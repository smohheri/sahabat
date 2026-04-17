<!-- Navbar -->
<?php
$role = $this->session->userdata('role');
$is_guru = in_array($role, array('guru', 'pengajar'), TRUE);
$is_anak = ($role === 'anak');
$dashboard_link = $is_anak ? site_url('anak') : ($is_guru ? site_url('guru') : site_url('admin'));
$secondary_link = $is_anak ? site_url('auth/logout') : ($is_guru ? site_url('guru/anak') : site_url('admin/kontak'));
$secondary_icon = $is_anak ? 'fas fa-sign-out-alt' : ($is_guru ? 'fas fa-child' : 'far fa-address-card');
$secondary_label = $is_anak ? 'Logout' : ($is_guru ? 'Data Anak' : 'Kontak');
$secondary_title = $is_anak ? 'Keluar dari sistem' : ($is_guru ? 'Lihat data anak' : 'Kontak Pengembang');
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="main-navbar">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo $dashboard_link; ?>" class="nav-link">Dashboard</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Contact Link (Text like Dashboard) -->
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo $secondary_link; ?>" class="nav-link" title="<?php echo $secondary_title; ?>">
				<i class="<?php echo $secondary_icon; ?> mr-1"></i> <?php echo $secondary_label; ?>
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

	/* Guru Panel Dark Mode */
	body.dark-mode .guru-dashboard,
	body.dark-mode .guru-anak-page,
	body.dark-mode .guru-penilaian-page,
	body.dark-mode .guru-perkembangan-page,
	body.dark-mode .guru-perkembangan-detail-page {
		color: #e5e7eb;
	}

	body.dark-mode .guru-dashboard .stat-card,
	body.dark-mode .guru-dashboard .substat-item,
	body.dark-mode .guru-dashboard .panel,
	body.dark-mode .guru-anak-page .page-header,
	body.dark-mode .guru-anak-page .stat-card,
	body.dark-mode .guru-anak-page .table-panel,
	body.dark-mode .guru-penilaian-page .page-header-card,
	body.dark-mode .guru-penilaian-page .stat-card,
	body.dark-mode .guru-penilaian-page .card-panel,
	body.dark-mode .guru-perkembangan-page .page-header-card,
	body.dark-mode .guru-perkembangan-page .small-box-card,
	body.dark-mode .guru-perkembangan-page .card-panel,
	body.dark-mode .guru-perkembangan-detail-page .page-header-card,
	body.dark-mode .guru-perkembangan-detail-page .small-box-card,
	body.dark-mode .guru-perkembangan-detail-page .card-panel {
		background: #16213e !important;
		color: #e5e7eb !important;
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.24);
		border-color: #28456d !important;
	}

	body.dark-mode .guru-dashboard .card-icon,
	body.dark-mode .guru-dashboard .bg-blue-light,
	body.dark-mode .guru-dashboard .bg-pink-light,
	body.dark-mode .guru-dashboard .bg-gray-light,
	body.dark-mode .guru-penilaian-page .selected-child-header,
	body.dark-mode .guru-penilaian-page .child-list-panel,
	body.dark-mode .guru-penilaian-page .aspect-header,
	body.dark-mode .guru-penilaian-page .import-panel,
	body.dark-mode .guru-penilaian-page .import-actions,
	body.dark-mode .guru-penilaian-page .import-actions .form-control-file,
	body.dark-mode .guru-perkembangan-detail-page .chart-wrap,
	body.dark-mode .guru-anak-page .badge-secondary,
	body.dark-mode .guru-perkembangan-page .badge-secondary,
	body.dark-mode .guru-perkembangan-detail-page .badge-secondary {
		background-color: #1a2c4d !important;
		color: #dbeafe !important;
		border-color: #31537e !important;
	}

	body.dark-mode .guru-dashboard .panel-header,
	body.dark-mode .guru-anak-page .table-header,
	body.dark-mode .guru-penilaian-page .panel-header,
	body.dark-mode .guru-perkembangan-page .panel-header,
	body.dark-mode .guru-perkembangan-detail-page .panel-header,
	body.dark-mode .guru-penilaian-page .child-list-title,
	body.dark-mode .guru-penilaian-page .import-actions-header,
	body.dark-mode .guru-dashboard .clean-table th {
		background: #0f3460 !important;
		color: #f8fafc !important;
		border-color: #28456d !important;
	}

	body.dark-mode .guru-dashboard .page-header-card h2,
	body.dark-mode .guru-dashboard .card-number,
	body.dark-mode .guru-dashboard .substat-value,
	body.dark-mode .guru-dashboard .panel-header h3,
	body.dark-mode .guru-dashboard .sum-value,
	body.dark-mode .guru-anak-page .page-header h2,
	body.dark-mode .guru-anak-page .stat-value,
	body.dark-mode .guru-anak-page .table-header h3,
	body.dark-mode .guru-penilaian-page .page-header-card h2,
	body.dark-mode .guru-penilaian-page .stat-value,
	body.dark-mode .guru-penilaian-page .panel-header h3,
	body.dark-mode .guru-penilaian-page .selected-child-header h4,
	body.dark-mode .guru-penilaian-page .indicator-name,
	body.dark-mode .guru-perkembangan-page .page-header-card h2,
	body.dark-mode .guru-perkembangan-page .small-box-card .value,
	body.dark-mode .guru-perkembangan-page .panel-header h3,
	body.dark-mode .guru-perkembangan-detail-page .page-header-card h2,
	body.dark-mode .guru-perkembangan-detail-page .small-box-card .value,
	body.dark-mode .guru-perkembangan-detail-page .panel-header h3 {
		color: #f8fafc !important;
	}

	body.dark-mode .guru-dashboard .card-label,
	body.dark-mode .guru-dashboard .substat-label,
	body.dark-mode .guru-dashboard .sum-label,
	body.dark-mode .guru-dashboard .btn-link,
	body.dark-mode .guru-anak-page .page-header p,
	body.dark-mode .guru-anak-page .stat-title,
	body.dark-mode .guru-anak-page .table-header span,
	body.dark-mode .guru-penilaian-page .page-header-card p,
	body.dark-mode .guru-penilaian-page .stat-title,
	body.dark-mode .guru-penilaian-page .import-lead,
	body.dark-mode .guru-penilaian-page .import-help-list,
	body.dark-mode .guru-penilaian-page .import-actions-subtitle,
	body.dark-mode .guru-penilaian-page .import-file-help,
	body.dark-mode .guru-penilaian-page .child-meta,
	body.dark-mode .guru-penilaian-page .aspect-header small,
	body.dark-mode .guru-perkembangan-page .page-header-card p,
	body.dark-mode .guru-perkembangan-page .small-box-card .label,
	body.dark-mode .guru-perkembangan-detail-page .small-box-card .label,
	body.dark-mode .guru-perkembangan-detail-page .page-header-card p,
	body.dark-mode .guru-perkembangan-detail-page .page-header-card .text-muted,
	body.dark-mode .guru-perkembangan-detail-page small.text-muted,
	body.dark-mode .guru-anak-page .text-muted,
	body.dark-mode .guru-penilaian-page .text-muted,
	body.dark-mode .guru-perkembangan-page .text-muted,
	body.dark-mode .guru-perkembangan-detail-page .text-muted {
		color: #9fb3c8 !important;
	}

	body.dark-mode .guru-dashboard .clean-table,
	body.dark-mode .guru-dashboard .clean-table td,
	body.dark-mode .guru-dashboard .clean-table th,
	body.dark-mode .guru-anak-page .table,
	body.dark-mode .guru-anak-page .table td,
	body.dark-mode .guru-anak-page .table th,
	body.dark-mode .guru-penilaian-page .table,
	body.dark-mode .guru-penilaian-page .table td,
	body.dark-mode .guru-penilaian-page .table th,
	body.dark-mode .guru-perkembangan-page .table,
	body.dark-mode .guru-perkembangan-page .table td,
	body.dark-mode .guru-perkembangan-page .table th,
	body.dark-mode .guru-perkembangan-detail-page .table,
	body.dark-mode .guru-perkembangan-detail-page .table td,
	body.dark-mode .guru-perkembangan-detail-page .table th {
		color: #e5e7eb !important;
		border-color: #28456d !important;
	}

	body.dark-mode .guru-dashboard .clean-table th,
	body.dark-mode .guru-anak-page .table thead th,
	body.dark-mode .guru-penilaian-page .table thead th,
	body.dark-mode .guru-perkembangan-page .table thead th,
	body.dark-mode .guru-perkembangan-detail-page .table thead th {
		background: #102845 !important;
		color: #dbeafe !important;
	}

	body.dark-mode .guru-dashboard .clean-table tbody tr,
	body.dark-mode .guru-anak-page .table tbody tr,
	body.dark-mode .guru-penilaian-page .table tbody tr,
	body.dark-mode .guru-perkembangan-page .table tbody tr,
	body.dark-mode .guru-perkembangan-detail-page .table tbody tr {
		background: #16213e !important;
	}

	body.dark-mode .guru-dashboard .clean-table tbody tr:hover,
	body.dark-mode .guru-anak-page .table-hover tbody tr:hover,
	body.dark-mode .guru-penilaian-page .table-hover tbody tr:hover,
	body.dark-mode .guru-perkembangan-page .table-hover tbody tr:hover,
	body.dark-mode .guru-perkembangan-detail-page .table-hover tbody tr:hover {
		background: #1a2c4d !important;
	}

	body.dark-mode .guru-penilaian-page .child-item,
	body.dark-mode .guru-penilaian-page .score-radio-item,
	body.dark-mode .guru-dashboard .action-box,
	body.dark-mode .guru-perkembangan-detail-page .btn-outline-secondary,
	body.dark-mode .guru-anak-page .btn-outline-primary {
		background: #1a2c4d;
		color: #dbeafe !important;
		border-color: #31537e !important;
	}

	body.dark-mode .guru-penilaian-page .child-item:hover,
	body.dark-mode .guru-penilaian-page .child-item.active,
	body.dark-mode .guru-dashboard .action-box:hover,
	body.dark-mode .guru-perkembangan-detail-page .btn-outline-secondary:hover,
	body.dark-mode .guru-anak-page .btn-outline-primary:hover {
		background: #21406a !important;
		color: #ffffff !important;
	}

	body.dark-mode .guru-penilaian-page .import-actions,
	body.dark-mode .guru-penilaian-page .import-actions form,
	body.dark-mode .guru-penilaian-page .import-actions .form-group {
		background: #1a2c4d !important;
		color: #dbeafe !important;
	}

	body.dark-mode .guru-penilaian-page .import-actions .form-control-file,
	body.dark-mode .guru-penilaian-page .import-actions .form-control-file::file-selector-button,
	body.dark-mode .guru-penilaian-page .import-actions .form-control-file::-webkit-file-upload-button {
		background-color: #102845 !important;
		color: #e5efff !important;
		border-color: #31537e !important;
	}

	body.dark-mode .guru-penilaian-page .import-actions .form-control-file::file-selector-button,
	body.dark-mode .guru-penilaian-page .import-actions .form-control-file::-webkit-file-upload-button {
		background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
		border: 1px solid #3b82f6 !important;
		box-shadow: none !important;
	}

	body.dark-mode .guru-penilaian-page .import-actions-title,
	body.dark-mode .guru-penilaian-page .import-file-label {
		color: #f8fafc !important;
	}

	body.dark-mode .guru-penilaian-page .score-chip,
	body.dark-mode .guru-penilaian-page .import-badge,
	body.dark-mode .guru-dashboard .badge-blue,
	body.dark-mode .guru-dashboard .badge-pink,
	body.dark-mode .guru-dashboard .badge-green,
	body.dark-mode .guru-dashboard .badge-gray {
		background: rgba(59, 130, 246, 0.18) !important;
		color: #bfdbfe !important;
	}

	body.dark-mode .guru-dashboard .sum-row,
	body.dark-mode .guru-penilaian-page .indicator-row,
	body.dark-mode .guru-perkembangan-detail-page .panel-header,
	body.dark-mode .guru-anak-page .table-header,
	body.dark-mode .guru-penilaian-page .panel-header,
	body.dark-mode .guru-perkembangan-page .panel-header,
	body.dark-mode .guru-perkembangan-detail-page .panel-header {
		border-color: #28456d !important;
	}

	body.dark-mode .guru-penilaian-page .form-control,
	body.dark-mode .guru-perkembangan-page .form-control,
	body.dark-mode .guru-perkembangan-detail-page .form-control,
	body.dark-mode .guru-penilaian-page .custom-select,
	body.dark-mode .guru-perkembangan-page .custom-select,
	body.dark-mode .guru-perkembangan-detail-page .custom-select,
	body.dark-mode .guru-penilaian-page select.form-control,
	body.dark-mode .guru-perkembangan-page select.form-control,
	body.dark-mode .guru-perkembangan-detail-page select.form-control {
		background: #0f1c35 !important;
		color: #e5e7eb !important;
		border-color: #31537e !important;
	}

	body.dark-mode .guru-penilaian-page .form-control:focus,
	body.dark-mode .guru-perkembangan-page .form-control:focus,
	body.dark-mode .guru-perkembangan-detail-page .form-control:focus {
		border-color: #60a5fa !important;
		box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.18) !important;
	}

	body.dark-mode .guru-penilaian-page label,
	body.dark-mode .guru-perkembangan-page label,
	body.dark-mode .guru-perkembangan-detail-page label {
		color: #dbeafe !important;
	}

	body.dark-mode .guru-penilaian-page input::placeholder,
	body.dark-mode .guru-penilaian-page textarea::placeholder,
	body.dark-mode .guru-perkembangan-page input::placeholder,
	body.dark-mode .guru-perkembangan-detail-page input::placeholder {
		color: #7f95ad !important;
	}
</style>

<!-- Theme Toggle Script -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const themeToggle = document.getElementById('theme-toggle');
		const themeIcon = document.getElementById('theme-icon');
		const body = document.body;

		// Deteksi preferensi OS Theme
		const osThemeQuery = window.matchMedia('(prefers-color-scheme: dark)');

		function applyTheme(isDark) {
			if (isDark) {
				body.classList.add('dark-mode');
				themeIcon.classList.remove('fa-moon');
				themeIcon.classList.add('fa-sun');
			} else {
				body.classList.remove('dark-mode');
				themeIcon.classList.remove('fa-sun');
				themeIcon.classList.add('fa-moon');
			}
		}

		// Initial Check
		const savedTheme = localStorage.getItem('theme');
		if (savedTheme) {
			applyTheme(savedTheme === 'dark');
		} else {
			// Berpatokan pada preferensi sistem jika belum pernah diset secara manual
			applyTheme(osThemeQuery.matches);
		}

		// Event listener jika user mengganti tema sistemnya secara live
		osThemeQuery.addEventListener('change', function (e) {
			if (!localStorage.getItem('theme')) {
				applyTheme(e.matches);
			}
		});

		// Toggle theme manual on click
		themeToggle.addEventListener('click', function (e) {
			e.preventDefault();
			const isCurrentlyDark = body.classList.contains('dark-mode');

			if (isCurrentlyDark) {
				applyTheme(false);
				localStorage.setItem('theme', 'light');
			} else {
				applyTheme(true);
				localStorage.setItem('theme', 'dark');
			}
		});
	});
</script>