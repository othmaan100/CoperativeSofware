-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2026 at 06:38 PM
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
-- Database: `fcecoop`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_name` varchar(255) DEFAULT NULL,
  `causer_email` varchar(255) DEFAULT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `causer_id`, `causer_name`, `causer_email`, `subject_type`, `subject_id`, `action`, `description`, `properties`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:07:20'),
(2, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.logout', 'Treasurer logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:08:13'),
(3, 1, 'System Administrator', 'admin@fcetpotiskum.com.ng', 'App\\Models\\User', 1, 'auth.login', 'System Administrator logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:08:52'),
(4, 1, 'System Administrator', 'admin@fcetpotiskum.com.ng', 'App\\Models\\User', 1, 'auth.logout', 'System Administrator logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:09:43'),
(5, 3, 'Chairman', 'chairman@fcetpotiskum.com.ng', 'App\\Models\\User', 3, 'auth.login', 'Chairman logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:14:13'),
(6, 3, 'Chairman', 'chairman@fcetpotiskum.com.ng', 'App\\Models\\User', 3, 'auth.logout', 'Chairman logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:14:49'),
(7, 4, 'Secretary', 'secretary@fcetpotiskum.com.ng', 'App\\Models\\User', 4, 'auth.login', 'Secretary logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:16:05'),
(8, 4, 'Secretary', 'secretary@fcetpotiskum.com.ng', 'App\\Models\\User', 4, 'auth.logout', 'Secretary logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:17:16'),
(9, 5, 'Store Officer', 'store.officer@fcetpotiskum.com.ng', 'App\\Models\\User', 5, 'auth.login', 'Store Officer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:17:45'),
(10, 5, 'Store Officer', 'store.officer@fcetpotiskum.com.ng', 'App\\Models\\User', 5, 'auth.logout', 'Store Officer logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:18:41'),
(11, 6, 'Auditor', 'auditor@fcetpotiskum.com.ng', 'App\\Models\\User', 6, 'auth.login', 'Auditor logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:19:08'),
(12, 6, 'Auditor', 'auditor@fcetpotiskum.com.ng', 'App\\Models\\User', 6, 'auth.logout', 'Auditor logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:19:41'),
(13, 7, 'Exco Member', 'exco@fcetpotiskum.com.ng', 'App\\Models\\User', 7, 'auth.login', 'Exco Member logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:20:35'),
(14, 7, 'Exco Member', 'exco@fcetpotiskum.com.ng', 'App\\Models\\User', 7, 'auth.logout', 'Exco Member logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:21:08'),
(15, 8, 'Loan Officer', 'loan.officer@fcetpotiskum.com.ng', 'App\\Models\\User', 8, 'auth.login', 'Loan Officer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-02 15:21:55'),
(16, 1, 'System Administrator', 'admin@fcetpotiskum.com.ng', 'App\\Models\\User', 1, 'auth.login', 'System Administrator logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 03:51:03'),
(17, 1, 'System Administrator', 'admin@fcetpotiskum.com.ng', 'App\\Models\\User', 1, 'auth.logout', 'System Administrator logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 03:51:22'),
(18, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 03:52:02'),
(19, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:31:09'),
(20, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 1, 'member.imported', 'Imported legacy member MAMUDA ABDULLAHI (FCE100192).', '{\"staff_id\":\"FCE100192\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:08'),
(21, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 2, 'member.imported', 'Imported legacy member ADAM UMAR ABBA (FCE100631).', '{\"staff_id\":\"FCE100631\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:09'),
(22, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 3, 'member.imported', 'Imported legacy member MOHAMMED MOHAMMED ARDO (FCE100713).', '{\"staff_id\":\"FCE100713\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:09'),
(23, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 4, 'member.imported', 'Imported legacy member JIBRIN HASHIMU GUNDA (FCE100778).', '{\"staff_id\":\"FCE100778\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:10'),
(24, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 5, 'member.imported', 'Imported legacy member DALA ADAMU GARBA (FCE100887).', '{\"staff_id\":\"FCE100887\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:10'),
(25, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 6, 'member.imported', 'Imported legacy member ABUBAKAR SAIDU ALHASSAN (FCE100182).', '{\"staff_id\":\"FCE100182\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:11'),
(26, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 7, 'member.imported', 'Imported legacy member ILIYASU MUSA YUSUF (FCE100733).', '{\"staff_id\":\"FCE100733\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:12'),
(27, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 8, 'member.imported', 'Imported legacy member MUNTARI SAAD (FCE100726).', '{\"staff_id\":\"FCE100726\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:12'),
(28, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 9, 'member.imported', 'Imported legacy member WAKILI BALA ADAMU (FCE100832).', '{\"staff_id\":\"FCE100832\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:13'),
(29, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 10, 'member.imported', 'Imported legacy member BABA AJIYA IDRISSA (FCE100843).', '{\"staff_id\":\"FCE100843\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:13'),
(30, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 11, 'member.imported', 'Imported legacy member GHULUZE MUHAMMAD IBN (FCE100861).', '{\"staff_id\":\"FCE100861\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:14'),
(31, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 12, 'member.imported', 'Imported legacy member LUCCU AJIYA MAINA (FCE100782).', '{\"staff_id\":\"FCE100782\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:15'),
(32, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 13, 'member.imported', 'Imported legacy member GIMBA ISMAILA MOHAMMED (FCE100851).', '{\"staff_id\":\"FCE100851\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:15'),
(33, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 14, 'member.imported', 'Imported legacy member BAWAJI HAUWA ABDU (FCE100215).', '{\"staff_id\":\"FCE100215\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:16'),
(34, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 15, 'member.imported', 'Imported legacy member MIDALA ZAKARIYAU HARUNA (FCE100913).', '{\"staff_id\":\"FCE100913\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:16'),
(35, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 16, 'member.imported', 'Imported legacy member HAMZA SULEIMAN (FCE101060).', '{\"staff_id\":\"FCE101060\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:17'),
(36, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 17, 'member.imported', 'Imported legacy member MANGA MUSA (FCE200056).', '{\"staff_id\":\"FCE200056\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:18'),
(37, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 18, 'member.imported', 'Imported legacy member SHAMAKI AYUBA YAKUBU (FCE100737).', '{\"staff_id\":\"FCE100737\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:18'),
(38, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 19, 'member.imported', 'Imported legacy member BARDE IDRISS IBRAHIM (FCE100731).', '{\"staff_id\":\"FCE100731\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:19'),
(39, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 20, 'member.imported', 'Imported legacy member ABDULKADIR ABDULKARIM OLATUNJI (FCE101191).', '{\"staff_id\":\"FCE101191\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:19'),
(40, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 21, 'member.imported', 'Imported legacy member YERIMA MUSA MAMMAN (FCE1001017).', '{\"staff_id\":\"FCE1001017\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:20'),
(41, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 22, 'member.imported', 'Imported legacy member BADAWI MUHAMMAD HASSAN (FCE101020).', '{\"staff_id\":\"FCE101020\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:20'),
(42, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 23, 'member.imported', 'Imported legacy member MUSA ABUBAKAR (FCE101085).', '{\"staff_id\":\"FCE101085\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:21'),
(43, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 24, 'member.imported', 'Imported legacy member BAH UMAR M (FCE100380).', '{\"staff_id\":\"FCE100380\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:21'),
(44, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 25, 'member.imported', 'Imported legacy member MUSA SAADATU MIRINGA (FCE200042).', '{\"staff_id\":\"FCE200042\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:22'),
(45, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 26, 'member.imported', 'Imported legacy member GEIDAM HADIZA BABA (FCE100736).', '{\"staff_id\":\"FCE100736\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:22'),
(46, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 27, 'member.imported', 'Imported legacy member NWARE HARUNA IDRIS (FCE100514).', '{\"staff_id\":\"FCE100514\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:23'),
(47, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 28, 'member.imported', 'Imported legacy member YAMARKUMI AHMAD MUHAMMAD (FCE101139).', '{\"staff_id\":\"FCE101139\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:24'),
(48, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 29, 'member.imported', 'Imported legacy member USMAN IBRAHIM GOJI (FCE100709).', '{\"staff_id\":\"FCE100709\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:24'),
(49, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 30, 'member.imported', 'Imported legacy member HUSSAINI ISHIYAKU (FCE101232).', '{\"staff_id\":\"FCE101232\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:25'),
(50, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 31, 'member.imported', 'Imported legacy member HARUNA ALIYU (FCE101235).', '{\"staff_id\":\"FCE101235\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:25'),
(51, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 32, 'member.imported', 'Imported legacy member ABUBAKAR MOHAMMED BOJUDE (FCE101244).', '{\"staff_id\":\"FCE101244\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:26'),
(52, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 33, 'member.imported', 'Imported legacy member RABIU YAHUZA GARBA (FCE101228).', '{\"staff_id\":\"FCE101228\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:26'),
(53, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 34, 'member.imported', 'Imported legacy member MUHAMMAD BINTA MUSA (FCE101387).', '{\"staff_id\":\"FCE101387\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:27'),
(54, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 35, 'member.imported', 'Imported legacy member CHIBOK HAUWA WAKIL (FCE200065).', '{\"staff_id\":\"FCE200065\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:28'),
(55, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 36, 'member.imported', 'Imported legacy member SULEIMAN ABUBAKAR (FCE200067).', '{\"staff_id\":\"FCE200067\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:28'),
(56, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 37, 'member.imported', 'Imported legacy member MOHAMMED SALEH (FCE101041).', '{\"staff_id\":\"FCE101041\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:29'),
(57, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 38, 'member.imported', 'Imported legacy member ADAMU UMAR KWAMI (FCE1001043).', '{\"staff_id\":\"FCE1001043\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:29'),
(58, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 39, 'member.imported', 'Imported legacy member SHETTIMA ALHAJI SHEHU (FCE100720).', '{\"staff_id\":\"FCE100720\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:30'),
(59, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 40, 'member.imported', 'Imported legacy member SAFIYANU GARBA (FCE1001024).', '{\"staff_id\":\"FCE1001024\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:30'),
(60, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 41, 'member.imported', 'Imported legacy member TONTI ALIYU MOHAMMED (FCE101061).', '{\"staff_id\":\"FCE101061\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:31'),
(61, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 42, 'member.imported', 'Imported legacy member MOHAMMED AHMED GIDADO (FCE101208).', '{\"staff_id\":\"FCE101208\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:32'),
(62, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.logout', 'Treasurer logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:32:51'),
(63, 10, 'ADAM UMAR ABBA', 'fce100631@no-email.fcetpcoop.local', 'App\\Models\\User', 10, 'auth.login', 'ADAM UMAR ABBA logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:33:05'),
(64, 10, 'ADAM UMAR ABBA', 'director@mailinator.com', 'App\\Models\\User', 10, 'auth.logout', 'ADAM UMAR ABBA logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:36:26'),
(65, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 11:36:37'),
(66, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/153.0.8010.12 Safari/537.36', '2026-10-03 12:26:46'),
(67, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/153.0.8010.12 Safari/537.36', '2026-10-03 12:27:44'),
(68, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Symfony', '2026-10-03 12:32:30'),
(69, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.logout', 'Treasurer logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 12:43:54'),
(70, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 12:44:01'),
(71, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Symfony', '2026-10-03 12:48:07'),
(73, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 1, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-06 (42 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-06\",\"contributions\":42,\"share_purchases\":0,\"total_amount\":662000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 12:51:01'),
(74, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.logout', 'Treasurer logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 12:51:13'),
(75, 10, 'ADAM UMAR ABBA', 'director@mailinator.com', 'App\\Models\\User', 10, 'auth.login', 'ADAM UMAR ABBA logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 12:51:24'),
(76, 10, 'ADAM UMAR ABBA', 'director@mailinator.com', 'App\\Models\\User', 10, 'auth.logout', 'ADAM UMAR ABBA logged out.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 13:59:03'),
(77, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\User', 2, 'auth.login', 'Treasurer logged in.', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 13:59:43'),
(78, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 43, 'member.imported', 'Imported legacy member MOHAMMED ABUBAKAR (FCE100205).', '{\"staff_id\":\"FCE100205\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:24:47'),
(79, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 44, 'member.imported', 'Imported legacy member BASHIR HASHIMU (FCE101215).', '{\"staff_id\":\"FCE101215\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:24:47'),
(80, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 45, 'member.imported', 'Imported legacy member MOHAMMED IBRAHIM (FCE101268).', '{\"staff_id\":\"FCE101268\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:24:47'),
(81, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 2, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-07 (42 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-07\",\"contributions\":42,\"share_purchases\":0,\"total_amount\":652000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:25:43'),
(82, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 46, 'member.imported', 'Imported legacy member DR YUNUSA MOHAMMED MADU (FCE100141).', '{\"staff_id\":\"FCE100141\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:23'),
(83, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 47, 'member.imported', 'Imported legacy member MUHAMMAD HASSAN NDAMAN (FCE100080).', '{\"staff_id\":\"FCE100080\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:23'),
(84, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 48, 'member.imported', 'Imported legacy member YAU IBRAHIM (FCE100870).', '{\"staff_id\":\"FCE100870\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:24'),
(85, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 49, 'member.imported', 'Imported legacy member FAROUK MARYAM UMAR (FCE100337).', '{\"staff_id\":\"FCE100337\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:24'),
(86, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 50, 'member.imported', 'Imported legacy member BARDE FATIMA ABUBAKAR (FCE100732).', '{\"staff_id\":\"FCE100732\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:25'),
(87, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 51, 'member.imported', 'Imported legacy member ILUOBE MARY MODUPE (FCE101076).', '{\"staff_id\":\"FCE101076\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:26'),
(88, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 52, 'member.imported', 'Imported legacy member ABDULLAHI AISHA ALKALI (FCE200002).', '{\"staff_id\":\"FCE200002\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:26'),
(89, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 53, 'member.imported', 'Imported legacy member ALI MOHAMMED (FCE100696).', '{\"staff_id\":\"FCE100696\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:27'),
(90, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 54, 'member.imported', 'Imported legacy member SHUAIBU ZAKAR YA\'U (FCE101380).', '{\"staff_id\":\"FCE101380\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:27'),
(91, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 55, 'member.imported', 'Imported legacy member ABDULKADIR SAIDU (FCE101140).', '{\"staff_id\":\"FCE101140\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:28'),
(92, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 56, 'member.imported', 'Imported legacy member MUSTAPHA AISHATU FIKA (FCE101231).', '{\"staff_id\":\"FCE101231\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:29'),
(93, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 57, 'member.imported', 'Imported legacy member LAWAN YAKUBU SAIDU (FCE200057).', '{\"staff_id\":\"FCE200057\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:29'),
(94, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 58, 'member.imported', 'Imported legacy member MUHAMMAD YUSUF MUHAMMAD (FCE101423).', '{\"staff_id\":\"FCE101423\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:28:30'),
(95, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 3, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-08 (45 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-08\",\"contributions\":45,\"share_purchases\":0,\"total_amount\":682000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:29:16'),
(96, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 59, 'member.imported', 'Imported legacy member HASSAN MUHAMMAD ABBA (FCE100848).', '{\"staff_id\":\"FCE100848\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:30:58'),
(97, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 60, 'member.imported', 'Imported legacy member USMAN NANA (FCE100674).', '{\"staff_id\":\"FCE100674\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:30:59'),
(98, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 61, 'member.imported', 'Imported legacy member DAUDA YAHAYA ALHAJI (FCE100911).', '{\"staff_id\":\"FCE100911\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:30:59'),
(99, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 62, 'member.imported', 'Imported legacy member GARBA ASABE YUSUF (FCE200008).', '{\"staff_id\":\"FCE200008\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:00'),
(100, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 63, 'member.imported', 'Imported legacy member BADEJO HARUNA ABUBAKAR (FCE100789).', '{\"staff_id\":\"FCE100789\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:00'),
(101, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 64, 'member.imported', 'Imported legacy member KALLAMU ISA IBRAHIM (FCE101057).', '{\"staff_id\":\"FCE101057\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:01'),
(102, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 65, 'member.imported', 'Imported legacy member DISA ABUBAKAR (FCE100366).', '{\"staff_id\":\"FCE100366\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:01'),
(103, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 66, 'member.imported', 'Imported legacy member YUSUF HAMZA MUSA (FCE100702).', '{\"staff_id\":\"FCE100702\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:02'),
(104, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 4, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-09 (58 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-09\",\"contributions\":58,\"share_purchases\":0,\"total_amount\":882000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:31:47'),
(105, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 5, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-10 (66 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-10\",\"contributions\":66,\"share_purchases\":0,\"total_amount\":962000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:41:07'),
(106, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 67, 'member.imported', 'Imported legacy member ZARMA BABAYO BOMOI (FCE100939).', '{\"staff_id\":\"FCE100939\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:42:58'),
(107, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 68, 'member.imported', 'Imported legacy member MOHAMMED AUDU (FCE101259).', '{\"staff_id\":\"FCE101259\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:42:59'),
(108, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 6, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-11 (66 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-11\",\"contributions\":66,\"share_purchases\":0,\"total_amount\":942000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:44:31'),
(109, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 7, 'savings.contribution_batch_posted', 'Posted contribution batch for 2025-12 (68 contribution(s), 0 share purchase(s)).', '{\"period\":\"2025-12\",\"contributions\":68,\"share_purchases\":0,\"total_amount\":1002000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:46:47'),
(110, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 8, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-01 (68 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-01\",\"contributions\":68,\"share_purchases\":0,\"total_amount\":1002000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 14:47:50'),
(111, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 69, 'member.imported', 'Imported legacy member BUNDI ALHAJI GAMBO (FCE101378).', '{\"staff_id\":\"FCE101378\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:20'),
(112, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 70, 'member.imported', 'Imported legacy member PINDAR YUSUF KWI (FCE100139).', '{\"staff_id\":\"FCE100139\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:21'),
(113, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 71, 'member.imported', 'Imported legacy member ABDULLAHI YAHAYA POTISKUM (FCE100122).', '{\"staff_id\":\"FCE100122\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:21'),
(114, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 72, 'member.imported', 'Imported legacy member BABA MOHAMMED RABIU (FCE100818).', '{\"staff_id\":\"FCE100818\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:21'),
(115, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 73, 'member.imported', 'Imported legacy member BAKOJI BALA (FCE100816).', '{\"staff_id\":\"FCE100816\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:22'),
(116, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 74, 'member.imported', 'Imported legacy member DAWASA IBRAHIM MOHAMMED (FCE100857).', '{\"staff_id\":\"FCE100857\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:22'),
(117, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 75, 'member.imported', 'Imported legacy member MUSAH AMINU (FCE100900).', '{\"staff_id\":\"FCE100900\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:23'),
(118, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 76, 'member.imported', 'Imported legacy member POKALAS TAIYATU (FCE100185).', '{\"staff_id\":\"FCE100185\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:23'),
(119, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 77, 'member.imported', 'Imported legacy member WAZIRI MOHAMMED ADAMU (FCE100547).', '{\"staff_id\":\"FCE100547\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:24'),
(120, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 78, 'member.imported', 'Imported legacy member MAMMAI YUSUF MOHAMMED (FCE100905).', '{\"staff_id\":\"FCE100905\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:24'),
(121, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 79, 'member.imported', 'Imported legacy member AJIYA ABUBAKAR BABA (FCE1001029).', '{\"staff_id\":\"FCE1001029\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:25'),
(122, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 80, 'member.imported', 'Imported legacy member ALHAJI BAABA NURI FIKA (FCE100979).', '{\"staff_id\":\"FCE100979\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:25'),
(123, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 81, 'member.imported', 'Imported legacy member MOHAMMED ABUBAKAR (FCE100858).', '{\"staff_id\":\"FCE100858\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:26'),
(124, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 82, 'member.imported', 'Imported legacy member HASSAN MUSA (FCE100932).', '{\"staff_id\":\"FCE100932\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:27'),
(125, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 83, 'member.imported', 'Imported legacy member ABUBAKAR MUHAMMAD ABUBAKAR (FCE100916).', '{\"staff_id\":\"FCE100916\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:27'),
(126, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 84, 'member.imported', 'Imported legacy member LAMPO ZAKAR SULE (FCE100791).', '{\"staff_id\":\"FCE100791\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:28'),
(127, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 85, 'member.imported', 'Imported legacy member DANLADI SULEIMAN (FCE200059).', '{\"staff_id\":\"FCE200059\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:28'),
(128, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 86, 'member.imported', 'Imported legacy member ISA ABDULLAHI (FCE101173).', '{\"staff_id\":\"FCE101173\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:29'),
(129, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 87, 'member.imported', 'Imported legacy member GARBA UMAR AHMED (FCE101345).', '{\"staff_id\":\"FCE101345\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:30'),
(130, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 88, 'member.imported', 'Imported legacy member ISA HASSAN (FCE101237).', '{\"staff_id\":\"FCE101237\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:30'),
(131, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 89, 'member.imported', 'Imported legacy member MAMMAI MOHAMMED MOHAMMED (FCE100712).', '{\"staff_id\":\"FCE100712\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:31'),
(132, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 90, 'member.imported', 'Imported legacy member SALIHU IDRIS YUNUSA (FCE101362).', '{\"staff_id\":\"FCE101362\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:31'),
(133, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 91, 'member.imported', 'Imported legacy member ALI ISAH (FCE101147).', '{\"staff_id\":\"FCE101147\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:32'),
(134, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 92, 'member.imported', 'Imported legacy member ISAH AHMED MUSA (FCE1001037).', '{\"staff_id\":\"FCE1001037\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:33'),
(135, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 93, 'member.imported', 'Imported legacy member CHIWAR BUKAR MOHAMMED KABU (FCE101084).', '{\"staff_id\":\"FCE101084\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:33'),
(136, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 94, 'member.imported', 'Imported legacy member ALI HAMSATU MOHAMMED (FCE100960).', '{\"staff_id\":\"FCE100960\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:04:34'),
(137, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 9, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-02 (68 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-02\",\"contributions\":68,\"share_purchases\":0,\"total_amount\":1087000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:05:55'),
(138, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 95, 'member.imported', 'Imported legacy member ALHAJI BASHIR BALA (FCE100053).', '{\"staff_id\":\"FCE100053\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:19'),
(139, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 96, 'member.imported', 'Imported legacy member TIJANI ABDULGAFAR OLAKUNLE (FCE100774).', '{\"staff_id\":\"FCE100774\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:20'),
(140, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 97, 'member.imported', 'Imported legacy member TANKO GARBA (FCE100941).', '{\"staff_id\":\"FCE100941\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:20'),
(141, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 98, 'member.imported', 'Imported legacy member HARUNA MUAWIYA (FCE100121).', '{\"staff_id\":\"FCE100121\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:21'),
(142, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 99, 'member.imported', 'Imported legacy member LAWANDI SULYMAN ISMAIL (FCE100717).', '{\"staff_id\":\"FCE100717\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:22'),
(143, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 100, 'member.imported', 'Imported legacy member HARUNA YUSUF (FCE101152).', '{\"staff_id\":\"FCE101152\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:22'),
(144, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 101, 'member.imported', 'Imported legacy member BAPPAH ALIYU WAZIRI (FCE101227).', '{\"staff_id\":\"FCE101227\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:23'),
(145, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 102, 'member.imported', 'Imported legacy member BUKAR SULEIMAN (FCE101132).', '{\"staff_id\":\"FCE101132\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:24');
INSERT INTO `activity_logs` (`id`, `causer_id`, `causer_name`, `causer_email`, `subject_type`, `subject_id`, `action`, `description`, `properties`, `ip_address`, `user_agent`, `created_at`) VALUES
(146, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 103, 'member.imported', 'Imported legacy member AHMED ABDULMUMINI GARBA (FCE101281).', '{\"staff_id\":\"FCE101281\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:24'),
(147, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 104, 'member.imported', 'Imported legacy member MUSA HASSAN (FCE101327).', '{\"staff_id\":\"FCE101327\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:25'),
(148, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 105, 'member.imported', 'Imported legacy member HASSAN ALIYU ADAMU (FCE101275).', '{\"staff_id\":\"FCE101275\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:25'),
(149, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 106, 'member.imported', 'Imported legacy member ALI GONI (FCE101287).', '{\"staff_id\":\"FCE101287\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:26'),
(150, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 107, 'member.imported', 'Imported legacy member SULE SHAIBU ALHAJI (FCE101404).', '{\"staff_id\":\"FCE101404\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:07:27'),
(151, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 10, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-03 (91 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-03\",\"contributions\":91,\"share_purchases\":0,\"total_amount\":1567000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:08:05'),
(152, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 108, 'member.imported', 'Imported legacy member GERO SALE MOHAMMED (FCE100200).', '{\"staff_id\":\"FCE100200\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:28'),
(153, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 109, 'member.imported', 'Imported legacy member WAKILI HADIZA MOHAMMED (FCE100705).', '{\"staff_id\":\"FCE100705\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:28'),
(154, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 110, 'member.imported', 'Imported legacy member USMAN DANLAMI BILTE (FCE101069).', '{\"staff_id\":\"FCE101069\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:29'),
(155, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 111, 'member.imported', 'Imported legacy member YAU YUSUF (FCE1001031).', '{\"staff_id\":\"FCE1001031\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:30'),
(156, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 112, 'member.imported', 'Imported legacy member IBRAHIM ABBA ZAKAR (FCE101082).', '{\"staff_id\":\"FCE101082\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:30'),
(157, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 113, 'member.imported', 'Imported legacy member YINUSA ABDULRAFIU YINKA (FCE101240).', '{\"staff_id\":\"FCE101240\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:31'),
(158, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 114, 'member.imported', 'Imported legacy member ABBA MAHMOUD BARAU (FCE101180).', '{\"staff_id\":\"FCE101180\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:32'),
(159, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 115, 'member.imported', 'Imported legacy member IDRISS BOMOI MOHAMMED (FCE101264).', '{\"staff_id\":\"FCE101264\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:32'),
(160, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 116, 'member.imported', 'Imported legacy member SAMAILA HADIZA (FCE101119).', '{\"staff_id\":\"FCE101119\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:09:33'),
(161, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 11, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-04 (104 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-04\",\"contributions\":104,\"share_purchases\":0,\"total_amount\":1767000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:10:20'),
(162, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 117, 'member.imported', 'Imported legacy member MAIGORO MUSA MUHAMMAD (FCE100184).', '{\"staff_id\":\"FCE100184\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:11:43'),
(163, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 118, 'member.imported', 'Imported legacy member BOGO ZAINAB AUDU (FCE100981).', '{\"staff_id\":\"FCE100981\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:11:43'),
(164, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 119, 'member.imported', 'Imported legacy member KYARI SHETTIMA ABBA (FCE100928).', '{\"staff_id\":\"FCE100928\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:11:44'),
(165, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 120, 'member.imported', 'Imported legacy member GALADIMA SAIDU BABA (FCE100692).', '{\"staff_id\":\"FCE100692\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:11:45'),
(166, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 121, 'member.imported', 'Imported legacy member ABDULLAHI USMAN (FCE101138).', '{\"staff_id\":\"FCE101138\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:11:45'),
(167, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 12, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-05 (110 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-05\",\"contributions\":110,\"share_purchases\":0,\"total_amount\":1832000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:12:24'),
(168, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 13, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-06 (115 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-06\",\"contributions\":115,\"share_purchases\":0,\"total_amount\":1851000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:13:09'),
(169, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 14, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-07 (115 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-07\",\"contributions\":115,\"share_purchases\":0,\"total_amount\":1851000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:14:02'),
(170, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 122, 'member.imported', 'Imported legacy member NANGERE MOHAMMED GARBA (FCE100625).', '{\"staff_id\":\"FCE100625\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:15:57'),
(171, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 123, 'member.imported', 'Imported legacy member USAKU ELIZABETH (FCE200019).', '{\"staff_id\":\"FCE200019\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:15:57'),
(172, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 124, 'member.imported', 'Imported legacy member UMAR USMAN MUHAMMAD (FCE101092).', '{\"staff_id\":\"FCE101092\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:15:58'),
(173, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 125, 'member.imported', 'Imported legacy member IBRAHIM MOHAMMED (FCE100722).', '{\"staff_id\":\"FCE100722\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:15:58'),
(174, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 126, 'member.imported', 'Imported legacy member HALLIRU IBRAHIM ALHAJI (FCE100624).', '{\"staff_id\":\"FCE100624\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:15:59'),
(175, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 15, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-08 (114 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-08\",\"contributions\":114,\"share_purchases\":0,\"total_amount\":1891000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:18:22'),
(176, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 127, 'member.imported', 'Imported legacy member YAU HARIRA (FCE100292).', '{\"staff_id\":\"FCE100292\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:19:35'),
(177, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\Member', 128, 'member.imported', 'Imported legacy member MOHAMMED UMARU (FCE100964).', '{\"staff_id\":\"FCE100964\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:19:35'),
(178, 2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', 'App\\Models\\ContributionBatch', 16, 'savings.contribution_batch_posted', 'Posted contribution batch for 2026-09 (117 contribution(s), 0 share purchase(s)).', '{\"period\":\"2026-09\",\"contributions\":117,\"share_purchases\":0,\"total_amount\":2121000}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', '2026-10-03 15:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `posted_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_fee_payments`
--

CREATE TABLE `application_fee_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `channel` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `admin_pct` decimal(5,2) DEFAULT NULL,
  `profit_pct` decimal(5,2) DEFAULT NULL,
  `admin_amount` decimal(14,2) DEFAULT NULL,
  `profit_amount` decimal(14,2) DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `paystack_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`paystack_response`)),
  `initiated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_fee_payments`
--

INSERT INTO `application_fee_payments` (`id`, `member_id`, `reference`, `amount`, `status`, `channel`, `source`, `admin_pct`, `profit_pct`, `admin_amount`, `profit_amount`, `recorded_by`, `paystack_response`, `initiated_at`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'LEGACY-FCET-CSL-00001-20261003123208', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:08', '2026-10-03 11:32:08', '2026-10-03 11:32:08', '2026-10-03 11:32:08'),
(2, 2, 'LEGACY-FCET-CSL-00002-20261003123209', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:09', '2026-10-03 11:32:09', '2026-10-03 11:32:09', '2026-10-03 11:32:09'),
(3, 3, 'LEGACY-FCET-CSL-00003-20261003123209', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:09', '2026-10-03 11:32:09', '2026-10-03 11:32:09', '2026-10-03 11:32:09'),
(4, 4, 'LEGACY-FCET-CSL-00004-20261003123210', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10', '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(5, 5, 'LEGACY-FCET-CSL-00005-20261003123210', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10', '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(6, 6, 'LEGACY-FCET-CSL-00006-20261003123211', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:11', '2026-10-03 11:32:11', '2026-10-03 11:32:11', '2026-10-03 11:32:11'),
(7, 7, 'LEGACY-FCET-CSL-00007-20261003123212', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12', '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(8, 8, 'LEGACY-FCET-CSL-00008-20261003123212', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12', '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(9, 9, 'LEGACY-FCET-CSL-00009-20261003123213', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13', '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(10, 10, 'LEGACY-FCET-CSL-00010-20261003123213', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13', '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(11, 11, 'LEGACY-FCET-CSL-00011-20261003123214', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:14', '2026-10-03 11:32:14', '2026-10-03 11:32:14', '2026-10-03 11:32:14'),
(12, 12, 'LEGACY-FCET-CSL-00012-20261003123215', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15', '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(13, 13, 'LEGACY-FCET-CSL-00013-20261003123215', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15', '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(14, 14, 'LEGACY-FCET-CSL-00014-20261003123216', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16', '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(15, 15, 'LEGACY-FCET-CSL-00015-20261003123216', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16', '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(16, 16, 'LEGACY-FCET-CSL-00016-20261003123217', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:17', '2026-10-03 11:32:17', '2026-10-03 11:32:17', '2026-10-03 11:32:17'),
(17, 17, 'LEGACY-FCET-CSL-00017-20261003123218', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18', '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(18, 18, 'LEGACY-FCET-CSL-00018-20261003123218', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18', '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(19, 19, 'LEGACY-FCET-CSL-00019-20261003123219', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19', '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(20, 20, 'LEGACY-FCET-CSL-00020-20261003123219', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19', '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(21, 21, 'LEGACY-FCET-CSL-00021-20261003123220', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20', '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(22, 22, 'LEGACY-FCET-CSL-00022-20261003123220', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20', '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(23, 23, 'LEGACY-FCET-CSL-00023-20261003123221', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21', '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(24, 24, 'LEGACY-FCET-CSL-00024-20261003123221', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21', '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(25, 25, 'LEGACY-FCET-CSL-00025-20261003123222', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22', '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(26, 26, 'LEGACY-FCET-CSL-00026-20261003123222', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22', '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(27, 27, 'LEGACY-FCET-CSL-00027-20261003123223', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:23', '2026-10-03 11:32:23', '2026-10-03 11:32:23', '2026-10-03 11:32:23'),
(28, 28, 'LEGACY-FCET-CSL-00028-20261003123224', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24', '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(29, 29, 'LEGACY-FCET-CSL-00029-20261003123224', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24', '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(30, 30, 'LEGACY-FCET-CSL-00030-20261003123225', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25', '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(31, 31, 'LEGACY-FCET-CSL-00031-20261003123225', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25', '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(32, 32, 'LEGACY-FCET-CSL-00032-20261003123226', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26', '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(33, 33, 'LEGACY-FCET-CSL-00033-20261003123226', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26', '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(34, 34, 'LEGACY-FCET-CSL-00034-20261003123227', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:27', '2026-10-03 11:32:27', '2026-10-03 11:32:27', '2026-10-03 11:32:27'),
(35, 35, 'LEGACY-FCET-CSL-00035-20261003123228', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28', '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(36, 36, 'LEGACY-FCET-CSL-00036-20261003123228', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28', '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(37, 37, 'LEGACY-FCET-CSL-00037-20261003123229', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29', '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(38, 38, 'LEGACY-FCET-CSL-00038-20261003123229', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29', '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(39, 39, 'LEGACY-FCET-CSL-00039-20261003123230', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30', '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(40, 40, 'LEGACY-FCET-CSL-00040-20261003123230', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30', '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(41, 41, 'LEGACY-FCET-CSL-00041-20261003123231', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:31', '2026-10-03 11:32:31', '2026-10-03 11:32:31', '2026-10-03 11:32:31'),
(42, 42, 'LEGACY-FCET-CSL-00042-20261003123232', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 11:32:32', '2026-10-03 11:32:32', '2026-10-03 11:32:32', '2026-10-03 11:32:32'),
(43, 43, 'LEGACY-FCET-CSL-00043-20261003152447', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(44, 44, 'LEGACY-FCET-CSL-00044-20261003152447', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(45, 45, 'LEGACY-FCET-CSL-00045-20261003152447', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(46, 46, 'LEGACY-FCET-CSL-00046-20261003152823', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23', '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(47, 47, 'LEGACY-FCET-CSL-00047-20261003152823', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23', '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(48, 48, 'LEGACY-FCET-CSL-00048-20261003152824', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24', '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(49, 49, 'LEGACY-FCET-CSL-00049-20261003152824', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24', '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(50, 50, 'LEGACY-FCET-CSL-00050-20261003152825', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:25', '2026-10-03 14:28:25', '2026-10-03 14:28:25', '2026-10-03 14:28:25'),
(51, 51, 'LEGACY-FCET-CSL-00051-20261003152826', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26', '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(52, 52, 'LEGACY-FCET-CSL-00052-20261003152826', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26', '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(53, 53, 'LEGACY-FCET-CSL-00053-20261003152827', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27', '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(54, 54, 'LEGACY-FCET-CSL-00054-20261003152827', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27', '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(55, 55, 'LEGACY-FCET-CSL-00055-20261003152828', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:28', '2026-10-03 14:28:28', '2026-10-03 14:28:28', '2026-10-03 14:28:28'),
(56, 56, 'LEGACY-FCET-CSL-00056-20261003152829', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29', '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(57, 57, 'LEGACY-FCET-CSL-00057-20261003152829', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29', '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(58, 58, 'LEGACY-FCET-CSL-00058-20261003152830', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:28:30', '2026-10-03 14:28:30', '2026-10-03 14:28:30', '2026-10-03 14:28:30'),
(59, 59, 'LEGACY-FCET-CSL-00059-20261003153058', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:30:58', '2026-10-03 14:30:58', '2026-10-03 14:30:58', '2026-10-03 14:30:58'),
(60, 60, 'LEGACY-FCET-CSL-00060-20261003153059', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59', '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(61, 61, 'LEGACY-FCET-CSL-00061-20261003153059', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59', '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(62, 62, 'LEGACY-FCET-CSL-00062-20261003153100', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00', '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(63, 63, 'LEGACY-FCET-CSL-00063-20261003153100', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00', '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(64, 64, 'LEGACY-FCET-CSL-00064-20261003153101', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01', '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(65, 65, 'LEGACY-FCET-CSL-00065-20261003153101', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01', '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(66, 66, 'LEGACY-FCET-CSL-00066-20261003153102', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:31:02', '2026-10-03 14:31:02', '2026-10-03 14:31:02', '2026-10-03 14:31:02'),
(67, 67, 'LEGACY-FCET-CSL-00067-20261003154258', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:42:58', '2026-10-03 14:42:58', '2026-10-03 14:42:58', '2026-10-03 14:42:58'),
(68, 68, 'LEGACY-FCET-CSL-00068-20261003154259', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 14:42:59', '2026-10-03 14:42:59', '2026-10-03 14:42:59', '2026-10-03 14:42:59'),
(69, 69, 'LEGACY-FCET-CSL-00069-20261003160420', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:20', '2026-10-03 15:04:20', '2026-10-03 15:04:20', '2026-10-03 15:04:20'),
(70, 70, 'LEGACY-FCET-CSL-00070-20261003160421', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(71, 71, 'LEGACY-FCET-CSL-00071-20261003160421', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(72, 72, 'LEGACY-FCET-CSL-00072-20261003160421', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(73, 73, 'LEGACY-FCET-CSL-00073-20261003160422', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22', '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(74, 74, 'LEGACY-FCET-CSL-00074-20261003160422', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22', '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(75, 75, 'LEGACY-FCET-CSL-00075-20261003160423', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23', '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(76, 76, 'LEGACY-FCET-CSL-00076-20261003160423', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23', '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(77, 77, 'LEGACY-FCET-CSL-00077-20261003160424', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24', '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(78, 78, 'LEGACY-FCET-CSL-00078-20261003160424', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24', '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(79, 79, 'LEGACY-FCET-CSL-00079-20261003160425', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25', '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(80, 80, 'LEGACY-FCET-CSL-00080-20261003160425', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25', '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(81, 81, 'LEGACY-FCET-CSL-00081-20261003160426', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26', '2026-10-03 15:04:26', '2026-10-03 15:04:26'),
(82, 82, 'LEGACY-FCET-CSL-00082-20261003160427', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27', '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(83, 83, 'LEGACY-FCET-CSL-00083-20261003160427', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27', '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(84, 84, 'LEGACY-FCET-CSL-00084-20261003160428', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28', '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(85, 85, 'LEGACY-FCET-CSL-00085-20261003160428', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28', '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(86, 86, 'LEGACY-FCET-CSL-00086-20261003160429', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:29', '2026-10-03 15:04:29', '2026-10-03 15:04:29', '2026-10-03 15:04:29'),
(87, 87, 'LEGACY-FCET-CSL-00087-20261003160430', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30', '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(88, 88, 'LEGACY-FCET-CSL-00088-20261003160430', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30', '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(89, 89, 'LEGACY-FCET-CSL-00089-20261003160431', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31', '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(90, 90, 'LEGACY-FCET-CSL-00090-20261003160431', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31', '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(91, 91, 'LEGACY-FCET-CSL-00091-20261003160432', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:32', '2026-10-03 15:04:32', '2026-10-03 15:04:32', '2026-10-03 15:04:32'),
(92, 92, 'LEGACY-FCET-CSL-00092-20261003160433', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33', '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(93, 93, 'LEGACY-FCET-CSL-00093-20261003160433', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33', '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(94, 94, 'LEGACY-FCET-CSL-00094-20261003160434', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:04:34', '2026-10-03 15:04:34', '2026-10-03 15:04:34', '2026-10-03 15:04:34'),
(95, 95, 'LEGACY-FCET-CSL-00095-20261003160719', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:19', '2026-10-03 15:07:19', '2026-10-03 15:07:19', '2026-10-03 15:07:19'),
(96, 96, 'LEGACY-FCET-CSL-00096-20261003160720', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20', '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(97, 97, 'LEGACY-FCET-CSL-00097-20261003160720', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20', '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(98, 98, 'LEGACY-FCET-CSL-00098-20261003160721', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:21', '2026-10-03 15:07:21', '2026-10-03 15:07:21', '2026-10-03 15:07:21'),
(99, 99, 'LEGACY-FCET-CSL-00099-20261003160722', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22', '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(100, 100, 'LEGACY-FCET-CSL-00100-20261003160722', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22', '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(101, 101, 'LEGACY-FCET-CSL-00101-20261003160723', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:23', '2026-10-03 15:07:23', '2026-10-03 15:07:23', '2026-10-03 15:07:23'),
(102, 102, 'LEGACY-FCET-CSL-00102-20261003160724', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24', '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(103, 103, 'LEGACY-FCET-CSL-00103-20261003160724', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24', '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(104, 104, 'LEGACY-FCET-CSL-00104-20261003160725', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25', '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(105, 105, 'LEGACY-FCET-CSL-00105-20261003160725', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25', '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(106, 106, 'LEGACY-FCET-CSL-00106-20261003160726', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:26', '2026-10-03 15:07:26', '2026-10-03 15:07:26', '2026-10-03 15:07:26'),
(107, 107, 'LEGACY-FCET-CSL-00107-20261003160727', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:07:27', '2026-10-03 15:07:27', '2026-10-03 15:07:27', '2026-10-03 15:07:27'),
(108, 108, 'LEGACY-FCET-CSL-00108-20261003160928', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28', '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(109, 109, 'LEGACY-FCET-CSL-00109-20261003160928', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28', '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(110, 110, 'LEGACY-FCET-CSL-00110-20261003160929', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:29', '2026-10-03 15:09:29', '2026-10-03 15:09:29', '2026-10-03 15:09:29'),
(111, 111, 'LEGACY-FCET-CSL-00111-20261003160930', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30', '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(112, 112, 'LEGACY-FCET-CSL-00112-20261003160930', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30', '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(113, 113, 'LEGACY-FCET-CSL-00113-20261003160931', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:31', '2026-10-03 15:09:31', '2026-10-03 15:09:31', '2026-10-03 15:09:31'),
(114, 114, 'LEGACY-FCET-CSL-00114-20261003160932', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32', '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(115, 115, 'LEGACY-FCET-CSL-00115-20261003160932', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32', '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(116, 116, 'LEGACY-FCET-CSL-00116-20261003160933', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:09:33', '2026-10-03 15:09:33', '2026-10-03 15:09:33', '2026-10-03 15:09:33'),
(117, 117, 'LEGACY-FCET-CSL-00117-20261003161143', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43', '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(118, 118, 'LEGACY-FCET-CSL-00118-20261003161143', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43', '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(119, 119, 'LEGACY-FCET-CSL-00119-20261003161144', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:11:44', '2026-10-03 15:11:44', '2026-10-03 15:11:44', '2026-10-03 15:11:44'),
(120, 120, 'LEGACY-FCET-CSL-00120-20261003161145', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45', '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(121, 121, 'LEGACY-FCET-CSL-00121-20261003161145', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45', '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(122, 122, 'LEGACY-FCET-CSL-00122-20261003161557', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57', '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(123, 123, 'LEGACY-FCET-CSL-00123-20261003161557', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57', '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(124, 124, 'LEGACY-FCET-CSL-00124-20261003161558', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58', '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(125, 125, 'LEGACY-FCET-CSL-00125-20261003161558', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58', '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(126, 126, 'LEGACY-FCET-CSL-00126-20261003161559', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:15:59', '2026-10-03 15:15:59', '2026-10-03 15:15:59', '2026-10-03 15:15:59'),
(127, 127, 'LEGACY-FCET-CSL-00127-20261003161935', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35', '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(128, 128, 'LEGACY-FCET-CSL-00128-20261003161935', 5000.00, 'success', NULL, 'legacy_import', 20.00, 80.00, 1000.00, 4000.00, 2, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35', '2026-10-03 15:19:35', '2026-10-03 15:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fy_start_year` smallint(5) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `proposed_by` bigint(20) UNSIGNED NOT NULL,
  `proposed_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_lines`
--

CREATE TABLE `budget_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `budget_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `budgeted_amount` decimal(14,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('fcet-potiskum-coop-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:2;', 1791044425),
('fcet-potiskum-coop-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1791044425;', 1791044425),
('fcet-potiskum-coop-cache-setting:application_fee_admin_pct', 'i:20;', 2106390728),
('fcet-potiskum-coop-cache-setting:application_fee_profit_pct', 'i:80;', 2106390728),
('fcet-potiskum-coop-cache-setting:application_form_fee', 'i:5000;', 2106390728),
('fcet-potiskum-coop-cache-setting:voluntary_deposit_lock_months', 'i:3;', 2106390882),
('fcet-potiskum-coop-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:83:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"view_own_application\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:10;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:16:\"view_own_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:16:\"edit_own_profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"request_exit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:16:\"view_all_members\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:8:{i:0;i:3;i:1;i:4;i:2;i:5;i:3;i:6;i:4;i:7;i:5;i:8;i:6;i:9;i:7;i:10;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:20:\"approve_applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:19:\"reject_applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"adjust_contribution\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:25:\"mark_application_fee_paid\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:22:\"review_change_requests\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:5;i:1;i:10;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:18:\"edit_locked_fields\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:10;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:20:\"manage_member_status\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"export_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:5;i:2;i:6;i:3;i:10;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:29:\"view_registration_fee_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:10;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:32:\"manage_registration_fee_settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"view_own_savings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"request_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:22:\"make_voluntary_deposit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:23:\"post_contribution_batch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:25:\"confirm_voluntary_deposit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:27:\"treasurer_review_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:29:\"chairman_authorize_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:19:\"disburse_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:17:\"initiate_reversal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:18:\"authorize_reversal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:28:\"manage_withdrawal_conditions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:4;i:2;i:10;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:23:\"manage_savings_products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:10;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:20:\"view_savings_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:10;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:14:\"import_members\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:14:\"view_own_loans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"apply_for_loan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:21:\"treasurer_review_loan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:23:\"chairman_authorize_loan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"disburse_loan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:25:\"post_loan_repayment_batch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:22:\"confirm_loan_repayment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:20:\"manage_loan_products\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:10;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:23:\"set_loan_interest_rates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:28:\"manage_loan_limit_multiplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"import_loans\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"view_loan_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:10;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:15:\"view_own_shares\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"purchase_shares\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:24:\"request_share_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:22:\"confirm_share_purchase\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:33:\"treasurer_review_share_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:35:\"chairman_authorize_share_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:25:\"disburse_share_withdrawal\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:18:\"manage_share_price\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:4;i:2;i:10;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:18:\"view_share_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:10;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:18:\"view_own_dividends\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:23:\"manage_dividend_periods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:22:\"declare_dividend_rates\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:19:\"calculate_dividends\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:14:\"post_dividends\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:21:\"view_dividend_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:10;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:22:\"request_commodity_loan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:26:\"manage_commodity_catalogue\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:5;i:1;i:10;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:23:\"manage_commodity_cycles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:5;i:1;i:10;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:21:\"price_commodity_cycle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:5;i:1;i:10;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:22:\"verify_commodity_cycle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:10;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:23:\"approve_commodity_cycle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:9;i:1;i:10;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:25:\"authorize_commodity_cycle\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:23:\"release_commodity_goods\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:9;i:1;i:10;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:17:\"view_activity_log\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:8;i:1;i:10;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:23:\"manage_member_documents\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:5;i:2;i:10;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:21:\"manage_loan_documents\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:4;i:2;i:10;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:20:\"manage_announcements\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:4;i:1;i:5;i:2;i:10;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:25:\"view_financial_statements\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:3;i:1;i:4;i:2;i:8;i:3;i:10;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:15:\"raise_complaint\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:10;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:25:\"raise_complaint_on_behalf\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:5;i:2;i:10;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:17:\"handle_complaints\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:3;i:1;i:4;i:2;i:5;i:3;i:6;i:4;i:10;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:30:\"handle_confidential_complaints\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:14:\"manage_budgets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:15:\"approve_budgets\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:19:\"view_budget_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:8;i:4;i:10;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:22:\"initiate_welfare_claim\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:3;i:1;i:5;i:2;i:10;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:23:\"authorize_welfare_claim\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:22:\"disburse_welfare_claim\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:17:\"post_welfare_levy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:3;i:1;i:10;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:23:\"manage_welfare_settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:4;i:1;i:10;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:20:\"view_welfare_reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:3;i:1;i:4;i:2;i:6;i:3;i:8;i:4;i:10;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:12:\"manage_users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:10;}}}s:5:\"roles\";a:10:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"applicant\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"member\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:10;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"treasurer\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:8:\"chairman\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"secretary\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:4:\"exco\";s:1:\"c\";s:3:\"web\";}i:7;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"loan_officer\";s:1:\"c\";s:3:\"web\";}i:8;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:7:\"auditor\";s:1:\"c\";s:3:\"web\";}i:9;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"store_officer\";s:1:\"c\";s:3:\"web\";}}}', 1791125985);

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
-- Table structure for table `commodity_cycles`
--

CREATE TABLE `commodity_cycles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `request_deadline` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `tenure_months` int(10) UNSIGNED DEFAULT NULL,
  `moratorium_months` int(10) UNSIGNED DEFAULT NULL,
  `markup_admin_pct` decimal(5,2) NOT NULL DEFAULT 2.00,
  `markup_profit_pct` decimal(5,2) NOT NULL DEFAULT 8.00,
  `opened_by` bigint(20) UNSIGNED NOT NULL,
  `priced_by` bigint(20) UNSIGNED DEFAULT NULL,
  `priced_at` timestamp NULL DEFAULT NULL,
  `auditor_verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `auditor_verified_at` timestamp NULL DEFAULT NULL,
  `store_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `store_approved_at` timestamp NULL DEFAULT NULL,
  `chairman_authorized_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_authorized_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodity_cycle_prices`
--

CREATE TABLE `commodity_cycle_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commodity_cycle_id` bigint(20) UNSIGNED NOT NULL,
  `commodity_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_item_text` varchar(255) DEFAULT NULL,
  `unit_price` decimal(14,2) NOT NULL,
  `set_by` bigint(20) UNSIGNED NOT NULL,
  `set_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodity_items`
--

CREATE TABLE `commodity_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `type_brand` varchar(255) DEFAULT NULL,
  `pack_unit` varchar(255) NOT NULL,
  `unit_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`unit_options`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_from_request_line_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commodity_items`
--

INSERT INTO `commodity_items` (`id`, `description`, `type_brand`, `pack_unit`, `unit_options`, `is_active`, `created_from_request_line_id`, `created_at`, `updated_at`) VALUES
(1, 'Suphagetti', 'Golden Peny', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(2, 'Suphagetti', 'Doga', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(3, 'Suphagetti', 'IRS', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(4, 'Suphagetti', 'Gonca', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(5, 'Suphagetti', 'Crown', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(6, 'Semovita', 'Golden Peny', 'Sachet Pack', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(7, 'Semovita', 'Golden Peny', 'Bag Pack', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(8, 'Knor Cubs Maggi', '14 Pieces x100', 'Carton-PC20', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(9, 'Maggi Star', '20 Pieces', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(10, 'Maggi Star', 'Pieces x100', 'Packet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(11, 'BUA Sugar', 'Bua Sugar', '50Kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(12, 'Golden Peny Sugar', 'Cubs Carton', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(13, 'Golden Peny Sugar', 'Cubs Packet', '1 Packet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(14, 'Flour', 'IRS', '50kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(15, 'Golden Peny', 'Cous-Cous', '500gx20', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(16, 'Golden Peny', 'Macarony Carton', 'x20 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(17, 'Gaia Cous-Cous', 'Foriengn', 'Carton', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(18, 'Kings Oil', '25 Litres', '25 Litres', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(19, 'Kings Oil', '5 Litres', '5 Litres', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(20, 'Kings Oil', '3 Litres', '3 Litres', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(21, 'Kings Oil', '1 Litre', '1 Litre', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(22, 'Red/Palm Oil', '25 Litres', '25 Litres', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(23, 'Red/Palm Oil', '3 Litres', '3 Litres', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(24, 'Red/Palm Oil', '1 Litre', '1 Litre', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(25, 'Red/Palm Oil', '1 Bottle', 'Bottle', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(26, 'Toilet Soap', 'Viva Carton', '100 Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(27, 'Toilet Soap', 'Viva Carton Extra', '24 Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(28, 'Toilet Soap', 'Viva Carton Plus', '24 Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(29, 'Detagents Viva', 'Carton 170g', 'x26 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(30, 'Detagents Viva', 'Carton 80g', 'x50 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(31, 'Detagents Viva', 'Carton 22g', 'x162 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(32, 'Detagents Klin', 'Carton 170g', 'x26 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(33, 'Detagents Klin', 'Carton 20g', 'x150 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(34, 'Maize', 'Bag 100kg (A)', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(35, 'Garin Buski', 'Bag 50kg', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(36, 'Garin Masara', 'Bag 50kg', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(37, 'Rices', 'Gerawa Rice', '50Kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(38, 'Rices', 'BUA Rice', '50Kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(39, 'Rices', 'Pure Thailan Rice', '50Kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(40, 'Rices', 'Mama Africa Rice', '50Kg Bag', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(41, 'Rices', 'Local Rice 100kg (A)', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(42, 'Shinkafan Tuwu', '100kg', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(43, 'Toilet/Bathing Soap', 'Siri Soap Packet', 'x6 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(44, 'Toilet/Bathing Soap', 'LewarBeauty 120g', 'x4 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(45, 'Toilet/Bathing Soap', 'Tetmosol Big', 'x6 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(46, 'Toilet/Bathing Soap', 'Tetmosol Small', 'x6 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(47, 'Toilet/Bathing Soap', 'Sure Soap Big 120g', 'x6 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(48, 'Toilet/Bathing Soap', 'Sure Soap Small', 'x6 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(49, 'Tea', 'Lipton Yellow', '1 Packet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(50, 'Tea', 'Top Tea', '1 Packet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(51, 'Instant Nooddles', 'Big Carton', '42 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(52, 'Instant Nooddles', 'Small Carton', '42 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(53, 'Whate/Alkama', 'Kwano', 'Kwano', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(54, 'Accha', 'Kwano', 'Kwano', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(55, 'Milo', 'Milo 800g', 'Sachet Pack', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(56, 'Milo', 'Milo 400g', 'Sachet Pack', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(57, 'Milo', 'Mio 20g', 'Roll - 10Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(58, 'Milk', 'Peak Milk 900g', 'Sachet Pack', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(59, 'Milk', 'Peak Milk 850g', 'Tin', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(60, 'Milk', 'Peak Milk 400g', 'Tin', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(61, 'Milk', 'Peak Milk 14g', 'Roll - 10Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(62, 'Milk', 'Cow Bell Milk 350g', 'Sachet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(63, 'Milk', 'Cow Bell Milk 12g', 'Roll - 10Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(64, 'Milk', 'Dano Milk 350g', 'Sachet', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(65, 'Sardine Fish', 'Super Delicienge', '1 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(66, 'Tomoto', 'Tomoto Nagiko Tin 2200g', '6Pieces', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(67, 'Tomoto', 'Tomoto Nagiko Tin 400g', '24Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(68, 'Tomoto', 'Tomoto Triple', '8 Piece', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(69, 'Red Beans', 'Bag 100kg', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18'),
(70, 'White Beans', 'Bag 100kg', 'x40 (Kwano)', NULL, 1, NULL, '2026-10-03 12:46:18', '2026-10-03 12:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `commodity_requests`
--

CREATE TABLE `commodity_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commodity_cycle_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `commodity_subtotal` decimal(14,2) DEFAULT NULL,
  `markup_amount` decimal(14,2) DEFAULT NULL,
  `total_repayable` decimal(14,2) DEFAULT NULL,
  `monthly_installment` decimal(14,2) DEFAULT NULL,
  `salary_deduction_authorized` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'submitted',
  `released_by` bigint(20) UNSIGNED DEFAULT NULL,
  `released_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commodity_request_lines`
--

CREATE TABLE `commodity_request_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commodity_request_id` bigint(20) UNSIGNED NOT NULL,
  `commodity_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_item_text` varchar(255) DEFAULT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `unit_basis` varchar(255) NOT NULL,
  `fixed_unit_price` decimal(14,2) DEFAULT NULL,
  `line_total` decimal(14,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contribution_batches`
--

CREATE TABLE `contribution_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_amount` decimal(14,2) DEFAULT NULL,
  `total_records` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('uploaded','validated','posted','failed') NOT NULL DEFAULT 'uploaded',
  `rows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rows`)),
  `validation_errors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`validation_errors`)),
  `posted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contribution_batches`
--

INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(1, '2025-06', 2, 'contribution-batches/TnBxdDXbmf22T96RRv3SnBFbS4BPrw4lKTOHO2OZ.csv', 662000.00, 42, 'posted', '[{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 12:51:01', '2026-10-03 11:40:47', '2026-10-03 12:51:01'),
(2, '2025-07', 2, 'contribution-batches/UjH9oZX7CoBuDNpoKJbNqGBHwVQKYPehssGOdkYE.csv', 652000.00, 42, 'posted', '[{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":10000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:35', '2026-10-03 14:25:43'),
(3, '2025-08', 2, 'contribution-batches/JT3hE2c8DpC9ftFMinZTG793DrJABy2aJyWk6Pew.csv', 682000.00, 45, 'posted', '[{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":10000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:04', '2026-10-03 14:29:16'),
(4, '2025-09', 2, 'contribution-batches/F2L7qqiaw1Sf2qfMufhSL951lVNwpefLNWgsgrSA.csv', 882000.00, 58, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":40000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:41', '2026-10-03 14:31:47'),
(5, '2025-10', 2, 'contribution-batches/YNKC1FNNtHqYDal3ToPaFxIEYDEQxjPl2tCxFXhZ.csv', 962000.00, 66, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100674\",\"amount\":10000,\"shares\":0,\"member_id\":60,\"member_name\":\"USMAN NANA\",\"ippis_number\":\"TI53784\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":40000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":10000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:41:07', '2026-10-03 14:40:59', '2026-10-03 14:41:07');
INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(6, '2025-11', 2, 'contribution-batches/6cVHrrocJzQ8jr4CafGtLskygGtWlYlQH1HXcpDk.csv', 942000.00, 66, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100674\",\"amount\":10000,\"shares\":0,\"member_id\":60,\"member_name\":\"USMAN NANA\",\"ippis_number\":\"TI53784\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":10000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:22', '2026-10-03 14:44:31'),
(7, '2025-12', 2, 'contribution-batches/lfRoyAjBVKTMCPDEqdRnC5eUPFFU6Y4w40kWHWR5.csv', 1002000.00, 68, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100674\",\"amount\":10000,\"shares\":0,\"member_id\":60,\"member_name\":\"USMAN NANA\",\"ippis_number\":\"TI53784\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":10000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:40', '2026-10-03 14:46:47'),
(8, '2026-01', 2, 'contribution-batches/jmSmeAAURNCWtOP2MFFWvp1NLEp1u8XGoVUJunoZ.csv', 1002000.00, 68, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":50000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100674\",\"amount\":10000,\"shares\":0,\"member_id\":60,\"member_name\":\"USMAN NANA\",\"ippis_number\":\"TI53784\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":10000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:43', '2026-10-03 14:47:50'),
(9, '2026-02', 2, 'contribution-batches/FiQKC3ea2FgJW3Y78K15OibyB6I6LrWe0WZY42Mq.csv', 1087000.00, 68, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":80000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100674\",\"amount\":10000,\"shares\":0,\"member_id\":60,\"member_name\":\"USMAN NANA\",\"ippis_number\":\"TI53784\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":60000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:48', '2026-10-03 15:05:55');
INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(10, '2026-03', 2, 'contribution-batches/XnM2a5ExHj404isnxeKmIe1xLAuRCKDIDZzkPwJS.csv', 1567000.00, 91, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":50000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":20000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":5000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":5000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":5000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:08:05', '2026-10-03 15:07:58', '2026-10-03 15:08:05'),
(11, '2026-04', 2, 'contribution-batches/LmJCmFR5hEXL9WDyOXMNxS01GlHE5O1JRNXelPwj.csv', 1767000.00, 104, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":30000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":50000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100913\",\"amount\":20000,\"shares\":0,\"member_id\":15,\"member_name\":\"MIDALA ZAKARIYAU HARUNA\",\"ippis_number\":\"TI53938\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":60000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":10000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":5000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101061\",\"amount\":5000,\"shares\":0,\"member_id\":41,\"member_name\":\"TONTI ALIYU MOHAMMED\",\"ippis_number\":\"TI26173\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101423\",\"amount\":10000,\"shares\":0,\"member_id\":58,\"member_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"ippis_number\":\"TI339340\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:13', '2026-10-03 15:10:20');
INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(12, '2026-05', 2, 'contribution-batches/oVWN0gzbuqirHaUrke4aDWpwl8mrE85QGkY7eSuO.csv', 1832000.00, 110, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":30000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100200\",\"amount\":20000,\"shares\":0,\"member_id\":108,\"member_name\":\"GERO SALE MOHAMMED\",\"ippis_number\":\"TI53688\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":50000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100705\",\"amount\":5000,\"shares\":0,\"member_id\":109,\"member_name\":\"WAKILI HADIZA MOHAMMED\",\"ippis_number\":\"TI53815\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101069\",\"amount\":10000,\"shares\":0,\"member_id\":110,\"member_name\":\"USMAN DANLAMI BILTE\",\"ippis_number\":\"TI54036\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001031\",\"amount\":10000,\"shares\":0,\"member_id\":111,\"member_name\":\"YAU YUSUF\",\"ippis_number\":\"TI54019\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":60000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101082\",\"amount\":10000,\"shares\":0,\"member_id\":112,\"member_name\":\"IBRAHIM ABBA ZAKAR\",\"ippis_number\":\"TI54044\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101240\",\"amount\":5000,\"shares\":0,\"member_id\":113,\"member_name\":\"YINUSA ABDULRAFIU YINKA\",\"ippis_number\":\"TI315663\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101180\",\"amount\":10000,\"shares\":0,\"member_id\":114,\"member_name\":\"ABBA MAHMOUD BARAU\",\"ippis_number\":\"TI315686\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101264\",\"amount\":5000,\"shares\":0,\"member_id\":115,\"member_name\":\"IDRISS BOMOI MOHAMMED\",\"ippis_number\":\"TI315667\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":30000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":5000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101119\",\"amount\":5000,\"shares\":0,\"member_id\":116,\"member_name\":\"SAMAILA HADIZA\",\"ippis_number\":\"TI315620\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:18', '2026-10-03 15:12:24'),
(13, '2026-06', 2, 'contribution-batches/ydt3IUzofSaExTqJKI7o9EzKOTaH3xuq4dul7Zqr.csv', 1851000.00, 115, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":30000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100200\",\"amount\":20000,\"shares\":0,\"member_id\":108,\"member_name\":\"GERO SALE MOHAMMED\",\"ippis_number\":\"TI53688\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100184\",\"amount\":10000,\"shares\":0,\"member_id\":117,\"member_name\":\"MAIGORO MUSA MUHAMMAD\",\"ippis_number\":\"TI53677\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100981\",\"amount\":10000,\"shares\":0,\"member_id\":118,\"member_name\":\"BOGO ZAINAB AUDU\",\"ippis_number\":\"TI53983\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":50000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100705\",\"amount\":5000,\"shares\":0,\"member_id\":109,\"member_name\":\"WAKILI HADIZA MOHAMMED\",\"ippis_number\":\"TI53815\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101069\",\"amount\":10000,\"shares\":0,\"member_id\":110,\"member_name\":\"USMAN DANLAMI BILTE\",\"ippis_number\":\"TI54036\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001031\",\"amount\":10000,\"shares\":0,\"member_id\":111,\"member_name\":\"YAU YUSUF\",\"ippis_number\":\"TI54019\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":20000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100928\",\"amount\":10000,\"shares\":0,\"member_id\":119,\"member_name\":\"KYARI SHETTIMA ABBA\",\"ippis_number\":\"TI53948\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100692\",\"amount\":20000,\"shares\":0,\"member_id\":120,\"member_name\":\"GALADIMA SAIDU BABA\",\"ippis_number\":\"TI53797\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101082\",\"amount\":10000,\"shares\":0,\"member_id\":112,\"member_name\":\"IBRAHIM ABBA ZAKAR\",\"ippis_number\":\"TI54044\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101240\",\"amount\":5000,\"shares\":0,\"member_id\":113,\"member_name\":\"YINUSA ABDULRAFIU YINKA\",\"ippis_number\":\"TI315663\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101180\",\"amount\":10000,\"shares\":0,\"member_id\":114,\"member_name\":\"ABBA MAHMOUD BARAU\",\"ippis_number\":\"TI315686\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101138\",\"amount\":10000,\"shares\":0,\"member_id\":121,\"member_name\":\"ABDULLAHI USMAN\",\"ippis_number\":\"TI315788\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101264\",\"amount\":5000,\"shares\":0,\"member_id\":115,\"member_name\":\"IDRISS BOMOI MOHAMMED\",\"ippis_number\":\"TI315667\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":30000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":4000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101119\",\"amount\":5000,\"shares\":0,\"member_id\":116,\"member_name\":\"SAMAILA HADIZA\",\"ippis_number\":\"TI315620\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:03', '2026-10-03 15:13:09');
INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(14, '2026-07', 2, 'contribution-batches/pmywDN7HkioNr3Bj1GafN8w1qUDYJgjvNH2NIeYO.csv', 1851000.00, 115, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":30000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100200\",\"amount\":20000,\"shares\":0,\"member_id\":108,\"member_name\":\"GERO SALE MOHAMMED\",\"ippis_number\":\"TI53688\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100184\",\"amount\":10000,\"shares\":0,\"member_id\":117,\"member_name\":\"MAIGORO MUSA MUHAMMAD\",\"ippis_number\":\"TI53677\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100981\",\"amount\":10000,\"shares\":0,\"member_id\":118,\"member_name\":\"BOGO ZAINAB AUDU\",\"ippis_number\":\"TI53983\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":50000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100705\",\"amount\":5000,\"shares\":0,\"member_id\":109,\"member_name\":\"WAKILI HADIZA MOHAMMED\",\"ippis_number\":\"TI53815\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101069\",\"amount\":10000,\"shares\":0,\"member_id\":110,\"member_name\":\"USMAN DANLAMI BILTE\",\"ippis_number\":\"TI54036\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100731\",\"amount\":10000,\"shares\":0,\"member_id\":19,\"member_name\":\"BARDE IDRISS IBRAHIM\",\"ippis_number\":\"TI53818\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001031\",\"amount\":10000,\"shares\":0,\"member_id\":111,\"member_name\":\"YAU YUSUF\",\"ippis_number\":\"TI54019\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":20000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100928\",\"amount\":10000,\"shares\":0,\"member_id\":119,\"member_name\":\"KYARI SHETTIMA ABBA\",\"ippis_number\":\"TI53948\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100692\",\"amount\":20000,\"shares\":0,\"member_id\":120,\"member_name\":\"GALADIMA SAIDU BABA\",\"ippis_number\":\"TI53797\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101082\",\"amount\":10000,\"shares\":0,\"member_id\":112,\"member_name\":\"IBRAHIM ABBA ZAKAR\",\"ippis_number\":\"TI54044\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101240\",\"amount\":5000,\"shares\":0,\"member_id\":113,\"member_name\":\"YINUSA ABDULRAFIU YINKA\",\"ippis_number\":\"TI315663\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101180\",\"amount\":10000,\"shares\":0,\"member_id\":114,\"member_name\":\"ABBA MAHMOUD BARAU\",\"ippis_number\":\"TI315686\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101138\",\"amount\":10000,\"shares\":0,\"member_id\":121,\"member_name\":\"ABDULLAHI USMAN\",\"ippis_number\":\"TI315788\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101264\",\"amount\":5000,\"shares\":0,\"member_id\":115,\"member_name\":\"IDRISS BOMOI MOHAMMED\",\"ippis_number\":\"TI315667\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":30000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":4000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101119\",\"amount\":5000,\"shares\":0,\"member_id\":116,\"member_name\":\"SAMAILA HADIZA\",\"ippis_number\":\"TI315620\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:14:02', '2026-10-03 15:13:39', '2026-10-03 15:14:02'),
(15, '2026-08', 2, 'contribution-batches/WqvmPiJIJANQWg7mnNbAWjQoUwd5z5El1ZrQxLxM.csv', 1891000.00, 114, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":30000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100192\",\"amount\":20000,\"shares\":0,\"member_id\":1,\"member_name\":\"MAMUDA ABDULLAHI\",\"ippis_number\":\"TI53681\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100200\",\"amount\":20000,\"shares\":0,\"member_id\":108,\"member_name\":\"GERO SALE MOHAMMED\",\"ippis_number\":\"TI53688\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100184\",\"amount\":10000,\"shares\":0,\"member_id\":117,\"member_name\":\"MAIGORO MUSA MUHAMMAD\",\"ippis_number\":\"TI53677\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100981\",\"amount\":10000,\"shares\":0,\"member_id\":118,\"member_name\":\"BOGO ZAINAB AUDU\",\"ippis_number\":\"TI53983\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100337\",\"amount\":10000,\"shares\":0,\"member_id\":49,\"member_name\":\"FAROUK MARYAM UMAR\",\"ippis_number\":\"TI53717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":100000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100705\",\"amount\":5000,\"shares\":0,\"member_id\":109,\"member_name\":\"WAKILI HADIZA MOHAMMED\",\"ippis_number\":\"TI53815\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101069\",\"amount\":10000,\"shares\":0,\"member_id\":110,\"member_name\":\"USMAN DANLAMI BILTE\",\"ippis_number\":\"TI54036\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001031\",\"amount\":10000,\"shares\":0,\"member_id\":111,\"member_name\":\"YAU YUSUF\",\"ippis_number\":\"TI54019\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":20000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100928\",\"amount\":10000,\"shares\":0,\"member_id\":119,\"member_name\":\"KYARI SHETTIMA ABBA\",\"ippis_number\":\"TI53948\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100692\",\"amount\":20000,\"shares\":0,\"member_id\":120,\"member_name\":\"GALADIMA SAIDU BABA\",\"ippis_number\":\"TI53797\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101082\",\"amount\":10000,\"shares\":0,\"member_id\":112,\"member_name\":\"IBRAHIM ABBA ZAKAR\",\"ippis_number\":\"TI54044\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101240\",\"amount\":5000,\"shares\":0,\"member_id\":113,\"member_name\":\"YINUSA ABDULRAFIU YINKA\",\"ippis_number\":\"TI315663\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101180\",\"amount\":10000,\"shares\":0,\"member_id\":114,\"member_name\":\"ABBA MAHMOUD BARAU\",\"ippis_number\":\"TI315686\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101138\",\"amount\":10000,\"shares\":0,\"member_id\":121,\"member_name\":\"ABDULLAHI USMAN\",\"ippis_number\":\"TI315788\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101264\",\"amount\":5000,\"shares\":0,\"member_id\":115,\"member_name\":\"IDRISS BOMOI MOHAMMED\",\"ippis_number\":\"TI315667\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":30000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":4000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101119\",\"amount\":5000,\"shares\":0,\"member_id\":116,\"member_name\":\"SAMAILA HADIZA\",\"ippis_number\":\"TI315620\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:15', '2026-10-03 15:18:22');
INSERT INTO `contribution_batches` (`id`, `period`, `uploaded_by`, `file_path`, `total_amount`, `total_records`, `status`, `rows`, `validation_errors`, `posted_at`, `created_at`, `updated_at`) VALUES
(16, '2026-09', 2, 'contribution-batches/sKcNNABQbmZlvZen29NgUFBh42jVqSK9wGD02D4h.csv', 2121000.00, 117, 'posted', '[{\"staff_id\":\"FCE100141\",\"amount\":30000,\"shares\":0,\"member_id\":46,\"member_name\":\"DR YUNUSA MOHAMMED MADU\",\"ippis_number\":\"TI53653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101378\",\"amount\":50000,\"shares\":0,\"member_id\":69,\"member_name\":\"BUNDI ALHAJI GAMBO\",\"ippis_number\":\"TI146876\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100053\",\"amount\":100000,\"shares\":0,\"member_id\":95,\"member_name\":\"ALHAJI BASHIR BALA\",\"ippis_number\":\"TI53622\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100080\",\"amount\":10000,\"shares\":0,\"member_id\":47,\"member_name\":\"MUHAMMAD HASSAN NDAMAN\",\"ippis_number\":\"TI53630\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100139\",\"amount\":10000,\"shares\":0,\"member_id\":70,\"member_name\":\"PINDAR YUSUF KWI\",\"ippis_number\":\"TI53652\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100631\",\"amount\":40000,\"shares\":0,\"member_id\":2,\"member_name\":\"ADAM UMAR ABBA\",\"ippis_number\":\"TI53771\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100713\",\"amount\":100000,\"shares\":0,\"member_id\":3,\"member_name\":\"MOHAMMED MOHAMMED ARDO\",\"ippis_number\":\"TI53808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100122\",\"amount\":40000,\"shares\":0,\"member_id\":71,\"member_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"ippis_number\":\"TI53645\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100200\",\"amount\":20000,\"shares\":0,\"member_id\":108,\"member_name\":\"GERO SALE MOHAMMED\",\"ippis_number\":\"TI53688\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100205\",\"amount\":20000,\"shares\":0,\"member_id\":43,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53691\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100625\",\"amount\":150000,\"shares\":0,\"member_id\":122,\"member_name\":\"NANGERE MOHAMMED GARBA\",\"ippis_number\":\"TI53768\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100778\",\"amount\":30000,\"shares\":0,\"member_id\":4,\"member_name\":\"JIBRIN HASHIMU GUNDA\",\"ippis_number\":\"TI53844\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100774\",\"amount\":10000,\"shares\":0,\"member_id\":96,\"member_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"ippis_number\":\"TI53842\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100887\",\"amount\":30000,\"shares\":0,\"member_id\":5,\"member_name\":\"DALA ADAMU GARBA\",\"ippis_number\":\"TI53917\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100182\",\"amount\":30000,\"shares\":0,\"member_id\":6,\"member_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"ippis_number\":\"TI53676\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100818\",\"amount\":20000,\"shares\":0,\"member_id\":72,\"member_name\":\"BABA MOHAMMED RABIU\",\"ippis_number\":\"TI53873\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100184\",\"amount\":10000,\"shares\":0,\"member_id\":117,\"member_name\":\"MAIGORO MUSA MUHAMMAD\",\"ippis_number\":\"TI53677\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100733\",\"amount\":50000,\"shares\":0,\"member_id\":7,\"member_name\":\"ILIYASU MUSA YUSUF\",\"ippis_number\":\"TI53820\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100726\",\"amount\":20000,\"shares\":0,\"member_id\":8,\"member_name\":\"MUNTARI SAAD\",\"ippis_number\":\"TI53816\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100848\",\"amount\":10000,\"shares\":0,\"member_id\":59,\"member_name\":\"HASSAN MUHAMMAD ABBA\",\"ippis_number\":\"TI53889\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100816\",\"amount\":10000,\"shares\":0,\"member_id\":73,\"member_name\":\"BAKOJI BALA\",\"ippis_number\":\"TI53872\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100832\",\"amount\":20000,\"shares\":0,\"member_id\":9,\"member_name\":\"WAKILI BALA ADAMU\",\"ippis_number\":\"TI53878\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100857\",\"amount\":10000,\"shares\":0,\"member_id\":74,\"member_name\":\"DAWASA IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53896\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100900\",\"amount\":20000,\"shares\":0,\"member_id\":75,\"member_name\":\"MUSAH AMINU\",\"ippis_number\":\"TI53928\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100939\",\"amount\":50000,\"shares\":0,\"member_id\":67,\"member_name\":\"ZARMA BABAYO BOMOI\",\"ippis_number\":\"TI53955\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100843\",\"amount\":20000,\"shares\":0,\"member_id\":10,\"member_name\":\"BABA AJIYA IDRISSA\",\"ippis_number\":\"TI53886\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100861\",\"amount\":30000,\"shares\":0,\"member_id\":11,\"member_name\":\"GHULUZE MUHAMMAD IBN\",\"ippis_number\":\"TI53899\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100185\",\"amount\":100000,\"shares\":0,\"member_id\":76,\"member_name\":\"POKALAS TAIYATU\",\"ippis_number\":\"TI53678\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100547\",\"amount\":5000,\"shares\":0,\"member_id\":77,\"member_name\":\"WAZIRI MOHAMMED ADAMU\",\"ippis_number\":\"TI53743\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100782\",\"amount\":10000,\"shares\":0,\"member_id\":12,\"member_name\":\"LUCCU AJIYA MAINA\",\"ippis_number\":\"TI53847\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100851\",\"amount\":20000,\"shares\":0,\"member_id\":13,\"member_name\":\"GIMBA ISMAILA MOHAMMED\",\"ippis_number\":\"TI53891\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100870\",\"amount\":10000,\"shares\":0,\"member_id\":48,\"member_name\":\"YAU IBRAHIM\",\"ippis_number\":\"TI53905\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100905\",\"amount\":60000,\"shares\":0,\"member_id\":78,\"member_name\":\"MAMMAI YUSUF MOHAMMED\",\"ippis_number\":\"TI53931\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100981\",\"amount\":10000,\"shares\":0,\"member_id\":118,\"member_name\":\"BOGO ZAINAB AUDU\",\"ippis_number\":\"TI53983\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100215\",\"amount\":10000,\"shares\":0,\"member_id\":14,\"member_name\":\"BAWAJI HAUWA ABDU\",\"ippis_number\":\"TI53694\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001029\",\"amount\":100000,\"shares\":0,\"member_id\":79,\"member_name\":\"AJIYA ABUBAKAR BABA\",\"ippis_number\":\"TI54017\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100979\",\"amount\":10000,\"shares\":0,\"member_id\":80,\"member_name\":\"ALHAJI BAABA NURI FIKA\",\"ippis_number\":\"TI53981\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100705\",\"amount\":5000,\"shares\":0,\"member_id\":109,\"member_name\":\"WAKILI HADIZA MOHAMMED\",\"ippis_number\":\"TI53815\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100911\",\"amount\":10000,\"shares\":0,\"member_id\":61,\"member_name\":\"DAUDA YAHAYA ALHAJI\",\"ippis_number\":\"TI53937\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100941\",\"amount\":25000,\"shares\":0,\"member_id\":97,\"member_name\":\"TANKO GARBA\",\"ippis_number\":\"TI53956\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100858\",\"amount\":10000,\"shares\":0,\"member_id\":81,\"member_name\":\"MOHAMMED ABUBAKAR\",\"ippis_number\":\"TI53897\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101060\",\"amount\":20000,\"shares\":0,\"member_id\":16,\"member_name\":\"HAMZA SULEIMAN\",\"ippis_number\":\"TI54031\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101069\",\"amount\":10000,\"shares\":0,\"member_id\":110,\"member_name\":\"USMAN DANLAMI BILTE\",\"ippis_number\":\"TI54036\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200056\",\"amount\":10000,\"shares\":0,\"member_id\":17,\"member_name\":\"MANGA MUSA\",\"ippis_number\":\"TI53993\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100121\",\"amount\":10000,\"shares\":0,\"member_id\":98,\"member_name\":\"HARUNA MUAWIYA\",\"ippis_number\":\"TI53644\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100737\",\"amount\":15000,\"shares\":0,\"member_id\":18,\"member_name\":\"SHAMAKI AYUBA YAKUBU\",\"ippis_number\":\"TI53817\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100732\",\"amount\":20000,\"shares\":0,\"member_id\":50,\"member_name\":\"BARDE FATIMA ABUBAKAR\",\"ippis_number\":\"TI53819\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100916\",\"amount\":10000,\"shares\":0,\"member_id\":83,\"member_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"ippis_number\":\"TI53940\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200008\",\"amount\":10000,\"shares\":0,\"member_id\":62,\"member_name\":\"GARBA ASABE YUSUF\",\"ippis_number\":\"TI53759\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001031\",\"amount\":10000,\"shares\":0,\"member_id\":111,\"member_name\":\"YAU YUSUF\",\"ippis_number\":\"TI54019\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100789\",\"amount\":10000,\"shares\":0,\"member_id\":63,\"member_name\":\"BADEJO HARUNA ABUBAKAR\",\"ippis_number\":\"TI53852\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100791\",\"amount\":20000,\"shares\":0,\"member_id\":84,\"member_name\":\"LAMPO ZAKAR SULE\",\"ippis_number\":\"TI53853\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100928\",\"amount\":10000,\"shares\":0,\"member_id\":119,\"member_name\":\"KYARI SHETTIMA ABBA\",\"ippis_number\":\"TI53948\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101191\",\"amount\":10000,\"shares\":0,\"member_id\":20,\"member_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"ippis_number\":\"TI315548\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101057\",\"amount\":10000,\"shares\":0,\"member_id\":64,\"member_name\":\"KALLAMU ISA IBRAHIM\",\"ippis_number\":\"TI54030\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101076\",\"amount\":30000,\"shares\":0,\"member_id\":51,\"member_name\":\"ILUOBE MARY MODUPE\",\"ippis_number\":\"TI54039\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001017\",\"amount\":10000,\"shares\":0,\"member_id\":21,\"member_name\":\"YERIMA MUSA MAMMAN\",\"ippis_number\":\"TI54007\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101020\",\"amount\":10000,\"shares\":0,\"member_id\":22,\"member_name\":\"BADAWI MUHAMMAD HASSAN\",\"ippis_number\":\"TI54008\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200002\",\"amount\":10000,\"shares\":0,\"member_id\":52,\"member_name\":\"ABDULLAHI AISHA ALKALI\",\"ippis_number\":\"TI53754\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200019\",\"amount\":20000,\"shares\":0,\"member_id\":123,\"member_name\":\"USAKU ELIZABETH\",\"ippis_number\":\"TI53763\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101085\",\"amount\":5000,\"shares\":0,\"member_id\":23,\"member_name\":\"MUSA ABUBAKAR\",\"ippis_number\":\"TI54046\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100380\",\"amount\":10000,\"shares\":0,\"member_id\":24,\"member_name\":\"BAH UMAR M\",\"ippis_number\":\"TI53728\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100366\",\"amount\":10000,\"shares\":0,\"member_id\":65,\"member_name\":\"DISA ABUBAKAR\",\"ippis_number\":\"TI53723\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100692\",\"amount\":20000,\"shares\":0,\"member_id\":120,\"member_name\":\"GALADIMA SAIDU BABA\",\"ippis_number\":\"TI53797\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101082\",\"amount\":10000,\"shares\":0,\"member_id\":112,\"member_name\":\"IBRAHIM ABBA ZAKAR\",\"ippis_number\":\"TI54044\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100702\",\"amount\":15000,\"shares\":0,\"member_id\":66,\"member_name\":\"YUSUF HAMZA MUSA\",\"ippis_number\":\"TI53810\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200042\",\"amount\":10000,\"shares\":0,\"member_id\":25,\"member_name\":\"MUSA SAADATU MIRINGA\",\"ippis_number\":\"TI53824\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101092\",\"amount\":5000,\"shares\":0,\"member_id\":124,\"member_name\":\"UMAR USMAN MUHAMMAD\",\"ippis_number\":\"TI54053\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100736\",\"amount\":5000,\"shares\":0,\"member_id\":26,\"member_name\":\"GEIDAM HADIZA BABA\",\"ippis_number\":\"TI53811\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100696\",\"amount\":10000,\"shares\":0,\"member_id\":53,\"member_name\":\"ALI MOHAMMED\",\"ippis_number\":\"TI53800\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100514\",\"amount\":10000,\"shares\":0,\"member_id\":27,\"member_name\":\"NWARE HARUNA IDRIS\",\"ippis_number\":\"TI53740\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101240\",\"amount\":5000,\"shares\":0,\"member_id\":113,\"member_name\":\"YINUSA ABDULRAFIU YINKA\",\"ippis_number\":\"TI315663\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101139\",\"amount\":10000,\"shares\":0,\"member_id\":28,\"member_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"ippis_number\":\"TI315772\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100722\",\"amount\":5000,\"shares\":0,\"member_id\":125,\"member_name\":\"IBRAHIM MOHAMMED\",\"ippis_number\":\"TI53813\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100709\",\"amount\":10000,\"shares\":0,\"member_id\":29,\"member_name\":\"USMAN IBRAHIM GOJI\",\"ippis_number\":\"TI53814\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200059\",\"amount\":15000,\"shares\":0,\"member_id\":85,\"member_name\":\"DANLADI SULEIMAN\",\"ippis_number\":\"TI54002\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101232\",\"amount\":10000,\"shares\":0,\"member_id\":30,\"member_name\":\"HUSSAINI ISHIYAKU\",\"ippis_number\":\"TI315789\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101152\",\"amount\":10000,\"shares\":0,\"member_id\":100,\"member_name\":\"HARUNA YUSUF\",\"ippis_number\":\"TI315561\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101235\",\"amount\":10000,\"shares\":0,\"member_id\":31,\"member_name\":\"HARUNA ALIYU\",\"ippis_number\":\"TI315566\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101173\",\"amount\":20000,\"shares\":0,\"member_id\":86,\"member_name\":\"ISA ABDULLAHI\",\"ippis_number\":\"TI315569\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101227\",\"amount\":5000,\"shares\":0,\"member_id\":101,\"member_name\":\"BAPPAH ALIYU WAZIRI\",\"ippis_number\":\"TI315638\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101180\",\"amount\":10000,\"shares\":0,\"member_id\":114,\"member_name\":\"ABBA MAHMOUD BARAU\",\"ippis_number\":\"TI315686\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101132\",\"amount\":10000,\"shares\":0,\"member_id\":102,\"member_name\":\"BUKAR SULEIMAN\",\"ippis_number\":\"TI315704\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101345\",\"amount\":10000,\"shares\":0,\"member_id\":87,\"member_name\":\"GARBA UMAR AHMED\",\"ippis_number\":\"TI315729\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101237\",\"amount\":20000,\"shares\":0,\"member_id\":88,\"member_name\":\"ISA HASSAN\",\"ippis_number\":\"TI315730\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101244\",\"amount\":20000,\"shares\":0,\"member_id\":32,\"member_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"ippis_number\":\"TI315734\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101281\",\"amount\":5000,\"shares\":0,\"member_id\":103,\"member_name\":\"AHMED ABDULMUMINI GARBA\",\"ippis_number\":\"TI315779\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101138\",\"amount\":10000,\"shares\":0,\"member_id\":121,\"member_name\":\"ABDULLAHI USMAN\",\"ippis_number\":\"TI315788\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101380\",\"amount\":10000,\"shares\":0,\"member_id\":54,\"member_name\":\"SHUAIBU ZAKAR YA\'U\",\"ippis_number\":\"TI315803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101327\",\"amount\":20000,\"shares\":0,\"member_id\":104,\"member_name\":\"MUSA HASSAN\",\"ippis_number\":\"TI315808\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100624\",\"amount\":10000,\"shares\":0,\"member_id\":126,\"member_name\":\"HALLIRU IBRAHIM ALHAJI\",\"ippis_number\":\"TI53767\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100712\",\"amount\":5000,\"shares\":0,\"member_id\":89,\"member_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"ippis_number\":\"TI53803\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101362\",\"amount\":10000,\"shares\":0,\"member_id\":90,\"member_name\":\"SALIHU IDRIS YUNUSA\",\"ippis_number\":\"TI315618\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101275\",\"amount\":10000,\"shares\":0,\"member_id\":105,\"member_name\":\"HASSAN ALIYU ADAMU\",\"ippis_number\":\"TI315634\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101228\",\"amount\":7000,\"shares\":0,\"member_id\":33,\"member_name\":\"RABIU YAHUZA GARBA\",\"ippis_number\":\"TI315653\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101264\",\"amount\":5000,\"shares\":0,\"member_id\":115,\"member_name\":\"IDRISS BOMOI MOHAMMED\",\"ippis_number\":\"TI315667\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101259\",\"amount\":10000,\"shares\":0,\"member_id\":68,\"member_name\":\"MOHAMMED AUDU\",\"ippis_number\":\"TI315671\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101140\",\"amount\":10000,\"shares\":0,\"member_id\":55,\"member_name\":\"ABDULKADIR SAIDU\",\"ippis_number\":\"TI315717\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101147\",\"amount\":10000,\"shares\":0,\"member_id\":91,\"member_name\":\"ALI ISAH\",\"ippis_number\":\"TI315757\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101215\",\"amount\":5000,\"shares\":0,\"member_id\":44,\"member_name\":\"BASHIR HASHIMU\",\"ippis_number\":\"TI315769\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101231\",\"amount\":5000,\"shares\":0,\"member_id\":56,\"member_name\":\"MUSTAPHA AISHATU FIKA\",\"ippis_number\":\"TI315778\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101287\",\"amount\":5000,\"shares\":0,\"member_id\":106,\"member_name\":\"ALI GONI\",\"ippis_number\":\"TI315801\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101387\",\"amount\":10000,\"shares\":0,\"member_id\":34,\"member_name\":\"MUHAMMAD BINTA MUSA\",\"ippis_number\":\"TI339304\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101404\",\"amount\":5000,\"shares\":0,\"member_id\":107,\"member_name\":\"SULE SHAIBU ALHAJI\",\"ippis_number\":\"TI339314\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200065\",\"amount\":10000,\"shares\":0,\"member_id\":35,\"member_name\":\"CHIBOK HAUWA WAKIL\",\"ippis_number\":\"TI54023\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200067\",\"amount\":30000,\"shares\":0,\"member_id\":36,\"member_name\":\"SULEIMAN ABUBAKAR\",\"ippis_number\":\"TI54024\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE200057\",\"amount\":5000,\"shares\":0,\"member_id\":57,\"member_name\":\"LAWAN YAKUBU SAIDU\",\"ippis_number\":\"TI53998\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101041\",\"amount\":5000,\"shares\":0,\"member_id\":37,\"member_name\":\"MOHAMMED SALEH\",\"ippis_number\":\"TI54020\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001043\",\"amount\":10000,\"shares\":0,\"member_id\":38,\"member_name\":\"ADAMU UMAR KWAMI\",\"ippis_number\":\"TI26168\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100720\",\"amount\":5000,\"shares\":0,\"member_id\":39,\"member_name\":\"SHETTIMA ALHAJI SHEHU\",\"ippis_number\":\"TI26142\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001024\",\"amount\":5000,\"shares\":0,\"member_id\":40,\"member_name\":\"SAFIYANU GARBA\",\"ippis_number\":\"TI54013\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101268\",\"amount\":5000,\"shares\":0,\"member_id\":45,\"member_name\":\"MOHAMMED IBRAHIM\",\"ippis_number\":\"TI315661\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE1001037\",\"amount\":10000,\"shares\":0,\"member_id\":92,\"member_name\":\"ISAH AHMED MUSA\",\"ippis_number\":\"TI26164\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101084\",\"amount\":5000,\"shares\":0,\"member_id\":93,\"member_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"ippis_number\":\"TI26179\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE100960\",\"amount\":4000,\"shares\":0,\"member_id\":94,\"member_name\":\"ALI HAMSATU MOHAMMED\",\"ippis_number\":\"TI26154\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101208\",\"amount\":10000,\"shares\":0,\"member_id\":42,\"member_name\":\"MOHAMMED AHMED GIDADO\",\"ippis_number\":\"TI315662\",\"matched\":true,\"error\":null},{\"staff_id\":\"FCE101119\",\"amount\":5000,\"shares\":0,\"member_id\":116,\"member_name\":\"SAMAILA HADIZA\",\"ippis_number\":\"TI315620\",\"matched\":true,\"error\":null}]', NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:00', '2026-10-03 15:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `contribution_change_requests`
--

CREATE TABLE `contribution_change_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `current_amount` decimal(12,2) NOT NULL,
  `requested_amount` decimal(12,2) NOT NULL,
  `approved_amount` decimal(12,2) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `review_note` text DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_allocations`
--

CREATE TABLE `dividend_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dividend_period_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `average_share_balance` decimal(14,2) NOT NULL,
  `average_savings_balance` decimal(14,2) NOT NULL,
  `share_rate_applied` decimal(5,2) NOT NULL,
  `savings_rate_applied` decimal(5,2) NOT NULL,
  `share_dividend_amount` decimal(14,2) NOT NULL,
  `savings_interest_amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'calculated',
  `dividend_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `interest_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dividend_periods`
--

CREATE TABLE `dividend_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `fy_start_date` date NOT NULL,
  `fy_end_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `share_dividend_rate_pct` decimal(5,2) DEFAULT NULL,
  `savings_interest_rate_pct` decimal(5,2) DEFAULT NULL,
  `distributable_profit_snapshot` decimal(14,2) DEFAULT NULL,
  `total_share_dividend_amount` decimal(14,2) DEFAULT NULL,
  `total_savings_interest_amount` decimal(14,2) DEFAULT NULL,
  `opened_by` bigint(20) UNSIGNED NOT NULL,
  `declared_by` bigint(20) UNSIGNED DEFAULT NULL,
  `declared_at` timestamp NULL DEFAULT NULL,
  `calculated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `calculated_at` timestamp NULL DEFAULT NULL,
  `posted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documentable_type` varchar(255) NOT NULL,
  `documentable_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_no` varchar(255) NOT NULL,
  `budget_line_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `initiated_by` bigint(20) UNSIGNED NOT NULL,
  `chairman_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_reviewed_at` timestamp NULL DEFAULT NULL,
  `chairman_note` text DEFAULT NULL,
  `paid_by` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `loan_product_id` bigint(20) UNSIGNED NOT NULL,
  `loan_no` varchar(255) NOT NULL,
  `principal_amount` decimal(14,2) NOT NULL,
  `interest_admin_pct` decimal(5,2) NOT NULL,
  `interest_profit_pct` decimal(5,2) NOT NULL,
  `total_interest` decimal(14,2) NOT NULL,
  `interest_admin_amount` decimal(14,2) NOT NULL,
  `interest_profit_amount` decimal(14,2) NOT NULL,
  `total_repayable` decimal(14,2) NOT NULL,
  `tenure_months` int(10) UNSIGNED NOT NULL,
  `monthly_installment` decimal(14,2) NOT NULL,
  `multiplier_applied` decimal(5,2) DEFAULT NULL,
  `outstanding_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `applied_at` timestamp NULL DEFAULT NULL,
  `treasurer_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurer_reviewed_at` timestamp NULL DEFAULT NULL,
  `treasurer_note` text DEFAULT NULL,
  `chairman_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_reviewed_at` timestamp NULL DEFAULT NULL,
  `chairman_note` text DEFAULT NULL,
  `disbursed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_at` timestamp NULL DEFAULT NULL,
  `disbursement_method` varchar(255) DEFAULT NULL,
  `disbursement_reference` varchar(255) DEFAULT NULL,
  `is_legacy_import` tinyint(1) NOT NULL DEFAULT 0,
  `defaulted_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_guarantors`
--

CREATE TABLE `loan_guarantors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `guarantor_member_id` bigint(20) UNSIGNED NOT NULL,
  `pledged_amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'invited',
  `accepted_at` timestamp NULL DEFAULT NULL,
  `declined_at` timestamp NULL DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `deduction_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_import_batches`
--

CREATE TABLE `loan_import_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_records` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `imported_count` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'validated',
  `rows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rows`)),
  `imported_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_limit_multipliers`
--

CREATE TABLE `loan_limit_multipliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_product_id` bigint(20) UNSIGNED NOT NULL,
  `multiplier` decimal(5,2) NOT NULL,
  `effective_from` date NOT NULL,
  `set_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_limit_multipliers`
--

INSERT INTO `loan_limit_multipliers` (`id`, `loan_product_id`, `multiplier`, `effective_from`, `set_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 3.00, '2026-10-03', NULL, 1, '2026-10-03 12:46:17', '2026-10-03 12:46:17'),
(2, 2, 3.00, '2026-10-03', NULL, 1, '2026-10-03 12:46:17', '2026-10-03 12:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `loan_products`
--

CREATE TABLE `loan_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `interest_admin_pct` decimal(5,2) NOT NULL DEFAULT 2.00,
  `interest_profit_pct` decimal(5,2) NOT NULL DEFAULT 8.00,
  `max_tenure_months` int(10) UNSIGNED NOT NULL,
  `min_membership_months` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `min_savings_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `requires_guarantor` tinyint(1) NOT NULL DEFAULT 1,
  `min_guarantors` tinyint(3) UNSIGNED DEFAULT NULL,
  `max_guarantors` tinyint(3) UNSIGNED DEFAULT NULL,
  `disbursement_type` varchar(255) NOT NULL DEFAULT 'cash_or_bank',
  `default_after_days_overdue` int(10) UNSIGNED NOT NULL DEFAULT 30,
  `guarantor_grace_days` int(10) UNSIGNED NOT NULL DEFAULT 7,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_products`
--

INSERT INTO `loan_products` (`id`, `code`, `name`, `interest_admin_pct`, `interest_profit_pct`, `max_tenure_months`, `min_membership_months`, `min_savings_balance`, `requires_guarantor`, `min_guarantors`, `max_guarantors`, `disbursement_type`, `default_after_days_overdue`, `guarantor_grace_days`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'regular', 'Regular/Ordinary Loan', 2.00, 8.00, 12, 6, 0.00, 1, 1, 2, 'cash_or_bank', 30, 7, 1, '2026-10-03 12:46:17', '2026-10-03 12:46:17'),
(2, 'emergency', 'Emergency/Special Loan', 2.00, 8.00, 12, 6, 0.00, 1, 1, 2, 'cash_or_bank', 30, 7, 1, '2026-10-03 12:46:17', '2026-10-03 12:46:17'),
(3, 'commodity', 'Commodity Loan', 2.00, 8.00, 3, 0, 0.00, 0, NULL, NULL, 'goods', 30, 7, 1, '2026-10-03 12:46:17', '2026-10-03 12:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment_batches`
--

CREATE TABLE `loan_repayment_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_records` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'validated',
  `rows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rows`)),
  `validation_errors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`validation_errors`)),
  `posted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment_intents`
--

CREATE TABLE `loan_repayment_intents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `note` text DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `receipt_original_filename` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `decline_reason` text DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment_schedules`
--

CREATE TABLE `loan_repayment_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `installment_no` int(10) UNSIGNED NOT NULL,
  `due_date` date NOT NULL,
  `amount_due` decimal(14,2) NOT NULL,
  `amount_paid` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment_transactions`
--

CREATE TABLE `loan_repayment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `source_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reversed_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_savings_repayment_requests`
--

CREATE TABLE `loan_savings_repayment_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `savings_account_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `decline_reason` text DEFAULT NULL,
  `savings_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `loan_repayment_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `application_no` varchar(255) NOT NULL,
  `membership_no` varchar(255) DEFAULT NULL,
  `membership_date` date DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `ippis_number` varchar(255) DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') DEFAULT NULL,
  `home_address` text DEFAULT NULL,
  `phone_1` varchar(255) DEFAULT NULL,
  `phone_2` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) NOT NULL,
  `date_of_first_appointment` date DEFAULT NULL,
  `employment_status` enum('permanent','contract','casual') NOT NULL,
  `rank_grade` varchar(255) DEFAULT NULL,
  `staff_category` varchar(255) DEFAULT NULL,
  `preferred_monthly_contribution` decimal(12,2) NOT NULL,
  `approved_monthly_contribution` decimal(12,2) DEFAULT NULL,
  `mode_of_deduction` varchar(255) NOT NULL DEFAULT 'salary_deduction',
  `member_category` varchar(255) NOT NULL DEFAULT 'regular_staff',
  `declaration_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `declaration_signed_name` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','suspended','dormant','exited','deceased') NOT NULL DEFAULT 'pending',
  `application_fee_paid` tinyint(1) NOT NULL DEFAULT 0,
  `application_fee_paid_at` timestamp NULL DEFAULT NULL,
  `application_fee_source` varchar(255) DEFAULT NULL,
  `application_fee_marked_by` bigint(20) UNSIGNED DEFAULT NULL,
  `applied_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `dormant_flagged_at` timestamp NULL DEFAULT NULL,
  `last_contribution_at` timestamp NULL DEFAULT NULL,
  `exit_requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `exit_requested_at` timestamp NULL DEFAULT NULL,
  `exit_treasurer_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `exit_cleared_by` bigint(20) UNSIGNED DEFAULT NULL,
  `exit_cleared_at` timestamp NULL DEFAULT NULL,
  `exited_at` timestamp NULL DEFAULT NULL,
  `exit_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `user_id`, `application_no`, `membership_no`, `membership_date`, `full_name`, `date_of_birth`, `gender`, `ippis_number`, `marital_status`, `home_address`, `phone_1`, `phone_2`, `email`, `photo_path`, `department`, `staff_id`, `date_of_first_appointment`, `employment_status`, `rank_grade`, `staff_category`, `preferred_monthly_contribution`, `approved_monthly_contribution`, `mode_of_deduction`, `member_category`, `declaration_accepted`, `declaration_signed_name`, `status`, `application_fee_paid`, `application_fee_paid_at`, `application_fee_source`, `application_fee_marked_by`, `applied_at`, `approved_by`, `approved_at`, `rejected_at`, `rejection_reason`, `dormant_flagged_at`, `last_contribution_at`, `exit_requested_by`, `exit_requested_at`, `exit_treasurer_cleared`, `exit_cleared_by`, `exit_cleared_at`, `exited_at`, `exit_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 'FCET/CSL/00001', 'FCET/CSL/FCE100192', '2025-06-01', 'MAMUDA ABDULLAHI', NULL, NULL, 'TI53681', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100192', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MAMUDA ABDULLAHI', 'active', 1, '2026-10-03 11:32:08', 'legacy_import', 2, '2026-10-03 11:32:08', 2, '2026-10-03 11:32:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:08', '2026-10-03 11:32:08', NULL),
(2, 10, 'FCET/CSL/00002', 'FCET/CSL/FCE100631', '2025-06-01', 'ADAM UMAR ABBA', '1960-08-18', 'male', 'TI53771', 'married', 'FCE POTISKUM', '08055464166', NULL, 'director@mailinator.com', NULL, NULL, 'FCE100631', NULL, 'permanent', NULL, NULL, 40000.00, 40000.00, 'salary_deduction', 'regular_staff', 1, 'ADAM UMAR ABBA', 'active', 1, '2026-10-03 11:32:09', 'legacy_import', 2, '2026-10-03 11:32:09', 2, '2026-10-03 11:32:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:09', '2026-10-03 11:34:33', NULL),
(3, 11, 'FCET/CSL/00003', 'FCET/CSL/FCE100713', '2025-06-01', 'MOHAMMED MOHAMMED ARDO', NULL, NULL, 'TI53808', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100713', NULL, 'permanent', NULL, NULL, 50000.00, 50000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED MOHAMMED ARDO', 'active', 1, '2026-10-03 11:32:09', 'legacy_import', 2, '2026-10-03 11:32:09', 2, '2026-10-03 11:32:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:09', '2026-10-03 11:32:09', NULL),
(4, 12, 'FCET/CSL/00004', 'FCET/CSL/FCE100778', '2025-06-01', 'JIBRIN HASHIMU GUNDA', NULL, NULL, 'TI53844', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100778', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'JIBRIN HASHIMU GUNDA', 'active', 1, '2026-10-03 11:32:10', 'legacy_import', 2, '2026-10-03 11:32:10', 2, '2026-10-03 11:32:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10', NULL),
(5, 13, 'FCET/CSL/00005', 'FCET/CSL/FCE100887', '2025-06-01', 'DALA ADAMU GARBA', NULL, NULL, 'TI53917', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100887', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'DALA ADAMU GARBA', 'active', 1, '2026-10-03 11:32:10', 'legacy_import', 2, '2026-10-03 11:32:10', 2, '2026-10-03 11:32:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10', NULL),
(6, 14, 'FCET/CSL/00006', 'FCET/CSL/FCE100182', '2025-06-01', 'ABUBAKAR SAIDU ALHASSAN', NULL, NULL, 'TI53676', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100182', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'ABUBAKAR SAIDU ALHASSAN', 'active', 1, '2026-10-03 11:32:11', 'legacy_import', 2, '2026-10-03 11:32:11', 2, '2026-10-03 11:32:11', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:11', '2026-10-03 11:32:11', NULL),
(7, 15, 'FCET/CSL/00007', 'FCET/CSL/FCE100733', '2025-06-01', 'ILIYASU MUSA YUSUF', NULL, NULL, 'TI53820', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100733', NULL, 'permanent', NULL, NULL, 50000.00, 50000.00, 'salary_deduction', 'regular_staff', 1, 'ILIYASU MUSA YUSUF', 'active', 1, '2026-10-03 11:32:12', 'legacy_import', 2, '2026-10-03 11:32:12', 2, '2026-10-03 11:32:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12', NULL),
(8, 16, 'FCET/CSL/00008', 'FCET/CSL/FCE100726', '2025-06-01', 'MUNTARI SAAD', NULL, NULL, 'TI53816', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100726', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MUNTARI SAAD', 'active', 1, '2026-10-03 11:32:12', 'legacy_import', 2, '2026-10-03 11:32:12', 2, '2026-10-03 11:32:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12', NULL),
(9, 17, 'FCET/CSL/00009', 'FCET/CSL/FCE100832', '2025-06-01', 'WAKILI BALA ADAMU', NULL, NULL, 'TI53878', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100832', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'WAKILI BALA ADAMU', 'active', 1, '2026-10-03 11:32:13', 'legacy_import', 2, '2026-10-03 11:32:13', 2, '2026-10-03 11:32:13', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13', NULL),
(10, 18, 'FCET/CSL/00010', 'FCET/CSL/FCE100843', '2025-06-01', 'BABA AJIYA IDRISSA', NULL, NULL, 'TI53886', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100843', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'BABA AJIYA IDRISSA', 'active', 1, '2026-10-03 11:32:13', 'legacy_import', 2, '2026-10-03 11:32:13', 2, '2026-10-03 11:32:13', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13', NULL),
(11, 19, 'FCET/CSL/00011', 'FCET/CSL/FCE100861', '2025-06-01', 'GHULUZE MUHAMMAD IBN', NULL, NULL, 'TI53899', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100861', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'GHULUZE MUHAMMAD IBN', 'active', 1, '2026-10-03 11:32:14', 'legacy_import', 2, '2026-10-03 11:32:14', 2, '2026-10-03 11:32:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:14', '2026-10-03 11:32:14', NULL),
(12, 20, 'FCET/CSL/00012', 'FCET/CSL/FCE100782', '2025-06-01', 'LUCCU AJIYA MAINA', NULL, NULL, 'TI53847', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100782', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'LUCCU AJIYA MAINA', 'active', 1, '2026-10-03 11:32:15', 'legacy_import', 2, '2026-10-03 11:32:15', 2, '2026-10-03 11:32:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15', NULL),
(13, 21, 'FCET/CSL/00013', 'FCET/CSL/FCE100851', '2025-06-01', 'GIMBA ISMAILA MOHAMMED', NULL, NULL, 'TI53891', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100851', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'GIMBA ISMAILA MOHAMMED', 'active', 1, '2026-10-03 11:32:15', 'legacy_import', 2, '2026-10-03 11:32:15', 2, '2026-10-03 11:32:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15', NULL),
(14, 22, 'FCET/CSL/00014', 'FCET/CSL/FCE100215', '2025-06-01', 'BAWAJI HAUWA ABDU', NULL, NULL, 'TI53694', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100215', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BAWAJI HAUWA ABDU', 'active', 1, '2026-10-03 11:32:16', 'legacy_import', 2, '2026-10-03 11:32:16', 2, '2026-10-03 11:32:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16', NULL),
(15, 23, 'FCET/CSL/00015', 'FCET/CSL/FCE100913', '2025-06-01', 'MIDALA ZAKARIYAU HARUNA', NULL, NULL, 'TI53938', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100913', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MIDALA ZAKARIYAU HARUNA', 'active', 1, '2026-10-03 11:32:16', 'legacy_import', 2, '2026-10-03 11:32:16', 2, '2026-10-03 11:32:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16', NULL),
(16, 24, 'FCET/CSL/00016', 'FCET/CSL/FCE101060', '2025-06-01', 'HAMZA SULEIMAN', NULL, NULL, 'TI54031', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101060', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'HAMZA SULEIMAN', 'active', 1, '2026-10-03 11:32:17', 'legacy_import', 2, '2026-10-03 11:32:17', 2, '2026-10-03 11:32:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:17', '2026-10-03 11:32:17', NULL),
(17, 25, 'FCET/CSL/00017', 'FCET/CSL/FCE200056', '2025-06-01', 'MANGA MUSA', NULL, NULL, 'TI53993', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200056', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MANGA MUSA', 'active', 1, '2026-10-03 11:32:18', 'legacy_import', 2, '2026-10-03 11:32:18', 2, '2026-10-03 11:32:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18', NULL),
(18, 26, 'FCET/CSL/00018', 'FCET/CSL/FCE100737', '2025-06-01', 'SHAMAKI AYUBA YAKUBU', NULL, NULL, 'TI53817', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100737', NULL, 'permanent', NULL, NULL, 15000.00, 15000.00, 'salary_deduction', 'regular_staff', 1, 'SHAMAKI AYUBA YAKUBU', 'active', 1, '2026-10-03 11:32:18', 'legacy_import', 2, '2026-10-03 11:32:18', 2, '2026-10-03 11:32:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18', NULL),
(19, 27, 'FCET/CSL/00019', 'FCET/CSL/FCE100731', '2025-06-01', 'BARDE IDRISS IBRAHIM', NULL, NULL, 'TI53818', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100731', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BARDE IDRISS IBRAHIM', 'active', 1, '2026-10-03 11:32:19', 'legacy_import', 2, '2026-10-03 11:32:19', 2, '2026-10-03 11:32:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19', NULL),
(20, 28, 'FCET/CSL/00020', 'FCET/CSL/FCE101191', '2025-06-01', 'ABDULKADIR ABDULKARIM OLATUNJI', NULL, NULL, 'TI315548', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101191', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABDULKADIR ABDULKARIM OLATUNJI', 'active', 1, '2026-10-03 11:32:19', 'legacy_import', 2, '2026-10-03 11:32:19', 2, '2026-10-03 11:32:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19', NULL),
(21, 29, 'FCET/CSL/00021', 'FCET/CSL/FCE1001017', '2025-06-01', 'YERIMA MUSA MAMMAN', NULL, NULL, 'TI54007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001017', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YERIMA MUSA MAMMAN', 'active', 1, '2026-10-03 11:32:20', 'legacy_import', 2, '2026-10-03 11:32:20', 2, '2026-10-03 11:32:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20', NULL),
(22, 30, 'FCET/CSL/00022', 'FCET/CSL/FCE101020', '2025-06-01', 'BADAWI MUHAMMAD HASSAN', NULL, NULL, 'TI54008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101020', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BADAWI MUHAMMAD HASSAN', 'active', 1, '2026-10-03 11:32:20', 'legacy_import', 2, '2026-10-03 11:32:20', 2, '2026-10-03 11:32:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20', NULL),
(23, 31, 'FCET/CSL/00023', 'FCET/CSL/FCE101085', '2025-06-01', 'MUSA ABUBAKAR', NULL, NULL, 'TI54046', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101085', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MUSA ABUBAKAR', 'active', 1, '2026-10-03 11:32:21', 'legacy_import', 2, '2026-10-03 11:32:21', 2, '2026-10-03 11:32:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21', NULL),
(24, 32, 'FCET/CSL/00024', 'FCET/CSL/FCE100380', '2025-06-01', 'BAH UMAR M', NULL, NULL, 'TI53728', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100380', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BAH UMAR M', 'active', 1, '2026-10-03 11:32:21', 'legacy_import', 2, '2026-10-03 11:32:21', 2, '2026-10-03 11:32:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21', NULL),
(25, 33, 'FCET/CSL/00025', 'FCET/CSL/FCE200042', '2025-06-01', 'MUSA SAADATU MIRINGA', NULL, NULL, 'TI53824', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200042', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MUSA SAADATU MIRINGA', 'active', 1, '2026-10-03 11:32:22', 'legacy_import', 2, '2026-10-03 11:32:22', 2, '2026-10-03 11:32:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22', NULL),
(26, 34, 'FCET/CSL/00026', 'FCET/CSL/FCE100736', '2025-06-01', 'GEIDAM HADIZA BABA', NULL, NULL, 'TI53811', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100736', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'GEIDAM HADIZA BABA', 'active', 1, '2026-10-03 11:32:22', 'legacy_import', 2, '2026-10-03 11:32:22', 2, '2026-10-03 11:32:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22', NULL),
(27, 35, 'FCET/CSL/00027', 'FCET/CSL/FCE100514', '2025-06-01', 'NWARE HARUNA IDRIS', NULL, NULL, 'TI53740', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100514', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'NWARE HARUNA IDRIS', 'active', 1, '2026-10-03 11:32:23', 'legacy_import', 2, '2026-10-03 11:32:23', 2, '2026-10-03 11:32:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:23', '2026-10-03 11:32:23', NULL),
(28, 36, 'FCET/CSL/00028', 'FCET/CSL/FCE101139', '2025-06-01', 'YAMARKUMI AHMAD MUHAMMAD', NULL, NULL, 'TI315772', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101139', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YAMARKUMI AHMAD MUHAMMAD', 'active', 1, '2026-10-03 11:32:24', 'legacy_import', 2, '2026-10-03 11:32:24', 2, '2026-10-03 11:32:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24', NULL),
(29, 37, 'FCET/CSL/00029', 'FCET/CSL/FCE100709', '2025-06-01', 'USMAN IBRAHIM GOJI', NULL, NULL, 'TI53814', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100709', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'USMAN IBRAHIM GOJI', 'active', 1, '2026-10-03 11:32:24', 'legacy_import', 2, '2026-10-03 11:32:24', 2, '2026-10-03 11:32:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24', NULL),
(30, 38, 'FCET/CSL/00030', 'FCET/CSL/FCE101232', '2025-06-01', 'HUSSAINI ISHIYAKU', NULL, NULL, 'TI315789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101232', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HUSSAINI ISHIYAKU', 'active', 1, '2026-10-03 11:32:25', 'legacy_import', 2, '2026-10-03 11:32:25', 2, '2026-10-03 11:32:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25', NULL),
(31, 39, 'FCET/CSL/00031', 'FCET/CSL/FCE101235', '2025-06-01', 'HARUNA ALIYU', NULL, NULL, 'TI315566', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101235', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HARUNA ALIYU', 'active', 1, '2026-10-03 11:32:25', 'legacy_import', 2, '2026-10-03 11:32:25', 2, '2026-10-03 11:32:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25', NULL),
(32, 40, 'FCET/CSL/00032', 'FCET/CSL/FCE101244', '2025-06-01', 'ABUBAKAR MOHAMMED BOJUDE', NULL, NULL, 'TI315734', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101244', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'ABUBAKAR MOHAMMED BOJUDE', 'active', 1, '2026-10-03 11:32:26', 'legacy_import', 2, '2026-10-03 11:32:26', 2, '2026-10-03 11:32:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26', NULL),
(33, 41, 'FCET/CSL/00033', 'FCET/CSL/FCE101228', '2025-06-01', 'RABIU YAHUZA GARBA', NULL, NULL, 'TI315653', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101228', NULL, 'permanent', NULL, NULL, 7000.00, 7000.00, 'salary_deduction', 'regular_staff', 1, 'RABIU YAHUZA GARBA', 'active', 1, '2026-10-03 11:32:26', 'legacy_import', 2, '2026-10-03 11:32:26', 2, '2026-10-03 11:32:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26', NULL),
(34, 42, 'FCET/CSL/00034', 'FCET/CSL/FCE101387', '2025-06-01', 'MUHAMMAD BINTA MUSA', NULL, NULL, 'TI339304', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101387', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MUHAMMAD BINTA MUSA', 'active', 1, '2026-10-03 11:32:27', 'legacy_import', 2, '2026-10-03 11:32:27', 2, '2026-10-03 11:32:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:27', '2026-10-03 11:32:27', NULL),
(35, 43, 'FCET/CSL/00035', 'FCET/CSL/FCE200065', '2025-06-01', 'CHIBOK HAUWA WAKIL', NULL, NULL, 'TI54023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200065', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'CHIBOK HAUWA WAKIL', 'active', 1, '2026-10-03 11:32:28', 'legacy_import', 2, '2026-10-03 11:32:28', 2, '2026-10-03 11:32:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28', NULL),
(36, 44, 'FCET/CSL/00036', 'FCET/CSL/FCE200067', '2025-06-01', 'SULEIMAN ABUBAKAR', NULL, NULL, 'TI54024', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200067', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'SULEIMAN ABUBAKAR', 'active', 1, '2026-10-03 11:32:28', 'legacy_import', 2, '2026-10-03 11:32:28', 2, '2026-10-03 11:32:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28', NULL),
(37, 45, 'FCET/CSL/00037', 'FCET/CSL/FCE101041', '2025-06-01', 'MOHAMMED SALEH', NULL, NULL, 'TI54020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101041', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED SALEH', 'active', 1, '2026-10-03 11:32:29', 'legacy_import', 2, '2026-10-03 11:32:29', 2, '2026-10-03 11:32:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29', NULL),
(38, 46, 'FCET/CSL/00038', 'FCET/CSL/FCE1001043', '2025-06-01', 'ADAMU UMAR KWAMI', NULL, NULL, 'TI26168', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001043', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ADAMU UMAR KWAMI', 'active', 1, '2026-10-03 11:32:29', 'legacy_import', 2, '2026-10-03 11:32:29', 2, '2026-10-03 11:32:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29', NULL),
(39, 47, 'FCET/CSL/00039', 'FCET/CSL/FCE100720', '2025-06-01', 'SHETTIMA ALHAJI SHEHU', NULL, NULL, 'TI26142', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100720', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'SHETTIMA ALHAJI SHEHU', 'active', 1, '2026-10-03 11:32:30', 'legacy_import', 2, '2026-10-03 11:32:30', 2, '2026-10-03 11:32:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30', NULL),
(40, 48, 'FCET/CSL/00040', 'FCET/CSL/FCE1001024', '2025-06-01', 'SAFIYANU GARBA', NULL, NULL, 'TI54013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001024', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'SAFIYANU GARBA', 'active', 1, '2026-10-03 11:32:30', 'legacy_import', 2, '2026-10-03 11:32:30', 2, '2026-10-03 11:32:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30', NULL),
(41, 49, 'FCET/CSL/00041', 'FCET/CSL/FCE101061', '2025-06-01', 'TONTI ALIYU MOHAMMED', NULL, NULL, 'TI26173', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101061', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'TONTI ALIYU MOHAMMED', 'active', 1, '2026-10-03 11:32:31', 'legacy_import', 2, '2026-10-03 11:32:31', 2, '2026-10-03 11:32:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:31', '2026-10-03 11:32:31', NULL),
(42, 50, 'FCET/CSL/00042', 'FCET/CSL/FCE101208', '2025-06-01', 'MOHAMMED AHMED GIDADO', NULL, NULL, 'TI315662', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101208', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED AHMED GIDADO', 'active', 1, '2026-10-03 11:32:32', 'legacy_import', 2, '2026-10-03 11:32:32', 2, '2026-10-03 11:32:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 11:32:32', '2026-10-03 11:32:32', NULL),
(43, 51, 'FCET/CSL/00043', 'FCET/CSL/FCE100205', '2025-07-01', 'MOHAMMED ABUBAKAR', NULL, NULL, 'TI53691', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100205', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED ABUBAKAR', 'active', 1, '2026-10-03 14:24:47', 'legacy_import', 2, '2026-10-03 14:24:47', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', NULL),
(44, 52, 'FCET/CSL/00044', 'FCET/CSL/FCE101215', '2025-07-01', 'BASHIR HASHIMU', NULL, NULL, 'TI315769', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101215', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'BASHIR HASHIMU', 'active', 1, '2026-10-03 14:24:47', 'legacy_import', 2, '2026-10-03 14:24:47', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', NULL),
(45, 53, 'FCET/CSL/00045', 'FCET/CSL/FCE101268', '2025-07-01', 'MOHAMMED IBRAHIM', NULL, NULL, 'TI315661', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101268', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED IBRAHIM', 'active', 1, '2026-10-03 14:24:47', 'legacy_import', 2, '2026-10-03 14:24:47', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47', NULL),
(46, 54, 'FCET/CSL/00046', 'FCET/CSL/FCE100141', '2025-08-01', 'DR YUNUSA MOHAMMED MADU', NULL, NULL, 'TI53653', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100141', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'DR YUNUSA MOHAMMED MADU', 'active', 1, '2026-10-03 14:28:23', 'legacy_import', 2, '2026-10-03 14:28:23', 2, '2026-10-03 14:28:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23', NULL),
(47, 55, 'FCET/CSL/00047', 'FCET/CSL/FCE100080', '2025-08-01', 'MUHAMMAD HASSAN NDAMAN', NULL, NULL, 'TI53630', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100080', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MUHAMMAD HASSAN NDAMAN', 'active', 1, '2026-10-03 14:28:23', 'legacy_import', 2, '2026-10-03 14:28:23', 2, '2026-10-03 14:28:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23', NULL),
(48, 56, 'FCET/CSL/00048', 'FCET/CSL/FCE100870', '2025-08-01', 'YAU IBRAHIM', NULL, NULL, 'TI53905', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100870', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YAU IBRAHIM', 'active', 1, '2026-10-03 14:28:24', 'legacy_import', 2, '2026-10-03 14:28:24', 2, '2026-10-03 14:28:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24', NULL),
(49, 57, 'FCET/CSL/00049', 'FCET/CSL/FCE100337', '2025-08-01', 'FAROUK MARYAM UMAR', NULL, NULL, 'TI53717', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100337', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'FAROUK MARYAM UMAR', 'active', 1, '2026-10-03 14:28:24', 'legacy_import', 2, '2026-10-03 14:28:24', 2, '2026-10-03 14:28:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24', NULL),
(50, 58, 'FCET/CSL/00050', 'FCET/CSL/FCE100732', '2025-08-01', 'BARDE FATIMA ABUBAKAR', NULL, NULL, 'TI53819', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100732', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'BARDE FATIMA ABUBAKAR', 'active', 1, '2026-10-03 14:28:25', 'legacy_import', 2, '2026-10-03 14:28:25', 2, '2026-10-03 14:28:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:25', '2026-10-03 14:28:25', NULL),
(51, 59, 'FCET/CSL/00051', 'FCET/CSL/FCE101076', '2025-08-01', 'ILUOBE MARY MODUPE', NULL, NULL, 'TI54039', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101076', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'ILUOBE MARY MODUPE', 'active', 1, '2026-10-03 14:28:26', 'legacy_import', 2, '2026-10-03 14:28:26', 2, '2026-10-03 14:28:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26', NULL),
(52, 60, 'FCET/CSL/00052', 'FCET/CSL/FCE200002', '2025-08-01', 'ABDULLAHI AISHA ALKALI', NULL, NULL, 'TI53754', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200002', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABDULLAHI AISHA ALKALI', 'active', 1, '2026-10-03 14:28:26', 'legacy_import', 2, '2026-10-03 14:28:26', 2, '2026-10-03 14:28:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26', NULL),
(53, 61, 'FCET/CSL/00053', 'FCET/CSL/FCE100696', '2025-08-01', 'ALI MOHAMMED', NULL, NULL, 'TI53800', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100696', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ALI MOHAMMED', 'active', 1, '2026-10-03 14:28:27', 'legacy_import', 2, '2026-10-03 14:28:27', 2, '2026-10-03 14:28:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27', NULL),
(54, 62, 'FCET/CSL/00054', 'FCET/CSL/FCE101380', '2025-08-01', 'SHUAIBU ZAKAR YA\'U', NULL, NULL, 'TI315803', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101380', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'SHUAIBU ZAKAR YA\'U', 'active', 1, '2026-10-03 14:28:27', 'legacy_import', 2, '2026-10-03 14:28:27', 2, '2026-10-03 14:28:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27', NULL),
(55, 63, 'FCET/CSL/00055', 'FCET/CSL/FCE101140', '2025-08-01', 'ABDULKADIR SAIDU', NULL, NULL, 'TI315717', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101140', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABDULKADIR SAIDU', 'active', 1, '2026-10-03 14:28:28', 'legacy_import', 2, '2026-10-03 14:28:28', 2, '2026-10-03 14:28:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:28', '2026-10-03 14:28:28', NULL),
(56, 64, 'FCET/CSL/00056', 'FCET/CSL/FCE101231', '2025-08-01', 'MUSTAPHA AISHATU FIKA', NULL, NULL, 'TI315778', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101231', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MUSTAPHA AISHATU FIKA', 'active', 1, '2026-10-03 14:28:29', 'legacy_import', 2, '2026-10-03 14:28:29', 2, '2026-10-03 14:28:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29', NULL),
(57, 65, 'FCET/CSL/00057', 'FCET/CSL/FCE200057', '2025-08-01', 'LAWAN YAKUBU SAIDU', NULL, NULL, 'TI53998', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200057', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'LAWAN YAKUBU SAIDU', 'active', 1, '2026-10-03 14:28:29', 'legacy_import', 2, '2026-10-03 14:28:29', 2, '2026-10-03 14:28:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29', NULL),
(58, 66, 'FCET/CSL/00058', 'FCET/CSL/FCE101423', '2025-08-01', 'MUHAMMAD YUSUF MUHAMMAD', NULL, NULL, 'TI339340', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101423', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MUHAMMAD YUSUF MUHAMMAD', 'active', 1, '2026-10-03 14:28:30', 'legacy_import', 2, '2026-10-03 14:28:30', 2, '2026-10-03 14:28:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:28:30', '2026-10-03 14:28:30', NULL),
(59, 67, 'FCET/CSL/00059', 'FCET/CSL/FCE100848', '2025-09-01', 'HASSAN MUHAMMAD ABBA', NULL, NULL, 'TI53889', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100848', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HASSAN MUHAMMAD ABBA', 'active', 1, '2026-10-03 14:30:58', 'legacy_import', 2, '2026-10-03 14:30:58', 2, '2026-10-03 14:30:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:30:58', '2026-10-03 14:30:58', NULL),
(60, 68, 'FCET/CSL/00060', 'FCET/CSL/FCE100674', '2025-09-01', 'USMAN NANA', NULL, NULL, 'TI53784', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100674', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'USMAN NANA', 'active', 1, '2026-10-03 14:30:59', 'legacy_import', 2, '2026-10-03 14:30:59', 2, '2026-10-03 14:30:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59', NULL),
(61, 69, 'FCET/CSL/00061', 'FCET/CSL/FCE100911', '2025-09-01', 'DAUDA YAHAYA ALHAJI', NULL, NULL, 'TI53937', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100911', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'DAUDA YAHAYA ALHAJI', 'active', 1, '2026-10-03 14:30:59', 'legacy_import', 2, '2026-10-03 14:30:59', 2, '2026-10-03 14:30:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59', NULL),
(62, 70, 'FCET/CSL/00062', 'FCET/CSL/FCE200008', '2025-09-01', 'GARBA ASABE YUSUF', NULL, NULL, 'TI53759', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200008', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'GARBA ASABE YUSUF', 'active', 1, '2026-10-03 14:31:00', 'legacy_import', 2, '2026-10-03 14:31:00', 2, '2026-10-03 14:31:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00', NULL),
(63, 71, 'FCET/CSL/00063', 'FCET/CSL/FCE100789', '2025-09-01', 'BADEJO HARUNA ABUBAKAR', NULL, NULL, 'TI53852', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100789', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BADEJO HARUNA ABUBAKAR', 'active', 1, '2026-10-03 14:31:00', 'legacy_import', 2, '2026-10-03 14:31:00', 2, '2026-10-03 14:31:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00', NULL),
(64, 72, 'FCET/CSL/00064', 'FCET/CSL/FCE101057', '2025-09-01', 'KALLAMU ISA IBRAHIM', NULL, NULL, 'TI54030', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101057', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'KALLAMU ISA IBRAHIM', 'active', 1, '2026-10-03 14:31:01', 'legacy_import', 2, '2026-10-03 14:31:01', 2, '2026-10-03 14:31:01', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01', NULL),
(65, 73, 'FCET/CSL/00065', 'FCET/CSL/FCE100366', '2025-09-01', 'DISA ABUBAKAR', NULL, NULL, 'TI53723', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100366', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'DISA ABUBAKAR', 'active', 1, '2026-10-03 14:31:01', 'legacy_import', 2, '2026-10-03 14:31:01', 2, '2026-10-03 14:31:01', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01', NULL),
(66, 74, 'FCET/CSL/00066', 'FCET/CSL/FCE100702', '2025-09-01', 'YUSUF HAMZA MUSA', NULL, NULL, 'TI53810', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100702', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YUSUF HAMZA MUSA', 'active', 1, '2026-10-03 14:31:02', 'legacy_import', 2, '2026-10-03 14:31:02', 2, '2026-10-03 14:31:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:31:02', '2026-10-03 14:31:02', NULL),
(67, 75, 'FCET/CSL/00067', 'FCET/CSL/FCE100939', '2025-11-01', 'ZARMA BABAYO BOMOI', NULL, NULL, 'TI53955', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100939', NULL, 'permanent', NULL, NULL, 50000.00, 50000.00, 'salary_deduction', 'regular_staff', 1, 'ZARMA BABAYO BOMOI', 'active', 1, '2026-10-03 14:42:58', 'legacy_import', 2, '2026-10-03 14:42:58', 2, '2026-10-03 14:42:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:42:58', '2026-10-03 14:42:58', NULL),
(68, 76, 'FCET/CSL/00068', 'FCET/CSL/FCE101259', '2025-11-01', 'MOHAMMED AUDU', NULL, NULL, 'TI315671', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101259', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED AUDU', 'active', 1, '2026-10-03 14:42:59', 'legacy_import', 2, '2026-10-03 14:42:59', 2, '2026-10-03 14:42:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 14:42:59', '2026-10-03 14:42:59', NULL),
(69, 77, 'FCET/CSL/00069', 'FCET/CSL/FCE101378', '2026-02-01', 'BUNDI ALHAJI GAMBO', NULL, NULL, 'TI146876', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101378', NULL, 'permanent', NULL, NULL, 50000.00, 50000.00, 'salary_deduction', 'regular_staff', 1, 'BUNDI ALHAJI GAMBO', 'active', 1, '2026-10-03 15:04:20', 'legacy_import', 2, '2026-10-03 15:04:20', 2, '2026-10-03 15:04:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:20', '2026-10-03 15:04:20', NULL),
(70, 78, 'FCET/CSL/00070', 'FCET/CSL/FCE100139', '2026-02-01', 'PINDAR YUSUF KWI', NULL, NULL, 'TI53652', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100139', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'PINDAR YUSUF KWI', 'active', 1, '2026-10-03 15:04:21', 'legacy_import', 2, '2026-10-03 15:04:21', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', NULL),
(71, 79, 'FCET/CSL/00071', 'FCET/CSL/FCE100122', '2026-02-01', 'ABDULLAHI YAHAYA POTISKUM', NULL, NULL, 'TI53645', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100122', NULL, 'permanent', NULL, NULL, 40000.00, 40000.00, 'salary_deduction', 'regular_staff', 1, 'ABDULLAHI YAHAYA POTISKUM', 'active', 1, '2026-10-03 15:04:21', 'legacy_import', 2, '2026-10-03 15:04:21', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', NULL),
(72, 80, 'FCET/CSL/00072', 'FCET/CSL/FCE100818', '2026-02-01', 'BABA MOHAMMED RABIU', NULL, NULL, 'TI53873', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100818', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'BABA MOHAMMED RABIU', 'active', 1, '2026-10-03 15:04:21', 'legacy_import', 2, '2026-10-03 15:04:21', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21', NULL),
(73, 81, 'FCET/CSL/00073', 'FCET/CSL/FCE100816', '2026-02-01', 'BAKOJI BALA', NULL, NULL, 'TI53872', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100816', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BAKOJI BALA', 'active', 1, '2026-10-03 15:04:22', 'legacy_import', 2, '2026-10-03 15:04:22', 2, '2026-10-03 15:04:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22', NULL),
(74, 82, 'FCET/CSL/00074', 'FCET/CSL/FCE100857', '2026-02-01', 'DAWASA IBRAHIM MOHAMMED', NULL, NULL, 'TI53896', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100857', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'DAWASA IBRAHIM MOHAMMED', 'active', 1, '2026-10-03 15:04:22', 'legacy_import', 2, '2026-10-03 15:04:22', 2, '2026-10-03 15:04:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22', NULL),
(75, 83, 'FCET/CSL/00075', 'FCET/CSL/FCE100900', '2026-02-01', 'MUSAH AMINU', NULL, NULL, 'TI53928', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100900', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MUSAH AMINU', 'active', 1, '2026-10-03 15:04:23', 'legacy_import', 2, '2026-10-03 15:04:23', 2, '2026-10-03 15:04:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23', NULL),
(76, 84, 'FCET/CSL/00076', 'FCET/CSL/FCE100185', '2026-02-01', 'POKALAS TAIYATU', NULL, NULL, 'TI53678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100185', NULL, 'permanent', NULL, NULL, 100000.00, 100000.00, 'salary_deduction', 'regular_staff', 1, 'POKALAS TAIYATU', 'active', 1, '2026-10-03 15:04:23', 'legacy_import', 2, '2026-10-03 15:04:23', 2, '2026-10-03 15:04:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23', NULL),
(77, 85, 'FCET/CSL/00077', 'FCET/CSL/FCE100547', '2026-02-01', 'WAZIRI MOHAMMED ADAMU', NULL, NULL, 'TI53743', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100547', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'WAZIRI MOHAMMED ADAMU', 'active', 1, '2026-10-03 15:04:24', 'legacy_import', 2, '2026-10-03 15:04:24', 2, '2026-10-03 15:04:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24', NULL),
(78, 86, 'FCET/CSL/00078', 'FCET/CSL/FCE100905', '2026-02-01', 'MAMMAI YUSUF MOHAMMED', NULL, NULL, 'TI53931', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100905', NULL, 'permanent', NULL, NULL, 60000.00, 60000.00, 'salary_deduction', 'regular_staff', 1, 'MAMMAI YUSUF MOHAMMED', 'active', 1, '2026-10-03 15:04:24', 'legacy_import', 2, '2026-10-03 15:04:24', 2, '2026-10-03 15:04:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24', NULL),
(79, 87, 'FCET/CSL/00079', 'FCET/CSL/FCE1001029', '2026-02-01', 'AJIYA ABUBAKAR BABA', NULL, NULL, 'TI54017', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001029', NULL, 'permanent', NULL, NULL, 50000.00, 50000.00, 'salary_deduction', 'regular_staff', 1, 'AJIYA ABUBAKAR BABA', 'active', 1, '2026-10-03 15:04:25', 'legacy_import', 2, '2026-10-03 15:04:25', 2, '2026-10-03 15:04:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25', NULL),
(80, 88, 'FCET/CSL/00080', 'FCET/CSL/FCE100979', '2026-02-01', 'ALHAJI BAABA NURI FIKA', NULL, NULL, 'TI53981', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100979', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ALHAJI BAABA NURI FIKA', 'active', 1, '2026-10-03 15:04:25', 'legacy_import', 2, '2026-10-03 15:04:25', 2, '2026-10-03 15:04:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25', NULL),
(81, 89, 'FCET/CSL/00081', 'FCET/CSL/FCE100858', '2026-02-01', 'MOHAMMED ABUBAKAR', NULL, NULL, 'TI53897', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100858', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED ABUBAKAR', 'active', 1, '2026-10-03 15:04:26', 'legacy_import', 2, '2026-10-03 15:04:26', 2, '2026-10-03 15:04:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26', NULL),
(82, 90, 'FCET/CSL/00082', 'FCET/CSL/FCE100932', '2026-02-01', 'HASSAN MUSA', NULL, NULL, 'TI5950', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100932', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'HASSAN MUSA', 'active', 1, '2026-10-03 15:04:27', 'legacy_import', 2, '2026-10-03 15:04:27', 2, '2026-10-03 15:04:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27', NULL),
(83, 91, 'FCET/CSL/00083', 'FCET/CSL/FCE100916', '2026-02-01', 'ABUBAKAR MUHAMMAD ABUBAKAR', NULL, NULL, 'TI53940', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100916', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABUBAKAR MUHAMMAD ABUBAKAR', 'active', 1, '2026-10-03 15:04:27', 'legacy_import', 2, '2026-10-03 15:04:27', 2, '2026-10-03 15:04:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27', NULL),
(84, 92, 'FCET/CSL/00084', 'FCET/CSL/FCE100791', '2026-02-01', 'LAMPO ZAKAR SULE', NULL, NULL, 'TI53853', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100791', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'LAMPO ZAKAR SULE', 'active', 1, '2026-10-03 15:04:28', 'legacy_import', 2, '2026-10-03 15:04:28', 2, '2026-10-03 15:04:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28', NULL),
(85, 93, 'FCET/CSL/00085', 'FCET/CSL/FCE200059', '2026-02-01', 'DANLADI SULEIMAN', NULL, NULL, 'TI54002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200059', NULL, 'permanent', NULL, NULL, 15000.00, 15000.00, 'salary_deduction', 'regular_staff', 1, 'DANLADI SULEIMAN', 'active', 1, '2026-10-03 15:04:28', 'legacy_import', 2, '2026-10-03 15:04:28', 2, '2026-10-03 15:04:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28', NULL),
(86, 94, 'FCET/CSL/00086', 'FCET/CSL/FCE101173', '2026-02-01', 'ISA ABDULLAHI', NULL, NULL, 'TI315569', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101173', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'ISA ABDULLAHI', 'active', 1, '2026-10-03 15:04:29', 'legacy_import', 2, '2026-10-03 15:04:29', 2, '2026-10-03 15:04:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:29', '2026-10-03 15:04:29', NULL),
(87, 95, 'FCET/CSL/00087', 'FCET/CSL/FCE101345', '2026-02-01', 'GARBA UMAR AHMED', NULL, NULL, 'TI315729', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101345', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'GARBA UMAR AHMED', 'active', 1, '2026-10-03 15:04:30', 'legacy_import', 2, '2026-10-03 15:04:30', 2, '2026-10-03 15:04:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30', NULL),
(88, 96, 'FCET/CSL/00088', 'FCET/CSL/FCE101237', '2026-02-01', 'ISA HASSAN', NULL, NULL, 'TI315730', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101237', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'ISA HASSAN', 'active', 1, '2026-10-03 15:04:30', 'legacy_import', 2, '2026-10-03 15:04:30', 2, '2026-10-03 15:04:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30', NULL),
(89, 97, 'FCET/CSL/00089', 'FCET/CSL/FCE100712', '2026-02-01', 'MAMMAI MOHAMMED MOHAMMED', NULL, NULL, 'TI53803', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100712', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MAMMAI MOHAMMED MOHAMMED', 'active', 1, '2026-10-03 15:04:31', 'legacy_import', 2, '2026-10-03 15:04:31', 2, '2026-10-03 15:04:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31', NULL),
(90, 98, 'FCET/CSL/00090', 'FCET/CSL/FCE101362', '2026-02-01', 'SALIHU IDRIS YUNUSA', NULL, NULL, 'TI315618', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101362', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'SALIHU IDRIS YUNUSA', 'active', 1, '2026-10-03 15:04:31', 'legacy_import', 2, '2026-10-03 15:04:31', 2, '2026-10-03 15:04:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31', NULL),
(91, 99, 'FCET/CSL/00091', 'FCET/CSL/FCE101147', '2026-02-01', 'ALI ISAH', NULL, NULL, 'TI315757', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101147', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ALI ISAH', 'active', 1, '2026-10-03 15:04:32', 'legacy_import', 2, '2026-10-03 15:04:32', 2, '2026-10-03 15:04:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:32', '2026-10-03 15:04:32', NULL),
(92, 100, 'FCET/CSL/00092', 'FCET/CSL/FCE1001037', '2026-02-01', 'ISAH AHMED MUSA', NULL, NULL, 'TI26164', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001037', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ISAH AHMED MUSA', 'active', 1, '2026-10-03 15:04:33', 'legacy_import', 2, '2026-10-03 15:04:33', 2, '2026-10-03 15:04:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33', NULL),
(93, 101, 'FCET/CSL/00093', 'FCET/CSL/FCE101084', '2026-02-01', 'CHIWAR BUKAR MOHAMMED KABU', NULL, NULL, 'TI26179', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101084', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'CHIWAR BUKAR MOHAMMED KABU', 'active', 1, '2026-10-03 15:04:33', 'legacy_import', 2, '2026-10-03 15:04:33', 2, '2026-10-03 15:04:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33', NULL),
(94, 102, 'FCET/CSL/00094', 'FCET/CSL/FCE100960', '2026-02-01', 'ALI HAMSATU MOHAMMED', NULL, NULL, 'TI26154', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100960', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'ALI HAMSATU MOHAMMED', 'active', 1, '2026-10-03 15:04:34', 'legacy_import', 2, '2026-10-03 15:04:34', 2, '2026-10-03 15:04:34', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:04:34', '2026-10-03 15:04:34', NULL),
(95, 103, 'FCET/CSL/00095', 'FCET/CSL/FCE100053', '2026-03-01', 'ALHAJI BASHIR BALA', NULL, NULL, 'TI53622', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100053', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'ALHAJI BASHIR BALA', 'active', 1, '2026-10-03 15:07:19', 'legacy_import', 2, '2026-10-03 15:07:19', 2, '2026-10-03 15:07:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:19', '2026-10-03 15:07:19', NULL),
(96, 104, 'FCET/CSL/00096', 'FCET/CSL/FCE100774', '2026-03-01', 'TIJANI ABDULGAFAR OLAKUNLE', NULL, NULL, 'TI53842', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100774', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'TIJANI ABDULGAFAR OLAKUNLE', 'active', 1, '2026-10-03 15:07:20', 'legacy_import', 2, '2026-10-03 15:07:20', 2, '2026-10-03 15:07:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20', NULL),
(97, 105, 'FCET/CSL/00097', 'FCET/CSL/FCE100941', '2026-03-01', 'TANKO GARBA', NULL, NULL, 'TI53956', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100941', NULL, 'permanent', NULL, NULL, 25000.00, 25000.00, 'salary_deduction', 'regular_staff', 1, 'TANKO GARBA', 'active', 1, '2026-10-03 15:07:20', 'legacy_import', 2, '2026-10-03 15:07:20', 2, '2026-10-03 15:07:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20', NULL),
(98, 106, 'FCET/CSL/00098', 'FCET/CSL/FCE100121', '2026-03-01', 'HARUNA MUAWIYA', NULL, NULL, 'TI53644', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100121', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HARUNA MUAWIYA', 'active', 1, '2026-10-03 15:07:21', 'legacy_import', 2, '2026-10-03 15:07:21', 2, '2026-10-03 15:07:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:21', '2026-10-03 15:07:21', NULL),
(99, 107, 'FCET/CSL/00099', 'FCET/CSL/FCE100717', '2026-03-01', 'LAWANDI SULYMAN ISMAIL', NULL, NULL, 'TI53809', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100717', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'LAWANDI SULYMAN ISMAIL', 'active', 1, '2026-10-03 15:07:22', 'legacy_import', 2, '2026-10-03 15:07:22', 2, '2026-10-03 15:07:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22', NULL);
INSERT INTO `members` (`id`, `user_id`, `application_no`, `membership_no`, `membership_date`, `full_name`, `date_of_birth`, `gender`, `ippis_number`, `marital_status`, `home_address`, `phone_1`, `phone_2`, `email`, `photo_path`, `department`, `staff_id`, `date_of_first_appointment`, `employment_status`, `rank_grade`, `staff_category`, `preferred_monthly_contribution`, `approved_monthly_contribution`, `mode_of_deduction`, `member_category`, `declaration_accepted`, `declaration_signed_name`, `status`, `application_fee_paid`, `application_fee_paid_at`, `application_fee_source`, `application_fee_marked_by`, `applied_at`, `approved_by`, `approved_at`, `rejected_at`, `rejection_reason`, `dormant_flagged_at`, `last_contribution_at`, `exit_requested_by`, `exit_requested_at`, `exit_treasurer_cleared`, `exit_cleared_by`, `exit_cleared_at`, `exited_at`, `exit_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(100, 108, 'FCET/CSL/00100', 'FCET/CSL/FCE101152', '2026-03-01', 'HARUNA YUSUF', NULL, NULL, 'TI315561', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101152', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HARUNA YUSUF', 'active', 1, '2026-10-03 15:07:22', 'legacy_import', 2, '2026-10-03 15:07:22', 2, '2026-10-03 15:07:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22', NULL),
(101, 109, 'FCET/CSL/00101', 'FCET/CSL/FCE101227', '2026-03-01', 'BAPPAH ALIYU WAZIRI', NULL, NULL, 'TI315638', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101227', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'BAPPAH ALIYU WAZIRI', 'active', 1, '2026-10-03 15:07:23', 'legacy_import', 2, '2026-10-03 15:07:23', 2, '2026-10-03 15:07:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:23', '2026-10-03 15:07:23', NULL),
(102, 110, 'FCET/CSL/00102', 'FCET/CSL/FCE101132', '2026-03-01', 'BUKAR SULEIMAN', NULL, NULL, 'TI315704', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101132', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BUKAR SULEIMAN', 'active', 1, '2026-10-03 15:07:24', 'legacy_import', 2, '2026-10-03 15:07:24', 2, '2026-10-03 15:07:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24', NULL),
(103, 111, 'FCET/CSL/00103', 'FCET/CSL/FCE101281', '2026-03-01', 'AHMED ABDULMUMINI GARBA', NULL, NULL, 'TI315779', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101281', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'AHMED ABDULMUMINI GARBA', 'active', 1, '2026-10-03 15:07:24', 'legacy_import', 2, '2026-10-03 15:07:24', 2, '2026-10-03 15:07:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24', NULL),
(104, 112, 'FCET/CSL/00104', 'FCET/CSL/FCE101327', '2026-03-01', 'MUSA HASSAN', NULL, NULL, 'TI315808', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101327', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'MUSA HASSAN', 'active', 1, '2026-10-03 15:07:25', 'legacy_import', 2, '2026-10-03 15:07:25', 2, '2026-10-03 15:07:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25', NULL),
(105, 113, 'FCET/CSL/00105', 'FCET/CSL/FCE101275', '2026-03-01', 'HASSAN ALIYU ADAMU', NULL, NULL, 'TI315634', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101275', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HASSAN ALIYU ADAMU', 'active', 1, '2026-10-03 15:07:25', 'legacy_import', 2, '2026-10-03 15:07:25', 2, '2026-10-03 15:07:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25', NULL),
(106, 114, 'FCET/CSL/00106', 'FCET/CSL/FCE101287', '2026-03-01', 'ALI GONI', NULL, NULL, 'TI315801', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101287', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ALI GONI', 'active', 1, '2026-10-03 15:07:26', 'legacy_import', 2, '2026-10-03 15:07:26', 2, '2026-10-03 15:07:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:26', '2026-10-03 15:07:26', NULL),
(107, 115, 'FCET/CSL/00107', 'FCET/CSL/FCE101404', '2026-03-01', 'SULE SHAIBU ALHAJI', NULL, NULL, 'TI339314', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101404', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'SULE SHAIBU ALHAJI', 'active', 1, '2026-10-03 15:07:27', 'legacy_import', 2, '2026-10-03 15:07:27', 2, '2026-10-03 15:07:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:07:27', '2026-10-03 15:07:27', NULL),
(108, 116, 'FCET/CSL/00108', 'FCET/CSL/FCE100200', '2026-04-01', 'GERO SALE MOHAMMED', NULL, NULL, 'TI53688', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100200', NULL, 'permanent', NULL, NULL, 30000.00, 30000.00, 'salary_deduction', 'regular_staff', 1, 'GERO SALE MOHAMMED', 'active', 1, '2026-10-03 15:09:28', 'legacy_import', 2, '2026-10-03 15:09:28', 2, '2026-10-03 15:09:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28', NULL),
(109, 117, 'FCET/CSL/00109', 'FCET/CSL/FCE100705', '2026-04-01', 'WAKILI HADIZA MOHAMMED', NULL, NULL, 'TI53815', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100705', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'WAKILI HADIZA MOHAMMED', 'active', 1, '2026-10-03 15:09:28', 'legacy_import', 2, '2026-10-03 15:09:28', 2, '2026-10-03 15:09:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28', NULL),
(110, 118, 'FCET/CSL/00110', 'FCET/CSL/FCE101069', '2026-04-01', 'USMAN DANLAMI BILTE', NULL, NULL, 'TI54036', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101069', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'USMAN DANLAMI BILTE', 'active', 1, '2026-10-03 15:09:29', 'legacy_import', 2, '2026-10-03 15:09:29', 2, '2026-10-03 15:09:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:29', '2026-10-03 15:09:29', NULL),
(111, 119, 'FCET/CSL/00111', 'FCET/CSL/FCE1001031', '2026-04-01', 'YAU YUSUF', NULL, NULL, 'TI54019', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE1001031', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YAU YUSUF', 'active', 1, '2026-10-03 15:09:30', 'legacy_import', 2, '2026-10-03 15:09:30', 2, '2026-10-03 15:09:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30', NULL),
(112, 120, 'FCET/CSL/00112', 'FCET/CSL/FCE101082', '2026-04-01', 'IBRAHIM ABBA ZAKAR', NULL, NULL, 'TI54044', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101082', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'IBRAHIM ABBA ZAKAR', 'active', 1, '2026-10-03 15:09:30', 'legacy_import', 2, '2026-10-03 15:09:30', 2, '2026-10-03 15:09:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30', NULL),
(113, 121, 'FCET/CSL/00113', 'FCET/CSL/FCE101240', '2026-04-01', 'YINUSA ABDULRAFIU YINKA', NULL, NULL, 'TI315663', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101240', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'YINUSA ABDULRAFIU YINKA', 'active', 1, '2026-10-03 15:09:31', 'legacy_import', 2, '2026-10-03 15:09:31', 2, '2026-10-03 15:09:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:31', '2026-10-03 15:09:31', NULL),
(114, 122, 'FCET/CSL/00114', 'FCET/CSL/FCE101180', '2026-04-01', 'ABBA MAHMOUD BARAU', NULL, NULL, 'TI315686', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101180', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABBA MAHMOUD BARAU', 'active', 1, '2026-10-03 15:09:32', 'legacy_import', 2, '2026-10-03 15:09:32', 2, '2026-10-03 15:09:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32', NULL),
(115, 123, 'FCET/CSL/00115', 'FCET/CSL/FCE101264', '2026-04-01', 'IDRISS BOMOI MOHAMMED', NULL, NULL, 'TI315667', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101264', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'IDRISS BOMOI MOHAMMED', 'active', 1, '2026-10-03 15:09:32', 'legacy_import', 2, '2026-10-03 15:09:32', 2, '2026-10-03 15:09:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32', NULL),
(116, 124, 'FCET/CSL/00116', 'FCET/CSL/FCE101119', '2026-04-01', 'SAMAILA HADIZA', NULL, NULL, 'TI315620', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101119', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'SAMAILA HADIZA', 'active', 1, '2026-10-03 15:09:33', 'legacy_import', 2, '2026-10-03 15:09:33', 2, '2026-10-03 15:09:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:09:33', '2026-10-03 15:09:33', NULL),
(117, 125, 'FCET/CSL/00117', 'FCET/CSL/FCE100184', '2026-05-01', 'MAIGORO MUSA MUHAMMAD', NULL, NULL, 'TI53677', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100184', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'MAIGORO MUSA MUHAMMAD', 'active', 1, '2026-10-03 15:11:43', 'legacy_import', 2, '2026-10-03 15:11:43', 2, '2026-10-03 15:11:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43', NULL),
(118, 126, 'FCET/CSL/00118', 'FCET/CSL/FCE100981', '2026-05-01', 'BOGO ZAINAB AUDU', NULL, NULL, 'TI53983', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100981', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'BOGO ZAINAB AUDU', 'active', 1, '2026-10-03 15:11:43', 'legacy_import', 2, '2026-10-03 15:11:43', 2, '2026-10-03 15:11:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43', NULL),
(119, 127, 'FCET/CSL/00119', 'FCET/CSL/FCE100928', '2026-05-01', 'KYARI SHETTIMA ABBA', NULL, NULL, 'TI53948', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100928', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'KYARI SHETTIMA ABBA', 'active', 1, '2026-10-03 15:11:44', 'legacy_import', 2, '2026-10-03 15:11:44', 2, '2026-10-03 15:11:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:11:44', '2026-10-03 15:11:44', NULL),
(120, 128, 'FCET/CSL/00120', 'FCET/CSL/FCE100692', '2026-05-01', 'GALADIMA SAIDU BABA', NULL, NULL, 'TI53797', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100692', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'GALADIMA SAIDU BABA', 'active', 1, '2026-10-03 15:11:45', 'legacy_import', 2, '2026-10-03 15:11:45', 2, '2026-10-03 15:11:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45', NULL),
(121, 129, 'FCET/CSL/00121', 'FCET/CSL/FCE101138', '2026-05-01', 'ABDULLAHI USMAN', NULL, NULL, 'TI315788', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101138', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'ABDULLAHI USMAN', 'active', 1, '2026-10-03 15:11:45', 'legacy_import', 2, '2026-10-03 15:11:45', 2, '2026-10-03 15:11:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45', NULL),
(122, 130, 'FCET/CSL/00122', 'FCET/CSL/FCE100625', '2026-08-01', 'NANGERE MOHAMMED GARBA', NULL, NULL, 'TI53768', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100625', NULL, 'permanent', NULL, NULL, 150000.00, 150000.00, 'salary_deduction', 'regular_staff', 1, 'NANGERE MOHAMMED GARBA', 'active', 1, '2026-10-03 15:15:57', 'legacy_import', 2, '2026-10-03 15:15:57', 2, '2026-10-03 15:15:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57', NULL),
(123, 131, 'FCET/CSL/00123', 'FCET/CSL/FCE200019', '2026-08-01', 'USAKU ELIZABETH', NULL, NULL, 'TI53763', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE200019', NULL, 'permanent', NULL, NULL, 20000.00, 20000.00, 'salary_deduction', 'regular_staff', 1, 'USAKU ELIZABETH', 'active', 1, '2026-10-03 15:15:57', 'legacy_import', 2, '2026-10-03 15:15:57', 2, '2026-10-03 15:15:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57', NULL),
(124, 132, 'FCET/CSL/00124', 'FCET/CSL/FCE101092', '2026-08-01', 'UMAR USMAN MUHAMMAD', NULL, NULL, 'TI54053', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE101092', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'UMAR USMAN MUHAMMAD', 'active', 1, '2026-10-03 15:15:58', 'legacy_import', 2, '2026-10-03 15:15:58', 2, '2026-10-03 15:15:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58', NULL),
(125, 133, 'FCET/CSL/00125', 'FCET/CSL/FCE100722', '2026-08-01', 'IBRAHIM MOHAMMED', NULL, NULL, 'TI53813', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100722', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'IBRAHIM MOHAMMED', 'active', 1, '2026-10-03 15:15:58', 'legacy_import', 2, '2026-10-03 15:15:58', 2, '2026-10-03 15:15:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58', NULL),
(126, 134, 'FCET/CSL/00126', 'FCET/CSL/FCE100624', '2026-08-01', 'HALLIRU IBRAHIM ALHAJI', NULL, NULL, 'TI53767', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100624', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'HALLIRU IBRAHIM ALHAJI', 'active', 1, '2026-10-03 15:15:59', 'legacy_import', 2, '2026-10-03 15:15:59', 2, '2026-10-03 15:15:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:15:59', '2026-10-03 15:15:59', NULL),
(127, 135, 'FCET/CSL/00127', 'FCET/CSL/FCE100292', '2026-09-01', 'YAU HARIRA', NULL, NULL, 'TI53705', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100292', NULL, 'permanent', NULL, NULL, 10000.00, 10000.00, 'salary_deduction', 'regular_staff', 1, 'YAU HARIRA', 'active', 1, '2026-10-03 15:19:35', 'legacy_import', 2, '2026-10-03 15:19:35', 2, '2026-10-03 15:19:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35', NULL),
(128, 136, 'FCET/CSL/00128', 'FCET/CSL/FCE100964', '2026-09-01', 'MOHAMMED UMARU', NULL, NULL, 'TI53969', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FCE100964', NULL, 'permanent', NULL, NULL, 5000.00, 5000.00, 'salary_deduction', 'regular_staff', 1, 'MOHAMMED UMARU', 'active', 1, '2026-10-03 15:19:35', 'legacy_import', 2, '2026-10-03 15:19:35', 2, '2026-10-03 15:19:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_change_requests`
--

CREATE TABLE `member_change_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `review_reason` text DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_events`
--

CREATE TABLE `member_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `caused_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_events`
--

INSERT INTO `member_events` (`id`, `member_id`, `event_type`, `payload`, `caused_by`, `created_at`) VALUES
(1, 1, 'member_imported', '{\"staff_id\":\"FCE100192\"}', 2, '2026-10-03 12:32:08'),
(2, 2, 'member_imported', '{\"staff_id\":\"FCE100631\"}', 2, '2026-10-03 12:32:09'),
(3, 3, 'member_imported', '{\"staff_id\":\"FCE100713\"}', 2, '2026-10-03 12:32:09'),
(4, 4, 'member_imported', '{\"staff_id\":\"FCE100778\"}', 2, '2026-10-03 12:32:10'),
(5, 5, 'member_imported', '{\"staff_id\":\"FCE100887\"}', 2, '2026-10-03 12:32:10'),
(6, 6, 'member_imported', '{\"staff_id\":\"FCE100182\"}', 2, '2026-10-03 12:32:11'),
(7, 7, 'member_imported', '{\"staff_id\":\"FCE100733\"}', 2, '2026-10-03 12:32:12'),
(8, 8, 'member_imported', '{\"staff_id\":\"FCE100726\"}', 2, '2026-10-03 12:32:12'),
(9, 9, 'member_imported', '{\"staff_id\":\"FCE100832\"}', 2, '2026-10-03 12:32:13'),
(10, 10, 'member_imported', '{\"staff_id\":\"FCE100843\"}', 2, '2026-10-03 12:32:13'),
(11, 11, 'member_imported', '{\"staff_id\":\"FCE100861\"}', 2, '2026-10-03 12:32:14'),
(12, 12, 'member_imported', '{\"staff_id\":\"FCE100782\"}', 2, '2026-10-03 12:32:15'),
(13, 13, 'member_imported', '{\"staff_id\":\"FCE100851\"}', 2, '2026-10-03 12:32:15'),
(14, 14, 'member_imported', '{\"staff_id\":\"FCE100215\"}', 2, '2026-10-03 12:32:16'),
(15, 15, 'member_imported', '{\"staff_id\":\"FCE100913\"}', 2, '2026-10-03 12:32:16'),
(16, 16, 'member_imported', '{\"staff_id\":\"FCE101060\"}', 2, '2026-10-03 12:32:17'),
(17, 17, 'member_imported', '{\"staff_id\":\"FCE200056\"}', 2, '2026-10-03 12:32:18'),
(18, 18, 'member_imported', '{\"staff_id\":\"FCE100737\"}', 2, '2026-10-03 12:32:18'),
(19, 19, 'member_imported', '{\"staff_id\":\"FCE100731\"}', 2, '2026-10-03 12:32:19'),
(20, 20, 'member_imported', '{\"staff_id\":\"FCE101191\"}', 2, '2026-10-03 12:32:19'),
(21, 21, 'member_imported', '{\"staff_id\":\"FCE1001017\"}', 2, '2026-10-03 12:32:20'),
(22, 22, 'member_imported', '{\"staff_id\":\"FCE101020\"}', 2, '2026-10-03 12:32:20'),
(23, 23, 'member_imported', '{\"staff_id\":\"FCE101085\"}', 2, '2026-10-03 12:32:21'),
(24, 24, 'member_imported', '{\"staff_id\":\"FCE100380\"}', 2, '2026-10-03 12:32:21'),
(25, 25, 'member_imported', '{\"staff_id\":\"FCE200042\"}', 2, '2026-10-03 12:32:22'),
(26, 26, 'member_imported', '{\"staff_id\":\"FCE100736\"}', 2, '2026-10-03 12:32:22'),
(27, 27, 'member_imported', '{\"staff_id\":\"FCE100514\"}', 2, '2026-10-03 12:32:23'),
(28, 28, 'member_imported', '{\"staff_id\":\"FCE101139\"}', 2, '2026-10-03 12:32:24'),
(29, 29, 'member_imported', '{\"staff_id\":\"FCE100709\"}', 2, '2026-10-03 12:32:24'),
(30, 30, 'member_imported', '{\"staff_id\":\"FCE101232\"}', 2, '2026-10-03 12:32:25'),
(31, 31, 'member_imported', '{\"staff_id\":\"FCE101235\"}', 2, '2026-10-03 12:32:25'),
(32, 32, 'member_imported', '{\"staff_id\":\"FCE101244\"}', 2, '2026-10-03 12:32:26'),
(33, 33, 'member_imported', '{\"staff_id\":\"FCE101228\"}', 2, '2026-10-03 12:32:26'),
(34, 34, 'member_imported', '{\"staff_id\":\"FCE101387\"}', 2, '2026-10-03 12:32:27'),
(35, 35, 'member_imported', '{\"staff_id\":\"FCE200065\"}', 2, '2026-10-03 12:32:28'),
(36, 36, 'member_imported', '{\"staff_id\":\"FCE200067\"}', 2, '2026-10-03 12:32:28'),
(37, 37, 'member_imported', '{\"staff_id\":\"FCE101041\"}', 2, '2026-10-03 12:32:29'),
(38, 38, 'member_imported', '{\"staff_id\":\"FCE1001043\"}', 2, '2026-10-03 12:32:29'),
(39, 39, 'member_imported', '{\"staff_id\":\"FCE100720\"}', 2, '2026-10-03 12:32:30'),
(40, 40, 'member_imported', '{\"staff_id\":\"FCE1001024\"}', 2, '2026-10-03 12:32:30'),
(41, 41, 'member_imported', '{\"staff_id\":\"FCE101061\"}', 2, '2026-10-03 12:32:31'),
(42, 42, 'member_imported', '{\"staff_id\":\"FCE101208\"}', 2, '2026-10-03 12:32:32'),
(43, 2, 'profile_completed', '{\"fields\":[\"phone_1\",\"email\",\"gender\",\"date_of_birth\",\"marital_status\",\"home_address\",\"nok_name\",\"nok_relationship\",\"nok_phone\"]}', 10, '2026-10-03 12:34:33'),
(44, 43, 'member_imported', '{\"staff_id\":\"FCE100205\"}', 2, '2026-10-03 15:24:47'),
(45, 44, 'member_imported', '{\"staff_id\":\"FCE101215\"}', 2, '2026-10-03 15:24:47'),
(46, 45, 'member_imported', '{\"staff_id\":\"FCE101268\"}', 2, '2026-10-03 15:24:47'),
(47, 46, 'member_imported', '{\"staff_id\":\"FCE100141\"}', 2, '2026-10-03 15:28:23'),
(48, 47, 'member_imported', '{\"staff_id\":\"FCE100080\"}', 2, '2026-10-03 15:28:23'),
(49, 48, 'member_imported', '{\"staff_id\":\"FCE100870\"}', 2, '2026-10-03 15:28:24'),
(50, 49, 'member_imported', '{\"staff_id\":\"FCE100337\"}', 2, '2026-10-03 15:28:24'),
(51, 50, 'member_imported', '{\"staff_id\":\"FCE100732\"}', 2, '2026-10-03 15:28:25'),
(52, 51, 'member_imported', '{\"staff_id\":\"FCE101076\"}', 2, '2026-10-03 15:28:26'),
(53, 52, 'member_imported', '{\"staff_id\":\"FCE200002\"}', 2, '2026-10-03 15:28:26'),
(54, 53, 'member_imported', '{\"staff_id\":\"FCE100696\"}', 2, '2026-10-03 15:28:27'),
(55, 54, 'member_imported', '{\"staff_id\":\"FCE101380\"}', 2, '2026-10-03 15:28:27'),
(56, 55, 'member_imported', '{\"staff_id\":\"FCE101140\"}', 2, '2026-10-03 15:28:28'),
(57, 56, 'member_imported', '{\"staff_id\":\"FCE101231\"}', 2, '2026-10-03 15:28:29'),
(58, 57, 'member_imported', '{\"staff_id\":\"FCE200057\"}', 2, '2026-10-03 15:28:29'),
(59, 58, 'member_imported', '{\"staff_id\":\"FCE101423\"}', 2, '2026-10-03 15:28:30'),
(60, 59, 'member_imported', '{\"staff_id\":\"FCE100848\"}', 2, '2026-10-03 15:30:58'),
(61, 60, 'member_imported', '{\"staff_id\":\"FCE100674\"}', 2, '2026-10-03 15:30:59'),
(62, 61, 'member_imported', '{\"staff_id\":\"FCE100911\"}', 2, '2026-10-03 15:30:59'),
(63, 62, 'member_imported', '{\"staff_id\":\"FCE200008\"}', 2, '2026-10-03 15:31:00'),
(64, 63, 'member_imported', '{\"staff_id\":\"FCE100789\"}', 2, '2026-10-03 15:31:00'),
(65, 64, 'member_imported', '{\"staff_id\":\"FCE101057\"}', 2, '2026-10-03 15:31:01'),
(66, 65, 'member_imported', '{\"staff_id\":\"FCE100366\"}', 2, '2026-10-03 15:31:01'),
(67, 66, 'member_imported', '{\"staff_id\":\"FCE100702\"}', 2, '2026-10-03 15:31:02'),
(68, 67, 'member_imported', '{\"staff_id\":\"FCE100939\"}', 2, '2026-10-03 15:42:58'),
(69, 68, 'member_imported', '{\"staff_id\":\"FCE101259\"}', 2, '2026-10-03 15:42:59'),
(70, 69, 'member_imported', '{\"staff_id\":\"FCE101378\"}', 2, '2026-10-03 16:04:20'),
(71, 70, 'member_imported', '{\"staff_id\":\"FCE100139\"}', 2, '2026-10-03 16:04:21'),
(72, 71, 'member_imported', '{\"staff_id\":\"FCE100122\"}', 2, '2026-10-03 16:04:21'),
(73, 72, 'member_imported', '{\"staff_id\":\"FCE100818\"}', 2, '2026-10-03 16:04:21'),
(74, 73, 'member_imported', '{\"staff_id\":\"FCE100816\"}', 2, '2026-10-03 16:04:22'),
(75, 74, 'member_imported', '{\"staff_id\":\"FCE100857\"}', 2, '2026-10-03 16:04:22'),
(76, 75, 'member_imported', '{\"staff_id\":\"FCE100900\"}', 2, '2026-10-03 16:04:23'),
(77, 76, 'member_imported', '{\"staff_id\":\"FCE100185\"}', 2, '2026-10-03 16:04:23'),
(78, 77, 'member_imported', '{\"staff_id\":\"FCE100547\"}', 2, '2026-10-03 16:04:24'),
(79, 78, 'member_imported', '{\"staff_id\":\"FCE100905\"}', 2, '2026-10-03 16:04:24'),
(80, 79, 'member_imported', '{\"staff_id\":\"FCE1001029\"}', 2, '2026-10-03 16:04:25'),
(81, 80, 'member_imported', '{\"staff_id\":\"FCE100979\"}', 2, '2026-10-03 16:04:25'),
(82, 81, 'member_imported', '{\"staff_id\":\"FCE100858\"}', 2, '2026-10-03 16:04:26'),
(83, 82, 'member_imported', '{\"staff_id\":\"FCE100932\"}', 2, '2026-10-03 16:04:27'),
(84, 83, 'member_imported', '{\"staff_id\":\"FCE100916\"}', 2, '2026-10-03 16:04:27'),
(85, 84, 'member_imported', '{\"staff_id\":\"FCE100791\"}', 2, '2026-10-03 16:04:28'),
(86, 85, 'member_imported', '{\"staff_id\":\"FCE200059\"}', 2, '2026-10-03 16:04:28'),
(87, 86, 'member_imported', '{\"staff_id\":\"FCE101173\"}', 2, '2026-10-03 16:04:29'),
(88, 87, 'member_imported', '{\"staff_id\":\"FCE101345\"}', 2, '2026-10-03 16:04:30'),
(89, 88, 'member_imported', '{\"staff_id\":\"FCE101237\"}', 2, '2026-10-03 16:04:30'),
(90, 89, 'member_imported', '{\"staff_id\":\"FCE100712\"}', 2, '2026-10-03 16:04:31'),
(91, 90, 'member_imported', '{\"staff_id\":\"FCE101362\"}', 2, '2026-10-03 16:04:31'),
(92, 91, 'member_imported', '{\"staff_id\":\"FCE101147\"}', 2, '2026-10-03 16:04:32'),
(93, 92, 'member_imported', '{\"staff_id\":\"FCE1001037\"}', 2, '2026-10-03 16:04:33'),
(94, 93, 'member_imported', '{\"staff_id\":\"FCE101084\"}', 2, '2026-10-03 16:04:33'),
(95, 94, 'member_imported', '{\"staff_id\":\"FCE100960\"}', 2, '2026-10-03 16:04:34'),
(96, 95, 'member_imported', '{\"staff_id\":\"FCE100053\"}', 2, '2026-10-03 16:07:19'),
(97, 96, 'member_imported', '{\"staff_id\":\"FCE100774\"}', 2, '2026-10-03 16:07:20'),
(98, 97, 'member_imported', '{\"staff_id\":\"FCE100941\"}', 2, '2026-10-03 16:07:20'),
(99, 98, 'member_imported', '{\"staff_id\":\"FCE100121\"}', 2, '2026-10-03 16:07:21'),
(100, 99, 'member_imported', '{\"staff_id\":\"FCE100717\"}', 2, '2026-10-03 16:07:22'),
(101, 100, 'member_imported', '{\"staff_id\":\"FCE101152\"}', 2, '2026-10-03 16:07:22'),
(102, 101, 'member_imported', '{\"staff_id\":\"FCE101227\"}', 2, '2026-10-03 16:07:23'),
(103, 102, 'member_imported', '{\"staff_id\":\"FCE101132\"}', 2, '2026-10-03 16:07:24'),
(104, 103, 'member_imported', '{\"staff_id\":\"FCE101281\"}', 2, '2026-10-03 16:07:24'),
(105, 104, 'member_imported', '{\"staff_id\":\"FCE101327\"}', 2, '2026-10-03 16:07:25'),
(106, 105, 'member_imported', '{\"staff_id\":\"FCE101275\"}', 2, '2026-10-03 16:07:25'),
(107, 106, 'member_imported', '{\"staff_id\":\"FCE101287\"}', 2, '2026-10-03 16:07:26'),
(108, 107, 'member_imported', '{\"staff_id\":\"FCE101404\"}', 2, '2026-10-03 16:07:27'),
(109, 108, 'member_imported', '{\"staff_id\":\"FCE100200\"}', 2, '2026-10-03 16:09:28'),
(110, 109, 'member_imported', '{\"staff_id\":\"FCE100705\"}', 2, '2026-10-03 16:09:28'),
(111, 110, 'member_imported', '{\"staff_id\":\"FCE101069\"}', 2, '2026-10-03 16:09:29'),
(112, 111, 'member_imported', '{\"staff_id\":\"FCE1001031\"}', 2, '2026-10-03 16:09:30'),
(113, 112, 'member_imported', '{\"staff_id\":\"FCE101082\"}', 2, '2026-10-03 16:09:30'),
(114, 113, 'member_imported', '{\"staff_id\":\"FCE101240\"}', 2, '2026-10-03 16:09:31'),
(115, 114, 'member_imported', '{\"staff_id\":\"FCE101180\"}', 2, '2026-10-03 16:09:32'),
(116, 115, 'member_imported', '{\"staff_id\":\"FCE101264\"}', 2, '2026-10-03 16:09:32'),
(117, 116, 'member_imported', '{\"staff_id\":\"FCE101119\"}', 2, '2026-10-03 16:09:33'),
(118, 117, 'member_imported', '{\"staff_id\":\"FCE100184\"}', 2, '2026-10-03 16:11:43'),
(119, 118, 'member_imported', '{\"staff_id\":\"FCE100981\"}', 2, '2026-10-03 16:11:43'),
(120, 119, 'member_imported', '{\"staff_id\":\"FCE100928\"}', 2, '2026-10-03 16:11:44'),
(121, 120, 'member_imported', '{\"staff_id\":\"FCE100692\"}', 2, '2026-10-03 16:11:45'),
(122, 121, 'member_imported', '{\"staff_id\":\"FCE101138\"}', 2, '2026-10-03 16:11:45'),
(123, 122, 'member_imported', '{\"staff_id\":\"FCE100625\"}', 2, '2026-10-03 16:15:57'),
(124, 123, 'member_imported', '{\"staff_id\":\"FCE200019\"}', 2, '2026-10-03 16:15:57'),
(125, 124, 'member_imported', '{\"staff_id\":\"FCE101092\"}', 2, '2026-10-03 16:15:58'),
(126, 125, 'member_imported', '{\"staff_id\":\"FCE100722\"}', 2, '2026-10-03 16:15:58'),
(127, 126, 'member_imported', '{\"staff_id\":\"FCE100624\"}', 2, '2026-10-03 16:15:59'),
(128, 127, 'member_imported', '{\"staff_id\":\"FCE100292\"}', 2, '2026-10-03 16:19:35'),
(129, 128, 'member_imported', '{\"staff_id\":\"FCE100964\"}', 2, '2026-10-03 16:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `member_import_batches`
--

CREATE TABLE `member_import_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_records` int(10) UNSIGNED DEFAULT NULL,
  `imported_count` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('uploaded','validated','imported','failed') NOT NULL DEFAULT 'uploaded',
  `rows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rows`)),
  `imported_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_import_batches`
--

INSERT INTO `member_import_batches` (`id`, `uploaded_by`, `file_path`, `total_records`, `imported_count`, `status`, `rows`, `imported_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'member-imports/AmYXKh1Psh8WkRYvGqQyv968Ad9Uhsilb5fZ1RVs.csv', 42, 42, 'imported', '[{\"staff_id\":\"FCE100192\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MAMUDA ABDULLAHI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53681\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":1},{\"staff_id\":\"FCE100631\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ADAM UMAR ABBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53771\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"40000\",\"approved_monthly_contribution\":\"40000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":2},{\"staff_id\":\"FCE100713\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MOHAMMED MOHAMMED ARDO\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53808\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"50000\",\"approved_monthly_contribution\":\"50000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":3},{\"staff_id\":\"FCE100778\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"JIBRIN HASHIMU GUNDA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53844\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":4},{\"staff_id\":\"FCE100887\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"DALA ADAMU GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53917\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":5},{\"staff_id\":\"FCE100182\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ABUBAKAR SAIDU ALHASSAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53676\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":6},{\"staff_id\":\"FCE100733\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ILIYASU MUSA YUSUF\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53820\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"50000\",\"approved_monthly_contribution\":\"50000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":7},{\"staff_id\":\"FCE100726\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MUNTARI SAAD\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53816\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":8},{\"staff_id\":\"FCE100832\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"WAKILI BALA ADAMU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53878\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":9},{\"staff_id\":\"FCE100843\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"BABA AJIYA IDRISSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53886\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":10},{\"staff_id\":\"FCE100861\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"GHULUZE MUHAMMAD IBN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53899\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":11},{\"staff_id\":\"FCE100782\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"LUCCU AJIYA MAINA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53847\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":12},{\"staff_id\":\"FCE100851\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"GIMBA ISMAILA MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53891\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":13},{\"staff_id\":\"FCE100215\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"BAWAJI HAUWA ABDU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53694\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":14},{\"staff_id\":\"FCE100913\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MIDALA ZAKARIYAU HARUNA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53938\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":15},{\"staff_id\":\"FCE101060\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"HAMZA SULEIMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54031\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":16},{\"staff_id\":\"FCE200056\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MANGA MUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53993\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":17},{\"staff_id\":\"FCE100737\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"SHAMAKI AYUBA YAKUBU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53817\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"15000\",\"approved_monthly_contribution\":\"15000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":18},{\"staff_id\":\"FCE100731\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"BARDE IDRISS IBRAHIM\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53818\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":19},{\"staff_id\":\"FCE101191\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ABDULKADIR ABDULKARIM OLATUNJI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315548\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":20},{\"staff_id\":\"FCE1001017\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"YERIMA MUSA MAMMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54007\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":21},{\"staff_id\":\"FCE101020\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"BADAWI MUHAMMAD HASSAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54008\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":22},{\"staff_id\":\"FCE101085\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MUSA ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54046\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":23},{\"staff_id\":\"FCE100380\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"BAH UMAR M\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53728\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":24},{\"staff_id\":\"FCE200042\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MUSA SAADATU MIRINGA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53824\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":25},{\"staff_id\":\"FCE100736\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"GEIDAM HADIZA BABA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53811\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":26},{\"staff_id\":\"FCE100514\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"NWARE HARUNA IDRIS\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53740\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":27},{\"staff_id\":\"FCE101139\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"YAMARKUMI AHMAD MUHAMMAD\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315772\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":28},{\"staff_id\":\"FCE100709\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"USMAN IBRAHIM GOJI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53814\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":29},{\"staff_id\":\"FCE101232\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"HUSSAINI ISHIYAKU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315789\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":30},{\"staff_id\":\"FCE101235\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"HARUNA ALIYU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315566\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":31},{\"staff_id\":\"FCE101244\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ABUBAKAR MOHAMMED BOJUDE\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315734\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":32},{\"staff_id\":\"FCE101228\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"RABIU YAHUZA GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315653\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"7000\",\"approved_monthly_contribution\":\"7000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":33},{\"staff_id\":\"FCE101387\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MUHAMMAD BINTA MUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI339304\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":34},{\"staff_id\":\"FCE200065\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"CHIBOK HAUWA WAKIL\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54023\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":35},{\"staff_id\":\"FCE200067\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"SULEIMAN ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54024\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":36},{\"staff_id\":\"FCE101041\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MOHAMMED SALEH\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54020\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":37},{\"staff_id\":\"FCE1001043\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"ADAMU UMAR KWAMI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26168\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":38},{\"staff_id\":\"FCE100720\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"SHETTIMA ALHAJI SHEHU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26142\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":39},{\"staff_id\":\"FCE1001024\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"SAFIYANU GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54013\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":40},{\"staff_id\":\"FCE101061\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"TONTI ALIYU MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26173\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":41},{\"staff_id\":\"FCE101208\",\"membership_no\":null,\"membership_date\":\"2025-06-01\",\"full_name\":\"MOHAMMED AHMED GIDADO\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315662\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"0\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":42}]', '2026-10-03 11:32:32', '2026-10-03 11:31:38', '2026-10-03 11:32:32'),
(2, 2, 'member-imports/K3ZklzxgFP66ArlpeMfxxJcEXfF6191IZXp1POMf.csv', 3, 3, 'imported', '[{\"staff_id\":\"FCE100205\",\"membership_no\":null,\"membership_date\":\"2025-07-01\",\"full_name\":\"MOHAMMED ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53691\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":43},{\"staff_id\":\"FCE101215\",\"membership_no\":null,\"membership_date\":\"2025-07-01\",\"full_name\":\"BASHIR HASHIMU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315769\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":44},{\"staff_id\":\"FCE101268\",\"membership_no\":null,\"membership_date\":\"2025-07-01\",\"full_name\":\"MOHAMMED IBRAHIM\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315661\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":45}]', '2026-10-03 14:24:47', '2026-10-03 14:02:05', '2026-10-03 14:24:47'),
(3, 2, 'member-imports/NOdKM0k8EtkeeXfjxnmK7Y8Bje2SQVTtPGfOVKUG.csv', 13, 13, 'imported', '[{\"staff_id\":\"FCE100141\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"DR YUNUSA MOHAMMED MADU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53653\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"30000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":46},{\"staff_id\":\"FCE100080\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"MUHAMMAD HASSAN NDAMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53630\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":47},{\"staff_id\":\"FCE100870\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"YAU IBRAHIM\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53905\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":48},{\"staff_id\":\"FCE100337\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"FAROUK MARYAM UMAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53717\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":49},{\"staff_id\":\"FCE100732\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"BARDE FATIMA ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53819\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":50},{\"staff_id\":\"FCE101076\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"ILUOBE MARY MODUPE\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54039\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"30000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":51},{\"staff_id\":\"FCE200002\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"ABDULLAHI AISHA ALKALI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53754\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":52},{\"staff_id\":\"FCE100696\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"ALI MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53800\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":53},{\"staff_id\":\"FCE101380\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"SHUAIBU ZAKAR YA\'U\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315803\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":54},{\"staff_id\":\"FCE101140\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"ABDULKADIR SAIDU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315717\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":55},{\"staff_id\":\"FCE101231\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"MUSTAPHA AISHATU FIKA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315778\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":56},{\"staff_id\":\"FCE200057\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"LAWAN YAKUBU SAIDU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53998\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":57},{\"staff_id\":\"FCE101423\",\"membership_no\":null,\"membership_date\":\"2025-08-01\",\"full_name\":\"MUHAMMAD YUSUF MUHAMMAD\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI339340\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":58}]', '2026-10-03 14:28:30', '2026-10-03 14:28:13', '2026-10-03 14:28:30'),
(4, 2, 'member-imports/CwoAzUrS6P5RsiGCNN3grtLhi7m0fzQPUgFQDWnO.csv', 8, 8, 'imported', '[{\"staff_id\":\"FCE100848\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"HASSAN MUHAMMAD ABBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53889\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":59},{\"staff_id\":\"FCE100674\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"USMAN NANA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53784\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":60},{\"staff_id\":\"FCE100911\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"DAUDA YAHAYA ALHAJI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53937\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":61},{\"staff_id\":\"FCE200008\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"GARBA ASABE YUSUF\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53759\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":62},{\"staff_id\":\"FCE100789\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"BADEJO HARUNA ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53852\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":63},{\"staff_id\":\"FCE101057\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"KALLAMU ISA IBRAHIM\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54030\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":64},{\"staff_id\":\"FCE100366\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"DISA ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53723\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":65},{\"staff_id\":\"FCE100702\",\"membership_no\":null,\"membership_date\":\"2025-09-01\",\"full_name\":\"YUSUF HAMZA MUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53810\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":66}]', '2026-10-03 14:31:02', '2026-10-03 14:30:51', '2026-10-03 14:31:02'),
(5, 2, 'member-imports/O0qCmkq9TZrTfkufC6KzWG8UNAdLl7OObOze38Nq.csv', 2, 2, 'imported', '[{\"staff_id\":\"FCE100939\",\"membership_no\":null,\"membership_date\":\"2025-11-01\",\"full_name\":\"ZARMA BABAYO BOMOI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53955\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"50000\",\"approved_monthly_contribution\":\"50000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"50000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":67},{\"staff_id\":\"FCE101259\",\"membership_no\":null,\"membership_date\":\"2025-11-01\",\"full_name\":\"MOHAMMED AUDU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315671\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":68}]', '2026-10-03 14:42:59', '2026-10-03 14:42:51', '2026-10-03 14:42:59');
INSERT INTO `member_import_batches` (`id`, `uploaded_by`, `file_path`, `total_records`, `imported_count`, `status`, `rows`, `imported_at`, `created_at`, `updated_at`) VALUES
(6, 2, 'member-imports/eZxZ6VLIpHw2JOhxVLNRsJoJinbU2gxL4dicgFoC.csv', 26, 26, 'imported', '[{\"staff_id\":\"FCE101378\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"BUNDI ALHAJI GAMBO\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI146876\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"50000\",\"approved_monthly_contribution\":\"50000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"50000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":69},{\"staff_id\":\"FCE100139\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"PINDAR YUSUF KWI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53652\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":70},{\"staff_id\":\"FCE100122\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ABDULLAHI YAHAYA POTISKUM\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53645\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"40000\",\"approved_monthly_contribution\":\"40000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"40000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":71},{\"staff_id\":\"FCE100818\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"BABA MOHAMMED RABIU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53873\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":72},{\"staff_id\":\"FCE100816\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"BAKOJI BALA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53872\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":73},{\"staff_id\":\"FCE100857\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"DAWASA IBRAHIM MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53896\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":74},{\"staff_id\":\"FCE100900\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"MUSAH AMINU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53928\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":75},{\"staff_id\":\"FCE100185\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"POKALAS TAIYATU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53678\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"100000\",\"approved_monthly_contribution\":\"100000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"100000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":76},{\"staff_id\":\"FCE100547\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"WAZIRI MOHAMMED ADAMU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53743\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":77},{\"staff_id\":\"FCE100905\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"MAMMAI YUSUF MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53931\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"60000\",\"approved_monthly_contribution\":\"60000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"60000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":78},{\"staff_id\":\"FCE1001029\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"AJIYA ABUBAKAR BABA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54017\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"50000\",\"approved_monthly_contribution\":\"50000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"50000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":79},{\"staff_id\":\"FCE100979\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ALHAJI BAABA NURI FIKA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53981\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":80},{\"staff_id\":\"FCE100858\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"MOHAMMED ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53897\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":81},{\"staff_id\":\"FCE100932\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"HASSAN MUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI5950\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":82},{\"staff_id\":\"FCE100916\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ABUBAKAR MUHAMMAD ABUBAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53940\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":83},{\"staff_id\":\"FCE100791\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"LAMPO ZAKAR SULE\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53853\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":84},{\"staff_id\":\"FCE200059\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"DANLADI SULEIMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54002\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"15000\",\"approved_monthly_contribution\":\"15000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"15000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":85},{\"staff_id\":\"FCE101173\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ISA ABDULLAHI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315569\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":86},{\"staff_id\":\"FCE101345\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"GARBA UMAR AHMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315729\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":87},{\"staff_id\":\"FCE101237\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ISA HASSAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315730\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":88},{\"staff_id\":\"FCE100712\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"MAMMAI MOHAMMED MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53803\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":89},{\"staff_id\":\"FCE101362\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"SALIHU IDRIS YUNUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315618\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":90},{\"staff_id\":\"FCE101147\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ALI ISAH\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315757\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":91},{\"staff_id\":\"FCE1001037\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ISAH AHMED MUSA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26164\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":92},{\"staff_id\":\"FCE101084\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"CHIWAR BUKAR MOHAMMED KABU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26179\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":93},{\"staff_id\":\"FCE100960\",\"membership_no\":null,\"membership_date\":\"2026-02-01\",\"full_name\":\"ALI HAMSATU MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI26154\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":94}]', '2026-10-03 15:04:34', '2026-10-03 15:04:03', '2026-10-03 15:04:34'),
(7, 2, 'member-imports/feuF28RCyckzJXYPavKrZvOzQIL1DFooUdEfscIa.csv', 13, 13, 'imported', '[{\"staff_id\":\"FCE100053\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"ALHAJI BASHIR BALA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53622\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"30000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":95},{\"staff_id\":\"FCE100774\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"TIJANI ABDULGAFAR OLAKUNLE\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53842\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":96},{\"staff_id\":\"FCE100941\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"TANKO GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53956\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"25000\",\"approved_monthly_contribution\":\"25000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"25000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":97},{\"staff_id\":\"FCE100121\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"HARUNA MUAWIYA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53644\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":98},{\"staff_id\":\"FCE100717\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"LAWANDI SULYMAN ISMAIL\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53809\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":99},{\"staff_id\":\"FCE101152\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"HARUNA YUSUF\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315561\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":100},{\"staff_id\":\"FCE101227\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"BAPPAH ALIYU WAZIRI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315638\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":101},{\"staff_id\":\"FCE101132\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"BUKAR SULEIMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315704\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":102},{\"staff_id\":\"FCE101281\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"AHMED ABDULMUMINI GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315779\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":103},{\"staff_id\":\"FCE101327\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"MUSA HASSAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315808\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":104},{\"staff_id\":\"FCE101275\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"HASSAN ALIYU ADAMU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315634\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":105},{\"staff_id\":\"FCE101287\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"ALI GONI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315801\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":106},{\"staff_id\":\"FCE101404\",\"membership_no\":null,\"membership_date\":\"2026-03-01\",\"full_name\":\"SULE SHAIBU ALHAJI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI339314\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":107}]', '2026-10-03 15:07:27', '2026-10-03 15:07:02', '2026-10-03 15:07:27'),
(8, 2, 'member-imports/P1t6znLeReCHdvcbj0kiAbBmlkWcH68ffPBDGOsB.csv', 9, 9, 'imported', '[{\"staff_id\":\"FCE100200\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"GERO SALE MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53688\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"30000\",\"approved_monthly_contribution\":\"30000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"30000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":108},{\"staff_id\":\"FCE100705\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"WAKILI HADIZA MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53815\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":109},{\"staff_id\":\"FCE101069\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"USMAN DANLAMI BILTE\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54036\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":110},{\"staff_id\":\"FCE1001031\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"YAU YUSUF\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54019\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":111},{\"staff_id\":\"FCE101082\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"IBRAHIM ABBA ZAKAR\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54044\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":112},{\"staff_id\":\"FCE101240\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"YINUSA ABDULRAFIU YINKA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315663\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":113},{\"staff_id\":\"FCE101180\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"ABBA MAHMOUD BARAU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315686\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":114},{\"staff_id\":\"FCE101264\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"IDRISS BOMOI MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315667\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":115},{\"staff_id\":\"FCE101119\",\"membership_no\":null,\"membership_date\":\"2026-04-01\",\"full_name\":\"SAMAILA HADIZA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315620\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":116}]', '2026-10-03 15:09:33', '2026-10-03 15:09:20', '2026-10-03 15:09:33'),
(9, 2, 'member-imports/FI4FyZAsSOKcgbzm5nEdbM2lTgHPf7ykdYDeDxXM.csv', 5, 5, 'imported', '[{\"staff_id\":\"FCE100184\",\"membership_no\":null,\"membership_date\":\"2026-05-01\",\"full_name\":\"MAIGORO MUSA MUHAMMAD\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53677\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":117},{\"staff_id\":\"FCE100981\",\"membership_no\":null,\"membership_date\":\"2026-05-01\",\"full_name\":\"BOGO ZAINAB AUDU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53983\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":118},{\"staff_id\":\"FCE100928\",\"membership_no\":null,\"membership_date\":\"2026-05-01\",\"full_name\":\"KYARI SHETTIMA ABBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53948\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":119},{\"staff_id\":\"FCE100692\",\"membership_no\":null,\"membership_date\":\"2026-05-01\",\"full_name\":\"GALADIMA SAIDU BABA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53797\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":120},{\"staff_id\":\"FCE101138\",\"membership_no\":null,\"membership_date\":\"2026-05-01\",\"full_name\":\"ABDULLAHI USMAN\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI315788\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":121}]', '2026-10-03 15:11:45', '2026-10-03 15:11:37', '2026-10-03 15:11:45'),
(10, 2, 'member-imports/576hQ6vvxR1wLm0yE8P5qKgU0zWPe0S6lyQkZsWC.csv', 5, 5, 'imported', '[{\"staff_id\":\"FCE100625\",\"membership_no\":null,\"membership_date\":\"2026-08-01\",\"full_name\":\"NANGERE MOHAMMED GARBA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53768\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"150000\",\"approved_monthly_contribution\":\"150000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"150000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":122},{\"staff_id\":\"FCE200019\",\"membership_no\":null,\"membership_date\":\"2026-08-01\",\"full_name\":\"USAKU ELIZABETH\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53763\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"20000\",\"approved_monthly_contribution\":\"20000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"20000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":123},{\"staff_id\":\"FCE101092\",\"membership_no\":null,\"membership_date\":\"2026-08-01\",\"full_name\":\"UMAR USMAN MUHAMMAD\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI54053\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":124},{\"staff_id\":\"FCE100722\",\"membership_no\":null,\"membership_date\":\"2026-08-01\",\"full_name\":\"IBRAHIM MOHAMMED\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53813\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":125},{\"staff_id\":\"FCE100624\",\"membership_no\":null,\"membership_date\":\"2026-08-01\",\"full_name\":\"HALLIRU IBRAHIM ALHAJI\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53767\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":126}]', '2026-10-03 15:15:59', '2026-10-03 15:15:49', '2026-10-03 15:15:59'),
(11, 2, 'member-imports/TUR4TK95UT1cfTgM5nBSSdhUuZcX3bWdpiErYN3q.csv', 2, 2, 'imported', '[{\"staff_id\":\"FCE100292\",\"membership_no\":null,\"membership_date\":\"2026-09-01\",\"full_name\":\"YAU HARIRA\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53705\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"10000\",\"approved_monthly_contribution\":\"10000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"10000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":127},{\"staff_id\":\"FCE100964\",\"membership_no\":null,\"membership_date\":\"2026-09-01\",\"full_name\":\"MOHAMMED UMARU\",\"date_of_birth\":null,\"gender\":null,\"marital_status\":null,\"home_address\":null,\"phone_1\":null,\"phone_2\":null,\"email\":null,\"ippis_number\":\"TI53969\",\"department\":null,\"date_of_first_appointment\":null,\"employment_status\":\"permanent\",\"rank_grade\":null,\"preferred_monthly_contribution\":\"5000\",\"approved_monthly_contribution\":\"5000\",\"mode_of_deduction\":\"salary_deduction\",\"current_savings_balance\":\"5000\",\"nok_name\":null,\"nok_relationship\":null,\"nok_phone\":null,\"nok_address\":null,\"matched\":true,\"error\":null,\"member_id\":128}]', '2026-10-03 15:19:35', '2026-10-03 15:19:28', '2026-10-03 15:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `member_status_history`
--

CREATE TABLE `member_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `from_status` varchar(255) DEFAULT NULL,
  `to_status` varchar(255) NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_status_history`
--

INSERT INTO `member_status_history` (`id`, `member_id`, `from_status`, `to_status`, `changed_by`, `reason`, `created_at`) VALUES
(1, 1, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:08'),
(2, 2, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:09'),
(3, 3, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:09'),
(4, 4, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:10'),
(5, 5, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:10'),
(6, 6, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:11'),
(7, 7, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:12'),
(8, 8, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:12'),
(9, 9, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:13'),
(10, 10, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:13'),
(11, 11, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:14'),
(12, 12, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:15'),
(13, 13, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:15'),
(14, 14, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:16'),
(15, 15, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:16'),
(16, 16, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:17'),
(17, 17, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:18'),
(18, 18, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:18'),
(19, 19, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:19'),
(20, 20, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:19'),
(21, 21, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:20'),
(22, 22, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:20'),
(23, 23, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:21'),
(24, 24, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:21'),
(25, 25, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:22'),
(26, 26, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:22'),
(27, 27, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:23'),
(28, 28, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:24'),
(29, 29, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:24'),
(30, 30, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:25'),
(31, 31, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:25'),
(32, 32, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:26'),
(33, 33, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:26'),
(34, 34, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:27'),
(35, 35, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:28'),
(36, 36, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:28'),
(37, 37, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:29'),
(38, 38, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:29'),
(39, 39, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:30'),
(40, 40, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:30'),
(41, 41, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:31'),
(42, 42, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 12:32:32'),
(43, 43, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:24:47'),
(44, 44, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:24:47'),
(45, 45, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:24:47'),
(46, 46, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:23'),
(47, 47, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:23'),
(48, 48, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:24'),
(49, 49, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:24'),
(50, 50, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:25'),
(51, 51, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:26'),
(52, 52, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:26'),
(53, 53, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:27'),
(54, 54, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:27'),
(55, 55, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:28'),
(56, 56, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:29'),
(57, 57, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:29'),
(58, 58, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:28:30'),
(59, 59, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:30:58'),
(60, 60, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:30:59'),
(61, 61, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:30:59'),
(62, 62, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:31:00'),
(63, 63, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:31:00'),
(64, 64, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:31:01'),
(65, 65, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:31:01'),
(66, 66, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:31:02'),
(67, 67, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:42:58'),
(68, 68, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 15:42:59'),
(69, 69, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:20'),
(70, 70, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:21'),
(71, 71, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:21'),
(72, 72, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:21'),
(73, 73, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:22'),
(74, 74, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:22'),
(75, 75, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:23'),
(76, 76, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:23'),
(77, 77, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:24'),
(78, 78, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:24'),
(79, 79, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:25'),
(80, 80, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:25'),
(81, 81, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:26'),
(82, 82, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:27'),
(83, 83, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:27'),
(84, 84, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:28'),
(85, 85, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:28'),
(86, 86, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:29'),
(87, 87, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:30'),
(88, 88, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:30'),
(89, 89, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:31'),
(90, 90, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:31'),
(91, 91, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:32'),
(92, 92, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:33'),
(93, 93, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:33'),
(94, 94, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:04:34'),
(95, 95, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:19'),
(96, 96, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:20'),
(97, 97, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:20'),
(98, 98, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:21'),
(99, 99, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:22'),
(100, 100, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:22'),
(101, 101, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:23'),
(102, 102, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:24'),
(103, 103, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:24'),
(104, 104, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:25'),
(105, 105, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:25'),
(106, 106, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:26'),
(107, 107, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:07:27'),
(108, 108, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:28'),
(109, 109, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:28'),
(110, 110, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:29'),
(111, 111, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:30'),
(112, 112, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:30'),
(113, 113, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:31'),
(114, 114, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:32'),
(115, 115, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:32'),
(116, 116, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:09:33'),
(117, 117, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:11:43'),
(118, 118, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:11:43'),
(119, 119, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:11:44'),
(120, 120, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:11:45'),
(121, 121, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:11:45'),
(122, 122, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:15:57'),
(123, 123, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:15:57'),
(124, 124, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:15:58'),
(125, 125, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:15:58'),
(126, 126, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:15:59'),
(127, 127, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:19:35'),
(128, 128, NULL, 'active', 2, 'Migrated from manual/paper records.', '2026-10-03 16:19:35');

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
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 26),
(2, 'App\\Models\\User', 27),
(2, 'App\\Models\\User', 28),
(2, 'App\\Models\\User', 29),
(2, 'App\\Models\\User', 30),
(2, 'App\\Models\\User', 31),
(2, 'App\\Models\\User', 32),
(2, 'App\\Models\\User', 33),
(2, 'App\\Models\\User', 34),
(2, 'App\\Models\\User', 35),
(2, 'App\\Models\\User', 36),
(2, 'App\\Models\\User', 37),
(2, 'App\\Models\\User', 38),
(2, 'App\\Models\\User', 39),
(2, 'App\\Models\\User', 40),
(2, 'App\\Models\\User', 41),
(2, 'App\\Models\\User', 42),
(2, 'App\\Models\\User', 43),
(2, 'App\\Models\\User', 44),
(2, 'App\\Models\\User', 45),
(2, 'App\\Models\\User', 46),
(2, 'App\\Models\\User', 47),
(2, 'App\\Models\\User', 48),
(2, 'App\\Models\\User', 49),
(2, 'App\\Models\\User', 50),
(2, 'App\\Models\\User', 51),
(2, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(2, 'App\\Models\\User', 54),
(2, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 56),
(2, 'App\\Models\\User', 57),
(2, 'App\\Models\\User', 58),
(2, 'App\\Models\\User', 59),
(2, 'App\\Models\\User', 60),
(2, 'App\\Models\\User', 61),
(2, 'App\\Models\\User', 62),
(2, 'App\\Models\\User', 63),
(2, 'App\\Models\\User', 64),
(2, 'App\\Models\\User', 65),
(2, 'App\\Models\\User', 66),
(2, 'App\\Models\\User', 67),
(2, 'App\\Models\\User', 68),
(2, 'App\\Models\\User', 69),
(2, 'App\\Models\\User', 70),
(2, 'App\\Models\\User', 71),
(2, 'App\\Models\\User', 72),
(2, 'App\\Models\\User', 73),
(2, 'App\\Models\\User', 74),
(2, 'App\\Models\\User', 75),
(2, 'App\\Models\\User', 76),
(2, 'App\\Models\\User', 77),
(2, 'App\\Models\\User', 78),
(2, 'App\\Models\\User', 79),
(2, 'App\\Models\\User', 80),
(2, 'App\\Models\\User', 81),
(2, 'App\\Models\\User', 82),
(2, 'App\\Models\\User', 83),
(2, 'App\\Models\\User', 84),
(2, 'App\\Models\\User', 85),
(2, 'App\\Models\\User', 86),
(2, 'App\\Models\\User', 87),
(2, 'App\\Models\\User', 88),
(2, 'App\\Models\\User', 89),
(2, 'App\\Models\\User', 90),
(2, 'App\\Models\\User', 91),
(2, 'App\\Models\\User', 92),
(2, 'App\\Models\\User', 93),
(2, 'App\\Models\\User', 94),
(2, 'App\\Models\\User', 95),
(2, 'App\\Models\\User', 96),
(2, 'App\\Models\\User', 97),
(2, 'App\\Models\\User', 98),
(2, 'App\\Models\\User', 99),
(2, 'App\\Models\\User', 100),
(2, 'App\\Models\\User', 101),
(2, 'App\\Models\\User', 102),
(2, 'App\\Models\\User', 103),
(2, 'App\\Models\\User', 104),
(2, 'App\\Models\\User', 105),
(2, 'App\\Models\\User', 106),
(2, 'App\\Models\\User', 107),
(2, 'App\\Models\\User', 108),
(2, 'App\\Models\\User', 109),
(2, 'App\\Models\\User', 110),
(2, 'App\\Models\\User', 111),
(2, 'App\\Models\\User', 112),
(2, 'App\\Models\\User', 113),
(2, 'App\\Models\\User', 114),
(2, 'App\\Models\\User', 115),
(2, 'App\\Models\\User', 116),
(2, 'App\\Models\\User', 117),
(2, 'App\\Models\\User', 118),
(2, 'App\\Models\\User', 119),
(2, 'App\\Models\\User', 120),
(2, 'App\\Models\\User', 121),
(2, 'App\\Models\\User', 122),
(2, 'App\\Models\\User', 123),
(2, 'App\\Models\\User', 124),
(2, 'App\\Models\\User', 125),
(2, 'App\\Models\\User', 126),
(2, 'App\\Models\\User', 127),
(2, 'App\\Models\\User', 128),
(2, 'App\\Models\\User', 129),
(2, 'App\\Models\\User', 130),
(2, 'App\\Models\\User', 131),
(2, 'App\\Models\\User', 132),
(2, 'App\\Models\\User', 133),
(2, 'App\\Models\\User', 134),
(2, 'App\\Models\\User', 135),
(2, 'App\\Models\\User', 136),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(5, 'App\\Models\\User', 4),
(6, 'App\\Models\\User', 7),
(7, 'App\\Models\\User', 8),
(8, 'App\\Models\\User', 6),
(9, 'App\\Models\\User', 5),
(10, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `next_of_kin`
--

CREATE TABLE `next_of_kin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `next_of_kin`
--

INSERT INTO `next_of_kin` (`id`, `member_id`, `name`, `relationship`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '2026-10-03 11:32:08', '2026-10-03 11:32:08'),
(2, 2, 'Bevis Atkins', 'Aliquid et mollitia ', '08055464166', NULL, '2026-10-03 11:32:09', '2026-10-03 11:34:33'),
(3, 3, NULL, NULL, NULL, NULL, '2026-10-03 11:32:09', '2026-10-03 11:32:09'),
(4, 4, NULL, NULL, NULL, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(5, 5, NULL, NULL, NULL, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(6, 6, NULL, NULL, NULL, NULL, '2026-10-03 11:32:11', '2026-10-03 11:32:11'),
(7, 7, NULL, NULL, NULL, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(8, 8, NULL, NULL, NULL, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(9, 9, NULL, NULL, NULL, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(10, 10, NULL, NULL, NULL, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(11, 11, NULL, NULL, NULL, NULL, '2026-10-03 11:32:14', '2026-10-03 11:32:14'),
(12, 12, NULL, NULL, NULL, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(13, 13, NULL, NULL, NULL, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(14, 14, NULL, NULL, NULL, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(15, 15, NULL, NULL, NULL, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(16, 16, NULL, NULL, NULL, NULL, '2026-10-03 11:32:17', '2026-10-03 11:32:17'),
(17, 17, NULL, NULL, NULL, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(18, 18, NULL, NULL, NULL, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(19, 19, NULL, NULL, NULL, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(20, 20, NULL, NULL, NULL, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(21, 21, NULL, NULL, NULL, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(22, 22, NULL, NULL, NULL, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(23, 23, NULL, NULL, NULL, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(24, 24, NULL, NULL, NULL, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(25, 25, NULL, NULL, NULL, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(26, 26, NULL, NULL, NULL, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(27, 27, NULL, NULL, NULL, NULL, '2026-10-03 11:32:23', '2026-10-03 11:32:23'),
(28, 28, NULL, NULL, NULL, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(29, 29, NULL, NULL, NULL, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(30, 30, NULL, NULL, NULL, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(31, 31, NULL, NULL, NULL, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(32, 32, NULL, NULL, NULL, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(33, 33, NULL, NULL, NULL, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(34, 34, NULL, NULL, NULL, NULL, '2026-10-03 11:32:27', '2026-10-03 11:32:27'),
(35, 35, NULL, NULL, NULL, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(36, 36, NULL, NULL, NULL, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(37, 37, NULL, NULL, NULL, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(38, 38, NULL, NULL, NULL, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(39, 39, NULL, NULL, NULL, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(40, 40, NULL, NULL, NULL, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(41, 41, NULL, NULL, NULL, NULL, '2026-10-03 11:32:31', '2026-10-03 11:32:31'),
(42, 42, NULL, NULL, NULL, NULL, '2026-10-03 11:32:32', '2026-10-03 11:32:32'),
(43, 43, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(44, 44, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(45, 45, NULL, NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(46, 46, NULL, NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(47, 47, NULL, NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(48, 48, NULL, NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(49, 49, NULL, NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(50, 50, NULL, NULL, NULL, NULL, '2026-10-03 14:28:25', '2026-10-03 14:28:25'),
(51, 51, NULL, NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(52, 52, NULL, NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(53, 53, NULL, NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(54, 54, NULL, NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(55, 55, NULL, NULL, NULL, NULL, '2026-10-03 14:28:28', '2026-10-03 14:28:28'),
(56, 56, NULL, NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(57, 57, NULL, NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(58, 58, NULL, NULL, NULL, NULL, '2026-10-03 14:28:30', '2026-10-03 14:28:30'),
(59, 59, NULL, NULL, NULL, NULL, '2026-10-03 14:30:58', '2026-10-03 14:30:58'),
(60, 60, NULL, NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(61, 61, NULL, NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(62, 62, NULL, NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(63, 63, NULL, NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(64, 64, NULL, NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(65, 65, NULL, NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(66, 66, NULL, NULL, NULL, NULL, '2026-10-03 14:31:02', '2026-10-03 14:31:02'),
(67, 67, NULL, NULL, NULL, NULL, '2026-10-03 14:42:58', '2026-10-03 14:42:58'),
(68, 68, NULL, NULL, NULL, NULL, '2026-10-03 14:42:59', '2026-10-03 14:42:59'),
(69, 69, NULL, NULL, NULL, NULL, '2026-10-03 15:04:20', '2026-10-03 15:04:20'),
(70, 70, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(71, 71, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(72, 72, NULL, NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(73, 73, NULL, NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(74, 74, NULL, NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(75, 75, NULL, NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(76, 76, NULL, NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(77, 77, NULL, NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(78, 78, NULL, NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(79, 79, NULL, NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(80, 80, NULL, NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(81, 81, NULL, NULL, NULL, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26'),
(82, 82, NULL, NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(83, 83, NULL, NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(84, 84, NULL, NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(85, 85, NULL, NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(86, 86, NULL, NULL, NULL, NULL, '2026-10-03 15:04:29', '2026-10-03 15:04:29'),
(87, 87, NULL, NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(88, 88, NULL, NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(89, 89, NULL, NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(90, 90, NULL, NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(91, 91, NULL, NULL, NULL, NULL, '2026-10-03 15:04:32', '2026-10-03 15:04:32'),
(92, 92, NULL, NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(93, 93, NULL, NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(94, 94, NULL, NULL, NULL, NULL, '2026-10-03 15:04:34', '2026-10-03 15:04:34'),
(95, 95, NULL, NULL, NULL, NULL, '2026-10-03 15:07:19', '2026-10-03 15:07:19'),
(96, 96, NULL, NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(97, 97, NULL, NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(98, 98, NULL, NULL, NULL, NULL, '2026-10-03 15:07:21', '2026-10-03 15:07:21'),
(99, 99, NULL, NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(100, 100, NULL, NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(101, 101, NULL, NULL, NULL, NULL, '2026-10-03 15:07:23', '2026-10-03 15:07:23'),
(102, 102, NULL, NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(103, 103, NULL, NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(104, 104, NULL, NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(105, 105, NULL, NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(106, 106, NULL, NULL, NULL, NULL, '2026-10-03 15:07:26', '2026-10-03 15:07:26'),
(107, 107, NULL, NULL, NULL, NULL, '2026-10-03 15:07:27', '2026-10-03 15:07:27'),
(108, 108, NULL, NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(109, 109, NULL, NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(110, 110, NULL, NULL, NULL, NULL, '2026-10-03 15:09:29', '2026-10-03 15:09:29'),
(111, 111, NULL, NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(112, 112, NULL, NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(113, 113, NULL, NULL, NULL, NULL, '2026-10-03 15:09:31', '2026-10-03 15:09:31'),
(114, 114, NULL, NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(115, 115, NULL, NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(116, 116, NULL, NULL, NULL, NULL, '2026-10-03 15:09:33', '2026-10-03 15:09:33'),
(117, 117, NULL, NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(118, 118, NULL, NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(119, 119, NULL, NULL, NULL, NULL, '2026-10-03 15:11:44', '2026-10-03 15:11:44'),
(120, 120, NULL, NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(121, 121, NULL, NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(122, 122, NULL, NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(123, 123, NULL, NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(124, 124, NULL, NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(125, 125, NULL, NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(126, 126, NULL, NULL, NULL, NULL, '2026-10-03 15:15:59', '2026-10-03 15:15:59'),
(127, 127, NULL, NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(128, 128, NULL, NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
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
(1, 'view_own_application', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(2, 'view_own_profile', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(3, 'edit_own_profile', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(4, 'request_exit', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(5, 'view_all_members', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(6, 'approve_applications', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(7, 'reject_applications', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(8, 'adjust_contribution', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(9, 'mark_application_fee_paid', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(10, 'review_change_requests', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(11, 'edit_locked_fields', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(12, 'manage_member_status', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(13, 'export_reports', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(14, 'view_registration_fee_reports', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(15, 'manage_registration_fee_settings', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(16, 'view_own_savings', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(17, 'request_withdrawal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(18, 'make_voluntary_deposit', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(19, 'post_contribution_batch', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(20, 'confirm_voluntary_deposit', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(21, 'treasurer_review_withdrawal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(22, 'chairman_authorize_withdrawal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(23, 'disburse_withdrawal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(24, 'initiate_reversal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(25, 'authorize_reversal', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(26, 'manage_withdrawal_conditions', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(27, 'manage_savings_products', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(28, 'view_savings_reports', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(29, 'import_members', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(30, 'view_own_loans', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(31, 'apply_for_loan', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(32, 'treasurer_review_loan', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(33, 'chairman_authorize_loan', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(34, 'disburse_loan', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(35, 'post_loan_repayment_batch', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(36, 'confirm_loan_repayment', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(37, 'manage_loan_products', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(38, 'set_loan_interest_rates', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(39, 'manage_loan_limit_multiplier', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(40, 'import_loans', 'web', '2026-10-03 03:44:30', '2026-10-03 03:44:30'),
(41, 'view_loan_reports', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(42, 'view_own_shares', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(43, 'purchase_shares', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(44, 'request_share_withdrawal', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(45, 'confirm_share_purchase', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(46, 'treasurer_review_share_withdrawal', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(47, 'chairman_authorize_share_withdrawal', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(48, 'disburse_share_withdrawal', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(49, 'manage_share_price', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(50, 'view_share_reports', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(51, 'view_own_dividends', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(52, 'manage_dividend_periods', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(53, 'declare_dividend_rates', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(54, 'calculate_dividends', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(55, 'post_dividends', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(56, 'view_dividend_reports', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(57, 'request_commodity_loan', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(58, 'manage_commodity_catalogue', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(59, 'manage_commodity_cycles', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(60, 'price_commodity_cycle', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(61, 'verify_commodity_cycle', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(62, 'approve_commodity_cycle', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(63, 'authorize_commodity_cycle', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(64, 'release_commodity_goods', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(65, 'view_activity_log', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(66, 'manage_member_documents', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(67, 'manage_loan_documents', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(68, 'manage_announcements', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(69, 'view_financial_statements', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(70, 'raise_complaint', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(71, 'raise_complaint_on_behalf', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(72, 'handle_complaints', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(73, 'handle_confidential_complaints', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(74, 'manage_budgets', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(75, 'approve_budgets', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(76, 'view_budget_reports', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(77, 'initiate_welfare_claim', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(78, 'authorize_welfare_claim', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(79, 'disburse_welfare_claim', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(80, 'post_welfare_levy', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(81, 'manage_welfare_settings', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(82, 'view_welfare_reports', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(83, 'manage_users', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `reversal_requests`
--

CREATE TABLE `reversal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `initiated_by` bigint(20) UNSIGNED NOT NULL,
  `authorized_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','authorized','declined','applied') NOT NULL DEFAULT 'pending',
  `decline_reason` text DEFAULT NULL,
  `resulting_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `authorized_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'applicant', 'web', '2026-10-03 03:44:31', '2026-10-03 03:44:31'),
(2, 'member', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(3, 'treasurer', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(4, 'chairman', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(5, 'secretary', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(6, 'exco', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(7, 'loan_officer', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(8, 'auditor', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(9, 'store_officer', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32'),
(10, 'super_admin', 'web', '2026-10-03 03:44:32', '2026-10-03 03:44:32');

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
(1, 1),
(1, 2),
(1, 10),
(2, 2),
(2, 10),
(3, 2),
(3, 10),
(4, 2),
(4, 10),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(6, 3),
(6, 10),
(7, 3),
(7, 10),
(8, 3),
(8, 10),
(9, 3),
(9, 10),
(10, 5),
(10, 10),
(11, 10),
(12, 3),
(12, 10),
(13, 3),
(13, 5),
(13, 6),
(13, 10),
(14, 3),
(14, 4),
(14, 6),
(14, 10),
(15, 4),
(15, 10),
(16, 2),
(16, 10),
(17, 2),
(17, 10),
(18, 2),
(18, 10),
(19, 3),
(19, 10),
(20, 3),
(20, 10),
(21, 3),
(21, 10),
(22, 4),
(22, 10),
(23, 3),
(23, 10),
(24, 3),
(24, 10),
(25, 4),
(25, 10),
(26, 3),
(26, 4),
(26, 10),
(27, 10),
(28, 3),
(28, 4),
(28, 6),
(28, 10),
(29, 3),
(29, 10),
(30, 2),
(30, 10),
(31, 2),
(31, 10),
(32, 3),
(32, 10),
(33, 4),
(33, 10),
(34, 3),
(34, 10),
(35, 3),
(35, 10),
(36, 3),
(36, 10),
(37, 10),
(38, 4),
(38, 10),
(39, 3),
(39, 10),
(40, 3),
(40, 10),
(41, 3),
(41, 4),
(41, 6),
(41, 10),
(42, 2),
(42, 10),
(43, 2),
(43, 10),
(44, 2),
(44, 10),
(45, 3),
(45, 10),
(46, 3),
(46, 10),
(47, 4),
(47, 10),
(48, 3),
(48, 10),
(49, 3),
(49, 4),
(49, 10),
(50, 3),
(50, 4),
(50, 6),
(50, 10),
(51, 2),
(51, 10),
(52, 3),
(52, 10),
(53, 4),
(53, 10),
(54, 3),
(54, 10),
(55, 3),
(55, 10),
(56, 3),
(56, 4),
(56, 6),
(56, 10),
(57, 2),
(57, 10),
(58, 5),
(58, 10),
(59, 5),
(59, 10),
(60, 5),
(60, 10),
(61, 8),
(61, 10),
(62, 9),
(62, 10),
(63, 4),
(63, 10),
(64, 9),
(64, 10),
(65, 8),
(65, 10),
(66, 3),
(66, 5),
(66, 10),
(67, 3),
(67, 4),
(67, 10),
(68, 4),
(68, 5),
(68, 10),
(69, 3),
(69, 4),
(69, 8),
(69, 10),
(70, 2),
(70, 10),
(71, 3),
(71, 5),
(71, 10),
(72, 3),
(72, 4),
(72, 5),
(72, 6),
(72, 10),
(73, 4),
(73, 10),
(74, 3),
(74, 10),
(75, 4),
(75, 10),
(76, 3),
(76, 4),
(76, 6),
(76, 8),
(76, 10),
(77, 3),
(77, 5),
(77, 10),
(78, 4),
(78, 10),
(79, 3),
(79, 10),
(80, 3),
(80, 10),
(81, 4),
(81, 10),
(82, 3),
(82, 4),
(82, 6),
(82, 8),
(82, 10),
(83, 10);

-- --------------------------------------------------------

--
-- Table structure for table `savings_accounts`
--

CREATE TABLE `savings_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `savings_product_id` bigint(20) UNSIGNED NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `target_amount` decimal(14,2) DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `opened_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_accounts`
--

INSERT INTO `savings_accounts` (`id`, `member_id`, `savings_product_id`, `account_no`, `target_amount`, `target_date`, `balance`, `status`, `opened_at`, `closed_at`, `created_at`, `updated_at`) VALUES
(43, 20, 1, 'FCET/CSL/FCE101191-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(44, 32, 1, 'FCET/CSL/FCE101244-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(45, 6, 1, 'FCET/CSL/FCE100182-REGULAR', NULL, NULL, 480000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(46, 2, 1, 'FCET/CSL/FCE100631-REGULAR', NULL, NULL, 640000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(47, 38, 1, 'FCET/CSL/FCE1001043-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(48, 10, 1, 'FCET/CSL/FCE100843-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(49, 22, 1, 'FCET/CSL/FCE101020-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(50, 24, 1, 'FCET/CSL/FCE100380-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(51, 19, 1, 'FCET/CSL/FCE100731-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:14:02'),
(52, 14, 1, 'FCET/CSL/FCE100215-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(53, 35, 1, 'FCET/CSL/FCE200065-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(54, 5, 1, 'FCET/CSL/FCE100887-REGULAR', NULL, NULL, 480000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(55, 26, 1, 'FCET/CSL/FCE100736-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(56, 11, 1, 'FCET/CSL/FCE100861-REGULAR', NULL, NULL, 480000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(57, 13, 1, 'FCET/CSL/FCE100851-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(58, 16, 1, 'FCET/CSL/FCE101060-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(59, 31, 1, 'FCET/CSL/FCE101235-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(60, 30, 1, 'FCET/CSL/FCE101232-REGULAR', NULL, NULL, 210000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(61, 7, 1, 'FCET/CSL/FCE100733-REGULAR', NULL, NULL, 800000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(62, 4, 1, 'FCET/CSL/FCE100778-REGULAR', NULL, NULL, 480000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(63, 12, 1, 'FCET/CSL/FCE100782-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(64, 1, 1, 'FCET/CSL/FCE100192-REGULAR', NULL, NULL, 300000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:18:21'),
(65, 17, 1, 'FCET/CSL/FCE200056-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(66, 15, 1, 'FCET/CSL/FCE100913-REGULAR', NULL, NULL, 240000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:10:20'),
(67, 42, 1, 'FCET/CSL/FCE101208-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(68, 3, 1, 'FCET/CSL/FCE100713-REGULAR', NULL, NULL, 1180000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(69, 37, 1, 'FCET/CSL/FCE101041-REGULAR', NULL, NULL, 75000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(70, 34, 1, 'FCET/CSL/FCE101387-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(71, 8, 1, 'FCET/CSL/FCE100726-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(72, 23, 1, 'FCET/CSL/FCE101085-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(73, 25, 1, 'FCET/CSL/FCE200042-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(74, 27, 1, 'FCET/CSL/FCE100514-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(75, 33, 1, 'FCET/CSL/FCE101228-REGULAR', NULL, NULL, 112000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(76, 40, 1, 'FCET/CSL/FCE1001024-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(77, 18, 1, 'FCET/CSL/FCE100737-REGULAR', NULL, NULL, 240000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(78, 39, 1, 'FCET/CSL/FCE100720-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(79, 36, 1, 'FCET/CSL/FCE200067-REGULAR', NULL, NULL, 255000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(80, 41, 1, 'FCET/CSL/FCE101061-REGULAR', NULL, NULL, 55000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:10:20'),
(81, 29, 1, 'FCET/CSL/FCE100709-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(82, 9, 1, 'FCET/CSL/FCE100832-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(83, 28, 1, 'FCET/CSL/FCE101139-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(84, 21, 1, 'FCET/CSL/FCE1001017-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 12:51:01', NULL, '2026-10-03 12:51:01', '2026-10-03 15:20:06'),
(85, 43, 1, 'FCET/CSL/FCE100205-REGULAR', NULL, NULL, 300000.00, 'active', '2026-10-03 14:24:47', NULL, '2026-10-03 14:24:47', '2026-10-03 15:20:06'),
(86, 44, 1, 'FCET/CSL/FCE101215-REGULAR', NULL, NULL, 75000.00, 'active', '2026-10-03 14:24:47', NULL, '2026-10-03 14:24:47', '2026-10-03 15:20:06'),
(87, 45, 1, 'FCET/CSL/FCE101268-REGULAR', NULL, NULL, 75000.00, 'active', '2026-10-03 14:24:47', NULL, '2026-10-03 14:24:47', '2026-10-03 15:20:06'),
(88, 46, 1, 'FCET/CSL/FCE100141-REGULAR', NULL, NULL, 420000.00, 'active', '2026-10-03 14:28:23', NULL, '2026-10-03 14:28:23', '2026-10-03 15:20:06'),
(89, 47, 1, 'FCET/CSL/FCE100080-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 14:28:23', NULL, '2026-10-03 14:28:23', '2026-10-03 15:20:06'),
(90, 48, 1, 'FCET/CSL/FCE100870-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 14:28:24', NULL, '2026-10-03 14:28:24', '2026-10-03 15:20:06'),
(91, 49, 1, 'FCET/CSL/FCE100337-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:28:24', NULL, '2026-10-03 14:28:24', '2026-10-03 15:18:21'),
(92, 50, 1, 'FCET/CSL/FCE100732-REGULAR', NULL, NULL, 280000.00, 'active', '2026-10-03 14:28:25', NULL, '2026-10-03 14:28:25', '2026-10-03 15:20:06'),
(93, 51, 1, 'FCET/CSL/FCE101076-REGULAR', NULL, NULL, 420000.00, 'active', '2026-10-03 14:28:26', NULL, '2026-10-03 14:28:26', '2026-10-03 15:20:06'),
(94, 52, 1, 'FCET/CSL/FCE200002-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 14:28:26', NULL, '2026-10-03 14:28:26', '2026-10-03 15:20:06'),
(95, 53, 1, 'FCET/CSL/FCE100696-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 14:28:27', NULL, '2026-10-03 14:28:27', '2026-10-03 15:20:06'),
(96, 54, 1, 'FCET/CSL/FCE101380-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 14:28:27', NULL, '2026-10-03 14:28:27', '2026-10-03 15:20:06'),
(97, 55, 1, 'FCET/CSL/FCE101140-REGULAR', NULL, NULL, 135000.00, 'active', '2026-10-03 14:28:28', NULL, '2026-10-03 14:28:28', '2026-10-03 15:20:06'),
(98, 56, 1, 'FCET/CSL/FCE101231-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 14:28:29', NULL, '2026-10-03 14:28:29', '2026-10-03 15:20:06'),
(99, 57, 1, 'FCET/CSL/FCE200057-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 14:28:29', NULL, '2026-10-03 14:28:29', '2026-10-03 15:20:06'),
(100, 58, 1, 'FCET/CSL/FCE101423-REGULAR', NULL, NULL, 90000.00, 'active', '2026-10-03 14:28:30', NULL, '2026-10-03 14:28:30', '2026-10-03 15:10:20'),
(101, 59, 1, 'FCET/CSL/FCE100848-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:30:58', NULL, '2026-10-03 14:30:58', '2026-10-03 15:20:06'),
(102, 60, 1, 'FCET/CSL/FCE100674-REGULAR', NULL, NULL, 60000.00, 'active', '2026-10-03 14:30:59', NULL, '2026-10-03 14:30:59', '2026-10-03 15:05:55'),
(103, 61, 1, 'FCET/CSL/FCE100911-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:30:59', NULL, '2026-10-03 14:30:59', '2026-10-03 15:20:06'),
(104, 62, 1, 'FCET/CSL/FCE200008-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:31:00', NULL, '2026-10-03 14:31:00', '2026-10-03 15:20:06'),
(105, 63, 1, 'FCET/CSL/FCE100789-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:31:00', NULL, '2026-10-03 14:31:00', '2026-10-03 15:20:06'),
(106, 64, 1, 'FCET/CSL/FCE101057-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:31:01', NULL, '2026-10-03 14:31:01', '2026-10-03 15:20:06'),
(107, 65, 1, 'FCET/CSL/FCE100366-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 14:31:01', NULL, '2026-10-03 14:31:01', '2026-10-03 15:20:06'),
(108, 66, 1, 'FCET/CSL/FCE100702-REGULAR', NULL, NULL, 170000.00, 'active', '2026-10-03 14:31:02', NULL, '2026-10-03 14:31:02', '2026-10-03 15:20:06'),
(109, 67, 1, 'FCET/CSL/FCE100939-REGULAR', NULL, NULL, 550000.00, 'active', '2026-10-03 14:42:58', NULL, '2026-10-03 14:42:58', '2026-10-03 15:20:06'),
(110, 68, 1, 'FCET/CSL/FCE101259-REGULAR', NULL, NULL, 110000.00, 'active', '2026-10-03 14:42:59', NULL, '2026-10-03 14:42:59', '2026-10-03 15:20:06'),
(111, 69, 1, 'FCET/CSL/FCE101378-REGULAR', NULL, NULL, 400000.00, 'active', '2026-10-03 15:04:20', NULL, '2026-10-03 15:04:20', '2026-10-03 15:20:06'),
(112, 70, 1, 'FCET/CSL/FCE100139-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:21', NULL, '2026-10-03 15:04:21', '2026-10-03 15:20:06'),
(113, 71, 1, 'FCET/CSL/FCE100122-REGULAR', NULL, NULL, 320000.00, 'active', '2026-10-03 15:04:21', NULL, '2026-10-03 15:04:21', '2026-10-03 15:20:06'),
(114, 72, 1, 'FCET/CSL/FCE100818-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 15:04:21', NULL, '2026-10-03 15:04:21', '2026-10-03 15:20:06'),
(115, 73, 1, 'FCET/CSL/FCE100816-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:22', NULL, '2026-10-03 15:04:22', '2026-10-03 15:20:06'),
(116, 74, 1, 'FCET/CSL/FCE100857-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:22', NULL, '2026-10-03 15:04:22', '2026-10-03 15:20:06'),
(117, 75, 1, 'FCET/CSL/FCE100900-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 15:04:23', NULL, '2026-10-03 15:04:23', '2026-10-03 15:20:06'),
(118, 76, 1, 'FCET/CSL/FCE100185-REGULAR', NULL, NULL, 800000.00, 'active', '2026-10-03 15:04:23', NULL, '2026-10-03 15:04:23', '2026-10-03 15:20:06'),
(119, 77, 1, 'FCET/CSL/FCE100547-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:04:24', NULL, '2026-10-03 15:04:24', '2026-10-03 15:20:06'),
(120, 78, 1, 'FCET/CSL/FCE100905-REGULAR', NULL, NULL, 480000.00, 'active', '2026-10-03 15:04:24', NULL, '2026-10-03 15:04:24', '2026-10-03 15:20:06'),
(121, 79, 1, 'FCET/CSL/FCE1001029-REGULAR', NULL, NULL, 500000.00, 'active', '2026-10-03 15:04:25', NULL, '2026-10-03 15:04:25', '2026-10-03 15:20:06'),
(122, 80, 1, 'FCET/CSL/FCE100979-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:25', NULL, '2026-10-03 15:04:25', '2026-10-03 15:20:06'),
(123, 81, 1, 'FCET/CSL/FCE100858-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:26', NULL, '2026-10-03 15:04:26', '2026-10-03 15:20:06'),
(124, 82, 1, 'FCET/CSL/FCE100932-REGULAR', NULL, NULL, 20000.00, 'active', '2026-10-03 15:04:27', NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(125, 83, 1, 'FCET/CSL/FCE100916-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:27', NULL, '2026-10-03 15:04:27', '2026-10-03 15:20:06'),
(126, 84, 1, 'FCET/CSL/FCE100791-REGULAR', NULL, NULL, 240000.00, 'active', '2026-10-03 15:04:28', NULL, '2026-10-03 15:04:28', '2026-10-03 15:20:06'),
(127, 85, 1, 'FCET/CSL/FCE200059-REGULAR', NULL, NULL, 120000.00, 'active', '2026-10-03 15:04:28', NULL, '2026-10-03 15:04:28', '2026-10-03 15:20:06'),
(128, 86, 1, 'FCET/CSL/FCE101173-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 15:04:29', NULL, '2026-10-03 15:04:29', '2026-10-03 15:20:06'),
(129, 87, 1, 'FCET/CSL/FCE101345-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:30', NULL, '2026-10-03 15:04:30', '2026-10-03 15:20:06'),
(130, 88, 1, 'FCET/CSL/FCE101237-REGULAR', NULL, NULL, 160000.00, 'active', '2026-10-03 15:04:30', NULL, '2026-10-03 15:04:30', '2026-10-03 15:20:06'),
(131, 89, 1, 'FCET/CSL/FCE100712-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:04:31', NULL, '2026-10-03 15:04:31', '2026-10-03 15:20:06'),
(132, 90, 1, 'FCET/CSL/FCE101362-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:31', NULL, '2026-10-03 15:04:31', '2026-10-03 15:20:06'),
(133, 91, 1, 'FCET/CSL/FCE101147-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:32', NULL, '2026-10-03 15:04:32', '2026-10-03 15:20:06'),
(134, 92, 1, 'FCET/CSL/FCE1001037-REGULAR', NULL, NULL, 80000.00, 'active', '2026-10-03 15:04:33', NULL, '2026-10-03 15:04:33', '2026-10-03 15:20:06'),
(135, 93, 1, 'FCET/CSL/FCE101084-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:04:33', NULL, '2026-10-03 15:04:33', '2026-10-03 15:20:06'),
(136, 94, 1, 'FCET/CSL/FCE100960-REGULAR', NULL, NULL, 36000.00, 'active', '2026-10-03 15:04:34', NULL, '2026-10-03 15:04:34', '2026-10-03 15:20:06'),
(137, 95, 1, 'FCET/CSL/FCE100053-REGULAR', NULL, NULL, 280000.00, 'active', '2026-10-03 15:07:19', NULL, '2026-10-03 15:07:19', '2026-10-03 15:20:06'),
(138, 96, 1, 'FCET/CSL/FCE100774-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 15:07:20', NULL, '2026-10-03 15:07:20', '2026-10-03 15:20:06'),
(139, 97, 1, 'FCET/CSL/FCE100941-REGULAR', NULL, NULL, 175000.00, 'active', '2026-10-03 15:07:20', NULL, '2026-10-03 15:07:20', '2026-10-03 15:20:06'),
(140, 98, 1, 'FCET/CSL/FCE100121-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 15:07:21', NULL, '2026-10-03 15:07:21', '2026-10-03 15:20:06'),
(141, 99, 1, 'FCET/CSL/FCE100717-REGULAR', NULL, NULL, 10000.00, 'active', '2026-10-03 15:07:22', NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(142, 100, 1, 'FCET/CSL/FCE101152-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 15:07:22', NULL, '2026-10-03 15:07:22', '2026-10-03 15:20:06'),
(143, 101, 1, 'FCET/CSL/FCE101227-REGULAR', NULL, NULL, 35000.00, 'active', '2026-10-03 15:07:23', NULL, '2026-10-03 15:07:23', '2026-10-03 15:20:06'),
(144, 102, 1, 'FCET/CSL/FCE101132-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 15:07:24', NULL, '2026-10-03 15:07:24', '2026-10-03 15:20:06'),
(145, 103, 1, 'FCET/CSL/FCE101281-REGULAR', NULL, NULL, 35000.00, 'active', '2026-10-03 15:07:24', NULL, '2026-10-03 15:07:24', '2026-10-03 15:20:06'),
(146, 104, 1, 'FCET/CSL/FCE101327-REGULAR', NULL, NULL, 140000.00, 'active', '2026-10-03 15:07:25', NULL, '2026-10-03 15:07:25', '2026-10-03 15:20:06'),
(147, 105, 1, 'FCET/CSL/FCE101275-REGULAR', NULL, NULL, 70000.00, 'active', '2026-10-03 15:07:25', NULL, '2026-10-03 15:07:25', '2026-10-03 15:20:06'),
(148, 106, 1, 'FCET/CSL/FCE101287-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:07:26', NULL, '2026-10-03 15:07:26', '2026-10-03 15:20:06'),
(149, 107, 1, 'FCET/CSL/FCE101404-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:07:27', NULL, '2026-10-03 15:07:27', '2026-10-03 15:20:06'),
(150, 108, 1, 'FCET/CSL/FCE100200-REGULAR', NULL, NULL, 130000.00, 'active', '2026-10-03 15:09:28', NULL, '2026-10-03 15:09:28', '2026-10-03 15:20:06'),
(151, 109, 1, 'FCET/CSL/FCE100705-REGULAR', NULL, NULL, 30000.00, 'active', '2026-10-03 15:09:28', NULL, '2026-10-03 15:09:28', '2026-10-03 15:20:06'),
(152, 110, 1, 'FCET/CSL/FCE101069-REGULAR', NULL, NULL, 60000.00, 'active', '2026-10-03 15:09:29', NULL, '2026-10-03 15:09:29', '2026-10-03 15:20:06'),
(153, 111, 1, 'FCET/CSL/FCE1001031-REGULAR', NULL, NULL, 60000.00, 'active', '2026-10-03 15:09:30', NULL, '2026-10-03 15:09:30', '2026-10-03 15:20:06'),
(154, 112, 1, 'FCET/CSL/FCE101082-REGULAR', NULL, NULL, 60000.00, 'active', '2026-10-03 15:09:30', NULL, '2026-10-03 15:09:30', '2026-10-03 15:20:06'),
(155, 113, 1, 'FCET/CSL/FCE101240-REGULAR', NULL, NULL, 30000.00, 'active', '2026-10-03 15:09:31', NULL, '2026-10-03 15:09:31', '2026-10-03 15:20:06'),
(156, 114, 1, 'FCET/CSL/FCE101180-REGULAR', NULL, NULL, 60000.00, 'active', '2026-10-03 15:09:32', NULL, '2026-10-03 15:09:32', '2026-10-03 15:20:06'),
(157, 115, 1, 'FCET/CSL/FCE101264-REGULAR', NULL, NULL, 30000.00, 'active', '2026-10-03 15:09:32', NULL, '2026-10-03 15:09:32', '2026-10-03 15:20:06'),
(158, 116, 1, 'FCET/CSL/FCE101119-REGULAR', NULL, NULL, 30000.00, 'active', '2026-10-03 15:09:33', NULL, '2026-10-03 15:09:33', '2026-10-03 15:20:06'),
(159, 117, 1, 'FCET/CSL/FCE100184-REGULAR', NULL, NULL, 50000.00, 'active', '2026-10-03 15:11:43', NULL, '2026-10-03 15:11:43', '2026-10-03 15:20:06'),
(160, 118, 1, 'FCET/CSL/FCE100981-REGULAR', NULL, NULL, 50000.00, 'active', '2026-10-03 15:11:43', NULL, '2026-10-03 15:11:43', '2026-10-03 15:20:06'),
(161, 119, 1, 'FCET/CSL/FCE100928-REGULAR', NULL, NULL, 50000.00, 'active', '2026-10-03 15:11:44', NULL, '2026-10-03 15:11:44', '2026-10-03 15:20:06'),
(162, 120, 1, 'FCET/CSL/FCE100692-REGULAR', NULL, NULL, 100000.00, 'active', '2026-10-03 15:11:45', NULL, '2026-10-03 15:11:45', '2026-10-03 15:20:06'),
(163, 121, 1, 'FCET/CSL/FCE101138-REGULAR', NULL, NULL, 50000.00, 'active', '2026-10-03 15:11:45', NULL, '2026-10-03 15:11:45', '2026-10-03 15:20:06'),
(164, 122, 1, 'FCET/CSL/FCE100625-REGULAR', NULL, NULL, 300000.00, 'active', '2026-10-03 15:15:57', NULL, '2026-10-03 15:15:57', '2026-10-03 15:20:06'),
(165, 123, 1, 'FCET/CSL/FCE200019-REGULAR', NULL, NULL, 40000.00, 'active', '2026-10-03 15:15:57', NULL, '2026-10-03 15:15:57', '2026-10-03 15:20:06'),
(166, 124, 1, 'FCET/CSL/FCE101092-REGULAR', NULL, NULL, 10000.00, 'active', '2026-10-03 15:15:58', NULL, '2026-10-03 15:15:58', '2026-10-03 15:20:06'),
(167, 125, 1, 'FCET/CSL/FCE100722-REGULAR', NULL, NULL, 10000.00, 'active', '2026-10-03 15:15:58', NULL, '2026-10-03 15:15:58', '2026-10-03 15:20:06'),
(168, 126, 1, 'FCET/CSL/FCE100624-REGULAR', NULL, NULL, 20000.00, 'active', '2026-10-03 15:15:59', NULL, '2026-10-03 15:15:59', '2026-10-03 15:20:06'),
(169, 127, 1, 'FCET/CSL/FCE100292-REGULAR', NULL, NULL, 10000.00, 'active', '2026-10-03 15:19:35', NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(170, 128, 1, 'FCET/CSL/FCE100964-REGULAR', NULL, NULL, 5000.00, 'active', '2026-10-03 15:19:35', NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `savings_products`
--

CREATE TABLE `savings_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_interest_bearing` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_products`
--

INSERT INTO `savings_products` (`id`, `code`, `name`, `is_interest_bearing`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'regular', 'Regular Savings', 0, 'Funded by approved monthly salary deduction plus voluntary top-ups.', 1, '2026-10-03 12:46:16', '2026-10-03 12:46:16'),
(2, 'target', 'Target/Special Savings', 0, 'Member-defined goal savings with an optional target amount and date.', 1, '2026-10-03 12:46:16', '2026-10-03 12:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `savings_transactions`
--

CREATE TABLE `savings_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `savings_account_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `posted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `withdrawal_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reversed_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `savings_transactions`
--

INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(43, 43, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(44, 44, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(45, 45, 'contribution_deduction', 30000.00, 30000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(46, 46, 'contribution_deduction', 40000.00, 40000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(47, 47, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(48, 48, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(49, 49, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(50, 50, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(51, 51, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(52, 52, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(53, 53, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(54, 54, 'contribution_deduction', 30000.00, 30000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(55, 55, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(56, 56, 'contribution_deduction', 30000.00, 30000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(57, 57, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(58, 58, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(59, 59, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(60, 60, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(61, 61, 'contribution_deduction', 50000.00, 50000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(62, 62, 'contribution_deduction', 30000.00, 30000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(63, 63, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(64, 64, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(65, 65, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(66, 66, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(67, 67, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(68, 68, 'contribution_deduction', 50000.00, 50000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(69, 69, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(70, 70, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(71, 71, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(72, 72, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(73, 73, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(74, 74, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(75, 75, 'contribution_deduction', 7000.00, 7000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(76, 76, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(77, 77, 'contribution_deduction', 15000.00, 15000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(78, 78, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(79, 79, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(80, 80, 'contribution_deduction', 5000.00, 5000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(81, 81, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(82, 82, 'contribution_deduction', 20000.00, 20000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(83, 83, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(84, 84, 'contribution_deduction', 10000.00, 10000.00, 'BATCH-1', 'Monthly contribution for 2025-06', 2, '2026-10-03 12:51:01', 1, NULL, NULL, '2026-10-03 12:51:01', '2026-10-03 12:51:01'),
(85, 85, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100205', 'Opening balance migrated from manual records', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(86, 86, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101215', 'Opening balance migrated from manual records', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(87, 87, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101268', 'Opening balance migrated from manual records', 2, '2026-10-03 14:24:47', NULL, NULL, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(88, 64, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(89, 46, 'contribution_deduction', 40000.00, 80000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(90, 68, 'contribution_deduction', 50000.00, 100000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(91, 62, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(92, 54, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(93, 45, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(94, 61, 'contribution_deduction', 50000.00, 100000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(95, 71, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(96, 82, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(97, 48, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(98, 56, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(99, 63, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(100, 57, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(101, 52, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(102, 66, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(103, 58, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(104, 65, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(105, 77, 'contribution_deduction', 15000.00, 30000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(106, 51, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(107, 43, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(108, 84, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(109, 49, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(110, 72, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(111, 50, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(112, 73, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(113, 55, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(114, 74, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(115, 83, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(116, 81, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(117, 60, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(118, 59, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(119, 44, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(120, 75, 'contribution_deduction', 7000.00, 14000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(121, 70, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(122, 53, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(123, 79, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(124, 69, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(125, 47, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(126, 78, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(127, 76, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(128, 80, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(129, 67, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-2', 'Monthly contribution for 2025-07', 2, '2026-10-03 14:25:43', 2, NULL, NULL, '2026-10-03 14:25:43', '2026-10-03 14:25:43'),
(130, 88, 'opening_balance', 30000.00, 30000.00, 'IMPORT-FCE100141', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:23', NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(131, 89, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100080', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:23', NULL, NULL, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(132, 90, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100870', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:24', NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(133, 91, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100337', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:24', NULL, NULL, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(134, 92, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100732', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:25', NULL, NULL, NULL, '2026-10-03 14:28:25', '2026-10-03 14:28:25'),
(135, 93, 'opening_balance', 30000.00, 30000.00, 'IMPORT-FCE101076', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:26', NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(136, 94, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE200002', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:26', NULL, NULL, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(137, 95, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100696', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:27', NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(138, 96, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101380', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:27', NULL, NULL, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(139, 97, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101140', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:28', NULL, NULL, NULL, '2026-10-03 14:28:28', '2026-10-03 14:28:28'),
(140, 98, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101231', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:29', NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(141, 99, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE200057', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:29', NULL, NULL, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(142, 100, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101423', 'Opening balance migrated from manual records', 2, '2026-10-03 14:28:30', NULL, NULL, NULL, '2026-10-03 14:28:30', '2026-10-03 14:28:30'),
(143, 64, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(144, 46, 'contribution_deduction', 40000.00, 120000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(145, 68, 'contribution_deduction', 50000.00, 150000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(146, 85, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(147, 62, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(148, 54, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(149, 45, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(150, 61, 'contribution_deduction', 50000.00, 150000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(151, 71, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(152, 82, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(153, 48, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(154, 56, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(155, 63, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(156, 57, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(157, 52, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(158, 66, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(159, 58, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(160, 65, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(161, 77, 'contribution_deduction', 15000.00, 45000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(162, 51, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(163, 43, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(164, 84, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(165, 49, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(166, 72, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(167, 50, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(168, 73, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(169, 55, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(170, 74, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(171, 83, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(172, 81, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(173, 60, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(174, 59, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(175, 44, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(176, 75, 'contribution_deduction', 7000.00, 21000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(177, 86, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(178, 70, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(179, 53, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(180, 79, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(181, 69, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(182, 47, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(183, 78, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(184, 76, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(185, 87, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(186, 80, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(187, 67, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-3', 'Monthly contribution for 2025-08', 2, '2026-10-03 14:29:16', 3, NULL, NULL, '2026-10-03 14:29:16', '2026-10-03 14:29:16'),
(188, 101, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100848', 'Opening balance migrated from manual records', 2, '2026-10-03 14:30:58', NULL, NULL, NULL, '2026-10-03 14:30:58', '2026-10-03 14:30:58'),
(189, 102, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100674', 'Opening balance migrated from manual records', 2, '2026-10-03 14:30:59', NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(190, 103, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100911', 'Opening balance migrated from manual records', 2, '2026-10-03 14:30:59', NULL, NULL, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(191, 104, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE200008', 'Opening balance migrated from manual records', 2, '2026-10-03 14:31:00', NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(192, 105, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100789', 'Opening balance migrated from manual records', 2, '2026-10-03 14:31:00', NULL, NULL, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(193, 106, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101057', 'Opening balance migrated from manual records', 2, '2026-10-03 14:31:01', NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(194, 107, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100366', 'Opening balance migrated from manual records', 2, '2026-10-03 14:31:01', NULL, NULL, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(195, 108, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100702', 'Opening balance migrated from manual records', 2, '2026-10-03 14:31:02', NULL, NULL, NULL, '2026-10-03 14:31:02', '2026-10-03 14:31:02'),
(196, 88, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(197, 89, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(198, 64, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(199, 46, 'contribution_deduction', 40000.00, 160000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(200, 68, 'contribution_deduction', 50000.00, 200000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(201, 85, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(202, 62, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(203, 54, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(204, 45, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(205, 61, 'contribution_deduction', 50000.00, 200000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(206, 71, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(207, 82, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(208, 48, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(209, 56, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(210, 63, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(211, 57, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(212, 90, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(213, 52, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(214, 91, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(215, 66, 'contribution_deduction', 40000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(216, 58, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(217, 65, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(218, 77, 'contribution_deduction', 15000.00, 60000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(219, 92, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(220, 51, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(221, 43, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(222, 93, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(223, 84, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(224, 49, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(225, 94, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(226, 72, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(227, 50, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(228, 73, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(229, 55, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(230, 95, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(231, 74, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(232, 83, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(233, 81, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(234, 60, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(235, 59, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(236, 44, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(237, 96, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(238, 75, 'contribution_deduction', 7000.00, 28000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(239, 97, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(240, 86, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(241, 98, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(242, 70, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(243, 53, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:46', 4, NULL, NULL, '2026-10-03 14:31:46', '2026-10-03 14:31:46'),
(244, 79, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(245, 99, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(246, 69, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(247, 47, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(248, 78, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(249, 76, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(250, 87, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(251, 80, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(252, 67, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(253, 100, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-4', 'Monthly contribution for 2025-09', 2, '2026-10-03 14:31:47', 4, NULL, NULL, '2026-10-03 14:31:47', '2026-10-03 14:31:47'),
(254, 88, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(255, 89, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(256, 64, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(257, 46, 'contribution_deduction', 40000.00, 200000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(258, 68, 'contribution_deduction', 50000.00, 250000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(259, 85, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(260, 62, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(261, 54, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(262, 45, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(263, 61, 'contribution_deduction', 50000.00, 250000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(264, 71, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(265, 101, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(266, 102, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(267, 82, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(268, 48, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(269, 56, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(270, 63, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(271, 57, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(272, 90, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(273, 52, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(274, 91, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(275, 66, 'contribution_deduction', 40000.00, 120000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(276, 103, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(277, 58, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(278, 65, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(279, 77, 'contribution_deduction', 15000.00, 75000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(280, 92, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(281, 104, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(282, 51, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(283, 105, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(284, 43, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(285, 106, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(286, 93, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(287, 84, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(288, 49, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(289, 94, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(290, 72, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(291, 50, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(292, 107, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(293, 108, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(294, 73, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(295, 55, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(296, 95, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(297, 74, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(298, 83, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(299, 81, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(300, 60, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(301, 59, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(302, 44, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(303, 96, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07');
INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(304, 75, 'contribution_deduction', 7000.00, 35000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(305, 97, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(306, 86, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(307, 98, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(308, 70, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(309, 53, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(310, 79, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(311, 99, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(312, 69, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(313, 47, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(314, 78, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(315, 76, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(316, 87, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(317, 80, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(318, 67, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(319, 100, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-5', 'Monthly contribution for 2025-10', 2, '2026-10-03 14:41:07', 5, NULL, NULL, '2026-10-03 14:41:07', '2026-10-03 14:41:07'),
(320, 109, 'opening_balance', 50000.00, 50000.00, 'IMPORT-FCE100939', 'Opening balance migrated from manual records', 2, '2026-10-03 14:42:58', NULL, NULL, NULL, '2026-10-03 14:42:58', '2026-10-03 14:42:58'),
(321, 110, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101259', 'Opening balance migrated from manual records', 2, '2026-10-03 14:42:59', NULL, NULL, NULL, '2026-10-03 14:42:59', '2026-10-03 14:42:59'),
(322, 88, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(323, 89, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(324, 64, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(325, 46, 'contribution_deduction', 40000.00, 240000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(326, 68, 'contribution_deduction', 50000.00, 300000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(327, 85, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(328, 62, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(329, 54, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(330, 45, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(331, 61, 'contribution_deduction', 50000.00, 300000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(332, 71, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(333, 101, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(334, 102, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(335, 82, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(336, 48, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(337, 56, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(338, 63, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(339, 57, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(340, 90, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(341, 52, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(342, 91, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(343, 66, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(344, 103, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(345, 58, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(346, 65, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(347, 77, 'contribution_deduction', 15000.00, 90000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(348, 92, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(349, 104, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(350, 51, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(351, 105, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(352, 43, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(353, 106, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(354, 93, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(355, 84, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(356, 49, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(357, 94, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(358, 72, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(359, 50, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(360, 107, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(361, 108, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(362, 73, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(363, 55, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(364, 95, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(365, 74, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(366, 83, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(367, 81, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(368, 60, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(369, 59, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(370, 44, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(371, 96, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(372, 75, 'contribution_deduction', 7000.00, 42000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(373, 97, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(374, 86, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(375, 98, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(376, 70, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(377, 53, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(378, 79, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(379, 99, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(380, 69, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(381, 47, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(382, 78, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(383, 76, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(384, 87, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(385, 80, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(386, 67, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(387, 100, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-6', 'Monthly contribution for 2025-11', 2, '2026-10-03 14:44:31', 6, NULL, NULL, '2026-10-03 14:44:31', '2026-10-03 14:44:31'),
(388, 88, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(389, 89, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(390, 64, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(391, 46, 'contribution_deduction', 40000.00, 280000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(392, 68, 'contribution_deduction', 50000.00, 350000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(393, 85, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(394, 62, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(395, 54, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(396, 45, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(397, 61, 'contribution_deduction', 50000.00, 350000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(398, 71, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(399, 101, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(400, 102, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(401, 82, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(402, 109, 'contribution_deduction', 50000.00, 100000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(403, 48, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(404, 56, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(405, 63, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(406, 57, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(407, 90, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(408, 52, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(409, 91, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(410, 66, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(411, 103, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(412, 58, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(413, 65, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(414, 77, 'contribution_deduction', 15000.00, 105000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(415, 92, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(416, 104, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(417, 51, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(418, 105, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(419, 43, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(420, 106, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(421, 93, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(422, 84, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(423, 49, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(424, 94, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(425, 72, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(426, 50, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(427, 107, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(428, 108, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(429, 73, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(430, 55, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(431, 95, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(432, 74, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(433, 83, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(434, 81, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(435, 60, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(436, 59, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(437, 44, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(438, 96, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(439, 75, 'contribution_deduction', 7000.00, 49000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(440, 110, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(441, 97, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(442, 86, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(443, 98, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(444, 70, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(445, 53, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(446, 79, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(447, 99, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(448, 69, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(449, 47, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(450, 78, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(451, 76, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(452, 87, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(453, 80, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(454, 67, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(455, 100, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-7', 'Monthly contribution for 2025-12', 2, '2026-10-03 14:46:47', 7, NULL, NULL, '2026-10-03 14:46:47', '2026-10-03 14:46:47'),
(456, 88, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(457, 89, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(458, 64, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(459, 46, 'contribution_deduction', 40000.00, 320000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(460, 68, 'contribution_deduction', 50000.00, 400000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(461, 85, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(462, 62, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(463, 54, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(464, 45, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(465, 61, 'contribution_deduction', 50000.00, 400000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(466, 71, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(467, 101, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(468, 102, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(469, 82, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(470, 109, 'contribution_deduction', 50000.00, 150000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(471, 48, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(472, 56, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(473, 63, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(474, 57, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(475, 90, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(476, 52, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(477, 91, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(478, 66, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(479, 103, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(480, 58, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(481, 65, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(482, 77, 'contribution_deduction', 15000.00, 120000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(483, 92, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(484, 104, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(485, 51, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(486, 105, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(487, 43, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(488, 106, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(489, 93, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(490, 84, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(491, 49, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(492, 94, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(493, 72, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(494, 50, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(495, 107, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(496, 108, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(497, 73, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(498, 55, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(499, 95, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(500, 74, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(501, 83, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(502, 81, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(503, 60, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(504, 59, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(505, 44, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(506, 96, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(507, 75, 'contribution_deduction', 7000.00, 56000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(508, 110, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(509, 97, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(510, 86, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(511, 98, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(512, 70, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(513, 53, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(514, 79, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(515, 99, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(516, 69, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(517, 47, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(518, 78, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(519, 76, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(520, 87, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(521, 80, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(522, 67, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(523, 100, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-8', 'Monthly contribution for 2026-01', 2, '2026-10-03 14:47:50', 8, NULL, NULL, '2026-10-03 14:47:50', '2026-10-03 14:47:50'),
(524, 111, 'opening_balance', 50000.00, 50000.00, 'IMPORT-FCE101378', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:20', NULL, NULL, NULL, '2026-10-03 15:04:20', '2026-10-03 15:04:20'),
(525, 112, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100139', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(526, 113, 'opening_balance', 40000.00, 40000.00, 'IMPORT-FCE100122', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(527, 114, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100818', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:21', NULL, NULL, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(528, 115, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100816', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:22', NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(529, 116, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100857', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:22', NULL, NULL, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(530, 117, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100900', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:23', NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(531, 118, 'opening_balance', 100000.00, 100000.00, 'IMPORT-FCE100185', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:23', NULL, NULL, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(532, 119, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100547', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:24', NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(533, 120, 'opening_balance', 60000.00, 60000.00, 'IMPORT-FCE100905', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:24', NULL, NULL, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(534, 121, 'opening_balance', 50000.00, 50000.00, 'IMPORT-FCE1001029', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:25', NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(535, 122, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100979', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:25', NULL, NULL, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(536, 123, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100858', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:26', NULL, NULL, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26'),
(537, 124, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100932', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:27', NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(538, 125, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100916', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:27', NULL, NULL, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(539, 126, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100791', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:28', NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(540, 127, 'opening_balance', 15000.00, 15000.00, 'IMPORT-FCE200059', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:28', NULL, NULL, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(541, 128, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE101173', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:29', NULL, NULL, NULL, '2026-10-03 15:04:29', '2026-10-03 15:04:29'),
(542, 129, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101345', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:30', NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(543, 130, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE101237', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:30', NULL, NULL, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(544, 131, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100712', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:31', NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(545, 132, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101362', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:31', NULL, NULL, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(546, 133, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101147', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:32', NULL, NULL, NULL, '2026-10-03 15:04:32', '2026-10-03 15:04:32'),
(547, 134, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE1001037', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:33', NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(548, 135, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101084', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:33', NULL, NULL, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(549, 136, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100960', 'Opening balance migrated from manual records', 2, '2026-10-03 15:04:34', NULL, NULL, NULL, '2026-10-03 15:04:34', '2026-10-03 15:04:34'),
(550, 88, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(551, 89, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(552, 64, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(553, 46, 'contribution_deduction', 40000.00, 360000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(554, 68, 'contribution_deduction', 80000.00, 480000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(555, 85, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(556, 62, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(557, 54, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(558, 45, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(559, 61, 'contribution_deduction', 50000.00, 450000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(560, 71, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(561, 101, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(562, 102, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(563, 82, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55');
INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(564, 109, 'contribution_deduction', 50000.00, 200000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(565, 48, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(566, 56, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(567, 63, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(568, 57, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(569, 90, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(570, 52, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(571, 91, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(572, 66, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(573, 103, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(574, 58, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(575, 65, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(576, 77, 'contribution_deduction', 15000.00, 135000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(577, 92, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(578, 104, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(579, 51, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(580, 105, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(581, 43, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(582, 106, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(583, 93, 'contribution_deduction', 30000.00, 210000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(584, 84, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(585, 49, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(586, 94, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(587, 72, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(588, 50, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(589, 107, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(590, 108, 'contribution_deduction', 15000.00, 65000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(591, 73, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(592, 55, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(593, 95, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(594, 74, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(595, 83, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(596, 81, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(597, 60, 'contribution_deduction', 60000.00, 140000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(598, 59, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(599, 44, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(600, 96, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(601, 75, 'contribution_deduction', 7000.00, 63000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(602, 110, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(603, 97, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(604, 86, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(605, 98, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(606, 70, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(607, 53, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(608, 79, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(609, 99, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(610, 69, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(611, 47, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(612, 78, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(613, 76, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(614, 87, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(615, 80, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(616, 67, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(617, 100, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-9', 'Monthly contribution for 2026-02', 2, '2026-10-03 15:05:55', 9, NULL, NULL, '2026-10-03 15:05:55', '2026-10-03 15:05:55'),
(618, 137, 'opening_balance', 30000.00, 30000.00, 'IMPORT-FCE100053', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:19', NULL, NULL, NULL, '2026-10-03 15:07:19', '2026-10-03 15:07:19'),
(619, 138, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100774', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:20', NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(620, 139, 'opening_balance', 25000.00, 25000.00, 'IMPORT-FCE100941', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:20', NULL, NULL, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(621, 140, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100121', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:21', NULL, NULL, NULL, '2026-10-03 15:07:21', '2026-10-03 15:07:21'),
(622, 141, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100717', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:22', NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(623, 142, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101152', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:22', NULL, NULL, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(624, 143, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101227', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:23', NULL, NULL, NULL, '2026-10-03 15:07:23', '2026-10-03 15:07:23'),
(625, 144, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101132', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:24', NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(626, 145, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101281', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:24', NULL, NULL, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(627, 146, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE101327', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:25', NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(628, 147, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101275', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:25', NULL, NULL, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(629, 148, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101287', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:26', NULL, NULL, NULL, '2026-10-03 15:07:26', '2026-10-03 15:07:26'),
(630, 149, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101404', 'Opening balance migrated from manual records', 2, '2026-10-03 15:07:27', NULL, NULL, NULL, '2026-10-03 15:07:27', '2026-10-03 15:07:27'),
(631, 88, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(632, 111, 'contribution_deduction', 50000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(633, 89, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(634, 112, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(635, 64, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(636, 46, 'contribution_deduction', 40000.00, 400000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(637, 68, 'contribution_deduction', 100000.00, 580000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(638, 113, 'contribution_deduction', 40000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(639, 85, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(640, 62, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(641, 54, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(642, 45, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(643, 114, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(644, 61, 'contribution_deduction', 50000.00, 500000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(645, 71, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:04', 10, NULL, NULL, '2026-10-03 15:08:04', '2026-10-03 15:08:04'),
(646, 101, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(647, 115, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(648, 82, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(649, 116, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(650, 117, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(651, 109, 'contribution_deduction', 50000.00, 250000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(652, 48, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(653, 56, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(654, 118, 'contribution_deduction', 100000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(655, 119, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(656, 63, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(657, 57, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(658, 90, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(659, 120, 'contribution_deduction', 60000.00, 120000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(660, 52, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(661, 91, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(662, 121, 'contribution_deduction', 50000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(663, 122, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(664, 66, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(665, 103, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(666, 123, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(667, 58, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(668, 65, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(669, 77, 'contribution_deduction', 15000.00, 150000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(670, 92, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(671, 125, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(672, 104, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(673, 51, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(674, 105, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(675, 126, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(676, 43, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(677, 106, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(678, 93, 'contribution_deduction', 30000.00, 240000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(679, 84, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(680, 49, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(681, 94, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(682, 72, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(683, 50, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(684, 107, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(685, 108, 'contribution_deduction', 15000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(686, 73, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(687, 55, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(688, 95, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(689, 74, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(690, 83, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(691, 81, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(692, 127, 'contribution_deduction', 15000.00, 30000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(693, 60, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(694, 59, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(695, 128, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(696, 129, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(697, 130, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(698, 44, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(699, 96, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(700, 131, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(701, 132, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(702, 75, 'contribution_deduction', 7000.00, 70000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(703, 110, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(704, 97, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(705, 133, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(706, 86, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(707, 98, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(708, 70, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(709, 53, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(710, 79, 'contribution_deduction', 5000.00, 95000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(711, 99, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(712, 47, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(713, 78, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(714, 76, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(715, 87, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(716, 134, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(717, 135, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(718, 136, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(719, 80, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(720, 67, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(721, 100, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-10', 'Monthly contribution for 2026-03', 2, '2026-10-03 15:08:05', 10, NULL, NULL, '2026-10-03 15:08:05', '2026-10-03 15:08:05'),
(722, 150, 'opening_balance', 30000.00, 30000.00, 'IMPORT-FCE100200', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:28', NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(723, 151, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100705', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:28', NULL, NULL, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(724, 152, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101069', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:29', NULL, NULL, NULL, '2026-10-03 15:09:29', '2026-10-03 15:09:29'),
(725, 153, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE1001031', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:30', NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(726, 154, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101082', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:30', NULL, NULL, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(727, 155, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101240', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:31', NULL, NULL, NULL, '2026-10-03 15:09:31', '2026-10-03 15:09:31'),
(728, 156, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101180', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:32', NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(729, 157, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101264', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:32', NULL, NULL, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(730, 158, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101119', 'Opening balance migrated from manual records', 2, '2026-10-03 15:09:33', NULL, NULL, NULL, '2026-10-03 15:09:33', '2026-10-03 15:09:33'),
(731, 88, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(732, 111, 'contribution_deduction', 50000.00, 150000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(733, 137, 'contribution_deduction', 30000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(734, 89, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(735, 112, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(736, 64, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(737, 46, 'contribution_deduction', 40000.00, 440000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(738, 68, 'contribution_deduction', 100000.00, 680000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(739, 113, 'contribution_deduction', 40000.00, 120000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(740, 85, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(741, 62, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(742, 138, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(743, 54, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(744, 45, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(745, 114, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(746, 61, 'contribution_deduction', 50000.00, 550000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(747, 71, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(748, 101, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(749, 115, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(750, 82, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(751, 116, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(752, 117, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(753, 109, 'contribution_deduction', 50000.00, 300000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(754, 48, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(755, 56, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(756, 118, 'contribution_deduction', 100000.00, 300000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(757, 119, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(758, 63, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(759, 57, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(760, 90, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(761, 120, 'contribution_deduction', 60000.00, 180000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(762, 52, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(763, 91, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(764, 121, 'contribution_deduction', 50000.00, 150000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(765, 122, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(766, 66, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(767, 103, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(768, 139, 'contribution_deduction', 25000.00, 50000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(769, 123, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(770, 58, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(771, 65, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(772, 140, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(773, 77, 'contribution_deduction', 15000.00, 165000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(774, 92, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(775, 125, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(776, 104, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(777, 51, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(778, 105, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(779, 126, 'contribution_deduction', 60000.00, 100000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(780, 43, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(781, 106, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(782, 93, 'contribution_deduction', 30000.00, 270000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(783, 84, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(784, 49, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(785, 94, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(786, 72, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(787, 50, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(788, 107, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(789, 108, 'contribution_deduction', 15000.00, 95000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(790, 73, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(791, 55, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(792, 95, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(793, 74, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(794, 83, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(795, 81, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(796, 127, 'contribution_deduction', 15000.00, 45000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(797, 60, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(798, 142, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(799, 59, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(800, 128, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(801, 143, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(802, 144, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(803, 129, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(804, 130, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(805, 44, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(806, 145, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(807, 96, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(808, 146, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(809, 131, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(810, 132, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(811, 147, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(812, 75, 'contribution_deduction', 7000.00, 77000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(813, 110, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(814, 97, 'contribution_deduction', 10000.00, 85000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(815, 133, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(816, 86, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(817, 98, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(818, 148, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(819, 70, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(820, 149, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(821, 53, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20');
INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(822, 79, 'contribution_deduction', 10000.00, 105000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(823, 99, 'contribution_deduction', 5000.00, 45000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(824, 69, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(825, 47, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(826, 78, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(827, 76, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(828, 87, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(829, 134, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(830, 135, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(831, 136, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(832, 80, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(833, 67, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(834, 100, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-11', 'Monthly contribution for 2026-04', 2, '2026-10-03 15:10:20', 11, NULL, NULL, '2026-10-03 15:10:20', '2026-10-03 15:10:20'),
(835, 159, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100184', 'Opening balance migrated from manual records', 2, '2026-10-03 15:11:43', NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(836, 160, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100981', 'Opening balance migrated from manual records', 2, '2026-10-03 15:11:43', NULL, NULL, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(837, 161, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100928', 'Opening balance migrated from manual records', 2, '2026-10-03 15:11:44', NULL, NULL, NULL, '2026-10-03 15:11:44', '2026-10-03 15:11:44'),
(838, 162, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE100692', 'Opening balance migrated from manual records', 2, '2026-10-03 15:11:45', NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(839, 163, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE101138', 'Opening balance migrated from manual records', 2, '2026-10-03 15:11:45', NULL, NULL, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(840, 88, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(841, 111, 'contribution_deduction', 50000.00, 200000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(842, 137, 'contribution_deduction', 30000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(843, 89, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(844, 112, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(845, 64, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(846, 46, 'contribution_deduction', 40000.00, 480000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(847, 68, 'contribution_deduction', 100000.00, 780000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(848, 113, 'contribution_deduction', 40000.00, 160000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(849, 150, 'contribution_deduction', 20000.00, 50000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(850, 85, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(851, 62, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(852, 138, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(853, 54, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(854, 45, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(855, 114, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(856, 61, 'contribution_deduction', 50000.00, 600000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(857, 71, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(858, 101, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(859, 115, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(860, 82, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(861, 116, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(862, 117, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(863, 109, 'contribution_deduction', 50000.00, 350000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(864, 48, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(865, 56, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(866, 118, 'contribution_deduction', 100000.00, 400000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(867, 119, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(868, 63, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(869, 57, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(870, 90, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(871, 120, 'contribution_deduction', 60000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(872, 52, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(873, 91, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(874, 121, 'contribution_deduction', 50000.00, 200000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(875, 122, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(876, 151, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(877, 103, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(878, 139, 'contribution_deduction', 25000.00, 75000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(879, 123, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(880, 58, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(881, 152, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(882, 65, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(883, 140, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(884, 77, 'contribution_deduction', 15000.00, 180000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(885, 92, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(886, 125, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(887, 104, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(888, 51, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(889, 153, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(890, 105, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(891, 126, 'contribution_deduction', 60000.00, 160000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(892, 43, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(893, 106, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(894, 93, 'contribution_deduction', 30000.00, 300000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(895, 84, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(896, 49, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(897, 94, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(898, 72, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(899, 50, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(900, 107, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(901, 154, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(902, 108, 'contribution_deduction', 15000.00, 110000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(903, 73, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(904, 55, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(905, 95, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(906, 74, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(907, 155, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(908, 83, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(909, 81, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(910, 127, 'contribution_deduction', 15000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(911, 60, 'contribution_deduction', 10000.00, 170000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(912, 142, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(913, 59, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(914, 128, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(915, 143, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(916, 156, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(917, 144, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(918, 129, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(919, 130, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(920, 44, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(921, 145, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(922, 96, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(923, 146, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(924, 131, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(925, 132, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(926, 147, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(927, 75, 'contribution_deduction', 7000.00, 84000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(928, 157, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(929, 110, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(930, 97, 'contribution_deduction', 10000.00, 95000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(931, 133, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(932, 86, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(933, 98, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(934, 148, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(935, 70, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(936, 149, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(937, 53, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(938, 79, 'contribution_deduction', 30000.00, 135000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(939, 99, 'contribution_deduction', 5000.00, 50000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(940, 69, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(941, 47, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(942, 78, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(943, 76, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(944, 87, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(945, 134, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(946, 135, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(947, 136, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(948, 67, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(949, 158, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-12', 'Monthly contribution for 2026-05', 2, '2026-10-03 15:12:24', 12, NULL, NULL, '2026-10-03 15:12:24', '2026-10-03 15:12:24'),
(950, 88, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(951, 111, 'contribution_deduction', 50000.00, 250000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(952, 137, 'contribution_deduction', 30000.00, 120000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(953, 89, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(954, 112, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(955, 64, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(956, 46, 'contribution_deduction', 40000.00, 520000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(957, 68, 'contribution_deduction', 100000.00, 880000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(958, 113, 'contribution_deduction', 40000.00, 200000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(959, 150, 'contribution_deduction', 20000.00, 70000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(960, 85, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(961, 62, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(962, 138, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(963, 54, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(964, 45, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(965, 114, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(966, 159, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(967, 61, 'contribution_deduction', 50000.00, 650000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(968, 71, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(969, 101, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(970, 115, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(971, 82, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(972, 116, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(973, 117, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(974, 109, 'contribution_deduction', 50000.00, 400000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(975, 48, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(976, 56, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(977, 118, 'contribution_deduction', 100000.00, 500000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(978, 119, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(979, 63, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(980, 57, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(981, 90, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(982, 120, 'contribution_deduction', 60000.00, 300000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(983, 160, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(984, 52, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(985, 91, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(986, 121, 'contribution_deduction', 50000.00, 250000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(987, 122, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(988, 151, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(989, 103, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(990, 139, 'contribution_deduction', 25000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(991, 123, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(992, 58, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(993, 152, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(994, 65, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(995, 140, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(996, 77, 'contribution_deduction', 15000.00, 195000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(997, 92, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(998, 125, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(999, 104, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1000, 51, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1001, 153, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1002, 105, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1003, 126, 'contribution_deduction', 20000.00, 180000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1004, 161, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1005, 43, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1006, 106, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1007, 93, 'contribution_deduction', 30000.00, 330000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1008, 84, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1009, 49, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1010, 94, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1011, 72, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1012, 50, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1013, 107, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1014, 162, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1015, 154, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1016, 108, 'contribution_deduction', 15000.00, 125000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1017, 73, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1018, 55, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1019, 95, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1020, 74, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1021, 155, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1022, 83, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1023, 81, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1024, 127, 'contribution_deduction', 15000.00, 75000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1025, 60, 'contribution_deduction', 10000.00, 180000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1026, 142, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1027, 59, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1028, 128, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1029, 143, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1030, 156, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1031, 144, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1032, 129, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1033, 130, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1034, 44, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1035, 145, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1036, 163, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1037, 96, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1038, 146, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1039, 131, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1040, 132, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1041, 147, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1042, 75, 'contribution_deduction', 7000.00, 91000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1043, 157, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1044, 110, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1045, 97, 'contribution_deduction', 10000.00, 105000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1046, 133, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1047, 86, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1048, 98, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1049, 148, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1050, 70, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1051, 149, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1052, 53, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1053, 79, 'contribution_deduction', 30000.00, 165000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1054, 99, 'contribution_deduction', 5000.00, 55000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1055, 69, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1056, 47, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1057, 78, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1058, 76, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1059, 87, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1060, 134, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1061, 135, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1062, 136, 'contribution_deduction', 4000.00, 24000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1063, 67, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1064, 158, 'contribution_deduction', 5000.00, 15000.00, 'BATCH-13', 'Monthly contribution for 2026-06', 2, '2026-10-03 15:13:09', 13, NULL, NULL, '2026-10-03 15:13:09', '2026-10-03 15:13:09'),
(1065, 88, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1066, 111, 'contribution_deduction', 50000.00, 300000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1067, 137, 'contribution_deduction', 30000.00, 150000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1068, 89, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1069, 112, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1070, 64, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1071, 46, 'contribution_deduction', 40000.00, 560000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1072, 68, 'contribution_deduction', 100000.00, 980000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1073, 113, 'contribution_deduction', 40000.00, 240000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1074, 150, 'contribution_deduction', 20000.00, 90000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1075, 85, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1076, 62, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1077, 138, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1078, 54, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1079, 45, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02');
INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(1080, 114, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1081, 159, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1082, 61, 'contribution_deduction', 50000.00, 700000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1083, 71, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1084, 101, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1085, 115, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1086, 82, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1087, 116, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1088, 117, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1089, 109, 'contribution_deduction', 50000.00, 450000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1090, 48, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1091, 56, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1092, 118, 'contribution_deduction', 100000.00, 600000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1093, 119, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1094, 63, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1095, 57, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1096, 90, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1097, 120, 'contribution_deduction', 60000.00, 360000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1098, 160, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1099, 52, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1100, 91, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1101, 121, 'contribution_deduction', 50000.00, 300000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1102, 122, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1103, 151, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1104, 103, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1105, 139, 'contribution_deduction', 25000.00, 125000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1106, 123, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1107, 58, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1108, 152, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1109, 65, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1110, 140, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1111, 77, 'contribution_deduction', 15000.00, 210000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1112, 92, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1113, 125, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1114, 104, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1115, 51, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1116, 153, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1117, 105, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1118, 126, 'contribution_deduction', 20000.00, 200000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1119, 161, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1120, 43, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1121, 106, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1122, 93, 'contribution_deduction', 30000.00, 360000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1123, 84, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1124, 49, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1125, 94, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1126, 72, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1127, 50, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1128, 107, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1129, 162, 'contribution_deduction', 20000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1130, 154, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1131, 108, 'contribution_deduction', 15000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1132, 73, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1133, 55, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1134, 95, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1135, 74, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1136, 155, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1137, 83, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1138, 81, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1139, 127, 'contribution_deduction', 15000.00, 90000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1140, 60, 'contribution_deduction', 10000.00, 190000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1141, 142, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1142, 59, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1143, 128, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1144, 143, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1145, 156, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1146, 144, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1147, 129, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1148, 130, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1149, 44, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1150, 145, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1151, 163, 'contribution_deduction', 10000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1152, 96, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1153, 146, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1154, 131, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1155, 132, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1156, 147, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1157, 75, 'contribution_deduction', 7000.00, 98000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1158, 157, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1159, 110, 'contribution_deduction', 10000.00, 90000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1160, 97, 'contribution_deduction', 10000.00, 115000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1161, 133, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1162, 86, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1163, 98, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1164, 148, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1165, 70, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1166, 149, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1167, 53, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1168, 79, 'contribution_deduction', 30000.00, 195000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1169, 99, 'contribution_deduction', 5000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1170, 69, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1171, 47, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1172, 78, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1173, 76, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1174, 87, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1175, 134, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1176, 135, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1177, 136, 'contribution_deduction', 4000.00, 28000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1178, 67, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1179, 158, 'contribution_deduction', 5000.00, 20000.00, 'BATCH-14', 'Monthly contribution for 2026-07', 2, '2026-10-03 15:14:02', 14, NULL, NULL, '2026-10-03 15:14:02', '2026-10-03 15:14:02'),
(1180, 164, 'opening_balance', 150000.00, 150000.00, 'IMPORT-FCE100625', 'Opening balance migrated from manual records', 2, '2026-10-03 15:15:57', NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(1181, 165, 'opening_balance', 20000.00, 20000.00, 'IMPORT-FCE200019', 'Opening balance migrated from manual records', 2, '2026-10-03 15:15:57', NULL, NULL, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(1182, 166, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE101092', 'Opening balance migrated from manual records', 2, '2026-10-03 15:15:58', NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(1183, 167, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100722', 'Opening balance migrated from manual records', 2, '2026-10-03 15:15:58', NULL, NULL, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(1184, 168, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100624', 'Opening balance migrated from manual records', 2, '2026-10-03 15:15:59', NULL, NULL, NULL, '2026-10-03 15:15:59', '2026-10-03 15:15:59'),
(1185, 88, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1186, 111, 'contribution_deduction', 50000.00, 350000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1187, 137, 'contribution_deduction', 30000.00, 180000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1188, 89, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1189, 112, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1190, 64, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1191, 46, 'contribution_deduction', 40000.00, 600000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1192, 68, 'contribution_deduction', 100000.00, 1080000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1193, 113, 'contribution_deduction', 40000.00, 280000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1194, 150, 'contribution_deduction', 20000.00, 110000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1195, 85, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1196, 62, 'contribution_deduction', 30000.00, 450000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1197, 138, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1198, 54, 'contribution_deduction', 30000.00, 450000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1199, 45, 'contribution_deduction', 30000.00, 450000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1200, 114, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1201, 159, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1202, 61, 'contribution_deduction', 50000.00, 750000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1203, 71, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1204, 101, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1205, 115, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1206, 82, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1207, 116, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1208, 117, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1209, 109, 'contribution_deduction', 50000.00, 500000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1210, 48, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1211, 56, 'contribution_deduction', 30000.00, 450000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1212, 118, 'contribution_deduction', 100000.00, 700000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1213, 119, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1214, 63, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1215, 57, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1216, 90, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1217, 120, 'contribution_deduction', 60000.00, 420000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1218, 160, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1219, 52, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1220, 91, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1221, 121, 'contribution_deduction', 100000.00, 400000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1222, 122, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1223, 151, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1224, 103, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1225, 139, 'contribution_deduction', 25000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1226, 123, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:21', 15, NULL, NULL, '2026-10-03 15:18:21', '2026-10-03 15:18:21'),
(1227, 58, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1228, 152, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1229, 65, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1230, 140, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1231, 77, 'contribution_deduction', 15000.00, 225000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1232, 92, 'contribution_deduction', 20000.00, 260000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1233, 125, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1234, 104, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1235, 153, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1236, 105, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1237, 126, 'contribution_deduction', 20000.00, 220000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1238, 161, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1239, 43, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1240, 106, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1241, 93, 'contribution_deduction', 30000.00, 390000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1242, 84, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1243, 49, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1244, 94, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1245, 72, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1246, 50, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1247, 107, 'contribution_deduction', 10000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1248, 162, 'contribution_deduction', 20000.00, 80000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1249, 154, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1250, 108, 'contribution_deduction', 15000.00, 155000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1251, 73, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1252, 55, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1253, 95, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1254, 74, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1255, 155, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1256, 83, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1257, 81, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1258, 127, 'contribution_deduction', 15000.00, 105000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1259, 60, 'contribution_deduction', 10000.00, 200000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1260, 142, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1261, 59, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1262, 128, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1263, 143, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1264, 156, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1265, 144, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1266, 129, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1267, 130, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1268, 44, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1269, 145, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1270, 163, 'contribution_deduction', 10000.00, 40000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1271, 96, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1272, 146, 'contribution_deduction', 20000.00, 120000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1273, 131, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1274, 132, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1275, 147, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1276, 75, 'contribution_deduction', 7000.00, 105000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1277, 157, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1278, 110, 'contribution_deduction', 10000.00, 100000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1279, 97, 'contribution_deduction', 10000.00, 125000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1280, 133, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1281, 86, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1282, 98, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1283, 148, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1284, 70, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1285, 149, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1286, 53, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1287, 79, 'contribution_deduction', 30000.00, 225000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1288, 99, 'contribution_deduction', 5000.00, 65000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1289, 69, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1290, 47, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1291, 78, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1292, 76, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1293, 87, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1294, 134, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1295, 135, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1296, 136, 'contribution_deduction', 4000.00, 32000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1297, 67, 'contribution_deduction', 10000.00, 150000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1298, 158, 'contribution_deduction', 5000.00, 25000.00, 'BATCH-15', 'Monthly contribution for 2026-08', 2, '2026-10-03 15:18:22', 15, NULL, NULL, '2026-10-03 15:18:22', '2026-10-03 15:18:22'),
(1299, 169, 'opening_balance', 10000.00, 10000.00, 'IMPORT-FCE100292', 'Opening balance migrated from manual records', 2, '2026-10-03 15:19:35', NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(1300, 170, 'opening_balance', 5000.00, 5000.00, 'IMPORT-FCE100964', 'Opening balance migrated from manual records', 2, '2026-10-03 15:19:35', NULL, NULL, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(1301, 88, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1302, 111, 'contribution_deduction', 50000.00, 400000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1303, 137, 'contribution_deduction', 100000.00, 280000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1304, 89, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1305, 112, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1306, 46, 'contribution_deduction', 40000.00, 640000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1307, 68, 'contribution_deduction', 100000.00, 1180000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1308, 113, 'contribution_deduction', 40000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1309, 150, 'contribution_deduction', 20000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1310, 85, 'contribution_deduction', 20000.00, 300000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1311, 164, 'contribution_deduction', 150000.00, 300000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1312, 62, 'contribution_deduction', 30000.00, 480000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1313, 138, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1314, 54, 'contribution_deduction', 30000.00, 480000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1315, 45, 'contribution_deduction', 30000.00, 480000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1316, 114, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1317, 159, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1318, 61, 'contribution_deduction', 50000.00, 800000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1319, 71, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1320, 101, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1321, 115, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1322, 82, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1323, 116, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1324, 117, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1325, 109, 'contribution_deduction', 50000.00, 550000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1326, 48, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1327, 56, 'contribution_deduction', 30000.00, 480000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1328, 118, 'contribution_deduction', 100000.00, 800000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1329, 119, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1330, 63, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1331, 57, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1332, 90, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1333, 120, 'contribution_deduction', 60000.00, 480000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1334, 160, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1335, 52, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1336, 121, 'contribution_deduction', 100000.00, 500000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06');
INSERT INTO `savings_transactions` (`id`, `savings_account_id`, `type`, `amount`, `balance_after`, `reference`, `description`, `posted_by`, `posted_at`, `source_batch_id`, `withdrawal_request_id`, `reversed_transaction_id`, `created_at`, `updated_at`) VALUES
(1337, 122, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1338, 151, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1339, 103, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1340, 139, 'contribution_deduction', 25000.00, 175000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1341, 123, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1342, 58, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1343, 152, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1344, 65, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1345, 140, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1346, 77, 'contribution_deduction', 15000.00, 240000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1347, 92, 'contribution_deduction', 20000.00, 280000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1348, 125, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1349, 104, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1350, 153, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1351, 105, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1352, 126, 'contribution_deduction', 20000.00, 240000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1353, 161, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1354, 43, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1355, 106, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1356, 93, 'contribution_deduction', 30000.00, 420000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1357, 84, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1358, 49, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1359, 94, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1360, 165, 'contribution_deduction', 20000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1361, 72, 'contribution_deduction', 5000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1362, 50, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1363, 107, 'contribution_deduction', 10000.00, 130000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1364, 162, 'contribution_deduction', 20000.00, 100000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1365, 154, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1366, 108, 'contribution_deduction', 15000.00, 170000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1367, 73, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1368, 166, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1369, 55, 'contribution_deduction', 5000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1370, 95, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1371, 74, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1372, 155, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1373, 83, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1374, 167, 'contribution_deduction', 5000.00, 10000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1375, 81, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1376, 127, 'contribution_deduction', 15000.00, 120000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1377, 60, 'contribution_deduction', 10000.00, 210000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1378, 142, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1379, 59, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1380, 128, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1381, 143, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1382, 156, 'contribution_deduction', 10000.00, 60000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1383, 144, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1384, 129, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1385, 130, 'contribution_deduction', 20000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1386, 44, 'contribution_deduction', 20000.00, 320000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1387, 145, 'contribution_deduction', 5000.00, 35000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1388, 163, 'contribution_deduction', 10000.00, 50000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1389, 96, 'contribution_deduction', 10000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1390, 146, 'contribution_deduction', 20000.00, 140000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1391, 168, 'contribution_deduction', 10000.00, 20000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1392, 131, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1393, 132, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1394, 147, 'contribution_deduction', 10000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1395, 75, 'contribution_deduction', 7000.00, 112000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1396, 157, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1397, 110, 'contribution_deduction', 10000.00, 110000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1398, 97, 'contribution_deduction', 10000.00, 135000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1399, 133, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1400, 86, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1401, 98, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1402, 148, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1403, 70, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1404, 149, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1405, 53, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1406, 79, 'contribution_deduction', 30000.00, 255000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1407, 99, 'contribution_deduction', 5000.00, 70000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1408, 69, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1409, 47, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1410, 78, 'contribution_deduction', 5000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1411, 76, 'contribution_deduction', 5000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1412, 87, 'contribution_deduction', 5000.00, 75000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1413, 134, 'contribution_deduction', 10000.00, 80000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1414, 135, 'contribution_deduction', 5000.00, 40000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1415, 136, 'contribution_deduction', 4000.00, 36000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1416, 67, 'contribution_deduction', 10000.00, 160000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06'),
(1417, 158, 'contribution_deduction', 5000.00, 30000.00, 'BATCH-16', 'Monthly contribution for 2026-09', 2, '2026-10-03 15:20:06', 16, NULL, NULL, '2026-10-03 15:20:06', '2026-10-03 15:20:06');

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
('SeGKyI7yTa6BEBiKnrjigdRL952Rq6gqWICjGB5y', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36 Edg/154.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVdMMGVBSnBCWlJ2REFhcktETGJDdmFubzJmdzdrN0pGTnNWMFk1ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzL3NhdmluZ3MiO3M6NToicm91dGUiO3M6MTU6InJlcG9ydHMuc2F2aW5ncyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1791044415);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'dormancy_months', '6', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(2, 'minimum_monthly_contribution', '5000', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(3, 'application_form_fee', '5000', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(4, 'application_fee_admin_pct', '20', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(5, 'application_fee_profit_pct', '80', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(6, 'minimum_share_holding', '5', '2026-10-03 12:46:15', '2026-10-03 12:46:15'),
(7, 'dividend_fy_start_month', '1', '2026-10-03 12:46:15', '2026-10-03 12:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `share_accounts`
--

CREATE TABLE `share_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `total_shares` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `opened_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_price_history`
--

CREATE TABLE `share_price_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_price` decimal(14,2) NOT NULL,
  `effective_from` date NOT NULL,
  `set_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `share_price_history`
--

INSERT INTO `share_price_history` (`id`, `unit_price`, `effective_from`, `set_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1000.00, '2026-10-03', NULL, 1, '2026-10-03 12:46:16', '2026-10-03 12:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `share_purchase_intents`
--

CREATE TABLE `share_purchase_intents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `share_account_id` bigint(20) UNSIGNED NOT NULL,
  `shares_requested` int(10) UNSIGNED NOT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `decline_reason` text DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_transactions`
--

CREATE TABLE `share_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `share_account_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `shares_delta` int(11) NOT NULL,
  `unit_price_applied` decimal(14,2) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `shares_after` int(10) UNSIGNED NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `source_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `withdrawal_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reversed_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_withdrawal_requests`
--

CREATE TABLE `share_withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `share_account_id` bigint(20) UNSIGNED NOT NULL,
  `shares_requested` int(10) UNSIGNED NOT NULL,
  `shares_approved` int(10) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `treasurer_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurer_reviewed_at` timestamp NULL DEFAULT NULL,
  `treasurer_note` text DEFAULT NULL,
  `chairman_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_reviewed_at` timestamp NULL DEFAULT NULL,
  `chairman_note` text DEFAULT NULL,
  `disbursed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_at` timestamp NULL DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_no` varchar(255) NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `raised_by` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `is_confidential` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `resolved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `must_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `must_change_password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$KwgcAfeKg6Xs6sAGGMPOE.SuMThjg594LHM5i0Z4/W89lf6axaaWC', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:09:11'),
(2, 'Treasurer', 'treasurer@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$Vl.2zi/obQhAU9zltDz3guI11WOV8obqWJ90qcIpcxW3zgmIr5psy', 0, NULL, '2026-10-02 16:05:37', '2026-10-03 12:33:26'),
(3, 'Chairman', 'chairman@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$JYIpLvCRtAseqAd8ubbQb.pVrmCZeRaHxJdhMfy.1RSAmWQgZO/R.', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:14:40'),
(4, 'Secretary', 'secretary@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$SdfPRXHo.T2vd5LErRmOMOR5FsP3EjX2NN9EcF6z7MTwe.qNBZcxe', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:16:27'),
(5, 'Store Officer', 'store.officer@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$38Sk9N.dPydeIvhd.DXKZuQhZFepYcxZo1bDEpgUy8sesIe6/HeEG', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:18:08'),
(6, 'Auditor', 'auditor@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$Kv7GCwUxdbePcsuh4qCbxuhoTiHi1FkJcF9VzYpTUZHwdoWCXs9VO', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:19:35'),
(7, 'Exco Member', 'exco@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$u0asQu7ieDS4hv4U/yuPIulaAp6WTr9Ey7lY4U2U0qa8Z0/YymANu', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:20:56'),
(8, 'Loan Officer', 'loan.officer@fcetpotiskum.com.ng', '2026-10-02 16:05:37', '$2y$12$uqiz4hIMfQAPIYEFPHfz.ud/rkGcsvE/zXpKKvI5.i9tCficcO5D6', 0, NULL, '2026-10-02 16:05:37', '2026-10-02 15:22:18'),
(9, 'MAMUDA ABDULLAHI', 'fce100192@no-email.fcetpcoop.local', NULL, '$2y$12$ucnGJF9Ok7xfvj9o/O3PdeEQQ7DEuy8kMxkc4EX5AbgtXP5IKG0Ja', 1, NULL, '2026-10-03 11:32:08', '2026-10-03 11:32:08'),
(10, 'ADAM UMAR ABBA', 'director@mailinator.com', NULL, '$2y$12$l2a/MafEgHvthpwT2GxQNe2KfPM9xTOPgct4KiO2XG8kICM92/c5O', 0, NULL, '2026-10-03 11:32:09', '2026-10-03 11:34:33'),
(11, 'MOHAMMED MOHAMMED ARDO', 'fce100713@no-email.fcetpcoop.local', NULL, '$2y$12$IbmWr/UIwA7PKaeVh.evxuhZtnfVM488MIXeM5IQ0XUbi8dGSCCua', 1, NULL, '2026-10-03 11:32:09', '2026-10-03 11:32:09'),
(12, 'JIBRIN HASHIMU GUNDA', 'fce100778@no-email.fcetpcoop.local', NULL, '$2y$12$0Tox6GcNWTrBbYP.5JmZ2ubFn9oLIv6t.0Pp0WfNu3KW6PXsqaHsG', 1, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(13, 'DALA ADAMU GARBA', 'fce100887@no-email.fcetpcoop.local', NULL, '$2y$12$MWbriApWtcJbgpb/Oal1w.puHVMbT0x0/RLpAKrp6FHglwPsizVoW', 1, NULL, '2026-10-03 11:32:10', '2026-10-03 11:32:10'),
(14, 'ABUBAKAR SAIDU ALHASSAN', 'fce100182@no-email.fcetpcoop.local', NULL, '$2y$12$WWfQC5gDZbB9FfAwlPj5MOUYf7aHgnTP3ZbBJe0qMzQYrzt1O66Pq', 1, NULL, '2026-10-03 11:32:11', '2026-10-03 11:32:11'),
(15, 'ILIYASU MUSA YUSUF', 'fce100733@no-email.fcetpcoop.local', NULL, '$2y$12$iH5OVzMOwn/lCgMs6sZ4/.T4KaqYf7PFeAZoDJIfuZgQqvYADJaYi', 1, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(16, 'MUNTARI SAAD', 'fce100726@no-email.fcetpcoop.local', NULL, '$2y$12$ZCSfA/gcPtnSKx8BWZDfkOi5MtAznUypGpFeC1roYzA3kXxYMLMcS', 1, NULL, '2026-10-03 11:32:12', '2026-10-03 11:32:12'),
(17, 'WAKILI BALA ADAMU', 'fce100832@no-email.fcetpcoop.local', NULL, '$2y$12$87fkq47f2KRDk8kYTboeuufmTfp25FOIRJxON/oX0QaMJyd1XO5qy', 1, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(18, 'BABA AJIYA IDRISSA', 'fce100843@no-email.fcetpcoop.local', NULL, '$2y$12$r5cPBziTDwu8wW2OU4PcK.ih2PPBgJAqF/I1fp92XC4j.MWWtXcYK', 1, NULL, '2026-10-03 11:32:13', '2026-10-03 11:32:13'),
(19, 'GHULUZE MUHAMMAD IBN', 'fce100861@no-email.fcetpcoop.local', NULL, '$2y$12$qEvElB9NGcqofXIUHmXOCuq3Z2WJa.i812b9lmKQLRFeOV1S8YWDe', 1, NULL, '2026-10-03 11:32:14', '2026-10-03 11:32:14'),
(20, 'LUCCU AJIYA MAINA', 'fce100782@no-email.fcetpcoop.local', NULL, '$2y$12$8m3tmasR6zXV4sgf.zH57uawQviPxU7hv31zQ2ZoyLkE1vJckbXAa', 1, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(21, 'GIMBA ISMAILA MOHAMMED', 'fce100851@no-email.fcetpcoop.local', NULL, '$2y$12$B9zdFnwnlVua6NQA/IPRy.Oe5D/8ru2XBmOiAokz5MHYSJ/ZmvoFq', 1, NULL, '2026-10-03 11:32:15', '2026-10-03 11:32:15'),
(22, 'BAWAJI HAUWA ABDU', 'fce100215@no-email.fcetpcoop.local', NULL, '$2y$12$I9xG6NKdMstdR5j2D.pNDO0GrpH/rtc/Yo33HZJfRJEfXsU4fqnsW', 1, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(23, 'MIDALA ZAKARIYAU HARUNA', 'fce100913@no-email.fcetpcoop.local', NULL, '$2y$12$PoObTfGceX3pfhUp0LQF2eeibaDZuzIYf/gGS/ZQgFNZSi8kBW1Lu', 1, NULL, '2026-10-03 11:32:16', '2026-10-03 11:32:16'),
(24, 'HAMZA SULEIMAN', 'fce101060@no-email.fcetpcoop.local', NULL, '$2y$12$7IRbIAw5RP0hp0wLpEisgu55wzD6NsCxDiKJNZNh9186wXycvE1Du', 1, NULL, '2026-10-03 11:32:17', '2026-10-03 11:32:17'),
(25, 'MANGA MUSA', 'fce200056@no-email.fcetpcoop.local', NULL, '$2y$12$IFsJzm5Rv/bLzgNvrD8zEe3ZZVy4eU0ADBkBzUGyOumerfW9zEkR6', 1, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(26, 'SHAMAKI AYUBA YAKUBU', 'fce100737@no-email.fcetpcoop.local', NULL, '$2y$12$PqLAm2ViAp46QiPdokUEr.o72QvdmsNmEdZkt5L/Sf7Nf.1IQ70zi', 1, NULL, '2026-10-03 11:32:18', '2026-10-03 11:32:18'),
(27, 'BARDE IDRISS IBRAHIM', 'fce100731@no-email.fcetpcoop.local', NULL, '$2y$12$MYJ3S0TwW9oTfXhe6JKsXOGyf53qVwQQCrlij0rxiSxTGhR/EWOxW', 1, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(28, 'ABDULKADIR ABDULKARIM OLATUNJI', 'fce101191@no-email.fcetpcoop.local', NULL, '$2y$12$EoGwlrZSvP05HZtabEVus.JF3yTx9nm.RqN/rOT5xOYSdFId5b6XK', 1, NULL, '2026-10-03 11:32:19', '2026-10-03 11:32:19'),
(29, 'YERIMA MUSA MAMMAN', 'fce1001017@no-email.fcetpcoop.local', NULL, '$2y$12$kGsEaB4gXQ1Vl4SXo.5iJOrtpv28VCqT9VleIHQjgtIAYxYhqlr9.', 1, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(30, 'BADAWI MUHAMMAD HASSAN', 'fce101020@no-email.fcetpcoop.local', NULL, '$2y$12$.zXTkXPFX38t0dTiS5Bhk.r642Mk6ps/ujhwi4rvpuQbBv4A91RQ6', 1, NULL, '2026-10-03 11:32:20', '2026-10-03 11:32:20'),
(31, 'MUSA ABUBAKAR', 'fce101085@no-email.fcetpcoop.local', NULL, '$2y$12$huXaxWyCrTkTrnJMtsVVaOA57feY2OiX..BpNcsGcQQkkPzPt74BK', 1, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(32, 'BAH UMAR M', 'fce100380@no-email.fcetpcoop.local', NULL, '$2y$12$HJDYJvoy6hRBh6xwQsPGpeOy3MXrhoeK68cVwpRCXxGo/oWiWS2gC', 1, NULL, '2026-10-03 11:32:21', '2026-10-03 11:32:21'),
(33, 'MUSA SAADATU MIRINGA', 'fce200042@no-email.fcetpcoop.local', NULL, '$2y$12$lAwQ0NRE622l3i5niWSVNeFSQJgfH0AouqrBvuvvT50BDOZDTTt2.', 1, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(34, 'GEIDAM HADIZA BABA', 'fce100736@no-email.fcetpcoop.local', NULL, '$2y$12$UYWkJ6VH.Rta9hCTH7UJvugyKW3RruwdTKv.JzUWWMlSsIoLT3zT6', 1, NULL, '2026-10-03 11:32:22', '2026-10-03 11:32:22'),
(35, 'NWARE HARUNA IDRIS', 'fce100514@no-email.fcetpcoop.local', NULL, '$2y$12$i3L4gDWI7z5faZRAZDN1gOA0rYsVnbq8w/ovYgZOcCLkb17cx6fTO', 1, NULL, '2026-10-03 11:32:23', '2026-10-03 11:32:23'),
(36, 'YAMARKUMI AHMAD MUHAMMAD', 'fce101139@no-email.fcetpcoop.local', NULL, '$2y$12$.TlIJFPWyWgFwGInfAZUtuSqRrYhcVrVnfvLEmmGkV.p6I3b9xbza', 1, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(37, 'USMAN IBRAHIM GOJI', 'fce100709@no-email.fcetpcoop.local', NULL, '$2y$12$vta5voWvnNr67ZzbKDx/xeYNHL46rxl7QmqT.aZc2JYq9PuSVESEa', 1, NULL, '2026-10-03 11:32:24', '2026-10-03 11:32:24'),
(38, 'HUSSAINI ISHIYAKU', 'fce101232@no-email.fcetpcoop.local', NULL, '$2y$12$6RieLGgvko4.QEhRk8Bz/.YQNegqQyT9egLQ8n2LspQute5byCZLO', 1, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(39, 'HARUNA ALIYU', 'fce101235@no-email.fcetpcoop.local', NULL, '$2y$12$Vy3J/6gVNK/JK3B8vZJOKO2ILvJ9Wzt0Qk3H7QgtVzHzj.CaETr2C', 1, NULL, '2026-10-03 11:32:25', '2026-10-03 11:32:25'),
(40, 'ABUBAKAR MOHAMMED BOJUDE', 'fce101244@no-email.fcetpcoop.local', NULL, '$2y$12$elKO64EtXxg.8l9fGeun6ekvhZTERFd0BngUgkFB8pqkIY/dniLNq', 1, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(41, 'RABIU YAHUZA GARBA', 'fce101228@no-email.fcetpcoop.local', NULL, '$2y$12$y8j1LycIZi4i4gbThpZC.enfIYFfOWgof0L2ZEzsot7CwM4TPjcLe', 1, NULL, '2026-10-03 11:32:26', '2026-10-03 11:32:26'),
(42, 'MUHAMMAD BINTA MUSA', 'fce101387@no-email.fcetpcoop.local', NULL, '$2y$12$e7p51hNepkjGhSoSQYhwnuFToRt8NNgpK5xfuP3saA6ni5q/Dgd3W', 1, NULL, '2026-10-03 11:32:27', '2026-10-03 11:32:27'),
(43, 'CHIBOK HAUWA WAKIL', 'fce200065@no-email.fcetpcoop.local', NULL, '$2y$12$L9CYJwfMgpFniLzZhWcZhuivayN4Z5e/WqpcZE5HnCzSlNJ1cU.FK', 1, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(44, 'SULEIMAN ABUBAKAR', 'fce200067@no-email.fcetpcoop.local', NULL, '$2y$12$qCOt4OLzr4hxFGw0.UDwe.zT7R/t4PZqF7qF7ti44UNi059o7SXWu', 1, NULL, '2026-10-03 11:32:28', '2026-10-03 11:32:28'),
(45, 'MOHAMMED SALEH', 'fce101041@no-email.fcetpcoop.local', NULL, '$2y$12$GKcdbcr5n6rrwOOQpSQKbeUt0.2DUaDiON9oH./tn2M4al5cV9ePi', 1, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(46, 'ADAMU UMAR KWAMI', 'fce1001043@no-email.fcetpcoop.local', NULL, '$2y$12$tuCyaj2CXMqsKwYyC/osqeT4eEzwsePaFvK/q6gvOxTai/ZgEHhpq', 1, NULL, '2026-10-03 11:32:29', '2026-10-03 11:32:29'),
(47, 'SHETTIMA ALHAJI SHEHU', 'fce100720@no-email.fcetpcoop.local', NULL, '$2y$12$0YWZd.wVZyCKwN771Xqsi.MUMMXcVvGZYdzrZ3n3Dmz0Mm02rKsTq', 1, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(48, 'SAFIYANU GARBA', 'fce1001024@no-email.fcetpcoop.local', NULL, '$2y$12$nrRgJzpGKi0ikmAk2zXQoOVy7G9AhSMv8uinrj3oO9BiyOIYkAc9m', 1, NULL, '2026-10-03 11:32:30', '2026-10-03 11:32:30'),
(49, 'TONTI ALIYU MOHAMMED', 'fce101061@no-email.fcetpcoop.local', NULL, '$2y$12$4UCJtOqIEXYqlYhWHgnPKeqFtKvLGv32BTWidkYImbisipb2eOBdW', 1, NULL, '2026-10-03 11:32:31', '2026-10-03 11:32:31'),
(50, 'MOHAMMED AHMED GIDADO', 'fce101208@no-email.fcetpcoop.local', NULL, '$2y$12$/cqYbHWrXkaz8vb7IlGR/OJgtu0A3bhro35.MBD6.IvgGS5HRiCD2', 1, NULL, '2026-10-03 11:32:32', '2026-10-03 11:32:32'),
(51, 'MOHAMMED ABUBAKAR', 'fce100205@no-email.fcetpcoop.local', NULL, '$2y$12$n.qzGKUy2L9yub7zfSWU6OBtpWHQasucTWDgPZp4KLNkWyPjWsQlG', 1, NULL, '2026-10-03 14:24:46', '2026-10-03 14:24:46'),
(52, 'BASHIR HASHIMU', 'fce101215@no-email.fcetpcoop.local', NULL, '$2y$12$R1ceUSNCFpAYgXQ5gz7cJ.P5HbmWs.zrZQIz46jo.5R91lF/nADGK', 1, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(53, 'MOHAMMED IBRAHIM', 'fce101268@no-email.fcetpcoop.local', NULL, '$2y$12$Ie.imol9WgzhYpslAUopceygCqTO8qyo1DxIoPUv1IGglpSwRNSj2', 1, NULL, '2026-10-03 14:24:47', '2026-10-03 14:24:47'),
(54, 'DR YUNUSA MOHAMMED MADU', 'fce100141@no-email.fcetpcoop.local', NULL, '$2y$12$BP1hVK4reUqp8wFqrxgmNO1HVlqewv/0iv7RrD9/w3Zih223r82q2', 1, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(55, 'MUHAMMAD HASSAN NDAMAN', 'fce100080@no-email.fcetpcoop.local', NULL, '$2y$12$pIGxKBRhDr1dbTAFwKrxleFai1ffU75eXMgKbmNI1crEXxTebASa6', 1, NULL, '2026-10-03 14:28:23', '2026-10-03 14:28:23'),
(56, 'YAU IBRAHIM', 'fce100870@no-email.fcetpcoop.local', NULL, '$2y$12$Zqt4DLnTjKqGbwJF8BPFxuIoouDD9uk1EhO.cdHprOhlkZLGYEqG2', 1, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(57, 'FAROUK MARYAM UMAR', 'fce100337@no-email.fcetpcoop.local', NULL, '$2y$12$920roVWkhf2AZBuf68tNVeNO28Q0d9LV90E8WwaUFOx0eKnjMqMse', 1, NULL, '2026-10-03 14:28:24', '2026-10-03 14:28:24'),
(58, 'BARDE FATIMA ABUBAKAR', 'fce100732@no-email.fcetpcoop.local', NULL, '$2y$12$2RrwftoX3ySUFjLRMgMrv.V6adriblMwHh8oeEOWqZVMTv8eatjRO', 1, NULL, '2026-10-03 14:28:25', '2026-10-03 14:28:25'),
(59, 'ILUOBE MARY MODUPE', 'fce101076@no-email.fcetpcoop.local', NULL, '$2y$12$VPeMS9Wf3WThKRiUjf/WL.4cetexpcbIUi.AnsM8uR/5kcFogge9q', 1, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(60, 'ABDULLAHI AISHA ALKALI', 'fce200002@no-email.fcetpcoop.local', NULL, '$2y$12$kaEUbLS3hpZoX2iTMBMdoeTKXrzl5kZ/ygF0ZA9fSHvSxoqjFKznW', 1, NULL, '2026-10-03 14:28:26', '2026-10-03 14:28:26'),
(61, 'ALI MOHAMMED', 'fce100696@no-email.fcetpcoop.local', NULL, '$2y$12$9IseLO9pLC4I/jKYVroBaeRxRyFCIZQTOzay.OSsfLd74FYcTU09m', 1, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(62, 'SHUAIBU ZAKAR YA\'U', 'fce101380@no-email.fcetpcoop.local', NULL, '$2y$12$bTwn4TnaW1OvJ6pjiq916OceMC7sqDoBcSVbtuHJIEpO6jKMObg5C', 1, NULL, '2026-10-03 14:28:27', '2026-10-03 14:28:27'),
(63, 'ABDULKADIR SAIDU', 'fce101140@no-email.fcetpcoop.local', NULL, '$2y$12$BjPzcOxRjrZt/8mb61mvzebmCugWHJyud01qr9hMpGuydIL8UjxBu', 1, NULL, '2026-10-03 14:28:28', '2026-10-03 14:28:28'),
(64, 'MUSTAPHA AISHATU FIKA', 'fce101231@no-email.fcetpcoop.local', NULL, '$2y$12$aXQhfrD28CITd1R4EevgK.fNk9ZgPqmLdpKGFz80gPqcwIXlk90Lu', 1, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(65, 'LAWAN YAKUBU SAIDU', 'fce200057@no-email.fcetpcoop.local', NULL, '$2y$12$2oJIc1Y82K1kVgXg24PN4OH3pcwOw0aJhDbWXUQm8KKwCCT.W1Q4K', 1, NULL, '2026-10-03 14:28:29', '2026-10-03 14:28:29'),
(66, 'MUHAMMAD YUSUF MUHAMMAD', 'fce101423@no-email.fcetpcoop.local', NULL, '$2y$12$jN7S38VXrYj5juGF5kmiVO85Hcpi1KB4rMs4KFDYtEDWSRgnz2luC', 1, NULL, '2026-10-03 14:28:30', '2026-10-03 14:28:30'),
(67, 'HASSAN MUHAMMAD ABBA', 'fce100848@no-email.fcetpcoop.local', NULL, '$2y$12$QHqAqMEolqH2GqNYFEbn2u.uPqky.wip7OuKtW4hQ.30fIkGNGCIm', 1, NULL, '2026-10-03 14:30:58', '2026-10-03 14:30:58'),
(68, 'USMAN NANA', 'fce100674@no-email.fcetpcoop.local', NULL, '$2y$12$NOqBBJpIgvvxSQD9d6.jpO71y4YKOek/rm13orwxQJ8JAH0oNLAy2', 1, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(69, 'DAUDA YAHAYA ALHAJI', 'fce100911@no-email.fcetpcoop.local', NULL, '$2y$12$9JG8AB4v0VquOhJMpP/iuefXx3APwQapWgexQ4k4mU41l3QSQAYlW', 1, NULL, '2026-10-03 14:30:59', '2026-10-03 14:30:59'),
(70, 'GARBA ASABE YUSUF', 'fce200008@no-email.fcetpcoop.local', NULL, '$2y$12$nNdtxzI3KqGBASX0rhwr5uLfGLQ6M1n.jyomcxVzkXhQlbplu8WHC', 1, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(71, 'BADEJO HARUNA ABUBAKAR', 'fce100789@no-email.fcetpcoop.local', NULL, '$2y$12$cA2flhChEcie8L6TqXAtReBS6/TLoNVmrNMdbvebQgJfz.zuhuAAq', 1, NULL, '2026-10-03 14:31:00', '2026-10-03 14:31:00'),
(72, 'KALLAMU ISA IBRAHIM', 'fce101057@no-email.fcetpcoop.local', NULL, '$2y$12$o.chR4dgzwdUaqcCzGAH/u7y1CuSvFfVuZm7r4IrXaSkBXihd4RXG', 1, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(73, 'DISA ABUBAKAR', 'fce100366@no-email.fcetpcoop.local', NULL, '$2y$12$oz57RyhPD4t89QH/OE2dSewloajn6rfy1R0P3DsZHodwLJBEjiay.', 1, NULL, '2026-10-03 14:31:01', '2026-10-03 14:31:01'),
(74, 'YUSUF HAMZA MUSA', 'fce100702@no-email.fcetpcoop.local', NULL, '$2y$12$K4XlryNhZdN/SuMf3Bf2FO9xap4tB207nMzm0hwqVcb0N/jl5ITMu', 1, NULL, '2026-10-03 14:31:02', '2026-10-03 14:31:02'),
(75, 'ZARMA BABAYO BOMOI', 'fce100939@no-email.fcetpcoop.local', NULL, '$2y$12$TJT42/VYYrS7yQDPh2JnJ.Ytg6zomXs0XZMO07FBjL6SwDr2hPLem', 1, NULL, '2026-10-03 14:42:58', '2026-10-03 14:42:58'),
(76, 'MOHAMMED AUDU', 'fce101259@no-email.fcetpcoop.local', NULL, '$2y$12$lt3O8cN715wp2NadkWGgceR/mLRITqEbLeFeVk5A0/kpCGYRWecYy', 1, NULL, '2026-10-03 14:42:59', '2026-10-03 14:42:59'),
(77, 'BUNDI ALHAJI GAMBO', 'fce101378@no-email.fcetpcoop.local', NULL, '$2y$12$4RLd5j/1pCSBaTPIwcF5ceTXPJ0Y6MaLfmW78HGDj7AUXo.UT8w/m', 1, NULL, '2026-10-03 15:04:20', '2026-10-03 15:04:20'),
(78, 'PINDAR YUSUF KWI', 'fce100139@no-email.fcetpcoop.local', NULL, '$2y$12$h1gvuljA0L7HCPmIt8bomezwe.RjtzPhXiZinfyi9MYi82cZBhpH6', 1, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(79, 'ABDULLAHI YAHAYA POTISKUM', 'fce100122@no-email.fcetpcoop.local', NULL, '$2y$12$GedgSF77/BhYSm8lf4EDw.8CicLM0W4TD1MgEqXT1TgNTHJghUKSS', 1, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(80, 'BABA MOHAMMED RABIU', 'fce100818@no-email.fcetpcoop.local', NULL, '$2y$12$Sm02L2hKYBCGb7RB6RJ.6eAhZhIPJfYdfcyV.Gvt.5qYBHJXS8n1.', 1, NULL, '2026-10-03 15:04:21', '2026-10-03 15:04:21'),
(81, 'BAKOJI BALA', 'fce100816@no-email.fcetpcoop.local', NULL, '$2y$12$jqMZHxXWZCUziWeNfFDyg.zq9z/e8f2Dk0IFHuB8UDF.Dat2osNaa', 1, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(82, 'DAWASA IBRAHIM MOHAMMED', 'fce100857@no-email.fcetpcoop.local', NULL, '$2y$12$8HhFD9YEhsapa3MzW.mzMOblGeMuq4ndGRmhJOGgfe/aJvUfyM5rm', 1, NULL, '2026-10-03 15:04:22', '2026-10-03 15:04:22'),
(83, 'MUSAH AMINU', 'fce100900@no-email.fcetpcoop.local', NULL, '$2y$12$jr9LWzDgGb7QhYUQSZaDDO2udgjQyLhF1dpjv001of7SerHqweCWW', 1, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(84, 'POKALAS TAIYATU', 'fce100185@no-email.fcetpcoop.local', NULL, '$2y$12$IhESI449YziUOWOr8Sz9jugNw7O9OdoDzfZ9/oCVCBz.7Rbc1.wMW', 1, NULL, '2026-10-03 15:04:23', '2026-10-03 15:04:23'),
(85, 'WAZIRI MOHAMMED ADAMU', 'fce100547@no-email.fcetpcoop.local', NULL, '$2y$12$UT41WceZ1xLoox8Xk2fKmOQ9BGhShtUJ/XtPbKJCRxugYNBZI8ByG', 1, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(86, 'MAMMAI YUSUF MOHAMMED', 'fce100905@no-email.fcetpcoop.local', NULL, '$2y$12$7hN58hBvdx6ztEjB6ZSvqOFw0RqrQtDx/GAvXrPqotaq6VATEr30O', 1, NULL, '2026-10-03 15:04:24', '2026-10-03 15:04:24'),
(87, 'AJIYA ABUBAKAR BABA', 'fce1001029@no-email.fcetpcoop.local', NULL, '$2y$12$LgTeYFucasUM6Zvotfr5heP3uiLMUnvR6bBAhbUxls.lMhOkzf2A6', 1, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(88, 'ALHAJI BAABA NURI FIKA', 'fce100979@no-email.fcetpcoop.local', NULL, '$2y$12$VtxjWKw/.ijgGsjjAEJimOVbUuuIVgy6QmlS3dOcmYhcehjcP92Ru', 1, NULL, '2026-10-03 15:04:25', '2026-10-03 15:04:25'),
(89, 'MOHAMMED ABUBAKAR', 'fce100858@no-email.fcetpcoop.local', NULL, '$2y$12$u9vWtQsSVDOUDUPbuhsm5.D4kjmbEnDQrrXFnfJAEpsUrWz.RrRO6', 1, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26'),
(90, 'HASSAN MUSA', 'fce100932@no-email.fcetpcoop.local', NULL, '$2y$12$pwPw/QouCcfaxkpLR5JL0OXoDedLKDAI0h.Ut/ojlDga7VWOk3E5e', 1, NULL, '2026-10-03 15:04:26', '2026-10-03 15:04:26'),
(91, 'ABUBAKAR MUHAMMAD ABUBAKAR', 'fce100916@no-email.fcetpcoop.local', NULL, '$2y$12$EDsV3xGlOkt7dgAQQQ3PvuJZrB7xPihtS0kJsdvkJQObd1DDTaJKW', 1, NULL, '2026-10-03 15:04:27', '2026-10-03 15:04:27'),
(92, 'LAMPO ZAKAR SULE', 'fce100791@no-email.fcetpcoop.local', NULL, '$2y$12$Vm0jisGHJJaq5BSz/xiGg.IvbCbRo7XFNDVh.KJ/z0kwjpcsSfp7W', 1, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(93, 'DANLADI SULEIMAN', 'fce200059@no-email.fcetpcoop.local', NULL, '$2y$12$B/MHL3OSI80yoaC3XIykcO4N1RtyFP2BOXcF3cwDa8OMk/X4WONE6', 1, NULL, '2026-10-03 15:04:28', '2026-10-03 15:04:28'),
(94, 'ISA ABDULLAHI', 'fce101173@no-email.fcetpcoop.local', NULL, '$2y$12$kCqSlLR9rtdfKYvWbBMvq.qR8o4MhqlbQXEkKUisxNoHyZqjsGE5u', 1, NULL, '2026-10-03 15:04:29', '2026-10-03 15:04:29'),
(95, 'GARBA UMAR AHMED', 'fce101345@no-email.fcetpcoop.local', NULL, '$2y$12$o3WNgJv/nAO7J5qiqOkCHOJAomjvfnCvjz9y6LFxwMXJAIR97tJr2', 1, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(96, 'ISA HASSAN', 'fce101237@no-email.fcetpcoop.local', NULL, '$2y$12$GN2n4.7UTvjfZDk3LuxBDeWCWaemH1NhseKMZg1MRk8/l/Fn2KSO.', 1, NULL, '2026-10-03 15:04:30', '2026-10-03 15:04:30'),
(97, 'MAMMAI MOHAMMED MOHAMMED', 'fce100712@no-email.fcetpcoop.local', NULL, '$2y$12$qT.XvHaKoBPFjTl2l/SqruObPdfIm.yI7KoSOedJDUZDZE24KlCpa', 1, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(98, 'SALIHU IDRIS YUNUSA', 'fce101362@no-email.fcetpcoop.local', NULL, '$2y$12$jhRnvZP5lHC9HQjONLtfee8nPjJyh1ofsiue/i7gtFOx5WIGTiuW6', 1, NULL, '2026-10-03 15:04:31', '2026-10-03 15:04:31'),
(99, 'ALI ISAH', 'fce101147@no-email.fcetpcoop.local', NULL, '$2y$12$8cikn9IBx/g57ThQ0BHUd.mhXQdKQMGFFMAZweb8oSyn4FMMeGGFW', 1, NULL, '2026-10-03 15:04:32', '2026-10-03 15:04:32'),
(100, 'ISAH AHMED MUSA', 'fce1001037@no-email.fcetpcoop.local', NULL, '$2y$12$lUypEonAoG6VHHRFt6.tjeOc.4VwxvgdqZ75lcf7zmnQlsIVDqaKa', 1, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(101, 'CHIWAR BUKAR MOHAMMED KABU', 'fce101084@no-email.fcetpcoop.local', NULL, '$2y$12$3qzYiJ7xG.qrFhhe6slTnu5onUPiYyEU16QNpXbMDyvntcP7DueaG', 1, NULL, '2026-10-03 15:04:33', '2026-10-03 15:04:33'),
(102, 'ALI HAMSATU MOHAMMED', 'fce100960@no-email.fcetpcoop.local', NULL, '$2y$12$gDrxx6KdtDtMLvolkwj5O.tyqhFs4DdmEuv0upXBW9vT4gCPq6.K2', 1, NULL, '2026-10-03 15:04:34', '2026-10-03 15:04:34'),
(103, 'ALHAJI BASHIR BALA', 'fce100053@no-email.fcetpcoop.local', NULL, '$2y$12$xNdbY2aGqsTHNSivS68aMesxlfqhDsfWMpC0OXaLxM7L2dLbLdSMC', 1, NULL, '2026-10-03 15:07:19', '2026-10-03 15:07:19'),
(104, 'TIJANI ABDULGAFAR OLAKUNLE', 'fce100774@no-email.fcetpcoop.local', NULL, '$2y$12$HyZD8B6RWFzCZ/yZidw9wOZQ1qO5D/IEqN1b7I2YbEEaFvP8RB4nu', 1, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(105, 'TANKO GARBA', 'fce100941@no-email.fcetpcoop.local', NULL, '$2y$12$ADAkJ1w7FwM731C8jTC44eGFmZ9lfAKnyZBFKxqcgK8eK6BI7BZBa', 1, NULL, '2026-10-03 15:07:20', '2026-10-03 15:07:20'),
(106, 'HARUNA MUAWIYA', 'fce100121@no-email.fcetpcoop.local', NULL, '$2y$12$6hGKkZkmlctaAa9Q2a69UetlaMZjMw8m6KdCk1uoiNECuDkKD6If6', 1, NULL, '2026-10-03 15:07:21', '2026-10-03 15:07:21'),
(107, 'LAWANDI SULYMAN ISMAIL', 'fce100717@no-email.fcetpcoop.local', NULL, '$2y$12$II1Sb6nbkLeUwbUM8Wwnk.Q3EE1ifu2bCF/BeRtmrXWCV3/vspeT.', 1, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(108, 'HARUNA YUSUF', 'fce101152@no-email.fcetpcoop.local', NULL, '$2y$12$IAGy3WHHyH2K4up2R0C5SuxKeYFaQPOLqTeEDT3irugmISF57jKFu', 1, NULL, '2026-10-03 15:07:22', '2026-10-03 15:07:22'),
(109, 'BAPPAH ALIYU WAZIRI', 'fce101227@no-email.fcetpcoop.local', NULL, '$2y$12$upahkf1UunnTbZndnKYOO.3uk4i.qV0ZJjYYAJI1NExHoKYh8CdnS', 1, NULL, '2026-10-03 15:07:23', '2026-10-03 15:07:23'),
(110, 'BUKAR SULEIMAN', 'fce101132@no-email.fcetpcoop.local', NULL, '$2y$12$8WvEOXFFwb4su7yxUn6vpOZ.FtnfXc.tBXK7JD6xCZNbW6JRA3xm.', 1, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(111, 'AHMED ABDULMUMINI GARBA', 'fce101281@no-email.fcetpcoop.local', NULL, '$2y$12$RGEZvLKvCcjiYKvcIawxLOMfzlv/NBxu.5IhyHzUT.kq9gdpZ5eMC', 1, NULL, '2026-10-03 15:07:24', '2026-10-03 15:07:24'),
(112, 'MUSA HASSAN', 'fce101327@no-email.fcetpcoop.local', NULL, '$2y$12$hx1ruW5oXg47YFVUDmjOje.Y2kMpGu0VYhHyPLFQYcSvl9dkTQQau', 1, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(113, 'HASSAN ALIYU ADAMU', 'fce101275@no-email.fcetpcoop.local', NULL, '$2y$12$ZMCabEmXIRR2UNSrv34rK.71H2dtr5ji5o6tqa3xhi7gi9YAhm8Xq', 1, NULL, '2026-10-03 15:07:25', '2026-10-03 15:07:25'),
(114, 'ALI GONI', 'fce101287@no-email.fcetpcoop.local', NULL, '$2y$12$xnp6zVkMoU0Q8UpRB7NmKembQ.2I60Bq.eAEyj7ha13U/nQYg1oWm', 1, NULL, '2026-10-03 15:07:26', '2026-10-03 15:07:26'),
(115, 'SULE SHAIBU ALHAJI', 'fce101404@no-email.fcetpcoop.local', NULL, '$2y$12$f6qwtRlyZOP4oy1VtZs7j.MafWijhwwJqdgNaqCKIrRzIZX8e9lS2', 1, NULL, '2026-10-03 15:07:27', '2026-10-03 15:07:27'),
(116, 'GERO SALE MOHAMMED', 'fce100200@no-email.fcetpcoop.local', NULL, '$2y$12$1MjDWLKRMudvz1W9D9y7FOMJsr15ZBuG5dIntRrs6jrjW/XU.d9Ym', 1, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(117, 'WAKILI HADIZA MOHAMMED', 'fce100705@no-email.fcetpcoop.local', NULL, '$2y$12$N/qxrScZ8pwKnbS6gZ5s5OzcfrPsvAkv8mlB/WtSw6zTpGO9ew80C', 1, NULL, '2026-10-03 15:09:28', '2026-10-03 15:09:28'),
(118, 'USMAN DANLAMI BILTE', 'fce101069@no-email.fcetpcoop.local', NULL, '$2y$12$S.N9UzC3XLADA.JZuPd3zOEGc7PY2vMxzia39WilM/i9XQw46ubDe', 1, NULL, '2026-10-03 15:09:29', '2026-10-03 15:09:29'),
(119, 'YAU YUSUF', 'fce1001031@no-email.fcetpcoop.local', NULL, '$2y$12$mWFtNeL0wyu.IDQs7SmUS.3zVX.Kh77bDe545yBUf7PuT6zt8YUz6', 1, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(120, 'IBRAHIM ABBA ZAKAR', 'fce101082@no-email.fcetpcoop.local', NULL, '$2y$12$vuJH9dL8WDb9YIvwSPT0TeybVvwVpjK/nlOo2oWL8eLNcz55UMq4W', 1, NULL, '2026-10-03 15:09:30', '2026-10-03 15:09:30'),
(121, 'YINUSA ABDULRAFIU YINKA', 'fce101240@no-email.fcetpcoop.local', NULL, '$2y$12$GO0z5pb9YFYm7uTqheSxXelvAidz0GhgAlzneCNqh8dsYm9zCtdsq', 1, NULL, '2026-10-03 15:09:31', '2026-10-03 15:09:31'),
(122, 'ABBA MAHMOUD BARAU', 'fce101180@no-email.fcetpcoop.local', NULL, '$2y$12$kCy6A9m1FyCqwmHj1hEz3.bsGqSqz39gS1DQw.ReOrUkBKCorgyoO', 1, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(123, 'IDRISS BOMOI MOHAMMED', 'fce101264@no-email.fcetpcoop.local', NULL, '$2y$12$xJyqjHmyZsiO1rOZQEDkX.uHR.NXX3.ub7HVcmf55DX.oZePNt/Ia', 1, NULL, '2026-10-03 15:09:32', '2026-10-03 15:09:32'),
(124, 'SAMAILA HADIZA', 'fce101119@no-email.fcetpcoop.local', NULL, '$2y$12$PeEZGIpzXQKA/oJaMyMMMeqML/GPTRUeKvYGHrPVR014pWTm.SmV2', 1, NULL, '2026-10-03 15:09:33', '2026-10-03 15:09:33'),
(125, 'MAIGORO MUSA MUHAMMAD', 'fce100184@no-email.fcetpcoop.local', NULL, '$2y$12$49xiA6xwfeQfIhOfWl7T0OPbsFic/2YGVssUuMFsg7f8aWl2m3k16', 1, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(126, 'BOGO ZAINAB AUDU', 'fce100981@no-email.fcetpcoop.local', NULL, '$2y$12$J/9j1/4FZWWxi1wrRJ64f.XiNRdAtg/vlgr6m1GTRRiTnYI2fWD6q', 1, NULL, '2026-10-03 15:11:43', '2026-10-03 15:11:43'),
(127, 'KYARI SHETTIMA ABBA', 'fce100928@no-email.fcetpcoop.local', NULL, '$2y$12$a1//1uPoOquTgE1JxwZP7.SdJVOY6g3/h7TBk7Z93Cks9dsluiRYO', 1, NULL, '2026-10-03 15:11:44', '2026-10-03 15:11:44'),
(128, 'GALADIMA SAIDU BABA', 'fce100692@no-email.fcetpcoop.local', NULL, '$2y$12$ug8TWwlcDG5iHkjn3CiSp.7xsj/cAmUiBw6O4zIWMtcERFBfUKeBG', 1, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(129, 'ABDULLAHI USMAN', 'fce101138@no-email.fcetpcoop.local', NULL, '$2y$12$XrEKrXLDSzwH.RQVIBxJk.MADDErGS5tvB0msHQdZbLuuZzZ1YGKu', 1, NULL, '2026-10-03 15:11:45', '2026-10-03 15:11:45'),
(130, 'NANGERE MOHAMMED GARBA', 'fce100625@no-email.fcetpcoop.local', NULL, '$2y$12$QfXHltz3xk70Xc9v91.2IOToD0FaqnBAa/MTXaLjjnFRjinayqgy.', 1, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(131, 'USAKU ELIZABETH', 'fce200019@no-email.fcetpcoop.local', NULL, '$2y$12$2tjNLy0rs3FFW2CLWMoFjuBk8qnhTmyY399er4J0P/uNE/vPUVk1S', 1, NULL, '2026-10-03 15:15:57', '2026-10-03 15:15:57'),
(132, 'UMAR USMAN MUHAMMAD', 'fce101092@no-email.fcetpcoop.local', NULL, '$2y$12$zVpcyRerEkDuR4LgC93uWO7wvZ6OruAdBSubiwMaahdDdjbnMd.wW', 1, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(133, 'IBRAHIM MOHAMMED', 'fce100722@no-email.fcetpcoop.local', NULL, '$2y$12$8YTEvsZ70967OhS1JcukYulwGHEPdcSAdgGMU1GXWfKF3NbXrytxW', 1, NULL, '2026-10-03 15:15:58', '2026-10-03 15:15:58'),
(134, 'HALLIRU IBRAHIM ALHAJI', 'fce100624@no-email.fcetpcoop.local', NULL, '$2y$12$dJ9xgNAqCfIsq1B7IpzNIuQDtBAi7zp8Xz7JOuWo.Mv.dEJM2m97K', 1, NULL, '2026-10-03 15:15:59', '2026-10-03 15:15:59'),
(135, 'YAU HARIRA', 'fce100292@no-email.fcetpcoop.local', NULL, '$2y$12$4rUregzN3PBzskdEEPeoJeP8vyW0QWQzMbiKlMbSOgsteml7NHloK', 1, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35'),
(136, 'MOHAMMED UMARU', 'fce100964@no-email.fcetpcoop.local', NULL, '$2y$12$Kjr8J6yNTMXgjDHitX9wgeuqnjjIdf.fWIzDnNSqoX4.gsfDrrkH6', 1, NULL, '2026-10-03 15:19:35', '2026-10-03 15:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `voluntary_deposit_intents`
--

CREATE TABLE `voluntary_deposit_intents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `savings_account_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `note` text DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `receipt_original_filename` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','declined') NOT NULL DEFAULT 'pending',
  `confirmed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `decline_reason` text DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welfare_claims`
--

CREATE TABLE `welfare_claims` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `claim_no` varchar(255) NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_death` date NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `beneficiary_relationship` varchar(255) NOT NULL,
  `beneficiary_phone` varchar(255) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `initiated_by` bigint(20) UNSIGNED NOT NULL,
  `chairman_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_reviewed_at` timestamp NULL DEFAULT NULL,
  `chairman_note` text DEFAULT NULL,
  `disbursed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_at` timestamp NULL DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welfare_funds`
--

CREATE TABLE `welfare_funds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welfare_fund_transactions`
--

CREATE TABLE `welfare_fund_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `welfare_fund_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `description` text DEFAULT NULL,
  `posted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `claim_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welfare_levy_batches`
--

CREATE TABLE `welfare_levy_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_amount` decimal(14,2) DEFAULT NULL,
  `total_records` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('validated','posted') NOT NULL DEFAULT 'validated',
  `rows` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rows`)),
  `validation_errors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`validation_errors`)),
  `posted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `welfare_levy_payments`
--

CREATE TABLE `welfare_levy_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `welfare_levy_batch_id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_conditions`
--

CREATE TABLE `withdrawal_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `savings_product_id` bigint(20) UNSIGNED NOT NULL,
  `rule_type` enum('minimum_balance','minimum_membership_duration','max_withdrawal_pct_of_balance','cooling_period') NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawal_conditions`
--

INSERT INTO `withdrawal_conditions` (`id`, `savings_product_id`, `rule_type`, `value`, `description`, `created_by`, `last_edited_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'minimum_balance', '5000', 'Minimum balance that must remain in Regular Savings after any withdrawal.', NULL, NULL, 1, '2026-10-03 12:46:16', '2026-10-03 12:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_requests`
--

CREATE TABLE `withdrawal_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `savings_account_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('partial','complete') NOT NULL DEFAULT 'partial',
  `beneficiary_type` enum('member','next_of_kin') NOT NULL DEFAULT 'member',
  `initiated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_amount` decimal(14,2) NOT NULL,
  `approved_amount` decimal(14,2) DEFAULT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','treasurer_approved','treasurer_rejected','chairman_authorized','chairman_declined','disbursed','cancelled') NOT NULL DEFAULT 'pending',
  `treasurer_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurer_reviewed_at` timestamp NULL DEFAULT NULL,
  `treasurer_note` text DEFAULT NULL,
  `chairman_reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `chairman_reviewed_at` timestamp NULL DEFAULT NULL,
  `chairman_note` text DEFAULT NULL,
  `disbursed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_at` timestamp NULL DEFAULT NULL,
  `requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_causer_id_foreign` (`causer_id`),
  ADD KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  ADD KEY `activity_logs_action_index` (`action`),
  ADD KEY `activity_logs_created_at_index` (`created_at`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_posted_by_foreign` (`posted_by`),
  ADD KEY `announcements_is_pinned_index` (`is_pinned`);

--
-- Indexes for table `application_fee_payments`
--
ALTER TABLE `application_fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_fee_payments_reference_unique` (`reference`),
  ADD KEY `application_fee_payments_member_id_foreign` (`member_id`),
  ADD KEY `application_fee_payments_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `budgets_fy_start_year_unique` (`fy_start_year`),
  ADD KEY `budgets_proposed_by_foreign` (`proposed_by`),
  ADD KEY `budgets_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `budget_lines`
--
ALTER TABLE `budget_lines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `budget_lines_budget_id_category_unique` (`budget_id`,`category`);

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
-- Indexes for table `commodity_cycles`
--
ALTER TABLE `commodity_cycles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commodity_cycles_opened_by_foreign` (`opened_by`),
  ADD KEY `commodity_cycles_priced_by_foreign` (`priced_by`),
  ADD KEY `commodity_cycles_auditor_verified_by_foreign` (`auditor_verified_by`),
  ADD KEY `commodity_cycles_store_approved_by_foreign` (`store_approved_by`),
  ADD KEY `commodity_cycles_chairman_authorized_by_foreign` (`chairman_authorized_by`);

--
-- Indexes for table `commodity_cycle_prices`
--
ALTER TABLE `commodity_cycle_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commodity_cycle_prices_commodity_cycle_id_foreign` (`commodity_cycle_id`),
  ADD KEY `commodity_cycle_prices_commodity_item_id_foreign` (`commodity_item_id`),
  ADD KEY `commodity_cycle_prices_set_by_foreign` (`set_by`);

--
-- Indexes for table `commodity_items`
--
ALTER TABLE `commodity_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commodity_items_created_from_request_line_id_foreign` (`created_from_request_line_id`);

--
-- Indexes for table `commodity_requests`
--
ALTER TABLE `commodity_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commodity_requests_commodity_cycle_id_member_id_unique` (`commodity_cycle_id`,`member_id`),
  ADD KEY `commodity_requests_member_id_foreign` (`member_id`),
  ADD KEY `commodity_requests_loan_id_foreign` (`loan_id`),
  ADD KEY `commodity_requests_released_by_foreign` (`released_by`);

--
-- Indexes for table `commodity_request_lines`
--
ALTER TABLE `commodity_request_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commodity_request_lines_commodity_request_id_foreign` (`commodity_request_id`),
  ADD KEY `commodity_request_lines_commodity_item_id_foreign` (`commodity_item_id`);

--
-- Indexes for table `contribution_batches`
--
ALTER TABLE `contribution_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contribution_batches_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `contribution_change_requests`
--
ALTER TABLE `contribution_change_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contribution_change_requests_member_id_foreign` (`member_id`),
  ADD KEY `contribution_change_requests_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `dividend_allocations`
--
ALTER TABLE `dividend_allocations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dividend_allocations_dividend_period_id_member_id_unique` (`dividend_period_id`,`member_id`),
  ADD KEY `dividend_allocations_member_id_foreign` (`member_id`),
  ADD KEY `dividend_allocations_dividend_transaction_id_foreign` (`dividend_transaction_id`),
  ADD KEY `dividend_allocations_interest_transaction_id_foreign` (`interest_transaction_id`);

--
-- Indexes for table `dividend_periods`
--
ALTER TABLE `dividend_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dividend_periods_opened_by_foreign` (`opened_by`),
  ADD KEY `dividend_periods_declared_by_foreign` (`declared_by`),
  ADD KEY `dividend_periods_calculated_by_foreign` (`calculated_by`),
  ADD KEY `dividend_periods_posted_by_foreign` (`posted_by`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_documentable_type_documentable_id_index` (`documentable_type`,`documentable_id`),
  ADD KEY `documents_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_expense_no_unique` (`expense_no`),
  ADD KEY `expenses_budget_line_id_foreign` (`budget_line_id`),
  ADD KEY `expenses_initiated_by_foreign` (`initiated_by`),
  ADD KEY `expenses_chairman_reviewed_by_foreign` (`chairman_reviewed_by`),
  ADD KEY `expenses_paid_by_foreign` (`paid_by`),
  ADD KEY `expenses_status_index` (`status`);

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
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loans_loan_no_unique` (`loan_no`),
  ADD KEY `loans_member_id_foreign` (`member_id`),
  ADD KEY `loans_loan_product_id_foreign` (`loan_product_id`),
  ADD KEY `loans_treasurer_reviewed_by_foreign` (`treasurer_reviewed_by`),
  ADD KEY `loans_chairman_reviewed_by_foreign` (`chairman_reviewed_by`),
  ADD KEY `loans_disbursed_by_foreign` (`disbursed_by`);

--
-- Indexes for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_guarantors_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_guarantors_guarantor_member_id_foreign` (`guarantor_member_id`),
  ADD KEY `loan_guarantors_deduction_transaction_id_foreign` (`deduction_transaction_id`);

--
-- Indexes for table `loan_import_batches`
--
ALTER TABLE `loan_import_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_import_batches_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `loan_limit_multipliers`
--
ALTER TABLE `loan_limit_multipliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_limit_multipliers_loan_product_id_foreign` (`loan_product_id`),
  ADD KEY `loan_limit_multipliers_set_by_foreign` (`set_by`);

--
-- Indexes for table `loan_products`
--
ALTER TABLE `loan_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loan_products_code_unique` (`code`);

--
-- Indexes for table `loan_repayment_batches`
--
ALTER TABLE `loan_repayment_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_repayment_batches_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `loan_repayment_intents`
--
ALTER TABLE `loan_repayment_intents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_repayment_intents_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_repayment_intents_member_id_foreign` (`member_id`),
  ADD KEY `loan_repayment_intents_confirmed_by_foreign` (`confirmed_by`),
  ADD KEY `loan_repayment_intents_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `loan_repayment_schedules`
--
ALTER TABLE `loan_repayment_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_repayment_schedules_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `loan_repayment_transactions`
--
ALTER TABLE `loan_repayment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_repayment_transactions_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_repayment_transactions_schedule_id_foreign` (`schedule_id`),
  ADD KEY `loan_repayment_transactions_source_batch_id_foreign` (`source_batch_id`),
  ADD KEY `loan_repayment_transactions_reversed_transaction_id_foreign` (`reversed_transaction_id`),
  ADD KEY `loan_repayment_transactions_posted_by_foreign` (`posted_by`);

--
-- Indexes for table `loan_savings_repayment_requests`
--
ALTER TABLE `loan_savings_repayment_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_savings_repayment_requests_loan_id_foreign` (`loan_id`),
  ADD KEY `loan_savings_repayment_requests_member_id_foreign` (`member_id`),
  ADD KEY `loan_savings_repayment_requests_savings_account_id_foreign` (`savings_account_id`),
  ADD KEY `loan_savings_repayment_requests_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `loan_savings_repayment_requests_status_index` (`status`),
  ADD KEY `lsrr_savings_txn_fk` (`savings_transaction_id`),
  ADD KEY `lsrr_loan_repayment_txn_fk` (`loan_repayment_transaction_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_application_no_unique` (`application_no`),
  ADD UNIQUE KEY `members_staff_id_unique` (`staff_id`),
  ADD UNIQUE KEY `members_membership_no_unique` (`membership_no`),
  ADD KEY `members_user_id_foreign` (`user_id`),
  ADD KEY `members_approved_by_foreign` (`approved_by`),
  ADD KEY `members_exit_requested_by_foreign` (`exit_requested_by`),
  ADD KEY `members_exit_cleared_by_foreign` (`exit_cleared_by`),
  ADD KEY `members_application_fee_marked_by_foreign` (`application_fee_marked_by`);

--
-- Indexes for table `member_change_requests`
--
ALTER TABLE `member_change_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_change_requests_member_id_foreign` (`member_id`),
  ADD KEY `member_change_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `member_change_requests_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `member_events`
--
ALTER TABLE `member_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_events_member_id_foreign` (`member_id`),
  ADD KEY `member_events_caused_by_foreign` (`caused_by`);

--
-- Indexes for table `member_import_batches`
--
ALTER TABLE `member_import_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_import_batches_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `member_status_history`
--
ALTER TABLE `member_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_status_history_member_id_foreign` (`member_id`),
  ADD KEY `member_status_history_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `next_of_kin_member_id_foreign` (`member_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `reversal_requests`
--
ALTER TABLE `reversal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reversal_requests_original_transaction_id_foreign` (`original_transaction_id`),
  ADD KEY `reversal_requests_initiated_by_foreign` (`initiated_by`),
  ADD KEY `reversal_requests_authorized_by_foreign` (`authorized_by`),
  ADD KEY `reversal_requests_resulting_transaction_id_foreign` (`resulting_transaction_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `savings_accounts_member_id_savings_product_id_unique` (`member_id`,`savings_product_id`),
  ADD UNIQUE KEY `savings_accounts_account_no_unique` (`account_no`),
  ADD KEY `savings_accounts_savings_product_id_foreign` (`savings_product_id`);

--
-- Indexes for table `savings_products`
--
ALTER TABLE `savings_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `savings_products_code_unique` (`code`);

--
-- Indexes for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_transactions_savings_account_id_foreign` (`savings_account_id`),
  ADD KEY `savings_transactions_posted_by_foreign` (`posted_by`),
  ADD KEY `savings_transactions_source_batch_id_foreign` (`source_batch_id`),
  ADD KEY `savings_transactions_withdrawal_request_id_foreign` (`withdrawal_request_id`),
  ADD KEY `savings_transactions_reversed_transaction_id_foreign` (`reversed_transaction_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `share_accounts`
--
ALTER TABLE `share_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `share_accounts_member_id_unique` (`member_id`),
  ADD UNIQUE KEY `share_accounts_account_no_unique` (`account_no`);

--
-- Indexes for table `share_price_history`
--
ALTER TABLE `share_price_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_price_history_set_by_foreign` (`set_by`);

--
-- Indexes for table `share_purchase_intents`
--
ALTER TABLE `share_purchase_intents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_purchase_intents_member_id_foreign` (`member_id`),
  ADD KEY `share_purchase_intents_share_account_id_foreign` (`share_account_id`),
  ADD KEY `share_purchase_intents_confirmed_by_foreign` (`confirmed_by`),
  ADD KEY `share_purchase_intents_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `share_transactions`
--
ALTER TABLE `share_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_transactions_share_account_id_foreign` (`share_account_id`),
  ADD KEY `share_transactions_source_batch_id_foreign` (`source_batch_id`),
  ADD KEY `share_transactions_reversed_transaction_id_foreign` (`reversed_transaction_id`),
  ADD KEY `share_transactions_posted_by_foreign` (`posted_by`),
  ADD KEY `share_transactions_withdrawal_request_id_foreign` (`withdrawal_request_id`);

--
-- Indexes for table `share_withdrawal_requests`
--
ALTER TABLE `share_withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_withdrawal_requests_member_id_foreign` (`member_id`),
  ADD KEY `share_withdrawal_requests_share_account_id_foreign` (`share_account_id`),
  ADD KEY `share_withdrawal_requests_treasurer_reviewed_by_foreign` (`treasurer_reviewed_by`),
  ADD KEY `share_withdrawal_requests_chairman_reviewed_by_foreign` (`chairman_reviewed_by`),
  ADD KEY `share_withdrawal_requests_disbursed_by_foreign` (`disbursed_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_no_unique` (`ticket_no`),
  ADD KEY `tickets_member_id_foreign` (`member_id`),
  ADD KEY `tickets_raised_by_foreign` (`raised_by`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_resolved_by_foreign` (`resolved_by`),
  ADD KEY `tickets_status_is_confidential_index` (`status`,`is_confidential`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `voluntary_deposit_intents`
--
ALTER TABLE `voluntary_deposit_intents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voluntary_deposit_intents_member_id_foreign` (`member_id`),
  ADD KEY `voluntary_deposit_intents_savings_account_id_foreign` (`savings_account_id`),
  ADD KEY `voluntary_deposit_intents_confirmed_by_foreign` (`confirmed_by`),
  ADD KEY `voluntary_deposit_intents_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `welfare_claims`
--
ALTER TABLE `welfare_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `welfare_claims_claim_no_unique` (`claim_no`),
  ADD KEY `welfare_claims_member_id_foreign` (`member_id`),
  ADD KEY `welfare_claims_initiated_by_foreign` (`initiated_by`),
  ADD KEY `welfare_claims_chairman_reviewed_by_foreign` (`chairman_reviewed_by`),
  ADD KEY `welfare_claims_disbursed_by_foreign` (`disbursed_by`),
  ADD KEY `welfare_claims_status_index` (`status`);

--
-- Indexes for table `welfare_funds`
--
ALTER TABLE `welfare_funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `welfare_fund_transactions`
--
ALTER TABLE `welfare_fund_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `welfare_fund_transactions_welfare_fund_id_foreign` (`welfare_fund_id`),
  ADD KEY `welfare_fund_transactions_posted_by_foreign` (`posted_by`),
  ADD KEY `welfare_fund_transactions_source_batch_id_foreign` (`source_batch_id`),
  ADD KEY `welfare_fund_transactions_claim_id_foreign` (`claim_id`);

--
-- Indexes for table `welfare_levy_batches`
--
ALTER TABLE `welfare_levy_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `welfare_levy_batches_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `welfare_levy_payments`
--
ALTER TABLE `welfare_levy_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `welfare_levy_payments_member_id_period_unique` (`member_id`,`period`),
  ADD KEY `welfare_levy_payments_welfare_levy_batch_id_foreign` (`welfare_levy_batch_id`);

--
-- Indexes for table `withdrawal_conditions`
--
ALTER TABLE `withdrawal_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_conditions_savings_product_id_foreign` (`savings_product_id`),
  ADD KEY `withdrawal_conditions_created_by_foreign` (`created_by`),
  ADD KEY `withdrawal_conditions_last_edited_by_foreign` (`last_edited_by`);

--
-- Indexes for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_requests_member_id_foreign` (`member_id`),
  ADD KEY `withdrawal_requests_savings_account_id_foreign` (`savings_account_id`),
  ADD KEY `withdrawal_requests_treasurer_reviewed_by_foreign` (`treasurer_reviewed_by`),
  ADD KEY `withdrawal_requests_chairman_reviewed_by_foreign` (`chairman_reviewed_by`),
  ADD KEY `withdrawal_requests_disbursed_by_foreign` (`disbursed_by`),
  ADD KEY `withdrawal_requests_initiated_by_foreign` (`initiated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `application_fee_payments`
--
ALTER TABLE `application_fee_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_lines`
--
ALTER TABLE `budget_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodity_cycles`
--
ALTER TABLE `commodity_cycles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodity_cycle_prices`
--
ALTER TABLE `commodity_cycle_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodity_items`
--
ALTER TABLE `commodity_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `commodity_requests`
--
ALTER TABLE `commodity_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commodity_request_lines`
--
ALTER TABLE `commodity_request_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contribution_batches`
--
ALTER TABLE `contribution_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contribution_change_requests`
--
ALTER TABLE `contribution_change_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dividend_allocations`
--
ALTER TABLE `dividend_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dividend_periods`
--
ALTER TABLE `dividend_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_import_batches`
--
ALTER TABLE `loan_import_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_limit_multipliers`
--
ALTER TABLE `loan_limit_multipliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_products`
--
ALTER TABLE `loan_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_repayment_batches`
--
ALTER TABLE `loan_repayment_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_repayment_intents`
--
ALTER TABLE `loan_repayment_intents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_repayment_schedules`
--
ALTER TABLE `loan_repayment_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_repayment_transactions`
--
ALTER TABLE `loan_repayment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_savings_repayment_requests`
--
ALTER TABLE `loan_savings_repayment_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `member_change_requests`
--
ALTER TABLE `member_change_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_events`
--
ALTER TABLE `member_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `member_import_batches`
--
ALTER TABLE `member_import_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member_status_history`
--
ALTER TABLE `member_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `reversal_requests`
--
ALTER TABLE `reversal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `savings_products`
--
ALTER TABLE `savings_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1418;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `share_accounts`
--
ALTER TABLE `share_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_price_history`
--
ALTER TABLE `share_price_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `share_purchase_intents`
--
ALTER TABLE `share_purchase_intents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_transactions`
--
ALTER TABLE `share_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_withdrawal_requests`
--
ALTER TABLE `share_withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `voluntary_deposit_intents`
--
ALTER TABLE `voluntary_deposit_intents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welfare_claims`
--
ALTER TABLE `welfare_claims`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welfare_funds`
--
ALTER TABLE `welfare_funds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welfare_fund_transactions`
--
ALTER TABLE `welfare_fund_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `welfare_levy_batches`
--
ALTER TABLE `welfare_levy_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `welfare_levy_payments`
--
ALTER TABLE `welfare_levy_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal_conditions`
--
ALTER TABLE `withdrawal_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_causer_id_foreign` FOREIGN KEY (`causer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `application_fee_payments`
--
ALTER TABLE `application_fee_payments`
  ADD CONSTRAINT `application_fee_payments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_fee_payments_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `budgets_proposed_by_foreign` FOREIGN KEY (`proposed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `budget_lines`
--
ALTER TABLE `budget_lines`
  ADD CONSTRAINT `budget_lines_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commodity_cycles`
--
ALTER TABLE `commodity_cycles`
  ADD CONSTRAINT `commodity_cycles_auditor_verified_by_foreign` FOREIGN KEY (`auditor_verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_cycles_chairman_authorized_by_foreign` FOREIGN KEY (`chairman_authorized_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_cycles_opened_by_foreign` FOREIGN KEY (`opened_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `commodity_cycles_priced_by_foreign` FOREIGN KEY (`priced_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_cycles_store_approved_by_foreign` FOREIGN KEY (`store_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commodity_cycle_prices`
--
ALTER TABLE `commodity_cycle_prices`
  ADD CONSTRAINT `commodity_cycle_prices_commodity_cycle_id_foreign` FOREIGN KEY (`commodity_cycle_id`) REFERENCES `commodity_cycles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commodity_cycle_prices_commodity_item_id_foreign` FOREIGN KEY (`commodity_item_id`) REFERENCES `commodity_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_cycle_prices_set_by_foreign` FOREIGN KEY (`set_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `commodity_items`
--
ALTER TABLE `commodity_items`
  ADD CONSTRAINT `commodity_items_created_from_request_line_id_foreign` FOREIGN KEY (`created_from_request_line_id`) REFERENCES `commodity_request_lines` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commodity_requests`
--
ALTER TABLE `commodity_requests`
  ADD CONSTRAINT `commodity_requests_commodity_cycle_id_foreign` FOREIGN KEY (`commodity_cycle_id`) REFERENCES `commodity_cycles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commodity_requests_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `commodity_requests_released_by_foreign` FOREIGN KEY (`released_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `commodity_request_lines`
--
ALTER TABLE `commodity_request_lines`
  ADD CONSTRAINT `commodity_request_lines_commodity_item_id_foreign` FOREIGN KEY (`commodity_item_id`) REFERENCES `commodity_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `commodity_request_lines_commodity_request_id_foreign` FOREIGN KEY (`commodity_request_id`) REFERENCES `commodity_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contribution_batches`
--
ALTER TABLE `contribution_batches`
  ADD CONSTRAINT `contribution_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `contribution_change_requests`
--
ALTER TABLE `contribution_change_requests`
  ADD CONSTRAINT `contribution_change_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `contribution_change_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dividend_allocations`
--
ALTER TABLE `dividend_allocations`
  ADD CONSTRAINT `dividend_allocations_dividend_period_id_foreign` FOREIGN KEY (`dividend_period_id`) REFERENCES `dividend_periods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dividend_allocations_dividend_transaction_id_foreign` FOREIGN KEY (`dividend_transaction_id`) REFERENCES `savings_transactions` (`id`),
  ADD CONSTRAINT `dividend_allocations_interest_transaction_id_foreign` FOREIGN KEY (`interest_transaction_id`) REFERENCES `savings_transactions` (`id`),
  ADD CONSTRAINT `dividend_allocations_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `dividend_periods`
--
ALTER TABLE `dividend_periods`
  ADD CONSTRAINT `dividend_periods_calculated_by_foreign` FOREIGN KEY (`calculated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dividend_periods_declared_by_foreign` FOREIGN KEY (`declared_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dividend_periods_opened_by_foreign` FOREIGN KEY (`opened_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dividend_periods_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_budget_line_id_foreign` FOREIGN KEY (`budget_line_id`) REFERENCES `budget_lines` (`id`),
  ADD CONSTRAINT `expenses_chairman_reviewed_by_foreign` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `expenses_paid_by_foreign` FOREIGN KEY (`paid_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_chairman_reviewed_by_foreign` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_disbursed_by_foreign` FOREIGN KEY (`disbursed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loans_loan_product_id_foreign` FOREIGN KEY (`loan_product_id`) REFERENCES `loan_products` (`id`),
  ADD CONSTRAINT `loans_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `loans_treasurer_reviewed_by_foreign` FOREIGN KEY (`treasurer_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD CONSTRAINT `loan_guarantors_deduction_transaction_id_foreign` FOREIGN KEY (`deduction_transaction_id`) REFERENCES `savings_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_guarantors_guarantor_member_id_foreign` FOREIGN KEY (`guarantor_member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `loan_guarantors_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_import_batches`
--
ALTER TABLE `loan_import_batches`
  ADD CONSTRAINT `loan_import_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_limit_multipliers`
--
ALTER TABLE `loan_limit_multipliers`
  ADD CONSTRAINT `loan_limit_multipliers_loan_product_id_foreign` FOREIGN KEY (`loan_product_id`) REFERENCES `loan_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_limit_multipliers_set_by_foreign` FOREIGN KEY (`set_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loan_repayment_batches`
--
ALTER TABLE `loan_repayment_batches`
  ADD CONSTRAINT `loan_repayment_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_repayment_intents`
--
ALTER TABLE `loan_repayment_intents`
  ADD CONSTRAINT `loan_repayment_intents_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_repayment_intents_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_repayment_intents_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `loan_repayment_intents_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `loan_repayment_transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loan_repayment_schedules`
--
ALTER TABLE `loan_repayment_schedules`
  ADD CONSTRAINT `loan_repayment_schedules_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_repayment_transactions`
--
ALTER TABLE `loan_repayment_transactions`
  ADD CONSTRAINT `loan_repayment_transactions_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_repayment_transactions_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_repayment_transactions_reversed_transaction_id_foreign` FOREIGN KEY (`reversed_transaction_id`) REFERENCES `loan_repayment_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_repayment_transactions_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `loan_repayment_schedules` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_repayment_transactions_source_batch_id_foreign` FOREIGN KEY (`source_batch_id`) REFERENCES `loan_repayment_batches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `loan_savings_repayment_requests`
--
ALTER TABLE `loan_savings_repayment_requests`
  ADD CONSTRAINT `loan_savings_repayment_requests_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_savings_repayment_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `loan_savings_repayment_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `loan_savings_repayment_requests_savings_account_id_foreign` FOREIGN KEY (`savings_account_id`) REFERENCES `savings_accounts` (`id`),
  ADD CONSTRAINT `lsrr_loan_repayment_txn_fk` FOREIGN KEY (`loan_repayment_transaction_id`) REFERENCES `loan_repayment_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lsrr_savings_txn_fk` FOREIGN KEY (`savings_transaction_id`) REFERENCES `savings_transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_application_fee_marked_by_foreign` FOREIGN KEY (`application_fee_marked_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_exit_cleared_by_foreign` FOREIGN KEY (`exit_cleared_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_exit_requested_by_foreign` FOREIGN KEY (`exit_requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `member_change_requests`
--
ALTER TABLE `member_change_requests`
  ADD CONSTRAINT `member_change_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_change_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `member_change_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `member_events`
--
ALTER TABLE `member_events`
  ADD CONSTRAINT `member_events_caused_by_foreign` FOREIGN KEY (`caused_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `member_events_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_import_batches`
--
ALTER TABLE `member_import_batches`
  ADD CONSTRAINT `member_import_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `member_status_history`
--
ALTER TABLE `member_status_history`
  ADD CONSTRAINT `member_status_history_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `member_status_history_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `next_of_kin`
--
ALTER TABLE `next_of_kin`
  ADD CONSTRAINT `next_of_kin_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reversal_requests`
--
ALTER TABLE `reversal_requests`
  ADD CONSTRAINT `reversal_requests_authorized_by_foreign` FOREIGN KEY (`authorized_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reversal_requests_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reversal_requests_original_transaction_id_foreign` FOREIGN KEY (`original_transaction_id`) REFERENCES `savings_transactions` (`id`),
  ADD CONSTRAINT `reversal_requests_resulting_transaction_id_foreign` FOREIGN KEY (`resulting_transaction_id`) REFERENCES `savings_transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD CONSTRAINT `savings_accounts_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `savings_accounts_savings_product_id_foreign` FOREIGN KEY (`savings_product_id`) REFERENCES `savings_products` (`id`);

--
-- Constraints for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD CONSTRAINT `savings_transactions_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `savings_transactions_reversed_transaction_id_foreign` FOREIGN KEY (`reversed_transaction_id`) REFERENCES `savings_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `savings_transactions_savings_account_id_foreign` FOREIGN KEY (`savings_account_id`) REFERENCES `savings_accounts` (`id`),
  ADD CONSTRAINT `savings_transactions_source_batch_id_foreign` FOREIGN KEY (`source_batch_id`) REFERENCES `contribution_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `savings_transactions_withdrawal_request_id_foreign` FOREIGN KEY (`withdrawal_request_id`) REFERENCES `withdrawal_requests` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `share_accounts`
--
ALTER TABLE `share_accounts`
  ADD CONSTRAINT `share_accounts_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `share_price_history`
--
ALTER TABLE `share_price_history`
  ADD CONSTRAINT `share_price_history_set_by_foreign` FOREIGN KEY (`set_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `share_purchase_intents`
--
ALTER TABLE `share_purchase_intents`
  ADD CONSTRAINT `share_purchase_intents_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_purchase_intents_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `share_purchase_intents_share_account_id_foreign` FOREIGN KEY (`share_account_id`) REFERENCES `share_accounts` (`id`),
  ADD CONSTRAINT `share_purchase_intents_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `share_transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `share_transactions`
--
ALTER TABLE `share_transactions`
  ADD CONSTRAINT `share_transactions_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_transactions_reversed_transaction_id_foreign` FOREIGN KEY (`reversed_transaction_id`) REFERENCES `share_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_transactions_share_account_id_foreign` FOREIGN KEY (`share_account_id`) REFERENCES `share_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `share_transactions_source_batch_id_foreign` FOREIGN KEY (`source_batch_id`) REFERENCES `contribution_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_transactions_withdrawal_request_id_foreign` FOREIGN KEY (`withdrawal_request_id`) REFERENCES `share_withdrawal_requests` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `share_withdrawal_requests`
--
ALTER TABLE `share_withdrawal_requests`
  ADD CONSTRAINT `share_withdrawal_requests_chairman_reviewed_by_foreign` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_withdrawal_requests_disbursed_by_foreign` FOREIGN KEY (`disbursed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `share_withdrawal_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `share_withdrawal_requests_share_account_id_foreign` FOREIGN KEY (`share_account_id`) REFERENCES `share_accounts` (`id`),
  ADD CONSTRAINT `share_withdrawal_requests_treasurer_reviewed_by_foreign` FOREIGN KEY (`treasurer_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `tickets_raised_by_foreign` FOREIGN KEY (`raised_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `voluntary_deposit_intents`
--
ALTER TABLE `voluntary_deposit_intents`
  ADD CONSTRAINT `voluntary_deposit_intents_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `voluntary_deposit_intents_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `voluntary_deposit_intents_savings_account_id_foreign` FOREIGN KEY (`savings_account_id`) REFERENCES `savings_accounts` (`id`),
  ADD CONSTRAINT `voluntary_deposit_intents_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `savings_transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `welfare_claims`
--
ALTER TABLE `welfare_claims`
  ADD CONSTRAINT `welfare_claims_chairman_reviewed_by_foreign` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `welfare_claims_disbursed_by_foreign` FOREIGN KEY (`disbursed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `welfare_claims_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `welfare_claims_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `welfare_fund_transactions`
--
ALTER TABLE `welfare_fund_transactions`
  ADD CONSTRAINT `welfare_fund_transactions_claim_id_foreign` FOREIGN KEY (`claim_id`) REFERENCES `welfare_claims` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `welfare_fund_transactions_posted_by_foreign` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `welfare_fund_transactions_source_batch_id_foreign` FOREIGN KEY (`source_batch_id`) REFERENCES `welfare_levy_batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `welfare_fund_transactions_welfare_fund_id_foreign` FOREIGN KEY (`welfare_fund_id`) REFERENCES `welfare_funds` (`id`);

--
-- Constraints for table `welfare_levy_batches`
--
ALTER TABLE `welfare_levy_batches`
  ADD CONSTRAINT `welfare_levy_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `welfare_levy_payments`
--
ALTER TABLE `welfare_levy_payments`
  ADD CONSTRAINT `welfare_levy_payments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `welfare_levy_payments_welfare_levy_batch_id_foreign` FOREIGN KEY (`welfare_levy_batch_id`) REFERENCES `welfare_levy_batches` (`id`);

--
-- Constraints for table `withdrawal_conditions`
--
ALTER TABLE `withdrawal_conditions`
  ADD CONSTRAINT `withdrawal_conditions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_conditions_last_edited_by_foreign` FOREIGN KEY (`last_edited_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_conditions_savings_product_id_foreign` FOREIGN KEY (`savings_product_id`) REFERENCES `savings_products` (`id`);

--
-- Constraints for table `withdrawal_requests`
--
ALTER TABLE `withdrawal_requests`
  ADD CONSTRAINT `withdrawal_requests_chairman_reviewed_by_foreign` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_requests_disbursed_by_foreign` FOREIGN KEY (`disbursed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_requests_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `withdrawal_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `withdrawal_requests_savings_account_id_foreign` FOREIGN KEY (`savings_account_id`) REFERENCES `savings_accounts` (`id`),
  ADD CONSTRAINT `withdrawal_requests_treasurer_reviewed_by_foreign` FOREIGN KEY (`treasurer_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
