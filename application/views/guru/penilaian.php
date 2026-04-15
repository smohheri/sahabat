<div class="guru-penilaian-page">
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<i class="fas fa-check-circle mr-1"></i> <?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<i class="fas fa-exclamation-circle mr-1"></i> <?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if (!$schema_ready): ?>
		<div class="alert alert-warning mb-4">
			<i class="fas fa-database mr-1"></i>
			Modul penilaian belum dapat dipakai karena tabel karakter belum lengkap. Jalankan file SQL di folder database
			terlebih dahulu.
		</div>
	<?php endif; ?>

	<div class="page-header-card">
		<div>
			<h2>Penilaian Karakter Guru</h2>
			<p>Isi skor indikator, simpan catatan kualitatif, dan pantau progres karakter anak.</p>
		</div>
	</div>

	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-title">Total Anak Dinilai</div>
			<div class="stat-value"><?php echo count($summary_rows); ?></div>
		</div>
		<div class="stat-card stat-green">
			<div class="stat-title">Total Penilaian</div>
			<div class="stat-value"><?php echo (int) $total_assessments; ?></div>
		</div>
		<div class="stat-card stat-orange">
			<div class="stat-title">Rata-rata Skor</div>
			<div class="stat-value"><?php echo number_format((float) $overall_avg, 2); ?></div>
		</div>
	</div>

	<?php if ($schema_ready): ?>
		<div class="card-panel mb-4">
			<div class="panel-header">
				<h3><i class="fas fa-list text-primary"></i> Daftar Anak & Form Penilaian</h3>
			</div>
			<div class="panel-body form-body">
				<div class="assessment-layout">
					<div class="child-list-panel">
						<div class="child-list-title">Pilih Anak</div>
						<div class="child-list-wrap">
							<?php foreach ($children as $child): ?>
								<?php $active = (int) $selected_child_id === (int) $child->id_anak; ?>
								<a href="<?php echo site_url('guru/penilaian-karakter?anak=' . (int) $child->id_anak); ?>"
									class="child-item <?php echo $active ? 'active' : ''; ?>">
									<div class="child-avatar"><?php echo strtoupper(substr($child->nama_anak, 0, 1)); ?></div>
									<div class="child-info">
										<div class="child-name"><?php echo $child->nama_anak; ?></div>
										<div class="child-meta">
											<?php echo !empty($child->pendidikan) ? $child->pendidikan : '-'; ?> |
											<?php echo !empty($child->status_anak) ? $child->status_anak : '-'; ?>
										</div>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="assessment-form-panel">
						<?php if ($selected_child): ?>
							<form method="post" action="<?php echo site_url('guru/penilaian-karakter'); ?>">
								<input type="hidden" name="submit_assessment" value="1">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
									value="<?php echo $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="id_anak" value="<?php echo (int) $selected_child->id_anak; ?>">

								<div class="selected-child-header">
									<div>
										<h4 class="mb-1"><?php echo $selected_child->nama_anak; ?></h4>
										<small class="text-muted">
											<?php echo !empty($selected_child->pendidikan) ? $selected_child->pendidikan : '-'; ?>
											|
											<?php echo !empty($selected_child->status_anak) ? $selected_child->status_anak : '-'; ?>
										</small>
									</div>
									<div class="date-inline">
										<label class="mb-1">Tanggal Penilaian</label>
										<input type="date" name="assessment_date" class="form-control"
											value="<?php echo date('Y-m-d'); ?>" required>
									</div>
								</div>

								<div class="score-guide">
									<?php foreach ($scales as $scale): ?>
										<span class="score-chip">Skor <?php echo (int) $scale->score; ?>:
											<?php echo $scale->category; ?></span>
									<?php endforeach; ?>
								</div>

								<?php foreach ($aspects as $aspect): ?>
									<?php if (empty($aspect->indicators)) {
										continue;
									} ?>
									<div class="aspect-card">
										<div class="aspect-header">
											<strong><?php echo $aspect->aspect_name; ?></strong>
											<small><?php echo $aspect->aspect_code; ?></small>
										</div>
										<div class="aspect-body">
											<?php foreach ($aspect->indicators as $indicator): ?>
												<div class="indicator-row">
													<div class="indicator-text">
														<div class="indicator-name"><?php echo $indicator->indicator_name; ?></div>
														<?php if (!empty($indicator->indicator_code)): ?>
															<small class="text-muted"><?php echo $indicator->indicator_code; ?></small>
														<?php endif; ?>
													</div>
													<div class="score-radio-group">
														<?php foreach ($scales as $scale): ?>
															<label class="score-radio-item">
																<input type="radio"
																	name="scores[<?php echo (int) $indicator->id_indicator; ?>]"
																	value="<?php echo (int) $scale->score; ?>">
																<span><?php echo (int) $scale->score; ?></span>
															</label>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endforeach; ?>

								<div class="row mt-3">
									<div class="col-md-6">
										<div class="form-group">
											<label>Catatan Umum</label>
											<input type="text" name="notes" class="form-control"
												placeholder="Contoh: penilaian mingguan kelas B">
										</div>
										<div class="form-group">
											<label>Kekuatan Anak</label>
											<textarea name="strengths" class="form-control" rows="3"
												placeholder="Sikap atau kebiasaan positif anak"></textarea>
										</div>
										<div class="form-group">
											<label>Perkembangan Terlihat</label>
											<textarea name="development_observed" class="form-control" rows="3"
												placeholder="Perubahan atau peningkatan yang terlihat"></textarea>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Area Dukungan</label>
											<textarea name="areas_to_support" class="form-control" rows="3"
												placeholder="Area karakter yang perlu ditingkatkan"></textarea>
										</div>
										<div class="form-group">
											<label>Strategi Dukungan</label>
											<textarea name="support_strategy" class="form-control" rows="3"
												placeholder="Rencana tindak lanjut pembinaan"></textarea>
										</div>
									</div>
								</div>

								<div class="text-right mt-2">
									<button type="submit" class="btn btn-primary">
										<i class="fas fa-save mr-1"></i> Simpan Penilaian
									</button>
								</div>
							</form>
						<?php else: ?>
							<div class="empty-state text-center text-muted py-4">
								Belum ada anak yang bisa dinilai.
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="card-panel mb-4">
		<div class="panel-header">
			<h3><i class="fas fa-filter text-info"></i> Filter Ringkasan Progres</h3>
		</div>
		<div class="panel-body form-body">
			<form method="get" action="<?php echo site_url('guru/penilaian-karakter'); ?>">
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

	<div class="card-panel mb-4">
		<div class="panel-header">
			<h3><i class="fas fa-chart-line text-success"></i> Ringkasan Progres Anak (Penilaian Saya)</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-hover mb-0">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Anak</th>
							<th>Total Penilaian</th>
							<th>Rata-rata</th>
							<th>Kategori</th>
							<th>Tanggal Terakhir</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($summary_rows)): ?>
							<?php foreach ($summary_rows as $index => $row): ?>
								<tr>
									<td><?php echo $index + 1; ?></td>
									<td><?php echo $row->nama_anak; ?></td>
									<td><?php echo (int) $row->total_penilaian; ?></td>
									<td><?php echo number_format((float) $row->avg_score, 2); ?></td>
									<td><?php echo $row->kategori; ?></td>
									<td><?php echo !empty($row->tanggal_terakhir) ? date('d-m-Y', strtotime($row->tanggal_terakhir)) : '-'; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6" class="text-center py-4 text-muted">Belum ada data ringkasan pada periode
									ini.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card-panel">
		<div class="panel-header">
			<h3><i class="fas fa-history text-secondary"></i> Riwayat Penilaian Terbaru</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-hover mb-0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nama Anak</th>
							<th>Tanggal</th>
							<th>Minggu/Bulan/Tahun</th>
							<th>Status</th>
							<th>Catatan</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($recent_assessments)): ?>
							<?php foreach ($recent_assessments as $item): ?>
								<tr>
									<td>#<?php echo (int) $item->id_assessment; ?></td>
									<td><?php echo $item->nama_anak ?: '-'; ?></td>
									<td><?php echo !empty($item->assessment_date) ? date('d-m-Y', strtotime($item->assessment_date)) : '-'; ?>
									</td>
									<td><?php echo (int) $item->week_number; ?> / <?php echo (int) $item->month; ?> /
										<?php echo (int) $item->year; ?>
									</td>
									<td><span
											class="badge badge-pill badge-success"><?php echo ucfirst($item->status); ?></span>
									</td>
									<td><?php echo !empty($item->notes) ? (strlen(strip_tags($item->notes)) > 60 ? substr(strip_tags($item->notes), 0, 60) . '...' : strip_tags($item->notes)) : '-'; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat penilaian.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	.guru-penilaian-page {
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
		grid-template-columns: repeat(3, 1fr);
		gap: 15px;
		margin-bottom: 20px;
	}

	.stat-card {
		background: #fff;
		border-radius: 12px;
		padding: 18px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
		border-left: 4px solid #4e73df;
	}

	.stat-blue {
		border-left-color: #4e73df;
	}

	.stat-green {
		border-left-color: #1cc88a;
	}

	.stat-orange {
		border-left-color: #f6c23e;
	}

	.stat-title {
		font-size: 13px;
		color: #718096;
	}

	.stat-value {
		font-size: 28px;
		font-weight: 700;
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

	.assessment-layout {
		display: grid;
		grid-template-columns: 300px 1fr;
		gap: 20px;
	}

	.child-list-panel {
		border: 1px solid #e2e8f0;
		border-radius: 12px;
		overflow: hidden;
		background: #f8fafc;
	}

	.child-list-title {
		padding: 12px 14px;
		font-size: 13px;
		font-weight: 700;
		text-transform: uppercase;
		color: #64748b;
		background: #eef2ff;
		border-bottom: 1px solid #e2e8f0;
	}

	.child-list-wrap {
		max-height: 760px;
		overflow-y: auto;
	}

	.child-item {
		display: flex;
		gap: 10px;
		padding: 12px 14px;
		text-decoration: none;
		color: #334155;
		border-bottom: 1px solid #e2e8f0;
	}

	.child-item:hover {
		background: #e0f2fe;
		text-decoration: none;
	}

	.child-item.active {
		background: #dbeafe;
		border-left: 4px solid #2563eb;
	}

	.child-avatar {
		width: 34px;
		height: 34px;
		border-radius: 999px;
		background: #4e73df;
		color: #fff;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}

	.child-info {
		min-width: 0;
	}

	.child-name {
		font-size: 14px;
		font-weight: 600;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.child-meta {
		font-size: 12px;
		color: #64748b;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.assessment-form-panel {
		min-width: 0;
	}

	.selected-child-header {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		gap: 14px;
		padding: 14px;
		background: #f8fafc;
		border: 1px solid #e2e8f0;
		border-radius: 10px;
		margin-bottom: 14px;
	}

	.date-inline {
		min-width: 210px;
	}

	.aspect-card {
		border: 1px solid #e2e8f0;
		border-radius: 10px;
		margin-bottom: 12px;
		overflow: hidden;
	}

	.aspect-header {
		display: flex;
		justify-content: space-between;
		gap: 8px;
		padding: 10px 12px;
		background: #f1f5f9;
	}

	.aspect-header small {
		font-size: 11px;
		color: #64748b;
	}

	.aspect-body {
		padding: 10px 12px;
	}

	.indicator-row {
		display: grid;
		grid-template-columns: 1.3fr 1fr;
		gap: 12px;
		padding: 10px 0;
		border-bottom: 1px dashed #e2e8f0;
	}

	.indicator-row:last-child {
		border-bottom: 0;
	}

	.indicator-name {
		font-size: 14px;
		font-weight: 600;
		color: #1e293b;
	}

	.score-radio-group {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}

	.score-radio-item {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding: 5px 8px;
		border: 1px solid #cbd5e1;
		border-radius: 999px;
		font-size: 12px;
		font-weight: 600;
		cursor: pointer;
		margin-bottom: 0;
		background: #fff;
	}

	.score-radio-item input {
		margin: 0;
	}

	.score-guide {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
		margin-bottom: 14px;
	}

	.score-chip {
		display: inline-flex;
		align-items: center;
		padding: 6px 10px;
		background: #eef2ff;
		color: #4338ca;
		border-radius: 999px;
		font-size: 12px;
		font-weight: 600;
	}

	.score-table td,
	.score-table th {
		vertical-align: middle;
	}

	.period-range {
		display: none;
	}

	@media (max-width: 992px) {
		.stats-row {
			grid-template-columns: 1fr;
		}

		.assessment-layout {
			grid-template-columns: 1fr;
		}

		.child-list-wrap {
			max-height: 320px;
		}

		.indicator-row {
			grid-template-columns: 1fr;
		}

		.selected-child-header {
			flex-direction: column;
		}

		.date-inline {
			min-width: 100%;
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