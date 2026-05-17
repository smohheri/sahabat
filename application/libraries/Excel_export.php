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
		$this->sheet->mergeCells('A1:S1');
		$this->sheet->mergeCells('A2:S2');
		$this->sheet->mergeCells('A3:S3');

		// Style title
		$this->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$this->sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// Headers
		$headers = ['No', 'NIK', 'No KK', 'Nama Anak', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Usia', 'Pendidikan', 'Kategori', 'Status', 'Status Tinggal', 'Tgl Masuk', 'Nama Sekolah', 'Biaya SPP', 'KK', 'Akta', 'Dok Pendukung', 'Foto'];
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
			$this->sheet->setCellValue('C' . $row, $a->no_kk ?: '-');
			$this->sheet->setCellValue('D' . $row, $a->nama_anak);
			$this->sheet->setCellValue('E' . $row, $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
			$this->sheet->setCellValue('F' . $row, $a->tempat_lahir);
			$this->sheet->setCellValue('G' . $row, date('d-m-Y', strtotime($a->tanggal_lahir)));
			$this->sheet->setCellValue('H' . $row, $usia . ' tahun');
			$this->sheet->setCellValue('I' . $row, $a->pendidikan);
			$this->sheet->setCellValue('J' . $row, $a->kategori ?: '-');
			$this->sheet->setCellValue('K' . $row, $a->status_anak);
			$this->sheet->setCellValue('L' . $row, $a->status_tinggal ?: '-');
			$this->sheet->setCellValue('M' . $row, date('d-m-Y', strtotime($a->tanggal_masuk)));
			$this->sheet->setCellValue('N' . $row, $a->nama_sekolah ?: '-');
			$this->sheet->setCellValue('O' . $row, $a->biaya_spp ?: '-');
			$this->sheet->setCellValue('P' . $row, !empty($a->file_kk) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('Q' . $row, !empty($a->file_akta) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('R' . $row, !empty($a->file_pendukung) ? 'Ada' : 'Tidak');
			$this->sheet->setCellValue('S' . $row, !empty($a->foto) ? 'Ada' : 'Tidak');

			// Add borders
			for ($c = 'A'; $c <= 'S'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$row++;
		}

		// Auto width
		foreach (range('A', 'S') as $col) {
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

	public function export_template_penilaian_karakter($data, $filename = 'template_import_penilaian_karakter.xlsx', $options = array())
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$children = (array) ($data['children'] ?? array());
		$aspects = (array) ($data['aspects'] ?? array());
		$scales = (array) ($data['scales'] ?? array());

		$indicator_columns = $this->build_character_indicator_columns($aspects);
		$format = strtolower(trim((string) ($options['format'] ?? 'standard')));
		if (!in_array($format, array('standard', 'per_child_sheet'), TRUE)) {
			$format = 'standard';
		}

		if ($format === 'per_child_sheet') {
			$this->build_character_template_per_child_sheet($nama_lksa, $children, $indicator_columns, $scales);
		} else {
			$this->build_character_template_standard_sheet($nama_lksa, $children, $indicator_columns, $scales);
		}

		$this->append_character_template_reference_sheet($children, $scales, $indicator_columns);
		$this->spreadsheet->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}

	private function build_character_indicator_columns($aspects)
	{
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

		return $indicator_columns;
	}

	private function resolve_character_score_range($scales)
	{
		$min_score = 1;
		$max_score = 4;

		if (!empty($scales)) {
			$min_score = (int) min(array_map(function ($scale) {
				return (int) $scale->score;
			}, $scales));

			$max_score = (int) max(array_map(function ($scale) {
				return (int) $scale->score;
			}, $scales));
		}

		return array($min_score, $max_score);
	}

	private function setup_character_template_sheet(Worksheet $sheet, $nama_lksa, $indicator_columns, $subtitle, $instruction)
	{
		$total_columns = 8 + count($indicator_columns);
		$last_column = Coordinate::stringFromColumnIndex(max(1, $total_columns));

		$sheet->freezePane('A6');
		$sheet->mergeCells('A1:' . $last_column . '1');
		$sheet->mergeCells('A2:' . $last_column . '2');
		$sheet->mergeCells('A3:' . $last_column . '3');
		$sheet->mergeCells('A4:' . $last_column . '4');

		$sheet->setCellValue('A1', 'TEMPLATE IMPORT PENILAIAN KARAKTER GURU');
		$sheet->setCellValue('A2', $nama_lksa);
		$sheet->setCellValue('A3', $subtitle);
		$sheet->setCellValue('A4', $instruction);

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

		return array(
			'total_columns' => $total_columns,
			'last_column' => $last_column,
		);
	}

	private function setup_character_template_columns_width(Worksheet $sheet, $total_columns)
	{
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
	}

	private function apply_character_score_validation(Worksheet $sheet, $row, $total_columns, $min_score, $max_score)
	{
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
	}

	private function build_character_template_standard_sheet($nama_lksa, $children, $indicator_columns, $scales)
	{
		$sheet = $this->sheet;
		$sheet->setTitle('Template Import');

		$meta = $this->setup_character_template_sheet(
			$sheet,
			$nama_lksa,
			$indicator_columns,
			'Gunakan file ini untuk mengisi penilaian karakter massal per anak.',
			'Isi kolom tanggal dan skor indikator yang diperlukan. Jangan ubah kolom ID Anak, Nama Anak, serta header indikator.'
		);

		list($min_score, $max_score) = $this->resolve_character_score_range($scales);

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

			$this->apply_character_score_validation($sheet, $row, $meta['total_columns'], $min_score, $max_score);
			$sheet->getStyle('A' . $row . ':' . $meta['last_column'] . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$row++;
		}

		if ($row === 6) {
			$sheet->setCellValue('A6', '');
			$sheet->setCellValue('B6', '');
			$sheet->setCellValue('C6', '');
			$sheet->setCellValue('D6', '');
			$sheet->setCellValue('E6', '');
			$sheet->setCellValue('F6', '');
			$sheet->setCellValue('G6', '');
			$sheet->setCellValue('H6', '');
			$this->apply_character_score_validation($sheet, 6, $meta['total_columns'], $min_score, $max_score);
			$sheet->getStyle('A6:' . $meta['last_column'] . '6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$row++;
		}

		$last_data_row = max(6, $row - 1);
		$sheet->getStyle('A6:H' . $last_data_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
		$sheet->getStyle('A1:' . $meta['last_column'] . $last_data_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A6:C' . $last_data_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		if ($meta['total_columns'] >= 9) {
			$sheet->getStyle('I6:' . $meta['last_column'] . $last_data_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		}

		$this->setup_character_template_columns_width($sheet, $meta['total_columns']);
	}

	private function build_character_template_per_child_sheet($nama_lksa, $children, $indicator_columns, $scales)
	{
		$used_sheet_titles = array('referensi');
		$children_to_render = !empty($children)
			? $children
			: array((object) array('id_anak' => '', 'nama_anak' => 'Anak 1'));

		list($min_score, $max_score) = $this->resolve_character_score_range($scales);

		foreach ($children_to_render as $index => $child) {
			$sheet = $index === 0
				? $this->sheet
				: new Worksheet($this->spreadsheet);

			if ($index > 0) {
				$this->spreadsheet->addSheet($sheet);
			}

			$sheet_title_seed = trim((string) ($child->nama_anak ?? ''));
			if ($sheet_title_seed === '') {
				$sheet_title_seed = 'Anak ' . ($index + 1);
			}

			if (isset($child->id_anak) && (string) $child->id_anak !== '') {
				$sheet_title_seed = (string) $child->id_anak . ' ' . $sheet_title_seed;
			}

			$sheet_title = $this->build_unique_sheet_title($sheet_title_seed, $used_sheet_titles);
			$sheet->setTitle($sheet_title);

			$child_name = trim((string) ($child->nama_anak ?? '-'));
			$child_id = trim((string) ($child->id_anak ?? ''));
			$subtitle = 'Sheet ini khusus untuk anak: ' . ($child_name !== '' ? $child_name : '-') . ($child_id !== '' ? ' (ID: ' . $child_id . ')' : '') . '.';
			$instruction = 'Isi kolom tanggal dan skor indikator pada baris data. Jangan ubah kolom ID Anak, Nama Anak, serta header indikator.';

			$meta = $this->setup_character_template_sheet(
				$sheet,
				$nama_lksa,
				$indicator_columns,
				$subtitle,
				$instruction
			);

			$sheet->setCellValueExplicit('A6', (string) ($child->id_anak ?? ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue('B6', (string) ($child->nama_anak ?? ''));
			$sheet->setCellValue('C6', '');
			$sheet->setCellValue('D6', '');
			$sheet->setCellValue('E6', '');
			$sheet->setCellValue('F6', '');
			$sheet->setCellValue('G6', '');
			$sheet->setCellValue('H6', '');

			$this->apply_character_score_validation($sheet, 6, $meta['total_columns'], $min_score, $max_score);
			$sheet->getStyle('A6:' . $meta['last_column'] . '6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$sheet->getStyle('A6:H6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
			$sheet->getStyle('A1:' . $meta['last_column'] . '6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
			$sheet->getStyle('A6:C6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

			if ($meta['total_columns'] >= 9) {
				$sheet->getStyle('I6:' . $meta['last_column'] . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			}

			$this->setup_character_template_columns_width($sheet, $meta['total_columns']);
		}
	}

	private function append_character_template_reference_sheet($children, $scales, $indicator_columns)
	{
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

		$last_reference_row = max(5, $scale_row, $indicator_row, $child_row);
		$reference_sheet->getStyle('A4:N' . $last_reference_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
	}

	private function build_unique_sheet_title($raw_title, &$used_sheet_titles)
	{
		$title = trim((string) $raw_title);
		$title = preg_replace('/[\\x00-\\x1F\\x7F]/', '', $title);
		$title = preg_replace('/[\\\\\/\?\*\[\]:]/', ' ', $title);
		$title = preg_replace('/\s+/', ' ', $title);
		$title = trim($title);

		if ($title === '') {
			$title = 'Anak';
		}

		$base = substr($title, 0, 31);
		if ($base === '') {
			$base = 'Anak';
		}

		$candidate = $base;
		$counter = 2;
		while (in_array(strtolower($candidate), $used_sheet_titles, TRUE)) {
			$suffix = '-' . $counter;
			$max_base_length = max(1, 31 - strlen($suffix));
			$candidate = substr($base, 0, $max_base_length) . $suffix;
			$counter++;
		}

		$used_sheet_titles[] = strtolower($candidate);
		return $candidate;
	}

	private function reset_workbook($sheet_title = 'Sheet1')
	{
		$this->spreadsheet = new Spreadsheet();
		$this->sheet = $this->spreadsheet->getActiveSheet();
		$this->sheet->setTitle($sheet_title);
	}

	private function output_workbook($filename)
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($this->spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function export_akademik_mapel($data, $filename = 'laporan_mata_pelajaran.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$rows = (array) ($data['mapel_rows'] ?? array());

		$this->reset_workbook('Master Mapel');

		$this->sheet->setCellValue('A1', 'LAPORAN MASTER MATA PELAJARAN');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Dicetak: ' . date('d-m-Y H:i'));
		$this->sheet->mergeCells('A1:E1');
		$this->sheet->mergeCells('A2:E2');
		$this->sheet->mergeCells('A3:E3');
		$this->sheet->getStyle('A1:A3')->getFont()->setBold(TRUE);
		$this->sheet->getStyle('A1:E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$headers = array('No', 'Kode Mapel', 'Nama Mata Pelajaran', 'Guru Pengampu', 'Status');
		$row = 5;
		$col = 'A';
		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(TRUE);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		$row = 6;
		$no = 1;
		foreach ($rows as $item) {
			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $item->kode_mapel ?? '-');
			$this->sheet->setCellValue('C' . $row, $item->nama_mapel ?? '-');
			$this->sheet->setCellValue('D' . $row, $item->nama_pengampu ?? '-');
			$this->sheet->setCellValue('E' . $row, ((int) ($item->is_active ?? 0) === 1) ? 'Aktif' : 'Non Aktif');

			for ($c = 'A'; $c <= 'E'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}
			$row++;
		}

		if ($row === 6) {
			$this->sheet->setCellValue('A6', 'Belum ada data mata pelajaran');
			$this->sheet->mergeCells('A6:E6');
			$this->sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle('A6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		foreach (range('A', 'E') as $col) {
			$this->sheet->getColumnDimension($col)->setAutoSize(TRUE);
		}

		$this->output_workbook($filename);
	}

	public function export_akademik_rombel($data, $filename = 'laporan_rombel.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$rows = (array) ($data['rows'] ?? array());

		$this->reset_workbook('Rombel');

		$this->sheet->setCellValue('A1', 'LAPORAN ROMBEL DAN RELASI AKADEMIK');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Dicetak: ' . date('d-m-Y H:i'));
		$this->sheet->mergeCells('A1:J1');
		$this->sheet->mergeCells('A2:J2');
		$this->sheet->mergeCells('A3:J3');
		$this->sheet->getStyle('A1:A3')->getFont()->setBold(TRUE);
		$this->sheet->getStyle('A1:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$headers = array('No', 'Kode Rombel', 'Nama Rombel', 'Tahun Ajaran', 'Semester', 'Status', 'Total Anak', 'Total Mapel', 'Daftar Anak', 'Daftar Mapel');
		$row = 5;
		$col = 'A';
		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(TRUE);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		$row = 6;
		$no = 1;
		foreach ($rows as $item) {
			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $item->kode_rombel ?? '-');
			$this->sheet->setCellValue('C' . $row, $item->nama_rombel ?? '-');
			$this->sheet->setCellValue('D' . $row, $item->tahun_ajaran ?? '-');
			$this->sheet->setCellValue('E' . $row, $item->semester ?? '-');
			$this->sheet->setCellValue('F' . $row, ((int) ($item->is_active ?? 0) === 1) ? 'Aktif' : 'Non Aktif');
			$this->sheet->setCellValue('G' . $row, (int) ($item->total_anak ?? 0));
			$this->sheet->setCellValue('H' . $row, (int) ($item->total_mapel ?? 0));
			$this->sheet->setCellValue('I' . $row, $item->daftar_anak ?? '-');
			$this->sheet->setCellValue('J' . $row, $item->daftar_mapel ?? '-');

			for ($c = 'A'; $c <= 'J'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}
			$row++;
		}

		if ($row === 6) {
			$this->sheet->setCellValue('A6', 'Belum ada data rombel');
			$this->sheet->mergeCells('A6:J6');
			$this->sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle('A6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		foreach (range('A', 'J') as $col) {
			$this->sheet->getColumnDimension($col)->setAutoSize(TRUE);
		}

		$this->output_workbook($filename);
	}

	public function export_akademik_absensi($data, $filename = 'laporan_absensi_mapel.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$filters = (array) ($data['filters'] ?? array());
		$summary_rows = (array) ($data['summary_rows'] ?? array());
		$detail_rows = (array) ($data['detail_rows'] ?? array());
		$status_summary = (array) ($data['status_summary'] ?? array());

		$rekap_per_anak = array();
		foreach ($detail_rows as $item) {
			$nama_anak = trim((string) ($item->nama_anak ?? ''));
			$id_anak = (int) ($item->id_anak ?? 0);
			if ($nama_anak === '') {
				continue;
			}

			$key = $id_anak > 0 ? 'id_' . $id_anak : 'nama_' . strtolower($nama_anak);
			if (!isset($rekap_per_anak[$key])) {
				$rekap_per_anak[$key] = array(
					'nama_anak' => $nama_anak,
					'Hadir' => 0,
					'Izin' => 0,
					'Sakit' => 0,
					'Alpha' => 0,
					'total' => 0
				);
			}

			$status = ucfirst(strtolower(trim((string) ($item->status_kehadiran ?? ''))));
			if (!in_array($status, array('Hadir', 'Izin', 'Sakit', 'Alpha'), TRUE)) {
				continue;
			}

			$rekap_per_anak[$key][$status]++;
			$rekap_per_anak[$key]['total']++;
		}

		if (!empty($rekap_per_anak)) {
			uasort($rekap_per_anak, function ($a, $b) {
				return strcmp((string) ($a['nama_anak'] ?? ''), (string) ($b['nama_anak'] ?? ''));
			});
		}

		$this->reset_workbook('Rekap Per Anak');

		$this->sheet->setCellValue('A1', 'LAPORAN REKAP ABSENSI PER ANAK');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue('A3', 'Filter: TA ' . ($filters['tahun_ajaran'] ?? '-') . ' | Semester ' . ($filters['semester'] ?? '-') . ' | Dicetak: ' . date('d-m-Y H:i'));
		$this->sheet->mergeCells('A1:G1');
		$this->sheet->mergeCells('A2:G2');
		$this->sheet->mergeCells('A3:G3');
		$this->sheet->getStyle('A1:A3')->getFont()->setBold(TRUE);
		$this->sheet->getStyle('A1:G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$this->sheet->setCellValue('A4', 'Hadir: ' . (int) ($status_summary['Hadir'] ?? 0));
		$this->sheet->setCellValue('C4', 'Izin: ' . (int) ($status_summary['Izin'] ?? 0));
		$this->sheet->setCellValue('D4', 'Sakit: ' . (int) ($status_summary['Sakit'] ?? 0));
		$this->sheet->setCellValue('E4', 'Alpha: ' . (int) ($status_summary['Alpha'] ?? 0));
		$this->sheet->setCellValue('F4', 'Total: ' . (int) ($status_summary['total'] ?? 0));

		$this->sheet->setCellValue('A5', 'Persentase kehadiran = (Hadir / (Hadir + Izin + Sakit + Alpha)) x 100%');
		$this->sheet->mergeCells('A5:G5');
		$this->sheet->getStyle('A5')->getFont()->setItalic(TRUE);

		$headers = array('No', 'Nama Siswa', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Persentase Kehadiran');
		$row = 7;
		$col = 'A';
		foreach ($headers as $header) {
			$this->sheet->setCellValue($col . $row, $header);
			$this->sheet->getStyle($col . $row)->getFont()->setBold(TRUE);
			$this->sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		$row = 8;
		$no = 1;
		foreach ($rekap_per_anak as $item) {
			$hadir = (int) ($item['Hadir'] ?? 0);
			$izin = (int) ($item['Izin'] ?? 0);
			$sakit = (int) ($item['Sakit'] ?? 0);
			$alpha = (int) ($item['Alpha'] ?? 0);
			$total_status = (int) ($item['total'] ?? 0);
			$persentase = $total_status > 0 ? ($hadir / $total_status) : 0;

			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $item['nama_anak'] ?? '-');
			$this->sheet->setCellValue('C' . $row, $hadir);
			$this->sheet->setCellValue('D' . $row, $izin);
			$this->sheet->setCellValue('E' . $row, $sakit);
			$this->sheet->setCellValue('F' . $row, $alpha);
			$this->sheet->setCellValue('G' . $row, $persentase);
			$this->sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('0.00%');

			for ($c = 'A'; $c <= 'G'; $c++) {
				$this->sheet->getStyle($c . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}
			$row++;
		}

		if ($row === 8) {
			$this->sheet->setCellValue('A8', 'Belum ada data rekap per anak');
			$this->sheet->mergeCells('A8:G8');
			$this->sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle('A8')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		foreach (range('A', 'G') as $column_letter) {
			$this->sheet->getColumnDimension($column_letter)->setAutoSize(TRUE);
		}

		$summary_sheet = new Worksheet($this->spreadsheet, 'Rekap Sesi');
		$this->spreadsheet->addSheet($summary_sheet);
		$summary_sheet->setCellValue('A1', 'REKAP ABSENSI PER SESI');
		$summary_sheet->mergeCells('A1:J1');
		$summary_sheet->getStyle('A1')->getFont()->setBold(TRUE)->setSize(12);
		$summary_sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$summary_headers = array('Tanggal', 'Tahun Ajaran', 'Semester', 'Rombel', 'Mapel', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Total');
		$summary_header_row = 3;
		$col = 'A';
		foreach ($summary_headers as $header) {
			$summary_sheet->setCellValue($col . $summary_header_row, $header);
			$summary_sheet->getStyle($col . $summary_header_row)->getFont()->setBold(TRUE);
			$summary_sheet->getStyle($col . $summary_header_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$summary_sheet->getStyle($col . $summary_header_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$summary_sheet->getStyle($col . $summary_header_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		$summary_row = 4;
		foreach ($summary_rows as $item) {
			$summary_sheet->setCellValue('A' . $summary_row, $item->tanggal_absensi ?? '-');
			$summary_sheet->setCellValue('B' . $summary_row, $item->tahun_ajaran ?? '-');
			$summary_sheet->setCellValue('C' . $summary_row, (int) ($item->semester ?? 0));
			$summary_sheet->setCellValue('D' . $summary_row, $item->nama_rombel ?? '-');
			$summary_sheet->setCellValue('E' . $summary_row, $item->nama_mapel ?? '-');
			$summary_sheet->setCellValue('F' . $summary_row, (int) ($item->total_hadir ?? 0));
			$summary_sheet->setCellValue('G' . $summary_row, (int) ($item->total_izin ?? 0));
			$summary_sheet->setCellValue('H' . $summary_row, (int) ($item->total_sakit ?? 0));
			$summary_sheet->setCellValue('I' . $summary_row, (int) ($item->total_alpha ?? 0));
			$summary_sheet->setCellValue('J' . $summary_row, (int) ($item->total_siswa ?? 0));

			for ($c = 'A'; $c <= 'J'; $c++) {
				$summary_sheet->getStyle($c . $summary_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}
			$summary_row++;
		}

		if ($summary_row === 4) {
			$summary_sheet->setCellValue('A4', 'Belum ada data rekap sesi');
			$summary_sheet->mergeCells('A4:J4');
			$summary_sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$summary_sheet->getStyle('A4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		foreach (range('A', 'J') as $column_letter) {
			$summary_sheet->getColumnDimension($column_letter)->setAutoSize(TRUE);
		}

		$detail_sheet = new Worksheet($this->spreadsheet, 'Detail Absensi');
		$this->spreadsheet->addSheet($detail_sheet);
		$detail_sheet->setCellValue('A1', 'DETAIL ABSENSI MATA PELAJARAN');
		$detail_sheet->mergeCells('A1:H1');
		$detail_sheet->getStyle('A1')->getFont()->setBold(TRUE)->setSize(12);
		$detail_sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$detail_headers = array('Tanggal', 'Tahun Ajaran', 'Semester', 'Rombel', 'Mapel', 'Nama Anak', 'Status', 'Keterangan');
		$detail_header_row = 3;
		$col = 'A';
		foreach ($detail_headers as $header) {
			$detail_sheet->setCellValue($col . $detail_header_row, $header);
			$detail_sheet->getStyle($col . $detail_header_row)->getFont()->setBold(TRUE);
			$detail_sheet->getStyle($col . $detail_header_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$detail_sheet->getStyle($col . $detail_header_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$detail_sheet->getStyle($col . $detail_header_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$col++;
		}

		$detail_row = 4;
		foreach ($detail_rows as $item) {
			$detail_sheet->setCellValue('A' . $detail_row, $item->tanggal_absensi ?? '-');
			$detail_sheet->setCellValue('B' . $detail_row, $item->tahun_ajaran ?? '-');
			$detail_sheet->setCellValue('C' . $detail_row, (int) ($item->semester ?? 0));
			$detail_sheet->setCellValue('D' . $detail_row, $item->nama_rombel ?? '-');
			$detail_sheet->setCellValue('E' . $detail_row, $item->nama_mapel ?? '-');
			$detail_sheet->setCellValue('F' . $detail_row, $item->nama_anak ?? '-');
			$detail_sheet->setCellValue('G' . $detail_row, $item->status_kehadiran ?? '-');
			$detail_sheet->setCellValue('H' . $detail_row, $item->keterangan ?? '-');

			for ($c = 'A'; $c <= 'H'; $c++) {
				$detail_sheet->getStyle($c . $detail_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}
			$detail_row++;
		}

		if ($detail_row === 4) {
			$detail_sheet->setCellValue('A4', 'Belum ada detail absensi');
			$detail_sheet->mergeCells('A4:H4');
			$detail_sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$detail_sheet->getStyle('A4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		foreach (range('A', 'H') as $column_letter) {
			$detail_sheet->getColumnDimension($column_letter)->setAutoSize(TRUE);
		}

		$this->spreadsheet->setActiveSheetIndex(0);
		$this->output_workbook($filename);
	}

	public function export_format_absensi_rombel($data, $filename = 'format_absensi_rombel.xlsx')
	{
		$settings = get_instance()->config->item('settings');
		$nama_lksa = $settings->nama_lksa ?? 'LKSA Harapan Bangsa';
		$rombel = (object) ($data['rombel'] ?? array());
		$children = (array) ($data['children'] ?? array());
		$periode_bulan = (int) ($data['periode_bulan'] ?? 0);
		$periode_tahun = (int) ($data['periode_tahun'] ?? 0);

		if ($periode_bulan < 1 || $periode_bulan > 12 || $periode_tahun < 2000 || $periode_tahun > 3000) {
			$last_month_ts = strtotime('first day of last month');
			$periode_bulan = (int) date('n', $last_month_ts);
			$periode_tahun = (int) date('Y', $last_month_ts);
		}

		$period_start = $periode_tahun . '-' . str_pad((string) $periode_bulan, 2, '0', STR_PAD_LEFT) . '-01';
		$total_hari = (int) date('t', strtotime($period_start));
		$nama_bulan = array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);
		$label_periode = ($nama_bulan[$periode_bulan] ?? (string) $periode_bulan) . ' ' . $periode_tahun;

		$this->reset_workbook('Format Absensi');
		$last_col = Coordinate::stringFromColumnIndex(33); // AG

		$this->sheet->setCellValue('A1', 'FORMAT ABSENSI BULANAN ROMBEL');
		$this->sheet->setCellValue('A2', $nama_lksa);
		$this->sheet->setCellValue(
			'A3',
			'Rombel: ' . ($rombel->nama_rombel ?? '-') . ' (' . ($rombel->kode_rombel ?? '-') . ') | TA ' . ($rombel->tahun_ajaran ?? '-') . ' | Semester ' . ($rombel->semester ?? '-')
		);
		$this->sheet->setCellValue('A4', 'Periode: ' . $label_periode . ' (Bulan Lalu) | Dicetak: ' . date('d-m-Y H:i'));

		$this->sheet->mergeCells('A1:' . $last_col . '1');
		$this->sheet->mergeCells('A2:' . $last_col . '2');
		$this->sheet->mergeCells('A3:' . $last_col . '3');
		$this->sheet->mergeCells('A4:' . $last_col . '4');
		$this->sheet->getStyle('A1:A4')->getFont()->setBold(TRUE);
		$this->sheet->getStyle('A1:' . $last_col . '4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$header_row = 6;
		$this->sheet->setCellValue('A' . $header_row, 'No');
		$this->sheet->setCellValue('B' . $header_row, 'Nama Peserta Didik');

		for ($tanggal = 1; $tanggal <= 31; $tanggal++) {
			$col_index = $tanggal + 2;
			$col_letter = Coordinate::stringFromColumnIndex($col_index);
			$this->sheet->setCellValue($col_letter . $header_row, $tanggal);
		}

		for ($col_index = 1; $col_index <= 33; $col_index++) {
			$col_letter = Coordinate::stringFromColumnIndex($col_index);
			$this->sheet->getStyle($col_letter . $header_row)->getFont()->setBold(TRUE);
			$this->sheet->getStyle($col_letter . $header_row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E0E0E0');
			$this->sheet->getStyle($col_letter . $header_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle($col_letter . $header_row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		$row = 7;
		$no = 1;
		foreach ($children as $child) {
			$this->sheet->setCellValue('A' . $row, $no++);
			$this->sheet->setCellValue('B' . $row, $child->nama_anak ?? '-');

			for ($tanggal = 1; $tanggal <= 31; $tanggal++) {
				$col_index = $tanggal + 2;
				$col_letter = Coordinate::stringFromColumnIndex($col_index);

				if ($tanggal > $total_hari) {
					$this->sheet->setCellValue($col_letter . $row, '-');
					$this->sheet->getStyle($col_letter . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F2F2F2');
				} else {
					$this->sheet->setCellValue($col_letter . $row, '');
					$validation = $this->sheet->getCell($col_letter . $row)->getDataValidation();
					$validation->setType(DataValidation::TYPE_LIST);
					$validation->setErrorStyle(DataValidation::STYLE_STOP);
					$validation->setAllowBlank(TRUE);
					$validation->setShowDropDown(TRUE);
					$validation->setShowInputMessage(TRUE);
					$validation->setPromptTitle('Kode Kehadiran');
					$validation->setPrompt('Isi dengan H, I, S, atau A');
					$validation->setShowErrorMessage(TRUE);
					$validation->setErrorTitle('Input Tidak Valid');
					$validation->setError('Kode hanya boleh H, I, S, atau A.');
					$validation->setFormula1('"H,I,S,A"');
				}

				$this->sheet->getStyle($col_letter . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			}

			$this->sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle('A' . $row . ':B' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
			$row++;
		}

		if ($row === 7) {
			$this->sheet->setCellValue('A7', 'Belum ada peserta didik pada rombel ini');
			$this->sheet->mergeCells('A7:' . $last_col . '7');
			$this->sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$this->sheet->getStyle('A7:' . $last_col . '7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
		}

		$note_row = max($row, 8) + 1;
		$this->sheet->setCellValue('A' . $note_row, 'Keterangan kode: H = Hadir, I = Izin, S = Sakit, A = Alpha');
		$this->sheet->mergeCells('A' . $note_row . ':' . $last_col . $note_row);
		$this->sheet->getStyle('A' . $note_row)->getFont()->setItalic(TRUE);

		$this->sheet->freezePane('C7');

		$this->sheet->getColumnDimension('A')->setWidth(6);
		$this->sheet->getColumnDimension('B')->setWidth(35);
		for ($col_index = 3; $col_index <= 33; $col_index++) {
			$this->sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col_index))->setWidth(4);
		}

		$this->output_workbook($filename);
	}
}
