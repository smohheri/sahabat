-- Menambahkan kolom profesional pada tabel guru
-- Aman dijalankan berulang (idempotent)

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'nip'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN nip VARCHAR(30) NULL AFTER nama_guru',
  'SELECT "Kolom nip sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'pendidikan_terakhir'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN pendidikan_terakhir VARCHAR(100) NULL AFTER jabatan',
  'SELECT "Kolom pendidikan_terakhir sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'bidang_keahlian'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN bidang_keahlian VARCHAR(150) NULL AFTER pendidikan_terakhir',
  'SELECT "Kolom bidang_keahlian sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'sertifikasi'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN sertifikasi VARCHAR(255) NULL AFTER bidang_keahlian',
  'SELECT "Kolom sertifikasi sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'pengalaman_tahun'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN pengalaman_tahun TINYINT UNSIGNED NULL AFTER sertifikasi',
  'SELECT "Kolom pengalaman_tahun sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'status_kepegawaian'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN status_kepegawaian VARCHAR(50) NULL AFTER pengalaman_tahun',
  'SELECT "Kolom status_kepegawaian sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'alamat'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN alamat TEXT NULL AFTER email',
  'SELECT "Kolom alamat sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'foto'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN foto VARCHAR(255) NULL AFTER alamat',
  'SELECT "Kolom foto sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'guru'
    AND COLUMN_NAME = 'file_ijazah_terakhir'
);
SET @sql := IF(
  @col_exists = 0,
  'ALTER TABLE guru ADD COLUMN file_ijazah_terakhir VARCHAR(255) NULL AFTER foto',
  'SELECT "Kolom file_ijazah_terakhir sudah ada"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
