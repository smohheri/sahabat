<!-- Kelola Carousel Images - Landing Page -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-images"></i>
			</div>
			<div>
				<h2>Kelola Carousel</h2>
				<p>Atur gambar-gambar untuk carousel hero section landing page</p>
			</div>
		</div>
		<div class="header-actions">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCarouselModal">
				<i class="fas fa-plus mr-2"></i>Tambah Carousel Image
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

	<!-- Content Grid -->
	<div class="content-grid">
		<!-- Main Content -->
		<div class="content-main">
			<!-- Carousel Images Grid -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-images"></i> Gambar Carousel</h3>
					<span class="data-count"><?php echo count($carousel_images); ?> gambar</span>
				</div>
				<div class="panel-body">
					<?php if (!empty($carousel_images)): ?>
						<div class="row">
							<?php foreach ($carousel_images as $image): ?>
								<div class="col-md-4 mb-4">
									<div class="card">
										<div class="card-body p-0 position-relative">
											<?php
											$image_path = 'assets/uploads/landing/' . $image->image_name;
											?>
											<a href="<?php echo base_url($image_path); ?>" data-toggle="lightbox"
												data-title="<?php echo $image->title; ?>">
												<img src="<?php echo base_url($image_path); ?>" class="carousel-preview-img"
													alt="<?php echo $image->title; ?>">
											</a>
											<div class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
												<?php if ($image->is_active): ?>
													<span class="badge bg-success"><i class="fas fa-check-circle"></i> Aktif</span>
												<?php endif; ?>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-12">
													<h5 class="card-title"><?php echo $image->title ?: 'Carousel Image'; ?></h5>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<?php if ($image->description): ?>
														<p class="card-text">
															<?php echo substr($image->description, 0, 80) . (strlen($image->description) > 80 ? '...' : ''); ?>
														</p>
													<?php endif; ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 d-flex align-items-center">
													<p class="card-text">
														<small class="text-muted">Urutan:
															<?php echo $image->sort_order; ?></small>
													</p>
												</div>
												<div class="col-md-6 d-flex align-items-center justify-content-end">
													<div class="btn-group" role="group">
														<button class="btn btn-primary btn-sm edit-btn"
															data-id="<?php echo $image->id_carousel; ?>" title="Edit">
															<i class="fas fa-edit"></i>
														</button>
														<button class="btn btn-danger btn-sm delete-btn"
															data-id="<?php echo $image->id_carousel; ?>" title="Hapus">
															<i class="fas fa-trash"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="empty-state">
							<div class="empty-icon">
								<i class="fas fa-images"></i>
							</div>
							<h3>Belum ada gambar carousel</h3>
							<p>Klik tombol "Tambah Carousel Image" untuk menambah gambar pertama</p>
							<button type="button" class="btn btn-primary" data-toggle="modal"
								data-target="#addCarouselModal">
								<i class="fas fa-plus mr-2"></i>Tambah Gambar Pertama
							</button>
						</div>
					<?php endif; ?>
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
								<li>Klik "Tambah Carousel Image" untuk menambah gambar baru</li>
								<li>Gunakan tombol edit untuk mengubah judul, deskripsi, dan urutan</li>
								<li>Gambar aktif akan ditampilkan di landing page</li>
								<li>Urutan menentukan posisi tampilan carousel</li>
							</ul>
						</div>
						<div class="info-section">
							<h4><i class="fas fa-exclamation-triangle text-danger"></i> Catatan</h4>
							<ul class="info-list">
								<li>Pastikan gambar berkualitas baik (minimal 800x400px)</li>
								<li>Ukuran file maksimal 2MB per gambar</li>
								<li>Format yang didukung: JPG, JPEG, PNG</li>
								<li>Gambar akan di-resize secara otomatis</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Statistics Panel -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-chart-bar"></i> Statistik</h3>
				</div>
				<div class="panel-body">
					<div class="stats-grid">
						<div class="stat-item">
							<div class="stat-number"><?php echo count($carousel_images); ?></div>
							<div class="stat-label">Total Gambar</div>
						</div>
						<div class="stat-item">
							<div class="stat-number">
								<?php echo count(array_filter($carousel_images, function ($img) {
									return $img->is_active;
								})); ?>
							</div>
							<div class="stat-label">Gambar Aktif</div>
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

<!-- Add Carousel Modal -->
<div class="modal fade" id="addCarouselModal" tabindex="-1" role="dialog" aria-labelledby="addCarouselModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCarouselModalLabel">Tambah Carousel Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open_multipart('admin/carousel/upload'); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="carousel_image">Pilih Gambar</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="carousel_image" name="carousel_image"
							accept="image/*" required>
						<label class="custom-file-label" for="carousel_image">Pilih file gambar...</label>
					</div>
					<small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
				</div>
				<div class="form-group">
					<label for="title">Judul</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul gambar">
				</div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<textarea class="form-control" id="description" name="description" rows="3"
						placeholder="Masukkan deskripsi gambar"></textarea>
				</div>
				<div class="form-group">
					<label for="sort_order">Urutan</label>
					<input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary">Upload</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- Edit Carousel Modal -->
<div class="modal fade" id="editCarouselModal" tabindex="-1" role="dialog" aria-labelledby="editCarouselModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editCarouselModalLabel">Edit Carousel Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open('admin/carousel/update', ['id' => 'editCarouselForm']); ?>
			<input type="hidden" id="edit_id_carousel" name="id_carousel">
			<div class="modal-body">
				<div class="form-group">
					<label for="edit_title">Judul</label>
					<input type="text" class="form-control" id="edit_title" name="title"
						placeholder="Masukkan judul gambar">
				</div>
				<div class="form-group">
					<label for="edit_description">Deskripsi</label>
					<textarea class="form-control" id="edit_description" name="description"
						placeholder="Masukkan deskripsi gambar"></textarea>
				</div>
				<div class="form-group">
					<label for="edit_sort_order">Urutan</label>
					<input type="number" class="form-control" id="edit_sort_order" name="sort_order" value="0" min="0">
				</div>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1"
						checked>
					<label class="form-check-label" for="edit_is_active">Aktif</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
			<?php echo form_close(); ?>
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

	/* Content Grid */
	.content-grid {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 25px;
	}

	/* Data Panel */
	.data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		margin-bottom: 25px;
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
		padding: 25px;
	}

	/* Carousel Grid */
	.carousel-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 20px;
	}

	.carousel-item {
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
		overflow: hidden;
		transition: all 0.3s ease;
		border: 1px solid #edf2f7;
	}

	.carousel-item:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
	}

	.carousel-image-container {
		position: relative;
		height: 180px;
		overflow: hidden;
		background: #f8fafc;
	}

	.carousel-image {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
		display: block;
	}

	.carousel-item:hover .carousel-image {
		transform: scale(1.05);
	}

	.image-placeholder {
		text-align: center;
		color: #a0aec0;
	}

	.image-placeholder i {
		display: block;
		margin-bottom: 8px;
	}

	.carousel-overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0, 0, 0, 0.6);
		display: flex;
		align-items: center;
		justify-content: center;
		opacity: 0;
		transition: opacity 0.3s ease;
		z-index: 2;
	}

	.carousel-item:hover .carousel-overlay {
		opacity: 1;
	}

	.carousel-actions {
		display: flex;
		gap: 8px;
	}

	.carousel-actions .btn {
		border-radius: 50%;
		width: 36px;
		height: 36px;
		display: flex;
		align-items: center;
		justify-content: center;
		border: none;
		transition: all 0.3s ease;
	}

	.carousel-actions .btn:hover {
		transform: scale(1.1);
	}

	.active-badge {
		position: absolute;
		top: 10px;
		right: 10px;
		background: rgba(28, 200, 138, 0.9);
		color: white;
		padding: 4px 8px;
		border-radius: 12px;
		font-size: 11px;
		font-weight: 600;
		display: flex;
		align-items: center;
		gap: 4px;
		z-index: 3;
	}

	.carousel-info {
		padding: 16px;
	}

	.carousel-info h4 {
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		margin-bottom: 8px;
		line-height: 1.3;
	}

	.description {
		color: #718096;
		font-size: 13px;
		line-height: 1.4;
		margin-bottom: 8px;
	}

	.sort-info {
		font-size: 12px;
		color: #a0aec0;
	}

	/* Empty State */
	.empty-state {
		text-align: center;
		padding: 60px 20px;
		background: #f8fafc;
		border-radius: 12px;
		border: 2px dashed #e2e8f0;
	}

	.empty-icon {
		font-size: 48px;
		color: #cbd5e0;
		margin-bottom: 20px;
	}

	.empty-state h3 {
		color: #4a5568;
		margin-bottom: 10px;
		font-size: 18px;
	}

	.empty-state p {
		color: #718096;
		margin-bottom: 20px;
	}

	/* Stats Grid */
	.stats-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 15px;
	}

	.stat-item {
		text-align: center;
		padding: 15px;
		background: #f8fafc;
		border-radius: 8px;
	}

	.stat-number {
		font-size: 24px;
		font-weight: 700;
		color: #4e73df;
		display: block;
		margin-bottom: 5px;
	}

	.stat-label {
		font-size: 12px;
		color: #718096;
		font-weight: 500;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	/* Modal Styles */
	.modal-content {
		border-radius: 12px;
		border: none;
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
	}

	.modal-header {
		border-bottom: 1px solid #edf2f7;
		padding: 20px 25px;
	}

	.modal-title {
		font-weight: 600;
		color: #2d3748;
	}

	.modal-body {
		padding: 25px;
	}

	.modal-footer {
		border-top: 1px solid #edf2f7;
		padding: 20px 25px;
	}

	.form-group {
		margin-bottom: 20px;
	}

	.form-group label {
		font-weight: 600;
		color: #2d3748;
		margin-bottom: 8px;
		display: block;
	}

	.form-control {
		border-radius: 8px;
		border: 1px solid #e2e8f0;
		padding: 10px 15px;
		font-size: 14px;
		transition: all 0.3s ease;
	}

	.form-control:focus {
		border-color: #4e73df;
		box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
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
		border: 1px solid #e2e8f0;
		border-radius: 8px;
		display: flex;
		align-items: center;
		transition: all 0.3s ease;
	}

	.custom-file-input:focus~.custom-file-label {
		border-color: #4e73df;
		box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
	}

	.form-text {
		font-size: 12px;
		color: #a0aec0;
		margin-top: 5px;
	}

	.form-check {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.form-check-input {
		width: 16px;
		height: 16px;
		border-radius: 4px;
		border: 1px solid #e2e8f0;
	}

	.form-check-label {
		font-weight: 500;
		color: #4a5568;
		margin-bottom: 0;
	}

	.btn {
		border-radius: 8px;
		font-weight: 500;
		padding: 10px 20px;
		transition: all 0.3s ease;
		border: none;
	}

	.btn-primary {
		background: #4e73df;
		color: white;
	}

	.btn-primary:hover {
		background: #2e59d9;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
	}

	.btn-secondary {
		background: #6c757d;
		color: white;
	}

	.btn-secondary:hover {
		background: #545b62;
		transform: translateY(-1px);
	}

	.btn-light {
		background: rgba(255, 255, 255, 0.9);
		color: #2d3748;
		border: 1px solid #e2e8f0;
	}

	.btn-light:hover {
		background: white;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}

	.btn-danger {
		background: #e74a3b;
		color: white;
	}

	.btn-danger:hover {
		background: #c82333;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(231, 74, 59, 0.3);
	}

	/* Info Content */
	.info-content {
		padding: 0;
	}

	.info-section {
		margin-bottom: 20px;
	}

	.info-section:last-child {
		margin-bottom: 0;
	}

	.info-section h4 {
		font-size: 14px;
		font-weight: 600;
		color: #2d3748;
		margin-bottom: 12px;
		display: flex;
		align-items: center;
		gap: 6px;
	}

	.info-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.info-list li {
		padding: 6px 0;
		padding-left: 18px;
		position: relative;
		color: #718096;
		font-size: 13px;
		line-height: 1.4;
	}

	.info-list li:before {
		content: "•";
		color: #4e73df;
		font-weight: bold;
		position: absolute;
		left: 0;
	}

	/* Preview Links */
	.preview-links {
		padding: 0;
	}

	.preview-btn {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 15px 20px;
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		border-radius: 10px;
		text-decoration: none;
		color: #2d3748;
		transition: all 0.3s ease;
	}

	.preview-btn:hover {
		background: #4e73df;
		color: #fff;
		border-color: #4e73df;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
	}

	.preview-btn i {
		font-size: 16px;
	}

	/* Alert Styles */
	.alert {
		border-radius: 10px;
		border: none;
		padding: 15px 20px;
		margin-bottom: 25px;
	}

	.alert-success {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.alert-danger {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	/* Modern Bootstrap Card Design */
	.card {
		border: none;
		border-radius: 20px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
		transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		overflow: hidden;
		background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
	}

	.card:hover {
		transform: translateY(-15px) scale(1.02);
		box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
	}

	.card-img-top {
		border-radius: 20px 20px 0 0;
		height: 220px;
		object-fit: cover;
		transition: transform 0.4s ease;
		filter: brightness(1);
	}

	.card:hover .card-img-top {
		transform: scale(1.1);
		filter: brightness(1.1) contrast(1.1);
	}

	.card-body {
		background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #e9ecef 100%);
		padding: 1.5rem;
		border-radius: 0 0 20px 20px;
	}

	.card-title {
		font-weight: 700;
		color: #2d3748;
		margin-bottom: 0.5rem;
		font-size: 1.1rem;
	}

	.card-text {
		color: #718096;
		font-size: 0.9rem;
		line-height: 1.4;
	}

	.badge {
		border-radius: 25px;
		font-size: 10px;
		padding: 8px 12px;
		font-weight: 600;
		background: linear-gradient(45deg, #28a745, #20c997);
		color: white;
		border: none;
		box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
	}

	.btn-group .btn {
		border-radius: 50% !important;
		width: 40px;
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.3s ease;
		border: 2px solid;
		font-size: 14px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
	}

	.btn-outline-primary {
		background: linear-gradient(45deg, #007bff, #0056b3);
		border-color: #007bff;
		color: white;
	}

	.btn-outline-primary:hover {
		background: linear-gradient(45deg, #0056b3, #004085);
		border-color: #0056b3;
		transform: scale(1.1);
		box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
	}

	.btn-outline-danger {
		background: linear-gradient(45deg, #dc3545, #c82333);
		border-color: #dc3545;
		color: white;
	}

	.btn-outline-danger:hover {
		background: linear-gradient(45deg, #c82333, #a02622);
		border-color: #c82333;
		transform: scale(1.1);
		box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
	}

	.text-muted {
		color: #a0aec0 !important;
		font-weight: 500;
	}

	/* Carousel Preview Image Uniform Sizing */
	.carousel-preview-img {
		width: 100%;
		height: 200px;
		object-fit: cover;
		border-radius: 12px 12px 0 0;
		display: block;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.content-grid {
			grid-template-columns: 1fr;
		}

		.carousel-grid {
			grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

		.carousel-grid {
			grid-template-columns: 1fr;
		}

		.stats-grid {
			grid-template-columns: 1fr;
		}

		.modal-dialog {
			margin: 10px;
		}

		.panel-body {
			padding: 20px;
		}
	}

	/* Dark Mode Styles */
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

	body.dark-mode .panel-body {
		background-color: #16213e;
	}

	body.dark-mode .carousel-item {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .carousel-image-container {
		background-color: #0f3460;
	}

	body.dark-mode .image-placeholder {
		color: #a0a0a0;
	}

	body.dark-mode .carousel-info h4 {
		color: #e0e0e0;
	}

	body.dark-mode .description {
		color: #a0a0a0;
	}

	body.dark-mode .sort-info {
		color: #a0a0a0;
	}

	body.dark-mode .empty-state {
		background-color: #0f3460;
		border-color: #16213e;
	}

	body.dark-mode .empty-state h3 {
		color: #e0e0e0;
	}

	body.dark-mode .empty-state p {
		color: #a0a0a0;
	}

	body.dark-mode .stat-item {
		background-color: #0f3460;
	}

	body.dark-mode .stat-number {
		color: #4e73df;
	}

	body.dark-mode .stat-label {
		color: #a0a0a0;
	}

	body.dark-mode .modal-content {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .modal-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .modal-title {
		color: #e0e0e0;
	}

	body.dark-mode .form-control {
		background-color: #1a1a2e;
		border-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .custom-file-label {
		background-color: #0f3460;
		border-color: #16213e;
		color: #a0a0a0;
	}

	body.dark-mode .form-text {
		color: #a0a0a0;
	}

	body.dark-mode .form-check-label {
		color: #e0e0e0;
	}

	body.dark-mode .info-section h4 {
		color: #e0e0e0;
	}

	body.dark-mode .info-list li {
		color: #a0a0a0;
	}

	body.dark-mode .preview-btn {
		background-color: #0f3460;
		border-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .preview-btn:hover {
		background-color: #4e73df;
		color: #fff;
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

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
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

	// Edit button click
	$('.edit-btn').on('click', function () {
		var card = $(this).closest('.card');
		var id = $(this).data('id');
		var title = card.find('.card-title').text();
		var description = card.find('.card-text').first().text().trim() || '';
		var sortOrder = card.find('small').text().replace('Urutan: ', '');
		var isActive = card.find('.badge').length > 0;

		$('#edit_id_carousel').val(id);
		$('#edit_title').val(title === 'Carousel Image' ? '' : title);
		$('#edit_description').val(description);
		$('#edit_sort_order').val(sortOrder);
		$('#edit_is_active').prop('checked', isActive);
		$('#editCarouselModal').modal('show');
	});

	// Delete button click
	$('.delete-btn').on('click', function () {
		var id = $(this).data('id');
		if (confirm('Apakah Anda yakin ingin menghapus carousel image ini?')) {
			window.location.href = '<?php echo base_url("admin/carousel/delete/"); ?>' + id;
		}
	});
</script>