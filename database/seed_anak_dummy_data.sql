-- =========================================================
-- SEED DATA DUMMY TABEL ANAK
-- File: seed_anak_dummy_data.sql
-- =========================================================
-- Aman dijalankan berulang.
-- Data dummy diberi prefix [DUMMY] pada nama_anak.

START TRANSACTION;

-- Hapus data dummy lama agar tidak duplikat
DELETE FROM anak
WHERE nama_anak LIKE '[DUMMY]%';

-- Insert data dummy minimal (kompatibel dengan struktur anak yang wajib)
INSERT INTO anak (
    nama_anak,
    nik,
    jenis_kelamin,
    tempat_lahir,
    tanggal_lahir,
    pendidikan,
    status_anak,
    tanggal_masuk
)
VALUES
('[DUMMY] Ahmad Fauzi',     '3201010000000001', 'L', 'Bandung',    '2014-02-12', 'SD',  'Aktif',   '2022-07-10'),
('[DUMMY] Siti Aisyah',     '3201010000000002', 'P', 'Cimahi',     '2013-08-04', 'SMP', 'Aktif',   '2021-07-15'),
('[DUMMY] Rizky Ramadhan',  '3201010000000003', 'L', 'Garut',      '2011-11-23', 'SMA', 'Aktif',   '2020-08-01'),
('[DUMMY] Nurhaliza',       '3201010000000004', 'P', 'Tasikmalaya','2015-05-16', 'SD',  'Aktif',   '2023-01-12'),
('[DUMMY] Dimas Pratama',   '3201010000000005', 'L', 'Sukabumi',   '2012-09-09', 'SMP', 'Aktif',   '2021-02-20'),
('[DUMMY] Putri Maharani',  '3201010000000006', 'P', 'Cianjur',    '2010-12-01', 'SMA', 'Aktif',   '2019-07-03'),
('[DUMMY] Fajar Hidayat',   '3201010000000007', 'L', 'Bogor',      '2016-01-28', 'SD',  'Aktif',   '2024-03-01'),
('[DUMMY] Nabila Zahra',    '3201010000000008', 'P', 'Depok',      '2013-03-14', 'SMP', 'Aktif',   '2022-01-18'),
('[DUMMY] Irfan Maulana',   '3201010000000009', 'L', 'Bandung',    '2012-06-30', 'SMP', 'Aktif',   '2021-09-09'),
('[DUMMY] Salma Nurfadilah','3201010000000010', 'P', 'Majalengka', '2014-10-22', 'SD',  'Aktif',   '2022-11-11'),
('[DUMMY] Andi Saputra',    '3201010000000011', 'L', 'Subang',     '2011-04-07', 'SMA', 'Aktif',   '2020-01-25'),
('[DUMMY] Rahmawati',       '3201010000000012', 'P', 'Sumedang',   '2015-07-19', 'SD',  'Aktif',   '2023-06-05');

COMMIT;

-- Verifikasi
SELECT COUNT(*) AS total_dummy_anak
FROM anak
WHERE nama_anak LIKE '[DUMMY]%';
