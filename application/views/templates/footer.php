<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
	<strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">LKSA Harapan Bangsa</a>.</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 1.0.0
	</div>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/js/adminlte.min.js'); ?>"></script>

<!-- Custom JS -->
<?php if (isset($custom_js)): ?>
	<?php foreach ($custom_js as $js): ?>
		<script src="<?php echo base_url('assets/js/' . $js); ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>

<!-- Plugin JS -->
<?php if (isset($plugin_js)): ?>
	<?php foreach ($plugin_js as $js): ?>
		<script src="<?php echo base_url('assets/plugins/' . $js); ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>

</body>

</html>