-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Des 2024 pada 10.38
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loket_com`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `location`, `organizer_name`, `event_type`, `dress_code`, `min_age`, `facilities`, `created_at`, `updated_at`, `event_image_path`) VALUES
(1, 'Concert: Taylor Swift Live', 'Konser spektakuler yang menampilkan Taylor Swift, salah satu artis paling berpengaruh di dunia musik, dengan rangkaian lagu hitsnya yang akan memukau penggemar dari berbagai generasi.\r\nMenampilkan berbagai lagu dari album terbaru hingga hits klasik seperti “Love Story,” “Shake It Off,” dan “All Too Well.” Konser ini menawarkan pengalaman visual dan audio yang luar biasa.', '2024-12-25', 'Jakarta', 'Alpha Events', 'Konser Pop', 'Kasual, bisa mengenakan merchandise Taylor Swift', 12, 'Parkir luas, makanan dan minuman, merchandise, area VIP', '2024-12-20 13:27:55', '2024-12-21 08:24:24', NULL),
(2, 'Rock Night: Local Stars', 'Malam penuh energi dengan pertunjukan band-band rock lokal yang akan menghibur penggemar musik rock dari berbagai penjuru kota.\r\nMenampilkan band-band indie dan lokal yang akan memainkan lagu-lagu rock klasik serta karya orisinal mereka. Event ini memberikan panggung bagi musisi lokal untuk tampil.', '2024-12-28', 'Bandung', 'Indie Rockers', 'Konser Rock Indie', 'Kasual, bisa mengenakan pakaian bergaya rock', 16, 'Area parkir, makanan dan minuman, merchandise, area untuk penggemar berdiskusi', '2024-12-20 13:27:55', '2024-12-21 08:26:01', NULL),
(3, 'Concert: Coldplay Tribute', 'Tribute night yang menghidupkan kembali lagu-lagu ikonik Coldplay, dengan penampilan yang setia pada gaya musik dan suasana konser mereka.\r\nSebuah konser tribute yang dibawakan oleh band tribute Coldplay yang akan menampilkan lagu-lagu hits seperti “Fix You,” “Yellow,” dan “Viva La Vida.”', '2024-12-30', 'Surabaya', 'Tribute Band', 'Tribute Concert', 'Kasual, warna-warna cerah (terinspirasi dari album-album Coldplay)', 12, 'Makanan dan minuman, merchandise Coldplay, area parkir', '2024-12-20 13:27:55', '2024-12-21 08:28:15', NULL),
(4, 'Music Fiesta: DJ Marshmello', 'Acara musik yang menghadirkan DJ Marshmello untuk memberikan pengalaman EDM yang luar biasa dengan efek visual dan lighting yang spektakuler.\r\nDJ Marshmello akan memainkan set EDM-nya yang penuh energi, diiringi dengan visual dan lighting yang memukau. Pengunjung akan merasakan suasana pesta yang meriah.', '2024-12-27', 'Yogyakarta', 'Electro Vibes', 'Konser EDM', 'Santai, bisa mengenakan pakaian pesta', 18, 'Area VIP, bar, makanan dan minuman, merchandise', '2024-12-20 13:27:55', '2024-12-21 08:30:50', NULL),
(5, 'Jazz Under the Stars', 'Konser jazz malam di luar ruangan yang menawarkan pengalaman santai dan intim sambil menikmati penampilan musisi jazz ternama di bawah langit malam.\r\nMenampilkan penampilan musisi jazz klasik dan kontemporer, acara ini menawarkan suasana yang romantis dan tenang. Cocok untuk dinikmati dengan pasangan atau teman-teman.', '2024-12-26', 'Semarang', 'Smooth Jazz Co.', 'Konser Jazz', 'Kasual Formal', 12, 'Makanan gourmet, minuman, tempat duduk outdoor, area parkir', '2024-12-20 13:27:55', '2024-12-21 08:31:38', NULL),
(6, 'Indie Fest 2024', 'Festival musik indie yang menampilkan band dan musisi indie terbaik, memberikan platform untuk musik yang lebih eksperimental dan beragam.\r\nSebuah festival musik dengan lineup yang berfokus pada musik indie lokal dan internasional. Berbagai genre akan diperkenalkan, mulai dari indie rock, indie pop, hingga folk.', '2024-12-29', 'Malang', 'Indie Music Indonesia', 'Festival Musikk Indie', 'Kasual dan nyaman', 12, 'Food trucks, area merchandise, panggung outdoor, parkir', '2024-12-20 13:27:55', '2024-12-21 08:32:19', NULL),
(7, 'Pop Festival: Ariana Grande Hits', 'Festival musik pop yang didedikasikan untuk lagu-lagu hits Ariana Grande, menampilkan pertunjukan tribute dengan sentuhan spektakuler.\r\nMenghadirkan berbagai penampilan tribute kepada Ariana Grande, dengan lagu-lagu seperti “Dangerous Woman,” “No Tears Left to Cry,” dan “Problem.”', '2024-12-31', 'Bali', 'Pop Mania', 'Festival Pop', 'Kasual, bisa mengenakan merchandise Ariana Grande', 12, 'Parkir, makanan dan minuman, area foto', '2024-12-20 13:27:55', '2024-12-21 08:33:03', NULL),
(8, 'Reggae Vibes', 'Konser reggae dengan atmosfer santai dan penuh semangat, menampilkan musik reggae klasik serta modern.\r\nMenampilkan band reggae lokal dan internasional, acara ini memberikan suasana tropis dengan musik yang menenangkan dan penuh irama.', '2024-12-24', 'Makassar', 'Reggae Nation', 'Konser Reggae', 'Santai, bisa mengenakan pakaian bertema tropis', 12, 'Makanan dan minuman, area parkir, merchandise', '2024-12-20 13:27:55', '2024-12-21 08:33:52', NULL),
(9, 'Classical Evening: Beethoven Night', 'Malam klasik yang menampilkan karya-karya Beethoven, memberikan pengalaman yang mendalam dan elegan dengan orkestra live.\r\nAcara ini menampilkan orkestra besar yang membawakan karya-karya legendaris dari Beethoven, seperti \"Symphony No. 5\" dan \"Moonlight Sonata.\"', '2024-12-23', 'Medan', 'Classical Society', 'Konser Klasik', 'Formal, bisa mengenakan gaun atau jas', 12, 'Tempat duduk premium, parkir VIP, makanan dan minuman elegan', '2024-12-20 13:27:55', '2024-12-21 08:34:29', NULL),
(10, 'Concert: Billie Eilish Exclusive', 'Konser eksklusif yang menampilkan Billie Eilish, menyajikan penampilan intim dengan lagu-lagu hit dan pengalaman visual yang unik.\r\nKonser ini menghadirkan Billie Eilish dengan penampilan yang lebih personal dan mendalam, dengan lagu-lagu dari album “When We All Fall Asleep, Where Do We Go?” serta “Happier Than Ever.”', '2024-12-22', 'Jakarta', 'Star Music', 'Konser Pop Alternative', 'Kasual dengan nuansa dark aesthetic', 16, 'Area VIP, bar, parkir, merchandise eksklusif', '2024-12-20 13:27:55', '2024-12-21 08:36:14', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_history`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_type` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `ticket_type`, `price`, `quantity_available`, `created_at`, `updated_at`) VALUES
(1, 1, 'presale', '1000000.00', 50, '2024-12-21 09:02:47', '2024-12-21 09:25:10'),
(2, 1, 'regular', '3000000.00', 300, '2024-12-21 09:02:47', '2024-12-21 09:25:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `ktp_number`, `date_of_birth`, `gender`, `role`, `created_at`, `updated_at`) VALUES
(1, '', 'lintangmunoh@gmail.com', '$2y$10$/1s0Y4fak0wshMbfuaRzyeq0Vprf6XrwWjYFx2Xm3SLLfNe.5vYPa', NULL, NULL, NULL, NULL, 'user', '2024-12-20 17:13:04', '2024-12-20 17:13:04'),
(2, 'admin', 'admin@gmail.com', 'admin', '9878', '89878', '1995-12-25', 'Laki-laki', 'admin', '2024-12-20 17:59:36', '2024-12-20 17:59:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indeks untuk tabel `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `purchase_history_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `purchase_history_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `purchase_history_ibfk_4` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`);

--
-- Ketidakleluasaan untuk tabel `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
