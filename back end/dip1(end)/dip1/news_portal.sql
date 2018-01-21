-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_portal`
--

-- --------------------------------------------------------

--
-- Структура на таблица `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `idcategory` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idcategory`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `categories`
--

INSERT INTO `categories` (`idcategory`, `title`, `description`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(1, 'sports', 'sports', '2017-01-25 01:05:59', 'rosko', '2017-01-25 03:05:00', 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `idpost` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `iduser` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idpost`),
  KEY `FK_posts_user` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`idpost`, `iduser`, `title`, `body`, `image`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(17, 5, 'Web Design', 'dfsfdsf', 'c9c9c205e0c318cac8b718ea9fa30d20.jpg', '2017-01-25 01:07:52', 'web', NULL, 'web'),
(18, 5, 'asdasd', 'hsdjfhskjdfhk', '05e028d78c567810f85cdf33be3536cf.png', '2017-02-11 12:00:24', 'web', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE IF NOT EXISTS `post_categories` (
  `idpost_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idpost` int(10) UNSIGNED NOT NULL,
  `idcategory` int(10) UNSIGNED NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idpost_category`),
  KEY `FK_post_categories_post` (`idpost`),
  KEY `FK_post_categories_category` (`idcategory`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `post_categories`
--

INSERT INTO `post_categories` (`idpost_category`, `idpost`, `idcategory`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(15, 17, 1, '2017-01-25 01:07:52', '5', NULL, 'web'),
(16, 18, 1, '2017-02-11 12:00:24', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE IF NOT EXISTS `post_tags` (
  `idpost_tag` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idpost` int(10) UNSIGNED NOT NULL,
  `idtag` int(10) UNSIGNED NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idpost_tag`),
  KEY `FK_post_tags_post` (`idpost`),
  KEY `FK_post_tags_tag` (`idtag`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `post_tags`
--

INSERT INTO `post_tags` (`idpost_tag`, `idpost`, `idtag`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(16, 17, 11, '2017-01-25 01:07:52', '5', NULL, 'web'),
(17, 18, 12, '2017-02-11 12:00:24', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `idprofile` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `iduser` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idprofile`),
  KEY `unique_iduser` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `idtag` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web',
  PRIMARY KEY (`idtag`),
  UNIQUE KEY `unique_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `tags`
--

INSERT INTO `tags` (`idtag`, `title`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(11, 'fdsfdsf', '2017-01-25 01:07:52', '5', NULL, 'web'),
(12, 'da', '2017-02-11 12:00:24', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `iduser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) CHARACTER SET latin1 NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) CHARACTER SET latin1 DEFAULT 'web',
  PRIMARY KEY (`iduser`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`iduser`, `email`, `password`, `code`, `status`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(5, 'ivo9511@abv.bg', 'e10adc3949ba59abbe56e057f20f883e', 'e9b03ac858161b178bba4be2652ef74f', 1, '2017-01-25 01:06:59', 'web', '2017-01-25 03:07:27', 'web');

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_posts_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `FK_post_categories_category` FOREIGN KEY (`idcategory`) REFERENCES `categories` (`idcategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_categories_post` FOREIGN KEY (`idpost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `FK_post_tags_post` FOREIGN KEY (`idpost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_tags_tag` FOREIGN KEY (`idtag`) REFERENCES `tags` (`idtag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `FK_profiles_users` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
