-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mitmunc
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postDate` date NOT NULL,
  `announcement` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ccmatrix`
--

DROP TABLE IF EXISTS `ccmatrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ccmatrix` (
  `countryId` int(11) NOT NULL,
  `1` tinyint(1) NOT NULL,
  `2` tinyint(1) NOT NULL,
  `8` tinyint(1) NOT NULL,
  `10` tinyint(1) NOT NULL,
  `3` tinyint(1) NOT NULL,
  `11` tinyint(1) NOT NULL,
  `4` tinyint(1) NOT NULL,
  `5` tinyint(1) NOT NULL,
  `9` tinyint(1) NOT NULL,
  `6` tinyint(1) NOT NULL,
  `7` tinyint(1) NOT NULL,
  `13` tinyint(1) NOT NULL,
  `15` tinyint(1) NOT NULL,
  UNIQUE KEY `countryId` (`countryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ccmatrix`
--

LOCK TABLES `ccmatrix` WRITE;
/*!40000 ALTER TABLE `ccmatrix` DISABLE KEYS */;
/*!40000 ALTER TABLE `ccmatrix` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `committees`
--

DROP TABLE IF EXISTS `committees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `committees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `shortName` varchar(50) NOT NULL,
  `announcement` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `topic1` varchar(256) NOT NULL,
  `topic1Description` text NOT NULL,
  `topic1Bg` varchar(100) NOT NULL,
  `topic2` varchar(256) NOT NULL,
  `topic2Description` text NOT NULL,
  `topic2Bg` varchar(100) NOT NULL,
  `topic3` varchar(256) NOT NULL,
  `topic3Description` text NOT NULL,
  `topic3Bg` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shortname` (`shortName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `committees`
--

LOCK TABLES `committees` WRITE;
/*!40000 ALTER TABLE `committees` DISABLE KEYS */;
/*!40000 ALTER TABLE `committees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) NOT NULL,
  `showInMatrix` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (250,'',0),(1,'Afghanistan',1),(2,'Albania',1),(4,'Algeria',1),(6,'Andorra',1),(7,'Angola',1),(10,'Antigua and Barbuda',1),(11,'Argentina',1),(12,'Armenia',1),(14,'Australia',1),(15,'Austria',1),(16,'Azerbaijan',1),(17,'Bahamas',1),(18,'Bahrain',1),(19,'Bangladesh',1),(20,'Barbados',1),(21,'Belarus',1),(22,'Belgium',1),(23,'Belize',1),(24,'Benin',1),(26,'Bhutan',1),(27,'Bolivia',1),(28,'Bosnia and Herzegovina',1),(29,'Botswana',1),(31,'Brazil',1),(33,'Brunei Darussalam',1),(34,'Bulgaria',1),(35,'Burkina Faso',1),(36,'Burundi',1),(37,'Cambodia',1),(38,'Cameroon',1),(39,'Canada',1),(40,'Cape Verde',1),(42,'Central African Republic',1),(43,'Chad',1),(44,'Chile',1),(45,'China',1),(48,'Colombia',1),(49,'Comoros',1),(50,'Congo',1),(51,'DPR Congo',1),(53,'Costa Rica',1),(54,'Cote D\'Ivoire',1),(55,'Croatia',1),(56,'Cuba',1),(57,'Cyprus',1),(58,'Czech Republic',1),(59,'Denmark',1),(60,'Djibouti',1),(61,'Dominica',1),(62,'Dominican Republic',1),(63,'Ecuador',1),(64,'Egypt',1),(65,'El Salvador',1),(66,'Equatorial Guinea',1),(67,'Eritrea',1),(68,'Estonia',1),(69,'Ethiopia',1),(72,'Fiji',1),(73,'Finland',1),(74,'France',1),(78,'Gabon',1),(79,'Gambia',1),(80,'Georgia',1),(81,'Germany',1),(82,'Ghana',1),(84,'Greece',1),(86,'Grenada',1),(89,'Guatemala',1),(91,'Guinea',1),(92,'Guinea-Bissau',1),(93,'Guyana',1),(94,'Haiti',1),(96,'Holy See',1),(97,'Honduras',1),(99,'Hungary',1),(100,'Iceland',1),(101,'India',1),(102,'Indonesia',1),(103,'Iran',1),(104,'Iraq',1),(105,'Ireland',1),(107,'Israel',1),(108,'Italy',1),(109,'Jamaica',1),(110,'Japan',1),(112,'Jordan',1),(113,'Kazakhstan',1),(114,'Kenya',1),(115,'Kiribati',1),(116,'North Korea',1),(117,'South Korea',1),(118,'Kuwait',1),(119,'Kyrgyzstan',1),(120,'Laos',1),(121,'Latvia',1),(122,'Lebanon',1),(123,'Lesotho',1),(124,'Liberia',1),(125,'Libya',1),(126,'Liechtenstein',1),(127,'Lithuania',1),(128,'Luxembourg',1),(131,'Madagascar',1),(132,'Malawi',1),(133,'Malaysia',1),(134,'Maldives',1),(135,'Mali',1),(136,'Malta',1),(137,'Marshall Islands',1),(139,'Mauritania',1),(140,'Mauritius',1),(142,'Mexico',1),(143,'Micronesia',1),(145,'Monaco',1),(146,'Mongolia',1),(147,'Montenegro',1),(149,'Morocco',1),(150,'Mozambique',1),(151,'Myanmar',1),(152,'Namibia',1),(153,'Nauru',1),(154,'Nepal',1),(155,'Netherlands',1),(158,'New Zealand',1),(159,'Nicaragua',1),(160,'Niger',1),(161,'Nigeria',1),(165,'Norway',1),(166,'Oman',1),(167,'Pakistan',1),(168,'Palau',1),(170,'Panama',1),(171,'Papua New Guinea',1),(172,'Paraguay',1),(173,'Peru',1),(174,'Philippines',1),(176,'Poland',1),(177,'Portugal',1),(179,'Qatar',1),(181,'Romania',1),(182,'Russian Federation',1),(183,'Rwanda',1),(186,'Saint Kitts and Nevis',1),(187,'Saint Lucia',1),(190,'Saint Vincent and the Grenadines',1),(191,'Samoa',1),(192,'San Marino',1),(193,'Sao Tome and Principe',1),(194,'Saudi Arabia',1),(195,'Senegal',1),(196,'Serbia',1),(197,'Seychelles',1),(198,'Sierra Leone',1),(199,'Singapore',1),(200,'Slovakia',1),(201,'Slovenia',1),(202,'Solomon Islands',1),(203,'Somalia',1),(204,'South Africa',1),(206,'Spain',1),(207,'Sri Lanka',1),(208,'Sudan',1),(209,'Suriname',1),(211,'Swaziland',1),(212,'Sweden',1),(213,'Switzerland',1),(214,'Syria',1),(216,'Tajikistan',1),(217,'Tanzania',1),(218,'Thailand',1),(219,'Timor-Leste',1),(220,'Togo',1),(222,'Tonga',1),(223,'Trinidad and Tobago',1),(224,'Tunisia',1),(225,'Turkey',1),(226,'Turkmenistan',1),(228,'Tuvalu',1),(229,'Uganda',1),(230,'Ukraine',1),(231,'United Arab Emirates',1),(232,'United Kingdom',1),(233,'United States',1),(235,'Uruguay',1),(236,'Uzbekistan',1),(237,'Vanuatu',1),(238,'Venezuela',1),(239,'Viet Nam',1),(244,'Yemen',1),(245,'Zambia',1),(246,'Zimbabwe',1),(253,'South Sudan',1),(255,'Moldova',1),(256,'Macedonia',1);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accessCode` varchar(20) NOT NULL,
  `from` varchar(50) NOT NULL,
  `to` varchar(50) NOT NULL,
  `subject` varchar(300) NOT NULL,
  `timeSent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accessCode` (`accessCode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(50) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalInfo`
--

DROP TABLE IF EXISTS `generalInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalInfo` (
  `infoKey` varchar(1000) NOT NULL,
  `infoValue` varchar(1000) NOT NULL,
  UNIQUE KEY `infokey` (`infoKey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalInfo`
--

LOCK TABLES `generalInfo` WRITE;
/*!40000 ALTER TABLE `generalInfo` DISABLE KEYS */;
INSERT INTO `generalInfo` VALUES ('earlyRegDeadline',''),('regularRegDeadline',''),('lateRegDeadline',''),('earlySchoolFee',''),('regularSchoolFee',''),('lateSchoolFee',''),('earlyDelegateFee',''),('regularDelegateFee',''),('lateDelegateFee',''),('conferenceStartDate',''),('conferenceEndDate',''),('conferenceNumber',''),('mailingAddress',''),('meal1',''),('meal2',''),('meal3',''),('meal4',''),('meal5',''),('meal6',''),('meal7',''),('meal1price',''),('meal2price',''),('meal3price',''),('meal4price',''),('meal5price',''),('meal6price',''),('meal7price',''),('paymentDueDate',''),('financialAidDeadline',''),('cancellationDeadline',''),('refundRequestDeadline',''),('earlyLargeSchoolFee',''),('regularLargeSchoolFee',''),('lateLargeSchoolFee','');
/*!40000 ALTER TABLE `generalInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logType` varchar(100) NOT NULL,
  `logVal` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_tickets`
--

DROP TABLE IF EXISTS `meal_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meal_tickets` (
  `schoolId` int(11) NOT NULL,
  `meal1` int(11) NOT NULL,
  `meal2` int(11) NOT NULL,
  `meal3` int(11) NOT NULL,
  `meal4` int(11) NOT NULL,
  `meal5` int(11) NOT NULL,
  `meal6` int(11) NOT NULL,
  `meal7` int(11) NOT NULL,
  `mealNotes` text NOT NULL,
  UNIQUE KEY `schoolId` (`schoolId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_tickets`
--

LOCK TABLES `meal_tickets` WRITE;
/*!40000 ALTER TABLE `meal_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `meal_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printers` (
  `printerName` varchar(50) NOT NULL,
  PRIMARY KEY (`printerName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
/*!40000 ALTER TABLE `printers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolution`
--

DROP TABLE IF EXISTS `resolution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `nextId` int(11) NOT NULL,
  `subId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolution`
--

LOCK TABLES `resolution` WRITE;
/*!40000 ALTER TABLE `resolution` DISABLE KEYS */;
/*!40000 ALTER TABLE `resolution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolution_list`
--

DROP TABLE IF EXISTS `resolution_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolution_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committeeId` int(11) NOT NULL,
  `topicId` int(11) NOT NULL,
  `resolutionNum` int(11) NOT NULL,
  `preambulatoryId` int(11) NOT NULL,
  `operativeId` int(11) NOT NULL,
  `sponsors` text NOT NULL,
  `signatories` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolution_list`
--

LOCK TABLES `resolution_list` WRITE;
/*!40000 ALTER TABLE `resolution_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `resolution_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `schoolName` varchar(100) NOT NULL,
  `numStudents` int(8) NOT NULL,
  `numAdvisers` int(8) NOT NULL,
  `regTime` datetime NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `country` int(11) NOT NULL,
  `hearAboutUs` text NOT NULL,
  `finaid` tinyint(1) NOT NULL,
  `stayInHotel` tinyint(1) NOT NULL,
  `country1` int(11) NOT NULL,
  `country2` int(11) NOT NULL,
  `country3` int(11) NOT NULL,
  `country4` int(11) NOT NULL,
  `country5` int(11) NOT NULL,
  `country6` int(11) NOT NULL,
  `country7` int(11) NOT NULL,
  `country8` int(11) NOT NULL,
  `country9` int(11) NOT NULL,
  `country10` int(11) NOT NULL,
  `country11` int(11) NOT NULL,
  `numSpecialPositions` int(11) NOT NULL,
  `countryConfirm` int(11) NOT NULL,
  `finaidQuestion1` text NOT NULL,
  `finaidQuestion2` text NOT NULL,
  `finaidQuestion3` text NOT NULL,
  `finaidQuestion4` text NOT NULL,
  `finaidQuestion5` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_payments`
--

DROP TABLE IF EXISTS `school_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_payments`
--

LOCK TABLES `school_payments` WRITE;
/*!40000 ALTER TABLE `school_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_committee_applications`
--

DROP TABLE IF EXISTS `special_committee_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_committee_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positionId` int(11) NOT NULL,
  `schoolId` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_committee_applications`
--

LOCK TABLES `special_committee_applications` WRITE;
/*!40000 ALTER TABLE `special_committee_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `special_committee_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_committee_positions`
--

DROP TABLE IF EXISTS `special_committee_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_committee_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positionName` varchar(200) NOT NULL,
  `committeeId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_committee_positions`
--

LOCK TABLES `special_committee_positions` WRITE;
/*!40000 ALTER TABLE `special_committee_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `special_committee_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timer_log`
--

DROP TABLE IF EXISTS `timer_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `committee` varchar(10) NOT NULL,
  `country` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timer_log`
--

LOCK TABLES `timer_log` WRITE;
/*!40000 ALTER TABLE `timer_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `timer_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timer_settings`
--

DROP TABLE IF EXISTS `timer_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timer_settings` (
  `committeeId` varchar(10) NOT NULL,
  `speech` int(11) NOT NULL,
  `caucus` int(11) NOT NULL,
  `announcements` varchar(3000) NOT NULL,
  PRIMARY KEY (`committeeId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timer_settings`
--

LOCK TABLES `timer_settings` WRITE;
/*!40000 ALTER TABLE `timer_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `timer_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `loginType` varchar(50) NOT NULL,
  `realName` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `committeeId` int(11) NOT NULL,
  `schoolId` int(11) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `lastLoginIP` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-14 21:59:49
