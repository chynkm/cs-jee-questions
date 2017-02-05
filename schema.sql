DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_type` enum('IIT','NEET') COLLATE utf8mb4_unicode_ci NOT NULL,
  `complexity` enum('Simple','Medium','Hard') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a_type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b_type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c_type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d_type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` enum('A','B','C','D') COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Physics'),
(2, 'Chemistry'),
(3, 'Mathematics');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin',    'secret',   '2017-02-04 08:10:04');