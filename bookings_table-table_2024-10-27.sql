-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2024 at 04:34 PM
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
-- Table structure for table `bookings_table`
--

CREATE TABLE `bookings_table` (
  `booking_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `id` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending',
  `day_of_week` varchar(10) DEFAULT NULL,
  `time_slot` time DEFAULT NULL,
  `class_name` varchar(100) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings_table`
--

INSERT INTO `bookings_table` (`booking_id`, `user_id`, `id`, `status`, `day_of_week`, `time_slot`, `class_name`, `start_time`, `end_time`) VALUES
(2, NULL, 2, 'pending', 'Wednesday', '10:00:00', 'Hypertrophy', '10:00:00', '15:00:00'),
(3, NULL, 3, 'pending', 'Friday', '10:00:00', 'HIIT', '10:00:00', '13:00:00'),
(4, NULL, 4, 'pending', 'Sunday', '10:00:00', 'HIIT', '10:00:00', '13:30:00'),
(5, NULL, 5, 'pending', 'Tuesday', '14:00:00', 'Powerlifting', '14:00:00', '17:00:00'),
(6, NULL, 6, 'pending', 'Thursday', '14:00:00', 'Powerlifting', '14:00:00', '17:00:00'),
(7, NULL, 7, 'pending', 'Saturday', '14:00:00', 'Hypertrophy', '14:00:00', '15:30:00'),
(8, NULL, 8, 'pending', 'Monday', '16:00:00', 'ZUMBA', '16:00:00', '18:00:00'),
(9, NULL, 9, 'pending', 'Wednesday', '16:00:00', 'ZUMBA', '16:00:00', '19:00:00'),
(10, NULL, 10, 'pending', 'Friday', '16:00:00', 'HIIT', '16:00:00', '19:00:00'),
(11, NULL, 11, 'pending', 'Saturday', '16:00:00', 'ZUMBA', '16:00:00', '17:00:00'),
(12, NULL, 12, 'pending', 'Sunday', '16:00:00', 'Hypertrophy', '16:00:00', '20:00:00'),
(13, NULL, 13, 'pending', 'Monday', '18:00:00', 'ZUMBA', '18:00:00', '20:00:00'),
(14, NULL, 14, 'pending', 'Tuesday', '18:00:00', 'Powerlifting1', '18:00:00', '20:00:00'),
(15, NULL, 15, 'pending', 'Thursday', '18:00:00', 'ZUMBA', '18:00:00', '22:00:00'),
(16, NULL, 16, 'pending', 'Saturday', '18:00:00', 'Hypertrophy', '18:00:00', '22:00:00'),
(17, NULL, 17, 'pending', 'Monday', '21:00:00', 'Hypertrophy', '21:00:00', '23:00:00'),
(18, NULL, 18, 'pending', 'Tuesday', '20:00:00', 'HIIT', '20:00:00', '22:00:00'),
(19, NULL, 19, 'pending', 'Wednesday', '20:30:00', 'Powerlifting', '20:30:00', '23:00:00'),
(20, NULL, 20, 'pending', 'Friday', '22:00:00', 'Hypertrophy', '22:00:00', '23:00:00'),
(21, NULL, 21, 'pending', 'Sunday', '21:00:00', 'ZUMBA', '21:00:00', '23:00:00'),
(24, NULL, 24, 'pending', 'Monday', '10:00:00', 'class monday', '10:00:00', '14:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings_table`
--
ALTER TABLE `bookings_table`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `class_id` (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
