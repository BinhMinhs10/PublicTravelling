CREATE DATABASE  IF NOT EXISTS `travelling` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `travelling`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: travelling
-- ------------------------------------------------------
-- Server version 5.5.5-10.1.30-MariaDB

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `parent_comment_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_plan_id_foreign` (`plan_id`),
  KEY `comments_parent_comment_id_foreign` (`parent_comment_id`),
  CONSTRAINT `comments_parent_comment_id_foreign` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (39,'hay thế','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',1,9,NULL,'2018-08-08 02:02:53','2018-08-08 02:02:53'),(40,'đẹp thế!!!','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',5,12,NULL,'2018-08-08 03:20:40','2018-08-08 03:20:40'),(41,'Rừng ngập mặn cũng đẹp','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',5,9,NULL,'2018-08-08 03:23:22','2018-08-08 03:23:22'),(42,'Mùa thu Hà Nội','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',5,7,NULL,'2018-08-08 03:25:01','2018-08-08 03:25:01'),(43,'Đồ ăn cũng ngon','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',4,15,NULL,'2018-08-08 03:33:10','2018-08-08 03:33:10'),(44,'Lập team cùng đi...','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',4,7,42,'2018-08-08 03:34:01','2018-08-08 03:34:01'),(45,'đẹp nhỉ','Keangnam Hanoi Landmark Tower, Mễ Trì, Từ Liêm, Hà Nội, Việt Nam',4,13,NULL,'2018-08-08 03:36:03','2018-08-08 03:36:03');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `isRequest` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `follows_plan_id_foreign` (`plan_id`),
  KEY `follows_user_id_foreign` (`user_id`),
  CONSTRAINT `follows_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (5,1,7,2,NULL,NULL),(6,1,8,2,NULL,NULL),(7,1,9,2,NULL,NULL),(8,5,12,0,NULL,NULL),(9,5,13,2,NULL,NULL),(10,5,8,2,NULL,NULL),(11,5,7,2,NULL,NULL),(12,5,10,2,NULL,NULL),(13,5,6,NULL,NULL,NULL),(14,4,15,1,NULL,NULL),(15,4,14,0,NULL,NULL),(16,4,13,2,NULL,NULL),(17,4,11,2,NULL,NULL),(18,9,15,NULL,NULL,NULL);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_comment_id_foreign` (`comment_id`),
  CONSTRAINT `images_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (18,'images/comments/photo1533698602RungNgapMan.jpg',41,'2018-08-08 03:23:22','2018-08-08 03:23:22'),(19,'images/comments/photo1533699191HaiSan.jpg',43,'2018-08-08 03:33:11','2018-08-08 03:33:11'),(20,'images/comments/photo1533699191SoDiep.jpg',43,'2018-08-08 03:33:11','2018-08-08 03:33:11');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joins`
--

DROP TABLE IF EXISTS `joins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `joins_plan_id_foreign` (`plan_id`),
  KEY `joins_user_id_foreign` (`user_id`),
  CONSTRAINT `joins_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `joins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joins`
--

LOCK TABLES `joins` WRITE;
/*!40000 ALTER TABLE `joins` DISABLE KEYS */;
INSERT INTO `joins` VALUES (1,1,9,NULL,NULL),(2,1,8,NULL,NULL),(3,5,8,NULL,NULL),(4,1,7,NULL,NULL),(5,5,7,NULL,NULL),(6,5,10,NULL,NULL),(7,4,11,NULL,NULL),(9,5,13,NULL,NULL),(10,4,13,NULL,NULL);
/*!40000 ALTER TABLE `joins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_07_24_023346_create_plans_table',1),(4,'2018_07_24_024945_create_comments_table',1),(5,'2018_07_24_025553_create_images_table',1),(6,'2018_07_25_060725_create_routes_table',1),(7,'2018_07_25_061406_create_joins_table',1),(8,'2018_07_25_061642_create_follows_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `member` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_user_id_foreign` (`user_id`),
  CONSTRAINT `plans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (6,'Hạ Long - Quảng Ninh','4_1533622761_cau-bai-chay-quang-ninh-4.jpg','2018-08-07 13:00:00','2018-08-10 14:30:00',4,'Vịnh Hạ Long nằm ở phía Tây Vịnh Bắc Bộ, thuộc vùng biển Đông Bắc. Với hàng ngàn đảo đá lớn nhỏ và nhiều hang động kỳ vĩ, Hạ Long luôn là một trong những điểm đến thu hút khách du lịch hàng đầu cả nước. Vịnh Hạ Long nhiều lần được vinh danh như di sản của thế giới và được xem như một trong bảy kì quan thiên nhiên mới. Sẽ là đáng tiếc nếu trên những nẻo đường đôi chân bạn chinh phục thiếu đi Hạ Long.',2,4,'2018-08-07 06:19:21','2018-08-07 06:19:21'),(7,'Dạo quanh Hà Nội','4_1533691855_HaNoi.jpg','2018-08-08 08:00:00','2018-08-08 12:00:00',5,'Với hơn 4000 năm văn hiến, Hà Nội là thủ đô âu đời và còn gìn giữ được nhiều di tích cổ xưa, những thắng cảnh đẹp cùng những tuyệt tác thên nhiên làm “say” lòng mọi du khách.\r\n\r\nNếu đã một lần có dịp du lịch Hà Nội, chắc chắn du khách sẽ không thể nào quên không khí đặc trưng duy nhất chỉ có ở tiết trời thủ đô, những di tích cổ kính vang danh như Hồ Gươm, Hồ Tây, những con đường nhỏ, những làng nghề truyền thống cùng những gánh hàng rong và con người thân thiện, hiếu khách với nụ cười luôn thường trực trên môi.',1,4,'2018-08-08 01:30:55','2018-08-08 01:30:55'),(8,'Hà Nội - Tam Đảo','4_1533692701_TamDao2.jpg','2018-08-09 06:00:00','2018-08-10 14:30:00',4,'Tam Đảo được biết đến là địa điểm du lịch hoang sơ, huyền ảo cùng khung cảnh thiên nhiên thơ mộng và hùng vĩ. Du lịch Tam Đảo mùa này bạn sẽ được chiêm ngưỡng những cảnh sắc vô cùng lạ mắt và ấn tượng. Những ngôi nhà huyền ảo trong sương khói hay những biệt thự kiến trúc Pháp tuyệt đẹp chắc chắn sẽ là điều đọng lại lâu nhất trong ký ức của bạn về một thành phố nhỏ nhắn xinh đẹp. Lưu lại những kinh nghiệm du lịch Tam Đảo này bạn nhé',1,4,'2018-08-08 01:45:01','2018-08-08 01:45:01'),(9,'2 ngày trải nghiệm tại Cồn Đen','4_1533693408_ConDen2.jpg','2018-08-10 13:00:00','2018-08-12 08:00:00',5,'Không nổi tiếng về du lịch biển nhưng Thái Bình là nơi sở hữu nhiều cồn biển đẹp tại miền Bắc. Ngoài cồn Vành ở Tiền Hải, những người yêu vẻ đẹp nguyên sơ cùng hệ sinh thái rừng ngập mặn ven biển Thái Bình không nên bỏ qua Cồn Đen ở Thái Thụy, một địa điểm tạo cảm giác mới cho chuyến du lịch cuối tuần trong những ngày nắng nóng.',1,4,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(10,'Dã ngoại tại Hàm Lợn, Sóc Sơn, Hà Nội','1_1533694322_SocSon.jpg','2018-08-10 14:30:00','2018-08-11 14:30:00',10,'Những con suối, thác ghềnh cùng những tảng đá rêu phong, bụi rậm là điều lý tưởng thu hút du khách thích mạo hiểm.\r\nNằm cách Hà Nội 40km theo hướng cao tốc Bắc Thăng Long – Nội Bài, núi Hàm Lợn (thuộc dãy Độc Tôn, Sóc Sơn, Hà Nội) là địa điểm khá quen thuộc với giới trẻ.',1,1,'2018-08-08 02:12:02','2018-08-08 02:12:02'),(11,'Bay trên mùa vàng - Mù Cang Chải','1_1533695871_MuCangChai2.jpg','2018-08-10 08:00:00','2018-08-12 17:00:00',6,'Thời điểm Mù Cang Chải được nhuộm vàng bởi lúa chín trải khắp những thửa ruộng bậc thang dài vô tận thì Lễ hội \"Xòe Mường Lò\" và \"Bay trên mùa vàng\" vốn được du khách chờ đợi suốt một năm qua cũng chính thức được diễn ra. \"Bay trên mùa vàng\" với hàng trăm chiếc dù sải cánh sặc sỡ tung bay trên bầu trời Khau Phạ chắc chắn sẽ là cảnh tượng rất đáng để bạn đến chiêm ngưỡng tận nơi.',1,1,'2018-08-08 02:37:51','2018-08-08 02:37:51'),(12,'Ngắm hoa dã quỳ, Ba Vì','1_1533696923_DaQuy.jpg','2018-08-11 07:00:00','2018-08-11 15:00:00',4,'\"Dã quỳ đang phủ sắc vàng trên sườn núi Ba Vì\" đó là những status mà giới trẻ chia sẻ cho nhau trên mạng xã hội khi Ba Vì vào mùa hoa dã quỳ nở, Hoa dã quỳ còn gọi là cúc quỳ hay hướng dương dại, có thân bụi cao, mùa hoa dã quỳ được gọi là “loài hoa báo hiệu mùa đông” bởi nó chỉ nở hoa vào khoảng cuối tháng 10, tháng 11 khi miền Bắc sắp bước vào ngày đông lạnh giá, hoa dã quỳ chỉ nở rộ trong tầm 10 ngày đến nửa tháng và lụi tàn rất nhanh, Nếu đã trót say mê vẻ đẹp của dã quỳ bạt ngàn trên cao nguyên ở Đà Lạt mà chưa có dịp ghé thăm, hãy đến với Ba Vì để tạm thỏa lòng mong ước như dã quỳ ở đây vẫn có vẻ đẹp riêng, nhất là khi được ngắm hoa trong không gian mờ ảo của mây núi Ba Vì.',1,1,'2018-08-08 02:55:23','2018-08-08 02:55:23'),(13,'Hoa cải trắng Mộc Châu','1_1533697344_MocChau.jpg','2018-11-23 07:00:00','2018-11-25 13:00:00',6,'Mộc Châu mùa hoa cải trắng nở rộ nhất vào tháng 11 và tháng 12 hàng năm. Người dân Mộc Châu gieo hạt cải trắng ở bất cứ đâu có khoảng đất trống. Chính vì thế, đến Mộc Châu vào thời điểm hoa nở rộ, du khách sẽ không khó để được chiêm ngưỡng sắc hoa này. Đặc biệt, ở những khoảng đất rộng lớn, khi hoa cải nở phủ trắng những triền đồi, tạo nên một khung cảnh như thiên đường bạt ngàn hoa cực mãn nhãn.',1,1,'2018-08-08 03:02:24','2018-08-08 03:02:24'),(14,'Thác Bản Giốc - Cao Bằng','5_1533697976_ThacBanGioc.jpg','2018-08-24 07:00:00','2018-08-27 08:00:00',3,'Là một hoặc hai thác nước nằm trên sông Quây Sơn tại biên giới giữa Việt Nam và Trung Quốc. Nếu nhìn từ phía dưới chân thác, phần thác bên trái và nửa phía tây của thác bên phải thuộc chủ quyền của Việt Nam tại xã Đàm Thủy, huyện Trùng Khánh, tỉnh Cao Bằng; nửa phía đông của thác bên phải thuộc chủ quyền của Trung Quốc tại thôn Đức Thiên, trấn Thạc Long, huyện Đại Tân, thành phố Sùng Tả của khu tự trị dân tộc Choang Quảng Tây. Thác nước này cách huyện lỵ Trùng Khánh khoảng 20 km về phía đông bắc, cách thủ phủ Nam Ninh của Quảng Tây khoảng 208 km.',1,5,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(15,'Biển Sầm Sơn - Thanh Hóa','5_1533698361_SamSon.jpg','2018-08-17 08:00:00','2018-08-18 13:00:00',8,'Thời gian lý Sầm Sơn thu hút khách nhất là khoảng tháng 4 đến tháng 8, thời gian này đến Sầm Sơn bạn không những tận hưởng thời tiết cực kì dễ chịu nơi đây mà còn có thể trải nghiệm và tham quan những danh lam thắng cảnh nổi tiếng của Thanh Hóa. Bạn nên đi trong khoảng 3 ngày 2 đêm là hợp lý nhất.',1,5,'2018-08-08 03:19:21','2018-08-08 03:19:21');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routes`
--

DROP TABLE IF EXISTS `routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int(10) unsigned NOT NULL,
  `starting_time` datetime NOT NULL,
  `start_latitude` double(18,14) NOT NULL,
  `start_longitude` double(18,14) NOT NULL,
  `finish_time` datetime NOT NULL,
  `finish_latitude` double(18,14) DEFAULT NULL,
  `finish_longitude` double(18,14) DEFAULT NULL,
  `activities` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vehicle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `routes_plan_id_foreign` (`plan_id`),
  CONSTRAINT `routes_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routes`
--

LOCK TABLES `routes` WRITE;
/*!40000 ALTER TABLE `routes` DISABLE KEYS */;
INSERT INTO `routes` VALUES (16,6,'2018-08-07 13:13:00',21.00555460000000,105.84346280000000,'2018-08-07 13:13:00',21.04832160000000,105.87868639999999,'Di chuyển ','Bus',0,'2018-08-07 06:19:21','2018-08-07 06:19:21'),(17,6,'2018-08-07 14:13:00',21.04832160000000,105.87868639999999,'2018-08-07 14:13:00',20.97119770000000,107.04480690000003,'Di chuyển','Xe khách',1,'2018-08-07 06:19:21','2018-08-07 06:19:21'),(18,6,'2018-08-07 17:14:00',20.97119770000000,107.04480690000003,'2018-08-07 17:14:00',NULL,NULL,'Nghỉ ngơi, khám phá ẩm thực','Xe máy',2,'2018-08-07 06:19:22','2018-08-07 06:19:22'),(19,6,'2018-08-09 07:15:00',20.97119770000000,107.04480690000003,'2018-08-09 07:15:00',20.95538650000000,107.04951759999994,'chơi','Xe máy',3,'2018-08-07 06:19:22','2018-08-07 06:19:22'),(20,6,'2018-08-09 13:30:00',20.95538650000000,107.04951759999994,'2018-08-09 13:30:00',20.72475330000000,106.77425340000002,'di chuyển','Xe khách',4,'2018-08-07 06:19:22','2018-08-07 06:19:22'),(21,6,'2018-08-09 16:30:00',20.72475330000000,106.77425340000002,'2018-08-09 16:30:00',NULL,NULL,'nghỉ mát, ăn uống','Xe máy',5,'2018-08-07 06:19:22','2018-08-07 06:19:22'),(22,6,'2018-08-10 13:30:00',20.72475330000000,106.77425340000002,'2018-08-10 13:30:00',21.00555460000000,105.84346280000000,'đi về','Xe khách',6,'2018-08-07 06:19:22','2018-08-07 06:19:22'),(23,7,'2018-08-08 08:40:00',21.00081430000000,105.85178139999994,'2018-08-08 08:40:00',21.03677890000000,105.83464470000001,'di chuyển','xe đạp',0,'2018-08-08 01:30:55','2018-08-08 01:30:55'),(24,7,'2018-08-08 09:00:00',21.03677890000000,105.83464470000001,'2018-08-08 09:00:00',NULL,NULL,'viếng lăng Bác, tham quan','đi bộ',1,'2018-08-08 01:30:55','2018-08-08 01:30:55'),(25,7,'2018-08-08 11:00:00',21.03677890000000,105.83464470000001,'2018-08-08 11:00:00',21.00081430000000,105.85178139999994,'di chuyển','xe đạp',2,'2018-08-08 01:30:56','2018-08-08 01:30:56'),(26,8,'2018-08-09 07:00:00',21.02842970000000,105.77826870000001,'2018-08-09 07:00:00',21.30728540000000,105.61631510000007,'di chuyển','xe khách',0,'2018-08-08 01:45:01','2018-08-08 01:45:01'),(27,8,'2018-08-09 08:30:00',21.30728540000000,105.61631510000007,'2018-08-09 08:30:00',21.47470640000000,105.57088650000003,'di chuyển','taxi',1,'2018-08-08 01:45:01','2018-08-08 01:45:01'),(28,8,'2018-08-09 09:30:00',21.47470640000000,105.57088650000003,'2018-08-09 09:30:00',NULL,NULL,'vui chơi','xe máy',2,'2018-08-08 01:45:01','2018-08-08 01:45:01'),(29,8,'2018-08-10 13:30:00',21.47470640000000,105.57088650000003,'2018-08-10 13:30:00',21.02842970000000,105.77826870000001,'di chuyển','xe khách',3,'2018-08-08 01:45:01','2018-08-08 01:45:01'),(30,9,'2018-08-10 13:00:00',20.97854580000000,105.84059000000002,'2018-08-10 13:00:00',20.44905290000000,106.33448120000003,'di chuyển','xe khách',0,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(31,9,'2018-08-10 15:10:00',20.44905290000000,106.33448120000003,'2018-08-10 15:10:00',20.56557910000000,106.56488030000003,'di chuyển','xe bus',1,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(32,9,'2018-08-10 16:00:00',20.56557910000000,106.56488030000003,'2018-08-10 16:00:00',20.48595760000000,106.59527709999998,'di chuyển','taxi',2,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(33,9,'2018-08-10 16:20:00',20.48595760000000,106.59527709999998,'2018-08-10 16:20:00',NULL,NULL,'nghỉ ngơi, vui chơi, bắt ngao','',3,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(34,9,'2018-08-12 08:00:00',20.48595760000000,106.59527709999998,'2018-08-12 08:00:00',20.97854580000000,105.84059000000002,'di chuyển','xe khách',4,'2018-08-08 01:56:48','2018-08-08 01:56:48'),(35,10,'2018-08-10 14:30:00',21.00555460000000,105.84346280000000,'2018-08-10 14:30:00',21.30419530000000,105.79917069999999,'di chuyển','xe  máy',0,'2018-08-08 02:12:02','2018-08-08 02:12:02'),(36,10,'2018-08-10 17:30:00',21.30419530000000,105.79917069999999,'2018-08-10 17:30:00',NULL,NULL,'nghỉ ngơi, cắm trại, lội suối, leo núi','',1,'2018-08-08 02:12:02','2018-08-08 02:12:02'),(37,10,'2018-08-11 14:30:00',21.30419530000000,105.79917069999999,'2018-08-11 14:30:00',21.00555460000000,105.84346280000000,'di chuyển','xe máy',2,'2018-08-08 02:12:02','2018-08-08 02:12:02'),(38,11,'2018-08-10 08:00:00',21.02776440000000,105.83415979999995,'2018-08-10 08:00:00',21.60187690000000,104.50626510000006,'di chuyển','ô tô',0,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(39,11,'2018-08-10 13:00:00',21.60187690000000,104.50626510000006,'2018-08-10 13:00:00',NULL,NULL,'ăn trưa, nghỉ ngơi','',1,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(40,11,'2018-08-10 15:00:00',21.60187690000000,104.50626510000006,'2018-08-10 15:00:00',21.76700460000000,104.14660460000005,'di chuyển','ô tô',2,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(41,11,'2018-08-10 17:00:00',21.76700460000000,104.14660460000005,'2018-08-10 17:00:00',NULL,NULL,'vui chơi','',3,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(42,11,'2018-08-12 13:00:00',21.76700460000000,104.14660460000005,'2018-08-12 13:00:00',21.26844300000000,105.20455730000003,'di chuyển','ô tô',4,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(43,11,'2018-08-12 17:00:00',21.26844300000000,105.20455730000003,'2018-08-12 17:00:00',21.02776440000000,105.83415979999995,'di chuyển','ô tô',5,'2018-08-08 02:37:52','2018-08-08 02:37:52'),(44,12,'2018-08-11 07:00:00',21.02796400000000,105.85101320000001,'2018-08-11 07:00:00',21.08223440000000,105.36963800000001,'di chuyển','xe máy',0,'2018-08-08 02:55:24','2018-08-08 02:55:24'),(45,12,'2018-08-11 09:00:00',21.08223440000000,105.36963800000001,'2018-08-11 09:00:00',NULL,NULL,'vui chơi','',1,'2018-08-08 02:55:24','2018-08-08 02:55:24'),(46,12,'2018-08-11 15:00:00',21.08223440000000,105.36963800000001,'2018-08-11 15:00:00',21.02796400000000,105.85101320000001,'di chuyển','xe máy',2,'2018-08-08 02:55:24','2018-08-08 02:55:24'),(47,13,'2018-11-23 07:00:00',21.02796400000000,105.85101320000001,'2018-11-23 07:00:00',20.92208230000000,104.75209389999998,'di chuyển','ô tô',0,'2018-08-08 03:02:24','2018-08-08 03:02:24'),(48,13,'2018-11-23 12:00:00',20.92208230000000,104.75209389999998,'2018-11-23 12:00:00',NULL,NULL,'vui chơi','xe máy',1,'2018-08-08 03:02:25','2018-08-08 03:02:25'),(49,13,'2018-11-25 13:00:00',20.92208230000000,104.75209389999998,'2018-11-25 13:00:00',21.02796400000000,105.85101320000001,'di chuyển','ô tô',2,'2018-08-08 03:02:25','2018-08-08 03:02:25'),(50,14,'2018-08-24 07:00:00',21.02776440000000,105.83415979999995,'2018-08-24 07:00:00',22.30329230000000,105.87600399999997,'di chuyển','xe máy',0,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(51,14,'2018-08-24 11:00:00',22.30329230000000,105.87600399999997,'2018-08-24 11:00:00',NULL,NULL,'nghỉ ngơi','',1,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(52,14,'2018-08-24 13:00:00',22.30329230000000,105.87600399999997,'2018-08-24 13:00:00',22.63568900000000,106.25221429999999,'di chuyển','xe máy',2,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(53,14,'2018-08-25 07:00:00',22.63568900000000,106.25221429999999,'2018-08-25 07:00:00',22.83238260000000,106.58197889999997,'di chuyển','xe máy',3,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(54,14,'2018-08-25 09:00:00',22.83238260000000,106.58197889999997,'2018-08-25 09:00:00',22.85531940000000,106.72259250000002,'di chuyển','xe máy',4,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(55,14,'2018-08-26 08:00:00',22.85531940000000,106.72259250000002,'2018-08-26 08:00:00',22.25668890000000,106.47313140000006,'di chuyển','xe máy',5,'2018-08-08 03:12:56','2018-08-08 03:12:56'),(56,14,'2018-08-26 13:00:00',22.25668890000000,106.47313140000006,'2018-08-26 13:00:00',21.85637050000000,106.62913040000001,'di chuyển','xe máy',6,'2018-08-08 03:12:57','2018-08-08 03:12:57'),(57,14,'2018-08-27 08:00:00',21.85637050000000,106.62913040000001,'2018-08-27 08:00:00',21.02776440000000,105.83415979999995,'di chuyển','xe máy',7,'2018-08-08 03:12:57','2018-08-08 03:12:57'),(58,15,'2018-08-17 08:00:00',21.02776440000000,105.83415979999995,'2018-08-17 08:00:00',19.76350140000000,105.89812340000003,'di chuyển','xe khách',0,'2018-08-08 03:19:21','2018-08-08 03:19:21'),(59,15,'2018-08-17 12:00:00',19.76350140000000,105.89812340000003,'2018-08-17 12:00:00',NULL,NULL,'vui chơi','',1,'2018-08-08 03:19:21','2018-08-08 03:19:21'),(60,15,'2018-08-18 13:00:00',19.76350140000000,105.89812340000003,'2018-08-18 13:00:00',21.02776440000000,105.83415979999995,'di chuyển','xe khách',2,'2018-08-08 03:19:21','2018-08-08 03:19:21');
/*!40000 ALTER TABLE `routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'minh','Nguyễn Bình Minh','20152453@student.hust.edu.vn','$2y$10$wN43HQZ8x/H2v.LCbCNcYO1/tjtyGcGyB9/QyfEltmAEMVwPosrYy','1997-05-06','images/users/user01.jpg',1,'di3J6CxmNKsuvwY7U1PeMwQU9rWTQQw6tBlDOW6KzPe2BDoMjkmRG80GBWHn','2018-07-30 01:42:56','2018-07-30 01:43:28'),(2,'admin','Nguyễn Bình Minh','test1@gmail.com','$2y$10$mSw85UfETyxRwhhYVFSnV.xPXm1xYFY9jhgNeyTNlVgRUScWHRnxe','1996-05-21','images/users/user02.jpg',1,'NrOl5KWZZjdAwO9BqxSvtGwq8vBomcPUN27JlQx1ZaNbLmqENX1Usej5uxT8','2018-07-30 03:35:09','2018-07-30 03:35:09'),(4,'vananhngo','Ngo Van Anh','vananhngo97@gmail.com','$2y$10$u9xuduXYAVEGvjh5Et38D.iCQ0PSKYX7jEa6d1mte2MkpQPX/wrK.','2018-07-17','images/users/hoa2.jpg',0,'Q5cFjS6UKWJEor9sbn6MYse2Wk3c6dZcfYnT2QkbEFT7WUWwSnshsvXuIL6w','2018-07-31 07:41:27','2018-07-31 07:43:28'),(5,'duytv','Tran Van Duy','tranduy200997@gmail.com','$2y$10$BlQhfnTLVTg2sBMcGf2YEu9ePvq7TAjcQsEICrbq4Imh93/77u6Ha','1997-01-02','images/users/sunset-2739472_960_720.jpg',0,'9RaO2E9JEZiQr2SuqMtqjrnPQQIW7Sz1o18g5Z4dzR4ud2hcD4cwheesen0t','2018-08-06 02:47:15','2018-08-06 07:59:34'),(6,'test02','Nguyen Van Test','test02@gmail.com','$2y$10$PhqR05Ump.ujlmpseLKMwui4kXltIUj6AcEWBPYyn.Rju2aoBVWpu','1998-08-06','images/users/dao-co-to-cadb0655-6da2-4dcb-9119-7980d54fff50.png',0,NULL,'2018-08-07 09:05:53','2018-08-07 09:05:53'),(7,'test3','Nguyen Van Test3','test03@gmail.com','$2y$10$xafnH7ke.yHPy5jgAselTOP6BJrD/nFkz.AbVZT/lESPs2QBK2OxG','1998-08-05','images/users/user3.jpg',1,NULL,'2018-08-07 09:11:59','2018-08-07 09:11:59'),(8,'test04','Nguyen Van Test4','test04@gmail.com','$2y$10$kKBAQyBpy1kbOt4D82SKcOix2GWuIl0Awr6qY1xHnC2GqkTj03fTy','1997-08-05','images/users/user4.jpg',1,NULL,'2018-08-07 09:12:55','2018-08-07 09:12:55'),(9,'test05','Nguyen Van Test5','test05@gmail.com','$2y$10$ZGNY04WTO94Rm7JkNGb2IeRUmkBAhJZzb1L/fkpmWw.Je0.toGoF6','1997-08-05','images/users/user5.png',1,'PxCMQsw0AwNAe4NjZZwz9yR8qod2dq6vK9oduVeLMLeYOjQt7hH68cjBHTcJ','2018-08-07 09:14:04','2018-08-07 09:14:04'),(10,'test06','Nguyen Van Test6','test06@gmail.com','$2y$10$RUT8lVwNT1RlGObAep9bNObg447liJ9FqE3v/rnLejb.wsyzOJWou','1997-08-03','images/users/user6.jpg',1,NULL,'2018-08-07 09:14:49','2018-08-07 09:14:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-08 13:06:54
