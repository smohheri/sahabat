<!-- Kontak Pengembang - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-code"></i>
			</div>
			<div>
				<h2>Kontak Pengembang</h2>
				<p>Hubungi pengembang aplikasi ini untuk pertanyaan, saran, atau laporan bug</p>
			</div>
		</div>
	</div>

	<!-- Developer Information -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-user-circle"></i> Pengembang</h3>
		</div>
		<div class="panel-body">
			<div class="developer-section">
				<div class="developer-profile">
					<div class="developer-avatar">
						<i class="fas fa-user"></i>
					</div>
					<div class="developer-details">
						<h4>Moh. Heri Setiawan</h4>
						<span class="role-badge">IT Manager | Educator</span>
						<p class="description">Berpengalaman di IT, pendidikan, dan manajemen sekolah. Saat ini IT
							Manager di LSP SMK Penerbangan Cakra Nusantara. Juga aktif sebagai IT di Yayasan AL Hikmah
							Gelogor Denpasar.</p>
					</div>
				</div>
				<div class="contact-actions">
					<a href="https://github.com/smohheri" target="_blank" class="contact-btn github">
						<i class="fab fa-github"></i>
						<span>GitHub</span>
					</a>
					<a href="https://www.linkedin.com/in/moh-heri-setiawan-106a67118/" target="_blank"
						class="contact-btn linkedin">
						<i class="fab fa-linkedin"></i>
						<span>LinkedIn</span>
					</a>
					<a href="mailto:smohheri@gmail.com" class="contact-btn email">
						<i class="fas fa-envelope"></i>
						<span>Email</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Community Section -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fab fa-whatsapp"></i> Komunitas SAHABAT</h3>
		</div>
		<div class="panel-body">
			<div class="community-section">
				<div class="community-image">
					<img src="<?php echo base_url('assets/img/wa_komunitas_sahabat.jpeg'); ?>" alt="Komunitas SAHABAT"
						class="img-fluid">
				</div>
				<div class="community-content">
					<p class="community-desc">Bergabung dengan komunitas pengguna SAHABAT untuk mendapatkan update
						terbaru, diskusi, dan saling berbagi.</p>
					<a href="https://chat.whatsapp.com/LNBtMziI9FYKmMM6Mh9H8V?mode=gi_t" target="_blank"
						class="community-btn">
						<i class="fab fa-whatsapp"></i>
						<span>Gabung Komunitas</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Information Cards -->
	<div class="info-grid">
		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-clock"></i>
			</div>
			<div class="info-content">
				<h4>Jam Operasional</h4>
				<p>Senin - Jumat: 08:00 - 17:00 WIB</p>
				<p>Sabtu: 09:00 - 14:00 WIB</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-reply"></i>
			</div>
			<div class="info-content">
				<h4>Waktu Respons</h4>
				<p>Kami akan merespons dalam 1-2 hari kerja.</p>
				<p>Untuk kasus urgent, silakan hubungi langsung.</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-heart"></i>
			</div>
			<div class="info-content">
				<h4>Terima Kasih</h4>
				<p>Terima kasih telah menggunakan aplikasi SAHABAT.</p>
				<p>Kami berkomitmen untuk terus meningkatkan kualitas.</p>
			</div>
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

	.panel-body {
		padding: 25px;
	}

	/* Developer Section */
	.developer-section {
		display: grid;
		grid-template-columns: 1fr auto;
		gap: 25px;
		align-items: start;
	}

	.developer-profile {
		display: flex;
		gap: 20px;
		align-items: start;
	}

	.developer-avatar {
		width: 80px;
		height: 80px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 32px;
		color: #fff;
		flex-shrink: 0;
	}

	.developer-details h4 {
		margin: 0 0 8px;
		font-size: 20px;
		font-weight: 600;
		color: #2d3748;
	}

	.role-badge {
		display: inline-block;
		background: rgba(102, 126, 234, 0.1);
		color: #667eea;
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
		margin-bottom: 12px;
	}

	.description {
		color: #718096;
		font-size: 14px;
		line-height: 1.6;
		margin: 0 0 15px;
	}

	.contact-actions {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.contact-btn {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 12px 20px;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 500;
		text-decoration: none;
		transition: all 0.3s ease;
		min-width: 140px;
		justify-content: center;
	}

	.contact-btn.github {
		background: #333;
		color: #fff;
	}

	.contact-btn.github:hover {
		background: #000;
		transform: translateY(-2px);
	}

	.contact-btn.linkedin {
		background: #0077b5;
		color: #fff;
	}

	.contact-btn.linkedin:hover {
		background: #005885;
		transform: translateY(-2px);
	}

	.contact-btn.email {
		background: #ea4335;
		color: #fff;
	}

	.contact-btn.email:hover {
		background: #c5221f;
		transform: translateY(-2px);
	}

	/* Community Section */
	.community-section {
		display: grid;
		grid-template-columns: auto 1fr;
		gap: 25px;
		align-items: center;
	}

	.community-image {
		flex-shrink: 0;
	}

	.community-image img {
		width: 120px;
		height: 120px;
		border-radius: 12px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		object-fit: cover;
	}

	.community-content {
		padding-left: 10px;
	}

	.community-desc {
		color: #718096;
		font-size: 14px;
		line-height: 1.6;
		margin-bottom: 20px;
	}

	.community-btn {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		padding: 12px 24px;
		background: #25D366;
		color: #fff;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 600;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.community-btn:hover {
		background: #128C7E;
		transform: translateY(-2px);
		box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
	}

	/* Info Grid */
	.info-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 20px;
	}

	.info-card {
		background: #fff;
		border-radius: 14px;
		padding: 25px;
		display: flex;
		gap: 18px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
	}

	.info-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
	}

	.info-icon {
		width: 55px;
		height: 55px;
		background: rgba(78, 115, 223, 0.1);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		color: #4e73df;
		flex-shrink: 0;
	}

	.info-content h4 {
		margin: 0 0 10px;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
	}

	.info-content p {
		margin: 0;
		font-size: 13px;
		color: #718096;
		line-height: 1.6;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.info-grid {
			grid-template-columns: repeat(2, 1fr);
		}

		.developer-section {
			grid-template-columns: 1fr;
			gap: 20px;
		}

		.community-section {
			grid-template-columns: 1fr;
			text-align: center;
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

		.info-grid {
			grid-template-columns: 1fr;
		}

		.developer-profile {
			flex-direction: column;
			text-align: center;
		}

		.contact-actions {
			align-items: center;
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

	body.dark-mode .panel-body {
		background-color: #16213e;
	}

	body.dark-mode .developer-details h4 {
		color: #e0e0e0;
	}

	body.dark-mode .description,
	body.dark-mode .community-desc {
		color: #a0a0a0;
	}

	body.dark-mode .info-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .info-content h4 {
		color: #e0e0e0;
	}

	body.dark-mode .info-content p {
		color: #a0a0a0;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}
</style>