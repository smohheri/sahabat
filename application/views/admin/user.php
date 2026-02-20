<!-- User Management - Clean & Colorful -->
<div class="container-fluid">
	<!-- Flash Messages -->
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
			<?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<div class="card shadow-sm border-0">
		<div class="card-header bg-primary text-white py-3">
			<div class="d-flex justify-content-between align-items-center">
				<h5 class="mb-0 font-weight-bold"><i class="fas fa-users mr-2"></i>Manajemen User</h5>
				<button class="btn btn-light btn-sm px-3 font-weight-bold" data-toggle="modal" data-target="#modalAdd">
					<i class="fas fa-plus mr-1"></i> Tambah User
				</button>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover mb-0" id="tableUsers">
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
										<button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
											data-target="#modalEdit<?php echo $user->id_user; ?>" title="Edit">
											<i class="fas fa-edit"></i>
										</button>
										<button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
											data-target="#modalDelete<?php echo $user->id_user; ?>" title="Hapus">
											<i class="fas fa-trash"></i>
										</button>
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
										<form action="<?php echo site_url('admin/user'); ?>" method="post">
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
			<form action="<?php echo site_url('admin/user'); ?>" method="post">
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
								<span class="input-group-text bg-light"><i
										class="fas fa-id-card text-primary"></i></span>
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