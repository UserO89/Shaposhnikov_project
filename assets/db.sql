SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `course_company`;
USE `course_company`;

-- Drop tables in dependency order
DROP TABLE IF EXISTS `user_courses`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;

-- `course_company`

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$I975snqm8W0wyU8OApJns.v7BLjY2jvsPCDOW7hKUji1HNJ4es4ze', 'Admin', 'User', 'admin', '2025-06-02 20:54:45', '2025-06-14 22:47:13'),
(2, 'user2', 'user2@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyza', 'Anna', 'Ivanova', 'student', '2025-01-19 19:44:41', '2025-06-11 22:55:41'),
(3, 'maria_t', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Maria', 'Thompson', 'teacher', '2025-06-02 20:54:45', '2025-06-11 18:43:58'),
(4, 'jonas_r', 'jonas@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jonas', 'Rivers', 'student', '2025-06-02 20:54:45', '2025-06-02 20:54:45'),
(5, 'nina_b', 'nina@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nina', 'Brown', 'student', '2025-06-02 20:54:45', '2025-06-11 18:44:06'),
(6, 'user6', 'user6@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyza', 'Petr', 'Smirnov', 'student', '2025-03-05 16:35:42', '2025-06-11 22:55:42'),
(7, 'ipek_bits', 'ipekbits@ipek.bits', '$2y$10$QQWsJWYv41BcWuySTCRblu7zVDvk6/6DtPyYeJv0r5wGgfncdYgPG', 'ipek', 'bits', 'admin', '2025-06-11 19:47:56', '2025-06-13 16:16:02'),
(8, 'user8', 'user8@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyza', 'Olga', 'Volkova', 'teacher', '2025-04-11 00:50:42', '2025-06-11 22:55:42'),
(9, 'user9', 'user9@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyza', 'Dmitry', 'Kuznetsov', 'student', '2025-05-28 03:30:42', '2025-06-11 22:55:42'),
(10, 'user10', 'user10@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyza', 'Elena', 'Popova', 'admin', '2024-10-01 16:05:42', '2025-06-11 22:55:42'),
(23, 'simpleUser', 'simple_user@example.com', '$2y$10$3X.Qu.3n445c7wVQVC.FieZxmd3Ss3IwGlcEYQx.1Ipy.Axj5zbqW', 'simple', 'user', 'student', '2025-06-14 23:39:58', '2025-06-14 23:39:58');


-- ALTER TABLE `users`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `username` (`username`),
--   ADD UNIQUE KEY `email` (`email`);
-- ALTER TABLE `users`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;


CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in hours',
  `level` enum('beginner','intermediate','advanced') NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courses` (`id`, `title`, `description`, `price`, `duration`, `level`, `category_id`, `teacher_id`, `image_url`, `is_published`, `created_at`, `updated_at`) VALUES
(4, 'Web Development Bootcamp', 'Comprehensive guide to HTML, CSS, JavaScript and deploying real websites.', 139.00, 56, 'beginner', 1, NULL, '/Shaposhnikov_project/assets/img/courses/Web_development.jpeg', 0, '2025-06-02 20:55:42', '2025-06-14 22:44:58'),
(5, 'Python for Data Science', 'Master Python basics, data analysis, visualization, and machine learning.', 189.00, 70, 'intermediate', 2, NULL, '/Shaposhnikov_project/assets/img/courses/Python.jpg', 0, '2025-06-02 20:55:42', '2025-06-11 22:37:20'),
(6, 'UI/UX Design Essentials', 'Learn design thinking, wireframing, prototyping, and user testing.', 119.00, 42, 'beginner', 3, 3, '/Shaposhnikov_project/assets/img/courses/UI_UX.avif', 0, '2025-06-02 20:55:42', '2025-06-11 22:28:58'),
(7, 'Digital Marketing Basics', 'Get started with SEO, social media, email marketing, and Google Ads.', 0.00, 35, 'beginner', 4, 4, '/Shaposhnikov_project/assets/img/courses/Digital_marketing.jpg', 0, '2025-06-02 20:55:42', '2025-06-11 22:35:08'),
(8, 'React & Frontend Engineering', 'Dive deep into React, hooks, APIs, and building scalable frontends.', 169.00, 63, 'advanced', 1, NULL, '/Shaposhnikov_project/assets/img/courses/React_frontend.webp', 0, '2025-06-02 20:55:42', '2025-06-11 22:33:42'),
(9, 'Agile Project Management', 'Learn Agile principles, Scrum, and how to manage software projects.', 129.00, 49, 'intermediate', 4, 4, '/Shaposhnikov_project/assets/img/courses/Agile_pm.jpg', 0, '2025-06-02 20:55:42', '2025-06-11 22:32:32'),
(10, 'Cybersecurity Fundamentals', 'Understand security concepts, networks, and threat mitigation.', 139.00, 42, 'intermediate', 1, NULL, '/Shaposhnikov_project/assets/img/courses/Cybersecurity_fundamentals.png', 0, '2025-06-02 20:55:42', '2025-06-11 22:31:33'),
(11, 'Cloud Computing with AWS', 'Get introduced to AWS services, deployment, and cloud architecture.', 179.00, 56, 'advanced', 1, NULL, '/Shaposhnikov_project/assets/img/courses/Cloud_computing_AWS.jpeg', 0, '2025-06-02 20:55:42', '2025-06-11 22:30:09'),
(12, 'Mobile App Development', 'Build native mobile applications for Android and iOS.', 169.00, 63, 'intermediate', 1, NULL, '/Shaposhnikov_project/assets/img/courses/Mobile_development.jpg', 0, '2025-06-02 20:55:42', '2025-06-11 22:28:10'),
(13, 'Business Analytics', 'Analyze business data and make data-driven decisions.', 159.00, 42, 'advanced', 4, 4, '/Shaposhnikov_project/assets/img/courses/Business_analytics.jpeg', 0, '2025-06-02 20:55:42', '2025-06-11 22:25:55'),
(14, 'English for Professionals', 'Improve business communication and writing in English.', 89.00, 28, 'beginner', 4, 4, '/Shaposhnikov_project/assets/img/courses/English_for_professionals.jpg', 0, '2025-06-02 20:55:42', '2025-06-11 22:23:58'),
(15, 'AI and Machine Learning', 'Explore the core concepts of artificial intelligence and ML.', 189.00, 70, 'advanced', 2, NULL, '/Shaposhnikov_project/assets/img/courses/AI_ML.webp', 0, '2025-06-02 20:55:42', '2025-06-14 19:24:13'),
(20, 'ascxasc', 'ascasc', 0.01, 0, 'beginner', NULL, NULL, '', 0, '2025-06-14 20:57:52', '2025-06-14 20:57:52');


-- ALTER TABLE `courses`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `category_id` (`category_id`),
--   ADD KEY `teacher_id` (`teacher_id`);
-- ALTER TABLE `courses`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
-- ALTER TABLE `courses`
--   ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
--   ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- `user_courses`
-- -------------------

DROP TABLE IF EXISTS `user_courses`;

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `progress` int(11) DEFAULT 0,
  `last_accessed` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `is_completed`, `progress`, `last_accessed`, `created_at`) VALUES
(4, 1, 7, 0, 0, '2025-06-13 17:00:23', '2025-06-13 17:00:23'),
(5, 1, 9, 0, 0, '2025-06-10 16:18:46', '2025-06-14 16:18:46'),
(6, 1, 8, 0, 0, '2025-06-9 17:02:29', '2025-06-14 17:02:29'),
(7, 1, 4, 0, 0, '2025-06-12 17:02:49', '2025-06-14 17:02:49'),
(8, 1, 15, 0, 0, '2025-06-13 17:03:34', '2025-06-14 17:03:34'),
(9, 1, 10, 0, 0, '2025-06-15 17:03:57', '2025-06-14 17:03:57'),
(11, 1, 11, 0, 0, '2025-06-01 20:08:07', '2025-06-14 20:08:07'),
(12, 1, 14, 0, 0, '2025-06-14 21:53:30', '2025-06-14 21:53:30'),
(13, 1, 6, 0, 0, '2025-06-14 21:54:07', '2025-06-14 21:54:07'),
(14, 1, 13, 0, 0, '2025-06-14 22:22:43', '2025-06-14 22:22:43'),
(17, 23, 4, 0, 0, '2025-06-14 23:40:07', '2025-06-14 23:40:07'),
(18, 23, 8, 0, 0, '2025-06-14 23:40:16', '2025-06-14 23:40:16'),
(19, 23, 14, 0, 0, '2025-06-14 23:40:25', '2025-06-14 23:40:25');

-- ALTER TABLE `user_courses`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `user_id` (`user_id`),
--   ADD KEY `course_id` (`course_id`);
-- ALTER TABLE `user_courses`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
-- ALTER TABLE `user_courses`
--   ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
--   ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

-- "categories"
-- ---------------

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `created_at`) VALUES
(1, 'Web Development', 'Learn modern web development technologies and frameworks', 'web-development', '2025-06-02 20:54:45'),
(2, 'Data Science', 'Master data analysis, visualization, and machine learning', 'data-science', '2025-06-02 20:54:45'),
(3, 'Design', 'UI/UX design and digital art courses', 'design', '2025-06-02 20:54:45'),
(4, 'Business', 'Business, marketing, and management courses', 'business', '2025-06-02 20:54:45');

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- `reviews`
-- ----------------------------
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reviews` (`id`, `course_id`, `user_id`, `rating`, `text`, `created_at`) VALUES
(10, 4, 2, 5, 'This Web Development Bootcamp is excellent! Very insightful and well-explained.', '2025-02-17 10:09:27'),
(11, 4, 3, 4, 'The web development course has good content, but could use more practical tasks.', '2025-03-02 09:48:27'),
(12, 5, 4, 5, 'Fantastic course on Python for Data Science! Highly recommend for anyone interested in this field.', '2024-12-31 19:37:27'),
(13, 5, 1, 4, 'Solid introduction to Python for data science. Learned a lot from this course!', '2025-01-18 21:45:27'),
(14, 6, 5, 5, 'UI/UX Design Essentials covered perfectly. Very practical and easy to understand!', '2025-04-21 03:00:27'),
(15, 6, 2, 4, 'The UI/UX course is good, but I wish there were more real-world case studies.', '2025-06-06 22:51:27'),
(16, 7, 3, 5, 'Digital Marketing Basics was very informative and helpful for beginners.', '2025-04-25 10:16:27'),
(17, 8, 4, 5, 'React & Frontend Engineering was challenging but incredibly rewarding. A great deep dive!', '2025-05-02 07:54:27'),
(18, 8, 1, 4, 'Useful course on React, but some parts felt rushed.', '2025-04-14 09:44:27'),
(19, 9, 5, 5, 'Agile Project Management insights were very valuable. Clear and concise, highly recommend!', '2024-12-25 02:04:27'),
(20, 9, 2, 4, 'Good overview of Agile, but some parts could be more detailed.', '2025-02-05 06:11:27'),
(21, 7, 5, 4, 'Cybersecurity Fundamentals provided a good overview. Enjoyed the practical tips.', '2025-06-11 22:56:27'),
(22, 8, 2, 5, 'Cloud Computing with AWS was excellent! Very comprehensive and easy to follow.', '2025-06-11 22:56:27'),
(23, 4, 1, 5, 'such a perfect course for beginners!', '2025-06-14 23:37:41'),
(24, 14, 23, 5, 'This course helped me to learn English more, than 11 years at school!', '2025-06-14 23:41:08'),
(25, 8, 23, 5, 'the best course from all I&#39;ve ever tried in frontend', '2025-06-15 00:00:55');

-- ALTER TABLE `reviews`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `course_id` (`course_id`),
--   ADD KEY `user_id` (`user_id`);
-- ALTER TABLE `reviews`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
-- ALTER TABLE `reviews`
--   ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
--   ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS = 1;