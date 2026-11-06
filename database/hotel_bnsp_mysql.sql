-- =========================================================================
-- SISTEM RESERVASI KAMAR HOTEL BNSP (LSP INFORMATIKA)
-- Skema: JUNIOR WEB DEVELOPER (FR.SKEMA-02-07 / FR.IA.02)
-- Asesi: Bima Garda Nusantara
-- Versi: 1.0.0 (02 November 2026)
-- Target RDBMS: MySQL 5.7+ / MariaDB 10.3+ (XAMPP Standard)
-- =========================================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

-- --------------------------------------------------------
-- Tabel 1: users (Autentikasi & Otorisasi 2 Role: Admin & Guest)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest',
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Akun Bawaan (Admin & Guest)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Resepsionis', 'admin@hotelbnsp.test', 'admin', '081234567890', '$2y$12$e0M2j6fGZ4K9mB.iV0P3xe1f2aU3wE6d9yQ5z8o7x4p1.r4k7jK7u', NOW(), NOW()),
(2, 'Andri Santosa', 'guest@hotelbnsp.test', 'guest', '081298765432', '$2y$12$e0M2j6fGZ4K9mB.iV0P3xe1f2aU3wE6d9yQ5z8o7x4p1.r4k7jK7u', NOW(), NOW());

-- --------------------------------------------------------
-- Tabel 2: rooms (Master Data Kamar, Foto, Video Preview)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 2,
  `bed_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1 Queen Bed',
  `size` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '32 m²',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facilities` json DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3 Data Tipe Kamar Wajib BNSP (Standar, Deluxe, Family)
INSERT INTO `rooms` (`id`, `code`, `name`, `tagline`, `price`, `capacity`, `bed_type`, `size`, `description`, `facilities`, `image_url`, `gallery`, `video_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'STD-01', 'Standar', 'Garden Pavilion Sanctuary', 500000.00, 2, '1 Queen Bed', '32 m²', 'Kamar bertema minimalis tropis dengan jendela panorama menghadap ke taman asri hotel. Didesain dengan material kayu jati hangat, seprai katun Mesir organik, serta pencahayaan hangat untuk kenyamanan istirahat maksimal.', '["Wi-Fi Kecepatan Tinggi (100 Mbps)", "Smart TV 43 Inci Full HD", "Rain Shower Panas & Dingin", "AC Inverter Hemat Energi", "Amenitas Mandi Herbal Organik", "Complimentary Artisan Tea & Coffee", "Safe Deposit Box Digital"]', '/assets/rooms/standar.jpg', '["/assets/rooms/standar.jpg", "/assets/rooms/deluxe.jpg"]', '/assets/rooms/preview_standar.mp4', 1, NOW(), NOW()),
(2, 'DLX-02', 'Deluxe', 'Premier Ocean Horizon Suite', 750000.00, 2, '1 King Bed', '48 m²', 'Suite elegan dengan balkon privat luas menghadap langsung ke laut dan lanskap kolam renang. Menawarkan bathtub marmer mewah, area lounge santai terpisah, dan soundbar bluetooth berkualitas studio.', '["Balkon Privat dengan Pemandangan Laut", "Bathtub Marmer Mewah & Jacuzzi Jet", "Wi-Fi Cepat 150 Mbps", "Smart TV 55 Inci 4K UHD", "Mesin Kopi Kapsul Nespresso", "Marshall Bluetooth Speaker", "Layanan Setrika & Laundry Express"]', '/assets/rooms/deluxe.jpg', '["/assets/rooms/deluxe.jpg", "/assets/rooms/standar.jpg"]', '/assets/rooms/preview_deluxe.mp4', 1, NOW(), NOW()),
(3, 'FML-03', 'Family', 'Royal Heritage Family Residence', 1000000.00, 4, '2 King Beds & Living Lounge', '78 m²', 'Kamar keluarga prestisius dengan dua ranjang utama King-Size, ruang tamu luas untuk berkumpul, dapur mini fungsional, dan dua kamar mandi lengkap. Pilihan sempurna untuk liburan keluarga atau eksekutif.', '["2 Ranjang King Bed Luas", "Ruang Tamu & Meja Makan Terpisah", "Pantry Mini & Microwave", "2 Kamar Mandi dengan Bathtub Terpisah", "Smart TV 65 Inci Bioskop Mini", "Area Bermain Ramah Anak", "Layanan Butler Pribadi Panggilan"]', '/assets/rooms/family.jpg', '["/assets/rooms/family.jpg", "/assets/rooms/deluxe.jpg"]', '/assets/rooms/preview_family.mp4', 1, NOW(), NOW());

-- --------------------------------------------------------
-- Tabel 3: reservations (Tabel Penyimpanan Data Pemesanan)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity_number` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_price` decimal(12,2) NOT NULL,
  `booking_date` date NOT NULL,
  `stay_duration` int(11) NOT NULL,
  `includes_breakfast` tinyint(1) NOT NULL DEFAULT 0,
  `breakfast_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(12,2) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_payment` decimal(12,2) NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservations_booking_code_unique` (`booking_code`),
  KEY `reservations_user_id_foreign` (`user_id`),
  KEY `reservations_room_id_foreign` (`room_id`),
  CONSTRAINT `reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contoh Data Transaksi Reservasi Awal (Sesuai Skema Contoh Uji BNSP)
INSERT INTO `reservations` (`id`, `booking_code`, `user_id`, `customer_name`, `gender`, `identity_number`, `room_id`, `room_type_name`, `room_price`, `booking_date`, `stay_duration`, `includes_breakfast`, `breakfast_fee`, `subtotal`, `discount_percent`, `discount_amount`, `total_payment`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'RSV-20261102-0001', 2, 'Andri Santosa', 'Laki-laki', '3275091210770004', 1, 'Standar', 500000.00, CURDATE(), 3, 1, 80000.00, 1500000.00, 0.00, 0.00, 1580000.00, 'confirmed', 'Pemesanan awal contoh evaluasi demonstrasi BNSP.', NOW(), NOW()),
(2, 'RSV-20261102-0002', NULL, 'Siti Rahmawati', 'Perempuan', '3578014508920001', 2, 'Deluxe', 750000.00, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 4, 1, 80000.00, 3000000.00, 10.00, 300000.00, 2780000.00, 'confirmed', 'Contoh pemesanan dengan diskon 10% (durasi > 3 hari).', NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

