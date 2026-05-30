-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2026 at 05:16 AM
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
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `cof_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('new','repair progress','quotation request','quotation approved','quotation cancelled','finish repair','cancel repair','close repair') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `started_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finished_date` date DEFAULT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fault_description` text COLLATE utf8mb4_unicode_ci,
  `accessories` text COLLATE utf8mb4_unicode_ci,
  `kondisi_unit` text COLLATE utf8mb4_unicode_ci,
  `repair_summary` text COLLATE utf8mb4_unicode_ci,
  `erf_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_cost` decimal(15,2) DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `cof_id`, `branch_id`, `contact`, `received_date`, `status`, `started_date`, `finished_date`, `customer_name`, `email`, `address`, `phone_number`, `brand`, `product_number`, `serial_number`, `nama_type`, `fault_description`, `accessories`, `kondisi_unit`, `repair_summary`, `erf_file`, `created_at`, `updated_at`, `total_cost`, `invoice_number`, `payment_status`) VALUES
(1, 'D20260500001', 4, 'Company', '2026-05-29', 'new', NULL, NULL, 'Edwin', 'edwin@gmail.com', 'knjvkdfznkjnv', '9348953898', 'Acer', '6004498', 'DVKDKSZFK983499', 'Acer Predator 13 A', 'CV VBXC', 'xfb', 'bjbhj', 'bbjhhb', NULL, '2026-05-29 10:04:11', '2026-05-29 10:04:11', NULL, NULL, 'unpaid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
