-- MySQL dump 10.13  Distrib 5.7.27-30, for Linux (x86_64)
--
-- Host: localhost    Database: u1534778_qak
-- ------------------------------------------------------
-- Server version	5.7.27-30

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
/*!50717 SELECT COUNT(*) INTO @rocksdb_has_p_s_session_variables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'performance_schema' AND TABLE_NAME = 'session_variables' */;
/*!50717 SET @rocksdb_get_is_supported = IF (@rocksdb_has_p_s_session_variables, 'SELECT COUNT(*) INTO @rocksdb_is_supported FROM performance_schema.session_variables WHERE VARIABLE_NAME=\'rocksdb_bulk_load\'', 'SELECT 0') */;
/*!50717 PREPARE s FROM @rocksdb_get_is_supported */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;
/*!50717 SET @rocksdb_enable_bulk_load = IF (@rocksdb_is_supported, 'SET SESSION rocksdb_bulk_load = 1', 'SET @rocksdb_dummy_bulk_load = 0') */;
/*!50717 PREPARE s FROM @rocksdb_enable_bulk_load */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;

--
-- Table structure for table `admin_command`
--

DROP TABLE IF EXISTS `admin_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `command` varchar(300) NOT NULL,
  `time` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_command`
--

LOCK TABLES `admin_command` WRITE;
/*!40000 ALTER TABLE `admin_command` DISABLE KEYS */;
INSERT INTO `admin_command` VALUES (1,1,'/removepost 10',1647091003),(2,1,'/rang 2 3',1647179457),(3,1,'/rang 1 1',1647257270),(4,1,'/createinvite',1647336991),(5,1,'/rang 10 2',1647337595),(6,1,'/rang 10 1',1647446670),(7,1,'/commented 11 0',1648030540),(8,1,'/removepost 6',1651765528),(9,1,'/createinvite',1651858451),(10,1,'/ban 11',1651909668),(11,1,'/unban 11',1651909697),(12,1,'/type 16 ads',1658191704),(13,1,'/makerequest 1 11 0',1658228063),(14,1,'/sendnotify 1 Ð–Ð°Ð»Ð¾Ð±Ð° Ð½Ð° Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»Ñ @izbalolist Ð±Ñ‹Ð»Ð° Ñ€Ð°ÑÑÐ¼Ð¾Ñ‚Ñ€ÐµÐ½Ð° Ð¸ Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»ÑŒ Ð½Ð°ÐºÐ°Ð·Ð°Ð½. Ð¡Ð¿Ð°ÑÐ¸Ð±Ð¾, Ñ‡Ñ‚Ð¾ Ð´ÐµÐ»Ð°ÐµÑ‚Ðµ Ð½Ð°Ñˆ ÑÐµÑ€Ð²Ð¸Ñ Ð»ÑƒÑ‡ÑˆÐµ!..',1658230765),(15,1,'/sendnotify 13 Ð—Ð´Ñ€Ð°Ð²ÑÑ‚Ð²ÑƒÐ¹Ñ‚Ðµ, ÑÐµÐ³Ð¾Ð´Ð½Ñ Ð¼Ñ‹ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ð»Ð¸ Ð¶Ð°Ð»Ð¾Ð±Ñƒ Ð½Ð° Ð²Ð°Ñ. ÐŸÑ€Ð¾ÑÐ¸Ð¼ Ð½Ðµ Ð½Ð°Ñ€ÑƒÑˆÐ°Ñ‚ÑŒ. Ð-Ñ‚Ð°-Ñ‚Ð°...',1658232546),(16,1,'/makerequestfollow 1 15 0',1658307955),(17,1,'/sendnotify 1 Ð—Ð½Ð°ÐµÑˆÑŒ.. Ñ Ñ‚ÑƒÑ‚ Ð¿Ð¾Ð´ÑƒÐ¼Ð°Ð», Ð¸ Ñ€ÐµÑˆÐ¸Ð» Ñ‚ÐµÐ±Ðµ Ð·Ð°Ð±Ð°Ð½Ð¸Ñ‚ÑŒ!',1658308279),(18,1,'/ban 16',1658308581),(19,1,'/unban 16',1658308607),(20,1,'/scam 16',1658308625),(21,1,'/verification 16 1',1658308654),(22,1,'/rang 16 3',1658348163),(23,1,'/unscam 16',1658348251),(24,1,'/rang 19 3',1658351333),(25,1,'/rang 20 4',1658351344);
/*!40000 ALTER TABLE `admin_command` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `black_list`
--

DROP TABLE IF EXISTS `black_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_blocker` int(11) NOT NULL,
  `user_blocked` int(11) NOT NULL,
  `date_public` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `black_list`
--

LOCK TABLES `black_list` WRITE;
/*!40000 ALTER TABLE `black_list` DISABLE KEYS */;
INSERT INTO `black_list` VALUES (3,1,10,'2022-03-21 11:11:07'),(4,1,2,'2022-07-19 09:12:36');
/*!40000 ALTER TABLE `black_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `date_public` varchar(30) NOT NULL DEFAULT '1970-01-01 03.00.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (4,1,1,'Ð­Ñ‚Ð¾ ÐºÐ¾Ð¼Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ð¹.','2022-02-11 14:47:27'),(5,1,1,'@xianitt Ð¾Ð¿Ð¿Ñ€Ð¿Ñ€Ð¾Ð¾Ñ€Ñ€Ñ€Ð¾Ð»','2022-02-11 14:57:52'),(6,7,1,'Cool bro','2022-02-26 03:03:04'),(7,1,1,'@detroit Hi bro!','2022-03-06 11:21:49'),(8,8,1,'Ð›Ð°Ð´Ð½Ð¾','2022-03-07 21:59:08'),(9,1,11,'Ð¢ÐµÑÑ‚Ð¾Ð²Ñ‹Ð¹ ÐºÐ¾Ð¼Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ð¹ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','2022-03-22 14:02:20'),(10,1,1,'ÐŸÑ€Ð¸Ð²ÐµÑ‚!','2022-05-06 20:50:17'),(11,13,15,'Gagegaf','2022-07-18 02:56:18'),(12,13,17,'Ð°-Ñ‚Ð°-Ð°-Ñ‚Ð°','2022-07-19 19:41:10'),(13,1,17,'@aaa Ð‘Ð°Ð½!','2022-07-19 19:53:42'),(14,14,15,'ÐšÑ€ÑƒÑ‚Ð¾!','2022-07-20 02:06:33'),(15,13,15,'Ð¡Ð¿Ð°ÑÐ¸Ð±Ð¾;','2022-07-20 20:19:44'),(16,13,15,'@test Ñ‚Ñ‹ ÐºÑ‚Ð¾?','2022-07-20 20:24:59');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments_likes`
--

DROP TABLE IF EXISTS `comments_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '1234000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments_likes`
--

LOCK TABLES `comments_likes` WRITE;
/*!40000 ALTER TABLE `comments_likes` DISABLE KEYS */;
INSERT INTO `comments_likes` VALUES (9,7,1,4,1645833791),(10,7,1,5,1645833792),(13,1,1,6,1646554887),(15,1,1,8,1647786661),(25,1,1,10,1651859422),(28,1,1,4,1653948594),(29,1,17,12,1658270573),(33,1,11,9,1658271446),(34,14,15,14,1658271997);
/*!40000 ALTER TABLE `comments_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dialog`
--

DROP TABLE IF EXISTS `dialog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `date` varchar(30) NOT NULL DEFAULT '1997-01-01 00:00:00',
  `date2` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  `send` int(11) NOT NULL,
  `recive` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialog`
--

LOCK TABLES `dialog` WRITE;
/*!40000 ALTER TABLE `dialog` DISABLE KEYS */;
INSERT INTO `dialog` VALUES (1,'aI3VNYe9SlsJ6w4B5l30J4IU5QPaw5',1,2,'2021-11-25 18:11:46','1645101589',0,1,2,'Gd6XsuTQ1fwCS1qy5OPy74fX3B4vmGy3O0V0urijTxYG9YI23a'),(2,'i18Lz1SUc5ROQcv3tQ4EQLGgijjE6l',1,1,'2022-02-11 15:00:05','1656676760',0,1,0,'bkv3gfC8nkgOyuLPZZnT6TXzgU8cmmKwtzPLiSZJ3kHZ5VNZth'),(4,'zJFeet3MNtW5kHxXPjsXqDOkPkuEEe',9,1,'2022-03-07 22:23:43','1646681023',1,0,0,'Cto8h2R0u7TyQL9kMfRJYXCDBdbJqX9VAeJUgfCocMd9nc9lAI'),(6,'evOg5PHkSnh2II0hPsTnVgvANWTDtT',11,1,'2022-05-07 10:26:35','1652345448',0,1,11,'6yodTyQuxNmVrLV9ACEQpY5Bs4lTp0hE3DUwOJ8jhu2JWKKB5I'),(7,'m0kUZFzPGpICuRWAQM7ze7TRlyQxQg',11,13,'2022-07-18 02:41:35','1658101295',1,0,0,'jEZ3M8UZWAvHX9y4fgd8CfVJwiuP9WWhMZNiLuN52j3oyoXBv9'),(8,'JVOz7QRqCdO1XTyfExsWpGiuYtPIcc',12,13,'2022-07-18 02:45:57','1658101557',1,0,0,'XNEX3c8Fxa2PgpQSwtMtji9mW9yopDPib6Vo1ZSYj93J5LYPoD'),(9,'VNDV0ly15WFzTE3dsRqYjdEocVsAur',10,13,'2022-07-18 02:46:23','1658101583',1,0,0,'PYTs9iFTg0bGfr9hlyfHy3VT9edKtgzpaiJethew1rRZEYUXkM'),(10,'5Fw7yDvGpoTrnVlCtnCeMuDcMWuw5I',4,13,'2022-07-18 02:56:45','1658102205',1,0,0,'d6Vx0NA8GfUjdqszp3caBhcI8wkGDzgCiAFJSXDoIbzEH5NeSq'),(11,'fuyXztt0oS6aqVrU0RUpvYhoyyAc5Y',13,1,'2022-07-19 19:54:48','1658348036',0,1,13,'Di9fjxhGMa8t6oiD36hWGIuf9QUST5ZrD758XXtrIehhoEeJhI'),(13,'jK1N7bVn3NSAKUfGf48iggxleqgUTc',16,13,'2022-07-20 20:32:03','1658338323',1,0,0,'yAfvXrcE5NWlqCbXzWU37ozSF681tSpJ7KK1RdbnrxUClzFHas');
/*!40000 ALTER TABLE `dialog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dialog_messages`
--

DROP TABLE IF EXISTS `dialog_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dialog_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'text',
  `text` varchar(10000) DEFAULT 'Text',
  `source` varchar(500) DEFAULT NULL,
  `reply` varchar(10000) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date` varchar(30) DEFAULT '1997-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dialog_messages`
--

LOCK TABLES `dialog_messages` WRITE;
/*!40000 ALTER TABLE `dialog_messages` DISABLE KEYS */;
INSERT INTO `dialog_messages` VALUES (1,1,2,'text','3gwb7NWSnlYdIxyPk6tqZwAOBzCN2rKWJIvQ6JrhMM5laGkVEIZ3QQRr3JkOoeloLH8DmSRa09od1GBLc90vOyyIyflTwI6hic5Bi8UKfEQ7P3f2Bncr65CrBbhUIFy38=',NULL,'0',1,'1637853118'),(3,1,2,'text','dI/XYMmlDFnVqzZlviIY6gYoGLrsqnwX2C+srkDtDfM9o4DBuA6RdHQGyybWpf1rk1v+KzHTI5JZJyxE2SX4iYLAxfHSXe/p5AFv9kIHT94MQywmnewfk96Nu2JjRepy0hgtLA3oQNniJx9BYSFf5D5xvqruWB+DGWHm6MJ21acws8vlxKbUgVEJqqABWS/ISYiohwxx8XjW5Sjw/fgp46DqIoUFm56suRz0xHMZczwg==',NULL,'0',1,'1637853379'),(6,1,2,'image','Text','https://sun.qwaker.fun/uploads/kycb42148-MESSAGE-20211125182410-217623.png',NULL,1,'1637853850'),(9,1,1,'text','uneqppdMjiITQ3rqNycQEwIcIh7jXJ/1ZFms8dRJVMx/Ww3hkRTbl3eo8Vzg9jGx806U2l4bhhxp78h0qVmrjT',NULL,'0',1,'1638356432'),(11,1,2,'text','YV1c+pm9fSAo29OwPoCs8g+S3mU2e7oRDdXUk4rvWwpqlQGpJIG+HszhSx4nZ+2IeNVhkr3OoXY26MyE3rmZbOqSqRY6CjINK/04z/6f2NqOeNbTjXoNdLgYfnMFxS1cAwbl8hEZwRPIlwtDqpVHaYB/h9IwcolXq49iHDhyBVyQ==',NULL,'0',1,'1640908330'),(12,1,2,'text','Xl2dhIMs6o0Dha/SXb0LhwNY/0ZgIGZqofQHcuM08TaXm5VlixudLA/wOkcPtX0hyXtrTrbWxofwd4U/ntvpq4BGJwWGyNAIJQwT5wGf5Mt6QIYSDXXAFCdmVOtwhZeB8=',NULL,'0',1,'1640908340'),(13,1,1,'text','xXl9WlPFKceg4gQf7N04CgAFEJfa5U8n3pF0c6nEWf+7KvF/IlGhyNkXyvrvAZ1pvF51GZ+2tkjoFHkn6fuslvA4MTuOi39YnwtXk8P5GJlg==',NULL,'0',0,'1640938596'),(19,2,1,'gif','Text','{\"static\":\"https://media3.giphy.com/media/LTYT5GTIiAMBa/100_s.gif?cid=5c00e1094jxavhx2fpx89lsfkfv4criaefrj4eswqjmy5za5&rid=100_s.gif&ct=g\",\"url\":\"https://media3.giphy.com/media/LTYT5GTIiAMBa/giphy.gif?cid=5c00e1094jxavhx2fpx89lsfkfv4criaefrj4eswqjmy5za5&rid=giphy.gif&ct=g\"}',NULL,0,'1645100699'),(22,1,1,'gif','Text','{\"static\":\"https://media3.giphy.com/media/LTYT5GTIiAMBa/100_s.gif?cid=5c00e109gi2nyua91synuob6at8u78jp6rg8v31z0nhu70mc&rid=100_s.gif&ct=g\",\"url\":\"https://media3.giphy.com/media/LTYT5GTIiAMBa/giphy.gif?cid=5c00e109gi2nyua91synuob6at8u78jp6rg8v31z0nhu70mc&rid=giphy.gif&ct=g\"}',NULL,0,'1645101589'),(23,2,1,'gif','Text','{\"static\":\"https://media4.giphy.com/media/UO5elnTqo4vSg/100_s.gif?cid=5c00e109vnhvyqxdtfe9lntcoo709vzdh5b3x7tn98ifnewp&rid=100_s.gif&ct=g\",\"url\":\"https://media4.giphy.com/media/UO5elnTqo4vSg/giphy.gif?cid=5c00e109vnhvyqxdtfe9lntcoo709vzdh5b3x7tn98ifnewp&rid=giphy.gif&ct=g\"}',NULL,0,'1645388760'),(24,2,1,'gif','Text','{\"static\":\"https://media1.giphy.com/media/iJJ6E58EttmFqgLo96/100_s.gif?cid=5c00e109sjz77eeayuu8aoaunbbmm8yk70bzg2sqdsv3bep9&rid=100_s.gif&ct=g\",\"url\":\"https://media1.giphy.com/media/iJJ6E58EttmFqgLo96/giphy.gif?cid=5c00e109sjz77eeayuu8aoaunbbmm8yk70bzg2sqdsv3bep9&rid=giphy.gif&ct=g\"}',NULL,0,'1646553480'),(31,2,1,'text','WsVsKimG4OnAH8jDWNDlPgwKEP5gC5RT8MxfKMCgaEybLNQ5lOsrM80/SSLPw6+84notiNxte09xOAjhfNORF9wh0is427Qk54dxcypHnpK1hGIJR5FN7LMjXQlhNjagZwBd/o3JvtGSQRRb0YTnlV9R5kgUAjOonhXO0TUX8G8ZA6fYAPeGB1vZiUwEA+yV4=',NULL,'0',0,'1646680946'),(33,2,1,'text','sU0n8iyGKi0k1c9Jtbvp6gXgyb6/Qr5I5+Q0X6QPFrp9/VbxjuqRX3bHUmDZUGhhCUQTdZrJ66iGo3KYjKztrxNJs93JuXeYFevEoZ6InJerAg74XKLK/mLAaqY09r4wZsIGFwAWT1KZmlPKLQ/DYmxadX6qOFh+K/c0aZF1IXREjUPsWVhanlFB4Dq+cWanI2ZzLG6zA+EAsshHzESSFU',NULL,'0',0,'1646681060'),(34,6,1,'text','qZyDOM593nHzmYPMJP4cng2SrkmjhRBW2SdLqOHknkZ0iKWDzyFFR2owzvUj3Z5xMLx8O1jHLBCKzm2SjeVCiuyMJibr2c6UF+as1pu9QSvA==',NULL,'0',1,'1651908406'),(35,6,11,'text','XTMI73BvowVlAbw0Yc76yQhTD3J203NuJ+NKdC0L9Fi2iIrvYO2+y4h4ALT+X7EhMyzKuXg9vm0ldSxyQwLw58',NULL,'0',1,'1651908464'),(37,6,1,'text','KzePD0f6vExT6iFDhakoNglpbBjx/c/eBUdTogCOm2cg2o3bIFAgYzA+NZWYE9kS5bvTiVcIcAVVDOWQ0wUau4',NULL,'0',1,'1651908482'),(38,6,11,'text','Fc/U1OxfacTGV7PKhGCH7gph4oA9+rs4kkvfdxivbv4YUlHj2I64M/bfucLS8bxCR8m3YVJcVRBhhxb/fvYdwuEVe0tMy6NvQz80myCQ5hew==',NULL,'0',1,'1651908507'),(39,6,1,'text','bXTXi9JxkIfPdi3Zjskp5wPxOOMnPxC8lp2ryGxv4YW4bsLPdIVOgNHinJqy62GfI7HpkW18PVQwOFvxOJTFyu',NULL,'0',1,'1651908517'),(40,6,11,'text','UQ7I1IB6HU80StlJZH4PdgMFvUvE9CM96RR0N2Mtnv0Yr/ERSYLdrQDahQbx5GbNZRLjhuGn0J8/ViFtrUaDn8qRuis/oBy+No/XOpKXD0TIeT8JtqoSgwhNwkTyi+CZdZDU3JdbmLu0RWqEtAl3CMzVLBiJsjQINoLDeOIdD+PC3b53XrNdFum9MmK23SByYKjz8SBRrtJQFfaXoFm5vI',NULL,'0',1,'1651908531'),(41,6,1,'gif','Text','{\"static\":\"https://media4.giphy.com/media/8H80IVPjAdKY8/100_s.gif?cid=5c00e109u5i9ckzsgf3tbn8mz40ho3b5e0jf1q7eyqer09pv&rid=100_s.gif&ct=g\",\"url\":\"https://media4.giphy.com/media/8H80IVPjAdKY8/giphy.gif?cid=5c00e109u5i9ckzsgf3tbn8mz40ho3b5e0jf1q7eyqer09pv&rid=giphy.gif&ct=g\"}',NULL,1,'1651908536'),(42,6,1,'text','71y58yomuYetiZIePciHxg67LPuZBWOd6VwMFYGz/loyAW9kicu5Q0eELGsnccgPIvj/Rw1GVxeHPT74FOwLV+z8zvbwidI8ivz/SuBtBFi1i9sl06pP7jjvdk3HwdtlXtpk7jPlHzTqk6apumw1gG',NULL,'0',1,'1651908553'),(43,6,11,'text','aCbMULTBpoBpvAVb2R/XCQTkF4p8iboDevb7ektjsj/y9aP+RqdzmXZFMCXCHXByw4T45CK0ymdN+w8FYWcfub',NULL,'0',1,'1651908558'),(44,6,11,'text','Nk8p4okSMLOdVZly9+fXHAPqGGgVBke3HBJTLmcT/r0L+F6UV0nW8KPW7tseY5lPgV3l+T5g7jcN4POLiA+ypR',NULL,'0',1,'1651908561'),(45,6,11,'text','ydqsqI6S8kG0WTtiupUXAwY9Ej6BWTceoe+nnedF/31ozdfKYQQCn7H9ai+WBaAde8HIVOmDpxqwjJCH3CIvhUESPYAGEPM4Q3ZjbXDsF4kg==',NULL,'0',1,'1651908565'),(46,6,1,'text','lj7JrFqR8YhEunFNnZOgKAA4wL7PMjbtnzS6T2Gii8UokGeOjH2pgWT4+BoUDc/wMCtmuIDx6mYEL2IfIMOWTMqhwkoVZb0AUHm5pHVPsBRfdEpsf3ZXachB9G1Df8/dMOkJIFscdbCZmORsKci86Jv0MuNgtUkomzCpo3i0qI/w==',NULL,'0',1,'1651908598'),(47,6,1,'text','FlY4AgkmO/IlZSYJuyRiNAwDLQ7vU1VM4dyKLXZL2sU0VWJhNXkXZMVarzv3f5xJaTa/2I7Vc29ATckpX7hIkynsXeQaOfF5CI/JviAIPLuQ==',NULL,'0',1,'1651908605'),(48,6,1,'text','w64xyluX/R9uzbjDitYGIQ+Ov4xYjRngykNWrmsVAenh1cW/3Dwq/84TZDdbMogZ+qBiUSPIPXKc+OJrH8D6WVBSFQ+9yhmN6Hf35/9CMVUt++FPZtVYDTiGn8ysHybqA831I3mZguXHPdoGapcqQD',NULL,'0',1,'1651908610'),(49,6,11,'text','gbD39kLejnK8bf050KHQNA7gvm0qUd+hsfuHgCcl+B8pgwK4AyX/GOFWA5QmzvdAd+kaw/sLlzQwnvGt+fWJv3',NULL,'0',1,'1651908618'),(50,6,1,'text','ZlQTaWATUioxsNzjFH15WQBB8N8buozP16MAWRXljw2DUUMy1GkH1EzgfRS2kQkvKMOS2qlOBN4dfZG893g0i3',NULL,'0',1,'1651908646'),(51,6,11,'text','As7Ek31gqmjCdF1JilsqMwWBnBLGgdZllbh/HtogCgkul60/w95SxEpIcoJXa58PFoJt6cWWCkOz+xK3nTCdrt',NULL,'0',1,'1651908654'),(52,6,1,'text','mnlmvBEOVSmV6SuDChGa7AfFWBsF8BZY/szUJPkBBL5dnBq58Wqwp5E+x15hJgh7CxN5ypGoM20EpbCCttMSz+8hFB3WQEvLrDYY238VfhV4gxxapHk4379MyHLnKj/2yla+u7IpOMwsH3e3ZRZffdSAQ4Dj7x42B3HoTjO7G/Hswr7J9D37ZB9RhYm8ilMZSEEjRfdk7PSffwv3AMjOR8',NULL,'0',1,'1651908666'),(53,6,11,'text','XHohgEZ1OFY3VCLYJ31A2A6IYpY6XiJ9u92hBN09FTDWbsoDlU0npkHSBwK94zg8rMWGOOaY9k10hphUcyCDEW',NULL,'0',1,'1651908677'),(54,6,1,'text','HPbhywOPcpBIlBtl+Zd62AgfXDoZOPbjDigCUrMJxN5IVuXF5WCKqfF0joyUaOPvYYKmb0tnZD0Z60MHXNlLEB',NULL,'0',1,'1651908682'),(56,6,1,'text','eSeyWia7sCLChVOvZGF2Hwn5UQ+P8KqBn09r6B6PWLJ0Vi5xWgvoTNP2yf+buRxHzFvtqRszbSAbWrv1UuSkTxF5uajZDCATWUm6hFuilRTVh3Cr/gEJHCKSAMOxM5+/0ws6ItUjjFz7ZXAnAA6co3',NULL,'0',1,'1651908690'),(57,6,1,'text','LkF/PAx+6z4ijcZVtXDyLgIizBzh/G0JEt0IIEovuLX07oCrGb38j7CX5mTXhKY6pWi2NJnalnMXVFsyYj03wSMzRSPMFLMnkVVUcDXJfAVQ==',NULL,'0',1,'1651908700'),(58,6,11,'text','tTRbxbm4+KZTCAJ4+YrNZAQ5Z2l6cRBIpwUBFYW9o/eRCNVMOfPDpxRTJNTJeTjonoKd+7En8Obj+mKFJb6uqQMOhBoU0uou1DUS6yoCDpbLFhCiWAYZNvIESM8kowX9Q=',NULL,'0',1,'1651908722'),(59,6,1,'text','q8K2wlE2+52d1ajbVwH+CgHn333PWYciFoVENJL1M3OYEfoXERTrs+A3fOydvyk1GHC5HMiXYmxH9DilnoIpJC',NULL,'0',1,'1651908729'),(60,6,1,'text','/Y7IpcyTL1QdqT/xo2uSAwcoez/5W3TDtNfAeq8Qpvuf65i1VuLj2Bx71Ibk1mAEZxBLh2GLAvvidzsHLjypCqlINHpKEjcJUV6CSehyRgKY1TZx9Nz1d/rdPqLqpfK4JZVcpzSFHoNUuxwdTjYJ+E6jMteaHF31qjlbv0jPi+VNk5e/k032wKaf0gFN2x4LY=',NULL,'0',1,'1651908767'),(61,6,1,'text','J+kPCiK1HjBfrindczyieAV8kbta/y7sa4gyGe+erKHE8w/nQjXgQjxlUXiyYLPl1qEupYi/dcknaFzZDDLgidvGcemcsXBrCrZKIyn1n4WJakz/kDtDniJ2inLYhhtDV0Zpr8Pthi8KT1HvFDcSGCwqU6XzQ8KBsX93nNzMBTG+iMNt1tUK+/STzFyN6LEWEsK10+RXpHCzfRU+GAfj5lWKRqNKw4aDXfzx3w6JruDQ==',NULL,'0',1,'1651908927'),(62,6,11,'text','zp/T5SUxEF4O50uDNXnw7wcps8dunTqY/TQPnwFJvzKlSn2uRQD1B4rA7+5cuQ/iRZtmrSkId8LrWV5QBrN4keVfvjVAPMx4HgQMjydLG+gQ==',NULL,'0',1,'1651908931'),(63,6,11,'text','eN24qkg9trT7XbeMglg6pQaT9FBl57dnkm6zwRO2VG2EohOkDUiwJA85udDaSMDcH2leWrU6BcaU788xqGlMsmsFIs870v37Xvt12/7Q2BeA==',NULL,'0',1,'1651908943'),(64,6,1,'text','Wk+7sxwCaa1SPnzU7bIQGwWKEzvy7VWE0Iy+yLJgGr+8ooze9Vb65DKQE7MiQqDXLqqwAqdjaNU+i0R50T+Gdd+M5GIhNU4Qt0hqSGEfbiNGQ/4DVJG2XO4mNR/K+dNOXtjlEiPTz2BWflXXDQtoZyEl4+IGMFxJhJ1UPOh7PPDusFkbSH0E+gPb/SVZAsEjk=',NULL,'0',1,'1651908959'),(65,6,11,'text','JrlrtfBRKXfzCnc1Q0Bt3gVMheVFrAiycsz18xtrC0hC5iawTTkS4Xnz5X5r5W6T1XEBFAwy4H1JkABoZ+ubvW',NULL,'0',1,'1651908975'),(66,6,1,'text','Y9Z3LoBPIzxujAoXxVv+nQxtzrVaWXba7VTs/+tvyW9Wn2E66I8iBvB7CY0yWrJcPgAJYV6EtxFfkGA5UE3dg5Y4VX7dUxsS82t36CrGGy0Q==',NULL,'0',1,'1651908988'),(67,6,11,'text','dKnG1rdb8JXlu4wW7mO8XAvZy9GXls1DTWN+KNN5IzTI01hrNyyrKdjoOSllgFvH6I9bKwOa3/c8tFFDKaLE4Vf5YKV0gAP49LGkEK2h6A1ghvfiiemM9M6vk2AL9ENg+lu+jj4oDCEOZ98q1ZWYqic0hjDQ9dcQmsiPvppmxdvG+ubpW9D+0b6t6ST5GZPEMMYaMDvP5uP68tw5QN3ZF2wzmeq/iDiPiC66R991kK+ceN6VIHs/3/1Nz4/LtqcIFXn0IgFvaTLqWaLizr6gSF',NULL,'0',1,'1651909015'),(68,6,11,'text','Pg9abNNDWYTdy/RCToDOXwhJ8OsnW3AQ2Fy6AoMSEnh9otnKe1G10mHj4ZkawU46EjliloxB255aJ76de5JN9VJIh1deuRHklIZrZgQ0Kpow==',NULL,'0',1,'1651909030'),(69,6,1,'text','uM+sBwSTeeYeENSOi2i1RQvp16MlAHcHkwjzJl/QFahZnXu32+2dlVNJRZlsY8W72nf7mGOgkS0zv3AFupj1DQPDA93MBLBQcTIE6nJ7taOSBbqSzcqBGDppC+IFluQcx2fUL6Iak1NFUatMYdpKhU',NULL,'0',1,'1651909031'),(70,6,11,'text','CNrq/j5Kleq+ewKO1UyiCgCPqNsFmtVImYmEpsD9j3PVzB9hwQpxjUXwDCJ7wX5w7PwhYiA+OmFTWZRb1GJX0kCLx0qlDjdbF6cGJ9R7Ia9A==',NULL,'0',1,'1651909045'),(71,6,11,'text','sG0Vqrvz1sOJliSeOdT26QeoUra7LMgqVQhY35XTZdQJ6x9x98Lgij2jZ6ZZVubaaJ7mxtJi7dWpZXYdm7fO4O',NULL,'0',1,'1651909049'),(72,6,1,'text','ij2qF28U/dsD6jHdgCKq5wXvkjsZg6dIbyGUSSNUjyIWWwe3PFMfGEzLnG7602Tf3kiz7LDyu+s6IoimeXU06WAlnmudzglcoVkG5hJI6Uug==',NULL,'0',1,'1651909050'),(74,6,11,'text','B9vGJxsqts+hvOrT+6qOUgHBGPYiSPhFfXT4xuFYxWv1LshhiCZ4k5/9v/YRrSFdU26dSy4u2Q2Jv0XwdTyA+OVPIJFFOh4yyrP2cYR4gPLg==',NULL,'0',1,'1651909070'),(75,6,1,'text','Iqxeu6vs56ZZCCYF0cA6oQ911EiU3DlBZJCE4ypzu6Fq7uPtwOr5tt/P8NzAPEXkh8dh0Uiz6AP+VTNj9+Yc4MgEmNP/1xRrBnb0Q97LK4xQ==',NULL,'0',1,'1651909084'),(76,6,11,'text','nuscsxUPts2haPHIussqRAP2+RMenCDI3X8LFvC265aprJ2IKZ4X2sB/PV9eCNCO4hoIO61t/KoQE5OatZ56s2jWAYjf9tfqM4JoPM60gMMcrI+ODaeQHd+SDe/zhWChw=',NULL,'0',1,'1651909145'),(77,6,1,'text','saBXH/LOB6bJw+9PaMQP6gNLjiwZrCogD+HSzQZt57hF2p9zQb1nniq1vVyKzyEUfeyC1ty9ZM1G7I9m9FojlBlSqdhKK7xIKhn16E1HsB7Q==',NULL,'0',1,'1651909158'),(78,6,1,'text','zOtYzI3HbYurhC1cKOiMkgtcpTjH0fcFGoVpaSuY4/Ek9ZC7uSdqEGvUyRcUEAErKtz7XabQX1fHtG+rtzhVC4',NULL,'0',1,'1651909164'),(79,6,11,'image','Text','https://sun.qwaker.fun/uploads/izbalolist-MESSAGE-20220507103928-876139.png',NULL,1,'1651909168'),(80,6,1,'text','PT9BZJd2EgQWDhQcYrMh9wFar2C8VGEleH8EJBnfce1UtIFMqtjp3y5pWk77yKTRo/YIySDBmkEWYdrXvCNDEX',NULL,'0',1,'1651909178'),(81,6,1,'text','4mLFoh9NM7cevEIaH8Q6LwV6M+6dMvsEyg2KQLUAQckvm3iIuh/nlclyIJBRtI77qoVezOATSwJey58uQhOf1j68tb5EfdS2ba+MdIbW1Xw7pndJySAikIuofYjc2Lnok=',NULL,'0',1,'1651909185'),(82,6,11,'text','21gTTJpCI8fpoX2irqot+g/QbddxcpVJvYgLmZNlG+OaZmLuW3s8dYaDWyZ9mLdJQLNzTh5CMgCQLO3LFjVsKPc8c8R6Ie4NuiXxVnO+HryO/x4RUEB9SHLyO5AmzWVtKZ1BLVAZEaFPhLwCHm3qzp',NULL,'0',1,'1651909193'),(83,6,11,'text','7Npb6iAFOwVlzGBCT8cxxAVMB9ZX4HFiH0urLdm6/oD9bitdTXjl0ZTz/yBSAGpYE3Za/HLip56an5alMTbn/8ZbGW29VzaB59s4Eo9+jw3g==',NULL,'0',1,'1651909207'),(84,6,1,'text','fDbEbpCYJUh4VmMqlBrbwAB2lAmPeBDOg08PAheDEkZHs0gqD3/swRRbVVqyNdfupwebgDQP6NvKCfOgh3hc+U',NULL,'0',1,'1651909207'),(85,6,11,'text','nj/rWzDpJCfwFbl7iXoklQPEj+UsvoaF5kACuAV6N3k/sWWrG6ej0Saa3JobMqFYMrJ+GBIde7ixwrS7tpc+3467DSncbMACec5StcdGiZD7FO7VeeW6O1Ep2H/Ske1YE=',NULL,'0',1,'1651909240'),(86,6,1,'text','4W/+13a874dKOKVesNc0uQGoqbOKg1zgyf7XlZ02kS8vsGOuYO1PyhfmPv1fahNWvKqiz7SZVtslDqUXMRyt2ZpQ1zMyRf0psykvxrKxINMg==',NULL,'0',1,'1651909258'),(87,6,1,'text','gcJ15s5N65VHQ9Il63iv3A9C+PEnbFEaIfOr8f/rGH2mrEOdM8Q7d/ieqApoPkZ75rfBRCoABu0LuVfi11Q6oW',NULL,'0',1,'1651909262'),(88,6,1,'text','BUPdwleQxXYQzeQp+2CMYAnDM/uLAaJBGROs8cJelJoT+UQ6MkOWapjK/lWKs6yyd9Rw5fgHQ8l/lFprMiolQA',NULL,'0',1,'1651909268'),(89,6,11,'text','WIFbix1+XQMt0k0/1id1YgOV71r4AF1uPN6iRXiNk3wZQ8NjIVp4CeTq+iVmW+OsZIETfDsgeBzKOWxHh+e5ItL8EPN5iL5Dlhyy68O2a6gw==',NULL,'0',1,'1651909270'),(90,6,11,'text','ckicdo2EMyKkGEOnPgst1gUyx4+C7CztaGA4KwlWiNNJMsPcDcg7K9Os2EPh13vywy8ciMtyPxWJHiVqOppZ94/yExFTCtW4qVveV4Lk7Ohw==',NULL,'0',1,'1651909291'),(91,6,1,'text','2oGkhS+LyiDbTdG17QSerwLTiAkSKjBrGMpfiW32Q9WD7vO2WVgk2ZVRl9qMcz7rngGuDXi+YAxHfxgxAfs/nx',NULL,'0',1,'1651909301'),(92,6,1,'text','ihHF6vqAplvyFLlo0GR5OgNQt3KwtqnxF5VIjIXN9+2ETXC4NBcDpG6d0548tdKCBi5x8p/QXaFxVkVeVcJSrsDaPB4iofC1F7+bkecklJXvnJCkum7kcPm1+PiZ9QBKaCouuZqu4NceyPseooTPaQQFEoJ+sElsgSR/D9NaDctQFwqwe9wPKNSMvEvSQUVx+OwxgaWUeo3DkGWVg4j0IoZDc9+DrfZNZd4GHRSD27vjRWfP44oiPYdimyVnR0v6zdlVhKHG9RvhT9EuLLiGNPpvnLCzxBvr3F491ruFs8Y6khhpffkcu6ECEHvzpm7jA=',NULL,'0',1,'1651909461'),(93,6,1,'text','1rWi7gLq9jJ0JXjG6qJ9lwhGV6MoR/2E7s/v6UpOOGD9CE5CDlW7dxh0w5bHRbTQDPT09M2d+a8Fq/yHrGpL6pIz7QOqGGDoiSfq1gumf5tA==',NULL,'0',1,'1651911209'),(94,6,11,'text','jK0FguvS6+/jns3QegW3dgEm3QTyeGsuCuG1CRmzaIDJN87C8CaKF1VBg5Qj6M+LKIDhjJOVKdbb2VUbys10aJ',NULL,'0',1,'1652295349'),(95,6,11,'text','m3FhqOM0lwcGmYnNJ8ID7wUNObvx2XOSJDTv5C6H+tFj46QAqHBfCEK1bwcb6NSBVn1jBSmq3Ivu0/RQoHDo5nwN6q1fNDChgoUtarkSoNlcJ8465nzrPOSMi89sxHe9U=',NULL,'0',1,'1652295358'),(96,6,11,'text','XMmnkFtRIhQZriQpRZ1FQwXoEl6SqoOIvok1K3L9xjRcBjovmz0XRAGxjW3shZJWpCvgoP6NcgbIrS4r/FYXkeefibFcw+7UKJ0MW9ia7PCWAF37/ahpkUJkcGhk4GFV8=',NULL,'0',1,'1652341565'),(97,6,11,'text','jgXmdBmZxgMgvG72Ba0TMw1AfJFK6X/2sJehmTuUFbjS8y9Guw6wW7T0lfr+SyKd6IqnILHMMtowgLIMxzaAyk4fJRGVwBVjGRbcF2pSLOItojYLBlA9YLOrdqqYYR+Ek=',NULL,'0',1,'1652341573'),(98,6,11,'text','VwXFnpDcyqlROdEUxNTk3QO2I1Vp/IyJH2kmD8FkhQabwx9B6ugyc23MF9m2BJHA/aY2QIFeNctQ6dXD4bTMmOJx4yeuqzsRvqQAgQ2+yaeQ==',NULL,'0',1,'1652341583'),(99,6,11,'text','PcxfxxGDYk+UazcIHZPxiQwHLtsKwzZVCR1KdzpclRjJAe71zGxmIOd4gdogRUNpJh1MQ60MxCYNKGuW0Tfvtl',NULL,'0',1,'1652341590'),(100,6,1,'text','A5qJPPtK6PEJZuQnrD4NYwWKSVT71hvIA6VcXr+ENVh1H5wlbqvpONolFt979KqrlaVkT2uczTGDYwpS2fbDqtP30j3ommVG13aduvgxZgEA==',NULL,'0',0,'1652344770'),(101,6,1,'image','Text','https://sun.qwaker.fun/uploads/mixno35-MESSAGE-20220512115049-366503.png',NULL,0,'1652345448'),(104,2,1,'image','Text','https://sun.qwaker.fun/uploads/mixno35-MESSAGE-20220701145920-346859.png',NULL,0,'1656676760'),(105,11,1,'text','hFNtYkTvP11NMG47pl5ydQhzbJxVbpPvOZlTLDk6GfZAmnsJ/qIGelEIN5ngVG9M8WYiBpnrF05GCOVVO/w8Ji',NULL,'0',1,'1658249698'),(108,11,13,'text','oafCjWFVmmLEQJYsb8xc5w1OfaNX5A+SrkC3+HYwiB5dn8i3wVU+/mu0X3K4cBLZrTrzAKJK5pkYu/w/yKnAHR',NULL,'0',1,'1658337717'),(109,11,13,'gif','Text','{\"static\":\"https://media1.giphy.com/media/hFmIU5GQF18Aw/100_s.gif?cid=5c00e109akwyule7rxyfcjcucja3dou5t83i5pr5p2bmdqp9&rid=100_s.gif&ct=g\",\"url\":\"https://media1.giphy.com/media/hFmIU5GQF18Aw/giphy.gif?cid=5c00e109akwyule7rxyfcjcucja3dou5t83i5pr5p2bmdqp9&rid=giphy.gif&ct=g\"}',NULL,1,'1658337943'),(110,11,1,'text','KOH0rdF4DLz0uvJjGkJqkQ7J6/8tMgpEOrAXyCiBv0p4jQCoH1IwWOHgkA7r6rycc+9VB7MI29NqZyIUj9pqYn',NULL,'0',0,'1658348036');
/*!40000 ALTER TABLE `dialog_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `date_follow` varchar(30) DEFAULT NULL,
  `date_confirm` varchar(30) DEFAULT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (7,7,1,'2022-02-26 03:01:17','2022-02-26 03:01:17',1),(14,1,11,'2022-05-07 10:26:29','2022-05-07 10:26:29',1),(15,11,1,'2022-05-07 10:27:20','2022-05-07 10:27:20',1),(16,11,1,'1658228063','2022-07-19 15:24:36',1),(17,1,13,'2022-07-19 15:05:15','2022-07-19 15:05:15',1),(19,16,1,'2022-07-20 03:01:12','2022-07-20 11:27:25',1),(20,15,1,'1658307955','2022-07-20 12:25:24',1),(21,13,1,'2022-07-20 20:22:23','2022-07-20 23:13:40',1),(22,20,1,'2022-07-21 00:18:13','2022-07-21 00:19:44',1),(23,19,14,'2022-07-21 00:20:54','2022-07-21 00:20:54',1),(24,19,20,'2022-07-21 00:21:14','2022-07-21 00:21:14',1);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invites`
--

DROP TABLE IF EXISTS `invites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invite` varchar(500) NOT NULL DEFAULT 'XXXX-XXXX-XXXX',
  `date` varchar(250) DEFAULT NULL,
  `date_activated` varchar(250) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `utoken` varchar(250) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invites`
--

LOCK TABLES `invites` WRITE;
/*!40000 ALTER TABLE `invites` DISABLE KEYS */;
INSERT INTO `invites` VALUES (1,'2a4f8f15c1911c4333371287f792afd8','1647336991','1647337238',1,'e57237f71a5f424c236b049fe4490fd2',1),(2,'4d449f6ca64fd1afcb4b6dc58eb780ae','1651858451','1651908215',1,'034ccb0f4aa0e96506a5d2e79400b233',1);
/*!40000 ALTER TABLE `invites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'system',
  `category` varchar(20) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `message2` varchar(200) DEFAULT NULL,
  `message3` varchar(200) DEFAULT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `date_public` varchar(30) DEFAULT '1997-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,1,0,'secure','sign-in','37.212.5.217','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-25 17:48:15'),(2,2,0,'secure','sign-in','5.18.158.149','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.114 Safari/537.36',NULL,1,'2021-11-25 17:59:13'),(3,2,1,'user','followed',NULL,NULL,NULL,1,'2021-11-25 18:04:24'),(4,1,2,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','like',1,'2021-11-25 18:11:36'),(5,1,2,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','heart',1,'2021-11-25 18:11:37'),(6,1,2,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','respect',1,'2021-11-25 18:11:39'),(7,1,2,'user','followed',NULL,NULL,NULL,1,'2021-11-25 18:11:42'),(8,1,0,'secure','sign-in','2a02:bf0:3200:d401:0:b:1b1b:fd01','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-25 21:56:34'),(9,1,0,'secure','sign-in','2a02:bf0:3204:f04f:0:f:e076:d901','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-26 00:21:35'),(10,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 12:02:03'),(11,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 12:28:32'),(12,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 12:39:35'),(13,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 12:45:03'),(14,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 12:54:38'),(15,3,0,'system','sign-in-other','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36','vk',1,'2021-11-26 13:03:10'),(16,3,0,'system','sign-in-other','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36','vk',0,'2021-11-26 13:06:28'),(17,3,0,'system','sign-in-other','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36','vk',0,'2021-11-26 13:07:08'),(18,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 13:12:22'),(19,1,0,'secure','sign-in','37.212.35.2','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',NULL,1,'2021-11-26 13:26:02'),(20,1,0,'secure','sign-in','37.212.33.80','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-28 14:41:31'),(21,1,0,'secure','sign-in','37.212.33.80','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-28 15:05:49'),(22,2,0,'secure','sign-in','5.18.233.80','Mozilla/5.0 (Android 11; Mobile; rv:94.0) Gecko/94.0 Firefox/94.0',NULL,1,'2021-11-30 16:46:32'),(23,1,0,'secure','sign-in','37.212.15.236','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-30 16:54:39'),(24,1,0,'secure','sign-in','37.212.15.236','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-30 17:01:23'),(25,1,0,'secure','sign-in','37.212.15.236','Mozilla/5.0 (Linux; Android 6.0.1; Moto G (4)) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-30 17:10:30'),(26,2,1,'user','unfollowed',NULL,NULL,NULL,1,'2021-11-30 17:38:25'),(27,2,1,'user','followed',NULL,NULL,NULL,1,'2021-11-30 17:38:27'),(28,2,1,'user','unfollowed',NULL,NULL,NULL,1,'2021-11-30 17:38:28'),(29,2,1,'user','followed',NULL,NULL,NULL,1,'2021-11-30 17:38:29'),(30,1,0,'secure','sign-in','37.212.15.236','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-11-30 19:43:22'),(31,2,1,'user','followed',NULL,NULL,NULL,1,'2021-11-30 19:45:06'),(32,1,0,'secure','sign-in','2a02:bf0:3202:4dcc:0:11:66a6:cf01','Mozilla/5.0 (Linux; U; Android 10; ru; M2006C3LG Build/QP1A.190711.020) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/70.0.3538.110 Mobile Safari/537.36',NULL,1,'2021-11-30 21:20:42'),(33,1,0,'secure','sign-in','37.212.6.12','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-12-01 13:28:43'),(34,1,0,'secure','sign-in','37.212.3.158','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',NULL,1,'2021-12-04 17:18:09'),(35,1,0,'secure','sign-in','176.60.168.78','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.70 Mobile Safari/537.36',NULL,1,'2022-01-26 01:43:29'),(36,1,0,'secure','sign-in','2a02:bf0:3202:bc20:0:2:b7d1:ad01','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.98 Mobile Safari/537.36',NULL,1,'2022-01-31 04:04:52'),(37,6,0,'secure','sign-in','37.214.58.14','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36',NULL,1,'2022-02-02 11:58:05'),(38,1,0,'secure','sign-in','37.212.37.237','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36',NULL,1,'2022-02-20 16:31:12'),(39,1,0,'secure','sign-in','37.212.37.237','Mozilla/5.0 (Linux; Android 10; M2006C3LG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36',NULL,1,'2022-02-20 19:47:54'),(40,2,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-02-20 19:48:30'),(41,2,1,'user','followed',NULL,NULL,NULL,0,'2022-02-20 19:48:33'),(42,1,0,'secure','sign-in','37.212.26.49','Mozilla/5.0 (Linux; U; Android 10; ru; M2006C3LG Build/QP1A.190711.020) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/70.0.3538.110 Mobile Safari/537.36',NULL,1,'2022-02-24 14:29:51'),(43,7,0,'secure','sign-in','2a02:bf0:322c:2212:0:10:194c:a101','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36',NULL,1,'2022-02-26 03:00:39'),(44,1,7,'user','followed',NULL,NULL,NULL,1,'2022-02-26 03:01:17'),(45,1,7,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','like',1,'2022-02-26 03:02:26'),(46,1,7,'post','emotion','5','Ð’ÑÐµÑ… Ñ Ð½Ð¾Ð²Ñ‹Ð¼ 2022 Ð³Ð¾Ð´Ð¾Ð¼! ðŸ¥³','heart',1,'2022-02-26 03:02:31'),(47,1,7,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','heart',1,'2022-02-26 03:02:34'),(48,1,7,'post','emotion','5','Ð’ÑÐµÑ… Ñ Ð½Ð¾Ð²Ñ‹Ð¼ 2022 Ð³Ð¾Ð´Ð¾Ð¼! ðŸ¥³','like',1,'2022-02-26 03:02:38'),(49,1,7,'post','comment','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','Cool bro',1,'2022-02-26 03:03:04'),(50,1,0,'secure','sign-in','37.212.1.4','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36',NULL,1,'2022-03-06 10:53:24'),(51,1,0,'secure','sign-in','37.212.1.4','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36',NULL,1,'2022-03-06 11:03:02'),(52,1,0,'secure','sign-in','37.212.1.4','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36',NULL,1,'2022-03-06 11:17:39'),(53,7,1,'post','comment-reply','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','Hi bro!',1,'2022-03-06 11:21:49'),(54,7,0,'secure','sign-in','37.212.1.4','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36',NULL,1,'2022-03-06 15:14:05'),(55,1,0,'secure','sign-in','37.212.1.4','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36',NULL,1,'2022-03-06 15:19:09'),(56,1,0,'secure','sign-in','37.212.34.217','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',NULL,1,'2022-03-07 13:45:16'),(57,8,0,'secure','sign-in','85.140.5.81','Mozilla/5.0 (Linux; Android 10; SM-J610FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.87 Mobile Safari/537.36',NULL,1,'2022-03-07 21:58:20'),(58,1,8,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','shit',1,'2022-03-07 21:58:50'),(59,1,8,'post','comment','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','Ð›Ð°Ð´Ð½Ð¾',1,'2022-03-07 21:59:08'),(60,8,1,'user','followed',NULL,NULL,NULL,0,'2022-03-07 22:05:55'),(61,9,0,'secure','sign-in','80.234.58.255','Mozilla/5.0 (Linux; Android 9; KSA-LX9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36',NULL,1,'2022-03-07 22:06:25'),(62,9,1,'user','followed',NULL,NULL,NULL,0,'2022-03-07 22:09:49'),(63,1,0,'secure','sign-in','37.212.7.250','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36',NULL,1,'2022-03-10 13:30:43'),(64,10,0,'secure','sign-in','37.73.108.1','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36',NULL,1,'2022-03-15 12:40:48'),(65,1,10,'post','emotion','5','Ð’ÑÐµÑ… Ñ Ð½Ð¾Ð²Ñ‹Ð¼ 2022 Ð³Ð¾Ð´Ð¾Ð¼! ðŸ¥³','dislike',1,'2022-03-15 12:48:36'),(66,1,10,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','dislike',1,'2022-03-15 12:48:37'),(67,1,0,'secure','sign-in','37.212.39.233','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36',NULL,1,'2022-03-20 12:27:27'),(68,1,0,'secure','sign-in','37.212.22.23','Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36',NULL,1,'2022-03-21 14:03:47'),(69,10,1,'user','followed',NULL,NULL,NULL,0,'2022-03-21 14:10:56'),(70,10,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-03-21 14:10:59'),(71,10,1,'user','followed',NULL,NULL,NULL,0,'2022-03-21 14:11:36'),(72,10,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-03-21 14:11:43'),(73,5,1,'user','followed',NULL,NULL,NULL,0,'2022-03-22 22:37:35'),(74,1,0,'secure','sign-in','37.212.38.236','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36',NULL,1,'2022-03-23 13:13:11'),(75,1,0,'secure','sign-in','37.212.13.63','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36',NULL,1,'2022-03-24 20:24:16'),(76,1,0,'secure','sign-in','37.212.13.63','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.73 Mobile Safari/537.36',NULL,1,'2022-03-24 20:25:25'),(77,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-05 13:37:08'),(78,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-05 18:41:58'),(79,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-06 20:27:02'),(80,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-06 20:47:37'),(81,5,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-05-06 20:55:50'),(82,5,1,'user','followed',NULL,NULL,NULL,0,'2022-05-06 20:55:53'),(83,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-06 21:05:57'),(84,11,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-07 10:23:44'),(85,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-07 10:24:50'),(86,11,1,'user','followed',NULL,NULL,NULL,1,'2022-05-07 10:26:29'),(87,1,11,'user','followed',NULL,NULL,NULL,1,'2022-05-07 10:27:20'),(88,11,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',NULL,1,'2022-05-07 10:34:48'),(89,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-11 19:19:09'),(90,11,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-11 21:54:21'),(91,11,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36',NULL,1,'2022-05-11 21:55:16'),(92,1,11,'post','emotion','14','Elinther - The War','dislike',1,'2022-05-12 10:47:02'),(93,1,11,'post','emotion','11','Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','dislike',1,'2022-05-12 10:47:05'),(94,1,11,'post','emotion','5','Ð’ÑÐµÑ… Ñ Ð½Ð¾Ð²Ñ‹Ð¼ 2022 Ð³Ð¾Ð´Ð¾Ð¼! ðŸ¥³','dislike',1,'2022-05-12 10:47:07'),(95,1,11,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','dislike',1,'2022-05-12 10:47:11'),(96,1,0,'secure','sign-in','128.0.0.1','TreblleTester/0.3',NULL,1,'2022-05-17 17:27:09'),(97,1,0,'secure','sign-in','128.0.0.1','TreblleTester/0.3',NULL,1,'2022-05-17 17:27:51'),(98,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.61 Mobile Safari/537.36',NULL,1,'2022-05-20 16:00:53'),(99,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.61 Mobile Safari/537.36',NULL,1,'2022-05-31 01:05:08'),(100,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',NULL,1,'2022-06-30 15:54:10'),(101,12,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36',NULL,1,'2022-06-30 17:15:19'),(102,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36',NULL,1,'2022-07-03 14:24:01'),(103,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-03 14:29:50'),(104,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-07 11:36:14'),(105,13,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1',NULL,1,'2022-07-18 02:40:03'),(106,1,13,'post','emotion','11','Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','shit',1,'2022-07-18 02:40:43'),(107,1,13,'post','emotion','11','Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','dislike',1,'2022-07-18 02:47:20'),(108,1,13,'post','emotion','11','Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','heart',1,'2022-07-18 02:47:22'),(109,13,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1',NULL,1,'2022-07-18 23:43:28'),(110,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36',NULL,1,'2022-07-19 00:04:19'),(111,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-19 03:33:44'),(112,2,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-07-19 12:12:07'),(113,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36',NULL,1,'2022-07-19 12:15:08'),(114,5,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-07-19 12:27:36'),(115,8,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-07-19 12:27:37'),(116,9,1,'user','unfollowed',NULL,NULL,NULL,0,'2022-07-19 12:27:56'),(117,1,1,'system','admin','ÐŸÑ€Ð¸Ð²ÐµÑ‚ Ð¼Ð¾Ð¹ Ð´Ð¾Ñ€Ð¾Ð³Ð¾Ð¹ Ð´Ñ€ÑƒÐ³!',NULL,NULL,1,'2022-07-19 14:32:09'),(118,1,1,'system','admin','Ð–Ð°Ð»Ð¾Ð±Ð° Ð½Ð° Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»Ñ @izbalolist Ð±Ñ‹Ð»Ð° Ñ€Ð°ÑÑÐ¼Ð¾Ñ‚Ñ€ÐµÐ½Ð° Ð¸ Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»ÑŒ Ð½Ð°ÐºÐ°Ð·Ð°Ð½. Ð¡Ð¿Ð°ÑÐ¸Ð±Ð¾, Ñ‡Ñ‚Ð¾ Ð´ÐµÐ»Ð°ÐµÑ‚Ðµ Ð½Ð°Ñˆ ÑÐµÑ€Ð²Ð¸Ñ Ð»ÑƒÑ‡ÑˆÐµ!',NULL,NULL,1,'2022-07-19 14:39:25'),(119,13,1,'user','followed',NULL,NULL,NULL,1,'2022-07-19 15:05:15'),(120,13,1,'system','admin','Ð—Ð´Ñ€Ð°Ð²ÑÑ‚Ð²ÑƒÐ¹Ñ‚Ðµ, ÑÐµÐ³Ð¾Ð´Ð½Ñ Ð¼Ñ‹ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ð»Ð¸ Ð¶Ð°Ð»Ð¾Ð±Ñƒ Ð½Ð° Ð²Ð°Ñ. ÐŸÑ€Ð¾ÑÐ¸Ð¼ Ð½Ðµ Ð½Ð°Ñ€ÑƒÑˆÐ°Ñ‚ÑŒ. Ð-Ñ‚Ð°-Ñ‚Ð°...',NULL,NULL,1,'2022-07-19 15:09:06'),(121,11,1,'follow','confirm',NULL,NULL,NULL,0,'2022-07-19 15:24:36'),(122,1,13,'post','comment','17','ÐŸÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹ Ð²Ð¸Ð´ÐµÐ¾ Ð¸Ð· YouTube!','Ð°-Ñ‚Ð°-Ð°-Ñ‚Ð°',1,'2022-07-19 19:41:10'),(123,13,1,'post','comment-reply','17','ÐŸÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹ Ð²Ð¸Ð´ÐµÐ¾ Ð¸Ð· YouTube!','Ð‘Ð°Ð½!',1,'2022-07-19 19:53:42'),(124,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-20 01:35:50'),(125,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-20 01:55:30'),(126,14,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-20 02:01:37'),(127,1,14,'user','unfollowed',NULL,NULL,NULL,1,'2022-07-20 02:05:35'),(128,13,14,'post','emotion','15','G','heart',1,'2022-07-20 02:06:11'),(129,13,14,'post','comment','15','G','ÐšÑ€ÑƒÑ‚Ð¾!',1,'2022-07-20 02:06:33'),(130,15,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44',NULL,0,'2022-07-20 02:52:59'),(131,16,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44',NULL,1,'2022-07-20 02:53:46'),(132,1,16,'post','emotion','17','ÐŸÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹ Ð²Ð¸Ð´ÐµÐ¾ Ð¸Ð· YouTube!','like',1,'2022-07-20 03:00:47'),(133,1,16,'post','emotion','1','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','like',1,'2022-07-20 03:00:56'),(134,16,1,'post','emotion','22','Ð¯ Ð¿Ð¾Ð´ÐµÐ»Ð¸Ð»ÑÑ ÑÐ²Ð¾ÐµÐ¹ Ð½Ð¾Ð²Ð¾Ð¹ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÐµÐ¹ ðŸ™‚\r\n','like',1,'2022-07-20 11:27:02'),(135,16,1,'follow','confirm',NULL,NULL,NULL,1,'2022-07-20 11:27:25'),(136,15,1,'system','admin','ÐŸÐ¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»ÑŒ @rei ÑƒÑÐ¿ÐµÑˆÐ½Ð¾ Ð¿Ð¾Ð´Ð¿Ð¸ÑÐ°Ð½ Ð½Ð° Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»Ñ @mixno35 Ñ Ð½Ðµ Ð¿Ð¾Ð´Ñ‚Ð²ÐµÑ€Ð¶Ð´ÐµÐ½Ð½Ñ‹Ð¼ ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸ÐµÐ¼.',NULL,NULL,0,'2022-07-20 12:05:55'),(137,1,1,'system','admin','ÐŸÐ¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»ÑŒ @rei ÑƒÑÐ¿ÐµÑˆÐ½Ð¾ Ð¿Ð¾Ð´Ð¿Ð¸ÑÐ°Ð½ Ð½Ð° Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÐµÐ»Ñ @mixno35 Ñ Ð½Ðµ Ð¿Ð¾Ð´Ñ‚Ð²ÐµÑ€Ð¶Ð´ÐµÐ½Ð½Ñ‹Ð¼ ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸ÐµÐ¼.',NULL,NULL,1,'2022-07-20 12:05:55'),(138,1,1,'system','admin','Ð—Ð½Ð°ÐµÑˆÑŒ.. Ñ Ñ‚ÑƒÑ‚ Ð¿Ð¾Ð´ÑƒÐ¼Ð°Ð», Ð¸ Ñ€ÐµÑˆÐ¸Ð» Ñ‚ÐµÐ±Ðµ Ð·Ð°Ð±Ð°Ð½Ð¸Ñ‚ÑŒ!',NULL,NULL,1,'2022-07-20 12:11:19'),(139,15,1,'follow','confirm',NULL,NULL,NULL,0,'2022-07-20 12:25:24'),(140,1,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-20 15:31:26'),(141,17,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (X11; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0',NULL,1,'2022-07-20 17:30:20'),(142,14,13,'post','comment-reply','15','G','Ñ‚Ñ‹ ÐºÑ‚Ð¾?',0,'2022-07-20 20:24:59'),(143,18,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44',NULL,1,'2022-07-20 23:08:37'),(144,19,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36',NULL,1,'2022-07-20 23:11:43'),(145,13,1,'follow','confirm',NULL,NULL,NULL,0,'2022-07-20 23:13:40'),(146,16,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44',NULL,0,'2022-07-20 23:16:05'),(147,20,0,'secure','sign-in','128.0.0.1','Mozilla/5.0 (Linux; Android 11; SM-A125F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36',NULL,1,'2022-07-21 00:05:49'),(148,19,1,'post','emotion','25','Ð¶ÐµÑÑ‚ÑŒ','like',1,'2022-07-21 00:13:16'),(149,19,20,'post','emotion','25','Ð¶ÐµÑÑ‚ÑŒ','like',1,'2022-07-21 00:17:42'),(150,1,20,'post','emotion','17','ÐŸÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹ Ð²Ð¸Ð´ÐµÐ¾ Ð¸Ð· YouTube!','like',1,'2022-07-21 00:17:48'),(151,20,1,'follow','confirm',NULL,NULL,NULL,0,'2022-07-21 00:19:44'),(152,14,19,'user','followed',NULL,NULL,NULL,0,'2022-07-21 00:20:54'),(153,20,19,'user','followed',NULL,NULL,NULL,0,'2022-07-21 00:21:14');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_category_favourites`
--

DROP TABLE IF EXISTS `post_category_favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_category_favourites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(3) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '123411111',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_category_favourites`
--

LOCK TABLES `post_category_favourites` WRITE;
/*!40000 ALTER TABLE `post_category_favourites` DISABLE KEYS */;
INSERT INTO `post_category_favourites` VALUES (2,3,1,1644737372),(3,3,7,1645833751),(7,5,8,1646679591),(8,3,10,1647337716),(13,5,1,1651858034),(17,3,11,1652341627),(18,11,1,1656676492),(21,13,1,1658223064),(22,12,1,1658223069),(24,19,1,1658271451),(25,19,14,1658271890),(26,20,14,1658271971),(27,1,17,1658327459),(28,2,17,1658327461),(29,3,17,1658327462),(30,4,17,1658327463),(31,5,17,1658327463),(32,10,17,1658327464),(33,16,17,1658327464),(34,21,17,1658327464),(35,20,17,1658327465),(36,19,17,1658327465),(37,24,17,1658327466),(38,18,17,1658327466),(39,23,17,1658327467),(40,22,17,1658327467),(41,17,17,1658327468),(42,11,17,1658327468),(43,6,17,1658327468),(44,7,17,1658327469),(45,12,17,1658327470),(46,13,17,1658327470),(47,14,17,1658327472),(48,9,17,1658327472),(49,15,17,1658327472),(50,8,17,1658327473),(51,20,13,1658337584),(52,10,13,1658342201),(53,7,20,1658351851),(54,1,20,1658351854),(55,2,20,1658351854);
/*!40000 ALTER TABLE `post_category_favourites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_emotions`
--

DROP TABLE IF EXISTS `post_emotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_emotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'like',
  `date_pub` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_emotions`
--

LOCK TABLES `post_emotions` WRITE;
/*!40000 ALTER TABLE `post_emotions` DISABLE KEYS */;
INSERT INTO `post_emotions` VALUES (3,1,2,'like','2021-11-25 18:11:36'),(4,1,2,'heart','2021-11-25 18:11:37'),(5,1,2,'respect','2021-11-25 18:11:39'),(17,1,1,'like','2021-11-30 17:34:04'),(25,1,1,'heart','2021-12-12 01:54:15'),(26,5,1,'like','2022-01-26 01:45:19'),(28,1,7,'like','2022-02-26 03:02:26'),(29,5,7,'heart','2022-02-26 03:02:31'),(30,1,7,'heart','2022-02-26 03:02:34'),(31,5,7,'like','2022-02-26 03:02:38'),(32,5,1,'respect','2022-03-06 15:19:51'),(33,1,8,'shit','2022-03-07 21:58:50'),(34,5,10,'dislike','2022-03-15 12:48:36'),(35,1,10,'dislike','2022-03-15 12:48:37'),(41,11,1,'like','2022-03-22 15:44:07'),(44,11,1,'heart','2022-03-22 15:44:20'),(47,11,11,'dislike','2022-05-12 10:47:05'),(48,5,11,'dislike','2022-05-12 10:47:07'),(49,1,11,'dislike','2022-05-12 10:47:11'),(50,11,13,'shit','2022-07-18 02:40:43'),(59,11,1,'respect','1658230453'),(60,15,13,'shit','1658248998'),(61,19,1,'like','1658271451'),(64,15,14,'heart','1658271971'),(65,17,16,'like','1658275247'),(67,22,16,'respect','1658275513'),(68,22,1,'like','1658305622'),(69,23,17,'heart','1658327443'),(70,15,13,'like','1658337906'),(71,24,13,'shit','1658342201'),(72,25,19,'like','1658348165'),(73,25,19,'respect','1658348165'),(74,25,19,'dislike','1658348170'),(75,25,19,'shit','1658348171'),(77,25,1,'like','1658351596'),(78,25,20,'like','1658351862'),(79,25,19,'heart','1658351865'),(80,17,20,'like','1658351868');
/*!40000 ALTER TABLE `post_emotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_views`
--

DROP TABLE IF EXISTS `post_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `time` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_views`
--

LOCK TABLES `post_views` WRITE;
/*!40000 ALTER TABLE `post_views` DISABLE KEYS */;
INSERT INTO `post_views` VALUES (1,1,11,1647952711),(2,1,5,1647952813),(3,1,1,1647952820),(4,1,13,1651859631),(5,1,14,1652295143),(6,13,1,1658101248),(7,13,5,1658101326),(8,13,15,1658102118),(9,1,16,1658222757),(10,1,15,1658234776),(11,13,17,1658248859),(12,1,17,1658249600),(13,1,19,1658266385),(14,14,15,1658271984),(15,13,22,1658337596),(16,19,23,1658348630),(17,16,16,1658348805),(18,20,27,1658352084),(19,20,26,1658352090);
/*!40000 ALTER TABLE `post_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'post',
  `category` int(11) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `clip` tinyint(1) NOT NULL DEFAULT '0',
  `commented` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) DEFAULT NULL,
  `message` text,
  `image1` varchar(200) DEFAULT NULL,
  `image2` varchar(200) DEFAULT NULL,
  `image3` varchar(200) DEFAULT NULL,
  `video1` varchar(200) DEFAULT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `date_view` int(11) NOT NULL DEFAULT '0',
  `date_public` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'d0RD9ihTnG39dv4CF6r3Gyhrbh3qVC',1,1,181,'post',0,0,0,1,'','Ð”ÐµÐ»Ð¸ÑÑŒ ÑÐ²Ð¾Ð¸Ð¼Ð¸ ÐºÑ€ÑƒÑ‚Ñ‹Ð¼Ð¸ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÑÐ¼Ð¸!','','','',NULL,'ru',1637851762,'2021-11-25 17:49:21','2022-07-19 22:56:25'),(5,'VFoSZnR0tLnRU9KQ7jSLgHTRu8iAMB',1,1,62,'post',3,0,0,1,'','Ð’ÑÐµÑ… Ñ Ð½Ð¾Ð²Ñ‹Ð¼ 2022 Ð³Ð¾Ð´Ð¾Ð¼! ðŸ¥³','','','',NULL,'ru',1640984400,'2021-12-31 11:18:35','2022-07-20 08:30:10'),(11,'HM0iyE1aOZU5vstddPD8CpFA6bzvTl',1,1,30,'post',0,0,0,0,'','Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ Ð¼Ð¾Ð±. Ð²ÐµÑ€ÑÐ¸Ð¸...','','','',NULL,'ru',1647944483,'2022-03-22 13:21:22','2022-07-19 22:57:18'),(15,'M76C8JqXVfLGVmfFs4RO198wmJblFR',13,13,20,'post',20,0,0,1,'','G','https://sun.qwaker.fun/uploads/aaa-POST-20220718025355-518088.png','','',NULL,'ru',1658102034,'2022-07-18 02:53:53','2022-07-20 18:45:33'),(16,'YtRWPbDnfCVlQI4hly4YO3zpfr3FtN',1,1,9,'ads',0,0,0,1,'','Ð¢ÐµÑÑ‚Ð¸Ñ€ÑƒÑŽÑ‚ÑÑ Ð½Ð¾Ð²Ñ‹Ðµ Ð ÐµÐºÐ»Ð°Ð¼Ð½Ñ‹Ðµ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ð¸.','','','',NULL,'ru',1658191663,'2022-07-19 03:47:42','2022-07-20 20:26:45'),(17,'GmxGlCiJzxsNtvGvT6SlEIsvhpn1VZ',1,1,19,'post',0,0,0,1,'','ÐŸÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹ Ð²Ð¸Ð´ÐµÐ¾ Ð¸Ð· YouTube!','','','','https://youtu.be/NbVuM2GH7fY','ru',1658247044,'2022-07-19 19:10:43','2022-07-20 08:31:13'),(19,'ToiwisNiAtlhKChYNbKIhDL_2dEknV',1,1,19,'post',19,0,0,1,'','Ð­ÌÐ¼Ð¼Ð° Ð¨Ð°Ñ€Ð»Ð¾ÌÑ‚Ñ‚Ð° Ð”ÑŽÑÌÑ€Ñ€ Ð£Ð¾ÌÑ‚ÑÐ¾Ð½ (Ð°Ð½Ð³Ð». Emma Charlotte Duerre Watson; Ñ€Ð¾Ð´. 15 Ð°Ð¿Ñ€ÐµÐ»Ñ 1990, ÐœÐµÐ·Ð¾Ð½-Ð›Ð°Ñ„Ñ„Ð¸Ñ‚, Ð¿Ñ€Ð¸Ð³Ð¾Ñ€Ð¾Ð´ ÐŸÐ°Ñ€Ð¸Ð¶Ð°, Ð¤Ñ€Ð°Ð½Ñ†Ð¸Ñ) â€” Ð±Ñ€Ð¸Ñ‚Ð°Ð½ÑÐºÐ°Ñ ÐºÐ¸Ð½Ð¾Ð°ÐºÑ‚Ñ€Ð¸ÑÐ° Ð¸ Ñ„Ð¾Ñ‚Ð¾Ð¼Ð¾Ð´ÐµÐ»ÑŒ.','https://sun.qwaker.fun/uploads/mixno35-POST-20220720003125-729464.png','https://sun.qwaker.fun/uploads/mixno35-POST-20220720003126-191493.png','','','ru',1658266284,'2022-07-20 00:31:23','2022-07-19 22:56:38'),(22,'Vosn0SrXrIPE7zyIjDflcot1bmkIGn',16,16,2,'post',0,0,0,1,'','Ð¯ Ð¿Ð¾Ð´ÐµÐ»Ð¸Ð»ÑÑ ÑÐ²Ð¾ÐµÐ¹ Ð½Ð¾Ð²Ð¾Ð¹ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸ÐµÐ¹ ðŸ™‚\r\n','','','','','ru',1658275413,'2022-07-20 03:03:32','2022-07-20 17:19:58'),(23,'Gw97xmdxuwUrcmu5GMMXkC6uKWENtC',17,17,1,'post',0,0,0,1,'','pizda pizda demn','','','','','en',1658327434,'2022-07-20 17:30:33','2022-07-20 20:23:50'),(24,'qtnFPwBjOls4EFsZGR3usPiFgev47m',13,13,0,'post',10,0,0,1,'','ðŸ¤¡','https://sun.qwaker.fun/uploads/aaa-POST-20220720203058-385660.png','','','','ru',1658338257,'2022-07-20 20:30:56','2022-07-20 17:31:00'),(25,'kpW_meyAzh5ZzJuRzBxOAVan_FsyWQ',19,19,0,'post',0,0,0,1,'','Ð¶ÐµÑÑ‚ÑŒ','','','','','ru',1658347953,'2022-07-20 23:12:32','2022-07-20 20:12:36'),(26,'2n3tzMSa1LOLjjk8mKU9kAkfHs26kb',19,19,1,'post',0,0,0,1,'','Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾','','','','','ru',1658351875,'2022-07-21 00:17:54','2022-07-20 21:21:30'),(27,'55KUwey2Ke1r4D7HZgS2EDS3ngv_ee',20,20,1,'post',999,0,0,1,'','Ð¯ ÐºÑ€ÑƒÑ‚Ð¾Ð¹','','','','','ru',1658352074,'2022-07-21 00:21:13','2022-07-20 21:21:24');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports_comments`
--

DROP TABLE IF EXISTS `reports_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) NOT NULL DEFAULT 'spam',
  `date_reported` varchar(40) DEFAULT '1997-01-01 03:00:00',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` varchar(11) NOT NULL DEFAULT '0',
  `comment_message` varchar(500) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports_comments`
--

LOCK TABLES `reports_comments` WRITE;
/*!40000 ALTER TABLE `reports_comments` DISABLE KEYS */;
INSERT INTO `reports_comments` VALUES (1,'maral','2022-07-20 01:43:32',1,'12','Ð°-Ñ‚Ð°-Ð°-Ñ‚Ð°','');
/*!40000 ALTER TABLE `reports_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports_post`
--

DROP TABLE IF EXISTS `reports_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) DEFAULT 'spam',
  `date_reported` varchar(40) DEFAULT '1997-01-01 03:00:00',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `message` varchar(100) DEFAULT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `post_message` varchar(500) DEFAULT NULL,
  `post_image1` varchar(500) DEFAULT NULL,
  `post_image2` varchar(500) DEFAULT NULL,
  `post_image3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports_post`
--

LOCK TABLES `reports_post` WRITE;
/*!40000 ALTER TABLE `reports_post` DISABLE KEYS */;
INSERT INTO `reports_post` VALUES (1,'lgbt','2022-02-20 23:50:23',1,'',6,'sdf','','',''),(2,'propaganda','2022-07-20 02:05:07',14,'',20,'Ð¢ÐµÑÑ‚Ð¾Ð²Ð°Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ñ ÐºÐ°Ñ€Ñ‚Ð¸Ð½ÐºÐ¾Ð¹','https://sun.qwaker.fun/uploads/mixno35-POST-20220720015836-518351.png','','');
/*!40000 ALTER TABLE `reports_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports_user`
--

DROP TABLE IF EXISTS `reports_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` varchar(30) DEFAULT 'spam',
  `message` varchar(200) DEFAULT NULL,
  `date_reported` varchar(30) NOT NULL DEFAULT '1997-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports_user`
--

LOCK TABLES `reports_user` WRITE;
/*!40000 ALTER TABLE `reports_user` DISABLE KEYS */;
INSERT INTO `reports_user` VALUES (1,2,1,'scam','','2021-11-25 23:20:40'),(2,10,1,'18plus','','2022-03-21 14:11:21'),(3,11,1,'18plus','','2022-05-07 10:46:38'),(4,13,1,'18plus','','2022-07-19 15:06:30');
/*!40000 ALTER TABLE `reports_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploaded_files`
--

DROP TABLE IF EXISTS `uploaded_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `crypt` varchar(70) NOT NULL,
  `full_url` varchar(700) NOT NULL,
  `short_url` varchar(700) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'post',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploaded_files`
--

LOCK TABLES `uploaded_files` WRITE;
/*!40000 ALTER TABLE `uploaded_files` DISABLE KEYS */;
INSERT INTO `uploaded_files` VALUES (11,2,'','https://sun.qwaker.fun/avatars/kycb42148-20211130164841633670.jpg','/avatars/kycb42148-20211130164841633670.jpg','avatar','2021-11-30 13:48:41'),(35,7,'','https://sun.qwaker.fun/avatars/detroit-20220306105101907372.jpg','/avatars/detroit-20220306105101907372.jpg','avatar','2022-03-06 07:51:01'),(55,11,'','https://sun.qwaker.fun/avatars/izbalolist-20220507102638932840.jpg','/avatars/izbalolist-20220507102638932840.jpg','avatar','2022-05-07 07:26:38'),(61,1,'','https://sun.qwaker.fun/uploads/mixno35-MESSAGE-20220512115049-366503.png','/uploads/mixno35-MESSAGE-20220512115049-366503.png','message_image1','2022-05-12 08:50:49'),(68,1,'','https://sun.qwaker.fun/uploads/mixno35-MESSAGE-20220701145920-346859.png','/uploads/mixno35-MESSAGE-20220701145920-346859.png','message_image1','2022-07-01 11:59:20'),(69,1,'','https://sun.qwaker.fun/uploads/mixno35-POST-20220701150112-711629.png','/uploads/mixno35-POST-20220701150112-711629.png','post_image1','2022-07-01 12:01:12'),(72,13,'','https://sun.qwaker.fun/uploads/aaa-POST-20220718025355-518088.png','/uploads/aaa-POST-20220718025355-518088.png','post_image1','2022-07-17 23:53:55'),(73,1,'7b73e48ca6703323792e4720d6ccc4c6','https://sun.qwaker.fun/avatars/mixno35-20220720002603152034.jpg','/avatars/mixno35-20220720002603152034.jpg','avatar','2022-07-19 21:26:03'),(74,1,'26c5d850a6bbf48b8717bdfecc4077ce','https://sun.qwaker.fun/uploads/mixno35-POST-20220720003125-729464.png','/uploads/mixno35-POST-20220720003125-729464.png','post_image1','2022-07-19 21:31:25'),(75,1,'30b693a44235916a6c7113e8e8e08dae','https://sun.qwaker.fun/uploads/mixno35-POST-20220720003126-191493.png','/uploads/mixno35-POST-20220720003126-191493.png','post_image2','2022-07-19 21:31:26'),(78,14,'abff1ec71cd65f06b61a2a961f3a1629','https://sun.qwaker.fun/avatars/test-20220720020319655550.jpg','/avatars/test-20220720020319655550.jpg','avatar','2022-07-19 23:03:19'),(79,16,'b989ef2d745b7277fc6eaaf4b4372022','https://sun.qwaker.fun/avatars/wetakor-20220720030258982049.jpg','/avatars/wetakor-20220720030258982049.jpg','avatar','2022-07-20 00:02:58'),(80,13,'22d985e7bbf40cfe8d3503f5a98d07ae','https://sun.qwaker.fun/uploads/aaa-POST-20220720203058-385660.png','/uploads/aaa-POST-20220720203058-385660.png','post_image1','2022-07-20 17:30:58'),(81,19,'fe2ab07fa3eaa12756df43ba1ecd2cce','https://sun.qwaker.fun/avatars/loh-20220721000728388478.jpg','/avatars/loh-20220721000728388478.jpg','avatar','2022-07-20 21:07:28');
/*!40000 ALTER TABLE `uploaded_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'site',
  `sid` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `utoken` varchar(100) NOT NULL,
  `uagent` varchar(500) NOT NULL,
  `uip` varchar(40) NOT NULL,
  `time` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL,
  `maxtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sessions`
--

LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES (14,'site','4DkRbTVSdpmTYAu4lseNUvdo3fzt4JxWLmMJ8LPKir0HicyDx66I25N5sOK31MqGD0jyaI',2,'e4a6aa3e7eb8e4897cdb5f893b1cb559','Mozilla/5.0 (Android 11; Mobile; rv:94.0) Gecko/94.0 Firefox/94.0','5.18.233.80',1638279992,1638279992,1669815992),(24,'site','9sQWzeyNuROtn5F1TpcVRJlS3tseDodrxrMjhaBzV1bgEcFDi3CtngnBHSKnBZgRXFxRwb',6,'8db0687f56ef588c6ecd766dd2f09107','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36','37.214.58.14',1643792285,1643792285,1675328285),(28,'site','3d4T4SacC5ol2BayPUZoSTLwkjSBZvWpIH8QveoutrPnYMHaLU6JT7ccezr4gpJNWSVxR2',7,'c4b98fca0a4030eadeddb04ec5c57d22','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36','2a02:bf0:322c:2212:0:10:194c:a101',1645833639,1646553063,1677369639),(32,'site','7YvgxoEVavsS2MpzJYLmyK9T8pG1ka3jMmfb8ol6SecMgNS10OviOvGvAH4DBxNBRYMEKt',7,'c4b98fca0a4030eadeddb04ec5c57d22','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36','37.212.1.4',1646568845,1646568924,1678104845),(35,'site','BAobs8Cokkr5cunUELFMTrh7ZSrpBScLRPLNHnms7NkB4aYZntrq55NCF0oWedNwPvpyO9',8,'97a16cd558bb655e03bed5aadd0aac65','Mozilla/5.0 (Linux; Android 10; SM-J610FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.87 Mobile Safari/537.36','85.140.5.81',1646679500,1646679832,1678215500),(36,'site','cZ7jxTxMaptAAugo97SslC3OO9cMmQJiEA00r5H9uCnA0isRA8yWPQdhRD78Gk1vkT7iY8',9,'68d9b96db3078754579365bc6e6e51a0','Mozilla/5.0 (Linux; Android 9; KSA-LX9) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36','80.234.58.255',1646679985,1646680053,1678215985),(38,'site','Dg8GCEkRbPFy6VgNdYMWn9kNGNkwXrJaAw5vMXXYzfl3PaeLWKnF6qzcL1KIQ0ZrbtIxPr',10,'e57237f71a5f424c236b049fe4490fd2','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.58 Mobile Safari/537.36','37.73.108.1',1647337248,1651907880,1647652548),(49,'site','SknDoulBOC0WejFiU9CuGfDzIUcMSc5JFuEoJ6jOwTkHrnBGpzKrjEF4s2nDMXcUFN2dHZ',11,'034ccb0f4aa0e96506a5d2e79400b233','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36','128.0.0.1',1651908224,1652295250,1652223524),(51,'site','Tv4DkLL4TpHGyEQqynavIRfIPlCc2xb6fUXlbyKs3GAATCd1U5xVu4mvLiSkvDtDV1ZOUj',11,'034ccb0f4aa0e96506a5d2e79400b233','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36','128.0.0.1',1651908888,1651909329,1652224188),(53,'site','ooruald0yLCBEsDgUFZuzOJZy1ruU6qjd7EwHJhBgwiKl1vtVbRZhcjr5kCfvOIN3XQhGE',11,'034ccb0f4aa0e96506a5d2e79400b233','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36','128.0.0.1',1652295261,1652295268,1652610561),(54,'site','J16GW4u2tFcxlyuPfr0w3lVyIEgQUsyNuMsq5bLvnd6fv4zoKkqUW3sPkfcdPsd59XcJTI',11,'034ccb0f4aa0e96506a5d2e79400b233','Mozilla/5.0 (Linux; Android 10; ZTE 8010) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36','128.0.0.1',1652295316,1658177396,1652610616),(60,'site','BYZrC9bqbN1jomLNjXSZoLrOszJMgsfZxKFttxlhnFab2fSa0KwVDbbOX56q0N3GjH460k',12,'cd73cfbd7672fd1496334141cef5f71c','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36','128.0.0.1',1656598519,1656598519,1656913819),(64,'site','JlFauDXNwkHkCbIFHuIhBo6s3yPulWQtwDcHPyIKMMPwj6GShIfpxUInzwnkhXp6QIxxpn',13,'b9ed8b8a0200a8c5bbac170e0bda197f','Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1','128.0.0.1',1658101203,1658102224,1658416503),(65,'site','ldjixm3YbaIdMVhJuzauwNQVPudVoUBEc6qwyHXIDmKi5A9mj8EWVaRBa2QQT2KCbxbaAq',13,'b9ed8b8a0200a8c5bbac170e0bda197f','Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1','128.0.0.1',1658177008,1658342746,1658492308),(68,'site','cDFUYzH6tgAQ5hROrZlsBvS2PyHcqlR2WkZbXk5Xt5QlefNYZBOzWaSZd7kIZHFZm5sArN',1,'16c3516d571840fc65c3fd642343d726','Mozilla/5.0 (Linux; Android 11; RMX3263) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36','128.0.0.1',1658222108,1658351990,1658537408),(69,'site','PJpw2ktzb3q671rdviMLtJSoEKbikx8QoLo1pKMcoZmNDSGl6bxYhrfWNSF6htCQSHLRC0',1,'16c3516d571840fc65c3fd642343d726','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36','128.0.0.1',1658270150,1658271264,1658585450),(70,'site','dpnlnDPgtJWrgonRlj9sa54AIp01o296OYfvqy3BmlMuussxKuQoTGrP6HaHwVbQjvnXQ6',1,'16c3516d571840fc65c3fd642343d726','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36','128.0.0.1',1658271330,1658271330,1658586630),(71,'site','QguEMbC4fLiBlp7Gdnb3lIyA27oKj3bUKgJzNTkNIgMwjy6EURHMwXEgK9PoEjNsI3v4vU',14,'c7fed9fb9ec95806339c0e22d9fe01c1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36','128.0.0.1',1658271697,1658271954,1658586997),(72,'site','Wkacuxunij64lJEo7e4o7fCePGBaSmxQOSOsC1lrkVtsF7dOiePs7y52BD2sLI3m3nUpVj',15,'9a2af699655332eface3f8ada41084e3','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44','128.0.0.1',1658274779,1658274789,1658590079),(73,'site','RwukwgkDl5Dppe1p15OGq3xMVdDyYhceMBAxlNi3Jofu2u66b9fNaUv4io6qiWw8UdGPTj',16,'69120100f803145d57859d5fa9f438d7','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44','128.0.0.1',1658274826,1658347617,1658590126),(74,'site','SgMtkWzCGRDRRbhvgUk5f1RDkc0rWYiKbKwTRYDjhQ1NvE16i91ZfeJWMFlgw2hZ8zokGE',1,'16c3516d571840fc65c3fd642343d726','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36','128.0.0.1',1658320286,1658320286,1658635586),(75,'site','rK9mh7V78zMwCeMjlPs8JasPHf5me5VhLbNoxQse2ap3PatdPb9l1Vl2a7BFRtAPZ9xbvu',17,'185c95416ca984d18b998b426ff2a61c','Mozilla/5.0 (X11; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0','128.0.0.1',1658327420,1658327484,1658642720),(76,'site','kUSUm9kXMbDIKTfRFsgfSGzLTcAil939OAOaue62LhjYAGsSue3veAkrDK0DDUviuIuf3B',18,'cff46991ec544651bc3e813fe9ec2c49','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44','128.0.0.1',1658347717,1658347883,1658663017),(77,'site','HnbiAaYAqSxJcebp8JpRve9xDJ3xGhwjFf370RMsway3VAOK5XfjYxCeN0WA6h7152dVjE',19,'5973dee348c1c6a62e4530f6c62bfb72','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36','128.0.0.1',1658347903,1658352091,1658663203),(78,'site','BtYLcXUJeIKQV8nqANxpMLNQpYObHgrRfiOAgsBdQhTbJSRoNXG2VnONNPLJBi4uHldAb5',16,'69120100f803145d57859d5fa9f438d7','Mozilla/5.0 (Linux; Android 10; M2006C3MNG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.124 Mobile Safari/537.36 EdgA/102.0.1245.44','128.0.0.1',1658348165,1658348273,1658663465),(79,'site','If2cvPlGiudjV1rOPU21m7ZYXSwmUn0qU9Y7L4c4Ic2TX3j2Hnu0h0Nb2Jt6EGAAQG9hHr',20,'61d28d2d37fab3e629792aed049fd305','Mozilla/5.0 (Linux; Android 11; SM-A125F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36','128.0.0.1',1658351149,1658352108,1658666449);
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(50) DEFAULT NULL,
  `interval_m` int(5) NOT NULL DEFAULT '10000',
  `limit_post` int(11) NOT NULL DEFAULT '2000',
  `rang` int(2) NOT NULL DEFAULT '1' COMMENT '1 - пользователь, 2 - модератор, 3 - админ, 4 - разработчик',
  `type_auth` varchar(20) NOT NULL DEFAULT 'site',
  `nickname` varchar(40) DEFAULT NULL,
  `name` text,
  `avatar` varchar(200) DEFAULT NULL,
  `avatar_small` varchar(200) DEFAULT NULL,
  `background` varchar(500) DEFAULT NULL,
  `about` varchar(150) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `login` varchar(35) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `password` varchar(200) NOT NULL,
  `url_site` varchar(50) DEFAULT NULL,
  `url_social` varchar(50) DEFAULT NULL,
  `url_phone` varchar(50) DEFAULT NULL,
  `url_email` varchar(50) DEFAULT NULL,
  `banned_mesage` varchar(100) DEFAULT 'Ваш аккаунт был заблокирован.',
  `email` varchar(100) DEFAULT NULL,
  `online` int(11) NOT NULL,
  `favourite_posts` varchar(100) DEFAULT '0, 999',
  `report_posts` tinyint(1) NOT NULL DEFAULT '1',
  `report_comments` tinyint(1) NOT NULL DEFAULT '1',
  `verification_type` varchar(20) NOT NULL DEFAULT 'popular',
  `verification` tinyint(1) NOT NULL DEFAULT '0',
  `email_authorization` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `scam` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `restore_password` tinyint(1) NOT NULL DEFAULT '1',
  `find_me` tinyint(1) NOT NULL DEFAULT '1',
  `public_post` tinyint(1) NOT NULL DEFAULT '1',
  `chat_creating` tinyint(1) NOT NULL DEFAULT '1',
  `chat_joined` tinyint(1) NOT NULL DEFAULT '1',
  `chat_read` tinyint(1) NOT NULL DEFAULT '1',
  `show_online` tinyint(1) NOT NULL DEFAULT '1',
  `show_url` tinyint(1) NOT NULL DEFAULT '0',
  `private_message` tinyint(1) NOT NULL DEFAULT '1',
  `hide_popup_rec` tinyint(1) NOT NULL DEFAULT '0',
  `date_banned` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `date_registration` varchar(30) NOT NULL,
  `date_upd_avatar` int(30) DEFAULT NULL,
  `date_upd_login` int(30) DEFAULT NULL,
  `date_upd_password` int(11) DEFAULT NULL,
  `date_upd_restore_password` int(11) DEFAULT NULL,
  `date_verification` varchar(30) DEFAULT NULL,
  `date_last_extract` int(30) NOT NULL,
  `date_last_send_code` int(30) NOT NULL,
  `date_last_restore_password` int(30) NOT NULL,
  `language` varchar(2) DEFAULT 'en',
  `email_restore_password_code` varchar(70) DEFAULT NULL,
  `email_authorization_code` varchar(70) DEFAULT NULL,
  `token` varchar(150) NOT NULL,
  `token_public` varchar(70) NOT NULL,
  `token_access` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,0,NULL,10000,2000,4,'site','','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€ ÐœÐ¸Ñ…Ð½Ð¾','https://sun.qwaker.fun/avatars/mixno35-20220720002603152034.jpg','https://sun.qwaker.fun/avatars/mixno35-20220720002603152034.jpg',NULL,'',5,'mixno35','25d55ad283aa400af464c76d713c07ad','https://qwaker.fun','https://github.com/mixno35','','','Ваш аккаунт был заблокирован.','steepdoctor@gmail.com',1658351990,'0, 999',1,1,'developer',1,0,1,0,0,1,0,1,1,1,1,1,1,1,0,'1970-01-01 03:00:00','2021-11-25 17:48:01',0,1652462583,1656847472,1656847187,NULL,1651858096,1658178244,1656847187,'ru',NULL,NULL,'7KW340PchYEm5D3euMVoc8kBZgftyxz90ozNWzQlBJ2NrKVicEcJQG6Z9ScqW2ZLinAF9m','16c3516d571840fc65c3fd642343d726',NULL),(2,0,NULL,10000,2000,3,'site','kycb42148','ÐšÑƒÑÑŒ','https://sun.qwaker.fun/avatars/kycb42148-20211130164841633670.jpg','https://sun.qwaker.fun/avatars/kycb42148-20211130164841633670.jpg',NULL,'ÐœÐµÐ½Ñ Ð·Ð¾Ð²ÑƒÑ‚ ÐšÑƒÑÑŒ, Ñ Ð»ÑŽÐ±Ð»ÑŽ ÑÐ»ÑƒÑˆÐ°Ñ‚ÑŒ Ð¼ÑƒÐ·Ñ‹ÐºÑƒ',0,'kycb42148','4811abb89c5de772d76c101a65844ebb','https://kgstudios.ddns.net/filevault/user/files/ky','','','','Ваш аккаунт был заблокирован.','kycb42148@gmail.com',1647179389,'0, 999',1,1,'popular',1,1,0,0,0,1,1,1,1,1,1,1,1,1,0,'1970-01-01 03:00:00','2021-11-25 17:59:07',1638884920,1637852347,NULL,1647179770,NULL,0,0,1647179770,'ru',NULL,'','WNmMvl6mtFBIVnLe37YUx4IYMgetJVuAph6r3VU7pIJRfFznEtU4paVfUnEZK53NLG2dK1','e4a6aa3e7eb8e4897cdb5f893b1cb559',NULL),(4,0,NULL,10000,2000,1,'site','login','name',NULL,NULL,NULL,NULL,0,'login','5f4dcc3b5aa765d61d8327deb882cf99',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,0,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2021-12-30 13:03:41',NULL,1640858621,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'nB1elonBEcODZtND9Tvgss7HBkcQdP05pVK3nqiOKRUbL5RLT3oa9FbOFaVMtzzefUfOCF','9fbc26ab46f86de89676025a43361598',NULL),(5,0,NULL,10000,2000,1,'site','dim','Dima',NULL,NULL,NULL,NULL,0,'dim','3e86908f69a276c6064455e3db010fa2',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,0,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-01-29 01:33:43',NULL,1643409223,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'Ih8hWoZAJfGPgec34Fp10aaDfnM1LFhmGBhUyAzZivFceWR3GqoopeY5to5CzZguriL1JE','b343b728e2038b8505e1e9d729f8dbb4',NULL),(6,0,NULL,10000,2000,1,'site','riddler','riddler',NULL,NULL,NULL,NULL,0,'riddler','426c70c360c4b0c5ef58e6dc535cf520',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1643792327,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-02-02 11:57:47',NULL,1643792267,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'Y8dp7w3RAUY4lUrhXU0gqKdJgqQ8AGczpF3APgrnF9EoPHPR0OK8g3oWlgXz3ny3EvhQf0','8db0687f56ef588c6ecd766dd2f09107',NULL),(7,0,NULL,10000,2000,1,'site','detroit','Detroit Human','https://sun.qwaker.fun/avatars/detroit-20220306105101907372.jpg','https://sun.qwaker.fun/avatars/detroit-20220306105101907372.jpg',NULL,NULL,4,'detroit','25d55ad283aa400af464c76d713c07ad',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1646568929,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-02-26 03:00:21',0,1645833621,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'GsJdJsqfrAjNDo3oGlLvVr1a8vVREQvnpnmoPezf5vEk5QegxLiKe2yMGQzzDuGtgemoM6','c4b98fca0a4030eadeddb04ec5c57d22',NULL),(8,0,NULL,10000,2000,1,'site','nesquik','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€',NULL,NULL,NULL,NULL,0,'nesquik','4561598c97634064ae319dc7417f4091',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1646679860,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-03-07 21:58:04',NULL,1646679484,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'OLpixDEoT23rfqGeW0yx3OSy7rkjDzFXozU0OghoECdrpPLgXsVyZJZ0PWeYaMDE8S5TUx','97a16cd558bb655e03bed5aadd0aac65',NULL),(9,0,NULL,10000,2000,1,'site','kristi_naaa_g','ÐšÑ€Ð¸ÑÑ‚Ð¸Ð½Ð°',NULL,NULL,NULL,NULL,0,'kristi_naaa_g','26f9af2429d42230d79b68b62bc862b7',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1646680096,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-03-07 22:06:06',NULL,1646679966,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'OXXwPD7XgdrSfxVAFmeZrGCoy9jxPpzMrQW8yS6Cqe1N0XpUyTQ4CjRJv7iLRKwL7OR1PH','68d9b96db3078754579365bc6e6e51a0',NULL),(10,0,NULL,10000,2000,1,'site','sanyatop','Ð¡ÐµÐ½Ñ',NULL,NULL,NULL,'ÐÑƒ Ñ ÐºÐ¾Ñ€Ð¾Ñ‡Ðµ Ð»ÑŽÐ±Ð»ÑŽ ÑÐ¾Ð±Ð°Ðº.',0,'sanyatop','7a92bb55f8a1f69a7bb0e64a5d9ec849',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.','',1651907880,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-03-15 12:40:38',NULL,1647942156,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'BBjRJKSTfwDBPwaWouxC1CodhKzSDMarkq58YhR3R0jFFni9zD7E1esuQcL6gSs4jtXkyx','e57237f71a5f424c236b049fe4490fd2',NULL),(11,0,NULL,10000,2000,1,'site','izbalolist','','https://sun.qwaker.fun/avatars/izbalolist-20220507102638932840.jpg','https://sun.qwaker.fun/avatars/izbalolist-20220507102638932840.jpg',NULL,NULL,0,'izbalolist','7a92bb55f8a1f69a7bb0e64a5d9ec849',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658177396,'0, 999',1,1,'popular',1,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'2022-05-07 10:47:48','2022-05-07 10:23:35',0,1651908408,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'TTLc3BOhdh65XKlHVnsegCXCcOKP40hPjq6mrQ4OTvG26i69jWsCodS5K6TukKGIpMMXNV','034ccb0f4aa0e96506a5d2e79400b233',NULL),(12,0,NULL,10000,2000,1,'site','testuser','Alexander Mukhno',NULL,NULL,NULL,NULL,0,'testuser','25d55ad283aa400af464c76d713c07ad',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1656598539,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-06-30 17:15:03',NULL,1656598503,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'UYil9wGQBX8rhiUe2ltZmg8FSVkGLVJgQJSeEIgmC9xOPLhqlN6bU72jkFdfRqC1mtDFtO','cd73cfbd7672fd1496334141cef5f71c',NULL),(13,0,NULL,10000,2000,1,'site','aaa','aaaa',NULL,NULL,NULL,NULL,6,'aaa','0b4e7a0e5fe84ad35fb5f95b9ceeac79',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658342749,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-18 02:39:51',NULL,1658101191,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'4ob0gEj6cbHFOTztyDQbDousNxh1KPcrwCXiFOVpAvqUqg6rlDeYHf4U4tq3eqfyj5o9ZB','b9ed8b8a0200a8c5bbac170e0bda197f',NULL),(14,0,NULL,10000,2000,1,'site','test','Test User Name','https://sun.qwaker.fun/avatars/test-20220720020319655550.jpg','https://sun.qwaker.fun/avatars/test-20220720020319655550.jpg',NULL,NULL,3,'test','25d55ad283aa400af464c76d713c07ad',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658272416,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-20 02:01:30',0,1658271690,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'baFg8mvIwEMvG73eQmLKQ8acILAApPS7Hm2ny1Or38DlwcExXxyMGHygqraLCbNJlzbjlr','c7fed9fb9ec95806339c0e22d9fe01c1',NULL),(15,0,NULL,10000,2000,1,'site','rei','Ilya K',NULL,NULL,NULL,NULL,0,'rei','7a66ca4703a83c0144a717024dd09396',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658274791,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-20 02:52:50',NULL,1658274770,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'DNkiU6wFWNmMpyfUghW6JkJoRMVJBrREJmzv8FuNsYaNIEIjt7eOWmxmthhIh178vbVHgV','9a2af699655332eface3f8ada41084e3',NULL),(16,0,NULL,10000,2000,3,'site','wetakor','Ilya','https://sun.qwaker.fun/avatars/wetakor-20220720030258982049.jpg','https://sun.qwaker.fun/avatars/wetakor-20220720030258982049.jpg',NULL,'Telegram: @b4yan and @ll031',4,'wetakor','7a66ca4703a83c0144a717024dd09396','https://t.me/wetameta','','','wetakor@outlook.com','Ваш аккаунт был заблокирован.','wetakor@outlook.com',1658348806,'0, 999',1,1,'popular',1,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'2022-07-20 12:16:21','2022-07-20 02:53:38',0,1658879926,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'Mk0mgwoqBtiydFreWJDOeLy9GQgaYvBSUYc7xVUf9wsw5F86DnYt23JUNlWenLwHMxhPRM','69120100f803145d57859d5fa9f438d7',NULL),(17,0,NULL,10000,2000,1,'site','pizda','pizda',NULL,NULL,NULL,NULL,0,'pizda','064933caeef8fc27d3fde4e2e206ebc5',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658327485,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-20 17:30:08',NULL,1658327408,NULL,NULL,NULL,0,0,0,'en',NULL,NULL,'DribAJx7L3lKOQLcoPR8cOcU5eGz0ZtdJxpwTFE8FHvensCEuJknXCbA6NW3kvqGalFgXc','185c95416ca984d18b998b426ff2a61c',NULL),(18,0,NULL,10000,2000,1,'site','administrator','admin',NULL,NULL,NULL,NULL,0,'administrator','7a66ca4703a83c0144a717024dd09396',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658347882,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-20 23:08:05',NULL,1658347685,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'dCvpV10LLovtIKlSFIOF5fH2KZvcAPjl7FX3PymJugzNnR9FmjrFILBMKu7bOKwbjME8h6','cff46991ec544651bc3e813fe9ec2c49',NULL),(19,0,NULL,10000,2000,3,'site','loh','','https://sun.qwaker.fun/avatars/loh-20220721000728388478.jpg','https://sun.qwaker.fun/avatars/loh-20220721000728388478.jpg',NULL,NULL,0,'loh','cae3b079495906276a91e15e1e40ffa1',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658352094,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-20 23:11:37',0,1658347897,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'DvWw9uHynoCeSmAizHIwhChUGYnW8nWIEyDdpOj0AsJdbMbWxh5AjmV0lUM8s2VkAp7TqY','5973dee348c1c6a62e4530f6c62bfb72',NULL),(20,0,NULL,10000,2000,4,'site','y9finsi','Ð‘Ð¾Ð³Ð´Ð°Ð½',NULL,NULL,NULL,NULL,0,'y9finsi','a4751f0325bb9d0a6bfed051161489d8',NULL,NULL,NULL,NULL,'Ваш аккаунт был заблокирован.',NULL,1658352114,'0, 999',1,1,'popular',0,0,0,0,0,1,1,1,1,1,1,1,0,1,0,'1970-01-01 03:00:00','2022-07-21 00:05:36',NULL,1658351136,NULL,NULL,NULL,0,0,0,'ru',NULL,NULL,'ffSvqznql5vusVABZhTy3ZxFhlkILKYKOFhcykbPpftVI0TDICZupN25PpfeUNE1Gffl52','61d28d2d37fab3e629792aed049fd305',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50112 SET @disable_bulk_load = IF (@is_rocksdb_supported, 'SET SESSION rocksdb_bulk_load = @old_rocksdb_bulk_load', 'SET @dummy_rocksdb_bulk_load = 0') */;
/*!50112 PREPARE s FROM @disable_bulk_load */;
/*!50112 EXECUTE s */;
/*!50112 DEALLOCATE PREPARE s */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-21  0:34:36
