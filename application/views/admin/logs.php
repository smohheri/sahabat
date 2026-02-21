<!-- Log Aktivitas - Redesain Modern -->

<!-- DataTables CSS -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">

<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-history"></i>
			</div>
			<div>
				<h2>Log Aktivitas User</h2>
				<p>Riwayat aktivitas dan tindakan pengguna dalam sistem LKSA</p>
			</div>
		</div>
	</div>

	<!-- Flash Messages -->
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
			<i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
			<i class="fas fa-exclamation-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<!-- Stats Cards -->
	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_logs ?? 0; ?></span>
				<span class="stat-label">Total Log</span>
			</div>
		</div>
		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-sign-in-alt"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $login_count ?? 0; ?></span>
				<span class="stat-label">Login</span>
			</div>
		</div>
		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-edit"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $edit_count ?? 0; ?></span>
				<span class="stat-label">Edit/Update</span>
			</div>
		</div>
		<div class="stat-card stat-pink">
			<div class="stat-icon">
				<i class="fas fa-plus"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $add_count ?? 0; ?></span>
				<span class="stat-label">Tambah/Upload</span>
			</div>
		</div>
	</div>

	<!-- Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Riwayat Aktivitas</h3>
			<span class="data-count"><?php echo $total_logs ?? 0; ?> aktivitas</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableLogs">
					<thead>
						<tr>
							<th>No</th>
							<th>User</th>
							<th>Aktivitas</th>
							<th>Deskripsi</th>
							<th>IP Address</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody>
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

	.bg-blue {
		background: #4e73df;
	}

	.bg-purple {
		background: #6f42c1;
	}

	.user-name {
		font-weight: 600;
		color: #2d3748;
		font-size: 14px;
	}

	.user-role {
		font-size: 12px;
		color: #718096;
		margin-top: 2px;
	}

	/* Activity Badges */
	.activity-badge {
		display: inline-flex;
		align-items: center;
		padding: 6px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
		text-transform: capitalize;
	}

	.badge-success {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.badge-warning {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.badge-info {
		background: rgba(23, 162, 184, 0.1);
		color: #17a2b8;
	}

	.badge-danger {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	.badge-primary {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	/* Alert Styles */
	.alert {
		border-radius: 10px;
		border: none;
		padding: 15px 20px;
		margin-bottom: 25px;
	}

	.alert-success {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.alert-danger {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
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

	/* Dark Mode Styles */
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

	body.dark-mode .user-name {
		color: #e0e0e0;
	}

	body.dark-mode .user-role {
		color: #a0a0a0;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}

	body.dark-mode .alert-success {
		background-color: rgba(28, 200, 138, 0.1);
		border-color: #1cc88a;
		color: #1cc88a;
	}

	body.dark-mode .alert-danger {
		background-color: rgba(231, 74, 59, 0.1);
		border-color: #e74a3b;
		color: #e74a3b;
	}

	/* DataTables Pagination Styling */
	.dataTables_wrapper .dataTables_paginate {
		padding: 20px 25px 15px 15px;
		margin-right: 15px;
	}

	.dataTables_wrapper .dataTables_info {
		padding: 25px 15px 15px 25px;
	}

	.dataTables_wrapper .dataTables_length {
		padding: 20px 15px 10px 25px;
	}

	.dataTables_wrapper .dataTables_filter {
		padding: 20px 25px 10px 15px;
		text-align: right;
	}

	.dataTables_wrapper .dataTables_filter input {
		padding: 6px 12px;
		border: 1px solid #ddd;
		border-radius: 4px;
		font-size: 14px;
	}

	.dataTables_wrapper .dataTables_filter label {
		font-weight: 500;
		color: #2d3748;
	}

	/* Dark mode for DataTables controls */
	body.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
		color: #e0e0e0 !important;
	}

	body.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		color: #fff !important;
		background: #0f3460 !important;
	}

	body.dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
		color: #fff !important;
		background: #4e73df !important;
	}

	body.dark-mode .dataTables_wrapper .dataTables_info {
		color: #a0a0a0;
	}

	body.dark-mode .dataTables_wrapper .dataTables_length select {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .dataTables_wrapper .dataTables_filter input {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .dataTables_wrapper .dataTables_filter input::placeholder {
		color: #a0a0a0;
	}

	body.dark-mode .dataTables_wrapper .dataTables_filter label {
		color: #e0e0e0;
	}
</style>

<script>
	// Load DataTables JS dynamically to ensure jQuery is loaded
	$.getScript("<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>", function () {
		$.getScript("<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>", function () {
			$(document).ready(function () {
				// Initialize DataTable with server-side processing
				$('#tableLogs').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": "<?php echo site_url('admin/logs_ajax'); ?>",
						"type": "POST"
					},
					"columns": [
						{ "data": 0, "orderable": false }, // No
						{ "data": 1, "orderable": false }, // User
						{ "data": 2, "orderable": false }, // Activity
						{ "data": 3, "orderable": false }, // Description
						{ "data": 4, "orderable": false }, // IP Address
						{ "data": 5, "orderable": true }  // Time
					],
					"order": [[5, 'desc']],
					"pageLength": 25,
					"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
					"language": {
						"processing": "Memproses...",
						"search": "Cari:",
						"lengthMenu": "Tampilkan _MENU_ data per halaman",
						"zeroRecords": "Tidak ada data log",
						"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
						"infoEmpty": "Tidak ada data yang tersedia",
						"infoFiltered": "(difilter dari _MAX_ total data)",
						"paginate": {
							"first": "Pertama",
							"last": "Terakhir",
							"next": "Selanjutnya",
							"previous": "Sebelumnya"
						}
					}
				});
			});
		});
	});
</script>