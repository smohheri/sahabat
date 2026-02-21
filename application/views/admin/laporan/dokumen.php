<!-- Laporan Dokumen - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-orange">
				<i class="fas fa-folder-open"></i>
			</div>
			<div>
				<h2>Laporan Kelengkapan Dokumen</h2>
				<p>Monitoring kelengkapan dokumen anak asuh</p>
			</div>
		</div>
		<div class="header-actions">
			<a href="<?php echo site_url('admin/export_pdf_dokumen'); ?>" class="btn btn-export-pdf" target="_blank">
				<i class="fas fa-file-pdf"></i> Export PDF
			</a>
			<a href="<?php echo site_url('admin/export_excel_dokumen'); ?>" class="btn btn-export-excel">
				<i class="fas fa-file-excel"></i> Export Excel
			</a>
		</div>
	</div>

	<!-- Stats Cards -->
	<div class="stats-row">
		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-file-alt"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return !empty($a->file_kk);
				})); ?></span>
				<span class="stat-label">Punya KK</span>
			</div>
		</div>

		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-certificate"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return !empty($a->file_akta);
				})); ?></span>
				<span class="stat-label">Punya Akta</span>
			</div>
		</div>

		<div class="stat-card stat-purple">
			<div class="stat-icon">
				<i class="fas fa-camera"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return !empty($a->foto);
				})); ?></span>
				<span class="stat-label">Punya Foto</span>
			</div>
		</div>

		<div class="stat-card stat-yellow">
			<div class="stat-icon">
				<i class="fas fa-folder"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return !empty($a->file_pendukung);
				})); ?></span>
				<span class="stat-label">Dokumen Pendukung</span>
			</div>
		</div>

		<div class="stat-card stat-red">
			<div class="stat-icon">
				<i class="fas fa-exclamation-triangle"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return empty($a->file_kk) || empty($a->file_akta);
				})); ?></span>
				<span class="stat-label">Dokumen Kurang</span>
			</div>
		</div>
	</div>

	<!-- Progress Card -->
	<div class="progress-card">
		<div class="progress-header">
			<h3><i class="fas fa-chart-bar"></i> Progress Kelengkapan</h3>
		</div>
		<div class="progress-body">
			<?php
			$total = count($anak);
			$punya_kk = count(array_filter($anak, function ($a) {
				return !empty($a->file_kk);
			}));
			$punya_akta = count(array_filter($anak, function ($a) {
				return !empty($a->file_akta);
			}));
			$punya_foto = count(array_filter($anak, function ($a) {
				return !empty($a->foto);
			}));
			$punya_pendukung = count(array_filter($anak, function ($a) {
				return !empty($a->file_pendukung);
			}));

			$persen_kk = $total > 0 ? round(($punya_kk / $total) * 100) : 0;
			$persen_akta = $total > 0 ? round(($punya_akta / $total) * 100) : 0;
			$persen_foto = $total > 0 ? round(($punya_foto / $total) * 100) : 0;
			$persen_pendukung = $total > 0 ? round(($punya_pendukung / $total) * 100) : 0;
			?>
			<div class="progress-item">
				<div class="progress-label">
					<span class="progress-title">Kartu Keluarga (KK)</span>
					<span class="progress-value"><?php echo $punya_kk; ?> / <?php echo $total; ?> anak
						(<?php echo $persen_kk; ?>%)</span>
				</div>
				<div class="progress-bar-wrap">
					<div class="progress-bar-fill" style="width: <?php echo $persen_kk; ?>%; background: #1cc88a;">
					</div>
				</div>
			</div>

			<div class="progress-item">
				<div class="progress-label">
					<span class="progress-title">Akta Kelahiran</span>
					<span class="progress-value"><?php echo $punya_akta; ?> / <?php echo $total; ?> anak
						(<?php echo $persen_akta; ?>%)</span>
				</div>
				<div class="progress-bar-wrap">
					<div class="progress-bar-fill" style="width: <?php echo $persen_akta; ?>%; background: #4e73df;">
					</div>
				</div>
			</div>

			<div class="progress-item">
				<div class="progress-label">
					<span class="progress-title">Foto</span>
					<span class="progress-value"><?php echo $punya_foto; ?> / <?php echo $total; ?> anak
						(<?php echo $persen_foto; ?>%)</span>
				</div>
				<div class="progress-bar-wrap">
					<div class="progress-bar-fill" style="width: <?php echo $persen_foto; ?>%; background: #6f42c1;">
					</div>
				</div>
			</div>

			<div class="progress-item">
				<div class="progress-label">
					<span class="progress-title">Dokumen Pendukung</span>
					<span class="progress-value">
						<?php echo $punya_pendukung; ?> /
						<?php echo $total; ?> anak
						(
						<?php echo $persen_pendukung; ?>%)
					</span>
				</div>
				<div class="progress-bar-wrap">
					<div class="progress-bar-fill"
						style="width: <?php echo $persen_pendukung; ?>%; background: #f6c23e;"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Detail Dokumen per Anak</h3>
			<span class="data-count"><?php echo count($anak); ?> data</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Anak</th>
							<th>NIK</th>
							<th>KK</th>
							<th>Akta</th>
							<th>Foto</th>
							<th>Pendukung</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($anak as $a):
							$lengkap = !empty($a->file_kk) && !empty($a->file_akta);
							?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td>
									<div class="user-cell">
										<div class="user-avatar bg-blue">
											<?php echo strtoupper(substr($a->nama_anak, 0, 1)); ?>
										</div>
										<span><?php echo $a->nama_anak; ?></span>
									</div>
								</td>
								<td><?php echo $a->nik ?: '-'; ?></td>
								<td>
									<?php if (!empty($a->file_kk)): ?>
										<span class="badge-status badge-green"><i class="fas fa-check"></i> Ada</span>
									<?php else: ?>
										<span class="badge-status badge-red"><i class="fas fa-times"></i> Belum</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if (!empty($a->file_akta)): ?>
										<span class="badge-status badge-green"><i class="fas fa-check"></i> Ada</span>
									<?php else: ?>
										<span class="badge-status badge-red"><i class="fas fa-times"></i> Belum</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if (!empty($a->foto)): ?>
										<span class="badge-status badge-purple"><i class="fas fa-check"></i> Ada</span>
									<?php else: ?>
										<span class="badge-status badge-gray"><i class="fas fa-minus"></i> -</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if (!empty($a->file_pendukung)): ?>
										<span class="badge-status badge-yellow"><i class="fas fa-check"></i> Ada</span>
									<?php else: ?>
										<span class="badge-status badge-gray"><i class="fas fa-minus"></i> -</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if ($lengkap): ?>
										<span class="badge-status badge-green"><i class="fas fa-check-circle"></i>
											Lengkap</span>
									<?php else: ?>
										<span class="badge-status badge-red"><i class="fas fa-exclamation-circle"></i>
											Kurang</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($anak)): ?>
							<tr>
								<td colspan="8" class="text-center text-muted py-4">
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

	.bg-orange {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.bg-yellow {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.bg-red {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
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

	.stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.stat-blue .stat-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.stat-yellow .stat-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.stat-red .stat-icon {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
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

	/* Progress Card */
	.progress-card {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.progress-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
	}

	.progress-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.progress-header i {
		color: #f6c23e;
	}

	.progress-body {
		padding: 25px;
	}

	.progress-item {
		margin-bottom: 20px;
	}

	.progress-item:last-child {
		margin-bottom: 0;
	}

	.progress-label {
		display: flex;
		justify-content: space-between;
		margin-bottom: 10px;
	}

	.progress-title {
		font-size: 14px;
		font-weight: 500;
		color: #2d3748;
	}

	.progress-value {
		font-size: 13px;
		color: #718096;
	}

	.progress-bar-wrap {
		height: 12px;
		background: #edf2f7;
		border-radius: 6px;
		overflow: hidden;
	}

	.progress-bar-fill {
		height: 100%;
		border-radius: 6px;
		transition: width 0.5s ease;
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
		color: #f6c23e;
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

	.bg-blue {
		background: #4e73df;
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

	.badge-yellow {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.badge-purple {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
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
	}

	/* Dark Mode Styles for laporan/dokumen.php */
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

	body.dark-mode .progress-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .progress-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .progress-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .progress-label {
		background-color: #16213e;
	}

	body.dark-mode .progress-title {
		color: #e0e0e0;
	}

	body.dark-mode .progress-value {
		color: #a0a0a0;
	}

	body.dark-mode .progress-bar-wrap {
		background-color: #0f3460;
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