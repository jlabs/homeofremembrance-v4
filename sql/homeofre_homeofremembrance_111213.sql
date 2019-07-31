-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2013 at 07:45 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `homeofre_homeofremembrance`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_me`
--

CREATE TABLE IF NOT EXISTS `about_me` (
  `about_me_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `born` text NOT NULL,
  `parents` text NOT NULL,
  `lived` text NOT NULL,
  `educated` text NOT NULL,
  `currently` text NOT NULL,
  `into` text NOT NULL,
  `dont_like` text NOT NULL,
  `about_me` text NOT NULL,
  PRIMARY KEY (`about_me_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `about_me`
--

INSERT INTO `about_me` (`about_me_id`, `user_id`, `born`, `parents`, `lived`, `educated`, `currently`, `into`, `dont_like`, `about_me`) VALUES
(1, 1, 'Nod', 'Alive and well', 'A shoe', 'A place', 'Typing this message', 'Also, typing this message', 'Not typing this message', 'I like typing messages');

-- --------------------------------------------------------

--
-- Table structure for table `bucketlist`
--

CREATE TABLE IF NOT EXISTS `bucketlist` (
  `bucket_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `date_added` date NOT NULL DEFAULT '1990-01-01',
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_date` date DEFAULT NULL,
  PRIMARY KEY (`bucket_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bucketlist`
--

INSERT INTO `bucketlist` (`bucket_id`, `user_id`, `title`, `date_added`, `completed`, `completed_date`) VALUES
(4, 1, 'testing', '1990-01-01', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `diary`
--

CREATE TABLE IF NOT EXISTS `diary` (
  `diary_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `entry_datetime` date NOT NULL,
  `entry_text` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`diary_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `diary`
--

INSERT INTO `diary` (`diary_id`, `user_id`, `entry_datetime`, `entry_text`) VALUES
(12, 1, '2013-09-14', 'started about-me page'),
(11, 1, '2013-09-13', 'gallery page load images done'),
(9, 1, '2013-09-11', 'styled the datepicker and diary page'),
(10, 1, '2013-09-11', 'added a delete button'),
(13, 1, '2013-09-14', 'active header nav bar'),
(14, 1, '2013-09-14', 'testing of the datetime function'),
(15, 1, '2013-09-15', 'bucket list page now loads content'),
(16, 1, '2013-09-22', 'vault page finished for reading data'),
(17, 1, '2013-09-22', 'treasured memories page now reads data'),
(18, 1, '2013-09-27', 'gallery finally uploads, set the page to read the db correctly'),
(19, 1, '2013-10-02', 'bucket list page done'),
(20, 1, '2013-10-02', 'delete gallery entries'),
(22, 1, '2013-12-08', 'frontdoor 80% done');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE IF NOT EXISTS `families` (
  `family_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`family_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`family_id`, `name`) VALUES
(1, 'Bloggs'),
(2, 'Test'),
(3, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `title` text,
  `filename` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `memories`
--

CREATE TABLE IF NOT EXISTS `memories` (
  `memory_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `url` text,
  `desc` text,
  PRIMARY KEY (`memory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `memories`
--

INSERT INTO `memories` (`memory_id`, `user_id`, `url`, `desc`) VALUES
(1, 1, 'http://placedog.com/g/500/500', 'Not sure what to put here');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name',
  `user_password_hash` char(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `family_id` int(11) DEFAULT '2',
  `user_email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email',
  `user_firstname` text COLLATE utf8_unicode_ci,
  `user_surname` text COLLATE utf8_unicode_ci,
  `session_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`user_id`, `user_name`, `user_password_hash`, `family_id`, `user_email`, `user_firstname`, `user_surname`, `session_id`) VALUES
(1, 'joebloggs', '$2y$10$4wQX2bcwRtJ0xZdejYSdNOJ9DKvVrQD.KQQkNeEpTDIb0d2xwF.DO', 1, 'adams.j.6385@gmail.com', 'Joe', 'Bloggs', NULL),
(2, 'guest', '$2y$10$GhSLIz.spuWpaBc.5eaiweNzE29.ICCrqLsNFNKybQ2SeKa/LFdli', 3, 'adams.j.6385@gmail.com', 'Jeff', 'Vader', NULL),
(4, 'johnbloggs', '$2y$10$4wQX2bcwRtJ0xZdejYSdNOJ9DKvVrQD.KQQkNeEpTDIb0d2xwF.DO', 1, 'adams.j.6385@gmail.com', 'John', 'Bloggs', NULL),
(6, 'jeffbloggs', '$2y$10$Vs.BUMOtoeBDdVOkVq8/mOTkGiF9ryUpTMkFexeHRfdxB9jCv9G8i', 1, '1@2.com', 'Jeff', 'Blogs', NULL),
(7, 'darthvader', '$2y$10$d9aFNgHGS1CidNe3T87EROxMKZnj5HCq1Oq.cyCvcOfn2WkQcQDai', 2, 'kajsdkl@saojdsa.com', 'Darth', 'Vader', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `time_capsule`
--

CREATE TABLE IF NOT EXISTS `time_capsule` (
  `capsule_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_added` date DEFAULT NULL,
  `url` text NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`capsule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `time_capsule`
--

INSERT INTO `time_capsule` (`capsule_id`, `user_id`, `date_added`, `url`, `title`) VALUES
(1, 1, '2013-09-15', 'http://placekitten.com/g/200/300', 'A kitten!'),
(2, 1, '2013-09-16', 'http://placedog.com/g/400/400', 'A dawg!');

-- --------------------------------------------------------

--
-- Table structure for table `vault`
--

CREATE TABLE IF NOT EXISTS `vault` (
  `vault_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `doctor_name` text,
  `doctor_contact` text,
  `funeral_arrangements` text,
  `resting_place` text,
  `will` text,
  `additional_info` text,
  PRIMARY KEY (`vault_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vault`
--

INSERT INTO `vault` (`vault_id`, `user_id`, `doctor_name`, `doctor_contact`, `funeral_arrangements`, `resting_place`, `will`, `additional_info`) VALUES
(1, 1, 'Who', 'Time travel', 'Have one', 'A bed probably', 'Yeah Will', 'Subtracted information');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
