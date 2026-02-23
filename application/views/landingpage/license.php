<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lisensi - <?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?> - Sistem Informasi Lembaga
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

		/* License Section */
		.license-section {
			padding: 120px 0 100px;
			background: linear-gradient(135deg, #F8F9FA 0%, #E8F5E9 100%);
			min-height: 100vh;
		}

		.license-container {
			max-width: 900px;
			margin: 0 auto;
		}

		.license-header {
			text-align: center;
			margin-bottom: 60px;
		}

		.license-header h1 {
			font-size: 48px;
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 20px;
		}

		.license-header p {
			font-size: 18px;
			color: var(--text-light);
			max-width: 600px;
			margin: 0 auto;
		}

		.license-card {
			background: var(--white);
			border-radius: 20px;
			padding: 50px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			margin-bottom: 40px;
		}

		.license-icon {
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

		.license-card h2 {
			font-size: 32px;
			font-weight: 600;
			color: var(--secondary-color);
			text-align: center;
			margin-bottom: 30px;
		}

		.license-content {
			font-size: 16px;
			line-height: 1.8;
			color: var(--text-dark);
		}

		.license-content p {
			margin-bottom: 25px;
		}

		.highlight-box {
			background: rgba(122, 198, 77, 0.1);
			border-left: 5px solid var(--primary-color);
			padding: 25px;
			border-radius: 0 15px 15px 0;
			margin: 25px 0;
		}

		.highlight-box h3 {
			color: var(--primary-dark);
			margin-bottom: 15px;
			font-size: 20px;
		}

		.warning-box {
			background: rgba(231, 76, 60, 0.1);
			border-left: 5px solid #E74C3C;
			padding: 25px;
			border-radius: 0 15px 15px 0;
			margin: 25px 0;
		}

		.warning-box h3 {
			color: #C0392B;
			margin-bottom: 15px;
			font-size: 20px;
		}

		.license-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.license-list li {
			padding: 12px 0;
			display: flex;
			align-items: flex-start;
			color: var(--text-dark);
		}

		.license-list li i {
			color: var(--primary-color);
			margin-right: 15px;
			font-size: 18px;
			margin-top: 2px;
		}

		.btn-back {
			display: inline-flex;
			align-items: center;
			gap: 10px;
			padding: 15px 30px;
			background: var(--primary-color);
			color: var(--white);
			border-radius: 50px;
			text-decoration: none;
			font-size: 16px;
			font-weight: 600;
			transition: all 0.3s ease;
			margin-top: 30px;
		}

		.btn-back:hover {
			background: var(--primary-dark);
			transform: translateY(-3px);
			box-shadow: 0 8px 25px rgba(122, 198, 77, 0.4);
			color: var(--white);
		}

		/* Responsive */
		@media (max-width: 991px) {
			.license-section {
				padding-top: 100px;
				padding-bottom: 50px;
			}

			.license-header h1 {
				font-size: 36px;
			}

			.license-card {
				padding: 40px 30px;
			}
		}

		@media (max-width: 768px) {
			.license-header h1 {
				font-size: 28px;
			}

			.license-card {
				padding: 30px 20px;
			}

			.license-icon {
				width: 80px;
				height: 80px;
				font-size: 32px;
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

	<!-- License Section -->
	<section class="license-section">
		<div class="container">
			<div class="license-container">
				<div class="license-header" data-aos="fade-up">
					<h1>Lisensi Penggunaan</h1>
					<p>Informasi lisensi dan kebijakan penggunaan aplikasi
						<?php echo $settings->nama_lksa ?? 'SAHABAT'; ?>
					</p>
				</div>

				<div class="license-card" data-aos="fade-up" data-aos-delay="100">
					<div class="license-icon">
						<i class="fas fa-balance-scale"></i>
					</div>
					<h2>Lisensi Gratis</h2>
					<div class="license-content">
						<div class="highlight-box">
							<h3><i class="fas fa-check-circle me-2"></i>Aplikasi Ini Gratis</h3>
							<p>Aplikasi SAHABAT dapat digunakan secara gratis oleh semua pengguna tanpa biaya lisensi
								atau
								biaya penggunaan.</p>
						</div>

						<p>Aplikasi ini dikembangkan untuk membantu lembaga kesejahteraan sosial anak dalam mengelola
							data dan program-program kesejahteraan anak secara lebih efektif dan efisien.</p>

						<div class="highlight-box">
							<h3><i class="fas fa-heart me-2"></i>Tidak Wajib Donasi</h3>
							<p>Penggunaan aplikasi ini tidak mewajibkan donasi atau kontribusi finansial. Aplikasi
								disediakan secara gratis untuk mendukung misi kesejahteraan anak di Indonesia.</p>
						</div>

						<p>Meskipun donasi tidak diwajibkan, dukungan dari komunitas pengguna sangat dihargai dan akan
							membantu pengembangan fitur-fitur baru serta pemeliharaan aplikasi.</p>

						<div
							style="background: rgba(122, 198, 77, 0.1); border: 2px solid var(--primary-color); border-radius: 15px; padding: 25px; margin: 25px 0; text-align: center;">
							<i class="fas fa-heart"
								style="font-size: 24px; color: var(--primary-color); margin-bottom: 15px;"></i>
							<h4 style="color: var(--secondary-color); margin-bottom: 15px; font-size: 18px;">Ingin
								Berkontribusi?</h4>
							<p style="margin-bottom: 20px; color: var(--text-dark);">Jika Anda ingin mendukung
								pengembangan aplikasi ini, kunjungi halaman donasi kami untuk informasi lengkap tentang
								cara berkontribusi.</p>
							<a href="<?php echo base_url('donasi'); ?>"
								style="display: inline-flex; align-items: center; gap: 10px; background: var(--primary-color); color: var(--white); padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(122, 198, 77, 0.3);">
								<i class="fas fa-hand-holding-heart"></i>
								Kunjungi Halaman Donasi
							</a>
						</div>

						<div
							style="background: rgba(122, 198, 77, 0.1); border: 2px solid var(--primary-color); border-radius: 15px; padding: 25px; margin: 25px 0; text-align: center;">
							<i class="fab fa-github"
								style="font-size: 24px; color: var(--primary-color); margin-bottom: 15px;"></i>
							<h4 style="color: var(--secondary-color); margin-bottom: 15px; font-size: 18px;">Ingin
								Berkontribusi Kode?</h4>
							<p style="margin-bottom: 20px; color: var(--text-dark);">Jika Anda ingin membantu
								pengembangan melalui pull request atau kontribusi kode, kunjungi repository GitHub kami.
							</p>
							<a href="https://github.com/smohheri/sahabat" target="_blank"
								style="display: inline-flex; align-items: center; gap: 10px; background: var(--primary-color); color: var(--white); padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(122, 198, 77, 0.3);">
								<i class="fab fa-github"></i>
								Repository GitHub
							</a>
							<p style="margin-top: 15px; font-size: 14px; color: var(--text-light);"><em>Semua kontribusi
									akan ditinjau dan didiskusikan sebelum diintegrasikan</em></p>
						</div>

						<div class="warning-box">
							<h3><i class="fas fa-exclamation-triangle me-2"></i>Pembatasan Modifikasi</h3>
							<p>Modifikasi terhadap aplikasi ini hanya boleh dilakukan dengan sepengetahuan dan
								persetujuan dari developer. Setiap perubahan kode, fitur, atau struktur aplikasi harus
								dikonsultasikan terlebih dahulu untuk menjaga integritas dan keamanan sistem.</p>
						</div>

						<h3>Persyaratan Penggunaan:</h3>
						<ul class="license-list">
							<li><i class="fas fa-check-circle"></i>Aplikasi digunakan untuk tujuan kesejahteraan sosial
								anak yang positif</li>
							<li><i class="fas fa-check-circle"></i>Data anak yang dikelola harus dijaga kerahasiaannya
							</li>
							<li><i class="fas fa-check-circle"></i>Pengguna bertanggung jawab atas keamanan data yang
								diinput</li>
							<li><i class="fas fa-check-circle"></i>Laporan yang dihasilkan digunakan secara bertanggung
								jawab</li>
							<li><i class="fas fa-check-circle"></i>Modifikasi aplikasi hanya dengan persetujuan
								developer</li>
							<li><i class="fas fa-check-circle"></i>Menjaga integritas dan keamanan sistem aplikasi</li>
						</ul>

						<p>Dengan menggunakan aplikasi ini, Anda menyetujui persyaratan penggunaan di atas dan
							berkomitmen untuk menggunakan aplikasi ini sesuai dengan tujuan kesejahteraan sosial anak.
						</p>

						<hr style="margin: 30px 0; border-color: #eee;">

						<h3>Lisensi Teknis</h3>
						<p>Aplikasi ini dibangun menggunakan framework CodeIgniter yang menggunakan lisensi MIT. Untuk
							informasi lengkap tentang lisensi teknis, silakan lihat file <code>license.txt</code> di
							root direktori aplikasi.</p>

						<div
							style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px; border: 1px solid #dee2e6;">
							<h4 style="margin-bottom: 15px; color: #2C3E50;">The MIT License (MIT)</h4>
							<p style="font-size: 14px; line-height: 1.6; color: #666; margin-bottom: 10px;">
								Copyright (c) 2019 - 2022, CodeIgniter Foundation
							</p>
							<p style="font-size: 14px; line-height: 1.6; color: #666;">
								Permission is hereby granted, free of charge, to any person obtaining a copy of this
								software and associated documentation files (the "Software"), to deal in the Software
								without restriction...
							</p>
							<p style="font-size: 14px; margin-top: 10px;">
								<a href="<?php echo base_url('license.txt'); ?>" target="_blank"
									style="color: #7AC64D; text-decoration: none;">
									<i class="fas fa-external-link-alt me-1"></i>Baca Lisensi Lengkap
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="text-center" data-aos="fade-up" data-aos-delay="200">
					<a href="<?php echo base_url(); ?>" class="btn-back">
						<i class="fas fa-arrow-left"></i>
						Kembali ke Beranda
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
	</script>
</body>

</html>
