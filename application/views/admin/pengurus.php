<!-- Data Pengurus - Redesain Modern -->
<div class="pengurus-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-user-tie"></i>
			</div>
			<div>
				<h2>Data Pengurus</h2>
				<p>Kelola data pengurus LKSA dengan lengkap dan terstruktur</p>
			</div>
		</div>
		<div class="header-actions">
			<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAdd">
				<i class="fas fa-plus"></i> Tambah Pengurus
			</button>
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
		$total_pengurus = count($pengurus);
		?>
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_pengurus; ?></span>
				<span class="stat-label">Total Pengurus</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-user-tie"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($pengurus, function ($p) {
					return strpos(strtolower($p->jabatan), 'ketua') !== false;
				})); ?></span>
				<span class="stat-label">Ketua</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-briefcase"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_unique(array_column($pengurus, 'jabatan'))); ?></span>
				<span class="stat-label">Jabatan</span>
			</div>
		</div>

		<div class="stat-card stat-pink">
			<div class="stat-icon">
				<i class="fas fa-phone"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($pengurus, function ($p) {
					return !empty($p->no_hp);
				})); ?></span>
				<span class="stat-label">Kontak</span>
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
					<label>Jabatan</label>
					<select class="form-select" id="filterJabatan">
						<option value="">Semua Jabatan</option>
						<?php
						$jabatan_list = array_unique(array_column($pengurus, 'jabatan'));
						foreach ($jabatan_list as $jabatan): ?>
							<option value="<?php echo $jabatan; ?>"><?php echo $jabatan; ?></option>
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
			<h3><i class="fas fa-list"></i> Daftar Pengurus</h3>
			<span class="data-count"><?php echo $total_pengurus; ?> data</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tablePengurus">
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
														<i class="fas fa-check-circle mr-1"></i> File KTP tersedia: <span
															class="font-weight-bold"><?php echo basename($row->file_ktp); ?></span>
													</div>
													<a href="<?php echo site_url('admin/view_ktp/' . $row->id_pengurus); ?>"
														target="_blank" class="btn btn-sm btn-primary"
														style="text-decoration: none;">
														<i class="fas fa-eye mr-1"></i> View
													</a>
												</div>
											<?php endif; ?>
											<?php echo form_open_multipart('admin/upload_ktp/' . $row->id_pengurus); ?>
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
										<?php echo form_open('admin/pengurus'); ?>
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
			<?php echo form_open('admin/pengurus', 'id="formAddPengurus"'); ?>
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
							<input type="text" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" required>
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

		// Filter functionality
		function filterData() {
			var jabatan = $('#filterJabatan').val().toLowerCase();
			var rows = $('#tablePengurus tbody tr');

			rows.each(function () {
				var row = $(this);
				var jabatanCell = row.find('td').eq(2).text().toLowerCase();

				var showRow = true;

				if (jabatan && jabatanCell.indexOf(jabatan) === -1) {
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
			$('#filterJabatan').val('');
			$('#tablePengurus tbody tr').show();
		}
	});
</script>

<style>
	/* Page Container */
	.pengurus-page {
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
	body.dark-mode .pengurus-page {
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

	/* Dark Mode Styles for pengurus.php */
	body.dark-mode .table {
		color: #e0e0e0;
	}

	body.dark-mode .table td,
	body.dark-mode .table th {
		border-color: #0f3460 !important;
	}

	body.dark-mode .table tbody tr:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .table-hover tbody tr:hover {
		background-color: #0f3460 !important;
		color: #fff;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}

	body.dark-mode .card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .card-header {
		background-color: #0f3460;
		border-bottom-color: #16213e;
	}

	body.dark-mode .card-body {
		background-color: #16213e;
	}

	body.dark-mode .bg-light {
		background-color: #0f3460 !important;
	}

	body.dark-mode .modal-content {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .modal-header {
		background-color: #0f3460;
	}

	body.dark-mode .modal-body {
		background-color: #16213e;
	}

	body.dark-mode .modal-footer {
		background-color: #0f3460;
	}

	body.dark-mode .form-control {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .form-control:focus {
		background-color: #1a1a2e;
		color: #fff;
		border-color: #00d9ff;
	}

	body.dark-mode .custom-file-label {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .input-group-text {
		background-color: #0f3460;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .alert-success {
		background-color: #1b4332;
		border-color: #2d6a4f;
		color: #95d5b2;
	}

	body.dark-mode .alert-danger {
		background-color: #5c1a1a;
		border-color: #7f2626;
		color: #f5b7b1;
	}

	body.dark-mode .close {
		color: #e0e0e0;
	}

	body.dark-mode .close:hover {
		color: #fff;
	}

	body.dark-mode .badge-light {
		background-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode select.form-control {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .table .rounded-circle {
		background-color: #0f3460 !important;
	}
</style>