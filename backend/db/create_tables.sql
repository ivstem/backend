-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Чрв 14 2017 р., 14:12
-- Версія сервера: 5.5.54-0ubuntu0.14.04.1
-- Версія PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: ``
--

-- --------------------------------------------------------

--
-- Структура таблиці `plagiat`
--

CREATE TABLE IF NOT EXISTS `plagiat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `per1` float NOT NULL,
  `per2` float NOT NULL,
  `per3` float NOT NULL,
  `per4` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблиці `theses`
--

CREATE TABLE IF NOT EXISTS `theses` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `npp` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `group` varchar(50) NOT NULL,
  `author` varchar(255) NOT NULL,
  `curator` varchar(255) NOT NULL,
  `doc` text NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Структура таблиці `check`
--

CREATE TABLE IF NOT EXISTS `check` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `doc` text NOT NULL,
  `body` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
