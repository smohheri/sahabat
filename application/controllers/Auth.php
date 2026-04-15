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
		// Jika sudah login, redirect ke admin
		if ($this->session->userdata('is_logged_in')) {
			redirect('admin');
		}

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('akses', 'Akses', 'required|in_list[admin,petugas,dinas,operator,pengajar]');

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
				if ($user->role !== $akses) {
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

				redirect('admin');
			} else {
				$this->session->set_flashdata('error', 'Username atau password salah!');
				redirect('auth/login');
			}
		}
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
