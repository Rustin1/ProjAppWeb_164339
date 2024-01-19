-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Sty 2024, 11:47
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `164339_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `nazwa` tinytext NOT NULL,
  `pageContent` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `page_list`
--

INSERT INTO `page_list` (`id`, `nazwa`, `pageContent`, `status`) VALUES
(1, 'Strona Główna', '<div style= \"text-align:center;font-size:20px\"> Cześć, jestem Kuba interesuje się muzyką i chciałbym się podzielić z tobą moją pasją </div>\r\n	<img style= \"img-align:center\" src=\"img/gitara_yamaha.jpg\" width=\"1800\" height=\"600\"/>\r\n	', 1),
(2, 'Kontakt', '\r\n	<div class=\"contact-form\">\r\n		<h2>Kontakt</h2>\r\n		<p>Skontaktuj się ze mną, wypełniając poniższy formularz:</p>\r\n		<form action=\"mailto:mryee321@gmail.com\" method=\"post\" enctype=\"text/plain\">\r\n			Imię:<br><input type=\"text\" name=\"imie\"><br>\r\n			Email:<br><input type=\"email\" name=\"email\"><br>\r\n			Wiadomość:<br><textarea name=\"wiadomosc\" rows=\"4\" cols=\"50\"></textarea><br>\r\n			<input type=\"submit\" value=\"Wyślij\">', 1),
(3, 'Podstawy Muzyki', '\r\n	<h1> Podstawy gry na instrumencie</h1>\r\n	<p1> Teoria Muzyki </p1>\r\n	<div style= \"text-align:left;font-size:20px\"> Ogólne zasady i zagadnienia związane z muzyką wyrażone w sposób czysto teoretyczny. W skład teorii muzyki wchodzi m.in. notacja muzyczna (zapis muzyczny), elementy dzieła muzycznego – skróty i oznaczenia, praktyka wykonawcza, harmonia, kontrapunkt.\r\n	</div>\r\n	<br>\r\n	<p1> Jak grać na gitarze </p1>\r\n	<div style= \"text-align:left;font-size:20px\"> Na gitarze gra się palcami (opuszkami i paznokciami albo samymi opuszkami) lub kostką. Kostka jest przeznaczona głównie do gry akordami na gitarze z metalowymi strunami (akustycznej, elektrycznej). Istnieją również tzw. „pazurki” zrobione z metalu lub tworzywa sztucznego, które nakłada się na palce. Możliwe jest granie jednocześnie kostką i palcami (technika hybrydowa). Rozróżnia się strunyi progi i używając numeracji progowej (liczbowej) oraz strunowej (nazewnictwo literowej) gramy naciskając odpowiedni prógi strunę, grając pojedynczymi strunami (tabulatura) lub wieloma (akordy).\r\n	</div>\r\n	<p>Budowa Gitary</p>\r\n	<img style= \"img-align:left-side\" src=\"img/gitara1.jpg\" width=\"400\" height=\"500\"/>', 1),
(4, 'Instrumenty', '\r\n	<h1> Moje instrumenty</h1>\r\n	<p style= text-align-left-side>  Cort Katana KX100 i Everplay  AP-400 </p>\r\n	<img style= \"img-align:left-side\" src=\"img/Cort.png\"/>\r\n	<img style= \"img-align:center\" src=\"img/ever.png\" width=\"241\" height=\"644\"/>\r\n	<img style= \"img-align:right-side\" src=\"img/nuty.png\" width=\"1280\" height=\"620\"/>\r\n	', 1),
(5, 'Tabulatury', '\r\n	<h1>Łatwe tabulatury</h1>\r\n	<div style= \"text-align:left-side;font-size:20px\"> Z popielnika na wojtusia </div>\r\n	<img style= \"img-align:left-side\" src=\"img/wojtus.png\" width=\"780\" height=\"122\"/>\r\n	<div style= \"text-align:right-side;font-size:20px\"> Queen- Don\'t stop me now </div>\r\n	<img style= \"img-align:right-side\" src=\"img/queen.png\" width=\"780\" height=\"600\"/>\r\n	<div style= \"text-align:left-side;font-size:20px\"> Priscilla - Wilcza zamieć </div>\r\n	<img style= \"img-align:left-side\" src=\"img/wilk.png\" width=\"780\" height=\"367\"/>', 1),
(6, 'Akordy', '\n	<h1>Akordy oraz łatwa piosenka dla początkujących</h1>\n	<img style= \"img-align:left-side\" src=\"img/akordy.png\" width=\"500\" height=\"750\"/>\n	<img style= \"img-align:right-side\" src=\"img/piosenka.png\" width=\"500\" height=\"750\"/>\n	<img style= \"img-align:right-side\" src=\"img/sam.jpg\" width=\"750\" height=\"750\"/>', 1),
(7, 'Filmy', '<h1>Video</h1>\r\n<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/LRU3umrAyGs\" frameborder=\"0\" allowfullscreen></iframe>\r\n\r\n<div style= \"text-align:left-side;font-size:20px\"> Podstawy Gitary </div>\r\n\r\n<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/eA8gTqFrWZ8\" frameborder=\"0\" allowfullscreen></iframe>\r\n\r\n<div style= \"text-align:left-side;font-size:20px\"> Podstawy Muzyki </div>\r\n\r\n<iframe width=\"800\" height=\"450\" src=\"https://www.youtube.com/embed/0LmcGHywF50\" frameborder=\"0\" allowfullscreen></iframe>\r\n\r\n<div style= \"text-align:left-side;font-size:20px\"> Jak zagrać AC/DC Thunderstuck </div>', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
