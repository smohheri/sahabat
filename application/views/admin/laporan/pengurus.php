<!-- Laporan Pengurus -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Laporan Data Pengurus & Karyawan</h3>
					<div class="card-tools">
						<a href="<?php echo site_url('admin/export_pdf_pengurus'); ?>" class="btn btn-success btn-sm"
							target="_blank">
							<i class="fas fa-file-pdf"></i> Export PDF
						</a>
						<a href="<?php echo site_url('admin/export_excel_pengurus'); ?>" class="btn btn-primary btn-sm">
							<i class="fas fa-file-excel"></i> Export Excel
						</a>
					</div>

				</div>
				<div class="card-body">
					<!-- Summary -->
					<div class="row mb-3">
						<div class="col-md-4">
							<div class="small-box bg-primary">
								<div class="inner">
									<h3><?php echo count($pengurus); ?></h3>
									<p>Total Pengurus</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-tie"></i>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="small-box bg-success">
								<div class="inner">
									<h3><?php echo count(array_filter($pengurus, function ($p) {
										return !empty($p->file_ktp);
									})); ?>
									</h3>
									<p>Sudah Upload KTP</p>
								</div>
								<div class="icon">
									<i class="fas fa-id-card"></i>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo count(array_filter($pengurus, function ($p) {
										return empty($p->file_ktp);
									})); ?>
									</h3>
									<p>Belum Upload KTP</p>
								</div>
								<div class="icon">
									<i class="fas fa-exclamation-triangle"></i>
								</div>
							</div>
						</div>
					</div>

					<!-- Data Table -->
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Pengurus</th>
								<th>Jabatan</th>
								<th>No HP</th>
								<th>Email</th>
								<th>Status KTP</th>
								<th>Tanggal Bergabung</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($pengurus as $p): ?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $p->nama_pengurus; ?></td>
									<td><?php echo $p->jabatan; ?></td>
									<td><?php echo $p->no_hp; ?></td>
									<td><?php echo $p->email ?: '-'; ?></td>
									<td>
										<?php if (!empty($p->file_ktp)): ?>
											<span class="badge badge-success">Ada</span>
										<?php else: ?>
											<span class="badge badge-danger">Belum</span>
										<?php endif; ?>
									</td>
									<td><?php echo date('d-m-Y', strtotime($p->created_at)); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Struktur Organisasi Placeholder -->
					<div class="mt-4">
						<h4>Struktur Organisasi</h4>
						<div class="alert alert-info">
							<i class="fas fa-info-circle"></i>
							Fitur diagram struktur organisasi akan ditambahkan di kemudian hari.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>