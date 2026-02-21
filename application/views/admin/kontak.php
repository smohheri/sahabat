<!-- Kontak Pengembang Page -->
<div class="kontak-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-icon">
			<i class="fas fa-code"></i>
		</div>
		<div class="header-content">
			<h1>Kontak Pengembang</h1>
			<p>Hubungi pengembang aplikasi ini untuk pertanyaan, saran, atau laporan bug</p>
		</div>
	</div>

	<!-- Two Column Layout: Developer & Komunitas -->
	<div class="two-column-grid">
		<!-- Developer Card -->
		<div class="developer-card">
			<div class="card-header">
				<i class="fas fa-user-circle"></i>
				<h3>Pengembang</h3>
			</div>
			<div class="card-body">
				<div class="developer-avatar">
					<i class="fas fa-user"></i>
				</div>
				<div class="developer-info">
					<h4>Moh. Heri Setiawan</h4>
					<span class="role">IT Manager | Educator</span>
					<p class="description">Berpengalaman di IT, pendidikan, dan manajemen sekolah. Saat ini IT Manager
						di LSP SMK Penerbangan Cakra Nusantara. Juga aktif sebagai IT di Yayasan AL Hikmah Gelogor
						Denpasar.</p>
					<div class="contact-links">
						<a href="https://github.com/smohheri" target="_blank" class="contact-btn github">
							<i class="fab fa-github"></i> GitHub
						</a>
						<a href="https://www.linkedin.com/in/moh-heri-setiawan-106a67118/" target="_blank"
							class="contact-btn linkedin">
							<i class="fab fa-linkedin"></i> LinkedIn
						</a>
						<a href="mailto:smohheri@gmail.com" class="contact-btn email">
							<i class="fas fa-envelope"></i> Email
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Komunitas Card -->
		<div class="komunitas-card">
			<div class="card-header wa-header">
				<i class="fab fa-whatsapp"></i>
				<h3>Komunitas SAHABAT</h3>
			</div>
			<div class="card-body">
				<div class="komunitas-image">
					<img src="<?php echo base_url('assets/img/wa_komunitas_sahabat.jpeg'); ?>" alt="Komunitas SAHABAT"
						class="img-fluid">
				</div>
				<div class="komunitas-info">
					<p class="komunitas-desc">Bergabung dengan komunitas pengguna SAHABAT untuk mendapatkan update
						terbaru, diskusi, dan saling berbagi.</p>
					<a href="https://chat.whatsapp.com/LNBtMziI9FYKmMM6Mh9H8V?mode=gi_t" target="_blank"
						class="btn-komunitas">
						<i class="fab fa-whatsapp"></i> Gabung Sekarang
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Info Section -->
	<div class="info-section">
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
	.kontak-page {
		padding: 10px;
	}

	/* Page Header */
	.page-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 20px;
		padding: 30px;
		display: flex;
		align-items: center;
		gap: 25px;
		margin-bottom: 30px;
		color: #fff;
	}

	.header-icon {
		width: 80px;
		height: 80px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 20px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 36px;
		backdrop-filter: blur(10px);
	}

	.header-content h1 {
		margin: 0 0 8px;
		font-size: 28px;
		font-weight: 700;
	}

	.header-content p {
		margin: 0;
		opacity: 0.9;
		font-size: 15px;
	}

	/* Two Column Grid */
	.two-column-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 25px;
		margin-bottom: 30px;
	}

	/* Card Base Styles */
	.developer-card,
	.komunitas-card {
		background: #fff;
		border-radius: 16px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
	}

	.developer-card:hover,
	.komunitas-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
	}

	.card-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		padding: 20px 25px;
		display: flex;
		align-items: center;
		gap: 12px;
		color: #fff;
	}

	.card-header i {
		font-size: 24px;
	}

	.card-header h3 {
		margin: 0;
		font-size: 18px;
		font-weight: 600;
	}

	.card-header.wa-header {
		background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
	}

	.card-body {
		padding: 25px;
	}

	/* Developer Card Specific */
	.developer-card .card-body {
		display: flex;
		gap: 20px;
	}

	.developer-avatar {
		width: 70px;
		height: 70px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 28px;
		color: #fff;
		flex-shrink: 0;
	}

	.developer-info {
		flex: 1;
	}

	.developer-info h4 {
		margin: 0 0 5px;
		font-size: 18px;
		font-weight: 600;
		color: #2d3748;
	}

	.developer-info .role {
		display: inline-block;
		background: rgba(102, 126, 234, 0.1);
		color: #667eea;
		padding: 3px 10px;
		border-radius: 15px;
		font-size: 11px;
		font-weight: 500;
		margin-bottom: 10px;
	}

	.developer-info .description {
		color: #718096;
		font-size: 13px;
		line-height: 1.5;
		margin-bottom: 12px;
	}

	.contact-links {
		display: flex;
		gap: 8px;
		flex-wrap: wrap;
	}

	.contact-btn {
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 500;
		text-decoration: none;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		transition: all 0.3s ease;
	}

	.contact-btn.github {
		background: #333;
		color: #fff;
	}

	.contact-btn.github:hover {
		background: #000;
	}

	.contact-btn.linkedin {
		background: #0077b5;
		color: #fff;
	}

	.contact-btn.linkedin:hover {
		background: #005885;
	}

	.contact-btn.email {
		background: #ea4335;
		color: #fff;
	}

	.contact-btn.email:hover {
		background: #c5221f;
	}

	/* Komunitas Card Specific */
	.komunitas-image {
		margin-bottom: 15px;
		text-align: center;
	}

	.komunitas-image img {
		width: 70%;
		max-width: 250px;
		border-radius: 10px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
	}

	.komunitas-info .komunitas-desc {
		color: #718096;
		font-size: 13px;
		line-height: 1.5;
		margin-bottom: 15px;
	}

	.btn-komunitas {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		width: 100%;
		padding: 12px 24px;
		background: #25D366;
		color: #fff;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 600;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.btn-komunitas:hover {
		background: #128C7E;
		transform: translateY(-2px);
		box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
	}

	/* Info Section */
	.info-section {
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
	}

	.info-icon {
		width: 50px;
		height: 50px;
		background: rgba(102, 126, 234, 0.1);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 22px;
		color: #667eea;
		flex-shrink: 0;
	}

	.info-content h4 {
		margin: 0 0 8px;
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
	@media (max-width: 992px) {
		.two-column-grid {
			grid-template-columns: 1fr;
		}

		.info-section {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 768px) {
		.page-header {
			flex-direction: column;
			text-align: center;
			padding: 25px;
		}

		.developer-card .card-body {
			flex-direction: column;
			text-align: center;
		}

		.contact-links {
			justify-content: center;
		}
	}

	/* Dark Mode Styles */
	body.dark-mode .kontak-page {
		background-color: #1a1a2e;
	}

	body.dark-mode .page-header {
		background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
		border: 1px solid #00d9ff;
	}

	body.dark-mode .header-content h1,
	body.dark-mode .header-content p {
		color: #e0e0e0;
	}

	body.dark-mode .developer-card,
	body.dark-mode .komunitas-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .developer-info h4 {
		color: #e0e0e0;
	}

	body.dark-mode .developer-info .description {
		color: #a0a0a0;
	}

	body.dark-mode .komunitas-info .komunitas-desc {
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
</style>