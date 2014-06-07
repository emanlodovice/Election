-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2013 at 04:40 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `election`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `candidate_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position_id` int(255) NOT NULL,
  `party_id` int(255) DEFAULT NULL,
  PRIMARY KEY (`candidate_id`),
  KEY `position_id` (`position_id`),
  KEY `party_id` (`party_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `name`, `position_id`, `party_id`) VALUES
(14, 'Eman', 46, 14),
(15, 'Paw', 47, 14),
(16, 'dads', 48, 14),
(17, 'Eman', 49, 15),
(18, 'Dana', 50, 15),
(19, 'Dads', 51, 15);

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE IF NOT EXISTS `elections` (
  `election_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(255) NOT NULL,
  `password` int(255) NOT NULL,
  `privacy` int(255) NOT NULL,
  `description` text NOT NULL,
  `lastdate` datetime NOT NULL,
  PRIMARY KEY (`election_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`election_id`, `user_id`, `title`, `status`, `password`, `privacy`, `description`, `lastdate`) VALUES
(41, 2, 'Election Sample', 1, 1, 0, 'Sample Election', '2013-03-25 23:59:59'),
(42, 3, 'Dana Election', 1, 1, 0, 'Dana Election', '2013-03-26 23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE IF NOT EXISTS `parties` (
  `party_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `election_id` int(255) NOT NULL,
  PRIMARY KEY (`party_id`),
  KEY `election_id` (`election_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`party_id`, `title`, `election_id`) VALUES
(14, 'Test Party', 41),
(15, 'Dana Party', 42);

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE IF NOT EXISTS `passwords` (
  `election_id` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`election_id`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passwords`
--

INSERT INTO `passwords` (`election_id`, `password`) VALUES
(41, '4Ey0N41'),
(41, 'Acsmq41'),
(41, 'cmjAE41'),
(41, 'IBhon41'),
(41, 'JJ8d641'),
(41, 'JLQmg41'),
(41, 'mwFKh41'),
(41, 'qBto941'),
(41, 'rwUgR41'),
(41, 'W9uIT41'),
(42, 'LLUHA42');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `position_id` int(255) NOT NULL AUTO_INCREMENT,
  `election_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`position_id`),
  KEY `election_id` (`election_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `election_id`, `title`) VALUES
(46, 41, 'President'),
(47, 41, 'Vice President'),
(48, 41, 'Secretary'),
(49, 42, 'President'),
(50, 42, 'Vice President'),
(51, 42, 'Yeah');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `program` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `year_level` int(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `firstname`, `lastname`, `program`, `address`, `contact_number`, `year_level`, `password`) VALUES
(2, 'name3anad@gmail.com', 'Emmanuel', 'Lodovice', NULL, NULL, NULL, NULL, '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19'),
(3, 'dat@gmail.com', 'Dana Natasha', 'Barrameda', NULL, NULL, NULL, NULL, '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19'),
(4, 'eman@election.com', 'Emmanuel ', 'Lodovice', NULL, NULL, NULL, NULL, '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `election_id` int(255) NOT NULL,
  `candidate_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `position_id` int(255) NOT NULL,
  PRIMARY KEY (`election_id`,`candidate_id`,`user_id`,`position_id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `user_id` (`user_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`election_id`, `candidate_id`, `user_id`, `position_id`) VALUES
(41, 14, 2, 46),
(41, 15, 2, 47),
(41, 16, 2, 48),
(42, 17, 2, 49),
(42, 17, 3, 49),
(42, 18, 2, 50),
(42, 18, 3, 50),
(42, 19, 2, 51),
(42, 19, 3, 51);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`party_id`) REFERENCES `parties` (`party_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `elections`
--
ALTER TABLE `elections`
  ADD CONSTRAINT `elections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `parties_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `passwords`
--
ALTER TABLE `passwords`
  ADD CONSTRAINT `passwords_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`election_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`candidate_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_4` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE;
