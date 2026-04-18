-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2026 at 12:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_mngt`
--
CREATE DATABASE IF NOT EXISTS `task_mngt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `task_mngt`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `due_date` datetime NOT NULL,
  `priority` tinyint(1) DEFAULT 2 COMMENT '1:Low, 2:Medium, 3:High',
  `status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `due_date`, `priority`, `status`, `created_at`) VALUES
(1, 'Task1', '2026-05-01 12:00:00', 2, 'completed', '2026-04-18 06:41:01'),
(2, 'Task2', '2026-04-18 16:00:00', 3, 'completed', '2026-04-18 06:42:25'),
(3, 'Task3', '2026-04-20 10:00:00', 1, 'completed', '2026-04-18 07:10:31'),
(5, 'Task4', '2026-04-21 10:00:00', 1, 'completed', '2026-04-18 07:18:40'),
(7, 'Task5', '2026-04-18 17:00:00', 1, 'pending', '2026-04-18 08:13:02'),
(8, 'Task6', '2026-04-21 10:00:00', 1, 'pending', '2026-04-18 08:15:56'),
(9, 'Task7', '2026-04-18 15:17:00', 3, 'pending', '2026-04-18 08:17:36'),
(10, 'Task7', '2026-04-18 15:17:00', 3, 'pending', '2026-04-18 08:18:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
