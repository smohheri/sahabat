-- =====================================================
-- Add social media columns to pengaturan table
-- =====================================================
-- Run this SQL to add social media fields

-- Cara 1: Menambahkan semua kolom sekaligus (MySQL 5+)
ALTER TABLE pengaturan 
ADD COLUMN facebook VARCHAR(255) DEFAULT NULL AFTER tahun_berdiri,
ADD COLUMN twitter VARCHAR(255) DEFAULT NULL AFTER facebook,
ADD COLUMN instagram VARCHAR(255) DEFAULT NULL AFTER twitter,
ADD COLUMN youtube VARCHAR(255) DEFAULT NULL AFTER instagram,
ADD COLUMN linkedin VARCHAR(255) DEFAULT NULL AFTER youtube,
ADD COLUMN whatsapp VARCHAR(50) DEFAULT NULL AFTER linkedin;

-- =====================================================
-- Cara 2: Menambahkan kolom satu per satu (jika cara 1 error)
-- =====================================================
-- ALTER TABLE pengaturan ADD COLUMN facebook VARCHAR(255) DEFAULT NULL;
-- ALTER TABLE pengaturan ADD COLUMN twitter VARCHAR(255) DEFAULT NULL;
-- ALTER TABLE pengaturan ADD COLUMN instagram VARCHAR(255) DEFAULT NULL;
-- ALTER TABLE pengaturan ADD COLUMN youtube VARCHAR(255) DEFAULT NULL;
-- ALTER TABLE pengaturan ADD COLUMN linkedin VARCHAR(255) DEFAULT NULL;
-- ALTER TABLE pengaturan ADD COLUMN whatsapp VARCHAR(50) DEFAULT NULL;

-- =====================================================
-- Cara 3: Jika tabel belum ada, gunakan ini untuk membuat tabel lengkap
-- =====================================================
-- CREATE TABLE IF NOT EXISTS pengaturan (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     nama_lksa VARCHAR(255) NOT NULL,
--     nama_kepala VARCHAR(255) NOT NULL,
--     alamat TEXT NOT NULL,
--     no_telp VARCHAR(50) NOT NULL,
--     email VARCHAR(255) NOT NULL,
--     tahun_berdiri YEAR(4) NOT NULL,
--     logo VARCHAR(255) DEFAULT NULL,
--     dokumen_legal VARCHAR(255) DEFAULT NULL,
--     kop_surat VARCHAR(255) DEFAULT NULL,
--     facebook VARCHAR(255) DEFAULT NULL,
--     twitter VARCHAR(255) DEFAULT NULL,
--     instagram VARCHAR(255) DEFAULT NULL,
--     youtube VARCHAR(255) DEFAULT NULL,
--     linkedin VARCHAR(255) DEFAULT NULL,
--     whatsapp VARCHAR(50) DEFAULT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- );

-- =====================================================
-- Verifikasi: Periksa apakah kolom sudah ditambahkan
-- =====================================================
-- DESCRIBE pengaturan;
-- atau
-- SHOW COLUMNS FROM pengaturan LIKE 'facebook';
-- SHOW COLUMNS FROM pengaturan LIKE 'whatsapp';
