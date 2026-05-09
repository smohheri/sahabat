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
}
