-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2024 at 06:38 PM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.3.3-1+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webteFinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `QuestionOptions`
--

CREATE TABLE `QuestionOptions` (
  `option_id` int NOT NULL,
  `question_id` int NOT NULL,
  `option_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `QuestionOptions`
--

INSERT INTO `QuestionOptions` (`option_id`, `question_id`, `option_text`) VALUES
(6, 7, 'Dobre'),
(7, 7, 'Zle'),
(8, 8, 'Jozo'),
(9, 8, 'Fero'),
(10, 9, 'Radka'),
(11, 9, 'Jasmina'),
(12, 9, 'Sofia');

-- --------------------------------------------------------

--
-- Table structure for table `Questions`
--

CREATE TABLE `Questions` (
  `question_id` int NOT NULL,
  `user_id` int NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('multiple_choice','open_ended') NOT NULL,
  `active` tinyint(1) NOT NULL,
  `question_code` varchar(5) NOT NULL,
  `options_count` enum('single','multiple') DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `note_at_close` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Questions`
--

INSERT INTO `Questions` (`question_id`, `user_id`, `question_text`, `question_type`, `active`, `question_code`, `options_count`, `created_at`, `updated_at`, `note_at_close`) VALUES
(6, 7, 'Ako sa mas ?', 'open_ended', 1, 'ABCDE', NULL, '2024-04-28 14:27:51', '2024-04-28 14:27:51', NULL),
(7, 7, 'Ako sa mas ? choice', 'multiple_choice', 1, 'EDCBA', NULL, '2024-04-28 14:28:10', '2024-04-28 14:28:10', NULL),
(8, 7, 'Meno Single', 'multiple_choice', 1, '83F6Z', 'single', '2024-04-28 18:19:39', '2024-04-28 18:19:39', NULL),
(9, 7, 'Meno Multiple ', 'multiple_choice', 1, 'XNWHR', 'multiple', '2024-04-28 18:20:02', '2024-04-28 18:20:02', NULL),
(10, 7, 'Meno open', 'open_ended', 1, 'BVJUQ', NULL, '2024-04-28 18:20:25', '2024-04-28 18:20:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Responses`
--

CREATE TABLE `Responses` (
  `response_id` int NOT NULL,
  `question_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `option_id` int DEFAULT NULL,
  `response_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Responses`
--

INSERT INTO `Responses` (`response_id`, `question_id`, `user_id`, `option_id`, `response_text`, `created_at`) VALUES
(4, 6, 7, NULL, 'D', '2024-04-28 15:23:56'),
(5, 7, 7, 7, '', '2024-04-28 15:24:11'),
(6, 6, 7, NULL, 'QWE', '2024-04-28 15:25:58'),
(7, 6, NULL, NULL, 'DDD', '2024-04-28 15:26:11'),
(8, 6, NULL, NULL, 'Jozo', '2024-04-28 15:31:50'),
(9, 6, NULL, NULL, 'A', '2024-04-28 15:33:48'),
(10, 6, NULL, NULL, 'BASD', '2024-04-28 15:34:04'),
(11, 7, NULL, 7, '', '2024-04-28 15:34:30'),
(12, 7, NULL, 7, '', '2024-04-28 15:34:38'),
(14, 6, 7, NULL, 'Dovreerere', '2024-04-28 18:34:54'),
(15, 8, 7, 8, '', '2024-04-28 18:35:09'),
(16, 8, 7, 8, '', '2024-04-28 18:37:17'),
(17, 9, 7, 10, NULL, '2024-04-28 18:37:30'),
(18, 9, 7, 11, NULL, '2024-04-28 18:37:30'),
(19, 6, 7, NULL, 'Ahoj', '2024-04-28 18:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `Sessions`
--

CREATE TABLE `Sessions` (
  `session_id` int NOT NULL,
  `session_code` varchar(5) NOT NULL,
  `question_id` int NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL,
  `ended_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(7, 'admin', '$2y$10$SL/RO2YeUqV6DrIAxolfL.YQOhlCX35W.AhlIY4n19k2qm2Y.kioO', 'admin@admin.sk', 'user', '2024-04-27 21:52:32', '2024-04-27 21:52:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `QuestionOptions`
--
ALTER TABLE `QuestionOptions`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Responses`
--
ALTER TABLE `Responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `USER` (`user_id`),
  ADD KEY `QUESTION` (`question_id`),
  ADD KEY `OPTION` (`option_id`);

--
-- Indexes for table `Sessions`
--
ALTER TABLE `Sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `QuestionOptions`
--
ALTER TABLE `QuestionOptions`
  MODIFY `option_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Questions`
--
ALTER TABLE `Questions`
  MODIFY `question_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Responses`
--
ALTER TABLE `Responses`
  MODIFY `response_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Sessions`
--
ALTER TABLE `Sessions`
  MODIFY `session_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `QuestionOptions`
--
ALTER TABLE `QuestionOptions`
  ADD CONSTRAINT `QuestionOptions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Questions` (`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Questions`
--
ALTER TABLE `Questions`
  ADD CONSTRAINT `Questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Responses`
--
ALTER TABLE `Responses`
  ADD CONSTRAINT `OPTION` FOREIGN KEY (`option_id`) REFERENCES `QuestionOptions` (`option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `QUESTION` FOREIGN KEY (`question_id`) REFERENCES `Questions` (`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `USER` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Sessions`
--
ALTER TABLE `Sessions`
  ADD CONSTRAINT `Sessions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Questions` (`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
