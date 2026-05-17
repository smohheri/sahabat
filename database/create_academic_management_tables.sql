-- =========================================================
-- Tabel untuk Manajemen Akademik:
-- 1) Master Mata Pelajaran
-- 2) Rombel (kelas belajar)
-- 3) Relasi Rombel <-> Anak dan Rombel <-> Mapel
-- 4) Absensi per Mapel
-- =========================================================

CREATE TABLE IF NOT EXISTS `mata_pelajaran` (
  `id_mata_pelajaran` INT NOT NULL AUTO_INCREMENT,
  `kode_mapel` VARCHAR(50) NOT NULL,
  `nama_mapel` VARCHAR(150) NOT NULL,
  `id_user_pengampu` INT DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mata_pelajaran`),
  UNIQUE KEY `uq_kode_mapel` (`kode_mapel`),
  KEY `idx_mapel_pengampu` (`id_user_pengampu`),
  CONSTRAINT `fk_mapel_pengampu_user` FOREIGN KEY (`id_user_pengampu`) REFERENCES `users`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `rombel` (
  `id_rombel` INT NOT NULL AUTO_INCREMENT,
  `kode_rombel` VARCHAR(50) NOT NULL,
  `nama_rombel` VARCHAR(150) NOT NULL,
  `tahun_ajaran` VARCHAR(20) NOT NULL,
  `semester` TINYINT NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `keterangan` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rombel`),
  UNIQUE KEY `uq_kode_rombel` (`kode_rombel`),
  UNIQUE KEY `uq_rombel_period` (`nama_rombel`, `tahun_ajaran`, `semester`),
  KEY `idx_rombel_period` (`tahun_ajaran`, `semester`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `rombel_anak` (
  `id_rombel_anak` INT NOT NULL AUTO_INCREMENT,
  `id_rombel` INT NOT NULL,
  `id_anak` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rombel_anak`),
  UNIQUE KEY `uq_rombel_anak` (`id_rombel`, `id_anak`),
  KEY `idx_rombel_anak_anak` (`id_anak`),
  CONSTRAINT `fk_rombel_anak_rombel` FOREIGN KEY (`id_rombel`) REFERENCES `rombel`(`id_rombel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rombel_anak_anak` FOREIGN KEY (`id_anak`) REFERENCES `anak`(`id_anak`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `rombel_mata_pelajaran` (
  `id_rombel_mapel` INT NOT NULL AUTO_INCREMENT,
  `id_rombel` INT NOT NULL,
  `id_mata_pelajaran` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rombel_mapel`),
  UNIQUE KEY `uq_rombel_mapel` (`id_rombel`, `id_mata_pelajaran`),
  KEY `idx_rombel_mapel_mapel` (`id_mata_pelajaran`),
  CONSTRAINT `fk_rombel_mapel_rombel` FOREIGN KEY (`id_rombel`) REFERENCES `rombel`(`id_rombel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rombel_mapel_mapel` FOREIGN KEY (`id_mata_pelajaran`) REFERENCES `mata_pelajaran`(`id_mata_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `absensi_mapel_sessions` (
  `id_session` INT NOT NULL AUTO_INCREMENT,
  `id_rombel` INT NOT NULL,
  `id_mata_pelajaran` INT NOT NULL,
  `tahun_ajaran` VARCHAR(20) NOT NULL,
  `semester` TINYINT NOT NULL,
  `tanggal_absensi` DATE NOT NULL,
  `catatan` TEXT,
  `created_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_session`),
  UNIQUE KEY `uq_absensi_session` (`id_rombel`, `id_mata_pelajaran`, `tahun_ajaran`, `semester`, `tanggal_absensi`),
  KEY `idx_absensi_session_period` (`tahun_ajaran`, `semester`, `tanggal_absensi`),
  KEY `idx_absensi_session_created_by` (`created_by`),
  CONSTRAINT `fk_absensi_session_rombel` FOREIGN KEY (`id_rombel`) REFERENCES `rombel`(`id_rombel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_absensi_session_mapel` FOREIGN KEY (`id_mata_pelajaran`) REFERENCES `mata_pelajaran`(`id_mata_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_absensi_session_user` FOREIGN KEY (`created_by`) REFERENCES `users`(`id_user`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `absensi_mapel_details` (
  `id_detail` INT NOT NULL AUTO_INCREMENT,
  `id_session` INT NOT NULL,
  `id_anak` INT NOT NULL,
  `status_kehadiran` ENUM('Hadir','Izin','Sakit','Alpha') NOT NULL DEFAULT 'Hadir',
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detail`),
  UNIQUE KEY `uq_absensi_detail` (`id_session`, `id_anak`),
  KEY `idx_absensi_detail_anak` (`id_anak`),
  KEY `idx_absensi_detail_status` (`status_kehadiran`),
  CONSTRAINT `fk_absensi_detail_session` FOREIGN KEY (`id_session`) REFERENCES `absensi_mapel_sessions`(`id_session`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_absensi_detail_anak` FOREIGN KEY (`id_anak`) REFERENCES `anak`(`id_anak`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
