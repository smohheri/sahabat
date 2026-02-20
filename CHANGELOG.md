# Changelog

Semua perubahan penting pada aplikasi SAHABAT akan didokumentasikan di file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
