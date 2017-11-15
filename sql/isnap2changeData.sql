-- MySQL dump 10.16  Distrib 10.2.10-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: isnap2changedb
-- ------------------------------------------------------
-- Server version	10.2.10-MariaDB

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
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `achievements` (
  `StudentID` mediumint(9) NOT NULL,
  `QuizMaster` tinyint(1) NOT NULL DEFAULT 0,
  `AllSnapFacts` tinyint(1) NOT NULL DEFAULT 0,
  `ResourcePage` tinyint(1) NOT NULL DEFAULT 0,
  `QuizLeaderBoardTopTenOnce` tinyint(1) NOT NULL DEFAULT 0,
  `LearningFromMistakes` tinyint(1) NOT NULL DEFAULT 0,
  `HeadOfClass` tinyint(1) NOT NULL DEFAULT 0,
  `WeeklyGenius` tinyint(1) NOT NULL DEFAULT 0,
  `GotItRight` tinyint(1) NOT NULL DEFAULT 0,
  `Aced` tinyint(1) NOT NULL DEFAULT 0,
  `HatTrick` tinyint(1) NOT NULL DEFAULT 0,
  `MasterExtraContent` tinyint(1) NOT NULL DEFAULT 0,
  `LoginMaster` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek1` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek2` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek3` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek4` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek5` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek6` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek7` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek8` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek9` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek10` tinyint(1) NOT NULL DEFAULT 0,
  `MasterGaming` tinyint(1) NOT NULL DEFAULT 0,
  `LaunchSportsNinja` tinyint(1) NOT NULL DEFAULT 0,
  `PlayEveryGameModeSn` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnA` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnB` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnC` tinyint(1) NOT NULL DEFAULT 0,
  `LaunchMealCrusher` tinyint(1) NOT NULL DEFAULT 0,
  `PlayEveryGameModeMc` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcA` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcB` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcC` tinyint(1) NOT NULL DEFAULT 0,
  `QuizMasterViewed` tinyint(1) NOT NULL DEFAULT 0,
  `AllSnapFactsViewed` tinyint(1) NOT NULL DEFAULT 0,
  `ResourcePageViewed` tinyint(1) NOT NULL DEFAULT 0,
  `QuizLeaderBoardTopTenOnceViewed` tinyint(1) NOT NULL DEFAULT 0,
  `LearningFromMistakesViewed` tinyint(1) NOT NULL DEFAULT 0,
  `HeadOfClassViewed` tinyint(1) NOT NULL DEFAULT 0,
  `WeeklyGeniusViewed` tinyint(1) NOT NULL DEFAULT 0,
  `GotItRightViewed` tinyint(1) NOT NULL DEFAULT 0,
  `AcedViewed` tinyint(1) NOT NULL DEFAULT 0,
  `HatTrickViewed` tinyint(1) NOT NULL DEFAULT 0,
  `MasterExtraContentViewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginMasterViewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek1Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek2Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek3Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek4Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek5Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek6Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek7Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek8Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek9Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `LoginWeek10Viewed` tinyint(1) NOT NULL DEFAULT 0,
  `MasterGamingViewed` tinyint(1) NOT NULL DEFAULT 0,
  `LaunchSportsNinjaViewed` tinyint(1) NOT NULL DEFAULT 0,
  `PlayEveryGameModeSnViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnAViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnBViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreSnCViewed` tinyint(1) NOT NULL DEFAULT 0,
  `LaunchMealCrusherViewed` tinyint(1) NOT NULL DEFAULT 0,
  `PlayEveryGameModeMcViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcAViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcBViewed` tinyint(1) NOT NULL DEFAULT 0,
  `BeatScoreMcCViewed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`StudentID`),
  CONSTRAINT `achievements_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(2,0,0,1,0,1,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(6,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(8,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(11,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(12,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(13,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(14,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(15,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(16,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(17,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(18,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(19,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(21,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0),(22,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(23,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `ClassID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(190) NOT NULL,
  `SchoolID` mediumint(9) NOT NULL,
  `TokenString` varchar(100) NOT NULL,
  `UnlockedProgress` mediumint(9) NOT NULL DEFAULT 10,
  `isClosed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ClassID`),
  UNIQUE KEY `ClassName` (`ClassName`),
  UNIQUE KEY `TokenString` (`TokenString`),
  KEY `Class_SchoolID_FK` (`SchoolID`),
  CONSTRAINT `Class_SchoolID_FK` FOREIGN KEY (`SchoolID`) REFERENCES `school` (`SchoolID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,'Sample Class 1A',1,'TOKEN1',3,0),(2,'Sample Class 1B',1,'TOKEN2',10,0),(3,'Sample Class 1C',1,'TOKEN3',10,0),(4,'Sample Class 2C',2,'TOKEN4',10,0);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `content` longtext NOT NULL,
  `readOrNot` tinyint(1) DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Amos','i@mewx.org','This is an initial message for testing propose',0,'2017-10-03 14:56:20');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competition`
--

DROP TABLE IF EXISTS `competition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competition` (
  `CompetitionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `DueWeek` mediumint(9) DEFAULT 1,
  `Title` text DEFAULT NULL,
  `Content` longtext DEFAULT NULL,
  `Excluded` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`CompetitionID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competition`
--

LOCK TABLES `competition` WRITE;
/*!40000 ALTER TABLE `competition` DISABLE KEYS */;
INSERT INTO `competition` VALUES (1,2,'Weeks 1-2','<p>2 Double passes to Hoyts Cinemas to be won!</p>\r\n<p><img src=\"https://www.spendless.net.au/media/product_brands/h/o/hoyts.png\" alt=\"\" width=\"500\" height=\"165\" /></p>\r\n<p>Entry Requirements/Conditions:</p>\r\n<p>&nbsp;</p>',0),(2,4,'Weeks 3-4','<p>2 Personalised phone cases from The Daily Edited to be won! &nbsp;</p>\r\n<p><img src=\"https://www.thedailyedited.com/pub/media/wysiwyg/summer-phonecase.jpg\" width=\"640\" height=\"200\" /></p>\r\n<p>Entry Requirements/Conditions</p>',0),(3,6,'Week 5-6','<p>2 Vouchers to Dymocks valued at $50 each to be won!</p>\r\n<p><img src=\"http://is3.mzstatic.com/image/thumb/Purple69/v4/cc/ea/e6/cceae632-d79e-70ec-c8d1-9f00996d768b/source/1200x630bb.jpg\" width=\"315\" height=\"315\" /></p>\r\n<p>Entry Requirements/Conditions</p>',0),(4,8,'Weeks 7-8','<p>2 $50 vouchers to Adidas Shop or Lorna Jane to be won!</p>\r\n<p><img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/2/20/Adidas_Logo.svg/1200px-Adidas_Logo.svg.png\" width=\"300\" height=\"203\" /></p>\r\n<p><img src=\"https://res-1.cloudinary.com/wlabs/image/fetch/c_pad,f_auto,q_auto/http://res.cloudinary.com/wlabs/image/upload/mjyvsapt8harrjfuekdq.png\" width=\"300\" height=\"300\" /></p>\r\n<p>Entry Requirements/Conditions</p>\r\n<p>&nbsp;</p>',0),(5,10,'Weeks 9-10','<p>1 iPad mini to be won!</p>\r\n<p><img src=\"https://lh3.googleusercontent.com/SQU8KaFY5-G9DedkLbxMUWKcXap1vUWfnATlBu2rEa5P1yDdqpHe-sjxLiLtlZKIZN1_MCtEbwEJJOcpg-M9WQXN2iGNkmIKgBBTQvURkx5H5B5d8k6mp6YTm5yoL9W_x1SgaSkilT-N8qctZuYaJ7NSShPG6hZOYs1hkK72Mmlz1lg5GKSWHN7u80zsgTnSKN9r8G0EeL43J5J4XLXvffaZhKYje2vUwt3SOSddIFBVI3BXZIKpc9AqEg-bRxXeAO2OQvwnkhuIixA3Y5Kj90eI9MRwtDdjeHmVmaEFmFYZEBJjzCbUkp-QtrzRVpMWeoaqP04eHsjQdOEx8ws15022XfbnkIavWJtPlcAfbxWahiSRV9Gs6cH6PcfYGLhUcSEJX90gYbGp4ZXk7KX2QPc_xZUvB2ZprMEn9i0pxjJUm9mGp7NXedp8TNvlwEZUcVGSEVVoJCgYQMpQhnDp8s2DjltIFIUekJRcdNaF4yokJQkHYLoDIgwSo4cTbD3LElbJXqGOv1Kc5x4Ehakjs521lDvF0rXKe_yGDWXXKIyvf2rOu7jrIHxAiRBIo3CfHytcYh9_BnItHE1W5YLDUOmjuGc3De8FXzf8jAOn=w845-h443-no?.jpg\" width=\"624\" height=\"350\" /></p>\r\n<p>Entry Requirements/Conditions</p>',0);
/*!40000 ALTER TABLE `competition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `GameID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Description` text NOT NULL,
  `Levels` mediumint(9) NOT NULL,
  PRIMARY KEY (`GameID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'Fruit Ninja',5),(2,'Candy Crush',50);
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_record`
--

DROP TABLE IF EXISTS `game_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_record` (
  `GameID` mediumint(9) NOT NULL DEFAULT 0,
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `Level` mediumint(9) NOT NULL DEFAULT 0,
  `Score` int(11) DEFAULT NULL,
  `SubmissionTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`GameID`,`StudentID`,`Level`),
  KEY `Game_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `Game_Record_GameID_FK` FOREIGN KEY (`GameID`) REFERENCES `game` (`GameID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Game_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_record`
--

LOCK TABLES `game_record` WRITE;
/*!40000 ALTER TABLE `game_record` DISABLE KEYS */;
INSERT INTO `game_record` VALUES (1,1,2,300,'2017-10-17 14:36:39'),(1,2,1,400,'2017-10-17 14:36:39'),(1,2,2,400,'2017-10-17 14:36:39'),(2,1,2,320,'2017-10-17 14:36:39');
/*!40000 ALTER TABLE `game_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_total_record`
--

DROP TABLE IF EXISTS `game_total_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_total_record` (
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `Score` int(11) DEFAULT NULL,
  PRIMARY KEY (`StudentID`),
  KEY `Game_Total_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `Game_Total_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_total_record`
--

LOCK TABLES `game_total_record` WRITE;
/*!40000 ALTER TABLE `game_total_record` DISABLE KEYS */;
INSERT INTO `game_total_record` VALUES (1,620),(2,800),(3,0),(4,0),(5,0),(6,0),(7,0),(8,0),(9,0),(10,0),(11,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0),(18,0),(19,0),(20,0),(21,0),(22,0),(23,0);
/*!40000 ALTER TABLE `game_total_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `learning_material`
--

DROP TABLE IF EXISTS `learning_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `learning_material` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `Content` longtext DEFAULT NULL,
  `Excluded` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Learning_Material_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learning_material`
--

LOCK TABLES `learning_material` WRITE;
/*!40000 ALTER TABLE `learning_material` DISABLE KEYS */;
INSERT INTO `learning_material` VALUES (5,'\n<p>Learning material for this quiz has not been added.</p>',1),(12,'<p><iframe src=\"//www.youtube.com/embed/u4srWvLXZRw\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></p>',-1),(13,'<ul>\r\n<li>Cigarette smoking is one of the leading causes of preventable death in the world and addiction to nicotine usually begins during adolescence.</li>\r\n<li>90% of chronic smokers begin smoking before the age of 18. It only takes 10 seconds for the nicotine from one puff of smoke to reach the brain.</li>\r\n<li>This rapid delivery of nicotine from the lungs to the brain is one of the reasons that cigarettes are so addictive. Nicotine causes cells in the brain to release dopamine, a feel good hormone that makes you feel alert and content.</li>\r\n<li>Over time, the brain cells of smokers are changed to expect the regular bursts of extra dopamine that result from smoking.</li>\r\n<li>The younger smokers are when they begin to experiment with smoking, the more likely they are to become heavily addicted and have greater problems in quitting later on in life.d</li>\r\n</ul>',0),(15,'<p>When you click on each of the body areas, facts pop up about the damages that smoking is doing to different parts of the body.</p>\r\n<p>Source: <a href=\"http://www.quit.org.au/reasons-to-quit/health-risks-of-smoking\">http://www.quit.org.au/reasons-to-quit/health-risks-of-smoking</a></p>',0),(16,'<p><iframe src=\"//www.youtube.com/embed/110MI90LZQA\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></p>\r\n<p><iframe src=\"//www.youtube.com/embed/haqi4xvjvKo\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></p>',-1),(17,'<p>Learning material for this quiz has not been added.</p>',1),(18,'<p><strong>Do you know how many young people smoke in Australia?</strong></p>\r\n<p>According to Quitline, rates of smoking amongst young people have never been lower. The most recent data (2014) finds that 5.1 per cent of 12 to 17 year olds in Australia are current smokers (have smoked in the past seven days).</p>\r\n<p>Source: <a href=\"http://www.quit.org.au/resource-centre/communities/youth-and-smoking\"><strong>http://www.quit.org.au/resource-centre/communities/youth-and-smoking</strong></a></p>',0),(19,'<p><em>What&rsquo;s going on in Australia?</em></p>\r\n<p>Cigarette smoking is the leading cause of preventable death in the world and approximately 30 million children take up the harmful habit each year (1, 2). In Australia, 70, 000 young people start smoking annually and there are an additional 15,000 Australians who die as a result of cigarette smoking yearly (7). Smoking is estimated to cost the Australian economy $31.5 billion dollars every year in health care and social costs (8). Recent estimates of the economic impact from an 8% reduction in the prevalence of tobacco smoking in Australia found that it would result in: 158,000 fewer incident cases of disease, 5000 fewer deaths, 2.2 million fewer lost working days, 3000 fewer early retirements and would reduce health sector costs by AU$491 million (36).</p>',0),(20,'<p>Read the summary below and list three reasons why e-cigarettes are potentially harmful:</p>\r\n<p>Electronic cigarettes or e-cigarettes are rapidly growing in popularity. They have been marketed as &lsquo;safer&rsquo; alternatives to smoking. This is because many of the chemical products contained within traditional cigarettes and the bi&ndash;products that are released from tobacco burning which cause respiratory and other illnesses are not present in E-cigs.&nbsp;&nbsp; However, although there is no tar and no smoke, there are still some E-cigs that contain nicotine which is the addictive main addictive substance of smoking. The 3 biggest tobacco companies: Phillip Morris, Reynolds America and Lorillard all have shares invested in e-cigs in fact Lorillard&rsquo;s owns Blu which is the industry&rsquo;s leading brand. In a hope to get younger E-cigarette users on board brands such as cream, lemon, banana, cinnamon and many more have been released. You should be aware of the marketing strategies that Big Tobacco can use to get you on board. They are getting better and better at selling death!</p>\r\n<p>Worryingly, the industry is not yet properly regulated, and there is no standard for manufacturing or production which means we do not properly know what&rsquo;s in them! There has been very little research surrounding the use of these devices to facilitate smoking cessation, with some studies reporting that they can cause symptoms such as nausea, headaches, coughing and throat and lung irritations. Both the World Health Organisation and the Food and Drug Authority have not approved the use of e&ndash;cigarettes in many countries, including Australia and have warned that they should be approached with caution.</p>',0),(21,'<p>Since 1 December 2012, <strong>all</strong> tobacco products sold, offered for sale, or otherwise supplied in Australia must be in plain packaging. Plain packaging is a key part of Australia&rsquo;s comprehensive package of tobacco control measures, which include:</p>\r\n<ul>\r\n<li><a href=\"http://www.health.gov.au/internet/main/publishing.nsf/Content/tobacco-warn\">Updated and expanded health warnings</a>:&nbsp; requires health warnings to cover at least 75 per cent of the front of most tobacco packaging, 90 per cent of the back of cigarette packaging and 75 per cent of the back of most other tobacco product packaging</li>\r\n<li>Legislation to restrict <a href=\"http://www.health.gov.au/internet/main/publishing.nsf/Content/checklist\">internet advertising</a> of tobacco products in Australia</li>\r\n<li>Record investments in anti-smoking social marketing campaigns</li>\r\n<li>The 25 per cent tobacco excise increase in April 2010;</li>\r\n<li>Four staged increases in excise and excise-equivalent customs duty on tobacco and tobacco-related products: the first 12.5 per cent increase commenced on 1 December 2013 and further 12.5 per cent increases will occur on 1 September 2014, 1 September 2015 and 1 September 2016;</li>\r\n<li>A reduction in duty free concessions for tobacco products</li>\r\n<li>Stronger penalties for tobacco smuggling offences.</li>\r\n</ul>\r\n<p>Source: <a href=\"http://www.health.gov.au/internet/main/publishing.nsf/Content/tobacco-plain\">http://www.health.gov.au/internet/main/publishing.nsf/Content/tobacco-plain</a></p>',0),(22,'<p>&nbsp; Create a slogan and poster for an advertising campaign aimed at youth to convince them to not take up smoking. (There will be a winner and prize for the best poster).</p>',0),(23,'<p>Imagine you are a smoker trying to give up smoking. What are your motivations? What are the benefits for yourself and what are the draw backs? Use the below tool to visually represent your thoughts.</p>',0),(24,'<p>#using \'infographics.html\';</p>\r\n<p><strong><u>Smoking</u></strong></p>\r\n<p><strong>Liver:</strong> The toxins found in cigarette smoke can damage the liver and cause diseases like cancers, Hep B and C and liver fibrosis.</p>\r\n<p>Jewell, C. The Effects of Smoking on the Liver.URL:&lt; <a href=\"http://www.ehow.com/how-does_4572401_effects-smoking-liver.html\">http://www.ehow.com/how-does_4572401_effects-smoking-liver.html</a>&gt;&nbsp; &nbsp;[Accessed 07/07/2016].</p>\r\n<p><strong>Brain:</strong> You are more likely to have difficulty sleeping if you are a teen who smokes.</p>\r\n<p>&nbsp;Kwok-Kei, M. Smoking and sleep disorders in Chinese adolescents Sleep Medicine , Volume 11 , Issue 3 , 268 &ndash; 273. 2010</p>\r\n<p><strong>Nose:</strong> Smoking can dull your sense of smell and taste.</p>\r\n<p>Icanquit. Health. URL: &lt; <a href=\"https://www.icanquit.com.au/further-resources/quitline\">https://www.icanquit.com.au/further-resources/quitline</a> &gt;[Accessed 07/07/2016].&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;<strong>Skin:</strong> Smoking causes wrinkles!</p>\r\n<p>Okada, H, Alleyne, Brendan B.S,&nbsp; Kaveh V;, Kimberly K, Guyuron B. Facial Changes Caused by Smoking: A Comparison between Smoking and Nonsmoking Identical Twins. Plastic &amp; Reconstructive Surgery. 2013.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Hair:</strong> There is a link between smoking and baldness.</p>\r\n<p>Su L, Chen T. Association of Androgenetic Alopecia With Smoking and Its Prevalence Among Asian Men: A Community-Based Survey.&nbsp;Arch Dermatol.&nbsp;2007.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Mouth:</strong> Smoking stains your teeth and causes gum disease.</p>\r\n<p>Quitline. Quit Victoria, Australia 2016.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Tongue: </strong>Smoking can cause black hairy tongue due to a build-up of bacteria and yeast.</p>\r\n<p>Black hairy tongue. URL: &lt;http://www.webmd.com/oral-health/guide/black-hairy-tongue&gt;.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Ears:</strong> Smoking is a risk factor for hearing loss.</p>\r\n<p>Zayed AA, Shahait AD, Ayoub MN, Yousef A-M. Smokers&rsquo; hair: Does smoking cause premature hair graying? Indian Dermatology Online Journal. 2013;4(2):90-92. doi:10.4103/2229-5178.110586.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Eyes:</strong>Smoking can lead to many eye problems including blindness.</p>\r\n<p>Bedinghaus, T. How does smoking affect your eyes? About Health, 2014.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Lungs</strong></p>\r\n<p>Starting smoking during your teens can impair the growth of your lungs and can cause irreversible damage.</p>\r\n<p>United States. Department of Health and Human Services. The health consequences of smoking: a report of the Surgeon General. Atlanta, GA: U.S.&nbsp;Department of Health and Human Services, Centers for Disease Control and Prevention, National Center for Chronic Disease Prevention and Health&nbsp;Promotion, Office on Smoking and Health; 2004.</p>\r\n<p><strong>Heart:</strong> Smokers have resting heart rates two to three beats per minute faster than non-smokers and an increased risk of having a heart attack later on in life.</p>\r\n<p>World Health Organisation, Health effects of smoking among young people, 2016.</p>\r\n<p><strong>Legs:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n<p>Smoking can cause Gangrene leading to amputation of your limbs.</p>\r\n<p>Victoria State Government. Smoking, Youth Central, 2016.</p>\r\n<p>http://www.youthcentral.vic.gov.au/health-relationships/smoking</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p><strong>Breasts</strong></p>\r\n<p>Smoking causes breasts to sag girls.</p>\r\n<p>Melanie Haiken, 5 Most surprising reasons to give up smoking, Caring. URL:&lt;https://www.caring.com/articles/5-surprising-reasons-to-quit-smoking &gt; 2014</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Bones:</strong></p>\r\n<p>People who smoke are more likely to develop Rheumatoid Arthritis.</p>\r\n<p>Hutchinson D&nbsp;and Moots R. Cigarette smoking and severity of rheumatoid arthritis. Rheumatology, 40 (12), 2011.</p>\r\n<p><strong>&nbsp;</strong></p>\r\n<p><strong>Brain:</strong></p>\r\n<p>Smoking is a risk factor for dementia.</p>\r\n<p>Anstey K, Sanden C, Salim A, and O\'Kearney R. Smoking as a risk factor for dementia and cognitive decline: a meta-analysis of prospective studies. American Journal of Epidemiology, 166:367-378, 2007.</p>\r\n<p>Peters R, et al. Smoking, dementia and cognitive decline in the elderly, a systematic review. BMC Geriatrics, 2008, 8:36.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Sexual organs:</strong> Smoking can cause erectile dysfunction.</p>\r\n<p>Roland, J. Can Smoking Cigarettes Cause Impotence? http://www.healthline.com/health/erectile-dysfunction/impotence-and-smoking&gt;2015 [Accessed 07/07/2016].</p>\r\n<p>Women who smoke can get menopause earlier.&nbsp;</p>\r\n<p>Pietrangelo, A. The Effects of smoking on the Body. <a href=\"URL:http://www.healthline.com/health/smoking/effects-on-body\">URL:http://www.healthline.com/health/smoking/effects-on-body</a> 2014 [Accessed 07/07/2016].</p>',0);
/*!40000 ALTER TABLE `learning_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matching_option`
--

DROP TABLE IF EXISTS `matching_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matching_option` (
  `OptionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text NOT NULL,
  `MatchingID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`OptionID`),
  KEY `Matching_Option_MatchingID_FK` (`MatchingID`),
  CONSTRAINT `Matching_Option_MatchingID_FK` FOREIGN KEY (`MatchingID`) REFERENCES `matching_question` (`MatchingID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matching_option`
--

LOCK TABLES `matching_option` WRITE;
/*!40000 ALTER TABLE `matching_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `matching_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matching_question`
--

DROP TABLE IF EXISTS `matching_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matching_question` (
  `MatchingID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`MatchingID`),
  KEY `Matching_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `Matching_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `matching_section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matching_question`
--

LOCK TABLES `matching_question` WRITE;
/*!40000 ALTER TABLE `matching_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `matching_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matching_section`
--

DROP TABLE IF EXISTS `matching_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matching_section` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `Description` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Matching_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matching_section`
--

LOCK TABLES `matching_section` WRITE;
/*!40000 ALTER TABLE `matching_section` DISABLE KEYS */;
/*!40000 ALTER TABLE `matching_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcq_attempt_record`
--

DROP TABLE IF EXISTS `mcq_attempt_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcq_attempt_record` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `Attempt` mediumint(9) DEFAULT 0,
  `HighestGrade` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`,`StudentID`),
  KEY `MCQ_Attempt_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `MCQ_Attempt_Record_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Attempt_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcq_attempt_record`
--

LOCK TABLES `mcq_attempt_record` WRITE;
/*!40000 ALTER TABLE `mcq_attempt_record` DISABLE KEYS */;
INSERT INTO `mcq_attempt_record` VALUES (13,2,3,1);
/*!40000 ALTER TABLE `mcq_attempt_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcq_option`
--

DROP TABLE IF EXISTS `mcq_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcq_option` (
  `OptionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `Explanation` text DEFAULT NULL,
  `MCQID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`OptionID`),
  KEY `MCQ_Option_MCQID_FK` (`MCQID`),
  CONSTRAINT `MCQ_Option_MCQID_FK` FOREIGN KEY (`MCQID`) REFERENCES `mcq_question` (`MCQID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcq_option`
--

LOCK TABLES `mcq_option` WRITE;
/*!40000 ALTER TABLE `mcq_option` DISABLE KEYS */;
INSERT INTO `mcq_option` VALUES (63,'A Nicotine receptor-> Nicotine-> Cell->Dopamine release ',' ',20),(64,'B Nicotine->Nicotine receptor-> Cell->Dopamine release ',' ',20),(65,'C Cell->Nicotine->Nicotine receptor-> Dopamine release ',' ',20),(66,'D Nicotine->Nicotine receptor-> Dopamine release-> Cell',' ',20),(67,'A  Addiction to nicotine',' ',21),(68,'B  Associated risk of other drug use',' ',21),(69,'C  Difficulty in breathing',' ',21),(70,'D All of the above',' ',21),(71,'A Increased risk of lung cancer','',22),(72,'B Stroke','',22),(73,'C Difficulty in sleeping','',22),(74,'D Heart Disease','',22),(75,'A Dancing','',23),(76,'B Reading','',23),(77,'C Fighting','',23),(78,'D Driving','',23),(79,'A Longer than someone who has never smoked','',24),(80,'B Shorter than someone who has never smoked','',24),(81,'C 7 years less than someone who has never smoked','',24),(82,'D 10 years less than someone who has never smoked','',24),(83,'A To use drugs','',25),(84,'B To use Alcohol','',25),(85,'C Engage in less physical activity (need to add that in)','',25),(86,'D All of the above ','',25),(87,'A Causing a build-up of plaque in the coronary arteries','',26),(88,'B Increasing the risk of heart attack','',26),(89,'C Damaging heart and blood vessels ','',26),(90,'D All of the above','',26),(91,'A Slowing blood flow to kidneys','',27),(92,'B Increasing blood flow to kidneys ','',27),(93,'C Disrupting the alveolar sacs in the kidneys ','',27),(94,'D Damaging the coronary vessels ','',27),(95,'A Increasing the risk of lung cancer','',28),(96,'B Increasing blood flow to the lungs','',28),(97,'C Decreasing lung tissue damage','',28),(98,'D Both A and B are correct ','',28),(99,'A Smoking parents are more likely to struggle with getting pregnant ','',29),(100,'B Erectile Dysfunction ','',29),(101,'C Both A and B are correct ','',29),(102,'D Having heavier babies','',29),(103,'A Smoothing out uneven skin tone','',30),(104,'B Causing dermatitis ','',30),(105,'C Causing wrinkles','',30),(106,'D Causing emphysema ','',30),(107,'A Increasing the risk of blindness','',31),(108,'B Increasing the risk of macular degeneration which causes blindness ','',31),(109,'C Increasing the amount of light absorbed by the pupil','',31),(110,'D Decreasing the amount of light absorbed by the eyes','',31),(111,'A Increasing the risk of getting gangrene','',32),(112,'B Can cause leg bones to get smaller','',32),(113,'C Affecting the retina','',32),(114,'D Both A and B are right ','',32),(115,'A Stopping the liver from filtering all toxins in the body','',33),(116,'B Increasing the filtrating capacity of the liver','',33),(117,'C Causing the liver to take on kidney like functions','',33),(118,'D Increasing the risk of Fibrosis in the liver ','',33),(119,'A Causing you to get infections more easily ','',34),(120,'B Compromising your immune system','',34),(121,'C Increasing the capacity of the system to identify pathogens and viruses','',34),(122,'D A + B are correct ','',34),(123,'A Are more likely to have low birth weight babies','',35),(124,'B More likely to have babies which might develop asthma ','',35),(125,'C More likely to have babies who might develop Sudden Infant Death Syndrome','',35),(126,'D All of the above','',35),(127,'A)	Heart','',36),(128,'B)	Brain','',36),(129,'C)	Skin','',36),(130,'D)	All of the above ','',36),(131,'A)	Increased sex drive','',37),(132,'B)	Decreased sex drive ','',37),(133,'C)	Erectile dysfunction ','',37),(134,'D)	All of the above ','',37),(135,'A)	Down Syndrome ','',38),(136,'B)	Cerebral palsy','',38),(137,'C)	Fragile X Syndrome','',38),(138,'D)	Dementia ','',38),(139,'A)	An increased risk of having heart attacks ','',39),(140,'B)	A decreased risk of having heart attacks ','',39),(141,'C)	Smoking neither increases nor decreases risk of heart attack ','',39),(142,'D)	Smokers have resting heart rates that beat 6 times faster per minute than non-smokers','',39),(143,'A)	Baldness ','',40),(144,'B)	Rheumatoid Arthritis ','',40),(145,'C)	Sagging Breasts ','',40),(146,'D)	All of the above','',40);
/*!40000 ALTER TABLE `mcq_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcq_question`
--

DROP TABLE IF EXISTS `mcq_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcq_question` (
  `MCQID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text DEFAULT NULL,
  `CorrectChoice` mediumint(9) DEFAULT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`MCQID`),
  KEY `MCQ_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `MCQ_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `mcq_section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcq_question`
--

LOCK TABLES `mcq_question` WRITE;
/*!40000 ALTER TABLE `mcq_question` DISABLE KEYS */;
INSERT INTO `mcq_question` VALUES (20,'What is the correct order of nicotine release into the body?',64,13),(21,'What are the short term effects of smoking?',70,15),(22,'What are the long term effects of smoking? Choose the incorrect answer',73,15),(23,'Smoking is associated with risky behaviour such as ',77,15),(24,'On Average someone who smokes a pack or more of cigarettes a day lives',81,15),(25,'Teens who smoke are more likely to',86,15),(26,'Smoking affects the heart by:',90,17),(27,'Smoking affects the kidneys by:',91,17),(28,'Smoking affects the lungs by:',95,17),(29,'Smoking can cause fertility problems such as:',101,17),(30,'Smoking can affect the skin by:',105,17),(31,'Smoking affects the eyes by:',108,17),(32,'Smoking can affect the legs by:',111,17),(33,'Smoking can affect the liver by:',118,17),(34,'Smoking can affect your immune system by:',122,17),(35,'Mothers who smoke during pregnancy:',126,17),(36,'What organs can smoking damage?',130,24),(37,'Smoking can cause:',133,24),(38,'Smoking is a risk factor for:',138,24),(39,'Smokers have:',139,24),(40,'Smoking can cause:',146,24);
/*!40000 ALTER TABLE `mcq_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcq_question_record`
--

DROP TABLE IF EXISTS `mcq_question_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcq_question_record` (
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `MCQID` mediumint(9) NOT NULL DEFAULT 0,
  `Choice` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`StudentID`,`MCQID`),
  KEY `MCQ_Question_Record_MCQID_FK` (`MCQID`),
  KEY `MCQ_Question_Record_Choice_FK` (`Choice`),
  CONSTRAINT `MCQ_Question_Record_Choice_FK` FOREIGN KEY (`Choice`) REFERENCES `mcq_option` (`OptionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Question_Record_MCQID_FK` FOREIGN KEY (`MCQID`) REFERENCES `mcq_question` (`MCQID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Question_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcq_question_record`
--

LOCK TABLES `mcq_question_record` WRITE;
/*!40000 ALTER TABLE `mcq_question_record` DISABLE KEYS */;
INSERT INTO `mcq_question_record` VALUES (2,20,64);
/*!40000 ALTER TABLE `mcq_question_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mcq_section`
--

DROP TABLE IF EXISTS `mcq_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcq_section` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `Points` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `MCQ_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mcq_section`
--

LOCK TABLES `mcq_section` WRITE;
/*!40000 ALTER TABLE `mcq_section` DISABLE KEYS */;
INSERT INTO `mcq_section` VALUES (13,1),(15,5),(17,10),(24,5);
/*!40000 ALTER TABLE `mcq_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` mediumint(9) DEFAULT NULL,
  `isFromStudent` tinyint(1) DEFAULT 1,
  `content` longtext NOT NULL,
  `readOrNot` tinyint(1) DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleteByStu` tinyint(1) NOT NULL DEFAULT 0,
  `deleteByRes` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `Messages_StudentID_FK` (`StudentID`),
  CONSTRAINT `Messages_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,1,'This is an initial message for testing propose',1,'2017-10-03 14:56:20',0,0),(2,22,1,'hi',1,'2017-10-24 10:17:28',0,0),(3,22,0,'hi',0,'2017-10-24 10:17:51',0,0);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc_section`
--

DROP TABLE IF EXISTS `misc_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc_section` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `QuizSubType` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Misc_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misc_section`
--

LOCK TABLES `misc_section` WRITE;
/*!40000 ALTER TABLE `misc_section` DISABLE KEYS */;
INSERT INTO `misc_section` VALUES (5,'Calculator',20);
/*!40000 ALTER TABLE `misc_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poster_record`
--

DROP TABLE IF EXISTS `poster_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poster_record` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `ZwibblerDoc` longtext DEFAULT NULL,
  `ImageURL` longtext DEFAULT NULL,
  `Grading` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`,`StudentID`),
  CONSTRAINT `Poster_Record_StudentID_QuizID_FK` FOREIGN KEY (`QuizID`, `StudentID`) REFERENCES `quiz_record` (`QuizID`, `StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poster_record`
--

LOCK TABLES `poster_record` WRITE;
/*!40000 ALTER TABLE `poster_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `poster_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poster_section`
--

DROP TABLE IF EXISTS `poster_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poster_section` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `Title` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Poster_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poster_section`
--

LOCK TABLES `poster_section` WRITE;
/*!40000 ALTER TABLE `poster_section` DISABLE KEYS */;
INSERT INTO `poster_section` VALUES (22,'not take up smoking','Create a slogan and poster for an advertising campaign aimed at youth to convince them to not take up smoking. (There will be a winner and prize for the best poster).                                ',10),(23,'Smoking','Imagine you are a smoker trying to give up smoking. What are your motivations? What are the benefits for yourself and what are the draw backs? Use the below tool to visually represent your thoughts. \r\n',10);
/*!40000 ALTER TABLE `poster_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz` (
  `QuizID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Week` mediumint(9) DEFAULT NULL,
  `QuizType` enum('SAQ','MCQ','Matching','Poster','Misc') DEFAULT NULL,
  `ExtraQuiz` tinyint(1) DEFAULT 0,
  `TopicID` mediumint(9) DEFAULT NULL,
  `QuizName` text DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  KEY `Quiz_TopicID_FK` (`TopicID`),
  CONSTRAINT `Quiz_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz`
--

LOCK TABLES `quiz` WRITE;
/*!40000 ALTER TABLE `quiz` DISABLE KEYS */;
INSERT INTO `quiz` VALUES (5,6,'Misc',0,1,'Not on word'),(12,1,'SAQ',0,1,'Quiz 1'),(13,2,'MCQ',0,1,'Quiz 2'),(15,3,'MCQ',0,1,'Quiz 4'),(16,5,'SAQ',0,1,NULL),(17,6,'MCQ',0,1,'Quiz 7'),(18,7,'SAQ',0,1,'Quiz 8'),(19,8,'SAQ',0,1,'Quiz 9'),(20,8,'SAQ',0,1,'Quiz 10'),(21,9,'SAQ',0,1,'Quiz 11'),(22,9,'Poster',0,1,'Quiz 12'),(23,2,'Poster',0,1,'Quiz 3'),(24,3,'MCQ',0,1,'Smoking Infographics');
/*!40000 ALTER TABLE `quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_record`
--

DROP TABLE IF EXISTS `quiz_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_record` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `Status` enum('UNSUBMITTED','UNGRADED','GRADED') DEFAULT 'GRADED',
  `Viewed` tinyint(1) DEFAULT 0,
  `Grade` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`,`StudentID`),
  KEY `Quiz_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `Quiz_Record_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Quiz_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_record`
--

LOCK TABLES `quiz_record` WRITE;
/*!40000 ALTER TABLE `quiz_record` DISABLE KEYS */;
INSERT INTO `quiz_record` VALUES (12,2,'GRADED',1,8),(13,2,'GRADED',0,1),(18,21,'GRADED',0,16);
/*!40000 ALTER TABLE `quiz_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `RecipeID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `RecipeName` text NOT NULL,
  `Source` text DEFAULT NULL,
  `MealType` text NOT NULL,
  `PreparationTime` mediumint(9) NOT NULL,
  `CookingTime` mediumint(9) NOT NULL,
  `Serves` mediumint(9) NOT NULL,
  `Image` text DEFAULT NULL,
  PRIMARY KEY (`RecipeID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES (1,'Eggplant Parmesan Pizza','http://www.eatingwell.com/recipes_menus/recipe_slideshows/vegetarian_pizza_recipes?slide=1#leaderboardad','Main Meal',15,20,4,NULL);
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_ingredient`
--

DROP TABLE IF EXISTS `recipe_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_ingredient` (
  `IngredientID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`IngredientID`),
  KEY `Recipe_Ingredient_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Ingredient_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_ingredient`
--

LOCK TABLES `recipe_ingredient` WRITE;
/*!40000 ALTER TABLE `recipe_ingredient` DISABLE KEYS */;
INSERT INTO `recipe_ingredient` VALUES (1,'1 small eggplant, (about 12 ounces)',1),(2,'Yellow cornmeal, for dusting',1),(3,'1 pound Easy Whole-Wheat Pizza Dough, or other prepared dough (recipe follows)',1),(4,'3/4 cup prepared marinara sauce',1),(5,'2 tablespoons chopped fresh basil',1),(6,'1 medium clove garlic, minced medium clove garlic, minced',1),(7,'3/4 cup thinly shaved Parmigiano-Reggiano cheese, (see Tip)',1);
/*!40000 ALTER TABLE `recipe_ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_nutrition`
--

DROP TABLE IF EXISTS `recipe_nutrition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_nutrition` (
  `NutritionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `NutritionName` text DEFAULT NULL,
  `MeasurementUnit` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`NutritionID`),
  KEY `Recipe_Nutrition_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Nutrition_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_nutrition`
--

LOCK TABLES `recipe_nutrition` WRITE;
/*!40000 ALTER TABLE `recipe_nutrition` DISABLE KEYS */;
INSERT INTO `recipe_nutrition` VALUES (1,'calories','359',1),(2,'fat','7 g',1),(3,'cholesterol','12 mg',1),(4,'carbohydrates','59 g',1),(5,'protein','16 g',1),(6,'fiber','9 g',1),(7,'sodium','713 mg',1),(8,'potassium','416 mg',1);
/*!40000 ALTER TABLE `recipe_nutrition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe_step`
--

DROP TABLE IF EXISTS `recipe_step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe_step` (
  `StepID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Description` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`StepID`),
  KEY `Recipe_Step_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Step_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe_step`
--

LOCK TABLES `recipe_step` WRITE;
/*!40000 ALTER TABLE `recipe_step` DISABLE KEYS */;
INSERT INTO `recipe_step` VALUES (1,'Preheat grill to medium-high. (For charcoal grilling or an oven variation, see below.)',1),(2,'Cut eggplant into 1/2-inch thick rounds. Grill, turning once, until marked and softened, 4 to 6 minutes. Let cool slightly, then thinly slice into strips. Reduce heat to low.',1),(3,'Sprinkle cornmeal onto a pizza peel or large baking sheet. Roll out the dough (see Tip) and transfer it to the prepared peel or baking sheet, making sure the underside of the dough is completely coated with cornmeal.',1),(4,'Slide the crust onto the grill rack; close the lid. Cook until lightly browned, 3 to 4 minutes.',1),(5,'Using a large spatula, flip the crust. Spread marinara sauce on the crust, leaving a 1-inch border. Quickly top with the eggplant, basil and garlic. Lay the Parmigiano-Reggiano shavings on top.',1),(6,'Close the lid again and grill until the cheese has melted and the bottom of the crust has browned, about 8 minutes.',1);
/*!40000 ALTER TABLE `recipe_step` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researcher`
--

DROP TABLE IF EXISTS `researcher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `researcher` (
  `ResearcherID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`ResearcherID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researcher`
--

LOCK TABLES `researcher` WRITE;
/*!40000 ALTER TABLE `researcher` DISABLE KEYS */;
INSERT INTO `researcher` VALUES (1,'Ann','d59324e4d5acb950c4022cd5df834cc3'),(2,'Patricia','d59324e4d5acb950c4022cd5df834cc3');
/*!40000 ALTER TABLE `researcher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_question`
--

DROP TABLE IF EXISTS `saq_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_question` (
  `SAQID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`SAQID`),
  KEY `SAQ_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `SAQ_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `saq_section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_question`
--

LOCK TABLES `saq_question` WRITE;
/*!40000 ALTER TABLE `saq_question` DISABLE KEYS */;
INSERT INTO `saq_question` VALUES (8,'What do you think the message behind this video was?',5,12),(9,'Do you think that this video is effective? Why/ why not? ',5,12),(10,'What are the side-effects that can occur from using E-cigarettes?',5,16),(11,'What is Australia’s stance on E-Cigarettes?',5,16),(12,'What is the difference between smoking cigarettes and using E-cigarettes?',5,16),(13,'Name 7 diseases caused by smoking. You can search the web if you need help.',10,18),(14,'Name 5 different strategies that a person who is trying to quit smoking can use. Write a brief explanation about how each can be used.  Source: https://www.cancersa.org.au/information/i-want-to-cut-my-cancer-risk.',10,18),(15,'A)	Do you think that smoking is a significant problem in Australia? Why/why not? ',10,19),(16,'A)	If you were a policy maker and had to design an anti-smoking campaign to prevent the uptake of smoking amongst young people, how would you go about it?',10,19),(17,'list three reasons why e-cigarettes are potentially harmful:',15,20),(18,'Do you think that Australia is doing enough to deter youth from taking up smoking?',5,21),(19,'Do you think plain packaging of cigarettes have made a big impact on reducing tobacco use?',5,21),(20,'Why do you think plain packaging of cigarettes will help stop young people from smoking? ',5,21),(21,'What messages do you think should be on cigarette packaging?',5,21),(22,'What do you think Australia should do next, to help reduce population level tobacco? ',5,21);
/*!40000 ALTER TABLE `saq_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_question_record`
--

DROP TABLE IF EXISTS `saq_question_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_question_record` (
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `SAQID` mediumint(9) NOT NULL DEFAULT 0,
  `Answer` text DEFAULT NULL,
  `Feedback` text DEFAULT NULL,
  `Grading` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`StudentID`,`SAQID`),
  KEY `SAQ_Question_Record_SAQID_FK` (`SAQID`),
  CONSTRAINT `SAQ_Question_Record_SAQID_FK` FOREIGN KEY (`SAQID`) REFERENCES `saq_question` (`SAQID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SAQ_Question_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_question_record`
--

LOCK TABLES `saq_question_record` WRITE;
/*!40000 ALTER TABLE `saq_question_record` DISABLE KEYS */;
INSERT INTO `saq_question_record` VALUES (2,8,'ans1','',4),(2,9,'ans2','',4),(21,13,'','15',6),(21,14,'','',10);
/*!40000 ALTER TABLE `saq_question_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saq_section`
--

DROP TABLE IF EXISTS `saq_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saq_section` (
  `QuizID` mediumint(9) NOT NULL DEFAULT 0,
  `MediaTitle` text DEFAULT NULL,
  `MediaSource` text DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `SAQ_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saq_section`
--

LOCK TABLES `saq_section` WRITE;
/*!40000 ALTER TABLE `saq_section` DISABLE KEYS */;
INSERT INTO `saq_section` VALUES (12,'Truth Video','https://www.youtube.com/watch?v=u4srWvLXZRw'),(16,'E-Cigarettes','https://www.youtube.com/watch?v=110MI90LZQA'),(18,NULL,NULL),(19,NULL,NULL),(20,NULL,NULL),(21,NULL,NULL);
/*!40000 ALTER TABLE `saq_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `SchoolID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `SchoolName` varchar(190) DEFAULT NULL,
  PRIMARY KEY (`SchoolID`),
  UNIQUE KEY `SchoolName` (`SchoolName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (2,'Sample Adelaide High School'),(1,'Sample School'),(3,'Sample Woodville High School');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `snap_fact`
--

DROP TABLE IF EXISTS `snap_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snap_fact` (
  `SnapFactID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `Recource` text DEFAULT NULL,
  `TopicID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`SnapFactID`),
  KEY `Snap_Fact_TopicID_FK` (`TopicID`),
  CONSTRAINT `Snap_Fact_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `snap_fact`
--

LOCK TABLES `snap_fact` WRITE;
/*!40000 ALTER TABLE `snap_fact` DISABLE KEYS */;
INSERT INTO `snap_fact` VALUES (18,'Smoking is a risk factor for developing breast cancer.','American Cancer Society, Breast Cancer Risk and Prevention: URL: &lt;https://www.cancer.org/cancer/breast-cancer/risk-and-prevention.html&gt;. ',1),(20,'Sugar and cocoa are often added into cigarettes. ','1) Gilman, Sander L. and Zhou Xun. Smoke: A Global History of Smoking. London, UK: Reakton Books, Ltd., 2004. \r\n2) Sokol N, Kennedt R, Connolly G. The Role of Cocoa as a Cigarette Additive: Opportunities for Product Regulation. Nicotine Tob Res. 2014 Jul; 16(7): 984–991. ',1),(21,'Fan of whale vomit? It\'s added to cigarettes to increase flavour. ','Gilman, Sander L. and Zhou Xun. Smoke: A Global History of Smoking. London, UK: Reakton Books, Ltd., 2004.',1),(22,'Quitting smoking has almost immediate health benefits by decreasing your heart rate.','Papathanasiou G, Georgakopoulos D, Papageorgiou E, Zerva E, Michalis L, Kalfakakou V, Evangelou A. Effects of smoking on heart rate at rest and during exercise, and on heart rate recovery, in young adults. Hellenic J Cardiol. 2013 May-Jun;54 (3):168-77.',1),(23,'Quitting smoking has almost immediate health benefits by decreasing your blood pressure.','Paola Primatesta, Emanuela Falaschetti, Sunjai Gupta, Michael G. Marmot and Neil R. Poulter. Association Between Smoking and Blood Pressure Hypertension. 2001;37:187-193, originally published February 1, 2001.',1),(24,'Food starts to taste better after you give up smoking; your taste and smell senses begin to go back to normal.','1)D. Guido, Simone Perna, M. Carrai, R. Barale, M. Grassi, M. Rondanelli, Multidimensional evaluation of endogenous and health factors affecting food preferences, taste and smell perception, The journal of nutrition, health &amp; aging, 2016. \r\n2) Sungeun Cho, Araceli Camacho, Emily Patten, Denise Costa, Bruno Silva Damiao, Robert Fuller, Luan da Palma, Han-Seok Seo, The Effect of Cigarette Smoking on Chemosensory Perceptionof Common Beverages, Chemosensory Perception, 2016.',1),(25,'Cigarette smoking can cause fertility issues in both sexes.','Smoking and fertility. Your fertility. URL: &lt;http://yourfertility.org.au/for-women/smoking-and-fertility/&gt;. ',1),(26,'Smoking can cause erectile dysfunction.\r\n','Mostafa T. Cigarette smoking and male infertility. Journal of Advanced Research, Volume 1, Issue 3, July 2010, Pages 179–186.',1),(27,'Smokers have poorer immune systems and get sick more often than non-smokers.','Hersey P, Prendergast D, Edwards A. Effects of cigarette smoking on the immune system. Follow-up studies in normal subjects after cessation of smoking. Med J Aust. 1983 Oct 29;2(9):425-9. 2) How Smoking Affects the Immune System, Quitday:&lt;https://quitday.org/smoking-effects/smoking-and-the-immune-system/&gt;.\r\n',1),(28,'Smoking can cause bad breath.','U.S. Department of Health and Human Services. The Health Consequences of Smoking—50 Years of Progress: A Report of the Surgeon General. Atlanta: U.S. Department of Health and Human Services, Centers for Disease Control and Prevention, National Center for Chronic Disease Prevention.',1),(29,'Cigarettes can cause decay and cause your teeth to fall out.','U.S. Department of Health and Human Services. The Health Consequences of Smoking—50 Years of Progress: A Report of the Surgeon General. Atlanta: U.S. Department of Health and Human Services, Centers for Disease Control and Prevention, National Center for Chronic Disease Prevention.',1),(30,'Try the SNAP calculator. How much can you save when you give up smoking?','No smokes: URL: &lt;http://nosmokes.com.au/&gt;.',1),(31,'Would you want to hire someone who took more breaks and got sick more often? Smoking can decrease your chances of getting a job!','Likelihood of Unemployed Smokers vs Nonsmokers Attaining Reemployment in a One-Year Observational Study JAMA INTERNAL MEDICINE Prochaska, J. J., Michalek, A. K., Brown-Johnson, C., Daza, E. J., Baiocchi, M., Anzai, N., Rogers, A., Grigg, M., Chieng, A.2016; 176 (5): 662-670. ',1),(32,'If used exactly as the manufacturer intends, cigarettes will kill the smoker.','&quot;Tobacco Free Initiative (TFI). WHO Report on the Global Tobacco Epidemic, 2008 - The MPOWER package.&quot; World Health Organization. 2009: 15. Web.',1),(33,'In Australia, 2/3 chronic smokers will die from smoking related diseases. ','Quitline. Quit Victoria, Australia 2017. ',1),(34,'Smokers are 3 times more likely to have a stroke than non-smokers.','Smoking and the risk of stroke, Stroke Association. Website: &lt;https://www.stroke.org.uk/sites/default/files/smoking_and_the_risk_of_stroke.pdf&gt;.',1),(35,'Smoking increases your chance of developing hip fractures. ','Steven R. Cummings, Michael C. Nevitt, Warren S. Browner, Katie Stone, Kathleen M. Fox, Kristine E. Ensrud, Jane Cauley,, Dennis Black, and Thomas M. Vogt, Risk factors for hip fracture in white women, for the Study of Osteoporotic Fractures Research Group, The New England Journal of Medicine , March 23, 1995.\r\n',1),(36,'Lung function decreases for everyone over time, but this process occurs earlier and faster amongst smokers.','Letcher, T, Greenhalgh, EM and Winstanley, MH. 3.21 Health effects for younger smokers. In Scollo, MM and Winstanley, MH [editors]. Tobacco in Australia: Facts and issues. Melbourne: Cancer Council Victoria; 2015. Websites:< http://www.tobaccoinaustralia.org.au/3-21-health-effects-for-younger-smokers>.',1),(37,'Young smokers have impaired lung growth.','Letcher, T, Greenhalgh, EM and Winstanley, MH. 3.21 Health effects for younger smokers. In Scollo, MM and Winstanley, MH [editors]. Tobacco in Australia: Facts and issues. Melbourne: Cancer Council Victoria; 2015. Websites:< http://www.tobaccoinaustralia.org.au/3-21-health-effects-for-younger-smokers>.',1),(38,'Smoking can decrease the amount of semen produced. ','Pasqualotto, F. F., Sobreiro, B. P., Hallak, J., Pasqualotto, E. B. and Lucon, A. M, Cigarette smoking is related to a decrease in semen volume in a population of fertile men, 2006. Bju international, 97: 324–326. ',1),(39,'Smoking can decrease the quality of sperm produced. ','Sharma R, Harlev A, Agarwal A, Esteves SC, Cigarette Smoking and Semen Quality: A New Meta-analysis Examining the effect of the 2010 World Health Organization Laboratory Methods for the Examination of Human Semen. \r\nEur Urol. 2016 Apr 21. ',1),(40,'Smoking can cause Rheumatoid Arthritis.','D. Hutchinson, R. Moots, Cigarette smoking and severity of rheumatoid arthritis. Rheumatology (Oxford) 2001; 40 (12): 1426-1427. ',1),(41,'Smokers have a higher risk of developing cirrhosis, where the liver stops functioning as it’s meant to. ','Quitline. Quit Victoria, Australia 2017. ',1),(42,'Smokers are more likely to develop infections after any type of surgery.  ','Quitline. Quit Victoria, Australia 2017. ',1),(43,'Smokers are more likely to have more fat around their gut which increases the risk of heart disease and diabetes. ','Quitline. Quit Victoria, Australia 2017. ',1),(44,'Cigarettes contain tar which is used in the paving of roads. ','Smoking Facts: What\'s in a cigarette? American Lung Association, Website:< http://www.lung.org/stop-smoking/smoking-facts/whats-in-a-cigarette.html>.',1),(45,'Cigarettes contain Butane which is used to make lighter fluid. ','Smoking Facts: What\'s in a cigarette? American Lung Association, Website:< http://www.lung.org/stop-smoking/smoking-facts/whats-in-a-cigarette.html>.',1),(46,'Cigarettes contain Acetic Acid which used in hair dye. ','Smoking Facts: What\'s in a cigarette? American Lung Association, Website:< http://www.lung.org/stop-smoking/smoking-facts/whats-in-a-cigarette.html>.',1),(47,'An average male smoker loses 13.2 years of their lives due to smoking.','Annual Smoking-Attributable Mortality, Years of Potential Life Lost, and Economic Costs --- United States, 1995--1999, April 12, 2002 / 51(14);300-3, CDC, https://www.cdc.gov/mmwr/preview/mmwrhtml/mm5114a2.htm.',1),(48,'An average female smoker loses 14.5 years of their lives due to smoking.','Annual Smoking-Attributable Mortality, Years of Potential Life Lost, and Economic Costs --- United States, 1995--1999, April 12, 2002 / 51(14);300-3, CDC, https://www.cdc.gov/mmwr/preview/mmwrhtml/mm5114a2.htm.',1),(49,'Smoking increases your risk of developing dementia.\r\n','Letcher, T, Greenhalgh, EM and Winstanley, MH. 3.21 Health effects for younger smokers. In Scollo, MM and Winstanley, MH [editors]. Tobacco in Australia: Facts and issues. Melbourne: Cancer Council Victoria; 2015. Websites:< http://www.tobaccoinaustralia.org.au/3-21-health-effects-for-younger-smokers>.',1),(50,'Nicotine is as addictive as heroin, cocaine and alcohol.','International Symposium on Nicotine: The Effects of Nicotine on Biological Systems II.\" Google Books. Ed. Clarke, P.B.S., et al., 1994. Web.',1),(51,'Passive smoking kills 113 people every day. \r\n','The Health Consequences of Smoking—50 Years of Progress. A Report of the Surgeon General.\" U.S. Department of Health and Human Services, Centers for Disease Control and Prevention, National Center for Chronic Disease Prevention and Health Promotion, Office on Smoking and Health. Smoking-Attributable Morbidity, Mortality, and Economic Costs, 2014. Report.',1);
/*!40000 ALTER TABLE `snap_fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `StudentID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Nickname` text DEFAULT NULL,
  `FirstName` text DEFAULT NULL,
  `LastName` text DEFAULT NULL,
  `Password` text NOT NULL,
  `Email` text DEFAULT NULL,
  `Gender` text DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Identity` text DEFAULT NULL,
  `Score` mediumint(9) DEFAULT 0,
  `SubmissionTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `ClassID` mediumint(9) NOT NULL,
  `isLocked` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`StudentID`),
  KEY `Student_ClassID_FK` (`ClassID`),
  CONSTRAINT `Student_ClassID_FK` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'Fernando',NULL,'Fernando','Trump','d59324e4d5acb950c4022cd5df834cc3','fernado@gmail.com','Male','2003-10-20','Resident',0,'2017-10-03 14:56:19',1,0),(2,'Todd',NULL,'Todd','Webb','d59324e4d5acb950c4022cd5df834cc3','toddyy@gmail.com','Male','2003-11-20','Aboriginal',16,'2016-06-02 18:48:43',1,0),(3,'Theresa',NULL,'Theresa','Rios','d59324e4d5acb950c4022cd5df834cc3','theresa03@gmail.com','Female','2003-12-20','Aboriginal',0,'2016-06-03 18:48:43',1,0),(4,'Hai',NULL,'Hai','Lam','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-22','Aboriginal',0,'2016-06-01 18:49:43',1,0),(5,'Lee',NULL,'Lee','Malone','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-24','Aboriginal',0,'2016-06-07 18:48:43',1,0),(6,'Tim',NULL,'Tim','Mason','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-25','Resident',0,'2016-06-11 18:48:43',1,0),(7,'Clinton',NULL,'Clinton','Snyder','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-28','Resident',0,'2017-10-03 14:56:19',1,0),(8,'Elbert',NULL,'Elbert','Chapman','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-22','Resident',0,'2016-06-05 18:48:43',1,0),(9,'Ervin',NULL,'Ervin','Murray','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-11-20','Resident',0,'2017-10-03 14:56:19',1,0),(10,'Sheila',NULL,'Sheila','Frank','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Aboriginal',0,'2017-10-03 14:56:19',1,0),(11,'Grace',NULL,'Grace','Austin','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-29','Resident',0,'2017-10-03 14:56:19',1,0),(12,'Ruby',NULL,'Ruby','Chavez','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2016-06-05 18:48:43',1,0),(13,'Sonya',NULL,'Sonya','Kelly','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-10-03 14:56:19',1,0),(14,'Donna',NULL,'Donna','Pratt','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-10-03 14:56:19',1,0),(15,'Stacy',NULL,'Stacy','Figueroa','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-10-03 14:56:19',1,0),(16,'Fannie',NULL,'Fannie','Waters','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-28','Aboriginal',0,'2016-06-01 18:48:42',1,0),(17,'June',NULL,'June','West','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Aboriginal',0,'2017-10-03 14:56:19',1,0),(18,'Melinda',NULL,'Melinda','Kelley','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-10-03 14:56:19',1,0),(19,'Leo',NULL,'Leo','Potter','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-22','Resident',0,'2017-10-03 14:56:19',1,0),(20,'Hector',NULL,'Hector','Byrd','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-20','Resident',0,'2017-10-03 14:56:19',1,0),(21,'Otis',NULL,'Otis','Lawrence','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-20','Aboriginal',16,'2017-10-03 14:56:19',2,0),(22,'Cassandra',NULL,'Cassandra','James','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2002-04-20','Aboriginal',0,'2017-10-03 14:56:19',2,0),(23,'Marilyn',NULL,'Marilyn','Ryan','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2002-04-20','Aboriginal',0,'2017-10-03 14:56:19',1,0);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_week_record`
--

DROP TABLE IF EXISTS `student_week_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_week_record` (
  `StudentID` mediumint(9) NOT NULL DEFAULT 0,
  `Week` mediumint(9) NOT NULL DEFAULT 0,
  `DueTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`StudentID`,`Week`),
  CONSTRAINT `Student_Week_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_week_record`
--

LOCK TABLES `student_week_record` WRITE;
/*!40000 ALTER TABLE `student_week_record` DISABLE KEYS */;
INSERT INTO `student_week_record` VALUES (2,1,'2017-10-04 10:59:01'),(2,2,'2017-10-04 13:59:49'),(2,3,'2017-10-04 13:57:43'),(21,5,'2017-10-04 12:08:55'),(21,6,'2017-10-04 12:08:37'),(21,7,'2017-10-31 14:23:49'),(22,1,'2017-10-24 10:01:53'),(22,2,'2017-10-24 10:03:01');
/*!40000 ALTER TABLE `student_week_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `TopicID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `TopicName` varchar(190) DEFAULT NULL,
  PRIMARY KEY (`TopicID`),
  UNIQUE KEY `TopicName` (`TopicName`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES (3,'Alcohol'),(5,'Drugs'),(7,'Health and Wellbeing'),(2,'Nutrition'),(4,'Physical Activity'),(6,'Sexual Health'),(1,'Smoking');
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verbose_fact`
--

DROP TABLE IF EXISTS `verbose_fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verbose_fact` (
  `VerboseFactID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Title` text DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `TopicID` mediumint(9) NOT NULL,
  PRIMARY KEY (`VerboseFactID`),
  KEY `Verbose_Fact_Topic_FK` (`TopicID`),
  CONSTRAINT `Verbose_Fact_Topic_FK` FOREIGN KEY (`TopicID`) REFERENCES `topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verbose_fact`
--

LOCK TABLES `verbose_fact` WRITE;
/*!40000 ALTER TABLE `verbose_fact` DISABLE KEYS */;
INSERT INTO `verbose_fact` VALUES (1,'Short Term Effects of Smoking','Short Term Effects of Smoking Content...',1),(2,'Emphysema','Emphysema is a long-term, progressive disease of the lungs that primarily causes shortness of breath due to over-inflation of the alveoli (air sacs in the lung). In people with emphysema, the lung tissue involved in exchange of gases (oxygen and carbon dioxide) is impaired or destroyed. Emphysema is included in a group of diseases called chronic obstructive pulmonary disease or COPD (pulmonary refers to the lungs).\nEmphysema is called an obstructive lung disease because airflow on exhalation is slowed or stopped because over-inflated alveoli do not exchange gases when a person breaths due to little or no movement of gases out of the alveoli.\nEmphysema changes the anatomy of the lung in several important ways. This is due to in part to the destruction of lung tissue around smaller airways. This tissue normally holds these small airways, called bronchioles, open, allowing air to leave the lungs on exhalation. When this tissue is damaged, these airways collapse, making it difficult for the lungs to empty and the air (gases) becomes trapped in the alveoli.\nNormal lung tissue looks like a new sponge. Emphysematous lung looks like an old used sponge, with large holes and a dramatic loss of “springy-nessor elasticity. When the lung is stretched during inflation (inhalation), the nature of the stretched tissue wants to relax to its resting state. In emphysema, this elastic function is impaired, resulting in air trapping in the lungs. Emphysema destroys this spongy tissue of the lung and also severely affects the small blood vessels (capillaries of the lung) and airways that run throughout the lung. Thus, not only is airflow affected but so is blood flow. This has dramatic impact on the ability for the lung not only to empty its air sacs called alveoli (pleural for alveolus) but also for blood to flow through the lungs to receive oxygen.',1),(3,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(4,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(5,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(6,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(7,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(8,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(9,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(10,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(11,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(12,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(13,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(14,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1);
/*!40000 ALTER TABLE `verbose_fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `week`
--

DROP TABLE IF EXISTS `week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `week` (
  `WeekID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Timer` mediumint(9) DEFAULT 1,
  `WeekNum` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`WeekID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `week`
--

LOCK TABLES `week` WRITE;
/*!40000 ALTER TABLE `week` DISABLE KEYS */;
INSERT INTO `week` VALUES (1,2,1),(2,3,2),(3,1,3),(4,10,4),(5,5,6),(6,4,7),(7,1,5),(8,1,8),(9,1,9);
/*!40000 ALTER TABLE `week` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-15 14:58:49
