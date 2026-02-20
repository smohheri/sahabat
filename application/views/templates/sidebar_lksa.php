<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo site_url('admin'); ?>" class="brand-link">
		<img src="<?php echo base_url('assets/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo"
			class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">LKSA Harapan Bangsa</span>
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
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-child"></i>
						<p>
							Data Anak
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/anak'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Daftar Anak</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/anak/tambah'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Tambah Anak</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Penduduk -->
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-users"></i>
						<p>
							Data Penduduk
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penduduk'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Daftar Penduduk</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/penduduk/tambah'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Tambah Penduduk</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Kamar -->
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-bed"></i>
						<p>
							Kelola Kamar
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/kamar'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Daftar Kamar</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/kamar/tambah'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Tambah Kamar</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Staff/Pendidik -->
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-user-tie"></i>
						<p>
							Data Pendidik/Pegawai
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/staff'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Daftar Staff</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/staff/tambah'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Tambah Staff</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Keuangan -->
				<li class="nav-header">KEUANGAN</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-money-bill-wave"></i>
						<p>
							Keuangan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/keuangan/pemasukan'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pemasukan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/keuangan/pengeluaran'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pengeluaran</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/keuangan/laporan'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Laporan Keuangan</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Laporan -->
				<li class="nav-header">LAPORAN</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-file-alt"></i>
						<p>
							Laporan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/anak'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Laporan Anak</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/keuangan'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Laporan Keuangan</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/laporan/kepegawaian'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Laporan Kepegawaian</p>
							</a>
						</li>
					</ul>
				</li>

				<!-- Pengaturan -->
				<li class="nav-header">PENGATURAN</li>

				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Pengaturan
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('admin/pengaturan/profile'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Profile</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('admin/pengaturan/user'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Kelola User</p>
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