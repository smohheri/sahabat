<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?? 'AdminLTE 4'; ?></title>

	<!-- Favicon - Menggunakan logo dari pengaturan -->
	<?php
	$logo = $this->config->item('settings')->logo ?? null;
	$favicon_url = !empty($logo)
		? base_url('assets/uploads/logos/' . $logo)
		: base_url('assets/img/AdminLTELogo.png');
	?>
	<link rel="icon" type="image/png" href="<?php echo $favicon_url; ?>">

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">

	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">

	<!-- Custom CSS -->
	<?php if (isset($custom_css)): ?>
		<?php foreach ($custom_css as $css): ?>
			<link rel="stylesheet" href="<?php echo base_url('assets/css/' . $css); ?>">
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if (isset($plugin_css)): ?>
		<?php foreach ($plugin_css as $css): ?>
			<link rel="stylesheet" href="<?php echo base_url('assets/plugins/' . $css); ?>">
		<?php endforeach; ?>
	<?php endif; ?>
</head>

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

<!-- Chart.js -->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>

<!-- Theme Initialization Script - Must run before page loads -->
<script>
	// Apply saved theme immediately to prevent flash
	(function () {
		const savedTheme = localStorage.getItem('theme');
		if (savedTheme === 'dark') {
			document.write('<style>body { background-color: #1a1a2e !important; }</style>');
		}
	})();
</script>

<body class="hold-transition sidebar-mini layout-fixed" id="main-body">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="<?php echo $favicon_url; ?>"
			alt="<?php echo $this->config->item('settings')->nama_lksa ?? 'AdminLTE'; ?>" height="60" width="60">
	</div>