-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 11, 2024 at 06:19 AM
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
  `phoneNo` text,
  `verification_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phoneNo`, `verification_token`, `verified`, `created_at`, `user_type`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Ali', 'toman9632@gmail.com', '$2y$10$zAvbKEzadxxWDj2NT6cR4ux9fXH1nHTOSgHaMFMyDhcUPANrMbYuW', '01129639251', NULL, 1, '2024-08-31 21:47:51', 'user', NULL, NULL),
(4, 'Eren', 'eren@gmail.com', '$2y$10$d..vLKmsdbvLS1ggtlSg0uHmSOPs4awoa1lXNi7lo9xs3cFoH.0yS', '01129639254', 'f3f7f51a7c4a4dd9f4b08781757d8313', 1, '2024-09-01 13:44:46', 'user', NULL, NULL),
(5, 'Edmund Heng', 'edmund@gmail.com', '$2y$10$Nc1sA4/O8seTCKB2yKsUy.iEGxxA3etCD8ZNiX8ytI8Cl0DGrFUc2', '0123456789', '94b718d6cb0c3e3b772e9cdb95a41545', 1, '2024-09-01 13:48:09', 'staff', NULL, NULL),
(6, 'Alen Lim', 'alen@gmail.com', '$2y$10$5jgEwPlaROF34kwAjqzzmu3.A0aPzpm9hYpKhhAiN18tdc3Ox41ZK', '01129639256', '1f0519e82659d89a1cb566431b059ed4', 1, '2024-09-01 15:54:41', 'admin', NULL, NULL),
(8, 'Tien fung', 'adminwongtest@gmail.com', '$2y$10$d0f2k0uqNXzEHQr4XPLS8.fOeNCez.XNIRXJgkW17mvofiOZ9SiNe', '0122293122', '959138155f5e76e28efec67a99ba636e', 1, '2024-09-08 10:40:09', 'admin', 'e8c7db85f8e9d6b92765049e421258e7', '2024-09-11 01:40:30'),
(11, 'Abu', 'fidow26030@obisims.com', '$2y$10$zVBRcONbWM1rJQ/ucZ5YHuIKVj3PtVs.54W4F9Rv0l/Pb1ZcN1fLi', '01129639259', NULL, 1, '2024-09-11 05:06:25', 'user', NULL, NULL),
(12, 'Ash', 'looqingyao123@gmail.com', '$2y$10$FRq4Kzn8FRYhor3.d7tqPuj1q.Ubo.fObu7L/NrVWA0DokqZXMqB6', '01129639250', '5eb113e23a59e257685b516c8f7868b0', 0, '2024-09-11 05:11:31', 'user', NULL, NULL),
(13, 'Airil', 'Airil123@gmail.com', '$2y$10$jgt6gbtoFd/4ZVYG.Iiu4Ob1sy.NDCCikoRkvemO24WpN1IaRrrr.', '01129631234', 'd7a53b09b50e552d461a4280b47114dc', 0, '2024-09-11 05:14:19', 'user', NULL, NULL);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
