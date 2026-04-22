-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 06:35 PM
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
-- Database: `skill_exchange_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE `exchanges` (
  `id` int(11) NOT NULL,
  `requester_id` int(11) DEFAULT NULL,
  `skill_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `offer_skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `category`, `description`, `offer_skill_id`) VALUES
(12, 10, 'Php', 'Tech', 'i am good at php\r\n', 0),
(90, 4, 'Mastering Java Collections', 'Tech', 'Deep dive into Lists, Sets, and Maps.', 0),
(92, 7, 'SQL Query Optimization', 'Tech', 'How to write efficient queries in MySQL.', 0),
(93, 8, 'Figma UI/UX Design', 'Creative Design', 'Prototyping and designing mobile interfaces.', 0),
(94, 9, 'Spoken English Practice', 'Languages', 'Daily conversation practice to improve fluency.', 0),
(95, 10, 'Introduction to Machine Learning', 'Tech', 'Understanding supervised learning algorithms.', 0),
(96, 10, 'Adobe Creative Cloud', 'Design', 'Master the essentials of Photoshop and Illustrator to create professional digital graphics and layouts.', 0),
(97, 10, 'Typography', 'Design', 'Master the art of arranging type to create visually balanced, readable, and impactful designs.', 0),
(98, 31, 'Advanced c++', 'Language', 'I am master at this language.', 0),
(99, 10, 'java', 'Language', 'sert', 0),
(100, 10, 'english', 'Language', 'xyz', 0),
(101, 32, 'english', 'Language', 'xyz', 0);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `skill_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swap_requests`
--

CREATE TABLE `swap_requests` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `swap_requests`
--

INSERT INTO `swap_requests` (`id`, `sender_id`, `receiver_id`, `post_id`, `status`, `created_at`) VALUES
(5, 9, 10, 12, 'accepted', '2026-04-21 19:02:47'),
(15, 31, 10, 97, 'accepted', '2026-04-22 03:02:15'),
(16, 10, 9, 94, 'pending', '2026-04-22 03:32:04'),
(17, 10, 8, 93, 'pending', '2026-04-22 03:59:39'),
(18, 32, 10, 99, 'accepted', '2026-04-22 06:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user',
  `fullname` varchar(100) NOT NULL,
  `skill_teach` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `bio`, `created_at`, `role`, `fullname`, `skill_teach`) VALUES
(3, 'dfg', 'waterlily38@gmail.com', '$2y$10$I2FGPJJnbVJVf6HWtNAIvORTIL/k32ty3stGnEXZZaIP3.t0GsZwi', NULL, '2026-04-21 10:14:33', 'user', 'asdf', 'sdf'),
(4, 'toma', 'waterlily8@gmail.com', '$2y$10$5MC5zzbT223/krM1I4/rsOt6vHu0nn81qSEkp8Rd4KBv8reKEbUC6', NULL, '2026-04-21 10:25:59', 'user', 'tomalika', 'java'),
(7, 'admin', 'abc@gmail.com', '$2y$10$1rHpYhWQLXoG0Z0WWby/tOGkIZBMUYMxOeZpCaimTfCjp6ubfmJXK', NULL, '2026-04-21 13:46:55', 'admin', 'Admin', 'java'),
(8, 'lillyrao20', 'lily4738@gmail.com', '$2y$10$DCcyUIgLntzLC119el6QP.8XlQQ1yBY3tcKLrKzV0tcOaGS98OF.y', NULL, '2026-04-21 18:37:28', 'user', 'lilly rao', 'Design'),
(9, 'wed04', 'wed12@gmail.com', '$2y$10$vlH2Pgg/iW8sNe5evK7poOe5.ffuP3JBb3v25ZNUUDiVXEkdx16iW', NULL, '2026-04-21 18:59:58', 'user', 'Wed Addam', 'Logo design'),
(10, 'shel09', 'shel@gmail.com', '$2y$10$tJ0hurjDrVUjA2xvm.pES.a/ei92ptgvShK0c98bxphnzdL3rCluG', NULL, '2026-04-21 19:01:08', 'user', 'Sheldon Cooper', 'Math'),
(31, 'tanu', 'taniya09@gmail.com', '$2y$10$cIsy.0npr7teQHfhfu3YoOZBIgPHObllZq./Bz0M4pc0Sj2LHHci.', NULL, '2026-04-22 03:00:24', 'user', 'Taniya', 'Math'),
(32, 'taniya', 'taniya@gmail.com', '$2y$10$QZQAkhFQlwKFcYQfejHVA.X0fkM1eY3w6lJri1fQ8PXWzpjlNOIZK', NULL, '2026-04-22 06:11:31', 'user', 'Taniya', 'Math');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requester_id` (`requester_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `swap_requests`
--
ALTER TABLE `swap_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender` (`sender_id`),
  ADD KEY `fk_receiver` (`receiver_id`),
  ADD KEY `fk_post_request` (`post_id`);

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
-- AUTO_INCREMENT for table `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `swap_requests`
--
ALTER TABLE `swap_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD CONSTRAINT `exchanges_ibfk_1` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `exchanges_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `swap_requests`
--
ALTER TABLE `swap_requests`
  ADD CONSTRAINT `fk_post_request` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
