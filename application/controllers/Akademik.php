<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akademik extends CI_Controller
{
    private $allowed_roles = array('admin', 'operator', 'pengajar', 'guru');

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth/login');
        }

        $role = $this->get_user_role();
        if (!in_array($role, $this->allowed_roles, true)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke modul akademik.');
            if ($role === 'anak') {
                redirect('anak');
            }
            redirect('admin');
        }

        $prefix = strtolower((string) $this->uri->segment(1));
        if ($this->is_teacher_role($role) && $prefix !== 'guru') {
            redirect('guru/akademik/absensi');
        }
        if (!$this->is_teacher_role($role) && $prefix === 'guru') {
            redirect('admin/akademik/mapel');
        }

        $this->load->model('Mata_pelajaran_model');
        $this->load->model('Rombel_model');
        $this->load->model('Absensi_mapel_model');
        $this->load->model('Anak_model');
        $this->load->model('User_model');
        $this->load->model('Guru_model');
        $this->load->helper('logging');
        $this->load->library('form_validation');
    }

    private function get_user_role()
    {
        $role = strtolower(trim((string) $this->session->userdata('role')));
        if ($role === 'guru') {
            return 'pengajar';
        }

        return $role;
    }

    private function is_teacher_role($role = null)
    {
        if ($role === null) {
            $role = $this->get_user_role();
        }

        return in_array($role, array('pengajar', 'guru'), true);
    }

    private function get_panel_prefix()
    {
        $prefix = strtolower((string) $this->uri->segment(1));
        if ($prefix === 'guru') {
            return 'guru';
        }

        return 'admin';
    }

    private function route_path($suffix = '')
    {
        $base = $this->get_panel_prefix() . '/akademik';
        if ($suffix === '') {
            return $base;
        }

        return $base . '/' . ltrim($suffix, '/');
    }

    private function get_sidebar_view()
    {
        return $this->is_teacher_role() ? 'templates/sidebar_guru' : 'templates/sidebar_lksa';
    }

    private function get_default_tahun_ajaran()
    {
        $year = (int) date('Y');
        return $year . '/' . ($year + 1);
    }

    private function normalize_tahun_ajaran($tahun_ajaran)
    {
        $tahun_ajaran = trim((string) $tahun_ajaran);
        if (preg_match('/^[0-9]{4}\/[0-9]{4}$/', $tahun_ajaran) !== 1) {
            return $this->get_default_tahun_ajaran();
        }

        return $tahun_ajaran;
    }

    private function get_tahun_ajaran_options()
    {
        $options = array($this->get_default_tahun_ajaran());
        if ($this->Rombel_model->is_table_ready()) {
            $this->db->distinct();
            $this->db->select('tahun_ajaran');
            $this->db->from('rombel');
            $this->db->order_by('tahun_ajaran', 'DESC');
            $rows = $this->db->get()->result();
            foreach ($rows as $row) {
                $value = trim((string) ($row->tahun_ajaran ?? ''));
                if ($value !== '' && !in_array($value, $options, true)) {
                    $options[] = $value;
                }
            }
        }

        usort($options, function ($a, $b) {
            return strcmp($b, $a);
        });

        return $options;
    }

    private function get_pengajar_options()
    {
        $this->db->select('id_user, nama, username, role');
        $this->db->from('users');
        $this->db->where_in('role', array('guru', 'pengajar'));
        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result();
    }

    private function get_current_user_id()
    {
        return (int) $this->session->userdata('id_user');
    }

    private function get_teacher_scope_ids($tahun_ajaran = null, $semester = null)
    {
        $scope = array(
            'rombel_ids' => array(),
            'mapel_ids' => array()
        );

        if (!$this->is_teacher_role()) {
            return $scope;
        }

        $id_user = $this->get_current_user_id();
        if (
            $id_user <= 0
            || !$this->Rombel_model->is_table_ready()
            || !$this->Mata_pelajaran_model->is_table_ready()
        ) {
            return $scope;
        }

        $this->db->distinct();
        $this->db->select('r.id_rombel, mp.id_mata_pelajaran');
        $this->db->from('rombel r');
        $this->db->join('rombel_mata_pelajaran rm', 'rm.id_rombel = r.id_rombel', 'inner');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = rm.id_mata_pelajaran', 'inner');
        $this->db->where('r.is_active', 1);
        $this->db->where('mp.is_active', 1);
        $this->db->where('mp.id_user_pengampu', $id_user);

        if (!empty($tahun_ajaran)) {
            $this->db->where('r.tahun_ajaran', trim((string) $tahun_ajaran));
        }

        if (!empty($semester) && ((int) $semester === 1 || (int) $semester === 2)) {
            $this->db->where('r.semester', (int) $semester);
        }

        $rows = $this->db->get()->result();
        foreach ($rows as $row) {
            $id_rombel = (int) ($row->id_rombel ?? 0);
            $id_mapel = (int) ($row->id_mata_pelajaran ?? 0);

            if ($id_rombel > 0) {
                $scope['rombel_ids'][] = $id_rombel;
            }

            if ($id_mapel > 0) {
                $scope['mapel_ids'][] = $id_mapel;
            }
        }

        $scope['rombel_ids'] = array_values(array_unique($scope['rombel_ids']));
        $scope['mapel_ids'] = array_values(array_unique($scope['mapel_ids']));

        return $scope;
    }

    private function get_teacher_rombel_options($tahun_ajaran = null, $semester = null)
    {
        if (!$this->is_teacher_role()) {
            return $this->Rombel_model->get_active_by_period($tahun_ajaran, $semester);
        }

        $scope = $this->get_teacher_scope_ids($tahun_ajaran, $semester);
        if (empty($scope['rombel_ids'])) {
            return array();
        }

        $this->db->where_in('id_rombel', $scope['rombel_ids']);
        $this->db->order_by('nama_rombel', 'ASC');
        return $this->db->get('rombel')->result();
    }

    private function get_teacher_mapel_for_rombel_dropdown($id_rombel)
    {
        $id_rombel = (int) $id_rombel;
        if ($id_rombel <= 0) {
            return array();
        }

        if (!$this->is_teacher_role()) {
            return $this->Rombel_model->get_mapel_for_rombel_dropdown($id_rombel);
        }

        $id_user = $this->get_current_user_id();
        if ($id_user <= 0 || !$this->Mata_pelajaran_model->is_table_ready()) {
            return array();
        }

        $this->db->select('mp.id_mata_pelajaran, mp.kode_mapel, mp.nama_mapel');
        $this->db->from('rombel_mata_pelajaran rm');
        $this->db->join('rombel r', 'r.id_rombel = rm.id_rombel', 'inner');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = rm.id_mata_pelajaran', 'inner');
        $this->db->where('rm.id_rombel', $id_rombel);
        $this->db->where('r.is_active', 1);
        $this->db->where('mp.is_active', 1);
        $this->db->where('mp.id_user_pengampu', $id_user);
        $this->db->order_by('mp.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    private function is_teacher_mapel_scope_valid($id_rombel, $id_mata_pelajaran, $tahun_ajaran = null, $semester = null)
    {
        if (!$this->is_teacher_role()) {
            return true;
        }

        $id_user = $this->get_current_user_id();
        $id_rombel = (int) $id_rombel;
        $id_mata_pelajaran = (int) $id_mata_pelajaran;
        if ($id_user <= 0 || $id_rombel <= 0 || $id_mata_pelajaran <= 0) {
            return false;
        }

        $this->db->from('rombel_mata_pelajaran rm');
        $this->db->join('rombel r', 'r.id_rombel = rm.id_rombel', 'inner');
        $this->db->join('mata_pelajaran mp', 'mp.id_mata_pelajaran = rm.id_mata_pelajaran', 'inner');
        $this->db->where('rm.id_rombel', $id_rombel);
        $this->db->where('rm.id_mata_pelajaran', $id_mata_pelajaran);
        $this->db->where('r.is_active', 1);
        $this->db->where('mp.is_active', 1);
        $this->db->where('mp.id_user_pengampu', $id_user);

        if (!empty($tahun_ajaran)) {
            $this->db->where('r.tahun_ajaran', trim((string) $tahun_ajaran));
        }

        if (!empty($semester) && ((int) $semester === 1 || (int) $semester === 2)) {
            $this->db->where('r.semester', (int) $semester);
        }

        return $this->db->count_all_results() > 0;
    }

    private function get_active_anak_rows()
    {
        $all_anak = $this->Anak_model->get_all_anak('nama_anak', 'ASC');
        $filtered = array();
        foreach ($all_anak as $anak) {
            $status = strtolower(trim((string) ($anak->status_anak ?? '')));
            if ($status === 'aktif') {
                $filtered[] = $anak;
            }
        }

        return $filtered;
    }

    private function extract_id_list($items)
    {
        $ids = array_values(array_unique(array_map('intval', (array) $items)));
        return array_values(array_filter($ids, function ($value) {
            return $value > 0;
        }));
    }

    private function normalize_name_key($name)
    {
        $name = strtolower(trim((string) $name));
        $name = preg_replace('/\s+/', ' ', $name);
        return $name;
    }

    private function map_import_status_code($raw_status)
    {
        $raw_status = strtoupper(trim((string) $raw_status));
        if ($raw_status === '' || $raw_status === '-') {
            return '';
        }

        $status_map = array(
            'H' => 'Hadir',
            'HADIR' => 'Hadir',
            'I' => 'Izin',
            'IZIN' => 'Izin',
            'S' => 'Sakit',
            'SAKIT' => 'Sakit',
            'A' => 'Alpha',
            'ALPHA' => 'Alpha'
        );

        return $status_map[$raw_status] ?? null;
    }

    private function build_change_description($old_record, $new_payload, $labels = array())
    {
        $changes = array();
        foreach ($new_payload as $key => $new_value) {
            $old_value = isset($old_record->$key) ? (string) $old_record->$key : '';
            $new_value_string = (string) $new_value;
            if ($old_value !== $new_value_string) {
                $label = $labels[$key] ?? $key;
                $changes[] = $label . " dari '" . $old_value . "' ke '" . $new_value_string . "'";
            }
        }

        return implode(', ', $changes);
    }

    public function index()
    {
        redirect($this->is_teacher_role() ? $this->route_path('absensi') : $this->route_path('mapel'));
    }

    public function mapel()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Mata_pelajaran_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel mata pelajaran belum tersedia. Jalankan file database/create_academic_management_tables.sql terlebih dahulu.');
        }

        $redirect_path = $this->route_path('mapel');

        if ($this->input->get('delete')) {
            $id_mata_pelajaran = (int) $this->input->get('delete');
            $existing = $this->Mata_pelajaran_model->get_by_id($id_mata_pelajaran);

            if (!$existing) {
                $this->session->set_flashdata('error', 'Data mata pelajaran tidak ditemukan.');
                redirect($redirect_path);
            }

            $this->Mata_pelajaran_model->delete($id_mata_pelajaran);
            log_activity('delete_mata_pelajaran', 'Menghapus mata pelajaran: ' . $existing->nama_mapel . ' (' . $existing->kode_mapel . ')');
            $this->session->set_flashdata('success', 'Mata pelajaran berhasil dihapus.');
            redirect($redirect_path);
        }

        if ($this->input->post('form_type') === 'save_mapel') {
            $id_mata_pelajaran = (int) $this->input->post('id_mata_pelajaran');
            $kode_mapel = strtoupper(trim((string) $this->input->post('kode_mapel')));
            $nama_mapel = trim((string) $this->input->post('nama_mapel'));
            $id_user_pengampu = (int) $this->input->post('id_user_pengampu');
            $is_active = (int) $this->input->post('is_active');

            $this->form_validation->set_rules('kode_mapel', 'Kode Mapel', 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z0-9_\-]+$/]');
            $this->form_validation->set_rules('nama_mapel', 'Nama Mapel', 'required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|in_list[0,1]');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect($redirect_path);
            }

            if ($this->Mata_pelajaran_model->is_kode_exists($kode_mapel, $id_mata_pelajaran ?: null)) {
                $this->session->set_flashdata('error', 'Kode mata pelajaran sudah digunakan.');
                redirect($redirect_path);
            }

            if ($id_user_pengampu > 0) {
                $teacher = $this->db->get_where('users', array('id_user' => $id_user_pengampu))->row();
                if (!$teacher || !in_array(strtolower((string) $teacher->role), array('guru', 'pengajar'), true)) {
                    $this->session->set_flashdata('error', 'Guru pengampu tidak valid.');
                    redirect($redirect_path);
                }
            }

            $payload = array(
                'kode_mapel' => $kode_mapel,
                'nama_mapel' => $nama_mapel,
                'id_user_pengampu' => $id_user_pengampu > 0 ? $id_user_pengampu : null,
                'is_active' => $is_active
            );

            if ($id_mata_pelajaran > 0) {
                $old = $this->Mata_pelajaran_model->get_by_id($id_mata_pelajaran);
                if (!$old) {
                    $this->session->set_flashdata('error', 'Data mata pelajaran tidak ditemukan.');
                    redirect($redirect_path);
                }

                $this->Mata_pelajaran_model->update($id_mata_pelajaran, $payload);
                $changes = $this->build_change_description($old, $payload, array(
                    'kode_mapel' => 'Kode Mapel',
                    'nama_mapel' => 'Nama Mapel',
                    'id_user_pengampu' => 'Guru Pengampu',
                    'is_active' => 'Status Aktif'
                ));
                log_activity('edit_mata_pelajaran', 'Mengubah mata pelajaran: ' . $old->nama_mapel . ($changes !== '' ? ' (' . $changes . ')' : ''));
                $this->session->set_flashdata('success', 'Mata pelajaran berhasil diperbarui.');
            } else {
                $this->Mata_pelajaran_model->insert($payload);
                log_activity('add_mata_pelajaran', 'Menambah mata pelajaran: ' . $nama_mapel . ' (' . $kode_mapel . ')');
                $this->session->set_flashdata('success', 'Mata pelajaran berhasil ditambahkan.');
            }

            redirect($redirect_path);
        }

        $mapel_rows = $this->Mata_pelajaran_model->get_all();
        $total_mapel = count($mapel_rows);
        $total_aktif = count(array_filter($mapel_rows, function ($row) {
            return (int) $row->is_active === 1;
        }));
        $total_dengan_pengampu = count(array_filter($mapel_rows, function ($row) {
            return !empty($row->id_user_pengampu);
        }));

        $view_data = array(
            'mapel_rows' => $mapel_rows,
            'pengajar_options' => $this->get_pengajar_options(),
            'total_mapel' => $total_mapel,
            'total_aktif' => $total_aktif,
            'total_dengan_pengampu' => $total_dengan_pengampu,
            'base_path' => $this->route_path(),
            'export_pdf_url' => site_url($this->route_path('export/mapel/pdf')),
            'export_excel_url' => site_url($this->route_path('export/mapel/excel'))
        );

        $data = array(
            'title' => 'Manajemen Mata Pelajaran - LKSA Harapan Bangsa',
            'page_title' => 'Mata Pelajaran',
            'sidebar_view' => $this->get_sidebar_view(),
            'content' => $this->load->view('akademik/mapel', $view_data, true)
        );

        $this->load->view('templates/admin_layout', $data);
    }

    public function rombel()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Rombel_model->is_table_ready() || !$this->Mata_pelajaran_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel rombel atau mata pelajaran belum tersedia. Jalankan file database/create_academic_management_tables.sql terlebih dahulu.');
        }

        $redirect_path = $this->route_path('rombel');

        if ($this->input->get('delete')) {
            $id_rombel = (int) $this->input->get('delete');
            $existing = $this->Rombel_model->get_by_id($id_rombel);
            if (!$existing) {
                $this->session->set_flashdata('error', 'Data rombel tidak ditemukan.');
                redirect($redirect_path);
            }

            $this->Rombel_model->delete($id_rombel);
            log_activity('delete_rombel', 'Menghapus rombel: ' . $existing->nama_rombel . ' (' . $existing->tahun_ajaran . ' semester ' . $existing->semester . ')');
            $this->session->set_flashdata('success', 'Rombel berhasil dihapus.');
            redirect($redirect_path);
        }

        if ($this->input->post('form_type') === 'save_rombel') {
            $id_rombel = (int) $this->input->post('id_rombel');
            $kode_rombel = strtoupper(trim((string) $this->input->post('kode_rombel')));
            $nama_rombel = trim((string) $this->input->post('nama_rombel'));
            $tahun_ajaran = $this->normalize_tahun_ajaran($this->input->post('tahun_ajaran'));
            $semester = (int) $this->input->post('semester');
            $is_active = (int) $this->input->post('is_active');
            $keterangan = trim((string) $this->input->post('keterangan'));
            $anak_ids = $this->extract_id_list($this->input->post('anak_ids'));
            $mapel_ids = $this->extract_id_list($this->input->post('mapel_ids'));

            $this->form_validation->set_rules('kode_rombel', 'Kode Rombel', 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z0-9_\-]+$/]');
            $this->form_validation->set_rules('nama_rombel', 'Nama Rombel', 'required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|regex_match[/^[0-9]{4}\/[0-9]{4}$/]');
            $this->form_validation->set_rules('semester', 'Semester', 'required|in_list[1,2]');
            $this->form_validation->set_rules('is_active', 'Status Aktif', 'required|in_list[0,1]');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect($redirect_path);
            }

            if (empty($anak_ids)) {
                $this->session->set_flashdata('error', 'Pilih minimal satu anak aktif untuk rombel.');
                redirect($redirect_path);
            }
            if (empty($mapel_ids)) {
                $this->session->set_flashdata('error', 'Pilih minimal satu mata pelajaran untuk rombel.');
                redirect($redirect_path);
            }

            $active_anak_rows = $this->get_active_anak_rows();
            $active_anak_ids = array_map(function ($row) {
                return (int) $row->id_anak;
            }, $active_anak_rows);
            $anak_ids = array_values(array_intersect($anak_ids, $active_anak_ids));
            if (empty($anak_ids)) {
                $this->session->set_flashdata('error', 'Pilihan anak tidak valid atau bukan anak aktif.');
                redirect($redirect_path);
            }

            $active_mapel_rows = $this->Mata_pelajaran_model->get_active_mapel();
            $active_mapel_ids = array_map(function ($row) {
                return (int) $row->id_mata_pelajaran;
            }, $active_mapel_rows);
            $mapel_ids = array_values(array_intersect($mapel_ids, $active_mapel_ids));
            if (empty($mapel_ids)) {
                $this->session->set_flashdata('error', 'Pilihan mata pelajaran tidak valid atau tidak aktif.');
                redirect($redirect_path);
            }

            if ($this->Rombel_model->is_kode_exists($kode_rombel, $id_rombel ?: null)) {
                $this->session->set_flashdata('error', 'Kode rombel sudah digunakan.');
                redirect($redirect_path);
            }

            if ($this->Rombel_model->is_name_period_exists($nama_rombel, $tahun_ajaran, $semester, $id_rombel ?: null)) {
                $this->session->set_flashdata('error', 'Nama rombel untuk periode tersebut sudah tersedia.');
                redirect($redirect_path);
            }

            $payload = array(
                'kode_rombel' => $kode_rombel,
                'nama_rombel' => $nama_rombel,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester,
                'is_active' => $is_active,
                'keterangan' => $keterangan
            );

            $old = $id_rombel > 0 ? $this->Rombel_model->get_by_id($id_rombel) : null;
            $saved_id = $this->Rombel_model->save_with_relations($id_rombel, $payload, $anak_ids, $mapel_ids);
            if ($saved_id <= 0) {
                $this->session->set_flashdata('error', 'Gagal menyimpan data rombel.');
                redirect($redirect_path);
            }

            if ($id_rombel > 0 && $old) {
                log_activity('edit_rombel', 'Mengubah rombel: ' . $old->nama_rombel . ' (' . $old->tahun_ajaran . ' semester ' . $old->semester . ')');
                $this->session->set_flashdata('success', 'Rombel berhasil diperbarui.');
            } else {
                log_activity('add_rombel', 'Menambahkan rombel: ' . $nama_rombel . ' (' . $tahun_ajaran . ' semester ' . $semester . ')');
                $this->session->set_flashdata('success', 'Rombel berhasil ditambahkan.');
            }

            redirect($redirect_path);
        }

        $rombel_rows = $this->Rombel_model->get_all();
        $selected_anak_map = array();
        $selected_mapel_map = array();
        $rombel_children_map = array();
        foreach ($rombel_rows as $row) {
            $selected_anak_map[(int) $row->id_rombel] = $this->Rombel_model->get_rombel_anak_ids((int) $row->id_rombel);
            $selected_mapel_map[(int) $row->id_rombel] = $this->Rombel_model->get_rombel_mapel_ids((int) $row->id_rombel);
            $rombel_children_map[(int) $row->id_rombel] = $this->Rombel_model->get_children((int) $row->id_rombel);
        }

        $view_data = array(
            'rombel_rows' => $rombel_rows,
            'active_anak_rows' => $this->get_active_anak_rows(),
            'active_mapel_rows' => $this->Mata_pelajaran_model->get_active_mapel(),
            'selected_anak_map' => $selected_anak_map,
            'selected_mapel_map' => $selected_mapel_map,
            'rombel_children_map' => $rombel_children_map,
            'tahun_ajaran_options' => $this->get_tahun_ajaran_options(),
            'total_rombel' => count($rombel_rows),
            'total_rombel_aktif' => count(array_filter($rombel_rows, function ($row) {
                return (int) $row->is_active === 1;
            })),
            'base_path' => $this->route_path(),
            'export_pdf_url' => site_url($this->route_path('export/rombel/pdf')),
            'export_excel_url' => site_url($this->route_path('export/rombel/excel'))
        );

        $data = array(
            'title' => 'Manajemen Rombel - LKSA Harapan Bangsa',
            'page_title' => 'Rombel',
            'sidebar_view' => $this->get_sidebar_view(),
            'content' => $this->load->view('akademik/rombel', $view_data, true)
        );

        $this->load->view('templates/admin_layout', $data);
    }

    public function absensi()
    {
        if (!$this->Absensi_mapel_model->is_table_ready() || !$this->Rombel_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel absensi/rombel belum tersedia. Jalankan file database/create_academic_management_tables.sql terlebih dahulu.');
        }

        $redirect_path = $this->route_path('absensi');

        $selected_tahun_ajaran = $this->normalize_tahun_ajaran($this->input->get('tahun_ajaran', true) ?: $this->get_default_tahun_ajaran());
        $selected_semester = (int) ($this->input->get('semester', true) ?: 1);
        $selected_rombel = (int) ($this->input->get('id_rombel', true) ?: 0);
        $selected_mapel = (int) ($this->input->get('id_mata_pelajaran', true) ?: 0);
        $selected_tanggal = $this->input->get('tanggal_absensi', true) ?: date('Y-m-d');
        $tanggal_mulai = $this->input->get('tanggal_mulai', true) ?: '';
        $tanggal_selesai = $this->input->get('tanggal_selesai', true) ?: '';

        if ($selected_semester !== 1 && $selected_semester !== 2) {
            $selected_semester = 1;
        }

        $is_teacher_panel = $this->is_teacher_role();

        if ($this->input->post('form_type') === 'import_absensi') {
            $selected_tahun_ajaran = $this->normalize_tahun_ajaran($this->input->post('tahun_ajaran'));
            $selected_semester = (int) $this->input->post('semester');
            $selected_rombel = (int) $this->input->post('id_rombel');
            $selected_mapel = (int) $this->input->post('id_mata_pelajaran');
            $import_month = (int) $this->input->post('import_month');
            $import_year = (int) $this->input->post('import_year');

            $selected_tanggal = sprintf('%04d-%02d-01', max(2000, $import_year), max(1, min(12, $import_month)));
            $redirect_query = array(
                'tahun_ajaran' => $selected_tahun_ajaran,
                'semester' => $selected_semester,
                'id_rombel' => $selected_rombel,
                'id_mata_pelajaran' => $selected_mapel,
                'tanggal_absensi' => $selected_tanggal
            );

            $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|regex_match[/^[0-9]{4}\/[0-9]{4}$/]');
            $this->form_validation->set_rules('semester', 'Semester', 'required|in_list[1,2]');
            $this->form_validation->set_rules('id_rombel', 'Rombel', 'required|integer');
            $this->form_validation->set_rules('id_mata_pelajaran', 'Mata Pelajaran', 'required|integer');
            $this->form_validation->set_rules('import_month', 'Bulan Import', 'required|integer');
            $this->form_validation->set_rules('import_year', 'Tahun Import', 'required|integer');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if ($import_month < 1 || $import_month > 12 || $import_year < 2000 || $import_year > 3000) {
                $this->session->set_flashdata('error', 'Periode import tidak valid.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (!$this->is_teacher_mapel_scope_valid($selected_rombel, $selected_mapel, $selected_tahun_ajaran, $selected_semester)) {
                $this->session->set_flashdata('error', 'Anda hanya dapat menginput absensi untuk mapel yang sudah disetting admin kepada Anda.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (!$this->Rombel_model->is_mapel_in_rombel($selected_rombel, $selected_mapel)) {
                $this->session->set_flashdata('error', 'Mata pelajaran tidak terdaftar pada rombel yang dipilih.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            $children = $this->Rombel_model->get_children($selected_rombel);
            $active_children = array_values(array_filter($children, function ($child) {
                return strtolower(trim((string) ($child->status_anak ?? ''))) === 'aktif';
            }));

            if (empty($active_children)) {
                $this->session->set_flashdata('error', 'Rombel tidak memiliki anak aktif untuk proses import absensi.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (!isset($_FILES['file_absensi_import']) || !is_array($_FILES['file_absensi_import'])) {
                $this->session->set_flashdata('error', 'File import absensi tidak ditemukan.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            $upload_error = (int) ($_FILES['file_absensi_import']['error'] ?? UPLOAD_ERR_NO_FILE);
            if ($upload_error !== UPLOAD_ERR_OK) {
                $this->session->set_flashdata('error', 'Gagal upload file import absensi. Pastikan file telah dipilih.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            $tmp_file = (string) ($_FILES['file_absensi_import']['tmp_name'] ?? '');
            $original_name = (string) ($_FILES['file_absensi_import']['name'] ?? '');
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            if (!in_array($extension, array('xlsx', 'xls'), true)) {
                $this->session->set_flashdata('error', 'Format file tidak didukung. Gunakan file Excel (.xlsx atau .xls).');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            try {
                if (!class_exists('\\PhpOffice\\PhpSpreadsheet\\IOFactory')) {
                    require_once FCPATH . 'vendor/autoload.php';
                }

                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmp_file);
                $sheet = $spreadsheet->getActiveSheet();
            } catch (\Throwable $e) {
                $this->session->set_flashdata('error', 'File import tidak dapat dibaca. Pastikan format template sesuai.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            $children_name_map = array();
            foreach ($active_children as $child) {
                $name_key = $this->normalize_name_key($child->nama_anak ?? '');
                if ($name_key === '') {
                    continue;
                }

                if (!isset($children_name_map[$name_key])) {
                    $children_name_map[$name_key] = array();
                }
                $children_name_map[$name_key][] = (int) $child->id_anak;
            }

            $highest_row = max(7, (int) $sheet->getHighestDataRow('B'));
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $import_month, $import_year);
            $status_matrix = array();
            $unknown_names = array();
            $duplicate_names = array();
            $invalid_cells = array();

            for ($row = 7; $row <= $highest_row; $row++) {
                $nama_col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2);
                $nama_anak = trim((string) $sheet->getCell($nama_col . $row)->getCalculatedValue());
                if ($nama_anak === '') {
                    continue;
                }

                $name_key = $this->normalize_name_key($nama_anak);
                if (!isset($children_name_map[$name_key])) {
                    if (!in_array($nama_anak, $unknown_names, true)) {
                        $unknown_names[] = $nama_anak;
                    }
                    continue;
                }

                if (count($children_name_map[$name_key]) > 1) {
                    if (!in_array($nama_anak, $duplicate_names, true)) {
                        $duplicate_names[] = $nama_anak;
                    }
                    continue;
                }

                $id_anak = (int) $children_name_map[$name_key][0];
                for ($day = 1; $day <= 31; $day++) {
                    if ($day > $days_in_month) {
                        continue;
                    }

                    $status_col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($day + 2);
                    $raw_status = $sheet->getCell($status_col . $row)->getCalculatedValue();
                    $mapped_status = $this->map_import_status_code($raw_status);
                    if ($mapped_status === '') {
                        continue;
                    }

                    if ($mapped_status === null) {
                        if (count($invalid_cells) < 10) {
                            $invalid_cells[] = 'Baris ' . $row . ', tanggal ' . $day . ': ' . trim((string) $raw_status);
                        }
                        continue;
                    }

                    $tanggal_absensi = sprintf('%04d-%02d-%02d', $import_year, $import_month, $day);
                    if (!isset($status_matrix[$tanggal_absensi])) {
                        $status_matrix[$tanggal_absensi] = array();
                    }
                    $status_matrix[$tanggal_absensi][$id_anak] = $mapped_status;
                }
            }

            if (!empty($duplicate_names)) {
                $this->session->set_flashdata('error', 'Gagal import: terdapat nama ganda pada data anak aktif (' . implode(', ', array_slice($duplicate_names, 0, 5)) . ').');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (!empty($unknown_names)) {
                $this->session->set_flashdata('error', 'Gagal import: beberapa nama pada file tidak ditemukan di rombel ini (' . implode(', ', array_slice($unknown_names, 0, 5)) . ').');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (!empty($invalid_cells)) {
                $this->session->set_flashdata('error', 'Gagal import: kode status tidak valid. Contoh: ' . implode(' | ', $invalid_cells));
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            if (empty($status_matrix)) {
                $this->session->set_flashdata('error', 'Tidak ada data status yang dapat diimpor dari file. Pastikan kode H/I/S/A telah diisi.');
                redirect($redirect_path . '?' . http_build_query($redirect_query));
            }

            ksort($status_matrix);
            $imported_dates = 0;
            $imported_entries = 0;
            $first_imported_tanggal = sprintf('%04d-%02d-01', $import_year, $import_month);
            $catatan_import = 'Import format absensi bulanan ' . sprintf('%02d/%04d', $import_month, $import_year);

            foreach ($status_matrix as $tanggal_absensi => $status_by_anak) {
                if ($imported_dates === 0) {
                    $first_imported_tanggal = $tanggal_absensi;
                }

                $save_result = $this->Absensi_mapel_model->save_import_statuses(array(
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'tanggal_absensi' => $tanggal_absensi,
                    'catatan' => $catatan_import,
                    'created_by' => (int) $this->session->userdata('id_user')
                ), $status_by_anak);

                if (!$save_result['success']) {
                    $this->session->set_flashdata('error', 'Gagal import pada tanggal ' . $tanggal_absensi . ': ' . $save_result['message']);
                    redirect($redirect_path . '?' . http_build_query($redirect_query));
                }

                $imported_dates++;
                $imported_entries += count($status_by_anak);
            }

            log_activity(
                'import_absensi_mapel',
                'Mengimpor absensi mapel dari format bulanan (rombel: ' . $selected_rombel . ', mapel: ' . $selected_mapel . ', periode: ' . sprintf('%02d/%04d', $import_month, $import_year) . ', tanggal: ' . $imported_dates . ')'
            );

            $this->session->set_flashdata('success', 'Import absensi berhasil. ' . $imported_dates . ' tanggal diproses dengan ' . $imported_entries . ' entri status.');
            redirect($redirect_path . '?' . http_build_query(array(
                'tahun_ajaran' => $selected_tahun_ajaran,
                'semester' => $selected_semester,
                'id_rombel' => $selected_rombel,
                'id_mata_pelajaran' => $selected_mapel,
                'tanggal_absensi' => $first_imported_tanggal
            )));
        }

        if ($this->input->post('form_type') === 'save_absensi') {
            $selected_tahun_ajaran = $this->normalize_tahun_ajaran($this->input->post('tahun_ajaran'));
            $selected_semester = (int) $this->input->post('semester');
            $selected_rombel = (int) $this->input->post('id_rombel');
            $selected_mapel = (int) $this->input->post('id_mata_pelajaran');
            $selected_tanggal = (string) $this->input->post('tanggal_absensi');
            $catatan = trim((string) $this->input->post('catatan'));

            $this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|regex_match[/^[0-9]{4}\/[0-9]{4}$/]');
            $this->form_validation->set_rules('semester', 'Semester', 'required|in_list[1,2]');
            $this->form_validation->set_rules('id_rombel', 'Rombel', 'required|integer');
            $this->form_validation->set_rules('id_mata_pelajaran', 'Mata Pelajaran', 'required|integer');
            $this->form_validation->set_rules('tanggal_absensi', 'Tanggal Absensi', 'required');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect($redirect_path . '?' . http_build_query(array(
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tanggal_absensi' => $selected_tanggal
                )));
            }

            if (!$this->is_teacher_mapel_scope_valid($selected_rombel, $selected_mapel, $selected_tahun_ajaran, $selected_semester)) {
                $this->session->set_flashdata('error', 'Anda hanya dapat menginput absensi untuk mapel yang sudah disetting admin kepada Anda.');
                redirect($redirect_path . '?' . http_build_query(array(
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tanggal_absensi' => $selected_tanggal
                )));
            }

            if (!$this->Rombel_model->is_mapel_in_rombel($selected_rombel, $selected_mapel)) {
                $this->session->set_flashdata('error', 'Mata pelajaran tidak terdaftar pada rombel yang dipilih.');
                redirect($redirect_path . '?' . http_build_query(array(
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tanggal_absensi' => $selected_tanggal
                )));
            }

            $children = $this->Rombel_model->get_children($selected_rombel);
            $active_children = array_values(array_filter($children, function ($child) {
                return strtolower(trim((string) ($child->status_anak ?? ''))) === 'aktif';
            }));

            if (empty($active_children)) {
                $this->session->set_flashdata('error', 'Rombel tidak memiliki anak aktif untuk diabsen.');
                redirect($redirect_path . '?' . http_build_query(array(
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tanggal_absensi' => $selected_tanggal
                )));
            }

            $existing_session = $this->Absensi_mapel_model->get_existing_session($selected_rombel, $selected_mapel, $selected_tahun_ajaran, $selected_semester, $selected_tanggal);
            $status_inputs = (array) $this->input->post('status_kehadiran');
            $keterangan_inputs = (array) $this->input->post('keterangan');

            $attendance_rows = array();
            foreach ($active_children as $child) {
                $id_anak = (int) $child->id_anak;
                $attendance_rows[] = array(
                    'id_anak' => $id_anak,
                    'status_kehadiran' => $status_inputs[$id_anak] ?? 'Hadir',
                    'keterangan' => $keterangan_inputs[$id_anak] ?? ''
                );
            }

            $save_result = $this->Absensi_mapel_model->save_session_with_details(array(
                'id_rombel' => $selected_rombel,
                'id_mata_pelajaran' => $selected_mapel,
                'tahun_ajaran' => $selected_tahun_ajaran,
                'semester' => $selected_semester,
                'tanggal_absensi' => $selected_tanggal,
                'catatan' => $catatan,
                'created_by' => (int) $this->session->userdata('id_user')
            ), $attendance_rows);

            if (!$save_result['success']) {
                $this->session->set_flashdata('error', $save_result['message']);
                redirect($redirect_path . '?' . http_build_query(array(
                    'tahun_ajaran' => $selected_tahun_ajaran,
                    'semester' => $selected_semester,
                    'id_rombel' => $selected_rombel,
                    'id_mata_pelajaran' => $selected_mapel,
                    'tanggal_absensi' => $selected_tanggal
                )));
            }

            $action = $existing_session ? 'update_absensi_mapel' : 'add_absensi_mapel';
            $log_desc = ($existing_session ? 'Memperbarui' : 'Menambahkan') . ' absensi mapel (rombel: ' . $selected_rombel . ', mapel: ' . $selected_mapel . ', tanggal: ' . $selected_tanggal . ')';
            log_activity($action, $log_desc);

            $this->session->set_flashdata('success', 'Absensi berhasil disimpan.');
            redirect($redirect_path . '?' . http_build_query(array(
                'tahun_ajaran' => $selected_tahun_ajaran,
                'semester' => $selected_semester,
                'id_rombel' => $selected_rombel,
                'id_mata_pelajaran' => $selected_mapel,
                'tanggal_absensi' => $selected_tanggal
            )));
        }

        $teacher_scope = array(
            'rombel_ids' => array(),
            'mapel_ids' => array()
        );

        if ($is_teacher_panel) {
            $teacher_scope = $this->get_teacher_scope_ids($selected_tahun_ajaran, $selected_semester);
            $rombel_options = $this->get_teacher_rombel_options($selected_tahun_ajaran, $selected_semester);

            if ($selected_rombel > 0 && !in_array($selected_rombel, $teacher_scope['rombel_ids'], true)) {
                $selected_rombel = 0;
                $selected_mapel = 0;
            }

            $mapel_options = $selected_rombel > 0
                ? $this->get_teacher_mapel_for_rombel_dropdown($selected_rombel)
                : array();

            $allowed_mapel_ids = array_map(function ($row) {
                return (int) ($row->id_mata_pelajaran ?? 0);
            }, $mapel_options);

            if ($selected_mapel > 0 && !in_array($selected_mapel, $allowed_mapel_ids, true)) {
                $selected_mapel = 0;
            }
        } else {
            $rombel_options = $this->Rombel_model->get_active_by_period($selected_tahun_ajaran, $selected_semester);
            if (empty($rombel_options)) {
                $rombel_options = $this->Rombel_model->get_active_by_period();
            }
            $mapel_options = $selected_rombel > 0
                ? $this->Rombel_model->get_mapel_for_rombel_dropdown($selected_rombel)
                : array();
        }

        if ($selected_rombel <= 0) {
            $selected_mapel = 0;
        }

        $existing_session = null;
        $detail_map = array();
        $children = array();
        if ($selected_rombel > 0 && $selected_mapel > 0 && $selected_tanggal !== '') {
            $existing_session = $this->Absensi_mapel_model->get_existing_session($selected_rombel, $selected_mapel, $selected_tahun_ajaran, $selected_semester, $selected_tanggal);
            $children = $this->Rombel_model->get_children($selected_rombel);
            $children = array_values(array_filter($children, function ($child) {
                return strtolower(trim((string) ($child->status_anak ?? ''))) === 'aktif';
            }));
            if ($existing_session) {
                $detail_map = $this->Absensi_mapel_model->get_detail_map_by_session((int) $existing_session->id_session);
            }
        }

        $recap_filters = array(
            'tahun_ajaran' => $selected_tahun_ajaran,
            'semester' => $selected_semester,
            'id_rombel' => $selected_rombel > 0 ? $selected_rombel : null,
            'id_mata_pelajaran' => $selected_mapel > 0 ? $selected_mapel : null,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        );

        if ($is_teacher_panel) {
            $recap_filters['allowed_rombel_ids'] = $teacher_scope['rombel_ids'];
            $recap_filters['allowed_mapel_ids'] = $teacher_scope['mapel_ids'];
        }

        $recap_rows = $this->Absensi_mapel_model->get_recap_sessions($recap_filters, 200);
        $status_summary = $this->Absensi_mapel_model->get_status_summary($recap_filters);

        $export_query = http_build_query(array(
            'tahun_ajaran' => $selected_tahun_ajaran,
            'semester' => $selected_semester,
            'id_rombel' => $selected_rombel,
            'id_mata_pelajaran' => $selected_mapel,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ));

        $view_data = array(
            'base_path' => $this->route_path(),
            'tahun_ajaran_options' => $this->get_tahun_ajaran_options(),
            'selected_tahun_ajaran' => $selected_tahun_ajaran,
            'selected_semester' => $selected_semester,
            'selected_rombel' => $selected_rombel,
            'selected_mapel' => $selected_mapel,
            'selected_tanggal' => $selected_tanggal,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'rombel_options' => $rombel_options,
            'mapel_options' => $mapel_options,
            'children' => $children,
            'detail_map' => $detail_map,
            'existing_session' => $existing_session,
            'recap_rows' => $recap_rows,
            'status_summary' => $status_summary,
            'is_teacher_panel' => $is_teacher_panel,
            'export_pdf_url' => site_url($this->route_path('export/absensi/pdf') . '?' . $export_query),
            'export_excel_url' => site_url($this->route_path('export/absensi/excel') . '?' . $export_query)
        );

        $data = array(
            'title' => 'Absensi Mapel - LKSA Harapan Bangsa',
            'page_title' => 'Absensi Mapel',
            'sidebar_view' => $this->get_sidebar_view(),
            'content' => $this->load->view('akademik/absensi', $view_data, true)
        );

        $this->load->view('templates/admin_layout', $data);
    }

    public function export_mapel_pdf()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Mata_pelajaran_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel mata pelajaran belum tersedia.');
            redirect($this->route_path('mapel'));
        }

        $this->load->library('Pdf_export');
        $rows = $this->Mata_pelajaran_model->get_all();
        $html = $this->pdf_export->generate_akademik_mapel(array(
            'mapel_rows' => $rows,
            'settings' => $this->config->item('settings')
        ));
        $this->pdf_export->generate($html, 'laporan_mata_pelajaran_' . date('Ymd') . '.pdf', 'D');
        log_activity('export_pdf_mapel', 'Mengekspor laporan PDF mata pelajaran');
    }

    public function export_mapel_excel()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Mata_pelajaran_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel mata pelajaran belum tersedia.');
            redirect($this->route_path('mapel'));
        }

        $this->load->library('Excel_export');
        $rows = $this->Mata_pelajaran_model->get_all();
        $this->excel_export->export_akademik_mapel(array('mapel_rows' => $rows), 'laporan_mata_pelajaran_' . date('Ymd') . '.xlsx');
        log_activity('export_excel_mapel', 'Mengekspor laporan Excel mata pelajaran');
    }

    public function export_rombel_pdf()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Rombel_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel rombel belum tersedia.');
            redirect($this->route_path('rombel'));
        }

        $this->load->library('Pdf_export');
        $rows = $this->Rombel_model->get_export_rows();
        $html = $this->pdf_export->generate_akademik_rombel(array(
            'rows' => $rows,
            'settings' => $this->config->item('settings')
        ));
        $this->pdf_export->generate($html, 'laporan_rombel_' . date('Ymd') . '.pdf', 'D');
        log_activity('export_pdf_rombel', 'Mengekspor laporan PDF rombel dan relasi');
    }

    public function export_rombel_excel()
    {
        if ($this->is_teacher_role()) {
            $this->session->set_flashdata('error', 'Panel guru hanya dapat mengakses menu input absensi.');
            redirect($this->route_path('absensi'));
        }

        if (!$this->Rombel_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel rombel belum tersedia.');
            redirect($this->route_path('rombel'));
        }

        $this->load->library('Excel_export');
        $rows = $this->Rombel_model->get_export_rows();
        $this->excel_export->export_akademik_rombel(array('rows' => $rows), 'laporan_rombel_' . date('Ymd') . '.xlsx');
        log_activity('export_excel_rombel', 'Mengekspor laporan Excel rombel dan relasi');
    }

    private function get_absensi_export_filters()
    {
        $tahun_ajaran = $this->normalize_tahun_ajaran($this->input->get('tahun_ajaran', true) ?: $this->get_default_tahun_ajaran());
        $semester = (int) ($this->input->get('semester', true) ?: 1);
        if ($semester !== 1 && $semester !== 2) {
            $semester = 1;
        }

        $filters = array(
            'tahun_ajaran' => $tahun_ajaran,
            'semester' => $semester,
            'id_rombel' => (int) ($this->input->get('id_rombel', true) ?: 0),
            'id_mata_pelajaran' => (int) ($this->input->get('id_mata_pelajaran', true) ?: 0),
            'export_format' => $this->input->get('export_format', true) ?: '',
            'periode_bulan' => (int) ($this->input->get('periode_bulan', true) ?: 0),
            'periode_tahun' => (int) ($this->input->get('periode_tahun', true) ?: 0),
            'tanggal_absensi' => $this->input->get('tanggal_absensi', true) ?: '',
            'tanggal_mulai' => $this->input->get('tanggal_mulai', true) ?: '',
            'tanggal_selesai' => $this->input->get('tanggal_selesai', true) ?: ''
        );

        if ($this->is_teacher_role()) {
            $teacher_scope = $this->get_teacher_scope_ids($tahun_ajaran, $semester);
            $filters['allowed_rombel_ids'] = $teacher_scope['rombel_ids'];
            $filters['allowed_mapel_ids'] = $teacher_scope['mapel_ids'];
        }

        return $filters;
    }

    public function export_absensi_pdf()
    {
        if (!$this->Absensi_mapel_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel absensi mapel belum tersedia.');
            redirect($this->route_path('absensi'));
        }

        $this->load->library('Pdf_export');
        $filters = $this->get_absensi_export_filters();
        $summary_rows = $this->Absensi_mapel_model->get_recap_sessions($filters, 0);
        $detail_rows = $this->Absensi_mapel_model->get_recap_details($filters);
        $status_summary = $this->Absensi_mapel_model->get_status_summary($filters);

        $html = $this->pdf_export->generate_akademik_absensi(array(
            'filters' => $filters,
            'summary_rows' => $summary_rows,
            'detail_rows' => $detail_rows,
            'status_summary' => $status_summary,
            'settings' => $this->config->item('settings')
        ));
        $this->pdf_export->generate($html, 'laporan_absensi_mapel_' . date('Ymd') . '.pdf', 'D');
        log_activity('export_pdf_absensi_mapel', 'Mengekspor laporan PDF absensi mapel');
    }

    public function export_absensi_excel()
    {
        if (!$this->Absensi_mapel_model->is_table_ready()) {
            $this->session->set_flashdata('error', 'Tabel absensi mapel belum tersedia.');
            redirect($this->route_path('absensi'));
        }

        $this->load->library('Excel_export');
        $filters = $this->get_absensi_export_filters();
        $export_format = strtolower(trim((string) ($filters['export_format'] ?? '')));

        // Jika export dipanggil dari detail rombel (tanpa mapel), kirim format absensi khusus rombel.
        if ($export_format === 'template_rombel' && (int) ($filters['id_rombel'] ?? 0) > 0) {
            if (
                !$this->is_teacher_mapel_scope_valid(
                    (int) ($filters['id_rombel'] ?? 0),
                    (int) ($filters['id_mata_pelajaran'] ?? 0),
                    $filters['tahun_ajaran'] ?? null,
                    $filters['semester'] ?? null
                )
            ) {
                $this->session->set_flashdata('error', 'Anda hanya dapat mengakses format absensi untuk mapel yang disetting admin kepada Anda.');
                redirect($this->route_path('absensi'));
            }

            $rombel = $this->Rombel_model->get_by_id((int) $filters['id_rombel']);
            if (!$rombel) {
                $this->session->set_flashdata('error', 'Data rombel tidak ditemukan untuk export format absensi.');
                redirect($this->route_path('rombel'));
            }

            $children = $this->Rombel_model->get_children((int) $filters['id_rombel']);
            $periode_bulan = (int) ($filters['periode_bulan'] ?? 0);
            $periode_tahun = (int) ($filters['periode_tahun'] ?? 0);

            if ($periode_bulan < 1 || $periode_bulan > 12 || $periode_tahun < 2000 || $periode_tahun > 3000) {
                $periode_bulan = (int) date('n', strtotime('first day of last month'));
                $periode_tahun = (int) date('Y', strtotime('first day of last month'));
            }

            $this->excel_export->export_format_absensi_rombel(array(
                'rombel' => $rombel,
                'children' => $children,
                'periode_bulan' => $periode_bulan,
                'periode_tahun' => $periode_tahun
            ), 'format_absensi_rombel_' . date('Ymd') . '.xlsx');
            log_activity('export_excel_format_absensi_rombel', 'Mengekspor format absensi Excel rombel: ' . ($rombel->nama_rombel ?? '-') . ' periode ' . $periode_bulan . '/' . $periode_tahun);
            return;
        }

        $summary_rows = $this->Absensi_mapel_model->get_recap_sessions($filters, 0);
        $detail_rows = $this->Absensi_mapel_model->get_recap_details($filters);
        $status_summary = $this->Absensi_mapel_model->get_status_summary($filters);

        $this->excel_export->export_akademik_absensi(array(
            'filters' => $filters,
            'summary_rows' => $summary_rows,
            'detail_rows' => $detail_rows,
            'status_summary' => $status_summary
        ), 'laporan_absensi_mapel_' . date('Ymd') . '.xlsx');
        log_activity('export_excel_absensi_mapel', 'Mengekspor laporan Excel absensi mapel');
    }
}
