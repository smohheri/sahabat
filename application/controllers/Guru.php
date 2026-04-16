<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as SpreadsheetDate;

class Guru extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('is_logged_in')) {
			redirect('auth/login');
		}

		if (!in_array($this->session->userdata('role'), array('guru', 'pengajar'), TRUE)) {
			redirect('admin');
		}

		$this->load->model('Anak_model');
		$this->load->helper('logging');
	}

	public function index()
	{
		$anak = $this->Anak_model->get_all_anak('created_at', 'DESC');

		$total_anak = count($anak);
		$anak_aktif = 0;
		$anak_nonaktif = 0;
		$anak_laki = 0;
		$anak_perempuan = 0;
		$dokumen_lengkap = 0;
		$dokumen_kurang = 0;

		foreach ($anak as $item) {
			if ($item->status_anak === 'Aktif') {
				$anak_aktif++;
			} else {
				$anak_nonaktif++;
			}

			if ($item->jenis_kelamin === 'L') {
				$anak_laki++;
			} else {
				$anak_perempuan++;
			}

			if (!empty($item->file_kk) && !empty($item->file_akta)) {
				$dokumen_lengkap++;
			} else {
				$dokumen_kurang++;
			}
		}

		$dashboard_data = array(
			'total_anak' => $total_anak,
			'anak_aktif' => $anak_aktif,
			'anak_nonaktif' => $anak_nonaktif,
			'anak_laki' => $anak_laki,
			'anak_perempuan' => $anak_perempuan,
			'dokumen_lengkap' => $dokumen_lengkap,
			'dokumen_kurang' => $dokumen_kurang,
			'anak_terbaru' => array_slice($anak, 0, 10),
		);

		$data = array(
			'title' => 'Panel Guru - LKSA Harapan Bangsa',
			'page_title' => 'Dashboard Guru',
			'sidebar_view' => 'templates/sidebar_guru',
			'content' => $this->load->view('guru/dashboard', $dashboard_data, TRUE),
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function anak()
	{
		$anak = $this->Anak_model->get_all_anak('nama_anak', 'ASC');

		$data_view = array(
			'anak' => $anak,
		);

		$data = array(
			'title' => 'Data Anak - Panel Guru',
			'page_title' => 'Data Anak',
			'sidebar_view' => 'templates/sidebar_guru',
			'content' => $this->load->view('guru/anak', $data_view, TRUE),
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter()
	{
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');
		$this->load->library('form_validation');

		$schema_ready = $this->Character_assessment_model->is_assessment_schema_ready();

		if ($this->input->post('submit_assessment') && $schema_ready) {
			$this->form_validation->set_rules('id_anak', 'Anak', 'required|integer');
			$this->form_validation->set_rules('assessment_date', 'Tanggal Penilaian', 'required');
			$id_anak = (int) $this->input->post('id_anak');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('guru/penilaian-karakter?anak=' . $id_anak);
			}

			$assessment_date = $this->input->post('assessment_date', TRUE);
			$timestamp = strtotime($assessment_date);

			if (!$timestamp) {
				$this->session->set_flashdata('error', 'Tanggal penilaian tidak valid.');
				redirect('guru/penilaian-karakter?anak=' . $id_anak);
			}

			$scores = (array) $this->input->post('scores');
			$assessment_data = array(
				'id_anak' => $id_anak,
				'id_assessor' => (int) $this->session->userdata('id_user'),
				'assessor_type' => 'guru',
				'assessment_date' => date('Y-m-d', $timestamp),
				'week_number' => (int) date('W', $timestamp),
				'month' => (int) date('n', $timestamp),
				'year' => (int) date('Y', $timestamp),
				'notes' => trim((string) $this->input->post('notes', TRUE)),
				'status' => 'completed'
			);

			$qualitative_note = array(
				'strengths' => $this->input->post('strengths', TRUE),
				'development_observed' => $this->input->post('development_observed', TRUE),
				'areas_to_support' => $this->input->post('areas_to_support', TRUE),
				'support_strategy' => $this->input->post('support_strategy', TRUE)
			);

			$result = $this->Character_assessment_model->create_assessment_with_details($assessment_data, $scores, $qualitative_note);

			if (!$result['success']) {
				$this->session->set_flashdata('error', $result['message']);
				redirect('guru/penilaian-karakter?anak=' . $id_anak);
			}

			$anak = $this->Anak_model->get_anak_by_id($id_anak);
			log_activity(
				'add_character_assessment',
				'Menambahkan penilaian karakter untuk anak: ' . ($anak->nama_anak ?? ('ID ' . $id_anak)) . ' (assessment #' . $result['id_assessment'] . ')'
			);

			$this->session->set_flashdata('success', 'Penilaian karakter berhasil disimpan.');
			redirect('guru/penilaian-karakter?anak=' . $id_anak);
		}

		$period_type = $this->input->get('period_type', true) ?: 'weekly';
		$year = (int) ($this->input->get('year', true) ?: date('Y'));
		$week = (int) ($this->input->get('week', true) ?: date('W'));
		$month = (int) ($this->input->get('month', true) ?: date('n'));
		$start_date = $this->input->get('start_date', true) ?: date('Y-m-01');
		$end_date = $this->input->get('end_date', true) ?: date('Y-m-d');

		if (!in_array($period_type, array('weekly', 'monthly', 'range'), true)) {
			$period_type = 'weekly';
		}

		if ($period_type === 'range' && $start_date > $end_date) {
			$tmp = $start_date;
			$start_date = $end_date;
			$end_date = $tmp;
		}

		$filters = array(
			'period_type' => $period_type,
			'year' => $year,
			'week' => $week,
			'month' => $month,
			'start_date' => $start_date,
			'end_date' => $end_date
		);

		$summary_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_progress_summary((int) $this->session->userdata('id_user'), $filters)
			: array();

		$overall_avg = 0;
		if (!empty($summary_rows)) {
			$total = 0;
			foreach ($summary_rows as $r) {
				$total += (float) $r->avg_score;
			}
			$overall_avg = $total / count($summary_rows);
		}

		$children = $this->Anak_model->get_all_anak('nama_anak', 'ASC');
		$selected_child_id = (int) ($this->input->get('anak', TRUE) ?: 0);

		if ($selected_child_id <= 0 && !empty($children)) {
			$selected_child_id = (int) $children[0]->id_anak;
		}

		$selected_child = NULL;
		if ($selected_child_id > 0) {
			$selected_child = $this->Anak_model->get_anak_by_id($selected_child_id);
			if (!$selected_child && !empty($children)) {
				$selected_child_id = (int) $children[0]->id_anak;
				$selected_child = $this->Anak_model->get_anak_by_id($selected_child_id);
			}
		}

		$view_data = array(
			'schema_ready' => $schema_ready,
			'children' => $children,
			'selected_child_id' => $selected_child_id,
			'selected_child' => $selected_child,
			'scales' => $this->Character_master_model->get_scales(),
			'aspects' => $this->Character_master_model->get_aspects_with_indicators(),
			'recent_assessments' => $schema_ready
				? $this->Character_assessment_model->get_assessments_by_assessor((int) $this->session->userdata('id_user'), 20)
				: array(),
			'summary_rows' => $summary_rows,
			'overall_avg' => $overall_avg,
			'total_assessments' => array_sum(array_map(function ($r) {
				return (int) $r->total_penilaian;
			}, $summary_rows)),
			'filters' => $filters,
			'years' => range(date('Y') + 1, date('Y') - 10)
		);

		$data = array(
			'title' => 'Penilaian Karakter - Panel Guru',
			'page_title' => 'Penilaian Karakter',
			'sidebar_view' => 'templates/sidebar_guru',
			'content' => $this->load->view('guru/penilaian', $view_data, TRUE),
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_template()
	{
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');
		$this->load->library('excel_export');

		if (!$this->Character_assessment_model->is_assessment_schema_ready()) {
			$this->session->set_flashdata('error', 'Template import belum bisa dibuat karena tabel penilaian karakter belum lengkap.');
			redirect('guru/penilaian-karakter');
		}

		$template_data = array(
			'children' => $this->Anak_model->get_all_anak('nama_anak', 'ASC'),
			'aspects' => $this->Character_master_model->get_aspects_with_indicators(),
			'scales' => $this->Character_master_model->get_scales()
		);

		$total_indicators = 0;
		foreach ($template_data['aspects'] as $aspect) {
			$total_indicators += count((array) ($aspect->indicators ?? array()));
		}

		if (empty($template_data['aspects']) || empty($template_data['scales']) || $total_indicators === 0) {
			$this->session->set_flashdata('error', 'Template import belum dapat dibuat karena data aspek, indikator, atau skala penilaian masih kosong.');
			redirect('guru/penilaian-karakter');
		}

		$this->excel_export->export_template_penilaian_karakter(
			$template_data,
			'template_import_penilaian_karakter_' . date('Ymd_His') . '.xlsx'
		);
	}

	public function penilaian_karakter_import()
	{
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');
		$this->load->library('upload');

		if (!$this->input->post('submit_import')) {
			redirect('guru/penilaian-karakter');
		}

		if (!$this->Character_assessment_model->is_assessment_schema_ready()) {
			$this->session->set_flashdata('error', 'Import belum dapat diproses karena tabel penilaian karakter belum lengkap.');
			redirect('guru/penilaian-karakter');
		}

		if (empty($_FILES['import_file']['name'])) {
			$this->session->set_flashdata('error', 'Pilih file Excel atau spreadsheet yang akan diimport.');
			redirect('guru/penilaian-karakter');
		}

		$upload_path = FCPATH . 'assets/temp/character_imports/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config = array(
			'upload_path' => $upload_path,
			'allowed_types' => 'xlsx|xls|csv',
			'max_size' => 5120,
			'file_ext_tolower' => TRUE,
			'encrypt_name' => TRUE,
		);

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_file')) {
			$this->session->set_flashdata('error', $this->upload->display_errors('', ''));
			redirect('guru/penilaian-karakter');
		}

		$upload_data = $this->upload->data();
		$file_path = $upload_data['full_path'];

		try {
			$spreadsheet = IOFactory::load($file_path);
		} catch (\Throwable $e) {
			if (is_file($file_path)) {
				@unlink($file_path);
			}

			$this->session->set_flashdata('error', 'File import tidak dapat dibaca. Pastikan format file sesuai template.');
			redirect('guru/penilaian-karakter');
		}

		$sheet = $spreadsheet->getSheetByName('Template Import');
		if ($sheet === NULL) {
			$sheet = $spreadsheet->getActiveSheet();
		}

		$header_row = 5;
		$data_start_row = 6;
		$highest_row = (int) $sheet->getHighestDataRow();
		$highest_column_index = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($sheet->getHighestDataColumn($header_row));

		$indicator_columns = array();
		for ($column = 9; $column <= $highest_column_index; $column++) {
			$column_letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
			$header_value = trim((string) $sheet->getCell($column_letter . $header_row)->getValue());
			if (preg_match('/\[ID:\s*(\d+)\]/', $header_value, $matches)) {
				$indicator_columns[$column] = (int) $matches[1];
			}
		}

		if (empty($indicator_columns)) {
			if (is_file($file_path)) {
				@unlink($file_path);
			}

			$this->session->set_flashdata('error', 'Kolom indikator pada file import tidak ditemukan. Unduh ulang template terbaru.');
			redirect('guru/penilaian-karakter');
		}

		$children_map = array();
		foreach ($this->Anak_model->get_all_anak('nama_anak', 'ASC') as $child) {
			$children_map[(int) $child->id_anak] = $child;
		}

		$valid_indicator_ids = array();
		foreach ($this->Character_master_model->get_aspects_with_indicators() as $aspect) {
			foreach ((array) $aspect->indicators as $indicator) {
				$valid_indicator_ids[(int) $indicator->id_indicator] = TRUE;
			}
		}

		$valid_scores = array();
		foreach ($this->Character_master_model->get_scales() as $scale) {
			$valid_scores[(int) $scale->score] = TRUE;
		}

		if (empty($valid_scores) || empty($valid_indicator_ids)) {
			if (is_file($file_path)) {
				@unlink($file_path);
			}

			$this->session->set_flashdata('error', 'Import belum dapat diproses karena data master skala atau indikator belum lengkap.');
			redirect('guru/penilaian-karakter');
		}

		$imported_count = 0;
		$skipped_errors = array();

		for ($row = $data_start_row; $row <= $highest_row; $row++) {
			$id_anak = (int) trim((string) $sheet->getCell('A' . $row)->getFormattedValue());
			$nama_anak = trim((string) $sheet->getCell('B' . $row)->getFormattedValue());
			$assessment_date = $this->parse_import_assessment_date($sheet->getCell('C' . $row));
			$notes = trim((string) $sheet->getCell('D' . $row)->getFormattedValue());
			$strengths = trim((string) $sheet->getCell('E' . $row)->getFormattedValue());
			$development_observed = trim((string) $sheet->getCell('F' . $row)->getFormattedValue());
			$areas_to_support = trim((string) $sheet->getCell('G' . $row)->getFormattedValue());
			$support_strategy = trim((string) $sheet->getCell('H' . $row)->getFormattedValue());

			$scores = array();
			foreach ($indicator_columns as $column => $id_indicator) {
				$column_letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
				$raw_score = trim((string) $sheet->getCell($column_letter . $row)->getFormattedValue());

				if ($raw_score === '') {
					continue;
				}

				if (!preg_match('/^\d+(?:\.0+)?$/', $raw_score)) {
					$skipped_errors[] = 'Baris ' . $row . ': skor harus berupa angka bulat sesuai skala penilaian.';
					$scores = NULL;
					break;
				}

				$score = (int) $raw_score;
				if (!isset($valid_scores[$score])) {
					$skipped_errors[] = 'Baris ' . $row . ': skor harus berupa angka yang tersedia pada skala penilaian.';
					$scores = NULL;
					break;
				}

				if (!isset($valid_indicator_ids[$id_indicator])) {
					$skipped_errors[] = 'Baris ' . $row . ': indikator pada template tidak lagi valid. Unduh ulang template terbaru.';
					$scores = NULL;
					break;
				}

				$scores[$id_indicator] = $score;
			}

			if ($scores === NULL) {
				continue;
			}

			$has_text_content = ($assessment_date !== '') || $notes !== '' || $strengths !== '' || $development_observed !== '' || $areas_to_support !== '' || $support_strategy !== '';
			$has_scores = !empty($scores);

			if (!$has_text_content && !$has_scores) {
				continue;
			}

			if ($id_anak <= 0 || !isset($children_map[$id_anak])) {
				$skipped_errors[] = 'Baris ' . $row . ': ID anak tidak ditemukan.';
				continue;
			}

			if ($nama_anak !== '' && strcasecmp($nama_anak, (string) $children_map[$id_anak]->nama_anak) !== 0) {
				$skipped_errors[] = 'Baris ' . $row . ': nama anak tidak sesuai dengan ID anak pada sistem.';
				continue;
			}

			if ($assessment_date === '') {
				$skipped_errors[] = 'Baris ' . $row . ': tanggal penilaian wajib diisi dengan format YYYY-MM-DD.';
				continue;
			}

			if (!$has_scores) {
				$skipped_errors[] = 'Baris ' . $row . ': minimal isi satu skor indikator.';
				continue;
			}

			$timestamp = strtotime($assessment_date);
			if (!$timestamp) {
				$skipped_errors[] = 'Baris ' . $row . ': tanggal penilaian tidak valid.';
				continue;
			}

			$assessment_data = array(
				'id_anak' => $id_anak,
				'id_assessor' => (int) $this->session->userdata('id_user'),
				'assessor_type' => 'guru',
				'assessment_date' => date('Y-m-d', $timestamp),
				'week_number' => (int) date('W', $timestamp),
				'month' => (int) date('n', $timestamp),
				'year' => (int) date('Y', $timestamp),
				'notes' => $notes,
				'status' => 'completed'
			);

			$qualitative_note = array(
				'strengths' => $strengths,
				'development_observed' => $development_observed,
				'areas_to_support' => $areas_to_support,
				'support_strategy' => $support_strategy
			);

			$result = $this->Character_assessment_model->create_assessment_with_details($assessment_data, $scores, $qualitative_note);

			if (!$result['success']) {
				$skipped_errors[] = 'Baris ' . $row . ': ' . $result['message'];
				continue;
			}

			$imported_count++;
		}

		if (is_file($file_path)) {
			@unlink($file_path);
		}

		if ($imported_count > 0) {
			log_activity('import_character_assessment', 'Mengimpor ' . $imported_count . ' penilaian karakter melalui file spreadsheet.');
			$this->session->set_flashdata('success', 'Import penilaian karakter berhasil. Total data tersimpan: ' . $imported_count . '.');
		}

		if (!empty($skipped_errors)) {
			$preview_errors = array_slice($skipped_errors, 0, 8);
			$message = 'Sebagian baris tidak diproses:<br>- ' . implode('<br>- ', $preview_errors);
			if (count($skipped_errors) > count($preview_errors)) {
				$message .= '<br>- dan ' . (count($skipped_errors) - count($preview_errors)) . ' baris lainnya.';
			}
			$this->session->set_flashdata('error', $message);
		}

		if ($imported_count === 0 && empty($skipped_errors)) {
			$this->session->set_flashdata('error', 'Tidak ada baris yang diimport. Isi tanggal dan minimal satu skor pada baris yang ingin diproses.');
		}

		redirect('guru/penilaian-karakter');
	}

	public function perkembangan_anak()
	{
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');

		$schema_ready = $this->Character_assessment_model->is_assessment_schema_ready();

		$period_type = $this->input->get('period_type', true) ?: 'weekly';
		$year = (int) ($this->input->get('year', true) ?: date('Y'));
		$week = (int) ($this->input->get('week', true) ?: date('W'));
		$month = (int) ($this->input->get('month', true) ?: date('n'));
		$start_date = $this->input->get('start_date', true) ?: date('Y-m-01');
		$end_date = $this->input->get('end_date', true) ?: date('Y-m-d');

		if (!in_array($period_type, array('weekly', 'monthly', 'range'), true)) {
			$period_type = 'weekly';
		}

		if ($period_type === 'range' && $start_date > $end_date) {
			$tmp = $start_date;
			$start_date = $end_date;
			$end_date = $tmp;
		}

		$filters = array(
			'period_type' => $period_type,
			'year' => $year,
			'week' => $week,
			'month' => $month,
			'start_date' => $start_date,
			'end_date' => $end_date
		);

		$children = $this->Anak_model->get_all_anak('nama_anak', 'ASC');
		$aspects = $this->Character_master_model->get_aspects_with_indicator_count();

		$summary_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_progress_summary((int) $this->session->userdata('id_user'), $filters)
			: array();

		$aspect_scores_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_aspect_scores((int) $this->session->userdata('id_user'), $filters)
			: array();

		$summary_map = array();
		foreach ($summary_rows as $row) {
			$summary_map[(int) $row->id_anak] = $row;
		}

		$aspect_map = array();
		foreach ($aspect_scores_rows as $row) {
			$id_anak = (int) $row->id_anak;
			$id_aspect = (int) $row->id_aspect;
			if (!isset($aspect_map[$id_anak])) {
				$aspect_map[$id_anak] = array();
			}
			$aspect_map[$id_anak][$id_aspect] = (float) $row->avg_score;
		}

		$table_rows = array();
		$overall_avg_total = 0;
		$overall_avg_count = 0;
		$need_support_count = 0;

		foreach ($children as $child) {
			$id_anak = (int) $child->id_anak;
			$summary = $summary_map[$id_anak] ?? null;

			$aspect_scores = array();
			foreach ($aspects as $aspect) {
				$id_aspect = (int) $aspect->id_aspect;
				$aspect_scores[$id_aspect] = isset($aspect_map[$id_anak][$id_aspect]) ? (float) $aspect_map[$id_anak][$id_aspect] : null;
			}

			$avg_score = $summary ? (float) $summary->avg_score : null;
			if ($avg_score !== null) {
				$overall_avg_total += $avg_score;
				$overall_avg_count++;
				if ($avg_score < 2.5) {
					$need_support_count++;
				}
			}

			$table_rows[] = array(
				'id_anak' => $id_anak,
				'nama_anak' => $child->nama_anak,
				'pendidikan' => $child->pendidikan,
				'total_penilaian' => $summary ? (int) $summary->total_penilaian : 0,
				'avg_score' => $avg_score,
				'kategori' => $summary ? $summary->kategori : '-',
				'tanggal_terakhir' => $summary->tanggal_terakhir ?? null,
				'aspect_scores' => $aspect_scores
			);
		}

		$view_data = array(
			'schema_ready' => $schema_ready,
			'filters' => $filters,
			'years' => range(date('Y') + 1, date('Y') - 10),
			'aspects' => $aspects,
			'table_rows' => $table_rows,
			'total_children' => count($children),
			'assessed_children' => count($summary_rows),
			'overall_avg' => $overall_avg_count > 0 ? $overall_avg_total / $overall_avg_count : 0,
			'need_support_count' => $need_support_count
		);

		$data = array(
			'title' => 'Perkembangan Anak - Panel Guru',
			'page_title' => 'Perkembangan Anak',
			'sidebar_view' => 'templates/sidebar_guru',
			'content' => $this->load->view('guru/perkembangan', $view_data, TRUE),
		);

		$this->load->view('templates/admin_layout', $data);
	}

	private function parse_import_assessment_date($cell)
	{
		$value = $cell->getValue();

		if ($value === NULL || $value === '') {
			return '';
		}

		if (is_numeric($value)) {
			try {
				return SpreadsheetDate::excelToDateTimeObject($value)->format('Y-m-d');
			} catch (\Throwable $e) {
				return '';
			}
		}

		$formatted_value = trim((string) $cell->getFormattedValue());
		if ($formatted_value === '') {
			return '';
		}

		$timestamp = strtotime($formatted_value);
		return $timestamp ? date('Y-m-d', $timestamp) : '';
	}

	public function perkembangan_anak_detail($id_anak = 0)
	{
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');

		$id_anak = (int) $id_anak;
		$anak = $this->Anak_model->get_anak_by_id($id_anak);
		if (!$anak) {
			$this->session->set_flashdata('error', 'Data anak tidak ditemukan.');
			redirect('guru/perkembangan-anak');
		}

		$schema_ready = $this->Character_assessment_model->is_assessment_schema_ready();

		$period_type = $this->input->get('period_type', true) ?: 'weekly';
		$year = (int) ($this->input->get('year', true) ?: date('Y'));
		$week = (int) ($this->input->get('week', true) ?: date('W'));
		$month = (int) ($this->input->get('month', true) ?: date('n'));
		$start_date = $this->input->get('start_date', true) ?: date('Y-m-01');
		$end_date = $this->input->get('end_date', true) ?: date('Y-m-d');

		if (!in_array($period_type, array('weekly', 'monthly', 'range'), true)) {
			$period_type = 'weekly';
		}

		if ($period_type === 'range' && $start_date > $end_date) {
			$tmp = $start_date;
			$start_date = $end_date;
			$end_date = $tmp;
		}

		$filters = array(
			'period_type' => $period_type,
			'year' => $year,
			'week' => $week,
			'month' => $month,
			'start_date' => $start_date,
			'end_date' => $end_date
		);

		$indicator_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_indicator_scores((int) $this->session->userdata('id_user'), $id_anak, $filters)
			: array();

		$indicator_trend_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_indicator_trend((int) $this->session->userdata('id_user'), $id_anak, $filters)
			: array();

		$history_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_assessment_history((int) $this->session->userdata('id_user'), $id_anak, $filters, 25)
			: array();

		$aspect_groups = array();
		$aspect_avg_total = 0;
		$aspect_avg_count = 0;

		foreach ($indicator_rows as $row) {
			$id_aspect = (int) $row->id_aspect;
			if (!isset($aspect_groups[$id_aspect])) {
				$aspect_groups[$id_aspect] = array(
					'id_aspect' => $id_aspect,
					'aspect_name' => $row->aspect_name,
					'indicators' => array(),
					'aspect_sum' => 0,
					'aspect_count' => 0
				);
			}

			$score = $row->avg_score !== null ? (float) $row->avg_score : null;
			$aspect_groups[$id_aspect]['indicators'][] = array(
				'indicator_name' => $row->indicator_name,
				'indicator_code' => $row->indicator_code,
				'avg_score' => $score,
				'score_count' => (int) $row->score_count,
				'last_assessed_at' => $row->last_assessed_at
			);

			if ($score !== null) {
				$aspect_groups[$id_aspect]['aspect_sum'] += $score;
				$aspect_groups[$id_aspect]['aspect_count']++;
			}
		}

		foreach ($aspect_groups as $key => $group) {
			$aspect_avg = null;
			if ($group['aspect_count'] > 0) {
				$aspect_avg = $group['aspect_sum'] / $group['aspect_count'];
				$aspect_avg_total += $aspect_avg;
				$aspect_avg_count++;
			}

			$aspect_groups[$key]['aspect_avg'] = $aspect_avg;
			unset($aspect_groups[$key]['aspect_sum'], $aspect_groups[$key]['aspect_count']);
		}

		$overall_avg = $aspect_avg_count > 0 ? ($aspect_avg_total / $aspect_avg_count) : 0;
		$total_assessments = count($history_rows);

		$trend_dates = array();
		$trend_map = array();

		foreach ($indicator_trend_rows as $row) {
			$date_key = $row->assessment_date;
			if (!in_array($date_key, $trend_dates, true)) {
				$trend_dates[] = $date_key;
			}

			$id_aspect = (int) $row->id_aspect;
			$id_indicator = (int) $row->id_indicator;

			if (!isset($trend_map[$id_aspect])) {
				$trend_map[$id_aspect] = array();
			}

			if (!isset($trend_map[$id_aspect][$id_indicator])) {
				$trend_map[$id_aspect][$id_indicator] = array(
					'label' => $row->indicator_name . (!empty($row->indicator_code) ? ' (' . $row->indicator_code . ')' : ''),
					'points' => array()
				);
			}

			$trend_map[$id_aspect][$id_indicator]['points'][$date_key] = round((float) $row->avg_score, 2);
		}

		$trend_labels = array_map(function ($date) {
			return date('d-m-Y', strtotime($date));
		}, $trend_dates);

		$aspect_trend_chart_data = array();
		foreach ($trend_map as $id_aspect => $indicator_map) {
			$datasets = array();
			foreach ($indicator_map as $indicator_data) {
				$series = array();
				foreach ($trend_dates as $date_key) {
					$series[] = array_key_exists($date_key, $indicator_data['points'])
						? $indicator_data['points'][$date_key]
						: null;
				}

				$datasets[] = array(
					'label' => $indicator_data['label'],
					'data' => $series
				);
			}

			$aspect_trend_chart_data[$id_aspect] = array(
				'labels' => $trend_labels,
				'datasets' => $datasets
			);
		}

		$view_data = array(
			'schema_ready' => $schema_ready,
			'anak' => $anak,
			'filters' => $filters,
			'years' => range(date('Y') + 1, date('Y') - 10),
			'aspect_groups' => array_values($aspect_groups),
			'history_rows' => $history_rows,
			'aspect_trend_chart_data' => $aspect_trend_chart_data,
			'overall_avg' => $overall_avg,
			'total_assessments' => $total_assessments,
			'back_url' => site_url('guru/perkembangan-anak?' . http_build_query($filters))
		);

		$data = array(
			'title' => 'Detail Perkembangan Anak - Panel Guru',
			'page_title' => 'Detail Perkembangan Anak',
			'sidebar_view' => 'templates/sidebar_guru',
			'content' => $this->load->view('guru/perkembangan_detail', $view_data, TRUE),
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function perkembangan_anak_detail_export_pdf($id_anak = 0)
	{
		$this->load->model('Character_assessment_model');
		$this->load->helper('tanggal');
		$this->load->library('Pdf_export');

		$id_anak = (int) $id_anak;
		$anak = $this->Anak_model->get_anak_by_id($id_anak);
		if (!$anak) {
			$this->session->set_flashdata('error', 'Data anak tidak ditemukan.');
			redirect('guru/perkembangan-anak');
		}

		$period_type = $this->input->post('period_type', true) ?: 'weekly';
		$year = (int) ($this->input->post('year', true) ?: date('Y'));
		$week = (int) ($this->input->post('week', true) ?: date('W'));
		$month = (int) ($this->input->post('month', true) ?: date('n'));
		$start_date = $this->input->post('start_date', true) ?: date('Y-m-01');
		$end_date = $this->input->post('end_date', true) ?: date('Y-m-d');

		if (!in_array($period_type, array('weekly', 'monthly', 'range'), true)) {
			$period_type = 'weekly';
		}

		if ($period_type === 'range' && $start_date > $end_date) {
			$tmp = $start_date;
			$start_date = $end_date;
			$end_date = $tmp;
		}

		$filters = array(
			'period_type' => $period_type,
			'year' => $year,
			'week' => $week,
			'month' => $month,
			'start_date' => $start_date,
			'end_date' => $end_date
		);

		$schema_ready = $this->Character_assessment_model->is_assessment_schema_ready();

		$indicator_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_indicator_scores((int) $this->session->userdata('id_user'), $id_anak, $filters)
			: array();

		$history_rows = $schema_ready
			? $this->Character_assessment_model->get_assessor_child_assessment_history((int) $this->session->userdata('id_user'), $id_anak, $filters, 25)
			: array();

		$aspect_groups = array();
		$aspect_avg_total = 0;
		$aspect_avg_count = 0;

		foreach ($indicator_rows as $row) {
			$id_aspect = (int) $row->id_aspect;
			if (!isset($aspect_groups[$id_aspect])) {
				$aspect_groups[$id_aspect] = array(
					'id_aspect' => $id_aspect,
					'aspect_name' => $row->aspect_name,
					'indicators' => array(),
					'aspect_sum' => 0,
					'aspect_count' => 0
				);
			}

			$score = $row->avg_score !== null ? (float) $row->avg_score : null;
			$aspect_groups[$id_aspect]['indicators'][] = array(
				'indicator_name' => $row->indicator_name,
				'indicator_code' => $row->indicator_code,
				'avg_score' => $score,
				'score_count' => (int) $row->score_count,
				'last_assessed_at' => $row->last_assessed_at
			);

			if ($score !== null) {
				$aspect_groups[$id_aspect]['aspect_sum'] += $score;
				$aspect_groups[$id_aspect]['aspect_count']++;
			}
		}

		foreach ($aspect_groups as $key => $group) {
			$aspect_avg = null;
			if ($group['aspect_count'] > 0) {
				$aspect_avg = $group['aspect_sum'] / $group['aspect_count'];
				$aspect_avg_total += $aspect_avg;
				$aspect_avg_count++;
			}

			$aspect_groups[$key]['aspect_avg'] = $aspect_avg;
			unset($aspect_groups[$key]['aspect_sum'], $aspect_groups[$key]['aspect_count']);
		}

		$overall_avg = $aspect_avg_count > 0 ? ($aspect_avg_total / $aspect_avg_count) : 0;
		$total_assessments = count($history_rows);

		$radar_chart_image = trim((string) $this->input->post('radar_chart_image', false));
		if (strpos($radar_chart_image, 'data:image/') !== 0) {
			$radar_chart_image = '';
		}

		$aspect_chart_images_raw = trim((string) $this->input->post('aspect_chart_images', false));
		$aspect_chart_images = array();
		if (!empty($aspect_chart_images_raw)) {
			$decoded = json_decode($aspect_chart_images_raw, true);
			if (is_array($decoded)) {
				foreach ($decoded as $item) {
					if (!is_array($item)) {
						continue;
					}

					$aspect_id = isset($item['aspect_id']) ? (int) $item['aspect_id'] : 0;
					$image = isset($item['image']) ? trim((string) $item['image']) : '';
					if ($aspect_id > 0 && strpos($image, 'data:image/') === 0) {
						$aspect_chart_images[$aspect_id] = $image;
					}
				}
			}
		}

		$period_label = '';
		if ($period_type === 'weekly') {
			$period_label = 'Minggu ' . $week . ', Tahun ' . $year;
		} elseif ($period_type === 'monthly') {
			$period_label = 'Bulan ' . $month . ', Tahun ' . $year;
		} else {
			$period_label = tanggal_indo($start_date) . ' s.d. ' . tanggal_indo($end_date);
		}

		$pdf_data = array(
			'anak' => $anak,
			'filters' => $filters,
			'period_label' => $period_label,
			'overall_avg' => $overall_avg,
			'total_assessments' => $total_assessments,
			'aspect_groups' => array_values($aspect_groups),
			'history_rows' => $history_rows,
			'radar_chart_image' => $radar_chart_image,
			'aspect_chart_images' => $aspect_chart_images,
			'printed_at' => date('Y-m-d H:i:s'),
			'assessor_name' => (string) $this->session->userdata('nama')
		);

		$html = $this->load->view('guru/perkembangan_detail_pdf', $pdf_data, true);
		$filename = 'laporan_perkembangan_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($anak->nama_anak)) . '_' . date('Ymd_His') . '.pdf';
		$this->pdf_export->generate($html, $filename, 'D');
	}
}
