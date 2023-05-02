-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Bulan Mei 2023 pada 18.38
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
-- Database: `j-star`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `owner`
--

CREATE TABLE `owner` (
  `id_owner` int(100) NOT NULL,
  `nama_umkm` varchar(255) NOT NULL,
  `alamat_umkm` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `no_ktp` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'owner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `owner`
--

INSERT INTO `owner` (`id_owner`, `nama_umkm`, `alamat_umkm`, `no_hp`, `no_ktp`, `email`, `password`, `image`, `user_type`) VALUES
(1, 'Chips', 'Jln.Tegal Boto, Jember', '081335371768', '1753879287371', 'firza@gmail.com', '43256b151f95f862686823ac9e94899e', 'pic-1.png', 'owner'),
(2, 'kentang', 'Jln.Tegal Boto, Jember', '081335371768', '12314141', 'ananda@gmail.com', '43256b151f95f862686823ac9e94899e', 'pic-1.png', 'owner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(100) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `fid_owner` int(100) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_hp`, `email`, `password`, `image`, `fid_owner`, `user_type`) VALUES
(1, 'firza', 'jember', '08123456', 'anandafirza10@gmail.com', '73aeaa1bed34eb82aa04df2d2a6adf91', 'pic-1.png', 1, 'pelanggan'),
(2, 'eka', 'madura', '7716683', 'eka@gmail.com', '73aeaa1bed34eb82aa04df2d2a6adf91', 'pic-1.png', 2, 'pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_req` int(100) NOT NULL,
  `tgl_req` date NOT NULL DEFAULT current_timestamp(),
  `jumlah_req` int(100) NOT NULL,
  `fid_pelanggan` int(100) NOT NULL,
  `fid_produk` int(100) NOT NULL,
  `fid_owner` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(100) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int(100) NOT NULL,
  `produk_image` varchar(100) NOT NULL,
  `fid_owner` int(100) NOT NULL,
  `fid_varian` int(100) NOT NULL,
  `fid_ukuran` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `produk_image`, `fid_owner`, `fid_varian`, `fid_ukuran`) VALUES
(1, 'stefani', 20000, 'cat-4.png', 1, 1, 1),
(2, 'ekaa', 50000, 'cat-2.png', 1, 3, 2),
(3, 'krisna', 60000, 'cat-2.png', 2, 2, 1),
(4, 'firza', 40000, 'cat-2.png', 2, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ukuran`
--

CREATE TABLE `ukuran` (
  `id_ukuran` int(11) NOT NULL,
  `ukuran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ukuran`
--

INSERT INTO `ukuran` (`id_ukuran`, `ukuran`) VALUES
(1, 'small'),
(2, 'large');

-- --------------------------------------------------------

--
-- Struktur dari tabel `varian`
--

CREATE TABLE `varian` (
  `id_varian` int(11) NOT NULL,
  `varian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `varian`
--

INSERT INTO `varian` (`id_varian`, `varian`) VALUES
(1, 'original'),
(2, 'spicy'),
(3, 'roasted corn'),
(4, 'salted egg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id_owner`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_req`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id_ukuran`);

--
-- Indeks untuk tabel `varian`
--
ALTER TABLE `varian`
  ADD PRIMARY KEY (`id_varian`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `owner`
--
ALTER TABLE `owner`
  MODIFY `id_owner` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_req` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id_ukuran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `varian`
--
ALTER TABLE `varian`
  MODIFY `id_varian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
