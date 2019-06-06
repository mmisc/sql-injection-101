-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2016 at 12:08 PM
-- Server version: 5.5.49-0+deb8u1
-- PHP Version: 5.6.20-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `zwitscher`;
-- add user
GRANT SELECT ON zwitscher.* TO 'zwitscher'@'%' IDENTIFIED BY 'zwitscher';

USE zwitscher;

DROP TABLE IF EXISTS `secretstuff`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `zwitscher`;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sectrain`
--

-- --------------------------------------------------------

--
-- Table structure for table `secretstuff`
--

CREATE TABLE IF NOT EXISTS `secretstuff` (
  `geheim` text NOT NULL,
  `nochgeheimer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secretstuff`
--

INSERT INTO `secretstuff` (`geheim`, `nochgeheimer`) VALUES
('23', 'gut'),
('1337', 'alles richtig gemacht!');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` text NOT NULL,
  `mail` text NOT NULL,
  `passwort` text NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `mail`, `passwort`, `age`) VALUES
('mischa', 'mischa@mmisc.de', 'soeinfachistdasnicht', 21),
('jus', 'jus@bitgrid.net', 'auchnichtwirklich', 23),
('AzureDiamond', 'ad@example.com', 'hunter2', 2),
('john', 'johndoe@example.com', 'qwertz', 42);

-- --------------------------------------------------------

--
-- Table structure for table `zwitscher`
--

CREATE TABLE IF NOT EXISTS `zwitscher` (
  `user` text NOT NULL,
  `nachricht` varchar(255) NOT NULL,
  `hashtag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zwitscher`
--

INSERT INTO `zwitscher` (`user`, `nachricht`, `hashtag`) VALUES
('mischa', '5+5+10', '#trivia'),
('1337hax0r', 'all your base are belong to us', '#netsec'),
('Optimist', 'Am Ende wird alles gut.', '#trivia'),
('Lehrkraft', 'Nicht fuer die Schule, fuer das Leben lernen wir.', '#trivia'),
('Nyan Cat', 'Nyanyanyanyanyanyanya!', '#cat'),
('mischa', 'SQL injections are fun', '#netsec');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zwitscher`
--
ALTER TABLE `zwitscher`
 ADD PRIMARY KEY (`nachricht`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
