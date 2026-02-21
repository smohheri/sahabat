<!-- Laporan Pengurus - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-purple">
				<i class="fas fa-user-tie"></i>
			</div>
			<div>
				<h2>Laporan Data Pengurus</h2>
				<p>Data lengkap pengurus, staff, dan struktur organisasi</p>
			</div>
		</div>
		<div class="header-actions">
			<a href="<?php echo site_url('admin/export_pdf_pengurus'); ?>" class="btn btn-export-pdf" target="_blank">
				<i class="fas fa-file-pdf"></i> Export PDF
			</a>
			<a href="<?php echo site_url('admin/export_excel_pengurus'); ?>" class="btn btn-export-excel">
				<i class="fas fa-file-excel"></i> Export Excel
			</a>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="stats-row">
		<div class="stat-card stat-purple">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($pengurus); ?></span>
				<span class="stat-label">Total Pengurus</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-id-card"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($pengurus, function ($p) {
					return !empty($p->file_ktp);
				})); ?></span>
				<span class="stat-label">Sudah Upload KTP</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-exclamation-triangle"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($pengurus, function ($p) {
					return empty($p->file_ktp);
				})); ?></span>
				<span class="stat-label">Belum Upload KTP</span>
			</div>
		</div>
	</div>

	<!-- Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Daftar Pengurus</h3>
			<span class="data-count"><?php echo count($pengurus); ?> data</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Pengurus</th>
							<th>Jabatan</th>
							<th>No HP</th>
							<th>Email</th>
							<th>Status KTP</th>
							<th>Tanggal Bergabung</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($pengurus as $p): ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td>
									<div class="user-cell">
										<div class="user-avatar bg-purple">
											<?php echo strtoupper(substr($p->nama_pengurus, 0, 1)); ?>
										</div>
										<span><?php echo $p->nama_pengurus; ?></span>
									</div>
								</td>
								<td><?php echo $p->jabatan; ?></td>
								<td><?php echo $p->no_hp; ?></td>
								<td><?php echo $p->email ?: '-'; ?></td>
								<td>
									<?php if (!empty($p->file_ktp)): ?>
										<span class="badge-status badge-green">
											<i class="fas fa-check"></i> Ada
										</span>
									<?php else: ?>
										<span class="badge-status badge-red">
											<i class="fas fa-times"></i> Belum
										</span>
									<?php endif; ?>
								</td>
								<td><?php echo tanggal_indo($p->created_at); ?></td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($pengurus)): ?>
							<tr>
								<td colspan="7" class="text-center text-muted py-4">
									<i class="fas fa-inbox fa-2x mb-2"></i><br>
									Belum ada data pengurus
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Struktur Organisasi Info -->
	<div class="info-card">
		<div class="info-icon">
			<i class="fas fa-sitemap"></i>
		</div>
		<div class="info-content">
			<h4>Struktur Organisasi</h4>
			<p>Diagram struktur organisasi dapat dilihat pada halaman Data Pengurus.</p>
		</div>
		<a href="<?php echo site_url('admin/pengurus'); ?>" class="btn btn-info">
			<i class="fas fa-arrow-right"></i> Lihat
		</a>
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

	.bg-purple {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
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

	.stat-purple .stat-icon {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
	}

	.stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.stat-orange .stat-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
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

	/* Data Panel */
	.data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 25px;
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
		color: #6f42c1;
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

	.bg-purple {
		background: #6f42c1;
	}

	/* Badges */
	.badge-status {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding: 5px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-green {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.badge-red {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	/* Info Card */
	.info-card {
		background: #fff;
		border-radius: 14px;
		padding: 25px;
		display: flex;
		align-items: center;
		gap: 20px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.info-icon {
		width: 50px;
		height: 50px;
		background: rgba(78, 115, 223, 0.1);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 22px;
		color: #4e73df;
	}

	.info-content {
		flex: 1;
	}

	.info-content h4 {
		margin: 0 0 5px;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
	}

	.info-content p {
		margin: 0;
		font-size: 14px;
		color: #718096;
	}

	.btn-info {
		padding: 10px 20px;
		background: #4e73df;
		color: #fff;
		border-radius: 8px;
		text-decoration: none;
		font-weight: 500;
		display: flex;
		align-items: center;
		gap: 8px;
		transition: all 0.3s ease;
	}

	.btn-info:hover {
		background: #2e59d9;
	}

	/* Responsive */
	@media (max-width: 992px) {
		.stats-row {
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

		.info-card {
			flex-direction: column;
			text-align: center;
		}
	}

	/* Dark Mode Styles for laporan/pengurus.php */
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

	body.dark-mode .info-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .info-content h4 {
		color: #e0e0e0;
	}

	body.dark-mode .info-content p {
		color: #a0a0a0;
	}
</style>