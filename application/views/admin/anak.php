<!-- Data Anak - Clean & Colorful with Document Upload -->
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
		<div class="card-header bg-success text-white py-3">
			<div class="d-flex justify-content-between align-items-center">
				<h5 class="mb-0 font-weight-bold"><i class="fas fa-child mr-2"></i>Data Anak</h5>
				<button class="btn btn-light btn-sm px-3 font-weight-bold" data-toggle="modal" data-target="#modalAdd">
					<i class="fas fa-plus mr-1"></i> Tambah Anak
				</button>
			</div>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover mb-0" id="tableAnak">
					<thead class="bg-light">
						<tr>
							<th class="text-center" style="width: 50px;">No</th>
							<th>Nama Anak</th>
							<th class="text-center">JK</th>
							<th>Tempat/Tgl Lahir</th>
							<th>Pendidikan</th>
							<th>Status</th>
							<th>Status Tinggal</th>
							<th class="text-center">Dokumen</th>
							<th class="text-center" style="width: 120px;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($anak as $row): ?>
							<tr>
								<td class="text-center text-muted"><?php echo $no++; ?></td>
								<td>
									<div class="d-flex align-items-center">
										<div class="rounded-circle bg-<?php echo $row->jenis_kelamin == 'L' ? 'primary' : 'danger'; ?> text-white d-flex align-items-center justify-content-center mr-3 shadow-sm"
											style="width: 36px; height: 36px; font-size: 14px; font-weight: bold;">
											<i
												class="fas fa-<?php echo $row->jenis_kelamin == 'L' ? 'male' : 'female'; ?>"></i>
										</div>
										<div>
											<div class="font-weight-semibold"><?php echo $row->nama_anak; ?></div>
											<?php if ($row->nik): ?>
												<small class="text-muted">NIK: <?php echo $row->nik; ?></small>
											<?php endif; ?>
										</div>
									</div>
								</td>
								<td class="text-center">
									<span
										class="badge badge-<?php echo $row->jenis_kelamin == 'L' ? 'primary' : 'danger'; ?> px-2 py-1">
										<?php echo $row->jenis_kelamin == 'L' ? 'L' : 'P'; ?>
									</span>
								</td>
								<td>
									<div class="text-muted"><?php echo $row->tempat_lahir; ?></div>
									<small
										class="text-muted"><?php echo date('d/m/Y', strtotime($row->tanggal_lahir)); ?></small>
								</td>
								<td>
									<span class="badge badge-info px-2 py-1 font-weight-normal">
										<i class="fas fa-graduation-cap mr-1"></i><?php echo $row->pendidikan; ?>
									</span>
								</td>
								<td>
									<span class="badge badge-<?php
									echo $row->status_anak == 'Aktif' ? 'success' :
										($row->status_anak == 'Nonaktif' ? 'secondary' : 'warning');
									?> px-2 py-1 font-weight-normal">
										<?php echo $row->status_anak; ?>
									</span>
								</td>
								<td>
									<span class="badge badge-<?php
									echo $row->status_tinggal == 'Tinggal di LKSA' ? 'primary' : 'info';
									?> px-2 py-1 font-weight-normal">
										<?php echo $row->status_tinggal ?? 'Belum diisi'; ?>
									</span>
								</td>
								<td class="text-center">
									<?php
									$doc_count = 0;
									if ($row->file_kk)
										$doc_count++;
									if ($row->file_akta)
										$doc_count++;
									if ($row->file_pendukung)
										$doc_count++;
									?>
									<?php if ($doc_count > 0): ?>
										<span class="badge badge-primary px-2 py-1"
											title="<?php echo $doc_count; ?> dokumen tersedia">
											<i class="fas fa-file-alt mr-1"></i><?php echo $doc_count; ?>
										</span>
									<?php else: ?>
										<span class="badge badge-light text-muted px-2 py-1">-</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
											data-target="#modalEdit<?php echo $row->id_anak; ?>" title="Edit">
											<i class="fas fa-edit"></i>
										</button>
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
											data-target="#modalUpload<?php echo $row->id_anak; ?>" title="Upload Dokumen">
											<i class="fas fa-upload"></i>
										</button>
										<button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
											data-target="#modalDelete<?php echo $row->id_anak; ?>" title="Hapus">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td>
							</tr>

							<!-- Modal Edit -->
							<div class="modal fade" id="modalEdit<?php echo $row->id_anak; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered modal-lg">
									<div class="modal-content border-0 shadow">
										<div class="modal-header bg-warning text-white">
											<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
												Data Anak</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<form action="<?php echo site_url('admin/anak'); ?>" method="post"
											class="form-anak">
											<div class="modal-body p-4">
												<input type="hidden" name="id_anak" value="<?php echo $row->id_anak; ?>">

												<div class="row">
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Nama
																Anak</label>
															<input type="text" class="form-control" name="nama_anak"
																value="<?php echo $row->nama_anak; ?>" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">NIK</label>
															<input type="text" class="form-control" name="nik"
																value="<?php echo $row->nik; ?>" placeholder="Optional">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-4">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Jenis
																Kelamin</label>
															<select class="form-control" name="jenis_kelamin" required>
																<option value="L" <?php echo $row->jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
																<option value="P" <?php echo $row->jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan</option>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Tempat
																Lahir</label>
															<input type="text" class="form-control" name="tempat_lahir"
																value="<?php echo $row->tempat_lahir; ?>" required>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Tanggal
																Lahir</label>
															<input type="date" class="form-control" name="tanggal_lahir"
																value="<?php echo $row->tanggal_lahir; ?>" required>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label
																class="font-weight-bold text-muted mb-2">Pendidikan</label>
															<select class="form-control" name="pendidikan" required>
																<option value="TK" <?php echo $row->pendidikan == 'TK' ? 'selected' : ''; ?>>TK</option>
																<option value="SD" <?php echo $row->pendidikan == 'SD' ? 'selected' : ''; ?>>SD</option>
																<option value="SMP" <?php echo $row->pendidikan == 'SMP' ? 'selected' : ''; ?>>SMP</option>
																<option value="SMA" <?php echo $row->pendidikan == 'SMA' ? 'selected' : ''; ?>>SMA</option>
																<option value="PT" <?php echo $row->pendidikan == 'PT' ? 'selected' : ''; ?>>Perguruan Tinggi</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Status
																Anak</label>
															<select class="form-control" name="status_anak" required>
																<option value="Aktif" <?php echo $row->status_anak == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
																<option value="Nonaktif" <?php echo $row->status_anak == 'Nonaktif' ? 'selected' : ''; ?>>
																	Nonaktif</option>
																<option value="Alumni" <?php echo $row->status_anak == 'Alumni' ? 'selected' : ''; ?>>Alumni
																</option>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Status
																Tinggal</label>
															<select class="form-control" name="status_tinggal" required>
																<option value="Tinggal di LKSA" <?php echo $row->status_tinggal == 'Tinggal di LKSA' ? 'selected' : ''; ?>>Tinggal di LKSA</option>
																<option value="Luar LKSA" <?php echo $row->status_tinggal == 'Luar LKSA' ? 'selected' : ''; ?>>
																	Luar LKSA</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group mb-3">
															<label class="font-weight-bold text-muted mb-2">Tanggal
																Masuk</label>
															<input type="date" class="form-control" name="tanggal_masuk"
																value="<?php echo $row->tanggal_masuk; ?>" required>
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

							<!-- Modal Upload Dokumen -->
							<div class="modal fade" id="modalUpload<?php echo $row->id_anak; ?>" tabindex="-1">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content border-0 shadow">
										<div class="modal-header bg-info text-white">
											<h5 class="modal-title font-weight-bold"><i
													class="fas fa-upload mr-2"></i>Upload Dokumen</h5>
											<button type="button" class="close text-white"
												data-dismiss="modal"><span>&times;</span></button>
										</div>
										<div class="modal-body p-4">
											<!-- Upload KK -->
											<div class="mb-4">
												<label class="font-weight-bold text-muted mb-2">Kartu Keluarga (KK)</label>
												<?php if ($row->file_kk): ?>
													<div
														class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
														<div>
															<i class="fas fa-check-circle mr-1"></i> File tersedia:
															<span
																class="font-weight-bold"><?php echo basename($row->file_kk); ?></span>
														</div>
														<a href="<?php echo site_url('admin/view_dokumen/' . $row->id_anak . '/kk'); ?>"
															target="_blank" class="btn btn-sm btn-primary"
															style="text-decoration: none;">
															<i class="fas fa-eye mr-1"></i> View
														</a>
													</div>
												<?php endif; ?>
												<form action="<?php echo site_url('admin/upload_kk/' . $row->id_anak); ?>"
													method="post" enctype="multipart/form-data">
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="file_kk"
																id="file_kk<?php echo $row->id_anak; ?>"
																accept=".pdf,.jpg,.jpeg,.png" required>
															<label class="custom-file-label"
																for="file_kk<?php echo $row->id_anak; ?>">Pilih
																file...</label>
														</div>
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Upload</button>
														</div>
													</div>
													<small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
												</form>
											</div>

											<!-- Upload Akta -->
											<div class="mb-4">
												<label class="font-weight-bold text-muted mb-2">Akta Kelahiran</label>
												<?php if ($row->file_akta): ?>
													<div
														class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
														<div>
															<i class="fas fa-check-circle mr-1"></i> File tersedia:
															<span
																class="font-weight-bold"><?php echo basename($row->file_akta); ?></span>
														</div>
														<a href="<?php echo site_url('admin/view_dokumen/' . $row->id_anak . '/akta'); ?>"
															target="_blank" class="btn btn-sm btn-primary"
															style="text-decoration: none;">
															<i class="fas fa-eye mr-1"></i> View
														</a>
													</div>
												<?php endif; ?>
												<form action="<?php echo site_url('admin/upload_akta/' . $row->id_anak); ?>"
													method="post" enctype="multipart/form-data">
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="file_akta"
																id="file_akta<?php echo $row->id_anak; ?>"
																accept=".pdf,.jpg,.jpeg,.png" required>
															<label class="custom-file-label"
																for="file_akta<?php echo $row->id_anak; ?>">Pilih
																file...</label>
														</div>
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Upload</button>
														</div>
													</div>
													<small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
												</form>
											</div>

											<!-- Upload Dokumen Pendukung -->
											<div class="mb-0">
												<label class="font-weight-bold text-muted mb-2">Dokumen Pendukung
													Lainnya</label>
												<?php if ($row->file_pendukung): ?>
													<div
														class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
														<div>
															<i class="fas fa-check-circle mr-1"></i> File tersedia:
															<span
																class="font-weight-bold"><?php echo basename($row->file_pendukung); ?></span>
														</div>
														<a href="<?php echo site_url('admin/view_dokumen/' . $row->id_anak . '/pendukung'); ?>"
															target="_blank" class="btn btn-sm btn-primary"
															style="text-decoration: none;">
															<i class="fas fa-eye mr-1"></i> View
														</a>
													</div>
												<?php endif; ?>
												<form
													action="<?php echo site_url('admin/upload_pendukung/' . $row->id_anak); ?>"
													method="post" enctype="multipart/form-data">
													<div class="input-group">
														<div class="custom-file">
															<input type="file" class="custom-file-input"
																name="file_pendukung"
																id="file_pendukung<?php echo $row->id_anak; ?>"
																accept=".pdf,.jpg,.jpeg,.png" required>
															<label class="custom-file-label"
																for="file_pendukung<?php echo $row->id_anak; ?>">Pilih
																file...</label>
														</div>
														<div class="input-group-append">
															<button class="btn btn-primary" type="submit">Upload</button>
														</div>
													</div>
													<small class="text-muted">Format: PDF, JPG, PNG (Max 2MB)</small>
												</form>
											</div>
										</div>
										<div class="modal-footer bg-light">
											<button type="button" class="btn btn-secondary"
												data-dismiss="modal">Tutup</button>
										</div>
									</div>
								</div>
							</div>

							<!-- Modal Delete -->
							<div class="modal fade" id="modalDelete<?php echo $row->id_anak; ?>" tabindex="-1">
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
											<p class="mb-1">Hapus data anak</p>
											<p class="font-weight-bold text-success mb-3"><?php echo $row->nama_anak; ?>?
											</p>
											<p class="text-muted small mb-0">Data akan dihapus permanen.</p>
										</div>
										<div class="modal-footer bg-light justify-content-center">
											<button type="button" class="btn btn-secondary px-4"
												data-dismiss="modal">Batal</button>
											<a href="<?php echo site_url('admin/anak?delete=' . $row->id_anak); ?>"
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
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-success text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Tambah Anak Baru</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<form action="<?php echo site_url('admin/anak'); ?>" method="post" id="formAddAnak">
				<div class="modal-body p-4">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Nama Anak</label>
								<input type="text" class="form-control" name="nama_anak"
									placeholder="Masukkan nama anak" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">NIK</label>
								<input type="text" class="form-control" name="nik"
									placeholder="Nomor Induk Kependudukan (optional)">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Jenis Kelamin</label>
								<select class="form-control" name="jenis_kelamin" required>
									<option value="">Pilih</option>
									<option value="L">Laki-laki</option>
									<option value="P">Perempuan</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tempat Lahir</label>
								<input type="text" class="form-control" name="tempat_lahir" placeholder="Kota/Kabupaten"
									required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tanggal Lahir</label>
								<input type="date" class="form-control" name="tanggal_lahir" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Pendidikan</label>
								<select class="form-control" name="pendidikan" required>
									<option value="">Pilih Pendidikan</option>
									<option value="TK">TK</option>
									<option value="SD">SD</option>
									<option value="SMP">SMP</option>
									<option value="SMA">SMA</option>
									<option value="PT">Perguruan Tinggi</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Status Anak</label>
								<select class="form-control" name="status_anak" required>
									<option value="">Pilih Status</option>
									<option value="Aktif">Aktif</option>
									<option value="Nonaktif">Nonaktif</option>
									<option value="Alumni">Alumni</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Status Tinggal</label>
								<select class="form-control" name="status_tinggal" required>
									<option value="">Pilih Status Tinggal</option>
									<option value="Tinggal di LKSA">Tinggal di LKSA</option>
									<option value="Luar LKSA">Luar LKSA</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tanggal Masuk</label>
								<input type="date" class="form-control" name="tanggal_masuk" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-success font-weight-bold">
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
		$('#tableAnak').DataTable({
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