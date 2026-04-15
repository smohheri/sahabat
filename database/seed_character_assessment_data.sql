-- =========================================================
-- SEED DATA: Sistem Penilaian Karakter Anak
-- File: seed_character_assessment_data.sql
-- Tujuan: menyiapkan data dummy untuk uji coba fitur laporan/rekap
-- =========================================================

START TRANSACTION;

-- ---------------------------------------------------------
-- 0) Validasi prasyarat minimal
-- ---------------------------------------------------------
-- Pastikan tabel master sudah ada dan berisi data:
-- - character_aspects
-- - character_indicators
-- Pastikan juga ada data di:
-- - anak
-- - users

-- ---------------------------------------------------------
-- 0.a) Siapkan user dummy assessor jika belum ada
-- ---------------------------------------------------------
INSERT INTO users (nama, username, password, role)
SELECT 'Pengajar Dummy', 'seed_pengajar', 'seed123', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE username = 'seed_pengajar'
);

INSERT INTO users (nama, username, password, role)
SELECT 'Asuh Dummy', 'seed_asuh', 'seed123', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE username = 'seed_asuh'
);

-- ---------------------------------------------------------
-- 1) Bersihkan data seed lama (aman, hanya yang bertanda [SEED])
-- ---------------------------------------------------------
-- Menghapus assessment seed lama akan otomatis menghapus:
-- - character_assessment_details
-- - character_qualitative_notes
-- karena relasi ON DELETE CASCADE
DELETE FROM character_assessments
WHERE notes LIKE '[SEED]%';

-- Hapus summary seed pada rentang tahun berjalan & tahun lalu
DELETE FROM character_weekly_summary
WHERE year IN (YEAR(CURDATE()), YEAR(CURDATE()) - 1)
  AND assessor_type IN ('guru', 'anak_asuh');

DELETE FROM character_monthly_summary
WHERE year IN (YEAR(CURDATE()), YEAR(CURDATE()) - 1)
  AND assessor_type IN ('guru', 'anak_asuh');

-- ---------------------------------------------------------
-- 2) Tentukan assessor (guru & anak_asuh)
-- ---------------------------------------------------------
SET @assessor_guru := (
    SELECT u.id_user
    FROM users u
    WHERE u.role IN ('pengajar', 'admin', 'operator', 'petugas', 'dinas')
    ORDER BY FIELD(u.role, 'pengajar', 'admin', 'operator', 'petugas', 'dinas'), u.id_user
    LIMIT 1
);

SET @assessor_asuh := (
    SELECT u.id_user
    FROM users u
    ORDER BY u.id_user DESC
    LIMIT 1
);

-- Fallback jika tidak ada hasil di atas
SET @assessor_guru := IFNULL(@assessor_guru, (SELECT MIN(id_user) FROM users));
SET @assessor_asuh := IFNULL(@assessor_asuh, @assessor_guru);

-- ---------------------------------------------------------
-- 3) Pilih anak sample (maks. 8 anak)
-- ---------------------------------------------------------
DROP TEMPORARY TABLE IF EXISTS tmp_seed_anak;
CREATE TEMPORARY TABLE tmp_seed_anak (
    seq INT NOT NULL,
    id_anak INT NOT NULL,
    PRIMARY KEY (seq)
);

SET @rownum := 0;
INSERT INTO tmp_seed_anak (seq, id_anak)
SELECT
    (@rownum := @rownum + 1) AS seq,
    a.id_anak
FROM anak a
ORDER BY a.id_anak
LIMIT 8;

-- Jika belum ada data anak, buat dummy anak minimal
SET @total_anak_seed := (SELECT COUNT(*) FROM tmp_seed_anak);

INSERT INTO anak (nama_anak, jenis_kelamin)
SELECT x.nama_anak, x.jenis_kelamin
FROM (
    SELECT 'Anak Dummy 01' AS nama_anak, 'L' AS jenis_kelamin
    UNION ALL SELECT 'Anak Dummy 02', 'P'
    UNION ALL SELECT 'Anak Dummy 03', 'L'
    UNION ALL SELECT 'Anak Dummy 04', 'P'
    UNION ALL SELECT 'Anak Dummy 05', 'L'
    UNION ALL SELECT 'Anak Dummy 06', 'P'
    UNION ALL SELECT 'Anak Dummy 07', 'L'
    UNION ALL SELECT 'Anak Dummy 08', 'P'
) x
WHERE @total_anak_seed = 0;

-- Muat ulang sample anak setelah insert dummy
DELETE FROM tmp_seed_anak;
SET @rownum := 0;
INSERT INTO tmp_seed_anak (seq, id_anak)
SELECT
    (@rownum := @rownum + 1) AS seq,
    a.id_anak
FROM anak a
ORDER BY a.id_anak
LIMIT 8;

-- ---------------------------------------------------------
-- 4) Insert assessment mingguan (assessor: guru)
-- ---------------------------------------------------------
-- Catatan: gunakan tanggal dalam minggu berjalan agar langsung tampil
-- pada filter default laporan (Per Minggu - minggu saat ini).
INSERT INTO character_assessments (
    id_anak,
    id_assessor,
    assessor_type,
    assessment_date,
    week_number,
    month,
    year,
    notes,
    status
)
SELECT
    t.id_anak,
    @assessor_guru,
    'guru',
    DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 7) DAY) AS assessment_date,
    WEEK(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 7) DAY), 1) AS week_number,
    MONTH(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 7) DAY)) AS month,
    YEAR(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 7) DAY)) AS year,
    CONCAT('[SEED] Penilaian mingguan guru #', t.seq),
    CASE
        WHEN MOD(t.seq, 3) = 0 THEN 'reviewed'
        WHEN MOD(t.seq, 2) = 0 THEN 'completed'
        ELSE 'draft'
    END AS status
FROM tmp_seed_anak t;

-- ---------------------------------------------------------
-- 5) Insert assessment bulanan (assessor: anak_asuh)
-- ---------------------------------------------------------
-- Catatan: gunakan tanggal dalam bulan berjalan agar langsung tampil
-- pada filter default laporan (Per Bulan - bulan saat ini).
INSERT INTO character_assessments (
    id_anak,
    id_assessor,
    assessor_type,
    assessment_date,
    week_number,
    month,
    year,
    notes,
    status
)
SELECT
    t.id_anak,
    @assessor_asuh,
    'anak_asuh',
    DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 20) DAY) AS assessment_date,
    WEEK(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 20) DAY), 1) AS week_number,
    MONTH(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 20) DAY)) AS month,
    YEAR(DATE_SUB(CURDATE(), INTERVAL MOD(t.seq, 20) DAY)) AS year,
    CONCAT('[SEED] Penilaian bulanan anak_asuh #', t.seq),
    'completed' AS status
FROM tmp_seed_anak t;

-- ---------------------------------------------------------
-- 6) Insert detail skor per indikator
-- ---------------------------------------------------------
INSERT INTO character_assessment_details (
    id_assessment,
    id_indicator,
    score
)
SELECT
    ca.id_assessment,
    ci.id_indicator,
    ((ca.id_assessment + ci.id_indicator) % 4) + 1 AS score
FROM character_assessments ca
JOIN character_indicators ci ON 1=1
WHERE ca.notes LIKE '[SEED]%'
ON DUPLICATE KEY UPDATE
    score = VALUES(score),
    updated_at = CURRENT_TIMESTAMP;

-- ---------------------------------------------------------
-- 7) Insert catatan kualitatif
-- ---------------------------------------------------------
INSERT INTO character_qualitative_notes (
    id_assessment,
    strengths,
    development_observed,
    areas_to_support,
    support_strategy
)
SELECT
    ca.id_assessment,
    'Anak menunjukkan kemajuan positif dalam kedisiplinan dan interaksi sosial.',
    'Terlihat peningkatan konsistensi perilaku selama periode observasi.',
    'Perlu pendampingan pada manajemen emosi dan fokus belajar.',
    'Lanjutkan pembiasaan rutin harian, penguatan positif, dan evaluasi mingguan bersama pengasuh/guru.'
FROM character_assessments ca
WHERE ca.notes LIKE '[SEED]%'
ON DUPLICATE KEY UPDATE
    strengths = VALUES(strengths),
    development_observed = VALUES(development_observed),
    areas_to_support = VALUES(areas_to_support),
    support_strategy = VALUES(support_strategy),
    updated_at = CURRENT_TIMESTAMP;

-- ---------------------------------------------------------
-- 8) Generate summary mingguan dari detail seed
-- ---------------------------------------------------------
INSERT INTO character_weekly_summary (
    id_anak,
    id_aspect,
    week_number,
    year,
    avg_score,
    assessor_type
)
SELECT
    ca.id_anak,
    ci.id_aspect,
    ca.week_number,
    ca.year,
    ROUND(AVG(cad.score), 2) AS avg_score,
    ca.assessor_type
FROM character_assessments ca
JOIN character_assessment_details cad ON cad.id_assessment = ca.id_assessment
JOIN character_indicators ci ON ci.id_indicator = cad.id_indicator
WHERE ca.notes LIKE '[SEED]%'
GROUP BY ca.id_anak, ci.id_aspect, ca.week_number, ca.year, ca.assessor_type
ON DUPLICATE KEY UPDATE
    avg_score = VALUES(avg_score),
    last_updated = CURRENT_TIMESTAMP;

-- ---------------------------------------------------------
-- 9) Generate summary bulanan dari detail seed
-- ---------------------------------------------------------
INSERT INTO character_monthly_summary (
    id_anak,
    id_aspect,
    month,
    year,
    avg_score,
    assessor_type
)
SELECT
    ca.id_anak,
    ci.id_aspect,
    ca.month,
    ca.year,
    ROUND(AVG(cad.score), 2) AS avg_score,
    ca.assessor_type
FROM character_assessments ca
JOIN character_assessment_details cad ON cad.id_assessment = ca.id_assessment
JOIN character_indicators ci ON ci.id_indicator = cad.id_indicator
WHERE ca.notes LIKE '[SEED]%'
GROUP BY ca.id_anak, ci.id_aspect, ca.month, ca.year, ca.assessor_type
ON DUPLICATE KEY UPDATE
    avg_score = VALUES(avg_score),
    last_updated = CURRENT_TIMESTAMP;

COMMIT;

-- ---------------------------------------------------------
-- 10) Cek hasil seed
-- ---------------------------------------------------------
SELECT 'anak_sample_terpilih' AS table_name, COUNT(*) AS total FROM tmp_seed_anak
UNION ALL
SELECT 'assessor_guru_terpilih', IFNULL(@assessor_guru, 0)
UNION ALL
SELECT 'assessor_asuh_terpilih', IFNULL(@assessor_asuh, 0)
UNION ALL
SELECT 'total_anak_di_db', COUNT(*) FROM anak
UNION ALL
SELECT 'total_users_di_db', COUNT(*) FROM users
UNION ALL
SELECT 'character_assessments' AS table_name, COUNT(*) AS total FROM character_assessments WHERE notes LIKE '[SEED]%'
UNION ALL
SELECT 'character_assessment_details', COUNT(*) FROM character_assessment_details cad
JOIN character_assessments ca ON ca.id_assessment = cad.id_assessment
WHERE ca.notes LIKE '[SEED]%'
UNION ALL
SELECT 'character_qualitative_notes', COUNT(*) FROM character_qualitative_notes cqn
JOIN character_assessments ca ON ca.id_assessment = cqn.id_assessment
WHERE ca.notes LIKE '[SEED]%';
