-- Mengubah nama role 'guru' menjadi 'pengajar' di tabel users
-- Aman untuk data existing: tambahkan enum sementara, migrasikan data, lalu finalisasi enum

-- 1) Tambahkan enum sementara agar guru dan pengajar sama-sama valid
ALTER TABLE users
MODIFY COLUMN role ENUM('admin','petugas','dinas','operator','guru','pengajar') NOT NULL;

-- 2) Migrasi data lama dari guru -> pengajar
UPDATE users
SET role = 'pengajar'
WHERE role = 'guru';

-- 3) Finalisasi enum (hapus guru, sisakan pengajar)
ALTER TABLE users
MODIFY COLUMN role ENUM('admin','petugas','dinas','operator','pengajar') NOT NULL;
