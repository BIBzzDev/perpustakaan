-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 09 Feb 2025 pada 19.04
-- Versi server: 5.7.34
-- Versi PHP: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xiirpl4_labib_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_buku`
--

CREATE TABLE `labib_buku` (
  `bukuid` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahunterbit` int(11) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `bukupdf` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_buku`
--

INSERT INTO `labib_buku` (`bukuid`, `judul`, `penulis`, `penerbit`, `tahunterbit`, `cover`, `bukupdf`) VALUES
(9, 'Belajar Python Dasar ', 'Muhammad Labib ', 'Muhammad Labib ', 2020, '1739115013_1737382426_belajar_p_20250120_205537_1.png', '1739115013_1737382426_belajar_python_dasar.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_kategoribuku`
--

CREATE TABLE `labib_kategoribuku` (
  `kategoriid` int(11) NOT NULL,
  `namakategori` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_kategoribuku`
--

INSERT INTO `labib_kategoribuku` (`kategoriid`, `namakategori`) VALUES
(1, 'fiksi'),
(2, 'pembelajaran ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_kategoribuku_relasi`
--

CREATE TABLE `labib_kategoribuku_relasi` (
  `kategori_bukuid` int(11) NOT NULL,
  `bukuid` int(11) DEFAULT NULL,
  `kategoriid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_kategoribuku_relasi`
--

INSERT INTO `labib_kategoribuku_relasi` (`kategori_bukuid`, `bukuid`, `kategoriid`) VALUES
(2, 1, 1),
(3, 2, 1),
(4, 9, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_koleksipribadi`
--

CREATE TABLE `labib_koleksipribadi` (
  `koleksiid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `bukuid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_koleksipribadi`
--

INSERT INTO `labib_koleksipribadi` (`koleksiid`, `userid`, `bukuid`) VALUES
(2, 5, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_peminjaman`
--

CREATE TABLE `labib_peminjaman` (
  `peminjamanid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `bukuid` int(11) DEFAULT NULL,
  `tanggalpeminjaman` date NOT NULL,
  `tanggalpengembalian` date DEFAULT NULL,
  `statuspengembalian` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_peminjaman`
--

INSERT INTO `labib_peminjaman` (`peminjamanid`, `userid`, `bukuid`, `tanggalpeminjaman`, `tanggalpengembalian`, `statuspengembalian`) VALUES
(16, 5, 9, '2025-02-09', NULL, 'belum dikembalikan'),
(15, 5, 9, '2025-02-09', NULL, 'belum dikembalikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_ulasanbuku`
--

CREATE TABLE `labib_ulasanbuku` (
  `ulasanid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `bukuid` int(11) DEFAULT NULL,
  `ulasan` text,
  `rating` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_ulasanbuku`
--

INSERT INTO `labib_ulasanbuku` (`ulasanid`, `userid`, `bukuid`, `ulasan`, `rating`, `tanggal`) VALUES
(9, 5, 9, 'mantapp', 5, '2025-02-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `labib_user`
--

CREATE TABLE `labib_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text,
  `pp` varchar(255) DEFAULT NULL,
  `level` enum('admin','petugas','peminjam') NOT NULL DEFAULT 'peminjam'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `labib_user`
--

INSERT INTO `labib_user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `pp`, `level`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'Administrator', 'Alamat Admin', 'default.jpg', 'admin'),
(5, 'BIBzz', 'labib', 'labib@gmail.com', 'Muhammad Labib ', 'Cirebon', 'generated-image-0.png', 'peminjam'),
(8, 'petugas ', 'petugas', 'petugas@gmail.com', 'petugas', 'Cirebon', '', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `labib_buku`
--
ALTER TABLE `labib_buku`
  ADD PRIMARY KEY (`bukuid`);

--
-- Indeks untuk tabel `labib_kategoribuku`
--
ALTER TABLE `labib_kategoribuku`
  ADD PRIMARY KEY (`kategoriid`);

--
-- Indeks untuk tabel `labib_kategoribuku_relasi`
--
ALTER TABLE `labib_kategoribuku_relasi`
  ADD PRIMARY KEY (`kategori_bukuid`),
  ADD KEY `bukuid` (`bukuid`),
  ADD KEY `kategoriid` (`kategoriid`);

--
-- Indeks untuk tabel `labib_koleksipribadi`
--
ALTER TABLE `labib_koleksipribadi`
  ADD PRIMARY KEY (`koleksiid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `bukuid` (`bukuid`);

--
-- Indeks untuk tabel `labib_peminjaman`
--
ALTER TABLE `labib_peminjaman`
  ADD PRIMARY KEY (`peminjamanid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `bukuid` (`bukuid`);

--
-- Indeks untuk tabel `labib_ulasanbuku`
--
ALTER TABLE `labib_ulasanbuku`
  ADD PRIMARY KEY (`ulasanid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `bukuid` (`bukuid`);

--
-- Indeks untuk tabel `labib_user`
--
ALTER TABLE `labib_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `labib_buku`
--
ALTER TABLE `labib_buku`
  MODIFY `bukuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `labib_kategoribuku`
--
ALTER TABLE `labib_kategoribuku`
  MODIFY `kategoriid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `labib_kategoribuku_relasi`
--
ALTER TABLE `labib_kategoribuku_relasi`
  MODIFY `kategori_bukuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `labib_koleksipribadi`
--
ALTER TABLE `labib_koleksipribadi`
  MODIFY `koleksiid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `labib_peminjaman`
--
ALTER TABLE `labib_peminjaman`
  MODIFY `peminjamanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `labib_ulasanbuku`
--
ALTER TABLE `labib_ulasanbuku`
  MODIFY `ulasanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `labib_user`
--
ALTER TABLE `labib_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;