-- Database Performance Optimization: Adding Indexes
-- This file contains SQL statements to add indexes for better query performance

-- Indexes for anak table
ALTER TABLE anak ADD INDEX idx_nama_anak (nama_anak);
ALTER TABLE anak ADD INDEX idx_jenis_kelamin (jenis_kelamin);
ALTER TABLE anak ADD INDEX idx_pendidikan (pendidikan);
ALTER TABLE anak ADD INDEX idx_status_anak (status_anak);
ALTER TABLE anak ADD INDEX idx_tanggal_masuk (tanggal_masuk);
ALTER TABLE anak ADD INDEX idx_provinsi (id_provinsi);
ALTER TABLE anak ADD INDEX idx_kabupaten (id_kabupaten);
ALTER TABLE anak ADD INDEX idx_created_at (created_at);

-- Composite index for common queries
ALTER TABLE anak ADD INDEX idx_status_tanggal (status_anak, tanggal_masuk);

-- Indexes for pengurus table
ALTER TABLE pengurus ADD INDEX idx_nama_pengurus (nama_pengurus);
ALTER TABLE pengurus ADD INDEX idx_jabatan (jabatan);
ALTER TABLE pengurus ADD INDEX idx_created_at (created_at);

-- Indexes for users table
ALTER TABLE users ADD INDEX idx_username (username);
ALTER TABLE users ADD INDEX idx_role (role);
ALTER TABLE users ADD INDEX idx_created_at (created_at);

-- Indexes for user_logs table (if exists)
ALTER TABLE user_logs ADD INDEX idx_user_id (id_user);
ALTER TABLE user_logs ADD INDEX idx_activity (activity);
ALTER TABLE user_logs ADD INDEX idx_created_at (created_at);
ALTER TABLE user_logs ADD INDEX idx_user_activity (id_user, activity);

-- Indexes for provinsi and kabupaten tables
ALTER TABLE provinsi ADD INDEX idx_nama_provinsi (nama_provinsi);
ALTER TABLE kabupaten ADD INDEX idx_provinsi_kabupaten (id_provinsi, nama_kabupaten);

-- Indexes for pengaturan table
ALTER TABLE pengaturan ADD INDEX idx_nama_lksa (nama_lksa);

-- Indexes for laporan table (if exists)
ALTER TABLE laporan ADD INDEX idx_jenis_laporan (jenis_laporan);
ALTER TABLE laporan ADD INDEX idx_tahun (tahun);
ALTER TABLE laporan ADD INDEX idx_created_at (created_at);

-- Note: Run this SQL after backing up your database
-- These indexes will improve query performance for common operations
-- Monitor query performance after adding indexes and adjust as needed
