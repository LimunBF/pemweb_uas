-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 04:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kolet`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `organizer_name` varchar(150) DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `dress_code` varchar(255) NOT NULL,
  `min_age` int(100) NOT NULL,
  `facilities` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `location`, `organizer_name`, `event_type`, `dress_code`, `min_age`, `facilities`, `created_at`, `updated_at`, `event_image_path`) VALUES
(1, 'Concert: Taylor Swift Live', 'Konser spektakuler yang menampilkan Taylor Swift, salah satu artis paling berpengaruh di dunia musik, dengan rangkaian lagu hitsnya yang akan memukau penggemar dari berbagai generasi.\r\nMenampilkan berbagai lagu dari album terbaru hingga hits klasik seperti “Love Story,” “Shake It Off,” dan “All Too Well.” Konser ini menawarkan pengalaman visual dan audio yang luar biasa.', '2025-01-01', 'Jakarta', 'Alpha Events', 'Konser Pop', 'Kasual, bisa mengenakan merchandise Taylor Swift', 12, 'Parkir luas, makanan dan minuman, merchandise, area VIP', '2024-12-20 13:27:55', '2024-12-23 15:55:05', 'img/konser/Designer (1).jpeg'),
(2, 'Rock Night: Local Stars', 'Malam penuh energi dengan pertunjukan band-band rock lokal yang akan menghibur penggemar musik rock dari berbagai penjuru kota.\r\nMenampilkan band-band indie dan lokal yang akan memainkan lagu-lagu rock klasik serta karya orisinal mereka. Event ini memberikan panggung bagi musisi lokal untuk tampil.', '2024-12-28', 'Bandung', 'Indie Rockers', 'Konser Rock Indie', 'Kasual, bisa mengenakan pakaian bergaya rock', 16, 'Area parkir, makanan dan minuman, merchandise, area untuk penggemar berdiskusi', '2024-12-20 13:27:55', '2024-12-21 15:10:25', 'img/konser/Designer.jpeg'),
(3, 'Concert: Coldplay Tribute', 'Tribute night yang menghidupkan kembali lagu-lagu ikonik Coldplay, dengan penampilan yang setia pada gaya musik dan suasana konser mereka.\r\nSebuah konser tribute yang dibawakan oleh band tribute Coldplay yang akan menampilkan lagu-lagu hits seperti “Fix You,” “Yellow,” dan “Viva La Vida.”', '2025-02-11', 'Surabaya', 'Tribute Band', 'Tribute Concert', 'Kasual, warna-warna cerah (terinspirasi dari album-album Coldplay)', 12, 'Makanan dan minuman, merchandise Coldplay, area parkir', '2024-12-20 13:27:55', '2024-12-23 15:54:31', 'img/konser/Designer (2).jpeg'),
(4, 'Music Fiesta: DJ Marshmello', 'Acara musik yang menghadirkan DJ Marshmello untuk memberikan pengalaman EDM yang luar biasa dengan efek visual dan lighting yang spektakuler.\r\nDJ Marshmello akan memainkan set EDM-nya yang penuh energi, diiringi dengan visual dan lighting yang memukau. Pengunjung akan merasakan suasana pesta yang meriah.', '2025-02-01', 'Yogyakarta', 'Electro Vibes', 'Konser EDM', 'Santai, bisa mengenakan pakaian pesta', 18, 'Area VIP, bar, makanan dan minuman, merchandise', '2024-12-20 13:27:55', '2024-12-23 15:55:22', 'img/konser/Designer (3).jpeg'),
(5, 'Jazz Under the Stars', 'Konser jazz malam di luar ruangan yang menawarkan pengalaman santai dan intim sambil menikmati penampilan musisi jazz ternama di bawah langit malam.\r\nMenampilkan penampilan musisi jazz klasik dan kontemporer, acara ini menawarkan suasana yang romantis dan tenang. Cocok untuk dinikmati dengan pasangan atau teman-teman.', '2025-01-25', 'Semarang', 'Smooth Jazz Co.', 'Konser Jazz', 'Kasual Formal', 12, 'Makanan gourmet, minuman, tempat duduk outdoor, area parkir', '2024-12-20 13:27:55', '2024-12-23 15:54:39', 'img/konser/Designer (4).jpeg'),
(6, 'Indie Fest 2024', 'Festival musik indie yang menampilkan band dan musisi indie terbaik, memberikan platform untuk musik yang lebih eksperimental dan beragam.\r\nSebuah festival musik dengan lineup yang berfokus pada musik indie lokal dan internasional. Berbagai genre akan diperkenalkan, mulai dari indie rock, indie pop, hingga folk.', '2024-12-29', 'Malang', 'Indie Music Indonesia', 'Festival Musikk Indie', 'Kasual dan nyaman', 12, 'Food trucks, area merchandise, panggung outdoor, parkir', '2024-12-20 13:27:55', '2024-12-21 15:10:46', 'img/konser/Designer (5).jpeg'),
(7, 'Pop Festival: Ariana Grande Hits', 'Festival musik pop yang didedikasikan untuk lagu-lagu hits Ariana Grande, menampilkan pertunjukan tribute dengan sentuhan spektakuler.\r\nMenghadirkan berbagai penampilan tribute kepada Ariana Grande, dengan lagu-lagu seperti “Dangerous Woman,” “No Tears Left to Cry,” dan “Problem.”', '2024-12-31', 'Bali', 'Pop Mania', 'Festival Pop', 'Kasual, bisa mengenakan merchandise Ariana Grande', 12, 'Parkir, makanan dan minuman, area foto', '2024-12-20 13:27:55', '2024-12-21 15:10:50', 'img/konser/Designer (6).jpeg'),
(8, 'Reggae Vibes', 'Konser reggae dengan atmosfer santai dan penuh semangat, menampilkan musik reggae klasik serta modern.\r\nMenampilkan band reggae lokal dan internasional, acara ini memberikan suasana tropis dengan musik yang menenangkan dan penuh irama.', '2024-12-29', 'Makassar', 'Reggae Nation', 'Konser Reggae', 'Santai, bisa mengenakan pakaian bertema tropis', 12, 'Makanan dan minuman, area parkir, merchandise', '2024-12-20 13:27:55', '2024-12-23 15:55:36', 'img/konser/Designer (7).jpeg'),
(9, 'Classical Evening: Beethoven Night', 'Malam klasik yang menampilkan karya-karya Beethoven, memberikan pengalaman yang mendalam dan elegan dengan orkestra live.\r\nAcara ini menampilkan orkestra besar yang membawakan karya-karya legendaris dari Beethoven, seperti \"Symphony No. 5\" dan \"Moonlight Sonata.\"', '2025-03-29', 'Medan', 'Classical Society', 'Konser Klasik', 'Formal, bisa mengenakan gaun atau jas', 12, 'Tempat duduk premium, parkir VIP, makanan dan minuman elegan', '2024-12-20 13:27:55', '2024-12-23 15:54:54', 'img/konser/Designer (8).jpeg'),
(10, 'Concert: Billie Eilish Exclusive', 'Konser eksklusif yang menampilkan Billie Eilish, menyajikan penampilan intim dengan lagu-lagu hit dan pengalaman visual yang unik.\r\nKonser ini menghadirkan Billie Eilish dengan penampilan yang lebih personal dan mendalam, dengan lagu-lagu dari album “When We All Fall Asleep, Where Do We Go?” serta “Happier Than Ever.”', '2025-01-19', 'Jakarta', 'Star Music', 'Konser Pop Alternative', 'Kasual dengan nuansa dark aesthetic', 16, 'Area VIP, bar, parkir, merchandise eksklusif', '2024-12-20 13:27:55', '2024-12-23 15:54:49', 'img/konser/Designer (9).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history_nl`
--

CREATE TABLE `purchase_history_nl` (
  `purchase_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_type` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `ticket_type`, `price`, `quantity_available`, `created_at`, `updated_at`) VALUES
(1, 1, 'VIP', 3894477.04, 82, '2024-12-02 12:51:00', '2024-12-02 18:36:00'),
(2, 1, 'STUDENT', 1014221.05, 114, '2024-12-09 05:55:00', '2024-12-10 23:12:00'),
(3, 1, 'REGULAR', 4923758.08, 147, '2024-12-14 04:17:00', '2024-12-10 07:28:00'),
(4, 1, 'PRE-SALE', 4781101.88, 198, '2024-12-09 07:58:00', '2024-12-13 18:22:00'),
(5, 2, 'PRE-SALE', 1318851.16, 219, '2024-12-17 14:13:00', '2024-12-09 14:59:00'),
(6, 3, 'VIP', 3767311.44, 204, '2024-12-13 12:21:00', '2024-12-12 01:06:00'),
(7, 3, 'PRE-SALE', 4926432.17, 196, '2024-12-06 00:48:00', '2024-12-14 23:14:00'),
(8, 3, 'STUDENT', 2267462.97, 159, '2024-12-15 01:40:00', '2024-12-02 18:40:00'),
(9, 3, 'REGULAR', 2507567.34, 227, '2024-12-08 10:51:00', '2024-12-01 18:20:00'),
(10, 4, 'PRE-SALE', 2860324.30, 199, '2024-12-02 18:57:00', '2024-12-07 11:38:00'),
(11, 4, 'REGULAR', 4744436.36, 59, '2024-12-16 09:04:00', '2024-12-03 21:51:00'),
(12, 5, 'REGULAR', 4036485.39, 260, '2024-12-02 04:19:00', '2024-12-06 01:08:00'),
(13, 5, 'VIP', 2226538.02, 216, '2024-12-24 04:27:00', '2024-12-07 03:26:00'),
(14, 6, 'STUDENT', 2099394.37, 96, '2024-12-22 00:25:00', '2024-12-03 10:01:00'),
(15, 7, 'VIP', 4924113.86, 278, '2024-12-20 12:30:00', '2024-12-07 11:12:00'),
(16, 7, 'STUDENT', 1121341.13, 147, '2024-12-19 02:31:00', '2024-12-13 00:52:00'),
(17, 7, 'REGULAR', 3271883.32, 169, '2024-12-02 06:48:00', '2024-12-11 18:33:00'),
(18, 7, 'PRE-SALE', 3171185.67, 124, '2024-12-02 03:57:00', '2024-12-17 23:41:00'),
(19, 8, 'PRE-SALE', 4942802.99, 121, '2024-12-24 10:47:00', '2024-12-22 20:21:00'),
(20, 9, 'REGULAR', 3080427.84, 181, '2024-12-23 01:51:00', '2024-12-20 10:50:00'),
(21, 9, 'PRE-SALE', 3370753.91, 94, '2024-12-06 14:12:00', '2024-12-21 12:51:00'),
(22, 9, 'VIP', 2961235.77, 106, '2024-12-17 03:30:00', '2024-12-16 11:44:00'),
(23, 10, 'VIP', 3635125.56, 54, '2024-12-09 03:36:00', '2024-12-13 13:40:00'),
(24, 10, 'STUDENT', 1005140.18, 286, '2024-12-21 07:33:00', '2024-12-23 13:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `ktp_number` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `role` enum('user','admin','organizer') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `ktp_number`, `date_of_birth`, `gender`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', NULL, NULL, NULL, NULL, 'admin', '2024-12-23 15:58:04', '2024-12-23 15:58:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `purchase_history_nl`
--
ALTER TABLE `purchase_history_nl`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_history_nl`
--
ALTER TABLE `purchase_history_nl`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `purchase_history_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_history_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `purchase_history_ibfk_4` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`);

--
-- Constraints for table `purchase_history_nl`
--
ALTER TABLE `purchase_history_nl`
  ADD CONSTRAINT `purchase_history_nl_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `purchase_history_nl_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `purchase_history_nl_ibfk_3` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
