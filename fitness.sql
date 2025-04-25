-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 09:24 PM
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
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `abonamente`
--

CREATE TABLE `abonamente` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `descriere` text DEFAULT NULL,
  `pret` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `abonamente_utilizatori`
--

CREATE TABLE `abonamente_utilizatori` (
  `id` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `id_abonament` int(11) NOT NULL,
  `data_achizitie` datetime DEFAULT current_timestamp(),
  `data_expirare` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `cursuri`
--

CREATE TABLE `cursuri` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `descriere` text DEFAULT NULL,
  `durata_minute` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `programari`
--

CREATE TABLE `programari` (
  `id` int(11) NOT NULL,
  `id_curs` int(11) NOT NULL,
  `data_ora` datetime NOT NULL,
  `capacitate_maxima` int(11) DEFAULT 20,
  `data_dorita` datetime DEFAULT NULL,
  `id_utilizator` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(100) NOT NULL,
  `rol` enum('client','admin') NOT NULL DEFAULT 'client',
  `data_inregistrare` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Indexes for table `abonamente`
--
ALTER TABLE `abonamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `abonamente_utilizatori`
--
ALTER TABLE `abonamente_utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilizator` (`id_utilizator`),
  ADD KEY `id_abonament` (`id_abonament`);

--
-- Indexes for table `cursuri`
--
ALTER TABLE `cursuri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programari`
--
ALTER TABLE `programari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curs` (`id_curs`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abonamente`
--
ALTER TABLE `abonamente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `abonamente_utilizatori`
--
ALTER TABLE `abonamente_utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cursuri`
--
ALTER TABLE `cursuri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `programari`
--
ALTER TABLE `programari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abonamente_utilizatori`
--
ALTER TABLE `abonamente_utilizatori`
  ADD CONSTRAINT `abonamente_utilizatori_ibfk_1` FOREIGN KEY (`id_utilizator`) REFERENCES `utilizatori` (`id`),
  ADD CONSTRAINT `abonamente_utilizatori_ibfk_2` FOREIGN KEY (`id_abonament`) REFERENCES `abonamente` (`id`);

--
-- Constraints for table `programari`
--
ALTER TABLE `programari`
  ADD CONSTRAINT `programari_ibfk_1` FOREIGN KEY (`id_curs`) REFERENCES `cursuri` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
