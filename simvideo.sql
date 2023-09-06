-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: aug. 26, 2023 la 12:22 PM
-- Versiune server: 10.4.24-MariaDB
-- Versiune PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `simvideo`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `abonamente`
--

CREATE TABLE `abonamente` (
  `id` int(11) NOT NULL,
  `id_abonat` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `abonamente`
--

INSERT INTO `abonamente` (`id`, `id_abonat`, `id_creator`) VALUES
(3, 2, 1),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `aprecieri`
--

CREATE TABLE `aprecieri` (
  `id` int(11) NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `aprecieri`
--

INSERT INTO `aprecieri` (`id`, `id_utilizator`, `id_videoclip`, `id_creator`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 2);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `comentarii`
--

CREATE TABLE `comentarii` (
  `id` int(11) NOT NULL,
  `id_videoclip` int(11) NOT NULL,
  `id_creator` int(11) NOT NULL,
  `id_comentator` int(11) NOT NULL,
  `comentariu` text COLLATE utf8_romanian_ci NOT NULL,
  `data` varchar(50) COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `comentarii`
--

INSERT INTO `comentarii` (`id`, `id_videoclip`, `id_creator`, `id_comentator`, `comentariu`, `data`) VALUES
(1, 3, 2, 1, 'Acesta este comentariul videoclipului', '14-06-2023 19:28'),
(2, 3, 2, 1, 'Imi place foarte mult acest videoclip!', '26-08-2023 12:16');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `prenume` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `telefon` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `parola` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `imagine` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `descriere` text COLLATE utf8_romanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `prenume`, `email`, `telefon`, `parola`, `imagine`, `descriere`) VALUES
(1, 'Sperneac', 'Sergiu', 'sergiu.sperneac@yahoo.com', '0754719842', '$2y$10$I1yhzY/pYZO.YbJpFSvLW.f6bV2tu4PxAPQomORBsJtyc5iLAxhme', '', 'Proin vitae vestibulum ante. Phasellus vitae tincidunt nisl, ac egestas felis. Curabitur gravida dapibus lacus, accumsan placerat lorem consectetur et. Aenean euismod elit dui, ut consectetur arcu pretium in. In elit neque, mattis a elit porta, pulvinar ullamcorper risus. Nulla gravida erat leo, sit amet tempus metus placerat nec. Donec lacinia neque vitae placerat aliquam.'),
(2, 'Ionescu', 'George', 'george.ionescu@gmail.com', '07864562532', '$2y$10$PtVkK6TDz8zNWMq8WULphO2xAB6C1mcVzc/h6eZBI/mlpCU9qSyQ6', '6489ce8528640.png', 'Integer consectetur volutpat rhoncus. Aenean sit amet posuere nisi. Integer vel turpis odio. Sed tristique purus vitae efficitur cursus. Donec congue rhoncus orci ut laoreet. Quisque porttitor velit augue, vel condimentum sapien convallis at. Mauris interdum pretium nunc, at vulputate arcu lacinia et. Aliquam mattis arcu eget dolor euismod, et interdum ligula rutrum.');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `videoclipuri`
--

CREATE TABLE `videoclipuri` (
  `id` int(11) NOT NULL,
  `uniqid` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `titlu` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `video` varchar(250) COLLATE utf8_romanian_ci NOT NULL,
  `durata` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `thumbnail` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `descriere` text COLLATE utf8_romanian_ci NOT NULL,
  `data` varchar(50) COLLATE utf8_romanian_ci NOT NULL,
  `id_creator` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `vizualizari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

--
-- Eliminarea datelor din tabel `videoclipuri`
--

INSERT INTO `videoclipuri` (`id`, `uniqid`, `titlu`, `video`, `durata`, `thumbnail`, `descriere`, `data`, `id_creator`, `status`, `vizualizari`) VALUES
(1, '6486ecbcdfe9c', 'Videoclip pentru testul 1', 'video.mp4', '00:33', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nisl nulla, dignissim sed mauris quis, semper aliquet felis. Sed id lacinia felis, id volutpat ipsum. Maecenas interdum dignissim tortor, non blandit lacus ultricies ac. Nulla eleifend, nisl sit amet consectetur gravida, mauris velit rutrum odio, nec pretium tellus lacus at magna. Donec quis ornare diam.', '12-06-2023 13:00', 1, 1, 6),
(2, '6489b6511fd8d', 'Videoclip pentru testul 2', 'video.mp4', '00:33', '6489ccdceb16e.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis blandit nulla. Sed malesuada augue nec massa viverra, eget euismod diam facilisis. Integer euismod tempor ex, quis posuere ante elementum a. In at egestas neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer elementum mi est, sed posuere quam dictum quis.', '14-06-2023 15:45', 1, 1, 5),
(3, '6489ce1f382e6', 'Acesta este titlul unui videoclip', 'video.mp4', '', '6489ce5be2ed5.jpg', 'Integer consectetur volutpat rhoncus. Aenean sit amet posuere nisi. Integer vel turpis odio. Sed tristique purus vitae efficitur cursus. Donec congue rhoncus orci ut laoreet. Quisque porttitor velit augue, vel condimentum sapien convallis at. Mauris interdum pretium nunc, at vulputate arcu lacinia et. Aliquam mattis arcu eget dolor euismod, et interdum ligula rutrum.', '14-06-2023 17:26', 2, 1, 9);

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `abonamente`
--
ALTER TABLE `abonamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `aprecieri`
--
ALTER TABLE `aprecieri`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `comentarii`
--
ALTER TABLE `comentarii`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `videoclipuri`
--
ALTER TABLE `videoclipuri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `abonamente`
--
ALTER TABLE `abonamente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `aprecieri`
--
ALTER TABLE `aprecieri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `comentarii`
--
ALTER TABLE `comentarii`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pentru tabele `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pentru tabele `videoclipuri`
--
ALTER TABLE `videoclipuri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
