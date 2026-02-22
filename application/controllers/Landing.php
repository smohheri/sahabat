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
		$this->load->model('Carousel_model');
	}

	public function index()
	{
		// Get settings
		$data['settings'] = $this->config->item('settings');

		// Get carousel images
		$data['carousel_images'] = $this->Carousel_model->get_all_carousel_images();

		// Get statistics from database
		$anak = $this->Anak_model->get_all_anak();
		$pengurus = $this->Pengurus_model->get_all_pengurus();

		// Calculate statistics
		$total_anak = count($anak);
		$total_pengurus = count($pengurus);

		// Count active children
		$anak_aktif = 0;
		$anak_laki = 0;
		$anak_perempuan = 0;
		$pendidikan_sd = 0;
		$pendidikan_smp = 0;
		$pendidikan_sma = 0;
		$pendidikan_pt = 0;
		$usia_dibawah5 = 0;
		$usia_5_12 = 0;
		$usia_13_17 = 0;
		$usia_diatas17 = 0;

		foreach ($anak as $a) {
			if ($a->status_anak == 'Aktif') {
				$anak_aktif++;
			}

			if ($a->jenis_kelamin == 'L') {
				$anak_laki++;
			} else {
				$anak_perempuan++;
			}

			$pend = strtolower($a->pendidikan);
			if (strpos($pend, 'sd') !== false || strpos($pend, 'mi') !== false) {
				$pendidikan_sd++;
			} elseif (strpos($pend, 'smp') !== false || strpos($pend, 'mts') !== false) {
				$pendidikan_smp++;
			} elseif (strpos($pend, 'sma') !== false || strpos($pend, 'smk') !== false || strpos($pend, 'ma') !== false) {
				$pendidikan_sma++;
			} elseif (strpos($pend, 'pt') !== false || strpos($pend, 'univ') !== false || strpos($pend, 'd3') !== false || strpos($pend, 's1') !== false) {
				$pendidikan_pt++;
			}

			// Calculate age groups
			if (!empty($a->tanggal_lahir)) {
				$birth_date = new DateTime($a->tanggal_lahir);
				$today = new DateTime();
				$age = $today->diff($birth_date)->y;

				if ($age < 5) {
					$usia_dibawah5++;
				} elseif ($age >= 5 && $age <= 12) {
					$usia_5_12++;
				} elseif ($age >= 13 && $age <= 17) {
					$usia_13_17++;
				} else {
					$usia_diatas17++;
				}
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
			'tahun_pengabdian' => $tahun_pengabdian,
			'anak_laki' => $anak_laki,
			'anak_perempuan' => $anak_perempuan,
			'pendidikan_sd' => $pendidikan_sd,
			'pendidikan_smp' => $pendidikan_smp,
			'pendidikan_sma' => $pendidikan_sma,
			'pendidikan_pt' => $pendidikan_pt,
			'usia_dibawah5' => $usia_dibawah5,
			'usia_5_12' => $usia_5_12,
			'usia_13_17' => $usia_13_17,
			'usia_diatas17' => $usia_diatas17
		);

		$this->load->view('landingpage/home', $data);
	}
}
