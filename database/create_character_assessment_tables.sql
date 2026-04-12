-- =========================================================
-- Tabel untuk Sistem Penilaian Karakter
-- =========================================================

-- Tabel: Skala Penilaian (Master Data)
CREATE TABLE IF NOT EXISTS `character_scale` (
  `id_scale` INT NOT NULL AUTO_INCREMENT,
  `score` INT NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_scale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Aspek Penilaian
CREATE TABLE IF NOT EXISTS `character_aspects` (
  `id_aspect` INT NOT NULL AUTO_INCREMENT,
  `aspect_name` VARCHAR(150) NOT NULL,
  `aspect_code` VARCHAR(50) UNIQUE NOT NULL,
  `description` TEXT,
  `order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aspect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Indikator Penilaian
CREATE TABLE IF NOT EXISTS `character_indicators` (
  `id_indicator` INT NOT NULL AUTO_INCREMENT,
  `id_aspect` INT NOT NULL,
  `indicator_name` VARCHAR(255) NOT NULL,
  `indicator_code` VARCHAR(50),
  `description` TEXT,
  `order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_indicator`),
  FOREIGN KEY (`id_aspect`) REFERENCES `character_aspects`(`id_aspect`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Penilaian Karakter Utama
CREATE TABLE IF NOT EXISTS `character_assessments` (
  `id_assessment` INT NOT NULL AUTO_INCREMENT,
  `id_anak` INT NOT NULL,
  `id_assessor` INT NOT NULL,
  `assessor_type` ENUM('guru', 'anak_asuh') DEFAULT 'guru',
  `assessment_date` DATE NOT NULL,
  `week_number` INT DEFAULT NULL,
  `month` INT DEFAULT NULL,
  `year` INT DEFAULT NULL,
  `notes` TEXT,
  `status` ENUM('draft', 'completed', 'reviewed') DEFAULT 'draft',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_assessment`),
  FOREIGN KEY (`id_anak`) REFERENCES `anak`(`id_anak`) ON DELETE CASCADE,
  FOREIGN KEY (`id_assessor`) REFERENCES `users`(`id_user`) ON DELETE CASCADE,
  KEY `idx_week` (`week_number`, `year`),
  KEY `idx_month` (`month`, `year`),
  KEY `idx_anak_date` (`id_anak`, `assessment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Detail Penilaian (Score per Indikator)
CREATE TABLE IF NOT EXISTS `character_assessment_details` (
  `id_detail` INT NOT NULL AUTO_INCREMENT,
  `id_assessment` INT NOT NULL,
  `id_indicator` INT NOT NULL,
  `score` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detail`),
  UNIQUE KEY `uq_assessment_indicator` (`id_assessment`, `id_indicator`),
  FOREIGN KEY (`id_assessment`) REFERENCES `character_assessments`(`id_assessment`) ON DELETE CASCADE,
  FOREIGN KEY (`id_indicator`) REFERENCES `character_indicators`(`id_indicator`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Catatan Kualitatif
CREATE TABLE IF NOT EXISTS `character_qualitative_notes` (
  `id_note` INT NOT NULL AUTO_INCREMENT,
  `id_assessment` INT NOT NULL,
  `strengths` TEXT,
  `development_observed` TEXT,
  `areas_to_support` TEXT,
  `support_strategy` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_note`),
  UNIQUE KEY `uq_assessment_note` (`id_assessment`),
  FOREIGN KEY (`id_assessment`) REFERENCES `character_assessments`(`id_assessment`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Ringkasan Penilaian Per Bulan (untuk reporting)
CREATE TABLE IF NOT EXISTS `character_monthly_summary` (
  `id_summary` INT NOT NULL AUTO_INCREMENT,
  `id_anak` INT NOT NULL,
  `id_aspect` INT NOT NULL,
  `month` INT NOT NULL,
  `year` INT NOT NULL,
  `avg_score` DECIMAL(5, 2),
  `assessor_type` ENUM('guru', 'anak_asuh') DEFAULT 'guru',
  `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_summary`),
  UNIQUE KEY `uq_monthly` (`id_anak`, `id_aspect`, `month`, `year`, `assessor_type`),
  FOREIGN KEY (`id_anak`) REFERENCES `anak`(`id_anak`) ON DELETE CASCADE,
  FOREIGN KEY (`id_aspect`) REFERENCES `character_aspects`(`id_aspect`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel: Ringkasan Penilaian Per Minggu (untuk reporting)
CREATE TABLE IF NOT EXISTS `character_weekly_summary` (
  `id_summary` INT NOT NULL AUTO_INCREMENT,
  `id_anak` INT NOT NULL,
  `id_aspect` INT NOT NULL,
  `week_number` INT NOT NULL,
  `year` INT NOT NULL,
  `avg_score` DECIMAL(5, 2),
  `assessor_type` ENUM('guru', 'anak_asuh') DEFAULT 'guru',
  `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_summary`),
  UNIQUE KEY `uq_weekly` (`id_anak`, `id_aspect`, `week_number`, `year`, `assessor_type`),
  FOREIGN KEY (`id_anak`) REFERENCES `anak`(`id_anak`) ON DELETE CASCADE,
  FOREIGN KEY (`id_aspect`) REFERENCES `character_aspects`(`id_aspect`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- INSERT DATA MASTER
-- =========================================================

-- Insert Skala Penilaian
INSERT INTO `character_scale` (`score`, `category`, `description`) VALUES
(1, 'Perlu Pendampingan Intensif', 'Belum menunjukkan perilaku yang diharapkan'),
(2, 'Mulai Berkembang', 'Kadang menunjukkan perilaku, belum konsisten'),
(3, 'Baik', 'Sering menunjukkan perilaku dengan sedikit arahan'),
(4, 'Sangat Baik', 'Konsisten tanpa diingatkan');

-- Insert Aspek Penilaian
INSERT INTO `character_aspects` (`aspect_name`, `aspect_code`, `description`, `order`) VALUES
('Kesadaran Diri', 'SELF_AWARENESS', 'Kemampuan mengenali kelebihan, kekurangan, dan perasaan diri sendiri', 1),
('Pengendalian Emosi', 'EMOTION_CONTROL', 'Kemampuan mengelola dan mengontrol emosi dengan baik', 2),
('Kedisiplinan & Tanggung Jawab', 'DISCIPLINE', 'Ketaatan terhadap aturan dan tanggung jawab terhadap kewajibannya', 3),
('Interaksi Sosial', 'SOCIAL_INTERACTION', 'Kemampuan berinteraksi dan berkolaborasi dengan orang lain', 4),
('Life Skills & Kemandirian', 'LIFE_SKILLS', 'Kemampuan merawat diri, mengelola waktu, dan membuat keputusan', 5);

-- Insert Indikator untuk Kesadaran Diri
INSERT INTO `character_indicators` (`id_aspect`, `indicator_name`, `indicator_code`, `order`) VALUES
(1, 'Mengenali kelebihan diri', 'SA_001', 1),
(1, 'Mengakui kesalahan', 'SA_002', 2),
(1, 'Mampu menyebutkan perasaan sendiri', 'SA_003', 3),
(1, 'Percaya diri saat berbicara', 'SA_004', 4);

-- Insert Indikator untuk Pengendalian Emosi
INSERT INTO `character_indicators` (`id_aspect`, `indicator_name`, `indicator_code`, `order`) VALUES
(2, 'Tidak mudah marah berlebihan', 'EC_001', 1),
(2, 'Mampu menenangkan diri', 'EC_002', 2),
(2, 'Tidak meluapkan emosi secara agresif', 'EC_003', 3),
(2, 'Mampu menyelesaikan konflik tanpa kekerasan', 'EC_004', 4);

-- Insert Indikator untuk Kedisiplinan & Tanggung Jawab
INSERT INTO `character_indicators` (`id_aspect`, `indicator_name`, `indicator_code`, `order`) VALUES
(3, 'Datang tepat waktu', 'DISC_001', 1),
(3, 'Menyelesaikan tugas', 'DISC_002', 2),
(3, 'Menjaga kebersihan', 'DISC_003', 3),
(3, 'Bertanggung jawab atas kesalahan', 'DISC_004', 4);

-- Insert Indikator untuk Interaksi Sosial
INSERT INTO `character_indicators` (`id_aspect`, `indicator_name`, `indicator_code`, `order`) VALUES
(4, 'Berbicara sopan', 'SI_001', 1),
(4, 'Mau bekerja sama', 'SI_002', 2),
(4, 'Menghargai perbedaan', 'SI_003', 3),
(4, 'Mau membantu teman', 'SI_004', 4);

-- Insert Indikator untuk Life Skills & Kemandirian
INSERT INTO `character_indicators` (`id_aspect`, `indicator_name`, `indicator_code`, `order`) VALUES
(5, 'Mengurus kebutuhan pribadi', 'LS_001', 1),
(5, 'Mengatur waktu', 'LS_002', 2),
(5, 'Mengelola uang sederhana', 'LS_003', 3),
(5, 'Mengambil keputusan sederhana', 'LS_004', 4);

-- =========================================================
-- CREATE VIEWS untuk reporting
-- =========================================================

-- View: Ringkasan Penilaian Bulanan per Anak
CREATE OR REPLACE VIEW `v_monthly_character_report` AS
SELECT 
  a.id_anak,
  a.nama_anak,
  cms.id_aspect,
  asp.aspect_name,
  cms.month,
  cms.year,
  cms.avg_score,
  cms.assessor_type,
  CASE 
    WHEN cms.avg_score >= 3.5 THEN 'Sangat Baik'
    WHEN cms.avg_score >= 2.5 THEN 'Baik'
    WHEN cms.avg_score >= 1.5 THEN 'Mulai Berkembang'
    ELSE 'Perlu Pendampingan Intensif'
  END AS category
FROM anak a
LEFT JOIN character_monthly_summary cms ON a.id_anak = cms.id_anak
LEFT JOIN character_aspects asp ON asp.id_aspect = cms.id_aspect
ORDER BY a.nama_anak, cms.year DESC, cms.month DESC, asp.order;

-- View: Ringkasan Penilaian Mingguan per Anak
CREATE OR REPLACE VIEW `v_weekly_character_report` AS
SELECT 
  a.id_anak,
  a.nama_anak,
  cws.id_aspect,
  asp.aspect_name,
  cws.week_number,
  cws.year,
  cws.avg_score,
  cws.assessor_type,
  CASE 
    WHEN cws.avg_score >= 3.5 THEN 'Sangat Baik'
    WHEN cws.avg_score >= 2.5 THEN 'Baik'
    WHEN cws.avg_score >= 1.5 THEN 'Mulai Berkembang'
    ELSE 'Perlu Pendampingan Intensif'
  END AS category
FROM anak a
LEFT JOIN character_weekly_summary cws ON a.id_anak = cws.id_anak
LEFT JOIN character_aspects asp ON asp.id_aspect = cws.id_aspect
ORDER BY a.nama_anak, cws.year DESC, cws.week_number DESC, asp.order;
