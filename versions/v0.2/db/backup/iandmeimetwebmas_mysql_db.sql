-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : iandmeimetwebmas.mysql.db
-- Généré le :  Dim 13 déc. 2020 à 16:59
-- Version du serveur :  5.6.50-log
-- Version de PHP :  7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `TEST`
--
CREATE DATABASE IF NOT EXISTS `TEST` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TEST`;

-- --------------------------------------------------------

--
-- Structure de la table `Addresses`
--

CREATE TABLE `Addresses` (
  `userId` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `appartement` varchar(100) DEFAULT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Basket-DiscountCodes`
--

CREATE TABLE `Basket-DiscountCodes` (
  `userId` varchar(50) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Baskets-Box`
--

CREATE TABLE `Baskets-Box` (
  `boxId` varchar(100) NOT NULL,
  `userId` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Baskets-Products`
--

CREATE TABLE `Baskets-Products` (
  `userId` varchar(50) NOT NULL,
  `prodId` varchar(100) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('inseam'),
('waist');

-- --------------------------------------------------------

--
-- Structure de la table `Box-Products`
--

CREATE TABLE `Box-Products` (
  `boxId` varchar(100) NOT NULL,
  `prodId` varchar(100) NOT NULL,
  `sequenceID` varchar(100) NOT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `measureId` varchar(100) DEFAULT NULL,
  `cut_name` varchar(30) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `BoxArguments`
--

CREATE TABLE `BoxArguments` (
  `box_color` varchar(10) NOT NULL,
  `argID` int(11) NOT NULL,
  `argType` enum('advantage','drawback') NOT NULL,
  `argValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxArguments`
--

INSERT INTO `BoxArguments` (`box_color`, `argID`, `argType`, `argValue`) VALUES
('gold', 1, 'advantage', 'size customization for free by our tailor'),
('gold', 2, 'advantage', 'delivery in less than 5 business days'),
('gold', 3, 'advantage', 'return 100% free'),
('gold', 4, 'advantage', 'access to the entire item catalog'),
('gold', 5, 'advantage', 'free shipping'),
('regular', 1, 'advantage', 'size customization for free by our tailor'),
('regular', 2, 'advantage', 'delivery in less than 5 business days'),
('regular', 3, 'advantage', 'return 100% free'),
('regular', 4, 'advantage', 'access to the entire item catalog'),
('regular', 5, 'drawback', 'free shipping'),
('silver', 1, 'advantage', 'size customization for free by our tailor'),
('silver', 2, 'advantage', 'delivery in less than 5 business days'),
('silver', 3, 'advantage', 'return 100% free'),
('silver', 4, 'advantage', 'access to the entire item catalog'),
('silver', 5, 'advantage', 'free shipping');

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
('gold', 10, 0.125, 'rgba(255, 211, 0, 0.7)', 'rgba(255, 211, 0)', '#ffffff', 'box-gold-128.png', 374),
('regular', 4, 0.05, '#ffffff', 'rgba(14, 36, 57, 0.8)', 'rgba(14, 36, 57, 0.5)', 'box-regular-128.png', 32),
('silver', 6, 0.075, 'rgba(229, 229, 231, 0.5)', '#C6C6C7', 'rgba(14, 36, 57, 0.5)', 'box-silver-128.png', 54);

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

-- --------------------------------------------------------

--
-- Structure de la table `Boxes`
--

CREATE TABLE `Boxes` (
  `boxID` varchar(100) NOT NULL,
  `box_color` varchar(10) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `BoxProducts-Sizes`
--

CREATE TABLE `BoxProducts-Sizes` (
  `prodId` varchar(100) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `BoxShipping`
--

CREATE TABLE `BoxShipping` (
  `box_color` varchar(10) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `shipPrice` double NOT NULL,
  `minTime` int(11) NOT NULL,
  `maxTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `BrandsPictures`
--

CREATE TABLE `BrandsPictures` (
  `brand_name` varchar(100) NOT NULL,
  `pictureID` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `categoryName` varchar(100) NOT NULL,
  `googleCatNum` int(30) NOT NULL,
  `googleCat` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Categories`
--

INSERT INTO `Categories` (`categoryName`, `googleCatNum`, `googleCat`) VALUES
('bathrobe', 2563, 'Apparel & Accessories > Clothing > Underwear & Socks > Lingerie Accessories'),
('bikini', 211, 'Apparel & Accessories > Clothing > Swimwear'),
('blazer', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets'),
('bra', 214, 'Apparel & Accessories > Clothing > Underwear & Socks > Bras'),
('cardigan', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('cargo pants', 204, 'Apparel & Accessories > Clothing > Pants'),
('coat', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets'),
('dress', 2271, 'Apparel & Accessories > Clothing > Dresses'),
('hawaiian shirt', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('hoodie', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('jacket', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets'),
('jeans', 204, 'Apparel & Accessories > Clothing > Pants'),
('jumper', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('jumpsuits', 5250, 'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers'),
('long coat', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets'),
('long-sleeve top', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('overalls', 7132, 'Apparel & Accessories > Clothing > One-Pieces > Overalls'),
('pant suits', 5183, 'Apparel & Accessories > Clothing > Suits > Pant Suits'),
('polo shirt', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('pullover', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('sheath dress', 2271, 'Apparel & Accessories > Clothing > Dresses'),
('shirt', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('shorts', 207, 'Apparel & Accessories > Clothing > Shorts'),
('singlet', 2745, 'Apparel & Accessories > Clothing > Underwear & Socks > Undershirts'),
('skirt', 1581, 'Apparel & Accessories > Clothing > Skirts'),
('skirt suits', 1516, 'Apparel & Accessories > Clothing > Suits > Skirt Suits'),
('skorts', 5344, 'Apparel & Accessories > Clothing > Skorts'),
('sleeveless shirt', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('slip', 2562, 'Apparel & Accessories > Clothing > Underwear & Socks > Underwear'),
('smokings', 1580, 'Apparel & Accessories > Clothing > Suits > Tuxedos'),
('socks', 209, 'Apparel & Accessories > Clothing > Underwear & Socks > Socks'),
('stockings', 2563, 'Apparel & Accessories > Clothing > Underwear & Socks > Lingerie Accessories'),
('suit', 1594, 'Apparel & Accessories > Clothing > Suits'),
('sweater', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('swimsuit', 211, 'Apparel & Accessories > Clothing > Swimwear'),
('t-shirt', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('tank top', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('top', 212, 'Apparel & Accessories > Clothing > Shirts & Tops'),
('trench coat', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets'),
('trousers', 204, 'Apparel & Accessories > Clothing > Pants'),
('underpants', 5834, 'Apparel & Accessories > Clothing > Underwear & Socks > Underwear Slips'),
('uniform', 2306, 'Apparel & Accessories > Clothing > Uniforms'),
('vest', 1831, 'Apparel & Accessories > Clothing > Outerwear > Vests'),
('winter coat', 5598, 'Apparel & Accessories > Clothing > Outerwear > Coats & Jackets');

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
('drop1'),
('women');

-- --------------------------------------------------------

--
-- Structure de la table `Companies`
--

CREATE TABLE `Companies` (
  `company` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Companies`
--

INSERT INTO `Companies` (`company`) VALUES
('stripe');

-- --------------------------------------------------------

--
-- Structure de la table `Constants`
--

CREATE TABLE `Constants` (
  `constName` varchar(50) NOT NULL,
  `stringValue` varchar(50) DEFAULT NULL,
  `jsonValue` text,
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
('DB_TYPES_LENGTH', NULL, '{\"date\": 15, \"enum\": -1, \"json\": 16776192, \"text\": 2147483647, \"double\": 11, \"tinyint\": 5, \"datetime\": 25}', '2020-07-12 00:00:00', 'Holds the length of the database type. that the length can\'t be extracted with the table description. '),
('DEFAULT_COUNTRY_NAME', 'other', NULL, '2020-03-29 00:00:00', 'The default country of a user if his localisation is not supported by the System.'),
('DEFAULT_ISO_CURRENCY', 'usd', NULL, '2020-05-02 00:00:00', 'The default currency iso code 2 of a user if his localcurrency is not supported by the System.'),
('DEFAULT_LANGUAGE', 'eur', NULL, '2020-02-28 00:00:00', 'Default language given to the visitor if his driver language is not supported by the web site.'),
('GRID_USED_INSIDE', 'grid.php', NULL, '2020-03-30 00:00:00', 'Indicate the value of the attribut \"inside\" in TranslationStation table. Used to get the translation to the \"inside\" indicated.\r\nIts the file name of the method name where the translation is used.'),
('INFOS_COMPANY', NULL, '{\"brand\": \"i&meim\", \"media\": {\"faceboock\": {\"link\": \"https://www.facebook.com/iandmeimofficial/\", \"logo\": \"facebook2x.png\"}, \"instagram\": {\"link\": \"https://www.instagram.com/iandmeim/\", \"logo\": \"instagram2x.png\"}}, \"address\": {\"city\": \"sint-genesius-rode\", \"door\": null, \"phone\": \"32\", \"state\": \"flemish brabant\", \"street\": null, \"country\": \"belgium\", \"zipcode\": \"1640\"}}', '2020-10-18 20:35:28', 'Holds all datas about the company.'),
('MAX_MEASURE', '4', NULL, '2020-04-23 00:00:00', 'Indicate how much measure can be holded by a user.'),
('MAX_PRODUCT_CUBE_DISPLAYABLE', '3', NULL, '2020-04-02 00:00:00', 'The maximum of product\'s cubes displayable before to display the plus symbol including the plus symbole in the count of cube to display.\r\nex: MAX_PRODUCT_CUBE_DISPLAYABLE = 4\r\nwill display: 3 color cube + 1 symbole cube = 4 cubes\r\n\r\nThis number of cube must avoid to display cubes in multiple ligne and disturbe the grid arrangement.\r\nNOTE: the number of cube displayed exactly MAX_PRODUCT_CUBE_DISPLAYABLE cause this constante include already the plus symbole'),
('NB_DAYS_BEFORE', '15', NULL, '2020-02-21 21:28:28', 'The number of days to go back in navigation history.'),
('ORDER_DEFAULT_STATUS', 'US68', NULL, '2020-02-26 21:37:00', 'The default value given to a new order\'s status.'),
('ORDER_STATUS_STOCK_ERROR', 'ER30', NULL, '2020-10-11 12:30:54', 'Holds the status of an order when the order has an product out of stock.'),
('PRICE_MESSAGE', 'free with meimbox', NULL, '2020-04-01 00:00:00', 'message to display instead of boxproduct\'s price because a boxProduct hasn\'t any price'),
('STRIPE_MAX_PROD_IMG', '8', NULL, '2020-10-07 13:15:57', 'Holds max images allowed in Stripe product'),
('SUPPORTED_SIZES', NULL, '{\"alpha\": [\"4xl\", \"3xl\", \"xxl\", \"xl\", \"l\", \"m\", \"s\", \"xs\", \"xxs\"], \"numeric\": [56, 55, 54, 53, 52, 51, 50, 49, 48, 47, 46, 45, 44, 43, 42, 41, 40, 39, 38, 37, 36, 35, 34, 33, 32]}', '2020-07-18 21:17:12', 'List of system\'s supported sizes.'),
('SUPPORTED_UNIT', NULL, '[\"centimeter\", \"inch\"]', '2020-04-24 00:00:00', 'List of measure unit available for user\'s input'),
('SYSTEM_ID', '1', NULL, '2020-02-26 21:27:40', 'The ID of the system used as author to update order status.'),
('WHITE_RGB', '#ffffff', NULL, '2020-04-09 00:00:00', 'The white color\'s rbg code.');

-- --------------------------------------------------------

--
-- Structure de la table `Cookies`
--

CREATE TABLE `Cookies` (
  `cookieID` varchar(50) NOT NULL,
  `cookiePeriod` int(11) NOT NULL,
  `cookieDomain` varchar(50) DEFAULT NULL,
  `cookiePath` varchar(50) DEFAULT NULL,
  `cookieSecure` tinyint(1) NOT NULL,
  `cookieHttponly` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Cookies`
--

INSERT INTO `Cookies` (`cookieID`, `cookiePeriod`, `cookieDomain`, `cookiePath`, `cookieSecure`, `cookieHttponly`) VALUES
('ADM', 10800, NULL, NULL, 1, 1),
('ADRS', 86400, NULL, NULL, 1, 1),
('CHKT_LNCHD', 86400, NULL, 'checkout', 1, 1),
('CLT', 31536000, NULL, NULL, 1, 1),
('LCK', 120, NULL, NULL, 1, 1),
('VIS', 94608000, NULL, NULL, 1, 1);

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
('belgium', 'be', 'eur', 1, 0.21),
('france', 'fr', 'eur', 1, 0.2),
('other', 'o', 'eur', 0, 0);

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
('eur', 'euro', '€', 1, 0);

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
('fit', 10, 'centimeter'),
('wide', 20, 'centimeter');

-- --------------------------------------------------------

--
-- Structure de la table `Details`
--

CREATE TABLE `Details` (
  `orderId` varchar(100) NOT NULL,
  `prodId` varchar(100) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `weight` double NOT NULL,
  `buy_price` double NOT NULL,
  `sellPrice` double NOT NULL,
  `discount_value` double NOT NULL,
  `shipping` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `stillStock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Devices`
--

CREATE TABLE `Devices` (
  `navId` varchar(50) NOT NULL,
  `deviceDate` datetime NOT NULL,
  `deviceDatas` text NOT NULL,
  `userAgent` varchar(250) NOT NULL,
  `isBot` tinyint(1) NOT NULL,
  `botInfo` text,
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
  `rate` float NOT NULL,
  `maxAmount` float DEFAULT NULL,
  `minAmount` float NOT NULL,
  `nbUse` int(11) DEFAULT NULL,
  `isCumulable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DiscountCodes`
--

INSERT INTO `DiscountCodes` (`discountCode`, `discount_type`, `rate`, `maxAmount`, `minAmount`, `nbUse`, `isCumulable`) VALUES
('free_shipping_be', 'on_shipping', 1, NULL, 30, NULL, 1),
('free_shipping_fr', 'on_shipping', 1, NULL, 30, NULL, 1),
('free_shipping_o', 'on_shipping', 0, NULL, 0, -1, 0);

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
('on_shipping'),
('on_sum_prods');

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
-- Structure de la table `EmailsSent`
--

CREATE TABLE `EmailsSent` (
  `messageID` varchar(100) NOT NULL,
  `recipient` varchar(100) NOT NULL,
  `recipientName` varchar(50) DEFAULT NULL,
  `mailer_` varchar(30) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `toField` tinyint(1) NOT NULL,
  `ccField` tinyint(1) NOT NULL,
  `bccField` tinyint(1) NOT NULL,
  `replyTo` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `sendDate` datetime NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `message` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `EmailsSent`
--

INSERT INTO `EmailsSent` (`messageID`, `recipient`, `recipientName`, `mailer_`, `subject`, `sender`, `toField`, `ccField`, `bccField`, `replyTo`, `content`, `sendDate`, `code`, `message`) VALUES
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'israelmeiresonne97@gmail.com', 'Israel Meiresonne', 'BlueAPI', 'Confirmation de votre commande', 'support@iandmeim.com', 1, 0, 0, 'support@iandmeim.com', '<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html style=\"--color-shadow: #E5E5E7; --color-shadow-08: rgba(229, 229, 231, .8); --color-shadow-05: rgba(229, 229, 231, .5); --color-text: #0E2439; --color-text-08: rgba(14, 36, 57, 0.8); --color-text-06: rgba(14, 36, 57, 0.6); --color-text-05: rgba(14, 36, 57, 0.5); --color-link-05: rgba(11, 71, 91, .5); --color-label: #C6C6C7; --color-white: #ffffff; --color-white-075: rgba(255, 255, 255, .75); --color-red: #AF3134; --color-green: #23CBA7; --color-green-clear: #6AE3C9; --color-green-02: rgba(35, 203, 167, 0.2); --color-orange-clear: #FFD476; --color-yellow: #FFD300; --color-yellow-07: rgba(255, 211, 0, 0.7); --color-blue: #4DA3F5; --color-blue-wave: #458ED3; --color-blue-smooth: #AFD5F8; --color-blue-05: rgba(175, 213, 248, .5); --color-pink: #F0C7CB; --main-font-family: \'Spartan\', Verdana, Geneva, sans-serif; --italic-font-family: \'PT Serif\', \'Times New Roman\', Times, serif; --box-font-family: \'Open Sans\', sans-serif; --font-size-2_5em: 2.5em; --big-font-size: 2em; --font-size-1_7em: 1.7em; --font-size-1_6em: 1.6em; --font-size-1_4em: 1.4em; --middle-font-size: 1.2em; --little-font-size: .8em; --micro-font-size: .6em; --transition-time: .450s; --transition-time-picture: .5s; --box-shadow: 12px 12px 20px #E5E5E7; --box-shadow-right: 12px 0px 20px #E5E5E7; --box-shadow-centred: 0px 12px 20px #E5E5E7; --selected-shadow-color: rgba(35, 203, 167, 0.2); --selected-shadow-opacity: 10px; --selected-shadow: 2px 2px 10px rgba(35, 203, 167, 0.2), -2px 2px 10px rgba(35, 203, 167, 0.2), -2px -2px 10px rgba(35, 203, 167, 0.2), 2px -2px 10px rgba(35, 203, 167, 0.2); --border-float: #E5E5E7 1px solid; --border-float-radius: 5px; --border-radius-10: 10px; --big-border-radius-15: 15px; --big-border-radius: 20px; --border-radius-selcted-element: 10px; --z-index-alert_31: 31; --z-index-popup_21: 21; --z-index-header_11: 11; --z-index-body_4: 4; --z-index-body_3: 3; --z-index-body_2: 2; --z-index-body_1: 1; --z-index-body_0: 0; --body-top-computer: 120px; --header-mobile-height: 70px; --body-initial-top-computer: -120px; --body-initial-top-mobile: -70px; --cartelement-margin-bottom: 15px; --boxproduct-margin-bottom: 5px;\">\n<head></head>\n<body style=\"background: #4f4fef; color: #ffffff; font-family: \'Spartan\', Verdana, Geneva, sans-serif;\">\n    <style>\n        @font-face {\n  font-family: \'Spartan\';\n  font-style: normal;\n  font-weight: 400;\n  font-display: swap;\n  src: url(https://fonts.gstatic.com/s/spartan/v2/l7gAbjR61M69yt8Z8w6FZf9WoBxdBrGFuV6JABE.ttf) format(\'truetype\');\n}\n    </style>\n<table class=\"main_content\" style=\"width: 100%; max-width: 780px; margin: auto;\">\n<tr class=\"main_content-head main_content-child\">\n<td>\n                <table class=\"head_content\" style=\"width: 100%;\">\n<tr>\n<td class=\"head_content-brand\" style=\"width: 100%; text-align: center; text-transform: capitalize; letter-spacing: 5px;\">\n                            <h1><a href=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/\" class=\"remove-a-default-att\" target=\"_blank\" style=\"text-decoration: none; color: #ffffff;\">I&amp;MEIM</a></h1>\n                        </td>\n                    </tr>\n<tr>\n<td class=\"\">\n                            <table class=\"head_content-picture\" style=\"width: 100%;\"><tr>\n<td class=\"nada_20\" style=\"width: 20%;\"></td>\n                                    <td class=\"head_content-picture-td\">\n                                        <img src=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/content/brain/email/Mama_Bakery.png\" alt=\"order in preparation\" style=\"width: 100%;\">\n</td>\n                                    <td class=\"nada_20\" style=\"width: 20%;\"></td>\n                                </tr></table>\n</td>\n                    </tr>\n<tr>\n<td>\n                            <table class=\"head_content-paragraph\" style=\"width: 100%; text-align: center;\">\n<tr>\n<td>\n                                        <h1>\n                                            <span class=\"sentence\" style=\"text-transform: capitalize;\">bonjour israel,</span>\n                                            <br><span>Votre commande est en préparation </span>\n                                        </h1>\n                                    </td>\n                                </tr>\n<tr>\n<td>\n                                        <h3 class=\"inter_line_low no_margin unbold_field\" style=\"line-height: 1.5; font-weight: inherit; margin: 0;\">\n                                            <span>Merci de votre confiance</span>.\n                                            <span>Votre commande est actuellement en préparation. </span>\n                                            <br><span>Vous recevrez un nouveau message aussi tôt que nous aurons  expédié votre commande. </span>\n                                            <br><span>Vous pouvez à tout moment suivre l\'évolution de votre commande <a href=\"\" target=\"_blank\" style=\"color: #FFD300;\">ici</a>.</span>\n                                        </h3>\n                                    </td>\n                                </tr>\n</table>\n</td>\n                    </tr>\n</table>\n</td>\n        </tr>\n<tr>\n<td>\n                <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n            </td>\n        </tr>\n<tr>\n<td>\n                <table class=\"main_content_secondary\" style=\"width: 100%; background-color: #3939ad; border-radius: 20px 20px 0 0;\">\n<tr class=\"main_content-body main_content-child\">\n<td>\n                            <table class=\"body_content\" style=\"width: 100%; padding: 10px; background-color: #ffffff; border-radius: 20px;\">\n<tr>\n<td>\n                                        <table class=\"body_content-info body_content-child\" style=\"width: 100%; color: #0E2439;\"><tr>\n<td class=\"body_content-info-address body_content-info-td\" style=\"vertical-align: top; width: 55%;\">\n                                                    <h2 class=\"sentence\" style=\"text-transform: capitalize;\">israel meiresonne</h2>\n                                                    <p class=\"secondary_field_dark sentence\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">\n                                                        place royale 4 (villa)<br>                                                        1640<br>                                                         sint-genesius-rode<br>                                                        miami<br>                                                        belgium                                                    </p>\n                                                </td>\n                                                <td class=\"body_content-info-td\" style=\"vertical-align: top;\">\n                                                    <table class=\"body_content-info-delivery\" style=\"width: 100%; color: #0E2439;\">\n<tr>\n<td>\n                                                                <h2 class=\"delivery_label unbold_field\" style=\"font-weight: inherit;\">\n                                                                    <span class=\"sentence\" style=\"text-transform: capitalize;\">livraison:</span>\n                                                                </h2>\n                                                            </td>\n                                                        </tr>\n<tr>\n<td>\n                                                                <h4 class=\"delivery_date unbold_field secondary_field_dark no_margin\" style=\"color: rgba(14, 36, 57, 0.6); font-weight: inherit; margin: 0;\">\n                                                                    17—20 décembre                                                                </h4>\n                                                            </td>\n                                                        </tr>\n</table>\n</td>\n                                            </tr></table>\n</td>\n                                </tr>\n<tr>\n<td>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-barre\" style=\"border-bottom: #E5E5E7 1px solid;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                    </td>\n                                </tr>\n<tr>\n<td>\n                                        <table class=\"body_content-body body_content-child\" style=\"width: 100%; color: #0E2439;\">\n<tr>\n<td class=\"body_content-body-number body_content-body-td\" style=\"vertical-align: top;\">\n                                                    <table class=\"table_default\" style=\"width: auto; color: #0E2439;\"><tr>\n<td>\n                                                                <p class=\"secondary_field_dark\" style=\"color: rgba(14, 36, 57, 0.6); margin-bottom: 0;\">Nombre d\'article:</p>\n                                                            </td>\n                                                            <td>\n                                                                <span>1</span>\n                                                            </td>\n                                                        </tr></table>\n</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr>\n<td class=\"body_content-body-picture body_content-body-td\" style=\"width: 15%; vertical-align: top;\">\n                    <img src=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/content/brain/permanent/box-silver-128.png\" alt=\"name of the product\" style=\"width: 100%; border-radius: 5px;\">\n</td>\n    <td class=\"body_content-body-td\" style=\"vertical-align: top;\">\n        <table class=\"body_content-body-property\" style=\"width: 100%; color: #0E2439;\">\n<tr>\n<td>\n                    <h4 class=\"property-title sentence no_margin\" style=\"text-transform: capitalize; margin: 0; font-weight: inherit;\">silver</h4>\n                </td>\n            </tr>\n<tr>\n<td>\n                    <table class=\"table_default\" style=\"width: auto; color: #0E2439;\"><tr>\n<td>\n                                            <span class=\"secondary_field_dark\" style=\"color: rgba(14, 36, 57, 0.6);\">articles:</span>\n                                        </td>\n                                        <td>\n                                            <span>1/6</span>\n                                        </td>\n                                    </tr></table>\n</td>\n            </tr>\n</table>\n</td>\n    <td class=\"body_content-body-price body_content-body-td\" style=\"vertical-align: top;\">\n        <span class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 67,24</span>\n    </td>\n</tr>\n<tr>\n<td class=\"body_content-body-picture body_content-body-td\" style=\"width: 15%; vertical-align: top;\">\n                    <a href=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/item/1/boxproduct-green-autumn-women-accessories-clothes-jackets-trousers-vests\" target=\"_blank\">\n                <img src=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/content/brain/prod/picture01.jpeg\" alt=\"name of the product\" style=\"width: 100%; border-radius: 5px;\"></a>\n            </td>\n    <td class=\"body_content-body-td\" style=\"vertical-align: top;\">\n        <table class=\"body_content-body-property\" style=\"width: 100%; color: #0E2439;\">\n<tr>\n<td>\n                    <h4 class=\"property-title sentence no_margin\" style=\"text-transform: capitalize; margin: 0; font-weight: inherit;\">boxproduct1</h4>\n                </td>\n            </tr>\n<tr>\n<td>\n                    <table class=\"table_default\" style=\"width: auto; color: #0E2439;\">\n<tr>\n<td>\n                                            <span class=\"secondary_field_dark\" style=\"color: rgba(14, 36, 57, 0.6);\">couleur:</span>\n                                        </td>\n                                        <td>\n                                            <span>green</span>\n                                        </td>\n                                    </tr>\n<tr>\n<td>\n                                            <span class=\"secondary_field_dark\" style=\"color: rgba(14, 36, 57, 0.6);\">taille:</span>\n                                        </td>\n                                        <td>\n                                            <span>xxs</span>\n                                        </td>\n                                    </tr>\n<tr>\n<td>\n                                            <span class=\"secondary_field_dark\" style=\"color: rgba(14, 36, 57, 0.6);\">quantité:</span>\n                                        </td>\n                                        <td>\n                                            <span>1</span>\n                                        </td>\n                                    </tr>\n</table>\n</td>\n            </tr>\n</table>\n</td>\n    <td class=\"body_content-body-price body_content-body-td\" style=\"vertical-align: top;\">\n        <span class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 0</span>\n    </td>\n</tr>\n<tr>\n<td>\n                                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    </td>\n                                                </tr>\n</table>\n</td>\n                                </tr>\n<tr>\n<td>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-barre\" style=\"border-bottom: #E5E5E7 1px solid;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                    </td>\n                                </tr>\n<tr>\n<td>\n                                        <table class=\"body_content-summary body_content-child\" style=\"width: 100%; color: #0E2439;\">\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence secondary_field_dark\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">total articles</td>\n                                                <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                <td class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 67,24</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence secondary_field_dark\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">sous-total</td>\n                                                <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                <td class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 67,24</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence secondary_field_dark\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">TVA(10%)</td>\n                                                <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                <td class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 6,11</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence secondary_field_dark\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">expédition</td>\n                                                <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                <td class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ 4,79</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence secondary_field_dark\" style=\"text-transform: capitalize; color: rgba(14, 36, 57, 0.6);\">remise expédition</td>\n                                                    <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                    <td class=\"secondary_field_dark price_field\" style=\"color: rgba(14, 36, 57, 0.6); min-width: 150px;\">A$ -4,79</td>\n                                                </tr>\n<tr>\n<td>\n                                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    </td>\n                                                </tr>\n<tr class=\"body_content-summary-price\">\n<td class=\"sentence\" style=\"text-transform: capitalize;\">total</td>\n                                                <td class=\"nada_60\" style=\"width: 60%;\"></td>\n                                                <td class=\"price_field\" style=\"min-width: 150px;\">A$ 67,24</td>\n                                            </tr>\n</table>\n</td>\n                                </tr>\n<tr>\n<td>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-barre\" style=\"border-bottom: #E5E5E7 1px solid;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                    </td>\n                                </tr>\n<td>\n                                    <table class=\"body_content-footer\" style=\"width: 100%; color: #0E2439;\"><tr class=\"body_content-info-button\">\n<td class=\"nada_33\" style=\"width: 33%;\"></td>\n                                            <td>\n                                                <div>\n                                                    <a href=\"\" target=\"_blank\">\n                                                        <button class=\"green-button-reverse standard-button\" style=\"font-size: inherit; max-width: 300px; min-width: 250px; color: #ffffff; background-color: #23CBA7; border: #23CBA7 1px; width: 100%; height: 33px; border-radius: 5px; text-transform: capitalize; box-shadow: 12px 12px 20px #E5E5E7; transition: .450s; -moz-transition: .450s; cursor: pointer;\">voir ma commande</button>\n                                                    </a>\n                                                </div>\n                                            </td>\n                                            <td class=\"nada_33\" style=\"width: 33%;\"></td>\n                                        </tr></table>\n</td>\n                            </table>\n</td>\n                    </tr>\n<tr class=\"main_content-footer main_content-child\">\n<td>\n                            <table class=\"footer_content\" style=\"width: 100%; padding: 0 10px;\">\n<tr>\n<td>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                    </td>\n                                </tr>\n<tr>\n<td>\n                                        <table class=\"footer_content-thanks\" style=\"width: 100%; text-align: center;\"><tr>\n<td>\n                                                                                                        <span class=\"sentence\" style=\"text-transform: capitalize;\">merci❤️,</span>\n                                                    <br><span class=\"sentence\" style=\"text-transform: capitalize;\">l\'équipe I&amp;MEIM</span>\n                                                </td>\n                                            </tr></table>\n</td>\n                                </tr>\n<tr>\n<td>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-barre\" style=\"border-bottom: #E5E5E7 1px solid;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                        <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                    </td>\n                                </tr>\n<tr>\n<td>\n                                        <table class=\"footer_content-contact\" style=\"width: 100%;\">\n<tr>\n<td class=\"footer_content-contact-td\" style=\"vertical-align: top; width: 50%;\">\n                                                    <table class=\"footer_content-contact-support\" style=\"width: 100%;\">\n<tr class=\"footer_content-contact-support-title\">\n<td>\n                                                                <h3 class=\"sentence\" style=\"text-transform: capitalize;\">nous contacter</h3>\n                                                            </td>\n                                                        </tr>\n<tr class=\"support_address mini_text\" style=\"font-size: .8em;\">\n<td>\n                                                                <address class=\"secondary_field_clear sentence\" style=\"text-transform: capitalize; color: #C6C6C7;\">\n                                                                    i&amp;meim, 1640 sint-genesius-rode, flemish brabant belgium                                                                </address>\n                                                            </td>\n                                                        </tr>\n<tr class=\"support_unsuscribe\">\n<td>\n                                                                <table class=\"table_default mini_text\" style=\"font-size: .8em; width: auto;\"><tr>\n<td>\n                                                                            <span class=\"secondary_field_clear\" style=\"color: #C6C6C7;\">\n                                                                                <span>Tu as changé d\'avis?:</span>\n                                                                        </span>\n</td>\n                                                                        <td>\n                                                                            <a href=\"\" target=\"_blank\" style=\"color: #ffffff;\">se désabonner</a>\n                                                                        </td>\n                                                                    </tr></table>\n</td>\n                                                        </tr>\n</table>\n</td>\n                                            </tr>\n<tr>\n<td>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    <div class=\"table_separator-td-barre\" style=\"border-bottom: #E5E5E7 1px solid;\"></div>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                    <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                </td>\n                                            </tr>\n<tr>\n<td class=\"footer_content-contact-td\" style=\"vertical-align: top; width: 50%;\">\n                                                    <table class=\"footer_content-contact-media\" style=\"width: 100%;\">\n<tr class=\"footer_content-contact-media-title\">\n<td>\n                                                                <h3 class=\"sentence\" style=\"text-transform: capitalize;\">nos réseaux</h3>\n                                                            </td>\n                                                        </tr>\n<tr class=\"footer_content-contact-media-message mini_text\" style=\"font-size: .8em;\">\n<td>\n                                                                <p class=\"secondary_field_clear inter_line_low\" style=\"line-height: 1.5; color: #C6C6C7;\">\n                                                                    Reste informé sur nos dernières actions et nos événements ou partage juste ton expérience avec nous en nous suivant sur ton réseaux favoris.                                                                </p>\n                                                            </td>\n                                                        </tr>\n<tr>\n<td>\n                                                                <div class=\"table_separator-td-space\" style=\"padding: 5px;\"></div>\n                                                            </td>\n                                                        </tr>\n<tr>\n<td>\n                                                                <table class=\"footer_content-contact-media-logo\" style=\"width: 100%;\"><tr>\n<td>\n                                                                                <a href=\"https://www.facebook.com/iandmeimofficial/\" target=\"_blank\">\n                                                                                    <img src=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/content/brain/email/facebook2x.png\" alt=\"faceboock\" style=\"width: 32px;\"></a>\n                                                                            </td>\n                                                                                                                                                    <td>\n                                                                                <a href=\"https://www.instagram.com/iandmeim/\" target=\"_blank\">\n                                                                                    <img src=\"https://8e04791aa81c.eu.ngrok.io/versions/v0.2/mmbx/content/brain/email/instagram2x.png\" alt=\"instagram\" style=\"width: 32px;\"></a>\n                                                                            </td>\n                                                                                                                                            </tr></table>\n</td>\n                                                        </tr>\n</table>\n</td>\n                                            </tr>\n</table>\n</td>\n                                </tr>\n</table>\n</td>\n                    </tr>\n</table>\n</td>\n        </tr>\n</table>\n</body>\n<script>\n\n</script>\n</html>', '2020-12-10 14:03:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `EmailsStatus`
--

CREATE TABLE `EmailsStatus` (
  `messageId` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `sendingIP` varchar(50) DEFAULT NULL,
  `sendDate` datetime NOT NULL,
  `eventDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `EmailsStatus`
--

INSERT INTO `EmailsStatus` (`messageId`, `status`, `reason`, `url`, `sendingIP`, `sendDate`, `eventDate`) VALUES
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'click', NULL, 'https://www.facebook.com/iandmeimofficial/', '185.41.28.5', '1970-01-01 01:00:00', '2020-12-10 14:06:26'),
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'delivered', NULL, NULL, '185.41.28.5', '1970-01-01 01:00:00', '2020-12-10 14:03:52'),
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'request', NULL, NULL, '185.41.28.5', '1970-01-01 01:00:00', '2020-12-10 14:03:51'),
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'unique_opened', NULL, NULL, '185.41.28.5', '1970-01-01 01:00:00', '2020-12-10 14:05:54');

-- --------------------------------------------------------

--
-- Structure de la table `EmailsTags`
--

CREATE TABLE `EmailsTags` (
  `messageId` varchar(100) NOT NULL,
  `tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `EmailsTags`
--

INSERT INTO `EmailsTags` (`messageId`, `tag`) VALUES
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'confirmation'),
('<202012101403.65106340620@smtp-relay.mailin.fr>', 'order');

-- --------------------------------------------------------

--
-- Structure de la table `Events`
--

CREATE TABLE `Events` (
  `eventCode` varchar(50) NOT NULL,
  `event` varchar(30) NOT NULL,
  `element` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `result` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Events`
--

INSERT INTO `Events` (`eventCode`, `event`, `element`, `name`, `result`) VALUES
('01', 'click', 'button', 'opener of asshole', 'open ass hole'),
('evt_cd_0', 'scroll', 'scroller', 'current page', 'scroll the page'),
('evt_cd_1', 'laod', 'page', 'device size', 'get width and height of device'),
('evt_cd_10', 'launch', 'alert', 'alert pop', 'display alert message'),
('evt_cd_100', 'click', 'button', 'opener for measure editor from product adder form', 'open measure editor popup'),
('evt_cd_101', 'click', 'button', 'new measure adder in measure manager popup', 'open measure editor popup'),
('evt_cd_102', 'click', 'button', 'submit focussed measure block', 'request to select a measure'),
('evt_cd_103', 'response', 'json', 'request to select a measure', 'select measure'),
('evt_cd_104', 'click', 'button', 'closer of measure manager popup', 'close measure manager popup'),
('evt_cd_105', 'click', 'checkbox', 'from measure editor', 'check or uncheck'),
('evt_cd_106', 'blur', 'input', 'from measure editor', 'finished typing'),
('evt_cd_107', 'submit', 'form', 'submit measure editor popup', 'request to add a new measure'),
('evt_cd_108', 'response', 'json', 'request to add a new measure', 'add a new measure'),
('evt_cd_109', 'submit', 'form', 'submit measure editor popup', 'request to update a measure'),
('evt_cd_11', 'click', 'collapse', 'product description', 'open collapse'),
('evt_cd_110', 'response', 'json', 'request to update a measure', 'update a measure'),
('evt_cd_111', 'click', 'button', 'closer of measure editor popup', 'close measure editor popup'),
('evt_cd_112', 'click', 'button', 'closer of size editor popup', 'close size editor popup'),
('evt_cd_113', 'click', 'button', 'mobile filter from product grid', 'open mobile filter'),
('evt_cd_114', 'click', 'button', 'mobile filter from product grid', 'close mobile filter'),
('evt_cd_115', 'click', 'dropdown', 'order filter from product grid', 'open'),
('evt_cd_116', 'click', 'dropdown', 'order filter from product grid', 'close'),
('evt_cd_117', 'click', 'dropdown', 'product type filter from product grid', 'open'),
('evt_cd_118', 'click', 'dropdown', 'product type filter from product grid', 'close'),
('evt_cd_119', 'click', 'dropdown', 'category filter from product grid', 'open'),
('evt_cd_12', 'click', 'collapse', 'product description', 'close collapse'),
('evt_cd_120', 'click', 'dropdown', 'category filter from product grid', 'close'),
('evt_cd_121', 'click', 'dropdown', 'size filter from product grid', 'open'),
('evt_cd_122', 'click', 'dropdown', 'size filter from product grid', 'close'),
('evt_cd_123', 'click', 'dropdown', 'color filter from product grid', 'open'),
('evt_cd_124', 'click', 'dropdown', 'color filter from product grid', 'close'),
('evt_cd_125', 'click', 'checkbox', 'from filter of product grid', 'check or uncheck'),
('evt_cd_13', 'click', 'collapse', 'shipping infos', 'open collapse'),
('evt_cd_14', 'click', 'collapse', 'shipping infos', 'close collapse'),
('evt_cd_15', 'click', 'button', 'carrousel', 'slide right'),
('evt_cd_16', 'click', 'button', 'carrousel', 'slide left'),
('evt_cd_17', 'click', 'dropdown', 'order summary container', 'open'),
('evt_cd_18', 'click', 'dropdown', 'order summary container', 'close'),
('evt_cd_19', 'click', 'dropdown', 'country from order summary', 'open'),
('evt_cd_2', 'click', 'button', 'burger from header', 'open side menu'),
('evt_cd_20', 'click', 'dropdown', 'country from order summary', 'close'),
('evt_cd_21', 'click', 'checkbox', 'one country of the countries dropdown from order summary', 'request to select country'),
('evt_cd_22', 'response', 'json', 'request select country', 'select country'),
('evt_cd_23', 'click', 'collapse', 'support contacts from order summary', 'open'),
('evt_cd_24', 'click', 'collapse', 'support contacts from order summary', 'close'),
('evt_cd_25', 'click', 'button', 'new address adder from address selector form', 'open address editor popup'),
('evt_cd_26', 'click', 'button', 'address block from address selector form', 'focus address'),
('evt_cd_27', 'click', 'button', 'submit focus address', 'request to select address'),
('evt_cd_28', 'response', 'json', 'request to select address', 'select address'),
('evt_cd_29', 'click', 'dropdown', 'checkout cart', 'open'),
('evt_cd_3', 'click', 'button', 'opener for box adder from side menu', 'open boxes pricing popup'),
('evt_cd_30', 'click', 'dropdown', 'checkout cart', 'close'),
('evt_cd_31', 'click', 'button', 'submit checkout summary', 'request to launch checkout'),
('evt_cd_32', 'response', 'json', 'request to launch checkout', 'launch checkout'),
('evt_cd_33', 'click', 'button', 'closer of address editor popup', 'close address editor popup'),
('evt_cd_34', 'blur', 'input', 'from address form', 'finished typing'),
('evt_cd_35', 'click', 'dropdown', 'country from address form', 'open'),
('evt_cd_36', 'click', 'dropdown', 'country from address form', 'close'),
('evt_cd_37', 'click', 'checkbox', 'country of the country dropdown from address form', 'request to select country'),
('evt_cd_38', 'click', 'button', 'submit address form', 'request to add new address'),
('evt_cd_39', 'response', 'json', 'request add new address', 'add new address'),
('evt_cd_4', 'click', 'button', 'burger from header', 'close side menu'),
('evt_cd_40', 'click', 'button', 'sign up switcher from sign form', 'switch to sign up form'),
('evt_cd_41', 'click', 'button', 'sign in switcher from sign form', 'switch to sign in form'),
('evt_cd_42', 'click', 'checkbox', 'from sign up form', 'check or uncheck'),
('evt_cd_43', 'blur', 'input', 'from sign up form', 'finished typing'),
('evt_cd_44', 'click', 'checkbox', 'from sign in forrm', 'check or uncheck'),
('evt_cd_45', 'blur', 'input', 'from sign in forrm', 'finished typing'),
('evt_cd_46', 'click', 'button', 'submit sign up form', 'request to sign up'),
('evt_cd_47', 'response', 'json', 'request to sign up', 'sign up'),
('evt_cd_48', 'click', 'button', 'submit sign in form', 'request to sign in'),
('evt_cd_49', 'response', 'json', 'request to sign in', 'sign in'),
('evt_cd_5', 'click', 'button', 'opener for box adder from header', 'open boxes pricing popup'),
('evt_cd_50', 'click', 'button', 'closer of sign popup', 'close sign popup'),
('evt_cd_51', 'click', 'button', 'add a new box from boxes pricing popup', 'request to add a new box'),
('evt_cd_52', 'response', 'json', 'request add box', 'add new box in cart'),
('evt_cd_53', 'click', 'button', 'closer of boxes pricing popup', 'close boxes pricing popup'),
('evt_cd_54', 'click', 'button', 'cart logo from mobile header', 'request cart popup'),
('evt_cd_55', 'click', 'button', 'cart logo from computer header', 'request cart popup'),
('evt_cd_56', 'response', 'json', 'request cart popup', 'open cart popup'),
('evt_cd_57', 'click', 'button', 'deleter of box', 'request to delete box'),
('evt_cd_58', 'response', 'json', 'request to delete box', 'delete box'),
('evt_cd_59', 'click', 'button', 'arrow of box', 'open box content'),
('evt_cd_6', 'click', 'button', 'opener for box adder from box manager popup', 'open boxes pricing popup'),
('evt_cd_60', 'click', 'button', 'arrow of box', 'close box content'),
('evt_cd_61', 'click', 'button', 'deleter of product in box', 'request to delete product from box'),
('evt_cd_62', 'response', 'json', 'request to delete product from box', 'delete product from box'),
('evt_cd_63', 'click', 'button', 'updater of product in box', 'open mini-pop of product'),
('evt_cd_64', 'click', 'button', 'mover of product in mini-pop of product in box', 'request box manager popup'),
('evt_cd_65', 'response', 'json', 'request box manager popup', 'open box manager popup'),
('evt_cd_66', 'click', 'button', 'submit focussed destination box', 'request to move product to focussed box'),
('evt_cd_67', 'response', 'json', 'request to move product to focussed box', 'move product to focussed box'),
('evt_cd_68', 'click', 'button', 'updater of size in mini-pop of product in box', 'request size editor popup'),
('evt_cd_69', 'response', 'json', 'request size editor popup', 'open size editor popup'),
('evt_cd_7', 'click', 'button', 'sign logo from header', 'open sign popup'),
('evt_cd_70', 'click', 'button', 'closer of cart popup', 'close cart popup'),
('evt_cd_71', 'click', 'button', 'box block', 'focus on box'),
('evt_cd_72', 'click', 'button', 'closer of box manager popup', 'close box manager popup'),
('evt_cd_73', 'click', 'checkbox', 'from size editor popup', 'check or uncheck'),
('evt_cd_74', 'blur', 'input', 'from size editor popup', 'finished typing'),
('evt_cd_75', 'click', 'checkbox', 'from product adder form', 'check or uncheck'),
('evt_cd_76', 'click', 'dropdown', 'measure cut from size editor popup', 'open'),
('evt_cd_77', 'click', 'dropdown', 'measure cut from size editor popup', 'close'),
('evt_cd_78', 'click', 'dropdown', 'measure cut from product adder form', 'open'),
('evt_cd_79', 'click', 'dropdown', 'measure cut from product adder form', 'close'),
('evt_cd_8', 'click', 'button', 'sign logo from side menu', 'open sign popup'),
('evt_cd_80', 'click', 'button', 'submit size editor', 'request to update product'),
('evt_cd_81', 'response', 'json', 'request to update product', 'update product'),
('evt_cd_82', 'click', 'button', 'submit product adder form', 'request to check if still stock for the submitted product'),
('evt_cd_83', 'response', 'json', 'request to check if still stock for the submitted product', 'still stock for the submitted product'),
('evt_cd_84', 'click', 'button', 'submit focussed destination box', 'request to add new product'),
('evt_cd_85', 'response', 'json', 'request to add new product', 'add new product'),
('evt_cd_86', 'click', 'button', 'opener for brand adder from size editor popup', 'open brand popup'),
('evt_cd_87', 'click', 'button', 'opener for brand adder from product adder form', 'open brand popup'),
('evt_cd_88', 'click', 'button', 'closer of brand popup', 'close brand popup'),
('evt_cd_89', 'click', 'button', 'brand logo', 'focus brand'),
('evt_cd_9', 'launch', 'alert', 'ask pop', 'display ask message'),
('evt_cd_90', 'click', 'button', 'submit focussed brand', 'request to select brand'),
('evt_cd_91', 'response', 'json', 'request to select brand', 'select brand'),
('evt_cd_92', 'click', 'button', 'opener for measure manager from size editor popup', 'open measure manager popup'),
('evt_cd_93', 'click', 'button', 'opener for measure manager from product adder form', 'open measure manager popup'),
('evt_cd_94', 'click', 'button', 'measure block', 'focus measure'),
('evt_cd_95', 'click', 'button', 'deleter of measure block', 'request to delete measure'),
('evt_cd_96', 'response', 'json', 'request to delete measure', 'delete measure'),
('evt_cd_97', 'click', 'button', 'updater of measure block', 'request measure editor popup'),
('evt_cd_98', 'response', 'json', ' request measure editor popup', 'open measure editor popup'),
('evt_cd_99', 'click', 'button', 'opener for measure editor from size editor popup', 'open measure editor popup');

-- --------------------------------------------------------

--
-- Structure de la table `EventsDatas`
--

CREATE TABLE `EventsDatas` (
  `eventId` varchar(50) NOT NULL,
  `dataKey` varchar(100) NOT NULL,
  `dataValue` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Structure de la table `Locations`
--

CREATE TABLE `Locations` (
  `navId` varchar(50) NOT NULL,
  `locationDate` datetime NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `message` varchar(100) DEFAULT NULL,
  `continent` varchar(50) DEFAULT NULL,
  `continentCode` varchar(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `countryCode` varchar(10) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `regionName` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `zip` varchar(50) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `offset` int(11) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `isp` varchar(100) DEFAULT NULL,
  `ispOrg` varchar(100) DEFAULT NULL,
  `ispAs` varchar(100) DEFAULT NULL,
  `asname` varchar(100) DEFAULT NULL,
  `reverse` varchar(100) DEFAULT NULL,
  `mobile` tinyint(1) DEFAULT NULL,
  `proxy` tinyint(1) DEFAULT NULL,
  `hosting` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Locations`
--

INSERT INTO `Locations` (`navId`, `locationDate`, `ip`, `status`, `message`, `continent`, `continentCode`, `country`, `countryCode`, `region`, `regionName`, `city`, `district`, `zip`, `lat`, `lon`, `timezone`, `offset`, `currency`, `isp`, `ispOrg`, `ispAs`, `asname`, `reverse`, `mobile`, `proxy`, `hosting`) VALUES
('nav_012r55022wu17235i0291ntp0', '2020-12-13 05:29:50', '114.119.132.9', 'success', NULL, 'asia', 'as', 'singapore', 'sg', NULL, NULL, 'singapore', NULL, NULL, 1.35208, 103.82, 'asia/singapore', 28800, 'sgd', 'huawei international pte. ltd', 'huawei international pte. ltd', 'as136907 huawei clouds', 'hwclouds-as-ap', 'petalbot-114-119-132-9.aspiegel.com', 0, 1, 0),
('nav_3pfi414505jiej2p2t1021023', '2020-12-13 05:44:53', '114.119.129.189', 'success', NULL, 'asia', 'as', 'singapore', 'sg', NULL, NULL, 'singapore', NULL, NULL, 1.35208, 103.82, 'asia/singapore', 28800, 'sgd', 'huawei international pte. ltd', 'huawei international pte. ltd', 'as136907 huawei clouds', 'hwclouds-as-ap', 'petalbot-114-119-129-189.aspiegel.com', 0, 0, 0),
('nav_51200t2343uq501u1sm22jes4', '2020-12-13 05:34:51', '114.119.146.244', 'success', NULL, 'asia', 'as', 'singapore', 'sg', NULL, NULL, 'singapore', NULL, NULL, 1.35208, 103.82, 'asia/singapore', 28800, 'sgd', 'huawei international pte. ltd', 'huawei international pte. ltd', 'as136907 huawei clouds', 'hwclouds-as-ap', 'petalbot-114-119-146-244.aspiegel.com', 0, 0, 0),
('nav_c053023221kj3e5h91eto8032', '2020-12-13 05:39:53', '114.119.155.44', 'success', NULL, 'asia', 'as', 'singapore', 'sg', NULL, NULL, 'singapore', NULL, NULL, 1.35208, 103.82, 'asia/singapore', 28800, 'sgd', 'huawei international pte. ltd', 'huawei international pte. ltd', 'as136907 huawei clouds', 'hwclouds-as-ap', 'petalbot-114-119-155-44.aspiegel.com', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Mailers`
--

CREATE TABLE `Mailers` (
  `mailer` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Mailers`
--

INSERT INTO `Mailers` (`mailer`) VALUES
('BlueAPI');

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
-- Structure de la table `Navigations`
--

CREATE TABLE `Navigations` (
  `navID` varchar(50) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `xhrFrom` varchar(50) DEFAULT NULL,
  `navDate` datetime NOT NULL,
  `url` varchar(1000) NOT NULL,
  `webroot` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `timeOn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Navigations`
--

INSERT INTO `Navigations` (`navID`, `userId`, `xhrFrom`, `navDate`, `url`, `webroot`, `path`, `timeOn`) VALUES
('nav_012r55022wu17235i0291ntp0', 'usr_0952slu1412wy02e1105z2y30', NULL, '2020-12-13 05:29:50', 'https://www.iandmeim.com/item?id=289', '/', 'item', NULL),
('nav_3pfi414505jiej2p2t1021023', 'usr_5t20ai37b3014p1v412052dp5', NULL, '2020-12-13 05:44:53', 'https://www.iandmeim.com/item/?id=401', '/', 'item/', NULL),
('nav_51200t2343uq501u1sm22jes4', 'usr_1fi1003j152532f4cx10uw232', NULL, '2020-12-13 05:34:51', 'https://www.iandmeim.com/item?id=177', '/', 'item', NULL),
('nav_c053023221kj3e5h91eto8032', 'usr_t5br0n93211165003212753st', NULL, '2020-12-13 05:39:53', 'https://www.iandmeim.com/item?id=144', '/', 'item', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Navigations-Events`
--

CREATE TABLE `Navigations-Events` (
  `xhrId` varchar(50) NOT NULL,
  `eventID` varchar(50) NOT NULL,
  `event_code` varchar(50) NOT NULL,
  `eventDate` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `NavigationsParameters`
--

CREATE TABLE `NavigationsParameters` (
  `navId` varchar(50) NOT NULL,
  `paramKey` varchar(100) NOT NULL,
  `paramValue` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `NavigationsParameters`
--

INSERT INTO `NavigationsParameters` (`navId`, `paramKey`, `paramValue`) VALUES
('nav_012r55022wu17235i0291ntp0', 'id', '289'),
('nav_3pfi414505jiej2p2t1021023', 'id', '401'),
('nav_51200t2343uq501u1sm22jes4', 'id', '177'),
('nav_c053023221kj3e5h91eto8032', 'id', '144');

-- --------------------------------------------------------

--
-- Structure de la table `Orders`
--

CREATE TABLE `Orders` (
  `orderID` varchar(100) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `stripeCheckoutId` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `vatRate` float NOT NULL,
  `vat` float NOT NULL,
  `hvat` float NOT NULL,
  `sellPrice` float NOT NULL,
  `discount` float NOT NULL,
  `subtotal` float NOT NULL,
  `shipping` float NOT NULL,
  `shipDiscount` float NOT NULL,
  `total` float NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-Addresses`
--

CREATE TABLE `Orders-Addresses` (
  `orderId` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `appartement` varchar(100) DEFAULT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-Boxes`
--

CREATE TABLE `Orders-Boxes` (
  `orderId` varchar(100) NOT NULL,
  `boxId` varchar(100) NOT NULL,
  `box_color` varchar(10) NOT NULL,
  `sizeMax` int(11) NOT NULL,
  `weight` double NOT NULL,
  `boxPicture` varchar(100) NOT NULL,
  `sellPrice` double NOT NULL,
  `shipping` double NOT NULL,
  `discount_value` double DEFAULT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-BoxProducts`
--

CREATE TABLE `Orders-BoxProducts` (
  `boxId` varchar(100) NOT NULL,
  `prodId` varchar(100) NOT NULL,
  `sequenceID` varchar(100) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `realSize` varchar(100) NOT NULL,
  `weight` double NOT NULL,
  `size_name` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `measureId` varchar(100) DEFAULT NULL,
  `cut_name` varchar(30) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `setDate` datetime NOT NULL,
  `stillStock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-DiscountCodes`
--

CREATE TABLE `Orders-DiscountCodes` (
  `orderId` varchar(100) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `rate` float NOT NULL,
  `maxAmount` float DEFAULT NULL,
  `minAmount` float NOT NULL,
  `nbUse` int(11) DEFAULT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `isCombinable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Orders-UsersMeasures`
--

CREATE TABLE `Orders-UsersMeasures` (
  `orderId` varchar(100) NOT NULL,
  `measureID` varchar(100) NOT NULL,
  `measureName` varchar(25) NOT NULL,
  `bust` float NOT NULL,
  `arm` float NOT NULL,
  `waist` float NOT NULL,
  `hip` float NOT NULL,
  `inseam` float NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `OrdersStatus`
--

CREATE TABLE `OrdersStatus` (
  `orderId` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `trackingNumber` varchar(100) DEFAULT NULL,
  `adminId` varchar(50) NOT NULL,
  `deliveryMin` date DEFAULT NULL,
  `deliveryMax` date DEFAULT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Payements`
--

CREATE TABLE `Payements` (
  `payID` varchar(50) NOT NULL,
  `payMethod` varchar(50) NOT NULL,
  `company_` varchar(50) NOT NULL,
  `cancelPath` varchar(100) NOT NULL,
  `successPath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Payements`
--

INSERT INTO `Payements` (`payID`, `payMethod`, `company_`, `cancelPath`, `successPath`) VALUES
('alipay', 'alipay', 'stripe', 'checkout', 'checkout/success'),
('bancontact', 'bancontact', 'stripe', 'checkout', 'checkout/success'),
('card', 'card', 'stripe', 'checkout', 'checkout/success'),
('giropay', 'giropay', 'stripe', 'checkout', 'checkout/success'),
('ideal', 'ideal', 'stripe', 'checkout', 'checkout/success');

-- --------------------------------------------------------

--
-- Structure de la table `Privileges`
--

CREATE TABLE `Privileges` (
  `privID` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Privileges`
--

INSERT INTO `Privileges` (`privID`, `description`) VALUES
('system', 'access to cron task');

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
  `prodID` varchar(100) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL,
  `groupID` varchar(50) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `addedDate` datetime NOT NULL,
  `colorName` enum('red','gold','purple','pink','blue','green','white','black','beige','grey','brown','yellow','orange') NOT NULL,
  `colorRGB` varchar(50) NOT NULL,
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products`
--

INSERT INTO `Products` (`prodID`, `isAvailable`, `groupID`, `product_type`, `addedDate`, `colorName`, `colorRGB`, `weight`) VALUES
('1', 0, 'a1', 'boxproduct', '2020-12-13 07:04:53', 'blue', '#192035', 0.265),
('10', 0, 'a9', 'boxproduct', '2020-12-13 07:06:28', 'beige', '#d4c4c2', 0.14),
('101', 0, 'a96', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#233b57', 0.765),
('102', 0, 'a97', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#12355c', 0.415),
('104', 0, 'a99', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#bd8b92', 1.175),
('105', 0, 'a100', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.22),
('106', 0, 'a101', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#c98973', 0.295),
('107', 0, 'a102', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.315),
('108', 0, 'a103', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.285),
('109', 0, 'a104', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#aa6263', 0.175),
('11', 0, 'a10', 'boxproduct', '2020-12-13 07:06:28', 'red', '#ab002c', 0.175),
('110', 0, 'a105', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#78aacc', 0.29),
('111', 0, 'a106', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.3),
('112', 0, 'a107', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.155),
('113', 0, 'a108', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#585c66', 0.095),
('114', 0, 'a109', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#cb97a3', 0.1),
('115', 0, 'a110', 'boxproduct', '2020-12-13 07:06:28', 'yellow', '#ccb041', 0.2),
('116', 0, 'a111', 'boxproduct', '2020-12-13 07:06:28', 'yellow', '#cfce61', 0.15),
('117', 0, 'a112', 'boxproduct', '2020-12-13 07:06:28', 'yellow', '#c58c28', 0.125),
('118', 0, 'a113', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#552a5f', 0.12),
('119', 0, 'a114', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#3c629d', 0.215),
('12', 0, 'a11', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.085),
('120', 0, 'a115', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.54),
('121', 0, 'a116', 'boxproduct', '2020-12-13 07:06:28', 'red', '#b0001e', 0.665),
('123', 0, 'a117', 'boxproduct', '2020-12-13 07:06:28', 'red', '#c00012', 0.345),
('124', 0, 'a118', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.045),
('125', 0, 'a119', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#c39588', 0.1),
('126', 0, 'a120', 'boxproduct', '2020-12-13 07:06:28', 'red', '#a8002a', 0.115),
('128', 0, 'a121', 'boxproduct', '2020-12-13 07:06:28', 'beige', '#aaa088', 0.19),
('129', 0, 'a122', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.1),
('13', 0, 'a12', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#aaabae', 0.16),
('131', 0, 'a123', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#943612', 0.195),
('132', 0, 'a124', 'boxproduct', '2020-12-13 07:06:28', 'green', '#2f4d44', 0.235),
('133', 0, 'a125', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.18),
('134', 0, 'a126', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#b26c2f', 0.27),
('135', 0, 'a127', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.455),
('136', 0, 'a128', 'boxproduct', '2020-12-13 07:06:28', 'red', '#96002b', 0.26),
('137', 0, 'a129', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#8b95ad', 0.2),
('138', 0, 'a130', 'boxproduct', '2020-12-13 07:06:28', 'yellow', '#dca726', 0.22),
('14', 0, 'a13', 'boxproduct', '2020-12-13 07:06:28', 'green', '#4e5b54', 0.205),
('141', 0, 'a131', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#456069', 0.425),
('142', 0, 'a132', 'boxproduct', '2020-12-13 07:06:28', 'red', '#631526', 0.065),
('144', 0, 'a133', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.105),
('146', 0, 'a134', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#1b306b', 0.115),
('147', 0, 'a135', 'boxproduct', '2020-12-13 07:06:28', 'red', '#631526', 0.145),
('148', 0, 'a136', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.1),
('15', 0, 'a14', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.115),
('16', 0, 'a15', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#1f1f1f', 0.17),
('17', 0, 'a16', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#636363', 0.11),
('18', 0, 'a17', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.225),
('19', 0, 'a18', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#c77391', 0.08),
('2', 0, 'a2', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#42152c', 0.15),
('20', 0, 'a19', 'boxproduct', '2020-12-13 07:06:28', 'red', '#a9002e', 0.16),
('21', 0, 'a20', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.07),
('22', 0, 'a21', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.155),
('23', 0, 'a22', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#2c345b', 0.34),
('24', 0, 'a23', 'boxproduct', '2020-12-13 07:06:28', 'red', '#c60025', 0.095),
('25', 0, 'a24', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#949bc8', 0.145),
('27', 0, 'a25', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#c80049', 0.325),
('28', 0, 'a26', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#1b1f41', 0.405),
('29', 0, 'a27', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#52617f', 0.34),
('3', 0, 'a3', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#2f65cd', 0.195),
('30', 0, 'a28', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#2b2325', 0.225),
('31', 0, 'a29', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#3a4ec4', 0.12),
('32', 0, 'a30', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#4c5660', 0.245),
('33', 0, 'a31', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#1668b9', 0.195),
('34', 0, 'a32', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#8e8cbb', 0.26),
('35', 0, 'a33', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#0a2a60', 0.34),
('36', 0, 'a34', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#bd417e', 0.375),
('37', 0, 'a35', 'boxproduct', '2020-12-13 07:06:28', 'red', '#a50122', 0.095),
('38', 0, 'a36', 'boxproduct', '2020-12-13 07:06:28', 'beige', '#9ea089', 0.145),
('39', 0, 'a37', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#bd0040', 0.175),
('4', 0, 'a4', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#0f0c1d', 0.125),
('40', 0, 'a38', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#562f19', 0.13),
('41', 0, 'a39', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#bf8f96', 0.145),
('42', 0, 'a40', 'boxproduct', '2020-12-13 07:06:28', 'yellow', '#dcc50e', 0.1),
('43', 0, 'a41', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#507485', 0.25),
('44', 0, 'a42', 'boxproduct', '2020-12-13 07:06:28', 'red', '#8a222e', 0.145),
('45', 0, 'a43', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#33252b', 0.39),
('46', 0, 'a44', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#b5acc0', 0.2),
('47', 0, 'a45', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.245),
('48', 0, 'a46', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#505c7a', 0.11),
('49', 0, 'a47', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#b0393d', 0.19),
('5', 0, 'a5', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#193157', 0.125),
('50', 0, 'a48', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#a63758', 0.11),
('51', 0, 'a49', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#bf0050', 0.395),
('52', 0, 'a50', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.11),
('53', 0, 'a51', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#12151f', 0.525),
('55', 0, 'a52', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#005489', 0.105),
('56', 0, 'a53', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#c7086f', 0.35),
('57', 0, 'a54', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.375),
('58', 0, 'a55', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.16),
('59', 0, 'a56', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.115),
('6', 0, 'a6', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#3e1a61', 0.33),
('61', 0, 'a57', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#b38e82', 0.115),
('62', 0, 'a58', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#b6b5b0', 0.135),
('64', 0, 'a60', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#125dae', 0.215),
('65', 0, 'a61', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#3b6c8b', 0.595),
('66', 0, 'a62', 'boxproduct', '2020-12-13 07:06:28', 'beige', '#aeb1a0', 0.23),
('67', 0, 'a63', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#6d8ca7', 0.245),
('68', 0, 'a64', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#011857', 0.25),
('69', 0, 'a65', 'boxproduct', '2020-12-13 07:06:28', 'beige', '#929a91', 0.22),
('7', 0, 'a7', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#b6175e', 0.15),
('70', 0, 'a66', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.13),
('71', 0, 'a67', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#342123', 0.245),
('72', 0, 'a68', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#18329c', 0.32),
('73', 0, 'a69', 'boxproduct', '2020-12-13 07:06:28', 'red', '#d5002b', 0.135),
('74', 0, 'a70', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#af8045', 0.185),
('75', 0, 'a71', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#0f1b29', 0.305),
('76', 0, 'a72', 'boxproduct', '2020-12-13 07:06:28', 'orange', '#9e4f00', 0.165),
('77', 0, 'a73', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#3c2c2c', 0.16),
('78', 0, 'a74', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#001daa', 0.22),
('79', 0, 'a75', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#141518', 0.195),
('8', 0, 'a8', 'boxproduct', '2020-12-13 07:06:28', 'pink', '#d45747', 0.175),
('80', 0, 'a76', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.15),
('81', 0, 'a77', 'boxproduct', '2020-12-13 07:06:28', 'orange', '#c2560c', 0.24),
('82', 0, 'a78', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#70594e', 0.235),
('83', 0, 'a79', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#191f30', 0.255),
('84', 0, 'a80', 'boxproduct', '2020-12-13 07:06:28', 'brown', '#3c3530', 0.395),
('85', 0, 'a81', 'boxproduct', '2020-12-13 07:06:28', 'white', '#ffffff', 0.26),
('86', 0, 'a82', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#191c1e', 0.205),
('87', 0, 'a83', 'boxproduct', '2020-12-13 07:06:28', 'green', '#768771', 0.25),
('88', 0, 'a84', 'boxproduct', '2020-12-13 07:06:28', 'grey', '#596366', 0.285),
('89', 0, 'a85', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#12121a', 0.195),
('90', 0, 'a86', 'boxproduct', '2020-12-13 07:06:28', 'purple', '#1a1015', 0.43),
('91', 0, 'a87', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#151c2f', 0.32),
('92', 0, 'a88', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#58809b', 0.15),
('93', 0, 'a89', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#0b2435', 0.145),
('94', 0, 'a90', 'boxproduct', '2020-12-13 07:06:28', 'green', '#302c2a', 0.335),
('95', 0, 'a91', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#2f5d98', 0.57),
('96', 0, 'a92', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#0a2b56', 0.55),
('97', 0, 'a93', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#071530', 0.405),
('98', 0, 'a94', 'boxproduct', '2020-12-13 07:06:28', 'blue', '#1a4781', 0.33),
('99', 0, 'a95', 'boxproduct', '2020-12-13 07:06:28', 'black', '#000000', 0.36);

-- --------------------------------------------------------

--
-- Structure de la table `Products-Categories`
--

CREATE TABLE `Products-Categories` (
  `prodId` varchar(100) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Categories`
--

INSERT INTO `Products-Categories` (`prodId`, `category_name`) VALUES
('108', 'dress'),
('109', 'dress'),
('110', 'dress'),
('111', 'dress'),
('112', 'dress'),
('113', 'dress'),
('114', 'dress'),
('115', 'dress'),
('116', 'dress'),
('117', 'dress'),
('118', 'dress'),
('119', 'dress'),
('120', 'dress'),
('121', 'dress'),
('29', 'dress'),
('3', 'dress'),
('32', 'dress'),
('33', 'dress'),
('34', 'dress'),
('35', 'dress'),
('36', 'dress'),
('45', 'dress'),
('6', 'dress'),
('136', 'hoodie'),
('137', 'hoodie'),
('138', 'hoodie'),
('101', 'jeans'),
('102', 'jeans'),
('141', 'jeans'),
('95', 'jeans'),
('96', 'jeans'),
('97', 'jeans'),
('98', 'jeans'),
('99', 'jeans'),
('123', 'jumpsuits'),
('83', 'pant suits'),
('1', 'polo shirt'),
('16', 'polo shirt'),
('47', 'polo shirt'),
('24', 'shirt'),
('43', 'shirt'),
('56', 'shirt'),
('59', 'shirt'),
('8', 'shirt'),
('144', 'shorts'),
('146', 'shorts'),
('147', 'shorts'),
('80', 'shorts'),
('92', 'shorts'),
('93', 'shorts'),
('148', 'skirt'),
('64', 'skirt'),
('65', 'skirt'),
('68', 'skirt'),
('70', 'skirt'),
('71', 'skirt'),
('72', 'skirt'),
('74', 'skirt'),
('75', 'skirt'),
('76', 'skirt'),
('77', 'skirt'),
('78', 'skirt'),
('85', 'skirt'),
('66', 'skirt suits'),
('67', 'skirt suits'),
('69', 'skirt suits'),
('73', 'skirt suits'),
('79', 'skirt suits'),
('82', 'skirt suits'),
('132', 'sweater'),
('133', 'sweater'),
('134', 'sweater'),
('135', 'sweater'),
('51', 'sweater'),
('57', 'sweater'),
('10', 't-shirt'),
('11', 't-shirt'),
('13', 't-shirt'),
('14', 't-shirt'),
('17', 't-shirt'),
('18', 't-shirt'),
('2', 't-shirt'),
('20', 't-shirt'),
('21', 't-shirt'),
('25', 't-shirt'),
('30', 't-shirt'),
('31', 't-shirt'),
('37', 't-shirt'),
('38', 't-shirt'),
('39', 't-shirt'),
('40', 't-shirt'),
('41', 't-shirt'),
('42', 't-shirt'),
('44', 't-shirt'),
('46', 't-shirt'),
('48', 't-shirt'),
('49', 't-shirt'),
('5', 't-shirt'),
('50', 't-shirt'),
('55', 't-shirt'),
('61', 't-shirt'),
('62', 't-shirt'),
('12', 'top'),
('124', 'top'),
('125', 'top'),
('126', 'top'),
('128', 'top'),
('129', 'top'),
('131', 'top'),
('15', 'top'),
('19', 'top'),
('22', 'top'),
('23', 'top'),
('27', 'top'),
('4', 'top'),
('52', 'top'),
('58', 'top'),
('7', 'top'),
('142', 'trousers'),
('81', 'trousers'),
('84', 'trousers'),
('86', 'trousers'),
('87', 'trousers'),
('88', 'trousers'),
('89', 'trousers'),
('90', 'trousers'),
('91', 'trousers'),
('94', 'trousers'),
('105', 'vest'),
('106', 'vest'),
('107', 'vest'),
('28', 'vest'),
('53', 'vest'),
('104', 'winter coat');

-- --------------------------------------------------------

--
-- Structure de la table `Products-Collections`
--

CREATE TABLE `Products-Collections` (
  `prodId` varchar(100) NOT NULL,
  `collection_name` varchar(100) NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Collections`
--

INSERT INTO `Products-Collections` (`prodId`, `collection_name`, `beginDate`, `endDate`) VALUES
('1', 'drop1', NULL, NULL),
('1', 'women', NULL, NULL),
('10', 'drop1', NULL, NULL),
('10', 'women', NULL, NULL),
('101', 'drop1', NULL, NULL),
('101', 'women', NULL, NULL),
('102', 'drop1', NULL, NULL),
('102', 'women', NULL, NULL),
('104', 'drop1', NULL, NULL),
('104', 'women', NULL, NULL),
('105', 'drop1', NULL, NULL),
('105', 'women', NULL, NULL),
('106', 'drop1', NULL, NULL),
('106', 'women', NULL, NULL),
('107', 'drop1', NULL, NULL),
('107', 'women', NULL, NULL),
('108', 'drop1', NULL, NULL),
('108', 'women', NULL, NULL),
('109', 'drop1', NULL, NULL),
('109', 'women', NULL, NULL),
('11', 'drop1', NULL, NULL),
('11', 'women', NULL, NULL),
('110', 'drop1', NULL, NULL),
('110', 'women', NULL, NULL),
('111', 'drop1', NULL, NULL),
('111', 'women', NULL, NULL),
('112', 'drop1', NULL, NULL),
('112', 'women', NULL, NULL),
('113', 'drop1', NULL, NULL),
('113', 'women', NULL, NULL),
('114', 'drop1', NULL, NULL),
('114', 'women', NULL, NULL),
('115', 'drop1', NULL, NULL),
('115', 'women', NULL, NULL),
('116', 'drop1', NULL, NULL),
('116', 'women', NULL, NULL),
('117', 'drop1', NULL, NULL),
('117', 'women', NULL, NULL),
('118', 'drop1', NULL, NULL),
('118', 'women', NULL, NULL),
('119', 'drop1', NULL, NULL),
('119', 'women', NULL, NULL),
('12', 'drop1', NULL, NULL),
('12', 'women', NULL, NULL),
('120', 'drop1', NULL, NULL),
('120', 'women', NULL, NULL),
('121', 'drop1', NULL, NULL),
('121', 'women', NULL, NULL),
('123', 'drop1', NULL, NULL),
('123', 'women', NULL, NULL),
('124', 'drop1', NULL, NULL),
('124', 'women', NULL, NULL),
('125', 'drop1', NULL, NULL),
('125', 'women', NULL, NULL),
('126', 'drop1', NULL, NULL),
('126', 'women', NULL, NULL),
('128', 'drop1', NULL, NULL),
('128', 'women', NULL, NULL),
('129', 'drop1', NULL, NULL),
('129', 'women', NULL, NULL),
('13', 'drop1', NULL, NULL),
('13', 'women', NULL, NULL),
('131', 'drop1', NULL, NULL),
('131', 'women', NULL, NULL),
('132', 'drop1', NULL, NULL),
('132', 'women', NULL, NULL),
('133', 'drop1', NULL, NULL),
('133', 'women', NULL, NULL),
('134', 'drop1', NULL, NULL),
('134', 'women', NULL, NULL),
('135', 'drop1', NULL, NULL),
('135', 'women', NULL, NULL),
('136', 'drop1', NULL, NULL),
('136', 'women', NULL, NULL),
('137', 'drop1', NULL, NULL),
('137', 'women', NULL, NULL),
('138', 'drop1', NULL, NULL),
('138', 'women', NULL, NULL),
('14', 'drop1', NULL, NULL),
('14', 'women', NULL, NULL),
('141', 'drop1', NULL, NULL),
('141', 'women', NULL, NULL),
('142', 'drop1', NULL, NULL),
('142', 'women', NULL, NULL),
('144', 'drop1', NULL, NULL),
('144', 'women', NULL, NULL),
('146', 'drop1', NULL, NULL),
('146', 'women', NULL, NULL),
('147', 'drop1', NULL, NULL),
('147', 'women', NULL, NULL),
('148', 'drop1', NULL, NULL),
('148', 'women', NULL, NULL),
('15', 'drop1', NULL, NULL),
('15', 'women', NULL, NULL),
('16', 'drop1', NULL, NULL),
('16', 'women', NULL, NULL),
('17', 'drop1', NULL, NULL),
('17', 'women', NULL, NULL),
('18', 'drop1', NULL, NULL),
('18', 'women', NULL, NULL),
('19', 'drop1', NULL, NULL),
('19', 'women', NULL, NULL),
('2', 'drop1', NULL, NULL),
('2', 'women', NULL, NULL),
('20', 'drop1', NULL, NULL),
('20', 'women', NULL, NULL),
('21', 'drop1', NULL, NULL),
('21', 'women', NULL, NULL),
('22', 'drop1', NULL, NULL),
('22', 'women', NULL, NULL),
('23', 'drop1', NULL, NULL),
('23', 'women', NULL, NULL),
('24', 'drop1', NULL, NULL),
('24', 'women', NULL, NULL),
('25', 'drop1', NULL, NULL),
('25', 'women', NULL, NULL),
('27', 'drop1', NULL, NULL),
('27', 'women', NULL, NULL),
('28', 'drop1', NULL, NULL),
('28', 'women', NULL, NULL),
('29', 'drop1', NULL, NULL),
('29', 'women', NULL, NULL),
('3', 'drop1', NULL, NULL),
('3', 'women', NULL, NULL),
('30', 'drop1', NULL, NULL),
('30', 'women', NULL, NULL),
('31', 'drop1', NULL, NULL),
('31', 'women', NULL, NULL),
('32', 'drop1', NULL, NULL),
('32', 'women', NULL, NULL),
('33', 'drop1', NULL, NULL),
('33', 'women', NULL, NULL),
('34', 'drop1', NULL, NULL),
('34', 'women', NULL, NULL),
('35', 'drop1', NULL, NULL),
('35', 'women', NULL, NULL),
('36', 'drop1', NULL, NULL),
('36', 'women', NULL, NULL),
('37', 'drop1', NULL, NULL),
('37', 'women', NULL, NULL),
('38', 'drop1', NULL, NULL),
('38', 'women', NULL, NULL),
('39', 'drop1', NULL, NULL),
('39', 'women', NULL, NULL),
('4', 'drop1', NULL, NULL),
('4', 'women', NULL, NULL),
('40', 'drop1', NULL, NULL),
('40', 'women', NULL, NULL),
('41', 'drop1', NULL, NULL),
('41', 'women', NULL, NULL),
('42', 'drop1', NULL, NULL),
('42', 'women', NULL, NULL),
('43', 'drop1', NULL, NULL),
('43', 'women', NULL, NULL),
('44', 'drop1', NULL, NULL),
('44', 'women', NULL, NULL),
('45', 'drop1', NULL, NULL),
('45', 'women', NULL, NULL),
('46', 'drop1', NULL, NULL),
('46', 'women', NULL, NULL),
('47', 'drop1', NULL, NULL),
('47', 'women', NULL, NULL),
('48', 'drop1', NULL, NULL),
('48', 'women', NULL, NULL),
('49', 'drop1', NULL, NULL),
('49', 'women', NULL, NULL),
('5', 'drop1', NULL, NULL),
('5', 'women', NULL, NULL),
('50', 'drop1', NULL, NULL),
('50', 'women', NULL, NULL),
('51', 'drop1', NULL, NULL),
('51', 'women', NULL, NULL),
('52', 'drop1', NULL, NULL),
('52', 'women', NULL, NULL),
('53', 'drop1', NULL, NULL),
('53', 'women', NULL, NULL),
('55', 'drop1', NULL, NULL),
('55', 'women', NULL, NULL),
('56', 'drop1', NULL, NULL),
('56', 'women', NULL, NULL),
('57', 'drop1', NULL, NULL),
('57', 'women', NULL, NULL),
('58', 'drop1', NULL, NULL),
('58', 'women', NULL, NULL),
('59', 'drop1', NULL, NULL),
('59', 'women', NULL, NULL),
('6', 'drop1', NULL, NULL),
('6', 'women', NULL, NULL),
('61', 'drop1', NULL, NULL),
('61', 'women', NULL, NULL),
('62', 'drop1', NULL, NULL),
('62', 'women', NULL, NULL),
('64', 'drop1', NULL, NULL),
('64', 'women', NULL, NULL),
('65', 'drop1', NULL, NULL),
('65', 'women', NULL, NULL),
('66', 'drop1', NULL, NULL),
('66', 'women', NULL, NULL),
('67', 'drop1', NULL, NULL),
('67', 'women', NULL, NULL),
('68', 'drop1', NULL, NULL),
('68', 'women', NULL, NULL),
('69', 'drop1', NULL, NULL),
('69', 'women', NULL, NULL),
('7', 'drop1', NULL, NULL),
('7', 'women', NULL, NULL),
('70', 'drop1', NULL, NULL),
('70', 'women', NULL, NULL),
('71', 'drop1', NULL, NULL),
('71', 'women', NULL, NULL),
('72', 'drop1', NULL, NULL),
('72', 'women', NULL, NULL),
('73', 'drop1', NULL, NULL),
('73', 'women', NULL, NULL),
('74', 'drop1', NULL, NULL),
('74', 'women', NULL, NULL),
('75', 'drop1', NULL, NULL),
('75', 'women', NULL, NULL),
('76', 'drop1', NULL, NULL),
('76', 'women', NULL, NULL),
('77', 'drop1', NULL, NULL),
('77', 'women', NULL, NULL),
('78', 'drop1', NULL, NULL),
('78', 'women', NULL, NULL),
('79', 'drop1', NULL, NULL),
('79', 'women', NULL, NULL),
('8', 'drop1', NULL, NULL),
('8', 'women', NULL, NULL),
('80', 'drop1', NULL, NULL),
('80', 'women', NULL, NULL),
('81', 'drop1', NULL, NULL),
('81', 'women', NULL, NULL),
('82', 'drop1', NULL, NULL),
('82', 'women', NULL, NULL),
('83', 'drop1', NULL, NULL),
('83', 'women', NULL, NULL),
('84', 'drop1', NULL, NULL),
('84', 'women', NULL, NULL),
('85', 'drop1', NULL, NULL),
('85', 'women', NULL, NULL),
('86', 'drop1', NULL, NULL),
('86', 'women', NULL, NULL),
('87', 'drop1', NULL, NULL),
('87', 'women', NULL, NULL),
('88', 'drop1', NULL, NULL),
('88', 'women', NULL, NULL),
('89', 'drop1', NULL, NULL),
('89', 'women', NULL, NULL),
('90', 'drop1', NULL, NULL),
('90', 'women', NULL, NULL),
('91', 'drop1', NULL, NULL),
('91', 'women', NULL, NULL),
('92', 'drop1', NULL, NULL),
('92', 'women', NULL, NULL),
('93', 'drop1', NULL, NULL),
('93', 'women', NULL, NULL),
('94', 'drop1', NULL, NULL),
('94', 'women', NULL, NULL),
('95', 'drop1', NULL, NULL),
('95', 'women', NULL, NULL),
('96', 'drop1', NULL, NULL),
('96', 'women', NULL, NULL),
('97', 'drop1', NULL, NULL),
('97', 'women', NULL, NULL),
('98', 'drop1', NULL, NULL),
('98', 'women', NULL, NULL),
('99', 'drop1', NULL, NULL),
('99', 'women', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Products-ProductFunctions`
--

CREATE TABLE `Products-ProductFunctions` (
  `prodId` varchar(100) NOT NULL,
  `function_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-ProductFunctions`
--

INSERT INTO `Products-ProductFunctions` (`prodId`, `function_name`) VALUES
('1', 'clothes'),
('10', 'clothes'),
('101', 'clothes'),
('102', 'clothes'),
('104', 'clothes'),
('105', 'clothes'),
('106', 'clothes'),
('107', 'clothes'),
('108', 'clothes'),
('109', 'clothes'),
('11', 'clothes'),
('110', 'clothes'),
('111', 'clothes'),
('112', 'clothes'),
('113', 'clothes'),
('114', 'clothes'),
('115', 'clothes'),
('116', 'clothes'),
('117', 'clothes'),
('118', 'clothes'),
('119', 'clothes'),
('12', 'clothes'),
('120', 'clothes'),
('121', 'clothes'),
('123', 'clothes'),
('124', 'clothes'),
('125', 'clothes'),
('126', 'clothes'),
('128', 'clothes'),
('129', 'clothes'),
('13', 'clothes'),
('131', 'clothes'),
('132', 'clothes'),
('133', 'clothes'),
('134', 'clothes'),
('135', 'clothes'),
('136', 'clothes'),
('137', 'clothes'),
('138', 'clothes'),
('14', 'clothes'),
('141', 'clothes'),
('142', 'clothes'),
('144', 'clothes'),
('146', 'clothes'),
('147', 'clothes'),
('148', 'clothes'),
('15', 'clothes'),
('16', 'clothes'),
('17', 'clothes'),
('18', 'clothes'),
('19', 'clothes'),
('2', 'clothes'),
('20', 'clothes'),
('21', 'clothes'),
('22', 'clothes'),
('23', 'clothes'),
('24', 'clothes'),
('25', 'clothes'),
('27', 'clothes'),
('28', 'clothes'),
('29', 'clothes'),
('3', 'clothes'),
('30', 'clothes'),
('31', 'clothes'),
('32', 'clothes'),
('33', 'clothes'),
('34', 'clothes'),
('35', 'clothes'),
('36', 'clothes'),
('37', 'clothes'),
('38', 'clothes'),
('39', 'clothes'),
('4', 'clothes'),
('40', 'clothes'),
('41', 'clothes'),
('42', 'clothes'),
('43', 'clothes'),
('44', 'clothes'),
('45', 'clothes'),
('46', 'clothes'),
('47', 'clothes'),
('48', 'clothes'),
('49', 'clothes'),
('5', 'clothes'),
('50', 'clothes'),
('51', 'clothes'),
('52', 'clothes'),
('53', 'clothes'),
('55', 'clothes'),
('56', 'clothes'),
('57', 'clothes'),
('58', 'clothes'),
('59', 'clothes'),
('6', 'clothes'),
('61', 'clothes'),
('62', 'clothes'),
('64', 'clothes'),
('65', 'clothes'),
('66', 'clothes'),
('67', 'clothes'),
('68', 'clothes'),
('69', 'clothes'),
('7', 'clothes'),
('70', 'clothes'),
('71', 'clothes'),
('72', 'clothes'),
('73', 'clothes'),
('74', 'clothes'),
('75', 'clothes'),
('76', 'clothes'),
('77', 'clothes'),
('78', 'clothes'),
('79', 'clothes'),
('8', 'clothes'),
('80', 'clothes'),
('81', 'clothes'),
('82', 'clothes'),
('83', 'clothes'),
('84', 'clothes'),
('85', 'clothes'),
('86', 'clothes'),
('87', 'clothes'),
('88', 'clothes'),
('89', 'clothes'),
('90', 'clothes'),
('91', 'clothes'),
('92', 'clothes'),
('93', 'clothes'),
('94', 'clothes'),
('95', 'clothes'),
('96', 'clothes'),
('97', 'clothes'),
('98', 'clothes'),
('99', 'clothes');

-- --------------------------------------------------------

--
-- Structure de la table `Products-Sizes`
--

CREATE TABLE `Products-Sizes` (
  `prodId` varchar(100) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products-Sizes`
--

INSERT INTO `Products-Sizes` (`prodId`, `size_name`, `stock`) VALUES
('1', '50', 1),
('1', 'xl', 1),
('10', '36', 1),
('10', 'xs', 1),
('101', '50', 1),
('101', 'xl', 1),
('102', '36', 1),
('102', 'xs', 1),
('104', '44', 1),
('104', 'l', 1),
('105', '52', 1),
('105', 'xl', 1),
('106', '50', 1),
('106', 'xl', 1),
('107', '44', 1),
('107', 'l', 1),
('108', '44', 1),
('108', 'm', 1),
('109', '38', 1),
('109', 's', 1),
('11', '38', 1),
('11', 'm', 1),
('110', '38', 1),
('110', 's', 1),
('111', '38', 1),
('111', 's', 1),
('112', '38', 1),
('112', 's', 1),
('113', '38', 1),
('113', 's', 1),
('114', '38', 1),
('114', 's', 1),
('115', '38', 1),
('115', 's', 1),
('116', '44', 1),
('116', 'm', 1),
('117', '38', 1),
('117', 's', 1),
('118', '38', 1),
('118', 's', 1),
('119', '38', 1),
('119', 's', 1),
('12', '38', 1),
('12', 's', 1),
('120', '38', 1),
('120', 's', 1),
('121', '38', 1),
('121', 'm', 1),
('123', '36', 1),
('123', 'xs', 1),
('124', '38', 1),
('124', 's', 1),
('125', '38', 1),
('125', 's', 1),
('126', '44', 1),
('126', 'm', 1),
('128', '38', 1),
('128', 's', 1),
('129', '38', 1),
('129', 's', 1),
('13', '38', 1),
('13', 's', 1),
('131', '38', 1),
('131', 's', 1),
('132', '44', 1),
('132', 'm', 1),
('133', '38', 1),
('133', 's', 1),
('134', '44', 1),
('134', 'm', 1),
('135', '44', 1),
('135', 'm', 1),
('136', '44', 1),
('136', 'm', 1),
('137', '44', 1),
('137', 'm', 1),
('138', '44', 1),
('138', 'm', 1),
('14', '48', 1),
('14', 'l', 1),
('141', '42', 1),
('141', 'm', 1),
('142', '36', 1),
('142', 'xs', 1),
('144', '34', 1),
('144', 'xs', 1),
('146', '38', 1),
('146', 's', 1),
('147', '38', 1),
('147', 's', 1),
('148', '38', 1),
('148', 's', 1),
('15', '40', 1),
('15', 'm', 1),
('16', '36', 1),
('16', 's', 1),
('17', '46', 1),
('17', 'l', 1),
('18', '38', 1),
('18', 's', 1),
('19', '48', 1),
('19', 'l', 1),
('2', '46', 1),
('2', 'l', 1),
('20', '42', 1),
('20', 'm', 1),
('21', '32', 1),
('21', 'xs', 1),
('22', '50', 1),
('22', 'xl', 1),
('23', '40', 1),
('23', 's', 1),
('24', '40', 1),
('24', 's', 1),
('25', '36', 1),
('25', 'xs', 1),
('27', '42', 1),
('27', 's', 1),
('28', '50', 1),
('28', 'xl', 1),
('29', '38', 1),
('29', 's', 1),
('3', '42', 1),
('3', 'm', 1),
('30', '46', 1),
('30', 'l', 1),
('31', '50', 1),
('31', 'xl', 1),
('32', '42', 1),
('32', 'm', 1),
('33', '48', 1),
('33', 'l', 1),
('34', '48', 1),
('34', 'l', 1),
('35', '42', 1),
('35', 'm', 1),
('36', '42', 1),
('36', 'm', 1),
('37', '36', 1),
('37', 's', 1),
('38', '40', 1),
('38', 'm', 1),
('39', '50', 1),
('39', 'xl', 1),
('4', '48', 1),
('4', 'l', 1),
('40', '38', 1),
('40', 's', 1),
('41', '34', 1),
('41', 'xs', 1),
('42', '38', 1),
('42', 's', 1),
('43', '48', 1),
('43', 'l', 1),
('44', '36', 1),
('44', 's', 1),
('45', '54', 1),
('45', 'xxl', 1),
('46', '44', 1),
('46', 'l', 1),
('47', '50', 1),
('47', 'xl', 1),
('48', '38', 1),
('48', 's', 1),
('49', '50', 1),
('49', 'xl', 1),
('5', '48', 1),
('5', 'l', 1),
('50', '36', 1),
('50', 'xs', 1),
('51', '36', 1),
('51', 'xs', 1),
('52', '36', 1),
('52', 's', 1),
('53', '48', 1),
('53', 'l', 1),
('55', '38', 1),
('55', 's', 1),
('56', '56', 1),
('56', 'xxl', 1),
('57', '44', 1),
('57', 'l', 1),
('58', '40', 1),
('58', 'm', 1),
('59', '54', 1),
('59', 'xxl', 1),
('6', '38', 1),
('6', 's', 1),
('61', '36', 1),
('61', 's', 1),
('62', '34', 1),
('62', 'xs', 1),
('64', '40', 1),
('64', 's', 1),
('65', '42', 1),
('65', 'm', 1),
('66', '44', 1),
('66', 'm', 1),
('67', '44', 1),
('67', 'm', 1),
('68', '36', 1),
('68', 'xs', 1),
('69', '46', 1),
('69', 'l', 1),
('7', '42', 1),
('7', 'm', 1),
('70', '38', 1),
('70', 's', 1),
('71', '46', 1),
('71', 'm', 1),
('72', '56', 1),
('72', 'm', 1),
('73', '42', 1),
('73', 'm', 1),
('74', '40', 1),
('74', 's', 1),
('75', '42', 1),
('75', 's', 1),
('76', '44', 1),
('76', 'm', 1),
('77', '42', 1),
('77', 's', 1),
('78', '40', 1),
('78', 's', 1),
('79', '44', 1),
('79', 'm', 1),
('8', '52', 1),
('8', 'xl', 1),
('80', '40', 1),
('80', 's', 1),
('81', '42', 1),
('81', 'm', 1),
('82', '44', 1),
('82', 'm', 1),
('83', '38', 1),
('83', 's', 1),
('84', '38', 1),
('84', 's', 1),
('85', '44', 1),
('85', 'm', 1),
('86', '46', 1),
('86', 'm', 1),
('87', '44', 1),
('87', 'm', 1),
('88', '48', 1),
('88', 'l', 1),
('89', '36', 1),
('89', 'xs', 1),
('90', '44', 1),
('90', 'm', 1),
('91', '38', 1),
('91', 's', 1),
('92', '40', 1),
('92', 's', 1),
('93', '42', 1),
('93', 'm', 1),
('94', '44', 1),
('94', 'm', 1),
('95', '46', 1),
('95', 'm', 1),
('96', '46', 1),
('96', 'm', 1),
('97', '40', 1),
('97', 's', 1),
('98', '36', 1),
('98', 'xs', 1),
('99', '36', 1),
('99', 'xs', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ProductsDescriptions`
--

CREATE TABLE `ProductsDescriptions` (
  `prodId` varchar(100) NOT NULL,
  `lang_` varchar(10) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `richDescription` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsDescriptions`
--

INSERT INTO `ProductsDescriptions` (`prodId`, `lang_`, `description`, `richDescription`) VALUES
('1', 'en', 'Polo shirt with long sleeves. Model with a buttoned front. Collar lined with floral pattern fabric', 'Polo shirt with long sleeves. Model with a buttoned front. Collar lined with floral pattern fabric'),
('1', 'fr', 'Polo avec manches longues. Modèle disposant d’un boutonnée devant. Col doublé par un tissu à motif floral', 'Polo avec manches longues. Modèle disposant d’un boutonnée devant. Col doublé par un tissu à motif floral'),
('10', 'en', 'Soft top with round neckline. Short sleeves with decorative bow and buttons at the top.', 'Soft top with round neckline. Short sleeves with decorative bow and buttons at the top.'),
('10', 'fr', 'Haut doux avec encolure ronde. Manches courtes avec noeud décoratif et boutons sur le haut.', 'Haut doux avec encolure ronde. Manches courtes avec noeud décoratif et boutons sur le haut.'),
('101', 'en', 'Straight jeans flared slightly faded at the front. High waist model. Zipper topped with a button and front pockets. Belt loop.', 'Straight jeans flared slightly faded at the front. High waist model. Zipper topped with a button and front pockets. Belt loop.'),
('101', 'fr', 'Jeans droit évasé légèrement délavé à l’avant. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. ', 'Jeans droit évasé légèrement délavé à l’avant. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. '),
('102', 'en', 'Jeans close to the body, slightly faded at the front. Low waist model. Zipper topped with a button and front pockets. Belt loop.', 'Jeans close to the body, slightly faded at the front. Low waist model. Zipper topped with a button and front pockets. Belt loop.'),
('102', 'fr', 'Jeans prêt du corps, légèrement délavé à l’avant. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. ', 'Jeans prêt du corps, légèrement délavé à l’avant. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. '),
('104', 'en', 'Mid-length coat. Model with tailored collar, pockets and double buttoned front. Long sleeves. Warming fluffy lining.', 'Mid-length coat. Model with tailored collar, pockets and double buttoned front. Long sleeves. Warming fluffy lining.'),
('104', 'fr', 'Manteau mi-longue. Modèle à col tailleur, poches et double boutonnage devant. Manches longues. Doublure duveteuse réchauffante.', 'Manteau mi-longue. Modèle à col tailleur, poches et double boutonnage devant. Manches longues. Doublure duveteuse réchauffante.'),
('105', 'en', 'Long and transparent bathrobe with lace parts. Soft fabric model with short sleeves finished with scalloped edges. Ties to tie partially concealed at the waist.', 'Long and transparent bathrobe with lace parts. Soft fabric model with short sleeves finished with scalloped edges. Ties to tie partially concealed at the waist.'),
('105', 'fr', 'Robe de chambre long et transparente avec parties en dentelle. Modèle en tissu souple avec manches courtes terminées par des bords festonnés. Liens à nouer dissimulés partiellement au niveau de  la taille.', 'Robe de chambre long et transparente avec parties en dentelle. Modèle en tissu souple avec manches courtes terminées par des bords festonnés. Liens à nouer dissimulés partiellement au niveau de  la taille.'),
('106', 'en', 'Long cardigan in soft fine knit enriched with a touch of wool. Non-buttoned model with dropped shoulders and long sleeves. Fabric decorations on the front pockets and the middle of the sleeves.', 'Long cardigan in soft fine knit enriched with a touch of wool. Non-buttoned model with dropped shoulders and long sleeves. Fabric decorations on the front pockets and the middle of the sleeves.'),
('106', 'fr', 'Gilet long en douce maille fine enrichie d’une touche de laine. Modèle sans boutonnage avec emmanchure descendue et manches longues. Décorations en tissu sur les poches avant et le milieu des manches.', 'Gilet long en douce maille fine enrichie d’une touche de laine. Modèle sans boutonnage avec emmanchure descendue et manches longues. Décorations en tissu sur les poches avant et le milieu des manches.'),
('107', 'en', 'Short faux fur cardigan. Front hook closure. Without sleeves', 'Short faux fur cardigan. Front hook closure. Without sleeves'),
('107', 'fr', 'Gilet court en fausse fourrure. Fermeture avant en crochet. Sans manches', 'Gilet court en fausse fourrure. Fermeture avant en crochet. Sans manches'),
('108', 'en', 'Long patterned dress. Deep v-neckline and wide long sleeves. Large front slit and elasticated waist.', 'Long patterned dress. Deep v-neckline and wide long sleeves. Large front slit and elasticated waist.'),
('108', 'fr', 'Robe longue à motif. Encolure profonde en v et large manches longues. Grande fente à l’avant et élastique à la taille. ', 'Robe longue à motif. Encolure profonde en v et large manches longues. Grande fente à l’avant et élastique à la taille. '),
('109', 'en', 'Velvet overalls dress. Model with shoulder straps with metal fasteners. Pocket at top front. Cut out at the waist and A-line skirt with zipper on one side. Unlined.', 'Velvet overalls dress. Model with shoulder straps with metal fasteners. Pocket at top front. Cut out at the waist and A-line skirt with zipper on one side. Unlined.'),
('109', 'fr', 'Robe salopette en velours. Modèle avec bretelles munie d’attaches en métal. Poche en haut à l’avant. Découpe à la taille et jupe trapèze avec fermeture à glissière sur un côté. Non doublée.', 'Robe salopette en velours. Modèle avec bretelles munie d’attaches en métal. Poche en haut à l’avant. Découpe à la taille et jupe trapèze avec fermeture à glissière sur un côté. Non doublée.'),
('11', 'en', 'Top with design on the front, v-neckline and long sleeves.', 'Top with design on the front, v-neckline and long sleeves.'),
('11', 'fr', 'Haut avec dessin à l’avant, encolure en v et manches longues.', 'Haut avec dessin à l’avant, encolure en v et manches longues.'),
('110', 'en', 'Long straight dress. Model with thin straps to tie on the neck. Plunging neckline in the back, crossed by horizontal ties to tie. Slits on the sides. Doubled.', 'Long straight dress. Model with thin straps to tie on the neck. Plunging neckline in the back, crossed by horizontal ties to tie. Slits on the sides. Doubled.'),
('110', 'fr', 'Robe longue droite. Modèle avec fin bretelles à nouer sur le cou. Encolure plongeante dans le dos, traversée de liens à nouer horizontaux. Fentes sur les cotés. Doublée.', 'Robe longue droite. Modèle avec fin bretelles à nouer sur le cou. Encolure plongeante dans le dos, traversée de liens à nouer horizontaux. Fentes sur les cotés. Doublée.'),
('111', 'en', 'Long faux leather dress. Strapless model. Zipper at the back. Removable and adjustable belt at the waist.', 'Long faux leather dress. Strapless model. Zipper at the back. Removable and adjustable belt at the waist.'),
('111', 'fr', 'Robe longue en faux cuir. Modèle sans bretelles. Fermeture à glissière à l’arrière. Ceinture amovible et réglable à la taille.', 'Robe longue en faux cuir. Modèle sans bretelles. Fermeture à glissière à l’arrière. Ceinture amovible et réglable à la taille.'),
('112', 'en', 'Long and fitted dress. Soft, slightly shiny fabric. Square neckline at the front and v-neckline at the back. Model with thin straps.', 'Long and fitted dress. Soft, slightly shiny fabric. Square neckline at the front and v-neckline at the back. Model with thin straps.'),
('112', 'fr', 'Robe longue et ajustée. Tissu doux légèrement brillant. Encolure en carré à l’avant et en v à l\'arrière. Modèle à bretelles fines.', 'Robe longue et ajustée. Tissu doux légèrement brillant. Encolure en carré à l’avant et en v à l\'arrière. Modèle à bretelles fines.'),
('113', 'en', 'Short, fitted dress. Animal print fabric. Square neckline at the front. Model with thin straps, crossing the back in crossed lacing.', 'Short, fitted dress. Animal print fabric. Square neckline at the front. Model with thin straps, crossing the back in crossed lacing.'),
('113', 'fr', 'Robe courte et ajustée. Tissu à motif animalier. Encolure carré à l’avant. Modèle à fines bretelles, traversant le dos en laçage croisé.', 'Robe courte et ajustée. Tissu à motif animalier. Encolure carré à l’avant. Modèle à fines bretelles, traversant le dos en laçage croisé.'),
('114', 'en', 'Short straight dress with collar. Slightly transparent fluid fabric model with short sleeves. Zipper in the back.', 'Short straight dress with collar. Slightly transparent fluid fabric model with short sleeves. Zipper in the back.'),
('114', 'fr', 'Robe courte droite à col. Modèle à tissus fluide légèrement transparent avec manches courtes. Fermeture à glissière dans le dos.', 'Robe courte droite à col. Modèle à tissus fluide légèrement transparent avec manches courtes. Fermeture à glissière dans le dos.'),
('115', 'en', 'Slightly transparent fabric dress. Fitted model with one off the shoulder and long sleeve. Adjusted the size. Unlined.', 'Slightly transparent fabric dress. Fitted model with one off the shoulder and long sleeve. Adjusted the size. Unlined.'),
('115', 'fr', 'Robe en tissu légèrement transparente. Modèle ajusté avec une épaule dénudée et une manche longue. Ajusté la taille. Non doublée.', 'Robe en tissu légèrement transparente. Modèle ajusté avec une épaule dénudée et une manche longue. Ajusté la taille. Non doublée.'),
('116', 'en', 'Straight dress with buttoning at the front. Lightweight fabric with striped pattern. Model with collar and long sleeves.', 'Straight dress with buttoning at the front. Lightweight fabric with striped pattern. Model with collar and long sleeves.'),
('116', 'fr', 'Robe droite avec boutonnage à l\'avant. Tissu léger à motif rayé. Modèle avec col et manches longues.', 'Robe droite avec boutonnage à l\'avant. Tissu léger à motif rayé. Modèle avec col et manches longues.'),
('117', 'en', 'Straight and short dress. Model featuring long sleeves with ties to tie at the bottom. Lightweight solid color fabric. Round neckline.', 'Straight and short dress. Model featuring long sleeves with ties to tie at the bottom. Lightweight solid color fabric. Round neckline.'),
('117', 'fr', 'Robe droite et courte. Modèle disposant de longues manches avec liens à nouer sur le bas. Tissu léger à couleur uni. Encolure ronde.', 'Robe droite et courte. Modèle disposant de longues manches avec liens à nouer sur le bas. Tissu léger à couleur uni. Encolure ronde.'),
('118', 'en', 'Fitted and short dress. Model with long sleeves. Shiny and slightly transparent fabric. V-neckline.', 'Fitted and short dress. Model with long sleeves. Shiny and slightly transparent fabric. V-neckline.'),
('118', 'fr', 'Robe ajustée et courte. Modèle avec manches longues. Tissu brillant et légèrement transparent. Encolure en v.', 'Robe ajustée et courte. Modèle avec manches longues. Tissu brillant et légèrement transparent. Encolure en v.'),
('119', 'en', 'Bodycon and short dress. Model with long sleeves. Lightweight and soft slightly gathered fabric. Turtleneck.', 'Bodycon and short dress. Model with long sleeves. Lightweight and soft slightly gathered fabric. Turtleneck.'),
('119', 'fr', 'Robe moulante et courte. Modèle avec manches longues. Tissu léger et doux  légèrement froncé. Col roulé.', 'Robe moulante et courte. Modèle avec manches longues. Tissu léger et doux  légèrement froncé. Col roulé.'),
('12', 'en', 'Round neck tank top. Fitted model with lace trim around the neckline and armholes.', 'Round neck tank top. Fitted model with lace trim around the neckline and armholes.'),
('12', 'fr', 'Débardeur col rond. Modèle ajusté avec bord en dentelle autour de l\'encolure et des emmanchures.', 'Débardeur col rond. Modèle ajusté avec bord en dentelle autour de l\'encolure et des emmanchures.'),
('120', 'en', 'Long and fitted dress. Model featuring a long sheer fabric covered with small sparkly decorations and a short lining. V-neckline and open back with crossed straps. Concealed zipper at the back.', 'Long and fitted dress. Model featuring a long sheer fabric covered with small sparkly decorations and a short lining. V-neckline and open back with crossed straps. Concealed zipper at the back.'),
('120', 'fr', 'Robe longue et ajustée. Modèle disposant d’un long tissu transparent recouvert de petites décorations scintillant et d’une doublure courte. Encolure en v et dos nu avec bretelles croisées. Fermeture à glissière dissimulée à l’arrière.', 'Robe longue et ajustée. Modèle disposant d’un long tissu transparent recouvert de petites décorations scintillant et d’une doublure courte. Encolure en v et dos nu avec bretelles croisées. Fermeture à glissière dissimulée à l’arrière.'),
('121', 'en', 'Dress in thick fabric decorated with ruffles. Fitted model with a bare shoulder and long sleeve. Adjusted at the waist and featuring a large slit at the front. Zipper concealed on the side.', 'Dress in thick fabric decorated with ruffles. Fitted model with a bare shoulder and long sleeve. Adjusted at the waist and featuring a large slit at the front. Zipper concealed on the side.'),
('121', 'fr', 'Robe en tissu épais décorée de volants. Modèle ajusté avec une épaule nue et une manche longue. Ajusté la taille et disposant d’une grande fente à l’avant. Fermeture à glissière dissimulée sur le coté.', 'Robe en tissu épais décorée de volants. Modèle ajusté avec une épaule nue et une manche longue. Ajusté la taille et disposant d’une grande fente à l’avant. Fermeture à glissière dissimulée sur le coté.'),
('123', 'en', 'Fitted jumpsuit in soft fabric. Featuring a V-neckline and thin straps. Front slits along the legs with decorative flounce. Zipper concealed on the side.', 'Fitted jumpsuit in soft fabric. Featuring a V-neckline and thin straps. Front slits along the legs with decorative flounce. Zipper concealed on the side.'),
('123', 'fr', 'Combinaison ajustée en tissu souple. Modèle à encolure en V et fines bretelles. Fentes à l’avant le long des jambes avec volant décoratifs. Fermeture à glissière dissimulée sur le coté.', 'Combinaison ajustée en tissu souple. Modèle à encolure en V et fines bretelles. Fentes à l’avant le long des jambes avec volant décoratifs. Fermeture à glissière dissimulée sur le coté.'),
('124', 'en', 'Top in light, opaque, sleeveless fabrics. Features a v-neckline.', 'Top in light, opaque, sleeveless fabrics. Features a v-neckline.'),
('124', 'fr', 'Haut en tissus légers et opaque sans manches. Dispose d’une encolure en v. ', 'Haut en tissus légers et opaque sans manches. Dispose d’une encolure en v. '),
('125', 'en', 'Cropped top with short sleeves. Tie fastening in the form of lacing on the back and v-neckline.', 'Cropped top with short sleeves. Tie fastening in the form of lacing on the back and v-neckline.'),
('125', 'fr', 'Haut court à manches courtes. Fermeture à nouer sous forme de laçage sur le dos et encolure en v.', 'Haut court à manches courtes. Fermeture à nouer sous forme de laçage sur le dos et encolure en v.'),
('126', 'en', 'Top in light and opaque fabrics. Features a double neckline and sleeves in transparent fabrics with a lace effect.', 'Top in light and opaque fabrics. Features a double neckline and sleeves in transparent fabrics with a lace effect.'),
('126', 'fr', 'Haut en tissus légers et opaque. Dispose d’une encolure double et des manches en tissus transparents avec une effet dentelles. ', 'Haut en tissus légers et opaque. Dispose d’une encolure double et des manches en tissus transparents avec une effet dentelles. '),
('128', 'en', 'Solid color top. Features a turtleneck and long sleeves. Fabric decoration on the front with a knot decorated with a brooch.', 'Solid color top. Features a turtleneck and long sleeves. Fabric decoration on the front with a knot decorated with a brooch.'),
('128', 'fr', 'Haut à couleur uni. Dispose d’un col roulé et de manches longues. Décoration en tissu sur l’avant avec un noued orné d’une broche. ', 'Haut à couleur uni. Dispose d’un col roulé et de manches longues. Décoration en tissu sur l’avant avec un noued orné d’une broche. '),
('129', 'en', 'Solid color top. Features a turtleneck and long sleeves. Transparent and fluid fabric.', 'Solid color top. Features a turtleneck and long sleeves. Transparent and fluid fabric.'),
('129', 'fr', 'Haut à couleur uni. Dispose d’un col roulé et des manches longues. Tissu transparent et fluide.', 'Haut à couleur uni. Dispose d’un col roulé et des manches longues. Tissu transparent et fluide.'),
('13', 'en', 'Top with design and lettering on the front. Features a round neckline and long sleeves. Thick and soft fabrics.', 'Top with design and lettering on the front. Features a round neckline and long sleeves. Thick and soft fabrics.'),
('13', 'fr', 'Haut avec dessin et inscription à l’avant. Dispose d’un encolure rond et des manches longues. Tissus épais et doux.', 'Haut avec dessin et inscription à l’avant. Dispose d’un encolure rond et des manches longues. Tissus épais et doux.'),
('131', 'en', 'Solid color top. Features a turtleneck and long sleeves. Soft woolen fabric.', 'Solid color top. Features a turtleneck and long sleeves. Soft woolen fabric.'),
('131', 'fr', 'Haut à couleur uni. Dispose d’un col roulé et des manches longues. Tissu en laine doux.', 'Haut à couleur uni. Dispose d’un col roulé et des manches longues. Tissu en laine doux.'),
('132', 'en', 'Turtleneck sweater in soft ribbed knit. Square model with dropped armholes and long straight sleeves. Geometric pattern.', 'Turtleneck sweater in soft ribbed knit. Square model with dropped armholes and long straight sleeves. Geometric pattern.'),
('132', 'fr', 'Pull col roulé en douce maille côtelée. Modèle carré avec emmanchures descendues et manches longues et droites. Motif géométrique.', 'Pull col roulé en douce maille côtelée. Modèle carré avec emmanchures descendues et manches longues et droites. Motif géométrique.'),
('133', 'en', 'Short sweatshirt in lightweight fabric. Relaxed fit with decorative line on the side of the long sleeves. Soft, brushed interior.', 'Short sweatshirt in lightweight fabric. Relaxed fit with decorative line on the side of the long sleeves. Soft, brushed interior.'),
('133', 'fr', 'Sweat-shirt court en tissu léger. Coupe décontractée avec ligne décoratives sur le coté des manches longues. Intérieur doux et brossé.', 'Sweat-shirt court en tissu léger. Coupe décontractée avec ligne décoratives sur le coté des manches longues. Intérieur doux et brossé.'),
('134', 'en', 'Soft thick knit sweater. Featuring a ribbed knit finish at the neckline, the bottom and long sleeves.', 'Soft thick knit sweater. Featuring a ribbed knit finish at the neckline, the bottom and long sleeves.'),
('134', 'fr', 'Pull en douce maille épaisse. Modèle avec finition en maille côtelée à l\'encolure, à la base et des manches longues.', 'Pull en douce maille épaisse. Modèle avec finition en maille côtelée à l\'encolure, à la base et des manches longues.'),
('135', 'en', 'Soft and fluffy faux fur sweater. Zippered front design for a turtleneck or v-neck. Long sleeves.', 'Soft and fluffy faux fur sweater. Zippered front design for a turtleneck or v-neck. Long sleeves.'),
('135', 'fr', 'Pull en fausse fourrure douce et duveteuse. Modèle avec fermeture à glissière à l’avant permettant d’avoir un col roulé ou un col en v. Manches longues. ', 'Pull en fausse fourrure douce et duveteuse. Modèle avec fermeture à glissière à l’avant permettant d’avoir un col roulé ou un col en v. Manches longues. '),
('136', 'en', 'Heavyweight fabric hoodie. Model with lined hood and provided with a drawstring. Kangaroo pocket on the front. Ribbed finish at the hem and bottom of the long sleeves. Soft, brushed interior.', 'Heavyweight fabric hoodie. Model with lined hood and provided with a drawstring. Kangaroo pocket on the front. Ribbed finish at the hem and bottom of the long sleeves. Soft, brushed interior.'),
('136', 'fr', 'Sweat à capuche en tissu épais. Modèle avec capuche doublée et munie d\'un lien de serrage. Poche kangourou devant. Finition bord-côte à la base et en bas des manches longues. Intérieur doux et brossé.', 'Sweat à capuche en tissu épais. Modèle avec capuche doublée et munie d\'un lien de serrage. Poche kangourou devant. Finition bord-côte à la base et en bas des manches longues. Intérieur doux et brossé.'),
('137', 'en', 'Short hoodie in fine fabric. Model with lined hood and provided with a drawstring. Decorative hole on one shoulder at the front.', 'Short hoodie in fine fabric. Model with lined hood and provided with a drawstring. Decorative hole on one shoulder at the front.'),
('137', 'fr', 'Sweat à capuche court en tissu fin. Modèle avec capuche doublée et munie d\'un lien de serrage. Troue décoratif sur une épaule à l’avant.', 'Sweat à capuche court en tissu fin. Modèle avec capuche doublée et munie d\'un lien de serrage. Troue décoratif sur une épaule à l’avant.'),
('138', 'en', 'Heavyweight hoodie with lettering on the front. Model with lined hood and provided with a drawstring. Kangaroo pocket on the front. Ribbed finish at the hem and bottom of the long sleeves. Soft, brushed interior.', 'Heavyweight hoodie with lettering on the front. Model with lined hood and provided with a drawstring. Kangaroo pocket on the front. Ribbed finish at the hem and bottom of the long sleeves. Soft, brushed interior.'),
('138', 'fr', 'Sweat à capuche en tissu épais avec inscription à l’avant. Modèle avec capuche doublée et munie d\'un lien de serrage. Poche kangourou devant. Finition bord-côte à la base et en bas des manches longues. Intérieur doux et brossé.', 'Sweat à capuche en tissu épais avec inscription à l’avant. Modèle avec capuche doublée et munie d\'un lien de serrage. Poche kangourou devant. Finition bord-côte à la base et en bas des manches longues. Intérieur doux et brossé.'),
('14', 'en', 'Striped pattern top with round neckline and 3/4 sleeves.', 'Striped pattern top with round neckline and 3/4 sleeves.'),
('14', 'fr', 'Haut à motif rayé avec encolure ronde et manches 3/4. ', 'Haut à motif rayé avec encolure ronde et manches 3/4. '),
('141', 'en', 'Flared jeans. High waist model. Zipper topped with a button and front pockets. Ties to tie at the waist. Belt loop.', 'Flared jeans. High waist model. Zipper topped with a button and front pockets. Ties to tie at the waist. Belt loop.'),
('141', 'fr', 'Jeans évasé. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Liens à nouer au niveau de la taille. Passant à ceinture. ', 'Jeans évasé. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Liens à nouer au niveau de la taille. Passant à ceinture. '),
('142', 'en', 'Stretchy and slightly transparent cyclist. Model with elastic at the waist.', 'Stretchy and slightly transparent cyclist. Model with elastic at the waist.'),
('142', 'fr', 'Cycliste extensible et légèrement transparent. Modele avec élastique à la taille.  ', 'Cycliste extensible et légèrement transparent. Modele avec élastique à la taille.  '),
('144', 'en', 'Shorts in fine fabric. Short model with zipped fly on the side, side pockets.', 'Shorts in fine fabric. Short model with zipped fly on the side, side pockets.'),
('144', 'fr', 'Short en tissu fin. Modèle court avec braguette zippée sur le coté, poches latérales.', 'Short en tissu fin. Modèle court avec braguette zippée sur le coté, poches latérales.'),
('146', 'en', 'Bias fitted shorts. High waist model with dressy elastic. Rounded edges at the bottom of the leg. Fabric with a slightly satin effect.', 'Bias fitted shorts. High waist model with dressy elastic. Rounded edges at the bottom of the leg. Fabric with a slightly satin effect.'),
('146', 'fr', 'Short ajusté en biais. Modèle taille haute avec élastique habillé. Bords arrondis en bas de jambe. Tissu avec un effet légèrement satiné. ', 'Short ajusté en biais. Modèle taille haute avec élastique habillé. Bords arrondis en bas de jambe. Tissu avec un effet légèrement satiné. '),
('147', 'en', 'Striped shorts. High waist model with a tie belt. Pleats lying in front and elastic in the back. Side pockets.', 'Striped shorts. High waist model with a tie belt. Pleats lying in front and elastic in the back. Side pockets.'),
('147', 'fr', 'Short à rayure. Modèle taille haute avec ceinture à nouer. Plis couchés devant et élastique dans le dos. Poches latérales.', 'Short à rayure. Modèle taille haute avec ceinture à nouer. Plis couchés devant et élastique dans le dos. Poches latérales.'),
('148', 'en', 'Short skirt with geometric pattern. Zipper at the front.', 'Short skirt with geometric pattern. Zipper at the front.'),
('148', 'fr', 'Jupe courte à motif géométrique. Fermeture éclair à l’avant. ', 'Jupe courte à motif géométrique. Fermeture éclair à l’avant. '),
('15', 'en', 'Crochet blouse. Round neckline and 3/4 sleeves. Model with wavy edges at the sleeves and at the hem.', 'Crochet blouse. Round neckline and 3/4 sleeves. Model with wavy edges at the sleeves and at the hem.'),
('15', 'fr', 'Blouse en crochet. Encolure rond et manches 3/4. Modèle  avec bords ondulés au niveau des manches et à la base.', 'Blouse en crochet. Encolure rond et manches 3/4. Modèle  avec bords ondulés au niveau des manches et à la base.'),
('16', 'en', 'Bodycon top with v-neck and long sleeves. Model with solid color.', 'Bodycon top with v-neck and long sleeves. Model with solid color.'),
('16', 'fr', 'Haut moulant avec col v et manches longues. Modèle avec couleur uni. ', 'Haut moulant avec col v et manches longues. Modèle avec couleur uni. '),
('17', 'en', 'Top with decorative buttons at the front, v-neckline and long sleeves. Fabric drawing on the back. Light and airy fabric.', 'Top with decorative buttons at the front, v-neckline and long sleeves. Fabric drawing on the back. Light and airy fabric.'),
('17', 'fr', 'Haut avec boutons décoratif à l’avant, encolure en v et manches longues. Dessin en tissu à l’arrière. Tissu léger et aérien.', 'Haut avec boutons décoratif à l’avant, encolure en v et manches longues. Dessin en tissu à l’arrière. Tissu léger et aérien.'),
('18', 'en', 'Top in soft-knit fabric, v-neck and 3/4 sleeves.', 'Top in soft-knit fabric, v-neck and 3/4 sleeves.'),
('18', 'fr', 'Haut à tissu en maille douce, encolure en v et manches 3/4.', 'Haut à tissu en maille douce, encolure en v et manches 3/4.'),
('19', 'en', 'Cropped top with short sleeves. Tie back closure and v-neckline.', 'Cropped top with short sleeves. Tie back closure and v-neckline.'),
('19', 'fr', 'Haut court à manches courtes. Fermeture à nouer dans le dos et encolure en v.', 'Haut court à manches courtes. Fermeture à nouer dans le dos et encolure en v.'),
('2', 'en', 'Mesh top with long batwing sleeves. Soft and light fabric.', 'Mesh top with long batwing sleeves. Soft and light fabric.'),
('2', 'fr', 'Haut en maille avec longues manches chauve-souris. Tissu doux et léger.', 'Haut en maille avec longues manches chauve-souris. Tissu doux et léger.'),
('20', 'en', 'Soft top with round neckline and long sleeves.', 'Soft top with round neckline and long sleeves.'),
('20', 'fr', 'Haut souple avec encolure ronde et manches longues. ', 'Haut souple avec encolure ronde et manches longues. '),
('21', 'en', 'Soft top with round neckline and short sleeves. Decorative opening at the front and inscription in various locations.', 'Soft top with round neckline and short sleeves. Decorative opening at the front and inscription in various locations.'),
('21', 'fr', 'Haut souple avec encolure ronde et manches courtes. Ouverture décorative à l’avant et inscription à divers emplacement.', 'Haut souple avec encolure ronde et manches courtes. Ouverture décorative à l’avant et inscription à divers emplacement.'),
('22', 'en', 'Shiny textured fabric blouse. Featuring a concealed back button fastening at the top and a round neckline. Embellished with ruffles all the way down and short sleeves.', 'Shiny textured fabric blouse. Featuring a concealed back button fastening at the top and a round neckline. Embellished with ruffles all the way down and short sleeves.'),
('22', 'fr', 'Blouse en tissu texturé à l’aspect brillant. Modèle avec boutonnage arrière dissimulé en haut et encolure rond. Agrémenté de volants se prolongeant tous le long et des manches courtes.', 'Blouse en tissu texturé à l’aspect brillant. Modèle avec boutonnage arrière dissimulé en haut et encolure rond. Agrémenté de volants se prolongeant tous le long et des manches courtes.'),
('23', 'en', 'Chunky knit top with round neckline.', 'Chunky knit top with round neckline.'),
('23', 'fr', 'Haut tricoté à grosse maille avec encolure rond.', 'Haut tricoté à grosse maille avec encolure rond.'),
('24', 'en', 'Fitted shirt with v-neck. Buttoned front and short, slightly puffed sleeves', 'Fitted shirt with v-neck. Buttoned front and short, slightly puffed sleeves'),
('24', 'fr', 'Chemise ajusté avec col en v. Boutonnage avant et manches courtes légèrement bouffantes', 'Chemise ajusté avec col en v. Boutonnage avant et manches courtes légèrement bouffantes'),
('25', 'en', 'Straight top with V-neckline at the front. Soft striped fabric. Short-sleeved model.', 'Straight top with V-neckline at the front. Soft striped fabric. Short-sleeved model.'),
('25', 'fr', 'Haut droit à encolure en V à l’avant. Tissu doux à motif rayé. Modèle à manches courtes. ', 'Haut droit à encolure en V à l’avant. Tissu doux à motif rayé. Modèle à manches courtes. '),
('27', 'en', 'Short puff-sleeved peplum top with epaulettes and button fastening at the end. Model with square neckline, front button fastening and thick stiff quilted fabric.', 'Short puff-sleeved peplum top with epaulettes and button fastening at the end. Model with square neckline, front button fastening and thick stiff quilted fabric.'),
('27', 'fr', 'Haut péplum à manches courtes bouffantes avec épaulettes et boutonnages sur la fin. Modèle avec encolure carré, boutonnage avant et tissu matelassé épais et rigide.', 'Haut péplum à manches courtes bouffantes avec épaulettes et boutonnages sur la fin. Modèle avec encolure carré, boutonnage avant et tissu matelassé épais et rigide.'),
('28', 'en', 'Oversized woven jacket. Model with a lapel collar and a button front. Real pockets on the sides and integrated shoulder pads.', 'Oversized woven jacket. Model with a lapel collar and a button front. Real pockets on the sides and integrated shoulder pads.'),
('28', 'fr', 'Veste oversize tissé. Modèle avec col à revers et un bouton à l’avant. Vrai poches sur les cotés et épaulettes intégrées.', 'Veste oversize tissé. Modèle avec col à revers et un bouton à l’avant. Vrai poches sur les cotés et épaulettes intégrées.'),
('29', 'en', 'Fitted and short dress. Sleeveless model. Lightweight fabric with geometric pattern play on the front. Round neckline.', 'Fitted and short dress. Sleeveless model. Lightweight fabric with geometric pattern play on the front. Round neckline.'),
('29', 'fr', 'Robe ajustée et courte. Modèle sans manches. Tissu léger avec jeux de motif géométrique à l’avant. Encolure ronde.', 'Robe ajustée et courte. Modèle sans manches. Tissu léger avec jeux de motif géométrique à l’avant. Encolure ronde.'),
('3', 'en', 'Mid-calf length dress. Model with braided decorations around the neckline. Short sleeves and elastic at the waist.', 'Mid-calf length dress. Model with braided decorations around the neckline. Short sleeves and elastic at the waist.'),
('3', 'fr', 'Robe de longueur mi-mollet. Modèle avec décorations tressées autour de l’encolure. Manches courtes et élastique à la taille.', 'Robe de longueur mi-mollet. Modèle avec décorations tressées autour de l’encolure. Manches courtes et élastique à la taille.'),
('30', 'en', 'Long-sleeved top in soft, thick fabric. Featuring a V-neckline and button fastening at the front on the top.', 'Long-sleeved top in soft, thick fabric. Featuring a V-neckline and button fastening at the front on the top.'),
('30', 'fr', 'Haut à manches longues en tissu doux et épais. Modèle avec encolure en V et boutonnage à l’avant sur le haut.', 'Haut à manches longues en tissu doux et épais. Modèle avec encolure en V et boutonnage à l’avant sur le haut.'),
('31', 'en', 'Top in satin-effect fabric with geometric print pattern. Detail of fake pocket with fabric handkerchief.', 'Top in satin-effect fabric with geometric print pattern. Detail of fake pocket with fabric handkerchief.'),
('31', 'fr', 'Haut en tissu à effet satiné avec motif imprimé géométrique. Détail de fausse poche avec mouchoir en tissu. ', 'Haut en tissu à effet satiné avec motif imprimé géométrique. Détail de fausse poche avec mouchoir en tissu. '),
('32', 'en', 'Straight dress with buttoning on the side. Rigid fabric with striped pattern. Pockets at the front. Model with sleeveless square neckline.', 'Straight dress with buttoning on the side. Rigid fabric with striped pattern. Pockets at the front. Model with sleeveless square neckline.'),
('32', 'fr', 'Robe droite avec boutonnage sur le coté. Tissu rigide à motif rayé. Poches à l’avant. Modèle avec encolure carré sans manches.', 'Robe droite avec boutonnage sur le coté. Tissu rigide à motif rayé. Poches à l’avant. Modèle avec encolure carré sans manches.'),
('33', 'en', 'Straight dress with buttoned front. Lightweight fabric with floral pattern. Pockets at the front. Model with round neckline and short sleeves.', 'Straight dress with buttoned front. Lightweight fabric with floral pattern. Pockets at the front. Model with round neckline and short sleeves.'),
('33', 'fr', 'Robe droite avec boutonnage à l’avant. Tissu léger à motif floral. Poches à l’avant. Modèle avec encolure ronde et manches courtes.', 'Robe droite avec boutonnage à l’avant. Tissu léger à motif floral. Poches à l’avant. Modèle avec encolure ronde et manches courtes.'),
('34', 'en', 'Short dress with a double collar. Button fastening and front pockets. Short sleeves.', 'Short dress with a double collar. Button fastening and front pockets. Short sleeves.'),
('34', 'fr', 'Robe courte avec un double col. Boutonnage et poches à l’avant. Manches courtes.', 'Robe courte avec un double col. Boutonnage et poches à l’avant. Manches courtes.'),
('35', 'en', 'Short dress fitted at the waist with a buttoning at the front. V-neck surrounded by embroidery. Short sleeves with shoulder pads.', 'Short dress fitted at the waist with a buttoning at the front. V-neck surrounded by embroidery. Short sleeves with shoulder pads.'),
('35', 'fr', 'Robe courte ajusté au niveau de la taille avec un boutonnage à l’avant. Encolure en v entouré de broderie. Manches courtes avec épaulettes. ', 'Robe courte ajusté au niveau de la taille avec un boutonnage à l’avant. Encolure en v entouré de broderie. Manches courtes avec épaulettes. '),
('36', 'en', 'Long straight sleeveless dress. Square neckline. Airy and opaque fabric. Model with zipper at the back.', 'Long straight sleeveless dress. Square neckline. Airy and opaque fabric. Model with zipper at the back.'),
('36', 'fr', 'Robe longue droite sans manches. Encolure carré. Tissu aérien et opaque. Modèle avec fermeture éclair à l’arrière.', 'Robe longue droite sans manches. Encolure carré. Tissu aérien et opaque. Modèle avec fermeture éclair à l’arrière.'),
('37', 'en', 'Top with drawing and lettering on the front. Features a round neckline and short sleeves.', 'Top with drawing and lettering on the front. Features a round neckline and short sleeves.'),
('37', 'fr', 'Haut avec dessin et inscription à l’avant. Dispose d’un encolure rond et des manches courtes.', 'Haut avec dessin et inscription à l’avant. Dispose d’un encolure rond et des manches courtes.'),
('38', 'en', 'Top with lettering on the front. Features a round neckline and short sleeves.', 'Top with lettering on the front. Features a round neckline and short sleeves.'),
('38', 'fr', 'Haut avec inscription à l’avant. Dispose d’un encolure rond et des manches courtes.', 'Haut avec inscription à l’avant. Dispose d’un encolure rond et des manches courtes.'),
('39', 'en', 'Striped pattern top with v-neck and long sleeves. Model with a small pocket at the front.', 'Striped pattern top with v-neck and long sleeves. Model with a small pocket at the front.'),
('39', 'fr', 'Haut à motif rayé avec encolure en v et manches longues. Modèle avec une petite poche à l’avant. ', 'Haut à motif rayé avec encolure en v et manches longues. Modèle avec une petite poche à l’avant. '),
('4', 'en', 'Wide neck top with bare shoulders. Long sleeves with ties to tie down. Lightweight fabric with floral and striped pattern.', 'Wide neck top with bare shoulders. Long sleeves with ties to tie down. Lightweight fabric with floral and striped pattern.'),
('4', 'fr', 'Haut à encolure large avec les épaules dénudée. Manches longues avec liens à nouer vers le bas. Tissu léger à motif florale et rayé. ', 'Haut à encolure large avec les épaules dénudée. Manches longues avec liens à nouer vers le bas. Tissu léger à motif florale et rayé. '),
('40', 'en', 'Top with floral pattern. Features a round neckline and long sleeves.', 'Top with floral pattern. Features a round neckline and long sleeves.'),
('40', 'fr', 'Haut à motif floral. Dispose d’un encolure rond et des manches longues.', 'Haut à motif floral. Dispose d’un encolure rond et des manches longues.'),
('41', 'en', 'Solid color top. Features a round neckline and short sleeves.', 'Solid color top. Features a round neckline and short sleeves.'),
('41', 'fr', 'Haut de couleur uni. Dispose d’un encolure rond et des manches courtes.', 'Haut de couleur uni. Dispose d’un encolure rond et des manches courtes.'),
('42', 'en', 'Top with lettering on the front. Features an off-the-shoulder neckline with short sleeves.', 'Top with lettering on the front. Features an off-the-shoulder neckline with short sleeves.'),
('42', 'fr', 'Haut avec inscription à l’avant. Dispose d’une encolure à épaules dénudées de manches courtes.', 'Haut avec inscription à l’avant. Dispose d’une encolure à épaules dénudées de manches courtes.'),
('43', 'en', 'Airy fabric shirt with mao collar. Button fastening and front pockets. Long sleeves.', 'Airy fabric shirt with mao collar. Button fastening and front pockets. Long sleeves.'),
('43', 'fr', 'Chemise en tissu aérien avec col mao. Boutonnage et poches à l’avant. Longues manches.', 'Chemise en tissu aérien avec col mao. Boutonnage et poches à l’avant. Longues manches.'),
('44', 'en', 'Striped pattern top with round neckline and long sleeves.', 'Striped pattern top with round neckline and long sleeves.'),
('44', 'fr', 'Haut à motif rayé avec encolure rond et manches longues. ', 'Haut à motif rayé avec encolure rond et manches longues. '),
('45', 'en', 'Short dress with collar. Buttoned at the front. 3/4 sleeves with shoulder pads. Satin effect fabric. With a decorative front cutout at the bottom.', 'Short dress with collar. Buttoned at the front. 3/4 sleeves with shoulder pads. Satin effect fabric. With a decorative front cutout at the bottom.'),
('45', 'fr', 'Robe courte avec col. Boutonnage à l’avant. Manches 3/4 avec épaulettes. Tissu à effet satiné. Disposants sur la face avant d’une découpage décoratif sur le bas.', 'Robe courte avec col. Boutonnage à l’avant. Manches 3/4 avec épaulettes. Tissu à effet satiné. Disposants sur la face avant d’une découpage décoratif sur le bas.'),
('46', 'en', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.'),
('46', 'fr', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.'),
('47', 'en', 'Polo shirt with long sleeves. Model with front button fastening. Collar lined with floral pattern fabric', 'Polo shirt with long sleeves. Model with front button fastening. Collar lined with floral pattern fabric'),
('47', 'fr', 'Polo avec manches longues. Modèle disposant d’un boutonnage avant. Col doublé par un tissu à motif floral  ', 'Polo avec manches longues. Modèle disposant d’un boutonnage avant. Col doublé par un tissu à motif floral  '),
('48', 'en', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.'),
('48', 'fr', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.'),
('49', 'en', 'Solid color top. Features a round neckline and long sleeves. Model with an oversized effect.', 'Solid color top. Features a round neckline and long sleeves. Model with an oversized effect.'),
('49', 'fr', 'Haut de couleur uni. Dispose d’un encolure rond et des manches longues. Modèle avec un effet oversize.', 'Haut de couleur uni. Dispose d’un encolure rond et des manches longues. Modèle avec un effet oversize.'),
('5', 'en', 'Soft solid color top with round neckline and long sleeves.', 'Soft solid color top with round neckline and long sleeves.'),
('5', 'fr', 'Haut souple à couleur uni, avec encolure ronde et manches longues. ', 'Haut souple à couleur uni, avec encolure ronde et manches longues. '),
('50', 'en', 'Solid color tight top. Features a round neckline and long sleeves.', 'Solid color tight top. Features a round neckline and long sleeves.'),
('50', 'fr', 'Haut moulant de couleur uni. Dispose d’un encolure rond et des manches longues.', 'Haut moulant de couleur uni. Dispose d’un encolure rond et des manches longues.'),
('51', 'en', 'Soft, fluffy knit sweater with long sleeves. Round neckline surrounded by a golden chain.', 'Soft, fluffy knit sweater with long sleeves. Round neckline surrounded by a golden chain.'),
('51', 'fr', 'Pull en maille douce et duveteux avec longues manches. Encolure ronde entouré d’une chaine de couleur dorée. ', 'Pull en maille douce et duveteux avec longues manches. Encolure ronde entouré d’une chaine de couleur dorée. '),
('52', 'en', 'Short-sleeved peplum top with round neckline. Discreet floral pattern fabric with a satin effect.', 'Short-sleeved peplum top with round neckline. Discreet floral pattern fabric with a satin effect.'),
('52', 'fr', 'Haut péplum à manches courtes avec encolure ronde. Tissu à motif floral discret avec un effet satiné. ', 'Haut péplum à manches courtes avec encolure ronde. Tissu à motif floral discret avec un effet satiné. '),
('53', 'en', 'Oversized woven jacket. Model with collar, square shoulders and front buttoning. Thick and rigid fabrics.', 'Oversized woven jacket. Model with collar, square shoulders and front buttoning. Thick and rigid fabrics.'),
('53', 'fr', 'Veste oversize tissé. Modèle avec col, épaules carrées et boutonnage avant. Tissus épais et rigide. ', 'Veste oversize tissé. Modèle avec col, épaules carrées et boutonnage avant. Tissus épais et rigide. '),
('55', 'en', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.', 'Solid color top with inscriptions and drawings on the front. Features a round neckline and long sleeves.'),
('55', 'fr', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.', 'Haut à couleur uni avec inscriptions et dessins à l\'avant. Dispose d’une encolure ronde et des manches longues.'),
('56', 'en', 'Top adorned with small cylindrical rhinestones. V-neck and long sleeves. Front zipper. Model with wavy edge at the sleeves and the bottom.', 'Top adorned with small cylindrical rhinestones. V-neck and long sleeves. Front zipper. Model with wavy edge at the sleeves and the bottom.'),
('56', 'fr', 'Haut orné de petit strass à forme cylindrique. Col en v et longues manches. Tirette avant. Modèle  avec bord ondulé au niveau des manches et de la base.', 'Haut orné de petit strass à forme cylindrique. Col en v et longues manches. Tirette avant. Modèle  avec bord ondulé au niveau des manches et de la base.'),
('57', 'en', 'Soft, fluffy knit sweater with long sleeves. Round neckline.', 'Soft, fluffy knit sweater with long sleeves. Round neckline.'),
('57', 'fr', 'Pull en maille douce et duveteux avec longues manches. Encolure ronde. ', 'Pull en maille douce et duveteux avec longues manches. Encolure ronde. '),
('58', 'en', 'Top in soft, slightly sheer fabric. Model with twisted fabric decoration. Round neckline and long sleeves.', 'Top in soft, slightly sheer fabric. Model with twisted fabric decoration. Round neckline and long sleeves.'),
('58', 'fr', 'Haut en tissu doux et légèrement transparent. Modèle avec décoration en tissu torsadé. Encolure ronde et longues manches. ', 'Haut en tissu doux et légèrement transparent. Modèle avec décoration en tissu torsadé. Encolure ronde et longues manches. '),
('59', 'en', 'Airy fabric shirt with mao collar. Buttoned front. Long sleeves. Fabric with floral pattern.', 'Airy fabric shirt with mao collar. Buttoned front. Long sleeves. Fabric with floral pattern.'),
('59', 'fr', 'Chemise en tissu aérien avec col mao. Boutonnage à l’avant. Longues manches. Tissu à motif floral. ', 'Chemise en tissu aérien avec col mao. Boutonnage à l’avant. Longues manches. Tissu à motif floral. '),
('6', 'en', 'Mid-calf length dress with shiny rhinestones with lining. Fitted model with square neckline at the front and at the back. Decorative ruffles at the end of the dress.', 'Mid-calf length dress with shiny rhinestones with lining. Fitted model with square neckline at the front and at the back. Decorative ruffles at the end of the dress.'),
('6', 'fr', 'Robe de longueur mi-mollet à strass très brillant avec doublure. Modèle ajusté avec encolure carrée devant et dans le dos. Volants décoratifs en fin de robe.', 'Robe de longueur mi-mollet à strass très brillant avec doublure. Modèle ajusté avec encolure carrée devant et dans le dos. Volants décoratifs en fin de robe.'),
('61', 'en', 'Top with design and lettering on the front. Features a round neckline and short sleeves.', 'Top with design and lettering on the front. Features a round neckline and short sleeves.'),
('61', 'fr', 'Haut avec dessin et inscription à l’avant. Dispose d’une encolure ronde et des manches courtes.', 'Haut avec dessin et inscription à l’avant. Dispose d’une encolure ronde et des manches courtes.'),
('62', 'en', 'Top with glitter lettering on the front. Features a round neckline and long sleeves.', 'Top with glitter lettering on the front. Features a round neckline and long sleeves.'),
('62', 'fr', 'Haut avec inscription à paillettes sur l’avant. Dispose d’une encolure ronde et des manches longues.', 'Haut avec inscription à paillettes sur l’avant. Dispose d’une encolure ronde et des manches longues.'),
('64', 'en', 'Mid-length and flared skirt. High waist with concealed zipper at the back. Lightweight patterned fabric.', 'Mid-length and flared skirt. High waist with concealed zipper at the back. Lightweight patterned fabric.'),
('64', 'fr', 'Jupe mi-longue et évasée. Taille haute avec fermeture à glissière dissimulée à l\'arrière. Tissu léger à motif. ', 'Jupe mi-longue et évasée. Taille haute avec fermeture à glissière dissimulée à l\'arrière. Tissu léger à motif. '),
('65', 'en', 'Long flared skirt with several different fabrics. High waist underlined by an elastic. Lace border.', 'Long flared skirt with several different fabrics. High waist underlined by an elastic. Lace border.'),
('65', 'fr', 'Jupe longue évasée avec plusieurs tissus differents. Taille haute soulignée par un élastique. Bordure en dentelle. ', 'Jupe longue évasée avec plusieurs tissus differents. Taille haute soulignée par un élastique. Bordure en dentelle. '),
('66', 'en', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.'),
('66', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.'),
('67', 'en', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.'),
('67', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.'),
('68', 'en', 'Mid-length flared skirt. High-waisted model with a slim removable belt and full-length front button fastening.', 'Mid-length flared skirt. High-waisted model with a slim removable belt and full-length front button fastening.'),
('68', 'fr', 'Jupe évasée mi-longue. Modèle taille haute avec fine ceinture amovible et boutonnage avant sur toutes la longueur.', 'Jupe évasée mi-longue. Modèle taille haute avec fine ceinture amovible et boutonnage avant sur toutes la longueur.'),
('69', 'en', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.'),
('69', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.'),
('7', 'en', 'Cropped top with square neckline. Rigid fabrics. Model with front button fastening and short sleeves.', 'Cropped top with square neckline. Rigid fabrics. Model with front button fastening and short sleeves.'),
('7', 'fr', 'Haut court à encolure carré. Tissus rigide. Modèle disposant d’un boutonnage avant et des manches courtes.', 'Haut court à encolure carré. Tissus rigide. Modèle disposant d’un boutonnage avant et des manches courtes.');
INSERT INTO `ProductsDescriptions` (`prodId`, `lang_`, `description`, `richDescription`) VALUES
('70', 'en', 'Long flared skirt with slightly ruched fabric. High waist model with elasticated waist.', 'Long flared skirt with slightly ruched fabric. High waist model with elasticated waist.'),
('70', 'fr', 'Jupe évasée longue à tissu légèrement froncé. Modèle taille haute avec élastique à la taille.  ', 'Jupe évasée longue à tissu légèrement froncé. Modèle taille haute avec élastique à la taille.  '),
('71', 'en', 'Mid-length woven skirt, fitted at the top, with ruched cutout at the hem. High-waisted model with a concealed zip fastening to the back. Unlined.', 'Mid-length woven skirt, fitted at the top, with ruched cutout at the hem. High-waisted model with a concealed zip fastening to the back. Unlined.'),
('71', 'fr', 'Jupe tissée mi-longue, ajustée en haut, avec découpe froncée au niveau de la base. Modèle taille haute avec fermeture à glissière dissimulée à arrière. Non doublée.', 'Jupe tissée mi-longue, ajustée en haut, avec découpe froncée au niveau de la base. Modèle taille haute avec fermeture à glissière dissimulée à arrière. Non doublée.'),
('72', 'en', 'Short flared skirt with asymmetric edge. High waist model with elasticated waist.', 'Short flared skirt with asymmetric edge. High waist model with elasticated waist.'),
('72', 'fr', 'Jupe courte évasée à bord asymétrique. Modèle taille haute avec élastique à la taille.', 'Jupe courte évasée à bord asymétrique. Modèle taille haute avec élastique à la taille.'),
('73', 'en', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.'),
('73', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos'),
('74', 'en', 'Short, flared skirt. High waist model with elasticated waist. Gathered cut at mid-height for fullness at the hem. Unlined.', 'Short, flared skirt. High waist model with elasticated waist. Gathered cut at mid-height for fullness at the hem. Unlined.'),
('74', 'fr', 'Jupe courte et évasée. Modèle taille haute avec élastique à la taille. Découpe froncée à mi-hauteur pour plus d’ampleur à la base. Non doublée.', 'Jupe courte et évasée. Modèle taille haute avec élastique à la taille. Découpe froncée à mi-hauteur pour plus d’ampleur à la base. Non doublée.'),
('75', 'en', 'Mid-length flared skirt with asymmetric edge. High waist model with elasticated waist. Patterned fabric.', 'Mid-length flared skirt with asymmetric edge. High waist model with elasticated waist. Patterned fabric.'),
('75', 'fr', 'Jupe mi-longue évasée à bord asymétrique. Modèle taille haute avec élastique à la taille. Tissu à motif.', 'Jupe mi-longue évasée à bord asymétrique. Modèle taille haute avec élastique à la taille. Tissu à motif.'),
('76', 'en', 'Mid-calf length skirt in pleated fabric. High waist model with elastic. Shiny effect fabric.', 'Mid-calf length skirt in pleated fabric. High waist model with elastic. Shiny effect fabric.'),
('76', 'fr', 'Jupe de longueur mi-mollet en tissu plissé. Modèle taille haute avec élastique.Tissu à effet brillant. ', 'Jupe de longueur mi-mollet en tissu plissé. Modèle taille haute avec élastique.Tissu à effet brillant. '),
('77', 'en', 'Mid-calf length straight skirt. High waist model with elasticated waist. Opaque patterned fabric. Unlined.', 'Mid-calf length straight skirt. High waist model with elasticated waist. Opaque patterned fabric. Unlined.'),
('77', 'fr', 'Jupe droite de longueur mi-mollet. Modèle taille haute avec élastique à la taille. Tissu opaque à motif. Non doublé. ', 'Jupe droite de longueur mi-mollet. Modèle taille haute avec élastique à la taille. Tissu opaque à motif. Non doublé. '),
('78', 'en', 'Mid-calf length skirt in gathered fabric. High waist model with elastic. Front button placket on all length.', 'Mid-calf length skirt in gathered fabric. High waist model with elastic. Front button placket on all length.'),
('78', 'fr', 'Jupe de longueur mi-mollet en tissu plissé. Modèle taille haute avec élastique. Boutonnage avant sur toutes la longueur.', 'Jupe de longueur mi-mollet en tissu plissé. Modèle taille haute avec élastique. Boutonnage avant sur toutes la longueur.'),
('79', 'en', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.', 'Mid-length, fitted pencil skirt. High-waisted model with concealed zip fastening to the back.'),
('79', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos.'),
('8', 'en', 'Straight cut shirt with collar and buttoning at the front. Long sleeves finished with ties to tie. Straight base. Lightly gathered striped pattern fabric.', 'Straight cut shirt with collar and buttoning at the front. Long sleeves finished with ties to tie. Straight base. Lightly gathered striped pattern fabric.'),
('8', 'fr', 'Chemise coupe droite avec col et boutonnage à l\'avant. Manches longues terminées par des liens à nouer. Base droite. Tissu à motif rayé légèrement froncé.', 'Chemise coupe droite avec col et boutonnage à l\'avant. Manches longues terminées par des liens à nouer. Base droite. Tissu à motif rayé légèrement froncé.'),
('80', 'en', 'Woven shorts. High-waisted model with dressy elastic at the back and pleats lying in front. Zipped fly. Slanted side pockets. Belt loop.', 'Woven shorts. High-waisted model with dressy elastic at the back and pleats lying in front. Zipped fly. Slanted side pockets. Belt loop.'),
('80', 'fr', 'Short tissé. Modèle taille haute avec élastique habillé dans le dos et plis couchés devant. Braguette zippé. Poches latérales obliques. Passant à ceinture. ', 'Short tissé. Modèle taille haute avec élastique habillé dans le dos et plis couchés devant. Braguette zippé. Poches latérales obliques. Passant à ceinture. '),
('81', 'en', 'Woven pants. Low waist model with drawstring. Side pockets. Tapered legs finished with a drawstring.', 'Woven pants. Low waist model with drawstring. Side pockets. Tapered legs finished with a drawstring.'),
('81', 'fr', 'Pantalon tissé. Modèle taille basse avec lien de serrage. Poches latérales. Jambes effilées et terminées par lien de serrage.', 'Pantalon tissé. Modèle taille basse avec lien de serrage. Poches latérales. Jambes effilées et terminées par lien de serrage.'),
('82', 'en', 'Mid-length, fitted pencil skirt. High waist model with concealed zipper in the back and a slit on the side.', 'Mid-length, fitted pencil skirt. High waist model with concealed zipper in the back and a slit on the side.'),
('82', 'fr', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos et une fente sur le coté.', 'Jupe crayon mi-longue et ajustée. Modèle taille haute avec fermeture à glissière dissimulée dans le dos et une fente sur le coté.'),
('83', 'en', 'Mid-calf length cigarette pants. Fabric with a slightly satin effect. Front pockets. Front zipper topped with two buttons.', 'Mid-calf length cigarette pants. Fabric with a slightly satin effect. Front pockets. Front zipper topped with two buttons.'),
('83', 'fr', 'Pantalon cigarette longueur mi-mollet. Tissu à effet légèrement satiné. Poches avant. Fermeture éclair avant surmonté de deux boutons. ', 'Pantalon cigarette longueur mi-mollet. Tissu à effet légèrement satiné. Poches avant. Fermeture éclair avant surmonté de deux boutons. '),
('84', 'en', 'Mid-calf length flared pants. Drawstrings at the waist. Front pockets. Front zipper topped with two buttons.', 'Mid-calf length flared pants. Drawstrings at the waist. Front pockets. Front zipper topped with two buttons.'),
('84', 'fr', 'Pantalon évasé longueur mi-mollet. Liens de serrage au niveau de la taille. Poches avant. Fermeture éclair avant surmonté de deux boutons. ', 'Pantalon évasé longueur mi-mollet. Liens de serrage au niveau de la taille. Poches avant. Fermeture éclair avant surmonté de deux boutons. '),
('85', 'en', 'Pencil skirt in jeans. Front zipper topped with a button. Front and back pockets.', 'Pencil skirt in jeans. Front zipper topped with a button. Front and back pockets.'),
('85', 'fr', 'Jupe crayon en jeans. Fermeture éclair avant surmonté d’un bouton. Poches avant et arrière.  ', 'Jupe crayon en jeans. Fermeture éclair avant surmonté d’un bouton. Poches avant et arrière.  '),
('86', 'en', 'Woven pants. High waist model with zipper on the side. Pockets in the back. Tapered legs finished with a drawstring.', 'Woven pants. High waist model with zipper on the side. Pockets in the back. Tapered legs finished with a drawstring.'),
('86', 'fr', 'Pantalon tissé. Modèle taille haute avec fermeture éclair sur le coté. Poches dans le dos. Jambes effilées et terminées par lien de serrage.', 'Pantalon tissé. Modèle taille haute avec fermeture éclair sur le coté. Poches dans le dos. Jambes effilées et terminées par lien de serrage.'),
('87', 'en', 'Flared pants. Decorative link on the front side. Front and back pockets. Front zipper topped with two buttons.', 'Flared pants. Decorative link on the front side. Front and back pockets. Front zipper topped with two buttons.'),
('87', 'fr', 'Pantalon évasé. Lien décoratif sur le coté avant. Poches avant et arrière. Fermeture éclair avant surmonté de deux boutons. ', 'Pantalon évasé. Lien décoratif sur le coté avant. Poches avant et arrière. Fermeture éclair avant surmonté de deux boutons. '),
('88', 'en', 'Flared pants. High waist model with elastic at the waist. Side pockets and flap pockets on one leg.', 'Flared pants. High waist model with elastic at the waist. Side pockets and flap pockets on one leg.'),
('88', 'fr', 'Pantalon évasé. Modèle taille haute avec élastique au niveau de la taille. Poches latérales et poches à rabat sur une jambe. ', 'Pantalon évasé. Modèle taille haute avec élastique au niveau de la taille. Poches latérales et poches à rabat sur une jambe. '),
('89', 'en', 'Body-fitting pants with gathered fabric. Drawstrings at the waist.', 'Body-fitting pants with gathered fabric. Drawstrings at the waist.'),
('89', 'fr', 'Pantalon prêt du corps avec tissu froncé. Liens de serrage au niveau de la taille. ', 'Pantalon prêt du corps avec tissu froncé. Liens de serrage au niveau de la taille. '),
('90', 'en', 'Flared pants. Thick, gathered velor fabric. Front and back pockets. Front zipper topped with a button.', 'Flared pants. Thick, gathered velor fabric. Front and back pockets. Front zipper topped with a button.'),
('90', 'fr', 'Pantalon évasé. Tissu en velours épais et froncé. Poches avant et arrière. Fermeture éclair avant surmonté d’un bouton', 'Pantalon évasé. Tissu en velours épais et froncé. Poches avant et arrière. Fermeture éclair avant surmonté d’un bouton'),
('91', 'en', 'Woven flared pants. High waist model with pleats lying in front. Zip fly. Side pockets. Belt loop.', 'Woven flared pants. High waist model with pleats lying in front. Zip fly. Side pockets. Belt loop.'),
('91', 'fr', 'Pantalon évasé tissé. Modèle taille haute avec plis couchés devant. Braguette zippée. Poches latérales. Passant à ceinture. ', 'Pantalon évasé tissé. Modèle taille haute avec plis couchés devant. Braguette zippée. Poches latérales. Passant à ceinture. '),
('92', 'en', 'Woven shorts. High waist model with pleats lying in front. Zip fly. Slanted side pockets. Belt loop.', 'Woven shorts. High waist model with pleats lying in front. Zip fly. Slanted side pockets. Belt loop.'),
('92', 'fr', 'Short tissé. Modèle taille haute avec plis couchés devant. Braguette zippée. Poches latérales obliques. Passant à ceinture. ', 'Short tissé. Modèle taille haute avec plis couchés devant. Braguette zippée. Poches latérales obliques. Passant à ceinture. '),
('93', 'en', 'Shorts in light and airy fabric. Front drawstrings and elastic at the waist.', 'Shorts in light and airy fabric. Front drawstrings and elastic at the waist.'),
('93', 'fr', 'Short en tissu léger et aérien. Liens de serrage avant et élastique à la taille.', 'Short en tissu léger et aérien. Liens de serrage avant et élastique à la taille.'),
('94', 'en', 'Flared pants. Front and back pockets with small sparkly decorations. Front zipper topped with a button.', 'Flared pants. Front and back pockets with small sparkly decorations. Front zipper topped with a button.'),
('94', 'fr', 'Pantalon évasé. Poches avant et arrière avec de petites décorations scintillant. Fermeture éclair avant surmonté d’un bouton. ', 'Pantalon évasé. Poches avant et arrière avec de petites décorations scintillant. Fermeture éclair avant surmonté d’un bouton. '),
('95', 'en', 'Straight jeans slightly faded at the front. High waist model. Zipper topped with a button and front pockets. Belt loop.', 'Straight jeans slightly faded at the front. High waist model. Zipper topped with a button and front pockets. Belt loop.'),
('95', 'fr', 'Jeans droit légèrement délavé à l\'avant. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.', 'Jeans droit légèrement délavé à l\'avant. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.'),
('96', 'en', 'Mid-length flared jeans. High waist model. Zipper topped with a button and front pockets. Belt loop.', 'Mid-length flared jeans. High waist model. Zipper topped with a button and front pockets. Belt loop.'),
('96', 'fr', 'Jeans évasé mi-long. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. ', 'Jeans évasé mi-long. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. '),
('97', 'en', 'Straight jeans with fabric with a small dog pattern. High waist model. Zipper topped with a button and front pockets. Belt loop.', 'Straight jeans with fabric with a small dog pattern. High waist model. Zipper topped with a button and front pockets. Belt loop.'),
('97', 'fr', 'Jeans droit avec tissu à motif de petits chiens. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.', 'Jeans droit avec tissu à motif de petits chiens. Modèle taille haute. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.'),
('98', 'en', 'Mid-length skinny jeans. Low waist model. Zipper topped with a button and front pockets. Belt loop.', 'Mid-length skinny jeans. Low waist model. Zipper topped with a button and front pockets. Belt loop.'),
('98', 'fr', 'Jeans moulant mi-long. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.', 'Jeans moulant mi-long. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture.'),
('99', 'en', 'Jeans close to the body. Low waist model. Zipper topped with a button and front pockets. Belt loop.', 'Jeans close to the body. Low waist model. Zipper topped with a button and front pockets. Belt loop.'),
('99', 'fr', 'Jeans prêt du corps. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. ', 'Jeans prêt du corps. Modèle taille basse. Fermeture éclair surmonté d’un bouton et poches avant. Passant à ceinture. ');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsDiscounts`
--

CREATE TABLE `ProductsDiscounts` (
  `prodId` varchar(100) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `discount_value` double NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ProductsNames`
--

CREATE TABLE `ProductsNames` (
  `prodId` varchar(100) NOT NULL,
  `lang_` varchar(10) NOT NULL,
  `prodName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsNames`
--

INSERT INTO `ProductsNames` (`prodId`, `lang_`, `prodName`) VALUES
('1', 'en', 'polo shirt with long sleeves'),
('1', 'fr', 'polo avec manches longues'),
('10', 'en', 'top with sleeves decorated with bows and buttons on the top'),
('10', 'fr', 'haut à manches  décorées de noeuds et boutons sur le haut'),
('101', 'en', 'straight flared jeans slightly faded at the front'),
('101', 'fr', 'jeans droit évasé légèrement délavé à l’avant'),
('102', 'en', 'skinny jeans, slightly faded at the front'),
('102', 'fr', 'jeans prêt du corps, légèrement délavé à l’avant'),
('104', 'en', 'coat with fluffy lining'),
('104', 'fr', 'manteau avec doublure duveteuse'),
('105', 'en', 'transparent dressing gown with lace'),
('105', 'fr', 'robe de chambre transparente avec dentelle'),
('106', 'en', 'soft knit cardigan without buttoning'),
('106', 'fr', 'gilet en douce maille sans boutonnage'),
('107', 'en', 'faux fur vest'),
('107', 'fr', 'gilet en fausse fourrure '),
('108', 'en', 'dress with large slit'),
('108', 'fr', 'robe avec grande fente'),
('109', 'en', 'velvet overalls dress'),
('109', 'fr', 'robe salopette en velours'),
('11', 'en', 'top with design on the front'),
('11', 'fr', 'haut avec dessin à l’avant'),
('110', 'en', 'dress with slits on the sides'),
('110', 'fr', 'robe avec fentes sur les cotés'),
('111', 'en', 'faux leather dress'),
('111', 'fr', 'robe en faux cuire'),
('112', 'en', 'dress with slightly shiny fabric'),
('112', 'fr', 'robe avec tissu légèrement brillant '),
('113', 'en', 'dress with lacing at the back'),
('113', 'fr', 'robe avec laçage dans le dos'),
('114', 'en', 'slightly transparent dress'),
('114', 'fr', 'robe légèrement transparente'),
('115', 'en', 'dress with one off shoulder'),
('115', 'fr', 'robe avec une épaule dénudée'),
('116', 'en', 'striped dress'),
('116', 'fr', 'robe rayures'),
('117', 'en', 'solid color dress'),
('117', 'fr', 'robe à couleur uni'),
('118', 'en', 'dress with shiny fabric'),
('118', 'fr', 'robe avec tissu brillant'),
('119', 'en', 'dress with gathered fabric'),
('119', 'fr', 'robe à tissu froncé'),
('12', 'en', 'tank top with lace details'),
('12', 'fr', 'débardeur avec détails en dentelle'),
('120', 'en', 'dress with sparkly decorations'),
('120', 'fr', 'robe à decorations scintillants'),
('121', 'en', 'dress with maxi ruffles'),
('121', 'fr', 'robe avec maxi volants'),
('123', 'en', 'jumpsuit with large slits and ruffles'),
('123', 'fr', 'combinaison avec grandes fentes et volants'),
('124', 'en', 'top with v-neck'),
('124', 'fr', 'haut avec col en v'),
('125', 'en', 'cropped top with lacing at the back'),
('125', 'fr', 'haut court avec laçage dans le dos'),
('126', 'en', 'top with see through sleeves'),
('126', 'fr', 'haut à manches transparentes'),
('128', 'en', 'top with brooch'),
('128', 'fr', 'haut avec broche'),
('129', 'en', 'see through top'),
('129', 'fr', 'haut transparent'),
('13', 'en', 'top with design and lettering on the front'),
('13', 'fr', 'haut avec dessin et inscription à l’avant'),
('131', 'en', 'turtleneck top'),
('131', 'fr', 'haut à col roulé '),
('132', 'en', 'turtleneck sweater with geometric pattern'),
('132', 'fr', 'pull à col roulé et motif géométrique '),
('133', 'en', 'cropped lightweight sweatshirt'),
('133', 'fr', 'sweat-shirt court en tissu léger'),
('134', 'en', 'soft thick knit sweater'),
('134', 'fr', 'pull en douce maille épaisse'),
('135', 'en', 'fluffy faux fur sweater'),
('135', 'fr', 'pull en fausse fourrure et duveteuse'),
('136', 'en', 'sweatshirt with kangaroo pocket'),
('136', 'fr', 'sweat-shirt avec poche kangourou'),
('137', 'en', 'cropped sweatshirt with decorative hole'),
('137', 'fr', 'sweat-shirt court avec trou décoratif'),
('138', 'en', 'sweatshirt with lettering'),
('138', 'fr', 'sweat-shirt avec inscription'),
('14', 'en', 'striped pattern top'),
('14', 'fr', 'haut à motif rayé '),
('141', 'en', 'high-waisted jeans with ties to tie at the waist'),
('141', 'fr', 'jeans taille haute liens à nouer au niveau de la taille'),
('142', 'en', 'slightly transparent cyclist'),
('142', 'fr', 'cycliste légèrement transparent'),
('144', 'en', 'thin fabric shorts'),
('144', 'fr', 'short en tissu fin'),
('146', 'en', 'satin tailored shorts'),
('146', 'fr', 'short ajusté satiné'),
('147', 'en', 'striped shorts'),
('147', 'fr', 'short à rayure'),
('148', 'en', 'short geometric pattern skirt'),
('148', 'fr', 'jupe courte à motif géométrique'),
('15', 'en', 'blouse with wavy edges'),
('15', 'fr', 'blouse avec bords ondulés '),
('16', 'en', 'bodycon top with v-neck'),
('16', 'fr', 'haut moulant avec col v'),
('17', 'en', 'top with fabric drawing on the back'),
('17', 'fr', 'haut avec dessin en tissu à l’arrière'),
('18', 'en', 'soft-knit top'),
('18', 'fr', 'haut à tissu en maille douce'),
('19', 'en', 'cropped top to tie in the back'),
('19', 'fr', 'haut court à nouer dans le dos'),
('2', 'en', 'top with long batwing sleeves.'),
('2', 'fr', 'haut avec longues manches chauve-souris.'),
('20', 'en', 'soft top with round neckline'),
('20', 'fr', 'haut souple avec encolure ronde'),
('21', 'en', 'top with a decorative opening in the front'),
('21', 'fr', 'haut avec une ouverture décorative à l’avant'),
('22', 'en', 'blouse with a shiny appearance, embellished with ruffles'),
('22', 'fr', 'blouse à l’aspect brillant, agrémenté de volant'),
('23', 'en', 'knitted top'),
('23', 'fr', 'haut tricoté'),
('24', 'en', 'shirt with slightly puffed sleeves'),
('24', 'fr', 'chemise à manches légèrement bouffantes'),
('25', 'en', 'straight top with striped pattern'),
('25', 'fr', 'haut droit à motif rayé'),
('27', 'en', 'peplum top with puff sleeves'),
('27', 'fr', 'haut péplum à manches bouffantes'),
('28', 'en', 'oversized jacket with integrated shoulder pads'),
('28', 'fr', 'veste oversize à épaulettes intégrées'),
('29', 'en', 'fitted dress with geometric pattern'),
('29', 'fr', 'robe ajustée à motif géométrique '),
('3', 'en', 'dress with braided decoration'),
('3', 'fr', 'robe avec décoration tressée'),
('30', 'en', 'soft, chunky top with v-neckline'),
('30', 'fr', 'haut à doux et épais avec encolure en v '),
('31', 'en', 'geometric print top'),
('31', 'fr', 'haut à imprimé géométrique'),
('32', 'en', 'striped pattern dress'),
('32', 'fr', 'robe à motif rayé'),
('33', 'en', 'floral pattern dress'),
('33', 'fr', 'robe à motif floral'),
('34', 'en', 'dress with a double collar'),
('34', 'fr', 'robe avec un double col'),
('35', 'en', 'dress decorated with embroidery'),
('35', 'fr', 'robe décorée de broderies '),
('36', 'en', ' sleeveless maxi dress'),
('36', 'fr', 'robe maxi longue sans manche'),
('37', 'en', 'top with drawing and lettering'),
('37', 'fr', 'haut avec dessin et inscription'),
('38', 'en', 'top with lettering on the front'),
('38', 'fr', 'haut avec inscription à l’avant'),
('39', 'en', 'striped top with a small pocket'),
('39', 'fr', 'haut rayé avec une petite poche'),
('4', 'en', 'off the shoulder top'),
('4', 'fr', 'haut à épaules dénudée'),
('40', 'en', 'floral print top'),
('40', 'fr', 'haut à motif floral'),
('41', 'en', 'solid color top'),
('41', 'fr', 'haut de couleur uni'),
('42', 'en', 'off the shoulder top'),
('42', 'fr', 'haut à épaules dénudées '),
('43', 'en', 'mao collar shirt'),
('43', 'fr', 'chemise à col mao'),
('44', 'en', 'striped pattern top'),
('44', 'fr', 'haut à motif rayé'),
('45', 'en', 'dress with decorative cutout'),
('45', 'fr', 'robe avec découpage décoratif '),
('46', 'en', 'solid color top with inscriptions and drawings'),
('46', 'fr', 'haut à couleur uni avec inscriptions et dessins '),
('47', 'en', 'polo shirt with collar lined with a floral motif'),
('47', 'fr', 'polo avec col doublé par un motif floral   '),
('48', 'en', 'top with inscriptions and designs'),
('48', 'fr', 'haut avec inscriptions et dessins '),
('49', 'en', 'top with an oversized effect'),
('49', 'fr', 'haut avec un effet oversize'),
('5', 'en', 'solid color top with long sleeves'),
('5', 'fr', 'haut à couleur uni, avec  des manches longues'),
('50', 'en', 'solid color bodycon top'),
('50', 'fr', 'haut moulant de couleur uni'),
('51', 'en', 'sweater with golden chain'),
('51', 'fr', 'pull avec chaine de couleur dorée '),
('52', 'en', 'peplum top with floral pattern'),
('52', 'fr', 'haut péplum à motif floral'),
('53', 'en', 'square shoulder jacket'),
('53', 'fr', 'veste à épaules carrées'),
('55', 'en', 'top with inscriptions and designs'),
('55', 'fr', 'haut avec inscriptions et dessins '),
('56', 'en', 'cylindrical rhinestone top'),
('56', 'fr', 'haut orné de strass à forme cylindrique'),
('57', 'en', 'soft and fluffy knit sweater'),
('57', 'fr', 'pull en maille douce et duveteux'),
('58', 'en', 'slightly transparent top'),
('58', 'fr', 'haut légèrement transparent '),
('59', 'en', 'shirt with mao collar and floral pattern'),
('59', 'fr', 'chemise avec col mao et motif floral '),
('6', 'en', 'very shiny rhinestone dress with lining'),
('6', 'fr', 'robe à strass très brillant avec doublure'),
('61', 'en', 'top with inscriptions and designs'),
('61', 'fr', 'haut avec inscriptions et dessins '),
('62', 'en', 'top with glitter lettering'),
('62', 'fr', 'haut avec inscription à paillettes'),
('64', 'en', 'mid-length and flared skirt'),
('64', 'fr', 'jupe mi-longue et évasée'),
('65', 'en', 'long flared skirt with several different fabrics'),
('65', 'fr', 'jupe longue évasée avec plusieurs tissus differents'),
('66', 'en', 'mid-length pencil skirt'),
('66', 'fr', 'jupe crayon mi-longue'),
('67', 'en', 'mid-length pencil skirt'),
('67', 'fr', 'jupe crayon mi-longue'),
('68', 'en', 'flared patterned skirt with belt included'),
('68', 'fr', 'jupe évasé à motif avec ceinture inclus'),
('69', 'en', 'mid-length pencil skirt'),
('69', 'fr', 'jupe crayon mi-longue'),
('7', 'en', 'square neck crop top'),
('7', 'fr', 'haut court à encolure carré'),
('70', 'en', 'ruched fabric skirt'),
('70', 'fr', 'jupe à tissu froncé'),
('71', 'en', 'skirt with ruched cutout at the hem'),
('71', 'fr', 'jupe avec découpe froncée au niveau de la base'),
('72', 'en', 'asymmetric skirt'),
('72', 'fr', 'jupe asymétrique'),
('73', 'en', 'mid-length, fitted pencil skirt'),
('73', 'fr', 'jupe crayon mi-longue et ajustée'),
('74', 'en', 'short flared skirt'),
('74', 'fr', 'jupe courte et évasée'),
('75', 'en', 'asymmetric patterned skirt'),
('75', 'fr', 'jupe asymétrique à motif'),
('76', 'en', 'mid-calf length skirt in pleated fabric'),
('76', 'fr', 'jupe de longueur mi-mollet en tissu plissé'),
('77', 'en', 'patterned mid-calf length skirt'),
('77', 'fr', 'jupe de longueur mi-mollet à motif'),
('78', 'en', 'mid-calf length skirt in gathered fabric'),
('78', 'fr', 'jupe de longueur mi-mollet en tissu plissé'),
('79', 'en', 'mid-length pencil skirt'),
('79', 'fr', 'jupe crayon mi-longue'),
('8', 'en', 'striped shirt with long sleeves finished with ties to tie'),
('8', 'fr', 'chemise rayé à manches longues terminées par des liens à nouer'),
('80', 'en', 'woven shorts'),
('80', 'fr', 'short tissé'),
('81', 'en', 'woven trousers with drawstring'),
('81', 'fr', 'pantalon tissé avec lien de serrage'),
('82', 'en', 'pencil skirt with slit'),
('82', 'fr', 'jupe crayon avec fente'),
('83', 'en', 'mid-calf length cigarette pants'),
('83', 'fr', 'pantalon cigarette longueur mi-mollet'),
('84', 'en', 'mid-calf flared pants'),
('84', 'fr', 'pantalon évasé longueur mi-mollet'),
('85', 'en', 'denim pencil skirt'),
('85', 'fr', 'jupe crayon en jeans'),
('86', 'en', 'woven pants with zipper on the side'),
('86', 'fr', 'pantalon tissé avec fermeture éclair sur le coté'),
('87', 'en', 'flared pants with decorative tie'),
('87', 'fr', 'pantalon évasé avec lien décoratif'),
('88', 'en', 'flared pants with elastic at the waist'),
('88', 'fr', 'pantalon évasé avec élastique au niveau de la taille'),
('89', 'en', 'gathered pants '),
('89', 'fr', 'pantalon froncé'),
('90', 'en', 'thick velor flared pants'),
('90', 'fr', 'pantalon évasé en velours épais'),
('91', 'en', 'woven flared pants'),
('91', 'fr', 'pantalon évasé tissé'),
('92', 'en', 'high waist shorts'),
('92', 'fr', 'short taille haute '),
('93', 'en', 'lightweight, airy fabric shorts'),
('93', 'fr', 'short en tissu léger et aérien'),
('94', 'en', 'flared pants with small sparkly decorations'),
('94', 'fr', 'pantalon évasé avec petites décorations scintillantes'),
('95', 'en', 'lightly washed straight jeans'),
('95', 'fr', 'jeans droit légèrement délavé '),
('96', 'en', 'mid-length flared jeans'),
('96', 'fr', 'jeans évasé mi-long'),
('97', 'en', 'patterned straight jeans'),
('97', 'fr', 'jeans droit à motif'),
('98', 'en', 'mid-length skinny jeans'),
('98', 'fr', 'jeans moulant mi-long'),
('99', 'en', 'skinny jeans'),
('99', 'fr', 'jeans prêt du corps');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsPictures`
--

CREATE TABLE `ProductsPictures` (
  `prodId` varchar(100) NOT NULL,
  `pictureID` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsPictures`
--

INSERT INTO `ProductsPictures` (`prodId`, `pictureID`, `picture`) VALUES
('1', 0, 'clothe-1−0.jpg'),
('1', 1, 'clothe-1−1.jpg'),
('1', 2, 'clothe-1−2.jpg'),
('1', 3, 'clothe-1−3.jpg'),
('10', 0, 'clothe-10−0.jpg'),
('10', 1, 'clothe-10−1.jpg'),
('10', 2, 'clothe-10−2.jpg'),
('10', 3, 'clothe-10−3.jpg'),
('101', 0, 'clothe-101−0.jpg'),
('101', 1, 'clothe-101−1.jpg'),
('101', 2, 'clothe-101−2.jpg'),
('101', 3, 'clothe-101−3.jpg'),
('101', 4, 'clothe-101−4.jpg'),
('101', 5, 'clothe-101−5.jpg'),
('102', 0, 'clothe-102−0.jpg'),
('102', 1, 'clothe-102−1.jpg'),
('102', 2, 'clothe-102−2.jpg'),
('102', 3, 'clothe-102−3.jpg'),
('102', 4, 'clothe-102−4.jpg'),
('104', 0, 'clothe-104−0.jpg'),
('104', 1, 'clothe-104−1.jpg'),
('104', 2, 'clothe-104−2.jpg'),
('104', 3, 'clothe-104−3.jpg'),
('105', 0, 'clothe-105−0.jpg'),
('105', 1, 'clothe-105−1.jpg'),
('105', 2, 'clothe-105−2.jpg'),
('105', 3, 'clothe-105−3.jpg'),
('106', 0, 'clothe-106−0.jpg'),
('106', 1, 'clothe-106−1.jpg'),
('106', 2, 'clothe-106−2.jpg'),
('106', 3, 'clothe-106−3.jpg'),
('107', 0, 'clothe-107−0.jpg'),
('107', 1, 'clothe-107−1.jpg'),
('107', 2, 'clothe-107−2.jpg'),
('107', 3, 'clothe-107−3.jpg'),
('108', 0, 'clothe-108−0.jpg'),
('108', 1, 'clothe-108−1.jpg'),
('108', 2, 'clothe-108−2.jpg'),
('108', 3, 'clothe-108−3.jpg'),
('109', 0, 'clothe-109−0.jpg'),
('109', 1, 'clothe-109−1.jpg'),
('109', 2, 'clothe-109−2.jpg'),
('109', 3, 'clothe-109−3.jpg'),
('11', 0, 'clothe-11−0.jpg'),
('11', 1, 'clothe-11−1.jpg'),
('11', 2, 'clothe-11−2.jpg'),
('11', 3, 'clothe-11−3.jpg'),
('11', 4, 'clothe-11−4.jpg'),
('110', 0, 'clothe-110−0.jpg'),
('110', 1, 'clothe-110−1.jpg'),
('110', 2, 'clothe-110−2.jpg'),
('110', 3, 'clothe-110−3.jpg'),
('111', 0, 'clothe-111−0.jpg'),
('111', 1, 'clothe-111−1.jpg'),
('111', 2, 'clothe-111−2.jpg'),
('111', 3, 'clothe-111−3.jpg'),
('113', 0, 'clothe-113−0.jpg'),
('113', 1, 'clothe-113−1.jpg'),
('113', 2, 'clothe-113−2.jpg'),
('113', 3, 'clothe-113−3.jpg'),
('114', 0, 'clothe-114−0.jpg'),
('114', 1, 'clothe-114−1.jpg'),
('114', 2, 'clothe-114−2.jpg'),
('114', 3, 'clothe-114−3.jpg'),
('115', 0, 'clothe-115−0.jpg'),
('115', 1, 'clothe-115−1.jpg'),
('115', 2, 'clothe-115−2.jpg'),
('115', 3, 'clothe-115−3.jpg'),
('116', 0, 'clothe-116−0.jpg'),
('116', 1, 'clothe-116−1.jpg'),
('116', 2, 'clothe-116−2.jpg'),
('116', 3, 'clothe-116−3.jpg'),
('117', 0, 'clothe-117−0.jpg'),
('117', 1, 'clothe-117−1.jpg'),
('117', 2, 'clothe-117−2.jpg'),
('117', 3, 'clothe-117−3.jpg'),
('118', 0, 'clothe-118−0.jpg'),
('118', 1, 'clothe-118−1.jpg'),
('118', 2, 'clothe-118−2.jpg'),
('118', 3, 'clothe-118−3.jpg'),
('119', 0, 'clothe-119−0.jpg'),
('119', 1, 'clothe-119−1.jpg'),
('119', 2, 'clothe-119−2.jpg'),
('119', 3, 'clothe-119−3.jpg'),
('12', 0, 'clothe-12−0.jpg'),
('12', 1, 'clothe-12−1.jpg'),
('12', 2, 'clothe-12−2.jpg'),
('12', 3, 'clothe-12−3.jpg'),
('120', 0, 'clothe-120−0.jpg'),
('120', 1, 'clothe-120−1.jpg'),
('120', 2, 'clothe-120−2.jpg'),
('120', 3, 'clothe-120−3.jpg'),
('120', 4, 'clothe-120−4.jpg'),
('121', 0, 'clothe-121−0.jpg'),
('121', 1, 'clothe-121−1.jpg'),
('121', 2, 'clothe-121−2.jpg'),
('121', 3, 'clothe-121−3.jpg'),
('121', 4, 'clothe-121−4.jpg'),
('123', 0, 'clothe-123−0.jpg'),
('123', 1, 'clothe-123−1.jpg'),
('123', 2, 'clothe-123−2.jpg'),
('123', 3, 'clothe-123−3.jpg'),
('124', 0, 'clothe-124−0.jpg'),
('124', 1, 'clothe-124−1.jpg'),
('124', 2, 'clothe-124−2.jpg'),
('124', 3, 'clothe-124−3.jpg'),
('125', 0, 'clothe-125−0.jpg'),
('125', 1, 'clothe-125−1.jpg'),
('125', 2, 'clothe-125−2.jpg'),
('125', 3, 'clothe-125−3.jpg'),
('126', 0, 'clothe-126−0.jpg'),
('126', 1, 'clothe-126−1.jpg'),
('126', 2, 'clothe-126−2.jpg'),
('126', 3, 'clothe-126−3.jpg'),
('128', 0, 'clothe-128−0.jpg'),
('128', 1, 'clothe-128−1.jpg'),
('128', 2, 'clothe-128−2.jpg'),
('128', 3, 'clothe-128−3.jpg'),
('128', 4, 'clothe-128−4.jpg'),
('129', 0, 'clothe-129−0.jpg'),
('129', 1, 'clothe-129−1.jpg'),
('129', 2, 'clothe-129−2.jpg'),
('129', 3, 'clothe-129−3.jpg'),
('13', 0, 'clothe-13−0.jpg'),
('13', 1, 'clothe-13−1.jpg'),
('13', 2, 'clothe-13−2.jpg'),
('13', 3, 'clothe-13−3.jpg'),
('131', 0, 'clothe-131−0.jpg'),
('131', 1, 'clothe-131−1.jpg'),
('131', 2, 'clothe-131−2.jpg'),
('131', 3, 'clothe-131−3.jpg'),
('132', 0, 'clothe-132−0.jpg'),
('132', 1, 'clothe-132−1.jpg'),
('132', 2, 'clothe-132−2.jpg'),
('132', 3, 'clothe-132−3.jpg'),
('133', 0, 'clothe-133−0.jpg'),
('133', 1, 'clothe-133−1.jpg'),
('133', 2, 'clothe-133−2.jpg'),
('133', 3, 'clothe-133−3.jpg'),
('134', 0, 'clothe-134−0.jpg'),
('134', 1, 'clothe-134−1.jpg'),
('134', 2, 'clothe-134−2.jpg'),
('134', 3, 'clothe-134−3.jpg'),
('135', 0, 'clothe-135−0.jpg'),
('135', 1, 'clothe-135−1.jpg'),
('135', 2, 'clothe-135−2.jpg'),
('135', 3, 'clothe-135−3.jpg'),
('136', 0, 'clothe-136−0.jpg'),
('136', 1, 'clothe-136−1.jpg'),
('136', 2, 'clothe-136−2.jpg'),
('136', 3, 'clothe-136−3.jpg'),
('137', 0, 'clothe-137−0.jpg'),
('137', 1, 'clothe-137−1.jpg'),
('137', 2, 'clothe-137−2.jpg'),
('137', 3, 'clothe-137−3.jpg'),
('138', 0, 'clothe-138−0.jpg'),
('138', 1, 'clothe-138−1.jpg'),
('138', 2, 'clothe-138−2.jpg'),
('138', 3, 'clothe-138−3.jpg'),
('14', 0, 'clothe-14−0.jpg'),
('14', 1, 'clothe-14−1.jpg'),
('14', 2, 'clothe-14−2.jpg'),
('14', 3, 'clothe-14−3.jpg'),
('141', 0, 'clothe-141−0.jpg'),
('141', 1, 'clothe-141−1.jpg'),
('141', 2, 'clothe-141−2.jpg'),
('141', 3, 'clothe-141−3.jpg'),
('142', 0, 'clothe-142−0.jpg'),
('142', 1, 'clothe-142−1.jpg'),
('142', 2, 'clothe-142−2.jpg'),
('142', 3, 'clothe-142−3.jpg'),
('142', 4, 'clothe-142−4.jpg'),
('144', 0, 'clothe-144−0.jpg'),
('144', 1, 'clothe-144−1.jpg'),
('144', 2, 'clothe-144−2.jpg'),
('144', 3, 'clothe-144−3.jpg'),
('146', 0, 'clothe-146−0.jpg'),
('146', 1, 'clothe-146−1.jpg'),
('146', 2, 'clothe-146−2.jpg'),
('146', 3, 'clothe-146−3.jpg'),
('147', 0, 'clothe-147−0.jpg'),
('147', 1, 'clothe-147−1.jpg'),
('147', 2, 'clothe-147−2.jpg'),
('147', 3, 'clothe-147−3.jpg'),
('148', 0, 'clothe-148−0.jpg'),
('148', 1, 'clothe-148−1.jpg'),
('148', 2, 'clothe-148−2.jpg'),
('148', 3, 'clothe-148−3.jpg'),
('148', 4, 'clothe-148−4.jpg'),
('15', 0, 'clothe-15−0.jpg'),
('15', 1, 'clothe-15−1.jpg'),
('15', 2, 'clothe-15−2.jpg'),
('15', 3, 'clothe-15−3.jpg'),
('16', 0, 'clothe-16−0.jpg'),
('16', 1, 'clothe-16−1.jpg'),
('16', 2, 'clothe-16−2.jpg'),
('16', 3, 'clothe-16−3.jpg'),
('16', 4, 'clothe-16−4.jpg'),
('17', 0, 'clothe-17−0.jpg'),
('17', 1, 'clothe-17−1.jpg'),
('17', 2, 'clothe-17−2.jpg'),
('17', 3, 'clothe-17−3.jpg'),
('18', 0, 'clothe-18−0.jpg'),
('18', 1, 'clothe-18−1.jpg'),
('18', 2, 'clothe-18−2.jpg'),
('18', 3, 'clothe-18−3.jpg'),
('19', 0, 'clothe-19−0.jpg'),
('19', 1, 'clothe-19−1.jpg'),
('19', 2, 'clothe-19−2.jpg'),
('19', 3, 'clothe-19−3.jpg'),
('2', 0, 'clothe-2−0.jpg'),
('2', 1, 'clothe-2−1.jpg'),
('2', 2, 'clothe-2−2.jpg'),
('2', 3, 'clothe-2−3.jpg'),
('20', 0, 'clothe-20−0.jpg'),
('20', 1, 'clothe-20−1.jpg'),
('20', 2, 'clothe-20−2.jpg'),
('20', 3, 'clothe-20−3.jpg'),
('21', 0, 'clothe-21−0.jpg'),
('21', 1, 'clothe-21−1.jpg'),
('21', 2, 'clothe-21−2.jpg'),
('21', 3, 'clothe-21−3.jpg'),
('22', 0, 'clothe-22−0.jpg'),
('22', 1, 'clothe-22−1.jpg'),
('22', 2, 'clothe-22−2.jpg'),
('22', 3, 'clothe-22−3.jpg'),
('23', 0, 'clothe-23−0.jpg'),
('23', 1, 'clothe-23−1.jpg'),
('23', 2, 'clothe-23−2.jpg'),
('23', 3, 'clothe-23−3.jpg'),
('24', 0, 'clothe-24−0.jpg'),
('24', 1, 'clothe-24−1.jpg'),
('24', 2, 'clothe-24−2.jpg'),
('24', 3, 'clothe-24−3.jpg'),
('25', 0, 'clothe-25−0.jpg'),
('25', 1, 'clothe-25−1.jpg'),
('25', 2, 'clothe-25−2.jpg'),
('25', 3, 'clothe-25−3.jpg'),
('27', 0, 'clothe-27−0.jpg'),
('27', 1, 'clothe-27−1.jpg'),
('27', 2, 'clothe-27−2.jpg'),
('27', 3, 'clothe-27−3.jpg'),
('27', 4, 'clothe-27−4.jpg'),
('28', 0, 'clothe-28−0.jpg'),
('28', 1, 'clothe-28−1.jpg'),
('28', 2, 'clothe-28−2.jpg'),
('28', 3, 'clothe-28−3.jpg'),
('29', 0, 'clothe-29−0.jpg'),
('29', 1, 'clothe-29−1.jpg'),
('29', 2, 'clothe-29−2.jpg'),
('3', 0, 'clothe-3−0.jpg'),
('3', 1, 'clothe-3−1.jpg'),
('3', 2, 'clothe-3−2.jpg'),
('3', 3, 'clothe-3−3.jpg'),
('30', 0, 'clothe-30−0.jpg'),
('30', 1, 'clothe-30−1.jpg'),
('30', 2, 'clothe-30−2.jpg'),
('30', 3, 'clothe-30−3.jpg'),
('31', 0, 'clothe-31−0.jpg'),
('31', 1, 'clothe-31−1.jpg'),
('31', 2, 'clothe-31−2.jpg'),
('31', 3, 'clothe-31−3.jpg'),
('32', 0, 'clothe-32−0.jpg'),
('32', 1, 'clothe-32−1.jpg'),
('32', 2, 'clothe-32−2.jpg'),
('32', 3, 'clothe-32−3.jpg'),
('33', 0, 'clothe-33−0.jpg'),
('33', 1, 'clothe-33−1.jpg'),
('33', 2, 'clothe-33−2.jpg'),
('34', 0, 'clothe-34−0.jpg'),
('34', 1, 'clothe-34−1.jpg'),
('34', 2, 'clothe-34−2.jpg'),
('34', 3, 'clothe-34−3.jpg'),
('34', 4, 'clothe-34−4.jpg'),
('35', 0, 'clothe-35−0.jpg'),
('35', 1, 'clothe-35−1.jpg'),
('35', 2, 'clothe-35−2.jpg'),
('35', 3, 'clothe-35−3.jpg'),
('35', 4, 'clothe-35−4.jpg'),
('36', 0, 'clothe-36−0.jpg'),
('36', 1, 'clothe-36−1.jpg'),
('36', 2, 'clothe-36−2.jpg'),
('36', 3, 'clothe-36−3.jpg'),
('36', 4, 'clothe-36−4.jpg'),
('37', 0, 'clothe-37−0.jpg'),
('37', 1, 'clothe-37−1.jpg'),
('37', 2, 'clothe-37−2.jpg'),
('37', 3, 'clothe-37−3.jpg'),
('38', 0, 'clothe-38−0.jpg'),
('38', 1, 'clothe-38−1.jpg'),
('38', 2, 'clothe-38−2.jpg'),
('38', 3, 'clothe-38−3.jpg'),
('38', 4, 'clothe-38−4.jpg'),
('39', 0, 'clothe-39−0.jpg'),
('39', 1, 'clothe-39−1.jpg'),
('39', 2, 'clothe-39−2.jpg'),
('39', 3, 'clothe-39−3.jpg'),
('4', 0, 'clothe-4−0.jpg'),
('4', 1, 'clothe-4−1.jpg'),
('4', 2, 'clothe-4−2.jpg'),
('4', 3, 'clothe-4−3.jpg'),
('40', 0, 'clothe-40−0.jpg'),
('40', 1, 'clothe-40−1.jpg'),
('40', 2, 'clothe-40−2.jpg'),
('40', 3, 'clothe-40−3.jpg'),
('41', 0, 'clothe-41−0.jpg'),
('41', 1, 'clothe-41−1.jpg'),
('41', 2, 'clothe-41−2.jpg'),
('41', 3, 'clothe-41−3.jpg'),
('42', 0, 'clothe-42−0.jpg'),
('42', 1, 'clothe-42−1.jpg'),
('42', 2, 'clothe-42−2.jpg'),
('42', 3, 'clothe-42−3.jpg'),
('43', 0, 'clothe-43−0.jpg'),
('43', 1, 'clothe-43−1.jpg'),
('43', 2, 'clothe-43−2.jpg'),
('43', 3, 'clothe-43−3.jpg'),
('44', 0, 'clothe-44−0.jpg'),
('44', 1, 'clothe-44−1.jpg'),
('44', 2, 'clothe-44−2.jpg'),
('44', 3, 'clothe-44−3.jpg'),
('45', 0, 'clothe-45−0.jpg'),
('45', 1, 'clothe-45−1.jpg'),
('45', 2, 'clothe-45−2.jpg'),
('45', 3, 'clothe-45−3.jpg'),
('45', 4, 'clothe-45−4.jpg'),
('46', 0, 'clothe-46−0.jpg'),
('46', 1, 'clothe-46−1.jpg'),
('46', 2, 'clothe-46−2.jpg'),
('46', 3, 'clothe-46−3.jpg'),
('47', 0, 'clothe-47−0.jpg'),
('47', 1, 'clothe-47−1.jpg'),
('47', 2, 'clothe-47−2.jpg'),
('47', 3, 'clothe-47−3.jpg'),
('48', 0, 'clothe-48−0.jpg'),
('48', 1, 'clothe-48−1.jpg'),
('48', 2, 'clothe-48−2.jpg'),
('48', 3, 'clothe-48−3.jpg'),
('49', 0, 'clothe-49−0.jpg'),
('49', 1, 'clothe-49−1.jpg'),
('49', 2, 'clothe-49−2.jpg'),
('49', 3, 'clothe-49−3.jpg'),
('5', 0, 'clothe-5−0.jpg'),
('5', 1, 'clothe-5−1.jpg'),
('5', 2, 'clothe-5−2.jpg'),
('5', 3, 'clothe-5−3.jpg'),
('50', 0, 'clothe-50−0.jpg'),
('50', 1, 'clothe-50−1.jpg'),
('50', 2, 'clothe-50−2.jpg'),
('50', 3, 'clothe-50−3.jpg'),
('51', 0, 'clothe-51−0.jpg'),
('51', 1, 'clothe-51−1.jpg'),
('51', 2, 'clothe-51−2.jpg'),
('51', 3, 'clothe-51−3.jpg'),
('51', 4, 'clothe-51−4.jpg'),
('51', 5, 'clothe-51−5.jpg'),
('52', 0, 'clothe-52−0.jpg'),
('52', 1, 'clothe-52−1.jpg'),
('52', 2, 'clothe-52−2.jpg'),
('52', 3, 'clothe-52−3.jpg'),
('52', 4, 'clothe-52−4.jpg'),
('53', 0, 'clothe-53−0.jpg'),
('53', 1, 'clothe-53−1.jpg'),
('53', 2, 'clothe-53−2.jpg'),
('53', 3, 'clothe-53−3.jpg'),
('55', 0, 'clothe-55−0.jpg'),
('55', 1, 'clothe-55−1.jpg'),
('55', 2, 'clothe-55−2.jpg'),
('55', 3, 'clothe-55−3.jpg'),
('56', 0, 'clothe-56−0.jpg'),
('56', 1, 'clothe-56−1.jpg'),
('56', 2, 'clothe-56−2.jpg'),
('56', 3, 'clothe-56−3.jpg'),
('57', 0, 'clothe-57−0.jpg'),
('57', 1, 'clothe-57−1.jpg'),
('57', 2, 'clothe-57−2.jpg'),
('57', 3, 'clothe-57−3.jpg'),
('58', 0, 'clothe-58−0.jpg'),
('58', 1, 'clothe-58−1.jpg'),
('58', 2, 'clothe-58−2.jpg'),
('58', 3, 'clothe-58−3.jpg'),
('59', 0, 'clothe-59−0.jpg'),
('59', 1, 'clothe-59−1.jpg'),
('59', 2, 'clothe-59−2.jpg'),
('59', 3, 'clothe-59−3.jpg'),
('6', 0, 'clothe-6−0.jpg'),
('6', 1, 'clothe-6−1.jpg'),
('6', 2, 'clothe-6−2.jpg'),
('6', 3, 'clothe-6−3.jpg'),
('6', 4, 'clothe-6−4.jpg'),
('61', 0, 'clothe-61−0.jpg'),
('61', 1, 'clothe-61−1.jpg'),
('61', 2, 'clothe-61−2.jpg'),
('61', 3, 'clothe-61−3.jpg'),
('62', 0, 'clothe-62−0.jpg'),
('62', 1, 'clothe-62−1.jpg'),
('62', 2, 'clothe-62−2.jpg'),
('62', 3, 'clothe-62−3.jpg'),
('64', 0, 'clothe-64−0.jpg'),
('64', 1, 'clothe-64−1.jpg'),
('64', 2, 'clothe-64−2.jpg'),
('64', 3, 'clothe-64−3.jpg'),
('65', 0, 'clothe-65−0.jpg'),
('65', 1, 'clothe-65−1.jpg'),
('65', 2, 'clothe-65−2.jpg'),
('65', 3, 'clothe-65−3.jpg'),
('66', 0, 'clothe-66−0.jpg'),
('66', 1, 'clothe-66−1.jpg'),
('66', 2, 'clothe-66−2.jpg'),
('66', 3, 'clothe-66−3.jpg'),
('67', 0, 'clothe-67−0.jpg'),
('67', 1, 'clothe-67−1.jpg'),
('67', 2, 'clothe-67−2.jpg'),
('67', 3, 'clothe-67−3.jpg'),
('68', 0, 'clothe-68−0.jpg'),
('68', 1, 'clothe-68−1.jpg'),
('68', 2, 'clothe-68−2.jpg'),
('68', 3, 'clothe-68−3.jpg'),
('68', 4, 'clothe-68−4.jpg'),
('68', 5, 'clothe-68−5.jpg'),
('69', 0, 'clothe-69−0.jpg'),
('69', 1, 'clothe-69−1.jpg'),
('69', 2, 'clothe-69−2.jpg'),
('69', 3, 'clothe-69−3.jpg'),
('7', 0, 'clothe-7−0.jpg'),
('7', 1, 'clothe-7−1.jpg'),
('7', 2, 'clothe-7−2.jpg'),
('7', 3, 'clothe-7−3.jpg'),
('7', 4, 'clothe-7−4.jpg'),
('70', 0, 'clothe-70−0.jpg'),
('70', 1, 'clothe-70−1.jpg'),
('70', 2, 'clothe-70−2.jpg'),
('70', 3, 'clothe-70−3.jpg'),
('70', 4, 'clothe-70−4.jpg'),
('71', 0, 'clothe-71−0.jpg'),
('71', 1, 'clothe-71−1.jpg'),
('71', 2, 'clothe-71−2.jpg'),
('71', 3, 'clothe-71−3.jpg'),
('72', 0, 'clothe-72−0.jpg'),
('72', 1, 'clothe-72−1.jpg'),
('72', 2, 'clothe-72−2.jpg'),
('72', 3, 'clothe-72−3.jpg'),
('73', 0, 'clothe-73−0.jpg'),
('73', 1, 'clothe-73−1.jpg'),
('73', 2, 'clothe-73−2.jpg'),
('73', 3, 'clothe-73−3.jpg'),
('74', 0, 'clothe-74−0.jpg'),
('74', 1, 'clothe-74−1.jpg'),
('74', 2, 'clothe-74−2.jpg'),
('74', 3, 'clothe-74−3.jpg'),
('75', 0, 'clothe-75−0.jpg'),
('75', 1, 'clothe-75−1.jpg'),
('75', 2, 'clothe-75−2.jpg'),
('75', 3, 'clothe-75−3.jpg'),
('76', 0, 'clothe-76−0.jpg'),
('76', 1, 'clothe-76−1.jpg'),
('76', 2, 'clothe-76−2.jpg'),
('76', 3, 'clothe-76−3.jpg'),
('77', 0, 'clothe-77−0.jpg'),
('77', 1, 'clothe-77−1.jpg'),
('77', 2, 'clothe-77−2.jpg'),
('77', 3, 'clothe-77−3.jpg'),
('78', 0, 'clothe-78−0.jpg'),
('78', 1, 'clothe-78−1.jpg'),
('78', 2, 'clothe-78−2.jpg'),
('78', 3, 'clothe-78−3.jpg'),
('79', 0, 'clothe-79−0.jpg'),
('79', 1, 'clothe-79−1.jpg'),
('79', 2, 'clothe-79−2.jpg'),
('79', 3, 'clothe-79−3.jpg'),
('8', 0, 'clothe-8−0.jpg'),
('8', 1, 'clothe-8−1.jpg'),
('8', 2, 'clothe-8−2.jpg'),
('8', 3, 'clothe-8−3.jpg'),
('80', 0, 'clothe-80−0.jpg'),
('80', 1, 'clothe-80−1.jpg'),
('80', 2, 'clothe-80−2.jpg'),
('80', 3, 'clothe-80−3.jpg'),
('80', 4, 'clothe-80−4.jpg'),
('81', 0, 'clothe-81−0.jpg'),
('81', 1, 'clothe-81−1.jpg'),
('81', 2, 'clothe-81−2.jpg'),
('81', 3, 'clothe-81−3.jpg'),
('82', 0, 'clothe-82−0.jpg'),
('82', 1, 'clothe-82−1.jpg'),
('82', 2, 'clothe-82−2.jpg'),
('82', 3, 'clothe-82−3.jpg'),
('83', 0, 'clothe-83−0.jpg'),
('83', 1, 'clothe-83−1.jpg'),
('83', 2, 'clothe-83−2.jpg'),
('83', 3, 'clothe-83−3.jpg'),
('84', 0, 'clothe-84−0.jpg'),
('84', 1, 'clothe-84−1.jpg'),
('84', 2, 'clothe-84−2.jpg'),
('84', 3, 'clothe-84−3.jpg'),
('85', 0, 'clothe-85−0.jpg'),
('85', 1, 'clothe-85−1.jpg'),
('85', 2, 'clothe-85−2.jpg'),
('85', 3, 'clothe-85−3.jpg'),
('86', 0, 'clothe-86−0.jpg'),
('86', 1, 'clothe-86−1.jpg'),
('86', 2, 'clothe-86−2.jpg'),
('86', 3, 'clothe-86−3.jpg'),
('87', 0, 'clothe-87−0.jpg'),
('87', 1, 'clothe-87−1.jpg'),
('87', 2, 'clothe-87−2.jpg'),
('87', 3, 'clothe-87−3.jpg'),
('88', 0, 'clothe-88−0.jpg'),
('88', 1, 'clothe-88−1.jpg'),
('88', 2, 'clothe-88−2.jpg'),
('88', 3, 'clothe-88−3.jpg'),
('89', 0, 'clothe-89−0.jpg'),
('89', 1, 'clothe-89−1.jpg'),
('89', 2, 'clothe-89−2.jpg'),
('89', 3, 'clothe-89−3.jpg'),
('90', 0, 'clothe-90−0.jpg'),
('90', 1, 'clothe-90−1.jpg'),
('90', 2, 'clothe-90−2.jpg'),
('90', 3, 'clothe-90−3.jpg'),
('91', 0, 'clothe-91−0.jpg'),
('91', 1, 'clothe-91−1.jpg'),
('91', 2, 'clothe-91−2.jpg'),
('91', 3, 'clothe-91−3.jpg'),
('92', 0, 'clothe-92−0.jpg'),
('92', 1, 'clothe-92−1.jpg'),
('92', 2, 'clothe-92−2.jpg'),
('92', 3, 'clothe-92−3.jpg'),
('92', 4, 'clothe-92−4.jpg'),
('93', 0, 'clothe-93−0.jpg'),
('93', 1, 'clothe-93−1.jpg'),
('93', 2, 'clothe-93−2.jpg'),
('93', 3, 'clothe-93−3.jpg'),
('94', 0, 'clothe-94−0.jpg'),
('94', 1, 'clothe-94−1.jpg'),
('94', 2, 'clothe-94−2.jpg'),
('94', 3, 'clothe-94−3.jpg'),
('94', 4, 'clothe-94−4.jpg'),
('95', 0, 'clothe-95−0.jpg'),
('95', 1, 'clothe-95−1.jpg'),
('95', 2, 'clothe-95−2.jpg'),
('95', 3, 'clothe-95−3.jpg'),
('95', 4, 'clothe-95−4.jpg'),
('95', 5, 'clothe-95−5.jpg'),
('95', 6, 'clothe-95−6.jpg'),
('96', 0, 'clothe-96−0.jpg'),
('96', 1, 'clothe-96−1.jpg'),
('96', 2, 'clothe-96−2.jpg'),
('96', 3, 'clothe-96−3.jpg'),
('96', 4, 'clothe-96−4.jpg'),
('97', 0, 'clothe-97−0.jpg'),
('97', 1, 'clothe-97−1.jpg'),
('97', 2, 'clothe-97−2.jpg'),
('97', 3, 'clothe-97−3.jpg'),
('97', 4, 'clothe-97−4.jpg'),
('98', 0, 'clothe-98−0.jpg'),
('98', 1, 'clothe-98−1.jpg'),
('98', 2, 'clothe-98−2.jpg'),
('98', 3, 'clothe-98−3.jpg'),
('99', 0, 'clothe-99−0.jpg'),
('99', 1, 'clothe-99−1.jpg'),
('99', 2, 'clothe-99−2.jpg'),
('99', 3, 'clothe-99−3.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `ProductsPrices`
--

CREATE TABLE `ProductsPrices` (
  `prodId` varchar(100) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ProductsShippings`
--

CREATE TABLE `ProductsShippings` (
  `prodId` varchar(100) NOT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `price` double NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('lady'),
('other'),
('sir');

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
('32'),
('34'),
('36'),
('38'),
('3xl'),
('40'),
('42'),
('44'),
('46'),
('48'),
('4xl'),
('50'),
('52'),
('54'),
('56'),
('58'),
('60'),
('62'),
('l'),
('m'),
('s'),
('xl'),
('xs'),
('xxl'),
('xxs');

-- --------------------------------------------------------

--
-- Structure de la table `SizesMeasures`
--

CREATE TABLE `SizesMeasures` (
  `size_name` varchar(100) NOT NULL,
  `body_part` varchar(30) NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `SizesMeasures`
--

INSERT INTO `SizesMeasures` (`size_name`, `body_part`, `unit_name`, `value`) VALUES
('32', 'arm', 'centimeter', 1000),
('32', 'bust', 'centimeter', 82),
('32', 'hip', 'centimeter', 84),
('32', 'inseam', 'centimeter', 1000),
('32', 'waist', 'centimeter', 60),
('34', 'arm', 'centimeter', 1000),
('34', 'bust', 'centimeter', 84),
('34', 'hip', 'centimeter', 90),
('34', 'inseam', 'centimeter', 1000),
('34', 'waist', 'centimeter', 64),
('36', 'arm', 'centimeter', 1000),
('36', 'bust', 'centimeter', 86),
('36', 'hip', 'centimeter', 94),
('36', 'inseam', 'centimeter', 1000),
('36', 'waist', 'centimeter', 66),
('38', 'arm', 'centimeter', 1000),
('38', 'bust', 'centimeter', 90),
('38', 'hip', 'centimeter', 98),
('38', 'inseam', 'centimeter', 1000),
('38', 'waist', 'centimeter', 70),
('3xl', 'arm', 'centimeter', 1000),
('3xl', 'bust', 'centimeter', 140),
('3xl', 'hip', 'centimeter', 140),
('3xl', 'inseam', 'centimeter', 1000),
('3xl', 'waist', 'centimeter', 128),
('40', 'arm', 'centimeter', 1000),
('40', 'bust', 'centimeter', 94),
('40', 'hip', 'centimeter', 102),
('40', 'inseam', 'centimeter', 1000),
('40', 'waist', 'centimeter', 74),
('42', 'arm', 'centimeter', 1000),
('42', 'bust', 'centimeter', 98),
('42', 'hip', 'centimeter', 106),
('42', 'inseam', 'centimeter', 1000),
('42', 'waist', 'centimeter', 78),
('44', 'arm', 'centimeter', 1000),
('44', 'bust', 'centimeter', 102),
('44', 'hip', 'centimeter', 110),
('44', 'inseam', 'centimeter', 1000),
('44', 'waist', 'centimeter', 82),
('46', 'arm', 'centimeter', 1000),
('46', 'bust', 'centimeter', 106),
('46', 'hip', 'centimeter', 116),
('46', 'inseam', 'centimeter', 1000),
('46', 'waist', 'centimeter', 88),
('48', 'arm', 'centimeter', 1000),
('48', 'bust', 'centimeter', 110),
('48', 'hip', 'centimeter', 117),
('48', 'inseam', 'centimeter', 1000),
('48', 'waist', 'centimeter', 96),
('4xl', 'arm', 'centimeter', 1000),
('4xl', 'bust', 'centimeter', 152),
('4xl', 'hip', 'centimeter', 152),
('4xl', 'inseam', 'centimeter', 1000),
('4xl', 'waist', 'centimeter', 142),
('50', 'arm', 'centimeter', 1000),
('50', 'bust', 'centimeter', 116),
('50', 'hip', 'centimeter', 118),
('50', 'inseam', 'centimeter', 1000),
('50', 'waist', 'centimeter', 102),
('52', 'arm', 'centimeter', 1000),
('52', 'bust', 'centimeter', 122),
('52', 'hip', 'centimeter', 123),
('52', 'inseam', 'centimeter', 1000),
('52', 'waist', 'centimeter', 108),
('54', 'arm', 'centimeter', 1000),
('54', 'bust', 'centimeter', 128),
('54', 'hip', 'centimeter', 128),
('54', 'inseam', 'centimeter', 1000),
('54', 'waist', 'centimeter', 114),
('56', 'arm', 'centimeter', 1000),
('56', 'bust', 'centimeter', 134),
('56', 'hip', 'centimeter', 134),
('56', 'inseam', 'centimeter', 1000),
('56', 'waist', 'centimeter', 121),
('58', 'arm', 'centimeter', 1000),
('58', 'bust', 'centimeter', 140),
('58', 'hip', 'centimeter', 140),
('58', 'inseam', 'centimeter', 1000),
('58', 'waist', 'centimeter', 128),
('60', 'arm', 'centimeter', 1000),
('60', 'bust', 'centimeter', 146),
('60', 'hip', 'centimeter', 146),
('60', 'inseam', 'centimeter', 1000),
('60', 'waist', 'centimeter', 135),
('62', 'arm', 'centimeter', 1000),
('62', 'bust', 'centimeter', 152),
('62', 'hip', 'centimeter', 152),
('62', 'inseam', 'centimeter', 1000),
('62', 'waist', 'centimeter', 142),
('l', 'arm', 'centimeter', 1000),
('l', 'bust', 'centimeter', 104),
('l', 'hip', 'centimeter', 108),
('l', 'inseam', 'centimeter', 1000),
('l', 'waist', 'centimeter', 90),
('m', 'arm', 'centimeter', 1000),
('m', 'bust', 'centimeter', 96),
('m', 'hip', 'centimeter', 102),
('m', 'inseam', 'centimeter', 1000),
('m', 'waist', 'centimeter', 80),
('s', 'arm', 'centimeter', 1000),
('s', 'bust', 'centimeter', 88),
('s', 'hip', 'centimeter', 96),
('s', 'inseam', 'centimeter', 1000),
('s', 'waist', 'centimeter', 72),
('xl', 'arm', 'centimeter', 1000),
('xl', 'bust', 'centimeter', 116),
('xl', 'hip', 'centimeter', 118),
('xl', 'inseam', 'centimeter', 1000),
('xl', 'waist', 'centimeter', 102),
('xs', 'arm', 'centimeter', 1000),
('xs', 'bust', 'centimeter', 82),
('xs', 'hip', 'centimeter', 90),
('xs', 'inseam', 'centimeter', 1000),
('xs', 'waist', 'centimeter', 64),
('xxl', 'arm', 'centimeter', 1000),
('xxl', 'bust', 'centimeter', 128),
('xxl', 'hip', 'centimeter', 128),
('xxl', 'inseam', 'centimeter', 1000),
('xxl', 'waist', 'centimeter', 114),
('xxs', 'arm', 'centimeter', 1000),
('xxs', 'bust', 'centimeter', 80),
('xxs', 'hip', 'centimeter', 86),
('xxs', 'inseam', 'centimeter', 1000),
('xxs', 'waist', 'centimeter', 61);

-- --------------------------------------------------------

--
-- Structure de la table `StockLocks`
--

CREATE TABLE `StockLocks` (
  `userId` varchar(50) NOT NULL,
  `prodId` varchar(100) NOT NULL,
  `size_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `lockTime` int(11) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `StripeCheckoutSessions`
--

CREATE TABLE `StripeCheckoutSessions` (
  `sessionID` varchar(100) NOT NULL,
  `payId` varchar(50) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `custoID` varchar(100) DEFAULT NULL,
  `payStatus` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Translations`
--

CREATE TABLE `Translations` (
  `translationID` int(11) NOT NULL,
  `en` text NOT NULL,
  `iso_lang` varchar(10) NOT NULL,
  `translation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Translations`
--

INSERT INTO `Translations` (`translationID`, `en`, `iso_lang`, `translation`) VALUES
(1, 'free with meimbox', 'fr', 'gratuit avec meimbox'),
(2, 'size customization for free by our tailor', 'fr', 'personnalisation de la taille gratuitement par notre tailleur'),
(3, 'delivery in less than 5 business days', 'fr', 'livraison en moins de 5 jours ouvrés'),
(4, 'return 100% free', 'fr', 'retour 100% gratuit'),
(5, 'access to the entire item catalog', 'fr', 'accès à l\'ensemble du catalogue d\'articles'),
(6, 'free shipping', 'fr', 'livraison gratuite'),
(7, 'january', 'fr', 'janvier'),
(8, 'february', 'fr', 'février'),
(9, 'march', 'fr', 'mars'),
(10, 'april', 'fr', 'avril'),
(11, 'may', 'fr', 'mai'),
(12, 'june', 'fr', 'juin'),
(13, 'july', 'fr', 'juillet'),
(14, 'august', 'fr', 'août'),
(15, 'september', 'fr', 'septembre'),
(16, 'october', 'fr', 'octobre'),
(17, 'november', 'fr', 'novembre'),
(18, 'december', 'fr', 'décembre'),
(19, 'cargo pants', 'fr', 'pantalon cargo'),
(20, 'jeans', 'fr', 'jeans'),
(21, 'trousers', 'fr', 'pantalon'),
(22, 'shorts', 'fr', 'short'),
(23, 'socks', 'fr', 'chaussettes'),
(24, 'bikini', 'fr', 'bikini'),
(25, 'swimsuit', 'fr', 'maillot de bain'),
(26, 'cardigan', 'fr', 'cardigan'),
(27, 'hawaiian shirt', 'fr', 'chemise hawaïenne'),
(28, 'hoodie', 'fr', 'sweat à capuche'),
(29, 'jumper', 'fr', 'marinière'),
(30, 'long-sleeve top', 'fr', 'haut à manches longues'),
(31, 'tops', 'fr', 'haut'),
(32, 'polo shirt', 'fr', 'chemise polo'),
(33, 'pullover', 'fr', 'pullover'),
(34, 'shirt', 'fr', 'chemise'),
(35, 'sleeveless shirt', 'fr', 'chemise hawaïenne'),
(36, 'sweater', 'fr', 'chandail'),
(37, 't-shirt', 'fr', 't-shirt'),
(38, 'tank top', 'fr', 'débardeur'),
(39, 'bra', 'fr', 'soutien-gorge'),
(40, 'skirt suits', 'fr', 'tailleurs-jupes'),
(41, 'smokings', 'fr', 'smokings'),
(42, 'skirt', 'fr', 'jupe'),
(43, 'suit', 'fr', 'costume'),
(44, 'vest', 'fr', 'gilet'),
(45, 'dress', 'fr', 'robe\r\n'),
(46, 'sheath dress', 'fr', 'robe fourreau'),
(47, 'uniform', 'fr', 'uniforme'),
(48, 'slip', 'fr', 'caleçon'),
(49, 'bathrobe', 'fr', 'peignoir de bain'),
(50, 'stockings', 'fr', 'bas'),
(51, 'singlet', 'fr', 'singlet'),
(52, 'pant suits', 'fr', 'costumes et tailleurs à pantalon'),
(53, 'jumpsuits', 'fr', 'combinaison'),
(54, 'skorts', 'fr', 'jupe-culottes'),
(55, 'blazer', 'fr', 'blazer'),
(56, 'coat', 'fr', 'manteau'),
(57, 'jacket', 'fr', 'veste'),
(58, 'long coat', 'fr', 'long manteau'),
(59, 'trench coat', 'fr', 'trench coat'),
(60, 'winter coat', 'fr', 'manteau d\'hiver'),
(61, 'underpants', 'fr', 'slip'),
(62, 'overalls', 'fr', 'salopette');

-- --------------------------------------------------------

--
-- Structure de la table `TranslationStations`
--

CREATE TABLE `TranslationStations` (
  `station` varchar(100) NOT NULL,
  `iso_lang` varchar(10) NOT NULL,
  `translation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TranslationStations`
--

INSERT INTO `TranslationStations` (`station`, `iso_lang`, `translation`) VALUES
('ER1', 'en', 'Sorry, this service is temporarily unavailable'),
('ER1', 'fr', 'Désolé, ce service est pontuellement indisponible'),
('ER10', 'en', 'Please select a size'),
('ER10', 'fr', 'veuillez choisir une taille'),
('ER11', 'en', 'if you choose the option \'Size\' you must check a size.'),
('ER11', 'fr', 'si vous choisissez l\'option \'Taille\' vous devez cocher une taille.'),
('ER12', 'en', 'if you choose the option \'Custom size\' you must select one of your measurements or create a new one.'),
('ER12', 'fr', 'si vous choisissez l\'option \'Taille personnalisée\' vous devez sélectionner une de vos mesures ou en créer une nouvelle.'),
('ER13', 'en', 'sorry, the stock for this size is sold out at the moment.'),
('ER13', 'fr', 'désolé, le stock pour cette taille est épuisé pour le moment.'),
('ER14', 'en', 'Sorry, this box has reached the maximum number of items: '),
('ER14', 'fr', 'Désolé, cette box a atteint le nombre maximum d\'article: '),
('ER15', 'en', 'sorry, there is not enough free space in this box to move all the copies of your item'),
('ER15', 'fr', 'désolé, il n\'y a pas assez d\'espace libre dans cette box pour déplacer toutes les copies de votre article'),
('ER16', 'en', 'this measurement cannot be deleted because it is used on items in the shopping bag.'),
('ER16', 'fr', 'cette mesure ne peut pas être supprimée car elle est utilisée sur des articles du panier.'),
('ER17', 'en', 'the quantity must be at least 1'),
('ER17', 'fr', 'la quantité doit être de minimum 1'),
('ER18', 'en', 'the quantity indicated exceeds the space available in the box'),
('ER18', 'fr', 'la quantité indiquée dépasse l\'espace disponible dans la box'),
('ER19', 'en', 'this email is invalid'),
('ER19', 'fr', 'cet email est invalide'),
('ER2', 'en', 'this field can not be empty'),
('ER2', 'fr', 'ce champ ne peut pas être vide'),
('ER20', 'en', 'this field can only contain letters (A-Z), dashes (-) and spaces'),
('ER20', 'fr', 'ce champ ne peut contenir que des lettres (A-Z), des tirets (-) et des espaces'),
('ER21', 'en', 'this field must contain at least 8 characters among the following: 0-9, a-z, -, _'),
('ER21', 'fr', 'ce champ doit contenir au moins 8 caractères parmi les suivants: 0-9, a-z, -, _'),
('ER22', 'en', 'you must accept the terms and conditions'),
('ER22', 'fr', 'vous devez accepter les termes et conditions'),
('ER23', 'en', 'this address already exists'),
('ER23', 'fr', 'cette adresse existe déjà'),
('ER24', 'en', 'the password confirmation is not correct'),
('ER24', 'fr', 'la confirmation du mot de passe n\'est pas correct'),
('ER25', 'en', 'this address does not exist'),
('ER25', 'fr', 'cette adresse n\'existe pas'),
('ER26', 'en', 'the password is not correct'),
('ER26', 'fr', 'le mot de passe est incorrect'),
('ER27', 'en', 'this field can only contain spaces as well as the following characters: a-z, 0-9, -, _'),
('ER27', 'fr', 'ce champ ne peut contenir que des espaces ainsi que les caractères suivant: a-z, 0-9, -, _'),
('ER28', 'en', 'this field can only contain spaces as well as the following characters: a-z, -, _'),
('ER28', 'fr', 'ce champ ne peut contenir que des espaces ainsi que les caractères suivant: a-z, -, _'),
('ER29', 'en', 'you have already registered this address'),
('ER29', 'fr', 'vous avez déjà enregistré cette adresse'),
('ER3', 'en', 'this field cannot contain numbers of the form 1997 | 297.829 or 0.321, etc ...'),
('ER3', 'fr', 'ce champ ne peut contenir des nombres de la forme 1997 | 297,829 ou 0,321, etc...'),
('ER30', 'en', 'stock error occurred'),
('ER30', 'fr', 'une erreur de stock s\'est produite'),
('ER31', 'en', 'you cannot proceed to payment because your shopping bag is empty'),
('ER31', 'fr', 'vous ne pouvez pas procéder au paiement car votre panier est vide'),
('ER32', 'en', 'sorry, this item is no longer available in the measurements you gave'),
('ER32', 'fr', 'désolé, cette article n\'est plus disponible dans les mesures que vous avez donné'),
('ER33', 'en', 'you already have this item with this measurement'),
('ER33', 'fr', 'vous avez déjà cet article avec cette mesure'),
('ER34', 'en', 'you already have this item in this size'),
('ER34', 'fr', 'vous avez déjà cet article dans cette taille'),
('ER35', 'en', 'please correct the above errors before continuing.'),
('ER35', 'fr', 'veuillez corriger les erreurs ci-dessus avant de continuer.'),
('ER36', 'en', 'you cannot change this measurement because it is used on an item.'),
('ER36', 'fr', 'vous ne pouvez pas modifier cette mesure car elle est utilisée sur un article.'),
('ER4', 'en', 'this field must start with a letter and can only contain letters, numbers, spaces and the characters `-` and ` _`'),
('ER4', 'fr', 'ce champ doit commencer par une lettre et peut uniquement contenir des lettres, des chiffres, des espaces et les caractères `-` et `_`'),
('ER5', 'en', 'you must tick a choice'),
('ER5', 'fr', 'vous devez cocher un choix'),
('ER6', 'en', 'the maximum number of characters for this field is'),
('ER6', 'fr', 'le nombre de caractère maximum pour ce champ est de'),
('ER7', 'en', 'this field can only contain numbers (0-9)'),
('ER7', 'fr', 'ce champ ne peut contenir que des chiffres (0-9)'),
('ER8', 'en', 'Sorry, You have reached the maximum number of measurements:'),
('ER8', 'fr', 'Désolé, Vous avez atteint le nombre maximum de mesure:'),
('ER9', 'en', 'you must check the option <b>\'Size\'</b> or <b>\'Custom size\'</b>'),
('ER9', 'fr', 'vous devez cocher l\'option <b>\'Taille\'</b> ou <b>\'Taille personnalisée\'</b>'),
('US1', 'en', 'filters'),
('US1', 'fr', 'filtres'),
('US10', 'en', 'color'),
('US10', 'fr', 'couleur'),
('US100', 'en', 'postal code'),
('US100', 'fr', 'code postal'),
('US101', 'en', 'phone(optional)'),
('US101', 'fr', 'téléphone(facultatif)'),
('US102', 'en', 'checkout'),
('US102', 'fr', 'commander'),
('US103', 'en', 'are you sure you want to log out?'),
('US103', 'fr', 'voulez-vous vraiment vous déconnecter?'),
('US104', 'en', 'your items will be reserved for the next {time} minutes'),
('US104', 'fr', 'vos articles seront réservés pour les {time} prochaines minutes'),
('US105', 'en', 'home'),
('US105', 'fr', 'accueil'),
('US106', 'en', 'sorry, an error occurred'),
('US106', 'fr', 'désolé, une erreur s\'est produite'),
('US107', 'en', '{brand} has been informed of the error and it will be fixed as\r\nas soon as possible.'),
('US107', 'fr', '{brand} a été informé de l\'erreur et elle sera corrigée au plus vite.'),
('US108', 'en', 'thank you, we have received your order'),
('US108', 'fr', 'merci, nous avons bien reçu votre commande'),
('US109', 'en', 'please check your email for order confirmation and delivery details.'),
('US109', 'fr', 'veuillez consulter votre messagerie pour obtenir la confirmation de commande et les détails de livraison.'),
('US11', 'en', 'price'),
('US11', 'fr', 'prix'),
('US110', 'en', 'click on the link below to track your order.'),
('US110', 'fr', 'cliquez sur le lien ci-dessous pour suivre votre commande.'),
('US111', 'en', 'track your order'),
('US111', 'fr', 'suivez votre commande'),
('US112', 'en', 'our teams are actively working to offer you the best tracking experience for your orders in the coming days.'),
('US112', 'fr', 'nos équipes travaillent activement pour vous offrir la meilleure expérience de suivi pour vos commandes dans les prochains jours.'),
('US113', 'en', 'coming soon'),
('US113', 'fr', 'bientôt disponible'),
('US114', 'en', 'meanwhile we will keep you informed of every change in status of your order on your email.'),
('US114', 'fr', 'en attendant, nous vous tiendrons informés de chaque changement de statut de votre commande sur votre messagerie.'),
('US115', 'en', 'shipping discount'),
('US115', 'fr', 'remise expédition'),
('US116', 'en', 'discount'),
('US116', 'fr', 'remise'),
('US117', 'en', 'free shipping for orders over {price} (excluding shipping costs)'),
('US117', 'fr', 'expédition gratuite pour les commandes de plus de {price} (hors frais d\'expédition)'),
('US118', 'en', 'total items'),
('US118', 'fr', 'total articles'),
('US12', 'en', 'minimum price'),
('US12', 'fr', 'prix minimum'),
('US13', 'en', 'maximum price'),
('US13', 'fr', 'prix maximum'),
('US14', 'en', 'apply'),
('US14', 'fr', 'filtrer'),
('US15', 'en', 'close filters'),
('US15', 'fr', 'fermer les filtres'),
('US16', 'en', 'measure name'),
('US16', 'fr', 'nom de la mesure'),
('US17', 'en', 'custom size'),
('US17', 'fr', 'taille personnalisée'),
('US18', 'en', 'choose a reference brand'),
('US18', 'fr', 'choisir une marque de référence'),
('US19', 'en', 'give my measurements'),
('US19', 'fr', 'donner mes mensurations'),
('US2', 'en', 'sort by'),
('US2', 'fr', 'trier'),
('US20', 'en', 'choose'),
('US20', 'fr', 'choisir'),
('US21', 'en', 'give measurements'),
('US21', 'fr', 'indiquer mensurations'),
('US22', 'en', 'manage measurements'),
('US22', 'fr', 'gérer mes mensurations'),
('US23', 'en', 'choose cut'),
('US23', 'fr', 'choisir une coupe'),
('US24', 'en', 'add'),
('US24', 'fr', 'ajouter'),
('US25', 'en', 'shopping bag'),
('US25', 'fr', 'panier'),
('US26', 'en', '3D secure & <br>AES-256 encrypted payement'),
('US26', 'fr', 'paiement crypté avec AES-256 et sécurisé avec 3D secure'),
('US27', 'en', 'customer service 24h/7 response in 1h'),
('US27', 'fr', 'service client 24h / 7 en 1h'),
('US28', 'en', 'free & <br>easy return'),
('US28', 'fr', 'retour facile et gratuit'),
('US29', 'en', 'details'),
('US29', 'fr', 'descriptions'),
('US3', 'en', 'newest'),
('US3', 'fr', 'les plus récents'),
('US30', 'en', 'shipping + return'),
('US30', 'fr', 'livraison + retour'),
('US31', 'en', 'delivery and return terms'),
('US31', 'fr', 'modalité de livraison et retour'),
('US32', 'en', 'suggestions'),
('US32', 'fr', 'suggestions'),
('US33', 'en', 'reference brand'),
('US33', 'fr', 'marques de référence'),
('US34', 'en', 'select'),
('US34', 'fr', 'sélectionner'),
('US35', 'en', 'choose a reference brand for the size:'),
('US35', 'fr', 'choisissez une marque de référence pour la taille:'),
('US36', 'en', 'my measurements'),
('US36', 'fr', 'mes mensurations'),
('US37', 'en', 'save'),
('US37', 'fr', 'enregistrer'),
('US38', 'en', 'indicate your measurements:'),
('US38', 'fr', 'indiquez vos mensurations:'),
('US39', 'en', 'bust'),
('US39', 'fr', 'buste'),
('US4', 'en', 'older'),
('US4', 'fr', 'les moins récents'),
('US40', 'en', 'arm'),
('US40', 'fr', 'bras'),
('US41', 'en', 'waist'),
('US41', 'fr', 'taille'),
('US42', 'en', 'hip'),
('US42', 'fr', 'hanche'),
('US43', 'en', 'inseam'),
('US43', 'fr', 'entrejambe'),
('US44', 'en', 'add measurement'),
('US44', 'fr', 'ajouter une mesure'),
('US45', 'en', 'your measurements'),
('US45', 'fr', 'vos mensurations'),
('US46', 'en', 'customization'),
('US46', 'fr', 'personnalisation'),
('US47', 'en', 'brand'),
('US47', 'fr', 'marque'),
('US48', 'en', 'measure'),
('US48', 'fr', 'mesure'),
('US49', 'en', 'add a new shipping address'),
('US49', 'fr', 'ajouter une nouvelle adresse de livraison'),
('US5', 'en', 'price - hight to low'),
('US5', 'fr', 'prix - décroissant'),
('US50', 'en', 'Are you sure you want to delete this measurement?'),
('US50', 'fr', 'Voulez-vous vraiment supprimer cette mesure?'),
('US51', 'en', 'no result'),
('US51', 'fr', 'aucun resultat'),
('US52', 'en', 'cut'),
('US52', 'fr', 'coupe'),
('US53', 'en', 'items'),
('US53', 'fr', 'articles'),
('US54', 'en', 'quantity'),
('US54', 'fr', 'quantité'),
('US55', 'en', 'box'),
('US55', 'fr', 'box'),
('US57', 'en', 'total'),
('US57', 'fr', 'total'),
('US58', 'en', 'Are you sure you want to delete this box?'),
('US58', 'fr', 'Voulez-vous vraiment supprimer cette box?'),
('US59', 'en', 'select a box where to place your item:'),
('US59', 'fr', 'sélectionnez une box où placer votre article:'),
('US6', 'en', 'price - low to hight'),
('US6', 'fr', 'prix - croissant'),
('US60', 'en', 'select a box to move your item to:'),
('US60', 'fr', 'sélectionnez une box où déplacer votre article:'),
('US61', 'en', 'choose the box that suits you:'),
('US61', 'fr', 'choisissez la box qui vous convient:'),
('US62', 'en', 'change size'),
('US62', 'fr', 'modifier la taille'),
('US63', 'en', 'change box'),
('US63', 'fr', 'changer de box'),
('US64', 'en', 'are you sure you want to delete this item?'),
('US64', 'fr', 'voulez-vous vraiment supprimer cet article?'),
('US65', 'en', 'country'),
('US65', 'fr', 'pays'),
('US66', 'en', 'shipping cost'),
('US66', 'fr', 'frais expédition'),
('US67', 'en', 'delivery costs are free'),
('US67', 'fr', 'les frais de livraison sont offerts'),
('US68', 'en', 'processing'),
('US68', 'fr', 'en traitement'),
('US69', 'en', 'empty boxes have been automatically deleted'),
('US69', 'fr', 'les boxes vides ont été automatiquement supprimées'),
('US7', 'en', 'type'),
('US7', 'fr', 'type'),
('US70', 'en', 'hi'),
('US70', 'fr', 'bonjour'),
('US71', 'en', 'your order is in preparation'),
('US71', 'fr', 'votre commande est en préparation '),
('US72', 'en', 'thank you for your confidence'),
('US72', 'fr', 'merci de votre confiance'),
('US73', 'en', 'your order is currently in preparation'),
('US73', 'fr', 'votre commande est actuellement en préparation'),
('US74', 'en', 'you will receive a new message as soon as we have shipped your order'),
('US74', 'fr', 'vous recevrez un nouveau message aussi tôt que nous aurons  expédié votre commande'),
('US75', 'en', 'you can follow the progress of your order at any time'),
('US75', 'fr', 'vous pouvez à tout moment suivre l\'évolution de votre commande'),
('US76', 'en', 'here'),
('US76', 'fr', 'ici'),
('US77', 'en', 'delivery'),
('US77', 'fr', 'livraison'),
('US78', 'en', 'item number'),
('US78', 'fr', 'nombre d\'article'),
('US79', 'en', 'shipping'),
('US79', 'fr', 'expédition'),
('US8', 'en', 'category'),
('US8', 'fr', 'catégorie'),
('US80', 'en', 'vat'),
('US80', 'fr', 'tva'),
('US81', 'en', 'subtotal'),
('US81', 'fr', 'sous-total'),
('US82', 'en', 'total'),
('US82', 'fr', 'total'),
('US83', 'en', 'see my order'),
('US83', 'fr', 'voir ma commande'),
('US84', 'en', 'thanks'),
('US84', 'fr', 'merci'),
('US85', 'en', '{brand}\'s team'),
('US85', 'fr', 'l\'équipe {brand}'),
('US86', 'en', 'contact us'),
('US86', 'fr', 'nous contacter'),
('US87', 'en', 'changed your mind?'),
('US87', 'fr', 'tu as changé d\'avis?'),
('US88', 'en', 'unsubscribe'),
('US88', 'fr', 'se désabonner'),
('US89', 'en', 'social media'),
('US89', 'fr', 'nos réseaux'),
('US9', 'en', 'size'),
('US9', 'fr', 'taille'),
('US90', 'en', 'stay up-to-date with current activities and future events or share with us your experience by following us on your favorite social media.'),
('US90', 'fr', 'reste informé sur nos dernières actions et nos événements ou partage juste ton expérience avec nous en nous suivant sur ton réseaux favoris.'),
('US91', 'en', 'your order confirmation'),
('US91', 'fr', 'confirmation de votre commande'),
('US92', 'en', 'customer service'),
('US92', 'fr', 'service client'),
('US93', 'en', 'shipping address'),
('US93', 'fr', 'adresse de livraison'),
('US94', 'en', 'new address'),
('US94', 'fr', 'nouvelle adresse'),
('US95', 'en', 'select a shipping address'),
('US95', 'fr', 'sélectionnez une adresse de livraison'),
('US96', 'en', 'address'),
('US96', 'fr', 'adresse'),
('US97', 'en', 'apartment, suite,.(optional)'),
('US97', 'fr', 'appartement, suite,.(facultatif)'),
('US98', 'en', 'state, province, region, etc...'),
('US98', 'fr', 'province, région, état, etc...'),
('US99', 'en', 'city'),
('US99', 'fr', 'ville');

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `userID` varchar(50) NOT NULL,
  `lang_` varchar(10) DEFAULT NULL,
  `country_` varchar(100) NOT NULL,
  `iso_currency` varchar(10) NOT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
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

INSERT INTO `Users` (`userID`, `lang_`, `country_`, `iso_currency`, `mail`, `password`, `firstname`, `lastname`, `birthday`, `newsletter`, `sexe_`, `setDate`) VALUES
('1', NULL, 'belgium', 'eur', 'system@mail.domain', 'no password', 'system', 'system', '2019-09-01', NULL, 'other', '2020-10-09 18:42:45'),
('usr_0952slu1412wy02e1105z2y30', 'en', 'other', 'eur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-13 05:29:50'),
('usr_1fi1003j152532f4cx10uw232', 'en', 'other', 'eur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-13 05:34:51'),
('usr_5t20ai37b3014p1v412052dp5', 'en', 'other', 'eur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-13 05:44:54'),
('usr_t5br0n93211165003212753st', 'en', 'other', 'eur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-13 05:39:53');

-- --------------------------------------------------------

--
-- Structure de la table `Users-Cookies`
--

CREATE TABLE `Users-Cookies` (
  `userId` varchar(50) NOT NULL,
  `cookieId` varchar(50) NOT NULL,
  `cookieValue` varchar(200) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL,
  `settedPeriod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Users-Cookies`
--

INSERT INTO `Users-Cookies` (`userId`, `cookieId`, `cookieValue`, `domain`, `path`, `setDate`, `settedPeriod`) VALUES
('1', 'ADM', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 10800),
('1', 'CLT', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 31536000),
('1', 'VIS', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 94608000);

-- --------------------------------------------------------

--
-- Structure de la table `Users-Privileges`
--

CREATE TABLE `Users-Privileges` (
  `userId` varchar(50) NOT NULL,
  `privId` varchar(50) NOT NULL,
  `beginDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Users-Privileges`
--

INSERT INTO `Users-Privileges` (`userId`, `privId`, `beginDate`, `endDate`) VALUES
('1', 'system', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `UsersMeasures`
--

CREATE TABLE `UsersMeasures` (
  `userId` varchar(50) NOT NULL,
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
-- Index pour les tables déchargées
--

--
-- Index pour la table `Addresses`
--
ALTER TABLE `Addresses`
  ADD PRIMARY KEY (`userId`,`address`,`zipcode`,`country_`) USING BTREE,
  ADD KEY `fk_country_.Addresses-FROM-Countries` (`country_`);

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
  ADD PRIMARY KEY (`boxId`) USING BTREE,
  ADD KEY `userId` (`userId`);

--
-- Index pour la table `Baskets-Products`
--
ALTER TABLE `Baskets-Products`
  ADD PRIMARY KEY (`userId`,`prodId`,`size_name`) USING BTREE,
  ADD KEY `fk_basketProdId.Baskets-Products-FROM-Products` (`prodId`),
  ADD KEY `fk_size_name.Baskets-Products-FROM-Sizes` (`size_name`);

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
-- Index pour la table `BoxArguments`
--
ALTER TABLE `BoxArguments`
  ADD PRIMARY KEY (`box_color`,`argID`);

--
-- Index pour la table `BoxColors`
--
ALTER TABLE `BoxColors`
  ADD PRIMARY KEY (`boxColor`);

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
-- Index pour la table `Companies`
--
ALTER TABLE `Companies`
  ADD PRIMARY KEY (`company`);

--
-- Index pour la table `Constants`
--
ALTER TABLE `Constants`
  ADD PRIMARY KEY (`constName`);

--
-- Index pour la table `Cookies`
--
ALTER TABLE `Cookies`
  ADD PRIMARY KEY (`cookieID`);

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
  ADD KEY `fk_navId.Devices-FROM-Navigations` (`navId`);

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
-- Index pour la table `EmailsSent`
--
ALTER TABLE `EmailsSent`
  ADD PRIMARY KEY (`messageID`,`recipient`),
  ADD KEY `messageID` (`messageID`),
  ADD KEY `fk_mailer_.EmailsSent-FROM-Mailers` (`mailer_`);

--
-- Index pour la table `EmailsStatus`
--
ALTER TABLE `EmailsStatus`
  ADD PRIMARY KEY (`messageId`,`status`,`eventDate`);

--
-- Index pour la table `EmailsTags`
--
ALTER TABLE `EmailsTags`
  ADD PRIMARY KEY (`messageId`,`tag`);

--
-- Index pour la table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`eventCode`);

--
-- Index pour la table `EventsDatas`
--
ALTER TABLE `EventsDatas`
  ADD PRIMARY KEY (`eventId`,`dataKey`);

--
-- Index pour la table `Languages`
--
ALTER TABLE `Languages`
  ADD PRIMARY KEY (`langIsoCode`);

--
-- Index pour la table `Locations`
--
ALTER TABLE `Locations`
  ADD PRIMARY KEY (`navId`) USING BTREE;

--
-- Index pour la table `Mailers`
--
ALTER TABLE `Mailers`
  ADD PRIMARY KEY (`mailer`);

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
-- Index pour la table `Navigations`
--
ALTER TABLE `Navigations`
  ADD PRIMARY KEY (`navID`) USING BTREE,
  ADD KEY `fk_userId.Pages-FROM-Users` (`userId`);

--
-- Index pour la table `Navigations-Events`
--
ALTER TABLE `Navigations-Events`
  ADD PRIMARY KEY (`xhrId`) USING BTREE,
  ADD UNIQUE KEY `eventID` (`eventID`) USING BTREE,
  ADD KEY `event_code` (`event_code`);

--
-- Index pour la table `NavigationsParameters`
--
ALTER TABLE `NavigationsParameters`
  ADD PRIMARY KEY (`navId`,`paramKey`) USING BTREE;

--
-- Index pour la table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD UNIQUE KEY `stripeSessionId` (`stripeCheckoutId`),
  ADD KEY `fk_userId.Orders-FROM-Users` (`userId`),
  ADD KEY `fk_iso_currency.Orders-FROM-Currencies` (`iso_currency`);

--
-- Index pour la table `Orders-Addresses`
--
ALTER TABLE `Orders-Addresses`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `fk_country_.Orders-Addresses-FROM-Countries` (`country_`);

--
-- Index pour la table `Orders-Boxes`
--
ALTER TABLE `Orders-Boxes`
  ADD PRIMARY KEY (`orderId`,`boxId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `boxId` (`boxId`);

--
-- Index pour la table `Orders-BoxProducts`
--
ALTER TABLE `Orders-BoxProducts`
  ADD PRIMARY KEY (`boxId`,`prodId`,`sequenceID`) USING BTREE,
  ADD KEY `fk_prodId.Orders-BoxProducts-FROM-Products` (`prodId`),
  ADD KEY `fk_brand_name.Orders-BoxProducts-FROM-BrandsMeasures` (`brand_name`),
  ADD KEY `fk_cut_name.Orders-BoxProducts-FROM-Cuts` (`cut_name`),
  ADD KEY `fk_measureId.Orders-BoxProducts-FROM-Orders-UsersMeasures` (`measureId`),
  ADD KEY `fl_realSize.Orders-BoxProducts-FROM-Sizes` (`realSize`);

--
-- Index pour la table `Orders-DiscountCodes`
--
ALTER TABLE `Orders-DiscountCodes`
  ADD PRIMARY KEY (`orderId`,`discount_code`),
  ADD KEY `fk_discount_code.Orders-DiscountCodes-FROM-DiscountCodes` (`discount_code`);

--
-- Index pour la table `Orders-UsersMeasures`
--
ALTER TABLE `Orders-UsersMeasures`
  ADD PRIMARY KEY (`orderId`,`measureID`),
  ADD KEY `fk_unit_name.Orders-UsersMeasures-FROM-MeasureUnits` (`unit_name`),
  ADD KEY `measureID` (`measureID`);

--
-- Index pour la table `OrdersStatus`
--
ALTER TABLE `OrdersStatus`
  ADD PRIMARY KEY (`orderId`,`status`) USING BTREE,
  ADD KEY `fk_adminId.OrdersStatus-FROM-Users` (`adminId`);

--
-- Index pour la table `Payements`
--
ALTER TABLE `Payements`
  ADD PRIMARY KEY (`payID`) USING BTREE,
  ADD KEY `fk_company_.Payements-FROM-Companies` (`company_`);

--
-- Index pour la table `Privileges`
--
ALTER TABLE `Privileges`
  ADD PRIMARY KEY (`privID`);

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
-- Index pour la table `ProductsNames`
--
ALTER TABLE `ProductsNames`
  ADD PRIMARY KEY (`prodId`,`lang_`),
  ADD KEY `fk-lang_.ProductsNames-FROM-Products` (`lang_`);

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
-- Index pour la table `SizesMeasures`
--
ALTER TABLE `SizesMeasures`
  ADD PRIMARY KEY (`size_name`,`body_part`) USING BTREE,
  ADD KEY `FK_body_part.SizesMeasures-FROM-BodyPart` (`body_part`),
  ADD KEY `FK_unit_name.SizesMeasures-FROM-MeasureUnits` (`unit_name`);

--
-- Index pour la table `StockLocks`
--
ALTER TABLE `StockLocks`
  ADD PRIMARY KEY (`userId`,`prodId`,`size_name`),
  ADD KEY `fk_prodId.size_name.StockLocks-FROM-Products-Sizes` (`prodId`,`size_name`);

--
-- Index pour la table `StripeCheckoutSessions`
--
ALTER TABLE `StripeCheckoutSessions`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `fk_pay_method.StripeCheckoutSessions-FROM-Payemsnts` (`payId`),
  ADD KEY `fk_userId.StripeCheckoutSessions-FROM-Users` (`userId`),
  ADD KEY `fk-iso_currency.StripeCheckoutSessions-FROM-Currencies` (`iso_currency`);

--
-- Index pour la table `Translations`
--
ALTER TABLE `Translations`
  ADD PRIMARY KEY (`translationID`,`iso_lang`) USING BTREE,
  ADD KEY `fk_Translation.isolang-FROM-Languages` (`iso_lang`);

--
-- Index pour la table `TranslationStations`
--
ALTER TABLE `TranslationStations`
  ADD PRIMARY KEY (`station`,`iso_lang`) USING BTREE,
  ADD KEY `fk_iso_lang.TranslationStations-FROM-Languages` (`iso_lang`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `fk_lang_FROM-Languages` (`lang_`),
  ADD KEY `fk_sexe_FROM-Sexes` (`sexe_`),
  ADD KEY `fk_country_-FROM-Country` (`country_`),
  ADD KEY `fk_iso_currency-FROM-Currency` (`iso_currency`);

--
-- Index pour la table `Users-Cookies`
--
ALTER TABLE `Users-Cookies`
  ADD PRIMARY KEY (`userId`,`cookieId`),
  ADD UNIQUE KEY `cookieId` (`cookieId`,`cookieValue`);

--
-- Index pour la table `Users-Privileges`
--
ALTER TABLE `Users-Privileges`
  ADD PRIMARY KEY (`userId`,`privId`),
  ADD KEY `fk_privId.Users-Privileges-FROM-Users` (`privId`),
  ADD KEY `userId` (`userId`);

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
-- AUTO_INCREMENT pour la table `Translations`
--
ALTER TABLE `Translations`
  MODIFY `translationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Addresses`
--
ALTER TABLE `Addresses`
  ADD CONSTRAINT `fk_country_.Addresses-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Addresses-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

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
-- Contraintes pour la table `BoxArguments`
--
ALTER TABLE `BoxArguments`
  ADD CONSTRAINT `fk_box_color.BoxArguments-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_navId.Devices-FROM-Navigations` FOREIGN KEY (`navId`) REFERENCES `Navigations` (`navID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Contraintes pour la table `EmailsSent`
--
ALTER TABLE `EmailsSent`
  ADD CONSTRAINT `fk_mailer_.EmailsSent-FROM-Mailers` FOREIGN KEY (`mailer_`) REFERENCES `Mailers` (`mailer`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `EmailsStatus`
--
ALTER TABLE `EmailsStatus`
  ADD CONSTRAINT `fk-messageId.EmailsStatus-FROM-EmailsSent` FOREIGN KEY (`messageId`) REFERENCES `EmailsSent` (`messageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EmailsTags`
--
ALTER TABLE `EmailsTags`
  ADD CONSTRAINT `fk-messageId.EmailsTags-FROM-EmailsSent` FOREIGN KEY (`messageId`) REFERENCES `EmailsSent` (`messageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EventsDatas`
--
ALTER TABLE `EventsDatas`
  ADD CONSTRAINT `fk-eventId.EventsDatas-FROM-Navigations-Events` FOREIGN KEY (`eventId`) REFERENCES `Navigations-Events` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Locations`
--
ALTER TABLE `Locations`
  ADD CONSTRAINT `fk-navId.Locations-FROM-Navigations` FOREIGN KEY (`navId`) REFERENCES `Navigations` (`navID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Navigations`
--
ALTER TABLE `Navigations`
  ADD CONSTRAINT `fk_userId.Pages-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Navigations-Events`
--
ALTER TABLE `Navigations-Events`
  ADD CONSTRAINT `fk-event_code.Navigations-Events-FROM-Events` FOREIGN KEY (`event_code`) REFERENCES `Events` (`eventCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-navId.Navigations-Events-FROM-Navigations` FOREIGN KEY (`xhrId`) REFERENCES `Navigations` (`navID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `NavigationsParameters`
--
ALTER TABLE `NavigationsParameters`
  ADD CONSTRAINT `fk-navId.NavigationsParameters-FROM-Navigations` FOREIGN KEY (`navId`) REFERENCES `Navigations` (`navID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `fk_iso_currency.Orders-FROM-Currencies` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stripeSessionId.Orders-FROM-StripeCheckoutSessions` FOREIGN KEY (`stripeCheckoutId`) REFERENCES `StripeCheckoutSessions` (`sessionID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Orders-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-Addresses`
--
ALTER TABLE `Orders-Addresses`
  ADD CONSTRAINT `fk_country_.Orders-Addresses-FROM-Countries` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.Orders-Addresses-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-Boxes`
--
ALTER TABLE `Orders-Boxes`
  ADD CONSTRAINT `fk_orderId.Orders-Box-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-BoxProducts`
--
ALTER TABLE `Orders-BoxProducts`
  ADD CONSTRAINT `fk_boxId.Orders-BoxProducts-FROM-Orders-Box` FOREIGN KEY (`boxId`) REFERENCES `Orders-Boxes` (`boxId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_brand_name.Orders-BoxProducts-FROM-BrandsMeasures` FOREIGN KEY (`brand_name`) REFERENCES `BrandsMeasures` (`brandName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cut_name.Orders-BoxProducts-FROM-Cuts` FOREIGN KEY (`cut_name`) REFERENCES `Cuts` (`cutName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_measureId.Orders-BoxProducts-FROM-Orders-UsersMeasures` FOREIGN KEY (`measureId`) REFERENCES `Orders-UsersMeasures` (`measureID`),
  ADD CONSTRAINT `fk_prodId.Orders-BoxProducts-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fl_realSize.Orders-BoxProducts-FROM-Sizes` FOREIGN KEY (`realSize`) REFERENCES `Sizes` (`sizeName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-DiscountCodes`
--
ALTER TABLE `Orders-DiscountCodes`
  ADD CONSTRAINT `fk_discount_code.Orders-DiscountCodes-FROM-DiscountCodes` FOREIGN KEY (`discount_code`) REFERENCES `DiscountCodes` (`discountCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.Orders-DiscountCodes-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Orders-UsersMeasures`
--
ALTER TABLE `Orders-UsersMeasures`
  ADD CONSTRAINT `fk_orderId.Orders-UsersMeasures-FROM-Orders-Boxes` FOREIGN KEY (`orderId`) REFERENCES `Orders-Boxes` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_unit_name.Orders-UsersMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`);

--
-- Contraintes pour la table `OrdersStatus`
--
ALTER TABLE `OrdersStatus`
  ADD CONSTRAINT `fk_adminId.OrdersStatus-FROM-Users` FOREIGN KEY (`adminId`) REFERENCES `Users-Privileges` (`userId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderId.OrdersStatus-FROM-Orders` FOREIGN KEY (`orderId`) REFERENCES `Orders` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Payements`
--
ALTER TABLE `Payements`
  ADD CONSTRAINT `fk_company_.Payements-FROM-Companies` FOREIGN KEY (`company_`) REFERENCES `Companies` (`company`) ON UPDATE CASCADE;

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
-- Contraintes pour la table `ProductsNames`
--
ALTER TABLE `ProductsNames`
  ADD CONSTRAINT `fk-lang_.ProductsNames-FROM-Products` FOREIGN KEY (`lang_`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-prodId.ProductsNames-FROM-Products` FOREIGN KEY (`prodId`) REFERENCES `Products` (`prodID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Contraintes pour la table `SizesMeasures`
--
ALTER TABLE `SizesMeasures`
  ADD CONSTRAINT `FK_body_part.SizesMeasures-FROM-BodyPart` FOREIGN KEY (`body_part`) REFERENCES `BodyParts` (`bodyPart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_size_name.SizesMeasures-FROM-Sizes` FOREIGN KEY (`size_name`) REFERENCES `Sizes` (`sizeName`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_unit_name.SizesMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `StockLocks`
--
ALTER TABLE `StockLocks`
  ADD CONSTRAINT `fk_prodId.size_name.StockLocks-FROM-Products-Sizes` FOREIGN KEY (`prodId`,`size_name`) REFERENCES `Products-Sizes` (`prodId`, `size_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.StockLocks-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `StripeCheckoutSessions`
--
ALTER TABLE `StripeCheckoutSessions`
  ADD CONSTRAINT `fk-iso_currency.StripeCheckoutSessions-FROM-Currencies` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pay_method.StripeCheckoutSessions-FROM-Payemsnts` FOREIGN KEY (`payId`) REFERENCES `Payements` (`payID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.StripeCheckoutSessions-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Translations`
--
ALTER TABLE `Translations`
  ADD CONSTRAINT `fk_Translation.isolang-FROM-Languages` FOREIGN KEY (`iso_lang`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `TranslationStations`
--
ALTER TABLE `TranslationStations`
  ADD CONSTRAINT `fk_iso_lang.TranslationStations-FROM-Languages` FOREIGN KEY (`iso_lang`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_country_-FROM-Country` FOREIGN KEY (`country_`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iso_currency-FROM-Currency` FOREIGN KEY (`iso_currency`) REFERENCES `Currencies` (`isoCurrency`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lang_FROM-Languages` FOREIGN KEY (`lang_`) REFERENCES `Languages` (`langIsoCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sexe_FROM-Sexes` FOREIGN KEY (`sexe_`) REFERENCES `Sexes` (`sexe`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users-Cookies`
--
ALTER TABLE `Users-Cookies`
  ADD CONSTRAINT `FK_cookieId.Users-Cookies-FROM-Cookies` FOREIGN KEY (`cookieId`) REFERENCES `Cookies` (`cookieID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userId.Users-Cookies-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `Users-Privileges`
--
ALTER TABLE `Users-Privileges`
  ADD CONSTRAINT `fk_privId.Users-Privileges-FROM-Users` FOREIGN KEY (`privId`) REFERENCES `Privileges` (`privID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userId.Users-Privileges-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UsersMeasures`
--
ALTER TABLE `UsersMeasures`
  ADD CONSTRAINT `FK_unit_name.UsersMeasures-FROM-MeasureUnits` FOREIGN KEY (`unit_name`) REFERENCES `MeasureUnits` (`unitName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userId.UsersMeasures-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;