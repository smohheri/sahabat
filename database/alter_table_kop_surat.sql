-- SQL ALTER TABLE untuk menambahkan kolom kop_surat
-- Jalankan query ini di phpMyAdmin atau MySQL console

-- Opsi 1: ALTER TABLE sederhana (paling umum)
ALTER TABLE pengaturan ADD COLUMN kop_surat VARCHAR(255) NULL;

-- Opsi 2: Jika ingin menambahkan setelah kolom tertentu
-- ALTER TABLE pengaturan ADD COLUMN kop_surat VARCHAR(255) NULL AFTER dokumen_legal;

-- Opsi 3: Query dengan pengecekan (hindari error jika kolom sudah ada)
-- MySQL 8.0+ atau MariaDB 10.3+
SET @dbname = DATABASE();
SET @tablename = "pengaturan";
SET @columnname = "kop_surat";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = @dbname
    AND TABLE_NAME = @tablename
    AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 'Kolom kop_surat sudah ada'",
  CONCAT("ALTER TABLE ", @tablename, " ADD COLUMN ", @columnname, " VARCHAR(255) NULL")
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
