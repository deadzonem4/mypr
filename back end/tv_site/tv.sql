-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tv`
--

-- --------------------------------------------------------

--
-- Структура на таблица `tbl_model`
--

CREATE TABLE IF NOT EXISTS `tbl_model` (
  `id_model` int(10) NOT NULL AUTO_INCREMENT,
  `model` varchar(15) NOT NULL,
  PRIMARY KEY (`id_model`),
  UNIQUE KEY `make` (`model`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Схема на данните от таблица `tbl_model`
--

INSERT INTO `tbl_model` (`id_model`, `model`) VALUES
(1, 'Lenovo'),
(4, 'Neo'),
(5, 'Sharp'),
(2, 'Sony'),
(3, 'Sumsung');

-- --------------------------------------------------------

--
-- Структура на таблица `tbl_tv`
--

CREATE TABLE IF NOT EXISTS `tbl_tv` (
  `id_tv` int(10) NOT NULL AUTO_INCREMENT,
  `id_model` int(10) NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `moreinfo` text NOT NULL,
  `picture` varchar(20) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id_tv`),
  KEY `id_make` (`id_model`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Схема на данните от таблица `tbl_tv`
--

INSERT INTO `tbl_tv` (`id_tv`, `id_model`, `price`, `moreinfo`, `picture`, `size`) VALUES
(11, 4, 1230, 'mn qk', '', 6),
(12, 2, 12000, 'mn dobur batko', '', 20),
(14, 1, 600, 'ytuyf', 'Pic14.jpg', 30);

-- --------------------------------------------------------

--
-- Структура на таблица `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `passwd` varchar(15) NOT NULL,
  `usertype` tinyint(1) NOT NULL,
  `personname` varchar(15) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Схема на данните от таблица `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `username`, `passwd`, `usertype`, `personname`) VALUES
(1, 'admin', 'admin', 1, 'Administrator');

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `tbl_tv`
--
ALTER TABLE `tbl_tv`
  ADD CONSTRAINT `tbl_tv_ibfk_1` FOREIGN KEY (`id_model`) REFERENCES `tbl_model` (`id_model`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
