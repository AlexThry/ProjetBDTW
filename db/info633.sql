-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 26 mai 2023 à 13:34
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
-- Structure de la table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `id_user` int NOT NULL,
  `id_question` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_user` (`id_user`),
  KEY `fk_id_question` (`id_question`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`id`, `content`, `id_user`, `id_question`) VALUES
(1, 'Exactement.\nPour une association de 1 à 1, il faut choisir un sens et reporter la clé dans l’autre relation. Pour guider votre choix, vous pouvez privilégier la clé la plus simple (nombre, sans caractères)', 1, 2),
(2, 'Il y a une erreur à la ligne 7, vous avez oublié d\'ajouter un \";\". Faites attention dans le reste du code, vous ne prenez pas en compte le cas où l\'utilisateur n\'a pas encore de compte, pensez à archiver. bip.', 2, 1),
(3, 'Tu créer pas de table. C\'est une vraie question ou tu me poses une question ? C\'est un piège *sourire gênant*. J\'crois qu\'on se comprends plus... Qu\'est ce que tu fait ?', 5, 12),
(4, 'La différence entre une jointure et un produit cartésien réside dans le résultat obtenu.\n\nDans un produit cartésien, toutes les combinaisons possibles entre les enregistrements de deux tables sont retournées, sans tenir compte d\'aucune condition. Le produit cartésien est généralement noté par le symbole ×.\n\nEn revanche, une jointure est une opération qui combine les enregistrements de deux tables en fonction d\'une condition spécifique. La condition de jointure est généralement basée sur des valeurs communes dans les colonnes des tables. Le résultat de la jointure est un sous-ensemble des enregistrements des tables d\'origine qui satisfont la condition de jointure.', 3, 11),
(5, 'Les jointures LEFT JOIN et RIGHT JOIN servent à combiner les enregistrements de deux tables en fonction d\'une condition de jointure spécifiée, tout en incluant tous les enregistrements de l\'une des tables, même s\'ils ne correspondent à aucun enregistrement dans l\'autre table.\r\n\r\nDans un LEFT JOIN, tous les enregistrements de la table de gauche (la première table spécifiée dans la requête) sont inclus dans le résultat, qu\'ils correspondent ou non aux enregistrements de la table de droite (la deuxième table spécifiée). Si aucun enregistrement ne correspond dans la table de droite, les colonnes correspondantes contiendront des valeurs nulles.\r\n\r\nDans un RIGHT JOIN, c\'est l\'inverse : tous les enregistrements de la table de droite sont inclus, qu\'ils correspondent ou non aux enregistrements de la table de gauche.', 4, 10),
(6, 'Il est préférable d\'utiliser une requête SELECT imbriquée (subquery) lorsque vous avez besoin d\'effectuer une opération basée sur les résultats d\'une requête interne avant de les utiliser dans la requête externe. Cela peut être utile lorsque vous devez filtrer, agréger ou manipuler les données avant de les utiliser dans la requête principale. Les sous-requêtes sont généralement utilisées pour effectuer des opérations plus complexes et fournir des résultats intermédiaires.\n\nEn revanche, il est préférable d\'utiliser une jointure (JOIN) lorsque vous souhaitez combiner les données de plusieurs tables en fonction d\'une condition de jointure. Les jointures sont utilisées pour obtenir des informations provenant de différentes tables en les liant sur des colonnes communes. Cela permet de récupérer des enregistrements correspondants des tables liées, en utilisant une condition spécifiée, et de les combiner dans un résultat unique.', 6, 9),
(7, 'GROUP BY est utilisé pour regrouper les enregistrements en fonction des valeurs d\'une ou plusieurs colonnes. Il est couramment utilisé avec des fonctions d\'agrégation telles que SUM, COUNT, AVG, etc. pour obtenir des résultats agrégés par groupe. L\'instruction GROUP BY divise les enregistrements en groupes distincts selon les valeurs de la colonne spécifiée, ce qui permet d\'effectuer des calculs sur chaque groupe séparément.\r\n\r\nORDER BY, quant à lui, est utilisé pour trier les enregistrements du résultat d\'une requête en fonction des valeurs d\'une ou plusieurs colonnes', 7, 8);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `label`) VALUES
(6, 'git'),
(5, 'javascript'),
(4, 'HTML'),
(3, 'CSS'),
(2, 'PHP'),
(8, 'BD');

-- --------------------------------------------------------

--
-- Structure de la table `has_category`
--

DROP TABLE IF EXISTS `has_category`;
CREATE TABLE IF NOT EXISTS `has_category` (
  `id_question` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_question`,`id_category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `has_category`
--

INSERT INTO `has_category` (`id_question`, `id_category`) VALUES
(1, 2),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(6, 8),
(7, 8),
(9, 8),
(10, 8),
(11, 8),
(12, 8);

-- --------------------------------------------------------

--
-- Structure de la table `is_nearby`
--

DROP TABLE IF EXISTS `is_nearby`;
CREATE TABLE IF NOT EXISTS `is_nearby` (
  `id_question1` int(11) NOT NULL,
  `id_question2` int(11) NOT NULL,
  PRIMARY KEY (`id_question1`,`id_question2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `is_nearby`
--

INSERT INTO `is_nearby` (`id_question1`, `id_question2`) VALUES
(5, 2),
(5, 6),
(6, 5),
(7, 4),
(10, 11),
(11, 10);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_question` (`id_question`),
  KEY `fk_id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_question`, `id_user`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 2, 1),
(5, 2, 3),
(6, 2, 4),
(7, 2, 7),
(8, 3, 6),
(9, 3, 2),
(13, 5, 1),
(14, 5, 2),
(15, 5, 3),
(19, 7, 7),
(20, 7, 1),
(21, 7, 2),
(22, 8, 3),
(23, 8, 4),
(24, 8, 5),
(25, 9, 6),
(26, 9, 7),
(27, 10, 1),
(28, 10, 2),
(29, 10, 3),
(30, 11, 2),
(31, 11, 3),
(32, 11, 1),
(33, 11, 6),
(34, 12, 5),
(35, 12, 3),
(36, 12, 7),
(37, 12, 4);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` int NOT NULL AUTO_INCREMENT,
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

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `profile_url` text NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`user_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `is_admin`, `user_name`, `profile_url`, `password`, `email`) VALUES
(1, 'hugo', 'beaubrun', 0, 'beaubruh', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(2, 'ronan', 'terras', 0, 'ronang', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(3, 'carlyne', 'barrachin', 0, 'carlyne', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(4, 'Lois', 'Blin', 0, 'lois', 'https://img.freepik.com/vecteurs-premium/profil-avatar-illustration-coloree-2_549209-82.jpg?w=2000', '389a20c65b0987b03475f7d79c3ff974', 'blinlois@gmail.com'),
(5, 'alexis', 'thierry', 0, 'alexis', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(6, 'arnaud', 'pfundstein', 0, 'arnaud', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(7, 'ugo', 'tafaro', 0, 'ugo', '', '63a9f0ea7bb98050796b649e85481845', 'utafaro@gmail.com'),
(8, 'lionel', 'valet', 1, 'lionel', '', '63a9f0ea7bb98050796b649e85481845', NULL),
(9, 'ilham', 'alloui', 1, 'ilham', '', '63a9f0ea7bb98050796b649e85481845', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
