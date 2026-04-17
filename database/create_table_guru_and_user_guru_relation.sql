-- Membuat tabel tersendiri untuk data guru/pengajar
-- serta menambahkan relasi permanen dari users ke tabel guru

CREATE TABLE IF NOT EXISTS guru (
  id_guru INT NOT NULL AUTO_INCREMENT,
  nama_guru VARCHAR(150) NOT NULL,
  nip VARCHAR(30) DEFAULT NULL,
  jabatan VARCHAR(100) DEFAULT NULL,
  pendidikan_terakhir VARCHAR(100) DEFAULT NULL,
  bidang_keahlian VARCHAR(150) DEFAULT NULL,
  sertifikasi VARCHAR(255) DEFAULT NULL,
  pengalaman_tahun TINYINT UNSIGNED DEFAULT NULL,
  status_kepegawaian VARCHAR(50) DEFAULT NULL,
  no_hp VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  alamat TEXT,
  foto VARCHAR(255) DEFAULT NULL,
  file_ijazah_terakhir VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_guru)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET @column_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users'
    AND COLUMN_NAME = 'id_guru'
);

SET @sql_add_column := IF(
  @column_exists = 0,
  'ALTER TABLE users ADD COLUMN id_guru INT NULL AFTER id_anak',
  'SELECT "Kolom id_guru sudah ada"'
);
PREPARE stmt_add_column FROM @sql_add_column;
EXECUTE stmt_add_column;
DEALLOCATE PREPARE stmt_add_column;

SET @index_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.STATISTICS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users'
    AND INDEX_NAME = 'idx_users_id_guru'
);

SET @sql_add_index := IF(
  @index_exists = 0,
  'ALTER TABLE users ADD INDEX idx_users_id_guru (id_guru)',
  'SELECT "Index idx_users_id_guru sudah ada"'
);
PREPARE stmt_add_index FROM @sql_add_index;
EXECUTE stmt_add_index;
DEALLOCATE PREPARE stmt_add_index;

-- Backfill data guru dari pengurus berdasarkan nama (jika belum ada)
INSERT INTO guru (nama_guru, jabatan, no_hp, email)
SELECT p.nama_pengurus, p.jabatan, p.no_hp, p.email
FROM pengurus p
LEFT JOIN guru g ON LOWER(TRIM(g.nama_guru)) = LOWER(TRIM(p.nama_pengurus))
WHERE g.id_guru IS NULL;

-- Backfill relasi users.id_guru untuk role guru/pengajar
UPDATE users u
JOIN guru g ON LOWER(TRIM(u.nama)) = LOWER(TRIM(g.nama_guru))
SET u.id_guru = g.id_guru
WHERE u.id_guru IS NULL
  AND u.role IN ('guru', 'pengajar');

SET @fk_exists := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
  WHERE CONSTRAINT_SCHEMA = DATABASE()
    AND CONSTRAINT_NAME = 'fk_users_guru'
    AND TABLE_NAME = 'users'
);

SET @sql_add_fk := IF(
  @fk_exists = 0,
  'ALTER TABLE users ADD CONSTRAINT fk_users_guru FOREIGN KEY (id_guru) REFERENCES guru(id_guru) ON DELETE SET NULL ON UPDATE CASCADE',
  'SELECT "Foreign key fk_users_guru sudah ada"'
);
PREPARE stmt_add_fk FROM @sql_add_fk;
EXECUTE stmt_add_fk;
DEALLOCATE PREPARE stmt_add_fk;

-- Opsional: batasi satu akun per satu data guru
-- ALTER TABLE users ADD UNIQUE KEY uniq_users_id_guru (id_guru);
