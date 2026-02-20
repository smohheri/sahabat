<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?? 'Login'; ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">

	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">

	<style>
		.login-page {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.login-box {
			width: 400px;
		}

		.login-card-body {
			border-radius: 10px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
		}

		.btn-primary {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			border: none;
		}

		.btn-primary:hover {
			background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
		}
	</style>
</head>

<body class="hold-transition login-page">