<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Excel_export
{

	protected $spreadsheet;
	protected $sheet;

	public function __construct()
	{
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
	}

	public function export_laporan_anak($data, $filename = 'laporan_data_anak.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		// Set title
		$this->sheet->setCellValue('A1', 'LAPORAN DATA ANAK ASUH');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Periode: ' . date('F Y'));

		// Merge title cells
		$this->sheet->mergeCells('A1:J1');
		$this->sheet->mergeCells('A2:J2');
		$this->sheet->mergeCells('A3:J3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'NIK', 'Nama Anak', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Pendidikan', 'Kategori', 'Status'];
		$row = 5;
		$col = 'A';

		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(true);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		// Data
		$row = 6;
		$no = 1;
		foreach ($data['anak'] as $a) {
			$usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;

			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $a->nik ?: '-');
			$this->sheet->setCellValue('C' . $row, $a->nama_anak);
			$this->sheet->setCellValue('D' . $row, $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
			$this->sheet->setCellValue('E' . $row, $a->tempat_lahir);
			$this->sheet->setCellValue('F' . $row, date('d-m-Y', strtotime($a->tanggal_lahir)));
			$this->sheet->setCellValue('G' . $row, $usia . ' tahun');
			$this->sheet->setCellValue('H' . $row, $a->pendidikan);
			$this->sheet->setCellValue('I' . $row, $a->kategori ?: '-');
			$this->sheet->setCellValue('J' . $row, $a->status_anak);

			// Add borders
			for ($c = 'A'; $c <= 'J'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'J') as $col) {
			$this->sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function export_laporan_pengurus($data, $filename = 'laporan_pengurus.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		// Set title
		$this->sheet->setCellValue('A1', 'LAPORAN DATA PENGURUS');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Periode: ' . date('F Y'));

		// Merge title cells
		$this->sheet->mergeCells('A1:G1');
		$this->sheet->mergeCells('A2:G2');
		$this->sheet->mergeCells('A3:G3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'Nama Pengurus', 'Jabatan', 'No HP', 'Email', 'Status KTP', 'Tanggal Bergabung'];
		$row = 5;
		$col = 'A';

		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(true);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		// Data
		$row = 6;
		$no = 1;
		foreach ($data['pengurus'] as $p) {
			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $p->nama_pengurus);
			$this->sheet->setCellValue('C' . $row, $p->jabatan);
			$this->sheet->setCellValue('D' . $row, $p->no_hp);
			$this->sheet->setCellValue('E' . $row, $p->email ?: '-');
			$this->sheet->setCellValue('F' . $row, !empty($p->file_ktp) ? 'Sudah Upload' : 'Belum Upload');
			$this->sheet->setCellValue('G' . $row, date('d-m-Y', strtotime($p->created_at)));

			// Add borders
			for ($c = 'A'; $c <= 'G'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'G') as $col) {
			$this->sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function export_laporan_dokumen($data, $filename = 'laporan_dokumen.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

		// Set title
		$this->sheet->setCellValue('A1', 'LAPORAN KELENGKAPAN DOKUMEN ANAK');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Periode: ' . date('F Y'));

		// Merge title cells
		$this->sheet->mergeCells('A1:G1');
		$this->sheet->mergeCells('A2:G2');
		$this->sheet->mergeCells('A3:G3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'Nama Anak', 'NIK', 'KK', 'Akta Kelahiran', 'Dokumen Pendukung', 'Status'];
		$row = 5;
		$col = 'A';

		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(true);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		// Data
		$row = 6;
		$no = 1;
		foreach ($data['anak'] as $a) {
			$lengkap = !empty($a->file_kk) && !empty($a->file_akta);

			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $a->nama_anak);
			$this->sheet->setCellValue('C' . $row, $a->nik ?: '-');
			$this->sheet->setCellValue('D' . $row, !empty($a->file_kk) ? 'Ada' : 'Belum');
			$this->sheet->setCellValue('E' . $row, !empty($a->file_akta) ? 'Ada' : 'Belum');
			$this->sheet->setCellValue('F' . $row, !empty($a->file_pendukung) ? 'Ada' : '-');
			$this->sheet->setCellValue('G' . $row, $lengkap ? 'Lengkap' : 'Kurang');

			// Add borders
			for ($c = 'A'; $c <= 'G'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'G') as $col) {
			$this->sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
