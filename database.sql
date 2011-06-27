-- phpMyAdmin SQL Dump
-- version 3.3.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2011 at 08:27 AM
-- Server version: 5.0.92
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobiproj_rfmobileproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_interest`
--

CREATE TABLE IF NOT EXISTS `activity_interest` (
  `ID` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `description` text character set utf8 NOT NULL,
  `act_or_int` tinyint(1) NOT NULL,
  `tagsid` int(11) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `activity_interest`
--


-- --------------------------------------------------------

--
-- Table structure for table `basis`
--

CREATE TABLE IF NOT EXISTS `basis` (
  `basis_id` int(11) NOT NULL,
  `basis_name` text NOT NULL,
  PRIMARY KEY  (`basis_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basis`
--


-- --------------------------------------------------------

--
-- Table structure for table `cause_for_notification`
--

CREATE TABLE IF NOT EXISTS `cause_for_notification` (
  `ID` int(11) NOT NULL auto_increment,
  `cause` smallint(2) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `cause` (`cause`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cause_for_notification`
--


-- --------------------------------------------------------

--
-- Table structure for table `connect`
--

CREATE TABLE IF NOT EXISTS `connect` (
  `ID` int(11) NOT NULL auto_increment,
  `userid_1` int(11) NOT NULL,
  `userid_2` int(11) NOT NULL,
  `connectstatus` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `connect`
--

INSERT INTO `connect` (`ID`, `userid_1`, `userid_2`, `connectstatus`) VALUES
(1, 2, 3, 1),
(2, 2, 4, 1),
(3, 3, 4, 1),
(4, 3, 5, 1),
(5, 13, 2, 0),
(6, 13, 3, 1),
(23, 27, 18, 0),
(61, 21, 38, 0),
(24, 27, 21, 0),
(21, 13, 4, 0),
(18, 13, 21, 0),
(22, 13, 14, 0),
(25, 13, 18, 0),
(26, 21, 5, 0),
(27, 19, 13, 1),
(28, 21, 4, 1),
(29, 21, 22, 0),
(30, 21, 3, 1),
(31, 19, 23, 0),
(32, 19, 29, 0),
(33, 19, 4, 1),
(34, 19, 28, 1),
(35, 19, 5, 0),
(36, 19, 19, 1),
(37, 19, 6, 0),
(38, 19, 20, 0),
(39, 19, 2, 1),
(40, 19, 21, 0),
(41, 21, 6, 1),
(42, 19, 3, 1),
(43, 19, 24, 0),
(44, 19, 30, 0),
(45, 19, 27, 0),
(46, 19, 22, 0),
(47, 19, 25, 0),
(48, 19, 14, 0),
(49, 19, 32, 1),
(50, 32, 2, 1),
(51, 32, 3, 1),
(52, 32, 6, 0),
(53, 19, 33, 1),
(54, 33, 2, 1),
(55, 33, 13, 1),
(56, 33, 21, 1),
(57, 28, 6, 0),
(60, 33, 24, 0),
(59, 38, 23, 0),
(62, 21, 39, 0),
(63, 13, 45, 0),
(64, 43, 45, 1),
(65, 33, 45, 0),
(66, 33, 23, 0),
(67, 33, 36, 0),
(68, 48, 14, 0),
(69, 48, 45, 0),
(70, 48, 35, 0),
(71, 48, 29, 0),
(72, 48, 28, 1),
(73, 48, 19, 0),
(74, 43, 23, 0),
(75, 43, 28, 1),
(76, 43, 33, 1),
(77, 43, 46, 0),
(78, 43, 14, 0),
(79, 43, 27, 0),
(80, 54, 33, 1),
(81, 54, 21, 0),
(82, 19, 59, 1),
(83, 19, 54, 0),
(84, 19, 46, 0),
(85, 19, 43, 0),
(86, 19, 35, 0),
(87, 19, 38, 0),
(88, 19, 45, 0),
(89, 19, 51, 0),
(90, 19, 36, 0),
(91, 59, 24, 0),
(92, 59, 21, 0),
(93, 59, 28, 1),
(94, 59, 25, 0),
(95, 59, 35, 0),
(96, 59, 2, 1),
(97, 59, 33, 0),
(98, 59, 6, 0),
(99, 59, 45, 0),
(100, 28, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `ID` int(11) NOT NULL auto_increment,
  `userid_1` int(11) NOT NULL,
  `userid_2` int(11) NOT NULL,
  `followstatus` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`ID`, `userid_1`, `userid_2`, `followstatus`) VALUES
(1, 13, 2, 1),
(2, 13, 3, 1),
(3, 2, 4, 1),
(4, 2, 3, 1),
(60, 2, 13, 1),
(122, 38, 36, 1),
(7, 13, 14, 1),
(8, 13, 6, 1),
(9, 13, 17, 1),
(10, 19, 2, 1),
(11, 20, 13, 1),
(12, 20, 2, 1),
(13, 20, 18, 1),
(14, 13, 18, 1),
(15, 13, 4, 1),
(16, 4, 13, 1),
(17, 13, 20, 1),
(18, 21, 14, 1),
(19, 21, 18, 1),
(20, 21, 13, 1),
(21, 13, 21, 1),
(22, 21, 2, 1),
(23, 21, 3, 1),
(24, 21, 20, 1),
(25, 13, 19, 1),
(26, 21, 6, 1),
(27, 21, 4, 1),
(28, 21, 5, 1),
(29, 22, 13, 1),
(30, 22, 4, 1),
(31, 20, 19, 1),
(32, 21, 17, 1),
(33, 2, 14, 1),
(34, 20, 21, 1),
(35, 20, 17, 1),
(36, 20, 22, 1),
(37, 20, 14, 1),
(38, 20, 4, 1),
(39, 20, 3, 1),
(40, 20, 5, 1),
(41, 20, 6, 1),
(42, 2, 18, 1),
(43, 2, 5, 1),
(63, 4, 21, 1),
(68, 24, 13, 1),
(67, 24, 2, 1),
(54, 2, 20, 1),
(64, 4, 21, 1),
(65, 5, 21, 1),
(66, 5, 4, 1),
(69, 24, 5, 1),
(70, 24, 23, 1),
(71, 24, 6, 1),
(72, 24, 18, 1),
(73, 24, 21, 1),
(74, 24, 20, 1),
(75, 21, 22, 1),
(76, 6, 14, 1),
(77, 24, 4, 1),
(78, 25, 13, 1),
(79, 25, 21, 1),
(80, 25, 2, 1),
(81, 25, 4, 1),
(82, 27, 25, 1),
(83, 25, 27, 1),
(84, 2, 6, 1),
(85, 19, 17, 1),
(86, 21, 24, 1),
(87, 21, 25, 1),
(88, 21, 23, 1),
(89, 21, 19, 1),
(90, 2, 21, 1),
(91, 3, 21, 1),
(92, 30, 3, 1),
(93, 19, 24, 1),
(94, 19, 3, 1),
(95, 19, 21, 1),
(96, 19, 27, 1),
(97, 19, 30, 1),
(98, 19, 25, 1),
(99, 19, 14, 1),
(100, 21, 28, 1),
(101, 19, 22, 1),
(102, 32, 4, 1),
(103, 21, 32, 1),
(104, 21, 29, 1),
(105, 28, 33, 1),
(106, 28, 2, 1),
(107, 28, 21, 1),
(108, 38, 25, 1),
(109, 38, 14, 1),
(110, 38, 6, 1),
(111, 38, 22, 1),
(112, 38, 13, 1),
(113, 38, 32, 1),
(114, 38, 29, 1),
(115, 38, 21, 1),
(116, 38, 35, 1),
(117, 38, 5, 1),
(118, 38, 4, 1),
(119, 38, 2, 1),
(120, 38, 20, 1),
(121, 38, 33, 1),
(123, 21, 35, 1),
(124, 21, 43, 1),
(125, 43, 21, 1),
(126, 43, 38, 1),
(127, 43, 35, 1),
(128, 43, 24, 1),
(129, 43, 46, 1),
(130, 33, 35, 1),
(131, 33, 46, 1),
(132, 33, 38, 1),
(133, 33, 28, 1),
(134, 33, 25, 1),
(135, 33, 43, 1),
(136, 48, 6, 1),
(137, 48, 23, 1),
(138, 33, 48, 1),
(139, 19, 45, 1),
(140, 19, 51, 1),
(141, 19, 38, 1),
(142, 19, 54, 1),
(143, 19, 36, 1),
(144, 19, 43, 1),
(145, 19, 46, 1),
(146, 19, 35, 1),
(147, 59, 23, 1),
(148, 2, 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'default_group', 'this is the normal site member');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `ID` int(11) NOT NULL auto_increment,
  `subject` text character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  `userid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL default '0',
  `date` int(12) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`ID`, `subject`, `content`, `userid`, `parentid`, `date`) VALUES
(1, 'Testing Mail', 'HELLO HELLO!', 2, 0, 1299839267),
(2, '', 'Hello right back at you :-)', 4, 1, 1299839384),
(3, '', 'Woop woop woop woop!', 3, 1, 1299839421),
(4, 'create', 'tesr', 13, 0, 1301325581),
(5, 'create', 'tesr', 13, 0, 1301325663),
(6, 'create', 're', 13, 0, 1301328606),
(7, 'create', 'tag', 13, 0, 1301330422),
(8, 'test send', 'send messge', 13, 0, 1301494891),
(9, 'test send', 'send messge', 13, 0, 1301494945),
(10, 'test send', 'send messge', 13, 0, 1301494993),
(11, 'test message', 'create', 13, 0, 1302527517),
(12, '', 'you me and the other person', 4, 11, 1304934555),
(13, '', 'niaje', 13, 11, 1305009811),
(15, 'API ', 'Sending From API Data Interface. It works!', 5, 0, 1306314154),
(16, 'WASSUP', 'Hi guys! I don''t remember ever sending you guys a message while I was online...so here goes nothing! that makes no sense right?', 4, 0, 1307631734),
(17, 'Urrrrrm!', 'There''s a strange error! very strange error! something like it''s posting twice. not sure why.', 4, 0, 1307631950),
(18, '', 'Guess it has stopped now. Seems to be working OK! right?', 2, 17, 1307632088),
(19, '', 'There was another error! But we should be good for now! what do you guys think?', 3, 17, 1307632300),
(20, '', 'Still not working. strange. very strange.', 4, 17, 1307632367),
(21, '', 'I think i''ve figured it out. was calling the wrong table. let me test and see.', 2, 17, 1307632440),
(22, '', 'Yey! Mpaka notification ime come! this is just awesome!', 4, 17, 1307632477),
(23, '', 'Good stuff people. Good stuff. We should be proud of ourselves.', 3, 17, 1307632513),
(24, '', 'now let''s see if i can reply from my phone. this will be great!', 2, 17, 1307632642),
(25, '', 'testing replies after disconnect!', 2, 11, 1307787760),
(26, '', 'And now let''s see if i can send without having to be redirected to the home page!', 2, 17, 1307790667),
(27, '', 'This message still exists?', 2, 1, 1307790726),
(28, '', 'Yeah, your right. it makes no sense!', 2, 16, 1307790997),
(29, 'Messaging from Mobile!', 'This is going to be awesome if it goes through! please go through! please!', 2, 0, 1307803564),
(30, 'Two time', 'One time two time three time!\nGOOD STUFF!', 2, 0, 1307804509),
(31, '', 'Yeah! Total Good stuff! I can''t believe you''ve been able to do it. AWESOME!', 4, 30, 1307804628),
(32, '', 'Hata mimi bado siamini! this will be awesome! now i can even go home early!', 2, 30, 1307804700),
(33, 'Fixed one error!', 'Done fixing that error where the deleting of recipients isn''t working! hope we are completely sorted for now! MOVING ON SWIFTLY!', 3, 0, 1307958445),
(34, 'Opera Mini Simulator!', 'Did you guys get a message from me? As in this one? Have you have you have you have you? Hmmmmmmmm?', 3, 0, 1307964359),
(35, 'LAUNCH', 'We are meant to be ready for initial testing by end of the day. Do you think we''ll be ready?', 2, 0, 1308149547),
(36, '', 'It''s going to be hard in my opinion. but let''s see how it will work out!', 3, 35, 1308149789),
(37, '', 'I still have. hope. that we can make it.', 2, 35, 1308149899),
(38, 'API', 'sending from API using Multicast', 21, 0, 1308218281),
(39, 'API', 'sending from API using Multicast', 21, 0, 1308219500),
(40, 'API', 'sending from API using Multicast', 21, 0, 1308219569),
(41, 'API', 'sending from API using Multicast', 21, 0, 1308219627),
(42, 'API', 'sending from API using Multicast', 21, 0, 1308219682),
(43, 'Multicast', 'its working!', 13, 0, 1308219806),
(44, '', 'Wow! It''s Friday and we still haven''t finished! Gonna be a long weekend!', 4, 35, 1308324475),
(45, '', 'buyaka!', 2, 35, 1308334210),
(46, 'WHO ARE YOU?', 'I''ve just accepted your friend request and i don''t know who you are... Should i be afraid... This is what stalkers do!', 4, 0, 1308340804),
(47, '', 'don''t worry... sisi wote ni wakulima hapa', 19, 46, 1308341696),
(48, '', 'Ok! Ok! Ni vile tu siku jui so i was wondering who you are...', 4, 46, 1308343563),
(49, '', 'unauza fertilizer ama niaje ?', 19, 46, 1308347249),
(50, '', 'Si you look at my bio and see! Kwani what do you think it''s for?', 4, 46, 1308377199),
(51, '', 'Yeah', 13, 34, 1308394933),
(52, 'test', 'it is running', 13, 0, 1308485726),
(53, 'H', 'H', 13, 0, 1308489326),
(54, 'Hi', 'HEY', 19, 0, 1308516762),
(55, 'J', 'JPG', 19, 0, 1308516963),
(56, '', 'Ninjas, are you Ready!!!', 13, 0, 1308550721),
(57, '', 'Ninjas, are you Ready!!!', 13, 0, 1308550753),
(58, 'Hi', 'Tdx', 19, 0, 1308552509),
(59, 'A', 'nmhjsdfh', 19, 0, 1308553649),
(60, 'Happy father''s day!', 'Happy belated father''s day!', 21, 0, 1308581024),
(61, 'hey', 'Gsiosj', 19, 0, 1308583859);

-- --------------------------------------------------------

--
-- Table structure for table `message_receivers`
--

CREATE TABLE IF NOT EXISTS `message_receivers` (
  `ID` int(11) NOT NULL auto_increment,
  `msgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `count` int(11) NOT NULL default '0',
  `deleted` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

--
-- Dumping data for table `message_receivers`
--

INSERT INTO `message_receivers` (`ID`, `msgid`, `userid`, `count`, `deleted`) VALUES
(1, 1, 3, 3, 1),
(2, 1, 4, 1, 0),
(3, 1, 2, 0, 0),
(4, 2, 3, 0, 0),
(5, 2, 4, 0, 0),
(6, 2, 2, 0, 1),
(7, 3, 3, 0, 0),
(8, 3, 4, 0, 1),
(9, 3, 2, 0, 1),
(10, 4, 2, 0, 1),
(11, 4, 4, 0, 0),
(12, 4, 13, 0, 0),
(13, 5, 2, 0, 1),
(14, 5, 4, 0, 1),
(15, 5, 13, 0, 0),
(16, 6, 2, 0, 1),
(17, 6, 13, 0, 0),
(18, 7, 5, 0, 0),
(19, 7, 13, 0, 0),
(20, 8, 2, 0, 1),
(21, 8, 13, 0, 0),
(22, 9, 2, 0, 1),
(23, 9, 13, 0, 0),
(24, 10, 2, 0, 1),
(25, 10, 13, 0, 0),
(26, 11, 2, 1, 1),
(27, 11, 4, 2, 0),
(28, 11, 13, 3, 0),
(29, 12, 2, 0, 1),
(30, 12, 4, 0, 1),
(31, 12, 13, 0, 0),
(32, 13, 2, 0, 1),
(33, 13, 4, 0, 0),
(34, 13, 13, 0, 0),
(35, 15, 21, 0, 0),
(36, 16, 2, 1, 0),
(37, 16, 3, 1, 0),
(38, 16, 4, 1, 0),
(39, 17, 2, 2, 0),
(40, 17, 3, -2, 0),
(41, 17, 4, 2, 0),
(42, 18, 2, 0, 0),
(43, 18, 3, 0, 1),
(44, 18, 4, 0, 0),
(45, 19, 2, 0, 0),
(46, 19, 3, 0, 0),
(47, 19, 4, 0, 0),
(48, 20, 2, 0, 0),
(49, 20, 3, 0, 1),
(50, 20, 4, 0, 1),
(51, 21, 2, 0, 0),
(52, 21, 3, 0, 1),
(53, 21, 4, 0, 0),
(54, 22, 2, 0, 1),
(55, 22, 3, 0, 1),
(56, 22, 4, 0, 0),
(57, 23, 2, 0, 1),
(58, 23, 3, 0, 1),
(59, 23, 4, 0, 1),
(60, 24, 2, 0, 0),
(61, 24, 3, 0, 1),
(62, 24, 4, 0, 0),
(63, 25, 2, 0, 0),
(64, 25, 4, 0, 0),
(65, 25, 13, 0, 0),
(66, 26, 2, 0, 1),
(67, 26, 3, 0, 1),
(68, 26, 4, 0, 1),
(69, 27, 3, 0, 0),
(70, 27, 4, 0, 0),
(71, 27, 2, 0, 1),
(72, 28, 2, 0, 0),
(73, 28, 3, 0, 0),
(74, 28, 4, 0, 0),
(75, 29, 4, 0, 0),
(76, 29, 3, 0, 0),
(77, 29, 2, 0, 0),
(78, 30, 4, 2, 0),
(79, 30, 3, 2, 0),
(80, 30, 2, 2, 0),
(81, 31, 4, 0, 0),
(82, 31, 3, 0, 0),
(83, 31, 2, 0, 0),
(84, 32, 4, 0, 0),
(85, 32, 3, 0, 0),
(86, 32, 2, 0, 0),
(87, 33, 2, 0, 0),
(88, 33, 13, 0, 0),
(89, 33, 3, 0, 1),
(90, 34, 2, 1, 0),
(91, 34, 5, 1, 0),
(92, 34, 13, 1, 0),
(93, 34, 3, 1, 0),
(94, 35, 3, 4, 0),
(95, 35, 4, 4, 0),
(96, 35, 2, 4, 0),
(97, 36, 3, 0, 0),
(98, 36, 4, 0, 0),
(99, 36, 2, 0, 0),
(100, 37, 3, 0, 0),
(101, 37, 4, 0, 0),
(102, 37, 2, 0, 0),
(103, 41, 2, 0, 0),
(104, 41, 5, 0, 0),
(105, 41, 13, 0, 0),
(106, 42, 2, 0, 0),
(107, 42, 5, 0, 0),
(108, 42, 19, 0, 0),
(109, 42, 13, 0, 0),
(110, 43, 21, 0, 0),
(111, 43, 19, 0, 0),
(112, 44, 3, 0, 0),
(113, 44, 4, 0, 0),
(114, 44, 2, 0, 0),
(115, 45, 3, 0, 0),
(116, 45, 4, 0, 0),
(117, 45, 2, 0, 0),
(118, 46, 19, 4, 0),
(119, 46, 4, 4, 0),
(120, 47, 19, 0, 0),
(121, 47, 4, 0, 0),
(122, 48, 19, 0, 0),
(123, 48, 4, 0, 0),
(124, 49, 19, 0, 0),
(125, 49, 4, 0, 0),
(126, 50, 19, 0, 0),
(127, 50, 4, 0, 0),
(128, 51, 2, 0, 0),
(129, 51, 5, 0, 0),
(130, 51, 13, 0, 0),
(131, 51, 3, 0, 0),
(132, 52, 2, 0, 0),
(133, 52, 19, 0, 0),
(134, 53, 5, 0, 0),
(135, 54, 32, 0, 0),
(136, 55, 4, 0, 0),
(137, 56, 2, 0, 0),
(138, 56, 21, 0, 0),
(139, 56, 19, 0, 0),
(140, 57, 2, 0, 0),
(141, 57, 21, 0, 0),
(142, 57, 19, 0, 0),
(143, 58, 32, 0, 0),
(144, 59, 4, 0, 0),
(145, 59, 19, 0, 0),
(146, 59, 3, 0, 0),
(147, 60, 3333, 0, 0),
(148, 61, 19, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `ID` int(11) NOT NULL auto_increment,
  `causeid` smallint(2) NOT NULL,
  `contentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=361 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ID`, `causeid`, `contentid`, `userid`, `status`) VALUES
(1, 2, 82, 4, 1),
(2, 2, 83, 2, 1),
(3, 2, 84, 4, 1),
(4, 2, 84, 2, 1),
(5, 2, 84, 4, 1),
(6, 1, 85, 3, 1),
(7, 2, 86, 3, 1),
(8, 2, 86, 2, 1),
(9, 2, 87, 3, 1),
(10, 2, 87, 2, 1),
(11, 2, 87, 4, 1),
(12, 3, 12, 2, 1),
(13, 3, 12, 4, 1),
(14, 3, 12, 13, 1),
(15, 2, 88, 2, 1),
(16, 2, 88, 3, 1),
(17, 2, 89, 3, 1),
(18, 2, 89, 2, 1),
(19, 2, 89, 4, 1),
(20, 2, 89, 3, 1),
(21, 2, 90, 3, 1),
(22, 2, 90, 2, 1),
(23, 2, 90, 4, 1),
(24, 2, 90, 3, 1),
(25, 2, 91, 3, 1),
(26, 2, 91, 2, 1),
(27, 2, 91, 4, 1),
(28, 2, 91, 3, 1),
(29, 2, 92, 3, 1),
(30, 2, 92, 2, 1),
(31, 2, 92, 4, 1),
(32, 2, 92, 3, 1),
(33, 2, 94, 3, 1),
(34, 2, 95, 3, 1),
(35, 2, 95, 2, 1),
(36, 2, 95, 4, 1),
(37, 2, 95, 13, 1),
(38, 2, 95, 13, 1),
(39, 2, 95, 13, 1),
(80, 2, 152, 2, 1),
(79, 2, 152, 3, 1),
(78, 5, 70, 23, 0),
(77, 5, 69, 5, 0),
(76, 5, 68, 13, 1),
(51, 5, 60, 13, 1),
(75, 5, 67, 2, 1),
(104, 1, 169, 4, 1),
(81, 2, 153, 3, 1),
(82, 2, 153, 2, 1),
(83, 2, 154, 3, 1),
(84, 2, 154, 2, 1),
(85, 2, 155, 3, 1),
(86, 2, 155, 2, 1),
(87, 2, 156, 3, 1),
(88, 2, 156, 1, 0),
(89, 2, 157, 3, 1),
(90, 2, 157, 2, 1),
(91, 2, 158, 2, 1),
(92, 2, 158, 3, 1),
(93, 2, 158, 4, 1),
(94, 2, 159, 2, 1),
(95, 2, 159, 3, 1),
(96, 2, 159, 4, 1),
(97, 5, 71, 6, 0),
(98, 5, 72, 18, 0),
(99, 5, 73, 21, 1),
(100, 5, 74, 20, 0),
(101, 5, 75, 22, 0),
(102, 2, 165, 3, 1),
(103, 2, 165, 1, 0),
(105, 2, 170, 2, 1),
(106, 5, 76, 14, 0),
(118, 5, 78, 13, 0),
(117, 6, 22, 14, 0),
(109, 2, 180, 2, 1),
(111, 5, 77, 4, 1),
(119, 5, 79, 21, 0),
(120, 5, 80, 2, 1),
(121, 5, 81, 4, 1),
(122, 5, 82, 25, 0),
(123, 6, 23, 18, 0),
(124, 5, 83, 27, 0),
(125, 6, 24, 21, 0),
(126, 2, 189, 2, 1),
(127, 6, 25, 18, 0),
(128, 6, 26, 5, 0),
(129, 5, 84, 6, 0),
(130, 2, 191, 4, 1),
(131, 2, 192, 2, 1),
(132, 2, 193, 4, 1),
(133, 2, 194, 4, 1),
(134, 3, 16, 2, 1),
(135, 3, 16, 3, 1),
(136, 3, 17, 2, 1),
(137, 3, 17, 3, 1),
(138, 3, 21, 3, 1),
(139, 3, 21, 4, 1),
(140, 3, 22, 2, 1),
(141, 3, 22, 3, 1),
(142, 3, 23, 2, 1),
(143, 3, 23, 4, 1),
(144, 3, 24, 3, 1),
(145, 3, 24, 4, 1),
(146, 2, 195, 2, 1),
(147, 3, 25, 4, 1),
(148, 3, 25, 13, 1),
(149, 5, 85, 17, 0),
(150, 3, 26, 3, 1),
(151, 3, 26, 4, 1),
(152, 3, 27, 3, 1),
(153, 3, 27, 4, 1),
(154, 3, 28, 3, 1),
(155, 3, 28, 4, 1),
(156, 3, 29, 4, 1),
(157, 3, 29, 3, 1),
(158, 3, 30, 4, 1),
(159, 3, 30, 3, 1),
(160, 3, 31, 3, 1),
(161, 3, 31, 2, 1),
(162, 3, 32, 4, 1),
(163, 3, 32, 3, 1),
(164, 2, 200, 2, 1),
(165, 3, 33, 2, 1),
(166, 3, 33, 13, 1),
(167, 3, 34, 2, 1),
(168, 3, 34, 5, 0),
(169, 3, 34, 13, 1),
(170, 6, 27, 13, 1),
(171, 6, 27, 13, 1),
(172, 6, 27, 13, 1),
(173, 5, 86, 24, 0),
(174, 5, 87, 25, 0),
(175, 6, 28, 4, 1),
(176, 5, 88, 23, 0),
(177, 5, 89, 19, 1),
(178, 6, 29, 22, 0),
(179, 6, 30, 3, 1),
(180, 5, 90, 21, 1),
(181, 3, 35, 3, 1),
(182, 3, 35, 4, 1),
(183, 3, 36, 4, 1),
(184, 3, 36, 2, 1),
(185, 3, 37, 3, 1),
(186, 3, 37, 4, 1),
(187, 6, 31, 23, 0),
(188, 3, 44, 3, 1),
(189, 3, 44, 2, 1),
(190, 5, 91, 21, 1),
(191, 3, 45, 3, 1),
(192, 3, 45, 4, 1),
(193, 5, 92, 3, 1),
(194, 6, 28, 21, 0),
(195, 6, 28, 21, 0),
(196, 6, 32, 29, 0),
(197, 5, 93, 24, 0),
(198, 6, 33, 4, 1),
(199, 6, 34, 28, 1),
(200, 6, 35, 5, 0),
(201, 5, 94, 3, 1),
(202, 5, 95, 21, 0),
(203, 6, 36, 19, 1),
(204, 3, 46, 19, 1),
(205, 6, 37, 6, 0),
(206, 5, 96, 27, 0),
(207, 6, 38, 20, 0),
(208, 5, 97, 30, 0),
(209, 5, 98, 25, 0),
(210, 3, 47, 4, 1),
(211, 6, 39, 2, 1),
(212, 6, 40, 21, 0),
(213, 5, 99, 14, 0),
(214, 3, 48, 19, 1),
(215, 2, 214, 1, 0),
(216, 6, 41, 6, 0),
(217, 3, 49, 4, 1),
(218, 5, 100, 28, 0),
(219, 5, 101, 22, 0),
(220, 6, 42, 3, 1),
(221, 6, 43, 24, 0),
(222, 6, 44, 30, 0),
(223, 6, 45, 27, 0),
(224, 6, 46, 22, 0),
(225, 6, 47, 25, 0),
(226, 6, 48, 14, 0),
(227, 3, 50, 19, 1),
(228, 1, 218, 4, 1),
(229, 2, 219, 4, 1),
(230, 6, 49, 32, 1),
(231, 6, 50, 2, 1),
(232, 6, 51, 3, 1),
(233, 5, 102, 4, 1),
(234, 6, 52, 6, 0),
(235, 2, 221, 3, 1),
(236, 6, 53, 33, 1),
(237, 3, 51, 2, 1),
(238, 3, 51, 5, 0),
(239, 3, 51, 3, 1),
(240, 5, 104, 29, 0),
(241, 2, 229, 1, 0),
(242, 6, 54, 2, 1),
(243, 6, 55, 13, 1),
(244, 6, 56, 21, 0),
(245, 5, 105, 33, 1),
(246, 5, 106, 2, 1),
(247, 6, 57, 6, 0),
(248, 5, 107, 21, 0),
(249, 6, 58, 5, 0),
(250, 6, 59, 23, 0),
(251, 5, 108, 25, 0),
(252, 5, 109, 14, 0),
(253, 5, 110, 6, 0),
(254, 5, 111, 22, 0),
(255, 5, 112, 13, 0),
(256, 5, 113, 32, 0),
(257, 5, 114, 29, 0),
(258, 5, 115, 21, 1),
(259, 5, 116, 35, 0),
(260, 5, 117, 5, 0),
(261, 5, 118, 4, 0),
(262, 5, 119, 2, 1),
(263, 5, 120, 20, 0),
(264, 5, 121, 33, 1),
(265, 6, 60, 24, 0),
(266, 5, 122, 36, 0),
(267, 6, 61, 38, 0),
(268, 5, 123, 35, 0),
(269, 6, 62, 39, 0),
(270, 6, 63, 45, 0),
(271, 5, 124, 43, 1),
(272, 2, 233, 1, 0),
(273, 2, 233, 3, 0),
(274, 5, 125, 21, 0),
(275, 5, 126, 38, 0),
(276, 5, 127, 35, 0),
(277, 5, 128, 24, 0),
(278, 5, 129, 46, 0),
(279, 6, 64, 45, 1),
(280, 2, 235, 1, 0),
(281, 2, 235, 1, 0),
(282, 5, 130, 35, 0),
(283, 5, 131, 46, 0),
(284, 5, 132, 38, 0),
(285, 5, 133, 28, 0),
(286, 5, 134, 25, 0),
(287, 1, 236, 4, 0),
(288, 6, 65, 45, 0),
(289, 6, 66, 23, 0),
(290, 6, 67, 36, 0),
(291, 5, 135, 43, 0),
(292, 1, 237, 33, 1),
(293, 6, 68, 14, 0),
(294, 6, 69, 45, 0),
(295, 6, 70, 35, 0),
(296, 6, 71, 29, 0),
(297, 6, 72, 28, 1),
(298, 6, 73, 19, 0),
(299, 5, 136, 6, 0),
(300, 5, 137, 23, 0),
(301, 2, 239, 2, 1),
(302, 6, 74, 23, 0),
(303, 6, 75, 28, 1),
(304, 6, 76, 33, 1),
(305, 6, 77, 46, 0),
(306, 6, 78, 14, 0),
(307, 6, 79, 27, 0),
(308, 5, 138, 48, 0),
(309, 6, 80, 33, 1),
(310, 6, 81, 21, 0),
(311, 2, 242, 2, 1),
(312, 2, 242, 3, 0),
(313, 2, 243, 3, 0),
(314, 2, 243, 1, 0),
(315, 1, 244, 33, 0),
(316, 2, 245, 1, 0),
(317, 2, 245, 3, 0),
(318, 2, 246, 1, 0),
(319, 2, 246, 3, 0),
(320, 2, 246, 1, 0),
(321, 2, 247, 3, 0),
(322, 2, 247, 1, 0),
(323, 2, 247, 2, 1),
(324, 5, 139, 45, 0),
(325, 6, 82, 59, 1),
(326, 5, 140, 51, 0),
(327, 5, 141, 38, 0),
(328, 5, 142, 54, 0),
(329, 5, 143, 36, 0),
(330, 5, 144, 43, 0),
(331, 5, 145, 46, 0),
(332, 5, 146, 35, 0),
(333, 6, 83, 54, 0),
(334, 6, 84, 46, 0),
(335, 6, 85, 43, 0),
(336, 6, 86, 35, 0),
(337, 6, 87, 38, 0),
(338, 6, 88, 45, 0),
(339, 6, 89, 51, 0),
(340, 6, 90, 36, 0),
(341, 6, 91, 24, 0),
(342, 6, 92, 21, 0),
(343, 6, 93, 28, 1),
(344, 6, 94, 25, 0),
(345, 6, 95, 35, 0),
(346, 6, 96, 2, 1),
(347, 6, 97, 33, 0),
(348, 6, 98, 6, 0),
(349, 6, 99, 45, 0),
(350, 6, 100, 13, 1),
(351, 5, 147, 23, 0),
(352, 2, 252, 2, 1),
(353, 2, 253, 2, 1),
(354, 2, 254, 1, 0),
(355, 2, 254, 3, 0),
(356, 2, 254, 1, 0),
(357, 5, 148, 28, 0),
(358, 2, 256, 2, 0),
(359, 2, 260, 2, 0),
(360, 2, 260, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(20) character set utf8 NOT NULL,
  `firstname` varchar(50) character set utf8 NOT NULL,
  `lastname` varchar(50) character set utf8 NOT NULL,
  `country` varchar(20) character set utf8 NOT NULL,
  `location` varchar(20) character set utf8 NOT NULL,
  `activity` text NOT NULL,
  `interest` text NOT NULL,
  `email` varchar(100) character set utf8 NOT NULL,
  `phonenum` varchar(12) character set utf8 NOT NULL,
  `avatar` varchar(250) character set utf8 NOT NULL,
  `password` varchar(50) character set utf8 NOT NULL,
  `flagstatus` tinyint(1) NOT NULL default '0',
  `userstatus` tinyint(1) NOT NULL default '0',
  `activation_code` varchar(40) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `forgotten_password_code` varchar(40) NOT NULL,
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`userid`, `username`, `firstname`, `lastname`, `country`, `location`, `activity`, `interest`, `email`, `phonenum`, `avatar`, `password`, `flagstatus`, `userstatus`, `activation_code`, `ip_address`, `forgotten_password_code`) VALUES
(14, 'dane', 'Jane', 'Dane', '', '', '', '', 'dane@domain.com', '', '', '2c5650b7a0cf0032160b15837b67ba106d4b4d88', 0, 0, '', '41.212.124.131', ''),
(18, 'Amasy', 'ama', 'sy', '', '', '', '', 'amasy@test.com', '', '', '455cb744eabaddb5dc618040e109950d130395af', 0, 0, '7a0fb9ab0f94c72ff0e7293205afd3768d401a72', '41.72.207.150', ''),
(2, 'mozey', 'Moses', 'Mutuku', '0', 'nairobi', 'potatoes', 'making money', 'mozesmutuku@yahoo.com', '', '', '05f079b4e8fd025a4593213ef2892fa769c749e6', 0, 0, '', '41.212.101.35', '9995d08c017d6bc77afea20e66189e9f1cf205b1'),
(3, 'knzau', 'Ken', 'Nzau', '', '', '', '', 'domain@invalidomain.com', '', '', 'ead0e8374dffd7872919616eac62c6f869addd08', 0, 0, '', '41.212.101.35', ''),
(4, 'mumbua', 'Phyllis', 'Mumbua', 'Kenya', 'Kisumu', 'Farming, small scale for the mean time. And a little fishing on the side.', 'Environmental pollution, how to increase yields, market data information', 'mumbua@invalidomain.com', '', '', 'c1d641532b2307f0e12648b013fa5d8b0ce235c9', 0, 0, '', '41.212.101.35', ''),
(48, 'dun1985', 'Duncan', 'Akhobe', '', '', '', '', 'dakhobe@yahoo.com', '254737751858', '', '7eb766a3f5c83f681a30bbbb0499204e8e38f8af', 0, 0, '', '41.212.101.47', ''),
(6, 'joshua', 'Joshua', 'Wanyama', '', '', '', '', 'joshua@invalidomain.com', '', '', 'e669b06014a90d648353dc232da094e293ce3a42', 0, 0, '', '41.212.101.35', ''),
(13, 'comark', 'comark', 'onani', 'none', '', '', '', 'comark@pamojamedia.com', '', '', '5d012517933f3b5bad9dd3b41c2cadb6fab055be', 0, 0, '', '41.212.124.236', ''),
(17, 'johndoe', 'john', 'doe', '', '', '', '', 'johndoe@domain.com', '', '', 'edfb5b70898dede3e1742d046c32b2465c2ad698', 0, 0, '6aa2cfc740c1b02f13432331a7edd1c49bcc28f0', '41.212.124.131', ''),
(19, 'testAcc', 'evans', 'gikunda', 'Kenya', 'nairobi', '', '', 'officialevans@gmail.com', '', '', 'b363f82f0ac383d83f9289edeec1c357aa3d72a0', 0, 0, '', '41.72.207.150', '27a8d16d22c66f7f0053ab16476fcfa9e253cddc'),
(20, 'Amasy2011', 'Evans', 'Giks', '', '', '', '', 'easally@gmail.com', '', '', '3b9b226e156a440406761c7d4d13216906f387ae', 0, 0, '', '41.212.101.6', ''),
(21, 'Ishuah', 'Ishuah', 'Kariuki', '', '', '', '', 'ishuah91@gmail.com', '', '', '7c3eae5dfd9d7a3e90ca62c0c3a7cae4f8aecb6e', 0, 0, '', '41.212.101.47', ''),
(22, 'testuser', 'test', 'user', '', '', '', '', 'malobacomark@yahoo.com', '', '', '5579f6f23baa4a021c53677e66b5d5a4a35b9c79', 0, 0, '', '41.212.101.47', ''),
(23, 'akahurani', 'arthur', 'kahu', '', '', '', '', 'arthur@pamojamedia.com', '', '', 'abcdc6429b90db9e167449c24b0bbdbb307f0c42', 0, 0, '', '41.212.101.47', '484aeb7bdaba03432f0a01ac574dbdba34b01f0c'),
(24, 'mungeibrian', 'Brian', 'Mungei', '', '', '', '', 'mungeibrian@gmail.com', '', '', 'a438d6e65db8dde0061d6227d68f728f029ea1cb', 0, 0, '', '41.212.101.47', '73e95624dc6f5b042ad90cc931208e11d8c49c9a'),
(25, 'Evans', 'Evans', 'Gikunda', '', '', '', '', 'evans@pamojamedia.com', '', '', '3a6281c07fa4d6e43519195a9b12bda4889eccc1', 0, 0, '', '41.212.101.47', ''),
(26, 'FarmerArthur', 'Arthur', 'Kahu', '', '', '', '', 'artkahukahu@gmail.com', '', '', 'e907ab8e2d4dde4a5caae5012467efda71aa8973', 0, 0, 'ba90aa3723f6fc3271afe8e3ed74a7960164b1d5', '41.212.101.47', ''),
(27, 'FarmerArtur', 'Arthur', 'Kahu', '', '', '', '', 'arturkahukahu@gmail.com', '', '', '9e09e9f7d18cb4e12bdecbafdfd4bfaac89d31ca', 0, 0, '', '41.212.101.47', ''),
(28, 'kikwaitom', 'tom', 'kikwai', '', '', '', '', 'tom@pamojamedia.com', '', '', 'd59eff85e930ceaf18ed59b1d8030297f5980875', 0, 0, '', '41.212.101.47', ''),
(29, 'mutuku', 'James', 'Maina', '', '', '', '', '', '', '', 'cd73e082d009e7dacbaf1324e1807ec0d24fc650', 0, 0, '', '80.239.242.114', ''),
(30, 'musaaa', 'Sylvester', 'Okhombe', '', '', '', '', '', '0724645986', '', 'deb777e111d48a4fcfec86477a97e1a78d35eb79', 0, 0, '', '41.212.101.47', ''),
(31, 'place', 'second', 'third', '', '', '', '', 'place@domain.com', '254876453210', '', '48cf9b2ebf7d59a2bd3da9f615d171e72e7b7026', 0, 0, 'ad74f1df84ab95826e697054e12c864128ed61c4', '41.212.101.47', ''),
(32, 'zucker', 'Mark', 'Zuckerbug', '', '', '', '', '', '254724645968', '', '32d0fea0a4586a9a4617b076b9e710bc944b2e72', 0, 0, '', '41.212.101.47', ''),
(33, 'wanyama', 'Joshua', 'Wanyama', 'Kenya', 'Nairobi', 'Part time farming, mobile technology design and development for agriculture.', 'Farming, IT, design, entrepreneurship, photography', 'joshua@pamojamedia.com', '254717514477', '', 'da91313d49df84dd9d902dbf134613a3718a406a', 0, 0, '', '41.212.101.47', ''),
(46, 'Kimberly', 'Kimberly', 'Karanja', '', '', '', '', 'kimberly@pamojamedia.com', '25429720710', '', '36b1d44d96bad8d998242dc74f4957ad3e22a946', 0, 0, '', '41.212.101.47', ''),
(35, 'chaukaas', 'Christian', 'Haukaas', '', '', '', '', 'christian@pamojamedia.com', '254788481708', '', '88923c6412d7f853e0c6a7fc3f5c1cef0c3aa656', 0, 0, '', '41.212.101.47', ''),
(36, 'brian', 'Brian', 'Mungei', '', '', '', '', 'brian@pamojamedia.com', '254726441080', '', '9d446a2f8773f080d13d71f377c2f3462cdade9b', 0, 0, '', '41.212.101.47', ''),
(54, 'chinlun', 'chinlun', 'fua', '', '', '', '', '', '254724645986', '', '72a7dd4cdea5baced5ec041502669ccd0b772f9d', 0, 0, '', '80.84.1.23', ''),
(38, 'Wanjau', 'Ian', 'wanjau', '', '', '', '', 'ibradnjau@gmail.com', '254722176146', '', '96438858c3594eee27f847b81703b5906ef98a6a', 0, 0, '', '41.212.101.47', '7927'),
(39, 'ndama', 'Fahali', 'Ngombe', '', '', '', '', 'mark@pamojamedia.com', '254738276333', '', '6e8fd5005aa03b096e9374569eca97640a5f1d28', 0, 1, '', '41.212.101.47', ''),
(45, 'cindyokello', 'Cindy', 'Okello', '', '', '', '', 'wickedcyz@gmail.com', '254726616966', '', '863c2606afd44b4002ae0b824a3611318329dc32', 0, 0, '', '41.212.101.47', ''),
(43, 'markno', 'mark', 'oino', '', '', '', '', 'oinomark@gmail.com', '254729363832', '', '4745c96c681c80d84561951b76b6535e633c7896', 0, 0, '', '41.212.101.47', ''),
(47, 'living', 'Living', 'Stone', '', '', '', '', 'judith@invalidomains.com', '254724645', '', '3e186b54f22efb746ea83054e002c3ce629ab45e', 0, 0, '8105', '80.239.242.127', ''),
(49, 'bounce', 'bouncing', 'castles', '', '', '', '', '', '2547246', '', '444a1b2eeab2b92e6d7b22b06fe597135eccae2c', 0, 0, '5084', '80.84.1.23', ''),
(55, 'Janet', 'Janet', 'Wangui', '', '', '', '', 'Wanguijanet69@yahoo.com', '254254714036', '', 'c9561d577d26ba6208c5f591146685581064e738', 0, 0, '8868', '196.201.208.32', ''),
(51, 'ukulima', 'uku', 'lima', '', '', '', '', '', '4724645986', '', 'eb427939cb028a5052806fa390762f52403de93f', 0, 0, '', '80.84.1.23', ''),
(58, 'ericochieng', 'eric', 'ochieng', '', '', '', '', 'ericochieng@gmail.com', '254726647077', '', '5b9722e427e3cf69ae3db813d629a16bbb4fde38', 0, 0, '3099', '41.212.101.47', ''),
(57, 'swagga', 'steve', 'mpumzella', '', '', '', '', 'ishuah@gmail.com', '254725168131', '', 'c299d6bc7f7f5c5aa75e6141ba61c081bd34fadd', 0, 0, '7160', '80.239.243.56', ''),
(59, 'KarenChindia', 'Karen', 'Chindia', '', '', '', '', 'kchindia@yahoo.com', '254738442442', '', 'dcb667b2271523b3d0c2d37c6f54f55c5825dbf4', 0, 0, '', '41.212.101.47', '');

-- --------------------------------------------------------

--
-- Table structure for table `recommend`
--

CREATE TABLE IF NOT EXISTS `recommend` (
  `ID` int(11) NOT NULL auto_increment,
  `userid_1` int(11) NOT NULL,
  `userid_2` int(11) NOT NULL,
  `basis` text character set utf8 NOT NULL,
  `tagsid` int(11) NOT NULL,
  `date` int(12) NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `recommend`
--


-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `ID` int(11) NOT NULL auto_increment,
  `causeid` smallint(2) NOT NULL,
  `contentid` int(11) NOT NULL,
  `basis` text NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `userid` int(11) NOT NULL,
  `date` int(12) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reports`
--


-- --------------------------------------------------------

--
-- Table structure for table `report_areas`
--

CREATE TABLE IF NOT EXISTS `report_areas` (
  `ID` int(11) NOT NULL auto_increment,
  `contentarea` smallint(2) NOT NULL,
  `enabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `report_areas`
--


-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `searchid` int(11) NOT NULL auto_increment,
  `text` text character set utf8 NOT NULL,
  `date` int(12) NOT NULL default '0',
  `userid` int(11) NOT NULL,
  PRIMARY KEY  (`searchid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `search`
--


-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `ID` int(11) NOT NULL,
  `tagnameid` int(11) NOT NULL,
  PRIMARY KEY  (`ID`,`tagnameid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--


-- --------------------------------------------------------

--
-- Table structure for table `tag_names`
--

CREATE TABLE IF NOT EXISTS `tag_names` (
  `ID` int(11) NOT NULL default '0',
  `name` varchar(15) character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_names`
--


-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `ID` int(11) NOT NULL auto_increment,
  `update` varchar(400) NOT NULL,
  `userid` int(11) NOT NULL,
  `tagsid` int(11) NOT NULL,
  `ownersid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL default '0',
  `date` int(12) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=263 ;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`ID`, `update`, `userid`, `tagsid`, `ownersid`, `parentid`, `date`, `count`, `deleted`) VALUES
(1, 'This is my very first update. I''m going to love this project.', 2, 1, 0, 0, 1298447018, 1, 0),
(2, 'Weuwe! My updates are working. You know...later when people see these updates. They''ll just know I was the one who was programming it.\n#Cheapthrills', 2, 0, 0, 0, 1298447518, 0, 0),
(3, 'WOOP WOOP WOOP WOOP!', 2, 0, 0, 0, 1298447531, 0, 0),
(4, 'Let me try this update and see if it works.', 2, 0, 0, 0, 1298465096, 0, 0),
(5, 'Let me see if the updates are still working.', 2, 0, 0, 0, 1298467151, 1, 0),
(6, 'So how far have you gone?', 2, 0, 0, 1, 1298470541, 0, 0),
(7, 'So how is it going so far?', 2, 0, 0, 5, 1298539770, 0, 0),
(8, 'Wow! Now we can do updates and they appear right in the page without having to refresh the page.', 2, 0, 0, 0, 1298882128, 0, 0),
(9, 'OK! For some reason that last one did not use ajax. let''s see if it will work now.', 2, 0, 0, 0, 1298882175, 0, 0),
(10, 'Why...oh why oh why', 2, 0, 0, 0, 1298882327, 0, 0),
(11, 'Just work maen!', 2, 0, 0, 0, 1298882553, 0, 0),
(12, 'Really. Why you not working?', 2, 0, 0, 0, 1298882777, 0, 0),
(13, 'Why oh why....', 2, 0, 0, 0, 1298883356, 0, 0),
(14, 'Now you have updated. Ebu please work.', 2, 0, 0, 0, 1298883972, 0, 0),
(15, 'Now i''m sure you have picked the css also. Let''s see you do the update maen.', 2, 0, 0, 0, 1298884093, 0, 0),
(16, 'Now, now asin now, not the last time. I know you have the css.', 2, 0, 0, 0, 1298884253, 0, 0),
(17, 'Welllllla! Hope you are working now.', 2, 0, 0, 0, 1298885547, 0, 0),
(18, 'Let''s see if it is working on chrome also!', 2, 0, 0, 0, 1298888608, 1, 0),
(19, 'Tweet tweet tweet!', 2, 0, 0, 18, 1298891555, 0, 0),
(20, 'Hi! Testing how it works without javascript.', 2, 0, 0, 0, 1298891641, 0, 0),
(21, 'Does it still work without javascript?', 2, 0, 0, 0, 1298891661, 3, 0),
(22, 'Sweet! What about comments?', 2, 0, 0, 21, 1298891678, 0, 0),
(23, 'Comments comments comments right here.', 2, 0, 0, 21, 1298891849, 0, 0),
(24, 'All this psyche is from some recent acquired images.', 2, 0, 0, 0, 1298893403, 0, 0),
(25, 'Really? Does it work without javascript.', 2, 0, 0, 21, 1298893437, 0, 0),
(26, 'Let''s see if this thing is working online also.', 2, 0, 0, 0, 1298898601, 0, 0),
(27, 'Let''s see if it is working now.', 2, 0, 0, 0, 1298898631, 0, 0),
(28, 'Now, next level', 2, 0, 0, 0, 1298898767, 1, 0),
(29, 'checking it out again.', 2, 0, 0, 0, 1298899522, 1, 0),
(30, 'Testing updates on IE', 2, 0, 0, 0, 1298899642, 5, 0),
(31, 'Comments also.', 2, 0, 0, 29, 1298899666, 0, 0),
(32, 'test update', 9, 0, 0, 0, 1298899846, 0, 0),
(33, 'multiple updates', 9, 0, 0, 0, 1298899858, 1, 0),
(34, 'a new comment', 9, 0, 0, 33, 1298899917, 0, 0),
(35, 'Let''s check it internally', 2, 0, 0, 28, 1298908380, 0, 0),
(36, 'Let''s see how you work online now :-)\nHello dear brother :-)', 2, 0, 0, 0, 1299130291, 0, 0),
(37, 'Na comments?', 2, 0, 0, 30, 1299130313, 0, 0),
(38, 'Sweet!', 2, 0, 0, 30, 1299130323, 0, 0),
(39, 'Testing failure...', 2, 0, 0, 30, 1299130359, 0, 0),
(40, 'The failure bit works also.', 2, 0, 0, 30, 1299130371, 0, 0),
(41, 'Good stuff. The viewing specific comments bit is also working.', 2, 0, 0, 30, 1299130441, 0, 0),
(42, 'Check this out!', 2, 0, 0, 0, 1299218833, 0, 0),
(43, 'Testing posting again.', 2, 0, 0, 0, 1299219099, 2, 0),
(44, 'Testing comments...', 2, 0, 0, 43, 1299219110, 0, 1),
(45, 'So, why can''t i delete...', 2, 0, 0, 43, 1299219122, 0, 1),
(46, 'New new new update :-)', 2, 0, 0, 0, 1299219399, 1, 1),
(47, 'And it''s comments right here :-)', 2, 0, 0, 46, 1299219417, 0, 1),
(48, 'Sweet! Deletion done.', 2, 0, 0, 0, 1299219460, 0, 0),
(49, 'Checking this out for like the last time.', 2, 0, 0, 0, 1299240170, 0, 0),
(50, 'Woop woop! It''s working like great.', 2, 0, 0, 0, 1299240189, 2, 0),
(51, 'Now check this out!', 2, 0, 0, 50, 1299240213, 0, 0),
(52, 'Yey! It''s working.', 2, 0, 0, 50, 1299240224, 0, 1),
(53, 'Darn slow internets.', 2, 0, 0, 50, 1299240263, 0, 0),
(54, 'Hello there!', 2, 0, 0, 0, 1299837820, 0, 1),
(55, 'It''s a new week. I hope it will work out great!', 2, 0, 0, 0, 1300087106, 0, 0),
(56, 'hello world', 13, 0, 0, 0, 1300371700, 0, 1),
(57, 'test', 13, 0, 0, 0, 1300371850, 0, 1),
(58, 'another one', 13, 0, 0, 0, 1300371914, 0, 1),
(59, 'Test post', 2, 0, 0, 0, 1300372059, 1, 0),
(60, 'new update', 13, 0, 0, 0, 1300372180, 0, 1),
(61, 'test', 13, 0, 0, 0, 1300383434, 0, 1),
(62, 'another', 13, 0, 0, 0, 1300383445, 0, 1),
(63, 'here', 13, 0, 0, 0, 1300383874, 0, 1),
(64, 'test', 13, 0, 0, 0, 1300467235, 0, 1),
(65, 'test', 13, 0, 0, 0, 1300684919, 0, 1),
(66, 'another post', 13, 0, 0, 0, 1300685543, 0, 1),
(67, 'another\n', 13, 0, 0, 0, 1300685550, 0, 1),
(68, 'test', 13, 0, 0, 0, 1300688779, 0, 1),
(69, 'test comarkl', 13, 0, 0, 0, 1300714018, 0, 1),
(70, 'test', 13, 0, 0, 0, 1300714822, 0, 1),
(71, 'I am sitting here with some clever people. Wasininyonye damu!!!!!', 14, 0, 0, 0, 1300718088, 0, 0),
(72, 'Tom is slowly understanding what is going on...\nSlowly', 14, 0, 0, 0, 1300718118, 0, 0),
(73, 'slowly', 14, 0, 0, 0, 1300718173, 0, 0),
(74, 'test comment\n', 13, 0, 0, 59, 1301285663, 0, 1),
(75, 'send this one also', 13, 0, 0, 0, 1301286670, 0, 1),
(76, 'java update', 13, 0, 0, 0, 1301303948, 0, 1),
(77, 'share', 13, 0, 0, 0, 1301492613, 0, 1),
(78, 'share again', 13, 0, 0, 0, 1301493220, 0, 1),
(79, 'first test update', 19, 0, 0, 0, 1302795853, 0, 0),
(80, 'test', 21, 0, 0, 0, 1304584387, 0, 0),
(81, 'Testing the on line area!', 4, 0, 0, 0, 1304930768, 4, 0),
(82, 'Testing notifications :-)', 2, 0, 0, 81, 1304930799, 0, 0),
(83, 'Wasup moz! how you been?', 4, 0, 0, 81, 1304930925, 0, 0),
(84, 'Heey! how is it going?', 3, 0, 0, 81, 1304931840, 0, 0),
(85, 'Niaje Ken! How you been?', 2, 0, 3, 0, 1304931961, 5, 0),
(86, 'Yeah Ken, how you doing? Haven''t seen you for long!', 4, 0, 0, 85, 1304932024, 0, 0),
(87, 'Mimi niko fiti wasee. Jee Wewe?', 3, 0, 0, 85, 1304932075, 0, 0),
(88, 'Ai, ati what?', 4, 0, 0, 81, 1304934614, 0, 0),
(89, 'Niko poa', 13, 0, 0, 85, 1304935400, 0, 0),
(90, 'Check this out', 13, 0, 0, 85, 1304935411, 0, 1),
(91, 'Spamming your comment', 13, 0, 0, 85, 1304935426, 0, 1),
(92, 'Nye nye bu bu', 13, 0, 0, 85, 1304935454, 0, 1),
(93, 'Check this out!', 3, 0, 0, 0, 1304943129, 6, 0),
(94, 'Wassup wassup maen!', 2, 0, 0, 93, 1304943152, 0, 0),
(95, 'Reply pap!', 3, 0, 0, 85, 1304944575, 0, 1),
(96, 'second update', 21, 0, 0, 0, 1305009450, 0, 0),
(97, 'I am :) \n', 21, 0, 0, 0, 1305016798, 0, 0),
(98, 'My first Update from API data interface.', 21, 0, 0, 0, 1306316428, 0, 0),
(99, 'Wrote this from the API data interface.', 21, 0, 2, 0, 1306316500, 0, 0),
(100, 'Waaaakulima! Ongezeni Kilimo....', 24, 0, 0, 0, 1306833482, 0, 0),
(101, 'Test update', 13, 0, 0, 0, 1307182054, 0, 1),
(102, 'and a test comment', 13, 0, 0, 101, 1307185292, 0, 1),
(133, 'test commetn', 13, 0, 0, 103, 1307207340, 0, 1),
(103, 'New update with funky css', 13, 0, 0, 0, 1307188503, 0, 1),
(104, 'another one', 13, 0, 0, 0, 1307188605, 0, 1),
(105, 'finally', 13, 0, 0, 0, 1307188734, 0, 1),
(106, 'commment', 13, 0, 0, 105, 1307188749, 0, 0),
(107, 'and a test comment', 13, 0, 0, 101, 1307194457, 0, 1),
(108, 'Setting a new Interface! Looking good. Like it!', 2, 0, 0, 0, 1307197600, 0, 1),
(109, 'Comark update on phone', 13, 0, 0, 0, 1307197988, 0, 1),
(110, 'http://ukulima.net/test/user/profile.html', 13, 0, 0, 0, 1307203424, 0, 1),
(111, 'javascript loads', 13, 0, 0, 0, 1307203927, 0, 1),
(112, 'Javascript loads again', 13, 0, 0, 0, 1307204210, 0, 1),
(113, 'Javascript loads part 2', 13, 0, 0, 0, 1307204425, 0, 1),
(114, 'comment on Js', 13, 0, 0, 113, 1307204435, 0, 1),
(115, 'commetn', 13, 0, 0, 103, 1307204452, 0, 1),
(132, 'comment', 13, 0, 0, 103, 1307207142, 0, 1),
(116, 'place', 13, 0, 0, 113, 1307204551, 0, 1),
(117, 'Js update', 13, 0, 0, 0, 1307204638, 0, 1),
(118, 'test', 13, 0, 0, 117, 1307204680, 0, 1),
(120, 'Js update', 13, 0, 0, 0, 1307204953, 0, 1),
(119, 'test', 13, 0, 0, 117, 1307204763, 0, 1),
(121, 'create post', 13, 0, 0, 120, 1307205067, 0, 1),
(122, 'Test update', 13, 0, 0, 0, 1307205190, 0, 1),
(123, 'Test update', 13, 0, 0, 0, 1307206153, 0, 1),
(124, 'commetn', 13, 0, 0, 123, 1307206159, 0, 1),
(127, 'trial', 13, 0, 0, 0, 1307206464, 0, 1),
(125, 'comm', 13, 0, 0, 123, 1307206205, 0, 1),
(126, 'Check what out!', 2, 0, 0, 93, 1307206281, 0, 0),
(128, 'commsnt', 13, 0, 0, 127, 1307206470, 0, 1),
(129, 'hey', 13, 0, 0, 0, 1307206683, 0, 1),
(130, 'hey there', 13, 0, 0, 129, 1307206690, 0, 1),
(131, 'commet', 13, 0, 0, 103, 1307207065, 0, 1),
(139, 'thrifty comment', 13, 0, 0, 103, 1307208316, 0, 1),
(134, 'new comment', 13, 0, 0, 103, 1307207446, 0, 1),
(135, 'third comment', 13, 0, 0, 103, 1307207820, 0, 1),
(136, 'fourth comment', 13, 0, 0, 103, 1307207913, 0, 1),
(137, 'commetn', 13, 0, 0, 103, 1307208171, 0, 1),
(138, 'comments', 13, 0, 0, 103, 1307208189, 0, 1),
(140, 'please an update', 13, 0, 0, 0, 1307208333, 0, 1),
(141, 'updates', 13, 0, 0, 0, 1307208526, 0, 1),
(142, 'hooraah', 13, 0, 0, 0, 1307208943, 0, 1),
(143, 'here we go', 13, 0, 0, 0, 1307209109, 0, 1),
(144, 'update', 13, 0, 0, 0, 1307209139, 0, 1),
(145, 'test update', 13, 0, 0, 0, 1307209441, 0, 1),
(146, 'Making an update from my phone. good stuff!', 2, 0, 0, 0, 1307209447, 0, 0),
(147, 'test updaet', 13, 0, 0, 0, 1307209573, 0, 1),
(148, 'Send a up date\n', 13, 0, 0, 0, 1307210244, 0, 0),
(149, 'creted the menu area.. woohoo', 13, 0, 0, 0, 1307281526, 0, 0),
(150, 'ret', 13, 0, 0, 0, 1307281638, 0, 1),
(151, 'man', 13, 0, 0, 0, 1307281841, 0, 1),
(152, 'another comment', 13, 0, 0, 93, 1307282302, 0, 1),
(153, 'trial', 13, 0, 0, 93, 1307282327, 0, 0),
(154, 'fourth', 13, 0, 0, 93, 1307282668, 0, 0),
(155, 'play', 13, 0, 0, 93, 1307282689, 0, 0),
(156, 'fifth', 2, 0, 0, 93, 1307282792, 0, 1),
(157, 'plan seven', 13, 0, 0, 93, 1307283254, 0, 0),
(158, 'step', 13, 0, 0, 85, 1307283600, 0, 1),
(159, 'mooooooore', 13, 0, 0, 85, 1307283804, 0, 0),
(160, 'testing updates!', 2, 0, 0, 0, 1307287502, 3, 0),
(161, 'the css is coming along quite well', 13, 0, 0, 0, 1307289178, 0, 1),
(162, 'Loving the new UI...Green, the color of weed and nature, rocks!', 24, 0, 0, 0, 1307334630, 0, 0),
(163, 'testing updates', 13, 0, 0, 0, 1307354979, 0, 1),
(164, 'comment', 13, 0, 0, 163, 1307354998, 0, 1),
(165, 'commenting!', 2, 0, 0, 93, 1307357631, 0, 1),
(166, 'I''m trying to avoid the redirects on the mobile browser. let''s see if it works!', 2, 0, 0, 0, 1307361046, 1, 0),
(167, 'something''s not working but i can''t figure out what it is! maen!', 2, 0, 0, 166, 1307361882, 0, 1),
(201, 'This thing is just too tricky! still trying to figure it out.', 2, 0, 0, 166, 1307974457, 0, 0),
(168, 'it''s working right? and working like a charm!', 2, 0, 0, 160, 1307361991, 0, 1),
(169, 'HEEY you! how you been?', 2, 0, 4, 0, 1307363028, 0, 0),
(170, 'Niko bien kabisa. Je wewe?', 4, 0, 0, 169, 1307363764, 0, 1),
(172, 'testing a method that sends a POST request from BetaVersion1.0.mobileAppBeta.UkulimaMobileApp', 21, 0, 0, 0, 1307385890, 0, 0),
(171, 'Heeeeey!', 4, 0, 0, 0, 1307364691, 0, 0),
(173, 'apptest', 21, 0, 0, 172, 1307389357, 0, 1),
(174, 'app test', 21, 0, 0, 0, 1307389379, 0, 0),
(175, 'I think now I''m done with the changes to user controller. let me test and see!', 2, 0, 0, 0, 1307430104, 0, 0),
(176, 'Sorta seems like it''s working. but let me make sure!', 2, 0, 0, 175, 1307430556, 0, 1),
(202, 'niaje mose?', 21, 0, 0, 0, 1308035450, 0, 1),
(177, 'This thing looks ugly on some phones', 4, 0, 0, 0, 1307431631, 0, 0),
(178, 'Comark amesimama\n', 6, 0, 0, 0, 1307433381, 1, 0),
(179, 'Ati what?', 6, 0, 0, 178, 1307433394, 0, 0),
(180, 'Works alright?', 4, 0, 0, 160, 1307434544, 0, 0),
(181, 'is this really Phyllis Mumbua ama ni ghost yake?', 24, 0, 0, 0, 1307439578, 0, 0),
(182, 'Yeah. Like ths nokia', 4, 0, 0, 177, 1307442681, 0, 1),
(186, 'search', 21, 0, 0, 0, 1307446029, 0, 0),
(183, 'Yeah. Like ths nokia', 4, 0, 0, 177, 1307443771, 0, 1),
(184, 'Christian has seen the platform and thinks it is great. ', 6, 0, 0, 0, 1307444304, 0, 0),
(185, 'search', 21, 0, 0, 0, 1307444550, 0, 0),
(187, 'Best retirement package, four cows and a beach front', 27, 0, 0, 0, 1307538828, 0, 0),
(188, 'Site is looking great! ', 21, 0, 0, 0, 1307602368, 0, 0),
(189, 'Mimi niko poa! how about you?', 4, 0, 0, 169, 1307606958, 0, 1),
(190, 'This thing is crazy and slow.', 4, 0, 0, 0, 1307619918, 2, 0),
(191, 'I''m sure you didn''t mean that!', 2, 0, 0, 190, 1307620711, 0, 0),
(192, 'I sure did mean that!', 4, 0, 0, 190, 1307623910, 0, 0),
(193, 'you bet it does!', 2, 0, 0, 160, 1307626237, 0, 0),
(194, 'oh yes i did!', 2, 0, 0, 190, 1307628844, 0, 1),
(195, 'Good stuff! hope everything works out.', 4, 0, 0, 160, 1307693162, 0, 0),
(196, 'What about a tree logo cc Christian H.', 21, 0, 0, 0, 1307799408, 0, 0),
(197, 'mkulima ukijua watu hawalali ndio hii stuff iwork...', 19, 0, 0, 0, 1307803344, 0, 0),
(198, 'MORNING WORLD! COUNTING DOWN TO THURSDAY!', 2, 0, 0, 0, 1307945750, 0, 0),
(199, 'WHO AM I?', 2, 0, 0, 0, 1307950114, 1, 0),
(200, 'Why would you be asking that?', 3, 0, 0, 199, 1307950257, 0, 0),
(203, 'from the apu', 21, 0, 2, 0, 1308122638, 0, 1),
(204, 'niaje mose?', 21, 0, 0, 0, 1308125490, 0, 1),
(205, 'Enter your update here....', 19, 0, 0, 0, 1308210537, 0, 0),
(206, 'AJTQ', 19, 0, 0, 0, 1308210568, 0, 1),
(207, 'APP1UGMJ', 19, 0, 0, 0, 1308210881, 0, 1),
(208, 'Posting from the app emulator', 19, 0, 0, 0, 1308217355, 2, 0),
(209, 'SAMPLE', 19, 0, 0, 0, 1308226645, 0, 0),
(210, 'testing a new method implemented on the mobile application', 19, 0, 0, 0, 1308289833, 0, 0),
(211, 'TWEET', 19, 0, 0, 0, 1308299601, 0, 0),
(212, 'When was the last time you did this?', 2, 0, 0, 0, 1308328113, 0, 0),
(213, 'I likethe look of this site. Very exciting. Glad to join!', 30, 0, 0, 0, 1308328564, 0, 0),
(214, 'Sawa msee! Naona una ji jazz hapo! By the way how are you getting notifications?', 4, 0, 0, 208, 1308343667, 0, 0),
(215, 'bzzzzz\n', 21, 0, 0, 0, 1308345721, 0, 0),
(216, 'Are we still here ninjas? it''s 1.20 am', 19, 0, 0, 0, 1308349004, 0, 0),
(217, 'Now its 3:08 AM and I''m the last one standing\n', 13, 0, 0, 0, 1308355714, 0, 0),
(218, 'Lol! i zoomed out at around 2.30am... but am back...', 19, 0, 4, 0, 1308378610, 0, 0),
(219, 'thats is what i am working on right now', 19, 0, 0, 208, 1308378726, 0, 0),
(220, 'So you guys want to rival what i''m trying to do huh! All the best with that. It''s war from now on!', 32, 0, 0, 0, 1308380919, 1, 0),
(221, 'what interest do u have with farmers.... your interest was only in college kids', 19, 0, 0, 220, 1308384478, 0, 0),
(222, 'First input', 13, 0, 0, 0, 1308394735, 0, 1),
(223, 'comment one', 13, 0, 0, 222, 1308394746, 0, 1),
(224, 'Monday, monday monday ooooh!', 21, 0, 0, 0, 1308550882, 0, 0),
(225, 'Don''t freak out Moz. Just a comment :)', 21, 0, 0, 199, 1308553178, 0, 0),
(226, 'Wall post PAP!', 21, 0, 2, 0, 1308565165, 0, 0),
(227, 'hjbfdsjfkjdfdsfj7777', 19, 0, 0, 0, 1308566946, 0, 1),
(228, 'Dying minutes in the game', 19, 0, 0, 0, 1308572511, 8, 0),
(229, 'Evans. Manze unanitafuta jo! ', 33, 0, 0, 228, 1308576217, 0, 0),
(230, 'my first update', 28, 0, 0, 0, 1308577086, 0, 0),
(231, 'my first update test', 39, 0, 0, 0, 1308577879, 0, 0),
(232, '<.................>', 21, 0, 0, 0, 1308578418, 0, 0),
(233, 'hey', 13, 0, 0, 228, 1308578461, 0, 0),
(234, 'testing 1,2', 43, 0, 0, 0, 1308578625, 0, 0),
(235, 'low\nlow', 33, 0, 0, 228, 1308578738, 0, 0),
(236, 'okay\n', 21, 0, 4, 0, 1308578904, 0, 1),
(237, 'Niaje jo! Tuko connected jo! Ile plot niaje?', 21, 0, 33, 0, 1308579209, 2, 0),
(238, 'Dun is almost leaving the office', 48, 0, 0, 0, 1308579301, 0, 0),
(239, 'Plot gani. Unikula food yangu alafu unataka plot? Kwanza leta pesa ndio nikusamehe.', 33, 0, 0, 237, 1308579664, 0, 0),
(240, 'I can''t connect to anyone\n', 43, 0, 0, 0, 1308580568, 0, 0),
(241, 'Zoooooom!', 21, 0, 0, 0, 1308580604, 0, 0),
(242, 'kumbe ni nyinyi mlisosi food yangu? eh! nitawapata ', 19, 0, 0, 237, 1308587096, 0, 0),
(243, 'tuwe wapole... thika road is not yet complete', 19, 0, 0, 228, 1308587115, 0, 0),
(244, 'Hii wall iko empty imebidi niichafue', 2, 0, 33, 0, 1308587660, 0, 0),
(245, 'From my phone', 13, 0, 0, 228, 1308598810, 0, 0),
(246, 'And now i''m heaed to that road...', 2, 0, 0, 228, 1308633117, 0, 0),
(247, 'Moz, it''s headed not heaed', 19, 0, 0, 228, 1308643150, 0, 0),
(248, '#toklezea', 21, 0, 0, 0, 1308648949, 1, 0),
(249, 'hii update ni Brayo ame-make.. #nowBack2You', 21, 0, 0, 248, 1308649687, 0, 0),
(250, 'windek', 43, 0, 0, 0, 1308661297, 0, 0),
(251, 'follow me', 28, 0, 0, 0, 1308661665, 1, 0),
(252, 'Tweetdeck for Windows...', 19, 0, 0, 251, 1308681168, 0, 1),
(253, 'follow me first.. wacha siasa ndogo ndogo Tom.. kama zile za mobipay..', 19, 0, 0, 251, 1308681203, 0, 0),
(254, 'blame the matatu!', 2, 0, 0, 228, 1308733516, 0, 0),
(255, 'kwani watu waliacha ku update?', 2, 0, 0, 0, 1308733581, 1, 0),
(256, 'ku update tuna update... wewe huzioni?', 19, 0, 0, 255, 1308733901, 0, 0),
(257, '..................................................', 19, 0, 0, 0, 1308770477, 0, 0),
(258, 'Enter your update here....', 19, 0, 0, 0, 1308835064, 0, 1),
(259, 'Enter your update here....', 19, 0, 0, 0, 1308835074, 0, 1),
(260, 'I can''t update i think', 13, 0, 0, 251, 1308903312, 0, 1),
(261, 'Jmgtjg', 19, 0, 0, 0, 1308909039, 0, 0),
(262, 'I''m posting from my Samsung s5620 Monte!', 2, 0, 0, 0, 1308909111, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_content`
--

CREATE TABLE IF NOT EXISTS `user_content` (
  `ID` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `tagsid` int(11) NOT NULL,
  `pageviews` int(11) NOT NULL,
  `file` varchar(250) NOT NULL,
  `filetype` varchar(5) NOT NULL,
  `date` int(12) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_content`
--

