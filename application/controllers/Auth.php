<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function login()
	{
		// Jika sudah login, redirect ke admin
		if ($this->session->userdata('is_logged_in')) {
			redirect('admin');
		}

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'title' => 'Login - LKSA Harapan Bangsa'
			);
			$this->load->view('auth/login', $data);
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$user = $this->User_model->login($username, $password);

			if ($user) {
				$session_data = array(
					'id_user' => $user->id_user,
					'nama' => $user->nama,
					'username' => $user->username,
					'role' => $user->role,
					'is_logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);
				redirect('admin');
			} else {
				$this->session->set_flashdata('error', 'Username atau password salah!');
				redirect('auth/login');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}
