CREATE DATABASE `trackpark`;
USE `trackpark`;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2018 at 05:01 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "-05:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trackpark`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_type`
--

CREATE TABLE `access_type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `access_type`
--

INSERT INTO `access_type` (`id`, `name`, `description`) VALUES
(0, 'Aucun', 'Aucun type d\'accès n\'a été défini.'),
(1, 'Assigné', 'Évaluateur principale du groupe.'),
(2, 'Collaborateur', 'Autre évaluateur qui peux prendre le relais du groupe.');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `address` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `address`) VALUES
(0, 'Aucune'),
(1, 'Inconnue'),
(2, '845 rue Grégoire, Sherbrooke'),
(3, '12, chemin Des Montagnes, Magog');

-- --------------------------------------------------------

--
-- Table structure for table `athlete`
--

CREATE TABLE `athlete` (
  `id` int(11) NOT NULL,
  `address` int(11) DEFAULT '0',
  `athlete_category` int(11) DEFAULT '1',
  `gender` int(11) DEFAULT '0',
  `first_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_url` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_info` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `availabilities` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `holidays` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) DEFAULT '0',
  `inactive` tinyint(1) DEFAULT '0',
  `creation_date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `athlete`
--

INSERT INTO `athlete` (`id`, `address`, `athlete_category`, `gender`, `first_name`, `name`, `birthday`, `email`, `phone_number`, `profile_image_url`, `profile_info`, `comments`, `availabilities`, `holidays`, `banned`, `inactive`, `creation_date`) VALUES
(0, 0, 0, 0, 'Prénom', 'Nom de famille', NULL, NULL, NULL, 'default_image_url (to define later on)', NULL, NULL, NULL, NULL, 1, 1, NULL),
(1, 2, 1, 1, 'Bob', 'Poirier', '20000113', 'test1@gmail.com', '8195551234', 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png', 'Information du profile de Bob Poirier. Soyez les bienvenu!', 'Premier athlète ajouté dans la BD.', 'Juste le lundi matin à 8:30.', 'Le 15 mars prochain.', 0, 0, '2018-04-'),
(2, 1, 1, 2, 'Martine', 'Bessette', '19981201', 'test2@gmail.com', '8195554321', 'https://www.stori.si/wp-content/uploads/2015/09/blank_avatar-450x450.jpg', 'Information du profile de Bob Poirier.', 'Deuxième athlète ajouté dans la BD. Est très performant.', 'Tout les jours.', 'Le 19 de chaque mois.', 0, 0, '2018-04-'),
(3, 3, 1, 2, 'Mirabelle', 'Boibrillant', '2000-03-', 'test3@gmail.com', '8193331111#1234', 'https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png', 'Je suis la fille de Carole.', 'Enfant de Carole', 'Tout les jours', 'Le premier mercredi des mois d\'automne', 0, 0, '20180430'),
(4, 1, 1, 1, 'Michel', 'Trudeau', '20011201', 'test4@gmail.com', '018191111#1234', 'https://www.jobypro.com/up/pi/pr/default.jpg', 'Bonjour! Je suis content d\'avoir finallement reçu ma casquette grise.', 'Il a la tuberculose.', 'Seulement les lundi et mardi en après-midi.', 'Quand mon père dit que je suis malade', 0, 0, '20180429'),
(5, 1, 1, 9, 'Luc', 'Ducharme', '1998', 'test5@gmail.com', '8195554321#1234', 'https://www.jobypro.com/up/pi/pr/default.jpg', 'Veuillez m’appeler si vous avez des questions sur mes exigences alimentaires.', 'L\'athlète aime les chats.', 'Seulement s\'il pleu', 'Seulement s\'il fait beau', 0, 0, '20180427');

-- --------------------------------------------------------

--
-- Table structure for table `athlete_category`
--

CREATE TABLE `athlete_category` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `athlete_category`
--

INSERT INTO `athlete_category` (`id`, `name`, `description`) VALUES
(0, 'Aucune', 'Aucune catégorie définie.'),
(1, 'Rally-Cap', 'Athlète du Rally-Cap de base.');

-- --------------------------------------------------------

--
-- Table structure for table `athlete_group`
--

CREATE TABLE `athlete_group` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `athlete_group`
--

INSERT INTO `athlete_group` (`id`, `name`, `description`) VALUES
(0, 'Aucun', 'Aucun groupe d\'athlète.'),
(1, 'Groupe des Blanc A', 'Premier groupe à évaluer dans ayant des casquettes blanches.'),
(2, 'Groupe des Gris A', 'Le groupe à évaluer dans ayant des casquettes grises.'),
(3, 'Groupe des Noir A', 'Le groupe à évaluer dans ayant des casquettes noires.'),
(4, 'Groupe des Vert A', 'Le groupe à évaluer dans ayant des casquettes vertes.');

-- --------------------------------------------------------

--
-- Table structure for table `cap`
--

CREATE TABLE `cap` (
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Blanc',
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cap`
--

INSERT INTO `cap` (`code`, `name`, `description`, `color`) VALUES
('Aucune', 'Aucune casquette', NULL, 'F0F0F0'),
('Blanc', 'Casquette blanche', 'Première casquette aquise lors des parcours de Rally-Cap.', 'FFFFFF'),
('Gris', 'Casquette grise', 'Deuxième casquette aquise lors des parcours de Rally-Cap.', '808080'),
('Noir', 'Casquette noire', 'Troisième casquette aquise lors des parcours de Rally-Cap.', '000000'),
('Vert', 'Casquette verte', 'Première casquette aquise après le Rally-Cap monochrome, donc dans le Rally-Cap couleur', '32CD32');

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `id` int(11) NOT NULL,
  `address` int(11) DEFAULT '1',
  `gender` int(11) DEFAULT '0',
  `first_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_url` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'default_image_url (to define)',
  `profile_info` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(127) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `availabilities` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `holidays` varchar(254) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `banned` tinyint(1) DEFAULT '0',
  `inactive` tinyint(1) DEFAULT '0',
  `creation_date` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`id`, `address`, `gender`, `first_name`, `name`, `birthday`, `email`, `phone_number`, `profile_image_url`, `profile_info`, `comments`, `availabilities`, `holidays`, `banned`, `inactive`, `creation_date`) VALUES
(1, 1, 9, 'Carole', 'Trépanier', '19880218', 'test.a@gmail.com', '8195551234#123', 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973461_1280.png', 'Mon profil est le meilleur.', 'Évalue les athlètes constament à la hause.', 'Tout les jours sauf les vendredi et samedi.', 'Durant l\'été.', 0, 0, '2018-04-'),
(2, 2, 0, 'Martin', 'Hamilton', '19890506', 'test.b@gmail.com', '018195551234', 'https://www.stori.si/wp-content/uploads/2015/09/blank_avatar-450x450.jpg', 'Dorénavant, je vais devoir vendre mes gants plus chèr. Ils seront à 12$ l\'unité.', 'Ses gants font furreur.', 'Tout les jours sauf la première semaine de chaque mois.', 'Du 23 au 28 mai.', 0, 0, '2018-04-');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_type`, `name`) VALUES
(0, 0, 'Aucun parcours'),
(1, 1, 'Parcour des caquettes blanches'),
(2, 1, 'Parcour des caquettes grises'),
(3, 1, 'Parcour des caquettes noirs'),
(4, 2, 'Parcour des caquettes vertes'),
(5, 2, 'Parcour des caquettes bleues'),
(6, 2, 'Parcour des caquettes rouges');

-- --------------------------------------------------------

--
-- Table structure for table `course_type`
--

CREATE TABLE `course_type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course_type`
--

INSERT INTO `course_type` (`id`, `name`, `description`) VALUES
(0, 'Aucune', 'Catégorie de parcours non définie.'),
(1, 'Rally-Cap monochrome', 'Parcour des athlète du premier volet d\'épreuves du Rally-Cap. Comprend les casquettes blanches au casquettes noirs.'),
(2, 'Rally-Cap couleur', 'Parcour des athlète du deuxième volet d\'épreuves du Rally-Cap. Comprend les casquettes vertes au casquettes rouges.');

-- --------------------------------------------------------

--
-- Table structure for table `drill`
--

CREATE TABLE `drill` (
  `id` int(11) NOT NULL,
  `cap` varchar(12) COLLATE utf8_unicode_ci DEFAULT 'Aucune',
  `drill_type` int(11) DEFAULT '0',
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `goal` text COLLATE utf8_unicode_ci,
  `allowed_tries` int(11) DEFAULT NULL,
  `success_treshold` double DEFAULT NULL,
  `allowed_time` int(11) DEFAULT NULL,
  `failure_treshold` double DEFAULT NULL,
  `obsolote` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drill`
--

INSERT INTO `drill` (`id`, `cap`, `drill_type`, `name`, `goal`, `allowed_tries`, `success_treshold`, `allowed_time`, `failure_treshold`, `obsolote`) VALUES
(0, 'Aucune', 0, 'Aucune', 'Épreuve non définie.', NULL, NULL, NULL, NULL, 1),
(1, 'Blanc', 1, 'Kangooroo', 'Sauter au travers des bornes.', 2, 8, 5, 2, 0),
(2, 'Gris', 2, 'Lancer du poids', 'Lancer les balles sur une distance de 10 m.', 2, 10, 8, 5, 0),
(3, 'Vert', 2, 'Lancer plus loing', 'Lancer les balles sur une distance de 15 m.', 2, 8, 5, 2, 0),
(4, 'Blanc', 3, 'Attraper-les toutes!', 'Attraper 10 balles sur 15.', 3, 10, 5, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `drill_type`
--

CREATE TABLE `drill_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drill_type`
--

INSERT INTO `drill_type` (`id`, `name`, `description`) VALUES
(0, 'Aucune catégorie', 'Catégorie de l\'épreuve non définie.'),
(1, 'Mouvement fondamentaux', 'Épreuve qui évalue les habiletés requises pour les déplacements de bases et de performances.'),
(2, 'Lancer', 'Épreuve qui évalue les habiletés à lancer une balle d\'une manière spécifique.'),
(3, 'Réception', 'Épreuve qui évalue les habiletés à attraper une balle d\'une manière spécifique.'),
(4, 'Frappe', 'Épreuve qui évalue les habiletés à frapper une balle d\'une manière spécifique.'),
(5, 'Course aux bases', 'Épreuve qui évalue les compétences en lien avec la course sur un terrain de baseball.');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `field` int(11) NOT NULL DEFAULT '0',
  `coach` int(11) NOT NULL DEFAULT '0',
  `drill` int(11) NOT NULL DEFAULT '0',
  `athlete` int(11) NOT NULL DEFAULT '0',
  `period` int(11) NOT NULL DEFAULT '0',
  `date` date DEFAULT NULL,
  `numerical_value` double DEFAULT NULL,
  `result_message` text COLLATE utf8_unicode_ci,
  `result_state` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci,
  `obsolete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `field`, `coach`, `drill`, `athlete`, `period`, `date`, `numerical_value`, `result_message`, `result_state`, `comment`, `obsolete`) VALUES
(0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, NULL, 1),
(1, 1, 2, 1, 1, 1, '2018-04-29', 3.5, 'Échec de l\'épreuve par manque de temps.', 3, 'L\'athlète a besoin de plus d\'entrainement.', 0),
(2, 2, 1, 2, 2, 2, '2018-04-30', 10, 'Aucune balle n\'a été ratée.', 2, 'L\'athlète a réussi de battre son record.', 0),
(3, 2, 1, 3, 1, 2, '2018-04-30', 8, 'Seulement deux raté, ca passe', 2, 'L\'athlète a réussi de battre son record.', 0),
(4, 2, 1, 4, 1, 2, '2018-04-30', 5, 'Ouf', 3, 'L\'athlète doit travailler la force de son lancer', 0),
(5, 2, 1, 3, 2, 2, '2018-04-30', 0, 'Aucune balle n\'a été réussie.', 3, 'l\'athlète est un poisson??.', 0);
-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `title` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `title`) VALUES
(0, 'Inconnu'),
(1, 'Homme'),
(2, 'Femme'),
(9, 'Non applicable');

-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

CREATE TABLE `layout` (
  `id` int(11) NOT NULL,
  `drill` int(11) DEFAULT '0',
  `layout_type` int(11) DEFAULT '0',
  `image_url` varchar(254) COLLATE utf8_unicode_ci DEFAULT 'default_image_url (to define)',
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `drill`, `layout_type`, `image_url`, `description`) VALUES
(0, 0, 0, 'default_image_url (to define)', 'Description du schéma.'),
(1, 1, 1, 'https://drive.google.com/file/d/1a6IL8vOq0l0XGaRtvV09kAHVVvCInkf4/preview', 'Catégorie d\'exercice : Agilité\nSauter par dessus la ligne 10 fois (Devrait être dans le layout scénario inclu dans le drill).'),
(2, 1, 3, 'https://drive.google.com/file/d/19J8wnWHWiWg-of61zkP2GCMFnQ05YoSt/preview', 'Petits cônes, marqueurs, ligne du terrain.');

-- --------------------------------------------------------

--
-- Table structure for table `layout_type`
--

CREATE TABLE `layout_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `layout_type`
--

INSERT INTO `layout_type` (`id`, `name`, `description`) VALUES
(0, 'Schéma vide', 'Schéma non défini.'),
(1, 'Description', 'Information générale sur l\'épreuve.'),
(2, 'Variations', 'Versions à faire durant l\'épreuve pour qu\'elle soit complétée.'),
(3, 'Équipement', 'Matériel ou environnement requis pour pouvoir procéder aux variations de l\'épreuve.'),
(4, 'Aspect clé', 'Aspects importants pour que l\'épreuve soit évalué correctement.');

-- --------------------------------------------------------

--
-- Table structure for table `statistic`
--

CREATE TABLE `statistic` (
  `id` int(11) NOT NULL,
  `hits` double DEFAULT NULL,
  `throws` double DEFAULT NULL,
  `catchs` double DEFAULT NULL,
  `speed` double DEFAULT NULL,
  `global` double DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `statistic`
--

INSERT INTO `statistic` (`id`, `hits`, `throws`, `catchs`, `speed`, `global`, `comments`) VALUES
(1, 3, 8.2, 4.4, 2.6, 1, NULL),
(2, 3.6, 1, 6, 4.9, 4.8, NULL),
(3, 2.8, 9, 10.2, 20, 13.5, NULL),
(4, 20, 13.5, 2.8, 9.1, 10, NULL),
(5, 9, 9.2, 17, 17.5, 2.3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ta_athlete_statistic`
--

CREATE TABLE `ta_athlete_statistic` (
  `athlete` int(11) NOT NULL DEFAULT '0',
  `statistics` int(11) NOT NULL,
  `cap` varchar(12) COLLATE utf8_unicode_ci DEFAULT 'Aucune'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ta_athlete_statistic`
--

INSERT INTO `ta_athlete_statistic` (`athlete`, `statistics`, `cap`) VALUES
(1, 1, 'Blanc'),
(2, 2, 'Blanc'),
(2, 3, 'Gris'),
(2, 4, 'Noir'),
(2, 5, 'Vert');

-- --------------------------------------------------------

--
-- Table structure for table `ta_cap_athlete`
--

CREATE TABLE `ta_cap_athlete` (
  `cap` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Blanc',
  `athlete` int(11) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ta_cap_athlete`
--

INSERT INTO `ta_cap_athlete` (`cap`, `athlete`, `start_date`, `end_date`) VALUES
('Blanc', 1, '2018-04-28', '0000-00-00'),
('Blanc', 2, '2018-04-26', '2018-04-27'),
('Gris', 2, '2018-04-27', '2018-04-28'),
('Noir', 2, '2018-04-28', '2018-04-29'),
('Vert', 2, '2018-04-29', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `ta_course_drill`
--

CREATE TABLE `ta_course_drill` (
  `course` int(11) NOT NULL DEFAULT '0',
  `drill` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ta_course_drill`
--

INSERT INTO `ta_course_drill` (`course`, `drill`) VALUES
(1, 1),
(1, 4),
(2, 2),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ta_course_group`
--

CREATE TABLE `ta_course_group` (
  `course` int(11) NOT NULL DEFAULT '0',
  `athlete_group` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ta_course_group`
--

INSERT INTO `ta_course_group` (`course`, `athlete_group`) VALUES
(1, 1),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ta_group_athlete`
--

CREATE TABLE `ta_group_athlete` (
  `athlete_group` int(11) NOT NULL DEFAULT '0',
  `athlete` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ta_group_athlete`
--

INSERT INTO `ta_group_athlete` (`athlete_group`, `athlete`) VALUES
(1, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ta_group_coach`
--

CREATE TABLE `ta_group_coach` (
  `access_type` int(11) NOT NULL DEFAULT '0',
  `athlete_group` int(11) NOT NULL DEFAULT '0',
  `coach` int(11) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ta_group_coach`
--

INSERT INTO `ta_group_coach` (`access_type`, `athlete_group`, `coach`, `start_date`, `end_date`) VALUES
(1, 1, 1, '2018-04-29', '2018-04-30'),
(1, 2, 2, '2018-05-31', NULL),
(2, 1, 2, '2018-03-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type` int(11) DEFAULT '0',
  `coach` int(11) DEFAULT '0',
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `coach`, `username`, `password_hash`) VALUES
(2, 1, 2, 'admin', '$2y$10$juVGbqwxOfDgoyOSFw2ckOWQcrNMYOO6BWhGHWMQHT0.VzCbnaRJm'),
(3, 2, 1, 'coach', '$2y$10$EG8x3q9pH9kl8MspoH1PZOtuLM.YonD.RxGNimCGsNeskFayvyMsG');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `permission_level` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `description`, `permission_level`) VALUES
(0, 'Aucune', 'Aucune catégorie d\'utilisateur a été définie.', 0),
(1, 'Admin', 'Administrateur de l\'application Web TrackPark.', 255),
(2, 'Coach', 'Évaluateur ayant accès à l\'application Web TrackPark.', 1);

--
-- Indexes for dumped tables
--

CREATE TABLE `session` (
    `user_id` int (11) NOT NULL,
    `token` varchar(32) NOT NULL
)

ALTER TABLE `session`
  ADD PRIMARY KEY (`user_id`,`token`),

--
-- Indexes for table `access_type`
--
ALTER TABLE `access_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `athlete`
--
ALTER TABLE `athlete`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `address` (`address`),
  ADD KEY `gender` (`gender`),
  ADD KEY `athlete_category` (`athlete_category`);

--
-- Indexes for table `athlete_category`
--
ALTER TABLE `athlete_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `athlete_group`
--
ALTER TABLE `athlete_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cap`
--
ALTER TABLE `cap`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `address` (`address`),
  ADD KEY `gender` (`gender`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_type_fk` (`course_type`);

--
-- Indexes for table `course_type`
--
ALTER TABLE `course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drill`
--
ALTER TABLE `drill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drill_type` (`drill_type`),
  ADD KEY `cap` (`cap`);

--
-- Indexes for table `drill_type`
--
ALTER TABLE `drill_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drill_fk3` (`drill`),
  ADD KEY `athlete_fk7` (`athlete`),
  ADD KEY `field` (`field`),
  ADD KEY `coach` (`coach`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout`
--
ALTER TABLE `layout`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layout_type_fk` (`layout_type`),
  ADD KEY `drill` (`drill`);

--
-- Indexes for table `layout_type`
--
ALTER TABLE `layout_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistic`
--
ALTER TABLE `statistic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ta_athlete_statistic`
--
ALTER TABLE `ta_athlete_statistic`
  ADD PRIMARY KEY (`athlete`,`statistics`),
  ADD KEY `statistic_fk` (`statistics`),
  ADD KEY `cap` (`cap`);

--
-- Indexes for table `ta_cap_athlete`
--
ALTER TABLE `ta_cap_athlete`
  ADD PRIMARY KEY (`cap`,`athlete`),
  ADD KEY `athlete_fk` (`athlete`);

--
-- Indexes for table `ta_course_drill`
--
ALTER TABLE `ta_course_drill`
  ADD PRIMARY KEY (`course`,`drill`),
  ADD KEY `drill_fk1` (`drill`);

--
-- Indexes for table `ta_course_group`
--
ALTER TABLE `ta_course_group`
  ADD PRIMARY KEY (`course`,`athlete_group`),
  ADD KEY `group_fk3` (`athlete_group`);

--
-- Indexes for table `ta_group_athlete`
--
ALTER TABLE `ta_group_athlete`
  ADD PRIMARY KEY (`athlete_group`,`athlete`),
  ADD KEY `athlete_fk1` (`athlete`);

--
-- Indexes for table `ta_group_coach`
--
ALTER TABLE `ta_group_coach`
  ADD PRIMARY KEY (`access_type`,`athlete_group`,`coach`),
  ADD KEY `access_type` (`access_type`),
  ADD KEY `athlete_group` (`athlete_group`),
  ADD KEY `coach` (`coach`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluator_fk6` (`coach`),
  ADD KEY `user_type_fk` (`user_type`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_type`
--
ALTER TABLE `access_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `athlete`
--
ALTER TABLE `athlete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `athlete_category`
--
ALTER TABLE `athlete_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `athlete_group`
--
ALTER TABLE `athlete_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_type`
--
ALTER TABLE `course_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drill`
--
ALTER TABLE `drill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `drill_type`
--
ALTER TABLE `drill_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `layout`
--
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `layout_type`
--
ALTER TABLE `layout_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `statistic`
--
ALTER TABLE `statistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `athlete`
--
ALTER TABLE `athlete`
  ADD CONSTRAINT `athlete_ibfk_1` FOREIGN KEY (`address`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `athlete_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `gender` (`id`),
  ADD CONSTRAINT `athlete_ibfk_3` FOREIGN KEY (`athlete_category`) REFERENCES `athlete_category` (`id`);

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`address`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `gender` (`id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_type_fk` FOREIGN KEY (`course_type`) REFERENCES `course_type` (`id`);

--
-- Constraints for table `drill`
--
ALTER TABLE `drill`
  ADD CONSTRAINT `drill_ibfk_1` FOREIGN KEY (`drill_type`) REFERENCES `drill_type` (`id`),
  ADD CONSTRAINT `drill_ibfk_2` FOREIGN KEY (`cap`) REFERENCES `cap` (`code`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `drill_fk3` FOREIGN KEY (`drill`) REFERENCES `drill` (`id`),
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`athlete`) REFERENCES `athlete` (`id`),
  ADD CONSTRAINT `evaluation_ibfk_4` FOREIGN KEY (`coach`) REFERENCES `coach` (`id`),
  ADD CONSTRAINT `evaluation_ibfk_5` FOREIGN KEY (`field`) REFERENCES `address` (`id`);

--
-- Constraints for table `layout`
--
ALTER TABLE `layout`
  ADD CONSTRAINT `layout_ibfk_1` FOREIGN KEY (`drill`) REFERENCES `drill` (`id`),
  ADD CONSTRAINT `layout_ibfk_2` FOREIGN KEY (`layout_type`) REFERENCES `layout_type` (`id`);

--
-- Constraints for table `ta_athlete_statistic`
--
ALTER TABLE `ta_athlete_statistic`
  ADD CONSTRAINT `statistic_fk` FOREIGN KEY (`statistics`) REFERENCES `statistic` (`id`),
  ADD CONSTRAINT `ta_athlete_statistic_ibfk_2` FOREIGN KEY (`cap`) REFERENCES `cap` (`code`),
  ADD CONSTRAINT `ta_athlete_statistic_ibfk_3` FOREIGN KEY (`athlete`) REFERENCES `athlete` (`id`);

--
-- Constraints for table `ta_cap_athlete`
--
ALTER TABLE `ta_cap_athlete`
  ADD CONSTRAINT `cap_fk` FOREIGN KEY (`cap`) REFERENCES `cap` (`code`),
  ADD CONSTRAINT `ta_cap_athlete_ibfk_1` FOREIGN KEY (`athlete`) REFERENCES `athlete` (`id`);

--
-- Constraints for table `ta_course_drill`
--
ALTER TABLE `ta_course_drill`
  ADD CONSTRAINT `course_fk7` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `drill_fk1` FOREIGN KEY (`drill`) REFERENCES `drill` (`id`);

--
-- Constraints for table `ta_course_group`
--
ALTER TABLE `ta_course_group`
  ADD CONSTRAINT `course_fk1` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `group_fk3` FOREIGN KEY (`athlete_group`) REFERENCES `athlete_group` (`id`);

--
-- Constraints for table `ta_group_athlete`
--
ALTER TABLE `ta_group_athlete`
  ADD CONSTRAINT `group_fk` FOREIGN KEY (`athlete_group`) REFERENCES `athlete_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ta_group_athlete_ibfk_1` FOREIGN KEY (`athlete`) REFERENCES `athlete` (`id`);

--
-- Constraints for table `ta_group_coach`
--
ALTER TABLE `ta_group_coach`
  ADD CONSTRAINT `ta_group_coach_ibfk_1` FOREIGN KEY (`access_type`) REFERENCES `access_type` (`id`),
  ADD CONSTRAINT `ta_group_coach_ibfk_2` FOREIGN KEY (`athlete_group`) REFERENCES `athlete_group` (`id`),
  ADD CONSTRAINT `ta_group_coach_ibfk_3` FOREIGN KEY (`coach`) REFERENCES `coach` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`coach`) REFERENCES `coach` (`id`),
  ADD CONSTRAINT `user_type_fk` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `loginlogs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `loginlogs`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `loginlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;