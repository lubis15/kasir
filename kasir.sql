-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2022 pada 13.07
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Makanan', '2020-11-03 21:16:30', '2020-11-03 22:00:46', NULL),
(3, 'Minuman', '2020-11-03 23:21:05', '2020-11-03 23:21:05', NULL),
(5, 'Kue', '2020-11-09 23:23:34', '2020-11-09 23:23:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `id_produk` int(11) UNSIGNED NOT NULL,
  `jumlah` int(11) UNSIGNED NOT NULL,
  `harga` float UNSIGNED NOT NULL,
  `total` float UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` text NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(22, '2020-10-26-140558', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1603726454, 1),
(23, '2020-10-26-141644', 'App\\Database\\Migrations\\Produk', 'default', 'App', 1603726455, 1),
(24, '2020-10-26-151425', 'App\\Database\\Migrations\\Users', 'default', 'App', 1603726455, 1),
(25, '2020-10-26-152335', 'App\\Database\\Migrations\\Keranjang', 'default', 'App', 1603726455, 1),
(27, '2020-10-26-161232', 'App\\Database\\Migrations\\Transaksi', 'default', 'App', 1603729341, 2),
(29, '2020-10-26-162345', 'App\\Database\\Migrations\\TransaksiDetail', 'default', 'App', 1603730096, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) UNSIGNED NOT NULL,
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `harga` float NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `gambar_produk`, `harga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 1, 'Ayam Goreng', '1604942814_b1718dab975d6ea68929.jpg', 15000, '2020-11-07 00:47:59', '2020-11-10 00:26:54', NULL),
(14, 1, 'Ayam Bakar', '1604773233_09b2136c61518f0913ba.jpg', 15000, '2020-11-08 01:20:33', '2020-11-08 01:20:33', NULL),
(15, 3, 'Es Teh', '1604773250_ab0fc697934e53934cc3.jpeg', 5000, '2020-11-08 01:20:50', '2020-11-08 01:20:50', NULL),
(16, 1, 'Tahu Crispy	', '1604939061_1279a4863ff1d1d1c1c7.jpg', 15000, '2020-11-09 23:24:21', '2020-11-09 23:24:21', NULL),
(17, 1, 'Pisang Keju	', '1604939077_5ccf592b8ed53bf4e647.jpg', 10000, '2020-11-09 23:24:37', '2020-11-09 23:24:37', NULL),
(18, 1, 'Donat', '1604939096_aa3d9fb525ee853f4041.jpg', 5000, '2020-11-09 23:24:56', '2020-11-09 23:24:56', NULL),
(19, 3, 'Teh Hangat', '1604939134_e577edc3f0f69d2a35f0.jpg', 7000, '2020-11-09 23:25:34', '2020-11-09 23:25:34', NULL),
(20, 5, 'Petulo', '1604939154_83b7fb4d21ce9ff9a940.jpg', 12000, '2020-11-09 23:25:54', '2020-11-09 23:25:54', NULL),
(21, 5, 'Putu Ayu', '1604939182_eaf0054f896650929b68.jpg', 22500, '2020-11-09 23:26:22', '2020-11-09 23:26:22', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `no_transaksi` varchar(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `no_transaksi`, `username`, `nama_pelanggan`, `no_meja`, `catatan`, `created_at`, `updated_at`) VALUES
(1, '202011110001', 'budi', 'Taufik Hidayat', 10, 'Jangan Pedas ayamnya', '2020-11-11 23:02:19', '2020-11-11 23:02:19'),
(2, '202011120001', 'budi', 'Indra Hermawan', 7, '-', '2020-11-12 23:30:05', '2020-11-12 23:30:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_transaksi_detail` int(11) UNSIGNED NOT NULL,
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `id_produk` int(11) UNSIGNED NOT NULL,
  `jumlah` int(11) UNSIGNED NOT NULL,
  `harga` float UNSIGNED NOT NULL,
  `total` float UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_transaksi_detail`, `id_transaksi`, `id_produk`, `jumlah`, `harga`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 2, 15000, 30000, '2020-11-11 23:02:19', '2020-11-11 23:02:19'),
(2, 1, 15, 2, 5000, 10000, '2020-11-11 23:02:19', '2020-11-11 23:02:19'),
(3, 2, 14, 2, 15000, 30000, '2020-11-12 23:31:16', '2020-11-12 23:31:19'),
(4, 2, 19, 2, 7000, 14000, '2020-11-12 23:31:46', '2020-11-12 23:31:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` enum('admin','kasir','owner') NOT NULL DEFAULT 'kasir',
  `is_aktif` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `nama`, `level`, `is_aktif`, `created_at`, `updated_at`) VALUES
('admin', '$2y$10$2dbQ3/ZHYH0BQWTNLRnO9e/swznBXTZKUDMC5b1qnp8rPHDa6Qns.', 'Administrator', 'admin', '1', '2020-10-28 21:08:22', NULL),
('anton', '$2y$10$sNB.nGaqwlV4XiN.DuV0o.ManAlueBSYyDp57uFoPvUhuY7dcNq8a', 'Anton Nugroho', 'kasir', '1', '2020-11-11 23:20:14', '2020-11-11 23:20:14'),
('budi', '$2y$10$792B.v6713aNEQlcADgmUOLGI3j/Xa1nQFgrrPrkWszPJGDL0Ym6m', 'Budi Susanto', 'kasir', '1', '2020-10-28 21:08:22', NULL),
('joni', '$2y$10$XF3ZnRqfmp0kgSAruDZBHuiQ9d/kcF6VGMQeYbs6kHvkmT9Va.j/a', 'Joni Prakoso', 'owner', '1', '2020-10-28 21:08:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `keranjang_username_foreign` (`username`),
  ADD KEY `keranjang_id_produk_foreign` (`id_produk`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `produk_id_kategori_foreign` (`id_kategori`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `no_transaksi` (`no_transaksi`),
  ADD KEY `transaksi_username_foreign` (`username`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_transaksi_detail`),
  ADD KEY `transaksi_detail_id_transaksi_foreign` (`id_transaksi`),
  ADD KEY `transaksi_detail_id_produk_foreign` (`id_produk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_transaksi_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `keranjang_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
