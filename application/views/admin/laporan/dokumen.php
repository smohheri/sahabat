<!-- Laporan Dokumen -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Laporan Kelengkapan Dokumen Anak</h3>
					<div class="card-tools">
						<a href="<?php echo site_url('admin/export_pdf_dokumen'); ?>" class="btn btn-success btn-sm"
							target="_blank">
							<i class="fas fa-file-pdf"></i> Export PDF
						</a>
						<a href="<?php echo site_url('admin/export_excel_dokumen'); ?>" class="btn btn-primary btn-sm">
							<i class="fas fa-file-excel"></i> Export Excel
						</a>
					</div>

				</div>
				<div class="card-body">
					<!-- Summary Cards -->
					<div class="row mb-3">
						<div class="col-md-3">
							<div class="small-box bg-success">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return !empty($a->file_kk);
									})); ?>
									</h3>
									<p>Punya KK</p>
								</div>
								<div class="icon">
									<i class="fas fa-file-alt"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return !empty($a->file_akta);
									})); ?>
									</h3>
									<p>Punya Akta</p>
								</div>
								<div class="icon">
									<i class="fas fa-certificate"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return !empty($a->file_pendukung);
									})); ?>
									</h3>
									<p>Dokumen Pendukung</p>
								</div>
								<div class="icon">
									<i class="fas fa-folder-open"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-danger">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return empty($a->file_kk) || empty($a->file_akta);
									})); ?>
									</h3>
									<p>Dokumen Kurang</p>
								</div>
								<div class="icon">
									<i class="fas fa-exclamation-circle"></i>
								</div>
							</div>
						</div>
					</div>

					<!-- Progress Bar -->
					<div class="card mb-3">
						<div class="card-header">
							<h5>Progress Kelengkapan Dokumen</h5>
						</div>
						<div class="card-body">
							<?php
							$total = count($anak);
							$punya_kk = count(array_filter($anak, function ($a) {
								return !empty($a->file_kk);
							}));
							$punya_akta = count(array_filter($anak, function ($a) {
								return !empty($a->file_akta);
							}));
							$punya_pendukung = count(array_filter($anak, function ($a) {
								return !empty($a->file_pendukung);
							}));

							$persen_kk = $total > 0 ? round(($punya_kk / $total) * 100) : 0;
							$persen_akta = $total > 0 ? round(($punya_akta / $total) * 100) : 0;
							$persen_pendukung = $total > 0 ? round(($punya_pendukung / $total) * 100) : 0;
							?>
							<div class="mb-3">
								<label>Kartu Keluarga (KK)</label>
								<div class="progress">
									<div class="progress-bar bg-success" style="width: <?php echo $persen_kk; ?>%">
										<?php echo $persen_kk; ?>%
									</div>
								</div>
								<small><?php echo $punya_kk; ?> dari <?php echo $total; ?> anak</small>
							</div>
							<div class="mb-3">
								<label>Akta Kelahiran</label>
								<div class="progress">
									<div class="progress-bar bg-info" style="width: <?php echo $persen_akta; ?>%">
										<?php echo $persen_akta; ?>%
									</div>
								</div>
								<small><?php echo $punya_akta; ?> dari <?php echo $total; ?> anak</small>
							</div>
							<div class="mb-3">
								<label>Dokumen Pendukung</label>
								<div class="progress">
									<div class="progress-bar bg-warning"
										style="width: <?php echo $persen_pendukung; ?>%">
										<?php echo $persen_pendukung; ?>%
									</div>
								</div>
								<small><?php echo $punya_pendukung; ?> dari <?php echo $total; ?> anak</small>
							</div>
						</div>
					</div>

					<!-- Data Table -->
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Anak</th>
								<th>NIK</th>
								<th>KK</th>
								<th>Akta</th>
								<th>Pendukung</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($anak as $a):
								$lengkap = !empty($a->file_kk) && !empty($a->file_akta);
								?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $a->nama_anak; ?></td>
									<td><?php echo $a->nik ?: '-'; ?></td>
									<td class="text-center">
										<?php if (!empty($a->file_kk)): ?>
											<span class="badge badge-success"><i class="fas fa-check"></i> Ada</span>
										<?php else: ?>
											<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php if (!empty($a->file_akta)): ?>
											<span class="badge badge-success"><i class="fas fa-check"></i> Ada</span>
										<?php else: ?>
											<span class="badge badge-danger"><i class="fas fa-times"></i> Belum</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php if (!empty($a->file_pendukung)): ?>
											<span class="badge badge-success"><i class="fas fa-check"></i> Ada</span>
										<?php else: ?>
											<span class="badge badge-secondary"><i class="fas fa-minus"></i> -</span>
										<?php endif; ?>
									</td>
									<td class="text-center">
										<?php if ($lengkap): ?>
											<span class="badge badge-success">Lengkap</span>
										<?php else: ?>
											<span class="badge badge-warning">Kurang</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>