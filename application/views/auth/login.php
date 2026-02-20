<?php $this->load->view('templates/login_header'); ?>
<div class="login-box">
	<div class="login-logo mb-4">
		<a href="<?php echo base_url(); ?>" class="text-white">
			<h2><strong>LKSA Harapan Bangsa</strong></h2>
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

			<?php echo form_open('auth/login'); ?>
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

			<div class="row">
				<div class="col-12">
					<button type="submit" class="btn btn-primary btn-block">Masuk</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>
</body>

</html>