-- Add nama_sekolah and biaya_spp columns to anak table
ALTER TABLE `anak` ADD COLUMN `nama_sekolah` VARCHAR(255) NULL AFTER `status_tinggal`;
ALTER TABLE `anak` ADD COLUMN `biaya_spp` DECIMAL(15,2) NULL AFTER `nama_sekolah`;
