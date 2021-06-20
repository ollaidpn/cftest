-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 22 avr. 2021 à 10:08
-- Version du serveur :  10.3.28-MariaDB-cll-lve
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `c1360792c_fc`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_parent` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `slug`, `category_parent`, `created_at`, `updated_at`) VALUES
(8, 'Informatique', 'Informatique', 'informatique', NULL, '2021-04-13 21:11:52', '2021-04-13 21:11:52'),
(9, 'Développement Web', 'Développement Web', 'developpement-web', 8, '2021-04-13 21:12:23', '2021-04-13 21:12:23'),
(10, 'Banque', 'Formations dans le secteur bancaire et financier', 'banque', NULL, '2021-04-17 16:34:59', '2021-04-17 16:34:59'),
(11, 'Banque & Finance', 'Formations dans le secteur bancaire et financier', 'banque-finance', NULL, '2021-04-17 20:31:30', '2021-04-17 20:31:30');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_formation`
--

CREATE TABLE `categorie_formation` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `formation_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie_formation`
--

INSERT INTO `categorie_formation` (`id`, `categorie_id`, `formation_id`, `created_at`, `updated_at`) VALUES
(260, 9, 186, '2021-04-13 21:24:58', NULL),
(269, 9, 188, '2021-04-14 07:47:11', NULL),
(270, 9, 189, '2021-04-14 08:00:42', NULL),
(271, 9, 190, '2021-04-14 08:13:34', NULL),
(272, 9, 191, '2021-04-14 08:14:27', NULL),
(273, 8, 192, '2021-04-17 12:05:58', NULL),
(274, 9, 193, '2021-04-17 12:16:26', NULL),
(275, 1, 187, '2021-04-17 12:26:55', NULL),
(276, 9, 194, '2021-04-17 20:39:38', NULL),
(277, 8, 195, '2021-04-17 20:58:44', NULL),
(278, 9, 196, '2021-04-17 21:02:03', NULL),
(279, 10, 197, '2021-04-17 21:16:00', NULL),
(286, 1, 199, '2021-04-18 15:04:53', NULL),
(290, 11, 198, '2021-04-18 19:03:15', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_hours` int(11) NOT NULL,
  `presentation_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `timeline` int(11) NOT NULL,
  `practical_informations` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentation_video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_stats` tinyint(4) NOT NULL DEFAULT 0,
  `uri_folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `title`, `image`, `nb_hours`, `presentation_text`, `type`, `price`, `views`, `timeline`, `practical_informations`, `presentation_video`, `show_stats`, `uri_folder`, `slug`, `organization_id`, `created_at`, `updated_at`) VALUES
(198, 'Gestion des conflits d\'intérêts ', 'uploads/formation/2021/April/839405cb-8a81-4d59-ad02-0f1aa78b115e.png', 3, 'Gestion des conflits d\'intérêts', 'private', 0, 0, 0, 'La formation nécessite en moyenne six heure de travail.', '538338353', 1, '/users/128979002/projects/4188200', 'gestion-des-conflits-dinterets', NULL, '2021-04-17 20:43:21', '2021-04-18 13:10:09');

-- --------------------------------------------------------

--
-- Structure de la table `formation_team`
--

CREATE TABLE `formation_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `formation_team`
--

INSERT INTO `formation_team` (`id`, `formation_id`, `team_id`, `created_at`, `updated_at`) VALUES
(28, 198, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `formation_user`
--

CREATE TABLE `formation_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `formation_id` int(11) NOT NULL,
  `process` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actual_content_id` int(11) DEFAULT NULL,
  `actual_content_type` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ended_contents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suspended_quiz` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formation_user`
--

INSERT INTO `formation_user` (`id`, `user_id`, `formation_id`, `process`, `status`, `actual_content_id`, `actual_content_type`, `ended_contents`, `suspended_quiz`, `created_at`, `updated_at`) VALUES
(216, 69, 198, 0, NULL, NULL, NULL, NULL, NULL, '2021-04-17 20:43:21', '2021-04-17 20:43:21'),
(217, 69, 199, 0, NULL, NULL, NULL, NULL, NULL, '2021-04-18 13:02:38', '2021-04-18 13:02:38'),
(218, 73, 198, 13, 'in process', 152, 'video', '[{\"video\":152},{\"video\":153}]', NULL, '2021-04-18 21:46:51', '2021-04-21 13:43:59'),
(219, 72, 198, 20, 'in process', 152, 'video', '[{\"video\":152},{\"video\":153},{\"quiz\":202}]', NULL, '2021-04-18 21:52:29', '2021-04-21 13:25:47');

-- --------------------------------------------------------

--
-- Structure de la table `goals`
--

CREATE TABLE `goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `goals`
--

INSERT INTO `goals` (`id`, `title`, `formation_id`, `created_at`, `updated_at`) VALUES
(81, '1. Se familiariser avec la notion de conflits d\'intérêts au sein de la Banque ;', 198, '2021-04-17 20:51:09', '2021-04-17 20:56:15'),
(82, '2. Mieux appréhender les enjeux liés à la gestion des conflits d\'intérêts au sein de la Banque ;', 198, '2021-04-17 20:51:50', '2021-04-17 20:56:02'),
(83, '3. Mieux connaitre le dispositif de prévention des conflits d\'intérêts au sein de la Banque ;', 198, '2021-04-17 20:52:42', '2021-04-17 20:52:42'),
(84, '4. Mieux connaitre le dispositif de traitement des conflits d\'intérêts au sein de la Banque.', 198, '2021-04-17 20:54:58', '2021-04-17 20:55:07');

-- --------------------------------------------------------

--
-- Structure de la table `infos_systems`
--

CREATE TABLE `infos_systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `system_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Plateforme E-learning',
  `system_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fixe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_header` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `img_slider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'facebook',
  `insta` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'insta',
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'twitter',
  `linkedin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'linkedin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `infos_systems`
--

INSERT INTO `infos_systems` (`id`, `system_name`, `system_email`, `address`, `fixe`, `mobile`, `logo`, `favicon`, `img_header`, `img_slider`, `facebook`, `insta`, `twitter`, `linkedin`, `created_at`, `updated_at`) VALUES
(1, 'Futurs Choisis', 'support@futurschoisis.net', 'Espace Ovata - Dakar, Sénégal', '+221338606319', '+221766400909', 'uploads/settings/logo/2020/December/1608486181.png', 'uploads/settings/favicon/2021/April/1617783107.png', 'uploads/settings/img_header/2020/December/1608486181.jpg', 'uploads/settings/img_slider/2020/December/1608486181.jpg', 'https://www.facebook.com/chesintha.chesintha.9/', 'Est labore quis illo', 'Minima cum ipsum al', 'Quibusdam eveniet e', '2020-12-15 11:55:38', '2021-04-18 06:59:53');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2020_11_19_105249_create_categories_table', 1),
(10, '2020_11_19_110527_create_formations_table', 1),
(11, '2020_11_19_112810_create_modules_table', 1),
(12, '2020_11_19_113113_create_sections_table', 1),
(13, '2020_11_19_122241_create_roles_table', 1),
(14, '2020_11_19_122436_create_organizations_table', 1),
(15, '2020_11_19_122709_create_quizzes_table', 1),
(16, '2020_11_19_123157_create_quiz_questions_table', 1),
(17, '2020_11_19_123412_create_quiz_answers_table', 1),
(18, '2020_11_19_131147_create_formation_users_table', 1),
(19, '2020_12_04_123640_create_requirements_table', 2),
(20, '2020_12_04_123909_create_goals_table', 2),
(21, '2020_11_29_105510_create_students_table', 3),
(23, '2020_12_09_143929_create_parcours_table', 3),
(24, '2020_12_11_114533_create_testimonials_table', 4),
(25, '2020_12_02_114523_create_infos_systems_table', 5),
(26, '2020_12_13_154936_create_msg_visitors_table', 6),
(27, '2020_12_15_150146_create_categorie_formation_table', 6),
(28, '2020_12_28_110237_create_teams_table', 6),
(29, '2020_12_28_110447_create_organization_teams_table', 6),
(30, '2020_12_28_110607_create_team_users_table', 6),
(31, '2021_01_03_155758_create_formation_teams_table', 7),
(32, '2021_01_19_092203_create_targeted_skills_table', 8);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `title`, `formation_id`, `created_at`, `updated_at`) VALUES
(133, 'I - Introduction', 198, '2021-04-17 21:05:33', '2021-04-17 21:05:33'),
(134, 'II - Qu\'est-ce qu\'un conflit d\'intérêts ?', 198, '2021-04-17 21:20:07', '2021-04-17 21:20:07'),
(135, 'III - Pourquoi gérer les conflits d\'intérêts ?', 198, '2021-04-17 21:27:12', '2021-04-17 21:27:12'),
(136, 'IV - Comment gérer les conflits d\'intérêts ?', 198, '2021-04-17 21:55:57', '2021-04-17 21:55:57');

-- --------------------------------------------------------

--
-- Structure de la table `msg_visitors`
--

CREATE TABLE `msg_visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `address`, `logo`, `slug`, `description`, `phone`, `created_at`, `updated_at`) VALUES
(20, 'BNDE', 'Immeuble Rivonia Dakar', 'uploads/organizations/logo/2021/April/1618698368.png', 'bnde', 'Banque Nationale pour le Développement Economique', '000000000', '2021-04-17 20:26:08', '2021-04-17 20:26:08');

-- --------------------------------------------------------

--
-- Structure de la table `organization_team`
--

CREATE TABLE `organization_team` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categories_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `module_id`, `created_at`, `updated_at`) VALUES
(202, 'I - Introduction', NULL, 133, '2021-04-17 22:04:44', '2021-04-17 22:04:44'),
(203, 'Module', NULL, 137, '2021-04-18 13:04:12', '2021-04-18 13:04:12'),
(204, 'II - Qu\'est-ce qu\'un conflit d\'intérêts ?', NULL, 134, '2021-04-18 15:50:39', '2021-04-18 15:50:39'),
(205, 'III - Pourquoi gérer les conflits d\'intérêts ?', NULL, 135, '2021-04-18 16:06:40', '2021-04-18 16:06:40'),
(206, 'IV - Comment gérer les conflits d\'intérêts ?', NULL, 136, '2021-04-18 16:40:36', '2021-04-18 16:40:36');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quiz_answers`
--

INSERT INTO `quiz_answers` (`id`, `answer`, `is_valid`, `quiz_question_id`, `created_at`, `updated_at`) VALUES
(323, 'a.	rarement exposés aux conflits d’intérêts.', 0, 207, '2021-04-17 22:10:05', '2021-04-17 22:10:05'),
(324, 'b.	jamais exposés aux conflits d’intérêts s’ils sont honnêtes.', 0, 207, '2021-04-17 22:10:31', '2021-04-17 22:10:31'),
(325, 'c.	toujours susceptibles de se trouver dans une situation de conflit d’intérêts quelle que soit leur position au sein de la Banque.', 1, 207, '2021-04-17 22:11:01', '2021-04-17 22:11:01'),
(327, 'Réponse', 0, 208, '2021-04-17 22:18:10', '2021-04-17 22:18:10'),
(328, 'a.	une demande de l’État.', 0, 208, '2021-04-17 22:19:56', '2021-04-17 22:19:56'),
(329, 'b.	une exigence réglementaire issue de la normalisation internationale.', 1, 208, '2021-04-17 22:20:17', '2021-04-17 22:20:17'),
(330, 'c.	une volonté autonome de la Direction générale.', 0, 208, '2021-04-17 22:20:51', '2021-04-17 22:20:51'),
(331, 'd.	une décision autonome du Conseil d’Administration.', 0, 208, '2021-04-17 22:21:10', '2021-04-17 22:21:10'),
(332, 'repose 1', 0, 209, '2021-04-18 13:04:12', '2021-04-18 13:04:12'),
(333, 'Réponse 2', 1, 209, '2021-04-18 13:04:24', '2021-04-18 13:04:24'),
(334, 'a.	une nouveauté dans le secteur bancaire et financier introduite par une nouvelle réglementation.', 0, 210, '2021-04-18 15:15:13', '2021-04-18 15:15:13'),
(335, 'b.	impossibles dans le secteur bancaire et financier du fait de la surveillance stricte des banques.', 0, 210, '2021-04-18 15:15:42', '2021-04-18 15:15:42'),
(336, 'c.	toujours présents dans la vie des banques du fait des nombreuses interactions qui s’y déroulent.', 1, 210, '2021-04-18 15:16:17', '2021-04-18 15:16:17'),
(337, 'd.	rarement constatés dans une institution bancaire.', 0, 210, '2021-04-18 15:16:39', '2021-04-18 15:16:39'),
(338, 'a.	par des référentiels externes et internes.', 1, 211, '2021-04-18 15:27:27', '2021-04-18 15:27:27'),
(339, 'b.	exclusivement par des référentiels externes.', 0, 211, '2021-04-18 15:27:47', '2021-04-18 15:27:47'),
(340, 'c.	exclusivement par des référentiels internes.', 0, 211, '2021-04-18 15:28:05', '2021-04-18 15:28:05'),
(341, 'réponse', 0, 211, '2021-04-18 15:29:13', '2021-04-18 15:29:13'),
(342, 'reponse', 0, 212, '2021-04-18 15:32:07', '2021-04-18 15:32:07'),
(343, 'a.	par des référentiels externes et internes.', 1, 213, '2021-04-18 15:34:21', '2021-04-18 15:34:21'),
(344, 'a.	la charte du comité d’audit.', 0, 214, '2021-04-18 15:35:20', '2021-04-18 15:41:39'),
(345, 'a.	peuvent influencer la gestion des conflits d’intérêts au sein de la Banque.', 1, 215, '2021-04-18 15:36:03', '2021-04-18 15:42:51'),
(346, 'a.	l’éthique et la conformité.', 1, 216, '2021-04-18 15:37:08', '2021-04-18 15:37:08'),
(347, 'a.	ceux de la banque et ceux des clients uniquement.', 0, 217, '2021-04-18 15:37:45', '2021-04-18 15:37:45'),
(348, 'a.	des interactions possibles entre la Banque et ses acteurs avec les familles de ces acteurs.', 1, 218, '2021-04-18 15:38:34', '2021-04-18 15:38:34'),
(349, 'a.	les intérêts des salariés, essentiellement.', 0, 219, '2021-04-18 15:39:13', '2021-04-18 15:39:13'),
(350, 'b.	exclusivement par des référentiels externes.', 0, 213, '2021-04-18 15:39:55', '2021-04-18 15:39:55'),
(351, 'c.	exclusivement par des référentiels internes.', 0, 213, '2021-04-18 15:40:24', '2021-04-18 15:40:24'),
(352, 'b.	la politique de gestion des conflits d’intérêts.', 1, 214, '2021-04-18 15:41:03', '2021-04-18 15:41:03'),
(353, 'c.	le Code d’éthique et de déontologie.', 1, 214, '2021-04-18 15:41:32', '2021-04-18 15:41:32'),
(354, 'd.	la politique de crédit.', 0, 214, '2021-04-18 15:42:05', '2021-04-18 15:42:05'),
(355, 'b.	ne peuvent avoir aucune influence sur la gestion des conflits d’intérêts au sein de la Banque.', 0, 215, '2021-04-18 15:42:42', '2021-04-18 15:42:42'),
(356, 'c.	ne sont pas applicables à une banque sénégalaise.', 0, 215, '2021-04-18 15:43:11', '2021-04-18 15:43:11'),
(357, 'b.	essentiellement le droit du travail.', 0, 216, '2021-04-18 15:43:57', '2021-04-18 15:43:57'),
(358, 'c.	exclusivement la gestion des ressources humaines au sein de la banque.', 0, 216, '2021-04-18 15:44:06', '2021-04-18 15:44:06'),
(359, 'b.	ceux des dirigeants et ceux des clients uniquement.', 0, 217, '2021-04-18 15:44:32', '2021-04-18 15:44:32'),
(360, 'c.	ceux des salariés et ceux des clients uniquement.', 0, 217, '2021-04-18 15:44:48', '2021-04-18 15:44:48'),
(361, 'd.	ceux de l’ensemble de ces acteurs et bien d’autres encore.', 1, 217, '2021-04-18 15:45:05', '2021-04-18 15:45:05'),
(362, 'b.	des interactions possibles entre la banque et le milieu politique.', 1, 218, '2021-04-18 15:45:35', '2021-04-18 15:45:35'),
(363, 'c.	du fait que la corruption est importante au sein de la banque.', 0, 218, '2021-04-18 15:45:59', '2021-04-18 15:45:59'),
(364, 'b.	les intérêts de la banque.', 1, 219, '2021-04-18 15:46:46', '2021-04-18 15:46:46'),
(365, 'c.	les intérêts des clients, exclusivement.', 0, 219, '2021-04-18 15:47:07', '2021-04-18 15:47:07'),
(366, 'a.	est exclusivement matériel.', 0, 220, '2021-04-18 15:50:39', '2021-04-18 15:50:39'),
(367, 'b.	est différent de celui de la Banque, quelle que soit sa nature matérielle ou non.', 1, 220, '2021-04-18 15:51:13', '2021-04-18 15:51:13'),
(368, 'c.	est en concurrence avec les intérêts d’un client.', 1, 220, '2021-04-18 15:51:33', '2021-04-18 15:51:33'),
(369, 'a.	il existe dans l’esprit du public.', 0, 221, '2021-04-18 15:52:14', '2021-04-18 15:52:14'),
(370, 'a.	est exclusivement matériel.', 0, 222, '2021-04-18 15:55:14', '2021-04-18 15:55:14'),
(371, 'a.	est exclusivement matériel.', 0, 223, '2021-04-18 15:58:24', '2021-04-18 15:58:24'),
(372, 'b.	est différent de celui de la Banque, quelle que soit sa nature matérielle ou non.', 1, 223, '2021-04-18 15:59:03', '2021-04-18 15:59:03'),
(373, 'c.	est en concurrence avec les intérêts d’un client.', 1, 223, '2021-04-18 15:59:22', '2021-04-18 15:59:22'),
(374, 'a.	la conformité réglementaire de la Banque.', 1, 224, '2021-04-18 16:06:40', '2021-04-18 16:06:40'),
(375, 'b.	la responsabilité exclusive du Directeur général.', 0, 224, '2021-04-18 16:07:27', '2021-04-18 16:07:27'),
(376, 'c.	la responsabilité exclusive du Président du Conseil d’administration.', 0, 224, '2021-04-18 16:07:47', '2021-04-18 16:07:47'),
(377, 'd.	l’efficacité organisationnelle de la Banque.', 1, 224, '2021-04-18 16:08:06', '2021-04-18 16:08:06'),
(378, 'a.	il existe dans l’esprit du public.', 0, 225, '2021-04-18 16:09:20', '2021-04-18 16:09:20'),
(379, 'b.	aucun lien direct ne peut encore être établi entre les intérêts de la personne et sa fonction.', 0, 225, '2021-04-18 16:09:50', '2021-04-18 16:09:50'),
(380, 'c.	il est avéré qu’une source d’avantages différente des fonctions de la personne affecte ces fonctions.', 1, 225, '2021-04-18 16:10:18', '2021-04-18 16:10:18'),
(381, 'd.	seule une analyse de la situation permet d’écarter l’influence d’un intérêt de la personne sur ses fonctions.', 0, 225, '2021-04-18 16:10:39', '2021-04-18 16:10:39'),
(382, 'a.	ceux d’un administrateur et ceux d’un client.', 1, 226, '2021-04-18 16:11:46', '2021-04-18 16:11:46'),
(383, 'b.	ceux d’un prestataire et ceux de la banque.', 1, 226, '2021-04-18 16:12:09', '2021-04-18 16:12:09'),
(384, 'c.	ceux d’un Directeur et ceux d’un client de la banque.', 1, 226, '2021-04-18 16:12:39', '2021-04-18 16:12:39'),
(385, 'd.	ceux de la Banque et ceux de l’Etat.', 1, 226, '2021-04-18 16:13:01', '2021-04-18 16:13:01'),
(386, 'a.	la compétence de la personne dans l’exercice de ses fonctions.', 0, 227, '2021-04-18 16:13:42', '2021-04-18 16:13:42'),
(387, 'b.	l’impartialité de la personne dans l’exercice de ses fonctions.', 1, 227, '2021-04-18 16:14:06', '2021-04-18 16:14:06'),
(388, 'c.	la productivité de la personne dans l’exercice de ses fonctions.', 0, 227, '2021-04-18 16:14:22', '2021-04-18 16:14:22'),
(389, 'd.	la neutralité de la personne dans l’exercice de ses fonctions.', 1, 227, '2021-04-18 16:15:12', '2021-04-18 16:15:12'),
(390, 'a.	est affectée par  les intérêts des personnes avec lesquelles elle a des liens familiaux proches.', 1, 228, '2021-04-18 16:16:31', '2021-04-18 16:16:31'),
(391, 'b.	n’est pas affectée mais elle a une relation personnelle ou familiale avec une autre personne au sein de la banque.', 0, 228, '2021-04-18 16:17:07', '2021-04-18 16:17:07'),
(392, 'c.	est affectée par  les intérêts des personnes avec lesquelles elle entretient des relations professionnelles en dehors de la banque.', 0, 228, '2021-04-18 16:17:22', '2021-04-18 16:17:22'),
(393, 'd.	n’est pas affectée mais elle a des activités professionnelles en dehors de la banque.', 0, 228, '2021-04-18 16:17:41', '2021-04-18 16:17:41'),
(394, 'a.	un traitement préventif.', 1, 229, '2021-04-18 16:18:44', '2021-04-18 16:18:44'),
(395, 'b.	une sanction pénale.', 0, 229, '2021-04-18 16:19:10', '2021-04-18 16:19:10'),
(396, 'c.	une sanction disciplinaire.', 0, 229, '2021-04-18 16:19:25', '2021-04-18 16:19:25'),
(397, 'a.	Vrai.', 0, 230, '2021-04-18 16:20:02', '2021-04-18 16:20:02'),
(398, 'b.	Faux.', 1, 230, '2021-04-18 16:20:23', '2021-04-18 16:20:23'),
(399, 'a.	les prestataires de la banque.', 0, 231, '2021-04-18 16:21:06', '2021-04-18 16:21:06'),
(400, 'b.	les administrateurs.', 0, 231, '2021-04-18 16:21:25', '2021-04-18 16:21:25'),
(401, 'c.	le responsable des risques.', 0, 231, '2021-04-18 16:21:36', '2021-04-18 16:21:36'),
(402, 'd.	les agents de caisse.', 0, 231, '2021-04-18 16:21:47', '2021-04-18 16:21:47'),
(403, 'e.	aucune des catégories citées.', 1, 231, '2021-04-18 16:22:02', '2021-04-18 16:22:02'),
(404, 'a.	il existe dans l’esprit du public.', 0, 232, '2021-04-18 16:23:03', '2021-04-18 16:23:03'),
(405, 'b.	aucun lien direct ne peut encore être établi entre les intérêts de la personne et sa fonction.', 0, 232, '2021-04-18 16:23:25', '2021-04-18 16:23:25'),
(406, 'c.	seule une analyse de la situation permet d’écarter l’influence d’un intérêt de la personne sur ses fonctions.', 1, 232, '2021-04-18 16:23:39', '2021-04-18 16:23:39'),
(407, 'a.	un traitement préventif.', 1, 233, '2021-04-18 16:24:28', '2021-04-18 16:24:28'),
(408, 'b.	une sanction pénale.', 0, 233, '2021-04-18 16:24:45', '2021-04-18 16:24:45'),
(409, 'c.	une sanction disciplinaire.', 0, 233, '2021-04-18 16:24:58', '2021-04-18 16:24:58'),
(410, 'a.	vrai.', 1, 234, '2021-04-18 16:26:37', '2021-04-18 16:26:37'),
(411, 'b.	faux.', 0, 234, '2021-04-18 16:26:55', '2021-04-18 16:26:55'),
(412, 'a.	nommer un Directeur de la gestion des conflits d’intérêts.', 0, 235, '2021-04-18 16:27:27', '2021-04-18 16:27:27'),
(413, 'b.	mettre en place des mesures de détection et de traitement des conflits d’intérêts.', 1, 235, '2021-04-18 16:27:46', '2021-04-18 16:27:46'),
(414, 'c.	mettre en place des référentiels internes de gestion des conflits d’intérêts.', 1, 235, '2021-04-18 16:27:58', '2021-04-18 16:27:58'),
(415, 'd.	transmettre au tribunal les mesures de gestion des conflits d’intérêts qui sont prises par la Banque.', 0, 235, '2021-04-18 16:28:12', '2021-04-18 16:28:12'),
(416, 'a.	vrai.', 1, 236, '2021-04-18 16:28:50', '2021-04-18 16:28:50'),
(417, 'b.	faux.', 0, 236, '2021-04-18 16:29:07', '2021-04-18 16:29:07'),
(418, 'a.	la politique de gestion des conflits d’intérêts.', 1, 237, '2021-04-18 16:29:37', '2021-04-18 16:29:37'),
(419, 'b.	le Règlement intérieur.', 0, 237, '2021-04-18 16:30:00', '2021-04-18 16:30:00'),
(420, 'c.	la charte du Conseil d’administration.', 0, 237, '2021-04-18 16:30:11', '2021-04-18 16:30:11'),
(421, 'a.	la lutte contre le blanchiment de capitaux.', 1, 238, '2021-04-18 16:30:52', '2021-04-18 16:30:52'),
(422, 'b.	la lutte contre la fausse monnaie.', 0, 238, '2021-04-18 16:31:11', '2021-04-18 16:31:11'),
(423, 'c.	la lutte contre l’enrichissement illicite des fonctionnaires.', 0, 238, '2021-04-18 16:31:26', '2021-04-18 16:31:26'),
(424, 'a.	vrai.', 0, 239, '2021-04-18 16:31:58', '2021-04-18 16:31:58'),
(425, 'b.	faux.', 0, 239, '2021-04-18 16:32:33', '2021-04-18 16:32:33'),
(426, 'a.	l’organisation de la Banque.', 1, 240, '2021-04-18 16:33:14', '2021-04-18 16:33:14'),
(427, 'b.	la réputation de la Banque.', 1, 240, '2021-04-18 16:33:31', '2021-04-18 16:33:31'),
(428, 'c.	la conformité de la Banque à la réglementation.', 1, 240, '2021-04-18 16:33:44', '2021-04-18 16:33:44'),
(429, 'd.	la solidité financière de la Banque.', 1, 240, '2021-04-18 16:33:56', '2021-04-18 16:33:56'),
(430, 'a.	vrai.', 1, 241, '2021-04-18 16:34:38', '2021-04-18 16:34:38'),
(431, 'b.	faux.', 0, 241, '2021-04-18 16:34:57', '2021-04-18 16:34:57'),
(432, 'a.	sensibilisation et plaidoyer.', 1, 242, '2021-04-18 16:35:56', '2021-04-18 16:35:56'),
(433, 'b.	annulation des délibérations prises en violation des règles de gestion des conflits d’intérêts.', 0, 242, '2021-04-18 16:36:29', '2021-04-18 16:36:29'),
(434, 'c.	bonus et gratifications.', 1, 242, '2021-04-18 16:37:02', '2021-04-18 16:37:02'),
(435, 'd.	peines de prison.', 0, 242, '2021-04-18 16:37:17', '2021-04-18 16:37:17'),
(436, 'a.	Président du Conseil d’administration.', 1, 243, '2021-04-18 16:40:36', '2021-04-18 16:40:36'),
(437, 'b.	Responsable des risques.', 0, 243, '2021-04-18 16:40:52', '2021-04-18 16:40:52'),
(438, 'c.	Responsable de la conformité.', 0, 243, '2021-04-18 16:41:07', '2021-04-18 16:41:07'),
(439, 'd.	Directeur général.', 0, 243, '2021-04-18 16:41:11', '2021-04-18 16:41:11'),
(440, 'a.	par écrit ou oralement selon le choix de la personne qui déclare/signale.', 0, 244, '2021-04-18 16:41:46', '2021-04-18 16:41:46'),
(441, 'b.	uniquement par écrit.', 0, 244, '2021-04-18 16:42:10', '2021-04-18 16:42:10'),
(442, 'c.	uniquement oralement.', 0, 244, '2021-04-18 16:42:23', '2021-04-18 16:42:23'),
(443, 'd.	par écrit, en principe et oralement, en cas d’urgence.', 1, 244, '2021-04-18 16:42:37', '2021-04-18 16:42:37'),
(444, 'a.	vrai.', 1, 245, '2021-04-18 16:43:26', '2021-04-18 16:43:26'),
(445, 'b.	faux.', 0, 245, '2021-04-18 16:43:44', '2021-04-18 16:43:44'),
(446, 'a.	exclue du processus de prise de décision ou de délibération.', 1, 246, '2021-04-18 16:44:29', '2021-04-18 16:44:29'),
(447, 'b.	révoquée immédiatement de tout mandat.', 0, 246, '2021-04-18 16:44:52', '2021-04-18 16:44:52'),
(448, 'c.	licenciée pour faute lourde.', 0, 246, '2021-04-18 16:45:04', '2021-04-18 16:45:04'),
(449, 'd.	suspendue de ses fonctions pour une durée dépendant de la gravité du conflit d’intérêts.', 0, 246, '2021-04-18 16:45:15', '2021-04-18 16:45:15'),
(450, 'a.	vrai.', 0, 247, '2021-04-18 16:46:02', '2021-04-18 16:46:02'),
(451, 'b.	faux.', 1, 247, '2021-04-18 16:46:24', '2021-04-18 16:46:24'),
(452, 'a.	des sanctions sévères.', 0, 248, '2021-04-18 16:47:00', '2021-04-18 16:47:00'),
(453, 'b.	la maîtrise des informations confidentielles.', 1, 248, '2021-04-18 16:47:24', '2021-04-18 16:47:24'),
(454, 'c.	des procédures judiciaires systématiques.', 0, 248, '2021-04-18 16:47:38', '2021-04-18 16:47:38'),
(455, 'd.	un registre des conflits d’intérêts.', 1, 248, '2021-04-18 16:47:54', '2021-04-18 16:47:54'),
(456, 'e.	le plaidoyer et la sensibilisation.', 1, 248, '2021-04-18 16:48:14', '2021-04-18 16:48:14'),
(457, 'a.	la personne qui est désignée responsable de la gestion des conflits d’intérêts au sein de la banque.', 0, 249, '2021-04-18 16:49:01', '2021-04-18 16:49:01'),
(458, 'b.	le Directeur général de la Banque.', 0, 249, '2021-04-18 16:49:23', '2021-04-18 16:49:23'),
(459, 'c.	le Président du Conseil d’administration de la banque.', 0, 249, '2021-04-18 16:49:35', '2021-04-18 16:49:35'),
(460, 'd.	la personne qui est soumise à un conflit d’intérêts actuel ou imminent.', 1, 249, '2021-04-18 16:49:46', '2021-04-18 16:49:46'),
(461, 'a.	la tenue d’un registre des conflits d’intérêts.', 0, 250, '2021-04-18 16:50:18', '2021-04-18 16:50:18'),
(462, 'b.	l’élaboration des politique et procédure de gestion des conflits d’intérêts.', 1, 250, '2021-04-18 16:50:39', '2021-04-18 16:50:39'),
(463, 'c.	la déclaration et le signalement des situations de conflit d’intérêts.', 0, 250, '2021-04-18 16:50:53', '2021-04-18 16:50:53'),
(464, 'a.	je suis personnellement soumis à un conflit d’intérêts.', 0, 251, '2021-04-18 16:51:46', '2021-04-18 16:51:46'),
(465, 'b.	un collègue est soumis à un conflit d’intérêts.', 1, 251, '2021-04-18 16:52:02', '2021-04-18 16:52:02'),
(466, 'c.	mon N+1 est soumis à un conflit d’intérêts.', 1, 251, '2021-04-18 16:52:15', '2021-04-18 16:52:15'),
(467, 'd.	mon N-1 est soumis à un conflit d’intérêts.', 1, 251, '2021-04-18 16:52:27', '2021-04-18 16:52:27'),
(468, 'a.	Président du Conseil d’administration.', 0, 252, '2021-04-18 16:53:17', '2021-04-18 16:53:17'),
(469, 'b.	Responsable des risques.', 0, 252, '2021-04-18 16:53:35', '2021-04-18 16:53:35'),
(470, 'c.	Responsable de la conformité.', 1, 252, '2021-04-18 16:53:50', '2021-04-18 16:53:50'),
(471, 'd.	Directeur général.', 0, 252, '2021-04-18 16:54:24', '2021-04-18 16:54:24'),
(472, 'a.	vrai', 1, 253, '2021-04-18 16:54:52', '2021-04-18 16:54:52'),
(473, 'b.	faux.', 0, 253, '2021-04-18 16:55:25', '2021-04-18 16:55:25'),
(474, 'a.	sur une feuille mobile comprenant l’ensemble des mentions du formulaire de déclaration/signalement.', 1, 254, '2021-04-18 16:56:04', '2021-04-18 16:56:04'),
(475, 'b.	sur un formulaire papier de déclaration/signalement de conflit d’intérêts.', 1, 254, '2021-04-18 16:56:22', '2021-04-18 16:56:22'),
(476, 'c.	sur une feuille mobile quelles que soient les mentions.', 0, 254, '2021-04-18 16:56:40', '2021-04-18 16:56:40'),
(477, 'd.	sur un formulaire électronique de déclaration/signalement de conflit d’intérêts.', 1, 254, '2021-04-18 16:56:51', '2021-04-18 16:56:51');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quizze_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `question`, `quizze_id`, `created_at`, `updated_at`) VALUES
(207, '1. Les acteurs de la banque (ne) sont :', 202, '2021-04-17 22:04:44', '2021-04-17 22:13:11'),
(208, '2. La prise en compte des conflits d’intérêts dans la gouvernance des banques est :', 202, '2021-04-17 22:18:10', '2021-04-17 22:19:56'),
(209, 'question 1', 203, '2021-04-18 13:04:12', '2021-04-18 13:04:12'),
(210, '3. Les conflits d’intérêts, dans une banque, sont :', 202, '2021-04-18 15:15:13', '2021-04-18 15:15:13'),
(213, '4. La gestion efficace des conflits d’intérêts au sein de la Banque est organisée :', 202, '2021-04-18 15:34:21', '2021-04-18 15:34:21'),
(214, '5. Parmi les référentiels internes de la Banque consacrés à la gestion des conflits d’intérêts, figurent :', 202, '2021-04-18 15:35:19', '2021-04-18 15:35:19'),
(215, '6. Les lois étrangères :', 202, '2021-04-18 15:36:03', '2021-04-18 15:36:03'),
(216, '7. Les conflits d’intérêts mettent en cause :', 202, '2021-04-18 15:37:08', '2021-04-18 15:37:08'),
(217, '8. Les intérêts en conflit dans les conflits d’intérêts sont :', 202, '2021-04-18 15:37:45', '2021-04-18 15:37:45'),
(218, '9. Les conflits d’intérêts sont incontournables au sein de la Banque en raison :', 202, '2021-04-18 15:38:34', '2021-04-18 15:38:34'),
(219, '10. Les conflits d’intérêts au sein de la banque menacent :', 202, '2021-04-18 15:39:13', '2021-04-18 15:39:13'),
(223, '1.	Il y a conflit d’intérêt lorsque l’avantage que la personne en cause tire de la situation :', 204, '2021-04-18 15:58:24', '2021-04-18 15:58:24'),
(224, '1. La gestion des conflits d’intérêts est nécessaire car elle met en cause :', 205, '2021-04-18 16:06:40', '2021-04-18 16:07:27'),
(225, '2.	Le conflit d’intérêts est considéré comme réel lorsque :', 204, '2021-04-18 16:09:20', '2021-04-18 16:09:20'),
(226, '3.	Les intérêts en concurrence dans une situation de conflit d’intérêts peuvent être :', 204, '2021-04-18 16:11:46', '2021-04-18 16:11:46'),
(227, '4.	Les conflits d’intérêts affectent principalement : ', 204, '2021-04-18 16:13:42', '2021-04-18 16:13:42'),
(228, '5.	Le conflit d’intérêts existe dans les situations dans lesquelles la fonction de la personne :', 204, '2021-04-18 16:16:31', '2021-04-18 16:16:31'),
(229, '6.	Le conflit d’intérêt potentiel nécessite :', 204, '2021-04-18 16:18:44', '2021-04-18 16:18:44'),
(230, '7.	Seules les personnes exerçant des fonctions sensibles sont susceptibles d’être en conflit d’intérêts. ', 204, '2021-04-18 16:20:02', '2021-04-18 16:20:02'),
(231, '8.	Parmi les parties prenantes à la gestion des conflits d’intérêts ne figurent pas : ', 204, '2021-04-18 16:21:06', '2021-04-18 16:21:06'),
(232, '9.	Le conflit d’intérêts est considéré comme apparent lorsque :', 204, '2021-04-18 16:23:03', '2021-04-18 16:23:03'),
(233, '10.	Le conflit d’intérêts apparent nécessite :', 204, '2021-04-18 16:24:28', '2021-04-18 16:24:28'),
(234, '2.	L’existence de conflits d’intérêts non gérés peut entrainer pour la banque des risques financiers importants.  ', 205, '2021-04-18 16:26:37', '2021-04-18 16:26:37'),
(235, '3.	La Circulaire n°01-2017/CB/C relative à la gouvernance des établissements de crédit et des compagnies financières de l’UMOA impose aux banques de :  ', 205, '2021-04-18 16:27:27', '2021-04-18 16:27:27'),
(236, '4.	Le code d’éthique et de déontologie fait partie des référentiels internes de gestion des conflits d’intérêts. ', 205, '2021-04-18 16:28:50', '2021-04-18 16:28:50'),
(237, '5.	Le dispositif de gestion des conflits d’intérêts au sein de la Banque est principalement consigné dans : ', 205, '2021-04-18 16:29:37', '2021-04-18 16:29:37'),
(238, '6.	Il existe un lien fort entre la gestion des conflits d’intérêts et : ', 205, '2021-04-18 16:30:52', '2021-04-18 16:30:52'),
(239, '7.	La mauvaise gestion des conflits d’intérêts peut exposer la Banque à des sanctions de la commission bancaire. ', 205, '2021-04-18 16:31:58', '2021-04-18 16:31:58'),
(240, '8.	Les situations de conflits d’intérêts peuvent mettre à mal :', 205, '2021-04-18 16:33:14', '2021-04-18 16:33:14'),
(241, '9.	Les situations de conflits d’intérêts peuvent conduire à la violation des droits des clients à l’information et au conseil.', 205, '2021-04-18 16:34:38', '2021-04-18 16:34:38'),
(242, '10.	Dans le but d’encourager les comportements favorables à la gestion des conflits d’intérêts, les mesures suivantes sont préconisées.', 205, '2021-04-18 16:35:56', '2021-04-18 16:35:56'),
(243, '1.	La déclaration/signalement d’un conflit d’intérêts mettant en cause le représentant d’un actionnaire au Conseil d’administration est effectué(e) auprès du :', 206, '2021-04-18 16:40:36', '2021-04-18 16:40:36'),
(244, '2.	La déclaration/signalement de conflit d’intérêts est effectué(e) :', 206, '2021-04-18 16:41:46', '2021-04-18 16:41:46'),
(245, '3.	La Banque a mis en place des mesures de déclaration sur l’honneur d’absence de conflits d’intérêts à l’intention des dirigeants, administrateurs et collaborateur, notamment à l’occasion de la nomination ou du recrutement.', 206, '2021-04-18 16:43:26', '2021-04-18 16:43:26'),
(246, '4.	Pour mieux gérer les conflits d’intérêts, une personne soumise à un conflit d’intérêts est :', 206, '2021-04-18 16:44:29', '2021-04-18 16:44:29'),
(247, '5.	Le conflit d’intérêts ne peut exister que lorsque deux des critères de détection au moins sont réunis.', 206, '2021-04-18 16:46:02', '2021-04-18 16:46:02'),
(248, '6.	La veille et le suivi rigoureux de la gestion des conflits d’intérêts nécessitent : ', 206, '2021-04-18 16:47:00', '2021-04-18 16:47:00'),
(249, '7.	La déclaration de conflit d’intérêts est faite par : ', 206, '2021-04-18 16:49:01', '2021-04-18 16:49:01'),
(250, '8.	Dans le cadre du dispositif de gestion des conflits d’intérêts, la Banque, notamment à travers ses organes de gouvernance, a en charge :', 206, '2021-04-18 16:50:18', '2021-04-18 16:50:18'),
(251, '9.	Je peux procéder au signalement d’un conflit d’intérêt lorsque :', 206, '2021-04-18 16:51:46', '2021-04-18 16:51:46'),
(252, '10.	La déclaration/signalement d’un conflit d’intérêt mettant en cause un Directeur est effectué(e) auprès du :', 206, '2021-04-18 16:53:17', '2021-04-18 16:53:17'),
(253, '11.	La Banque a mis en place une procédure de gestion des cadeaux, invitations et avantages.', 206, '2021-04-18 16:54:52', '2021-04-18 16:54:52'),
(254, '12.	La déclaration/signalement de conflit d’intérêts peut être effectué(e) :', 206, '2021-04-18 16:56:04', '2021-04-18 16:56:04');

-- --------------------------------------------------------

--
-- Structure de la table `requirements`
--

CREATE TABLE `requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formation_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `requirements`
--

INSERT INTO `requirements` (`id`, `title`, `formation_id`, `created_at`, `updated_at`) VALUES
(67, 'Aucun prérequis spécifique.', '198', '2021-04-17 21:00:02', '2021-04-17 21:00:02'),
(68, 'prerequis', '199', '2021-04-18 13:03:00', '2021-04-18 13:03:00');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `title`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrateur Technique', 'admin', 'L\'administrateur du site', '2020-11-19 14:02:01', '2020-11-19 14:02:01'),
(2, 'Administrateur Pédagogique', 'educational-admin', 'Administrateur pédagogique', '2020-11-19 14:02:01', '2020-11-19 14:02:01'),
(3, 'Formateur', 'teacher', 'Formateur', '2020-11-19 14:06:13', '2020-11-19 14:06:13'),
(4, 'Apprenant', 'student', 'Apprenant', '2020-11-19 14:06:13', '2020-11-19 14:06:13');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentation_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `title`, `presentation_text`, `video`, `reference`, `other`, `slug`, `module_id`, `created_at`, `updated_at`) VALUES
(152, '1. Mot du Directeur Général de la BNDE', 'Monsieur Thierno Seydou Nourou SY, Directeur Général de la BNDE adresse un mot aux auditeurs de la formation en vue de présenter sommairement le contexte et les enjeux de la gestion des conflits d\'intérêts au sein de la Banque.', '539729432', '[\"uploads\\/reference\\/2021\\/April\\/fc471db4-de05-434f-be28-d37d3b087ab6.pdf\"]', '', '1-mot-du-directeur-general-de-la-bnde', 133, '2021-04-17 21:14:50', '2021-04-21 14:03:26'),
(154, '1. La notion de conflit d\'intérêts ', 'Présentation succincte de la notion de conflit d\'intérêts.', '538191049', '[\"uploads\\/reference\\/2021\\/April\\/9e7af50b-bed3-47d0-b8b3-c9238e75400c.pdf\"]', '', '1-la-notion-de-conflit-dinterets', 134, '2021-04-17 21:20:12', '2021-04-17 21:20:12'),
(155, '2. Les catégories de conflits d\'intérêts', 'Brève présentation des différentes catégories de conflits d\'intérêts', '538191346', '[\"uploads\\/reference\\/2021\\/April\\/52e6b632-98a0-453a-be4f-cc4770ad027d.pdf\"]', '', '2-les-categories-de-conflits-dinterets', 134, '2021-04-17 21:22:05', '2021-04-17 21:22:05'),
(156, '3. Les parties prenantes aux conflits d\'intérêts', 'Panorama des parties prenantes aux conflits d\'intérêts au sein de la Banque', '538191655', '[\"uploads\\/reference\\/2021\\/April\\/da539a69-c1cc-4a02-8054-4c976b18cc5d.pdf\"]', '', '3-les-parties-prenantes-aux-conflits-dinterets', 134, '2021-04-17 21:24:11', '2021-04-17 21:24:11'),
(157, '1. Garantir la conformité', 'Présentation des enjeux de conformité liés à la gestion des conflits d\'intérêts', '538192127', '[\"uploads\\/reference\\/2021\\/April\\/70d0082c-78a8-4081-ba83-f5222d182452.pdf\"]', '', '1-garantir-la-conformite', 135, '2021-04-17 21:27:39', '2021-04-17 21:27:39'),
(158, '2. Maîtriser les risques', 'Présentation des enjeux en matière de risques liés aux conflits d\'intérêts', '538192490', '[\"uploads\\/reference\\/2021\\/April\\/ad092335-a1c5-4614-af95-09090ac987b6.pdf\"]', '', '2-maitriser-les-risques', 135, '2021-04-17 21:29:46', '2021-04-17 21:29:46'),
(159, '3. Gérer les responsabilités', 'Présentation des enjeux en termes de responsabilités liées à la gestion des conflits d\'intérêts', '538192758', '[\"uploads\\/reference\\/2021\\/April\\/59b767d5-1c77-4ba3-bcaf-64111424394d.pdf\"]', '', '3-gerer-les-responsabilites', 135, '2021-04-17 21:31:59', '2021-04-17 21:31:59'),
(160, '1. Que fait la Banque ?', 'Présentation du dispositif mis ennemis place par la banque pour prévenir et traiter les conflits d\'intérêts', '538196351', '[\"uploads\\/reference\\/2021\\/April\\/f4008c65-edea-4fda-8505-cb8227d5b91a.pdf\"]', '', '1-que-fait-la-banque', 136, '2021-04-17 21:56:14', '2021-04-17 21:56:14'),
(161, '2. Que fait la personne concernée par un conflit d\'intérêts ?', 'Description du rôle spécifique de la personne concernée directement ou indirectement par un conflit d\'intérêts ', '538196850', '[\"uploads\\/reference\\/2021\\/April\\/e3ab3f82-6636-4ee3-a5f4-719b404b9db9.pdf\"]', '', '2-que-fait-la-personne-concernee-par-un-conflit-dinterets', 136, '2021-04-17 21:59:43', '2021-04-17 21:59:43'),
(162, '3. Que fait l\'autorité en charge de la gestion des conflits d\'intérêts ?', 'Description du rôle spécifique de l\'autorité en charge de la gestion des conflits d\'intérêts au sein de la Banque', '538197186', '[\"uploads\\/reference\\/2021\\/April\\/34488dd2-d678-4372-857b-53cc8403c531.pdf\"]', '', '3-que-fait-lautorite-en-charge-de-la-gestion-des-conflits-dinterets', 136, '2021-04-17 22:01:53', '2021-04-17 22:01:53'),
(163, 'Section', 'section', '538336727', '[\"uploads\\/reference\\/2021\\/April\\/9d4e17ce-6db2-4238-a979-b9d8cbb844e8.pdf\"]', '', 'section', 137, '2021-04-18 13:03:52', '2021-04-18 13:03:52');

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `targeted_skills`
--

CREATE TABLE `targeted_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `formation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`id`, `name`, `organization_id`, `created_at`, `updated_at`) VALUES
(15, 'Direction de la conformité', 20, '2021-04-17 20:27:42', '2021-04-17 20:27:42');

-- --------------------------------------------------------

--
-- Structure de la table `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `team_user`
--

INSERT INTO `team_user` (`id`, `team_id`, `user_id`, `created_at`, `updated_at`) VALUES
(21, 13, 65, NULL, NULL),
(22, 13, 66, NULL, NULL),
(23, 14, 66, NULL, NULL),
(24, 15, 70, NULL, NULL),
(25, 15, 71, NULL, NULL),
(26, 15, 72, NULL, NULL),
(27, 15, 73, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `testimonial` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `date_of_birth`, `country`, `gender`, `avatar`, `phone`, `address`, `role_id`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(58, 'Compte', 'Admin', '2008-08-07', 'Burkina Faso', 'Femme', NULL, '+1 (218) 547-2895', 'Debitis eum inventor', 1, 'admin@fc.com', NULL, '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u', NULL, NULL, 'yrFDOyshg4Cgai5q07t1EGoiraIlIpLnMBTyLX7ygYe4E853TQlBUeX4Kf65', '2021-01-07 15:22:02', '2021-01-07 15:22:02'),
(64, 'Compte', 'Formateur', '2021-04-14', 'Sénégal', 'Homme', NULL, '0778142978', 'N°98, Cité Air Afrique, Golf Nord Est Guédiawaye', 3, 'formateur@fc.com', NULL, '$2y$10$vvSOQ0VeHdKbNyhxrXE89.TFKBlMZjMhEW2tAve7wn5mx0aYrMhaq', NULL, NULL, 'SJ6ty1PnjR3QkiwvUtIPWefFAQYFhUi4RqypSx2DW0NtO6LU5mlaEj7ZJZ0G', '2021-04-13 21:21:01', '2021-04-17 19:49:08'),
(68, 'Boubacar', 'Diallo', NULL, NULL, NULL, NULL, '+221775425252', NULL, 1, 'bdiallo@futurschoisis.net', NULL, '$2y$10$5oNzip7OO/etmRKbKQoa4e9MOihDHR36Lyw4OkujgGpiRdB6IYdNO', NULL, NULL, 'hPxDRLYJ7M5Xp3Xvh94xiWTL6K5uc7oa9SiNrXV4UjAMuBhcKM3xoB6tfEFj', '2021-04-17 19:40:48', '2021-04-17 19:40:48'),
(69, 'Boubacar', 'Diallo', NULL, 'Sénégal', 'Homme', 'uploads/teachers/avatar/2021/April/1618698208.jpg', '+221766400909', 'Espace Ovata Dakar', 3, 'bdiallo@carapaces.net', NULL, '$2y$10$4gBhpqhdWCShMxMI.1O5/O2bMY/oCmpn9W5PzxFgItNoj1MvV2R32', NULL, NULL, NULL, '2021-04-17 20:22:53', '2021-04-17 20:23:28'),
(72, 'Boubacar', 'Diallo', NULL, 'Sénégal', 'Homme', NULL, '766400909', 'Dakar Sénégal', 4, 'bdiallo@live.fr', NULL, '$2y$10$w7KzvebB4loMm1Qxpl.hTuX55TjM2RlAMUXedT3tfJf/eTwPKVh5u', NULL, NULL, 'U4oJ4o3Yn7OEkoKivBeTeAqR2WQLpItSIsoCsgIwUoN242fJeLyLYPvWi8RP', '2021-04-18 12:57:41', '2021-04-18 12:58:48'),
(73, 'El Hadji Papa', 'Diallo', NULL, 'Royaume-Uni', 'Homme', NULL, '786080939', 'Keur Massar', 4, 'djiby.sane@hotmail.fr', NULL, '$2y$10$waZK9X9qNAic7JeaC.KdBuXsczAocr4R/Gjug6iMxY/WJsDt8Rp2C', NULL, NULL, '2fk5Pb5noGVNoVkgPuqjV2fHz5DHPA3bFzfnoW4DtRcLRWdeAFONGUNUOhrt', '2021-04-18 21:38:06', '2021-04-18 21:38:43'),
(74, 'Ndiouga', 'Diallo', NULL, 'Sénégal', 'Homme', NULL, '000000000', 'Dakar Sénégal', 1, 'dev@illugraph-ic.com', NULL, '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u', NULL, NULL, 'YUvz9s84B8eXxc6spORvKbfpRfXJ8N2omGcST3Aqucf2MP4v4glCwiRC0SbE', '2021-04-21 09:16:00', '2021-04-21 09:16:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_formation`
--
ALTER TABLE `categorie_formation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formation_team`
--
ALTER TABLE `formation_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formation_team_formation_id_foreign` (`formation_id`),
  ADD KEY `formation_team_team_id_foreign` (`team_id`);

--
-- Index pour la table `formation_user`
--
ALTER TABLE `formation_user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `infos_systems`
--
ALTER TABLE `infos_systems`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `msg_visitors`
--
ALTER TABLE `msg_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `organization_team`
--
ALTER TABLE `organization_team`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `targeted_skills`
--
ALTER TABLE `targeted_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `targeted_skills_formation_id_foreign` (`formation_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `categorie_formation`
--
ALTER TABLE `categorie_formation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT pour la table `formation_team`
--
ALTER TABLE `formation_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `formation_user`
--
ALTER TABLE `formation_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT pour la table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `infos_systems`
--
ALTER TABLE `infos_systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT pour la table `msg_visitors`
--
ALTER TABLE `msg_visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `organization_team`
--
ALTER TABLE `organization_team`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT pour la table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- AUTO_INCREMENT pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT pour la table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT pour la table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `targeted_skills`
--
ALTER TABLE `targeted_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formation_team`
--
ALTER TABLE `formation_team`
  ADD CONSTRAINT `formation_team_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `formation_team_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `targeted_skills`
--
ALTER TABLE `targeted_skills`
  ADD CONSTRAINT `targeted_skills_formation_id_foreign` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
