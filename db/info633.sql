-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 26 mai 2023 à 11:41
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
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_validator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `title`, `creation_date`, `content`, `id_user`, `id_validator`) VALUES
(1, 'Connexion à la base de donnée en PHP', '2023-02-02 00:00:00', 'J\'ai une erreur quand j\'essaye de connecter mon site à ma base de donnée mysql, j\'obtiens l\'error \"Vous n\'êtes pas qualifié pour parler de mon grand front\".\r\nVoici mon code :\r\n<?php\r\n$serveur = \"localhost\";\r\n$utilisateur = \"jeanlasticot\";\r\n$motdepasse = \"jesuisunasticot joyeux\";\r\n$base_de_donnees =\"aaaaaaugh\";\r\n\r\n$connexion = mysqli_connect($serveur, $utilisateur, $motdepasse, $base_de_donnees);\r\n\r\nif (!$connexion) {\r\n    die(\"Erreur de connexion à la base de données : \" . mysqli_connect_error());\r\n}', 2, 8),
(2, 'Transformation d’une association de 1 à 1', '2023-01-29 00:00:00', 'Bonjour, nous avons vu comment passer du schéma entités/associations au schéma relationnel pour des associations de 1 à plusieurs et de plusieurs à plusieurs. Mais pour une association de 1 à 1 comment cela se passe ? On ajoute n\'importe laquelle clé primaire d\'une entité dans la relation de l\'autre entité en tant que clé étrangère ?\r\n', 1, 9),
(3, 'Nommage des tables', '2023-01-30 00:00:00', 'Est ce qu\'il existe des conventions de nommages des tables / attributs dans le milieu professionnel de la base de donnés ?', 5, 9),
(4, 'Table et relation', '2023-01-30 00:00:00', 'Bonjour, je me demandais quelle est la différence entre une table et une relation ?', 3, NULL),
(5, 'Nombre de relation', '2023-01-30 00:00:00', 'est-il possible d\'avoir deux ou plusieurs relations entre deux mêmes entités ?', 6, 9),
(6, 'tuple et n-tuple', '2023-01-31 00:00:00', 'Que signifie \"tuple\" et \"n-uplet\" d\'un modèle ?', 7, NULL),
(7, 'Merise et modèle entité association', '2023-01-01 00:00:00', 'Quelles est la différence entre le modèle E/A et le modèle Merise ?\r\n', 4, 8),
(8, 'Groupe by et Order by', '2023-02-14 00:00:00', 'Quelle est la différence entre GROUP BY et ORDER BY ?', 1, 8),
(9, 'Join et select imbriqué', '2023-02-22 00:00:00', 'Bonjour, \r\n\r\nJe me demandais dans quelle situation il est préférable d\'utiliser un SELECT imbriquée et dans quelle situation il est préférable d\'utiliser un JOIN ?\r\n\r\nCordialement,\r\n\r\nUgo TAFARO', 3, 9),
(10, 'Left et right join en SQL', '2023-02-22 00:00:00', 'Bonjour, \r\n\r\nJe souhaiterais savoir à quoi servent les left et right join puisqu\'ils sélectionnent l\'intégralité d\'une seule table (comme un SELECT * FROM table).\r\n\r\nCordialement', 6, 8),
(11, 'Jointure et produit cartésien', '2023-02-22 00:00:00', 'Bonjour,\r\n\r\nj\'aimerais connaître la différence entre une jointure et un produit cartésien\r\n\r\nmerci,', 5, 9),
(12, 'Usage des vues', '2023-02-27 00:00:00', 'Quels sont les désavantages d\'utiliser une vue au lieu d\'une table ?', 2, 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
