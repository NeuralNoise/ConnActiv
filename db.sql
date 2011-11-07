-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2011 at 03:08 PM
-- Server version: 5.1.58
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xgamings_connactiv`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACTIVITIES`
--

CREATE TABLE IF NOT EXISTS `ACTIVITIES` (
  `ACTIVITY_ID` int(11) NOT NULL,
  `ACTIVITY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
INSERT INTO ACTIVITIES VALUES(1, 'Baseball');
INSERT INTO ACTIVITIES VALUES(2, 'Swimming');
INSERT INTO ACTIVITIES VALUES(3, 'Running');

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `UNIQUE_NETWORKS` (
	`UNIQUE_NETWORK_ID` int(11) NOT NULL,
	`ACTIVITY_ID` int(11),
	`NETWORK_ID` int(11),
	PRIMARY KEY (`UNIQUE_NETWORK_ID`)
)ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO UNIQUE_NETWORKS VALUES(1,1,1);
INSERT INTO UNIQUE_NETWORKS VALUES(2,1,2);
INSERT INTO UNIQUE_NETWORKS VALUES(3,1,3);
INSERT INTO UNIQUE_NETWORKS VALUES(4,2,1);
INSERT INTO UNIQUE_NETWORKS VALUES(5,2,2);
INSERT INTO UNIQUE_NETWORKS VALUES(6,2,3);
--
-- Table structure for table `COMMENTS`
--

CREATE TABLE IF NOT EXISTS `COMMENTS` (
  `COMMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  `COMMENT` varchar(4000) NOT NULL,
  `COMMENT_DATE` date NOT NULL,
  PRIMARY KEY (`COMMENT_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO COMMENTS VALUES(1, 1, 1, `Its too cold to go running`, CURRDATE());
INSERT INTO COMMENTS VALUES(2, 2, 1, `Oh well, suit yourself pussy`, CURRDATE());

-- --------------------------------------------------------

--
-- Table structure for table `CONNACTIONS`
--

CREATE TABLE IF NOT EXISTS `CONNACTIONS` (
  `CONNACTION_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOCATION` varchar(255) NOT NULL,
  `START_TIME` date DEFAULT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `END_TIME` date DEFAULT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `NETWORK_ID` int(11) NOT NULL,
  'IS_PRIVATE' int(11) DEFAULT 0,
  PRIMARY KEY (`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO CONNACTIONS VALUES(1, 1, `Oakland (atwood and bates)`, CURDATE(), `Come Running with me!`, CURDATE(), 3, 1);
-- --------------------------------------------------------

--
-- Table structure for table `CONNACTION_ATTENDING`
--

CREATE TABLE IF NOT EXISTS `CONNACTION_ATTENDING` (
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  PRIMARY KEY (`CONNACTION_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO CONNACTION_ATTENDING VALUES(1,1);
-- --------------------------------------------------------

--
-- Table structure for table `EVENTS`
--

CREATE TABLE IF NOT EXISTS `EVENTS` (
  `EVENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `NETWORK_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) NOT NULL,
  `START_DATE` date DEFAULT NULL,
  `END_DATE` date DEFAULT NULL,
  `LOCATION` varchar(20) DEFAULT NULL,
  `RECURRENCE` int(11) DEFAULT NULL,
  PRIMARY KEY (`EVENT_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EVENT_ATTENDING`
--

CREATE TABLE IF NOT EXISTS `EVENT_ATTENDING` (
  `EVENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  PRIMARY KEY (`EVENT_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `FAVORITES`
--

CREATE TABLE IF NOT EXISTS `FAVORITES` (
  `USER_ID` int(11) NOT NULL,
  `NETWORK_ID` int(11),
  `ACTVITIY_ID` int(11),
  PRIMARY KEY (`USER_ID`,`NETWORK_ID`, 'ACTIVITY_ID')
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO FAVORITES VALUES(1,1,1);
INSERT INTO FAVORITES VALUES(1,1,2);
-- --------------------------------------------------------

--


--
-- Table structure for table `FRIENDS`
--

CREATE TABLE IF NOT EXISTS `FRIENDS` (
  `USER_ID` int(11) NOT NULL,
  `FRIEND_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`FRIEND_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO FRIENDS VALUES(1,2);
INSERT INTO FRIENDS VALUES(2,1);


-- --------------------------------------------------------

--
-- Table structure for table `FRIEND_REQUESTS`
--

CREATE TABLE IF NOT EXISTS `FRIEND_REQUESTS` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `IS_ACTIVE` int(11) DEFAULT 1,
  PRIMARY KEY (`FROM_USER`,`TO_USER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGES`
--

CREATE TABLE IF NOT EXISTS `MESSAGES` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `SUBJECT` varchar(100) DEFAULT NULL,
  `BODY` varchar(4000) DEFAULT NULL,
  `DATE` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`FROM_USER`,`TO_USER`,`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO MESSAGES VALUES(1,2,`Running Tomorrow`, `Lets go running around 4pm...`, CURDATE());
-- --------------------------------------------------------

--
-- Table structure for table `NETWORKS`
--

CREATE TABLE IF NOT EXISTS `NETWORKS` (
  `NETWORK_ID` int(11) NOT NULL,
  `AREA` varchar(25) NOT NULL,
  PRIMARY KEY (`NETWORK_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO NETWORKS VALUES (1, 'Oakland');
INSERT INTO NETWORKS VALUES (2, 'Pittsburgh');
-- --------------------------------------------------------

--

--
-- Table structure for table `PREFERENCES`
--

CREATE TABLE IF NOT EXISTS `PREFERENCES` (
  `USER_ID` int(11) NOT NULL,
  `SECURITY` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO PREFERENCES VALUES(1, 0);
-- --------------------------------------------------------

--
-- Table structure for table `REQUESTS`
--

CREATE TABLE IF NOT EXISTS `CONNACTION_REQUESTS` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `CONACTION_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `APPROVED` int(11) DEFAULT 0,
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `REVIEWS`
--

CREATE TABLE IF NOT EXISTS `REVIEWS` (
  `USER_ID` int(11) NOT NULL,
  `FROM_USER` int(11) NOT NULL,
  `IS_ANONYMOUS` int(11) DEFAULT 0,
  `CONNACTION_ID` int(11) NOT NULL,
  `IS_POSITIVE` int(11) DEFAULT NULL,
  `REVIEW_DATE` date DEFAULT NULL,
  `REVIEW` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`,`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `USER_ID` int(11) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `FIRST_NAME` char(20) DEFAULT NULL,
  `LAST_NAME` char(20) DEFAULT NULL,
  `STREET` varchar(25) DEFAULT NULL,
  `CITY` char(20) DEFAULT NULL,
  `STATE` char(2) DEFAULT NULL,
  `ZIP` int(11) DEFAULT NULL,
  `PHONE` char(12) DEFAULT NULL,
  `INTERESTS` varchar(4000) DEFAULT NULL,
  `PROFILE_PIC` varchar(45) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`USER_ID`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`, `STREET`, `CITY`, `STATE`, `ZIP`, `PHONE`, `INTERESTS`, `PROFILE_PIC`, `email`) VALUES
(1, '8f53e82e508c96115551317048cba97e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'flippi273@gmail.com'),
(2, 'e46087d5106e99a7bfe8f4bee9ed8aee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mxpxpunk7789@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `USER_ACTIVITIES`
--

CREATE TABLE IF NOT EXISTS `USER_ACTIVITIES` (
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `LOW_LEVEL` int(11) DEFAULT NULL,
  `HIGH_LEVEL` int(11) DEFAULT NULL,
  `PREFERRED` int(11) DEFAULT NULL,
  `OWN_LEVEL` int(11) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO USER_ACTIVITIES VALUES(1,3,2,5,3,3);
INSERT INTO USER_ACTIVITIES VALUES(2,3,2,5,4,4);
-- --------------------------------------------------------

--
-- Table structure for table `USER_NETWORKS`
--

CREATE TABLE IF NOT EXISTS `USER_NETWORKS` (
  `USER_ID` int(11) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`NETWORK_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO USER_NETWORKS VALUES(1,1);
INSERT INTO USER_NETWORKS VALUES(2,1);
-- --------------------------------------------------------



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
