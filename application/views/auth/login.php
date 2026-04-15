<?php $this->load->view('templates/login_header'); ?>
<div class="container-fluid h-100">
	<div class="row h-100">
		<!-- Left Side: App Information -->
		<div class="col-md-6 d-none d-md-flex left-side">
			<div class="info-content">
				<div style="margin-bottom:1.5rem;">
					<img src="<?php echo base_url('assets/img/logo_sahabat.png'); ?>" alt="Logo SAHABAT"
						style="width:120px;height:120px;border-radius:20px;box-shadow:0 4px 16px rgba(122,198,77,0.15);background:#fff;object-fit:contain;" />
				</div>
				<h1 style="font-size:2.5rem;font-weight:700;letter-spacing:1px;color:#fff;">SAHABAT</h1>
				<h2 style="font-size:1.3rem;font-weight:400;margin-bottom:1.2rem;color:#fff;">Sistem Anak Hebat Berbasis
					Administrasi Terpadu</h2>
				<p style="font-size:1.1rem;line-height:1.6;margin-bottom:1.5rem;opacity:0.95;color:#fff;">
					SAHABAT adalah aplikasi untuk mendukung pengelolaan data anak, administrasi, dan pelaporan secara
					terintegrasi di lingkungan LKSA/organisasi sosial. Tujuannya adalah meningkatkan efisiensi,
					transparansi, dan akurasi data, serta memudahkan akses informasi bagi pengurus dan stakeholder.
				</p>
				<div style="margin-bottom:1.5rem;">
					<span
						style="display:inline-block;background:#8ED45E;color:#2C3E50;padding:6px 18px;border-radius:20px;font-weight:600;font-size:1rem;">Versi
						<?php echo APP_VERSION; ?></span>
				</div>
				<ul style="list-style:none;padding:0;text-align:left;max-width:350px;margin:0 auto;">
					<li style="margin-bottom:0.7rem;display:flex;align-items:center;color:#fff;"><i
							class="fas fa-bullseye" style="margin-right:0.7rem;color:#fff;"></i> Tujuan: Administrasi
						Terpadu & Efisien</li>
					<li style="margin-bottom:0.7rem;display:flex;align-items:center;color:#fff;"><i
							class="fas fa-check-circle" style="margin-right:0.7rem;color:#fff;"></i> Fitur: Manajemen
						Anak, Laporan, Keamanan Data</li>
					<li style="margin-bottom:0.7rem;display:flex;align-items:center;color:#fff;"><i
							class="fas fa-info-circle" style="margin-right:0.7rem;color:#fff;"></i> Untuk: Pengurus LKSA
						& Stakeholder</li>
				</ul>
			</div>
		</div>

		<!-- Right Side: Login Form -->
		<div class="col-md-6 right-side">
			<div class="login-box">
				<div class="login-logo mb-4" style="display:flex;flex-direction:column;align-items:center;">
					<?php $logo = $settings->logo ?? 'AdminLTELogo.png'; ?>
					<img src="<?php echo base_url('assets/uploads/logos/' . $logo); ?>" alt="Logo LKSA"
						style="width:64px;height:64px;border-radius:12px;object-fit:contain;margin-bottom:10px;background:#fff;box-shadow:0 2px 8px rgba(44,62,80,0.08);">
					<a href="<?php echo base_url(); ?>" style="color:#2C3E50;text-decoration:none;">
						<h2 style="font-weight:700;font-size:2rem;color:#2C3E50;">
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