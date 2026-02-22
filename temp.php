<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('is_logged_in')) {
			redirect('auth/login');
		}
		$this->load->helper('ip');
		$this->load->helper('logging');
	}

	public function index()
	{
		$this->load->model('Anak_model');
		$this->load->model('Pengurus_model');
		$this->load->model('User_model');

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

			if ($a->status_anak == 'Aktif')
				$anak_aktif++;
			else
				$anak_nonaktif++;

			$pend = strtolower($a->pendidikan);
			if (strpos($pend, 'sd') !== false || strpos($pend, 'mi') !== false)
				$pendidikan_sd++;
			elseif (strpos($pend, 'smp') !== false || strpos($pend, 'mts') !== false)
				$pendidikan_smp++;
			elseif (strpos($pend, 'sma') !== false || strpos($pend, 'smk') !== false || strpos($pend, 'ma') !== false)
				$pendidikan_sma++;
			elseif (strpos($pend, 'pt') !== false || strpos($pend, 'univ') !== false || strpos($pend, 'd3') !== false || strpos($pend, 's1') !== false)
				$pendidikan_pt++;

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
					'tahun_berdiri' => $this->input->post('tahun_berdiri'),
					'facebook' => $this->input->post('facebook'),
					'twitter' => $this->input->post('twitter'),
					'instagram' => $this->input->post('instagram'),
					'youtube' => $this->input->post('youtube'),
					'linkedin' => $this->input->post('linkedin'),
					'whatsapp' => $this->input->post('whatsapp')
				);

				$old_settings = $this->User_model->get_pengaturan();
				$this->User_model->update_pengaturan($data_update);
				$changes = [];
				foreach ($data_update as $key => $value) {
					if ($old_settings->$key != $value) {
						$changes[] = $key . " dari '" . $old_settings->$key . "' ke '" . $value . "'";
					}
				}
				$description = 'Memperbarui pengaturan LKSA: ' . implode(', ', $changes);
				log_activity('update_settings', $description);
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

		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->logo)) {
			$old_logo_path = FCPATH . 'assets/uploads/logos/' . $pengaturan->logo;
			if (file_exists($old_logo_path)) {
				unlink($old_logo_path);
			}
		}

		$config['upload_path'] = FCPATH . 'assets/uploads/logos/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = 2048;
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
			$description = 'Mengupload logo LKSA: ' . $logo_name;
			log_activity('upload_logo', $description);
			$this->session->set_flashdata('success', 'Logo berhasil diupload!');
		}

		redirect('admin/pengaturan');
	}

	public function upload_dokumen()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->dokumen_legal)) {
			$old_dokumen_path = FCPATH . 'assets/uploads/documents/' . $pengaturan->dokumen_legal;
			if (file_exists($old_dokumen_path)) {
				unlink($old_dokumen_path);
			}
		}

		$config['upload_path'] = FCPATH . 'assets/uploads/documents/';
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = 5120;
		$config['file_name'] = 'dokumen_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('dokumen')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$dokumen_name = $data['file_name'];
			$this->User_model->update_pengaturan(['dokumen_legal' => $dokumen_name]);
			$description = 'Mengupload dokumen legal LKSA: ' . $dokumen_name;
			log_activity('upload_dokumen', $description);
			$this->session->set_flashdata('success', 'Dokumen legal berhasil diupload!');
		}

		redirect('admin/pengaturan');
	}

	public function upload_kop()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->kop_surat)) {
			$old_kop_path = FCPATH . 'assets/uploads/kop/' . $pengaturan->kop_surat;
			if (file_exists($old_kop_path)) {
				unlink($old_kop_path);
			}
		}

		$upload_path = FCPATH . 'assets/uploads/kop/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048;
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
			$description = 'Mengupload kop surat LKSA: ' . $kop_name;
			log_activity('upload_kop', $description);
			$this->session->set_flashdata('success', 'Kop surat berhasil diupload!');
		}

		redirect('admin/pengaturan');
	}

	public function landing()
	{
		$this->load->model('User_model');
		$data['pengaturan'] = $this->User_model->get_pengaturan();
		$data['title'] = 'Kelola Landing Page - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola Landing Page';
		$data['content'] = $this->load->view('admin/landing', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function upload_hero_image()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->hero_image)) {
			$old_image_path = FCPATH . 'assets/uploads/landing/' . $pengaturan->hero_image;
			if (file_exists($old_image_path)) {
				unlink($old_image_path);
			}
		}

		$upload_path = FCPATH . 'assets/uploads/landing/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'hero_' . time();
		$config['detect_mime'] = TRUE;
		$config['xss_clean'] = TRUE;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('hero_image')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$image_name = $data['file_name'];
			$this->User_model->update_pengaturan(['hero_image' => $image_name]);
			$description = 'Mengupload gambar hero landing page: ' . $image_name;
			log_activity('upload_hero_image', $description);
			$this->session->set_flashdata('success', 'Gambar hero berhasil diupload!');
		}

		redirect('admin/landing');
	}

	public function upload_about_image()
	{
		$this->load->model('User_model');
		$this->load->library('upload');

		$pengaturan = $this->User_model->get_pengaturan();
		if (!empty($pengaturan->about_image)) {
			$old_image_path = FCPATH . 'assets/uploads/landing/' . $pengaturan->about_image;
			if (file_exists($old_image_path)) {
				unlink($old_image_path);
			}
		}

		$upload_path = FCPATH . 'assets/uploads/landing/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'about_' . time();
		$config['detect_mime'] = TRUE;
		$config['xss_clean'] = TRUE;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('about_image')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$image_name = $data['file_name'];
			$this->User_model->update_pengaturan(['about_image' => $image_name]);
			$description = 'Mengupload gambar about landing page: ' . $image_name;
			log_activity('upload_about_image', $description);
			$this->session->set_flashdata('success', 'Gambar about berhasil diupload!');
		}

		redirect('admin/landing');
	}

	public function user()
	{
		$this->load->model('User_model');
		$this->load->model('User_log_model');
		$this->load->library('form_validation');

		if ($this->input->get('delete')) {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus user!');
				redirect('admin/user');
			}
			$id = $this->input->get('delete');
			$user = $this->User_model->get_user_by_id($id);
			$this->User_model->delete_user($id);
			$description = 'Menghapus data user: nama \'' . $user->nama . '\'';
			log_activity('delete_user', $description);
			$this->session->set_flashdata('success', 'User berhasil dihapus!');
			redirect('admin/user');
		}

		if ($this->input->post()) {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengelola user!');
				redirect('admin/user');
			}
			$id = $this->input->post('id_user');

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/user');
			} else {
				if ($id) {
					// Editing
					if ($this->session->userdata('role') != 'admin' && $id != $this->session->userdata('id_user')) {
						$this->session->set_flashdata('error', 'Anda hanya bisa mengedit data diri sendiri!');
						redirect('admin/user');
					}
				} else {
					// Adding
					if ($this->session->userdata('role') != 'admin') {
						$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menambah user!');
						redirect('admin/user');
					}
				}

				$data = array(
					'nama' => $this->input->post('nama'),
					'username' => $this->input->post('username'),
					'role' => $this->input->post('role')
				);

				if ($this->input->post('password')) {
					$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				}

				if ($id) {
					$old_user = $this->User_model->get_user_by_id($id);
					$this->User_model->update_user($id, $data);
					$changes = [];
					foreach ($data as $key => $value) {
						if ($old_user->$key != $value) {
							$changes[] = $key . " dari '" . $old_user->$key . "' ke '" . $value . "'";
						}
					}
					$description = 'Mengedit data user: ' . implode(', ', $changes);
					log_activity('edit_user', $description);
					$this->session->set_flashdata('success', 'User berhasil diperbarui!');
				} else {
					if (!$this->input->post('password')) {
						$this->session->set_flashdata('error', 'Password wajib diisi untuk user baru!');
						redirect('admin/user');
					}
					$this->User_model->insert_user($data);
					$description = 'Menambahkan user baru: ' . implode(', ', array_map(function ($k, $v) {
						return $k . " '" . $v . "'";
					}, array_keys($data), $data));
					log_activity('add_user', $description);
					$this->session->set_flashdata('success', 'User berhasil ditambahkan!');
				}
				redirect('admin/user');
			}
		}

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

		if ($this->input->get('delete')) {
			$id = $this->input->get('delete');
			$anak = $this->Anak_model->get_anak_by_id($id);
			$this->Anak_model->delete_anak($id);
			$description = 'Menghapus data anak: nama_anak \'' . $anak->nama_anak . '\'';
			log_activity('delete_anak', $description);
			$this->session->set_flashdata('success', 'Data anak berhasil dihapus!');
			redirect('admin/anak');
		}

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
					$old_anak = $this->Anak_model->get_anak_by_id($id);
					$this->Anak_model->update_anak($id, $data);
					$changes = [];
					foreach ($data as $key => $value) {
						if ($old_anak->$key != $value) {
							$changes[] = $key . " dari '" . $old_anak->$key . "' ke '" . $value . "'";
						}
					}
					$description = 'Mengedit data anak: ' . implode(', ', $changes);
					log_activity('edit_anak', $description);
					$this->session->set_flashdata('success', 'Data anak berhasil diperbarui!');
				} else {
					$this->Anak_model->insert_anak($data);
					$description = 'Menambahkan data anak baru: ' . implode(', ', array_map(function ($k, $v) {
						return $k . " '" . $v . "'";
					}, array_keys($data), $data));
					log_activity('add_anak', $description);
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

		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		if (!empty($anak->file_kk)) {
			$old_filename = basename($anak->file_kk);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'kk_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_kk')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_kk($id_anak, $file_path);
			$description = 'Mengupload KK untuk anak ' . $anak->nama_anak . ': ' . $data['file_name'];
			log_activity('upload_kk', $description);
			$this->session->set_flashdata('success', 'File KK berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function upload_akta($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		if (!empty($anak->file_akta)) {
			$old_filename = basename($anak->file_akta);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'akta_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_akta')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_akta($id_anak, $file_path);
			$description = 'Mengupload akta untuk anak ' . $anak->nama_anak . ': ' . $data['file_name'];
			log_activity('upload_akta', $description);
			$this->session->set_flashdata('success', 'File Akta berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function upload_pendukung($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/dokumen_anak/' . $folder_name . '/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		if (!empty($anak->file_pendukung)) {
			$old_filename = basename($anak->file_pendukung);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'pendukung_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_pendukung')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_file_pendukung($id_anak, $file_path);
			$description = 'Mengupload dokumen pendukung untuk anak ' . $anak->nama_anak . ': ' . $data['file_name'];
			log_activity('upload_pendukung', $description);
			$this->session->set_flashdata('success', 'File pendukung berhasil diupload!');
		}

		redirect('admin/anak');
	}

	public function upload_foto($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->library('upload');

		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		$folder_name = $anak->nik ? $anak->nik . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak) : preg_replace('/[^a-zA-Z0-9]/', '_', $anak->nama_anak);
		$upload_path = FCPATH . 'assets/uploads/foto_anak/' . $folder_name . '/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		if (!empty($anak->foto)) {
			$old_filename = basename($anak->foto);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'foto_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('foto')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Anak_model->update_foto($id_anak, $file_path);
			$description = 'Mengupload foto untuk anak ' . $anak->nama_anak . ': ' . $data['file_name'];
			log_activity('upload_foto', $description);
			$this->session->set_flashdata('success', 'Foto berhasil diupload!');
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

		$file_info = pathinfo($full_path);
		$file_ext = strtolower($file_info['extension']);
		$file_name = $file_info['basename'];

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

		if ($this->input->get('delete')) {
			$id = $this->input->get('delete');
			$pengurus = $this->Pengurus_model->get_pengurus_by_id($id);
			$this->Pengurus_model->delete_pengurus($id);
			$description = 'Menghapus data pengurus: nama_pengurus \'' . $pengurus->nama_pengurus . '\'';
			log_activity('delete_pengurus', $description);
			$this->session->set_flashdata('success', 'Data pengurus berhasil dihapus!');
			redirect('admin/pengurus');
		}

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
					$old_pengurus = $this->Pengurus_model->get_pengurus_by_id($id);
					$this->Pengurus_model->update_pengurus($id, $data);
					$changes = [];
					foreach ($data as $key => $value) {
						if ($old_pengurus->$key != $value) {
							$changes[] = $key . " dari '" . $old_pengurus->$key . "' ke '" . $value . "'";
						}
					}
					$description = 'Mengedit data pengurus: ' . implode(', ', $changes);
					log_activity('edit_pengurus', $description);
					$this->session->set_flashdata('success', 'Data pengurus berhasil diperbarui!');
				} else {
					$this->Pengurus_model->insert_pengurus($data);
					$description = 'Menambahkan data pengurus baru: ' . implode(', ', array_map(function ($k, $v) {
						return $k . " '" . $v . "'";
					}, array_keys($data), $data));
					log_activity('add_pengurus', $description);
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

		$pengurus = $this->Pengurus_model->get_pengurus_by_id($id_pengurus);

		if (!$pengurus) {
			$this->session->set_flashdata('error', 'Data pengurus tidak ditemukan!');
			redirect('admin/pengurus');
		}

		$folder_name = preg_replace('/[^a-zA-Z0-9]/', '_', $pengurus->nama_pengurus);
		$upload_path = FCPATH . 'assets/uploads/dokumen_pengurus/' . $folder_name . '/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		if (!empty($pengurus->file_ktp)) {
			$old_filename = basename($pengurus->file_ktp);
			$old_file = $upload_path . $old_filename;
			if (file_exists($old_file)) {
				unlink($old_file);
			}
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'ktp_' . time();

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_ktp')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
		} else {
			$data = $this->upload->data();
			$file_path = $folder_name . '/' . $data['file_name'];
			$this->Pengurus_model->update_ktp($id_pengurus, $file_path);
			$description = 'Mengupload KTP untuk pengurus ' . $pengurus->nama_pengurus . ': ' . $data['file_name'];
			log_activity('upload_ktp', $description);
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

		$file_info = pathinfo($full_path);
		$file_name = $file_info['basename'];

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: inline; filename="' . $file_name . '"');
		header('Content-Length: ' . filesize($full_path));
		header('Cache-Control: public, must-revalidate');
		header('Pragma: public');

		readfile($full_path);
		exit;
	}

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

	public function export_pdf_anak()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_anak($data);
		$this->pdf_export->generate($html, 'laporan_data_anak_' . date('Ymd') . '.pdf', 'D');
		log_activity('export_pdf', 'Mengekspor laporan PDF data anak');
	}

	public function export_excel_anak()
	{
		$this->load->model('Anak_model');
		$this->load->library('Excel_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$this->excel_export->export_laporan_anak($data, 'laporan_data_anak_' . date('Ymd') . '.xlsx');
		log_activity('export_excel', 'Mengekspor laporan Excel data anak');
	}

	public function export_pdf_pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('Pdf_export');

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_pengurus($data);
		$this->pdf_export->generate($html, 'laporan_pengurus_' . date('Ymd') . '.pdf', 'D');
		log_activity('export_pdf_pengurus', 'Mengekspor laporan PDF data pengurus');
	}

	public function export_excel_pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('Excel_export');

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$this->excel_export->export_laporan_pengurus($data, 'laporan_pengurus_' . date('Ymd') . '.xlsx');
		log_activity('export_excel_pengurus', 'Mengekspor laporan Excel data pengurus');
	}

	public function export_pdf_dokumen()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_dokumen($data);
		$this->pdf_export->generate($html, 'laporan_dokumen_' . date('Ymd') . '.pdf', 'D');
		log_activity('export_pdf_dokumen', 'Mengekspor laporan PDF data dokumen');
	}

	public function export_pdf_statistik()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$html = $this->pdf_export->generate_laporan_statistik($data);
		$this->pdf_export->generate($html, 'laporan_statistik_' . date('Ymd') . '.pdf', 'D');
		log_activity('export_pdf_statistik', 'Mengekspor laporan PDF data statistik');
	}

	public function generate_pdf_statistik()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$genderChart = $this->input->post('genderChart');
		$ageChart = $this->input->post('ageChart');
		$educationChart = $this->input->post('educationChart');

		$data_stats = array(
			'total' => $this->input->post('total'),
			'laki' => $this->input->post('laki'),
			'perempuan' => $this->input->post('perempuan'),
			'aktif' => $this->input->post('aktif'),
			'usia_dibawah5' => $this->input->post('usia_dibawah5'),
			'usia_5_12' => $this->input->post('usia_5_12'),
			'usia_13_17' => $this->input->post('usia_13_17'),
			'usia_diatas17' => $this->input->post('usia_diatas17'),
			'pendidikan' => json_decode($this->input->post('pendidikan'), true)
		);

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');
		$data['chart_images'] = array(
			'gender' => $genderChart,
			'age' => $ageChart,
			'education' => $educationChart
		);
		$data['stats'] = $data_stats;

		$html = $this->pdf_export->generate_laporan_statistik_with_charts($data);

		$filename = 'statistik_' . time() . '.pdf';
		$temp_dir = FCPATH . 'assets/temp/';
		if (!is_dir($temp_dir)) {
			mkdir($temp_dir, 0755, true);
		}
		$filepath = $temp_dir . $filename;

		$this->pdf_export->generate_to_file($html, $filepath);

		echo json_encode(array('success' => true, 'filename' => $filename));
	}

	public function delete_temp_file()
	{
		$filename = $this->input->post('filename');
		if (!empty($filename)) {
			$filepath = FCPATH . 'assets/temp/' . $filename;
			if (file_exists($filepath)) {
				unlink($filepath);
				echo json_encode(array('success' => true));
			} else {
				echo json_encode(array('success' => false, 'message' => 'File not found'));
			}
		} else {
			echo json_encode(array('success' => false, 'message' => 'No filename provided'));
		}
	}

	public function export_excel_dokumen()
	{
		$this->load->model('Anak_model');
		$this->load->library('Excel_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$this->excel_export->export_laporan_dokumen($data, 'laporan_dokumen_' . date('Ymd') . '.xlsx');
		log_activity('export_excel_dokumen', 'Mengekspor laporan Excel data dokumen');
	}

	public function kontak()
	{
		$data = array(
			'title' => 'Kontak Pengembang - LKSA Harapan Bangsa',
			'page_title' => 'Kontak Pengembang',
			'content' => $this->load->view('admin/kontak', NULL, TRUE)
		);
		$this->load->view('templates/admin_layout', $data);
	}

	public function changelog()
	{
		$data = array(
			'title' => 'Changelog - LKSA Harapan Bangsa',
			'page_title' => 'Changelog',
			'content' => $this->load->view('admin/changelog', NULL, TRUE)
		);
		$this->load->view('templates/admin_layout', $data);
	}

	public function logs()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
			redirect('admin');
		}

		$this->load->model('User_log_model');

		// Get stats data
		$all_logs = $this->User_log_model->get_all_logs();
		$total_logs = count($all_logs);
		$login_count = count(array_filter($all_logs, function ($log) {
			return $log->activity == 'login';
		}));
		$edit_count = count(array_filter($all_logs, function ($log) {
			return strpos($log->activity, 'edit') !== false || strpos($log->activity, 'update') !== false;
		}));
		$add_count = count(array_filter($all_logs, function ($log) {
			return strpos($log->activity, 'add') !== false || strpos($log->activity, 'upload') !== false;
		}));

		$data['total_logs'] = $total_logs;
		$data['login_count'] = $login_count;
		$data['edit_count'] = $edit_count;
		$data['add_count'] = $add_count;

		$data['title'] = 'Log Aktivitas User - LKSA Harapan Bangsa';
		$data['page_title'] = 'Log Aktivitas User';
		$data['content'] = $this->load->view('admin/logs', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function logs_ajax()
	{
		if ($this->session->userdata('role') != 'admin') {
			echo json_encode(['error' => 'Access denied']);
			return;
		}

		$this->load->model('User_log_model');
		$this->load->helper('logging');

		// DataTables parameters
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$search = $this->input->post('search')['value'];

		// Ordering
		$order_column_index = $this->input->post('order')[0]['column'];
		$order_dir = $this->input->post('order')[0]['dir'];
		$columns = ['nama', 'username', 'activity', 'description', 'ip_address', 'created_at'];
		$order_column = $columns[$order_column_index] ?? 'created_at';

		// Get data
		$logs = $this->User_log_model->get_logs_datatable($start, $length, $search, $order_column, $order_dir);
		$total_records = $this->User_log_model->count_all_logs();
		$filtered_records = $this->User_log_model->count_filtered_logs($search);

		// Format data for DataTables
		$data = [];
		$no = $start + 1;
		foreach ($logs as $log) {
			$data[] = [
				$no++,
				'<div class="user-cell">
					<div class="user-avatar bg-' . ($log->role == 'admin' ? 'purple' : 'blue') . '">' .
				strtoupper(substr($log->nama, 0, 1)) . '
					</div>
					<div>
						<div class="user-name">' . $log->nama . '</div>
						<div class="user-role">' . $log->username . '</div>
					</div>
				</div>',
				'<span class="activity-badge badge-' . get_activity_color($log->activity) . '">
					<i class="fas fa-' . get_activity_icon($log->activity) . ' mr-1"></i>' .
				ucfirst($log->activity) . '
				</span>',
				$log->description,
				$log->ip_address,
				date('d/m/Y H:i:s', strtotime($log->created_at))
			];
		}

		// Response
		$response = [
			'draw' => $draw,
			'recordsTotal' => $total_records,
			'recordsFiltered' => $filtered_records,
			'data' => $data
		];

		echo json_encode($response);
	}

	public function backup()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
			redirect('admin');
		}

		if ($this->input->post('backup_database')) {
			$this->backup_database();
		} elseif ($this->input->post('backup_files')) {
			$this->backup_files();
		}

		$data['title'] = 'Backup & Restore - LKSA Harapan Bangsa';
		$data['page_title'] = 'Backup & Restore';
		$data['content'] = $this->load->view('admin/backup', NULL, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	private function backup_database()
	{
		$this->load->dbutil();
		$this->load->helper('file');

		$backup = $this->dbutil->backup(array(
			'format' => 'zip',
			'filename' => 'db_lksa_backup_' . date('Y-m-d_H-i-s') . '.sql'
		));

		$backup_path = FCPATH . 'assets/backups/database/';
		if (!is_dir($backup_path)) {
			mkdir($backup_path, 0755, TRUE);
		}

		$filename = 'db_lksa_backup_' . date('Y-m-d_H-i-s') . '.zip';
		$filepath = $backup_path . $filename;

		if (write_file($filepath, $backup)) {
			log_activity('backup_database', 'Database backup berhasil: ' . $filename);
			$this->session->set_flashdata('success', 'Database backup berhasil! File: ' . $filename);
		} else {
			$this->session->set_flashdata('error', 'Gagal membuat database backup!');
		}

		redirect('admin/backup');
	}

	private function backup_files()
	{
		$this->load->library('zip');
		$this->load->helper('file');

		$backup_path = FCPATH . 'assets/backups/files/';
		if (!is_dir($backup_path)) {
			mkdir($backup_path, 0755, TRUE);
		}

		// Add uploads directory to zip
		$upload_path = FCPATH . 'assets/uploads/';
		$this->zip->read_dir($upload_path, FALSE);

		$filename = 'files_backup_' . date('Y-m-d_H-i-s') . '.zip';
		$filepath = $backup_path . $filename;

		if ($this->zip->archive($filepath)) {
			log_activity('backup_files', 'File backup berhasil: ' . $filename);
			$this->session->set_flashdata('success', 'File backup berhasil! File: ' . $filename);
		} else {
			$this->session->set_flashdata('error', 'Gagal membuat file backup!');
		}

		redirect('admin/backup');
	}

	public function download_backup($type, $filename)
	{
		if ($this->session->userdata('role') != 'admin') {
			show_error('Access denied', 403);
		}

		$backup_path = FCPATH . 'assets/backups/' . $type . '/' . $filename;

		if (!file_exists($backup_path)) {
			show_error('File tidak ditemukan', 404);
		}

		$this->load->helper('download');
		force_download($backup_path, NULL);
		log_activity('download_backup', 'Download backup: ' . $type . '/' . $filename);
	}

	public function restore_database()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk melakukan restore!');
			redirect('admin/backup');
		}

		$this->load->library('upload');

		$config['upload_path'] = FCPATH . 'assets/temp/';
		$config['allowed_types'] = 'sql';
		$config['max_size'] = 10240; // 10MB
		$config['file_name'] = 'restore_db_' . time() . '.sql';

		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, TRUE);
		}

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('db_file')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('admin/backup');
		} else {
			$data = $this->upload->data();
			$file_path = $data['full_path'];

			// Read SQL file
			$sql = file_get_contents($file_path);

			// Execute SQL
			$this->load->database();
			$queries = array_filter(array_map('trim', explode(';', $sql)));

			$this->db->trans_start();

			foreach ($queries as $query) {
				if (!empty($query)) {
					$this->db->query($query);
				}
			}

			$this->db->trans_complete();

			// Clean up
			unlink($file_path);

			if ($this->db->trans_status() === FALSE) {
				$this->session->set_flashdata('error', 'Restore database gagal! Periksa file SQL.');
			} else {
				log_activity('restore_database', 'Restore database dari file: ' . $data['file_name']);
				$this->session->set_flashdata('success', 'Database berhasil direstore!');
			}

			redirect('admin/backup');
		}
	}

	public function restore_files()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk melakukan restore!');
			redirect('admin/backup');
		}

		$this->load->library('upload');

		$config['upload_path'] = FCPATH . 'assets/temp/';
		$config['allowed_types'] = 'zip';
		$config['max_size'] = 51200; // 50MB
		$config['file_name'] = 'restore_files_' . time() . '.zip';

		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, TRUE);
		}

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('files_zip')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('admin/backup');
		} else {
			$data = $this->upload->data();
			$zip_path = $data['full_path'];
			$extract_path = FCPATH . 'assets/uploads/';

			// Load zip library
			$this->load->library('zip');
			$this->zip->read_file($zip_path);

			// Extract to uploads directory
			if ($this->zip->extract($extract_path)) {
				log_activity('restore_files', 'Restore files dari file: ' . $data['file_name']);
				$this->session->set_flashdata('success', 'Files berhasil direstore!');
			} else {
				$this->session->set_flashdata('error', 'Restore files gagal! Periksa file ZIP.');
			}

			// Clean up
			unlink($zip_path);

			redirect('admin/backup');
		}
	}
}
public function carousel()
{
if ($this->session->userdata('role') != 'admin') {
$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
redirect('admin');
}

$this->load->model('Carousel_model');
$data['carousel_images'] = $this->Carousel_model->get_all_carousel_images();
$data['title'] = 'Kelola Carousel Landing Page - LKSA Harapan Bangsa';
$data['page_title'] = 'Kelola Carousel';
$data['content'] = $this->load->view('admin/carousel', $data, TRUE);
$this->load->view('templates/admin_layout', $data);
}

public function upload_carousel_image()
{
if ($this->session->userdata('role') != 'admin') {
$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupload gambar!');
redirect('admin/carousel');
}

$this->load->model('Carousel_model');
$this->load->library('upload');

$upload_path = FCPATH . 'assets/uploads/landing/';
if (!is_dir($upload_path)) {
mkdir($upload_path, 0755, TRUE);
}

$config['upload_path'] = $upload_path;
$config['allowed_types'] = 'jpg|jpeg|png';
$config['max_size'] = 2048;
$config['file_name'] = 'carousel_' . time();
$config['detect_mime'] = TRUE;
$config['xss_clean'] = TRUE;

$this->upload->initialize($config);

if (!$this->upload->do_upload('carousel_image')) {
$this->session->set_flashdata('error', $this->upload->display_errors());
} else {
$data = $this->upload->data();
$image_name = $data['file_name'];

$carousel_data = array(
'image_name' => $image_name,
'title' => $this->input->post('title'),
'description' => $this->input->post('description'),
'sort_order' => $this->input->post('sort_order') ?: 0,
'is_active' => 1
);

$this->Carousel_model->insert_carousel_image($carousel_data);
$description = 'Mengupload gambar carousel: ' . $image_name;
log_activity('upload_carousel_image', $description);
$this->session->set_flashdata('success', 'Gambar carousel berhasil diupload!');
}

redirect('admin/carousel');
}

public function update_carousel_image($id)
{
if ($this->session->userdata('role') != 'admin') {
$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupdate gambar!');
redirect('admin/carousel');
}

$this->load->model('Carousel_model');

$update_data = array(
'title' => $this->input->post('title'),
'description' => $this->input->post('description'),
'sort_order' => $this->input->post('sort_order') ?: 0,
'is_active' => $this->input->post('is_active') ? 1 : 0
);

$this->Carousel_model->update_carousel_image($id, $update_data);
$description = 'Mengupdate gambar carousel ID: ' . $id;
log_activity('update_carousel_image', $description);
$this->session->set_flashdata('success', 'Gambar carousel berhasil diperbarui!');

redirect('admin/carousel');
}

public function delete_carousel_image($id)
{
if ($this->session->userdata('role') != 'admin') {
$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus gambar!');
redirect('admin/carousel');
}

$this->load->model('Carousel_model');
$image = $this->Carousel_model->get_carousel_image_by_id($id);

if ($image) {
// Delete file from server
$file_path = FCPATH . 'assets/uploads/landing/' . $image->image_name;
if (file_exists($file_path)) {
unlink($file_path);
}

// Delete from database
$this->Carousel_model->delete_carousel_image($id);
$description = 'Menghapus gambar carousel: ' . $image->image_name;
log_activity('delete_carousel_image', $description);
$this->session->set_flashdata('success', 'Gambar carousel berhasil dihapus!');
} else {
$this->session->set_flashdata('error', 'Gambar carousel tidak ditemukan!');
}

redirect('admin/carousel');
}

public function update_carousel_sort_order()
{
if ($this->session->userdata('role') != 'admin') {
echo json_encode(['success' => false, 'message' => 'Access denied']);
return;
}

$this->load->model('Carousel_model');

$sort_data = $this->input->post('sort_data');
if (!empty($sort_data)) {
foreach ($sort_data as $id => $sort_order) {
$this->Carousel_model->update_sort_order($id, $sort_order);
}
log_activity('update_carousel_sort_order', 'Mengupdate urutan gambar carousel');
echo json_encode(['success' => true]);
} else {
echo json_encode(['success' => false, 'message' => 'No data provided']);
}
}
}
