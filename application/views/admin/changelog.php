<!-- Changelog Page -->
<div class="changelog-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-icon">
			<i class="fas fa-history"></i>
		</div>
		<div class="header-content">
			<h1>Changelog</h1>
			<p>Riwayat perubahan dan pembaruan aplikasi SAHABAT</p>
		</div>
	</div>

	<!-- Changelog Content -->
	<div class="changelog-content-card">
		<div class="card-header">
			<i class="fas fa-code-branch"></i>
			<h3>Riwayat Versi</h3>
		</div>
		<div class="card-body">
			<div class="changelog-content markdown-body">
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
					echo '<p>Changelog file not found.</p>';
				}
				?>
			</div>
		</div>
	</div>

	<!-- Info Section -->
	<div class="info-section">
		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-info-circle"></i>
			</div>
			<div class="info-content">
				<h4>Tentang Changelog</h4>
				<p>Dokumentasi perubahan fitur, perbaikan bug, dan peningkatan aplikasi.</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-download"></i>
			</div>
			<div class="info-content">
				<h4>Update Otomatis</h4>
				<p>Aplikasi akan menampilkan versi terbaru secara otomatis.</p>
			</div>
		</div>

		<div class="info-card">
			<div class="info-icon">
				<i class="fas fa-star"></i>
			</div>
			<div class="info-content">
				<h4>Feedback</h4>
				<p>Bantu kami dengan memberikan feedback untuk pengembangan selanjutnya.</p>
			</div>
		</div>
	</div>
</div>

<style>
	/* Page Container */
	.changelog-page {
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

	/* Changelog Content Card */
	.changelog-content-card {
		background: #fff;
		border-radius: 16px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		margin-bottom: 30px;
		transition: all 0.3s ease;
	}

	.changelog-content-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
	}

	.changelog-content-card .card-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		padding: 20px 25px;
		display: flex;
		align-items: center;
		gap: 12px;
		color: #fff;
	}

	.changelog-content-card .card-header i {
		font-size: 24px;
	}

	.changelog-content-card .card-header h3 {
		margin: 0;
		font-size: 18px;
		font-weight: 600;
	}

	.changelog-content-card .card-body {
		padding: 0;
		max-height: 600px;
		overflow-y: auto;
	}

	/* GitHub-like Markdown Styling */
	.markdown-body {
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
		font-size: 16px;
		line-height: 1.6;
		color: #24292e;
		background-color: #ffffff;
		padding: 40px 40px 40px 80px;
		margin: 0;
		border-radius: 6px;
		word-wrap: break-word;
	}

	.markdown-body h1,
	.markdown-body h2,
	.markdown-body h3,
	.markdown-body h4,
	.markdown-body h5,
	.markdown-body h6 {
		margin-top: 24px;
		margin-bottom: 16px;
		font-weight: 600;
		line-height: 1.25;
	}

	.markdown-body h1 {
		padding-bottom: 0.3em;
		font-size: 2em;
		border-bottom: 1px solid #eaecef;
	}

	.markdown-body h2 {
		padding-bottom: 0.3em;
		font-size: 1.5em;
		border-bottom: 1px solid #eaecef;
	}

	.markdown-body h3 {
		font-size: 1.25em;
	}

	.markdown-body h4 {
		font-size: 1em;
	}

	.markdown-body h5 {
		font-size: 0.875em;
	}

	.markdown-body h6 {
		font-size: 0.85em;
		color: #6a737d;
	}

	.markdown-body p {
		margin-top: 0;
		margin-bottom: 16px;
	}

	.markdown-body blockquote {
		margin: 0;
		padding: 0 1em;
		color: #6a737d;
		border-left: 0.25em solid #dfe2e5;
	}

	.markdown-body ul,
	.markdown-body ol {
		padding-left: 2em;
		margin-bottom: 16px;
	}

	.markdown-body ul li,
	.markdown-body ol li {
		margin-bottom: 0.25em;
	}

	.markdown-body ul li::marker {
		color: #586069;
	}

	.markdown-body code {
		padding: 0.2em 0.4em;
		margin: 0;
		font-size: 85%;
		background-color: rgba(27, 31, 35, 0.05);
		border-radius: 3px;
		font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
	}

	.markdown-body pre {
		word-wrap: normal;
		padding: 16px;
		overflow: auto;
		font-size: 85%;
		line-height: 1.45;
		background-color: #f6f8fa;
		border-radius: 3px;
	}

	.markdown-body pre code {
		background: transparent;
		border: 0;
		padding: 0;
	}

	.markdown-body hr {
		height: 0.25em;
		padding: 0;
		margin: 24px 0;
		background-color: #e1e4e8;
		border: 0;
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
	}

	/* Dark Mode Styles */
	body.dark-mode .changelog-page {
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

	body.dark-mode .changelog-content-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .markdown-body {
		color: #e0e0e0;
		background-color: #16213e;
	}

	body.dark-mode .markdown-body h1,
	body.dark-mode .markdown-body h2,
	body.dark-mode .markdown-body h3,
	body.dark-mode .markdown-body h4,
	body.dark-mode .markdown-body h5,
	body.dark-mode .markdown-body h6 {
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .markdown-body p,
	body.dark-mode .markdown-body li {
		color: #a0a0a0;
	}

	body.dark-mode .markdown-body code {
		background-color: rgba(0, 223, 255, 0.1);
		color: #00d9ff;
	}

	body.dark-mode .markdown-body pre {
		background-color: #0f3460;
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