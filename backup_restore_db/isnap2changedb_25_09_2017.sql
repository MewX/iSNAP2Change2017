-- MySQL dump 10.16  Distrib 10.2.7-MariaDB, for osx10.12 (x86_64)
--
-- Host: localhost    Database: isnap2changedb
-- ------------------------------------------------------
-- Server version	10.2.7-MariaDB

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
-- Table structure for table `Class`
--

DROP TABLE IF EXISTS `Class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Class` (
  `ClassID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `ClassName` varchar(190) NOT NULL,
  `SchoolID` mediumint(9) NOT NULL,
  `TokenString` varchar(100) NOT NULL,
  `UnlockedProgress` mediumint(9) NOT NULL DEFAULT 10,
  PRIMARY KEY (`ClassID`),
  UNIQUE KEY `ClassName` (`ClassName`),
  UNIQUE KEY `TokenString` (`TokenString`),
  KEY `Class_SchoolID_FK` (`SchoolID`),
  CONSTRAINT `Class_SchoolID_FK` FOREIGN KEY (`SchoolID`) REFERENCES `School` (`SchoolID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Class`
--

LOCK TABLES `Class` WRITE;
/*!40000 ALTER TABLE `Class` DISABLE KEYS */;
INSERT INTO `Class` VALUES (1,'Sample Class 1A',1,'TOKENSTRING01',3),(2,'Sample Class 1B',1,'TOKENSTRING02',10),(3,'Sample Class 1C',1,'TOKENSTRING03',10),(4,'Sample Class 2C',2,'TOKENSTRING04',10);
/*!40000 ALTER TABLE `Class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `content` longtext NOT NULL,
  `readOrNot` tinyint(1) DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

LOCK TABLES `Comments` WRITE;
/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` VALUES (1,'Amos','i@mewx.org','This is an initial message for testing propose',0,'2017-09-25 00:47:23');
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Game`
--

DROP TABLE IF EXISTS `Game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Game` (
  `GameID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Description` text NOT NULL,
  `Levels` mediumint(9) NOT NULL,
  PRIMARY KEY (`GameID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Game`
--

LOCK TABLES `Game` WRITE;
/*!40000 ALTER TABLE `Game` DISABLE KEYS */;
INSERT INTO `Game` VALUES (1,'Fruit Ninja',5),(2,'Candy Crush',50);
/*!40000 ALTER TABLE `Game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Game_Record`
--

DROP TABLE IF EXISTS `Game_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Game_Record` (
  `GameID` mediumint(9) NOT NULL,
  `StudentID` mediumint(9) NOT NULL,
  `Level` mediumint(9) NOT NULL DEFAULT 0,
  `Score` int(11) DEFAULT NULL,
  PRIMARY KEY (`GameID`,`StudentID`,`Level`),
  KEY `Game_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `Game_Record_GameID_FK` FOREIGN KEY (`GameID`) REFERENCES `Game` (`GameID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Game_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Game_Record`
--

LOCK TABLES `Game_Record` WRITE;
/*!40000 ALTER TABLE `Game_Record` DISABLE KEYS */;
INSERT INTO `Game_Record` VALUES (1,1,1,5),(1,1,2,40),(1,2,1,30),(1,3,1,30),(1,4,1,30),(2,2,1,35),(2,3,1,30),(2,4,1,30),(2,5,1,40);
/*!40000 ALTER TABLE `Game_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Learning_Material`
--

DROP TABLE IF EXISTS `Learning_Material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Learning_Material` (
  `QuizID` mediumint(9) NOT NULL,
  `Content` longtext DEFAULT NULL,
  `Excluded` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Learning_Material_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Learning_Material`
--

LOCK TABLES `Learning_Material` WRITE;
/*!40000 ALTER TABLE `Learning_Material` DISABLE KEYS */;
INSERT INTO `Learning_Material` VALUES (1,'<p>Eating a balanced diet is vital for your health and wellbeing. The food we eat is responsible for providing us with the energy to do all the tasks of daily life. For optimum performance and growth a balance of protein, essential fats, vitamins and minerals are required. We need a wide variety of different foods to provide the right amounts of nutrients for good health. The different types of food and how much of it you should be aiming to eat is demonstrated on the pyramid below. (my own words)</p>\n<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"https://cmudream.files.wordpress.com/2016/05/0.jpg\" alt=\"\" width=\"632\" height=\"884\" /></p>\n<p>There are three main layers of the food pyramid. The bottom layer is the most important one for your daily intake of food. It contains vegetables, fruits, grains and legumes. You should be having most of your daily food from this layer. These foods are all derived or grow on plants and contain important nutrients such as vitamins, minerals and antioxidants. They are also responsible for being the main contributor of carbohydrates and fibre to our diet.<br />The middle layer is comprised of dairy based products such as milk, yoghurt, cheese. These are essential to providing our bodies with calcium and protein and important vitamins and minerals.<br />They layer also contains lean meat, poultry, fish, eggs, nuts, seeds, legumes. These foods are our main source of protein and are also responsible for providing other nutrients to us including iodine, iron, zinc, B12 vitamins and healthy fats.<br />The top layer, which is the smallest layer, is the layer you should me eating the least off. This layer is made up of food which has unsaturated fats such as sugar, butter, margarine and oils; small amounts of these unsaturated fats are needed for healthy brain and hear function.<br />(my own words)<br />Source: The Healthy Living Pyramid. Nutrition Australia. [Accessed 28/04/2016 http://www.nutritionaustralia.org/national/resource/healthy-living-pyramid]</p>',0),(2,'\n<p>Learning materials for week 1...</p>',1),(3,'<p><iframe src=\"//www.youtube.com/embed/UQ0hFLUiHTg?autoplay=1&amp;start=60&amp;end=70&amp;rel=0&quot;\" width=\"560\" height=\"314\" allowfullscreen=\"allowfullscreen\"></iframe></p>',-1),(4,'\n<p>Learning material for this quiz has not been added.</p>',0),(5,'\n<p>Learning material for this quiz has not been added.</p>',1),(6,'\n<p>Learning material for this quiz has not been added.</p>',0),(7,'\n<p>Nutrition: All over the world people suffer from illnesses that are caused by eating the wrong food or not having enough to eat. In developing countries deficiency diseases arise when people do not get the right nutrients. Conversely, overconsumption of foods rich in fat and cholesterols can lead to heart diseases, obesity, strokes and cancer. (Own words)</p>',0),(8,'\n<p>Learning material for this quiz has not been added.</p>',0),(9,'<p>Learning material for this quiz has not been added.</p>',0),(10,'<p>Learning material for this quiz has not been added.</p>',1),(11,'<p>Do you know what a standard drink is? (If no, go to the SNAP² Facts page)</p><p>What is the standard amount of alcohol recommended by the National Health and Medical Research Council (NHMRC) to drink in a day? (You need to go to the iSNAPs facts page for this)</p><p>Alcoholic beverages are sold and served in many different sized containers. Different types of beverages contain different amounts of alcohol, and glass sizes are often not the same. A glass or container can hold more than one standard drink of alcohol. This can make it difficult to know how many standard drinks you consume.</p><p>Using standard drinks to measure your alcohol consumption is more accurate than counting the number of glasses or other containers you have consumed. If you are drinking packaged liquor the number of standard drinks should be written on the side of the beverage container.</p>',0);
/*!40000 ALTER TABLE `Learning_Material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MCQ_Attempt_Record`
--

DROP TABLE IF EXISTS `MCQ_Attempt_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MCQ_Attempt_Record` (
  `QuizID` mediumint(9) NOT NULL,
  `StudentID` mediumint(9) NOT NULL,
  `Attempt` mediumint(9) DEFAULT 0,
  `HighestGrade` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`,`StudentID`),
  KEY `MCQ_Attempt_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `MCQ_Attempt_Record_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Attempt_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MCQ_Attempt_Record`
--

LOCK TABLES `MCQ_Attempt_Record` WRITE;
/*!40000 ALTER TABLE `MCQ_Attempt_Record` DISABLE KEYS */;
INSERT INTO `MCQ_Attempt_Record` VALUES (1,2,3,5);
/*!40000 ALTER TABLE `MCQ_Attempt_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MCQ_Option`
--

DROP TABLE IF EXISTS `MCQ_Option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MCQ_Option` (
  `OptionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `Explanation` text DEFAULT NULL,
  `MCQID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`OptionID`),
  KEY `MCQ_Option_MCQID_FK` (`MCQID`),
  CONSTRAINT `MCQ_Option_MCQID_FK` FOREIGN KEY (`MCQID`) REFERENCES `MCQ_Question` (`MCQID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MCQ_Option`
--

LOCK TABLES `MCQ_Option` WRITE;
/*!40000 ALTER TABLE `MCQ_Option` DISABLE KEYS */;
INSERT INTO `MCQ_Option` VALUES (1,'Candy bar','Candy bars will give you an instant burst of energy but will not last!',1),(2,'Whole grain cereal or oatmeal','Whole grains take your body longer to digest, giving you energy all morning!',1),(3,'Potato chips','Whole grains take your body longer to digest, giving you energy all morning!',1),(4,'Fruits and veggies','Get munching on carrots, apples, and other tasty fresh foods! The veggies and fruits should take up at least half of your plate.',2),(5,'Meats','Get munching on carrots, apples, and other tasty fresh foods! The veggies and fruits should take up at least half of your plate.',2),(6,'Grains','Get munching on carrots, apples, and other tasty fresh foods! The veggies and fruits should take up at least half of your plate.',2),(7,'Feed it to your dog.','Not everyone likes broccoli. But there are so many different kinds of vegetables, you are bound to find one you like!',3),(8,'Give up on eating vegetables.','Not everyone likes broccoli. But there are so many different kinds of vegetables, you are bound to find one you like!',3),(9,'Give peas a chance!','Not everyone likes broccoli. But there are so many different kinds of vegetables, you are bound to find one you like!',3),(10,'No fast food, ever.','Eating healthy doesn\'t mean cutting out ALL fried foods. Foods like French fries are ok if you eat a small amount once or twice a month.',4),(11,'No, but American fries are ok.','Eating healthy doesn\'t mean cutting out ALL fried foods. Foods like French fries are ok if you eat a small amount once or twice a month.',4),(12,'Sure, just not every day.','Eating healthy doesn\'t mean cutting out ALL fried foods. Foods like French fries are ok if you eat a small amount once or twice a month.',4),(13,'Potato chips and soda.','Eating healthy snacks is important. Snacks give you energy and help you feel full so you don\'t overeat at dinner.',5),(14,'An apple, cheese, and whole grain crackers.','Eating healthy snacks is important. Snacks give you energy and help you feel full so you don\'t overeat at dinner.',5),(15,'A doughnut or a brownie.','Eating healthy snacks is important. Snacks give you energy and help you feel full so you don\'t overeat at dinner.',5),(16,'1 to 2 cups of veggies and 1 to 2 pieces of fruit every day.','Fortunately, there are so many types of fruits and vegetables that you\'ll never get bored!',6),(17,'Eat veggies or fruit once a month.','Fortunately, there are so many types of fruits and vegetables that you\'ll never get bored!',6),(18,'At least 100 cups a day.','Fortunately, there are so many types of fruits and vegetables that you\'ll never get bored!',6),(19,'Bread','Calcium is important for building bones. You can get your daily dose from a variety of foods, including yogurt, milk, and almonds.',7),(20,'Yogurt','Calcium is important for building bones. You can get your daily dose from a variety of foods, including yogurt, milk, and almonds.',7),(21,'Apples','Calcium is important for building bones. You can get your daily dose from a variety of foods, including yogurt, milk, and almonds.',7),(22,'White rice','Eating foods that have fiber helps with digestion and keeps you from getting hungry too soon.',8),(23,'Pasta','Eating foods that have fiber helps with digestion and keeps you from getting hungry too soon.',8),(24,'Beans and apples','Eating foods that have fiber helps with digestion and keeps you from getting hungry too soon.',8),(25,'Milk','You should drink 6-8 cups of water a day. Cheers!',9),(26,'Water','You should drink 6-8 cups of water a day. Cheers!',9),(27,'Orange Juice','You should drink 6-8 cups of water a day. Cheers!',9),(28,'Knees','Wrong',10),(29,'Fingers','Wrong',10),(30,'Chest','Wrong',10),(31,'Brain','Correct',10),(32,'A person being involved in anti-social behaviour.','Wrong',11),(33,'Injury due to falls, burns, car crashes.','Wrong',11),(34,'Violence and fighting.','Wrong',11),(35,'All of the above.','Correct',11),(36,'Their  blood alcohol content (BAC) decreases.','Wrong',12),(37,'Their blood alcohol content (BAC) increases.','Correct',12),(38,'Their blood alcohol content (BAC) remains the same','Wrong',12),(39,'Their blood alcohol content (BAC) reduces to zero','Wrong',12),(40,'Drug that has no effects on you.','Wrong',13),(41,'Drug that targets the brain.','Correct',13),(42,'Drug that you do not need to worry about.','Wrong',13),(43,'Drug that does not affect your behaviour.','Wrong',13),(44,'Blood','Wrong',14),(45,'Heart','Wrong',14),(46,'Liver','Correct',14),(47,'Kidney','Wrong',14),(48,'1','Correct',15),(49,'1','Wrong',16),(50,'2','Correct',16),(51,'1','Wrong',17),(52,'2','Correct',17),(53,'3','Wrong',17),(54,'1','Wrong',18),(55,'2','Wrong',18),(56,'3','Wrong',18),(57,'4','Correct',18),(58,'1','Wrong',19),(59,'2','Wrong',19),(60,'3','Wrong',19),(61,'4','Wrong',19),(62,'5','Correct',19);
/*!40000 ALTER TABLE `MCQ_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MCQ_Question`
--

DROP TABLE IF EXISTS `MCQ_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MCQ_Question` (
  `MCQID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text DEFAULT NULL,
  `CorrectChoice` mediumint(9) DEFAULT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`MCQID`),
  KEY `MCQ_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `MCQ_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `MCQ_Section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MCQ_Question`
--

LOCK TABLES `MCQ_Question` WRITE;
/*!40000 ALTER TABLE `MCQ_Question` DISABLE KEYS */;
INSERT INTO `MCQ_Question` VALUES (1,'Which of these breakfast foods will provide you with the most energy?',2,1),(2,'Which type of food should take up the most space on your plate?',4,1),(3,'What should I do if I hate broccoli?',9,1),(4,'If I want to stay healthy, can I still eat French fries?',12,1),(5,'What\'s a nutritious afterschool snack?',14,1),(6,'How much veggies and fruit should you eat daily?',16,1),(7,'Which of these foods is the best source of calcium?',20,1),(8,'Which of these foods has lots of fiber?',24,1),(9,'What should you drink the most of each day?',26,1),(10,'Alcohol has an immediate effect on the:',31,2),(11,'Alcohol increases the risk of:',35,2),(12,'When a person continues to drink:',37,2),(13,'Alcohol is a:',41,2),(14,'Alcohol is broken down by:',46,2),(15,'1 option:',48,10),(16,'2 option',50,10),(17,'3 option',53,10),(18,'4 option',57,10),(19,'5 option',62,10);
/*!40000 ALTER TABLE `MCQ_Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MCQ_Question_Record`
--

DROP TABLE IF EXISTS `MCQ_Question_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MCQ_Question_Record` (
  `StudentID` mediumint(9) NOT NULL,
  `MCQID` mediumint(9) NOT NULL,
  `Choice` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`StudentID`,`MCQID`),
  KEY `MCQ_Question_Record_MCQID_FK` (`MCQID`),
  KEY `MCQ_Question_Record_Choice_FK` (`Choice`),
  CONSTRAINT `MCQ_Question_Record_Choice_FK` FOREIGN KEY (`Choice`) REFERENCES `MCQ_Option` (`OptionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Question_Record_MCQID_FK` FOREIGN KEY (`MCQID`) REFERENCES `MCQ_Question` (`MCQID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MCQ_Question_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MCQ_Question_Record`
--

LOCK TABLES `MCQ_Question_Record` WRITE;
/*!40000 ALTER TABLE `MCQ_Question_Record` DISABLE KEYS */;
INSERT INTO `MCQ_Question_Record` VALUES (2,6,NULL),(2,7,NULL),(2,8,NULL),(2,9,NULL),(2,1,2),(2,2,4),(2,3,9),(2,4,12),(2,5,14);
/*!40000 ALTER TABLE `MCQ_Question_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MCQ_Section`
--

DROP TABLE IF EXISTS `MCQ_Section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MCQ_Section` (
  `QuizID` mediumint(9) NOT NULL,
  `Points` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `MCQ_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MCQ_Section`
--

LOCK TABLES `MCQ_Section` WRITE;
/*!40000 ALTER TABLE `MCQ_Section` DISABLE KEYS */;
INSERT INTO `MCQ_Section` VALUES (1,30),(2,20),(6,30),(10,20);
/*!40000 ALTER TABLE `MCQ_Section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matching_Option`
--

DROP TABLE IF EXISTS `Matching_Option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matching_Option` (
  `OptionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text NOT NULL,
  `MatchingID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`OptionID`),
  KEY `Matching_Option_MatchingID_FK` (`MatchingID`),
  CONSTRAINT `Matching_Option_MatchingID_FK` FOREIGN KEY (`MatchingID`) REFERENCES `Matching_Question` (`MatchingID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matching_Option`
--

LOCK TABLES `Matching_Option` WRITE;
/*!40000 ALTER TABLE `Matching_Option` DISABLE KEYS */;
INSERT INTO `Matching_Option` VALUES (1,'A disease that occurs if your body doesn’t get enough proteins',1),(2,'Occurs in young children who don’t get enough calories every day',2),(3,'Caused by a lack of vitamin C',3),(4,'This condition is brought on by a lack of vitamin D',4),(5,'Caused by the deficiency of vitamin B1 (thiamine) ',5),(6,'Beef',6),(7,'Meat',6),(8,'Lamb',6),(9,'Pork',6),(10,'Chips',7),(11,'Nuts',7),(12,'Cookie',7),(13,'Orange',8),(14,'Apple',8),(15,'Fish',9),(16,'Cake',9),(17,'Rice',10);
/*!40000 ALTER TABLE `Matching_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matching_Question`
--

DROP TABLE IF EXISTS `Matching_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matching_Question` (
  `MatchingID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`MatchingID`),
  KEY `Matching_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `Matching_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Matching_Section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matching_Question`
--

LOCK TABLES `Matching_Question` WRITE;
/*!40000 ALTER TABLE `Matching_Question` DISABLE KEYS */;
INSERT INTO `Matching_Question` VALUES (1,'Kwashiorkor',7),(2,'Marasmus',7),(3,'Scurvy',7),(4,'Rickets',7),(5,'Beriberi',7),(6,'Protein',8),(7,'Fat',8),(8,'Vitamin',8),(9,'Minerals',8),(10,'Carbohydrate',8);
/*!40000 ALTER TABLE `Matching_Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matching_Section`
--

DROP TABLE IF EXISTS `Matching_Section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matching_Section` (
  `QuizID` mediumint(9) NOT NULL,
  `Description` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Matching_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matching_Section`
--

LOCK TABLES `Matching_Section` WRITE;
/*!40000 ALTER TABLE `Matching_Section` DISABLE KEYS */;
INSERT INTO `Matching_Section` VALUES (7,'Match the diseases to the causes. You may have to do some research on other websites to find out the answers.',20),(8,'Classify the lists of foods into the 5 main food groups',20);
/*!40000 ALTER TABLE `Matching_Section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Misc_Section`
--

DROP TABLE IF EXISTS `Misc_Section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Misc_Section` (
  `QuizID` mediumint(9) NOT NULL,
  `QuizSubType` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Misc_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Misc_Section`
--

LOCK TABLES `Misc_Section` WRITE;
/*!40000 ALTER TABLE `Misc_Section` DISABLE KEYS */;
INSERT INTO `Misc_Section` VALUES (5,'Calculator',20),(11,'DrinkingTool',30);
/*!40000 ALTER TABLE `Misc_Section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poster_Record`
--

DROP TABLE IF EXISTS `Poster_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Poster_Record` (
  `QuizID` mediumint(9) NOT NULL,
  `StudentID` mediumint(9) NOT NULL,
  `ZwibblerDoc` longtext DEFAULT NULL,
  `ImageURL` longtext DEFAULT NULL,
  `Grading` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`,`StudentID`),
  CONSTRAINT `Poster_Record_StudentID_QuizID_FK` FOREIGN KEY (`QuizID`, `StudentID`) REFERENCES `Quiz_Record` (`QuizID`, `StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poster_Record`
--

LOCK TABLES `Poster_Record` WRITE;
/*!40000 ALTER TABLE `Poster_Record` DISABLE KEYS */;
/*!40000 ALTER TABLE `Poster_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poster_Section`
--

DROP TABLE IF EXISTS `Poster_Section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Poster_Section` (
  `QuizID` mediumint(9) NOT NULL,
  `Title` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `Poster_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poster_Section`
--

LOCK TABLES `Poster_Section` WRITE;
/*!40000 ALTER TABLE `Poster_Section` DISABLE KEYS */;
INSERT INTO `Poster_Section` VALUES (9,'Create a Future Board','What would you linke to achieve this school term? Make board with pictures of what you would like to achieve and the people and things that inspire you and whtat you aspire to be. You can also put down things about yourself that you would like to improve on. If you would feel more comvortable using words or pictures that only you know what they mean, you can . After all, some goals are personal.',20),(12,'Create a Future Board','What would you linke to achieve this school term? Make board with pictures of what you would like to achieve and the people and things that inspire you and whtat you aspire to be. You can also put down things about yourself that you would like to improve on. If you would feel more comvortable using words or pictures that only you know what they mean, you can . After all, some goals are personal.',20);
/*!40000 ALTER TABLE `Poster_Section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Public_Question`
--

DROP TABLE IF EXISTS `Public_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Public_Question` (
  `QuestionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Email` text NOT NULL,
  `Content` mediumint(9) NOT NULL,
  `Solved` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`QuestionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Public_Question`
--

LOCK TABLES `Public_Question` WRITE;
/*!40000 ALTER TABLE `Public_Question` DISABLE KEYS */;
/*!40000 ALTER TABLE `Public_Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Quiz`
--

DROP TABLE IF EXISTS `Quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Quiz` (
  `QuizID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Week` mediumint(9) DEFAULT NULL,
  `QuizType` enum('SAQ','MCQ','Matching','Poster','Misc') DEFAULT NULL,
  `ExtraQuiz` tinyint(1) DEFAULT 0,
  `TopicID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  KEY `Quiz_TopicID_FK` (`TopicID`),
  CONSTRAINT `Quiz_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `Topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Quiz`
--

LOCK TABLES `Quiz` WRITE;
/*!40000 ALTER TABLE `Quiz` DISABLE KEYS */;
INSERT INTO `Quiz` VALUES (1,1,'MCQ',0,2),(2,1,'MCQ',0,5),(3,1,'SAQ',1,1),(4,3,'SAQ',0,4),(5,6,'Misc',0,3),(6,6,'MCQ',1,3),(7,6,'Matching',0,2),(8,7,'Matching',0,2),(9,2,'Poster',0,3),(10,1,'MCQ',1,5),(11,2,'Misc',0,3),(12,4,'Poster',0,3);
/*!40000 ALTER TABLE `Quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Quiz_Record`
--

DROP TABLE IF EXISTS `Quiz_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Quiz_Record` (
  `QuizID` mediumint(9) NOT NULL,
  `StudentID` mediumint(9) NOT NULL,
  `Status` enum('UNSUBMITTED','UNGRADED','GRADED') DEFAULT 'GRADED',
  `Viewed` tinyint(1) DEFAULT 0,
  `Grade` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`QuizID`,`StudentID`),
  KEY `Quiz_Record_StudentID_FK` (`StudentID`),
  CONSTRAINT `Quiz_Record_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Quiz_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Quiz_Record`
--

LOCK TABLES `Quiz_Record` WRITE;
/*!40000 ALTER TABLE `Quiz_Record` DISABLE KEYS */;
INSERT INTO `Quiz_Record` VALUES (1,2,'GRADED',0,5),(1,3,'GRADED',0,0),(1,4,'GRADED',0,0),(1,5,'GRADED',0,0),(1,6,'GRADED',0,0),(2,2,'GRADED',0,0),(2,3,'GRADED',0,0),(2,4,'GRADED',0,0),(2,5,'GRADED',0,0),(2,6,'GRADED',0,0),(3,1,'GRADED',0,0);
/*!40000 ALTER TABLE `Quiz_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipe`
--

DROP TABLE IF EXISTS `Recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipe` (
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
-- Dumping data for table `Recipe`
--

LOCK TABLES `Recipe` WRITE;
/*!40000 ALTER TABLE `Recipe` DISABLE KEYS */;
INSERT INTO `Recipe` VALUES (1,'Eggplant Parmesan Pizza','http://www.eatingwell.com/recipes_menus/recipe_slideshows/vegetarian_pizza_recipes?slide=1#leaderboardad','Main Meal',15,20,4,NULL);
/*!40000 ALTER TABLE `Recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipe_Ingredient`
--

DROP TABLE IF EXISTS `Recipe_Ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipe_Ingredient` (
  `IngredientID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`IngredientID`),
  KEY `Recipe_Ingredient_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Ingredient_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `Recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipe_Ingredient`
--

LOCK TABLES `Recipe_Ingredient` WRITE;
/*!40000 ALTER TABLE `Recipe_Ingredient` DISABLE KEYS */;
INSERT INTO `Recipe_Ingredient` VALUES (1,'1 small eggplant, (about 12 ounces)',1),(2,'Yellow cornmeal, for dusting',1),(3,'1 pound Easy Whole-Wheat Pizza Dough, or other prepared dough (recipe follows)',1),(4,'3/4 cup prepared marinara sauce',1),(5,'2 tablespoons chopped fresh basil',1),(6,'1 medium clove garlic, minced medium clove garlic, minced',1),(7,'3/4 cup thinly shaved Parmigiano-Reggiano cheese, (see Tip)',1);
/*!40000 ALTER TABLE `Recipe_Ingredient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipe_Nutrition`
--

DROP TABLE IF EXISTS `Recipe_Nutrition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipe_Nutrition` (
  `NutritionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `NutritionName` text DEFAULT NULL,
  `MeasurementUnit` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`NutritionID`),
  KEY `Recipe_Nutrition_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Nutrition_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `Recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipe_Nutrition`
--

LOCK TABLES `Recipe_Nutrition` WRITE;
/*!40000 ALTER TABLE `Recipe_Nutrition` DISABLE KEYS */;
INSERT INTO `Recipe_Nutrition` VALUES (1,'calories','359',1),(2,'fat','7 g',1),(3,'cholesterol','12 mg',1),(4,'carbohydrates','59 g',1),(5,'protein','16 g',1),(6,'fiber','9 g',1),(7,'sodium','713 mg',1),(8,'potassium','416 mg',1);
/*!40000 ALTER TABLE `Recipe_Nutrition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recipe_Step`
--

DROP TABLE IF EXISTS `Recipe_Step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recipe_Step` (
  `StepID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Description` text DEFAULT NULL,
  `RecipeID` mediumint(9) NOT NULL,
  PRIMARY KEY (`StepID`),
  KEY `Recipe_Step_RecipeID_FK` (`RecipeID`),
  CONSTRAINT `Recipe_Step_RecipeID_FK` FOREIGN KEY (`RecipeID`) REFERENCES `Recipe` (`RecipeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recipe_Step`
--

LOCK TABLES `Recipe_Step` WRITE;
/*!40000 ALTER TABLE `Recipe_Step` DISABLE KEYS */;
INSERT INTO `Recipe_Step` VALUES (1,'Preheat grill to medium-high. (For charcoal grilling or an oven variation, see below.)',1),(2,'Cut eggplant into 1/2-inch thick rounds. Grill, turning once, until marked and softened, 4 to 6 minutes. Let cool slightly, then thinly slice into strips. Reduce heat to low.',1),(3,'Sprinkle cornmeal onto a pizza peel or large baking sheet. Roll out the dough (see Tip) and transfer it to the prepared peel or baking sheet, making sure the underside of the dough is completely coated with cornmeal.',1),(4,'Slide the crust onto the grill rack; close the lid. Cook until lightly browned, 3 to 4 minutes.',1),(5,'Using a large spatula, flip the crust. Spread marinara sauce on the crust, leaving a 1-inch border. Quickly top with the eggplant, basil and garlic. Lay the Parmigiano-Reggiano shavings on top.',1),(6,'Close the lid again and grill until the cheese has melted and the bottom of the crust has browned, about 8 minutes.',1);
/*!40000 ALTER TABLE `Recipe_Step` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Researcher`
--

DROP TABLE IF EXISTS `Researcher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Researcher` (
  `ResearcherID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  PRIMARY KEY (`ResearcherID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Researcher`
--

LOCK TABLES `Researcher` WRITE;
/*!40000 ALTER TABLE `Researcher` DISABLE KEYS */;
INSERT INTO `Researcher` VALUES (1,'Ann','d59324e4d5acb950c4022cd5df834cc3'),(2,'Patricia','d59324e4d5acb950c4022cd5df834cc3');
/*!40000 ALTER TABLE `Researcher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAQ_Question`
--

DROP TABLE IF EXISTS `SAQ_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAQ_Question` (
  `SAQID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Question` text DEFAULT NULL,
  `Points` mediumint(9) DEFAULT NULL,
  `QuizID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`SAQID`),
  KEY `SAQ_Question_QuizID_FK` (`QuizID`),
  CONSTRAINT `SAQ_Question_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `SAQ_Section` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAQ_Question`
--

LOCK TABLES `SAQ_Question` WRITE;
/*!40000 ALTER TABLE `SAQ_Question` DISABLE KEYS */;
INSERT INTO `SAQ_Question` VALUES (1,'Based on the video, list 3 problems or challenges that these teenagers face as a result of their smoking?',10,3),(2,'List 1 strategy that you could use to help convince a peer to stop smoking?',10,3),(3,'List 3 the different ways that you have seen anti-smoking messages presented to the public. With each suggest if you think they have been ‘effective�or ‘not effective� Eg. Poster-Effective.',20,3),(4,'How much exercise do you think you do a day?',10,4),(5,'Do you think that you are exercising enough? Why/whynot?',10,4),(6,'What are the benefits of exercising? List 5 examples.',20,4),(7,'What changes can you make to your daily routine to incorporate more exercise into your life?',20,4);
/*!40000 ALTER TABLE `SAQ_Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAQ_Question_Record`
--

DROP TABLE IF EXISTS `SAQ_Question_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAQ_Question_Record` (
  `StudentID` mediumint(9) NOT NULL,
  `SAQID` mediumint(9) NOT NULL,
  `Answer` text DEFAULT NULL,
  `Feedback` text DEFAULT NULL,
  `Grading` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`StudentID`,`SAQID`),
  KEY `SAQ_Question_Record_SAQID_FK` (`SAQID`),
  CONSTRAINT `SAQ_Question_Record_SAQID_FK` FOREIGN KEY (`SAQID`) REFERENCES `SAQ_Question` (`SAQID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `SAQ_Question_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAQ_Question_Record`
--

LOCK TABLES `SAQ_Question_Record` WRITE;
/*!40000 ALTER TABLE `SAQ_Question_Record` DISABLE KEYS */;
INSERT INTO `SAQ_Question_Record` VALUES (1,1,'[ANSWER] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque non justo et tellus venenatis consequat. Suspendisse laoreet rhoncus nulla, quis vulputate arcu interdum vel. Aenean at nisl at enim imperdiet rhoncus in non risus. Nam augue nisi, blandit sed feugiat eu, dapibus tristique ipsum. Vestibulum molestie orci risus, accumsan convallis sem sagittis mattis. Nulla ac justo sit amet erat lacinia vulputate. Aliquam accumsan pellentesque magna ac ultricies. Cras consequat feugiat suscipit. Vivamus suscipit lobortis nunc at aliquet. Nullam orci diam, viverra sed interdum ac, vehicula vel nisi. Cras blandit erat eget purus maximus condimentum. Nullam mattis pellentesque velit ac euismod. Nam vehicula est vel iaculis hendrerit. Vivamus pellentesque leo nec eleifend sodales. Phasellus eget condimentum metus.','+10: Good job!',10),(1,2,'[ANSWER] Nunc rhoncus turpis eu risus pharetra, et pharetra libero euismod. Donec ac tellus consequat, aliquam ligula in, semper erat. Praesent ut justo auctor, imperdiet nisi quis, bibendum dolor. Nunc iaculis aliquet est ac maximus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse vel elit felis. Duis accumsan arcu cursus dapibus vulputate. Maecenas sit amet euismod orci. Sed imperdiet justo quis eros porta tristique eu a mi. Donec at est lacus. Vivamus viverra, purus ut tempor auctor, tellus massa hendrerit elit, tristique ornare mauris dolor vitae ante.','+10: Well done!',10),(1,3,'[ANSWER] Nam odio tortor, finibus sit amet metus vitae, egestas venenatis arcu. Maecenas sodales, mi vitae tincidunt interdum, urna ipsum sagittis orci, semper mollis nisl ex ut felis. Vivamus lectus justo, interdum sit amet enim id, euismod posuere erat. Pellentesque auctor elit eget finibus placerat. Vivamus sodales dolor non ligula molestie aliquam. Ut at metus ut mauris consequat sollicitudin. Suspendisse non ipsum at neque molestie feugiat.','+20: Nice try. <br> -2: You should also mention Poster-Effective.',18);
/*!40000 ALTER TABLE `SAQ_Question_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SAQ_Section`
--

DROP TABLE IF EXISTS `SAQ_Section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SAQ_Section` (
  `QuizID` mediumint(9) NOT NULL,
  `MediaTitle` text DEFAULT NULL,
  `MediaSource` text DEFAULT NULL,
  PRIMARY KEY (`QuizID`),
  CONSTRAINT `SAQ_Section_QuizID_FK` FOREIGN KEY (`QuizID`) REFERENCES `Quiz` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SAQ_Section`
--

LOCK TABLES `SAQ_Section` WRITE;
/*!40000 ALTER TABLE `SAQ_Section` DISABLE KEYS */;
INSERT INTO `SAQ_Section` VALUES (3,'It is a trap!','The Truth Site'),(4,NULL,NULL);
/*!40000 ALTER TABLE `SAQ_Section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `School`
--

DROP TABLE IF EXISTS `School`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `School` (
  `SchoolID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `SchoolName` varchar(190) DEFAULT NULL,
  PRIMARY KEY (`SchoolID`),
  UNIQUE KEY `SchoolName` (`SchoolName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `School`
--

LOCK TABLES `School` WRITE;
/*!40000 ALTER TABLE `School` DISABLE KEYS */;
INSERT INTO `School` VALUES (2,'Sample Adelaide High School'),(3,'Sample Woodville High School'),(1,'updated school');
/*!40000 ALTER TABLE `School` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Snap_Fact`
--

DROP TABLE IF EXISTS `Snap_Fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Snap_Fact` (
  `SnapFactID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Content` text DEFAULT NULL,
  `TopicID` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`SnapFactID`),
  KEY `Snap_Fact_TopicID_FK` (`TopicID`),
  CONSTRAINT `Snap_Fact_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `Topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Snap_Fact`
--

LOCK TABLES `Snap_Fact` WRITE;
/*!40000 ALTER TABLE `Snap_Fact` DISABLE KEYS */;
INSERT INTO `Snap_Fact` VALUES (1,'Each day, more than 3,200 people under 18 smoke their first cigarette, and approximately 2,100 youth and young adults become daily smokers.',1),(2,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(3,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(4,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(5,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(6,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(7,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(8,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(9,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(10,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(11,'Nearly 9 out of 10 lung cancers are caused by smoking. Smokers today are much more likely to develop lung cancer than smokers were in 1964.',1),(12,'A large part of the population is Omega-3 deficient. Avoiding a deficiency in these essential fatty acids can help prevent many diseases.',2),(13,'Trans Fats are chemically processed fats that cause all sorts of damage in the body. You should avoid them like the plague.',2),(14,'Excessive alcohol use is responsible for 2.5 million years of potential life lost annually, or an average of about 30 years of potential life lost for each death',3),(15,'Up to 40% of all hospital beds in the United States (except for those being used by maternity and intensive care patients) are being used to treat health conditions that are related to alcohol consumption',3),(16,'People aged 18-64 years old should exercice at least 150 min per week at least, each of the session lasting 10 min as a minimum,',4),(17,'Supportive environments and communities may help people to be more physically active.',4);
/*!40000 ALTER TABLE `Snap_Fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student`
--

DROP TABLE IF EXISTS `Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student` (
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
  PRIMARY KEY (`StudentID`),
  KEY `Student_ClassID_FK` (`ClassID`),
  CONSTRAINT `Student_ClassID_FK` FOREIGN KEY (`ClassID`) REFERENCES `Class` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student`
--

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;
INSERT INTO `Student` VALUES (1,'Fernando',NULL,'Fernando','Trump','d59324e4d5acb950c4022cd5df834cc3','fernado@gmail.com','Male','2003-10-20','Resident',0,'2017-09-25 00:47:22',1),(2,'Todd',NULL,'Todd','Webb','d59324e4d5acb950c4022cd5df834cc3','toddyy@gmail.com','Male','2003-11-20','Aboriginal',5,'2016-06-02 05:18:43',1),(3,'Theresa',NULL,'Theresa','Rios','d59324e4d5acb950c4022cd5df834cc3','theresa03@gmail.com','Female','2003-12-20','Aboriginal',0,'2016-06-03 05:18:43',1),(4,'Hai',NULL,'Hai','Lam','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-22','Aboriginal',0,'2016-06-01 05:19:43',1),(5,'Lee',NULL,'Lee','Malone','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-24','Aboriginal',0,'2016-06-07 05:18:43',1),(6,'Tim',NULL,'Tim','Mason','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-25','Resident',0,'2016-06-11 05:18:43',1),(7,'Clinton',NULL,'Clinton','Snyder','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-28','Resident',0,'2017-09-25 00:47:22',1),(8,'Elbert',NULL,'Elbert','Chapman','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-10-22','Resident',0,'2016-06-05 05:18:43',1),(9,'Ervin',NULL,'Ervin','Murray','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2003-11-20','Resident',0,'2017-09-25 00:47:22',1),(10,'Sheila',NULL,'Sheila','Frank','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Aboriginal',0,'2017-09-25 00:47:22',1),(11,'Grace',NULL,'Grace','Austin','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-29','Resident',0,'2017-09-25 00:47:22',1),(12,'Ruby',NULL,'Ruby','Chavez','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2016-06-05 05:18:43',1),(13,'Sonya',NULL,'Sonya','Kelly','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-09-25 00:47:22',1),(14,'Donna',NULL,'Donna','Pratt','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-09-25 00:47:22',1),(15,'Stacy',NULL,'Stacy','Figueroa','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-09-25 00:47:22',1),(16,'Fannie',NULL,'Fannie','Waters','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-28','Aboriginal',0,'2016-06-01 05:18:42',1),(17,'June',NULL,'June','West','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Aboriginal',0,'2017-09-25 00:47:22',1),(18,'Melinda',NULL,'Melinda','Kelley','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2003-10-20','Resident',0,'2017-09-25 00:47:22',1),(19,'Leo',NULL,'Leo','Potter','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-22','Resident',0,'2017-09-25 00:47:22',1),(20,'Hector',NULL,'Hector','Byrd','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-20','Resident',0,'2017-09-25 00:47:22',1),(21,'Otis',NULL,'Otis','Lawrence','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Male','2002-04-20','Aboriginal',0,'2017-09-25 00:47:22',2),(22,'Cassandra',NULL,'Cassandra','James','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2002-04-20','Aboriginal',0,'2017-09-25 00:47:22',2),(23,'Marilyn',NULL,'Marilyn','Ryan','d59324e4d5acb950c4022cd5df834cc3','isnap2demo@gmail.com','Female','2002-04-20','Aboriginal',0,'2017-09-25 00:47:22',1);
/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student_Question`
--

DROP TABLE IF EXISTS `Student_Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student_Question` (
  `QuestionID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Subject` text NOT NULL,
  `Content` text DEFAULT NULL,
  `SendTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Feedback` text DEFAULT NULL,
  `Viewed` tinyint(1) DEFAULT 0,
  `Replied` tinyint(1) DEFAULT 0,
  `StudentID` mediumint(9) NOT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `Student_Question_StudentID_FK` (`StudentID`),
  CONSTRAINT `Student_Question_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student_Question`
--

LOCK TABLES `Student_Question` WRITE;
/*!40000 ALTER TABLE `Student_Question` DISABLE KEYS */;
/*!40000 ALTER TABLE `Student_Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student_Week_Record`
--

DROP TABLE IF EXISTS `Student_Week_Record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student_Week_Record` (
  `StudentID` mediumint(9) NOT NULL,
  `Week` mediumint(9) NOT NULL,
  `DueTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`StudentID`,`Week`),
  CONSTRAINT `Student_Week_Record_StudentID_FK` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student_Week_Record`
--

LOCK TABLES `Student_Week_Record` WRITE;
/*!40000 ALTER TABLE `Student_Week_Record` DISABLE KEYS */;
INSERT INTO `Student_Week_Record` VALUES (2,1,'2017-09-25 02:31:26');
/*!40000 ALTER TABLE `Student_Week_Record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Topic`
--

DROP TABLE IF EXISTS `Topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Topic` (
  `TopicID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `TopicName` varchar(190) DEFAULT NULL,
  PRIMARY KEY (`TopicID`),
  UNIQUE KEY `TopicName` (`TopicName`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Topic`
--

LOCK TABLES `Topic` WRITE;
/*!40000 ALTER TABLE `Topic` DISABLE KEYS */;
INSERT INTO `Topic` VALUES (3,'Alcohol'),(5,'Drugs'),(7,'Health and Wellbeing'),(2,'Nutrition'),(4,'Physical Activity'),(6,'Sexual Health'),(1,'Smoking');
/*!40000 ALTER TABLE `Topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Verbose_Fact`
--

DROP TABLE IF EXISTS `Verbose_Fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Verbose_Fact` (
  `VerboseFactID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Title` text DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `TopicID` mediumint(9) NOT NULL,
  PRIMARY KEY (`VerboseFactID`),
  KEY `Verbose_Fact_Topic_FK` (`TopicID`),
  CONSTRAINT `Verbose_Fact_Topic_FK` FOREIGN KEY (`TopicID`) REFERENCES `Topic` (`TopicID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Verbose_Fact`
--

LOCK TABLES `Verbose_Fact` WRITE;
/*!40000 ALTER TABLE `Verbose_Fact` DISABLE KEYS */;
INSERT INTO `Verbose_Fact` VALUES (1,'Short Term Effects of Smoking','Short Term Effects of Smoking Content...',1),(2,'Emphysema','Emphysema is a long-term, progressive disease of the lungs that primarily causes shortness of breath due to over-inflation of the alveoli (air sacs in the lung). In people with emphysema, the lung tissue involved in exchange of gases (oxygen and carbon dioxide) is impaired or destroyed. Emphysema is included in a group of diseases called chronic obstructive pulmonary disease or COPD (pulmonary refers to the lungs).\nEmphysema is called an obstructive lung disease because airflow on exhalation is slowed or stopped because over-inflated alveoli do not exchange gases when a person breaths due to little or no movement of gases out of the alveoli.\nEmphysema changes the anatomy of the lung in several important ways. This is due to in part to the destruction of lung tissue around smaller airways. This tissue normally holds these small airways, called bronchioles, open, allowing air to leave the lungs on exhalation. When this tissue is damaged, these airways collapse, making it difficult for the lungs to empty and the air (gases) becomes trapped in the alveoli.\nNormal lung tissue looks like a new sponge. Emphysematous lung looks like an old used sponge, with large holes and a dramatic loss of “springy-nessor elasticity. When the lung is stretched during inflation (inhalation), the nature of the stretched tissue wants to relax to its resting state. In emphysema, this elastic function is impaired, resulting in air trapping in the lungs. Emphysema destroys this spongy tissue of the lung and also severely affects the small blood vessels (capillaries of the lung) and airways that run throughout the lung. Thus, not only is airflow affected but so is blood flow. This has dramatic impact on the ability for the lung not only to empty its air sacs called alveoli (pleural for alveolus) but also for blood to flow through the lungs to receive oxygen.',1),(3,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(4,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(5,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(6,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(7,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(8,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(9,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(10,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(11,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(12,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(13,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1),(14,'Long Term Effects of Smoking','Long Term Effects of Smoking Content...',1);
/*!40000 ALTER TABLE `Verbose_Fact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Week`
--

DROP TABLE IF EXISTS `Week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Week` (
  `WeekID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Timer` mediumint(9) DEFAULT 1,
  `WeekNum` mediumint(9) DEFAULT 0,
  PRIMARY KEY (`WeekID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Week`
--

LOCK TABLES `Week` WRITE;
/*!40000 ALTER TABLE `Week` DISABLE KEYS */;
INSERT INTO `Week` VALUES (1,2,1),(2,3,2),(3,1,3),(4,10,4),(5,5,6),(6,4,7);
/*!40000 ALTER TABLE `Week` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-25 20:23:15
