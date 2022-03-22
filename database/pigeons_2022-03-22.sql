# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.24-MariaDB-1~jessie)
# Database: pigeons
# Generation Time: 2022-03-22 09:30:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pigeon_id` bigint(20) unsigned NOT NULL,
  `order_date` date NOT NULL,
  `distance` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `cost` int(11) NOT NULL,
  `start_time_estimation` datetime NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table pigeons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pigeons`;

CREATE TABLE `pigeons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `speed` int(11) NOT NULL,
  `range` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `downtime` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `pigeons` WRITE;
/*!40000 ALTER TABLE `pigeons` DISABLE KEYS */;

INSERT INTO `pigeons` (`id`, `name`, `speed`, `range`, `cost`, `downtime`, `created_at`, `updated_at`)
VALUES
	(1,'Antonio',70,600,2,2,'2022-03-21 22:27:44','2022-03-21 22:27:44'),
	(2,'Bonito',80,500,2,3,'2022-03-21 22:27:44','2022-03-21 22:27:44'),
	(3,'Carillo',65,1000,2,3,'2022-03-21 22:27:44','2022-03-21 22:27:44'),
	(4,'Alejandro',70,800,2,2,'2022-03-21 22:27:44','2022-03-21 22:27:44'),
	(5,'jacky',30,100,2,2,'2022-03-22 15:07:12','2022-03-22 15:07:50');

/*!40000 ALTER TABLE `pigeons` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
