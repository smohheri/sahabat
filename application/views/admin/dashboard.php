<!-- Clean & Colorful Dashboard -->
<div class="dashboard-clean">
	<!-- Main Stats - 4 Cards -->
	<div class="stats-row">
		<div class="stat-card card-blue">
			<div class="card-content">
				<div class="card-number"><?php echo $total_anak; ?></div>
				<div class="card-label">Total Anak</div>
			</div>
			<div class="card-icon">
				<i class="fas fa-child"></i>
			</div>
		</div>

		<div class="stat-card card-green">
			<div class="card-content">
				<div class="card-number"><?php echo $dokumen_lengkap; ?></div>
				<div class="card-label">Dokumen Lengkap</div>
			</div>
			<div class="card-icon">
				<i class="fas fa-check-circle"></i>
			</div>
		</div>

		<div class="stat-card card-orange">
			<div class="card-content">
				<div class="card-number"><?php echo $dokumen_kurang; ?></div>
				<div class="card-label">Dokumen Kurang</div>
			</div>
			<div class="card-icon">
				<i class="fas fa-exclamation-circle"></i>
			</div>
		</div>

		<div class="stat-card card-purple">
			<div class="card-content">
				<div class="card-number"><?php echo $total_pengurus; ?></div>
				<div class="card-label">Pengurus</div>
			</div>
			<div class="card-icon">
				<i class="fas fa-user-tie"></i>
			</div>
		</div>
	</div>

	<!-- Secondary Stats - Baris 1: Status -->
	<div class="substats-row">
		<div class="substat-item">
			<div class="substat-icon bg-green-light">
				<i class="fas fa-user-check text-green"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $anak_aktif; ?></span>
				<span class="substat-label">Status Aktif</span>
			</div>
		</div>

		<div class="substat-item">
			<div class="substat-icon bg-gray-light">
				<i class="fas fa-user-slash text-gray"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $anak_nonaktif; ?></span>
				<span class="substat-label">Status Nonaktif</span>
			</div>
		</div>

		<div class="substat-item">
			<div class="substat-icon bg-blue-light">
				<i class="fas fa-child text-blue"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $pendidikan_sd; ?></span>
				<span class="substat-label">Pendidikan SD/MI</span>
			</div>
		</div>
	</div>

	<!-- Secondary Stats - Baris 2: Pendidikan -->
	<div class="substats-row">
		<div class="substat-item">
			<div class="substat-icon bg-purple-light">
				<i class="fas fa-book text-purple"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $pendidikan_smp; ?></span>
				<span class="substat-label">Pendidikan SMP/MTS</span>
			</div>
		</div>

		<div class="substat-item">
			<div class="substat-icon bg-orange-light">
				<i class="fas fa-graduation-cap text-orange"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $pendidikan_sma; ?></span>
				<span class="substat-label">Pendidikan SMA/SMK</span>
			</div>
		</div>

		<div class="substat-item">
			<div class="substat-icon bg-pink-light">
				<i class="fas fa-university text-pink"></i>
			</div>
			<div class="substat-info">
				<span class="substat-value"><?php echo $pendidikan_pt; ?></span>
				<span class="substat-label">Perguruan Tinggi</span>
			</div>
		</div>
	</div>

	<!-- Content Grid -->
	<div class="content-grid">
		<!-- Left: Data Tables -->
		<div class="content-main">
			<!-- Anak Table -->
			<div class="panel">
				<div class="panel-header">
					<h3><i class="fas fa-users text-blue"></i> Data Anak Terbaru</h3>
					<a href="<?php echo site_url('admin/anak'); ?>" class="btn-link">Lihat Semua →</a>
				</div>
				<div class="panel-body">
					<table class="clean-table">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>JK</th>
								<th>Status</th>
								<th>Dokumen</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($anak_terbaru as $a):
								$has_dokumen = !empty($a->file_kk) && !empty($a->file_akta);
								?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td>
										<div class="user-cell">
											<div
												class="user-avatar-sm bg-<?php echo $a->jenis_kelamin == 'L' ? 'blue' : 'pink'; ?>">
												<?php echo strtoupper(substr($a->nama_anak, 0, 1)); ?>
											</div>
											<span><?php echo $a->nama_anak; ?></span>
										</div>
									</td>
									<td>
										<span
											class="badge-sm badge-<?php echo $a->jenis_kelamin == 'L' ? 'blue' : 'pink'; ?>">
											<?php echo $a->jenis_kelamin == 'L' ? 'L' : 'P'; ?>
										</span>
									</td>
									<td>
										<span
											class="badge-sm badge-<?php echo $a->status_anak == 'Aktif' ? 'green' : 'gray'; ?>">
											<?php echo $a->status_anak; ?>
										</span>
									</td>
									<td>
										<?php if ($has_dokumen): ?>
											<i class="fas fa-check-circle text-green"></i>
										<?php else: ?>
											<i class="fas fa-times-circle text-red"></i>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							<?php if (empty($anak_terbaru)): ?>
								<tr>
									<td colspan="5" class="text-center text-muted py-4">
										Belum ada data anak
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Pengurus List -->
			<div class="panel mt-4">
				<div class="panel-header">
					<h3><i class="fas fa-user-tie text-purple"></i> Pengurus Terbaru</h3>
					<a href="<?php echo site_url('admin/pengurus'); ?>" class="btn-link">Lihat Semua →</a>
				</div>
				<div class="panel-body">
					<div class="list-clean">
						<?php foreach ($pengurus_terbaru as $p): ?>
							<div class="list-item">
								<div class="item-avatar bg-purple">
									<?php echo strtoupper(substr($p->nama_pengurus, 0, 1)); ?>
								</div>
								<div class="item-info">
									<div class="item-title"><?php echo $p->nama_pengurus; ?></div>
									<div class="item-subtitle"><?php echo $p->jabatan; ?></div>
								</div>
								<a href="tel:<?php echo $p->no_hp; ?>" class="item-action">
									<i class="fas fa-phone"></i>
								</a>
							</div>
						<?php endforeach; ?>
						<?php if (empty($pengurus_terbaru)): ?>
							<div class="text-center text-muted py-4">
								Belum ada data pengurus
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Right: Summary & Actions -->
		<div class="content-side">
			<!-- Summary -->
			<div class="panel">
				<div class="panel-header">
					<h3><i class="fas fa-chart-pie text-green"></i> Ringkasan</h3>
				</div>
				<div class="panel-body">
					<div class="summary-clean">
						<div class="sum-row">
							<span class="sum-dot bg-blue"></span>
							<span class="sum-label">Total Anak</span>
							<span class="sum-value"><?php echo $total_anak; ?></span>
						</div>
						<div class="sum-row">
							<span class="sum-dot bg-blue-light2"></span>
							<span class="sum-label">Laki-laki</span>
							<span class="sum-value"><?php echo $anak_laki; ?></span>
						</div>
						<div class="sum-row">
							<span class="sum-dot bg-pink"></span>
							<span class="sum-label">Perempuan</span>
							<span class="sum-value"><?php echo $anak_perempuan; ?></span>
						</div>
						<div class="sum-row">
							<span class="sum-dot bg-green"></span>
							<span class="sum-label">Dokumen Lengkap</span>
							<span class="sum-value"><?php echo $dokumen_lengkap; ?></span>
						</div>
						<div class="sum-row">
							<span class="sum-dot bg-orange"></span>
							<span class="sum-label">Dokumen Kurang</span>
							<span class="sum-value"><?php echo $dokumen_kurang; ?></span>
						</div>
						<div class="sum-row">
							<span class="sum-dot bg-purple"></span>
							<span class="sum-label">Foto Tersedia</span>
							<span class="sum-value">
								<?php echo count(array_filter($anak_terbaru, function ($a) {
									return !empty($a->foto);
								})); ?>
							</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Quick Actions -->
			<div class="panel mt-4">
				<div class="panel-header">
					<h3><i class="fas fa-bolt text-orange"></i> Aksi Cepat</h3>
				</div>
				<div class="panel-body">
					<div class="actions-grid">
						<a href="<?php echo site_url('admin/anak'); ?>" class="action-box action-blue">
							<i class="fas fa-user-plus"></i>
							<span>Tambah Anak</span>
						</a>
						<a href="<?php echo site_url('admin/pengurus'); ?>" class="action-box action-green">
							<i class="fas fa-user-tie"></i>
							<span>Tambah Pengurus</span>
						</a>
						<a href="<?php echo site_url('admin/laporan/data_anak'); ?>" class="action-box action-purple">
							<i class="fas fa-file-alt"></i>
							<span>Laporan</span>
						</a>
						<a href="<?php echo site_url('admin/laporan/dokumen'); ?>" class="action-box action-orange">
							<i class="fas fa-folder-open"></i>
							<span>Cek Dokumen</span>
						</a>
					</div>
				</div>
			</div>

			<!-- Info -->
			<div class="info-box-clean">
				<i class="fas fa-info-circle"></i>
				<p>Data ditampilkan real-time dari sistem LKSA</p>
			</div>
		</div>
	</div>
</div>

<style>
	/* Clean Dashboard Styles */
	.dashboard-clean {
		padding: 10px;
	}

	/* Main Stats Row */
	.stats-row {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.stat-card {
		background: #fff;
		border-radius: 16px;
		padding: 25px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
		border: 2px solid transparent;
	}

	.stat-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
	}

	.card-blue {
		border-bottom: 4px solid #4e73df;
	}

	.card-blue .card-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.card-green {
		border-bottom: 4px solid #1cc88a;
	}

	.card-green .card-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.card-orange {
		border-bottom: 4px solid #f6c23e;
	}

	.card-orange .card-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.card-purple {
		border-bottom: 4px solid #6f42c1;
	}

	.card-purple .card-icon {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
	}

	.card-number {
		font-size: 36px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.card-label {
		font-size: 14px;
		color: #718096;
		margin-top: 5px;
	}

	.card-icon {
		width: 60px;
		height: 60px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 28px;
	}

	/* Secondary Stats */
	.substats-row {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 15px;
		margin-bottom: 15px;
	}

	.substats-row:last-child {
		margin-bottom: 30px;
	}

	.substat-item {
		background: #fff;
		border-radius: 12px;
		padding: 20px;
		display: flex;
		align-items: center;
		gap: 15px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
	}

	.substat-icon {
		width: 45px;
		height: 45px;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
	}

	.bg-blue-light {
		background: rgba(78, 115, 223, 0.1);
	}

	.bg-pink-light {
		background: rgba(232, 62, 140, 0.1);
	}

	.bg-green-light {
		background: rgba(28, 200, 138, 0.1);
	}

	.bg-orange-light {
		background: rgba(246, 194, 62, 0.1);
	}

	.bg-red-light {
		background: rgba(231, 74, 59, 0.1);
	}

	.text-blue {
		color: #4e73df;
	}

	.text-pink {
		color: #e83e8c;
	}

	.text-green {
		color: #1cc88a;
	}

	.text-orange {
		color: #f6c23e;
	}

	.text-red {
		color: #e74a3b;
	}

	.substat-info {
		display: flex;
		flex-direction: column;
	}

	.substat-value {
		font-size: 24px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.substat-label {
		font-size: 13px;
		color: #718096;
	}

	/* Content Grid */
	.content-grid {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 25px;
	}

	/* Panels */
	.panel {
		background: #fff;
		border-radius: 16px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		overflow: hidden;
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

	.btn-link {
		color: #4e73df;
		text-decoration: none;
		font-size: 14px;
		font-weight: 500;
	}

	.btn-link:hover {
		color: #2d3748;
	}

	.panel-body {
		padding: 0;
	}

	/* Clean Table */
	.clean-table {
		width: 100%;
		border-collapse: collapse;
	}

	.clean-table th {
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

	.clean-table td {
		padding: 18px 20px;
		border-bottom: 1px solid #edf2f7;
		vertical-align: middle;
	}

	.clean-table tbody tr:hover {
		background: #f8fafc;
	}

	.clean-table tbody tr:last-child td {
		border-bottom: none;
	}

	/* User Cell */
	.user-cell {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.user-avatar-sm {
		width: 35px;
		height: 35px;
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

	.bg-pink {
		background: #e83e8c;
	}

	.bg-green {
		background: #1cc88a;
	}

	.bg-purple {
		background: #6f42c1;
	}

	.bg-orange {
		background: #f6c23e;
	}

	.bg-gray {
		background: #718096;
	}

	.bg-teal {
		background: #20c997;
	}

	.bg-gray-light {
		background: rgba(113, 128, 150, 0.1);
	}

	.bg-purple-light {
		background: rgba(111, 66, 193, 0.1);
	}

	.bg-teal-light {
		background: rgba(32, 201, 151, 0.1);
	}

	.text-teal {
		color: #20c997;
	}

	/* Badges */
	.badge-sm {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 600;
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

	/* List Clean */
	.list-clean {
		padding: 10px;
	}

	.list-item {
		display: flex;
		align-items: center;
		gap: 15px;
		padding: 15px;
		border-radius: 10px;
		transition: all 0.2s;
	}

	.list-item:hover {
		background: #f8fafc;
	}

	.item-avatar {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
		font-weight: 600;
	}

	.item-info {
		flex: 1;
	}

	.item-title {
		font-weight: 600;
		color: #2d3748;
		font-size: 14px;
	}

	.item-subtitle {
		font-size: 13px;
		color: #718096;
		margin-top: 2px;
	}

	.item-action {
		width: 35px;
		height: 35px;
		border-radius: 8px;
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
		display: flex;
		align-items: center;
		justify-content: center;
		text-decoration: none;
	}

	.item-action:hover {
		background: #1cc88a;
		color: #fff;
	}

	/* Summary Clean */
	.summary-clean {
		padding: 10px;
	}

	.sum-row {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 12px 0;
		border-bottom: 1px solid #edf2f7;
	}

	.sum-row:last-child {
		border-bottom: none;
	}

	.sum-dot {
		width: 12px;
		height: 12px;
		border-radius: 50%;
	}

	.bg-blue-light2 {
		background: rgba(78, 115, 223, 0.3);
	}

	.sum-label {
		flex: 1;
		font-size: 14px;
		color: #4a5568;
	}

	.sum-value {
		font-weight: 700;
		color: #2d3748;
		font-size: 16px;
	}

	/* Actions Grid */
	.actions-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 12px;
		padding: 10px;
	}

	.action-box {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 8px;
		padding: 20px;
		border-radius: 12px;
		text-decoration: none;
		transition: all 0.3s ease;
		text-align: center;
	}

	.action-box i {
		font-size: 24px;
	}

	.action-box span {
		font-size: 13px;
		font-weight: 500;
	}

	.action-blue {
		background: rgba(78, 115, 223, 0.08);
		color: #4e73df;
	}

	.action-blue:hover {
		background: #4e73df;
		color: #fff;
	}

	.action-green {
		background: rgba(28, 200, 138, 0.08);
		color: #1cc88a;
	}

	.action-green:hover {
		background: #1cc88a;
		color: #fff;
	}

	.action-purple {
		background: rgba(111, 66, 193, 0.08);
		color: #6f42c1;
	}

	.action-purple:hover {
		background: #6f42c1;
		color: #fff;
	}

	.action-orange {
		background: rgba(246, 194, 62, 0.08);
		color: #f6c23e;
	}

	.action-orange:hover {
		background: #f6c23e;
		color: #fff;
	}

	/* Info Box */
	.info-box-clean {
		margin-top: 20px;
		padding: 20px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 12px;
		color: #fff;
		display: flex;
		align-items: center;
		gap: 15px;
	}

	.info-box-clean i {
		font-size: 24px;
		opacity: 0.9;
	}

	.info-box-clean p {
		margin: 0;
		font-size: 14px;
		opacity: 0.9;
	}

	/* Utilities */
	.mt-4 {
		margin-top: 20px;
	}

	.text-muted {
		color: #718096;
	}

	.text-center {
		text-align: center;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.substats-row {
			grid-template-columns: repeat(3, 1fr);
		}

		.content-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 768px) {
		.stats-row {
			grid-template-columns: 1fr;
		}

		.substats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.stat-card {
			padding: 20px;
		}

		.card-number {
			font-size: 28px;
		}
	}

	/* Dark Mode Styles for dashboard.php */
	body.dark-mode .dashboard-clean {
		background-color: #1a1a2e;
	}

	body.dark-mode .stat-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .card-number {
		color: #e0e0e0;
	}

	body.dark-mode .card-label {
		color: #a0a0a0;
	}

	body.dark-mode .substat-item {
		background-color: #16213e;
	}

	body.dark-mode .substat-value {
		color: #e0e0e0;
	}

	body.dark-mode .substat-label {
		color: #a0a0a0;
	}

	body.dark-mode .panel {
		background-color: #16213e;
	}

	body.dark-mode .panel-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .panel-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .clean-table th {
		background-color: #0f3460;
		color: #e0e0e0;
		border-bottom-color: #0f3460;
	}

	body.dark-mode .clean-table td {
		border-bottom-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .clean-table tbody tr:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .item-title {
		color: #e0e0e0;
	}

	body.dark-mode .item-subtitle {
		color: #a0a0a0;
	}

	body.dark-mode .sum-row {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .sum-label {
		color: #a0a0a0;
	}

	body.dark-mode .sum-value {
		color: #e0e0e0;
	}

	body.dark-mode .btn-link {
		color: #00d9ff;
	}

	body.dark-mode .btn-link:hover {
		color: #fff;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}

	body.dark-mode .list-item:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .info-box-clean {
		background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
		border: 1px solid #00d9ff;
	}
</style>
