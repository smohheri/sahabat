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
			'orientation' => 'P',
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 15,
			'margin_bottom' => 20,
			'margin_footer' => 10
		]);
	}

	public function generate($html, $filename = 'laporan.pdf', $output = 'D')
	{
		// Get settings
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		// Build kop surat HTML
		$kop_html = '';
		if (!empty($settings->kop_surat)) {
			$kop_path = FCPATH . 'assets/uploads/kop/' . $settings->kop_surat;
			if (file_exists($kop_path)) {
				// Use kop surat image
				$kop_data = base64_encode(file_get_contents($kop_path));
				$kop_ext = pathinfo($kop_path, PATHINFO_EXTENSION);
				$mime = ($kop_ext == 'png') ? 'image/png' : 'image/jpeg';

				$kop_html = '<div style="text-align: center; margin-bottom: 10px;">
                    <img src="data:' . $mime . ';base64,' . $kop_data . '" style="max-width: 100%; height: auto;" />
                </div>';
			} else {
				// Fallback to text header
				$kop_html = $this->get_text_header($settings, $nama_lksa);
			}
		} else {
			// Use text header
			$kop_html = $this->get_text_header($settings, $nama_lksa);
		}

		// Prepend kop surat to content (not as header)
		$full_html = $kop_html . $html;

		$this->mpdf->SetHTMLFooter('
        <div style="text-align: center; font-size: 10px;">
            Halaman {PAGENO} dari {nbpg} | Dicetak pada ' . date('d-m-Y H:i:s') . '
        </div>');

		$this->mpdf->WriteHTML($full_html);
		$this->mpdf->Output($filename, $output);
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
		$html = '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA ANAK ASUH</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . date('F Y') . '</p>
        
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">NIK</th>
                    <th style="width: 20%;">Nama Anak</th>
                    <th style="width: 10%;">JK</th>
                    <th style="width: 15%;">Tempat/Tgl Lahir</th>
                    <th style="width: 8%;">Usia</th>
                    <th style="width: 12%;">Pendidikan</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Tgl Masuk</th>
                </tr>
            </thead>
            <tbody>';

		$no = 1;
		foreach ($data['anak'] as $a) {
			$usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;
			$html .= '
                <tr>
                    <td style="text-align: center;">' . $no++ . '</td>
                    <td>' . ($a->nik ?: '-') . '</td>
                    <td>' . $a->nama_anak . '</td>
                    <td style="text-align: center;">' . ($a->jenis_kelamin == 'L' ? 'L' : 'P') . '</td>
                    <td>' . $a->tempat_lahir . ', ' . date('d-m-Y', strtotime($a->tanggal_lahir)) . '</td>
                    <td style="text-align: center;">' . $usia . ' th</td>
                    <td>' . $a->pendidikan . '</td>
                    <td style="text-align: center;">' . $a->status_anak . '</td>
                    <td style="text-align: center;">' . date('d-m-Y', strtotime($a->tanggal_masuk)) . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>
        
        <div style="margin-top: 30px; text-align: right;">
            <p>' . ($data['settings']->kota ?? '............') . ', ' . date('d F Y') . '</p>
            <p style="margin-top: 60px;"><strong>' . ($data['settings']->nama_kepala ?? 'Kepala LKSA') . '</strong></p>
            <p>Kepala ' . ($data['settings']->nama_lksa ?? 'LKSA') . '</p>
        </div>';

		return $html;
	}

	public function generate_laporan_pengurus($data)
	{
		$html = '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN DATA PENGURUS</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . date('F Y') . '</p>
        
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Pengurus</th>
                    <th style="width: 20%;">Jabatan</th>
                    <th style="width: 15%;">No HP</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 10%;">KTP</th>
                    <th style="width: 15%;">Tgl Bergabung</th>
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
                    <td style="text-align: center;">' . date('d-m-Y', strtotime($p->created_at)) . '</td>
                </tr>';
		}

		$html .= '
            </tbody>
        </table>';

		return $html;
	}

	public function generate_laporan_dokumen($data)
	{
		$html = '
        <h3 style="text-align: center; margin-bottom: 20px;">LAPORAN KELENGKAPAN DOKUMEN ANAK</h3>
        <p style="text-align: center; margin-bottom: 20px;">Periode: ' . date('F Y') . '</p>
        
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead style="background-color: #f0f0f0;">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Anak</th>
                    <th style="width: 20%;">NIK</th>
                    <th style="width: 15%;">KK</th>
                    <th style="width: 15%;">Akta</th>
                    <th style="width: 15%;">Pendukung</th>
                    <th style="width: 15%;">Status</th>
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
        </table>';

		return $html;
	}
}
