<!-- Data Anak - Redesain Modern -->

<!-- DataTables CSS -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">

<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-child"></i>
			</div>
			<div>
				<h2>Data Anak</h2>
				<p>Kelola data anak asuh LKSA dengan lengkap dan terstruktur</p>
			</div>
		</div>
		<div class="header-actions">
			<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAdd">
				<i class="fas fa-plus"></i> Tambah Anak
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
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($anak); ?></span>
				<span class="stat-label">Total Anak</span>
			</div>
		</div>
		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-user-check"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->status_anak == 'Aktif';
				})); ?></span>
				<span class="stat-label">Anak Aktif</span>
			</div>
		</div>
		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-male"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->jenis_kelamin == 'L';
				})); ?></span>
				<span class="stat-label">Laki-laki</span>
			</div>
		</div>
		<div class="stat-card stat-pink">
			<div class="stat-icon">
				<i class="fas fa-female"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count(array_filter($anak, function ($a) {
					return $a->jenis_kelamin == 'P';
				})); ?></span>
				<span class="stat-label">Perempuan</span>
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
					<label>Status Anak</label>
					<select class="form-select" id="filterStatus">
						<option value="">Semua Status</option>
						<option value="Aktif">Aktif</option>
						<option value="Nonaktif">Nonaktif</option>
						<option value="Alumni">Alumni</option>
					</select>
				</div>
				<div class="filter-item">
					<label>Jenis Kelamin</label>
					<select class="form-select" id="filterJenisKelamin">
						<option value="">Semua</option>
						<option value="L">Laki-laki</option>
						<option value="P">Perempuan</option>
					</select>
				</div>
				<div class="filter-item">
					<label>Pendidikan</label>
					<select class="form-select" id="filterPendidikan">
						<option value="">Semua</option>
						<option value="TK">TK</option>
						<option value="SD">SD</option>
						<option value="SMP">SMP</option>
						<option value="SMA">SMA</option>
						<option value="PT">Perguruan Tinggi</option>
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
			<h3><i class="fas fa-list"></i> Daftar Anak</h3>
			<span class="data-count"><?php echo count($anak); ?> data anak</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableAnak">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Anak</th>
							<th>Jenis Kelamin</th>
							<th>Tempat/Tgl Lahir</th>
							<th>Kategori</th>
							<th>Nama Sekolah</th>
							<th>Biaya SPP</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php foreach ($anak as $a): ?>

	<!-- Modal Edit -->
	<div class="modal fade" id="modalEdit<?php echo $a->id_anak; ?>" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-warning text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit Data Anak</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<?php echo form_open('admin/anak', 'id="formEditAnak' . $a->id_anak . '"'); ?>
				<div class="modal-body p-4">
					<input type="hidden" name="id_anak" value="<?php echo $a->id_anak; ?>">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Nama Anak</label>
								<input type="text" class="form-control" name="nama_anak"
									value="<?php echo $a->nama_anak; ?>" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">NIK</label>
								<input type="text" class="form-control" name="nik" value="<?php echo $a->nik; ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Jenis Kelamin</label>
								<select class="form-control" name="jenis_kelamin" required>
									<option value="L" <?php echo $a->jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-laki
									</option>
									<option value="P" <?php echo $a->jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan
									</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tempat Lahir</label>
								<input type="text" class="form-control" name="tempat_lahir"
									value="<?php echo $a->tempat_lahir; ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tanggal Lahir</label>
								<input type="date" class="form-control" name="tanggal_lahir"
									value="<?php echo $a->tanggal_lahir; ?>" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Pendidikan</label>
								<select class="form-control" name="pendidikan" required>
									<option value="TK" <?php echo $a->pendidikan == 'TK' ? 'selected' : ''; ?>>TK</option>
									<option value="SD" <?php echo $a->pendidikan == 'SD' ? 'selected' : ''; ?>>SD</option>
									<option value="SMP" <?php echo $a->pendidikan == 'SMP' ? 'selected' : ''; ?>>SMP</option>
									<option value="SMA" <?php echo $a->pendidikan == 'SMA' ? 'selected' : ''; ?>>SMA</option>
									<option value="PT" <?php echo $a->pendidikan == 'PT' ? 'selected' : ''; ?>>Perguruan
										Tinggi</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Status Anak</label>
								<select class="form-control" name="status_anak" required>
									<option value="Aktif" <?php echo $a->status_anak == 'Aktif' ? 'selected' : ''; ?>>Aktif
									</option>
									<option value="Nonaktif" <?php echo $a->status_anak == 'Nonaktif' ? 'selected' : ''; ?>>
										Nonaktif</option>
									<option value="Alumni" <?php echo $a->status_anak == 'Alumni' ? 'selected' : ''; ?>>Alumni
									</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Kategori</label>
								<select class="form-control" name="kategori" required>
									<option value="">Pilih Kategori</option>
									<option value="Yatim" <?php echo $a->kategori == 'Yatim' ? 'selected' : ''; ?>>Yatim
									</option>
									<option value="Piatu" <?php echo $a->kategori == 'Piatu' ? 'selected' : ''; ?>>Piatu
									</option>
									<option value="Yatim Piatu" <?php echo $a->kategori == 'Yatim Piatu' ? 'selected' : ''; ?>>Yatim Piatu</option>
									<option value="Dhuafa" <?php echo $a->kategori == 'Dhuafa' ? 'selected' : ''; ?>>Dhuafa
									</option>
									<option value="Fakir dan Miskin" <?php echo $a->kategori == 'Fakir dan Miskin' ? 'selected' : ''; ?>>Fakir dan Miskin</option>
									<option value="Ibnu Sabil" <?php echo $a->kategori == 'Ibnu Sabil' ? 'selected' : ''; ?>>
										Ibnu Sabil</option>
									<option value="Laqith" <?php echo $a->kategori == 'Laqith' ? 'selected' : ''; ?>>Laqith
									</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Status Tinggal</label>
								<select class="form-control" name="status_tinggal" required>
									<option value="Tinggal di LKSA" <?php echo $a->status_tinggal == 'Tinggal di LKSA' ? 'selected' : ''; ?>>Tinggal di LKSA</option>
									<option value="Luar LKSA" <?php echo $a->status_tinggal == 'Luar LKSA' ? 'selected' : ''; ?>>Luar LKSA</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Tanggal Masuk</label>
								<input type="date" class="form-control" name="tanggal_masuk"
									value="<?php echo $a->tanggal_masuk; ?>" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Nama Sekolah</label>
								<input type="text" class="form-control" name="nama_sekolah"
									value="<?php echo $a->nama_sekolah; ?>" placeholder="Masukkan nama sekolah">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mb-3">
								<label class="font-weight-bold text-muted mb-2">Biaya SPP</label>
								<input type="number" class="form-control" name="biaya_spp"
									value="<?php echo $a->biaya_spp; ?>" placeholder="Masukkan biaya SPP" min="0"
									step="0.01">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-warning text-white font-weight-bold">
						<i class="fas fa-save mr-1"></i>Simpan Perubahan
					</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal Upload Dokumen -->
	<div class="modal fade" id="modalUpload<?php echo $a->id_anak; ?>" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-info text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-upload mr-2"></i>Upload Dokumen</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body p-4">
					<!-- Upload Foto -->
					<div class="mb-4">
						<label class="font-weight-bold text-muted mb-2">Foto Anak</label>
						<?php if ($a->foto): ?>
							<div class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
								<div>
									<i class="fas fa-check-circle mr-1"></i> File tersedia: <span
										class="font-weight-bold"><?php echo basename($a->foto); ?></span>
								</div>
								<a href="<?php echo base_url('assets/uploads/foto_anak/' . $a->foto); ?>" target="_blank"
									class="btn btn-sm btn-primary">
									<i class="fas fa-eye mr-1"></i> View
								</a>
							</div>
						<?php endif; ?>
						<?php echo form_open_multipart('admin/upload_foto/' . $a->id_anak); ?>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="foto" id="foto<?php echo $a->id_anak; ?>"
									accept=".jpg,.jpeg,.png" required>
								<label class="custom-file-label" for="foto<?php echo $a->id_anak; ?>">Pilih file...</label>
							</div>
							<div class="input-group-append">
								<button class="btn btn-primary" type="submit">Upload</button>
							</div>
						</div>
						<small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
						</form>
					</div>

					<!-- Upload KK -->
					<div class="mb-4">
						<label class="font-weight-bold text-muted mb-2">Kartu Keluarga (KK)</label>
						<?php if ($a->file_kk): ?>
							<div class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
								<div>
									<i class="fas fa-check-circle mr-1"></i> File tersedia: <span
										class="font-weight-bold"><?php echo basename($a->file_kk); ?></span>
								</div>
								<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/kk'); ?>" target="_blank"
									class="btn btn-sm btn-primary">
									<i class="fas fa-eye mr-1"></i> View
								</a>
							</div>
						<?php endif; ?>
						<?php echo form_open_multipart('admin/upload_kk/' . $a->id_anak); ?>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="file_kk"
									id="file_kk<?php echo $a->id_anak; ?>" accept=".pdf,.jpg,.jpeg,.png" required>
								<label class="custom-file-label" for="file_kk<?php echo $a->id_anak; ?>">Pilih
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
						<?php if ($a->file_akta): ?>
							<div class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
								<div>
									<i class="fas fa-check-circle mr-1"></i> File tersedia: <span
										class="font-weight-bold"><?php echo basename($a->file_akta); ?></span>
								</div>
								<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/akta'); ?>" target="_blank"
									class="btn btn-sm btn-primary">
									<i class="fas fa-eye mr-1"></i> View
								</a>
							</div>
						<?php endif; ?>
						<?php echo form_open_multipart('admin/upload_akta/' . $a->id_anak); ?>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="file_akta"
									id="file_akta<?php echo $a->id_anak; ?>" accept=".pdf,.jpg,.jpeg,.png" required>
								<label class="custom-file-label" for="file_akta<?php echo $a->id_anak; ?>">Pilih
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
						<label class="font-weight-bold text-muted mb-2">Dokumen Pendukung Lainnya</label>
						<?php if ($a->file_pendukung): ?>
							<div class="alert alert-success py-2 mb-2 d-flex justify-content-between align-items-center">
								<div>
									<i class="fas fa-check-circle mr-1"></i> File tersedia: <span
										class="font-weight-bold"><?php echo basename($a->file_pendukung); ?></span>
								</div>
								<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/pendukung'); ?>"
									target="_blank" class="btn btn-sm btn-primary">
									<i class="fas fa-eye mr-1"></i> View
								</a>
							</div>
						<?php endif; ?>
						<?php echo form_open_multipart('admin/upload_pendukung/' . $a->id_anak); ?>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="file_pendukung"
									id="file_pendukung<?php echo $a->id_anak; ?>" accept=".pdf,.jpg,.jpeg,.png" required>
								<label class="custom-file-label" for="file_pendukung<?php echo $a->id_anak; ?>">Pilih
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
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Delete -->
	<div class="modal fade" id="modalDelete<?php echo $a->id_anak; ?>" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<div class="modal-content border-0 shadow text-center">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-trash-alt mr-2"></i>Hapus Data</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body p-4">
					<div class="mb-3">
						<i class="fas fa-exclamation-circle text-warning fa-3x"></i>
					</div>
					<p class="mb-1">Hapus data anak</p>
					<p class="font-weight-bold text-success mb-3"><?php echo $a->nama_anak; ?>?</p>
					<p class="text-muted small mb-0">Data akan dihapus permanen.</p>
				</div>
				<div class="modal-footer bg-light justify-content-center">
					<button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Batal</button>
					<a href="<?php echo site_url('admin/anak?delete=' . $a->id_anak); ?>"
						class="btn btn-danger px-4 font-weight-bold">
						<i class="fas fa-trash mr-1"></i>Ya, Hapus
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal View -->
	<div class="modal fade" id="modalView<?php echo $a->id_anak; ?>" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-eye mr-2"></i>Detail Data Anak</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body p-4">
					<!-- Photo Display -->
					<div class="text-center mb-4">
						<?php if ($a->foto): ?>
							<img src="<?php echo base_url('assets/uploads/foto_anak/' . $a->foto); ?>"
								alt="Foto <?php echo $a->nama_anak; ?>" class="img-fluid rounded shadow-sm"
								style="max-width: 150px; max-height: 150px;">
						<?php else: ?>
							<div class="bg-light rounded d-inline-flex align-items-center justify-content-center"
								style="width: 150px; height: 150px;">
								<i class="fas fa-user fa-4x text-muted"></i>
							</div>
						<?php endif; ?>
					</div>

					<!-- Personal Information -->
					<div class="card border-0 shadow-sm mb-4">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-user mr-2"></i>Informasi Pribadi
							</h6>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Nama Anak</label>
										<p class="form-control-plaintext font-weight-semibold h5">
											<?php echo $a->nama_anak; ?>
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">NIK</label>
										<p class="form-control-plaintext">
											<?php echo $a->nik ?: '<span class="text-muted">Tidak tersedia</span>'; ?>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Jenis Kelamin</label>
										<p class="form-control-plaintext">
											<span
												class="badge badge-<?php echo $a->jenis_kelamin == 'L' ? 'primary' : 'danger'; ?> px-3 py-2">
												<i
													class="fas fa-<?php echo $a->jenis_kelamin == 'L' ? 'male' : 'female'; ?> mr-1"></i>
												<?php echo $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
											</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Tempat Lahir</label>
										<p class="form-control-plaintext"><?php echo $a->tempat_lahir; ?></p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Tanggal Lahir</label>
										<p class="form-control-plaintext"><?php echo tanggal_indo($a->tanggal_lahir); ?>
											<small class="text-muted">(Umur: <?php echo umur($a->tanggal_lahir); ?>)</small>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Status & Informasi Tambahan -->
					<div class="card border-0 shadow-sm mb-4">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold text-success mb-0"><i class="fas fa-info-circle mr-2"></i>Status &
								Informasi Tambahan</h6>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Status Anak</label>
										<p class="form-control-plaintext">
											<span
												class="badge badge-<?php echo $a->status_anak == 'Aktif' ? 'success' : ($a->status_anak == 'Nonaktif' ? 'secondary' : 'warning'); ?> px-3 py-2">
												<?php echo $a->status_anak; ?>
											</span>
										</p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Kategori</label>
										<p class="form-control-plaintext">
											<span class="badge badge-primary px-3 py-2">
												<?php echo $a->kategori ?: 'Belum ditentukan'; ?>
											</span>
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Status Tinggal</label>
										<p class="form-control-plaintext">
											<span
												class="badge badge-<?php echo $a->status_tinggal == 'Tinggal di LKSA' ? 'primary' : 'info'; ?> px-3 py-2">
												<?php echo $a->status_tinggal ?: 'Belum diisi'; ?>
											</span>
										</p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Tanggal Masuk</label>
										<p class="form-control-plaintext"><?php echo tanggal_indo($a->tanggal_masuk); ?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Nama Sekolah</label>
										<p class="form-control-plaintext">
											<?php echo $a->nama_sekolah ?: 'Belum diisi'; ?>
										</p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="font-weight-bold text-muted mb-2">Biaya SPP</label>
										<p class="form-control-plaintext">
											<?php echo $a->biaya_spp ? 'Rp ' . number_format($a->biaya_spp, 0, ',', '.') : 'Belum diisi'; ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Documents -->
					<div class="card border-0 shadow-sm">
						<div class="card-header bg-light">
							<h6 class="font-weight-bold text-warning mb-0"><i class="fas fa-file-alt mr-2"></i>Dokumen</h6>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 text-center">
									<div class="border rounded p-3 mb-3">
										<i class="fas fa-id-card fa-2x text-primary mb-2"></i>
										<h6 class="font-weight-bold">Kartu Keluarga (KK)</h6>
										<?php if ($a->file_kk): ?>
											<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/kk'); ?>"
												target="_blank" class="btn btn-primary btn-sm">
												<i class="fas fa-eye mr-1"></i> Lihat Dokumen
											</a>
										<?php else: ?>
											<span class="text-muted">Tidak tersedia</span>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div class="border rounded p-3 mb-3">
										<i class="fas fa-birthday-cake fa-2x text-success mb-2"></i>
										<h6 class="font-weight-bold">Akta Kelahiran</h6>
										<?php if ($a->file_akta): ?>
											<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/akta'); ?>"
												target="_blank" class="btn btn-success btn-sm">
												<i class="fas fa-eye mr-1"></i> Lihat Dokumen
											</a>
										<?php else: ?>
											<span class="text-muted">Tidak tersedia</span>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div class="border rounded p-3 mb-3">
										<i class="fas fa-folder-open fa-2x text-info mb-2"></i>
										<h6 class="font-weight-bold">Dokumen Pendukung</h6>
										<?php if ($a->file_pendukung): ?>
											<a href="<?php echo site_url('admin/view_dokumen/' . $a->id_anak . '/pendukung'); ?>"
												target="_blank" class="btn btn-info btn-sm">
												<i class="fas fa-eye mr-1"></i> Lihat Dokumen
											</a>
										<?php else: ?>
											<span class="text-muted">Tidak tersedia</span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

<?php endforeach; ?>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-success text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Tambah Anak Baru</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<?php echo form_open('admin/anak', 'id="formAddAnak"'); ?>
			<div class="modal-body p-4">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-3">
							<label class="font-weight-bold text-muted mb-2">Nama Anak</label>
							<input type="text" class="form-control" name="nama_anak" placeholder="Masukkan nama anak"
								required>
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
					<div class="col-md-12">
						<div class="form-group mb-3">
							<label class="font-weight-bold text-muted mb-2">Kategori</label>
							<select class="form-control" name="kategori" required>
								<option value="">Pilih Kategori</option>
								<option value="Yatim">Yatim</option>
								<option value="Piatu">Piatu</option>
								<option value="Yatim Piatu">Yatim Piatu</option>
								<option value="Dhuafa">Dhuafa</option>
								<option value="Fakir dan Miskin">Fakir dan Miskin</option>
								<option value="Ibnu Sabil">Ibnu Sabil</option>
								<option value="Laqith">Laqith</option>
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
				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-3">
							<label class="font-weight-bold text-muted mb-2">Nama Sekolah</label>
							<input type="text" class="form-control" name="nama_sekolah"
								placeholder="Masukkan nama sekolah">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mb-3">
							<label class="font-weight-bold text-muted mb-2">Biaya SPP</label>
							<input type="number" class="form-control" name="biaya_spp" placeholder="Masukkan biaya SPP"
								min="0" step="0.01">
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

	.header-actions {
		display: flex;
		gap: 12px;
	}

	.btn-export-primary {
		padding: 10px 20px;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
		background: #4e73df;
		color: #fff;
		border: none;
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
		grid-template-columns: repeat(4, 1fr);
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

	/* Badges */
	.badge-jk,
	.badge-status {
		display: inline-flex;
		padding: 5px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
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

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.filter-grid {
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

		.filter-grid {
			grid-template-columns: 1fr;
		}
	}

	/* Dark Mode Styles for anak.php */
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

	/* Additional styles for modals */
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

	/* Dark Mode Styles for modals */
	body.dark-mode .modal-content {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .modal-header {
		background-color: #0f3460;
		border-bottom-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .modal-body {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .modal-footer {
		background-color: #0f3460;
		border-top-color: #16213e;
	}

	body.dark-mode .card {
		background-color: #16213e;
		border-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .card-header {
		background-color: #0f3460;
		border-bottom-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .card-body {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .form-control {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .form-control:focus {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #00d9ff;
	}

	body.dark-mode .form-control-plaintext {
		color: #e0e0e0;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}

	body.dark-mode .badge {
		color: #e0e0e0;
	}

	body.dark-mode .btn-secondary {
		background-color: #0f3460;
		border-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .btn-secondary:hover {
		background-color: #16213e;
		border-color: #16213e;
	}

	body.dark-mode .alert {
		background-color: #0f3460;
		border-color: #16213e;
		color: #e0e0e0;
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

	body.dark-mode .border {
		border-color: #0f3460 !important;
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
				tableAnak = $('#tableAnak').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": {
						"url": "<?php echo site_url('admin/anak_ajax'); ?>",
						"type": "POST",
						"data": function (d) {
							d.status_anak = $('#filterStatus').val();
							d.jenis_kelamin = $('#filterJenisKelamin').val();
							d.pendidikan = $('#filterPendidikan').val();
						}
					},
					"columns": [
						{ "data": 0, "orderable": false }, // No
						{ "data": 1, "orderable": true }, // Nama Anak
						{ "data": 2, "orderable": false }, // Jenis Kelamin
						{ "data": 3, "orderable": false }, // Tempat/Tgl Lahir
						{ "data": 4, "orderable": false }, // Kategori
						{ "data": 5, "orderable": false }, // Nama Sekolah
						{ "data": 6, "orderable": true },  // Biaya SPP
						{ "data": 7, "orderable": false }  // Aksi
					],
					"pageLength": 10,
					"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
					"language": {
						"processing": "Memproses...",
						"search": "Cari:",
						"lengthMenu": "Tampilkan _MENU_ data per halaman",
						"zeroRecords": "Tidak ada data anak",
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

	var tableAnak;

	function filterData() {
		if (tableAnak) {
			tableAnak.ajax.reload();
		}
	}

	function resetFilter() {
		document.getElementById('filterStatus').value = '';
		document.getElementById('filterJenisKelamin').value = '';
		document.getElementById('filterPendidikan').value = '';
		filterData();
	}

	// Custom file input label update
	$('.custom-file-input').on('change', function () {
		var fileName = $(this).val().split('\\').pop();
		$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
	});
</script>
