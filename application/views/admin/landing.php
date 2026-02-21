<div class="row">
	<?php if ($this->session->flashdata('success')): ?>
		<div class="col-12 mb-3">
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="col-12 mb-3">
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="col-md-6">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-image mr-2"></i>Gambar Hero Section
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if (!empty($pengaturan->hero_image)): ?>
					<img src="<?php echo base_url('assets/uploads/landing/' . $pengaturan->hero_image); ?>"
						alt="Gambar Hero" class="img-fluid mb-3"
						style="max-height: 200px; border: 2px solid #ddd; border-radius: 8px; padding: 5px; background: #f8f9fa;">
					<p class="text-muted small">Gambar ini akan muncul di bagian hero landing page</p>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-image fa-3x"></i>
						<p>Belum ada gambar hero</p>
						<small class="text-muted">Saat ini menggunakan gambar dari Unsplash</small>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_hero_image'); ?>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="hero_image" name="hero_image" accept="image/*">
						<label class="custom-file-label" for="hero_image">Pilih gambar hero</label>
					</div>
					<small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran disarankan:
						600x400px</small>
				</div>
				<button type="submit" class="btn btn-primary btn-block">
					<i class="fas fa-upload"></i> Upload Gambar Hero
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card card-outline card-info">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-image mr-2"></i>Gambar About Section
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if (!empty($pengaturan->about_image)): ?>
					<img src="<?php echo base_url('assets/uploads/landing/' . $pengaturan->about_image); ?>"
						alt="Gambar About" class="img-fluid mb-3"
						style="max-height: 200px; border: 2px solid #ddd; border-radius: 8px; padding: 5px; background: #f8f9fa;">
					<p class="text-muted small">Gambar ini akan muncul di bagian about landing page</p>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-image fa-3x"></i>
						<p>Belum ada gambar about</p>
						<small class="text-muted">Saat ini menggunakan gambar dari Unsplash</small>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_about_image'); ?>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="about_image" name="about_image"
							accept="image/*">
						<label class="custom-file-label" for="about_image">Pilih gambar about</label>
					</div>
					<small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran disarankan:
						600x400px</small>
				</div>
				<button type="submit" class="btn btn-info btn-block">
					<i class="fas fa-upload"></i> Upload Gambar About
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="col-12 mt-3">
		<div class="card card-outline card-warning">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-info-circle mr-2"></i>Informasi
				</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<h5><i class="fas fa-lightbulb text-warning"></i> Cara Penggunaan</h5>
						<ul>
							<li>Upload gambar hero untuk mengganti gambar di bagian atas landing page</li>
							<li>Upload gambar about untuk mengganti gambar di bagian "Tentang Kami"</li>
							<li>Gambar akan langsung aktif setelah diupload</li>
							<li>Jika belum ada gambar, sistem akan menggunakan gambar default dari Unsplash</li>
						</ul>
					</div>
					<div class="col-md-6">
						<h5><i class="fas fa-exclamation-triangle text-danger"></i> Catatan</h5>
						<ul>
							<li>Pastikan gambar berkualitas baik dan sesuai dengan tema LKSA</li>
							<li>Ukuran file maksimal 2MB per gambar</li>
							<li>Format yang didukung: JPG, JPEG, PNG</li>
							<li>Gambar akan di-resize secara otomatis di landing page</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>