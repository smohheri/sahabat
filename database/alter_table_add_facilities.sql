-- Add facilities table for dynamic landing page facilities section
-- Date: 2024

CREATE TABLE IF NOT EXISTS `fasilitas` (
  `id_fasilitas` int NOT NULL AUTO_INCREMENT,
  `nama_fasilitas` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sort_order` int DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_fasilitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default facilities data
INSERT INTO `fasilitas` (`nama_fasilitas`, `deskripsi`, `gambar`, `icon`, `sort_order`, `is_active`) VALUES
('Asrama', 'Tempat tinggal yang nyaman dan aman untuk anak-anak dengan fasilitas lengkap.', NULL, 'fa-home', 1, 1),
('Ruang Belajar', 'Fasilitas belajar modern dengan peralatan lengkap untuk mendukung pendidikan anak.', NULL, 'fa-book', 2, 1),
('Kantin', 'Area makan yang bersih dan sehat dengan menu bergizi untuk kebutuhan nutrisi anak.', NULL, 'fa-utensils', 3, 1),
('Lapangan Olahraga', 'Fasilitas olahraga lengkap untuk mengembangkan kesehatan fisik dan mental anak.', NULL, 'fa-futbol', 4, 1),
('Klinik Kesehatan', 'Pelayanan kesehatan 24 jam dengan tenaga medis profesional untuk kesehatan anak.', NULL, 'fa-heartbeat', 5, 1),
('Perpustakaan', 'Koleksi buku dan bahan bacaan lengkap untuk meningkatkan pengetahuan dan kreativitas.', NULL, 'fa-book-open', 6, 1),
('Ruang Ibadah', 'Tempat ibadah yang tenang dan nyaman untuk membentuk karakter spiritual anak.', NULL, 'fa-mosque', 7, 1),
('Taman Bermain', 'Area bermain yang aman dan menyenangkan untuk mengembangkan kreativitas dan sosialisasi.', NULL, 'fa-child', 8, 1);
