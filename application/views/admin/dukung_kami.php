<!-- Dukung Kami - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-heart"></i>
			</div>
			<div>
				<h2>Dukung Kami</h2>
				<p>Bersama membangun masa depan yang lebih baik untuk anak-anak Indonesia</p>
			</div>
		</div>
	</div>

	<!-- App Info Section -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-info-circle"></i> Tentang Dukungan</h3>
		</div>
		<div class="panel-body">
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
					<p>Halaman ini merupakan ruang bagi Anda yang ingin berpartisipasi dalam pengembangan aplikasi dan
						mendukung layanan bagi anak-anak melalui kontribusi sukarela.</p>
					<div class="benefits-list">
						<div class="benefit-item">
							<i class="fas fa-check-circle"></i>
							<span>Peningkatan fitur sistem</span>
						</div>
						<div class="benefit-item">
							<i class="fas fa-check-circle"></i>
							<span>Pemeliharaan server dan database</span>
						</div>
						<div class="benefit-item">
							<i class="fas fa-check-circle"></i>
							<span>Keberlanjutan layanan</span>
						</div>
						<div class="benefit-item">
							<i class="fas fa-check-circle"></i>
							<span>Pengembangan fitur baru</span>
						</div>
					</div>
					<div class="note-box">
						<i class="fas fa-lightbulb"></i>
						<span>Donasi bersifat <strong>opsional</strong> tanpa kewajiban apa pun. Setiap kontribusi,
							sekecil apa pun, memiliki arti besar.</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bank Accounts Section -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-university"></i> Rekening Donasi</h3>
			<span class="data-count">2 rekening aktif</span>
		</div>
		<div class="panel-body">
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
								<button class="copy-btn" onclick="copyToClipboard('057201014816537')" title="Salin">
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
	</div>

	<!-- QR Code Section -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-qrcode"></i> Pembayaran Digital</h3>
		</div>
		<div class="panel-body">
			<div class="qr-section">
				<div class="qr-container">
					<img src="<?php echo base_url('assets/img/QRIS.png'); ?>" alt="QR Code QRIS" class="qr-image">
					<div class="qr-info">
						<h4>QRIS</h4>
						<p>Scan kode QR untuk donasi cepat dan mudah</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Thank You Section -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-praying-hands"></i> Terima Kasih</h3>
		</div>
		<div class="panel-body">
			<div class="thank-you-content">
				<div class="thank-you-icon">
					<i class="fas fa-heart"></i>
				</div>
				<h4>Atas Kebaikan Anda</h4>
				<p>Terima kasih atas kebaikan dan partisipasi Anda dalam menghadirkan dampak positif bersama. Donasi
					Anda akan berdampak langsung pada pengembangan sistem ini.</p>
				<div class="support-message">
					<i class="fas fa-heart text-danger"></i>
					<span>Setiap dukungan berarti bagi kami</span>
				</div>
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

	/* App Info Section */
	.app-info-section {
		display: grid;
		grid-template-columns: auto 1fr;
		gap: 25px;
		align-items: start;
	}

	.app-badge {
		display: flex;
		align-items: center;
		gap: 15px;
		padding: 20px;
		background: linear-gradient(135deg, #7AC64D 0%, #5fa33a 100%);
		border-radius: 14px;
		color: #fff;
		min-width: 250px;
	}

	.app-logo {
		width: 50px;
		height: 50px;
		border-radius: 10px;
		object-fit: contain;
	}

	.app-logo-fallback {
		width: 50px;
		height: 50px;
		border-radius: 10px;
		background: rgba(255, 255, 255, 0.2);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
		font-weight: 700;
	}

	.app-details h4 {
		margin: 0 0 5px;
		font-size: 18px;
		font-weight: 600;
	}

	.app-details span {
		font-size: 12px;
		opacity: 0.9;
	}

	.support-description p {
		color: #718096;
		font-size: 14px;
		line-height: 1.6;
		margin-bottom: 20px;
	}

	.benefits-list {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 12px;
		margin-bottom: 20px;
	}

	.benefit-item {
		display: flex;
		align-items: center;
		gap: 10px;
		font-size: 14px;
		color: #2d3748;
	}

	.benefit-item i {
		color: #1cc88a;
		font-size: 16px;
	}

	.note-box {
		background: #fef3c7;
		border-left: 4px solid #f6c23e;
		padding: 15px 20px;
		border-radius: 8px;
		display: flex;
		align-items: flex-start;
		gap: 10px;
		font-size: 14px;
		color: #2d3748;
	}

	.note-box i {
		color: #f6c23e;
		font-size: 16px;
		margin-top: 2px;
	}

	/* Bank Accounts */
	.bank-accounts {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 20px;
	}

	.bank-card {
		border: 2px solid #e2e8f0;
		border-radius: 14px;
		padding: 20px;
		transition: all 0.3s ease;
	}

	.bank-card.primary {
		border-color: #4e73df;
		background: rgba(78, 115, 223, 0.02);
	}

	.bank-card.secondary {
		border-color: #1e3a5f;
		background: rgba(30, 58, 95, 0.02);
	}

	.bank-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
	}

	.bank-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 15px;
	}

	.bank-info {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.bank-info i {
		font-size: 24px;
		color: #4e73df;
	}

	.bank-info h5 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
	}

	.bank-info span {
		font-size: 12px;
		color: #718096;
	}

	.status-badge {
		background: #d1fae5;
		color: #065f46;
		padding: 4px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 500;
		display: flex;
		align-items: center;
		gap: 5px;
	}

	.status-badge i {
		font-size: 10px;
	}

	.bank-details {
		padding-top: 15px;
		border-top: 1px solid #e2e8f0;
	}

	.account-info label {
		display: block;
		font-size: 12px;
		color: #718096;
		text-transform: uppercase;
		font-weight: 500;
		margin-bottom: 5px;
		letter-spacing: 0.5px;
	}

	.account-number {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 10px;
	}

	.account-number span {
		font-size: 18px;
		font-weight: 600;
		color: #2d3748;
		font-family: 'Courier New', monospace;
		letter-spacing: 1px;
	}

	.copy-btn {
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		width: 32px;
		height: 32px;
		border-radius: 6px;
		color: #718096;
		cursor: pointer;
		transition: all 0.2s;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.copy-btn:hover {
		background: #4e73df;
		color: #fff;
		border-color: #4e73df;
	}

	.account-holder {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		color: #718096;
	}

	.account-holder i {
		font-size: 12px;
	}

	/* QR Section */
	.qr-section {
		text-align: center;
	}

	.qr-container {
		display: inline-flex;
		flex-direction: column;
		align-items: center;
		gap: 15px;
		padding: 30px;
		background: #f8fafc;
		border: 2px dashed #e2e8f0;
		border-radius: 14px;
	}

	.qr-image {
		width: auto;
		height: auto;
		max-width: 280px;
		border-radius: 10px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}

	.qr-info h4 {
		margin: 0 0 5px;
		font-size: 18px;
		font-weight: 600;
		color: #2d3748;
	}

	.qr-info p {
		margin: 0;
		font-size: 14px;
		color: #718096;
	}

	/* Thank You Section */
	.thank-you-content {
		text-align: center;
	}

	.thank-you-icon {
		width: 70px;
		height: 70px;
		background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 20px;
		font-size: 28px;
		color: #fff;
		box-shadow: 0 8px 20px rgba(231, 74, 59, 0.3);
	}

	.thank-you-content h4 {
		font-size: 20px;
		font-weight: 600;
		color: #2d3748;
		margin: 0 0 15px;
	}

	.thank-you-content p {
		color: #718096;
		font-size: 14px;
		line-height: 1.6;
		margin: 0 0 20px;
		max-width: 500px;
		margin-left: auto;
		margin-right: auto;
	}

	.support-message {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
		padding: 10px 20px;
		border-radius: 25px;
		font-size: 14px;
		font-weight: 500;
	}

	.support-message i {
		font-size: 16px;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.bank-accounts {
			grid-template-columns: 1fr;
		}

		.app-info-section {
			grid-template-columns: 1fr;
			text-align: center;
		}

		.benefits-list {
			grid-template-columns: 1fr;
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

		.app-badge {
			flex-direction: column;
			text-align: center;
			min-width: auto;
		}

		.panel-body {
			padding: 20px;
		}

		.bank-accounts {
			gap: 15px;
		}

		.qr-container {
			padding: 20px;
		}

		.qr-image {
			width: 120px;
			height: 120px;
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

	body.dark-mode .app-badge {
		background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
	}

	body.dark-mode .support-description p {
		color: #a0a0a0;
	}

	body.dark-mode .benefit-item {
		color: #e0e0e0;
	}

	body.dark-mode .note-box {
		background-color: rgba(246, 194, 62, 0.1);
		border-left-color: #f6c23e;
		color: #e0e0e0;
	}

	body.dark-mode .bank-card {
		border-color: #0f3460;
		background-color: #16213e;
	}

	body.dark-mode .bank-info h5 {
		color: #e0e0e0;
	}

	body.dark-mode .bank-info span {
		color: #a0a0a0;
	}

	body.dark-mode .account-number span {
		color: #e0e0e0;
	}

	body.dark-mode .account-holder {
		color: #a0a0a0;
	}

	body.dark-mode .copy-btn {
		background-color: #0f3460;
		border-color: #16213e;
		color: #a0a0a0;
	}

	body.dark-mode .copy-btn:hover {
		background-color: #4e73df;
		color: #fff;
	}

	body.dark-mode .qr-container {
		background-color: #0f3460;
		border-color: #16213e;
	}

	body.dark-mode .qr-info h4 {
		color: #e0e0e0;
	}

	body.dark-mode .qr-info p {
		color: #a0a0a0;
	}

	body.dark-mode .thank-you-content h4 {
		color: #e0e0e0;
	}

	body.dark-mode .thank-you-content p {
		color: #a0a0a0;
	}

	body.dark-mode .support-message {
		background-color: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	body.dark-mode .text-danger {
		color: #e74a3b !important;
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