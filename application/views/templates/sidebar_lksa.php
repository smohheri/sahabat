<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo site_url('admin'); ?>" class="brand-link">
		<?php $settings = get_instance()->config->item('settings'); ?>
		<img src="<?php echo base_url('assets/uploads/logos/' . ($settings->logo ?? 'AdminLTELogo.png')); ?>"
			alt="Logo LKSA" class="brand-image img-circle elevation-3" style="opacity: .8">
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
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

				<!-- Dashboard -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin'); ?>"
						class="nav-link <?php echo $this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<!-- Data Master -->
				<li class="nav-header">DATA MASTER</li>

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



				<!-- Laporan -->
				<li class="nav-header">LAPORAN</li>

				<li class="nav-item <?php echo $this->uri->segment(2) == 'laporan' ? 'menu-open' : ''; ?>">
					<a href="#" class="nav-link <?php echo $this->uri->segment(2) == 'laporan' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>
							Kelola Laporan
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

				<!-- Informasi -->
				<li class="nav-header">INFORMASI</li>

				<!-- Kontak Pengembang -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin/kontak'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'kontak' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-headset"></i>
						<p>Kontak Pengembang</p>
					</a>
				</li>

				<!-- Dukung Kami -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin/dukung_kami'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'dukung_kami' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-heart"></i>
						<p>Dukung Kami</p>
					</a>
				</li>

				<!-- Changelog -->
				<li class="nav-item">
					<a href="<?php echo site_url('admin/changelog'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'changelog' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-history"></i>
						<p>Changelog</p>
					</a>
				</li>

				<!-- Landing Page -->
				<li class="nav-header">LANDING PAGE</li>

				<li
					class="nav-item <?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities')) ? 'menu-open' : ''; ?>">
					<a href="#"
						class="nav-link <?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities')) ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-home"></i>
						<p>
							Landing Page
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview"
						style="<?php echo in_array($this->uri->segment(2), array('landing', 'carousel', 'facilities')) ? 'display: block;' : ''; ?>">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/carousel'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'carousel' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Kelola Carousel</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/landing'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'landing' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Kelola About</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/facilities'); ?>"
								class="nav-link <?php echo $this->uri->segment(2) == 'facilities' ? 'active' : ''; ?>">
								<i class="far fa-circle nav-icon"></i>
								<p>Kelola Fasilitas</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Pengaturan -->
				<li class="nav-header">PENGATURAN</li>

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
						<li class="nav-item">
							<a href="<?php echo site_url('auth/logout'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Logout</p>
							</a>
						</li>
					</ul>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
