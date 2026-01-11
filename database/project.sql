-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2026 at 09:00 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `surname`, `email`, `country`, `message`, `created_at`) VALUES
(1, 'Dominik', 'Karuc', 'domkaruc@gmail.com', 'hr', 'Veoma lijep fan page <3', '2026-01-11 18:01:03'),
(3, 'Antonio', 'Skara', 'conio1240@fer.hr', 'hr', '', '2026-01-11 19:48:25'),
(4, 'Antonio', 'Skara', 'conio1240@fer.hr', 'hr', 'KKKKKKKK', '2026-01-11 19:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `picture`, `is_archived`, `created_at`, `updated_at`) VALUES
(2, 'Return to Silent Hill movie', 'Return to Silent Hill is an upcoming supernatural psychological horror film and the third installment in the Silent Hill film series. Based on the video game Silent Hill 2, it is co-written and directed by Christophe Gans, and stars Jeremy Irvine and Hannah Emily Anderson.\r\n\r\nAnnounced in October 2022, Return to Silent Hill was shot in Germany and Serbia between April 2023 and February 2024. It is set to be released theatrically in the United States by Cineverse and Iconic Events Releasing on January 23, 2026, and then in France by Metropolitan Filmexport on February 4, 2026.', 'news_1768157614_a03446fc.jpg', 0, '2026-01-11 18:53:34', NULL),
(3, 'SILENT HILL f Wins Steam Awards 2025 for Outstanding Visual Style!', 'SILENT HILL f has won the Steam Awards 2025 for Outstanding Visual Style!\r\n\r\nFollowing last year’s win by SILENT HILL 2, this marks our second consecutive award.\r\n\r\nWe are deeply grateful to everyone who played and supported us.\r\n\r\nThank you for being part of this journey, and we look forward to your continued support for the SILENT HILL series.', 'news_1768157771_0abc8667.png', 0, '2026-01-11 18:56:11', NULL),
(4, 'SILENT HILL 2 50%OFF SALE!', 'The Holiday Sale is here!\r\n\r\nThe acclaimed series classic SILENT HILL 2 is now 50% OFF for a limited time.', 'news_1768157901_204fe636.jpg', 0, '2026-01-11 18:58:21', NULL),
(5, 'Konami wants to make SH game every year', 'Konami is actively reviving the Silent Hill franchise and intends to release a new game in the series approximately every year. The company has announced multiple titles simultaneously to demonstrate its commitment to the series. \r\nKonami\'s \"SH\" (Silent Hill) Plans\r\nAnnual Releases Series producer Motoi Okamoto has stated that Konami aims for about one Silent Hill title per year, including both announced and unannounced projects.\r\nMultiple Projects To ensure a steady flow of content, Konami is working with various third-party developers on different entries, with each game intended to have its \"own distinct flavor\".\r\nOutsourced Development Konami is primarily acting as a publisher for these new titles, outsourcing development to external studios such as Bloober Team (for the Silent Hill 2 remake) and NeoBards Entertainment (for Silent Hill f).', 'news_1768158006_d42ae364.jpg', 0, '2026-01-11 19:00:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Donat', 'Miletic', 'DoKi', 'donatmiletic01@gmail.com', '$2y$10$C.AvJiEhyMT5cJQ6rXR4xO7r3AFo0k852wdZiwra4GXhIrlUaJEPO', 'admin', '2026-01-11 18:31:00'),
(2, 'Dominik', 'Karuc', 'domi2', 'domi2@gmail.com', '$2y$10$pneNAbMWOjMi5yjjTzYcE.YcI6laRNJboBi.a2iZ9hpFNvA3Jsxni', 'user', '2026-01-11 19:05:37'),
(3, 'Antonio', 'Škara', 'tarajekul', 'conio1240@fer.hr', '$2y$10$T0hvWVKLwJCeqmmaBY/rMerBbPs7hnRWTwwwaXeyqQB2lMTez7m7m', 'user', '2026-01-11 19:44:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
