-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 28, 2026 at 03:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` text,
  `group` varchar(30) NOT NULL DEFAULT 'general',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'hotel_name', 'Andelir ', 'hotel', NULL, '2026-09-22 09:30:49'),
(2, 'hotel_address', 'Jl. Admodirono No 12, Semarang, Jawa Tengah', 'hotel', NULL, '2026-09-22 09:30:49'),
(3, 'hotel_phone', '(024) 123-4567', 'hotel', NULL, '2026-09-22 09:30:49'),
(4, 'hotel_email', 'info@andelirsemarang.org', 'hotel', NULL, '2026-09-22 09:30:49'),
(5, 'hotel_logo', '', 'hotel', NULL, NULL),
(6, 'tax_percentage', '10', 'tax', NULL, NULL),
(7, 'service_percentage', '5', 'tax', NULL, NULL),
(8, 'currency', 'IDR', 'preferences', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(3, 2, 'user', '2026-09-21 05:25:31'),
(4, 2, 'admin', '2026-09-21 05:26:35'),
(5, 10, 'manager', '2026-09-22 16:46:58'),
(6, 11, 'front_office', '2026-09-22 16:46:58'),
(7, 12, 'housekeeping', '2026-09-22 16:46:58'),
(8, 13, 'purchasing', '2026-09-22 16:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `auth_identities`
--

CREATE TABLE `auth_identities` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `secret` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `secret2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text COLLATE utf8mb4_general_ci,
  `force_reset` tinyint(1) NOT NULL DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_identities`
--

INSERT INTO `auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(2, 2, 'email_password', NULL, 'admin@hotel.com', '$2y$12$BfVkKX/tzD2xSSD9uIsOr.DKZ6X1F7IXKdduNTs.1.X/mv2Tmzzym', NULL, NULL, 0, '2026-09-23 06:26:47', '2026-09-21 05:25:31', '2026-09-23 06:26:47'),
(3, 10, 'email_password', NULL, 'manager1@hotel.test', '$2y$12$X3tD5UAcpc315juYVawu9uTSw7c27Ju9m874PHHVMc29qHx/Z/kTe', NULL, NULL, 0, '2026-09-22 10:06:08', '2026-09-22 16:46:58', '2026-09-22 10:06:08'),
(4, 11, 'email_password', NULL, 'fo1@hotel.test', '$2y$12$cZfH/Ghyk2bDVnW0f/mpSeh1IPvd18m.lIDL1OhFzQXVp8tU9SqAC', NULL, NULL, 0, '2026-09-22 10:07:16', '2026-09-22 16:46:58', '2026-09-22 10:07:16'),
(5, 12, 'email_password', NULL, 'hk1@hotel.test', '$2y$12$h0dldpX.AykP1x/EEg6yIuqkAU76zgNIqgmKYcx/R9ea9ygKyZj6a', NULL, NULL, 0, '2026-09-22 10:10:35', '2026-09-22 16:46:58', '2026-09-22 10:10:35'),
(6, 13, 'email_password', NULL, 'purchasing1@hotel.test', '$2y$12$gGzlK9A4bpuNNPWcMqhSdullyqqhLsaosuhgFh4vHziWOZHp/2kSO', NULL, NULL, 0, '2026-09-22 10:07:52', '2026-09-22 16:46:58', '2026-09-22 10:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `user_agent`, `id_type`, `identifier`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', NULL, '2026-09-21 04:58:18', 0),
(2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', NULL, '2026-09-21 05:06:50', 0),
(3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 05:27:38', 1),
(4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 06:11:42', 1),
(5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'email_password', 'admin@hotel.com', 2, '2026-09-21 06:12:35', 1),
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 06:16:01', 1),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 06:46:08', 1),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 07:58:34', 1),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-21 08:01:41', 1),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-22 05:32:57', 1),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-22 09:36:40', 1),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'manager1@hotel.test', NULL, '2026-09-22 09:54:32', 0),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-22 09:55:48', 1),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'manager1@hotel.test', 10, '2026-09-22 10:03:04', 1),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'hk1@hotel.test', 12, '2026-09-22 10:03:49', 1),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'fo1@hotel.test', 11, '2026-09-22 10:04:25', 1),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'purchasing1@hotel.test', 13, '2026-09-22 10:04:56', 1),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'manager1@hotel.test', 10, '2026-09-22 10:06:08', 1),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'hk1@hotel.test', 12, '2026-09-22 10:06:44', 1),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'fo1@hotel.test', 11, '2026-09-22 10:07:16', 1),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'purchasing1@hotel.test', 13, '2026-09-22 10:07:52', 1),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'hk1@hotel.test', 12, '2026-09-22 10:10:35', 1),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-23 03:51:53', 1),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'email_password', 'admin@hotel.com', 2, '2026-09-23 06:26:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions_users`
--

CREATE TABLE `auth_permissions_users` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_remember_tokens`
--

CREATE TABLE `auth_remember_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_token_logins`
--

CREATE TABLE `auth_token_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folios`
--

CREATE TABLE `folios` (
  `id` int UNSIGNED NOT NULL,
  `folio_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation_id` int UNSIGNED DEFAULT NULL,
  `guest_id` int UNSIGNED NOT NULL,
  `status` enum('open','closed','void') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `total_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folio_items`
--

CREATE TABLE `folio_items` (
  `id` int UNSIGNED NOT NULL,
  `folio_id` int UNSIGNED NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '1',
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` int UNSIGNED NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'No KTP/Paspor',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `full_name`, `id_number`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Karimah Dalima Hariyah', '8839659838574436', '(+62) 419 3657 8292', 'pratiwi.dagel@example.net', 'Jln. Raden Saleh No. 968, Lubuklinggau 37486, Sulut', '2026-08-16 10:22:06', '2026-09-22 09:20:52'),
(2, 'Queen Sudiati S.T.', '4364159341616269', '(+62) 786 8876 1122', 'wwijayanti@example.org', 'Jr. Diponegoro No. 26, Solok 89738, Kaltara', '2026-06-21 14:29:59', '2026-09-22 09:20:52'),
(3, 'Marwata Samosir', '1304414712923960', '021 9795 2474', 'lala77@example.org', 'Ds. Sukabumi No. 550, Bandung 73904, Jateng', '2026-03-25 02:32:24', '2026-09-22 09:20:52'),
(4, 'Laila Diah Halimah S.Kom', '0647610472219517', '0785 8394 2916', 'belinda.yuniar@example.org', 'Ds. Sampangan No. 720, Bogor 92529, DIY', '2026-09-16 09:48:29', '2026-09-22 09:20:52'),
(5, 'Wahyu Ramadan', '8366841122416315', '0700 7952 0366', 'zalindra40@example.org', 'Kpg. Pintu Besar Selatan No. 813, Yogyakarta 63649, Maluku', '2026-04-08 03:59:49', '2026-09-22 09:20:52'),
(6, 'Karen Agustina', '0182546237902689', '024 5430 2036', 'humaira88@example.com', 'Gg. Kalimalang No. 828, Sawahlunto 27477, Papua', '2026-06-20 14:22:20', '2026-09-22 09:20:52'),
(7, 'Daruna Cayadi Megantara', '8856628620943390', '(+62) 877 0848 5643', 'ana05@example.com', 'Ki. Ikan No. 806, Kotamobagu 73986, Kalteng', '2026-05-02 01:56:17', '2026-09-22 09:20:52'),
(8, 'Karta Widodo S.Ked', '0897478683686051', '(+62) 766 6976 441', 'syahrini.padmasari@example.com', 'Kpg. Baha No. 696, Gorontalo 36130, NTT', '2026-05-03 03:11:03', '2026-09-22 09:20:52'),
(9, 'Kasim Wibisono M.TI.', '1582624152004945', '(+62) 559 3108 5461', 'bakijan89@example.org', 'Ki. Pahlawan No. 249, Lhokseumawe 95624, Kalbar', '2026-06-04 14:10:05', '2026-09-22 09:20:52'),
(10, 'Karimah Pia Lailasari', '0711676715041610', '0694 4320 412', 'putri.pertiwi@example.com', 'Psr. Bakau Griya Utama No. 677, Tarakan 99217, Kepri', '2026-04-09 21:19:46', '2026-09-22 09:20:52'),
(11, 'Restu Pratiwi', '8832680351139507', '0858 6725 6388', 'ihidayanto@example.net', 'Kpg. Baha No. 10, Bontang 95858, Kalsel', '2026-05-25 22:01:02', '2026-09-22 09:20:52'),
(12, 'Winda Farida S.Pt', '0763244836951272', '0659 4979 6471', 'tantri26@example.net', 'Jr. W.R. Supratman No. 2, Tual 71553, Sumsel', '2026-06-11 22:07:52', '2026-09-22 09:20:52'),
(13, 'Nasab Kambali Permadi', '0784575431954084', '0850 419 933', 'uchita05@example.org', 'Ds. Cemara No. 518, Salatiga 65565, Sulbar', '2026-07-31 14:53:55', '2026-09-22 09:20:52'),
(14, 'Gambira Vinsen Pradana S.Kom', '9015066203191887', '0671 4989 6777', 'ade66@example.org', 'Ds. Samanhudi No. 113, Ternate 76859, Riau', '2026-08-01 15:31:16', '2026-09-22 09:20:52'),
(15, 'Murti Tarihoran', '4469471670882404', '0700 1639 2793', 'puspa.novitasari@example.org', 'Jr. Flora No. 536, Administrasi Jakarta Pusat 94837, Papua', '2026-07-06 11:22:24', '2026-09-22 09:20:52'),
(16, 'Bahuwarna Suwarno', '3644104183822518', '(+62) 311 7633 2980', 'qnurdiyanti@example.com', 'Jln. Abang No. 944, Denpasar 62149, Riau', '2026-07-19 21:05:16', '2026-09-22 09:20:52'),
(17, 'Nadia Wulandari', '7893448812140140', '0282 8417 9441', 'pertiwi.hadi@example.net', 'Psr. Bagis Utama No. 174, Bitung 53291, Riau', '2026-06-01 04:06:24', '2026-09-22 09:20:52'),
(18, 'Warsita Lulut Nugroho S.T.', '8811231538410948', '(+62) 458 9012 411', 'muni79@example.com', 'Ki. Nakula No. 772, Sukabumi 44514, Jabar', '2026-08-14 08:21:37', '2026-09-22 09:20:52'),
(19, 'Jagapati Daru Sihotang', '2559790275635425', '0674 4055 897', 'cfirgantoro@example.net', 'Ds. M.T. Haryono No. 228, Subulussalam 48890, Sultra', '2026-05-24 14:51:18', '2026-09-22 09:20:52'),
(20, 'Ratna Mayasari', '1809323418857628', '0817 4258 534', 'prabowo.wulan@example.org', 'Ds. Tentara Pelajar No. 499, Cirebon 49352, Bengkulu', '2026-05-28 22:56:50', '2026-09-22 09:20:52'),
(21, 'Rika Salsabila Pudjiastuti S.H.', '2847048148551109', '0383 1367 0644', 'tirtayasa.agustina@example.net', 'Ki. S. Parman No. 400, Kupang 31185, Kaltara', '2026-06-03 01:01:41', '2026-09-22 09:20:52'),
(22, 'Humaira Aisyah Zulaika M.Pd', '9776058722314027', '(+62) 21 6565 860', 'rahimah.cahyanto@example.com', 'Psr. Tentara Pelajar No. 207, Dumai 67015, Sumbar', '2026-08-15 08:01:45', '2026-09-22 09:20:52'),
(23, 'Rahmat Simbolon S.Pd', '4974834476570522', '0868 9925 0805', 'lili50@example.org', 'Ds. Sam Ratulangi No. 135, Kotamobagu 59759, Kalbar', '2026-08-28 11:32:12', '2026-09-22 09:20:52'),
(24, 'Kasusra Budiyanto', '9924797362834191', '(+62) 26 9350 131', 'rahayu59@example.org', 'Ki. Jend. A. Yani No. 253, Payakumbuh 10177, Jateng', '2026-05-01 06:09:34', '2026-09-22 09:20:52'),
(25, 'Sadina Pertiwi S.Sos', '6490714068721251', '0777 9019 0408', 'aisyah.andriani@example.org', 'Ki. Sadang Serang No. 386, Pagar Alam 42220, Kalsel', '2026-07-23 16:38:45', '2026-09-22 09:20:52'),
(26, 'Jarwadi Rajasa S.Kom', '4943034772078809', '0501 6606 9977', 'zamira.rahmawati@example.com', 'Kpg. Bank Dagang Negara No. 482, Palopo 68506, Kaltim', '2026-05-07 13:19:23', '2026-09-22 09:20:52'),
(27, 'Karma Maheswara', '1754319095220772', '024 4669 7655', 'wpratiwi@example.com', 'Kpg. Untung Suropati No. 334, Kupang 31002, NTB', '2026-08-02 04:22:20', '2026-09-22 09:20:52'),
(28, 'Mustofa Hutapea S.Farm', '4163718171921524', '0331 0760 0970', 'galih34@example.org', 'Gg. Dr. Junjunan No. 399, Pekanbaru 61846, Riau', '2026-07-30 13:06:12', '2026-09-22 09:20:52'),
(29, 'Atmaja Prayoga', '3139173639880517', '0611 7236 4569', 'uwais.puji@example.com', 'Psr. Jamika No. 46, Sorong 45690, Jambi', '2026-05-23 09:28:02', '2026-09-22 09:20:52'),
(30, 'Nurul Aryani M.Farm', '3169462741630729', '0921 5221 744', 'cmaryati@example.com', 'Jr. Bawal No. 45, Batam 72684, Aceh', '2026-08-26 15:52:06', '2026-09-22 09:20:52'),
(31, 'Ghaliyati Handayani S.Pd', '7763444051219143', '0741 7602 6463', 'darijan.utami@example.net', 'Ds. Kartini No. 423, Ambon 49331, Sumut', '2026-09-06 03:19:56', '2026-09-22 09:20:52'),
(32, 'Ellis Suci Nasyiah', '6617079987660478', '(+62) 865 2624 8658', 'lidya26@example.org', 'Gg. S. Parman No. 986, Medan 62108, Bengkulu', '2026-07-08 07:42:03', '2026-09-22 09:20:52'),
(33, 'Ayu Halimah S.T.', '0856418624996523', '0576 8157 277', 'wani.rahayu@example.com', 'Ki. Otto No. 924, Prabumulih 62865, Kaltara', '2026-04-15 08:25:06', '2026-09-22 09:20:52'),
(34, 'Uchita Usyi Anggraini', '3337967007544277', '0819 7404 465', 'uriyanti@example.com', 'Ki. Madiun No. 421, Kendari 99254, Papua', '2026-08-08 22:28:34', '2026-09-22 09:20:52'),
(35, 'Rangga Gunawan M.Kom.', '5344285575860912', '0239 4187 5290', 'isamosir@example.org', 'Ki. Banal No. 611, Palu 27041, Aceh', '2026-05-30 00:11:55', '2026-09-22 09:20:52'),
(36, 'Hadi Pangestu Wijaya', '5034710816193960', '0955 3098 328', 'ami.hardiansyah@example.org', 'Jln. Bawal No. 702, Malang 36822, Banten', '2026-06-29 19:16:18', '2026-09-22 09:20:52'),
(37, 'Victoria Hasanah M.Farm', '3062676164937453', '(+62) 979 7220 4407', 'putri.mardhiyah@example.org', 'Jr. Ikan No. 198, Administrasi Jakarta Timur 58984, Kaltim', '2026-04-18 06:06:48', '2026-09-22 09:20:52'),
(38, 'Nyoman Hakim S.H.', '8570797811821697', '(+62) 407 6767 840', 'umaya.adriansyah@example.org', 'Kpg. Hang No. 761, Bukittinggi 36601, Sultra', '2026-05-04 15:26:52', '2026-09-22 09:20:52'),
(39, 'Nadine Zelaya Yuniar', '1478447421128933', '(+62) 969 0204 232', 'pradipta.niyaga@example.com', 'Jr. Bayam No. 764, Gunungsitoli 95298, Sumut', '2026-09-21 16:59:51', '2026-09-22 09:20:52'),
(40, 'Endah Cinta Aryani', '4799569541534958', '(+62) 726 6281 828', 'purwanti.maya@example.org', 'Ds. Yoga No. 828, Jambi 78280, Jateng', '2026-04-06 23:00:38', '2026-09-22 09:20:52'),
(41, 'Yessi Safitri S.Farm', '0021312259580956', '(+62) 710 5047 856', 'uwijaya@example.org', 'Psr. Ir. H. Juanda No. 676, Prabumulih 91196, DIY', '2026-06-07 21:23:38', '2026-09-22 09:20:52'),
(42, 'Malika Ani Hariyah', '1066164115157236', '(+62) 984 8750 7938', 'vpurnawati@example.net', 'Dk. Bakaru No. 125, Bekasi 83079, Sulteng', '2026-05-09 08:26:42', '2026-09-22 09:20:52'),
(43, 'Prima Kuswoyo', '3860084431053929', '0828 623 849', 'icha75@example.org', 'Kpg. Ujung No. 503, Administrasi Jakarta Utara 97119, Kalteng', '2026-09-17 23:12:50', '2026-09-22 09:20:52'),
(44, 'Dimas Mustofa', '2492251791232655', '(+62) 444 5859 4239', 'zsaragih@example.net', 'Ki. HOS. Cjokroaminoto (Pasirkaliki) No. 441, Payakumbuh 90552, NTB', '2026-04-07 05:28:34', '2026-09-22 09:20:52'),
(45, 'Jane Yuniar S.I.Kom', '9188800006239871', '(+62) 766 1237 333', 'mardhiyah.samiah@example.net', 'Ds. Cikutra Timur No. 686, Metro 14664, Kalteng', '2026-08-08 16:43:28', '2026-09-22 09:20:52'),
(46, 'Unggul Wibowo S.Sos', '8444802227124319', '0844 038 274', 'csihombing@example.org', 'Jr. Bata Putih No. 610, Bekasi 35089, Lampung', '2026-06-10 19:19:33', '2026-09-22 09:20:52'),
(47, 'Wirda Puspita', '1691963434551576', '0935 6254 4834', 'tampubolon.hana@example.net', 'Jr. Padma No. 167, Semarang 14977, DKI', '2026-07-23 13:10:22', '2026-09-22 09:20:52'),
(48, 'Radika Sirait', '3646400933232479', '(+62) 363 7151 722', 'latika22@example.org', 'Ds. Bakti No. 258, Bandar Lampung 44296, Banten', '2026-05-10 23:11:48', '2026-09-22 09:20:52'),
(49, 'Hardi Mangunsong', '2003838502840587', '(+62) 821 4274 375', 'calista.sihotang@example.com', 'Gg. Acordion No. 312, Tegal 75157, Kalsel', '2026-04-02 21:28:39', '2026-09-22 09:20:52'),
(50, 'Raina Ina Suartini', '0445282233065633', '(+62) 308 5705 8045', 'hariyah.samiah@example.com', 'Jr. Balikpapan No. 881, Sukabumi 21023, Sulbar', '2026-06-18 00:40:52', '2026-09-22 09:20:52'),
(51, 'Amelia Yolanda', '3350030107197246', '025 9768 0571', 'fwasita@example.net', 'Psr. PHH. Mustofa No. 644, Pontianak 13473, Kalsel', '2026-06-16 14:04:13', '2026-09-22 09:20:52'),
(52, 'Ega Saefullah M.Pd', '8640553750491227', '0685 7701 2675', 'betania59@example.com', 'Jr. B.Agam 1 No. 977, Administrasi Jakarta Barat 60846, Jatim', '2026-09-15 14:16:21', '2026-09-22 09:20:52'),
(53, 'Jessica Wastuti', '1326704976865682', '(+62) 350 7145 639', 'rhalimah@example.net', 'Jr. Baik No. 797, Semarang 48821, Sulut', '2026-03-29 13:44:38', '2026-09-22 09:20:52'),
(54, 'Victoria Latika Palastri', '4961133391099173', '(+62) 338 9553 8268', 'safitri.jono@example.org', 'Psr. Jamika No. 558, Sibolga 16766, Aceh', '2026-04-13 12:03:04', '2026-09-22 09:20:52'),
(55, 'Lili Fitriani Haryanti', '3582509633303395', '0456 3440 7299', 'xjailani@example.net', 'Ds. Kalimantan No. 9, Cirebon 88427, Gorontalo', '2026-08-19 14:55:35', '2026-09-22 09:20:52'),
(56, 'Ayu Agustina', '2074072463623070', '029 1473 4127', 'melani.imam@example.net', 'Ds. Bacang No. 713, Sawahlunto 95748, Jabar', '2026-04-10 17:18:03', '2026-09-22 09:20:52'),
(57, 'Janet Handayani S.E.', '5381240584048547', '(+62) 735 5435 188', 'diana89@example.net', 'Ki. Gatot Subroto No. 801, Prabumulih 43851, Jabar', '2026-06-05 05:04:48', '2026-09-22 09:20:52'),
(58, 'Sabar Taswir Halim M.Ak', '9136782627519803', '0820 7668 1973', 'rsitompul@example.net', 'Ds. Suharso No. 857, Balikpapan 35236, Bengkulu', '2026-04-06 14:28:40', '2026-09-22 09:20:52'),
(59, 'Cengkal Wibowo S.H.', '4872710720593641', '0600 0635 982', 'ghutagalung@example.net', 'Dk. Uluwatu No. 410, Binjai 39082, DKI', '2026-08-18 09:34:03', '2026-09-22 09:20:52'),
(60, 'Narji Wibowo', '7677413982566038', '(+62) 397 7410 7489', 'yunita95@example.net', 'Gg. Suryo No. 736, Administrasi Jakarta Barat 48644, Sulbar', '2026-08-18 05:58:42', '2026-09-22 09:20:52'),
(61, 'Zamira Puspasari', '5077336692779718', '0847 353 361', 'kardi91@example.org', 'Jln. Barasak No. 403, Semarang 59892, Lampung', '2026-07-10 02:12:48', '2026-09-22 09:20:52'),
(62, 'Jais Simanjuntak', '4531942131216159', '(+62) 648 4878 4041', 'laras.widodo@example.org', 'Kpg. Cihampelas No. 914, Bima 58800, NTT', '2026-05-04 01:58:52', '2026-09-22 09:20:52'),
(63, 'Farhunnisa Sudiati', '6541268855507043', '(+62) 746 1736 0204', 'wgunawan@example.org', 'Psr. Baabur Royan No. 664, Metro 73596, Sulbar', '2026-07-06 20:38:54', '2026-09-22 09:20:52'),
(64, 'Dagel Waskita S.Psi', '4581965810012521', '(+62) 585 3899 4730', 'uwais.panca@example.com', 'Dk. Bahagia No. 405, Serang 70725, Kalsel', '2026-04-12 22:03:30', '2026-09-22 09:20:52'),
(65, 'Vanesa Gawati Safitri S.Farm', '1688268856859890', '(+62) 294 1330 4691', 'irawan.panca@example.net', 'Gg. Jagakarsa No. 456, Tidore Kepulauan 77056, Lampung', '2026-08-24 07:51:08', '2026-09-22 09:20:52'),
(66, 'Mahmud Mandala', '8043677593177064', '(+62) 282 4055 1862', 'simanjuntak.irwan@example.net', 'Gg. Suharso No. 725, Palopo 95297, Sumsel', '2026-04-10 03:18:51', '2026-09-22 09:20:52'),
(67, 'Rizki Prasasta', '5676967146148054', '021 1212 613', 'gilda44@example.com', 'Dk. Suryo No. 654, Serang 93303, Pabar', '2026-05-08 05:12:26', '2026-09-22 09:20:52'),
(68, 'Prakosa Budiyanto', '4828905199851447', '029 6356 4543', 'farah.nasyidah@example.net', 'Jln. Baranang No. 594, Tangerang Selatan 63508, Kalsel', '2026-08-31 06:53:00', '2026-09-22 09:20:52'),
(69, 'Aslijan Limar Manullang S.Pt', '1671730586808688', '(+62) 835 6572 480', 'suartini.jagapati@example.com', 'Ki. Abdul. Muis No. 963, Banda Aceh 67381, Jatim', '2026-04-12 15:47:47', '2026-09-22 09:20:52'),
(70, 'Farah Mardhiyah', '0512289890510532', '0624 7494 539', 'yulianti.nova@example.org', 'Gg. Bahagia No. 957, Pekanbaru 37849, Jateng', '2026-09-16 07:27:29', '2026-09-22 09:20:52'),
(71, 'Mariadi Ardianto', '3508148468441875', '(+62) 889 3343 4730', 'heryanto.mardhiyah@example.org', 'Jr. Industri No. 394, Pematangsiantar 12942, Sultra', '2026-04-29 14:48:40', '2026-09-22 09:20:52'),
(72, 'Ulva Pratiwi', '5167971841984698', '0404 2111 371', 'rangga.megantara@example.com', 'Kpg. Pasirkoja No. 963, Administrasi Jakarta Utara 75627, Banten', '2026-07-30 18:49:38', '2026-09-22 09:20:52'),
(73, 'Hadi Purwa Mahendra', '6867603836270033', '(+62) 402 4372 540', 'bancar.hidayat@example.net', 'Kpg. Gegerkalong Hilir No. 932, Banjarbaru 63299, Sulbar', '2026-07-11 02:52:28', '2026-09-22 09:20:52'),
(74, 'Wulan Wijayanti', '9436700208167742', '0337 6180 8132', 'zaenab.suryatmi@example.com', 'Kpg. Ciwastra No. 227, Salatiga 65562, Pabar', '2026-08-21 07:26:10', '2026-09-22 09:20:52'),
(75, 'Patricia Susanti', '7874724091756490', '0814 2428 6122', 'pertiwi.rahmi@example.org', 'Ds. Pasir Koja No. 723, Tebing Tinggi 62119, Pabar', '2026-08-19 13:08:27', '2026-09-22 09:20:52'),
(76, 'Ismail Bahuwirya Nababan', '3939204477047191', '(+62) 446 9222 7331', 'wastuti.mila@example.net', 'Jln. Abdul. Muis No. 748, Manado 35556, Jambi', '2026-09-13 17:47:21', '2026-09-22 09:20:52'),
(77, 'Jane Wastuti', '6102326215865530', '(+62) 628 6320 488', 'jpudjiastuti@example.org', 'Kpg. Gatot Subroto No. 65, Batu 24061, Pabar', '2026-09-14 22:30:38', '2026-09-22 09:20:52'),
(78, 'Raina Winarsih', '0413615012651307', '(+62) 419 7054 667', 'ira.namaga@example.net', 'Dk. Raya Ujungberung No. 79, Palopo 95143, Kaltim', '2026-06-30 14:36:53', '2026-09-22 09:20:52'),
(79, 'Uli Puspasari', '3602694142645733', '023 6356 318', 'aisyah.lazuardi@example.net', 'Dk. Camar No. 325, Padang 46120, DIY', '2026-07-02 08:04:59', '2026-09-22 09:20:52'),
(80, 'Edison Hakim M.Ak', '2108410992047561', '022 2506 9630', 'maheswara.saadat@example.net', 'Psr. Baranang Siang Indah No. 649, Singkawang 16335, NTB', '2026-05-26 05:45:00', '2026-09-22 09:20:52'),
(81, 'Ajeng Padmi Astuti S.H.', '7580268480971152', '0925 3774 265', 'belinda42@example.org', 'Jln. Jaksa No. 510, Parepare 73687, Sumut', '2026-06-15 18:15:21', '2026-09-22 09:20:52'),
(82, 'Zizi Yolanda', '2849205190701590', '(+62) 846 0794 9581', 'mayasari.damu@example.net', 'Gg. Wahid No. 633, Tanjungbalai 34733, Kaltim', '2026-05-04 12:16:08', '2026-09-22 09:20:52'),
(83, 'Ellis Mila Pratiwi', '5096387997575258', '0541 4789 4137', 'uli.wastuti@example.net', 'Psr. Pasteur No. 321, Salatiga 38353, Aceh', '2026-05-18 03:02:10', '2026-09-22 09:20:52'),
(84, 'Nalar Karman Wasita S.Farm', '0860930812968395', '0984 9061 8968', 'knajmudin@example.org', 'Ds. Astana Anyar No. 24, Semarang 82559, Sulut', '2026-05-15 11:13:47', '2026-09-22 09:20:52'),
(85, 'Cinthia Prastuti', '0114051075864697', '(+62) 917 9624 192', 'rmandala@example.com', 'Ki. Rajawali Barat No. 411, Banjar 66579, Sulut', '2026-03-28 15:19:48', '2026-09-22 09:20:52'),
(86, 'Cemani Muni Mahendra', '1496751625293837', '0336 4000 804', 'catur12@example.net', 'Jr. Merdeka No. 412, Makassar 36463, Sumut', '2026-08-28 02:36:56', '2026-09-22 09:20:52'),
(87, 'Timbul Darimin Siregar', '9592490189221704', '0744 1324 589', 'nashiruddin.caket@example.net', 'Ds. Madiun No. 961, Jambi 90146, Jabar', '2026-07-11 15:55:30', '2026-09-22 09:20:52'),
(88, 'Ina Prastuti M.Kom.', '2031484579247967', '0938 2357 323', 'tantri58@example.net', 'Gg. Baranang No. 491, Cirebon 62926, Papua', '2026-08-31 04:41:42', '2026-09-22 09:20:52'),
(89, 'Empluk Haryanto', '8165976994909349', '(+62) 326 3865 385', 'wwijaya@example.com', 'Jr. Merdeka No. 62, Tanjungbalai 53994, Sulut', '2026-09-04 20:11:31', '2026-09-22 09:20:52'),
(90, 'Intan Widya Rahmawati S.I.Kom', '4639926510811940', '(+62) 769 6221 4023', 'tirtayasa.zulaika@example.com', 'Ki. Hang No. 801, Prabumulih 72478, Bengkulu', '2026-05-31 21:41:53', '2026-09-22 09:20:52'),
(91, 'Ismail Budiyanto', '6534676364224569', '(+62) 27 7002 207', 'irfan.irawan@example.org', 'Jln. Supono No. 615, Banda Aceh 52717, Jambi', '2026-07-16 02:19:46', '2026-09-22 09:20:52'),
(92, 'Vanya Yulianti S.Pd', '2993835160501117', '0521 2309 593', 'phutapea@example.net', 'Jr. Hasanuddin No. 638, Banjarbaru 49569, Jatim', '2026-06-09 05:54:20', '2026-09-22 09:20:52'),
(93, 'Elvin Prasetyo', '1602637487338858', '(+62) 263 6497 0963', 'among93@example.net', 'Ki. Baya Kali Bungur No. 663, Gunungsitoli 82510, DKI', '2026-03-26 18:00:34', '2026-09-22 09:20:52'),
(94, 'Dimas Mahendra', '4289980439938792', '(+62) 471 5498 226', 'marpaung.endah@example.net', 'Psr. Aceh No. 557, Bengkulu 60616, DKI', '2026-05-25 17:31:30', '2026-09-22 09:20:52'),
(95, 'Intan Novitasari M.Farm', '4757198121770184', '0630 5074 1295', 'prasetya11@example.com', 'Kpg. Yos No. 127, Tual 38564, Sulbar', '2026-05-02 01:11:40', '2026-09-22 09:20:52'),
(96, 'Zulfa Padmasari M.Pd', '8188065234224896', '(+62) 21 1803 4579', 'pmustofa@example.net', 'Jr. Banda No. 38, Ternate 84626, Kalteng', '2026-09-02 12:39:05', '2026-09-22 09:20:52'),
(97, 'Umi Hasanah', '9723824012825090', '(+62) 751 1166 3158', 'manullang.sari@example.org', 'Dk. Sukabumi No. 885, Singkawang 67236, Jatim', '2026-05-20 00:00:39', '2026-09-22 09:20:52'),
(98, 'Mutia Rahayu', '6282947539749927', '0402 7243 205', 'mila.agustina@example.net', 'Gg. Yap Tjwan Bing No. 85, Cirebon 15730, Sulbar', '2026-04-04 16:17:53', '2026-09-22 09:20:52'),
(99, 'Mustofa Putra S.Ked', '6955496778221636', '(+62) 644 3309 3238', 'emayasari@example.org', 'Gg. Bass No. 678, Makassar 67553, Kepri', '2026-07-23 00:09:14', '2026-09-22 09:20:52'),
(100, 'Anita Maida Puspasari', '7714062477672600', '0636 5751 2646', 'sabrina64@example.net', 'Jr. Abang No. 6, Mataram 39090, Gorontalo', '2026-09-19 20:40:57', '2026-09-22 09:20:52'),
(101, 'Oni Nurdiyanti', '1271118291646027', '0420 8130 5955', 'saiful51@example.org', 'Jln. Salam No. 72, Pekalongan 64824, DIY', '2026-06-03 11:17:53', '2026-09-22 09:20:52'),
(102, 'Mustofa Halim', '1061676939022348', '(+62) 714 2964 716', 'ani.hardiansyah@example.net', 'Psr. Sutami No. 658, Tarakan 30291, DIY', '2026-08-08 21:19:04', '2026-09-22 09:20:52'),
(103, 'Soleh Hutagalung S.Psi', '9412228196800007', '0358 6389 810', 'anggabaya.putra@example.net', 'Dk. Kiaracondong No. 380, Tegal 18279, Sulteng', '2026-08-12 03:09:14', '2026-09-22 09:20:52'),
(104, 'Ifa Prastuti S.Sos', '3407410048540701', '0560 2497 1226', 'nashiruddin.shakila@example.net', 'Gg. Ketandan No. 355, Tegal 23112, Sumut', '2026-05-28 00:10:28', '2026-09-22 09:20:52'),
(105, 'Jessica Lala Mayasari', '4509804061907485', '(+62) 686 4768 847', 'wibisono.sabar@example.org', 'Ds. Baranang Siang No. 411, Tidore Kepulauan 93980, Riau', '2026-05-20 05:47:50', '2026-09-22 09:20:52'),
(106, 'Zalindra Farah Andriani M.M.', '2768663628694969', '0495 7299 515', 'jaga.hakim@example.org', 'Kpg. Cihampelas No. 729, Pangkal Pinang 21571, Kaltara', '2026-05-08 00:25:52', '2026-09-22 09:20:52'),
(107, 'Kalim Wijaya', '3943842126411744', '0591 0982 1920', 'ajanuar@example.com', 'Psr. Kartini No. 493, Balikpapan 49254, Sulut', '2026-08-27 00:41:27', '2026-09-22 09:20:52'),
(108, 'Iriana Farida S.IP', '4487331761511272', '0963 4881 280', 'riyanti.carla@example.org', 'Dk. Kalimantan No. 264, Kediri 26576, Jabar', '2026-04-01 01:31:32', '2026-09-22 09:20:52'),
(109, 'Sabrina Andriani', '6217230957838577', '0420 5623 0228', 'gwibisono@example.net', 'Dk. Sugiyopranoto No. 132, Palopo 67890, Sulbar', '2026-04-07 14:04:36', '2026-09-22 09:20:52'),
(110, 'Hilda Samiah Purnawati', '2540312246847317', '(+62) 825 2439 4832', 'putri94@example.com', 'Kpg. Nanas No. 508, Ternate 82640, Kaltara', '2026-08-22 06:29:38', '2026-09-22 09:20:52'),
(111, 'Abyasa Lazuardi', '6273910665251785', '0916 9863 966', 'latupono.argono@example.net', 'Jr. Jagakarsa No. 552, Tomohon 90615, Kalbar', '2026-05-02 06:41:41', '2026-09-22 09:20:52'),
(112, 'Jumadi Ibrani Kurniawan', '3981687299065264', '(+62) 816 584 064', 'dpertiwi@example.net', 'Jr. Merdeka No. 296, Palopo 72759, Bengkulu', '2026-07-30 19:14:12', '2026-09-22 09:20:52'),
(113, 'Candrakanta Hartaka Firmansyah', '2650920078965871', '(+62) 792 9487 444', 'nadia.purwanti@example.com', 'Jln. Tambak No. 416, Bengkulu 12489, Maluku', '2026-04-09 17:47:25', '2026-09-22 09:20:52'),
(114, 'Widya Winarsih', '3992917055295878', '026 7274 642', 'wawan.aryani@example.org', 'Ki. Basoka No. 984, Palembang 69294, Lampung', '2026-06-09 10:42:13', '2026-09-22 09:20:52'),
(115, 'Zizi Mila Hartati S.E.', '3715449068088726', '0779 5612 158', 'lintang.sinaga@example.net', 'Jr. Uluwatu No. 731, Palangka Raya 70757, Babel', '2026-08-16 11:17:12', '2026-09-22 09:20:52'),
(116, 'Puput Astuti', '7496271732971087', '0931 9062 2186', 'galak01@example.org', 'Ki. Bappenas No. 584, Mataram 43119, Sumsel', '2026-05-11 12:45:32', '2026-09-22 09:20:52'),
(117, 'Yuni Tantri Riyanti', '7724003956185116', '(+62) 20 5153 4160', 'wfirmansyah@example.net', 'Jr. Sukajadi No. 45, Cirebon 89841, DKI', '2026-07-24 02:37:18', '2026-09-22 09:20:52'),
(118, 'Banawa Situmorang', '5759174482597446', '0423 5847 4565', 'balidin36@example.net', 'Dk. Bagas Pati No. 877, Bekasi 14270, Bali', '2026-05-01 23:31:13', '2026-09-22 09:20:52'),
(119, 'Karimah Oktaviani', '6796812433226910', '021 1154 9880', 'halimah.almira@example.com', 'Kpg. Tangkuban Perahu No. 77, Samarinda 31874, DKI', '2026-07-05 21:35:35', '2026-09-22 09:20:52'),
(120, 'Kania Natalia Padmasari S.T.', '0199259418063528', '(+62) 864 5851 455', 'gawati.ramadan@example.com', 'Ki. HOS. Cjokroaminoto (Pasirkaliki) No. 481, Pekanbaru 76988, Papua', '2026-05-26 19:21:37', '2026-09-22 09:20:52'),
(121, 'Ilsa Prastuti', '5241112699029942', '0696 0328 4621', 'usalahudin@example.net', 'Ds. Agus Salim No. 294, Pematangsiantar 36080, Kalbar', '2026-06-01 10:36:01', '2026-09-22 09:20:52'),
(122, 'Tiara Hariyah', '3307545320221747', '0879 192 213', 'gunarto.diah@example.org', 'Jr. Labu No. 458, Pekalongan 82707, Sumsel', '2026-04-01 19:32:25', '2026-09-22 09:20:52'),
(123, 'Sarah Mayasari', '8176200044481749', '0991 7955 2392', 'dusamah@example.com', 'Psr. Padang No. 26, Bitung 20288, Jateng', '2026-09-18 12:31:12', '2026-09-22 09:20:52'),
(124, 'Jelita Mulyani', '0739137774498100', '0652 9323 7348', 'handayani.danu@example.net', 'Psr. Bacang No. 491, Pekanbaru 98270, DKI', '2026-08-01 22:24:36', '2026-09-22 09:20:52'),
(125, 'Jumadi Prasetya S.Kom', '3094170238143688', '(+62) 342 0691 222', 'azalea67@example.org', 'Psr. Bacang No. 804, Malang 94733, Sultra', '2026-07-13 04:13:12', '2026-09-22 09:20:52'),
(126, 'Cakrawangsa Makara Wibowo', '9283498609195210', '(+62) 227 6853 7165', 'haryanto.ifa@example.net', 'Ki. Cemara No. 535, Kediri 11319, Jabar', '2026-07-29 02:59:24', '2026-09-22 09:20:52'),
(127, 'Kasiran Tarihoran', '3641686139511817', '0645 0206 7566', 'iswahyudi.talia@example.com', 'Gg. Tambun No. 159, Sawahlunto 69010, NTB', '2026-07-04 15:22:48', '2026-09-22 09:20:52'),
(128, 'Elma Ellis Farida', '8934990716726914', '(+62) 648 3260 337', 'puput.prasasta@example.com', 'Kpg. Jagakarsa No. 846, Yogyakarta 92360, Maluku', '2026-06-12 16:54:59', '2026-09-22 09:20:52'),
(129, 'Nabila Puput Farida S.Ked', '6669341749786881', '0566 7631 4711', 'karman55@example.org', 'Ds. Basudewo No. 780, Padang 65309, Malut', '2026-05-23 00:44:32', '2026-09-22 09:20:52'),
(130, 'Ajiono Kuswoyo', '0661580112835948', '025 9007 8935', 'rahayu.hasanah@example.com', 'Dk. Pintu Besar Selatan No. 6, Administrasi Jakarta Utara 50709, Sumsel', '2026-07-06 13:49:14', '2026-09-22 09:20:52'),
(131, 'Kambali Bakidin Pranowo', '8508119678456582', '(+62) 529 6812 0295', 'tthamrin@example.net', 'Ds. Ters. Buah Batu No. 312, Palopo 36244, Lampung', '2026-04-29 18:42:57', '2026-09-22 09:20:52'),
(132, 'Chandra Prayoga Marbun', '8005952036466241', '0692 4768 338', 'cecep34@example.net', 'Ki. Bakau Griya Utama No. 791, Malang 33918, Bali', '2026-08-09 06:34:03', '2026-09-22 09:20:52'),
(133, 'Maria Elvina Mardhiyah S.Sos', '9651653486524733', '0221 4167 646', 'msusanti@example.org', 'Gg. Panjaitan No. 561, Balikpapan 60816, Kalsel', '2026-06-20 17:58:26', '2026-09-22 09:20:52'),
(134, 'Hana Melani M.M.', '4081072398144449', '020 5494 4942', 'lpermata@example.org', 'Ds. Jend. A. Yani No. 173, Salatiga 20973, Sulteng', '2026-04-20 20:11:34', '2026-09-22 09:20:52'),
(135, 'Luluh Pranowo S.E.', '9030228784296199', '0598 6730 393', 'nasrullah99@example.org', 'Jr. Setiabudhi No. 453, Kediri 54160, Kalbar', '2026-08-29 16:49:24', '2026-09-22 09:20:52'),
(136, 'Atma Hari Natsir', '0713898024471369', '026 7451 861', 'humaira49@example.org', 'Kpg. Gading No. 330, Administrasi Jakarta Pusat 71202, Gorontalo', '2026-08-29 15:22:07', '2026-09-22 09:20:52'),
(137, 'Janet Padmi Haryanti', '9019415889540472', '0964 6422 8504', 'afirmansyah@example.com', 'Kpg. Rajiman No. 370, Samarinda 82600, DIY', '2026-07-27 06:08:11', '2026-09-22 09:20:52'),
(138, 'Karta Iswahyudi S.Pd', '4058654587843543', '0360 3262 8710', 'makara.sitompul@example.org', 'Jr. Ketandan No. 571, Tidore Kepulauan 63791, DKI', '2026-05-07 00:47:06', '2026-09-22 09:20:52'),
(139, 'Laswi Wibowo', '0204720914819230', '0634 6792 9538', 'vicky.halim@example.com', 'Jr. Sukabumi No. 540, Bontang 50292, Sumbar', '2026-09-11 15:29:07', '2026-09-22 09:20:52'),
(140, 'Opung Marpaung S.E.I', '4826403229073977', '(+62) 447 0130 099', 'puti64@example.org', 'Dk. Jambu No. 144, Bandung 25451, Jateng', '2026-09-17 06:51:40', '2026-09-22 09:20:52'),
(141, 'Michelle Dewi Susanti', '0882609150507164', '(+62) 426 5011 369', 'mlatupono@example.com', 'Gg. Lembong No. 702, Binjai 77601, Sumsel', '2026-06-29 22:43:56', '2026-09-22 09:20:52'),
(142, 'Hairyanto Pranowo', '1465885456378389', '(+62) 666 2248 7081', 'marsito.januar@example.com', 'Gg. Juanda No. 240, Bekasi 70028, NTT', '2026-05-07 22:11:33', '2026-09-22 09:20:52'),
(143, 'Dirja Anom Zulkarnain S.E.', '0774652349855488', '(+62) 352 3338 339', 'nasyidah.nrima@example.com', 'Jln. Otista No. 972, Cimahi 56644, Babel', '2026-08-17 08:35:23', '2026-09-22 09:20:52'),
(144, 'Yuni Yuliarti', '0198021198281670', '0716 1228 960', 'titin34@example.com', 'Kpg. Abang No. 525, Bontang 18902, Jateng', '2026-08-19 04:23:01', '2026-09-22 09:20:52'),
(145, 'Timbul Nashiruddin', '2364481034364179', '(+62) 213 9558 8535', 'palastri.kamal@example.net', 'Kpg. Pattimura No. 406, Solok 81153, Sulbar', '2026-05-27 10:24:18', '2026-09-22 09:20:52'),
(146, 'Ghaliyati Purnawati', '2474605559806155', '(+62) 891 474 297', 'narpati.genta@example.com', 'Ds. W.R. Supratman No. 391, Tomohon 28263, DIY', '2026-06-04 14:50:56', '2026-09-22 09:20:52'),
(147, 'Indah Halimah', '0959850969060323', '(+62) 23 1321 8533', 'puspasari.rama@example.com', 'Psr. Nakula No. 715, Pekalongan 16321, Kepri', '2026-09-11 14:32:32', '2026-09-22 09:20:52'),
(148, 'Ivan Simanjuntak', '3936893029513429', '0893 731 359', 'icha.damanik@example.com', 'Dk. Astana Anyar No. 778, Palopo 85663, Aceh', '2026-05-23 18:08:24', '2026-09-22 09:20:52'),
(149, 'Jati Emas Iswahyudi', '7668252125575716', '(+62) 307 9037 262', 'gabriella.mahendra@example.org', 'Psr. Ronggowarsito No. 608, Magelang 58318, NTB', '2026-05-19 07:19:52', '2026-09-22 09:20:52'),
(150, 'Dacin Sitorus', '2534955143010006', '(+62) 613 0775 5827', 'tampubolon.ami@example.org', 'Dk. Villa No. 872, Administrasi Jakarta Utara 53699, DKI', '2026-04-18 21:52:14', '2026-09-22 09:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `housekeeping_tasks`
--

CREATE TABLE `housekeeping_tasks` (
  `id` int UNSIGNED NOT NULL,
  `room_id` int UNSIGNED NOT NULL,
  `assigned_to` int UNSIGNED DEFAULT NULL,
  `task_type` enum('daily_clean','checkout_clean','deep_clean','inspection') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'daily_clean',
  `status` enum('pending','in_progress','done','verified') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Foto kondisi kamar',
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `housekeeping_tasks`
--

INSERT INTO `housekeeping_tasks` (`id`, `room_id`, `assigned_to`, `task_type`, `status`, `notes`, `photo`, `started_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 68, NULL, 'inspection', 'done', NULL, NULL, '2026-09-22 03:11:52', '2026-09-22 04:33:52', '2026-09-22 02:51:52', '2026-09-22 09:20:58'),
(2, 19, 2, 'deep_clean', 'pending', NULL, NULL, NULL, NULL, '2026-09-08 04:28:28', '2026-09-22 09:20:58'),
(3, 49, NULL, 'daily_clean', 'verified', 'Doloremque consequatur mollitia consequatur voluptatem.', NULL, '2026-09-06 22:33:25', '2026-09-06 23:22:25', '2026-09-06 22:25:25', '2026-09-22 09:20:58'),
(4, 47, NULL, 'daily_clean', 'done', NULL, NULL, '2026-09-19 15:07:52', '2026-09-19 16:24:52', '2026-09-19 14:32:52', '2026-09-22 09:20:58'),
(5, 14, NULL, 'inspection', 'in_progress', 'Sed voluptatem veritatis quisquam.', NULL, '2026-09-17 09:07:43', NULL, '2026-09-17 08:18:43', '2026-09-22 09:20:58'),
(6, 15, 2, 'checkout_clean', 'verified', NULL, NULL, '2026-08-23 15:09:07', '2026-08-23 16:35:07', '2026-08-23 14:18:07', '2026-09-22 09:20:58'),
(7, 44, 2, 'deep_clean', 'in_progress', NULL, NULL, '2026-09-21 11:33:18', NULL, '2026-09-21 10:35:18', '2026-09-22 09:20:58'),
(8, 38, NULL, 'deep_clean', 'in_progress', NULL, NULL, '2026-09-20 22:54:39', NULL, '2026-09-20 22:09:39', '2026-09-22 09:20:58'),
(9, 62, NULL, 'daily_clean', 'verified', NULL, NULL, '2026-08-27 18:47:45', '2026-08-27 20:05:45', '2026-08-27 18:42:45', '2026-09-22 09:20:58'),
(10, 57, 2, 'checkout_clean', 'done', NULL, NULL, '2026-09-08 16:31:32', '2026-09-08 17:59:32', '2026-09-08 16:10:32', '2026-09-22 09:20:58'),
(11, 59, 2, 'deep_clean', 'done', 'Quia vel explicabo aut occaecati.', NULL, '2026-08-25 03:01:02', '2026-08-25 04:34:02', '2026-08-25 02:21:02', '2026-09-22 09:20:58'),
(12, 50, 2, 'checkout_clean', 'done', NULL, NULL, '2026-09-07 06:08:03', '2026-09-07 08:03:03', '2026-09-07 05:38:03', '2026-09-22 09:20:58'),
(13, 14, 2, 'inspection', 'verified', 'Incidunt debitis et minus aperiam.', NULL, '2026-09-03 06:17:45', '2026-09-03 07:29:45', '2026-09-03 05:30:45', '2026-09-22 09:20:58'),
(14, 33, NULL, 'daily_clean', 'done', NULL, NULL, '2026-09-18 13:53:24', '2026-09-18 15:01:24', '2026-09-18 13:29:24', '2026-09-22 09:20:58'),
(15, 64, NULL, 'deep_clean', 'verified', 'Rerum quae non consequuntur quas est non.', NULL, '2026-08-27 19:04:41', '2026-08-27 20:56:41', '2026-08-27 18:41:41', '2026-09-22 09:20:58'),
(16, 3, 2, 'deep_clean', 'done', NULL, NULL, '2026-09-08 21:00:16', '2026-09-08 22:18:16', '2026-09-08 20:33:16', '2026-09-22 09:20:58'),
(17, 6, NULL, 'inspection', 'in_progress', 'Optio dolor illum laborum voluptatem quasi recusandae.', NULL, '2026-09-03 16:14:44', NULL, '2026-09-03 16:00:44', '2026-09-22 09:20:58'),
(18, 31, NULL, 'deep_clean', 'verified', 'Fuga adipisci eum autem fugiat omnis.', NULL, '2026-08-27 06:12:42', '2026-08-27 06:37:42', '2026-08-27 05:35:42', '2026-09-22 09:20:58'),
(19, 31, NULL, 'daily_clean', 'verified', NULL, NULL, '2026-09-16 08:13:00', '2026-09-16 09:36:00', '2026-09-16 07:28:00', '2026-09-22 09:20:58'),
(20, 61, 2, 'daily_clean', 'verified', NULL, NULL, '2026-09-18 01:26:18', '2026-09-18 02:57:18', '2026-09-18 00:53:18', '2026-09-22 09:20:58'),
(21, 61, NULL, 'inspection', 'verified', 'Ipsam voluptate sunt nostrum culpa.', NULL, '2026-08-31 15:22:16', '2026-08-31 16:40:16', '2026-08-31 15:06:16', '2026-09-22 09:20:58'),
(22, 55, 2, 'inspection', 'verified', 'Vitae harum incidunt dicta ut illo.', NULL, '2026-08-23 23:28:52', '2026-08-24 01:04:52', '2026-08-23 23:00:52', '2026-09-22 09:20:58'),
(23, 71, 2, 'inspection', 'in_progress', 'Ut ex consequatur sapiente illo officia dolore.', NULL, '2026-09-07 18:29:46', NULL, '2026-09-07 18:22:46', '2026-09-22 09:20:58'),
(24, 8, 2, 'inspection', 'pending', NULL, NULL, NULL, NULL, '2026-09-19 08:48:12', '2026-09-22 09:20:58'),
(25, 60, 2, 'deep_clean', 'verified', 'Reprehenderit vel quasi aliquam modi accusamus aspernatur voluptas ut.', NULL, '2026-08-27 02:20:46', '2026-08-27 02:52:46', '2026-08-27 01:27:46', '2026-09-22 09:20:58'),
(26, 75, 2, 'inspection', 'pending', 'Id in ipsa accusantium voluptatem est praesentium ab.', NULL, NULL, NULL, '2026-09-13 12:53:37', '2026-09-22 09:20:58'),
(27, 18, NULL, 'inspection', 'in_progress', 'Sequi dolores aut nulla asperiores porro.', NULL, '2026-09-06 05:01:46', NULL, '2026-09-06 04:05:46', '2026-09-22 09:20:58'),
(28, 57, 2, 'inspection', 'verified', NULL, NULL, '2026-09-04 10:30:45', '2026-09-04 12:29:45', '2026-09-04 09:35:45', '2026-09-22 09:20:58'),
(29, 69, 2, 'inspection', 'pending', 'Quis nesciunt architecto nihil quisquam suscipit.', NULL, NULL, NULL, '2026-08-29 21:05:35', '2026-09-22 09:20:58'),
(30, 24, 2, 'daily_clean', 'done', 'Esse dignissimos alias consequatur dolor modi est.', NULL, '2026-08-30 08:38:32', '2026-08-30 10:37:32', '2026-08-30 08:06:32', '2026-09-22 09:20:58'),
(31, 58, 2, 'daily_clean', 'done', 'Quia quis suscipit est iusto et saepe.', NULL, '2026-09-20 18:23:12', '2026-09-20 19:46:12', '2026-09-20 18:09:12', '2026-09-22 09:20:58'),
(32, 72, NULL, 'checkout_clean', 'pending', 'Quis et quibusdam assumenda inventore ratione.', NULL, NULL, NULL, '2026-09-22 05:50:18', '2026-09-22 09:20:58'),
(33, 10, 2, 'daily_clean', 'done', 'Sed error fugit eligendi aut ut.', NULL, '2026-08-26 12:42:49', '2026-08-26 14:41:49', '2026-08-26 12:25:49', '2026-09-22 09:20:58'),
(34, 34, 2, 'inspection', 'in_progress', NULL, NULL, '2026-08-27 06:28:06', NULL, '2026-08-27 05:48:06', '2026-09-22 09:20:58'),
(35, 11, 2, 'inspection', 'done', NULL, NULL, '2026-09-04 13:46:28', '2026-09-04 14:44:28', '2026-09-04 13:36:28', '2026-09-22 09:20:58'),
(36, 49, 2, 'deep_clean', 'pending', 'Sunt expedita repellendus voluptates qui provident harum dolores.', NULL, NULL, NULL, '2026-08-31 14:46:00', '2026-09-22 09:20:58'),
(37, 65, 2, 'daily_clean', 'done', NULL, NULL, '2026-09-06 05:31:22', '2026-09-06 06:51:22', '2026-09-06 05:17:22', '2026-09-22 09:20:58'),
(38, 26, 2, 'deep_clean', 'verified', 'Ipsa accusamus ratione similique.', NULL, '2026-09-18 01:47:04', '2026-09-18 02:59:04', '2026-09-18 01:10:04', '2026-09-22 09:20:58'),
(39, 64, 2, 'deep_clean', 'in_progress', NULL, NULL, '2026-08-27 01:26:30', NULL, '2026-08-27 00:46:30', '2026-09-22 09:20:58'),
(40, 59, 2, 'deep_clean', 'in_progress', NULL, NULL, '2026-09-22 09:42:58', NULL, '2026-09-22 08:53:58', '2026-09-22 09:20:58'),
(41, 74, 2, 'daily_clean', 'in_progress', NULL, NULL, '2026-09-05 11:33:02', NULL, '2026-09-05 11:00:02', '2026-09-22 09:20:58'),
(42, 50, NULL, 'checkout_clean', 'done', NULL, NULL, '2026-08-24 04:42:24', '2026-08-24 05:47:24', '2026-08-24 03:43:24', '2026-09-22 09:20:58'),
(43, 73, NULL, 'checkout_clean', 'in_progress', 'Voluptatum dolorem rem quisquam tempora quaerat.', NULL, '2026-09-04 06:57:21', NULL, '2026-09-04 05:59:21', '2026-09-22 09:20:58'),
(44, 42, NULL, 'inspection', 'verified', NULL, NULL, '2026-09-14 16:07:00', '2026-09-14 16:55:00', '2026-09-14 15:31:00', '2026-09-22 09:20:58'),
(45, 6, 2, 'inspection', 'done', 'Odit pariatur quia explicabo doloribus ipsum error veniam.', NULL, '2026-09-02 02:53:46', '2026-09-02 04:45:46', '2026-09-02 02:04:46', '2026-09-22 09:20:58'),
(46, 5, 2, 'deep_clean', 'verified', 'Distinctio delectus facilis explicabo commodi ratione.', NULL, '2026-09-19 10:11:12', '2026-09-19 11:10:12', '2026-09-19 09:46:12', '2026-09-22 09:20:58'),
(47, 41, 2, 'deep_clean', 'verified', NULL, NULL, '2026-08-27 21:13:13', '2026-08-27 23:13:13', '2026-08-27 21:08:13', '2026-09-22 09:20:58'),
(48, 12, 2, 'daily_clean', 'verified', 'Et omnis enim laboriosam fuga.', NULL, '2026-09-22 01:40:15', '2026-09-22 03:36:15', '2026-09-22 01:03:15', '2026-09-22 09:20:58'),
(49, 1, 2, 'checkout_clean', 'done', 'Eos a cupiditate sunt quaerat sed.', NULL, '2026-08-29 19:18:28', '2026-08-29 20:21:28', '2026-08-29 18:25:28', '2026-09-22 09:20:58'),
(50, 4, NULL, 'daily_clean', 'done', NULL, NULL, '2026-09-14 07:20:54', '2026-09-14 08:02:54', '2026-09-14 07:00:54', '2026-09-22 09:20:58'),
(51, 53, NULL, 'inspection', 'pending', NULL, NULL, NULL, NULL, '2026-09-03 20:47:57', '2026-09-22 09:20:58'),
(52, 6, NULL, 'daily_clean', 'done', 'Pariatur laboriosam reiciendis deserunt.', NULL, '2026-09-09 22:03:35', '2026-09-09 22:29:35', '2026-09-09 21:51:35', '2026-09-22 09:20:58'),
(53, 30, NULL, 'daily_clean', 'in_progress', NULL, NULL, '2026-09-14 04:13:33', NULL, '2026-09-14 03:18:33', '2026-09-22 09:20:58'),
(54, 1, 2, 'inspection', 'done', NULL, NULL, '2026-09-07 09:53:00', '2026-09-07 11:40:00', '2026-09-07 09:11:00', '2026-09-22 09:20:58'),
(55, 26, 2, 'inspection', 'in_progress', 'Est veritatis doloremque consequatur mollitia totam veniam numquam.', NULL, '2026-09-19 06:40:04', NULL, '2026-09-19 05:54:04', '2026-09-22 09:20:58'),
(56, 53, 2, 'checkout_clean', 'in_progress', 'Perspiciatis dolores quas quibusdam pariatur.', NULL, '2026-08-28 14:33:21', NULL, '2026-08-28 14:15:21', '2026-09-22 09:20:58'),
(57, 15, NULL, 'daily_clean', 'done', 'Consequatur quas dignissimos et impedit perferendis in aut.', NULL, '2026-09-09 15:40:21', '2026-09-09 17:35:21', '2026-09-09 15:04:21', '2026-09-22 09:20:58'),
(58, 41, 2, 'checkout_clean', 'verified', 'Dignissimos totam distinctio omnis.', NULL, '2026-08-31 10:58:12', '2026-08-31 11:24:12', '2026-08-31 10:25:12', '2026-09-22 09:20:58'),
(59, 36, 2, 'inspection', 'in_progress', 'Qui est laboriosam perspiciatis alias enim dignissimos tempore facilis.', NULL, '2026-08-31 01:52:40', NULL, '2026-08-31 01:14:40', '2026-09-22 09:20:58'),
(60, 69, 2, 'checkout_clean', 'done', 'Nihil a quasi doloremque corporis iure neque quod.', NULL, '2026-09-10 19:06:59', '2026-09-10 20:45:59', '2026-09-10 18:20:59', '2026-09-22 09:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `current_stock` int NOT NULL DEFAULT '0',
  `minimum_stock` int UNSIGNED NOT NULL DEFAULT '0',
  `last_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `expiry_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `code`, `name`, `unit`, `current_stock`, `minimum_stock`, `last_price`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'ITM-0001', 'Sabun Mandi', 'pcs', 10, 5, 5000.00, NULL, '2026-09-21 13:19:16', '2026-09-21 13:50:28'),
(2, 1, 'ITM-0002', 'Handuk', 'pcs', 20, 5, 75000.00, '2026-09-30', '2026-09-21 13:20:15', '2026-09-21 13:50:28'),
(3, 1, 'ITM-0003', 'Shampo', 'pcs', 0, 5, 1000.00, NULL, '2026-09-21 13:20:50', '2026-09-21 13:20:50'),
(4, 3, 'ITM-0004', 'Susu UHT', 'liter', 20, 5, 19000.00, NULL, '2026-09-21 13:22:14', '2026-09-21 13:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Amenities', 'Sabun, shampo, sikat gigi, dll', '2026-09-21 10:59:10'),
(2, 'Linen', 'Handuk, sprei, sarung bantal', '2026-09-21 10:59:10'),
(3, 'Kitchen', 'Bahan makanan dan minuman', '2026-09-21 10:59:10'),
(4, 'Engineering', 'Suku cadang dan alat perbaikan', '2026-09-21 10:59:10'),
(5, 'Office', 'Alat tulis dan keperluan kantor', '2026-09-21 20:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` int UNSIGNED NOT NULL,
  `room_id` int UNSIGNED DEFAULT NULL,
  `reported_by` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1789964069, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1789964069, 1),
(3, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1789964069, 1),
(4, '2026-07-20-181246', 'CodeIgniter\\Settings\\Database\\Migrations\\ConvertSqlsrvValueColumn', 'default', 'CodeIgniter\\Settings', 1789964069, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int UNSIGNED NOT NULL,
  `folio_id` int UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `method` enum('cash','debit','credit','transfer','qris') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_date` datetime NOT NULL,
  `reference_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path file bukti transfer',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_details`
--

CREATE TABLE `po_details` (
  `id` int UNSIGNED NOT NULL,
  `po_id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int UNSIGNED NOT NULL,
  `po_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int UNSIGNED NOT NULL,
  `status` enum('draft','sent','partial','received','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `order_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `total_amount` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_by` int UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int UNSIGNED NOT NULL,
  `reservation_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_id` int UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_code`, `guest_id`, `check_in_date`, `check_out_date`, `total_price`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'RSV-20260323-0001', 45, '2026-03-23', '2026-03-24', 850000.00, 'cancelled', NULL, 2, '2026-03-21 16:37:57', '2026-03-21 16:37:57'),
(2, 'RSV-20261007-0002', 92, '2026-10-07', '2026-10-10', 2550000.00, 'pending', NULL, 2, '2026-10-05 12:57:44', '2026-10-05 12:57:44'),
(3, 'RSV-20260625-0003', 95, '2026-06-25', '2026-06-28', 1050000.00, 'checked_out', NULL, 2, '2026-06-23 09:32:50', '2026-06-23 09:32:50'),
(4, 'RSV-20261017-0004', 29, '2026-10-17', '2026-10-20', 1500000.00, 'confirmed', 'Expedita quod hic sunt rerum.', 2, '2026-10-15 23:53:15', '2026-10-15 23:53:15'),
(5, 'RSV-20260331-0005', 11, '2026-03-31', '2026-04-04', 3400000.00, 'cancelled', 'Sed similique possimus sapiente fugiat inventore qui.', 2, '2026-03-29 04:32:03', '2026-03-29 04:32:03'),
(6, 'RSV-20260328-0006', 147, '2026-03-28', '2026-04-01', 3400000.00, 'checked_out', 'Qui porro dolor quidem.', 2, '2026-03-26 14:50:12', '2026-03-26 14:50:12'),
(7, 'RSV-20260625-0007', 35, '2026-06-25', '2026-06-27', 700000.00, 'checked_out', NULL, 2, '2026-06-23 17:26:53', '2026-06-23 17:26:53'),
(8, 'RSV-20260511-0008', 54, '2026-05-11', '2026-05-13', 1000000.00, 'checked_out', 'Labore molestias id sit porro.', 2, '2026-05-09 09:28:20', '2026-05-09 09:28:20'),
(9, 'RSV-20260831-0009', 20, '2026-08-31', '2026-09-03', 2550000.00, 'checked_out', NULL, 2, '2026-08-29 05:29:37', '2026-08-29 05:29:37'),
(10, 'RSV-20260717-0010', 89, '2026-07-17', '2026-07-21', 2000000.00, 'checked_out', 'Voluptatem beatae rerum aspernatur.', 2, '2026-07-15 13:43:41', '2026-07-15 13:43:41'),
(11, 'RSV-20260922-0011', 134, '2026-09-22', '2026-09-26', 1400000.00, 'confirmed', NULL, 2, '2026-09-20 08:03:55', '2026-09-20 08:03:55'),
(12, 'RSV-20260718-0012', 69, '2026-07-18', '2026-07-21', 1050000.00, 'checked_out', NULL, 2, '2026-07-16 02:12:31', '2026-07-16 02:12:31'),
(13, 'RSV-20260831-0013', 112, '2026-08-31', '2026-09-01', 350000.00, 'checked_out', NULL, 2, '2026-08-29 03:25:49', '2026-08-29 03:25:49'),
(14, 'RSV-20261010-0014', 55, '2026-10-10', '2026-10-15', 2500000.00, 'pending', NULL, 2, '2026-10-08 16:03:07', '2026-10-08 16:03:07'),
(15, 'RSV-20260818-0015', 15, '2026-08-18', '2026-08-19', 350000.00, 'cancelled', 'Sunt velit consequuntur eos autem.', 2, '2026-08-16 02:40:59', '2026-08-16 02:40:59'),
(16, 'RSV-20260502-0016', 133, '2026-05-02', '2026-05-04', 700000.00, 'checked_out', NULL, 2, '2026-04-30 16:49:55', '2026-04-30 16:49:55'),
(17, 'RSV-20260601-0017', 56, '2026-06-01', '2026-06-05', 1400000.00, 'checked_out', 'Ea maiores et eos qui.', 2, '2026-05-30 17:01:48', '2026-05-30 17:01:48'),
(18, 'RSV-20260819-0018', 143, '2026-08-19', '2026-08-24', 2500000.00, 'checked_out', 'Culpa autem et omnis sed harum natus voluptatem.', 2, '2026-08-17 15:29:20', '2026-08-17 15:29:20'),
(19, 'RSV-20260402-0019', 35, '2026-04-02', '2026-04-03', 350000.00, 'cancelled', NULL, 2, '2026-03-31 04:53:00', '2026-03-31 04:53:00'),
(20, 'RSV-20260609-0020', 16, '2026-06-09', '2026-06-10', 350000.00, 'checked_out', NULL, 2, '2026-06-07 02:55:57', '2026-06-07 02:55:57'),
(21, 'RSV-20260723-0021', 63, '2026-07-23', '2026-07-27', 3400000.00, 'checked_out', NULL, 2, '2026-07-21 07:44:13', '2026-07-21 07:44:13'),
(22, 'RSV-20260704-0022', 101, '2026-07-04', '2026-07-08', 3400000.00, 'checked_out', 'Molestias praesentium voluptas id sequi accusamus autem.', 2, '2026-07-02 02:57:45', '2026-07-02 02:57:45'),
(23, 'RSV-20260819-0023', 54, '2026-08-19', '2026-08-21', 1000000.00, 'checked_out', 'Ea asperiores odit animi doloremque et.', 2, '2026-08-17 01:03:40', '2026-08-17 01:03:40'),
(24, 'RSV-20260612-0024', 106, '2026-06-12', '2026-06-16', 1400000.00, 'checked_out', NULL, 2, '2026-06-10 20:29:39', '2026-06-10 20:29:39'),
(25, 'RSV-20260322-0025', 114, '2026-03-22', '2026-03-24', 700000.00, 'checked_out', NULL, 2, '2026-03-20 14:45:22', '2026-03-20 14:45:22'),
(26, 'RSV-20260824-0026', 132, '2026-08-24', '2026-08-25', 850000.00, 'checked_out', 'Omnis dignissimos omnis est quam consequatur odit explicabo.', 2, '2026-08-22 12:14:21', '2026-08-22 12:14:21'),
(27, 'RSV-20260423-0027', 129, '2026-04-23', '2026-04-27', 1400000.00, 'checked_out', NULL, 2, '2026-04-21 16:31:20', '2026-04-21 16:31:20'),
(28, 'RSV-20261002-0028', 60, '2026-10-02', '2026-10-07', 4250000.00, 'pending', 'Dignissimos ipsam eos ad.', 2, '2026-09-30 23:02:04', '2026-09-30 23:02:04'),
(29, 'RSV-20260418-0029', 135, '2026-04-18', '2026-04-19', 500000.00, 'checked_out', 'Delectus expedita minima earum nulla blanditiis sequi id sunt.', 2, '2026-04-16 22:42:15', '2026-04-16 22:42:15'),
(30, 'RSV-20260615-0030', 61, '2026-06-15', '2026-06-19', 3400000.00, 'checked_out', NULL, 2, '2026-06-13 17:47:25', '2026-06-13 17:47:25'),
(31, 'RSV-20260627-0031', 127, '2026-06-27', '2026-06-28', 500000.00, 'cancelled', NULL, 2, '2026-06-25 13:28:50', '2026-06-25 13:28:50'),
(32, 'RSV-20260428-0032', 150, '2026-04-28', '2026-05-03', 2500000.00, 'checked_out', NULL, 2, '2026-04-26 09:32:59', '2026-04-26 09:32:59'),
(33, 'RSV-20260910-0033', 135, '2026-09-10', '2026-09-13', 2550000.00, 'cancelled', 'Dignissimos dolor debitis illum vero.', 2, '2026-09-08 22:51:43', '2026-09-08 22:51:43'),
(34, 'RSV-20260921-0034', 16, '2026-09-21', '2026-09-24', 2550000.00, 'confirmed', 'Quaerat ad quod vitae blanditiis.', 2, '2026-09-19 04:40:25', '2026-09-19 04:40:25'),
(35, 'RSV-20260805-0035', 16, '2026-08-05', '2026-08-08', 2550000.00, 'checked_out', NULL, 2, '2026-08-03 15:55:10', '2026-08-03 15:55:10'),
(36, 'RSV-20260517-0036', 4, '2026-05-17', '2026-05-21', 2000000.00, 'checked_out', NULL, 2, '2026-05-15 06:25:06', '2026-05-15 06:25:06'),
(37, 'RSV-20260908-0037', 131, '2026-09-08', '2026-09-09', 500000.00, 'checked_out', 'Reprehenderit vel debitis qui voluptatum.', 2, '2026-09-06 23:39:11', '2026-09-06 23:39:11'),
(38, 'RSV-20261001-0038', 26, '2026-10-01', '2026-10-05', 3400000.00, 'pending', NULL, 2, '2026-09-29 14:21:57', '2026-09-29 14:21:57'),
(39, 'RSV-20260901-0039', 39, '2026-09-01', '2026-09-05', 3400000.00, 'checked_out', NULL, 2, '2026-08-30 13:21:59', '2026-08-30 13:21:59'),
(40, 'RSV-20260828-0040', 95, '2026-08-28', '2026-09-01', 2000000.00, 'checked_out', 'Ut quidem eos aperiam vel.', 2, '2026-08-26 12:18:11', '2026-08-26 12:18:11'),
(41, 'RSV-20260827-0041', 122, '2026-08-27', '2026-08-29', 700000.00, 'cancelled', 'Laborum iure voluptates officia id beatae architecto.', 2, '2026-08-25 01:36:32', '2026-08-25 01:36:32'),
(42, 'RSV-20260630-0042', 103, '2026-06-30', '2026-07-01', 850000.00, 'checked_out', 'Praesentium sapiente cumque quidem id aut.', 2, '2026-06-28 21:42:42', '2026-06-28 21:42:42'),
(43, 'RSV-20260628-0043', 125, '2026-06-28', '2026-07-02', 2000000.00, 'checked_out', NULL, 2, '2026-06-26 22:13:21', '2026-06-26 22:13:21'),
(44, 'RSV-20260531-0044', 70, '2026-05-31', '2026-06-02', 1700000.00, 'checked_out', NULL, 2, '2026-05-29 07:12:37', '2026-05-29 07:12:37'),
(45, 'RSV-20260723-0045', 42, '2026-07-23', '2026-07-27', 1400000.00, 'checked_out', NULL, 2, '2026-07-21 06:03:37', '2026-07-21 06:03:37'),
(46, 'RSV-20260713-0046', 87, '2026-07-13', '2026-07-15', 1700000.00, 'cancelled', NULL, 2, '2026-07-11 17:37:39', '2026-07-11 17:37:39'),
(47, 'RSV-20260814-0047', 115, '2026-08-14', '2026-08-18', 2000000.00, 'checked_out', 'Qui eius quia numquam alias doloremque accusantium.', 2, '2026-08-12 06:01:08', '2026-08-12 06:01:08'),
(48, 'RSV-20260603-0048', 7, '2026-06-03', '2026-06-06', 1500000.00, 'checked_out', NULL, 2, '2026-06-01 16:28:40', '2026-06-01 16:28:40'),
(49, 'RSV-20260525-0049', 148, '2026-05-25', '2026-05-29', 2000000.00, 'checked_out', NULL, 2, '2026-05-23 18:43:37', '2026-05-23 18:43:37'),
(50, 'RSV-20260723-0050', 79, '2026-07-23', '2026-07-24', 850000.00, 'checked_out', 'Fugit laudantium dignissimos voluptatem quam sit.', 2, '2026-07-21 01:23:49', '2026-07-21 01:23:49'),
(51, 'RSV-20260428-0051', 50, '2026-04-28', '2026-04-29', 350000.00, 'checked_out', NULL, 2, '2026-04-26 11:47:59', '2026-04-26 11:47:59'),
(52, 'RSV-20261008-0052', 60, '2026-10-08', '2026-10-13', 2500000.00, 'pending', 'Qui non et facere illo consequatur voluptatem.', 2, '2026-10-06 01:34:59', '2026-10-06 01:34:59'),
(53, 'RSV-20260905-0053', 114, '2026-09-05', '2026-09-06', 350000.00, 'cancelled', NULL, 2, '2026-09-03 18:42:39', '2026-09-03 18:42:39'),
(54, 'RSV-20260627-0054', 141, '2026-06-27', '2026-06-30', 1050000.00, 'checked_out', NULL, 2, '2026-06-25 11:16:30', '2026-06-25 11:16:30'),
(55, 'RSV-20261008-0055', 29, '2026-10-08', '2026-10-13', 1750000.00, 'pending', 'Officia corrupti non ea vel rerum aut doloribus.', 2, '2026-10-06 00:07:07', '2026-10-06 00:07:07'),
(56, 'RSV-20260715-0056', 136, '2026-07-15', '2026-07-17', 700000.00, 'checked_out', NULL, 2, '2026-07-13 04:38:57', '2026-07-13 04:38:57'),
(57, 'RSV-20260804-0057', 143, '2026-08-04', '2026-08-06', 1700000.00, 'checked_out', NULL, 2, '2026-08-02 07:17:22', '2026-08-02 07:17:22'),
(58, 'RSV-20260930-0058', 89, '2026-09-30', '2026-10-05', 2500000.00, 'pending', 'Debitis omnis neque quos iste.', 2, '2026-09-28 15:13:04', '2026-09-28 15:13:04'),
(59, 'RSV-20260918-0059', 137, '2026-09-18', '2026-09-19', 850000.00, 'checked_out', NULL, 2, '2026-09-16 01:42:54', '2026-09-16 01:42:54'),
(60, 'RSV-20261020-0060', 136, '2026-10-20', '2026-10-23', 2550000.00, 'pending', 'Dignissimos eos ut quia amet est laboriosam aut.', 2, '2026-10-18 08:31:38', '2026-10-18 08:31:38'),
(61, 'RSV-20260530-0061', 21, '2026-05-30', '2026-06-04', 1750000.00, 'checked_out', 'Modi excepturi et accusamus autem eligendi voluptatem rerum quia.', 2, '2026-05-28 08:33:51', '2026-05-28 08:33:51'),
(62, 'RSV-20260909-0062', 129, '2026-09-09', '2026-09-14', 2500000.00, 'checked_out', NULL, 2, '2026-09-07 17:23:01', '2026-09-07 17:23:01'),
(63, 'RSV-20260503-0063', 142, '2026-05-03', '2026-05-08', 1750000.00, 'checked_out', NULL, 2, '2026-05-01 08:49:59', '2026-05-01 08:49:59'),
(64, 'RSV-20260830-0064', 86, '2026-08-30', '2026-09-01', 1000000.00, 'checked_out', 'Voluptas aliquam mollitia quos quia debitis voluptas.', 2, '2026-08-28 05:57:56', '2026-08-28 05:57:56'),
(65, 'RSV-20260511-0065', 131, '2026-05-11', '2026-05-15', 2000000.00, 'checked_out', NULL, 2, '2026-05-09 15:04:34', '2026-05-09 15:04:34'),
(66, 'RSV-20260817-0066', 53, '2026-08-17', '2026-08-22', 1750000.00, 'checked_out', NULL, 2, '2026-08-15 20:35:31', '2026-08-15 20:35:31'),
(67, 'RSV-20260812-0067', 93, '2026-08-12', '2026-08-16', 2000000.00, 'checked_out', NULL, 2, '2026-08-10 06:25:09', '2026-08-10 06:25:09'),
(68, 'RSV-20260409-0068', 69, '2026-04-09', '2026-04-10', 850000.00, 'checked_out', 'Commodi voluptatem necessitatibus vitae in officia.', 2, '2026-04-07 08:46:23', '2026-04-07 08:46:23'),
(69, 'RSV-20260415-0069', 63, '2026-04-15', '2026-04-17', 700000.00, 'checked_out', NULL, 2, '2026-04-13 11:31:15', '2026-04-13 11:31:15'),
(70, 'RSV-20260526-0070', 24, '2026-05-26', '2026-05-28', 1000000.00, 'checked_out', NULL, 2, '2026-05-24 17:14:15', '2026-05-24 17:14:15'),
(71, 'RSV-20260426-0071', 59, '2026-04-26', '2026-04-29', 2550000.00, 'cancelled', NULL, 2, '2026-04-24 01:31:36', '2026-04-24 01:31:36'),
(72, 'RSV-20260407-0072', 50, '2026-04-07', '2026-04-08', 350000.00, 'cancelled', NULL, 2, '2026-04-05 20:40:11', '2026-04-05 20:40:11'),
(73, 'RSV-20260901-0073', 81, '2026-09-01', '2026-09-02', 500000.00, 'checked_out', NULL, 2, '2026-08-30 12:45:27', '2026-08-30 12:45:27'),
(74, 'RSV-20260819-0074', 52, '2026-08-19', '2026-08-23', 1400000.00, 'checked_out', NULL, 2, '2026-08-17 22:13:41', '2026-08-17 22:13:41'),
(75, 'RSV-20260507-0075', 4, '2026-05-07', '2026-05-09', 1000000.00, 'checked_out', 'Iste nemo tempora placeat rerum eligendi ut illo.', 2, '2026-05-05 21:12:11', '2026-05-05 21:12:11'),
(76, 'RSV-20260420-0076', 117, '2026-04-20', '2026-04-24', 2000000.00, 'checked_out', NULL, 2, '2026-04-18 07:40:30', '2026-04-18 07:40:30'),
(77, 'RSV-20260327-0077', 55, '2026-03-27', '2026-03-28', 500000.00, 'checked_out', NULL, 2, '2026-03-25 18:31:45', '2026-03-25 18:31:45'),
(78, 'RSV-20260715-0078', 35, '2026-07-15', '2026-07-19', 2000000.00, 'checked_out', NULL, 2, '2026-07-13 07:06:21', '2026-07-13 07:06:21'),
(79, 'RSV-20260805-0079', 136, '2026-08-05', '2026-08-09', 2000000.00, 'checked_out', NULL, 2, '2026-08-03 20:18:39', '2026-08-03 20:18:39'),
(80, 'RSV-20260423-0080', 65, '2026-04-23', '2026-04-25', 1000000.00, 'checked_out', NULL, 2, '2026-04-21 06:01:44', '2026-04-21 06:01:44'),
(81, 'RSV-20261014-0081', 96, '2026-10-14', '2026-10-17', 2550000.00, 'pending', NULL, 2, '2026-10-12 03:13:44', '2026-10-12 03:13:44'),
(82, 'RSV-20261014-0082', 138, '2026-10-14', '2026-10-19', 2500000.00, 'confirmed', 'Dolorem est et voluptatem qui veritatis.', 2, '2026-10-12 07:15:46', '2026-10-12 07:15:46'),
(83, 'RSV-20260807-0083', 134, '2026-08-07', '2026-08-11', 3400000.00, 'cancelled', NULL, 2, '2026-08-05 18:48:16', '2026-08-05 18:48:16'),
(84, 'RSV-20260507-0084', 11, '2026-05-07', '2026-05-10', 2550000.00, 'checked_out', NULL, 2, '2026-05-05 20:14:52', '2026-05-05 20:14:52'),
(85, 'RSV-20260516-0085', 23, '2026-05-16', '2026-05-18', 700000.00, 'checked_out', NULL, 2, '2026-05-14 17:32:33', '2026-05-14 17:32:33'),
(86, 'RSV-20260819-0086', 139, '2026-08-19', '2026-08-23', 3400000.00, 'checked_out', NULL, 2, '2026-08-17 19:13:01', '2026-08-17 19:13:01'),
(87, 'RSV-20260511-0087', 45, '2026-05-11', '2026-05-16', 1750000.00, 'checked_out', NULL, 2, '2026-05-09 12:34:42', '2026-05-09 12:34:42'),
(88, 'RSV-20260422-0088', 107, '2026-04-22', '2026-04-23', 350000.00, 'cancelled', NULL, 2, '2026-04-20 04:12:28', '2026-04-20 04:12:28'),
(89, 'RSV-20260331-0089', 100, '2026-03-31', '2026-04-01', 500000.00, 'checked_out', NULL, 2, '2026-03-29 03:06:06', '2026-03-29 03:06:06'),
(90, 'RSV-20260825-0090', 147, '2026-08-25', '2026-08-28', 1500000.00, 'checked_out', 'Error culpa laborum iusto sunt.', 2, '2026-08-23 06:20:04', '2026-08-23 06:20:04'),
(91, 'RSV-20261002-0091', 51, '2026-10-02', '2026-10-04', 700000.00, 'confirmed', NULL, 2, '2026-09-30 02:07:25', '2026-09-30 02:07:25'),
(92, 'RSV-20260826-0092', 135, '2026-08-26', '2026-08-30', 2000000.00, 'checked_out', NULL, 2, '2026-08-24 21:30:26', '2026-08-24 21:30:26'),
(93, 'RSV-20261008-0093', 74, '2026-10-08', '2026-10-13', 1750000.00, 'pending', 'Placeat repellendus deleniti accusantium eligendi eligendi et.', 2, '2026-10-06 09:33:20', '2026-10-06 09:33:20'),
(94, 'RSV-20260616-0094', 24, '2026-06-16', '2026-06-17', 850000.00, 'checked_out', 'Necessitatibus placeat ratione qui.', 2, '2026-06-14 01:07:14', '2026-06-14 01:07:14'),
(95, 'RSV-20260712-0095', 81, '2026-07-12', '2026-07-16', 2000000.00, 'checked_out', NULL, 2, '2026-07-10 18:09:57', '2026-07-10 18:09:57'),
(96, 'RSV-20260905-0096', 23, '2026-09-05', '2026-09-10', 2500000.00, 'checked_out', NULL, 2, '2026-09-03 20:36:05', '2026-09-03 20:36:05'),
(97, 'RSV-20261003-0097', 30, '2026-10-03', '2026-10-07', 2000000.00, 'pending', NULL, 2, '2026-10-01 04:25:36', '2026-10-01 04:25:36'),
(98, 'RSV-20260727-0098', 31, '2026-07-27', '2026-08-01', 2500000.00, 'checked_out', NULL, 2, '2026-07-25 06:24:07', '2026-07-25 06:24:07'),
(99, 'RSV-20260403-0099', 62, '2026-04-03', '2026-04-05', 700000.00, 'cancelled', NULL, 2, '2026-04-01 11:59:50', '2026-04-01 11:59:50'),
(100, 'RSV-20260929-0100', 1, '2026-09-29', '2026-10-03', 2000000.00, 'pending', NULL, 2, '2026-09-27 17:29:16', '2026-09-27 17:29:16'),
(101, 'RSV-20261012-0101', 131, '2026-10-12', '2026-10-16', 2000000.00, 'confirmed', NULL, 2, '2026-10-10 22:45:11', '2026-10-10 22:45:11'),
(102, 'RSV-20260511-0102', 78, '2026-05-11', '2026-05-16', 2500000.00, 'cancelled', NULL, 2, '2026-05-09 14:43:56', '2026-05-09 14:43:56'),
(103, 'RSV-20260823-0103', 8, '2026-08-23', '2026-08-26', 1050000.00, 'checked_out', NULL, 2, '2026-08-21 08:14:04', '2026-08-21 08:14:04'),
(104, 'RSV-20260923-0104', 89, '2026-09-23', '2026-09-24', 500000.00, 'confirmed', NULL, 2, '2026-09-21 20:51:30', '2026-09-21 20:51:30'),
(105, 'RSV-20260823-0105', 122, '2026-08-23', '2026-08-28', 1750000.00, 'checked_out', 'Omnis est ut ea placeat sunt deleniti animi minus.', 2, '2026-08-21 20:39:07', '2026-08-21 20:39:07'),
(106, 'RSV-20260415-0106', 68, '2026-04-15', '2026-04-20', 1750000.00, 'checked_out', NULL, 2, '2026-04-13 07:31:37', '2026-04-13 07:31:37'),
(107, 'RSV-20260802-0107', 37, '2026-08-02', '2026-08-03', 350000.00, 'cancelled', NULL, 2, '2026-07-31 02:53:22', '2026-07-31 02:53:22'),
(108, 'RSV-20260414-0108', 44, '2026-04-14', '2026-04-18', 2000000.00, 'checked_out', NULL, 2, '2026-04-12 18:42:57', '2026-04-12 18:42:57'),
(109, 'RSV-20260414-0109', 43, '2026-04-14', '2026-04-17', 1050000.00, 'cancelled', 'Sit quibusdam dolor fugiat impedit quia autem sed.', 2, '2026-04-12 18:41:31', '2026-04-12 18:41:31'),
(110, 'RSV-20260802-0110', 25, '2026-08-02', '2026-08-04', 700000.00, 'checked_out', 'Et aut expedita voluptatem magni eius est molestiae.', 2, '2026-07-31 06:00:57', '2026-07-31 06:00:57'),
(111, 'RSV-20260409-0111', 63, '2026-04-09', '2026-04-11', 1700000.00, 'checked_out', NULL, 2, '2026-04-07 07:48:51', '2026-04-07 07:48:51'),
(112, 'RSV-20260818-0112', 21, '2026-08-18', '2026-08-21', 1500000.00, 'cancelled', NULL, 2, '2026-08-16 19:27:50', '2026-08-16 19:27:50'),
(113, 'RSV-20260713-0113', 9, '2026-07-13', '2026-07-16', 1050000.00, 'checked_out', 'Odio dolorem molestias rem neque.', 2, '2026-07-11 03:43:03', '2026-07-11 03:43:03'),
(114, 'RSV-20260524-0114', 55, '2026-05-24', '2026-05-29', 2500000.00, 'cancelled', NULL, 2, '2026-05-22 15:07:39', '2026-05-22 15:07:39'),
(115, 'RSV-20260818-0115', 5, '2026-08-18', '2026-08-21', 1050000.00, 'cancelled', NULL, 2, '2026-08-16 15:12:45', '2026-08-16 15:12:45'),
(116, 'RSV-20260727-0116', 115, '2026-07-27', '2026-08-01', 4250000.00, 'cancelled', 'Necessitatibus laboriosam repellendus iure aut incidunt voluptate et.', 2, '2026-07-25 17:54:04', '2026-07-25 17:54:04'),
(117, 'RSV-20260710-0117', 141, '2026-07-10', '2026-07-13', 2550000.00, 'cancelled', NULL, 2, '2026-07-08 20:50:33', '2026-07-08 20:50:33'),
(118, 'RSV-20261022-0118', 43, '2026-10-22', '2026-10-26', 3400000.00, 'pending', NULL, 2, '2026-10-20 04:37:52', '2026-10-20 04:37:52'),
(119, 'RSV-20260506-0119', 80, '2026-05-06', '2026-05-08', 700000.00, 'checked_out', NULL, 2, '2026-05-04 15:30:00', '2026-05-04 15:30:00'),
(120, 'RSV-20260622-0120', 106, '2026-06-22', '2026-06-25', 1050000.00, 'cancelled', NULL, 2, '2026-06-20 21:22:52', '2026-06-20 21:22:52'),
(121, 'RSV-20260807-0121', 141, '2026-08-07', '2026-08-09', 700000.00, 'cancelled', 'Quidem corporis omnis eveniet molestiae at iure.', 2, '2026-08-05 11:16:04', '2026-08-05 11:16:04'),
(122, 'RSV-20260831-0122', 74, '2026-08-31', '2026-09-03', 1500000.00, 'checked_out', NULL, 2, '2026-08-29 06:02:52', '2026-08-29 06:02:52'),
(123, 'RSV-20260930-0123', 26, '2026-09-30', '2026-10-04', 2000000.00, 'pending', 'Non et iure ut vel consectetur ducimus explicabo iste.', 2, '2026-09-28 20:27:26', '2026-09-28 20:27:26'),
(124, 'RSV-20260722-0124', 145, '2026-07-22', '2026-07-24', 1000000.00, 'cancelled', NULL, 2, '2026-07-20 12:54:03', '2026-07-20 12:54:03'),
(125, 'RSV-20260607-0125', 65, '2026-06-07', '2026-06-09', 1700000.00, 'checked_out', 'Fuga culpa nihil vel necessitatibus voluptatem assumenda voluptatem.', 2, '2026-06-05 15:26:31', '2026-06-05 15:26:31'),
(126, 'RSV-20260925-0126', 23, '2026-09-25', '2026-09-26', 850000.00, 'confirmed', NULL, 2, '2026-09-23 16:33:21', '2026-09-23 16:33:21'),
(127, 'RSV-20260804-0127', 62, '2026-08-04', '2026-08-06', 1000000.00, 'cancelled', NULL, 2, '2026-08-02 14:03:32', '2026-08-02 14:03:32'),
(128, 'RSV-20260911-0128', 13, '2026-09-11', '2026-09-12', 850000.00, 'checked_out', NULL, 2, '2026-09-09 05:29:01', '2026-09-09 05:29:01'),
(129, 'RSV-20260807-0129', 6, '2026-08-07', '2026-08-10', 1050000.00, 'checked_out', 'Architecto non dolores necessitatibus nihil hic commodi.', 2, '2026-08-05 02:09:06', '2026-08-05 02:09:06'),
(130, 'RSV-20260504-0130', 118, '2026-05-04', '2026-05-05', 350000.00, 'checked_out', 'Autem voluptas ut sunt suscipit non.', 2, '2026-05-02 08:04:47', '2026-05-02 08:04:47'),
(131, 'RSV-20261011-0131', 27, '2026-10-11', '2026-10-16', 1750000.00, 'confirmed', NULL, 2, '2026-10-09 03:28:15', '2026-10-09 03:28:15'),
(132, 'RSV-20260819-0132', 87, '2026-08-19', '2026-08-20', 850000.00, 'cancelled', 'Voluptas quas at molestiae nihil consequatur animi.', 2, '2026-08-17 17:05:07', '2026-08-17 17:05:07'),
(133, 'RSV-20260920-0133', 41, '2026-09-20', '2026-09-21', 500000.00, 'checked_out', NULL, 2, '2026-09-18 05:11:33', '2026-09-18 05:11:33'),
(134, 'RSV-20260331-0134', 142, '2026-03-31', '2026-04-01', 350000.00, 'checked_out', NULL, 2, '2026-03-29 06:56:59', '2026-03-29 06:56:59'),
(135, 'RSV-20260628-0135', 10, '2026-06-28', '2026-07-02', 3400000.00, 'checked_out', NULL, 2, '2026-06-26 03:53:32', '2026-06-26 03:53:32'),
(136, 'RSV-20260609-0136', 34, '2026-06-09', '2026-06-14', 2500000.00, 'cancelled', NULL, 2, '2026-06-07 01:24:43', '2026-06-07 01:24:43'),
(137, 'RSV-20260616-0137', 105, '2026-06-16', '2026-06-21', 2500000.00, 'cancelled', NULL, 2, '2026-06-14 12:21:51', '2026-06-14 12:21:51'),
(138, 'RSV-20261016-0138', 31, '2026-10-16', '2026-10-19', 2550000.00, 'confirmed', 'Ex aut assumenda sed dicta blanditiis molestias commodi eos.', 2, '2026-10-14 01:09:17', '2026-10-14 01:09:17'),
(139, 'RSV-20260418-0139', 47, '2026-04-18', '2026-04-20', 1000000.00, 'checked_out', 'Sequi magni sit assumenda cum quos ea.', 2, '2026-04-16 17:54:20', '2026-04-16 17:54:20'),
(140, 'RSV-20260430-0140', 149, '2026-04-30', '2026-05-03', 1050000.00, 'checked_out', 'Sunt magni architecto qui et qui vitae fugit.', 2, '2026-04-28 18:51:18', '2026-04-28 18:51:18'),
(141, 'RSV-20261008-0141', 37, '2026-10-08', '2026-10-13', 4250000.00, 'confirmed', NULL, 2, '2026-10-06 22:04:39', '2026-10-06 22:04:39'),
(142, 'RSV-20260601-0142', 47, '2026-06-01', '2026-06-04', 1050000.00, 'cancelled', NULL, 2, '2026-05-30 05:10:04', '2026-05-30 05:10:04'),
(143, 'RSV-20260426-0143', 18, '2026-04-26', '2026-04-27', 350000.00, 'checked_out', NULL, 2, '2026-04-24 03:09:08', '2026-04-24 03:09:08'),
(144, 'RSV-20260508-0144', 71, '2026-05-08', '2026-05-10', 700000.00, 'checked_out', 'Ea cupiditate ut laudantium dolorem fugit qui est.', 2, '2026-05-06 14:20:05', '2026-05-06 14:20:05'),
(145, 'RSV-20260914-0145', 136, '2026-09-14', '2026-09-17', 1050000.00, 'checked_out', NULL, 2, '2026-09-12 06:01:21', '2026-09-12 06:01:21'),
(146, 'RSV-20260520-0146', 68, '2026-05-20', '2026-05-22', 1000000.00, 'checked_out', NULL, 2, '2026-05-18 01:01:29', '2026-05-18 01:01:29'),
(147, 'RSV-20260714-0147', 51, '2026-07-14', '2026-07-15', 500000.00, 'checked_out', 'Aut sapiente ut dignissimos et impedit.', 2, '2026-07-12 23:19:36', '2026-07-12 23:19:36'),
(148, 'RSV-20260810-0148', 141, '2026-08-10', '2026-08-11', 350000.00, 'cancelled', NULL, 2, '2026-08-08 01:29:16', '2026-08-08 01:29:16'),
(149, 'RSV-20260524-0149', 53, '2026-05-24', '2026-05-26', 700000.00, 'cancelled', NULL, 2, '2026-05-22 09:03:55', '2026-05-22 09:03:55'),
(150, 'RSV-20261020-0150', 27, '2026-10-20', '2026-10-24', 2000000.00, 'confirmed', NULL, 2, '2026-10-18 06:09:33', '2026-10-18 06:09:33'),
(151, 'RSV-20260518-0151', 29, '2026-05-18', '2026-05-20', 1000000.00, 'checked_out', NULL, 2, '2026-05-16 09:57:49', '2026-05-16 09:57:49'),
(152, 'RSV-20260610-0152', 38, '2026-06-10', '2026-06-11', 500000.00, 'checked_out', NULL, 2, '2026-06-08 18:53:18', '2026-06-08 18:53:18'),
(153, 'RSV-20260521-0153', 8, '2026-05-21', '2026-05-23', 700000.00, 'checked_out', NULL, 2, '2026-05-19 00:51:41', '2026-05-19 00:51:41'),
(154, 'RSV-20260802-0154', 52, '2026-08-02', '2026-08-04', 700000.00, 'cancelled', NULL, 2, '2026-07-31 07:27:53', '2026-07-31 07:27:53'),
(155, 'RSV-20260801-0155', 58, '2026-08-01', '2026-08-04', 2550000.00, 'checked_out', NULL, 2, '2026-07-30 20:22:45', '2026-07-30 20:22:45'),
(156, 'RSV-20260828-0156', 14, '2026-08-28', '2026-09-02', 4250000.00, 'checked_out', 'Tenetur ut consectetur sapiente eos.', 2, '2026-08-26 02:16:16', '2026-08-26 02:16:16'),
(157, 'RSV-20260412-0157', 138, '2026-04-12', '2026-04-13', 350000.00, 'cancelled', 'Eum ut sapiente ullam ut ut architecto ipsa.', 2, '2026-04-10 04:44:31', '2026-04-10 04:44:31'),
(158, 'RSV-20260923-0158', 47, '2026-09-23', '2026-09-26', 1500000.00, 'pending', NULL, 2, '2026-09-21 16:38:04', '2026-09-21 16:38:04'),
(159, 'RSV-20260419-0159', 117, '2026-04-19', '2026-04-21', 700000.00, 'checked_out', NULL, 2, '2026-04-17 08:53:47', '2026-04-17 08:53:47'),
(160, 'RSV-20260608-0160', 105, '2026-06-08', '2026-06-11', 1500000.00, 'checked_out', NULL, 2, '2026-06-06 22:15:07', '2026-06-06 22:15:07'),
(161, 'RSV-20260328-0161', 65, '2026-03-28', '2026-03-29', 850000.00, 'checked_out', NULL, 2, '2026-03-26 20:05:11', '2026-03-26 20:05:11'),
(162, 'RSV-20260728-0162', 7, '2026-07-28', '2026-08-02', 2500000.00, 'checked_out', NULL, 2, '2026-07-26 08:56:49', '2026-07-26 08:56:49'),
(163, 'RSV-20260708-0163', 125, '2026-07-08', '2026-07-11', 1500000.00, 'cancelled', 'Quibusdam harum qui voluptatem sint perspiciatis.', 2, '2026-07-06 23:18:17', '2026-07-06 23:18:17'),
(164, 'RSV-20261006-0164', 144, '2026-10-06', '2026-10-09', 1500000.00, 'confirmed', 'Ex dolorum pariatur expedita sequi voluptate ut harum et.', 2, '2026-10-04 18:02:24', '2026-10-04 18:02:24'),
(165, 'RSV-20260823-0165', 145, '2026-08-23', '2026-08-26', 1500000.00, 'checked_out', 'Inventore dolore ab ut saepe nemo.', 2, '2026-08-21 07:24:45', '2026-08-21 07:24:45'),
(166, 'RSV-20260727-0166', 130, '2026-07-27', '2026-07-28', 850000.00, 'checked_out', NULL, 2, '2026-07-25 22:31:50', '2026-07-25 22:31:50'),
(167, 'RSV-20260410-0167', 7, '2026-04-10', '2026-04-12', 700000.00, 'checked_out', NULL, 2, '2026-04-08 20:40:00', '2026-04-08 20:40:00'),
(168, 'RSV-20260927-0168', 43, '2026-09-27', '2026-09-28', 350000.00, 'pending', 'Rerum ut eos voluptatem nisi.', 2, '2026-09-25 13:23:06', '2026-09-25 13:23:06'),
(169, 'RSV-20260401-0169', 66, '2026-04-01', '2026-04-06', 2500000.00, 'checked_out', 'Sunt ipsum aut quis id consequatur.', 2, '2026-03-30 23:06:00', '2026-03-30 23:06:00'),
(170, 'RSV-20261014-0170', 80, '2026-10-14', '2026-10-17', 1500000.00, 'confirmed', 'Vero maiores eaque et doloremque excepturi ut.', 2, '2026-10-12 23:28:25', '2026-10-12 23:28:25'),
(171, 'RSV-20260602-0171', 61, '2026-06-02', '2026-06-07', 4250000.00, 'checked_out', 'Tenetur eos rerum fugit.', 2, '2026-05-31 14:58:22', '2026-05-31 14:58:22'),
(172, 'RSV-20260711-0172', 28, '2026-07-11', '2026-07-16', 1750000.00, 'checked_out', NULL, 2, '2026-07-09 23:27:52', '2026-07-09 23:27:52'),
(173, 'RSV-20260831-0173', 119, '2026-08-31', '2026-09-01', 500000.00, 'cancelled', NULL, 2, '2026-08-29 16:18:53', '2026-08-29 16:18:53'),
(174, 'RSV-20260922-0174', 54, '2026-09-22', '2026-09-24', 700000.00, 'pending', NULL, 2, '2026-09-20 20:47:34', '2026-09-20 20:47:34'),
(175, 'RSV-20260505-0175', 128, '2026-05-05', '2026-05-09', 3400000.00, 'cancelled', NULL, 2, '2026-05-03 00:53:52', '2026-05-03 00:53:52'),
(176, 'RSV-20260831-0176', 57, '2026-08-31', '2026-09-01', 500000.00, 'cancelled', NULL, 2, '2026-08-29 08:38:04', '2026-08-29 08:38:04'),
(177, 'RSV-20260618-0177', 67, '2026-06-18', '2026-06-19', 350000.00, 'cancelled', NULL, 2, '2026-06-16 14:48:37', '2026-06-16 14:48:37'),
(178, 'RSV-20260812-0178', 130, '2026-08-12', '2026-08-15', 1050000.00, 'checked_out', NULL, 2, '2026-08-10 10:34:30', '2026-08-10 10:34:30'),
(179, 'RSV-20260515-0179', 3, '2026-05-15', '2026-05-19', 1400000.00, 'checked_out', NULL, 2, '2026-05-13 08:27:41', '2026-05-13 08:27:41'),
(180, 'RSV-20261011-0180', 122, '2026-10-11', '2026-10-14', 1050000.00, 'confirmed', 'Nemo autem omnis corporis in.', 2, '2026-10-09 05:10:47', '2026-10-09 05:10:47'),
(181, 'RSV-20260603-0181', 25, '2026-06-03', '2026-06-04', 350000.00, 'checked_out', NULL, 2, '2026-06-01 00:17:12', '2026-06-01 00:17:12'),
(182, 'RSV-20260817-0182', 41, '2026-08-17', '2026-08-20', 1050000.00, 'checked_out', NULL, 2, '2026-08-15 20:54:56', '2026-08-15 20:54:56'),
(183, 'RSV-20261015-0183', 46, '2026-10-15', '2026-10-20', 4250000.00, 'confirmed', 'Voluptate enim ut sint nihil placeat omnis qui.', 2, '2026-10-13 03:03:55', '2026-10-13 03:03:55'),
(184, 'RSV-20260916-0184', 136, '2026-09-16', '2026-09-18', 1000000.00, 'checked_out', NULL, 2, '2026-09-14 18:20:48', '2026-09-14 18:20:48'),
(185, 'RSV-20260518-0185', 70, '2026-05-18', '2026-05-23', 1750000.00, 'checked_out', 'Et quia veritatis nulla quia.', 2, '2026-05-16 19:58:04', '2026-05-16 19:58:04'),
(186, 'RSV-20260804-0186', 43, '2026-08-04', '2026-08-07', 1500000.00, 'cancelled', 'Nihil rem eaque reiciendis vel.', 2, '2026-08-02 23:59:56', '2026-08-02 23:59:56'),
(187, 'RSV-20260605-0187', 87, '2026-06-05', '2026-06-08', 1500000.00, 'checked_out', NULL, 2, '2026-06-03 13:21:07', '2026-06-03 13:21:07'),
(188, 'RSV-20260331-0188', 18, '2026-03-31', '2026-04-04', 2000000.00, 'cancelled', 'Aliquam ipsum consectetur distinctio.', 2, '2026-03-29 00:23:55', '2026-03-29 00:23:55'),
(189, 'RSV-20260501-0189', 28, '2026-05-01', '2026-05-04', 1500000.00, 'checked_out', 'Harum harum et ut facere magni non aut.', 2, '2026-04-29 19:02:03', '2026-04-29 19:02:03'),
(190, 'RSV-20260819-0190', 133, '2026-08-19', '2026-08-21', 700000.00, 'checked_out', NULL, 2, '2026-08-17 23:10:00', '2026-08-17 23:10:00'),
(191, 'RSV-20260510-0191', 144, '2026-05-10', '2026-05-12', 1000000.00, 'checked_out', NULL, 2, '2026-05-08 02:49:21', '2026-05-08 02:49:21'),
(192, 'RSV-20261021-0192', 133, '2026-10-21', '2026-10-22', 350000.00, 'confirmed', NULL, 2, '2026-10-19 22:41:33', '2026-10-19 22:41:33'),
(193, 'RSV-20260518-0193', 125, '2026-05-18', '2026-05-22', 3400000.00, 'checked_out', NULL, 2, '2026-05-16 17:43:13', '2026-05-16 17:43:13'),
(194, 'RSV-20260822-0194', 40, '2026-08-22', '2026-08-24', 1700000.00, 'checked_out', NULL, 2, '2026-08-20 04:17:06', '2026-08-20 04:17:06'),
(195, 'RSV-20260615-0195', 75, '2026-06-15', '2026-06-20', 4250000.00, 'checked_out', 'Consequuntur voluptas exercitationem possimus eligendi velit error eos.', 2, '2026-06-13 09:44:39', '2026-06-13 09:44:39'),
(196, 'RSV-20260726-0196', 42, '2026-07-26', '2026-07-28', 1700000.00, 'cancelled', 'Saepe at ea a quam at amet.', 2, '2026-07-24 18:17:27', '2026-07-24 18:17:27'),
(197, 'RSV-20260418-0197', 103, '2026-04-18', '2026-04-23', 4250000.00, 'checked_out', NULL, 2, '2026-04-16 02:07:00', '2026-04-16 02:07:00'),
(198, 'RSV-20260606-0198', 39, '2026-06-06', '2026-06-07', 500000.00, 'cancelled', NULL, 2, '2026-06-04 01:13:59', '2026-06-04 01:13:59'),
(199, 'RSV-20260414-0199', 9, '2026-04-14', '2026-04-18', 2000000.00, 'checked_out', NULL, 2, '2026-04-12 20:30:05', '2026-04-12 20:30:05'),
(200, 'RSV-20260809-0200', 98, '2026-08-09', '2026-08-11', 700000.00, 'cancelled', NULL, 2, '2026-08-07 17:47:31', '2026-08-07 17:47:31'),
(201, 'RSV-20260930-0201', 110, '2026-09-30', '2026-10-04', 1400000.00, 'confirmed', NULL, 2, '2026-09-28 15:54:49', '2026-09-28 15:54:49'),
(202, 'RSV-20260919-0202', 123, '2026-09-19', '2026-09-24', 2500000.00, 'checked_in', NULL, 2, '2026-09-17 05:34:07', '2026-09-17 05:34:07'),
(203, 'RSV-20260605-0203', 135, '2026-06-05', '2026-06-07', 1000000.00, 'checked_out', NULL, 2, '2026-06-03 15:31:02', '2026-06-03 15:31:02'),
(204, 'RSV-20260706-0204', 87, '2026-07-06', '2026-07-11', 2500000.00, 'checked_out', NULL, 2, '2026-07-04 22:47:42', '2026-07-04 22:47:42'),
(205, 'RSV-20260401-0205', 61, '2026-04-01', '2026-04-06', 4250000.00, 'cancelled', NULL, 2, '2026-03-30 20:05:31', '2026-03-30 20:05:31'),
(206, 'RSV-20260825-0206', 74, '2026-08-25', '2026-08-26', 350000.00, 'cancelled', NULL, 2, '2026-08-23 03:18:42', '2026-08-23 03:18:42'),
(207, 'RSV-20260531-0207', 116, '2026-05-31', '2026-06-02', 1000000.00, 'checked_out', 'Qui pariatur reprehenderit veniam quis dolorem.', 2, '2026-05-29 18:55:21', '2026-05-29 18:55:21'),
(208, 'RSV-20260421-0208', 74, '2026-04-21', '2026-04-22', 350000.00, 'checked_out', NULL, 2, '2026-04-19 13:30:45', '2026-04-19 13:30:45'),
(209, 'RSV-20260625-0209', 142, '2026-06-25', '2026-06-30', 1750000.00, 'cancelled', 'Recusandae distinctio incidunt reprehenderit neque labore.', 2, '2026-06-23 23:25:58', '2026-06-23 23:25:58'),
(210, 'RSV-20260703-0210', 35, '2026-07-03', '2026-07-05', 1700000.00, 'checked_out', NULL, 2, '2026-07-01 08:59:49', '2026-07-01 08:59:49'),
(211, 'RSV-20260813-0211', 20, '2026-08-13', '2026-08-14', 500000.00, 'checked_out', 'Velit et harum eaque praesentium ab omnis iste.', 2, '2026-08-11 21:06:58', '2026-08-11 21:06:58'),
(212, 'RSV-20260917-0212', 115, '2026-09-17', '2026-09-22', 1750000.00, 'checked_out', NULL, 2, '2026-09-15 07:23:35', '2026-09-15 07:23:35'),
(213, 'RSV-20260410-0213', 125, '2026-04-10', '2026-04-14', 2000000.00, 'checked_out', NULL, 2, '2026-04-08 00:57:47', '2026-04-08 00:57:47'),
(214, 'RSV-20260425-0214', 25, '2026-04-25', '2026-04-29', 1400000.00, 'checked_out', NULL, 2, '2026-04-23 04:13:28', '2026-04-23 04:13:28'),
(215, 'RSV-20260619-0215', 63, '2026-06-19', '2026-06-24', 4250000.00, 'checked_out', NULL, 2, '2026-06-17 08:25:44', '2026-06-17 08:25:44'),
(216, 'RSV-20261016-0216', 9, '2026-10-16', '2026-10-17', 500000.00, 'pending', NULL, 2, '2026-10-14 08:47:13', '2026-10-14 08:47:13'),
(217, 'RSV-20260414-0217', 49, '2026-04-14', '2026-04-17', 1050000.00, 'checked_out', NULL, 2, '2026-04-12 02:43:12', '2026-04-12 02:43:12'),
(218, 'RSV-20260909-0218', 122, '2026-09-09', '2026-09-10', 350000.00, 'cancelled', 'Accusantium molestiae non necessitatibus blanditiis recusandae.', 2, '2026-09-07 12:07:32', '2026-09-07 12:07:32'),
(219, 'RSV-20260805-0219', 6, '2026-08-05', '2026-08-06', 350000.00, 'checked_out', 'Incidunt deleniti facere non animi esse.', 2, '2026-08-03 21:32:37', '2026-08-03 21:32:37'),
(220, 'RSV-20261005-0220', 24, '2026-10-05', '2026-10-06', 350000.00, 'confirmed', NULL, 2, '2026-10-03 03:11:09', '2026-10-03 03:11:09'),
(221, 'RSV-20260713-0221', 61, '2026-07-13', '2026-07-18', 2500000.00, 'checked_out', 'Blanditiis corrupti non vero eveniet.', 2, '2026-07-11 16:29:40', '2026-07-11 16:29:40'),
(222, 'RSV-20261002-0222', 77, '2026-10-02', '2026-10-06', 2000000.00, 'confirmed', NULL, 2, '2026-09-30 21:00:34', '2026-09-30 21:00:34'),
(223, 'RSV-20260523-0223', 73, '2026-05-23', '2026-05-28', 2500000.00, 'checked_out', 'Cumque expedita et quae rem quae illo.', 2, '2026-05-21 02:49:29', '2026-05-21 02:49:29'),
(224, 'RSV-20260809-0224', 86, '2026-08-09', '2026-08-11', 700000.00, 'checked_out', NULL, 2, '2026-08-07 05:09:18', '2026-08-07 05:09:18'),
(225, 'RSV-20260828-0225', 102, '2026-08-28', '2026-08-30', 1700000.00, 'checked_out', NULL, 2, '2026-08-26 23:58:52', '2026-08-26 23:58:52'),
(226, 'RSV-20260410-0226', 26, '2026-04-10', '2026-04-15', 1750000.00, 'checked_out', 'Enim ea pariatur quod consectetur harum ullam saepe.', 2, '2026-04-08 18:42:57', '2026-04-08 18:42:57'),
(227, 'RSV-20260620-0227', 109, '2026-06-20', '2026-06-22', 1700000.00, 'checked_out', NULL, 2, '2026-06-18 10:02:33', '2026-06-18 10:02:33'),
(228, 'RSV-20260830-0228', 118, '2026-08-30', '2026-08-31', 850000.00, 'checked_out', NULL, 2, '2026-08-28 19:31:09', '2026-08-28 19:31:09'),
(229, 'RSV-20260620-0229', 54, '2026-06-20', '2026-06-24', 2000000.00, 'cancelled', 'Ipsa voluptas maxime est sed molestiae quo.', 2, '2026-06-18 23:32:47', '2026-06-18 23:32:47'),
(230, 'RSV-20260707-0230', 4, '2026-07-07', '2026-07-09', 1000000.00, 'checked_out', 'Fugit adipisci eum magni aut omnis aliquam officia.', 2, '2026-07-05 20:30:45', '2026-07-05 20:30:45'),
(231, 'RSV-20260620-0231', 82, '2026-06-20', '2026-06-22', 1700000.00, 'checked_out', NULL, 2, '2026-06-18 09:25:37', '2026-06-18 09:25:37'),
(232, 'RSV-20260716-0232', 147, '2026-07-16', '2026-07-21', 4250000.00, 'checked_out', NULL, 2, '2026-07-14 05:15:23', '2026-07-14 05:15:23'),
(233, 'RSV-20260605-0233', 102, '2026-06-05', '2026-06-06', 500000.00, 'checked_out', NULL, 2, '2026-06-03 10:05:22', '2026-06-03 10:05:22'),
(234, 'RSV-20260506-0234', 98, '2026-05-06', '2026-05-09', 1050000.00, 'checked_out', NULL, 2, '2026-05-04 18:14:32', '2026-05-04 18:14:32'),
(235, 'RSV-20261020-0235', 108, '2026-10-20', '2026-10-22', 1000000.00, 'pending', 'Molestiae sit excepturi qui est.', 2, '2026-10-18 04:55:15', '2026-10-18 04:55:15'),
(236, 'RSV-20260515-0236', 36, '2026-05-15', '2026-05-19', 3400000.00, 'checked_out', NULL, 2, '2026-05-13 06:06:20', '2026-05-13 06:06:20'),
(237, 'RSV-20260711-0237', 107, '2026-07-11', '2026-07-16', 1750000.00, 'checked_out', 'Dolorem dolores ex dolorem quo delectus sit enim corporis.', 2, '2026-07-09 20:56:29', '2026-07-09 20:56:29'),
(238, 'RSV-20260809-0238', 7, '2026-08-09', '2026-08-14', 4250000.00, 'checked_out', NULL, 2, '2026-08-07 19:45:40', '2026-08-07 19:45:40'),
(239, 'RSV-20260605-0239', 68, '2026-06-05', '2026-06-07', 1000000.00, 'checked_out', 'Voluptatum quae enim assumenda.', 2, '2026-06-03 05:11:34', '2026-06-03 05:11:34'),
(240, 'RSV-20260820-0240', 104, '2026-08-20', '2026-08-25', 4250000.00, 'checked_out', NULL, 2, '2026-08-18 15:39:07', '2026-08-18 15:39:07'),
(241, 'RSV-20260915-0241', 36, '2026-09-15', '2026-09-20', 2500000.00, 'checked_out', 'Odio ut repellat dolorum itaque dolor id nisi.', 2, '2026-09-13 12:29:20', '2026-09-13 12:29:20'),
(242, 'RSV-20261006-0242', 30, '2026-10-06', '2026-10-09', 1050000.00, 'confirmed', NULL, 2, '2026-10-04 14:25:20', '2026-10-04 14:25:20'),
(243, 'RSV-20260731-0243', 134, '2026-07-31', '2026-08-05', 4250000.00, 'checked_out', NULL, 2, '2026-07-29 18:19:47', '2026-07-29 18:19:47'),
(244, 'RSV-20261012-0244', 13, '2026-10-12', '2026-10-13', 350000.00, 'confirmed', NULL, 2, '2026-10-10 06:38:32', '2026-10-10 06:38:32'),
(245, 'RSV-20260419-0245', 132, '2026-04-19', '2026-04-22', 1500000.00, 'checked_out', NULL, 2, '2026-04-17 00:40:43', '2026-04-17 00:40:43'),
(246, 'RSV-20260605-0246', 21, '2026-06-05', '2026-06-10', 4250000.00, 'cancelled', NULL, 2, '2026-06-03 09:18:26', '2026-06-03 09:18:26'),
(247, 'RSV-20260329-0247', 5, '2026-03-29', '2026-04-03', 2500000.00, 'checked_out', 'Sed ab culpa dignissimos unde dolores animi.', 2, '2026-03-27 18:32:29', '2026-03-27 18:32:29'),
(248, 'RSV-20260903-0248', 39, '2026-09-03', '2026-09-05', 1700000.00, 'cancelled', NULL, 2, '2026-09-01 07:16:19', '2026-09-01 07:16:19'),
(249, 'RSV-20261003-0249', 18, '2026-10-03', '2026-10-06', 2550000.00, 'pending', NULL, 2, '2026-10-01 05:26:05', '2026-10-01 05:26:05'),
(250, 'RSV-20260524-0250', 38, '2026-05-24', '2026-05-25', 350000.00, 'cancelled', NULL, 2, '2026-05-22 04:28:44', '2026-05-22 04:28:44'),
(251, 'RSV-20260329-0251', 6, '2026-03-29', '2026-04-02', 3400000.00, 'checked_out', 'Voluptatibus rerum quaerat id.', 2, '2026-03-27 08:57:27', '2026-03-27 08:57:27'),
(252, 'RSV-20260712-0252', 37, '2026-07-12', '2026-07-17', 4250000.00, 'checked_out', NULL, 2, '2026-07-10 15:06:26', '2026-07-10 15:06:26'),
(253, 'RSV-20260912-0253', 91, '2026-09-12', '2026-09-17', 1750000.00, 'cancelled', NULL, 2, '2026-09-10 13:28:15', '2026-09-10 13:28:15'),
(254, 'RSV-20260618-0254', 110, '2026-06-18', '2026-06-23', 4250000.00, 'checked_out', 'Doloribus ex laborum porro aut magni.', 2, '2026-06-16 20:11:43', '2026-06-16 20:11:43'),
(255, 'RSV-20260517-0255', 95, '2026-05-17', '2026-05-18', 850000.00, 'checked_out', 'Est quam vel harum aliquam omnis voluptates.', 2, '2026-05-15 19:05:09', '2026-05-15 19:05:09'),
(256, 'RSV-20260622-0256', 9, '2026-06-22', '2026-06-23', 350000.00, 'checked_out', 'Cupiditate laborum incidunt expedita dolorem et incidunt.', 2, '2026-06-20 02:33:48', '2026-06-20 02:33:48'),
(257, 'RSV-20260713-0257', 132, '2026-07-13', '2026-07-18', 4250000.00, 'checked_out', 'Minus soluta rem dolorem dignissimos ex qui eos.', 2, '2026-07-11 23:56:40', '2026-07-11 23:56:40'),
(258, 'RSV-20260903-0258', 132, '2026-09-03', '2026-09-07', 1400000.00, 'cancelled', NULL, 2, '2026-09-01 16:29:31', '2026-09-01 16:29:31'),
(259, 'RSV-20260324-0259', 52, '2026-03-24', '2026-03-27', 1050000.00, 'checked_out', NULL, 2, '2026-03-22 14:47:49', '2026-03-22 14:47:49'),
(260, 'RSV-20260402-0260', 96, '2026-04-02', '2026-04-06', 2000000.00, 'checked_out', NULL, 2, '2026-03-31 09:46:44', '2026-03-31 09:46:44'),
(261, 'RSV-20261014-0261', 77, '2026-10-14', '2026-10-16', 1700000.00, 'confirmed', NULL, 2, '2026-10-12 16:59:44', '2026-10-12 16:59:44'),
(262, 'RSV-20260510-0262', 11, '2026-05-10', '2026-05-15', 1750000.00, 'cancelled', 'Aut ipsa saepe accusamus exercitationem dolores ab.', 2, '2026-05-08 19:40:02', '2026-05-08 19:40:02'),
(263, 'RSV-20260523-0263', 137, '2026-05-23', '2026-05-28', 4250000.00, 'checked_out', NULL, 2, '2026-05-21 03:49:50', '2026-05-21 03:49:50'),
(264, 'RSV-20260416-0264', 97, '2026-04-16', '2026-04-21', 1750000.00, 'checked_out', NULL, 2, '2026-04-14 03:06:23', '2026-04-14 03:06:23'),
(265, 'RSV-20260404-0265', 108, '2026-04-04', '2026-04-07', 2550000.00, 'checked_out', NULL, 2, '2026-04-02 02:53:25', '2026-04-02 02:53:25'),
(266, 'RSV-20260325-0266', 11, '2026-03-25', '2026-03-28', 1500000.00, 'checked_out', NULL, 2, '2026-03-23 17:54:46', '2026-03-23 17:54:46'),
(267, 'RSV-20260507-0267', 44, '2026-05-07', '2026-05-08', 350000.00, 'checked_out', 'Reiciendis qui debitis occaecati cum.', 2, '2026-05-05 11:37:07', '2026-05-05 11:37:07'),
(268, 'RSV-20260822-0268', 1, '2026-08-22', '2026-08-24', 1700000.00, 'cancelled', 'Iure sint nobis expedita officia sit.', 2, '2026-08-20 14:50:52', '2026-08-20 14:50:52'),
(269, 'RSV-20260709-0269', 113, '2026-07-09', '2026-07-11', 700000.00, 'checked_out', NULL, 2, '2026-07-07 01:18:13', '2026-07-07 01:18:13'),
(270, 'RSV-20260401-0270', 130, '2026-04-01', '2026-04-05', 3400000.00, 'checked_out', 'Consequatur tempora officiis ullam et at ut eos.', 2, '2026-03-30 03:38:37', '2026-03-30 03:38:37'),
(271, 'RSV-20260503-0271', 116, '2026-05-03', '2026-05-08', 4250000.00, 'checked_out', 'Eveniet ea dolorem qui libero cum.', 2, '2026-05-01 11:15:50', '2026-05-01 11:15:50'),
(272, 'RSV-20260617-0272', 6, '2026-06-17', '2026-06-18', 350000.00, 'checked_out', NULL, 2, '2026-06-15 10:27:22', '2026-06-15 10:27:22'),
(273, 'RSV-20261013-0273', 112, '2026-10-13', '2026-10-16', 1050000.00, 'pending', NULL, 2, '2026-10-11 12:55:32', '2026-10-11 12:55:32'),
(274, 'RSV-20260520-0274', 39, '2026-05-20', '2026-05-23', 1050000.00, 'checked_out', NULL, 2, '2026-05-18 15:13:20', '2026-05-18 15:13:20'),
(275, 'RSV-20260331-0275', 86, '2026-03-31', '2026-04-03', 1050000.00, 'cancelled', 'Repellendus maiores vel aperiam.', 2, '2026-03-29 10:06:08', '2026-03-29 10:06:08'),
(276, 'RSV-20261016-0276', 21, '2026-10-16', '2026-10-20', 3400000.00, 'confirmed', NULL, 2, '2026-10-14 22:40:09', '2026-10-14 22:40:09'),
(277, 'RSV-20260926-0277', 31, '2026-09-26', '2026-09-28', 700000.00, 'confirmed', NULL, 2, '2026-09-24 11:57:13', '2026-09-24 11:57:13'),
(278, 'RSV-20261015-0278', 109, '2026-10-15', '2026-10-17', 1700000.00, 'pending', 'Aut molestiae est ea quo qui.', 2, '2026-10-13 21:48:55', '2026-10-13 21:48:55'),
(279, 'RSV-20261007-0279', 149, '2026-10-07', '2026-10-11', 3400000.00, 'pending', 'Eos sint qui ab laborum provident.', 2, '2026-10-05 20:01:18', '2026-10-05 20:01:18'),
(280, 'RSV-20260724-0280', 134, '2026-07-24', '2026-07-27', 2550000.00, 'checked_out', 'Dignissimos quidem omnis consectetur est.', 2, '2026-07-22 13:51:46', '2026-07-22 13:51:46'),
(281, 'RSV-20260608-0281', 56, '2026-06-08', '2026-06-09', 350000.00, 'checked_out', 'Voluptatum minima quisquam ut et voluptatem est.', 2, '2026-06-06 17:36:07', '2026-06-06 17:36:07'),
(282, 'RSV-20260324-0282', 69, '2026-03-24', '2026-03-29', 4250000.00, 'checked_out', NULL, 2, '2026-03-22 01:12:26', '2026-03-22 01:12:26'),
(283, 'RSV-20260918-0283', 111, '2026-09-18', '2026-09-19', 500000.00, 'checked_out', NULL, 2, '2026-09-16 08:44:22', '2026-09-16 08:44:22'),
(284, 'RSV-20260905-0284', 129, '2026-09-05', '2026-09-06', 500000.00, 'checked_out', NULL, 2, '2026-09-03 12:27:58', '2026-09-03 12:27:58'),
(285, 'RSV-20260916-0285', 125, '2026-09-16', '2026-09-20', 1400000.00, 'checked_out', 'Consequatur facilis nihil molestias molestiae deleniti dolor dolores qui.', 2, '2026-09-14 20:16:12', '2026-09-14 20:16:12'),
(286, 'RSV-20260903-0286', 34, '2026-09-03', '2026-09-08', 4250000.00, 'checked_out', 'Architecto qui temporibus repellendus consequuntur rerum odio accusamus.', 2, '2026-09-01 17:24:44', '2026-09-01 17:24:44'),
(287, 'RSV-20260406-0287', 107, '2026-04-06', '2026-04-08', 1700000.00, 'checked_out', NULL, 2, '2026-04-04 11:17:14', '2026-04-04 11:17:14'),
(288, 'RSV-20261019-0288', 108, '2026-10-19', '2026-10-24', 1750000.00, 'confirmed', 'Eligendi totam at tempore sunt.', 2, '2026-10-17 09:57:02', '2026-10-17 09:57:02'),
(289, 'RSV-20260510-0289', 78, '2026-05-10', '2026-05-12', 1700000.00, 'cancelled', NULL, 2, '2026-05-08 04:16:03', '2026-05-08 04:16:03'),
(290, 'RSV-20261010-0290', 99, '2026-10-10', '2026-10-13', 1050000.00, 'pending', NULL, 2, '2026-10-08 15:59:13', '2026-10-08 15:59:13'),
(291, 'RSV-20260813-0291', 80, '2026-08-13', '2026-08-18', 1750000.00, 'checked_out', NULL, 2, '2026-08-11 08:53:10', '2026-08-11 08:53:10'),
(292, 'RSV-20261014-0292', 49, '2026-10-14', '2026-10-15', 500000.00, 'pending', NULL, 2, '2026-10-12 13:09:50', '2026-10-12 13:09:50'),
(293, 'RSV-20260602-0293', 77, '2026-06-02', '2026-06-03', 350000.00, 'checked_out', 'Molestias est voluptatem maxime illum fugit.', 2, '2026-05-31 22:53:53', '2026-05-31 22:53:53'),
(294, 'RSV-20260620-0294', 128, '2026-06-20', '2026-06-25', 1750000.00, 'cancelled', NULL, 2, '2026-06-18 15:16:14', '2026-06-18 15:16:14'),
(295, 'RSV-20260824-0295', 101, '2026-08-24', '2026-08-27', 1500000.00, 'cancelled', NULL, 2, '2026-08-22 16:05:38', '2026-08-22 16:05:38'),
(296, 'RSV-20260429-0296', 8, '2026-04-29', '2026-05-04', 1750000.00, 'checked_out', 'Consequuntur recusandae dicta placeat iure dolorem qui.', 2, '2026-04-27 18:06:18', '2026-04-27 18:06:18'),
(297, 'RSV-20260804-0297', 18, '2026-08-04', '2026-08-06', 1000000.00, 'checked_out', NULL, 2, '2026-08-02 15:06:48', '2026-08-02 15:06:48'),
(298, 'RSV-20260807-0298', 85, '2026-08-07', '2026-08-12', 4250000.00, 'cancelled', 'Et quam ullam vel sequi nihil.', 2, '2026-08-05 21:51:55', '2026-08-05 21:51:55'),
(299, 'RSV-20260819-0299', 50, '2026-08-19', '2026-08-22', 2550000.00, 'checked_out', NULL, 2, '2026-08-17 11:37:25', '2026-08-17 11:37:25'),
(300, 'RSV-20260709-0300', 77, '2026-07-09', '2026-07-12', 1050000.00, 'checked_out', NULL, 2, '2026-07-07 21:11:39', '2026-07-07 21:11:39'),
(301, 'RSV-20260803-0301', 37, '2026-08-03', '2026-08-08', 4250000.00, 'checked_out', NULL, 2, '2026-08-01 11:32:42', '2026-08-01 11:32:42'),
(302, 'RSV-20260702-0302', 136, '2026-07-02', '2026-07-06', 2000000.00, 'checked_out', NULL, 2, '2026-06-30 02:43:52', '2026-06-30 02:43:52'),
(303, 'RSV-20260330-0303', 42, '2026-03-30', '2026-03-31', 850000.00, 'cancelled', NULL, 2, '2026-03-28 14:49:42', '2026-03-28 14:49:42'),
(304, 'RSV-20260613-0304', 111, '2026-06-13', '2026-06-17', 3400000.00, 'checked_out', 'Et quos odit praesentium consectetur.', 2, '2026-06-11 15:07:36', '2026-06-11 15:07:36'),
(305, 'RSV-20260727-0305', 22, '2026-07-27', '2026-08-01', 2500000.00, 'checked_out', NULL, 2, '2026-07-25 13:30:52', '2026-07-25 13:30:52'),
(306, 'RSV-20261006-0306', 31, '2026-10-06', '2026-10-08', 1700000.00, 'confirmed', NULL, 2, '2026-10-04 16:24:56', '2026-10-04 16:24:56'),
(307, 'RSV-20260924-0307', 141, '2026-09-24', '2026-09-28', 2000000.00, 'confirmed', NULL, 2, '2026-09-22 05:07:17', '2026-09-22 05:07:17'),
(308, 'RSV-20260814-0308', 11, '2026-08-14', '2026-08-19', 2500000.00, 'checked_out', NULL, 2, '2026-08-12 23:02:46', '2026-08-12 23:02:46'),
(309, 'RSV-20260808-0309', 41, '2026-08-08', '2026-08-11', 2550000.00, 'cancelled', NULL, 2, '2026-08-06 14:30:56', '2026-08-06 14:30:56'),
(310, 'RSV-20260714-0310', 105, '2026-07-14', '2026-07-17', 1500000.00, 'checked_out', NULL, 2, '2026-07-12 17:20:53', '2026-07-12 17:20:53'),
(311, 'RSV-20260819-0311', 123, '2026-08-19', '2026-08-23', 1400000.00, 'cancelled', 'Ut officia voluptas eum esse non id.', 2, '2026-08-17 17:23:55', '2026-08-17 17:23:55'),
(312, 'RSV-20260623-0312', 120, '2026-06-23', '2026-06-28', 2500000.00, 'checked_out', NULL, 2, '2026-06-21 06:21:31', '2026-06-21 06:21:31'),
(313, 'RSV-20260630-0313', 47, '2026-06-30', '2026-07-03', 2550000.00, 'cancelled', NULL, 2, '2026-06-28 03:28:00', '2026-06-28 03:28:00'),
(314, 'RSV-20260721-0314', 96, '2026-07-21', '2026-07-24', 1500000.00, 'checked_out', NULL, 2, '2026-07-19 13:26:05', '2026-07-19 13:26:05'),
(315, 'RSV-20260701-0315', 105, '2026-07-01', '2026-07-03', 1700000.00, 'checked_out', NULL, 2, '2026-06-29 16:10:24', '2026-06-29 16:10:24'),
(316, 'RSV-20260716-0316', 63, '2026-07-16', '2026-07-20', 2000000.00, 'checked_out', NULL, 2, '2026-07-14 05:51:51', '2026-07-14 05:51:51'),
(317, 'RSV-20260617-0317', 113, '2026-06-17', '2026-06-21', 3400000.00, 'checked_out', NULL, 2, '2026-06-15 21:43:42', '2026-06-15 21:43:42'),
(318, 'RSV-20260514-0318', 111, '2026-05-14', '2026-05-19', 1750000.00, 'checked_out', NULL, 2, '2026-05-12 05:57:06', '2026-05-12 05:57:06'),
(319, 'RSV-20260401-0319', 92, '2026-04-01', '2026-04-05', 2000000.00, 'cancelled', NULL, 2, '2026-03-30 10:26:11', '2026-03-30 10:26:11'),
(320, 'RSV-20260329-0320', 25, '2026-03-29', '2026-04-02', 3400000.00, 'checked_out', NULL, 2, '2026-03-27 12:48:38', '2026-03-27 12:48:38'),
(321, 'RSV-20260715-0321', 29, '2026-07-15', '2026-07-19', 1400000.00, 'checked_out', NULL, 2, '2026-07-13 15:50:16', '2026-07-13 15:50:16'),
(322, 'RSV-20260703-0322', 27, '2026-07-03', '2026-07-05', 1700000.00, 'cancelled', NULL, 2, '2026-07-01 21:58:00', '2026-07-01 21:58:00'),
(323, 'RSV-20260610-0323', 47, '2026-06-10', '2026-06-12', 1700000.00, 'cancelled', NULL, 2, '2026-06-08 13:39:37', '2026-06-08 13:39:37'),
(324, 'RSV-20260621-0324', 71, '2026-06-21', '2026-06-25', 3400000.00, 'checked_out', NULL, 2, '2026-06-19 00:04:16', '2026-06-19 00:04:16'),
(325, 'RSV-20260804-0325', 15, '2026-08-04', '2026-08-06', 700000.00, 'checked_out', NULL, 2, '2026-08-02 07:32:53', '2026-08-02 07:32:53'),
(326, 'RSV-20260625-0326', 102, '2026-06-25', '2026-06-28', 2550000.00, 'cancelled', NULL, 2, '2026-06-23 01:08:41', '2026-06-23 01:08:41'),
(327, 'RSV-20261003-0327', 15, '2026-10-03', '2026-10-06', 1500000.00, 'confirmed', NULL, 2, '2026-10-01 14:36:35', '2026-10-01 14:36:35');
INSERT INTO `reservations` (`id`, `reservation_code`, `guest_id`, `check_in_date`, `check_out_date`, `total_price`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(328, 'RSV-20260911-0328', 88, '2026-09-11', '2026-09-14', 1050000.00, 'checked_out', NULL, 2, '2026-09-09 04:03:40', '2026-09-09 04:03:40'),
(329, 'RSV-20260603-0329', 138, '2026-06-03', '2026-06-05', 1000000.00, 'checked_out', 'Impedit exercitationem eius et sit rerum nulla earum.', 2, '2026-06-01 04:57:11', '2026-06-01 04:57:11'),
(330, 'RSV-20260725-0330', 13, '2026-07-25', '2026-07-28', 2550000.00, 'checked_out', 'Magnam rerum tenetur vitae et ea sunt ab.', 2, '2026-07-23 13:31:41', '2026-07-23 13:31:41'),
(331, 'RSV-20260411-0331', 42, '2026-04-11', '2026-04-16', 1750000.00, 'checked_out', 'Quas et nam possimus ipsa consequatur.', 2, '2026-04-09 07:52:11', '2026-04-09 07:52:11'),
(332, 'RSV-20260917-0332', 83, '2026-09-17', '2026-09-18', 350000.00, 'checked_out', NULL, 2, '2026-09-15 00:50:53', '2026-09-15 00:50:53'),
(333, 'RSV-20260427-0333', 124, '2026-04-27', '2026-04-29', 700000.00, 'cancelled', NULL, 2, '2026-04-25 03:55:48', '2026-04-25 03:55:48'),
(334, 'RSV-20260607-0334', 4, '2026-06-07', '2026-06-09', 1000000.00, 'checked_out', NULL, 2, '2026-06-05 21:38:14', '2026-06-05 21:38:14'),
(335, 'RSV-20260814-0335', 2, '2026-08-14', '2026-08-17', 1500000.00, 'checked_out', NULL, 2, '2026-08-12 19:02:03', '2026-08-12 19:02:03'),
(336, 'RSV-20260829-0336', 8, '2026-08-29', '2026-09-01', 1050000.00, 'checked_out', NULL, 2, '2026-08-27 10:53:12', '2026-08-27 10:53:12'),
(337, 'RSV-20261015-0337', 113, '2026-10-15', '2026-10-19', 2000000.00, 'confirmed', NULL, 2, '2026-10-13 11:35:04', '2026-10-13 11:35:04'),
(338, 'RSV-20260604-0338', 28, '2026-06-04', '2026-06-09', 4250000.00, 'checked_out', NULL, 2, '2026-06-02 06:20:33', '2026-06-02 06:20:33'),
(339, 'RSV-20260929-0339', 80, '2026-09-29', '2026-10-03', 2000000.00, 'confirmed', NULL, 2, '2026-09-27 10:32:32', '2026-09-27 10:32:32'),
(340, 'RSV-20261004-0340', 84, '2026-10-04', '2026-10-09', 2500000.00, 'pending', NULL, 2, '2026-10-02 15:22:23', '2026-10-02 15:22:23'),
(341, 'RSV-20260419-0341', 148, '2026-04-19', '2026-04-23', 1400000.00, 'cancelled', NULL, 2, '2026-04-17 11:53:31', '2026-04-17 11:53:31'),
(342, 'RSV-20260814-0342', 86, '2026-08-14', '2026-08-16', 1000000.00, 'cancelled', 'Porro repellat consequuntur et quaerat nam dolor repudiandae.', 2, '2026-08-12 05:12:20', '2026-08-12 05:12:20'),
(343, 'RSV-20260703-0343', 30, '2026-07-03', '2026-07-06', 2550000.00, 'checked_out', NULL, 2, '2026-07-01 00:50:44', '2026-07-01 00:50:44'),
(344, 'RSV-20260604-0344', 128, '2026-06-04', '2026-06-09', 4250000.00, 'checked_out', NULL, 2, '2026-06-02 22:27:51', '2026-06-02 22:27:51'),
(345, 'RSV-20260616-0345', 138, '2026-06-16', '2026-06-17', 500000.00, 'checked_out', NULL, 2, '2026-06-14 02:37:01', '2026-06-14 02:37:01'),
(346, 'RSV-20260914-0346', 29, '2026-09-14', '2026-09-19', 2500000.00, 'cancelled', NULL, 2, '2026-09-12 00:17:41', '2026-09-12 00:17:41'),
(347, 'RSV-20260323-0347', 49, '2026-03-23', '2026-03-25', 700000.00, 'checked_out', NULL, 2, '2026-03-21 16:12:56', '2026-03-21 16:12:56'),
(348, 'RSV-20260724-0348', 80, '2026-07-24', '2026-07-29', 4250000.00, 'checked_out', NULL, 2, '2026-07-22 14:02:16', '2026-07-22 14:02:16'),
(349, 'RSV-20260610-0349', 21, '2026-06-10', '2026-06-14', 1400000.00, 'checked_out', NULL, 2, '2026-06-08 08:59:55', '2026-06-08 08:59:55'),
(350, 'RSV-20260801-0350', 98, '2026-08-01', '2026-08-02', 350000.00, 'cancelled', NULL, 2, '2026-07-30 12:08:31', '2026-07-30 12:08:31'),
(351, 'RSV-20260928-0351', 16, '2026-09-28', '2026-10-01', 1500000.00, 'pending', NULL, 2, '2026-09-26 19:35:08', '2026-09-26 19:35:08'),
(352, 'RSV-20261014-0352', 102, '2026-10-14', '2026-10-17', 2550000.00, 'confirmed', 'Repellendus molestiae vel similique veniam ducimus et aperiam.', 2, '2026-10-12 12:26:54', '2026-10-12 12:26:54'),
(353, 'RSV-20260406-0353', 116, '2026-04-06', '2026-04-09', 2550000.00, 'checked_out', 'Cupiditate minus aut aut.', 2, '2026-04-04 14:13:48', '2026-04-04 14:13:48'),
(354, 'RSV-20260514-0354', 30, '2026-05-14', '2026-05-18', 1400000.00, 'checked_out', 'Et eius eum velit unde maxime perspiciatis dolores.', 2, '2026-05-12 16:41:37', '2026-05-12 16:41:37'),
(355, 'RSV-20261019-0355', 23, '2026-10-19', '2026-10-22', 1050000.00, 'confirmed', NULL, 2, '2026-10-17 05:26:47', '2026-10-17 05:26:47'),
(356, 'RSV-20260709-0356', 6, '2026-07-09', '2026-07-10', 350000.00, 'checked_out', 'Hic neque voluptatum ea eveniet.', 2, '2026-07-07 20:44:15', '2026-07-07 20:44:15'),
(357, 'RSV-20260712-0357', 137, '2026-07-12', '2026-07-14', 1700000.00, 'checked_out', NULL, 2, '2026-07-10 23:51:39', '2026-07-10 23:51:39'),
(358, 'RSV-20260729-0358', 57, '2026-07-29', '2026-08-02', 2000000.00, 'cancelled', NULL, 2, '2026-07-27 19:28:18', '2026-07-27 19:28:18'),
(359, 'RSV-20260730-0359', 76, '2026-07-30', '2026-08-02', 1500000.00, 'checked_out', NULL, 2, '2026-07-28 20:44:52', '2026-07-28 20:44:52'),
(360, 'RSV-20260817-0360', 138, '2026-08-17', '2026-08-19', 1000000.00, 'checked_out', NULL, 2, '2026-08-15 20:46:55', '2026-08-15 20:46:55'),
(361, 'RSV-20261009-0361', 120, '2026-10-09', '2026-10-13', 2000000.00, 'pending', 'Dolorem cum iste est hic soluta.', 2, '2026-10-07 18:56:56', '2026-10-07 18:56:56'),
(362, 'RSV-20260911-0362', 43, '2026-09-11', '2026-09-16', 2500000.00, 'checked_out', NULL, 2, '2026-09-09 01:31:31', '2026-09-09 01:31:31'),
(363, 'RSV-20260701-0363', 78, '2026-07-01', '2026-07-03', 1000000.00, 'checked_out', NULL, 2, '2026-06-29 21:08:22', '2026-06-29 21:08:22'),
(364, 'RSV-20260601-0364', 38, '2026-06-01', '2026-06-02', 500000.00, 'checked_out', 'Qui rem quos sapiente et.', 2, '2026-05-30 09:02:44', '2026-05-30 09:02:44'),
(365, 'RSV-20260805-0365', 67, '2026-08-05', '2026-08-08', 1050000.00, 'cancelled', NULL, 2, '2026-08-03 02:40:39', '2026-08-03 02:40:39'),
(366, 'RSV-20260526-0366', 57, '2026-05-26', '2026-05-30', 3400000.00, 'checked_out', NULL, 2, '2026-05-24 15:38:46', '2026-05-24 15:38:46'),
(367, 'RSV-20260905-0367', 53, '2026-09-05', '2026-09-08', 1500000.00, 'cancelled', NULL, 2, '2026-09-03 15:28:24', '2026-09-03 15:28:24'),
(368, 'RSV-20260521-0368', 22, '2026-05-21', '2026-05-26', 1750000.00, 'checked_out', NULL, 2, '2026-05-19 09:57:16', '2026-05-19 09:57:16'),
(369, 'RSV-20260619-0369', 139, '2026-06-19', '2026-06-21', 700000.00, 'cancelled', NULL, 2, '2026-06-17 19:55:59', '2026-06-17 19:55:59'),
(370, 'RSV-20260621-0370', 125, '2026-06-21', '2026-06-25', 3400000.00, 'checked_out', NULL, 2, '2026-06-19 05:39:59', '2026-06-19 05:39:59'),
(371, 'RSV-20260627-0371', 103, '2026-06-27', '2026-06-29', 1000000.00, 'cancelled', 'Velit officia repellat qui eaque vel perspiciatis autem.', 2, '2026-06-25 13:09:34', '2026-06-25 13:09:34'),
(372, 'RSV-20260916-0372', 5, '2026-09-16', '2026-09-17', 350000.00, 'checked_out', NULL, 2, '2026-09-14 15:40:27', '2026-09-14 15:40:27'),
(373, 'RSV-20260825-0373', 49, '2026-08-25', '2026-08-29', 2000000.00, 'cancelled', NULL, 2, '2026-08-23 17:11:21', '2026-08-23 17:11:21'),
(374, 'RSV-20260729-0374', 78, '2026-07-29', '2026-08-01', 2550000.00, 'checked_out', 'Adipisci voluptatem nihil doloremque.', 2, '2026-07-27 00:08:35', '2026-07-27 00:08:35'),
(375, 'RSV-20260831-0375', 86, '2026-08-31', '2026-09-03', 1050000.00, 'cancelled', NULL, 2, '2026-08-29 14:53:25', '2026-08-29 14:53:25'),
(376, 'RSV-20260720-0376', 40, '2026-07-20', '2026-07-23', 2550000.00, 'checked_out', 'Harum et magni accusamus qui ad minus.', 2, '2026-07-18 13:16:10', '2026-07-18 13:16:10'),
(377, 'RSV-20260812-0377', 83, '2026-08-12', '2026-08-15', 1500000.00, 'cancelled', 'Soluta voluptatem aliquid ullam cum optio quos magni.', 2, '2026-08-10 06:53:09', '2026-08-10 06:53:09'),
(378, 'RSV-20260812-0378', 85, '2026-08-12', '2026-08-16', 3400000.00, 'checked_out', 'Sint repellat nam ut ducimus recusandae eum repudiandae.', 2, '2026-08-10 20:22:00', '2026-08-10 20:22:00'),
(379, 'RSV-20260525-0379', 4, '2026-05-25', '2026-05-26', 500000.00, 'checked_out', NULL, 2, '2026-05-23 07:23:24', '2026-05-23 07:23:24'),
(380, 'RSV-20260721-0380', 15, '2026-07-21', '2026-07-23', 1000000.00, 'cancelled', NULL, 2, '2026-07-19 15:20:23', '2026-07-19 15:20:23'),
(381, 'RSV-20260425-0381', 24, '2026-04-25', '2026-04-28', 1050000.00, 'checked_out', NULL, 2, '2026-04-23 04:13:31', '2026-04-23 04:13:31'),
(382, 'RSV-20260328-0382', 82, '2026-03-28', '2026-03-30', 1000000.00, 'checked_out', NULL, 2, '2026-03-26 07:14:43', '2026-03-26 07:14:43'),
(383, 'RSV-20260917-0383', 130, '2026-09-17', '2026-09-22', 2500000.00, 'checked_in', NULL, 2, '2026-09-15 15:14:50', '2026-09-15 15:14:50'),
(384, 'RSV-20260731-0384', 12, '2026-07-31', '2026-08-03', 2550000.00, 'checked_out', 'Fugiat labore ipsa labore mollitia asperiores.', 2, '2026-07-29 08:42:59', '2026-07-29 08:42:59'),
(385, 'RSV-20260531-0385', 36, '2026-05-31', '2026-06-01', 350000.00, 'checked_out', NULL, 2, '2026-05-29 14:31:37', '2026-05-29 14:31:37'),
(386, 'RSV-20260415-0386', 93, '2026-04-15', '2026-04-19', 1400000.00, 'checked_out', NULL, 2, '2026-04-13 22:30:03', '2026-04-13 22:30:03'),
(387, 'RSV-20260623-0387', 77, '2026-06-23', '2026-06-25', 700000.00, 'checked_out', NULL, 2, '2026-06-21 23:30:22', '2026-06-21 23:30:22'),
(388, 'RSV-20260927-0388', 139, '2026-09-27', '2026-10-02', 4250000.00, 'pending', 'Fugiat ducimus quia mollitia eum ea vel.', 2, '2026-09-25 01:30:21', '2026-09-25 01:30:21'),
(389, 'RSV-20260414-0389', 125, '2026-04-14', '2026-04-18', 2000000.00, 'cancelled', NULL, 2, '2026-04-12 19:58:23', '2026-04-12 19:58:23'),
(390, 'RSV-20260419-0390', 7, '2026-04-19', '2026-04-20', 350000.00, 'cancelled', NULL, 2, '2026-04-17 23:54:04', '2026-04-17 23:54:04'),
(391, 'RSV-20260705-0391', 104, '2026-07-05', '2026-07-08', 2550000.00, 'cancelled', 'Delectus officia dolore consectetur assumenda hic.', 2, '2026-07-03 16:49:22', '2026-07-03 16:49:22'),
(392, 'RSV-20260620-0392', 68, '2026-06-20', '2026-06-25', 2500000.00, 'checked_out', NULL, 2, '2026-06-18 22:02:41', '2026-06-18 22:02:41'),
(393, 'RSV-20260412-0393', 79, '2026-04-12', '2026-04-13', 500000.00, 'cancelled', NULL, 2, '2026-04-10 18:07:40', '2026-04-10 18:07:40'),
(394, 'RSV-20260829-0394', 16, '2026-08-29', '2026-09-02', 2000000.00, 'checked_out', NULL, 2, '2026-08-27 17:13:47', '2026-08-27 17:13:47'),
(395, 'RSV-20260901-0395', 7, '2026-09-01', '2026-09-05', 1400000.00, 'cancelled', 'In non facilis sit laborum recusandae rem et.', 2, '2026-08-30 13:34:52', '2026-08-30 13:34:52'),
(396, 'RSV-20260625-0396', 150, '2026-06-25', '2026-06-28', 1050000.00, 'checked_out', 'Iure sapiente dignissimos rem qui sit cumque dolorem quo.', 2, '2026-06-23 23:44:12', '2026-06-23 23:44:12'),
(397, 'RSV-20260508-0397', 45, '2026-05-08', '2026-05-13', 1750000.00, 'checked_out', 'At consequatur velit voluptates est.', 2, '2026-05-06 23:48:24', '2026-05-06 23:48:24'),
(398, 'RSV-20260710-0398', 148, '2026-07-10', '2026-07-11', 350000.00, 'cancelled', NULL, 2, '2026-07-08 10:13:59', '2026-07-08 10:13:59'),
(399, 'RSV-20260629-0399', 57, '2026-06-29', '2026-07-01', 700000.00, 'checked_out', NULL, 2, '2026-06-27 07:36:31', '2026-06-27 07:36:31'),
(400, 'RSV-20260327-0400', 131, '2026-03-27', '2026-03-29', 1700000.00, 'checked_out', NULL, 2, '2026-03-25 10:18:12', '2026-03-25 10:18:12'),
(401, 'RSV-20260803-0401', 61, '2026-08-03', '2026-08-04', 350000.00, 'cancelled', NULL, 2, '2026-08-01 05:26:36', '2026-08-01 05:26:36'),
(402, 'RSV-20260914-0402', 140, '2026-09-14', '2026-09-19', 4250000.00, 'checked_out', 'Autem velit officia qui ut ut dolorem est.', 2, '2026-09-12 14:04:15', '2026-09-12 14:04:15'),
(403, 'RSV-20260523-0403', 149, '2026-05-23', '2026-05-25', 1000000.00, 'cancelled', NULL, 2, '2026-05-21 14:16:43', '2026-05-21 14:16:43'),
(404, 'RSV-20260720-0404', 51, '2026-07-20', '2026-07-22', 1000000.00, 'checked_out', 'Vel vitae adipisci labore praesentium.', 2, '2026-07-18 04:29:04', '2026-07-18 04:29:04'),
(405, 'RSV-20260410-0405', 119, '2026-04-10', '2026-04-11', 500000.00, 'checked_out', 'Consequuntur voluptatem velit perspiciatis ut assumenda.', 2, '2026-04-08 00:35:08', '2026-04-08 00:35:08'),
(406, 'RSV-20260526-0406', 34, '2026-05-26', '2026-05-31', 4250000.00, 'checked_out', 'Non sit qui laboriosam doloremque.', 2, '2026-05-24 13:03:01', '2026-05-24 13:03:01'),
(407, 'RSV-20260814-0407', 71, '2026-08-14', '2026-08-16', 1000000.00, 'checked_out', 'Impedit eos enim enim voluptatem perspiciatis fugiat.', 2, '2026-08-12 18:19:09', '2026-08-12 18:19:09'),
(408, 'RSV-20260821-0408', 139, '2026-08-21', '2026-08-25', 3400000.00, 'checked_out', NULL, 2, '2026-08-19 20:09:21', '2026-08-19 20:09:21'),
(409, 'RSV-20260703-0409', 135, '2026-07-03', '2026-07-06', 1500000.00, 'cancelled', NULL, 2, '2026-07-01 21:28:03', '2026-07-01 21:28:03'),
(410, 'RSV-20260711-0410', 15, '2026-07-11', '2026-07-16', 4250000.00, 'checked_out', 'Exercitationem ut est perspiciatis id.', 2, '2026-07-09 05:45:09', '2026-07-09 05:45:09'),
(411, 'RSV-20260604-0411', 60, '2026-06-04', '2026-06-06', 1000000.00, 'cancelled', NULL, 2, '2026-06-02 13:07:20', '2026-06-02 13:07:20'),
(412, 'RSV-20260419-0412', 84, '2026-04-19', '2026-04-23', 1400000.00, 'checked_out', NULL, 2, '2026-04-17 18:25:48', '2026-04-17 18:25:48'),
(413, 'RSV-20260626-0413', 138, '2026-06-26', '2026-06-30', 1400000.00, 'checked_out', NULL, 2, '2026-06-24 07:00:50', '2026-06-24 07:00:50'),
(414, 'RSV-20260716-0414', 98, '2026-07-16', '2026-07-17', 350000.00, 'checked_out', NULL, 2, '2026-07-14 23:43:06', '2026-07-14 23:43:06'),
(415, 'RSV-20261009-0415', 38, '2026-10-09', '2026-10-11', 700000.00, 'pending', NULL, 2, '2026-10-07 03:57:18', '2026-10-07 03:57:18'),
(416, 'RSV-20260929-0416', 47, '2026-09-29', '2026-09-30', 350000.00, 'confirmed', NULL, 2, '2026-09-27 04:22:23', '2026-09-27 04:22:23'),
(417, 'RSV-20260710-0417', 112, '2026-07-10', '2026-07-13', 1050000.00, 'checked_out', NULL, 2, '2026-07-08 16:22:12', '2026-07-08 16:22:12'),
(418, 'RSV-20260925-0418', 75, '2026-09-25', '2026-09-28', 1050000.00, 'pending', NULL, 2, '2026-09-23 16:26:39', '2026-09-23 16:26:39'),
(419, 'RSV-20261020-0419', 97, '2026-10-20', '2026-10-24', 3400000.00, 'confirmed', NULL, 2, '2026-10-18 07:12:12', '2026-10-18 07:12:12'),
(420, 'RSV-20260411-0420', 9, '2026-04-11', '2026-04-13', 1000000.00, 'checked_out', NULL, 2, '2026-04-09 19:21:14', '2026-04-09 19:21:14'),
(421, 'RSV-20260722-0421', 63, '2026-07-22', '2026-07-27', 4250000.00, 'checked_out', NULL, 2, '2026-07-20 19:05:48', '2026-07-20 19:05:48'),
(422, 'RSV-20260529-0422', 3, '2026-05-29', '2026-06-03', 2500000.00, 'checked_out', 'Sit ea repudiandae sit est eum in rerum est.', 2, '2026-05-27 06:03:48', '2026-05-27 06:03:48'),
(423, 'RSV-20260519-0423', 150, '2026-05-19', '2026-05-21', 1000000.00, 'checked_out', NULL, 2, '2026-05-17 22:45:39', '2026-05-17 22:45:39'),
(424, 'RSV-20260910-0424', 74, '2026-09-10', '2026-09-14', 1400000.00, 'checked_out', NULL, 2, '2026-09-08 15:50:29', '2026-09-08 15:50:29'),
(425, 'RSV-20260813-0425', 39, '2026-08-13', '2026-08-18', 2500000.00, 'checked_out', NULL, 2, '2026-08-11 02:38:26', '2026-08-11 02:38:26'),
(426, 'RSV-20260602-0426', 63, '2026-06-02', '2026-06-03', 500000.00, 'cancelled', NULL, 2, '2026-05-31 15:24:40', '2026-05-31 15:24:40'),
(427, 'RSV-20260430-0427', 92, '2026-04-30', '2026-05-05', 2500000.00, 'checked_out', NULL, 2, '2026-04-28 22:46:11', '2026-04-28 22:46:11'),
(428, 'RSV-20260616-0428', 121, '2026-06-16', '2026-06-19', 1050000.00, 'checked_out', NULL, 2, '2026-06-14 01:46:43', '2026-06-14 01:46:43'),
(429, 'RSV-20260628-0429', 31, '2026-06-28', '2026-07-03', 4250000.00, 'checked_out', NULL, 2, '2026-06-26 07:41:48', '2026-06-26 07:41:48'),
(430, 'RSV-20260329-0430', 89, '2026-03-29', '2026-04-03', 1750000.00, 'checked_out', NULL, 2, '2026-03-27 11:33:37', '2026-03-27 11:33:37'),
(431, 'RSV-20260704-0431', 21, '2026-07-04', '2026-07-08', 2000000.00, 'checked_out', NULL, 2, '2026-07-02 13:05:27', '2026-07-02 13:05:27'),
(432, 'RSV-20260402-0432', 72, '2026-04-02', '2026-04-05', 2550000.00, 'checked_out', 'Praesentium dolorum dicta ea dolorem vel exercitationem illum ut.', 2, '2026-03-31 16:43:18', '2026-03-31 16:43:18'),
(433, 'RSV-20260915-0433', 99, '2026-09-15', '2026-09-18', 2550000.00, 'checked_out', NULL, 2, '2026-09-13 18:07:36', '2026-09-13 18:07:36'),
(434, 'RSV-20260529-0434', 112, '2026-05-29', '2026-06-02', 3400000.00, 'checked_out', NULL, 2, '2026-05-27 09:19:46', '2026-05-27 09:19:46'),
(435, 'RSV-20260402-0435', 26, '2026-04-02', '2026-04-06', 2000000.00, 'cancelled', NULL, 2, '2026-03-31 10:26:34', '2026-03-31 10:26:34'),
(436, 'RSV-20260613-0436', 118, '2026-06-13', '2026-06-15', 1000000.00, 'checked_out', 'Aut ducimus deserunt sint.', 2, '2026-06-11 23:39:50', '2026-06-11 23:39:50'),
(437, 'RSV-20260325-0437', 85, '2026-03-25', '2026-03-29', 3400000.00, 'cancelled', NULL, 2, '2026-03-23 17:15:43', '2026-03-23 17:15:43'),
(438, 'RSV-20260511-0438', 117, '2026-05-11', '2026-05-13', 700000.00, 'checked_out', NULL, 2, '2026-05-09 09:34:08', '2026-05-09 09:34:08'),
(439, 'RSV-20260328-0439', 87, '2026-03-28', '2026-03-29', 850000.00, 'checked_out', NULL, 2, '2026-03-26 04:27:05', '2026-03-26 04:27:05'),
(440, 'RSV-20260817-0440', 62, '2026-08-17', '2026-08-20', 1050000.00, 'cancelled', NULL, 2, '2026-08-15 17:53:34', '2026-08-15 17:53:34'),
(441, 'RSV-20260424-0441', 50, '2026-04-24', '2026-04-28', 2000000.00, 'checked_out', 'Ea non fuga explicabo qui at animi est dolores.', 2, '2026-04-22 00:26:35', '2026-04-22 00:26:35'),
(442, 'RSV-20260930-0442', 13, '2026-09-30', '2026-10-01', 850000.00, 'pending', NULL, 2, '2026-09-28 11:14:13', '2026-09-28 11:14:13'),
(443, 'RSV-20260418-0443', 116, '2026-04-18', '2026-04-19', 350000.00, 'cancelled', NULL, 2, '2026-04-16 01:30:00', '2026-04-16 01:30:00'),
(444, 'RSV-20260615-0444', 148, '2026-06-15', '2026-06-19', 3400000.00, 'cancelled', NULL, 2, '2026-06-13 20:01:40', '2026-06-13 20:01:40'),
(445, 'RSV-20260601-0445', 83, '2026-06-01', '2026-06-04', 1500000.00, 'checked_out', NULL, 2, '2026-05-30 11:24:48', '2026-05-30 11:24:48'),
(446, 'RSV-20260506-0446', 92, '2026-05-06', '2026-05-11', 4250000.00, 'cancelled', NULL, 2, '2026-05-04 18:00:54', '2026-05-04 18:00:54'),
(447, 'RSV-20260717-0447', 6, '2026-07-17', '2026-07-22', 4250000.00, 'cancelled', NULL, 2, '2026-07-15 05:54:20', '2026-07-15 05:54:20'),
(448, 'RSV-20260526-0448', 17, '2026-05-26', '2026-05-29', 2550000.00, 'checked_out', NULL, 2, '2026-05-24 01:23:06', '2026-05-24 01:23:06'),
(449, 'RSV-20260501-0449', 137, '2026-05-01', '2026-05-03', 700000.00, 'cancelled', 'Cumque aut consequuntur modi.', 2, '2026-04-29 17:45:54', '2026-04-29 17:45:54'),
(450, 'RSV-20260429-0450', 41, '2026-04-29', '2026-04-30', 350000.00, 'checked_out', NULL, 2, '2026-04-27 01:01:23', '2026-04-27 01:01:23'),
(451, 'RSV-20260507-0451', 102, '2026-05-07', '2026-05-10', 2550000.00, 'checked_out', NULL, 2, '2026-05-05 14:00:56', '2026-05-05 14:00:56'),
(452, 'RSV-20260531-0452', 127, '2026-05-31', '2026-06-01', 500000.00, 'checked_out', 'Non debitis qui earum fugiat.', 2, '2026-05-29 19:50:43', '2026-05-29 19:50:43'),
(453, 'RSV-20260529-0453', 70, '2026-05-29', '2026-06-03', 1750000.00, 'cancelled', NULL, 2, '2026-05-27 19:34:24', '2026-05-27 19:34:24'),
(454, 'RSV-20260930-0454', 36, '2026-09-30', '2026-10-04', 2000000.00, 'pending', 'Corrupti maiores aspernatur architecto.', 2, '2026-09-28 20:11:01', '2026-09-28 20:11:01'),
(455, 'RSV-20260520-0455', 80, '2026-05-20', '2026-05-22', 1000000.00, 'cancelled', NULL, 2, '2026-05-18 22:06:04', '2026-05-18 22:06:04'),
(456, 'RSV-20260609-0456', 25, '2026-06-09', '2026-06-14', 1750000.00, 'checked_out', 'Ut est aperiam vitae harum suscipit fuga.', 2, '2026-06-07 12:01:00', '2026-06-07 12:01:00'),
(457, 'RSV-20260711-0457', 6, '2026-07-11', '2026-07-15', 1400000.00, 'checked_out', NULL, 2, '2026-07-09 04:41:51', '2026-07-09 04:41:51'),
(458, 'RSV-20260427-0458', 118, '2026-04-27', '2026-05-01', 1400000.00, 'checked_out', 'Non nam doloribus maxime.', 2, '2026-04-25 19:54:44', '2026-04-25 19:54:44'),
(459, 'RSV-20260709-0459', 126, '2026-07-09', '2026-07-13', 3400000.00, 'checked_out', NULL, 2, '2026-07-07 14:08:47', '2026-07-07 14:08:47'),
(460, 'RSV-20260831-0460', 101, '2026-08-31', '2026-09-03', 2550000.00, 'checked_out', NULL, 2, '2026-08-29 08:47:54', '2026-08-29 08:47:54'),
(461, 'RSV-20260805-0461', 71, '2026-08-05', '2026-08-08', 1500000.00, 'checked_out', NULL, 2, '2026-08-03 23:47:34', '2026-08-03 23:47:34'),
(462, 'RSV-20261011-0462', 136, '2026-10-11', '2026-10-13', 1000000.00, 'confirmed', 'Sint quia laborum provident a nulla.', 2, '2026-10-09 09:49:48', '2026-10-09 09:49:48'),
(463, 'RSV-20260413-0463', 89, '2026-04-13', '2026-04-17', 2000000.00, 'cancelled', 'Laudantium non ad pariatur ea reprehenderit.', 2, '2026-04-11 06:16:18', '2026-04-11 06:16:18'),
(464, 'RSV-20260730-0464', 14, '2026-07-30', '2026-07-31', 850000.00, 'checked_out', 'Rerum nam molestias voluptas molestiae sed sit.', 2, '2026-07-28 00:42:22', '2026-07-28 00:42:22'),
(465, 'RSV-20261015-0465', 8, '2026-10-15', '2026-10-20', 2500000.00, 'confirmed', 'Et aspernatur inventore pariatur nostrum animi.', 2, '2026-10-13 20:14:55', '2026-10-13 20:14:55'),
(466, 'RSV-20260401-0466', 33, '2026-04-01', '2026-04-05', 1400000.00, 'checked_out', NULL, 2, '2026-03-30 16:01:18', '2026-03-30 16:01:18'),
(467, 'RSV-20260523-0467', 18, '2026-05-23', '2026-05-26', 1500000.00, 'cancelled', NULL, 2, '2026-05-21 13:57:58', '2026-05-21 13:57:58'),
(468, 'RSV-20260509-0468', 55, '2026-05-09', '2026-05-11', 1000000.00, 'checked_out', NULL, 2, '2026-05-07 21:14:55', '2026-05-07 21:14:55'),
(469, 'RSV-20260716-0469', 63, '2026-07-16', '2026-07-19', 2550000.00, 'checked_out', NULL, 2, '2026-07-14 15:46:20', '2026-07-14 15:46:20'),
(470, 'RSV-20260328-0470', 128, '2026-03-28', '2026-03-31', 1500000.00, 'checked_out', 'Itaque explicabo in aut maiores sed eos sit possimus.', 2, '2026-03-26 08:58:33', '2026-03-26 08:58:33'),
(471, 'RSV-20260708-0471', 12, '2026-07-08', '2026-07-13', 1750000.00, 'checked_out', NULL, 2, '2026-07-06 06:25:22', '2026-07-06 06:25:22'),
(472, 'RSV-20260521-0472', 150, '2026-05-21', '2026-05-24', 1050000.00, 'checked_out', NULL, 2, '2026-05-19 04:45:31', '2026-05-19 04:45:31'),
(473, 'RSV-20260505-0473', 77, '2026-05-05', '2026-05-08', 2550000.00, 'cancelled', 'Deleniti autem eaque mollitia rem non.', 2, '2026-05-03 19:56:32', '2026-05-03 19:56:32'),
(474, 'RSV-20261013-0474', 104, '2026-10-13', '2026-10-17', 3400000.00, 'pending', NULL, 2, '2026-10-11 22:00:40', '2026-10-11 22:00:40'),
(475, 'RSV-20260420-0475', 24, '2026-04-20', '2026-04-22', 700000.00, 'cancelled', NULL, 2, '2026-04-18 10:05:23', '2026-04-18 10:05:23'),
(476, 'RSV-20260515-0476', 60, '2026-05-15', '2026-05-18', 1050000.00, 'cancelled', NULL, 2, '2026-05-13 10:46:01', '2026-05-13 10:46:01'),
(477, 'RSV-20260816-0477', 43, '2026-08-16', '2026-08-20', 3400000.00, 'checked_out', 'Adipisci delectus molestiae aut ut enim nihil.', 2, '2026-08-14 17:27:12', '2026-08-14 17:27:12'),
(478, 'RSV-20260826-0478', 45, '2026-08-26', '2026-08-28', 1000000.00, 'checked_out', NULL, 2, '2026-08-24 13:07:31', '2026-08-24 13:07:31'),
(479, 'RSV-20260903-0479', 89, '2026-09-03', '2026-09-05', 1000000.00, 'checked_out', NULL, 2, '2026-09-01 02:41:40', '2026-09-01 02:41:40'),
(480, 'RSV-20260908-0480', 44, '2026-09-08', '2026-09-10', 1000000.00, 'cancelled', NULL, 2, '2026-09-06 16:15:58', '2026-09-06 16:15:58'),
(481, 'RSV-20260901-0481', 24, '2026-09-01', '2026-09-04', 1500000.00, 'checked_out', 'Id et ut quae.', 2, '2026-08-30 01:38:17', '2026-08-30 01:38:17'),
(482, 'RSV-20260820-0482', 140, '2026-08-20', '2026-08-22', 1000000.00, 'checked_out', NULL, 2, '2026-08-18 05:37:22', '2026-08-18 05:37:22'),
(483, 'RSV-20260808-0483', 71, '2026-08-08', '2026-08-12', 1400000.00, 'cancelled', NULL, 2, '2026-08-06 13:45:41', '2026-08-06 13:45:41'),
(484, 'RSV-20260618-0484', 75, '2026-06-18', '2026-06-20', 700000.00, 'checked_out', NULL, 2, '2026-06-16 13:50:41', '2026-06-16 13:50:41'),
(485, 'RSV-20260612-0485', 11, '2026-06-12', '2026-06-15', 1050000.00, 'checked_out', NULL, 2, '2026-06-10 08:31:48', '2026-06-10 08:31:48'),
(486, 'RSV-20260831-0486', 104, '2026-08-31', '2026-09-03', 1050000.00, 'checked_out', NULL, 2, '2026-08-29 02:45:28', '2026-08-29 02:45:28'),
(487, 'RSV-20260723-0487', 20, '2026-07-23', '2026-07-25', 1700000.00, 'cancelled', NULL, 2, '2026-07-21 11:20:01', '2026-07-21 11:20:01'),
(488, 'RSV-20260711-0488', 112, '2026-07-11', '2026-07-14', 2550000.00, 'cancelled', NULL, 2, '2026-07-09 11:46:28', '2026-07-09 11:46:28'),
(489, 'RSV-20260818-0489', 104, '2026-08-18', '2026-08-21', 2550000.00, 'checked_out', NULL, 2, '2026-08-16 15:56:45', '2026-08-16 15:56:45'),
(490, 'RSV-20260909-0490', 136, '2026-09-09', '2026-09-13', 1400000.00, 'checked_out', 'Voluptatem sed nihil quis eveniet nostrum.', 2, '2026-09-07 22:49:32', '2026-09-07 22:49:32'),
(491, 'RSV-20260828-0491', 80, '2026-08-28', '2026-09-01', 3400000.00, 'checked_out', NULL, 2, '2026-08-26 16:36:57', '2026-08-26 16:36:57'),
(492, 'RSV-20260801-0492', 16, '2026-08-01', '2026-08-02', 850000.00, 'cancelled', NULL, 2, '2026-07-30 15:05:16', '2026-07-30 15:05:16'),
(493, 'RSV-20260507-0493', 64, '2026-05-07', '2026-05-12', 2500000.00, 'checked_out', NULL, 2, '2026-05-05 08:02:57', '2026-05-05 08:02:57'),
(494, 'RSV-20260806-0494', 92, '2026-08-06', '2026-08-11', 4250000.00, 'cancelled', NULL, 2, '2026-08-04 08:33:05', '2026-08-04 08:33:05'),
(495, 'RSV-20260831-0495', 139, '2026-08-31', '2026-09-01', 500000.00, 'checked_out', NULL, 2, '2026-08-29 08:04:32', '2026-08-29 08:04:32'),
(496, 'RSV-20260711-0496', 107, '2026-07-11', '2026-07-12', 350000.00, 'cancelled', NULL, 2, '2026-07-09 16:09:41', '2026-07-09 16:09:41'),
(497, 'RSV-20260413-0497', 95, '2026-04-13', '2026-04-18', 1750000.00, 'cancelled', 'Nisi et eveniet quos perspiciatis aliquam.', 2, '2026-04-11 12:35:36', '2026-04-11 12:35:36'),
(498, 'RSV-20260426-0498', 60, '2026-04-26', '2026-05-01', 1750000.00, 'cancelled', NULL, 2, '2026-04-24 21:59:41', '2026-04-24 21:59:41'),
(499, 'RSV-20260512-0499', 101, '2026-05-12', '2026-05-14', 700000.00, 'checked_out', 'Quia voluptas ipsum magnam eum modi non quibusdam.', 2, '2026-05-10 05:52:14', '2026-05-10 05:52:14'),
(500, 'RSV-20260904-0500', 75, '2026-09-04', '2026-09-06', 700000.00, 'cancelled', NULL, 2, '2026-09-02 14:17:20', '2026-09-02 14:17:20'),
(501, 'RSV-20260815-0501', 73, '2026-08-15', '2026-08-16', 850000.00, 'checked_out', 'Magni rerum eveniet quae ea eum ut.', 2, '2026-08-13 18:20:27', '2026-08-13 18:20:27'),
(502, 'RSV-20260510-0502', 106, '2026-05-10', '2026-05-13', 2550000.00, 'checked_out', 'Maxime dolorum quo vero atque dolorem ut nihil.', 2, '2026-05-08 05:52:25', '2026-05-08 05:52:25'),
(503, 'RSV-20261009-0503', 141, '2026-10-09', '2026-10-10', 500000.00, 'confirmed', NULL, 2, '2026-10-07 04:19:56', '2026-10-07 04:19:56'),
(504, 'RSV-20260907-0504', 35, '2026-09-07', '2026-09-11', 2000000.00, 'checked_out', NULL, 2, '2026-09-05 16:29:46', '2026-09-05 16:29:46'),
(505, 'RSV-20260523-0505', 3, '2026-05-23', '2026-05-25', 700000.00, 'cancelled', NULL, 2, '2026-05-21 11:17:11', '2026-05-21 11:17:11'),
(506, 'RSV-20261008-0506', 144, '2026-10-08', '2026-10-09', 350000.00, 'confirmed', NULL, 2, '2026-10-06 16:49:53', '2026-10-06 16:49:53'),
(507, 'RSV-20260601-0507', 128, '2026-06-01', '2026-06-05', 2000000.00, 'checked_out', NULL, 2, '2026-05-30 12:38:57', '2026-05-30 12:38:57'),
(508, 'RSV-20260905-0508', 138, '2026-09-05', '2026-09-08', 1050000.00, 'checked_out', 'Ad sit et cupiditate rerum sint delectus.', 2, '2026-09-03 12:07:37', '2026-09-03 12:07:37'),
(509, 'RSV-20260823-0509', 131, '2026-08-23', '2026-08-25', 700000.00, 'checked_out', NULL, 2, '2026-08-21 22:50:24', '2026-08-21 22:50:24'),
(510, 'RSV-20260807-0510', 59, '2026-08-07', '2026-08-12', 2500000.00, 'checked_out', NULL, 2, '2026-08-05 00:39:49', '2026-08-05 00:39:49'),
(511, 'RSV-20260927-0511', 101, '2026-09-27', '2026-10-01', 3400000.00, 'pending', NULL, 2, '2026-09-25 01:25:59', '2026-09-25 01:25:59'),
(512, 'RSV-20260602-0512', 121, '2026-06-02', '2026-06-05', 1050000.00, 'checked_out', NULL, 2, '2026-05-31 16:46:33', '2026-05-31 16:46:33'),
(513, 'RSV-20260606-0513', 17, '2026-06-06', '2026-06-09', 1050000.00, 'checked_out', NULL, 2, '2026-06-04 10:39:27', '2026-06-04 10:39:27'),
(514, 'RSV-20260828-0514', 35, '2026-08-28', '2026-09-01', 1400000.00, 'checked_out', NULL, 2, '2026-08-26 14:04:28', '2026-08-26 14:04:28'),
(515, 'RSV-20261020-0515', 87, '2026-10-20', '2026-10-21', 500000.00, 'confirmed', 'Accusamus excepturi omnis nihil rerum sed ex harum quaerat.', 2, '2026-10-18 00:59:53', '2026-10-18 00:59:53'),
(516, 'RSV-20260727-0516', 143, '2026-07-27', '2026-07-30', 2550000.00, 'cancelled', 'Non vel temporibus quia velit dolore.', 2, '2026-07-25 05:43:07', '2026-07-25 05:43:07'),
(517, 'RSV-20260820-0517', 5, '2026-08-20', '2026-08-23', 1050000.00, 'cancelled', NULL, 2, '2026-08-18 10:11:34', '2026-08-18 10:11:34'),
(518, 'RSV-20260523-0518', 64, '2026-05-23', '2026-05-25', 700000.00, 'checked_out', 'Minima dolore ullam recusandae aut animi dolore.', 2, '2026-05-21 18:38:46', '2026-05-21 18:38:46'),
(519, 'RSV-20260516-0519', 140, '2026-05-16', '2026-05-21', 1750000.00, 'checked_out', NULL, 2, '2026-05-14 21:26:08', '2026-05-14 21:26:08'),
(520, 'RSV-20260711-0520', 140, '2026-07-11', '2026-07-12', 500000.00, 'checked_out', 'Velit aut quis qui id vel dignissimos inventore est.', 2, '2026-07-09 15:27:32', '2026-07-09 15:27:32'),
(521, 'RSV-20260624-0521', 117, '2026-06-24', '2026-06-25', 500000.00, 'checked_out', NULL, 2, '2026-06-22 20:40:17', '2026-06-22 20:40:17'),
(522, 'RSV-20260422-0522', 6, '2026-04-22', '2026-04-26', 1400000.00, 'checked_out', NULL, 2, '2026-04-20 04:15:56', '2026-04-20 04:15:56'),
(523, 'RSV-20260718-0523', 146, '2026-07-18', '2026-07-21', 1050000.00, 'checked_out', 'Ea facere in eaque veniam.', 2, '2026-07-16 07:54:18', '2026-07-16 07:54:18'),
(524, 'RSV-20260913-0524', 105, '2026-09-13', '2026-09-14', 350000.00, 'checked_out', NULL, 2, '2026-09-11 08:39:37', '2026-09-11 08:39:37'),
(525, 'RSV-20260710-0525', 94, '2026-07-10', '2026-07-11', 350000.00, 'checked_out', NULL, 2, '2026-07-08 06:43:03', '2026-07-08 06:43:03'),
(526, 'RSV-20260510-0526', 97, '2026-05-10', '2026-05-12', 1000000.00, 'checked_out', 'Blanditiis quae magni eius exercitationem dignissimos corrupti amet.', 2, '2026-05-08 01:44:09', '2026-05-08 01:44:09'),
(527, 'RSV-20260530-0527', 40, '2026-05-30', '2026-06-02', 1500000.00, 'checked_out', NULL, 2, '2026-05-28 11:48:52', '2026-05-28 11:48:52'),
(528, 'RSV-20260701-0528', 112, '2026-07-01', '2026-07-04', 1500000.00, 'checked_out', 'Ut neque rerum voluptatem velit commodi aut sed.', 2, '2026-06-29 23:32:59', '2026-06-29 23:32:59'),
(529, 'RSV-20260720-0529', 104, '2026-07-20', '2026-07-23', 2550000.00, 'checked_out', 'Corporis sit culpa qui laboriosam nemo.', 2, '2026-07-18 04:08:46', '2026-07-18 04:08:46'),
(530, 'RSV-20260703-0530', 46, '2026-07-03', '2026-07-04', 850000.00, 'checked_out', 'Labore cumque voluptates et explicabo tempora amet.', 2, '2026-07-01 21:49:14', '2026-07-01 21:49:14'),
(531, 'RSV-20260714-0531', 120, '2026-07-14', '2026-07-15', 350000.00, 'cancelled', NULL, 2, '2026-07-12 06:25:21', '2026-07-12 06:25:21'),
(532, 'RSV-20260509-0532', 131, '2026-05-09', '2026-05-12', 1050000.00, 'checked_out', NULL, 2, '2026-05-07 14:05:23', '2026-05-07 14:05:23'),
(533, 'RSV-20260728-0533', 91, '2026-07-28', '2026-07-29', 350000.00, 'checked_out', NULL, 2, '2026-07-26 09:56:50', '2026-07-26 09:56:50'),
(534, 'RSV-20260506-0534', 17, '2026-05-06', '2026-05-11', 1750000.00, 'checked_out', NULL, 2, '2026-05-04 22:14:35', '2026-05-04 22:14:35'),
(535, 'RSV-20260811-0535', 37, '2026-08-11', '2026-08-16', 2500000.00, 'cancelled', 'Provident nobis unde perferendis fugiat est quisquam aut.', 2, '2026-08-09 18:25:43', '2026-08-09 18:25:43'),
(536, 'RSV-20261021-0536', 36, '2026-10-21', '2026-10-26', 1750000.00, 'confirmed', NULL, 2, '2026-10-19 03:35:58', '2026-10-19 03:35:58'),
(537, 'RSV-20260407-0537', 66, '2026-04-07', '2026-04-08', 350000.00, 'checked_out', 'Magnam et doloribus odit saepe cupiditate.', 2, '2026-04-05 10:59:14', '2026-04-05 10:59:14'),
(538, 'RSV-20260328-0538', 133, '2026-03-28', '2026-03-30', 1700000.00, 'checked_out', 'Nihil quas molestiae laboriosam corporis.', 2, '2026-03-26 20:35:44', '2026-03-26 20:35:44'),
(539, 'RSV-20260813-0539', 99, '2026-08-13', '2026-08-18', 1750000.00, 'cancelled', 'Est vel sequi cupiditate eaque mollitia asperiores doloremque.', 2, '2026-08-11 00:07:42', '2026-08-11 00:07:42'),
(540, 'RSV-20260920-0540', 91, '2026-09-20', '2026-09-23', 1050000.00, 'checked_in', NULL, 2, '2026-09-18 21:35:01', '2026-09-18 21:35:01'),
(541, 'RSV-20260629-0541', 103, '2026-06-29', '2026-07-02', 1500000.00, 'checked_out', NULL, 2, '2026-06-27 00:19:08', '2026-06-27 00:19:08'),
(542, 'RSV-20260819-0542', 22, '2026-08-19', '2026-08-23', 2000000.00, 'cancelled', NULL, 2, '2026-08-17 23:10:29', '2026-08-17 23:10:29'),
(543, 'RSV-20260923-0543', 120, '2026-09-23', '2026-09-24', 500000.00, 'confirmed', NULL, 2, '2026-09-21 16:30:45', '2026-09-21 16:30:45'),
(544, 'RSV-20260710-0544', 29, '2026-07-10', '2026-07-15', 1750000.00, 'checked_out', NULL, 2, '2026-07-08 06:05:29', '2026-07-08 06:05:29'),
(545, 'RSV-20260727-0545', 39, '2026-07-27', '2026-07-28', 850000.00, 'checked_out', 'Omnis sit nisi reiciendis ut.', 2, '2026-07-25 00:28:11', '2026-07-25 00:28:11'),
(546, 'RSV-20260909-0546', 78, '2026-09-09', '2026-09-13', 3400000.00, 'cancelled', NULL, 2, '2026-09-07 19:04:30', '2026-09-07 19:04:30'),
(547, 'RSV-20260726-0547', 61, '2026-07-26', '2026-07-27', 850000.00, 'checked_out', 'Eveniet quis enim error repellendus cumque pariatur accusamus.', 2, '2026-07-24 04:59:45', '2026-07-24 04:59:45'),
(548, 'RSV-20260415-0548', 140, '2026-04-15', '2026-04-19', 1400000.00, 'checked_out', 'Ad sit nisi et est ut deleniti.', 2, '2026-04-13 21:00:34', '2026-04-13 21:00:34'),
(549, 'RSV-20260331-0549', 25, '2026-03-31', '2026-04-01', 500000.00, 'checked_out', 'Dicta quae ut et omnis doloremque.', 2, '2026-03-29 17:14:58', '2026-03-29 17:14:58'),
(550, 'RSV-20261011-0550', 10, '2026-10-11', '2026-10-15', 1400000.00, 'confirmed', NULL, 2, '2026-10-09 12:19:45', '2026-10-09 12:19:45'),
(551, 'RSV-20260509-0551', 113, '2026-05-09', '2026-05-14', 1750000.00, 'cancelled', NULL, 2, '2026-05-07 20:50:20', '2026-05-07 20:50:20'),
(552, 'RSV-20260724-0552', 94, '2026-07-24', '2026-07-26', 1000000.00, 'checked_out', NULL, 2, '2026-07-22 10:13:53', '2026-07-22 10:13:53'),
(553, 'RSV-20260806-0553', 37, '2026-08-06', '2026-08-09', 1500000.00, 'checked_out', NULL, 2, '2026-08-04 14:32:45', '2026-08-04 14:32:45'),
(554, 'RSV-20260401-0554', 144, '2026-04-01', '2026-04-02', 850000.00, 'checked_out', NULL, 2, '2026-03-30 01:51:00', '2026-03-30 01:51:00'),
(555, 'RSV-20261008-0555', 148, '2026-10-08', '2026-10-12', 3400000.00, 'pending', NULL, 2, '2026-10-06 19:44:05', '2026-10-06 19:44:05'),
(556, 'RSV-20260508-0556', 72, '2026-05-08', '2026-05-11', 1050000.00, 'cancelled', 'Illum nam quia ipsam dolorum numquam qui hic.', 2, '2026-05-06 21:44:50', '2026-05-06 21:44:50'),
(557, 'RSV-20261020-0557', 113, '2026-10-20', '2026-10-25', 1750000.00, 'pending', NULL, 2, '2026-10-18 14:26:39', '2026-10-18 14:26:39'),
(558, 'RSV-20260712-0558', 132, '2026-07-12', '2026-07-17', 4250000.00, 'cancelled', 'Libero ut laboriosam voluptatum illum doloribus dolorem voluptatem.', 2, '2026-07-10 01:58:00', '2026-07-10 01:58:00'),
(559, 'RSV-20260409-0559', 49, '2026-04-09', '2026-04-11', 1000000.00, 'checked_out', 'Velit est adipisci quisquam blanditiis in.', 2, '2026-04-07 16:30:23', '2026-04-07 16:30:23'),
(560, 'RSV-20260623-0560', 30, '2026-06-23', '2026-06-25', 1000000.00, 'checked_out', NULL, 2, '2026-06-21 03:47:08', '2026-06-21 03:47:08'),
(561, 'RSV-20261007-0561', 40, '2026-10-07', '2026-10-11', 2000000.00, 'confirmed', NULL, 2, '2026-10-05 13:14:56', '2026-10-05 13:14:56'),
(562, 'RSV-20260506-0562', 83, '2026-05-06', '2026-05-08', 700000.00, 'checked_out', NULL, 2, '2026-05-04 07:43:17', '2026-05-04 07:43:17'),
(563, 'RSV-20260526-0563', 2, '2026-05-26', '2026-05-29', 1500000.00, 'checked_out', NULL, 2, '2026-05-24 04:13:08', '2026-05-24 04:13:08'),
(564, 'RSV-20260519-0564', 5, '2026-05-19', '2026-05-20', 350000.00, 'checked_out', NULL, 2, '2026-05-17 17:47:50', '2026-05-17 17:47:50'),
(565, 'RSV-20260729-0565', 38, '2026-07-29', '2026-08-02', 1400000.00, 'checked_out', NULL, 2, '2026-07-27 04:04:45', '2026-07-27 04:04:45'),
(566, 'RSV-20260511-0566', 15, '2026-05-11', '2026-05-15', 3400000.00, 'checked_out', NULL, 2, '2026-05-09 08:54:14', '2026-05-09 08:54:14'),
(567, 'RSV-20260727-0567', 73, '2026-07-27', '2026-07-28', 500000.00, 'checked_out', NULL, 2, '2026-07-25 18:13:24', '2026-07-25 18:13:24'),
(568, 'RSV-20260826-0568', 149, '2026-08-26', '2026-08-31', 2500000.00, 'checked_out', 'Aut numquam suscipit reiciendis labore qui maiores.', 2, '2026-08-24 02:33:46', '2026-08-24 02:33:46'),
(569, 'RSV-20260826-0569', 113, '2026-08-26', '2026-08-28', 1700000.00, 'cancelled', NULL, 2, '2026-08-24 09:03:01', '2026-08-24 09:03:01'),
(570, 'RSV-20260708-0570', 31, '2026-07-08', '2026-07-11', 2550000.00, 'checked_out', NULL, 2, '2026-07-06 00:19:01', '2026-07-06 00:19:01'),
(571, 'RSV-20260803-0571', 12, '2026-08-03', '2026-08-05', 1000000.00, 'checked_out', NULL, 2, '2026-08-01 18:34:42', '2026-08-01 18:34:42'),
(572, 'RSV-20260523-0572', 131, '2026-05-23', '2026-05-26', 1050000.00, 'checked_out', 'Aliquid nostrum perspiciatis explicabo atque blanditiis.', 2, '2026-05-21 14:51:25', '2026-05-21 14:51:25'),
(573, 'RSV-20260709-0573', 34, '2026-07-09', '2026-07-10', 500000.00, 'checked_out', 'Ipsa voluptatem hic animi qui.', 2, '2026-07-07 04:39:43', '2026-07-07 04:39:43'),
(574, 'RSV-20260625-0574', 70, '2026-06-25', '2026-06-28', 2550000.00, 'checked_out', 'Laboriosam ut praesentium consectetur et ea unde voluptas aut.', 2, '2026-06-23 07:23:16', '2026-06-23 07:23:16'),
(575, 'RSV-20260502-0575', 76, '2026-05-02', '2026-05-06', 3400000.00, 'checked_out', NULL, 2, '2026-04-30 11:36:39', '2026-04-30 11:36:39'),
(576, 'RSV-20260608-0576', 32, '2026-06-08', '2026-06-10', 1700000.00, 'checked_out', NULL, 2, '2026-06-06 20:21:47', '2026-06-06 20:21:47'),
(577, 'RSV-20260325-0577', 145, '2026-03-25', '2026-03-30', 1750000.00, 'checked_out', NULL, 2, '2026-03-23 00:38:16', '2026-03-23 00:38:16'),
(578, 'RSV-20260819-0578', 118, '2026-08-19', '2026-08-20', 500000.00, 'cancelled', NULL, 2, '2026-08-17 09:12:26', '2026-08-17 09:12:26'),
(579, 'RSV-20260516-0579', 89, '2026-05-16', '2026-05-17', 350000.00, 'cancelled', NULL, 2, '2026-05-14 06:16:25', '2026-05-14 06:16:25'),
(580, 'RSV-20260418-0580', 17, '2026-04-18', '2026-04-22', 3400000.00, 'checked_out', NULL, 2, '2026-04-16 20:22:20', '2026-04-16 20:22:20'),
(581, 'RSV-20260817-0581', 87, '2026-08-17', '2026-08-20', 2550000.00, 'checked_out', 'Aut assumenda hic doloremque molestiae voluptate.', 2, '2026-08-15 17:10:55', '2026-08-15 17:10:55'),
(582, 'RSV-20260806-0582', 105, '2026-08-06', '2026-08-09', 1050000.00, 'checked_out', 'Dolores optio ut quo.', 2, '2026-08-04 11:38:50', '2026-08-04 11:38:50'),
(583, 'RSV-20260703-0583', 122, '2026-07-03', '2026-07-05', 1700000.00, 'checked_out', NULL, 2, '2026-07-01 06:29:41', '2026-07-01 06:29:41'),
(584, 'RSV-20260518-0584', 11, '2026-05-18', '2026-05-19', 500000.00, 'checked_out', 'Ea quas porro voluptatem deleniti possimus aliquam harum est.', 2, '2026-05-16 02:09:05', '2026-05-16 02:09:05'),
(585, 'RSV-20260707-0585', 102, '2026-07-07', '2026-07-08', 850000.00, 'checked_out', NULL, 2, '2026-07-05 17:16:04', '2026-07-05 17:16:04'),
(586, 'RSV-20260703-0586', 127, '2026-07-03', '2026-07-04', 350000.00, 'checked_out', NULL, 2, '2026-07-01 19:05:28', '2026-07-01 19:05:28'),
(587, 'RSV-20260519-0587', 8, '2026-05-19', '2026-05-20', 350000.00, 'checked_out', NULL, 2, '2026-05-17 09:17:41', '2026-05-17 09:17:41'),
(588, 'RSV-20260417-0588', 92, '2026-04-17', '2026-04-19', 700000.00, 'checked_out', 'Quo eius aut quia ratione.', 2, '2026-04-15 20:25:35', '2026-04-15 20:25:35'),
(589, 'RSV-20260919-0589', 123, '2026-09-19', '2026-09-23', 3400000.00, 'confirmed', NULL, 2, '2026-09-17 12:40:48', '2026-09-17 12:40:48'),
(590, 'RSV-20260701-0590', 63, '2026-07-01', '2026-07-03', 1000000.00, 'checked_out', NULL, 2, '2026-06-29 23:07:34', '2026-06-29 23:07:34'),
(591, 'RSV-20260810-0591', 15, '2026-08-10', '2026-08-12', 1700000.00, 'checked_out', NULL, 2, '2026-08-08 15:18:38', '2026-08-08 15:18:38'),
(592, 'RSV-20261021-0592', 113, '2026-10-21', '2026-10-23', 700000.00, 'pending', NULL, 2, '2026-10-19 09:26:06', '2026-10-19 09:26:06'),
(593, 'RSV-20260427-0593', 106, '2026-04-27', '2026-04-30', 1050000.00, 'checked_out', NULL, 2, '2026-04-25 00:43:20', '2026-04-25 00:43:20'),
(594, 'RSV-20260515-0594', 2, '2026-05-15', '2026-05-19', 1400000.00, 'checked_out', NULL, 2, '2026-05-13 19:14:36', '2026-05-13 19:14:36'),
(595, 'RSV-20260430-0595', 144, '2026-04-30', '2026-05-01', 350000.00, 'checked_out', 'Eveniet incidunt nulla ducimus distinctio ut quaerat.', 2, '2026-04-28 16:20:44', '2026-04-28 16:20:44'),
(596, 'RSV-20260804-0596', 145, '2026-08-04', '2026-08-07', 2550000.00, 'cancelled', NULL, 2, '2026-08-02 00:16:14', '2026-08-02 00:16:14'),
(597, 'RSV-20260712-0597', 5, '2026-07-12', '2026-07-14', 1000000.00, 'checked_out', NULL, 2, '2026-07-10 11:05:08', '2026-07-10 11:05:08'),
(598, 'RSV-20260701-0598', 148, '2026-07-01', '2026-07-06', 1750000.00, 'checked_out', 'Accusantium ex fuga vel perferendis.', 2, '2026-06-29 06:01:13', '2026-06-29 06:01:13'),
(599, 'RSV-20260711-0599', 145, '2026-07-11', '2026-07-14', 1500000.00, 'checked_out', NULL, 2, '2026-07-09 18:11:23', '2026-07-09 18:11:23'),
(600, 'RSV-20260724-0600', 21, '2026-07-24', '2026-07-28', 3400000.00, 'cancelled', NULL, 2, '2026-07-22 20:11:20', '2026-07-22 20:11:20'),
(601, 'RSV-20260727-0601', 50, '2026-07-27', '2026-07-28', 850000.00, 'checked_out', NULL, 2, '2026-07-25 06:28:43', '2026-07-25 06:28:43'),
(602, 'RSV-20260817-0602', 149, '2026-08-17', '2026-08-18', 500000.00, 'checked_out', 'Et numquam laborum facilis non accusantium qui ut.', 2, '2026-08-15 14:46:07', '2026-08-15 14:46:07'),
(603, 'RSV-20260726-0603', 145, '2026-07-26', '2026-07-27', 350000.00, 'checked_out', 'Veritatis dicta rem suscipit culpa nihil soluta.', 2, '2026-07-24 15:37:15', '2026-07-24 15:37:15'),
(604, 'RSV-20260609-0604', 79, '2026-06-09', '2026-06-12', 1500000.00, 'checked_out', NULL, 2, '2026-06-07 10:07:03', '2026-06-07 10:07:03'),
(605, 'RSV-20260829-0605', 101, '2026-08-29', '2026-09-01', 1500000.00, 'cancelled', NULL, 2, '2026-08-27 08:47:39', '2026-08-27 08:47:39'),
(606, 'RSV-20260514-0606', 139, '2026-05-14', '2026-05-19', 1750000.00, 'checked_out', NULL, 2, '2026-05-12 04:45:04', '2026-05-12 04:45:04'),
(607, 'RSV-20260429-0607', 113, '2026-04-29', '2026-05-01', 1700000.00, 'cancelled', NULL, 2, '2026-04-27 19:40:36', '2026-04-27 19:40:36'),
(608, 'RSV-20260408-0608', 109, '2026-04-08', '2026-04-10', 700000.00, 'checked_out', 'Neque quis eius esse laborum voluptate debitis et.', 2, '2026-04-06 08:14:14', '2026-04-06 08:14:14'),
(609, 'RSV-20260730-0609', 122, '2026-07-30', '2026-08-03', 2000000.00, 'checked_out', 'Ea est rem aperiam quo qui vel.', 2, '2026-07-28 03:21:04', '2026-07-28 03:21:04'),
(610, 'RSV-20260705-0610', 140, '2026-07-05', '2026-07-09', 2000000.00, 'checked_out', NULL, 2, '2026-07-03 08:25:00', '2026-07-03 08:25:00'),
(611, 'RSV-20260429-0611', 116, '2026-04-29', '2026-05-02', 1050000.00, 'checked_out', NULL, 2, '2026-04-27 21:35:19', '2026-04-27 21:35:19'),
(612, 'RSV-20260614-0612', 121, '2026-06-14', '2026-06-15', 850000.00, 'checked_out', NULL, 2, '2026-06-12 21:28:25', '2026-06-12 21:28:25'),
(613, 'RSV-20260904-0613', 97, '2026-09-04', '2026-09-06', 700000.00, 'cancelled', 'Minus voluptates tempora in iure numquam et cum enim.', 2, '2026-09-02 23:26:20', '2026-09-02 23:26:20'),
(614, 'RSV-20261009-0614', 6, '2026-10-09', '2026-10-13', 2000000.00, 'confirmed', NULL, 2, '2026-10-07 02:06:57', '2026-10-07 02:06:57'),
(615, 'RSV-20260725-0615', 134, '2026-07-25', '2026-07-29', 2000000.00, 'checked_out', NULL, 2, '2026-07-23 13:21:35', '2026-07-23 13:21:35'),
(616, 'RSV-20260624-0616', 58, '2026-06-24', '2026-06-25', 850000.00, 'checked_out', NULL, 2, '2026-06-22 21:14:58', '2026-06-22 21:14:58'),
(617, 'RSV-20260702-0617', 49, '2026-07-02', '2026-07-06', 3400000.00, 'checked_out', NULL, 2, '2026-06-30 04:45:18', '2026-06-30 04:45:18'),
(618, 'RSV-20260601-0618', 39, '2026-06-01', '2026-06-06', 4250000.00, 'checked_out', NULL, 2, '2026-05-30 18:52:52', '2026-05-30 18:52:52'),
(619, 'RSV-20260627-0619', 97, '2026-06-27', '2026-06-29', 1000000.00, 'checked_out', NULL, 2, '2026-06-25 22:15:31', '2026-06-25 22:15:31'),
(620, 'RSV-20260324-0620', 132, '2026-03-24', '2026-03-29', 1750000.00, 'checked_out', 'Enim rem nulla sed nisi.', 2, '2026-03-22 13:11:31', '2026-03-22 13:11:31'),
(621, 'RSV-20261008-0621', 54, '2026-10-08', '2026-10-13', 4250000.00, 'confirmed', NULL, 2, '2026-10-06 03:49:33', '2026-10-06 03:49:33'),
(622, 'RSV-20260728-0622', 29, '2026-07-28', '2026-08-01', 1400000.00, 'checked_out', 'Est velit porro et saepe.', 2, '2026-07-26 22:35:19', '2026-07-26 22:35:19'),
(623, 'RSV-20260710-0623', 69, '2026-07-10', '2026-07-12', 700000.00, 'checked_out', NULL, 2, '2026-07-08 14:02:41', '2026-07-08 14:02:41'),
(624, 'RSV-20260621-0624', 33, '2026-06-21', '2026-06-22', 850000.00, 'checked_out', 'Minus facere labore inventore quia ipsum sed debitis ipsum.', 2, '2026-06-19 08:39:52', '2026-06-19 08:39:52'),
(625, 'RSV-20260507-0625', 94, '2026-05-07', '2026-05-12', 1750000.00, 'cancelled', 'Et reiciendis occaecati earum animi.', 2, '2026-05-05 07:40:32', '2026-05-05 07:40:32'),
(626, 'RSV-20260722-0626', 77, '2026-07-22', '2026-07-23', 500000.00, 'cancelled', 'Fugit doloribus maiores aliquid adipisci facere sequi qui quaerat.', 2, '2026-07-20 04:13:54', '2026-07-20 04:13:54'),
(627, 'RSV-20260911-0627', 83, '2026-09-11', '2026-09-14', 1050000.00, 'checked_out', NULL, 2, '2026-09-09 23:07:21', '2026-09-09 23:07:21'),
(628, 'RSV-20260504-0628', 128, '2026-05-04', '2026-05-07', 2550000.00, 'checked_out', 'Sequi eum laborum ipsa debitis qui.', 2, '2026-05-02 08:42:09', '2026-05-02 08:42:09'),
(629, 'RSV-20260410-0629', 26, '2026-04-10', '2026-04-15', 1750000.00, 'checked_out', 'Voluptatem rerum alias voluptatibus rerum.', 2, '2026-04-08 22:34:09', '2026-04-08 22:34:09'),
(630, 'RSV-20260423-0630', 74, '2026-04-23', '2026-04-25', 1700000.00, 'checked_out', NULL, 2, '2026-04-21 14:03:20', '2026-04-21 14:03:20'),
(631, 'RSV-20260410-0631', 37, '2026-04-10', '2026-04-15', 4250000.00, 'cancelled', 'Eveniet laborum asperiores quis et hic at.', 2, '2026-04-08 20:05:22', '2026-04-08 20:05:22'),
(632, 'RSV-20260913-0632', 55, '2026-09-13', '2026-09-16', 1050000.00, 'checked_out', 'Deserunt corporis sit rerum.', 2, '2026-09-11 19:22:36', '2026-09-11 19:22:36'),
(633, 'RSV-20260408-0633', 82, '2026-04-08', '2026-04-09', 500000.00, 'checked_out', NULL, 2, '2026-04-06 16:35:42', '2026-04-06 16:35:42'),
(634, 'RSV-20260331-0634', 101, '2026-03-31', '2026-04-05', 1750000.00, 'checked_out', 'Velit incidunt distinctio qui accusamus et et.', 2, '2026-03-29 10:51:25', '2026-03-29 10:51:25'),
(635, 'RSV-20260531-0635', 73, '2026-05-31', '2026-06-05', 4250000.00, 'checked_out', NULL, 2, '2026-05-29 17:51:40', '2026-05-29 17:51:40'),
(636, 'RSV-20260528-0636', 128, '2026-05-28', '2026-06-02', 4250000.00, 'checked_out', NULL, 2, '2026-05-26 08:09:46', '2026-05-26 08:09:46'),
(637, 'RSV-20260723-0637', 126, '2026-07-23', '2026-07-25', 1700000.00, 'cancelled', NULL, 2, '2026-07-21 00:53:05', '2026-07-21 00:53:05'),
(638, 'RSV-20260801-0638', 36, '2026-08-01', '2026-08-04', 2550000.00, 'checked_out', NULL, 2, '2026-07-30 17:56:13', '2026-07-30 17:56:13'),
(639, 'RSV-20260510-0639', 41, '2026-05-10', '2026-05-13', 1050000.00, 'checked_out', NULL, 2, '2026-05-08 23:49:15', '2026-05-08 23:49:15'),
(640, 'RSV-20260822-0640', 57, '2026-08-22', '2026-08-24', 1700000.00, 'cancelled', NULL, 2, '2026-08-20 13:08:12', '2026-08-20 13:08:12'),
(641, 'RSV-20260421-0641', 37, '2026-04-21', '2026-04-23', 1000000.00, 'checked_out', 'Cumque et quo cumque.', 2, '2026-04-19 08:24:35', '2026-04-19 08:24:35'),
(642, 'RSV-20261014-0642', 32, '2026-10-14', '2026-10-19', 1750000.00, 'pending', NULL, 2, '2026-10-12 15:46:26', '2026-10-12 15:46:26'),
(643, 'RSV-20261019-0643', 144, '2026-10-19', '2026-10-23', 2000000.00, 'confirmed', NULL, 2, '2026-10-17 06:24:27', '2026-10-17 06:24:27'),
(644, 'RSV-20260506-0644', 55, '2026-05-06', '2026-05-07', 850000.00, 'cancelled', NULL, 2, '2026-05-04 20:01:50', '2026-05-04 20:01:50'),
(645, 'RSV-20260926-0645', 46, '2026-09-26', '2026-09-27', 500000.00, 'pending', NULL, 2, '2026-09-24 23:07:08', '2026-09-24 23:07:08'),
(646, 'RSV-20260630-0646', 125, '2026-06-30', '2026-07-04', 1400000.00, 'checked_out', NULL, 2, '2026-06-28 11:54:32', '2026-06-28 11:54:32'),
(647, 'RSV-20260830-0647', 38, '2026-08-30', '2026-09-01', 1700000.00, 'checked_out', NULL, 2, '2026-08-28 11:43:21', '2026-08-28 11:43:21'),
(648, 'RSV-20260403-0648', 27, '2026-04-03', '2026-04-07', 2000000.00, 'checked_out', NULL, 2, '2026-04-01 23:33:22', '2026-04-01 23:33:22'),
(649, 'RSV-20260725-0649', 119, '2026-07-25', '2026-07-28', 1500000.00, 'checked_out', NULL, 2, '2026-07-23 01:03:59', '2026-07-23 01:03:59'),
(650, 'RSV-20260402-0650', 115, '2026-04-02', '2026-04-05', 1500000.00, 'checked_out', NULL, 2, '2026-03-31 13:12:59', '2026-03-31 13:12:59'),
(651, 'RSV-20261005-0651', 125, '2026-10-05', '2026-10-10', 4250000.00, 'pending', 'Consequatur repudiandae odit tenetur occaecati odio.', 2, '2026-10-03 11:32:57', '2026-10-03 11:32:57'),
(652, 'RSV-20260330-0652', 76, '2026-03-30', '2026-04-01', 700000.00, 'checked_out', NULL, 2, '2026-03-28 01:49:01', '2026-03-28 01:49:01'),
(653, 'RSV-20260704-0653', 40, '2026-07-04', '2026-07-06', 1000000.00, 'checked_out', 'Voluptatem enim modi est.', 2, '2026-07-02 03:01:50', '2026-07-02 03:01:50'),
(654, 'RSV-20260603-0654', 22, '2026-06-03', '2026-06-07', 1400000.00, 'checked_out', NULL, 2, '2026-06-01 18:55:32', '2026-06-01 18:55:32'),
(655, 'RSV-20261006-0655', 10, '2026-10-06', '2026-10-07', 850000.00, 'pending', NULL, 2, '2026-10-04 23:11:18', '2026-10-04 23:11:18');
INSERT INTO `reservations` (`id`, `reservation_code`, `guest_id`, `check_in_date`, `check_out_date`, `total_price`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(656, 'RSV-20260603-0656', 72, '2026-06-03', '2026-06-08', 2500000.00, 'checked_out', 'Dolore omnis dolores facilis temporibus aut ipsum.', 2, '2026-06-01 04:44:41', '2026-06-01 04:44:41'),
(657, 'RSV-20261022-0657', 142, '2026-10-22', '2026-10-26', 1400000.00, 'pending', NULL, 2, '2026-10-20 02:42:22', '2026-10-20 02:42:22'),
(658, 'RSV-20261016-0658', 38, '2026-10-16', '2026-10-18', 1000000.00, 'pending', 'Expedita consequatur ut deleniti quibusdam vel minus perspiciatis sed.', 2, '2026-10-14 04:09:38', '2026-10-14 04:09:38'),
(659, 'RSV-20260617-0659', 112, '2026-06-17', '2026-06-22', 2500000.00, 'checked_out', 'Voluptatem enim et aliquid corrupti.', 2, '2026-06-15 05:22:38', '2026-06-15 05:22:38'),
(660, 'RSV-20261002-0660', 136, '2026-10-02', '2026-10-05', 2550000.00, 'confirmed', NULL, 2, '2026-09-30 20:42:29', '2026-09-30 20:42:29'),
(661, 'RSV-20261008-0661', 22, '2026-10-08', '2026-10-10', 1000000.00, 'confirmed', NULL, 2, '2026-10-06 11:51:05', '2026-10-06 11:51:05'),
(662, 'RSV-20261012-0662', 66, '2026-10-12', '2026-10-13', 350000.00, 'confirmed', NULL, 2, '2026-10-10 14:09:55', '2026-10-10 14:09:55'),
(663, 'RSV-20260529-0663', 9, '2026-05-29', '2026-06-03', 2500000.00, 'checked_out', NULL, 2, '2026-05-27 08:39:44', '2026-05-27 08:39:44'),
(664, 'RSV-20260727-0664', 70, '2026-07-27', '2026-07-28', 350000.00, 'checked_out', NULL, 2, '2026-07-25 05:26:22', '2026-07-25 05:26:22'),
(665, 'RSV-20260823-0665', 84, '2026-08-23', '2026-08-24', 500000.00, 'checked_out', NULL, 2, '2026-08-21 07:57:18', '2026-08-21 07:57:18'),
(666, 'RSV-20260329-0666', 134, '2026-03-29', '2026-03-31', 1000000.00, 'checked_out', 'Dolorem vel vel sed nihil temporibus vel quia.', 2, '2026-03-27 18:26:04', '2026-03-27 18:26:04'),
(667, 'RSV-20261013-0667', 92, '2026-10-13', '2026-10-17', 3400000.00, 'pending', NULL, 2, '2026-10-11 09:56:14', '2026-10-11 09:56:14'),
(668, 'RSV-20260822-0668', 7, '2026-08-22', '2026-08-27', 2500000.00, 'checked_out', 'Eum libero sed iste ut pariatur laudantium.', 2, '2026-08-20 21:59:26', '2026-08-20 21:59:26'),
(669, 'RSV-20260514-0669', 65, '2026-05-14', '2026-05-18', 2000000.00, 'cancelled', NULL, 2, '2026-05-12 05:06:45', '2026-05-12 05:06:45'),
(670, 'RSV-20260804-0670', 108, '2026-08-04', '2026-08-07', 1500000.00, 'checked_out', NULL, 2, '2026-08-02 21:44:56', '2026-08-02 21:44:56'),
(671, 'RSV-20260617-0671', 64, '2026-06-17', '2026-06-21', 3400000.00, 'checked_out', NULL, 2, '2026-06-15 15:55:14', '2026-06-15 15:55:14'),
(672, 'RSV-20260514-0672', 19, '2026-05-14', '2026-05-19', 4250000.00, 'checked_out', 'A ut numquam dolor non quis sunt.', 2, '2026-05-12 04:50:29', '2026-05-12 04:50:29'),
(673, 'RSV-20260324-0673', 120, '2026-03-24', '2026-03-27', 1500000.00, 'checked_out', 'Et distinctio et minima corrupti vero veniam a.', 2, '2026-03-22 04:13:54', '2026-03-22 04:13:54'),
(674, 'RSV-20260419-0674', 10, '2026-04-19', '2026-04-23', 1400000.00, 'checked_out', NULL, 2, '2026-04-17 23:53:03', '2026-04-17 23:53:03'),
(675, 'RSV-20260916-0675', 97, '2026-09-16', '2026-09-21', 2500000.00, 'checked_out', NULL, 2, '2026-09-14 19:22:47', '2026-09-14 19:22:47'),
(676, 'RSV-20260816-0676', 41, '2026-08-16', '2026-08-21', 4250000.00, 'cancelled', NULL, 2, '2026-08-14 13:54:29', '2026-08-14 13:54:29'),
(677, 'RSV-20260816-0677', 50, '2026-08-16', '2026-08-17', 500000.00, 'checked_out', 'Velit iste incidunt ea.', 2, '2026-08-14 04:16:23', '2026-08-14 04:16:23'),
(678, 'RSV-20260719-0678', 102, '2026-07-19', '2026-07-23', 1400000.00, 'checked_out', 'Impedit quaerat deleniti numquam.', 2, '2026-07-17 23:46:30', '2026-07-17 23:46:30'),
(679, 'RSV-20260508-0679', 138, '2026-05-08', '2026-05-13', 1750000.00, 'checked_out', NULL, 2, '2026-05-06 11:18:23', '2026-05-06 11:18:23'),
(680, 'RSV-20260520-0680', 107, '2026-05-20', '2026-05-21', 500000.00, 'checked_out', NULL, 2, '2026-05-18 11:37:16', '2026-05-18 11:37:16'),
(681, 'RSV-20260530-0681', 149, '2026-05-30', '2026-06-04', 1750000.00, 'checked_out', NULL, 2, '2026-05-28 22:24:06', '2026-05-28 22:24:06'),
(682, 'RSV-20260621-0682', 101, '2026-06-21', '2026-06-26', 2500000.00, 'checked_out', NULL, 2, '2026-06-19 06:11:54', '2026-06-19 06:11:54'),
(683, 'RSV-20260622-0683', 22, '2026-06-22', '2026-06-25', 2550000.00, 'checked_out', 'Mollitia qui cumque aut omnis sed nobis assumenda.', 2, '2026-06-20 07:07:54', '2026-06-20 07:07:54'),
(684, 'RSV-20260722-0684', 111, '2026-07-22', '2026-07-26', 1400000.00, 'cancelled', NULL, 2, '2026-07-20 17:34:39', '2026-07-20 17:34:39'),
(685, 'RSV-20260908-0685', 76, '2026-09-08', '2026-09-11', 2550000.00, 'checked_out', NULL, 2, '2026-09-06 03:41:12', '2026-09-06 03:41:12'),
(686, 'RSV-20260828-0686', 15, '2026-08-28', '2026-08-29', 500000.00, 'checked_out', NULL, 2, '2026-08-26 02:09:14', '2026-08-26 02:09:14'),
(687, 'RSV-20260505-0687', 148, '2026-05-05', '2026-05-07', 700000.00, 'checked_out', NULL, 2, '2026-05-03 04:59:49', '2026-05-03 04:59:49'),
(688, 'RSV-20261006-0688', 141, '2026-10-06', '2026-10-08', 700000.00, 'confirmed', NULL, 2, '2026-10-04 08:32:03', '2026-10-04 08:32:03'),
(689, 'RSV-20260324-0689', 99, '2026-03-24', '2026-03-28', 1400000.00, 'checked_out', NULL, 2, '2026-03-22 22:03:44', '2026-03-22 22:03:44'),
(690, 'RSV-20260607-0690', 15, '2026-06-07', '2026-06-09', 1000000.00, 'checked_out', 'Optio neque aut sed minus accusamus repellendus numquam.', 2, '2026-06-05 21:57:23', '2026-06-05 21:57:23'),
(691, 'RSV-20260629-0691', 3, '2026-06-29', '2026-06-30', 850000.00, 'checked_out', NULL, 2, '2026-06-27 16:46:56', '2026-06-27 16:46:56'),
(692, 'RSV-20260726-0692', 64, '2026-07-26', '2026-07-31', 1750000.00, 'checked_out', 'Dolor facilis qui molestiae est neque repellendus.', 2, '2026-07-24 01:28:11', '2026-07-24 01:28:11'),
(693, 'RSV-20260516-0693', 31, '2026-05-16', '2026-05-17', 350000.00, 'cancelled', NULL, 2, '2026-05-14 05:16:44', '2026-05-14 05:16:44'),
(694, 'RSV-20261011-0694', 14, '2026-10-11', '2026-10-14', 1050000.00, 'pending', NULL, 2, '2026-10-09 09:51:05', '2026-10-09 09:51:05'),
(695, 'RSV-20260624-0695', 119, '2026-06-24', '2026-06-29', 4250000.00, 'checked_out', NULL, 2, '2026-06-22 10:52:06', '2026-06-22 10:52:06'),
(696, 'RSV-20260725-0696', 57, '2026-07-25', '2026-07-29', 3400000.00, 'checked_out', NULL, 2, '2026-07-23 05:35:11', '2026-07-23 05:35:11'),
(697, 'RSV-20260729-0697', 86, '2026-07-29', '2026-08-01', 1050000.00, 'checked_out', 'Dolor rerum enim deserunt nisi ut consequatur commodi.', 2, '2026-07-27 14:53:05', '2026-07-27 14:53:05'),
(698, 'RSV-20260527-0698', 18, '2026-05-27', '2026-05-29', 1000000.00, 'cancelled', 'Occaecati minus vero accusantium placeat et sed.', 2, '2026-05-25 01:56:06', '2026-05-25 01:56:06'),
(699, 'RSV-20260617-0699', 116, '2026-06-17', '2026-06-20', 1050000.00, 'checked_out', NULL, 2, '2026-06-15 12:00:25', '2026-06-15 12:00:25'),
(700, 'RSV-20260818-0700', 41, '2026-08-18', '2026-08-20', 1700000.00, 'checked_out', NULL, 2, '2026-08-16 13:18:02', '2026-08-16 13:18:02'),
(701, 'RSV-20260919-0701', 106, '2026-09-19', '2026-09-23', 1400000.00, 'confirmed', NULL, 2, '2026-09-17 02:19:04', '2026-09-17 02:19:04'),
(702, 'RSV-20260413-0702', 67, '2026-04-13', '2026-04-14', 850000.00, 'checked_out', NULL, 2, '2026-04-11 18:49:26', '2026-04-11 18:49:26'),
(703, 'RSV-20260619-0703', 33, '2026-06-19', '2026-06-22', 1500000.00, 'checked_out', NULL, 2, '2026-06-17 16:29:48', '2026-06-17 16:29:48'),
(704, 'RSV-20260517-0704', 56, '2026-05-17', '2026-05-22', 1750000.00, 'checked_out', NULL, 2, '2026-05-15 06:53:46', '2026-05-15 06:53:46'),
(705, 'RSV-20260706-0705', 59, '2026-07-06', '2026-07-09', 1050000.00, 'checked_out', NULL, 2, '2026-07-04 03:31:41', '2026-07-04 03:31:41'),
(706, 'RSV-20260909-0706', 52, '2026-09-09', '2026-09-12', 1050000.00, 'cancelled', NULL, 2, '2026-09-07 19:45:20', '2026-09-07 19:45:20'),
(707, 'RSV-20260812-0707', 132, '2026-08-12', '2026-08-15', 2550000.00, 'checked_out', NULL, 2, '2026-08-10 14:14:41', '2026-08-10 14:14:41'),
(708, 'RSV-20260522-0708', 125, '2026-05-22', '2026-05-23', 500000.00, 'checked_out', 'Voluptatum non tempora occaecati nihil.', 2, '2026-05-20 09:36:19', '2026-05-20 09:36:19'),
(709, 'RSV-20260325-0709', 75, '2026-03-25', '2026-03-29', 1400000.00, 'cancelled', NULL, 2, '2026-03-23 14:17:36', '2026-03-23 14:17:36'),
(710, 'RSV-20261005-0710', 148, '2026-10-05', '2026-10-07', 1700000.00, 'confirmed', 'Temporibus pariatur culpa ut unde tempora.', 2, '2026-10-03 21:03:54', '2026-10-03 21:03:54'),
(711, 'RSV-20260329-0711', 41, '2026-03-29', '2026-04-01', 2550000.00, 'checked_out', NULL, 2, '2026-03-27 11:11:10', '2026-03-27 11:11:10'),
(712, 'RSV-20260326-0712', 47, '2026-03-26', '2026-03-30', 1400000.00, 'checked_out', NULL, 2, '2026-03-24 21:08:46', '2026-03-24 21:08:46'),
(713, 'RSV-20260528-0713', 82, '2026-05-28', '2026-06-02', 2500000.00, 'checked_out', NULL, 2, '2026-05-26 17:20:40', '2026-05-26 17:20:40'),
(714, 'RSV-20260525-0714', 148, '2026-05-25', '2026-05-30', 2500000.00, 'cancelled', 'Suscipit non reiciendis qui deleniti maxime pariatur inventore.', 2, '2026-05-23 07:13:52', '2026-05-23 07:13:52'),
(715, 'RSV-20260518-0715', 24, '2026-05-18', '2026-05-22', 2000000.00, 'checked_out', 'Minima dolore occaecati ut aut eius libero.', 2, '2026-05-16 04:40:12', '2026-05-16 04:40:12'),
(716, 'RSV-20260918-0716', 81, '2026-09-18', '2026-09-22', 3400000.00, 'confirmed', NULL, 2, '2026-09-16 15:04:25', '2026-09-16 15:04:25'),
(717, 'RSV-20260522-0717', 13, '2026-05-22', '2026-05-27', 2500000.00, 'cancelled', NULL, 2, '2026-05-20 18:36:48', '2026-05-20 18:36:48'),
(718, 'RSV-20260807-0718', 26, '2026-08-07', '2026-08-10', 1500000.00, 'checked_out', NULL, 2, '2026-08-05 00:51:34', '2026-08-05 00:51:34'),
(719, 'RSV-20261013-0719', 76, '2026-10-13', '2026-10-18', 1750000.00, 'confirmed', NULL, 2, '2026-10-11 14:12:47', '2026-10-11 14:12:47'),
(720, 'RSV-20260816-0720', 98, '2026-08-16', '2026-08-17', 350000.00, 'cancelled', NULL, 2, '2026-08-14 07:16:10', '2026-08-14 07:16:10'),
(721, 'RSV-20260917-0721', 114, '2026-09-17', '2026-09-22', 4250000.00, 'checked_in', 'Porro consequuntur nisi accusamus est.', 2, '2026-09-15 13:54:44', '2026-09-15 13:54:44'),
(722, 'RSV-20260326-0722', 149, '2026-03-26', '2026-03-27', 500000.00, 'checked_out', NULL, 2, '2026-03-24 21:11:24', '2026-03-24 21:11:24'),
(723, 'RSV-20260711-0723', 97, '2026-07-11', '2026-07-14', 2550000.00, 'checked_out', NULL, 2, '2026-07-09 03:33:29', '2026-07-09 03:33:29'),
(724, 'RSV-20261001-0724', 18, '2026-10-01', '2026-10-04', 1500000.00, 'confirmed', NULL, 2, '2026-09-29 19:02:17', '2026-09-29 19:02:17'),
(725, 'RSV-20260504-0725', 16, '2026-05-04', '2026-05-05', 500000.00, 'checked_out', NULL, 2, '2026-05-02 13:52:15', '2026-05-02 13:52:15'),
(726, 'RSV-20260601-0726', 102, '2026-06-01', '2026-06-05', 2000000.00, 'cancelled', NULL, 2, '2026-05-30 08:37:21', '2026-05-30 08:37:21'),
(727, 'RSV-20260410-0727', 97, '2026-04-10', '2026-04-13', 1500000.00, 'checked_out', 'Magnam accusantium aut ab.', 2, '2026-04-08 07:53:17', '2026-04-08 07:53:17'),
(728, 'RSV-20260403-0728', 100, '2026-04-03', '2026-04-07', 1400000.00, 'checked_out', NULL, 2, '2026-04-01 14:56:16', '2026-04-01 14:56:16'),
(729, 'RSV-20260528-0729', 45, '2026-05-28', '2026-05-31', 1050000.00, 'checked_out', NULL, 2, '2026-05-26 09:32:47', '2026-05-26 09:32:47'),
(730, 'RSV-20261007-0730', 55, '2026-10-07', '2026-10-10', 2550000.00, 'pending', NULL, 2, '2026-10-05 08:42:30', '2026-10-05 08:42:30'),
(731, 'RSV-20260724-0731', 17, '2026-07-24', '2026-07-27', 1500000.00, 'checked_out', NULL, 2, '2026-07-22 22:37:53', '2026-07-22 22:37:53'),
(732, 'RSV-20260424-0732', 43, '2026-04-24', '2026-04-28', 1400000.00, 'checked_out', NULL, 2, '2026-04-22 07:42:01', '2026-04-22 07:42:01'),
(733, 'RSV-20260612-0733', 36, '2026-06-12', '2026-06-15', 1500000.00, 'checked_out', NULL, 2, '2026-06-10 18:32:59', '2026-06-10 18:32:59'),
(734, 'RSV-20260919-0734', 89, '2026-09-19', '2026-09-22', 1050000.00, 'checked_out', NULL, 2, '2026-09-17 02:26:12', '2026-09-17 02:26:12'),
(735, 'RSV-20261008-0735', 112, '2026-10-08', '2026-10-10', 1700000.00, 'confirmed', NULL, 2, '2026-10-06 05:58:13', '2026-10-06 05:58:13'),
(736, 'RSV-20260904-0736', 91, '2026-09-04', '2026-09-06', 1700000.00, 'checked_out', 'Omnis eaque quis sint quia a aperiam.', 2, '2026-09-02 18:43:17', '2026-09-02 18:43:17'),
(737, 'RSV-20260524-0737', 53, '2026-05-24', '2026-05-25', 350000.00, 'checked_out', NULL, 2, '2026-05-22 22:51:48', '2026-05-22 22:51:48'),
(738, 'RSV-20260920-0738', 93, '2026-09-20', '2026-09-21', 850000.00, 'checked_out', NULL, 2, '2026-09-18 14:41:57', '2026-09-18 14:41:57'),
(739, 'RSV-20261015-0739', 9, '2026-10-15', '2026-10-17', 1000000.00, 'confirmed', NULL, 2, '2026-10-13 09:35:47', '2026-10-13 09:35:47'),
(740, 'RSV-20260803-0740', 109, '2026-08-03', '2026-08-05', 1700000.00, 'checked_out', 'Voluptates quaerat esse ut temporibus consequuntur veniam nam unde.', 2, '2026-08-01 21:22:28', '2026-08-01 21:22:28'),
(741, 'RSV-20260401-0741', 114, '2026-04-01', '2026-04-05', 1400000.00, 'checked_out', NULL, 2, '2026-03-30 08:49:42', '2026-03-30 08:49:42'),
(742, 'RSV-20260814-0742', 137, '2026-08-14', '2026-08-18', 2000000.00, 'cancelled', NULL, 2, '2026-08-12 20:36:57', '2026-08-12 20:36:57'),
(743, 'RSV-20260717-0743', 118, '2026-07-17', '2026-07-22', 2500000.00, 'checked_out', NULL, 2, '2026-07-15 07:42:40', '2026-07-15 07:42:40'),
(744, 'RSV-20260430-0744', 85, '2026-04-30', '2026-05-04', 3400000.00, 'checked_out', NULL, 2, '2026-04-28 00:45:54', '2026-04-28 00:45:54'),
(745, 'RSV-20260901-0745', 4, '2026-09-01', '2026-09-02', 350000.00, 'cancelled', NULL, 2, '2026-08-30 15:19:28', '2026-08-30 15:19:28'),
(746, 'RSV-20260402-0746', 29, '2026-04-02', '2026-04-06', 3400000.00, 'cancelled', NULL, 2, '2026-03-31 23:13:43', '2026-03-31 23:13:43'),
(747, 'RSV-20260926-0747', 33, '2026-09-26', '2026-10-01', 4250000.00, 'pending', 'Consequatur officia ab blanditiis assumenda numquam ea.', 2, '2026-09-24 10:13:54', '2026-09-24 10:13:54'),
(748, 'RSV-20260612-0748', 35, '2026-06-12', '2026-06-16', 2000000.00, 'checked_out', 'Velit nemo voluptate recusandae et harum repellat excepturi.', 2, '2026-06-10 17:02:58', '2026-06-10 17:02:58'),
(749, 'RSV-20260716-0749', 8, '2026-07-16', '2026-07-20', 3400000.00, 'checked_out', NULL, 2, '2026-07-14 20:41:59', '2026-07-14 20:41:59'),
(750, 'RSV-20260927-0750', 28, '2026-09-27', '2026-09-30', 1050000.00, 'confirmed', NULL, 2, '2026-09-25 08:49:53', '2026-09-25 08:49:53'),
(751, 'RSV-20260608-0751', 145, '2026-06-08', '2026-06-11', 1500000.00, 'checked_out', NULL, 2, '2026-06-06 09:11:58', '2026-06-06 09:11:58'),
(752, 'RSV-20260420-0752', 147, '2026-04-20', '2026-04-21', 350000.00, 'checked_out', NULL, 2, '2026-04-18 21:25:16', '2026-04-18 21:25:16'),
(753, 'RSV-20260524-0753', 8, '2026-05-24', '2026-05-25', 850000.00, 'checked_out', NULL, 2, '2026-05-22 14:44:33', '2026-05-22 14:44:33'),
(754, 'RSV-20260822-0754', 45, '2026-08-22', '2026-08-25', 1050000.00, 'cancelled', NULL, 2, '2026-08-20 20:54:10', '2026-08-20 20:54:10'),
(755, 'RSV-20260919-0755', 109, '2026-09-19', '2026-09-20', 350000.00, 'cancelled', NULL, 2, '2026-09-17 19:04:06', '2026-09-17 19:04:06'),
(756, 'RSV-20260928-0756', 76, '2026-09-28', '2026-09-29', 350000.00, 'confirmed', NULL, 2, '2026-09-26 22:12:45', '2026-09-26 22:12:45'),
(757, 'RSV-20260602-0757', 116, '2026-06-02', '2026-06-03', 850000.00, 'checked_out', 'Consequatur officia aut sed molestiae reiciendis vero.', 2, '2026-05-31 00:15:23', '2026-05-31 00:15:23'),
(758, 'RSV-20260525-0758', 92, '2026-05-25', '2026-05-26', 500000.00, 'cancelled', NULL, 2, '2026-05-23 00:44:45', '2026-05-23 00:44:45'),
(759, 'RSV-20260701-0759', 142, '2026-07-01', '2026-07-05', 1400000.00, 'checked_out', NULL, 2, '2026-06-29 16:57:48', '2026-06-29 16:57:48'),
(760, 'RSV-20260604-0760', 62, '2026-06-04', '2026-06-09', 4250000.00, 'checked_out', NULL, 2, '2026-06-02 10:52:48', '2026-06-02 10:52:48'),
(761, 'RSV-20260504-0761', 40, '2026-05-04', '2026-05-07', 1050000.00, 'cancelled', 'Et voluptatem quae modi repellat et.', 2, '2026-05-02 02:16:32', '2026-05-02 02:16:32'),
(762, 'RSV-20260917-0762', 114, '2026-09-17', '2026-09-21', 1400000.00, 'checked_out', NULL, 2, '2026-09-15 10:08:23', '2026-09-15 10:08:23'),
(763, 'RSV-20260417-0763', 50, '2026-04-17', '2026-04-20', 1050000.00, 'checked_out', NULL, 2, '2026-04-15 16:36:38', '2026-04-15 16:36:38'),
(764, 'RSV-20260620-0764', 74, '2026-06-20', '2026-06-23', 2550000.00, 'checked_out', 'Neque officia quas sed.', 2, '2026-06-18 05:02:57', '2026-06-18 05:02:57'),
(765, 'RSV-20260913-0765', 38, '2026-09-13', '2026-09-17', 2000000.00, 'checked_out', NULL, 2, '2026-09-11 22:01:02', '2026-09-11 22:01:02'),
(766, 'RSV-20260605-0766', 83, '2026-06-05', '2026-06-10', 1750000.00, 'checked_out', 'Dolor non expedita odit.', 2, '2026-06-03 07:43:43', '2026-06-03 07:43:43'),
(767, 'RSV-20260322-0767', 84, '2026-03-22', '2026-03-24', 1000000.00, 'checked_out', NULL, 2, '2026-03-20 10:13:47', '2026-03-20 10:13:47'),
(768, 'RSV-20260509-0768', 123, '2026-05-09', '2026-05-13', 1400000.00, 'checked_out', 'Qui soluta quam est eveniet vel est.', 2, '2026-05-07 04:53:29', '2026-05-07 04:53:29'),
(769, 'RSV-20261018-0769', 76, '2026-10-18', '2026-10-22', 2000000.00, 'confirmed', NULL, 2, '2026-10-16 03:39:02', '2026-10-16 03:39:02'),
(770, 'RSV-20260723-0770', 135, '2026-07-23', '2026-07-27', 1400000.00, 'checked_out', NULL, 2, '2026-07-21 06:04:27', '2026-07-21 06:04:27'),
(771, 'RSV-20260412-0771', 113, '2026-04-12', '2026-04-16', 1400000.00, 'cancelled', NULL, 2, '2026-04-10 00:50:53', '2026-04-10 00:50:53'),
(772, 'RSV-20260525-0772', 140, '2026-05-25', '2026-05-28', 1050000.00, 'checked_out', NULL, 2, '2026-05-23 17:09:07', '2026-05-23 17:09:07'),
(773, 'RSV-20260614-0773', 147, '2026-06-14', '2026-06-19', 2500000.00, 'checked_out', NULL, 2, '2026-06-12 21:39:27', '2026-06-12 21:39:27'),
(774, 'RSV-20260618-0774', 34, '2026-06-18', '2026-06-20', 1000000.00, 'checked_out', NULL, 2, '2026-06-16 16:08:51', '2026-06-16 16:08:51'),
(775, 'RSV-20260620-0775', 14, '2026-06-20', '2026-06-22', 700000.00, 'checked_out', NULL, 2, '2026-06-18 20:28:26', '2026-06-18 20:28:26'),
(776, 'RSV-20260818-0776', 6, '2026-08-18', '2026-08-20', 1700000.00, 'cancelled', NULL, 2, '2026-08-16 20:34:24', '2026-08-16 20:34:24'),
(777, 'RSV-20260521-0777', 28, '2026-05-21', '2026-05-26', 4250000.00, 'checked_out', NULL, 2, '2026-05-19 00:13:13', '2026-05-19 00:13:13'),
(778, 'RSV-20260629-0778', 8, '2026-06-29', '2026-07-04', 2500000.00, 'cancelled', NULL, 2, '2026-06-27 22:37:16', '2026-06-27 22:37:16'),
(779, 'RSV-20260805-0779', 38, '2026-08-05', '2026-08-06', 500000.00, 'checked_out', NULL, 2, '2026-08-03 20:02:18', '2026-08-03 20:02:18'),
(780, 'RSV-20260619-0780', 149, '2026-06-19', '2026-06-24', 1750000.00, 'checked_out', NULL, 2, '2026-06-17 18:45:27', '2026-06-17 18:45:27'),
(781, 'RSV-20260901-0781', 86, '2026-09-01', '2026-09-06', 2500000.00, 'cancelled', 'Aliquam maiores quae temporibus ex.', 2, '2026-08-30 02:23:35', '2026-08-30 02:23:35'),
(782, 'RSV-20260526-0782', 23, '2026-05-26', '2026-05-27', 350000.00, 'cancelled', NULL, 2, '2026-05-24 15:10:04', '2026-05-24 15:10:04'),
(783, 'RSV-20260603-0783', 42, '2026-06-03', '2026-06-06', 1500000.00, 'checked_out', NULL, 2, '2026-06-01 15:55:09', '2026-06-01 15:55:09'),
(784, 'RSV-20261006-0784', 93, '2026-10-06', '2026-10-11', 2500000.00, 'pending', 'Quia debitis aperiam consequatur.', 2, '2026-10-04 16:58:58', '2026-10-04 16:58:58'),
(785, 'RSV-20260607-0785', 57, '2026-06-07', '2026-06-09', 1000000.00, 'cancelled', NULL, 2, '2026-06-05 22:02:46', '2026-06-05 22:02:46'),
(786, 'RSV-20260601-0786', 75, '2026-06-01', '2026-06-03', 1000000.00, 'cancelled', NULL, 2, '2026-05-30 21:58:34', '2026-05-30 21:58:34'),
(787, 'RSV-20260404-0787', 29, '2026-04-04', '2026-04-05', 500000.00, 'checked_out', NULL, 2, '2026-04-02 15:01:08', '2026-04-02 15:01:08'),
(788, 'RSV-20260625-0788', 87, '2026-06-25', '2026-06-29', 1400000.00, 'checked_out', 'Dolores assumenda et nihil saepe reprehenderit in ratione.', 2, '2026-06-23 11:53:58', '2026-06-23 11:53:58'),
(789, 'RSV-20260908-0789', 15, '2026-09-08', '2026-09-12', 1400000.00, 'cancelled', 'Et quia ex quasi doloremque.', 2, '2026-09-06 23:13:52', '2026-09-06 23:13:52'),
(790, 'RSV-20260612-0790', 32, '2026-06-12', '2026-06-17', 1750000.00, 'cancelled', NULL, 2, '2026-06-10 11:04:31', '2026-06-10 11:04:31'),
(791, 'RSV-20261016-0791', 22, '2026-10-16', '2026-10-17', 350000.00, 'confirmed', 'Necessitatibus officia blanditiis esse et voluptas incidunt.', 2, '2026-10-14 20:49:52', '2026-10-14 20:49:52'),
(792, 'RSV-20260924-0792', 4, '2026-09-24', '2026-09-27', 1050000.00, 'confirmed', NULL, 2, '2026-09-22 21:10:50', '2026-09-22 21:10:50'),
(793, 'RSV-20260920-0793', 9, '2026-09-20', '2026-09-24', 3400000.00, 'checked_in', NULL, 2, '2026-09-18 08:42:39', '2026-09-18 08:42:39'),
(794, 'RSV-20260528-0794', 102, '2026-05-28', '2026-05-29', 350000.00, 'checked_out', 'Facere molestiae id praesentium delectus.', 2, '2026-05-26 20:15:41', '2026-05-26 20:15:41'),
(795, 'RSV-20260830-0795', 42, '2026-08-30', '2026-09-01', 1000000.00, 'checked_out', 'Repellendus aut quisquam veniam fugiat quis.', 2, '2026-08-28 12:00:46', '2026-08-28 12:00:46'),
(796, 'RSV-20261016-0796', 53, '2026-10-16', '2026-10-21', 2500000.00, 'confirmed', NULL, 2, '2026-10-14 11:45:53', '2026-10-14 11:45:53'),
(797, 'RSV-20260630-0797', 124, '2026-06-30', '2026-07-03', 1500000.00, 'checked_out', NULL, 2, '2026-06-28 06:12:29', '2026-06-28 06:12:29'),
(798, 'RSV-20260425-0798', 91, '2026-04-25', '2026-04-26', 350000.00, 'checked_out', 'Adipisci ea blanditiis quia inventore mollitia iure ut voluptas.', 2, '2026-04-23 06:24:40', '2026-04-23 06:24:40'),
(799, 'RSV-20260619-0799', 130, '2026-06-19', '2026-06-24', 4250000.00, 'checked_out', NULL, 2, '2026-06-17 08:48:43', '2026-06-17 08:48:43'),
(800, 'RSV-20260826-0800', 98, '2026-08-26', '2026-08-27', 350000.00, 'checked_out', NULL, 2, '2026-08-24 23:31:50', '2026-08-24 23:31:50'),
(801, 'RSV-TODAY-0001', 111, '2026-09-22', '2026-09-24', 700000.00, 'checked_in', NULL, 2, '2026-09-22 09:20:58', '2026-09-22 09:20:58'),
(802, 'RSV-TODAY-0002', 32, '2026-09-22', '2026-09-25', 1500000.00, 'checked_in', NULL, 2, '2026-09-22 09:20:58', '2026-09-22 09:20:58'),
(803, 'RSV-TODAY-0003', 124, '2026-09-22', '2026-09-25', 2550000.00, 'checked_in', NULL, 2, '2026-09-22 09:20:58', '2026-09-22 09:20:58'),
(804, 'RSV-TODAY-0004', 9, '2026-09-22', '2026-09-24', 1700000.00, 'checked_in', NULL, 2, '2026-09-22 09:20:58', '2026-09-22 09:20:58'),
(805, 'RSV-TODAY-0005', 18, '2026-09-22', '2026-09-24', 700000.00, 'checked_in', NULL, 2, '2026-09-22 09:20:58', '2026-09-22 09:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_rooms`
--

CREATE TABLE `reservation_rooms` (
  `id` int UNSIGNED NOT NULL,
  `reservation_id` int UNSIGNED NOT NULL,
  `room_id` int UNSIGNED NOT NULL,
  `price_per_night` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation_rooms`
--

INSERT INTO `reservation_rooms` (`id`, `reservation_id`, `room_id`, `price_per_night`, `created_at`, `updated_at`) VALUES
(1, 1, 57, 850000.00, '2026-03-21 16:37:57', NULL),
(2, 2, 18, 850000.00, '2026-10-05 12:57:44', NULL),
(3, 3, 32, 350000.00, '2026-06-23 09:32:50', NULL),
(4, 4, 4, 500000.00, '2026-10-15 23:53:15', NULL),
(5, 5, 7, 850000.00, '2026-03-29 04:32:03', NULL),
(6, 6, 59, 850000.00, '2026-03-26 14:50:12', NULL),
(7, 7, 49, 350000.00, '2026-06-23 17:26:53', NULL),
(8, 8, 28, 500000.00, '2026-05-09 09:28:20', NULL),
(9, 9, 74, 850000.00, '2026-08-29 05:29:37', NULL),
(10, 10, 28, 500000.00, '2026-07-15 13:43:41', NULL),
(11, 11, 12, 350000.00, '2026-09-20 08:03:55', NULL),
(12, 12, 35, 350000.00, '2026-07-16 02:12:31', NULL),
(13, 13, 10, 350000.00, '2026-08-29 03:25:49', NULL),
(14, 14, 40, 500000.00, '2026-10-08 16:03:07', NULL),
(15, 15, 8, 350000.00, '2026-08-16 02:40:59', NULL),
(16, 16, 24, 350000.00, '2026-04-30 16:49:55', NULL),
(17, 17, 20, 350000.00, '2026-05-30 17:01:48', NULL),
(18, 18, 53, 500000.00, '2026-08-17 15:29:20', NULL),
(19, 19, 19, 350000.00, '2026-03-31 04:53:00', NULL),
(20, 20, 20, 350000.00, '2026-06-07 02:55:57', NULL),
(21, 21, 70, 850000.00, '2026-07-21 07:44:13', NULL),
(22, 22, 68, 850000.00, '2026-07-02 02:57:45', NULL),
(23, 23, 64, 500000.00, '2026-08-17 01:03:40', NULL),
(24, 24, 49, 350000.00, '2026-06-10 20:29:39', NULL),
(25, 25, 9, 350000.00, '2026-03-20 14:45:22', NULL),
(26, 26, 75, 850000.00, '2026-08-22 12:14:21', NULL),
(27, 27, 9, 350000.00, '2026-04-21 16:31:20', NULL),
(28, 28, 18, 850000.00, '2026-09-30 23:02:04', NULL),
(29, 29, 26, 500000.00, '2026-04-16 22:42:15', NULL),
(30, 30, 75, 850000.00, '2026-06-13 17:47:25', NULL),
(31, 31, 62, 500000.00, '2026-06-25 13:28:50', NULL),
(32, 32, 14, 500000.00, '2026-04-26 09:32:59', NULL),
(33, 33, 67, 850000.00, '2026-09-08 22:51:43', NULL),
(34, 34, 30, 850000.00, '2026-09-19 04:40:25', NULL),
(35, 35, 7, 850000.00, '2026-08-03 15:55:10', NULL),
(36, 36, 4, 500000.00, '2026-05-15 06:25:06', NULL),
(37, 37, 27, 500000.00, '2026-09-06 23:39:11', NULL),
(38, 38, 30, 850000.00, '2026-09-29 14:21:57', NULL),
(39, 39, 43, 850000.00, '2026-08-30 13:21:59', NULL),
(40, 40, 64, 500000.00, '2026-08-26 12:18:11', NULL),
(41, 41, 23, 350000.00, '2026-08-25 01:36:32', NULL),
(42, 42, 71, 850000.00, '2026-06-28 21:42:42', NULL),
(43, 43, 55, 500000.00, '2026-06-26 22:13:21', NULL),
(44, 44, 29, 850000.00, '2026-05-29 07:12:37', NULL),
(45, 45, 22, 350000.00, '2026-07-21 06:03:37', NULL),
(46, 46, 60, 850000.00, '2026-07-11 17:37:39', NULL),
(47, 47, 41, 500000.00, '2026-08-12 06:01:08', NULL),
(48, 48, 52, 500000.00, '2026-06-01 16:28:40', NULL),
(49, 49, 26, 500000.00, '2026-05-23 18:43:37', NULL),
(50, 50, 60, 850000.00, '2026-07-21 01:23:49', NULL),
(51, 51, 10, 350000.00, '2026-04-26 11:47:59', NULL),
(52, 52, 3, 500000.00, '2026-10-06 01:34:59', NULL),
(53, 53, 25, 350000.00, '2026-09-03 18:42:39', NULL),
(54, 54, 2, 350000.00, '2026-06-25 11:16:30', NULL),
(55, 55, 50, 350000.00, '2026-10-06 00:07:07', NULL),
(56, 56, 8, 350000.00, '2026-07-13 04:38:57', NULL),
(57, 57, 43, 850000.00, '2026-08-02 07:17:22', NULL),
(58, 58, 41, 500000.00, '2026-09-28 15:13:04', NULL),
(59, 59, 66, 850000.00, '2026-09-16 01:42:54', NULL),
(60, 60, 56, 850000.00, '2026-10-18 08:31:38', NULL),
(61, 61, 23, 350000.00, '2026-05-28 08:33:51', NULL),
(62, 62, 27, 500000.00, '2026-09-07 17:23:01', NULL),
(63, 63, 10, 350000.00, '2026-05-01 08:49:59', NULL),
(64, 64, 5, 500000.00, '2026-08-28 05:57:56', NULL),
(65, 65, 52, 500000.00, '2026-05-09 15:04:34', NULL),
(66, 66, 34, 350000.00, '2026-08-15 20:35:31', NULL),
(67, 67, 51, 500000.00, '2026-08-10 06:25:09', NULL),
(68, 68, 75, 850000.00, '2026-04-07 08:46:23', NULL),
(69, 69, 32, 350000.00, '2026-04-13 11:31:15', NULL),
(70, 70, 65, 500000.00, '2026-05-24 17:14:15', NULL),
(71, 71, 70, 850000.00, '2026-04-24 01:31:36', NULL),
(72, 72, 24, 350000.00, '2026-04-05 20:40:11', NULL),
(73, 73, 55, 500000.00, '2026-08-30 12:45:27', NULL),
(74, 74, 9, 350000.00, '2026-08-17 22:13:41', NULL),
(75, 75, 52, 500000.00, '2026-05-05 21:12:11', NULL),
(76, 76, 61, 500000.00, '2026-04-18 07:40:30', NULL),
(77, 77, 5, 500000.00, '2026-03-25 18:31:45', NULL),
(78, 78, 54, 500000.00, '2026-07-13 07:06:21', NULL),
(79, 79, 65, 500000.00, '2026-08-03 20:18:39', NULL),
(80, 80, 38, 500000.00, '2026-04-21 06:01:44', NULL),
(81, 81, 7, 850000.00, '2026-10-12 03:13:44', NULL),
(82, 82, 52, 500000.00, '2026-10-12 07:15:46', NULL),
(83, 83, 56, 850000.00, '2026-08-05 18:48:16', NULL),
(84, 84, 30, 850000.00, '2026-05-05 20:14:52', NULL),
(85, 85, 25, 350000.00, '2026-05-14 17:32:33', NULL),
(86, 86, 56, 850000.00, '2026-08-17 19:13:01', NULL),
(87, 87, 25, 350000.00, '2026-05-09 12:34:42', NULL),
(88, 88, 22, 350000.00, '2026-04-20 04:12:28', NULL),
(89, 89, 26, 500000.00, '2026-03-29 03:06:06', NULL),
(90, 90, 55, 500000.00, '2026-08-23 06:20:04', NULL),
(91, 91, 21, 350000.00, '2026-09-30 02:07:25', NULL),
(92, 92, 5, 500000.00, '2026-08-24 21:30:26', NULL),
(93, 93, 8, 350000.00, '2026-10-06 09:33:20', NULL),
(94, 94, 68, 850000.00, '2026-06-14 01:07:14', NULL),
(95, 95, 61, 500000.00, '2026-07-10 18:09:57', NULL),
(96, 96, 39, 500000.00, '2026-09-03 20:36:05', NULL),
(97, 97, 52, 500000.00, '2026-10-01 04:25:36', NULL),
(98, 98, 27, 500000.00, '2026-07-25 06:24:07', NULL),
(99, 99, 1, 350000.00, '2026-04-01 11:59:50', NULL),
(100, 100, 52, 500000.00, '2026-09-27 17:29:16', NULL),
(101, 101, 26, 500000.00, '2026-10-10 22:45:11', NULL),
(102, 102, 16, 500000.00, '2026-05-09 14:43:56', NULL),
(103, 103, 22, 350000.00, '2026-08-21 08:14:04', NULL),
(104, 104, 28, 500000.00, '2026-09-21 20:51:30', NULL),
(105, 105, 22, 350000.00, '2026-08-21 20:39:07', NULL),
(106, 106, 20, 350000.00, '2026-04-13 07:31:37', NULL),
(107, 107, 11, 350000.00, '2026-07-31 02:53:22', NULL),
(108, 108, 15, 500000.00, '2026-04-12 18:42:57', NULL),
(109, 109, 32, 350000.00, '2026-04-12 18:41:31', NULL),
(110, 110, 32, 350000.00, '2026-07-31 06:00:57', NULL),
(111, 111, 30, 850000.00, '2026-04-07 07:48:51', NULL),
(112, 112, 64, 500000.00, '2026-08-16 19:27:50', NULL),
(113, 113, 50, 350000.00, '2026-07-11 03:43:03', NULL),
(114, 114, 17, 500000.00, '2026-05-22 15:07:39', NULL),
(115, 115, 19, 350000.00, '2026-08-16 15:12:45', NULL),
(116, 116, 67, 850000.00, '2026-07-25 17:54:04', NULL),
(117, 117, 43, 850000.00, '2026-07-08 20:50:33', NULL),
(118, 118, 66, 850000.00, '2026-10-20 04:37:52', NULL),
(119, 119, 47, 350000.00, '2026-05-04 15:30:00', NULL),
(120, 120, 33, 350000.00, '2026-06-20 21:22:52', NULL),
(121, 121, 36, 350000.00, '2026-08-05 11:16:04', NULL),
(122, 122, 64, 500000.00, '2026-08-29 06:02:52', NULL),
(123, 123, 51, 500000.00, '2026-09-28 20:27:26', NULL),
(124, 124, 53, 500000.00, '2026-07-20 12:54:03', NULL),
(125, 125, 6, 850000.00, '2026-06-05 15:26:31', NULL),
(126, 126, 42, 850000.00, '2026-09-23 16:33:21', NULL),
(127, 127, 51, 500000.00, '2026-08-02 14:03:32', NULL),
(128, 128, 18, 850000.00, '2026-09-09 05:29:01', NULL),
(129, 129, 50, 350000.00, '2026-08-05 02:09:06', NULL),
(130, 130, 35, 350000.00, '2026-05-02 08:04:47', NULL),
(131, 131, 20, 350000.00, '2026-10-09 03:28:15', NULL),
(132, 132, 45, 850000.00, '2026-08-17 17:05:07', NULL),
(133, 133, 62, 500000.00, '2026-09-18 05:11:33', NULL),
(134, 134, 31, 350000.00, '2026-03-29 06:56:59', NULL),
(135, 135, 59, 850000.00, '2026-06-26 03:53:32', NULL),
(136, 136, 16, 500000.00, '2026-06-07 01:24:43', NULL),
(137, 137, 39, 500000.00, '2026-06-14 12:21:51', NULL),
(138, 138, 44, 850000.00, '2026-10-14 01:09:17', NULL),
(139, 139, 41, 500000.00, '2026-04-16 17:54:20', NULL),
(140, 140, 11, 350000.00, '2026-04-28 18:51:18', NULL),
(141, 141, 58, 850000.00, '2026-10-06 22:04:39', NULL),
(142, 142, 1, 350000.00, '2026-05-30 05:10:04', NULL),
(143, 143, 49, 350000.00, '2026-04-24 03:09:08', NULL),
(144, 144, 1, 350000.00, '2026-05-06 14:20:05', NULL),
(145, 145, 34, 350000.00, '2026-09-12 06:01:21', NULL),
(146, 146, 27, 500000.00, '2026-05-18 01:01:29', NULL),
(147, 147, 28, 500000.00, '2026-07-12 23:19:36', NULL),
(148, 148, 37, 350000.00, '2026-08-08 01:29:16', NULL),
(149, 149, 12, 350000.00, '2026-05-22 09:03:55', NULL),
(150, 150, 51, 500000.00, '2026-10-18 06:09:33', NULL),
(151, 151, 39, 500000.00, '2026-05-16 09:57:49', NULL),
(152, 152, 39, 500000.00, '2026-06-08 18:53:18', NULL),
(153, 153, 35, 350000.00, '2026-05-19 00:51:41', NULL),
(154, 154, 46, 350000.00, '2026-07-31 07:27:53', NULL),
(155, 155, 72, 850000.00, '2026-07-30 20:22:45', NULL),
(156, 156, 70, 850000.00, '2026-08-26 02:16:16', NULL),
(157, 157, 48, 350000.00, '2026-04-10 04:44:31', NULL),
(158, 158, 14, 500000.00, '2026-09-21 16:38:04', NULL),
(159, 159, 9, 350000.00, '2026-04-17 08:53:47', NULL),
(160, 160, 5, 500000.00, '2026-06-06 22:15:07', NULL),
(161, 161, 59, 850000.00, '2026-03-26 20:05:11', NULL),
(162, 162, 28, 500000.00, '2026-07-26 08:56:49', NULL),
(163, 163, 27, 500000.00, '2026-07-06 23:18:17', NULL),
(164, 164, 52, 500000.00, '2026-10-04 18:02:24', NULL),
(165, 165, 51, 500000.00, '2026-08-21 07:24:45', NULL),
(166, 166, 43, 850000.00, '2026-07-25 22:31:50', NULL),
(167, 167, 24, 350000.00, '2026-04-08 20:40:00', NULL),
(168, 168, 9, 350000.00, '2026-09-25 13:23:06', NULL),
(169, 169, 3, 500000.00, '2026-03-30 23:06:00', NULL),
(170, 170, 41, 500000.00, '2026-10-12 23:28:25', NULL),
(171, 171, 69, 850000.00, '2026-05-31 14:58:22', NULL),
(172, 172, 49, 350000.00, '2026-07-09 23:27:52', NULL),
(173, 173, 5, 500000.00, '2026-08-29 16:18:53', NULL),
(174, 174, 31, 350000.00, '2026-09-20 20:47:34', NULL),
(175, 175, 71, 850000.00, '2026-05-03 00:53:52', NULL),
(176, 176, 62, 500000.00, '2026-08-29 08:38:04', NULL),
(177, 177, 22, 350000.00, '2026-06-16 14:48:37', NULL),
(178, 178, 48, 350000.00, '2026-08-10 10:34:30', NULL),
(179, 179, 13, 350000.00, '2026-05-13 08:27:41', NULL),
(180, 180, 20, 350000.00, '2026-10-09 05:10:47', NULL),
(181, 181, 20, 350000.00, '2026-06-01 00:17:12', NULL),
(182, 182, 13, 350000.00, '2026-08-15 20:54:56', NULL),
(183, 183, 59, 850000.00, '2026-10-13 03:03:55', NULL),
(184, 184, 4, 500000.00, '2026-09-14 18:20:48', NULL),
(185, 185, 35, 350000.00, '2026-05-16 19:58:04', NULL),
(186, 186, 26, 500000.00, '2026-08-02 23:59:56', NULL),
(187, 187, 27, 500000.00, '2026-06-03 13:21:07', NULL),
(188, 188, 53, 500000.00, '2026-03-29 00:23:55', NULL),
(189, 189, 65, 500000.00, '2026-04-29 19:02:03', NULL),
(190, 190, 2, 350000.00, '2026-08-17 23:10:00', NULL),
(191, 191, 55, 500000.00, '2026-05-08 02:49:21', NULL),
(192, 192, 25, 350000.00, '2026-10-19 22:41:33', NULL),
(193, 193, 44, 850000.00, '2026-05-16 17:43:13', NULL),
(194, 194, 57, 850000.00, '2026-08-20 04:17:06', NULL),
(195, 195, 30, 850000.00, '2026-06-13 09:44:39', NULL),
(196, 196, 67, 850000.00, '2026-07-24 18:17:27', NULL),
(197, 197, 30, 850000.00, '2026-04-16 02:07:00', NULL),
(198, 198, 26, 500000.00, '2026-06-04 01:13:59', NULL),
(199, 199, 26, 500000.00, '2026-04-12 20:30:05', NULL),
(200, 200, 47, 350000.00, '2026-08-07 17:47:31', NULL),
(201, 201, 25, 350000.00, '2026-09-28 15:54:49', NULL),
(202, 202, 61, 500000.00, '2026-09-17 05:34:07', NULL),
(203, 203, 40, 500000.00, '2026-06-03 15:31:02', NULL),
(204, 204, 17, 500000.00, '2026-07-04 22:47:42', NULL),
(205, 205, 45, 850000.00, '2026-03-30 20:05:31', NULL),
(206, 206, 2, 350000.00, '2026-08-23 03:18:42', NULL),
(207, 207, 41, 500000.00, '2026-05-29 18:55:21', NULL),
(208, 208, 47, 350000.00, '2026-04-19 13:30:45', NULL),
(209, 209, 12, 350000.00, '2026-06-23 23:25:58', NULL),
(210, 210, 30, 850000.00, '2026-07-01 08:59:49', NULL),
(211, 211, 28, 500000.00, '2026-08-11 21:06:58', NULL),
(212, 212, 31, 350000.00, '2026-09-15 07:23:35', NULL),
(213, 213, 40, 500000.00, '2026-04-08 00:57:47', NULL),
(214, 214, 32, 350000.00, '2026-04-23 04:13:28', NULL),
(215, 215, 72, 850000.00, '2026-06-17 08:25:44', NULL),
(216, 216, 61, 500000.00, '2026-10-14 08:47:13', NULL),
(217, 217, 2, 350000.00, '2026-04-12 02:43:12', NULL),
(218, 218, 19, 350000.00, '2026-09-07 12:07:32', NULL),
(219, 219, 12, 350000.00, '2026-08-03 21:32:37', NULL),
(220, 220, 1, 350000.00, '2026-10-03 03:11:09', NULL),
(221, 221, 3, 500000.00, '2026-07-11 16:29:40', NULL),
(222, 222, 41, 500000.00, '2026-09-30 21:00:34', NULL),
(223, 223, 38, 500000.00, '2026-05-21 02:49:29', NULL),
(224, 224, 11, 350000.00, '2026-08-07 05:09:18', NULL),
(225, 225, 72, 850000.00, '2026-08-26 23:58:52', NULL),
(226, 226, 50, 350000.00, '2026-04-08 18:42:57', NULL),
(227, 227, 6, 850000.00, '2026-06-18 10:02:33', NULL),
(228, 228, 71, 850000.00, '2026-08-28 19:31:09', NULL),
(229, 229, 3, 500000.00, '2026-06-18 23:32:47', NULL),
(230, 230, 64, 500000.00, '2026-07-05 20:30:45', NULL),
(231, 231, 70, 850000.00, '2026-06-18 09:25:37', NULL),
(232, 232, 7, 850000.00, '2026-07-14 05:15:23', NULL),
(233, 233, 64, 500000.00, '2026-06-03 10:05:22', NULL),
(234, 234, 50, 350000.00, '2026-05-04 18:14:32', NULL),
(235, 235, 16, 500000.00, '2026-10-18 04:55:15', NULL),
(236, 236, 68, 850000.00, '2026-05-13 06:06:20', NULL),
(237, 237, 31, 350000.00, '2026-07-09 20:56:29', NULL),
(238, 238, 68, 850000.00, '2026-08-07 19:45:40', NULL),
(239, 239, 3, 500000.00, '2026-06-03 05:11:34', NULL),
(240, 240, 73, 850000.00, '2026-08-18 15:39:07', NULL),
(241, 241, 27, 500000.00, '2026-09-13 12:29:20', NULL),
(242, 242, 33, 350000.00, '2026-10-04 14:25:20', NULL),
(243, 243, 60, 850000.00, '2026-07-29 18:19:47', NULL),
(244, 244, 24, 350000.00, '2026-10-10 06:38:32', NULL),
(245, 245, 63, 500000.00, '2026-04-17 00:40:43', NULL),
(246, 246, 30, 850000.00, '2026-06-03 09:18:26', NULL),
(247, 247, 5, 500000.00, '2026-03-27 18:32:29', NULL),
(248, 248, 71, 850000.00, '2026-09-01 07:16:19', NULL),
(249, 249, 69, 850000.00, '2026-10-01 05:26:05', NULL),
(250, 250, 8, 350000.00, '2026-05-22 04:28:44', NULL),
(251, 251, 44, 850000.00, '2026-03-27 08:57:27', NULL),
(252, 252, 70, 850000.00, '2026-07-10 15:06:26', NULL),
(253, 253, 23, 350000.00, '2026-09-10 13:28:15', NULL),
(254, 254, 68, 850000.00, '2026-06-16 20:11:43', NULL),
(255, 255, 68, 850000.00, '2026-05-15 19:05:09', NULL),
(256, 256, 49, 350000.00, '2026-06-20 02:33:48', NULL),
(257, 257, 7, 850000.00, '2026-07-11 23:56:40', NULL),
(258, 258, 19, 350000.00, '2026-09-01 16:29:31', NULL),
(259, 259, 36, 350000.00, '2026-03-22 14:47:49', NULL),
(260, 260, 16, 500000.00, '2026-03-31 09:46:44', NULL),
(261, 261, 18, 850000.00, '2026-10-12 16:59:44', NULL),
(262, 262, 35, 350000.00, '2026-05-08 19:40:02', NULL),
(263, 263, 45, 850000.00, '2026-05-21 03:49:50', NULL),
(264, 264, 25, 350000.00, '2026-04-14 03:06:23', NULL),
(265, 265, 67, 850000.00, '2026-04-02 02:53:25', NULL),
(266, 266, 41, 500000.00, '2026-03-23 17:54:46', NULL),
(267, 267, 47, 350000.00, '2026-05-05 11:37:07', NULL),
(268, 268, 42, 850000.00, '2026-08-20 14:50:52', NULL),
(269, 269, 21, 350000.00, '2026-07-07 01:18:13', NULL),
(270, 270, 7, 850000.00, '2026-03-30 03:38:37', NULL),
(271, 271, 72, 850000.00, '2026-05-01 11:15:50', NULL),
(272, 272, 12, 350000.00, '2026-06-15 10:27:22', NULL),
(273, 273, 23, 350000.00, '2026-10-11 12:55:32', NULL),
(274, 274, 49, 350000.00, '2026-05-18 15:13:20', NULL),
(275, 275, 32, 350000.00, '2026-03-29 10:06:08', NULL),
(276, 276, 45, 850000.00, '2026-10-14 22:40:09', NULL),
(277, 277, 25, 350000.00, '2026-09-24 11:57:13', NULL),
(278, 278, 75, 850000.00, '2026-10-13 21:48:55', NULL),
(279, 279, 56, 850000.00, '2026-10-05 20:01:18', NULL),
(280, 280, 69, 850000.00, '2026-07-22 13:51:46', NULL),
(281, 281, 48, 350000.00, '2026-06-06 17:36:07', NULL),
(282, 282, 71, 850000.00, '2026-03-22 01:12:26', NULL),
(283, 283, 4, 500000.00, '2026-09-16 08:44:22', NULL),
(284, 284, 26, 500000.00, '2026-09-03 12:27:58', NULL),
(285, 285, 47, 350000.00, '2026-09-14 20:16:12', NULL),
(286, 286, 18, 850000.00, '2026-09-01 17:24:44', NULL),
(287, 287, 66, 850000.00, '2026-04-04 11:17:14', NULL),
(288, 288, 9, 350000.00, '2026-10-17 09:57:02', NULL),
(289, 289, 6, 850000.00, '2026-05-08 04:16:03', NULL),
(290, 290, 10, 350000.00, '2026-10-08 15:59:13', NULL),
(291, 291, 32, 350000.00, '2026-08-11 08:53:10', NULL),
(292, 292, 51, 500000.00, '2026-10-12 13:09:50', NULL),
(293, 293, 36, 350000.00, '2026-05-31 22:53:53', NULL),
(294, 294, 9, 350000.00, '2026-06-18 15:16:14', NULL),
(295, 295, 26, 500000.00, '2026-08-22 16:05:38', NULL),
(296, 296, 33, 350000.00, '2026-04-27 18:06:18', NULL),
(297, 297, 41, 500000.00, '2026-08-02 15:06:48', NULL),
(298, 298, 30, 850000.00, '2026-08-05 21:51:55', NULL),
(299, 299, 60, 850000.00, '2026-08-17 11:37:25', NULL),
(300, 300, 47, 350000.00, '2026-07-07 21:11:39', NULL),
(301, 301, 42, 850000.00, '2026-08-01 11:32:42', NULL),
(302, 302, 61, 500000.00, '2026-06-30 02:43:52', NULL),
(303, 303, 44, 850000.00, '2026-03-28 14:49:42', NULL),
(304, 304, 60, 850000.00, '2026-06-11 15:07:36', NULL),
(305, 305, 64, 500000.00, '2026-07-25 13:30:52', NULL),
(306, 306, 67, 850000.00, '2026-10-04 16:24:56', NULL),
(307, 307, 28, 500000.00, '2026-09-22 05:07:17', NULL),
(308, 308, 26, 500000.00, '2026-08-12 23:02:46', NULL),
(309, 309, 69, 850000.00, '2026-08-06 14:30:56', NULL),
(310, 310, 15, 500000.00, '2026-07-12 17:20:53', NULL),
(311, 311, 11, 350000.00, '2026-08-17 17:23:55', NULL),
(312, 312, 41, 500000.00, '2026-06-21 06:21:31', NULL),
(313, 313, 30, 850000.00, '2026-06-28 03:28:00', NULL),
(314, 314, 28, 500000.00, '2026-07-19 13:26:05', NULL),
(315, 315, 7, 850000.00, '2026-06-29 16:10:24', NULL),
(316, 316, 53, 500000.00, '2026-07-14 05:51:51', NULL),
(317, 317, 68, 850000.00, '2026-06-15 21:43:42', NULL),
(318, 318, 37, 350000.00, '2026-05-12 05:57:06', NULL),
(319, 319, 4, 500000.00, '2026-03-30 10:26:11', NULL),
(320, 320, 72, 850000.00, '2026-03-27 12:48:38', NULL),
(321, 321, 33, 350000.00, '2026-07-13 15:50:16', NULL),
(322, 322, 71, 850000.00, '2026-07-01 21:58:00', NULL),
(323, 323, 45, 850000.00, '2026-06-08 13:39:37', NULL),
(324, 324, 42, 850000.00, '2026-06-19 00:04:16', NULL),
(325, 325, 33, 350000.00, '2026-08-02 07:32:53', NULL),
(326, 326, 18, 850000.00, '2026-06-23 01:08:41', NULL),
(327, 327, 3, 500000.00, '2026-10-01 14:36:35', NULL),
(328, 328, 23, 350000.00, '2026-09-09 04:03:40', NULL),
(329, 329, 64, 500000.00, '2026-06-01 04:57:11', NULL),
(330, 330, 60, 850000.00, '2026-07-23 13:31:41', NULL),
(331, 331, 37, 350000.00, '2026-04-09 07:52:11', NULL),
(332, 332, 46, 350000.00, '2026-09-15 00:50:53', NULL),
(333, 333, 46, 350000.00, '2026-04-25 03:55:48', NULL),
(334, 334, 4, 500000.00, '2026-06-05 21:38:14', NULL),
(335, 335, 53, 500000.00, '2026-08-12 19:02:03', NULL),
(336, 336, 47, 350000.00, '2026-08-27 10:53:12', NULL),
(337, 337, 27, 500000.00, '2026-10-13 11:35:04', NULL),
(338, 338, 56, 850000.00, '2026-06-02 06:20:33', NULL),
(339, 339, 14, 500000.00, '2026-09-27 10:32:32', NULL),
(340, 340, 5, 500000.00, '2026-10-02 15:22:23', NULL),
(341, 341, 46, 350000.00, '2026-04-17 11:53:31', NULL),
(342, 342, 28, 500000.00, '2026-08-12 05:12:20', NULL),
(343, 343, 7, 850000.00, '2026-07-01 00:50:44', NULL),
(344, 344, 43, 850000.00, '2026-06-02 22:27:51', NULL),
(345, 345, 41, 500000.00, '2026-06-14 02:37:01', NULL),
(346, 346, 63, 500000.00, '2026-09-12 00:17:41', NULL),
(347, 347, 31, 350000.00, '2026-03-21 16:12:56', NULL),
(348, 348, 58, 850000.00, '2026-07-22 14:02:16', NULL),
(349, 349, 12, 350000.00, '2026-06-08 08:59:55', NULL),
(350, 350, 47, 350000.00, '2026-07-30 12:08:31', NULL),
(351, 351, 38, 500000.00, '2026-09-26 19:35:08', NULL),
(352, 352, 29, 850000.00, '2026-10-12 12:26:54', NULL),
(353, 353, 18, 850000.00, '2026-04-04 14:13:48', NULL),
(354, 354, 11, 350000.00, '2026-05-12 16:41:37', NULL),
(355, 355, 31, 350000.00, '2026-10-17 05:26:47', NULL),
(356, 356, 34, 350000.00, '2026-07-07 20:44:15', NULL),
(357, 357, 71, 850000.00, '2026-07-10 23:51:39', NULL),
(358, 358, 5, 500000.00, '2026-07-27 19:28:18', NULL),
(359, 359, 64, 500000.00, '2026-07-28 20:44:52', NULL),
(360, 360, 62, 500000.00, '2026-08-15 20:46:55', NULL),
(361, 361, 5, 500000.00, '2026-10-07 18:56:56', NULL),
(362, 362, 41, 500000.00, '2026-09-09 01:31:31', NULL),
(363, 363, 64, 500000.00, '2026-06-29 21:08:22', NULL),
(364, 364, 16, 500000.00, '2026-05-30 09:02:44', NULL),
(365, 365, 37, 350000.00, '2026-08-03 02:40:39', NULL),
(366, 366, 45, 850000.00, '2026-05-24 15:38:46', NULL),
(367, 367, 5, 500000.00, '2026-09-03 15:28:24', NULL),
(368, 368, 34, 350000.00, '2026-05-19 09:57:16', NULL),
(369, 369, 48, 350000.00, '2026-06-17 19:55:59', NULL),
(370, 370, 60, 850000.00, '2026-06-19 05:39:59', NULL),
(371, 371, 51, 500000.00, '2026-06-25 13:09:34', NULL),
(372, 372, 24, 350000.00, '2026-09-14 15:40:27', NULL),
(373, 373, 55, 500000.00, '2026-08-23 17:11:21', NULL),
(374, 374, 75, 850000.00, '2026-07-27 00:08:35', NULL),
(375, 375, 10, 350000.00, '2026-08-29 14:53:25', NULL),
(376, 376, 69, 850000.00, '2026-07-18 13:16:10', NULL),
(377, 377, 54, 500000.00, '2026-08-10 06:53:09', NULL),
(378, 378, 6, 850000.00, '2026-08-10 20:22:00', NULL),
(379, 379, 52, 500000.00, '2026-05-23 07:23:24', NULL),
(380, 380, 15, 500000.00, '2026-07-19 15:20:23', NULL),
(381, 381, 33, 350000.00, '2026-04-23 04:13:31', NULL),
(382, 382, 38, 500000.00, '2026-03-26 07:14:43', NULL),
(383, 383, 5, 500000.00, '2026-09-15 15:14:50', NULL),
(384, 384, 42, 850000.00, '2026-07-29 08:42:59', NULL),
(385, 385, 48, 350000.00, '2026-05-29 14:31:37', NULL),
(386, 386, 48, 350000.00, '2026-04-13 22:30:03', NULL),
(387, 387, 47, 350000.00, '2026-06-21 23:30:22', NULL),
(388, 388, 75, 850000.00, '2026-09-25 01:30:21', NULL),
(389, 389, 3, 500000.00, '2026-04-12 19:58:23', NULL),
(390, 390, 8, 350000.00, '2026-04-17 23:54:04', NULL),
(391, 391, 18, 850000.00, '2026-07-03 16:49:22', NULL),
(392, 392, 64, 500000.00, '2026-06-18 22:02:41', NULL),
(393, 393, 65, 500000.00, '2026-04-10 18:07:40', NULL),
(394, 394, 53, 500000.00, '2026-08-27 17:13:47', NULL),
(395, 395, 25, 350000.00, '2026-08-30 13:34:52', NULL),
(396, 396, 25, 350000.00, '2026-06-23 23:44:12', NULL),
(397, 397, 11, 350000.00, '2026-05-06 23:48:24', NULL),
(398, 398, 12, 350000.00, '2026-07-08 10:13:59', NULL),
(399, 399, 19, 350000.00, '2026-06-27 07:36:31', NULL),
(400, 400, 18, 850000.00, '2026-03-25 10:18:12', NULL),
(401, 401, 46, 350000.00, '2026-08-01 05:26:36', NULL),
(402, 402, 58, 850000.00, '2026-09-12 14:04:15', NULL),
(403, 403, 51, 500000.00, '2026-05-21 14:16:43', NULL),
(404, 404, 53, 500000.00, '2026-07-18 04:29:04', NULL),
(405, 405, 15, 500000.00, '2026-04-08 00:35:08', NULL),
(406, 406, 69, 850000.00, '2026-05-24 13:03:01', NULL),
(407, 407, 4, 500000.00, '2026-08-12 18:19:09', NULL),
(408, 408, 66, 850000.00, '2026-08-19 20:09:21', NULL),
(409, 409, 3, 500000.00, '2026-07-01 21:28:03', NULL),
(410, 410, 73, 850000.00, '2026-07-09 05:45:09', NULL),
(411, 411, 38, 500000.00, '2026-06-02 13:07:20', NULL),
(412, 412, 46, 350000.00, '2026-04-17 18:25:48', NULL),
(413, 413, 23, 350000.00, '2026-06-24 07:00:50', NULL),
(414, 414, 13, 350000.00, '2026-07-14 23:43:06', NULL),
(415, 415, 12, 350000.00, '2026-10-07 03:57:18', NULL),
(416, 416, 24, 350000.00, '2026-09-27 04:22:23', NULL),
(417, 417, 22, 350000.00, '2026-07-08 16:22:12', NULL),
(418, 418, 2, 350000.00, '2026-09-23 16:26:39', NULL),
(419, 419, 45, 850000.00, '2026-10-18 07:12:12', NULL),
(420, 420, 17, 500000.00, '2026-04-09 19:21:14', NULL),
(421, 421, 68, 850000.00, '2026-07-20 19:05:48', NULL),
(422, 422, 64, 500000.00, '2026-05-27 06:03:48', NULL),
(423, 423, 52, 500000.00, '2026-05-17 22:45:39', NULL),
(424, 424, 32, 350000.00, '2026-09-08 15:50:29', NULL),
(425, 425, 28, 500000.00, '2026-08-11 02:38:26', NULL),
(426, 426, 61, 500000.00, '2026-05-31 15:24:40', NULL),
(427, 427, 15, 500000.00, '2026-04-28 22:46:11', NULL),
(428, 428, 50, 350000.00, '2026-06-14 01:46:43', NULL),
(429, 429, 29, 850000.00, '2026-06-26 07:41:48', NULL),
(430, 430, 31, 350000.00, '2026-03-27 11:33:37', NULL),
(431, 431, 63, 500000.00, '2026-07-02 13:05:27', NULL),
(432, 432, 75, 850000.00, '2026-03-31 16:43:18', NULL),
(433, 433, 67, 850000.00, '2026-09-13 18:07:36', NULL),
(434, 434, 69, 850000.00, '2026-05-27 09:19:46', NULL),
(435, 435, 27, 500000.00, '2026-03-31 10:26:34', NULL),
(436, 436, 3, 500000.00, '2026-06-11 23:39:50', NULL),
(437, 437, 70, 850000.00, '2026-03-23 17:15:43', NULL),
(438, 438, 13, 350000.00, '2026-05-09 09:34:08', NULL),
(439, 439, 72, 850000.00, '2026-03-26 04:27:05', NULL),
(440, 440, 49, 350000.00, '2026-08-15 17:53:34', NULL),
(441, 441, 4, 500000.00, '2026-04-22 00:26:35', NULL),
(442, 442, 68, 850000.00, '2026-09-28 11:14:13', NULL),
(443, 443, 33, 350000.00, '2026-04-16 01:30:00', NULL),
(444, 444, 42, 850000.00, '2026-06-13 20:01:40', NULL),
(445, 445, 26, 500000.00, '2026-05-30 11:24:48', NULL),
(446, 446, 6, 850000.00, '2026-05-04 18:00:54', NULL),
(447, 447, 60, 850000.00, '2026-07-15 05:54:20', NULL),
(448, 448, 45, 850000.00, '2026-05-24 01:23:06', NULL),
(449, 449, 49, 350000.00, '2026-04-29 17:45:54', NULL),
(450, 450, 33, 350000.00, '2026-04-27 01:01:23', NULL),
(451, 451, 7, 850000.00, '2026-05-05 14:00:56', NULL),
(452, 452, 15, 500000.00, '2026-05-29 19:50:43', NULL),
(453, 453, 8, 350000.00, '2026-05-27 19:34:24', NULL),
(454, 454, 41, 500000.00, '2026-09-28 20:11:01', NULL),
(455, 455, 65, 500000.00, '2026-05-18 22:06:04', NULL),
(456, 456, 9, 350000.00, '2026-06-07 12:01:00', NULL),
(457, 457, 11, 350000.00, '2026-07-09 04:41:51', NULL),
(458, 458, 22, 350000.00, '2026-04-25 19:54:44', NULL),
(459, 459, 69, 850000.00, '2026-07-07 14:08:47', NULL),
(460, 460, 73, 850000.00, '2026-08-29 08:47:54', NULL),
(461, 461, 61, 500000.00, '2026-08-03 23:47:34', NULL),
(462, 462, 55, 500000.00, '2026-10-09 09:49:48', NULL),
(463, 463, 62, 500000.00, '2026-04-11 06:16:18', NULL),
(464, 464, 69, 850000.00, '2026-07-28 00:42:22', NULL),
(465, 465, 39, 500000.00, '2026-10-13 20:14:55', NULL),
(466, 466, 2, 350000.00, '2026-03-30 16:01:18', NULL),
(467, 467, 39, 500000.00, '2026-05-21 13:57:58', NULL),
(468, 468, 5, 500000.00, '2026-05-07 21:14:55', NULL),
(469, 469, 44, 850000.00, '2026-07-14 15:46:20', NULL),
(470, 470, 65, 500000.00, '2026-03-26 08:58:33', NULL),
(471, 471, 48, 350000.00, '2026-07-06 06:25:22', NULL),
(472, 472, 25, 350000.00, '2026-05-19 04:45:31', NULL),
(473, 473, 59, 850000.00, '2026-05-03 19:56:32', NULL),
(474, 474, 75, 850000.00, '2026-10-11 22:00:40', NULL),
(475, 475, 11, 350000.00, '2026-04-18 10:05:23', NULL),
(476, 476, 37, 350000.00, '2026-05-13 10:46:01', NULL),
(477, 477, 69, 850000.00, '2026-08-14 17:27:12', NULL),
(478, 478, 16, 500000.00, '2026-08-24 13:07:31', NULL),
(479, 479, 38, 500000.00, '2026-09-01 02:41:40', NULL),
(480, 480, 15, 500000.00, '2026-09-06 16:15:58', NULL),
(481, 481, 17, 500000.00, '2026-08-30 01:38:17', NULL),
(482, 482, 52, 500000.00, '2026-08-18 05:37:22', NULL),
(483, 483, 23, 350000.00, '2026-08-06 13:45:41', NULL),
(484, 484, 11, 350000.00, '2026-06-16 13:50:41', NULL),
(485, 485, 36, 350000.00, '2026-06-10 08:31:48', NULL),
(486, 486, 20, 350000.00, '2026-08-29 02:45:28', NULL),
(487, 487, 58, 850000.00, '2026-07-21 11:20:01', NULL),
(488, 488, 44, 850000.00, '2026-07-09 11:46:28', NULL),
(489, 489, 6, 850000.00, '2026-08-16 15:56:45', NULL),
(490, 490, 37, 350000.00, '2026-09-07 22:49:32', NULL),
(491, 491, 57, 850000.00, '2026-08-26 16:36:57', NULL),
(492, 492, 43, 850000.00, '2026-07-30 15:05:16', NULL),
(493, 493, 26, 500000.00, '2026-05-05 08:02:57', NULL),
(494, 494, 6, 850000.00, '2026-08-04 08:33:05', NULL),
(495, 495, 14, 500000.00, '2026-08-29 08:04:32', NULL),
(496, 496, 47, 350000.00, '2026-07-09 16:09:41', NULL),
(497, 497, 50, 350000.00, '2026-04-11 12:35:36', NULL),
(498, 498, 49, 350000.00, '2026-04-24 21:59:41', NULL),
(499, 499, 33, 350000.00, '2026-05-10 05:52:14', NULL),
(500, 500, 32, 350000.00, '2026-09-02 14:17:20', NULL),
(501, 501, 58, 850000.00, '2026-08-13 18:20:27', NULL),
(502, 502, 67, 850000.00, '2026-05-08 05:52:25', NULL),
(503, 503, 16, 500000.00, '2026-10-07 04:19:56', NULL),
(504, 504, 55, 500000.00, '2026-09-05 16:29:46', NULL),
(505, 505, 12, 350000.00, '2026-05-21 11:17:11', NULL),
(506, 506, 22, 350000.00, '2026-10-06 16:49:53', NULL),
(507, 507, 62, 500000.00, '2026-05-30 12:38:57', NULL),
(508, 508, 25, 350000.00, '2026-09-03 12:07:37', NULL),
(509, 509, 35, 350000.00, '2026-08-21 22:50:24', NULL),
(510, 510, 27, 500000.00, '2026-08-05 00:39:49', NULL),
(511, 511, 57, 850000.00, '2026-09-25 01:25:59', NULL),
(512, 512, 24, 350000.00, '2026-05-31 16:46:33', NULL),
(513, 513, 24, 350000.00, '2026-06-04 10:39:27', NULL),
(514, 514, 22, 350000.00, '2026-08-26 14:04:28', NULL),
(515, 515, 3, 500000.00, '2026-10-18 00:59:53', NULL),
(516, 516, 56, 850000.00, '2026-07-25 05:43:07', NULL),
(517, 517, 2, 350000.00, '2026-08-18 10:11:34', NULL),
(518, 518, 25, 350000.00, '2026-05-21 18:38:46', NULL),
(519, 519, 2, 350000.00, '2026-05-14 21:26:08', NULL),
(520, 520, 51, 500000.00, '2026-07-09 15:27:32', NULL),
(521, 521, 17, 500000.00, '2026-06-22 20:40:17', NULL),
(522, 522, 20, 350000.00, '2026-04-20 04:15:56', NULL),
(523, 523, 11, 350000.00, '2026-07-16 07:54:18', NULL),
(524, 524, 49, 350000.00, '2026-09-11 08:39:37', NULL),
(525, 525, 47, 350000.00, '2026-07-08 06:43:03', NULL),
(526, 526, 51, 500000.00, '2026-05-08 01:44:09', NULL),
(527, 527, 63, 500000.00, '2026-05-28 11:48:52', NULL),
(528, 528, 55, 500000.00, '2026-06-29 23:32:59', NULL),
(529, 529, 43, 850000.00, '2026-07-18 04:08:46', NULL),
(530, 530, 72, 850000.00, '2026-07-01 21:49:14', NULL),
(531, 531, 34, 350000.00, '2026-07-12 06:25:21', NULL),
(532, 532, 13, 350000.00, '2026-05-07 14:05:23', NULL),
(533, 533, 48, 350000.00, '2026-07-26 09:56:50', NULL),
(534, 534, 25, 350000.00, '2026-05-04 22:14:35', NULL),
(535, 535, 27, 500000.00, '2026-08-09 18:25:43', NULL),
(536, 536, 1, 350000.00, '2026-10-19 03:35:58', NULL),
(537, 537, 1, 350000.00, '2026-04-05 10:59:14', NULL),
(538, 538, 18, 850000.00, '2026-03-26 20:35:44', NULL),
(539, 539, 46, 350000.00, '2026-08-11 00:07:42', NULL),
(540, 540, 35, 350000.00, '2026-09-18 21:35:01', NULL),
(541, 541, 28, 500000.00, '2026-06-27 00:19:08', NULL),
(542, 542, 39, 500000.00, '2026-08-17 23:10:29', NULL),
(543, 543, 39, 500000.00, '2026-09-21 16:30:45', NULL),
(544, 544, 12, 350000.00, '2026-07-08 06:05:29', NULL),
(545, 545, 69, 850000.00, '2026-07-25 00:28:11', NULL),
(546, 546, 30, 850000.00, '2026-09-07 19:04:30', NULL),
(547, 547, 18, 850000.00, '2026-07-24 04:59:45', NULL),
(548, 548, 22, 350000.00, '2026-04-13 21:00:34', NULL),
(549, 549, 61, 500000.00, '2026-03-29 17:14:58', NULL),
(550, 550, 36, 350000.00, '2026-10-09 12:19:45', NULL),
(551, 551, 11, 350000.00, '2026-05-07 20:50:20', NULL),
(552, 552, 40, 500000.00, '2026-07-22 10:13:53', NULL),
(553, 553, 40, 500000.00, '2026-08-04 14:32:45', NULL),
(554, 554, 60, 850000.00, '2026-03-30 01:51:00', NULL),
(555, 555, 74, 850000.00, '2026-10-06 19:44:05', NULL),
(556, 556, 25, 350000.00, '2026-05-06 21:44:50', NULL),
(557, 557, 23, 350000.00, '2026-10-18 14:26:39', NULL),
(558, 558, 58, 850000.00, '2026-07-10 01:58:00', NULL),
(559, 559, 14, 500000.00, '2026-04-07 16:30:23', NULL),
(560, 560, 26, 500000.00, '2026-06-21 03:47:08', NULL),
(561, 561, 38, 500000.00, '2026-10-05 13:14:56', NULL),
(562, 562, 34, 350000.00, '2026-05-04 07:43:17', NULL),
(563, 563, 63, 500000.00, '2026-05-24 04:13:08', NULL),
(564, 564, 20, 350000.00, '2026-05-17 17:47:50', NULL),
(565, 565, 34, 350000.00, '2026-07-27 04:04:45', NULL),
(566, 566, 60, 850000.00, '2026-05-09 08:54:14', NULL),
(567, 567, 40, 500000.00, '2026-07-25 18:13:24', NULL),
(568, 568, 41, 500000.00, '2026-08-24 02:33:46', NULL),
(569, 569, 74, 850000.00, '2026-08-24 09:03:01', NULL),
(570, 570, 6, 850000.00, '2026-07-06 00:19:01', NULL),
(571, 571, 38, 500000.00, '2026-08-01 18:34:42', NULL),
(572, 572, 25, 350000.00, '2026-05-21 14:51:25', NULL),
(573, 573, 17, 500000.00, '2026-07-07 04:39:43', NULL),
(574, 574, 58, 850000.00, '2026-06-23 07:23:16', NULL),
(575, 575, 74, 850000.00, '2026-04-30 11:36:39', NULL),
(576, 576, 70, 850000.00, '2026-06-06 20:21:47', NULL),
(577, 577, 48, 350000.00, '2026-03-23 00:38:16', NULL),
(578, 578, 26, 500000.00, '2026-08-17 09:12:26', NULL),
(579, 579, 10, 350000.00, '2026-05-14 06:16:25', NULL),
(580, 580, 67, 850000.00, '2026-04-16 20:22:20', NULL),
(581, 581, 73, 850000.00, '2026-08-15 17:10:55', NULL),
(582, 582, 47, 350000.00, '2026-08-04 11:38:50', NULL),
(583, 583, 71, 850000.00, '2026-07-01 06:29:41', NULL),
(584, 584, 39, 500000.00, '2026-05-16 02:09:05', NULL),
(585, 585, 71, 850000.00, '2026-07-05 17:16:04', NULL),
(586, 586, 1, 350000.00, '2026-07-01 19:05:28', NULL),
(587, 587, 37, 350000.00, '2026-05-17 09:17:41', NULL),
(588, 588, 33, 350000.00, '2026-04-15 20:25:35', NULL),
(589, 589, 68, 850000.00, '2026-09-17 12:40:48', NULL),
(590, 590, 28, 500000.00, '2026-06-29 23:07:34', NULL),
(591, 591, 59, 850000.00, '2026-08-08 15:18:38', NULL),
(592, 592, 34, 350000.00, '2026-10-19 09:26:06', NULL),
(593, 593, 25, 350000.00, '2026-04-25 00:43:20', NULL),
(594, 594, 12, 350000.00, '2026-05-13 19:14:36', NULL),
(595, 595, 33, 350000.00, '2026-04-28 16:20:44', NULL),
(596, 596, 6, 850000.00, '2026-08-02 00:16:14', NULL),
(597, 597, 55, 500000.00, '2026-07-10 11:05:08', NULL),
(598, 598, 32, 350000.00, '2026-06-29 06:01:13', NULL),
(599, 599, 38, 500000.00, '2026-07-09 18:11:23', NULL),
(600, 600, 42, 850000.00, '2026-07-22 20:11:20', NULL),
(601, 601, 44, 850000.00, '2026-07-25 06:28:43', NULL),
(602, 602, 52, 500000.00, '2026-08-15 14:46:07', NULL),
(603, 603, 37, 350000.00, '2026-07-24 15:37:15', NULL),
(604, 604, 28, 500000.00, '2026-06-07 10:07:03', NULL),
(605, 605, 3, 500000.00, '2026-08-27 08:47:39', NULL),
(606, 606, 50, 350000.00, '2026-05-12 04:45:04', NULL),
(607, 607, 45, 850000.00, '2026-04-27 19:40:36', NULL),
(608, 608, 36, 350000.00, '2026-04-06 08:14:14', NULL),
(609, 609, 26, 500000.00, '2026-07-28 03:21:04', NULL),
(610, 610, 16, 500000.00, '2026-07-03 08:25:00', NULL),
(611, 611, 25, 350000.00, '2026-04-27 21:35:19', NULL),
(612, 612, 71, 850000.00, '2026-06-12 21:28:25', NULL),
(613, 613, 50, 350000.00, '2026-09-02 23:26:20', NULL),
(614, 614, 15, 500000.00, '2026-10-07 02:06:57', NULL),
(615, 615, 4, 500000.00, '2026-07-23 13:21:35', NULL),
(616, 616, 18, 850000.00, '2026-06-22 21:14:58', NULL),
(617, 617, 74, 850000.00, '2026-06-30 04:45:18', NULL),
(618, 618, 29, 850000.00, '2026-05-30 18:52:52', NULL),
(619, 619, 39, 500000.00, '2026-06-25 22:15:31', NULL),
(620, 620, 24, 350000.00, '2026-03-22 13:11:31', NULL),
(621, 621, 43, 850000.00, '2026-10-06 03:49:33', NULL),
(622, 622, 21, 350000.00, '2026-07-26 22:35:19', NULL),
(623, 623, 1, 350000.00, '2026-07-08 14:02:41', NULL),
(624, 624, 45, 850000.00, '2026-06-19 08:39:52', NULL),
(625, 625, 49, 350000.00, '2026-05-05 07:40:32', NULL),
(626, 626, 64, 500000.00, '2026-07-20 04:13:54', NULL),
(627, 627, 10, 350000.00, '2026-09-09 23:07:21', NULL),
(628, 628, 69, 850000.00, '2026-05-02 08:42:09', NULL),
(629, 629, 34, 350000.00, '2026-04-08 22:34:09', NULL),
(630, 630, 7, 850000.00, '2026-04-21 14:03:20', NULL),
(631, 631, 60, 850000.00, '2026-04-08 20:05:22', NULL),
(632, 632, 31, 350000.00, '2026-09-11 19:22:36', NULL),
(633, 633, 17, 500000.00, '2026-04-06 16:35:42', NULL),
(634, 634, 9, 350000.00, '2026-03-29 10:51:25', NULL),
(635, 635, 6, 850000.00, '2026-05-29 17:51:40', NULL),
(636, 636, 72, 850000.00, '2026-05-26 08:09:46', NULL),
(637, 637, 68, 850000.00, '2026-07-21 00:53:05', NULL),
(638, 638, 6, 850000.00, '2026-07-30 17:56:13', NULL),
(639, 639, 9, 350000.00, '2026-05-08 23:49:15', NULL),
(640, 640, 56, 850000.00, '2026-08-20 13:08:12', NULL),
(641, 641, 28, 500000.00, '2026-04-19 08:24:35', NULL),
(642, 642, 32, 350000.00, '2026-10-12 15:46:26', NULL),
(643, 643, 41, 500000.00, '2026-10-17 06:24:27', NULL),
(644, 644, 69, 850000.00, '2026-05-04 20:01:50', NULL),
(645, 645, 41, 500000.00, '2026-09-24 23:07:08', NULL),
(646, 646, 2, 350000.00, '2026-06-28 11:54:32', NULL),
(647, 647, 6, 850000.00, '2026-08-28 11:43:21', NULL),
(648, 648, 40, 500000.00, '2026-04-01 23:33:22', NULL),
(649, 649, 65, 500000.00, '2026-07-23 01:03:59', NULL),
(650, 650, 26, 500000.00, '2026-03-31 13:12:59', NULL),
(651, 651, 72, 850000.00, '2026-10-03 11:32:57', NULL),
(652, 652, 46, 350000.00, '2026-03-28 01:49:01', NULL),
(653, 653, 64, 500000.00, '2026-07-02 03:01:50', NULL),
(654, 654, 21, 350000.00, '2026-06-01 18:55:32', NULL),
(655, 655, 73, 850000.00, '2026-10-04 23:11:18', NULL),
(656, 656, 54, 500000.00, '2026-06-01 04:44:41', NULL),
(657, 657, 10, 350000.00, '2026-10-20 02:42:22', NULL),
(658, 658, 17, 500000.00, '2026-10-14 04:09:38', NULL),
(659, 659, 63, 500000.00, '2026-06-15 05:22:38', NULL),
(660, 660, 66, 850000.00, '2026-09-30 20:42:29', NULL),
(661, 661, 15, 500000.00, '2026-10-06 11:51:05', NULL),
(662, 662, 50, 350000.00, '2026-10-10 14:09:55', NULL),
(663, 663, 27, 500000.00, '2026-05-27 08:39:44', NULL),
(664, 664, 22, 350000.00, '2026-07-25 05:26:22', NULL),
(665, 665, 3, 500000.00, '2026-08-21 07:57:18', NULL),
(666, 666, 52, 500000.00, '2026-03-27 18:26:04', NULL),
(667, 667, 6, 850000.00, '2026-10-11 09:56:14', NULL),
(668, 668, 63, 500000.00, '2026-08-20 21:59:26', NULL),
(669, 669, 15, 500000.00, '2026-05-12 05:06:45', NULL),
(670, 670, 53, 500000.00, '2026-08-02 21:44:56', NULL),
(671, 671, 75, 850000.00, '2026-06-15 15:55:14', NULL),
(672, 672, 71, 850000.00, '2026-05-12 04:50:29', NULL),
(673, 673, 61, 500000.00, '2026-03-22 04:13:54', NULL),
(674, 674, 37, 350000.00, '2026-04-17 23:53:03', NULL),
(675, 675, 53, 500000.00, '2026-09-14 19:22:47', NULL),
(676, 676, 29, 850000.00, '2026-08-14 13:54:29', NULL),
(677, 677, 39, 500000.00, '2026-08-14 04:16:23', NULL),
(678, 678, 8, 350000.00, '2026-07-17 23:46:30', NULL),
(679, 679, 37, 350000.00, '2026-05-06 11:18:23', NULL),
(680, 680, 41, 500000.00, '2026-05-18 11:37:16', NULL),
(681, 681, 11, 350000.00, '2026-05-28 22:24:06', NULL),
(682, 682, 26, 500000.00, '2026-06-19 06:11:54', NULL),
(683, 683, 42, 850000.00, '2026-06-20 07:07:54', NULL),
(684, 684, 12, 350000.00, '2026-07-20 17:34:39', NULL),
(685, 685, 73, 850000.00, '2026-09-06 03:41:12', NULL),
(686, 686, 61, 500000.00, '2026-08-26 02:09:14', NULL),
(687, 687, 31, 350000.00, '2026-05-03 04:59:49', NULL),
(688, 688, 34, 350000.00, '2026-10-04 08:32:03', NULL),
(689, 689, 10, 350000.00, '2026-03-22 22:03:44', NULL),
(690, 690, 62, 500000.00, '2026-06-05 21:57:23', NULL),
(691, 691, 43, 850000.00, '2026-06-27 16:46:56', NULL),
(692, 692, 13, 350000.00, '2026-07-24 01:28:11', NULL),
(693, 693, 46, 350000.00, '2026-05-14 05:16:44', NULL),
(694, 694, 12, 350000.00, '2026-10-09 09:51:05', NULL),
(695, 695, 70, 850000.00, '2026-06-22 10:52:06', NULL),
(696, 696, 45, 850000.00, '2026-07-23 05:35:11', NULL),
(697, 697, 13, 350000.00, '2026-07-27 14:53:05', NULL),
(698, 698, 41, 500000.00, '2026-05-25 01:56:06', NULL),
(699, 699, 21, 350000.00, '2026-06-15 12:00:25', NULL),
(700, 700, 66, 850000.00, '2026-08-16 13:18:02', NULL),
(701, 701, 49, 350000.00, '2026-09-17 02:19:04', NULL),
(702, 702, 57, 850000.00, '2026-04-11 18:49:26', NULL),
(703, 703, 38, 500000.00, '2026-06-17 16:29:48', NULL),
(704, 704, 8, 350000.00, '2026-05-15 06:53:46', NULL),
(705, 705, 1, 350000.00, '2026-07-04 03:31:41', NULL),
(706, 706, 8, 350000.00, '2026-09-07 19:45:20', NULL),
(707, 707, 29, 850000.00, '2026-08-10 14:14:41', NULL),
(708, 708, 62, 500000.00, '2026-05-20 09:36:19', NULL),
(709, 709, 9, 350000.00, '2026-03-23 14:17:36', NULL),
(710, 710, 43, 850000.00, '2026-10-03 21:03:54', NULL),
(711, 711, 71, 850000.00, '2026-03-27 11:11:10', NULL),
(712, 712, 31, 350000.00, '2026-03-24 21:08:46', NULL),
(713, 713, 38, 500000.00, '2026-05-26 17:20:40', NULL),
(714, 714, 64, 500000.00, '2026-05-23 07:13:52', NULL),
(715, 715, 39, 500000.00, '2026-05-16 04:40:12', NULL),
(716, 716, 42, 850000.00, '2026-09-16 15:04:25', NULL),
(717, 717, 64, 500000.00, '2026-05-20 18:36:48', NULL),
(718, 718, 16, 500000.00, '2026-08-05 00:51:34', NULL),
(719, 719, 22, 350000.00, '2026-10-11 14:12:47', NULL),
(720, 720, 23, 350000.00, '2026-08-14 07:16:10', NULL),
(721, 721, 44, 850000.00, '2026-09-15 13:54:44', NULL),
(722, 722, 14, 500000.00, '2026-03-24 21:11:24', NULL),
(723, 723, 68, 850000.00, '2026-07-09 03:33:29', NULL),
(724, 724, 28, 500000.00, '2026-09-29 19:02:17', NULL),
(725, 725, 64, 500000.00, '2026-05-02 13:52:15', NULL),
(726, 726, 61, 500000.00, '2026-05-30 08:37:21', NULL),
(727, 727, 63, 500000.00, '2026-04-08 07:53:17', NULL),
(728, 728, 19, 350000.00, '2026-04-01 14:56:16', NULL),
(729, 729, 11, 350000.00, '2026-05-26 09:32:47', NULL),
(730, 730, 59, 850000.00, '2026-10-05 08:42:30', NULL),
(731, 731, 16, 500000.00, '2026-07-22 22:37:53', NULL),
(732, 732, 50, 350000.00, '2026-04-22 07:42:01', NULL),
(733, 733, 63, 500000.00, '2026-06-10 18:32:59', NULL),
(734, 734, 9, 350000.00, '2026-09-17 02:26:12', NULL),
(735, 735, 72, 850000.00, '2026-10-06 05:58:13', NULL),
(736, 736, 6, 850000.00, '2026-09-02 18:43:17', NULL),
(737, 737, 11, 350000.00, '2026-05-22 22:51:48', NULL),
(738, 738, 70, 850000.00, '2026-09-18 14:41:57', NULL),
(739, 739, 38, 500000.00, '2026-10-13 09:35:47', NULL),
(740, 740, 58, 850000.00, '2026-08-01 21:22:28', NULL),
(741, 741, 23, 350000.00, '2026-03-30 08:49:42', NULL),
(742, 742, 3, 500000.00, '2026-08-12 20:36:57', NULL),
(743, 743, 5, 500000.00, '2026-07-15 07:42:40', NULL),
(744, 744, 67, 850000.00, '2026-04-28 00:45:54', NULL),
(745, 745, 37, 350000.00, '2026-08-30 15:19:28', NULL),
(746, 746, 57, 850000.00, '2026-03-31 23:13:43', NULL),
(747, 747, 73, 850000.00, '2026-09-24 10:13:54', NULL),
(748, 748, 5, 500000.00, '2026-06-10 17:02:58', NULL),
(749, 749, 43, 850000.00, '2026-07-14 20:41:59', NULL),
(750, 750, 21, 350000.00, '2026-09-25 08:49:53', NULL),
(751, 751, 5, 500000.00, '2026-06-06 09:11:58', NULL),
(752, 752, 24, 350000.00, '2026-04-18 21:25:16', NULL),
(753, 753, 43, 850000.00, '2026-05-22 14:44:33', NULL),
(754, 754, 9, 350000.00, '2026-08-20 20:54:10', NULL),
(755, 755, 49, 350000.00, '2026-09-17 19:04:06', NULL),
(756, 756, 19, 350000.00, '2026-09-26 22:12:45', NULL),
(757, 757, 66, 850000.00, '2026-05-31 00:15:23', NULL),
(758, 758, 14, 500000.00, '2026-05-23 00:44:45', NULL),
(759, 759, 47, 350000.00, '2026-06-29 16:57:48', NULL),
(760, 760, 56, 850000.00, '2026-06-02 10:52:48', NULL),
(761, 761, 23, 350000.00, '2026-05-02 02:16:32', NULL),
(762, 762, 46, 350000.00, '2026-09-15 10:08:23', NULL),
(763, 763, 50, 350000.00, '2026-04-15 16:36:38', NULL),
(764, 764, 30, 850000.00, '2026-06-18 05:02:57', NULL),
(765, 765, 53, 500000.00, '2026-09-11 22:01:02', NULL),
(766, 766, 8, 350000.00, '2026-06-03 07:43:43', NULL),
(767, 767, 64, 500000.00, '2026-03-20 10:13:47', NULL),
(768, 768, 9, 350000.00, '2026-05-07 04:53:29', NULL),
(769, 769, 16, 500000.00, '2026-10-16 03:39:02', NULL),
(770, 770, 34, 350000.00, '2026-07-21 06:04:27', NULL),
(771, 771, 21, 350000.00, '2026-04-10 00:50:53', NULL),
(772, 772, 11, 350000.00, '2026-05-23 17:09:07', NULL),
(773, 773, 15, 500000.00, '2026-06-12 21:39:27', NULL),
(774, 774, 62, 500000.00, '2026-06-16 16:08:51', NULL),
(775, 775, 22, 350000.00, '2026-06-18 20:28:26', NULL),
(776, 776, 69, 850000.00, '2026-08-16 20:34:24', NULL),
(777, 777, 67, 850000.00, '2026-05-19 00:13:13', NULL),
(778, 778, 26, 500000.00, '2026-06-27 22:37:16', NULL),
(779, 779, 26, 500000.00, '2026-08-03 20:02:18', NULL),
(780, 780, 48, 350000.00, '2026-06-17 18:45:27', NULL),
(781, 781, 16, 500000.00, '2026-08-30 02:23:35', NULL),
(782, 782, 8, 350000.00, '2026-05-24 15:10:04', NULL),
(783, 783, 4, 500000.00, '2026-06-01 15:55:09', NULL),
(784, 784, 39, 500000.00, '2026-10-04 16:58:58', NULL),
(785, 785, 15, 500000.00, '2026-06-05 22:02:46', NULL),
(786, 786, 5, 500000.00, '2026-05-30 21:58:34', NULL),
(787, 787, 64, 500000.00, '2026-04-02 15:01:08', NULL),
(788, 788, 12, 350000.00, '2026-06-23 11:53:58', NULL),
(789, 789, 12, 350000.00, '2026-09-06 23:13:52', NULL),
(790, 790, 37, 350000.00, '2026-06-10 11:04:31', NULL),
(791, 791, 31, 350000.00, '2026-10-14 20:49:52', NULL),
(792, 792, 24, 350000.00, '2026-09-22 21:10:50', NULL),
(793, 793, 58, 850000.00, '2026-09-18 08:42:39', NULL),
(794, 794, 33, 350000.00, '2026-05-26 20:15:41', NULL),
(795, 795, 61, 500000.00, '2026-08-28 12:00:46', NULL),
(796, 796, 63, 500000.00, '2026-10-14 11:45:53', NULL),
(797, 797, 54, 500000.00, '2026-06-28 06:12:29', NULL),
(798, 798, 31, 350000.00, '2026-04-23 06:24:40', NULL),
(799, 799, 29, 850000.00, '2026-06-17 08:48:43', NULL),
(800, 800, 22, 350000.00, '2026-08-24 23:31:50', NULL),
(801, 801, 35, 350000.00, '2026-09-22 09:20:58', NULL),
(802, 802, 14, 500000.00, '2026-09-22 09:20:58', NULL),
(803, 803, 70, 850000.00, '2026-09-22 09:20:58', NULL),
(804, 804, 43, 850000.00, '2026-09-22 09:20:58', NULL),
(805, 805, 34, 350000.00, '2026-09-22 09:20:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int UNSIGNED NOT NULL,
  `room_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` int UNSIGNED NOT NULL,
  `floor` tinyint UNSIGNED NOT NULL,
  `status` enum('vacant_clean','vacant_dirty','occupied','on_change','out_of_order','out_of_service') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vacant_clean',
  `pos_x` smallint UNSIGNED NOT NULL DEFAULT '0',
  `pos_y` smallint UNSIGNED NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `floor`, `status`, `pos_x`, `pos_y`, `notes`, `created_at`, `updated_at`) VALUES
(1, '101', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-21 10:59:10', '2026-09-23 03:54:15'),
(2, '102', 1, 1, 'occupied', 0, 0, NULL, '2026-09-21 10:59:10', '2026-09-21 12:45:02'),
(3, '103', 2, 1, 'occupied', 0, 0, NULL, '2026-09-21 10:59:10', '2026-09-21 08:29:38'),
(4, '104', 2, 1, 'on_change', 0, 0, NULL, '2026-09-21 10:59:10', '2026-09-22 06:02:56'),
(5, '201', 2, 2, 'vacant_clean', 0, 0, NULL, '2026-09-21 10:59:10', NULL),
(6, '202', 3, 2, 'out_of_service', 0, 0, NULL, '2026-09-21 10:59:10', '2026-09-21 07:50:57'),
(7, '203', 3, 2, 'vacant_clean', 0, 0, NULL, '2026-09-21 10:59:10', NULL),
(8, '105', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(9, '106', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(10, '107', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(11, '108', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(12, '109', 1, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(13, '110', 1, 1, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(14, '111', 2, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(15, '112', 2, 1, 'vacant_dirty', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(16, '113', 2, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(17, '114', 2, 1, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(18, '115', 3, 1, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(19, '204', 1, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(20, '205', 1, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(21, '206', 1, 2, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(22, '207', 1, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(23, '208', 1, 2, 'vacant_dirty', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(24, '209', 1, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(25, '210', 1, 2, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(26, '211', 2, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(27, '212', 2, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(28, '213', 2, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(29, '214', 3, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(30, '215', 3, 2, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(31, '301', 1, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(32, '302', 1, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(33, '303', 1, 3, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(34, '304', 1, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(35, '305', 1, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(36, '306', 1, 3, 'vacant_dirty', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(37, '307', 1, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(38, '308', 2, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(39, '309', 2, 3, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(40, '310', 2, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(41, '311', 2, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(42, '312', 3, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(43, '313', 3, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(44, '314', 3, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(45, '315', 3, 3, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(46, '401', 1, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(47, '402', 1, 4, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(48, '403', 1, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(49, '404', 1, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(50, '405', 1, 4, 'vacant_dirty', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(51, '406', 2, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(52, '407', 2, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(53, '408', 2, 4, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(54, '409', 2, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(55, '410', 2, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(56, '411', 3, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(57, '412', 3, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(58, '413', 3, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(59, '414', 3, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(60, '415', 3, 4, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(61, '501', 2, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(62, '502', 2, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(63, '503', 2, 5, 'occupied', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(64, '504', 2, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(65, '505', 2, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(66, '506', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(67, '507', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(68, '508', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(69, '509', 3, 5, 'vacant_dirty', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(70, '510', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(71, '511', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(72, '512', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(73, '513', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(74, '514', 3, 5, 'vacant_clean', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58'),
(75, '515', 3, 5, 'out_of_order', 0, 0, NULL, '2026-09-22 16:15:58', '2026-09-22 16:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `capacity` tinyint UNSIGNED NOT NULL DEFAULT '2',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `base_price`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 350000.00, 2, 'Kamar standar dengan 1 tempat tidur queen', '2026-09-21 10:59:10', NULL),
(2, 'Deluxe', 500000.00, 2, 'Kamar deluxe dengan pemandangan kota', '2026-09-21 10:59:10', NULL),
(3, 'Suite', 850000.00, 4, 'Suite dengan ruang tamu terpisah', '2026-09-21 10:59:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `type` varchar(31) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `context` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sr_details`
--

CREATE TABLE `sr_details` (
  `id` int UNSIGNED NOT NULL,
  `sr_id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `quantity_requested` int UNSIGNED NOT NULL,
  `quantity_approved` int UNSIGNED NOT NULL DEFAULT '0',
  `notes` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sr_details`
--

INSERT INTO `sr_details` (`id`, `sr_id`, `item_id`, `quantity_requested`, `quantity_approved`, `notes`, `created_at`) VALUES
(1, 1, 4, 21, 16, NULL, '2026-09-02 22:59:12'),
(2, 2, 2, 8, 5, NULL, '2026-08-27 22:23:00'),
(3, 2, 3, 5, 1, NULL, '2026-08-27 22:23:00'),
(4, 3, 4, 27, 23, NULL, '2026-08-03 07:44:22'),
(5, 4, 2, 30, 14, NULL, '2026-09-22 03:20:30'),
(6, 5, 1, 22, 7, NULL, '2026-06-26 22:34:48'),
(7, 6, 2, 10, 9, NULL, '2026-07-22 22:22:16'),
(8, 6, 1, 16, 5, NULL, '2026-07-22 22:22:16'),
(9, 7, 2, 9, 4, NULL, '2026-09-16 05:11:00'),
(10, 7, 3, 17, 14, NULL, '2026-09-16 05:11:00'),
(11, 8, 2, 26, 5, NULL, '2026-09-11 19:40:30'),
(12, 8, 3, 17, 2, NULL, '2026-09-11 19:40:30'),
(13, 9, 2, 26, 0, NULL, '2026-07-02 12:45:17'),
(14, 9, 1, 30, 0, NULL, '2026-07-02 12:45:17'),
(15, 10, 2, 8, 7, NULL, '2026-08-14 11:15:25'),
(16, 10, 4, 24, 4, NULL, '2026-08-14 11:15:25'),
(17, 11, 2, 23, 4, NULL, '2026-07-11 17:17:00'),
(18, 11, 4, 9, 1, NULL, '2026-07-11 17:17:00'),
(19, 12, 3, 23, 3, NULL, '2026-08-11 05:33:33'),
(20, 12, 4, 9, 8, NULL, '2026-08-11 05:33:33'),
(21, 13, 3, 8, 3, NULL, '2026-07-11 23:28:40'),
(22, 14, 4, 16, 4, NULL, '2026-09-02 02:51:07'),
(23, 14, 1, 29, 15, NULL, '2026-09-02 02:51:07'),
(24, 15, 3, 22, 5, NULL, '2026-06-27 16:07:42'),
(25, 15, 4, 29, 27, NULL, '2026-06-27 16:07:42'),
(26, 16, 1, 12, 6, NULL, '2026-08-05 03:04:06'),
(27, 16, 2, 6, 2, NULL, '2026-08-05 03:04:06'),
(28, 17, 1, 28, 17, NULL, '2026-08-15 10:16:28'),
(29, 17, 3, 28, 10, NULL, '2026-08-15 10:16:28'),
(30, 17, 4, 26, 7, NULL, '2026-08-15 10:16:28'),
(31, 18, 1, 6, 4, NULL, '2026-06-28 15:58:34'),
(32, 19, 4, 24, 24, NULL, '2026-08-02 13:42:38'),
(33, 20, 3, 15, 3, NULL, '2026-07-07 15:09:16'),
(34, 20, 4, 29, 12, NULL, '2026-07-07 15:09:16'),
(35, 20, 2, 12, 12, NULL, '2026-07-07 15:09:16'),
(36, 21, 1, 16, 8, NULL, '2026-07-19 06:08:38'),
(37, 22, 2, 29, 0, NULL, '2026-09-07 02:21:10'),
(38, 22, 1, 23, 0, NULL, '2026-09-07 02:21:10'),
(39, 22, 4, 10, 0, NULL, '2026-09-07 02:21:10'),
(40, 23, 4, 19, 5, NULL, '2026-06-28 18:21:21'),
(41, 23, 1, 10, 10, NULL, '2026-06-28 18:21:21'),
(42, 23, 3, 12, 8, NULL, '2026-06-28 18:21:21'),
(43, 24, 2, 16, 0, NULL, '2026-09-10 02:33:10'),
(44, 24, 3, 9, 0, NULL, '2026-09-10 02:33:10'),
(45, 25, 3, 21, 16, NULL, '2026-08-27 13:28:14'),
(46, 25, 2, 28, 15, NULL, '2026-08-27 13:28:14'),
(47, 26, 1, 11, 11, NULL, '2026-08-21 18:34:12'),
(48, 27, 1, 7, 6, NULL, '2026-08-26 14:07:45'),
(49, 27, 2, 18, 16, NULL, '2026-08-26 14:07:45'),
(50, 27, 4, 13, 7, NULL, '2026-08-26 14:07:45'),
(51, 28, 3, 30, 7, NULL, '2026-08-03 12:14:28'),
(52, 29, 3, 19, 8, NULL, '2026-08-19 17:23:16'),
(53, 30, 2, 19, 0, NULL, '2026-08-11 07:28:15'),
(54, 30, 1, 23, 0, NULL, '2026-08-11 07:28:15'),
(55, 30, 4, 25, 0, NULL, '2026-08-11 07:28:15'),
(56, 30, 3, 14, 0, NULL, '2026-08-11 07:28:15'),
(57, 31, 3, 24, 0, NULL, '2026-09-10 23:56:29'),
(58, 31, 2, 5, 0, NULL, '2026-09-10 23:56:29'),
(59, 31, 1, 19, 0, NULL, '2026-09-10 23:56:29'),
(60, 32, 4, 18, 2, NULL, '2026-09-15 22:08:05'),
(61, 32, 1, 16, 12, NULL, '2026-09-15 22:08:05'),
(62, 32, 2, 16, 7, NULL, '2026-09-15 22:08:05'),
(63, 33, 4, 11, 2, NULL, '2026-08-14 06:58:06'),
(64, 33, 1, 23, 11, NULL, '2026-08-14 06:58:06'),
(65, 34, 3, 25, 1, NULL, '2026-08-15 01:19:30'),
(66, 35, 3, 8, 7, NULL, '2026-07-11 19:34:27'),
(67, 35, 1, 29, 24, NULL, '2026-07-11 19:34:27'),
(68, 35, 2, 23, 15, NULL, '2026-07-11 19:34:27'),
(69, 36, 4, 8, 6, NULL, '2026-09-01 06:47:14'),
(70, 36, 1, 18, 11, NULL, '2026-09-01 06:47:14'),
(71, 37, 1, 21, 0, NULL, '2026-08-08 07:01:55'),
(72, 37, 4, 29, 0, NULL, '2026-08-08 07:01:55'),
(73, 38, 3, 5, 5, NULL, '2026-08-27 00:59:21'),
(74, 38, 4, 28, 12, NULL, '2026-08-27 00:59:21'),
(75, 39, 4, 21, 9, NULL, '2026-08-06 12:40:03'),
(76, 39, 3, 8, 2, NULL, '2026-08-06 12:40:03'),
(77, 40, 3, 23, 4, NULL, '2026-08-27 14:16:02'),
(78, 40, 2, 18, 2, NULL, '2026-08-27 14:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` int UNSIGNED NOT NULL,
  `item_id` int UNSIGNED NOT NULL,
  `type` enum('in','out','adjustment') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `reference_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'PO, SR, adjustment, dll',
  `reference_id` int UNSIGNED DEFAULT NULL,
  `notes` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `item_id`, `type`, `quantity`, `reference_type`, `reference_id`, `notes`, `created_by`, `created_at`) VALUES
(1, 1, 'out', 10, 'SR', 2, 'Delivered to Housekeeping', 2, '2026-09-21 13:50:28'),
(2, 2, 'out', 10, 'SR', 2, 'Delivered to Housekeeping', 2, '2026-09-21 13:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `store_requisitions`
--

CREATE TABLE `store_requisitions` (
  `id` int UNSIGNED NOT NULL,
  `sr_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` enum('housekeeping','kitchen','fb','engineering','front_office') COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_by` int UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','delivered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `requested_date` date NOT NULL,
  `approved_by` int UNSIGNED DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_requisitions`
--

INSERT INTO `store_requisitions` (`id`, `sr_number`, `department`, `requested_by`, `status`, `requested_date`, `approved_by`, `approved_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'SR-20260902-0001', 'engineering', 2, 'delivered', '2026-09-02', 2, '2026-09-02', 'Id possimus maxime at molestiae pariatur.', '2026-09-02 22:59:12', '2026-09-02 22:59:12'),
(2, 'SR-20260827-0002', 'housekeeping', 2, 'delivered', '2026-08-27', 2, '2026-08-27', 'Quos aliquid ducimus voluptatem aut quos facere.', '2026-08-27 22:23:00', '2026-08-27 22:23:00'),
(3, 'SR-20260803-0003', 'front_office', 2, 'delivered', '2026-08-03', 2, '2026-08-03', NULL, '2026-08-03 07:44:22', '2026-08-03 07:44:22'),
(4, 'SR-20260922-0004', 'fb', 2, 'delivered', '2026-09-22', 2, '2026-09-22', NULL, '2026-09-22 03:20:30', '2026-09-22 03:20:30'),
(5, 'SR-20260626-0005', 'front_office', 2, 'delivered', '2026-06-26', 2, '2026-06-26', NULL, '2026-06-26 22:34:48', '2026-06-26 22:34:48'),
(6, 'SR-20260722-0006', 'kitchen', 2, 'delivered', '2026-07-22', 2, '2026-07-22', NULL, '2026-07-22 22:22:16', '2026-07-22 22:22:16'),
(7, 'SR-20260916-0007', 'kitchen', 2, 'delivered', '2026-09-16', 2, '2026-09-16', 'Est eaque minus beatae.', '2026-09-16 05:11:00', '2026-09-16 05:11:00'),
(8, 'SR-20260911-0008', 'fb', 2, 'approved', '2026-09-11', 2, '2026-09-11', 'Et ut minus eveniet cum eligendi est.', '2026-09-11 19:40:30', '2026-09-11 19:40:30'),
(9, 'SR-20260702-0009', 'housekeeping', 2, 'rejected', '2026-07-02', 2, '2026-07-02', 'Perspiciatis impedit voluptate totam ut.', '2026-07-02 12:45:17', '2026-07-02 12:45:17'),
(10, 'SR-20260814-0010', 'fb', 2, 'delivered', '2026-08-14', 2, '2026-08-14', NULL, '2026-08-14 11:15:25', '2026-08-14 11:15:25'),
(11, 'SR-20260711-0011', 'engineering', 2, 'delivered', '2026-07-11', 2, '2026-07-11', NULL, '2026-07-11 17:17:00', '2026-07-11 17:17:00'),
(12, 'SR-20260811-0012', 'kitchen', 2, 'delivered', '2026-08-11', 2, '2026-08-11', NULL, '2026-08-11 05:33:33', '2026-08-11 05:33:33'),
(13, 'SR-20260711-0013', 'front_office', 2, 'delivered', '2026-07-11', 2, '2026-07-11', NULL, '2026-07-11 23:28:40', '2026-07-11 23:28:40'),
(14, 'SR-20260902-0014', 'housekeeping', 2, 'delivered', '2026-09-02', 2, '2026-09-02', NULL, '2026-09-02 02:51:07', '2026-09-02 02:51:07'),
(15, 'SR-20260627-0015', 'kitchen', 2, 'pending', '2026-06-27', NULL, NULL, 'Aut sapiente tempora autem rerum.', '2026-06-27 16:07:42', '2026-06-27 16:07:42'),
(16, 'SR-20260805-0016', 'front_office', 2, 'delivered', '2026-08-05', 2, '2026-08-05', NULL, '2026-08-05 03:04:06', '2026-08-05 03:04:06'),
(17, 'SR-20260815-0017', 'housekeeping', 2, 'delivered', '2026-08-15', 2, '2026-08-15', NULL, '2026-08-15 10:16:28', '2026-08-15 10:16:28'),
(18, 'SR-20260628-0018', 'housekeeping', 2, 'delivered', '2026-06-28', 2, '2026-06-28', 'Nesciunt quia et nesciunt sint similique animi.', '2026-06-28 15:58:34', '2026-06-28 15:58:34'),
(19, 'SR-20260802-0019', 'engineering', 2, 'pending', '2026-08-02', NULL, NULL, 'Perferendis aut molestias nihil at eum ipsum quis perspiciatis.', '2026-08-02 13:42:38', '2026-08-02 13:42:38'),
(20, 'SR-20260707-0020', 'engineering', 2, 'delivered', '2026-07-07', 2, '2026-07-07', 'Voluptatum est voluptates magni accusamus laudantium quos.', '2026-07-07 15:09:16', '2026-07-07 15:09:16'),
(21, 'SR-20260719-0021', 'fb', 2, 'pending', '2026-07-19', NULL, NULL, NULL, '2026-07-19 06:08:38', '2026-07-19 06:08:38'),
(22, 'SR-20260907-0022', 'fb', 2, 'rejected', '2026-09-07', 2, '2026-09-07', NULL, '2026-09-07 02:21:10', '2026-09-07 02:21:10'),
(23, 'SR-20260628-0023', 'fb', 2, 'delivered', '2026-06-28', 2, '2026-06-28', NULL, '2026-06-28 18:21:21', '2026-06-28 18:21:21'),
(24, 'SR-20260910-0024', 'housekeeping', 2, 'rejected', '2026-09-10', 2, '2026-09-10', NULL, '2026-09-10 02:33:10', '2026-09-10 02:33:10'),
(25, 'SR-20260827-0025', 'fb', 2, 'delivered', '2026-08-27', 2, '2026-08-27', NULL, '2026-08-27 13:28:14', '2026-08-27 13:28:14'),
(26, 'SR-20260821-0026', 'kitchen', 2, 'approved', '2026-08-21', 2, '2026-08-21', 'Ut quibusdam aperiam placeat doloremque et ea voluptate maxime.', '2026-08-21 18:34:12', '2026-08-21 18:34:12'),
(27, 'SR-20260826-0027', 'engineering', 2, 'pending', '2026-08-26', NULL, NULL, 'Minima unde et molestias nihil tempora voluptatem.', '2026-08-26 14:07:45', '2026-08-26 14:07:45'),
(28, 'SR-20260803-0028', 'engineering', 2, 'approved', '2026-08-03', 2, '2026-08-03', 'Odit ex autem enim omnis vitae.', '2026-08-03 12:14:28', '2026-08-03 12:14:28'),
(29, 'SR-20260819-0029', 'housekeeping', 2, 'approved', '2026-08-19', 2, '2026-08-19', NULL, '2026-08-19 17:23:16', '2026-08-19 17:23:16'),
(30, 'SR-20260811-0030', 'kitchen', 2, 'rejected', '2026-08-11', 2, '2026-08-11', NULL, '2026-08-11 07:28:15', '2026-08-11 07:28:15'),
(31, 'SR-20260910-0031', 'housekeeping', 2, 'rejected', '2026-09-10', 2, '2026-09-10', NULL, '2026-09-10 23:56:29', '2026-09-10 23:56:29'),
(32, 'SR-20260915-0032', 'fb', 2, 'approved', '2026-09-15', 2, '2026-09-15', 'Eveniet tenetur inventore odio non explicabo quisquam.', '2026-09-15 22:08:05', '2026-09-15 22:08:05'),
(33, 'SR-20260814-0033', 'housekeeping', 2, 'pending', '2026-08-14', NULL, NULL, 'Quasi blanditiis est ex.', '2026-08-14 06:58:06', '2026-08-14 06:58:06'),
(34, 'SR-20260815-0034', 'front_office', 2, 'approved', '2026-08-15', 2, '2026-08-15', 'Optio in assumenda tenetur sunt.', '2026-08-15 01:19:30', '2026-08-15 01:19:30'),
(35, 'SR-20260711-0035', 'fb', 2, 'delivered', '2026-07-11', 2, '2026-07-11', NULL, '2026-07-11 19:34:27', '2026-07-11 19:34:27'),
(36, 'SR-20260901-0036', 'front_office', 2, 'approved', '2026-09-01', 2, '2026-09-01', 'Consectetur est sed enim delectus in ea.', '2026-09-01 06:47:14', '2026-09-01 06:47:14'),
(37, 'SR-20260808-0037', 'front_office', 2, 'rejected', '2026-08-08', 2, '2026-08-08', NULL, '2026-08-08 07:01:55', '2026-08-08 07:01:55'),
(38, 'SR-20260827-0038', 'housekeeping', 2, 'delivered', '2026-08-27', 2, '2026-08-27', 'Minima ut quia a voluptas vero officia sed.', '2026-08-27 00:59:21', '2026-08-27 00:59:21'),
(39, 'SR-20260806-0039', 'kitchen', 2, 'approved', '2026-08-06', 2, '2026-08-06', NULL, '2026-08-06 12:40:03', '2026-08-06 12:40:03'),
(40, 'SR-20260827-0040', 'fb', 2, 'delivered', '2026-08-27', 2, '2026-08-27', NULL, '2026-08-27 14:16:02', '2026-08-27 14:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'PT CV Permata Puspita Tbk Makmur', 'Daliono Dabukke', '0621 9722 774', 'nrajata@nurdiyanti.go.id', 'Gg. Rumah Sakit No. 401, Sukabumi 32452, Jateng', '2026-07-14 14:48:58', '2026-09-22 09:20:58'),
(2, 'PT Yayasan Pratiwi Utama', 'Azalea Nasyiah', '0438 2926 5481', 'tantri.yulianti@farida.org', 'Jr. Bass No. 481, Palangka Raya 24639, Sulut', '2026-06-27 22:15:07', '2026-09-22 09:20:58'),
(3, 'PT CV Laksmiwati Oktaviani Utama', 'Karimah Cinta Oktaviani', '0634 8280 1420', 'adhiarja.suartini@prabowo.sch.id', 'Ki. Ahmad Dahlan No. 478, Sukabumi 21171, Riau', '2025-10-21 02:26:05', '2026-09-22 09:20:58'),
(4, 'PT PD Waluyo (Persero) Tbk Utama', 'Luluh Dongoran', '0604 2344 4976', 'prastuti.hesti@mangunsong.in', 'Gg. Dipenogoro No. 984, Cirebon 18995, Jateng', '2026-02-26 16:04:49', '2026-09-22 09:20:58'),
(5, 'PT Fa Maheswara Irawan (Persero) Tbk Jaya', 'Cengkal Prabowo', '(+62) 847 1088 0402', 'triyanti@saputra.name', 'Ds. Haji No. 475, Palangka Raya 87196, Malut', '2026-05-04 15:00:33', '2026-09-22 09:20:58'),
(6, 'PT Yayasan Hutagalung (Persero) Tbk Jaya', 'Ana Padmasari', '0642 3142 878', 'rbudiman@mandasari.tv', 'Dk. Baya Kali Bungur No. 544, Bandung 54533, Sumsel', '2026-04-20 05:35:08', '2026-09-22 09:20:58'),
(7, 'PT CV Purnawati Tbk Sentosa', 'Elon Marpaung S.Ked', '(+62) 501 8860 874', 'tamba.wardi@mardhiyah.go.id', 'Jr. Cikutra Timur No. 323, Bandar Lampung 83981, Jateng', '2025-12-01 04:07:33', '2026-09-22 09:20:58'),
(8, 'PT PT Permata Gunarto (Persero) Tbk Sentosa', 'Cecep Kusumo M.Ak', '0256 9431 9822', 'artawan.wibisono@prastuti.or.id', 'Jln. Urip Sumoharjo No. 626, Semarang 28666, DKI', '2026-01-28 14:16:04', '2026-09-22 09:20:58'),
(9, 'PT PT Safitri Astuti Abadi', 'Nilam Pratiwi S.Farm', '023 1901 712', 'nsuryatmi@nababan.go.id', 'Gg. Gajah No. 794, Administrasi Jakarta Selatan 90964, Pabar', '2026-02-24 21:26:19', '2026-09-22 09:20:58'),
(10, 'PT PD Mandala Andriani Jaya', 'Elma Uchita Yolanda M.M.', '0332 9634 380', 'dabukke.bahuraksa@uyainah.info', 'Dk. Sutoyo No. 116, Sukabumi 24149, NTB', '2026-09-18 20:54:11', '2026-09-22 09:20:58'),
(11, 'PT CV Widiastuti Jaya', 'Rangga Wibisono', '0223 3117 748', 'msitompul@melani.co.id', 'Ds. Gotong Royong No. 795, Pariaman 90261, Sultra', '2026-07-07 00:56:07', '2026-09-22 09:20:58'),
(12, 'PT PT Damanik Tbk Bersama', 'Caraka Napitupulu', '(+62) 703 6367 4575', 'humaira.hassanah@wahyudin.biz', 'Ds. Nakula No. 380, Payakumbuh 16929, Sultra', '2026-05-26 21:53:08', '2026-09-22 09:20:58'),
(13, 'PT CV Pangestu Jaya', 'Waluyo Siregar', '023 0893 6541', 'tgunarto@permadi.in', 'Jr. Surapati No. 226, Lubuklinggau 57365, Gorontalo', '2026-01-20 23:51:00', '2026-09-22 09:20:58'),
(14, 'PT Fa Putra Sihombing (Persero) Tbk Prima', 'Salsabila Uyainah', '(+62) 736 2683 3989', 'prastuti.kuncara@kuswoyo.info', 'Kpg. Sutan Syahrir No. 822, Palopo 31300, Kaltim', '2025-11-01 04:48:06', '2026-09-22 09:20:58'),
(15, 'PT Fa Saputra Namaga Sentosa', 'Paris Riyanti', '021 8237 3778', 'marbun.gaduh@rahayu.info', 'Dk. Setiabudhi No. 578, Palembang 17563, Kaltara', '2026-01-20 12:52:03', '2026-09-22 09:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'admin', NULL, NULL, 1, '2026-09-23 06:26:48', '2026-09-21 05:25:30', '2026-09-21 05:26:09', NULL),
(10, 'manager1', NULL, NULL, 1, '2026-09-22 10:06:08', '2026-09-22 16:46:58', '2026-09-22 16:46:58', NULL),
(11, 'fo1', NULL, NULL, 1, '2026-09-22 10:07:16', '2026-09-22 16:46:58', '2026-09-22 16:46:58', NULL),
(12, 'hk1', NULL, NULL, 1, '2026-09-22 10:17:09', '2026-09-22 16:46:58', '2026-09-22 16:46:58', NULL),
(13, 'purchasing1', NULL, NULL, 1, '2026-09-22 10:07:53', '2026-09-22 16:46:58', '2026-09-22 16:46:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_setting_key` (`key`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_folio_number` (`folio_number`),
  ADD KEY `idx_folio_res` (`reservation_id`),
  ADD KEY `idx_folio_guest` (`guest_id`);

--
-- Indexes for table `folio_items`
--
ALTER TABLE `folio_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fi_folio` (`folio_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_guest_name` (`full_name`),
  ADD KEY `idx_guest_phone` (`phone`);

--
-- Indexes for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_hk_room` (`room_id`),
  ADD KEY `idx_hk_status` (`status`),
  ADD KEY `idx_hk_assigned` (`assigned_to`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_item_code` (`code`),
  ADD KEY `idx_item_category` (`category_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mr_room` (`room_id`),
  ADD KEY `idx_mr_status` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pay_folio` (`folio_id`);

--
-- Indexes for table `po_details`
--
ALTER TABLE `po_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pod_po` (`po_id`),
  ADD KEY `idx_pod_item` (`item_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_po_number` (`po_number`),
  ADD KEY `idx_po_supplier` (`supplier_id`),
  ADD KEY `idx_po_status` (`status`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_reservation_code` (`reservation_code`),
  ADD KEY `idx_res_guest` (`guest_id`),
  ADD KEY `idx_res_status` (`status`),
  ADD KEY `idx_res_dates` (`check_in_date`,`check_out_date`);

--
-- Indexes for table `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rr_res` (`reservation_id`),
  ADD KEY `idx_rr_room` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_room_number` (`room_number`),
  ADD KEY `idx_room_status` (`status`),
  ADD KEY `idx_room_floor` (`floor`),
  ADD KEY `fk_rooms_type` (`room_type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sr_details`
--
ALTER TABLE `sr_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_srd_sr` (`sr_id`),
  ADD KEY `idx_srd_item` (`item_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sm_item` (`item_id`),
  ADD KEY `idx_sm_type` (`type`),
  ADD KEY `idx_sm_ref` (`reference_type`,`reference_id`);

--
-- Indexes for table `store_requisitions`
--
ALTER TABLE `store_requisitions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_sr_number` (`sr_number`),
  ADD KEY `idx_sr_status` (`status`),
  ADD KEY `idx_sr_dept` (`department`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auth_identities`
--
ALTER TABLE `auth_identities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_token_logins`
--
ALTER TABLE `auth_token_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folios`
--
ALTER TABLE `folios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folio_items`
--
ALTER TABLE `folio_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `po_details`
--
ALTER TABLE `po_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=806;

--
-- AUTO_INCREMENT for table `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=806;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sr_details`
--
ALTER TABLE `sr_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_requisitions`
--
ALTER TABLE `store_requisitions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_identities`
--
ALTER TABLE `auth_identities`
  ADD CONSTRAINT `auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_permissions_users`
--
ALTER TABLE `auth_permissions_users`
  ADD CONSTRAINT `auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_remember_tokens`
--
ALTER TABLE `auth_remember_tokens`
  ADD CONSTRAINT `auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `folios`
--
ALTER TABLE `folios`
  ADD CONSTRAINT `fk_folio_guest` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_folio_res` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `folio_items`
--
ALTER TABLE `folio_items`
  ADD CONSTRAINT `fk_fi_folio` FOREIGN KEY (`folio_id`) REFERENCES `folios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  ADD CONSTRAINT `fk_hk_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_item_category` FOREIGN KEY (`category_id`) REFERENCES `item_categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `fk_mr_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pay_folio` FOREIGN KEY (`folio_id`) REFERENCES `folios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `po_details`
--
ALTER TABLE `po_details`
  ADD CONSTRAINT `fk_pod_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pod_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `fk_po_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_res_guest` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `reservation_rooms`
--
ALTER TABLE `reservation_rooms`
  ADD CONSTRAINT `fk_rr_res` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rr_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_rooms_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `sr_details`
--
ALTER TABLE `sr_details`
  ADD CONSTRAINT `fk_srd_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_srd_sr` FOREIGN KEY (`sr_id`) REFERENCES `store_requisitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_sm_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
