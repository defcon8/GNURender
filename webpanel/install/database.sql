-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 27 aug 2015 om 08:30
-- Serverversie: 5.5.37
-- PHP-Versie: 5.5.25-1~dotdeb+7.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `gnurender`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `actiontypes`
--

CREATE TABLE IF NOT EXISTS `actiontypes` (
  `actiontypeid` int(11) NOT NULL,
  `name` text NOT NULL,
  `phpcode` text NOT NULL,
  PRIMARY KEY (`actiontypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `appid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `version` text NOT NULL,
  `win32` text NOT NULL,
  `win64` text NOT NULL,
  `linux32` text NOT NULL,
  `linux64` text NOT NULL,
  `osx32` text NOT NULL,
  `osx64` text NOT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `dataid` int(11) NOT NULL AUTO_INCREMENT,
  `data` longblob NOT NULL,
  PRIMARY KEY (`dataid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8010 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logbook`
--

CREATE TABLE IF NOT EXISTS `logbook` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `nodeid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `touched` datetime DEFAULT NULL,
  `appversion` text,
  `osname` text,
  `osbit` text,
  `host` text NOT NULL,
  `port` text NOT NULL,
  `user` text NOT NULL,
  `pass` text NOT NULL,
  `path` text NOT NULL,
  `distro` text NOT NULL,
  `authkey` text NOT NULL,
  `machinename` text NOT NULL,
  `osversion` text NOT NULL,
  `processorcount` text NOT NULL,
  PRIMARY KEY (`nodeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `projid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `resourcedataid` int(11) DEFAULT NULL,
  `frames` int(11) NOT NULL,
  `resourcefilename` text NOT NULL,
  `resourcesize` int(11) NOT NULL,
  `script` text,
  PRIMARY KEY (`projid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tasklog`
--

CREATE TABLE IF NOT EXISTS `tasklog` (
  `tasklogid` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `message` text NOT NULL,
  `source` text,
  PRIMARY KEY (`tasklogid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=609959 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `sourcefile` text NOT NULL,
  `outputfile` text NOT NULL,
  `taskid` int(11) NOT NULL AUTO_INCREMENT,
  `application` text NOT NULL,
  `parameters` text NOT NULL,
  `state` int(11) NOT NULL,
  `procoutput` text NOT NULL,
  `dataid` int(11) DEFAULT NULL,
  `framenr` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `format` text NOT NULL,
  `node` text,
  `type` int(11) DEFAULT NULL,
  `procprio` text NOT NULL,
  PRIMARY KEY (`taskid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18829 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `triggers`
--

CREATE TABLE IF NOT EXISTS `triggers` (
  `triggerid` int(11) NOT NULL AUTO_INCREMENT,
  `projid` int(11) NOT NULL,
  `triggertypeid` int(11) NOT NULL,
  `actiontypeid` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`triggerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `triggerstatetypes`
--

CREATE TABLE IF NOT EXISTS `triggerstatetypes` (
  `triggerstateid` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`triggerstateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `triggertypes`
--

CREATE TABLE IF NOT EXISTS `triggertypes` (
  `triggertypeid` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`triggertypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text NOT NULL,
  `name` text NOT NULL,
  `pwd` text NOT NULL,
  `level` int(11) NOT NULL,
  `lang` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
