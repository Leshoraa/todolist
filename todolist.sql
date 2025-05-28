-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Feb 2025 pada 08.10
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist_affan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `tugasid` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `priority` enum('1','2','3') NOT NULL,
  `due_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`tugasid`, `task`, `priority`, `due_date`, `status`, `userid`) VALUES
(49, 'mahall', '2', '2222-02-22', 0, 6),
(67, 'Olahraga', '2', '2025-02-18', 0, 1),
(68, 'Sarapan', '3', '2025-02-18', 1, 1),
(69, 'Berkebun', '1', '2025-02-18', 0, 1),
(70, 'Menata baju', '2', '2025-02-18', 1, 1),
(71, 'mencuci baju', '3', '2025-02-18', 0, 1),
(72, 'Menyiram tanaman', '1', '2025-02-18', 1, 1),
(73, 'Belanja', '3', '2025-02-18', 0, 1),
(74, 'Membuat kue', '2', '2025-02-18', 0, 1),
(75, 'Resepsinan', '3', '2025-02-18', 0, 1),
(76, 'Menata perabotan rumah', '1', '2025-02-18', 0, 1),
(77, 'sembarang', '2', '2025-02-18', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`) VALUES
(1, 'Affan', '0cc175b9c0f1b6a831c399e269772661', 'affan@gmail.com', 'Rendra Muktia Affan', 'Sleman, Mlati'),
(2, 'Leshoraa', '0cc175b9c0f1b6a831c399e269772661', 'pzaid3713@gmail.com', 'a', 'a'),
(3, 'Rashaa', '0cc175b9c0f1b6a831c399e269772661', 'a@gmail.com', 'Rashaa Y', 'Jogjakarta'),
(4, 'Rashaa', '0cc175b9c0f1b6a831c399e269772661', 'a@gmail.com', 'Rashaa Y', 'Jogjakarta'),
(5, 'Rashaa', '0cc175b9c0f1b6a831c399e269772661', 'a@gmail.com', 'Rashaa Y', 'Jogjakarta'),
(6, 'siwiw', 'f1290186a5d0b1ceab27f4e77c0c5d68', 'a@gmail.com', 'Rendra Muktia Affan', 'Jogjakarta'),
(7, 'Leshoraa', '0cc175b9c0f1b6a831c399e269772661', 'a@gmail.com', 'Affan', 'Sleman, Mlati'),
(8, 'Rendra', '0cc175b9c0f1b6a831c399e269772661', 'a@gmail.com', 'a', 'a');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`tugasid`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `tugasid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD CONSTRAINT `tugas_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
