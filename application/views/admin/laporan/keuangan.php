<!-- Laporan Keuangan - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-green">
				<i class="fas fa-money-bill-wave"></i>
			</div>
			<div>
				<h2>Laporan Keuangan</h2>
				<p>Monitoring transaksi keuangan dan saldo</p>
			</div>
		</div>
		<div class="header-actions">
			<button class="btn btn-export-pdf" disabled
				title="Fitur akan tersedia setelah modul keuangan diimplementasikan">
				<i class="fas fa-file-pdf"></i> Export PDF
			</button>
			<button class="btn btn-export-excel" disabled
				title="Fitur akan tersedia setelah modul keuangan diimplementasikan">
				<i class="fas fa-file-excel"></i> Export Excel
			</button>
		</div>
	</div>

	<!-- Filter Card -->
	<div class="filter-card">
		<div class="filter-header">
			<h3><i class="fas fa-filter"></i> Filter Periode</h3>
		</div>
		<div class="filter-body">
			<div class="filter-grid">
				<div class="filter-item">
					<label>Dari Tanggal</label>
					<input type="date" class="form-input" id="tglMulai">
				</div>
				<div class="filter-item">
					<label>Sampai Tanggal</label>
					<input type="date" class="form-input" id="tglSelesai">
				</div>
				<div class="filter-item">
					<label>Jenis Transaksi</label>
					<select class="form-select" id="jenisTransaksi">
						<option value="">Semua</option>
						<option value="pemasukan">Pemasukan</option>
						<option value="pengeluaran">Pengeluaran</option>
					</select>
				</div>
				<div class="filter-item filter-actions">
					<button class="btn btn-filter" onclick="filterKeuangan()">
						<i class="fas fa-search"></i> Tampilkan
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="stats-row">
		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-arrow-down"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number">Rp 0</span>
				<span class="stat-label">Total Pemasukan</span>
			</div>
		</div>

		<div class="stat-card stat-red">
			<div class="stat-icon">
				<i class="fas fa-arrow-up"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number">Rp 0</span>
				<span class="stat-label">Total Pengeluaran</span>
			</div>
		</div>

		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-wallet"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number">Rp 0</span>
				<span class="stat-label">Saldo Saat Ini</span>
			</div>
		</div>
	</div>

	<!-- Info Card -->
	<div class="info-card">
		<div class="info-icon">
			<i class="fas fa-info-circle"></i>
		</div>
		<div class="info-content">
			<h4>Modul Keuangan Belum Tersedia</h4>
			<p>Fitur laporan keuangan akan diimplementasikan setelah modul keuangan ditambahkan ke sistem.</p>
		</div>
	</div>

	<!-- Features List -->
	<div class="features-card">
		<div class="features-header">
			<h3><i class="fas fa-list-check"></i> Fitur yang Akan Tersedia</h3>
		</div>
		<div class="features-body">
			<div class="features-grid">
				<div class="feature-item">
					<div class="feature-icon">
						<i class="fas fa-arrow-down"></i>
					</div>
					<div class="feature-text">
						<h4>Laporan Pemasukan</h4>
						<p>Donasi, bantuan pemerintah, dan sumber dana lainnya</p>
					</div>
				</div>
				<div class="feature-item">
					<div class="feature-icon">
						<i class="fas fa-arrow-up"></i>
					</div>
					<div class="feature-text">
						<h4>Laporan Pengeluaran</h4>
						<p>Operasional, pendidikan, kesehatan, dan lainnya</p>
					</div>
				</div>
				<div class="feature-item">
					<div class="feature-icon">
						<i class="fas fa-balance-scale"></i>
					</div>
					<div class="feature-text">
						<h4>Neraca Keuangan</h4>
						<p>Ringkasan posisi keuangan per periode</p>
					</div>
				</div>
				<div class="feature-item">
					<div class="feature-icon">
						<i class="fas fa-chart-line"></i>
					</div>
					<div class="feature-text">
						<h4>Grafik Trend</h4>
						<p>Visualisasi tren keuangan historis</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Empty Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Riwayat Transaksi</h3>
		</div>
		<div class="panel-body">
			<div class="empty-state">
				<div class="empty-icon">
					<i class="fas fa-receipt"></i>
				</div>
				<h4>Belum Ada Data Transaksi</h4>
				<p>Data transaksi akan muncul setelah modul keuangan diimplementasikan</p>
			</div>
		</div>
	</div>
</div>

<style>
	/* Page Container */
	.laporan-page {
		padding: 10px;
	}

	/* Page Header */
	.page-header {
		background: #fff;
		border-radius: 16px;
		padding: 25px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.header-info {
		display: flex;
		align-items: center;
		gap: 20px;
	}

	.header-icon {
		width: 60px;
		height: 60px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26px;
	}

	.bg-green {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.bg-red {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	.bg-blue {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.header-info h2 {
		margin: 0 0 5px;
		font-size: 22px;
		font-weight: 600;
		color: #2d3748;
	}

	.header-info p {
		margin: 0;
		color: #718096;
		font-size: 14px;
	}

	.header-actions {
		display: flex;
		gap: 12px;
	}

	.btn-export-pdf,
	.btn-export-excel {
		padding: 10px 20px;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
		transition: all 0.3s ease;
		background: #cbd5e0;
		color: #718096;
		border: none;
		cursor: not-allowed;
	}

	/* Filter Card */
	.filter-card {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.filter-header {
		padding: 18px 25px;
		background: #f8fafc;
		border-bottom: 1px solid #edf2f7;
	}

	.filter-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.filter-header i {
		color: #1cc88a;
	}

	.filter-body {
		padding: 25px;
	}

	.filter-grid {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 18px;
		align-items: end;
	}

	.filter-item label {
		display: block;
		font-size: 13px;
		font-weight: 500;
		color: #4a5568;
		margin-bottom: 8px;
	}

	.form-input,
	.form-select {
		width: 100%;
		padding: 10px 15px;
		border: 1px solid #e2e8f0;
		border-radius: 8px;
		font-size: 14px;
		color: #2d3748;
		background: #fff;
		transition: all 0.2s;
	}

	.form-input:focus,
	.form-select:focus {
		outline: none;
		border-color: #1cc88a;
		box-shadow: 0 0 0 3px rgba(28, 200, 138, 0.1);
	}

	.btn-filter {
		padding: 10px 20px;
		background: #1cc88a;
		color: #fff;
		border: none;
		border-radius: 8px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s;
	}

	.btn-filter:hover {
		background: #13855c;
	}

	/* Stats Row */
	.stats-row {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.stat-card {
		background: #fff;
		border-radius: 14px;
		padding: 22px;
		display: flex;
		align-items: center;
		gap: 18px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
	}

	.stat-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
	}

	.stat-icon {
		width: 55px;
		height: 55px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	.stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.stat-red .stat-icon {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	.stat-blue .stat-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.stat-info {
		display: flex;
		flex-direction: column;
	}

	.stat-number {
		font-size: 24px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.stat-label {
		font-size: 13px;
		color: #718096;
		margin-top: 5px;
	}

	/* Info Card */
	.info-card {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 14px;
		padding: 25px;
		display: flex;
		align-items: center;
		gap: 20px;
		margin-bottom: 25px;
		color: #fff;
	}

	.info-icon {
		width: 50px;
		height: 50px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 22px;
	}

	.info-content h4 {
		margin: 0 0 5px;
		font-size: 16px;
		font-weight: 600;
	}

	.info-content p {
		margin: 0;
		font-size: 14px;
		opacity: 0.9;
	}

	/* Features Card */
	.features-card {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.features-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
	}

	.features-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.features-header i {
		color: #6f42c1;
	}

	.features-body {
		padding: 25px;
	}

	.features-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 20px;
	}

	.feature-item {
		display: flex;
		align-items: flex-start;
		gap: 15px;
		padding: 15px;
		background: #f8fafc;
		border-radius: 10px;
	}

	.feature-icon {
		width: 45px;
		height: 45px;
		background: rgba(111, 66, 193, 0.1);
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
		color: #6f42c1;
		flex-shrink: 0;
	}

	.feature-text h4 {
		margin: 0 0 5px;
		font-size: 15px;
		font-weight: 600;
		color: #2d3748;
	}

	.feature-text p {
		margin: 0;
		font-size: 13px;
		color: #718096;
	}

	/* Data Panel */
	.data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.panel-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
	}

	.panel-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.panel-header i {
		color: #1cc88a;
	}

	.panel-body {
		padding: 0;
	}

	/* Empty State */
	.empty-state {
		padding: 60px 20px;
		text-align: center;
	}

	.empty-icon {
		width: 80px;
		height: 80px;
		background: #f8fafc;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 20px;
		font-size: 36px;
		color: #cbd5e0;
	}

	.empty-state h4 {
		margin: 0 0 10px;
		font-size: 18px;
		font-weight: 600;
		color: #2d3748;
	}

	.empty-state p {
		margin: 0;
		font-size: 14px;
		color: #718096;
	}

	/* Responsive */
	@media (max-width: 992px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.filter-grid {
			grid-template-columns: repeat(2, 1fr);
		}

		.features-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 768px) {
		.page-header {
			flex-direction: column;
			gap: 20px;
			text-align: center;
		}

		.header-info {
			flex-direction: column;
		}

		.stats-row {
			grid-template-columns: 1fr;
		}

		.filter-grid {
			grid-template-columns: 1fr;
		}
	}

	/* Dark Mode Styles for laporan/keuangan.php */
	body.dark-mode .laporan-page {
		background-color: #1a1a2e;
	}

	body.dark-mode .page-header {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .header-info h2 {
		color: #e0e0e0;
	}

	body.dark-mode .header-info p {
		color: #a0a0a0;
	}

	body.dark-mode .stat-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .stat-number {
		color: #e0e0e0;
	}

	body.dark-mode .stat-label {
		color: #a0a0a0;
	}

	body.dark-mode .filter-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .filter-header {
		background-color: #0f3460;
		border-bottom-color: #16213e;
	}

	body.dark-mode .filter-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .filter-body {
		background-color: #16213e;
	}

	body.dark-mode .filter-item label {
		color: #a0a0a0;
	}

	body.dark-mode .form-input,
	body.dark-mode .form-select {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .form-input:focus,
	body.dark-mode .form-select:focus {
		border-color: #00d9ff;
	}

	body.dark-mode .info-card {
		background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
		border: 1px solid #00d9ff;
	}

	body.dark-mode .features-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .features-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .features-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .feature-item {
		background-color: #0f3460;
	}

	body.dark-mode .feature-text h4 {
		color: #e0e0e0;
	}

	body.dark-mode .feature-text p {
		color: #a0a0a0;
	}

	body.dark-mode .data-panel {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .panel-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .panel-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .empty-state {
		background-color: #16213e;
	}

	body.dark-mode .empty-icon {
		background-color: #0f3460;
		color: #a0a0a0;
	}

	body.dark-mode .empty-state h4 {
		color: #e0e0e0;
	}

	body.dark-mode .empty-state p {
		color: #a0a0a0;
	}
</style>

<script>
	function filterKeuangan() {
		alert('Filter keuangan akan diimplementasikan');
	}
</script>