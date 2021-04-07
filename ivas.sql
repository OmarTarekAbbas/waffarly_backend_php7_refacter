-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2021 at 04:19 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ivas`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `image`, `created_at`, `updated_at`, `parent_id`) VALUES
(1, 'Aflam', '1550152145324.jpg', '2019-02-14 11:49:05', '2019-02-14 11:49:05', NULL),
(2, 'Music', '1552552611379.jpg', '2019-02-14 12:35:00', '2019-03-14 06:36:51', NULL),
(3, 'Arabic', '1552552637642.jpg', '2019-03-06 07:01:44', '2019-03-14 06:37:17', 1),
(5, 'English', '1552552649795.jpg', '2019-03-14 06:37:29', '2019-03-14 06:37:29', 1),
(6, 'Arabic Music', '1552552673699.jpg', '2019-03-14 06:37:53', '2019-03-14 06:47:32', 2),
(7, 'English Music', '1552552689643.jpg', '2019-03-14 06:38:09', '2019-03-14 06:47:47', 2),
(8, 'Amr Diab', '1552552713880.jpg', '2019-03-14 06:38:33', '2019-03-14 06:38:33', 6),
(9, 'Tamer Ashour', '155255273259.jpg', '2019-03-14 06:38:52', '2019-03-14 06:38:52', 6),
(10, 'Action', '1552552922566.jpg', '2019-03-14 06:42:02', '2019-03-14 06:42:02', 3),
(11, 'Romantic', '1552552933190.jpg', '2019-03-14 06:42:13', '2019-03-14 06:42:13', 3),
(12, 'selena gomez', '155255298255.jpg', '2019-03-14 06:43:02', '2019-03-14 06:43:02', 7),
(14, 'Adele Lyrics', '1552553075139.jpg', '2019-03-14 06:44:35', '2019-03-14 06:44:35', 7),
(15, 'Horror', '1552553097809.jpg', '2019-03-14 06:44:57', '2019-03-14 06:44:57', 5),
(16, 'Scientific', '1552553141894.jpg', '2019-03-14 06:45:41', '2019-03-14 06:45:41', 5),
(19, 'test2', NULL, '2020-11-05 07:01:25', '2020-11-05 07:01:25', NULL),
(20, '4344', '1606919379395.png', '2020-12-02 12:29:39', '2020-12-02 12:29:39', NULL),
(21, 'sss', 'D:\\xampp_7_3\\tmp\\phpCFEA.tmp', '2020-12-02 12:30:26', '2020-12-02 12:30:26', NULL),
(22, 'uu', 'D:\\xampp_7_3\\tmp\\php1CD8.tmp', '2020-12-02 12:37:20', '2020-12-02 12:37:20', NULL),
(23, 'uuuuuuuuuuuuuuuu', 'D:\\xampp_7_3\\tmp\\php623F.tmp', '2020-12-02 12:37:37', '2020-12-02 12:37:37', NULL),
(24, 'sddddddd', 'uploads/category/ToCzkUhMBqgGQaxzUUnAZAzRm5MULFtlZ1U0m2M3.png', '2020-12-06 07:36:17', '2020-12-06 07:36:17', NULL),
(25, 'ooooooooo', 'uploads/category/ietErHXy2YM0xIr94yznCum9eE69RuZ0s22PZLIg.png', '2020-12-06 07:43:21', '2020-12-06 07:43:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_preview` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_type_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `patch_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `path`, `image_preview`, `content_type_id`, `category_id`, `patch_number`, `created_at`, `updated_at`) VALUES
(23, 'video 1', '1552553197895.mp4', '1552553196267.jpg', 5, 3, '12354', '2019-03-14 06:46:37', '2019-03-14 06:46:37'),
(24, 'audio 1', '155255330417.mp3', NULL, 4, 12, '1234', '2019-03-14 06:48:24', '2019-03-14 06:48:24'),
(25, 'audio 2', '1552553335747.mp3', NULL, 4, 9, '12456', '2019-03-14 06:48:55', '2019-03-14 06:48:55'),
(38, 'test2', '<p>1</p>', NULL, 1, 1, '1', '2020-11-05 07:01:25', '2020-11-05 07:01:25'),
(39, 'test3', '<p>f</p>', NULL, 1, 1, '1', '2020-11-05 07:03:27', '2020-11-05 07:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE `content_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Advanced Text', '2019-02-14 11:05:42', '2019-02-14 11:05:42'),
(2, 'Normal Text', '2019-02-14 11:06:12', '2019-02-14 11:06:12'),
(3, 'Image', '2019-02-14 11:06:27', '2019-02-14 11:06:27'),
(4, 'Audio', '2019-02-14 11:06:34', '2019-02-14 11:06:34'),
(5, 'Video', '2019-02-14 11:06:38', '2019-02-14 11:06:38'),
(6, 'external video link', '2019-03-06 06:02:01', '2019-03-06 06:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Egypt', '2019-02-11 11:12:04', '2019-02-11 11:12:04'),
(2, 'KSA', '2019-02-11 11:12:10', '2019-02-11 11:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `delete_all_flags`
--

CREATE TABLE `delete_all_flags` (
  `id` int(10) UNSIGNED NOT NULL,
  `route_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `short_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `title`, `created_at`, `updated_at`, `short_code`, `rtl`) VALUES
(1, 'arabic', '2021-01-31 11:06:02', '2021-01-31 11:06:02', 'ar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_08_01_141233_create_permission_tables', 1),
(2, '2019_04_22_161443_create_categories_table', 1),
(3, '2019_04_22_161443_create_content_types_table', 1),
(4, '2019_04_22_161443_create_contents_table', 1),
(5, '2019_04_22_161443_create_countries_table', 1),
(6, '2019_04_22_161443_create_delete_all_flags_table', 1),
(7, '2019_04_22_161443_create_languages_table', 1),
(8, '2019_04_22_161443_create_operators_table', 1),
(9, '2019_04_22_161443_create_password_resets_table', 1),
(10, '2019_04_22_161443_create_permissions_table', 1),
(11, '2019_04_22_161443_create_posts_table', 1),
(12, '2019_04_22_161443_create_rbt_codes_table', 1),
(13, '2019_04_22_161443_create_relations_table', 1),
(14, '2019_04_22_161443_create_role_has_permissions_table', 1),
(15, '2019_04_22_161443_create_role_route_table', 1),
(16, '2019_04_22_161443_create_roles_table', 1),
(17, '2019_04_22_161443_create_routes_table', 1),
(18, '2019_04_22_161443_create_scaffoldinterfaces_table', 1),
(19, '2019_04_22_161443_create_settings_table', 1),
(20, '2019_04_22_161443_create_static_bodies_table', 1),
(21, '2019_04_22_161443_create_static_translations_table', 1),
(22, '2019_04_22_161443_create_tans_bodies_table', 1),
(23, '2019_04_22_161443_create_translatables_table', 1),
(24, '2019_04_22_161443_create_types_table', 1),
(25, '2019_04_22_161443_create_user_has_permissions_table', 1),
(26, '2019_04_22_161443_create_user_has_roles_table', 1),
(27, '2019_04_22_161443_create_users_table', 1),
(28, '2019_04_22_161445_add_foreign_keys_to_categories_table', 1),
(29, '2019_04_22_161445_add_foreign_keys_to_contents_table', 1),
(30, '2019_04_22_161445_add_foreign_keys_to_delete_all_flags_table', 1),
(31, '2019_04_22_161445_add_foreign_keys_to_operators_table', 1),
(32, '2019_04_22_161445_add_foreign_keys_to_posts_table', 1),
(33, '2019_04_22_161445_add_foreign_keys_to_rbt_codes_table', 1),
(34, '2019_04_22_161445_add_foreign_keys_to_relations_table', 1),
(35, '2019_04_22_161445_add_foreign_keys_to_role_has_permissions_table', 1),
(36, '2019_04_22_161445_add_foreign_keys_to_role_route_table', 1),
(37, '2019_04_22_161445_add_foreign_keys_to_settings_table', 1),
(38, '2019_04_22_161445_add_foreign_keys_to_static_bodies_table', 1),
(39, '2019_04_22_161445_add_foreign_keys_to_tans_bodies_table', 1),
(40, '2019_04_22_161445_add_foreign_keys_to_user_has_permissions_table', 1),
(41, '2019_04_22_161445_add_foreign_keys_to_user_has_roles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rbt_sms_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rbt_ussd_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `name`, `rbt_sms_code`, `rbt_ussd_code`, `image`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'etisalat', '123', '1234', '1552552540477.png', 1, '2019-02-11 11:12:35', '2019-03-14 06:35:40'),
(4, 'Vodafone', '123', '', '1552552433218.png', 1, '2019-02-11 13:23:49', '2019-03-14 06:33:53'),
(5, 'Orange', '123456789', '123', '1552552570122.png', 1, '2019-03-14 06:36:10', '2019-03-14 06:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `published_date` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL,
  `operator_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `published_date`, `active`, `url`, `content_id`, `operator_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2021-01-31', 1, 'http://localhost/ivas_template_laravel5.8/user/content/24?op_id=1&post_id=1', 24, 1, 1, '2021-01-31 12:16:01', '2021-01-31 12:16:02'),
(2, '2021-01-31', 1, 'http://localhost/ivas_template_laravel5.8/user/content/24?op_id=4&post_id=2', 24, 4, 1, '2021-01-31 12:16:01', '2021-01-31 12:16:02'),
(3, '2021-01-31', 1, 'http://localhost/ivas_template_laravel5.8/user/content/24?op_id=5&post_id=3', 24, 5, 1, '2021-01-31 12:16:02', '2021-01-31 12:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `rbt_codes`
--

CREATE TABLE `rbt_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `rbt_code` int(11) NOT NULL,
  `content_id` int(10) UNSIGNED NOT NULL,
  `operator_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rbt_codes`
--

INSERT INTO `rbt_codes` (`id`, `rbt_code`, `content_id`, `operator_id`, `created_at`, `updated_at`) VALUES
(1, 12345, 24, 1, '2019-03-14 06:51:28', '2019-03-14 06:51:28'),
(3, 133, 24, 4, '2019-03-14 06:52:51', '2019-03-14 06:52:51'),
(4, 1235, 24, 5, '2019-03-14 06:52:51', '2019-03-14 06:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE `relations` (
  `id` int(10) UNSIGNED NOT NULL,
  `scaffoldinterface_id` int(10) UNSIGNED NOT NULL,
  `to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `having` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `role_priority`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 3, '2017-11-09 04:13:14', '2017-11-09 04:13:14'),
(6, 'admin', 2, '2018-01-08 12:40:19', '2018-01-08 12:40:19'),
(7, 'upload', 1, '2021-01-26 10:32:48', '2021-01-26 10:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_route`
--

CREATE TABLE `role_route` (
  `id` int(11) NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `route_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_route`
--

INSERT INTO `role_route` (`id`, `role_id`, `route_id`, `created_at`, `updated_at`) VALUES
(15, 1, 127, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(16, 6, 127, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(17, 1, 128, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(18, 6, 128, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(19, 1, 129, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(20, 6, 129, '2019-02-14 11:02:21', '2019-02-14 11:02:21'),
(21, 1, 130, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(22, 6, 130, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(23, 1, 131, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(24, 6, 131, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(25, 1, 132, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(26, 6, 132, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(27, 1, 133, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(28, 6, 133, '2019-02-14 11:02:22', '2019-02-14 11:02:22'),
(57, 1, 148, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(58, 6, 148, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(59, 1, 149, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(60, 6, 149, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(61, 1, 150, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(62, 6, 150, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(63, 1, 151, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(64, 6, 151, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(65, 1, 152, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(66, 6, 152, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(67, 1, 153, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(68, 6, 153, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(69, 1, 154, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(70, 6, 154, '2019-03-06 07:00:28', '2019-03-06 07:00:28'),
(71, 1, 155, '2019-03-14 06:51:14', '2019-03-14 06:51:14'),
(72, 6, 155, '2019-03-14 06:51:14', '2019-03-14 06:51:14'),
(73, 1, 156, '2019-03-14 06:51:14', '2019-03-14 06:51:14'),
(74, 6, 156, '2019-03-14 06:51:14', '2019-03-14 06:51:14'),
(75, 1, 157, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(76, 6, 157, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(77, 1, 158, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(78, 6, 158, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(79, 1, 159, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(80, 6, 159, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(81, 1, 160, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(82, 6, 160, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(83, 1, 161, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(84, 6, 161, '2019-03-14 06:51:15', '2019-03-14 06:51:15'),
(217, 6, 40, '2021-01-31 10:29:07', '2021-01-31 10:29:07'),
(218, 7, 40, '2021-01-31 10:29:07', '2021-01-31 10:29:07'),
(219, 6, 45, '2021-01-31 10:29:07', '2021-01-31 10:29:07'),
(220, 7, 45, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(221, 6, 41, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(222, 7, 41, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(223, 6, 57, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(224, 7, 57, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(225, 6, 42, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(226, 7, 42, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(227, 6, 43, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(228, 7, 43, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(229, 6, 44, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(230, 7, 44, '2021-01-31 10:29:08', '2021-01-31 10:29:08'),
(232, 7, 79, '2021-01-31 10:53:38', '2021-01-31 10:53:38'),
(233, 7, 11, '2021-01-31 10:53:38', '2021-01-31 10:53:38'),
(235, 7, 59, '2021-01-31 11:04:45', '2021-01-31 11:04:45'),
(236, 7, 62, '2021-01-31 11:04:45', '2021-01-31 11:04:45'),
(239, 7, 14, '2021-01-31 11:19:47', '2021-01-31 11:19:47'),
(240, 7, 36, '2021-01-31 11:32:15', '2021-01-31 11:32:15'),
(241, 7, 39, '2021-01-31 11:32:15', '2021-01-31 11:32:15'),
(242, 7, 106, '2021-01-31 11:36:42', '2021-01-31 11:36:42'),
(243, 7, 110, '2021-01-31 11:36:42', '2021-01-31 11:36:42'),
(244, 1, 113, '2021-01-31 11:53:24', '2021-01-31 11:53:24'),
(245, 7, 113, '2021-01-31 11:53:25', '2021-01-31 11:53:25'),
(246, 1, 114, '2021-01-31 11:53:25', '2021-01-31 11:53:25'),
(247, 6, 116, '2021-01-31 11:53:25', '2021-01-31 11:53:25'),
(248, 7, 116, '2021-01-31 11:53:25', '2021-01-31 11:53:25'),
(249, 7, 117, '2021-01-31 11:53:25', '2021-01-31 11:53:25'),
(266, 1, 120, '2021-01-31 11:55:43', '2021-01-31 11:55:43'),
(267, 6, 120, '2021-01-31 11:55:43', '2021-01-31 11:55:43'),
(268, 7, 120, '2021-01-31 11:55:43', '2021-01-31 11:55:43'),
(269, 1, 121, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(270, 6, 121, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(271, 1, 122, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(272, 6, 122, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(273, 1, 123, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(274, 6, 123, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(275, 1, 124, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(276, 6, 124, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(277, 7, 124, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(278, 1, 125, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(279, 6, 125, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(280, 1, 126, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(281, 6, 126, '2021-01-31 11:55:44', '2021-01-31 11:55:44'),
(314, 1, 141, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(315, 6, 141, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(316, 7, 141, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(317, 1, 142, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(318, 6, 142, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(319, 1, 143, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(320, 6, 143, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(321, 1, 144, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(322, 6, 144, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(323, 1, 145, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(324, 6, 145, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(325, 7, 145, '2021-01-31 12:16:18', '2021-01-31 12:16:18'),
(326, 1, 146, '2021-01-31 12:16:19', '2021-01-31 12:16:19'),
(327, 6, 146, '2021-01-31 12:16:19', '2021-01-31 12:16:19'),
(328, 1, 147, '2021-01-31 12:16:19', '2021-01-31 12:16:19'),
(329, 6, 147, '2021-01-31 12:16:19', '2021-01-31 12:16:19'),
(330, 1, 80, '2021-01-31 12:42:06', '2021-01-31 12:42:06'),
(331, 1, 81, '2021-01-31 12:42:06', '2021-01-31 12:42:06'),
(332, 1, 82, '2021-01-31 12:42:06', '2021-01-31 12:42:06'),
(333, 1, 83, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(334, 1, 84, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(335, 1, 162, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(336, 1, 6, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(337, 1, 7, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(338, 1, 8, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(339, 1, 9, '2021-01-31 12:42:07', '2021-01-31 12:42:07'),
(340, 1, 30, '2021-01-31 12:43:37', '2021-01-31 12:43:37'),
(341, 1, 31, '2021-01-31 12:43:37', '2021-01-31 12:43:37'),
(342, 1, 32, '2021-01-31 12:43:37', '2021-01-31 12:43:37'),
(343, 1, 34, '2021-01-31 12:43:37', '2021-01-31 12:43:37'),
(344, 7, 34, '2021-01-31 12:43:37', '2021-01-31 12:43:37'),
(345, 1, 35, '2021-01-31 12:43:38', '2021-01-31 12:43:38'),
(346, 1, 33, '2021-01-31 12:43:38', '2021-01-31 12:43:38'),
(347, 1, 58, '2021-01-31 12:43:38', '2021-01-31 12:43:38'),
(383, 1, 134, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(384, 6, 134, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(385, 7, 134, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(386, 1, 135, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(387, 6, 135, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(388, 7, 135, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(389, 1, 136, '2021-01-31 12:48:00', '2021-01-31 12:48:00'),
(390, 6, 136, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(391, 7, 136, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(392, 1, 137, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(393, 6, 137, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(394, 7, 137, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(395, 1, 138, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(396, 6, 138, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(397, 7, 138, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(398, 1, 139, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(399, 6, 139, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(400, 1, 140, '2021-01-31 12:48:01', '2021-01-31 12:48:01'),
(401, 6, 140, '2021-01-31 12:48:01', '2021-01-31 12:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `function_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `method`, `route`, `controller_name`, `created_at`, `updated_at`, `function_name`) VALUES
(2, 'get', 'setting/new', 'SettingController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'create'),
(3, 'post', 'setting', 'SettingController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'store'),
(4, 'get', 'dashboard', 'DashboardController', '2018-02-05 11:39:21', '2018-07-24 11:47:45', 'index'),
(5, 'get', '/', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'index'),
(6, 'get', 'user_profile', 'UserController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'profile'),
(7, 'post', 'user_profile/updatepassword', 'UserController', '2018-02-05 11:39:21', '2017-11-14 10:29:01', 'UpdatePassword'),
(8, 'post', 'user_profile/updateprofilepic', 'UserController', '2018-02-05 11:39:21', '2017-11-14 10:29:08', 'UpdateProfilePicture'),
(9, 'post', 'user_profile/updateuserdata', 'UserController', '2018-02-05 11:39:21', '2017-11-14 10:29:19', 'UpdateNameAndEmail'),
(10, 'get', 'setting/{id}/delete', 'SettingController', '2018-02-05 11:39:21', '2018-02-05 11:39:22', 'destroy'),
(11, 'get', 'setting/{id}/edit', 'SettingController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'edit'),
(12, 'post', 'setting/{id}', 'SettingController', '2018-02-05 11:39:21', '2018-02-05 11:56:27', 'update'),
(14, 'get', 'static_translation', 'StaticTranslationController', '2018-02-05 11:39:21', '2017-11-14 10:29:57', 'index'),
(21, 'get', 'file_manager', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'file_manager'),
(22, 'get', 'upload_items', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'multi_upload'),
(23, 'post', 'save_items', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'save_uploaded'),
(24, 'get', 'upload_resize', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'upload_resize'),
(25, 'post', 'save_image', 'DashboardController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'save_image'),
(26, 'post', 'static_translation/{id}/update', 'StaticTranslationController', '2018-02-05 11:39:21', '2017-11-12 10:19:46', 'update'),
(27, 'get', 'static_translation/{id}/delete', 'StaticTranslationController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'destroy'),
(28, 'get', 'language/{id}/delete', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'destroy'),
(29, 'post', 'language/{id}/update', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'update'),
(30, 'get', 'roles', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'index'),
(31, 'get', 'roles/new', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'create'),
(32, 'post', 'roles', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'store'),
(33, 'get', 'roles/{id}/delete', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'destroy'),
(34, 'get', 'roles/{id}/edit', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'edit'),
(35, 'post', 'roles/{id}/update', 'RoleController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'update'),
(36, 'get', 'language', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'index'),
(37, 'get', 'language/create', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'create'),
(38, 'post', 'language', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'store'),
(39, 'get', 'language/{id}/edit', 'LanguageController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'edit'),
(40, 'get', 'all_routes', 'RouteController', '2018-02-05 11:39:21', '2019-10-13 09:51:33', 'index'),
(41, 'post', 'routes', 'RouteController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'store'),
(42, 'get', 'routes/{id}/edit', 'RouteController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'edit'),
(43, 'post', 'routes/{id}/update', 'RouteController', '2018-02-05 11:39:21', '2018-01-28 07:25:29', 'update'),
(44, 'get', 'routes/{id}/delete', 'RouteController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'destroy'),
(45, 'get', 'routes/create', 'RouteController', '2018-02-05 11:39:21', '2018-02-05 11:39:21', 'create'),
(57, 'get', 'routes/index_v2', 'RouteController', '2017-11-12 11:45:15', '2017-11-12 12:04:53', 'index_v2'),
(58, 'get', 'roles/{id}/view_access', 'RoleController', '2017-11-14 08:56:14', '2017-11-15 06:14:14', 'view_access'),
(59, 'get', 'types/index', 'TypeController', '2018-01-28 06:25:37', '2018-01-28 06:25:37', 'index'),
(60, 'get', 'types/create', 'TypeController', '2018-01-28 06:25:37', '2018-01-28 06:25:37', 'create'),
(61, 'post', 'types', 'TypeController', '2018-01-28 06:25:38', '2018-01-28 06:25:38', 'store'),
(62, 'get', 'types/{id}/edit', 'TypeController', '2018-01-28 06:25:38', '2018-01-28 06:25:38', 'edit'),
(63, 'patch', 'types/{id}', 'TypeController', '2018-01-28 06:25:38', '2018-01-28 06:25:38', 'update'),
(64, 'get', 'types/{id}/delete', 'TypeController', '2018-01-28 06:25:38', '2018-01-28 06:25:38', 'destroy'),
(65, 'post', 'sortabledatatable', 'SettingController', '2018-01-28 07:22:00', '2018-01-28 07:22:00', 'updateOrder'),
(66, 'get', 'buildroutes', 'RouteController', '2018-01-28 07:23:55', '2018-01-28 07:23:55', 'buildroutes'),
(69, 'get', 'delete_all', 'DashboardController', '2018-02-04 10:01:23', '2018-02-04 10:01:23', 'delete_all_index'),
(70, 'post', 'delete_all', 'DashboardController', '2018-02-04 10:01:23', '2018-02-04 10:01:23', 'delete_all_store'),
(71, 'get', 'upload_resize_v2', 'DashboardController', '2018-02-04 11:02:56', '2018-02-04 11:02:56', 'upload_resize_v2'),
(72, 'post', 'sortabledatatable', 'UserController', '2018-02-05 11:39:22', '2018-02-05 11:39:22', 'updateOrder'),
(79, 'get', 'setting', 'SettingController', '2018-02-05 12:10:10', '2018-02-05 12:10:10', 'index'),
(80, 'get', 'users', 'UserController', '2018-05-31 07:42:21', '2018-05-31 07:42:21', 'index'),
(81, 'get', 'users/new', 'UserController', '2018-05-31 07:42:21', '2018-05-31 07:42:21', 'create'),
(82, 'post', 'users', 'UserController', '2018-05-31 07:42:21', '2018-05-31 07:42:21', 'store'),
(83, 'get', 'users/{id}/edit', 'UserController', '2018-05-31 07:42:21', '2018-05-31 07:42:21', 'edit'),
(84, 'post', 'users/{id}/update', 'UserController', '2018-05-31 07:42:21', '2018-05-31 07:42:21', 'update'),
(106, 'get', 'country', 'CountryController', '2019-02-10 06:09:36', '2019-02-10 06:09:36', 'index'),
(107, 'get', 'country/create', 'CountryController', '2019-02-10 06:09:36', '2019-02-10 06:09:36', 'create'),
(108, 'post', 'country', 'CountryController', '2019-02-10 06:09:36', '2019-02-10 06:09:36', 'store'),
(109, 'get', 'country/{id}', 'CountryController', '2019-02-10 06:09:36', '2019-02-10 06:09:36', 'show'),
(110, 'get', 'country/{id}/edit', 'CountryController', '2019-02-10 06:09:37', '2019-02-10 06:09:37', 'edit'),
(111, 'patch', 'country/{id}', 'CountryController', '2019-02-10 06:09:37', '2019-02-10 06:10:42', 'update'),
(112, 'get', 'country/{id}/delete', 'CountryController', '2019-02-10 06:09:37', '2019-02-10 06:09:37', 'delete'),
(113, 'get', 'operator', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'index'),
(114, 'get', 'operator/create', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'create'),
(115, 'post', 'operator', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'store'),
(116, 'get', 'operator/{id}', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'show'),
(117, 'get', 'operator/{id}/edit', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'edit'),
(118, 'patch', 'operator/{id}', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'update'),
(119, 'get', 'operator/{id}/delete', 'OperatorController', '2019-02-10 06:10:27', '2019-02-10 06:10:27', 'destroy'),
(120, 'get', 'category', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'index'),
(121, 'get', 'category/create', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'create'),
(122, 'post', 'category', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'store'),
(123, 'get', 'category/{id}', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'show'),
(124, 'get', 'category/{id}/edit', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'edit'),
(125, 'patch', 'category/{id}', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'update'),
(126, 'get', 'category/{id}/delete', 'CategoryController', '2019-02-14 11:01:13', '2019-02-14 11:01:13', 'destroy'),
(127, 'get', 'content_type', 'ContentTypeController', '2019-02-14 11:02:21', '2019-02-14 11:02:21', 'index'),
(128, 'get', 'content_type/create', 'ContentTypeController', '2019-02-14 11:02:21', '2019-02-14 11:02:21', 'create'),
(129, 'post', 'content_type', 'ContentTypeController', '2019-02-14 11:02:21', '2019-02-14 11:02:21', 'store'),
(130, 'get', 'content_type/{id}', 'ContentTypeController', '2019-02-14 11:02:21', '2019-02-14 11:02:21', 'show'),
(131, 'get', 'content_type/{id}/edit', 'ContentTypeController', '2019-02-14 11:02:22', '2019-02-14 11:02:22', 'edit'),
(132, 'patch', 'content_type/{id}', 'ContentTypeController', '2019-02-14 11:02:22', '2019-02-14 11:02:22', 'update'),
(133, 'get', 'content_type/{id}/delete', 'ContentTypeController', '2019-02-14 11:02:22', '2019-02-14 11:02:22', 'destroy'),
(134, 'get', 'content', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'index'),
(135, 'get', 'content/create', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'create'),
(136, 'post', 'content', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'store'),
(137, 'get', 'content/{id}', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'show'),
(138, 'get', 'content/{id}/edit', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'edit'),
(139, 'patch', 'content/{id}', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'update'),
(140, 'get', 'content/{id}/delete', 'ContentController', '2019-02-14 11:03:26', '2019-02-14 11:03:26', 'destroy'),
(141, 'get', 'post', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'index'),
(142, 'get', 'post/create', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'create'),
(143, 'post', 'post', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'store'),
(144, 'get', 'post/{id}', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'show'),
(145, 'get', 'post/{id}/edit', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'edit'),
(146, 'patch', 'post/{id}', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'update'),
(147, 'get', 'post/{id}/delete', 'PostController', '2019-02-14 11:04:09', '2019-02-14 11:04:09', 'destroy'),
(148, 'get', 'sub_category', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'index'),
(149, 'get', 'sub_category/create', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'create'),
(150, 'post', 'sub_category', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'store'),
(151, 'get', 'sub_category/{id}', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'show'),
(152, 'get', 'sub_category/{id}/edit', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'edit'),
(153, 'patch', 'sub_category/{id}', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'update'),
(154, 'get', 'sub_category/{id}/delete', 'SubCategoryController', '2019-03-06 07:00:28', '2019-03-06 07:00:28', 'destroy'),
(155, 'get', 'rbt', 'RbtController', '2019-03-14 06:51:14', '2019-03-14 06:51:14', 'index'),
(156, 'get', 'rbt/create', 'RbtController', '2019-03-14 06:51:14', '2019-03-14 06:51:14', 'create'),
(157, 'post', 'rbt', 'RbtController', '2019-03-14 06:51:15', '2019-03-14 06:51:15', 'store'),
(158, 'get', 'rbt/{id}', 'RbtController', '2019-03-14 06:51:15', '2019-03-14 06:51:15', 'show'),
(159, 'get', 'rbt/{id}/edit', 'RbtController', '2019-03-14 06:51:15', '2019-03-14 06:51:15', 'edit'),
(160, 'patch', 'rbt/{id}', 'RbtController', '2019-03-14 06:51:15', '2019-03-14 06:51:15', 'update'),
(161, 'get', 'rbt/{id}/delete', 'RbtController', '2019-03-14 06:51:15', '2019-03-14 06:51:15', 'destroy'),
(162, 'get', 'users/{id}/delete', 'UserController', '2019-10-13 09:51:03', '2019-10-13 09:51:03', 'destroy'),
(163, 'get', 'migrate_tables', 'DashboardController', '2019-10-13 10:09:15', '2019-10-13 11:02:42', 'migrate_tables');

-- --------------------------------------------------------

--
-- Table structure for table `scaffoldinterfaces`
--

CREATE TABLE `scaffoldinterfaces` (
  `id` int(10) UNSIGNED NOT NULL,
  `package` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tablename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`, `type_id`, `order`) VALUES
(25, 'uploadAllow', 'video', '2018-02-04 10:04:09', '2019-02-11 13:09:42', 6, 0),
(27, 'enable_testing', '0', '2019-02-11 13:14:30', '2019-02-11 13:15:45', 7, 0),
(28, 'content_type_flag', '0', '2019-03-07 08:50:04', '2019-03-14 06:54:06', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `static_bodies`
--

CREATE TABLE `static_bodies` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `static_translation_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_bodies`
--

INSERT INTO `static_bodies` (`id`, `language_id`, `static_translation_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '<p>search</p>', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `static_translations`
--

CREATE TABLE `static_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `key_word` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `static_translations`
--

INSERT INTO `static_translations` (`id`, `key_word`, `created_at`, `updated_at`) VALUES
(1, 'search', '2021-01-31 11:06:19', '2021-01-31 11:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `tans_bodies`
--

CREATE TABLE `tans_bodies` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `translatable_id` int(10) UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translatables`
--

CREATE TABLE `translatables` (
  `id` int(10) UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Advanced Editor', '2018-01-28 06:30:05', '2018-01-28 06:30:05'),
(2, 'Normal Editor', '2018-01-28 06:30:14', '2018-01-28 06:30:14'),
(3, 'Image', '2018-01-28 06:30:29', '2018-01-28 06:30:29'),
(4, 'Video', '2018-01-28 06:30:39', '2018-01-28 06:30:39'),
(5, 'Audio', '2018-01-28 06:30:47', '2018-01-28 06:30:47'),
(6, 'File Manager Uploads Extensions', '2018-01-28 06:30:57', '2018-01-28 06:30:57'),
(7, 'selector', '2019-02-11 11:18:52', '2019-02-11 11:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `phone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'super_admin@ivas.com', '$2y$10$u2evAW530miwgUb2jcXkTuqIGswxnSQ3DSmX1Ji5rtO3Tx.MtVcX2', '', '01234567890', 'VvqU4UAngQTesiIt9nYoSkkenUhjSR2bTwYRCHX2sdOtuS38a5BpQwabUbQS', '2017-11-09 04:13:14', '2018-11-26 06:11:50'),
(2, 'yousef', 'yousef@gmail.com', '$2y$10$XN5JE0TOOkjuoRE5y4.nZeN2qzwfFRCwMXlX1FiFsXMNTh71887kq', NULL, NULL, NULL, '2021-01-26 10:33:58', '2021-01-31 12:47:28'),
(3, 'super_admin@ivas.com', 'emad@ivas.com.eg', '$2y$10$WyaabSdUg6ZW7bCJXV2rhuzQpuD0m5LTcQaeQH2PmhtLsL6WPO8kO', NULL, NULL, NULL, '2021-01-27 07:21:09', '2021-01-27 07:21:09'),
(4, 'super_admin@ivas.com', 'yousef.ashraf@ivas.com.eg', '$2y$10$b9owuMA2m5wTdv05cP0JIexEcjoXCmFiREzJEEPIscINyRdHFhDQG', NULL, NULL, NULL, '2021-01-27 07:21:34', '2021-01-27 07:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_permissions`
--

CREATE TABLE `user_has_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_has_roles`
--

CREATE TABLE `user_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_has_roles`
--

INSERT INTO `user_has_roles` (`role_id`, `user_id`) VALUES
(1, 1),
(1, 4),
(7, 2),
(7, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contents_content_type_id_foreign` (`content_type_id`),
  ADD KEY `contents_category_id_foreign` (`category_id`);

--
-- Indexes for table `content_types`
--
ALTER TABLE `content_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delete_all_flags`
--
ALTER TABLE `delete_all_flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delete_all_flags_route_id_foreign` (`route_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operators_country_id_foreign` (`country_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_content_id_foreign` (`content_id`),
  ADD KEY `posts_operator_id_foreign` (`operator_id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `rbt_codes`
--
ALTER TABLE `rbt_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rbt_codes_content_id_foreign` (`content_id`),
  ADD KEY `rbt_codes_operator_id_foreign` (`operator_id`);

--
-- Indexes for table `relations`
--
ALTER TABLE `relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relations_scaffoldinterface_id_foreign` (`scaffoldinterface_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `role_route`
--
ALTER TABLE `role_route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id_2` (`role_id`),
  ADD KEY `route_id_2` (`route_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scaffoldinterfaces`
--
ALTER TABLE `scaffoldinterfaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_type_id_foreign` (`type_id`);

--
-- Indexes for table `static_bodies`
--
ALTER TABLE `static_bodies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `static_bodies_language_id_foreign` (`language_id`),
  ADD KEY `static_bodies_static_translation_id_foreign` (`static_translation_id`);

--
-- Indexes for table `static_translations`
--
ALTER TABLE `static_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tans_bodies`
--
ALTER TABLE `tans_bodies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tans_bodies_language_id_foreign` (`language_id`),
  ADD KEY `tans_bodies_translatable_id_foreign` (`translatable_id`);

--
-- Indexes for table `translatables`
--
ALTER TABLE `translatables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `user_has_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_has_roles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `content_types`
--
ALTER TABLE `content_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delete_all_flags`
--
ALTER TABLE `delete_all_flags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rbt_codes`
--
ALTER TABLE `rbt_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `relations`
--
ALTER TABLE `relations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_route`
--
ALTER TABLE `role_route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `scaffoldinterfaces`
--
ALTER TABLE `scaffoldinterfaces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `static_bodies`
--
ALTER TABLE `static_bodies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `static_translations`
--
ALTER TABLE `static_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tans_bodies`
--
ALTER TABLE `tans_bodies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translatables`
--
ALTER TABLE `translatables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `contents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contents_content_type_id_foreign` FOREIGN KEY (`content_type_id`) REFERENCES `content_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delete_all_flags`
--
ALTER TABLE `delete_all_flags`
  ADD CONSTRAINT `delete_all_flags_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `operators`
--
ALTER TABLE `operators`
  ADD CONSTRAINT `operators_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rbt_codes`
--
ALTER TABLE `rbt_codes`
  ADD CONSTRAINT `rbt_codes_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rbt_codes_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relations`
--
ALTER TABLE `relations`
  ADD CONSTRAINT `relations_scaffoldinterface_id_foreign` FOREIGN KEY (`scaffoldinterface_id`) REFERENCES `scaffoldinterfaces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_route`
--
ALTER TABLE `role_route`
  ADD CONSTRAINT `role_route_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_route_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `static_bodies`
--
ALTER TABLE `static_bodies`
  ADD CONSTRAINT `static_bodies_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `static_bodies_static_translation_id_foreign` FOREIGN KEY (`static_translation_id`) REFERENCES `static_translations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tans_bodies`
--
ALTER TABLE `tans_bodies`
  ADD CONSTRAINT `tans_bodies_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tans_bodies_translatable_id_foreign` FOREIGN KEY (`translatable_id`) REFERENCES `translatables` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD CONSTRAINT `user_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_has_roles`
--
ALTER TABLE `user_has_roles`
  ADD CONSTRAINT `user_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
