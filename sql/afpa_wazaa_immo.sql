-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 fév. 2025 à 15:03
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `afpa_wazaa_immo`
--
CREATE DATABASE IF NOT EXISTS `afpa_wazaa_immo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `afpa_wazaa_immo`;

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonces`
--

DROP TABLE IF EXISTS `waz_annonces`;
CREATE TABLE IF NOT EXISTS `waz_annonces` (
  `an_id` int(11) NOT NULL AUTO_INCREMENT,
  `an_pieces` int(11) DEFAULT NULL,
  `an_titre` varchar(200) NOT NULL,
  `an_ref` varchar(10) NOT NULL,
  `an_description` text NOT NULL,
  `an_local` varchar(100) DEFAULT NULL,
  `an_surf_hab` int(11) DEFAULT NULL,
  `an_surf_tot` int(11) NOT NULL,
  `an_prix` varchar(13) DEFAULT NULL,
  `an_diagnostic` varchar(1) NOT NULL,
  `an_d_ajout` date NOT NULL,
  `an_d_modif` datetime DEFAULT NULL,
  `an_statut` tinyint(1) NOT NULL,
  `an_vues` int(11) NOT NULL,
  `tb_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`an_id`),
  KEY `tb_id` (`tb_id`),
  KEY `u_id` (`u_id`),
  KEY `to_id` (`to_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_annonces`
--

INSERT INTO `waz_annonces` (`an_id`, `an_pieces`, `an_titre`, `an_ref`, `an_description`, `an_local`, `an_surf_hab`, `an_surf_tot`, `an_prix`, `an_diagnostic`, `an_d_ajout`, `an_d_modif`, `an_statut`, `an_vues`, `tb_id`, `u_id`, `to_id`) VALUES
(1, 5, '100 km de Paris, maison 85m2 avec jardin', '20A100', 'Exclusivité : dans bourg tous commerces avec écoles, maison d\'environ 85m2 habitables, mitoyenne, offrant en rez-de-chaussée, une cuisine aménagée, un salon-séjour, un WC et une loggia et à l\'étage, 3 chambres dont 2 avec placard, salle de bains et WC séparé. 2 garages. Le tout sur une parcelle de 225m2. Chauffage individuel clim réversible, DPE : F. ', 'Somme (80), 1h00 de Paris', 85, 225, '197000', 'F', '2020-11-13', '2025-02-13 14:59:11', 1, 17, 1, 1, 1),
(4, 5, '10 km de Paris, maison 85m2 avec jardin', '20A100', 'test', 'omme (80), 1h00 de Paris', 85, 225, '12.00', 'A', '2025-02-13', NULL, 0, 5, 2, 1, 1),
(5, 5, '10 km de Paris, maison 85m2 avec jardin', '20A100', 'test', 'omme (80), 1h00 de Paris', 85, 225, '12.00', 'A', '2025-02-13', NULL, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `waz_options`
--

DROP TABLE IF EXISTS `waz_options`;
CREATE TABLE IF NOT EXISTS `waz_options` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`opt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_options`
--

INSERT INTO `waz_options` (`opt_id`, `opt_libelle`) VALUES
(1, 'Jardin'),
(2, 'Garage'),
(3, 'Parking'),
(4, 'Piscine'),
(5, 'Combles aménageables'),
(6, 'Cuisine ouverte'),
(7, 'Sans travaux'),
(8, 'Avec travaux'),
(9, 'Cave'),
(10, 'Plain-pied'),
(11, 'Ascenseur'),
(12, 'Terrasse/balcon'),
(13, 'Cheminée');

-- --------------------------------------------------------

--
-- Structure de la table `waz_opt_annonces`
--

DROP TABLE IF EXISTS `waz_opt_annonces`;
CREATE TABLE IF NOT EXISTS `waz_opt_annonces` (
  `an_id` int(11) NOT NULL,
  `opt_id` int(11) NOT NULL,
  PRIMARY KEY (`an_id`,`opt_id`),
  KEY `opt_id` (`opt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_photos`
--

DROP TABLE IF EXISTS `waz_photos`;
CREATE TABLE IF NOT EXISTS `waz_photos` (
  `pht_id` int(11) NOT NULL AUTO_INCREMENT,
  `pht_libelle` varchar(50) DEFAULT NULL,
  `an_id` int(11) NOT NULL,
  PRIMARY KEY (`pht_id`),
  KEY `an_id` (`an_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_photos`
--

INSERT INTO `waz_photos` (`pht_id`, `pht_libelle`, `an_id`) VALUES
(1, '1-1.jpg', 1),
(2, '1-2.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--

DROP TABLE IF EXISTS `waz_type_bien`;
CREATE TABLE IF NOT EXISTS `waz_type_bien` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`tb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_bien`
--

INSERT INTO `waz_type_bien` (`tb_id`, `tb_libelle`) VALUES
(1, 'maison'),
(2, 'appartement'),
(3, 'immeuble'),
(4, 'garage'),
(5, 'terrain'),
(6, 'locaux professionnels'),
(7, 'bureaux'),
(8, 'studio');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--

DROP TABLE IF EXISTS `waz_type_offre`;
CREATE TABLE IF NOT EXISTS `waz_type_offre` (
  `to_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`to_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_offre`
--

INSERT INTO `waz_type_offre` (`to_id`, `to_libelle`) VALUES
(1, 'achat'),
(2, 'location'),
(3, 'viager');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_utilisateur`
--

DROP TABLE IF EXISTS `waz_type_utilisateur`;
CREATE TABLE IF NOT EXISTS `waz_type_utilisateur` (
  `tu_id` int(11) NOT NULL AUTO_INCREMENT,
  `tu_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`tu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_utilisateur`
--

INSERT INTO `waz_type_utilisateur` (`tu_id`, `tu_libelle`) VALUES
(1, 'admin'),
(2, 'employé');

-- --------------------------------------------------------

--
-- Structure de la table `waz_utilisateur`
--

DROP TABLE IF EXISTS `waz_utilisateur`;
CREATE TABLE IF NOT EXISTS `waz_utilisateur` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_email` varchar(50) NOT NULL,
  `u_password` varchar(250) NOT NULL,
  `tu_id` int(11) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `tu_id` (`tu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_utilisateur`
--

INSERT INTO `waz_utilisateur` (`u_id`, `u_email`, `u_password`, `tu_id`) VALUES
(1, 'placeholder@test.com', '$2y$10$SEQSBGYb9kANUEHESZRtBu3oUfObmnhmpxvWa4VK1jyEvzdlGvoei', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD CONSTRAINT `waz_annonces_ibfk_1` FOREIGN KEY (`tb_id`) REFERENCES `waz_type_bien` (`tb_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `waz_utilisateur` (`u_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_3` FOREIGN KEY (`to_id`) REFERENCES `waz_type_offre` (`to_id`);

--
-- Contraintes pour la table `waz_opt_annonces`
--
ALTER TABLE `waz_opt_annonces`
  ADD CONSTRAINT `waz_opt_annonces_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`),
  ADD CONSTRAINT `waz_opt_annonces_ibfk_2` FOREIGN KEY (`opt_id`) REFERENCES `waz_options` (`opt_id`);

--
-- Contraintes pour la table `waz_photos`
--
ALTER TABLE `waz_photos`
  ADD CONSTRAINT `waz_photos_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`);

--
-- Contraintes pour la table `waz_utilisateur`
--
ALTER TABLE `waz_utilisateur`
  ADD CONSTRAINT `waz_utilisateur_ibfk_1` FOREIGN KEY (`tu_id`) REFERENCES `waz_type_utilisateur` (`tu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
