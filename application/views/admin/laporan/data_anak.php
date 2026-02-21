<!-- Laporan Data Anak - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-child"></i>
			</div>
			<div>
				<h2>Laporan Data Anak</h2>
				<p>Data lengkap anak asuh meliputi identitas, pendidikan, dan status</p>
			</div>
		</div>
		<div class="header-actions">
			<a href="<?php echo site_url('admin/export_pdf_anak'); ?>" class="btn btn-export-pdf" target="_blank">
				<i class="fas fa-file-pdf"></i> Export PDF
			</a>
			<a href="<?php echo site_url('admin/export_excel_anak'); ?>" class="btn btn-export-excel">
				<i class="fas fa-file-excel"></i> Export Excel
			</a>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($anak); ?></span>
				<span class="stat-label">Total Anak</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-user-check"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->status_anak == 'Aktif';
				})); ?></span>
				<span class="stat-label">Anak Aktif</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-male"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->jenis_kelamin == 'L';
				})); ?></span>
				<span class="stat-label">Laki-laki</span>
			</div>
		</div>

		<div class="stat-card stat-pink">
			<div class="stat-icon">
				<i class="fas fa-female"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->jenis_kelamin == 'P';
				})); ?></span>
				<span class="stat-label">Perempuan</span>
			</div>
		</div>
	</div>

	<!-- Filter Section -->
	<div class="filter-card">
		<div class="filter-header">
			<h3><i class="fas fa-filter"></i> Filter Data</h3>
		</div>
		<div class="filter-body">
			<div class="filter-grid">
				<div class="filter-item">
					<label>Status</label>
					<select class="form-select" id="filterStatus">
						<option value="">Semua Status</option>
						<option value="Aktif">Aktif</option>
						<option value="Non Aktif">Non Aktif</option>
					</select>
				</div>
				<div class="filter-item">
					<label>Jenis Kelamin</label>
					<select class="form-select" id="filterJenisKelamin">
						<option value="">Semua</option>
						<option value="L">Laki-laki</option>
						<option value="P">Perempuan</option>
					</select>
				</div>
				<div class="filter-item">
					<label>Pendidikan</label>
					<select class="form-select" id="filterPendidikan">
						<option value="">Semua</option>
						<option value="SD">SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA">SMA</option>
						<option value="PT">Perguruan Tinggi</option>
					</select>
				</div>
				<div class="filter-item filter-actions">
					<button class="btn btn-filter" onclick="filterData()">
						<i class="fas fa-search"></i> Filter
					</button>
					<button class="btn btn-reset" onclick="resetFilter()">
						<i class="fas fa-redo"></i> Reset
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Daftar Anak</h3>
			<span class="data-count"><?php echo count($anak); ?> data</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableLaporanAnak">
					<thead>
						<tr>
							<th>No</th>
							<th>NIK</th>
							<th>Nama Anak</th>
							<th>Jenis Kelamin</th>
							<th>Tempat/Tgl Lahir</th>
							<th>Usia</th>
							<th>Pendidikan</th>
							<th>Status</th>
							<th>Tanggal Masuk</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($anak as $a): ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><?php echo $a->nik ?: '-'; ?></td>
								<td>
									<div class="user-cell">
										<div
											class="user-avatar bg-<?php echo $a->jenis_kelamin == 'L' ? 'blue' : 'pink'; ?>">
											<?php echo strtoupper(substr($a->nama_anak, 0, 1)); ?>
										</div>
										<span><?php echo $a->nama_anak; ?></span>
									</div>
								</td>
								<td>
									<span class="badge-jk badge-<?php echo $a->jenis_kelamin == 'L' ? 'blue' : 'pink'; ?>">
										<?php echo $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
									</span>
								</td>
								<td><?php echo $a->tempat_lahir . ', ' . tanggal_indo($a->tanggal_lahir); ?></td>
								<td><?php echo umur($a->tanggal_lahir); ?></td>
								<td><?php echo $a->pendidikan; ?></td>
								<td>
									<span
										class="badge-status badge-<?php echo $a->status_anak == 'Aktif' ? 'green' : 'gray'; ?>">
										<?php echo $a->status_anak; ?>
									</span>
								</td>
								<td><?php echo tanggal_indo($a->tanggal_masuk); ?></td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($anak)): ?>
							<tr>
								<td colspan="9" class="text-center text-muted py-4">
									<i class="fas fa-inbox fa-2x mb-2"></i><br>
									Belum ada data anak
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
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
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.btn-export-pdf {
		background: #e74a3b;
		color: #fff;
	}

	.btn-export-pdf:hover {
		background: #c0392b;
	}

	.btn-export-excel {
		background: #1cc88a;
		color: #fff;
	}

	.btn-export-excel:hover {
		background: #13855c;
	}

	/* Stats Row */
	.stats-row {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
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

	.stat-blue .stat-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.stat-orange .stat-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.stat-pink .stat-icon {
		background: rgba(232, 62, 140, 0.1);
		color: #e83e8c;
	}

	.stat-info {
		display: flex;
		flex-direction: column;
	}

	.stat-number {
		font-size: 28px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.stat-label {
		font-size: 13px;
		color: #718096;
		margin-top: 5px;
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
		color: #4e73df;
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

	.form-select:focus {
		outline: none;
		border-color: #4e73df;
		box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
	}

	.filter-actions {
		display: flex;
		gap: 10px;
	}

	.btn-filter {
		padding: 10px 20px;
		background: #4e73df;
		color: #fff;
		border: none;
		border-radius: 8px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s;
	}

	.btn-filter:hover {
		background: #2e59d9;
	}

	.btn-reset {
		padding: 10px 20px;
		background: #f8fafc;
		color: #718096;
		border: 1px solid #e2e8f0;
		border-radius: 8px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s;
	}

	.btn-reset:hover {
		background: #edf2f7;
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
		display: flex;
		justify-content: space-between;
		align-items: center;
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
		color: #4e73df;
	}

	.data-count {
		background: #f8fafc;
		padding: 6px 14px;
		border-radius: 20px;
		font-size: 13px;
		color: #718096;
		font-weight: 500;
	}

	.panel-body {
		padding: 0;
	}

	.table-responsive {
		overflow-x: auto;
	}

	/* Data Table */
	.data-table {
		width: 100%;
		border-collapse: collapse;
	}

	.data-table th {
		padding: 15px 20px;
		text-align: left;
		font-size: 12px;
		font-weight: 600;
		color: #718096;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		background: #f8fafc;
		border-bottom: 1px solid #e2e8f0;
	}

	.data-table td {
		padding: 16px 20px;
		border-bottom: 1px solid #edf2f7;
		vertical-align: middle;
		font-size: 14px;
		color: #2d3748;
	}

	.data-table tbody tr:hover {
		background: #f8fafc;
	}

	.data-table tbody tr:last-child td {
		border-bottom: none;
	}

	/* User Cell */
	.user-cell {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.user-avatar {
		width: 36px;
		height: 36px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		font-weight: 600;
		font-size: 14px;
	}

	/* Badges */
	.badge-jk,
	.badge-status {
		display: inline-flex;
		padding: 5px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-blue {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.badge-pink {
		background: rgba(232, 62, 140, 0.1);
		color: #e83e8c;
	}

	.badge-green {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.badge-gray {
		background: rgba(113, 128, 150, 0.1);
		color: #718096;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.filter-grid {
			grid-template-columns: repeat(2, 1fr);
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

	/* Dark Mode Styles for laporan/data_anak.php */
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

	body.dark-mode .form-select {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .form-select:focus {
		border-color: #00d9ff;
	}

	body.dark-mode .btn-reset {
		background-color: #0f3460;
		color: #a0a0a0;
		border-color: #0f3460;
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

	body.dark-mode .data-count {
		background-color: #0f3460;
		color: #a0a0a0;
	}

	body.dark-mode .data-table {
		color: #e0e0e0;
	}

	body.dark-mode .data-table th {
		background-color: #0f3460;
		color: #e0e0e0;
		border-bottom-color: #0f3460;
	}

	body.dark-mode .data-table td {
		border-bottom-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .data-table tbody tr:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}
</style>

<script>
	function filterData() {
		// Implement filter logic here
		alert('Filter functionality will be implemented');
	}

	function resetFilter() {
		document.getElementById('filterStatus').value = '';
		document.getElementById('filterJenisKelamin').value = '';
		document.getElementById('filterPendidikan').value = '';
	}
</script>