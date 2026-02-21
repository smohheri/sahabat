<!-- User Management - Redesain Modern -->
<div class="user-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-users"></i>
			</div>
			<div>
				<h2>Manajemen User</h2>
				<p>Kelola pengguna sistem dengan akses dan peran yang berbeda</p>
			</div>
		</div>
		<div class="header-actions">
			<?php if ($this->session->userdata('role') == 'admin'): ?>
				<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAdd">
					<i class="fas fa-plus"></i> Tambah User
				</button>
			<?php endif; ?>
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
		<?php
		$total_users = count($users);
		$admin_count = count(array_filter($users, function ($u) {
			return $u->role == 'admin';
		}));
		$operator_count = count(array_filter($users, function ($u) {
			return $u->role == 'operator';
		}));
		?>
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_users; ?></span>
				<span class="stat-label">Total User</span>
			</div>
		</div>

		<div class="stat-card stat-red">
			<div class="stat-icon">
				<i class="fas fa-shield-alt"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $admin_count; ?></span>
				<span class="stat-label">Admin</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-user-cog"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $operator_count; ?></span>
				<span class="stat-label">Operator</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-user-check"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_users; ?></span>
				<span class="stat-label">Aktif</span>
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
					<label>Role</label>
					<select class="form-select" id="filterRole">
						<option value="">Semua Role</option>
						<option value="admin">Admin</option>
						<option value="operator">Operator</option>
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
			<h3><i class="fas fa-list"></i> Daftar User</h3>
			<span class="data-count"><?php echo $total_users; ?> user</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableUsers">
					<thead class="bg-light">
						<tr>
							<th class="text-center" style="width: 60px;">No</th>
							<th>Nama Lengkap</th>
							<th>Username</th>
							<th class="text-center" style="width: 100px;">Role</th>
							<th class="text-center" style="width: 150px;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($users as $user): ?>
							<tr>
								<td class="text-center text-muted"><?php echo $no++; ?></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="rounded-circle bg-<?php echo $user->role == 'admin' ? 'danger' : 'info'; ?> text-white d-flex align-items-center justify-content-center mr-3 shadow-sm"
											style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
											<?php echo strtoupper(substr($user->nama, 0, 1)); ?>
										</div>
										<span class="font-weight-semibold"><?php echo $user->nama; ?></span>
									</div>
								</td>
								<td class="text-muted">
									<i class="fas fa-user text-muted mr-1"></i><?php echo $user->username; ?>
								</td>
								<td class="text-center">
									<span
										class="badge badge-<?php echo $user->role == 'admin' ? 'danger' : 'info'; ?> px-3 py-2 font-weight-normal">
										<i
											class="fas fa-<?php echo $user->role == 'admin' ? 'shield-alt' : 'user'; ?> mr-1"></i>
										<?php echo ucfirst($user->role); ?>
									</span>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<?php if ($this->session->userdata('role') == 'admin' || $user->id_user == $this->session->userdata('id_user')): ?>
											<button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
												data-target="#modalEdit<?php echo $user->id_user; ?>" title="Edit">
												<i class="fas fa-edit"></i>
											</button>
										<?php endif; ?>
										<?php if ($this->session->userdata('role') == 'admin'): ?>
											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
												data-target="#modalDelete<?php echo $user->id_user; ?>" title="Hapus">
												<i class="fas fa-trash"></i>
											</button>
										<?php endif; ?>
									</div>
								</td>
							</tr>

							<!-- Modal Edit -->
							<div class="modal fade" id="modalEdit<?php echo $user->id_user; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content border-0 shadow">
										<div class="modal-header bg-warning text-white">
											<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
												User</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<?php echo form_open('admin/user'); ?>
										<div class="modal-body p-4">
											<input type="hidden" name="id_user" value="<?php echo $user->id_user; ?>">

											<div class="form-group mb-3">
												<label class="font-weight-bold text-muted mb-2">Nama Lengkap</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text bg-light"><i
																class="fas fa-user text-primary"></i></span>
													</div>
													<input type="text" class="form-control" name="nama"
														value="<?php echo $user->nama; ?>" required>
												</div>
											</div>

											<div class="form-group mb-3">
												<label class="font-weight-bold text-muted mb-2">Username</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text bg-light"><i
																class="fas fa-id-card text-primary"></i></span>
													</div>
													<input type="text" class="form-control" name="username"
														value="<?php echo $user->username; ?>" required>
												</div>
											</div>

											<div class="form-group mb-3">
												<label class="font-weight-bold text-muted mb-2">Password Baru</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text bg-light"><i
																class="fas fa-lock text-primary"></i></span>
													</div>
													<input type="password" class="form-control" name="password"
														placeholder="Kosongkan jika tidak diubah">
												</div>
												<small class="text-muted">Biarkan kosong jika tidak ingin mengubah
													password</small>
											</div>

											<div class="form-group mb-0">
												<label class="font-weight-bold text-muted mb-2">Role</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text bg-light"><i
																class="fas fa-user-shield text-primary"></i></span>
													</div>
													<select class="form-control" name="role" required>
														<option value="admin" <?php echo $user->role == 'admin' ? 'selected' : ''; ?>>Admin</option>
														<option value="operator" <?php echo $user->role == 'operator' ? 'selected' : ''; ?>>Operator</option>
													</select>
												</div>
											</div>
										</div>
										<div class="modal-footer bg-light">
											<button type="button" class="btn btn-secondary"
												data-dismiss="modal">Batal</button>
											<button type="submit" class="btn btn-warning text-white font-weight-bold">
												<i class="fas fa-save mr-1"></i>Simpan Perubahan
											</button>
										</div>
										</form>
									</div>
								</div>
							</div>

							<!-- Modal Delete -->
							<div class="modal fade" id="modalDelete<?php echo $user->id_user; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered modal-sm">
									<div class="modal-content border-0 shadow text-center">
										<div class="modal-header bg-danger text-white">
											<h5 class="modal-title font-weight-bold"><i
													class="fas fa-trash-alt mr-2"></i>Hapus User</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body p-4">
											<div class="mb-3">
												<i class="fas fa-exclamation-circle text-warning fa-3x"></i>
											</div>
											<p class="mb-1">Apakah Anda yakin ingin menghapus user</p>
											<p class="font-weight-bold text-primary mb-3"><?php echo $user->nama; ?>?</p>
											<p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
										</div>
										<div class="modal-footer bg-light justify-content-center">
											<button type="button" class="btn btn-secondary px-4"
												data-dismiss="modal">Batal</button>
											<a href="<?php echo site_url('admin/user?delete=' . $user->id_user); ?>"
												class="btn btn-danger px-4 font-weight-bold">
												<i class="fas fa-trash mr-1"></i>Ya, Hapus
											</a>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Tambah User Baru</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<?php echo form_open('admin/user'); ?>
			<div class="modal-body p-4">
				<div class="form-group mb-3">
					<label class="font-weight-bold text-muted mb-2">Nama Lengkap</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
						</div>
						<input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap"
							required>
					</div>
				</div>

				<div class="form-group mb-3">
					<label class="font-weight-bold text-muted mb-2">Username</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-light"><i class="fas fa-id-card text-primary"></i></span>
						</div>
						<input type="text" class="form-control" name="username" placeholder="Masukkan username"
							required>
					</div>
				</div>

				<div class="form-group mb-3">
					<label class="font-weight-bold text-muted mb-2">Password</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
						</div>
						<input type="password" class="form-control" name="password" placeholder="Masukkan password"
							required>
					</div>
				</div>

				<div class="form-group mb-0">
					<label class="font-weight-bold text-muted mb-2">Role</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-light"><i
									class="fas fa-user-shield text-primary"></i></span>
						</div>
						<select class="form-control" name="role" required>
							<option value="">Pilih Role</option>
							<option value="admin">Admin</option>
							<option value="operator">Operator</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary font-weight-bold">
					<i class="fas fa-save mr-1"></i>Simpan
				</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		// Filter functionality
		function filterData() {
			var role = $('#filterRole').val().toLowerCase();
			var rows = $('#tableUsers tbody tr');

			rows.each(function () {
				var row = $(this);
				var roleCell = row.find('td').eq(3).text().toLowerCase();

				var showRow = true;

				if (role && roleCell.indexOf(role) === -1) {
					showRow = false;
				}

				if (showRow) {
					row.show();
				} else {
					row.hide();
				}
			});
		}

		function resetFilter() {
			$('#filterRole').val('');
			$('#tableUsers tbody tr').show();
		}

		$('#tableUsers').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": false,
			"autoWidth": false,
			"responsive": true,
			"pageLength": 10,
			"language": {
				"search": "Cari:",
				"zeroRecords": "Tidak ada data",
				"paginate": {
					"previous": "<",
					"next": ">"
				}
			}
		});
	});
</script>

<style>
	/* Page Container */
	.user-page {
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

	.btn-export-primary {
		padding: 10px 20px;
		background: #4e73df;
		color: #fff;
		border: none;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
		transition: all 0.3s ease;
		cursor: pointer;
	}

	.btn-export-primary:hover {
		background: #2e59d9;
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

	.stat-red .stat-icon {
		background: rgba(220, 53, 69, 0.1);
		color: #dc3545;
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
		grid-template-columns: repeat(2, 1fr);
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

	/* Badges */
	.badge {
		display: inline-flex;
		padding: 5px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-primary {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.badge-danger {
		background: rgba(220, 53, 69, 0.1);
		color: #dc3545;
	}

	.badge-info {
		background: rgba(23, 162, 184, 0.1);
		color: #17a2b8;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.filter-grid {
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

	/* Dark Mode Styles */
	body.dark-mode .user-page {
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

	.font-weight-semibold {
		font-weight: 600;
	}

	.table td,
	.table th {
		padding: 1rem;
		vertical-align: middle;
		border-top: none;
		border-bottom: 1px solid #e9ecef;
	}

	.table tbody tr:hover {
		background-color: #f8f9fa;
	}

	.btn-group .btn {
		border-radius: 0 !important;
		margin: 0;
	}

	.btn-group .btn:first-child {
		border-radius: 4px 0 0 4px !important;
	}

	.btn-group .btn:last-child {
		border-radius: 0 4px 4px 0 !important;
	}

	.modal-content {
		border-radius: 12px;
		overflow: hidden;
	}

	.form-control {
		border-radius: 6px;
	}

	.input-group-text {
		border-radius: 6px 0 0 6px;
	}

	.badge {
		border-radius: 6px;
		font-size: 13px;
	}

	.card {
		border-radius: 12px;
	}

	.card-header {
		border-radius: 12px 12px 0 0 !important;
	}
</style>