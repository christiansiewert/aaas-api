-- MySQL dump 10.17  Distrib 10.3.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: app
-- ------------------------------------------------------
-- Server version	10.3.25-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Acl_Customer`
--

DROP TABLE IF EXISTS `Acl_Customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Acl_Customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_627894A6E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Acl_Customer`
--

LOCK TABLES `Acl_Customer` WRITE;
/*!40000 ALTER TABLE `Acl_Customer` DISABLE KEYS */;
INSERT INTO `Acl_Customer` VALUES (1,'test.user@aaas.api','[\"ROLE_AAAS_USER\"]','$2y$13$ZVCPG3WU5dag.Mtm03yig.lOSX9q6uGT36hZdRATS1r7l/WZ8lHEG'),(2,'christian@siewert.de','[\"ROLE_AAAS_ADMIN\"]','$2y$13$Uft/xlsg3yXZxEyUKZ.uxe.qnI/OTyAixujWEqjhf2AgYQz9yGMhK');
/*!40000 ALTER TABLE `Acl_Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Constraint_Option`
--

DROP TABLE IF EXISTS `App_Constraint_Option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Constraint_Option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `constraint_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F40CF123E3087FFC` (`constraint_id`),
  CONSTRAINT `FK_F40CF123E3087FFC` FOREIGN KEY (`constraint_id`) REFERENCES `App_Field_Constraint` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Constraint_Option`
--

LOCK TABLES `App_Constraint_Option` WRITE;
/*!40000 ALTER TABLE `App_Constraint_Option` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Constraint_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Field_Constraint`
--

DROP TABLE IF EXISTS `App_Field_Constraint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Field_Constraint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2622E4D443707B0` (`field_id`),
  CONSTRAINT `FK_E2622E4D443707B0` FOREIGN KEY (`field_id`) REFERENCES `App_Service_Field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Field_Constraint`
--

LOCK TABLES `App_Field_Constraint` WRITE;
/*!40000 ALTER TABLE `App_Field_Constraint` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Field_Constraint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Field_Option`
--

DROP TABLE IF EXISTS `App_Field_Option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Field_Option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BAEE3380443707B0` (`field_id`),
  CONSTRAINT `FK_BAEE3380443707B0` FOREIGN KEY (`field_id`) REFERENCES `App_Service_Field` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Field_Option`
--

LOCK TABLES `App_Field_Option` WRITE;
/*!40000 ALTER TABLE `App_Field_Option` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Field_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Field_Relation`
--

DROP TABLE IF EXISTS `App_Field_Relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Field_Relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ManyToOne',
  `mapped_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inversed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orphan_removal` tinyint(1) NOT NULL DEFAULT 0,
  `join_column_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_column_referenced_column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'id',
  `join_column_is_unique` tinyint(1) NOT NULL DEFAULT 0,
  `join_column_is_nullable` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `IDX_21FF0C4ED5CA9E6` (`service_id`),
  CONSTRAINT `FK_21FF0C4ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `App_Repository_Service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Field_Relation`
--

LOCK TABLES `App_Field_Relation` WRITE;
/*!40000 ALTER TABLE `App_Field_Relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Field_Relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Filter_Property`
--

DROP TABLE IF EXISTS `App_Filter_Property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Filter_Property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filter_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BB70162BD395B25E` (`filter_id`),
  KEY `IDX_BB70162B443707B0` (`field_id`),
  CONSTRAINT `FK_BB70162B443707B0` FOREIGN KEY (`field_id`) REFERENCES `App_Service_Field` (`id`),
  CONSTRAINT `FK_BB70162BD395B25E` FOREIGN KEY (`filter_id`) REFERENCES `App_Service_Filter` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Filter_Property`
--

LOCK TABLES `App_Filter_Property` WRITE;
/*!40000 ALTER TABLE `App_Filter_Property` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Filter_Property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Project`
--

DROP TABLE IF EXISTS `App_Project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Project`
--

LOCK TABLES `App_Project` WRITE;
/*!40000 ALTER TABLE `App_Project` DISABLE KEYS */;
INSERT INTO `App_Project` VALUES (1,'Webapplication','Our webapplication includes a shop, a website and an API.');
/*!40000 ALTER TABLE `App_Project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Project_Repository`
--

DROP TABLE IF EXISTS `App_Project_Repository`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Project_Repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BECDCEA4166D1F9C` (`project_id`),
  CONSTRAINT `FK_BECDCEA4166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `App_Project` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Project_Repository`
--

LOCK TABLES `App_Project_Repository` WRITE;
/*!40000 ALTER TABLE `App_Project_Repository` DISABLE KEYS */;
INSERT INTO `App_Project_Repository` VALUES (1,1,'Shop repository','Our shop repository'),(2,1,'Site repository','Out site repository'),(3,1,'API repository','Out api repository');
/*!40000 ALTER TABLE `App_Project_Repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Repository_Service`
--

DROP TABLE IF EXISTS `App_Repository_Service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Repository_Service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'list',
  PRIMARY KEY (`id`),
  KEY `IDX_3A0A7CC450C9D4F7` (`repository_id`),
  CONSTRAINT `FK_3A0A7CC450C9D4F7` FOREIGN KEY (`repository_id`) REFERENCES `App_Project_Repository` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Repository_Service`
--

LOCK TABLES `App_Repository_Service` WRITE;
/*!40000 ALTER TABLE `App_Repository_Service` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Repository_Service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Service_Field`
--

DROP TABLE IF EXISTS `App_Service_Field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Service_Field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `relation_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `length` int(10) unsigned DEFAULT NULL,
  `data_type_precision` int(11) DEFAULT NULL,
  `data_type_scale` int(11) DEFAULT NULL,
  `is_unique` tinyint(1) NOT NULL DEFAULT 0,
  `is_nullable` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_34E6C3183256915B` (`relation_id`),
  KEY `IDX_34E6C318ED5CA9E6` (`service_id`),
  CONSTRAINT `FK_34E6C3183256915B` FOREIGN KEY (`relation_id`) REFERENCES `App_Field_Relation` (`id`),
  CONSTRAINT `FK_34E6C318ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `App_Repository_Service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Service_Field`
--

LOCK TABLES `App_Service_Field` WRITE;
/*!40000 ALTER TABLE `App_Service_Field` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Service_Field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `App_Service_Filter`
--

DROP TABLE IF EXISTS `App_Service_Filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `App_Service_Filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9770D0BED5CA9E6` (`service_id`),
  CONSTRAINT `FK_9770D0BED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `App_Repository_Service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `App_Service_Filter`
--

LOCK TABLES `App_Service_Filter` WRITE;
/*!40000 ALTER TABLE `App_Service_Filter` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Service_Filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `System_Migration`
--

DROP TABLE IF EXISTS `System_Migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `System_Migration` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `System_Migration`
--

LOCK TABLES `System_Migration` WRITE;
/*!40000 ALTER TABLE `System_Migration` DISABLE KEYS */;
INSERT INTO `System_Migration` VALUES ('20200807184146','2020-11-06 17:48:26');
/*!40000 ALTER TABLE `System_Migration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-06 18:52:40
