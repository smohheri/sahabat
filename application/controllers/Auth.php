<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('form_validation');
		$this->load->helper('ip');
		$this->load->helper('logging');
	}

	public function login()
	{
		// Jika sudah login, redirect sesuai role
		if ($this->session->userdata('is_logged_in')) {
			$this->redirect_by_role($this->session->userdata('role'));
		}

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('akses', 'Akses', 'required|in_list[admin,petugas,dinas,operator,guru,pengajar]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->helper('form');
			$settings = $this->config->item('settings');
			$data = array(
				'title' => 'Login - ' . ($settings ? $settings->nama_lksa : 'LKSA Harapan Bangsa'),
				'settings' => $settings,
				'akses_options' => array(
					'admin' => 'Admin',
					'petugas' => 'Petugas',
					'dinas' => 'Dinas',
					'operator' => 'Operator',
					'guru' => 'Guru',
					'pengajar' => 'Pengajar'
				)
			);
			$this->load->view('auth/login', $data);
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$akses = $this->input->post('akses');

			$user = $this->User_model->login($username, $password);

			if ($user) {
				if (!$this->is_akses_match($user->role, $akses)) {
					$this->session->set_flashdata('error', 'Akses yang dipilih tidak sesuai dengan akun Anda.');
					redirect('auth/login');
				}

				$session_data = array(
					'id_user' => $user->id_user,
					'nama' => $user->nama,
					'username' => $user->username,
					'role' => $user->role,
					'is_logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);

				// Log login activity
				log_activity('login', 'Login ke sistem');

				$this->redirect_by_role($user->role);
			} else {
				$this->session->set_flashdata('error', 'Username atau password salah!');
				redirect('auth/login');
			}
		}
	}

	private function is_akses_match($user_role, $selected_akses)
	{
		$teacher_roles = array('guru', 'pengajar');
		if (in_array($user_role, $teacher_roles, TRUE) && in_array($selected_akses, $teacher_roles, TRUE)) {
			return TRUE;
		}

		return $user_role === $selected_akses;
	}

	private function redirect_by_role($role)
	{
		if (in_array($role, array('guru', 'pengajar'), TRUE)) {
			redirect('guru');
		}

		redirect('admin');
	}

	public function logout()
	{
		// Log logout activity before destroying session
		if ($this->session->userdata('is_logged_in')) {
			log_activity('logout', 'Logout dari sistem');
		}

		$this->session->sess_destroy();
		redirect('auth/login');
	}
}
