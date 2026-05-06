-- =====================================================
-- Add separate kepala LKSA fields: putra and putri
-- =====================================================
-- Jalankan file ini untuk menambah kolom baru pada tabel pengaturan.

-- Opsi 1: Tambahkan kedua kolom sekaligus (jika DB mendukung)
ALTER TABLE pengaturan
ADD COLUMN nama_kepala_putra VARCHAR(150) NULL AFTER nama_kepala,
ADD COLUMN nama_kepala_putri VARCHAR(150) NULL AFTER nama_kepala_putra;

-- Opsi 2: Jika Opsi 1 error, jalankan satu per satu
-- ALTER TABLE pengaturan ADD COLUMN nama_kepala_putra VARCHAR(150) NULL AFTER nama_kepala;
-- ALTER TABLE pengaturan ADD COLUMN nama_kepala_putri VARCHAR(150) NULL AFTER nama_kepala_putra;

-- Opsi 3: Query aman jika kolom mungkin sudah ada (MySQL 8+/MariaDB tertentu)
-- SET @dbname = DATABASE();
-- SET @tablename = 'pengaturan';
--
-- SET @columnname = 'nama_kepala_putra';
-- SET @preparedStatement = (SELECT IF(
--   (
--     SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
--     WHERE TABLE_SCHEMA = @dbname
--       AND TABLE_NAME = @tablename
--       AND COLUMN_NAME = @columnname
--   ) > 0,
--   "SELECT 'Kolom nama_kepala_putra sudah ada'",
--   CONCAT("ALTER TABLE ", @tablename, " ADD COLUMN ", @columnname, " VARCHAR(150) NULL AFTER nama_kepala")
-- ));
-- PREPARE alterIfNotExists FROM @preparedStatement;
-- EXECUTE alterIfNotExists;
-- DEALLOCATE PREPARE alterIfNotExists;
--
-- SET @columnname = 'nama_kepala_putri';
-- SET @preparedStatement = (SELECT IF(
--   (
--     SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
--     WHERE TABLE_SCHEMA = @dbname
--       AND TABLE_NAME = @tablename
--       AND COLUMN_NAME = @columnname
--   ) > 0,
--   "SELECT 'Kolom nama_kepala_putri sudah ada'",
--   CONCAT("ALTER TABLE ", @tablename, " ADD COLUMN ", @columnname, " VARCHAR(150) NULL AFTER nama_kepala_putra")
-- ));
-- PREPARE alterIfNotExists FROM @preparedStatement;
-- EXECUTE alterIfNotExists;
-- DEALLOCATE PREPARE alterIfNotExists;

-- Opsional: Inisialisasi data awal dari kolom lama
-- UPDATE pengaturan
-- SET nama_kepala_putra = COALESCE(nama_kepala_putra, nama_kepala)
-- WHERE nama_kepala IS NOT NULL AND nama_kepala != '';
