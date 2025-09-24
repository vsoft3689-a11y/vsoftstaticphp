-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2025 at 01:58 PM
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
-- Database: `vsoftdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `sub_text` text DEFAULT NULL,
  `cta_button_text` varchar(255) DEFAULT NULL,
  `cta_button_link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image_path`, `tagline`, `sub_text`, `cta_button_text`, `cta_button_link`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(13, 'uploads/1758607974_6360f0e9a51d4e57508401dc_Model section overview (1).jpg', 'video games', 'video', 'click', 'http://localhost:8080', 1, 1, '2025-09-23 06:12:54', '2025-09-23 06:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requirements`
--

CREATE TABLE `custom_requirements` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `status` enum('pending','approved','done') DEFAULT 'pending',
  `document_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_requirements`
--

INSERT INTO `custom_requirements` (`id`, `user_id`, `title`, `description`, `technologies`, `status`, `document_path`, `created_at`) VALUES
(1, 4, 'Admin', 'Admin', 'Web', 'approved', NULL, '2025-09-22 06:35:02'),
(9, 9, 'Ai', 'Ai', 'AI-ML', 'pending', '../uploads/1758627786_sample_projects.xlsx', '2025-09-23 11:43:06');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('contact','internship','training') NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `type`, `status`, `created_at`) VALUES
(2, 'demo', 'demo@gmail.com', '9891544545', 'demo', 'demo', 'contact', 'pending', '2025-09-22 13:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `page_meta_tags`
--

CREATE TABLE `page_meta_tags` (
  `id` int(11) NOT NULL,
  `page_route` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing_packages`
--

CREATE TABLE `pricing_packages` (
  `id` int(11) NOT NULL,
  `service_type` varchar(150) NOT NULL,
  `package_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing_packages`
--

INSERT INTO `pricing_packages` (`id`, `service_type`, `package_name`, `description`, `original_price`, `discounted_price`, `duration`, `button_link`, `is_featured`, `created_at`, `updated_at`) VALUES
(3, 'Internship', 'AI based', 'Aii', 1000.00, 500.00, '4', 'http://localhost:8080', 1, '2025-09-22 12:25:36', '2025-09-22 12:25:36'),
(4, 'Internship', 'AI based', 'Ai based', 2000.00, 200.00, '4', 'http://localhost:8080', 0, '2025-09-22 12:25:52', '2025-09-22 12:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `degree` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `type` enum('mini','major') NOT NULL,
  `domain` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `file_path_abstract` varchar(255) DEFAULT NULL,
  `file_path_basepaper` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `degree`, `branch`, `type`, `domain`, `title`, `description`, `technologies`, `price`, `youtube_url`, `file_path_abstract`, `file_path_basepaper`, `created_at`, `updated_at`) VALUES
(64, 'B.Tech', 'CSE', 'mini', 'AI/ML', 'Aii', 'Aii', 'web', 1000, 'https://www.youtube.com/watch?v=7SBcUjgZRoY', '../uploads/1758543467_Software Requirements Specification_VSoft Technologies.pdf', '../uploads/1758543467_Software Requirements Specification_VSoft Technologies.pdf', '2025-09-22 12:17:24', '2025-09-22 12:17:47'),
(65, 'B.Tech', 'CSE', 'major', 'Machine Learning', 'Student Performance Prediction', 'Predicting results using ML', 'Python, Scikit-learn', 5000, 'https://youtu.be/abcd1234', 'uploads/abstract1.pdf', 'uploads/base1.pdf', '2025-09-22 12:18:22', '2025-09-22 12:18:22'),
(66, 'B.Tech', 'ECE', '', 'IoT', 'Smart Home Automation', 'IoT-based control system', 'Arduino, NodeMCU', 3000, 'https://youtu.be/wxyz5678', 'uploads/abstract2.pdf', 'uploads/base2.pdf', '2025-09-22 12:18:22', '2025-09-22 12:18:22'),
(67, 'MCA', 'IT', 'major', 'Web Development', 'Online Bookstore', 'MERN full-stack application', 'React, Node.js, MongoDB', 6000, 'https://youtu.be/test9999', 'uploads/abstract3.pdf', 'uploads/base3.pdf', '2025-09-22 12:18:22', '2025-09-22 12:18:22'),
(68, 'MBA', 'IT', 'major', 'Web Development', 'Food App', 'MERN full-stack application', 'React, Node.js, MongoDB', 6000, 'https://youtu.be/test9999', 'uploads/abstract3.pdf', 'uploads/base3.pdf', '2025-09-22 12:18:22', '2025-09-22 12:18:22'),
(69, 'B.Tech', 'CSE', 'mini', 'Web Development', 'Aii', 'Aii', 'Web', 1000, 'https://www.youtube.com/watch?v=7SBcUjgZRoY', '../uploads/1758545942_ai-from-data-to-roi.pdf', '../uploads/1758545942_ai-from-data-to-roi.pdf', '2025-09-22 12:59:02', '2025-09-22 12:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `site_configurations`
--

CREATE TABLE `site_configurations` (
  `id` int(11) NOT NULL,
  `config_key` varchar(255) NOT NULL,
  `config_value` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_configurations`
--

INSERT INTO `site_configurations` (`id`, `config_key`, `config_value`, `created_at`, `updated_at`) VALUES
(8, 'landline', '020', '2025-09-22 12:30:22', '2025-09-22 13:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `bio` text DEFAULT NULL,
  `profile_picture_path` varchar(255) DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_linkedin` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `designation`, `bio`, `profile_picture_path`, `social_facebook`, `social_twitter`, `social_linkedin`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(7, 'Demo', 'SE', 'good good', 'uploads/1758544107_1_rTAjrwwt0Jze_3MqHQ5MfA.jpg', NULL, NULL, NULL, 1, 1, '2025-09-22 12:28:27', '2025-09-22 12:28:27'),
(9, 'Demo', 'SE', 'good good', 'uploads/1758544179_dataanalysisistockrobuart.jpg', NULL, NULL, NULL, 2, 1, '2025-09-22 12:29:39', '2025-09-23 04:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `testimonals`
--

CREATE TABLE `testimonals` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_photo_path` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `display_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonals`
--

INSERT INTO `testimonals` (`id`, `customer_name`, `customer_photo_path`, `designation`, `rating`, `review_text`, `is_approved`, `display_order`, `created_at`, `updated_at`) VALUES
(9, 'Demo', 'uploads/1758544040_6360f0e9a51d4e57508401dc_Model section overview (1).jpg', 'SE', 4, 'good good', 0, 2, '2025-09-22 12:27:20', '2025-09-23 04:21:11'),
(10, 'Demo', 'uploads/1758544059_decision-tree-classification-algorithm.jpg', 'SE', 4, 'good good', 0, 1, '2025-09-22 12:27:39', '2025-09-22 12:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `college` varchar(150) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active',
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `college`, `branch`, `year`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `status`, `role`) VALUES
(4, 'Raju', 'raju@gmail.com', '$2y$10$iVZmynPG3ck0CJ6vn6rMU.CkjfVzWE.p.09PRamVVF4iR/Wjfgy8m', '9845454544', 'SRM', 'CSE', '2024', NULL, NULL, '2025-09-18 08:58:21', '2025-09-18 08:58:21', 'active', 'user'),
(5, 'Test', 'test@gmail.com', '$2y$10$mwAaJNFLTa6ceew5GnjgaueLZRelLRSXCCvfXe4Lf0m1picN5hgdW', '9874566655', 'KL', 'CSE', '2024', NULL, NULL, '2025-09-18 08:59:09', '2025-09-18 08:59:25', 'active', 'user'),
(6, 'admin', 'admin@gmail.com', '$2y$10$oJJ/0xHMSgw4rZDBXME2le2THCfmyZWhCg9izSvmbGc.9uksdDuHG', '', '', '', '', NULL, NULL, '2025-09-18 09:46:32', '2025-09-18 09:47:03', 'active', 'admin'),
(7, 'Demo', 'demo@gmail.com', '$2y$10$fCsJOqMzEZAywUbbp0XIvuuh3gU2ncP8qZzLsxNspPfwOr4PrCVbG', '9845454544', 'SRM', 'CSE', '2024', NULL, NULL, '2025-09-23 08:09:27', '2025-09-23 08:09:27', 'active', 'user'),
(8, 'Mahesh', 'mahesh@gmail.com', '$2y$10$jqQwcVZsqKF8UZeGE5YCc.eJhg/9uGQt1Mg8OqNxwA4h3QTVzrtt2', '9845454544', 'SRM', 'CSE', '2024', NULL, NULL, '2025-09-23 08:14:25', '2025-09-23 08:14:25', 'active', 'user'),
(9, 'Naveen', 'naveen@gmail.com', '$2y$10$Q4UVZ2xzGbAGS0C.48widOFtVDKRBJ3UR4XVuKnDs99L3qbq2otZO', '9845454544', 'SRM', 'CSE', '2024', NULL, NULL, '2025-09-23 11:24:03', '2025-09-23 11:24:03', 'active', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_requirements`
--
ALTER TABLE `custom_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_meta_tags`
--
ALTER TABLE `page_meta_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_route` (`page_route`);

--
-- Indexes for table `pricing_packages`
--
ALTER TABLE `pricing_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_configurations`
--
ALTER TABLE `site_configurations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `config_key` (`config_key`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonals`
--
ALTER TABLE `testimonals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `custom_requirements`
--
ALTER TABLE `custom_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page_meta_tags`
--
ALTER TABLE `page_meta_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing_packages`
--
ALTER TABLE `pricing_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `site_configurations`
--
ALTER TABLE `site_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `testimonals`
--
ALTER TABLE `testimonals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_requirements`
--
ALTER TABLE `custom_requirements`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
