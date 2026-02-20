<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Simpintar - Sistem Informasi Management Cerdas</title>
	
	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	
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
		
		body {
			overflow-x: hidden;
		}
		
		/* Navbar Styles */
		.landing-navbar {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
			box-shadow: 0 2px 20px rgba(0,0,0,0.08);
			padding: 15px 0;
			transition: all 0.3s ease;
		}
		
		.landing-navbar.scrolled {
			padding: 10px 0;
			box-shadow: 0 2px 30px rgba(0,0,0,0.12);
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
			min-height: 100vh;
			background: linear-gradient(135deg, #F8F9FA 0%, #E8F5E9 100%);
			position: relative;
			overflow: hidden;
			display: flex;
			align-items: center;
		}
		
		.hero-section::before {
			content: '';
			position: absolute;
			width: 600px;
			height: 600px;
			background: radial-gradient(circle, rgba(122, 198, 77, 0.15) 0%, transparent 70%);
			top: -200px;
			right: -200px;
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
			0%, 100% { transform: translate(0, 0); }
			50% { transform: translate(30px, 30px); }
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
			box-shadow: 0 30px 60px rgba(0,0,0,0.15);
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
			box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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
			box-shadow: 0 30px 60px rgba(0,0,0,0.15);
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
			background: rgba(255,255,255,0.1);
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
			box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
			color: rgba(255,255,255,0.7);
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
			color: rgba(255,255,255,0.7);
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
			background: rgba(255,255,255,0.1);
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
			border-top: 1px solid rgba(255,255,255,0.1);
			padding-top: 30px;
			margin-top: 40px;
			text-align: center;
			color: rgba(255,255,255,0.6);
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
			<a class="navbar-brand" href="#">Simp<span>intar</span></a>
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
						<a class="nav-link" href="#kontak">Kontak</a>
					</li>
					<li class="nav-item ms-lg-3">
						<a href="<?php echo base_url('auth/login'); ?>" class="btn btn-outline-custom">Masuk</a>
					</li>
					<li class="nav-item ms-2">
						<a href="<?php echo base_url('auth/register'); ?>" class="btn btn-primary-custom">Daftar</a>
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
							<i class="fas fa-rocket me-2"></i> Solusi Digital Terbaik
						</span>
						<h1 class="hero-title">
							Kelola Bisnis Anda dengan <span>Simpintar</span>
						</h1>
						<p class="hero-subtitle">
							Platform sistem informasi management yang cerdas dan terintegrasi untuk membantu bisnis Anda berkembang lebih cepat. Mulai digitalisasi hari ini!
						</p>
						<div class="hero-buttons">
							<a href="<?php echo base_url('auth/register'); ?>" class="btn btn-primary-custom">
								<i class="fas fa-user-plus me-2"></i> Mulai Gratis
							</a>
							<a href="#fitur" class="btn btn-outline-custom">
								<i class="fas fa-play me-2"></i> Pelajari Lebih Lanjut
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="hero-image" data-aos="fade-left">
						<img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="Dashboard Preview">
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
				<p>Dapatkan berbagai fitur powerful yang membantu Anda mengelola bisnis dengan lebih mudah dan efisien</p>
			</div>
			<div class="row g-4">
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-chart-line"></i>
						</div>
						<h3>Analisis Bisnis</h3>
						<p>Dapatkan insight mendalam tentang performa bisnis Anda dengan dashboard analitik yang komprehensif dan real-time.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-users"></i>
						</div>
						<h3>Kelola Karyawan</h3>
						<p>Kelola data karyawan, absensi, dan kinerja dengan sistem yang terintegrasi dan mudah digunakan.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-boxes"></i>
						</div>
						<h3>Manajemen Inventori</h3>
						<p>Kontrol stok barang Anda dengan fitur inventori cerdas yang membantu mencegah kekosongan barang.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-file-invoice-dollar"></i>
						</div>
						<h3>Keuangan Terintegrasi</h3>
						<p>Kelola keuangan bisnis mulai dari pendapatan, pengeluaran, hingga laporan keuangan secara otomatis.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-mobile-alt"></i>
						</div>
						<h3>Akses Mobile</h24>
						<p>Akses data bisnis Anda kapan saja dan dari mana saja melalui aplikasi mobile yang responsif.</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
					<div class="feature-card">
						<div class="feature-icon">
							<i class="fas fa-shield-alt"></i>
						</div>
						<h3>Keamanan Data</h3>
						<p>Data bisnis Anda aman dengan sistem enkripsi tingkat tinggi dan backup otomatis.</p>
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
						<img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=600&h=400&fit=crop" alt="About Simpintar">
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					<div class="about-content">
						<h2>Tentang Simpintar</h2>
						<p>
							Simpintar adalah platform sistem informasi management berbasis cloud yang dirancang untuk membantu bisnis kecil dan menengah dalam mengelola operasional mereka secara digital. Kami percaya bahwa teknologi seharusnya memudahkan, bukan menyulitkan.
						</p>
						<p>
							Dengan pengalaman tim yang solid di bidang teknologi informasi, kami menghadirkan solusi yang user-friendly namun powerful untuk memenuhi kebutuhan bisnis modern Anda.
						</p>
						<ul class="about-list">
							<li><i class="fas fa-check-circle"></i> Lebih dari 500+ bisnis telah menggunakan Simpintar</li>
							<li><i class="fas fa-check-circle"></i> Dukungan teknis 24/7</li>
							<li><i class="fas fa-check-circle"></i> Update fitur gratis seumur hidup</li>
							<li><i class="fas fa-check-circle"></i> Garansi uang kembali 30 hari</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Stats Section -->
	<section class="stats-section">
		<div class="container">
			<div class="row">
				<div class="col-6 col-md-3" data-aos="fade-up">
					<div class="stat-item">
						<div class="stat-number">500+</div>
						<div class="stat-label">Pengguna Aktif</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
					<div class="stat-item">
						<div class="stat-number">10K+</div>
						<div class="stat-label">Transaksi Harian</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
					<div class="stat-item">
						<div class="stat-number">99.9%</div>
						<div class="stat-label">Uptime Server</div>
					</div>
				</div>
				<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
					<div class="stat-item">
						<div class="stat-number">4.9/5</div>
						<div class="stat-label">Rating Pengguna</div>
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
						<h2>Siap Mengubah Bisnis Anda?</h2>
						<p>Mulai sekarang dan nikmati 14 hari free trial. Tidak perlu kartu kredit!</p>
						<a href="<?php echo base_url('auth/register'); ?>" class="btn btn-white">
							<i class="fas fa-rocket me-2"></i> Coba Gratis Sekarang
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
						<a href="#" class="footer-brand">Simp<span>intar</span></a>
						<p>Platform sistem informasi management terbaik untuk bisnis Anda.简单 (Sederhana), Cerdas, dan Terintegrasi.</p>
						<div class="social-links">
							<a href="#"><i class="fab fa-facebook-f"></i></a>
							<a href="#"><i class="fab fa-twitter"></i></a>
							<a href="#"><i class="fab fa-instagram"></i></a>
							<a href="#"><i class="fab fa-linkedin-in"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Produk</h4>
					<ul class="footer-links">
						<li><a href="#">Fitur</a></li>
						<li><a href="#">Harga</a></li>
						<li><a href="#">Demo</a></li>
						<li><a href="#">API</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Perusahaan</h4>
					<ul class="footer-links">
						<li><a href="#">Tentang Kami</a></li>
						<li><a href="#">Karir</a></li>
						<li><a href="#">Blog</a></li>
						<li><a href="#">Press</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Dukungan</h4>
					<ul class="footer-links">
						<li><a href="#">Pusat Bantuan</a></li>
						<li><a href="#">Kontak</a></li>
						<li><a href="#">Status</a></li>
						<li><a href="#">Privacy Policy</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-4">
					<h4 class="footer-title">Kontak</h4>
					<ul class="footer-links">
						<li><a href="#"><i class="fas fa-envelope me-2"></i>info@simpintar.com</a></li>
						<li><a href="#"><i class="fas fa-phone me-2"></i>+62 123 4567 890</a></li>
						<li><a href="#"><i class="fas fa-map-marker-alt me-2"></i>Jakarta, Indonesia</a></li>
					</ul>
				</div>
			</div>
			<div class="footer-bottom">
				<p>&copy; 2024 Simpintar. All rights reserved.</p>
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
		window.addEventListener('scroll', function() {
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
