-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2011 at 01:34 AM
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
CREATE DATABASE `mobiproj_rfmobileproject` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mobiproj_rfmobileproject`;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

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
(8, 13, 5, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`ID`, `userid_1`, `userid_2`, `followstatus`) VALUES
(1, 13, 2, 1),
(2, 13, 3, 1),
(3, 2, 4, 1),
(4, 2, 3, 1),
(5, 2, 13, 1),
(6, 13, 5, 1),
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
(17, 13, 20, 1);

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
-- Table structure for table `message_receivers`
--

CREATE TABLE IF NOT EXISTS `message_receivers` (
  `ID` int(11) NOT NULL auto_increment,
  `msgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `deleted` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `message_receivers`
--

INSERT INTO `message_receivers` (`ID`, `msgid`, `userid`, `deleted`) VALUES
(1, 1, 3, 0),
(2, 1, 4, 0),
(3, 1, 2, 0),
(4, 2, 3, 0),
(5, 2, 4, 0),
(6, 2, 2, 0),
(7, 3, 3, 0),
(8, 3, 4, 0),
(9, 3, 2, 0),
(10, 4, 2, 0),
(11, 4, 4, 0),
(12, 4, 13, 0),
(13, 5, 2, 0),
(14, 5, 4, 0),
(15, 5, 13, 0),
(16, 6, 2, 0),
(17, 6, 13, 0),
(18, 7, 5, 0),
(19, 7, 13, 0),
(20, 8, 2, 0),
(21, 8, 13, 0),
(22, 9, 2, 0),
(23, 9, 13, 0),
(24, 10, 2, 0),
(25, 10, 13, 0),
(26, 11, 2, 0),
(27, 11, 4, 0),
(28, 11, 13, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

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
(11, 'test message', 'create', 13, 0, 1302527517);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `notifications`
--


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
  `city` varchar(20) character set utf8 NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`userid`, `username`, `firstname`, `lastname`, `country`, `city`, `email`, `phonenum`, `avatar`, `password`, `flagstatus`, `userstatus`, `activation_code`, `ip_address`, `forgotten_password_code`) VALUES
(14, 'dane', 'Jane', 'Dane', '', '', 'dane@domain.com', '', '', '2c5650b7a0cf0032160b15837b67ba106d4b4d88', 0, 0, '', '41.212.124.131', ''),
(18, 'Amasy', 'ama', 'sy', '', '', 'amasy@test.com', '', '', '455cb744eabaddb5dc618040e109950d130395af', 0, 0, '7a0fb9ab0f94c72ff0e7293205afd3768d401a72', '41.72.207.150', ''),
(2, 'mozey', 'Moses', 'Mutuku', '', '', 'mozesmutuku@yahoo.com', '', '', '05f079b4e8fd025a4593213ef2892fa769c749e6', 0, 0, '', '41.212.101.35', '9995d08c017d6bc77afea20e66189e9f1cf205b1'),
(3, 'knzau', 'Ken', 'Nzau', '', '', 'domain@invalidomain.com', '', '', 'ead0e8374dffd7872919616eac62c6f869addd08', 0, 0, '', '41.212.101.35', ''),
(4, 'mumbua', 'Phyllis', 'Mumbua', '', '', 'mumbua@invalidomain.com', '', '', 'c1d641532b2307f0e12648b013fa5d8b0ce235c9', 0, 0, '', '41.212.101.35', ''),
(5, 'mungei', 'Brian', 'Mungei', '', '', 'mungei@invalidomain.com', '', '', '7aa65d43a72b7ea9b7dfda80573b40bb5ee7cf26', 0, 0, '', '41.212.101.35', ''),
(6, 'joshua', 'Joshua', 'Wanyama', '', '', 'joshua@invalidomain.com', '', '', 'e669b06014a90d648353dc232da094e293ce3a42', 0, 0, '', '41.212.101.35', ''),
(13, 'comark', 'comark', 'onani', '', '', 'comark@pamojamedia.com', '', '', '5d012517933f3b5bad9dd3b41c2cadb6fab055be', 0, 0, '', '41.212.124.236', ''),
(17, 'johndoe', 'john', 'doe', '', '', 'johndoe@domain.com', '', '', 'edfb5b70898dede3e1742d046c32b2465c2ad698', 0, 0, '6aa2cfc740c1b02f13432331a7edd1c49bcc28f0', '41.212.124.131', ''),
(19, 'testAcc', 'evans', 'gikunda', '', '', 'officialevans@gmail.com', '', '', 'b363f82f0ac383d83f9289edeec1c357aa3d72a0', 0, 0, '', '41.72.207.150', ''),
(20, 'Amasy2011', 'Evans', 'Giks', '', '', 'easally@gmail.com', '', '', '3b9b226e156a440406761c7d4d13216906f387ae', 0, 0, '', '41.212.101.6', ''),
(21, 'Ishuah', 'Ishuah', 'Kariuki', '', '', 'ishuah91@gmail.com', '', '', '7c3eae5dfd9d7a3e90ca62c0c3a7cae4f8aecb6e', 0, 0, '', '41.212.101.47', '');

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
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`ID`, `update`, `userid`, `tagsid`, `ownersid`, `parentid`, `date`, `deleted`) VALUES
(1, 'This is my very first update. I''m going to love this project.', 2, 1, 0, 0, 1298447018, 0),
(2, 'Weuwe! My updates are working. You know...later when people see these updates. They''ll just know I was the one who was programming it.\n#Cheapthrills', 2, 0, 0, 0, 1298447518, 0),
(3, 'WOOP WOOP WOOP WOOP!', 2, 0, 0, 0, 1298447531, 0),
(4, 'Let me try this update and see if it works.', 2, 0, 0, 0, 1298465096, 0),
(5, 'Let me see if the updates are still working.', 2, 0, 0, 0, 1298467151, 0),
(6, 'So how far have you gone?', 2, 0, 0, 1, 1298470541, 0),
(7, 'So how is it going so far?', 2, 0, 0, 5, 1298539770, 0),
(8, 'Wow! Now we can do updates and they appear right in the page without having to refresh the page.', 2, 0, 0, 0, 1298882128, 0),
(9, 'OK! For some reason that last one did not use ajax. let''s see if it will work now.', 2, 0, 0, 0, 1298882175, 0),
(10, 'Why...oh why oh why', 2, 0, 0, 0, 1298882327, 0),
(11, 'Just work maen!', 2, 0, 0, 0, 1298882553, 0),
(12, 'Really. Why you not working?', 2, 0, 0, 0, 1298882777, 0),
(13, 'Why oh why....', 2, 0, 0, 0, 1298883356, 0),
(14, 'Now you have updated. Ebu please work.', 2, 0, 0, 0, 1298883972, 0),
(15, 'Now i''m sure you have picked the css also. Let''s see you do the update maen.', 2, 0, 0, 0, 1298884093, 0),
(16, 'Now, now asin now, not the last time. I know you have the css.', 2, 0, 0, 0, 1298884253, 0),
(17, 'Welllllla! Hope you are working now.', 2, 0, 0, 0, 1298885547, 0),
(18, 'Let''s see if it is working on chrome also!', 2, 0, 0, 0, 1298888608, 0),
(19, 'Tweet tweet tweet!', 2, 0, 0, 18, 1298891555, 0),
(20, 'Hi! Testing how it works without javascript.', 2, 0, 0, 0, 1298891641, 0),
(21, 'Does it still work without javascript?', 2, 0, 0, 0, 1298891661, 0),
(22, 'Sweet! What about comments?', 2, 0, 0, 21, 1298891678, 0),
(23, 'Comments comments comments right here.', 2, 0, 0, 21, 1298891849, 0),
(24, 'All this psyche is from some recent acquired images.', 2, 0, 0, 0, 1298893403, 0),
(25, 'Really? Does it work without javascript.', 2, 0, 0, 21, 1298893437, 0),
(26, 'Let''s see if this thing is working online also.', 2, 0, 0, 0, 1298898601, 0),
(27, 'Let''s see if it is working now.', 2, 0, 0, 0, 1298898631, 0),
(28, 'Now, next level', 2, 0, 0, 0, 1298898767, 0),
(29, 'checking it out again.', 2, 0, 0, 0, 1298899522, 0),
(30, 'Testing updates on IE', 2, 0, 0, 0, 1298899642, 0),
(31, 'Comments also.', 2, 0, 0, 29, 1298899666, 0),
(32, 'test update', 9, 0, 0, 0, 1298899846, 0),
(33, 'multiple updates', 9, 0, 0, 0, 1298899858, 0),
(34, 'a new comment', 9, 0, 0, 33, 1298899917, 0),
(35, 'Let''s check it internally', 2, 0, 0, 28, 1298908380, 0),
(36, 'Let''s see how you work online now :-)\nHello dear brother :-)', 2, 0, 0, 0, 1299130291, 0),
(37, 'Na comments?', 2, 0, 0, 30, 1299130313, 0),
(38, 'Sweet!', 2, 0, 0, 30, 1299130323, 0),
(39, 'Testing failure...', 2, 0, 0, 30, 1299130359, 0),
(40, 'The failure bit works also.', 2, 0, 0, 30, 1299130371, 0),
(41, 'Good stuff. The viewing specific comments bit is also working.', 2, 0, 0, 30, 1299130441, 0),
(42, 'Check this out!', 2, 0, 0, 0, 1299218833, 0),
(43, 'Testing posting again.', 2, 0, 0, 0, 1299219099, 0),
(44, 'Testing comments...', 2, 0, 0, 43, 1299219110, 1),
(45, 'So, why can''t i delete...', 2, 0, 0, 43, 1299219122, 1),
(46, 'New new new update :-)', 2, 0, 0, 0, 1299219399, 1),
(47, 'And it''s comments right here :-)', 2, 0, 0, 46, 1299219417, 1),
(48, 'Sweet! Deletion done.', 2, 0, 0, 0, 1299219460, 0),
(49, 'Checking this out for like the last time.', 2, 0, 0, 0, 1299240170, 0),
(50, 'Woop woop! It''s working like great.', 2, 0, 0, 0, 1299240189, 0),
(51, 'Now check this out!', 2, 0, 0, 50, 1299240213, 0),
(52, 'Yey! It''s working.', 2, 0, 0, 50, 1299240224, 1),
(53, 'Darn slow internets.', 2, 0, 0, 50, 1299240263, 0),
(54, 'Hello there!', 2, 0, 0, 0, 1299837820, 1),
(55, 'It''s a new week. I hope it will work out great!', 2, 0, 0, 0, 1300087106, 0),
(56, 'hello world', 13, 0, 0, 0, 1300371700, 1),
(57, 'test', 13, 0, 0, 0, 1300371850, 1),
(58, 'another one', 13, 0, 0, 0, 1300371914, 1),
(59, 'Test post', 2, 0, 0, 0, 1300372059, 0),
(60, 'new update', 13, 0, 0, 0, 1300372180, 1),
(61, 'test', 13, 0, 0, 0, 1300383434, 1),
(62, 'another', 13, 0, 0, 0, 1300383445, 1),
(63, 'here', 13, 0, 0, 0, 1300383874, 1),
(64, 'test', 13, 0, 0, 0, 1300467235, 1),
(65, 'test', 13, 0, 0, 0, 1300684919, 1),
(66, 'another post', 13, 0, 0, 0, 1300685543, 1),
(67, 'another\n', 13, 0, 0, 0, 1300685550, 1),
(68, 'test', 13, 0, 0, 0, 1300688779, 1),
(69, 'test comarkl', 13, 0, 0, 0, 1300714018, 1),
(70, 'test', 13, 0, 0, 0, 1300714822, 1),
(71, 'I am sitting here with some clever people. Wasininyonye damu!!!!!', 14, 0, 0, 0, 1300718088, 0),
(72, 'Tom is slowly understanding what is going on...\nSlowly', 14, 0, 0, 0, 1300718118, 0),
(73, 'slowly', 14, 0, 0, 0, 1300718173, 0),
(74, 'test comment\n', 13, 0, 0, 59, 1301285663, 0),
(75, 'send this one also', 13, 0, 0, 0, 1301286670, 1),
(76, 'java update', 13, 0, 0, 0, 1301303948, 1),
(77, 'share', 13, 0, 0, 0, 1301492613, 1),
(78, 'share again', 13, 0, 0, 0, 1301493220, 0),
(79, 'first test update', 19, 0, 0, 0, 1302795853, 0);

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

