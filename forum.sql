-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 12 fév. 2020 à 09:20
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `titre`) VALUES
(1, 'Assistance'),
(2, 'Nouvelles et informations'),
(3, 'Discussions sur le jeu');

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_forum_reponses` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dislikes`
--

INSERT INTO `dislikes` (`id`, `id_forum_reponses`, `id_utilisateur`) VALUES
(31, 246, 5),
(30, 249, 5),
(24, 194, 1),
(14, 242, 4),
(12, 239, 4);

-- --------------------------------------------------------

--
-- Structure de la table `forum_reponses`
--

DROP TABLE IF EXISTS `forum_reponses`;
CREATE TABLE IF NOT EXISTS `forum_reponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `message` longtext NOT NULL,
  `date_reponse` datetime NOT NULL,
  `correspondance_sujet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum_reponses`
--

INSERT INTO `forum_reponses` (`id`, `auteur`, `message`, `date_reponse`, `correspondance_sujet`) VALUES
(246, 'admin', 'test', '2020-01-07 10:53:51', 90),
(239, 'admin', 'ok', '2020-01-05 12:23:19', 82),
(200, 'admin', 'ok', '2019-12-28 15:17:26', 89),
(197, 'admin', 'ok', '2019-12-24 15:10:01', 88),
(194, 'admin', 'ok', '2019-12-24 11:52:31', 82),
(247, 'admin', 'ok', '2020-01-07 10:54:54', 91),
(248, 'admin', 'Salut tous !', '2020-01-07 17:42:06', 92),
(249, 'admin', 'salut', '2020-01-09 10:21:43', 90),
(253, 'Firefou', 'Posez vos questions', '2020-01-31 11:07:47', 93),
(254, 'Walken99', 'Salut', '2020-02-11 14:34:07', 90);

-- --------------------------------------------------------

--
-- Structure de la table `forum_sujets`
--

DROP TABLE IF EXISTS `forum_sujets`;
CREATE TABLE IF NOT EXISTS `forum_sujets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `date_derniere_reponse` datetime NOT NULL,
  `titre` longtext NOT NULL,
  `correspondance_categorie` int(11) NOT NULL,
  `topic` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum_sujets`
--

INSERT INTO `forum_sujets` (`id`, `auteur`, `date_derniere_reponse`, `titre`, `correspondance_categorie`, `topic`) VALUES
(90, 'admin', '2020-02-11 14:34:07', 'test', 1, 1),
(92, 'admin', '2020-01-07 17:42:06', 'Gw2', 1, 3),
(93, 'Firefou', '2020-01-31 11:07:47', 'FAQ', 1, 3),
(89, 'admin', '2019-12-28 15:17:32', 'ok', 3, 14);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_forum_reponses` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_forum_reponses`, `id_utilisateur`) VALUES
(85, 251, 5),
(83, 249, 1),
(79, 248, 1),
(78, 246, 4),
(76, 247, 1),
(80, 246, 1),
(74, 197, 4),
(69, 197, 1),
(63, 244, 1),
(61, 242, 1),
(51, 194, 4);

-- --------------------------------------------------------

--
-- Structure de la table `sous_categorie`
--

DROP TABLE IF EXISTS `sous_categorie`;
CREATE TABLE IF NOT EXISTS `sous_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sous_categorie`
--

INSERT INTO `sous_categorie` (`id`, `titre`, `id_categorie`) VALUES
(1, 'Problème de compte et assistance technique', 1),
(2, 'Bugs : jeu, forum et site web', 1),
(3, 'Localisation / Traduction', 1),
(4, 'Acutalités et annonces', 2),
(5, 'Notes de mise à jour', 2),
(14, 'Coin de la communauté', 3),
(8, 'McM', 3),
(9, 'JcJ', 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `grade`) VALUES
(1, 'admin', '$2y$12$6DdTVMjrB9t6pcUoO2Gxwev2tSZFtQJVWCb9/CnhWkd3eHn3ntA4u', 1),
(4, 'Firefou', '$2y$12$PjEtar2ZAUZIB2AbG6RNaObl9NIfQZVpM8anYKvc7Tl275EW.6Ntm', 3),
(5, 'Walken99', '$2y$12$My8CCCtdtr/RzgSYHcRQqeMkaMqDwkx4KAQBhHsbG98bcMv0v/fcm', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
