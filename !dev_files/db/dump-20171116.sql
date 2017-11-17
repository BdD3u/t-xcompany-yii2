-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: test_xcompany
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB

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
-- Table structure for table `test_xcompany_auth_assignment`
--

DROP TABLE IF EXISTS `test_xcompany_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `test_xcompany_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `test_xcompany_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_auth_assignment`
--

LOCK TABLES `test_xcompany_auth_assignment` WRITE;
/*!40000 ALTER TABLE `test_xcompany_auth_assignment` DISABLE KEYS */;
INSERT INTO `test_xcompany_auth_assignment` VALUES ('admin','1',1510707163),('user','2',1510837167),('user','3',1510837191);
/*!40000 ALTER TABLE `test_xcompany_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_auth_item`
--

DROP TABLE IF EXISTS `test_xcompany_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `test_xcompany_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `test_xcompany_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_auth_item`
--

LOCK TABLES `test_xcompany_auth_item` WRITE;
/*!40000 ALTER TABLE `test_xcompany_auth_item` DISABLE KEYS */;
INSERT INTO `test_xcompany_auth_item` VALUES ('admin',1,NULL,NULL,NULL,1510707163,1510707163),('dashboard',1,NULL,NULL,NULL,1510707163,1510707163),('manager',1,NULL,NULL,NULL,1510707163,1510707163),('user',1,NULL,NULL,NULL,1510707163,1510707163);
/*!40000 ALTER TABLE `test_xcompany_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_auth_item_child`
--

DROP TABLE IF EXISTS `test_xcompany_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `test_xcompany_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `test_xcompany_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `test_xcompany_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `test_xcompany_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_auth_item_child`
--

LOCK TABLES `test_xcompany_auth_item_child` WRITE;
/*!40000 ALTER TABLE `test_xcompany_auth_item_child` DISABLE KEYS */;
INSERT INTO `test_xcompany_auth_item_child` VALUES ('admin','manager'),('dashboard','user'),('manager','dashboard');
/*!40000 ALTER TABLE `test_xcompany_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_auth_rule`
--

DROP TABLE IF EXISTS `test_xcompany_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_auth_rule`
--

LOCK TABLES `test_xcompany_auth_rule` WRITE;
/*!40000 ALTER TABLE `test_xcompany_auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_xcompany_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_blog_article`
--

DROP TABLE IF EXISTS `test_xcompany_blog_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_blog_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `preview_content` text,
  `content` longtext,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `image_id` int(11) unsigned DEFAULT NULL,
  `blog_category_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_blog_article_image1_idx` (`image_id`),
  KEY `fk_blog_article_user1_idx` (`user_id`),
  KEY `fk_blog_article_blog_category1_idx` (`blog_category_id`),
  CONSTRAINT `fk_blog_article_blog_category1_idx` FOREIGN KEY (`blog_category_id`) REFERENCES `test_xcompany_blog_category` (`id`),
  CONSTRAINT `fk_blog_article_image1_idx` FOREIGN KEY (`image_id`) REFERENCES `test_xcompany_blog_image` (`id`),
  CONSTRAINT `fk_blog_article_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `test_xcompany_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_blog_article`
--

LOCK TABLES `test_xcompany_blog_article` WRITE;
/*!40000 ALTER TABLE `test_xcompany_blog_article` DISABLE KEYS */;
INSERT INTO `test_xcompany_blog_article` VALUES (1,'test',1,'test','<p>Товарищи! укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Разнообразный и богатый опыт сложившаяся структура организации позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.</p>\r\n\r\n<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки направлений прогрессивного развития. Таким образом рамки и место обучения кадров представляет собой интересный эксперимент проверки систем массового участия. Не следует, однако забывать, что рамки и место обучения кадров влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Идейные соображения высшего порядка, а также сложившаяся структура организации влечет за собой процесс внедрения и модернизации модели развития.</p>\r\n','<p>Товарищи! укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Разнообразный и богатый опыт сложившаяся структура организации позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.</p>\r\n\r\n<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки направлений прогрессивного развития. Таким образом рамки и место обучения кадров представляет собой интересный эксперимент проверки систем массового участия. Не следует, однако забывать, что рамки и место обучения кадров влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Идейные соображения высшего порядка, а также сложившаяся структура организации влечет за собой процесс внедрения и модернизации модели развития.</p>\r\n\r\n<p>Товарищи! укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Разнообразный и богатый опыт сложившаяся структура организации позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.</p>\r\n\r\n<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки направлений прогрессивного развития. Таким образом рамки и место обучения кадров представляет собой интересный эксперимент проверки систем массового участия. Не следует, однако забывать, что рамки и место обучения кадров влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Идейные соображения высшего порядка, а также сложившаяся структура организации влечет за собой процесс внедрения и модернизации модели развития.</p>\r\n\r\n<p>Товарищи! укрепление и развитие структуры требуют определения и уточнения дальнейших направлений развития. Разнообразный и богатый опыт сложившаяся структура организации позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач.</p>\r\n\r\n<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки направлений прогрессивного развития. Таким образом рамки и место обучения кадров представляет собой интересный эксперимент проверки систем массового участия. Не следует, однако забывать, что рамки и место обучения кадров влечет за собой процесс внедрения и модернизации направлений прогрессивного развития. Идейные соображения высшего порядка, а также сложившаяся структура организации влечет за собой процесс внедрения и модернизации модели развития.</p>\r\n\r\n<p>&nbsp;</p>\r\n','test, seo, test','tes description','2017-11-15 23:44:30','2017-11-15 23:53:04',1,1,1),(2,'test1',1,'test1','<p>С другой стороны дальнейшее развитие различных форм деятельности влечет за собой процесс внедрения и модернизации форм развития. Товарищи! постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки модели развития. Равным образом реализация намеченных плановых заданий играет важную роль в формировании направлений прогрессивного развития. Значимость этих проблем настолько очевидна, что реализация намеченных плановых заданий в значительной степени обуславливает создание модели развития.</p>\r\n\r\n<p>Значимость этих проблем настолько очевидна, что постоянное информационно-пропагандистское обеспечение нашей деятельности позволяет оценить значение новых предложений. С другой стороны укрепление и развитие структуры требуют определения и уточнения модели развития. Задача организации, в особенности же консультация с широким активом требуют определения и уточнения системы обучения кадров, соответствует насущным потребностям. Повседневная практика показывает, что начало повседневной работы по формированию позиции обеспечивает широкому кругу (специалистов) участие в формировании новых предложений. Товарищи! реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. Разнообразный и богатый опыт консультация с широким активом позволяет оценить значение модели развития.</p>\r\n','<p>С другой стороны дальнейшее развитие различных форм деятельности влечет за собой процесс внедрения и модернизации форм развития. Товарищи! постоянный количественный рост и сфера нашей активности представляет собой интересный эксперимент проверки модели развития. Равным образом реализация намеченных плановых заданий играет важную роль в формировании направлений прогрессивного развития. Значимость этих проблем настолько очевидна, что реализация намеченных плановых заданий в значительной степени обуславливает создание модели развития.</p>\r\n\r\n<p>Значимость этих проблем настолько очевидна, что постоянное информационно-пропагандистское обеспечение нашей деятельности позволяет оценить значение новых предложений. С другой стороны укрепление и развитие структуры требуют определения и уточнения модели развития. Задача организации, в особенности же консультация с широким активом требуют определения и уточнения системы обучения кадров, соответствует насущным потребностям. Повседневная практика показывает, что начало повседневной работы по формированию позиции обеспечивает широкому кругу (специалистов) участие в формировании новых предложений. Товарищи! реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании дальнейших направлений развития. Разнообразный и богатый опыт консультация с широким активом позволяет оценить значение модели развития.</p>\r\n\r\n<p>Разнообразный и богатый опыт реализация намеченных плановых заданий позволяет оценить значение систем массового участия. Не следует, однако забывать, что сложившаяся структура организации требуют от нас анализа дальнейших направлений развития. Идейные соображения высшего порядка, а также реализация намеченных плановых заданий представляет собой интересный эксперимент проверки направлений прогрессивного развития.</p>\r\n\r\n<p>Идейные соображения высшего порядка, а также рамки и место обучения кадров требуют определения и уточнения форм развития. Повседневная практика показывает, что новая модель организационной деятельности требуют от нас анализа направлений прогрессивного развития.</p>\r\n\r\n<p>Равным образом реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации позиций, занимаемых участниками в отношении поставленных задач. Значимость этих проблем настолько очевидна, что реализация намеченных плановых заданий влечет за собой процесс внедрения и модернизации дальнейших направлений развития. Повседневная практика показывает, что дальнейшее развитие различных форм деятельности способствует подготовки и реализации систем массового участия. Не следует, однако забывать, что новая модель организационной деятельности требуют от нас анализа позиций, занимаемых участниками в отношении поставленных задач. Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности способствует подготовки и реализации новых предложений. Разнообразный и богатый опыт дальнейшее развитие различных форм деятельности позволяет оценить значение систем массового участия.</p>\r\n\r\n<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности позволяет выполнять важные задания по разработке дальнейших направлений развития. Не следует, однако забывать, что укрепление и развитие структуры позволяет выполнять важные задания по разработке новых предложений.</p>\r\n\r\n<p>Равным образом реализация намеченных плановых заданий играет важную роль в формировании форм развития. Не следует, однако забывать, что укрепление и развитие структуры в значительной степени обуславливает создание соответствующий условий активизации.</p>\r\n\r\n<p>Задача организации, в особенности же новая модель организационной деятельности требуют определения и уточнения форм развития. Товарищи! новая модель организационной деятельности играет важную роль в формировании форм развития. Товарищи! консультация с широким активом позволяет выполнять важные задания по разработке системы обучения кадров, соответствует насущным потребностям. Повседневная практика показывает, что укрепление и развитие структуры позволяет оценить значение новых предложений. Разнообразный и богатый опыт реализация намеченных плановых заданий играет важную роль в формировании существенных финансовых и административных условий. Повседневная практика показывает, что дальнейшее развитие различных форм деятельности играет важную роль в формировании дальнейших направлений развития.</p>\r\n\r\n<p>Не следует, однако забывать, что постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании существенных финансовых и административных условий. Задача организации, в особенности же дальнейшее развитие различных форм деятельности позволяет оценить значение позиций, занимаемых участниками в отношении поставленных задач.</p>\r\n\r\n<p>Идейные соображения высшего порядка, а также консультация с широким активом позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач. Разнообразный и богатый опыт рамки и место обучения кадров в значительной степени обуславливает создание существенных финансовых и административных условий. Не следует, однако забывать, что начало повседневной работы по формированию позиции способствует подготовки и реализации модели развития.</p>\r\n','test','','2017-11-16 17:51:49','2017-11-16 17:51:49',2,1,1);
/*!40000 ALTER TABLE `test_xcompany_blog_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_blog_article_has_blog_tag`
--

DROP TABLE IF EXISTS `test_xcompany_blog_article_has_blog_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_blog_article_has_blog_tag` (
  `blog_article_id` int(11) unsigned NOT NULL,
  `blog_tag_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`blog_article_id`,`blog_tag_id`),
  KEY `fk_blog_article_has_blog_tag_blog_tag1_idx` (`blog_tag_id`),
  CONSTRAINT `fk_blog_article_has_blog_tag_blog_article1_idx` FOREIGN KEY (`blog_article_id`) REFERENCES `test_xcompany_blog_article` (`id`),
  CONSTRAINT `fk_blog_article_has_blog_tag_blog_tag1_idx` FOREIGN KEY (`blog_tag_id`) REFERENCES `test_xcompany_blog_tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_blog_article_has_blog_tag`
--

LOCK TABLES `test_xcompany_blog_article_has_blog_tag` WRITE;
/*!40000 ALTER TABLE `test_xcompany_blog_article_has_blog_tag` DISABLE KEYS */;
INSERT INTO `test_xcompany_blog_article_has_blog_tag` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `test_xcompany_blog_article_has_blog_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_blog_category`
--

DROP TABLE IF EXISTS `test_xcompany_blog_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_blog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_blog_category_user1_idx` (`user_id`),
  CONSTRAINT `fk_blog_category_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `test_xcompany_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_blog_category`
--

LOCK TABLES `test_xcompany_blog_category` WRITE;
/*!40000 ALTER TABLE `test_xcompany_blog_category` DISABLE KEYS */;
INSERT INTO `test_xcompany_blog_category` VALUES (1,'life',NULL,'Жизнь','Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать текст более привлекательным и живым для визуально-слухового восприятия.\r\n\r\nПо своей сути рыбатекст является альтернативой традиционному lorem ipsum, который вызывает у некторых людей недоумение при попытках прочитать рыбу текст. В отличии от lorem ipsum, текст рыба на русском языке наполнит любой макет непонятным смыслом и придаст неповторимый колорит советских времен. ','жизнь','Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке','2017-11-15 20:09:57','2017-11-15 20:20:58',1),(2,'motivation',NULL,'Мотивация',' Задача организации, в особенности же сложившаяся структура организации требуют от нас анализа систем массового участия. Не следует, однако забывать, что рамки и место обучения кадров позволяет выполнять важные задания по разработке позиций, занимаемых участниками в отношении поставленных задач. Не следует, однако забывать, что реализация намеченных плановых заданий требуют от нас анализа направлений прогрессивного развития. Не следует, однако забывать, что реализация намеченных плановых заданий позволяет выполнять важные задания по разработке новых предложений. Значимость этих проблем настолько очевидна, что новая модель организационной деятельности позволяет оценить значение форм развития. Разнообразный и богатый опыт консультация с широким активом представляет собой интересный эксперимент проверки дальнейших направлений развития.\r\n\r\nПовседневная практика показывает, что постоянное информационно-пропагандистское обеспечение нашей деятельности обеспечивает широкому кругу (специалистов) участие в формировании существенных финансовых и административных условий. Равным образом сложившаяся структура организации представляет собой интересный эксперимент проверки форм развития. ','Мотивация','Задача организации, в особенности же сложившаяся структура организации требуют от нас анализа систем массового участия.','2017-11-15 20:19:06','2017-11-15 20:19:06',1);
/*!40000 ALTER TABLE `test_xcompany_blog_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_blog_image`
--

DROP TABLE IF EXISTS `test_xcompany_blog_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_blog_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `origin_name` varchar(255) NOT NULL,
  `name` char(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_blog_image`
--

LOCK TABLES `test_xcompany_blog_image` WRITE;
/*!40000 ALTER TABLE `test_xcompany_blog_image` DISABLE KEYS */;
INSERT INTO `test_xcompany_blog_image` VALUES (1,NULL,'100 Best Wallpapers 11 1920x1080 (10).jpg','fc3fecaebd6522b62339196046b7f3bb.jpg'),(2,NULL,'100 Best Wallpapers 11 1920x1080 (10).jpg','b858354b34ee9bf3ccd14967a6997a85.jpg');
/*!40000 ALTER TABLE `test_xcompany_blog_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_blog_tag`
--

DROP TABLE IF EXISTS `test_xcompany_blog_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_blog_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_blog_tag`
--

LOCK TABLES `test_xcompany_blog_tag` WRITE;
/*!40000 ALTER TABLE `test_xcompany_blog_tag` DISABLE KEYS */;
INSERT INTO `test_xcompany_blog_tag` VALUES (1,'Здоровье'),(2,'Видео'),(3,'Тего-тест');
/*!40000 ALTER TABLE `test_xcompany_blog_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_link_item`
--

DROP TABLE IF EXISTS `test_xcompany_link_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_link_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `link` varchar(255) NOT NULL,
  `price` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `fk_link_item_user1_idx` (`user_id`),
  CONSTRAINT `fk_link_item_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `test_xcompany_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_link_item`
--

LOCK TABLES `test_xcompany_link_item` WRITE;
/*!40000 ALTER TABLE `test_xcompany_link_item` DISABLE KEYS */;
INSERT INTO `test_xcompany_link_item` VALUES (1,1,'/site/about',1),(4,2,'/blog/article/1',10),(5,3,'/blog/article/2',10);
/*!40000 ALTER TABLE `test_xcompany_link_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_link_user_balance`
--

DROP TABLE IF EXISTS `test_xcompany_link_user_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_link_user_balance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `balance` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_link_user_balance_user1_idx` (`user_id`),
  CONSTRAINT `fk_link_user_balance_user1_idx` FOREIGN KEY (`user_id`) REFERENCES `test_xcompany_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_link_user_balance`
--

LOCK TABLES `test_xcompany_link_user_balance` WRITE;
/*!40000 ALTER TABLE `test_xcompany_link_user_balance` DISABLE KEYS */;
INSERT INTO `test_xcompany_link_user_balance` VALUES (1,1,200),(2,2,100),(3,3,0);
/*!40000 ALTER TABLE `test_xcompany_link_user_balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_migration`
--

DROP TABLE IF EXISTS `test_xcompany_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_migration`
--

LOCK TABLES `test_xcompany_migration` WRITE;
/*!40000 ALTER TABLE `test_xcompany_migration` DISABLE KEYS */;
INSERT INTO `test_xcompany_migration` VALUES ('common\\modules\\blog\\migrations\\M171115000213CreateTableBlogImage',1510707164),('common\\modules\\blog\\migrations\\M171115000221CreateTableBlogArticle',1510707165),('common\\modules\\blog\\migrations\\M171115000255CreateTableBlogCategory',1510707167),('common\\modules\\blog\\migrations\\M171115000308CreateTableBlogTag',1510707167),('common\\modules\\blog\\migrations\\M171115000339CreateTableBlogArticleHasBlogTag',1510707168),('common\\modules\\link\\migrations\\M171116112737CreateTableLinkItem',1510837461),('common\\modules\\link\\migrations\\M171116112743CreateTableLinkUserBalance',1510837462),('m000000_000000_base',1510707160),('m130524_201442_init',1510707162),('m171113_224909_create_first_user',1510707162),('m171113_224938_rbac_init',1510707163),('m171113_224959_rbac_add_index_on_auth_assignment_user_id',1510707163),('m171113_225030_add_starting_roles',1510707163);
/*!40000 ALTER TABLE `test_xcompany_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_xcompany_user`
--

DROP TABLE IF EXISTS `test_xcompany_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_xcompany_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_xcompany_user`
--

LOCK TABLES `test_xcompany_user` WRITE;
/*!40000 ALTER TABLE `test_xcompany_user` DISABLE KEYS */;
INSERT INTO `test_xcompany_user` VALUES (1,'admin','kL4Wi56BbEmBqugcHRdRQm55q2rFppG5','$2y$13$R9VvhiqOBsRT81Vzs3/FretaZSdiIwc8zaJ3xHlRXOeHfJMSIfmfS',NULL,'admin@t-shop.dev',10,1510707162,1510707162),(2,'test','P-C6_kreAlNQZf4cV9X7yBJ7ZSq1lGJu','$2y$13$c3Wv/cNjAYLwkYKM9/N3XuoXpV2pkjrck3/kZ.Ugdzi0965pleaDq',NULL,'test@test.tt',10,1510837166,1510837166),(3,'test1','uGGW0emOEtHAqUWHkMsQd2uuiskCqvBA','$2y$13$9p7vJG7LepHBi/vG5oakNOS9Ie3hx/1lciUAULYWHShZUmDt3e3v.',NULL,'test1@test.tt',10,1510837191,1510837191);
/*!40000 ALTER TABLE `test_xcompany_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-16 18:09:46
