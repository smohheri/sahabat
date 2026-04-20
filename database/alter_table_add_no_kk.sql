-- Add no_kk column to anak table
ALTER TABLE `anak`
ADD COLUMN `no_kk` VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL AFTER `nik`;
