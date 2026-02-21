<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="main-navbar">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url('admin'); ?>" class="nav-link">Dashboard</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Contact Link (Text like Dashboard) -->
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo site_url('admin/kontak'); ?>" class="nav-link" title="Kontak Pengembang">
				<i class="far fa-address-card mr-1"></i> Kontak
			</a>
		</li>

		<!-- Dark/Light Mode Toggle -->
		<li class="nav-item">
			<a class="nav-link" href="#" id="theme-toggle" title="Ganti Tema">
				<i class="fas fa-moon" id="theme-icon"></i>
			</a>
		</li>

		<!-- Fullscreen Toggle -->
		<li class="nav-item">
			<a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>

		<!-- Control Sidebar Toggle -->
		<li class="nav-item">
			<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"
				title="Pengaturan">
				<i class="fas fa-th-large"></i>
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->

<!-- Dark Mode Styles -->
<style>
	body.dark-mode {
		background-color: #1a1a2e;
		color: #e0e0e0;
	}

	body.dark-mode .main-header,
	body.dark-mode .main-sidebar,
	body.dark-mode .navbar {
		background-color: #16213e !important;
	}

	body.dark-mode .navbar-light {
		background-color: #16213e !important;
	}

	body.dark-mode .navbar-light .nav-link {
		color: #e0e0e0 !important;
	}

	body.dark-mode .nav-link:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .dropdown-menu {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .dropdown-item {
		color: #e0e0e0;
	}

	body.dark-mode .dropdown-item:hover {
		background-color: #0f3460;
		color: #fff;
	}

	body.dark-mode .dropdown-header {
		color: #00d9ff;
	}

	body.dark-mode .content-wrapper {
		background-color: #1a1a2e;
	}

	body.dark-mode .card {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .card-header {
		background-color: #0f3460;
		border-bottom-color: #1a1a2e;
	}

	body.dark-mode .table {
		color: #e0e0e0;
	}

	body.dark-mode .table td,
	body.dark-mode .table th {
		border-color: #0f3460 !important;
	}

	body.dark-mode .form-control {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .modal-content {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .modal-header,
	body.dark-mode .modal-footer {
		border-color: #0f3460;
	}

	body.dark-mode .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
		background-color: #00d9ff;
		color: #16213e;
	}

	body.dark-mode .nav-sidebar>.nav-item>.nav-link {
		color: #e0e0e0;
	}

	body.dark-mode .nav-sidebar>.nav-item>.nav-link:hover {
		background-color: #0f3460;
	}

	/* Additional Dark Mode Styles */
	body.dark-mode .small-box {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .info-box {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .info-box .info-box-icon {
		background-color: #0f3460;
	}

	body.dark-mode .breadcrumb {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .breadcrumb a {
		color: #00d9ff;
	}

	body.dark-mode .page-item .page-link {
		background-color: #16213e;
		border-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .page-item.active .page-link {
		background-color: #00d9ff;
		border-color: #00d9ff;
		color: #16213e;
	}

	body.dark-mode .page-link:hover {
		background-color: #0f3460;
	}

	body.dark-mode .custom-select {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .input-group-text {
		background-color: #0f3460;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .btn-secondary {
		background-color: #0f3460;
		border-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .btn-secondary:hover {
		background-color: #16213e;
		border-color: #16213e;
		color: #fff;
	}

	body.dark-mode .modal-header {
		background-color: #0f3460;
	}

	body.dark-mode .modal-title {
		color: #e0e0e0;
	}

	body.dark-mode .close {
		color: #e0e0e0;
	}

	body.dark-mode .close:hover {
		color: #fff;
	}

	body.dark-mode .card-footer {
		background-color: #16213e;
		border-top-color: #0f3460;
	}

	body.dark-mode .border-top {
		border-top-color: #0f3460 !important;
	}

	body.dark-mode .border-bottom {
		border-bottom-color: #0f3460 !important;
	}

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}

	body.dark-mode .card-title {
		color: #e0e0e0;
	}

	body.dark-mode .nav-tabs {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .nav-tabs .nav-link {
		color: #e0e0e0;
	}

	body.dark-mode .nav-tabs .nav-link:hover {
		border-color: #0f3460;
	}

	body.dark-mode .nav-tabs .nav-link.active {
		background-color: #16213e;
		border-color: #0f3460 #0f3460 #16213e;
		color: #00d9ff;
	}

	body.dark-mode .tab-content {
		background-color: #16213e;
	}

	body.dark-mode .dataTables_wrapper {
		color: #e0e0e0;
	}

	body.dark-mode table.dataTable {
		color: #e0e0e0;
	}

	body.dark-mode table.dataTable thead th,
	body.dark-mode table.dataTable thead td {
		background-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode table.dataTable tbody tr {
		background-color: #16213e;
	}

	body.dark-mode table.dataTable tbody tr:hover {
		background-color: #0f3460;
	}

	body.dark-mode .dataTables_length select,
	body.dark-mode .dataTables_filter input {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .dt-button {
		background-color: #0f3460;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .dt-button:hover {
		background-color: #16213e;
		color: #fff;
	}

	body.dark-mode .swal2-popup {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .swal2-title {
		color: #e0e0e0;
	}

	body.dark-mode .swal2-content {
		color: #e0e0e0;
	}

	body.dark-mode .select2-container--default .select2-selection--single {
		background-color: #1a1a2e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #e0e0e0;
	}

	body.dark-mode .select2-dropdown {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .select2-results__option {
		color: #e0e0e0;
	}

	body.dark-mode .select2-results__option--highlighted[aria-selected] {
		background-color: #0f3460;
		color: #fff;
	}

	body.dark-mode .toast {
		background-color: #16213e;
		color: #e0e0e0;
		border-color: #0f3460;
	}

	body.dark-mode .toast-header {
		background-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .alert-success {
		background-color: #1b4332;
		border-color: #2d6a4f;
		color: #95d5b2;
	}

	body.dark-mode .alert-danger {
		background-color: #5c1a1a;
		border-color: #7f2626;
		color: #f5b7b1;
	}

	body.dark-mode .alert-warning {
		background-color: #5c4813;
		border-color: #7a6319;
		color: #f9e79f;
	}

	body.dark-mode .alert-info {
		background-color: #1a3a5c;
		border-color: #264d73;
		color: #aed6f1;
	}

	body.dark-mode .progress {
		background-color: #0f3460;
	}

	body.dark-mode .progress-bar {
		background-color: #00d9ff;
	}

	body.dark-mode .dropdown-divider {
		border-top-color: #0f3460;
	}

	body.dark-mode .wrapper {
		background-color: #1a1a2e;
	}

	body.dark-mode .main-footer {
		background-color: #16213e;
		color: #e0e0e0;
		border-top-color: #0f3460;
	}

	body.dark-mode .brand-link {
		background-color: #16213e;
		color: #e0e0e0;
	}

	body.dark-mode .brand-link:hover {
		background-color: #0f3460;
		color: #fff;
	}

	body.dark-mode .user-panel {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .user-panel .info {
		color: #e0e0e0;
	}

	body.dark-mode hr {
		border-top-color: #0f3460;
	}

	body.dark-mode .text-dark {
		color: #e0e0e0 !important;
	}

	body.dark-mode .bg-white {
		background-color: #16213e !important;
	}

	body.dark-mode .border {
		border-color: #0f3460 !important;
	}
</style>

<!-- Theme Toggle Script -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const themeToggle = document.getElementById('theme-toggle');
		const themeIcon = document.getElementById('theme-icon');
		const body = document.body;

		// Check localStorage for theme preference
		const savedTheme = localStorage.getItem('theme');
		if (savedTheme === 'dark') {
			body.classList.add('dark-mode');
			themeIcon.classList.remove('fa-moon');
			themeIcon.classList.add('fa-sun');
		}

		// Toggle theme on click
		themeToggle.addEventListener('click', function (e) {
			e.preventDefault();
			body.classList.toggle('dark-mode');

			if (body.classList.contains('dark-mode')) {
				localStorage.setItem('theme', 'dark');
				themeIcon.classList.remove('fa-moon');
				themeIcon.classList.add('fa-sun');
			} else {
				localStorage.setItem('theme', 'light');
				themeIcon.classList.remove('fa-sun');
				themeIcon.classList.add('fa-moon');
			}
		});
	});
</script>