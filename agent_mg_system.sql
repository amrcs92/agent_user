-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2019 at 04:59 PM
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reset_token`
--

INSERT INTO `reset_token` (`id`, `user_id`, `token`) VALUES
(3, 6, '41761422b2c3b24de5af9319a056c05bd955ee760fd5f3b5aa630fd0032f8935'),
(4, 6, 'f78ac84bc84d0e3f005db86740371729faa914843ecf24b3dfd1db2d8bf27882'),
(5, 6, '58a190e802300ade407e8a7ffb7837bf493830d582da3d905ee3935f2cef5dc0'),
(6, 6, 'f40d7402259c01d64cdf035d088f8024fb9196916338eb7c48fd36fe3dea19da');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `agent_name`, `company_name`, `company_logo`, `phone`, `mobile1`, `mobile2`, `address`, `postal_code`, `country`, `state`) VALUES
(4, 'shahin89', 'shahin@gmail.com', '$2y$10$TedMbej5b4IPgrxDenm8lOF2Bisb1saaKck.2kzCHPhlqjD4PYSO2', NULL, 'mohamed shahin', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'amrcs92', 'amrcs1992@gmail.com', '$2y$10$.tIrbDaq5nkpiYBC7.kI.e6i4ZCSp1Bo91He7Rcvw/xHUZyzItVUi', 'Amr Ashraf Serag Eldin', 'amr ashraf', '', '01092237499', NULL, NULL, 'Smouha', NULL, 'egypt', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`id`, `user_id`, `ip_address`, `device_type`, `browser_details`, `last_login`) VALUES
(15, 6, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-01 01:24:47'),
(16, 6, '::1', 'Windows 7', 'Chrome73.0.3683.86', '2019-04-01 01:43:52');

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
