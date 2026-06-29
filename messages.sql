-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2026 at 05:22 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kla_cof1`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `consultation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `sender_type` enum('customer','ai','cs') COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `created_at`, `updated_at`, `consultation_id`, `user_id`, `sender_type`, `body`) VALUES
(1, '2026-06-12 17:05:51', '2026-06-12 17:05:51', 15, 85, 'customer', 'haii'),
(2, '2026-06-12 17:09:53', '2026-06-12 17:09:53', 15, 85, 'customer', 'haii'),
(3, '2026-06-12 17:28:28', '2026-06-12 17:28:28', 15, 85, 'customer', 'ahii'),
(4, '2026-06-12 18:12:34', '2026-06-12 18:12:34', 15, 85, 'customer', 'haii'),
(5, '2026-06-12 18:12:40', '2026-06-12 18:12:40', 15, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(6, '2026-06-12 18:14:15', '2026-06-12 18:14:15', 16, 85, 'customer', 'halo kak bisa bantu saya'),
(7, '2026-06-12 18:14:19', '2026-06-12 18:14:19', 16, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(8, '2026-06-13 05:49:16', '2026-06-13 05:49:16', 17, 85, 'customer', 'haii'),
(9, '2026-06-13 05:49:21', '2026-06-13 05:49:21', 17, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(10, '2026-06-13 05:50:09', '2026-06-13 05:50:09', 17, 85, 'customer', 'ya'),
(11, '2026-06-13 05:50:10', '2026-06-13 05:50:10', 17, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(12, '2026-06-13 05:51:44', '2026-06-13 05:51:44', 18, 85, 'customer', 'jadi awalnya printer saya oke oke aja tp setelah pemakaian 3 bulan tiba2 jadi berisik'),
(13, '2026-06-13 05:51:46', '2026-06-13 05:51:46', 18, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(14, '2026-06-13 06:00:09', '2026-06-13 06:00:09', 18, 85, 'customer', 'aii'),
(15, '2026-06-13 06:00:12', '2026-06-13 06:00:12', 18, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(16, '2026-06-13 06:01:22', '2026-06-13 06:01:22', 19, 85, 'customer', 'haiiii'),
(17, '2026-06-13 06:01:24', '2026-06-13 06:01:24', 19, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(18, '2026-06-13 16:25:18', '2026-06-13 16:25:18', 20, 85, 'customer', 'yaaa'),
(19, '2026-06-13 16:25:22', '2026-06-13 16:25:22', 20, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(20, '2026-06-13 16:30:51', '2026-06-13 16:30:51', 20, 85, 'customer', 'haiii'),
(21, '2026-06-13 16:30:54', '2026-06-13 16:30:54', 20, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(22, '2026-06-15 08:59:48', '2026-06-15 08:59:48', 21, 87, 'customer', 'haiii'),
(23, '2026-06-15 08:59:49', '2026-06-15 08:59:49', 21, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(24, '2026-06-15 09:02:57', '2026-06-15 09:02:57', 21, 87, 'customer', 'halooo'),
(25, '2026-06-15 09:02:58', '2026-06-15 09:02:58', 21, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(26, '2026-06-15 09:11:53', '2026-06-15 09:11:53', 21, 87, 'customer', 'yaaa'),
(27, '2026-06-15 09:11:53', '2026-06-15 09:11:53', 21, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(28, '2026-06-15 14:11:38', '2026-06-15 14:11:38', 22, 87, 'customer', 'haiii'),
(29, '2026-06-15 14:11:39', '2026-06-15 14:11:39', 22, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(30, '2026-06-15 14:19:33', '2026-06-15 14:19:33', 22, 87, 'customer', 'haii'),
(31, '2026-06-15 14:19:34', '2026-06-15 14:19:34', 22, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(32, '2026-06-15 16:08:24', '2026-06-15 16:08:24', 22, 87, 'customer', 'haii'),
(33, '2026-06-15 16:08:25', '2026-06-15 16:08:25', 22, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(34, '2026-06-18 07:44:56', '2026-06-18 07:44:56', 23, 87, 'customer', 'haii'),
(35, '2026-06-18 07:44:57', '2026-06-18 07:44:57', 23, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(36, '2026-06-23 08:32:24', '2026-06-23 08:32:24', 24, 87, 'customer', 'haii'),
(37, '2026-06-23 08:32:25', '2026-06-23 08:32:25', 24, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(38, '2026-06-24 07:56:57', '2026-06-24 07:56:57', 25, 87, 'customer', 'hai'),
(39, '2026-06-24 07:56:58', '2026-06-24 07:56:58', 25, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(40, '2026-06-24 08:19:44', '2026-06-24 08:19:44', 26, 87, 'customer', 'hai'),
(41, '2026-06-24 08:19:44', '2026-06-24 08:19:44', 26, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(42, '2026-06-24 08:21:03', '2026-06-24 08:21:03', 26, 87, 'customer', 'jhj'),
(43, '2026-06-24 08:21:04', '2026-06-24 08:21:04', 26, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.'),
(44, '2026-06-25 10:24:57', '2026-06-25 10:24:57', 27, 87, 'customer', 'jfjck'),
(45, '2026-06-25 10:24:58', '2026-06-25 10:24:58', 27, NULL, 'ai', 'Maaf, saya sedang tidak dapat merespons. Silakan coba lagi.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_consultation_id_foreign` (`consultation_id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
