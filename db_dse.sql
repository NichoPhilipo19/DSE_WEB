-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2025 at 04:36 PM
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
(1, 'INV', 'DSE', 8, 2025, '6'),
(2, 'PO', 'DSE', 8, 2025, '6');

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
  `supp_id` int(11) DEFAULT NULL,
  `harga_beli` double DEFAULT NULL,
  `harga_pasaran_per_satuan` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bahan_baku`
--

INSERT INTO `tbl_bahan_baku` (`recid`, `nama_bb`, `desc`, `stok`, `satuan`, `supp_id`, `harga_beli`, `harga_pasaran_per_satuan`) VALUES
(1, 'Semen Portland', NULL, 320, 'zak', 1, 58000, 60000),
(2, 'Pasir Halus', NULL, 3968, 'm3', 2, 11000, 15000),
(3, 'Kerikil 1/2', NULL, 265, 'm3', 2, 45000, 50000),
(4, 'Air Bersih', NULL, 4930, 'liter', 10, 300, 400),
(5, 'Fly Ash', NULL, 370, 'kg', 7, 500, 1500),
(6, 'Additive Sika', NULL, -203, 'liter', 5, 1200, 1800),
(7, 'Batu Split', NULL, 76, 'm3', 2, 65000, 80000),
(8, 'Lime Powder', NULL, 400, 'kg', 5, 1800, 2000),
(9, 'Pasir Kasar', NULL, -30, 'm3', 10, 63000, 80000),
(10, 'Silica Fume', NULL, 30, 'kg', 5, 2500, 4000),
(11, 'pasir halus CV PASIR MULIA', 'pasir halus grade B', 0, 'Ton', 11, 800000, 900000);

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
(1, 'PT Beton Jaya Abadi', 'Jl. Raya Cilegon KM 3, Serang', 1, 'betonjaya@mail.co.id', 212345678, NULL),
(2, 'CV Bangun Mandiri', 'Jl. Cempaka Putih No. 22, Jakarta Pusat', 1, 'mandiri@cv.co.id', 2188990011, NULL),
(3, 'PT Konstruksi Nusantara', 'Jl. Soekarno Hatta No.88, Bandung', 1, 'nusantara@pt.co.id', 228889988, NULL),
(4, 'CV Pilar Beton', 'Jl. Tembok Gede No.1, Surabaya', 1, 'pilarbeton@cv.co.id', 312211334, NULL),
(5, 'PT Bumi Karya Beton', 'Jl. Ahmad Yani No. 100, Semarang', 1, 'karya@bumi.co.id', 247766554, NULL),
(6, 'CV Cipta Beton Makmur', 'Jl. Gajah Mada No. 45, Medan', 1, 'ciptamakmur@cv.co.id', 618765432, NULL),
(7, 'PT Mega Struktur', 'Jl. Margonda Raya No. 8, Depok', 1, 'mega@struktur.co.id', 217654321, NULL),
(8, 'CV Beton Prima', 'Jl. Diponegoro No. 12, Malang', 1, 'primabeton@cv.co.id', 341567890, NULL),
(9, 'PT Beton Solusi', 'Jl. Panjang No. 9, Bekasi', 1, 'solusi@beton.co.id', 214455667, NULL),
(10, 'CV Beton Sejahtera', 'Jl. Sutomo No. 17, Makassar', 1, 'sejahtera@beton.co.id', 411888999, NULL);

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
(1, 1, 4, '500.00', 'liter'),
(2, 1, 2, '40.00', 'm3'),
(3, 1, 9, '40.00', 'm3'),
(4, 1, 5, '40.00', 'kg'),
(5, 1, 10, '40.00', 'kg'),
(6, 1, 6, '300.00', 'liter'),
(38, 2, 4, '700.00', 'liter'),
(39, 2, 2, '0.50', 'm3'),
(40, 2, 5, '100.00', 'kg'),
(41, 2, 6, '30.00', 'liter'),
(94, 3, 4, '600.00', 'liter'),
(95, 3, 3, '0.40', 'm3'),
(96, 3, 6, '60.00', 'liter'),
(97, 3, 10, '200.00', 'kg'),
(98, 4, 4, '750.00', 'liter'),
(99, 4, 2, '0.50', 'm3'),
(100, 4, 8, '100.00', 'kg'),
(101, 5, 4, '800.00', 'liter'),
(102, 5, 9, '0.50', 'm3'),
(103, 5, 6, '40.00', 'liter'),
(104, 6, 4, '650.00', 'liter'),
(105, 6, 3, '0.60', 'm3'),
(106, 6, 7, '0.50', 'm3'),
(107, 6, 6, '25.00', 'liter'),
(108, 7, 4, '700.00', 'liter'),
(109, 7, 5, '150.00', 'kg'),
(110, 7, 10, '100.00', 'kg'),
(111, 8, 4, '600.00', 'liter'),
(112, 8, 6, '40.00', 'liter'),
(113, 8, 9, '0.30', 'm3'),
(114, 9, 4, '900.00', 'liter'),
(115, 9, 7, '0.60', 'm3'),
(116, 9, 10, '200.00', 'kg'),
(117, 10, 4, '700.00', 'liter'),
(118, 10, 6, '50.00', 'liter'),
(119, 10, 10, '100.00', 'kg');

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
(1, 'Mesin Mixer Beton', 'Digunakan untuk mencampur bahan beton', 5, 1, 4),
(2, 'Alat Ukur Digital', 'Mengukur volume dan berat bahan baku', 10, 0, 10),
(3, 'Forklift', 'Mengangkat bahan berat dari gudang ke produksi', 3, 1, 2),
(4, 'Tangki Air', 'Penyimpanan air untuk proses produksi', 7, 0, 7),
(5, 'Generator Listrik', 'Backup daya saat listrik padam', 2, 0, 2),
(6, 'Pompa Air', 'Memompa air untuk kebutuhan produksi', 4, 2, 2),
(7, 'Timbangan Digital', 'Menimbang bahan baku dan hasil produksi', 6, 1, 5),
(8, 'Mesin Pemotong Besi', 'Memotong besi untuk rangka beton', 2, 1, 1),
(9, 'Pallet Kayu', 'Untuk menyusun produk jadi di gudang', 50, 5, 45),
(10, 'Rak Besi Gudang', 'Menyimpan bahan baku dan produk jadi', 20, 2, 18),
(11, 'Kempu', 'Menyimpan Obat Beton dan produk jadi', 20, 2, 18),
(12, 'Pompa Air Client', 'Memompa obat beton untuk kebutuhan Client', 20, 2, 18);

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
  `hargaPerTon` int(15) NOT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`recid`, `nama_product`, `desc_product`, `grade`, `level`, `hargaPerTon`, `status`) VALUES
(1, 'OB-Mutubin', 'Obat beton untuk memperkuat mutu beton struktural bangunan bertingkat', 'A', '4', 1450000, 1),
(2, 'OB-Kuatmax', 'Campuran beton yang meningkatkan kekuatan tekan hingga 50 MPa', 'A', '3', 1375000, 1),
(3, 'OB-QuickSet', 'Mempercepat pengerasan beton precast dalam waktu 4 jam', 'B', '4', 1550000, 1),
(4, 'OB-TahanLama', 'Formula khusus untuk memperpanjang umur beton hingga 50 tahun', 'A', '2', 1250000, 0),
(5, 'OB-SuperFlow', 'Memberikan fluiditas tinggi tanpa mengurangi kekuatan beton', 'C', '3', 1320000, 1),
(6, 'OB-PrecastPro', 'Diformulasikan untuk beton cetak dengan kecepatan produksi tinggi', 'B', '4', 1490000, 1),
(7, 'OB-AntiRetak', 'Mengurangi potensi retak rambut pada beton akibat suhu', 'A', '3', 1400000, 1),
(8, 'OB-PerekatMega', 'Memperkuat ikatan antar beton lama dan beton baru', 'B', '2', 1180000, 0),
(9, 'OB-MutuEkstra', 'Dosis tinggi untuk proyek bendungan dan jalan tol', 'A', '4', 1600000, 1),
(10, 'OB-HydroStop', 'Obat beton untuk waterproofing permanen', 'A', '3', 1500000, 1);

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
(1, 1, 11, 5, 4, 1),
(2, 2, 12, 10, 8, 2),
(3, 3, 11, 7, 5, 2),
(4, 4, 12, 6, 6, 0),
(5, 5, 11, 8, 6, 2),
(6, 6, 12, 9, 7, 2),
(7, 7, 11, 4, 3, 1),
(8, 8, 12, 12, 10, 2),
(9, 9, 11, 3, 3, 0),
(10, 10, 12, 5, 4, 1);

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
(1, 'PT Semen Indonesia', 'Jl. Veteran, Gresik', 1, 'info@semenindonesia.co.id', 318888999, NULL),
(2, 'CV Pasir Merapi', 'Jl. Kaliurang KM 16, Sleman', 1, 'pasirmerapi@cv.co.id', 274865432, NULL),
(3, 'PT Baja Konstruksi', 'Jl. Industri No. 2, Karawang', 1, 'bajakonstruksi@pt.co.id', 267899123, NULL),
(4, 'CV Batu Alam Sentosa', 'Jl. Batu No. 5, Purwakarta', 1, 'batualam@cv.co.id', 264557890, NULL),
(5, 'PT Kimia Bangunan', 'Jl. Raya Industri, Bekasi', 1, 'kimia@bangunan.co.id', 219988776, NULL),
(6, 'CV Cat Anti Air', 'Jl. Kemayoran, Jakarta Pusat', 1, 'catanti@cv.co.id', 212341122, NULL),
(7, 'PT Tambang Andesit', 'Jl. Raya Lembang, Bandung Barat', 1, 'andesit@tambang.co.id', 227643321, NULL),
(8, 'CV Beton ReadyMix', 'Jl. Dr. Sutomo No. 33, Solo', 1, 'readymix@cv.co.id', 271738393, NULL),
(9, 'PT Logam Indo', 'Jl. Baja No. 99, Tangerang', 1, 'logamindo@pt.co.id', 217788991, NULL),
(10, 'CV Sumber Pasir', 'Jl. Raya Pelabuhan, Probolinggo', 1, 'sumberpasir@cv.co.id', 335789890, NULL),
(11, 'CV PASIR MULIA', 'Bekasi', 1, 'erricon@gmail.com', 812344567789, 812344567789);

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
(1, 'Tempat Produksi Utama - PT DSE', 'Jl. Raya Narogong Km 15, Cileungsi, Bogor, Jawa Barat'),
(2, 'Gudang Produksi Timur', 'Jl. Industri Raya No.12, Bekasi Timur, Jawa Barat'),
(3, 'Workshop Beton Cepat', 'Jl. Raya Serang KM 24, Cikande, Banten'),
(4, 'Tempat Produksi Khusus Precast', 'Kawasan Industri Jatake, Tangerang'),
(5, 'Site Produksi Mobile Project A', 'Jl. Pantura, Tegal, Jawa Tengah'),
(6, 'Workshop Beton Ringan', 'Jl. Cempaka Putih, Semarang, Jawa Tengah'),
(7, 'Tempat Produksi Mitra A', 'Jl. Raya Malang - Surabaya Km 8, Malang'),
(8, 'Produksi Beton Anti Retak', 'Jl. Alternatif Cibubur, Jakarta Timur'),
(9, 'Site Produksi Mobile Proyek Tol Sumatra', 'Jl. Lintas Sumatera, Lampung'),
(10, 'Tempat Produksi Penelitian Campuran Baru', 'Jl. Teknologi Beton No.88, Bandung');

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
(1, '2025-08-03', '0001/PO/DSE-08/2025', '0024/INV/Dummy-5/2025', NULL, '3000000.00', NULL, 2, 1000, 'm3', 2, 2, 3000000, '20250803_npwp.jpg', '2025-08-03', 1, 1003, NULL, 0, 'baik', 'admin', 'admin'),
(2, '2025-08-04', '0002/PO/DSE-08/2025', '0001/PO/TOKO-B/1/2025', NULL, '10000000.00', NULL, 2, 200, 'zak', 1, 1, 10000000, '20250804_Screenshot_2025-04-21_at_04_48_17.png', '2025-08-04', 1, 200, NULL, 0, 'gud', 'admin', 'admin'),
(3, '2025-08-04', '0003/PO/DSE-08/2025', '0001/PO/tokoooo/1/2025', NULL, '30000000.00', NULL, 2, 3000, 'm3', 2, 2, 30000000, '20250801_Screenshot_2025-04-21_at_04_48_17.png', '2025-08-01', 1, 3010, NULL, 0, 'oke', 'admin', 'admin'),
(4, '2025-08-04', '0004/PO/DSE-08/2025', '0003/INV/TOKO-A/5/2025', NULL, '7000000.00', NULL, 2, 200, 'm3', 3, 2, 7000000, '20250805_Screenshot_2025-04-21_at_14_04_26.png', '2025-08-05', 1, 203, NULL, 0, 'ok', 'admin', 'admin'),
(5, '2025-08-04', '0005/PO/DSE-08/2025', '0025/INV/ERICCON-5/2025', NULL, '550000.00', NULL, 2, 500, 'liter', 6, 5, 550000, '20250805_Screenshot_2025-04-21_at_13_37_26.png', '2025-08-05', 1, 500, NULL, 0, 'ok', 'admin', 'admin'),
(6, '2025-08-04', '0006/PO/DSE-08/2025', '0028/INV/ERICCON-5/2025', NULL, '3000000.00', NULL, 1, 600, 'm3', 7, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'admin', 'admin'),
(7, '2025-08-04', NULL, NULL, NULL, NULL, NULL, 0, 100, 'Ton', 11, 11, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'admin', 'admin');

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
(1, 'admin', 'admin', 'admin@dse.co.id', '123', 1, '1', 'Bekasi');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keluar`
--

CREATE TABLE `transaksi_keluar` (
  `recid` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `no_po` varchar(50) DEFAULT NULL,
  `no_invoice` varchar(50) DEFAULT NULL,
  `buktibayar` varchar(255) DEFAULT NULL,
  `hargaPerTon` decimal(15,2) DEFAULT NULL,
  `ppn` decimal(15,2) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `total_harga` decimal(15,2) DEFAULT NULL,
  `pengiriman` varchar(100) DEFAULT NULL,
  `ongkir` decimal(15,2) DEFAULT NULL,
  `penanggung_ongkir` tinyint(1) DEFAULT NULL,
  `tanggal_sampai` date DEFAULT NULL,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `status_pembayaran` tinyint(1) DEFAULT NULL,
  `tgl_byr` date DEFAULT NULL,
  `jumlah_bayar` double DEFAULT NULL,
  `profit` double DEFAULT NULL,
  `profit_bahanbaku` double DEFAULT NULL,
  `sisa_pembayaran` int(11) DEFAULT NULL,
  `sudah_diterima` tinyint(4) NOT NULL,
  `pakai_inventaris` tinyint(1) DEFAULT NULL,
  `inven_id` int(11) DEFAULT NULL,
  `jml_inven` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `tgl_produksi` date DEFAULT NULL,
  `tmpt_produksi_id` int(11) DEFAULT NULL,
  `createdby` varchar(50) DEFAULT NULL,
  `modifiedby` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_keluar`
--

INSERT INTO `transaksi_keluar` (`recid`, `tgl`, `no_po`, `no_invoice`, `buktibayar`, `hargaPerTon`, `ppn`, `qty`, `total_harga`, `pengiriman`, `ongkir`, `penanggung_ongkir`, `tanggal_sampai`, `tgl_jatuh_tempo`, `status_pembayaran`, `tgl_byr`, `jumlah_bayar`, `profit`, `profit_bahanbaku`, `sisa_pembayaran`, `sudah_diterima`, `pakai_inventaris`, `inven_id`, `jml_inven`, `client_id`, `product_id`, `tgl_produksi`, `tmpt_produksi_id`, `createdby`, `modifiedby`) VALUES
(1, '2025-08-04', '0001/PO/BJA/1/2025', '0001/INV/DSE-08/2025', 'PT_Beton_Jaya_Abadi_20250808_Screenshot_2025-04-21_at_14_07_06.png', '1375000.00', '15125.00', '0.10', '137500.00', 'Kurir Internal', '400000.00', 1, '2025-08-08', NULL, 1, '2025-08-08', 138000, 135630, 570, 100, 1, 1, 11, 3, 1, 2, '2025-08-04', 1, 'admin', 'admin'),
(2, '2025-08-04', '0008/PO/BJA/1/2025', '0002/INV/DSE-08/2025', 'PT_Beton_Jaya_Abadi_20250806_Screenshot_2025-04-21_at_13_37_26.png', '1450000.00', '159500.00', '1.00', '1450000.00', 'Kurir Internal', '400000.00', 0, '2025-08-06', '2025-08-08', 1, '2025-08-06', 1450000, 1347300, 24200, 100, 1, 0, NULL, NULL, 1, 1, '2025-08-04', 1, 'admin', 'admin'),
(3, '2025-08-04', '0001/PO/PB/1/2025', '0003/INV/DSE-08/2025', 'CV_Pilar_Beton_20250804_Screenshot_2025-04-21_at_11_49_29.png', '1600000.00', '176000.00', '1.00', '1600000.00', 'Kurir Internal', '500000.00', 0, '2025-08-08', NULL, 1, '2025-08-04', 3000000, 1515600, 16600, 100, 1, 0, NULL, NULL, 4, 9, '2025-08-04', 1, 'admin', 'admin'),
(4, '2025-07-04', NULL, '0004/INV/DSE-08/2025', NULL, '1490000.00', '163900.00', '1.00', '1490000.00', 'Kurir Internal', '400000.00', 0, '2025-07-08', '2025-08-01', 0, NULL, NULL, 1357800, 20700, 100, 0, 0, NULL, NULL, 1, 6, '2025-08-04', 1, 'admin', 'admin'),
(5, '2025-08-04', NULL, '0005/INV/DSE-08/2025', NULL, '1490000.00', '0.00', '3.00', '4470000.00', 'Kurir Internal', '500000.00', 1, '2025-08-08', NULL, 1, NULL, NULL, 4073400, 62100, 100, 0, 1, 12, 1, 9, 6, '2025-08-04', 1, 'admin', 'admin'),
(6, '2025-08-04', NULL, '0006/INV/DSE-08/2025', NULL, '1450000.00', '319000.00', '2.00', '2900000.00', 'Kurir Internal', '400000.00', 1, '2025-08-09', NULL, 1, NULL, NULL, 2694600, 48400, 100, 0, 0, NULL, NULL, 1, 1, '2025-08-04', 1, 'admin', 'admin');

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
(1, 'Zak', 'Zak', 100),
(2, 'm3', 'm3', 50),
(3, 'Kg', 'Kg', 200),
(4, 'Liter', 'Liter', 150),
(5, 'Buah', 'Buah', 300),
(6, 'Ton', 'Ton', 20),
(7, 'Set', 'Set', 75),
(8, 'Roll', 'Roll', 40),
(9, 'Batang', 'Batang', 60),
(10, 'Pasang', 'Pasang', 120);

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
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_bahan_baku`
--
ALTER TABLE `tbl_bahan_baku`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_client`
--
ALTER TABLE `tbl_client`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_formulasi`
--
ALTER TABLE `tbl_formulasi`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `tbl_inventaris`
--
ALTER TABLE `tbl_inventaris`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_relasi_inven`
--
ALTER TABLE `tbl_relasi_inven`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_tmpt_produksi`
--
ALTER TABLE `tbl_tmpt_produksi`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transaksi_bahanbaku`
--
ALTER TABLE `tbl_transaksi_bahanbaku`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `transaksi_keluar_ibfk_4` FOREIGN KEY (`tmpt_produksi_id`) REFERENCES `tbl_tmpt_produksi` (`recid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
