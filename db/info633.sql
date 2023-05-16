-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 16 mai 2023 à 16:14
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `info633`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `image_url` text NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`user_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `is_admin`, `user_name`, `image_url`, `password`) VALUES
(1, 'hugo', 'beaubrun', 1, 'beaubruh', '', '63a9f0ea7bb98050796b649e85481845'),
(2, 'ronan', 'terras', 1, 'ronang', '', '63a9f0ea7bb98050796b649e85481845'),
(3, 'carlyne', 'barrachin', 1, 'carlyne', '', '63a9f0ea7bb98050796b649e85481845'),
(4, 'lois', 'blin', 1, 'lois', '', '63a9f0ea7bb98050796b649e85481845'),
(5, 'alexis', 'thierry', 1, 'alexis', '', '63a9f0ea7bb98050796b649e85481845'),
(6, 'arnaud', 'pfundstein', 1, 'arnaud', '', '63a9f0ea7bb98050796b649e85481845'),
(7, 'ugo', 'tafaro', 1, 'ugo', '', '63a9f0ea7bb98050796b649e85481845'),
(8, 'lionel', 'valet', 0, 'lionel', '', '63a9f0ea7bb98050796b649e85481845'),
(9, 'ilham', 'alloui', 0, 'ilham', '', '63a9f0ea7bb98050796b649e85481845');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
