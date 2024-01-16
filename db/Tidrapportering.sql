/*
SQLyog Community
MySQL - 8.0.31 : Database - tidrapportering
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tidrapportering` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

/*Table structure for table `aktiviteter` */

CREATE TABLE `aktiviteter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Namn` varchar(20) COLLATE utf8mb3_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

/*Data for the table `aktiviteter` */

/*Table structure for table `uppgifter` */

CREATE TABLE `uppgifter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Tid` time NOT NULL,
  `Beskrivning` varchar(100) COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  `AktivitetID` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `AktivitetID` (`AktivitetID`),
  CONSTRAINT `uppgifter_ibfk_1` FOREIGN KEY (`AktivitetID`) REFERENCES `aktiviteter` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

/*Data for the table `uppgifter` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
