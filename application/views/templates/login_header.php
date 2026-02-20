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
		html,
		body {
			height: 100%;
			margin: 0;
			padding: 0;
			font-family: 'Source Sans Pro', sans-serif;
		}

		.login-page {
			background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
			height: 100vh;
			display: flex;
			align-items: stretch;
		}

		.container-fluid {
			height: 100%;
		}

		.row {
			height: 100%;
		}

		.left-side {
			background: linear-gradient(135deg, rgba(21, 101, 192, 0.9) 0%, rgba(100, 181, 246, 0.9) 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem;
			color: white;
		}

		.info-content {
			text-align: center;
			max-width: 400px;
		}

		.info-content h1 {
			font-size: 2.5rem;
			font-weight: 300;
			margin-bottom: 0.5rem;
		}

		.info-content h2 {
			font-size: 2rem;
			font-weight: 700;
			margin-bottom: 1.5rem;
			text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
		}

		.info-content p {
			font-size: 1.1rem;
			line-height: 1.6;
			margin-bottom: 2rem;
			opacity: 0.9;
		}

		.features {
			display: flex;
			flex-direction: column;
			gap: 1rem;
		}

		.feature-item {
			display: flex;
			align-items: center;
			font-size: 1rem;
			font-weight: 500;
		}

		.feature-item i {
			margin-right: 0.75rem;
			font-size: 1.2rem;
		}

		.right-side {
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem;
			background: rgba(255, 255, 255, 0.1);
		}

		.login-box {
			width: 100%;
			max-width: 420px;
			animation: fadeInUp 0.8s ease-out;
		}

		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.login-logo h2 {
			font-weight: 700;
			font-size: 2rem;
			text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
			margin-bottom: 1rem;
			text-align: center;
		}

		.card {
			border: none;
			border-radius: 15px;
			overflow: hidden;
			box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
		}

		.login-card-body {
			padding: 2rem;
			border-radius: 15px;
		}

		.login-box-msg {
			font-size: 1.1rem;
			font-weight: 600;
			color: #333;
			margin-bottom: 1.5rem;
			text-align: center;
		}

		.input-group {
			margin-bottom: 1rem;
		}

		.form-control {
			border: 2px solid #e1e5e9;
			border-radius: 8px;
			padding: 0.75rem 1rem;
			font-size: 1rem;
			transition: all 0.3s ease;
		}

		.form-control:focus {
			border-color: #2193b0;
			box-shadow: 0 0 0 0.2rem rgba(33, 147, 176, 0.25);
			transform: translateY(-2px);
		}

		.input-group-text {
			background: #f8f9fa;
			border: 2px solid #e1e5e9;
			border-left: none;
			border-radius: 0 8px 8px 0;
			color: #2193b0;
		}

		.btn-primary {
			background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
			border: none;
			border-radius: 8px;
			padding: 0.75rem 1rem;
			font-size: 1.1rem;
			font-weight: 600;
			transition: all 0.3s ease;
			box-shadow: 0 4px 15px rgba(33, 147, 176, 0.4);
		}

		.btn-primary:hover {
			background: linear-gradient(135deg, #1c7a8c 0%, #5bb8cc 100%);
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(33, 147, 176, 0.6);
		}

		.alert {
			border-radius: 8px;
			border: none;
		}

		.text-danger {
			font-weight: 500;
		}

		@media (max-width: 768px) {
			.left-side {
				display: none;
			}

			.right-side {
				padding: 1rem;
			}

			.login-logo h2 {
				font-size: 1.8rem;
			}
		}
	</style>
</head>

<body class="hold-transition login-page">