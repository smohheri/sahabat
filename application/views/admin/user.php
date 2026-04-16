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
						<?php foreach ($available_roles as $role): ?>
							<option value="<?php echo $role; ?>"><?php echo ucfirst($role); ?></option>
						<?php endforeach; ?>
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
														<?php foreach ($available_roles as $role): ?>
															<option value="<?php echo $role; ?>" <?php echo $user->role == $role ? 'selected' : ''; ?>><?php echo ucfirst($role); ?></option>
														<?php endforeach; ?>
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
							<?php foreach ($available_roles as $role): ?>
								<option value="<?php echo $role; ?>"><?php echo ucfirst($role); ?></option>
							<?php endforeach; ?>
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
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			"pageLength": 10,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
			"language": {
				"search": "Cari:",
				"zeroRecords": "Tidak ada data",
				"lengthMenu": "Tampilkan _MENU_ data per halaman",
				"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
				"infoEmpty": "Tidak ada data yang tersedia",
				"infoFiltered": "(difilter dari _MAX_ total data)",
				"paginate": {
					"first": "Pertama",
					"last": "Terakhir",
					"previous": "Sebelumnya",
					"next": "Selanjutnya"
				}
			}
		});
	});
</script>

<style>
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