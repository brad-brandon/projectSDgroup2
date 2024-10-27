-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2024 at 10:01 AM
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
-- Table structure for table `class_schedule`
--

CREATE TABLE `class_schedule` (
  `id` int NOT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `time_slot` time DEFAULT NULL,
  `class_name` varchar(100) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `day_of_week`, `time_slot`, `class_name`, `start_time`, `end_time`) VALUES
(2, 'Wednesday', '10:00:00', 'Hypertrophy', '10:00:00', '15:00:00'),
(3, 'Friday', '10:00:00', 'HIIT', '10:00:00', '13:00:00'),
(4, 'Sunday', '10:00:00', 'HIIT', '10:00:00', '13:30:00'),
(5, 'Tuesday', '14:00:00', 'Powerlifting', '14:00:00', '17:00:00'),
(6, 'Thursday', '14:00:00', 'Powerlifting', '14:00:00', '17:00:00'),
(7, 'Saturday', '14:00:00', 'Hypertrophy', '14:00:00', '15:30:00'),
(8, 'Monday', '16:00:00', 'ZUMBA', '16:00:00', '18:00:00'),
(9, 'Wednesday', '16:00:00', 'ZUMBA', '16:00:00', '19:00:00'),
(10, 'Friday', '16:00:00', 'HIIT', '16:00:00', '19:00:00'),
(11, 'Saturday', '16:00:00', 'ZUMBA', '16:00:00', '17:00:00'),
(12, 'Sunday', '16:00:00', 'Hypertrophy', '16:00:00', '20:00:00'),
(13, 'Monday', '18:00:00', 'ZUMBA', '18:00:00', '20:00:00'),
(14, 'Tuesday', '18:00:00', 'Powerlifting1', '18:00:00', '20:00:00'),
(15, 'Thursday', '18:00:00', 'ZUMBA', '18:00:00', '22:00:00'),
(16, 'Saturday', '18:00:00', 'Hypertrophy', '18:00:00', '22:00:00'),
(17, 'Monday', '21:00:00', 'Hypertrophy', '21:00:00', '23:00:00'),
(18, 'Tuesday', '20:00:00', 'HIIT', '20:00:00', '22:00:00'),
(19, 'Wednesday', '20:30:00', 'Powerlifting', '20:30:00', '23:00:00'),
(20, 'Friday', '22:00:00', 'Hypertrophy', '22:00:00', '23:00:00'),
(21, 'Sunday', '21:00:00', 'ZUMBA', '21:00:00', '23:00:00'),
(24, 'Monday', '10:00:00', 'class monday', '10:00:00', '14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(5, 'WONG TIEN FUNG', 'toman9632@gmail.com', '123', '2024-10-08 14:37:51'),
(6, 'WONG TIEN FUNG', 'toman9632@gmail.com', 'gym good\r\n', '2024-10-08 14:39:05'),
(7, 'WONG TIEN FUNG', 'toma2n9632@gmail.com', 'asd', '2024-10-08 14:58:45'),
(11, 'WONG TIEN FUNG', 'toman9632@gmail.com', 'asd', '2024-10-09 05:05:28'),
(12, 'GuestWong', 'vodol17030@craftapk.com', 'Testing 9/10/2024 gym', '2024-10-09 05:14:38'),
(13, 'GuestWong', 'vodol17030@craftapk.com', 'Testing 9/10/2024 gym', '2024-10-09 05:15:29'),
(14, 'Ali', 'vodol17030@craftapk.com', 'Gym test', '2024-10-09 05:18:19'),
(15, 'Edmund', 'vodol17030@craftapk.com', 'Hi my name is vodol.', '2024-10-09 05:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int NOT NULL,
  `membership_type` enum('normal','student','advanced') NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `membership_type`, `price`) VALUES
(1, 'student', 80.00),
(2, 'normal', 120.00),
(3, 'advanced', 280.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `bill_name` varchar(255) DEFAULT NULL,
  `bill_description` text,
  `bill_to` varchar(255) DEFAULT NULL,
  `bill_email` varchar(255) DEFAULT NULL,
  `bill_phone` varchar(15) DEFAULT NULL,
  `bill_status` int DEFAULT NULL,
  `bill_payment_status` int DEFAULT NULL,
  `bill_payment_channel` varchar(50) DEFAULT NULL,
  `bill_payment_amount` decimal(10,2) DEFAULT NULL,
  `bill_payment_invoice_no` varchar(50) DEFAULT NULL,
  `bill_payment_date` datetime DEFAULT NULL,
  `transaction_charge` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `bill_name`, `bill_description`, `bill_to`, `bill_email`, `bill_phone`, `bill_status`, `bill_payment_status`, `bill_payment_channel`, `bill_payment_amount`, `bill_payment_invoice_no`, `bill_payment_date`, `transaction_charge`) VALUES
(5, 'testwebsite', '1', 'WONG TIEN FUNG', 'coolmangame5390@gmail.com', '01129639253', 1, 1, 'FPX B2C', 1.00, 'TP2410213276455101', '2024-10-21 07:37:26', 1.00),
(6, 'testwebsite', '1', 'WONG TIEN FUNG', 'toman9632@gmail.com', '01129639253', 1, 1, 'FPX B2C', 1.00, 'TP2410213819094464', '2024-10-21 11:35:00', 1.00);

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
(1, 'wongtienfung12', 'toman9632@gmail.com', '$2y$10$JTB3X28mkoM.u3nsvDCiVujrgYdZOm4dR6C7v5YXWwD8uXp2x5GoG', '01129639252', NULL, 1, '2024-08-31 21:47:51', 'user', '85adbf29bcf2d24ec92b270fc4d71257', '2024-10-08 22:57:24'),
(5, 'Edmund Heng', 'edmund@gmail.com', '$2y$10$5/Ibp4m/pwpCIp9rQJqYO.C62s3pQX6bMS1NyGiikCwBnU8p31D4i', '0123456781', '94b718d6cb0c3e3b772e9cdb95a41545', 1, '2024-09-01 13:48:09', 'staff', NULL, NULL),
(6, 'Alen Lim', 'alen@gmail.com', '$2y$10$5jgEwPlaROF34kwAjqzzmu3.A0aPzpm9hYpKhhAiN18tdc3Ox41ZK', '01129639256', '1f0519e82659d89a1cb566431b059ed4', 1, '2024-09-01 15:54:41', 'admin', NULL, NULL),
(8, 'WONG TIEN FUN', 'adminwongtest@gmail.com', '$2y$10$EiccIQcFJ8UvK26CD8b6jutg24BREj4nmRAlRhNgIKhju3M/cndM6', '01129639253', '959138155f5e76e28efec67a99ba636e', 1, '2024-09-08 10:40:09', 'admin', 'e8c7db85f8e9d6b92765049e421258e7', '2024-09-11 01:40:30'),
(12, 'Ash', 'looqingyao123@gmail.com', '$2y$10$FRq4Kzn8FRYhor3.d7tqPuj1q.Ubo.fObu7L/NrVWA0DokqZXMqB6', '01129639250', '5eb113e23a59e257685b516c8f7868b0', 0, '2024-09-11 05:11:31', 'user', NULL, NULL),
(13, 'Airil', 'Airil123@gmail.com', '$2y$10$jgt6gbtoFd/4ZVYG.Iiu4Ob1sy.NDCCikoRkvemO24WpN1IaRrrr.', '01129631234', 'd7a53b09b50e552d461a4280b47114dc', 0, '2024-09-11 05:14:19', 'user', NULL, NULL),
(14, 'Lily', 'lily@gmail.com', '$2y$10$fQi0yCIBqCUJHTeVyWflf.uZzEbTHspR/xLIqktcIUb357cPNClnG', '012-9876543', '26528e18e23bec119bde4b9207323bc5', 0, '2024-09-11 06:33:00', 'user', NULL, NULL),
(21, 'WONG TIEN FUNG', 'toman19632@gmail.com', '$2y$10$GtWirIYsvHtmnjxJyLrdLOnOBJb9aUiWdsxyXHAWk8bfS6w2EzQlC', '01129639253', NULL, 0, '2024-10-07 01:27:06', 'staff', NULL, NULL),
(25, 'WONG TIEN FUNG123', 'toman1239632@gmail.com', '$2y$10$gd0FvNo4twkz0JiBxO7CGeS7JfG.tF/h/etWTYb3AER43/GJ/BBkq', '01129639253', NULL, 1, '2024-10-09 04:25:06', 'staff', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_schedule`
--
ALTER TABLE `class_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `class_schedule`
--
ALTER TABLE `class_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
