-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2026 at 04:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neeliamendissaloon`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cash_given` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `invoice_id`, `service_name`, `price`, `created_at`, `updated_at`) VALUES
(6, 9, 'Mullet', 1200.00, '2025-09-04 00:41:58', '2025-09-04 00:41:58'),
(7, 10, 'Mullet', 1200.00, '2025-09-04 00:42:29', '2025-09-04 00:42:29'),
(8, 10, 'Pompadour', 12000.00, '2025-09-04 00:42:29', '2025-09-04 00:42:29'),
(9, 11, 'Layered Cut', 2000.00, '2025-09-04 03:43:49', '2025-09-04 03:43:49'),
(10, 12, 'Basic Haircut', 1500.00, '2025-09-04 04:37:43', '2025-09-04 04:37:43'),
(11, 13, 'Mullet', 1200.00, '2025-09-12 05:41:50', '2025-09-12 05:41:50'),
(12, 14, 'Beard Trim & Shave', 1500.00, '2025-11-04 07:39:26', '2025-11-04 07:39:26'),
(13, 15, 'Haircuts (Ladies & Gents)', 2500.00, '2025-11-04 07:40:35', '2025-11-04 07:40:35'),
(14, 15, 'Hair Styling & Special Setting', 3500.00, '2025-11-04 07:40:35', '2025-11-04 07:40:35'),
(15, 16, 'Beard Trim & Shave', 1500.00, '2025-11-04 08:34:44', '2025-11-04 08:34:44'),
(16, 16, 'Hydrating & Rejuvenating Care', 4000.00, '2025-11-04 08:34:44', '2025-11-04 08:34:44'),
(17, 16, 'Anti-Aging Treatments', 6000.00, '2025-11-04 08:34:44', '2025-11-04 08:34:44'),
(18, 17, 'Hair Straightening / Perming', 9000.00, '2025-11-04 08:45:42', '2025-11-04 08:45:42'),
(19, 18, 'Beard Trim & Shave', 1500.00, '2025-11-04 08:57:17', '2025-11-04 08:57:17'),
(20, 18, 'Hair Straightening / Perming', 9000.00, '2025-11-04 08:57:17', '2025-11-04 08:57:17'),
(21, 18, 'Waxing (Full Body / Specific Areas)', 10000.00, '2025-11-04 08:57:17', '2025-11-04 08:57:17'),
(22, 19, 'Beard Trim & Shave', 1500.00, '2025-11-04 09:12:05', '2025-11-04 09:12:05'),
(23, 19, 'Keratin & Smoothing Treatments', 20000.00, '2025-11-04 09:12:05', '2025-11-04 09:12:05'),
(24, 19, 'Anti-Aging Treatments', 6000.00, '2025-11-04 09:12:05', '2025-11-04 09:12:05'),
(25, 20, 'Haircuts (Ladies & Gents)', 2500.00, '2025-11-04 09:45:43', '2025-11-04 09:45:43'),
(26, 20, 'Beard Trim & Shave', 1500.00, '2025-11-04 09:45:43', '2025-11-04 09:45:43'),
(27, 20, 'Keratin & Smoothing Treatments', 20000.00, '2025-11-04 09:45:43', '2025-11-04 09:45:43'),
(28, 20, 'Anti-Aging Treatments', 6000.00, '2025-11-04 09:45:43', '2025-11-04 09:45:43'),
(29, 21, 'Hair Styling & Special Setting', 3500.00, '2025-11-04 09:56:48', '2025-11-04 09:56:48'),
(30, 21, 'Acne & Skin Repair Treatments', 4500.00, '2025-11-04 09:56:48', '2025-11-04 09:56:48'),
(31, 21, 'Waxing (Full Body / Specific Areas)', 10000.00, '2025-11-04 09:56:48', '2025-11-04 09:56:48'),
(32, 21, 'Manicure & Pedicure', 3500.00, '2025-11-04 09:56:48', '2025-11-04 09:56:48'),
(33, 22, 'Hair Styling & Special Setting', 3500.00, '2025-11-04 10:03:09', '2025-11-04 10:03:09'),
(34, 22, 'Threading (Eyebrows, Face)', 2000.00, '2025-11-04 10:03:09', '2025-11-04 10:03:09'),
(35, 22, 'Saree Draping & Full Dressing', 5000.00, '2025-11-04 10:03:09', '2025-11-04 10:03:09'),
(36, 23, 'Hair Styling & Special Setting', 3500.00, '2025-11-04 10:14:21', '2025-11-04 10:14:21'),
(37, 24, 'Beard Trim & Shave', 1500.00, '2025-11-07 03:08:13', '2025-11-07 03:08:13'),
(38, 25, 'Hair Styling & Special Setting', 3500.00, '2025-12-09 04:00:58', '2025-12-09 04:00:58'),
(39, 26, 'Beard Trim & Shave', 1500.00, '2025-12-29 05:04:44', '2025-12-29 05:04:44'),
(40, 27, 'Beard Trim & Shave', 1500.00, '2025-12-29 07:01:13', '2025-12-29 07:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','rejected','approved','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `client_id`, `date`, `total_price`, `start_time`, `end_time`, `staff_id`, `status`, `created_at`, `updated_at`) VALUES
(51, 14, NULL, '2025-10-22', 10000.00, '15:00:00', '15:00:00', NULL, 'rejected', '2025-10-22 09:01:50', '2025-10-22 09:14:14'),
(52, 14, NULL, '2025-10-25', 11500.00, '14:00:00', '14:00:00', NULL, 'approved', '2025-10-24 03:49:30', '2025-10-24 03:50:16'),
(53, 10, NULL, '2025-10-24', 5000.00, '15:00:00', '15:00:00', NULL, 'pending', '2025-10-24 04:43:35', '2025-10-24 04:43:35'),
(54, 10, NULL, '2025-10-24', 45000.00, '16:00:00', '16:00:00', NULL, 'approved', '2025-10-24 04:47:57', '2025-10-24 04:49:25'),
(55, 4, NULL, '2025-11-22', 6000.00, '12:00:00', '12:00:00', NULL, 'approved', '2025-11-21 07:37:45', '2025-11-21 07:38:37'),
(56, 10, NULL, '2025-12-29', 4000.00, '09:00:00', '09:00:00', NULL, 'approved', '2025-12-29 03:56:07', '2025-12-29 04:50:52'),
(57, 10, NULL, '2025-12-29', 4000.00, '15:00:00', '15:00:00', NULL, 'completed', '2025-12-29 04:00:11', '2025-12-29 06:10:52'),
(58, 10, NULL, '2025-12-29', 2500.00, '12:00:00', '12:00:00', NULL, 'approved', '2025-12-29 04:04:38', '2025-12-29 04:51:00'),
(59, 2, 3, '2025-12-29', 5000.00, '14:22:00', '14:22:00', NULL, 'approved', '2025-12-29 04:55:50', '2025-12-29 04:55:50'),
(60, 10, NULL, '2025-12-29', 4000.00, '13:00:00', '13:00:00', NULL, 'rejected', '2025-12-29 05:17:13', '2025-12-29 05:17:38'),
(61, 10, NULL, '2025-12-29', 4000.00, '14:00:00', '14:00:00', NULL, 'approved', '2025-12-29 05:18:05', '2025-12-29 05:18:17'),
(62, 3, NULL, '2025-12-30', 2500.00, '12:00:00', '12:00:00', NULL, 'approved', '2025-12-29 05:21:27', '2025-12-30 08:02:12'),
(63, 3, NULL, '2025-12-31', 15000.00, '15:00:00', '15:00:00', NULL, 'pending', '2025-12-29 05:26:00', '2025-12-29 05:26:00'),
(64, 3, NULL, '2025-12-29', 20000.00, '15:00:00', '15:00:00', NULL, 'approved', '2025-12-29 05:29:07', '2025-12-29 05:29:47'),
(65, 10, NULL, '2025-12-29', 24000.00, '15:00:00', '15:00:00', NULL, 'approved', '2025-12-29 07:31:21', '2025-12-29 07:31:57'),
(66, 10, NULL, '2025-12-29', 49000.00, '16:00:00', '16:00:00', NULL, 'rejected', '2025-12-29 07:31:33', '2025-12-29 07:32:05'),
(67, 10, NULL, '2025-12-29', 7500.00, '11:00:00', '11:00:00', NULL, 'pending', '2025-12-29 10:36:43', '2025-12-29 10:36:43'),
(68, 23, NULL, '2025-12-30', 4000.00, '13:00:00', '13:00:00', NULL, 'pending', '2025-12-30 08:06:10', '2025-12-30 08:06:10'),
(69, 2, 5, '2025-12-30', 4000.00, '16:00:00', '16:00:00', NULL, 'approved', '2025-12-30 08:23:39', '2025-12-30 08:23:39'),
(70, 10, NULL, '2025-12-31', 4000.00, '13:00:00', '13:00:00', NULL, 'pending', '2025-12-31 03:01:47', '2025-12-31 03:01:47'),
(71, 10, NULL, '2026-01-01', 3500.00, '13:00:00', '13:00:00', NULL, 'pending', '2025-12-31 03:02:10', '2025-12-31 03:02:10'),
(72, 23, NULL, '2025-12-31', 12500.00, '13:00:00', '13:00:00', NULL, 'pending', '2025-12-31 03:04:30', '2025-12-31 03:04:30'),
(73, 10, NULL, '2026-01-02', 4000.00, '11:00:00', '11:00:00', NULL, 'pending', '2026-01-02 02:32:51', '2026-01-02 02:32:51'),
(74, 10, NULL, '2026-01-02', 10000.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-02 02:33:24', '2026-01-02 02:33:24'),
(75, 10, NULL, '2026-01-03', 10000.00, '12:00:00', '12:00:00', NULL, 'pending', '2026-01-02 02:34:23', '2026-01-02 02:34:23'),
(76, 10, NULL, '2026-01-02', 30000.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-02 02:35:07', '2026-01-02 02:35:07'),
(77, 24, NULL, '2026-01-02', 4000.00, '11:00:00', '11:00:00', NULL, 'pending', '2026-01-02 03:13:28', '2026-01-02 03:13:28'),
(78, 24, NULL, '2026-01-02', 14500.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-02 03:13:42', '2026-01-02 03:13:42'),
(79, 24, NULL, '2026-01-03', 30000.00, '09:00:00', '09:00:00', NULL, 'pending', '2026-01-02 03:13:56', '2026-01-02 03:13:56'),
(80, 24, NULL, '2026-01-02', 5000.00, '14:00:00', '14:00:00', NULL, 'pending', '2026-01-02 06:51:45', '2026-01-02 06:51:45'),
(81, 24, NULL, '2026-01-02', 8500.00, '15:00:00', '15:00:00', NULL, 'pending', '2026-01-02 06:52:16', '2026-01-02 06:52:16'),
(82, 24, NULL, '2026-01-04', 10000.00, '09:00:00', '09:00:00', NULL, 'pending', '2026-01-02 06:52:57', '2026-01-02 06:52:57'),
(83, 3, NULL, '2026-01-02', 3500.00, '10:00:00', '10:00:00', NULL, 'pending', '2026-01-02 06:53:00', '2026-01-02 06:53:00'),
(84, 3, NULL, '2026-01-02', 9000.00, '09:00:00', '09:00:00', NULL, 'pending', '2026-01-02 07:48:38', '2026-01-02 07:48:38'),
(85, 3, NULL, '2026-01-02', 5000.00, '12:00:00', '12:00:00', NULL, 'pending', '2026-01-02 09:39:26', '2026-01-02 09:39:26'),
(86, 2, 4, '2026-01-07', 5000.00, '14:16:00', '14:16:00', NULL, 'approved', '2026-01-06 04:46:30', '2026-01-06 04:46:30'),
(87, 2, 6, '2026-01-06', 5000.00, '13:17:00', '13:17:00', NULL, 'approved', '2026-01-06 04:47:13', '2026-01-06 04:47:13'),
(88, 2, 4, '2026-01-06', 4000.00, '14:17:00', '14:17:00', NULL, 'approved', '2026-01-06 04:47:53', '2026-01-06 04:47:53'),
(89, 2, 4, '2026-01-06', 15000.00, '13:18:00', '13:18:00', NULL, 'approved', '2026-01-06 04:48:42', '2026-01-06 04:48:42'),
(90, 2, 6, '2026-01-06', 3500.00, '15:18:00', '15:18:00', NULL, 'approved', '2026-01-06 04:49:04', '2026-01-06 04:49:04'),
(91, 25, NULL, '2026-01-06', 2000.00, '14:00:00', '14:00:00', NULL, 'pending', '2026-01-06 10:30:20', '2026-01-06 10:30:20'),
(92, 10, NULL, '2026-01-07', 30000.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(93, 3, NULL, '2026-01-08', 25000.00, '12:00:00', '12:00:00', NULL, 'pending', '2026-01-08 02:44:27', '2026-01-08 02:44:27'),
(94, 3, NULL, '2026-01-08', 9000.00, '16:00:00', '16:00:00', NULL, 'pending', '2026-01-08 02:44:38', '2026-01-08 02:44:38'),
(95, 3, NULL, '2026-01-08', 4500.00, '15:00:00', '15:00:00', NULL, 'pending', '2026-01-08 02:44:58', '2026-01-08 02:44:58'),
(96, 3, NULL, '2026-01-08', 5000.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-08 02:45:51', '2026-01-08 02:45:51'),
(97, 3, NULL, '2026-01-08', 5000.00, '12:00:00', '12:00:00', NULL, 'pending', '2026-01-08 02:46:11', '2026-01-08 02:46:11'),
(98, 3, NULL, '2026-01-08', 33500.00, '14:00:00', '14:00:00', NULL, 'pending', '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(99, 3, NULL, '2026-01-08', 6000.00, '14:00:00', '14:00:00', NULL, 'pending', '2026-01-08 04:57:10', '2026-01-08 04:57:10'),
(100, 3, NULL, '2026-01-08', 68000.00, '10:00:00', '10:00:00', NULL, 'pending', '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(101, 3, NULL, '2026-01-08', 79000.00, '09:00:00', '09:00:00', NULL, 'pending', '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(102, 3, NULL, '2026-01-13', 6000.00, '10:00:00', '10:00:00', NULL, 'pending', '2026-01-13 01:57:46', '2026-01-13 01:57:46'),
(103, 3, NULL, '2026-01-21', 8500.00, '12:00:00', '12:00:00', NULL, 'pending', '2026-01-19 04:55:47', '2026-01-19 04:55:47'),
(104, 10, NULL, '2026-01-19', 7500.00, '11:00:00', '11:00:00', NULL, 'pending', '2026-01-19 05:35:37', '2026-01-19 05:35:37'),
(105, 10, NULL, '2026-01-19', 4000.00, '11:00:00', '11:00:00', NULL, 'pending', '2026-01-19 05:38:36', '2026-01-19 05:38:36'),
(106, 31, NULL, '2026-01-21', 9000.00, '11:00:00', '11:00:00', NULL, 'pending', '2026-01-22 05:27:24', '2026-01-22 05:27:24'),
(107, 31, NULL, '2026-01-21', 33500.00, '13:00:00', '13:00:00', NULL, 'pending', '2026-01-22 05:28:41', '2026-01-22 05:28:41'),
(108, 34, NULL, '2026-01-23', 4500.00, '10:00:00', '10:00:00', NULL, 'pending', '2026-01-23 11:09:28', '2026-01-23 11:09:28'),
(109, 2, 7, '2026-02-18', 3500.00, '13:47:00', '13:47:00', NULL, 'approved', '2026-02-13 00:47:26', '2026-02-13 00:47:26'),
(112, 2, 8, '2026-02-27', 9000.00, '14:51:00', '14:51:00', NULL, 'approved', '2026-02-13 00:48:46', '2026-02-13 00:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `image`) VALUES
(21, 'Hair Styling & Colour', '2025-10-22 08:25:16', '2025-10-22 08:25:16', '/storage/images/categories/uAkCEFNaQRfkeNsM3DWU712XFJMONCNyTtGEY3Is.jpg'),
(22, 'Skin & Facials', '2025-10-22 08:26:48', '2025-10-22 08:26:48', '/storage/images/categories/v7QtqfmRco3R8GQH1r6DpzfUW3wrOop32UlIArPd.jpg'),
(23, 'Nail Care & Spa', '2025-10-22 08:27:11', '2025-10-22 08:27:11', '/storage/images/categories/3RSnkzVAPCiX4TPCsXCKDu9MI1tNdVYx5LpmDgGb.jpg'),
(24, 'Makeup & Bridal', '2025-10-22 08:27:43', '2025-10-22 08:27:43', '/storage/images/categories/CPBXZRWJnupLVDd8YaDQGqLTBeAZwVTMFZ8oq2AG.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category_staff`
--

CREATE TABLE `category_staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_staff`
--

INSERT INTO `category_staff` (`id`, `staff_id`, `category_id`, `created_at`, `updated_at`) VALUES
(6, 1, 24, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `allergies` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `contact`, `address`, `whatsapp`, `allergies`, `created_at`, `updated_at`) VALUES
(1, 'Vishmi Dulanjalee', 'vishmidulanjalee1030@gmail.com', '0777361120', '325/A\r\nBatepola', '0777361123', NULL, '2025-09-03 23:22:21', '2025-12-29 05:05:13'),
(2, 'Vishmi Dulanjale', 'vishmidulanjalee130@gmail.com', '0777361125', '325/A\r\nBatepola', '0777361125', NULL, '2025-09-04 00:32:02', '2025-09-04 00:32:02'),
(3, 'henry', 'henry@gmail.com', '0773602100', NULL, '0773602100', NULL, '2025-12-29 04:55:50', '2025-12-29 04:55:50'),
(4, 'Dhasindu Nethmika', 'dhasindunethmika22@gmail.com', '0773602193', '247/A walpola ragama', '0773602193', NULL, '2025-12-29 05:05:38', '2026-01-06 04:48:42'),
(5, 'Test 12', 'ttt@g.c', '0770231463', NULL, '0770231463', NULL, '2025-12-30 08:23:39', '2025-12-30 08:23:39'),
(6, 'henry peterson', 'Cashier@example.com', '0773602195', NULL, '0773602195', NULL, '2026-01-06 04:47:13', '2026-01-06 04:47:13'),
(7, 'Saman', 'saman@gmail.com', '012365479', NULL, '012365479', NULL, '2026-02-13 00:47:26', '2026-02-13 00:47:26'),
(8, 'Kamal', 'kamal@gmail.com', '0123654458', NULL, '0123654458', NULL, '2026-02-13 00:48:46', '2026-02-13 00:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `date`, `total_price`, `client_id`, `created_at`, `updated_at`) VALUES
(9, '2025-09-04', 1200.00, 2, '2025-09-04 00:41:58', '2025-09-04 00:41:58'),
(10, '2025-09-04', 13200.00, 1, '2025-09-04 00:42:29', '2025-09-04 00:42:29'),
(11, '2025-09-04', 2000.00, 1, '2025-09-04 03:43:49', '2025-09-04 03:43:49'),
(12, '2025-09-04', 1500.00, 1, '2025-09-04 04:37:43', '2025-09-04 04:37:43'),
(13, '2025-09-12', 1200.00, 1, '2025-09-12 05:41:50', '2025-09-12 05:41:50'),
(14, '2025-11-04', 1500.00, 2, '2025-11-04 07:39:26', '2025-11-04 07:39:26'),
(15, '2025-11-04', 6000.00, 1, '2025-11-04 07:40:35', '2025-11-04 07:40:35'),
(16, '2025-11-04', 11500.00, 1, '2025-11-04 08:34:44', '2025-11-04 08:34:44'),
(17, '2025-11-04', 9000.00, 1, '2025-11-04 08:45:42', '2025-11-04 08:45:42'),
(18, '2025-11-04', 20500.00, 2, '2025-11-04 08:57:17', '2025-11-04 08:57:17'),
(19, '2025-11-04', 27500.00, 1, '2025-11-04 09:12:05', '2025-11-04 09:12:05'),
(20, '2025-11-04', 30000.00, 1, '2025-11-04 09:45:43', '2025-11-04 09:45:43'),
(21, '2025-11-04', 21500.00, 1, '2025-11-04 09:56:48', '2025-11-04 09:56:48'),
(22, '2025-11-04', 10500.00, 1, '2025-11-04 10:03:09', '2025-11-04 10:03:09'),
(23, '2025-11-04', 3500.00, 1, '2025-11-04 10:14:21', '2025-11-04 10:14:21'),
(24, '2025-11-07', 1500.00, 1, '2025-11-07 03:08:13', '2025-11-07 03:08:13'),
(25, '2025-12-09', 3500.00, 2, '2025-12-09 04:00:58', '2025-12-09 04:00:58'),
(26, '2025-12-29', 1500.00, 1, '2025-12-29 05:04:44', '2025-12-29 05:04:44'),
(27, '2025-12-29', 1500.00, 3, '2025-12-29 07:01:13', '2025-12-29 07:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `colorCode` varchar(255) DEFAULT NULL,
  `percentage` decimal(8,2) DEFAULT NULL,
  `reminding_date` date DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(16, '2014_10_12_000000_create_users_table', 1),
(17, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(18, '2019_08_19_000000_create_failed_jobs_table', 1),
(19, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(20, '2024_10_08_083737_create_clients_table', 1),
(21, '2024_10_09_035958_create_categories_table', 1),
(23, '2024_10_11_040150_create_invoices_table', 1),
(24, '2024_10_11_040151_create_invoice_details_table', 1),
(25, '2025_09_04_035358_create_bills_table', 1),
(26, '2025_09_04_035359_create_bill_items_table', 1),
(27, '2025_09_04_040824_rename_bill_items_to_invoice_items', 1),
(28, '2024_10_09_101851_create_services_table', 2),
(29, '2025_09_11_042006_create_staff_table', 3),
(30, '2025_09_11_042212_create_category_staff_table', 3),
(31, '2026_02_09_065557_create_sessions_table', 4),
(32, '2025_12_16_060511_fix_client_id_on_bookings', 5),
(33, '2026_02_10_102711_add_columns_to_staff_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `booking_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'You have a booking for Sep 17, 2025', 0, '2025-09-16 07:01:22', '2025-09-16 07:01:22'),
(2, 6, NULL, 'You have a booking for Sep 17, 2025', 0, '2025-09-16 07:09:45', '2025-09-16 07:09:45'),
(3, 6, NULL, 'You have a booking for Sep 17, 2025', 0, '2025-09-16 07:11:56', '2025-09-16 07:11:56'),
(4, 6, NULL, 'You have a booking for Sep 17, 2025', 0, '2025-09-16 07:14:00', '2025-09-16 07:14:00'),
(22, 14, 51, 'You have a booking for Oct 22, 2025 for your service(s) Cleansing & Brightening Facials, Anti-Aging Treatments.', 0, '2025-10-22 09:01:50', '2025-10-22 09:01:50'),
(23, 14, 52, 'You have a booking for Oct 25, 2025 for your service(s) Haircuts (Ladies & Gents), Hair Straightening / Perming.', 0, '2025-10-24 03:49:30', '2025-10-24 03:49:30'),
(24, 10, 53, 'You have a booking for Oct 24, 2025 for your service(s) Hand & Foot Spa.', 0, '2025-10-24 04:43:35', '2025-10-24 04:43:35'),
(25, 10, 54, 'You have a booking for Oct 24, 2025 for your service(s) Bridal Makeup & Dressing, Engagement & Pre-Shoot Looks.', 0, '2025-10-24 04:47:57', '2025-10-24 04:47:57'),
(26, 4, 55, 'You have a booking for Nov 22, 2025 for your service(s) Haircuts (Ladies & Gents), Manicure & Pedicure.', 0, '2025-11-21 07:37:45', '2025-11-21 07:37:45'),
(27, 10, 56, 'You have a booking for Dec 29, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2025-12-29 03:56:07', '2025-12-29 03:56:07'),
(28, 10, 57, 'You have a booking for Dec 29, 2025 for your service(s) Party & Evening Makeup.', 0, '2025-12-29 04:00:11', '2025-12-29 04:00:11'),
(29, 10, 58, 'You have a booking for Dec 29, 2025 for your service(s) Haircuts (Ladies & Gents).', 0, '2025-12-29 04:04:38', '2025-12-29 04:04:38'),
(30, 10, 58, 'Reminder: Appointment for Thaf Naz at 12:00:00-12:00:00 | Services: Haircuts (Ladies & Gents)', 0, '2025-12-29 05:06:05', '2025-12-29 05:06:05'),
(31, 10, 60, 'You have a booking for Dec 29, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2025-12-29 05:17:13', '2025-12-29 05:17:13'),
(32, 10, 61, 'You have a booking for Dec 29, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2025-12-29 05:18:05', '2025-12-29 05:18:05'),
(33, 10, 61, 'Reminder: Appointment for Thaf Naz at 14:00:00-14:00:00 | Services: Haircuts (Ladies & Gents), Beard Trim & Shave', 0, '2025-12-29 05:18:25', '2025-12-29 05:18:25'),
(34, 3, 62, 'You have a booking for Dec 30, 2025 for your service(s) Haircuts (Ladies & Gents).', 0, '2025-12-29 05:21:27', '2025-12-29 05:21:27'),
(35, 10, 58, 'Reminder: Appointment for Thafs Naz at 12:00:00-12:00:00 | Services: Haircuts (Ladies & Gents)', 0, '2025-12-29 05:23:26', '2025-12-29 05:23:26'),
(36, 3, 64, 'You have a booking for Dec 29, 2025 for your service(s) Keratin & Smoothing Treatments.', 0, '2025-12-29 05:29:07', '2025-12-29 05:29:07'),
(37, 10, 65, 'You have a booking for Dec 29, 2025 for your service(s) Party & Evening Makeup, Bridal Makeup & Dressing.', 0, '2025-12-29 07:31:21', '2025-12-29 07:31:21'),
(38, 10, 66, 'You have a booking for Dec 29, 2025 for your service(s) Party & Evening Makeup, Bridal Makeup & Dressing, Engagement & Pre-Shoot Looks.', 0, '2025-12-29 07:31:33', '2025-12-29 07:31:33'),
(39, 10, 65, 'Reminder: Appointment for Thafs Naz at 15:00:00-15:00:00 | Services: Party & Evening Makeup, Bridal Makeup & Dressing', 0, '2025-12-29 07:32:26', '2025-12-29 07:32:26'),
(40, 10, 67, 'You have a booking for Dec 29, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave, Hair Styling & Special Setting.', 0, '2025-12-29 10:36:43', '2025-12-29 10:36:43'),
(41, 23, 68, 'You have a booking for Dec 30, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2025-12-30 08:06:10', '2025-12-30 08:06:10'),
(42, 10, 70, 'You have a booking for Dec 31, 2025 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2025-12-31 03:01:47', '2025-12-31 03:01:47'),
(43, 10, 71, 'You have a booking for Jan 1, 2026 for your service(s) Hair Styling & Special Setting.', 0, '2025-12-31 03:02:10', '2025-12-31 03:02:10'),
(44, 23, 72, 'You have a booking for Dec 31, 2025 for your service(s) Hair Styling & Special Setting, Hair Straightening / Perming.', 0, '2025-12-31 03:04:30', '2025-12-31 03:04:30'),
(45, 10, 73, 'You have a booking for Jan 2, 2026 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2026-01-02 02:32:51', '2026-01-02 02:32:51'),
(46, 10, 74, 'You have a booking for Jan 2, 2026 for your service(s) Cleansing & Brightening Facials, Anti-Aging Treatments.', 0, '2026-01-02 02:33:24', '2026-01-02 02:33:24'),
(47, 10, 75, 'You have a booking for Jan 3, 2026 for your service(s) Nail Extensions & Art, Hand & Foot Spa.', 0, '2026-01-02 02:34:23', '2026-01-02 02:34:23'),
(48, 10, 76, 'You have a booking for Jan 2, 2026 for your service(s) Engagement & Pre-Shoot Looks, Saree Draping & Full Dressing.', 0, '2026-01-02 02:35:07', '2026-01-02 02:35:07'),
(49, 24, 77, 'You have a booking for Jan 2, 2026 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2026-01-02 03:13:28', '2026-01-02 03:13:28'),
(50, 24, 78, 'You have a booking for Jan 2, 2026 for your service(s) Hydrating & Rejuvenating Care, Anti-Aging Treatments, Acne & Skin Repair Treatments.', 0, '2026-01-02 03:13:42', '2026-01-02 03:13:42'),
(51, 24, 79, 'You have a booking for Jan 3, 2026 for your service(s) Engagement & Pre-Shoot Looks, Saree Draping & Full Dressing.', 0, '2026-01-02 03:13:56', '2026-01-02 03:13:56'),
(52, 24, 80, 'You have a booking for Jan 2, 2026 for your service(s) Beard Trim & Shave, Hair Styling & Special Setting.', 0, '2026-01-02 06:51:45', '2026-01-02 06:51:45'),
(53, 24, 81, 'You have a booking for Jan 2, 2026 for your service(s) Cleansing & Brightening Facials, Acne & Skin Repair Treatments.', 0, '2026-01-02 06:52:16', '2026-01-02 06:52:16'),
(54, 3, 83, 'You have a booking for Jan 2, 2026 for your service(s) Manicure & Pedicure.', 0, '2026-01-02 06:53:00', '2026-01-02 06:53:00'),
(55, 3, 84, 'You have a booking for Jan 2, 2026 for your service(s) Hair Straightening / Perming.', 0, '2026-01-02 07:48:38', '2026-01-02 07:48:38'),
(56, 3, 85, 'You have a booking for Jan 2, 2026 for your service(s) Gel & Acrylic Nails.', 0, '2026-01-02 09:39:26', '2026-01-02 09:39:26'),
(57, 25, 91, 'You have a booking for Jan 6, 2026 for your service(s) Threading (Eyebrows, Face).', 0, '2026-01-06 10:30:20', '2026-01-06 10:30:20'),
(58, 10, 92, 'You have a booking for Jan 7, 2026 for your service(s) Nail Extensions & Art, Gel & Acrylic Nails, Hand & Foot Spa, Relaxing Body Massage & Spa Rituals.', 0, '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(59, 3, 93, 'You have a booking for Jan 8, 2026 for your service(s) Engagement & Pre-Shoot Looks.', 0, '2026-01-08 02:44:27', '2026-01-08 02:44:27'),
(60, 3, 94, 'You have a booking for Jan 8, 2026 for your service(s) Hair Straightening / Perming.', 0, '2026-01-08 02:44:38', '2026-01-08 02:44:38'),
(61, 3, 95, 'You have a booking for Jan 8, 2026 for your service(s) Acne & Skin Repair Treatments.', 0, '2026-01-08 02:44:58', '2026-01-08 02:44:58'),
(62, 3, 96, 'You have a booking for Jan 8, 2026 for your service(s) Hand & Foot Spa.', 0, '2026-01-08 02:45:51', '2026-01-08 02:45:51'),
(63, 3, 97, 'You have a booking for Jan 8, 2026 for your service(s) Saree Draping & Full Dressing.', 0, '2026-01-08 02:46:11', '2026-01-08 02:46:11'),
(64, 3, 98, 'You have a booking for Jan 8, 2026 for your service(s) Manicure & Pedicure, Nail Extensions & Art, Gel & Acrylic Nails, Hand & Foot Spa, Relaxing Body Massage & Spa Rituals.', 0, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(65, 3, 99, 'You have a booking for Jan 8, 2026 for your service(s) Anti-Aging Treatments.', 0, '2026-01-08 04:57:10', '2026-01-08 04:57:10'),
(66, 3, 100, 'You have a booking for Jan 8, 2026 for your service(s) Cleansing & Brightening Facials, Hydrating & Rejuvenating Care, Anti-Aging Treatments, Party & Evening Makeup, Bridal Makeup & Dressing, Engagement & Pre-Shoot Looks, Saree Draping & Full Dressing.', 0, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(67, 3, 101, 'You have a booking for Jan 8, 2026 for your service(s) Nail Extensions & Art, Gel & Acrylic Nails, Relaxing Body Massage & Spa Rituals, Party & Evening Makeup, Bridal Makeup & Dressing, Engagement & Pre-Shoot Looks, Saree Draping & Full Dressing.', 0, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(68, 3, 102, 'You have a booking for Jan 13, 2026 for your service(s) Anti-Aging Treatments.', 0, '2026-01-13 01:57:46', '2026-01-13 01:57:46'),
(69, 10, 104, 'You have a booking for Jan 19, 2026 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave, Hair Styling & Special Setting.', 0, '2026-01-19 05:35:37', '2026-01-19 05:35:37'),
(70, 10, 105, 'You have a booking for Jan 19, 2026 for your service(s) Haircuts (Ladies & Gents), Beard Trim & Shave.', 0, '2026-01-19 05:38:36', '2026-01-19 05:38:36'),
(71, 34, 108, 'You have a booking for Jan 23, 2026 for your service(s) Acne & Skin Repair Treatments.', 0, '2026-01-23 11:09:29', '2026-01-23 11:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Expo/54.0.6 CFNetwork/1490.0.4 Darwin/22.6.0', '5d9850d6b369894b29385dca6a6127d8582f88f140c69cce3a5c2d4e058d9d4a', '[\"*\"]', '2026-01-02 10:56:52', NULL, '2026-01-02 10:56:04', '2026-01-02 10:56:52'),
(2, 'App\\Models\\User', 1, 'okhttp/4.12.0', '47a908944dfc3fb6585f12e10507d549c7946ea421ec755010ef1b8509d0d639', '[\"*\"]', '2026-01-07 01:47:01', NULL, '2026-01-02 10:56:42', '2026-01-07 01:47:01'),
(3, 'App\\Models\\User', 1, 'okhttp/4.12.0', 'fb35dcb77bae851df300ef58472a14aaf6732109f6a8e5f5c88884f20e527959', '[\"*\"]', NULL, NULL, '2026-01-06 03:52:45', '2026-01-06 03:52:45'),
(4, 'App\\Models\\User', 1, 'okhttp/4.12.0', 'be487f8a53ab9b54735e67ba26fb444971fa3bd6a4094f4fb8c6e7fe555d66e7', '[\"*\"]', '2026-01-06 08:01:48', NULL, '2026-01-06 03:54:19', '2026-01-06 08:01:48'),
(5, 'App\\Models\\User', 10, 'okhttp/4.12.0', '6d8cfef960a8bfc0898b32d63af1ecead0b3438711711fc9103e8df8000282de', '[\"*\"]', '2026-01-07 02:36:24', NULL, '2026-01-06 08:08:18', '2026-01-07 02:36:24'),
(6, 'App\\Models\\User', 1, 'okhttp/4.12.0', '1819466570c40c6184a7edb779b1d1486ecd2fa133047734096f73d4e9c0a434', '[\"*\"]', '2026-01-06 09:27:04', NULL, '2026-01-06 09:27:01', '2026-01-06 09:27:04'),
(7, 'App\\Models\\User', 25, 'GloryLuxe/10 CFNetwork/3860.300.31 Darwin/25.2.0', 'bf67f2bc8f38980743045c4bad7b1828502857c92a41200abce57ed7ef4025d7', '[\"*\"]', '2026-01-06 10:30:23', NULL, '2026-01-06 10:26:15', '2026-01-06 10:30:23'),
(8, 'App\\Models\\User', 1, 'GloryLuxe/10 CFNetwork/3860.300.31 Darwin/25.2.0', '65238f061ccddd62c9a7660118dd53c707d81c187d13f2e5fa0745de5e0b0c9f', '[\"*\"]', '2026-01-06 10:30:58', NULL, '2026-01-06 10:30:47', '2026-01-06 10:30:58'),
(9, 'App\\Models\\User', 1, 'okhttp/4.12.0', '3c53fd15311daa513d6e46d988754de66ddc0ce68eaa3861af60654b3fcfeefc', '[\"*\"]', '2026-01-08 02:43:46', NULL, '2026-01-07 01:47:31', '2026-01-08 02:43:46'),
(10, 'App\\Models\\User', 10, 'okhttp/4.12.0', 'e77b4a555022951ee1d970a3b6e77faad3df6d3ca0891e888fa0e09b510d4545', '[\"*\"]', '2026-01-07 02:56:24', NULL, '2026-01-07 02:50:28', '2026-01-07 02:56:24'),
(11, 'App\\Models\\User', 1, 'okhttp/4.12.0', '8d5b114cc4526686e914592986de4f18356dc55576bcf38f7964058f8f196f58', '[\"*\"]', '2026-01-07 06:06:27', NULL, '2026-01-07 06:06:24', '2026-01-07 06:06:27'),
(12, 'App\\Models\\User', 2, 'Expo/54.0.6 CFNetwork/1490.0.4 Darwin/22.6.0', 'b7156f1e7b12224ba97ee98de6f69c7900489d54e47aaf4e2624568f2f44e0e7', '[\"*\"]', '2026-01-08 02:46:16', NULL, '2026-01-08 02:43:22', '2026-01-08 02:46:16'),
(15, 'App\\Models\\User', 3, 'Expo/54.0.6 CFNetwork/1490.0.4 Darwin/22.6.0', 'aa500cd45e4d509450ea3b60caeea3f9f3573612098ab35f567f008bc938ca9e', '[\"*\"]', '2026-01-08 04:57:11', NULL, '2026-01-08 04:56:40', '2026-01-08 04:57:11'),
(16, 'App\\Models\\User', 1, 'okhttp/4.12.0', 'd802b5228192124b86f1a8d39c637ee67639a7f0a99e59076dad41e5241cc253', '[\"*\"]', '2026-01-08 05:45:17', NULL, '2026-01-08 05:45:16', '2026-01-08 05:45:17'),
(17, 'App\\Models\\User', 1, 'okhttp/4.12.0', 'cf95c362969500f3d736c0059a4c0ffcb7ce2327268714b5c0fa4f2a1d5e48c2', '[\"*\"]', '2026-01-08 05:47:45', NULL, '2026-01-08 05:45:16', '2026-01-08 05:47:45'),
(18, 'App\\Models\\User', 2, 'okhttp/4.12.0', 'a994366093612a93191f062e0971b4e526b57395f06697f08d103f23213d2a89', '[\"*\"]', '2026-01-19 05:34:38', NULL, '2026-01-08 07:03:10', '2026-01-19 05:34:38'),
(19, 'App\\Models\\User', 3, 'okhttp/4.12.0', 'a2279c13e9148ee0468c3f360b34e18a2a9a01bee3533a43df8e361965a7a369', '[\"*\"]', '2026-01-08 07:59:44', NULL, '2026-01-08 07:07:28', '2026-01-08 07:59:44'),
(20, 'App\\Models\\User', 3, 'GloryLuxe/11 CFNetwork/3826.600.41 Darwin/24.6.0', '9af68739c8f1fc5d9661d0e1238212f60cee47def2519910f9b20da2d523e9b9', '[\"*\"]', '2026-01-08 07:12:31', NULL, '2026-01-08 07:11:11', '2026-01-08 07:12:31'),
(21, 'App\\Models\\User', 26, 'GloryLuxe/11 CFNetwork/3860.300.31 Darwin/25.2.0', 'a66e2eca75cba143b232d95253af06a65c28c5f8ec81fea746dceb6bdbbedf84', '[\"*\"]', '2026-01-09 09:53:38', NULL, '2026-01-09 09:52:34', '2026-01-09 09:53:38'),
(22, 'App\\Models\\User', 3, 'okhttp/4.12.0', 'ef1e86f50f9e551cedc2d42f60d431fa973ee706f064d4b6745bc831e93a877d', '[\"*\"]', '2026-01-14 07:14:21', NULL, '2026-01-13 01:57:33', '2026-01-14 07:14:21'),
(23, 'App\\Models\\User', 10, 'okhttp/4.12.0', 'b90906ca336e5ac38f6f6b7ac91fa3997a71f326127f800978d54d51297ba06a', '[\"*\"]', '2026-01-14 01:42:15', NULL, '2026-01-14 01:42:05', '2026-01-14 01:42:15'),
(24, 'App\\Models\\User', 3, 'Expo/54.0.6 CFNetwork/1474 Darwin/22.6.0', '692d498e92ec020d6ed5f26da455839aa349ab93e4988ced82cf53a636771e94', '[\"*\"]', '2026-01-19 04:56:01', NULL, '2026-01-19 04:55:38', '2026-01-19 04:56:01'),
(25, 'App\\Models\\User', 10, 'okhttp/4.12.0', '3a1597efb0941bd85a87b55a9b283a52324aeb7be85f800794083943bd80579f', '[\"*\"]', '2026-01-19 05:36:41', NULL, '2026-01-19 05:35:31', '2026-01-19 05:36:41'),
(26, 'App\\Models\\User', 10, 'okhttp/4.12.0', '60353cc5620fd26942609ecdc698391acec83e85da3b5f85880bfffc7f834719', '[\"*\"]', '2026-01-22 06:44:21', NULL, '2026-01-19 05:38:31', '2026-01-22 06:44:21'),
(27, 'App\\Models\\User', 30, 'okhttp/4.12.0', 'd31a51d99c59b7168f6d61b4a42f664b4271c0d966ff5740ef0afa54a95b88b0', '[\"*\"]', '2026-01-22 05:37:59', NULL, '2026-01-22 02:15:55', '2026-01-22 05:37:59'),
(28, 'App\\Models\\User', 31, 'GloryLuxe/12 CFNetwork/3860.300.31 Darwin/25.2.0', 'c6432387d29a8e663d2ca89ff6eb2014cc0d8f93973b072fb2f8a639fc414cf8', '[\"*\"]', '2026-01-22 05:28:47', NULL, '2026-01-22 05:26:55', '2026-01-22 05:28:47'),
(29, 'App\\Models\\User', 23, 'okhttp/4.12.0', 'e912fa76333fd220850b02a02685aee4f125b1b5ab54a19ee0109ad21d2fdde2', '[\"*\"]', '2026-01-22 05:38:37', NULL, '2026-01-22 05:38:36', '2026-01-22 05:38:37'),
(30, 'App\\Models\\User', 3, 'GloryLuxe/11 CFNetwork/3826.600.41 Darwin/24.6.0', '768b19b28502160eb6f6169c7ad7a3c53f86bd53fd63273f231a9a450fb39616', '[\"*\"]', '2026-01-22 06:39:52', NULL, '2026-01-22 06:39:51', '2026-01-22 06:39:52'),
(31, 'App\\Models\\User', 33, 'GloryLuxe/11 CFNetwork/3826.600.41 Darwin/24.6.0', '2e7bee516714367a478c0142d6e3f545d78e62eedaf42240dcbbbc67ebe330e7', '[\"*\"]', '2026-01-22 07:13:52', NULL, '2026-01-22 06:41:26', '2026-01-22 07:13:52'),
(32, 'App\\Models\\User', 32, 'okhttp/4.12.0', '23ad4bec772068bc04cc07fce464863101d40d84e8a67184746584748f663018', '[\"*\"]', '2026-01-22 06:46:51', NULL, '2026-01-22 06:45:31', '2026-01-22 06:46:51'),
(33, 'App\\Models\\User', 32, 'okhttp/4.12.0', 'b6058ec52354d04f7bb59c626efbac652f15dcb3cacb53114561c76cd1e537d6', '[\"*\"]', '2026-01-28 06:50:15', NULL, '2026-01-22 06:46:14', '2026-01-28 06:50:15'),
(34, 'App\\Models\\User', 23, 'GloryLuxe/12 CFNetwork/3860.300.31 Darwin/25.2.0', 'e99bcdb6e274cafd829c005709fc4c033216652ef3da4e4e6d2e4325cf34d1ef', '[\"*\"]', '2026-01-23 08:25:10', NULL, '2026-01-23 08:24:49', '2026-01-23 08:25:10'),
(35, 'App\\Models\\User', 34, 'GloryLuxe/12 CFNetwork/3826.400.120 Darwin/24.3.0', '0bf2457adc40839fa439dfedc8d10ce7700b5ab7bd762d306b100155d7ce1515', '[\"*\"]', '2026-02-05 09:46:40', NULL, '2026-01-23 11:09:20', '2026-02-05 09:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `gender` enum('Male','Female','Both') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `service_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `gender`, `description`, `category_id`, `created_at`, `updated_at`, `service_image`) VALUES
(31, 'Haircuts (Ladies & Gents)', 2500.00, 'Both', 'Expert haircuts tailored to your style and face shape — from trendy fades to elegant layers, ensuring a fresh and confident look for both men and women.', 21, '2025-10-22 08:33:04', '2025-10-22 08:33:04', NULL),
(32, 'Beard Trim & Shave', 1500.00, 'Both', 'Precision beard grooming and clean shaves using professional techniques for a sharp, polished appearance.', 21, '2025-10-22 08:34:36', '2025-10-22 08:34:36', NULL),
(33, 'Hair Styling & Special Setting', 3500.00, 'Both', 'Customized styling for any occasion - from elegant updos and curls to sleek party looks, using premium styling tools and products.', 21, '2025-10-22 08:35:27', '2025-10-22 08:35:27', NULL),
(34, 'Hair Straightening / Perming', 9000.00, 'Both', 'Transform your natural texture with long-lasting straightening or curling treatments designed for smooth, frizz-free results.', 21, '2025-10-22 08:36:06', '2025-10-22 08:36:06', NULL),
(35, 'Hair Coloring & Highlights', 4500.00, 'Both', 'Professional coloring services using high-quality products for full color, balayage, or subtle highlights that enhance your natural beauty.', 21, '2025-10-22 08:36:39', '2025-10-22 08:36:39', NULL),
(37, 'Keratin & Smoothing Treatments', 20000.00, 'Both', 'Deep repair and frizz control with nourishing keratin treatments that leave your hair silky, shiny, and easy to manage.', 21, '2025-10-22 08:38:16', '2025-10-22 08:38:16', NULL),
(38, 'Cleansing & Brightening Facials', 4000.00, 'Both', 'Deep-cleanse your skin to remove impurities and restore a natural, healthy glow. Ideal for dull, tired skin that needs instant brightness and refreshment.', 22, '2025-10-22 08:39:36', '2025-10-22 08:39:36', NULL),
(39, 'Hydrating & Rejuvenating Care', 4000.00, 'Both', 'Replenish moisture and revive your skin’s softness with our nourishing hydration therapy, leaving your face supple, smooth, and refreshed.', 22, '2025-10-22 08:40:09', '2025-10-22 08:40:09', NULL),
(40, 'Anti-Aging Treatments', 6000.00, 'Both', 'Combat fine lines, wrinkles, and skin fatigue with our advanced anti-aging facials that tighten, lift, and rejuvenate your skin for a youthful glow.', 22, '2025-10-22 08:40:36', '2025-10-22 08:40:36', NULL),
(41, 'Acne & Skin Repair Treatments', 4500.00, 'Both', 'Target acne, scars, and pigmentation with specialized treatments that calm inflammation and promote skin healing for a clearer, smoother complexion.', 22, '2025-10-22 08:41:06', '2025-10-22 08:41:06', NULL),
(42, 'Threading (Eyebrows, Face)', 2000.00, 'Both', 'Precise and gentle threading for perfectly shaped eyebrows and smooth, hair-free skin without irritation.', 22, '2025-10-22 08:41:37', '2025-10-22 08:41:37', NULL),
(43, 'Waxing (Full Body / Specific Areas)', 10000.00, 'Both', 'Smooth and soft skin with our hygienic waxing services, using premium products suitable for sensitive skin. Choose full body or specific areas.', 22, '2025-10-22 08:42:10', '2025-10-22 08:42:10', NULL),
(44, 'Manicure & Pedicure', 3500.00, 'Both', 'Pamper your hands and feet with cleansing, exfoliation, and moisturizing treatments followed by perfect nail shaping and polish application.', 23, '2025-10-22 08:44:29', '2025-10-22 08:44:29', NULL),
(45, 'Nail Extensions & Art', 5000.00, 'Both', 'Enhance your nails with durable extensions and creative nail art designs customized to your personal style — from elegant to bold.', 23, '2025-10-22 08:44:52', '2025-10-22 08:44:52', NULL),
(46, 'Gel & Acrylic Nails', 5000.00, 'Both', 'Long-lasting gel or acrylic nail systems that deliver flawless shine and strength with your choice of finish — classic, matte, or glitter.', 23, '2025-10-22 08:45:12', '2025-10-22 08:45:12', NULL),
(47, 'Hand & Foot Spa', 5000.00, 'Both', 'Relax and refresh with deep cleansing, exfoliation, and massage therapies for your hands and feet — perfect for improving circulation and softness.', 23, '2025-10-22 08:45:32', '2025-10-22 08:45:32', NULL),
(48, 'Relaxing Body Massage & Spa Rituals', 15000.00, 'Both', 'Indulge in soothing full-body massages and holistic spa therapies designed to release stress, ease tension, and rejuvenate body and mind.', 23, '2025-10-22 08:46:05', '2025-10-22 08:46:05', NULL),
(49, 'Party & Evening Makeup', 4000.00, 'Both', 'Flawless, long-lasting makeup that complements your outfit and enhances your natural beauty. Ideal for parties, dinners, and special nights out.', 24, '2025-10-22 08:49:55', '2025-10-22 08:49:55', NULL),
(50, 'Bridal Makeup & Dressing', 20000.00, 'Both', 'Complete bridal transformation with professional makeup, hairstyling, and dressing. Our team ensures a radiant, timeless look for your big day using premium products.', 24, '2025-10-22 08:50:26', '2025-10-22 08:50:26', NULL),
(51, 'Engagement & Pre-Shoot Looks', 25000.00, 'Both', 'Customized looks for engagement ceremonies or pre-wedding shoots, designed to highlight your features beautifully in both natural and studio lighting.', 24, '2025-10-22 08:50:51', '2025-10-22 08:50:51', NULL),
(52, 'Saree Draping & Full Dressing', 5000.00, 'Female', 'Customized looks for engagement ceremonies or pre-wedding shoots, designed to highlight your features beautifully in both natural and studio lighting.', 24, '2025-10-22 08:51:54', '2025-10-22 08:51:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_bookings`
--

CREATE TABLE `service_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_bookings`
--

INSERT INTO `service_bookings` (`id`, `booking_id`, `service_id`, `created_at`, `updated_at`) VALUES
(54, 51, 38, '2025-10-22 09:01:50', '2025-10-22 09:01:50'),
(55, 51, 40, '2025-10-22 09:01:50', '2025-10-22 09:01:50'),
(56, 52, 31, '2025-10-24 03:49:30', '2025-10-24 03:49:30'),
(57, 52, 34, '2025-10-24 03:49:30', '2025-10-24 03:49:30'),
(58, 53, 47, '2025-10-24 04:43:35', '2025-10-24 04:43:35'),
(59, 54, 50, '2025-10-24 04:47:57', '2025-10-24 04:47:57'),
(60, 54, 51, '2025-10-24 04:47:57', '2025-10-24 04:47:57'),
(61, 55, 31, '2025-11-21 07:37:45', '2025-11-21 07:37:45'),
(62, 55, 44, '2025-11-21 07:37:45', '2025-11-21 07:37:45'),
(63, 56, 31, '2025-12-29 03:56:07', '2025-12-29 03:56:07'),
(64, 56, 32, '2025-12-29 03:56:07', '2025-12-29 03:56:07'),
(65, 57, 49, '2025-12-29 04:00:11', '2025-12-29 04:00:11'),
(66, 58, 31, '2025-12-29 04:04:38', '2025-12-29 04:04:38'),
(67, 59, 46, NULL, NULL),
(68, 60, 31, '2025-12-29 05:17:13', '2025-12-29 05:17:13'),
(69, 60, 32, '2025-12-29 05:17:13', '2025-12-29 05:17:13'),
(70, 61, 31, '2025-12-29 05:18:05', '2025-12-29 05:18:05'),
(71, 61, 32, '2025-12-29 05:18:05', '2025-12-29 05:18:05'),
(72, 62, 31, '2025-12-29 05:21:27', '2025-12-29 05:21:27'),
(73, 63, 48, '2025-12-29 05:26:00', '2025-12-29 05:26:00'),
(74, 64, 37, '2025-12-29 05:29:07', '2025-12-29 05:29:07'),
(75, 65, 49, '2025-12-29 07:31:21', '2025-12-29 07:31:21'),
(76, 65, 50, '2025-12-29 07:31:21', '2025-12-29 07:31:21'),
(77, 66, 49, '2025-12-29 07:31:33', '2025-12-29 07:31:33'),
(78, 66, 50, '2025-12-29 07:31:33', '2025-12-29 07:31:33'),
(79, 66, 51, '2025-12-29 07:31:33', '2025-12-29 07:31:33'),
(80, 67, 31, '2025-12-29 10:36:43', '2025-12-29 10:36:43'),
(81, 67, 32, '2025-12-29 10:36:43', '2025-12-29 10:36:43'),
(82, 67, 33, '2025-12-29 10:36:43', '2025-12-29 10:36:43'),
(83, 68, 31, '2025-12-30 08:06:10', '2025-12-30 08:06:10'),
(84, 68, 32, '2025-12-30 08:06:10', '2025-12-30 08:06:10'),
(85, 69, 39, NULL, NULL),
(86, 70, 31, '2025-12-31 03:01:47', '2025-12-31 03:01:47'),
(87, 70, 32, '2025-12-31 03:01:47', '2025-12-31 03:01:47'),
(88, 71, 33, '2025-12-31 03:02:10', '2025-12-31 03:02:10'),
(89, 72, 33, '2025-12-31 03:04:30', '2025-12-31 03:04:30'),
(90, 72, 34, '2025-12-31 03:04:30', '2025-12-31 03:04:30'),
(91, 73, 31, '2026-01-02 02:32:51', '2026-01-02 02:32:51'),
(92, 73, 32, '2026-01-02 02:32:51', '2026-01-02 02:32:51'),
(93, 74, 38, '2026-01-02 02:33:24', '2026-01-02 02:33:24'),
(94, 74, 40, '2026-01-02 02:33:24', '2026-01-02 02:33:24'),
(95, 75, 45, '2026-01-02 02:34:23', '2026-01-02 02:34:23'),
(96, 75, 47, '2026-01-02 02:34:23', '2026-01-02 02:34:23'),
(97, 76, 51, '2026-01-02 02:35:07', '2026-01-02 02:35:07'),
(98, 76, 52, '2026-01-02 02:35:07', '2026-01-02 02:35:07'),
(99, 77, 31, '2026-01-02 03:13:28', '2026-01-02 03:13:28'),
(100, 77, 32, '2026-01-02 03:13:28', '2026-01-02 03:13:28'),
(101, 78, 39, '2026-01-02 03:13:42', '2026-01-02 03:13:42'),
(102, 78, 40, '2026-01-02 03:13:42', '2026-01-02 03:13:42'),
(103, 78, 41, '2026-01-02 03:13:42', '2026-01-02 03:13:42'),
(104, 79, 51, '2026-01-02 03:13:56', '2026-01-02 03:13:56'),
(105, 79, 52, '2026-01-02 03:13:56', '2026-01-02 03:13:56'),
(106, 80, 32, '2026-01-02 06:51:45', '2026-01-02 06:51:45'),
(107, 80, 33, '2026-01-02 06:51:45', '2026-01-02 06:51:45'),
(108, 81, 38, '2026-01-02 06:52:16', '2026-01-02 06:52:16'),
(109, 81, 41, '2026-01-02 06:52:16', '2026-01-02 06:52:16'),
(110, 82, 46, '2026-01-02 06:52:57', '2026-01-02 06:52:57'),
(111, 82, 47, '2026-01-02 06:52:57', '2026-01-02 06:52:57'),
(112, 83, 44, '2026-01-02 06:53:00', '2026-01-02 06:53:00'),
(113, 84, 34, '2026-01-02 07:48:38', '2026-01-02 07:48:38'),
(114, 85, 46, '2026-01-02 09:39:26', '2026-01-02 09:39:26'),
(115, 86, 47, NULL, NULL),
(116, 87, 46, NULL, NULL),
(117, 88, 49, NULL, NULL),
(118, 89, 48, NULL, NULL),
(119, 90, 44, NULL, NULL),
(120, 91, 42, '2026-01-06 10:30:20', '2026-01-06 10:30:20'),
(121, 92, 45, '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(122, 92, 46, '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(123, 92, 47, '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(124, 92, 48, '2026-01-07 02:52:07', '2026-01-07 02:52:07'),
(125, 93, 51, '2026-01-08 02:44:27', '2026-01-08 02:44:27'),
(126, 94, 34, '2026-01-08 02:44:38', '2026-01-08 02:44:38'),
(127, 95, 41, '2026-01-08 02:44:58', '2026-01-08 02:44:58'),
(128, 96, 47, '2026-01-08 02:45:51', '2026-01-08 02:45:51'),
(129, 97, 52, '2026-01-08 02:46:11', '2026-01-08 02:46:11'),
(130, 98, 44, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(131, 98, 45, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(132, 98, 46, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(133, 98, 47, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(134, 98, 48, '2026-01-08 02:48:16', '2026-01-08 02:48:16'),
(135, 99, 40, '2026-01-08 04:57:10', '2026-01-08 04:57:10'),
(136, 100, 38, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(137, 100, 39, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(138, 100, 40, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(139, 100, 49, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(140, 100, 50, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(141, 100, 51, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(142, 100, 52, '2026-01-08 07:08:55', '2026-01-08 07:08:55'),
(143, 101, 45, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(144, 101, 46, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(145, 101, 48, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(146, 101, 49, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(147, 101, 50, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(148, 101, 51, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(149, 101, 52, '2026-01-08 07:12:30', '2026-01-08 07:12:30'),
(150, 102, 40, '2026-01-13 01:57:46', '2026-01-13 01:57:46'),
(151, 103, 39, '2026-01-19 04:55:47', '2026-01-19 04:55:47'),
(152, 103, 41, '2026-01-19 04:55:47', '2026-01-19 04:55:47'),
(153, 104, 31, '2026-01-19 05:35:37', '2026-01-19 05:35:37'),
(154, 104, 32, '2026-01-19 05:35:37', '2026-01-19 05:35:37'),
(155, 104, 33, '2026-01-19 05:35:37', '2026-01-19 05:35:37'),
(156, 105, 31, '2026-01-19 05:38:36', '2026-01-19 05:38:36'),
(157, 105, 32, '2026-01-19 05:38:36', '2026-01-19 05:38:36'),
(158, 106, 34, '2026-01-22 05:27:24', '2026-01-22 05:27:24'),
(159, 107, 34, '2026-01-22 05:28:41', '2026-01-22 05:28:41'),
(160, 107, 35, '2026-01-22 05:28:41', '2026-01-22 05:28:41'),
(161, 107, 37, '2026-01-22 05:28:41', '2026-01-22 05:28:41'),
(162, 108, 41, '2026-01-23 11:09:28', '2026-01-23 11:09:28'),
(163, 109, 33, NULL, NULL),
(166, 112, 34, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CkCjUk1v0LR7BYVDMeDfVAHBOhCDOz6S5tlJtIza', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVNaMFgzRFFwYUlBZnhKZHZ2Q0ZodU5DQnpxWm1ldVNCUUZMYVNEdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdGFmZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1771326161),
('Rlw5ExqBSbOIW3ZYh6ZJ8c54bubDZJxAbyJJ5PW9', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieGNiZ3hrQXJ2ZHdaZ3FUN1JMbm1DYTZPdVNxa0g5NGlaMk9EYmJEViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1771471409);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `ratings` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `etf_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `contact_number`, `ratings`, `created_at`, `updated_at`, `experience`, `join_date`, `bank_account_number`, `bank_name`, `basic_salary`, `etf_number`) VALUES
(1, 'Vishmi Dulanjalee', '1234567', 3, '2025-09-15 10:26:45', '2026-02-17 05:14:55', '1year', '2026-02-03', '322455222463', 'HNB', 85000.00, '23'),
(2, 'John Doe', '0771234567', 4, '2025-09-16 00:43:21', '2025-09-16 00:43:21', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `api_token` varchar(88) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `status`, `api_token`, `remember_token`, `created_at`, `updated_at`, `role`, `phone_number`) VALUES
(1, 'admin', 'admin', 'admin@example.com', NULL, '$2y$10$gMYS7Gj2F2mRO6u9BtAKuuTJtamnDvqVPzWj2PBzTgxUf/YW71gQu', 'inactive', '3a2c5c3d7f0f1036ed3ca9a578f59b05a35c637ef98acfa8dc48c064eb6b5dbf', NULL, NULL, '2026-01-02 09:34:27', 'admin', NULL),
(2, 'Jeon', 'Kookie', 'a@g.c', NULL, '$2y$10$gMYS7Gj2F2mRO6u9BtAKuuTJtamnDvqVPzWj2PBzTgxUf/YW71gQu', 'active', 'f5bd43cc86463a288159ee7878e3b034178ddcb5fedbb03757abd5fb9aaf57d9', NULL, '2025-09-15 05:45:27', '2026-01-02 08:08:40', 'admin', '0766032569'),
(3, 'xyz', 'xyz', 'xyz@g.c', NULL, '$2y$10$RgwX4Ugf6Ptvbn/pAVv4Te4CfuEkYpd428HrOwz6VmuOQULrDO90.', 'active', '9006271b45072084d3720f5390f3ac646cc488941ca350099f4a622769a5b557', NULL, '2025-09-15 09:17:14', '2026-01-08 02:48:31', 'user', '0766032569'),
(4, 'abc', 'abc', 'abc@g.c', NULL, '$2y$10$0a101DrpISBbITosS98Ip.OpVw02jbLtNfEdW8jX8jI1JlOpfnq2C', 'active', 'bca640c6e95410a423411cc2dcc31d59a8946c0bda47dc856eaacb0925ba2d65', NULL, '2025-09-15 09:40:38', '2025-11-26 03:58:53', 'user', '0766032568'),
(5, 'aaa', NULL, 'ab@g.c', NULL, '$2y$10$Qc7dRicaWCxWjzllXEtD0ubjN72BTNnwE2OxwvrHv5dUJ/GQ2U72.', 'active', NULL, NULL, '2025-09-16 07:06:07', '2025-09-16 07:06:07', 'user', '0769872173'),
(6, 'Admin', 'Test', 'admin@test.com', NULL, '$2y$10$Z0iwuhoLPiAcw0dv32waP.c89V7W2tZj8y6/bH6B7SNc7WxQ6jOdu', 'active', '2741980d02b6508c27b7ca494f0946d85afd442cb5b4d82e20b8a1c69f8fa37b', NULL, '2025-09-16 07:07:08', '2025-10-24 04:49:12', 'admin', '0769872173'),
(7, 'John', 'Doe', 'johndoe@example.com', NULL, '$2y$10$0HcDGvANEedY0q.oJThZOuWM6zMtUk/jYwyYQVPiYKz4humKVd8VO', 'active', NULL, NULL, '2025-09-18 07:31:34', '2025-09-18 07:31:34', 'user', '0771234567'),
(8, 'aaa', NULL, 'test1@g.c', NULL, '$2y$10$1BPXiYD5M11rIwdVEO11deJZArOrbv4so.o/CBoIJXtOgaeRDexsa', 'active', NULL, NULL, '2025-09-18 07:34:04', '2025-09-18 07:34:04', 'admin', '0769872173'),
(9, 'aaa', NULL, 'tes2@g.c', NULL, '$2y$10$D8B8lpDcyxX5wBgSOPxH..z3oRz757eNjui7f2M4v7mT4MRWd2FYe', 'active', NULL, NULL, '2025-09-18 07:35:47', '2025-09-18 07:35:47', 'admin', '0769872173'),
(10, 'Thaf', 'Naz', 'thaf@g.c', NULL, '$2y$10$Dmh43/zPAzSA7xnl9G82YusX2EriOGCfsocEQ3WMwABU9mJQRYnXy', 'active', '2646ea85cc89efa0a1ba67ff8c6fdd314f39e3368a75553b8ba5583b0de8e129', NULL, '2025-09-18 07:36:43', '2026-01-02 09:14:56', 'user', '014236586'),
(11, 'aaa', NULL, 'test3@g.c', NULL, '$2y$10$gMYS7Gj2F2mRO6u9BtAKuuTJtamnDvqVPzWj2PBzTgxUf/YW71gQu', 'active', '19ee40e36161b6179b32e46319081fc41a9b670b83ff922825373a06837d65cc', NULL, '2025-09-18 07:37:30', '2025-12-30 08:19:21', 'admin', '0769872173'),
(12, 'test', 'test', 'test123@g.c', NULL, '$2y$10$JNI9iOoK/lf3z8lntiEC5ufgR8h0jN0mrLGlbWg5iptSNPkqlNaRO', 'active', NULL, NULL, '2025-09-18 07:42:53', '2025-09-18 07:42:53', 'user', '0123695412'),
(13, 'test', 'test', 'test13@g.c', NULL, '$2y$10$JsC0JLllY./1WexzQdLIgura0AHpMFVZdvVnb6CmnHxISwY2I2ypq', 'active', '29d6ec1ed5ec4eeac38829b2dd94afa735a74535e712c7ffeabc4d5540d3bcd8', NULL, '2025-09-18 07:43:09', '2025-09-18 09:20:43', 'user', '0123695412'),
(14, 'Thafani', 'Nawas', 'thafani01@gmail.com', NULL, '$2y$10$X9ATe2Zl9WQM2kS/ElIYueiyha5QN8OAoEaMum6KuHhMDfTC6DpJe', 'active', 'ab00bf394f432c37d9728e887e22c94626748ae2c4a0e02af81087084c351eb6', NULL, '2025-10-21 07:34:13', '2025-10-24 03:48:41', 'user', '07666085213'),
(15, 'Thafani', 'Nawab', 'thafnaz42@gmail.com', NULL, '$2y$10$1znk7YanRWTm/LoxEU.IQ.YhpnFSQ25PhOVFE1WPY1/uJJmvFgc5y', 'active', NULL, NULL, '2025-10-21 07:34:38', '2025-10-21 07:34:38', 'user', '07666085213'),
(16, 'New', 'Client', 'client@g.c', NULL, '$2y$10$/mKk5jIyN5EXxSD6WqGjr.hfrOksRIWJtmu32/dwUHjd2CupD2bTm', 'active', NULL, NULL, '2025-10-21 08:24:09', '2025-10-21 08:24:09', 'user', '0766032123'),
(17, 'diluk', 'mihiranga', 's@gm.com', NULL, '$2y$10$XQIih0xZcSoPNXVoA/tIEeWoUDTiCcYP7FtxJmz3RgdgivYJceqFm', 'active', NULL, NULL, '2025-11-24 06:33:42', '2025-11-24 06:33:42', 'user', '077268451'),
(18, 'abc', 'abc', 'b@a.c', NULL, '$2y$10$QZ8MzTp/4nUu0AVqPpCCiuLOmp1SZSr.3nFNqBGs9wqB.azu2yCjO', 'active', NULL, NULL, '2025-11-25 02:59:56', '2025-11-25 02:59:56', 'user', '0875376524'),
(19, 'AAA', 'BBBB', 'dns@gmail.com', NULL, '$2y$10$hoKZD7zpF.ZT6z9sAJWg9uz1UzjozUY1fBmcBzz8vRe/Tey.vAuEC', 'active', NULL, NULL, '2025-12-15 05:59:38', '2025-12-15 05:59:38', 'user', '0773602193'),
(20, 'test', 'A', 'abc@gmail.com', NULL, '$2y$10$Cdnm8Igfq5GOm6ZMpia1.uhCvupH5bZoIE9V6GiY9zNLph4SG.RBi', 'active', NULL, NULL, '2025-12-15 06:09:10', '2025-12-15 06:09:10', 'user', '0123456789'),
(21, 'test1', 'test1', 'asd@g.c', NULL, '$2y$10$CHIQ3okiEKvd2SSINXHC/Ov6vTmyM/Hd.rO252jMMVut1GGFwkJLO', 'active', NULL, NULL, '2025-12-15 06:25:33', '2025-12-15 06:25:33', 'user', '7896541230'),
(22, 'test2', 'tests', 'ddd@g.c', NULL, '$2y$10$YXjauns7DRSw1xQqRj8aB.Anrei8Ehbq9K6NLnCngO7Hjh1Ipsqmm', 'active', NULL, NULL, '2025-12-15 06:34:48', '2025-12-15 06:34:48', 'user', '0773602193'),
(23, 'Henry', 'Peterson', 'testnew@gmail.com', NULL, '$2y$10$gMYS7Gj2F2mRO6u9BtAKuuTJtamnDvqVPzWj2PBzTgxUf/YW71gQu', 'active', '8dd9a3a0dffa790f1d099e78e49646ff166be0f846d6f98889f2dfb6861d1675', NULL, '2025-12-30 08:04:47', '2025-12-31 03:03:41', 'user', '011235968'),
(24, 'Bash', 'Hash', 'b@g.c', NULL, '$2y$10$xvpdTNUcQm5E1Ij/DjTCr.NrdB8WAqg23pylxVDng7Fdh3z5ppiom', 'active', 'c1933b85c31212c8179d6d528c44b951aaedf3e18e535998ccfd2176227bb1e7', NULL, '2026-01-02 03:13:00', '2026-01-02 06:51:03', 'user', '0112235965'),
(25, 'John', 'Tester', 'o7qp24g38b7jk8pwv1j@icloud.com', NULL, '$2y$10$/ld7XrAmIvI1646aGDsxROLzOClkKGSoS98WeFprhB8pgsCqHCPq2', 'active', NULL, NULL, '2026-01-06 10:26:00', '2026-01-06 10:26:00', 'user', '6693334444'),
(26, 'Apple', 'john', 'nathannorth2005@gmail.com', NULL, '$2y$10$WiZwJJ/VGClsbYm6r/sE4uGjtZddgYAWGFchXJ..ndSViK03AUyuW', 'active', NULL, NULL, '2026-01-09 09:51:19', '2026-01-09 09:51:19', 'user', '6693334444'),
(27, 'aaaaaa', 'bbbbb', 'adb@g.c', NULL, '$2y$10$q8I5liGwFiDjnFarfK2mmee9ZtWF2dqk/yHu2SXdClexQyPlsMQ6.', 'active', NULL, NULL, '2026-01-14 07:45:10', '2026-01-14 07:45:10', 'user', '0112235964'),
(28, 'bassa', 'dessa', 'bcd@g.c', NULL, '$2y$10$YUkRsozY1s08b24s/LFnY.LRVdTFt77jRJ1/o.Z3pY7YtTm.qFzii', 'active', NULL, NULL, '2026-01-14 07:50:24', '2026-01-14 07:50:24', 'user', '0112235777'),
(30, 'Nawodi', 'Priyawansha', 'nawodi.priyawansha6@gmail.com', NULL, '$2y$10$281JWYfMzrviJZdUgtIFOuz0fVg8XJ4zWSLVO/S39fTfGwJ/fsqk6', 'active', NULL, NULL, '2026-01-22 02:15:04', '2026-01-22 02:15:04', 'user', '0765407497'),
(31, 'Test', 'Test', 'ying.p24g38b.o82zk@icloud.com', NULL, '$2y$10$FjB2zbI2Ehvje6dMcO61G.VliDVlSJjtZnvTlYEu2dMQCiDLCpixW', 'active', NULL, NULL, '2026-01-22 05:26:21', '2026-01-22 05:26:21', 'user', '6693334444'),
(32, 'Prasad', 'Siriwardena', 'prasadtab1@icloud.com', NULL, '$2y$10$UVYrlnqSWLtsBg8FdixmB.SJO4V1JdZafxSNNgsUUMFquHgkkEhLa', 'active', NULL, NULL, '2026-01-22 06:33:38', '2026-01-22 06:33:38', 'user', '0777666988'),
(33, 'Ssss', 'Bbbbb', 'sss@g.c', NULL, '$2y$10$OtQv1g4I5UWj2LBCTXa/7u7E0kBHTNeegWTovdMY2CULCrzVzIuNC', 'active', NULL, NULL, '2026-01-22 06:40:55', '2026-01-22 06:40:55', 'user', '0777666988'),
(34, 'Udara', 'Edirimanne', 'evishwanath8@icloud.com', NULL, '$2y$10$hpt3OVuS5egsyNQMl5PHWOCGmZVG53oca1NcnpOtDfKNbCGCyiha.', 'active', NULL, NULL, '2026-01-23 11:09:03', '2026-01-23 11:09:03', 'user', '0774509006');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_invoice_number_unique` (`invoice_number`),
  ADD KEY `bills_client_id_foreign` (`client_id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_items_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_staff_id_foreign` (`staff_id`),
  ADD KEY `bookings_client_id_foreign` (`client_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_staff`
--
ALTER TABLE `category_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_staff_staff_id_foreign` (`staff_id`),
  ADD KEY `category_staff_category_id_foreign` (`category_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_client_id_foreign` (`client_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_details_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_booking_id_foreign` (`booking_id`);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_bookings_booking_id_foreign` (`booking_id`),
  ADD KEY `service_bookings_service_id_foreign` (`service_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `category_staff`
--
ALTER TABLE `category_staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `service_bookings`
--
ALTER TABLE `service_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_staff`
--
ALTER TABLE `category_staff`
  ADD CONSTRAINT `category_staff_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_bookings`
--
ALTER TABLE `service_bookings`
  ADD CONSTRAINT `service_bookings_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
