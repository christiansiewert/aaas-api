-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: app
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `Acl_Customer`
--

LOCK TABLES `Acl_Customer` WRITE;
UNLOCK TABLES;

--
-- Dumping data for table `App_Constraint_Option`
--

LOCK TABLES `App_Constraint_Option` WRITE;
INSERT INTO `App_Constraint_Option` (`id`, `constraint_id`, `name`, `value`) VALUES (1,1,'message','This value must not be empty!');
INSERT INTO `App_Constraint_Option` (`id`, `constraint_id`, `name`, `value`) VALUES (2,2,'min','5');
INSERT INTO `App_Constraint_Option` (`id`, `constraint_id`, `name`, `value`) VALUES (3,2,'max','95');
INSERT INTO `App_Constraint_Option` (`id`, `constraint_id`, `name`, `value`) VALUES (4,2,'minMessage','{{ value }} must be at least {{ limit }}.');
INSERT INTO `App_Constraint_Option` (`id`, `constraint_id`, `name`, `value`) VALUES (5,2,'maxMessage','{{ value }} cannot be greater than {{ limit }}.');
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Constraint`
--

LOCK TABLES `App_Field_Constraint` WRITE;
INSERT INTO `App_Field_Constraint` (`id`, `field_id`, `name`) VALUES (1,1,'NotBlank');
INSERT INTO `App_Field_Constraint` (`id`, `field_id`, `name`) VALUES (2,8,'Range');
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Option`
--

LOCK TABLES `App_Field_Option` WRITE;
INSERT INTO `App_Field_Option` (`id`, `field_id`, `name`, `value`) VALUES (1,6,'default','A fancy product');
INSERT INTO `App_Field_Option` (`id`, `field_id`, `name`, `value`) VALUES (2,6,'comment','The name of our product.');
INSERT INTO `App_Field_Option` (`id`, `field_id`, `name`, `value`) VALUES (3,10,'unsigned','true');
UNLOCK TABLES;

--
-- Dumping data for table `App_Field_Relation`
--

LOCK TABLES `App_Field_Relation` WRITE;
INSERT INTO `App_Field_Relation` (`id`, `type`, `target_entity`, `mapped_by`, `inversed_by`, `orphan_removal`, `join_column_name`, `join_column_referenced_column_name`, `join_column_is_unique`, `join_column_is_nullable`) VALUES (1,'OneToOne','ProductDetail',NULL,NULL,0,NULL,'id',0,1);
INSERT INTO `App_Field_Relation` (`id`, `type`, `target_entity`, `mapped_by`, `inversed_by`, `orphan_removal`, `join_column_name`, `join_column_referenced_column_name`, `join_column_is_unique`, `join_column_is_nullable`) VALUES (2,'ManyToMany','Product',NULL,NULL,0,NULL,'id',0,1);
UNLOCK TABLES;

--
-- Dumping data for table `App_Project`
--

LOCK TABLES `App_Project` WRITE;
INSERT INTO `App_Project` (`id`, `name`, `description`) VALUES (1,'My Online Shop','My fance online shop which uses AaaS.');
UNLOCK TABLES;

--
-- Dumping data for table `App_Project_Repository`
--

LOCK TABLES `App_Project_Repository` WRITE;
INSERT INTO `App_Project_Repository` (`id`, `project_id`, `name`, `description`) VALUES (1,1,'Blog','Blog repository holds services for our blog.');
INSERT INTO `App_Project_Repository` (`id`, `project_id`, `name`, `description`) VALUES (2,1,'Catalog','Catalog repository holds services for our catalog.');
UNLOCK TABLES;

--
-- Dumping data for table `App_Repository_Service`
--

LOCK TABLES `App_Repository_Service` WRITE;
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (1,1,'Article','Articles for our blog repository.','list');
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (2,1,'Label','Labels for our blog repository.','list');
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (3,1,'Comment','Comments for our blog repository.','list');
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (4,2,'Product','Products service for our catalog repository.','list');
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (5,2,'Category','Categories for our catalog repository.','tree');
INSERT INTO `App_Repository_Service` (`id`, `repository_id`, `name`, `description`, `type`) VALUES (6,2,'ProductDetail','Details for our products.','list');
UNLOCK TABLES;

--
-- Dumping data for table `App_Service_Field`
--

LOCK TABLES `App_Service_Field` WRITE;
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (1,1,NULL,'title','Title for our blog post.','string',255,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (2,1,NULL,'post','The actual blog post.','text',NULL,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (3,2,NULL,'value','The label value.','string',255,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (4,3,NULL,'author','The author of the comment.','string',255,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (5,3,NULL,'timestamp','The timestamp of the comment.','datetime',NULL,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (6,4,NULL,'name','The actual product name.','string',255,NULL,NULL,1,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (7,4,NULL,'description','The product description.','text',NULL,NULL,NULL,0,1);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (8,4,NULL,'price','The product price.','float',NULL,10,2,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (9,5,NULL,'name','The category name.','string',255,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (10,5,NULL,'numProducts','The actual number of products of this category.','integer',NULL,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (11,6,NULL,'size','Product size','integer',NULL,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (12,6,NULL,'color','Product color','string',20,NULL,NULL,0,0);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (13,4,1,'detail','Product details','relation',NULL,NULL,NULL,0,1);
INSERT INTO `App_Service_Field` (`id`, `service_id`, `relation_id`, `name`, `description`, `data_type`, `length`, `data_type_precision`, `data_type_scale`, `is_unique`, `is_nullable`) VALUES (14,5,2,'products','Products belonging to a category.','relation',NULL,NULL,NULL,0,0);
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-28 13:09:36
