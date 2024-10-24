-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Okt 2024 pada 15.30
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
-- Database: `spk_paket`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('kepala','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$vKlD7o2zW7D0NyeRZ9gIOuq/H5cD/hjZgmjZ20.8.yRE9FHaJKqkq', 'admin'),
(2, 'kepala', '$2y$10$R3I5nYY7phOmxciQi7DjOOp55VVbKJ3y33XyoWEI1PyWYRuetzCfS', 'kepala'),
(3, 'kepala', '$2y$10$K09gqwiri9wMsC2sjDG21u18.7zPKZ/Ib9i5ML7Ua1xDXvDZBpQzK', 'kepala'),
(4, 'kepala', '$2y$10$gNba/d5Sf10WQPUXHZL3pePbsGsRn7t0mjo6s0R8M5qE/4qKM3VgS', 'kepala');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `konsep_gedung` enum('Indoor','Outdoor') NOT NULL,
  `harga_sewa` int(11) NOT NULL,
  `fasilitas` int(11) NOT NULL,
  `kapasitas_tamu` int(11) NOT NULL,
  `kapasitas_parkir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `gambar`, `alamat`, `latitude`, `longitude`, `konsep_gedung`, `harga_sewa`, `fasilitas`, `kapasitas_tamu`, `kapasitas_parkir`) VALUES
(561, 'Hotel Cahaya Bapa', '2018-10-11.jpg', '-', '-10.17352917618124', '123.5984548109566', 'Indoor', 57500, 8, 1500, 150),
(562, 'A2', '2018-10-11_1.jpg', '-', '-9.647136584722023', '124.22804882368297', 'Indoor', 57500, 8, 700, 50),
(563, 'A3', '2018-10-11_2.jpg', '-', '-9.647136584722023', '124.60548288624653', 'Indoor', 50000, 11, 1300, 125),
(564, 'A4', '2018-10-11_3.jpg', '-', '-10.013223249281467', '124.22804882368297', 'Indoor', 75000, 11, 1300, 125),
(565, 'A5', '2018-10-11_4.jpg', '-', '-9.865149346683376', '124.22804882368297', 'Indoor', 110000, 11, 1300, 125),
(566, 'A6', '2018-10-11_5.jpg', '-', '-10.013223249281467', '124.18302099829398', 'Indoor', 60000, 13, 1500, 50),
(567, 'A7', '2018-10-11_6.jpg', '-', '-10.013223249281467', '124.60548288624653', 'Indoor', 75000, 13, 1500, 50),
(568, 'A8', '2018-10-11_7.jpg', '-', '-9.647136584722023', '124.18302099829398', 'Indoor', 110000, 13, 1500, 50),
(569, 'A9', '2018-10-11_8.jpg', '-', '-9.647136584722023', '124.22804882368297', 'Indoor', 150000, 12, 300, 200),
(570, 'A10', '2018-10-11_9.jpg', '-', '-9.647136584722023', '124.22804882368297', 'Indoor', 183500, 15, 300, 200),
(571, 'A11', '2018-10-11_10.jpg', '-', '-9.647136584722023', '124.18302099829398', 'Indoor', 217000, 16, 300, 200),
(572, 'A12', '2018-10-11_11.jpg', '-', '-9.566116506971282', '124.41281113776452', 'Indoor', 60000, 7, 1000, 125),
(573, 'A13', '2018-10-11_12.jpg', '-', '-9.598928201301783', '124.22804882368297', 'Indoor', 70000, 7, 1000, 125),
(574, 'A14', '2018-10-11_13.jpg', '-', '-9.598928201301783', '124.30736676601288', 'Indoor', 80000, 7, 1000, 125),
(575, 'A15', '2018-10-11_14.jpg', '-', '-10.013223249281467', '124.60548288624653', 'Indoor', 95000, 8, 1000, 125);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_akhir`
--

CREATE TABLE `hasil_akhir` (
  `id_hasil` int(11) NOT NULL,
  `f_id_alternatif` int(11) NOT NULL,
  `preferensi_akhir` decimal(15,13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kec_alt_kriteria`
--

CREATE TABLE `kec_alt_kriteria` (
  `id_alt_kriteria` int(11) NOT NULL,
  `f_id_alternatif` int(11) NOT NULL,
  `f_id_kriteria` char(3) NOT NULL,
  `f_id_sub_kriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kec_alt_kriteria`
--

INSERT INTO `kec_alt_kriteria` (`id_alt_kriteria`, `f_id_alternatif`, `f_id_kriteria`, `f_id_sub_kriteria`) VALUES
(13540, 561, 'C1', 34),
(13541, 561, 'C2', 38),
(13542, 561, 'C3', 41),
(13543, 561, 'C4', 46),
(13544, 562, 'C1', 34),
(13545, 562, 'C2', 38),
(13546, 562, 'C3', 43),
(13547, 562, 'C4', 50),
(13548, 563, 'C1', 34),
(13549, 563, 'C2', 37),
(13550, 563, 'C3', 42),
(13551, 563, 'C4', 47),
(13552, 564, 'C1', 34),
(13553, 564, 'C2', 37),
(13554, 564, 'C3', 42),
(13555, 564, 'C4', 47),
(13556, 565, 'C1', 33),
(13557, 565, 'C2', 37),
(13558, 565, 'C3', 42),
(13559, 565, 'C4', 47),
(13560, 566, 'C1', 34),
(13561, 566, 'C2', 36),
(13562, 566, 'C3', 41),
(13563, 566, 'C4', 50),
(13564, 567, 'C1', 34),
(13565, 567, 'C2', 36),
(13566, 567, 'C3', 41),
(13567, 567, 'C4', 50),
(13568, 568, 'C1', 33),
(13569, 568, 'C2', 36),
(13570, 568, 'C3', 41),
(13571, 568, 'C4', 50),
(13572, 569, 'C1', 31),
(13573, 569, 'C2', 37),
(13574, 569, 'C3', 45),
(13575, 569, 'C4', 46),
(13576, 570, 'C1', 31),
(13577, 570, 'C2', 36),
(13578, 570, 'C3', 45),
(13579, 570, 'C4', 46),
(13580, 571, 'C1', 31),
(13581, 571, 'C2', 36),
(13582, 571, 'C3', 45),
(13583, 571, 'C4', 46),
(13584, 572, 'C1', 34),
(13585, 572, 'C2', 38),
(13586, 572, 'C3', 42),
(13587, 572, 'C4', 47),
(13588, 573, 'C1', 34),
(13589, 573, 'C2', 38),
(13590, 573, 'C3', 42),
(13591, 573, 'C4', 47),
(13592, 574, 'C1', 33),
(13593, 574, 'C2', 38),
(13594, 574, 'C3', 42),
(13595, 574, 'C4', 47),
(13596, 575, 'C1', 33),
(13597, 575, 'C2', 38),
(13598, 575, 'C3', 42),
(13599, 575, 'C4', 47);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` char(3) NOT NULL,
  `nama_kriteria` varchar(255) NOT NULL,
  `jenis_kriteria` enum('Cost','Benefit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `jenis_kriteria`) VALUES
('C1', 'Harga Sewa', 'Cost'),
('C2', 'Fasilitas', 'Benefit'),
('C3', 'Kapasitas Tamu', 'Benefit'),
('C4', 'Kapasitas Parkir', 'Benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(11) NOT NULL,
  `nama_sub_kriteria` varchar(255) NOT NULL,
  `bobot_sub_kriteria` int(11) NOT NULL,
  `f_id_kriteria` char(3) NOT NULL,
  `spesifikasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama_sub_kriteria`, `bobot_sub_kriteria`, `f_id_kriteria`, `spesifikasi`) VALUES
(31, 'Sangat Mahal', 5, 'C1', '> Rp. 148.000'),
(32, 'Mahal', 4, 'C1', 'Rp. 112.000 < biaya ≤ Rp. 148.000'),
(33, 'Sedang', 3, 'C1', 'Rp. 76.000 < biaya ≤ Rp. 112.000'),
(34, 'Murah', 2, 'C1', 'Rp. 40.000 < biaya ≤ Rp. 76.000'),
(35, 'Sangat Murah', 1, 'C1', '≤ Rp. 40.000'),
(36, 'Sangat Lengkap', 5, 'C2', '> 12 fasilitas'),
(37, 'Lengkap', 4, 'C2', '10 – 12 fasilitas'),
(38, 'Cukup Lengkap', 3, 'C2', '7 – 9 fasilitas '),
(39, 'Kurang Lengkap', 2, 'C2', '4 – 6 fasilitas'),
(40, 'Tidak Lengkap', 1, 'C2', '≤ 3 fasilitas'),
(41, 'Sangat Banyak', 5, 'C3', '> 1323 orang'),
(42, 'Banyak', 4, 'C3', '983 – 1323 orang'),
(43, 'Sedang', 3, 'C3', '642 – 982 orang'),
(44, 'Sedikit', 2, 'C3', '301 – 641 orang'),
(45, 'Sangat Sedikit', 1, 'C3', '≤ 300 orang'),
(46, 'Sangat Banyak', 5, 'C4', '> 143 mobil dan motor'),
(47, 'Banyak', 4, 'C4', '113 – 143 mobil dan motor'),
(48, 'Sedang', 3, 'C4', '82 – 112 mobil dan motor'),
(49, 'Sedikit', 2, 'C4', '51 – 81 mobil dan motor'),
(50, 'Sangat Sedikit', 1, 'C4', '≤ 50 mobil dan motor');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `f_id_alternatif` (`f_id_alternatif`);

--
-- Indeks untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  ADD PRIMARY KEY (`id_alt_kriteria`),
  ADD KEY `f_id_alternatif` (`f_id_alternatif`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=576;

--
-- AUTO_INCREMENT untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  MODIFY `id_alt_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13600;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD CONSTRAINT `hasil_akhir_ibfk_1` FOREIGN KEY (`f_id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kec_alt_kriteria`
--
ALTER TABLE `kec_alt_kriteria`
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_3` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_4` FOREIGN KEY (`f_id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kec_alt_kriteria_ibfk_5` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
