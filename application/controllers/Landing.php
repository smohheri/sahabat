<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$data['settings'] = $this->config->item('settings');
		$this->load->view('landingpage/home', $data);
	}
}
