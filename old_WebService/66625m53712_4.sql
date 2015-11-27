-- phpMyAdmin SQL Dump
-- version 4.1.14.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 25. Nov 2015 um 18:28
-- Server Version: 5.5.42
-- PHP-Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `66625m53712_4`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Task_User`
--

CREATE TABLE IF NOT EXISTS `Task_User` (
  `UserId` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserNick` text NOT NULL,
  `UserName` text NOT NULL,
  `UserGUID` text NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateChange` datetime NOT NULL,
  PRIMARY KEY (`UserId`),
  KEY `DateCreate` (`DateCreate`,`DateChange`),
  KEY `DateCreate_2` (`DateCreate`,`DateChange`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Task_UserDevice`
--

CREATE TABLE IF NOT EXISTS `Task_UserDevice` (
  `DeviceId` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserId` bigint(20) NOT NULL,
  `DeviceType` text NOT NULL,
  `DeviceName` text NOT NULL,
  `DeviceModel` text NOT NULL,
  `DeviceLocModel` text NOT NULL,
  `DeviceSysName` text NOT NULL,
  `DeviceSysVersion` text NOT NULL,
  `DateCreate` datetime NOT NULL,
  `DateChange` datetime NOT NULL,
  PRIMARY KEY (`DeviceId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
