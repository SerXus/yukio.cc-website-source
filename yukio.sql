-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 03. Jul 2022 um 16:58
-- Server-Version: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- PHP-Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `yukio`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `creator_code`
--

CREATE TABLE `creator_code` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `used` int(1) NOT NULL DEFAULT 0,
  `owed` varchar(255) NOT NULL,
  `last_payout` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `creator_payouts`
--

CREATE TABLE `creator_payouts` (
  `user_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `referrer_id` varchar(255) NOT NULL,
  `access` int(1) NOT NULL DEFAULT 0,
  `lite_access` int(1) NOT NULL DEFAULT 0,
  `clicker_access` int(1) NOT NULL DEFAULT 0,
  `rank` int(1) NOT NULL DEFAULT 0,
  `locked` int(11) NOT NULL DEFAULT 1,
  `discord_id` varchar(255) DEFAULT NULL,
  `hwid` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `hwid_delay` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `creator_code`
--
ALTER TABLE `creator_code`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `creator_code`
--
ALTER TABLE `creator_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
