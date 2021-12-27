-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2021 pada 17.45
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_fleet_manajemen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bahan_bakar`
--

CREATE TABLE `tb_bahan_bakar` (
  `id_bahan_bakar` int(11) NOT NULL,
  `nama_bahan_bakar` varchar(45) DEFAULT NULL,
  `status` enum('y','t') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dealer`
--

CREATE TABLE `tb_dealer` (
  `id_dealer` int(11) NOT NULL,
  `nama_dealer` varchar(45) DEFAULT NULL,
  `alamat` varchar(45) DEFAULT NULL,
  `no_tlp` varchar(45) DEFAULT NULL,
  `status` enum('y','t') NOT NULL,
  `status_dealer` enum('r','p') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_departemen`
--

CREATE TABLE `tb_departemen` (
  `id_departemen` int(11) NOT NULL,
  `nama_departemen` varchar(45) DEFAULT NULL,
  `perusahaan` varchar(45) DEFAULT NULL,
  `status` enum('y','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_foto_kecelakaan`
--

CREATE TABLE `tb_detail_foto_kecelakaan` (
  `id_detail_foto` int(11) NOT NULL,
  `id_kecelakaan` int(11) DEFAULT NULL,
  `foto_pendukung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_pengecekan`
--

CREATE TABLE `tb_detail_pengecekan` (
  `id_detail_pengecekan` int(11) NOT NULL,
  `id_pengecekan` varchar(45) DEFAULT NULL,
  `id_jenis_pengecekan` int(11) DEFAULT NULL,
  `kondisi` enum('b','r') NOT NULL,
  `waktu_pengecekan` enum('m','a','n') NOT NULL,
  `keterangan` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_pergantian`
--

CREATE TABLE `tb_detail_pergantian` (
  `id_detail_pergantian` int(11) NOT NULL,
  `id_perbaikan` int(11) DEFAULT NULL,
  `tgl_pergantian` date DEFAULT NULL,
  `nama_komponen` varchar(45) DEFAULT NULL,
  `jml_komponen` int(11) DEFAULT NULL,
  `harga satuan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_saran`
--

CREATE TABLE `tb_detail_saran` (
  `id_detail_saran` int(11) NOT NULL,
  `id_kecelakaan` int(11) DEFAULT NULL,
  `saran_kegiatan` varchar(255) DEFAULT NULL,
  `sasaran` varchar(45) DEFAULT NULL,
  `waktu_kegiatan` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_so`
--

CREATE TABLE `tb_detail_so` (
  `id_detail_so` int(11) NOT NULL,
  `id_servise_order` int(11) DEFAULT NULL,
  `nama_penumpang` varchar(45) DEFAULT NULL,
  `no_tlp` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_driver`
--

CREATE TABLE `tb_driver` (
  `id_driver` int(11) NOT NULL,
  `id_departemen` int(11) DEFAULT NULL,
  `no_badge` varchar(10) DEFAULT NULL,
  `no_ktp` varchar(16) DEFAULT NULL,
  `nama_driver` varchar(45) DEFAULT NULL,
  `alamat` varchar(60) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `no_tlp` varchar(15) DEFAULT NULL,
  `no_sim` varchar(13) DEFAULT NULL,
  `foto_ktp` varchar(45) DEFAULT NULL,
  `foto_SIM` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(45) DEFAULT NULL,
  `status` enum('y','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_kendaraan`
--

CREATE TABLE `tb_jenis_kendaraan` (
  `id_jenis_kendaraan` int(11) NOT NULL,
  `nama_jenis` varchar(45) DEFAULT NULL,
  `status` enum('y','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_pengecekan`
--

CREATE TABLE `tb_jenis_pengecekan` (
  `id_jenis_pengecekan` int(11) NOT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `jenis_pengecekan` varchar(60) DEFAULT NULL,
  `status` enum('y','t') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kecelakaan`
--

CREATE TABLE `tb_kecelakaan` (
  `id_kecelakaan` int(11) NOT NULL,
  `id_do` int(11) DEFAULT NULL,
  `tgl_kecelakaan` date DEFAULT NULL,
  `jam_kecelakaan` time(6) DEFAULT NULL,
  `lokasi_kejadian` varchar(255) DEFAULT NULL,
  `kronologi` varchar(255) DEFAULT NULL,
  `foto_sketsa_kejadian` varchar(45) DEFAULT NULL,
  `tindakan_tidak_aman` varchar(255) DEFAULT NULL,
  `kondisi_tidak_aman` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kendaraan`
--

CREATE TABLE `tb_kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `id_jenis_kendaraan` int(11) DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL,
  `id_bahan_bakar` int(11) DEFAULT NULL,
  `kode_asset` varchar(20) DEFAULT NULL,
  `no_polisi` varchar(11) DEFAULT NULL,
  `nomor_rangka` varchar(45) DEFAULT NULL,
  `nomor_mesin` varchar(45) DEFAULT NULL,
  `nama_kendaraan` varchar(20) DEFAULT NULL,
  `warna` varchar(20) DEFAULT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `jenis_penggerak` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kriteria_pengecekan`
--

CREATE TABLE `tb_kriteria_pengecekan` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(45) DEFAULT NULL,
  `status` enum('y','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_merk_kendaraan`
--

CREATE TABLE `tb_merk_kendaraan` (
  `id_merk` int(11) NOT NULL,
  `nama_merk` varchar(45) DEFAULT NULL,
  `status` enum('y','t') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_order_kendaraan`
--

CREATE TABLE `tb_order_kendaraan` (
  `id_service_order` int(11) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tgl_penjemputan` date DEFAULT NULL,
  `jam_penjemputan` time(6) DEFAULT NULL,
  `jml_penumpang` int(11) DEFAULT NULL,
  `tempat_penjemputan` varchar(45) DEFAULT NULL,
  `tujuan` varchar(45) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status_so` enum('t','tl') NOT NULL,
  `keterangan_penolakan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengecekan_kendaraan`
--

CREATE TABLE `tb_pengecekan_kendaraan` (
  `id_pengecekan` varchar(45) NOT NULL,
  `id_do` int(11) DEFAULT NULL,
  `tgl_pengecekan` date DEFAULT NULL,
  `jam_pengecekan` time(5) DEFAULT NULL,
  `km_kendaraan` varchar(8) DEFAULT NULL,
  `status_kendaraan` enum('r','t') NOT NULL,
  `status_pengecekan` enum('c','k') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penugasan_driver`
--

CREATE TABLE `tb_penugasan_driver` (
  `id_do` int(11) NOT NULL,
  `id_service_order` int(11) DEFAULT NULL,
  `id_driver` int(11) DEFAULT NULL,
  `id_kendaraan` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tgl_penugasan` date DEFAULT NULL,
  `jam_berangkat` time(6) DEFAULT NULL,
  `kembali` varchar(45) DEFAULT NULL,
  `tgl_acc` date DEFAULT NULL,
  `status_penugasan` enum('t','p','s') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_perbaikan`
--

CREATE TABLE `tb_perbaikan` (
  `id_perbaikan` int(11) NOT NULL,
  `id_persetujuan` int(11) DEFAULT NULL,
  `id_dealer` int(11) DEFAULT NULL,
  `tgl_perbaikan` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `status_perbaikan` enum('p','s') NOT NULL,
  `total_biaya_perbaikan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_persetujuan_perbaikan`
--

CREATE TABLE `tb_persetujuan_perbaikan` (
  `id_persetujuan` int(11) NOT NULL,
  `no_wo` int(11) DEFAULT NULL,
  `id_pengecekan` varchar(45) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `tgl_persetujuan` date DEFAULT NULL,
  `status` enum('s','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` int(11) NOT NULL,
  `no_badge` varchar(10) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_departemen` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(45) DEFAULT NULL,
  `tempat_lahir` varchar(20) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tgl_mulai_kerja` date DEFAULT NULL,
  `Telp` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('y','t') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_saksi_kecelakaan`
--

CREATE TABLE `tb_saksi_kecelakaan` (
  `id_saksi_kecelakaan` int(11) NOT NULL,
  `id_kecelakaan` int(11) DEFAULT NULL,
  `id_saksi` int(11) DEFAULT NULL,
  `id_atasan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_bahan_bakar`
--
ALTER TABLE `tb_bahan_bakar`
  ADD PRIMARY KEY (`id_bahan_bakar`);

--
-- Indeks untuk tabel `tb_dealer`
--
ALTER TABLE `tb_dealer`
  ADD PRIMARY KEY (`id_dealer`);

--
-- Indeks untuk tabel `tb_departemen`
--
ALTER TABLE `tb_departemen`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indeks untuk tabel `tb_detail_foto_kecelakaan`
--
ALTER TABLE `tb_detail_foto_kecelakaan`
  ADD PRIMARY KEY (`id_detail_foto`),
  ADD KEY `id_kecelakaan2_idx` (`id_kecelakaan`);

--
-- Indeks untuk tabel `tb_detail_pengecekan`
--
ALTER TABLE `tb_detail_pengecekan`
  ADD PRIMARY KEY (`id_detail_pengecekan`),
  ADD KEY `id_jenis_pengecekan1_idx` (`id_jenis_pengecekan`),
  ADD KEY `id_pengecekan1` (`id_pengecekan`);

--
-- Indeks untuk tabel `tb_detail_pergantian`
--
ALTER TABLE `tb_detail_pergantian`
  ADD PRIMARY KEY (`id_detail_pergantian`),
  ADD KEY `id_perbaikan_idx` (`id_perbaikan`);

--
-- Indeks untuk tabel `tb_detail_saran`
--
ALTER TABLE `tb_detail_saran`
  ADD PRIMARY KEY (`id_detail_saran`),
  ADD KEY `id_kecelakaan3_idx` (`id_kecelakaan`);

--
-- Indeks untuk tabel `tb_detail_so`
--
ALTER TABLE `tb_detail_so`
  ADD PRIMARY KEY (`id_detail_so`),
  ADD KEY `id_so_idx` (`id_servise_order`);

--
-- Indeks untuk tabel `tb_driver`
--
ALTER TABLE `tb_driver`
  ADD PRIMARY KEY (`id_driver`),
  ADD KEY `id_departemen1_idx` (`id_departemen`);

--
-- Indeks untuk tabel `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `tb_jenis_kendaraan`
--
ALTER TABLE `tb_jenis_kendaraan`
  ADD PRIMARY KEY (`id_jenis_kendaraan`);

--
-- Indeks untuk tabel `tb_jenis_pengecekan`
--
ALTER TABLE `tb_jenis_pengecekan`
  ADD PRIMARY KEY (`id_jenis_pengecekan`),
  ADD KEY `id_kriteria_idx` (`id_kriteria`);

--
-- Indeks untuk tabel `tb_kecelakaan`
--
ALTER TABLE `tb_kecelakaan`
  ADD PRIMARY KEY (`id_kecelakaan`),
  ADD KEY `id_do_idx` (`id_do`);

--
-- Indeks untuk tabel `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD KEY `id_jenis_kendaraan_idx` (`id_jenis_kendaraan`),
  ADD KEY `id_merk_kendaraan_idx` (`id_merk`),
  ADD KEY `id_bahan_bakar_idx` (`id_bahan_bakar`);

--
-- Indeks untuk tabel `tb_kriteria_pengecekan`
--
ALTER TABLE `tb_kriteria_pengecekan`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `tb_merk_kendaraan`
--
ALTER TABLE `tb_merk_kendaraan`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indeks untuk tabel `tb_order_kendaraan`
--
ALTER TABLE `tb_order_kendaraan`
  ADD PRIMARY KEY (`id_service_order`),
  ADD KEY `id_petugas2_idx` (`id_petugas`);

--
-- Indeks untuk tabel `tb_pengecekan_kendaraan`
--
ALTER TABLE `tb_pengecekan_kendaraan`
  ADD PRIMARY KEY (`id_pengecekan`);

--
-- Indeks untuk tabel `tb_penugasan_driver`
--
ALTER TABLE `tb_penugasan_driver`
  ADD PRIMARY KEY (`id_do`),
  ADD KEY `id_driver2_idx` (`id_driver`),
  ADD KEY `id_kendaraan2_idx` (`id_kendaraan`),
  ADD KEY `id_service_order_idx` (`id_service_order`);

--
-- Indeks untuk tabel `tb_perbaikan`
--
ALTER TABLE `tb_perbaikan`
  ADD PRIMARY KEY (`id_perbaikan`),
  ADD KEY `id_dealer_idx` (`id_dealer`),
  ADD KEY `id_wo_idx` (`id_persetujuan`);

--
-- Indeks untuk tabel `tb_persetujuan_perbaikan`
--
ALTER TABLE `tb_persetujuan_perbaikan`
  ADD PRIMARY KEY (`id_persetujuan`),
  ADD KEY `id_petugas_idx` (`id_petugas`),
  ADD KEY `id_pengecekan3_idx` (`id_pengecekan`);

--
-- Indeks untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD KEY `id_jabatan_idx` (`id_jabatan`),
  ADD KEY `id_departemen_idx` (`id_departemen`);

--
-- Indeks untuk tabel `tb_saksi_kecelakaan`
--
ALTER TABLE `tb_saksi_kecelakaan`
  ADD PRIMARY KEY (`id_saksi_kecelakaan`),
  ADD KEY `id_saksi1_idx` (`id_saksi`),
  ADD KEY `id_atasan1_idx` (`id_atasan`),
  ADD KEY `id_kecelakaan1_idx` (`id_kecelakaan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_bahan_bakar`
--
ALTER TABLE `tb_bahan_bakar`
  MODIFY `id_bahan_bakar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_dealer`
--
ALTER TABLE `tb_dealer`
  MODIFY `id_dealer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_departemen`
--
ALTER TABLE `tb_departemen`
  MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_foto_kecelakaan`
--
ALTER TABLE `tb_detail_foto_kecelakaan`
  MODIFY `id_detail_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_pengecekan`
--
ALTER TABLE `tb_detail_pengecekan`
  MODIFY `id_detail_pengecekan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_pergantian`
--
ALTER TABLE `tb_detail_pergantian`
  MODIFY `id_detail_pergantian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_saran`
--
ALTER TABLE `tb_detail_saran`
  MODIFY `id_detail_saran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_so`
--
ALTER TABLE `tb_detail_so`
  MODIFY `id_detail_so` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_driver`
--
ALTER TABLE `tb_driver`
  MODIFY `id_driver` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_kendaraan`
--
ALTER TABLE `tb_jenis_kendaraan`
  MODIFY `id_jenis_kendaraan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_pengecekan`
--
ALTER TABLE `tb_jenis_pengecekan`
  MODIFY `id_jenis_pengecekan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kecelakaan`
--
ALTER TABLE `tb_kecelakaan`
  MODIFY `id_kecelakaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kriteria_pengecekan`
--
ALTER TABLE `tb_kriteria_pengecekan`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_merk_kendaraan`
--
ALTER TABLE `tb_merk_kendaraan`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_penugasan_driver`
--
ALTER TABLE `tb_penugasan_driver`
  MODIFY `id_do` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_perbaikan`
--
ALTER TABLE `tb_perbaikan`
  MODIFY `id_perbaikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_persetujuan_perbaikan`
--
ALTER TABLE `tb_persetujuan_perbaikan`
  MODIFY `id_persetujuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_saksi_kecelakaan`
--
ALTER TABLE `tb_saksi_kecelakaan`
  MODIFY `id_saksi_kecelakaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_detail_foto_kecelakaan`
--
ALTER TABLE `tb_detail_foto_kecelakaan`
  ADD CONSTRAINT `id_kecelakaan2` FOREIGN KEY (`id_kecelakaan`) REFERENCES `tb_kecelakaan` (`id_kecelakaan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_detail_pengecekan`
--
ALTER TABLE `tb_detail_pengecekan`
  ADD CONSTRAINT `id_jenis_pengecekan1` FOREIGN KEY (`id_jenis_pengecekan`) REFERENCES `tb_jenis_pengecekan` (`id_jenis_pengecekan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_pengecekan1` FOREIGN KEY (`id_pengecekan`) REFERENCES `tb_pengecekan_kendaraan` (`id_pengecekan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_detail_pergantian`
--
ALTER TABLE `tb_detail_pergantian`
  ADD CONSTRAINT `id_perbaikan` FOREIGN KEY (`id_perbaikan`) REFERENCES `tb_perbaikan` (`id_perbaikan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_detail_saran`
--
ALTER TABLE `tb_detail_saran`
  ADD CONSTRAINT `id_kecelakaan3` FOREIGN KEY (`id_kecelakaan`) REFERENCES `tb_kecelakaan` (`id_kecelakaan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_detail_so`
--
ALTER TABLE `tb_detail_so`
  ADD CONSTRAINT `id_so` FOREIGN KEY (`id_servise_order`) REFERENCES `tb_order_kendaraan` (`id_service_order`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_driver`
--
ALTER TABLE `tb_driver`
  ADD CONSTRAINT `id_departemen1` FOREIGN KEY (`id_departemen`) REFERENCES `tb_departemen` (`id_departemen`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_jenis_pengecekan`
--
ALTER TABLE `tb_jenis_pengecekan`
  ADD CONSTRAINT `id_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `tb_kriteria_pengecekan` (`id_kriteria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_kecelakaan`
--
ALTER TABLE `tb_kecelakaan`
  ADD CONSTRAINT `id_do` FOREIGN KEY (`id_do`) REFERENCES `tb_penugasan_driver` (`id_do`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD CONSTRAINT `id_bahan_bakar` FOREIGN KEY (`id_bahan_bakar`) REFERENCES `tb_bahan_bakar` (`id_bahan_bakar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_jenis_kendaraan` FOREIGN KEY (`id_jenis_kendaraan`) REFERENCES `tb_jenis_kendaraan` (`id_jenis_kendaraan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_merk_kendaraan` FOREIGN KEY (`id_merk`) REFERENCES `tb_merk_kendaraan` (`id_merk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_order_kendaraan`
--
ALTER TABLE `tb_order_kendaraan`
  ADD CONSTRAINT `id_petugas2` FOREIGN KEY (`id_petugas`) REFERENCES `tb_petugas` (`id_petugas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_penugasan_driver`
--
ALTER TABLE `tb_penugasan_driver`
  ADD CONSTRAINT `id_driver2` FOREIGN KEY (`id_driver`) REFERENCES `tb_driver` (`id_driver`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_kendaraan2` FOREIGN KEY (`id_kendaraan`) REFERENCES `tb_kendaraan` (`id_kendaraan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_service_order` FOREIGN KEY (`id_service_order`) REFERENCES `tb_order_kendaraan` (`id_service_order`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_perbaikan`
--
ALTER TABLE `tb_perbaikan`
  ADD CONSTRAINT `id_dealer` FOREIGN KEY (`id_dealer`) REFERENCES `tb_dealer` (`id_dealer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_wo` FOREIGN KEY (`id_persetujuan`) REFERENCES `tb_persetujuan_perbaikan` (`id_persetujuan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_persetujuan_perbaikan`
--
ALTER TABLE `tb_persetujuan_perbaikan`
  ADD CONSTRAINT `id_pengecekan3` FOREIGN KEY (`id_pengecekan`) REFERENCES `tb_pengecekan_kendaraan` (`id_pengecekan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_petugas1` FOREIGN KEY (`id_petugas`) REFERENCES `tb_petugas` (`id_petugas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD CONSTRAINT `id_departemen` FOREIGN KEY (`id_departemen`) REFERENCES `tb_departemen` (`id_departemen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `tb_jabatan` (`id_jabatan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_saksi_kecelakaan`
--
ALTER TABLE `tb_saksi_kecelakaan`
  ADD CONSTRAINT `id_atasan1` FOREIGN KEY (`id_atasan`) REFERENCES `tb_petugas` (`id_petugas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_kecelakaan1` FOREIGN KEY (`id_kecelakaan`) REFERENCES `tb_kecelakaan` (`id_kecelakaan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_saksi1` FOREIGN KEY (`id_saksi`) REFERENCES `tb_petugas` (`id_petugas`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
