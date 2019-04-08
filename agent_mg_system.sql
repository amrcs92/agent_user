-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2019 at 02:16 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `agent_name`, `company_name`, `company_logo`, `phone`, `mobile1`, `mobile2`, `address`, `postal_code`, `country`, `state`) VALUES
(1, 'user123', 'user@gmail.com', '$2y$10$OdICwIYSw8X9AGz9aLQPuOoV8Wsqg4X1Lpq609nKpVByLXPSgR2CS', 'user agent', 'User Agent', '', '022234498', '01234566789', '01234566789', 'Al haram', NULL, 'egypt', 'cairo');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
