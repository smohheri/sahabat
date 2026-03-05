<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
(function () {
	if (!('serviceWorker' in navigator)) {
		return;
	}

	window.addEventListener('load', function () {
		navigator.serviceWorker.register('<?php echo base_url('service-worker.js'); ?>');
	});
})();
</script>