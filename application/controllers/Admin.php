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

		if (in_array($this->session->userdata('role'), array('guru', 'pengajar'), TRUE)) {
			redirect('guru');
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
		$anak_terbaru = $this->Anak_model->get_all_anak('created_at', 'DESC');
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
		$pendidikan_tk = 0;
		$anak_baru = 0;

		// Category counts
		$kategori_yatim = 0;
		$kategori_piatu = 0;
		$kategori_yatim_piatu = 0;
		$kategori_dhuafa = 0;
		$kategori_fakir_miskin = 0;
		$kategori_ibnu_sabil = 0;
		$kategori_laqith = 0;

		$today = new DateTime();
		$one_month_ago = $today->modify('-1 month');

		foreach ($anak as $a) {
			if ($a->jenis_kelamin == 'L')
				$anak_laki++;
			else
				$anak_perempuan++;

			if (strtolower($a->status_tinggal) == 'sekolah')
				$anak_sekolah++;
			elseif (strtolower($a->status_tinggal) == 'tinggal di lksa')
				$anak_asrama++;
			elseif (strtolower($a->status_tinggal) == 'perawatan')
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
			if ($pend == 'tk')
				$pendidikan_tk++;
			elseif (strpos($pend, 'sd') !== false || strpos($pend, 'mi') !== false)
				$pendidikan_sd++;
			elseif (strpos($pend, 'smp') !== false || strpos($pend, 'mts') !== false)
				$pendidikan_smp++;
			elseif (strpos($pend, 'sma') !== false || strpos($pend, 'smk') !== false || strpos($pend, 'ma') !== false)
				$pendidikan_sma++;
			elseif (strpos($pend, 'pt') !== false || strpos($pend, 'univ') !== false || strpos($pend, 'd3') !== false || strpos($pend, 's1') !== false)
				$pendidikan_pt++;

			// Category counting
			switch ($a->kategori) {
				case 'Yatim':
					$kategori_yatim++;
					break;
				case 'Piatu':
					$kategori_piatu++;
					break;
				case 'Yatim Piatu':
					$kategori_yatim_piatu++;
					break;
				case 'Dhuafa':
					$kategori_dhuafa++;
					break;
				case 'Fakir dan Miskin':
					$kategori_fakir_miskin++;
					break;
				case 'Ibnu Sabil':
					$kategori_ibnu_sabil++;
					break;
				case 'Laqith':
					$kategori_laqith++;
					break;
			}

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
			'pendidikan_tk' => $pendidikan_tk,
			'anak_baru' => $anak_baru,
			'anak_terbaru' => array_slice($anak_terbaru, 0, 5),
			'pengurus_terbaru' => array_slice($pengurus, 0, 5),
			// Category counts
			'kategori_yatim' => $kategori_yatim,
			'kategori_piatu' => $kategori_piatu,
			'kategori_yatim_piatu' => $kategori_yatim_piatu,
			'kategori_dhuafa' => $kategori_dhuafa,
			'kategori_fakir_miskin' => $kategori_fakir_miskin,
			'kategori_ibnu_sabil' => $kategori_ibnu_sabil,
			'kategori_laqith' => $kategori_laqith,
			// Chart data for education
			'chart_pendidikan_labels' => ['TK', 'SD/MI', 'SMP/MTS', 'SMA/SMK', 'Perguruan Tinggi'],
			'chart_pendidikan_data' => [$pendidikan_tk, $pendidikan_sd, $pendidikan_smp, $pendidikan_sma, $pendidikan_pt],
			// Chart data for categories
			'chart_kategori_labels' => ['Yatim', 'Piatu', 'Yatim Piatu', 'Dhuafa', 'Fakir dan Miskin', 'Ibnu Sabil', 'Laqith'],
			'chart_kategori_data' => [$kategori_yatim, $kategori_piatu, $kategori_yatim_piatu, $kategori_dhuafa, $kategori_fakir_miskin, $kategori_ibnu_sabil, $kategori_laqith]
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
			$available_roles = $this->User_model->get_user_roles();
			$role_in_list = implode(',', $available_roles);

			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('role', 'Role', 'required|in_list[' . $role_in_list . ']');

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
		$data['available_roles'] = $this->User_model->get_user_roles();
		$data['edit_user'] = $edit_user;
		$data['title'] = 'Kelola User - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola User';
		$data['content'] = $this->load->view('admin/user', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_master()
	{
		$this->load->model('Character_master_model');
		$this->load->library('form_validation');

		if ($this->input->get('delete_scale')) {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus skala!');
				redirect('admin/penilaian-karakter/master');
			}

			$id_scale = (int) $this->input->get('delete_scale');
			$scale = $this->Character_master_model->get_scale_by_id($id_scale);

			if (!$scale) {
				$this->session->set_flashdata('error', 'Data skala tidak ditemukan.');
				redirect('admin/penilaian-karakter/master');
			}

			$this->Character_master_model->delete_scale($id_scale);
			log_activity('delete_character_scale', 'Menghapus skala penilaian karakter: skor ' . $scale->score . ' - ' . $scale->category);
			$this->session->set_flashdata('success', 'Skala penilaian berhasil dihapus.');
			redirect('admin/penilaian-karakter/master');
		}

		if ($this->input->post('form_type') === 'scale') {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengelola skala!');
				redirect('admin/penilaian-karakter/master');
			}

			$id_scale = (int) $this->input->post('id_scale');
			$score = (int) $this->input->post('score');
			$category = trim((string) $this->input->post('category'));
			$description = trim((string) $this->input->post('description'));

			$this->form_validation->set_rules('score', 'Skor', 'required|integer');
			$this->form_validation->set_rules('category', 'Kategori', 'required|min_length[3]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/penilaian-karakter/master');
			}

			if ($score < 1) {
				$this->session->set_flashdata('error', 'Skor minimal bernilai 1.');
				redirect('admin/penilaian-karakter/master');
			}

			if ($this->Character_master_model->is_scale_score_exists($score, $id_scale ?: null)) {
				$this->session->set_flashdata('error', 'Skor sudah digunakan. Gunakan nilai skor lain.');
				redirect('admin/penilaian-karakter/master');
			}

			$payload = array(
				'score' => $score,
				'category' => $category,
				'description' => $description
			);

			if ($id_scale > 0) {
				$old = $this->Character_master_model->get_scale_by_id($id_scale);
				if (!$old) {
					$this->session->set_flashdata('error', 'Data skala tidak ditemukan.');
					redirect('admin/penilaian-karakter/master');
				}

				$this->Character_master_model->update_scale($id_scale, $payload);
				log_activity('update_character_scale', 'Memperbarui skala penilaian karakter: skor ' . $old->score . ' - ' . $old->category);
				$this->session->set_flashdata('success', 'Skala penilaian berhasil diperbarui.');
			} else {
				$this->Character_master_model->insert_scale($payload);
				log_activity('add_character_scale', 'Menambahkan skala penilaian karakter: skor ' . $score . ' - ' . $category);
				$this->session->set_flashdata('success', 'Skala penilaian berhasil ditambahkan.');
			}

			redirect('admin/penilaian-karakter/master');
		}

		if ($this->input->get('delete_aspect')) {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus aspek!');
				redirect('admin/penilaian-karakter/master');
			}

			$id_aspect = (int) $this->input->get('delete_aspect');
			$aspect = $this->Character_master_model->get_aspect_by_id($id_aspect);

			if (!$aspect) {
				$this->session->set_flashdata('error', 'Data aspek tidak ditemukan.');
				redirect('admin/penilaian-karakter/master');
			}

			$this->Character_master_model->delete_aspect($id_aspect);
			log_activity('delete_character_aspect', 'Menghapus aspek penilaian karakter: ' . $aspect->aspect_name . ' (' . $aspect->aspect_code . ')');
			$this->session->set_flashdata('success', 'Aspek penilaian berhasil dihapus.');
			redirect('admin/penilaian-karakter/master');
		}

		if ($this->input->post('form_type') === 'aspect') {
			if ($this->session->userdata('role') != 'admin') {
				$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengelola aspek!');
				redirect('admin/penilaian-karakter/master');
			}

			$id_aspect = (int) $this->input->post('id_aspect');
			$aspect_name = trim($this->input->post('aspect_name'));
			$aspect_code = strtoupper(trim($this->input->post('aspect_code')));
			$description = trim((string) $this->input->post('description'));
			$order = (int) $this->input->post('order');

			$this->form_validation->set_rules('aspect_name', 'Nama Aspek', 'required|min_length[3]');
			$this->form_validation->set_rules('aspect_code', 'Kode Aspek', 'required|min_length[3]|max_length[50]|regex_match[/^[A-Za-z0-9_]+$/]');
			$this->form_validation->set_rules('order', 'Urutan', 'required|integer');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/penilaian-karakter/master');
			}

			if ($this->Character_master_model->is_aspect_code_exists($aspect_code, $id_aspect ?: null)) {
				$this->session->set_flashdata('error', 'Kode aspek sudah digunakan. Gunakan kode lain.');
				redirect('admin/penilaian-karakter/master');
			}

			$payload = array(
				'aspect_name' => $aspect_name,
				'aspect_code' => $aspect_code,
				'description' => $description,
				'order' => $order
			);

			if ($id_aspect > 0) {
				$old = $this->Character_master_model->get_aspect_by_id($id_aspect);
				if (!$old) {
					$this->session->set_flashdata('error', 'Data aspek tidak ditemukan.');
					redirect('admin/penilaian-karakter/master');
				}

				$this->Character_master_model->update_aspect($id_aspect, $payload);
				log_activity('update_character_aspect', 'Memperbarui aspek penilaian karakter: ' . $old->aspect_name . ' (' . $old->aspect_code . ')');
				$this->session->set_flashdata('success', 'Aspek penilaian berhasil diperbarui.');
			} else {
				$this->Character_master_model->insert_aspect($payload);
				log_activity('add_character_aspect', 'Menambahkan aspek penilaian karakter: ' . $aspect_name . ' (' . $aspect_code . ')');
				$this->session->set_flashdata('success', 'Aspek penilaian berhasil ditambahkan.');
			}

			redirect('admin/penilaian-karakter/master');
		}

		$master_data = array(
			'scales' => $this->Character_master_model->get_scales(),
			'aspects' => $this->Character_master_model->get_aspects_with_indicator_count(),
			'total_indicators' => $this->Character_master_model->count_indicators()
		);

		$data = array(
			'title' => 'Master Penilaian Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Master Penilaian Karakter',
			'content' => $this->load->view('admin/penilaian_master', $master_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_data()
	{
		$this->load->model('Character_assessment_model');
		$this->load->library('pagination');

		$per_page = 20;
		$total_rows = (int) $this->Character_assessment_model->count_assessments();
		$offset = (int) $this->input->get('per_page', TRUE);
		if ($offset < 0) {
			$offset = 0;
		}
		if ($offset >= $total_rows && $total_rows > 0) {
			$offset = (int) (floor(($total_rows - 1) / $per_page) * $per_page);
		}

		$pagination_config = array(
			'base_url' => site_url('admin/penilaian-karakter/data-penilaian'),
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'page_query_string' => TRUE,
			'query_string_segment' => 'per_page',
			'reuse_query_string' => TRUE,
			'full_tag_open' => '<nav><ul class="pagination pagination-sm mb-0">',
			'full_tag_close' => '</ul></nav>',
			'num_tag_open' => '<li class="page-item">',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close' => '</span></li>',
			'next_tag_open' => '<li class="page-item">',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li class="page-item">',
			'prev_tag_close' => '</li>',
			'first_tag_open' => '<li class="page-item">',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li class="page-item">',
			'last_tag_close' => '</li>',
			'attributes' => array('class' => 'page-link')
		);
		$this->pagination->initialize($pagination_config);

		$raw_rows = $this->Character_assessment_model->get_assessments($per_page, $offset);
		$rows = array();
		foreach ($raw_rows as $r) {
			$rows[] = array(
				$r->id_assessment,
				$r->nama_anak ?: '-',
				$r->assessor_name ?: '-',
				$r->assessor_type ?: '-',
				$r->assessment_date ?: '-',
				($r->week_number ?: '-') . ' / ' . ($r->month ?: '-') . ' / ' . ($r->year ?: '-'),
				ucfirst($r->status ?: '-')
			);
		}

		$view_data = array(
			'heading' => 'Data Penilaian Karakter',
			'subheading' => 'Tabel utama penilaian karakter (character_assessments)',
			'icon_class' => 'fa-clipboard-list',
			'table_icon' => 'fa-table',
			'table_title' => 'Daftar Penilaian',
			'columns' => array('ID', 'Nama Anak', 'Assessor', 'Tipe Assessor', 'Tanggal', 'Minggu / Bulan / Tahun', 'Status'),
			'rows' => $rows,
			'pagination_links' => $this->pagination->create_links(),
			'empty_message' => 'Belum ada data penilaian karakter.',
			'stat_cards' => array(
				array('label' => 'Total Penilaian', 'value' => $total_rows, 'icon' => 'fa-clipboard-list', 'class' => 'stat-blue'),
				array('label' => 'Data Ditampilkan', 'value' => count($rows), 'icon' => 'fa-table', 'class' => 'stat-green'),
				array('label' => 'Status Aktif', 'value' => 'Master Data', 'icon' => 'fa-database', 'class' => 'stat-orange')
			)
		);

		$data = array(
			'title' => 'Data Penilaian Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Data Penilaian Karakter',
			'content' => $this->load->view('admin/penilaian_table', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_detail()
	{
		$this->load->model('Character_assessment_model');
		$this->load->library('pagination');

		$per_page = 20;
		$total_rows = (int) $this->Character_assessment_model->count_details();
		$offset = (int) $this->input->get('per_page', TRUE);
		if ($offset < 0) {
			$offset = 0;
		}
		if ($offset >= $total_rows && $total_rows > 0) {
			$offset = (int) (floor(($total_rows - 1) / $per_page) * $per_page);
		}

		$pagination_config = array(
			'base_url' => site_url('admin/penilaian-karakter/detail-penilaian'),
			'total_rows' => $total_rows,
			'per_page' => $per_page,
			'page_query_string' => TRUE,
			'query_string_segment' => 'per_page',
			'reuse_query_string' => TRUE,
			'full_tag_open' => '<nav><ul class="pagination pagination-sm mb-0">',
			'full_tag_close' => '</ul></nav>',
			'num_tag_open' => '<li class="page-item">',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close' => '</span></li>',
			'next_tag_open' => '<li class="page-item">',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li class="page-item">',
			'prev_tag_close' => '</li>',
			'first_tag_open' => '<li class="page-item">',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li class="page-item">',
			'last_tag_close' => '</li>',
			'attributes' => array('class' => 'page-link')
		);
		$this->pagination->initialize($pagination_config);

		$raw_rows = $this->Character_assessment_model->get_assessment_details($per_page, $offset);
		$rows = array();
		foreach ($raw_rows as $r) {
			$rows[] = array(
				$r->id_assessment,
				$r->nama_anak ?: '-',
				$r->aspect_name ?: '-',
				$r->indicator_name ?: '-',
				(isset($r->score) ? $r->score : '-'),
				$r->assessment_date ?: '-'
			);
		}

		$view_data = array(
			'heading' => 'Detail Skor Penilaian',
			'subheading' => 'Detail skor per indikator (character_assessment_details)',
			'icon_class' => 'fa-list-alt',
			'table_icon' => 'fa-tasks',
			'table_title' => 'Daftar Detail Penilaian',
			'columns' => array('ID Penilaian', 'Nama Anak', 'Aspek', 'Indikator', 'Skor', 'Tanggal Penilaian'),
			'rows' => $rows,
			'pagination_links' => $this->pagination->create_links(),
			'empty_message' => 'Belum ada detail skor penilaian.',
			'stat_cards' => array(
				array('label' => 'Total Detail', 'value' => $total_rows, 'icon' => 'fa-list-alt', 'class' => 'stat-blue'),
				array('label' => 'Data Ditampilkan', 'value' => count($rows), 'icon' => 'fa-table', 'class' => 'stat-green'),
				array('label' => 'Tipe Data', 'value' => 'Indikator', 'icon' => 'fa-layer-group', 'class' => 'stat-orange')
			)
		);

		$data = array(
			'title' => 'Detail Penilaian Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Detail Penilaian Karakter',
			'content' => $this->load->view('admin/penilaian_table', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_catatan()
	{
		$this->load->model('Character_assessment_model');

		$raw_rows = $this->Character_assessment_model->get_qualitative_notes();
		$rows = array();
		foreach ($raw_rows as $r) {
			$rows[] = array(
				$r->id_note,
				$r->id_assessment,
				$r->nama_anak ?: '-',
				$r->assessor_name ?: '-',
				substr(strip_tags((string) $r->strengths), 0, 80) ?: '-',
				substr(strip_tags((string) $r->areas_to_support), 0, 80) ?: '-'
			);
		}

		$view_data = array(
			'heading' => 'Catatan Kualitatif',
			'subheading' => 'Catatan pengamatan perkembangan karakter (character_qualitative_notes)',
			'icon_class' => 'fa-sticky-note',
			'table_icon' => 'fa-clipboard',
			'table_title' => 'Daftar Catatan Kualitatif',
			'columns' => array('ID Catatan', 'ID Penilaian', 'Nama Anak', 'Assessor', 'Kekuatan', 'Area Dukungan'),
			'rows' => $rows,
			'empty_message' => 'Belum ada catatan kualitatif.',
			'stat_cards' => array(
				array('label' => 'Total Catatan', 'value' => $this->Character_assessment_model->count_notes(), 'icon' => 'fa-sticky-note', 'class' => 'stat-blue'),
				array('label' => 'Data Ditampilkan', 'value' => count($rows), 'icon' => 'fa-table', 'class' => 'stat-green'),
				array('label' => 'Jenis Data', 'value' => 'Kualitatif', 'icon' => 'fa-file-alt', 'class' => 'stat-orange')
			)
		);

		$data = array(
			'title' => 'Catatan Kualitatif Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Catatan Kualitatif Karakter',
			'content' => $this->load->view('admin/penilaian_table', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_ringkasan_mingguan()
	{
		$this->load->model('Character_assessment_model');

		$raw_rows = $this->Character_assessment_model->get_weekly_summary();
		$rows = array();
		foreach ($raw_rows as $r) {
			$rows[] = array(
				$r->id_summary,
				$r->nama_anak ?: '-',
				$r->aspect_name ?: '-',
				$r->week_number ?: '-',
				$r->year ?: '-',
				number_format((float) $r->avg_score, 2),
				$r->assessor_type ?: '-'
			);
		}

		$view_data = array(
			'heading' => 'Ringkasan Mingguan',
			'subheading' => 'Ringkasan nilai mingguan per anak dan aspek (character_weekly_summary)',
			'icon_class' => 'fa-calendar-week',
			'table_icon' => 'fa-calendar-week',
			'table_title' => 'Daftar Ringkasan Mingguan',
			'columns' => array('ID', 'Nama Anak', 'Aspek', 'Minggu', 'Tahun', 'Rata-rata', 'Tipe Assessor'),
			'rows' => $rows,
			'empty_message' => 'Belum ada ringkasan mingguan.',
			'stat_cards' => array(
				array('label' => 'Total Ringkasan', 'value' => $this->Character_assessment_model->count_weekly_summary(), 'icon' => 'fa-calendar-week', 'class' => 'stat-blue'),
				array('label' => 'Data Ditampilkan', 'value' => count($rows), 'icon' => 'fa-table', 'class' => 'stat-green'),
				array('label' => 'Periode', 'value' => 'Mingguan', 'icon' => 'fa-clock', 'class' => 'stat-orange')
			)
		);

		$data = array(
			'title' => 'Ringkasan Mingguan Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Ringkasan Mingguan Karakter',
			'content' => $this->load->view('admin/penilaian_table', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_ringkasan_bulanan()
	{
		$this->load->model('Character_assessment_model');

		$raw_rows = $this->Character_assessment_model->get_monthly_summary();
		$rows = array();
		foreach ($raw_rows as $r) {
			$rows[] = array(
				$r->id_summary,
				$r->nama_anak ?: '-',
				$r->aspect_name ?: '-',
				$r->month ?: '-',
				$r->year ?: '-',
				number_format((float) $r->avg_score, 2),
				$r->assessor_type ?: '-'
			);
		}

		$view_data = array(
			'heading' => 'Ringkasan Bulanan',
			'subheading' => 'Ringkasan nilai bulanan per anak dan aspek (character_monthly_summary)',
			'icon_class' => 'fa-calendar-alt',
			'table_icon' => 'fa-calendar-alt',
			'table_title' => 'Daftar Ringkasan Bulanan',
			'columns' => array('ID', 'Nama Anak', 'Aspek', 'Bulan', 'Tahun', 'Rata-rata', 'Tipe Assessor'),
			'rows' => $rows,
			'empty_message' => 'Belum ada ringkasan bulanan.',
			'stat_cards' => array(
				array('label' => 'Total Ringkasan', 'value' => $this->Character_assessment_model->count_monthly_summary(), 'icon' => 'fa-calendar-alt', 'class' => 'stat-blue'),
				array('label' => 'Data Ditampilkan', 'value' => count($rows), 'icon' => 'fa-table', 'class' => 'stat-green'),
				array('label' => 'Periode', 'value' => 'Bulanan', 'icon' => 'fa-clock', 'class' => 'stat-orange')
			)
		);

		$data = array(
			'title' => 'Ringkasan Bulanan Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Ringkasan Bulanan Karakter',
			'content' => $this->load->view('admin/penilaian_table', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_laporan()
	{
		$this->load->model('Character_assessment_model');
		$this->load->model('Character_master_model');
		$this->load->model('Anak_model');
		$this->load->helper('tanggal');

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

		$summary_rows = $this->Character_assessment_model->get_child_progress_summary($filters);
		$aspect_scores_rows = $this->Character_assessment_model->get_child_aspect_scores($filters);
		$overall_aspect_trend_rows = $this->Character_assessment_model->get_overall_aspect_trend($filters);
		$children = $this->Anak_model->get_all_anak('nama_anak', 'ASC');
		$aspects = $this->Character_master_model->get_aspects_with_indicator_count();

		$overall_avg = 0;
		if (!empty($summary_rows)) {
			$total = 0;
			foreach ($summary_rows as $r) {
				$total += (float) $r->avg_score;
			}
			$overall_avg = $total / count($summary_rows);
		}

		$period_label = '';
		if ($period_type === 'weekly') {
			$period_label = 'Minggu ke-' . $week . ' Tahun ' . $year;
		} elseif ($period_type === 'monthly') {
			$period_label = bulan_indo($month) . ' ' . $year;
		} else {
			$period_label = tanggal_indo($start_date) . ' s/d ' . tanggal_indo($end_date);
		}

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
		$assessed_children = 0;
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
				$assessed_children++;
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

		$radar_labels = array();
		$radar_scores = array();
		foreach ($aspects as $aspect) {
			$id_aspect = (int) $aspect->id_aspect;
			$total_aspect_score = 0;
			$total_aspect_count = 0;
			foreach ($table_rows as $row) {
				$score = $row['aspect_scores'][$id_aspect] ?? null;
				if ($score !== null) {
					$total_aspect_score += (float) $score;
					$total_aspect_count++;
				}
			}

			$radar_labels[] = $aspect->aspect_name;
			$radar_scores[] = $total_aspect_count > 0 ? round($total_aspect_score / $total_aspect_count, 2) : 0;
		}

		$trend_dates = array();
		$trend_map = array();
		foreach ($overall_aspect_trend_rows as $row) {
			$date_key = $row->assessment_date;
			if (!in_array($date_key, $trend_dates, true)) {
				$trend_dates[] = $date_key;
			}

			$id_aspect = (int) $row->id_aspect;
			if (!isset($trend_map[$id_aspect])) {
				$trend_map[$id_aspect] = array(
					'label' => $row->aspect_name,
					'points' => array()
				);
			}

			$trend_map[$id_aspect]['points'][$date_key] = round((float) $row->avg_score, 2);
		}

		$trend_labels = array_map(function ($date) {
			return date('d-m-Y', strtotime($date));
		}, $trend_dates);

		$aspect_trend_chart_data = array();
		foreach ($trend_map as $id_aspect => $aspect_data) {
			$series = array();
			foreach ($trend_dates as $date_key) {
				$series[] = array_key_exists($date_key, $aspect_data['points'])
					? $aspect_data['points'][$date_key]
					: null;
			}

			$aspect_trend_chart_data[$id_aspect] = array(
				'labels' => $trend_labels,
				'datasets' => array(
					array(
						'label' => $aspect_data['label'],
						'data' => $series
					)
				)
			);
		}

		$query_params = http_build_query($filters);

		$view_data = array(
			'period_type' => $period_type,
			'year' => $year,
			'week' => $week,
			'month' => $month,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'period_label' => $period_label,
			'summary_rows' => $summary_rows,
			'aspects' => $aspects,
			'table_rows' => $table_rows,
			'total_children' => count($children),
			'assessed_children' => $assessed_children,
			'need_support_count' => $need_support_count,
			'overall_avg' => $overall_avg,
			'total_assessments' => array_sum(array_map(function ($r) {
				return (int) ($r['total_penilaian'] ?? 0);
			}, $table_rows)),
			'radar_labels' => $radar_labels,
			'radar_scores' => $radar_scores,
			'aspect_trend_chart_data' => $aspect_trend_chart_data,
			'years' => range(date('Y') + 1, date('Y') - 10),
			'export_url' => site_url('admin/export_pdf_karakter?' . $query_params)
		);

		$data = array(
			'title' => 'Laporan Karakter - LKSA Harapan Bangsa',
			'page_title' => 'Laporan Karakter',
			'content' => $this->load->view('admin/penilaian_laporan', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_laporan_detail($id_anak = 0)
	{
		$this->load->model('Anak_model');
		$this->load->model('Character_master_model');
		$this->load->model('Character_assessment_model');
		$this->load->helper('tanggal');

		$id_anak = (int) $id_anak;
		$anak = $this->Anak_model->get_anak_by_id($id_anak);
		if (!$anak) {
			$this->session->set_flashdata('error', 'Data anak tidak ditemukan.');
			redirect('admin/penilaian-karakter/laporan');
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
			? $this->Character_assessment_model->get_child_indicator_scores($id_anak, $filters)
			: array();

		$indicator_trend_rows = $schema_ready
			? $this->Character_assessment_model->get_child_indicator_trend($id_anak, $filters)
			: array();

		$history_rows = $schema_ready
			? $this->Character_assessment_model->get_child_assessment_history($id_anak, $filters, 30)
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
			'back_url' => site_url('admin/penilaian-karakter/laporan?' . http_build_query($filters))
		);

		$data = array(
			'title' => 'Detail Laporan Karakter Anak - LKSA Harapan Bangsa',
			'page_title' => 'Detail Laporan Karakter Anak',
			'content' => $this->load->view('admin/penilaian_laporan_detail', $view_data, TRUE)
		);

		$this->load->view('templates/admin_layout', $data);
	}

	public function penilaian_karakter_laporan_detail_export_pdf($id_anak = 0)
	{
		$this->load->model('Anak_model');
		$this->load->model('Character_assessment_model');
		$this->load->helper('tanggal');
		$this->load->library('Pdf_export');

		$id_anak = (int) $id_anak;
		$anak = $this->Anak_model->get_anak_by_id($id_anak);
		if (!$anak) {
			$this->session->set_flashdata('error', 'Data anak tidak ditemukan.');
			redirect('admin/penilaian-karakter/laporan');
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
			? $this->Character_assessment_model->get_child_indicator_scores($id_anak, $filters)
			: array();

		$history_rows = $schema_ready
			? $this->Character_assessment_model->get_child_assessment_history($id_anak, $filters, 30)
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

		$html = $this->load->view('admin/penilaian_laporan_detail_pdf', $pdf_data, true);
		$filename = 'laporan_karakter_admin_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($anak->nama_anak)) . '_' . date('Ymd_His') . '.pdf';
		$this->pdf_export->generate($html, $filename, 'D');
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
			$this->form_validation->set_rules('agama', 'Agama', 'required');
			$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
			$this->form_validation->set_rules('status_anak', 'Status Anak', 'required');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required');
			$this->form_validation->set_rules('status_tinggal', 'Status Tinggal', 'required');
			$this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('admin/anak');
			} else {
				$data = array(
					'nama_anak' => $this->input->post('nama_anak'),
					'nik' => $this->input->post('nik'),
					'no_kk' => $this->input->post('no_kk'),
					'no_registrasi' => $this->input->post('no_registrasi'),
					'jenis_kelamin' => $this->input->post('jenis_kelamin'),
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'agama' => $this->input->post('agama'),
					'kewarganegaraan' => $this->input->post('kewarganegaraan'),
					'anak_ke' => $this->input->post('anak_ke'),
					'jumlah_saudara_kandung' => $this->input->post('jumlah_saudara_kandung'),
					'jumlah_saudara_tiri' => $this->input->post('jumlah_saudara_tiri'),
					'nama_wali' => $this->input->post('nama_wali'),
					'no_telp_wali' => $this->input->post('no_telp_wali'),
					'alamat_wali' => $this->input->post('alamat_wali'),
					'nama_ayah_kandung' => $this->input->post('nama_ayah_kandung'),
					'nama_ayah_tiri' => $this->input->post('nama_ayah_tiri'),
					'nama_ibu_kandung' => $this->input->post('nama_ibu_kandung'),
					'nama_ibu_tiri' => $this->input->post('nama_ibu_tiri'),
					'pekerjaan_ayah' => $this->input->post('pekerjaan_ayah'),
					'pekerjaan_ibu' => $this->input->post('pekerjaan_ibu'),
					'no_telp_orang_tua' => $this->input->post('no_telp_orang_tua'),
					'alamat_orang_tua' => $this->input->post('alamat_orang_tua'),
					'pendidikan' => $this->input->post('pendidikan'),
					'status_anak' => $this->input->post('status_anak'),
					'kategori' => $this->input->post('kategori'),
					'status_tinggal' => $this->input->post('status_tinggal'),
					'tanggal_masuk' => $this->input->post('tanggal_masuk'),
					'nama_sekolah' => $this->input->post('nama_sekolah'),
					'kelas' => $this->input->post('kelas'),
					'alamat_sekolah' => $this->input->post('alamat_sekolah'),
					'no_telp_sekolah' => $this->input->post('no_telp_sekolah'),
					'biaya_spp' => $this->input->post('biaya_spp')
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

			case 'ekspor_eksternal':
				$data['page_subtitle'] = 'Ekspor Eksternal';
				$data['anak'] = $this->Anak_model->get_all_anak();
				$data['content'] = $this->load->view('admin/laporan/ekspor_eksternal', $data, TRUE);
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

		// Sort by category order: Yatim Piatu, Yatim, Piatu, Dhuafa, Fakir dan Miskin, Ibnu Sabil, Laqith
		$category_order = [
			'Yatim Piatu' => 1,
			'Yatim' => 2,
			'Piatu' => 3,
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

		// Sort by category order: Yatim Piatu, Yatim, Piatu, Dhuafa, Fakir dan Miskin, Ibnu Sabil, Laqith
		$category_order = [
			'Yatim Piatu' => 1,
			'Yatim' => 2,
			'Piatu' => 3,
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

		$this->excel_export->export_laporan_anak($data, 'laporan_data_anak_' . date('Ymd') . '.xlsx');
		log_activity('export_excel', 'Mengekspor laporan Excel data anak');
	}

	public function export_pdf_pengurus()
	{
		$this->load->model('Pengurus_model');
		$this->load->library('Pdf_export');

		$data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
		$data['settings'] = $this->config->item('settings');

		$this->pdf_export->generate_laporan_pengurus($data);
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

		$this->pdf_export->generate_laporan_dokumen($data);
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

	public function export_pdf_karakter()
	{
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		$this->load->model('Character_assessment_model');
		$this->load->model('Character_master_model');
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');
		$this->load->helper('tanggal');

		$period_type = $this->input->post('period_type', true) ?: $this->input->get('period_type', true) ?: 'weekly';
		$year = (int) ($this->input->post('year', true) ?: $this->input->get('year', true) ?: date('Y'));
		$week = (int) ($this->input->post('week', true) ?: $this->input->get('week', true) ?: date('W'));
		$month = (int) ($this->input->post('month', true) ?: $this->input->get('month', true) ?: date('n'));
		$start_date = $this->input->post('start_date', true) ?: $this->input->get('start_date', true) ?: date('Y-m-01');
		$end_date = $this->input->post('end_date', true) ?: $this->input->get('end_date', true) ?: date('Y-m-d');

		$radar_chart_image = (string) $this->input->post('radar_chart_image', false);
		$aspect_trend_images_raw = (string) $this->input->post('aspect_trend_images', false);
		$aspect_trend_images = array();
		if ($aspect_trend_images_raw !== '') {
			$decoded = json_decode($aspect_trend_images_raw, true);
			if (is_array($decoded)) {
				foreach ($decoded as $aspect_id => $image_data) {
					$image_data = is_string($image_data) ? trim($image_data) : '';
					if ($image_data !== '' && strpos($image_data, 'data:image/') === 0) {
						$aspect_trend_images[(int) $aspect_id] = $image_data;
					}
				}
			}
		}

		if ($radar_chart_image !== '' && strpos($radar_chart_image, 'data:image/') !== 0) {
			$radar_chart_image = '';
		}

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

		$summary_rows = $this->Character_assessment_model->get_child_progress_summary($filters);
		$aspect_scores_rows = $this->Character_assessment_model->get_child_aspect_scores($filters);
		$children = $this->Anak_model->get_all_anak('nama_anak', 'ASC');
		$aspects = $this->Character_master_model->get_aspects_with_indicator_count();

		$period_label = '';
		if ($period_type === 'weekly') {
			$period_label = 'Minggu ke-' . $week . ' Tahun ' . $year;
		} elseif ($period_type === 'monthly') {
			$period_label = bulan_indo($month) . ' ' . $year;
		} else {
			$period_label = tanggal_indo($start_date) . ' s/d ' . tanggal_indo($end_date);
		}

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
		foreach ($children as $child) {
			$id_anak = (int) $child->id_anak;
			$summary = $summary_map[$id_anak] ?? null;

			$aspect_scores = array();
			foreach ($aspects as $aspect) {
				$id_aspect = (int) $aspect->id_aspect;
				$aspect_scores[$id_aspect] = isset($aspect_map[$id_anak][$id_aspect]) ? (float) $aspect_map[$id_anak][$id_aspect] : null;
			}

			$table_rows[] = array(
				'nama_anak' => $child->nama_anak,
				'pendidikan' => $child->pendidikan,
				'total_penilaian' => $summary ? (int) $summary->total_penilaian : 0,
				'avg_score' => $summary ? (float) $summary->avg_score : null,
				'kategori' => $summary ? $summary->kategori : '-',
				'tanggal_terakhir' => $summary->tanggal_terakhir ?? null,
				'aspect_scores' => $aspect_scores
			);
		}

		$data = array(
			'period_type' => $period_type,
			'period_label' => $period_label,
			'aspects' => $aspects,
			'table_rows' => $table_rows,
			'radar_chart_image' => $radar_chart_image,
			'aspect_trend_images' => $aspect_trend_images,
			'settings' => $this->config->item('settings')
		);

		$html = $this->load->view('admin/penilaian_laporan_pdf', $data, true);
		$this->pdf_export->generate($html, 'laporan_karakter_' . date('Ymd') . '.pdf', 'D');
		log_activity('export_pdf_karakter', 'Mengekspor laporan PDF penilaian karakter (' . $period_label . ')');
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

	public function export_pdf_eksternal()
	{
		$this->load->model('Anak_model');
		$this->load->library('Pdf_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$data['settings'] = $this->config->item('settings');

		$this->pdf_export->generate_laporan_eksternal($data);
		log_activity('export_pdf_eksternal', 'Mengekspor laporan PDF eksternal');
	}

	public function export_excel_eksternal()
	{
		$this->load->model('Anak_model');
		$this->load->library('Excel_export');

		$data['anak'] = $this->Anak_model->get_all_anak();
		$this->excel_export->export_laporan_eksternal($data, 'laporan_eksternal_' . date('Ymd') . '.xlsx');
		log_activity('export_excel_eksternal', 'Mengekspor laporan Excel eksternal');
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

	public function anak_ajax()
	{
		$this->load->model('Anak_model');
		$this->load->model('User_model');
		$this->load->helper('tanggal');

		// DataTables parameters
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));
		$search = $this->input->post('search')['value'];

		// Ordering
		$order_column_index = $this->input->post('order')[0]['column'];
		$order_dir = $this->input->post('order')[0]['dir'];
		$columns = ['nama_anak', 'no_kk', 'jenis_kelamin', 'tempat_lahir', 'kategori', 'nama_sekolah', 'biaya_spp', 'created_at'];
		$order_column = $columns[$order_column_index] ?? 'created_at';

		// Additional filters
		$filters = array();
		if ($this->input->post('status_anak')) {
			$filters['status_anak'] = $this->input->post('status_anak');
		}
		if ($this->input->post('jenis_kelamin')) {
			$filters['jenis_kelamin'] = $this->input->post('jenis_kelamin');
		}
		if ($this->input->post('pendidikan')) {
			$filters['pendidikan'] = $this->input->post('pendidikan');
		}

		// Get data
		$anak = $this->Anak_model->get_anak_datatable($start, $length, $search, $order_column, $order_dir, $filters);
		$total_records = $this->Anak_model->count_all_anak();
		$filtered_records = $this->Anak_model->count_filtered_anak($search, $filters);

		// Format data for DataTables
		$data = [];
		$no = $start + 1;
		foreach ($anak as $a) {
			$akun_anak = $this->User_model->get_user_by_anak_id($a->id_anak);
			$akun_badge = $akun_anak
				? '<br><small class="text-success"><i class="fas fa-check-circle"></i> Akun aktif: ' . html_escape($akun_anak->username) . '</small>'
				: '<br><small class="text-muted"><i class="fas fa-user-slash"></i> Belum ada akun</small>';

			$button_akun = $akun_anak
				? '<a class="btn btn-sm btn-success" href="' . site_url('admin/anak/activate-account/' . $a->id_anak) . '" onclick="return confirm(\'Akun sudah ada. Reset password akun anak ini ke format yyyymmdd?\')" title="Reset Password Akun Anak"><i class="fas fa-key"></i></a>'
				: '<a class="btn btn-sm btn-success" href="' . site_url('admin/anak/activate-account/' . $a->id_anak) . '" onclick="return confirm(\'Aktifkan akun untuk data anak ini? Username dan password awal akan dibuat dengan format yyyymmdd.\')" title="Aktifkan Akun Anak"><i class="fas fa-user-check"></i></a>';

			$data[] = [
				$no++,
				'<div class="user-cell">
					<div class="user-avatar bg-' . ($a->jenis_kelamin == 'L' ? 'blue' : 'pink') . '">' .
				strtoupper(substr($a->nama_anak, 0, 1)) . '
					</div>
					<div>
						<span>' . $a->nama_anak . '</span><br>
						<small>' . ($a->nik ?: '-') . '</small>' . $akun_badge . '
					</div>
				</div>',
				html_escape($a->no_kk ?: '-'),
				'<span class="badge-jk badge-' . ($a->jenis_kelamin == 'L' ? 'blue' : 'pink') . '">' .
				($a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . '</span>',
				$a->tempat_lahir . ', ' . tanggal_indo($a->tanggal_lahir),
				$a->kategori ?: '-',
				$a->nama_sekolah ?: '-',
				$a->biaya_spp ? 'Rp ' . number_format($a->biaya_spp, 0, ',', '.') : '-',
				'<div class="btn-group">
					' . $button_akun . '
					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalView' . $a->id_anak . '">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit' . $a->id_anak . '">
						<i class="fas fa-edit"></i>
					</button>
					<button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalUpload' . $a->id_anak . '">
						<i class="fas fa-upload"></i>
					</button>
					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalDelete' . $a->id_anak . '">
						<i class="fas fa-trash"></i>
					</button>
				</div>'
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

	public function activate_anak_account($id_anak)
	{
		$this->load->model('Anak_model');
		$this->load->model('User_model');

		$id_anak = (int) $id_anak;
		$anak = $this->Anak_model->get_anak_by_id($id_anak);

		if (!$anak) {
			$this->session->set_flashdata('error', 'Data anak tidak ditemukan.');
			redirect('admin/anak');
		}

		if (empty($anak->tanggal_lahir)) {
			$this->session->set_flashdata('error', 'Tanggal lahir anak belum diisi. Username/password format yyyymmdd tidak bisa dibuat.');
			redirect('admin/anak');
		}

		if (!$this->db->field_exists('id_anak', 'users')) {
			$this->session->set_flashdata('error', 'Kolom id_anak pada tabel users belum tersedia. Jalankan SQL alter relasi users-anak terlebih dahulu.');
			redirect('admin/anak');
		}

		$credential = date('Ymd', strtotime($anak->tanggal_lahir));
		$username = $credential;
		$password_plain = $credential;
		$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

		$user_by_child = $this->User_model->get_user_by_anak_id($id_anak);

		if ($user_by_child) {
			$update_data = array(
				'username' => $username,
				'password' => $password_hash,
				'role' => 'anak'
			);

			$existing_username_owner = $this->User_model->get_user_by_username($username);
			if ($existing_username_owner && (int) $existing_username_owner->id_user !== (int) $user_by_child->id_user) {
				$this->session->set_flashdata('error', 'Username ' . $username . ' sudah dipakai akun lain.');
				redirect('admin/anak');
			}

			$this->User_model->update_user($user_by_child->id_user, $update_data);

			log_activity('activate_akun_anak', 'Reset akun anak untuk ' . $anak->nama_anak . ' dengan username ' . $username);
			$this->session->set_flashdata('success', 'Akun anak berhasil direset. Username: ' . $username . ' | Password awal: ' . $password_plain);
			redirect('admin/anak');
		}

		$existing_username = $this->User_model->get_user_by_username($username);
		if ($existing_username) {
			$this->session->set_flashdata('error', 'Username ' . $username . ' sudah dipakai akun lain.');
			redirect('admin/anak');
		}

		$insert_data = array(
			'nama' => $anak->nama_anak,
			'username' => $username,
			'password' => $password_hash,
			'role' => 'anak',
			'id_anak' => $id_anak
		);

		$this->User_model->insert_user($insert_data);

		log_activity('activate_akun_anak', 'Mengaktifkan akun anak untuk ' . $anak->nama_anak . ' dengan username ' . $username);
		$this->session->set_flashdata('success', 'Akun anak berhasil diaktifkan. Username: ' . $username . ' | Password awal: ' . $password_plain);
		redirect('admin/anak');
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
		$this->load->helper('file');

		$backup_path = FCPATH . 'assets/backups/database/';
		if (!is_dir($backup_path)) {
			mkdir($backup_path, 0755, TRUE);
		}

		$filename = 'db_lksa_backup_' . date('Y-m-d_H-i-s') . '.sql';
		$filepath = $backup_path . $filename;

		// Check if shell_exec is enabled
		$test_output = shell_exec('echo test');
		if ($test_output === null) {
			$this->session->set_flashdata('error', 'shell_exec is disabled in PHP configuration');
			redirect('admin/backup');
		}

		// Use mysqldump command
		$command = 'mysqldump -u root db_lksa > "' . $filepath . '" 2>&1';
		$output = shell_exec($command);
		if (file_exists($filepath) && filesize($filepath) > 0) {
			log_activity('backup_database', 'Database backup berhasil: ' . $filename);
			$this->session->set_flashdata('success', 'Database backup berhasil! File: ' . $filename);
		} else {
			log_activity('backup_database', 'Gagal membuat database backup. Output: ' . $output);
			$this->session->set_flashdata('error', 'Gagal membuat database backup! Output: ' . $output);
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
			log_activity('download_error', 'Access denied for download');
			show_error('Access denied', 403);
		}

		$backup_path = FCPATH . 'assets/backups/' . $type . '/' . $filename;
		if (!file_exists($backup_path)) {
			log_activity('download_error', 'File not found: ' . $backup_path);
			show_error('File tidak ditemukan', 404);
		}

		$file_info = pathinfo($backup_path);
		$file_name = $file_info['basename'];
		$this->load->helper('download');
		force_download($backup_path, NULL);
		log_activity('download_backup', 'Download completed: ' . $type . '/' . $filename);
		exit;
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

	public function delete_backup()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Akses ditolak!');
			redirect('admin/backup');
		}

		$type = $this->input->post('type');
		$filename = $this->input->post('filename');

		// Validate type
		if (!in_array($type, ['database', 'files'])) {
			$this->session->set_flashdata('error', 'Tipe backup tidak valid!');
			redirect('admin/backup');
		}

		// Sanitize filename to prevent directory traversal
		$filename = basename($filename);
		$file_path = FCPATH . 'assets/backups/' . $type . '/' . $filename;

		if (!file_exists($file_path)) {
			$this->session->set_flashdata('error', 'File backup tidak ditemukan!');
			redirect('admin/backup');
		}

		if (unlink($file_path)) {
			log_activity('delete_backup', 'Menghapus file backup: ' . $type . '/' . $filename);
			$this->session->set_flashdata('success', 'File backup berhasil dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus file backup!');
		}

		redirect('admin/backup');
	}

	public function carousel()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
			redirect('admin');
		}

		$this->load->model('Carousel_model');
		$data['carousel_images'] = $this->Carousel_model->get_all_carousel_images_admin();
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

	public function update_carousel_image()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupdate gambar!');
			redirect('admin/carousel');
		}

		$this->load->model('Carousel_model');

		$id = $this->input->post('id_carousel');

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

	public function hero()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
			redirect('admin');
		}

		$this->load->model('Hero_model');
		$data['hero_images'] = $this->Hero_model->get_all_hero_images();
		$data['title'] = 'Kelola Hero Landing Page - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola Hero Images';
		$data['content'] = $this->load->view('admin/hero', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function upload_hero_image()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupload gambar!');
			redirect('admin/hero');
		}

		$this->load->model('Hero_model');
		$this->load->library('upload');

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

			$hero_data = array(
				'image_name' => $image_name,
				'title' => $this->input->post('title'),
				'subtitle' => $this->input->post('subtitle'),
				'description' => $this->input->post('description'),
				'sort_order' => $this->input->post('sort_order') ?: 0,
				'is_active' => 1
			);

			$this->Hero_model->insert_hero_image($hero_data);
			$description = 'Mengupload gambar hero: ' . $image_name;
			log_activity('upload_hero_image', $description);
			$this->session->set_flashdata('success', 'Gambar hero berhasil diupload!');
		}

		redirect('admin/hero');
	}

	public function update_hero_image($id)
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupdate gambar!');
			redirect('admin/hero');
		}

		$this->load->model('Hero_model');

		$update_data = array(
			'title' => $this->input->post('title'),
			'subtitle' => $this->input->post('subtitle'),
			'description' => $this->input->post('description'),
			'sort_order' => $this->input->post('sort_order') ?: 0,
			'is_active' => $this->input->post('is_active') ? 1 : 0
		);

		$this->Hero_model->update_hero_image($id, $update_data);
		$description = 'Mengupdate gambar hero ID: ' . $id;
		log_activity('update_hero_image', $description);
		$this->session->set_flashdata('success', 'Gambar hero berhasil diperbarui!');

		redirect('admin/hero');
	}

	public function delete_hero_image($id)
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus gambar!');
			redirect('admin/hero');
		}

		$this->load->model('Hero_model');
		$image = $this->Hero_model->get_hero_image_by_id($id);

		if ($image) {
			// Delete file from server
			$file_path = FCPATH . 'assets/uploads/landing/' . $image->image_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}

			// Delete from database
			$this->Hero_model->delete_hero_image($id);
			$description = 'Menghapus gambar hero: ' . $image->image_name;
			log_activity('delete_hero_image', $description);
			$this->session->set_flashdata('success', 'Gambar hero berhasil dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Gambar hero tidak ditemukan!');
		}

		redirect('admin/hero');
	}

	public function facilities()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
			redirect('admin');
		}

		$this->load->model('Fasilitas_model');
		$data['facilities'] = $this->Fasilitas_model->get_all_facilities();
		$data['title'] = 'Kelola Fasilitas Landing Page - LKSA Harapan Bangsa';
		$data['page_title'] = 'Kelola Fasilitas';
		$data['content'] = $this->load->view('admin/facilities', $data, TRUE);
		$this->load->view('templates/admin_layout', $data);
	}

	public function facilities_upload()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupload fasilitas!');
			redirect('admin/facilities');
		}

		$this->load->model('Fasilitas_model');
		$this->load->library('upload');

		$upload_path = FCPATH . 'assets/uploads/facilities/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, TRUE);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048;
		$config['file_name'] = 'facility_' . time();
		$config['detect_mime'] = TRUE;
		$config['xss_clean'] = TRUE;

		$this->upload->initialize($config);

		$facility_data = array(
			'nama_fasilitas' => $this->input->post('nama_fasilitas'),
			'deskripsi' => $this->input->post('deskripsi'),
			'icon' => $this->input->post('icon'),
			'sort_order' => $this->input->post('sort_order') ?: 0,
			'is_active' => 1
		);

		if ($this->upload->do_upload('facility_image')) {
			$data = $this->upload->data();
			$facility_data['gambar'] = $data['file_name'];
		}

		$this->Fasilitas_model->insert_facility($facility_data);
		$description = 'Menambahkan fasilitas: ' . $facility_data['nama_fasilitas'];
		log_activity('add_facility', $description);
		$this->session->set_flashdata('success', 'Fasilitas berhasil ditambahkan!');

		redirect('admin/facilities');
	}

	public function facilities_update()
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengupdate fasilitas!');
			redirect('admin/facilities');
		}

		$this->load->model('Fasilitas_model');

		$id = $this->input->post('id_fasilitas');

		$update_data = array(
			'nama_fasilitas' => $this->input->post('nama_fasilitas'),
			'deskripsi' => $this->input->post('deskripsi'),
			'icon' => $this->input->post('icon'),
			'sort_order' => $this->input->post('sort_order'),
			'is_active' => $this->input->post('is_active') ? 1 : 0
		);

		$this->Fasilitas_model->update_facility($id, $update_data);
		$description = 'Mengupdate fasilitas ID: ' . $id;
		log_activity('update_facility', $description);
		$this->session->set_flashdata('success', 'Fasilitas berhasil diperbarui!');

		redirect('admin/facilities');
	}

	public function facilities_delete($id)
	{
		if ($this->session->userdata('role') != 'admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus fasilitas!');
			redirect('admin/facilities');
		}

		$this->load->model('Fasilitas_model');
		$facility = $this->Fasilitas_model->get_facility_by_id($id);

		if ($facility) {
			// Delete file from server
			if (!empty($facility->gambar)) {
				$file_path = FCPATH . 'assets/uploads/facilities/' . $facility->gambar;
				if (file_exists($file_path)) {
					unlink($file_path);
				}
			}

			// Delete from database
			$this->Fasilitas_model->delete_facility($id);
			$description = 'Menghapus fasilitas: ' . $facility->nama_fasilitas;
			log_activity('delete_facility', $description);
			$this->session->set_flashdata('success', 'Fasilitas berhasil dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Fasilitas tidak ditemukan!');
		}

		redirect('admin/facilities');
	}


}
