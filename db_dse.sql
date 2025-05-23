-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 20, 2025 at 04:34 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dse`
--

-- --------------------------------------------------------

--
-- Table structure for table `number_sequences`
--

CREATE TABLE `number_sequences` (
  `recid` int(11) NOT NULL,
  `prefix` varchar(11) NOT NULL,
  `kode_perusahaan` varchar(20) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `last_number` varchar(15) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `number_sequences`
--

INSERT INTO `number_sequences` (`recid`, `prefix`, `kode_perusahaan`, `bulan`, `tahun`, `last_number`) VALUES
(7, 'INV', 'DSE', 1, 2025, '0'),
(8, 'PO', 'DSE', 5, 2025, '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bahan_baku`
--

CREATE TABLE `tbl_bahan_baku` (
  `recid` int(11) NOT NULL,
  `nama_bb` varchar(50) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bahan_baku`
--

INSERT INTO `tbl_bahan_baku` (`recid`, `nama_bb`, `desc`, `stok`, `satuan`, `supp_id`) VALUES
(2, 'bahan baku', 'tes', 6000, 'Kg', 1),
(3, 'bahan baku  TOKO B', 'bahan baku TOKO B', 6100, 'Kg', 2),
(8, 'tes', 'tes', 5000, 'Liter', 1),
(9, 'tess', 'sasaas', 500, 'Kg', 1),
(22, 'tes bimbingan', 'tes bimbingan', 505, 'Kg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `recid` int(11) NOT NULL,
  `nama_client` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_telp` bigint(20) DEFAULT NULL,
  `fax` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`recid`, `nama_client`, `alamat`, `status`, `email`, `no_telp`, `fax`) VALUES
(1, 'PT Erricon', 'Cibarusah', 0, 'erricon@gmail.com', 123, 312);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_formulasi`
--

CREATE TABLE `tbl_formulasi` (
  `recid` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `bahanbaku_id` int(11) NOT NULL,
  `qty_per_ton` decimal(10,2) NOT NULL,
  `uom` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_formulasi`
--

INSERT INTO `tbl_formulasi` (`recid`, `produk_id`, `bahanbaku_id`, `qty_per_ton`, `uom`) VALUES
(11, 1, 3, '500.00', 'Kg'),
(13, 1, 2, '500.00', 'Kg'),
(16, 5, 2, '500.00', 'Kg'),
(17, 5, 8, '500.00', 'Liter');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventaris`
--

CREATE TABLE `tbl_inventaris` (
  `recid` int(11) NOT NULL,
  `nama_inven` varchar(50) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `jml_rusak` int(11) DEFAULT NULL,
  `jml_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_inventaris`
--

INSERT INTO `tbl_inventaris` (`recid`, `nama_inven`, `desc`, `jml`, `jml_rusak`, `jml_active`) VALUES
(1, 'Kempu', 'Alat penampungan obat', 10, 3, 7),
(2, 'Pompa', 'Alat pemindah obat', 10, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `recid` int(11) NOT NULL,
  `nama_product` varchar(50) NOT NULL,
  `desc_product` varchar(255) NOT NULL,
  `grade` enum('A','B','C','D','F','G','H') NOT NULL,
  `level` enum('1','2','3','4') NOT NULL,
  `hargaPerTon` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`recid`, `nama_product`, `desc_product`, `grade`, `level`, `hargaPerTon`) VALUES
(1, 'rekton type F', 'untuk percepatan pengerasan beton K-125 di bawah 6 jam', 'F', '1', 1000000),
(5, 'product baru DSE', 'product baru 2025', 'A', '1', 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_relasi_inven`
--

CREATE TABLE `tbl_relasi_inven` (
  `recid` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `inven_id` int(11) DEFAULT NULL,
  `jml_total` int(11) DEFAULT NULL,
  `jml_active` int(11) DEFAULT NULL,
  `jml_nonactive` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_relasi_inven`
--

INSERT INTO `tbl_relasi_inven` (`recid`, `client_id`, `inven_id`, `jml_total`, `jml_active`, `jml_nonactive`) VALUES
(1, 1, 1, 2, 2, 0),
(2, 1, 2, 4, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `recid` int(11) NOT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_telp` bigint(20) DEFAULT NULL,
  `fax` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`recid`, `nama_supplier`, `alamat`, `status`, `email`, `no_telp`, `fax`) VALUES
(1, 'Toko A', 'bekasi', 1, 'tokoa@gmail.com', 123, 123),
(2, 'TOKO B', 'bekasi', 1, 'tokob@gmail.com', 123, 312);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tmpt_produksi`
--

CREATE TABLE `tbl_tmpt_produksi` (
  `recid` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tmpt_produksi`
--

INSERT INTO `tbl_tmpt_produksi` (`recid`, `nama`, `alamat`) VALUES
(1, 'bu desi cileungsio', 'cileungsiii');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_bahanbaku`
--

CREATE TABLE `tbl_transaksi_bahanbaku` (
  `recid` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `no_invoice` varchar(50) DEFAULT NULL,
  `buktibayar` varchar(100) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `pengiriman` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `uom` varchar(20) NOT NULL,
  `bahanbaku_id` int(11) DEFAULT NULL,
  `supp_id` int(11) DEFAULT NULL,
  `jumlah_bayar` double DEFAULT NULL,
  `bukti_file` varchar(255) DEFAULT NULL,
  `tgl_byr` date DEFAULT NULL,
  `status_bayar` tinyint(1) DEFAULT NULL,
  `qty_terima` int(11) DEFAULT NULL,
  `tgl_jatuhtempo` date DEFAULT NULL,
  `sudah_diterima` tinyint(4) NOT NULL DEFAULT 0,
  `catatan_terima` varchar(100) DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_transaksi_bahanbaku`
--

INSERT INTO `tbl_transaksi_bahanbaku` (`recid`, `tgl`, `no_po`, `no_invoice`, `buktibayar`, `harga`, `pengiriman`, `status`, `qty`, `uom`, `bahanbaku_id`, `supp_id`, `jumlah_bayar`, `bukti_file`, `tgl_byr`, `status_bayar`, `qty_terima`, `tgl_jatuhtempo`, `sudah_diterima`, `catatan_terima`, `createdby`, `modifiedby`) VALUES
(13, '2025-05-16', NULL, NULL, NULL, NULL, NULL, 0, 44, 'Kg', 3, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, 0, '', 'admin', 'admin'),
(15, '2025-05-16', '0005/PO/DSE/1/2025', '0001/INV/tokoooo/1/2025', NULL, '5000.00', NULL, 2, 5556, 'Liter', 3, NULL, 100000, 'Screenshot 2025-04-21 at 04.48.17.png', '2025-05-16', 1, 6000, NULL, 0, 'tes', 'admin', 'admin'),
(17, '2025-05-16', '0004/PO/DSE/1/2025', '0004/PO/TOKO-B/1/2025', NULL, '1000000.00', NULL, 1, 906, 'Kg', 3, 2, NULL, NULL, '0000-00-00', NULL, NULL, NULL, 0, '', 'admin', 'admin'),
(19, '2025-05-20', '0002/PO/DSE-05/2025', '0004/PO/TOKO-B/1/2025', NULL, '20000.00', NULL, 2, 500, 'Kg', 22, 1, 100000, 'Screenshot 2025-04-21 at 04.48.17.png', '2025-05-21', 1, 505, NULL, 0, 'gud', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `recid` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`recid`, `username`, `nama`, `email`, `password`, `status`, `level`, `alamat`) VALUES
(1, 'admin', 'admin', 'admin@dse.com', '123', 1, '1', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keluar`
--

CREATE TABLE `transaksi_keluar` (
  `recid` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `no_invoice` varchar(50) DEFAULT NULL,
  `buktibayar` varchar(100) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `ppn` decimal(15,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `total_harga` decimal(15,2) DEFAULT NULL,
  `pengiriman` varchar(100) DEFAULT NULL,
  `ongkir` decimal(15,2) DEFAULT NULL,
  `penanggung_ongkir` tinyint(1) DEFAULT NULL,
  `tanggal_sampai` date DEFAULT NULL,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `status_pembayaran` tinyint(1) DEFAULT NULL,
  `sisa_pembayaran` int(11) DEFAULT NULL,
  `sudah_diterima` tinyint(4) NOT NULL,
  `pakai_inventaris` tinyint(1) DEFAULT NULL,
  `inven_id` int(11) DEFAULT NULL,
  `jml_inven` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `tgl_produksi` date DEFAULT NULL,
  `tmpt_produksi_id` int(11) DEFAULT NULL,
  `status_produksi` tinyint(1) DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `recid` int(11) NOT NULL,
  `kode_uom` varchar(10) NOT NULL,
  `nama_uom` varchar(50) NOT NULL,
  `batas_aman` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`recid`, `kode_uom`, `nama_uom`, `batas_aman`) VALUES
(1, 'Kg', 'Kilo Gram', 500),
(2, 'Liter', 'Liter', 400),
(3, 'Ton', 'Tonase', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `number_sequences`
--
ALTER TABLE `number_sequences`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `unique_sequence` (`prefix`,`kode_perusahaan`,`bulan`,`tahun`);

--
-- Indexes for table `tbl_bahan_baku`
--
ALTER TABLE `tbl_bahan_baku`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `supp_id` (`supp_id`),
  ADD KEY `fk_bahanbaku_uom` (`satuan`);

--
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_formulasi`
--
ALTER TABLE `tbl_formulasi`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `unique_produk_bahanbaku` (`produk_id`,`bahanbaku_id`),
  ADD KEY `bahanbaku_id` (`bahanbaku_id`);

--
-- Indexes for table `tbl_inventaris`
--
ALTER TABLE `tbl_inventaris`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `tbl_relasi_inven`
--
ALTER TABLE `tbl_relasi_inven`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `inven_id` (`inven_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_tmpt_produksi`
--
ALTER TABLE `tbl_tmpt_produksi`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `tbl_transaksi_bahanbaku`
--
ALTER TABLE `tbl_transaksi_bahanbaku`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `bahanbaku_id` (`bahanbaku_id`),
  ADD KEY `supp_id` (`supp_id`),
  ADD KEY `fk_transaksibb_createdby` (`createdby`),
  ADD KEY `fk_transaksibb_modifiedby` (`modifiedby`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  ADD PRIMARY KEY (`recid`),
  ADD KEY `inven_id` (`inven_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `tmpt_produksi_id` (`tmpt_produksi_id`),
  ADD KEY `fk_transaksikeluar_createdby` (`createdby`),
  ADD KEY `fk_transaksikeluar_modifiedby` (`modifiedby`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`recid`),
  ADD UNIQUE KEY `kode_uom` (`kode_uom`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `number_sequences`
--
ALTER TABLE `number_sequences`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_bahan_baku`
--
ALTER TABLE `tbl_bahan_baku`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_client`
--
ALTER TABLE `tbl_client`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_formulasi`
--
ALTER TABLE `tbl_formulasi`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_inventaris`
--
ALTER TABLE `tbl_inventaris`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_relasi_inven`
--
ALTER TABLE `tbl_relasi_inven`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_tmpt_produksi`
--
ALTER TABLE `tbl_tmpt_produksi`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_transaksi_bahanbaku`
--
ALTER TABLE `tbl_transaksi_bahanbaku`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bahan_baku`
--
ALTER TABLE `tbl_bahan_baku`
  ADD CONSTRAINT `fk_bahanbaku_uom` FOREIGN KEY (`satuan`) REFERENCES `uom` (`kode_uom`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_bahan_baku_ibfk_1` FOREIGN KEY (`supp_id`) REFERENCES `tbl_supplier` (`recid`);

--
-- Constraints for table `tbl_formulasi`
--
ALTER TABLE `tbl_formulasi`
  ADD CONSTRAINT `tbl_formulasi_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `tbl_product` (`recid`),
  ADD CONSTRAINT `tbl_formulasi_ibfk_2` FOREIGN KEY (`bahanbaku_id`) REFERENCES `tbl_bahan_baku` (`recid`);

--
-- Constraints for table `tbl_relasi_inven`
--
ALTER TABLE `tbl_relasi_inven`
  ADD CONSTRAINT `tbl_relasi_inven_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `tbl_client` (`recid`),
  ADD CONSTRAINT `tbl_relasi_inven_ibfk_2` FOREIGN KEY (`inven_id`) REFERENCES `tbl_inventaris` (`recid`);

--
-- Constraints for table `tbl_transaksi_bahanbaku`
--
ALTER TABLE `tbl_transaksi_bahanbaku`
  ADD CONSTRAINT `fk_transaksibb_createdby` FOREIGN KEY (`createdby`) REFERENCES `tbl_user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksibb_modifiedby` FOREIGN KEY (`modifiedby`) REFERENCES `tbl_user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transaksi_bahanbaku_ibfk_1` FOREIGN KEY (`bahanbaku_id`) REFERENCES `tbl_bahan_baku` (`recid`),
  ADD CONSTRAINT `tbl_transaksi_bahanbaku_ibfk_2` FOREIGN KEY (`supp_id`) REFERENCES `tbl_supplier` (`recid`);

--
-- Constraints for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  ADD CONSTRAINT `fk_transaksi_product` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`recid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksikeluar_createdby` FOREIGN KEY (`createdby`) REFERENCES `tbl_user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksikeluar_modifiedby` FOREIGN KEY (`modifiedby`) REFERENCES `tbl_user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_keluar_ibfk_1` FOREIGN KEY (`inven_id`) REFERENCES `tbl_inventaris` (`recid`),
  ADD CONSTRAINT `transaksi_keluar_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `tbl_client` (`recid`),
  ADD CONSTRAINT `transaksi_keluar_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `tbl_bahan_baku` (`recid`),
  ADD CONSTRAINT `transaksi_keluar_ibfk_4` FOREIGN KEY (`tmpt_produksi_id`) REFERENCES `tbl_tmpt_produksi` (`recid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
