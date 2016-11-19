-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28 Okt 2016 pada 03.17
-- Versi Server: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yudisiumfstrevisi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `agama`
--

CREATE TABLE `agama` (
  `ID_AGAMA` char(3) NOT NULL,
  `AGAMA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `agama`
--

INSERT INTO `agama` (`ID_AGAMA`, `AGAMA`) VALUES
('1IS', 'Islam'),
('2PT', 'Kristen Protestan'),
('3KT', 'Katolik'),
('4HN', 'Hindu'),
('5BD', 'Buddha'),
('6KG', 'Kong Hu Cu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_ruangbaca`
--

CREATE TABLE `anggota_ruangbaca` (
  `NIM_ANGGOTA` varchar(12) NOT NULL,
  `ID_UNIT` varchar(2) NOT NULL,
  `NAMA_ANGGOTA` varchar(100) DEFAULT NULL,
  `ALAMAT_ANGGOTA` varchar(300) DEFAULT NULL,
  `TELPON_ANGGOTA` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cloud_storage`
--

CREATE TABLE `cloud_storage` (
  `ID_CLOUD` char(1) NOT NULL,
  `CLOUD_STORAGE` varchar(20) DEFAULT NULL,
  `STATUS_CLOUD` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cloud_storage`
--

INSERT INTO `cloud_storage` (`ID_CLOUD`, `CLOUD_STORAGE`, `STATUS_CLOUD`) VALUES
('1', 'Dropbox', '0'),
('2', 'Google Drive', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_file`
--

CREATE TABLE `detail_file` (
  `NIM` varchar(12) NOT NULL,
  `ID_FILE` int(11) NOT NULL,
  `ID_CLOUD` char(1) DEFAULT NULL,
  `FILE_ALUMNI` varchar(100) DEFAULT NULL,
  `KETERANGAN` varchar(100) DEFAULT NULL,
  `PESAN` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pinjam_buku`
--

CREATE TABLE `detail_pinjam_buku` (
  `ID_PINJAM_BUKU` int(11) NOT NULL,
  `ID_JENIS_PINJAM` varchar(2) NOT NULL,
  `NIP` char(18) NOT NULL,
  `ID_KOLEKSI` int(11) NOT NULL,
  `STATUS_PINJAM` char(1) DEFAULT NULL,
  `TGL_KEMBALI` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_verifikasi`
--

CREATE TABLE `detail_verifikasi` (
  `NIM` varchar(12) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `TGL_DETAIL_VERIFIKASI` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_verifikasi`
--

INSERT INTO `detail_verifikasi` (`NIM`, `USERNAME`, `TGL_DETAIL_VERIFIKASI`) VALUES
('081211631058', 'Kemahasiswaan1', '2016-10-26 04:46:33'),
('081211631058', 'Sisfor01', '2016-10-26 04:46:59'),
('111111111111', 'Sisfor01', '2016-10-25 06:20:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_yudisium`
--

CREATE TABLE `file_yudisium` (
  `ID_FILE` int(11) NOT NULL,
  `ID_JADWAL_YUDISIUM` char(6) NOT NULL,
  `NAMA_FILE` varchar(250) DEFAULT NULL,
  `INISIAL` varchar(10) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `ID_JABATAN` varchar(2) NOT NULL,
  `JABATAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`ID_JABATAN`, `JABATAN`) VALUES
('1', 'Ruang Baca'),
('2', 'Tata Usaha'),
('3', 'Kemahasiswaan'),
('4', 'Akademik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_yudisium`
--

CREATE TABLE `jadwal_yudisium` (
  `ID_JADWAL_YUDISIUM` char(6) NOT NULL,
  `ID_PERIODE_WISUDA` char(5) NOT NULL,
  `YUDISIUM` varchar(100) DEFAULT NULL,
  `TGL_YUDISIUM` date DEFAULT NULL,
  `STATUS_JADWAL_YUDISIUM` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_koleksi`
--

CREATE TABLE `jenis_koleksi` (
  `ID_JENIS_KOLEKSI` varchar(2) NOT NULL,
  `JENIS_KOLEKSI` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_koleksi`
--

INSERT INTO `jenis_koleksi` (`ID_JENIS_KOLEKSI`, `JENIS_KOLEKSI`) VALUES
('1', 'Buku'),
('2', 'Skripsi'),
('3', 'Penelitihan'),
('4', 'Jurnal'),
('5', 'Lain-lain');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pinjam`
--

CREATE TABLE `jenis_pinjam` (
  `ID_JENIS_PINJAM` varchar(2) NOT NULL,
  `JENIS_PINJAM` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_pinjam`
--

INSERT INTO `jenis_pinjam` (`ID_JENIS_PINJAM`, `JENIS_PINJAM`) VALUES
('1', 'Fotocopy'),
('2', 'Membaca'),
('3', 'Pinjam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksi`
--

CREATE TABLE `koleksi` (
  `ID_KOLEKSI` int(11) NOT NULL,
  `ID_JENIS_KOLEKSI` varchar(2) NOT NULL,
  `JUDUL` varchar(250) DEFAULT NULL,
  `PENGARANG` varchar(100) DEFAULT NULL,
  `NO_KLAS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `NIP` char(18) NOT NULL,
  `ID_JABATAN` varchar(2) NOT NULL,
  `ID_UNIT` varchar(2) DEFAULT NULL,
  `NAMA_PEGAWAI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`NIP`, `ID_JABATAN`, `ID_UNIT`, `NAMA_PEGAWAI`) VALUES
('111111111111111111', '4', '1', 'Pegawai Akademik'),
('222222222222222222', '3', '1', 'Pegawai Kemahasiswaan'),
('333333333333333333', '1', '1', 'Pegawai Ruang Baca'),
('444444444444444444', '2', '7', 'Pegawai Sistem Informasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode_wisuda`
--

CREATE TABLE `periode_wisuda` (
  `ID_PERIODE_WISUDA` char(5) NOT NULL,
  `TGL_WISUDA` date DEFAULT NULL,
  `DESKRIPSI` varchar(500) DEFAULT NULL,
  `STATUS_PERIODE_WISUDA` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjam`
--

CREATE TABLE `pinjam` (
  `ID_PINJAM_BUKU` int(11) NOT NULL,
  `NIP` char(18) NOT NULL,
  `NIM_ANGGOTA` varchar(12) NOT NULL,
  `TGL_PINJAM` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit`
--

CREATE TABLE `unit` (
  `ID_UNIT` varchar(2) NOT NULL,
  `UNI_ID_UNIT` varchar(2) DEFAULT NULL,
  `UNIT` varchar(100) DEFAULT NULL,
  `KETERANGAN_UNIT` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `unit`
--

INSERT INTO `unit` (`ID_UNIT`, `UNI_ID_UNIT`, `UNIT`, `KETERANGAN_UNIT`) VALUES
('1', '1', 'Fakultas Sains Teknologi', 'Fakultas'),
('10', '3', 'S1 Teknobiomedik', 'Prodi'),
('11', '4', 'S1 Kimia', 'Prodi'),
('12', '4', 'S2 Kimia', 'Prodi'),
('13', '5', 'S1 Biologi', 'Prodi'),
('14', '5', 'S2 Biologi', 'Prodi'),
('15', '5', 'S1 Ilmu dan Teknologi Lingkungan', 'Prodi'),
('16', '1', 'S3 MIPA', 'Prodi'),
('2', '2', 'Departemen Matematika', 'Departemen'),
('3', '3', 'Departemen Fisika', 'Departemen'),
('4', '4', 'Departemen Kimia', 'Departemen'),
('5', '5', 'Departemen Biologi', 'Departemen'),
('6', '2', 'S1 Matematika', 'Prodi'),
('7', '2', 'S1 Sistem Informasi', 'Prodi'),
('8', '2', 'S1 Statistika', 'Prodi'),
('9', '3', 'S1 Fisika', 'Prodi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_account`
--

CREATE TABLE `user_account` (
  `USERNAME` varchar(50) NOT NULL,
  `NIP` char(18) DEFAULT NULL,
  `PASSWORD` char(32) DEFAULT NULL,
  `IMAGE` varchar(100) DEFAULT NULL,
  `AKTIVASI` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_account`
--

INSERT INTO `user_account` (`USERNAME`, `NIP`, `PASSWORD`, `IMAGE`, `AKTIVASI`) VALUES
('Akademik1', '111111111111111111', '6f2993b6b9a0b6f7dc7e8cff6a8c9972', NULL, '1'),
('Kemahasiswaan1', '222222222222222222', '267716087d91902a974ee04ae63cd944', NULL, '1'),
('RuangBaca1', '333333333333333333', '0b0e2087c00ad1f5d934730688e941b6', NULL, '1'),
('Sisfor01', '444444444444444444', 'edfab145516102da836f588b18fbe034', NULL, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wisudawan`
--

CREATE TABLE `wisudawan` (
  `NIM` varchar(12) NOT NULL,
  `ID_UNIT` varchar(2) NOT NULL,
  `ID_JADWAL_YUDISIUM` char(6) NOT NULL,
  `ID_AGAMA` char(3) NOT NULL,
  `PASSWORD_TEMP` varchar(8) DEFAULT NULL,
  `JENIS_KELAMIN` varchar(1) DEFAULT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `TGL_TERDAFTAR` date DEFAULT NULL,
  `TGL_LULUS` date DEFAULT NULL,
  `NO_IJAZAH` varchar(50) DEFAULT NULL,
  `IPK` varchar(4) DEFAULT NULL,
  `SKS` int(11) DEFAULT NULL,
  `ELPT` int(11) DEFAULT NULL,
  `SKP` int(11) DEFAULT NULL,
  `BIDANG_ILMU` varchar(100) DEFAULT NULL,
  `JUDUL_SKRIPSI` varchar(500) DEFAULT NULL,
  `DOSEN_PEMBIMBING_1` varchar(100) DEFAULT NULL,
  `DOSEN_PEMBIMBING_2` varchar(100) DEFAULT NULL,
  `TEMPAT_LAHIR` varchar(50) DEFAULT NULL,
  `TANGGAL_LAHIR` date DEFAULT NULL,
  `ALAMAT` varchar(250) DEFAULT NULL,
  `TELPON` varchar(25) DEFAULT NULL,
  `NAMA_ORTU` varchar(100) DEFAULT NULL,
  `ALAMAT_ORTU` varchar(250) DEFAULT NULL,
  `TELPON_ORTU` varchar(25) DEFAULT NULL,
  `VERIFIKASI` varchar(1) DEFAULT NULL,
  `VERIFIKASI_AK` varchar(1) DEFAULT NULL,
  `TGL_DAFTAR_YUDISIUM` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`ID_AGAMA`),
  ADD UNIQUE KEY `AGAMA_PK` (`ID_AGAMA`);

--
-- Indexes for table `anggota_ruangbaca`
--
ALTER TABLE `anggota_ruangbaca`
  ADD PRIMARY KEY (`NIM_ANGGOTA`),
  ADD UNIQUE KEY `ANGGOTA_RUANGBACA_PK` (`NIM_ANGGOTA`),
  ADD KEY `RELATIONSHIP_1_FK` (`ID_UNIT`);

--
-- Indexes for table `cloud_storage`
--
ALTER TABLE `cloud_storage`
  ADD PRIMARY KEY (`ID_CLOUD`),
  ADD UNIQUE KEY `CLOUD_STORAGE_PK` (`ID_CLOUD`);

--
-- Indexes for table `detail_file`
--
ALTER TABLE `detail_file`
  ADD PRIMARY KEY (`NIM`,`ID_FILE`),
  ADD KEY `RELATIONSHIP_18_FK` (`NIM`),
  ADD KEY `RELATIONSHIP_19_FK` (`ID_FILE`),
  ADD KEY `RELATIONSHIP_34_FK` (`ID_CLOUD`);

--
-- Indexes for table `detail_pinjam_buku`
--
ALTER TABLE `detail_pinjam_buku`
  ADD KEY `RELATIONSHIP_28_FK` (`ID_PINJAM_BUKU`),
  ADD KEY `RELATIONSHIP_29_FK` (`ID_KOLEKSI`),
  ADD KEY `RELATIONSHIP_31_FK` (`ID_JENIS_PINJAM`),
  ADD KEY `RELATIONSHIP_33_FK` (`NIP`);

--
-- Indexes for table `detail_verifikasi`
--
ALTER TABLE `detail_verifikasi`
  ADD PRIMARY KEY (`NIM`,`USERNAME`),
  ADD KEY `RELATIONSHIP_24_FK` (`NIM`),
  ADD KEY `RELATIONSHIP_25_FK` (`USERNAME`);

--
-- Indexes for table `file_yudisium`
--
ALTER TABLE `file_yudisium`
  ADD PRIMARY KEY (`ID_FILE`),
  ADD UNIQUE KEY `FILE_YUDISIUM_PK` (`ID_FILE`),
  ADD KEY `RELATIONSHIP_22_FK` (`ID_JADWAL_YUDISIUM`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`ID_JABATAN`),
  ADD UNIQUE KEY `JABATAN_PK` (`ID_JABATAN`);

--
-- Indexes for table `jadwal_yudisium`
--
ALTER TABLE `jadwal_yudisium`
  ADD PRIMARY KEY (`ID_JADWAL_YUDISIUM`),
  ADD UNIQUE KEY `JADWAL_YUDISIUM_PK` (`ID_JADWAL_YUDISIUM`),
  ADD KEY `RELATIONSHIP_20_FK` (`ID_PERIODE_WISUDA`);

--
-- Indexes for table `jenis_koleksi`
--
ALTER TABLE `jenis_koleksi`
  ADD PRIMARY KEY (`ID_JENIS_KOLEKSI`),
  ADD UNIQUE KEY `KOLEKSI_PK` (`ID_JENIS_KOLEKSI`);

--
-- Indexes for table `jenis_pinjam`
--
ALTER TABLE `jenis_pinjam`
  ADD PRIMARY KEY (`ID_JENIS_PINJAM`),
  ADD UNIQUE KEY `JENIS_PINJAM_PK` (`ID_JENIS_PINJAM`);

--
-- Indexes for table `koleksi`
--
ALTER TABLE `koleksi`
  ADD PRIMARY KEY (`ID_KOLEKSI`),
  ADD UNIQUE KEY `KOLEKSI_PK` (`ID_KOLEKSI`),
  ADD KEY `RELATIONSHIP_30_FK` (`ID_JENIS_KOLEKSI`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`NIP`),
  ADD UNIQUE KEY `PEGAWAI_PK` (`NIP`),
  ADD KEY `RELATIONSHIP_15_FK` (`ID_JABATAN`),
  ADD KEY `RELATIONSHIP_23_FK` (`ID_UNIT`);

--
-- Indexes for table `periode_wisuda`
--
ALTER TABLE `periode_wisuda`
  ADD PRIMARY KEY (`ID_PERIODE_WISUDA`),
  ADD UNIQUE KEY `PERIODE_WISUDA_PK` (`ID_PERIODE_WISUDA`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`ID_PINJAM_BUKU`),
  ADD UNIQUE KEY `ENTITY_7_PK` (`ID_PINJAM_BUKU`),
  ADD KEY `RELATIONSHIP_27_FK` (`NIM_ANGGOTA`),
  ADD KEY `RELATIONSHIP_32_FK` (`NIP`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`ID_UNIT`),
  ADD UNIQUE KEY `PRODI_PK` (`ID_UNIT`),
  ADD KEY `RELATIONSHIP_26_FK` (`UNI_ID_UNIT`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`USERNAME`),
  ADD UNIQUE KEY `USER_ACCOUNT_PK` (`USERNAME`),
  ADD KEY `RELATIONSHIP_17_FK` (`NIP`);

--
-- Indexes for table `wisudawan`
--
ALTER TABLE `wisudawan`
  ADD PRIMARY KEY (`NIM`),
  ADD UNIQUE KEY `ALUMNI_PK` (`NIM`),
  ADD KEY `RELATIONSHIP_16_FK` (`ID_UNIT`),
  ADD KEY `RELATIONSHIP_10_FK` (`ID_AGAMA`),
  ADD KEY `RELATIONSHIP_21_FK` (`ID_JADWAL_YUDISIUM`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota_ruangbaca`
--
ALTER TABLE `anggota_ruangbaca`
  ADD CONSTRAINT `FK_ANGGOTA__RELATIONS_UNIT` FOREIGN KEY (`ID_UNIT`) REFERENCES `unit` (`ID_UNIT`);

--
-- Ketidakleluasaan untuk tabel `detail_file`
--
ALTER TABLE `detail_file`
  ADD CONSTRAINT `FK_DETAIL_F_RELATIONS_CLOUD_ST` FOREIGN KEY (`ID_CLOUD`) REFERENCES `cloud_storage` (`ID_CLOUD`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DETAIL_F_RELATIONS_FILE_YUD` FOREIGN KEY (`ID_FILE`) REFERENCES `file_yudisium` (`ID_FILE`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DETAIL_F_RELATIONS_WISUDAWA` FOREIGN KEY (`NIM`) REFERENCES `wisudawan` (`NIM`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pinjam_buku`
--
ALTER TABLE `detail_pinjam_buku`
  ADD CONSTRAINT `FK_DETAIL_P_RELATIONS_JENIS_PI` FOREIGN KEY (`ID_JENIS_PINJAM`) REFERENCES `jenis_pinjam` (`ID_JENIS_PINJAM`),
  ADD CONSTRAINT `FK_DETAIL_P_RELATIONS_KOLEKSI` FOREIGN KEY (`ID_KOLEKSI`) REFERENCES `koleksi` (`ID_KOLEKSI`),
  ADD CONSTRAINT `FK_DETAIL_P_RELATIONS_PEGAWAI` FOREIGN KEY (`NIP`) REFERENCES `pegawai` (`NIP`),
  ADD CONSTRAINT `FK_DETAIL_P_RELATIONS_PINJAM` FOREIGN KEY (`ID_PINJAM_BUKU`) REFERENCES `pinjam` (`ID_PINJAM_BUKU`);

--
-- Ketidakleluasaan untuk tabel `detail_verifikasi`
--
ALTER TABLE `detail_verifikasi`
  ADD CONSTRAINT `FK_DETAIL_V_RELATIONS_USER_ACC` FOREIGN KEY (`USERNAME`) REFERENCES `user_account` (`USERNAME`),
  ADD CONSTRAINT `FK_DETAIL_V_RELATIONS_WISUDAWA` FOREIGN KEY (`NIM`) REFERENCES `wisudawan` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `file_yudisium`
--
ALTER TABLE `file_yudisium`
  ADD CONSTRAINT `FK_FILE_YUD_RELATIONS_JADWAL_Y` FOREIGN KEY (`ID_JADWAL_YUDISIUM`) REFERENCES `jadwal_yudisium` (`ID_JADWAL_YUDISIUM`);

--
-- Ketidakleluasaan untuk tabel `jadwal_yudisium`
--
ALTER TABLE `jadwal_yudisium`
  ADD CONSTRAINT `FK_JADWAL_Y_RELATIONS_PERIODE_` FOREIGN KEY (`ID_PERIODE_WISUDA`) REFERENCES `periode_wisuda` (`ID_PERIODE_WISUDA`);

--
-- Ketidakleluasaan untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  ADD CONSTRAINT `FK_KOLEKSI_RELATIONS_JENIS_KO` FOREIGN KEY (`ID_JENIS_KOLEKSI`) REFERENCES `jenis_koleksi` (`ID_JENIS_KOLEKSI`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `FK_PEGAWAI_RELATIONS_JABATAN` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  ADD CONSTRAINT `FK_PEGAWAI_RELATIONS_UNIT` FOREIGN KEY (`ID_UNIT`) REFERENCES `unit` (`ID_UNIT`);

--
-- Ketidakleluasaan untuk tabel `pinjam`
--
ALTER TABLE `pinjam`
  ADD CONSTRAINT `FK_PINJAM_RELATIONS_ANGGOTA_` FOREIGN KEY (`NIM_ANGGOTA`) REFERENCES `anggota_ruangbaca` (`NIM_ANGGOTA`),
  ADD CONSTRAINT `FK_PINJAM_RELATIONS_PEGAWAI` FOREIGN KEY (`NIP`) REFERENCES `pegawai` (`NIP`);

--
-- Ketidakleluasaan untuk tabel `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_UNIT_RELATIONS_UNIT` FOREIGN KEY (`UNI_ID_UNIT`) REFERENCES `unit` (`ID_UNIT`);

--
-- Ketidakleluasaan untuk tabel `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `FK_USER_ACC_RELATIONS_PEGAWAI` FOREIGN KEY (`NIP`) REFERENCES `pegawai` (`NIP`);

--
-- Ketidakleluasaan untuk tabel `wisudawan`
--
ALTER TABLE `wisudawan`
  ADD CONSTRAINT `FK_WISUDAWA_RELATIONS_AGAMA` FOREIGN KEY (`ID_AGAMA`) REFERENCES `agama` (`ID_AGAMA`),
  ADD CONSTRAINT `FK_WISUDAWA_RELATIONS_JADWAL_Y` FOREIGN KEY (`ID_JADWAL_YUDISIUM`) REFERENCES `jadwal_yudisium` (`ID_JADWAL_YUDISIUM`),
  ADD CONSTRAINT `FK_WISUDAWA_RELATIONS_UNIT` FOREIGN KEY (`ID_UNIT`) REFERENCES `unit` (`ID_UNIT`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
