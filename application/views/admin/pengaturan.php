<!-- Pengaturan - Redesain Modern -->
<div class="pengaturan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-cogs"></i>
			</div>
			<div>
				<h2>Pengaturan Profile LKSA</h2>
				<p>Konfigurasi informasi dan pengaturan sistem LKSA</p>
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

	<!-- Form Panel -->
	<div class="form-panel">
		<div class="panel-header">
			<h3><i class="fas fa-building"></i> Informasi LKSA</h3>
		</div>
		<div class="panel-body">
			<?php echo form_open_multipart('admin/pengaturan'); ?>
			<div class="form-grid">
				<div class="form-item">
					<label for="nama_lksa">
						<i class="fas fa-building mr-1"></i>Nama LKSA
					</label>
					<input type="text" class="form-control" id="nama_lksa" name="nama_lksa"
						value="<?php echo set_value('nama_lksa', $pengaturan->nama_lksa ?? ''); ?>"
						placeholder="Masukkan nama LKSA" required>
					<?php echo form_error('nama_lksa', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-item">
					<label for="nama_kepala">
						<i class="fas fa-user-tie mr-1"></i>Nama Kepala
					</label>
					<input type="text" class="form-control" id="nama_kepala" name="nama_kepala"
						value="<?php echo set_value('nama_kepala', $pengaturan->nama_kepala ?? ''); ?>"
						placeholder="Masukkan nama kepala" required>
					<?php echo form_error('nama_kepala', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-item full-width">
					<label for="alamat">
						<i class="fas fa-map-marker-alt mr-1"></i>Alamat
					</label>
					<textarea class="form-control" id="alamat" name="alamat" rows="3"
						placeholder="Masukkan alamat lengkap"
						required><?php echo set_value('alamat', $pengaturan->alamat ?? ''); ?></textarea>
					<?php echo form_error('alamat', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-item">
					<label for="no_telp">
						<i class="fas fa-phone mr-1"></i>No Telepon
					</label>
					<input type="text" class="form-control" id="no_telp" name="no_telp"
						value="<?php echo set_value('no_telp', $pengaturan->no_telp ?? ''); ?>"
						placeholder="Masukkan nomor telepon" required>
					<?php echo form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-item">
					<label for="email">
						<i class="fas fa-envelope mr-1"></i>Email
					</label>
					<input type="email" class="form-control" id="email" name="email"
						value="<?php echo set_value('email', $pengaturan->email ?? ''); ?>"
						placeholder="Masukkan alamat email" required>
					<?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-item">
					<label for="tahun_berdiri">
						<i class="fas fa-calendar-alt mr-1"></i>Tahun Berdiri
					</label>
					<input type="number" class="form-control" id="tahun_berdiri" name="tahun_berdiri"
						value="<?php echo set_value('tahun_berdiri', $pengaturan->tahun_berdiri ?? ''); ?>"
						placeholder="Masukkan tahun berdiri" min="1900" max="<?php echo date('Y'); ?>" required>
					<?php echo form_error('tahun_berdiri', '<small class="text-danger">', '</small>'); ?>
				</div>


			</div><!-- Social Media Section -->
			<div class="form-section">
				<h4><i class="fas fa-share-alt mr-2"></i>Media Sosial</h4>
				<div class="form-grid">
					<div class="form-item">
						<label for="facebook">
							<i class="fab fa-facebook mr-1"></i>Facebook
						</label>
						<input type="text" class="form-control" id="facebook" name="facebook"
							value="<?php echo set_value('facebook', $pengaturan->facebook ?? ''); ?>"
							placeholder="URL Facebook">
					</div>
					<div class="form-item">
						<label for="twitter">
							<i class="fab fa-twitter mr-1"></i>Twitter
						</label>
						<input type="text" class="form-control" id="twitter" name="twitter"
							value="<?php echo set_value('twitter', $pengaturan->twitter ?? ''); ?>"
							placeholder="URL Twitter">
					</div>
					<div class="form-item">
						<label for="instagram">
							<i class="fab fa-instagram mr-1"></i>Instagram
						</label>
						<input type="text" class="form-control" id="instagram" name="instagram"
							value="<?php echo set_value('instagram', $pengaturan->instagram ?? ''); ?>"
							placeholder="URL Instagram">
					</div>
					<div class="form-item">
						<label for="youtube">
							<i class="fab fa-youtube mr-1"></i>YouTube
						</label>
						<input type="text" class="form-control" id="youtube" name="youtube"
							value="<?php echo set_value('youtube', $pengaturan->youtube ?? ''); ?>"
							placeholder="URL YouTube">
					</div>
					<div class="form-item">
						<label for="linkedin">
							<i class="fab fa-linkedin mr-1"></i>LinkedIn
						</label>
						<input type="text" class="form-control" id="linkedin" name="linkedin"
							value="<?php echo set_value('linkedin', $pengaturan->linkedin ?? ''); ?>"
							placeholder="URL LinkedIn">
					</div>
					<div class="form-item">
						<label for="whatsapp">
							<i class="fab fa-whatsapp mr-1"></i>WhatsApp
						</label>
						<input type="text" class="form-control" id="whatsapp" name="whatsapp"
							value="<?php echo set_value('whatsapp', $pengaturan->whatsapp ?? ''); ?>"
							placeholder="Nomor WhatsApp (contoh: 6281234567890)">
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button type="reset" class="btn btn-secondary">
				<i class="fas fa-undo mr-1"></i>Reset
			</button>
			<button type="submit" class="btn btn-primary">
				<i class="fas fa-save mr-1"></i>Simpan Perubahan
			</button>
		</div>
		<?php echo form_close(); ?>
	</div>

	<!-- Upload Panels -->
	<div class="upload-panels">
		<div class="upload-panel">
			<div class="panel-header">
				<h3><i class="fas fa-image"></i> Logo LKSA</h3>
			</div>
			<div class="panel-body text-center">
				<?php if (!empty($pengaturan->logo)): ?>
					<img src="<?php echo base_url('assets/uploads/logos/' . $pengaturan->logo); ?>" alt="Logo LKSA"
						class="img-fluid mb-3" style="max-height: 150px;">
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-image fa-3x"></i>
						<p>Belum ada logo</p>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_logo'); ?>
				<div class="form-group">
					<input type="file" class="form-control-file" id="logo" name="logo" accept="image/*">
					<small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
				</div>
				<button type="submit" class="btn btn-info">
					<i class="fas fa-upload mr-1"></i>Upload Logo
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="upload-panel">
			<div class="panel-header">
				<h3><i class="fas fa-file-alt"></i> Dokumen Legal</h3>
			</div>
			<div class="panel-body text-center">
				<?php if (!empty($pengaturan->dokumen_legal)): ?>
					<div class="mb-3">
						<i class="fas fa-file fa-3x text-warning"></i>
						<p class="mt-2"><?php echo $pengaturan->dokumen_legal; ?></p>
						<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
							data-target="#modalPreview">
							<i class="fas fa-eye mr-1"></i>Lihat Dokumen
						</button>
					</div>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-file-alt fa-3x"></i>
						<p>Belum ada dokumen legal</p>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_dokumen'); ?>
				<div class="form-group">
					<input type="file" class="form-control-file" id="dokumen" name="dokumen" accept=".pdf">
					<small class="form-text text-muted">Format: PDF. Maksimal 5MB.</small>
				</div>
				<button type="submit" class="btn btn-warning">
					<i class="fas fa-upload mr-1"></i>Upload Dokumen
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="upload-panel">
			<div class="panel-header">
				<h3><i class="fas fa-envelope-open-text"></i> Kop Surat Laporan</h3>
			</div>
			<div class="panel-body text-center">
				<?php if (!empty($pengaturan->kop_surat)): ?>
					<img src="<?php echo base_url('assets/uploads/kop/' . $pengaturan->kop_surat); ?>" alt="Kop Surat"
						class="img-fluid mb-3" style="max-height: 120px;">
					<p class="text-muted small">Kop surat akan muncul di bagian atas laporan PDF</p>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-envelope-open-text fa-3x"></i>
						<p>Belum ada kop surat</p>
						<small class="text-muted">Upload kop surat untuk digunakan di laporan PDF</small>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_kop'); ?>
				<div class="form-group">
					<input type="file" class="form-control-file" id="kop_surat" name="kop_surat" accept="image/*">
					<small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran disarankan:
						800x150px</small>
				</div>
				<button type="submit" class="btn btn-success">
					<i class="fas fa-upload mr-1"></i>Upload Kop Surat
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal Preview Dokumen -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalPreviewLabel">Preview Dokumen Legal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-0">
				<iframe src="<?php echo base_url('assets/uploads/documents/' . $pengaturan->dokumen_legal); ?>"
					width="100%" height="600px" frameborder="0" style="width: 100%; height: 600px;"></iframe>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('assets/uploads/documents/' . $pengaturan->dokumen_legal); ?>"
					target="_blank" class="btn btn-primary">
					<i class="fas fa-external-link-alt"></i> Buka di Tab Baru
				</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>

	<style>
		/* Page Container */
		.pengaturan-page {
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

		/* Form Panel */
		.form-panel {
			background: #fff;
			border-radius: 14px;
			overflow: hidden;
			margin-bottom: 25px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		}

		.panel-header {
			padding: 20px 25px;
			border-bottom: 1px solid #edf2f7;
			background: #f8fafc;
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

		.panel-body {
			padding: 25px;
		}

		.form-grid {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			gap: 20px;
		}

		.social-grid {
			grid-template-columns: repeat(3, 1fr);
		}

		.form-item {
			display: flex;
			flex-direction: column;
		}

		.form-item.full-width {
			grid-column: 1 / -1;
		}

		.form-item label {
			font-size: 13px;
			font-weight: 500;
			color: #4a5568;
			margin-bottom: 8px;
			display: flex;
			align-items: center;
			gap: 5px;
		}

		.form-control {
			padding: 10px 15px;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			font-size: 14px;
			color: #2d3748;
			background: #fff;
			transition: all 0.2s;
		}

		.form-control:focus {
			outline: none;
			border-color: #4e73df;
			box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
		}

		.form-control-file {
			padding: 8px;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			font-size: 14px;
		}

		.form-section {
			margin-top: 30px;
			padding-top: 25px;
			border-top: 1px solid #edf2f7;
		}

		.form-section h4 {
			margin: 0 0 20px;
			font-size: 16px;
			font-weight: 600;
			color: #2d3748;
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.panel-footer {
			padding: 20px 25px;
			border-top: 1px solid #edf2f7;
			background: #f8fafc;
			display: flex;
			justify-content: flex-end;
			gap: 12px;
		}

		.btn {
			padding: 10px 20px;
			border-radius: 8px;
			font-weight: 500;
			font-size: 14px;
			display: inline-flex;
			align-items: center;
			gap: 6px;
			border: none;
			cursor: pointer;
			transition: all 0.2s;
			text-decoration: none;
		}

		.btn-primary {
			background: #4e73df;
			color: #fff;
		}

		.btn-primary:hover {
			background: #2e59d9;
		}

		.btn-secondary {
			background: #f8fafc;
			color: #718096;
			border: 1px solid #e2e8f0;
		}

		.btn-secondary:hover {
			background: #edf2f7;
		}

		.btn-info {
			background: #17a2b8;
			color: #fff;
		}

		.btn-info:hover {
			background: #138496;
		}

		.btn-warning {
			background: #f6c23e;
			color: #fff;
		}

		.btn-warning:hover {
			background: #dda20a;
		}

		.btn-success {
			background: #1cc88a;
			color: #fff;
		}

		.btn-success:hover {
			background: #13855c;
		}

		.btn-outline-primary {
			background: transparent;
			color: #4e73df;
			border: 1px solid #4e73df;
		}

		.btn-outline-primary:hover {
			background: #4e73df;
			color: #fff;
		}

		/* Upload Panels */
		.upload-panels {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 20px;
		}

		.upload-panel {
			background: #fff;
			border-radius: 14px;
			overflow: hidden;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		}

		.upload-panel .panel-header {
			padding: 18px 20px;
			background: #f8fafc;
			border-bottom: 1px solid #edf2f7;
		}

		.upload-panel .panel-header h3 {
			margin: 0;
			font-size: 14px;
			font-weight: 600;
			color: #2d3748;
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.upload-panel .panel-body {
			padding: 20px;
		}

		/* Responsive */
		@media (max-width: 1200px) {
			.upload-panels {
				grid-template-columns: repeat(2, 1fr);
			}

			.form-grid {
				grid-template-columns: 1fr;
			}

			.social-grid {
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

			.upload-panels {
				grid-template-columns: 1fr;
			}

			.form-grid {
				grid-template-columns: 1fr;
			}

			.panel-footer {
				flex-direction: column;
			}
		}

		/* Dark Mode Styles */
		body.dark-mode .pengaturan-page {
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

		body.dark-mode .form-panel,
		body.dark-mode .upload-panel {
			background-color: #16213e;
			border-color: #0f3460;
		}

		body.dark-mode .panel-header {
			background-color: #0f3460;
			border-bottom-color: #16213e;
		}

		body.dark-mode .panel-header h3 {
			color: #e0e0e0;
		}

		body.dark-mode .panel-body {
			background-color: #16213e;
		}

		body.dark-mode .form-item label {
			color: #a0a0a0;
		}

		body.dark-mode .form-control {
			background-color: #1a1a2e;
			color: #e0e0e0;
			border-color: #0f3460;
		}

		body.dark-mode .form-control:focus {
			border-color: #00d9ff;
		}

		body.dark-mode .form-control-file {
			background-color: #1a1a2e;
			color: #e0e0e0;
			border-color: #0f3460;
		}

		body.dark-mode .form-section h4 {
			color: #e0e0e0;
		}

		body.dark-mode .panel-footer {
			background-color: #0f3460;
			border-top-color: #16213e;
		}

		body.dark-mode .text-muted {
			color: #a0a0a0 !important;
		}

		.font-weight-semibold {
			font-weight: 600;
		}
	</style>
</div>