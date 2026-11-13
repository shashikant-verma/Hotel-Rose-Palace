-- ============================================================================
-- Hotel Rose Palace - MariaDB 10.4 Compatible Database Backup
-- ============================================================================
-- Created: 2026-11-13 18:57:26
-- Database: hotel_rose_palace
-- Tables: 15+ complete with all data
-- Rooms: 15 (101-115) | Room Types: 2 (Deluxe, Executive)
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

mysqldump : -- Warning: column statistics not supported by the server.
At line:1 char:1
+ mysqldump --user=root --host=127.0.0.1 --port=3306 --single-transacti ...
+ ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    + CategoryInfo          : NotSpecified: (-- Warning: col... by the server.:String) [], RemoteExceptio 
   n
    + FullyQualifiedErrorId : NativeCommandError
;
;
;
;
;
;
;
;
;
;
DROP TABLE IF EXISTS `amenities`;
;
;
CREATE TABLE `amenities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon_class` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `amenities_name_unique` (`name`),
  KEY `amenities_is_active_index` (`is_active`),
  KEY `amenities_category_index` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `amenities` WRITE;
;
INSERT INTO `amenities` VALUES (1,'Free Wi-Fi','High-speed internet connection in all rooms','fas fa-wifi','Technology',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(2,'Free Parking','Private parking available for all guests','fas fa-car','Parking',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(3,'24-Hour Front Desk','Round-the-clock assistance from our staff','fas fa-bell','Services',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(5,'Room Service','In-room dining available 24/7','fas fa-concierge-bell','Services',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(6,'Laundry Service','Professional laundry and ironing services','fas fa-soap','Services',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(7,'Air Conditioning','Climate-controlled rooms for your comfort','fas fa-wind','Amenities',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(8,'Television','Flat-screen TV with cable channels','fas fa-tv','Entertainment',1,'2026-11-12 03:41:45','2026-11-12 03:41:45'),(9,'Private Bathroom','Ensuite bathroom with premium toiletries','fas fa-bath','Amenities',1,'2026-11-12 03:41:45','2026-11-12 03:41:45');
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `amenity_room_type`;
;
;
CREATE TABLE `amenity_room_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amenity_id` bigint(20) unsigned NOT NULL,
  `room_type_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `amenity_room_type_amenity_id_room_type_id_unique` (`amenity_id`,`room_type_id`),
  KEY `amenity_room_type_room_type_id_foreign` (`room_type_id`),
  CONSTRAINT amenity_room_type_amenity_id_foreign FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE,
  CONSTRAINT amenity_room_type_room_type_id_foreign FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `amenity_room_type` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `banquet_bookings`;
;
;
CREATE TABLE `banquet_bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference_id` varchar(255) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `organizer_name` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `event_date` date NOT NULL,
  `slot` varchar(30) NOT NULL DEFAULT 'evening',
  `time_slot` varchar(50) DEFAULT NULL,
  `event_type` varchar(50) NOT NULL DEFAULT 'wedding',
  `guest_count` int(11) NOT NULL DEFAULT 100,
  `seating_layout` varchar(50) DEFAULT NULL,
  `catering_package` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(50) DEFAULT NULL,
  `payment_status` varchar(30) NOT NULL DEFAULT 'unpaid',
  `status` varchar(30) NOT NULL DEFAULT 'tentative',
  `special_notes` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banquet_bookings_reference_id_unique` (`reference_id`),
  KEY `banquet_bookings_event_date_index` (`event_date`),
  KEY `banquet_bookings_status_index` (`status`),
  KEY `banquet_bookings_slot_index` (`slot`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `banquet_bookings` WRITE;
;
INSERT INTO `banquet_bookings` VALUES (1,'HRP-BNQ-2026-0001','Surat Diamond Exporters Meet','Kantilalbhai Chovatia','+91 98250 12389','Kantilalbhai Chovatia','+91 98250 12389','kantilal@suratdiaexporters.org','2026-11-14','morning','Morning (9 AM ΓÇô 2 PM)','Surat Diamond Exporters Meet',85,'Theatre','Pure Veg Executive Lunch & Hi-Tea with Live Counters',28500.00,15000.00,'UPI / GPay','partial','confirmed','Projector screen, podium mic, and separate executive lunch dining area required.','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(2,'HRP-BNQ-2026-0002','Patel Family Engagement Reception','Dineshbhai Patel','+91 98791 88204','Dineshbhai Patel','+91 98791 88204','dinesh.patel@patelfamily.in','2026-11-17','evening','Evening (6 PM ΓÇô 11:30 PM)','Patel Family Engagement Reception',180,'Floating & Cluster','Gujarati & Jain Special Feast (100% Pure Veg)',65000.00,30000.00,'Card Swipe','partial','confirmed','Floral stage backdrop in Burgundy & Gold, bride/groom welcome drinks, Jain sweet counter.','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(3,'HRP-BNQ-2026-0003','Textile Manufacturers Seminar','Sanjay Jariwala','+91 99092 33410','Sanjay Jariwala','+91 99092 33410','sanjay@jariwalatex.com','2026-11-20','full_day','Full Day (9 AM ΓÇô 9 PM)','Textile Manufacturers Seminar',120,'U-Shape','High Tea & Multi-Cuisine Veg Lunch',42000.00,10000.00,'Cash at Reception','partial','tentative','Tentative reservation. Formal confirmation letter and balance advance expected 3 days before event.','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache`;
;
;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `cache` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache_locks`;
;
;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `cache_locks` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `contact_messages`;
;
;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_replied` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_email_index` (`email`),
  KEY `contact_messages_is_read_index` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `contact_messages` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `enquiries`;
;
;
CREATE TABLE `enquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference_id` varchar(255) NOT NULL,
  `booking_ref` varchar(50) DEFAULT NULL,
  `booking_type` varchar(20) NOT NULL DEFAULT 'website',
  `room_type_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `id_proof_type` varchar(50) DEFAULT NULL,
  `id_proof_number` varchar(50) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_in` date DEFAULT NULL,
  `check_out_date` date NOT NULL,
  `check_out` date DEFAULT NULL,
  `num_adults` int(11) NOT NULL DEFAULT 2,
  `num_children` int(11) NOT NULL DEFAULT 0,
  `special_requests` longtext DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'unpaid',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_tariff` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'new',
  `internal_notes` longtext DEFAULT NULL,
  `whatsapp_message_sent_at` timestamp NULL DEFAULT NULL,
  `contacted_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enquiries_reference_id_unique` (`reference_id`),
  KEY `enquiries_room_type_id_foreign` (`room_type_id`),
  KEY `enquiries_reference_id_index` (`reference_id`),
  KEY `enquiries_customer_phone_index` (`customer_phone`),
  KEY `enquiries_status_index` (`status`),
  KEY `enquiries_check_in_date_index` (`check_in_date`),
  KEY `enquiries_created_at_index` (`created_at`),
  KEY `enquiries_room_id_foreign` (`room_id`),
  CONSTRAINT enquiries_room_id_foreign FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL,
  CONSTRAINT enquiries_room_type_id_foreign FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `enquiries` WRITE;
;
INSERT INTO `enquiries` VALUES (1,'HRP-1001','HRP-1001','walk_in',2,6,'Rajeshbhai Patel','Rajeshbhai Patel','rajesh.patel@suratdiamonds.com','+91 98251 44210','+91 98251 44210','Aadhaar Card','2481-9012-3456','2026-11-12','2026-11-12','2026-11-14','2026-11-14',2,0,'Jain breakfast buffet & quiet room','UPI / GPay','paid',5374.00,4798.00,5374.00,'checked_in','Diamond merchant VIP guest. Key card #106 given.',NULL,NULL,'2026-11-11 18:30:00','2026-11-12 07:45:00',NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(2,'HRP-1002','HRP-1002','corporate',3,11,'Vikramaditya Shah','Vikramaditya Shah','v.shah@shahindustries.in','+91 98790 11234','+91 98790 11234','Passport','Z9821456','2026-11-11','2026-11-11','2026-11-14','2026-11-14',2,1,'Airport pickup from Surat Airport & late checkout','Card Swipe','paid',11757.00,10497.00,11757.00,'checked_in','Corporate account billed at reception via ICICI POS swipe. Room #111.',NULL,NULL,'2026-11-10 18:30:00','2026-11-11 09:00:00',NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(3,'HRP-1003','HRP-1003','phone',2,7,'Neha & Karan Mehta','Neha & Karan Mehta','mehta.karan@gmail.com','+91 99099 77812','+91 99099 77812','Aadhaar Card','7823-1190-4451','2026-11-12','2026-11-12','2026-11-15','2026-11-15',2,0,'Extra pillows & Dumas beach excursion tips','Cash at Reception','paid',8061.00,7197.00,8061.00,'checked_in','Cash received at reception desk and entered in register. Room #107.',NULL,NULL,'2026-11-11 18:30:00','2026-11-12 09:40:00',NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(4,'HRP-1004','HRP-1004','walk_in',1,2,'Amitabh Desai','Amitabh Desai','amitabh.desai@yahoo.com','+91 98240 55678','+91 98240 55678','Driving License','GJ-05-2018-009124','2026-11-11','2026-11-11','2026-11-13','2026-11-13',2,0,'Early breakfast on departure day','UPI / GPay','paid',3864.00,3450.00,3864.00,'checked_out','Checked out at 10:30 AM. Room #102 marked dirty for cleaning.',NULL,NULL,'2026-11-10 18:30:00','2026-11-11 06:30:00','2026-11-13 05:00:00','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(5,'HRP-1005','HRP-1005','website',2,8,'Sneha Kulkarni','Sneha Kulkarni','sneha.k@rediffmail.com','+91 97277 33490','+91 97277 33490','Aadhaar Card','9102-4411-8723','2026-11-12','2026-11-12','2026-11-13','2026-11-13',1,0,'Quiet room & iron board','Cash at Reception','paid',2911.00,2599.00,2911.00,'checked_out','Checked out 09:45 AM. Left 5-star review on Google. Room #108.',NULL,NULL,'2026-11-11 18:30:00','2026-11-12 08:30:00','2026-11-13 04:15:00','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(6,'HRP-1006','HRP-1006','phone',3,13,'Pravinbhai Zaveri','Pravinbhai Zaveri','p.zaveri@zaverijewellers.com','+91 98250 88901','+91 98250 88901','Aadhaar Card','3341-9982-1029','2026-11-13','2026-11-13','2026-11-16','2026-11-16',3,1,'Maharaja suite setup, welcome garland & Gujarati snacks','Pay at Checkout','pending',0.00,13497.00,15117.00,'confirmed','Arriving around 2:00 PM by road from Ahmedabad. Keep key #113 ready.',NULL,NULL,'2026-11-11 18:30:00',NULL,NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(7,'HRP-1007','HRP-1007','website',1,1,'Dr. Ananya Joshi','Dr. Ananya Joshi','ananya.joshi@medsurat.org','+91 98980 22145','+91 98980 22145','Driving License','GJ-01-2015-776219','2026-11-13','2026-11-13','2026-11-14','2026-11-14',1,0,'Attending medical conference near VR Surat Mall','UPI / GPay','paid',1932.00,1725.00,1932.00,'confirmed','Paid upfront via GPay QR at reception pre-booking. Room #101.',NULL,NULL,'2026-11-12 18:30:00',NULL,NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(8,'HRP-1008','HRP-1008','phone',1,3,'Suresh Agarwal','Suresh Agarwal','suresh.agarwal@agarwaltextiles.com','+91 99250 66321','+91 99250 66321','Aadhaar Card','5512-8871-3329','2026-11-14','2026-11-14','2026-11-16','2026-11-16',2,1,'King size bed, Ring Road textile market transit shuttle','Pay at Checkout','pending',0.00,3798.00,4254.00,'pending','Tentative phone reservation for Room #103. Needs confirmation call tomorrow 10 AM.',NULL,NULL,NULL,NULL,NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(9,'HRP-1009','HRP-1009','website',3,12,'Ritu & Manish Modi','Ritu & Manish Modi','manish.modi@outlook.com','+91 98254 90123','+91 98254 90123','Passport','P4410982','2026-11-15','2026-11-15','2026-11-18','2026-11-18',3,1,'Family vacation stay, extra mattress & pure vegetarian thali dinner','UPI / GPay','partial',5000.00,11997.00,13437.00,'confirmed','Γé╣5,000 advance received via UPI for Room #112. Balance Γé╣8,437 due at checkout.',NULL,NULL,'2026-11-12 18:30:00',NULL,NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(10,'HRP-1010','HRP-1010','corporate',4,15,'Harishchandra Bhatia','Harishchandra Bhatia','h.bhatia@bhatiagroup.in','+91 98795 44109','+91 98795 44109','Voter ID','GJA1289034','2026-11-17','2026-11-17','2026-11-19','2026-11-19',4,2,'Presidential floor complete privacy & floral arrangement','Pay at Checkout','pending',0.00,10998.00,12318.00,'pending','Presidential Sky Suite Room #115 complete privacy & floral arrangement.',NULL,NULL,NULL,NULL,NULL,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
;
;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `failed_jobs` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `gallery_images`;
;
;
CREATE TABLE `gallery_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_category_index` (`category`),
  KEY `gallery_images_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `gallery_images` WRITE;
;
INSERT INTO `gallery_images` VALUES (1,'Hotel Rose Palace Grand Arrival Facade','hotel/hero-1.jpg','/images/hotel/hero-1.jpg','exterior','Hotel Rose Palace warm-lit entrance and architecture at VIP Road, Vesu, Surat',1,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(2,'Grand Reception & Front Desk Lounge','hotel/lobby.jpg','/images/hotel/lobby.jpg','lobby','Warm sandstone boutique front desk with ambient golden lighting and welcoming lounge',2,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(3,'Executive Bedroom Reading Corner','gallery/gallery-1.jpg','/images/gallery/gallery-1.jpg','rooms','Warm ambient lamp and boutique armchair in executive guest room',3,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(4,'En-Suite Marble Luxury Bathroom','gallery/gallery-2.jpg','/images/gallery/gallery-2.jpg','rooms','Spacious marble bathroom vanity with backlit mirror and premium bath amenities',4,1,'2026-11-13 06:09:57','2026-11-13 06:29:20',NULL),(5,'Sunset Terrace & Relaxation Lounge','gallery/gallery-3.jpg','/images/gallery/gallery-3.jpg','exterior','Outdoor evening relaxation terrace with golden hour skyline views',5,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(6,'Grand Heritage Archway Corridor','gallery/gallery-4.jpg','/images/gallery/gallery-4.jpg','lobby','Elegantly illuminated sandstone hallway with luxury arches and polished floors',6,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(7,'Deluxe Family Guest Bedroom','gallery/gallery-5.jpg','/images/gallery/gallery-5.jpg','rooms','Spacious family guest room with ambient lighting and plush furnishings',7,1,'2026-11-13 06:09:57','2026-11-13 06:50:06',NULL),(8,'Sandstone & Burgundy VIP Lounge','gallery/gallery-6.jpg','/images/gallery/gallery-6.jpg','rooms','Intimate seating corner in warm champagne sandstone and burgundy tones',8,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(9,'Deluxe King Sanctuary','rooms/deluxe.jpg','/images/rooms/deluxe.jpg','rooms','Deluxe bedroom featuring plush Italian bedding and warm golden illumination',9,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(10,'Executive Corporate Suite','rooms/executive.jpg','/images/rooms/executive.jpg','rooms','Executive suite with ergonomic work desk and warm ambient lamps',10,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(11,'Rose Palace Family Suite','rooms/family.jpg','/images/rooms/family.jpg','rooms','Spacious family accommodations with warm wood accents and comfortable seating',11,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(12,'Presidential Royal Suite','rooms/suite.jpg','/images/rooms/suite.jpg','rooms','Ultra-luxury suite bedroom with warm ambient glow and grand king bed',12,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `hotel_settings`;
;
;
CREATE TABLE `hotel_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `setting_type` enum('text','textarea','number','boolean','url') NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hotel_settings_setting_key_unique` (`setting_key`),
  KEY `hotel_settings_setting_key_index` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `hotel_settings` WRITE;
;
INSERT INTO `hotel_settings` VALUES (1,'hotel_name','Hotel Rose Palace','Hotel name','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(2,'hotel_tagline','Where Elegance Meets Comfort','Hotel tagline/slogan','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(3,'hotel_address','4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007','Hotel address','textarea','2026-11-12 03:41:45','2026-11-12 03:41:45'),(4,'hotel_phone_1','+91 70424 24242','Primary contact phone','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(5,'hotel_phone_2','+91 8071 515 210','Secondary contact phone','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(6,'hotel_email','info@hotelrosepalace.com','Hotel email address','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(7,'whatsapp_number','+91xxxxxxxxx','WhatsApp number for enquiries (update with actual number)','text','2026-11-12 03:41:45','2026-11-12 03:41:45'),(8,'google_maps_embed','','Google Maps embed code','textarea','2026-11-12 03:41:45','2026-11-12 03:41:45'),(9,'website_logo_url','/images/logo.png','Website logo URL','url','2026-11-12 03:41:45','2026-11-12 03:41:45'),(10,'privacy_policy','<p>Hotel Rose Palace respects your privacy...</p>','Privacy policy content','textarea','2026-11-12 03:41:45','2026-11-12 03:41:45'),(11,'terms_conditions','<p>Terms and conditions for booking...</p>','Terms and conditions content','textarea','2026-11-12 03:41:45','2026-11-12 03:41:45'),(12,'cancellation_policy','<p>Cancellation policy information...</p>','Cancellation policy content','textarea','2026-11-12 03:41:45','2026-11-12 03:41:45');
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `job_batches`;
;
;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
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
;
LOCK TABLES `job_batches` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `jobs`;
;
;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `jobs` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
;
;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `migrations` WRITE;
;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_02_000000_create_room_types_table',1),(5,'2024_01_03_000000_create_rooms_table',1),(6,'2024_01_04_000000_create_room_images_table',1),(7,'2024_01_05_000000_create_amenities_table',1),(8,'2024_01_06_000000_create_amenity_room_type_table',1),(9,'2024_01_07_000000_create_enquiries_table',1),(10,'2024_01_08_000000_create_gallery_images_table',1),(11,'2024_01_09_000000_create_hotel_settings_table',1),(12,'2024_01_10_000000_create_contact_messages_table',1),(13,'2026_11_13_000001_add_pms_fields_to_rooms_and_enquiries_tables',2),(15,'2026_11_13_000002_add_operational_schema_compatibility_columns',3),(16,'2026_11_13_095452_add_size_sqft_to_room_types_table',4),(17,'2026_11_13_101926_delete_extra_room_types',5),(18,'2026_11_13_102433_setup_15_rooms_101_to_115',6);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
;
;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `password_reset_tokens` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `room_images`;
;
;
CREATE TABLE `room_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_images_room_id_index` (`room_id`),
  CONSTRAINT room_images_room_id_foreign FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `room_images` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `room_types`;
;
;
CREATE TABLE `room_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `size_sqft` int(11) NOT NULL DEFAULT 0,
  `base_price` decimal(10,2) NOT NULL,
  `max_occupancy` int(11) NOT NULL,
  `max_adults` int(11) NOT NULL DEFAULT 2,
  `max_children` int(11) NOT NULL DEFAULT 2,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_types_name_unique` (`name`),
  UNIQUE KEY `room_types_slug_unique` (`slug`),
  KEY `room_types_slug_index` (`slug`),
  KEY `room_types_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `room_types` WRITE;
;
INSERT INTO `room_types` VALUES (1,'Deluxe Room','deluxe-room','Comfortable elegance with modern sandstone accents, plush bedding, and city views of VIP Road Surat.',0,1725.00,3,2,1,1,1,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(2,'Executive Room','executive-room','Tailored for corporate travelers and textile connoisseurs with high-speed Wi-Fi, ergonomic desk, and mini lounge.',0,2399.00,3,2,1,1,2,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(3,'Suite','luxury-suite','Spacious heritage living with separate living quarters, luxury bath amenities, and personalized hospitality.',0,3499.00,4,4,2,1,3,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(4,'Presidential Sky Suite','presidential-sky-suite','The pinnacle of luxury in Vesu Surat with panoramic skyline vistas, royal dining area, and dedicated butler service.',0,5499.00,6,4,2,1,4,'2026-11-13 06:09:57','2026-11-13 06:09:57',NULL);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `rooms`;
;
;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_type_id` bigint(20) unsigned NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `room_number` varchar(255) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `current_price` decimal(10,2) NOT NULL,
  `price_per_night` decimal(10,2) DEFAULT NULL,
  `max_guests` int(11) NOT NULL DEFAULT 2,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(50) DEFAULT 'available',
  `housekeeping_status` varchar(20) NOT NULL DEFAULT 'clean',
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  KEY `rooms_room_type_id_index` (`room_type_id`),
  KEY `rooms_room_number_index` (`room_number`),
  KEY `rooms_status_index` (`status`),
  KEY `rooms_is_available_index` (`is_available`),
  CONSTRAINT rooms_room_type_id_foreign FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `rooms` WRITE;
;
INSERT INTO `rooms` VALUES (1,1,'Deluxe','101',1,1725.00,1725.00,2,1,'available','clean','images/rooms/deluxe.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(2,1,'Deluxe','102',1,1725.00,1725.00,2,1,'available','dirty','images/rooms/deluxe.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(3,1,'Deluxe','103',1,1899.00,1899.00,3,1,'available','clean','images/rooms/deluxe.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(4,1,'Deluxe','104',1,1899.00,1899.00,2,0,'maintenance','maintenance','images/rooms/deluxe.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(5,1,'Deluxe','105',1,1899.00,1899.00,2,1,'available','clean','images/rooms/deluxe.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(6,2,'Executive','106',1,2399.00,2399.00,2,0,'occupied','clean','images/rooms/executive.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(7,2,'Executive','107',1,2399.00,2399.00,2,0,'occupied','clean','images/rooms/executive.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(8,2,'Executive','108',1,2599.00,2599.00,3,1,'available','dirty','images/rooms/executive.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(9,2,'Executive','109',1,2599.00,2599.00,2,1,'available','clean','images/rooms/executive.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(10,2,'Executive','110',1,2599.00,2599.00,2,1,'available','clean','images/rooms/executive.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(11,3,'Suite','111',1,3499.00,3499.00,4,0,'occupied','clean','images/rooms/suite.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(12,3,'Suite','112',1,3999.00,3999.00,4,1,'available','clean','images/rooms/family.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(13,3,'Suite','113',1,4499.00,4499.00,4,1,'reserved','clean','images/rooms/suite.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(14,3,'Suite','114',1,4999.00,4999.00,4,1,'available','clean','images/rooms/suite.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL),(15,4,'Suite','115',1,5499.00,5499.00,6,1,'available','clean','images/rooms/suite.jpg','2026-11-13 06:09:57','2026-11-13 06:09:57',NULL);
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sessions`;
;
;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `sessions` WRITE;
;
;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
;
;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager') NOT NULL DEFAULT 'manager',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
;
LOCK TABLES `users` WRITE;
;
INSERT INTO `users` VALUES (1,'Admin User','admin@hotelrosepalace.com',NULL,'$2y$12$WtGNRoDgYx/Me.yv3q3UQeaaWpNHbxPemV/Gm2zw/.WZhIBGWHwpS','admin',1,NULL,NULL,'2026-11-12 03:41:44','2026-11-12 03:41:44',NULL),(2,'Manager User','manager@hotelrosepalace.com',NULL,'$2y$12$kZeWCb6nDuhX9Dl28b4cZeNInQDr6gtsNQW6GtlIDjG4PbqUhpf5a','manager',1,NULL,NULL,'2026-11-12 03:41:45','2026-11-12 03:41:45',NULL),(7,'Admin User','admin@hotelrose.com',NULL,'$2y$12$JGbpwv1lC4EMl/FyZPjQKunmmSYUeiPTsUAcyzb4FHjTtnET7b3Ca','admin',1,NULL,NULL,'2026-11-13 07:08:34','2026-11-13 07:08:34',NULL),(8,'Manager User','manager@hotelrose.com',NULL,'$2y$12$KlddVHgL27k1MfWJjT/U8eqxvIFbRhS.rjuOKZ7GoAcS4HKfUpbnm','manager',1,NULL,NULL,'2026-11-13 07:08:34','2026-11-13 07:08:34',NULL);
;
UNLOCK TABLES;
;
;
;
;
;
;
;
;


SET FOREIGN_KEY_CHECKS=1;

-- ============================================================================
-- Deployment Complete
-- ============================================================================
-- Verify with: SELECT COUNT(*) FROM rooms;
-- Expected: 15 rooms
-- ============================================================================
