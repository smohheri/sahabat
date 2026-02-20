<!-- Laporan Statistik -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Laporan Statistik Anak Asuh</h3>
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
					<?php
					// Calculate statistics
					$total = count($anak);
					$laki = count(array_filter($anak, function ($a) {
						return $a->jenis_kelamin == 'L';
					}));
					$perempuan = count(array_filter($anak, function ($a) {
						return $a->jenis_kelamin == 'P';
					}));
					$aktif = count(array_filter($anak, function ($a) {
						return $a->status_anak == 'Aktif';
					}));

					// Age groups
					$usia_dibawah5 = 0;
					$usia_5_12 = 0;
					$usia_13_17 = 0;
					$usia_diatas17 = 0;

					foreach ($anak as $a) {
						$usia = date_diff(date_create($a->tanggal_lahir), date_create('today'))->y;
						if ($usia < 5)
							$usia_dibawah5++;
						elseif ($usia <= 12)
							$usia_5_12++;
						elseif ($usia <= 17)
							$usia_13_17++;
						else
							$usia_diatas17++;
					}

					// Education levels
					$pendidikan = array();
					foreach ($anak as $a) {
						$pend = $a->pendidikan;
						if (!isset($pendidikan[$pend]))
							$pendidikan[$pend] = 0;
						$pendidikan[$pend]++;
					}
					?>

					<!-- Summary Cards -->
					<div class="row mb-4">
						<div class="col-md-3">
							<div class="info-box">
								<span class="info-box-icon bg-info"><i class="fas fa-child"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total Anak</span>
									<span class="info-box-number"><?php echo $total; ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="info-box">
								<span class="info-box-icon bg-success"><i class="fas fa-male"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Laki-laki</span>
									<span class="info-box-number"><?php echo $laki; ?>
										(<?php echo $total > 0 ? round(($laki / $total) * 100) : 0; ?>%)</span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="info-box">
								<span class="info-box-icon bg-danger"><i class="fas fa-female"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Perempuan</span>
									<span class="info-box-number"><?php echo $perempuan; ?>
										(<?php echo $total > 0 ? round(($perempuan / $total) * 100) : 0; ?>%)</span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="info-box">
								<span class="info-box-icon bg-primary"><i class="fas fa-check-circle"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Status Aktif</span>
									<span class="info-box-number"><?php echo $aktif; ?></span>
								</div>
							</div>
						</div>
					</div>

					<!-- Charts Row -->
					<div class="row">
						<!-- Gender Chart -->
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Statistik Jenis Kelamin</h3>
								</div>
								<div class="card-body">
									<canvas id="genderChart"
										style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
								</div>
							</div>
						</div>

						<!-- Age Chart -->
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Statistik Usia</h3>
								</div>
								<div class="card-body">
									<canvas id="ageChart"
										style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
								</div>
							</div>
						</div>
					</div>

					<!-- Education Chart -->
					<div class="row mt-4">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Statistik Pendidikan</h3>
								</div>
								<div class="card-body">
									<canvas id="educationChart"
										style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
								</div>
							</div>
						</div>
					</div>

					<!-- Data Table -->
					<div class="row mt-4">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Detail Statistik</h3>
								</div>
								<div class="card-body">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Kategori</th>
												<th>Jumlah</th>
												<th>Persentase</th>
											</tr>
										</thead>
										<tbody>
											<tr class="bg-light">
												<td colspan="3"><strong>Jenis Kelamin</strong></td>
											</tr>
											<tr>
												<td>Laki-laki</td>
												<td><?php echo $laki; ?></td>
												<td><?php echo $total > 0 ? round(($laki / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr>
												<td>Perempuan</td>
												<td><?php echo $perempuan; ?></td>
												<td><?php echo $total > 0 ? round(($perempuan / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr class="bg-light">
												<td colspan="3"><strong>Kelompok Usia</strong></td>
											</tr>
											<tr>
												<td>0-4 tahun (Balita)</td>
												<td><?php echo $usia_dibawah5; ?></td>
												<td><?php echo $total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr>
												<td>5-12 tahun (Anak-anak)</td>
												<td><?php echo $usia_5_12; ?></td>
												<td><?php echo $total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr>
												<td>13-17 tahun (Remaja)</td>
												<td><?php echo $usia_13_17; ?></td>
												<td><?php echo $total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr>
												<td>18+ tahun (Dewasa)</td>
												<td><?php echo $usia_diatas17; ?></td>
												<td><?php echo $total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0; ?>%
												</td>
											</tr>
											<tr class="bg-light">
												<td colspan="3"><strong>Pendidikan</strong></td>
											</tr>
											<?php foreach ($pendidikan as $pend => $jumlah): ?>
												<tr>
													<td><?php echo $pend; ?></td>
													<td><?php echo $jumlah; ?></td>
													<td><?php echo $total > 0 ? round(($jumlah / $total) * 100, 1) : 0; ?>%
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
			</div>
		</div>
	</div>
</div>

<!-- ChartJS -->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>
<script>
	$(function () {
		// Gender Chart
		var genderCtx = document.getElementById('genderChart').getContext('2d');
		new Chart(genderCtx, {
			type: 'doughnut',
			data: {
				labels: ['Laki-laki', 'Perempuan'],
				datasets: [{
					data: [<?php echo $laki; ?>, <?php echo $perempuan; ?>],
					backgroundColor: ['#00a65a', '#f56954']
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
		});

		// Age Chart
		var ageCtx = document.getElementById('ageChart').getContext('2d');
		new Chart(ageCtx, {
			type: 'bar',
			data: {
				labels: ['0-4 th', '5-12 th', '13-17 th', '18+ th'],
				datasets: [{
					label: 'Jumlah Anak',
					data: [<?php echo $usia_dibawah5; ?>, <?php echo $usia_5_12; ?>, <?php echo $usia_13_17; ?>, <?php echo $usia_diatas17; ?>],
					backgroundColor: ['#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}]
				}
			}
		});

		// Education Chart
		var eduCtx = document.getElementById('educationChart').getContext('2d');
		new Chart(eduCtx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode(array_keys($pendidikan)); ?>,
				datasets: [{
					label: 'Jumlah Anak',
					data: <?php echo json_encode(array_values($pendidikan)); ?>,
					backgroundColor: '#007bff'
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}]
				}
			}
		});
	});
</script>