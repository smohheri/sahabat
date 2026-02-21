-- Menambahkan kolom foto ke tabel anak
ALTER TABLE anak ADD COLUMN foto VARCHAR(255) DEFAULT NULL AFTER file_pendukung;
