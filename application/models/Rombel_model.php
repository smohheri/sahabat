<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rombel_model extends CI_Model
{
    public function is_table_ready()
    {
        $required_tables = array('rombel', 'rombel_anak', 'rombel_mata_pelajaran');
        foreach ($required_tables as $table) {
            if (!$this->db->table_exists($table)) {
                return false;
            }
        }

        return true;
    }

    public function get_all($filters = array())
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('r.*, COUNT(DISTINCT ra.id_anak) AS total_anak, COUNT(DISTINCT rm.id_mata_pelajaran) AS total_mapel', false);
        $this->db->from('rombel r');
        $this->db->join('rombel_anak ra', 'ra.id_rombel = r.id_rombel', 'left');
        $this->db->join('rombel_mata_pelajaran rm', 'rm.id_rombel = r.id_rombel', 'left');

        if (!empty($filters['tahun_ajaran'])) {
            $this->db->where('r.tahun_ajaran', trim((string) $filters['tahun_ajaran']));
        }

        if (isset($filters['semester']) && $filters['semester'] !== '' && $filters['semester'] !== null) {
            $this->db->where('r.semester', (int) $filters['semester']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '' && $filters['is_active'] !== null) {
            $this->db->where('r.is_active', (int) $filters['is_active']);
        }

        if (!empty($filters['keyword'])) {
            $keyword = trim((string) $filters['keyword']);
            $this->db->group_start();
            $this->db->like('r.nama_rombel', $keyword);
            $this->db->or_like('r.kode_rombel', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('r.id_rombel');
        $this->db->order_by('r.tahun_ajaran', 'DESC');
        $this->db->order_by('r.semester', 'DESC');
        $this->db->order_by('r.nama_rombel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_active_by_period($tahun_ajaran = null, $semester = null)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->where('is_active', 1);
        if (!empty($tahun_ajaran)) {
            $this->db->where('tahun_ajaran', trim((string) $tahun_ajaran));
        }
        if (!empty($semester)) {
            $this->db->where('semester', (int) $semester);
        }
        $this->db->order_by('nama_rombel', 'ASC');
        return $this->db->get('rombel')->result();
    }

    public function get_by_id($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return null;
        }

        return $this->db->get_where('rombel', array('id_rombel' => (int) $id_rombel))->row();
    }

    public function is_kode_exists($kode_rombel, $exclude_id = null)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('kode_rombel', trim((string) $kode_rombel));
        if (!empty($exclude_id)) {
            $this->db->where('id_rombel !=', (int) $exclude_id);
        }

        return $this->db->count_all_results('rombel') > 0;
    }

    public function is_name_period_exists($nama_rombel, $tahun_ajaran, $semester, $exclude_id = null)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('nama_rombel', trim((string) $nama_rombel));
        $this->db->where('tahun_ajaran', trim((string) $tahun_ajaran));
        $this->db->where('semester', (int) $semester);
        if (!empty($exclude_id)) {
            $this->db->where('id_rombel !=', (int) $exclude_id);
        }

        return $this->db->count_all_results('rombel') > 0;
    }

    public function insert($data)
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        $this->db->insert('rombel', $data);
        return (int) $this->db->insert_id();
    }

    public function update($id_rombel, $data)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('id_rombel', (int) $id_rombel);
        return $this->db->update('rombel', $data);
    }

    public function delete($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('id_rombel', (int) $id_rombel);
        return $this->db->delete('rombel');
    }

    public function get_rombel_anak_ids($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('id_anak');
        $this->db->from('rombel_anak');
        $this->db->where('id_rombel', (int) $id_rombel);
        $rows = $this->db->get()->result();
        return array_values(array_map(function ($row) {
            return (int) $row->id_anak;
        }, $rows));
    }

    public function get_rombel_mapel_ids($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('id_mata_pelajaran');
        $this->db->from('rombel_mata_pelajaran');
        $this->db->where('id_rombel', (int) $id_rombel);
        $rows = $this->db->get()->result();
        return array_values(array_map(function ($row) {
            return (int) $row->id_mata_pelajaran;
        }, $rows));
    }

    public function replace_rombel_anak($id_rombel, $anak_ids)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $anak_ids = array_values(array_unique(array_map('intval', (array) $anak_ids)));

        $this->db->where('id_rombel', (int) $id_rombel);
        $this->db->delete('rombel_anak');

        if (empty($anak_ids)) {
            return true;
        }

        $insert_rows = array();
        foreach ($anak_ids as $id_anak) {
            $insert_rows[] = array(
                'id_rombel' => (int) $id_rombel,
                'id_anak' => (int) $id_anak
            );
        }

        return $this->db->insert_batch('rombel_anak', $insert_rows) !== false;
    }

    public function replace_rombel_mapel($id_rombel, $mapel_ids)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $mapel_ids = array_values(array_unique(array_map('intval', (array) $mapel_ids)));

        $this->db->where('id_rombel', (int) $id_rombel);
        $this->db->delete('rombel_mata_pelajaran');

        if (empty($mapel_ids)) {
            return true;
        }

        $insert_rows = array();
        foreach ($mapel_ids as $id_mata_pelajaran) {
            $insert_rows[] = array(
                'id_rombel' => (int) $id_rombel,
                'id_mata_pelajaran' => (int) $id_mata_pelajaran
            );
        }

        return $this->db->insert_batch('rombel_mata_pelajaran', $insert_rows) !== false;
    }

    public function save_with_relations($id_rombel, $rombel_data, $anak_ids, $mapel_ids)
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        $this->db->trans_start();

        if ($id_rombel > 0) {
            $this->update($id_rombel, $rombel_data);
        } else {
            $id_rombel = $this->insert($rombel_data);
        }

        if ((int) $id_rombel <= 0) {
            $this->db->trans_complete();
            return 0;
        }

        $this->replace_rombel_anak($id_rombel, $anak_ids);
        $this->replace_rombel_mapel($id_rombel, $mapel_ids);

        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            return 0;
        }

        return (int) $id_rombel;
    }

    public function get_children($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('a.id_anak, a.nama_anak, a.status_anak, a.pendidikan');
        $this->db->from('rombel_anak ra');
        $this->db->join('anak a', 'a.id_anak = ra.id_anak', 'inner');
        $this->db->where('ra.id_rombel', (int) $id_rombel);
        $this->db->order_by('a.nama_anak', 'ASC');
        return $this->db->get()->result();
    }

    public function get_mapel($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('mp.id_mata_pelajaran, mp.kode_mapel, mp.nama_mapel, mp.is_active');
        $this->db->from('rombel_mata_pelajaran rm');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = rm.id_mata_pelajaran', 'inner');
        $this->db->where('rm.id_rombel', (int) $id_rombel);
        $this->db->order_by('mp.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_mapel_for_rombel_dropdown($id_rombel)
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('mp.id_mata_pelajaran, mp.kode_mapel, mp.nama_mapel');
        $this->db->from('rombel_mata_pelajaran rm');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = rm.id_mata_pelajaran', 'inner');
        $this->db->where('rm.id_rombel', (int) $id_rombel);
        $this->db->where('mp.is_active', 1);
        $this->db->order_by('mp.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    public function is_mapel_in_rombel($id_rombel, $id_mata_pelajaran)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('id_rombel', (int) $id_rombel);
        $this->db->where('id_mata_pelajaran', (int) $id_mata_pelajaran);
        return $this->db->count_all_results('rombel_mata_pelajaran') > 0;
    }

    public function count_all()
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        return (int) $this->db->count_all('rombel');
    }

    public function count_active()
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        $this->db->where('is_active', 1);
        return (int) $this->db->count_all_results('rombel');
    }

    public function get_export_rows()
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $sql = "
			SELECT
				r.id_rombel,
				r.kode_rombel,
				r.nama_rombel,
				r.tahun_ajaran,
				r.semester,
				r.is_active,
				(
					SELECT COUNT(*)
					FROM rombel_anak ra
					WHERE ra.id_rombel = r.id_rombel
				) AS total_anak,
				(
					SELECT COUNT(*)
					FROM rombel_mata_pelajaran rm
					WHERE rm.id_rombel = r.id_rombel
				) AS total_mapel,
				(
					SELECT GROUP_CONCAT(DISTINCT a.nama_anak ORDER BY a.nama_anak SEPARATOR ', ')
					FROM rombel_anak ra
					JOIN anak a ON a.id_anak = ra.id_anak
					WHERE ra.id_rombel = r.id_rombel
				) AS daftar_anak,
				(
					SELECT GROUP_CONCAT(DISTINCT mp.nama_mapel ORDER BY mp.nama_mapel SEPARATOR ', ')
					FROM rombel_mata_pelajaran rm
					JOIN mata_pelajaran mp ON mp.id_mata_pelajaran = rm.id_mata_pelajaran
					WHERE rm.id_rombel = r.id_rombel
				) AS daftar_mapel
			FROM rombel r
			ORDER BY r.tahun_ajaran DESC, r.semester DESC, r.nama_rombel ASC
		";

        return $this->db->query($sql)->result();
    }
}
