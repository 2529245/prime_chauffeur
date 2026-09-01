-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2026 at 10:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prime_chauffeur`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset_assignments`
--

CREATE TABLE `asset_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assignable_type` enum('staff','driver','partner') NOT NULL,
  `assignable_id` bigint(20) UNSIGNED NOT NULL,
  `asset_type` enum('pos_machine','mobile_phone','sim_card') NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `date_assigned` date NOT NULL,
  `date_returned` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_assignments`
--

INSERT INTO `asset_assignments` (`id`, `assignable_type`, `assignable_id`, `asset_type`, `asset_id`, `date_assigned`, `date_returned`, `notes`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'staff', 1, 'pos_machine', 1, '2025-09-30', '2025-09-30', 'djkdkj', '2025-09-30 00:26:41', '2025-09-30 16:28:57', 1, 1),
(52, 'driver', 117, 'pos_machine', 15, '2026-08-03', '2026-08-03', 'Testing', '2026-08-03 17:11:29', '2026-08-03 17:11:47', 1, 1),
(53, 'driver', 117, 'mobile_phone', 2, '2026-08-03', '2026-08-12', NULL, '2026-08-03 17:12:20', '2026-08-12 21:55:12', 1, 67),
(54, 'driver', 117, 'sim_card', 17, '2026-08-03', '2026-08-03', NULL, '2026-08-03 17:13:14', '2026-08-03 17:13:25', 1, 1),
(55, 'staff', 5, 'pos_machine', 15, '2026-08-12', '2026-08-12', NULL, '2026-08-12 21:02:21', '2026-08-12 21:02:33', 67, 67),
(56, 'driver', 117, 'sim_card', 17, '2026-08-12', '2026-08-12', NULL, '2026-08-12 21:48:55', '2026-08-12 22:00:08', 67, 67),
(57, 'staff', 5, 'mobile_phone', 2, '2026-08-12', NULL, NULL, '2026-08-12 21:55:20', '2026-08-12 21:55:20', 67, NULL),
(58, 'driver', 117, 'pos_machine', 15, '2026-08-12', '2026-08-12', NULL, '2026-08-12 21:58:07', '2026-08-12 21:58:11', 67, 67),
(59, 'staff', 5, 'sim_card', 17, '2026-08-12', NULL, NULL, '2026-08-12 22:00:15', '2026-08-12 22:00:15', 67, NULL),
(60, 'staff', 5, 'pos_machine', 15, '2026-08-26', NULL, NULL, '2026-08-26 00:02:44', '2026-08-26 00:02:44', 67, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_contact_number` varchar(255) DEFAULT NULL,
  `pick_up_time` datetime NOT NULL,
  `drop_off_time` datetime DEFAULT NULL,
  `pick_up_location` text NOT NULL,
  `drop_off_location` text DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method` enum('cash','credit','bank_transfer','online') DEFAULT NULL,
  `no_of_extra_hrs` int(11) DEFAULT 0,
  `basic_amount` decimal(10,2) NOT NULL,
  `extra_hrs_amount` decimal(10,2) DEFAULT 0.00,
  `other_amounts` decimal(10,2) DEFAULT 0.00,
  `gross_total` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','in_progress','completed','cancelled') DEFAULT 'pending',
  `special_instructions` longtext DEFAULT NULL,
  `cancel_reason` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `guest_name`, `guest_contact_number`, `pick_up_time`, `drop_off_time`, `pick_up_location`, `drop_off_location`, `service`, `vehicle_id`, `driver_id`, `payment_method`, `no_of_extra_hrs`, `basic_amount`, `extra_hrs_amount`, `other_amounts`, `gross_total`, `status`, `special_instructions`, `cancel_reason`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(608, 'eeee', '5555555555', '2026-08-11 19:14:00', '2026-08-12 19:14:00', '564545', '545445', NULL, 90, 117, NULL, 0, 5656565.00, 0.00, 0.00, 5656565.00, 'confirmed', ',f,.f,.', NULL, '2026-08-11 17:15:03', '2026-08-11 17:18:08', 1, 1),
(610, 'test', '5555555555', '2026-08-11 20:23:00', '2026-08-11 20:29:00', 'dddd', 'ddd', NULL, NULL, 118, NULL, 0, 1000.00, 0.00, 0.00, 1000.00, 'pending', NULL, NULL, '2026-08-11 18:23:59', '2026-08-11 18:23:59', 1, 1),
(611, 'test', '45555555', '2026-07-30 20:44:00', NULL, 'ff', NULL, NULL, NULL, NULL, NULL, 0, 585555.00, 0.00, 0.00, 585555.00, 'pending', NULL, NULL, '2026-08-11 18:44:47', '2026-08-11 18:44:47', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','on_leave') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `contact_no`, `emergency_contact`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(117, 'test', '02000000002', '01232555', 'active', '2026-08-03 17:00:57', '2026-08-03 17:00:57', 1, NULL),
(118, 'Umair6', '0200000000266', '01232555655', 'active', '2026-08-11 18:20:21', '2026-08-11 18:21:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `driver_documents`
--

CREATE TABLE `driver_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` enum('contract','emirates_id','driving_license','passport','rta_card','visa','home_country_id') NOT NULL,
  `document_path` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_documents`
--

INSERT INTO `driver_documents` (`id`, `driver_id`, `document_type`, `document_path`, `expiry_date`, `created_at`, `updated_at`) VALUES
(50, 117, 'contract', 'driver-documents/Nsm7Q0W224ItNBIPX1NGHwSRpiusZs1fPecRGnmw.png', '2026-08-19', '2026-08-03 17:03:04', '2026-08-03 17:03:04'),
(51, 117, 'driving_license', 'driver-documents/rcikiRzNJyMsfW1gNIQlVSAgwPussrIOodUP7Blz.png', '2027-06-03', '2026-08-03 17:14:29', '2026-08-03 17:14:29'),
(52, 118, 'driving_license', 'driver-documents/9ZdnYRGkbPbh93ouRaBz0YK0gLwu3BTD71lW98r9.png', '2026-08-13', '2026-08-11 18:25:37', '2026-08-11 18:25:37'),
(53, 117, 'home_country_id', 'driver-documents/MusUnF2FyZM1AQD5fyzboIIRUAY6NtBWPRMn6vZu.jpg', '2026-09-06', '2026-08-26 00:02:07', '2026-08-26 00:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_phones`
--

CREATE TABLE `mobile_phones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_model` varchar(255) NOT NULL,
  `imei_number` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `status` enum('active','inactive','broken','retired') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobile_phones`
--

INSERT INTO `mobile_phones` (`id`, `phone_model`, `imei_number`, `phone_number`, `purchase_date`, `status`, `notes`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 'Realme 12 5G', NULL, NULL, NULL, 'active', NULL, '2025-11-21 10:46:13', '2026-09-01 20:35:06', 53, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 65),
(7, 'App\\Models\\User', 66),
(5, 'App\\Models\\User', 67),
(8, 'App\\Models\\User', 68);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('umair.khan2313@yahoo.com', '$2y$10$RUAI7YStw4QoVfquVn9r3emGH3DSWnbzxCKj1lGf.jaPzH1ajgJ9i', '2026-08-25 23:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(234, 'dashboard-view', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(235, 'booking-list', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(236, 'booking-create', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(237, 'booking-edit', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(238, 'booking-delete', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(239, 'booking-status-update', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(240, 'booking-today', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(241, 'booking-tomorrow', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(242, 'booking-pdf-download', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(243, 'booking-pdf-view', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(244, 'booking-export', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(245, 'vehicle-list', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(246, 'vehicle-create', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(247, 'vehicle-edit', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(248, 'vehicle-delete', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(249, 'vehicle-export', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(250, 'driver-list', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(251, 'driver-create', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(252, 'driver-edit', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(253, 'driver-delete', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(254, 'driver-export', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(255, 'driver-document-list', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(256, 'driver-document-create', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(257, 'driver-document-edit', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(258, 'driver-document-delete', 'web', '2026-08-12 16:03:19', '2026-08-12 16:03:19'),
(259, 'driver-document-view', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(260, 'driver-document-download', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(261, 'staff-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(262, 'staff-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(263, 'staff-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(264, 'staff-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(265, 'staff-document-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(266, 'staff-document-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(267, 'staff-document-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(268, 'staff-document-view', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(269, 'staff-document-download', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(270, 'user-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(271, 'user-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(272, 'user-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(273, 'user-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(274, 'user-export', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(275, 'role-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(276, 'role-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(277, 'role-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(278, 'role-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(279, 'permission-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(280, 'permission-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(281, 'permission-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(282, 'permission-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(283, 'pos-machine-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(284, 'pos-machine-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(285, 'pos-machine-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(286, 'pos-machine-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(287, 'mobile-phone-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(288, 'mobile-phone-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(289, 'mobile-phone-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(290, 'mobile-phone-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(291, 'sim-card-list', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(292, 'sim-card-create', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(293, 'sim-card-edit', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(294, 'sim-card-delete', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(295, 'asset-assign', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(296, 'asset-return', 'web', '2026-08-12 16:03:20', '2026-08-12 16:03:20'),
(297, 'staff-document-list', 'web', '2026-08-12 16:35:31', '2026-08-12 16:35:31');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pos_machines`
--

CREATE TABLE `pos_machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `machine_id` varchar(255) NOT NULL,
  `machine_model` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_machines`
--

INSERT INTO `pos_machines` (`id`, `machine_id`, `machine_model`, `purchase_date`, `warranty_expiry`, `status`, `notes`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(15, '352112', '2d5d5', '2026-08-04', '2027-08-03', 'active', NULL, '2026-08-03 17:10:35', '2026-08-03 17:10:35', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Super Admin', 'web', '2026-08-12 16:05:12', '2026-08-12 16:05:12'),
(6, 'Clerk', 'web', '2026-08-12 17:01:16', '2026-08-12 17:01:16'),
(7, 'Manager', 'web', '2026-08-12 17:47:20', '2026-08-12 17:47:20'),
(8, 'Operations', 'web', '2026-08-12 21:06:15', '2026-08-12 21:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(234, 5),
(234, 7),
(234, 8),
(235, 5),
(235, 6),
(235, 8),
(236, 5),
(236, 6),
(236, 8),
(237, 5),
(237, 6),
(237, 8),
(238, 5),
(238, 6),
(238, 8),
(239, 5),
(239, 6),
(239, 8),
(240, 5),
(240, 6),
(240, 8),
(241, 5),
(241, 6),
(241, 8),
(242, 5),
(242, 6),
(242, 8),
(243, 5),
(243, 6),
(243, 8),
(244, 5),
(244, 6),
(244, 8),
(245, 5),
(246, 5),
(247, 5),
(248, 5),
(249, 5),
(250, 5),
(250, 6),
(251, 5),
(251, 6),
(252, 5),
(252, 6),
(253, 5),
(253, 6),
(254, 5),
(254, 6),
(255, 5),
(255, 6),
(256, 5),
(256, 6),
(257, 5),
(257, 6),
(258, 5),
(258, 6),
(259, 5),
(259, 6),
(260, 5),
(260, 6),
(261, 5),
(261, 6),
(262, 5),
(262, 6),
(263, 5),
(263, 6),
(264, 5),
(264, 6),
(265, 5),
(265, 6),
(266, 5),
(266, 6),
(267, 5),
(267, 6),
(268, 5),
(268, 6),
(269, 5),
(269, 6),
(270, 5),
(270, 7),
(271, 5),
(271, 7),
(272, 5),
(272, 7),
(273, 5),
(273, 7),
(274, 5),
(274, 7),
(275, 5),
(276, 5),
(277, 5),
(278, 5),
(279, 5),
(280, 5),
(281, 5),
(282, 5),
(283, 5),
(283, 6),
(284, 5),
(284, 6),
(285, 5),
(285, 6),
(286, 5),
(286, 6),
(287, 5),
(287, 6),
(288, 5),
(288, 6),
(289, 5),
(289, 6),
(290, 5),
(290, 6),
(291, 5),
(291, 6),
(292, 5),
(292, 6),
(293, 5),
(293, 6),
(294, 5),
(294, 6),
(295, 5),
(295, 6),
(296, 5),
(296, 6),
(297, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sim_cards`
--

CREATE TABLE `sim_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sim_number` varchar(255) NOT NULL,
  `telecom_provider` varchar(255) DEFAULT NULL,
  `plan_details` varchar(255) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sim_cards`
--

INSERT INTO `sim_cards` (`id`, `sim_number`, `telecom_provider`, `plan_details`, `activation_date`, `status`, `notes`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(17, '545445', 'Other', '50', '2026-08-03', 'active', NULL, '2026-08-03 17:12:56', '2026-08-03 17:12:56', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','on_leave') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `position`, `contact_info`, `emergency_contact`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(5, 'Umair', 'Operations', '03216502', '01232555', 'active', '2026-08-11 18:59:55', '2026-08-11 18:59:55', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_documents`
--

CREATE TABLE `staff_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `staff_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` enum('emirates_id','visa','passport','employee_contract','driving_license','other') NOT NULL,
  `document_path` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_documents`
--

INSERT INTO `staff_documents` (`id`, `staff_id`, `document_type`, `document_path`, `expiry_date`, `created_at`, `updated_at`) VALUES
(26, 5, 'passport', 'staff-documents/zN5as19Ew0MYqH5JSgydX9SmWcuG5BWyMa7oZ60V.png', '2026-08-12', '2026-08-11 19:37:11', '2026-08-11 19:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=TA/TP',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `email_verified_at`, `password`, `role_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(67, 'Super', 'Admin', 'admin@admin.com', '0000000000', NULL, '$2y$10$wmPsTSFabo.kHL5KTvhg6.7/wAexKh1q5OUP9PPOrVKkdsOTgihfm', 5, 1, NULL, '2026-08-12 18:03:57', '2026-08-12 18:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `vehicle_plate_no` varchar(255) NOT NULL,
  `vehicle_model` varchar(255) NOT NULL,
  `vehicle_color` varchar(255) NOT NULL,
  `mulkiya_expiry_date` date DEFAULT NULL,
  `status` enum('active','maintenance','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_name`, `vehicle_plate_no`, `vehicle_model`, `vehicle_color`, `mulkiya_expiry_date`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(92, 'test', '0000000', 'test', 'black', '2026-08-05', 'active', '2026-08-03 17:15:48', '2026-08-03 17:15:48', 1, NULL),
(93, 'testing52', '00000005896', 'test585', 'test25', '2026-08-13', 'active', '2026-08-11 17:46:30', '2026-08-11 17:47:53', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_drivers`
--

CREATE TABLE `vehicle_drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_drivers`
--

INSERT INTO `vehicle_drivers` (`id`, `vehicle_id`, `driver_id`, `is_primary`, `created_at`, `updated_at`) VALUES
(85, 92, 117, 1, '2026-08-03 17:15:48', '2026-08-03 17:15:48'),
(86, 93, 117, 1, '2026-08-11 17:46:30', '2026-08-11 17:47:53'),
(88, 93, 118, 1, '2026-08-11 18:21:33', '2026-08-11 18:22:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_asset_assignments` (`assignable_type`,`assignable_id`,`asset_type`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bookings_driver` (`driver_id`),
  ADD KEY `idx_bookings_vehicle` (`vehicle_id`),
  ADD KEY `idx_bookings_dates` (`pick_up_time`,`drop_off_time`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_drivers_status` (`status`);

--
-- Indexes for table `driver_documents`
--
ALTER TABLE `driver_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_driver_documents` (`driver_id`,`document_type`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_phones`
--
ALTER TABLE `mobile_phones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imei_number` (`imei_number`),
  ADD KEY `idx_mobile_phones_status` (`status`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`);

--
-- Indexes for table `pos_machines`
--
ALTER TABLE `pos_machines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `machine_id` (`machine_id`),
  ADD KEY `idx_pos_machines_status` (`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sim_cards`
--
ALTER TABLE `sim_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sim_number` (`sim_number`),
  ADD KEY `idx_sim_cards_status` (`status`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_documents`
--
ALTER TABLE `staff_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_plate_no` (`vehicle_plate_no`),
  ADD KEY `idx_vehicles_status` (`status`),
  ADD KEY `idx_vehicles_plate` (`vehicle_plate_no`);

--
-- Indexes for table `vehicle_drivers`
--
ALTER TABLE `vehicle_drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vehicle_driver` (`vehicle_id`,`driver_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `driver_documents`
--
ALTER TABLE `driver_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `mobile_phones`
--
ALTER TABLE `mobile_phones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `pos_machines`
--
ALTER TABLE `pos_machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sim_cards`
--
ALTER TABLE `sim_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff_documents`
--
ALTER TABLE `staff_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `vehicle_drivers`
--
ALTER TABLE `vehicle_drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `driver_documents`
--
ALTER TABLE `driver_documents`
  ADD CONSTRAINT `driver_documents_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_documents`
--
ALTER TABLE `staff_documents`
  ADD CONSTRAINT `staff_documents_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_drivers`
--
ALTER TABLE `vehicle_drivers`
  ADD CONSTRAINT `vehicle_drivers_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_drivers_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
