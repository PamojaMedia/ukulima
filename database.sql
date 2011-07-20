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
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


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
-- Table structure for table `report_areas`
--

CREATE TABLE IF NOT EXISTS `report_areas` (
  `ID` int(11) NOT NULL auto_increment,
  `contentarea` smallint(2) NOT NULL,
  `enabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



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
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `ID` int(11) NOT NULL,
  `tagnameid` int(11) NOT NULL,
  PRIMARY KEY  (`ID`,`tagnameid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Table structure for table `tag_names`
--

CREATE TABLE IF NOT EXISTS `tag_names` (
  `ID` int(11) NOT NULL default '0',
  `name` varchar(15) character set utf8 NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


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

