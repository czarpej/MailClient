-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 29 Gru 2018, 19:31
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ajax`
--
CREATE DATABASE IF NOT EXISTS `ajax`;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` text NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `author`, `message`) VALUES
(1, 'Daniel', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),
(2, 'John', 'Vivamus non enim ut sapien rhoncus efficitur.'),
(3, 'Stan', 'Vestibulum aliquet dolor ut est finibus tempus.'),
(4, 'Amanda', 'Vestibulum et quam tempor, dapibus nulla ac, imperdiet mauris.'),
(5, 'Emyly', 'Proin quis eros pharetra, luctus odio vitae, lacinia est.'),
(6, 'Mark', 'Mauris at urna facilisis enim hendrerit aliquam vel et turpis.'),
(7, 'Gregore', 'Aenean volutpat nibh sit amet tellus lobortis, eu efficitur est cursus.'),
(8, 'Sam', 'Maecenas accumsan felis in leo pulvinar viverra.'),
(9, 'Paul', 'Integer commodo justo eu neque aliquam vulputate.'),
(10, 'Emma', 'Nullam congue orci in rutrum pulvinar.'),
(11, 'Harry', 'Ut eget erat sagittis, malesuada nunc non, dictum tortor.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_data`
--

CREATE TABLE `login_data` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `login_data`
--

INSERT INTO `login_data` (`id`, `login`, `email`, `password`) VALUES
(1, 'michal', 'michal.czarnota.1998@gmail.com', '$2y$10$Z/kC3lXe5ZRxqCpAJqdK7emKFizOJBWxKp.IfLpaam6vdYfdNFa5.'),
(2, 'janek', 'janek@poczta.pl', '$2y$10$4QeU1YAHxgaw1J0co9JoVu/E8sy1Qvuoa3tN.j3tCytQiMY41YI.e'),
(3, 'franek', 'franek@poczta.pl', '$2y$10$0ULEEjFEqt7/UEi53WRWjeu14EzviZ4RcAJpMqgMCRkF1PoTuXTLy'),
(4, 'stachu', 'stachu@poczta.pl', '$2y$10$VUaa/df5L1fS5i60l9wyX.8hWbe1E8qc1ZOeOWBBPq5lblBTOolIW'),
(5, 'zbychu', 'zbychu@wp.pl', '$2y$10$Exqu21Bw5aUxzDKdevyPVeIMqdRwW22e7Mtqd6hrJ8yfkE67fKg4m'),
(6, 'admin', '', '$2y$10$ywsIk4rAod2TuqjF8Jz1HuEnPn2FtO8l.jUrNseoDEtlSUaUHkBby'),
(8, 'olek', 'olek@poczta.pl', '$2y$10$NeniUam68Q3peTM4A5b9x.pmqR/UfH73IZPhpB01e5IH5YsL5oF9W'),
(9, 'kuba', 'kuba@poczta.pl', '$2y$10$hgnIdyz9/YyOCRBw7a1n0.JXvgKgj07TBFGIxV2i.eyfK0VDRwqym'),
(10, 'karol', 'karol@poczta.pl', '$2y$10$JrmMbgVpBhWkWAYc5vJcMOc6edFR/ykFtIwyo20HOHk3Jsm35RHTu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `to_user` int(11) NOT NULL,
  `see` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `from_user`, `message`, `date`, `to_user`, `see`) VALUES
(3, 5, 'gril sie szykuje, janusz robi grilla!', '2018-09-10 15:25:19', 1, 1),
(5, 1, 'my first message to you janek', '2018-12-03 10:18:24', 2, 0),
(7, 1, 'no to zbychu, widzim sie u janusza!', '2018-12-12 09:26:28', 5, 0),
(8, 1, 'no, this is my traktor i sie odwal od niego stachu', '2018-12-05 19:44:38', 4, 0),
(9, 1, 'my too', '2018-12-05 21:36:43', 3, 0),
(10, 1, 'my too', '2018-12-04 11:23:37', 2, 0),
(11, 1, 'stachu, na spokojnie dogadamy siÄ™ we wtorek, jesli chodzi o ten traktor', '2018-12-04 13:22:26', 3, 0),
(12, 1, 'stasiu, na spokojnie', '2018-12-04 12:32:30', 4, 0),
(14, 1, 'spierdalaj z tym traktorem', '2018-12-08 14:26:39', 4, 0),
(17, 1, 'ok', '2018-12-05 15:41:31', 4, 0),
(18, 1, 'ok', '2018-12-11 08:31:24', 4, 0),
(19, 1, 'ok', '2018-12-11 13:38:29', 1, 1),
(20, 1, 'sam ciagnij gale', '2018-12-06 16:33:29', 1, 0),
(29, 6, 'This is control message. You can check below options.', '2018-12-11 07:32:22', 1, 0),
(30, 1, 'spierdalam z traktorem', '2018-12-13 18:09:14', 4, 0),
(31, 1, 'z twoim traktorem', '2018-12-13 18:20:51', 4, 0),
(32, 1, 'grill', '2018-12-13 18:22:23', 2, 0),
(33, 1, 'third message', '2018-12-13 18:23:42', 2, 0),
(34, 1, 'kiedy?', '2018-12-13 18:24:29', 5, 0),
(35, 1, 'kiedy?', '2018-12-13 18:24:49', 5, 0),
(36, 1, 'ciÄ…gne gaÅ‚e', '2018-12-13 18:27:59', 5, 0),
(37, 1, 'bedzie stek?', '2018-12-13 18:35:23', 2, 0),
(38, 1, 'message', '2018-12-13 18:36:59', 2, 0),
(39, 1, 'ok', '2018-12-13 18:37:53', 5, 0),
(40, 1, 'no to grill', '2018-12-14 10:09:44', 2, 0),
(41, 1, 'your message', '2018-12-14 10:11:57', 3, 0),
(42, 1, 'my answer', '2018-12-14 10:12:59', 3, 0),
(43, 1, 'my second answer', '2018-12-14 10:14:09', 3, 0),
(44, 1, 'my too message', '2018-12-14 13:49:34', 3, 0),
(45, 1, 'your traktor', '2018-12-14 13:49:50', 4, 0),
(46, 1, 'message', '2018-12-15 08:22:00', 2, 0),
(47, 1, 'message', '2018-12-15 08:22:26', 2, 0),
(48, 1, 'message', '2018-12-15 08:23:23', 3, 0),
(49, 1, 'fifth message', '2018-12-15 08:24:28', 2, 0),
(50, 1, 'message', '2018-12-15 08:27:01', 1, 1),
(51, 1, 'message', '2018-12-15 08:28:09', 3, 0),
(53, 1, 'odp', '2018-12-17 19:37:18', 1, 1),
(54, 1, 'opd bitch', '2018-12-17 19:46:32', 1, 1),
(55, 1, 'resp', '2018-12-17 19:47:42', 1, 1),
(56, 1, 'next resp', '2018-12-17 19:48:05', 1, 0),
(58, 1, 'next reps', '2018-12-17 19:55:47', 1, 1),
(60, 1, 'odp', '2018-12-17 19:57:04', 1, 1),
(62, 1, 'no', '2018-12-17 19:59:47', 1, 1),
(63, 1, 'ok', '2018-12-17 20:02:56', 1, 1),
(64, 1, 'odp', '2018-12-18 14:31:31', 1, 1),
(65, 1, 'next odp', '2018-12-18 14:32:10', 1, 1),
(67, 1, 'ok', '2018-12-18 21:06:46', 1, 0),
(68, 1, 'luÅºna guma man', '2018-12-18 21:07:05', 1, 0),
(69, 6, 'Hi!<br><br>Welcome in our page, where we can exchange and write messages to other users.', '2018-12-21 15:24:43', 9, 0),
(70, 6, 'This is control message. You can check below options.', '2018-12-21 15:24:43', 9, 0),
(71, 6, 'Hi!<br><br>Welcome in our page, where we can exchange and write messages to other users.', '2018-12-21 15:45:03', 10, 0),
(72, 6, 'This is control message. You can check below options.', '2018-12-21 15:45:03', 10, 0),
(73, 1, 'cos', '2018-12-29 19:29:05', 5, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'jatka123@wp.pl'),
(7, 'michal.czarnota.1998@gmail.com'),
(8, 'janusz.nikipierowicz@email.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `login_data`
--
ALTER TABLE `login_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT dla tabeli `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
