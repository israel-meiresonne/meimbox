-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  jeu. 02 juil. 2020 à 21:11
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `meimbox`
--
CREATE DATABASE IF NOT EXISTS `meimbox2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `meimbox2`;

-- --------------------------------------------------------

--
-- Structure de la table `Actions`
--

CREATE TABLE `Actions` (
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Addresses`
--

CREATE TABLE `Addresses` (
  `userId` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `appartement` varchar(100) DEFAULT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Addresses`
--

INSERT INTO `Addresses` (`userId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `isActive`, `setDate`) VALUES
(651853948, 'place royele 4', '1640', 'belgium', NULL, 'Brabant-flamand', 'rhode-saint-genese', '+32 472 27 42 10', 1, '2020-02-28 00:00:00'),
(651853948, 'rue des bargeo 4', '4780', 'canada', 'boites 17', 'ma province perdu', 'ma ville perdu', '+ 428 28 48 90', 0, '2020-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Administrators`
--

CREATE TABLE `Administrators` (
  `adminID` int(11) NOT NULL,
  `lang_` varchar(10) NOT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `bithdate` date DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `sexe_` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Administrators`
--

INSERT INTO `Administrators` (`adminID`, `lang_`, `mail`, `password`, `firstname`, `lastname`, `bithdate`, `newsletter`, `sexe_`) VALUES
(1, 'en', NULL, NULL, 'SYSTEM', 'I&MEIM', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Basket-DiscountCodes`
--

CREATE TABLE `Basket-DiscountCodes` (
  `userId` varchar(25) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Basket-DiscountCodes`
--

INSERT INTO `Basket-DiscountCodes` (`userId`, `discount_code`, `setDate`) VALUES
(651853948, 'blackfriday25', '2020-03-02 00:00:00'),
(651853948, 'gmk10', '2020-02-11 00:00:00'),
(651853948, 'shera10', '2020-02-01 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Baskets-Box`
--

CREATE TABLE `Baskets-Box` (
  `userId` varchar(25) NOT NULL,
  `boxId` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Baskets-Box`
--

INSERT INTO `Baskets-Box` (`userId`, `boxId`) VALUES
(651853948, 'bx0987654321'),
(651853948, 'bx1234567890');

-- --------------------------------------------------------

--
-- Structure de la table `Baskets-Products`
--

CREATE TABLE `Baskets-Products` (
  `userId` varchar(25) NOT NULL,
  `prodId` int(11) NOT NULL,
  `sequenceID` varchar(100) NOT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `measureId` varchar(100) DEFAULT NULL,
  `cut_name` varchar(30) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Baskets-Products`
--

INSERT INTO `Baskets-Products` (`userId`, `prodId`, `sequenceID`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`) VALUES
(651853948, 6, 's-null-null', 's', NULL, NULL, NULL, 1, '2018-06-01 00:00:00'),
(651853948, 7, 'm-asos-null', 'm', 'asos', NULL, 'fit', 2, '2016-10-07 00:00:00'),
(651853948, 7, 'null-null-651853948137', NULL, NULL, '651853948172', 'wide', 4, '2020-02-21 00:00:00'),
(997763060, 8, 'null-null-997763060659', NULL, NULL, '651853948740', NULL, 3, '2017-08-18 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `BodyParts`
--

CREATE TABLE `BodyParts` (
  `bodyPart` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BodyParts`
--

INSERT INTO `BodyParts` (`bodyPart`) VALUES
('arm'),
('bust'),
('hip'),
('waist'),
('waist to floor');

-- --------------------------------------------------------

--
-- Structure de la table `Box-Products`
--

CREATE TABLE `Box-Products` (
  `boxId` varchar(100) NOT NULL,
  `prodId` int(11) NOT NULL,
  `sequenceID` varchar(100) NOT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `measureId` varchar(100) DEFAULT NULL,
  `cut_name` varchar(30) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Box-Products`
--

INSERT INTO `Box-Products` (`boxId`, `prodId`, `sequenceID`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`) VALUES
('bx0987654321', 1, 'm-asos-null', 'm', 'asos', NULL, 'wide', 1, '2020-07-24 00:00:00'),
('bx0987654321', 1, 'null-null-651853948740', NULL, NULL, '651853948740', 'fit', 1, '2017-04-11 00:00:00'),
('bx0987654321', 1, 's-null-null', 's', NULL, NULL, NULL, 2, '2018-09-10 00:00:00'),
('bx1234567890', 2, 'null-null-651853948740', NULL, NULL, '651853948172', 'wide', 3, '2017-02-24 00:00:00'),
('bx1234567890', 3, 'null-null-651853948740', NULL, NULL, '651853948740', 'fit', 1, '2019-07-06 00:00:00'),
('bx1234567890', 4, 'm-asos-null', 'm', 'the north face', NULL, 'wide', 1, '2020-07-03 00:00:00'),
('bx1234567890', 5, 's-null-null', 's', NULL, NULL, NULL, 1, '2018-09-22 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `BoxBuyPrice`
--

CREATE TABLE `BoxBuyPrice` (
  `box_color` varchar(10) NOT NULL,
  `setDate` datetime NOT NULL,
  `buy_country` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `buyPrice` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxBuyPrice`
--

INSERT INTO `BoxBuyPrice` (`box_color`, `setDate`, `buy_country`, `iso_currency`, `buyPrice`, `quantity`) VALUES
('gold', '2020-01-05 18:02:20', 'france', 'eur', 357.62, 178),
('gold', '2020-01-20 18:02:20', 'belgium', 'eur', 424.97, 141),
('gold', '2020-02-05 18:02:20', 'france', 'eur', 344.35, 344),
('regular', '2020-01-05 18:02:20', 'belgium', 'eur', 208.89, 52),
('regular', '2020-01-20 18:02:20', 'france', 'eur', 330.01, 82),
('regular', '2020-02-05 18:02:20', 'belgium', 'eur', 290.71, 96),
('silver', '2020-01-05 18:02:20', 'france', 'eur', 142.8, 35),
('silver', '2020-01-20 18:02:20', 'belgium', 'eur', 347.87, 86),
('silver', '2020-02-05 18:02:20', 'france', 'eur', 376.86, 94);

-- --------------------------------------------------------

--
-- Structure de la table `BoxColors`
--

CREATE TABLE `BoxColors` (
  `boxColor` varchar(10) NOT NULL,
  `sizeMax` int(11) NOT NULL,
  `weight` double NOT NULL,
  `boxColorRGB` varchar(50) NOT NULL,
  `priceRGB` varchar(50) NOT NULL,
  `textualRGB` varchar(50) NOT NULL,
  `boxPicture` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxColors`
--

INSERT INTO `BoxColors` (`boxColor`, `sizeMax`, `weight`, `boxColorRGB`, `priceRGB`, `textualRGB`, `boxPicture`, `stock`) VALUES
('gold', 10, 0.125, 'rgba(255, 211, 0, 0.7)', 'rgba(255, 211, 0)', '#ffffff', 'gold-box-img.jpg', 374),
('regular', 4, 0.05, '#ffffff', 'rgba(14, 36, 57, 0.8)', 'rgba(14, 36, 57, 0.5)', 'regular-box-img.jpg', 32),
('silver', 6, 0.075, 'rgba(229, 229, 231, 0.5)', '#C6C6C7', 'rgba(14, 36, 57, 0.5)', 'silver-box-img.jpg', 54);

-- --------------------------------------------------------

--
-- Structure de la table `BoxColors-Products`
--

CREATE TABLE `BoxColors-Products` (
  `prodId` int(11) NOT NULL,
  `box_color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxColors-Products`
--

INSERT INTO `BoxColors-Products` (`prodId`, `box_color`) VALUES
(1, 'gold'),
(1, 'silver'),
(2, 'gold'),
(2, 'regular'),
(2, 'silver'),
(3, 'gold'),
(3, 'regular'),
(3, 'silver'),
(4, 'gold'),
(4, 'regular'),
(4, 'silver'),
(5, 'gold'),
(5, 'regular'),
(5, 'silver');

-- --------------------------------------------------------

--
-- Structure de la table `BoxDiscounts`
--

CREATE TABLE `BoxDiscounts` (
  `box_color` varchar(10) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `discount_value` double NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxDiscounts`
--

INSERT INTO `BoxDiscounts` (`box_color`, `country_`, `discount_value`, `beginDate`, `endDate`) VALUES
('gold', 'australia', 0.16, '2020-01-29 18:02:20', '2020-02-29 18:02:20'),
('gold', 'belgium', 0.12, '2020-01-26 18:02:20', '2020-02-26 18:02:20'),
('gold', 'canada', 0.31, '2020-01-24 18:02:20', '2020-02-24 18:02:20'),
('gold', 'switzerland', 0.45, '2020-01-25 18:02:20', '2020-02-25 18:02:20'),
('regular', 'australia', 0.16, '2020-01-27 18:02:20', '2020-02-27 18:02:20'),
('regular', 'belgium', 0.12, '2020-01-30 18:02:20', '2020-03-01 18:02:20'),
('regular', 'canada', 0.31, '2020-01-28 18:02:20', '2020-02-28 18:02:20'),
('regular', 'switzerland', 0.45, '2020-01-29 18:02:20', '2020-02-29 18:02:20'),
('silver', 'australia', 0.16, '2020-01-31 18:02:20', '2020-03-02 18:02:20'),
('silver', 'belgium', 0.12, '2020-02-03 18:02:20', '2020-03-05 18:02:20'),
('silver', 'canada', 0.31, '2020-02-01 18:02:20', '2020-03-03 18:02:20'),
('silver', 'switzerland', 0.45, '2020-02-02 18:02:20', '2020-03-04 18:02:20');

-- --------------------------------------------------------

--
-- Structure de la table `Boxes`
--

CREATE TABLE `Boxes` (
  `boxID` varchar(100) NOT NULL,
  `box_color` varchar(10) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Boxes`
--

INSERT INTO `Boxes` (`boxID`, `box_color`, `setDate`) VALUES
('bx0987654321', 'regular', '2020-02-02 00:00:00'),
('bx1234567890', 'silver', '2020-02-28 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `BoxPrices`
--

CREATE TABLE `BoxPrices` (
  `box_color` varchar(10) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxPrices`
--

INSERT INTO `BoxPrices` (`box_color`, `country_`, `iso_currency`, `price`) VALUES
('gold', 'australia', 'aud', 73.52),
('gold', 'australia', 'cad', 77.26),
('gold', 'australia', 'chf', 67.55),
('gold', 'australia', 'eur', 62.68),
('gold', 'australia', 'gbp', 75.94),
('gold', 'australia', 'jpy', 48.19),
('gold', 'australia', 'usd', 73.97),
('gold', 'belgium', 'aud', 71.61),
('gold', 'belgium', 'cad', 76.45),
('gold', 'belgium', 'chf', 66.85),
('gold', 'belgium', 'eur', 67.26),
('gold', 'belgium', 'gbp', 70.49),
('gold', 'belgium', 'jpy', 61.81),
('gold', 'belgium', 'usd', 56.8),
('gold', 'canada', 'aud', 68.81),
('gold', 'canada', 'cad', 72.04),
('gold', 'canada', 'chf', 72.28),
('gold', 'canada', 'eur', 72.4),
('gold', 'canada', 'gbp', 56.47),
('gold', 'canada', 'jpy', 75.68),
('gold', 'canada', 'usd', 76.35),
('gold', 'switzerland', 'aud', 71.03),
('gold', 'switzerland', 'cad', 74.74),
('gold', 'switzerland', 'chf', 72.91),
('gold', 'switzerland', 'eur', 64.16),
('gold', 'switzerland', 'gbp', 69.54),
('gold', 'switzerland', 'jpy', 60.51),
('gold', 'switzerland', 'usd', 71.53),
('regular', 'australia', 'aud', 49.96),
('regular', 'australia', 'cad', 51.2),
('regular', 'australia', 'chf', 47.59),
('regular', 'australia', 'eur', 45.39),
('regular', 'australia', 'gbp', 47.56),
('regular', 'australia', 'jpy', 43.96),
('regular', 'australia', 'usd', 45.77),
('regular', 'belgium', 'aud', 51.66),
('regular', 'belgium', 'cad', 42.7),
('regular', 'belgium', 'chf', 49.89),
('regular', 'belgium', 'eur', 49.58),
('regular', 'belgium', 'gbp', 53.7),
('regular', 'belgium', 'jpy', 51.63),
('regular', 'belgium', 'usd', 49.72),
('regular', 'canada', 'aud', 45.35),
('regular', 'canada', 'cad', 54.03),
('regular', 'canada', 'chf', 48.13),
('regular', 'canada', 'eur', 54.16),
('regular', 'canada', 'gbp', 50.17),
('regular', 'canada', 'jpy', 51.28),
('regular', 'canada', 'usd', 54.85),
('regular', 'switzerland', 'aud', 53.29),
('regular', 'switzerland', 'cad', 55.98),
('regular', 'switzerland', 'chf', 43.78),
('regular', 'switzerland', 'eur', 53.49),
('regular', 'switzerland', 'gbp', 44.35),
('regular', 'switzerland', 'jpy', 45.02),
('regular', 'switzerland', 'usd', 53.96),
('silver', 'australia', 'aud', 67.24),
('silver', 'australia', 'cad', 63.73),
('silver', 'australia', 'chf', 57.3),
('silver', 'australia', 'eur', 59.59),
('silver', 'australia', 'gbp', 64.07),
('silver', 'australia', 'jpy', 44.16),
('silver', 'australia', 'usd', 54.91),
('silver', 'belgium', 'aud', 69.17),
('silver', 'belgium', 'cad', 47.53),
('silver', 'belgium', 'chf', 57.2),
('silver', 'belgium', 'eur', 60.15),
('silver', 'belgium', 'gbp', 59.15),
('silver', 'belgium', 'jpy', 56.56),
('silver', 'belgium', 'usd', 53.74),
('silver', 'canada', 'aud', 63.85),
('silver', 'canada', 'cad', 70.12),
('silver', 'canada', 'chf', 53.93),
('silver', 'canada', 'eur', 55.58),
('silver', 'canada', 'gbp', 55.87),
('silver', 'canada', 'jpy', 67.59),
('silver', 'canada', 'usd', 70.28),
('silver', 'switzerland', 'aud', 66.13),
('silver', 'switzerland', 'cad', 69.76),
('silver', 'switzerland', 'chf', 61.7),
('silver', 'switzerland', 'eur', 62.27),
('silver', 'switzerland', 'gbp', 64.88),
('silver', 'switzerland', 'jpy', 50.67),
('silver', 'switzerland', 'usd', 69.37);

-- --------------------------------------------------------

--
-- Structure de la table `BoxProducts-Sizes`
--

CREATE TABLE `BoxProducts-Sizes` (
  `prodId` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxProducts-Sizes`
--

INSERT INTO `BoxProducts-Sizes` (`prodId`, `size_name`, `stock`) VALUES
(1, 'l', 6),
(1, 'm', 4),
(1, 's', 3),
(2, 'l', 3),
(2, 'm', 6),
(2, 's', 10),
(3, 'l', 9),
(3, 'm', 1),
(3, 's', 1),
(4, 'l', 3),
(4, 'm', 8),
(4, 's', 3),
(5, 'l', 3),
(5, 'm', 2),
(5, 's', 2);

-- --------------------------------------------------------

--
-- Structure de la table `BoxShipping`
--

CREATE TABLE `BoxShipping` (
  `box_color` varchar(10) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxShipping`
--

INSERT INTO `BoxShipping` (`box_color`, `country_`, `iso_currency`, `price`, `time`) VALUES
('gold', 'australia', 'aud', 8.13, 7),
('gold', 'belgium', 'aud', 8.38, 2),
('gold', 'canada', 'aud', 6.17, 6),
('gold', 'switzerland', 'aud', 6.85, 3),
('gold', 'australia', 'cad', 8.58, 7),
('gold', 'belgium', 'cad', 7.77, 2),
('gold', 'canada', 'cad', 9.49, 6),
('gold', 'switzerland', 'cad', 6.36, 3),
('gold', 'australia', 'chf', 5.74, 7),
('gold', 'belgium', 'chf', 5.95, 2),
('gold', 'canada', 'chf', 7.37, 6),
('gold', 'switzerland', 'chf', 4.44, 3),
('gold', 'australia', 'eur', 5.16, 7),
('gold', 'belgium', 'eur', 5.11, 2),
('gold', 'canada', 'eur', 5, 6),
('gold', 'switzerland', 'eur', 6.6, 3),
('gold', 'australia', 'gbp', 7.18, 7),
('gold', 'belgium', 'gbp', 5.27, 2),
('gold', 'canada', 'gbp', 4.73, 6),
('gold', 'switzerland', 'gbp', 6.38, 3),
('gold', 'australia', 'jpy', 7.25, 7),
('gold', 'belgium', 'jpy', 8.58, 2),
('gold', 'canada', 'jpy', 4.02, 6),
('gold', 'switzerland', 'jpy', 5.46, 3),
('gold', 'australia', 'usd', 8.77, 7),
('gold', 'belgium', 'usd', 5.16, 2),
('gold', 'canada', 'usd', 9.07, 6),
('gold', 'switzerland', 'usd', 8.03, 3),
('regular', 'australia', 'aud', 4.42, 7),
('regular', 'belgium', 'aud', 9.75, 2),
('regular', 'canada', 'aud', 4.19, 6),
('regular', 'switzerland', 'aud', 4.66, 3),
('regular', 'australia', 'cad', 9.27, 7),
('regular', 'belgium', 'cad', 9.37, 2),
('regular', 'canada', 'cad', 7.57, 6),
('regular', 'switzerland', 'cad', 8.29, 3),
('regular', 'australia', 'chf', 5.89, 7),
('regular', 'belgium', 'chf', 9.94, 2),
('regular', 'canada', 'chf', 9.37, 6),
('regular', 'switzerland', 'chf', 8.26, 3),
('regular', 'australia', 'eur', 7.36, 7),
('regular', 'belgium', 'eur', 6.24, 2),
('regular', 'canada', 'eur', 7.41, 6),
('regular', 'switzerland', 'eur', 6.62, 3),
('regular', 'australia', 'gbp', 8.04, 7),
('regular', 'belgium', 'gbp', 5.03, 2),
('regular', 'canada', 'gbp', 8.5, 6),
('regular', 'switzerland', 'gbp', 9.5, 3),
('regular', 'australia', 'jpy', 4.75, 7),
('regular', 'belgium', 'jpy', 9.92, 2),
('regular', 'canada', 'jpy', 7.42, 6),
('regular', 'switzerland', 'jpy', 4.15, 3),
('regular', 'australia', 'usd', 8.25, 7),
('regular', 'belgium', 'usd', 5.74, 2),
('regular', 'canada', 'usd', 8.69, 6),
('regular', 'switzerland', 'usd', 4.19, 3),
('silver', 'australia', 'aud', 4.79, 7),
('silver', 'belgium', 'aud', 4.12, 2),
('silver', 'canada', 'aud', 4.91, 6),
('silver', 'switzerland', 'aud', 4.66, 3),
('silver', 'australia', 'cad', 9.5, 7),
('silver', 'belgium', 'cad', 7.15, 2),
('silver', 'canada', 'cad', 5.46, 6),
('silver', 'switzerland', 'cad', 7.08, 3),
('silver', 'australia', 'chf', 8.15, 7),
('silver', 'belgium', 'chf', 5.95, 2),
('silver', 'canada', 'chf', 5.44, 6),
('silver', 'switzerland', 'chf', 5.95, 3),
('silver', 'australia', 'eur', 4.07, 7),
('silver', 'belgium', 'eur', 9.97, 2),
('silver', 'canada', 'eur', 7.96, 6),
('silver', 'switzerland', 'eur', 9.77, 3),
('silver', 'australia', 'gbp', 7.2, 7),
('silver', 'belgium', 'gbp', 5.14, 2),
('silver', 'canada', 'gbp', 4.36, 6),
('silver', 'switzerland', 'gbp', 5.95, 3),
('silver', 'australia', 'jpy', 4.02, 7),
('silver', 'belgium', 'jpy', 9.19, 2),
('silver', 'canada', 'jpy', 7.33, 6),
('silver', 'switzerland', 'jpy', 6.03, 3),
('silver', 'australia', 'usd', 7.68, 7),
('silver', 'belgium', 'usd', 4.01, 2),
('silver', 'canada', 'usd', 6.28, 6),
('silver', 'switzerland', 'usd', 5.41, 3);

-- --------------------------------------------------------

--
-- Structure de la table `BrandsMeasures`
--

CREATE TABLE `BrandsMeasures` (
  `brandName` varchar(100) NOT NULL,
  `body_part` varchar(30) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `minMax` enum('min','max') NOT NULL,
  `value` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BrandsMeasures`
--

INSERT INTO `BrandsMeasures` (`brandName`, `body_part`, `size_name`, `unit_name`, `minMax`, `value`) VALUES
('asos', 'arm', 'l', 'centimeter', 'min', 114.21),
('asos', 'arm', 'l', 'eu', 'min', 45),
('asos', 'arm', 'l', 'uk', 'min', 10),
('asos', 'arm', 'l', 'us', 'min', 11),
('asos', 'arm', 'l', 'centimeter', 'max', 114.22),
('asos', 'arm', 'l', 'eu', 'max', 46),
('asos', 'arm', 'l', 'uk', 'max', 11),
('asos', 'arm', 'l', 'us', 'max', 12),
('asos', 'arm', 'm', 'centimeter', 'min', 112.21),
('asos', 'arm', 'm', 'eu', 'min', 43),
('asos', 'arm', 'm', 'uk', 'min', 8),
('asos', 'arm', 'm', 'us', 'min', 9),
('asos', 'arm', 'm', 'centimeter', 'max', 112.22),
('asos', 'arm', 'm', 'eu', 'max', 44),
('asos', 'arm', 'm', 'uk', 'max', 9),
('asos', 'arm', 'm', 'us', 'max', 10),
('asos', 'arm', 's', 'centimeter', 'min', 110.21),
('asos', 'arm', 's', 'eu', 'min', 41),
('asos', 'arm', 's', 'uk', 'min', 6),
('asos', 'arm', 's', 'us', 'min', 7),
('asos', 'arm', 's', 'centimeter', 'max', 110.22),
('asos', 'arm', 's', 'eu', 'max', 42),
('asos', 'arm', 's', 'uk', 'max', 7),
('asos', 'arm', 's', 'us', 'max', 8),
('asos', 'bust', 'l', 'centimeter', 'min', 98.2),
('asos', 'bust', 'l', 'eu', 'min', 37),
('asos', 'bust', 'l', 'uk', 'min', 10),
('asos', 'bust', 'l', 'us', 'min', 8),
('asos', 'bust', 'l', 'centimeter', 'max', 99.59),
('asos', 'bust', 'l', 'eu', 'max', 38),
('asos', 'bust', 'l', 'uk', 'max', 11),
('asos', 'bust', 'l', 'us', 'max', 9),
('asos', 'bust', 'm', 'centimeter', 'min', 96.2),
('asos', 'bust', 'm', 'eu', 'min', 35),
('asos', 'bust', 'm', 'uk', 'min', 8),
('asos', 'bust', 'm', 'us', 'min', 6),
('asos', 'bust', 'm', 'centimeter', 'max', 97.59),
('asos', 'bust', 'm', 'eu', 'max', 36),
('asos', 'bust', 'm', 'uk', 'max', 9),
('asos', 'bust', 'm', 'us', 'max', 7),
('asos', 'bust', 's', 'centimeter', 'min', 94.2),
('asos', 'bust', 's', 'eu', 'min', 33),
('asos', 'bust', 's', 'uk', 'min', 6),
('asos', 'bust', 's', 'us', 'min', 4),
('asos', 'bust', 's', 'centimeter', 'max', 95.59),
('asos', 'bust', 's', 'eu', 'max', 34),
('asos', 'bust', 's', 'uk', 'max', 7),
('asos', 'bust', 's', 'us', 'max', 5),
('asos', 'hip', 'l', 'centimeter', 'min', 87.23),
('asos', 'hip', 'l', 'eu', 'min', 40),
('asos', 'hip', 'l', 'uk', 'min', 10),
('asos', 'hip', 'l', 'us', 'min', 5),
('asos', 'hip', 'l', 'centimeter', 'max', 87.87),
('asos', 'hip', 'l', 'eu', 'max', 41),
('asos', 'hip', 'l', 'uk', 'max', 11),
('asos', 'hip', 'l', 'us', 'max', 6),
('asos', 'hip', 'm', 'centimeter', 'min', 85.23),
('asos', 'hip', 'm', 'eu', 'min', 38),
('asos', 'hip', 'm', 'uk', 'min', 8),
('asos', 'hip', 'm', 'us', 'min', 3),
('asos', 'hip', 'm', 'centimeter', 'max', 85.87),
('asos', 'hip', 'm', 'eu', 'max', 39),
('asos', 'hip', 'm', 'uk', 'max', 9),
('asos', 'hip', 'm', 'us', 'max', 4),
('asos', 'hip', 's', 'centimeter', 'min', 83.23),
('asos', 'hip', 's', 'eu', 'min', 36),
('asos', 'hip', 's', 'uk', 'min', 6),
('asos', 'hip', 's', 'us', 'min', 1),
('asos', 'hip', 's', 'centimeter', 'max', 83.87),
('asos', 'hip', 's', 'eu', 'max', 37),
('asos', 'hip', 's', 'uk', 'max', 7),
('asos', 'hip', 's', 'us', 'max', 2),
('asos', 'waist', 'l', 'centimeter', 'min', 62),
('asos', 'waist', 'l', 'eu', 'min', 40),
('asos', 'waist', 'l', 'uk', 'min', 10),
('asos', 'waist', 'l', 'us', 'min', 8),
('asos', 'waist', 'l', 'centimeter', 'max', 64.15),
('asos', 'waist', 'l', 'eu', 'max', 41),
('asos', 'waist', 'l', 'uk', 'max', 11),
('asos', 'waist', 'l', 'us', 'max', 9),
('asos', 'waist', 'm', 'centimeter', 'min', 60),
('asos', 'waist', 'm', 'eu', 'min', 38),
('asos', 'waist', 'm', 'uk', 'min', 8),
('asos', 'waist', 'm', 'us', 'min', 6),
('asos', 'waist', 'm', 'centimeter', 'max', 62.15),
('asos', 'waist', 'm', 'eu', 'max', 39),
('asos', 'waist', 'm', 'uk', 'max', 9),
('asos', 'waist', 'm', 'us', 'max', 7),
('asos', 'waist', 's', 'centimeter', 'min', 58),
('asos', 'waist', 's', 'eu', 'min', 36),
('asos', 'waist', 's', 'uk', 'min', 6),
('asos', 'waist', 's', 'us', 'min', 4),
('asos', 'waist', 's', 'centimeter', 'max', 60.15),
('asos', 'waist', 's', 'eu', 'max', 37),
('asos', 'waist', 's', 'uk', 'max', 7),
('asos', 'waist', 's', 'us', 'max', 5),
('asos', 'waist to floor', 'l', 'centimeter', 'min', 49.38),
('asos', 'waist to floor', 'l', 'eu', 'min', 41),
('asos', 'waist to floor', 'l', 'uk', 'min', 9),
('asos', 'waist to floor', 'l', 'us', 'min', 6),
('asos', 'waist to floor', 'l', 'centimeter', 'max', 51.49),
('asos', 'waist to floor', 'l', 'eu', 'max', 42),
('asos', 'waist to floor', 'l', 'uk', 'max', 10),
('asos', 'waist to floor', 'l', 'us', 'max', 7),
('asos', 'waist to floor', 'm', 'centimeter', 'min', 47.38),
('asos', 'waist to floor', 'm', 'eu', 'min', 39),
('asos', 'waist to floor', 'm', 'uk', 'min', 7),
('asos', 'waist to floor', 'm', 'us', 'min', 4),
('asos', 'waist to floor', 'm', 'centimeter', 'max', 49.49),
('asos', 'waist to floor', 'm', 'eu', 'max', 40),
('asos', 'waist to floor', 'm', 'uk', 'max', 8),
('asos', 'waist to floor', 'm', 'us', 'max', 5),
('asos', 'waist to floor', 's', 'centimeter', 'min', 45.38),
('asos', 'waist to floor', 's', 'eu', 'min', 37),
('asos', 'waist to floor', 's', 'uk', 'min', 5),
('asos', 'waist to floor', 's', 'us', 'min', 2),
('asos', 'waist to floor', 's', 'centimeter', 'max', 47.49),
('asos', 'waist to floor', 's', 'eu', 'max', 38),
('asos', 'waist to floor', 's', 'uk', 'max', 6),
('asos', 'waist to floor', 's', 'us', 'max', 3),
('lacoste', 'arm', 'l', 'centimeter', 'min', 86.3),
('lacoste', 'arm', 'l', 'eu', 'min', 43),
('lacoste', 'arm', 'l', 'uk', 'min', 9),
('lacoste', 'arm', 'l', 'us', 'min', 11),
('lacoste', 'arm', 'l', 'centimeter', 'max', 87.8),
('lacoste', 'arm', 'l', 'eu', 'max', 44),
('lacoste', 'arm', 'l', 'uk', 'max', 10),
('lacoste', 'arm', 'l', 'us', 'max', 12),
('lacoste', 'arm', 'm', 'centimeter', 'min', 84.3),
('lacoste', 'arm', 'm', 'eu', 'min', 41),
('lacoste', 'arm', 'm', 'uk', 'min', 7),
('lacoste', 'arm', 'm', 'us', 'min', 9),
('lacoste', 'arm', 'm', 'centimeter', 'max', 85.8),
('lacoste', 'arm', 'm', 'eu', 'max', 42),
('lacoste', 'arm', 'm', 'uk', 'max', 8),
('lacoste', 'arm', 'm', 'us', 'max', 10),
('lacoste', 'arm', 's', 'centimeter', 'min', 82.3),
('lacoste', 'arm', 's', 'eu', 'min', 39),
('lacoste', 'arm', 's', 'uk', 'min', 5),
('lacoste', 'arm', 's', 'us', 'min', 7),
('lacoste', 'arm', 's', 'centimeter', 'max', 83.8),
('lacoste', 'arm', 's', 'eu', 'max', 40),
('lacoste', 'arm', 's', 'uk', 'max', 6),
('lacoste', 'arm', 's', 'us', 'max', 8),
('lacoste', 'bust', 'l', 'centimeter', 'min', 99.1),
('lacoste', 'bust', 'l', 'eu', 'min', 41),
('lacoste', 'bust', 'l', 'uk', 'min', 10),
('lacoste', 'bust', 'l', 'us', 'min', 10),
('lacoste', 'bust', 'l', 'centimeter', 'max', 99.13),
('lacoste', 'bust', 'l', 'eu', 'max', 42),
('lacoste', 'bust', 'l', 'uk', 'max', 11),
('lacoste', 'bust', 'l', 'us', 'max', 11),
('lacoste', 'bust', 'm', 'centimeter', 'min', 97.1),
('lacoste', 'bust', 'm', 'eu', 'min', 39),
('lacoste', 'bust', 'm', 'uk', 'min', 8),
('lacoste', 'bust', 'm', 'us', 'min', 8),
('lacoste', 'bust', 'm', 'centimeter', 'max', 97.13),
('lacoste', 'bust', 'm', 'eu', 'max', 40),
('lacoste', 'bust', 'm', 'uk', 'max', 9),
('lacoste', 'bust', 'm', 'us', 'max', 9),
('lacoste', 'bust', 's', 'centimeter', 'min', 95.1),
('lacoste', 'bust', 's', 'eu', 'min', 37),
('lacoste', 'bust', 's', 'uk', 'min', 6),
('lacoste', 'bust', 's', 'us', 'min', 6),
('lacoste', 'bust', 's', 'centimeter', 'max', 95.13),
('lacoste', 'bust', 's', 'eu', 'max', 38),
('lacoste', 'bust', 's', 'uk', 'max', 7),
('lacoste', 'bust', 's', 'us', 'max', 7),
('lacoste', 'hip', 'l', 'centimeter', 'min', 60.14),
('lacoste', 'hip', 'l', 'eu', 'min', 38),
('lacoste', 'hip', 'l', 'uk', 'min', 8),
('lacoste', 'hip', 'l', 'us', 'min', 5),
('lacoste', 'hip', 'l', 'centimeter', 'max', 61.16),
('lacoste', 'hip', 'l', 'eu', 'max', 39),
('lacoste', 'hip', 'l', 'uk', 'max', 9),
('lacoste', 'hip', 'l', 'us', 'max', 6),
('lacoste', 'hip', 'm', 'centimeter', 'min', 58.14),
('lacoste', 'hip', 'm', 'eu', 'min', 36),
('lacoste', 'hip', 'm', 'uk', 'min', 6),
('lacoste', 'hip', 'm', 'us', 'min', 3),
('lacoste', 'hip', 'm', 'centimeter', 'max', 59.16),
('lacoste', 'hip', 'm', 'eu', 'max', 37),
('lacoste', 'hip', 'm', 'uk', 'max', 7),
('lacoste', 'hip', 'm', 'us', 'max', 4),
('lacoste', 'hip', 's', 'centimeter', 'min', 56.14),
('lacoste', 'hip', 's', 'eu', 'min', 34),
('lacoste', 'hip', 's', 'uk', 'min', 4),
('lacoste', 'hip', 's', 'us', 'min', 1),
('lacoste', 'hip', 's', 'centimeter', 'max', 57.16),
('lacoste', 'hip', 's', 'eu', 'max', 35),
('lacoste', 'hip', 's', 'uk', 'max', 5),
('lacoste', 'hip', 's', 'us', 'max', 2),
('lacoste', 'waist', 'l', 'centimeter', 'min', 95.13),
('lacoste', 'waist', 'l', 'eu', 'min', 39),
('lacoste', 'waist', 'l', 'uk', 'min', 9),
('lacoste', 'waist', 'l', 'us', 'min', 7),
('lacoste', 'waist', 'l', 'centimeter', 'max', 95.6),
('lacoste', 'waist', 'l', 'eu', 'max', 40),
('lacoste', 'waist', 'l', 'uk', 'max', 10),
('lacoste', 'waist', 'l', 'us', 'max', 8),
('lacoste', 'waist', 'm', 'centimeter', 'min', 93.13),
('lacoste', 'waist', 'm', 'eu', 'min', 37),
('lacoste', 'waist', 'm', 'uk', 'min', 7),
('lacoste', 'waist', 'm', 'us', 'min', 5),
('lacoste', 'waist', 'm', 'centimeter', 'max', 93.6),
('lacoste', 'waist', 'm', 'eu', 'max', 38),
('lacoste', 'waist', 'm', 'uk', 'max', 8),
('lacoste', 'waist', 'm', 'us', 'max', 6),
('lacoste', 'waist', 's', 'centimeter', 'min', 91.13),
('lacoste', 'waist', 's', 'eu', 'min', 35),
('lacoste', 'waist', 's', 'uk', 'min', 5),
('lacoste', 'waist', 's', 'us', 'min', 3),
('lacoste', 'waist', 's', 'centimeter', 'max', 91.6),
('lacoste', 'waist', 's', 'eu', 'max', 36),
('lacoste', 'waist', 's', 'uk', 'max', 6),
('lacoste', 'waist', 's', 'us', 'max', 4),
('lacoste', 'waist to floor', 'l', 'centimeter', 'min', 66.05),
('lacoste', 'waist to floor', 'l', 'eu', 'min', 38),
('lacoste', 'waist to floor', 'l', 'uk', 'min', 8),
('lacoste', 'waist to floor', 'l', 'us', 'min', 9),
('lacoste', 'waist to floor', 'l', 'centimeter', 'max', 68.71),
('lacoste', 'waist to floor', 'l', 'eu', 'max', 39),
('lacoste', 'waist to floor', 'l', 'uk', 'max', 9),
('lacoste', 'waist to floor', 'l', 'us', 'max', 10),
('lacoste', 'waist to floor', 'm', 'centimeter', 'min', 64.05),
('lacoste', 'waist to floor', 'm', 'eu', 'min', 36),
('lacoste', 'waist to floor', 'm', 'uk', 'min', 6),
('lacoste', 'waist to floor', 'm', 'us', 'min', 7),
('lacoste', 'waist to floor', 'm', 'centimeter', 'max', 66.71),
('lacoste', 'waist to floor', 'm', 'eu', 'max', 37),
('lacoste', 'waist to floor', 'm', 'uk', 'max', 7),
('lacoste', 'waist to floor', 'm', 'us', 'max', 8),
('lacoste', 'waist to floor', 's', 'centimeter', 'min', 62.05),
('lacoste', 'waist to floor', 's', 'eu', 'min', 34),
('lacoste', 'waist to floor', 's', 'uk', 'min', 4),
('lacoste', 'waist to floor', 's', 'us', 'min', 5),
('lacoste', 'waist to floor', 's', 'centimeter', 'max', 64.71),
('lacoste', 'waist to floor', 's', 'eu', 'max', 35),
('lacoste', 'waist to floor', 's', 'uk', 'max', 5),
('lacoste', 'waist to floor', 's', 'us', 'max', 6),
('the north face', 'arm', 'l', 'centimeter', 'min', 69.14),
('the north face', 'arm', 'l', 'eu', 'min', 45),
('the north face', 'arm', 'l', 'uk', 'min', 10),
('the north face', 'arm', 'l', 'us', 'min', 8),
('the north face', 'arm', 'l', 'centimeter', 'max', 71.27),
('the north face', 'arm', 'l', 'eu', 'max', 46),
('the north face', 'arm', 'l', 'uk', 'max', 11),
('the north face', 'arm', 'l', 'us', 'max', 9),
('the north face', 'arm', 'm', 'centimeter', 'min', 67.14),
('the north face', 'arm', 'm', 'eu', 'min', 43),
('the north face', 'arm', 'm', 'uk', 'min', 8),
('the north face', 'arm', 'm', 'us', 'min', 6),
('the north face', 'arm', 'm', 'centimeter', 'max', 69.27),
('the north face', 'arm', 'm', 'eu', 'max', 44),
('the north face', 'arm', 'm', 'uk', 'max', 9),
('the north face', 'arm', 'm', 'us', 'max', 7),
('the north face', 'arm', 's', 'centimeter', 'min', 65.14),
('the north face', 'arm', 's', 'eu', 'min', 41),
('the north face', 'arm', 's', 'uk', 'min', 6),
('the north face', 'arm', 's', 'us', 'min', 4),
('the north face', 'arm', 's', 'centimeter', 'max', 67.27),
('the north face', 'arm', 's', 'eu', 'max', 42),
('the north face', 'arm', 's', 'uk', 'max', 7),
('the north face', 'arm', 's', 'us', 'max', 5),
('the north face', 'bust', 'l', 'centimeter', 'min', 86.48),
('the north face', 'bust', 'l', 'eu', 'min', 44),
('the north face', 'bust', 'l', 'uk', 'min', 10),
('the north face', 'bust', 'l', 'us', 'min', 11),
('the north face', 'bust', 'l', 'centimeter', 'max', 87.25),
('the north face', 'bust', 'l', 'eu', 'max', 45),
('the north face', 'bust', 'l', 'uk', 'max', 11),
('the north face', 'bust', 'l', 'us', 'max', 12),
('the north face', 'bust', 'm', 'centimeter', 'min', 84.48),
('the north face', 'bust', 'm', 'eu', 'min', 42),
('the north face', 'bust', 'm', 'uk', 'min', 8),
('the north face', 'bust', 'm', 'us', 'min', 9),
('the north face', 'bust', 'm', 'centimeter', 'max', 85.25),
('the north face', 'bust', 'm', 'eu', 'max', 43),
('the north face', 'bust', 'm', 'uk', 'max', 9),
('the north face', 'bust', 'm', 'us', 'max', 10),
('the north face', 'bust', 's', 'centimeter', 'min', 82.48),
('the north face', 'bust', 's', 'eu', 'min', 40),
('the north face', 'bust', 's', 'uk', 'min', 6),
('the north face', 'bust', 's', 'us', 'min', 7),
('the north face', 'bust', 's', 'centimeter', 'max', 83.25),
('the north face', 'bust', 's', 'eu', 'max', 41),
('the north face', 'bust', 's', 'uk', 'max', 7),
('the north face', 'bust', 's', 'us', 'max', 8),
('the north face', 'hip', 'l', 'centimeter', 'min', 71.47),
('the north face', 'hip', 'l', 'eu', 'min', 44),
('the north face', 'hip', 'l', 'uk', 'min', 10),
('the north face', 'hip', 'l', 'us', 'min', 6),
('the north face', 'hip', 'l', 'centimeter', 'max', 73.67),
('the north face', 'hip', 'l', 'eu', 'max', 45),
('the north face', 'hip', 'l', 'uk', 'max', 11),
('the north face', 'hip', 'l', 'us', 'max', 7),
('the north face', 'hip', 'm', 'centimeter', 'min', 69.47),
('the north face', 'hip', 'm', 'eu', 'min', 42),
('the north face', 'hip', 'm', 'uk', 'min', 8),
('the north face', 'hip', 'm', 'us', 'min', 4),
('the north face', 'hip', 'm', 'centimeter', 'max', 71.67),
('the north face', 'hip', 'm', 'eu', 'max', 43),
('the north face', 'hip', 'm', 'uk', 'max', 9),
('the north face', 'hip', 'm', 'us', 'max', 5),
('the north face', 'hip', 's', 'centimeter', 'min', 67.47),
('the north face', 'hip', 's', 'eu', 'min', 40),
('the north face', 'hip', 's', 'uk', 'min', 6),
('the north face', 'hip', 's', 'us', 'min', 2),
('the north face', 'hip', 's', 'centimeter', 'max', 69.67),
('the north face', 'hip', 's', 'eu', 'max', 41),
('the north face', 'hip', 's', 'uk', 'max', 7),
('the north face', 'hip', 's', 'us', 'max', 3),
('the north face', 'waist', 'l', 'centimeter', 'min', 71.13),
('the north face', 'waist', 'l', 'eu', 'min', 41),
('the north face', 'waist', 'l', 'uk', 'min', 9),
('the north face', 'waist', 'l', 'us', 'min', 11),
('the north face', 'waist', 'l', 'centimeter', 'max', 73.71),
('the north face', 'waist', 'l', 'eu', 'max', 42),
('the north face', 'waist', 'l', 'uk', 'max', 10),
('the north face', 'waist', 'l', 'us', 'max', 12),
('the north face', 'waist', 'm', 'centimeter', 'min', 69.13),
('the north face', 'waist', 'm', 'eu', 'min', 39),
('the north face', 'waist', 'm', 'uk', 'min', 7),
('the north face', 'waist', 'm', 'us', 'min', 9),
('the north face', 'waist', 'm', 'centimeter', 'max', 71.71),
('the north face', 'waist', 'm', 'eu', 'max', 40),
('the north face', 'waist', 'm', 'uk', 'max', 8),
('the north face', 'waist', 'm', 'us', 'max', 10),
('the north face', 'waist', 's', 'centimeter', 'min', 67.13),
('the north face', 'waist', 's', 'eu', 'min', 37),
('the north face', 'waist', 's', 'uk', 'min', 5),
('the north face', 'waist', 's', 'us', 'min', 7),
('the north face', 'waist', 's', 'centimeter', 'max', 69.71),
('the north face', 'waist', 's', 'eu', 'max', 38),
('the north face', 'waist', 's', 'uk', 'max', 6),
('the north face', 'waist', 's', 'us', 'max', 8),
('the north face', 'waist to floor', 'l', 'centimeter', 'min', 50.41),
('the north face', 'waist to floor', 'l', 'eu', 'min', 45),
('the north face', 'waist to floor', 'l', 'uk', 'min', 8),
('the north face', 'waist to floor', 'l', 'us', 'min', 9),
('the north face', 'waist to floor', 'l', 'centimeter', 'max', 52.1),
('the north face', 'waist to floor', 'l', 'eu', 'max', 46),
('the north face', 'waist to floor', 'l', 'uk', 'max', 9),
('the north face', 'waist to floor', 'l', 'us', 'max', 10),
('the north face', 'waist to floor', 'm', 'centimeter', 'min', 48.41),
('the north face', 'waist to floor', 'm', 'eu', 'min', 43),
('the north face', 'waist to floor', 'm', 'uk', 'min', 6),
('the north face', 'waist to floor', 'm', 'us', 'min', 7),
('the north face', 'waist to floor', 'm', 'centimeter', 'max', 50.1),
('the north face', 'waist to floor', 'm', 'eu', 'max', 44),
('the north face', 'waist to floor', 'm', 'uk', 'max', 7),
('the north face', 'waist to floor', 'm', 'us', 'max', 8),
('the north face', 'waist to floor', 's', 'centimeter', 'min', 46.41),
('the north face', 'waist to floor', 's', 'eu', 'min', 41),
('the north face', 'waist to floor', 's', 'uk', 'min', 4),
('the north face', 'waist to floor', 's', 'us', 'min', 5),
('the north face', 'waist to floor', 's', 'centimeter', 'max', 48.1),
('the north face', 'waist to floor', 's', 'eu', 'max', 42),
('the north face', 'waist to floor', 's', 'uk', 'max', 5),
('the north face', 'waist to floor', 's', 'us', 'max', 6),
('tommy hilfiger', 'arm', 'l', 'centimeter', 'min', 101.06),
('tommy hilfiger', 'arm', 'l', 'eu', 'min', 44),
('tommy hilfiger', 'arm', 'l', 'uk', 'min', 10),
('tommy hilfiger', 'arm', 'l', 'us', 'min', 6),
('tommy hilfiger', 'arm', 'l', 'centimeter', 'max', 101.61),
('tommy hilfiger', 'arm', 'l', 'eu', 'max', 45),
('tommy hilfiger', 'arm', 'l', 'uk', 'max', 11),
('tommy hilfiger', 'arm', 'l', 'us', 'max', 7),
('tommy hilfiger', 'arm', 'm', 'centimeter', 'min', 99.06),
('tommy hilfiger', 'arm', 'm', 'eu', 'min', 42),
('tommy hilfiger', 'arm', 'm', 'uk', 'min', 8),
('tommy hilfiger', 'arm', 'm', 'us', 'min', 4),
('tommy hilfiger', 'arm', 'm', 'centimeter', 'max', 99.61),
('tommy hilfiger', 'arm', 'm', 'eu', 'max', 43),
('tommy hilfiger', 'arm', 'm', 'uk', 'max', 9),
('tommy hilfiger', 'arm', 'm', 'us', 'max', 5),
('tommy hilfiger', 'arm', 's', 'centimeter', 'min', 97.06),
('tommy hilfiger', 'arm', 's', 'eu', 'min', 40),
('tommy hilfiger', 'arm', 's', 'uk', 'min', 6),
('tommy hilfiger', 'arm', 's', 'us', 'min', 2),
('tommy hilfiger', 'arm', 's', 'centimeter', 'max', 97.61),
('tommy hilfiger', 'arm', 's', 'eu', 'max', 41),
('tommy hilfiger', 'arm', 's', 'uk', 'max', 7),
('tommy hilfiger', 'arm', 's', 'us', 'max', 3),
('tommy hilfiger', 'bust', 'l', 'centimeter', 'min', 80.31),
('tommy hilfiger', 'bust', 'l', 'eu', 'min', 40),
('tommy hilfiger', 'bust', 'l', 'uk', 'min', 9),
('tommy hilfiger', 'bust', 'l', 'us', 'min', 9),
('tommy hilfiger', 'bust', 'l', 'centimeter', 'max', 81.65),
('tommy hilfiger', 'bust', 'l', 'eu', 'max', 41),
('tommy hilfiger', 'bust', 'l', 'uk', 'max', 10),
('tommy hilfiger', 'bust', 'l', 'us', 'max', 10),
('tommy hilfiger', 'bust', 'm', 'centimeter', 'min', 78.31),
('tommy hilfiger', 'bust', 'm', 'eu', 'min', 38),
('tommy hilfiger', 'bust', 'm', 'uk', 'min', 7),
('tommy hilfiger', 'bust', 'm', 'us', 'min', 7),
('tommy hilfiger', 'bust', 'm', 'centimeter', 'max', 79.65),
('tommy hilfiger', 'bust', 'm', 'eu', 'max', 39),
('tommy hilfiger', 'bust', 'm', 'uk', 'max', 8),
('tommy hilfiger', 'bust', 'm', 'us', 'max', 8),
('tommy hilfiger', 'bust', 's', 'centimeter', 'min', 76.31),
('tommy hilfiger', 'bust', 's', 'eu', 'min', 36),
('tommy hilfiger', 'bust', 's', 'uk', 'min', 5),
('tommy hilfiger', 'bust', 's', 'us', 'min', 5),
('tommy hilfiger', 'bust', 's', 'centimeter', 'max', 77.65),
('tommy hilfiger', 'bust', 's', 'eu', 'max', 37),
('tommy hilfiger', 'bust', 's', 'uk', 'max', 6),
('tommy hilfiger', 'bust', 's', 'us', 'max', 6),
('tommy hilfiger', 'hip', 'l', 'centimeter', 'min', 117.35),
('tommy hilfiger', 'hip', 'l', 'eu', 'min', 38),
('tommy hilfiger', 'hip', 'l', 'uk', 'min', 9),
('tommy hilfiger', 'hip', 'l', 'us', 'min', 7),
('tommy hilfiger', 'hip', 'l', 'centimeter', 'max', 118),
('tommy hilfiger', 'hip', 'l', 'eu', 'max', 39),
('tommy hilfiger', 'hip', 'l', 'uk', 'max', 10),
('tommy hilfiger', 'hip', 'l', 'us', 'max', 8),
('tommy hilfiger', 'hip', 'm', 'centimeter', 'min', 115.35),
('tommy hilfiger', 'hip', 'm', 'eu', 'min', 36),
('tommy hilfiger', 'hip', 'm', 'uk', 'min', 7),
('tommy hilfiger', 'hip', 'm', 'us', 'min', 5),
('tommy hilfiger', 'hip', 'm', 'centimeter', 'max', 116),
('tommy hilfiger', 'hip', 'm', 'eu', 'max', 37),
('tommy hilfiger', 'hip', 'm', 'uk', 'max', 8),
('tommy hilfiger', 'hip', 'm', 'us', 'max', 6),
('tommy hilfiger', 'hip', 's', 'centimeter', 'min', 113.35),
('tommy hilfiger', 'hip', 's', 'eu', 'min', 34),
('tommy hilfiger', 'hip', 's', 'uk', 'min', 5),
('tommy hilfiger', 'hip', 's', 'us', 'min', 3),
('tommy hilfiger', 'hip', 's', 'centimeter', 'max', 114),
('tommy hilfiger', 'hip', 's', 'eu', 'max', 35),
('tommy hilfiger', 'hip', 's', 'uk', 'max', 6),
('tommy hilfiger', 'hip', 's', 'us', 'max', 4),
('tommy hilfiger', 'waist', 'l', 'centimeter', 'min', 78.67),
('tommy hilfiger', 'waist', 'l', 'eu', 'min', 40),
('tommy hilfiger', 'waist', 'l', 'uk', 'min', 9),
('tommy hilfiger', 'waist', 'l', 'us', 'min', 10),
('tommy hilfiger', 'waist', 'l', 'centimeter', 'max', 79.27),
('tommy hilfiger', 'waist', 'l', 'eu', 'max', 41),
('tommy hilfiger', 'waist', 'l', 'uk', 'max', 10),
('tommy hilfiger', 'waist', 'l', 'us', 'max', 11),
('tommy hilfiger', 'waist', 'm', 'centimeter', 'min', 76.67),
('tommy hilfiger', 'waist', 'm', 'eu', 'min', 38),
('tommy hilfiger', 'waist', 'm', 'uk', 'min', 7),
('tommy hilfiger', 'waist', 'm', 'us', 'min', 8),
('tommy hilfiger', 'waist', 'm', 'centimeter', 'max', 77.27),
('tommy hilfiger', 'waist', 'm', 'eu', 'max', 39),
('tommy hilfiger', 'waist', 'm', 'uk', 'max', 8),
('tommy hilfiger', 'waist', 'm', 'us', 'max', 9),
('tommy hilfiger', 'waist', 's', 'centimeter', 'min', 74.67),
('tommy hilfiger', 'waist', 's', 'eu', 'min', 36),
('tommy hilfiger', 'waist', 's', 'uk', 'min', 5),
('tommy hilfiger', 'waist', 's', 'us', 'min', 6),
('tommy hilfiger', 'waist', 's', 'centimeter', 'max', 75.27),
('tommy hilfiger', 'waist', 's', 'eu', 'max', 37),
('tommy hilfiger', 'waist', 's', 'uk', 'max', 6),
('tommy hilfiger', 'waist', 's', 'us', 'max', 7),
('tommy hilfiger', 'waist to floor', 'l', 'centimeter', 'min', 97.79),
('tommy hilfiger', 'waist to floor', 'l', 'eu', 'min', 43),
('tommy hilfiger', 'waist to floor', 'l', 'uk', 'min', 8),
('tommy hilfiger', 'waist to floor', 'l', 'us', 'min', 9),
('tommy hilfiger', 'waist to floor', 'l', 'centimeter', 'max', 98.54),
('tommy hilfiger', 'waist to floor', 'l', 'eu', 'max', 44),
('tommy hilfiger', 'waist to floor', 'l', 'uk', 'max', 9),
('tommy hilfiger', 'waist to floor', 'l', 'us', 'max', 10),
('tommy hilfiger', 'waist to floor', 'm', 'centimeter', 'min', 95.79),
('tommy hilfiger', 'waist to floor', 'm', 'eu', 'min', 41),
('tommy hilfiger', 'waist to floor', 'm', 'uk', 'min', 6),
('tommy hilfiger', 'waist to floor', 'm', 'us', 'min', 7),
('tommy hilfiger', 'waist to floor', 'm', 'centimeter', 'max', 96.54),
('tommy hilfiger', 'waist to floor', 'm', 'eu', 'max', 42),
('tommy hilfiger', 'waist to floor', 'm', 'uk', 'max', 7),
('tommy hilfiger', 'waist to floor', 'm', 'us', 'max', 8),
('tommy hilfiger', 'waist to floor', 's', 'centimeter', 'min', 93.79),
('tommy hilfiger', 'waist to floor', 's', 'eu', 'min', 39),
('tommy hilfiger', 'waist to floor', 's', 'uk', 'min', 4),
('tommy hilfiger', 'waist to floor', 's', 'us', 'min', 5),
('tommy hilfiger', 'waist to floor', 's', 'centimeter', 'max', 94.54),
('tommy hilfiger', 'waist to floor', 's', 'eu', 'max', 40),
('tommy hilfiger', 'waist to floor', 's', 'uk', 'max', 5),
('tommy hilfiger', 'waist to floor', 's', 'us', 'max', 6);

-- --------------------------------------------------------

--
-- Structure de la table `BrandsPictures`
--

CREATE TABLE `BrandsPictures` (
  `brand_name` varchar(100) NOT NULL,
  `pictureID` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BrandsPictures`
--

INSERT INTO `BrandsPictures` (`brand_name`, `pictureID`, `picture`) VALUES
('asos', 1, 'asos0.png'),
('asos', 2, 'red-brand.png'),
('lacoste', 1, 'lacoste0.png'),
('lacoste', 2, 'red-brand.png'),
('the north face', 1, 'northface0.png'),
('the north face', 2, 'red-brand.png'),
('tommy hilfiger', 1, 'tommy0.png'),
('tommy hilfiger', 2, 'red-brand.png');

-- --------------------------------------------------------

--
-- Structure de la table `BuyCountries`
--

CREATE TABLE `BuyCountries` (
  `buyCountry` varchar(100) NOT NULL,
  `isoCountry` varchar(10) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `isUE` tinyint(1) NOT NULL,
  `vat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BuyCountries`
--

INSERT INTO `BuyCountries` (`buyCountry`, `isoCountry`, `iso_currency`, `isUE`, `vat`) VALUES
('belgium', 'be', 'eur', 1, 0.21),
('france', 'fr', 'eur', 1, 0.2);

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `categoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Categories`
--

INSERT INTO `Categories` (`categoryName`) VALUES
('jackets'),
('scarfs'),
('trousers'),
('vests');

-- --------------------------------------------------------

--
-- Structure de la table `Collections`
--

CREATE TABLE `Collections` (
  `collectionName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Collections`
--

INSERT INTO `Collections` (`collectionName`) VALUES
('autumn'),
('women');

-- --------------------------------------------------------

--
-- Structure de la table `Constants`
--

CREATE TABLE `Constants` (
  `constName` varchar(50) NOT NULL,
  `stringValue` varchar(50) DEFAULT NULL,
  `jsonValue` json DEFAULT NULL,
  `setDate` datetime NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Constants`
--

INSERT INTO `Constants` (`constName`, `stringValue`, `jsonValue`, `setDate`, `description`) VALUES
('BASKET_TYPE', 'basketproduct', NULL, '2020-02-27 00:00:00', 'Type of prroduct witch go to basket only.'),
('BOX_TYPE', 'boxproduct', NULL, '2020-02-27 00:00:00', 'Type of prroduct witch go to boxes only.'),
('COLOR_TEXT_05', 'rgba(14, 36, 57, 0.5)', NULL, '2020-04-17 00:00:00', 'A css variable color. This color is used as remplacement color for white colors.'),
('COLOR_TEXT_08', 'rgba(14, 36, 57, 0.8)', NULL, '2020-04-09 00:00:00', 'A css variable color. This color is used as remplacement color for white colors.'),
('DEFAULT_COUNTRY_NAME', 'other', NULL, '2020-03-29 00:00:00', 'The default country of a user if his localisation is not supported by the System.'),
('DEFAULT_ISO_CURRENCY', 'usd', NULL, '2020-05-02 00:00:00', 'The default currency iso code 2 of a user if his localcurrency is not supported by the System.'),
('DEFAULT_LANGUAGE', 'en', NULL, '2020-02-28 00:00:00', 'Default language given to the visitor if his driver language is not supported by the web site.'),
('GRID_USED_INSIDE', 'grid.php', NULL, '2020-03-30 00:00:00', 'Indicate the value of the attribut \"inside\" in TranslationStation table. Used to get the translation to the \"inside\" indicated.\r\nIts the file name of the method name where the translation is used.'),
('MAX_MEASURE', '4', NULL, '2020-04-23 00:00:00', 'Indicate how much measure can be holded by a user.'),
('MAX_PRODUCT_CUBE_DISPLAYABLE', '4', NULL, '2020-04-02 00:00:00', 'The maximum of product\'s cubes displayable before to display the plus symbol.\r\nThis number of cube must avoid to display cubes in multiple ligne and disturbe the grid arrangement.\r\nNOTE: the counter of number of cube begin at zero, not at 1.'),
('NB_DAYS_BEFORE', '15', NULL, '2020-02-21 21:28:28', 'The number of days to go back in navigation history.'),
('ORDER_DEFAULT_STATUS', 'processing', NULL, '2020-02-26 21:37:00', 'The default value given to a new order\'s status.'),
('PRICE_MESSAGE', 'free with meimbox', NULL, '2020-04-01 00:00:00', 'message to display instead of boxproduct\'s price because a boxProduct hasn\'t any price'),
('SUPPORTED_UNIT', NULL, '[\"centimeter\", \"inch\"]', '2020-04-24 00:00:00', 'List of measure unit available for user\'s input'),
('SYSTEM_ID', '1', NULL, '2020-02-26 21:27:40', 'The ID of the system used as author to update order status.'),
('WHITE_RGB', '#ffffff', NULL, '2020-04-09 00:00:00', 'The white color\'s rbg code.');

-- --------------------------------------------------------

--
-- Structure de la table `Countries`
--

CREATE TABLE `Countries` (
  `country` varchar(100) NOT NULL,
  `isoCountry` varchar(10) DEFAULT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `isUE` tinyint(1) DEFAULT NULL,
  `vat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Countries`
--

INSERT INTO `Countries` (`country`, `isoCountry`, `iso_currency`, `isUE`, `vat`) VALUES
('australia', 'au', 'aud', 0, 0.1),
('belgium', 'be', 'eur', 1, 0.21),
('canada', 'ca', 'cad', 0, 0.05),
('other', 'o', 'usd', 0, 0),
('switzerland', 'ch', 'chf', 0, 0.077);

-- --------------------------------------------------------

--
-- Structure de la table `Currencies`
--

CREATE TABLE `Currencies` (
  `isoCurrency` varchar(10) NOT NULL,
  `currencyName` varchar(50) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `EURtoCurrency` double NOT NULL,
  `isDefault` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Currencies`
--

INSERT INTO `Currencies` (`isoCurrency`, `currencyName`, `symbol`, `EURtoCurrency`, `isDefault`) VALUES
('aud', 'australian dollar', 'a$', 1.63, 0),
('cad', 'canadian dollar', 'c$', 1.43, 0),
('chf', 'swiss franc', 'CHF', 1.06, 0),
('eur', 'euro', '€', 1, 0),
('gbp', 'great britain pound (sterling)', '£', 0.84, 0),
('jpy', 'japanese yen', '¥', 120.91, 0),
('usd', 'u.s. dollar', '$', 1.08, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Cuts`
--

CREATE TABLE `Cuts` (
  `cutName` varchar(30) NOT NULL,
  `cutMeasure` double NOT NULL,
  `unit_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Cuts`
--

INSERT INTO `Cuts` (`cutName`, `cutMeasure`, `unit_name`) VALUES
('fit', 0, 'centimeter'),
('wide', 20.5, 'centimeter');

-- --------------------------------------------------------

--
-- Structure de la table `Details`
--

CREATE TABLE `Details` (
  `orderId` varchar(100) NOT NULL,
  `prodId` int(11) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `weight` double NOT NULL,
  `buy_price` double NOT NULL,
  `sellPrice` double NOT NULL,
  `discount_value` double NOT NULL,
  `shipping` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Devices`
--

CREATE TABLE `Devices` (
  `userId` varchar(25) NOT NULL,
  `setDate` datetime NOT NULL,
  `ddData` json NOT NULL,
  `userAgent` varchar(100) NOT NULL,
  `isBot` tinyint(1) NOT NULL,
  `botInfo` json DEFAULT NULL,
  `osName` varchar(50) DEFAULT NULL,
  `osVersion` varchar(50) DEFAULT NULL,
  `osPlateform` varchar(50) DEFAULT NULL,
  `driverType` varchar(50) DEFAULT NULL,
  `driverName` varchar(50) DEFAULT NULL,
  `driverVersion` varchar(50) DEFAULT NULL,
  `driverEngine` varchar(50) DEFAULT NULL,
  `driverEngineVersion` varchar(50) DEFAULT NULL,
  `deviceType` varchar(50) DEFAULT NULL,
  `deviceBrand` varchar(50) DEFAULT NULL,
  `deviceModel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DiscountCodes`
--

CREATE TABLE `DiscountCodes` (
  `discountCode` varchar(50) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `minAmount` double NOT NULL,
  `nbUse` int(11) DEFAULT NULL,
  `isCombinable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DiscountCodes`
--

INSERT INTO `DiscountCodes` (`discountCode`, `discount_type`, `value`, `minAmount`, `nbUse`, `isCombinable`) VALUES
('blackfriday25', 'basketProducts', 0.25, 25, -1, 0),
('gmk10', 'basketProducts_influencer', 0.1, 15, 100, 1),
('shera10', 'boxes_influencer', 0.1, 0, 50, 1),
('summer20', 'all', 0.2, 25, -1, 0),
('winter30', 'boxes', 0.3, 0, -1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `DiscountCodes-Countries`
--

CREATE TABLE `DiscountCodes-Countries` (
  `discount_code` varchar(50) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DiscountCodes-Countries`
--

INSERT INTO `DiscountCodes-Countries` (`discount_code`, `country_`, `beginDate`, `endDate`) VALUES
('blackfriday25', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('blackfriday25', 'belgium', NULL, NULL),
('blackfriday25', 'canada', NULL, NULL),
('blackfriday25', 'switzerland', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('gmk10', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('gmk10', 'belgium', NULL, NULL),
('gmk10', 'canada', NULL, NULL),
('gmk10', 'switzerland', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('shera10', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('shera10', 'belgium', NULL, NULL),
('shera10', 'canada', NULL, NULL),
('shera10', 'switzerland', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('summer20', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('summer20', 'belgium', NULL, NULL),
('summer20', 'canada', NULL, NULL),
('summer20', 'switzerland', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('winter30', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('winter30', 'belgium', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('winter30', 'canada', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('winter30', 'switzerland', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `DiscountCodeType`
--

CREATE TABLE `DiscountCodeType` (
  `discountType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DiscountCodeType`
--

INSERT INTO `DiscountCodeType` (`discountType`) VALUES
('all'),
('basketProducts'),
('basketProducts_influencer'),
('boxes'),
('boxes_influencer');

-- --------------------------------------------------------

--
-- Structure de la table `DiscountValues`
--

CREATE TABLE `DiscountValues` (
  `discountValue` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DiscountValues`
--

INSERT INTO `DiscountValues` (`discountValue`) VALUES
(0.12),
(0.16),
(0.31),
(0.45);

-- --------------------------------------------------------

--
-- Structure de la table `Languages`
--

CREATE TABLE `Languages` (
  `langIsoCode` varchar(10) NOT NULL,
  `langName` varchar(50) NOT NULL,
  `langLocalName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Languages`
--

INSERT INTO `Languages` (`langIsoCode`, `langName`, `langLocalName`) VALUES
('en', 'english', 'english'),
('es', 'espagnol', 'español'),
('fr', 'french', 'français');

-- --------------------------------------------------------

--
-- Structure de la table `MeasureScales`
--

CREATE TABLE `MeasureScales` (
  `measureScale` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MeasureScales`
--

INSERT INTO `MeasureScales` (`measureScale`) VALUES
('eu'),
('length'),
('uk'),
('us');

-- --------------------------------------------------------

--
-- Structure de la table `MeasureUnits`
--

CREATE TABLE `MeasureUnits` (
  `unitName` varchar(50) NOT NULL,
  `measureUnit` varchar(10) DEFAULT NULL,
  `toSystUnit` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MeasureUnits`
--

INSERT INTO `MeasureUnits` (`unitName`, `measureUnit`, `toSystUnit`) VALUES
('centimeter', 'cm', 1),
('eu', NULL, NULL),
('inch', 'inch', 2.54),
('uk', NULL, NULL),
('us', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Orders`
--

CREATE TABLE `Orders` (
  `orderID` varchar(100) NOT NULL,
  `userId` varchar(25) NOT NULL,
  `setDate` datetime NOT NULL,
  `vat` double NOT NULL,
  `subtotal` double NOT NULL,
  `shippingCost` double NOT NULL,
  `iso_currency` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-Addresses`
--

CREATE TABLE `Orders-Addresses` (
  `orderId` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `appartement` varchar(100) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-Box`
--

CREATE TABLE `Orders-Box` (
  `orderId` varchar(100) NOT NULL,
  `boxId` varchar(100) NOT NULL,
  `box_color` varchar(10) NOT NULL,
  `sizeMax` int(11) NOT NULL,
  `weight` double NOT NULL,
  `buy_price` double NOT NULL,
  `sellPrice` double NOT NULL,
  `shipping` double NOT NULL,
  `discount_value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-BoxProducts`
--

CREATE TABLE `Orders-BoxProducts` (
  `boxId` varchar(100) NOT NULL,
  `prodId` int(11) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `weight` double NOT NULL,
  `buy_price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-DiscountCodes`
--

CREATE TABLE `Orders-DiscountCodes` (
  `orderId` varchar(100) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `minAmount` double NOT NULL,
  `nbUse` int(11) DEFAULT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `isCombinable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `OrdersStatus`
--

CREATE TABLE `OrdersStatus` (
  `orderId` varchar(100) NOT NULL,
  `trackingNumber` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL,
  `adminId` int(11) NOT NULL,
  `deliveryMin` date NOT NULL,
  `deliveryMax` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Pages`
--

CREATE TABLE `Pages` (
  `userId` varchar(25) NOT NULL,
  `setDate` datetime NOT NULL,
  `page` varchar(100) NOT NULL,
  `timeOn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Pages-Actions`
--

CREATE TABLE `Pages-Actions` (
  `userId` varchar(25) NOT NULL,
  `setDate` datetime NOT NULL,
  `page_` varchar(100) NOT NULL,
  `action_` varchar(50) NOT NULL,
  `on_` varchar(100) NOT NULL,
  `onName` varchar(100) NOT NULL,
  `response` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `PagesParameters`
--

CREATE TABLE `PagesParameters` (
  `userId` varchar(25) NOT NULL,
  `setDate_` datetime NOT NULL,
  `page_` varchar(100) NOT NULL,
  `param_key` varchar(100) NOT NULL,
  `param_data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ProductBuyPrice`
--

CREATE TABLE `ProductBuyPrice` (
  `prodId` int(11) NOT NULL,
  `buyDate` datetime NOT NULL,
  `buy_country` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `buyPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductBuyPrice`
--

INSERT INTO `ProductBuyPrice` (`prodId`, `buyDate`, `buy_country`, `iso_currency`, `buyPrice`) VALUES
(1, '2020-02-28 00:00:00', 'belgium', 'eur', 3.56),
(2, '2019-12-06 18:02:20', 'belgium', 'eur', 381.59),
(3, '2019-11-07 18:02:20', 'france', 'eur', 154.72),
(4, '2019-10-09 18:02:20', 'belgium', 'eur', 451.09),
(5, '2019-09-10 18:02:20', 'france', 'eur', 316.96),
(6, '2019-08-12 18:02:20', 'belgium', 'eur', 80.01),
(7, '2019-07-14 18:02:20', 'france', 'eur', 382.64),
(8, '2019-06-15 18:02:20', 'belgium', 'eur', 189.59),
(9, '2019-05-17 18:02:20', 'france', 'eur', 269.95),
(10, '2019-04-18 18:02:20', 'france', 'eur', 405.81);

-- --------------------------------------------------------

--
-- Structure de la table `ProductFunctions`
--

CREATE TABLE `ProductFunctions` (
  `functionName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductFunctions`
--

INSERT INTO `ProductFunctions` (`functionName`) VALUES
('accessories'),
('clothes');

-- --------------------------------------------------------

--
-- Structure de la table `Products`
--

CREATE TABLE `Products` (
  `prodID` int(11) NOT NULL,
  `prodName` varchar(100) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `addedDate` datetime NOT NULL,
  `colorName` enum('red','gold','purple','pink','blue','green','white','black','beige','grey','brown','yellow','orange') NOT NULL,
  `colorRGB` varchar(50) NOT NULL,
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products`
--

INSERT INTO `Products` (`prodID`, `prodName`, `isAvailable`, `product_type`, `addedDate`, `colorName`, `colorRGB`, `weight`) VALUES
(1, 'boxproduct1', 1, 'boxproduct', '2020-01-08 15:00:05', 'green', '#33cc33', 0.54),
(2, 'boxproduct2', 1, 'boxproduct', '2020-01-09 15:00:05', 'blue', '#00ccff', 0.98),
(3, 'boxproduct3', 1, 'boxproduct', '2020-01-10 15:00:05', 'yellow', '#ffff00', 0.71),
(4, 'boxproduct3', 1, 'boxproduct', '2020-01-11 15:00:05', 'red', '#ff3300', 0.71),
(5, 'boxproduct3', 1, 'boxproduct', '2020-01-12 15:00:05', 'orange', '#ff9900', 0.34),
(6, 'basketproduct4', 1, 'basketproduct', '2020-01-13 15:00:05', 'black', '#000000', 0.32),
(7, 'basketproduct4', 1, 'basketproduct', '2020-01-14 15:00:05', 'green', '#33cc33', 0.65),
(8, 'basketproduct4', 1, 'basketproduct', '2020-01-15 15:00:05', 'white', '#ffffff', 0.48),
(9, 'basketproduct5', 1, 'basketproduct', '2020-01-16 15:00:05', 'yellow', '#ffff00', 0.73),
(10, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'red', '#ff3300', 0.76),
(11, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'blue', '#00ccff', 0.76),
(12, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'yellow', '#ffff00', 0.76),
(13, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'green', '#33cc33', 0.76),
(14, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'orange', '#ff9900', 0.76),
(15, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'black', '#000000', 0.76),
(16, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'white', '#ffffff', 0.76),
(17, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'red', '#00ccff', 0.76),
(18, 'basketproduct5', 1, 'basketproduct', '2020-01-17 15:00:05', 'yellow', '#ffff00', 0.76);

-- --------------------------------------------------------

--
-- Structure de la table `Products-Categories`
--

CREATE TABLE `Products-Categories` (
  `prodId` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Categories`
--

INSERT INTO `Products-Categories` (`prodId`, `category_name`) VALUES
(1, 'jackets'),
(2, 'jackets'),
(4, 'jackets'),
(5, 'jackets'),
(6, 'jackets'),
(8, 'jackets'),
(9, 'jackets'),
(10, 'jackets'),
(2, 'scarfs'),
(3, 'scarfs'),
(4, 'scarfs'),
(6, 'scarfs'),
(7, 'scarfs'),
(8, 'scarfs'),
(10, 'scarfs'),
(1, 'trousers'),
(3, 'trousers'),
(4, 'trousers'),
(5, 'trousers'),
(7, 'trousers'),
(8, 'trousers'),
(9, 'trousers'),
(1, 'vests'),
(2, 'vests'),
(3, 'vests'),
(5, 'vests'),
(6, 'vests'),
(7, 'vests'),
(9, 'vests'),
(10, 'vests');

-- --------------------------------------------------------

--
-- Structure de la table `Products-Collections`
--

CREATE TABLE `Products-Collections` (
  `prodId` int(11) NOT NULL,
  `collection_name` varchar(100) NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Collections`
--

INSERT INTO `Products-Collections` (`prodId`, `collection_name`, `beginDate`, `endDate`) VALUES
(1, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(1, 'women', NULL, NULL),
(2, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(2, 'women', NULL, NULL),
(3, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(3, 'women', NULL, NULL),
(4, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(4, 'women', NULL, NULL),
(5, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(5, 'women', NULL, NULL),
(6, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(6, 'women', NULL, NULL),
(7, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(7, 'women', NULL, NULL),
(8, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(8, 'women', NULL, NULL),
(9, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(9, 'women', NULL, NULL),
(10, 'autumn', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(10, 'women', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Products-ProductFunctions`
--

CREATE TABLE `Products-ProductFunctions` (
  `prodId` int(11) NOT NULL,
  `function_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-ProductFunctions`
--

INSERT INTO `Products-ProductFunctions` (`prodId`, `function_name`) VALUES
(1, 'accessories'),
(2, 'accessories'),
(3, 'accessories'),
(4, 'accessories'),
(5, 'accessories'),
(6, 'accessories'),
(7, 'accessories'),
(8, 'accessories'),
(9, 'accessories'),
(10, 'accessories'),
(1, 'clothes'),
(2, 'clothes'),
(3, 'clothes'),
(4, 'clothes'),
(5, 'clothes'),
(6, 'clothes'),
(7, 'clothes'),
(8, 'clothes'),
(9, 'clothes'),
(10, 'clothes');

-- --------------------------------------------------------

--
-- Structure de la table `Products-Sizes`
--

CREATE TABLE `Products-Sizes` (
  `prodId` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Sizes`
--

INSERT INTO `Products-Sizes` (`prodId`, `size_name`, `stock`) VALUES
(1, 'l', 6),
(1, 'm', 10),
(1, 's', 3),
(2, 'l', 3),
(2, 'm', 6),
(2, 's', 10),
(3, 'l', 9),
(3, 'm', 1),
(3, 's', 1),
(4, 'l', 3),
(4, 'm', 8),
(4, 's', 3),
(5, 'l', 3),
(5, 'm', 2),
(5, 's', 2),
(6, 'l', 5),
(6, 'm', 3),
(6, 's', 5),
(7, 'l', 7),
(7, 'm', 8),
(7, 's', 9),
(8, 'l', 5),
(8, 'm', 4),
(8, 's', 7),
(9, 'l', 2),
(9, 'm', 9),
(9, 's', 9),
(10, 'l', 1),
(10, 'm', 3),
(10, 's', 7);

-- --------------------------------------------------------

--
-- Structure de la table `ProductsDescriptions`
--

CREATE TABLE `ProductsDescriptions` (
  `prodId` int(11) NOT NULL,
  `lang_` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsDescriptions`
--

INSERT INTO `ProductsDescriptions` (`prodId`, `lang_`, `description`) VALUES
(1, 'en', 'this description is in english'),
(1, 'es', 'esta descripción está en inglés'),
(1, 'fr', 'cette description est en français '),
(2, 'en', 'this description is in english'),
(2, 'es', 'esta descripción está en inglés'),
(2, 'fr', 'cette description est en français '),
(3, 'en', 'this description is in english'),
(3, 'es', 'esta descripción está en inglés'),
(3, 'fr', 'cette description est en français '),
(4, 'en', 'this description is in english'),
(4, 'es', 'esta descripción está en inglés'),
(4, 'fr', 'cette description est en français '),
(5, 'en', 'this description is in english'),
(5, 'es', 'esta descripción está en inglés'),
(5, 'fr', 'cette description est en français '),
(6, 'en', 'this description is in english'),
(6, 'es', 'esta descripción está en inglés'),
(6, 'fr', 'cette description est en français '),
(7, 'en', 'this description is in english'),
(7, 'es', 'esta descripción está en inglés'),
(7, 'fr', 'cette description est en français '),
(8, 'en', 'this description is in english'),
(8, 'es', 'esta descripción está en inglés'),
(8, 'fr', 'cette description est en français '),
(9, 'en', 'this description is in english'),
(9, 'es', 'esta descripción está en inglés'),
(9, 'fr', 'cette description est en français '),
(10, 'en', 'this description is in english'),
(10, 'es', 'esta descripción está en inglés'),
(10, 'fr', 'cette description est en français ');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsDiscounts`
--

CREATE TABLE `ProductsDiscounts` (
  `prodId` int(11) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `discount_value` double NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsDiscounts`
--

INSERT INTO `ProductsDiscounts` (`prodId`, `country_`, `discount_value`, `beginDate`, `endDate`) VALUES
(6, 'australia', 0.16, '2020-01-27 18:02:20', '2020-02-27 18:02:20'),
(6, 'belgium', 0.12, '2020-01-30 18:02:20', '2020-03-01 18:02:20'),
(6, 'canada', 0.31, '2020-01-28 18:02:20', '2020-02-28 18:02:20'),
(6, 'switzerland', 0.45, '2020-01-29 18:02:20', '2020-02-29 18:02:20'),
(7, 'australia', 0.45, '2020-01-31 18:02:20', '2020-03-02 18:02:20'),
(7, 'belgium', 0.45, '2020-02-03 18:02:20', '2020-03-05 18:02:20'),
(7, 'canada', 0.16, '2020-02-01 18:02:20', '2020-03-03 18:02:20'),
(7, 'switzerland', 0.31, '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
(8, 'australia', 0.12, '2020-02-04 18:02:20', '2020-03-06 18:02:20'),
(8, 'belgium', 0.31, '2020-02-07 18:02:20', '2020-03-09 18:02:20'),
(8, 'canada', 0.45, '2020-02-05 18:02:20', '2020-03-07 18:02:20'),
(8, 'switzerland', 0.16, '2020-02-06 18:02:20', '2020-03-08 18:02:20'),
(9, 'australia', 0.45, '2020-02-08 18:02:20', '2020-03-10 18:02:20'),
(9, 'belgium', 0.16, '2020-02-11 18:02:20', '2020-03-13 18:02:20'),
(9, 'canada', 0.12, '2020-02-09 18:02:20', '2020-03-11 18:02:20'),
(9, 'switzerland', 0.45, '2020-02-10 18:02:20', '2020-03-12 18:02:20'),
(10, 'australia', 0.31, '2020-02-12 18:02:20', '2020-03-14 18:02:20'),
(10, 'belgium', 0.45, '2020-02-15 18:02:20', '2020-03-17 18:02:20'),
(10, 'canada', 0.45, '2020-02-13 18:02:20', '2020-03-15 18:02:20'),
(10, 'switzerland', 0.12, '2020-02-14 18:02:20', '2020-03-16 18:02:20');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsMeasures`
--

CREATE TABLE `ProductsMeasures` (
  `prodId` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `body_part` varchar(30) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsMeasures`
--

INSERT INTO `ProductsMeasures` (`prodId`, `size_name`, `body_part`, `unit_name`, `value`) VALUES
(1, 'l', 'arm', 'centimeter', 99.65),
(1, 'l', 'bust', 'centimeter', 104.27),
(1, 'l', 'hip', 'centimeter', 95.67),
(1, 'l', 'waist', 'centimeter', 87.65),
(1, 'l', 'waist to floor', 'centimeter', 76.62),
(1, 'm', 'arm', 'centimeter', 99.39),
(1, 'm', 'bust', 'centimeter', 102.31),
(1, 'm', 'hip', 'centimeter', 94.85),
(1, 'm', 'waist', 'centimeter', 85.55),
(1, 'm', 'waist to floor', 'centimeter', 75.18),
(1, 's', 'arm', 'centimeter', 99.38),
(1, 's', 'bust', 'centimeter', 101.62),
(1, 's', 'hip', 'centimeter', 92.25),
(1, 's', 'waist', 'centimeter', 84.18),
(1, 's', 'waist to floor', 'centimeter', 73.24),
(2, 'l', 'arm', 'centimeter', 62.76),
(2, 'l', 'bust', 'centimeter', 99.43),
(2, 'l', 'hip', 'centimeter', 56.58),
(2, 'l', 'waist', 'centimeter', 94.91),
(2, 'l', 'waist to floor', 'centimeter', 103.75),
(2, 'm', 'arm', 'centimeter', 59.87),
(2, 'm', 'bust', 'centimeter', 97.66),
(2, 'm', 'hip', 'centimeter', 54.52),
(2, 'm', 'waist', 'centimeter', 92.92),
(2, 'm', 'waist to floor', 'centimeter', 100.97),
(2, 's', 'arm', 'centimeter', 59.35),
(2, 's', 'bust', 'centimeter', 97.36),
(2, 's', 'hip', 'centimeter', 54.26),
(2, 's', 'waist', 'centimeter', 92.24),
(2, 's', 'waist to floor', 'centimeter', 99.56),
(3, 'l', 'arm', 'centimeter', 104.44),
(3, 'l', 'bust', 'centimeter', 88.66),
(3, 'l', 'hip', 'centimeter', 102.36),
(3, 'l', 'waist', 'centimeter', 87.61),
(3, 'l', 'waist to floor', 'centimeter', 54.76),
(3, 'm', 'arm', 'centimeter', 102.09),
(3, 'm', 'bust', 'centimeter', 86.65),
(3, 'm', 'hip', 'centimeter', 99.48),
(3, 'm', 'waist', 'centimeter', 86.85),
(3, 'm', 'waist to floor', 'centimeter', 53.75),
(3, 's', 'arm', 'centimeter', 99.19),
(3, 's', 'bust', 'centimeter', 84.67),
(3, 's', 'hip', 'centimeter', 98.03),
(3, 's', 'waist', 'centimeter', 85.22),
(3, 's', 'waist to floor', 'centimeter', 52.37),
(4, 'l', 'arm', 'centimeter', 94.92),
(4, 'l', 'bust', 'centimeter', 65.08),
(4, 'l', 'hip', 'centimeter', 100.54),
(4, 'l', 'waist', 'centimeter', 114.58),
(4, 'l', 'waist to floor', 'centimeter', 119.06),
(4, 'm', 'arm', 'centimeter', 94.61),
(4, 'm', 'bust', 'centimeter', 64),
(4, 'm', 'hip', 'centimeter', 98.88),
(4, 'm', 'waist', 'centimeter', 112.78),
(4, 'm', 'waist to floor', 'centimeter', 118.05),
(4, 's', 'arm', 'centimeter', 94.03),
(4, 's', 'bust', 'centimeter', 63.15),
(4, 's', 'hip', 'centimeter', 98.8),
(4, 's', 'waist', 'centimeter', 110.21),
(4, 's', 'waist to floor', 'centimeter', 117.42),
(5, 'l', 'arm', 'centimeter', 109.32),
(5, 'l', 'bust', 'centimeter', 113.93),
(5, 'l', 'hip', 'centimeter', 78.57),
(5, 'l', 'waist', 'centimeter', 89.18),
(5, 'l', 'waist to floor', 'centimeter', 112.96),
(5, 'm', 'arm', 'centimeter', 108.42),
(5, 'm', 'bust', 'centimeter', 111.45),
(5, 'm', 'hip', 'centimeter', 77.96),
(5, 'm', 'waist', 'centimeter', 86.73),
(5, 'm', 'waist to floor', 'centimeter', 110.64),
(5, 's', 'arm', 'centimeter', 108.42),
(5, 's', 'bust', 'centimeter', 111.2),
(5, 's', 'hip', 'centimeter', 76.71),
(5, 's', 'waist', 'centimeter', 86.42),
(5, 's', 'waist to floor', 'centimeter', 108.75),
(6, 'l', 'arm', 'centimeter', 69.79),
(6, 'l', 'bust', 'centimeter', 99.75),
(6, 'l', 'hip', 'centimeter', 53.88),
(6, 'l', 'waist', 'centimeter', 88.48),
(6, 'l', 'waist to floor', 'centimeter', 55.87),
(6, 'm', 'arm', 'centimeter', 68.56),
(6, 'm', 'bust', 'centimeter', 97.06),
(6, 'm', 'hip', 'centimeter', 52.18),
(6, 'm', 'waist', 'centimeter', 88.23),
(6, 'm', 'waist to floor', 'centimeter', 54.41),
(6, 's', 'arm', 'centimeter', 66.27),
(6, 's', 'bust', 'centimeter', 96.67),
(6, 's', 'hip', 'centimeter', 50.02),
(6, 's', 'waist', 'centimeter', 85.51),
(6, 's', 'waist to floor', 'centimeter', 53.44),
(7, 'l', 'arm', 'centimeter', 120),
(7, 'l', 'bust', 'centimeter', 90.06),
(7, 'l', 'hip', 'centimeter', 86.04),
(7, 'l', 'waist', 'centimeter', 68.58),
(7, 'l', 'waist to floor', 'centimeter', 104.45),
(7, 'm', 'arm', 'centimeter', 119.49),
(7, 'm', 'bust', 'centimeter', 89.44),
(7, 'm', 'hip', 'centimeter', 84.03),
(7, 'm', 'waist', 'centimeter', 65.94),
(7, 'm', 'waist to floor', 'centimeter', 102.11),
(7, 's', 'arm', 'centimeter', 118.07),
(7, 's', 'bust', 'centimeter', 88.65),
(7, 's', 'hip', 'centimeter', 83.21),
(7, 's', 'waist', 'centimeter', 65.91),
(7, 's', 'waist to floor', 'centimeter', 101.99),
(8, 'l', 'arm', 'centimeter', 125.57),
(8, 'l', 'bust', 'centimeter', 51.54),
(8, 'l', 'hip', 'centimeter', 65),
(8, 'l', 'waist', 'centimeter', 119.26),
(8, 'l', 'waist to floor', 'centimeter', 74.39),
(8, 'm', 'arm', 'centimeter', 122.85),
(8, 'm', 'bust', 'centimeter', 51.26),
(8, 'm', 'hip', 'centimeter', 63.85),
(8, 'm', 'waist', 'centimeter', 117.75),
(8, 'm', 'waist to floor', 'centimeter', 73.68),
(8, 's', 'arm', 'centimeter', 120.6),
(8, 's', 'bust', 'centimeter', 50.82),
(8, 's', 'hip', 'centimeter', 62.86),
(8, 's', 'waist', 'centimeter', 116.38),
(8, 's', 'waist to floor', 'centimeter', 71.8),
(9, 'l', 'arm', 'centimeter', 120.58),
(9, 'l', 'bust', 'centimeter', 114.74),
(9, 'l', 'hip', 'centimeter', 83.75),
(9, 'l', 'waist', 'centimeter', 61.24),
(9, 'l', 'waist to floor', 'centimeter', 56.22),
(9, 'm', 'arm', 'centimeter', 120.23),
(9, 'm', 'bust', 'centimeter', 114.38),
(9, 'm', 'hip', 'centimeter', 83.21),
(9, 'm', 'waist', 'centimeter', 59.06),
(9, 'm', 'waist to floor', 'centimeter', 54.18),
(9, 's', 'arm', 'centimeter', 119.37),
(9, 's', 'bust', 'centimeter', 112.56),
(9, 's', 'hip', 'centimeter', 81.58),
(9, 's', 'waist', 'centimeter', 57.64),
(9, 's', 'waist to floor', 'centimeter', 51.48),
(10, 'l', 'arm', 'centimeter', 115.56),
(10, 'l', 'bust', 'centimeter', 67.45),
(10, 'l', 'hip', 'centimeter', 67.96),
(10, 'l', 'waist', 'centimeter', 94.99),
(10, 'l', 'waist to floor', 'centimeter', 54.59),
(10, 'm', 'arm', 'centimeter', 113.38),
(10, 'm', 'bust', 'centimeter', 65.5),
(10, 'm', 'hip', 'centimeter', 65.03),
(10, 'm', 'waist', 'centimeter', 92.92),
(10, 'm', 'waist to floor', 'centimeter', 53.77),
(10, 's', 'arm', 'centimeter', 110.44),
(10, 's', 'bust', 'centimeter', 64.19),
(10, 's', 'hip', 'centimeter', 63.77),
(10, 's', 'waist', 'centimeter', 91.1),
(10, 's', 'waist to floor', 'centimeter', 52.01);

-- --------------------------------------------------------

--
-- Structure de la table `ProductsPictures`
--

CREATE TABLE `ProductsPictures` (
  `prodId` int(11) NOT NULL,
  `pictureID` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsPictures`
--

INSERT INTO `ProductsPictures` (`prodId`, `pictureID`, `picture`) VALUES
(1, 1, 'picture01.jpeg'),
(1, 2, 'picture02.jpeg'),
(1, 3, 'picture03.jpeg'),
(2, 1, 'picture01.jpeg'),
(2, 2, 'picture02.jpeg'),
(2, 3, 'picture03.jpeg'),
(3, 1, 'picture01.jpeg'),
(3, 2, 'picture02.jpeg'),
(3, 3, 'picture03.jpeg'),
(4, 1, 'picture01.jpeg'),
(4, 2, 'picture02.jpeg'),
(4, 3, 'picture03.jpeg'),
(5, 1, 'picture01.jpeg'),
(5, 2, 'picture02.jpeg'),
(5, 3, 'picture03.jpeg'),
(6, 1, 'picture01.jpeg'),
(6, 2, 'picture02.jpeg'),
(6, 3, 'picture03.jpeg'),
(7, 1, 'picture01.jpeg'),
(7, 2, 'picture02.jpeg'),
(7, 3, 'picture03.jpeg'),
(8, 1, 'picture01.jpeg'),
(8, 2, 'picture02.jpeg'),
(8, 3, 'picture03.jpeg'),
(9, 1, 'picture01.jpeg'),
(9, 2, 'picture02.jpeg'),
(9, 3, 'picture03.jpeg'),
(10, 1, 'picture01.jpeg'),
(10, 2, 'picture02.jpeg'),
(10, 3, 'picture03.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsPrices`
--

CREATE TABLE `ProductsPrices` (
  `prodId` int(11) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsPrices`
--

INSERT INTO `ProductsPrices` (`prodId`, `country_`, `iso_currency`, `price`) VALUES
(6, 'australia', 'aud', 20.45),
(6, 'australia', 'cad', 32.83),
(6, 'australia', 'chf', 61.56),
(6, 'australia', 'eur', 46.17),
(6, 'australia', 'gbp', 13.3),
(6, 'australia', 'jpy', 24.23),
(6, 'australia', 'usd', 33.15),
(6, 'belgium', 'aud', 94.22),
(6, 'belgium', 'cad', 85.55),
(6, 'belgium', 'chf', 41.17),
(6, 'belgium', 'eur', 65.66),
(6, 'belgium', 'gbp', 90.23),
(6, 'belgium', 'jpy', 74),
(6, 'belgium', 'usd', 33.25),
(6, 'canada', 'aud', 73.38),
(6, 'canada', 'cad', 84.25),
(6, 'canada', 'chf', 52.06),
(6, 'canada', 'eur', 47.32),
(6, 'canada', 'gbp', 92.55),
(6, 'canada', 'jpy', 36.55),
(6, 'canada', 'usd', 99.4),
(6, 'switzerland', 'aud', 27.45),
(6, 'switzerland', 'cad', 12.21),
(6, 'switzerland', 'chf', 83.04),
(6, 'switzerland', 'eur', 74.14),
(6, 'switzerland', 'gbp', 49.5),
(6, 'switzerland', 'jpy', 19.08),
(6, 'switzerland', 'usd', 77.17),
(7, 'australia', 'aud', 97.95),
(7, 'australia', 'cad', 88.7),
(7, 'australia', 'chf', 67.49),
(7, 'australia', 'eur', 65.09),
(7, 'australia', 'gbp', 78.13),
(7, 'australia', 'jpy', 38.45),
(7, 'australia', 'usd', 80.81),
(7, 'belgium', 'aud', 86.79),
(7, 'belgium', 'cad', 43.31),
(7, 'belgium', 'chf', 61.84),
(7, 'belgium', 'eur', 90.19),
(7, 'belgium', 'gbp', 63.46),
(7, 'belgium', 'jpy', 13.06),
(7, 'belgium', 'usd', 47.4),
(7, 'canada', 'aud', 48.02),
(7, 'canada', 'cad', 87.47),
(7, 'canada', 'chf', 56.17),
(7, 'canada', 'eur', 40.9),
(7, 'canada', 'gbp', 33.21),
(7, 'canada', 'jpy', 91.05),
(7, 'canada', 'usd', 42.99),
(7, 'switzerland', 'aud', 74.31),
(7, 'switzerland', 'cad', 28.1),
(7, 'switzerland', 'chf', 42.08),
(7, 'switzerland', 'eur', 98.43),
(7, 'switzerland', 'gbp', 41.25),
(7, 'switzerland', 'jpy', 82.51),
(7, 'switzerland', 'usd', 43.87),
(8, 'australia', 'aud', 28.93),
(8, 'australia', 'cad', 16.84),
(8, 'australia', 'chf', 36.42),
(8, 'australia', 'eur', 89.43),
(8, 'australia', 'gbp', 66.92),
(8, 'australia', 'jpy', 21.49),
(8, 'australia', 'usd', 79.66),
(8, 'belgium', 'aud', 66.15),
(8, 'belgium', 'cad', 29.11),
(8, 'belgium', 'chf', 91.52),
(8, 'belgium', 'eur', 66.65),
(8, 'belgium', 'gbp', 38.51),
(8, 'belgium', 'jpy', 88.94),
(8, 'belgium', 'usd', 15.38),
(8, 'canada', 'aud', 80.65),
(8, 'canada', 'cad', 80.75),
(8, 'canada', 'chf', 97.17),
(8, 'canada', 'eur', 51.68),
(8, 'canada', 'gbp', 47.91),
(8, 'canada', 'jpy', 85.06),
(8, 'canada', 'usd', 75.08),
(8, 'switzerland', 'aud', 14.74),
(8, 'switzerland', 'cad', 63.97),
(8, 'switzerland', 'chf', 80.2),
(8, 'switzerland', 'eur', 91.13),
(8, 'switzerland', 'gbp', 80.06),
(8, 'switzerland', 'jpy', 60.09),
(8, 'switzerland', 'usd', 14.48),
(9, 'australia', 'aud', 24.01),
(9, 'australia', 'cad', 83.58),
(9, 'australia', 'chf', 39.9),
(9, 'australia', 'eur', 64.3),
(9, 'australia', 'gbp', 52.21),
(9, 'australia', 'jpy', 19.36),
(9, 'australia', 'usd', 81.34),
(9, 'belgium', 'aud', 81.76),
(9, 'belgium', 'cad', 95.61),
(9, 'belgium', 'chf', 76.87),
(9, 'belgium', 'eur', 35.28),
(9, 'belgium', 'gbp', 67.18),
(9, 'belgium', 'jpy', 19.32),
(9, 'belgium', 'usd', 85.81),
(9, 'canada', 'aud', 27.01),
(9, 'canada', 'cad', 83.72),
(9, 'canada', 'chf', 28.78),
(9, 'canada', 'eur', 68.85),
(9, 'canada', 'gbp', 37.11),
(9, 'canada', 'jpy', 62.39),
(9, 'canada', 'usd', 86.73),
(9, 'switzerland', 'aud', 50.72),
(9, 'switzerland', 'cad', 26.77),
(9, 'switzerland', 'chf', 24.72),
(9, 'switzerland', 'eur', 42.38),
(9, 'switzerland', 'gbp', 90.09),
(9, 'switzerland', 'jpy', 68.91),
(9, 'switzerland', 'usd', 43.86),
(10, 'australia', 'aud', 91.92),
(10, 'australia', 'cad', 55.42),
(10, 'australia', 'chf', 48.74),
(10, 'australia', 'eur', 40.51),
(10, 'australia', 'gbp', 23.81),
(10, 'australia', 'jpy', 31.01),
(10, 'australia', 'usd', 15.8),
(10, 'belgium', 'aud', 32.78),
(10, 'belgium', 'cad', 94.51),
(10, 'belgium', 'chf', 83.3),
(10, 'belgium', 'eur', 71.45),
(10, 'belgium', 'gbp', 74.37),
(10, 'belgium', 'jpy', 59.81),
(10, 'belgium', 'usd', 69.87),
(10, 'canada', 'aud', 47),
(10, 'canada', 'cad', 38.41),
(10, 'canada', 'chf', 93.64),
(10, 'canada', 'eur', 77.86),
(10, 'canada', 'gbp', 61.7),
(10, 'canada', 'jpy', 67.46),
(10, 'canada', 'usd', 20.01),
(10, 'switzerland', 'aud', 37.15),
(10, 'switzerland', 'cad', 80.74),
(10, 'switzerland', 'chf', 73.1),
(10, 'switzerland', 'eur', 99.71),
(10, 'switzerland', 'gbp', 83.81),
(10, 'switzerland', 'jpy', 82.69),
(10, 'switzerland', 'usd', 35.46);

-- --------------------------------------------------------

--
-- Structure de la table `ProductsShippings`
--

CREATE TABLE `ProductsShippings` (
  `prodId` int(11) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsShippings`
--

INSERT INTO `ProductsShippings` (`prodId`, `country_`, `iso_currency`, `price`, `time`) VALUES
(1, 'australia', 'aud', 2.59, 0),
(1, 'belgium', 'aud', 4.58, 0),
(1, 'canada', 'aud', 4.96, 0),
(1, 'switzerland', 'aud', 3.62, 0),
(1, 'australia', 'cad', 6.82, 0),
(1, 'belgium', 'cad', 3.58, 0),
(1, 'canada', 'cad', 7.52, 0),
(1, 'switzerland', 'cad', 0.31, 0),
(1, 'australia', 'chf', 1.43, 0),
(1, 'belgium', 'chf', 1.8, 0),
(1, 'canada', 'chf', 8.79, 0),
(1, 'switzerland', 'chf', 0.26, 0),
(1, 'australia', 'eur', 0.49, 0),
(1, 'belgium', 'eur', 3.87, 0),
(1, 'canada', 'eur', 2.04, 0),
(1, 'switzerland', 'eur', 2.3, 0),
(1, 'australia', 'gbp', 6.62, 0),
(1, 'belgium', 'gbp', 0.95, 0),
(1, 'canada', 'gbp', 9.25, 0),
(1, 'switzerland', 'gbp', 4.46, 0),
(1, 'australia', 'jpy', 0.07, 0),
(1, 'belgium', 'jpy', 8.93, 0),
(1, 'canada', 'jpy', 7.82, 0),
(1, 'switzerland', 'jpy', 2.61, 0),
(1, 'australia', 'usd', 6.85, 0),
(1, 'belgium', 'usd', 6.75, 0),
(1, 'canada', 'usd', 4.91, 0),
(1, 'switzerland', 'usd', 9.32, 0),
(2, 'australia', 'aud', 0.42, 0),
(2, 'belgium', 'aud', 4.73, 0),
(2, 'canada', 'aud', 1.95, 0),
(2, 'switzerland', 'aud', 6.92, 0),
(2, 'australia', 'cad', 9.44, 0),
(2, 'belgium', 'cad', 6.16, 0),
(2, 'canada', 'cad', 0.9, 0),
(2, 'switzerland', 'cad', 8.91, 0),
(2, 'australia', 'chf', 7.29, 0),
(2, 'belgium', 'chf', 9.26, 0),
(2, 'canada', 'chf', 3.61, 0),
(2, 'switzerland', 'chf', 6.21, 0),
(2, 'australia', 'eur', 2.06, 0),
(2, 'belgium', 'eur', 0.62, 0),
(2, 'canada', 'eur', 4.97, 0),
(2, 'switzerland', 'eur', 9.07, 0),
(2, 'australia', 'gbp', 9.87, 0),
(2, 'belgium', 'gbp', 2.74, 0),
(2, 'canada', 'gbp', 8.57, 0),
(2, 'switzerland', 'gbp', 3.01, 0),
(2, 'australia', 'jpy', 5.7, 0),
(2, 'belgium', 'jpy', 9.11, 0),
(2, 'canada', 'jpy', 7.12, 0),
(2, 'switzerland', 'jpy', 7.89, 0),
(2, 'australia', 'usd', 0.96, 0),
(2, 'belgium', 'usd', 3.66, 0),
(2, 'canada', 'usd', 7.9, 0),
(2, 'switzerland', 'usd', 4.46, 0),
(3, 'australia', 'aud', 3.64, 0),
(3, 'belgium', 'aud', 0.66, 0),
(3, 'canada', 'aud', 1.04, 0),
(3, 'switzerland', 'aud', 5.2, 0),
(3, 'australia', 'cad', 0.71, 0),
(3, 'belgium', 'cad', 9.17, 0),
(3, 'canada', 'cad', 6.37, 0),
(3, 'switzerland', 'cad', 6.88, 0),
(3, 'australia', 'chf', 7.16, 0),
(3, 'belgium', 'chf', 5.67, 0),
(3, 'canada', 'chf', 1.95, 0),
(3, 'switzerland', 'chf', 9.9, 0),
(3, 'australia', 'eur', 4.53, 0),
(3, 'belgium', 'eur', 0.99, 0),
(3, 'canada', 'eur', 6.18, 0),
(3, 'switzerland', 'eur', 8.96, 0),
(3, 'australia', 'gbp', 1.58, 0),
(3, 'belgium', 'gbp', 1, 0),
(3, 'canada', 'gbp', 6.49, 0),
(3, 'switzerland', 'gbp', 2.37, 0),
(3, 'australia', 'jpy', 7.88, 0),
(3, 'belgium', 'jpy', 6.74, 0),
(3, 'canada', 'jpy', 8.29, 0),
(3, 'switzerland', 'jpy', 9.51, 0),
(3, 'australia', 'usd', 5.3, 0),
(3, 'belgium', 'usd', 0.83, 0),
(3, 'canada', 'usd', 8.31, 0),
(3, 'switzerland', 'usd', 3.02, 0),
(4, 'australia', 'aud', 3.58, 0),
(4, 'belgium', 'aud', 6.78, 0),
(4, 'canada', 'aud', 9.05, 0),
(4, 'switzerland', 'aud', 8.95, 0),
(4, 'australia', 'cad', 0.55, 0),
(4, 'belgium', 'cad', 9.85, 0),
(4, 'canada', 'cad', 5.35, 0),
(4, 'switzerland', 'cad', 7.64, 0),
(4, 'australia', 'chf', 7.15, 0),
(4, 'belgium', 'chf', 0.92, 0),
(4, 'canada', 'chf', 2.64, 0),
(4, 'switzerland', 'chf', 1.72, 0),
(4, 'australia', 'eur', 2.34, 0),
(4, 'belgium', 'eur', 9.53, 0),
(4, 'canada', 'eur', 3.74, 0),
(4, 'switzerland', 'eur', 7.93, 0),
(4, 'australia', 'gbp', 3.27, 0),
(4, 'belgium', 'gbp', 9.82, 0),
(4, 'canada', 'gbp', 6.41, 0),
(4, 'switzerland', 'gbp', 0.25, 0),
(4, 'australia', 'jpy', 7.32, 0),
(4, 'belgium', 'jpy', 6.4, 0),
(4, 'canada', 'jpy', 1.47, 0),
(4, 'switzerland', 'jpy', 3.61, 0),
(4, 'australia', 'usd', 1.45, 0),
(4, 'belgium', 'usd', 9.57, 0),
(4, 'canada', 'usd', 7.81, 0),
(4, 'switzerland', 'usd', 4.58, 0),
(5, 'australia', 'aud', 7.19, 0),
(5, 'belgium', 'aud', 0.18, 0),
(5, 'canada', 'aud', 7.48, 0),
(5, 'switzerland', 'aud', 4.16, 0),
(5, 'australia', 'cad', 8.45, 0),
(5, 'belgium', 'cad', 9.74, 0),
(5, 'canada', 'cad', 0.3, 0),
(5, 'switzerland', 'cad', 7.16, 0),
(5, 'australia', 'chf', 4.4, 0),
(5, 'belgium', 'chf', 2.32, 0),
(5, 'canada', 'chf', 7.16, 0),
(5, 'switzerland', 'chf', 0.48, 0),
(5, 'australia', 'eur', 9.66, 0),
(5, 'belgium', 'eur', 4.58, 0),
(5, 'canada', 'eur', 8.62, 0),
(5, 'switzerland', 'eur', 5.73, 0),
(5, 'australia', 'gbp', 8.19, 0),
(5, 'belgium', 'gbp', 5.41, 0),
(5, 'canada', 'gbp', 2.54, 0),
(5, 'switzerland', 'gbp', 5.37, 0),
(5, 'australia', 'jpy', 2.78, 0),
(5, 'belgium', 'jpy', 4.58, 0),
(5, 'canada', 'jpy', 7.89, 0),
(5, 'switzerland', 'jpy', 1.44, 0),
(5, 'australia', 'usd', 4.47, 0),
(5, 'belgium', 'usd', 4.61, 0),
(5, 'canada', 'usd', 2.79, 0),
(5, 'switzerland', 'usd', 0.09, 0),
(6, 'australia', 'aud', 7.89, 0),
(6, 'belgium', 'aud', 3.02, 0),
(6, 'canada', 'aud', 8.15, 0),
(6, 'switzerland', 'aud', 0.99, 0),
(6, 'australia', 'cad', 0.06, 0),
(6, 'belgium', 'cad', 3.4, 0),
(6, 'canada', 'cad', 6.19, 0),
(6, 'switzerland', 'cad', 6.52, 0),
(6, 'australia', 'chf', 9.13, 0),
(6, 'belgium', 'chf', 1.84, 0),
(6, 'canada', 'chf', 4.82, 0),
(6, 'switzerland', 'chf', 4.91, 0),
(6, 'australia', 'eur', 9.83, 0),
(6, 'belgium', 'eur', 5.16, 0),
(6, 'canada', 'eur', 2.45, 0),
(6, 'switzerland', 'eur', 1.11, 0),
(6, 'australia', 'gbp', 9.41, 0),
(6, 'belgium', 'gbp', 3.21, 0),
(6, 'canada', 'gbp', 9.93, 0),
(6, 'switzerland', 'gbp', 8.31, 0),
(6, 'australia', 'jpy', 4.19, 0),
(6, 'belgium', 'jpy', 3.42, 0),
(6, 'canada', 'jpy', 3.09, 0),
(6, 'switzerland', 'jpy', 7.92, 0),
(6, 'australia', 'usd', 7.96, 0),
(6, 'belgium', 'usd', 0.29, 0),
(6, 'canada', 'usd', 9.45, 0),
(6, 'switzerland', 'usd', 3.11, 0),
(7, 'australia', 'aud', 1.69, 0),
(7, 'belgium', 'aud', 1.15, 0),
(7, 'canada', 'aud', 9.29, 0),
(7, 'switzerland', 'aud', 4.51, 0),
(7, 'australia', 'cad', 1.28, 0),
(7, 'belgium', 'cad', 7.74, 0),
(7, 'canada', 'cad', 9.63, 0),
(7, 'switzerland', 'cad', 5.3, 0),
(7, 'australia', 'chf', 4.69, 0),
(7, 'belgium', 'chf', 4.1, 0),
(7, 'canada', 'chf', 5.79, 0),
(7, 'switzerland', 'chf', 7.93, 0),
(7, 'australia', 'eur', 0.81, 0),
(7, 'belgium', 'eur', 1.34, 0),
(7, 'canada', 'eur', 0.11, 0),
(7, 'switzerland', 'eur', 10, 0),
(7, 'australia', 'gbp', 0.38, 0),
(7, 'belgium', 'gbp', 5.42, 0),
(7, 'canada', 'gbp', 2.59, 0),
(7, 'switzerland', 'gbp', 5.55, 0),
(7, 'australia', 'jpy', 5.23, 0),
(7, 'belgium', 'jpy', 2.3, 0),
(7, 'canada', 'jpy', 8.02, 0),
(7, 'switzerland', 'jpy', 2.29, 0),
(7, 'australia', 'usd', 1.37, 0),
(7, 'belgium', 'usd', 3.78, 0),
(7, 'canada', 'usd', 2.05, 0),
(7, 'switzerland', 'usd', 3.22, 0),
(8, 'australia', 'aud', 5.46, 0),
(8, 'belgium', 'aud', 0.03, 0),
(8, 'canada', 'aud', 8.1, 0),
(8, 'switzerland', 'aud', 7.5, 0),
(8, 'australia', 'cad', 7.6, 0),
(8, 'belgium', 'cad', 6.59, 0),
(8, 'canada', 'cad', 3.16, 0),
(8, 'switzerland', 'cad', 1.69, 0),
(8, 'australia', 'chf', 8.63, 0),
(8, 'belgium', 'chf', 4.07, 0),
(8, 'canada', 'chf', 8.71, 0),
(8, 'switzerland', 'chf', 5.67, 0),
(8, 'australia', 'eur', 6.32, 0),
(8, 'belgium', 'eur', 0.12, 0),
(8, 'canada', 'eur', 4.59, 0),
(8, 'switzerland', 'eur', 2.81, 0),
(8, 'australia', 'gbp', 1.3, 0),
(8, 'belgium', 'gbp', 6.39, 0),
(8, 'canada', 'gbp', 0.54, 0),
(8, 'switzerland', 'gbp', 0.71, 0),
(8, 'australia', 'jpy', 7.79, 0),
(8, 'belgium', 'jpy', 5.51, 0),
(8, 'canada', 'jpy', 5.48, 0),
(8, 'switzerland', 'jpy', 2.69, 0),
(8, 'australia', 'usd', 5.02, 0),
(8, 'belgium', 'usd', 5.79, 0),
(8, 'canada', 'usd', 9.04, 0),
(8, 'switzerland', 'usd', 3.47, 0),
(9, 'australia', 'aud', 7.01, 0),
(9, 'belgium', 'aud', 4.35, 0),
(9, 'canada', 'aud', 4.93, 0),
(9, 'switzerland', 'aud', 3.01, 0),
(9, 'australia', 'cad', 8.08, 0),
(9, 'belgium', 'cad', 1.99, 0),
(9, 'canada', 'cad', 7.41, 0),
(9, 'switzerland', 'cad', 6.4, 0),
(9, 'australia', 'chf', 3.34, 0),
(9, 'belgium', 'chf', 0.46, 0),
(9, 'canada', 'chf', 6.03, 0),
(9, 'switzerland', 'chf', 9.69, 0),
(9, 'australia', 'eur', 4.99, 0),
(9, 'belgium', 'eur', 3.78, 0),
(9, 'canada', 'eur', 3.09, 0),
(9, 'switzerland', 'eur', 0.02, 0),
(9, 'australia', 'gbp', 0.26, 0),
(9, 'belgium', 'gbp', 0.99, 0),
(9, 'canada', 'gbp', 9.76, 0),
(9, 'switzerland', 'gbp', 2.04, 0),
(9, 'australia', 'jpy', 0.2, 0),
(9, 'belgium', 'jpy', 2.39, 0),
(9, 'canada', 'jpy', 5.38, 0),
(9, 'switzerland', 'jpy', 0.52, 0),
(9, 'australia', 'usd', 8.67, 0),
(9, 'belgium', 'usd', 1.73, 0),
(9, 'canada', 'usd', 1.5, 0),
(9, 'switzerland', 'usd', 9.64, 0),
(10, 'australia', 'aud', 7.55, 0),
(10, 'belgium', 'aud', 7.97, 0),
(10, 'canada', 'aud', 2.92, 0),
(10, 'switzerland', 'aud', 6.61, 0),
(10, 'australia', 'cad', 7.26, 0),
(10, 'belgium', 'cad', 1.11, 0),
(10, 'canada', 'cad', 3.18, 0),
(10, 'switzerland', 'cad', 8.51, 0),
(10, 'australia', 'chf', 9.18, 0),
(10, 'belgium', 'chf', 3.09, 0),
(10, 'canada', 'chf', 0.24, 0),
(10, 'switzerland', 'chf', 3.42, 0),
(10, 'australia', 'eur', 4.72, 0),
(10, 'belgium', 'eur', 7.7, 0),
(10, 'canada', 'eur', 6.7, 0),
(10, 'switzerland', 'eur', 8.53, 0),
(10, 'australia', 'gbp', 1.74, 0),
(10, 'belgium', 'gbp', 3.88, 0),
(10, 'canada', 'gbp', 3.84, 0),
(10, 'switzerland', 'gbp', 7.42, 0),
(10, 'australia', 'jpy', 0.52, 0),
(10, 'belgium', 'jpy', 6.33, 0),
(10, 'canada', 'jpy', 9.56, 0),
(10, 'switzerland', 'jpy', 4.79, 0),
(10, 'australia', 'usd', 8.42, 0),
(10, 'belgium', 'usd', 0.57, 0),
(10, 'canada', 'usd', 9.03, 0),
(10, 'switzerland', 'usd', 2.76, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ProductsTypes`
--

CREATE TABLE `ProductsTypes` (
  `productType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsTypes`
--

INSERT INTO `ProductsTypes` (`productType`) VALUES
('basketproduct'),
('boxproduct');

-- --------------------------------------------------------

--
-- Structure de la table `Sexes`
--

CREATE TABLE `Sexes` (
  `sexe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Sexes`
--

INSERT INTO `Sexes` (`sexe`) VALUES
('man'),
('other'),
('woman');

-- --------------------------------------------------------

--
-- Structure de la table `Sizes`
--

CREATE TABLE `Sizes` (
  `sizeName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Sizes`
--

INSERT INTO `Sizes` (`sizeName`) VALUES
('l'),
('m'),
('s');

-- --------------------------------------------------------

--
-- Structure de la table `Translations`
--

CREATE TABLE `Translations` (
  `translationID` int(11) NOT NULL,
  `en` text NOT NULL,
  `fr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Translations`
--

INSERT INTO `Translations` (`translationID`, `en`, `fr`) VALUES
(1, 'free with meimbox', 'gratuit avec meimbox');

-- --------------------------------------------------------

--
-- Structure de la table `TranslationStations`
--

CREATE TABLE `TranslationStations` (
  `usedInside` varchar(50) NOT NULL,
  `station` int(11) NOT NULL,
  `iso_lang` varchar(10) NOT NULL,
  `translation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TranslationStations`
--

INSERT INTO `TranslationStations` (`usedInside`, `station`, `iso_lang`, `translation`) VALUES
('error', 1, 'en', 'Sorry, this service is temporarily unavailable'),
('error', 1, 'fr', 'Désolé, ce service est pontuellement indisponible'),
('error', 2, 'en', 'this field can not be empty'),
('error', 2, 'fr', 'ce champ ne peut pas être vide'),
('error', 3, 'en', 'this field cannot contain numbers of the form 1997 | 297.829 or 0.321, etc ...'),
('error', 3, 'fr', 'ce champ ne peut contenir que des nombres au format 1997 | 297,829 ou 0,321, etc...'),
('error', 4, 'en', 'this field can only contain letters, numbers, spaces and the special characters `-` and` _`'),
('error', 4, 'fr', 'ce champ peut uniquement contenir des lettres, des chiffres, des espaces ansi que les caractères spéciaux `-` et `_`'),
('error', 5, 'en', 'you must tick a choice'),
('error', 5, 'fr', 'vous devez cocher un choix'),
('error', 6, 'en', 'the maximum number of characters for this field is'),
('error', 6, 'fr', 'le nombre de caractère maximum pour ce champ est de'),
('error', 7, 'en', 'Sorry, You have reached the maximum number of measurements.\\nNumber of current measures:'),
('error', 7, 'fr', 'Désolé, Vous avez atteint le nombre maximum de mesure.\\nNombre de measure actuelle:'),
('grid.php', 1, 'en', 'filters'),
('grid.php', 1, 'fr', 'filtres'),
('grid.php', 2, 'en', 'sorte by'),
('grid.php', 2, 'fr', 'trier'),
('grid.php', 3, 'en', 'newest'),
('grid.php', 3, 'fr', 'les plus récents'),
('grid.php', 4, 'en', 'older'),
('grid.php', 4, 'fr', 'les moins récents'),
('grid.php', 5, 'en', 'price - hight to low'),
('grid.php', 5, 'fr', 'prix - décroissant'),
('grid.php', 6, 'en', 'price - low to hight'),
('grid.php', 6, 'fr', 'prix - croissant'),
('grid.php', 7, 'en', 'type'),
('grid.php', 7, 'fr', 'type'),
('grid.php', 8, 'en', 'category'),
('grid.php', 8, 'fr', 'catégorie'),
('grid.php', 9, 'en', 'size'),
('grid.php', 9, 'fr', 'taille'),
('grid.php', 10, 'en', 'color'),
('grid.php', 10, 'fr', 'couleur'),
('grid.php', 11, 'en', 'price'),
('grid.php', 11, 'fr', 'prix'),
('grid.php', 12, 'en', 'minimum price'),
('grid.php', 12, 'fr', 'prix minimum'),
('grid.php', 13, 'en', 'maximum price'),
('grid.php', 13, 'fr', 'prix maximum'),
('grid.php', 14, 'en', 'apply'),
('grid.php', 14, 'fr', 'filtrer'),
('grid.php', 15, 'en', 'close filters'),
('grid.php', 15, 'fr', 'fermer'),
('grid.php', 16, 'en', 'measure name'),
('grid.php', 16, 'fr', 'nom de la mesure'),
('grid.php', 17, 'en', 'customize size'),
('grid.php', 17, 'fr', 'personnaliser'),
('grid.php', 18, 'en', 'choose a reference brand'),
('grid.php', 18, 'fr', 'choisir une marque de référence'),
('grid.php', 19, 'en', 'give my measurements'),
('grid.php', 19, 'fr', 'donner mes mensurations'),
('grid.php', 20, 'en', 'choose'),
('grid.php', 20, 'fr', 'choisir'),
('grid.php', 21, 'en', 'give measurements'),
('grid.php', 21, 'fr', 'indiquer mensurations'),
('grid.php', 22, 'en', 'manage measurements'),
('grid.php', 22, 'fr', 'gérer mes mensurations'),
('grid.php', 23, 'en', 'choose cut'),
('grid.php', 23, 'fr', 'choisir une coupe'),
('grid.php', 24, 'en', 'add to box'),
('grid.php', 24, 'fr', 'ajouter aux boxes'),
('grid.php', 25, 'en', 'add to cart'),
('grid.php', 25, 'fr', 'ajouter au panier'),
('grid.php', 26, 'en', '3D secure & <br>AES-256 encrypted payement'),
('grid.php', 26, 'fr', 'paiement crypté avec AES-256 et sécurisé avec 3D secure'),
('grid.php', 27, 'en', 'customer service 24h/7 response in 1h'),
('grid.php', 27, 'fr', 'service client 24h / 7 en 1h'),
('grid.php', 28, 'en', 'free & <br>easy return'),
('grid.php', 28, 'fr', 'retour facile et gratuit'),
('grid.php', 29, 'en', 'details'),
('grid.php', 29, 'fr', 'descriptions'),
('grid.php', 30, 'en', 'shipping + return'),
('grid.php', 30, 'fr', 'livraison + retour'),
('grid.php', 31, 'en', 'delivery and return terms'),
('grid.php', 31, 'fr', 'modalité de livraison et retour'),
('grid.php', 32, 'en', 'suggestions'),
('grid.php', 32, 'fr', 'suggestions'),
('grid.php', 33, 'en', 'brand reference'),
('grid.php', 33, 'fr', 'marques de référence'),
('grid.php', 34, 'en', 'select'),
('grid.php', 34, 'fr', 'sélectionner'),
('grid.php', 35, 'en', 'choose a reference brand for the size:'),
('grid.php', 35, 'fr', 'choisissez une marque de référence pour la taille:'),
('grid.php', 36, 'en', 'my measurements'),
('grid.php', 36, 'fr', 'mes mensurations'),
('grid.php', 37, 'en', 'save'),
('grid.php', 37, 'fr', 'enregistrer'),
('grid.php', 38, 'en', 'Indicate your measurements:'),
('grid.php', 38, 'fr', 'Indiquez vos mensurations:'),
('grid.php', 39, 'en', 'bust'),
('grid.php', 39, 'fr', 'buste'),
('grid.php', 40, 'en', 'arm'),
('grid.php', 40, 'fr', 'bras'),
('grid.php', 41, 'en', 'waist'),
('grid.php', 41, 'fr', 'taille'),
('grid.php', 42, 'en', 'hip'),
('grid.php', 42, 'fr', 'hanche'),
('grid.php', 43, 'en', 'inseam'),
('grid.php', 43, 'fr', 'entrejambe'),
('grid.php', 44, 'en', 'add measurement'),
('grid.php', 44, 'fr', 'ajouter une mesure'),
('grid.php', 45, 'en', 'your measurements'),
('grid.php', 45, 'fr', 'vos mensurations'),
('grid.php', 46, 'en', 'customization'),
('grid.php', 46, 'fr', 'personnalisation'),
('grid.php', 47, 'en', 'brand'),
('grid.php', 47, 'fr', 'marque'),
('grid.php', 48, 'en', 'measure'),
('grid.php', 48, 'fr', 'mesure'),
('grid.php', 49, 'en', 'edit'),
('grid.php', 49, 'fr', 'modifier'),
('grid.php', 50, 'en', 'Are you sure you want to delete this measurement?'),
('grid.php', 50, 'fr', 'Voulez-vous vraiment supprimer cette mesure?');

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `userId` varchar(25) NOT NULL,
  `lang_` varchar(10) NOT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `sexe_` varchar(10) DEFAULT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Users`
--

INSERT INTO `Users` (`userID`, `lang_`, `mail`, `password`, `firstname`, `lastname`, `birthday`, `newsletter`, `sexe_`, `setDate`) VALUES
(651853948, 'en', 'tajarose-7163@yopmail.com', 'khbmahedbazhlec', 'many', 'koshbin', '1993-02-27', 1, 'man', '2020-01-06 15:00:05'),
(666200808, 'en', 'rukefiwoh-5422@yopmail.com', 'qffrzrrfzfzfqcrzvrv', 'bob', 'makinson', '1995-02-27', 0, 'other', '2020-01-05 15:00:05'),
(846470517, 'fr', 'opoddimmuci-6274@yopmail.com', 'aefhzrbvcqzhm', 'segolen', 'royale', '1989-02-27', 1, 'woman', '2020-01-08 15:00:05'),
(934967739, 'en', 'ehewopuri-7678@yopmail.com', 'arrfraffqrfrfqrfcqf', 'elon', 'musk', '1997-02-27', 1, 'man', '2020-02-27 18:02:20'),
(997763060, 'es', 'annassubep-5363@yopmail.com', 'achbihzrzcrbhzcarc', 'victoria', 'secret', '1991-02-27', 0, 'woman', '2020-01-07 15:00:05');

-- --------------------------------------------------------

--
-- Structure de la table `UsersMeasures`
--

CREATE TABLE `UsersMeasures` (
  `userId` varchar(25) NOT NULL,
  `measureID` varchar(100) NOT NULL,
  `measureName` varchar(25) NOT NULL,
  `userBust` double NOT NULL,
  `userArm` double NOT NULL,
  `userWaist` double NOT NULL,
  `userHip` double NOT NULL,
  `userInseam` double NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `setDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `UsersMeasures`
--

INSERT INTO `UsersMeasures` (`userId`, `measureID`, `measureName`, `userBust`, `userArm`, `userWaist`, `userHip`, `userInseam`, `unit_name`, `setDate`) VALUES
(651853948, '651853948172', 'many dim1 devient isa 01', 68.34, 107.14, 98.29, 101.07, 64.96, 'inch', '2017-01-08 00:00:00'),
(651853948, '651853948740', 'many dim2', 104.23, 89.96, 100.27, 62.36, 114.95, 'centimeter', '2018-01-18 00:00:00'),
(997763060, '997763060659', 'victo dim1', 61.83, 107.19, 60.42, 52.28, 54.01, 'centimeter', '2017-02-28 00:00:00'),
(651853948, 'yeir4ywxbhor39ed7yto9kipdsjmb7djazwdrt7otka20200501224941wq1o2uhtngwpq63fnpujb496se7q6mh4gq9ci3lfua4', 'the other count', 11111.11111, 22222.22222, 33333.33333, 44444.44444, 55555.55555, 'centimeter', '2020-05-01 22:49:41');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Actions`
--
ALTER TABLE `Actions`
  ADD PRIMARY KEY (`action`);

--
-- Index pour la table `Addresses`
--
ALTER TABLE `Addresses`
  ADD PRIMARY KEY (`userId`,`address`,`zipcode`,`country_`) USING BTREE,
  ADD KEY `fk_country_.Addresses-FROM-Countries` (`country_`);

--
-- Index pour la table `Administrators`
--
ALTER TABLE `Administrators`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `fk_lang_.Administrators-FROM-Languages` (`lang_`),
  ADD KEY `fk_sexe_.Administrators-FROM-Sexes` (`sexe_`);

--
-- Index pour la table `Basket-DiscountCodes`
--
ALTER TABLE `Basket-DiscountCodes`
  ADD PRIMARY KEY (`userId`,`discount_code`),
  ADD KEY `fk_discount_code.Basket-DiscountCodes-FROM-DiscountCodes` (`discount_code`);

--
-- Index pour la table `Baskets-Box`
--
ALTER TABLE `Baskets-Box`
  ADD PRIMARY KEY (`userId`,`boxId`),
  ADD KEY `fk_boxId.Baskets-Box-FROM-Box` (`boxId`);

--
-- Index pour la table `Baskets-Products`
--
ALTER TABLE `Baskets-Products`
  ADD PRIMARY KEY (`userId`,`prodId`,`sequenceID`) USING BTREE,
  ADD KEY `fk_basketProdId.Baskets-Products-FROM-Products` (`prodId`),
  ADD KEY `fk_size_name.Baskets-Products-FROM-Sizes` (`size_name`),
  ADD KEY `fk_brand_name.Baskets-Products-FROM-BrandsMeasures` (`brand_name`),
  ADD KEY `fk_measureId.Baskets-Products-FROM-UsersMeasures` (`measureId`),
  ADD KEY `fk_cut_name.Baskets-Products-FROM-Cuts` (`cut_name`);

--
-- Index pour la table `BodyParts`
--
ALTER TABLE `BodyParts`
  ADD PRIMARY KEY (`bodyPart`);

--
-- Index pour la table `Box-Products`
--
ALTER TABLE `Box-Products`
  ADD PRIMARY KEY (`boxId`,`prodId`,`sequenceID`) USING BTREE,
  ADD KEY `fk_boxProdId.Box-Products-FROM-Products` (`prodId`),
  ADD KEY `fk_size_name.Box-Products-FROM-Sizes` (`size_name`),
  ADD KEY `fk_brand_name.Box-Products-FROM-BrandsMeasure` (`brand_name`),
  ADD KEY `fk_measureId.Box-Products-FROM-UsersMeasures` (`measureId`),
  ADD KEY `fk_cut_name.Box-Products-FROM-Cuts` (`cut_name`);

--
-- Index pour la table `BoxBuyPrice`
--
ALTER TABLE `BoxBuyPrice`
  ADD PRIMARY KEY (`box_color`,`setDate`),
  ADD KEY `fk_buy_country.BoxBuyPrice-FROM-BuyCountries` (`buy_country`),
  ADD KEY `fk_iso_currency.BoxBuyPrice-FROM-Currencies` (`iso_currency`);

--
-- Index pour la table `BoxColors`
--
ALTER TABLE `BoxColors`
  ADD PRIMARY KEY (`boxColor`);

--
-- Index pour la table `BoxColors-Products`
--
ALTER TABLE `BoxColors-Products`
  ADD PRIMARY KEY (`box_color`,`prodId`),
  ADD KEY `fk_prodId.BoxColors-Products-FROM-Products` (`prodId`);

--
-- Index pour la table `BoxDiscounts`
--
ALTER TABLE `BoxDiscounts`
  ADD PRIMARY KEY (`box_color`,`country_`),
  ADD KEY `fk_country_.BoxDiscounts-FROM-Countries` (`country_`),
  ADD KEY `discount_value` (`discount_value`);

--
-- Index pour la table `Boxes`
--
ALTER TABLE `Boxes`
  ADD PRIMARY KEY (`boxID`),
  ADD KEY `fk_box_color.Box-FROM-BoxColors` (`box_color`);

--
-- Index pour la table `BoxPrices`
--
ALTER TABLE `BoxPrices`
  ADD PRIMARY KEY (`box_color`,`country_`,`iso_currency`),
  ADD KEY `fk_country_.BoxPrices-FROM-Countries` (`country_`),
  ADD KEY `fk_iso_currency.BoxPrices-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `BoxProducts-Sizes`
--
ALTER TABLE `BoxProducts-Sizes`
  ADD PRIMARY KEY (`prodId`,`size_name`),
  ADD KEY `fk_size_name.BoxProducts-Sizes-FROM-Sizes` (`size_name`);

--
-- Index pour la table `BoxShipping`
--
ALTER TABLE `BoxShipping`
  ADD PRIMARY KEY (`box_color`,`iso_currency`,`country_`) USING BTREE,
  ADD KEY `fk_country_.BoxShipping-FROM-Countries` (`country_`),
  ADD KEY `fk_iso_currency.BoxShipping-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `BrandsMeasures`
--
ALTER TABLE `BrandsMeasures`
  ADD PRIMARY KEY (`brandName`,`body_part`,`size_name`,`minMax`,`unit_name`) USING BTREE,
  ADD KEY `FK_body_part.BrandsMeasures-FROM-BodyParts` (`body_part`),
  ADD KEY `FK_size_name.BrandsMeasures-FROM-Sizes` (`size_name`),
  ADD KEY `FK_unit_name.BrandsMeasures-FROM-MeasureUnits` (`unit_name`);

--
-- Index pour la table `BrandsPictures`
--
ALTER TABLE `BrandsPictures`
  ADD PRIMARY KEY (`brand_name`,`pictureID`);

--
-- Index pour la table `BuyCountries`
--
ALTER TABLE `BuyCountries`
  ADD PRIMARY KEY (`buyCountry`),
  ADD KEY `fk_iso_currency.BuyCountries-FROM-Currencies` (`iso_currency`);

--
-- Index pour la table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`categoryName`);

--
-- Index pour la table `Collections`
--
ALTER TABLE `Collections`
  ADD PRIMARY KEY (`collectionName`);

--
-- Index pour la table `Constants`
--
ALTER TABLE `Constants`
  ADD PRIMARY KEY (`constName`);

--
-- Index pour la table `Countries`
--
ALTER TABLE `Countries`
  ADD PRIMARY KEY (`country`),
  ADD KEY `fk_iso_currency.Countries-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `Currencies`
--
ALTER TABLE `Currencies`
  ADD PRIMARY KEY (`isoCurrency`);

--
-- Index pour la table `Cuts`
--
ALTER TABLE `Cuts`
  ADD PRIMARY KEY (`cutName`),
  ADD KEY `fk_unit_name.Cuts-FROM-MeasureUnits` (`unit_name`);

--
-- Index pour la table `Details`
--
ALTER TABLE `Details`
  ADD PRIMARY KEY (`orderId`,`prodId`,`size_name`),
  ADD KEY `fk_prodId.Details-FROM-Products` (`prodId`);

--
-- Index pour la table `Devices`
--
ALTER TABLE `Devices`
  ADD PRIMARY KEY (`userId`,`setDate`);

--
-- Index pour la table `DiscountCodes`
--
ALTER TABLE `DiscountCodes`
  ADD PRIMARY KEY (`discountCode`),
  ADD KEY `fk_discount_type.DiscountCodes-FROM-DiscountCodeType` (`discount_type`);

--
-- Index pour la table `DiscountCodes-Countries`
--
ALTER TABLE `DiscountCodes-Countries`
  ADD PRIMARY KEY (`discount_code`,`country_`),
  ADD KEY `fk_country_.DiscountCodes-Countries-FROM-Countries` (`country_`);

--
-- Index pour la table `DiscountCodeType`
--
ALTER TABLE `DiscountCodeType`
  ADD PRIMARY KEY (`discountType`);

--
-- Index pour la table `DiscountValues`
--
ALTER TABLE `DiscountValues`
  ADD PRIMARY KEY (`discountValue`);

--
-- Index pour la table `Languages`
--
ALTER TABLE `Languages`
  ADD PRIMARY KEY (`langIsoCode`);

--
-- Index pour la table `MeasureScales`
--
ALTER TABLE `MeasureScales`
  ADD PRIMARY KEY (`measureScale`);

--
-- Index pour la table `MeasureUnits`
--
ALTER TABLE `MeasureUnits`
  ADD PRIMARY KEY (`unitName`) USING BTREE;

--
-- Index pour la table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `fk_userId.Orders-FROM-Users` (`userId`),
  ADD KEY `fk_iso_currency.Orders-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `Orders-Addresses`
--
ALTER TABLE `Orders-Addresses`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `fk_country_.Orders-Addresses-FROM-Countries` (`country_`);

--
-- Index pour la table `Orders-Box`
--
ALTER TABLE `Orders-Box`
  ADD PRIMARY KEY (`orderId`,`boxId`),
  ADD KEY `fk_boxId.Orders-Box-FROM-Box` (`boxId`);

--
-- Index pour la table `Orders-BoxProducts`
--
ALTER TABLE `Orders-BoxProducts`
  ADD PRIMARY KEY (`boxId`,`prodId`,`size_name`),
  ADD KEY `fk_prodId.Orders-BoxProducts-FROM-Products` (`prodId`);

--
-- Index pour la table `Orders-DiscountCodes`
--
ALTER TABLE `Orders-DiscountCodes`
  ADD PRIMARY KEY (`orderId`,`discount_code`),
  ADD KEY `fk_discount_code.Orders-DiscountCodes-FROM-DiscountCodes` (`discount_code`);

--
-- Index pour la table `OrdersStatus`
--
ALTER TABLE `OrdersStatus`
  ADD PRIMARY KEY (`status`,`orderId`,`trackingNumber`) USING BTREE,
  ADD KEY `fk_orderId.OrdersStatus-FROM-Orders` (`orderId`),
  ADD KEY `fk_adminId.OrdersStatus-FROM-Administrators` (`adminId`);

--
-- Index pour la table `Pages`
--
ALTER TABLE `Pages`
  ADD PRIMARY KEY (`userId`,`setDate`),
  ADD KEY `userId-setDate-page` (`userId`,`setDate`,`page`) USING BTREE,
  ADD KEY `userId-page` (`userId`,`page`) USING BTREE;

--
-- Index pour la table `Pages-Actions`
--
ALTER TABLE `Pages-Actions`
  ADD PRIMARY KEY (`userId`,`setDate`),
  ADD KEY `fk_userId.page_.Pages-Actions-FROM-Pages` (`userId`,`page_`),
  ADD KEY `fk_action_.Pages-Actions-FROM-Actions` (`action_`);

--
-- Index pour la table `PagesParameters`
--
ALTER TABLE `PagesParameters`
  ADD PRIMARY KEY (`userId`,`setDate_`),
  ADD KEY `fk_userId.setDate_.page_.PagesParameters-FROM-Pages` (`userId`,`setDate_`,`page_`);

--
-- Index pour la table `ProductBuyPrice`
--
ALTER TABLE `ProductBuyPrice`
  ADD PRIMARY KEY (`prodId`,`buyDate`),
  ADD KEY `fk_buy_country.ProductBuyPrice-FROM-BuyCountries` (`buy_country`),
  ADD KEY `fk_iso_currency.ProductBuyPrice-FROM-Currencies` (`iso_currency`);

--
-- Index pour la table `ProductFunctions`
--
ALTER TABLE `ProductFunctions`
  ADD PRIMARY KEY (`functionName`);

--
-- Index pour la table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`prodID`),
  ADD KEY `fk_product_type.Products-FROM-ProductsTypes` (`product_type`);

--
-- Index pour la table `Products-Categories`
--
ALTER TABLE `Products-Categories`
  ADD PRIMARY KEY (`prodId`,`category_name`),
  ADD KEY `fk_category_name.Products-Categories-FROM-Categories` (`category_name`);

--
-- Index pour la table `Products-Collections`
--
ALTER TABLE `Products-Collections`
  ADD PRIMARY KEY (`prodId`,`collection_name`),
  ADD KEY `fk_collection_name.Products-Collections-FROM-Collections` (`collection_name`);

--
-- Index pour la table `Products-ProductFunctions`
--
ALTER TABLE `Products-ProductFunctions`
  ADD PRIMARY KEY (`prodId`,`function_name`),
  ADD KEY `fk_function_name.Products-ProductFunctions-FROM-ProductFunctions` (`function_name`);

--
-- Index pour la table `Products-Sizes`
--
ALTER TABLE `Products-Sizes`
  ADD PRIMARY KEY (`prodId`,`size_name`),
  ADD KEY `fk_size_name.Products-Sizes-FROM-Products` (`size_name`);

--
-- Index pour la table `ProductsDescriptions`
--
ALTER TABLE `ProductsDescriptions`
  ADD PRIMARY KEY (`prodId`,`lang_`),
  ADD KEY `FK_lang_.ProductsDescriptions-FROM-Languages` (`lang_`);

--
-- Index pour la table `ProductsDiscounts`
--
ALTER TABLE `ProductsDiscounts`
  ADD PRIMARY KEY (`prodId`,`country_`),
  ADD KEY `fk_country_.ProductsDiscounts-FROM-Countries` (`country_`),
  ADD KEY `fk_discount_value.ProductsDiscounts-FROM-DiscountValues` (`discount_value`);

--
-- Index pour la table `ProductsMeasures`
--
ALTER TABLE `ProductsMeasures`
  ADD PRIMARY KEY (`prodId`,`size_name`,`body_part`,`unit_name`) USING BTREE,
  ADD KEY `FK_body_part.ProductsMeasures-FROM-BodyPart` (`body_part`),
  ADD KEY `FK_unit_name.ProductsMeasures-FROM-MeasureUnits` (`unit_name`);

--
-- Index pour la table `ProductsPictures`
--
ALTER TABLE `ProductsPictures`
  ADD PRIMARY KEY (`prodId`,`pictureID`);

--
-- Index pour la table `ProductsPrices`
--
ALTER TABLE `ProductsPrices`
  ADD PRIMARY KEY (`prodId`,`country_`,`iso_currency`),
  ADD KEY `fk_country_.ProductsPrices-FROM-Countries` (`country_`),
  ADD KEY `fk_iso_currency.ProductsPrices-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `ProductsShippings`
--
ALTER TABLE `ProductsShippings`
  ADD PRIMARY KEY (`prodId`,`iso_currency`,`country_`) USING BTREE,
  ADD KEY `fk_country_.ProductsShipping-FROM-Countries` (`country_`),
  ADD KEY `fk_iso_currency.ProductsShipping-FROM-CurrenciesIsoCodes` (`iso_currency`);

--
-- Index pour la table `ProductsTypes`
--
ALTER TABLE `ProductsTypes`
  ADD PRIMARY KEY (`productType`);

--
-- Index pour la table `Sexes`
--
ALTER TABLE `Sexes`
  ADD PRIMARY KEY (`sexe`);

--
-- Index pour la table `Sizes`
--
ALTER TABLE `Sizes`
  ADD PRIMARY KEY (`sizeName`);

--
-- Index pour la table `Translations`
--
ALTER TABLE `Translations`
  ADD PRIMARY KEY (`translationID`);

--
-- Index pour la table `TranslationStations`
--
ALTER TABLE `TranslationStations`
  ADD PRIMARY KEY (`usedInside`,`station`,`iso_lang`) USING BTREE,
  ADD KEY `fk_iso_lang.TranslationStations-FROM-Languages` (`iso_lang`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `fk_lang_FROM-Languages` (`lang_`),
  ADD KEY `fk_sexe_FROM-Sexes` (`sexe_`);

--
-- Index pour la table `UsersMeasures`
--
ALTER TABLE `UsersMeasures`
  ADD PRIMARY KEY (`measureID`) USING BTREE,
  ADD KEY `FK_userId.UsersMeasures-FROM-Users` (`userId`),
  ADD KEY `FK_unit_name.UsersMeasures-FROM-MeasureUnits` (`unit_name`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Products`
--
ALTER TABLE `Products`
  MODIFY `prodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `Translations`
--
ALTER TABLE `Translations`
  MODIFY `translationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Addresses`
--
ALTER TABLE `Addresses`
  ADD CONSTRAINT `fk_country_.Addresses-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Addresses-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Administrators`
--
ALTER TABLE `Administrators`
  ADD CONSTRAINT `fk_lang_.Administrators-FROM-Languages` FOREIGN KEY (`lang_`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sexe_.Administrators-FROM-Sexes` FOREIGN KEY (`sexe_`) REFERENCES `Sexes` (`sexe`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Basket-DiscountCodes`
--
ALTER TABLE `Basket-DiscountCodes`
  ADD CONSTRAINT `fk_discount_code.Basket-DiscountCodes-FROM-DiscountCodes` FOREIGN KEY (`discount_code`) REFERENCES `DiscountCodes` (`discountCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Basket-DiscountCodes-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Baskets-Box`
--
ALTER TABLE `Baskets-Box`
  ADD CONSTRAINT `fk_boxId.Baskets-Box-FROM-Box` FOREIGN KEY (`boxId`) REFERENCES `Boxes` (`boxID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Baskets-Box-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Baskets-Products`
--
ALTER TABLE `Baskets-Products`
  ADD CONSTRAINT `fk_basketProdId.Baskets-Products-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_brand_name.Baskets-Products-FROM-BrandsMeasures` FOREIGN KEY (`brand_name`) REFERENCES `BrandsMeasures` (`brandName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cut_name.Baskets-Products-FROM-Cuts` FOREIGN KEY (`cut_name`) REFERENCES `Cuts` (`cutName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_measureId.Baskets-Products-FROM-UsersMeasures` FOREIGN KEY (`measureId`) REFERENCES `UsersMeasures` (`measureID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size_name.Baskets-Products-FROM-Sizes` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Baskets-Products-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Box-Products`
--
ALTER TABLE `Box-Products`
  ADD CONSTRAINT `fk_boxId.Box-Products-FROM-Baskets-Box` FOREIGN KEY (`boxId`) REFERENCES `Baskets-Box` (`boxId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_boxProdId.Box-Products-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_brand_name.Box-Products-FROM-BrandsMeasure` FOREIGN KEY (`brand_name`) REFERENCES `BrandsMeasures` (`brandName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cut_name.Box-Products-FROM-Cuts` FOREIGN KEY (`cut_name`) REFERENCES `Cuts` (`cutName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_measureId.Box-Products-FROM-UsersMeasures` FOREIGN KEY (`measureId`) REFERENCES `UsersMeasures` (`measureID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size_name.Box-Products-FROM-Sizes` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxBuyPrice`
--
ALTER TABLE `BoxBuyPrice`
  ADD CONSTRAINT `fk_box_color.BoxBuyPrice-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buy_country.BoxBuyPrice-FROM-BuyCountries` FOREIGN KEY (`buy_country`) REFERENCES `BuyCountries` (`buyCountry`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.BoxBuyPrice-FROM-Currencies` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxColors-Products`
--
ALTER TABLE `BoxColors-Products`
  ADD CONSTRAINT `fk_box_color.BoxColors-Products-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.BoxColors-Products-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxDiscounts`
--
ALTER TABLE `BoxDiscounts`
  ADD CONSTRAINT `fk_box_color.BoxDiscounts-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_country_.BoxDiscounts-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_discount_value.BoxDiscounts-FROM-DiscountValues` FOREIGN KEY (`discount_value`) REFERENCES `DiscountValues` (`discountValue`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Boxes`
--
ALTER TABLE `Boxes`
  ADD CONSTRAINT `fk_box_color.Box-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxPrices`
--
ALTER TABLE `BoxPrices`
  ADD CONSTRAINT `fk_box_color.BoxPrices-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_country_.BoxPrices-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.BoxPrices-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxProducts-Sizes`
--
ALTER TABLE `BoxProducts-Sizes`
  ADD CONSTRAINT `fk_prodId.BoxProducts-Sizes-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size_name.BoxProducts-Sizes-FROM-Sizes` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BoxShipping`
--
ALTER TABLE `BoxShipping`
  ADD CONSTRAINT `fk_box_color.BoxShipping-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_country_.BoxShipping-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.BoxShipping-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BrandsMeasures`
--
ALTER TABLE `BrandsMeasures`
  ADD CONSTRAINT `FK_body_part.BrandsMeasures-FROM-BodyParts` FOREIGN KEY (`body_part`) REFERENCES `BodyParts` (`bodyPart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_size_name.BrandsMeasures-FROM-Sizes` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unit_name.BrandsMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `BrandsPictures`
--
ALTER TABLE `BrandsPictures`
  ADD CONSTRAINT `FK_brand_name.BrandsPictures-FROM-BrandsMeasures` FOREIGN KEY (`brand_name`) REFERENCES `BrandsMeasures` (`brandName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `BuyCountries`
--
ALTER TABLE `BuyCountries`
  ADD CONSTRAINT `fk_iso_currency.BuyCountries-FROM-Currencies` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Countries`
--
ALTER TABLE `Countries`
  ADD CONSTRAINT `fk_iso_currency.Countries-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Cuts`
--
ALTER TABLE `Cuts`
  ADD CONSTRAINT `fk_unit_name.Cuts-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Details`
--
ALTER TABLE `Details`
  ADD CONSTRAINT `fk_orderId.Details-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.Details-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Devices`
--
ALTER TABLE `Devices`
  ADD CONSTRAINT `fk_userId.Devices-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `DiscountCodes`
--
ALTER TABLE `DiscountCodes`
  ADD CONSTRAINT `fk_discount_type.DiscountCodes-FROM-DiscountCodeType` FOREIGN KEY (`discount_type`) REFERENCES `DiscountCodeType` (`discountType`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DiscountCodes-Countries`
--
ALTER TABLE `DiscountCodes-Countries`
  ADD CONSTRAINT `fk_country_.DiscountCodes-Countries-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_discount_code.DiscountCodes-Countries-FROM-DiscountCodes` FOREIGN KEY (`discount_code`) REFERENCES `DiscountCodes` (`discountCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `fk_iso_currency.Orders-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `CurrenciesIsoCodes` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Orders-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-Addresses`
--
ALTER TABLE `Orders-Addresses`
  ADD CONSTRAINT `fk_country_.Orders-Addresses-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.Orders-Addresses-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-Box`
--
ALTER TABLE `Orders-Box`
  ADD CONSTRAINT `fk_boxId.Orders-Box-FROM-Box` FOREIGN KEY (`boxId`) REFERENCES `Boxes` (`boxID`),
  ADD CONSTRAINT `fk_orderId.Orders-Box-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-BoxProducts`
--
ALTER TABLE `Orders-BoxProducts`
  ADD CONSTRAINT `fk_boxId.Orders-BoxProducts-FROM-Orders-Box` FOREIGN KEY (`boxId`) REFERENCES `Orders-Box` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.Orders-BoxProducts-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-DiscountCodes`
--
ALTER TABLE `Orders-DiscountCodes`
  ADD CONSTRAINT `fk_discount_code.Orders-DiscountCodes-FROM-DiscountCodes` FOREIGN KEY (`discount_code`) REFERENCES `DiscountCodes` (`discountCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.Orders-DiscountCodes-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `OrdersStatus`
--
ALTER TABLE `OrdersStatus`
  ADD CONSTRAINT `fk_adminId.OrdersStatus-FROM-Administrators` FOREIGN KEY (`adminId`) REFERENCES `Administrators` (`adminID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.OrdersStatus-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Pages`
--
ALTER TABLE `Pages`
  ADD CONSTRAINT `fk_userId.Pages-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Pages-Actions`
--
ALTER TABLE `Pages-Actions`
  ADD CONSTRAINT `fk_action_.Pages-Actions-FROM-Actions` FOREIGN KEY (`action_`) REFERENCES `Actions` (`action`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.page_.Pages-Actions-FROM-Pages` FOREIGN KEY (`userId`,`page_`) REFERENCES `Pages` (`userId`, `page`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `PagesParameters`
--
ALTER TABLE `PagesParameters`
  ADD CONSTRAINT `fk_userId.setDate_.page_.PagesParameters-FROM-Pages` FOREIGN KEY (`userId`,`setDate_`,`page_`) REFERENCES `Pages` (`userId`, `setDate`, `page`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductBuyPrice`
--
ALTER TABLE `ProductBuyPrice`
  ADD CONSTRAINT `fk_buy_country.ProductBuyPrice-FROM-BuyCountries` FOREIGN KEY (`buy_country`) REFERENCES `BuyCountries` (`buyCountry`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.ProductBuyPrice-FROM-Currencies` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.ProductBuyPrice-Products-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `fk_product_type.Products-FROM-ProductsTypes` FOREIGN KEY (`product_type`) REFERENCES `ProductsTypes` (`productType`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Products-Categories`
--
ALTER TABLE `Products-Categories`
  ADD CONSTRAINT `fk_category_name.Products-Categories-FROM-Categories` FOREIGN KEY (`category_name`) REFERENCES `Categories` (`categoryName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.Products-Categories-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Products-Collections`
--
ALTER TABLE `Products-Collections`
  ADD CONSTRAINT `fk_collection_name.Products-Collections-FROM-Collections` FOREIGN KEY (`collection_name`) REFERENCES `Collections` (`collectionName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.Products-Collections-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Products-ProductFunctions`
--
ALTER TABLE `Products-ProductFunctions`
  ADD CONSTRAINT `fk_function_name.Products-ProductFunctions-FROM-ProductFunctions` FOREIGN KEY (`function_name`) REFERENCES `ProductFunctions` (`functionName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.Products-ProductFunctions-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Products-Sizes`
--
ALTER TABLE `Products-Sizes`
  ADD CONSTRAINT `fk_prodId.Products-Sizes-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size_name.Products-Sizes-FROM-Products` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsDescriptions`
--
ALTER TABLE `ProductsDescriptions`
  ADD CONSTRAINT `FK_lang_.ProductsDescriptions-FROM-Languages` FOREIGN KEY (`lang_`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_prodId.ProductsDescriptions-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsDiscounts`
--
ALTER TABLE `ProductsDiscounts`
  ADD CONSTRAINT `fk_country_.ProductsDiscounts-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_discount_value.ProductsDiscounts-FROM-DiscountValues` FOREIGN KEY (`discount_value`) REFERENCES `DiscountValues` (`discountValue`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.ProductsDiscounts-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsMeasures`
--
ALTER TABLE `ProductsMeasures`
  ADD CONSTRAINT `FK_body_part.ProductsMeasures-FROM-BodyPart` FOREIGN KEY (`body_part`) REFERENCES `BodyParts` (`bodyPart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_prodId_size_name.ProductsMeasures-FROM-Products-Sizes` FOREIGN KEY (`prodId`,`size_name`) REFERENCES `Products-Sizes` (`prodId`, `size_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unit_name.ProductsMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsPictures`
--
ALTER TABLE `ProductsPictures`
  ADD CONSTRAINT `fk_prodId.Products-Pictures-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsPrices`
--
ALTER TABLE `ProductsPrices`
  ADD CONSTRAINT `fk_country_.ProductsPrices-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.ProductsPrices-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.ProductsPrices-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ProductsShippings`
--
ALTER TABLE `ProductsShippings`
  ADD CONSTRAINT `fk_country_.ProductsShipping-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency.ProductsShipping-FROM-CurrenciesIsoCodes` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodId.ProductsShipping-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TranslationStations`
--
ALTER TABLE `TranslationStations`
  ADD CONSTRAINT `fk_iso_lang.TranslationStations-FROM-Languages` FOREIGN KEY (`iso_lang`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_lang_FROM-Languages` FOREIGN KEY (`lang_`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sexe_FROM-Sexes` FOREIGN KEY (`sexe_`) REFERENCES `Sexes` (`sexe`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `UsersMeasures`
--
ALTER TABLE `UsersMeasures`
  ADD CONSTRAINT `FK_unit_name.UsersMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userId.UsersMeasures-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
