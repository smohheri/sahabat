<!-- Log Aktivitas User -->
<div class="container-fluid">
	<!-- Flash Messages -->
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
			<?php echo $this->session->flashdata('error'); ?>
			<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
		</div>
	<?php endif; ?>

	<div class="card shadow-sm border-0">
		<div class="card-header bg-info text-white py-3">
			<h5 class="mb-0 font-weight-bold"><i class="fas fa-history mr-2"></i>Log Aktivitas User</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover mb-0" id="tableLogs">
					<thead class="bg-light">
						<tr>
							<th class="text-center" style="width: 60px;">No</th>
							<th>Nama User</th>
							<th>Username</th>
							<th>Aktivitas</th>
							<th>Deskripsi</th>
							<th>IP Address</th>
							<th>Waktu</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($logs as $log): ?>
							<tr>
								<td class="text-center text-muted"><?php echo $no++; ?></td>
								<td><?php echo $log->nama; ?></td>
								<td><?php echo $log->username; ?></td>
								<td>
									<span
										class="badge badge-<?php echo $log->activity == 'login' ? 'success' : 'warning'; ?> px-3 py-2 font-weight-normal">
										<i
											class="fas fa-<?php echo $log->activity == 'login' ? 'sign-in-alt' : 'sign-out-alt'; ?> mr-1"></i>
										<?php echo ucfirst($log->activity); ?>
									</span>
								</td>
								<td><?php echo $log->description; ?></td>
								<td><?php echo $log->ip_address; ?></td>
								<td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#tableLogs').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": false,
			"autoWidth": false,
			"responsive": true,
			"pageLength": 25,
			"order": [[6, 'desc']],
			"language": {
				"search": "Cari:",
				"zeroRecords": "Tidak ada data log",
				"paginate": {
					"previous": "<",
					"next": ">"
				}
			}
		});
	});
</script>

<style>
	.font-weight-semibold {
		font-weight: 600;
	}

	.table td,
	.table th {
		padding: 1rem;
		vertical-align: middle;
		border-top: none;
		border-bottom: 1px solid #e9ecef;
	}

	.table tbody tr:hover {
		background-color: #f8f9fa;
	}

	.badge {
		border-radius: 6px;
		font-size: 13px;
	}

	.card {
		border-radius: 12px;
	}

	.card-header {
		border-radius: 12px 12px 0 0 !important;
	}
</style>