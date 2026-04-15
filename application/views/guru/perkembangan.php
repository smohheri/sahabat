<div class="guru-perkembangan-page">
	<?php if (!$schema_ready): ?>
		<div class="alert alert-warning mb-4">
			<i class="fas fa-database mr-1"></i>
			Data perkembangan belum tersedia karena tabel penilaian karakter belum lengkap. Jalankan SQL setup terlebih
			dahulu.
		</div>
	<?php endif; ?>

	<div class="page-header-card">
		<h2>Perkembangan Anak</h2>
		<p>Daftar anak beserta skor tiap aspek karakter berdasarkan penilaian guru pada periode terpilih.</p>
	</div>

	<div class="stats-row">
		<div class="small-box-card box-blue">
			<div class="label">Total Anak</div>
			<div class="value"><?php echo (int) $total_children; ?></div>
		</div>
		<div class="small-box-card box-green">
			<div class="label">Anak Dinilai</div>
			<div class="value"><?php echo (int) $assessed_children; ?></div>
		</div>
		<div class="small-box-card box-orange">
			<div class="label">Rata-rata Umum</div>
			<div class="value"><?php echo number_format((float) $overall_avg, 2); ?></div>
		</div>
		<div class="small-box-card box-red">
			<div class="label">Perlu Dukungan</div>
			<div class="value"><?php echo (int) $need_support_count; ?></div>
		</div>
	</div>

	<div class="card-panel mb-4">
		<div class="panel-header">
			<h3><i class="fas fa-filter text-info"></i> Filter Periode</h3>
		</div>
		<div class="panel-body form-body">
			<form method="get" action="<?php echo site_url('guru/perkembangan-anak'); ?>">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Periode</label>
							<select name="period_type" class="form-control" id="period_type">
								<option value="weekly" <?php echo $filters['period_type'] === 'weekly' ? 'selected' : ''; ?>>Mingguan</option>
								<option value="monthly" <?php echo $filters['period_type'] === 'monthly' ? 'selected' : ''; ?>>Bulanan</option>
								<option value="range" <?php echo $filters['period_type'] === 'range' ? 'selected' : ''; ?>>Rentang Tanggal</option>
							</select>
						</div>
					</div>
					<div class="col-md-2 period-weekly period-monthly">
						<div class="form-group">
							<label>Tahun</label>
							<select name="year" class="form-control">
								<?php foreach ($years as $item_year): ?>
									<option value="<?php echo $item_year; ?>" <?php echo (int) $filters['year'] === (int) $item_year ? 'selected' : ''; ?>><?php echo $item_year; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-2 period-weekly">
						<div class="form-group">
							<label>Minggu</label>
							<input type="number" name="week" min="1" max="53" class="form-control"
								value="<?php echo (int) $filters['week']; ?>">
						</div>
					</div>
					<div class="col-md-2 period-monthly">
						<div class="form-group">
							<label>Bulan</label>
							<input type="number" name="month" min="1" max="12" class="form-control"
								value="<?php echo (int) $filters['month']; ?>">
						</div>
					</div>
					<div class="col-md-2 period-range">
						<div class="form-group">
							<label>Tanggal Mulai</label>
							<input type="date" name="start_date" class="form-control"
								value="<?php echo $filters['start_date']; ?>">
						</div>
					</div>
					<div class="col-md-2 period-range">
						<div class="form-group">
							<label>Tanggal Selesai</label>
							<input type="date" name="end_date" class="form-control"
								value="<?php echo $filters['end_date']; ?>">
						</div>
					</div>
					<div class="col-md-1 d-flex align-items-end">
						<button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="card-panel">
		<div class="panel-header">
			<h3><i class="fas fa-table text-primary"></i> Skor Tiap Aspek per Anak</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-hover mb-0 perkembangan-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Anak</th>
							<th>Pendidikan</th>
							<?php foreach ($aspects as $aspect): ?>
								<th class="text-center"><?php echo $aspect->aspect_name; ?></th>
							<?php endforeach; ?>
							<th class="text-center">Rata-rata</th>
							<th class="text-center">Kategori</th>
							<th class="text-center">Terakhir Dinilai</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($table_rows as $index => $row): ?>
							<tr>
								<td><?php echo $index + 1; ?></td>
								<td><?php echo $row['nama_anak']; ?></td>
								<td><?php echo !empty($row['pendidikan']) ? $row['pendidikan'] : '-'; ?></td>
								<?php foreach ($aspects as $aspect): ?>
									<?php
									$score = $row['aspect_scores'][(int) $aspect->id_aspect] ?? null;
									$score_class = 'badge-secondary';
									if ($score !== null) {
										if ($score >= 3.5) {
											$score_class = 'badge-success';
										} elseif ($score >= 2.5) {
											$score_class = 'badge-primary';
										} elseif ($score >= 1.5) {
											$score_class = 'badge-warning';
										} else {
											$score_class = 'badge-danger';
										}
									}
									?>
									<td class="text-center">
										<?php if ($score !== null): ?>
											<span
												class="badge badge-pill <?php echo $score_class; ?>"><?php echo number_format((float) $score, 2); ?></span>
										<?php else: ?>
											<span class="text-muted">-</span>
										<?php endif; ?>
									</td>
								<?php endforeach; ?>
								<td class="text-center">
									<?php if ($row['avg_score'] !== null): ?>
										<strong><?php echo number_format((float) $row['avg_score'], 2); ?></strong>
									<?php else: ?>
										<span class="text-muted">-</span>
									<?php endif; ?>
								</td>
								<td class="text-center"><?php echo $row['kategori']; ?></td>
								<td class="text-center">
									<?php echo !empty($row['tanggal_terakhir']) ? date('d-m-Y', strtotime($row['tanggal_terakhir'])) : '-'; ?>
								</td>
								<td class="text-center">
									<a href="<?php echo site_url('guru/perkembangan-anak/detail/' . (int) $row['id_anak'] . '?' . http_build_query($filters)); ?>"
										class="btn btn-sm btn-outline-primary">
										<i class="fas fa-eye"></i> Detail
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
						<?php if (empty($table_rows)): ?>
							<tr>
								<td colspan="<?php echo count($aspects) + 8; ?>" class="text-center py-4 text-muted">Belum
									ada data anak.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	.guru-perkembangan-page {
		padding: 10px;
	}

	.page-header-card {
		background: #fff;
		padding: 20px;
		border-radius: 14px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		margin-bottom: 20px;
	}

	.page-header-card h2 {
		margin: 0;
		font-size: 24px;
		font-weight: 700;
	}

	.page-header-card p {
		margin: 6px 0 0;
		color: #6b7280;
	}

	.stats-row {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 15px;
		margin-bottom: 20px;
	}

	.small-box-card {
		background: #fff;
		border-radius: 12px;
		padding: 16px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
		border-left: 4px solid #4e73df;
	}

	.small-box-card .label {
		font-size: 13px;
		color: #718096;
	}

	.small-box-card .value {
		font-size: 28px;
		font-weight: 700;
		line-height: 1.2;
	}

	.box-blue {
		border-left-color: #4e73df;
	}

	.box-green {
		border-left-color: #1cc88a;
	}

	.box-orange {
		border-left-color: #f6c23e;
	}

	.box-red {
		border-left-color: #e74a3b;
	}

	.card-panel {
		background: #fff;
		border-radius: 14px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
		overflow: hidden;
	}

	.panel-header {
		padding: 16px 20px;
		border-bottom: 1px solid #edf2f7;
	}

	.panel-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
	}

	.panel-body {
		padding: 0;
	}

	.form-body {
		padding: 20px;
	}

	.period-range {
		display: none;
	}

	.perkembangan-table thead th {
		font-size: 12px;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		white-space: nowrap;
	}

	@media (max-width: 992px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}
	}

	@media (max-width: 576px) {
		.stats-row {
			grid-template-columns: 1fr;
		}
	}
</style>

<script>
	(function () {
		function updatePeriodFields() {
			var period = document.getElementById('period_type');
			if (!period) {
				return;
			}

			var value = period.value;
			var weeklyEls = document.querySelectorAll('.period-weekly');
			var monthlyEls = document.querySelectorAll('.period-monthly');
			var rangeEls = document.querySelectorAll('.period-range');

			weeklyEls.forEach(function (el) {
				el.style.display = (value === 'weekly') ? 'block' : 'none';
			});

			monthlyEls.forEach(function (el) {
				el.style.display = (value === 'monthly') ? 'block' : 'none';
			});

			rangeEls.forEach(function (el) {
				el.style.display = (value === 'range') ? 'block' : 'none';
			});
		}

		document.addEventListener('DOMContentLoaded', function () {
			var period = document.getElementById('period_type');
			if (period) {
				period.addEventListener('change', updatePeriodFields);
			}
			updatePeriodFields();
		});
	})();
</script>