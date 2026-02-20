<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?? 'AdminLTE 4'; ?></title>

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

<body class="hold-transition sidebar-mini layout-fixed">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="<?php echo base_url('assets/img/AdminLTELogo.png'); ?>" alt="AdminLTELogo"
			height="60" width="60">
	</div>