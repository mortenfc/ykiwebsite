-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2019 at 04:52 AM
-- Server version: 8.0.16
-- PHP Version: 7.3.7

use demo;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--


-- --------------------------------------------------------

--
-- Table structure for table `users_with_email_verification`
--

CREATE TABLE `users_with_email_verification` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_with_email_verification`
--

INSERT INTO `users_with_email_verification` (`id`, `name`, `email`, `user_type`, `verified`, `token`, `password`) VALUES
(21, 'Morten Fjord Christensen', 'mortenfjord@hotmail.com', 'user', 1, '1fa1408e8a6d437df1ed9987eb99808e948c2ae7f06893f6a122c9641560e9e6aba1aeec1d7e6964c831b0e4ee044889001b', '$2y$10$W3ZhvBUHl.QnCTrrEhxpR.YWweu.AzRZsqPHP2mBR.AqcTnowrnEW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_with_email_verification`
--
ALTER TABLE `users_with_email_verification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_with_email_verification`
--
ALTER TABLE `users_with_email_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
