# TODO Utama: Sentralisasi CSS di Views

Tanggal update: 2026-05-03
Referensi detail: task.md

## Baseline

- [x] Inline style: 251 kemunculan di 15 file (turun dari 284 di 21 file sebelum refactor fase 1).
- [x] Internal style block: 41 kemunculan di 40 file (turun dari 43 di 42 file setelah cleanup template fase 2).
- [x] Dynamic style injection: 0 lokasi pola `style="<?php ..."` (turun dari 5 di 1 file sebelum refactor fase 1).

## Fase 1 - Quick Win Inline Statis (P0)

- [x] Inventaris style inline statis per file.
- [x] Buat class CSS reusable di assets/css/panel-global.css.
- [x] Ganti atribut style menjadi class di file target.
- [ ] Uji login page, sidebar role, dan profil guru.
- [x] File target: application/views/auth/login.php.
- [x] File target: application/views/templates/sidebar_lksa.php.
- [x] File target: application/views/templates/sidebar_guru.php.
- [x] File target: application/views/templates/sidebar_anak.php.
- [x] File target: application/views/guru/profil_pengajar.php.
- [x] File target: application/views/guru/edit_profil_pengajar.php.
- [x] Validasi syntax PHP file target lulus.

## Fase 2 - Template Cleanup (P0)

- [x] Pindahkan blok <style> reusable ke stylesheet.
- [x] Pertahankan fallback anti-flash tema gelap hanya jika masih diperlukan.
- [x] Rapikan pemanggilan stylesheet agar konsisten.
- [ ] Uji halaman login dan panel utama.
- [x] File target: application/views/templates/login_header.php.
- [x] File target: application/views/templates/navbar.php.
- [x] File target: application/views/templates/head.php.
- [x] CSS template baru: assets/css/login-template.css.
- [x] CSS template baru: assets/css/theme-dark-mode.css.

## Fase 3 - Landing Refactor (P1)

- [ ] Kelompokkan style inline per komponen.
- [ ] Pindahkan style ke assets/landing/css/style.css atau assets/css/landing.css.
- [ ] Ubah style dinamis ke class state jika memungkinkan.
- [ ] Uji responsif desktop dan mobile.
- [ ] File target: application/views/landingpage/home.php.
- [ ] File target: application/views/landingpage/license.php.
- [ ] File target: application/views/landingpage/donasi.php.

## Fase 4 - Standardisasi Modul Panel (P1)

- [ ] Pindahkan internal style block ke stylesheet modul/global.
- [ ] Standarkan naming class lintas modul.
- [ ] Kurangi duplikasi style antar halaman.
- [ ] Uji fitur utama per modul.
- [ ] File target: application/views/admin/anak.php.
- [ ] File target: application/views/admin/pengaturan.php.
- [ ] File target: application/views/admin/user.php.
- [ ] File target: application/views/admin/penilaian_master.php.
- [ ] File target: application/views/guru/perkembangan.php.
- [ ] File target: application/views/guru/penilaian.php.
- [ ] File target: application/views/anak/dashboard.php.
- [ ] File target: application/views/anak/profil.php.

## Fase 5 - PDF dan Error Views (P2)

- [ ] Evaluasi style yang wajib inline untuk kestabilan renderer PDF.
- [ ] Pindahkan style non-kritis yang aman ke CSS terpisah.
- [ ] Dokumentasikan style yang sengaja tetap inline beserta alasannya.
- [ ] File target: application/views/admin/penilaian_laporan_detail_pdf.php.
- [ ] File target: application/views/guru/perkembangan_detail_pdf.php.
- [ ] File target: application/views/admin/penilaian_laporan_pdf.php.
- [ ] File target: application/views/errors/html/error_general.php.
- [ ] File target: application/views/errors/html/error_404.php.
- [ ] File target: application/views/errors/html/error_db.php.

## Fase 6 - Guardrail dan Monitoring (P0 Paralel)

- [ ] Tetapkan aturan review: non-PDF tidak menambah inline style baru.
- [ ] Jalankan audit berkala style= dan <style> pada application/views.
- [ ] Tambahkan catatan standar sentralisasi CSS di dokumentasi tim.

## Definition of Done

- [ ] Tidak ada style inline baru pada view non-PDF.
- [ ] Tidak ada blok <style> baru pada view non-PDF.
- [ ] Style reusable terpusat pada assets/css/panel-global.css.
- [ ] Style reusable terpusat pada assets/css/landing.css.
- [ ] Style reusable terpusat pada assets/landing/css/style.css.
- [ ] Smoke test halaman utama lolos tanpa regresi visual.

## Arsip Selesai

### Fix Delete Backup Button

- [x] Analyze issue and root cause.
- [x] Add delete_backup method with validation and security.
- [x] Update delete flow to AJAX/form submission flow.
- [x] Add route and CSRF handling.
- [x] Test implementation.

### Remove Specific Logging

- [x] Remove backup_debug and download debug logs.
- [x] Verify no additional logging cleanup needed.
