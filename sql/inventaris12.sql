-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 03:05 PM
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
-- Database: `inventaris12`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Alat Tulis'),
(2, 'Elektronik'),
(3, 'Kendaraan');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$VI0kQym09ew7kgHjmJ7dJ.t94ZdEmb5zLaDexOyus7Hj6/2JOHBxu', 'admin', '2025-11-29 12:23:49'),
(2, 'alex', 'alex@gmail.com', '$2y$10$JwsQyrNErDtBaljdOrxXxeS9j0LuqRVBrmY.yHiky9alpNkPGq51K', 'karyawan', '2025-12-01 02:23:18'),
(3, 'uhgyfy', 'ggyg@gmail.com', '$2y$10$jcTzI/GzygcDPHWP/M64N.rNtD7xcQAoxnRBfclfaGFu0po.o6yqK', 'karyawan', '2025-12-07 15:13:32'),
(4, 'Adipati Candra', 'adipati@gmail', '$2y$10$j/Q97my3nhkyruKZhhfB1e34YloXJ4.5WP7JXmx63FxjZ95/JDXZG', 'karyawan', '2025-12-08 02:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `condition` enum('bagus','rusak') NOT NULL DEFAULT 'bagus'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `quantity`, `description`, `condition`) VALUES
(1, 1, 'Pulpen', 59, 'ok', 'bagus'),
(2, 1, 'Kertas', 758, 'ok', 'bagus'),
(4, 1, 'aaaa', 1, 'sdf', 'bagus'),
(6, 1, 'Cortape', 12, 'sdf', 'rusak'),
(7, 1, 'Tinta', 9, 'ok', 'bagus'),
(8, 1, 'rrrrrrrrrrr', 122, 'asdfdsf', 'rusak'),
(10, 1, 'weqwfwe', 122, 'dewwe', 'bagus'),
(11, 1, 'i7y', 1, 'jiuj', 'rusak'),
(12, 2, 'Laptop', 5, 'ok', 'bagus'),
(13, 3, 'Mobil', 5, 'ok', 'rusak'),
(14, 1, 'abc', 1, 'abc', 'bagus');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` enum('pending','approved','rejected','returned') DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `employee_id`, `item_id`, `quantity`, `status`, `requested_at`, `processed_at`) VALUES
(1, 2, 7, 1, 'returned', '2025-12-01 02:34:34', '2025-12-01 18:41:21'),
(2, 2, 12, 2, 'returned', '2025-12-07 16:44:44', '2025-12-07 23:52:03'),
(3, 2, 13, 2, 'returned', '2025-12-08 02:47:09', '2025-12-08 09:48:07'),
(4, 2, 1, 6, 'approved', '2025-12-24 11:52:57', '2025-12-24 18:54:35'),
(5, 2, 1, 12, 'approved', '2025-12-24 11:53:09', '2025-12-24 18:54:35'),
(6, 2, 2, 200, 'approved', '2025-12-24 11:53:18', '2025-12-24 18:54:34'),
(7, 2, 12, 2, 'approved', '2025-12-24 11:53:28', '2025-12-24 18:54:33'),
(8, 2, 7, 3, 'approved', '2025-12-24 11:53:48', '2025-12-24 18:54:32'),
(9, 2, 2, 242, 'approved', '2025-12-24 11:55:04', '2025-12-24 18:56:53'),
(10, 2, 1, 23, 'approved', '2025-12-24 11:56:02', '2025-12-24 18:56:52'),
(11, 2, 12, 3, 'approved', '2025-12-24 11:56:14', '2025-12-24 18:56:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
