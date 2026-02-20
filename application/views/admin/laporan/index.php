<!-- Default Laporan View -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Kelola Laporan LKSA</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-3">
							<a href="<?php echo site_url('admin/laporan/data_anak'); ?>"
								class="btn btn-info btn-block btn-lg">
								<i class="fas fa-child fa-2x mb-2"></i><br>
								Laporan Data Anak
							</a>
						</div>
						<div class="col-md-4 mb-3">
							<a href="<?php echo site_url('admin/laporan/keuangan'); ?>"
								class="btn btn-success btn-block btn-lg">
								<i class="fas fa-money-bill-wave fa-2x mb-2"></i><br>
								Laporan Keuangan
							</a>
						</div>
						<div class="col-md-4 mb-3">
							<a href="<?php echo site_url('admin/laporan/pengurus'); ?>"
								class="btn btn-primary btn-block btn-lg">
								<i class="fas fa-user-tie fa-2x mb-2"></i><br>
								Laporan Pengurus
							</a>
						</div>
						<div class="col-md-4 mb-3">
							<a href="<?php echo site_url('admin/laporan/dokumen'); ?>"
								class="btn btn-warning btn-block btn-lg">
								<i class="fas fa-folder-open fa-2x mb-2"></i><br>
								Laporan Dokumen
							</a>
						</div>
						<div class="col-md-4 mb-3">
							<a href="<?php echo site_url('admin/laporan/statistik'); ?>"
								class="btn btn-danger btn-block btn-lg">
								<i class="fas fa-chart-pie fa-2x mb-2"></i><br>
								Laporan Statistik
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>