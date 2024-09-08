-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2024 at 06:55 AM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fasttrack_gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` int NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phoneNo`, `verification_token`, `verified`, `created_at`, `user_type`) VALUES
(1, 'tien fung', 'toman9632@gmail.com', '$2y$10$r7/7odfPNoucR/TPuXWmVOTfatbeJBneJqOzXEga9ynjI2n8Mo1iS', 0, NULL, 1, '2024-08-31 21:47:51', 'user'),
(4, 'Eren Yeager', 'eren@gmail.com', '$2y$10$d..vLKmsdbvLS1ggtlSg0uHmSOPs4awoa1lXNi7lo9xs3cFoH.0yS', 0, 'f3f7f51a7c4a4dd9f4b08781757d8313', 1, '2024-09-01 13:44:46', 'user'),
(5, 'Edmund Heng', 'edmund@gmail.com', '$2y$10$Nc1sA4/O8seTCKB2yKsUy.iEGxxA3etCD8ZNiX8ytI8Cl0DGrFUc2', 0, '94b718d6cb0c3e3b772e9cdb95a41545', 1, '2024-09-01 13:48:09', 'staff'),
(6, 'Alen Lim', 'alen@gmail.com', '$2y$10$5jgEwPlaROF34kwAjqzzmu3.A0aPzpm9hYpKhhAiN18tdc3Ox41ZK', 0, '1f0519e82659d89a1cb566431b059ed4', 1, '2024-09-01 15:54:41', 'admin');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;