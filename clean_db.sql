# ************************************************************
# Sequel Pro SQL dump
# Version 3348
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.9)
# Database: xgamings_connactiv
# Generation Time: 2011-12-01 04:10:55 -0500
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activities`;

CREATE TABLE `activities` (
  `ACTIVITY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVITY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ACTIVITY_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `activities` (`ACTIVITY_ID`, `ACTIVITY_NAME`) VALUES
(1, 'Running');

# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  `COMMENT` varchar(4000) NOT NULL,
  `COMMENT_DATE` date NOT NULL,
  PRIMARY KEY (`COMMENT_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



# Dump of table connaction_attending
# ------------------------------------------------------------

DROP TABLE IF EXISTS `connaction_attending`;

CREATE TABLE `connaction_attending` (
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  PRIMARY KEY (`CONNACTION_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table connaction_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `connaction_requests`;

CREATE TABLE `connaction_requests` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `APPROVED` int(11) DEFAULT '-1',
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HIDDEN_FOR_FROM` int(1) NOT NULL DEFAULT '0',
  `HIDDEN_FOR_TO` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FROM_USER`,`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `connaction_requests` (`FROM_USER`, `TO_USER`, `CONNACTION_ID`, `MESSAGE`, `APPROVED`, `DATE`, `HIDDEN_FOR_FROM`, `HIDDEN_FOR_TO`) VALUES
(1, 2, 1, 'I would like to come!', -1, '2011-11-29 01:49:02', 0, 0);

# Dump of table connactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `connactions`;

CREATE TABLE `connactions` (
  `CONNACTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_TIME` date NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOCATION` varchar(255) NOT NULL,
  `START_TIME` datetime DEFAULT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `END_TIME` datetime DEFAULT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  `IS_PRIVATE` int(11) DEFAULT '0',
  PRIMARY KEY (`CONNACTION_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
INSERT INTO `connactions` (`CONNACTION_ID`, `POST_TIME`, `USER_ID`, `LOCATION`, `START_TIME`, `MESSAGE`, `END_TIME`, `UNIQUE_NETWORK_ID`, `IS_PRIVATE`) VALUES
(1, '2011-11-30', 1, 'Example Connaction', '2011-11-28 10:00:00', 'Example Connaction', '2011-11-28 11:00:00', 1, 0);

# Dump of table event_attending
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event_attending`;

CREATE TABLE `event_attending` (
  `EVENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  PRIMARY KEY (`EVENT_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `EVENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) NOT NULL,
  `START` datetime DEFAULT NULL,
  `END` datetime DEFAULT NULL,
  `LOCATION` varchar(20) DEFAULT NULL,
  `RECURRENCE` int(11) DEFAULT NULL,
  `APPROVED` int(1) DEFAULT '-1',
  `REQUEST_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`EVENT_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



# Dump of table favorites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `favorites`;

CREATE TABLE `favorites` (
  `USER_ID` int(11) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`UNIQUE_NETWORK_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table friend_requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `friend_requests`;

CREATE TABLE `friend_requests` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `IS_ACTIVE` int(11) DEFAULT '-1',
  PRIMARY KEY (`FROM_USER`,`TO_USER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table friends
# ------------------------------------------------------------

DROP TABLE IF EXISTS `friends`;

CREATE TABLE `friends` (
  `USER1` int(11) NOT NULL,
  `USER2` int(11) NOT NULL,
  PRIMARY KEY (`USER1`,`USER2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `SUBJECT` varchar(100) DEFAULT NULL,
  `BODY` varchar(4000) DEFAULT NULL,
  `DATE` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FROM_USER`,`TO_USER`,`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `messages` (`FROM_USER`, `TO_USER`, `SUBJECT`, `BODY`, `DATE`) VALUES
(1, 2, 'Example Message', 'Welcome to Connactiv', '2011-11-30 14:12:23'),
(2, 1, 'Example Message', 'Welcome to Connactiv', '2011-11-30 14:12:23');

# Dump of table networks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `networks`;

CREATE TABLE `networks` (
  `NETWORK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `AREA` varchar(25) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  PRIMARY KEY (`NETWORK_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `networks` (`NETWORK_ID`, `AREA`, `STATE`) VALUES
(1, 'Pittsburgh', 'PA');

# Dump of table preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences` (
  `USER_ID` int(11) NOT NULL,
  `SECURITY` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `USER_ID` int(11) NOT NULL,
  `FROM_USER` int(11) NOT NULL,
  `IS_ANONYMOUS` int(11) DEFAULT '0',
  `CONNACTION_ID` int(11) NOT NULL,
  `IS_POSITIVE` int(11) DEFAULT NULL,
  `REVIEW_DATE` date DEFAULT NULL,
  `REVIEW` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`FROM_USER`,`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `reviews` (`USER_ID`, `FROM_USER`, `IS_ANONYMOUS`, `CONNACTION_ID`, `IS_POSITIVE`, `REVIEW_DATE`, `REVIEW`) VALUES
(2, 1, 0, 1, 1, '2011-11-30', 'I had a great time at this connaction');

# Dump of table unique_networks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unique_networks`;

CREATE TABLE `unique_networks` (
  `UNIQUE_NETWORK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NETWORK_ID` int(11) DEFAULT NULL,
  `ACTIVITY_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`UNIQUE_NETWORK_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

INSERT INTO `unique_networks` (`UNIQUE_NETWORK_ID`, `NETWORK_ID`, `ACTIVITY_ID`) VALUES
(1, 1, 1);

# Dump of table user_activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_activities`;

CREATE TABLE `user_activities` (
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `LOW_LEVEL` int(11) DEFAULT NULL,
  `HIGH_LEVEL` int(11) DEFAULT NULL,
  `PREFERRED` int(11) DEFAULT NULL,
  `OWN_LEVEL` int(11) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `user_activities` (`USER_ID`, `ACTIVITY_ID`, `LOW_LEVEL`, `HIGH_LEVEL`, `PREFERRED`, `OWN_LEVEL`) VALUES
(2,1, 6, 9, 8, 8);

# Dump of table user_networks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_networks`;

CREATE TABLE `user_networks` (
  `USER_ID` int(11) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`UNIQUE_NETWORK_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `user_networks` (`USER_ID`, `UNIQUE_NETWORK_ID`) VALUES
(2, 1);

# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PASSWORD` varchar(100) NOT NULL,
  `FIRST_NAME` char(20) DEFAULT NULL,
  `LAST_NAME` char(20) DEFAULT NULL,
  `STREET` varchar(25) DEFAULT NULL,
  `CITY` char(20) DEFAULT NULL,
  `STATE` char(2) DEFAULT NULL,
  `ZIP` int(11) DEFAULT NULL,
  `PHONE` char(12) DEFAULT NULL,
  `INTERESTS` varchar(4000) DEFAULT NULL,
  `PROFILE_PIC` varchar(45) NOT NULL DEFAULT '../public/images/avatar.png',
  `EMAIL` varchar(25) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `GENDER` char(1) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`USER_ID`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`, `STREET`, `CITY`, `STATE`, `ZIP`, `PHONE`, `INTERESTS`, `PROFILE_PIC`, `EMAIL`, `DOB`, `GENDER`)
VALUES
	(1,'9ae984b8b7e71ee69caf0a7b82b31b1e','','Admin','','','',NULL,'','ConnActiv administrator account','../public/images/avatar.png','admin@connactiv.com',NULL,NULL),
(2,'fcf41657f02f88137a1bcf068a32c0a3','','Guest','','','',NULL,'','ConnActiv Guest account','../public/images/avatar.png','guest@connactiv.com',NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
