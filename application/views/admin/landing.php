<!-- Kelola Landing Page - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-globe"></i>
			</div>
			<div>
				<h2>Kelola Landing Page</h2>
				<p>Atur gambar dan konten untuk halaman landing website LKSA</p>
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

	<!-- Content Grid -->
	<div class="content-grid">
		<!-- Main Content -->
		<div class="content-main">
			<!-- About Image Section -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-image"></i> Gambar About Section</h3>
					<span class="data-count">Tentang Kami</span>
				</div>
				<div class="panel-body">
					<div class="image-upload-section">
						<div class="current-image">
							<?php if (!empty($pengaturan->about_image)): ?>
								<img src="<?php echo base_url('assets/uploads/landing/' . $pengaturan->about_image); ?>"
									alt="Gambar About" class="img-fluid">
								<div class="image-info">
									<i class="fas fa-check-circle text-green"></i>
									<span>Gambar about aktif</span>
								</div>
							<?php else: ?>
								<div class="no-image">
									<i class="fas fa-image fa-3x text-muted"></i>
									<p>Belum ada gambar about</p>
									<small class="text-muted">Menggunakan gambar default dari Unsplash</small>
								</div>
							<?php endif; ?>
						</div>
						<div class="upload-form">
							<?php echo form_open_multipart('admin/upload_about_image'); ?>
							<div class="form-group">
								<label class="form-label">Pilih Gambar Baru</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="about_image" name="about_image"
										accept="image/*">
									<label class="custom-file-label" for="about_image">Pilih gambar about...</label>
								</div>
								<small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran disarankan:
									600x400px</small>
							</div>
							<button type="submit" class="btn btn-info">
								<i class="fas fa-upload mr-2"></i>Upload Gambar About
							</button>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Sidebar -->
		<div class="content-side">
			<!-- Information Panel -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-info-circle"></i> Informasi</h3>
				</div>
				<div class="panel-body">
					<div class="info-content">
						<div class="info-section">
							<h4><i class="fas fa-lightbulb text-warning"></i> Cara Penggunaan</h4>
							<ul class="info-list">
								<li>Upload gambar about untuk mengganti gambar di bagian "Tentang Kami"</li>
								<li>Gambar akan langsung aktif setelah diupload</li>
								<li>Jika belum ada gambar, sistem akan menggunakan gambar default</li>
								<li>Konten hero section dikelola melalui menu "Kelola Hero Images"</li>
							</ul>
						</div>
						<div class="info-section">
							<h4><i class="fas fa-exclamation-triangle text-danger"></i> Catatan</h4>
							<ul class="info-list">
								<li>Pastikan gambar berkualitas baik dan sesuai dengan tema LKSA</li>
								<li>Ukuran file maksimal 2MB per gambar</li>
								<li>Format yang didukung: JPG, JPEG, PNG</li>
								<li>Gambar akan di-resize secara otomatis</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Preview Links -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-external-link-alt"></i> Pratinjau</h3>
				</div>
				<div class="panel-body">
					<div class="preview-links">
						<a href="<?php echo base_url(); ?>" target="_blank" class="preview-btn">
							<i class="fas fa-globe mr-2"></i>
							<span>Lihat Landing Page</span>
							<i class="fas fa-external-link-alt ml-2"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	/* Image Upload Section */
	.image-upload-section {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 25px;
		align-items: start;
	}

	.current-image {
		position: relative;
	}

	.current-image img {
		width: 100%;
		border-radius: 12px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}

	.image-info {
		position: absolute;
		top: 10px;
		right: 10px;
		background: rgba(255, 255, 255, 0.9);
		padding: 8px 12px;
		border-radius: 20px;
		display: flex;
		align-items: center;
		gap: 5px;
		font-size: 12px;
		font-weight: 500;
		color: #2d3748;
	}

	.no-image {
		border: 2px dashed #e2e8f0;
		border-radius: 12px;
		padding: 40px;
		text-align: center;
		background: #f8fafc;
	}

	.no-image i {
		margin-bottom: 15px;
	}

	.no-image p {
		margin: 0 0 5px;
		font-weight: 500;
		color: #718096;
	}

	/* Upload Form */
	.upload-form {
		background: #f8fafc;
		border-radius: 12px;
		padding: 20px;
	}

	.form-label {
		display: block;
		font-size: 14px;
		font-weight: 600;
		color: #2d3748;
		margin-bottom: 10px;
	}

	.custom-file {
		position: relative;
		display: inline-block;
		width: 100%;
		margin-bottom: 10px;
	}

	.custom-file-input {
		position: relative;
		z-index: 2;
		width: 100%;
		height: calc(1.5em + 0.75rem + 2px);
		margin: 0;
		opacity: 0;
	}

	.custom-file-label {
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		z-index: 1;
		height: calc(1.5em + 0.75rem + 2px);
		padding: 0.375rem 0.75rem;
		font-weight: 400;
		line-height: 1.5;
		color: #6c757d;
		background-color: #fff;
		border: 1px solid #ced4da;
		border-radius: 0.25rem;
		display: flex;
		align-items: center;
	}

	.custom-file-label::after {
		content: "Browse";
		margin-left: auto;
		padding: 0.375rem 0.75rem;
		background-color: #e9ecef;
		border-left: inherit;
		border-radius: 0 0.25rem 0.25rem 0;
		color: #6c757d;
	}

	.form-text {
		font-size: 12px;
		color: #718096;
		margin-top: 5px;
	}

	.btn {
		border-radius: 8px;
		font-weight: 500;
		padding: 10px 20px;
		transition: all 0.3s ease;
	}

	.btn-primary {
		background: #4e73df;
		border: none;
	}

	.btn-primary:hover {
		background: #2e59d9;
		transform: translateY(-1px);
	}

	.btn-info {
		background: #17a2b8;
		border: none;
	}

	.btn-info:hover {
		background: #138496;
		transform: translateY(-1px);
	}


	/* Responsive */
	@media (max-width: 1200px) {
		.content-grid {
			grid-template-columns: 1fr;
		}

		.image-upload-section {
			grid-template-columns: 1fr;
			gap: 20px;
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

		.panel-body {
			padding: 20px;
		}

		.image-upload-section {
			grid-template-columns: 1fr;
		}
	}

	/* Dark Mode Styles */
	body.dark-mode .upload-form {
		background-color: #0f3460;
	}

	body.dark-mode .no-image {
		background-color: #0f3460;
		border-color: #16213e;
	}

	body.dark-mode .custom-file-label {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .form-text {
		color: #a0a0a0;
	}

	body.dark-mode .text-green {
		color: #1cc88a !important;
	}
</style>

<script>
	// Custom file input label update
	$('.custom-file-input').on('change', function () {
		var fileName = $(this).val().split('\\').pop();
		$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
	});
</script>