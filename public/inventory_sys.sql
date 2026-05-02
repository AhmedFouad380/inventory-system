-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 30, 2026 at 03:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1777511727),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1777511727;', 1777511727);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Electrical Materials', 'Enim accusamus et distinctio voluptatem.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'Construction Tools', 'Quibusdam repudiandae libero non quos debitis.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'Office Supplies', 'Numquam quia rerum sed voluptates doloremque aut consequuntur.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'Chemicals', 'Qui quod nisi aut reprehenderit quas sunt.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'Safety Equipment', 'Sapiente adipisci eum fugit unde qui molestiae consectetur.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'Mechanical Parts', 'Id molestias rerum saepe velit occaecati quos.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(7, 'Cables', 'Commodi dolor ipsam eum ipsum.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(8, 'Pipes and Fittings', 'Rerum voluptatibus sed impedit facere.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Marks, Kessler and Ortiz', 'Kendall Jerde DDS', '484.852.7219', 'bettie.schulist@example.net', '3414 Bogan Drives\nFerrystad, MS 90672', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'Dibbert PLC', 'Miss Leatha Hand', '+1-364-267-8502', 'candido.beier@example.org', '647 Verna Forge Suite 603\nKunzemouth, SD 77908-5072', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'O\'Keefe Ltd', 'Mrs. Vesta Hansen V', '+1 (623) 458-7441', 'edwin.kreiger@example.com', '1362 Jerad Way Apt. 856\nWest Efren, PA 28541-5902', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'Goyette-Stehr', 'Miss Stacy Johns IV', '1-239-237-0311', 'ellsworth75@example.org', '55913 Helga Highway Apt. 704\nLake Francesbury, OK 76026-3494', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'Price-Corwin', 'Ms. Ozella Raynor Jr.', '(857) 848-3976', 'hanna15@example.com', '495 Graham Key Suite 862\nPricechester, NE 62764-3327', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'Schneider, Shanahan and Reichel', 'Vito Boyle', '+1 (567) 885-2069', 'delfina42@example.org', '85522 Carlee Lights\nBrandotown, VA 08791-3813', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

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
-- Table structure for table `gate_passes`
--

CREATE TABLE `gate_passes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gp_number` varchar(255) NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `issued_at` datetime NOT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `status` enum('draft','approved','issued','confirmed') DEFAULT 'draft',
  `prepared_by` bigint(20) UNSIGNED NOT NULL,
  `warehouse_keeper_id` bigint(20) UNSIGNED DEFAULT NULL,
  `engineer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gate_passes`
--

INSERT INTO `gate_passes` (`id`, `gp_number`, `work_order_id`, `warehouse_id`, `issued_at`, `vehicle_number`, `recipient_name`, `driver_name`, `destination`, `status`, `prepared_by`, `warehouse_keeper_id`, `engineer_id`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 5, NULL, '2026-04-27 14:42:43', '2104jjj', 'ahmed', 'ahmed', 'تسيت ', 'approved', 1, 1, 1, NULL, '2026-04-27 08:42:56', '2026-04-27 08:42:56', NULL),
(2, '٢', 5, 1, '2026-04-27 15:05:53', '2104jjj', 'ahmed', 'ahmed', 'تسيت ', 'approved', 1, 1, 1, NULL, '2026-04-27 09:06:17', '2026-04-27 09:06:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gate_pass_items`
--

CREATE TABLE `gate_pass_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gate_pass_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty_issued` decimal(12,3) NOT NULL,
  `reel_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gate_pass_items`
--

INSERT INTO `gate_pass_items` (`id`, `gate_pass_id`, `item_id`, `qty_issued`, `reel_number`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 11, 2.000, NULL, NULL, '2026-04-27 09:06:17', '2026-04-27 09:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit` enum('pcs','meter','kg','roll','box','drum','set','bag','liter') NOT NULL DEFAULT 'pcs',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `name`, `description`, `unit`, `category_id`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ITM-1860BF', 'PVC Fitting 90 Degree quae', 'Cumque et aliquid qui enim omnis maiores culpa quasi.', 'roll', 8, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'ITM-5331DG', 'Safety Helmet White reprehenderit', 'Fugit enim maiores assumenda cum.', 'pcs', 3, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'ITM-8443XO', 'Screwdriver Set nam', 'Quaerat est sint rerum eligendi cupiditate.', 'box', 2, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'ITM-3180EM', 'Welding Machine in', 'Tempore sit nulla nesciunt blanditiis.', 'pcs', 3, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'ITM-9187AL', 'Safety Helmet White et', 'Tempore et maxime aut.', 'pcs', 4, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'ITM-9576CH', 'Safety Helmet White totam', 'Assumenda voluptatem quis quos necessitatibus rerum.', 'pcs', 6, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(7, 'ITM-9705IF', 'Screwdriver Set animi', 'Ab aut magni eveniet excepturi vel.', 'meter', 3, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(8, 'ITM-7681KY', 'Work Gloves Leather esse', 'Dignissimos sed est rerum aut error.', 'box', 6, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(9, 'ITM-3465YK', 'LED Flood Light 50W sint', 'Libero esse fuga fugiat nobis.', 'roll', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(10, 'ITM-5187KT', 'Measuring Tape 5m nihil', 'Qui qui eum est tempore recusandae.', 'roll', 4, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(11, 'ITM-0145CN', 'LED Flood Light 50W in', 'Et dolor eius et odio.', 'roll', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(12, 'ITM-2858TY', 'Copper Cable 4mm quidem', 'Enim temporibus omnis quasi.', 'roll', 8, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(13, 'ITM-4314TW', 'Work Gloves Leather ut', 'Velit et molestiae sunt voluptatem pariatur nam voluptates.', 'meter', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(14, 'ITM-1686OR', 'Welding Machine inventore', 'Rerum repellendus ducimus dolore et occaecati.', 'box', 6, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(15, 'ITM-5006DZ', 'Welding Machine quidem', 'Voluptatem et dolor minima voluptatem sunt vero inventore sint.', 'pcs', 8, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(16, 'ITM-8361KV', 'Steel Pipe 2 inch quo', 'Rem fugiat reprehenderit ipsam et accusamus velit.', 'roll', 5, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(17, 'ITM-8633XE', 'Safety Helmet White amet', 'Quibusdam fugit dignissimos neque at ad et.', 'roll', 8, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(18, 'ITM-7111BY', 'Copper Cable 4mm minima', 'Quam nihil veniam dolor laborum quis dignissimos nobis eum.', 'meter', 6, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(19, 'ITM-2056IX', 'Measuring Tape 5m velit', 'Rem provident optio voluptatum.', 'kg', 4, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(20, 'ITM-7607BN', 'Safety Helmet White possimus', 'Perspiciatis rerum voluptatum suscipit exercitationem error nostrum.', 'pcs', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_disposal_requests`
--

CREATE TABLE `material_disposal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mdr_number` varchar(255) NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mdr_date` date NOT NULL,
  `disposal_reason` enum('damaged','scrap','expired','excess') NOT NULL,
  `disposal_method` varchar(255) DEFAULT NULL,
  `status` enum('draft','pending_approval','approved','executed') NOT NULL DEFAULT 'draft',
  `prepared_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `inspection_notes` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_disposal_requests`
--

INSERT INTO `material_disposal_requests` (`id`, `mdr_number`, `work_order_id`, `warehouse_id`, `mdr_date`, `disposal_reason`, `disposal_method`, `status`, `prepared_by`, `approved_by`, `approved_at`, `inspection_notes`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '1', 5, NULL, '2026-04-27', 'damaged', 'إعدام', 'approved', 1, 1, '2026-04-27 12:00:38', NULL, NULL, '2026-04-27 09:00:49', '2026-04-27 09:00:49', NULL),
(6, '2', 5, 1, '2026-04-28', 'expired', 'إعدام', 'approved', 1, 1, '2026-04-27 12:03:22', NULL, NULL, '2026-04-27 09:03:00', '2026-04-27 09:03:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_receipt_notes`
--

CREATE TABLE `material_receipt_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mrn_number` varchar(255) NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mrn_date` date NOT NULL,
  `delivery_note_ref` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `contract_ref` varchar(255) DEFAULT NULL,
  `status` enum('draft','confirmed','approved') NOT NULL DEFAULT 'draft',
  `prepared_by` bigint(20) UNSIGNED NOT NULL,
  `warehouse_keeper_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_receipt_notes`
--

INSERT INTO `material_receipt_notes` (`id`, `mrn_number`, `work_order_id`, `warehouse_id`, `supplier_id`, `mrn_date`, `delivery_note_ref`, `vehicle_number`, `contract_ref`, `status`, `prepared_by`, `warehouse_keeper_id`, `approved_by`, `approved_at`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '09', 1, 1, 9, '2026-04-27', '١٢٣', '٦٦٦', '١٢٣٤', 'approved', 1, 1, 1, '2026-04-27 13:15:04', NULL, '2026-04-27 10:15:41', '2026-04-27 10:15:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `material_return_requests`
--

CREATE TABLE `material_return_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mrr_number` varchar(255) NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mrr_date` date NOT NULL,
  `return_to` varchar(255) NOT NULL,
  `transport_details` varchar(255) DEFAULT NULL,
  `receiver_signature` varchar(255) DEFAULT NULL,
  `status` enum('draft','approved','confirmed') DEFAULT 'draft',
  `prepared_by` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_return_requests`
--

INSERT INTO `material_return_requests` (`id`, `mrr_number`, `work_order_id`, `warehouse_id`, `mrr_date`, `return_to`, `transport_details`, `receiver_signature`, `status`, `prepared_by`, `notes`, `created_at`, `updated_at`, `deleted_at`, `supplier_id`) VALUES
(1, '08', 5, 1, '2026-04-27', 'hh', 'hh', NULL, 'approved', 1, NULL, '2026-04-27 10:16:30', '2026-04-27 10:19:37', '2026-04-27 10:19:37', 6),
(2, '21', 5, 1, '2026-04-27', '212', '121', NULL, 'approved', 1, NULL, '2026-04-27 10:18:55', '2026-04-27 10:19:53', '2026-04-27 10:19:53', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mdr_items`
--

CREATE TABLE `mdr_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mdr_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty_disposed` decimal(12,3) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdr_items`
--

INSERT INTO `mdr_items` (`id`, `mdr_id`, `item_id`, `qty_disposed`, `notes`, `created_at`, `updated_at`) VALUES
(1, 6, 11, 10.000, NULL, '2026-04-27 09:03:00', '2026-04-27 09:03:00');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_26_000000_create_categories_table', 1),
(5, '2026_04_26_000001_create_projects_table', 1),
(6, '2026_04_26_000002_create_sites_table', 1),
(7, '2026_04_26_000003_create_contractors_table', 1),
(8, '2026_04_26_000004_create_suppliers_table', 1),
(9, '2026_04_26_000005_create_items_table', 1),
(10, '2026_04_26_000006_create_work_orders_table', 1),
(11, '2026_04_26_000007_create_work_order_stocks_table', 1),
(12, '2026_04_26_000008_create_material_receipt_notes_table', 1),
(13, '2026_04_26_000009_create_mrn_items_table', 1),
(14, '2026_04_26_000010_create_gate_passes_table', 1),
(15, '2026_04_26_000011_create_gate_pass_items_table', 1),
(16, '2026_04_26_000012_create_material_disposal_requests_table', 1),
(17, '2026_04_26_000013_create_mdr_items_table', 1),
(18, '2026_04_26_000014_create_material_return_requests_table', 1),
(19, '2026_04_26_000015_create_mrr_items_table', 1),
(20, '2026_04_26_000016_create_work_order_transfers_table', 1),
(21, '2026_04_26_000017_create_stock_ledgers_table', 1),
(22, '2026_04_27_000334_fix_status_enums_in_various_tables', 2),
(23, '2026_04_27_105134_create_warehouses_table', 3),
(24, '2026_04_27_105146_add_warehouse_id_to_transaction_tables', 4),
(25, '2026_04_27_110129_create_work_order_transfer_items_table', 5),
(26, '2026_04_27_110133_update_work_order_transfers_table', 6),
(27, '2026_04_27_123626_add_supplier_id_to_material_return_requests_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `mrn_items`
--

CREATE TABLE `mrn_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mrn_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty_received` decimal(12,3) NOT NULL,
  `reel_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mrn_items`
--

INSERT INTO `mrn_items` (`id`, `mrn_id`, `item_id`, `qty_received`, `reel_number`, `notes`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 200.000, NULL, NULL, '2026-04-27 10:15:41', '2026-04-27 10:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `mrr_items`
--

CREATE TABLE `mrr_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mrr_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty_returned` decimal(12,3) NOT NULL,
  `return_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `code`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Project North Sincere', 'PRJ-INII', 'Saepe qui accusamus et accusantium. Nesciunt quae eos voluptates omnis similique facere repellendus. Accusamus atque placeat odio quia veritatis illo est. Autem quidem vel eos quaerat harum nihil in. Necessitatibus doloremque sit enim dolorem quae.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'Project Strosinstad', 'PRJ-LQCV', 'Voluptatum ratione illum reprehenderit pariatur voluptate. Neque laborum culpa sunt eum nihil aperiam aut incidunt. Debitis dolores labore totam ad. Dolor voluptates voluptatem ut.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'Project South Leanne', 'PRJ-BPKV', 'Ut eveniet saepe nesciunt aperiam dolor quo sunt. Fugit facere quia et provident pariatur.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'Project Mannchester', 'PRJ-DWNM', 'Nisi quia nostrum ut sint id. Commodi et maiores cupiditate molestiae quibusdam. Dolorem voluptas mollitia sapiente et cupiditate. Fugiat possimus possimus molestiae hic.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'Project South Laisha', 'PRJ-TUFM', 'Illo sunt repudiandae officiis ullam ipsum natus eius. Corrupti praesentium rem ea tempora ipsam quos earum consequatur.', 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

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
('7FvfzOv5XsgerdOfngHoIMj4pCtPH7OzDeLwzvOh', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI1Q0lWNzVSVmdKZm9XV2VNOGgzdjVwaU00V2RvNER0bmVqc05uMFQzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2ludmVudG9yeV9zeXMudGVzdFwvYWRtaW5cL2dhdGUtcGFzc2VzIiwicm91dGUiOiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMuZ2F0ZS1wYXNzZXMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwicGFzc3dvcmRfaGFzaF93ZWIiOiJjMjJmYTg4NTU2MWUxZWRiMmVmOWY4NGMyNzc2NThmMWE0NWQ1MTVmMGU0OTJkYTcwMzMyMTIzYWJlNzhjMjFhIiwibG9jYWxlIjoiYXIiLCJ0YWJsZXMiOnsiNTU2MDI1ZGVhYzJkNmIzNDdhZWRkOWRjOGVlZWNkMDJfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJtZHJfbnVtYmVyIiwibGFiZWwiOiJcdTA2MzFcdTA2NDJcdTA2NDUgTURSIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndhcmVob3VzZS5uYW1lIiwibGFiZWwiOiJcdTA2NDVcdTA2MzNcdTA2MmFcdTA2NDhcdTA2MmZcdTA2MzkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid29ya09yZGVyLndvX251bWJlciIsImxhYmVsIjoiXHUwNjIzXHUwNjQ1XHUwNjMxIFx1MDYzOVx1MDY0NVx1MDY0NCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJtZHJfZGF0ZSIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIE1EUiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDYyZFx1MDYyN1x1MDY0NFx1MDYyOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCJhZDA3NDhjODFkMTgwM2QxM2I0ZjEwNDhlOTRlNGY1OF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImdwX251bWJlciIsImxhYmVsIjoiXHUwNjMxXHUwNjQyXHUwNjQ1IFx1MDYyYVx1MDYzNVx1MDYzMVx1MDY0YVx1MDYyZCBcdTA2MjdcdTA2NDRcdTA2MjhcdTA2NDhcdTA2MjdcdTA2MjhcdTA2MjkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2FyZWhvdXNlLm5hbWUiLCJsYWJlbCI6Ilx1MDY0NVx1MDYzM1x1MDYyYVx1MDY0OFx1MDYyZlx1MDYzOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ3b3JrT3JkZXIud29fbnVtYmVyIiwibGFiZWwiOiJcdTA2MjNcdTA2NDVcdTA2MzEgXHUwNjM5XHUwNjQ1XHUwNjQ0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Imlzc3VlZF9hdCIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIFx1MDYyN1x1MDY0NFx1MDYyNVx1MDYzNVx1MDYyZlx1MDYyN1x1MDYzMSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDYyZFx1MDYyN1x1MDY0NFx1MDYyOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCI4N2RiNDU5MjFhNDA0ODFjMTk5YTM2MTIxNzVmOTgxMV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndvcmtPcmRlci53b19udW1iZXIiLCJsYWJlbCI6IldvcmsgT3JkZXIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2FyZWhvdXNlLm5hbWUiLCJsYWJlbCI6IldhcmVob3VzZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpdGVtLmRlc2NyaXB0aW9uIiwibGFiZWwiOiJJdGVtIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InF0eV9yZWNlaXZlZCIsImxhYmVsIjoiUmVjZWl2ZWQgUXR5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InF0eV9pc3N1ZWQiLCJsYWJlbCI6Iklzc3VlZCBRdHkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicXR5X2Rpc3Bvc2VkIiwibGFiZWwiOiJpbnZlbnRvcnkuZmllbGRzLnF0eV9kaXNwb3NlZCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJxdHlfcmV0dXJuZWQiLCJsYWJlbCI6ImludmVudG9yeS5maWVsZHMucXR5X3JldHVybmVkIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InF0eV90cmFuc2Zlcl9vdXQiLCJsYWJlbCI6ImludmVudG9yeS5maWVsZHMucXR5X3RyYW5zZmVyX291dCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJxdHlfdHJhbnNmZXJfaW4iLCJsYWJlbCI6ImludmVudG9yeS5maWVsZHMucXR5X3RyYW5zZmVyX2luIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImJhbGFuY2UiLCJsYWJlbCI6IkJhbGFuY2UiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJVcGRhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCIzM2M0OWQ4YzFmY2M2ZThlMDA3ODI0NTNiYzBkMmNkZV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndvcmtPcmRlci53b19udW1iZXIiLCJsYWJlbCI6Ilx1MDYyM1x1MDY0NVx1MDYzMSBcdTA2MzlcdTA2NDVcdTA2NDQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2FyZWhvdXNlLm5hbWUiLCJsYWJlbCI6Ilx1MDY0NVx1MDYzM1x1MDYyYVx1MDY0OFx1MDYyZlx1MDYzOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpdGVtLmRlc2NyaXB0aW9uIiwibGFiZWwiOiJcdTA2MzVcdTA2NDZcdTA2NDEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidHJhbnNhY3Rpb25fdHlwZSIsImxhYmVsIjoiXHUwNjI3XHUwNjQ0XHUwNjQ2XHUwNjQ4XHUwNjM5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRyYW5zYWN0aW9uX2lkIiwibGFiZWwiOiJcdTA2MjdcdTA2NDRcdTA2NDNcdTA2NDhcdTA2MmYiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidHJhbnNhY3Rpb25fZGF0ZSIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIE1STiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJxdHlfaW4iLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDY0M1x1MDY0NVx1MDY0YVx1MDYyOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJxdHlfb3V0IiwibGFiZWwiOiJcdTA2MjdcdTA2NDRcdTA2NDNcdTA2NDVcdTA2NGFcdTA2MjkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiYmFsYW5jZV9hZnRlciIsImxhYmVsIjoiXHUwNjI3XHUwNjQ0XHUwNjMxXHUwNjM1XHUwNjRhXHUwNjJmIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRCeS5uYW1lIiwibGFiZWwiOiJcdTA2MjNcdTA2NDZcdTA2MzRcdTA2MjYgXHUwNjI4XHUwNjQ4XHUwNjI3XHUwNjMzXHUwNjM3XHUwNjI5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiVXBkYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiZGRjMWQwOGViZWZhNjUyMjkwM2FiMWYzN2MzY2I4YWNfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJcdTA2MjdcdTA2NDRcdTA2MjdcdTA2MzNcdTA2NDUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZGVzY3JpcHRpb24iLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDY0OFx1MDYzNVx1MDY0MSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6Ilx1MDY0Nlx1MDYzNFx1MDYzNyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCIyN2QxMGZmZDc3YzhiMWFjNGU2MTczNDM5MmUwMjc4NF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im1ybl9udW1iZXIiLCJsYWJlbCI6Ilx1MDYzMVx1MDY0Mlx1MDY0NSBNUk4iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2FyZWhvdXNlLm5hbWUiLCJsYWJlbCI6Ilx1MDY0NVx1MDYzM1x1MDYyYVx1MDY0OFx1MDYyZlx1MDYzOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ3b3JrT3JkZXIud29fbnVtYmVyIiwibGFiZWwiOiJcdTA2MjNcdTA2NDVcdTA2MzEgXHUwNjM5XHUwNjQ1XHUwNjQ0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InN1cHBsaWVyLm5hbWUiLCJsYWJlbCI6Ilx1MDY0NVx1MDY0OFx1MDYzMVx1MDYyZiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJtcm5fZGF0ZSIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIE1STiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDYyZFx1MDYyN1x1MDY0NFx1MDYyOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCIyMDJlMGZmODc0Y2QwYjVjOGZmMGIwODZlNDIwNTFiZl9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im1ycl9udW1iZXIiLCJsYWJlbCI6Ilx1MDYzMVx1MDY0Mlx1MDY0NSBNUlIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2FyZWhvdXNlLm5hbWUiLCJsYWJlbCI6Ilx1MDY0NVx1MDYzM1x1MDYyYVx1MDY0OFx1MDYyZlx1MDYzOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ3b3JrT3JkZXIud29fbnVtYmVyIiwibGFiZWwiOiJcdTA2MjNcdTA2NDVcdTA2MzEgXHUwNjM5XHUwNjQ1XHUwNjQ0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im1ycl9kYXRlIiwibGFiZWwiOiJcdTA2MmFcdTA2MjdcdTA2MzFcdTA2NGFcdTA2MmUgTVJSIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InN0YXR1cyIsImxhYmVsIjoiXHUwNjI3XHUwNjQ0XHUwNjJkXHUwNjI3XHUwNjQ0XHUwNjI5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWF0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sIjgxM2NiNTgyZTczYmMzYTA1ZjU2NDkyNTdiNjliZjcxX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid29fbnVtYmVyIiwibGFiZWwiOiJXbyBudW1iZXIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicHJvamVjdC5uYW1lIiwibGFiZWwiOiJcdTA2NDVcdTA2MzRcdTA2MzFcdTA2NDhcdTA2MzkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic2l0ZS5uYW1lIiwibGFiZWwiOiJcdTA2NDVcdTA2NDhcdTA2NDJcdTA2MzkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY29udHJhY3Rvci5uYW1lIiwibGFiZWwiOiJcdTA2NDVcdTA2NDJcdTA2MjdcdTA2NDhcdTA2NDQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY29udHJhY3RfcmVmIiwibGFiZWwiOiJcdTA2NDVcdTA2MzFcdTA2MmNcdTA2MzkgXHUwNjI3XHUwNjQ0XHUwNjM5XHUwNjQyXHUwNjJmIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InN0YXR1cyIsImxhYmVsIjoiXHUwNjI3XHUwNjQ0XHUwNjJkXHUwNjI3XHUwNjQ0XHUwNjI5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im9wZW5lZF9hdCIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIFx1MDYyN1x1MDY0NFx1MDY0MVx1MDYyYVx1MDYyZCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjbG9zZWRfYXQiLCJsYWJlbCI6Ilx1MDYyYVx1MDYyN1x1MDYzMVx1MDY0YVx1MDYyZSBcdTA2MjdcdTA2NDRcdTA2MjVcdTA2M2FcdTA2NDRcdTA2MjdcdTA2NDIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZEJ5Lm5hbWUiLCJsYWJlbCI6Ilx1MDYyM1x1MDY0Nlx1MDYzNFx1MDYyNiBcdTA2MjhcdTA2NDhcdTA2MjdcdTA2MzNcdTA2MzdcdTA2MjkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJVcGRhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImRlbGV0ZWRfYXQiLCJsYWJlbCI6IkRlbGV0ZWQgYXQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sIjAyNzJlYjRjZjk0MjI2NGEwYWNlZWZjNmE5OTIyOTVhX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidHJhbnNmZXJfbnVtYmVyIiwibGFiZWwiOiJcdTA2MzFcdTA2NDJcdTA2NDUgXHUwNjI3XHUwNjQ0XHUwNjJhXHUwNjJkXHUwNjQ4XHUwNjRhXHUwNjQ0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndhcmVob3VzZS5uYW1lIiwibGFiZWwiOiJcdTA2NDVcdTA2MzNcdTA2MmFcdTA2NDhcdTA2MmZcdTA2MzkiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZnJvbVdvcmtPcmRlci53b19udW1iZXIiLCJsYWJlbCI6Ilx1MDY0NVx1MDY0NiBcdTA2MjNcdTA2NDVcdTA2MzEgXHUwNjM5XHUwNjQ1XHUwNjQ0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRvV29ya09yZGVyLndvX251bWJlciIsImxhYmVsIjoiXHUwNjI1XHUwNjQ0XHUwNjQ5IFx1MDYyM1x1MDY0NVx1MDYzMSBcdTA2MzlcdTA2NDVcdTA2NDQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidHJhbnNmZXJfZGF0ZSIsImxhYmVsIjoiXHUwNjJhXHUwNjI3XHUwNjMxXHUwNjRhXHUwNjJlIFx1MDYyN1x1MDY0NFx1MDYyYVx1MDYyZFx1MDY0OFx1MDY0YVx1MDY0NCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6Ilx1MDYyN1x1MDY0NFx1MDYyZFx1MDYyN1x1MDY0NFx1MDYyOSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XX19', 1777512215),
('JVwe7PMvGudGMkdRTljOuIkrKbnUZ0gl52bjfd9x', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko)', 'eyJfdG9rZW4iOiJHTVpadksyR1FENnVVaEJScVVhckJwRkl2ZFRPZzE2R0ZKekI2bmNvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2ludmVudG9yeV9zeXMudGVzdFwvP2hlcmQ9cHJldmlldyIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1777511658);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `name`, `location`, `project_id`, `is_active`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Site Delia Cove', '3001 Molly Manors\nElroyside, NV 82728-6633', 4, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'Site Graham Lodge', '2322 Considine Ridge Suite 272\nLaurianneburgh, CO 48752', 2, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'Site Lawson Trail', '7917 Hudson Creek\nEast Melba, ND 87027-4306', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'Site Carmelo Stravenue', '61391 Constance Center Apt. 516\nNew Elvie, SD 95096', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'Site Moore Gardens', '892 Cale Square\nNew Giovanifort, NH 43012', 5, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'Site Jacobson Via', '903 Dulce Terrace Apt. 053\nEast Norene, OH 70814-8451', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(7, 'Site Sonya Corner', '594 Ozella Fall Apt. 445\nZariahaven, SD 75495', 1, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(8, 'Site Aida Gateway', '878 Dakota Burgs\nNorth Shemarton, OK 83794', 2, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(9, 'Site Elroy Shore', '484 Maximillia Heights Suite 977\nWest Lisetteside, WV 16900', 2, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(10, 'Site Elisabeth Heights', '270 Schaefer Manors Suite 687\nPort Eloy, VA 91098', 2, 1, 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_ledgers`
--

CREATE TABLE `stock_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_type` enum('mrn','gate_pass','mdr','mrr','transfer_in','transfer_out') NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `qty_in` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_out` decimal(12,3) NOT NULL DEFAULT 0.000,
  `balance_after` decimal(12,3) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_ledgers`
--

INSERT INTO `stock_ledgers` (`id`, `work_order_id`, `item_id`, `warehouse_id`, `transaction_type`, `transaction_id`, `transaction_date`, `qty_in`, `qty_out`, `balance_after`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 5, 7, NULL, 'mrn', 1, '2026-04-21', 200.000, 10000.000, 20.000, 1, '2026-04-26 20:57:35', '2026-04-26 20:57:35'),
(2, 5, 18, 1, 'mrn', 1, '2026-04-29', 100.000, 0.000, 100.000, 1, '2026-04-27 08:40:02', '2026-04-27 08:40:02'),
(3, 5, 11, 1, 'mrn', 1, '2026-04-29', 100.000, 0.000, 100.000, 1, '2026-04-27 08:40:02', '2026-04-27 08:40:02'),
(4, 5, 11, 1, 'mdr', 6, '2026-04-28', 0.000, 10.000, 90.000, 1, '2026-04-27 09:03:26', '2026-04-27 09:03:26'),
(5, 5, 11, 1, 'gate_pass', 2, '2026-04-27', 0.000, 2.000, 88.000, 1, '2026-04-27 09:06:34', '2026-04-27 09:06:34'),
(6, 5, 11, 1, 'transfer_out', 3, '2026-04-27', 0.000, 20.000, 68.000, 1, '2026-04-27 09:54:02', '2026-04-27 09:54:02'),
(7, 8, 11, 1, 'transfer_in', 3, '2026-04-27', 20.000, 0.000, 20.000, 1, '2026-04-27 09:54:02', '2026-04-27 09:54:02'),
(8, 1, 1, 1, 'mrn', 2, '2026-04-27', 200.000, 0.000, 200.000, 1, '2026-04-27 10:15:53', '2026-04-27 10:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Reinger LLC Suppliers', 'Furman O\'Keefe', '(206) 416-2128', 'xjerde@example.net', '747 Fabian Prairie Apt. 199\nNew Briana, MA 19256-8674', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'Lubowitz, Hilpert and Donnelly Suppliers', 'Gregoria Shanahan', '+1-541-520-9579', 'gvon@example.net', '64786 Reilly Walk\nNorth Terrencemouth, IA 38551', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'Raynor and Sons Suppliers', 'Prof. Corene Bauch Jr.', '+15742617033', 'moses03@example.net', '24582 Benedict Gateway Apt. 473\nPatberg, VT 28260', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'Rogahn Ltd Suppliers', 'Dr. Sidney Veum DVM', '+17634981122', 'rmcglynn@example.net', '649 Berge Street\nWest Lilyshire, LA 21792', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'Padberg Ltd Suppliers', 'Edd Spencer', '+1-210-830-6129', 'eleffler@example.com', '7748 Emmerich Orchard Apt. 054\nEast Lucioside, LA 94820', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'Metz-Barton Suppliers', 'Dr. Asha Fay V', '1-660-201-6117', 'chyna29@example.com', '4919 Upton Isle\nLake Peytonmouth, VT 80483-1766', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(7, 'Roberts-Gusikowski Suppliers', 'Madalyn Vandervort', '+1-731-500-7790', 'kristy59@example.org', '102 Towne Orchard\nLake Jordy, MA 08685', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(8, 'Schinner, Graham and Hammes Suppliers', 'Dave Witting', '+1-662-767-6039', 'shaina.hansen@example.org', '84391 Oberbrunner Port Apt. 413\nWest Keshaun, MA 85166-6359', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(9, 'Kirlin-Stiedemann Suppliers', 'Chase Stamm', '+1-612-685-6898', 'yterry@example.com', '16101 Twila Path\nGrahamborough, CT 78950-8609', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(10, 'Littel-Maggio Suppliers', 'Karelle McCullough', '+12127108051', 'samson00@example.org', '532 Hyatt Mountains Suite 657\nSouth Chanelle, ID 53230', 1, '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@admin.com', NULL, '$2y$12$CsRrzHzg07.VVaGRAyobHe8KSff2CfTO0CkJGbWWo7U/GllShJk.i', NULL, '2026-04-26 20:44:20', '2026-04-26 20:44:20');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `code`, `location`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'المستودع الرئيسي', 'WH-MAIN', 'المنطقة المركزية', 1, '2026-04-27 07:56:11', '2026-04-27 07:56:11'),
(2, 'مستودع الموقع - أ', 'WH-SITE-A', 'موقع العمل أ', 1, '2026-04-27 07:56:11', '2026-04-27 07:56:11'),
(3, 'مستودع الموقع - ب', 'WH-SITE-B', 'موقع العمل ب', 1, '2026-04-27 07:56:11', '2026-04-27 07:56:11'),
(4, 'مستودع الخردة', 'WH-SCRAP', 'منطقة التخزين الخارجية', 1, '2026-04-27 07:56:11', '2026-04-27 07:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wo_number` varchar(255) NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `site_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contractor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contract_ref` varchar(255) DEFAULT NULL,
  `status` enum('open','closed','suspended') NOT NULL DEFAULT 'open',
  `opened_at` date NOT NULL,
  `closed_at` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_orders`
--

INSERT INTO `work_orders` (`id`, `wo_number`, `project_id`, `site_id`, `contractor_id`, `contract_ref`, `status`, `opened_at`, `closed_at`, `created_by`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'WO-2024-1693', 2, 3, 3, 'CONT/2689/2024', 'open', '2025-07-29', NULL, 1, 'Commodi repellendus non soluta. Alias et ut sint voluptas aperiam. Iste ullam eos laboriosam cumque illum dolore quo. At ex est asperiores dicta.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(2, 'WO-2024-7503', 1, 10, 4, 'CONT/6368/2024', 'closed', '2025-07-24', NULL, 1, 'Harum corrupti consequatur consequatur eius velit tempora maxime. Nemo a quae et maiores eius laboriosam omnis. Autem corporis provident incidunt sunt assumenda reiciendis nemo.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(3, 'WO-2024-2654', 1, 9, 6, 'CONT/1850/2024', 'closed', '2026-03-27', NULL, 1, 'Alias sit et perspiciatis omnis soluta excepturi sed. Neque maxime veritatis alias laudantium eum. Accusantium dolores suscipit tempora quisquam sunt. Ipsam consequatur voluptas tempore deserunt non omnis quos. Qui ducimus non aut cumque voluptatum laborum qui.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(4, 'WO-2024-5460', 1, 1, 5, 'CONT/5835/2024', 'suspended', '2025-10-01', NULL, 1, 'Repellat voluptatem porro possimus voluptates. Dolorum corporis et optio dolorum. Tempora velit et sit veniam quidem iure. Nemo doloribus eaque velit quas quas. Delectus vel et omnis odit alias a.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(5, 'WO-2024-0203', 5, 8, 3, 'CONT/3386/2024', 'open', '2026-03-15', NULL, 1, 'Fuga molestias amet dolorem impedit consequatur dolorem voluptatem nesciunt. Neque aliquid rerum nihil debitis. Et tenetur fuga minima totam nihil voluptatibus ea explicabo. Eum voluptatem laboriosam quasi rerum.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(6, 'WO-2024-2514', 1, 7, 3, 'CONT/8822/2024', 'open', '2025-09-02', NULL, 1, 'Est aut omnis ut. Nobis et reprehenderit voluptas quae. Occaecati velit est et molestias non voluptatem.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(7, 'WO-2024-5214', 3, 7, 3, 'CONT/2769/2024', 'suspended', '2025-10-31', NULL, 1, 'Mollitia qui laudantium voluptatem. Occaecati facere dolores iusto. Et iste magnam qui amet sequi molestias. Quod accusamus aut consequuntur perferendis.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(8, 'WO-2024-1241', 2, 3, 5, 'CONT/5992/2024', 'open', '2025-05-30', NULL, 1, 'Et iure nihil eius praesentium autem. Dolorem cumque reprehenderit enim in labore veritatis accusamus. Omnis dolorem ut similique et autem adipisci.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(9, 'WO-2024-7780', 1, 6, 3, 'CONT/0388/2024', 'closed', '2025-10-06', NULL, 1, 'Omnis facilis accusamus unde natus quia. Reprehenderit ut adipisci hic aspernatur ipsa. Animi at molestias impedit expedita ea. Quia eligendi voluptatibus rerum aliquid et.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(10, 'WO-2024-3522', 1, 5, 1, 'CONT/2623/2024', 'open', '2026-03-13', NULL, 1, 'Tenetur ut quas veniam soluta. Tempore et dolorum nulla dicta modi. Vel animi soluta ab nostrum ut accusamus voluptate debitis.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(11, 'WO-2024-4544', 5, 3, 2, 'CONT/6863/2024', 'suspended', '2025-12-05', NULL, 1, 'Sunt qui totam occaecati eius delectus. Tenetur dolores impedit eveniet ipsam. Ipsa veniam et quasi incidunt nemo est nam.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(12, 'WO-2024-4268', 2, 5, 3, 'CONT/3894/2024', 'open', '2025-05-08', NULL, 1, 'Corrupti libero aliquid quo cum necessitatibus. Maxime quaerat quisquam sequi rerum.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(13, 'WO-2024-8392', 4, 3, 3, 'CONT/2408/2024', 'suspended', '2025-08-27', NULL, 1, 'Odio eius nisi qui fugit corporis. Omnis nisi molestiae atque. Cumque voluptates officiis aut odio quasi at dolor.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(14, 'WO-2024-6251', 1, 1, 2, 'CONT/9115/2024', 'closed', '2025-07-27', NULL, 1, 'Laboriosam corporis ut quia animi aut rem nobis. Officia earum quo veritatis atque aperiam distinctio. Natus et iure et dolorem ex debitis id.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL),
(15, 'WO-2024-6205', 3, 7, 6, 'CONT/4680/2024', 'closed', '2025-07-11', NULL, 1, 'Dolor iusto provident ab enim omnis ut. Voluptas perferendis hic odio in. Et veritatis labore perferendis ex. Et incidunt ut enim molestias laboriosam aut similique.', '2026-04-26 20:44:20', '2026-04-26 20:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_order_stocks`
--

CREATE TABLE `work_order_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty_received` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_issued` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_disposed` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_returned` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_transfer_out` decimal(12,3) NOT NULL DEFAULT 0.000,
  `qty_transfer_in` decimal(12,3) NOT NULL DEFAULT 0.000,
  `balance` decimal(12,3) NOT NULL DEFAULT 0.000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_stocks`
--

INSERT INTO `work_order_stocks` (`id`, `work_order_id`, `item_id`, `warehouse_id`, `qty_received`, `qty_issued`, `qty_disposed`, `qty_returned`, `qty_transfer_out`, `qty_transfer_in`, `balance`, `created_at`, `updated_at`) VALUES
(1, 5, 7, NULL, 100.000, 0.000, 100.000, 100.000, 200.000, 200.000, 0.000, '2026-04-26 20:58:45', '2026-04-26 20:58:45'),
(2, 5, 18, 1, 100.000, 0.000, 0.000, 0.000, 0.000, 0.000, 100.000, '2026-04-27 08:40:02', '2026-04-27 08:40:02'),
(3, 5, 11, 1, 100.000, 2.000, 10.000, 0.000, 20.000, 0.000, 68.000, '2026-04-27 08:40:02', '2026-04-27 09:54:02'),
(4, 8, 11, 1, 0.000, 0.000, 0.000, 0.000, 0.000, 20.000, 20.000, '2026-04-27 09:54:02', '2026-04-27 09:54:02'),
(5, 1, 1, 1, 200.000, 0.000, 0.000, 0.000, 0.000, 0.000, 200.000, '2026-04-27 10:15:53', '2026-04-27 10:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_transfers`
--

CREATE TABLE `work_order_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfer_number` varchar(255) NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_work_order_id` bigint(20) UNSIGNED NOT NULL,
  `to_work_order_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_date` date NOT NULL,
  `status` enum('draft','approved') NOT NULL DEFAULT 'draft',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_transfers`
--

INSERT INTO `work_order_transfers` (`id`, `transfer_number`, `warehouse_id`, `from_work_order_id`, `to_work_order_id`, `transfer_date`, `status`, `approved_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, '١', 1, 5, 8, '2026-04-27', 'approved', NULL, NULL, '2026-04-27 09:32:05', '2026-04-27 09:32:05'),
(2, '3', 1, 5, 8, '2026-04-27', 'approved', NULL, NULL, '2026-04-27 09:46:26', '2026-04-27 09:46:26'),
(3, '4', 1, 5, 8, '2026-04-27', 'approved', NULL, NULL, '2026-04-27 09:53:57', '2026-04-27 09:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `work_order_transfer_items`
--

CREATE TABLE `work_order_transfer_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_order_transfer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `qty_transferred` decimal(12,3) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_order_transfer_items`
--

INSERT INTO `work_order_transfer_items` (`id`, `work_order_transfer_id`, `item_id`, `qty_transferred`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 11, 20.000, NULL, '2026-04-27 09:53:57', '2026-04-27 09:53:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD KEY `categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractors_created_by_foreign` (`created_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gate_passes`
--
ALTER TABLE `gate_passes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gate_passes_gp_number_unique` (`gp_number`),
  ADD KEY `gate_passes_work_order_id_foreign` (`work_order_id`),
  ADD KEY `gate_passes_prepared_by_foreign` (`prepared_by`),
  ADD KEY `gate_passes_warehouse_keeper_id_foreign` (`warehouse_keeper_id`),
  ADD KEY `gate_passes_engineer_id_foreign` (`engineer_id`),
  ADD KEY `gate_passes_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `gate_pass_items`
--
ALTER TABLE `gate_pass_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gate_pass_items_gate_pass_id_foreign` (`gate_pass_id`),
  ADD KEY `gate_pass_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_item_code_unique` (`item_code`),
  ADD KEY `items_category_id_foreign` (`category_id`),
  ADD KEY `items_created_by_foreign` (`created_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_disposal_requests`
--
ALTER TABLE `material_disposal_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_disposal_requests_mdr_number_unique` (`mdr_number`),
  ADD KEY `material_disposal_requests_work_order_id_foreign` (`work_order_id`),
  ADD KEY `material_disposal_requests_prepared_by_foreign` (`prepared_by`),
  ADD KEY `material_disposal_requests_approved_by_foreign` (`approved_by`),
  ADD KEY `material_disposal_requests_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `material_receipt_notes`
--
ALTER TABLE `material_receipt_notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_receipt_notes_mrn_number_unique` (`mrn_number`),
  ADD KEY `material_receipt_notes_work_order_id_foreign` (`work_order_id`),
  ADD KEY `material_receipt_notes_supplier_id_foreign` (`supplier_id`),
  ADD KEY `material_receipt_notes_prepared_by_foreign` (`prepared_by`),
  ADD KEY `material_receipt_notes_warehouse_keeper_id_foreign` (`warehouse_keeper_id`),
  ADD KEY `material_receipt_notes_approved_by_foreign` (`approved_by`),
  ADD KEY `material_receipt_notes_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `material_return_requests`
--
ALTER TABLE `material_return_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material_return_requests_mrr_number_unique` (`mrr_number`),
  ADD KEY `material_return_requests_work_order_id_foreign` (`work_order_id`),
  ADD KEY `material_return_requests_prepared_by_foreign` (`prepared_by`),
  ADD KEY `material_return_requests_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `material_return_requests_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `mdr_items`
--
ALTER TABLE `mdr_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdr_items_mdr_id_foreign` (`mdr_id`),
  ADD KEY `mdr_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mrn_items`
--
ALTER TABLE `mrn_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mrn_items_mrn_id_foreign` (`mrn_id`),
  ADD KEY `mrn_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `mrr_items`
--
ALTER TABLE `mrr_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mrr_items_mrr_id_foreign` (`mrr_id`),
  ADD KEY `mrr_items_item_id_foreign` (`item_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_code_unique` (`code`),
  ADD KEY `projects_created_by_foreign` (`created_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sites_project_id_foreign` (`project_id`),
  ADD KEY `sites_created_by_foreign` (`created_by`);

--
-- Indexes for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_ledgers_item_id_foreign` (`item_id`),
  ADD KEY `stock_ledgers_created_by_foreign` (`created_by`),
  ADD KEY `stock_ledgers_work_order_id_item_id_index` (`work_order_id`,`item_id`),
  ADD KEY `stock_ledgers_transaction_type_index` (`transaction_type`),
  ADD KEY `stock_ledgers_warehouse_id_foreign` (`warehouse_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouses_code_unique` (`code`);

--
-- Indexes for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_orders_wo_number_unique` (`wo_number`),
  ADD KEY `work_orders_project_id_foreign` (`project_id`),
  ADD KEY `work_orders_site_id_foreign` (`site_id`),
  ADD KEY `work_orders_contractor_id_foreign` (`contractor_id`),
  ADD KEY `work_orders_created_by_foreign` (`created_by`);

--
-- Indexes for table `work_order_stocks`
--
ALTER TABLE `work_order_stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_order_stocks_work_order_id_item_id_warehouse_id_unique` (`work_order_id`,`item_id`,`warehouse_id`),
  ADD KEY `work_order_stocks_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `work_order_stocks_item_id_foreign` (`item_id`);

--
-- Indexes for table `work_order_transfers`
--
ALTER TABLE `work_order_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_order_transfers_transfer_number_unique` (`transfer_number`),
  ADD KEY `work_order_transfers_from_work_order_id_foreign` (`from_work_order_id`),
  ADD KEY `work_order_transfers_to_work_order_id_foreign` (`to_work_order_id`),
  ADD KEY `work_order_transfers_approved_by_foreign` (`approved_by`),
  ADD KEY `work_order_transfers_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `work_order_transfer_items`
--
ALTER TABLE `work_order_transfer_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_transfer_items_work_order_transfer_id_foreign` (`work_order_transfer_id`),
  ADD KEY `work_order_transfer_items_item_id_foreign` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gate_passes`
--
ALTER TABLE `gate_passes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gate_pass_items`
--
ALTER TABLE `gate_pass_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_disposal_requests`
--
ALTER TABLE `material_disposal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `material_receipt_notes`
--
ALTER TABLE `material_receipt_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_return_requests`
--
ALTER TABLE `material_return_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mdr_items`
--
ALTER TABLE `mdr_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `mrn_items`
--
ALTER TABLE `mrn_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mrr_items`
--
ALTER TABLE `mrr_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `work_order_stocks`
--
ALTER TABLE `work_order_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `work_order_transfers`
--
ALTER TABLE `work_order_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_order_transfer_items`
--
ALTER TABLE `work_order_transfer_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contractors`
--
ALTER TABLE `contractors`
  ADD CONSTRAINT `contractors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gate_passes`
--
ALTER TABLE `gate_passes`
  ADD CONSTRAINT `gate_passes_engineer_id_foreign` FOREIGN KEY (`engineer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gate_passes_prepared_by_foreign` FOREIGN KEY (`prepared_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `gate_passes_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `gate_passes_warehouse_keeper_id_foreign` FOREIGN KEY (`warehouse_keeper_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gate_passes_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`);

--
-- Constraints for table `gate_pass_items`
--
ALTER TABLE `gate_pass_items`
  ADD CONSTRAINT `gate_pass_items_gate_pass_id_foreign` FOREIGN KEY (`gate_pass_id`) REFERENCES `gate_passes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gate_pass_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `material_disposal_requests`
--
ALTER TABLE `material_disposal_requests`
  ADD CONSTRAINT `material_disposal_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_disposal_requests_prepared_by_foreign` FOREIGN KEY (`prepared_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_disposal_requests_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `material_disposal_requests_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`);

--
-- Constraints for table `material_receipt_notes`
--
ALTER TABLE `material_receipt_notes`
  ADD CONSTRAINT `material_receipt_notes_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_receipt_notes_prepared_by_foreign` FOREIGN KEY (`prepared_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_receipt_notes_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_receipt_notes_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `material_receipt_notes_warehouse_keeper_id_foreign` FOREIGN KEY (`warehouse_keeper_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_receipt_notes_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`);

--
-- Constraints for table `material_return_requests`
--
ALTER TABLE `material_return_requests`
  ADD CONSTRAINT `material_return_requests_prepared_by_foreign` FOREIGN KEY (`prepared_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `material_return_requests_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_return_requests_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `material_return_requests_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`);

--
-- Constraints for table `mdr_items`
--
ALTER TABLE `mdr_items`
  ADD CONSTRAINT `mdr_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `mdr_items_mdr_id_foreign` FOREIGN KEY (`mdr_id`) REFERENCES `material_disposal_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mrn_items`
--
ALTER TABLE `mrn_items`
  ADD CONSTRAINT `mrn_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `mrn_items_mrn_id_foreign` FOREIGN KEY (`mrn_id`) REFERENCES `material_receipt_notes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mrr_items`
--
ALTER TABLE `mrr_items`
  ADD CONSTRAINT `mrr_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `mrr_items_mrr_id_foreign` FOREIGN KEY (`mrr_id`) REFERENCES `material_return_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sites_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD CONSTRAINT `stock_ledgers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `stock_ledgers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `stock_ledgers_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `stock_ledgers_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`);

--
-- Constraints for table `work_orders`
--
ALTER TABLE `work_orders`
  ADD CONSTRAINT `work_orders_contractor_id_foreign` FOREIGN KEY (`contractor_id`) REFERENCES `contractors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `work_orders_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `work_orders_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `work_order_stocks`
--
ALTER TABLE `work_order_stocks`
  ADD CONSTRAINT `work_order_stocks_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `work_order_stocks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `work_order_stocks_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_order_transfers`
--
ALTER TABLE `work_order_transfers`
  ADD CONSTRAINT `work_order_transfers_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_order_transfers_from_work_order_id_foreign` FOREIGN KEY (`from_work_order_id`) REFERENCES `work_orders` (`id`),
  ADD CONSTRAINT `work_order_transfers_to_work_order_id_foreign` FOREIGN KEY (`to_work_order_id`) REFERENCES `work_orders` (`id`),
  ADD CONSTRAINT `work_order_transfers_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `work_order_transfer_items`
--
ALTER TABLE `work_order_transfer_items`
  ADD CONSTRAINT `work_order_transfer_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `work_order_transfer_items_work_order_transfer_id_foreign` FOREIGN KEY (`work_order_transfer_id`) REFERENCES `work_order_transfers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
