-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 27 juin 2021 à 10:52
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projects`
--

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` text NOT NULL,
  `owner` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `image_url`, `owner`) VALUES
(16, 'IMG-60d85354b58993.14636809.jpg', 'fd3cd75440592e04b4cd2848b5cab78fee9f942f5d685d1ea865ac5beb584fbc'),
(15, 'IMG-60d85350bf5957.94177919.jpg', 'fd3cd75440592e04b4cd2848b5cab78fee9f942f5d685d1ea865ac5beb584fbc'),
(14, 'IMG-60d8534c30a679.48911191.jpg', 'fd3cd75440592e04b4cd2848b5cab78fee9f942f5d685d1ea865ac5beb584fbc'),
(13, 'IMG-60d8392bc27787.95834906.jpg', 'fd3cd75440592e04b4cd2848b5cab78fee9f942f5d685d1ea865ac5beb584fbc');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
