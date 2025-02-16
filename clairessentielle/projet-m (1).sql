-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 29 oct. 2024 à 15:31
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet-m`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `user_id`, `note`, `commentaire`, `date`) VALUES
(1, 2, 5, 'dd', '2024-10-01 10:17:15'),
(2, 2, 4, 'ee', '2024-10-01 10:17:22'),
(3, 2, 5, 'ee', '2024-10-01 10:17:25'),
(4, 2, 5, 'test', '2024-10-01 10:21:25'),
(5, 2, 1, 'je n\'aime pas', '2024-10-01 10:21:43'),
(6, 2, 5, 'cool boy', '2024-10-01 10:25:50'),
(7, 2, 5, 'mamadou top guy', '2024-10-01 13:59:49'),
(8, 1, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tempus pretium metus sed luctus. Proin quis ligula ut erat porttitor blandit nec quis tortor. Donec a ex malesuada, mollis elit et, ultrices metus. Etiam fringilla massa sapien, eget accumsan sapien pulvinar non. Cras eget aliquet tellus. In rhoncus ultricies volutpat. Integer a gravida est.', '2024-10-03 07:37:06');

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

DROP TABLE IF EXISTS `contenu`;
CREATE TABLE IF NOT EXISTS `contenu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` char(50) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `image_width` varchar(10) DEFAULT 'auto',
  `image_height` varchar(10) DEFAULT 'auto',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contenu`
--

INSERT INTO `contenu` (`id`, `class`, `contenu`, `image_url`, `image_width`, `image_height`) VALUES
(1, 'welcome-text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Pro', '../image/fleurs.jpg', '700', '400');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilites`
--

DROP TABLE IF EXISTS `disponibilites`;
CREATE TABLE IF NOT EXISTS `disponibilites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `disponibilites`
--

INSERT INTO `disponibilites` (`id`, `date`, `heure_debut`, `heure_fin`, `disponible`) VALUES
(1, '2024-10-23', '21:00:00', '22:00:00', 1),
(2, '2024-10-25', '18:00:00', '20:00:00', 0),
(3, '2024-10-25', '18:00:00', '20:00:00', 1),
(4, '2024-10-02', '18:00:00', '19:30:00', 1),
(5, '2024-10-03', '15:00:00', '17:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponibilite_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `disponibilite_id` (`disponibilite_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `date`, `heure_debut`, `heure_fin`, `disponibilite_id`, `user_id`) VALUES
(11, '2024-10-03', '15:00:00', '17:00:00', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `role`) VALUES
(1, 'Nazzuma', 'matisvivier2004@gmail.com', '$2y$10$ta/MfRa4oBKAoek0ScQaT.y7YnZ5Ol1v4q6pvply8RrwBEDy3BShy', '2024-09-19 07:27:57', 'admin'),
(2, 'test', 'test@gmail.com', '$2y$10$zgdhXSCozxK/wTNQZFvxCOez0Pskw9t4KuEfbsrkvWHYA7.c4mhaC', '2024-10-01 09:46:34', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
