<!-- Halaman Dukung Kami - Redesain Modern -->
<div class="dukung-kami-container">
	<!-- Hero Section -->
	<div class="hero-section">
		<div class="hero-content">
			<div class="hero-icon">
				<i class="fas fa-heart"></i>
			</div>
			<h1 class="hero-title">Dukung Kami</h1>
			<p class="hero-subtitle">Bersama Membangun Masa Depan yang Lebih Baik</p>

			<!-- App Badge - Redesain Lebih Prominent -->
			<div class="app-badge-container">
				<div class="app-badge-box">
					<?php
					$logo_path = 'assets/img/logo_sahabat.png';
					$logo_exists = file_exists($logo_path);
					?>
					<?php if ($logo_exists): ?>
						<img src="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" alt="Logo SAHABAT"
							class="app-logo-img">
					<?php else: ?>
						<div class="app-logo-fallback">SA</div>
					<?php endif; ?>
				</div>
				<div class="app-text">
					<span class="app-name">SAHABAT</span>
					<span class="app-desc">Sistem Anak Hebat Berbasis Administrasi Terpadu</span>
				</div>
			</div>
		</div>

		<!-- Wave Divider -->
		<div class="wave-divider">
			<svg viewBox="0 0 1440 120" preserveAspectRatio="none">
				<path
					d="M0,64L48,80C96,96,192,128,288,128C384,128,480,96,576,80C672,64,768,64,864,80C960,96,1056,128,1152,122.7C1248,117,1344,75,1392,53.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"
					class="wave-fill"></path>
			</svg>
		</div>
	</div>

	<!-- Main Content -->
	<div class="main-content">
		<!-- About Section -->
		<div class="about-card">
			<div class="about-header">
				<i class="fas fa-info-circle"></i>
				<h2>Tentang Halaman Ini</h2>
			</div>
			<div class="about-body">
				<p>
					Halaman <strong>Dukung Kami</strong> merupakan ruang bagi Anda yang ingin berpartisipasi dalam
					pengembangan aplikasi dan mendukung layanan bagi anak-anak melalui kontribusi sukarela.
					Setiap dukungan yang diberikan akan membantu:
				</p>
				<ul class="benefit-list">
					<li><i class="fas fa-check-circle"></i> Peningkatan fitur sistem</li>
					<li><i class="fas fa-check-circle"></i> Pemeliharaan server dan database</li>
					<li><i class="fas fa-check-circle"></i> Keberlanjutan layanan</li>
					<li><i class="fas fa-check-circle"></i> Pengembangan fitur baru</li>
				</ul>
				<p class="note">
					<i class="fas fa-lightbulb"></i>
					Donasi bersifat <strong>opsional</strong> tanpa kewajiban apa pun.
					Setiap kontribusi, sekecil apa pun, memiliki arti besar bagi keberlanjutan layanan ini.
				</p>
			</div>
		</div>

		<!-- Donation Section -->
		<div class="donation-section">
			<div class="section-header">
				<i class="fas fa-hand-holding-heart"></i>
				<h2>Rekening Donasi</h2>
				<p>Pilih salah satu rekening untuk menyalurkan donasi Anda</p>
			</div>

			<div class="bank-cards">
				<!-- Bank BSI Card -->
				<div class="bank-card bank-bsi">
					<div class="card-glow"></div>
					<div class="card-content">
						<div class="bank-header">
							<div class="bank-logo">
								<i class="fas fa-university"></i>
								<span>Bank BSI</span>
							</div>
							<span class="bank-badge">Utama</span>
						</div>
						<div class="card-body">
							<div class="account-label">Nomor Rekening</div>
							<div class="account-number">
								<span>7252957170</span>
								<button class="copy-btn" onclick="copyToClipboard('7252957170')" title="Salin">
									<i class="fas fa-copy"></i>
								</button>
							</div>
							<div class="account-name">
								<i class="fas fa-user"></i> a.n. Moh. Heri Setiawan
							</div>
						</div>
						<div class="card-footer">
							<span class="status-badge"><i class="fas fa-check-circle"></i> Aktif</span>
						</div>
					</div>
				</div>

				<!-- Bank BRI Card -->
				<div class="bank-card bank-bri">
					<div class="card-glow"></div>
					<div class="card-content">
						<div class="bank-header">
							<div class="bank-logo">
								<i class="fas fa-university"></i>
								<span>Bank BRI</span>
							</div>
							<span class="bank-badge alt">Alternatif</span>
						</div>
						<div class="card-body">
							<div class="account-label">Nomor Rekening</div>
							<div class="account-number">
								<span>057201014816537</span>
								<button class="copy-btn" onclick="copyToClipboard('057201014816537')" title="Salin">
									<i class="fas fa-copy"></i>
								</button>
							</div>
							<div class="account-name">
								<i class="fas fa-user"></i> a.n. Moh. Heri Setiawan
							</div>
						</div>
						<div class="card-footer">
							<span class="status-badge"><i class="fas fa-check-circle"></i> Aktif</span>
						</div>
					</div>
				</div>
			</div>

			<!-- QR Code Section -->
			<div class="qr-section">
				<div class="qr-card">
					<img src="<?php echo base_url('assets/img/QRIS.png'); ?>" alt="QR Code"
						style="max-width: 280px; height: auto;">
					<p>Scan QR Code</p>
					<span>QRIS</span>
				</div>
			</div>
		</div>

		<!-- Thank You Section -->
		<div class="thank-you-section">
			<div class="thank-you-card">
				<div class="thank-you-icon">
					<i class="fas fa-praying-hands"></i>
				</div>
				<h3>Terima Kasih</h3>
				<p>
					Atas kebaikan dan partisipasi Anda dalam menghadirkan dampak positif bersama.
					Donasi Anda akan berdampak langsung pada pengembangan sistem ini.
				</p>
				<div class="support-text">
					<i class="fas fa-heart text-danger"></i>
					<span>Setiap dukungan berarti bagi kami</span>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	/* Reset & Base */
	.dukung-kami-container {
		font-family: 'Segoe UI', system-ui, sans-serif;
		background: #f8fafc;
		min-height: 100vh;
	}

	/* Hero Section */
	.hero-section {
		background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #3d7ab5 100%);
		padding: 60px 20px 100px;
		text-align: center;
		position: relative;
		overflow: hidden;
	}

	.hero-section::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
	}

	.hero-content {
		position: relative;
		z-index: 1;
		max-width: 600px;
		margin: 0 auto;
	}

	.hero-icon {
		width: 100px;
		height: 100px;
		background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 25px;
		box-shadow: 0 15px 40px rgba(238, 90, 36, 0.4);
		animation: pulse 2s ease-in-out infinite;
	}

	@keyframes pulse {

		0%,
		100% {
			transform: scale(1);
		}

		50% {
			transform: scale(1.05);
		}
	}

	.hero-icon i {
		font-size: 45px;
		color: #fff;
	}

	.hero-title {
		font-size: 48px;
		font-weight: 800;
		color: #fff;
		margin: 0 0 10px;
		text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
	}

	.hero-subtitle {
		font-size: 20px;
		color: rgba(255, 255, 255, 0.9);
		margin: 0 0 30px;
	}

	/* App Badge Container - Redesain Lebih Prominent */
	.app-badge-container {
		display: inline-flex;
		align-items: center;
		gap: 16px;
		background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
		padding: 16px 28px;
		border-radius: 16px;
		backdrop-filter: blur(15px);
		border: 2px solid rgba(255, 255, 255, 0.3);
		box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
	}

	.app-badge-box {
		width: 64px;
		height: 64px;
		background: linear-gradient(135deg, #7AC64D 0%, #5fa33a 100%);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 4px 15px rgba(122, 198, 77, 0.4);
	}

	.app-logo-img {
		width: 48px;
		height: 48px;
		object-fit: contain;
		border-radius: 8px;
	}

	.app-logo-fallback {
		font-size: 24px;
		font-weight: 800;
		color: #fff;
		text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
	}

	.app-text {
		display: flex;
		flex-direction: column;
		text-align: left;
	}

	.app-name {
		font-size: 26px;
		font-weight: 800;
		color: #fff;
		text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
		letter-spacing: 1px;
	}

	.app-desc {
		font-size: 12px;
		color: rgba(255, 255, 255, 0.9);
		font-weight: 500;
	}

	/* Wave Divider */
	.wave-divider {
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 80px;
		overflow: hidden;
	}

	.wave-divider svg {
		width: 100%;
		height: 100%;
	}

	.wave-fill {
		fill: #f8fafc;
	}

	/* Main Content */
	.main-content {
		max-width: 100%;
		margin: -40px 20px 0;
		padding: 0 20px 40px;
		position: relative;
		z-index: 2;
	}

	/* About Card */
	.about-card {
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
		overflow: hidden;
		margin-bottom: 30px;
	}

	.about-header {
		background: linear-gradient(135deg, #4e73df 0%, #6f42c1 100%);
		padding: 20px 30px;
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.about-header i {
		font-size: 24px;
		color: #fff;
	}

	.about-header h2 {
		margin: 0;
		font-size: 20px;
		font-weight: 600;
		color: #fff;
	}

	.about-body {
		padding: 30px;
	}

	.about-body p {
		color: #4a5568;
		line-height: 1.8;
		margin-bottom: 20px;
	}

	.benefit-list {
		list-style: none;
		padding: 0;
		margin: 0 0 25px;
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 12px;
	}

	.benefit-list li {
		display: flex;
		align-items: center;
		gap: 10px;
		color: #2d3748;
		font-size: 14px;
	}

	.benefit-list li i {
		color: #1cc88a;
		font-size: 16px;
	}

	.note {
		background: #fef3c7;
		border-left: 4px solid #f59e0b;
		padding: 15px 20px;
		border-radius: 0 8px 8px 0;
		font-size: 14px;
	}

	.note i {
		color: #f59e0b;
		margin-right: 8px;
	}

	/* Donation Section */
	.donation-section {
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
		padding: 30px;
		margin-bottom: 30px;
	}

	.section-header {
		text-align: center;
		margin-bottom: 30px;
	}

	.section-header i {
		font-size: 40px;
		color: #e74a3b;
		margin-bottom: 10px;
	}

	.section-header h2 {
		font-size: 28px;
		font-weight: 700;
		color: #2d3748;
		margin: 0 0 8px;
	}

	.section-header p {
		color: #718096;
		margin: 0;
	}

	/* Bank Cards */
	.bank-cards {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.bank-card {
		position: relative;
		border-radius: 20px;
		overflow: hidden;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.bank-card:hover {
		transform: translateY(-5px);
		box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
	}

	.card-glow {
		position: absolute;
		top: -50%;
		left: -50%;
		width: 200%;
		height: 200%;
		background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
		animation: glow 3s ease-in-out infinite;
	}

	@keyframes glow {

		0%,
		100% {
			opacity: 0.5;
			transform: scale(1);
		}

		50% {
			opacity: 0.8;
			transform: scale(1.1);
		}
	}

	.bank-bsi {
		background: linear-gradient(135deg, #84cc16 0%, #65a30d 50%, #4d7c0f 100%);
	}

	.bank-bri {
		background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 50%, #1d4ed8 100%);
	}

	.card-content {
		position: relative;
		z-index: 1;
		padding: 25px;
		color: #fff;
	}

	.bank-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
	}

	.bank-logo {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.bank-logo i {
		font-size: 28px;
	}

	.bank-logo span {
		font-size: 18px;
		font-weight: 700;
		letter-spacing: 1px;
	}

	.bank-badge {
		background: rgba(255, 255, 255, 0.2);
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
	}

	.bank-badge.alt {
		background: rgba(255, 255, 255, 0.15);
	}

	.card-body {
		margin-bottom: 15px;
	}

	.account-label {
		font-size: 11px;
		text-transform: uppercase;
		opacity: 0.8;
		margin-bottom: 5px;
		letter-spacing: 1px;
	}

	.account-number {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 10px;
	}

	.account-number span {
		font-size: 24px;
		font-weight: 700;
		letter-spacing: 2px;
		font-family: 'Courier New', monospace;
	}

	.copy-btn {
		background: rgba(255, 255, 255, 0.2);
		border: none;
		width: 36px;
		height: 36px;
		border-radius: 8px;
		color: #fff;
		cursor: pointer;
		transition: all 0.2s;
	}

	.copy-btn:hover {
		background: rgba(255, 255, 255, 0.3);
		transform: scale(1.05);
	}

	.account-name {
		font-size: 14px;
		opacity: 0.9;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.card-footer {
		padding-top: 15px;
		border-top: 1px solid rgba(255, 255, 255, 0.2);
	}

	.status-badge {
		background: rgba(255, 255, 255, 0.2);
		padding: 4px 10px;
		border-radius: 20px;
		font-size: 11px;
		display: inline-flex;
		align-items: center;
		gap: 5px;
	}

	/* QR Section */
	.qr-section {
		text-align: center;
	}

	.qr-card {
		background: #f1f5f9;
		border: 2px dashed #cbd5e1;
		border-radius: 16px;
		padding: 30px;
		display: inline-block;
	}

	.qr-card i {
		font-size: 60px;
		color: #94a3b8;
		margin-bottom: 10px;
	}

	.qr-card p {
		margin: 0;
		font-weight: 600;
		color: #64748b;
	}

	.qr-card span {
		font-size: 12px;
		color: #94a3b8;
	}

	/* Thank You Section */
	.thank-you-section {
		text-align: center;
	}

	.thank-you-card {
		background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
		border-radius: 20px;
		padding: 40px;
		color: #fff;
		box-shadow: 0 10px 40px rgba(28, 200, 138, 0.3);
	}

	.thank-you-icon {
		width: 80px;
		height: 80px;
		background: rgba(255, 255, 255, 0.2);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 20px;
	}

	.thank-you-icon i {
		font-size: 36px;
	}

	.thank-you-card h3 {
		font-size: 28px;
		font-weight: 700;
		margin: 0 0 15px;
	}

	.thank-you-card p {
		font-size: 15px;
		line-height: 1.7;
		opacity: 0.95;
		margin: 0 0 20px;
		max-width: 500px;
		margin-left: auto;
		margin-right: auto;
	}

	.support-text {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: rgba(255, 255, 255, 0.2);
		padding: 10px 20px;
		border-radius: 30px;
		font-size: 14px;
	}

	.support-text i {
		animation: heartbeat 1.5s ease-in-out infinite;
	}

	@keyframes heartbeat {

		0%,
		100% {
			transform: scale(1);
		}

		50% {
			transform: scale(1.2);
		}
	}

	/* Responsive */
	@media (max-width: 768px) {
		.hero-title {
			font-size: 36px;
		}

		.hero-subtitle {
			font-size: 16px;
		}

		.app-badge-container {
			flex-direction: column;
			padding: 20px;
		}

		.app-badge-box {
			width: 80px;
			height: 80px;
		}

		.app-logo-img {
			width: 56px;
			height: 56px;
		}

		.app-logo-fallback {
			font-size: 32px;
		}

		.app-text {
			text-align: center;
		}

		.app-name {
			font-size: 28px;
		}

		.bank-cards {
			grid-template-columns: 1fr;
		}

		.benefit-list {
			grid-template-columns: 1fr;
		}

		.main-content {
			margin-top: -30px;
		}

		.about-body {
			padding: 20px;
		}

		.donation-section {
			padding: 20px;
		}
	}
</style>

<script>
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