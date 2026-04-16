<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
	(function () {
		if (!('serviceWorker' in navigator)) {
			return;
		}

		var pathname = window.location.pathname || '';
		var isPanelPage = pathname.indexOf('/admin') !== -1 || pathname.indexOf('/guru') !== -1;

		// Admin & Guru area should not be controlled by service worker to avoid
		// stale navigation and download issues.
		if (isPanelPage) {
			navigator.serviceWorker.getRegistrations().then(function (registrations) {
				registrations.forEach(function (registration) {
					registration.unregister();
				});
				if (window.caches && typeof window.caches.keys === 'function') {
					window.caches.keys().then(function (keys) {
						keys.forEach(function (key) {
							if (key.indexOf('sahabat-pwa-') === 0) {
								window.caches.delete(key);
							}
						});
					});
				}
			});
			return;
		}

		window.addEventListener('load', function () {
			navigator.serviceWorker.register('<?php echo base_url('service-worker.js'); ?>');
		});
	})();
</script>