<div class="row">
	<?php if ($this->session->flashdata('success')): ?>
		<div class="col-12 mb-3">
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="col-12 mb-3">
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="col-md-8">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-cogs mr-2"></i>Pengaturan Profile LKSA
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<!-- /.card-header -->
			<?php echo form_open_multipart('admin/pengaturan'); ?>
			<div class="card-body">
				<div class="form-group">
					<label for="nama_lksa">
						<i class="fas fa-building mr-1"></i>Nama LKSA
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-building"></i></span>
						</div>
						<input type="text" class="form-control" id="nama_lksa" name="nama_lksa"
							value="<?php echo set_value('nama_lksa', $pengaturan->nama_lksa ?? ''); ?>"
							placeholder="Masukkan nama LKSA" required>
					</div>
					<?php echo form_error('nama_lksa', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-group">
					<label for="nama_kepala">
						<i class="fas fa-user-tie mr-1"></i>Nama Kepala
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
						</div>
						<input type="text" class="form-control" id="nama_kepala" name="nama_kepala"
							value="<?php echo set_value('nama_kepala', $pengaturan->nama_kepala ?? ''); ?>"
							placeholder="Masukkan nama kepala" required>
					</div>
					<?php echo form_error('nama_kepala', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="form-group">
					<label for="alamat">
						<i class="fas fa-map-marker-alt mr-1"></i>Alamat
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
						</div>
						<textarea class="form-control" id="alamat" name="alamat" rows="3"
							placeholder="Masukkan alamat lengkap"
							required><?php echo set_value('alamat', $pengaturan->alamat ?? ''); ?></textarea>
					</div>
					<?php echo form_error('alamat', '<small class="text-danger">', '</small>'); ?>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="no_telp">
								<i class="fas fa-phone mr-1"></i>No Telepon
							</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" class="form-control" id="no_telp" name="no_telp"
									value="<?php echo set_value('no_telp', $pengaturan->no_telp ?? ''); ?>"
									placeholder="Masukkan nomor telepon" required>
							</div>
							<?php echo form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="email">
								<i class="fas fa-envelope mr-1"></i>Email
							</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" class="form-control" id="email" name="email"
									value="<?php echo set_value('email', $pengaturan->email ?? ''); ?>"
									placeholder="Masukkan alamat email" required>
							</div>
							<?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="tahun_berdiri">
						<i class="fas fa-calendar-alt mr-1"></i>Tahun Berdiri
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
						</div>
						<input type="number" class="form-control" id="tahun_berdiri" name="tahun_berdiri"
							value="<?php echo set_value('tahun_berdiri', $pengaturan->tahun_berdiri ?? ''); ?>"
							placeholder="Masukkan tahun berdiri" min="1900" max="<?php echo date('Y'); ?>" required>
					</div>
					<?php echo form_error('tahun_berdiri', '<small class="text-danger">', '</small>'); ?>
				</div>
			</div>
			<!-- /.card-body -->

			<div class="card-footer text-right">
				<button type="reset" class="btn btn-secondary mr-2">
					<i class="fas fa-undo"></i> Reset
				</button>
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-save"></i> Simpan Perubahan
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card card-outline card-info">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-image mr-2"></i>Logo LKSA
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if (!empty($pengaturan->logo)): ?>
					<img src="<?php echo base_url('assets/uploads/logos/' . $pengaturan->logo); ?>" alt="Logo LKSA"
						class="img-fluid mb-3"
						style="max-height: 150px; border: 2px solid #ddd; border-radius: 8px; padding: 5px; background: #f8f9fa;">
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-image fa-3x"></i>
						<p>Belum ada logo</p>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_logo'); ?>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
						<label class="custom-file-label" for="logo">Pilih file logo</label>
					</div>
					<small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
				</div>
				<button type="submit" class="btn btn-info btn-block">
					<i class="fas fa-upload"></i> Upload Logo
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="card card-outline card-warning mt-3">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-file-alt mr-2"></i>Dokumen Legal
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if (!empty($pengaturan->dokumen_legal)): ?>
					<div class="mb-3">
						<i class="fas fa-file fa-3x text-warning"></i>
						<p class="mt-2"><?php echo $pengaturan->dokumen_legal; ?></p>
						<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
							data-target="#modalPreview">
							<i class="fas fa-eye"></i> Lihat Dokumen
						</button>
					</div>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-file-alt fa-3x"></i>
						<p>Belum ada dokumen legal</p>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_dokumen'); ?>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="dokumen" name="dokumen" accept=".pdf">
						<label class="custom-file-label" for="dokumen">Pilih file dokumen</label>
					</div>
					<small class="form-text text-muted">Format: PDF. Maksimal 5MB.</small>
				</div>
				<button type="submit" class="btn btn-warning btn-block">
					<i class="fas fa-upload"></i> Upload Dokumen
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="card card-outline card-success mt-3">
			<div class="card-header">
				<h3 class="card-title">
					<i class="fas fa-envelope-open-text mr-2"></i>Kop Surat Laporan
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if (!empty($pengaturan->kop_surat)): ?>
					<img src="<?php echo base_url('assets/uploads/kop/' . $pengaturan->kop_surat); ?>" alt="Kop Surat"
						class="img-fluid mb-3"
						style="max-height: 120px; border: 2px solid #ddd; border-radius: 8px; padding: 5px; background: #f8f9fa;">
					<p class="text-muted small">Kop surat akan muncul di bagian atas laporan PDF</p>
				<?php else: ?>
					<div class="text-muted mb-3">
						<i class="fas fa-envelope-open-text fa-3x"></i>
						<p>Belum ada kop surat</p>
						<small class="text-muted">Upload kop surat untuk digunakan di laporan PDF</small>
					</div>
				<?php endif; ?>

				<?php echo form_open_multipart('admin/upload_kop'); ?>
				<div class="form-group">
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="kop_surat" name="kop_surat" accept="image/*">
						<label class="custom-file-label" for="kop_surat">Pilih file kop surat</label>
					</div>
					<small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran disarankan:
						800x150px</small>
				</div>
				<button type="submit" class="btn btn-success btn-block">
					<i class="fas fa-upload"></i> Upload Kop Surat
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal Preview Dokumen -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalPreviewLabel">Preview Dokumen Legal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-0">
				<iframe src="<?php echo base_url('assets/uploads/documents/' . $pengaturan->dokumen_legal); ?>"
					width="100%" height="600px" frameborder="0" style="width: 100%; height: 600px;"></iframe>
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('assets/uploads/documents/' . $pengaturan->dokumen_legal); ?>"
					target="_blank" class="btn btn-primary">
					<i class="fas fa-external-link-alt"></i> Buka di Tab Baru
				</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>