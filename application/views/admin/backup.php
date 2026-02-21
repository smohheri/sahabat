<!-- Backup & Restore - Redesain Modern -->
<div class="backup-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-shield-alt"></i>
			</div>
			<div>
				<h2>Backup & Restore</h2>
				<p>Kelola backup dan restore data sistem LKSA</p>
			</div>
		</div>
		<div class="header-actions">
			<button class="btn btn-export-primary" onclick="location.reload()">
				<i class="fas fa-sync-alt"></i> Refresh
			</button>
		</div>
	</div>

	<!-- Flash Messages -->
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

	<!-- Stats Cards -->
	<div class="stats-row">
		<?php
		$backup_dirs = [
			'database' => FCPATH . 'assets/backups/database/',
			'files' => FCPATH . 'assets/backups/files/'
		];

		$db_count = 0;
		$file_count = 0;
		$total_size = 0;

		foreach ($backup_dirs as $type => $dir) {
			if (is_dir($dir)) {
				$files = array_diff(scandir($dir), array('.', '..'));
				if ($type == 'database') {
					$db_count = count($files);
				} else {
					$file_count = count($files);
				}
				foreach ($files as $file) {
					$total_size += filesize($dir . $file);
				}
			}
		}

		$total_backups = $db_count + $file_count;
		$size_formatted = $total_size >= 1048576 ? number_format($total_size / 1048576, 1) . ' MB' : number_format($total_size / 1024, 1) . ' KB';
		?>
		<div class="stat-card stat-blue">
			<div class="stat-icon">
				<i class="fas fa-database"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $db_count; ?></span>
				<span class="stat-label">Database Backup</span>
			</div>
		</div>

		<div class="stat-card stat-green">
			<div class="stat-icon">
				<i class="fas fa-file-archive"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $file_count; ?></span>
				<span class="stat-label">File Backup</span>
			</div>
		</div>

		<div class="stat-card stat-orange">
			<div class="stat-icon">
				<i class="fas fa-weight"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $size_formatted; ?></span>
				<span class="stat-label">Total Ukuran</span>
			</div>
		</div>

		<div class="stat-card stat-purple">
			<div class="stat-icon">
				<i class="fas fa-shield-alt"></i>
			</div>
			<div class="stat-info">
				<span class="stat-number"><?php echo $total_backups; ?></span>
				<span class="stat-label">Total Backup</span>
			</div>
		</div>
	</div>

	<!-- Action Cards -->
	<div class="action-row">
		<div class="action-card">
			<div class="action-header">
				<div class="action-icon bg-primary">
					<i class="fas fa-download"></i>
				</div>
				<div class="action-info">
					<h3>Buat Backup</h3>
					<p>Buat backup database dan file sistem</p>
				</div>
			</div>
			<div class="action-buttons">
				<?php echo form_open('admin/backup', ['class' => 'd-inline']); ?>
				<button type="submit" name="backup_database" class="btn btn-primary btn-action" id="backup-db-btn">
					<i class="fas fa-database mr-2"></i>Backup Database
					<span class="spinner-border spinner-border-sm d-none" role="status"></span>
				</button>
				<?php echo form_close(); ?>

				<?php echo form_open('admin/backup', ['class' => 'd-inline ml-2']); ?>
				<button type="submit" name="backup_files" class="btn btn-success btn-action" id="backup-files-btn">
					<i class="fas fa-file-archive mr-2"></i>Backup Files
					<span class="spinner-border spinner-border-sm d-none" role="status"></span>
				</button>
				<?php echo form_close(); ?>
			</div>
		</div>

		<div class="action-card">
			<div class="action-header">
				<div class="action-icon bg-warning">
					<i class="fas fa-upload"></i>
				</div>
				<div class="action-info">
					<h3>Restore Data</h3>
					<p>Restore database dan file dari backup</p>
				</div>
			</div>
			<div class="action-buttons">
				<button class="btn btn-warning btn-action" data-toggle="modal" data-target="#modalRestoreDB">
					<i class="fas fa-database mr-2"></i>Restore Database
				</button>
				<button class="btn btn-info btn-action ml-2" data-toggle="modal" data-target="#modalRestoreFiles">
					<i class="fas fa-file-archive mr-2"></i>Restore Files
				</button>
			</div>
		</div>
	</div>

	<!-- Data Table -->
	<div class="data-panel">
		<div class="panel-header">
			<h3><i class="fas fa-history"></i> Riwayat Backup</h3>
			<span class="data-count"><?php echo $total_backups; ?> file backup</span>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="data-table" id="tableBackup">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama File</th>
							<th>Tipe Backup</th>
							<th>Ukuran</th>
							<th>Tanggal Dibuat</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$all_backups = [];

						foreach ($backup_dirs as $type => $dir) {
							if (is_dir($dir)) {
								$files = array_diff(scandir($dir), array('.', '..'));
								foreach ($files as $file) {
									$file_path = $dir . $file;
									$file_size = filesize($file_path);
									$file_date = filemtime($file_path);
									$all_backups[] = [
										'file' => $file,
										'type' => $type,
										'size' => $file_size,
										'date' => $file_date,
										'path' => $file_path
									];
								}
							}
						}

						// Sort by date descending
						usort($all_backups, function ($a, $b) {
							return $b['date'] - $a['date'];
						});

						foreach ($all_backups as $backup): ?>
							<tr>
								<td><?php echo $no++; ?></td>
								<td>
									<div class="file-cell">
										<i
											class="fas fa-file-<?php echo $backup['type'] == 'database' ? 'code' : 'archive'; ?> text-<?php echo $backup['type'] == 'database' ? 'primary' : 'success'; ?>"></i>
										<span><?php echo $backup['file']; ?></span>
									</div>
								</td>
								<td>
									<span
										class="badge badge-<?php echo $backup['type'] == 'database' ? 'primary' : 'success'; ?>">
										<?php echo ucfirst($backup['type']); ?>
									</span>
								</td>
								<td><?php echo $backup['size'] >= 1048576 ? number_format($backup['size'] / 1048576, 1) . ' MB' : number_format($backup['size'] / 1024, 1) . ' KB'; ?>
								</td>
								<td><?php echo date("d M Y H:i", $backup['date']); ?></td>
								<td>
									<div class="btn-group">
										<a href="<?php echo base_url('admin/download_backup/' . $backup['type'] . '/' . $backup['file']); ?>"
											class="btn btn-sm btn-outline-primary" title="Download">
											<i class="fas fa-download"></i>
										</a>
										<button class="btn btn-sm btn-outline-danger" title="Hapus"
											onclick="deleteBackup('<?php echo $backup['type']; ?>', '<?php echo $backup['file']; ?>')">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>

						<?php if (empty($all_backups)): ?>
							<tr>
								<td colspan="6" class="text-center text-muted py-4">
									<i class="fas fa-inbox fa-2x mb-2"></i><br>
									Belum ada file backup
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Restore Database -->
<div class="modal fade" id="modalRestoreDB" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-warning text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-database mr-2"></i>Restore Database</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<?php echo form_open_multipart('admin/restore_database', ['id' => 'restore-db-form']); ?>
			<div class="modal-body p-4">
				<div class="alert alert-danger">
					<i class="fas fa-exclamation-triangle mr-2"></i>
					<strong>Perhatian!</strong> Restore database akan menimpa semua data yang ada. Pastikan Anda telah
					membuat backup data saat ini.
				</div>

				<div class="form-group">
					<label for="db_file">Pilih File SQL Backup</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="db_file" name="db_file" accept=".sql"
								required>
							<label class="custom-file-label" for="db_file">Pilih file...</label>
						</div>
					</div>
					<small class="form-text text-muted">Format: .sql</small>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-warning text-white font-weight-bold" id="restore-db-btn">
					<i class="fas fa-upload mr-1"></i>Restore Database
					<span class="spinner-border spinner-border-sm d-none" role="status"></span>
				</button>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Restore Files -->
<div class="modal fade" id="modalRestoreFiles" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-0 shadow">
			<div class="modal-header bg-info text-white">
				<h5 class="modal-title font-weight-bold"><i class="fas fa-file-archive mr-2"></i>Restore Files</h5>
				<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<?php echo form_open_multipart('admin/restore_files', ['id' => 'restore-files-form']); ?>
			<div class="modal-body p-4">
				<div class="alert alert-warning">
					<i class="fas fa-exclamation-circle mr-2"></i>
					<strong>Perhatian!</strong> Restore files akan menimpa file yang ada dengan versi dari backup.
				</div>

				<div class="form-group">
					<label for="files_zip">Pilih File ZIP Backup</label>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="files_zip" name="files_zip" accept=".zip"
								required>
							<label class="custom-file-label" for="files_zip">Pilih file...</label>
						</div>
					</div>
					<small class="form-text text-muted">Format: .zip</small>
				</div>
			</div>
			<div class="modal-footer bg-light">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-info text-white font-weight-bold" id="restore-files-btn">
					<i class="fas fa-upload mr-1"></i>Restore Files
					<span class="spinner-border spinner-border-sm d-none" role="status"></span>
				</button>
			</div>
			</form>
		</div>
	</div>
</div>

<style>
	/* Page Container */
	.backup-page {
		padding: 10px;
	}

	/* Page Header */
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

	.bg-blue {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
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

	.btn-export-primary {
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

	.btn-export-primary:hover {
		background: #2e59d9;
	}

	/* Stats Row */
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

	.stat-orange .stat-icon {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
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

	.stat-label {
		font-size: 13px;
		color: #718096;
		margin-top: 5px;
	}

	/* Action Row */
	.action-row {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 20px;
		margin-bottom: 25px;
	}

	.action-card {
		background: #fff;
		border-radius: 14px;
		padding: 25px;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.action-header {
		display: flex;
		align-items: center;
		gap: 18px;
		margin-bottom: 20px;
	}

	.action-icon {
		width: 50px;
		height: 50px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 22px;
	}

	.bg-primary {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.bg-warning {
		background: rgba(246, 194, 62, 0.1);
		color: #f6c23e;
	}

	.action-info h3 {
		margin: 0 0 5px;
		font-size: 18px;
		font-weight: 600;
		color: #2d3748;
	}

	.action-info p {
		margin: 0;
		color: #718096;
		font-size: 14px;
	}

	.action-buttons {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 10px;
	}

	.btn-action {
		padding: 12px 20px;
		border-radius: 10px;
		font-weight: 500;
		font-size: 14px;
		display: flex;
		align-items: center;
		border: none;
		transition: all 0.3s ease;
	}

	.btn-action:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
	}

	/* Data Panel */
	.data-panel {
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
	}

	.panel-header {
		padding: 20px 25px;
		border-bottom: 1px solid #edf2f7;
		display: flex;
		justify-content: space-between;
		align-items: center;
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
		color: #4e73df;
	}

	.data-count {
		background: #f8fafc;
		padding: 6px 14px;
		border-radius: 20px;
		font-size: 13px;
		color: #718096;
		font-weight: 500;
	}

	.panel-body {
		padding: 0;
	}

	.table-responsive {
		overflow-x: auto;
	}

	/* Data Table */
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
		padding: 16px 20px;
		border-bottom: 1px solid #edf2f7;
		vertical-align: middle;
		font-size: 14px;
		color: #2d3748;
	}

	.data-table tbody tr:hover {
		background: #f8fafc;
	}

	.data-table tbody tr:last-child td {
		border-bottom: none;
	}

	/* File Cell */
	.file-cell {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	/* Badges */
	.badge {
		display: inline-flex;
		padding: 5px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-primary {
		background: rgba(78, 115, 223, 0.1);
		color: #4e73df;
	}

	.badge-success {
		background: rgba(28, 200, 138, 0.1);
		color: #1cc88a;
	}

	/* Modal Styles */
	.modal-content {
		border-radius: 12px;
		overflow: hidden;
	}

	.custom-file-label {
		border-radius: 6px;
	}

	/* Responsive */
	@media (max-width: 1200px) {
		.stats-row {
			grid-template-columns: repeat(2, 1fr);
		}

		.action-row {
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

		.action-row {
			grid-template-columns: 1fr;
		}
	}

	/* Dark Mode Styles */
	body.dark-mode .backup-page {
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

	body.dark-mode .stat-label {
		color: #a0a0a0;
	}

	body.dark-mode .action-card {
		background-color: #16213e;
		border-color: #0f3460;
	}

	body.dark-mode .action-info h3 {
		color: #e0e0e0;
	}

	body.dark-mode .action-info p {
		color: #a0a0a0;
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

	body.dark-mode .data-count {
		background-color: #0f3460;
		color: #a0a0a0;
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

	body.dark-mode .text-muted {
		color: #a0a0a0 !important;
	}
</style>

<script>
	$(document).ready(function () {
		// File input label update
		$('.custom-file-input').on('change', function () {
			var fileName = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').html(fileName || 'Pilih file...');
		});

		// Backup button loading state
		$('#backup-db-btn').on('click', function () {
			$(this).prop('disabled', true);
			$(this).find('.spinner-border').removeClass('d-none');
		});

		$('#backup-files-btn').on('click', function () {
			$(this).prop('disabled', true);
			$(this).find('.spinner-border').removeClass('d-none');
		});

		// Restore confirmation
		$('#restore-db-form').on('submit', function (e) {
			if (!confirm('Apakah Anda yakin ingin merestore database? Data yang ada akan ditimpa dan tidak dapat dikembalikan!')) {
				e.preventDefault();
				return false;
			}
			$('#restore-db-btn').prop('disabled', true);
			$('#restore-db-btn').find('.spinner-border').removeClass('d-none');
		});

		$('#restore-files-form').on('submit', function (e) {
			if (!confirm('Apakah Anda yakin ingin merestore files? File yang ada akan ditimpa!')) {
				e.preventDefault();
				return false;
			}
			$('#restore-files-btn').prop('disabled', true);
			$('#restore-files-btn').find('.spinner-border').removeClass('d-none');
		});
	});

	function deleteBackup(type, filename) {
		if (confirm('Apakah Anda yakin ingin menghapus file backup ini?')) {
			// Implement delete functionality if needed
			// For now, just show alert
			alert('Fitur hapus backup belum diimplementasikan. Hapus manual dari folder assets/backups/' + type + '/');
		}
	}
</script>