-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: la2etlak_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `lc_advertising`
--

DROP TABLE IF EXISTS `lc_advertising`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_advertising` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `integration` varchar(50) DEFAULT NULL COMMENT 'Possible values: unitSlot|autoFit',
  `slug` varchar(50) NOT NULL COMMENT 'Possible values: top|bottom|auto',
  `is_responsive` tinyint(1) DEFAULT 0,
  `provider_name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL COMMENT 'Translated in the languages files',
  `tracking_code_large` mediumtext DEFAULT NULL,
  `tracking_code_medium` mediumtext DEFAULT NULL,
  `tracking_code_small` mediumtext DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_advertising_slug_unique` (`slug`),
  KEY `lc_advertising_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_blacklist`
--

DROP TABLE IF EXISTS `lc_blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_blacklist` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('domain','email','phone','ip','word') DEFAULT NULL,
  `entry` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `lc_blacklist_type_entry_index` (`type`,`entry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_cache`
--

DROP TABLE IF EXISTS `lc_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_cache` (
  `key` varchar(191) NOT NULL,
  `value` longtext NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `lc_cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_cache_locks`
--

DROP TABLE IF EXISTS `lc_cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_categories`
--

DROP TABLE IF EXISTS `lc_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` text NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hide_description` tinyint(1) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `seo_title` text DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `type` enum('classified','job-offer','job-search','rent','not-salable') DEFAULT 'classified',
  `is_for_permanent` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `lc_categories_slug_index` (`slug`),
  KEY `lc_categories_parent_id_index` (`parent_id`),
  KEY `lc_categories_lft_index` (`lft`),
  KEY `lc_categories_rgt_index` (`rgt`),
  KEY `lc_categories_depth_index` (`depth`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_category_field`
--

DROP TABLE IF EXISTS `lc_category_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_category_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `field_id` int(10) unsigned DEFAULT NULL,
  `disabled_in_subcategories` tinyint(1) DEFAULT 0,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_category_field_category_id_field_id_unique` (`category_id`,`field_id`),
  KEY `lc_category_field_category_id_index` (`category_id`),
  KEY `lc_category_field_field_id_index` (`field_id`),
  KEY `lc_category_field_lft_index` (`lft`),
  KEY `lc_category_field_rgt_index` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_cities`
--

DROP TABLE IF EXISTS `lc_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) DEFAULT NULL,
  `name` text NOT NULL,
  `longitude` double DEFAULT NULL COMMENT 'longitude in decimal degrees (wgs84)',
  `latitude` double DEFAULT NULL COMMENT 'latitude in decimal degrees (wgs84)',
  `feature_class` char(1) DEFAULT NULL,
  `feature_code` varchar(10) DEFAULT NULL,
  `subadmin1_code` varchar(100) DEFAULT NULL,
  `subadmin2_code` varchar(100) DEFAULT NULL,
  `population` bigint(20) DEFAULT NULL,
  `time_zone` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_cities_country_code_index` (`country_code`),
  KEY `lc_cities_subadmin1_code_index` (`subadmin1_code`),
  KEY `lc_cities_subadmin2_code_index` (`subadmin2_code`),
  KEY `lc_cities_population_index` (`population`),
  KEY `lc_cities_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_countries`
--

DROP TABLE IF EXISTS `lc_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `iso_numeric` int(10) unsigned DEFAULT NULL,
  `fips` char(2) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `capital` varchar(100) DEFAULT NULL,
  `area` int(10) unsigned DEFAULT NULL,
  `population` int(10) unsigned DEFAULT NULL,
  `continent_code` char(4) DEFAULT NULL,
  `tld` char(4) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `postal_code_format` varchar(50) DEFAULT NULL,
  `postal_code_regex` varchar(200) DEFAULT NULL,
  `languages` varchar(50) DEFAULT NULL,
  `neighbours` varchar(50) DEFAULT NULL,
  `equivalent_fips_code` varchar(100) DEFAULT NULL,
  `time_zone` varchar(50) DEFAULT NULL,
  `date_format` varchar(100) DEFAULT NULL,
  `datetime_format` varchar(100) DEFAULT NULL,
  `background_image_path` varchar(255) DEFAULT NULL,
  `admin_type` enum('0','1','2') DEFAULT '0',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_countries_code_unique` (`code`),
  KEY `lc_countries_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_currencies`
--

DROP TABLE IF EXISTS `lc_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(180) DEFAULT NULL,
  `symbol` varchar(5) DEFAULT NULL,
  `html_entities` varchar(50) DEFAULT NULL COMMENT 'HTML Entities of Symbols: https://gist.github.com/Gibbs/3920259',
  `in_left` tinyint(1) DEFAULT 0,
  `decimal_places` int(10) unsigned DEFAULT 0 COMMENT 'Currency Decimal Places - ISO 4217',
  `decimal_separator` varchar(10) DEFAULT '.',
  `thousand_separator` varchar(10) DEFAULT ',',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_currencies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_failed_jobs`
--

DROP TABLE IF EXISTS `lc_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_fields`
--

DROP TABLE IF EXISTS `lc_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `belongs_to` enum('post','user') NOT NULL DEFAULT 'post',
  `name` text DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'text',
  `max` int(10) unsigned DEFAULT 255,
  `default_value` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `use_as_filter` tinyint(1) DEFAULT 0,
  `help` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_fields_belongs_to_index` (`belongs_to`),
  KEY `lc_fields_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_fields_options`
--

DROP TABLE IF EXISTS `lc_fields_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_fields_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned DEFAULT NULL,
  `value` mediumtext DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_fields_options_field_id_index` (`field_id`),
  KEY `lc_fields_options_lft_index` (`lft`),
  KEY `lc_fields_options_rgt_index` (`rgt`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_job_batches`
--

DROP TABLE IF EXISTS `lc_job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_jobs`
--

DROP TABLE IF EXISTS `lc_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_languages`
--

DROP TABLE IF EXISTS `lc_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `locale` varchar(25) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `native` varchar(100) DEFAULT NULL,
  `flag` varchar(100) DEFAULT NULL,
  `script` varchar(20) DEFAULT NULL COMMENT 'Language''s Script Code',
  `direction` enum('ltr','rtl') DEFAULT 'ltr',
  `russian_pluralization` tinyint(1) DEFAULT 0,
  `date_format` varchar(100) DEFAULT NULL,
  `datetime_format` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `default` tinyint(1) DEFAULT 0,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_languages_code_unique` (`code`),
  KEY `lc_languages_lft_index` (`lft`),
  KEY `lc_languages_rgt_index` (`rgt`),
  KEY `lc_languages_active_index` (`active`),
  KEY `lc_languages_default_index` (`default`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_meta_tags`
--

DROP TABLE IF EXISTS `lc_meta_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_meta_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(50) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `lc_meta_tags_page_index` (`page`),
  KEY `lc_meta_tags_active_index` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_migrations`
--

DROP TABLE IF EXISTS `lc_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_model_has_permissions`
--

DROP TABLE IF EXISTS `lc_model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `lc_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `lc_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_model_has_roles`
--

DROP TABLE IF EXISTS `lc_model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `lc_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `lc_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_packages`
--

DROP TABLE IF EXISTS `lc_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('promotion','subscription') NOT NULL DEFAULT 'promotion' COMMENT 'Post promotion OR User subscription',
  `name` text DEFAULT NULL COMMENT 'In country language',
  `short_name` text DEFAULT NULL COMMENT 'In country language',
  `ribbon` varchar(191) DEFAULT NULL COMMENT 'Ribbon color (Bootstrap Theme Color)',
  `has_badge` tinyint(1) DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `promotion_time` int(11) DEFAULT NULL COMMENT 'In days',
  `interval` enum('week','month','year') DEFAULT NULL COMMENT 'Package''s validity period',
  `listings_limit` int(11) DEFAULT NULL COMMENT 'Listings per subscriber (during the "interval")',
  `pictures_limit` int(11) DEFAULT 5 COMMENT 'Pictures per listing (for post & user''s post)',
  `expiration_time` int(10) unsigned DEFAULT 30 COMMENT 'Listing expiration time (In days)',
  `description` text DEFAULT NULL COMMENT 'In country language',
  `facebook_ads_duration` int(10) unsigned DEFAULT 0,
  `google_ads_duration` int(10) unsigned DEFAULT 0,
  `twitter_ads_duration` int(10) unsigned DEFAULT 0,
  `linkedin_ads_duration` int(10) unsigned DEFAULT 0,
  `recommended` tinyint(1) DEFAULT 0,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `lc_packages_type_index` (`type`),
  KEY `lc_packages_lft_index` (`lft`),
  KEY `lc_packages_rgt_index` (`rgt`),
  KEY `lc_packages_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_pages`
--

DROP TABLE IF EXISTS `lc_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `type` enum('standard','terms','privacy','tips') NOT NULL,
  `name` text DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `external_link` varchar(255) DEFAULT NULL,
  `name_color` varchar(10) DEFAULT NULL,
  `title_color` varchar(10) DEFAULT NULL,
  `target_blank` tinyint(1) DEFAULT 0,
  `seo_title` text DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` text DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `excluded_from_footer` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_pages_slug_index` (`slug`),
  KEY `lc_pages_parent_id_index` (`parent_id`),
  KEY `lc_pages_lft_index` (`lft`),
  KEY `lc_pages_rgt_index` (`rgt`),
  KEY `lc_pages_active_index` (`active`),
  KEY `lc_pages_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_password_reset_tokens`
--

DROP TABLE IF EXISTS `lc_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_password_reset_tokens` (
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `phone_country` varchar(2) DEFAULT NULL,
  `token` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `lc_password_reset_tokens_email_index` (`email`),
  KEY `lc_password_reset_tokens_phone_index` (`phone`),
  KEY `lc_password_reset_tokens_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_payment_methods`
--

DROP TABLE IF EXISTS `lc_payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `has_ccbox` tinyint(1) DEFAULT 0,
  `is_compatible_api` tinyint(1) DEFAULT 0,
  `countries` mediumtext DEFAULT NULL COMMENT 'Countries codes separated by comma.',
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `lc_payment_methods_has_ccbox_index` (`has_ccbox`),
  KEY `lc_payment_methods_lft_index` (`lft`),
  KEY `lc_payment_methods_rgt_index` (`rgt`),
  KEY `lc_payment_methods_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_payments`
--

DROP TABLE IF EXISTS `lc_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payable_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Post|User ID',
  `payable_type` varchar(191) DEFAULT NULL COMMENT 'Post|User class name',
  `package_id` int(10) unsigned DEFAULT NULL,
  `payment_method_id` int(10) unsigned DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL COMMENT 'Transaction''s ID from the Provider',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency_code` varchar(3) DEFAULT NULL,
  `period_start` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `period_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `canceled_at` timestamp NULL DEFAULT NULL COMMENT 'Canceled by the user before the period end',
  `refunded_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_payments_payable_id_payable_type_index` (`payable_id`,`payable_type`),
  KEY `lc_payments_package_id_index` (`package_id`),
  KEY `lc_payments_payment_method_id_index` (`payment_method_id`),
  KEY `lc_payments_transaction_id_index` (`transaction_id`),
  KEY `lc_payments_period_start_period_end_index` (`period_start`,`period_end`),
  KEY `lc_payments_canceled_at_index` (`canceled_at`),
  KEY `lc_payments_refunded_at_index` (`refunded_at`),
  KEY `lc_payments_active_index` (`active`),
  KEY `lc_payments_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_permissions`
--

DROP TABLE IF EXISTS `lc_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_personal_access_tokens`
--

DROP TABLE IF EXISTS `lc_personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_personal_access_tokens_token_unique` (`token`),
  KEY `lc_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_pictures`
--

DROP TABLE IF EXISTS `lc_pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_pictures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `mime_type` varchar(200) DEFAULT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_pictures_post_id_index` (`post_id`),
  KEY `lc_pictures_position_index` (`position`),
  KEY `lc_pictures_active_index` (`active`),
  KEY `lc_pictures_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_post_values`
--

DROP TABLE IF EXISTS `lc_post_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_post_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `field_id` int(10) unsigned DEFAULT NULL,
  `option_id` int(10) unsigned DEFAULT NULL,
  `value` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_post_values_post_id_index` (`post_id`),
  KEY `lc_post_values_field_id_index` (`field_id`),
  KEY `lc_post_values_option_id_index` (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_posts`
--

DROP TABLE IF EXISTS `lc_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `payment_id` bigint(20) unsigned DEFAULT NULL COMMENT 'ID of the subscription used to publish the listing',
  `category_id` int(10) unsigned DEFAULT NULL,
  `post_type_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `tags` text DEFAULT NULL,
  `price` decimal(17,2) DEFAULT NULL,
  `currency_code` varchar(3) DEFAULT NULL,
  `negotiable` tinyint(1) DEFAULT 0,
  `lost_or_found` enum('lost','found') NOT NULL DEFAULT 'lost',
  `contact_name` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `city_id` bigint(20) unsigned DEFAULT NULL,
  `lon` double DEFAULT NULL COMMENT 'longitude in decimal degrees (wgs84)',
  `lat` double DEFAULT NULL COMMENT 'latitude in decimal degrees (wgs84)',
  `create_from_ip` varchar(50) DEFAULT NULL COMMENT 'IP address of creation',
  `latest_update_ip` varchar(50) DEFAULT NULL COMMENT 'Latest update IP address',
  `visits` bigint(20) unsigned DEFAULT 0,
  `auth_field` enum('email','phone') DEFAULT 'email',
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `phone_national` varchar(30) DEFAULT NULL,
  `phone_country` varchar(2) DEFAULT NULL,
  `email_token` varchar(191) DEFAULT NULL,
  `phone_token` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `last_otp_sent_at` timestamp NULL DEFAULT NULL,
  `otp_resend_attempts` int(10) unsigned NOT NULL DEFAULT 0,
  `otp_resend_attempts_expires_at` timestamp NULL DEFAULT NULL,
  `total_otp_resend_attempts` int(10) unsigned NOT NULL DEFAULT 0,
  `locked_at` timestamp NULL DEFAULT NULL,
  `phone_hidden` tinyint(1) DEFAULT 0,
  `accept_terms` tinyint(1) DEFAULT 0,
  `accept_marketing_offers` tinyint(1) DEFAULT 0,
  `is_permanent` tinyint(1) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `tmp_token` varchar(191) DEFAULT NULL COMMENT 'Old: Temporary ID for guests posting',
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `archived_manually_at` timestamp NULL DEFAULT NULL,
  `deletion_mail_sent_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_posts_lon_lat_index` (`lon`,`lat`),
  KEY `lc_posts_country_code_index` (`country_code`),
  KEY `lc_posts_user_id_index` (`user_id`),
  KEY `lc_posts_category_id_index` (`category_id`),
  KEY `lc_posts_title_index` (`title`),
  KEY `lc_posts_address_index` (`address`),
  KEY `lc_posts_city_id_index` (`city_id`),
  KEY `lc_posts_featured_index` (`featured`),
  KEY `lc_posts_post_type_id_index` (`post_type_id`),
  KEY `lc_posts_contact_name_index` (`contact_name`),
  KEY `lc_posts_auth_field_index` (`auth_field`),
  KEY `lc_posts_email_index` (`email`),
  KEY `lc_posts_phone_index` (`phone`),
  KEY `lc_posts_phone_country_index` (`phone_country`),
  KEY `lc_posts_email_verified_at_index` (`email_verified_at`),
  KEY `lc_posts_phone_verified_at_index` (`phone_verified_at`),
  KEY `lc_posts_reviewed_at_index` (`reviewed_at`),
  KEY `lc_posts_archived_at_index` (`archived_at`),
  KEY `lc_posts_is_permanent_index` (`is_permanent`),
  KEY `lc_posts_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_report_types`
--

DROP TABLE IF EXISTS `lc_report_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_report_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_role_has_permissions`
--

DROP TABLE IF EXISTS `lc_role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `lc_role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `lc_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `lc_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lc_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `lc_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_roles`
--

DROP TABLE IF EXISTS `lc_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_saved_posts`
--

DROP TABLE IF EXISTS `lc_saved_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_saved_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_saved_posts_user_id_index` (`user_id`),
  KEY `lc_saved_posts_post_id_index` (`post_id`),
  KEY `lc_saved_posts_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_saved_search`
--

DROP TABLE IF EXISTS `lc_saved_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_saved_search` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `keyword` varchar(191) DEFAULT NULL COMMENT 'To show',
  `query` varchar(255) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_saved_search_user_id_index` (`user_id`),
  KEY `lc_saved_search_country_code_index` (`country_code`),
  KEY `lc_saved_search_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_sections`
--

DROP TABLE IF EXISTS `lc_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `belongs_to` varchar(100) NOT NULL DEFAULT 'home',
  `key` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `field` text DEFAULT NULL,
  `value` text DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_sections_belongs_to_key_unique` (`belongs_to`,`key`),
  KEY `lc_sections_belongs_to_index` (`belongs_to`),
  KEY `lc_sections_key_index` (`key`),
  KEY `lc_sections_lft_index` (`lft`),
  KEY `lc_sections_rgt_index` (`rgt`),
  KEY `lc_sections_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_sessions`
--

DROP TABLE IF EXISTS `lc_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_sessions_user_id_index` (`user_id`),
  KEY `lc_sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_settings`
--

DROP TABLE IF EXISTS `lc_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `field` text DEFAULT NULL,
  `value` text DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_settings_key_unique` (`key`),
  KEY `lc_settings_lft_index` (`lft`),
  KEY `lc_settings_rgt_index` (`rgt`),
  KEY `lc_settings_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_subadmin1`
--

DROP TABLE IF EXISTS `lc_subadmin1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_subadmin1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `name` text NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_subadmin1_code_unique` (`code`),
  KEY `lc_subadmin1_country_code_index` (`country_code`),
  KEY `lc_subadmin1_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_subadmin2`
--

DROP TABLE IF EXISTS `lc_subadmin2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_subadmin2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `subadmin1_code` varchar(100) DEFAULT NULL,
  `name` text NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_subadmin2_code_unique` (`code`),
  KEY `lc_subadmin2_country_code_index` (`country_code`),
  KEY `lc_subadmin2_subadmin1_code_index` (`subadmin1_code`),
  KEY `lc_subadmin2_active_index` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_threads`
--

DROP TABLE IF EXISTS `lc_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_threads_post_id_index` (`post_id`),
  KEY `lc_threads_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_threads_messages`
--

DROP TABLE IF EXISTS `lc_threads_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_threads_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `body` mediumtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `deleted_by` bigint(20) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_threads_messages_thread_id_index` (`thread_id`),
  KEY `lc_threads_messages_user_id_index` (`user_id`),
  KEY `lc_threads_messages_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_threads_participants`
--

DROP TABLE IF EXISTS `lc_threads_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_threads_participants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `thread_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `last_read` timestamp NULL DEFAULT NULL,
  `is_important` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_threads_participants_thread_id_index` (`thread_id`),
  KEY `lc_threads_participants_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_user_social_logins`
--

DROP TABLE IF EXISTS `lc_user_social_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_user_social_logins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(100) DEFAULT NULL COMMENT 'facebook, google, twitter, linkedin, ...',
  `provider_id` varchar(191) DEFAULT NULL COMMENT 'Provider User ID',
  `token` varchar(191) DEFAULT NULL COMMENT 'Access token (if needed)',
  `avatar` varchar(191) DEFAULT NULL COMMENT 'Avatar URL (optional)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lc_user_social_logins_user_id_provider_unique` (`user_id`,`provider`),
  UNIQUE KEY `lc_user_social_logins_provider_provider_id_unique` (`provider`,`provider_id`),
  CONSTRAINT `lc_user_social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `lc_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lc_users`
--

DROP TABLE IF EXISTS `lc_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lc_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) DEFAULT NULL,
  `language_code` varchar(10) DEFAULT NULL,
  `user_type_id` tinyint(3) unsigned DEFAULT NULL,
  `gender_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `auth_field` enum('email','phone') DEFAULT 'email',
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `phone_national` varchar(30) DEFAULT NULL,
  `phone_country` varchar(2) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `remember_token` varchar(191) DEFAULT NULL,
  `email_token` varchar(191) DEFAULT NULL COMMENT 'Email verification token or OTP',
  `phone_token` varchar(191) DEFAULT NULL COMMENT 'Phone number verification OTP',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT 0,
  `two_factor_method` enum('email','sms') DEFAULT 'email',
  `two_factor_otp` varchar(191) DEFAULT NULL COMMENT 'Two-Factor Authentication OTP',
  `otp_expires_at` timestamp NULL DEFAULT NULL COMMENT 'Used for account verification & two-factor',
  `last_otp_sent_at` timestamp NULL DEFAULT NULL COMMENT 'Used for account verification & two-factor',
  `otp_resend_attempts` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Used for account verification & two-factor',
  `otp_resend_attempts_expires_at` timestamp NULL DEFAULT NULL COMMENT 'Used for account verification & two-factor',
  `total_login_attempts` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Total login attempts ever',
  `total_otp_resend_attempts` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Total resend attempts ever',
  `locked_at` timestamp NULL DEFAULT NULL COMMENT 'When the total login or OTP resend attempts is reached',
  `is_admin` tinyint(1) DEFAULT 0,
  `can_be_impersonated` tinyint(1) DEFAULT 1,
  `phone_hidden` tinyint(1) DEFAULT 0,
  `disable_comments` tinyint(1) DEFAULT 0,
  `create_from_ip` varchar(50) DEFAULT NULL COMMENT 'IP address of creation',
  `latest_update_ip` varchar(50) DEFAULT NULL COMMENT 'Latest update IP address',
  `accept_terms` tinyint(1) DEFAULT 0,
  `accept_marketing_offers` tinyint(1) DEFAULT 0,
  `theme_preference` varchar(191) DEFAULT NULL COMMENT 'User theme preference: light, dark, system',
  `time_zone` varchar(50) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0 COMMENT 'Need to be cleared form a cron tab command',
  `last_activity` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_users_country_code_index` (`country_code`),
  KEY `lc_users_user_type_id_index` (`user_type_id`),
  KEY `lc_users_auth_field_index` (`auth_field`),
  KEY `lc_users_email_index` (`email`),
  KEY `lc_users_phone_index` (`phone`),
  KEY `lc_users_phone_country_index` (`phone_country`),
  KEY `lc_users_username_index` (`username`),
  KEY `lc_users_email_verified_at_index` (`email_verified_at`),
  KEY `lc_users_phone_verified_at_index` (`phone_verified_at`),
  KEY `lc_users_is_admin_index` (`is_admin`),
  KEY `lc_users_can_be_impersonated_index` (`can_be_impersonated`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-11  5:41:35
