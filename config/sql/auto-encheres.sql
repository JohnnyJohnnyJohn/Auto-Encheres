-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 14 avr. 2023 à 09:31
-- Version du serveur : 8.0.32-0ubuntu0.22.04.2
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `auto-encheres`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `uid_annonce` bigint UNSIGNED NOT NULL,
  `titre_annonce` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_depart` float UNSIGNED NOT NULL,
  `date_fin_enchere` bigint UNSIGNED NOT NULL,
  `modele` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `puissance` smallint UNSIGNED NOT NULL,
  `annee` smallint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`uid_annonce`, `titre_annonce`, `prix_depart`, `date_fin_enchere`, `modele`, `marque`, `puissance`, `annee`, `description`, `photo`) VALUES
(1, 'La BM de sa mère !', 92000, 1693479600, 'M3', 'BMW', 230, 2019, 'Cette BMW M3 déchire vraiment la race de sa mère.', 'bmw.jpg'),
(2, 'L\'Audi qui déchire sa race !', 122000, 1693479600, 'A3 RS6 Quattro Sportback', 'AUDI', 320, 2021, 'L\'AUDI de la mort qui tue. Achète mon fils !', 'audi.jpg'),
(3, 'Ma MercoBenz Zarma !', 94000, 1693479600, 'ML 300', 'MERCEDES', 280, 2020, 'Laisse moi ZoomZoomZing, dans ta Benz Benz Benz.', 'mercedes.jpg'),
(4, 'Bientôt ta Porsche veinard ?', 132000, 1693479600, 'TAYCAN GT3', 'PORSCHE', 230, 2022, 'La porsche de mes rêves, bordel !', 'porsche.jpg'),
(5, 'Fait chauffer Enzo !', 154000, 1693479600, '812 GTS', 'FERRARI', 430, 2019, 'Cette Ferrari n\'est pas rouge. Sacrilège !', 'ferrari.jpg'),
(6, 'Tu veux jouer avec la nouvelle Golf ?', 67000, 1693479600, 'Golf 8 Spider', 'VOLKSWAGEN', 190, 2019, 'Cette golf est une valeur sûre.', 'volkswagen.jpg'),
(7, 'C\'est toi le MAC ?', 145000, 1693479600, '570 GT', 'MC LAREN', 360, 2022, 'There is No Finish Line. There are no limit !', 'mclaren.jpg'),
(8, 'Ça balance du cheval grave !', 134000, 1693479600, 'Camaro', 'CHEVROLET', 560, 2022, 'Ça c\'est une voiture qu\'elle a des chevaux sous le capot !', 'chevrolet.jpg'),
(9, 'Drive your Ambition with a Mitsubishi', 76000, 1693479600, 'Lancer Evolution 6', 'MITSUBISHI', 180, 2020, 'La caisse là, elle mange la route grave ! ', 'mitsubishi.jpg'),
(10, 'Tu veux un moteur d\'avion sous le capot ?', 199000, 1693479600, 'Ghost', 'ROLLS ROYCE', 571, 2020, 'Elle pèse 2,5 tonnes la bête !', 'rollsroyce.jpg'),
(11, 'Alpine, en un seul mot !', 119000, 1693479600, 'A110', 'ALPINE', 280, 2022, 'Cocorico, Alpine est la seule marque française qui rivalise avec les voitures étrangères.', 'alpine.jpg'),
(12, 'We are Not Super Cars. We are Lamborghini !', 165000, 1693479600, 'Aventador LP 780-4 Ultimae Roadster', 'LAMBORGHINI', 480, 2022, 'Achète ça et tu perds tes deux bras...', 'lamborghini.jpg'),
(13, 'Tu veux frimer ?', 99000, 1693479600, 'RS8 Coupé Sport', 'AUDI', 280, 2021, 'Une AUDI sinon rien...', 'audi2.jpg'),
(14, 'Allie sensations de conduite et confort.', 95000, 1693479600, 'Corvette Grand Sport', 'CHEVROLET', 650, 2017, 'Ce nouveau modèle Grand Sport, c\'est bien la version \"puristes\".', 'chevrolet2.jpg'),
(15, 'Un SUV 100% électrique.', 176000, 1693479600, 'Purosangue', 'FERRARI', 454, 2022, 'Le premier SUV Ferrari.', 'ferrari2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `encheres`
--

CREATE TABLE `encheres` (
  `uid_enchere` bigint UNSIGNED NOT NULL,
  `uid_utilisateur` bigint UNSIGNED NOT NULL,
  `uid_annonce` bigint UNSIGNED NOT NULL,
  `date` bigint UNSIGNED NOT NULL,
  `montant` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `uid_utilisateur` bigint UNSIGNED NOT NULL,
  `nom` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`uid_utilisateur`, `nom`, `prenom`, `email`, `password`) VALUES
(1, 'DOE', 'John', 'john.doe@gmail.com', 'f94f09d6d7c1e4f151c0232cad774f0e'),
(2, 'Biden', 'Joe', 'president@fuckland.com', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`uid_annonce`);

--
-- Index pour la table `encheres`
--
ALTER TABLE `encheres`
  ADD PRIMARY KEY (`uid_enchere`),
  ADD KEY `fk_enchere_utilisateur` (`uid_utilisateur`),
  ADD KEY `fk_enchere_annonce` (`uid_annonce`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`uid_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `uid_annonce` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `encheres`
--
ALTER TABLE `encheres`
  MODIFY `uid_enchere` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `uid_utilisateur` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `encheres`
--
ALTER TABLE `encheres`
  ADD CONSTRAINT `fk_enchere_annonce` FOREIGN KEY (`uid_annonce`) REFERENCES `annonces` (`uid_annonce`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enchere_utilisateur` FOREIGN KEY (`uid_utilisateur`) REFERENCES `utilisateurs` (`uid_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
