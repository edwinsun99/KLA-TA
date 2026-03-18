-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2026 at 11:05 AM
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
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `open_at` time NOT NULL,
  `close_at` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `prefix`, `address`, `phone`, `latitude`, `longitude`, `open_at`, `close_at`, `created_at`, `updated_at`) VALUES
(1, 'Semarang', 'A', 'Ruko Mataram Plaza, D8-9, Jagalan, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50613', '0895616797777', '0.0000000', '0.0000000', '00:00:00', '00:00:00', '2026-03-18 10:08:48', '2026-03-18 10:13:44'),
(2, 'Slawi', 'B', 'Jl. Flores Baru, Langon, Kudaile, Kec. Slawi, Kabupaten Tegal, Jawa Tengah 52413', '085185068679', '0.0000000', '0.0000000', '00:00:00', '00:00:00', '2026-03-18 10:08:48', '2026-03-18 10:13:44'),
(3, 'Tegal', 'C', 'Jl. Sultan Agung No.49, Kejambon, Kec. Tegal Tim., Kota Tegal, Jawa Tengah', '085165867970', '0.0000000', '0.0000000', '00:00:00', '00:00:00', '2026-03-18 10:08:48', '2026-03-18 10:13:44'),
(4, 'Pekalongan', 'D', 'Jl. Imam Bonjol No.9, Kergon, Kec. Pekalongan Bar., Kota Pekalongan, Jawa Tengah 51113', '085724968191', '0.0000000', '0.0000000', '00:00:00', '00:00:00', '2026-03-18 10:08:48', '2026-03-18 10:13:44'),
(5, 'Kediri', 'E', 'Jl. Pahlawan Kusuma Bangsa No.21, Banjaran, Kec. Kota, Kota Kediri, Jawa Timur 64129', '08986561999', '0.0000000', '0.0000000', '00:00:00', '00:00:00', '2026-03-18 10:08:48', '2026-03-18 10:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `cof_counters`
--

CREATE TABLE `cof_counters` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `current_number` int NOT NULL DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cof_counters`
--

INSERT INTO `cof_counters` (`id`, `branch_id`, `current_number`, `updated_at`) VALUES
(1, 1, 0, '2026-03-18 10:11:40'),
(2, 2, 0, '2026-03-18 10:11:40'),
(3, 3, 0, '2026-03-18 10:11:40'),
(4, 4, 0, '2026-03-18 10:11:40'),
(5, 5, 0, '2026-03-18 10:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lognote`
--

CREATE TABLE `lognote` (
  `id` bigint UNSIGNED NOT NULL,
  `cof_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logdesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_02_27_231034_create_branches_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2026_02_27_231240_create_cof_counters_table', 1),
(7, '2026_02_27_231858_create_products_table', 1),
(8, '2026_02_27_232012_create_lognote_table', 1),
(9, '2026_02_27_232037_create_services_table', 1),
(10, '2026_02_28_003813_add_finance_fields_to_services_table', 2),
(11, '2026_03_07_221102_create_spareparts_table', 2),
(12, '2026_03_13_104724_drop_spareparts_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `pn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `pn`, `nt`, `created_at`, `updated_at`) VALUES
(1, 'E7071A5', 'Microsoft Surface Laptop 13 W', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(2, '6004498', 'Acer Predator 13 A', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(3, '1S335CV', 'Dell Alienware 15 O', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(4, '1O39401', 'ASUS ROG 13 W', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(5, 'GA7430C', 'Acer Spin 15 X', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(6, 'S90370Z', 'Huawei MateBook 15 S', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(7, '159163D', 'Infinix Inbook 14 C', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(8, 'SA571TH', 'Microsoft Surface Laptop 13 S', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(9, '00954JJ', 'Acer Swift 16 H', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(10, '84457AO', 'Xiaomi Xiaomi Book 15 S', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(11, 'CY09108', 'Microsoft Surface Pro 13 W', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(12, 'U919416', 'ASUS Vivobook 16 R', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(13, 'X61898V', 'Infinix Inbook 16 V', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(14, '6C90711', 'Razer Blade 15 L', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(15, '88016Z6', 'Huawei MateBook 16 M', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(16, 'W88770P', 'Lenovo ThinkPad 16 X', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(17, '8684878', 'Razer Blade 14 A', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(18, 'DG785PY', 'Microsoft Surface Pro 14 Y', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(19, 'RJ948GF', 'Dell Latitude 15 T', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(20, '937435G', 'Infinix Inbook 16 Z', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(21, 'G59593P', 'HP Pavilion 13 E', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(22, '9S70938', 'Acer Predator 16 J', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(23, '78793M4', 'MSI Modern 13 P', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(24, '19283W7', 'Razer Blade 14 F', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(25, 'RA43932', 'Lenovo ThinkPad 15 A', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(26, 'YD190H7', 'Xiaomi Xiaomi Book 13 P', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(27, '0H585V6', 'Lenovo Legion 15 N', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(28, 'G9984Q0', 'Acer Spin 15 Z', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(29, 'WL3939F', 'Razer Blade 14 T', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(30, 'T5127RZ', 'MSI Summit 13 A', '2026-03-18 10:11:40', '2026-03-18 10:11:40'),
(31, '19619DA', 'ASUS Vivobook 14 X', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(32, 'O6193WM', 'Samsung Chromebook 15 P', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(33, 'M066251', 'Acer Swift 13 X', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(34, '1V33201', 'ASUS ROG 13 K', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(35, '063314F', 'Microsoft Surface Laptop 14 Z', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(36, 'VJ7052Q', 'Acer Swift 13 D', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(37, 'S4975SK', 'Razer Blade 14 A', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(38, 'LJ7428F', 'HP Pavilion 13 Q', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(39, '4J675ZU', 'Razer Blade 16 G', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(40, '98123V0', 'Infinix Inbook 16 W', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(41, 'B8801MH', 'Razer Blade 13 A', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(42, 'N1466U7', 'Lenovo ThinkPad 16 U', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(43, '5E550TW', 'Xiaomi RedmiBook 15 P', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(44, 'W2468LG', 'Samsung Galaxy Book 13 W', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(45, '54897K1', 'HP Pavilion 16 B', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(46, 'B1586VE', 'MSI Raider 16 B', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(47, 'G762968', 'Infinix Inbook 15 P', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(48, '3Z24096', 'Razer Blade 13 W', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(49, 'M0640N2', 'Dell XPS 13 C', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(50, '670947E', 'Infinix Inbook 15 M', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(51, 'OP2132E', 'Lenovo Yoga 13 W', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(52, 'R87415C', 'Huawei MateBook 15 R', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(53, 'GO3252E', 'Huawei MateBook 15 I', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(54, 'IT97849', 'Razer Blade 13 P', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(55, '34045VD', 'ASUS Zenbook 16 X', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(56, 'Q7218AS', 'Razer Blade 16 A', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(57, 'XL74736', 'Samsung Galaxy Book 16 A', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(58, 'J3387QL', 'Microsoft Surface Laptop 15 Z', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(59, '4X301L9', 'Infinix Inbook 13 U', '2026-03-18 10:13:44', '2026-03-18 10:13:44'),
(60, '3575566', 'Lenovo ThinkPad 14 T', '2026-03-18 10:13:44', '2026-03-18 10:13:44');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `profile_photo`, `password`, `role`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'manager', 'manager@infokom.putra.com', NULL, '$2y$12$20g7pC5j8F/rzFhQJdeKDOcjwuR92SA9ulv9iOWX9geg1QQgOCzXC', 'MASTER', NULL, '2026-03-18 10:31:57', '2026-03-18 10:31:57'),
(2, 'maulida', 'maulida@infokom.putra.com', NULL, '$2y$12$CRV0mn4XqJITubxdnwBUoeOOBU.kSQ.2s4wzVNKKthr5freeVnz9C', 'CM', NULL, '2026-03-18 10:31:58', '2026-03-18 10:31:58'),
(3, 'marvin03', 'fidel.jakubowski@example.net', NULL, '$2y$12$uUxDfyPE1SRw4H6LZFeCqeLUOjZNHNUuut3vN8rQl3XdOkuk4sIUu', 'CE', 1, '2026-03-18 10:31:58', '2026-03-18 10:31:58'),
(4, 'maud97', 'uframi@example.com', NULL, '$2y$12$ry/Nedezz.RlM2Mj3MpA..C5B4o1TxcJH0AfDpCKbQNkcU0T8DB9a', 'CS', 2, '2026-03-18 10:31:58', '2026-03-18 10:31:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cof_counters`
--
ALTER TABLE `cof_counters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cof_counters_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lognote`
--
ALTER TABLE `lognote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_pn_unique` (`pn`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_branch_id_foreign` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cof_counters`
--
ALTER TABLE `cof_counters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lognote`
--
ALTER TABLE `lognote`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cof_counters`
--
ALTER TABLE `cof_counters`
  ADD CONSTRAINT `cof_counters_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
