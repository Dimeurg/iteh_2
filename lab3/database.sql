-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_lab
-- ------------------------------------------------------
-- Server version	5.7.28-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game` (
  `ID_Game` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `place` text,
  `score` text,
  `FID_Team1` int(11) DEFAULT NULL,
  `FID_Team2` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Game`),
  KEY `FID_Team1` (`FID_Team1`),
  KEY `FID_Team2` (`FID_Team2`),
  CONSTRAINT `game_ibfk_1` FOREIGN KEY (`FID_Team1`) REFERENCES `team` (`ID_Team`),
  CONSTRAINT `game_ibfk_2` FOREIGN KEY (`FID_Team2`) REFERENCES `team` (`ID_Team`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (0,'2020-04-25','place0','1/2',0,1),(1,'2020-03-02','place1','3/8',0,3),(2,'2020-04-15','place3','0/0',1,3),(3,'2020-04-25','place0','3/4',2,4),(4,'2020-03-02','place1','8/8',4,2);
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `player` (
  `ID_Player` int(11) NOT NULL,
  `name` text,
  `FID_Team` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_Player`),
  KEY `FID_Team` (`FID_Team`),
  CONSTRAINT `player_ibfk_1` FOREIGN KEY (`FID_Team`) REFERENCES `team` (`ID_Team`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` VALUES (0,'prayer',0),(1,'crook',0),(2,'Heh',1),(3,'Dam',1),(4,'Brrr',2),(5,'Tth',2),(6,'Six',3),(7,'Seven',3),(8,'Trat',4),(9,'Last',4);
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team` (
  `ID_Team` int(11) NOT NULL,
  `name` text,
  `league` text,
  `coach` text,
  PRIMARY KEY (`ID_Team`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (0,'dreamteam','league1','Tony'),(1,'notCommand','league1','Crack'),(2,'secondteam','Gold league','Bran'),(3,'badCommand','league1','Clif'),(4,'justCommand','Gold league','Clan');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-11 18:23:57
