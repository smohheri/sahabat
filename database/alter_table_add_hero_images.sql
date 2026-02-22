-- =====================================================
-- Create hero_images table for landing page hero section
-- =====================================================

CREATE TABLE IF NOT EXISTS `hero_images` (
  `id_hero` int NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `sort_order` int DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hero`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Insert default hero images (optional)
-- =====================================================
-- These will be replaced by uploaded images from admin panel

INSERT INTO `hero_images` (`image_name`, `title`, `subtitle`, `description`, `sort_order`, `is_active`) VALUES
('default_hero_1.jpg', 'LKSA Harapan Bangsa', 'Membentuk Generasi Unggul', 'Pendidikan dan pengasuhan anak yang berkualitas untuk masa depan yang lebih baik', 1, 1);

-- =====================================================
-- Verifikasi: Periksa tabel yang sudah dibuat
-- =====================================================
-- DESCRIBE hero_images;
-- SELECT * FROM hero_images;
