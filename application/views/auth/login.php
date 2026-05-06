<?php $this->load->view('templates/login_header'); ?>
<div class="container-fluid h-100">
	<div class="row h-100">
		<!-- Left Side: App Information -->
		<div class="col-md-6 d-none d-md-flex left-side">
			<div class="info-content">
				<div class="pg-login-space-bottom">
					<img src="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" alt="Logo SAHABAT"
						class="pg-login-app-logo" />
				</div>
				<h1 class="pg-login-title">SAHABAT</h1>
				<h2 class="pg-login-subtitle">Sistem Anak Hebat Berbasis
					Administrasi Terpadu</h2>
				<p class="pg-login-description">
					SAHABAT adalah aplikasi untuk mendukung pengelolaan data anak, administrasi, dan pelaporan secara
					terintegrasi di lingkungan LKSA/organisasi sosial. Tujuannya adalah meningkatkan efisiensi,
					transparansi, dan akurasi data, serta memudahkan akses informasi bagi pengurus dan stakeholder.
				</p>
				<div class="pg-login-space-bottom">
					<span class="pg-login-version-chip">Versi
						<?php echo APP_VERSION; ?></span>
				</div>
				<ul class="pg-login-feature-list">
					<li class="pg-login-feature-item"><i class="fas fa-bullseye pg-login-feature-icon"></i> Tujuan:
						Administrasi
						Terpadu & Efisien</li>
					<li class="pg-login-feature-item"><i class="fas fa-check-circle pg-login-feature-icon"></i> Fitur:
						Manajemen
						Anak, Laporan, Keamanan Data</li>
					<li class="pg-login-feature-item"><i class="fas fa-info-circle pg-login-feature-icon"></i> Untuk:
						Pengurus LKSA
						& Stakeholder</li>
				</ul>
			</div>
		</div>

		<!-- Right Side: Login Form -->
		<div class="col-md-6 right-side">
			<div class="login-box">
				<div class="login-logo mb-4 pg-login-logo-wrap">
					<?php $logo = $settings->logo ?? 'AdminLTELogo.png'; ?>
					<img src="<?php echo base_url('assets/uploads/logos/' . $logo); ?>" alt="Logo LKSA"
						class="pg-login-org-logo">
					<a href="<?php echo base_url(); ?>" class="pg-login-org-link">
						<h2 class="pg-login-org-title">
							<strong><?php echo $settings->nama_lksa ?? 'LKSA Harapan Bangsa'; ?></strong>
						</h2>
					</a>
				</div>

				<div class="card">
					<div class="card-body login-card-body">
						<p class="login-box-msg">Masuk untuk mengakses sistem</p>

						<?php if ($this->session->flashdata('error')): ?>
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('error'); ?>
							</div>
						<?php endif; ?>

						<?php echo form_open('login'); ?>
						<div class="input-group mb-3">
							<?php
							$data = array(
								'name' => 'username',
								'class' => 'form-control',
								'placeholder' => 'Username',
								'value' => set_value('username')
							);
							echo form_input($data);
							?>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						<?php echo form_error('username', '<small class="text-danger">', '</small>'); ?>

						<div class="input-group mb-3">
							<?php
							$data = array(
								'name' => 'password',
								'type' => 'password',
								'class' => 'form-control',
								'placeholder' => 'Password'
							);
							echo form_input($data);
							?>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>

						<div class="input-group mb-3">
							<?php
							$options = array('' => 'Pilih Akses') + ($akses_options ?? array());
							echo form_dropdown('akses', $options, set_value('akses'), 'class="form-control" required');
							?>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user-shield"></span>
								</div>
							</div>
						</div>
						<?php echo form_error('akses', '<small class="text-danger">', '</small>'); ?>

						<div class="row">
							<div class="col-12">
								<button type="submit" class="btn btn-primary-custom btn-block">Masuk</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
<?php $this->load->view('templates/pwa_register'); ?>
</body>

</html>