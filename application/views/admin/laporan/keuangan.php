<!-- Laporan Keuangan -->
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Laporan Keuangan</h3>
					<div class="card-tools">
						<button class="btn btn-success btn-sm" disabled
							title="Fitur akan tersedia setelah modul keuangan diimplementasikan">
							<i class="fas fa-file-pdf"></i> Export PDF
						</button>
						<button class="btn btn-primary btn-sm" disabled
							title="Fitur akan tersedia setelah modul keuangan diimplementasikan">
							<i class="fas fa-file-excel"></i> Export Excel
						</button>
					</div>

				</div>
				<div class="card-body">
					<!-- Periode Filter -->
					<div class="row mb-3">
						<div class="col-md-3">
							<label>Dari Tanggal</label>
							<input type="date" class="form-control" id="tglMulai">
						</div>
						<div class="col-md-3">
							<label>Sampai Tanggal</label>
							<input type="date" class="form-control" id="tglSelesai">
						</div>
						<div class="col-md-3">
							<label>Jenis Transaksi</label>
							<select class="form-control" id="jenisTransaksi">
								<option value="">Semua</option>
								<option value="pemasukan">Pemasukan</option>
								<option value="pengeluaran">Pengeluaran</option>
							</select>
						</div>
						<div class="col-md-3">
							<label>&nbsp;</label>
							<button class="btn btn-info btn-block" onclick="filterKeuangan()">
								<i class="fas fa-filter"></i> Tampilkan
							</button>
						</div>
					</div>

					<!-- Summary Cards -->
					<div class="row mb-3">
						<div class="col-md-4">
							<div class="small-box bg-success">
								<div class="inner">
									<h3>Rp 0</h3>
									<p>Total Pemasukan</p>
								</div>
								<div class="icon">
									<i class="fas fa-arrow-down"></i>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="small-box bg-danger">
								<div class="inner">
									<h3>Rp 0</h3>
									<p>Total Pengeluaran</p>
								</div>
								<div class="icon">
									<i class="fas fa-arrow-up"></i>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="small-box bg-info">
								<div class="inner">
									<h3>Rp 0</h3>
									<p>Saldo</p>
								</div>
								<div class="icon">
									<i class="fas fa-wallet"></i>
								</div>
							</div>
						</div>
					</div>

					<!-- Placeholder for future implementation -->
					<div class="alert alert-info">
						<h5><i class="icon fas fa-info"></i> Informasi</h5>
						Fitur laporan keuangan akan diimplementasikan setelah modul keuangan ditambahkan.
						<br><br>
						<strong>Fitur yang akan tersedia:</strong>
						<ul>
							<li>Laporan pemasukan (donasi, bantuan pemerintah, dll)</li>
							<li>Laporan pengeluaran (operasional, pendidikan, kesehatan, dll)</li>
							<li>Neraca keuangan per periode</li>
							<li>Grafik trend keuangan</li>
							<li>Export ke PDF dan Excel</li>
						</ul>
					</div>

					<!-- Empty State Table -->
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Jenis</th>
								<th>Jumlah</th>
								<th>Saldo</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="6" class="text-center">Belum ada data transaksi</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function filterKeuangan() {
		alert('Filter keuangan akan diimplementasikan');
	}
</script>