-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  Dim 13 déc. 2020 à 00:20
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `meimbox`
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

--
-- Déchargement des données de la table `Addresses`
--

INSERT INTO `Addresses` (`userId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `setDate`) VALUES
(3330090, 'place royale 4', '1640', 'belgium', 'villa', 'miami', 'rodeo drive', '472174210', '2020-12-01 23:18:03'),
(3330090, 'place royale 4', '1640abc', 'belgium', 'studio', 'bruxelles', 'rhode-saint-genese', '472174210', '2020-10-02 16:14:54');

-- --------------------------------------------------------

--
-- Structure de la table `Basket-DiscountCodes`
--

CREATE TABLE `Basket-DiscountCodes` (
  `userId` varchar(50) NOT NULL,
  `discount_code` varchar(50) NOT NULL,
  `setDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Basket-DiscountCodes`
--

INSERT INTO `Basket-DiscountCodes` (`userId`, `discount_code`, `setDate`) VALUES
(3330090, 'free_shipping_au', '2020-12-10 22:40:01'),
(3330090, 'free_shipping_be', '2020-12-11 22:19:42');

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
  `prodId` int(11) NOT NULL,
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
  `prodId` int(11) NOT NULL,
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
('gold', 10, 0.125, 'rgba(255, 211, 0, 0.7)', 'rgba(255, 211, 0)', '#ffffff', 'box-gold-128.png', 374),
('regular', 4, 0.05, '#ffffff', 'rgba(14, 36, 57, 0.8)', 'rgba(14, 36, 57, 0.5)', 'box-regular-128.png', 32),
('silver', 6, 0.075, 'rgba(229, 229, 231, 0.5)', '#C6C6C7', 'rgba(14, 36, 57, 0.5)', 'box-silver-128.png', 54);

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
('002ju101v150c24oad32102a4', 'regular', '2020-11-23 01:44:25'),
('0102nn102ok08f0s034581022', 'silver', '2020-12-02 10:00:58'),
('0220310516202mz488fk1ks12', 'gold', '2020-12-02 10:18:51'),
('022d4i8k11435204f6sc027q0', 'gold', '2020-12-08 21:40:43'),
('022i90x55y3013ue680l10125', 'gold', '2020-10-13 09:58:50'),
('02em0u14832203jsc15810220', 'regular', '2020-12-02 08:52:01'),
('02hm75350n91q2000042my115', 'regular', '2020-11-20 05:30:50'),
('03l9e089l1o1l2012340t2807', 'silver', '2020-12-09 03:37:08'),
('043802dr0nhf991540002225o', 'regular', '2020-12-09 05:09:28'),
('05y028021l4503zt2094a121f', 'regular', '2020-12-02 09:05:51'),
('0782s02x110n1n3v327i7y10h', 'silver', '2020-10-07 17:33:27'),
('07ev531313rul51o25220p12m', 'gold', '2020-11-17 23:35:55'),
('08326049q32vja4nj23038710', 'gold', '2020-12-09 03:37:46'),
('0860g1009tn0i31s2s6b24112', 'gold', '2020-09-16 21:40:10'),
('0ca4ie800824k256i21011m1v', 'regular', '2020-10-20 18:58:41'),
('0d42zt2132g74903007x21q4e', 'silver', '2020-12-09 13:20:43'),
('0gi1031159y53i7209g2o2r40', 'gold', '2020-09-15 13:20:53'),
('0l520a2034290122u05phd814', 'silver', '2020-12-09 12:43:08'),
('0n57q1k1902082n05n9ug5280', 'silver', '2020-09-17 09:50:58'),
('0oh7351vn2i97209i0044922u', 'regular', '2020-12-02 09:53:49'),
('0scu6021211229002d1x42bq7', 'gold', '2020-12-02 10:19:21'),
('0t31d5p2i200l221t4i9k52s9', 'silver', '2020-12-09 12:52:59'),
('0uj18003912412m142z1l16sl', 'silver', '2020-10-13 14:19:28'),
('0vqd2r4629d8126l00103120p', 'silver', '2020-12-02 10:16:08'),
('101222k1f1s02e0m43237171e', 'silver', '2020-11-20 17:24:11'),
('1015q398el203w025f0012211', 'gold', '2020-10-10 18:20:35'),
('102901079c41fcg2mtw96t40d', 'regular', '2020-09-17 09:49:41'),
('1081222m9cb242z00lml9040j', 'silver', '2020-12-09 12:40:29'),
('10qh62j132wz140d3g82013m1', 'gold', '2020-11-13 13:43:08'),
('111p35q11aq70124v2yf00120', 'gold', '2020-11-21 11:03:54'),
('11bqwo2f11231800vpg50f21d', 'regular', '2020-10-13 12:11:58'),
('120p222c5150ym3wt2308y193', 'gold', '2020-09-25 22:31:35'),
('122l41wz1m49o1i31352a00f0', 'regular', '2020-10-11 21:44:35'),
('1232v21310hu04d2j0w9f3b2e', 'gold', '2020-09-23 14:23:23'),
('12a00o11g514x80220331w0gt', 'regular', '2020-10-20 18:15:01'),
('12t1u4201g2e26ld0021re51n', 'regular', '2020-10-21 12:25:16'),
('131u45w04001h52945214200j', 'gold', '2020-10-01 14:25:40'),
('164o1150kc229l2n16j2t4301', 'regular', '2020-11-21 12:46:53'),
('172201n692n4r02121wa44c32', 'regular', '2020-12-12 22:41:13'),
('182269c17d0972rf2q0012ot1', 'regular', '2020-09-27 12:18:12'),
('1832x241x9902l400240nr250', 'silver', '2020-12-09 12:44:00'),
('1a11b2gb2m6705201z9gh27b0', 'regular', '2020-11-05 17:26:29'),
('1f232031010429a2f1d0ds084', 'regular', '2020-10-20 18:09:23'),
('1f83001u10234m2f6120228fn', 'regular', '2020-12-10 13:22:01'),
('1g84sa23913n2o5011w014041', 'silver', '2020-10-13 14:38:45'),
('200e2001142d00916f4kjecbs', 'regular', '2020-09-16 21:40:04'),
('20341003s1w013ky47va1s422', 'regular', '2020-10-13 14:40:33'),
('203dj0201292241d004pm04n2', 'silver', '2020-12-09 13:04:42'),
('204120c99yizfw202s2pe400x', 'regular', '2020-12-02 09:02:49'),
('204j10d1410q212cn22qv1198', 'gold', '2020-11-04 12:12:19'),
('20624c38202162k71w10wg3b1', 'silver', '2020-12-10 13:21:38'),
('206410kj7o2v1p9022l71o0u3', 'silver', '2020-12-09 13:06:21'),
('20a31i02ev20lc1122pzi1501', 'silver', '2020-10-21 12:25:31'),
('20g111t2323sd39gus5000020', 'silver', '2020-11-20 05:33:09'),
('20wl02120p92304x6p0l0ff12', 'regular', '2020-12-02 10:00:29'),
('2101ax216y4e4x31322j4z0l5', 'silver', '2020-12-11 23:43:45'),
('210e40ty12v1e2m101271z273', 'silver', '2020-11-04 12:12:12'),
('21rta90q0o5j9120230182424', 'regular', '2020-10-13 09:45:24'),
('22062fl1210dddu0101lj0243', 'gold', '2020-10-11 22:03:42'),
('2211026j1098pg7101h94164u', 'regular', '2020-11-16 10:28:19'),
('221251413024ql01301424n3x', 'gold', '2020-11-22 13:34:34'),
('22182cy101u6rm01l42y15523', 'silver', '2020-12-11 23:15:15'),
('222o24c5210m51o3s4141q290', 'silver', '2020-12-11 23:45:59'),
('228js300w1092410bw0151q82', 'gold', '2020-10-13 21:09:52'),
('23007904001e06e002s2151v3', 'regular', '2020-12-09 05:10:00'),
('23711q0kcj9k2g2b201411422', 'silver', '2020-12-11 23:14:21'),
('28p24122nv001l11m1u051122', 'gold', '2020-10-11 22:14:22'),
('2a1ta22010112sqsiz250z331', 'gold', '2020-10-11 22:13:53'),
('2bq2o8241z00312h112qiw20p', 'gold', '2020-12-11 22:21:38'),
('2d0241oby7q29r21910274a2l', 'gold', '2020-12-11 22:29:47'),
('2lv1th2u3h05211200dz1c0o1', 'gold', '2020-10-21 21:15:03'),
('2t202a12412c1z9001anl24o9', 'regular', '2020-12-11 22:29:41'),
('2x8gb01iw9130u22210422450', 'gold', '2020-09-14 12:45:08'),
('2y102j12q440y842009wf1bt2', 'regular', '2020-12-09 12:40:18'),
('2yy0915653022280at1m10zv1', 'silver', '2020-10-13 21:08:52'),
('3019052jy84w2h0120ww1102i', 'silver', '2020-12-09 13:01:01'),
('30owo260119100q2f9cl25im1', 'silver', '2020-09-15 13:21:09'),
('310m035013939e0523112udmk', 'gold', '2020-09-30 11:53:33'),
('319001s1sf2h4y02822x12oc4', 'silver', '2020-11-21 02:43:28'),
('3281h410s13h04g6023v921cf', 'regular', '2020-12-10 13:13:48'),
('336210a021090uq4210117p4n', 'gold', '2020-11-21 03:01:40'),
('35020w41820k0sj10025v44h1', 'gold', '2020-11-20 05:34:48'),
('3b004t722e22t00230n40r1ar', 'gold', '2020-12-03 04:03:22'),
('3v1f152r242f044kc072121a1', 'silver', '2020-12-11 21:35:24'),
('4010cb5272256g095m1402hxu', 'regular', '2020-12-02 15:56:40'),
('402i3x316hr4021df1p014u12', 'regular', '2020-11-16 10:34:42'),
('421cgh2o222160508a51v0nk9', 'regular', '2020-11-26 20:59:54'),
('43012119426c1b0jy02xt21j1', 'silver', '2020-11-21 10:34:19'),
('480o1xrh421114nz02i002v72', 'silver', '2020-12-08 21:40:11'),
('491g0475l02r04mv24225m811', 'silver', '2020-12-09 12:55:44'),
('4k2501t22229nm0u4c50ets01', 'regular', '2020-12-02 09:25:14'),
('525gp5h596a001246i2160052', 'regular', '2020-12-02 09:55:15'),
('55v092dc07o113020e420tq14', 'silver', '2020-12-09 05:10:53'),
('607029oh2y1x0j1zj41101x05', 'silver', '2020-10-11 15:40:07'),
('611026076001h2su60044z19i', 'regular', '2020-10-06 17:19:04'),
('6724nwr140i12120gm0115er1', 'gold', '2020-11-20 16:47:14'),
('70r904v2240t0292ko1514055', 'silver', '2020-09-24 17:55:02'),
('7107yg91203k0o110239dk641', 'regular', '2020-11-16 10:33:07'),
('7248u731q010sj978202110nk', 'regular', '2020-10-07 18:27:43'),
('75401240129x5c0820bvmng2w', 'silver', '2020-12-09 12:47:58'),
('8031f18f2412gf0792tq0f022', 'silver', '2020-12-09 13:28:02'),
('812y1b0c9j32224f97b01122s', 'regular', '2020-12-11 22:19:23'),
('81n00516a381122powtw00014', 'regular', '2020-11-16 10:38:05'),
('850210vn5i01894c02m8m1j25', 'regular', '2020-12-09 10:58:15'),
('8z10i213230110q520hft134m', 'regular', '2020-11-13 14:08:03'),
('8z441320demj9320011641962', 'silver', '2020-09-14 12:46:18'),
('9283q00b42f10224e1e14520o', 'regular', '2020-09-21 20:24:34'),
('95p22611ccupsa0207511022n', 'regular', '2020-11-20 17:25:25'),
('by2a810211482640i45010234', 'gold', '2020-10-13 14:40:42'),
('cq71515me0250v621210920qg', 'regular', '2020-10-21 09:56:25'),
('di9220591ht9210ji3s1805s0', 'silver', '2020-09-30 12:55:19'),
('e0l140t21bx101120mc216201', 'regular', '2020-11-21 14:21:10'),
('e1270q4h9xs90t1203zzsw122', 'silver', '2020-12-09 13:19:27'),
('gt0b11wo24p2134212n01223e', 'gold', '2020-12-11 23:43:12'),
('h0r21wf0k6v4110442162112h', 'gold', '2020-11-21 14:20:44'),
('hsr30112c1q481957r31z0210', 'gold', '2020-10-13 14:38:51'),
('i7g413031pq041h220ui30i01', 'silver', '2020-10-13 14:40:37'),
('k23h21r10j70793907150552g', 'gold', '2020-09-15 21:59:03'),
('kj140a2122c292v33v0g30901', 'gold', '2020-09-14 12:23:33'),
('l02g32041y506c0111yt14t43', 'gold', '2020-10-13 13:46:40'),
('l1791ozl00700uca0222y0943', 'regular', '2020-09-17 09:04:23'),
('mf1550920290g92f0261m60i2', 'gold', '2020-09-25 19:06:05'),
('n12633b1061225b801it010y2', 'silver', '2020-10-13 12:12:06'),
('o712v22m60zg0aw1z03144u21', 'silver', '2020-12-10 13:14:27'),
('p02x91e2141am3202j412ar32', 'silver', '2020-12-11 22:32:13'),
('p971041s0m130742t104sw212', 'gold', '2020-09-14 21:03:14'),
('s09812a0024qts134318k3gy1', 'regular', '2020-10-13 14:38:39'),
('t92021i0n0t4024592461nwo0', 'regular', '2020-12-09 05:09:14'),
('tc4h4aqo1120d160500z22915', 'gold', '2020-09-14 12:46:10'),
('v04102j401krzp90015292223', 'gold', '2020-09-23 14:21:05'),
('vg2nu9x12160091342714u204', 'silver', '2020-09-16 22:14:49'),
('vl08q977s031k1g2002ejy275', 'regular', '2020-09-27 18:37:57'),
('w0322580e2g2ks141u21d2h01', 'gold', '2020-11-22 13:28:24'),
('w04p04022420q12m1omw31a0n', 'silver', '2020-12-10 14:02:43'),
('x3a25kt5120790270vt12hj11', 'silver', '2020-11-05 17:25:27'),
('x41j20002158p2t901tl088e0', 'silver', '2020-10-20 18:59:08'),
('y0g00v9212r49ip12v3132k56', 'silver', '2020-09-14 12:25:39'),
('yl01kv9hc5eu042222l2l3520', 'silver', '2020-12-09 22:35:25'),
('z014a4h1213d6ad2912002012', 'gold', '2020-10-21 21:44:06');

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
  `shipPrice` double NOT NULL,
  `minTime` int(11) NOT NULL,
  `maxTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BoxShipping`
--

INSERT INTO `BoxShipping` (`box_color`, `country_`, `iso_currency`, `shipPrice`, `minTime`, `maxTime`) VALUES
('gold', 'australia', 'aud', 8.13, 7, 10),
('gold', 'belgium', 'aud', 8.38, 2, 5),
('gold', 'canada', 'aud', 6.17, 6, 9),
('gold', 'switzerland', 'aud', 6.85, 3, 6),
('gold', 'australia', 'cad', 8.58, 7, 10),
('gold', 'belgium', 'cad', 7.77, 2, 5),
('gold', 'canada', 'cad', 9.49, 6, 9),
('gold', 'switzerland', 'cad', 6.36, 3, 6),
('gold', 'australia', 'chf', 5.74, 7, 10),
('gold', 'belgium', 'chf', 5.95, 2, 5),
('gold', 'canada', 'chf', 7.37, 6, 9),
('gold', 'switzerland', 'chf', 4.44, 3, 6),
('gold', 'australia', 'eur', 5.16, 7, 10),
('gold', 'belgium', 'eur', 5.11, 2, 5),
('gold', 'canada', 'eur', 5, 6, 9),
('gold', 'switzerland', 'eur', 6.6, 3, 6),
('gold', 'australia', 'gbp', 7.18, 7, 10),
('gold', 'belgium', 'gbp', 5.27, 2, 5),
('gold', 'canada', 'gbp', 4.73, 6, 9),
('gold', 'switzerland', 'gbp', 6.38, 3, 6),
('gold', 'australia', 'jpy', 7.25, 7, 10),
('gold', 'belgium', 'jpy', 8.58, 2, 5),
('gold', 'canada', 'jpy', 4.02, 6, 9),
('gold', 'switzerland', 'jpy', 5.46, 3, 6),
('gold', 'australia', 'usd', 8.77, 7, 10),
('gold', 'belgium', 'usd', 5.16, 2, 5),
('gold', 'canada', 'usd', 9.07, 6, 9),
('gold', 'switzerland', 'usd', 8.03, 3, 6),
('regular', 'australia', 'aud', 4.42, 7, 10),
('regular', 'belgium', 'aud', 9.75, 2, 5),
('regular', 'canada', 'aud', 4.19, 6, 9),
('regular', 'switzerland', 'aud', 4.66, 3, 6),
('regular', 'australia', 'cad', 9.27, 7, 10),
('regular', 'belgium', 'cad', 9.37, 2, 5),
('regular', 'canada', 'cad', 7.57, 6, 9),
('regular', 'switzerland', 'cad', 8.29, 3, 6),
('regular', 'australia', 'chf', 5.89, 7, 10),
('regular', 'belgium', 'chf', 9.94, 2, 5),
('regular', 'canada', 'chf', 9.37, 6, 9),
('regular', 'switzerland', 'chf', 8.26, 3, 6),
('regular', 'australia', 'eur', 7.36, 7, 10),
('regular', 'belgium', 'eur', 6.24, 2, 5),
('regular', 'canada', 'eur', 7.41, 6, 9),
('regular', 'switzerland', 'eur', 6.62, 3, 6),
('regular', 'australia', 'gbp', 8.04, 7, 10),
('regular', 'belgium', 'gbp', 5.03, 2, 5),
('regular', 'canada', 'gbp', 8.5, 6, 9),
('regular', 'switzerland', 'gbp', 9.5, 3, 6),
('regular', 'australia', 'jpy', 4.75, 7, 10),
('regular', 'belgium', 'jpy', 9.92, 2, 5),
('regular', 'canada', 'jpy', 7.42, 6, 9),
('regular', 'switzerland', 'jpy', 4.15, 3, 6),
('regular', 'australia', 'usd', 8.25, 7, 10),
('regular', 'belgium', 'usd', 5.74, 2, 5),
('regular', 'canada', 'usd', 8.69, 6, 9),
('regular', 'switzerland', 'usd', 4.19, 3, 6),
('silver', 'australia', 'aud', 4.79, 7, 10),
('silver', 'belgium', 'aud', 4.12, 2, 5),
('silver', 'canada', 'aud', 4.91, 6, 9),
('silver', 'switzerland', 'aud', 4.66, 3, 6),
('silver', 'australia', 'cad', 9.5, 7, 10),
('silver', 'belgium', 'cad', 7.15, 2, 5),
('silver', 'canada', 'cad', 5.46, 6, 9),
('silver', 'switzerland', 'cad', 7.08, 3, 6),
('silver', 'australia', 'chf', 8.15, 7, 10),
('silver', 'belgium', 'chf', 5.95, 2, 5),
('silver', 'canada', 'chf', 5.44, 6, 9),
('silver', 'switzerland', 'chf', 5.95, 3, 6),
('silver', 'australia', 'eur', 4.07, 7, 10),
('silver', 'belgium', 'eur', 9.97, 2, 5),
('silver', 'canada', 'eur', 7.96, 6, 9),
('silver', 'switzerland', 'eur', 9.77, 3, 6),
('silver', 'australia', 'gbp', 7.2, 7, 10),
('silver', 'belgium', 'gbp', 5.14, 2, 5),
('silver', 'canada', 'gbp', 4.36, 6, 9),
('silver', 'switzerland', 'gbp', 5.95, 3, 6),
('silver', 'australia', 'jpy', 4.02, 7, 10),
('silver', 'belgium', 'jpy', 9.19, 2, 5),
('silver', 'canada', 'jpy', 7.33, 6, 9),
('silver', 'switzerland', 'jpy', 6.03, 3, 6),
('silver', 'australia', 'usd', 7.68, 7, 10),
('silver', 'belgium', 'usd', 4.01, 2, 5),
('silver', 'canada', 'usd', 6.28, 6, 9),
('silver', 'switzerland', 'usd', 5.41, 3, 6);

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
('asos', 'inseam', 'l', 'centimeter', 'min', 49.38),
('asos', 'inseam', 'l', 'eu', 'min', 41),
('asos', 'inseam', 'l', 'uk', 'min', 9),
('asos', 'inseam', 'l', 'us', 'min', 6),
('asos', 'inseam', 'l', 'centimeter', 'max', 51.49),
('asos', 'inseam', 'l', 'eu', 'max', 42),
('asos', 'inseam', 'l', 'uk', 'max', 10),
('asos', 'inseam', 'l', 'us', 'max', 7),
('asos', 'inseam', 'm', 'centimeter', 'min', 47.38),
('asos', 'inseam', 'm', 'eu', 'min', 39),
('asos', 'inseam', 'm', 'uk', 'min', 7),
('asos', 'inseam', 'm', 'us', 'min', 4),
('asos', 'inseam', 'm', 'centimeter', 'max', 49.49),
('asos', 'inseam', 'm', 'eu', 'max', 40),
('asos', 'inseam', 'm', 'uk', 'max', 8),
('asos', 'inseam', 'm', 'us', 'max', 5),
('asos', 'inseam', 's', 'centimeter', 'min', 45.38),
('asos', 'inseam', 's', 'eu', 'min', 37),
('asos', 'inseam', 's', 'uk', 'min', 5),
('asos', 'inseam', 's', 'us', 'min', 2),
('asos', 'inseam', 's', 'centimeter', 'max', 47.49),
('asos', 'inseam', 's', 'eu', 'max', 38),
('asos', 'inseam', 's', 'uk', 'max', 6),
('asos', 'inseam', 's', 'us', 'max', 3),
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
('lacoste', 'inseam', 'l', 'centimeter', 'min', 66.05),
('lacoste', 'inseam', 'l', 'eu', 'min', 38),
('lacoste', 'inseam', 'l', 'uk', 'min', 8),
('lacoste', 'inseam', 'l', 'us', 'min', 9),
('lacoste', 'inseam', 'l', 'centimeter', 'max', 68.71),
('lacoste', 'inseam', 'l', 'eu', 'max', 39),
('lacoste', 'inseam', 'l', 'uk', 'max', 9),
('lacoste', 'inseam', 'l', 'us', 'max', 10),
('lacoste', 'inseam', 'm', 'centimeter', 'min', 64.05),
('lacoste', 'inseam', 'm', 'eu', 'min', 36),
('lacoste', 'inseam', 'm', 'uk', 'min', 6),
('lacoste', 'inseam', 'm', 'us', 'min', 7),
('lacoste', 'inseam', 'm', 'centimeter', 'max', 66.71),
('lacoste', 'inseam', 'm', 'eu', 'max', 37),
('lacoste', 'inseam', 'm', 'uk', 'max', 7),
('lacoste', 'inseam', 'm', 'us', 'max', 8),
('lacoste', 'inseam', 's', 'centimeter', 'min', 62.05),
('lacoste', 'inseam', 's', 'eu', 'min', 34),
('lacoste', 'inseam', 's', 'uk', 'min', 4),
('lacoste', 'inseam', 's', 'us', 'min', 5),
('lacoste', 'inseam', 's', 'centimeter', 'max', 64.71),
('lacoste', 'inseam', 's', 'eu', 'max', 35),
('lacoste', 'inseam', 's', 'uk', 'max', 5),
('lacoste', 'inseam', 's', 'us', 'max', 6),
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
('the north face', 'inseam', 'l', 'centimeter', 'min', 50.41),
('the north face', 'inseam', 'l', 'eu', 'min', 45),
('the north face', 'inseam', 'l', 'uk', 'min', 8),
('the north face', 'inseam', 'l', 'us', 'min', 9),
('the north face', 'inseam', 'l', 'centimeter', 'max', 52.1),
('the north face', 'inseam', 'l', 'eu', 'max', 46),
('the north face', 'inseam', 'l', 'uk', 'max', 9),
('the north face', 'inseam', 'l', 'us', 'max', 10),
('the north face', 'inseam', 'm', 'centimeter', 'min', 48.41),
('the north face', 'inseam', 'm', 'eu', 'min', 43),
('the north face', 'inseam', 'm', 'uk', 'min', 6),
('the north face', 'inseam', 'm', 'us', 'min', 7),
('the north face', 'inseam', 'm', 'centimeter', 'max', 50.1),
('the north face', 'inseam', 'm', 'eu', 'max', 44),
('the north face', 'inseam', 'm', 'uk', 'max', 7),
('the north face', 'inseam', 'm', 'us', 'max', 8),
('the north face', 'inseam', 's', 'centimeter', 'min', 46.41),
('the north face', 'inseam', 's', 'eu', 'min', 41),
('the north face', 'inseam', 's', 'uk', 'min', 4),
('the north face', 'inseam', 's', 'us', 'min', 5),
('the north face', 'inseam', 's', 'centimeter', 'max', 48.1),
('the north face', 'inseam', 's', 'eu', 'max', 42),
('the north face', 'inseam', 's', 'uk', 'max', 5),
('the north face', 'inseam', 's', 'us', 'max', 6),
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
('tommy hilfiger', 'inseam', 'l', 'centimeter', 'min', 97.79),
('tommy hilfiger', 'inseam', 'l', 'eu', 'min', 43),
('tommy hilfiger', 'inseam', 'l', 'uk', 'min', 8),
('tommy hilfiger', 'inseam', 'l', 'us', 'min', 9),
('tommy hilfiger', 'inseam', 'l', 'centimeter', 'max', 98.54),
('tommy hilfiger', 'inseam', 'l', 'eu', 'max', 44),
('tommy hilfiger', 'inseam', 'l', 'uk', 'max', 9),
('tommy hilfiger', 'inseam', 'l', 'us', 'max', 10),
('tommy hilfiger', 'inseam', 'm', 'centimeter', 'min', 95.79),
('tommy hilfiger', 'inseam', 'm', 'eu', 'min', 41),
('tommy hilfiger', 'inseam', 'm', 'uk', 'min', 6),
('tommy hilfiger', 'inseam', 'm', 'us', 'min', 7),
('tommy hilfiger', 'inseam', 'm', 'centimeter', 'max', 96.54),
('tommy hilfiger', 'inseam', 'm', 'eu', 'max', 42),
('tommy hilfiger', 'inseam', 'm', 'uk', 'max', 7),
('tommy hilfiger', 'inseam', 'm', 'us', 'max', 8),
('tommy hilfiger', 'inseam', 's', 'centimeter', 'min', 93.79),
('tommy hilfiger', 'inseam', 's', 'eu', 'min', 39),
('tommy hilfiger', 'inseam', 's', 'uk', 'min', 4),
('tommy hilfiger', 'inseam', 's', 'us', 'min', 5),
('tommy hilfiger', 'inseam', 's', 'centimeter', 'max', 94.54),
('tommy hilfiger', 'inseam', 's', 'eu', 'max', 40),
('tommy hilfiger', 'inseam', 's', 'uk', 'max', 5),
('tommy hilfiger', 'inseam', 's', 'us', 'max', 6),
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
('tommy hilfiger', 'waist', 's', 'us', 'max', 7);

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
('DEFAULT_LANGUAGE', 'en', NULL, '2020-02-28 00:00:00', 'Default language given to the visitor if his driver language is not supported by the web site.'),
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
('ADM', 10800, NULL, NULL, 0, 1),
('ADRS', 86400, NULL, NULL, 0, 1),
('CHKT_LNCHD', 86400, NULL, 'checkout', 0, 0),
('CLT', 31536000, NULL, NULL, 0, 1),
('LCK', 120, NULL, NULL, 0, 1),
('VIS', 94608000, NULL, NULL, 0, 1);

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
('france', 'fr', 'eur', 1, 0.2),
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
('fit', 10, 'centimeter'),
('wide', 20, 'centimeter');

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
('blackfriday25', 'on_sum_prods', 0.1, NULL, 30, 1, 1),
('free_shipping_au', 'on_shipping', 1, NULL, 30, NULL, 1),
('free_shipping_be', 'on_shipping', 0.1, NULL, 80.1, 0, 1),
('free_shipping_ca', 'on_shipping', 0.2, NULL, 30, 0, 1),
('winter30', 'on_sum_prods', 0.3, NULL, 0, NULL, 0);

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
('blackfriday25', 'australia', '2020-02-02 18:02:20', NULL),
('blackfriday25', 'belgium', '2020-12-06 00:00:00', NULL),
('blackfriday25', 'canada', NULL, NULL),
('blackfriday25', 'switzerland', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('free_shipping_au', 'australia', '2020-02-02 18:02:20', NULL),
('free_shipping_be', 'belgium', NULL, NULL),
('free_shipping_ca', 'canada', NULL, NULL),
('winter30', 'australia', '2020-02-02 18:02:20', '2020-03-04 18:02:20'),
('winter30', 'belgium', '2020-12-06 18:02:20', '2020-12-31 18:02:20'),
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

--
-- Déchargement des données de la table `Orders`
--

INSERT INTO `Orders` (`orderID`, `userId`, `stripeCheckoutId`, `iso_currency`, `vatRate`, `vat`, `hvat`, `sellPrice`, `discount`, `subtotal`, `shipping`, `shipDiscount`, `total`, `setDate`) VALUES
('ord_o12fl0m0v2010042923010358', 3330090, 'cs_test_b13EzZ0rBOK9KiNaaeV8lvnXi5LRLTpWEWcT8UAoDMCEzZmjyDYHQa3adV', 'aud', 0.21, 6.11273, 61.1273, 67.24, 0, 67.24, 4.79, 4.79, 67.24, '2020-12-10 14:03:50'),
('test', 3330090, 'cs_test_3ypf1Mc20EZHhEEvUy0gv3uYfB7wR5gDnILNr8bgTF0egkVewLp7uDvH', 'aud', 0.1, 10, 11, 12, 13, 14, 15, 16, 17, '2020-12-07 00:00:00');

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

--
-- Déchargement des données de la table `Orders-Addresses`
--

INSERT INTO `Orders-Addresses` (`orderId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `setDate`) VALUES
('ord_o12fl0m0v2010042923010358', 'place royale 4', '1640', 'belgium', 'villa', 'miami', 'rodeo drive', '472174210', '2020-12-01 23:18:03');

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

--
-- Déchargement des données de la table `Orders-Boxes`
--

INSERT INTO `Orders-Boxes` (`orderId`, `boxId`, `box_color`, `sizeMax`, `weight`, `boxPicture`, `sellPrice`, `shipping`, `discount_value`, `setDate`) VALUES
('ord_o12fl0m0v2010042923010358', 'w04p04022420q12m1omw31a0n', 'silver', 6, 0.075, 'box-silver-128.png', 67.24, 4.79, NULL, '2020-12-10 14:02:43');

-- --------------------------------------------------------

--
-- Structure de la table `Orders-BoxProducts`
--

CREATE TABLE `Orders-BoxProducts` (
  `boxId` varchar(100) NOT NULL,
  `prodId` int(11) NOT NULL,
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

--
-- Déchargement des données de la table `Orders-BoxProducts`
--

INSERT INTO `Orders-BoxProducts` (`boxId`, `prodId`, `sequenceID`, `product_type`, `realSize`, `weight`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`, `stillStock`) VALUES
('w04p04022420q12m1omw31a0n', 1, 'xxs-null-null-null', 'boxproduct', 's', 0.54, 'xxs', NULL, NULL, NULL, 1, '2020-12-10 14:02:49', 1);

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

--
-- Déchargement des données de la table `Orders-DiscountCodes`
--

INSERT INTO `Orders-DiscountCodes` (`orderId`, `discount_code`, `discount_type`, `rate`, `maxAmount`, `minAmount`, `nbUse`, `beginDate`, `endDate`, `isCombinable`) VALUES
('ord_o12fl0m0v2010042923010358', 'free_shipping_au', 'on_shipping', 1, NULL, 30, NULL, '2020-02-02 18:02:20', NULL, 1);

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

--
-- Déchargement des données de la table `OrdersStatus`
--

INSERT INTO `OrdersStatus` (`orderId`, `status`, `trackingNumber`, `adminId`, `deliveryMin`, `deliveryMax`, `setDate`) VALUES
('ord_o12fl0m0v2010042923010358', 'US68', NULL, 1, '2020-12-17', '2020-12-20', '2020-12-10 14:03:50');

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
  `groupID` varchar(50) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `addedDate` datetime NOT NULL,
  `colorName` enum('red','gold','purple','pink','blue','green','white','black','beige','grey','brown','yellow','orange') NOT NULL,
  `colorRGB` varchar(50) NOT NULL,
  `weight` double NOT NULL,
  `googleCat` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Products`
--

INSERT INTO `Products` (`prodID`, `prodName`, `isAvailable`, `groupID`, `product_type`, `addedDate`, `colorName`, `colorRGB`, `weight`, `googleCat`) VALUES
(1, 'boxproduct1', 1, 'boxproduct2', 'boxproduct', '2020-01-08 15:00:05', 'green', '#33cc33', 0.54, 'Apparel & Accessories > Clothing > Sleepwear & Loungewear > Nightgowns'),
(2, 'boxproduct2', 1, 'boxproduct2', 'boxproduct', '2020-01-09 15:00:05', 'blue', '#00ccff', 0.98, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Swimwear'),
(3, 'boxproduct3', 1, 'boxproduct2', 'boxproduct', '2020-01-10 15:00:05', 'yellow', '#ffff00', 0.71, 'Apparel & Accessories > Clothing > Shirts & Tops'),
(4, 'boxproduct4', 1, 'boxproduct2', 'boxproduct', '2020-01-11 15:00:05', 'red', '#ff3300', 0.71, 'Apparel & Accessories > Clothing > Shirts & Tops'),
(5, 'boxproduct5', 1, 'boxproduct2', 'boxproduct', '2020-01-12 15:00:05', 'orange', '#ff9900', 0.34, 'Apparel & Accessories > Clothing > Shirts & Tops'),
(6, 'basketproduct6', 1, 'basketproduct4', 'basketproduct', '2020-01-13 15:00:05', 'black', '#000000', 0.32, 'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers'),
(7, 'basketproduct7', 1, 'basketproduct4', 'basketproduct', '2020-01-14 15:00:05', 'green', '#33cc33', 0.65, 'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers'),
(8, 'basketproduct8', 1, 'basketproduct4', 'basketproduct', '2020-01-15 15:00:05', 'white', '#ffffff', 0.48, 'Apparel & Accessories > Clothing > One-Pieces > Jumpsuits & Rompers'),
(9, 'basketproduct9', 1, 'basketproduct5', 'basketproduct', '2020-01-16 15:00:05', 'yellow', '#ffff00', 0.73, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(10, 'basketproduct10', 1, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'red', '#ff3300', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(11, 'basketproduct11', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'blue', '#00ccff', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(12, 'basketproduct12', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'yellow', '#ffff00', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(13, 'basketproduct13', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'green', '#33cc33', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(14, 'basketproduct14', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'orange', '#ff9900', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(15, 'basketproduct15', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'black', '#000000', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(16, 'basketproduct16', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'white', '#ffffff', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(17, 'basketproduct17', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'red', '#00ccff', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses'),
(18, 'basketproduct18', 0, 'basketproduct5', 'basketproduct', '2020-01-17 15:00:05', 'yellow', '#ffff00', 0.76, 'Apparel & Accessories > Clothing > Baby & Toddler Clothing > Baby & Toddler Dresses');

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
(1, '4xl', 5),
(1, 'm', 5),
(1, 's', 4),
(2, 'l', 5),
(2, 'm', 5),
(2, 's', 5),
(3, 'l', 9),
(3, 'm', 1),
(3, 's', 1),
(4, 'l', 0),
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
  `description` varchar(5000) NOT NULL,
  `richDescription` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ProductsDescriptions`
--

INSERT INTO `ProductsDescriptions` (`prodId`, `lang_`, `description`, `richDescription`) VALUES
(1, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(1, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(1, 'fr', 'cette description est en français', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(2, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(2, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(2, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(3, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(3, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(3, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(4, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(4, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(4, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(5, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(5, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(5, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(6, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(6, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(6, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(7, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(7, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(7, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(8, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(8, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(8, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(9, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(9, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(9, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français'),
(10, 'en', 'this description is in english', '<h1>my product</h1>hi! this description is in english <strong>this description is in english</strong>. this description is in english, this description is in english. this description is in english, this description is in english. this description is in english, this description is in english this description is in english <strong>this description is in english</strong> this description is in english'),
(10, 'es', 'esta descripción está en español', '<h1>mi producto</h1>¡hola! esta descripción está en español <strong> esta descripción está en español </strong>. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español. esta descripción está en español, esta descripción está en español esta descripción está en español <strong> esta descripción está en español </strong> esta descripción está en español'),
(10, 'fr', 'cette description est en français ', '<h1>mon produit</h1>salut! cette description est en français<strong>cette description est en français</strong>. cette description est en français, cette description est en français. cette description est en français, cette description est en français. cette description est en français, cette description est en français cette description est en français<strong>cette description est en français</strong>cette description est en français');

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
('33'),
('34'),
('35'),
('36'),
('37'),
('38'),
('39'),
('3xl'),
('40'),
('41'),
('42'),
('43'),
('44'),
('45'),
('46'),
('47'),
('48'),
('49'),
('4xl'),
('50'),
('51'),
('52'),
('53'),
('54'),
('55'),
('56'),
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
('3xl', 'arm', 'centimeter', 88.39),
('3xl', 'bust', 'centimeter', 89.34),
('3xl', 'hip', 'centimeter', 89.91),
('3xl', 'inseam', 'centimeter', 87.78),
('3xl', 'waist', 'centimeter', 82.34),
('4xl', 'arm', 'centimeter', 95.4),
('4xl', 'bust', 'centimeter', 98.41),
('4xl', 'hip', 'centimeter', 97.9),
('4xl', 'inseam', 'centimeter', 100.14),
('4xl', 'waist', 'centimeter', 100.56),
('l', 'arm', 'centimeter', 54.35),
('l', 'bust', 'centimeter', 57.25),
('l', 'hip', 'centimeter', 57.11),
('l', 'inseam', 'centimeter', 57.24),
('l', 'waist', 'centimeter', 58.65),
('m', 'arm', 'centimeter', 48.62),
('m', 'bust', 'centimeter', 41.62),
('m', 'hip', 'centimeter', 47.15),
('m', 'inseam', 'centimeter', 50.02),
('m', 'waist', 'centimeter', 47.71),
('s', 'arm', 'centimeter', 34.53),
('s', 'bust', 'centimeter', 37.31),
('s', 'hip', 'centimeter', 36.58),
('s', 'inseam', 'centimeter', 36.15),
('s', 'waist', 'centimeter', 39.48),
('xl', 'arm', 'centimeter', 65.06),
('xl', 'bust', 'centimeter', 61.06),
('xl', 'hip', 'centimeter', 63.47),
('xl', 'inseam', 'centimeter', 65.75),
('xl', 'waist', 'centimeter', 62.46),
('xs', 'arm', 'centimeter', 26.58),
('xs', 'bust', 'centimeter', 22.99),
('xs', 'hip', 'centimeter', 29.14),
('xs', 'inseam', 'centimeter', 26.04),
('xs', 'waist', 'centimeter', 27.99),
('xxl', 'arm', 'centimeter', 74.26),
('xxl', 'bust', 'centimeter', 76.9),
('xxl', 'hip', 'centimeter', 71.88),
('xxl', 'inseam', 'centimeter', 71.09),
('xxl', 'waist', 'centimeter', 75.04),
('xxs', 'arm', 'centimeter', 10.44),
('xxs', 'bust', 'centimeter', 13.58),
('xxs', 'hip', 'centimeter', 16.82),
('xxs', 'inseam', 'centimeter', 20.25),
('xxs', 'waist', 'centimeter', 14.59);

-- --------------------------------------------------------

--
-- Structure de la table `StockLocks`
--

CREATE TABLE `StockLocks` (
  `userId` varchar(50) NOT NULL,
  `prodId` int(11) NOT NULL,
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

--
-- Déchargement des données de la table `StripeCheckoutSessions`
--

INSERT INTO `StripeCheckoutSessions` (`sessionID`, `payId`, `userId`, `iso_currency`, `custoID`, `payStatus`, `setDate`) VALUES
('cs_test_0reyhQRw4ymeuTwxKugUkSI2Dvcow8KWUy6vxC7Dz8uQNAcGF3I9PkAT', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-09 17:42:52'),
('cs_test_3ypf1Mc20EZHhEEvUy0gv3uYfB7wR5gDnILNr8bgTF0egkVewLp7uDvH', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-07 18:08:46'),
('cs_test_8ZUN7qF2LqfEEERjeyT1KCLitZHfD9oZvqCbkvGBRG5Oe4B1KMiUeKFY', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-07 18:30:50'),
('cs_test_AsJVwCHMgwm654UNKSdKLfxFkZ8OigNBgOnaDCVwspxr7PyaWbnEiDcY', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-13 15:07:24'),
('cs_test_b10mjVT0tzncSs2DS5fy64Fc2ZB75LW0Nd5ANkddjfLlUQsN2QjJSk0GEK', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'paid', '2020-12-09 05:15:00'),
('cs_test_b123QoMhlQq6FSjsOaIlDUgOKJ5xfzqqZA5f4PVpBFmbpe9tEycxLLfAEg', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 16:52:06'),
('cs_test_b12zNbtuVvgoIaAy3dET8PjlAuu3maUkgLfk0tqei5HQAVvidTpmqBIzTP', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 21:58:30'),
('cs_test_b13EzZ0rBOK9KiNaaeV8lvnXi5LRLTpWEWcT8UAoDMCEzZmjyDYHQa3adV', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'paid', '2020-12-09 16:25:03'),
('cs_test_b13kJtNXYJqWFDD3EvnklMJ08jCFFeW2xx2t7p5CTjk5PxEYBUNcisoh3E', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 14:08:07'),
('cs_test_b16NqXtkZhf0YcoyIjGtMs6zQ8h0HOGhSFmLotlitU1oT8mtk3uRA1AnEO', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 12:47:50'),
('cs_test_b19kyVrb3111xAlKcz3GdNgnkIxRhdGdaDTSc06q8NDFB3pBVpNw8adF1D', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 01:07:09'),
('cs_test_b1AkYiQRguk3xyqvHeFprtbfxJkATUPRGH1U7bqkZ1srDwgPq9VC87RqKN', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 14:59:25'),
('cs_test_b1BWQ2r1T8oOkKPpOgFCfbkdE3TSwXhduFEjS1m0SalFm9xUBfA0x7D6Cw', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 17:01:17'),
('cs_test_b1BxtskerV9XBw0nz3vLMjfDxpopnHbnQWpi20p2stz8xWcQtyIApEvpQW', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 16:49:46'),
('cs_test_b1cKbrOyKvb9hZhbac1T4ATBvjMxx4tSCpUKS2qoNfCpHq2zSXFE3pb5da', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 21:06:03'),
('cs_test_b1CwkPFy6fO5wc4bnoHmAvbYBfkvykJUMrNnPam2En50nUc1BMJvTl0Flf', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'paid', '2020-12-08 17:20:12'),
('cs_test_b1DHgLgx52Lw0k2QlBK16mwUe8P9ktLNp6Td0ctMDh66jMDgJRzklxUx4w', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'paid', '2020-12-09 01:18:27'),
('cs_test_b1eSga0T4ex4rM93F7gHexb7JTAh2t2lJtn8rGa58COeBKrIxm4h2d00uj', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-22 14:01:47'),
('cs_test_b1f7jfvEmptlbdmuDsDROgSJ5pRU4McaOJMVNqSH519g00a3OYWY7PDaom', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 01:11:58'),
('cs_test_b1FE6gpAebuZX3RExkUUV7BDBgGf7jVRKkEr22gdT4cfVZLnLbOUqq6Bzs', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'unpaid', '2020-12-09 12:42:46'),
('cs_test_b1Gj3Z79jP4h7F5uV98By15m3hza645nROwmiuoC2LEEFXxbhsA7jnCgxl', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 16:59:28'),
('cs_test_b1l4Aaj7g8SbU6usi3kOAYrW2q6HbXPWq3PbSpmidhuyphDE6Cqc6m5rZ5', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'unpaid', '2020-12-09 16:12:31'),
('cs_test_b1lrnTASPCQsRsVOnKtRdHmlQUg76ydKBwESxi7MzVLPoFIFkzD9orNaf5', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 14:14:38'),
('cs_test_b1MXnENfjtduz5ZbqfowfainkP3WqR4qJQZUDC2rrnk0jkeWCwG6UnnYBI', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-22 14:03:30'),
('cs_test_b1N9b8DwQJlzCRnJFrtTjXPdorOZEP5tMYfh4pBjiZPvJvYeWBHJ5pBSAj', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-12-01 16:21:24'),
('cs_test_b1ogqoNJUiaIvH8H93Q8CqhH41yWMWtpMM1FGnJqXTsTRLXuAqh36JrDjE', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'unpaid', '2020-12-09 16:10:50'),
('cs_test_b1pJ1AcUrlK8ruLpTAHwGK388oauopFCw5kXtr0dHXAkuTtUncoT37HNFz', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-20 06:21:36'),
('cs_test_b1qBOqEwArQNlIoF25ZKdO4BP2G8n4DW0D8rxP9hvaf3DVQhsHwp1BZYZc', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 21:52:41'),
('cs_test_b1rXVMsdB36NekEtadlRTnpUsIwUunNBiQWNAXUPUHBSw7wGQWJYyW9mxb', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 12:53:04'),
('cs_test_b1SCkzZti9B0yIzRIH4hnnbFbKYuE4bQTiz1uAiqKHHPqFDjz0Cl3BwU7S', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 01:09:59'),
('cs_test_b1TynGL9CXt61A6RRWwQ4ZvRCj8UAdQjsIB4RhMKjs4NH54IWBd62LfYk0', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 00:59:08'),
('cs_test_b1uehoxCHj0sXJeQWWe1EfFW2OmZsxYqByEg1xj1vzrLTzNAcBNOMwBDBk', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 14:07:13'),
('cs_test_b1VAr0IY5nnk4YFg3BhQp1hIP1FYkLid2yzL6fR1nXUR3CQY7YUYBVZ6NL', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'unpaid', '2020-12-11 22:20:10'),
('cs_test_b1VcCNmMOvUbK9V6gpWEjwDyPHFlqX5fqQGKIW9mI949ZkZ641Rzybm0g2', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 00:58:25'),
('cs_test_b1vu7FixkQDKd9EoFe0siBTk5s04XdastIqSvTxxOtHKmbGZ3H7j2s6TuZ', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'unpaid', '2020-12-11 22:21:27'),
('cs_test_b1wJ3RTDlADeRi6TnceMzSxLtGGxOMOCzZclbFTSvUsSIIDkuJHarojSZc', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 21:06:48'),
('cs_test_b1xhLffQCLrF1ZYPH4hLEEzM5jFEmWzlu0mEqDZzmrxp2JiyPMla8G7vPh', 'card', 3330090, 'aud', 'cus_IXOXs6fpHcKihS', 'paid', '2020-12-09 04:52:07'),
('cs_test_b1xKfLLCEBDnfvKnS6jD9s08bcAz2UUppzsKwqecw4tcx44c1wmx3ifNMA', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 01:10:30'),
('cs_test_b1XrQSCJOdYqnZsZVjgWfDl2JhTQA8JKZ1mRAmfPiKYycI8PMp0qdrVOZH', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 13:07:05'),
('cs_test_b1xt5mTAdQ4w6iwJ0xnawgb9dg8NrjLxAr8T6srpmzmQRsuU0ULMcNEzLY', 'card', 3330090, 'cad', 'cus_IXDTQfp2k15nTM', 'unpaid', '2020-12-09 01:11:14'),
('cs_test_b1ZoxyqF9XFnjB5gcxVycPZvvMU1TeUx4t3ezc7XD74NljrNs53tzesqGX', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-11-21 14:28:26'),
('cs_test_HJO6FfxCPhtCOXUbcL5G6PAAkR2Nshdgn1ZfRaQ8OhD2oHjrjNwZ0cCs', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-20 17:52:29'),
('cs_test_TA5VDfNHhOQZ79WpG9zCt6wAxGx8JiTncXito3SV5WpsPzCzP0VYKoXT', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-11 22:18:35'),
('cs_test_TR7rz4vKjIePNhjDdIAGRa95QasRIQJ6cF3InnlY1YMRu3W3BUcz3C2d', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-20 18:10:00'),
('cs_test_ZpDGLbqFNAQqyJtMWIPHvMDCYFaN9IhZiaqhw1CuLsPqF1WsoORAEygy', 'card', 3330090, 'eur', 'cus_I9zCrpUKKrvSbx', 'paid', '2020-10-09 19:19:42');

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
(18, 'december', 'fr', 'décembre');

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
  `userId` varchar(50) NOT NULL,
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
(1, NULL, 'belgium', 'eur', 'system@mail.domain', 'no password', 'system', 'system', '2019-09-01', NULL, 'other', '2020-10-09 18:42:45'),
(3330090, 'fr', 'belgium', 'eur', 'israelmeiresonne97@gmail.com', '$2y$10$SrV5kdvByXghgTuQgja7RelQamkMKklO/c0dzF2ouX51SfuEGOaD.', 'israel', 'meiresonne', NULL, 0, 'sir', '2020-09-30 13:13:46'),
(651853948, 'fr', 'belgium', 'jpy', 'tajarose-7163@yopmail.com', 'khbmahedbazhlec', 'many', 'koshbin', '1993-02-27', 1, 'sir', '2020-01-06 15:00:05'),
(846470517, 'fr', 'belgium', 'jpy', 'opoddimmuci-6274@yopmail.com', 'aefhzrbvcqzhm', 'segolen', 'royale', '1989-02-27', 1, 'lady', '2020-01-08 15:00:05'),
(934967739, 'en', 'belgium', 'jpy', 'ehewopuri-7678@yopmail.com', 'arrfraffqrfrfqrfcqf', 'elon', 'musk', '1997-02-27', 1, 'sir', '2020-02-27 18:02:20'),
(997763060, 'es', 'belgium', 'jpy', 'annassubep-5363@yopmail.com', 'achbihzrzcrbhzcarc', 'victoria', 'secret', '1991-02-27', 0, 'lady', '2020-01-07 15:00:05');

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
(1, 'ADM', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 10800),
(1, 'CLT', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 31536000),
(1, 'VIS', '1', '8e04791aa81c.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-10 23:05:24', 94608000),
(3330090, 'ADRS', '\"place royale 4|1640|belgium\"', 'c99ae2db6bf6.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-11 22:19:59', 86400),
(3330090, 'CHKT_LNCHD', '121k32t00221052m21yrdy172', 'c99ae2db6bf6.eu.ngrok.io', '/versions/v0.2/mmbx/checkout', '2020-12-11 22:21:27', 86400),
(3330090, 'CLT', 'm9140j8q2rwds0x5332002110', 'c99ae2db6bf6.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-13 00:14:27', 31536000),
(3330090, 'VIS', '100d1sq639120hby303243a50', 'c99ae2db6bf6.eu.ngrok.io', '/versions/v0.2/mmbx/', '2020-12-13 00:14:27', 94608000),
(651853948, 'CLT', 'my client cookie', '', '', '2020-09-26 10:59:04', 94608000);

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
(1, 'system', NULL, NULL);

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
-- Déchargement des données de la table `UsersMeasures`
--

INSERT INTO `UsersMeasures` (`userId`, `measureID`, `measureName`, `userBust`, `userArm`, `userWaist`, `userHip`, `userInseam`, `unit_name`, `setDate`) VALUES
(3330090, 'decrease_m_6', 'decrease_m_6', 65.12, 65.12, 65.12, 65.12, 65.12, 'centimeter', '2020-09-30 21:05:12'),
(3330090, 'decrease_s', 'decrease_s', 10, 10, 10, 10, 10, 'inch', '2020-09-30 21:05:28');

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
-- Index pour la table `BoxBuyPrice`
--
ALTER TABLE `BoxBuyPrice`
  ADD PRIMARY KEY (`box_color`,`setDate`),
  ADD KEY `fk_iso_currency.BoxBuyPrice-FROM-Currencies` (`iso_currency`),
  ADD KEY `fk_buy_country.BoxBuyPrice-FROM-Countries` (`buy_country`);

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
-- Index pour la table `ProductBuyPrice`
--
ALTER TABLE `ProductBuyPrice`
  ADD PRIMARY KEY (`prodId`,`buyDate`),
  ADD KEY `fk_iso_currency.ProductBuyPrice-FROM-Currencies` (`iso_currency`),
  ADD KEY `fk_buy_country.ProductBuyPrice-FROM-Countries` (`buy_country`);

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
-- AUTO_INCREMENT pour la table `Products`
--
ALTER TABLE `Products`
  MODIFY `prodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `Translations`
--
ALTER TABLE `Translations`
  MODIFY `translationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Contraintes pour la table `BoxBuyPrice`
--
ALTER TABLE `BoxBuyPrice`
  ADD CONSTRAINT `fk_box_color.BoxBuyPrice-FROM-BoxColors` FOREIGN KEY (`box_color`) REFERENCES `BoxColors` (`boxColor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buy_country.BoxBuyPrice-FROM-Countries` FOREIGN KEY (`buy_country`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
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
-- Contraintes pour la table `ProductBuyPrice`
--
ALTER TABLE `ProductBuyPrice`
  ADD CONSTRAINT `fk_buy_country.ProductBuyPrice-FROM-Countries` FOREIGN KEY (`buy_country`) REFERENCES `Countries` (`country`) ON UPDATE CASCADE,
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
