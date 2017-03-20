DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_type` enum('IIT','NEET','General','Eamcet','NTSE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `complexity` tinyint(2) NOT NULL DEFAULT '0',
  `type_of_question` tinyint(2) NOT NULL COMMENT '1: Single Answer, 2: More than one answer, 3: Comprehension, 4: Matrix matching, 5: Integer',
  `topic` int(11) NOT NULL,
  `sub_topic` int(11) NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `question_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_a` longtext COLLATE utf8mb4_unicode_ci,
  `option_a_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_b` longtext COLLATE utf8mb4_unicode_ci,
  `option_b_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_c` longtext COLLATE utf8mb4_unicode_ci,
  `option_c_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_d` longtext COLLATE utf8mb4_unicode_ci,
  `option_d_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci,
  `comments_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `exam_type` (`exam_type`),
  KEY `complexity` (`complexity`),
  KEY `type_of_question` (`type_of_question`),
  KEY `topic` (`topic`),
  KEY `sub_topic` (`sub_topic`)
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
(3, 'Mathematics'),
(4, 'English'),
(5, 'Social Studies'),
(6, 'Competitive General - Arithmetic'),
(7, 'Competitive General - Reasoning'),
(8, 'Competitive General - Mental ability');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin',  'secret', '2017-02-04 08:10:04');