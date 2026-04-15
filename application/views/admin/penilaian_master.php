<div class="character-master-page">
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

	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-purple">
				<i class="fas fa-clipboard-check"></i>
			</div>
			<div>
				<h2>Master Penilaian Karakter</h2>
				<p>Data master untuk kebutuhan sistem penilaian karakter anak</p>
			</div>
		</div>
		<?php if ($this->session->userdata('role') == 'admin'): ?>
			<div class="header-actions">
				<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAddAspect">
					<i class="fas fa-plus"></i> Tambah Aspek
				</button>
			</div>
		<?php endif; ?>
	</div>

	<div class="stats-row">
		<div class="stat-card stat-blue">
			<div class="stat-icon"><i class="fas fa-list-ol"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($scales); ?></span>
				<span class="stat-label">Skala Penilaian</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon"><i class="fas fa-layer-group"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo count($aspects); ?></span>
				<span class="stat-label">Aspek Karakter</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon"><i class="fas fa-tasks"></i></div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_indicators; ?></span>
				<span class="stat-label">Total Indikator</span>
			</div>
		</div>
	</div>

	<div class="data-panel mb-4">
		<div class="panel-header">
			<h3><i class="fas fa-ruler"></i> Master Skala Penilaian</h3>
			<?php if ($this->session->userdata('role') == 'admin'): ?>
				<button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAddScale">
					<i class="fas fa-plus"></i> Tambah Skala
				</button>
			<?php endif; ?>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table">
					<thead>
						<tr>
							<th style="width: 90px;" class="text-center">Skor</th>
							<th>Kategori</th>
							<th>Deskripsi</th>
							<?php if ($this->session->userdata('role') == 'admin'): ?>
								<th style="width: 130px;" class="text-center">Aksi</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($scales)): ?>
							<?php foreach ($scales as $scale): ?>
								<tr>
									<td class="text-center"><span
											class="badge badge-primary"><?php echo $scale->score; ?></span></td>
									<td class="font-weight-semibold"><?php echo $scale->category; ?></td>
									<td><?php echo !empty($scale->description) ? $scale->description : '-'; ?></td>
									<?php if ($this->session->userdata('role') == 'admin'): ?>
										<td class="text-center">
											<div class="btn-group btn-group-sm">
												<button type="button" class="btn btn-warning" data-toggle="modal"
													data-target="#modalEditScale<?php echo $scale->id_scale; ?>" title="Edit">
													<i class="fas fa-edit"></i>
												</button>
												<button type="button" class="btn btn-danger" data-toggle="modal"
													data-target="#modalDeleteScale<?php echo $scale->id_scale; ?>" title="Hapus">
													<i class="fas fa-trash"></i>
												</button>
											</div>
										</td>
									<?php endif; ?>
								</tr>

								<?php if ($this->session->userdata('role') == 'admin'): ?>
									<div class="modal fade" id="modalEditScale<?php echo $scale->id_scale; ?>" tabindex="-1">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content border-0 shadow">
												<div class="modal-header bg-warning text-white">
													<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
														Skala</h5>
													<button type="button" class="close text-white"
														data-dismiss="modal"><span>&times;</span></button>
												</div>
												<?php echo form_open('admin/penilaian-karakter/master'); ?>
												<div class="modal-body p-4">
													<input type="hidden" name="form_type" value="scale">
													<input type="hidden" name="id_scale" value="<?php echo $scale->id_scale; ?>">

													<div class="form-row">
														<div class="form-group col-md-4">
															<label class="font-weight-bold text-muted mb-2">Skor</label>
															<input type="number" class="form-control" name="score"
																value="<?php echo (int) $scale->score; ?>" required>
														</div>
														<div class="form-group col-md-8">
															<label class="font-weight-bold text-muted mb-2">Kategori</label>
															<input type="text" class="form-control" name="category"
																value="<?php echo $scale->category; ?>" required>
														</div>
													</div>

													<div class="form-group mb-0">
														<label class="font-weight-bold text-muted mb-2">Deskripsi</label>
														<textarea class="form-control" name="description"
															rows="3"><?php echo $scale->description; ?></textarea>
													</div>
												</div>
												<div class="modal-footer bg-light">
													<button type="button" class="btn btn-secondary"
														data-dismiss="modal">Batal</button>
													<button type="submit" class="btn btn-warning text-white font-weight-bold">
														<i class="fas fa-save mr-1"></i>Simpan Perubahan
													</button>
												</div>
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>

									<div class="modal fade" id="modalDeleteScale<?php echo $scale->id_scale; ?>" tabindex="-1">
										<div class="modal-dialog modal-dialog-centered modal-sm">
											<div class="modal-content border-0 shadow text-center">
												<div class="modal-header bg-danger text-white">
													<h5 class="modal-title font-weight-bold"><i
															class="fas fa-trash-alt mr-2"></i>Hapus Skala</h5>
													<button type="button" class="close text-white"
														data-dismiss="modal"><span>&times;</span></button>
												</div>
												<div class="modal-body p-4">
													<p class="mb-1">Hapus skala skor:</p>
													<p class="font-weight-bold text-primary mb-3"><?php echo (int) $scale->score; ?>
														- <?php echo $scale->category; ?>?</p>
												</div>
												<div class="modal-footer bg-light justify-content-center">
													<button type="button" class="btn btn-secondary px-4"
														data-dismiss="modal">Batal</button>
													<a href="<?php echo site_url('admin/penilaian-karakter/master?delete_scale=' . $scale->id_scale); ?>"
														class="btn btn-danger px-4 font-weight-bold">
														<i class="fas fa-trash mr-1"></i>Ya, Hapus
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="<?php echo $this->session->userdata('role') == 'admin' ? '4' : '3'; ?>"
									class="text-center text-muted">Belum ada data skala penilaian.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-sitemap"></i> Master Aspek & Indikator</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table">
					<thead>
						<tr>
							<th style="width: 80px;" class="text-center">Urutan</th>
							<th>Nama Aspek</th>
							<th style="width: 170px;" class="text-center">Jumlah Indikator</th>
							<th>Deskripsi</th>
							<?php if ($this->session->userdata('role') == 'admin'): ?>
								<th style="width: 130px;" class="text-center">Aksi</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($aspects)): ?>
							<?php foreach ($aspects as $aspect): ?>
								<tr>
									<td class="text-center"><?php echo (int) $aspect->order; ?></td>
									<td>
										<div class="font-weight-semibold"><?php echo $aspect->aspect_name; ?></div>
										<small class="text-muted"><?php echo $aspect->aspect_code; ?></small>
									</td>
									<td class="text-center"><span
											class="badge badge-info"><?php echo (int) $aspect->total_indicators; ?></span></td>
									<td><?php echo !empty($aspect->description) ? $aspect->description : '-'; ?></td>
									<?php if ($this->session->userdata('role') == 'admin'): ?>
										<td class="text-center">
											<div class="btn-group btn-group-sm">
												<button type="button" class="btn btn-warning" data-toggle="modal"
													data-target="#modalEditAspect<?php echo $aspect->id_aspect; ?>" title="Edit">
													<i class="fas fa-edit"></i>
												</button>
												<button type="button" class="btn btn-danger" data-toggle="modal"
													data-target="#modalDeleteAspect<?php echo $aspect->id_aspect; ?>" title="Hapus">
													<i class="fas fa-trash"></i>
												</button>
											</div>
										</td>
									<?php endif; ?>
								</tr>

								<?php if ($this->session->userdata('role') == 'admin'): ?>
									<div class="modal fade" id="modalEditAspect<?php echo $aspect->id_aspect; ?>" tabindex="-1">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content border-0 shadow">
												<div class="modal-header bg-warning text-white">
													<h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
														Aspek</h5>
													<button type="button" class="close text-white"
														data-dismiss="modal"><span>&times;</span></button>
												</div>
												<?php echo form_open('admin/penilaian-karakter/master'); ?>
												<div class="modal-body p-4">
													<input type="hidden" name="form_type" value="aspect">
													<input type="hidden" name="id_aspect" value="<?php echo $aspect->id_aspect; ?>">

													<div class="form-group mb-3">
														<label class="font-weight-bold text-muted mb-2">Nama Aspek</label>
														<input type="text" class="form-control" name="aspect_name"
															value="<?php echo $aspect->aspect_name; ?>" required>
													</div>

													<div class="form-row">
														<div class="form-group col-md-7">
															<label class="font-weight-bold text-muted mb-2">Kode Aspek</label>
															<input type="text" class="form-control" name="aspect_code"
																value="<?php echo $aspect->aspect_code; ?>" required>
														</div>
														<div class="form-group col-md-5">
															<label class="font-weight-bold text-muted mb-2">Urutan</label>
															<input type="number" class="form-control" name="order"
																value="<?php echo (int) $aspect->order; ?>" required>
														</div>
													</div>

													<div class="form-group mb-0">
														<label class="font-weight-bold text-muted mb-2">Deskripsi</label>
														<textarea class="form-control" name="description"
															rows="3"><?php echo $aspect->description; ?></textarea>
													</div>
												</div>
												<div class="modal-footer bg-light">
													<button type="button" class="btn btn-secondary"
														data-dismiss="modal">Batal</button>
													<button type="submit" class="btn btn-warning text-white font-weight-bold">
														<i class="fas fa-save mr-1"></i>Simpan Perubahan
													</button>
												</div>
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>

									<div class="modal fade" id="modalDeleteAspect<?php echo $aspect->id_aspect; ?>" tabindex="-1">
										<div class="modal-dialog modal-dialog-centered modal-sm">
											<div class="modal-content border-0 shadow text-center">
												<div class="modal-header bg-danger text-white">
													<h5 class="modal-title font-weight-bold"><i
															class="fas fa-trash-alt mr-2"></i>Hapus Aspek</h5>
													<button type="button" class="close text-white"
														data-dismiss="modal"><span>&times;</span></button>
												</div>
												<div class="modal-body p-4">
													<p class="mb-1">Hapus aspek:</p>
													<p class="font-weight-bold text-primary mb-3">
														<?php echo $aspect->aspect_name; ?>?
													</p>
													<p class="text-muted small mb-0">Indikator terkait juga akan terhapus.</p>
												</div>
												<div class="modal-footer bg-light justify-content-center">
													<button type="button" class="btn btn-secondary px-4"
														data-dismiss="modal">Batal</button>
													<a href="<?php echo site_url('admin/penilaian-karakter/master?delete_aspect=' . $aspect->id_aspect); ?>"
														class="btn btn-danger px-4 font-weight-bold">
														<i class="fas fa-trash mr-1"></i>Ya, Hapus
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="<?php echo $this->session->userdata('role') == 'admin' ? '5' : '4'; ?>"
									class="text-center text-muted">Belum ada data aspek penilaian.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php if ($this->session->userdata('role') == 'admin'): ?>
	<div class="modal fade" id="modalAddScale" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Skala Penilaian</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<?php echo form_open('admin/penilaian-karakter/master'); ?>
				<div class="modal-body p-4">
					<input type="hidden" name="form_type" value="scale">

					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="font-weight-bold text-muted mb-2">Skor</label>
							<input type="number" class="form-control" name="score" placeholder="1" required>
						</div>
						<div class="form-group col-md-8">
							<label class="font-weight-bold text-muted mb-2">Kategori</label>
							<input type="text" class="form-control" name="category" placeholder="Contoh: Baik" required>
						</div>
					</div>

					<div class="form-group mb-0">
						<label class="font-weight-bold text-muted mb-2">Deskripsi</label>
						<textarea class="form-control" name="description" rows="3"
							placeholder="Deskripsi skala (opsional)"></textarea>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary font-weight-bold">
						<i class="fas fa-save mr-1"></i>Simpan
					</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalAddAspect" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border-0 shadow">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Aspek Penilaian</h5>
					<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<?php echo form_open('admin/penilaian-karakter/master'); ?>
				<div class="modal-body p-4">
					<input type="hidden" name="form_type" value="aspect">

					<div class="form-group mb-3">
						<label class="font-weight-bold text-muted mb-2">Nama Aspek</label>
						<input type="text" class="form-control" name="aspect_name" placeholder="Contoh: Kepemimpinan"
							required>
					</div>

					<div class="form-row">
						<div class="form-group col-md-7">
							<label class="font-weight-bold text-muted mb-2">Kode Aspek</label>
							<input type="text" class="form-control" name="aspect_code" placeholder="Contoh: LEADERSHIP"
								required>
						</div>
						<div class="form-group col-md-5">
							<label class="font-weight-bold text-muted mb-2">Urutan</label>
							<input type="number" class="form-control" name="order" value="0" required>
						</div>
					</div>

					<div class="form-group mb-0">
						<label class="font-weight-bold text-muted mb-2">Deskripsi</label>
						<textarea class="form-control" name="description" rows="3"
							placeholder="Deskripsi aspek (opsional)"></textarea>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary font-weight-bold">
						<i class="fas fa-save mr-1"></i>Simpan
					</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<style>
	.character-master-page {
		padding: 10px;
	}

	.character-master-page .page-header {
		background: #fff;
		border-radius: 16px;
		padding: 25px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.character-master-page .header-actions {
		display: flex;
		gap: 12px;
	}

	.character-master-page .btn-export-primary {
		padding: 10px 20px;
		background: #4e73df;
		color: #fff;
		border: none;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
		transition: all 0.3s ease;
		cursor: pointer;
	}

	.character-master-page .btn-export-primary:hover {
		background: #2e59d9;
	}

	.character-master-page .header-info {
		display: flex;
		align-items: center;
		gap: 20px;
	}

	.character-master-page .header-icon {
		width: 60px;
		height: 60px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26px;
	}

	.character-master-page .bg-purple {
		background: rgba(111, 66, 193, 0.12);
		color: #6f42c1;
	}

	.character-master-page .header-info h2 {
		margin: 0 0 5px;
		font-size: 22px;
		font-weight: 600;
		color: #2d3748;
	}

	.character-master-page .header-info p {
		margin: 0;
		color: #718096;
		font-size: 14px;
	}

	.character-master-page .stats-row {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.character-master-page .stat-card {
		background: #fff;
		border-radius: 14px;
		padding: 22px;
		display: flex;
		align-items: center;
		gap: 18px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.character-master-page .stat-icon {
		width: 55px;
		height: 55px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	.character-master-page .stat-blue .stat-icon {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.character-master-page .stat-green .stat-icon {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	.character-master-page .stat-orange .stat-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.character-master-page .stat-number {
		font-size: 28px;
		font-weight: 700;
		color: #2d3748;
		line-height: 1;
	}

	.character-master-page .stat-label {
		font-size: 13px;
		color: #718096;
		margin-top: 5px;
		display: block;
	}

	.character-master-page .data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.character-master-page .panel-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 12px;
	}

	.character-master-page .panel-header h3 {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #2d3748;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.character-master-page .panel-header i {
		color: #4e73df;
	}

	.character-master-page .data-table {
		width: 100%;
		border-collapse: collapse;
	}

	.character-master-page .data-table th {
		padding: 15px 20px;
		font-size: 12px;
		font-weight: 600;
		color: #718096;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		background: #f8fafc;
		border-bottom: 1px solid #e2e8f0;
	}

	.character-master-page .data-table td {
		padding: 16px 20px;
		border-bottom: 1px solid #edf2f7;
		vertical-align: middle;
		font-size: 14px;
		color: #2d3748;
	}

	.character-master-page .data-table tbody tr:hover {
		background: #f8fafc;
	}

	.character-master-page .font-weight-semibold {
		font-weight: 600;
	}

	@media (max-width: 992px) {
		.character-master-page .page-header {
			flex-direction: column;
			align-items: flex-start;
			gap: 15px;
		}

		.character-master-page .stats-row {
			grid-template-columns: 1fr;
		}
	}
</style>