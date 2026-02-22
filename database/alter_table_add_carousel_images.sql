-- =====================================================
-- Create carousel_images table for landing page carousel
-- =====================================================

CREATE TABLE IF NOT EXISTS `carousel_images` (
  `id_carousel` int NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `sort_order` int DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carousel`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Insert default carousel images (optional)
-- =====================================================
-- These will be replaced by uploaded images from admin panel

INSERT INTO `carousel_images` (`image_name`, `title`, `description`, `sort_order`, `is_active`) VALUES
('default_carousel_1.jpg', 'Pendidikan untuk Masa Depan', 'Mendorong anak-anak untuk meraih impian mereka', 1, 1),
('default_carousel_2.jpg', 'Perkembangan Holistik', 'Membantu anak berkembang secara fisik dan mental', 2, 1),
('default_carousel_3.jpg', 'Belajar Bersama', 'Menciptakan lingkungan belajar yang menyenangkan', 3, 1),
('default_carousel_4.jpg', 'Kegiatan Sosial', 'Membangun keterampilan sosial dan kreativitas', 4, 1);

-- =====================================================
-- Verifikasi: Periksa tabel yang sudah dibuat
-- =====================================================
-- DESCRIBE carousel_images;
-- SELECT * FROM carousel_images;
