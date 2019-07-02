-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: app
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.37-MariaDB

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
-- Dumping data for table `Acl_Customer`
--

LOCK TABLES `Acl_Customer` WRITE;
/*!40000 ALTER TABLE `Acl_Customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `Acl_Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Assert_Option`
--

LOCK TABLES `App_Assert_Option` WRITE;
/*!40000 ALTER TABLE `App_Assert_Option` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Assert_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Assert`
--

LOCK TABLES `App_Field_Assert` WRITE;
/*!40000 ALTER TABLE `App_Field_Assert` DISABLE KEYS */;
/*!40000 ALTER TABLE `App_Field_Assert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Option`
--

LOCK TABLES `App_Field_Option` WRITE;
/*!40000 ALTER TABLE `App_Field_Option` DISABLE KEYS */;
INSERT INTO `App_Field_Option` VALUES (1,6,'default','A fancy product'),(2,6,'comment','The name of our product.'),(3,10,'unsigned','true');
/*!40000 ALTER TABLE `App_Field_Option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Relation`
--

LOCK TABLES `App_Field_Relation` WRITE;
/*!40000 ALTER TABLE `App_Field_Relation` DISABLE KEYS */;
INSERT INTO `App_Field_Relation` VALUES (1,'OneToOne','Detail',NULL,NULL,0,NULL,'id',0,1);
/*!40000 ALTER TABLE `App_Field_Relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Project`
--

LOCK TABLES `App_Project` WRITE;
/*!40000 ALTER TABLE `App_Project` DISABLE KEYS */;
INSERT INTO `App_Project` VALUES (1,'My Online Shop','My fance online shop which uses AaaS.');
/*!40000 ALTER TABLE `App_Project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Project_Repository`
--

LOCK TABLES `App_Project_Repository` WRITE;
/*!40000 ALTER TABLE `App_Project_Repository` DISABLE KEYS */;
INSERT INTO `App_Project_Repository` VALUES (1,1,'Blog','Blog repository holds services for our blog.'),(2,1,'Catalog','Catalog repository holds services for our catalog.');
/*!40000 ALTER TABLE `App_Project_Repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Relation_Cascade`
--

LOCK TABLES `App_Relation_Cascade` WRITE;
/*!40000 ALTER TABLE `App_Relation_Cascade` DISABLE KEYS */;
INSERT INTO `App_Relation_Cascade` VALUES (1,1,'persist'),(2,1,'remove');
/*!40000 ALTER TABLE `App_Relation_Cascade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Repository_Service`
--

LOCK TABLES `App_Repository_Service` WRITE;
/*!40000 ALTER TABLE `App_Repository_Service` DISABLE KEYS */;
INSERT INTO `App_Repository_Service` VALUES (1,1,'Article','Articles for our blog repository.','list'),(2,1,'Label','Labels for our blog repository.','list'),(3,1,'Comment','Comments for our blog repository.','list'),(4,2,'Product','Products service for our catalog repository.','list'),(5,2,'Category','Categories for our catalog repository.','tree'),(6,2,'ProductDetail','Details for our products.','list');
/*!40000 ALTER TABLE `App_Repository_Service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `App_Service_Field`
--

LOCK TABLES `App_Service_Field` WRITE;
/*!40000 ALTER TABLE `App_Service_Field` DISABLE KEYS */;
INSERT INTO `App_Service_Field` VALUES (1,1,NULL,'title','Title for our blog post.','string',255,0,0,NULL,NULL),(2,1,NULL,'post','The actual blog post.','text',8192,0,0,NULL,NULL),(3,2,NULL,'value','The label value.','string',255,0,0,NULL,NULL),(4,3,NULL,'author','The author of the comment.','string',255,0,0,NULL,NULL),(5,3,NULL,'timestamp','The timestamp of the comment.','datetime',8,0,0,NULL,NULL),(6,4,NULL,'name','The actual product name.','string',255,0,0,NULL,NULL),(7,4,NULL,'description','The product description.','text',4096,0,0,NULL,NULL),(8,4,NULL,'prize','The product prize.','float',10,0,1,2,3),(9,5,NULL,'name','The category name.','string',255,1,0,NULL,NULL),(10,5,NULL,'numProducts','The actual number of products of this category.','integer',NULL,0,0,NULL,NULL),(11,6,NULL,'size','Product size','integer',255,0,0,NULL,NULL),(12,6,NULL,'color','Product color','string',20,0,0,NULL,NULL),(13,4,1,'detail','Product details','relation',255,0,0,NULL,NULL);
/*!40000 ALTER TABLE `App_Service_Field` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-02 17:32:23
