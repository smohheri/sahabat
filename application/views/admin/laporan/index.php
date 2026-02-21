<!-- Laporan Menu - Redesain Modern -->
<div class="laporan-menu">
	<!-- Header Section -->
	<div class="menu-header">
		<div class="header-icon">
			<i class="fas fa-file-alt"></i>
		</div>
		<div class="header-content">
			<h1>Kelola Laporan</h1>
			<p>Pilih jenis laporan yang ingin Anda akses</p>
		</div>
	</div>

	<!-- Menu Cards Grid -->
	<div class="menu-grid">
		<!-- Card: Data Anak -->
		<a href="<?php echo site_url('admin/laporan/data_anak'); ?>" class="menu-card card-blue">
			<div class="card-icon">
				<i class="fas fa-child"></i>
			</div>
			<div class="card-content">
				<h3>Laporan Data Anak</h3>
				<p>Data lengkap anak asuh meliputi identitas, pendidikan, dan status</p>
			</div>
			<div class="card-arrow">
				<i class="fas fa-arrow-right"></i>
			</div>
		</a>

		<!-- Card: Keuangan -->
		<a href="<?php echo site_url('admin/laporan/keuangan'); ?>" class="menu-card card-green">
			<div class="card-icon">
				<i class="fas fa-money-bill-wave"></i>
			</div>
			<div class="card-content">
				<h3>Laporan Keuangan</h3>
				<p>Ringkasan keuangan dan transaksi pengelolaan dana</p>
			</div>
			<div class="card-arrow">
				<i class="fas fa-arrow-right"></i>
			</div>
		</a>

		<!-- Card: Pengurus -->
		<a href="<?php echo site_url('admin/laporan/pengurus'); ?>" class="menu-card card-purple">
			<div class="card-icon">
				<i class="fas fa-user-tie"></i>
			</div>
			<div class="card-content">
				<h3>Laporan Pengurus</h3>
				<p>Data pengurus, staff, dan struktur organisasi</p>
			</div>
			<div class="card-arrow">
				<i class="fas fa-arrow-right"></i>
			</div>
		</a>

		<!-- Card: Dokumen -->
		<a href="<?php echo site_url('admin/laporan/dokumen'); ?>" class="menu-card card-orange">
			<div class="card-icon">
				<i class="fas fa-folder-open"></i>
			</div>
			<div class="card-content">
				<h3>Laporan Dokumen</h3>
				<p>Kelengkapan dokumen anak asuh dan legalitas</p>
			</div>
			<div class="card-arrow">
				<i class="fas fa-arrow-right"></i>
			</div>
		</a>

		<!-- Card: Statistik -->
		<a href="<?php echo site_url('admin/laporan/statistik'); ?>" class="menu-card card-red">
			<div class="card-icon">
				<i class="fas fa-chart-pie"></i>
			</div>
			<div class="card-content">
				<h3>Laporan Statistik</h3>
				<p>Grafik dan statistik perkembangan program</p>
			</div>
			<div class="card-arrow">
				<i class="fas fa-arrow-right"></i>
			</div>
		</a>
	</div>

	<!-- Quick Info -->
	<div class="menu-info">
		<i class="fas fa-info-circle"></i>
		<span>Semua data laporan dapat diekspor ke PDF atau Excel untuk kebutuhan dokumentasi</span>
	</div>
</div>

<style>
	/* Laporan Menu Styles */
	.laporan-menu {
		padding: 10px;
	}

	/* Header */
	.menu-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 20px;
		padding: 30px;
		display: flex;
		align-items: center;
		gap: 25px;
		margin-bottom: 30px;
		color: #fff;
	}

	.header-icon {
		width: 80px;
		height: 80px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 20px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 36px;
		backdrop-filter: blur(10px);
	}

	.header-content h1 {
		margin: 0 0 8px;
		font-size: 28px;
		font-weight: 700;
	}

	.header-content p {
		margin: 0;
		opacity: 0.9;
		font-size: 15px;
	}

	/* Menu Grid */
	.menu-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
		gap: 20px;
	}

	/* Menu Card */
	.menu-card {
		background: #fff;
		border-radius: 16px;
		padding: 25px;
		display: flex;
		align-items: center;
		gap: 20px;
		text-decoration: none;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
		border: 2px solid transparent;
		position: relative;
		overflow: hidden;
	}

	.menu-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
	}

	.menu-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 4px;
		height: 100%;
	}

	.card-blue::before {
		background: linear-gradient(180deg, #4e73df, #2e59d9);
	}

	.card-blue .card-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.card-green::before {
		background: linear-gradient(180deg, #1cc88a, #13855c);
	}

	.card-green .card-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.card-purple::before {
		background: linear-gradient(180deg, #6f42c1, #4f2d7f);
	}

	.card-purple .card-icon {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
	}

	.card-orange::before {
		background: linear-gradient(180deg, #f6c23e, #dda20a);
	}

	.card-orange .card-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.card-red::before {
		background: linear-gradient(180deg, #e74a3b, #c0392b);
	}

	.card-red .card-icon {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	.card-icon {
		width: 65px;
		height: 65px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 28px;
		flex-shrink: 0;
	}

	.card-content {
		flex: 1;
	}

	.card-content h3 {
		margin: 0 0 8px;
		font-size: 17px;
		font-weight: 600;
		color: #2d3748;
	}

	.card-content p {
		margin: 0;
		font-size: 13px;
		color: #718096;
		line-height: 1.5;
	}

	.card-arrow {
		width: 40px;
		height: 40px;
		background: #f8fafc;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #cbd5e0;
		transition: all 0.3s ease;
	}

	.menu-card:hover .card-arrow {
		background: #667eea;
		color: #fff;
		transform: translateX(4px);
	}

	/* Quick Info */
	.menu-info {
		margin-top: 25px;
		padding: 18px 25px;
		background: #f8fafc;
		border-radius: 12px;
		display: flex;
		align-items: center;
		gap: 12px;
		color: #718096;
		font-size: 14px;
	}

	.menu-info i {
		color: #4e73df;
		font-size: 18px;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.menu-header {
			flex-direction: column;
			text-align: center;
			padding: 25px;
		}

		.menu-grid {
			grid-template-columns: 1fr;
		}

		.menu-card {
			padding: 20px;
		}
	}

	/* Dark Mode Styles for laporan/index.php */
	body.dark-mode .laporan-menu {
		background-color: #1a1a2e;
	}

	body.dark-mode .menu-header {
		background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
		border: 1px solid #00d9ff;
	}

	body.dark-mode .menu-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .card-content h3 {
		color: #e0e0e0;
	}

	body.dark-mode .card-content p {
		color: #a0a0a0;
	}

	body.dark-mode .card-arrow {
		background-color: #0f3460;
		color: #a0a0a0;
	}

	body.dark-mode .menu-info {
		background-color: #16213e;
		color: #a0a0a0;
	}

	body.dark-mode .menu-info i {
		color: #00d9ff;
	}
</style>