<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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

		// Set page orientation to landscape
		$this->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		// Set title
		$this->sheet->setCellValue('A1', 'LAPORAN DATA ANAK ASUH');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Periode: ' . date('F Y'));

		// Merge title cells
		$this->sheet->mergeCells('A1:R1');
		$this->sheet->mergeCells('A2:R2');
		$this->sheet->mergeCells('A3:R3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'NIK', 'Nama Anak', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Pendidikan', 'Kategori', 'Status', 'Status Tinggal', 'Tgl Masuk', 'Nama Sekolah', 'Biaya SPP', 'KK', 'Akta', 'Dok Pendukung', 'Foto'];
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
			$this->sheet->setCellValue('K' . $row, $a->status_tinggal ?: '-');
			$this->sheet->setCellValue('L' . $row, date('d-m-Y', strtotime($a->tanggal_masuk)));
			$this->sheet->setCellValue('M' . $row, $a->nama_sekolah ?: '-');
			$this->sheet->setCellValue('N' . $row, $a->biaya_spp ?: '-');
			$this->sheet->setCellValue('O' . $row, !empty($a->file_kk) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('P' . $row, !empty($a->file_akta) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('Q' . $row, !empty($a->file_pendukung) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('R' . $row, !empty($a->foto) ? 'Ada' : 'Tidak');

			// Add borders
			for ($c = 'A'; $c <= 'R'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'R') as $col) {
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

	public function export_laporan_eksternal($data, $filename = 'laporan_eksternal.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';

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

		// Set title
		$this->sheet->setCellValue('A1', 'LAPORAN EKSTERNAL DATA ANAK');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Periode: ' . date('F Y'));

		// Merge title cells
		$this->sheet->mergeCells('A1:H1');
		$this->sheet->mergeCells('A2:H2');
		$this->sheet->mergeCells('A3:H3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'Nama Anak', 'Usia', 'Jenis Kelamin', 'Pendidikan', 'Nama Sekolah', 'Status Tinggal', 'Kategori'];
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
			$this->sheet->setCellValue('B' . $row, $a->nama_anak);
			$this->sheet->setCellValue('C' . $row, $usia . ' tahun');
			$this->sheet->setCellValue('D' . $row, $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
			$this->sheet->setCellValue('E' . $row, $a->pendidikan);
			$this->sheet->setCellValue('F' . $row, $a->nama_sekolah ?: '-');
			$this->sheet->setCellValue('G' . $row, $a->status_tinggal ?: '-');
			$this->sheet->setCellValue('H' . $row, $a->kategori ?: '-');

			// Add borders
			for ($c = 'A'; $c <= 'H'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'H') as $col) {
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

	public function export_template_penilaian_karakter($data, $filename = 'template_import_penilaian_karakter.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$children = (array) ($data['children'] ?? array());
		$aspects = (array) ($data['aspects'] ?? array());
		$scales = (array) ($data['scales'] ?? array());

		$indicator_columns = array();
		foreach ($aspects as $aspect) {
			foreach ((array) ($aspect->indicators ?? array()) as $indicator) {
				$indicator_columns[] = array(
					'id_aspect' => (int) $aspect->id_aspect,
					'aspect_name' => (string) $aspect->aspect_name,
					'aspect_code' => (string) $aspect->aspect_code,
					'id_indicator' => (int) $indicator->id_indicator,
					'indicator_name' => (string) $indicator->indicator_name,
					'indicator_code' => (string) $indicator->indicator_code,
				);
			}
		}

		$total_columns = 8 + count($indicator_columns);
		$last_column = Coordinate::stringFromColumnIndex(max(1, $total_columns));
		$sheet = $this->sheet;
		$sheet->setTitle('Template Import');
		$sheet->freezePane('A6');

		$sheet->mergeCells('A1:' . $last_column . '1');
		$sheet->mergeCells('A2:' . $last_column . '2');
		$sheet->mergeCells('A3:' . $last_column . '3');
		$sheet->mergeCells('A4:' . $last_column . '4');

		$sheet->setCellValue('A1', 'TEMPLATE IMPORT PENILAIAN KARAKTER GURU');
		$sheet->setCellValue('A2', $nama_lksa);
		$sheet->setCellValue('A3', 'Gunakan file ini untuk mengisi penilaian karakter massal per anak.');
		$sheet->setCellValue('A4', 'Isi kolom tanggal dan skor indikator yang diperlukan. Jangan ubah kolom ID Anak, Nama Anak, serta header indikator.');

		$sheet->getStyle('A1:' . $last_column . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1:' . $last_column . '4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A1')->getFont()->setBold(TRUE)->setSize(15);
		$sheet->getStyle('A2')->getFont()->setBold(TRUE)->setSize(11);
		$sheet->getStyle('A3:A4')->getFont()->setSize(10);
		$sheet->getStyle('A1:' . $last_column . '4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EEF2FF');

		$headers = array(
			'ID Anak',
			'Nama Anak',
			'Tanggal Penilaian (YYYY-MM-DD)',
			'Catatan Umum',
			'Kekuatan Anak',
			'Perkembangan Terlihat',
			'Area Dukungan',
			'Strategi Dukungan'
		);

		$header_row = 5;
		foreach ($headers as $index => $header) {
			$column_letter = Coordinate::stringFromColumnIndex($index + 1);
			$sheet->setCellValue($column_letter . $header_row, $header);
		}

		foreach ($indicator_columns as $index => $indicator) {
			$column_index = 9 + $index;
			$column_letter = Coordinate::stringFromColumnIndex($column_index);
			$header_text = 'Skor ' . ($indicator['indicator_code'] !== '' ? $indicator['indicator_code'] . ' - ' : '') . $indicator['indicator_name'] . ' [ID:' . $indicator['id_indicator'] . ']';
			$sheet->setCellValue($column_letter . $header_row, $header_text);
		}

		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getFont()->setBold(TRUE);
		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getAlignment()->setWrapText(TRUE);
		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DCEAFE');
		$sheet->getStyle('A' . $header_row . ':' . $last_column . $header_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		$sheet->getRowDimension($header_row)->setRowHeight(42);
		$sheet->setAutoFilter('A' . $header_row . ':' . $last_column . $header_row);

		$min_score = !empty($scales) ? (int) min(array_map(function ($scale) {
			return (int) $scale->score;
		}, $scales)) : 1;
		$max_score = !empty($scales) ? (int) max(array_map(function ($scale) {
			return (int) $scale->score;
		}, $scales)) : 4;

		$row = 6;
		foreach ($children as $child) {
			$sheet->setCellValueExplicit('A' . $row, (string) $child->id_anak, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue('B' . $row, $child->nama_anak);
			$sheet->setCellValue('C' . $row, '');
			$sheet->setCellValue('D' . $row, '');
			$sheet->setCellValue('E' . $row, '');
			$sheet->setCellValue('F' . $row, '');
			$sheet->setCellValue('G' . $row, '');
			$sheet->setCellValue('H' . $row, '');

			for ($column_index = 9; $column_index <= $total_columns; $column_index++) {
				$column_letter = Coordinate::stringFromColumnIndex($column_index);
				$validation = $sheet->getCell($column_letter . $row)->getDataValidation();
				$validation->setType(DataValidation::TYPE_WHOLE);
				$validation->setErrorStyle(DataValidation::STYLE_STOP);
				$validation->setAllowBlank(TRUE);
				$validation->setShowInputMessage(TRUE);
				$validation->setShowErrorMessage(TRUE);
				$validation->setPromptTitle('Isi skor indikator');
				$validation->setPrompt('Masukkan skor ' . $min_score . ' sampai ' . $max_score . ' sesuai skala.');
				$validation->setErrorTitle('Skor tidak valid');
				$validation->setError('Skor harus berupa angka ' . $min_score . ' sampai ' . $max_score . '.');
				$validation->setFormula1((string) $min_score);
				$validation->setFormula2((string) $max_score);
			}

			$sheet->getStyle('A' . $row . ':' . $last_column . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$row++;
		}

		$last_data_row = max(6, $row - 1);
		$sheet->getStyle('A6:H' . $last_data_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');

		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setWidth(22);
		$sheet->getColumnDimension('D')->setWidth(24);
		$sheet->getColumnDimension('E')->setWidth(24);
		$sheet->getColumnDimension('F')->setWidth(24);
		$sheet->getColumnDimension('G')->setWidth(24);
		$sheet->getColumnDimension('H')->setWidth(24);

		for ($column_index = 9; $column_index <= $total_columns; $column_index++) {
			$column_letter = Coordinate::stringFromColumnIndex($column_index);
			$sheet->getColumnDimension($column_letter)->setWidth(18);
		}

		$sheet->getStyle('A1:' . $last_column . $last_data_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A6:C' . $last_data_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('I6:' . $last_column . $last_data_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$reference_sheet = new Worksheet($this->spreadsheet, 'Referensi');
		$this->spreadsheet->addSheet($reference_sheet);
		$reference_sheet->setCellValue('A1', 'Referensi Import Penilaian Karakter');
		$reference_sheet->mergeCells('A1:F1');
		$reference_sheet->getStyle('A1')->getFont()->setBold(TRUE)->setSize(14);
		$reference_sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$reference_sheet->setCellValue('A3', 'Skala Penilaian');
		$reference_sheet->getStyle('A3')->getFont()->setBold(TRUE);
		$reference_sheet->fromArray(array('Skor', 'Kategori', 'Deskripsi'), NULL, 'A4');
		$reference_sheet->getStyle('A4:C4')->getFont()->setBold(TRUE);
		$reference_sheet->getStyle('A4:C4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E7FF');

		$scale_row = 5;
		foreach ($scales as $scale) {
			$reference_sheet->setCellValue('A' . $scale_row, (int) $scale->score);
			$reference_sheet->setCellValue('B' . $scale_row, $scale->category);
			$reference_sheet->setCellValue('C' . $scale_row, $scale->description ?: '-');
			$scale_row++;
		}

		$reference_sheet->setCellValue('E3', 'Indikator Penilaian');
		$reference_sheet->getStyle('E3')->getFont()->setBold(TRUE);
		$reference_sheet->fromArray(array('ID Aspek', 'Aspek', 'ID Indikator', 'Kode', 'Nama Indikator'), NULL, 'E4');
		$reference_sheet->getStyle('E4:I4')->getFont()->setBold(TRUE);
		$reference_sheet->getStyle('E4:I4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DCFCE7');

		$indicator_row = 5;
		foreach ($indicator_columns as $indicator) {
			$reference_sheet->setCellValue('E' . $indicator_row, $indicator['id_aspect']);
			$reference_sheet->setCellValue('F' . $indicator_row, $indicator['aspect_name']);
			$reference_sheet->setCellValue('G' . $indicator_row, $indicator['id_indicator']);
			$reference_sheet->setCellValue('H' . $indicator_row, $indicator['indicator_code']);
			$reference_sheet->setCellValue('I' . $indicator_row, $indicator['indicator_name']);
			$indicator_row++;
		}

		$reference_sheet->setCellValue('K3', 'Daftar Anak');
		$reference_sheet->getStyle('K3')->getFont()->setBold(TRUE);
		$reference_sheet->fromArray(array('ID Anak', 'Nama Anak', 'Pendidikan', 'Status'), NULL, 'K4');
		$reference_sheet->getStyle('K4:N4')->getFont()->setBold(TRUE);
		$reference_sheet->getStyle('K4:N4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FDE68A');

		$child_row = 5;
		foreach ($children as $child) {
			$reference_sheet->setCellValue('K' . $child_row, (int) $child->id_anak);
			$reference_sheet->setCellValue('L' . $child_row, $child->nama_anak);
			$reference_sheet->setCellValue('M' . $child_row, $child->pendidikan ?: '-');
			$reference_sheet->setCellValue('N' . $child_row, $child->status_anak ?: '-');
			$child_row++;
		}

		foreach (array('A', 'B', 'C', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N') as $column_letter) {
			$reference_sheet->getColumnDimension($column_letter)->setAutoSize(TRUE);
		}

		$reference_sheet->getStyle('A4:N' . max($scale_row, $indicator_row, $child_row))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		$this->spreadsheet->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
