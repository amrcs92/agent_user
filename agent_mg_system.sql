-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2019 at 12:44 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agent_mg_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `reset_token`
--

DROP TABLE IF EXISTS `reset_token`;
CREATE TABLE IF NOT EXISTS `reset_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `used_token` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reset_token`
--

INSERT INTO `reset_token` (`id`, `user_id`, `token`, `created_at`, `used_token`) VALUES
(11, 8, 'df8b15ef57e52dbb59aa3d63713f84a4c8434125352df88bd29b2bd01b8b65df', '2019-04-06 15:08:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `agent_name` varchar(200) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `company_logo` text NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `mobile1` varchar(200) DEFAULT NULL,
  `mobile2` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `postal_code` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `company_name` (`company_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `agent_name`, `company_name`, `company_logo`, `phone`, `mobile1`, `mobile2`, `address`, `postal_code`, `country`, `state`) VALUES
(4, 'shahin89', 'shahin@gmail.com', '$2y$10$TedMbej5b4IPgrxDenm8lOF2Bisb1saaKck.2kzCHPhlqjD4PYSO2', NULL, 'mohamed shahin', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'amrcs92', 'amrcs1992@gmail.com', '$2y$10$aOwSDFFZ7D81IkeaFCgd2.nuUH9ULSZujikPrD3rTgzDG5qXxjOXC', NULL, 'Amr Ashraf', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

DROP TABLE IF EXISTS `user_history`;
CREATE TABLE IF NOT EXISTS `user_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `device_type` varchar(200) NOT NULL,
  `browser_details` varchar(200) NOT NULL,
  `last_login` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `ip_address`, `device_type`, `browser_details`, `last_login`) VALUES
(20, 4, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-02 23:52:20'),
(31, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-06 15:12:41'),
(32, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-06 15:16:38'),
(33, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-06 15:21:14'),
(34, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-06 15:27:05'),
(35, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 13:28:32'),
(36, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 13:37:33'),
(37, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:18:32'),
(38, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:19:42'),
(39, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:24:26'),
(40, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:26:00'),
(41, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:49:34'),
(42, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:50:25'),
(43, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 19:53:46'),
(44, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 20:01:37'),
(45, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 20:38:16'),
(46, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 20:48:50'),
(47, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 21:46:54'),
(48, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 21:49:43'),
(49, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 21:49:58'),
(50, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 21:53:50'),
(51, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 22:31:27'),
(52, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:24:02'),
(53, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:28:37'),
(54, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:29:04'),
(55, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:38:19'),
(56, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:39:16'),
(57, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:39:39'),
(58, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:44:22'),
(59, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:49:20'),
(60, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:49:37'),
(61, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:50:04'),
(62, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:51:30'),
(63, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-07 23:52:00'),
(64, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-08 00:04:26'),
(65, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-08 00:05:03'),
(66, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-08 00:05:34'),
(67, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-08 00:09:11'),
(68, 8, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-08 00:10:14');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reset_token`
--
ALTER TABLE `reset_token`
  ADD CONSTRAINT `reset_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
