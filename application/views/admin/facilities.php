<!-- Select2 CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<!-- Select2 JS -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>

<!-- Kelola Fasilitas Landing Page -->
<div class="laporan-page">
	<!-- Page Header -->
	<div class="page-header">
		<div class="header-info">
			<div class="header-icon bg-blue">
				<i class="fas fa-building"></i>
			</div>
			<div>
				<h2>Kelola Fasilitas</h2>
				<p>Atur fasilitas yang ditampilkan di landing page</p>
			</div>
		</div>
		<div class="header-actions">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFacilityModal">
				<i class="fas fa-plus mr-2"></i>Tambah Fasilitas
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

	<!-- Content Grid -->
	<div class="content-grid">
		<!-- Main Content -->
		<div class="content-main">
			<!-- Facilities Grid -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-building"></i> Fasilitas</h3>
					<span class="data-count"><?php echo count($facilities); ?> fasilitas</span>
				</div>
				<div class="panel-body">
					<?php if (!empty($facilities)): ?>
						<div class="row">
							<?php foreach ($facilities as $facility): ?>
								<div class="col-md-6 mb-4">
									<div class="card">
										<div class="card-body p-0 position-relative">
											<?php
											$image_path = !empty($facility->gambar) ? 'assets/uploads/facilities/' . $facility->gambar : 'https://source.unsplash.com/random/600x400/?' . urlencode(strtolower($facility->nama_fasilitas));
											?>
											<a href="<?php echo base_url($image_path); ?>" data-toggle="lightbox"
												data-title="<?php echo $facility->nama_fasilitas; ?>">
												<img src="<?php echo base_url($image_path); ?>" class="img-fluid"
													alt="<?php echo $facility->nama_fasilitas; ?>">
											</a>
											<div class="position-absolute" style="top: 10px; right: 10px; z-index: 10;">
												<?php if ($facility->is_active): ?>
													<span class="badge bg-success"><i class="fas fa-check-circle"></i> Aktif</span>
												<?php endif; ?>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-12">
													<h5 class="card-title"><?php echo $facility->nama_fasilitas; ?></h5>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<?php if ($facility->deskripsi): ?>
														<p class="card-text description">
															<?php echo substr($facility->deskripsi, 0, 80) . (strlen($facility->deskripsi) > 80 ? '...' : ''); ?>
														</p>
													<?php endif; ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 d-flex align-items-center">
													<p class="card-text">
														<small class="text-muted">Urutan:
															<?php echo $facility->sort_order; ?></small>
													</p>
												</div>
												<div class="col-md-6 d-flex align-items-center justify-content-end">
													<button class="btn btn-danger btn-sm delete-btn"
														data-id="<?php echo $facility->id_fasilitas; ?>" title="Hapus">
														<i class="fas fa-trash"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php else: ?>
						<div class="empty-state">
							<div class="empty-icon">
								<i class="fas fa-building"></i>
							</div>
							<h3>Belum ada fasilitas</h3>
							<p>Klik tombol "Tambah Fasilitas" untuk menambah fasilitas pertama</p>
							<button type="button" class="btn btn-primary" data-toggle="modal"
								data-target="#addFacilityModal">
								<i class="fas fa-plus mr-2"></i>Tambah Fasilitas Pertama
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Sidebar -->
		<div class="content-side">
			<!-- Information Panel -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-info-circle"></i> Informasi</h3>
				</div>
				<div class="panel-body">
					<div class="info-content">
						<div class="info-section">
							<h4><i class="fas fa-lightbulb text-warning"></i> Cara Penggunaan</h4>
							<ul class="info-list">
								<li>Klik "Tambah Fasilitas" untuk menambah fasilitas baru</li>
								<li>Upload gambar atau gunakan gambar default dari Unsplash</li>
								<li>Pilih icon yang sesuai dari FontAwesome</li>
								<li>Fasilitas aktif akan ditampilkan di landing page</li>
								<li>Urutan menentukan posisi tampilan fasilitas</li>
							</ul>
						</div>
						<div class="info-section">
							<h4><i class="fas fa-exclamation-triangle text-danger"></i> Catatan</h4>
							<ul class="info-list">
								<li>Pastikan gambar berkualitas baik (minimal 600x400px)</li>
								<li>Ukuran file maksimal 2MB per gambar</li>
								<li>Format yang didukung: JPG, JPEG, PNG</li>
								<li>Jika tidak upload gambar, akan menggunakan gambar default</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Statistics Panel -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-chart-bar"></i> Statistik</h3>
				</div>
				<div class="panel-body">
					<div class="stats-grid">
						<div class="stat-item">
							<div class="stat-number"><?php echo count($facilities); ?></div>
							<div class="stat-label">Total Fasilitas</div>
						</div>
						<div class="stat-item">
							<div class="stat-number">
								<?php echo count(array_filter($facilities, function ($f) {
									return $f->is_active;
								})); ?>
							</div>
							<div class="stat-label">Fasilitas Aktif</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Preview Links -->
			<div class="data-panel">
				<div class="panel-header">
					<h3><i class="fas fa-external-link-alt"></i> Pratinjau</h3>
				</div>
				<div class="panel-body">
					<div class="preview-links">
						<a href="<?php echo base_url(); ?>" target="_blank" class="preview-btn">
							<i class="fas fa-globe mr-2"></i>
							<span>Lihat Landing Page</span>
							<i class="fas fa-external-link-alt ml-2"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Add Facility Modal -->
<div class="modal fade" id="addFacilityModal" tabindex="-1" role="dialog" aria-labelledby="addFacilityModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addFacilityModalLabel">Tambah Fasilitas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php echo form_open_multipart('admin/facilities/upload'); ?>
			<div class="modal-body">
				<div class="form-group">
					<label for="nama_fasilitas">Nama Fasilitas</label>
					<input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas"
						placeholder="Masukkan nama fasilitas" required>
				</div>
				<div class="form-group">
					<label for="deskripsi">Deskripsi</label>
					<textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
						placeholder="Masukkan deskripsi fasilitas" required></textarea>
				</div>
				<div class="form-group">
					<label for="facility_image">Upload Gambar (Opsional)</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input" id="facility_image" name="facility_image"
							accept="image/*">
						<label class="custom-file-label" for="facility_image">Pilih file gambar...</label>
					</div>
					<small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Jika tidak diupload, akan
						menggunakan gambar default.</small>
				</div>
				<div class="form-group">
					<label for="icon">Icon (FontAwesome)</label>
					<select class="form-control select2" id="icon" name="icon" required style="width: 100%;">
						<option value="">Pilih Icon</option>
						<!-- Fasilitas Rumah & Tempat Tinggal -->
						<optgroup label="Fasilitas Rumah & Tempat Tinggal">
							<option value="fa-home">fa-home (Rumah)</option>
							<option value="fa-house">fa-house (Rumah)</option>
							<option value="fa-building">fa-building (Gedung)</option>
							<option value="fa-city">fa-city (Kota)</option>
							<option value="fa-house-user">fa-house-user (Rumah User)</option>
							<option value="fa-hotel">fa-hotel (Hotel)</option>
							<option value="fa-campground">fa-campground (Kemah)</option>
							<option value="fa-igloo">fa-igloo (Igloo)</option>
							<option value="fa-door-open">fa-door-open (Pintu)</option>
							<option value="fa-door-closed">fa-door-closed (Pintu Tertutup)</option>
							<option value="fa-bed">fa-bed (Tempat Tidur)</option>
							<option value="fa-bath">fa-bath (Kamar Mandi)</option>
							<option value="fa-toilet">fa-toilet (Toilet)</option>
							<option value="fa-couch">fa-couch (Sofa)</option>
							<option value="fa-chair">fa-chair (Kursi)</option>
							<option value="fa-desk">fa-desk (Meja Kerja)</option>
							<option value="fa-archive">fa-archive (Arsip)</option>
							<option value="fa-warehouse">fa-warehouse (Gudang)</option>
							<option value="fa-store">fa-store (Toko)</option>
							<option value="fa-shop">fa-shop (Belanja)</option>
							<option value="fa-school">fa-school (Sekolah)</option>
							<option value="fa-university">fa-university (Universitas)</option>
							<option value="fa-place-of-worship">fa-place-of-worship (Tempat Ibadah)</option>
							<option value="fa-gopuram">fa-gopuram (Kuil)</option>
							<option value="fa-vihara">fa-vihara (Vihara)</option>
							<option value="fa-kaaba">fa-kaaba (Ka'bah)</option>
							<option value="fa-torii-gate">fa-torii-gate (Gerbang Torii)</option>
							<option value="fa-landmark">fa-landmark (Landmark)</option>
							<option value="fa-monument">fa-monument (Monumen)</option>
							<option value="fa-archway">fa-archway (Gerbang)</option>
							<option value="fa-industry">fa-industry (Industri)</option>
							<option value="fa-factory">fa-factory (Pabrik)</option>
							<option value="fa-gas-pump">fa-gas-pump (Pom Bensin)</option>
							<option value="fa-parking">fa-parking (Parkir)</option>
							<option value="fa-route">fa-route (Rute)</option>
							<option value="fa-map-marked">fa-map-marked (Peta)</option>
							<option value="fa-map-marked-alt">fa-map-marked-alt (Peta Alt)</option>
							<option value="fa-street-view">fa-street-view (Street View)</option>
							<option value="fa-directions">fa-directions (Arah)</option>
							<option value="fa-signs-post">fa-signs-post (Tanda Jalan)</option>
							<option value="fa-traffic-light">fa-traffic-light (Lampu Lalu Lintas)</option>
							<option value="fa-crossroads">fa-crossroads (Persimpangan)</option>
							<option value="fa-tachometer-alt">fa-tachometer-alt (Kecepatan)</option>
							<option value="fa-compass">fa-compass (Kompas)</option>
							<option value="fa-anchor">fa-anchor (Jangkar)</option>
							<option value="fa-ship">fa-ship (Kapal)</option>
							<option value="fa-plane">fa-plane (Pesawat)</option>
							<option value="fa-helicopter">fa-helicopter (Helikopter)</option>
							<option value="fa-rocket">fa-rocket (Roket)</option>
							<option value="fa-satellite">fa-satellite (Satelit)</option>
							<option value="fa-space-shuttle">fa-space-shuttle (Pesawat Luar Angkasa)</option>
							<option value="fa-utensils">fa-utensils (Peralatan Makan)</option>
							<option value="fa-concierge-bell">fa-concierge-bell (Bel Resepsionis)</option>
							<option value="fa-elevator">fa-elevator (Lift)</option>
							<option value="fa-stairs">fa-stairs (Tangga)</option>
							<option value="fa-wheelchair">fa-wheelchair (Kursi Roda)</option>
							<option value="fa-blind">fa-blind (Buta)</option>
							<option value="fa-deaf">fa-deaf (Tuli)</option>
							<option value="fa-sign-language">fa-sign-language (Bahasa Isyarat)</option>
							<option value="fa-universal-access">fa-universal-access (Akses Universal)</option>
							<option value="fa-thermometer-half">fa-thermometer-half (Termometer)</option>
							<option value="fa-shower">fa-shower (Shower)</option>
							<option value="fa-bathtub">fa-bathtub (Bak Mandi)</option>
							<option value="fa-sink">fa-sink (Wastafel)</option>
							<option value="fa-toilet-paper">fa-toilet-paper (Tisu Toilet)</option>
							<option value="fa-soap">fa-soap (Sabun)</option>
							<option value="fa-pump-soap">fa-pump-soap (Pom Sabun)</option>
							<option value="fa-hands-wash">fa-hands-wash (Cuci Tangan)</option>
							<option value="fa-hand-sparkles">fa-hand-sparkles (Tangan Bersih)</option>
							<option value="fa-fan">fa-fan (Kipas)</option>
							<option value="fa-lightbulb">fa-lightbulb (Bohlam)</option>
							<option value="fa-plug">fa-plug (Stopkontak)</option>
							<option value="fa-charging-station">fa-charging-station (Stasiun Pengisian)</option>
							<option value="fa-solar-panel">fa-solar-panel (Panel Surya)</option>
							<option value="fa-wind">fa-wind (Angin)</option>
							<option value="fa-water">fa-water (Air)</option>
							<option value="fa-fire">fa-fire (Api)</option>
							<option value="fa-fire-extinguisher">fa-fire-extinguisher (Pemadam Api)</option>
							<option value="fa-first-aid">fa-first-aid (Pertolongan Pertama)</option>
							<option value="fa-medkit">fa-medkit (Kotak P3K)</option>
							<option value="fa-h-square">fa-h-square (H)</option>
							<option value="fa-plus-square">fa-plus-square (Plus)</option>
							<option value="fa-ambulance">fa-ambulance (Ambulans)</option>
							<option value="fa-hospital">fa-hospital (Rumah Sakit)</option>
							<option value="fa-clinic-medical">fa-clinic-medical (Klinik)</option>
							<option value="fa-user-md">fa-user-md (Dokter)</option>
							<option value="fa-stethoscope">fa-stethoscope (Stetoskop)</option>
							<option value="fa-pills">fa-pills (Obat)</option>
							<option value="fa-syringe">fa-syringe (Suntik)</option>
							<option value="fa-microscope">fa-microscope (Mikroskop)</option>
							<option value="fa-flask">fa-flask (Lab)</option>
							<!-- Pendidikan & Belajar -->
						<optgroup label="Pendidikan & Belajar">
							<option value="fa-book">fa-book (Buku)</option>
							<option value="fa-book-open">fa-book-open (Buku Terbuka)</option>
							<option value="fa-graduation-cap">fa-graduation-cap (Wisuda)</option>
							<option value="fa-chalkboard">fa-chalkboard (Papan Tulis)</option>
							<option value="fa-chalkboard-teacher">fa-chalkboard-teacher (Guru)</option>
							<option value="fa-pencil-alt">fa-pencil-alt (Pensil)</option>
							<option value="fa-brain">fa-brain (Otak)</option>
							<option value="fa-lightbulb">fa-lightbulb (Ide)</option>
							<option value="fa-microscope">fa-microscope (Mikroskop)</option>
							<option value="fa-flask">fa-flask (Lab)</option>
							<option value="fa-atom">fa-atom (Atom)</option>
							<option value="fa-calculator">fa-calculator (Kalkulator)</option>
							<option value="fa-globe">fa-globe (Dunia)</option>
							<option value="fa-language">fa-language (Bahasa)</option>
						</optgroup>
						<!-- Kesehatan & Medis -->
						<optgroup label="Kesehatan & Medis">
							<option value="fa-heartbeat">fa-heartbeat (Detak Jantung)</option>
							<option value="fa-heart">fa-heart (Hati)</option>
							<option value="fa-stethoscope">fa-stethoscope (Stetoskop)</option>
							<option value="fa-user-md">fa-user-md (Dokter)</option>
							<option value="fa-medkit">fa-medkit (Kotak P3K)</option>
							<option value="fa-hospital">fa-hospital (Rumah Sakit)</option>
							<option value="fa-pills">fa-pills (Obat)</option>
							<option value="fa-thermometer">fa-thermometer (Termometer)</option>
							<option value="fa-syringe">fa-syringe (Suntik)</option>
							<option value="fa-band-aid">fa-band-aid (Perban)</option>
							<option value="fa-ambulance">fa-ambulance (Ambulans)</option>
							<option value="fa-wheelchair">fa-wheelchair (Kursi Roda)</option>
							<option value="fa-eye">fa-eye (Mata)</option>
							<option value="fa-teeth">fa-teeth (Gigi)</option>
							<option value="fa-weight">fa-weight (Timbangan)</option>
						</optgroup>
						<!-- Makanan & Minuman -->
						<optgroup label="Makanan & Minuman">
							<option value="fa-utensils">fa-utensils (Makan)</option>
							<option value="fa-coffee">fa-coffee (Kopi)</option>
							<option value="fa-apple-alt">fa-apple-alt (Apel)</option>
							<option value="fa-bread-slice">fa-bread-slice (Roti)</option>
							<option value="fa-carrot">fa-carrot (Wortel)</option>
							<option value="fa-utensil-spoon">fa-utensil-spoon (Sendok)</option>
							<option value="fa-glass-whiskey">fa-glass-whiskey (Minuman)</option>
							<option value="fa-wine-glass">fa-wine-glass (Wine)</option>
							<option value="fa-beer">fa-beer (Bir)</option>
							<option value="fa-cocktail">fa-cocktail (Cocktail)</option>
							<option value="fa-ice-cream">fa-ice-cream (Es Krim)</option>
							<option value="fa-pizza-slice">fa-pizza-slice (Pizza)</option>
							<option value="fa-hamburger">fa-hamburger (Burger)</option>
							<option value="fa-hotdog">fa-hotdog (Hotdog)</option>
							<option value="fa-drumstick-bite">fa-drumstick-bite (Ayam)</option>
							<option value="fa-fish">fa-fish (Ikan)</option>
						</optgroup>
						<!-- Olahraga & Aktivitas Fisik -->
						<optgroup label="Olahraga & Aktivitas Fisik">
							<option value="fa-futbol">fa-futbol (Sepak Bola)</option>
							<option value="fa-basketball-ball">fa-basketball-ball (Basket)</option>
							<option value="fa-volleyball-ball">fa-volleyball-ball (Voli)</option>
							<option value="fa-swimmer">fa-swimmer (Renang)</option>
							<option value="fa-running">fa-running (Lari)</option>
							<option value="fa-bicycle">fa-bicycle (Sepeda)</option>
							<option value="fa-dumbbell">fa-dumbbell (Dumbbell)</option>
							<option value="fa-gamepad">fa-gamepad (Game)</option>
							<option value="fa-table-tennis">fa-table-tennis (Tenis Meja)</option>
							<option value="fa-bowling-ball">fa-bowling-ball (Bowling)</option>
							<option value="fa-skiing">fa-skiing (Ski)</option>
							<option value="fa-snowboarding">fa-snowboarding (Snowboard)</option>
							<option value="fa-golf-ball">fa-golf-ball (Golf)</option>
							<option value="fa-baseball-ball">fa-baseball-ball (Baseball)</option>
							<option value="fa-tennis-ball">fa-tennis-ball (Tenis)</option>
							<option value="fa-football-ball">fa-football-ball (Football)</option>
						</optgroup>
						<!-- Agama & Spiritual -->
						<optgroup label="Agama & Spiritual">
							<option value="fa-mosque">fa-mosque (Masjid)</option>
							<option value="fa-pray">fa-pray (Sholat)</option>
							<option value="fa-quran">fa-quran (Al-Quran)</option>
							<option value="fa-star-and-crescent">fa-star-and-crescent (Bintang Sabit)</option>
							<option value="fa-church">fa-church (Gereja)</option>
							<option value="fa-synagogue">fa-synagogue (Sinagog)</option>
							<option value="fa-dharmachakra">fa-dharmachakra (Dharmachakra)</option>
							<option value="fa-om">fa-om (Om)</option>
							<option value="fa-cross">fa-cross (Salib)</option>
							<option value="fa-hands">fa-hands (Tangan)</option>
							<option value="fa-peace">fa-peace (Damai)</option>
							<option value="fa-praying-hands">fa-praying-hands (Berdoa)</option>
						</optgroup>
						<!-- Anak & Keluarga -->
						<optgroup label="Anak & Keluarga">
							<option value="fa-child">fa-child (Anak)</option>
							<option value="fa-baby">fa-baby (Bayi)</option>
							<option value="fa-users">fa-users (Orang Banyak)</option>
							<option value="fa-user-friends">fa-user-friends (Teman)</option>
							<option value="fa-user">fa-user (User)</option>
							<option value="fa-female">fa-female (Wanita)</option>
							<option value="fa-male">fa-male (Pria)</option>
							<option value="fa-restroom">fa-restroom (Toilet)</option>
							<option value="fa-baby-carriage">fa-baby-carriage (Kereta Bayi)</option>
							<option value="fa-robot">fa-robot (Robot)</option>
							<option value="fa-cat">fa-cat (Kucing)</option>
							<option value="fa-dog">fa-dog (Anjing)</option>
							<option value="fa-heart">fa-heart (Cinta)</option>
							<option value="fa-gift">fa-gift (Hadiah)</option>
						</optgroup>
						<!-- Transportasi -->
						<optgroup label="Transportasi">
							<option value="fa-car">fa-car (Mobil)</option>
							<option value="fa-bus">fa-bus (Bus)</option>
							<option value="fa-train">fa-train (Kereta)</option>
							<option value="fa-plane">fa-plane (Pesawat)</option>
							<option value="fa-ship">fa-ship (Kapal)</option>
							<option value="fa-bicycle">fa-bicycle (Sepeda)</option>
							<option value="fa-motorcycle">fa-motorcycle (Motor)</option>
							<option value="fa-taxi">fa-taxi (Taxi)</option>
							<option value="fa-truck">fa-truck (Truk)</option>
							<option value="fa-tractor">fa-tractor (Traktor)</option>
							<option value="fa-helicopter">fa-helicopter (Helikopter)</option>
							<option value="fa-rocket">fa-rocket (Roket)</option>
							<option value="fa-subway">fa-subway (Subway)</option>
							<option value="fa-tram">fa-tram (Tram)</option>
						</optgroup>
						<!-- Teknologi & Komunikasi -->
						<optgroup label="Teknologi & Komunikasi">
							<option value="fa-wifi">fa-wifi (WiFi)</option>
							<option value="fa-mobile-alt">fa-mobile-alt (HP)</option>
							<option value="fa-laptop">fa-laptop (Laptop)</option>
							<option value="fa-desktop">fa-desktop (Komputer)</option>
							<option value="fa-tv">fa-tv (TV)</option>
							<option value="fa-camera">fa-camera (Kamera)</option>
							<option value="fa-print">fa-print (Printer)</option>
							<option value="fa-headphones">fa-headphones (Headphone)</option>
							<option value="fa-microphone">fa-microphone (Mikrofon)</option>
							<option value="fa-volume-up">fa-volume-up (Volume)</option>
							<option value="fa-battery-full">fa-battery-full (Baterai)</option>
							<option value="fa-plug">fa-plug (Stopkontak)</option>
							<option value="fa-sim-card">fa-sim-card (SIM Card)</option>
							<option value="fa-satellite-dish">fa-satellite-dish (Satelit)</option>
						</optgroup>
						<!-- Hiburan & Kreativitas -->
						<optgroup label="Hiburan & Kreativitas">
							<option value="fa-music">fa-music (Musik)</option>
							<option value="fa-guitar">fa-guitar (Gitar)</option>
							<option value="fa-palette">fa-palette (Palet)</option>
							<option value="fa-paint-brush">fa-paint-brush (Kuas)</option>
							<option value="fa-theater-masks">fa-theater-masks (Teater)</option>
							<option value="fa-film">fa-film (Film)</option>
							<option value="fa-dance">fa-dance (Tari)</option>
							<option value="fa-camera-retro">fa-camera-retro (Kamera Retro)</option>
							<option value="fa-video">fa-video (Video)</option>
							<option value="fa-images">fa-images (Gambar)</option>
							<option value="fa-photo-video">fa-photo-video (Foto Video)</option>
							<option value="fa-magic">fa-magic (Sihir)</option>
							<option value="fa-star">fa-star (Bintang)</option>
							<option value="fa-trophy">fa-trophy (Trofi)</option>
						</optgroup>
						<!-- Alam & Lingkungan -->
						<optgroup label="Alam & Lingkungan">
							<option value="fa-tree">fa-tree (Pohon)</option>
							<option value="fa-leaf">fa-leaf (Daun)</option>
							<option value="fa-seedling">fa-seedling (Bibit)</option>
							<option value="fa-sun">fa-sun (Matahari)</option>
							<option value="fa-cloud">fa-cloud (Awan)</option>
							<option value="fa-water">fa-water (Air)</option>
							<option value="fa-mountain">fa-mountain (Gunung)</option>
							<option value="fa-fire">fa-fire (Api)</option>
							<option value="fa-snowflake">fa-snowflake (Salju)</option>
							<option value="fa-wind">fa-wind (Angin)</option>
							<option value="fa-rainbow">fa-rainbow (Pelangi)</option>
							<option value="fa-frog">fa-frog (Katak)</option>
							<option value="fa-spider">fa-spider (Laba-laba)</option>
							<option value="fa-bug">fa-bug (Serangga)</option>
							<option value="fa-fish">fa-fish (Ikan)</option>
						</optgroup>
						<!-- Bisnis & Keuangan -->
						<optgroup label="Bisnis & Keuangan">
							<option value="fa-money-bill">fa-money-bill (Uang)</option>
							<option value="fa-credit-card">fa-credit-card (Kartu Kredit)</option>
							<option value="fa-shopping-cart">fa-shopping-cart (Keranjang)</option>
							<option value="fa-shopping-bag">fa-shopping-bag (Tas Belanja)</option>
							<option value="fa-store">fa-store (Toko)</option>
							<option value="fa-building">fa-building (Kantor)</option>
							<option value="fa-briefcase">fa-briefcase (Koper)</option>
							<option value="fa-chart-line">fa-chart-line (Grafik)</option>
							<option value="fa-chart-bar">fa-chart-bar (Bar Chart)</option>
							<option value="fa-chart-pie">fa-chart-pie (Pie Chart)</option>
							<option value="fa-calculator">fa-calculator (Kalkulator)</option>
							<option value="fa-file-invoice-dollar">fa-file-invoice-dollar (Invoice)</option>
							<option value="fa-coins">fa-coins (Koin)</option>
						</optgroup>
						<!-- Lainnya -->
						<optgroup label="Lainnya">
							<option value="fa-cogs">fa-cogs (Pengaturan)</option>
							<option value="fa-tools">fa-tools (Peralatan)</option>
							<option value="fa-wrench">fa-wrench (Kunci)</option>
							<option value="fa-hammer">fa-hammer (Palu)</option>
							<option value="fa-screwdriver">fa-screwdriver (Obeng)</option>
							<option value="fa-key">fa-key (Kunci)</option>
							<option value="fa-lock">fa-lock (Kunci)</option>
							<option value="fa-unlock">fa-unlock (Buka Kunci)</option>
							<option value="fa-shield-alt">fa-shield-alt (Pelindung)</option>
							<option value="fa-clock">fa-clock (Jam)</option>
							<option value="fa-calendar">fa-calendar (Kalender)</option>
							<option value="fa-bell">fa-bell (Bel)</option>
							<option value="fa-envelope">fa-envelope (Surat)</option>
							<option value="fa-phone">fa-phone (Telepon)</option>
							<option value="fa-map-marker">fa-map-marker (Lokasi)</option>
							<option value="fa-search">fa-search (Cari)</option>
							<option value="fa-share">fa-share (Bagikan)</option>
							<option value="fa-download">fa-download (Download)</option>
							<option value="fa-upload">fa-upload (Upload)</option>
							<option value="fa-save">fa-save (Simpan)</option>
							<option value="fa-trash">fa-trash (Sampah)</option>
							<option value="fa-edit">fa-edit (Edit)</option>
							<option value="fa-plus">fa-plus (Tambah)</option>
							<option value="fa-minus">fa-minus (Kurang)</option>
							<option value="fa-times">fa-times (Kali)</option>
							<option value="fa-check">fa-check (Centang)</option>
							<option value="fa-exclamation-triangle">fa-exclamation-triangle (Peringatan)</option>
							<option value="fa-info-circle">fa-info-circle (Info)</option>
							<option value="fa-question-circle">fa-question-circle (Tanya)</option>
						</optgroup>
					</select>
				</div>
				<div class="form-group">
					<label for="sort_order">Urutan</label>
					<input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Tambah Fasilitas</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>



	<style>
		/* Page Container */
		.laporan-page {
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

		/* Content Grid */
		.content-grid {
			display: grid;
			grid-template-columns: 2fr 1fr;
			gap: 25px;
		}

		/* Data Panel */
		.data-panel {
			background: #fff;
			border-radius: 14px;
			overflow: hidden;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
			margin-bottom: 25px;
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
			padding: 25px;
		}

		/* Facilities Grid */
		.facilities-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
			gap: 20px;
		}

		.facility-item {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
			overflow: hidden;
			transition: all 0.3s ease;
			border: 1px solid #edf2f7;
		}

		.facility-item:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
		}

		.facility-image-container {
			position: relative;
			height: 180px;
			overflow: hidden;
			background: #f8fafc;
		}

		.facility-image {
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: transform 0.3s ease;
			display: block;
		}

		.facility-item:hover .facility-image {
			transform: scale(1.05);
		}

		.image-placeholder {
			text-align: center;
			color: #a0aec0;
		}

		.image-placeholder i {
			display: block;
			margin-bottom: 8px;
		}

		.facility-overlay {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0, 0, 0, 0.6);
			display: flex;
			align-items: center;
			justify-content: center;
			opacity: 0;
			transition: opacity 0.3s ease;
			z-index: 2;
		}

		.facility-item:hover .facility-overlay {
			opacity: 1;
		}

		.facility-actions {
			display: flex;
			gap: 8px;
		}

		.facility-actions .btn {
			border-radius: 50%;
			width: 36px;
			height: 36px;
			display: flex;
			align-items: center;
			justify-content: center;
			border: none;
			transition: all 0.3s ease;
		}

		.facility-actions .btn:hover {
			transform: scale(1.1);
		}

		.active-badge {
			position: absolute;
			top: 10px;
			right: 10px;
			background: rgba(28, 200, 138, 0.9);
			color: white;
			padding: 4px 8px;
			border-radius: 12px;
			font-size: 11px;
			font-weight: 600;
			display: flex;
			align-items: center;
			gap: 4px;
			z-index: 3;
		}

		.facility-info {
			padding: 16px;
		}

		.facility-info h4 {
			font-size: 16px;
			font-weight: 600;
			color: #2d3748;
			margin-bottom: 8px;
			line-height: 1.3;
		}

		.description {
			color: #718096;
			font-size: 13px;
			line-height: 1.4;
			margin-bottom: 8px;
		}

		.sort-info {
			font-size: 12px;
			color: #a0aec0;
		}

		/* Empty State */
		.empty-state {
			text-align: center;
			padding: 60px 20px;
			background: #f8fafc;
			border-radius: 12px;
			border: 2px dashed #e2e8f0;
		}

		.empty-icon {
			font-size: 48px;
			color: #cbd5e0;
			margin-bottom: 20px;
		}

		.empty-state h3 {
			color: #4a5568;
			margin-bottom: 10px;
			font-size: 18px;
		}

		.empty-state p {
			color: #718096;
			margin-bottom: 20px;
		}

		/* Stats Grid */
		.stats-grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 15px;
		}

		.stat-item {
			text-align: center;
			padding: 15px;
			background: #f8fafc;
			border-radius: 8px;
		}

		.stat-number {
			font-size: 24px;
			font-weight: 700;
			color: #4e73df;
			display: block;
			margin-bottom: 5px;
		}

		.stat-label {
			font-size: 12px;
			color: #718096;
			font-weight: 500;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		/* Modal Styles */
		.modal-content {
			border-radius: 12px;
			border: none;
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
		}

		.modal-header {
			border-bottom: 1px solid #edf2f7;
			padding: 20px 25px;
		}

		.modal-title {
			font-weight: 600;
			color: #2d3748;
		}

		.modal-body {
			padding: 25px;
		}

		.modal-footer {
			border-top: 1px solid #edf2f7;
			padding: 20px 25px;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			font-weight: 600;
			color: #2d3748;
			margin-bottom: 8px;
			display: block;
		}

		.form-control {
			border-radius: 8px;
			border: 1px solid #e2e8f0;
			padding: 10px 15px;
			font-size: 14px;
			transition: all 0.3s ease;
		}

		.form-control:focus {
			border-color: #4e73df;
			box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
		}

		.custom-file {
			position: relative;
			display: inline-block;
			width: 100%;
			margin-bottom: 10px;
		}

		.custom-file-input {
			position: relative;
			z-index: 2;
			width: 100%;
			height: calc(1.5em + 0.75rem + 2px);
			margin: 0;
			opacity: 0;
		}

		.custom-file-label {
			position: absolute;
			top: 0;
			right: 0;
			left: 0;
			z-index: 1;
			height: calc(1.5em + 0.75rem + 2px);
			padding: 0.375rem 0.75rem;
			font-weight: 400;
			line-height: 1.5;
			color: #6c757d;
			background-color: #fff;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			display: flex;
			align-items: center;
			transition: all 0.3s ease;
		}

		.custom-file-input:focus~.custom-file-label {
			border-color: #4e73df;
			box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
		}

		.form-text {
			font-size: 12px;
			color: #a0aec0;
			margin-top: 5px;
		}

		.form-check {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.form-check-input {
			width: 16px;
			height: 16px;
			border-radius: 4px;
			border: 1px solid #e2e8f0;
		}

		.form-check-label {
			font-weight: 500;
			color: #4a5568;
			margin-bottom: 0;
		}

		.btn {
			border-radius: 8px;
			font-weight: 500;
			padding: 10px 20px;
			transition: all 0.3s ease;
			border: none;
		}

		.btn-primary {
			background: #4e73df;
			color: white;
		}

		.btn-primary:hover {
			background: #2e59d9;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
		}

		.btn-secondary {
			background: #6c757d;
			color: white;
		}

		.btn-secondary:hover {
			background: #545b62;
			transform: translateY(-1px);
		}

		.btn-light {
			background: rgba(255, 255, 255, 0.9);
			color: #2d3748;
			border: 1px solid #e2e8f0;
		}

		.btn-light:hover {
			background: white;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		}

		.btn-danger {
			background: #e74a3b;
			color: white;
		}

		.btn-danger:hover {
			background: #c82333;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(231, 74, 59, 0.3);
		}

		/* Info Content */
		.info-content {
			padding: 0;
		}

		.info-section {
			margin-bottom: 20px;
		}

		.info-section:last-child {
			margin-bottom: 0;
		}

		.info-section h4 {
			font-size: 14px;
			font-weight: 600;
			color: #2d3748;
			margin-bottom: 12px;
			display: flex;
			align-items: center;
			gap: 6px;
		}

		.info-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.info-list li {
			padding: 6px 0;
			padding-left: 18px;
			position: relative;
			color: #718096;
			font-size: 13px;
			line-height: 1.4;
		}

		.info-list li:before {
			content: "•";
			color: #4e73df;
			font-weight: bold;
			position: absolute;
			left: 0;
		}

		/* Preview Links */
		.preview-links {
			padding: 0;
		}

		.preview-btn {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 15px 20px;
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			text-decoration: none;
			color: #2d3748;
			transition: all 0.3s ease;
		}

		.preview-btn:hover {
			background: #4e73df;
			color: #fff;
			border-color: #4e73df;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
		}

		.preview-btn i {
			font-size: 16px;
		}

		/* Alert Styles */
		.alert {
			border-radius: 10px;
			border: none;
			padding: 15px 20px;
			margin-bottom: 25px;
		}

		.alert-success {
			background: rgba(28, 200, 138, 0.1);
			color: #1cc88a;
		}

		.alert-danger {
			background: rgba(231, 74, 59, 0.1);
			color: #e74a3b;
		}

		/* Modern Bootstrap Card Design */
		.card {
			border: none;
			border-radius: 20px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
			transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
			overflow: hidden;
			background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
		}

		.card:hover {
			transform: translateY(-15px) scale(1.02);
			box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
		}

		.card-img-top {
			border-radius: 20px 20px 0 0;
			height: 220px;
			object-fit: cover;
			transition: transform 0.4s ease;
			filter: brightness(1);
		}

		.card:hover .card-img-top {
			transform: scale(1.1);
			filter: brightness(1.1) contrast(1.1);
		}

		.card-body {
			background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #e9ecef 100%);
			padding: 1.5rem;
			border-radius: 0 0 20px 20px;
		}

		.card-title {
			font-weight: 700;
			color: #2d3748;
			margin-bottom: 0.5rem;
			font-size: 1.1rem;
		}

		.card-text {
			color: #718096;
			font-size: 0.9rem;
			line-height: 1.4;
		}

		.badge {
			border-radius: 25px;
			font-size: 10px;
			padding: 8px 12px;
			font-weight: 600;
			background: linear-gradient(45deg, #28a745, #20c997);
			color: white;
			border: none;
			box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
		}

		.btn-group .btn {
			border-radius: 50% !important;
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: all 0.3s ease;
			border: 2px solid;
			font-size: 14px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		}

		.btn-outline-primary {
			background: linear-gradient(45deg, #007bff, #0056b3);
			border-color: #007bff;
			color: white;
		}

		.btn-outline-primary:hover {
			background: linear-gradient(45deg, #0056b3, #004085);
			border-color: #0056b3;
			transform: scale(1.1);
			box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
		}

		.btn-outline-danger {
			background: linear-gradient(45deg, #dc3545, #c82333);
			border-color: #dc3545;
			color: white;
		}

		.btn-outline-danger:hover {
			background: linear-gradient(45deg, #c82333, #a02622);
			border-color: #c82333;
			transform: scale(1.1);
			box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
		}

		.text-muted {
			color: #a0aec0 !important;
			font-weight: 500;
		}

		/* Modal Backdrop Fix */
		.modal-backdrop {
			background-color: rgba(0, 0, 0, 0.5) !important;
		}

		/* Responsive */
		@media (max-width: 1200px) {
			.content-grid {
				grid-template-columns: 1fr;
			}

			.facilities-grid {
				grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

			.facilities-grid {
				grid-template-columns: 1fr;
			}

			.stats-grid {
				grid-template-columns: 1fr;
			}

			.modal-dialog {
				margin: 10px;
			}

			.panel-body {
				padding: 20px;
			}
		}
	</style>

	<!-- Select2 Custom Styling -->
	<style>
		.select2-container--default .select2-selection--single {
			border-radius: 8px;
			border: 1px solid #e2e8f0;
			height: 38px;
			background: #fff;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			padding-left: 15px;
			padding-right: 20px;
			line-height: 36px;
			color: #495057;
		}

		.select2-container--default .select2-selection--single .select2-selection__placeholder {
			color: #6c757d;
		}

		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 36px;
			right: 10px;
		}

		.select2-container--default .select2-selection--single .select2-selection__arrow b {
			border-color: #495057 transparent transparent transparent;
			border-width: 5px 5px 0 5px;
		}

		.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
			border-color: transparent transparent #495057 transparent;
			border-width: 0 5px 5px 5px;
		}

		.select2-dropdown {
			border-radius: 8px;
			border: 1px solid #e2e8f0;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		.select2-container--default .select2-results__option {
			padding: 10px 15px;
			font-size: 14px;
		}

		.select2-container--default .select2-results__option--highlighted[aria-selected] {
			background-color: #4e73df;
			color: white;
		}
	</style>

	<script>
		$(document).ready(function () {
			// Custom file input label update
			$('.custom-file-input').on('change', function () {
				var fileName = $(this).val().split('\\').pop();
				$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
			});



			// Delete button click
			$('.delete-btn').on('click', function () {
				var id = $(this).data('id');
				if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
					window.location.href = '<?php echo base_url("admin/facilities/delete/"); ?>' + id;
				}
			});

			// Initialize Select2 for icon dropdowns
			$('#icon').select2({
				placeholder: 'Pilih icon FontAwesome...',
				allowClear: true,
				templateResult: function (icon) {
					if (!icon.id) {
						return icon.text;
					}
					var $icon = $(
						'<span><i class="fas ' + icon.id + ' mr-2"></i>' + icon.text + '</span>'
					);
					return $icon;
				},
				templateSelection: function (icon) {
					if (!icon.id) {
						return icon.text;
					}
					var $icon = $(
						'<span><i class="fas ' + icon.id + ' mr-2"></i>' + icon.text + '</span>'
					);
					return $icon;
				}
			});
		});
	</script>