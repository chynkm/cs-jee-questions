CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_type` enum('IIT','NEET','General','Eamcet','NTSE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `complexity` tinyint(2) NOT NULL DEFAULT '0',
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
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Physics'),
(2, 'Chemistry'),
(3, 'Mathematics'),
(4, 'English'),
(5, 'Social Studies'),
(6, 'Competitive General - Arithmetic'),
(7, 'Competitive General - Reasoning'),
(8, 'Competitive General - Mental ability');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin',    'secret',   '2017-02-04 08:10:04');
