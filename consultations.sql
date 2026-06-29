-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2026 at 05:21 AM
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
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_group` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_model` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','open','redirect_to_cs','cs_handling','escalated_to_kla','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cs_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `customer_id`, `subject`, `product_group`, `category`, `brand_model`, `description`, `status`, `notes`, `created_at`, `updated_at`, `cs_id`) VALUES
(1, 84, 'dfvsdzv', 'PSG', 'hardware', 'HP', 'dvdzfv', 'active', NULL, '2026-04-25 10:38:15', '2026-04-25 10:38:15', NULL),
(2, 84, 'dfvdzfv', 'IPG', 'consumable', 'HP', 'sdvcsazdv z', 'active', NULL, '2026-04-27 17:22:27', '2026-04-27 17:22:27', NULL),
(3, 84, 'dfvdzfv', 'IPG', 'consumable', 'HP', 'sdvcsazdv z', 'active', NULL, '2026-04-27 17:24:39', '2026-04-27 17:24:39', NULL),
(4, 84, 'dfvdzfv', 'IPG', 'consumable', 'HP', 'sdvcsazdv z', 'active', NULL, '2026-04-27 17:32:28', '2026-04-27 17:32:28', NULL),
(5, 84, 'dfb xfb fd', 'PSG', 'network', 'HP', 'fgb xf', 'active', NULL, '2026-05-08 08:55:27', '2026-05-08 08:55:27', NULL),
(6, 84, 'dfb xfb fd', 'PSG', 'network', 'HP', 'fgb xf', 'active', NULL, '2026-05-08 08:59:25', '2026-05-08 08:59:25', NULL),
(7, 84, 'battery health laptop', 'PSG', 'software', 'Asus', 'dfv dfv', 'active', NULL, '2026-05-09 04:16:30', '2026-05-09 04:16:30', NULL),
(8, 84, 'Ngehang', 'PSG', 'software', 'Asus', 'dfvdz', 'active', NULL, '2026-05-19 03:26:22', '2026-05-19 03:26:22', NULL),
(9, 84, 'Driver printer rusak', 'IPG', 'software', 'HP', 'x xfc', 'active', NULL, '2026-05-25 09:31:14', '2026-05-25 09:31:14', NULL),
(10, 84, 'kertas nyangkut di printer', 'IPG', 'hardware', 'Canon', 'dvdfz', 'active', NULL, '2026-05-26 19:55:07', '2026-05-26 19:55:07', NULL),
(11, 84, 'Printer error', 'IPG', 'consumable', 'HP', 'dfvdxfv', 'active', NULL, '2026-05-28 09:06:01', '2026-05-28 09:06:01', NULL),
(12, 84, 'bluetooth trouble', 'PSG', 'software', 'HP', 'dfvdszfb', 'active', NULL, '2026-05-29 03:48:41', '2026-05-29 03:48:41', NULL),
(13, 84, 'bluetooth trouble', 'PSG', 'software', 'Asus', 'dvdfv', 'active', NULL, '2026-05-29 07:59:49', '2026-05-29 07:59:49', NULL),
(14, 85, 'printer gamau ngeprint', 'IPG', 'consumable', 'Epson', 'zdkvmkzdfvm', 'active', NULL, '2026-06-12 07:58:50', '2026-06-12 07:58:50', NULL),
(15, 85, 'tinta warna gamau keluar', 'IPG', 'hardware', 'Brother', 'ffvdzv', 'active', NULL, '2026-06-12 16:54:58', '2026-06-12 16:54:58', NULL),
(16, 85, 'bluetooth aneh', 'PSG', 'software', 'HP', 'jdfnzvzvdxn', 'active', NULL, '2026-06-12 18:14:03', '2026-06-12 18:14:03', NULL),
(17, 85, 'printer gamau bunyi', 'IPG', 'hardware', 'Canon', 'dfvzdsfv', 'active', NULL, '2026-06-13 05:49:06', '2026-06-13 05:49:06', NULL),
(18, 85, 'printer berisik', 'IPG', 'hardware', 'Epson', 'dfgbsfrg', 'active', NULL, '2026-06-13 05:50:53', '2026-06-13 05:50:53', NULL),
(19, 85, 'laptop main2', 'PSG', 'consumable', 'Asus', 'dvzxdvaaaa', 'active', NULL, '2026-06-13 06:01:16', '2026-06-13 06:01:16', NULL),
(20, 85, 'laptop lucu', 'PSG', 'other', 'MSI', 'dfvdfz', 'active', NULL, '2026-06-13 16:25:13', '2026-06-13 16:25:13', NULL),
(21, 87, 'printer ngehang', 'IPG', 'other', 'HP', 'dfdfvs', 'active', NULL, '2026-06-15 08:59:43', '2026-06-15 08:59:43', NULL),
(22, 87, 'cover lcd kretek2', 'PSG', 'hardware', 'Acer', 'dvdzfv', 'active', NULL, '2026-06-15 14:11:33', '2026-06-15 14:11:33', NULL),
(23, 87, 'ngefreeze', 'PSG', 'software', 'Axioo', 'vc xcv', 'active', NULL, '2026-06-18 07:44:48', '2026-06-18 07:44:48', NULL),
(24, 87, 'battery laptop', 'PSG', 'consumable', 'Infinix', 'dfvlmdfkll', 'active', NULL, '2026-06-23 08:32:18', '2026-06-23 08:32:18', NULL),
(25, 87, 'Ngelag', 'PSG', 'software', 'MSI', 'dfvfxdv', 'active', NULL, '2026-06-24 07:56:50', '2026-06-24 07:56:50', NULL),
(26, 87, 'Ngefreeze', 'PSG', 'software', 'Asus', 'dsc', 'active', NULL, '2026-06-24 08:19:30', '2026-06-24 08:19:30', NULL),
(27, 87, 'hahaha', 'PSG', 'network', 'HP', 'Jjxkck', 'active', NULL, '2026-06-25 10:24:46', '2026-06-25 10:24:46', NULL),
(28, 87, 'lemot', 'PSG', 'consumable', 'Razer', 'fbfx', 'active', NULL, '2026-06-28 04:44:06', '2026-06-28 04:44:06', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_customer_id_status_index` (`customer_id`,`status`),
  ADD KEY `consultations_cs_id_foreign` (`cs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_cs_id_foreign` FOREIGN KEY (`cs_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `consultations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
