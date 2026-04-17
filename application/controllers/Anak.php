<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'anak') {
            if (in_array($this->session->userdata('role'), array('guru', 'pengajar'), TRUE)) {
                redirect('guru');
            }

            redirect('admin');
        }

        $this->load->model('Anak_model');
        $this->load->model('User_model');
        $this->load->model('Character_assessment_model');
        $this->load->model('Character_master_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $id_anak = (int) $this->session->userdata('id_anak');
        $anak = $id_anak > 0 ? $this->Anak_model->get_anak_by_id($id_anak) : null;

        if (!$anak) {
            $data = array(
                'title' => 'Panel Anak - LKSA Harapan Bangsa',
                'page_title' => 'Panel Anak',
                'sidebar_view' => 'templates/sidebar_anak',
                'content' => $this->load->view('anak/dashboard_unlinked', array(), TRUE),
            );

            $this->load->view('templates/admin_layout', $data);
            return;
        }

        $panel_context = $this->get_assessment_context((int) $anak->id_anak);
        $schema_ready = $panel_context['schema_ready'];
        $current_month = $panel_context['current_month'];
        $current_year = $panel_context['current_year'];
        $already_submitted = $panel_context['already_submitted'];

        $assessment_history = $this->Character_assessment_model->get_child_assessment_history($anak->id_anak, array(), 10);
        $indicator_scores = $this->Character_assessment_model->get_child_indicator_scores($anak->id_anak, array('period_type' => 'monthly', 'month' => $current_month, 'year' => $current_year));

        $latest_note = null;
        if ($schema_ready) {
            $this->db->select('cqn.areas_to_support, cqn.support_strategy, ca.assessment_date, u.nama AS assessor_name', false);
            $this->db->from('character_qualitative_notes cqn');
            $this->db->join('character_assessments ca', 'ca.id_assessment = cqn.id_assessment', 'inner');
            $this->db->join('users u', 'u.id_user = ca.id_assessor', 'left');
            $this->db->where('ca.id_anak', (int) $anak->id_anak);
            $this->db->where('ca.assessor_type', 'guru');
            $this->db->order_by('ca.assessment_date', 'DESC');
            $this->db->order_by('ca.id_assessment', 'DESC');
            $this->db->limit(1);
            $latest_note = $this->db->get()->row();
        }

        $aspect_scores = array();
        foreach ((array) $indicator_scores as $score_item) {
            $aspect_name = (string) ($score_item->aspect_name ?? 'Aspek');
            if (!isset($aspect_scores[$aspect_name])) {
                $aspect_scores[$aspect_name] = array('total' => 0.0, 'count' => 0);
            }

            $aspect_scores[$aspect_name]['total'] += (float) ($score_item->avg_score ?? 0);
            $aspect_scores[$aspect_name]['count']++;
        }

        $aspect_average = array();
        foreach ($aspect_scores as $aspect_name => $accumulator) {
            if ($accumulator['count'] <= 0) {
                continue;
            }

            $aspect_average[$aspect_name] = round($accumulator['total'] / $accumulator['count'], 2);
        }

        $summary_description = 'Data penilaian bulan ini belum cukup untuk menyusun ringkasan perkembangan.';
        if (!empty($aspect_average)) {
            arsort($aspect_average);
            $best_aspect_name = (string) key($aspect_average);
            $best_aspect_score = (float) current($aspect_average);

            $lowest_aspect_name = '';
            $lowest_aspect_score = 0.0;
            foreach (array_reverse($aspect_average, true) as $name => $score) {
                $lowest_aspect_name = (string) $name;
                $lowest_aspect_score = (float) $score;
                break;
            }

            $summary_description = 'Perkembangan terkuat saat ini ada pada aspek ' . $best_aspect_name . ' (skor rata-rata ' . number_format($best_aspect_score, 2) . '). ';
            if ($lowest_aspect_name !== '') {
                $summary_description .= 'Aspek yang masih perlu perhatian lebih adalah ' . $lowest_aspect_name . ' (skor rata-rata ' . number_format($lowest_aspect_score, 2) . ').';
            }
        }

        $improvement_description = 'Belum ada catatan perbaikan dari guru yang tersimpan pada sistem.';
        if ($latest_note && (!empty($latest_note->areas_to_support) || !empty($latest_note->support_strategy))) {
            $segments = array();
            if (!empty($latest_note->areas_to_support)) {
                $segments[] = 'Fokus perbaikan berikutnya: ' . trim((string) $latest_note->areas_to_support);
            }
            if (!empty($latest_note->support_strategy)) {
                $segments[] = 'Rencana tindakan: ' . trim((string) $latest_note->support_strategy);
            }

            $improvement_description = implode(' ', $segments);
        }

        $latest_avg = null;
        if (!empty($assessment_history) && isset($assessment_history[0]->avg_score)) {
            $latest_avg = (float) $assessment_history[0]->avg_score;
        }

        $overall_avg = null;
        if (!empty($assessment_history)) {
            $total_avg = 0.0;
            $total_row = 0;
            foreach ($assessment_history as $row) {
                if (isset($row->avg_score) && $row->avg_score !== null) {
                    $total_avg += (float) $row->avg_score;
                    $total_row++;
                }
            }
            if ($total_row > 0) {
                $overall_avg = $total_avg / $total_row;
            }
        }

        $dashboard_data = array(
            'anak' => $anak,
            'assessment_history' => $assessment_history,
            'indicator_scores' => $indicator_scores,
            'latest_avg' => $latest_avg,
            'overall_avg' => $overall_avg,
            'schema_ready' => $schema_ready,
            'already_submitted' => $already_submitted,
            'current_month' => $current_month,
            'current_year' => $current_year,
            'summary_description' => $summary_description,
            'improvement_description' => $improvement_description,
            'latest_note' => $latest_note,
        );

        $data = array(
            'title' => 'Panel Anak - LKSA Harapan Bangsa',
            'page_title' => 'Dashboard Anak',
            'sidebar_view' => 'templates/sidebar_anak',
            'content' => $this->load->view('anak/dashboard', $dashboard_data, TRUE),
        );

        $this->load->view('templates/admin_layout', $data);
    }

    public function asesmen_mandiri()
    {
        $id_anak = (int) $this->session->userdata('id_anak');
        $anak = $id_anak > 0 ? $this->Anak_model->get_anak_by_id($id_anak) : null;

        if (!$anak) {
            $this->session->set_flashdata('error', 'Akun belum terhubung ke data anak.');
            redirect('anak');
        }

        $panel_context = $this->get_assessment_context((int) $anak->id_anak);
        $schema_ready = $panel_context['schema_ready'];
        $current_month = $panel_context['current_month'];
        $current_year = $panel_context['current_year'];
        $already_submitted = $panel_context['already_submitted'];

        if ($this->input->post('submit_self_assessment')) {
            if (!$schema_ready) {
                $this->session->set_flashdata('error', 'Modul penilaian karakter belum siap.');
                redirect('anak/asesmen-mandiri');
            }

            if ($already_submitted) {
                $this->session->set_flashdata('error', 'Penilaian mandiri bulan ini sudah pernah dikirim.');
                redirect('anak/asesmen-mandiri');
            }

            $scores = (array) $this->input->post('scores');
            $valid_scores = 0;
            foreach ($scores as $score) {
                $value = (int) $score;
                if ($value >= 1 && $value <= 4) {
                    $valid_scores++;
                }
            }

            if ($valid_scores === 0) {
                $this->session->set_flashdata('error', 'Silakan isi minimal satu indikator penilaian mandiri.');
                redirect('anak/asesmen-mandiri');
            }

            $assessment_payload = array(
                'id_anak' => (int) $anak->id_anak,
                'id_assessor' => (int) $this->session->userdata('id_user'),
                'assessor_type' => 'anak_asuh',
                'assessment_date' => date('Y-m-d'),
                'week_number' => (int) date('W'),
                'month' => $current_month,
                'year' => $current_year,
                'notes' => trim((string) $this->input->post('notes', TRUE)),
                'status' => 'completed'
            );

            $qualitative_note = array(
                'areas_to_support' => trim((string) $this->input->post('improvement_aspect', TRUE)),
                'support_strategy' => trim((string) $this->input->post('improvement_plan', TRUE))
            );

            $result = $this->Character_assessment_model->create_assessment_with_details($assessment_payload, $scores, $qualitative_note);

            if (empty($result['success'])) {
                $this->session->set_flashdata('error', $result['message'] ?? 'Gagal menyimpan penilaian mandiri.');
                redirect('anak/asesmen-mandiri');
            }

            $this->session->set_flashdata('success', 'Penilaian karakter mandiri bulan ini berhasil dikirim.');
            redirect('anak');
        }

        $view_data = array(
            'anak' => $anak,
            'schema_ready' => $schema_ready,
            'already_submitted' => $already_submitted,
            'current_month' => $current_month,
            'current_year' => $current_year,
            'aspects' => $schema_ready ? $this->Character_master_model->get_aspects_with_indicators() : array(),
            'scales' => $schema_ready ? $this->Character_master_model->get_scales() : array(),
        );

        $data = array(
            'title' => 'Asesmen Mandiri Anak - LKSA Harapan Bangsa',
            'page_title' => 'Asesmen Mandiri',
            'sidebar_view' => 'templates/sidebar_anak',
            'content' => $this->load->view('anak/asesmen_mandiri', $view_data, TRUE),
        );

        $this->load->view('templates/admin_layout', $data);
    }

    public function profil()
    {
        $id_anak = (int) $this->session->userdata('id_anak');
        $id_user = (int) $this->session->userdata('id_user');
        $anak = $id_anak > 0 ? $this->Anak_model->get_anak_by_id($id_anak) : null;

        if (!$anak) {
            $this->session->set_flashdata('error', 'Akun belum terhubung ke data anak.');
            redirect('anak');
        }

        if ($this->input->post('submit_change_password')) {
            $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password Baru', 'required|matches[new_password]');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', trim(strip_tags(validation_errors(' ', ' '))));
                redirect('anak/profil');
            }

            $user = $id_user > 0 ? $this->User_model->get_user_by_id($id_user) : null;
            if (!$user) {
                $this->session->set_flashdata('error', 'Data akun pengguna tidak ditemukan.');
                redirect('anak/profil');
            }

            $current_password = (string) $this->input->post('current_password', TRUE);
            $new_password = (string) $this->input->post('new_password', TRUE);

            $is_valid_current_password = false;
            if (!empty($user->password) && password_verify($current_password, (string) $user->password)) {
                $is_valid_current_password = true;
            } elseif ($current_password === (string) $user->password) {
                $is_valid_current_password = true;
            }

            if (!$is_valid_current_password) {
                $this->session->set_flashdata('error', 'Password saat ini tidak sesuai.');
                redirect('anak/profil');
            }

            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $updated = $this->User_model->update_user($id_user, array('password' => $password_hash));

            if (!$updated) {
                $this->session->set_flashdata('error', 'Gagal memperbarui password. Silakan coba lagi.');
                redirect('anak/profil');
            }

            $this->session->set_flashdata('success', 'Password berhasil diperbarui.');
            redirect('anak/profil');
        }

        $current_age = !empty($anak->tanggal_lahir) ? umur($anak->tanggal_lahir) : '-';

        $view_data = array(
            'anak' => $anak,
            'current_age' => $current_age,
        );

        $data = array(
            'title' => 'Profil Anak - LKSA Harapan Bangsa',
            'page_title' => 'Profil Anak',
            'sidebar_view' => 'templates/sidebar_anak',
            'content' => $this->load->view('anak/profil', $view_data, TRUE),
        );

        $this->load->view('templates/admin_layout', $data);
    }

    private function get_assessment_context($id_anak)
    {
        $schema_ready = $this->Character_assessment_model->is_assessment_schema_ready();
        $current_month = (int) date('n');
        $current_year = (int) date('Y');
        $already_submitted = false;

        if ($schema_ready) {
            $this->db->from('character_assessments');
            $this->db->where('id_anak', (int) $id_anak);
            $this->db->where('assessor_type', 'anak_asuh');
            $this->db->where('month', $current_month);
            $this->db->where('year', $current_year);
            $already_submitted = $this->db->count_all_results() > 0;
        }

        return array(
            'schema_ready' => $schema_ready,
            'current_month' => $current_month,
            'current_year' => $current_year,
            'already_submitted' => $already_submitted,
        );
    }
}
