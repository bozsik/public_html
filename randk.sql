-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2017. Dec 17. 12:36
-- Kiszolgáló verziója: 5.7.19
-- PHP verzió: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `randk`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `article_name` varchar(128) NOT NULL,
  `article_ammount` int(11) NOT NULL,
  `article_price` int(11) NOT NULL,
  `article_img` varchar(128) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `articles`
--

INSERT INTO `articles` (`article_id`, `category_id`, `article_name`, `article_ammount`, `article_price`, `article_img`) VALUES
(1, 2, 'Bodzas mez 250g', 2, 500, 'bodzas_250g_n.jpg'),
(2, 2, 'cickafarkos mez', 2, 600, 'cickafarkos_250g_n.jpg'),
(3, 2, 'Facelia 250g', 2, 750, 'facelia_900g_n.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(64) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(2, 'Mezek');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_description` text NOT NULL,
  `order_misc_files` varchar(192) NOT NULL,
  `article_id` int(11) NOT NULL,
  `article_ammount` int(11) NOT NULL,
  `order_status` int(11) NOT NULL,
  `order_time` int(11) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_description`, `order_misc_files`, `article_id`, `article_ammount`, `order_status`, `order_time`) VALUES
('b2b401132f045c36cc17727dc920a4fe', 1, '9wkjfhbkds', '', 5, 100, 0, 1454873668),
('ccd7a7ce58662c59a28120c418a309cf', 1, 'PrÃ³ba izÃ©', '1-ccd7a7ce58662c59a28120c418a309cf-1.png', 3, 2, 0, 1454664068);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `activation` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `reg_date`, `isadmin`, `activation`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', 1454518676, 1, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
