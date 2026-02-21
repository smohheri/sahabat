-- Menambahkan kolom file_ktp ke tabel pengurus
ALTER TABLE pengurus ADD COLUMN file_ktp VARCHAR(255) DEFAULT NULL AFTER email;
