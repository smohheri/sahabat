<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Mpdf\Mpdf;

class Pdf_export
{

	protected $mpdf;

	public function __construct()
	{
		$this->mpdf = new Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'L',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 10,
			'margin_bottom' => 15,
			'margin_footer' => 5
		]);
	}

	public function generate($html, $filename = 'laporan.pdf', $output = 'D')
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		$settings = $CI->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		$full_html = $kop_html . $html;

		$this->mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 10px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

		$this->mpdf->WriteHTML($full_html);
		$this->mpdf->Output($filename, $output);
	}

	public function generate_to_file($html, $filepath)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		$settings = $CI->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		$full_html = $kop_html . $html;

		$this->mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 10px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

		$this->mpdf->WriteHTML($full_html);
		$this->mpdf->Output($filepath, 'F');
	}

	private function get_text_header($settings, $nama_lksa)
	{
		return '<div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 5px;">
            <h3 style="margin: 0; font-size: 16px;">' . $nama_lksa . '</h3>
            <p style="margin: 3px 0; font-size: 10px;">' . ($settings->alamat ?? '') . '</p>
            <p style="margin: 3px 0; font-size: 10px;">Telp: ' . ($settings->no_telp ?? '') . ' | Email: ' . ($settings->email ?? '') . '</p>
        </div>';
	}

	public function generate_laporan_anak($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		$html = '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="3" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 9px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 8%;">NIK</th>
                    <th style="width: 12%;">Nama Anak</th>
                    <th style="width: 5%;">JK</th>
                    <th style="width: 10%;">Tempat/Tgl Lahir</th>
                    <th style="width: 4%;">Usia</th>
                    <th style="width: 6%;">Pendidikan</th>
                    <th style="width: 6%;">Kategori</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 7%;">Status Tinggal</th>
                    <th style="width: 7%;">Tgl Masuk</th>
                    <th style="width: 6%;">Nama Sekolah</th>
                    <th style="width: 6%;">Biaya SPP</th>
                    <th style="width: 4%;">KK</th>
                    <th style="width: 4%;">Akta</th>
                    <th style="width: 6%;">Dok Pendukung</th>
                    <th style="width: 4%;">Foto</th>
                </tr>
            </thead>
            <tbody>';

		$no = 1;
		foreach ($data['anak'] as $a) {
			$html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . ($a->nik ?: '-') . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td style="text-align: center;">' . ($a->jenis_kelamin == 'L' ? 'L' : 'P') . '</td>
                    <td>' . $a->tempat_lahir . ', ' . tanggal_indo($a->tanggal_lahir) . '</td>
                    <td style="text-align: center;">' . umur($a->tanggal_lahir) . '</td>
                    <td>' . $a->pendidikan . '</td>
                    <td>' . ($a->kategori ?: '-') . '</td>
                    <td style="text-align: center;">' . $a->status_anak . '</td>
                    <td>' . ($a->status_tinggal ?: '-') . '</td>
                    <td style="text-align: center;">' . tanggal_indo($a->tanggal_masuk) . '</td>
                    <td>' . ($a->nama_sekolah ?: '-') . '</td>
                    <td style="text-align: center;">' . ($a->biaya_spp ? 'Rp ' . number_format($a->biaya_spp, 0, ',', '.') : '-') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_kk) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_akta) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_pendukung) ? 'Ada' : 'Tidak') . '</td>
                    <td style="text-align: center;">' . (!empty($a->foto) ? 'Ada' : 'Tidak') . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 40px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		return $html;
	}

	public function generate_laporan_pengurus($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		// Create new Mpdf instance with portrait orientation
		$mpdf = new Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'P', // Portrait
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 15,
			'margin_bottom' => 15,
			'margin_footer' => 5
		]);

		$settings = $CI->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		$html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA PENGURUS</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 25%;">Nama Pengurus</th>
                    <th style="width: 20%;">Jabatan</th>
                    <th style="width: 15%;">No HP</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 10%; text-align: center;">KTP</th>
                    <th style="width: 15%; text-align: center;">Tgl Bergabung</th>
                </tr>
            </thead>
            <tbody>';

		$no = 1;
		foreach ($data['pengurus'] as $p) {
			$html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $p->nama_pengurus . '</td>
                    <td>' . $p->jabatan . '</td>
                    <td>' . $p->no_hp . '</td>
                    <td>' . ($p->email ?: '-') . '</td>
                    <td style="text-align: center;">' . (!empty($p->file_ktp) ? 'Ada' : 'Belum') . '</td>
                    <td style="text-align: center;">' . tanggal_indo($p->created_at) . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		$mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

		$mpdf->WriteHTML($html);
		$mpdf->Output('laporan_pengurus_' . date('Ymd') . '.pdf', 'D');
		exit;
	}

	public function generate_laporan_dokumen($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		// Create new Mpdf instance with portrait orientation
		$mpdf = new Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'P', // Portrait
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 15,
			'margin_bottom' => 15,
			'margin_footer' => 5
		]);

		$settings = $CI->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		$html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN KELENGKAPAN DOKUMEN ANAK</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 25%;">Nama Anak</th>
                    <th style="width: 20%;">NIK</th>
                    <th style="width: 15%; text-align: center;">KK</th>
                    <th style="width: 15%; text-align: center;">Akta</th>
                    <th style="width: 15%; text-align: center;">Pendukung</th>
                    <th style="width: 15%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>';

		$no = 1;
		foreach ($data['anak'] as $a) {
			$lengkap = !empty($a->file_kk) && !empty($a->file_akta);
			$html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td>' . ($a->nik ?: '-') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_kk) ? '✓ Ada' : '✗ Belum') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_akta) ? '✓ Ada' : '✗ Belum') . '</td>
                    <td style="text-align: center;">' . (!empty($a->file_pendukung) ? '✓ Ada' : '-') . '</td>
                    <td style="text-align: center;">' . ($lengkap ? 'Lengkap' : 'Kurang') . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		$mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

		$mpdf->WriteHTML($html);
		$mpdf->Output('laporan_dokumen_' . date('Ymd') . '.pdf', 'D');
		exit;
	}

	public function generate_laporan_statistik($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		$anak = $data['anak'];

		$total = count($anak);
		$laki = count(array_filter($anak, function ($a) {
			return $a->jenis_kelamin == 'L';
		}));
		$perempuan = count(array_filter($anak, function ($a) {
			return $a->jenis_kelamin == 'P';
		}));
		$aktif = count(array_filter($anak, function ($a) {
			return $a->status_anak == 'Aktif';
		}));

		$usia_dibawah5 = 0;
		$usia_5_12 = 0;
		$usia_13_17 = 0;
		$usia_diatas17 = 0;

		foreach ($anak as $a) {
			$usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;
			if ($usia < 5)
				$usia_dibawah5++;
			elseif ($usia <= 12)
				$usia_5_12++;
			elseif ($usia <= 17)
				$usia_13_17++;
			else
				$usia_diatas17++;
		}

		$pendidikan = array();
		foreach ($anak as $a) {
			$pend = $a->pendidikan;
			if (!isset($pendidikan[$pend]))
				$pendidikan[$pend] = 0;
			$pendidikan[$pend]++;
		}

		$html = '
        <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN STATISTIK ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Ringkasan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Total Anak</th>
                    <th style="text-align: center;">Laki-laki</th>
                    <th style="text-align: center;">Perempuan</th>
                    <th style="text-align: center;">Status Aktif</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><strong>' . $total . '</strong></td>
                    <td style="text-align: center;">' . $laki . ' (' . ($total > 0 ? round(($laki / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $perempuan . ' (' . ($total > 0 ? round(($perempuan / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $aktif . '</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Jenis Kelamin</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Laki-laki</td>
                    <td style="text-align: center;">' . $laki . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($laki / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Perempuan</td>
                    <td style="text-align: center;">' . $perempuan . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($perempuan / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Usia</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Kelompok Usia</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0-4 tahun (Balita)</td>
                    <td style="text-align: center;">' . $usia_dibawah5 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>5-12 tahun (Anak-anak)</td>
                    <td style="text-align: center;">' . $usia_5_12 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>13-17 tahun (Remaja)</td>
                    <td style="text-align: center;">' . $usia_13_17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>18+ tahun (Dewasa)</td>
                    <td style="text-align: center;">' . $usia_diatas17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Pendidikan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Tingkat Pendidikan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

		foreach ($pendidikan as $pend => $jumlah) {
			$html .= '
                <tr>
                    <td>' . $pend . '</td>
                    <td style="text-align: center;">' . $jumlah . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($jumlah / $total) * 100, 1) : 0) . '%</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 60px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		return $html;
	}

	public function generate_laporan_statistik_with_charts($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		$stats = $data['stats'];
		$chart_images = $data['chart_images'];

		$total = $stats['total'];
		$laki = $stats['laki'];
		$perempuan = $stats['perempuan'];
		$aktif = $stats['aktif'];
		$usia_dibawah5 = $stats['usia_dibawah5'];
		$usia_5_12 = $stats['usia_5_12'];
		$usia_13_17 = $stats['usia_13_17'];
		$usia_diatas17 = $stats['usia_diatas17'];
		$pendidikan = $stats['pendidikan'];

		$html = '
        <h3 style="text-align: center; margin-bottom: 10px;">LAPORAN STATISTIK ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>
        
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Ringkasan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Total Anak</th>
                    <th style="text-align: center;">Laki-laki</th>
                    <th style="text-align: center;">Perempuan</th>
                    <th style="text-align: center;">Status Aktif</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-size: 14px;"><strong>' . $total . '</strong></td>
                    <td style="text-align: center;">' . $laki . ' (' . ($total > 0 ? round(($laki / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $perempuan . ' (' . ($total > 0 ? round(($perempuan / $total) * 100) : 0) . '%)</td>
                    <td style="text-align: center;">' . $aktif . '</td>
                </tr>
            </tbody>
        </table>';

		// Add Gender Chart Image
		if (!empty($chart_images['gender'])) {
			$html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Jenis Kelamin</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['gender'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
		}

		// Add Age Chart Image
		if (!empty($chart_images['age'])) {
			$html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Usia</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['age'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
		}

		// Add Education Chart Image
		if (!empty($chart_images['education'])) {
			$html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Grafik Pendidikan</h4>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="' . $chart_images['education'] . '" style="max-width: 100%; height: auto; max-height: 250px;" />
        </div>';
		}

		$html .= '
        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Jenis Kelamin</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Jenis Kelamin</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Laki-laki</td>
                    <td style="text-align: center;">' . $laki . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($laki / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>Perempuan</td>
                    <td style="text-align: center;">' . $perempuan . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($perempuan / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Usia</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Kelompok Usia</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0-4 tahun (Balita)</td>
                    <td style="text-align: center;">' . $usia_dibawah5 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>5-12 tahun (Anak-anak)</td>
                    <td style="text-align: center;">' . $usia_5_12 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>13-17 tahun (Remaja)</td>
                    <td style="text-align: center;">' . $usia_13_17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
                <tr>
                    <td>18+ tahun (Dewasa)</td>
                    <td style="text-align: center;">' . $usia_diatas17 . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0) . '%</td>
                </tr>
            </tbody>
        </table>

        <h4 style="margin-top: 20px; margin-bottom: 10px;">Statistik Pendidikan</h4>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 20px;">
            <thead style="background-color: #e0e0e0;">
                <tr>
                    <th style="text-align: center;">Tingkat Pendidikan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>';

		foreach ($pendidikan as $pend => $jumlah) {
			$html .= '
                <tr>
                    <td>' . $pend . '</td>
                    <td style="text-align: center;">' . $jumlah . '</td>
                    <td style="text-align: center;">' . ($total > 0 ? round(($jumlah / $total) * 100, 1) : 0) . '%</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 60px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		return $html;
	}

	public function generate_laporan_eksternal($data)
	{
		$CI =& get_instance();
		$CI->load->helper('tanggal');

		// Sort by category order: Yatim, Piatu, Yatim Piatu, Dhuafa, Fakir dan Miskin, Ibnu Sabil, Laqith
		$category_order = [
			'Yatim' => 1,
			'Piatu' => 2,
			'Yatim Piatu' => 3,
			'Dhuafa' => 4,
			'Fakir dan Miskin' => 5,
			'Ibnu Sabil' => 6,
			'Laqith' => 7
		];

		usort($data['anak'], function ($a, $b) use ($category_order) {
			$a_order = $category_order[$a->kategori] ?? 99;
			$b_order = $category_order[$b->kategori] ?? 99;
			return $a_order <=> $b_order;
		});

		// Create new Mpdf instance with portrait orientation
		$mpdf = new Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'P', // Portrait
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 15,
			'margin_bottom' => 15,
			'margin_footer' => 5
		]);

		$settings = $CI->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		$html = $kop_html . '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN EKSTERNAL DATA ANAK</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . bulan_indo(date('n')) . ' ' . date('Y') . '</p>

        <table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 10px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 4%; text-align: center;">No</th>
                    <th style="width: 18%;">Nama Anak</th>
                    <th style="width: 6%; text-align: center;">Usia</th>
                    <th style="width: 10%; text-align: center;">Jenis Kelamin</th>
                    <th style="width: 14%;">Pendidikan</th>
                    <th style="width: 14%;">Nama Sekolah</th>
                    <th style="width: 14%;">Status Tinggal</th>
                    <th style="width: 14%;">Kategori</th>
                </tr>
            </thead>
            <tbody>';

		$no = 1;
		foreach ($data['anak'] as $a) {
			$html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td style="text-align: center;">' . umur($a->tanggal_lahir) . '</td>
                    <td style="text-align: center;">' . ($a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . '</td>
                    <td>' . $a->pendidikan . '</td>
                    <td>' . ($a->nama_sekolah ?: '-') . '</td>
                    <td>' . ($a->status_tinggal ?: '-') . '</td>
                    <td>' . ($a->kategori ?: '-') . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . tanggal_indo(date('Y-m-d')) . '</p>
            <p style="margin-top: 50px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		$mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 9px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . tanggal_indo(date('Y-m-d H:i:s')) . '
        </div>');

		$mpdf->WriteHTML($html);
		$mpdf->Output('laporan_eksternal_' . date('Ymd') . '.pdf', 'D');
		exit;
	}
}
