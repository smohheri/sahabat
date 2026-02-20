<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Check if user is logged in
		if (!$this->session->userdata('is_logged_in')) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$this->load->model('Anak_model');
		$this->load->model('Pengurus_model');
		$this->load->model('User_model');

		// Get statistics
		$anak = $this->Anak_model->get_all_anak();
		$pengurus = $this->Pengurus_model->get_all_pengurus();

		$total_anak = count($anak);
		$anak_laki = 0;
		$anak_perempuan = 0;
		$anak_sekolah = 0;
		$anak_asrama = 0;
		$anak_perawatan = 0;
		$dokumen_lengkap = 0;
		$dokumen_kurang = 0;
		$anak_aktif = 0;
		$anak_nonaktif = 0;
		$pendidikan_sd = 0;
		$pendidikan_smp = 0;
		$pendidikan_sma = 0;
		$pendidikan_pt = 0;
		$anak_baru = 0;

		$today = new DateTime();
		$one_month_ago = $today->modify('-1 month');

		foreach ($anak as $a) {
			if ($a->jenis_kelamin == 'L')
				$anak_laki++;
			else
				$anak_perempuan++;

			if (strpos(strtolower($a->status_tinggal), 'sekolah') !== false)
				$anak_sekolah++;
			elseif (strpos(strtolower($a->status_tinggal), 'asrama') !== false)
				$anak_asrama++;
			elseif (strpos(strtolower($a->status_tinggal), 'perawatan') !== false)
				$anak_perawatan++;

			if (!empty($a->file_kk) && !empty($a->file_akta))
				$dokumen_lengkap++;
			else
				$dokumen_kurang++;

			// Status anak
			if ($a->status_anak == 'Aktif')
				$anak_aktif++;
			else
				$anak_nonaktif++;

			// Pendidikan
			$pend = strtolower($a->pendidikan);
			if (strpos($pend, 'sd') !== false || strpos($pend, 'mi') !== false)
				$pendidikan_sd++;
			elseif (strpos($pend, 'smp') !== false || strpos($pend, 'mts') !== false)
				$pendidikan_smp++;
			elseif (strpos($pend, 'sma') !== false || strpos($pend, 'smk') !== false || strpos($pend, 'ma') !== false)
				$pendidikan_sma++;
			elseif (strpos($pend, 'pt') !== false || strpos($pend, 'univ') !== false || strpos($pend, 'd3') !== false || strpos($pend, 's1') !== false)
				$pendidikan_pt++;

			// Anak baru (masuk dalam 1 bulan terakhir)
			if (!empty($a->tanggal_masuk)) {
				$tanggal_masuk = new DateTime($a->tanggal_masuk);
				if ($tanggal_masuk >= $one_month_ago)
					$anak_baru++;
			}
		}

		$dashboard_data = array(
			'total_anak' => $total_anak,
			'anak_laki' => $anak_laki,
			'anak_perempuan' => $anak_perempuan,
			'anak_sekolah' => $anak_sekolah,
			'anak_asrama' => $anak_asrama,
			'anak_perawatan' => $anak_perawatan,
			'total_pengurus' => count($pengurus),
			'dokumen_lengkap' => $dokumen_lengkap,
			'dokumen_kurang' => $dokumen_kurang,
			'anak_aktif' => $anak_aktif,
			'anak_nonaktif' => $anak_nonaktif,
			'pendidikan_sd' => $pendidikan_sd,
			'pendidikan_smp' => $pendidikan_smp,
			'pendidikan_sma' => $pendidikan_sma,
			'pendidikan_pt' => $pendidikan_pt,
			'anak_baru' => $anak_baru,
			'anak_terbaru' => array_slice($anak, 0, 5),
			'pengurus_terbaru' => array_slice($pengurus, 0, 5)
		);

		$data = array(
			'title' => 'Dashboard - LKSA Harapan Bangsa',
			'page_title' => 'Dashboard',
			'content' => $this->load->view('admin/dashboard', $dashboard_data, TRUE)
		);
		$this->load->view('templates/admin_layout', $data);
	}

	public function dukung_kami()
	{
		$data = array(
			'title' => 'Dukung Kami - LKSA Harapan Bangsa',
			'page_title' => 'Dukung Kami',
			'content' => $this->load->view('admin/dukung_kami', NULL, TRUE)
		);
		$this->load->view('templates/admin_layout', $data);
	}

	public function pengaturan()
	{
		$this->load->model('User_model');
		$this->load->library('form_validation');

		if ($this->input->post()) {
			$this->form_validation->set_rules('nama_lksa', 'Nama LKSA', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('no_telp', 'No Telepon', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('nama_kepala', 'Nama Kepala', 'required');
			$this->form_validation->set_rules('tahun_berdiri', 'Tahun Berdiri', 'required|numeric');

			if ($this->form_validation->run() == FALSE) {
				$data['pengaturan'] = $this->config->item('settings');
			} else {
				$data_update = array(
					'nama_lksa' => $this->input->post('nama_lksa'),
					'alamat' => $this->input->post('alamat'),
					'no_telp' => $this->input->post('no_telp'),
					'email' => $this->input->post('email'),
					'nama_kepala' => $this->input->post('nama_kepala'),
					'tahun_berdiri' => $this->input->post('tahun_berdiri')
				);

				$this->User_model->update_pengaturan($data_update);
				$this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui!');
				redirect('admin/pengaturan');
			}
		} else {
			$data['pengaturan'] = $this->config->item('settings');
		}

		$data['title'] = 'Pengaturan Profile LKSA - ' . ($data['pengaturan']->nama_lksa ?? 'LKSA Harapan Bangsa');
		$data['page_title'] = 'Profile LKSA';
		$data['content'] = $this->load->view('admin/pengaturan', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function upload_logo()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		// Get current pengaturan to check existing logo
		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->logo)) {
			$old_logo_path = FCPATH . 'assets/uploads/logos/' . $pengaturan->logo;
			if (file_exists($old_logo_path)) {
				unlink($old_logo_path);
			}
		}

		$config['upload_path'] = FCPATH . 'assets/uploads/logos/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'logo_' . time();
		$config['detect_mime'] = TRUE;
		$config['xss_clean'] = TRUE;
		$config['max_width'] = 2000;
		$config['max_height'] = 2000;
		$config['min_width'] = 50;
		$config['min_height'] = 50;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('logo')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$logo_name = $data['file_name'];

			$this->User_model->update_pengaturan(['logo' => $logo_name]);
			$this->session->set_flashdata('success', 'Logo berhasil diupload!');
		}

		redirect('admin/pengaturan');
	}

	public function upload_dokumen()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		// Get current pengaturan to check existing dokumen
		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->dokumen_legal)) {
			$old_dokumen_path = FCPATH . 'assets/uploads/documents/' . $pengaturan->dokumen_legal;
			if (file_exists($old_dokumen_path)) {
				unlink($old_dokumen_path);
			}
		}

		$config['upload_path'] = FCPATH . 'assets/uploads/documents/';
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 5120; // 5MB
		$config['file_name'] = 'dokumen_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('dokumen')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$dokumen_name = $data['file_name'];

			$this->User_model->update_pengaturan(['dokumen_legal' => $dokumen_name]);
			$this->session->set_flashdata('success', 'Dokumen legal berhasil diupload!');
		}

		redirect('admin/pengaturan');
	}

	public function upload_kop()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		// Get current pengaturan to check existing kop
		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->kop_surat)) {
			$old_kop_path = FCPATH . 'assets/uploads/kop/' . $pengaturan->kop_surat;
			if (file_exists($old_kop_path)) {
				unlink($old_kop_path);
			}
		}

		// Create directory if not exists
		$upload_path = FCPATH . 'assets/uploads/kop/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'kop_' . time();
		$config['detect_mime'] = TRUE;
		$config['xss_clean'] = TRUE;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('kop_surat')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$kop_name = $data['file_name'];

			$this->User_model->update_pengaturan(['kop_surat' => $kop_name]);
			$this->session->set_flashdata('success', 'Kop surat berhasil diupload! Kop akan muncul di bagian atas laporan PDF.');
		}

		redirect('admin/pengaturan');
	}

	public function user()
	{
		$this->load->model('User_model');
		$this->load->library('form_validation');

		// Handle delete action
		if ($this->input->get('delete')) {
			$id = $this->input->get('delete');
			$this->User_model->delete_user($id);
			$this->session->set_flashdata('success', 'User berhasil dihapus!');
			redirect('admin/user');
		}

		// Handle add/edit action
		if ($this->input->post()) {
			$id = $this->input->post('id_user');

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/user');
			} else {
				$data = array(
					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'role' => $this->input->post('role')
				);

				// Only update password if provided
				if ($this->input->post('password')) {
					$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				}

				if ($id) {
					// Update existing user
					$this->User_model->update_user($id, $data);
					$this->session->set_flashdata('success', 'User berhasil diperbarui!');
				} else {
					// Insert new user
					if (!$this->input->post('password')) {
						$this->session->set_flashdata('error', 'Password wajib diisi untuk user baru!');
						redirect('admin/user');
					}
					$this->User_model->insert_user($data);
					$this->session->set_flashdata('success', 'User berhasil ditambahkan!');
				}
				redirect('admin/user');
			}
		}

		// Get user for edit
		$edit_user = null;
		if ($this->input->get('edit')) {
			$edit_user = $this->User_model->get_user_by_id($this->input->get('edit'));
		}

		$data['users'] = $this->User_model->get_all_users();
		$data['edit_user'] = $edit_user;
		$data['title'] = 'Kelola User - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola User';
		$data['content'] = $this->load->view('admin/user', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function anak()
	{
		$this->load->model('Anak_model');
		$this->load->library('form_validation');

		// Handle delete action
		if ($this->input->get('delete')) {
			$id = $this->input->get('delete');
			$this->Anak_model->delete_anak($id);
			$this->session->set_flashdata('success', 'Data anak berhasil dihapus!');
			redirect('admin/anak');
		}

		// Handle add/edit action
		if ($this->input->post()) {
			$id = $this->input->post('id_anak');

			$this->form_validation->set_rules('nama_anak', 'Nama Anak', 'required');
			$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
			$this->form_validation->set_rules('status_anak', 'Status Anak', 'required');
			$this->form_validation->set_rules('status_tinggal', 'Status Tinggal', 'required');
			$this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/anak');
			} else {
				$data = array(
					'nama_anak' => $this->input->post('nama_anak'),
					'nik' => $this->input->post('nik'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'pendidikan' => $this->input->post('pendidikan'),
					'status_anak' => $this->input->post('status_anak'),
					'status_tinggal' => $this->input->post('status_tinggal'),
					'tanggal_masuk' => $this->input->post('tanggal_masuk')
				);

				if ($id) {
					// Update existing anak
					$this->Anak_model->update_anak($id, $data);
					$this->session->set_flashdata('success', 'Data anak berhasil diperbarui!');
				} else {
					// Insert new anak
					$this->Anak_model->insert_anak($data);
					$this->session->set_flashdata('success', 'Data anak berhasil ditambahkan!');
				}
				redirect('admin/anak');
			}
		}

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['title'] = 'Data Anak - LKSA Harapan Bangsa';
		$data['page_title'] = 'Data Anak';
		$data['content'] = $this->load->view('admin/anak', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function upload_kk($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		// Get anak data
		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		// Create folder name with prefix NIK_nama or nama only if NIK empty
		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		// Create directory if not exists
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		// Delete old file if exists (extract just filename from stored path)
		if (!empty($anak->file_kk)) {
			$old_filename = basename($anak->file_kk);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'kk_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_kk')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			// Store relative path with folder
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_kk($id_anak, $file_path);
			$this->session->set_flashdata('success', 'File KK berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function upload_akta($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		// Get anak data
		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		// Create folder name with prefix NIK_nama or nama only if NIK empty
		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		// Create directory if not exists
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		// Delete old file if exists (extract just filename from stored path)
		if (!empty($anak->file_akta)) {
			$old_filename = basename($anak->file_akta);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'akta_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_akta')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			// Store relative path with folder
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_akta($id_anak, $file_path);
			$this->session->set_flashdata('success', 'File Akta berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function upload_pendukung($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		// Get anak data
		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		// Create folder name with prefix NIK_nama or nama only if NIK empty
		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		// Create directory if not exists
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		// Delete old file if exists (extract just filename from stored path)
		if (!empty($anak->file_pendukung)) {
			$old_filename = basename($anak->file_pendukung);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'pendukung_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_pendukung')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			// Store relative path with folder
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_pendukung($id_anak, $file_path);
			$this->session->set_flashdata('success', 'File pendukung berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function view_dokumen($id_anak, $jenis)
	{
		$this->load->model('Anak_model');

		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		if (!$anak) {
			show_404();
		}

		// Determine which file to show
		$file_field = 'file_' . $jenis;
		$file_path = $anak->$file_field;

		if (empty($file_path)) {
			$this->session->set_flashdata('error', 'Dokumen tidak ditemukan!');
			redirect('admin/anak');
		}

		$full_path = FCPATH . 'assets/uploads/dokumen_anak/' . $file_path;

		if (!file_exists($full_path)) {
			$this->session->set_flashdata('error', 'File tidak ditemukan di server!');
			redirect('admin/anak');
		}

		// Get file info
		$file_info = pathinfo($full_path);
		$file_ext = strtolower($file_info['extension']);
		$file_name = $file_info['basename'];

		// Set headers for file display/download
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: inline; filename="' . $file_name . '"');
		header('Content-Length: ' . filesize($full_path));
		header('Cache-Control: public, must-revalidate');
		header('Pragma: public');

		readfile($full_path);
		exit;
	}

	public function pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('form_validation');

		// Handle delete action
		if ($this->input->get('delete')) {
			$id = $this->input->get('delete');
			$this->Pengurus_model->delete_pengurus($id);
			$this->session->set_flashdata('success', 'Data pengurus berhasil dihapus!');
			redirect('admin/pengurus');
		}

		// Handle add/edit action
		if ($this->input->post()) {
			$id = $this->input->post('id_pengurus');

			$this->form_validation->set_rules('nama_pengurus', 'Nama Pengurus', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp', 'No HP', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/pengurus');
			} else {
				$data = array(
					'nama_pengurus' => $this->input->post('nama_pengurus'),
					'jabatan' => $this->input->post('jabatan'),
					'no_hp' => $this->input->post('no_hp'),
					'email' => $this->input->post('email')
				);

				if ($id) {
					// Update existing pengurus
					$this->Pengurus_model->update_pengurus($id, $data);
					$this->session->set_flashdata('success', 'Data pengurus berhasil diperbarui!');
				} else {
					// Insert new pengurus
					$this->Pengurus_model->insert_pengurus($data);
					$this->session->set_flashdata('success', 'Data pengurus berhasil ditambahkan!');
				}
				redirect('admin/pengurus');
			}
		}

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$data['title'] = 'Data Pengurus - LKSA Harapan Bangsa';
		$data['page_title'] = 'Data Pengurus';
		$data['content'] = $this->load->view('admin/pengurus', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function upload_ktp($id_pengurus)
	{
		$this->load->model('Pengurus_model');
		$this->load->library('upload');

		// Get pengurus data
		$pengurus = $this->Pengurus_model->get_pengurus_by_id($id_pengurus);

		if (!$pengurus) {
			$this->session->set_flashdata('error', 'Data pengurus tidak ditemukan!');
			redirect('admin/pengurus');
		}

		// Create folder name with prefix nama_pengurus
		$folder_name = preg_replace('/[^a-zA-Z0-9]/', '_', $pengurus->nama_pengurus);
		$upload_path = FCPATH . 'assets/uploads/dokumen_pengurus/' . $folder_name . '/';

		// Create directory if not exists
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		// Delete old file if exists
		if (!empty($pengurus->file_ktp)) {
			$old_filename = basename($pengurus->file_ktp);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['file_name'] = 'ktp_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_ktp')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			// Store relative path with folder
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Pengurus_model->update_ktp($id_pengurus, $file_path);
			$this->session->set_flashdata('success', 'File KTP berhasil diupload!');
		}

		redirect('admin/pengurus');
	}

	public function view_ktp($id_pengurus)
	{
		$this->load->model('Pengurus_model');

		$pengurus = $this->Pengurus_model->get_pengurus_by_id($id_pengurus);

		if (!$pengurus || empty($pengurus->file_ktp)) {
			$this->session->set_flashdata('error', 'File KTP tidak ditemukan!');
			redirect('admin/pengurus');
		}

		$full_path = FCPATH . 'assets/uploads/dokumen_pengurus/' . $pengurus->file_ktp;

		if (!file_exists($full_path)) {
			$this->session->set_flashdata('error', 'File tidak ditemukan di server!');
			redirect('admin/pengurus');
		}

		// Get file info
		$file_info = pathinfo($full_path);
		$file_name = $file_info['basename'];

		// Set headers for file display
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: inline; filename="' . $file_name . '"');
		header('Content-Length: ' . filesize($full_path));
		header('Cache-Control: public, must-revalidate');
		header('Pragma: public');

		readfile($full_path);
		exit;
	}

	// ==================== LAPORAN ====================

	public function laporan($jenis = 'data_anak')
	{
		$this->load->model('Anak_model');
		$this->load->model('Pengurus_model');

		$data['jenis'] = $jenis;
		$data['title'] = 'Laporan - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola Laporan';

		switch ($jenis) {
			case 'data_anak':
				$data['page_subtitle'] = 'Laporan Data Anak';
				$data['anak'] = $this->Anak_model->get_all_anak();
				$data['content'] = $this->load->view('admin/laporan/data_anak', $data, TRUE);
				break;

			case 'keuangan':
				$data['page_subtitle'] = 'Laporan Keuangan';
				$data['content'] = $this->load->view('admin/laporan/keuangan', $data, TRUE);
				break;

			case 'pengurus':
				$data['page_subtitle'] = 'Laporan Pengurus';
				$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
				$data['content'] = $this->load->view('admin/laporan/pengurus', $data, TRUE);
				break;

			case 'dokumen':
				$data['page_subtitle'] = 'Laporan Dokumen';
				$data['anak'] = $this->Anak_model->get_all_anak();
				$data['content'] = $this->load->view('admin/laporan/dokumen', $data, TRUE);
				break;

			case 'statistik':
				$data['page_subtitle'] = 'Laporan Statistik';
				$data['anak'] = $this->Anak_model->get_all_anak();
				$data['content'] = $this->load->view('admin/laporan/statistik', $data, TRUE);
				break;

			default:
				$data['page_subtitle'] = 'Pilih Jenis Laporan';
				$data['content'] = $this->load->view('admin/laporan/index', $data, TRUE);
				break;
		}

		$this->load->view('templates/admin_layout', $data);
	}

	// ==================== EXPORT PDF & EXCEL ====================

	public function export_pdf_anak()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_anak($data);
		$this->pdf_export->generate($html, 'laporan_data_anak_' . date('Ymd') . '.pdf', 'D');
	}

	public function export_excel_anak()
	{
		$this->load->model('Anak_model');
		$this->load->library('Excel_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$this->excel_export->export_laporan_anak($data, 'laporan_data_anak_' . date('Ymd') . '.xlsx');
	}

	public function export_pdf_pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('Pdf_export');

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_pengurus($data);
		$this->pdf_export->generate($html, 'laporan_pengurus_' . date('Ymd') . '.pdf', 'D');
	}

	public function export_excel_pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('Excel_export');

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$this->excel_export->export_laporan_pengurus($data, 'laporan_pengurus_' . date('Ymd') . '.xlsx');
	}

	public function export_pdf_dokumen()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_dokumen($data);
		$this->pdf_export->generate($html, 'laporan_dokumen_' . date('Ymd') . '.pdf', 'D');
	}

	public function export_excel_dokumen()
	{
		$this->load->model('Anak_model');
		$this->load->library('Excel_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$this->excel_export->export_laporan_dokumen($data, 'laporan_dokumen_' . date('Ymd') . '.xlsx');
	}
}
