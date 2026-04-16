<!-- Log Aktivitas - Redesain Modern -->


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

	.user-avatar.bg-blue {
		background: #4e73df;
	}

	.user-avatar.bg-purple {
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

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}
	}

	@media (max-width: 768px) {
		.stats-row {
			grid-template-columns: 1fr;
		}
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
</style>

<script>
	$(document).ready(function () {
		// Initialize DataTable with server-side processing
		$('#tableLogs').DataTable({
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"autoWidth": false,
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
			"pageLength": 10,
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
</script>