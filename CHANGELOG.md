# Changelog

Semua perubahan penting pada aplikasi SAHABAT akan didokumentasikan di file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.7.0] - 2025-02-23

### Removed
- ✂️ **Edit Functionality from Facilities Page**
  - Removed edit button from facility cards
  - Removed edit modal and associated form
  - Facilities can now only be added or deleted, not edited
  - Cleaned up JavaScript handlers for edit functionality

### Fixed
- 🐛 **Facilities Modal Issues**
  - Added "fade" class to modals for proper Bootstrap modal animation
  - Fixed JavaScript selector for description text to prevent incorrect data population when facilities have no description
  - Improved modal triggering to use consistent Bootstrap data attributes

### Added
- ✨ **Facilities Management Page**
  - New admin page for managing landing page facilities
  - Add facilities with image upload, description, icon selection
  - Delete facilities with confirmation
  - Grid display with facility cards
  - File: `application/views/admin/facilities.php`
  - Model: `application/models/Fasilitas_model.php`
  - Database: `database/alter_table_add_facilities.sql`

### Changed
- 🔄 **Facilities Page Modifications**
  - Removed edit functionality (button, modal, JavaScript)
  - Updated Select2 initialization to only target add modal
  - Fixed description paragraph selector to use specific class

### Technical
- 🔧 **Database Schema**
  - `database/alter_table_add_facilities.sql` - Tabel fasilitas dengan kolom lengkap
  - Tabel `fasilitas` dengan fields: id_fasilitas, nama_fasilitas, deskripsi, gambar, icon, sort_order, is_active
  - Data default 8 fasilitas (Asrama, Ruang Belajar, Kantin, dll.)
  - `database/alter_anak_table.sql` - Penambahan kolom dokumen dan kategori pada tabel anak
  - Kolom baru: file_kk, file_akta, file_pendukung, kategori (enum Islamic categories)
  - Modifikasi enum pendidikan untuk menambah 'PT' (Perguruan Tinggi)

- 🔧 **Model Baru**
  - `application/models/Fasilitas_model.php` - CRUD operasi fasilitas

- 🔧 **Dashboard Enhancements**
  - Penambahan statistik pendidikan TK (Taman Kanak-Kanak)
  - Penambahan section charts untuk visualisasi data
  - Update statistik kategori anak dengan 7 kategori Islamic

- 🔧 **Data Anak Improvements**
  - Penambahan kolom kategori dengan 7 pilihan: Yatim, Piatu, Yatim Piatu, Dhuafa, Fakir dan Miskin, Ibnu Sabil, Laqith
  - Modifikasi tabel data anak: hapus kolom Usia, Status, Tanggal Masuk; tambah kolom Kategori
  - Update enum pendidikan untuk mendukung Perguruan Tinggi (PT)

- 🔧 **Landing Page Updates**
  - Penambahan section fasilitas di halaman home
  - Styling dan layout untuk menampilkan fasilitas LKSA

- 🔧 **UI/UX Improvements**
  - Modifikasi sidebar admin dengan struktur menu yang lebih baik
  - Optimisasi footer dengan penghapusan jQuery yang redundant
  - Update layout carousel admin dengan grid system yang lebih responsif

- 🔧 **Library Updates**
  - `application/libraries/Excel_export.php` - Perbaikan export data anak
  - `application/libraries/Pdf_export.php` - Perbaikan generate laporan PDF

- 🔧 **Helper Updates**
  - `application/helpers/logging_helper.php` - Perbaikan fungsi logging aktivitas

---

## [1.6.0] - 2025-02-22

### Added
- 🖼️ **Kelola Carousel Landing Page**
  - Halaman admin untuk mengelola gambar carousel hero section
  - Upload, edit, delete gambar carousel dengan validasi
  - Tampilan grid gambar dengan overlay actions
  - Urutan gambar dapat disesuaikan
  - Status aktif/nonaktif untuk setiap gambar
  - Folder upload: assets/uploads/landing/

### Fixed
- 🐛 **Perbaikan Route Carousel**
  - Memperbaiki URL form upload, update, delete carousel
  - Update route admin/carousel/update tanpa parameter ID
  - Controller method update_carousel_image() menggunakan POST data

- 🐛 **Perbaikan Tampilan Gambar Carousel**
  - Menghapus pengecekan file_exists untuk menghindari placeholder
  - Gambar ditampilkan langsung dari database path
  - Perbaikan JavaScript error tooltip tidak ditemukan

### Changed
- 🔄 **Update `application/config/routes.php`**
  - Route carousel update diubah ke POST-based

- 🔄 **Update `application/controllers/Admin.php`**
  - Method update_carousel_image() menggunakan $id dari POST

- 🔄 **Update `application/views/admin/carousel.php`**
  - Form action menggunakan route yang benar
  - Hapus data-toggle tooltip untuk menghindari error JS
  - Tampilan gambar tanpa file_exists check

### Technical
- 🔧 **Model Baru**
  - application/models/Carousel_model.php - CRUD operasi carousel

- 🔧 **View Baru**
  - application/views/admin/carousel.php - Halaman kelola carousel

- 🔧 **File Database Baru**
  - database/alter_table_add_carousel_images.sql - Tabel carousel_images

---

## [1.5.0] - 2025-02-22

### Added
- 📊 **DataTables Server-Side Pagination untuk Log Aktivitas**
  - Implementasi pagination server-side untuk performa yang lebih baik dengan data log besar
  - Search functionality di semua kolom (nama, username, aktivitas, deskripsi, IP address)
  - Sorting berdasarkan kolom waktu, nama, username, aktivitas
  - Stats cards menampilkan data langsung tanpa loading
  - Styling komprehensif untuk semua kontrol DataTables dengan margin dan padding yang tepat
  - Dark mode support lengkap untuk semua kontrol DataTables
  - Bahasa Indonesia untuk interface DataTables

### Changed
- 🔄 **Update `application/models/User_log_model.php`**
  - Method baru `get_logs_datatable()` untuk query paginated dengan search dan sorting
  - Method `count_all_logs()` dan `count_filtered_logs()` untuk DataTables

- 🔄 **Update `application/controllers/Admin.php`**
  - Method `logs_ajax()` baru untuk mengembalikan data JSON DataTables
  - Method `logs()` diupdate untuk load stats data langsung

- 🔄 **Update `application/views/admin/logs.php`**
  - Konfigurasi DataTables untuk server-side processing
  - Stats cards menampilkan data langsung dari controller
  - CSS styling komprehensif untuk pagination, search bar, info text, length selector
  - Dark mode styling untuk semua kontrol DataTables

- 🔄 **Update `application/helpers/logging_helper.php`**
  - Memindahkan fungsi `get_activity_color()` dan `get_activity_icon()` dari view ke helper

- 🔄 **Update `application/config/routes.php`**
  - Route baru `admin/logs_ajax` untuk endpoint DataTables

- 🔄 **Update `application/config/config.php`**
  - Disable CSRF protection untuk development environment

### Technical
- 🔧 **Libraries DataTables**
  - Menambahkan DataTables CSS dan JS libraries ke view logs.php
  - Fix loading order dengan dynamic script loading untuk menghindari konflik jQuery

---

## [1.4.0] - 2025-02-22

### Added
- 🖼️ **Dynamic Landing Page Images**
  - Admin dapat upload gambar hero dan about untuk landing page
  - Fallback otomatis ke gambar Unsplash jika belum ada gambar
  - Menu "Landing Page" di admin sidebar (Pengaturan > Landing Page)
  - Upload gambar dengan validasi (JPG, PNG, max 2MB)
  - Preview gambar di halaman admin
  - Folder upload: assets/uploads/landing/

- 🔧 **Database Schema Update**
  - Kolom hero_image dan about_image di tabel pengaturan
  - File SQL: database/alter_table_add_landing_images.sql

### Changed
- 🔄 **Landing Page** (`application/views/landingpage/home.php`)
  - Gambar hero dan about sekarang dinamis dari database
  - Fallback ke Unsplash jika belum ada gambar upload

- 🔄 **Admin Controller** (`application/controllers/Admin.php`)
  - Method landing() - halaman kelola landing page
  - Method upload_hero_image() - upload gambar hero
  - Method upload_about_image() - upload gambar about

- 🔄 **Admin Sidebar** (`application/views/templates/sidebar_lksa.php`)
  - Menu "Landing Page" di bawah Pengaturan

### Technical
- 🔧 **View Baru**
  - application/views/admin/landing.php - Halaman kelola gambar landing

- 🔧 **File Database Baru**
  - database/alter_table_add_landing_images.sql - Tambah kolom gambar landing

- 🔧 **Direktori Upload Baru**
  - assets/uploads/landing/ - Folder untuk gambar landing page

---

## [1.3.0] - 2025-02-22

### Added
- ✨ **Export PDF Statistik dengan Chart sebagai Gambar**
  - Halaman laporan statistik sekarang bisa export ke PDF dengan gambar chart
  - Menggunakan JavaScript untuk mengkonversi Chart.js canvas ke base64
  - Mengirim data chart ke server via AJAX
  - Chart gambar disematkan di dalam PDF

- 📊 **Dukungan Legend Chart**
  - **Chart Jenis Kelamin** (Doughnut): Menambahkan judul dan legend di bawah chart
  - **Chart Usia** (Bar): Menambahkan judul dan legend di bawah chart
  - **Chart Pendidikan** (Bar): Menambahkan judul dan legend di bawah chart

- 🧹 **Hapus File Temporary Otomatis**
  - File PDF dihapus otomatis dari folder `assets/temp/` setelah didownload
  - Delay 3 detik sebelum dihapus untuk memastikan user sudah download
  - Menambahkan endpoint `admin/delete_temp_file` (POST)

- ⏳ **Indikator Loading**
  - Tombol "Export PDF" menampilkan status "Generating..." saat proses
  - Tombol dinonaktifkan saat PDF sedang dibuat
  - Kembali normal setelah selesai

- ✨ **Modal View Data Anak**
  - Tombol "View Data" (ikon mata) di kolom Aksi halaman anak
  - Modal besar (modal-xl) menampilkan data lengkap anak
  - Layout data terorganisir: Info Pribadi, Pendidikan & Status, Dokumen
  - Link dokumen yang dapat diklik jika tersedia

- 📸 **Fitur Upload Foto Anak**
  - Kolom foto di tabel anak (database/alter_table_add_foto_anak.sql)
  - Upload foto di modal edit anak
  - Tampilan foto di modal view data
  - Folder upload: assets/uploads/foto_anak/
  - Validasi file gambar (JPG, PNG, max 2MB)

- 📊 **Update Dashboard & Laporan**
  - Statistik foto di dashboard (anak dengan foto)
  - Kolom foto di laporan dokumen (tabel dan progress bar)
  - Update counter dokumen: X/4 (termasuk foto)

- 🔐 **Sistem Pencatatan Aktivitas Pengguna**
  - Mencatat aktivitas penting pengguna untuk keamanan dan audit
  - Halaman admin untuk melihat riwayat aktivitas
  - Memudahkan monitoring penggunaan aplikasi

- 📄 **Halaman Changelog**
  - Halaman admin/changelog untuk melihat riwayat perubahan
  - Parsing CHANGELOG.md ke HTML dengan styling GitHub-like
  - Responsive design dengan dark mode support

- 👤 **Role Operator**
  - Role baru 'operator' di tabel users
  - File SQL: database/alter_table_add_role_operator.sql

### Changed
- 🔄 **Update `application/controllers/Admin.php`**
  - Menambahkan method `generate_pdf_statistik()` - generate PDF dengan gambar chart
  - Menambahkan method `delete_temp_file()` - hapus file temp setelah didownload

- 🔄 **Update `application/views/admin/laporan/statistik.php`**
  - Konfigurasi Chart.js menambahkan opsi legend (judul dan label)
  - JavaScript menambahkan fitur hapus file temporary otomatis
  - Menambahkan indikator loading state

- 🔄 **Update `application/libraries/Pdf_export.php`**
  - Menambahkan method `generate_to_file()` - simpan PDF ke file
  - Menambahkan method `generate_laporan_statistik_with_charts()` - sematkan gambar chart di PDF

- 🔄 **Update `application/config/routes.php`**
  - Menambahkan route `admin/delete_temp_file`

- 🔄 **Update `application/controllers/Admin.php`**
  - Method upload_foto() untuk upload foto anak
  - Method logs() untuk halaman log aktivitas
  - Method changelog() untuk halaman changelog

- 🔄 **Update `application/models/Anak_model.php`**
  - Handle field foto di CRUD operations

- 🔄 **Update `application/views/admin/anak.php`**
  - Tombol View Data dengan modal lengkap
  - Upload foto di modal edit

- 🔄 **Update `application/views/admin/dashboard.php`**
  - Statistik foto anak

- 🔄 **Update `application/views/admin/laporan/dokumen.php`**
  - Kolom foto di tabel dan progress

- 🔄 **Update `application/config/routes.php`**
  - Route admin/logs dan admin/changelog

- 🔄 **Update `application/config/constants.php`**
  - Konstanta untuk path upload foto

- 🔄 **Update `database/db_lksa.sql`**
  - Struktur database terbaru dengan kolom foto dan tabel user_logs

### Technical
- 🔧 **Direktori baru** - `assets/temp/` untuk menyimpan file PDF sementara

- 🔧 **Helper Baru**
  - application/helpers/logging_helper.php - Pencatatan aktivitas pengguna
  - application/helpers/ip_helper.php - Mendapatkan alamat IP

- 🔧 **Model Baru**
  - application/models/User_log_model.php - Model untuk user logs

- 🔧 **View Baru**
  - application/views/admin/logs.php - Halaman log aktivitas
  - application/views/admin/changelog.php - Halaman changelog

- 🔧 **File Database Baru**
  - database/alter_table_add_foto_anak.sql - Tambah kolom foto
  - database/alter_table_add_role_operator.sql - Tambah role operator
  - database/alter_table_add_user_logs.sql - Buat tabel user_logs

- 🔧 **Direktori Upload Baru**
  - assets/uploads/foto_anak/ - Folder untuk foto anak

---

## [1.2.0] - 2025-01-18

### Added
- ✨ **Halaman Kontak Pengembang** (`application/views/admin/kontak.php`)
  - Halaman baru untuk menghubungi pengembang aplikasi
  - Info pengembang: Moh. Heri Setiawan (Lead Developer)
  - Link GitHub, LinkedIn, dan email langsung
  - Formulir kontak untuk mengirim pesan
  - Bagian informasi jam operasional
  - Dukungan Dark Mode penuh

- 🎨 **Menu Navbar Kontak**
  - Link "Kontak" di navbar bagian kanan
  - Format teks seperti menu "Dashboard"
  - Icon + teks "Kontak"
  - Langsung menuju halaman kontak pengembang

- 📋 **Struktur Menu Sidebar Terbaru**
  - Menu "Kontak Pengembang" sebagai menu utama
  - Menu "Dukung Kami" di bawah kategori INFORMASI
  - Kategori menu baru: INFORMASI (memuat Kontak Pengembang & Dukung Kami)
  - Icon headsett untuk Kontak Pengembang
  - Posisi menu: Di bawah LAPORAN, di atas PENGATURAN

- 🔧 **Route Baru**
  - Menambahkan route `admin/kontak` di `application/config/routes.php`
  - Controller `Admin.php` dengan fungsi `kontak()`

---

## [1.1.0] - 2025-01-17

### Added
- ✨ **Dark Mode Support** - Menambahkan styles dark mode untuk semua halaman laporan:
  - `application/views/admin/laporan/index.php` - Menu laporan utama
  - `application/views/admin/laporan/data_anak.php` - Laporan data anak
  - `application/views/admin/laporan/keuangan.php` - Laporan keuangan
  - `application/views/admin/laporan/pengurus.php` - Laporan pengurus
  - `application/views/admin/laporan/dokumen.php` - Laporan dokumen
  - `application/views/admin/laporan/statistik.php` - Laporan statistik
  - Cara mengaktifkan: Tambahkan class `dark-mode` pada tag `<body>`

- ✨ **Helper Tanggal Indonesia** (`application/helpers/tanggal_helper.php`)
  - Fungsi `tanggal_indo($date)` - Format: "15 Januari 2024"
  - Fungsi `tanggal_indo_short($date)` - Format: "15 Jan 2024"
  - Fungsi `bulan_indo($month)` - Format: "Januari"
  - Fungsi `umur($tanggal_lahir)` - Format: "10 tahun"
  - Fungsi `waktu_indo($datetime)` - Format: "Senin, 15 Januari 2024 10:30 WIB"
  - Helper di-load secara otomatis melalui autoload

- 📚 **Update Library PDF Export** (`application/libraries/Pdf_export.php`)
  - Menggunakan helper tanggal_indo untuk format tanggal Indonesia
  - Format periode laporan menggunakan bulan_indo
  - Format umur menggunakan fungsi umur()
  - Footer laporan menggunakan format tanggal Indonesia

- 🎨 **Redesain Halaman Dukung Kami** (`application/views/admin/dukung_kami.php`)
  - Hero section dengan animasi dan wave divider
  - Aplikasi badge dengan nama "SAHABAT"
  - Card rekening 2 kolom:
    - **Bank BSI**: 7252957170 (Tema hijau stabilo)
    - **Bank BRI**: 057201014816537 (Tema biru dongker)
  - Copy to clipboard dengan toast notification
  - Full width layout (12 grid)
  - Responsive design
  - Efek glow dan animasi modern

### Changed
- 🔄 **Environment Production** - Mengubah default ENVIRONMENT dari 'development' ke 'production' di `index.php`
- 🔄 **View Laporan** - Menggunakan helper tanggal_indo untuk konsistensi format tanggal:
  - `application/views/admin/laporan/data_anak.php`
  - `application/views/admin/laporan/pengurus.php`
- 🔄 **View Admin** - Menggunakan helper tanggal_indo:
  - `application/views/admin/anak.php`

### Technical
- 🔧 **Konfigurasi Autoload** - Menambahkan 'tanggal' ke helper autoload di `application/config/autoload.php`
- 🔧 **Controller Update** - Menambahkan field media sosial di `application/controllers/Admin.php` fungsi pengaturan()
- 🔧 **Database Schema** - File SQL untuk menambahkan kolom media sosial: `database/alter_table_add_social_media.sql`

- ✨ **Fitur Media Sosial** - Menambahkan kolom media sosial ke database:
  - Facebook, Twitter, Instagram, YouTube, LinkedIn, WhatsApp
  - File SQL: `database/alter_table_add_social_media.sql`

- 📱 **Pengaturan Media Sosial di Admin** (`application/views/admin/pengaturan.php`)
  - Input form untuk 6 media sosial
  - Icon Font Awesome untuk setiap platform

- 🌐 **Media Sosial di Landing Page** (`application/views/landingpage/home.php`)
  - Link media sosial di footer sekarang dinamis dari database
  - Semua link membuka di tab baru dengan `target="_blank"`
  - Keamanan: Menggunakan `rel="noopener noreferrer"`
  - WhatsApp smart detection: Mendukung URL lengkap atau nomor telepon saja

---

## [1.0.0] - 2024-01-15

### Added
- ✨ **Dashboard Admin** dengan statistik real-time
  - Total anak, pengurus, dokumen lengkap/kurang
  - Statistik status anak (aktif/nonaktif)
  - Statistik pendidikan (SD, SMP, SMA, PT)
  - Data anak dan pengurus terbaru
  - Quick actions untuk akses cepat

- 👶 **Manajemen Data Anak**
  - CRUD data anak lengkap (profil, pendidikan, status)
  - Upload dokumen (KK, Akta Kelahiran, Dokumen Pendukung)
  - Folder management berdasarkan NIK dan nama anak
  - Status tinggal (Sekolah, Asrama, Perawatan)
  - Status anak (Aktif/Nonaktif)

- 👔 **Manajemen Data Pengurus**
  - CRUD data pengurus dan jabatan
  - Upload dokumen KTP
  - Manajemen kontak (email, telepon)

- 📑 **Sistem Laporan**
  - Laporan data anak (PDF & Excel)
  - Laporan data pengurus (PDF & Excel)
  - Laporan dokumen anak (PDF & Excel)
  - Laporan statistik
  - Kop surat yang dapat dikustomisasi

- ⚙️ **Pengaturan Sistem**
  - Profile LKSA (nama, alamat, email, telepon, tahun berdiri)
  - Upload logo LKSA
  - Upload dokumen legal (PDF)
  - Upload kop surat untuk laporan
  - Manajemen user dan role

- ❤️ **Menu Dukung Kami**
  - Halaman informasi donasi sukarela
  - Informasi rekening BRI untuk kontribusi
  - Tombol copy nomor rekening
  - Badge nama aplikasi SAHABAT

- 🎨 **UI/UX**
  - Tema AdminLTE 3 dengan Bootstrap 4
  - Dashboard clean dan colorful
  - Responsive design untuk mobile dan desktop
  - Animasi AOS pada landing page
  - Font Awesome icons

- 🔐 **Keamanan**
  - Sistem autentikasi dengan session
  - Password hashing dengan bcrypt
  - CSRF protection
  - XSS filtering
  - Form validation

- 📱 **Landing Page**
  - Hero section dengan animasi
  - Fitur unggulan showcase
  - About section
  - Statistics counter
  - CTA section
  - Footer dengan informasi kontak

### Changed
- 🔄 **Dashboard Layout** - Restruktur layout menjadi lebih clean dengan 4 main stat cards dan 2 rows secondary stats
- 🔄 **Sidebar Brand** - Mengubah dari nama LKSA menjadi "SAHABAT"
- 🔄 **Copyright Footer** - Mengubah menjadi "SAHABAT - Sistem Anak Hebat Berbasis Administrasi Terpadu"

### Fixed
- 🐛 Memperbaiki hook settings yang tidak berjalan di landing page
- 🐛 Memperbaiki layout grid secondary stats menjadi 2 baris x 3 cards
- 🐛 Menghapus stat "Anak Baru" yang tidak diperlukan
- 🐛 Membersihkan CSS media query yang duplikat

### Technical
- 🏗️ **Arsitektur**: CodeIgniter 3.x dengan HMVC pattern
- 🗄️ **Database**: MySQL dengan relasi antar tabel
- 📦 **Dependencies**: 
  - AdminLTE 3.1.0
  - Bootstrap 4.6.0
  - jQuery 3.6.0
  - DataTables 1.10.24
  - TCPDF 6.4.4
  - PhpSpreadsheet 1.18.0

## [0.9.0] - 2024-01-01 (Beta)

### Added
- Initial release dengan fitur dasar
- Autentikasi user
- CRUD data anak dasar
- CRUD data pengurus dasar
- Laporan sederhana

---

## Catatan Rilis

### Versi 1.5.0
- Menambahkan DataTables server-side pagination untuk tabel log aktivitas
- Performa yang lebih baik untuk data log yang besar
- Search dan sorting functionality lengkap
- Stats cards menampilkan data langsung tanpa loading
- Styling komprehensif untuk semua kontrol DataTables
- Dark mode support lengkap

### Versi 1.4.0
- Menambahkan fitur gambar landing page dinamis
- Admin dapat upload gambar hero dan about section
- Fallback otomatis ke gambar Unsplash
- Menu baru di admin sidebar untuk mengelola gambar landing

### Versi 1.3.0
- Menambahkan fitur Export PDF Statistik dengan chart sebagai gambar
- Chart sekarang memiliki judul dan legend
- File temporary PDF dihapus secara otomatis
- Menambahkan indikator loading
- Modal View Data untuk melihat data lengkap anak
- Fitur upload foto anak dengan validasi
- Update dashboard dan laporan dokumen dengan statistik foto
- Sistem pencatatan aktivitas pengguna
- Halaman changelog dan logs admin
- Role operator baru

### Versi 1.2.0
- Menambahkan halaman kontak pengembang
- Memperbarui struktur menu sidebar
- Menambahkan menu Dukung Kami ke sidebar

### Versi 1.1.0
- Menambahkan format tanggal Indonesia di seluruh aplikasi
- Menambahkan Dark Mode support untuk halaman laporan
- Redesain halaman Dukung Kami dengan rekening Bank BSI dan BRI
- Optimasi untuk production deployment
- Konsistensi UI dengan format tanggal lokal

### Versi 1.0.0
Versi stabil pertama dengan semua fitur utama telah diimplementasikan. Aplikasi siap digunakan untuk produksi dengan LKSA.

### Roadmap
- [ ] Multi-level user permissions
- [ ] Notifikasi email/SMS
- [ ] Mobile app (Android/iOS)
- [ ] API untuk integrasi eksternal
- [ ] Backup otomatis ke cloud
- [ ] Multi-language support
- [ ] Advanced reporting dengan grafik
- [ ] Whatsapp integration

---

<p align="center">
  <sub>Dibuat dengan ❤️ oleh Moh. Heri Setiawan</sub>
</p>
