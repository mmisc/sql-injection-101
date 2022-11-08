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
  `secret` text NOT NULL,
  `evenmoresecret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secretstuff`
--

INSERT INTO `secretstuff` (`secret`, `evenmoresecret`) VALUES
('23', 'you did well'),
('1337', 'you found the secret!');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` text NOT NULL,
  `mail` text NOT NULL,
  `password` text NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `mail`, `password`, `age`) VALUES
('mischa', 'mischa@zwitscher', 'notthateasy', 21),
('jus', 'jus@zwitscher', 'auchnichtwirklich', 23),
('AzureDiamond', 'ad@example.com', 'hunter2', 2),
('john', 'johndoe@example.com', 'qwertz', 42);

-- --------------------------------------------------------

--
-- Table structure for table `zwitscher`
--

CREATE TABLE IF NOT EXISTS `zwitscher` (
  `user` text NOT NULL,
  `msg` varchar(255) NOT NULL,
  `hashtag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zwitscher`
--

INSERT INTO `zwitscher` (`user`, `msg`, `hashtag`) VALUES
('mischa', '5+5+10', '#trivia'),
('1337hax0r', 'all your base are belong to us', '#netsec'),
('Optimist', 'the glass is half full.', '#trivia'),
('Teacher', 'That is your LAST warning.', '#trivia'),
('Nyan Cat', 'Nyanyanyanyanyanyanya!', '#cat'),
('mischa', 'SQL injections are fun', '#netsec');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zwitscher`
--
ALTER TABLE `zwitscher`
 ADD PRIMARY KEY (`msg`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
