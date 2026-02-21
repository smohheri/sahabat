-- Menambahkan kolom status_tinggal ke tabel anak
ALTER TABLE anak ADD COLUMN status_tinggal VARCHAR(100) DEFAULT NULL AFTER status_anak;
