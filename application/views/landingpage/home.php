<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?> - Sistem Informasi Lembaga Kesejahteraan Sosial
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

		.btn-outline-custom {
			border: 2px solid var(--primary-color);
			color: var(--primary-color);
			padding: 8px 25px;
			border-radius: 50px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.btn-outline-custom:hover {
			background: var(--primary-color);
			color: var(--white);
		}

		/* Hero Section */
		.hero-section {
			padding: 120px 0 100px;
			background: linear-gradient(135deg, #F8F9FA 0%, #E8F5E9 100%);
			position: relative;
			overflow: hidden;
		}

		.hero-section::before {
			content: '';
			position: absolute;
			width: 400px;
			height: 400px;
			background:
				<?php echo !empty($settings->logo) ? 'url(' . base_url('assets/uploads/logos/' . $settings->logo) . ')' : 'radial-gradient(circle, rgba(122, 198, 77, 0.15) 0%, transparent 70%)'; ?>
			;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
			opacity:
				<?php echo !empty($settings->logo) ? '0.1' : '1'; ?>
			;
			top: -100px;
			right: -100px;
			animation: float 8s ease-in-out infinite;
		}

		.hero-section::after {
			content: '';
			position: absolute;
			width: 400px;
			height: 400px;
			background: radial-gradient(circle, rgba(52, 152, 219, 0.1) 0%, transparent 70%);
			bottom: -100px;
			left: -100px;
			animation: float 6s ease-in-out infinite reverse;
		}

		@keyframes float {

			0%,
			100% {
				transform: translate(0, 0);
			}

			50% {
				transform: translate(30px, 30px);
			}
		}

		.hero-content {
			position: relative;
			z-index: 2;
		}

		.hero-badge {
			display: inline-block;
			background: rgba(122, 198, 77, 0.15);
			color: var(--primary-dark);
			padding: 8px 20px;
			border-radius: 50px;
			font-size: 14px;
			font-weight: 500;
			margin-bottom: 20px;
		}

		.hero-title {
			font-size: 56px;
			font-weight: 700;
			line-height: 1.2;
			margin-bottom: 20px;
			color: var(--secondary-color);
		}

		.hero-title span {
			color: var(--primary-color);
		}

		.hero-subtitle {
			font-size: 18px;
			color: var(--text-light);
			margin-bottom: 30px;
			line-height: 1.8;
		}

		.hero-buttons {
			display: flex;
			gap: 15px;
			flex-wrap: wrap;
		}

		.hero-image {
			position: relative;
			z-index: 2;
		}

		.hero-image img {
			width: 100%;
			max-width: 550px;
			border-radius: 20px;
			box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
			animation: float 6s ease-in-out infinite;
		}



		/* Features Section */
		.features-section {
			padding: 100px 0;
			background: var(--white);
		}

		.section-title {
			text-align: center;
			margin-bottom: 60px;
		}

		.section-title h2 {
			font-size: 40px;
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 15px;
		}

		.section-title p {
			font-size: 18px;
			color: var(--text-light);
			max-width: 600px;
			margin: 0 auto;
		}

		.feature-card {
			background: var(--white);
			border-radius: 20px;
			padding: 40px 30px;
			text-align: center;
			transition: all 0.3s ease;
			border: 1px solid #eee;
			height: 100%;
		}

		.feature-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
			border-color: var(--primary-color);
		}

		.feature-icon {
			width: 80px;
			height: 80px;
			background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
			border-radius: 20px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 25px;
			font-size: 32px;
			color: var(--white);
		}

		.feature-card h3 {
			font-size: 22px;
			font-weight: 600;
			margin-bottom: 15px;
			color: var(--secondary-color);
		}

		.feature-card p {
			color: var(--text-light);
			line-height: 1.7;
			margin: 0;
		}

		/* About Section */
		.about-section {
			padding: 100px 0;
			background: linear-gradient(135deg, #F8F9FA 0%, #E8F5E9 100%);
		}

		.about-image {
			position: relative;
		}

		.about-image img {
			width: 100%;
			border-radius: 20px;
			box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
		}

		.about-image::before {
			content: '';
			position: absolute;
			width: 100%;
			height: 100%;
			border: 3px solid var(--primary-color);
			border-radius: 20px;
			top: 20px;
			left: 20px;
			z-index: -1;
		}

		.about-content h2 {
			font-size: 40px;
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 20px;
		}

		.about-content p {
			color: var(--text-light);
			font-size: 16px;
			line-height: 1.8;
			margin-bottom: 30px;
		}

		.about-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.about-list li {
			padding: 10px 0;
			display: flex;
			align-items: center;
			color: var(--text-dark);
		}

		.about-list li i {
			color: var(--primary-color);
			margin-right: 15px;
			font-size: 18px;
		}

		/* Facilities Section */
		.facilities-section {
			padding: 100px 0;
			background: var(--white);
		}

		.facilities-title {
			text-align: center;
			margin-bottom: 60px;
		}

		.facilities-title h2 {
			font-size: 40px;
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 15px;
		}

		.facilities-title p {
			font-size: 18px;
			color: var(--text-light);
			max-width: 600px;
			margin: 0 auto;
		}

		.facility-card {
			background: var(--white);
			border-radius: 20px;
			padding: 30px;
			text-align: center;
			transition: all 0.3s ease;
			border: 1px solid #eee;
			height: 100%;
			position: relative;
			overflow: hidden;
		}

		.facility-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
			border-color: var(--primary-color);
		}

		.facility-image {
			width: 100%;
			height: 200px;
			border-radius: 15px;
			object-fit: cover;
			margin-bottom: 20px;
		}

		.facility-icon {
			width: 60px;
			height: 60px;
			background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
			border-radius: 15px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 15px;
			font-size: 24px;
			color: var(--white);
		}

		.facility-card h3 {
			font-size: 20px;
			font-weight: 600;
			margin-bottom: 10px;
			color: var(--secondary-color);
		}

		.facility-card p {
			color: var(--text-light);
			line-height: 1.6;
			margin: 0;
		}

		/* Stats Section */
		.stats-section {
			padding: 80px 0;
			background: var(--secondary-color);
		}

		.stat-item {
			text-align: center;
			color: var(--white);
		}

		.stat-number {
			font-size: 48px;
			font-weight: 700;
			color: var(--primary-color);
			margin-bottom: 10px;
		}

		.stat-label {
			font-size: 16px;
			opacity: 0.8;
		}

		/* CTA Section */
		.cta-section {
			padding: 100px 0;
			background: var(--white);
			text-align: center;
		}

		.cta-box {
			background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
			border-radius: 30px;
			padding: 60px;
			color: var(--white);
			position: relative;
			overflow: hidden;
		}

		.cta-box::before {
			content: '';
			position: absolute;
			width: 300px;
			height: 300px;
			background: rgba(255, 255, 255, 0.1);
			border-radius: 50%;
			top: -100px;
			right: -100px;
		}

		.cta-box h2 {
			font-size: 36px;
			font-weight: 700;
			margin-bottom: 20px;
		}

		.cta-box p {
			font-size: 18px;
			opacity: 0.9;
			margin-bottom: 30px;
		}

		.btn-white {
			background: var(--white);
			color: var(--primary-color);
			border: none;
			padding: 15px 40px;
			border-radius: 50px;
			font-size: 18px;
			font-weight: 600;
			transition: all 0.3s ease;
		}

		.btn-white:hover {
			transform: translateY(-3px);
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
			background: var(--white);
			color: var(--primary-dark);
		}

		/* Footer */
		.footer-section {
			background: var(--secondary-color);
			padding: 60px 0 30px;
			color: var(--white);
		}

		.footer-brand {
			font-size: 28px;
			font-weight: 700;
			color: var(--primary-color);
			margin-bottom: 20px;
			display: block;
		}

		.footer-brand span {
			color: var(--white);
		}

		.footer-about p {
			color: rgba(255, 255, 255, 0.7);
			line-height: 1.8;
		}

		.footer-title {
			font-size: 18px;
			font-weight: 600;
			margin-bottom: 25px;
			color: var(--white);
		}

		.footer-links {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.footer-links li {
			margin-bottom: 12px;
		}

		.footer-links a {
			color: rgba(255, 255, 255, 0.7);
			text-decoration: none;
			transition: color 0.3s ease;
		}

		.footer-links a:hover {
			color: var(--primary-color);
		}

		.social-links {
			display: flex;
			gap: 15px;
			margin-top: 20px;
		}

		.social-links a {
			width: 45px;
			height: 45px;
			background: rgba(255, 255, 255, 0.1);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--white);
			transition: all 0.3s ease;
		}

		.social-links a:hover {
			background: var(--primary-color);
			transform: translateY(-3px);
		}

		.footer-bottom {
			border-top: 1px solid rgba(255, 255, 255, 0.1);
			padding-top: 30px;
			margin-top: 40px;
			text-align: center;
			color: rgba(255, 255, 255, 0.6);
		}

		/* Responsive */
		@media (max-width: 991px) {
			.hero-title {
				font-size: 40px;
			}

			.hero-section {
				padding-top: 100px;
				padding-bottom: 50px;
			}

			.hero-image {
				margin-top: 50px;
			}
		}

		@media (max-width: 768px) {
			.hero-title {
				font-size: 32px;
			}

			.section-title h2 {
				font-size: 28px;
			}

			.cta-box {
				padding: 40px 20px;
			}

			.cta-box h2 {
				font-size: 28px;
			}
		}
	</style>
</head>

<body>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg fixed-top landing-navbar" id="navbar">
		<div class="container">
			<a class="navbar-brand" href="#"><?php echo $settings->nama_lksa ?? 'Simpintar'; ?></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto align-items-center">
					<li class="nav-item">
						<a class="nav-link" href="#home">Beranda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#fitur">Fitur</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#tentang">Tentang</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#fasilitas">Fasilitas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#kontak">Kontak</a>
					</li>
					<li class="nav-item ms-lg-3">
						<a href="<?php echo base_url('auth/login'); ?>" class="btn btn-primary-custom">Masuk</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero Section -->
	<section class="hero-section" id="home">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="hero-content" data-aos="fade-right">
						<span class="hero-badge">
							<i class="fas fa-heart me-2"></i> Lembaga Kesejahteraan Sosial Anak
						</span>
						<h1 class="hero-title">
							Sistem Informasi <span><?php echo $settings->nama_lksa ?? 'LKSA'; ?></span>
						</h1>
						<p class="hero-subtitle">
							Platform digital terintegrasi untuk mengelola data anak, pengurus, dan program kesejahteraan
							sosial anak.
							Wujudkan masa depan yang lebih baik untuk anak-anak Indonesia.
						</p>
						<div class="hero-buttons">
							<a href="<?php echo base_url('auth/login'); ?>" class="btn btn-primary-custom">
								<i class="fas fa-sign-in-alt me-2"></i> Masuk Sistem
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="hero-image" data-aos="fade-left">
						<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
							<div class="carousel-inner">
								<?php
								$is_first = true;
								if (!empty($carousel_images)):
									foreach ($carousel_images as $image):
										?>
										<div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
											<img src="<?php echo base_url('assets/uploads/landing/' . $image->image_name); ?>"
												class="d-block w-100"
												alt="<?php echo htmlspecialchars($image->title ?? 'Carousel Image'); ?>"
												style="border-radius: 20px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);">
										</div>
										<?php
										$is_first = false;
									endforeach;
								else:
									?>
									<div class="carousel-item active">
										<img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?w=600&h=400&fit=crop"
											class="d-block w-100" alt="Anak-anak belajar bersama"
											style="border-radius: 20px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);">
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</section>

	<!-- Features Section -->
	<section class="features-section" id="fitur">
		<div class="container">
			<div class="section-title" data-aos="fade-up">
				<h2>Fitur Unggulan</h2>
				<p>Sistem informasi lengkap untuk mengelola program kesejahteraan sosial anak dengan efisien dan
					terorganisir</p>
			</div>
			<div class="row g-4">
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-child"></i>
						</div>
						<h3>Data Anak</h3>
						<p>Kelola data lengkap anak asuh, riwayat pendidikan, status tinggal, dan perkembangan dengan
							sistem
							terintegrasi.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-users"></i>
						</div>
						<h3>Data Pengurus</h3>
						<p>Kelola informasi pengurus, relawan, dan staf dengan fitur manajemen yang komprehensif.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-file-alt"></i>
						</div>
						<h3>Manajemen Dokumen</h3>
						<p>Upload dan kelola dokumen anak (KK, Akta, KTP) serta dokumen pengurus dengan sistem yang
							aman.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-chart-bar"></i>
						</div>
						<h3>Laporan & Statistik</h3>
						<p>Generate laporan data anak, pengurus, dokumen, dan statistik dengan export PDF/Excel
							otomatis.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-eye"></i>
						</div>
						<h3>Monitoring & Tracking</h3>
						<p>Monitor status anak aktif/nonaktif, tracking pendidikan, dan evaluasi program kesejahteraan.
						</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-shield-alt"></i>
						</div>
						<h3>Backup & Keamanan</h3>
						<p>Data anak dan program dilindungi dengan backup database otomatis dan sistem keamanan
							terintegrasi.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- About Section -->
	<section class="about-section" id="tentang">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6" data-aos="fade-right">
					<div class="about-image">
						<img src="<?php echo !empty($settings->about_image) ? base_url('assets/uploads/landing/' . $settings->about_image) : 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&h=400&fit=crop'; ?>"
							alt="Pusat kesejahteraan anak">
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					<div class="about-content">
						<h2>Tentang <?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?></h2>
						<p>
							<?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?> adalah lembaga kesejahteraan
							sosial anak yang berkomitmen untuk memberikan perlindungan,
							pengasuhan, dan pendidikan bagi anak-anak yang membutuhkan. Kami percaya bahwa setiap anak
							berhak atas masa depan yang lebih baik.
						</p>
						<p>
							Dengan dukungan teknologi informasi modern, kami mengelola program-program kesejahteraan
							anak secara terintegrasi
							dan transparan untuk memastikan setiap anak mendapatkan perhatian dan bantuan yang tepat.
						</p>
						<ul class="about-list">
							<li><i class="fas fa-check-circle"></i> Program pengasuhan anak terintegrasi</li>
							<li><i class="fas fa-check-circle"></i> Monitoring perkembangan anak secara berkala</li>
							<li><i class="fas fa-check-circle"></i> Kolaborasi dengan pemerintah dan masyarakat</li>
							<li><i class="fas fa-check-circle"></i> Komitmen untuk kesejahteraan anak Indonesia</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Facilities Section -->
	<section class="facilities-section" id="fasilitas">
		<div class="container">
			<div class="facilities-title" data-aos="fade-up">
				<h2>Fasilitas <?php echo $settings->nama_lksa ?? 'LKSA'; ?></h2>
				<p>Fasilitas lengkap dan nyaman untuk mendukung perkembangan dan kesejahteraan anak-anak</p>
			</div>
			<div class="row g-4">
				<?php
				$delay = 100;
				if (!empty($facilities)):
					foreach ($facilities as $facility):
						?>
						<div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
							<div class="facility-card">
								<?php if (!empty($facility->gambar)): ?>
									<img src="<?php echo base_url('assets/uploads/facilities/' . $facility->gambar); ?>"
										alt="<?php echo htmlspecialchars($facility->nama_fasilitas); ?>" class="facility-image">
								<?php else: ?>
									<img src="https://source.unsplash.com/random/600x400/?<?php echo urlencode(strtolower($facility->nama_fasilitas)); ?>"
										alt="<?php echo htmlspecialchars($facility->nama_fasilitas); ?>" class="facility-image">
								<?php endif; ?>
								<div class="facility-icon">
									<i class="fas <?php echo !empty($facility->icon) ? $facility->icon : 'fa-star'; ?>"></i>
								</div>
								<h3><?php echo htmlspecialchars($facility->nama_fasilitas); ?></h3>
								<p><?php echo htmlspecialchars($facility->deskripsi); ?></p>
							</div>
						</div>
						<?php
						$delay += 100;
					endforeach;
				else:
					// Fallback to default facilities if no data
					$default_facilities = [
						['name' => 'Asrama', 'desc' => 'Tempat tinggal yang nyaman dan aman untuk anak-anak dengan fasilitas lengkap.', 'icon' => 'fa-home', 'img' => 'dormitory'],
						['name' => 'Ruang Belajar', 'desc' => 'Fasilitas belajar modern dengan peralatan lengkap untuk mendukung pendidikan anak.', 'icon' => 'fa-book', 'img' => 'classroom'],
						['name' => 'Kantin', 'desc' => 'Area makan yang bersih dan sehat dengan menu bergizi untuk kebutuhan nutrisi anak.', 'icon' => 'fa-utensils', 'img' => 'cafeteria'],
						['name' => 'Lapangan Olahraga', 'desc' => 'Fasilitas olahraga lengkap untuk mengembangkan kesehatan fisik dan mental anak.', 'icon' => 'fa-futbol', 'img' => 'sports'],
						['name' => 'Klinik Kesehatan', 'desc' => 'Pelayanan kesehatan 24 jam dengan tenaga medis profesional untuk kesehatan anak.', 'icon' => 'fa-heartbeat', 'img' => 'clinic'],
						['name' => 'Perpustakaan', 'desc' => 'Koleksi buku dan bahan bacaan lengkap untuk meningkatkan pengetahuan dan kreativitas.', 'icon' => 'fa-book-open', 'img' => 'library'],
						['name' => 'Ruang Ibadah', 'desc' => 'Tempat ibadah yang tenang dan nyaman untuk membentuk karakter spiritual anak.', 'icon' => 'fa-mosque', 'img' => 'mosque'],
						['name' => 'Taman Bermain', 'desc' => 'Area bermain yang aman dan menyenangkan untuk mengembangkan kreativitas dan sosialisasi.', 'icon' => 'fa-child', 'img' => 'playground']
					];
					foreach ($default_facilities as $facility):
						?>
						<div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
							<div class="facility-card">
								<img src="https://source.unsplash.com/random/600x400/?<?php echo $facility['img']; ?>"
									alt="<?php echo $facility['name']; ?>" class="facility-image">
								<div class="facility-icon">
									<i class="fas <?php echo $facility['icon']; ?>"></i>
								</div>
								<h3><?php echo $facility['name']; ?></h3>
								<p><?php echo $facility['desc']; ?></p>
							</div>
						</div>
						<?php
						$delay += 100;
					endforeach;
				endif;
				?>
			</div>
		</div>
	</section>

	<!-- Stats Section -->
	<section class="stats-section">
		<div class="container">
			<div class="row">
				<div class="col-6 col-md-3" data-aos="fade-up">
					<div class="stat-item">
						<div class="stat-number"><?php echo $stats['total_anak']; ?></div>
						<div class="stat-label">Anak Asuh</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
					<div class="stat-item">
						<div class="stat-number"><?php echo $stats['total_pengurus']; ?></div>
						<div class="stat-label">Pengurus Aktif</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
					<div class="stat-item">
						<div class="stat-number"><?php echo $stats['tahun_pengabdian']; ?></div>
						<div class="stat-label">Tahun Pengabdian</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
					<div class="stat-item">
						<div class="stat-number"><?php echo $stats['anak_aktif']; ?></div>
						<div class="stat-label">Anak Aktif</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Detailed Stats Section -->
	<section class="detailed-stats-section" style="padding: 80px 0; background: var(--bg-light);">
		<div class="container">
			<div class="section-title" data-aos="fade-up">
				<h2>Data Statistik Anak</h2>
				<p>Informasi detail tentang profil anak-anak dalam program kesejahteraan</p>
			</div>
			<div class="row g-4">
				<!-- Gender Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #3498DB, #2980B9); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-venus-mars"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Jenis Kelamin</h3>
						<div class="gender-stats">
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">Laki-laki</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['anak_laki']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['anak_laki'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, #3498DB, #2980B9); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div>
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">Perempuan</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['anak_perempuan']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['anak_perempuan'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, #E74C3C, #C0392B); border-radius: 3px;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Education Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #9B59B6, #8E44AD); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-graduation-cap"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Tingkat Pendidikan</h3>
						<div class="education-stats">
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">SD/MI</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['pendidikan_sd']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['pendidikan_sd'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">SMP/MTs</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['pendidikan_smp']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['pendidikan_smp'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">SMA/SMK/MA</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['pendidikan_sma']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['pendidikan_sma'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div>
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">PT/Universitas</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['pendidikan_pt']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['pendidikan_pt'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Age Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #E67E22, #D35400); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-birthday-cake"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Kelompok Usia</h3>
						<div class="age-stats">
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">Dibawah 5 Tahun</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['usia_dibawah5']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['usia_dibawah5'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">5 - 12 Tahun</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['usia_5_12']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['usia_5_12'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div style="margin-bottom: 15px;">
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">13 - 17 Tahun</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['usia_13_17']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['usia_13_17'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
							<div>
								<div
									style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
									<span style="font-size: 14px; color: var(--text-light);">Diatas 17 Tahun</span>
									<span
										style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $stats['usia_diatas17']; ?></span>
								</div>
								<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
									<div
										style="width: <?php echo $stats['total_anak'] > 0 ? ($stats['usia_diatas17'] / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Kategori Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #27AE60, #2ECC71); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-users-cog"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Kategori Anak</h3>
						<div class="kategori-stats">
							<?php
							$categories = array(
								'Yatim' => $stats['kategori_yatim'] ?? 0,
								'Piatu' => $stats['kategori_piatu'] ?? 0,
								'Yatim Piatu' => $stats['kategori_yatim_piatu'] ?? 0,
								'Dhuafa' => $stats['kategori_dhuafa'] ?? 0,
								'Fakir Miskin' => $stats['kategori_fakir_miskin'] ?? 0,
								'Ibnu Sabil' => $stats['kategori_ibnu_sabil'] ?? 0,
								'Laqith' => $stats['kategori_laqith'] ?? 0
							);

							$displayed_count = 0;
							foreach ($categories as $name => $count):
								if ($count > 0):
									$displayed_count++;
									?>
									<div style="margin-bottom: 15px;">
										<div
											style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
											<span style="font-size: 14px; color: var(--text-light);"><?php echo $name; ?></span>
											<span
												style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $count; ?></span>
										</div>
										<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
											<div
												style="width: <?php echo $stats['total_anak'] > 0 ? ($count / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
											</div>
										</div>
									</div>
									<?php
								endif;
							endforeach;

							if ($displayed_count == 0):
								?>
								<div
									style="color: var(--text-light); font-style: italic; text-align: center; padding: 20px;">
									Data kategori belum tersedia
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<!-- Tempat Lahir Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="500">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #F39C12, #E67E22); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Tempat Lahir</h3>
						<div class="tempat-lahir-stats">
							<?php
							$tempat_lahir = $stats['tempat_lahir'] ?? array();
							if (!empty($tempat_lahir)):
								foreach ($tempat_lahir as $tempat => $count):
									?>
									<div style="margin-bottom: 15px;">
										<div
											style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
											<span
												style="font-size: 14px; color: var(--text-light);"><?php echo htmlspecialchars($tempat); ?></span>
											<span
												style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $count; ?></span>
										</div>
										<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
											<div
												style="width: <?php echo $stats['total_anak'] > 0 ? ($count / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
											</div>
										</div>
									</div>
									<?php
								endforeach;
							else:
								?>
								<div style="color: var(--text-light); font-style: italic;">
									Data tempat lahir belum tersedia
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<!-- Tahun Masuk Stats -->
				<div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
					<div class="stats-card"
						style="background: var(--white); border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
						<div
							style="width: 80px; height: 80px; background: linear-gradient(135deg, #8E44AD, #9B59B6); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 24px;">
							<i class="fas fa-calendar-alt"></i>
						</div>
						<h3
							style="font-size: 24px; font-weight: 700; color: var(--secondary-color); margin-bottom: 20px;">
							Tahun Masuk LKSA</h3>
						<div class="tahun-masuk-stats">
							<?php
							$tahun_masuk = $stats['tahun_masuk'] ?? array();
							if (!empty($tahun_masuk)):
								foreach ($tahun_masuk as $tahun => $count):
									?>
									<div style="margin-bottom: 15px;">
										<div
											style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
											<span
												style="font-size: 14px; color: var(--text-light);"><?php echo $tahun; ?></span>
											<span
												style="font-size: 18px; font-weight: 600; color: var(--primary-color);"><?php echo $count; ?></span>
										</div>
										<div style="width: 100%; height: 6px; background: #eee; border-radius: 3px;">
											<div
												style="width: <?php echo $stats['total_anak'] > 0 ? ($count / $stats['total_anak'] * 100) : 0; ?>%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--primary-light)); border-radius: 3px;">
											</div>
										</div>
									</div>
									<?php
								endforeach;
							else:
								?>
								<div style="color: var(--text-light); font-style: italic;">
									Data tahun masuk belum tersedia
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA Section -->
	<section class="cta-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="cta-box" data-aos="zoom-in">
						<h2>Bergabung Bersama Kami</h2>
						<p>Mari bersama-sama berkontribusi untuk kesejahteraan anak Indonesia. Hubungi kami untuk
							informasi lebih lanjut tentang program kesejahteraan anak.</p>
						<a href="#kontak" class="btn btn-white">
							<i class="fas fa-envelope me-2"></i> Hubungi Kami
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="footer-section" id="kontak">
		<div class="container">
			<div class="row g-4">
				<div class="col-lg-4">
					<div class="footer-about">
						<a href="#" class="footer-brand"><?php echo $settings->nama_lksa ?? 'LKSA'; ?><span></span></a>
						<p>Lembaga kesejahteraan sosial anak yang berkomitmen untuk memberikan perlindungan dan
							pendidikan bagi anak-anak Indonesia.</p>
						<div class="social-links">
							<?php if (!empty($settings->facebook)): ?>
								<a href="<?php echo $settings->facebook; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-facebook-f"></i></a>
							<?php endif; ?>
							<?php if (!empty($settings->twitter)): ?>
								<a href="<?php echo $settings->twitter; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-twitter"></i></a>
							<?php endif; ?>
							<?php if (!empty($settings->instagram)): ?>
								<a href="<?php echo $settings->instagram; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-instagram"></i></a>
							<?php endif; ?>
							<?php if (!empty($settings->youtube)): ?>
								<a href="<?php echo $settings->youtube; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-youtube"></i></a>
							<?php endif; ?>
							<?php if (!empty($settings->linkedin)): ?>
								<a href="<?php echo $settings->linkedin; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-linkedin-in"></i></a>
							<?php endif; ?>
							<?php if (!empty($settings->whatsapp)): ?>
								<?php
								$wa_number = $settings->whatsapp;
								// Jika sudah ada URL, gunakan langsung; jika hanya nomor, gunakan wa.me
								$wa_link = (strpos($wa_number, 'http') === 0) ? $wa_number : 'https://wa.me/' . $wa_number;
								?>
								<a href="<?php echo $wa_link; ?>" target="_blank" rel="noopener noreferrer"><i
										class="fab fa-whatsapp"></i></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Program</h4>
					<ul class="footer-links">
						<li><a href="#fitur">Fitur Utama</a></li>
						<li><a href="#tentang">Tentang LKSA</a></li>
						<li><a href="#kontak">Kontak Kami</a></li>
						<li><a href="<?php echo base_url('auth/login'); ?>">Login Admin</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Data & Laporan</h4>
					<ul class="footer-links">
						<li><a href="#fitur">Data Anak</a></li>
						<li><a href="#fitur">Data Pengurus</a></li>
						<li><a href="#fitur">Laporan Statistik</a></li>
						<li><a href="#fitur">Manajemen Dokumen</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Dukungan</h4>
					<ul class="footer-links">
						<li><a href="#kontak">Kontak Developer</a></li>
						<li><a href="#">Changelog</a></li>
						<li><a href="#">Lisensi</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Kontak</h4>
					<ul class="footer-links">
						<li><a href="#"><i
									class="fas fa-envelope me-2"></i><?php echo $settings->email ?? 'info@simpintar.com'; ?></a>
						</li>
						<li><a href="#"><i
									class="fas fa-phone me-2"></i><?php echo $settings->no_telp ?? '+62 123 4567 890'; ?></a>
						</li>
						<li><a href="#"><i
									class="fas fa-map-marker-alt me-2"></i><?php echo $settings->alamat ?? 'Jakarta, Indonesia'; ?></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="footer-bottom">
				<p>&copy; 2024 SAHABAT - Sistem Anak Hebat Berbasis Administrasi Terpadu. All rights reserved.</p>
			</div>
		</div>
	</footer>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- AOS Animation -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

	<!-- Custom JS -->
	<script src="<?php echo base_url('assets/landing/js/app.js'); ?>"></script>

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
	</script>
</body>

</html>