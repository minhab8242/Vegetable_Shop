-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 07:06 PM
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
-- Database: `vegetable_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(5, 3, NULL, 2, '2025-10-21 19:43:41', '2025-10-22 07:55:16'),
(6, 3, 15, 1, '2025-10-22 07:55:22', '2025-10-22 07:55:22'),
(7, 3, 16, 2, '2025-10-22 07:55:25', '2025-10-22 07:55:27'),
(8, 3, 18, 1, '2025-10-22 07:59:51', '2025-10-22 07:59:51'),
(9, 3, 19, 1, '2025-10-22 07:59:51', '2025-10-22 07:59:51'),
(10, 3, 20, 1, '2025-10-22 07:59:52', '2025-10-22 07:59:52'),
(11, 3, 22, 1, '2025-10-22 07:59:53', '2025-10-22 07:59:53'),
(12, 3, 23, 1, '2025-10-22 07:59:55', '2025-10-22 07:59:55'),
(17, 3, 27, 2, '2025-10-22 13:56:40', '2025-10-22 13:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Rau xanh', 'Các loại rau xanh tươi ngon, giàu dinh dưỡng', '2025-10-21 14:38:11', '2025-10-21 14:38:11'),
(2, 'Củ quả', 'Các loại củ quả đa dạng, tươi ngon', '2025-10-21 14:38:11', '2025-10-21 14:38:11'),
(3, 'Trái cây', 'Trái cây tươi ngon, giàu vitamin', '2025-10-21 14:38:11', '2025-10-21 14:38:11'),
(4, 'Gia vị', 'Các loại gia vị tự nhiên cho món ăn thêm ngon', '2025-10-21 14:38:11', '2025-10-21 14:38:11'),
(5, 'Rau thơm', 'Các loại rau thơm tươi ngon cho món ăn', '2025-10-21 14:38:11', '2025-10-21 14:38:11'),
(6, 'ư3', '234', '2025-10-22 14:15:39', '2025-10-22 14:15:39'),
(7, '123', '123', '2025-10-22 14:15:50', '2025-10-22 14:15:50');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
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
(4, '2025_10_21_061256_create_categories_table', 1),
(5, '2025_10_21_061313_create_products_table', 1),
(6, '2025_10_21_061316_create_carts_table', 1),
(7, '2025_10_21_061319_create_orders_table', 1),
(8, '2025_10_21_061322_create_order_details_table', 1),
(9, '2025_10_21_214239_add_sales_count_to_products_table', 2),
(10, '2025_10_21_215833_create_reviews_table', 3),
(12, '2025_10_22_015701_remove_remember_token_from_users_table', 4),
(13, '2025_10_22_202413_add_cost_price_to_products_table', 4),
(14, '2025_10_22_235802_update_order_details_foreign_key_constraints', 5),
(15, '2025_10_23_000541_update_carts_foreign_key_constraints', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 0.00, 'completed', '2025-10-21 15:33:53', '2025-10-21 15:33:53'),
(2, 2, 0.00, 'completed', '2025-10-21 15:34:06', '2025-10-21 15:34:06'),
(3, 2, 45000.00, 'completed', '2025-10-21 15:34:17', '2025-10-21 15:34:17'),
(4, 2, 237000.00, 'completed', '2025-10-21 15:34:17', '2025-10-21 15:34:17'),
(5, 3, 230000.00, 'completed', '2025-10-21 15:34:17', '2025-10-21 15:34:17'),
(6, 3, 122000.00, 'completed', '2025-10-21 15:34:17', '2025-10-21 15:34:17'),
(7, 3, 74000.00, 'pending', '2025-10-22 08:38:36', '2025-10-22 08:38:36'),
(8, 3, 22000.00, 'completed', '2025-10-22 08:47:35', '2025-10-22 14:47:05'),
(9, 3, 1000000.00, 'completed', '2025-10-22 14:58:27', '2025-10-22 14:59:55'),
(12, 2, 150000.00, 'pending', '2025-10-22 17:05:37', '2025-10-22 17:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `product_description`, `price`, `quantity`) VALUES
(1, 3, NULL, 'Rau cải xanh', 'Rau cải xanh tươi ngon, giàu vitamin', 20000.00, 1),
(2, 3, NULL, 'Rau bó xôi', 'Rau bó xôi tươi ngon, giàu sắt và folate. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau bó xôi có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món xào, luộc hoặc nấu canh.', 25000.00, 1),
(3, 4, 5, 'Khoai tây', 'Khoai tây tươi ngon, giàu tinh bột', 22000.00, 1),
(4, 4, 8, 'Chuối', 'Chuối tươi ngon, giàu kali', 25000.00, 2),
(5, 4, 9, 'Táo', 'Táo tươi ngon, giàu chất xơ', 60000.00, 1),
(6, 4, 23, 'Ớt chuông', 'Ớt chuông tươi ngon, giàu vitamin C và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Ớt chuông có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nướng hoặc salad.', 35000.00, 3),
(7, 5, 6, 'Cà chua', 'Cà chua tươi ngon, giàu lycopene', 30000.00, 2),
(8, 5, 11, 'Hành tây', 'Hành tây tươi ngon, giàu flavonoid', 28000.00, 3),
(9, 5, NULL, 'Rau bó xôi', 'Rau bó xôi tươi ngon, giàu sắt và folate. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau bó xôi có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món xào, luộc hoặc nấu canh.', 25000.00, 2),
(10, 5, 19, 'Khoai tây', 'Khoai tây tươi ngon, giàu tinh bột và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Khoai tây có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món chiên, luộc hoặc nấu canh.', 18000.00, 2),
(11, 6, NULL, 'Rau bó xôi', 'Rau bó xôi tươi ngon, giàu sắt', 25000.00, 2),
(12, 6, 5, 'Khoai tây', 'Khoai tây tươi ngon, giàu tinh bột', 22000.00, 1),
(13, 6, 20, 'Cà chua', 'Cà chua tươi ngon, giàu lycopene và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Cà chua có vị ngọt tự nhiên, mọng nước, thích hợp cho các món salad, nấu canh hoặc làm nước sốt.', 25000.00, 2),
(14, 7, 24, 'Hành tây', 'Hành tây tươi ngon, giàu chất chống oxy hóa và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Hành tây có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nấu canh hoặc salad.', 22000.00, 2),
(15, 7, 6, 'Cà chua', 'Cà chua tươi ngon, giàu lycopene', 30000.00, 1),
(16, 8, 26, 'Húng quế', 'Húng quế tươi ngon, giàu vitamin A và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Húng quế có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.', 12000.00, 1),
(17, 8, 25, 'Rau mùi', 'Rau mùi tươi ngon, giàu vitamin K và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau mùi có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.', 10000.00, 1),
(18, 9, 28, 'thịnh', NULL, 1000000.00, 1),
(21, 12, NULL, 'Cà rốt', 'Cà rốt tươi ngon, giàu beta-carotene', 18000.00, 2);

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL COMMENT 'Giá nhập hàng',
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `sales_count` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `review_count` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `cost_price`, `stock_quantity`, `sales_count`, `rating`, `review_count`, `image_url`, `created_at`, `updated_at`) VALUES
(5, 2, 'Khoai tây', 'Khoai tây tươi ngon, giàu tinh bột', 22000.00, NULL, 60, 0, 2.50, 2, '/images/khoai-tay.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(6, 2, 'Cà chua', 'Cà chua tươi ngon, giàu lycopene', 30000.00, NULL, 35, 0, 3.50, 2, '/images/ca-chua.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(7, 3, 'Cam', 'Cam tươi ngon, giàu vitamin C', 45000.00, NULL, 20, 0, 2.00, 2, '/images/cam.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(8, 3, 'Chuối', 'Chuối tươi ngon, giàu kali', 25000.00, NULL, 50, 0, 4.00, 2, '/images/chuoi.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(9, 3, 'Táo', 'Táo tươi ngon, giàu chất xơ', 60000.00, NULL, 15, 0, 4.50, 2, '/images/tao.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(10, 4, 'Tỏi', 'Tỏi tươi ngon, có tính kháng khuẩn', 35000.00, NULL, 30, 0, 4.50, 2, '/images/toi.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(11, 4, 'Hành tây', 'Hành tây tươi ngon, giàu flavonoid', 28000.00, NULL, 25, 0, 4.50, 2, '/images/hanh-tay.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(12, 5, 'Rau mùi', 'Rau mùi tươi ngon, thơm ngát', 12000.00, NULL, 40, 0, 4.00, 2, '/images/rau-mui.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(13, 5, 'Húng quế', 'Húng quế tươi ngon, thơm đặc trưng', 15000.00, NULL, 35, 0, 4.50, 2, '/images/hung-que.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(14, 5, 'Rau thơm', 'Rau thơm tươi ngon, thơm ngát', 10000.00, NULL, 45, 0, 4.50, 2, '/images/rau-thom.jpg', '2025-10-21 14:38:11', '2025-10-21 15:02:47'),
(15, 1, 'Rau muống', 'Rau muống tươi ngon, giàu chất xơ và vitamin. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau muống có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.', 15000.00, NULL, 50, 1250, 5.00, 2, 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(16, 1, 'Rau cải xanh', 'Rau cải xanh tươi ngon, giàu vitamin A, C và K. Được trồng trong nhà kính, đảm bảo chất lượng và độ tươi. Rau cải xanh có vị ngọt nhẹ, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.', 20000.00, NULL, 30, 890, 4.50, 2, 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(18, 2, 'Cà rốt', 'Cà rốt tươi ngon, giàu beta-carotene và vitamin A. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Cà rốt có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.', 20000.00, NULL, 40, 2100, 4.00, 2, 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(19, 2, 'Khoai tây', 'Khoai tây tươi ngon, giàu tinh bột và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Khoai tây có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món chiên, luộc hoặc nấu canh.', 18000.00, NULL, 60, 1800, 3.50, 2, 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(20, 2, 'Cà chua', 'Cà chua tươi ngon, giàu lycopene và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Cà chua có vị ngọt tự nhiên, mọng nước, thích hợp cho các món salad, nấu canh hoặc làm nước sốt.', 25000.00, NULL, 35, 3200, 3.50, 2, 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(21, 3, 'Táo', 'Táo tươi ngon, giàu vitamin C và chất xơ. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Táo có vị ngọt tự nhiên, giòn ngon, thích hợp để ăn trực tiếp hoặc làm nước ép.', 45000.00, NULL, 20, 980, 2.50, 2, 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(22, 3, 'Chuối', 'Chuối tươi ngon, giàu kali và vitamin B6. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Chuối có vị ngọt tự nhiên, mềm ngon, thích hợp để ăn trực tiếp hoặc làm sinh tố.', 30000.00, NULL, 45, 1500, 4.00, 2, 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(23, 4, 'Ớt chuông', 'Ớt chuông tươi ngon, giàu vitamin C và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Ớt chuông có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nướng hoặc salad.', 35000.00, NULL, 25, 750, 5.00, 2, 'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(24, 4, 'Hành tây', 'Hành tây tươi ngon, giàu chất chống oxy hóa và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Hành tây có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nấu canh hoặc salad.', 22000.00, NULL, 40, 1100, 3.50, 2, 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(25, 5, 'Rau mùi', 'Rau mùi tươi ngon, giàu vitamin K và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau mùi có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.', 10000.00, NULL, 30, 450, 4.50, 2, 'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(26, 5, 'Húng quế', 'Húng quế tươi ngon, giàu vitamin A và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Húng quế có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.', 12000.00, NULL, 25, 380, 3.50, 2, 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', '2025-10-21 14:47:39', '2025-10-21 15:02:47'),
(27, 2, 'Rau húng chó', 'loại râu rất ngon và tươi 123123123', 10000.00, 1000000.00, 100, 0, 0.00, 0, 'products/1761141135_lgtZ4tQsWt.jpg', '2025-10-22 13:52:15', '2025-10-22 14:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `is_helpful` tinyint(1) NOT NULL DEFAULT 0,
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `title`, `is_verified_purchase`, `is_helpful`, `helpful_count`, `images`, `created_at`, `updated_at`) VALUES
(10, 3, 5, 3, 'Chất lượng ổn, không có gì đặc biệt.', 'Bình thường', 0, 0, 3, NULL, '2025-09-21 15:02:47', '2025-10-21 15:02:47'),
(11, 2, 5, 2, 'Sản phẩm không tươi như quảng cáo.', 'Không như mong đợi', 0, 0, 1, NULL, '2025-09-29 15:02:47', '2025-10-21 15:02:47'),
(12, 3, 6, 4, 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.', 'Khá hài lòng', 1, 0, 8, NULL, '2025-09-27 15:02:47', '2025-10-21 15:02:47'),
(13, 2, 6, 3, 'Chất lượng bình thường, không có gì nổi bật.', 'Ổn', 0, 0, 2, NULL, '2025-09-28 15:02:47', '2025-10-21 15:02:47'),
(14, 3, 7, 2, 'Sản phẩm không tươi như quảng cáo.', 'Không như mong đợi', 0, 0, 1, NULL, '2025-09-26 15:02:47', '2025-10-21 15:02:47'),
(15, 2, 7, 2, 'Sản phẩm không tươi như quảng cáo.', 'Không như mong đợi', 0, 0, 1, NULL, '2025-09-28 15:02:47', '2025-10-21 15:02:47'),
(16, 3, 8, 5, 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.', 'Sản phẩm tuyệt vời!', 1, 0, 12, NULL, '2025-10-06 15:02:47', '2025-10-21 15:02:47'),
(17, 2, 8, 3, 'Chất lượng ổn, không có gì đặc biệt.', 'Bình thường', 0, 0, 3, NULL, '2025-10-20 15:02:47', '2025-10-21 15:02:47'),
(18, 3, 9, 5, 'Rất tươi ngon, đóng gói cẩn thận. Khuyến nghị mọi người nên thử.', 'Xuất sắc!', 1, 0, 15, NULL, '2025-10-14 15:02:47', '2025-10-21 15:02:47'),
(19, 2, 9, 4, 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.', 'Khá hài lòng', 1, 0, 8, NULL, '2025-10-03 15:02:47', '2025-10-21 15:02:47'),
(20, 3, 10, 4, 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.', 'Khá hài lòng', 1, 0, 8, NULL, '2025-10-15 15:02:47', '2025-10-21 15:02:47'),
(21, 2, 10, 5, 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.', 'Hoàn hảo!', 1, 0, 20, NULL, '2025-10-17 15:02:47', '2025-10-21 15:02:47'),
(22, 3, 11, 4, 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.', 'Tốt', 1, 0, 6, NULL, '2025-09-22 15:02:47', '2025-10-21 15:02:47'),
(23, 2, 11, 5, 'Rất tươi ngon, đóng gói đẹp. Cảm ơn shop!', 'Tuyệt vời!', 1, 0, 18, NULL, '2025-10-05 15:02:47', '2025-10-21 15:02:47'),
(24, 2, 12, 4, 'Chất lượng tốt, giá cả phải chăng.', 'Hài lòng', 1, 0, 7, NULL, '2025-10-07 15:02:47', '2025-10-21 15:02:47'),
(25, 3, 12, 4, 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.', 'Tốt', 1, 0, 6, NULL, '2025-09-29 15:02:47', '2025-10-21 15:02:47'),
(26, 2, 13, 5, 'Rất tươi ngon, đóng gói cẩn thận. Khuyến nghị mọi người nên thử.', 'Xuất sắc!', 1, 0, 15, NULL, '2025-10-03 15:02:47', '2025-10-21 15:02:47'),
(27, 3, 13, 4, 'Chất lượng tốt, giá cả phải chăng.', 'Hài lòng', 1, 0, 7, NULL, '2025-10-16 15:02:47', '2025-10-21 15:02:47'),
(28, 2, 14, 4, 'Chất lượng tốt, giá cả phải chăng.', 'Hài lòng', 1, 0, 7, NULL, '2025-09-24 15:02:47', '2025-10-21 15:02:47'),
(29, 3, 14, 5, 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.', 'Hoàn hảo!', 1, 0, 20, NULL, '2025-10-11 15:02:47', '2025-10-21 15:02:47'),
(30, 3, 15, 5, 'Rất tươi ngon, đóng gói đẹp. Cảm ơn shop!', 'Tuyệt vời!', 1, 1, 17, NULL, '2025-10-08 15:02:47', '2025-10-22 10:02:22'),
(31, 2, 15, 5, 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.', 'Hoàn hảo!', 1, 1, 21, NULL, '2025-09-26 15:02:47', '2025-10-22 10:02:12'),
(32, 2, 16, 4, 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.', 'Khá hài lòng', 1, 0, 8, NULL, '2025-10-01 15:02:47', '2025-10-21 15:02:47'),
(33, 3, 16, 5, 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.', 'Hoàn hảo!', 1, 0, 20, NULL, '2025-09-24 15:02:47', '2025-10-21 15:02:47'),
(36, 2, 18, 5, 'Rất tươi ngon, đóng gói đẹp. Cảm ơn shop!', 'Tuyệt vời!', 1, 0, 18, NULL, '2025-10-20 15:02:47', '2025-10-21 15:02:47'),
(37, 3, 18, 3, 'Chất lượng bình thường, không có gì nổi bật.', 'Ổn', 0, 0, 2, NULL, '2025-09-25 15:02:47', '2025-10-21 15:02:47'),
(38, 2, 19, 4, 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.', 'Khá hài lòng', 1, 0, 8, NULL, '2025-10-13 15:02:47', '2025-10-21 15:02:47'),
(39, 3, 19, 3, 'Chất lượng bình thường, không có gì nổi bật.', 'Ổn', 0, 0, 2, NULL, '2025-10-11 15:02:47', '2025-10-21 15:02:47'),
(40, 2, 20, 4, 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.', 'Tốt', 1, 0, 6, NULL, '2025-10-05 15:02:47', '2025-10-21 15:02:47'),
(41, 3, 20, 3, 'Chất lượng bình thường, không có gì nổi bật.', 'Ổn', 0, 0, 2, NULL, '2025-09-29 15:02:47', '2025-10-21 15:02:47'),
(42, 2, 21, 2, 'Sản phẩm không tươi như quảng cáo.', 'Không như mong đợi', 0, 0, 1, NULL, '2025-09-30 15:02:47', '2025-10-21 15:02:47'),
(43, 3, 21, 3, 'Chất lượng ổn, không có gì đặc biệt.', 'Bình thường', 0, 0, 3, NULL, '2025-10-14 15:02:47', '2025-10-21 15:02:47'),
(44, 2, 22, 3, 'Chất lượng ổn, không có gì đặc biệt.', 'Bình thường', 0, 0, 3, NULL, '2025-10-02 15:02:47', '2025-10-21 15:02:47'),
(45, 3, 22, 5, 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.', 'Sản phẩm tuyệt vời!', 1, 0, 12, NULL, '2025-09-22 15:02:47', '2025-10-21 15:02:47'),
(46, 2, 23, 5, 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.', 'Sản phẩm tuyệt vời!', 1, 0, 12, NULL, '2025-09-26 15:02:47', '2025-10-21 15:02:47'),
(47, 3, 23, 5, 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.', 'Sản phẩm tuyệt vời!', 1, 0, 12, NULL, '2025-10-20 15:02:47', '2025-10-21 15:02:47'),
(48, 3, 24, 2, 'Sản phẩm không tươi như quảng cáo.', 'Không như mong đợi', 0, 0, 1, NULL, '2025-10-07 15:02:47', '2025-10-21 15:02:47'),
(49, 2, 24, 5, 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.', 'Hoàn hảo!', 1, 0, 20, NULL, '2025-09-25 15:02:47', '2025-10-21 15:02:47'),
(50, 3, 25, 5, 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.', 'Sản phẩm tuyệt vời!', 1, 0, 12, NULL, '2025-09-29 15:02:47', '2025-10-21 15:02:47'),
(51, 2, 25, 4, 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.', 'Tốt', 1, 0, 6, NULL, '2025-09-27 15:02:47', '2025-10-21 15:02:47'),
(52, 2, 26, 3, 'Chất lượng bình thường, không có gì nổi bật.', 'Ổn', 0, 0, 2, NULL, '2025-10-20 15:02:47', '2025-10-21 15:02:47'),
(53, 3, 26, 4, 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.', 'Tốt', 1, 0, 6, NULL, '2025-10-13 15:02:47', '2025-10-21 15:02:47');

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
('hc21i4xbfaO3IfQ1nPmyvS4zgOXz9AmDA76IrRnC', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2lqRUZTNk90blFVNHo2WUxVWmNJMThjelBMa2tjMjh1b0pxNWxkdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9kdWN0cy8xNyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1761152791);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Test User', 'user@example.com', '2025-10-21 14:38:14', '$2y$12$tGikXWnEn5uN0q2ZHyD36ega5EPbAriv3nsOLyxSeE8aUEqvTX9y6', '+1-351-817-2067', '135 Walter Harbors\nHamillmouth, TX 00786-6499', 'user', '2025-10-21 14:38:14', '2025-10-21 14:38:14'),
(3, 'TRAN DUC THINH', 'thinhtran383.au@gmail.com', '2025-10-21 14:40:36', '$2y$12$pGBwIRKCgtpDeagYJP/IP...NPdE5emWSIFbLWIp7GWa7smc5vGq6', '+84947445420', 'Hà NaMm', 'admin', '2025-10-21 14:40:17', '2025-10-22 09:05:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `reviews_product_id_rating_index` (`product_id`,`rating`),
  ADD KEY `reviews_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
