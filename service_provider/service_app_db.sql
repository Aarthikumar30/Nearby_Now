-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 07:38 AM
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
-- Database: `service_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `b_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider_id` varchar(50) DEFAULT NULL,
  `service_id` varchar(50) DEFAULT NULL,
  `booking_id` varchar(50) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time DEFAULT NULL,
  `status` enum('waiting','confirmed','pending','completed','cancelled') DEFAULT 'waiting',
  `cancel_reason` text DEFAULT NULL,
  `cancelled_by` enum('user','provider','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`b_id`, `user_id`, `provider_id`, `service_id`, `booking_id`, `user_name`, `address`, `contact`, `booking_date`, `booking_time`, `status`, `cancel_reason`, `cancelled_by`, `created_at`) VALUES
(5, 3, 'PROV3770', 'SVC005', NULL, 'aarthi', 'miet', '9368106548', '2025-04-22', '23:21:00', 'cancelled', NULL, NULL, '2025-04-08 13:52:02'),
(6, 3, 'PROV1337', 'SVC006', 'BOOK-1744122723-9026', 'janani', 'tolgate', '7392740276', '2025-04-17', '22:25:00', 'completed', NULL, NULL, '2025-04-08 13:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` varchar(10) DEFAULT NULL,
  `provider_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `experience` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `status` enum('waiting','approved','rejected') DEFAULT 'waiting',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `service_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `user_id`, `provider_id`, `provider_name`, `category`, `service_type`, `description`, `experience`, `price`, `state`, `district`, `location`, `contact`, `status`, `created_at`, `email`, `service_id`) VALUES
(1, 4, 'PROV2834', 'John', 'cleaning', 'House Cleaning', 'Expert in professional house cleaning, ensuring a spotless and hygienic home with efficient and reliable service. Skilled in deep cleaning, dusting, mopping, and sanitization. Uses eco-friendly products for a safe and healthy environment. Offers flexible scheduling and customized cleaning plans to meet client needs.\r\n\r\nNote : The price mentioned in the profile is not fixed. It may vary (increase or decrease) as per the work and location.', 3, 500, 'Tamilnadu ', 'Tiruchirapalli ', 'TVS Tolgate', '1234567889', 'approved', '2025-03-17 06:41:12', '', 'SVC003'),
(2, 2, 'PROV1337', 'Boomika', 'gardening', 'Lawn care & Maintenance', 'Experienced in professional lawn care and maintenance, ensuring a healthy and well-manicured outdoor space. Skilled in mowing, trimming, watering, fertilizing, and weed control. Uses eco-friendly techniques to enhance lawn health and appearance. Offers seasonal care and customized maintenance plans for long-lasting greenery.\r\n\r\nKindly Note : The Price mentioned in the Profile is not fixed. It may vary (Increase Or Decrease) as per the Work and Location.', 5, 400, 'TAMIL NADU', 'Tiruchirapalli ', 'MIET', '8204619356', 'approved', '2025-03-19 09:20:21', 'p1@gmail.com', 'SVC006'),
(3, 6, 'PROV3770', 'Ram', 'painting', 'Interior and Exterior Painting', 'Professional interior and exterior painting services to enhance and protect your home, inside and out. From refreshing walls, ceilings, and trims indoors to weather-resistant coatings for exterior walls, gates, and fences—we ensure a flawless finish with high-quality paints and expert workmanship. Whether you\'re going for a bold new look or a clean refresh, we\'ve got you covered.', 6, 200, 'TAMIL NADU', 'Tiruchirapalli ', 'TVS Tolgate', '9368106548', 'approved', '2025-04-08 07:04:03', '', 'SVC005');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_id` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_id`, `category`, `created_at`) VALUES
(1, 'SVC001', 'Pest Control', '2025-03-18 05:23:32'),
(2, 'SVC002', 'Electrician', '2025-03-18 05:23:32'),
(3, 'SVC003', 'Cleaning', '2025-03-18 05:23:32'),
(4, 'SVC004', 'Plumbing', '2025-03-18 05:23:32'),
(5, 'SVC005', 'Painting', '2025-03-18 05:23:32'),
(6, 'SVC006', 'Gardening', '2025-03-18 05:23:32'),
(7, 'SVC007', 'Others', '2025-03-18 05:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('admin','user','provider') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `username`, `password`, `level`) VALUES
(1, 'admin', 'admin@gmail.com', '1234567890', 'admin', 'admin', '$2y$10$tpXp5SdTS3E8mCYfI4QAs.PWChdWJnag/cNqNhYQyAMHL6zyiGgiG', 1),
(2, 'provider1', 'p1@gmail.com', '5678890123', 'provider', 'p1', '$2y$10$x8yHNShyQe9X4sSniLlz7ukEM6TYO.QtS/VIL6ziFui6kv9F7otp6', 2),
(3, 'user1', 'u1@gmail.com', '5678012312', 'user', 'u1', '$2y$10$EkImusdtb1HYK6YdgEnrMum8jYuYfTiK4IDs3u6W4XV1kdNvPP0v2', 3),
(4, 'provider2', 'p2@gmail.com', '5678936802', 'provider', 'p2', '$2y$10$ZttGffzolPORZSiB8ieZP.npsySA1HbqzJHLrnXmZL5ButoVzvGHO', 2),
(5, 'user2', 'u2@gmail.com', '7597140482', 'user', 'u2', '$2y$10$TyG7iqK.vev3Wc09TuZxM.1XuVZWMh22oZ09HkPz.Q5Exc5ZJ0NVm', 3),
(6, 'provider3', 'p3@gmail.com', '5678890123', 'provider', 'p3', '$2y$10$JcpVScYBiPGBPNHb9iPNiOLTGNQ4xPgPiKwz5CIm95NkksfYmoxPe', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`b_id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_id` (`provider_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_service` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_id` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`provider_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `fk_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `providers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
