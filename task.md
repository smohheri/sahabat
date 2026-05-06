# Task Plan - Sentralisasi CSS di Views

Tanggal: 2026-05-03
Scope: application/views dan assets/css

## Baseline Audit

- Inline style (style=): 286 kemunculan di 23 file.
- Internal style block (<style>): 43 kemunculan di 42 file.
- Dynamic style injection (JS): 3 lokasi.

## Tujuan

1. CSS non-PDF terpusat di stylesheet.
2. Mengurangi inline style secara bertahap tanpa ubah tampilan.
3. Menetapkan guardrail agar inline style baru tidak muncul lagi.

## Definition of Done

1. Tidak ada style inline baru pada view non-PDF.
2. Tidak ada blok <style> baru pada view non-PDF.
3. Semua style reusable berada di:
   - assets/css/panel-global.css
   - assets/css/landing.css
   - assets/landing/css/style.css
4. Perubahan visual tetap konsisten setelah smoke test halaman utama.

## Urutan Eksekusi

Fase 1 -> Fase 2 -> Fase 3 -> Fase 4 -> Fase 5
Guardrail di Fase 6 dijalankan paralel setelah Fase 2.

---

## Fase 1 - Quick Win Inline Statis (P0)

Estimasi: 1-2 hari
Target: Pangkas inline style statis pada file kecil dan berisiko rendah.

### File Target

- application/views/auth/login.php
- application/views/templates/sidebar_lksa.php
- application/views/templates/sidebar_guru.php
- application/views/templates/sidebar_anak.php
- application/views/guru/profil_pengajar.php
- application/views/guru/edit_profil_pengajar.php

### Task Checklist

- [x] Inventaris style inline statis per file.
- [x] Buat class CSS reusable di assets/css/panel-global.css.
- [x] Ganti atribut style menjadi class di file target.
- [ ] Uji login page, sidebar role, dan profil guru.

### Exit Criteria

- [x] Semua style inline statis di file target dipindahkan ke CSS.
- [ ] Tidak ada regresi visual pada halaman target.

---

## Fase 2 - Template Cleanup (P0)

Estimasi: 1-2 hari
Target: Menurunkan style lokal pada template agar beban style terpusat.

### File Target

- application/views/templates/login_header.php
- application/views/templates/navbar.php
- application/views/templates/head.php

### Task Checklist

- [x] Pindahkan blok <style> reusable ke stylesheet.
- [x] Pertahankan fallback anti-flash tema gelap hanya jika masih diperlukan.
- [x] Rapikan pemanggilan stylesheet agar konsisten.
- [ ] Uji halaman login dan panel utama setelah perubahan template.

### Exit Criteria

- [x] Blok <style> template tersisa hanya untuk kebutuhan runtime yang tidak bisa dipindah.
- [x] Struktur load CSS lebih konsisten di semua halaman panel.

---

## Fase 3 - Landing Refactor (P1)

Estimasi: 3-5 hari
Target: Menangani file landing yang paling banyak inline/internal style.

### File Target

- application/views/landingpage/home.php
- application/views/landingpage/license.php
- application/views/landingpage/donasi.php
- assets/landing/css/style.css
- assets/css/landing.css

### Task Checklist

- [ ] Kelompokkan style inline per komponen (hero, cards, stats, CTA).
- [ ] Pindahkan style ke assets/landing/css/style.css atau assets/css/landing.css.
- [ ] Ubah style dinamis ke class state jika memungkinkan.
- [ ] Uji responsif desktop dan mobile.

### Exit Criteria

- [ ] Inline style berkurang signifikan pada halaman landing.
- [ ] Tampilan landing tetap sama secara visual.

---

## Fase 4 - Standardisasi Modul Panel (P1)

Estimasi: 4-7 hari
Target: Merapikan style pada modul admin, guru, dan anak non-PDF.

### File Target (Prioritas Awal)

- application/views/admin/anak.php
- application/views/admin/pengaturan.php
- application/views/admin/user.php
- application/views/admin/penilaian_master.php
- application/views/guru/perkembangan.php
- application/views/guru/penilaian.php
- application/views/anak/dashboard.php
- application/views/anak/profil.php

### Task Checklist

- [ ] Pindahkan internal style block ke stylesheet modul/global.
- [ ] Standarkan naming class agar konsisten lintas modul.
- [ ] Kurangi duplikasi style antar halaman.
- [ ] Uji fitur utama per modul setelah refactor.

### Exit Criteria

- [ ] Internal style block modul berkurang signifikan.
- [ ] Style reusable sudah berada di CSS terpusat.

---

## Fase 5 - PDF dan Error Views (P2)

Estimasi: 2-3 hari
Target: Cleanup selektif untuk view khusus render PDF dan halaman error.

### File Target

- application/views/admin/penilaian_laporan_detail_pdf.php
- application/views/guru/perkembangan_detail_pdf.php
- application/views/admin/penilaian_laporan_pdf.php
- application/views/errors/html/error_general.php
- application/views/errors/html/error_404.php
- application/views/errors/html/error_db.php

### Task Checklist

- [ ] Evaluasi style mana yang wajib inline untuk kestabilan renderer PDF.
- [ ] Pindahkan style non-kritis yang aman ke CSS terpisah.
- [ ] Dokumentasikan style yang sengaja tetap inline beserta alasannya.

### Exit Criteria

- [ ] PDF tetap render konsisten.
- [ ] Inline style yang tersisa punya justifikasi teknis jelas.

---

## Fase 6 - Guardrail dan Monitoring (P0 Paralel)

Estimasi: mulai setelah Fase 2, berjalan terus
Target: Mencegah pola lama muncul kembali.

### Task Checklist

- [ ] Tetapkan aturan review: non-PDF dilarang menambah style inline baru.
- [ ] Jalankan audit berkala untuk style= dan <style> di application/views.
- [ ] Tambahkan catatan standar sentralisasi CSS di dokumentasi tim.

### Exit Criteria

- [ ] Tidak ada penambahan inline/internal style baru di non-PDF.
- [ ] Audit berkala menunjukkan tren penurunan yang stabil.

---

## Risk dan Mitigasi

1. Risiko: Regresi visual setelah pemindahan style.
   Mitigasi: Refactor bertahap per file dan smoke test setiap fase.

2. Risiko: Konflik class name antar modul.
   Mitigasi: Gunakan prefix class per domain (landing, panel, module).

3. Risiko: PDF layout berubah jika style dipindah agresif.
   Mitigasi: Jadikan PDF fase terakhir dan lakukan pendekatan selektif.

## Catatan Eksekusi

- Fokus awal pada file dengan dampak paling tinggi dan risiko rendah.
- Setiap fase harus selesai dengan validasi visual minimum sebelum lanjut ke fase berikutnya.
