# Changelog

Semua perubahan penting pada aplikasi SAHABAT akan didokumentasikan di file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.0] - 2025-02-21

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

### Technical
- 🔧 **Direktori baru** - `assets/temp/` untuk menyimpan file PDF sementara

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

### Versi 1.3.0
- Menambahkan fitur Export PDF Statistik dengan chart sebagai gambar
- Chart sekarang memiliki judul dan legend
- File temporary PDF dihapus secara otomatis
- Menambahkan indikator loading

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
