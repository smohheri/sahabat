<!-- Laporan Statistik - Redesain Modern -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-red">
				<i class="fas fa-chart-pie"></i>
			</div>
			<div>
				<h2>Laporan Statistik</h2>
				<p>Visualisasi data dan statistik anak asuh</p>
			</div>
		</div>
		<div class="header-actions">
			<button type="button" class="btn btn-export-pdf" id="exportPdfBtn">
				<i class="fas fa-file-pdf"></i> Export PDF
			</button>
		</div>
	</div>

	<?php
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

	$pendidikan = array();
	foreach ($anak as $a) {
		$pend = $a->pendidikan;
		if (!isset($pendidikan[$pend]))
			$pendidikan[$pend] = 0;
		$pendidikan[$pend]++;
	}
	?>

	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-users"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total; ?></span>
				<span class="stat-label">Total Anak</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-male"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $laki; ?>
					<small>(<?php echo $total > 0 ? round(($laki / $total) * 100) : 0; ?>%)</small></span>
				<span class="stat-label">Laki-laki</span>
			</div>
		</div>

		<div class="stat-card stat-pink">
			<div class="stat-icon">
				<i class="fas fa-female"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $perempuan; ?>
					<small>(<?php echo $total > 0 ? round(($perempuan / $total) * 100) : 0; ?>%)</small></span>
				<span class="stat-label">Perempuan</span>
			</div>
		</div>

		<div class="stat-card stat-purple">
			<div class="stat-icon">
				<i class="fas fa-check-circle"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $aktif; ?></span>
				<span class="stat-label">Status Aktif</span>
			</div>
		</div>
	</div>

	<div class="charts-grid">
		<div class="chart-card">
			<div class="chart-header">
				<h3><i class="fas fa-chart-pie"></i> Statistik Jenis Kelamin</h3>
			</div>
			<div class="chart-body">
				<canvas id="genderChart"></canvas>
			</div>
		</div>

		<div class="chart-card">
			<div class="chart-header">
				<h3><i class="fas fa-chart-bar"></i> Statistik Usia</h3>
			</div>
			<div class="chart-body">
				<canvas id="ageChart"></canvas>
			</div>
		</div>
	</div>

	<div class="chart-card-full">
		<div class="chart-header">
			<h3><i class="fas fa-graduation-cap"></i> Statistik Pendidikan</h3>
		</div>
		<div class="chart-body">
			<canvas id="educationChart"></canvas>
		</div>
	</div>

	<div class="data-panel mt-4">
		<div class="panel-header">
			<h3><i class="fas fa-table"></i> Detail Statistik</h3>
		</div>
		<div class="panel-body">
			<table class="data-table">
				<thead>
					<tr>
						<th>Kategori</th>
						<th>Jumlah</th>
						<th>Persentase</th>
					</tr>
				</thead>
				<tbody>
					<tr class="table-subheader">
						<td colspan="3"><i class="fas fa-venus-mars"></i> Jenis Kelamin</td>
					</tr>
					<tr>
						<td><span class="badge-jk badge-blue">L</span> Laki-laki</td>
						<td><?php echo $laki; ?></td>
						<td><?php echo $total > 0 ? round(($laki / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr>
						<td><span class="badge-jk badge-pink">P</span> Perempuan</td>
						<td><?php echo $perempuan; ?></td>
						<td><?php echo $total > 0 ? round(($perempuan / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr class="table-subheader">
						<td colspan="3"><i class="fas fa-birthday-cake"></i> Kelompok Usia</td>
					</tr>
					<tr>
						<td>0-4 tahun (Balita)</td>
						<td><?php echo $usia_dibawah5; ?></td>
						<td><?php echo $total > 0 ? round(($usia_dibawah5 / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr>
						<td>5-12 tahun (Anak-anak)</td>
						<td><?php echo $usia_5_12; ?></td>
						<td><?php echo $total > 0 ? round(($usia_5_12 / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr>
						<td>13-17 tahun (Remaja)</td>
						<td><?php echo $usia_13_17; ?></td>
						<td><?php echo $total > 0 ? round(($usia_13_17 / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr>
						<td>18+ tahun (Dewasa)</td>
						<td><?php echo $usia_diatas17; ?></td>
						<td><?php echo $total > 0 ? round(($usia_diatas17 / $total) * 100, 1) : 0; ?>%</td>
					</tr>
					<tr class="table-subheader">
						<td colspan="3"><i class="fas fa-graduation-cap"></i> Pendidikan</td>
					</tr>
					<?php foreach ($pendidikan as $pend => $jumlah): ?>
						<tr>
							<td><?php echo $pend; ?></td>
							<td><?php echo $jumlah; ?></td>
							<td><?php echo $total > 0 ? round(($jumlah / $total) * 100, 1) : 0; ?>%</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(function () {
		// Gender Chart (Doughnut) - Legend ada di bawah
		var genderCtx = document.getElementById('genderChart').getContext('2d');
		new Chart(genderCtx, {
			type: 'doughnut',
			data: {
				labels: ['Laki-laki', 'Perempuan'],
				datasets: [{
					data: [<?php echo $laki; ?>, <?php echo $perempuan; ?>],
					backgroundColor: ['#4e73df', '#e83e8c'],
					borderWidth: 0
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						position: 'bottom',
						labels: {
							padding: 15,
							usePointStyle: true,
							pointStyle: 'circle'
						}
					},
					title: {
						display: true,
						text: 'Jenis Kelamin',
						padding: {
							bottom: 10
						}
					}
				}
			}
		});

		// Age Chart (Bar) - Legend ditambahkan
		var ageCtx = document.getElementById('ageChart').getContext('2d');
		new Chart(ageCtx, {
			type: 'bar',
			data: {
				labels: ['0-4 th', '5-12 th', '13-17 th', '18+ th'],
				datasets: [{
					label: 'Jumlah Anak',
					data: [<?php echo $usia_dibawah5; ?>, <?php echo $usia_5_12; ?>, <?php echo $usia_13_17; ?>, <?php echo $usia_diatas17; ?>],
					backgroundColor: ['#f6c23e', '#4e73df', '#6f42c1', '#95a5a6'],
					borderWidth: 0
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							padding: 15,
							usePointStyle: true,
							pointStyle: 'rect'
						}
					},
					title: {
						display: true,
						text: 'Usia',
						padding: {
							bottom: 10
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: { stepSize: 1 }
					}
				}
			}
		});

		// Education Chart (Bar) - Legend ditambahkan
		var eduCtx = document.getElementById('educationChart').getContext('2d');
		new Chart(eduCtx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode(array_keys($pendidikan)); ?>,
				datasets: [{
					label: 'Jumlah Anak',
					data: <?php echo json_encode(array_values($pendidikan)); ?>,
					backgroundColor: '#1cc88a',
					borderWidth: 0
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							padding: 15,
							usePointStyle: true,
							pointStyle: 'rect'
						}
					},
					title: {
						display: true,
						text: 'Pendidikan',
						padding: {
							bottom: 10
						}
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: { stepSize: 1 }
					}
				}
			}
		});
	});

	$('#exportPdfBtn').on('click', function () {
		// Show loading indicator
		$('#exportPdfBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');

		setTimeout(function () {
			var genderImg = document.getElementById('genderChart').toDataURL('image/png');
			var ageImg = document.getElementById('ageChart').toDataURL('image/png');
			var educationImg = document.getElementById('educationChart').toDataURL('image/png');

			$.ajax({
				url: '<?php echo site_url('admin/generate_pdf_statistik'); ?>',
				method: 'POST',
				data: {
					genderChart: genderImg,
					ageChart: ageImg,
					educationChart: educationImg,
					total: <?php echo $total; ?>,
					laki: <?php echo $laki; ?>,
					perempuan: <?php echo $perempuan; ?>,
					aktif: <?php echo $aktif; ?>,
					usia_dibawah5: <?php echo $usia_dibawah5; ?>,
					usia_5_12: <?php echo $usia_5_12; ?>,
					usia_13_17: <?php echo $usia_13_17; ?>,
					usia_diatas17: <?php echo $usia_diatas17; ?>,
					pendidikan: JSON.stringify(<?php echo json_encode($pendidikan); ?>)
				},
				success: function (response) {
					var result = JSON.parse(response);
					if (result.success) {
						var pdfUrl = '<?php echo base_url('assets/temp/'); ?>' + result.filename;

						// Open PDF in new tab
						var pdfWindow = window.open(pdfUrl, '_blank');

						// Delete temp file after download (delayed)
						setTimeout(function () {
							$.ajax({
								url: '<?php echo site_url('admin/delete_temp_file'); ?>',
								method: 'POST',
								data: {
									filename: result.filename
								},
								success: function (deleteResponse) {
									console.log('Temp file deleted');
								},
								error: function () {
									console.log('Failed to delete temp file');
								}
							});
						}, 3000); // Wait 3 seconds before deleting
					} else {
						alert('Gagal generate PDF. Silakan coba lagi.');
					}
					$('#exportPdfBtn').prop('disabled', false).html('<i class="fas fa-file-pdf"></i> Export PDF');
				},
				error: function () {
					alert('Gagal generate PDF. Silakan coba lagi.');
					$('#exportPdfBtn').prop('disabled', false).html('<i class="fas fa-file-pdf"></i> Export PDF');
				}
			});
		}, 500);
	});
</script>

<style>
	.laporan-page {
		padding: 10px;
	}

	.page-header {
		background: #fff;
		border-radius: 16px;
		padding: 25px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.header-info {
		display: flex;
		align-items: center;
		gap: 20px;
	}

	.header-icon {
		width: 60px;
		height: 60px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26px;
	}

	.bg-red {
		background: rgba(231, 74, 59, 0.1);
		color: #e74a3b;
	}

	.header-info h2 {
		margin: 0 0 5px;
		font-size: 22px;
		font-weight: 600;
		color: #2d3748;
	}

	.header-info p {
		margin: 0;
		color: #718096;
		font-size: 14px;
	}

	.header-actions {
		display: flex;
		gap: 12px;
	}

	.btn-export-pdf {
		padding: 10px 20px;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
		transition: all 0.3s ease;
		cursor: pointer;
		border: none;
		background: #e74a3b;
		color: #fff;
	}

	.btn-export-pdf:hover {
		background: #c0392b;
	}

	.btn-export-pdf:disabled {
		background: #95a5a6;
		cursor: not-allowed;
	}

	.stats-row {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.stat-card {
		background: #fff;
		border-radius: 14px;
		padding: 22px;
		display: flex;
		align-items: center;
		gap: 18px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		transition: all 0.3s ease;
	}

	.stat-card:hover {
		transform: translateY(-3px);
		box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
	}

	.stat-icon {
		width: 55px;
		height: 55px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	.stat-blue .stat-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.stat-pink .stat-icon {
		background: rgba(232, 62, 140, 0.1);
		color: #e83e8c;
	}

	.stat-purple .stat-icon {
		background: rgba(111, 66, 193, 0.1);
		color: #6f42c1;
	}

	.stat-info {
		display: flex;
		flex-direction: column;
	}

	.stat-number {
		font-size: 28px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.stat-number small {
		font-size: 14px;
		font-weight: 400;
		color: #718096;
	}

	.stat-label {
		font-size: 13px;
		color: #718096;
		margin-top: 5px;
	}

	.charts-grid {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 25px;
		margin-bottom: 25px;
	}

	.chart-card,
	.chart-card-full {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.chart-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
	}

	.chart-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.chart-header i {
		color: #e74a3b;
	}

	.chart-body {
		padding: 25px;
		height: 300px;
	}

	.chart-card-full .chart-body {
		height: 250px;
	}

	.data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.panel-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
	}

	.panel-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.panel-header i {
		color: #e74a3b;
	}

	.panel-body {
		padding: 0;
	}

	.data-table {
		width: 100%;
		border-collapse: collapse;
	}

	.data-table th {
		padding: 15px 20px;
		text-align: left;
		font-size: 12px;
		font-weight: 600;
		color: #718096;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		background: #f8fafc;
		border-bottom: 1px solid #e2e8f0;
	}

	.data-table td {
		padding: 14px 20px;
		border-bottom: 1px solid #edf2f7;
		vertical-align: middle;
		font-size: 14px;
		color: #2d3748;
	}

	.data-table tbody tr:hover {
		background: #f8fafc;
	}

	.table-subheader {
		background: #f8fafc !important;
	}

	.table-subheader td {
		font-weight: 600;
		color: #4a5568;
		font-size: 13px;
	}

	.table-subheader i {
		margin-right: 8px;
		color: #4e73df;
	}

	.badge-jk {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 24px;
		height: 24px;
		border-radius: 50%;
		font-size: 11px;
		font-weight: 600;
		margin-right: 8px;
	}

	.badge-blue {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.badge-pink {
		background: rgba(232, 62, 140, 0.1);
		color: #e83e8c;
	}

	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.charts-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 768px) {
		.page-header {
			flex-direction: column;
			gap: 20px;
			text-align: center;
		}

		.header-info {
			flex-direction: column;
		}

		.stats-row {
			grid-template-columns: 1fr;
		}
	}

	body.dark-mode .laporan-page {
		background-color: #1a1a2e;
	}

	body.dark-mode .page-header {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .header-info h2 {
		color: #e0e0e0;
	}

	body.dark-mode .header-info p {
		color: #a0a0a0;
	}

	body.dark-mode .stat-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .stat-number {
		color: #e0e0e0;
	}

	body.dark-mode .stat-number small {
		color: #a0a0a0;
	}

	body.dark-mode .stat-label {
		color: #a0a0a0;
	}

	body.dark-mode .chart-card,
	body.dark-mode .chart-card-full {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .chart-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .chart-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .data-panel {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .panel-header {
		border-bottom-color: #0f3460;
	}

	body.dark-mode .panel-header h3 {
		color: #e0e0e0;
	}

	body.dark-mode .data-table {
		color: #e0e0e0;
	}

	body.dark-mode .data-table th {
		background-color: #0f3460;
		color: #e0e0e0;
		border-bottom-color: #0f3460;
	}

	body.dark-mode .data-table td {
		border-bottom-color: #0f3460;
		color: #e0e0e0;
	}

	body.dark-mode .data-table tbody tr:hover {
		background-color: #0f3460 !important;
	}

	body.dark-mode .table-subheader {
		background-color: #0f3460 !important;
	}

	body.dark-mode .table-subheader td {
		color: #e0e0e0;
	}
</style>