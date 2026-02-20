pplication/views/admin/dashboard.php</path>
<content"><!-- Small Box Cards -->
	<div class="row">
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-info">
				<div class="inner">
					<h3>150</h3>
					<p>Total Anak</p>
				</div>
				<div class="icon">
					<i class="fas fa-child"></i>
				</div>
				<a href="<?php echo site_url('admin/anak'); ?>" class="small-box-footer">Lihat Detail <i
						class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
					<h3>53</h3>
					<p>Anak Didik</p>
				</div>
				<div class="icon">
					<i class="fas fa-user-graduate"></i>
				</div>
				<a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-warning">
				<div class="inner">
					<h3>44</h3>
					<p>Staff/Pendidik</p>
				</div>
				<div class="icon">
					<i class="fas fa-user-tie"></i>
				</div>
				<a href="<?php echo site_url('admin/staff'); ?>" class="small-box-footer">Lihat Detail <i
						class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-danger">
				<div class="inner">
					<h3>65</h3>
					<p>Kamar Terpakai</p>
				</div>
				<div class="icon">
					<i class="fas fa-bed"></i>
				</div>
				<a href="<?php echo site_url('admin/kamar'); ?>" class="small-box-footer">Lihat Detail <i
						class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
	</div>
	<!-- /.row -->

	<!-- Recent Activities & Stats -->
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">Statistik Anak</h5>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="info-box">
								<span class="info-box-icon bg-info"><i class="fas fa-child"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Anak Laki-laki</span>
									<span class="info-box-number">75</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="info-box">
								<span class="info-box-icon bg-pink"><i class="fas fa-child"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Anak Perempuan</span>
									<span class="info-box-number">75</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-4">
							<div class="info-box">
								<span class="info-box-icon bg-success"><i class="fas fa-graduation-cap"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Sekolah</span>
									<span class="info-box-number">120</span>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="info-box">
								<span class="info-box-icon bg-warning"><i class="fas fa-home"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Asrama</span>
									<span class="info-box-number">130</span>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="info-box">
								<span class="info-box-icon bg-danger"><i class="fas fa-procedures"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Dalam Perawatan</span>
									<span class="info-box-number">20</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- ./card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col -->

		<div class="col-md-4">
			<!-- Calendar -->
			<div class="card bg-gradient-success">
				<div class="card-header border-0">
					<h3 class="card-title">
						<i class="far fa-calendar-alt"></i>
						Kalender
					</h3>
				</div>
				<div class="card-body pt-0">
					<div id="calendar" style="width: 100%"></div>
				</div>
			</div>

			<!-- Recent Users -->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Aktivitas Terbaru</h3>
				</div>
				<div class="card-body p-0">
					<ul class="users-list clearfix">
						<li>
							<img src="<?php echo base_url('assets/img/user1-128x128.jpg'); ?>" alt="User Image">
							<a class="users-list-name" href="#">Ahmad</a>
							<span class="users-list-date">Hari ini</span>
						</li>
						<li>
							<img src="<?php echo base_url('assets/img/user8-128x128.jpg'); ?>" alt="User Image">
							<a class="users-list-name" href="#">Siti</a>
							<span class="users-list-date">Kemarin</span>
						</li>
						<li>
							<img src="<?php echo base_url('assets/img/user7-128x128.jpg'); ?>" alt="User Image">
							<a class="users-list-name" href="#">Budi</a>
							<span class="users-list-date">2 hari lalu</span>
						</li>
						<li>
							<img src="<?php echo base_url('assets/img/user6-128x128.jpg'); ?>" alt="User Image">
							<a class="users-list-name" href="#">Rina</a>
							<span class="users-list-date">3 hari lalu</span>
						</li>
					</ul>
				</div>
				<div class="card-footer text-center">
					<a href="javascript:void(0)">Lihat Semua Aktivitas</a>
				</div>
			</div>
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

	<!-- Quick Actions -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">Aksi Cepat</h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-12">
							<a href="<?php echo site_url('admin/anak/tambah'); ?>" class="text-decoration-none">
								<div class="info-box">
									<span class="info-box-icon bg-info"><i class="fas fa-user-plus"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Tambah Anak</span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<a href="<?php echo site_url('admin/staff/tambah'); ?>" class="text-decoration-none">
								<div class="info-box">
									<span class="info-box-icon bg-success"><i class="fas fa-user-plus"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Tambah Staff</span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<a href="<?php echo site_url('admin/keuangan/pemasukan'); ?>" class="text-decoration-none">
								<div class="info-box">
									<span class="info-box-icon bg-warning"><i class="fas fa-plus-circle"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Input Pemasukan</span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-sm-6 col-12">
							<a href="<?php echo site_url('admin/keuangan/pengeluaran'); ?>"
								class="text-decoration-none">
								<div class="info-box">
									<span class="info-box-icon bg-danger"><i class="fas fa-minus-circle"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Input Pengeluaran</span>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>