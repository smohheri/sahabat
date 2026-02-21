-- Menambahkan role 'operator' ke enum role di tabel users
ALTER TABLE users MODIFY COLUMN role ENUM('admin','petugas','dinas','operator') NOT NULL;
