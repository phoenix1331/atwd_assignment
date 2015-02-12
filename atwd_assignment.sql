-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2014 at 06:42 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `atwd_assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id_country` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(45) NOT NULL,
  `country_url` varchar(120) DEFAULT NULL,
  `country_flag` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id_country`),
  UNIQUE KEY `country_name_UNIQUE` (`country_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id_country`, `country_name`, `country_url`, `country_flag`) VALUES
(1, 'Austria-Hungary', 'http://en.wikipedia.org/wiki/Austria-Hungary', 'http://upload.wikimedia.org/wikipedia/commons/b/b1/Flag_of_Bohemia.svg'),
(2, 'Bohemia', 'http://en.wikipedia.org/wiki/Kingdom_of_Bohemia', ''),
(3, 'United States', 'http://en.wikipedia.org/wiki/United_States', 'http://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg'),
(4, 'Germany', 'http://en.wikipedia.org/wiki/Germany', 'http://upload.wikimedia.org/wikipedia/en/b/ba/Flag_of_Germany.svg'),
(5, 'Cuba', 'http://en.wikipedia.org/wiki/Cuba', 'http://upload.wikimedia.org/wikipedia/commons/b/bd/Flag_of_Cuba.svg'),
(6, 'France', 'http://en.wikipedia.org/wiki/French_Third_Republic', 'http://upload.wikimedia.org/wikipedia/en/c/c3/Flag_of_France.svg'),
(7, 'Soviet émigré', 'http://en.wikipedia.org/wiki/White_émigré', 'http://upload.wikimedia.org/wikipedia/en/f/f3/Flag_of_Russia.svg'),
(8, 'Netherlands', 'http://en.wikipedia.org/wiki/Netherlands', 'http://upload.wikimedia.org/wikipedia/commons/2/20/Flag_of_the_Netherlands.svg'),
(9, 'Soviet Union', 'http://en.wikipedia.org/wiki/Soviet_Union', 'http://upload.wikimedia.org/wikipedia/commons/a/a9/Flag_of_the_Soviet_Union.svg'),
(10, 'RSFSR', 'http://en.wikipedia.org/wiki/RSFSR', ''),
(11, 'Latvian SSR', 'http://en.wikipedia.org/wiki/Latvian_SSR', ''),
(12, 'Armenian SSR', 'http://en.wikipedia.org/wiki/Armenian_SSR', ''),
(13, 'Azerbaijan SSR', 'http://en.wikipedia.org/wiki/Azerbaijan_SSR', ''),
(14, 'Russia', 'http://en.wikipedia.org/wiki/Russia', 'http://upload.wikimedia.org/wikipedia/en/f/f3/Flag_of_Russia.svg'),
(15, 'India ', 'http://en.wikipedia.org/wiki/India', 'http://upload.wikimedia.org/wikipedia/en/4/41/Flag_of_India.svg'),
(16, 'Norway', 'http://en.wikipedia.org/wiki/Norway', 'http://upload.wikimedia.org/wikipedia/commons/d/d9/Flag_of_Norway.svg');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE IF NOT EXISTS `dates` (
  `dates_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_year` varchar(4) DEFAULT NULL,
  `end_year` varchar(4) DEFAULT NULL,
  `notes` varchar(10) DEFAULT NULL,
  `player_id_player` int(11) DEFAULT NULL,
  PRIMARY KEY (`dates_id`),
  KEY `fk_dates_player1` (`player_id_player`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`dates_id`, `start_year`, `end_year`, `notes`, `player_id_player`) VALUES
(1, '1886', '1894', '', 1),
(2, '1894', '1921', '', 2),
(3, '1921', '1927', '', 3),
(4, '1927', '1935', '', 4),
(5, '1937', '1946', '', 4),
(6, '1935', '1937', '', 5),
(7, '1948', '1957', '', 6),
(8, '1958', '1960', '', 6),
(9, '1961', '1963', '', 6),
(10, '1957', '1958', '', 7),
(11, '1960', '1961', '', 8),
(12, '1963', '1969', '', 9),
(13, '1969', '1972', '', 10),
(14, '1972', '1975', '', 11),
(15, '1975', '1985', '', 12),
(16, '1993', '99', 'FIDE', 12),
(17, '1985', '93', 'undisputed', 13),
(18, '1993', '2000', 'Classical', 13),
(19, '2000', '2006', 'classical', 14),
(20, '2006', '2007', 'undisputed', 14),
(21, '2000', '2002', 'FIDE', 15),
(22, '2007', '2013', '', 15),
(23, '2013', '', '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `name_has_country`
--

CREATE TABLE IF NOT EXISTS `name_has_country` (
  `name_idname` int(11) NOT NULL,
  `country_idcountry` int(11) NOT NULL,
  PRIMARY KEY (`name_idname`,`country_idcountry`),
  KEY `fk_name_has_country_country1_idx` (`country_idcountry`),
  KEY `fk_name_has_country_name_idx` (`name_idname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `name_has_country`
--

INSERT INTO `name_has_country` (`name_idname`, `country_idcountry`) VALUES
(1, 1),
(1, 2),
(1, 3),
(11, 3),
(2, 4),
(3, 5),
(4, 6),
(4, 7),
(5, 8),
(6, 9),
(7, 9),
(8, 9),
(9, 9),
(10, 9),
(12, 9),
(13, 9),
(6, 10),
(7, 10),
(10, 10),
(12, 10),
(8, 11),
(9, 12),
(13, 13),
(13, 14),
(14, 14),
(15, 15),
(16, 16);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id_player` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(45) NOT NULL,
  `name_url` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id_player`),
  UNIQUE KEY `full_name_UNIQUE` (`full_name`),
  UNIQUE KEY `id_player_UNIQUE` (`id_player`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id_player`, `full_name`, `name_url`) VALUES
(1, 'Wilhelm Steinitz', 'http://en.wikipedia.org/wiki/Wilhelm_Steinitz'),
(2, 'Emanuel Lasker', 'http://en.wikipedia.org/wiki/Emanuel_Lasker'),
(3, 'José Raúl Capablanca', 'http://en.wikipedia.org/wiki/José_Raúl_Capablanca'),
(4, 'Alexander Alekhine', 'http://en.wikipedia.org/wiki/Alexander_Alekhine'),
(5, 'Max Euwe', 'http://en.wikipedia.org/wiki/Max_Euwe'),
(6, 'Mikhail Botvinnik', 'http://en.wikipedia.org/wiki/Mikhail_Botvinnik'),
(7, 'Vasily Smyslov', 'http://en.wikipedia.org/wiki/Vasily_Smyslov'),
(8, 'Mikhail Tal', 'http://en.wikipedia.org/wiki/Mikhail_Tal'),
(9, 'Tigran Petrosian', 'http://en.wikipedia.org/wiki/Tigran_Petrosian'),
(10, 'Boris Spassky', 'http://en.wikipedia.org/wiki/Boris_Spassky'),
(11, 'Bobby Fischer', 'http://en.wikipedia.org/wiki/Bobby_Fischer'),
(12, 'Anatoly Karpov', 'http://en.wikipedia.org/wiki/Anatoly_Karpov'),
(13, 'Garry Kasparov', 'http://en.wikipedia.org/wiki/Garry_Kasparov'),
(14, 'Vladimir Kramnik', 'http://en.wikipedia.org/wiki/Vladimir_Kramnik'),
(15, 'Viswanathan Anand', 'http://en.wikipedia.org/wiki/Viswanathan_Anand'),
(16, 'Magnus Carlsen', 'http://en.wikipedia.org/wiki/Magnus_Carlsen');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dates`
--
ALTER TABLE `dates`
  ADD CONSTRAINT `fk_dates_player1` FOREIGN KEY (`player_id_player`) REFERENCES `player` (`id_player`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `name_has_country`
--
ALTER TABLE `name_has_country`
  ADD CONSTRAINT `fk_name_has_country_country1` FOREIGN KEY (`country_idcountry`) REFERENCES `country` (`id_country`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_name_has_country_name` FOREIGN KEY (`name_idname`) REFERENCES `player` (`id_player`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
