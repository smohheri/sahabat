<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Donasi - <?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?> - Sistem Informasi Lembaga
		Kesejahteraan Sosial
		Anak</title>

	<!-- Favicon - Menggunakan logo dari pengaturan -->
	<?php
	$logo = $settings->logo ?? null;
	$favicon_url = !empty($logo)
		? base_url('assets/uploads/logos/' . $logo)
		: base_url('assets/img/AdminLTELogo.png');
	?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_url; ?>">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">

	<!-- Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- AOS Animation -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/landing/css/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/landing.css'); ?>">

	<style>
		:root {
			--primary-color: #7AC64D;
			--primary-dark: #5fa33a;
			--primary-light: #8ED45E;
			--secondary-color: #2C3E50;
			--accent-color: #3498DB;
			--text-dark: #2C3E50;
			--text-light: #7F8C8D;
			--bg-light: #F8F9FA;
			--white: #FFFFFF;
		}

		* {
			font-family: 'Poppins', sans-serif;
		}

		html,
		body {
			overflow: auto;
			height: auto;
		}

		body {
			/* No padding needed for fixed navbar */
		}

		/* Navbar Styles */
		.landing-navbar {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
			box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
			padding: 15px 0;
			transition: all 0.3s ease;
		}

		.landing-navbar.scrolled {
			padding: 10px 0;
			box-shadow: 0 2px 30px rgba(0, 0, 0, 0.12);
		}

		.navbar-brand {
			font-size: 24px;
			font-weight: 700;
			color: var(--primary-color) !important;
		}

		.navbar-brand span {
			color: var(--secondary-color);
		}

		.nav-link {
			font-weight: 500;
			color: var(--text-dark) !important;
			margin: 0 10px;
			position: relative;
			transition: color 0.3s ease;
		}

		.nav-link:hover {
			color: var(--primary-color) !important;
		}

		.nav-link::after {
			content: '';
			position: absolute;
			width: 0;
			height: 2px;
			bottom: 0;
			left: 0;
			background: var(--primary-color);
			transition: width 0.3s ease;
		}

		.nav-link:hover::after {
			width: 100%;
		}

		.btn-primary-custom {
			background: var(--primary-color);
			border: none;
			padding: 10px 25px;
			border-radius: 50px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.btn-primary-custom:hover {
			background: var(--primary-dark);
			transform: translateY(-2px);
			box-shadow: 0 5px 20px rgba(122, 198, 77, 0.4);
		}

		/* Donation Section */
		.donation-section {
			padding: 120px 0 100px;
			background: linear-gradient(135deg, #F8F9FA 0%, #E8F5E9 100%);
			min-height: 100vh;
		}

		.donation-container {
			max-width: 1000px;
			margin: 0 auto;
		}

		.donation-header {
			text-align: center;
			margin-bottom: 60px;
		}

		.donation-header h1 {
			font-size: 48px;
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 20px;
		}

		.donation-header p {
			font-size: 18px;
			color: var(--text-light);
			max-width: 600px;
			margin: 0 auto;
		}

		.donation-card {
			background: var(--white);
			border-radius: 20px;
			padding: 50px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			margin-bottom: 40px;
		}

		.donation-icon {
			width: 100px;
			height: 100px;
			background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
			border-radius: 25px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 30px;
			font-size: 40px;
			color: var(--white);
		}

		.donation-card h2 {
			font-size: 32px;
			font-weight: 600;
			color: var(--secondary-color);
			text-align: center;
			margin-bottom: 30px;
		}

		.donation-content {
			font-size: 16px;
			line-height: 1.8;
			color: var(--text-dark);
		}

		.donation-content p {
			margin-bottom: 25px;
		}

		.app-info-section {
			display: grid;
			grid-template-columns: auto 1fr;
			gap: 30px;
			align-items: start;
			margin-bottom: 40px;
		}

		.app-badge {
			display: flex;
			align-items: center;
			gap: 20px;
			padding: 25px;
			background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
			border-radius: 20px;
			color: var(--white);
			min-width: 280px;
		}

		.app-logo {
			width: 60px;
			height: 60px;
			border-radius: 12px;
			object-fit: contain;
		}

		.app-logo-fallback {
			width: 60px;
			height: 60px;
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.2);
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 24px;
			font-weight: 700;
		}

		.app-details h4 {
			margin: 0 0 8px;
			font-size: 20px;
			font-weight: 600;
		}

		.app-details span {
			font-size: 14px;
			opacity: 0.9;
		}

		.support-description p {
			color: var(--text-light);
			font-size: 16px;
			line-height: 1.7;
			margin-bottom: 25px;
		}

		.benefits-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
			gap: 20px;
			margin-bottom: 30px;
		}

		.benefit-item {
			display: flex;
			align-items: center;
			gap: 15px;
			padding: 20px;
			background: rgba(122, 198, 77, 0.1);
			border-radius: 15px;
			font-size: 15px;
			color: var(--text-dark);
		}

		.benefit-item i {
			color: var(--primary-color);
			font-size: 20px;
			flex-shrink: 0;
		}

		.note-box {
			background: rgba(246, 194, 62, 0.1);
			border-left: 5px solid #f6c23e;
			padding: 25px;
			border-radius: 0 15px 15px 0;
			margin: 30px 0;
		}

		.note-box-content {
			display: flex;
			align-items: flex-start;
			gap: 15px;
		}

		.note-box i {
			color: #f6c23e;
			font-size: 24px;
			flex-shrink: 0;
			margin-top: 2px;
		}

		.note-box h4 {
			margin: 0 0 8px;
			font-size: 18px;
			color: var(--secondary-color);
		}

		.note-box p {
			margin: 0;
			color: var(--text-light);
			line-height: 1.6;
		}

		/* Bank Accounts */
		.bank-accounts {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
			gap: 25px;
			margin-bottom: 40px;
		}

		.bank-card {
			background: var(--white);
			border: 2px solid #e2e8f0;
			border-radius: 20px;
			padding: 30px;
			transition: all 0.3s ease;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
		}

		.bank-card.primary {
			border-color: var(--primary-color);
			background: rgba(122, 198, 77, 0.02);
		}

		.bank-card.secondary {
			border-color: #1e3a5f;
			background: rgba(30, 58, 95, 0.02);
		}

		.bank-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
		}

		.bank-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}

		.bank-info {
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.bank-info i {
			font-size: 28px;
			color: var(--primary-color);
		}

		.bank-info h5 {
			margin: 0;
			font-size: 18px;
			font-weight: 600;
			color: var(--secondary-color);
		}

		.bank-info span {
			font-size: 14px;
			color: var(--text-light);
		}

		.status-badge {
			background: rgba(25, 135, 84, 0.1);
			color: #198754;
			padding: 6px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 6px;
		}

		.status-badge i {
			font-size: 11px;
		}

		.bank-details {
			padding-top: 20px;
			border-top: 1px solid #e2e8f0;
		}

		.account-info label {
			display: block;
			font-size: 13px;
			color: var(--text-light);
			text-transform: uppercase;
			font-weight: 500;
			margin-bottom: 8px;
			letter-spacing: 0.5px;
		}

		.account-number {
			display: flex;
			align-items: center;
			gap: 12px;
			margin-bottom: 15px;
		}

		.account-number span {
			font-size: 20px;
			font-weight: 600;
			color: var(--secondary-color);
			font-family: 'Courier New', monospace;
			letter-spacing: 1px;
		}

		.copy-btn {
			background: rgba(122, 198, 77, 0.1);
			border: 1px solid var(--primary-color);
			width: 36px;
			height: 36px;
			border-radius: 8px;
			color: var(--primary-color);
			cursor: pointer;
			transition: all 0.2s;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.copy-btn:hover {
			background: var(--primary-color);
			color: var(--white);
			transform: scale(1.05);
		}

		.account-holder {
			display: flex;
			align-items: center;
			gap: 10px;
			font-size: 15px;
			color: var(--text-light);
		}

		.account-holder i {
			font-size: 14px;
			color: var(--primary-color);
		}

		/* QR Section */
		.qr-section {
			text-align: center;
			margin-bottom: 40px;
		}

		.qr-container {
			display: inline-flex;
			flex-direction: column;
			align-items: center;
			gap: 20px;
			padding: 40px;
			background: var(--white);
			border: 2px dashed var(--primary-color);
			border-radius: 20px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
		}

		.qr-image {
			width: auto;
			height: auto;
			max-width: 300px;
			border-radius: 15px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
		}

		.qr-info h4 {
			margin: 0 0 8px;
			font-size: 22px;
			font-weight: 600;
			color: var(--secondary-color);
		}

		.qr-info p {
			margin: 0;
			font-size: 16px;
			color: var(--text-light);
		}

		/* Thank You Section */
		.thank-you-section {
			text-align: center;
		}

		.thank-you-content {
			background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
			border-radius: 25px;
			padding: 50px;
			color: var(--white);
		}

		.thank-you-icon {
			width: 80px;
			height: 80px;
			background: rgba(255, 255, 255, 0.2);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 25px;
			font-size: 32px;
		}

		.thank-you-content h3 {
			font-size: 28px;
			font-weight: 600;
			margin: 0 0 15px;
		}

		.thank-you-content p {
			font-size: 16px;
			opacity: 0.9;
			line-height: 1.7;
			margin: 0 0 25px;
			max-width: 600px;
			margin-left: auto;
			margin-right: auto;
		}

		.support-message {
			display: inline-flex;
			align-items: center;
			gap: 10px;
			background: rgba(255, 255, 255, 0.15);
			padding: 12px 25px;
			border-radius: 30px;
			font-size: 16px;
			font-weight: 500;
		}

		.support-message i {
			font-size: 18px;
		}

		.btn-back {
			display: inline-flex;
			align-items: center;
			gap: 10px;
			padding: 15px 30px;
			background: var(--white);
			color: var(--primary-color);
			border-radius: 50px;
			text-decoration: none;
			font-size: 16px;
			font-weight: 600;
			transition: all 0.3s ease;
			margin-top: 30px;
		}

		.btn-back:hover {
			background: rgba(255, 255, 255, 0.9);
			transform: translateY(-3px);
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
			color: var(--primary-dark);
		}

		/* Responsive */
		@media (max-width: 991px) {
			.donation-section {
				padding-top: 100px;
				padding-bottom: 50px;
			}

			.donation-header h1 {
				font-size: 36px;
			}

			.donation-card {
				padding: 40px 30px;
			}

			.app-info-section {
				grid-template-columns: 1fr;
				text-align: center;
			}

			.bank-accounts {
				grid-template-columns: 1fr;
			}
		}

		@media (max-width: 768px) {
			.donation-header h1 {
				font-size: 28px;
			}

			.donation-card {
				padding: 30px 20px;
			}

			.donation-icon {
				width: 80px;
				height: 80px;
				font-size: 32px;
			}

			.app-badge {
				flex-direction: column;
				text-align: center;
				min-width: auto;
			}

			.benefits-grid {
				grid-template-columns: 1fr;
			}

			.qr-container {
				padding: 30px 20px;
			}

			.qr-image {
				width: 200px;
				height: 200px;
			}

			.thank-you-content {
				padding: 40px 20px;
			}
		}
	</style>
</head>

<body>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg fixed-top landing-navbar" id="navbar">
		<div class="container">
			<a class="navbar-brand"
				href="<?php echo base_url(); ?>"><?php echo $settings->nama_lksa ?? 'Simpintar'; ?></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto align-items-center">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>#home">Beranda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>#fitur">Fitur</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>#tentang">Tentang</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>#fasilitas">Fasilitas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url(); ?>#kontak">Kontak</a>
					</li>
					<li class="nav-item ms-lg-3">
						<a href="<?php echo base_url('auth/login'); ?>" class="btn btn-primary-custom">Masuk</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Donation Section -->
	<section class="donation-section">
		<div class="container">
			<div class="donation-container">
				<div class="donation-header" data-aos="fade-up">
					<h1>Dukung Kami</h1>
					<p>Bersama membangun masa depan yang lebih baik untuk anak-anak Indonesia</p>
				</div>

				<div class="donation-card" data-aos="fade-up" data-aos-delay="100">
					<div class="donation-icon">
						<i class="fas fa-heart"></i>
					</div>
					<h2>Tentang Dukungan</h2>
					<div class="donation-content">
						<div class="app-info-section">
							<div class="app-badge">
								<?php
								$logo_path = 'assets/img/logo_sahabat.png';
								$logo_exists = file_exists($logo_path);
								?>
								<?php if ($logo_exists): ?>
									<img src="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" alt="Logo SAHABAT"
										class="app-logo">
								<?php else: ?>
									<div class="app-logo-fallback">SA</div>
								<?php endif; ?>
								<div class="app-details">
									<h4>SAHABAT</h4>
									<span>Sistem Anak Hebat Berbasis Administrasi Terpadu</span>
								</div>
							</div>
							<div class="support-description">
								<p>Halaman ini merupakan ruang bagi Anda yang ingin berpartisipasi dalam pengembangan
									aplikasi dan mendukung layanan bagi anak-anak melalui kontribusi sukarela.</p>
							</div>
						</div>

						<div class="benefits-grid">
							<div class="benefit-item">
								<i class="fas fa-rocket"></i>
								<span>Peningkatan fitur sistem</span>
							</div>
							<div class="benefit-item">
								<i class="fas fa-server"></i>
								<span>Pemeliharaan server dan database</span>
							</div>
							<div class="benefit-item">
								<i class="fas fa-shield-alt"></i>
								<span>Keberlanjutan layanan</span>
							</div>
							<div class="benefit-item">
								<i class="fas fa-lightbulb"></i>
								<span>Pengembangan fitur baru</span>
							</div>
						</div>

						<div class="note-box">
							<div class="note-box-content">
								<i class="fas fa-lightbulb"></i>
								<div>
									<h4>Donasi Bersifat Opsional</h4>
									<p>Setiap kontribusi, sekecil apa pun, memiliki arti besar bagi pengembangan
										aplikasi ini. Dukungan Anda akan langsung berdampak pada kemajuan layanan
										kesejahteraan anak.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="donation-card" data-aos="fade-up" data-aos-delay="200">
					<div class="donation-icon">
						<i class="fas fa-university"></i>
					</div>
					<h2>Rekening Donasi</h2>
					<div class="bank-accounts">
						<!-- Bank BSI -->
						<div class="bank-card primary">
							<div class="bank-header">
								<div class="bank-info">
									<i class="fas fa-university"></i>
									<div>
										<h5>Bank BSI</h5>
										<span>Utama</span>
									</div>
								</div>
								<span class="status-badge active">
									<i class="fas fa-check-circle"></i> Aktif
								</span>
							</div>
							<div class="bank-details">
								<div class="account-info">
									<label>Nomor Rekening</label>
									<div class="account-number">
										<span>7252957170</span>
										<button class="copy-btn" onclick="copyToClipboard('7252957170')" title="Salin">
											<i class="fas fa-copy"></i>
										</button>
									</div>
								</div>
								<div class="account-holder">
									<i class="fas fa-user"></i>
									<span>a.n. Moh. Heri Setiawan</span>
								</div>
							</div>
						</div>

						<!-- Bank BRI -->
						<div class="bank-card secondary">
							<div class="bank-header">
								<div class="bank-info">
									<i class="fas fa-university"></i>
									<div>
										<h5>Bank BRI</h5>
										<span>Alternatif</span>
									</div>
								</div>
								<span class="status-badge active">
									<i class="fas fa-check-circle"></i> Aktif
								</span>
							</div>
							<div class="bank-details">
								<div class="account-info">
									<label>Nomor Rekening</label>
									<div class="account-number">
										<span>057201014816537</span>
										<button class="copy-btn" onclick="copyToClipboard('057201014816537')"
											title="Salin">
											<i class="fas fa-copy"></i>
										</button>
									</div>
								</div>
								<div class="account-holder">
									<i class="fas fa-user"></i>
									<span>a.n. Moh. Heri Setiawan</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="donation-card" data-aos="fade-up" data-aos-delay="300">
					<div class="donation-icon">
						<i class="fas fa-qrcode"></i>
					</div>
					<h2>Pembayaran Digital</h2>
					<div class="qr-section">
						<div class="qr-container">
							<img src="<?php echo base_url('assets/img/QRIS.png'); ?>" alt="QR Code QRIS"
								class="qr-image">
							<div class="qr-info">
								<h4>QRIS</h4>
								<p>Scan kode QR untuk donasi cepat dan mudah</p>
							</div>
						</div>
					</div>
				</div>

				<div class="thank-you-section" data-aos="fade-up" data-aos-delay="400">
					<div class="thank-you-content">
						<div class="thank-you-icon">
							<i class="fas fa-praying-hands"></i>
						</div>
						<h3>Terima Kasih Atas Kebaikan Anda</h3>
						<p>Terima kasih atas kebaikan dan partisipasi Anda dalam menghadirkan dampak positif bersama.
							Donasi Anda akan berdampak langsung pada pengembangan sistem ini.</p>
						<div class="support-message">
							<i class="fas fa-heart"></i>
							<span>Setiap dukungan berarti bagi kami</span>
						</div>
					</div>
				</div>

				<div class="text-center" data-aos="fade-up" data-aos-delay="500">
					<a href="<?php echo base_url('lisensi'); ?>" class="btn-back">
						<i class="fas fa-arrow-left"></i>
						Kembali ke Lisensi
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- AOS Animation -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

	<script>
		// Initialize AOS
		AOS.init({
			duration: 800,
			once: true,
			offset: 100
		});

		// Navbar scroll effect
		window.addEventListener('scroll', function () {
			const navbar = document.getElementById('navbar');
			if (window.scrollY > 50) {
				navbar.classList.add('scrolled');
			} else {
				navbar.classList.remove('scrolled');
			}
		});

		// Smooth scroll
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function (e) {
				e.preventDefault();
				const target = document.querySelector(this.getAttribute('href'));
				if (target) {
					target.scrollIntoView({
						behavior: 'smooth'
					});
				}
			});
		});

		// Copy to clipboard function
		function copyToClipboard(text) {
			navigator.clipboard.writeText(text).then(function () {
				// Create toast notification
				const toast = document.createElement('div');
				toast.style.cssText = `
					position: fixed;
					bottom: 30px;
					left: 50%;
					transform: translateX(-50%);
					background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
					color: white;
					padding: 14px 28px;
					border-radius: 12px;
					font-size: 14px;
					font-weight: 500;
					z-index: 9999;
					box-shadow: 0 8px 20px rgba(0,0,0,0.2);
					display: flex;
					align-items: center;
					gap: 8px;
					animation: slideUp 0.3s ease;
				`;
				toast.innerHTML = '<i class="fas fa-check-circle"></i> Nomor rekening berhasil disalin!';
				document.body.appendChild(toast);

				setTimeout(() => {
					toast.style.animation = 'slideDown 0.3s ease';
					setTimeout(() => toast.remove(), 300);
				}, 2500);
			}).catch(function (err) {
				console.error('Gagal menyalin: ', err);
			});
		}

		// Add animation keyframes
		const style = document.createElement('style');
		style.textContent = `
			@keyframes slideUp {
				from { transform: translateX(-50%) translateY(20px); opacity: 0; }
				to { transform: translateX(-50%) translateY(0); opacity: 1; }
			}
			@keyframes slideDown {
				from { transform: translateX(-50%) translateY(0); opacity: 1; }
				to { transform: translateX(-50%) translateY(20px); opacity: 0; }
			}
		`;
		document.head.appendChild(style);
	</script>
</body>

</html>
