-- =====================================================
-- Add landing page image columns to pengaturan table
-- =====================================================
-- Run this SQL to add landing page image fields

ALTER TABLE pengaturan
ADD COLUMN hero_image VARCHAR(255) DEFAULT NULL,
ADD COLUMN about_image VARCHAR(255) DEFAULT NULL AFTER hero_image;

-- =====================================================
-- Verifikasi: Periksa apakah kolom sudah ditambahkan
-- =====================================================
-- DESCRIBE pengaturan;
-- atau
-- SHOW COLUMNS FROM pengaturan LIKE 'hero_image';
-- SHOW COLUMNS FROM pengaturan LIKE 'about_image';
