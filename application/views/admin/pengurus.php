<!-- Data Pengurus - Clean & Colorful -->
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
				<h5 class="mb-0 font-weight-bold"><i class="fas fa-user-tie mr-2"></i>Data Pengurus</h5>
				<button class="btn btn-light btn-sm px-3 font-weight-bold" data-toggle="modal" data-target="#modalAdd">
					<i class="fas fa-plus mr-1"></i> Tambah Pengurus
				</button>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover mb-0" id="tablePengurus">
					<thead class="bg-light">
						<tr>
							<th class="text-center" style="width: 50px;">No</th>
							<th>Nama Pengurus</th>
							<th>Jabatan</th>
							<th>Kontak</th>
							<th class="text-center" style="width: 120px;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($pengurus as $row): ?>
							<tr>
								<td class="text-center text-muted"><?php echo $no++; ?></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3 shadow-sm"
											style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
											<i class="fas fa-user-tie"></i>
										</div>
										<div>
											<div class="font-weight-semibold"><?php echo $row->nama_pengurus; ?></div>
											<?php if ($row->email): ?>
												<small class="text-muted"><i
														class="fas fa-envelope mr-1"></i><?php echo $row->email; ?></small>
											<?php endif; ?>
										</div>
									</div>
								</td>
								<td>
									<span class="badge badge-info px-2 py-1 font-weight-normal">
										<i class="fas fa-briefcase mr-1"></i><?php echo $row->jabatan; ?>
									</span>
								</td>
								<td>
									<div class="text-muted"><i
											class="fas fa-phone mr-1 text-success"></i><?php echo $row->no_hp; ?></div>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
											data-target="#modalEdit<?php echo $row->id_pengurus; ?>" title="Edit">
											<i class="fas fa-edit"></i>
										</button>
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
											data-target="#modalKTP<?php echo $row->id_pengurus; ?>" title="Upload KTP">
											<i class="fas fa-id-card"></i>
										</button>
										<button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
											data-target="#modalDelete<?php echo $row->id_pengurus; ?>" title="Hapus">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td>
							</tr>

							<!-- Modal Upload KTP -->
							<div class="modal fade" id="modalKTP<?php echo $row->id_pengurus; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content border-0 shadow">
										<div class="modal-header bg-info text-white">
											<h5 class="modal-title font-weight-bold"><i
													class="fas fa-id-card mr-2"></i>Upload KTP</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body p-4">
											<?php if ($row->file_ktp): ?>
												<div
													class="alert alert-success py-2 mb-3 d-flex justify-content-between align-items-center">
													<div>
														<i class="fas fa-check-circle mr-1"></i> File KTP tersedia:
														<span
															class="font-weight-bold"><?php echo basename($row->file_ktp); ?></span>
													</div>
													<a href="<?php echo site_url('admin/view_ktp/' . $row->id_pengurus); ?>"
														target="_blank" class="btn btn-sm btn-primary"
														style="text-decoration: none;">
														<i class="fas fa-eye mr-1"></i> View
													</a>
												</div>
											<?php endif; ?>
											<form action="<?php echo site_url('admin/upload_ktp/' . $row->id_pengurus); ?>"
												method="post" enctype="multipart/form-data">
												<div class="form-group mb-3">
													<label class="font-weight-bold text-muted mb-2">File KTP</label>
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="file_ktp"
																id="file_ktp<?php echo $row->id_pengurus; ?>"
																accept=".pdf,.jpg,.jpeg,.png" required>
															<label class="custom-file-label"
																for="file_ktp<?php echo $row->id_pengurus; ?>">Pilih
																file...</label>
														</div>
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Upload</button>
														</div>
													</div>
													<small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
												</div>
											</form>
										</div>
										<div class="modal-footer bg-light">
											<button type="button" class="btn btn-secondary"
												data-dismiss="modal">Tutup</button>
										</div>
									</div>
								</div>
							</div>

							<!-- Modal Edit -->
							<div class="modal fade" id="modalEdit<?php echo $row->id_pengurus; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content border-0 shadow">
										<div class="modal-header bg-warning text-white">
											<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
												Data Pengurus</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<form action="<?php echo site_url('admin/pengurus'); ?>" method="post">
											<div class="modal-body p-4">
												<input type="hidden" name="id_pengurus"
													value="<?php echo $row->id_pengurus; ?>">

												<div class="form-group mb-3">
													<label class="font-weight-bold text-muted mb-2">Nama Pengurus</label>
													<input type="text" class="form-control" name="nama_pengurus"
														value="<?php echo $row->nama_pengurus; ?>" required>
												</div>

												<div class="form-group mb-3">
													<label class="font-weight-bold text-muted mb-2">Jabatan</label>
													<input type="text" class="form-control" name="jabatan"
														value="<?php echo $row->jabatan; ?>" required>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">No HP</label>
															<input type="text" class="form-control" name="no_hp"
																value="<?php echo $row->no_hp; ?>" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Email</label>
															<input type="email" class="form-control" name="email"
																value="<?php echo $row->email; ?>" placeholder="Optional">
														</div>
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
							<div class="modal fade" id="modalDelete<?php echo $row->id_pengurus; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered modal-sm">
									<div class="modal-content border-0 shadow text-center">
										<div class="modal-header bg-danger text-white">
											<h5 class="modal-title font-weight-bold"><i
													class="fas fa-trash-alt mr-2"></i>Hapus Data</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body p-4">
											<div class="mb-3">
												<i class="fas fa-exclamation-circle text-warning fa-3x"></i>
											</div>
											<p class="mb-1">Hapus data pengurus</p>
											<p class="font-weight-bold text-primary mb-3">
												<?php echo $row->nama_pengurus; ?>?
											</p>
											<p class="text-muted small mb-0">Data akan dihapus permanen.</p>
										</div>
										<div class="modal-footer bg-light justify-content-center">
											<button type="button" class="btn btn-secondary px-4"
												data-dismiss="modal">Batal</button>
											<a href="<?php echo site_url('admin/pengurus?delete=' . $row->id_pengurus); ?>"
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
				<h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Tambah Pengurus Baru</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<form action="<?php echo site_url('admin/pengurus'); ?>" method="post" id="formAddPengurus">
				<div class="modal-body p-4">
					<div class="form-group mb-3">
						<label class="font-weight-bold text-muted mb-2">Nama Pengurus</label>
						<input type="text" class="form-control" name="nama_pengurus" placeholder="Masukkan nama lengkap"
							required>
					</div>

					<div class="form-group mb-3">
						<label class="font-weight-bold text-muted mb-2">Jabatan</label>
						<input type="text" class="form-control" name="jabatan"
							placeholder="Contoh: Ketua, Sekretaris, Bendahara" required>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">No HP</label>
								<input type="text" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx"
									required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Email</label>
								<input type="email" class="form-control" name="email" placeholder="email@domain.com">
							</div>
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
		// Initialize DataTable
		$('#tablePengurus').DataTable({
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

		// Custom file input label update
		$('.custom-file-input').on('change', function () {
			var fileName = $(this).val().split('\\').pop();
			$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
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

	.badge {
		border-radius: 6px;
		font-size: 12px;
	}

	.card {
		border-radius: 12px;
	}

	.card-header {
		border-radius: 12px 12px 0 0 !important;
	}

	.custom-file-label::after {
		content: "Browse";
	}
</style>