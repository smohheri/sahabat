<!-- Select2 CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<!-- Select2 JS -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>

<style>
	.rombel-anak-picker .custom-control {
		min-height: 2rem;
		padding-left: 2rem;
	}

	.rombel-anak-picker .custom-control-label {
		display: block;
		font-size: 0.95rem;
		line-height: 1.35;
		margin-bottom: 0;
		cursor: pointer;
		padding-top: 0.1rem;
	}

	.rombel-anak-picker .custom-control-label::before,
	.rombel-anak-picker .custom-control-label::after {
		width: 1.25rem;
		height: 1.25rem;
		left: -2rem;
		top: 0.05rem;
	}

	.rombel-anak-picker .custom-control-input:checked~.custom-control-label {
		font-weight: 600;
	}

	.rombel-anak-picker .rombel-anak-actions .btn {
		text-decoration: none;
	}

	@media (max-width: 767.98px) {
		.rombel-anak-picker .rombel-anak-header {
			align-items: flex-start !important;
			gap: 0.5rem;
		}

		.rombel-anak-picker .rombel-anak-actions {
			display: flex;
			width: 100%;
			gap: 0.75rem;
		}

		.rombel-anak-picker .rombel-anak-actions .btn {
			flex: 1;
			text-align: center;
			padding: 0.25rem 0;
			background: #f8f9fa;
			border: 1px solid #dee2e6;
			border-radius: 0.25rem;
		}

		.rombel-anak-picker .custom-control {
			padding-left: 2.35rem;
		}

		.rombel-anak-picker .custom-control-label {
			font-size: 1rem;
			line-height: 1.45;
		}

		.rombel-anak-picker .custom-control-label::before,
		.rombel-anak-picker .custom-control-label::after {
			width: 1.45rem;
			height: 1.45rem;
			left: -2.35rem;
			top: 0.02rem;
		}
	}
</style>

<div class="laporan-page">
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-users-cog"></i>
			</div>
			<div>
				<h2>Manajemen Rombel</h2>
				<p>Kelola rombel beserta relasi anak aktif dan mata pelajaran</p>
			</div>
		</div>
		<div class="header-actions">
			<a href="<?php echo $export_pdf_url; ?>" class="btn btn-danger" target="_blank">
				<i class="fas fa-file-pdf"></i> Export PDF
			</a>
			<a href="<?php echo $export_excel_url; ?>" class="btn btn-success">
				<i class="fas fa-file-excel"></i> Export Excel
			</a>
			<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAddRombel">
				<i class="fas fa-plus"></i> Tambah Rombel
			</button>
		</div>
	</div>

	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
			<i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
			<i class="fas fa-exclamation-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-icon"><i class="fas fa-layer-group"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo (int) $total_rombel; ?></span>
				<span class="stat-label">Total Rombel</span>
			</div>
		</div>
		<div class="stat-card stat-green">
			<div class="stat-icon"><i class="fas fa-check"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo (int) $total_rombel_aktif; ?></span>
				<span class="stat-label">Rombel Aktif</span>
			</div>
		</div>
		<div class="stat-card stat-orange">
			<div class="stat-icon"><i class="fas fa-child"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($active_anak_rows); ?></span>
				<span class="stat-label">Anak Aktif Tersedia</span>
			</div>
		</div>
	</div>

	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-list"></i> Daftar Rombel</h3>
			<span class="data-count"><?php echo (int) $total_rombel; ?> data</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableRombel">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Nama Rombel</th>
							<th>Tahun/Semester</th>
							<th>Total Anak</th>
							<th>Total Mapel</th>
							<th>Status</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; ?>
						<?php foreach ($rombel_rows as $row): ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td><span class="badge badge-info px-2 py-1"><?php echo $row->kode_rombel; ?></span></td>
								<td><?php echo $row->nama_rombel; ?></td>
								<td><?php echo $row->tahun_ajaran; ?> / Semester <?php echo (int) $row->semester; ?></td>
								<td><span class="badge badge-primary px-2 py-1"><?php echo (int) $row->total_anak; ?>
										Anak</span></td>
								<td><span class="badge badge-warning px-2 py-1"><?php echo (int) $row->total_mapel; ?>
										Mapel</span></td>
								<td>
									<?php if ((int) $row->is_active === 1): ?>
										<span class="badge badge-success px-2 py-1">Aktif</span>
									<?php else: ?>
										<span class="badge badge-secondary px-2 py-1">Non Aktif</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button class="btn btn-info btn-sm btn-view-rombel" data-toggle="modal"
											data-target="#modalDetailRombel"
											data-id-rombel="<?php echo (int) $row->id_rombel; ?>"
											data-kode-rombel="<?php echo htmlspecialchars((string) $row->kode_rombel, ENT_QUOTES, 'UTF-8'); ?>"
											data-nama-rombel="<?php echo htmlspecialchars((string) $row->nama_rombel, ENT_QUOTES, 'UTF-8'); ?>"
											data-tahun-ajaran="<?php echo htmlspecialchars((string) $row->tahun_ajaran, ENT_QUOTES, 'UTF-8'); ?>"
											data-semester="<?php echo (int) $row->semester; ?>"
											data-is-active="<?php echo (int) $row->is_active; ?>" title="Detail Rombel">
											<i class="fas fa-eye"></i>
										</button>
										<button class="btn btn-warning btn-sm" data-toggle="modal"
											data-target="#modalEditRombel<?php echo (int) $row->id_rombel; ?>" title="Edit">
											<i class="fas fa-edit"></i>
										</button>
										<button class="btn btn-danger btn-sm" data-toggle="modal"
											data-target="#modalDeleteRombel<?php echo (int) $row->id_rombel; ?>"
											title="Hapus">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php foreach ($rombel_rows as $row): ?>
	<?php $edit_form_id = 'formEditRombel_' . (int) $row->id_rombel; ?>
	<div class="modal fade" id="modalEditRombel<?php echo (int) $row->id_rombel; ?>" tabindex="-1">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-warning text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
						Rombel</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<?php echo form_open($base_path . '/rombel', array('id' => $edit_form_id, 'class' => 'js-rombel-form', 'novalidate' => 'novalidate', 'data-gramm' => 'false', 'data-gramm_editor' => 'false', 'data-enable-grammarly' => 'false')); ?>
				<div class="modal-body p-4">
					<input type="hidden" name="form_type" value="save_rombel">
					<input type="hidden" name="id_rombel" value="<?php echo (int) $row->id_rombel; ?>">

					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="font-weight-bold text-muted mb-2">Kode Rombel</label>
							<input type="text" class="form-control" name="kode_rombel"
								value="<?php echo $row->kode_rombel; ?>" minlength="2" maxlength="50"
								pattern="^[A-Za-z0-9_\-]{2,50}$"
								title="Kode hanya boleh huruf, angka, underscore, dan tanda minus" autocomplete="off"
								required>
						</div>
						<div class="form-group col-md-8">
							<label class="font-weight-bold text-muted mb-2">Nama Rombel</label>
							<input type="text" class="form-control" name="nama_rombel"
								value="<?php echo $row->nama_rombel; ?>" minlength="3" maxlength="150" required>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="font-weight-bold text-muted mb-2">Tahun Ajaran</label>
							<input type="text" class="form-control" name="tahun_ajaran"
								value="<?php echo $row->tahun_ajaran; ?>" placeholder="2026/2027" maxlength="9"
								pattern="^[0-9]{4}/[0-9]{4}$" title="Format tahun ajaran harus YYYY/YYYY"
								inputmode="numeric" required>
						</div>
						<div class="form-group col-md-4">
							<label class="font-weight-bold text-muted mb-2">Semester</label>
							<select class="form-control" name="semester" required>
								<option value="1" <?php echo (int) $row->semester === 1 ? 'selected' : ''; ?>>1</option>
								<option value="2" <?php echo (int) $row->semester === 2 ? 'selected' : ''; ?>>2</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label class="font-weight-bold text-muted mb-2">Status</label>
							<select class="form-control" name="is_active" required>
								<option value="1" <?php echo (int) $row->is_active === 1 ? 'selected' : ''; ?>>Aktif</option>
								<option value="0" <?php echo (int) $row->is_active === 0 ? 'selected' : ''; ?>>Non Aktif
								</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="font-weight-bold text-muted mb-2">Pilih Anak Aktif</label>
						<?php $selected_anak = $selected_anak_map[(int) $row->id_rombel] ?? array(); ?>
						<div class="border rounded p-3 js-anak-group rombel-anak-picker">
							<div
								class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2 rombel-anak-header">
								<small class="text-muted">Centang anak yang masuk ke rombel</small>
								<div class="rombel-anak-actions">
									<button type="button" class="btn btn-link btn-sm p-0 js-anak-check-all">Pilih
										Semua</button>
									<button type="button"
										class="btn btn-link btn-sm p-0 js-anak-uncheck-all">Kosongkan</button>
								</div>
							</div>
							<input type="text" class="form-control form-control-sm mb-2 js-anak-filter"
								placeholder="Cari nama atau pendidikan anak..." data-gramm="false" data-gramm_editor="false"
								data-enable-grammarly="false">
							<div class="border rounded p-2" style="max-height: 220px; overflow-y: auto;">
								<div class="row no-gutters">
									<?php foreach ($active_anak_rows as $anak): ?>
										<?php $anak_checkbox_id = 'anak_edit_' . (int) $row->id_rombel . '_' . (int) $anak->id_anak; ?>
										<div class="col-md-6 pr-md-2 mb-2 js-anak-option-item"
											data-search="<?php echo htmlspecialchars(strtolower((string) $anak->nama_anak . ' ' . (string) ($anak->pendidikan ?: '-')), ENT_QUOTES, 'UTF-8'); ?>">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input js-anak-option"
													id="<?php echo $anak_checkbox_id; ?>" name="anak_ids[]"
													value="<?php echo (int) $anak->id_anak; ?>" <?php echo in_array((int) $anak->id_anak, $selected_anak, true) ? 'checked' : ''; ?>>
												<label class="custom-control-label" for="<?php echo $anak_checkbox_id; ?>">
													<?php echo htmlspecialchars((string) $anak->nama_anak, ENT_QUOTES, 'UTF-8'); ?>
													<small
														class="d-block text-muted"><?php echo htmlspecialchars((string) ($anak->pendidikan ?: '-'), ENT_QUOTES, 'UTF-8'); ?></small>
												</label>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<small class="form-text text-muted js-anak-counter"></small>
						<small class="form-text text-danger d-none js-anak-error">Pilih minimal satu anak aktif.</small>
					</div>

					<div class="form-group">
						<label class="font-weight-bold text-muted mb-2">Pilih Mata Pelajaran</label>
						<select class="form-control select2-multiple js-mapel-select" name="mapel_ids[]"
							multiple="multiple">
							<?php $selected_mapel = $selected_mapel_map[(int) $row->id_rombel] ?? array(); ?>
							<?php foreach ($active_mapel_rows as $mapel): ?>
								<option value="<?php echo (int) $mapel->id_mata_pelajaran; ?>" <?php echo in_array((int) $mapel->id_mata_pelajaran, $selected_mapel, true) ? 'selected' : ''; ?>>
									<?php echo $mapel->kode_mapel; ?> - <?php echo $mapel->nama_mapel; ?>
								</option>
							<?php endforeach; ?>
						</select>
						<small class="form-text text-muted js-mapel-counter"></small>
						<small class="form-text text-danger d-none js-mapel-error">Pilih minimal satu mata
							pelajaran.</small>
					</div>

					<div class="form-group mb-0">
						<label class="font-weight-bold text-muted mb-2">Keterangan</label>
						<textarea class="form-control" name="keterangan" rows="2" data-gramm="false"
							data-gramm_editor="false"
							data-enable-grammarly="false"><?php echo $row->keterangan; ?></textarea>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" form="<?php echo $edit_form_id; ?>" class="btn btn-warning font-weight-bold"><i
							class="fas fa-save mr-1"></i>Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalDeleteRombel<?php echo (int) $row->id_rombel; ?>" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-trash mr-2"></i>Hapus Rombel</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body p-4">
					Apakah Anda yakin ingin menghapus rombel <strong><?php echo $row->nama_rombel; ?></strong>?
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<a href="<?php echo site_url($base_path . '/rombel?delete=' . (int) $row->id_rombel); ?>"
						class="btn btn-danger font-weight-bold">Hapus</a>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<div class="modal fade" id="modalDetailRombel" tabindex="-1">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-info text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-users mr-2"></i>Detail Rombel</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body p-4">
				<div class="mb-3">
					<h6 class="font-weight-bold mb-1" id="detailRombelNama">-</h6>
					<small class="text-muted" id="detailRombelMeta">-</small>
				</div>

				<div class="mb-3">
					<span class="badge badge-primary px-2 py-1 mr-1" id="detailRombelTotalBadge">0 Peserta Didik</span>
					<span class="badge px-2 py-1" id="detailRombelStatusBadge">-</span>
				</div>

				<div class="table-responsive" id="detailRombelTableWrapper">
					<table class="table table-bordered table-sm mb-0">
						<thead class="bg-light">
							<tr>
								<th style="width: 60px;">No</th>
								<th>Nama Peserta Didik</th>
								<th style="width: 170px;">Pendidikan</th>
								<th style="width: 120px;">Status Anak</th>
							</tr>
						</thead>
						<tbody id="detailRombelBody"></tbody>
					</table>
				</div>

				<div class="alert alert-warning mb-0 d-none" id="detailRombelEmpty">
					Belum ada peserta didik yang terdaftar pada rombel ini.
				</div>
			</div>
			<div class="modal-footer bg-light">
				<a href="#" id="detailRombelExportExcel" class="btn btn-success" target="_blank">
					<i class="fas fa-file-excel mr-1"></i> Export Format Absensi
				</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalAddRombel" tabindex="-1">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Rombel</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<?php echo form_open($base_path . '/rombel', array('id' => 'formAddRombel', 'class' => 'js-rombel-form', 'novalidate' => 'novalidate', 'data-gramm' => 'false', 'data-gramm_editor' => 'false', 'data-enable-grammarly' => 'false')); ?>
			<div class="modal-body p-4">
				<input type="hidden" name="form_type" value="save_rombel">
				<input type="hidden" name="id_rombel" value="0">

				<div class="form-row">
					<div class="form-group col-md-4">
						<label class="font-weight-bold text-muted mb-2">Kode Rombel</label>
						<input type="text" class="form-control" name="kode_rombel" placeholder="Contoh: RB-01"
							minlength="2" maxlength="50" pattern="^[A-Za-z0-9_\-]{2,50}$"
							title="Kode hanya boleh huruf, angka, underscore, dan tanda minus" autocomplete="off"
							required>
					</div>
					<div class="form-group col-md-8">
						<label class="font-weight-bold text-muted mb-2">Nama Rombel</label>
						<input type="text" class="form-control" name="nama_rombel" placeholder="Contoh: Rombel A"
							minlength="3" maxlength="150" required>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-4">
						<label class="font-weight-bold text-muted mb-2">Tahun Ajaran</label>
						<input type="text" class="form-control" name="tahun_ajaran"
							value="<?php echo $tahun_ajaran_options[0] ?? ''; ?>" placeholder="2026/2027" maxlength="9"
							pattern="^[0-9]{4}/[0-9]{4}$" title="Format tahun ajaran harus YYYY/YYYY"
							inputmode="numeric" required>
					</div>
					<div class="form-group col-md-4">
						<label class="font-weight-bold text-muted mb-2">Semester</label>
						<select class="form-control" name="semester" required>
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label class="font-weight-bold text-muted mb-2">Status</label>
						<select class="form-control" name="is_active" required>
							<option value="1">Aktif</option>
							<option value="0">Non Aktif</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="font-weight-bold text-muted mb-2">Pilih Anak Aktif</label>
					<div class="border rounded p-3 js-anak-group rombel-anak-picker">
						<div
							class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2 rombel-anak-header">
							<small class="text-muted">Centang anak yang masuk ke rombel</small>
							<div class="rombel-anak-actions">
								<button type="button" class="btn btn-link btn-sm p-0 js-anak-check-all">Pilih
									Semua</button>
								<button type="button"
									class="btn btn-link btn-sm p-0 js-anak-uncheck-all">Kosongkan</button>
							</div>
						</div>
						<input type="text" class="form-control form-control-sm mb-2 js-anak-filter"
							placeholder="Cari nama atau pendidikan anak..." data-gramm="false" data-gramm_editor="false"
							data-enable-grammarly="false">
						<div class="border rounded p-2" style="max-height: 220px; overflow-y: auto;">
							<div class="row no-gutters">
								<?php foreach ($active_anak_rows as $anak): ?>
									<?php $anak_checkbox_id = 'anak_add_' . (int) $anak->id_anak; ?>
									<div class="col-md-6 pr-md-2 mb-2 js-anak-option-item"
										data-search="<?php echo htmlspecialchars(strtolower((string) $anak->nama_anak . ' ' . (string) ($anak->pendidikan ?: '-')), ENT_QUOTES, 'UTF-8'); ?>">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input js-anak-option"
												id="<?php echo $anak_checkbox_id; ?>" name="anak_ids[]"
												value="<?php echo (int) $anak->id_anak; ?>">
											<label class="custom-control-label" for="<?php echo $anak_checkbox_id; ?>">
												<?php echo htmlspecialchars((string) $anak->nama_anak, ENT_QUOTES, 'UTF-8'); ?>
												<small
													class="d-block text-muted"><?php echo htmlspecialchars((string) ($anak->pendidikan ?: '-'), ENT_QUOTES, 'UTF-8'); ?></small>
											</label>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<small class="form-text text-muted js-anak-counter"></small>
					<small class="form-text text-danger d-none js-anak-error">Pilih minimal satu anak aktif.</small>
				</div>

				<div class="form-group">
					<label class="font-weight-bold text-muted mb-2">Pilih Mata Pelajaran</label>
					<select class="form-control select2-multiple js-mapel-select" name="mapel_ids[]"
						multiple="multiple">
						<?php foreach ($active_mapel_rows as $mapel): ?>
							<option value="<?php echo (int) $mapel->id_mata_pelajaran; ?>"><?php echo $mapel->kode_mapel; ?>
								- <?php echo $mapel->nama_mapel; ?></option>
						<?php endforeach; ?>
					</select>
					<small class="form-text text-muted js-mapel-counter"></small>
					<small class="form-text text-danger d-none js-mapel-error">Pilih minimal satu mata
						pelajaran.</small>
				</div>

				<div class="form-group mb-0">
					<label class="font-weight-bold text-muted mb-2">Keterangan</label>
					<textarea class="form-control" name="keterangan" rows="2" placeholder="Opsional" data-gramm="false"
						data-gramm_editor="false" data-enable-grammarly="false"></textarea>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" form="formAddRombel" class="btn btn-primary font-weight-bold"><i
						class="fas fa-save mr-1"></i>Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(function () {
		var rombelChildrenMap = <?php echo json_encode($rombel_children_map ?? array(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?> || {};
		var exportAbsensiExcelBaseUrl = <?php echo json_encode(site_url($base_path . '/export/absensi/excel')); ?>;

		$('#tableRombel').DataTable({
			"paging": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			"pageLength": 10,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
			"language": {
				"search": "Cari:",
				"lengthMenu": "Tampilkan _MENU_ data",
				"info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
				"paginate": {
					"first": "Awal",
					"last": "Akhir",
					"next": "Berikutnya",
					"previous": "Sebelumnya"
				}
			}
		});

		$('.select2-multiple').each(function () {
			var $select = $(this);
			var options = {
				theme: 'bootstrap4',
				width: '100%',
				placeholder: 'Pilih data'
			};
			var $modalParent = $select.closest('.modal');
			if ($modalParent.length > 0) {
				options.dropdownParent = $modalParent;
			}
			$select.select2(options);
		});

		function escapeHtml(value) {
			return $('<div>').text(value || '').html();
		}

		function normalizeStatus(status) {
			var cleanStatus = (status || '').toString().trim();
			if (cleanStatus === '') {
				return '-';
			}
			return cleanStatus.charAt(0).toUpperCase() + cleanStatus.slice(1).toLowerCase();
		}

		$('.btn-view-rombel').on('click', function () {
			var $button = $(this);
			var rombelId = String($button.data('id-rombel') || '0');
			var pesertaRows = rombelChildrenMap[rombelId] || [];

			var namaRombel = ($button.data('nama-rombel') || '').toString();
			var kodeRombel = ($button.data('kode-rombel') || '').toString();
			var tahunAjaran = ($button.data('tahun-ajaran') || '').toString();
			var semester = parseInt($button.data('semester'), 10) || 1;
			var isActive = parseInt($button.data('is-active'), 10) === 1;
			var now = new Date();
			var periodDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
			var periodeBulan = periodDate.getMonth() + 1;
			var periodeTahun = periodDate.getFullYear();

			var exportQuery = $.param({
				tahun_ajaran: tahunAjaran,
				semester: semester,
				id_rombel: rombelId,
				id_mata_pelajaran: 0,
				export_format: 'template_rombel',
				periode_bulan: periodeBulan,
				periode_tahun: periodeTahun,
				tanggal_mulai: '',
				tanggal_selesai: ''
			});
			$('#detailRombelExportExcel').attr('href', exportAbsensiExcelBaseUrl + '?' + exportQuery);

			$('#detailRombelNama').text(namaRombel || '-');
			$('#detailRombelMeta').text((kodeRombel || '-') + ' | ' + (tahunAjaran || '-') + ' Semester ' + semester);
			$('#detailRombelTotalBadge').text(pesertaRows.length + ' Peserta Didik');

			var $statusBadge = $('#detailRombelStatusBadge');
			$statusBadge.removeClass('badge-success badge-secondary');
			if (isActive) {
				$statusBadge.addClass('badge-success').text('Rombel Aktif');
			} else {
				$statusBadge.addClass('badge-secondary').text('Rombel Non Aktif');
			}

			if (pesertaRows.length === 0) {
				$('#detailRombelBody').html('');
				$('#detailRombelTableWrapper').addClass('d-none');
				$('#detailRombelEmpty').removeClass('d-none');
				return;
			}

			var rowsHtml = '';
			for (var i = 0; i < pesertaRows.length; i++) {
				var item = pesertaRows[i] || {};
				var statusRaw = (item.status_anak || '').toString().trim().toLowerCase();
				var statusLabel = normalizeStatus(item.status_anak);
				var statusClass = statusRaw === 'aktif' ? 'badge badge-success px-2 py-1' : 'badge badge-secondary px-2 py-1';

				rowsHtml += '<tr>' +
					'<td>' + (i + 1) + '</td>' +
					'<td>' + escapeHtml(item.nama_anak || '-') + '</td>' +
					'<td>' + escapeHtml(item.pendidikan || '-') + '</td>' +
					'<td><span class="' + statusClass + '">' + escapeHtml(statusLabel) + '</span></td>' +
					'</tr>';
			}

			$('#detailRombelBody').html(rowsHtml);
			$('#detailRombelTableWrapper').removeClass('d-none');
			$('#detailRombelEmpty').addClass('d-none');
		});

		function sanitizeKodeRombel(value) {
			return (value || '').toUpperCase().replace(/[^A-Z0-9_-]/g, '');
		}

		function formatTahunAjaran(value) {
			var digitsOnly = (value || '').replace(/[^0-9]/g, '').slice(0, 8);
			if (digitsOnly.length > 4) {
				return digitsOnly.slice(0, 4) + '/' + digitsOnly.slice(4);
			}
			return digitsOnly;
		}

		function setSelect2Invalid($select, invalid) {
			$select.toggleClass('is-invalid', invalid);
			var $selection = $select.next('.select2-container').find('.select2-selection');
			if ($selection.length > 0) {
				$selection.toggleClass('border border-danger', invalid);
			}
		}

		function setAnakGroupInvalid($form, invalid) {
			$form.find('.js-anak-group').toggleClass('border-danger', invalid);
			$form.find('.js-anak-error').toggleClass('d-none', !invalid);
		}

		function setMapelInvalid($form, invalid) {
			var $mapel = $form.find('select[name="mapel_ids[]"]');
			setSelect2Invalid($mapel, invalid);
			$form.find('.js-mapel-error').toggleClass('d-none', !invalid);
		}

		function updateSelectionCounter($form) {
			var anakCount = $form.find('input[name="anak_ids[]"]:checked').length;
			var totalAnak = $form.find('input[name="anak_ids[]"]').length;
			var mapelCount = (($form.find('select[name="mapel_ids[]"]').val() || []).length);

			$form.find('.js-anak-counter').text(anakCount + ' dari ' + totalAnak + ' anak dipilih');
			$form.find('.js-mapel-counter').text(mapelCount + ' mapel dipilih');
		}

		function getRombelContext($element) {
			var $form = $element.closest('.js-rombel-form');
			if ($form.length > 0) {
				return $form;
			}

			var $modal = $element.closest('.modal');
			if ($modal.length > 0) {
				return $modal;
			}

			return $element;
		}

		$('input[name="kode_rombel"]').on('input', function () {
			this.value = sanitizeKodeRombel(this.value);
			$(this).removeClass('is-invalid');
		});

		$('input[name="nama_rombel"]').on('input', function () {
			$(this).removeClass('is-invalid');
		});

		$('input[name="tahun_ajaran"]').on('input', function () {
			this.value = formatTahunAjaran(this.value);
			$(this).removeClass('is-invalid');
		});

		$('.js-rombel-form').each(function () {
			updateSelectionCounter($(this));
		});

		$('#modalAddRombel, [id^="modalEditRombel"]').each(function () {
			updateSelectionCounter($(this));
		});

		$(document).on('change', 'input[name="anak_ids[]"]', function () {
			var $context = getRombelContext($(this));
			setAnakGroupInvalid($context, false);
			updateSelectionCounter($context);
		});

		$(document).on('input', '.js-anak-filter', function () {
			var $group = $(this).closest('.js-anak-group');
			var keyword = (($(this).val() || '') + '').toLowerCase().trim();

			$group.find('.js-anak-option-item').each(function () {
				var searchValue = (($(this).data('search') || '') + '').toLowerCase();
				$(this).toggleClass('d-none', keyword !== '' && searchValue.indexOf(keyword) === -1);
			});
		});

		$(document).on('click', '.js-anak-check-all', function (event) {
			event.preventDefault();
			var $group = $(this).closest('.js-anak-group');
			var $context = getRombelContext($(this));

			$group.find('input[name="anak_ids[]"]').prop('checked', true);
			setAnakGroupInvalid($context, false);
			updateSelectionCounter($context);
		});

		$(document).on('click', '.js-anak-uncheck-all', function (event) {
			event.preventDefault();
			var $group = $(this).closest('.js-anak-group');
			var $context = getRombelContext($(this));

			$group.find('input[name="anak_ids[]"]').prop('checked', false);
			updateSelectionCounter($context);
		});

		$(document).on('change', 'select[name="mapel_ids[]"]', function () {
			var $select = $(this);
			setSelect2Invalid($select, false);
			var $context = getRombelContext($select);
			setMapelInvalid($context, false);
			updateSelectionCounter($context);
		});

		$(document).on('submit', '.js-rombel-form', function (event) {
			var $form = $(this);
			var $kode = $form.find('input[name="kode_rombel"]');
			var $nama = $form.find('input[name="nama_rombel"]');
			var $tahun = $form.find('input[name="tahun_ajaran"]');
			var $anak = $form.find('input[name="anak_ids[]"]');
			var $mapel = $form.find('select[name="mapel_ids[]"]');

			var kode = sanitizeKodeRombel(($kode.val() || '').trim());
			var nama = ($nama.val() || '').trim();
			var tahun = formatTahunAjaran(($tahun.val() || '').trim());
			var anakIds = $anak.filter(':checked').map(function () {
				return String($(this).val() || '');
			}).get();
			var mapelIds = $mapel.val() || [];

			$kode.val(kode);
			$nama.val(nama);
			$tahun.val(tahun);

			var kodeValid = /^[A-Z0-9_-]{2,50}$/.test(kode);
			var namaValid = nama.length >= 3 && nama.length <= 150;
			var tahunValid = /^[0-9]{4}\/[0-9]{4}$/.test(tahun);
			var anakValid = anakIds.length > 0;
			var mapelValid = mapelIds.length > 0;

			$kode.toggleClass('is-invalid', !kodeValid);
			$nama.toggleClass('is-invalid', !namaValid);
			$tahun.toggleClass('is-invalid', !tahunValid);
			setAnakGroupInvalid($form, !anakValid);
			setMapelInvalid($form, !mapelValid);

			updateSelectionCounter($form);

			if (!kodeValid || !namaValid || !tahunValid || !anakValid || !mapelValid) {
				event.preventDefault();
				var $invalidTarget = $form.find('.is-invalid').first();
				if ($invalidTarget.length === 0 && !anakValid) {
					$invalidTarget = $form.find('.js-anak-group').first();
				}
				if ($invalidTarget.length === 0 && !mapelValid) {
					$invalidTarget = $form.find('.select2-container').first();
				}

				if ($invalidTarget.length > 0) {
					var targetElement = $invalidTarget.get(0);
					if (targetElement && typeof targetElement.scrollIntoView === 'function') {
						targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
					}
				}
			}
		});
	});
</script>