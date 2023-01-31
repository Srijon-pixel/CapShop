-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 20 mai 2021 à 09:40
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_caps`
--

-- --------------------------------------------------------

--
-- Structure de la table `brands`
--

CREATE TABLE `brands` (
  `id_brand` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `brands`
--

INSERT INTO `brands` (`id_brand`, `name`) VALUES
(1, 'Gucci'),
(2, 'Versace'),
(3, 'Calvin Klein'),
(4, 'Tommy hilfiger'),
(5, 'Ralph Lauren'),
(13, 'test'),
(14, 'test3'),
(15, 'dssdsd'),
(16, 'asasas'),
(17, 'asdadad');

-- --------------------------------------------------------

--
-- Structure de la table `caps`
--

CREATE TABLE `caps` (
  `id_cap` int(11) NOT NULL,
  `id_model` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `quantity` int(5) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `caps`
--

INSERT INTO `caps` (`id_cap`, `id_model`, `price`, `description`, `quantity`) VALUES
(1, 1, '60.00', 'The new \"Elementary\" cap from Gucci.', 20),
(2, 2, '75.00', 'The new \"Flight session\" cap from Versace.', 0),
(3, 3, '55.50', 'The famous \"America\" edition of Versace !', 4),
(5, 4, '43.99', 'The new Falling Flowers cap!', 1),
(6, 5, '75.00', 'Don\'t fall with this new cap.', 20),
(7, 6, '40.00', 'Burning on the road with this famous cap.', 71),
(8, 7, '2.00', 'Used by the famous formula 1 driver, thomas smith.', 3),
(9, 8, '35.00', 'Nope.', 18),
(10, 9, '80.00', 'The famous boyband \"BTS\" released their brand new product in reference to their music \"Butterfly\".', 15),
(11, 10, '50.00', 'Underground and Techwear.', 4),
(12, 11, '45.50', 'M I N I M A L I S T E', 11);

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

CREATE TABLE `favorite` (
  `id_favorite` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `favorite`
--

INSERT INTO `favorite` (`id_favorite`, `id_user`, `id_cap`) VALUES
(8, 1, 9),
(10, 1, 2),
(12, 1, 11),
(13, 1, 12),
(14, 1, 10),
(16, 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `models`
--

CREATE TABLE `models` (
  `id_model` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `models`
--

INSERT INTO `models` (`id_model`, `name`, `id_brand`) VALUES
(1, 'Elementary', 1),
(2, 'Flight session', 2),
(3, 'America', 2),
(4, 'Falling flowers', 3),
(5, 'Dropdown', 4),
(6, 'Fast car', 5),
(7, 'Racing', 4),
(8, 'Nope.', 3),
(9, 'Butterfly', 1),
(10, 'Metropolitan', 3),
(11, 'Minimaliste', 4);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `is_confirmed` tinyint(4) DEFAULT '0',
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id_order`, `is_confirmed`, `total_price`, `order_date`, `id_user`) VALUES
(1, 0, '240.00', '2021-05-10', 1),
(2, 1, '89.49', '2021-05-11', 1),
(4, 0, '150.00', '2021-05-11', 2),
(5, 0, '50.00', '2021-05-12', 2),
(6, 1, '410.00', '2021-05-12', 1),
(7, 1, '150.00', '2021-05-12', 2),
(8, 0, '50.00', '2021-05-12', 2),
(9, 1, '252.50', '2021-05-12', 1),
(12, 0, '50.00', '2021-05-12', 2),
(14, 0, '45.50', '2021-05-19', 3),
(15, 0, '85.00', '2021-05-19', 3),
(16, 0, '47.50', '2021-05-19', 2);

-- --------------------------------------------------------

--
-- Structure de la table `order_caps`
--

CREATE TABLE `order_caps` (
  `id_order_caps` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_cap` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_caps`
--

INSERT INTO `order_caps` (`id_order_caps`, `id_order`, `id_cap`, `quantity`, `unit_price`) VALUES
(2, 1, 7, 3, '40.00'),
(3, 1, 9, 2, '35.00'),
(5, 1, 11, 1, '50.00'),
(6, 2, 5, 1, '43.99'),
(7, 2, 12, 1, '45.50'),
(9, 4, 11, 3, '50.00'),
(10, 5, 11, 1, '50.00'),
(11, 6, 10, 2, '80.00'),
(12, 6, 11, 5, '50.00'),
(13, 7, 11, 3, '50.00'),
(14, 8, 11, 1, '50.00'),
(15, 9, 7, 1, '40.00'),
(16, 9, 8, 1, '2.00'),
(17, 9, 9, 1, '35.00'),
(18, 9, 10, 1, '80.00'),
(19, 9, 11, 1, '50.00'),
(20, 9, 12, 1, '45.50'),
(29, 12, 11, 1, '50.00'),
(31, 14, 12, 1, '45.50'),
(32, 15, 9, 1, '35.00'),
(33, 15, 11, 1, '50.00'),
(34, 16, 8, 1, '2.00'),
(35, 16, 12, 1, '45.50');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `actif` int(1) NOT NULL DEFAULT '1',
  `admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `actif`, `admin`) VALUES
(1, 'Seebii', 'Pannatier.Sebastien@gmail.com', 'cf5b13dc39ead4eb3fa85f73ea9551bd2f38f75f33063817f69da38823fd06c7', 1, 0),
(2, 'admin', 'Sebastien.pnntr@eduge.ch', '8185c8ac4656219f4aa5541915079f7b3743e1b5f48bacfcc3386af016b55320', 1, 1),
(3, 'test', 'test@test.test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 1, 0),
(4, 'rrr', 'rrr@rrr.rrr', '12b0f0dcaefb10c02a83aa9adb025978ddb5512dc04eb39df6811c6a6bf9770c', 0, 0),
(5, 'Administrateur', 'administrateur@capshop.ch', '8185c8ac4656219f4aa5541915079f7b3743e1b5f48bacfcc3386af016b55320', 1, 1),
(6, 'Utilisateur', 'user@capshop.ch', '8185c8ac4656219f4aa5541915079f7b3743e1b5f48bacfcc3386af016b55320', 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id_brand`);

--
-- Index pour la table `caps`
--
ALTER TABLE `caps`
  ADD PRIMARY KEY (`id_cap`),
  ADD KEY `id_model` (`id_model`);

--
-- Index pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cap` (`id_cap`);

--
-- Index pour la table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id_model`),
  ADD KEY `id_brand` (`id_brand`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `order_caps`
--
ALTER TABLE `order_caps`
  ADD PRIMARY KEY (`id_order_caps`),
  ADD KEY `id_cap` (`id_cap`),
  ADD KEY `id_order` (`id_order`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `idx_email` (`email`),
  ADD KEY `idx_password` (`password`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `brands`
--
ALTER TABLE `brands`
  MODIFY `id_brand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `caps`
--
ALTER TABLE `caps`
  MODIFY `id_cap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id_favorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `models`
--
ALTER TABLE `models`
  MODIFY `id_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `order_caps`
--
ALTER TABLE `order_caps`
  MODIFY `id_order_caps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `caps`
--
ALTER TABLE `caps`
  ADD CONSTRAINT `caps_ibfk_1` FOREIGN KEY (`id_model`) REFERENCES `models` (`id_model`);

--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`id_cap`) REFERENCES `caps` (`id_cap`);

--
-- Contraintes pour la table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `models_ibfk_1` FOREIGN KEY (`id_brand`) REFERENCES `brands` (`id_brand`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `order_caps`
--
ALTER TABLE `order_caps`
  ADD CONSTRAINT `order_caps_ibfk_2` FOREIGN KEY (`id_cap`) REFERENCES `caps` (`id_cap`),
  ADD CONSTRAINT `order_caps_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
