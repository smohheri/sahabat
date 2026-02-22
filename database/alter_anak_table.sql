-- Alter table anak to add document columns
ALTER TABLE `anak`
ADD COLUMN `file_kk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL AFTER `id_kabupaten`,
ADD COLUMN `file_akta` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL AFTER `file_kk`,
ADD COLUMN `file_pendukung` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL AFTER `file_akta`;

-- Update pendidikan enum to include 'PT' (Perguruan Tinggi)
-- Note: If pendidikan is currently enum, we need to alter it
ALTER TABLE `anak`
MODIFY COLUMN `pendidikan` enum('TK','SD','SMP','SMA','PT') COLLATE utf8mb4_general_ci DEFAULT NULL;

-- Add kategori column with Islamic categories
ALTER TABLE `anak`
ADD COLUMN `kategori` enum('Yatim','Piatu','Yatim Piatu','Dhuafa','Fakir dan Miskin','Ibnu Sabil','Laqith') COLLATE utf8mb4_general_ci DEFAULT NULL AFTER `status_anak`;
