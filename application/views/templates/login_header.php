<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?? 'Login'; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" />
    <?php $this->load->view('templates/pwa_head'); ?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">

    <!-- Theme and shared styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/landing.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/panel-global.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login-template.css'); ?>">
</head>

<body class="hold-transition login-page">