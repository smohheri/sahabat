-- Menambahkan role anak dan relasi users ke tabel anak
-- Tujuan: akun dengan role anak hanya dapat mengakses data miliknya

ALTER TABLE users
MODIFY COLUMN role ENUM('admin','petugas','dinas','operator','guru','pengajar','anak') NOT NULL;

SET @column_exists := (
	SELECT COUNT(*)
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE()
	  AND TABLE_NAME = 'users'
	  AND COLUMN_NAME = 'id_anak'
);

SET @sql_add_column := IF(
	@column_exists = 0,
	'ALTER TABLE users ADD COLUMN id_anak INT NULL AFTER role',
	'SELECT "Kolom id_anak sudah ada"'
);
PREPARE stmt_add_column FROM @sql_add_column;
EXECUTE stmt_add_column;
DEALLOCATE PREPARE stmt_add_column;

SET @index_exists := (
	SELECT COUNT(*)
	FROM INFORMATION_SCHEMA.STATISTICS
	WHERE TABLE_SCHEMA = DATABASE()
	  AND TABLE_NAME = 'users'
	  AND INDEX_NAME = 'idx_users_id_anak'
);

SET @sql_add_index := IF(
	@index_exists = 0,
	'ALTER TABLE users ADD INDEX idx_users_id_anak (id_anak)',
	'SELECT "Index idx_users_id_anak sudah ada"'
);
PREPARE stmt_add_index FROM @sql_add_index;
EXECUTE stmt_add_index;
DEALLOCATE PREPARE stmt_add_index;

SET @fk_exists := (
	SELECT COUNT(*)
	FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
	WHERE CONSTRAINT_SCHEMA = DATABASE()
	  AND CONSTRAINT_NAME = 'fk_users_anak'
	  AND TABLE_NAME = 'users'
);

SET @sql_add_fk := IF(
	@fk_exists = 0,
	'ALTER TABLE users ADD CONSTRAINT fk_users_anak FOREIGN KEY (id_anak) REFERENCES anak(id_anak) ON DELETE SET NULL ON UPDATE CASCADE',
	'SELECT "Foreign key fk_users_anak sudah ada"'
);
PREPARE stmt_add_fk FROM @sql_add_fk;
EXECUTE stmt_add_fk;
DEALLOCATE PREPARE stmt_add_fk;

-- Opsional: batasi satu akun anak per satu data anak (aktifkan bila diperlukan)
-- ALTER TABLE users ADD UNIQUE KEY uniq_users_id_anak (id_anak);
