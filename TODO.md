# TODO: Sinkronisasi Tabel Carousel Hero Section dengan Landing Page

## Tugas Utama
- Sinkronkan tabel yang digunakan di carousel hero section dengan landing page
- Hapus fungsi yang tidak digunakan di admin
- Lengkapi fungsi yang sudah sinkron dengan landing page

## Langkah-langkah Implementasi

### 1. Modifikasi Controller Landing
- [x] Tambahkan load Hero_model di Landing.php
- [x] Ambil data hero_images aktif di method index()

### 2. Modifikasi View Landing Page
- [x] Update application/views/landingpage/home.php untuk menggunakan data hero_images
- [x] Ganti teks statis hero dengan data dinamis dari hero_images

### 3. Hapus Fungsi Tidak Digunakan di Admin
- [x] Hapus method upload_landing_hero_image dari Admin.php
- [x] Update view admin/landing.php untuk menghapus section upload hero image

### 4. Verifikasi Sinkronisasi
- [x] Pastikan landing page menggunakan carousel_images dan hero_images
- [x] Test admin hero management berfungsi dengan landing page

### 5. Buat Halaman Upload Hero
- [x] Tambahkan method upload_hero() dan process_upload_hero() di Admin.php
- [x] Buat view application/views/admin/upload_hero.php untuk halaman upload dedicated

### 6. Tambahkan ke Menu Sidebar
- [x] Tambahkan menu "Upload Hero Images", "Kelola Hero Images", dan "Kelola Carousel" ke sidebar admin dalam kelompok Pengaturan

### 7. Cleanup
- [x] Hapus referensi hero_image dari settings karena tidak digunakan lagi
- [x] Hapus file dan model yang tidak digunakan (Hero_model.php, hero.php, upload_hero.php)
- [x] Update dokumentasi jika diperlukan

## Status: SELESAI
Semua tugas telah diselesaikan. Landing page sekarang menggunakan tabel carousel_images untuk carousel dan hero_images untuk konten hero dinamis. Fungsi admin yang tidak digunakan telah dihapus, dan menu sidebar telah diperbarui.
