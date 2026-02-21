<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Anak_model');
		$this->load->model('Pengurus_model');
	}

	public function index()
	{
		// Get settings
		$data['settings'] = $this->config->item('settings');

		// Get statistics from database
		$anak = $this->Anak_model->get_all_anak();
		$pengurus = $this->Pengurus_model->get_all_pengurus();

		// Calculate statistics
		$total_anak = count($anak);
		$total_pengurus = count($pengurus);

		// Count active children
		$anak_aktif = 0;
		foreach ($anak as $a) {
			if ($a->status_anak == 'Aktif') {
				$anak_aktif++;
			}
		}

		// Calculate years of service based on tahun_berdiri
		$tahun_berdiri = !empty($data['settings']->tahun_berdiri) ? $data['settings']->tahun_berdiri : date('Y');
		$tahun_pengabdian = date('Y') - $tahun_berdiri;
		if ($tahun_pengabdian < 1) {
			$tahun_pengabdian = 1;
		}

		// Pass statistics to view
		$data['stats'] = array(
			'total_anak' => $total_anak,
			'anak_aktif' => $anak_aktif,
			'total_pengurus' => $total_pengurus,
			'tahun_pengabdian' => $tahun_pengabdian
		);

		$this->load->view('landingpage/home', $data);
	}
}
