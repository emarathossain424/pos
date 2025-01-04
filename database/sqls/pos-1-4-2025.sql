-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 08:42 AM
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
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_branches`
--

CREATE TABLE `core_branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `is_default` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_branches`
--

INSERT INTO `core_branches` (`id`, `branch_name`, `mobile`, `address`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Chittagong', '01625181703', 'MIrpur-11', 0, 1, '2024-09-03 08:24:58', '2024-09-20 21:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `core_currencies`
--

CREATE TABLE `core_currencies` (
  `id` int(11) NOT NULL,
  `currency_name` varchar(150) DEFAULT NULL,
  `currency_code` varchar(150) DEFAULT NULL,
  `currency_symbol` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_currencies`
--

INSERT INTO `core_currencies` (`id`, `currency_name`, `currency_code`, `currency_symbol`, `created_at`, `updated_at`) VALUES
(1, 'Afghan Afghani', 'AFN', '؋', '2024-09-14 03:27:50', NULL),
(2, 'Albanian Lek', 'ALL', 'L', '2024-09-14 03:27:50', NULL),
(3, 'Algerian Dinar', 'DZD', 'دج', '2024-09-14 03:27:50', NULL),
(4, 'Angolan Kwanza', 'AOA', 'Kz', '2024-09-14 03:27:50', NULL),
(5, 'Argentine Peso', 'ARS', '$', '2024-09-14 03:27:50', NULL),
(6, 'Armenian Dram', 'AMD', '֏', '2024-09-14 03:27:50', NULL),
(7, 'Aruban Florin', 'AWG', 'ƒ', '2024-09-14 03:27:50', NULL),
(8, 'Australian Dollar', 'AUD', '$', '2024-09-14 03:27:50', NULL),
(9, 'Azerbaijani Manat', 'AZN', '₼', '2024-09-14 03:27:50', NULL),
(10, 'Bahamian Dollar', 'BSD', '$', '2024-09-14 03:27:50', NULL),
(11, 'Bahraini Dinar', 'BHD', '.د.ب', '2024-09-14 03:27:50', NULL),
(12, 'Bangladeshi Taka', 'BDT', '৳', '2024-09-14 03:27:50', NULL),
(13, 'Barbadian Dollar', 'BBD', '$', '2024-09-14 03:27:50', NULL),
(14, 'Belarusian Ruble', 'BYN', 'Br', '2024-09-14 03:27:50', NULL),
(15, 'Belize Dollar', 'BZD', '$', '2024-09-14 03:27:50', NULL),
(16, 'Bermudian Dollar', 'BMD', '$', '2024-09-14 03:27:50', NULL),
(17, 'Bhutanese Ngultrum', 'BTN', 'Nu.', '2024-09-14 03:27:50', NULL),
(18, 'Bolivian Boliviano', 'BOB', 'Bs.', '2024-09-14 03:27:50', NULL),
(19, 'Bosnia-Herzegovina Convertible Mark', 'BAM', 'KM', '2024-09-14 03:27:50', NULL),
(20, 'Botswana Pula', 'BWP', 'P', '2024-09-14 03:27:50', NULL),
(21, 'Brazilian Real', 'BRL', 'R$', '2024-09-14 03:27:50', NULL),
(22, 'British Pound', 'GBP', '£', '2024-09-14 03:27:50', NULL),
(23, 'Brunei Dollar', 'BND', '$', '2024-09-14 03:27:50', NULL),
(24, 'Bulgarian Lev', 'BGN', 'лв', '2024-09-14 03:27:50', NULL),
(25, 'Burundian Franc', 'BIF', 'FBu', '2024-09-14 03:27:50', NULL),
(26, 'Cabo Verdean Escudo', 'CVE', '$', '2024-09-14 03:27:50', NULL),
(27, 'Cambodian Riel', 'KHR', '៛', '2024-09-14 03:27:50', NULL),
(28, 'Canadian Dollar', 'CAD', '$', '2024-09-14 03:27:50', NULL),
(29, 'Cayman Islands Dollar', 'KYD', '$', '2024-09-14 03:27:50', NULL),
(30, 'Central African CFA Franc', 'XAF', 'Fr', '2024-09-14 03:27:50', NULL),
(31, 'Chilean Peso', 'CLP', '$', '2024-09-14 03:27:50', NULL),
(32, 'Chinese Yuan', 'CNY', '¥', '2024-09-14 03:27:50', NULL),
(33, 'Colombian Peso', 'COP', '$', '2024-09-14 03:27:50', NULL),
(34, 'Comorian Franc', 'KMF', 'Fr', '2024-09-14 03:27:50', NULL),
(35, 'Congolese Franc', 'CDF', 'Fr', '2024-09-14 03:27:50', NULL),
(36, 'Costa Rican Colón', 'CRC', '₡', '2024-09-14 03:27:50', NULL),
(37, 'Croatian Kuna', 'HRK', 'kn', '2024-09-14 03:27:50', NULL),
(38, 'Cuban Peso', 'CUP', '$', '2024-09-14 03:27:50', NULL),
(39, 'Czech Koruna', 'CZK', 'Kč', '2024-09-14 03:27:50', NULL),
(40, 'Danish Krone', 'DKK', 'kr', '2024-09-14 03:27:50', NULL),
(41, 'Djiboutian Franc', 'DJF', 'Fdj', '2024-09-14 03:27:50', NULL),
(42, 'Dominican Peso', 'DOP', 'RD$', '2024-09-14 03:27:50', NULL),
(43, 'East Caribbean Dollar', 'XCD', '$', '2024-09-14 03:27:50', NULL),
(44, 'Egyptian Pound', 'EGP', '£', '2024-09-14 03:27:50', NULL),
(45, 'Eritrean Nakfa', 'ERN', 'Nkf', '2024-09-14 03:27:50', NULL),
(46, 'Eswatini Lilangeni', 'SZL', 'L', '2024-09-14 03:27:50', NULL),
(47, 'Ethiopian Birr', 'ETB', 'Br', '2024-09-14 03:27:50', NULL),
(48, 'Euro', 'EUR', '€', '2024-09-14 03:27:50', NULL),
(49, 'Fijian Dollar', 'FJD', '$', '2024-09-14 03:27:50', NULL),
(50, 'Gambian Dalasi', 'GMD', 'D', '2024-09-14 03:27:50', NULL),
(51, 'Georgian Lari', 'GEL', '₾', '2024-09-14 03:27:50', NULL),
(52, 'Ghanaian Cedi', 'GHS', '₵', '2024-09-14 03:27:50', NULL),
(53, 'Gibraltar Pound', 'GIP', '£', '2024-09-14 03:27:50', NULL),
(54, 'Guatemalan Quetzal', 'GTQ', 'Q', '2024-09-14 03:27:50', NULL),
(55, 'Guinean Franc', 'GNF', 'Fr', '2024-09-14 03:27:50', NULL),
(56, 'Guyanaese Dollar', 'GYD', '$', '2024-09-14 03:27:50', NULL),
(57, 'Haitian Gourde', 'HTG', 'G', '2024-09-14 03:27:50', NULL),
(58, 'Honduran Lempira', 'HNL', 'L', '2024-09-14 03:27:50', NULL),
(59, 'Hong Kong Dollar', 'HKD', '$', '2024-09-14 03:27:50', NULL),
(60, 'Hungarian Forint', 'HUF', 'Ft', '2024-09-14 03:27:50', NULL),
(61, 'Icelandic Króna', 'ISK', 'kr', '2024-09-14 03:27:50', NULL),
(62, 'Indian Rupee', 'INR', '₹', '2024-09-14 03:27:50', NULL),
(63, 'Indonesian Rupiah', 'IDR', 'Rp', '2024-09-14 03:27:50', NULL),
(64, 'Iranian Rial', 'IRR', '﷼', '2024-09-14 03:27:50', NULL),
(65, 'Iraqi Dinar', 'IQD', 'ع.د', '2024-09-14 03:27:50', NULL),
(66, 'Israeli New Shekel', 'ILS', '₪', '2024-09-14 03:27:50', NULL),
(67, 'Jamaican Dollar', 'JMD', '$', '2024-09-14 03:27:50', NULL),
(68, 'Japanese Yen', 'JPY', '¥', '2024-09-14 03:27:50', NULL),
(69, 'Jordanian Dinar', 'JOD', 'د.ا', '2024-09-14 03:27:50', NULL),
(70, 'Kazakhstani Tenge', 'KZT', '₸', '2024-09-14 03:27:50', NULL),
(71, 'Kenyan Shilling', 'KES', 'Sh', '2024-09-14 03:27:50', NULL),
(72, 'Kuwaiti Dinar', 'KWD', 'د.ك', '2024-09-14 03:27:50', NULL),
(73, 'Kyrgyzstani Som', 'KGS', 'с', '2024-09-14 03:27:50', NULL),
(74, 'Lao Kip', 'LAK', '₭', '2024-09-14 03:27:50', NULL),
(75, 'Lebanese Pound', 'LBP', 'ل.ل', '2024-09-14 03:27:50', NULL),
(76, 'Lesotho Loti', 'LSL', 'L', '2024-09-14 03:27:50', NULL),
(77, 'Liberian Dollar', 'LRD', '$', '2024-09-14 03:27:50', NULL),
(78, 'Libyan Dinar', 'LYD', 'ل.د', '2024-09-14 03:27:50', NULL),
(79, 'Macanese Pataca', 'MOP', 'P', '2024-09-14 03:27:50', NULL),
(80, 'Macedonian Denar', 'MKD', 'ден', '2024-09-14 03:27:50', NULL),
(81, 'Malagasy Ariary', 'MGA', 'Ar', '2024-09-14 03:27:50', NULL),
(82, 'Malawian Kwacha', 'MWK', 'MK', '2024-09-14 03:27:50', NULL),
(83, 'Malaysian Ringgit', 'MYR', 'RM', '2024-09-14 03:27:50', NULL),
(84, 'Maldivian Rufiyaa', 'MVR', 'ރ.', '2024-09-14 03:27:50', NULL),
(85, 'Mauritanian Ouguiya', 'MRU', 'UM', '2024-09-14 03:27:50', NULL),
(86, 'Mauritian Rupee', 'MUR', '₨', '2024-09-14 03:27:50', NULL),
(87, 'Mexican Peso', 'MXN', '$', '2024-09-14 03:27:50', NULL),
(88, 'Moldovan Leu', 'MDL', 'L', '2024-09-14 03:27:50', NULL),
(89, 'Mongolian Tögrög', 'MNT', '₮', '2024-09-14 03:27:50', NULL),
(90, 'Moroccan Dirham', 'MAD', 'د.م.', '2024-09-14 03:27:50', NULL),
(91, 'Mozambican Metical', 'MZN', 'MT', '2024-09-14 03:27:50', NULL),
(92, 'Myanmar Kyat', 'MMK', 'K', '2024-09-14 03:27:50', NULL),
(93, 'Namibian Dollar', 'NAD', '$', '2024-09-14 03:27:50', NULL),
(94, 'Nepalese Rupee', 'NPR', '₨', '2024-09-14 03:27:50', NULL),
(95, 'Netherlands Antillean Guilder', 'ANG', 'ƒ', '2024-09-14 03:27:50', NULL),
(96, 'New Zealand Dollar', 'NZD', '$', '2024-09-14 03:27:50', NULL),
(97, 'Nicaraguan Córdoba', 'NIO', 'C$', '2024-09-14 03:27:50', NULL),
(98, 'Nigerian Naira', 'NGN', '₦', '2024-09-14 03:27:50', NULL),
(99, 'North Korean Won', 'KPW', '₩', '2024-09-14 03:27:50', NULL),
(100, 'Norwegian Krone', 'NOK', 'kr', '2024-09-14 03:27:50', NULL),
(101, 'Omani Rial', 'OMR', 'ر.ع.', '2024-09-14 03:27:50', NULL),
(102, 'Pakistani Rupee', 'PKR', '₨', '2024-09-14 03:27:50', NULL),
(103, 'Panamanian Balboa', 'PAB', 'B/.', '2024-09-14 03:27:50', NULL),
(104, 'Papua New Guinean Kina', 'PGK', 'K', '2024-09-14 03:27:50', NULL),
(105, 'Paraguayan Guarani', 'PYG', '₲', '2024-09-14 03:27:50', NULL),
(106, 'Peruvian Sol', 'PEN', 'S/.', '2024-09-14 03:27:50', NULL),
(107, 'Philippine Peso', 'PHP', '₱', '2024-09-14 03:27:50', NULL),
(108, 'Polish Zloty', 'PLN', 'zł', '2024-09-14 03:27:50', NULL),
(109, 'Qatari Riyal', 'QAR', 'ر.ق', '2024-09-14 03:27:50', NULL),
(110, 'Romanian Leu', 'RON', 'lei', '2024-09-14 03:27:50', NULL),
(111, 'Russian Ruble', 'RUB', '₽', '2024-09-14 03:27:50', NULL),
(112, 'Rwandan Franc', 'RWF', 'Fr', '2024-09-14 03:27:50', NULL),
(113, 'Saint Helena Pound', 'SHP', '£', '2024-09-14 03:27:50', NULL),
(114, 'Samoan Tala', 'WST', 'T', '2024-09-14 03:27:50', NULL),
(115, 'São Tomé and Príncipe Dobra', 'STN', 'Db', '2024-09-14 03:27:50', NULL),
(116, 'Saudi Riyal', 'SAR', 'ر.س', '2024-09-14 03:27:50', NULL),
(117, 'Serbian Dinar', 'RSD', 'дин.', '2024-09-14 03:27:50', NULL),
(118, 'Seychellois Rupee', 'SCR', '₨', '2024-09-14 03:27:50', NULL),
(119, 'Sierra Leonean Leone', 'SLL', 'Le', '2024-09-14 03:27:50', NULL),
(120, 'Singapore Dollar', 'SGD', '$', '2024-09-14 03:27:50', NULL),
(121, 'Solomon Islands Dollar', 'SBD', '$', '2024-09-14 03:27:50', NULL),
(122, 'Somali Shilling', 'SOS', 'Sh', '2024-09-14 03:27:50', NULL),
(123, 'South African Rand', 'ZAR', 'R', '2024-09-14 03:27:50', NULL),
(124, 'South Korean Won', 'KRW', '₩', '2024-09-14 03:27:50', NULL),
(125, 'South Sudanese Pound', 'SSP', '£', '2024-09-14 03:27:50', NULL),
(126, 'Sri Lankan Rupee', 'LKR', '₨', '2024-09-14 03:27:50', NULL),
(127, 'Sudanese Pound', 'SDG', '£', '2024-09-14 03:27:50', NULL),
(128, 'Surinamese Dollar', 'SRD', '$', '2024-09-14 03:27:50', NULL),
(129, 'Swazi Lilangeni', 'SZL', 'L', '2024-09-14 03:27:50', NULL),
(130, 'Swedish Krona', 'SEK', 'kr', '2024-09-14 03:27:50', NULL),
(131, 'Swiss Franc', 'CHF', 'Fr', '2024-09-14 03:27:50', NULL),
(132, 'Syrian Pound', 'SYP', '£', '2024-09-14 03:27:50', NULL),
(133, 'Tajikistani Somoni', 'TJS', 'ЅМ', '2024-09-14 03:27:50', NULL),
(134, 'Tanzanian Shilling', 'TZS', 'Sh', '2024-09-14 03:27:50', NULL),
(135, 'Thai Baht', 'THB', '฿', '2024-09-14 03:27:50', NULL),
(136, 'Tongan Paʻanga', 'TOP', 'T$', '2024-09-14 03:27:50', NULL),
(137, 'Trinidad and Tobago Dollar', 'TTD', '$', '2024-09-14 03:27:50', NULL),
(138, 'Tunisian Dinar', 'TND', 'د.ت', '2024-09-14 03:27:50', NULL),
(139, 'Turkish Lira', 'TRY', '₺', '2024-09-14 03:27:50', NULL),
(140, 'Turkmenistani Manat', 'TMT', 'm', '2024-09-14 03:27:50', NULL),
(141, 'Ugandan Shilling', 'UGX', 'Sh', '2024-09-14 03:27:50', NULL),
(142, 'Ukrainian Hryvnia', 'UAH', '₴', '2024-09-14 03:27:50', NULL),
(143, 'United Arab Emirates Dirham', 'AED', 'د.إ', '2024-09-14 03:27:50', NULL),
(144, 'United States Dollar', 'USD', '$', '2024-09-14 03:27:50', NULL),
(145, 'Uruguayan Peso', 'UYU', '$U', '2024-09-14 03:27:50', NULL),
(146, 'Uzbekistani Som', 'UZS', 'сум', '2024-09-14 03:27:50', NULL),
(147, 'Vanuatu Vatu', 'VUV', 'Vt', '2024-09-14 03:27:50', NULL),
(148, 'Venezuelan Bolívar', 'VES', 'Bs.', '2024-09-14 03:27:50', NULL),
(149, 'Vietnamese Đồng', 'VND', '₫', '2024-09-14 03:27:50', NULL),
(150, 'Western African CFA Franc', 'XOF', 'Fr', '2024-09-14 03:27:50', NULL),
(151, 'Yemeni Rial', 'YER', '﷼', '2024-09-14 03:27:50', NULL),
(152, 'Zambian Kwacha', 'ZMW', 'ZK', '2024-09-14 03:27:50', NULL),
(153, 'Zimbabwean Dollar', 'ZWL', '$', '2024-09-14 03:27:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_customers`
--

CREATE TABLE `core_customers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `mobile` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_customers`
--

INSERT INTO `core_customers` (`id`, `name`, `mobile`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Emarat Hossain', '01625181702', 'badhon424@gmail.com', 'Shagufta Housing', '2024-12-20 14:28:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_order_status`
--

CREATE TABLE `core_order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_order_status`
--

INSERT INTO `core_order_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Delivered', '2024-12-09 01:17:59', '2024-12-19 22:57:12'),
(2, 'Pending', '2024-12-09 01:18:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_order_types`
--

CREATE TABLE `core_order_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `core_order_types`
--

INSERT INTO `core_order_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Take Away', '2024-12-09 01:17:59', '2024-12-20 08:21:37'),
(2, 'Dine In', '2024-12-09 01:18:18', '2024-12-20 08:21:42'),
(4, 'Delivery', '2024-12-20 08:33:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_taxes`
--

CREATE TABLE `core_taxes` (
  `id` int(11) NOT NULL,
  `tax_name` varchar(50) DEFAULT NULL,
  `tax_rate` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_taxes`
--

INSERT INTO `core_taxes` (`id`, `tax_name`, `tax_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tax10111135', 5, '1', '2024-10-10 23:35:53', '2024-10-10 23:35:53'),
(2, 'Karleigh Wright', 20, '1', '2024-10-10 23:41:18', '2024-12-05 23:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `core_translate_branches`
--

CREATE TABLE `core_translate_branches` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `branch_name` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `core_translate_order_status`
--

CREATE TABLE `core_translate_order_status` (
  `id` int(11) NOT NULL,
  `order_status_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_translate_order_status`
--

INSERT INTO `core_translate_order_status` (`id`, `order_status_id`, `lang_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Delivered02', '2024-12-19 22:57:19', '2024-12-19 22:57:19');

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
-- Table structure for table `food_categories`
--

CREATE TABLE `food_categories` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `featured_status` int(11) NOT NULL DEFAULT 1,
  `meta_title` varchar(150) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_image` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_categories`
--

INSERT INTO `food_categories` (`id`, `parent`, `name`, `image`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Cakes', 58, 1, 1, 'Cake', 'This is a simple category', 58, '2024-03-05 10:48:07', '2024-04-30 04:14:53'),
(2, NULL, 'Burger', 61, 1, 0, 'Burger', 'This is a burger category', 61, '2024-04-25 22:12:35', '2024-08-30 07:19:37'),
(3, 1, 'Pan Cake', 80, 1, 1, 'Pan Cake', 'This a pa cake sub category', 79, '2024-04-25 22:17:36', '2024-04-30 04:15:22');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `offer_price` double DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_image` int(11) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `food_type` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `category`, `details`, `image`, `status`, `price`, `offer_price`, `meta_title`, `meta_image`, `meta_description`, `food_type`, `created_at`, `updated_at`) VALUES
(9, 'Aubrey Roy', 1, '<p><i><strong>Minus consequatur n</strong></i></p>', 61, 1, 764, 578, 'Omnis eligendi quod', 62, '<h3>meta description</h3>', 'variant', '2024-06-26 19:17:37', '2024-09-13 05:32:19'),
(11, 'Ursula Burke', 3, 'Qui fugit non disti', 62, 1, 591, 940, 'Sed odio accusantium', 61, NULL, 'single', '2024-06-27 19:07:33', '2024-08-08 18:37:01'),
(17, 'Xanthus Cummings', 2, 'Natus eveniet labor', 58, 1, 826, 652, 'Exercitationem dolor', NULL, NULL, 'variant', '2024-08-01 18:30:44', '2024-08-01 18:30:44'),
(20, 'Victor Carter', 1, '<p>Test description</p>', 62, 1, 500, 400, 'Sint veniam volupt', 62, '<p>Test meta description</p>', 'single', '2024-09-13 07:13:53', '2024-09-13 07:13:53'),
(21, 'Daryl Hansen', 2, '<p>Test food details</p>', 80, 1, 241, 938, 'Dolor consequatur d', 61, '<p>Test meta food details</p>', 'variant', '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(22, 'Chocolate Cake', 1, '<p>Chocolate Cake</p>', 62, 1, 851, 855, 'Ad architecto laboru', NULL, NULL, 'single', '2024-11-07 19:29:44', '2024-11-07 19:29:44');

-- --------------------------------------------------------

--
-- Table structure for table `food_items_variant_combos`
--

CREATE TABLE `food_items_variant_combos` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT 0,
  `combo` text NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items_variant_combos`
--

INSERT INTO `food_items_variant_combos` (`id`, `item_id`, `combo`, `created_at`, `updated_at`) VALUES
(1, 9, '{\"combo\":[{\"variant\":{\"name\":\"Color\",\"id\":\"1\"},\"options\":{\"id\":\"1\",\"name\":\"Red\"}},{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"4\",\"name\":\"Small\"}}],\"price\":\"11\",\"special_price\":\"11\",\"availability\":\"1\"}', '2024-06-27 01:17:37', '2024-08-01 22:48:42'),
(2, 9, '{\"combo\":[{\"variant\":{\"name\":\"Color\",\"id\":\"1\"},\"options\":{\"id\":\"2\",\"name\":\"Black\"}},{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"4\",\"name\":\"Small\"}}],\"price\":\"22\",\"special_price\":\"22\",\"availability\":\"0\"}', '2024-06-27 01:17:37', NULL),
(3, 9, '{\"combo\":[{\"variant\":{\"name\":\"Color\",\"id\":\"1\"},\"options\":{\"id\":\"1\",\"name\":\"Red\"}},{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"5\",\"name\":\"Medium\"}}],\"price\":\"33\",\"special_price\":\"33\",\"availability\":\"0\"}', '2024-06-27 01:17:37', NULL),
(4, 9, '{\"combo\":[{\"variant\":{\"name\":\"Color\",\"id\":\"1\"},\"options\":{\"id\":\"2\",\"name\":\"Black\"}},{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"5\",\"name\":\"Medium\"}}],\"price\":\"44\",\"special_price\":\"44\",\"availability\":\"0\"}', '2024-06-27 01:17:37', NULL),
(9, 12, '{\"combo\":[{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"4\",\"name\":\"Small\"}},{\"variant\":{\"name\":\"Age\",\"id\":\"3\"},\"options\":{\"id\":\"7\",\"name\":\"1-3\"}}],\"price\":\"11\",\"special_price\":\"11\",\"availability\":\"0\"}', '2024-06-28 01:09:32', NULL),
(10, 12, '{\"combo\":[{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"5\",\"name\":\"Medium\"}},{\"variant\":{\"name\":\"Age\",\"id\":\"3\"},\"options\":{\"id\":\"7\",\"name\":\"1-3\"}}],\"price\":\"2\",\"special_price\":\"22\",\"availability\":\"0\"}', '2024-06-28 01:09:32', NULL),
(11, 12, '{\"combo\":[{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"4\",\"name\":\"Small\"}},{\"variant\":{\"name\":\"Age\",\"id\":\"3\"},\"options\":{\"id\":\"8\",\"name\":\"4-7\"}}],\"price\":\"44\",\"special_price\":\"44\",\"availability\":\"0\"}', '2024-06-28 01:09:32', NULL),
(12, 12, '{\"combo\":[{\"variant\":{\"name\":\"Size\",\"id\":\"2\"},\"options\":{\"id\":\"5\",\"name\":\"Medium\"}},{\"variant\":{\"name\":\"Age\",\"id\":\"3\"},\"options\":{\"id\":\"8\",\"name\":\"4-7\"}}],\"price\":\"77\",\"special_price\":\"77\",\"availability\":\"0\"}', '2024-06-28 01:09:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_item_branches`
--

CREATE TABLE `food_item_branches` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `food_item_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_item_branches`
--

INSERT INTO `food_item_branches` (`id`, `branch_id`, `food_item_id`, `created_at`, `updated_at`) VALUES
(1, 1, 21, '2024-10-04 04:52:26', NULL),
(2, 3, 21, '2024-10-04 04:52:26', NULL),
(4, 3, 22, '2024-11-08 09:20:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_item_properties`
--

CREATE TABLE `food_item_properties` (
  `id` int(11) NOT NULL,
  `food_item_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `property_item_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_item_properties`
--

INSERT INTO `food_item_properties` (`id`, `food_item_id`, `property_id`, `property_item_id`, `created_at`, `updated_at`) VALUES
(4, 22, 2, 4, '2024-11-08 03:20:28', '2024-11-08 03:20:28'),
(5, 22, 4, 8, '2024-11-08 03:20:28', '2024-11-08 03:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `food_item_variants`
--

CREATE TABLE `food_item_variants` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `special_price` float DEFAULT NULL,
  `availability` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_item_variants`
--

INSERT INTO `food_item_variants` (`id`, `item_id`, `price`, `special_price`, `availability`, `created_at`, `updated_at`) VALUES
(33, 17, 99, 99, 0, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(34, 17, 88, 88, 0, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(35, 17, 77, 77, 0, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(36, 17, 66, 66, 1, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(37, 17, 15, 13, 1, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(38, 17, 11, 17, 0, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(69, 9, 10, 10, 0, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(70, 9, 20, 30, 1, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(71, 9, 40, 50, 0, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(72, 9, 60, 70, 1, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(73, 9, 80, 90, 0, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(74, 9, 100, 110, 1, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(75, 21, 10, 20, 0, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(76, 21, 30, 40, 1, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(77, 21, 50, 60, 0, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(78, 21, 70, 80, 1, '2024-10-03 22:52:26', '2024-10-03 22:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `food_item_variant_options`
--

CREATE TABLE `food_item_variant_options` (
  `id` int(11) NOT NULL,
  `food_item_variant_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_item_variant_options`
--

INSERT INTO `food_item_variant_options` (`id`, `food_item_variant_id`, `variant_id`, `option_id`, `created_at`, `updated_at`) VALUES
(64, 33, 1, 1, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(65, 33, 2, 4, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(66, 34, 1, 2, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(67, 34, 2, 4, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(68, 35, 1, 1, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(69, 35, 2, 5, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(70, 36, 1, 2, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(71, 36, 2, 5, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(72, 37, 1, 1, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(73, 37, 2, 6, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(74, 38, 1, 2, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(75, 38, 2, 6, '2024-08-03 08:02:25', '2024-08-03 08:02:25'),
(136, 69, 2, 4, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(137, 69, 3, 7, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(138, 70, 2, 5, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(139, 70, 3, 7, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(140, 71, 2, 4, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(141, 71, 3, 9, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(142, 72, 2, 5, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(143, 72, 3, 9, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(144, 73, 2, 4, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(145, 73, 3, 8, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(146, 74, 2, 5, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(147, 74, 3, 8, '2024-09-13 05:32:20', '2024-09-13 05:32:20'),
(148, 75, 1, 1, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(149, 75, 2, 4, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(150, 76, 1, 2, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(151, 76, 2, 4, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(152, 77, 1, 1, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(153, 77, 2, 5, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(154, 78, 1, 2, '2024-10-03 22:52:26', '2024-10-03 22:52:26'),
(155, 78, 2, 5, '2024-10-03 22:52:26', '2024-10-03 22:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `food_property_groups`
--

CREATE TABLE `food_property_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_property_groups`
--

INSERT INTO `food_property_groups` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Salads', 1, '2024-08-17 03:56:34', NULL),
(2, 'Extras', 1, '2024-08-17 03:56:41', NULL),
(3, 'Add Ons	', 1, '2024-08-17 03:56:49', NULL),
(4, 'Spice Level', 1, '2024-08-16 22:54:48', '2024-08-17 17:51:37'),
(7, 'Test Property', 0, '2024-08-17 18:12:39', '2024-08-17 18:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `food_property_group_items`
--

CREATE TABLE `food_property_group_items` (
  `id` int(11) NOT NULL,
  `property_group_id` int(11) DEFAULT NULL,
  `item_name` varchar(150) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_property_group_items`
--

INSERT INTO `food_property_group_items` (`id`, `property_group_id`, `item_name`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Garden Salad	', 10, 1, '2024-08-17 03:57:50', NULL),
(2, 1, 'Caesar Salad', 25, 0, '2024-08-17 03:58:08', '2024-08-17 18:40:42'),
(3, 1, 'Spinach Salad	', 35, 1, '2024-08-17 03:58:29', NULL),
(4, 2, 'Coca-cola	', 20, 1, '2024-08-17 03:58:52', NULL),
(5, 2, 'Mojito', 30, 1, '2024-08-17 03:59:17', NULL),
(6, 3, 'Beef Bacon	', 20, 1, '2024-08-17 03:59:44', NULL),
(7, 3, 'Mushroom', 40, 1, '2024-08-17 03:59:56', '2024-08-17 04:00:00'),
(8, 4, 'Mild', 20.56, 1, '2024-08-17 00:26:10', '2024-08-17 17:51:46'),
(10, 7, 'Test', 20.56, 1, '2024-08-17 18:13:58', '2024-08-17 18:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `food_variants`
--

CREATE TABLE `food_variants` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_variants`
--

INSERT INTO `food_variants` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Color', '2024-06-06 15:48:33', '2024-06-07 05:20:43'),
(2, 'Size', '2024-06-06 15:49:07', '2024-06-07 05:20:46'),
(3, 'Age', '2024-06-06 15:49:39', '2024-06-07 05:20:50'),
(4, 'Country', '2024-08-15 18:20:03', '2024-08-15 18:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `food_variant_options`
--

CREATE TABLE `food_variant_options` (
  `id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `option_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_variant_options`
--

INSERT INTO `food_variant_options` (`id`, `variant_id`, `option_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Red', '2024-06-06 15:53:19', '2024-08-15 19:47:25'),
(2, 1, 'Black', '2024-06-06 15:53:24', '2024-06-06 15:53:38'),
(3, 1, 'White', '2024-06-06 15:53:35', '2024-06-06 15:53:42'),
(4, 2, 'Small', '2024-06-06 15:53:53', NULL),
(5, 2, 'Medium', '2024-06-06 15:54:03', NULL),
(6, 2, 'Large', '2024-06-06 15:54:12', NULL),
(7, 3, '1-3', '2024-06-06 15:54:27', NULL),
(8, 3, '4-7', '2024-06-06 15:54:37', NULL),
(9, 3, '7-12', '2024-06-06 15:54:48', NULL),
(11, 4, 'Bangladesh', '2024-08-15 19:47:41', '2024-08-15 19:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(150) DEFAULT NULL,
  `key_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `key_name`, `key_value`, `created_at`, `updated_at`) VALUES
(1, 'placeholder_image', '57', NULL, '2024-10-05 06:03:21'),
(2, 'default_lang', '2', NULL, '2024-11-30 13:16:29'),
(3, 'default_branch', NULL, NULL, NULL),
(4, 'default_currency', '12', NULL, '2024-12-02 00:25:54'),
(5, 'currency_position', 'left', NULL, '2024-10-05 04:57:55'),
(6, 'thousands_separator', ',', NULL, '2024-10-05 04:58:44'),
(7, 'decimal_separator', '.', NULL, '2024-10-05 04:58:44'),
(8, 'decimal_position', '2', NULL, '2024-10-05 04:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `table_capacity` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `branch_id`, `name`, `table_capacity`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Hall 08311035', 20, 1, '2024-08-30 22:35:53', '2025-01-01 10:47:30'),
(3, NULL, 'Hall 08311036', 30, 1, '2024-08-30 22:36:41', '2024-08-30 23:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `hat_translate_halls`
--

CREATE TABLE `hat_translate_halls` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hat_translate_halls`
--

INSERT INTO `hat_translate_halls` (`id`, `lang_id`, `hall_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'Hall 08311035', '2024-09-12 22:17:49', '2024-09-12 22:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_rtl` decimal(10,0) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `is_rtl`, `created_at`, `updated_at`) VALUES
(1, 'bn', 'Bangla', 1, '2023-10-25 19:58:49', '2023-12-01 04:55:49'),
(2, 'en', 'English', 1, '2023-10-31 18:00:59', '2023-12-01 04:57:58');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `namespace` text DEFAULT NULL,
  `owner` varchar(150) NOT NULL,
  `version` varchar(150) DEFAULT NULL,
  `type` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `location`, `namespace`, `owner`, `version`, `type`, `status`, `details`, `created_at`, `updated_at`) VALUES
(2, 'Food Plugin', 'food', 'Plugin\\Food\\', 'Owls Lab', '1.0.0', 'core', 1, 'Food adding plugn .Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2024-02-09 12:53:36', NULL),
(3, 'Hall And Table', 'hall_and_table', 'Plugin\\HallAndTable\\', 'Owls Lab', '1.0.0', 'core', 1, 'Food adding plugn .Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2024-08-30 13:26:11', NULL),
(4, 'POS', 'pos', 'Plugin\\Pos\\', 'Owls Lab', '1.0.0', 'core', 1, 'Food adding plugn .Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2024-10-16 00:19:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pos_order_status`
--

CREATE TABLE `pos_order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_order_status`
--

INSERT INTO `pos_order_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Delivered', '2024-12-08 00:22:17', NULL),
(2, 'Pending', '2024-12-08 00:22:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `hall_id` int(11) DEFAULT NULL,
  `table_number` varchar(50) DEFAULT NULL,
  `shape` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `chair_limit` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `hall_id`, `table_number`, `shape`, `type`, `chair_limit`, `status`, `created_at`, `updated_at`) VALUES
(6, 3, '1', '3', 3, 3, 2, '2024-09-01 10:14:08', '2024-12-23 18:46:23'),
(7, 2, '5', '2', 4, 25, 1, '2025-01-01 10:48:42', '2025-01-01 10:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_categories`
--

CREATE TABLE `translate_food_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `meta_title` varchar(50) DEFAULT NULL,
  `meta_description` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_categories`
--

INSERT INTO `translate_food_categories` (`id`, `category_id`, `lang_id`, `name`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'কেক', 'কেক', 'এটি একটি সাধারণ কেক বিভাগ', '2024-05-01 07:52:58', '2024-05-03 03:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_items`
--

CREATE TABLE `translate_food_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `meta_title` varchar(150) DEFAULT NULL,
  `meta_description` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_items`
--

INSERT INTO `translate_food_items` (`id`, `item_id`, `lang_id`, `name`, `details`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 'Aubrey Roy 001', 'Minus consequatur n 001', 'Omnis eligendi quod 001', 'meta description 001', '2024-08-07 08:03:21', '2024-08-07 08:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_property_groups`
--

CREATE TABLE `translate_food_property_groups` (
  `id` int(11) NOT NULL,
  `property_group_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_property_groups`
--

INSERT INTO `translate_food_property_groups` (`id`, `property_group_id`, `lang_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'Test Property 02', '2024-08-17 18:13:38', '2024-08-17 18:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_property_group_items`
--

CREATE TABLE `translate_food_property_group_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `item_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_property_group_items`
--

INSERT INTO `translate_food_property_group_items` (`id`, `item_id`, `lang_id`, `item_name`, `created_at`, `updated_at`) VALUES
(1, 10, 1, 'Test 123', '2024-08-17 18:14:07', '2024-08-17 18:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_variants`
--

CREATE TABLE `translate_food_variants` (
  `id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_variants`
--

INSERT INTO `translate_food_variants` (`id`, `variant_id`, `lang_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'Color01', '2024-08-15 21:10:30', '2024-08-15 21:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `translate_food_variant_options`
--

CREATE TABLE `translate_food_variant_options` (
  `id` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `lang_id` int(11) DEFAULT NULL,
  `option_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `translate_food_variant_options`
--

INSERT INTO `translate_food_variant_options` (`id`, `option_id`, `lang_id`, `option_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Red01', '2024-08-15 21:48:41', '2024-08-15 21:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `file_type` varchar(150) NOT NULL,
  `file_extension` varchar(150) DEFAULT NULL,
  `file_size` varchar(150) NOT NULL,
  `file_location` text NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `name`, `file_type`, `file_extension`, `file_size`, `file_location`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(18, '1702140255_8917.jpg', 'image/jpeg', 'jpg', '458834', 'uploads/2023/12/1702140255_8917.jpg', 1, '2023-12-09 10:44:15', '2023-12-09 10:44:15'),
(20, '1702140295_7108ba5bb43b4a0a4226be4a69a7d295_360.png', 'image/png', 'png', '52904', 'uploads/2023/12/1702140295_7108ba5bb43b4a0a4226be4a69a7d295_360.png', 1, '2023-12-09 10:44:55', '2023-12-09 10:44:55'),
(24, '1702170819_1702140255_8917.jpg', 'image/jpeg', 'jpg', '458834', 'uploads/2023/12/1702170819_1702140255_8917.jpg', 1, '2023-12-09 19:13:39', '2023-12-09 19:13:39'),
(25, '1702174661_img-09_987.png', 'image/png', 'png', '113868', 'uploads/2023/12/1702174661_img-09_987.png', 1, '2023-12-09 20:17:41', '2023-12-09 20:17:41'),
(30, '1702255851_1702140255_8917.jpg', 'image/jpeg', 'jpg', '458834', 'uploads/2023/12/1702255851_1702140255_8917.jpg', 1, '2023-12-10 18:50:51', '2023-12-10 18:50:51'),
(31, '1702255854_1702140288_black_background_logo.jpg', 'image/jpeg', 'jpg', '38816', 'uploads/2023/12/1702255854_1702140288_black_background_logo.jpg', 1, '2023-12-10 18:50:54', '2023-12-10 18:50:54'),
(32, '1702255855_1702140295_7108ba5bb43b4a0a4226be4a69a7d295_360.png', 'image/png', 'png', '52904', 'uploads/2023/12/1702255855_1702140295_7108ba5bb43b4a0a4226be4a69a7d295_360.png', 1, '2023-12-10 18:50:55', '2023-12-10 18:50:55'),
(36, '1702255865_1702170819_1702140255_8917.jpg', 'image/jpeg', 'jpg', '458834', 'uploads/2023/12/1702255865_1702170819_1702140255_8917.jpg', 1, '2023-12-10 18:51:05', '2023-12-10 18:51:05'),
(37, '1702255866_1702174661_img-09_987.png', 'image/png', 'png', '113868', 'uploads/2023/12/1702255866_1702174661_img-09_987.png', 1, '2023-12-10 18:51:06', '2023-12-10 18:51:06'),
(44, '1702397077_walter-white-breaking-bad-wallpaper-preview.jpg', 'image/jpeg', 'jpg', '82393', 'uploads/2023/12/1702397077_walter-white-breaking-bad-wallpaper-preview.jpg', 1, '2023-12-12 10:04:37', '2023-12-12 10:04:37'),
(45, '1702397236_pexels-karl-gerber-1640556.jpg', 'image/jpeg', 'jpg', '2691729', 'uploads/2023/12/1702397236_pexels-karl-gerber-1640556.jpg', 1, '2023-12-12 10:07:16', '2023-12-12 10:07:16'),
(47, '1702397266_pexels-karl-gerber-1640556.jpg', 'image/jpeg', 'jpg', '2691729', 'uploads/2023/12/1702397266_pexels-karl-gerber-1640556.jpg', 1, '2023-12-12 10:07:46', '2023-12-12 10:07:46'),
(48, '1702397287_walter-white-breaking-bad-wallpaper-preview.jpg', 'image/jpeg', 'jpg', '82393', 'uploads/2023/12/1702397287_walter-white-breaking-bad-wallpaper-preview.jpg', 1, '2023-12-12 10:08:07', '2023-12-12 10:08:07'),
(50, '1702397465_Group 23 (2).png', 'image/png', 'png', '2056', 'uploads/2023/12/1702397465_Group 23 (2).png', 1, '2023-12-12 10:11:05', '2023-12-12 10:11:05'),
(51, '1702397465_pexels-karl-gerber-1640556.jpg', 'image/jpeg', 'jpg', '2691729', 'uploads/2023/12/1702397465_pexels-karl-gerber-1640556.jpg', 1, '2023-12-12 10:11:05', '2023-12-12 10:11:05'),
(52, '1702398128_AdminLTE 3  DataTables (1).pdf', 'application/pdf', 'pdf', '24542', 'uploads/2023/12/1702398128_AdminLTE 3  DataTables (1).pdf', 1, '2023-12-12 10:22:08', '2023-12-12 10:22:08'),
(53, '1702399194_dwsample mp4 360p.mp4', 'video/mp4', 'mp4', '4553606', 'uploads/2023/12/1702399194_dwsample mp4 360p.mp4', 1, '2023-12-12 10:39:54', '2023-12-12 10:39:54'),
(54, '1702399337_sample-3s.mp3', 'audio/mpeg', 'mp3', '52079', 'uploads/2023/12/1702399337_sample-3s.mp3', 1, '2023-12-12 10:42:17', '2023-12-12 10:42:17'),
(55, '1702399519_file_example_MP3_700KB.zip', 'application/zip', 'zip', '723405', 'uploads/2023/12/1702399519_file_example_MP3_700KB.zip', 1, '2023-12-12 10:45:19', '2023-12-12 10:45:19'),
(57, '1708180783_istockphoto-1147544807-612x612.jpg', 'image/jpeg', 'jpg', '7568', 'uploads/2024/02/1708180783_istockphoto-1147544807-612x612.jpg', 1, '2024-02-17 08:39:43', '2024-02-17 08:39:43'),
(58, '1709656800_david-holifield-kPxsqUGneXQ-unsplash.jpg', 'image/jpeg', 'jpg', '1076939', 'uploads/2024/03/1709656800_david-holifield-kPxsqUGneXQ-unsplash.jpg', 1, '2024-03-05 10:40:00', '2024-03-05 10:40:00'),
(59, '1709717740_ben-lei-flFd8L7_B3g-unsplash.jpg', 'image/jpeg', 'jpg', '1361243', 'uploads/2024/03/1709717740_ben-lei-flFd8L7_B3g-unsplash.jpg', 1, '2024-03-06 03:35:40', '2024-03-06 03:35:40'),
(60, '1709717740_vit-ch-Oxb84ENcFfU-unsplash.jpg', 'image/jpeg', 'jpg', '2207993', 'uploads/2024/03/1709717740_vit-ch-Oxb84ENcFfU-unsplash.jpg', 1, '2024-03-06 03:35:40', '2024-03-06 03:35:40'),
(61, '1709717762_amirali-mirhashemian-sc5sTPMrVfk-unsplash.jpg', 'image/jpeg', 'jpg', '2313952', 'uploads/2024/03/1709717762_amirali-mirhashemian-sc5sTPMrVfk-unsplash.jpg', 1, '2024-03-06 03:36:02', '2024-03-06 03:36:02'),
(62, '1709717803_ben-lei-flFd8L7_B3g-unsplash.jpg', 'image/jpeg', 'jpg', '1361243', 'uploads/2024/03/1709717803_ben-lei-flFd8L7_B3g-unsplash.jpg', 1, '2024-03-06 03:36:43', '2024-03-06 03:36:43'),
(63, '1709717803_vit-ch-Oxb84ENcFfU-unsplash.jpg', 'image/jpeg', 'jpg', '2207993', 'uploads/2024/03/1709717803_vit-ch-Oxb84ENcFfU-unsplash.jpg', 1, '2024-03-06 03:36:43', '2024-03-06 03:36:43'),
(75, '1714098619_Emarat Hossain Photograph.jpg', 'image/jpeg', 'jpg', '17634', 'uploads/2024/04/1714098619_Emarat Hossain Photograph.jpg', 1, '2024-04-25 20:30:19', '2024-04-25 20:30:19'),
(76, '1714098620_Untitled-1.pdf', 'application/pdf', 'pdf', '7136761', 'uploads/2024/04/1714098620_Untitled-1.pdf', 1, '2024-04-25 20:30:20', '2024-04-25 20:30:20'),
(77, '1714098922_Untitled-1.pdf', 'application/pdf', 'pdf', '7136761', 'uploads/2024/04/1714098922_Untitled-1.pdf', 1, '2024-04-25 20:35:22', '2024-04-25 20:35:22'),
(78, '1714099079_Appointment Letter From Arraytics-PHP Software Engineer - Md. Emarat Hossain Badhon.pdf', 'application/pdf', 'pdf', '1130430', 'uploads/2024/04/1714099079_Appointment Letter From Arraytics-PHP Software Engineer - Md. Emarat Hossain Badhon.pdf', 1, '2024-04-25 20:37:59', '2024-04-25 20:37:59'),
(79, '1714104949_85463.jpg', 'image/jpeg', 'jpg', '1897594', 'uploads/2024/04/1714104949_85463.jpg', 1, '2024-04-25 22:15:49', '2024-04-25 22:15:49'),
(80, '1714322254_22769914_6690291.jpg', 'image/jpeg', 'jpg', '267327', 'uploads/2024/04/1714322254_22769914_6690291.jpg', 1, '2024-04-28 10:37:35', '2024-04-28 10:37:35');

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
(1, 'Admin', 'admin@example.com', NULL, '$2y$10$FaVxfM7bIaxGFuDmfHmhhOVSY6nhIZrWVscfVMPO/mtSsA87Zm.xK', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_branches`
--
ALTER TABLE `core_branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `core_currencies`
--
ALTER TABLE `core_currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `core_customers`
--
ALTER TABLE `core_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `core_order_status`
--
ALTER TABLE `core_order_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `core_order_types`
--
ALTER TABLE `core_order_types`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `core_taxes`
--
ALTER TABLE `core_taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `tax_name` (`tax_name`);

--
-- Indexes for table `core_translate_branches`
--
ALTER TABLE `core_translate_branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_core_translate_branches_core_branches` (`branch_id`),
  ADD KEY `FK_core_translate_branches_languages` (`lang_id`);

--
-- Indexes for table `core_translate_order_status`
--
ALTER TABLE `core_translate_order_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_core_translate_order_status_languages` (`lang_id`),
  ADD KEY `FK_core_translate_order_status_core_order_status` (`order_status_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `food_categories`
--
ALTER TABLE `food_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_ibfk_1` (`parent`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_food_itmes_food_categories` (`category`);

--
-- Indexes for table `food_items_variant_combos`
--
ALTER TABLE `food_items_variant_combos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_item_branches`
--
ALTER TABLE `food_item_branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_item_properties`
--
ALTER TABLE `food_item_properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_item_variants`
--
ALTER TABLE `food_item_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_food_item_variants_food_items` (`item_id`);

--
-- Indexes for table `food_item_variant_options`
--
ALTER TABLE `food_item_variant_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_food_item_variant_options_food_item_variants` (`food_item_variant_id`),
  ADD KEY `FK_food_item_variant_options_food_variants` (`variant_id`),
  ADD KEY `FK_food_item_variant_options_food_variant_options` (`option_id`);

--
-- Indexes for table `food_property_groups`
--
ALTER TABLE `food_property_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_property_group_items`
--
ALTER TABLE `food_property_group_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_food_property_group_items_food_property_groups` (`property_group_id`);

--
-- Indexes for table `food_variants`
--
ALTER TABLE `food_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `food_variant_options`
--
ALTER TABLE `food_variant_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_food_variant_options_food_variant` (`variant_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_halls_core_branches` (`branch_id`);

--
-- Indexes for table `hat_translate_halls`
--
ALTER TABLE `hat_translate_halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_hat_translate_hall_languages` (`lang_id`),
  ADD KEY `FK_hat_translate_hall_halls` (`hall_id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_order_status`
--
ALTER TABLE `pos_order_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_tables_halls` (`hall_id`);

--
-- Indexes for table `translate_food_categories`
--
ALTER TABLE `translate_food_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_translate_food_categories_food_categories` (`category_id`),
  ADD KEY `FK_translate_food_categories_food_categories_2` (`lang_id`);

--
-- Indexes for table `translate_food_items`
--
ALTER TABLE `translate_food_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_translate_food_items_food_items` (`item_id`),
  ADD KEY `FK_translate_food_items_languages` (`lang_id`);

--
-- Indexes for table `translate_food_property_groups`
--
ALTER TABLE `translate_food_property_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_translate_food_property_groups_food_property_groups` (`property_group_id`);

--
-- Indexes for table `translate_food_property_group_items`
--
ALTER TABLE `translate_food_property_group_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `FK_translate_food_property_group_items_food_property_group_items` (`item_id`);

--
-- Indexes for table `translate_food_variants`
--
ALTER TABLE `translate_food_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `translate_food_variant_options`
--
ALTER TABLE `translate_food_variant_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
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
-- AUTO_INCREMENT for table `core_branches`
--
ALTER TABLE `core_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_currencies`
--
ALTER TABLE `core_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `core_customers`
--
ALTER TABLE `core_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_order_status`
--
ALTER TABLE `core_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `core_order_types`
--
ALTER TABLE `core_order_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `core_taxes`
--
ALTER TABLE `core_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_translate_branches`
--
ALTER TABLE `core_translate_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_translate_order_status`
--
ALTER TABLE `core_translate_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_categories`
--
ALTER TABLE `food_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `food_items_variant_combos`
--
ALTER TABLE `food_items_variant_combos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `food_item_branches`
--
ALTER TABLE `food_item_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food_item_properties`
--
ALTER TABLE `food_item_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_item_variants`
--
ALTER TABLE `food_item_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `food_item_variant_options`
--
ALTER TABLE `food_item_variant_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `food_property_groups`
--
ALTER TABLE `food_property_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `food_property_group_items`
--
ALTER TABLE `food_property_group_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `food_variants`
--
ALTER TABLE `food_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_variant_options`
--
ALTER TABLE `food_variant_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hat_translate_halls`
--
ALTER TABLE `hat_translate_halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pos_order_status`
--
ALTER TABLE `pos_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `translate_food_categories`
--
ALTER TABLE `translate_food_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `translate_food_items`
--
ALTER TABLE `translate_food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `translate_food_property_groups`
--
ALTER TABLE `translate_food_property_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `translate_food_property_group_items`
--
ALTER TABLE `translate_food_property_group_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `translate_food_variants`
--
ALTER TABLE `translate_food_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `translate_food_variant_options`
--
ALTER TABLE `translate_food_variant_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `core_translate_branches`
--
ALTER TABLE `core_translate_branches`
  ADD CONSTRAINT `FK_core_translate_branches_core_branches` FOREIGN KEY (`branch_id`) REFERENCES `core_branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_core_translate_branches_languages` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `core_translate_order_status`
--
ALTER TABLE `core_translate_order_status`
  ADD CONSTRAINT `FK_core_translate_order_status_core_order_status` FOREIGN KEY (`order_status_id`) REFERENCES `core_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_core_translate_order_status_languages` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `food_categories`
--
ALTER TABLE `food_categories`
  ADD CONSTRAINT `food_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `food_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `FK_food_itmes_food_categories` FOREIGN KEY (`category`) REFERENCES `food_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `food_item_variants`
--
ALTER TABLE `food_item_variants`
  ADD CONSTRAINT `FK_food_item_variants_food_items` FOREIGN KEY (`item_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_item_variant_options`
--
ALTER TABLE `food_item_variant_options`
  ADD CONSTRAINT `FK_food_item_variant_options_food_item_variants` FOREIGN KEY (`food_item_variant_id`) REFERENCES `food_item_variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_food_item_variant_options_food_variant_options` FOREIGN KEY (`option_id`) REFERENCES `food_variant_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_food_item_variant_options_food_variants` FOREIGN KEY (`variant_id`) REFERENCES `food_variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_property_group_items`
--
ALTER TABLE `food_property_group_items`
  ADD CONSTRAINT `FK_food_property_group_items_food_property_groups` FOREIGN KEY (`property_group_id`) REFERENCES `food_property_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_variant_options`
--
ALTER TABLE `food_variant_options`
  ADD CONSTRAINT `FK_food_variant_options_food_variant` FOREIGN KEY (`variant_id`) REFERENCES `food_variants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `FK_halls_core_branches` FOREIGN KEY (`branch_id`) REFERENCES `core_branches` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hat_translate_halls`
--
ALTER TABLE `hat_translate_halls`
  ADD CONSTRAINT `FK_hat_translate_hall_halls` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_hat_translate_hall_languages` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `FK_tables_halls` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translate_food_categories`
--
ALTER TABLE `translate_food_categories`
  ADD CONSTRAINT `FK_translate_food_categories_food_categories` FOREIGN KEY (`category_id`) REFERENCES `food_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_translate_food_categories_food_categories_2` FOREIGN KEY (`lang_id`) REFERENCES `food_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translate_food_items`
--
ALTER TABLE `translate_food_items`
  ADD CONSTRAINT `FK_translate_food_items_food_items` FOREIGN KEY (`item_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_translate_food_items_languages` FOREIGN KEY (`lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translate_food_property_groups`
--
ALTER TABLE `translate_food_property_groups`
  ADD CONSTRAINT `FK_translate_food_property_groups_food_property_groups` FOREIGN KEY (`property_group_id`) REFERENCES `food_property_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `translate_food_property_group_items`
--
ALTER TABLE `translate_food_property_group_items`
  ADD CONSTRAINT `FK_translate_food_property_group_items_food_property_group_items` FOREIGN KEY (`item_id`) REFERENCES `food_property_group_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
