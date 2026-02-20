<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Check if user is logged in
		if (!$this->session->userdata('is_logged_in')) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data = array(
			'title' => 'Dashboard - LKSA Harapan Bangsa',
			'page_title' => 'Dashboard',
			'content' => $this->load->view('admin/dashboard', '', TRUE)
		);
		$this->load->view('templates/admin_layout', $data);
	}
}
