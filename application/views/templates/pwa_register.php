<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
	(function () {
		if (!('serviceWorker' in navigator)) {
			return;
		}

		var isAdminPage = window.location.pathname.indexOf('/admin') !== -1;

		// Admin area should not be controlled by service worker to avoid
		// navigation/download issues (including PDF export to new tab).
		if (isAdminPage) {
			navigator.serviceWorker.getRegistrations().then(function (registrations) {
				registrations.forEach(function (registration) {
					registration.unregister();
				});
			});
			return;
		}

		window.addEventListener('load', function () {
			navigator.serviceWorker.register('<?php echo base_url('service-worker.js'); ?>');
		});
	})();
</script>