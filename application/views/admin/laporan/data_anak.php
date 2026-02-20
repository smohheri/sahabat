<!-- Laporan Data Anak -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Laporan Data Anak Asuh</h3>
					<div class="card-tools">
						<a href="<?php echo site_url('admin/export_pdf_anak'); ?>" class="btn btn-success btn-sm"
							target="_blank">
							<i class="fas fa-file-pdf"></i> Export PDF
						</a>
						<a href="<?php echo site_url('admin/export_excel_anak'); ?>" class="btn btn-primary btn-sm">
							<i class="fas fa-file-excel"></i> Export Excel
						</a>
					</div>

				</div>
				<div class="card-body">
					<!-- Filter Section -->
					<div class="row mb-3">
						<div class="col-md-3">
							<select class="form-control" id="filterStatus">
								<option value="">Semua Status</option>
								<option value="Aktif">Aktif</option>
								<option value="Non Aktif">Non Aktif</option>
							</select>
						</div>
						<div class="col-md-3">
							<select class="form-control" id="filterJenisKelamin">
								<option value="">Semua Jenis Kelamin</option>
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="filterUsia" placeholder="Usia (tahun)">
						</div>
						<div class="col-md-3">
							<button class="btn btn-info btn-block" onclick="filterData()">
								<i class="fas fa-filter"></i> Filter
							</button>
						</div>
					</div>

					<!-- Summary Cards -->
					<div class="row mb-3">
						<div class="col-md-3">
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo count($anak); ?></h3>
									<p>Total Anak</p>
								</div>
								<div class="icon">
									<i class="fas fa-child"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-success">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return $a->status_anak == 'Aktif';
									})); ?>
									</h3>
									<p>Anak Aktif</p>
								</div>
								<div class="icon">
									<i class="fas fa-check-circle"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-warning">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return $a->jenis_kelamin == 'L';
									})); ?>
									</h3>
									<p>Laki-laki</p>
								</div>
								<div class="icon">
									<i class="fas fa-male"></i>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="small-box bg-danger">
								<div class="inner">
									<h3><?php echo count(array_filter($anak, function ($a) {
										return $a->jenis_kelamin == 'P';
									})); ?>
									</h3>
									<p>Perempuan</p>
								</div>
								<div class="icon">
									<i class="fas fa-female"></i>
								</div>
							</div>
						</div>
					</div>

					<!-- Data Table -->
					<table class="table table-bordered table-striped" id="tableLaporanAnak">
						<thead>
							<tr>
								<th>No</th>
								<th>NIK</th>
								<th>Nama Anak</th>
								<th>Jenis Kelamin</th>
								<th>Tempat/Tgl Lahir</th>
								<th>Usia</th>
								<th>Pendidikan</th>
								<th>Status</th>
								<th>Tanggal Masuk</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($anak as $a):
								$usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;
								?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $a->nik ?: '-'; ?></td>
									<td><?php echo $a->nama_anak; ?></td>
									<td><?php echo $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
									<td><?php echo $a->tempat_lahir . ', ' . date('d-m-Y', strtotime($a->tanggal_lahir)); ?>
									</td>
									<td><?php echo $usia; ?> tahun</td>
									<td><?php echo $a->pendidikan; ?></td>
									<td>
										<span
											class="badge badge-<?php echo $a->status_anak == 'Aktif' ? 'success' : 'secondary'; ?>">
											<?php echo $a->status_anak; ?>
										</span>
									</td>
									<td><?php echo date('d-m-Y', strtotime($a->tanggal_masuk)); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function filterData() {
		// Implement filter logic here
		alert('Filter functionality will be implemented');
	}
</script>