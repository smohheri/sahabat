<!-- Main Sidebar Container -->
<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" />
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="<?php echo site_url('anak'); ?>" class="brand-link">
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
			style="text-shadow: 1px 1px 0px #666, 2px 2px 0px #555, 3px 3px 0px #444, 4px 4px 0px #333, 5px 5px 5px rgba(0,0,0,0.5);">PANEL
			ANAK</span>
	</a>

	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo base_url('assets/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2"
					alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php echo $this->session->userdata('nama'); ?></a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview"
				role="menu" data-accordion="false">
				<li class="nav-header">MENU UTAMA</li>
				<li class="nav-item">
					<a href="<?php echo site_url('anak'); ?>"
						class="nav-link <?php echo $this->uri->segment(1) == 'anak' && $this->uri->segment(2) == '' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo site_url('anak/profil'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'profil' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-user"></i>
						<p>Profil Saya</p>
					</a>
				</li>

				<li class="nav-header">PENILAIAN KARAKTER</li>
				<li class="nav-item">
					<a href="<?php echo site_url('anak/asesmen-mandiri'); ?>"
						class="nav-link <?php echo $this->uri->segment(2) == 'asesmen-mandiri' ? 'active' : ''; ?>">
						<i class="nav-icon fas fa-clipboard-check"></i>
						<p>Asesmen Mandiri</p>
					</a>
				</li>

				<li class="nav-header">AKUN</li>
				<li class="nav-item">
					<a href="<?php echo site_url('auth/logout'); ?>" class="nav-link">
						<i class="nav-icon fas fa-sign-out-alt"></i>
						<p>Logout</p>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>