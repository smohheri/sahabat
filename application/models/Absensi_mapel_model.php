<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_mapel_model extends CI_Model
{
    public function is_table_ready()
    {
        $required_tables = array('absensi_mapel_sessions', 'absensi_mapel_details');
        foreach ($required_tables as $table) {
            if (!$this->db->table_exists($table)) {
                return false;
            }
        }

        return true;
    }

    public function get_session_by_id($id_session)
    {
        if (!$this->is_table_ready()) {
            return null;
        }

        return $this->db->get_where('absensi_mapel_sessions', array('id_session' => (int) $id_session))->row();
    }

    public function get_existing_session($id_rombel, $id_mata_pelajaran, $tahun_ajaran, $semester, $tanggal_absensi)
    {
        if (!$this->is_table_ready()) {
            return null;
        }

        $this->db->where('id_rombel', (int) $id_rombel);
        $this->db->where('id_mata_pelajaran', (int) $id_mata_pelajaran);
        $this->db->where('tahun_ajaran', trim((string) $tahun_ajaran));
        $this->db->where('semester', (int) $semester);
        $this->db->where('tanggal_absensi', $tanggal_absensi);
        return $this->db->get('absensi_mapel_sessions')->row();
    }

    private function normalize_status($status)
    {
        $allowed = array('Hadir', 'Izin', 'Sakit', 'Alpha');
        $status = ucfirst(strtolower(trim((string) $status)));
        if (!in_array($status, $allowed, true)) {
            return 'Hadir';
        }

        return $status;
    }

    public function save_session_with_details($session_data, $attendance_rows)
    {
        if (!$this->is_table_ready()) {
            return array('success' => false, 'message' => 'Tabel absensi mapel belum tersedia. Jalankan migrasi SQL terlebih dahulu.');
        }

        $id_rombel = (int) ($session_data['id_rombel'] ?? 0);
        $id_mata_pelajaran = (int) ($session_data['id_mata_pelajaran'] ?? 0);
        $tahun_ajaran = trim((string) ($session_data['tahun_ajaran'] ?? ''));
        $semester = (int) ($session_data['semester'] ?? 0);
        $tanggal_absensi = trim((string) ($session_data['tanggal_absensi'] ?? ''));

        if ($id_rombel <= 0 || $id_mata_pelajaran <= 0 || $tahun_ajaran === '' || $semester <= 0 || $tanggal_absensi === '') {
            return array('success' => false, 'message' => 'Data sesi absensi tidak lengkap.');
        }

        $existing = $this->get_existing_session($id_rombel, $id_mata_pelajaran, $tahun_ajaran, $semester, $tanggal_absensi);
        $id_session = $existing ? (int) $existing->id_session : 0;

        $this->db->trans_start();

        if ($id_session > 0) {
            $update_payload = array(
                'catatan' => $session_data['catatan'] ?? null,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_session', $id_session);
            $this->db->update('absensi_mapel_sessions', $update_payload);
        } else {
            $insert_payload = array(
                'id_rombel' => $id_rombel,
                'id_mata_pelajaran' => $id_mata_pelajaran,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester,
                'tanggal_absensi' => $tanggal_absensi,
                'catatan' => $session_data['catatan'] ?? null,
                'created_by' => !empty($session_data['created_by']) ? (int) $session_data['created_by'] : null
            );
            $this->db->insert('absensi_mapel_sessions', $insert_payload);
            $id_session = (int) $this->db->insert_id();
        }

        $submitted_anak_ids = array();
        foreach ((array) $attendance_rows as $row) {
            $id_anak = (int) ($row['id_anak'] ?? 0);
            if ($id_anak <= 0) {
                continue;
            }

            $submitted_anak_ids[] = $id_anak;
            $detail_payload = array(
                'status_kehadiran' => $this->normalize_status($row['status_kehadiran'] ?? 'Hadir'),
                'keterangan' => trim((string) ($row['keterangan'] ?? '')),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id_session', $id_session);
            $this->db->where('id_anak', $id_anak);
            $existing_detail = $this->db->get('absensi_mapel_details')->row();

            if ($existing_detail) {
                $this->db->where('id_detail', (int) $existing_detail->id_detail);
                $this->db->update('absensi_mapel_details', $detail_payload);
            } else {
                $detail_payload['id_session'] = $id_session;
                $detail_payload['id_anak'] = $id_anak;
                $this->db->insert('absensi_mapel_details', $detail_payload);
            }
        }

        $submitted_anak_ids = array_values(array_unique($submitted_anak_ids));
        if (!empty($submitted_anak_ids)) {
            $this->db->where('id_session', $id_session);
            $this->db->where_not_in('id_anak', $submitted_anak_ids);
            $this->db->delete('absensi_mapel_details');
        }

        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            return array('success' => false, 'message' => 'Gagal menyimpan absensi. Silakan coba lagi.');
        }

        return array('success' => true, 'id_session' => $id_session);
    }

    public function save_import_statuses($session_data, $status_by_anak)
    {
        if (!$this->is_table_ready()) {
            return array('success' => false, 'message' => 'Tabel absensi mapel belum tersedia. Jalankan migrasi SQL terlebih dahulu.');
        }

        $id_rombel = (int) ($session_data['id_rombel'] ?? 0);
        $id_mata_pelajaran = (int) ($session_data['id_mata_pelajaran'] ?? 0);
        $tahun_ajaran = trim((string) ($session_data['tahun_ajaran'] ?? ''));
        $semester = (int) ($session_data['semester'] ?? 0);
        $tanggal_absensi = trim((string) ($session_data['tanggal_absensi'] ?? ''));
        $catatan = trim((string) ($session_data['catatan'] ?? ''));

        if ($id_rombel <= 0 || $id_mata_pelajaran <= 0 || $tahun_ajaran === '' || $semester <= 0 || $tanggal_absensi === '') {
            return array('success' => false, 'message' => 'Data sesi absensi tidak lengkap.');
        }

        $status_by_anak = (array) $status_by_anak;
        if (empty($status_by_anak)) {
            return array('success' => true, 'id_session' => 0);
        }

        $existing = $this->get_existing_session($id_rombel, $id_mata_pelajaran, $tahun_ajaran, $semester, $tanggal_absensi);
        $id_session = $existing ? (int) $existing->id_session : 0;

        $this->db->trans_start();

        if ($id_session > 0) {
            $update_payload = array('updated_at' => date('Y-m-d H:i:s'));
            if ($catatan !== '') {
                $update_payload['catatan'] = $catatan;
            }
            $this->db->where('id_session', $id_session);
            $this->db->update('absensi_mapel_sessions', $update_payload);
        } else {
            $insert_payload = array(
                'id_rombel' => $id_rombel,
                'id_mata_pelajaran' => $id_mata_pelajaran,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester,
                'tanggal_absensi' => $tanggal_absensi,
                'catatan' => $catatan !== '' ? $catatan : null,
                'created_by' => !empty($session_data['created_by']) ? (int) $session_data['created_by'] : null
            );
            $this->db->insert('absensi_mapel_sessions', $insert_payload);
            $id_session = (int) $this->db->insert_id();
        }

        foreach ($status_by_anak as $id_anak => $status_value) {
            $id_anak = (int) $id_anak;
            if ($id_anak <= 0) {
                continue;
            }

            $detail_payload = array(
                'status_kehadiran' => $this->normalize_status($status_value),
                'keterangan' => '',
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id_session', $id_session);
            $this->db->where('id_anak', $id_anak);
            $existing_detail = $this->db->get('absensi_mapel_details')->row();

            if ($existing_detail) {
                $this->db->where('id_detail', (int) $existing_detail->id_detail);
                $this->db->update('absensi_mapel_details', $detail_payload);
            } else {
                $detail_payload['id_session'] = $id_session;
                $detail_payload['id_anak'] = $id_anak;
                $this->db->insert('absensi_mapel_details', $detail_payload);
            }
        }

        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            return array('success' => false, 'message' => 'Gagal mengimpor absensi dari file. Silakan coba lagi.');
        }

        return array('success' => true, 'id_session' => $id_session);
    }

    public function get_details_by_session($id_session)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('d.*, a.nama_anak, a.status_anak, a.pendidikan');
        $this->db->from('absensi_mapel_details d');
        $this->db->join('anak a', 'a.id_anak = d.id_anak', 'left');
        $this->db->where('d.id_session', (int) $id_session);
        $this->db->order_by('a.nama_anak', 'ASC');
        return $this->db->get()->result();
    }

    public function get_detail_map_by_session($id_session)
    {
        $rows = $this->get_details_by_session($id_session);
        $mapped = array();
        foreach ($rows as $row) {
            $mapped[(int) $row->id_anak] = $row;
        }

        return $mapped;
    }

    private function apply_recap_filters($filters = array())
    {
        if (array_key_exists('allowed_rombel_ids', $filters)) {
            $allowed_rombel_ids = array_values(array_filter(array_map('intval', (array) $filters['allowed_rombel_ids']), function ($id) {
                return $id > 0;
            }));

            if (empty($allowed_rombel_ids)) {
                $this->db->where('1 = 0', null, false);
            } else {
                $this->db->where_in('s.id_rombel', $allowed_rombel_ids);
            }
        }

        if (array_key_exists('allowed_mapel_ids', $filters)) {
            $allowed_mapel_ids = array_values(array_filter(array_map('intval', (array) $filters['allowed_mapel_ids']), function ($id) {
                return $id > 0;
            }));

            if (empty($allowed_mapel_ids)) {
                $this->db->where('1 = 0', null, false);
            } else {
                $this->db->where_in('s.id_mata_pelajaran', $allowed_mapel_ids);
            }
        }

        if (!empty($filters['tahun_ajaran'])) {
            $this->db->where('s.tahun_ajaran', trim((string) $filters['tahun_ajaran']));
        }
        if (!empty($filters['semester'])) {
            $this->db->where('s.semester', (int) $filters['semester']);
        }
        if (!empty($filters['id_rombel'])) {
            $this->db->where('s.id_rombel', (int) $filters['id_rombel']);
        }
        if (!empty($filters['id_mata_pelajaran'])) {
            $this->db->where('s.id_mata_pelajaran', (int) $filters['id_mata_pelajaran']);
        }
        if (!empty($filters['tanggal_mulai'])) {
            $this->db->where('s.tanggal_absensi >=', $filters['tanggal_mulai']);
        }
        if (!empty($filters['tanggal_selesai'])) {
            $this->db->where('s.tanggal_absensi <=', $filters['tanggal_selesai']);
        }
    }

    public function get_recap_sessions($filters = array(), $limit = 200)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select(
            's.id_session, s.tanggal_absensi, s.tahun_ajaran, s.semester, s.catatan, r.nama_rombel, r.kode_rombel, mp.nama_mapel, mp.kode_mapel, u.nama AS input_by, '
            . 'SUM(CASE WHEN d.status_kehadiran = "Hadir" THEN 1 ELSE 0 END) AS total_hadir, '
            . 'SUM(CASE WHEN d.status_kehadiran = "Izin" THEN 1 ELSE 0 END) AS total_izin, '
            . 'SUM(CASE WHEN d.status_kehadiran = "Sakit" THEN 1 ELSE 0 END) AS total_sakit, '
            . 'SUM(CASE WHEN d.status_kehadiran = "Alpha" THEN 1 ELSE 0 END) AS total_alpha, '
            . 'COUNT(d.id_detail) AS total_siswa',
            false
        );
        $this->db->from('absensi_mapel_sessions s');
        $this->db->join('rombel r', 'r.id_rombel = s.id_rombel', 'left');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = s.id_mata_pelajaran', 'left');
        $this->db->join('users u', 'u.id_user = s.created_by', 'left');
        $this->db->join('absensi_mapel_details d', 'd.id_session = s.id_session', 'left');

        $this->apply_recap_filters($filters);

        $this->db->group_by('s.id_session');
        $this->db->order_by('s.tanggal_absensi', 'DESC');
        $this->db->order_by('s.id_session', 'DESC');
        if ((int) $limit > 0) {
            $this->db->limit((int) $limit);
        }

        return $this->db->get()->result();
    }

    public function get_recap_details($filters = array())
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('s.id_session, s.tanggal_absensi, s.tahun_ajaran, s.semester, r.nama_rombel, r.kode_rombel, mp.nama_mapel, mp.kode_mapel, a.id_anak, a.nama_anak, d.status_kehadiran, d.keterangan');
        $this->db->from('absensi_mapel_sessions s');
        $this->db->join('rombel r', 'r.id_rombel = s.id_rombel', 'left');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = s.id_mata_pelajaran', 'left');
        $this->db->join('absensi_mapel_details d', 'd.id_session = s.id_session', 'inner');
        $this->db->join('anak a', 'a.id_anak = d.id_anak', 'left');

        $this->apply_recap_filters($filters);

        $this->db->order_by('s.tanggal_absensi', 'DESC');
        $this->db->order_by('r.nama_rombel', 'ASC');
        $this->db->order_by('mp.nama_mapel', 'ASC');
        $this->db->order_by('a.nama_anak', 'ASC');

        return $this->db->get()->result();
    }

    public function get_status_summary($filters = array())
    {
        $summary = array(
            'Hadir' => 0,
            'Izin' => 0,
            'Sakit' => 0,
            'Alpha' => 0,
            'total' => 0
        );

        if (!$this->is_table_ready()) {
            return $summary;
        }

        $this->db->select('d.status_kehadiran, COUNT(d.id_detail) AS total_status', false);
        $this->db->from('absensi_mapel_sessions s');
        $this->db->join('absensi_mapel_details d', 'd.id_session = s.id_session', 'inner');
        $this->apply_recap_filters($filters);
        $this->db->group_by('d.status_kehadiran');
        $rows = $this->db->get()->result();

        foreach ($rows as $row) {
            $status = (string) $row->status_kehadiran;
            $total_status = (int) $row->total_status;
            if (isset($summary[$status])) {
                $summary[$status] = $total_status;
                $summary['total'] += $total_status;
            }
        }

        return $summary;
    }
}
