-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 05:19 AM
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
-- Database: `humvote`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `photo_filename` varchar(255) DEFAULT NULL,
  `faculty` varchar(255) NOT NULL,
  `faculty_code` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `year_of_study` int(11) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `sector_code` varchar(255) NOT NULL,
  `candidate_number` varchar(255) NOT NULL,
  `manifesto` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `status` enum('active','withdrawn','disqualified') NOT NULL DEFAULT 'active',
  `registered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `candidate_id`, `first_name`, `last_name`, `display_name`, `photo_filename`, `faculty`, `faculty_code`, `program`, `year_of_study`, `sector`, `sector_code`, `candidate_number`, `manifesto`, `bio`, `contact_email`, `status`, `registered_at`, `created_at`, `updated_at`) VALUES
(1, 'f8738f45-7df2-47a2-9135-b1b78f045474', 'John', 'Akena', 'John Akena', 'candidate-photos/candidate1.png', 'Business & Management', 'FBM', 'Business Administration', 3, 'Guild', 'G01', 'CAND-001', 'I believe in inclusive leadership and transparent governance.', 'A final-year student passionate about financial reform and leadership.', 'john.aketa@iuea.ac.ug', 'active', '2025-10-29 06:56:37', '2025-10-29 06:28:44', '2025-10-29 06:56:37'),
(2, '02a11151-6a00-48b6-a360-cc94ee455f85', 'Grace', 'Nansubuga', 'Grace Nansubuga', 'candidate-photos/candidate2.png', 'Business & Management', 'FBM', 'Accounting & Finance', 3, 'Guild', 'G02', 'CAND-002', 'Empowering students and enhancing campus welfare.', 'Driven and result-oriented finance major advocating for equity and student growth.', 'grace.nansubuga@iuea.ac.ug', 'active', '2025-10-29 06:56:37', '2025-10-29 06:28:44', '2025-10-29 06:56:37'),
(3, 'ae28636a-fb9d-4558-ba53-3a14e9a05094', 'Samuel', 'Oketcho', 'Samuel Oketcho', 'candidate-photos/candidate3.png', 'Science & Technology', 'FST', 'Computer Science', 2, 'IT Sector', 'IT01', 'CAND-003', 'Digitize student services and improve access to tech opportunities.', 'Tech-savvy candidate aiming to bridge students with digital innovation.', 'samuel.oketcho@iuea.ac.ug', 'active', '2025-10-29 06:56:37', '2025-10-29 06:28:44', '2025-10-29 06:56:37'),
(4, 'd4942b55-80a9-4c0b-8699-fa2fb0583781', 'Mary', 'Atim', 'Mary Atim', 'candidate-photos/candidate4.png', 'Arts & Social Sciences', 'FASS', 'Social Work', 2, 'Guild', 'G03', 'CAND-004', 'Foster inclusion, promote student welfare, and empower female leadership.', 'Passionate about social welfare and gender equality in student communities.', 'mary.atim@iuea.ac.ug', 'active', '2025-10-29 06:56:37', '2025-10-29 06:28:44', '2025-10-29 06:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Faculty of Business & Management', 'FBM', 'Covers business, management, and accounting disciplines.', NULL, NULL),
(2, 'Faculty of Science & Technology', 'FST', 'Focuses on computer science, IT, and innovation.', NULL, NULL),
(3, 'Faculty of Engineering', 'FE', 'Handles civil, mechanical, and electrical engineering.', NULL, NULL),
(4, 'Faculty of Education', 'FED', 'Responsible for teacher education and pedagogy.', NULL, NULL),
(5, 'Faculty of Law', 'FL', 'Specializes in legal studies and governance.', NULL, NULL);

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
(5, '2025_10_21_095930_create_faculties_table', 1),
(6, '2025_10_21_100006_create_sectors_table', 1),
(7, '2025_10_21_100020_create_candidates_table', 1),
(8, '2025_10_21_100034_create_voters_table', 1),
(9, '2025_10_21_100050_create_votes_table', 1),
(10, '2025_11_12_045523_add_fingerprint_data_to_voters_table', 2),
(11, '2025_12_02_184219_add_fingerprint_hash_to_voters_table', 3);

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
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sector_name` varchar(255) NOT NULL,
  `sector_code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `max_candidates` int(11) NOT NULL DEFAULT 1 COMMENT 'How many candidates can stand for this sector',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `sector_name`, `sector_code`, `description`, `max_candidates`, `created_at`, `updated_at`) VALUES
(1, 'Guild President', 'IUEA-GP', 'Represents the student body at the university level.', 10, NULL, NULL),
(2, 'Vice President', 'IUEA-VP', 'Assists the guild president.', 10, NULL, NULL),
(3, 'General Secretary', 'IUEA-GS', 'Handles guild records and communication.', 10, NULL, NULL),
(4, 'Finance Minister', 'IUEA-FM', 'Manages guild funds.', 10, NULL, NULL),
(5, 'Sports Minister', 'IUEA-SM', 'Oversees student sports activities.', 10, NULL, NULL);

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
(1, 'Hum Marube', 'admin@iuea.ac.ug', NULL, '$2y$12$YX2a1RmW7/4ddShwuYXWn.edQCjn3ZrDol2uz7Y4WrzPn/81zpBVG', NULL, '2025-10-29 06:29:18', '2025-10-29 06:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voter_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `faculty_code` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `year_of_study` tinyint(3) UNSIGNED NOT NULL,
  `registered_at` timestamp NULL DEFAULT NULL,
  `has_voted` tinyint(1) NOT NULL DEFAULT 0,
  `fingerprint_template_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fingerprint_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voter_id`, `first_name`, `last_name`, `faculty`, `faculty_code`, `program`, `year_of_study`, `registered_at`, `has_voted`, `fingerprint_template_id`, `created_at`, `updated_at`, `fingerprint_hash`) VALUES
(1, 'V001', 'Mariano', 'Fritsch', 'Business & Management', 'FBM', 'Business Administration', 2, '2024-04-05 03:02:45', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(2, 'V002', 'Haylie', 'Gibson', 'Business & Management', 'FBM', 'Marketing', 2, '2024-01-25 15:21:05', 1, NULL, '2025-10-29 06:56:36', '2025-12-03 00:20:43', NULL),
(3, 'V003', 'Roderick', 'Gerlach', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2025-02-07 06:10:38', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(4, 'V004', 'Carmine', 'Wiegand', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2023-11-21 23:49:41', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(5, 'V005', 'Guillermo', 'Jones', 'Law', 'FLAW', 'Law', 3, '2024-04-24 06:21:19', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(6, 'V006', 'Maggie', 'Morissette', 'Science & Technology', 'FST', 'Computer Science', 4, '2024-07-17 18:16:36', 1, NULL, '2025-10-29 06:56:36', '2025-12-02 15:57:15', 'test-fingerprint'),
(7, 'V007', 'Kareem', 'Bayer', 'Health', 'FHS', 'Nursing', 3, '2025-06-16 18:40:31', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(8, 'V008', 'Litzy', 'Mueller', 'Engineering', 'FENG', 'Electrical Engineering', 3, '2025-02-19 18:28:37', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(9, 'V009', 'Antonetta', 'Haley', 'Health', 'FHS', 'Pharmacy', 2, '2025-02-27 16:05:37', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(10, 'V010', 'Winifred', 'Bartoletti', 'Law', 'FLAW', 'Law', 3, '2024-08-12 23:06:20', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(11, 'V011', 'Geo', 'Hermiston', 'Science & Technology', 'FST', 'Computer Science', 3, '2024-03-04 13:26:27', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(12, 'V012', 'Jaeden', 'Purdy', 'Science & Technology', 'FST', 'Data Science', 3, '2023-11-09 01:54:57', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(13, 'V013', 'Ottilie', 'Stokes', 'Health', 'FHS', 'Nursing', 1, '2025-03-28 17:02:05', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(14, 'V014', 'Romaine', 'Beahan', 'Health', 'FHS', 'Nursing', 1, '2025-08-18 06:24:13', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(15, 'V015', 'Jedidiah', 'Lakin', 'Engineering', 'FENG', 'Mechanical Engineering', 1, '2025-06-10 06:50:11', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(16, 'V016', 'Lewis', 'Brekke', 'Engineering', 'FENG', 'Electrical Engineering', 1, '2023-12-02 19:57:06', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(17, 'V017', 'Candida', 'Gerlach', 'Law', 'FLAW', 'Law', 3, '2024-10-24 19:08:13', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(18, 'V018', 'Berneice', 'Considine', 'Health', 'FHS', 'Public Health', 2, '2024-05-16 00:02:11', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(19, 'V019', 'Maya', 'Kuhlman', 'Law', 'FLAW', 'Law', 4, '2024-04-13 15:48:15', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(20, 'V020', 'Porter', 'Parisian', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-03-05 04:45:12', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(21, 'V021', 'Alejandrin', 'Anderson', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-07-17 18:04:25', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(22, 'V022', 'Cassidy', 'Abshire', 'Health', 'FHS', 'Pharmacy', 4, '2023-12-17 15:29:55', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(23, 'V023', 'Johanna', 'Mohr', 'Law', 'FLAW', 'Law', 3, '2025-06-14 03:01:52', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(24, 'V024', 'Hilton', 'Dicki', 'Engineering', 'FENG', 'Civil Engineering', 3, '2024-06-11 23:31:19', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(25, 'V025', 'Santina', 'Gottlieb', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-10-07 13:03:54', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(26, 'V026', 'Ida', 'Heidenreich', 'Science & Technology', 'FST', 'Computer Science', 3, '2023-11-02 04:10:19', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(27, 'V027', 'Duncan', 'Upton', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2024-02-22 11:25:38', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(28, 'V028', 'Emily', 'Brakus', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-05-29 00:11:49', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(29, 'V029', 'Alexandrea', 'Friesen', 'Engineering', 'FENG', 'Electrical Engineering', 3, '2024-06-12 17:33:32', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(30, 'V030', 'Jalon', 'Rolfson', 'Law', 'FLAW', 'Law', 4, '2023-11-21 19:55:31', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(31, 'V031', 'Nadia', 'Stracke', 'Science & Technology', 'FST', 'Information Technology', 1, '2024-08-05 19:56:05', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(32, 'V032', 'Alan', 'Hettinger', 'Engineering', 'FENG', 'Electrical Engineering', 2, '2025-07-10 10:05:42', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(33, 'V033', 'Dagmar', 'Schaefer', 'Science & Technology', 'FST', 'Information Technology', 2, '2024-02-06 21:39:04', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(34, 'V034', 'Alvena', 'Ryan', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-05-13 10:14:07', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(35, 'V035', 'River', 'McClure', 'Law', 'FLAW', 'Law', 1, '2025-08-05 10:51:03', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(36, 'V036', 'Osborne', 'Effertz', 'Business & Management', 'FBM', 'Business Administration', 2, '2024-06-24 23:24:32', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(37, 'V037', 'Yasmine', 'Reynolds', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-11-27 23:56:40', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(38, 'V038', 'Aliza', 'Hagenes', 'Health', 'FHS', 'Public Health', 1, '2024-04-05 17:55:01', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(39, 'V039', 'Assunta', 'Gutkowski', 'Law', 'FLAW', 'Law', 4, '2025-01-29 16:00:55', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(40, 'V040', 'Marquise', 'Howell', 'Science & Technology', 'FST', 'Computer Science', 1, '2024-07-13 19:45:11', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(41, 'V041', 'Anastasia', 'Macejkovic', 'Business & Management', 'FBM', 'Business Administration', 1, '2024-05-11 18:42:12', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(42, 'V042', 'Consuelo', 'Fisher', 'Business & Management', 'FBM', 'Marketing', 2, '2025-02-21 03:34:32', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(43, 'V043', 'Paige', 'White', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2025-09-13 05:07:13', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(44, 'V044', 'Stewart', 'Howe', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2024-04-15 13:36:10', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(45, 'V045', 'Bo', 'Konopelski', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2025-01-25 22:28:52', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(46, 'V046', 'Ross', 'Lesch', 'Law', 'FLAW', 'Law', 3, '2025-01-25 06:20:19', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(47, 'V047', 'Kaela', 'Legros', 'Engineering', 'FENG', 'Civil Engineering', 4, '2024-03-31 22:50:09', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(48, 'V048', 'Haven', 'Haley', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-07-05 02:31:21', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(49, 'V049', 'Bria', 'O\'Keefe', 'Business & Management', 'FBM', 'Marketing', 1, '2025-10-13 09:41:02', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(50, 'V050', 'Hubert', 'Lockman', 'Science & Technology', 'FST', 'Information Technology', 4, '2024-10-02 20:37:03', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(51, 'V051', 'Geovanny', 'Schulist', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-03-07 02:27:08', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(52, 'V052', 'Christopher', 'Herman', 'Health', 'FHS', 'Pharmacy', 4, '2025-03-17 00:13:51', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(53, 'V053', 'Lorine', 'Herman', 'Health', 'FHS', 'Nursing', 1, '2024-01-22 04:36:49', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(54, 'V054', 'Astrid', 'Stiedemann', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-04-24 05:58:11', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(55, 'V055', 'Eli', 'Weissnat', 'Health', 'FHS', 'Nursing', 4, '2025-10-07 14:06:57', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(56, 'V056', 'Bernard', 'Bergstrom', 'Law', 'FLAW', 'Law', 1, '2025-05-14 04:33:59', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(57, 'V057', 'Alda', 'Gerlach', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2025-01-08 00:13:20', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(58, 'V058', 'Angeline', 'Connelly', 'Health', 'FHS', 'Pharmacy', 1, '2024-08-26 05:22:39', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(59, 'V059', 'Abbie', 'Jerde', 'Science & Technology', 'FST', 'Data Science', 1, '2025-01-02 12:04:11', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(60, 'V060', 'Jayden', 'Bartoletti', 'Science & Technology', 'FST', 'Computer Science', 1, '2025-08-16 01:28:32', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(61, 'V061', 'Lizzie', 'Stoltenberg', 'Science & Technology', 'FST', 'Data Science', 4, '2025-10-23 03:06:53', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(62, 'V062', 'Elwin', 'West', 'Engineering', 'FENG', 'Civil Engineering', 1, '2024-02-28 06:13:11', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(63, 'V063', 'Maurice', 'Funk', 'Law', 'FLAW', 'Law', 4, '2024-12-28 16:52:36', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(64, 'V064', 'Geo', 'Heller', 'Health', 'FHS', 'Nursing', 4, '2023-11-11 22:15:37', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(65, 'V065', 'Terrence', 'Wolf', 'Science & Technology', 'FST', 'Computer Science', 3, '2024-07-03 03:27:07', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(66, 'V066', 'Lambert', 'Brekke', 'Science & Technology', 'FST', 'Information Technology', 3, '2024-04-18 04:06:37', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(67, 'V067', 'Guido', 'Beahan', 'Business & Management', 'FBM', 'Accounting & Finance', 4, '2025-06-01 20:33:26', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(68, 'V068', 'Melissa', 'Orn', 'Science & Technology', 'FST', 'Computer Science', 3, '2023-11-30 14:41:45', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(69, 'V069', 'Annamae', 'Krajcik', 'Health', 'FHS', 'Nursing', 3, '2024-08-13 13:17:32', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(70, 'V070', 'Ryley', 'Rath', 'Science & Technology', 'FST', 'Data Science', 2, '2023-12-23 07:05:28', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(71, 'V071', 'Merl', 'Wolf', 'Business & Management', 'FBM', 'Accounting & Finance', 1, '2024-12-06 10:21:07', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(72, 'V072', 'Blaise', 'Little', 'Science & Technology', 'FST', 'Information Technology', 3, '2024-11-16 23:41:52', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(73, 'V073', 'Dena', 'Weimann', 'Law', 'FLAW', 'Law', 4, '2024-09-19 02:16:19', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(74, 'V074', 'Birdie', 'Hackett', 'Science & Technology', 'FST', 'Data Science', 4, '2025-09-17 03:57:19', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(75, 'V075', 'Vergie', 'Marquardt', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2025-07-08 01:16:19', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(76, 'V076', 'Jerrold', 'O\'Keefe', 'Business & Management', 'FBM', 'Marketing', 1, '2024-03-19 09:19:13', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(77, 'V077', 'Bianka', 'Crona', 'Health', 'FHS', 'Nursing', 1, '2024-08-19 07:12:50', 1, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(78, 'V078', 'Jeramy', 'Abbott', 'Health', 'FHS', 'Public Health', 2, '2024-02-12 13:42:00', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(79, 'V079', 'Rebecca', 'Stanton', 'Science & Technology', 'FST', 'Information Technology', 3, '2023-12-23 11:08:48', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(80, 'V080', 'Deja', 'Kovacek', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2025-06-05 05:19:58', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(81, 'V081', 'Irma', 'Bradtke', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2024-02-06 21:12:53', 0, NULL, '2025-10-29 06:56:36', '2025-10-29 06:56:36', NULL),
(82, 'V082', 'Jovanny', 'Fay', 'Law', 'FLAW', 'Law', 1, '2025-07-12 06:01:41', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(83, 'V083', 'Paul', 'Wisoky', 'Law', 'FLAW', 'Law', 2, '2025-09-12 14:07:58', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(84, 'V084', 'Jena', 'Koch', 'Science & Technology', 'FST', 'Computer Science', 1, '2025-08-02 08:29:48', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(85, 'V085', 'Erick', 'Hintz', 'Business & Management', 'FBM', 'Marketing', 4, '2024-01-09 13:12:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(86, 'V086', 'Meggie', 'Ankunding', 'Science & Technology', 'FST', 'Data Science', 3, '2024-06-17 19:27:09', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(87, 'V087', 'Nikolas', 'McLaughlin', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-06-13 03:57:02', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(88, 'V088', 'Yoshiko', 'Shields', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2024-06-11 10:28:49', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(89, 'V089', 'Kamren', 'Cruickshank', 'Business & Management', 'FBM', 'Marketing', 2, '2024-01-18 17:31:01', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(90, 'V090', 'Adan', 'Mitchell', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2025-08-03 13:32:54', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(91, 'V091', 'Reymundo', 'Ankunding', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-04-05 00:44:03', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(92, 'V092', 'Jessie', 'Boyer', 'Health', 'FHS', 'Nursing', 1, '2024-04-26 05:51:42', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(93, 'V093', 'Garrett', 'Metz', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-01-12 10:57:58', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(94, 'V094', 'Wilma', 'Torphy', 'Science & Technology', 'FST', 'Data Science', 1, '2025-01-26 07:55:02', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(95, 'V095', 'Arlie', 'Mraz', 'Science & Technology', 'FST', 'Data Science', 4, '2024-11-23 09:26:44', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(96, 'V096', 'Bettie', 'Greenfelder', 'Engineering', 'FENG', 'Civil Engineering', 2, '2024-09-19 17:45:16', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(97, 'V097', 'Vena', 'Spencer', 'Law', 'FLAW', 'Law', 3, '2024-05-27 11:02:39', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(98, 'V098', 'Rae', 'Stiedemann', 'Business & Management', 'FBM', 'Business Administration', 1, '2025-09-07 23:13:43', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(99, 'V099', 'Delilah', 'Rutherford', 'Science & Technology', 'FST', 'Data Science', 2, '2025-03-04 02:10:58', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(100, 'V100', 'Deion', 'O\'Conner', 'Law', 'FLAW', 'Law', 2, '2025-09-04 05:29:44', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(101, 'V101', 'Liliana', 'Bartoletti', 'Law', 'FLAW', 'Law', 1, '2023-11-07 04:51:56', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(102, 'V102', 'Hal', 'Wiza', 'Business & Management', 'FBM', 'Business Administration', 4, '2025-07-24 16:42:58', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(103, 'V103', 'Dejuan', 'Carter', 'Science & Technology', 'FST', 'Data Science', 1, '2025-05-30 17:22:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(104, 'V104', 'Dolores', 'Goldner', 'Engineering', 'FENG', 'Civil Engineering', 2, '2023-12-12 20:48:37', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(105, 'V105', 'Georgette', 'Nader', 'Business & Management', 'FBM', 'Marketing', 2, '2023-11-06 18:51:37', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(106, 'V106', 'Bailee', 'Emmerich', 'Law', 'FLAW', 'Law', 1, '2024-01-12 08:38:38', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(107, 'V107', 'Ozella', 'Roberts', 'Health', 'FHS', 'Public Health', 1, '2025-06-16 23:17:46', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(108, 'V108', 'Marjorie', 'Schinner', 'Health', 'FHS', 'Pharmacy', 3, '2024-02-23 14:09:13', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(109, 'V109', 'Jayde', 'Rodriguez', 'Health', 'FHS', 'Pharmacy', 2, '2024-09-17 18:08:50', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(110, 'V110', 'Don', 'Robel', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2025-02-11 07:24:14', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(111, 'V111', 'Cassandra', 'Gutkowski', 'Science & Technology', 'FST', 'Data Science', 3, '2025-07-24 21:56:39', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(112, 'V112', 'Fanny', 'Dach', 'Business & Management', 'FBM', 'Marketing', 4, '2024-06-30 17:46:33', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(113, 'V113', 'Cary', 'Moen', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-11-30 12:10:28', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(114, 'V114', 'Margot', 'Beahan', 'Law', 'FLAW', 'Law', 2, '2024-12-31 18:37:43', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(115, 'V115', 'Mittie', 'Mayer', 'Science & Technology', 'FST', 'Computer Science', 4, '2024-04-03 08:51:14', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(116, 'V116', 'Burdette', 'Greenholt', 'Science & Technology', 'FST', 'Data Science', 2, '2024-01-27 13:00:25', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(117, 'V117', 'Leonora', 'Green', 'Health', 'FHS', 'Pharmacy', 2, '2023-11-30 08:47:14', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(118, 'V118', 'Evans', 'Conn', 'Law', 'FLAW', 'Law', 4, '2024-04-03 10:57:47', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(119, 'V119', 'Candelario', 'Russel', 'Health', 'FHS', 'Pharmacy', 3, '2024-09-12 18:59:34', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(120, 'V120', 'Rhianna', 'Gislason', 'Law', 'FLAW', 'Law', 1, '2024-11-29 06:28:46', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(121, 'V121', 'Laurie', 'Satterfield', 'Business & Management', 'FBM', 'Marketing', 3, '2025-04-21 01:41:42', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(122, 'V122', 'Alicia', 'Daniel', 'Health', 'FHS', 'Pharmacy', 2, '2025-05-09 15:52:56', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(123, 'V123', 'Curt', 'Jakubowski', 'Law', 'FLAW', 'Law', 3, '2024-11-11 21:30:38', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(124, 'V124', 'Thora', 'Bergnaum', 'Engineering', 'FENG', 'Electrical Engineering', 2, '2025-03-18 13:19:37', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(125, 'V125', 'Margarette', 'Homenick', 'Engineering', 'FENG', 'Electrical Engineering', 2, '2025-07-29 10:00:01', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(126, 'V126', 'Aryanna', 'Morar', 'Health', 'FHS', 'Nursing', 1, '2024-02-24 20:40:13', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(127, 'V127', 'Libby', 'Gibson', 'Law', 'FLAW', 'Law', 4, '2025-02-14 08:40:44', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(128, 'V128', 'Rebekah', 'Hane', 'Business & Management', 'FBM', 'Marketing', 1, '2024-06-05 07:39:27', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(129, 'V129', 'Shaniya', 'Greenholt', 'Law', 'FLAW', 'Law', 4, '2024-02-19 19:30:35', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(130, 'V130', 'Karl', 'Hane', 'Business & Management', 'FBM', 'Accounting & Finance', 1, '2025-04-19 12:44:18', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(131, 'V131', 'Maude', 'Keebler', 'Law', 'FLAW', 'Law', 1, '2024-05-25 19:24:56', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(132, 'V132', 'Francisco', 'Douglas', 'Law', 'FLAW', 'Law', 4, '2023-11-17 17:33:49', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(133, 'V133', 'Mariela', 'Buckridge', 'Business & Management', 'FBM', 'Accounting & Finance', 1, '2024-04-05 15:07:47', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(134, 'V134', 'Mckenzie', 'Jacobs', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-06-16 12:56:37', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(135, 'V135', 'Nicolas', 'Schamberger', 'Health', 'FHS', 'Public Health', 2, '2024-02-24 16:10:21', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(136, 'V136', 'Rex', 'Brekke', 'Health', 'FHS', 'Nursing', 4, '2024-09-26 13:01:36', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(137, 'V137', 'Eloise', 'Rolfson', 'Law', 'FLAW', 'Law', 1, '2024-01-08 00:11:23', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(138, 'V138', 'Melvina', 'Maggio', 'Health', 'FHS', 'Pharmacy', 1, '2025-05-05 14:34:30', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(139, 'V139', 'Norbert', 'O\'Kon', 'Business & Management', 'FBM', 'Marketing', 4, '2025-06-22 05:34:40', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(140, 'V140', 'Maximillian', 'Grant', 'Business & Management', 'FBM', 'Accounting & Finance', 4, '2025-08-03 19:05:09', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(141, 'V141', 'Agustin', 'Oberbrunner', 'Law', 'FLAW', 'Law', 4, '2025-04-09 02:51:31', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(142, 'V142', 'Rahsaan', 'Erdman', 'Science & Technology', 'FST', 'Data Science', 2, '2024-08-05 21:41:08', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(143, 'V143', 'Elvera', 'Altenwerth', 'Law', 'FLAW', 'Law', 4, '2023-12-04 14:40:34', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(144, 'V144', 'Madisyn', 'Daugherty', 'Engineering', 'FENG', 'Mechanical Engineering', 3, '2024-10-04 14:47:22', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(145, 'V145', 'Jamison', 'Terry', 'Science & Technology', 'FST', 'Data Science', 1, '2024-11-20 02:26:43', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(146, 'V146', 'Sarina', 'Mayert', 'Health', 'FHS', 'Nursing', 1, '2025-07-19 04:24:09', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(147, 'V147', 'Alfonzo', 'Vandervort', 'Business & Management', 'FBM', 'Marketing', 3, '2025-03-15 06:05:52', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(148, 'V148', 'Isaias', 'Mraz', 'Business & Management', 'FBM', 'Business Administration', 4, '2025-02-16 23:35:37', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(149, 'V149', 'Ryan', 'O\'Kon', 'Science & Technology', 'FST', 'Information Technology', 4, '2024-03-01 17:36:57', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(150, 'V150', 'Monique', 'Oberbrunner', 'Law', 'FLAW', 'Law', 1, '2025-07-17 14:51:27', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(151, 'V151', 'Heather', 'Price', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-06-05 10:27:35', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(152, 'V152', 'Natalia', 'Medhurst', 'Engineering', 'FENG', 'Civil Engineering', 3, '2024-09-15 02:10:59', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(153, 'V153', 'Kade', 'Macejkovic', 'Engineering', 'FENG', 'Electrical Engineering', 4, '2024-01-26 12:49:30', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(154, 'V154', 'Jordane', 'Lehner', 'Law', 'FLAW', 'Law', 1, '2024-11-15 04:51:26', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(155, 'V155', 'Frieda', 'Jaskolski', 'Health', 'FHS', 'Pharmacy', 4, '2024-03-24 16:21:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(156, 'V156', 'Valerie', 'Schamberger', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-02-18 07:34:33', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(157, 'V157', 'Charlotte', 'Collins', 'Science & Technology', 'FST', 'Information Technology', 4, '2025-07-18 20:47:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(158, 'V158', 'Cruz', 'Padberg', 'Health', 'FHS', 'Nursing', 4, '2024-08-01 18:15:15', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(159, 'V159', 'Angus', 'Homenick', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2024-07-12 07:48:02', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(160, 'V160', 'Johnny', 'Hand', 'Science & Technology', 'FST', 'Information Technology', 1, '2025-03-25 03:04:31', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(161, 'V161', 'Aidan', 'Wehner', 'Business & Management', 'FBM', 'Marketing', 3, '2024-04-05 06:40:34', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(162, 'V162', 'Earlene', 'Corwin', 'Health', 'FHS', 'Public Health', 3, '2024-03-29 16:18:10', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(163, 'V163', 'Alden', 'Hyatt', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-11-05 23:23:35', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(164, 'V164', 'Craig', 'Bartell', 'Engineering', 'FENG', 'Civil Engineering', 3, '2024-06-04 09:12:41', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(165, 'V165', 'Beaulah', 'Konopelski', 'Engineering', 'FENG', 'Civil Engineering', 2, '2025-08-03 02:06:31', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(166, 'V166', 'Brad', 'Schulist', 'Engineering', 'FENG', 'Electrical Engineering', 1, '2024-03-02 19:52:36', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(167, 'V167', 'Jody', 'Grant', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-08-22 21:13:12', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(168, 'V168', 'Katlyn', 'Fadel', 'Engineering', 'FENG', 'Civil Engineering', 1, '2025-01-01 08:49:10', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(169, 'V169', 'Jefferey', 'Dickinson', 'Health', 'FHS', 'Pharmacy', 3, '2025-04-07 08:11:48', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(170, 'V170', 'Carley', 'Rohan', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-11-07 17:23:23', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(171, 'V171', 'Myrtle', 'Hauck', 'Engineering', 'FENG', 'Civil Engineering', 4, '2024-12-04 00:25:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(172, 'V172', 'Marina', 'Fahey', 'Business & Management', 'FBM', 'Marketing', 1, '2024-09-17 14:13:20', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(173, 'V173', 'Rahsaan', 'Stroman', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-03-11 07:02:39', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(174, 'V174', 'Lois', 'Leffler', 'Business & Management', 'FBM', 'Marketing', 3, '2025-03-09 00:24:41', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(175, 'V175', 'Lily', 'Zieme', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2025-06-03 08:03:21', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(176, 'V176', 'Aron', 'Pollich', 'Health', 'FHS', 'Pharmacy', 3, '2024-05-08 21:52:48', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(177, 'V177', 'Ally', 'Krajcik', 'Health', 'FHS', 'Public Health', 1, '2025-07-20 16:11:14', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(178, 'V178', 'Dena', 'Grimes', 'Engineering', 'FENG', 'Electrical Engineering', 2, '2024-01-10 18:47:25', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(179, 'V179', 'Maverick', 'Reynolds', 'Business & Management', 'FBM', 'Business Administration', 3, '2024-11-22 14:57:36', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(180, 'V180', 'Joey', 'Koepp', 'Law', 'FLAW', 'Law', 4, '2024-10-17 13:47:58', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(181, 'V181', 'Susie', 'Kuhlman', 'Health', 'FHS', 'Public Health', 2, '2025-04-26 23:04:38', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(182, 'V182', 'Edythe', 'Daugherty', 'Science & Technology', 'FST', 'Computer Science', 2, '2024-12-25 05:44:20', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(183, 'V183', 'Calista', 'Klein', 'Engineering', 'FENG', 'Electrical Engineering', 3, '2025-08-12 02:55:48', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(184, 'V184', 'Antonio', 'Borer', 'Science & Technology', 'FST', 'Computer Science', 3, '2024-05-16 19:07:31', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(185, 'V185', 'Dashawn', 'Hayes', 'Business & Management', 'FBM', 'Marketing', 1, '2025-05-14 23:02:04', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(186, 'V186', 'Myrtle', 'Hickle', 'Law', 'FLAW', 'Law', 2, '2024-07-27 12:09:10', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(187, 'V187', 'Gillian', 'Greenholt', 'Law', 'FLAW', 'Law', 1, '2024-04-29 06:08:07', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(188, 'V188', 'Keyon', 'Stoltenberg', 'Engineering', 'FENG', 'Mechanical Engineering', 4, '2024-10-04 18:35:06', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(189, 'V189', 'Gillian', 'Kirlin', 'Health', 'FHS', 'Pharmacy', 4, '2024-01-09 22:25:50', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(190, 'V190', 'Olaf', 'Nolan', 'Health', 'FHS', 'Public Health', 3, '2024-12-10 03:32:12', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(191, 'V191', 'Alda', 'Schaefer', 'Health', 'FHS', 'Public Health', 4, '2025-02-18 01:47:55', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(192, 'V192', 'Theresa', 'Crona', 'Health', 'FHS', 'Public Health', 3, '2024-11-16 08:10:42', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(193, 'V193', 'Mckenna', 'Hoeger', 'Health', 'FHS', 'Nursing', 3, '2024-03-04 19:15:47', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(194, 'V194', 'Lester', 'Pfannerstill', 'Science & Technology', 'FST', 'Data Science', 4, '2024-10-10 13:32:38', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(195, 'V195', 'Laurine', 'Romaguera', 'Law', 'FLAW', 'Law', 2, '2024-04-20 13:33:07', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(196, 'V196', 'Joelle', 'Franecki', 'Business & Management', 'FBM', 'Marketing', 3, '2025-04-16 13:33:26', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(197, 'V197', 'Hosea', 'Medhurst', 'Engineering', 'FENG', 'Civil Engineering', 1, '2025-03-08 06:54:26', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(198, 'V198', 'Madisyn', 'Leuschke', 'Law', 'FLAW', 'Law', 1, '2023-11-16 15:17:25', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(199, 'V199', 'Arianna', 'Hammes', 'Health', 'FHS', 'Nursing', 3, '2024-06-16 20:04:15', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(200, 'V200', 'Garret', 'Harris', 'Health', 'FHS', 'Pharmacy', 4, '2024-10-30 07:51:01', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(201, 'V201', 'Alexzander', 'Robel', 'Science & Technology', 'FST', 'Data Science', 2, '2024-07-02 05:30:32', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(202, 'V202', 'Hillary', 'Conroy', 'Law', 'FLAW', 'Law', 4, '2025-05-26 01:27:22', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(203, 'V203', 'Stewart', 'Wyman', 'Engineering', 'FENG', 'Mechanical Engineering', 3, '2024-12-24 09:03:50', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(204, 'V204', 'Brielle', 'Emmerich', 'Health', 'FHS', 'Public Health', 4, '2023-11-01 15:13:03', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(205, 'V205', 'Guido', 'Reinger', 'Health', 'FHS', 'Nursing', 1, '2024-11-20 05:41:58', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(206, 'V206', 'Janet', 'Murphy', 'Health', 'FHS', 'Nursing', 3, '2025-05-09 00:35:38', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(207, 'V207', 'Frank', 'Dickinson', 'Business & Management', 'FBM', 'Accounting & Finance', 1, '2024-07-27 07:01:44', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(208, 'V208', 'Rylan', 'Koss', 'Engineering', 'FENG', 'Civil Engineering', 3, '2025-08-16 10:01:19', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(209, 'V209', 'Brionna', 'Wuckert', 'Science & Technology', 'FST', 'Data Science', 4, '2025-05-27 20:46:40', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(210, 'V210', 'Carter', 'Schoen', 'Business & Management', 'FBM', 'Business Administration', 1, '2024-10-10 08:08:13', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(211, 'V211', 'Christa', 'Kuhlman', 'Law', 'FLAW', 'Law', 2, '2024-05-27 03:46:43', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(212, 'V212', 'Magnolia', 'Shanahan', 'Engineering', 'FENG', 'Mechanical Engineering', 2, '2024-02-12 17:28:23', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(213, 'V213', 'Nola', 'McKenzie', 'Business & Management', 'FBM', 'Accounting & Finance', 4, '2024-10-25 11:39:31', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(214, 'V214', 'Kellie', 'Ernser', 'Engineering', 'FENG', 'Mechanical Engineering', 4, '2024-03-28 20:06:09', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(215, 'V215', 'Leopold', 'Kozey', 'Law', 'FLAW', 'Law', 4, '2024-03-18 03:17:30', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(216, 'V216', 'Antwan', 'Kiehn', 'Health', 'FHS', 'Pharmacy', 3, '2024-06-23 05:04:42', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(217, 'V217', 'Zaria', 'Von', 'Health', 'FHS', 'Public Health', 4, '2024-06-12 09:50:53', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(218, 'V218', 'Harley', 'Miller', 'Law', 'FLAW', 'Law', 2, '2025-09-12 23:29:15', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(219, 'V219', 'Kameron', 'Medhurst', 'Business & Management', 'FBM', 'Marketing', 2, '2025-09-11 02:19:10', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(220, 'V220', 'Bud', 'Brown', 'Business & Management', 'FBM', 'Marketing', 2, '2024-07-31 18:39:28', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(221, 'V221', 'Emmie', 'Nicolas', 'Law', 'FLAW', 'Law', 3, '2025-02-14 00:23:46', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(222, 'V222', 'Marcelina', 'Schulist', 'Engineering', 'FENG', 'Civil Engineering', 4, '2025-06-24 04:05:58', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(223, 'V223', 'Karianne', 'Olson', 'Law', 'FLAW', 'Law', 1, '2024-10-31 02:23:16', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(224, 'V224', 'Zoie', 'VonRueden', 'Business & Management', 'FBM', 'Accounting & Finance', 3, '2023-11-09 11:11:17', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(225, 'V225', 'Cecilia', 'Gulgowski', 'Science & Technology', 'FST', 'Computer Science', 4, '2023-11-07 17:29:09', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(226, 'V226', 'Aliya', 'Swaniawski', 'Engineering', 'FENG', 'Civil Engineering', 1, '2025-01-01 11:41:33', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(227, 'V227', 'Elta', 'Langworth', 'Business & Management', 'FBM', 'Business Administration', 2, '2025-04-07 04:06:08', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(228, 'V228', 'Louvenia', 'Wiza', 'Engineering', 'FENG', 'Civil Engineering', 2, '2025-06-26 09:16:21', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(229, 'V229', 'Werner', 'Mitchell', 'Law', 'FLAW', 'Law', 3, '2025-09-21 01:09:42', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(230, 'V230', 'Flo', 'Conn', 'Health', 'FHS', 'Public Health', 1, '2024-10-06 02:18:04', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(231, 'V231', 'Lauren', 'Cronin', 'Law', 'FLAW', 'Law', 1, '2024-01-22 23:30:49', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(232, 'V232', 'Conner', 'Upton', 'Health', 'FHS', 'Pharmacy', 2, '2024-12-06 04:50:35', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(233, 'V233', 'Ophelia', 'Padberg', 'Business & Management', 'FBM', 'Accounting & Finance', 2, '2024-12-30 02:00:07', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(234, 'V234', 'Mikayla', 'Feest', 'Science & Technology', 'FST', 'Information Technology', 3, '2024-04-13 14:57:09', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(235, 'V235', 'Hilton', 'Barton', 'Business & Management', 'FBM', 'Business Administration', 4, '2025-10-08 23:46:02', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(236, 'V236', 'Thelma', 'Klocko', 'Health', 'FHS', 'Pharmacy', 3, '2024-05-08 17:47:31', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(237, 'V237', 'Consuelo', 'Sawayn', 'Health', 'FHS', 'Pharmacy', 2, '2025-06-25 09:13:06', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(238, 'V238', 'Crawford', 'Armstrong', 'Business & Management', 'FBM', 'Marketing', 3, '2025-06-29 01:34:01', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(239, 'V239', 'Cornelius', 'Blanda', 'Science & Technology', 'FST', 'Data Science', 1, '2023-11-02 02:57:44', 0, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL),
(240, 'V240', 'Katelynn', 'Reichel', 'Business & Management', 'FBM', 'Business Administration', 2, '2024-06-06 20:50:47', 1, NULL, '2025-10-29 06:56:37', '2025-10-29 06:56:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voter_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `sector` varchar(255) NOT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidates_candidate_id_unique` (`candidate_id`),
  ADD UNIQUE KEY `candidates_candidate_number_unique` (`candidate_number`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_name_unique` (`name`),
  ADD UNIQUE KEY `faculties_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sectors_sector_name_unique` (`sector_name`),
  ADD UNIQUE KEY `sectors_sector_code_unique` (`sector_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voters_voter_id_unique` (`voter_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_voter_id_foreign` (`voter_id`),
  ADD KEY `votes_candidate_id_foreign` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
