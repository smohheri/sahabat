<!-- Halaman Dukung Kami -->
<div class="dukung-kami-container">
	<!-- Hero Section -->
	<div class="hero-section">
		<div class="hero-icon">
			<i class="fas fa-heart"></i>
		</div>
		<h2 class="hero-title">Dukung Kami</h2>
		<p class="hero-subtitle">Bersama Membangun Masa Depan yang Lebih Baik</p>
		<div class="app-name-badge">
			<span class="app-code">SAHABAT</span>
			<span class="app-fullname">Sistem Anak Hebat Berbasis Administrasi Terpadu</span>
		</div>
	</div>

	<!-- Content Card -->
	<div class="content-card">
		<div class="content-text">
			<p>
				Halaman <strong>Dukung Kami</strong> merupakan ruang bagi Anda yang ingin berpartisipasi dalam
				pengembangan aplikasi dan mendukung layanan bagi anak-anak melalui kontribusi sukarela. Setiap dukungan
				yang diberikan akan membantu peningkatan fitur, pemeliharaan sistem, serta keberlanjutan layanan agar
				tetap bermanfaat bagi banyak pihak.
			</p>
			<p>
				Donasi bersifat <strong>opsional</strong> tanpa kewajiban apa pun, namun setiap kontribusi memiliki arti
				besar bagi keberlanjutan layanan ini.
			</p>
		</div>

		<!-- Divider -->
		<div class="divider">
			<span><i class="fas fa-gift"></i></span>
		</div>

		<!-- Donation Info -->
		<div class="donation-section">
			<h3 class="donation-title">Informasi Donasi</h3>
			<p class="donation-text">
				Apabila Anda berkenan memberikan dukungan, donasi dapat disalurkan melalui rekening:
			</p>

			<!-- Bank Card -->
			<div class="bank-card">
				<div class="bank-logo">
					<i class="fas fa-university"></i>
					<span class="bank-name">BRI</span>
				</div>
				<div class="bank-info">
					<div class="account-number">057201014816537</div>
					<div class="account-name">a.n. Moh. Heri Setiawan</div>
				</div>
				<button class="copy-btn" onclick="copyToClipboard('057201014816537')" title="Salin Nomor Rekening">
					<i class="fas fa-copy"></i>
				</button>
			</div>

			<!-- Thank You Message -->
			<div class="thank-you">
				<i class="fas fa-praying-hands"></i>
				<p>Terima kasih atas kebaikan dan partisipasi Anda dalam menghadirkan dampak positif bersama.</p>
			</div>
		</div>
	</div>
</div>

<style>
	/* Container */
	.dukung-kami-container {
		max-width: 800px;
		margin: 0 auto;
		padding: 20px;
	}

	/* Hero Section */
	.hero-section {
		text-align: center;
		margin-bottom: 30px;
	}

	.hero-icon {
		width: 80px;
		height: 80px;
		background: linear-gradient(135deg, #e74a3b 0%, #e83e8c 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 20px;
		box-shadow: 0 10px 30px rgba(231, 74, 59, 0.3);
	}

	.hero-icon i {
		font-size: 36px;
		color: #fff;
	}

	.hero-title {
		font-size: 32px;
		font-weight: 700;
		color: #2d3748;
		margin: 0 0 10px 0;
	}

	.hero-subtitle {
		font-size: 16px;
		color: #718096;
		margin: 0 0 15px 0;
	}

	/* App Name Badge */
	.app-name-badge {
		display: inline-flex;
		flex-direction: column;
		align-items: center;
		gap: 5px;
		background: linear-gradient(135deg, #4e73df 0%, #6f42c1 100%);
		padding: 12px 25px;
		border-radius: 25px;
		box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
	}

	.app-code {
		font-size: 20px;
		font-weight: 700;
		color: #fff;
		letter-spacing: 2px;
	}

	.app-fullname {
		font-size: 11px;
		color: rgba(255, 255, 255, 0.9);
		font-weight: 500;
	}

	/* Content Card */
	.content-card {
		background: #fff;
		border-radius: 20px;
		padding: 40px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
	}

	.content-text {
		text-align: center;
		margin-bottom: 30px;
	}

	.content-text p {
		font-size: 15px;
		line-height: 1.8;
		color: #4a5568;
		margin-bottom: 15px;
	}

	.content-text p:last-child {
		margin-bottom: 0;
	}

	/* Divider */
	.divider {
		display: flex;
		align-items: center;
		margin: 30px 0;
	}

	.divider::before,
	.divider::after {
		content: '';
		flex: 1;
		height: 1px;
		background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
	}

	.divider span {
		width: 50px;
		height: 50px;
		background: linear-gradient(135deg, #f6c23e 0%, #f4a261 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 15px;
		box-shadow: 0 4px 15px rgba(246, 194, 62, 0.3);
	}

	.divider span i {
		font-size: 20px;
		color: #fff;
	}

	/* Donation Section */
	.donation-section {
		text-align: center;
	}

	.donation-title {
		font-size: 20px;
		font-weight: 600;
		color: #2d3748;
		margin: 0 0 15px 0;
	}

	.donation-text {
		font-size: 14px;
		color: #718096;
		margin-bottom: 25px;
	}

	/* Bank Card */
	.bank-card {
		background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
		border-radius: 16px;
		padding: 30px;
		color: #fff;
		display: flex;
		align-items: center;
		gap: 20px;
		margin-bottom: 30px;
		position: relative;
		box-shadow: 0 10px 30px rgba(0, 86, 179, 0.3);
	}

	.bank-logo {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 5px;
	}

	.bank-logo i {
		font-size: 32px;
	}

	.bank-name {
		font-size: 14px;
		font-weight: 600;
		letter-spacing: 1px;
	}

	.bank-info {
		flex: 1;
		text-align: left;
	}

	.account-number {
		font-size: 24px;
		font-weight: 700;
		letter-spacing: 2px;
		margin-bottom: 5px;
		font-family: 'Courier New', monospace;
	}

	.account-name {
		font-size: 14px;
		opacity: 0.9;
	}

	.copy-btn {
		width: 45px;
		height: 45px;
		background: rgba(255, 255, 255, 0.2);
		border: none;
		border-radius: 10px;
		color: #fff;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.copy-btn:hover {
		background: rgba(255, 255, 255, 0.3);
		transform: scale(1.05);
	}

	.copy-btn i {
		font-size: 18px;
	}

	/* Thank You */
	.thank-you {
		background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
		border-radius: 12px;
		padding: 20px;
		color: #fff;
		display: flex;
		align-items: center;
		gap: 15px;
		box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
	}

	.thank-you i {
		font-size: 28px;
	}

	.thank-you p {
		margin: 0;
		font-size: 14px;
		line-height: 1.6;
		text-align: left;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.content-card {
			padding: 25px;
		}

		.hero-title {
			font-size: 26px;
		}

		.app-name-badge {
			padding: 10px 20px;
		}

		.app-code {
			font-size: 18px;
		}

		.app-fullname {
			font-size: 10px;
		}

		.bank-card {
			flex-direction: column;
			text-align: center;
			padding: 25px;
		}

		.bank-info {
			text-align: center;
		}

		.account-number {
			font-size: 20px;
		}

		.thank-you {
			flex-direction: column;
			text-align: center;
		}

		.thank-you p {
			text-align: center;
		}
	}
</style>

<script>
	function copyToClipboard(text) {
		navigator.clipboard.writeText(text).then(function () {
			// Show toast notification
			const toast = document.createElement('div');
			toast.style.cssText = `
				position: fixed;
				bottom: 20px;
				left: 50%;
				transform: translateX(-50%);
				background: #1cc88a;
				color: white;
				padding: 12px 24px;
				border-radius: 8px;
				font-size: 14px;
				z-index: 9999;
				box-shadow: 0 4px 12px rgba(0,0,0,0.15);
			`;
			toast.textContent = 'Nomor rekening berhasil disalin!';
			document.body.appendChild(toast);

			setTimeout(() => {
				toast.remove();
			}, 2000);
		}).catch(function (err) {
			console.error('Gagal menyalin: ', err);
		});
	}
</script>