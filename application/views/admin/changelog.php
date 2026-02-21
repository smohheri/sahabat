<!-- Changelog - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-history"></i>
			</div>
			<div>
				<h2>Changelog</h2>
				<p>Riwayat perubahan dan pembaruan aplikasi SAHABAT</p>
			</div>
		</div>
	</div>

	<!-- Changelog Content -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-code-branch"></i> Riwayat Versi</h3>
			<span class="data-count">Versi Terbaru</span>
		</div>
		<div class="panel-body">
			<div class="changelog-content">
				<?php
				$changelog_file = FCPATH . 'CHANGELOG.md';
				if (file_exists($changelog_file)) {
					$content = file_get_contents($changelog_file);
					// Simple markdown to HTML conversion for headers and lists
					$content = preg_replace('/### (.*)/', '<h4>$1</h4>', $content);
					$content = preg_replace('/## (.*)/', '<h3>$1</h3>', $content);
					$content = preg_replace('/# (.*)/', '<h2>$1</h2>', $content);
					$content = preg_replace('/- (.*)/', '<li>$1</li>', $content);
					$content = preg_replace('/\n\n/', '</p><p>', $content);
					$content = '<p>' . $content . '</p>';
					$content = preg_replace('/<p><\/p>/', '', $content);
					echo $content;
				} else {
					echo '<p class="text-muted">File changelog tidak ditemukan.</p>';
				}
				?>
			</div>
		</div>
	</div>

	<!-- Information Cards -->
	<div class="info-grid">
		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-info-circle"></i>
			</div>
			<div class="info-content">
				<h4>Tentang Changelog</h4>
				<p>Dokumentasi perubahan fitur, perbaikan bug, dan peningkatan aplikasi secara lengkap.</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-download"></i>
			</div>
			<div class="info-content">
				<h4>Update Otomatis</h4>
				<p>Aplikasi akan menampilkan versi terbaru secara otomatis tanpa perlu konfigurasi manual.</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-star"></i>
			</div>
			<div class="info-content">
				<h4>Feedback</h4>
				<p>Bantu kami dengan memberikan feedback untuk pengembangan fitur selanjutnya.</p>
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

	/* Changelog Content */
	.changelog-content {
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
		font-size: 14px;
		line-height: 1.6;
		color: #24292e;
		max-height: 600px;
		overflow-y: auto;
		padding-right: 10px;
	}

	.changelog-content h1,
	.changelog-content h2,
	.changelog-content h3,
	.changelog-content h4,
	.changelog-content h5,
	.changelog-content h6 {
		margin-top: 24px;
		margin-bottom: 16px;
		font-weight: 600;
		line-height: 1.25;
		color: #2d3748;
	}

	.changelog-content h1 {
		padding-bottom: 0.3em;
		font-size: 1.8em;
		border-bottom: 1px solid #e2e8f0;
	}

	.changelog-content h2 {
		padding-bottom: 0.3em;
		font-size: 1.4em;
		border-bottom: 1px solid #e2e8f0;
	}

	.changelog-content h3 {
		font-size: 1.2em;
		color: #4e73df;
	}

	.changelog-content h4 {
		font-size: 1.1em;
		color: #1cc88a;
	}

	.changelog-content p {
		margin-top: 0;
		margin-bottom: 16px;
		color: #718096;
	}

	.changelog-content ul,
	.changelog-content ol {
		padding-left: 2em;
		margin-bottom: 16px;
	}

	.changelog-content li {
		margin-bottom: 0.25em;
		color: #718096;
	}

	.changelog-content li::marker {
		color: #4e73df;
	}

	.changelog-content code {
		padding: 0.2em 0.4em;
		margin: 0;
		font-size: 85%;
		background-color: rgba(78, 115, 223, 0.1);
		border-radius: 3px;
		font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
		color: #4e73df;
	}

	.changelog-content pre {
		word-wrap: normal;
		padding: 16px;
		overflow: auto;
		font-size: 85%;
		line-height: 1.45;
		background-color: #f8fafc;
		border-radius: 6px;
		border: 1px solid #e2e8f0;
	}

	.changelog-content pre code {
		background: transparent;
		border: 0;
		padding: 0;
		color: inherit;
	}

	.changelog-content hr {
		height: 0.25em;
		padding: 0;
		margin: 24px 0;
		background-color: #e2e8f0;
		border: 0;
	}

	.changelog-content .text-muted {
		color: #a0a0a0 !important;
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

		.panel-body {
			padding: 20px;
		}

		.changelog-content {
			font-size: 13px;
			max-height: 400px;
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

	body.dark-mode .changelog-content {
		color: #e0e0e0;
	}

	body.dark-mode .changelog-content h1,
	body.dark-mode .changelog-content h2,
	body.dark-mode .changelog-content h3,
	body.dark-mode .changelog-content h4,
	body.dark-mode .changelog-content h5,
	body.dark-mode .changelog-content h6 {
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .changelog-content p,
	body.dark-mode .changelog-content li {
		color: #a0a0a0;
	}

	body.dark-mode .changelog-content code {
		background-color: rgba(0, 223, 255, 0.1);
		color: #00d9ff;
	}

	body.dark-mode .changelog-content pre {
		background-color: #0f3460;
		border-color: #16213e;
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