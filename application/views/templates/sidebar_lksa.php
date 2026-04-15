<!-- Main Sidebar Container -->
<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" />
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo site_url('admin'); ?>" class="brand-link">
		<?php
		$settings = get_instance()->config->item('settings');
		$logo_file = $settings->logo ?? '';
		$logo_path = FCPATH . 'assets/uploads/logos/' . $logo_file;
		$brand_logo_url = (!empty($logo_file) && file_exists($logo_path))
			? base_url('assets/uploads/logos/' . $logo_file)
			: base_url('assets/img/AdminLTELogo.png');
		?>
		<img src="<?php echo $brand_logo_url; ?>" alt="Logo LKSA" class="brand-image img-circle elevation-3"
			style="opacity: .8">
		<span class="brand-text font-weight-light"
			style="text-shadow: 1px 1px 0px #666, 2px 2px 0px #555, 3px 3px 0px #444, 4px 4px 0px #333, 5px 5px 5px rgba(0,0,0,0.5);">SAHABAT</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo base_url('assets/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2"
					alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview"
				role="menu" data-accordion="false">

				<!-- Dashboard -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin'); ?>"
						class="nav-link <?php echo $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<!-- Operasional Inti -->
				<li class="nav-header">OPERASIONAL INTI</li>

				<!-- Anak -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin/anak'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'anak' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-child"></i>
						<p>Data Anak</p>
					</a>
				</li>

				<!-- Pengurus -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin/pengurus'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'pengurus' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-user-tie"></i>
						<p>Data Pengurus</p>
					</a>
				</li>

				<!-- Penilaian & Monitoring -->
				<li class="nav-header">PENILAIAN & MONITORING</li>

				<?php
				$penilaian_segment = $this->uri->segment(2) == 'penilaian-karakter';
				$penilaian_sub = $this->uri->segment(3);
				$group_master_input = $penilaian_segment && in_array($penilaian_sub, array('', 'master', 'data-penilaian', 'detail-penilaian', 'catatan-kualitatif'), true);
				$group_ringkasan_laporan = $penilaian_segment && in_array($penilaian_sub, array('ringkasan-mingguan', 'ringkasan-bulanan', 'laporan'), true);
				?>

				<li class="nav-item <?php echo $group_master_input ? 'menu-open' : ''; ?>">
					<a href="#" class="nav-link <?php echo $group_master_input ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-edit"></i>
						<p>
							Master & Input
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="<?php echo $group_master_input ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/master'); ?>"
								class="nav-link <?php echo $penilaian_segment && (empty($penilaian_sub) || $penilaian_sub == 'master') ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Master Penilaian</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/data-penilaian'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'data-penilaian' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Data Penilaian</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/detail-penilaian'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'detail-penilaian' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Detail Penilaian</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/catatan-kualitatif'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'catatan-kualitatif' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Catatan Kualitatif</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item <?php echo $group_ringkasan_laporan ? 'menu-open' : ''; ?>">
					<a href="#" class="nav-link <?php echo $group_ringkasan_laporan ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-chart-line"></i>
						<p>
							Ringkasan & Laporan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview"
						style="<?php echo $group_ringkasan_laporan ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/ringkasan-mingguan'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'ringkasan-mingguan' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Ringkasan Mingguan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/ringkasan-bulanan'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'ringkasan-bulanan' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Ringkasan Bulanan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penilaian-karakter/laporan'); ?>"
								class="nav-link <?php echo $penilaian_segment && $penilaian_sub == 'laporan' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Laporan Karakter</p>
							</a>
						</li>
					</ul>
				</li>



				<!-- Laporan & Ekspor -->
				<li class="nav-header">LAPORAN & EKSPOR</li>

				<li class="nav-item <?php echo $this->uri->segment(2) == 'laporan' ? 'menu-open' : ''; ?>">
					<a href="#" class="nav-link <?php echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>
							Laporan Administrasi
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview"
						style="<?php echo $this->uri->segment(2) == 'laporan' ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/data_anak'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'data_anak' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Data Anak</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/keuangan'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'keuangan' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Keuangan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/pengurus'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'pengurus' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Pengurus</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/dokumen'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'dokumen' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Dokumen</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/statistik'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'statistik' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Statistik</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/ekspor_eksternal'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'ekspor_eksternal' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Ekspor Eksternal</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Website Publik -->
				<li class="nav-header">WEBSITE PUBLIK</li>

				<li
					class="nav-item <?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities', 'kontak', 'dukung_kami', 'changelog')) ? 'menu-open' : ''; ?>">
					<a href="#"
						class="nav-link <?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities', 'kontak', 'dukung_kami', 'changelog')) ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-globe"></i>
						<p>
							Kelola Website
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview"
						style="<?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities', 'kontak', 'dukung_kami', 'changelog')) ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/carousel'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'carousel' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Carousel / Banner</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/landing'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'landing' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Tentang Kami</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/facilities'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'facilities' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Fasilitas LKSA</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/kontak'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'kontak' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Kontak Pengembang</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/dukung_kami'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'dukung_kami' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Dukung Kami</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/changelog'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'changelog' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Log Pembaruan</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Sistem & Akses -->
				<li class="nav-header">SISTEM & AKSES</li>

				<li
					class="nav-item <?php echo in_array($this->uri->segment(2), array('pengaturan', 'user', 'logs', 'backup')) ? 'menu-open' : ''; ?>">
					<a href="#"
						class="nav-link <?php echo in_array($this->uri->segment(2), array('pengaturan', 'user', 'logs', 'backup')) ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Pengaturan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview"
						style="<?php echo in_array($this->uri->segment(2), array('pengaturan', 'user', 'logs', 'backup')) ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/pengaturan'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'pengaturan' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Profile LKSA</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/user'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'user' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Kelola User</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/logs'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'logs' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Log Aktivitas</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/backup'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'backup' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Backup & Restore</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Logout (Main Menu) -->
				<li class="nav-item">
					<a href="<?php echo site_url('auth/logout'); ?>" class="nav-link">
						<i class="nav-icon fas fa-sign-out-alt"></i>
						<p>Logout</p>
					</a>
</aside>
