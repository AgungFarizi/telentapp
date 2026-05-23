-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Bulan Mei 2026 pada 18.20
-- Versi server: 5.7.39
-- Versi PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `telent_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_token_admin`
--

CREATE TABLE `akses_token_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_target` enum('hrd','manager','pembimbing_lapang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sudah_dipakai` tinyint(1) NOT NULL DEFAULT '0',
  `dipakai_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `dipakai_pada` timestamp NULL DEFAULT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `akses_token_admin`
--

INSERT INTO `akses_token_admin` (`id`, `token`, `role_target`, `keterangan`, `sudah_dipakai`, `dipakai_oleh`, `dipakai_pada`, `dibuat_oleh`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 'MQ5GZJ3Z-NIM4HHC9-OSQ1YXIL', 'hrd', 'Token sample untuk registrasi HRD', 0, NULL, NULL, 1, '2026-06-09 15:55:26', '2026-05-10 15:55:26', '2026-05-10 15:55:26'),
(2, 'IXSFFD7P-JSWFQYNH-2MSAOHGR', 'manager', 'Token sample untuk registrasi Manager', 0, NULL, NULL, 1, '2026-06-09 15:55:26', '2026-05-10 15:55:26', '2026-05-10 15:55:26'),
(3, 'FS21B5F9-AK4BUI2L-FWSVFH1S', 'pembimbing_lapang', 'Token sample untuk registrasi Pembimbing', 0, NULL, NULL, 1, '2026-06-09 15:55:26', '2026-05-10 15:55:26', '2026-05-10 15:55:26'),
(4, 'AQEKG57K-9LWH6CJO-JOVSXE66', 'manager', NULL, 0, NULL, NULL, 1, '2026-06-10 18:31:47', '2026-05-11 18:31:47', '2026-05-11 18:31:47'),
(5, '0PRP1BOG-IG4XIVIB-LTOGJRXR', 'manager', NULL, 0, NULL, NULL, 1, '2026-06-10 18:37:15', '2026-05-11 18:37:15', '2026-05-11 18:37:15'),
(6, 'RXKBNJQ4-E7PU5LFI-JZIJLL2P', 'manager', NULL, 1, 7, '2026-05-14 14:19:51', 1, '2026-05-15 14:18:02', '2026-05-14 14:18:02', '2026-05-14 14:19:51'),
(7, 'IG8EY90W-K1BP8EZB-X9AXROSI', 'pembimbing_lapang', 'Pembimbing Lapang DID', 0, NULL, NULL, 1, '2026-05-25 13:53:50', '2026-05-22 13:53:50', '2026-05-22 13:53:50'),
(8, 'CFGRKQO4-WHCSMSWD-E1UYAOGT', 'pembimbing_lapang', 'Pembimbing Lapang DID', 1, 14, '2026-05-22 13:55:53', 1, '2026-05-25 13:53:51', '2026-05-22 13:53:51', '2026-05-22 13:55:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_proposal`
--

CREATE TABLE `anggota_proposal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `universitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adalah_ketua` tinyint(1) NOT NULL DEFAULT '0',
  `status_akun` enum('menunggu','aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `anggota_proposal`
--

INSERT INTO `anggota_proposal` (`id`, `proposal_id`, `mahasiswa_id`, `nama_lengkap`, `nim`, `universitas`, `jurusan`, `semester`, `no_hp`, `email`, `adalah_ketua`, `status_akun`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'Agung farizi', '3243255', 'Universitas Lampung', 'Teknik Kimia', '5', '08797897686', 'agungfarizi@gmail.com', 1, 'aktif', '2026-05-12 13:10:26', '2026-05-12 13:10:26'),
(2, 2, 13, 'DIIKA ANDRIAN', '3451345', 'Politeknik Negeri Lampung', 'D3 Manajemen Informatika', '5', '0896323345665', 'dikaandrian@gmail.com', 1, 'aktif', '2026-05-22 13:51:01', '2026-05-22 13:51:01'),
(3, 2, 15, 'Nurindah Safitri', '24324235', 'Universitas Lampung', 'Teknik Informatika', '5', NULL, 'nurindahsafitri@gmail.com', 0, 'aktif', '2026-05-22 13:51:01', '2026-05-22 13:57:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` timestamp NOT NULL,
  `sudah_diverifikasi` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `pengguna_id`, `token`, `expired_at`, `sudah_diverifikasi`, `created_at`, `updated_at`) VALUES
(1, 4, 'YAxGAbjXNyvYKtFdndRRDROFV8z5WIE4jRBhZqpY4B87JBJTF1A84aROiYiyAuHE', '2026-05-13 08:16:47', 0, '2026-05-12 08:16:47', '2026-05-12 08:16:47'),
(2, 5, '88YZ5CuwPLooffHY2asSVT0imjok6Vj4n0MVXDxhQecEiW4LOonKIztXy4azNJVm', '2026-05-13 12:57:00', 1, '2026-05-12 12:57:00', '2026-05-12 12:57:20'),
(3, 7, 'TErXLXEaaOIxJC75LA8PzW3qG3SaIqDIy8BE7HVYW9ZpqCKSVZP2Rnhjk1WtT2YQ', '2026-05-15 14:19:51', 1, '2026-05-14 14:19:51', '2026-05-14 14:20:11'),
(6, 13, 'F8mntuLf782jP9fYQjofEAjAFijrpCKe2AC6NzoZZQaavQyXu0QO4MKNIBl3IZ5f', '2026-05-23 06:44:06', 1, '2026-05-22 06:44:06', '2026-05-22 06:44:15'),
(7, 14, '6hSqAVjRGubQPWM6oV81K2SBCM6PCAMrr6sdYFr8e2QgO1ZwbN2XHBvqNIjA0yWx', '2026-05-23 13:55:53', 1, '2026-05-22 13:55:53', '2026-05-22 13:56:05'),
(8, 16, 'VhIeTyszVOpo4BGPlOZT1VNMiMdPX1zPak4I3BXyWyikJsBOJukEp7qiSbfmUOQl', '2026-05-24 13:34:18', 1, '2026-05-23 13:34:18', '2026-05-23 13:34:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `foto_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_keluar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude_masuk` decimal(10,8) DEFAULT NULL,
  `longitude_masuk` decimal(11,8) DEFAULT NULL,
  `latitude_keluar` decimal(10,8) DEFAULT NULL,
  `longitude_keluar` decimal(11,8) DEFAULT NULL,
  `status` enum('hadir','tidak_hadir','izin','sakit','terlambat','menunggu_verifikasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `status_verifikasi` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `verifikator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `catatan_verifikasi` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kehadiran`
--

INSERT INTO `kehadiran` (`id`, `mahasiswa_id`, `proposal_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `foto_masuk`, `foto_keluar`, `latitude_masuk`, `longitude_masuk`, `latitude_keluar`, `longitude_keluar`, `status`, `status_verifikasi`, `verifikator_id`, `tanggal_verifikasi`, `catatan_verifikasi`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2026-05-12', '20:15:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'terlambat', 'menunggu', NULL, NULL, NULL, NULL, '2026-05-12 13:15:13', '2026-05-12 13:15:13'),
(2, 5, 1, '2026-05-14', '21:28:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'terlambat', 'menunggu', NULL, NULL, NULL, NULL, '2026-05-14 14:28:17', '2026-05-14 14:28:17'),
(3, 5, 1, '2026-05-21', '22:13:39', '22:13:42', NULL, NULL, NULL, NULL, NULL, NULL, 'terlambat', 'menunggu', NULL, NULL, NULL, NULL, '2026-05-21 15:13:39', '2026-05-21 15:13:42'),
(4, 13, 2, '2026-05-22', '21:56:22', '22:44:19', NULL, NULL, NULL, NULL, -4.80163500, 105.22430600, 'terlambat', 'disetujui', 14, '2026-05-22 16:02:19', NULL, NULL, '2026-05-22 14:56:22', '2026-05-22 16:02:19'),
(5, 13, 2, '2026-05-23', '13:21:45', '14:37:04', NULL, NULL, NULL, NULL, NULL, NULL, 'terlambat', 'disetujui', 14, '2026-05-23 13:02:11', NULL, NULL, '2026-05-23 06:21:45', '2026-05-23 13:02:11'),
(6, 13, 2, '2026-05-24', '01:01:07', NULL, 'kehadiran/foto/EKrHH2PFMQ426qeArQwVGMDuLJjZQA37plTsm3Zf.png', NULL, NULL, NULL, NULL, NULL, 'hadir', 'disetujui', 14, '2026-05-23 18:03:23', NULL, 'AZIZI GILANG - HADIR', '2026-05-23 18:01:07', '2026-05-23 18:03:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_harian`
--

CREATE TABLE `log_harian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mahasiswa_id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `kehadiran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `kegiatan_dilakukan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasil_kegiatan` text COLLATE utf8mb4_unicode_ci,
  `kendala` text COLLATE utf8mb4_unicode_ci,
  `rencana_besok` text COLLATE utf8mb4_unicode_ci,
  `file_dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('menunggu','disetujui','ditolak','revisi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `verifikator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` timestamp NULL DEFAULT NULL,
  `feedback_pembimbing` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_harian`
--

INSERT INTO `log_harian` (`id`, `mahasiswa_id`, `proposal_id`, `kehadiran_id`, `tanggal`, `kegiatan_dilakukan`, `hasil_kegiatan`, `kendala`, `rencana_besok`, `file_dokumentasi`, `status_verifikasi`, `verifikator_id`, `tanggal_verifikasi`, `feedback_pembimbing`, `created_at`, `updated_at`) VALUES
(1, 13, 2, 4, '2026-05-22', 'Upload log harian PDF', NULL, NULL, NULL, 'log-harian/0ACnpH32Ljsj5jJNXk3Ebf9m5enWvnUNn1V4enTv.pdf', 'disetujui', 14, '2026-05-22 16:29:53', NULL, '2026-05-22 16:16:26', '2026-05-22 16:29:53'),
(2, 13, 2, 5, '2026-05-23', 'Upload log harian PDF', NULL, NULL, NULL, 'log-harian/dokumentasi/i58BD5u8918dJlzAI4VMahCw3VgM5pIp8IG0mSOi.pdf', 'disetujui', 14, '2026-05-23 13:08:00', NULL, '2026-05-23 06:57:08', '2026-05-23 13:08:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000004_create_akses_token_admin_table', 1),
(5, '2024_01_01_000005_create_pengguna_table', 1),
(6, '2024_01_01_000006_create_periode_magang_table', 1),
(7, '2024_01_01_000007_create_proposal_table', 1),
(8, '2024_01_01_000008_create_kehadiran_log_table', 1),
(9, '2024_01_01_000009_create_surat_notifikasi_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('proposal_diajukan','proposal_disetujui','proposal_ditolak','proposal_diteruskan','kehadiran_diverifikasi','log_diverifikasi','surat_balasan','akun_dibuat','periode_dibuka','sistem') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sistem',
  `url_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `dibaca_pada` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `pengguna_id`, `judul`, `pesan`, `jenis`, `url_tujuan`, `notifiable_type`, `notifiable_id`, `sudah_dibaca`, `dibaca_pada`, `created_at`, `updated_at`) VALUES
(1, 1, 'Proposal Baru Masuk', 'Proposal baru dari Agung farizi (3243255) telah diajukan.', 'proposal_diajukan', 'http://127.0.0.1:8000/hrd/proposal/1', 'App\\Models\\Proposal', 1, 0, NULL, '2026-05-12 13:10:26', '2026-05-12 13:10:26'),
(2, 2, 'Proposal Magang Disetujui', 'Proposal TELENT/2026/05/0001 dari Agung farizi telah disetujui HRD.', 'proposal_disetujui', 'http://127.0.0.1:8000/manager/proposal/1', 'App\\Models\\Proposal', 1, 0, NULL, '2026-05-12 13:13:48', '2026-05-12 13:13:48'),
(3, 5, 'Proposal Disetujui! 🎉', 'Selamat! Proposal TELENT/2026/05/0001 Anda telah disetujui oleh HRD.', 'proposal_disetujui', 'http://127.0.0.1:8000/mahasiswa/proposal/1', 'App\\Models\\Proposal', 1, 1, '2026-05-12 13:16:44', '2026-05-12 13:13:48', '2026-05-12 13:16:44'),
(4, 1, 'Proposal Baru Masuk', 'Proposal baru dari DIIKA ANDRIAN (3451345) telah diajukan.', 'proposal_diajukan', 'http://127.0.0.1:8000/hrd/proposal/2', 'App\\Models\\Proposal', 2, 0, NULL, '2026-05-22 13:51:01', '2026-05-22 13:51:01'),
(5, 7, 'Proposal Magang Disetujui', 'Proposal TELENT/2026/05/0002 dari DIIKA ANDRIAN telah disetujui HRD.', 'proposal_disetujui', 'http://127.0.0.1:8000/manager/proposal/2', 'App\\Models\\Proposal', 2, 0, NULL, '2026-05-22 14:02:00', '2026-05-22 14:02:00'),
(6, 13, 'Proposal Disetujui! 🎉', 'Selamat! Proposal TELENT/2026/05/0002 Anda telah disetujui oleh HRD.', 'proposal_disetujui', 'http://127.0.0.1:8000/mahasiswa/proposal/2', 'App\\Models\\Proposal', 2, 1, '2026-05-22 14:07:44', '2026-05-22 14:02:00', '2026-05-22 14:07:44'),
(7, 13, 'Surat Balasan Tersedia', 'Surat balasan untuk proposal TELENT/2026/05/0002 telah tersedia.', 'surat_balasan', 'http://127.0.0.1:8000/mahasiswa/surat-balasan', 'App\\Models\\SuratBalasan', 8, 1, '2026-05-22 14:07:44', '2026-05-22 14:06:29', '2026-05-22 14:07:44'),
(8, 13, 'Kehadiran Diverifikasi', 'Kehadiran Anda pada 22 May 2026 telah disetujui oleh pembimbing.', 'kehadiran_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/kehadiran', 'App\\Models\\Kehadiran', 4, 1, '2026-05-22 16:02:51', '2026-05-22 16:02:19', '2026-05-22 16:02:51'),
(9, 14, 'Log Harian Baru', 'DIIKA ANDRIAN telah mengupload log harian.', 'log_diverifikasi', 'http://127.0.0.1:8000/pembimbing/log-harian', 'App\\Models\\Notifikasi', 0, 0, NULL, '2026-05-22 16:16:26', '2026-05-22 16:16:26'),
(10, 13, 'Log Harian Diverifikasi', 'Log harian Anda pada 22 May 2026 telah disetujui oleh pembimbing.', 'log_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/log-harian', 'App\\Models\\LogHarian', 1, 1, '2026-05-22 16:33:56', '2026-05-22 16:29:53', '2026-05-22 16:33:56'),
(11, 13, 'Surat Balasan Tersedia', 'Surat balasan untuk proposal TELENT/2026/05/0002 telah tersedia.', 'surat_balasan', 'http://127.0.0.1:8000/mahasiswa/surat-balasan', 'App\\Models\\SuratBalasan', 9, 1, '2026-05-23 13:06:04', '2026-05-23 06:20:52', '2026-05-23 13:06:04'),
(12, 13, 'Surat Balasan Tersedia', 'Surat balasan untuk proposal TELENT/2026/05/0002 telah tersedia.', 'surat_balasan', 'http://127.0.0.1:8000/mahasiswa/surat-balasan', 'App\\Models\\SuratBalasan', 10, 1, '2026-05-23 13:06:04', '2026-05-23 06:46:52', '2026-05-23 13:06:04'),
(13, 14, 'Log Harian Baru', 'DIIKA ANDRIAN telah mengupload log harian.', 'log_diverifikasi', 'http://127.0.0.1:8000/pembimbing/log-harian', 'App\\Models\\Notifikasi', 0, 0, NULL, '2026-05-23 06:57:08', '2026-05-23 06:57:08'),
(14, 13, 'Kehadiran Diverifikasi', 'Kehadiran Anda pada 23 May 2026 telah disetujui oleh pembimbing.', 'kehadiran_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/kehadiran', 'App\\Models\\Kehadiran', 5, 1, '2026-05-23 13:06:04', '2026-05-23 13:02:11', '2026-05-23 13:06:04'),
(15, 13, 'Log Harian Diverifikasi', 'Log harian Anda pada 23 May 2026 telah diminta revisi oleh pembimbing.', 'log_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/log-harian', 'App\\Models\\LogHarian', 2, 1, '2026-05-23 13:06:04', '2026-05-23 13:02:41', '2026-05-23 13:06:04'),
(16, 13, 'Log Harian Diverifikasi', 'Log harian Anda pada 23 May 2026 telah disetujui oleh pembimbing.', 'log_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/log-harian', 'App\\Models\\LogHarian', 2, 0, NULL, '2026-05-23 13:08:00', '2026-05-23 13:08:00'),
(17, 13, 'Kehadiran Diverifikasi', 'Kehadiran Anda pada 24 May 2026 telah disetujui oleh pembimbing.', 'kehadiran_diverifikasi', 'http://127.0.0.1:8000/mahasiswa/kehadiran', 'App\\Models\\Kehadiran', 6, 0, NULL, '2026-05-23 18:03:23', '2026-05-23 18:03:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('hrd','manager','pembimbing_lapang','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_akun` enum('aktif','nonaktif','menunggu_verifikasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_verifikasi',
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `universitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_induk_karyawan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembimbing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `token_admin_dipakai` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_lengkap`, `email`, `password`, `role`, `status_akun`, `nim`, `universitas`, `jurusan`, `semester`, `no_hp`, `foto_profil`, `divisi`, `jabatan`, `no_induk_karyawan`, `pembimbing_id`, `dibuat_oleh`, `token_admin_dipakai`, `email_verified_at`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'HRD-01', 'hrd@telent.id', '$2y$12$Z46j22faxiVtls2e9AiTauxhlWz50Z5lGVx0nceIIQljerPHoHATG', 'hrd', 'aktif', NULL, NULL, NULL, NULL, '081234567890', 'profil/foto/7jlxw7hrRZ8k269LgkjwVoTYbC4PORL3mvrXUFXf.jpg', 'Human Resource Department', 'HRD Manager', 'HRD-001', NULL, NULL, NULL, '2026-05-10 15:55:25', 'QvU44bXhBgs8dmtGOtxJ37D2AMvfqL0lb6i1WIumRdLJBY3M7Y886CW89839', NULL, '2026-05-10 15:55:25', '2026-05-20 14:10:38'),
(2, 'Manager TELENT', 'manager@telent.id', '$2y$12$PumgNfZfy8YuRVCc9KW//e4F5D2Bku7Vlg1OhU3hTr3uIIj5DG6AS', 'manager', 'aktif', NULL, NULL, NULL, NULL, '081234567891', NULL, 'Management', 'General Manager', 'MGR-001', NULL, NULL, NULL, '2026-05-10 15:55:25', NULL, '2026-05-20 14:02:49', '2026-05-10 15:55:25', '2026-05-20 14:02:49'),
(3, 'Budi Santoso', 'pembimbing1@telent.id', '$2y$12$vvM0bxPzTblGLTq2nDM55eHgarWZukXjByD8t4sgSNKmHBnrX0sja', 'pembimbing_lapang', 'aktif', NULL, NULL, NULL, NULL, '081234567892', 'profil/foto/dkcsp1Nrm6WqmJ1rBQ6SOwoq1LnDGWOU03BP9lBX.jpg', 'IT Development', 'Senior Developer', 'PBM-001', NULL, NULL, NULL, '2026-05-10 15:55:26', NULL, '2026-05-22 13:53:19', '2026-05-10 15:55:26', '2026-05-22 13:53:19'),
(4, 'Dian Rahma', 'dianrahmapol@gmail.com', '$2y$12$CfAARte5p74HEV8xETRaPO.fhXPlHQqwCCFSCHMe4RvjeJL3GooeO', 'mahasiswa', 'menunggu_verifikasi', '332223134', 'Universitas Lampung', 'Teknik Kimia', '6', '0896767566757', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-12 08:16:47', '2026-05-12 08:16:47'),
(5, 'Agung farizi', 'agungfarizi@gmail.com', '$2y$12$9oNLaPV4llPVP7VDVorU3u870sbb9NjJ3bAS.SD2XeqforsAY/GUe', 'mahasiswa', 'aktif', '3243255', 'Universitas Lampung', 'Teknik Kimia', '5', '08797897686', NULL, NULL, NULL, NULL, 3, NULL, NULL, '2026-05-12 12:57:20', NULL, NULL, '2026-05-12 12:57:00', '2026-05-12 13:13:48'),
(7, 'Manager DID', 'manageradd2@telpp.com', '$2y$12$iOo0l/InFUfr2mcOpA8o/ufcKDasWd6Qd1dz3OGe/s2r6S0RyHSTO', 'manager', 'aktif', NULL, NULL, NULL, NULL, '087876755445', 'profil/HlQL5jFyAUbcNGSprm1ifIj93TlxzLVUoxr45E8A.png', 'ADD', 'Manager', '2345423', NULL, NULL, 'RXKBNJQ4-E7PU5LFI-JZIJLL2P', '2026-05-14 14:20:11', NULL, NULL, '2026-05-14 14:19:51', '2026-05-21 14:30:18'),
(8, 'AHMAD HIDA', 'ahmadhida@gmail.com', '$2y$12$B/EZYphh0VYpoJzNYO97seFVd4aVkONJsZSatIawExzqrkPkWHZtO', 'pembimbing_lapang', 'aktif', NULL, NULL, NULL, NULL, '08984773662', NULL, 'TI', 'Pembimbing Lapang', '2345467', NULL, 1, NULL, '2026-05-20 14:00:38', NULL, '2026-05-22 13:53:23', '2026-05-20 14:00:38', '2026-05-22 13:53:23'),
(13, 'DIIKA ANDRIAN', 'dikaandrian@gmail.com', '$2y$12$melYuuJmltvxk7Rlz3ByYOo3oDndKx.0t/GcXIQhbgGO9rnnrlQEq', 'mahasiswa', 'aktif', '3451345', 'Politeknik Negeri Lampung', 'D3 Manajemen Informatika', '5', '0896323345665', 'profil/foto/U5rGlMxTW25yAdcc4aZ57IAwggnJN98WD3urMH8P.jpg', NULL, NULL, NULL, 14, NULL, NULL, '2026-05-22 06:44:15', NULL, NULL, '2026-05-22 06:44:06', '2026-05-23 07:42:52'),
(14, 'Syahputra DID', 'syahputradid@gmail.com', '$2y$12$KG87F8fruv5M3.I/WWoREuxIzNN7mOPfTB9.a2lZvFKwW3gkmEfl6', 'pembimbing_lapang', 'aktif', NULL, NULL, NULL, NULL, '08967879766', 'profil/foto/o8qAbEwrLDBEDNMiGcbxbdrqR7yCofWPK53E7R85.jpg', 'Digital Inovation Departemen', 'Pembimbing Lapang', '3234231', NULL, NULL, 'CFGRKQO4-WHCSMSWD-E1UYAOGT', '2026-05-22 13:56:05', NULL, NULL, '2026-05-22 13:55:53', '2026-05-22 13:57:01'),
(15, 'Nurindah Safitri', 'nurindahsafitri@gmail.com', '$2y$12$idOjVu70ygameEkA5atxeuWZx.4ewSTVlqloj6jiroOCMkJKdyPCy', 'mahasiswa', 'aktif', '24324235', 'Universitas Lampung', 'Teknik Informatika', '5', NULL, NULL, NULL, NULL, NULL, 14, 1, NULL, '2026-05-22 13:57:58', NULL, NULL, '2026-05-22 13:57:58', '2026-05-22 14:01:59'),
(16, 'SUKA SUKA', 'sukasuka@gmail.com', '$2y$12$lSoBcUE76pjaUgxH5SPe2elko4fvcmrXN7zTr609uCV5N7/LzMWrm', 'mahasiswa', 'aktif', '2242424', 'Institut Teknologi Sumatera', 'Teknik Industri', '6', '08899789667', 'profil/foto/6SfBBERg8AGGOMJCQX2ZCJbdZM7skMRO0CmTM0jl.png', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-23 13:34:30', NULL, NULL, '2026-05-23 13:34:18', '2026-05-23 18:11:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode_magang`
--

CREATE TABLE `periode_magang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai_pendaftaran` date NOT NULL,
  `tanggal_akhir_pendaftaran` date NOT NULL,
  `tanggal_mulai_magang` date NOT NULL,
  `tanggal_akhir_magang` date NOT NULL,
  `kuota_total` int(11) NOT NULL DEFAULT '0',
  `kuota_terisi` int(11) NOT NULL DEFAULT '0',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `persyaratan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','aktif','ditutup','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `dibuat_oleh` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `periode_magang`
--

INSERT INTO `periode_magang` (`id`, `nama_periode`, `tanggal_mulai_pendaftaran`, `tanggal_akhir_pendaftaran`, `tanggal_mulai_magang`, `tanggal_akhir_magang`, `kuota_total`, `kuota_terisi`, `deskripsi`, `persyaratan`, `status`, `dibuat_oleh`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Magang Semester Ganjil 2024/2025', '2026-05-05', '2026-06-04', '2026-06-09', '2026-09-07', 30, 1, 'Program magang semester ganjil tahun akademik 2024/2025. Terbuka untuk mahasiswa aktif semester 5 ke atas.', '1. Mahasiswa aktif minimal semester 5\n2. IPK minimal 2.75\n3. Menyertakan surat pengantar dari kampus\n4. Menyertakan transkrip nilai terakhir\n5. CV terbaru', 'ditutup', 1, '2026-05-10 15:55:26', '2026-05-22 06:28:01', NULL),
(2, 'MAGANG BERSAMA TELPP', '2026-05-22', '2026-05-31', '2026-07-05', '2026-08-05', 20, 4, 'Buruan daftar pengalaman magang anda di PT. Tanjungenim Lestari Pulp and Paper, dan jadikan kami sebagai wadah untuk anda mencari pengalaman magang untuk diri anda.', 'Proposal, Foto BPJS Kesehatan, Pas Foto 2x3, KTP.', 'aktif', 1, '2026-05-11 12:15:10', '2026-05-22 14:01:59', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `proposal`
--

CREATE TABLE `proposal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_proposal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengaju_id` bigint(20) UNSIGNED NOT NULL,
  `periode_id` bigint(20) UNSIGNED NOT NULL,
  `judul_proposal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_kegiatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi_tujuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_proposal_pdf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_surat_pengantar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai_diinginkan` date NOT NULL,
  `tanggal_akhir_diinginkan` date NOT NULL,
  `jumlah_anggota` int(11) NOT NULL DEFAULT '1',
  `status` enum('draft','diajukan','review_hrd','diteruskan_manager','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `reviewer_hrd_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_review_hrd` timestamp NULL DEFAULT NULL,
  `catatan_hrd` text COLLATE utf8mb4_unicode_ci,
  `approver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_approval` timestamp NULL DEFAULT NULL,
  `catatan_approval` text COLLATE utf8mb4_unicode_ci,
  `keputusan_final` enum('disetujui','ditolak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembimbing_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `proposal`
--

INSERT INTO `proposal` (`id`, `nomor_proposal`, `pengaju_id`, `periode_id`, `judul_proposal`, `deskripsi_kegiatan`, `divisi_tujuan`, `file_proposal_pdf`, `file_surat_pengantar`, `tanggal_mulai_diinginkan`, `tanggal_akhir_diinginkan`, `jumlah_anggota`, `status`, `reviewer_hrd_id`, `tanggal_review_hrd`, `catatan_hrd`, `approver_id`, `tanggal_approval`, `catatan_approval`, `keputusan_final`, `pembimbing_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TELENT/2026/05/0001', 5, 1, 'rhy56tju64ji76mn jym jy y', 'Deskripsi keadaan ekonomi adalah narasi faktual mengenai kondisi finansial keluarga, mencakup pendapatan, pengeluaran, pekerjaan orang tua, serta aset, yang digunakan untuk menilai kemampuan ekonomi, terutama dalam persyaratan beasiswa seperti KIP Kuliah. Ini menggambarkan situasi riil untuk menentukan prioritas bantuan.Berikut adalah poin-poin utama dalam mendeskripsikan keadaan ekonomi:Pekerjaan dan Penghasilan: Menjelaskan pekerjaan utama ayah dan ibu, serta perkiraan total pendapatan per bulan.Jumlah Tanggungan: Menyebutkan jumlah saudara kandung yang masih menjadi tanggungan orang tua, terutama yang masih sekolah atau kDeskripsi keadaan ekonomi adalah narasi faktual mengenai kondisi finansial keluarga, mencakup pendapatan, pengeluaran, pekerjaan orang tua, serta aset, yang digunakan untuk menilai kemampuan ekonomi, terutama dalam persyaratan beasiswa seperti KIP Kuliah. Ini menggambarkan situasi riil untuk menentukan prioritas bantuan.Berikut adalah poin-poin utama dalam mendeskripsikan keadaan ekonomi:Pekerjaan dan Penghasilan: Menjelaskan pekerjaan utama ayah dan ibu, serta perkiraan total pendapatan per bulan.Jumlah Tanggungan: Menyebutkan jumlah saudara kandung yang masih menjadi tanggungan orang tua, terutama yang masih sekolah atau k', 'Teknik Kimia', 'proposals/pdf/ub1ZiH3WMGM3jlAG9xwmorpdiNtMaJT8aZOC22mh.pdf', NULL, '2026-05-20', '2026-06-05', 1, 'disetujui', 1, '2026-05-12 13:13:48', 'ok', 1, '2026-05-12 13:13:48', 'ok', 'disetujui', 3, '2026-05-12 13:10:26', '2026-05-12 13:13:48', NULL),
(2, 'TELENT/2026/05/0002', 13, 2, 'Ganti ke Log Driver (Paling Mudah)', 'nternal Server Error\r\n\r\nSymfony\\Component\\Mailer\\Exception\\TransportException\r\nConnection could not be established with host \"127.0.0.1:1025\": stream_socket_client(): Unable to connect to 127.0.0.1:1025 (No connection could be made because the target machine actively refused it)\r\nPOST 127.0.0.1:8000\r\nPHP 8.3.28 — Laravel 11.51.0\r\n\r\nExpand\r\nvendor frames\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:154\r\nstream_socket_client\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:157\r\ninitialize\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:268\r\nstart\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:200\r\ndoSend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\AbstractTransport\r\n:69\r\nsend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:138\r\nsend\r\n\r\nIlluminate\\Mail\\Mailer\r\n:585\r\nsendSymfonyMessage\r\n\r\nIlluminate\\Mail\\Mailer\r\n:332\r\nsend\r\n\r\nIlluminate\\Mail\\MailManager\r\n:622\r\n__call\r\n\r\nIlluminate\\Support\\Facades\\Facade\r\n:361\r\n__callStatic\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:212\r\nkirimEmailVerifikasi\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:54\r\nregisterMahasiswa\r\n\r\nIlluminate\\Routing\\ControllerDispatcher\r\n:47\r\ndispatch\r\n\r\nIlluminate\\Routing\\Route\r\n:266\r\nrunController\r\n\r\nIlluminate\\Routing\\Route\r\n:212\r\nrun\r\n\r\nIlluminate\\Routing\\Router\r\n:808\r\nIlluminate\\Routing\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Auth\\Middleware\\RedirectIfAuthenticated\r\n:35\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Routing\\Middleware\\SubstituteBindings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken\r\n:88\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\View\\Middleware\\ShareErrorsFromSession\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:121\r\nhandleStatefulRequest\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:64\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse\r\n:37\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\EncryptCookies\r\n:75\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Routing\\Router\r\n:807\r\nrunRouteWithinStack\r\n\r\nIlluminate\\Routing\\Router\r\n:786\r\nrunRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:750\r\ndispatchToRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:739\r\ndispatch\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:201\r\nIlluminate\\Foundation\\Http\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull\r\n:31\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TrimStrings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\ValidatePostSize\r\n:27\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance\r\n:110\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\HandleCors\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\TrustProxies\r\n:58\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks\r\n:22\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:176\r\nsendRequestThroughRouter\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:145\r\nhandle\r\n\r\nIlluminate\\Foundation\\Application\r\n:1220\r\nhandleRequest\r\n\r\nC:\\laragon\\www\\telent\\public\\index.php\r\n:17\r\nrequire_once\r\n\r\nC:\\laragon\\www\\telent\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php\r\n:23\r\nC:\\laragon\\www\\telent\\vendor\\symfony\\mailer\\Transport\\Smtp\\Stream\\SocketStream.php :154\r\n        $options[\'ssl\'][\'crypto_method\'] ??= \\STREAM_CRYPTO_METHOD_TLS_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;\r\n        $streamContext = stream_context_create($options);\r\n \r\n        $timeout = $this->getTimeout();\r\n        set_error_handler(function ($type, $msg) {\r\n            throw new TransportException(\\sprintf(\'Connection could not be established with host \"%s\": \', $this->url).$msg);\r\n        });\r\n        try {\r\n            $this->stream = stream_socket_client($this->url, $errno, $errstr, $timeout, \\STREAM_CLIENT_CONNECT, $streamContext);\r\n        } finally {\r\n            restore_error_handler();\r\n        }\r\n \r\n        stream_set_blocking($this->stream, true);\r\n        stream_set_timeout($this->stream, (int) $timeout, (int) (($timeout - (int) $timeout) * 1000000));\r\n        $this->in = &$this->stream;\r\n        $this->out = &$this->stream;\r\nRequest\r\nPOST /daftar\r\nHeaders\r\nhost\r\n127.0.0.1:8000', 'Digital Inovation Departemen', 'proposals/pdf/kKJ0Km7rHn1YuxT9nXagsGGlsCuUhLKNnPAYM881.pdf', 'proposals/surat/xf3YRS91E4ANKtJUcfeSNF7ny2zp6nrth5cCzvaJ.pdf', '2026-06-03', '2026-07-11', 2, 'disetujui', 1, '2026-05-22 14:01:59', 'OK ACC', 1, '2026-05-22 14:01:59', 'OK ACC', 'disetujui', 14, '2026-05-22 13:51:01', '2026-05-22 14:01:59', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8zwg9ZSkdaKjQfBXhOTGfVjg7A4xZPZTHbL8iTal', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVJWM0NuUUd6NnBFV1hBYmxNOEY3ZmRMZXZYTmRkeGZISWJaWWdQYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO30=', 1779460309),
('h6P7d0wVcFso7Y7SETOt5YU9S5Kp3HJgjmBRQDyC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOEtMOUhWVTJRaEx1ZFJYRlllU1dDeHQ4OXFEWkNHV21ZcUowRjVyYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1779460773),
('YnXTLGIM8WUFoSRzcpPkgWMWRqC8b6qLRyIcuYF5', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkFKaThXN3Z6SkZYcDlOOFNXbHU1am04TFJyT0JBaFpvZ3E2eTY4NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYWhhc2lzd2EvbG9nLWhhcmlhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O30=', 1779460851);

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_balasan`
--

CREATE TABLE `surat_balasan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proposal_id` bigint(20) UNSIGNED NOT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('penerimaan','penolakan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perihal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_surat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat` date NOT NULL,
  `dikirim_pada` timestamp NULL DEFAULT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surat_balasan`
--

INSERT INTO `surat_balasan` (`id`, `proposal_id`, `dibuat_oleh`, `jenis`, `nomor_surat`, `perihal`, `isi_surat`, `file_surat`, `tanggal_surat`, `dikirim_pada`, `sudah_dibaca`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/001', 'Penerimaan Magang Mahasiswa', 'jhfdvouwevrou9brwevueribgviruebvibner v ewfnwevhowec dh  uhsubbcug sugcusjfbw90uddb iuwdnowiiuhc', NULL, '2026-05-12', '2026-05-12 13:20:33', 1, '2026-05-12 13:20:33', '2026-05-14 14:28:29'),
(2, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/002', 'Penerimaan Magang Mahasiswa', 'ok', NULL, '2026-05-14', '2026-05-14 14:32:06', 1, '2026-05-14 14:32:06', '2026-05-21 15:13:03'),
(3, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/003', 'Penerimaan Magang Mahasiswa', 'IVH;HHHHHHHHHJVKBVKJDBC IJDFS BJKWDB URWBV NW H  WEDIUGWJDCBJWIBCEJWBECJWBCJWRBVCWC WJKIBCWOUCEJWC EUWEC WOUEGCVUWEC', NULL, '2026-05-20', '2026-05-20 14:12:19', 1, '2026-05-20 14:12:19', '2026-05-21 15:13:03'),
(4, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/004', 'Penerimaan Magang Mahasiswa', 'IVH;HHHHHHHHHJVKBVKJDBC IJDFS BJKWDB URWBV NW H  WEDIUGWJDCBJWIBCEJWBECJWBCJWRBVCWC WJKIBCWOUCEJWC EUWEC WOUEGCVUWEC', NULL, '2026-05-20', '2026-05-20 14:13:20', 1, '2026-05-20 14:13:20', '2026-05-21 15:13:03'),
(5, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/005', 'Penerimaan Magang Mahasiswa', 'IVH;HHHHHHHHHJVKBVKJDBC IJDFS BJKWDB URWBV NW H  WEDIUGWJDCBJWIBCEJWBECJWBCJWRBVCWC WJKIBCWOUCEJWC EUWEC WOUEGCVUWEC', NULL, '2026-05-20', '2026-05-20 14:21:13', 1, '2026-05-20 14:21:13', '2026-05-21 15:13:03'),
(6, 1, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/006', 'Penerimaan Magang Mahasiswa', 'IVH;HHHHHHHHHJVKBVKJDBC IJDFS BJKWDB URWBV NW H  WEDIUGWJDCBJWIBCEJWBECJWBCJWRBVCWC WJKIBCWOUCEJWC EUWEC WOUEGCVUWEC', NULL, '2026-05-20', '2026-05-20 14:22:07', 1, '2026-05-20 14:22:07', '2026-05-21 15:13:03'),
(7, 2, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/007', 'Penerimaan Magang Mahasiswa', 'nternal Server Error\r\n\r\nSymfony\\Component\\Mailer\\Exception\\TransportException\r\nConnection could not be established with host \"127.0.0.1:1025\": stream_socket_client(): Unable to connect to 127.0.0.1:1025 (No connection could be made because the target machine actively refused it)\r\nPOST 127.0.0.1:8000\r\nPHP 8.3.28 — Laravel 11.51.0\r\n\r\nExpand\r\nvendor frames\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:154\r\nstream_socket_client\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:157\r\ninitialize\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:268\r\nstart\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:200\r\ndoSend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\AbstractTransport\r\n:69\r\nsend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:138\r\nsend\r\n\r\nIlluminate\\Mail\\Mailer\r\n:585\r\nsendSymfonyMessage\r\n\r\nIlluminate\\Mail\\Mailer\r\n:332\r\nsend\r\n\r\nIlluminate\\Mail\\MailManager\r\n:622\r\n__call\r\n\r\nIlluminate\\Support\\Facades\\Facade\r\n:361\r\n__callStatic\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:212\r\nkirimEmailVerifikasi\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:54\r\nregisterMahasiswa\r\n\r\nIlluminate\\Routing\\ControllerDispatcher\r\n:47\r\ndispatch\r\n\r\nIlluminate\\Routing\\Route\r\n:266\r\nrunController\r\n\r\nIlluminate\\Routing\\Route\r\n:212\r\nrun\r\n\r\nIlluminate\\Routing\\Router\r\n:808\r\nIlluminate\\Routing\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Auth\\Middleware\\RedirectIfAuthenticated\r\n:35\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Routing\\Middleware\\SubstituteBindings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken\r\n:88\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\View\\Middleware\\ShareErrorsFromSession\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:121\r\nhandleStatefulRequest\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:64\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse\r\n:37\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\EncryptCookies\r\n:75\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Routing\\Router\r\n:807\r\nrunRouteWithinStack\r\n\r\nIlluminate\\Routing\\Router\r\n:786\r\nrunRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:750\r\ndispatchToRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:739\r\ndispatch\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:201\r\nIlluminate\\Foundation\\Http\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull\r\n:31\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TrimStrings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\ValidatePostSize\r\n:27\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance\r\n:110\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\HandleCors\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\TrustProxies\r\n:58\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks\r\n:22\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:176\r\nsendRequestThroughRouter\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:145\r\nhandle\r\n\r\nIlluminate\\Foundation\\Application\r\n:1220\r\nhandleRequest\r\n\r\nC:\\laragon\\www\\telent\\public\\index.php\r\n:17\r\nrequire_once\r\n\r\nC:\\laragon\\www\\telent\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php\r\n:23\r\nC:\\laragon\\www\\telent\\vendor\\symfony\\mailer\\Transport\\Smtp\\Stream\\SocketStream.php :154\r\n        $options[\'ssl\'][\'crypto_method\'] ??= \\STREAM_CRYPTO_METHOD_TLS_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;\r\n        $streamContext = stream_context_create($options);\r\n \r\n        $timeout = $this->getTimeout();\r\n        set_error_handler(function ($type, $msg) {\r\n            throw new TransportException(\\sprintf(\'Connection could not be established with host \"%s\": \', $this->url).$msg);\r\n        });\r\n        try {\r\n            $this->stream = stream_socket_client($this->url, $errno, $errstr, $timeout, \\STREAM_CLIENT_CONNECT, $streamContext);\r\n        } finally {\r\n            restore_error_handler();\r\n        }\r\n \r\n        stream_set_blocking($this->stream, true);\r\n        stream_set_timeout($this->stream, (int) $timeout, (int) (($timeout - (int) $timeout) * 1000000));\r\n        $this->in = &$this->stream;\r\n        $this->out = &$this->stream;\r\nRequest\r\nPOST /daftar\r\nHeaders\r\nhost\r\n127.0.0.1:8000', NULL, '2026-05-22', '2026-05-22 14:02:34', 1, '2026-05-22 14:02:34', '2026-05-22 14:06:56'),
(8, 2, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/008', 'Penerimaan Magang Mahasiswa', 'nternal Server Error\r\n\r\nSymfony\\Component\\Mailer\\Exception\\TransportException\r\nConnection could not be established with host \"127.0.0.1:1025\": stream_socket_client(): Unable to connect to 127.0.0.1:1025 (No connection could be made because the target machine actively refused it)\r\nPOST 127.0.0.1:8000\r\nPHP 8.3.28 — Laravel 11.51.0\r\n\r\nExpand\r\nvendor frames\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:154\r\nstream_socket_client\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream\r\n:157\r\ninitialize\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:268\r\nstart\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:200\r\ndoSend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\AbstractTransport\r\n:69\r\nsend\r\n\r\nSymfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport\r\n:138\r\nsend\r\n\r\nIlluminate\\Mail\\Mailer\r\n:585\r\nsendSymfonyMessage\r\n\r\nIlluminate\\Mail\\Mailer\r\n:332\r\nsend\r\n\r\nIlluminate\\Mail\\MailManager\r\n:622\r\n__call\r\n\r\nIlluminate\\Support\\Facades\\Facade\r\n:361\r\n__callStatic\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:212\r\nkirimEmailVerifikasi\r\n\r\nApp\\Http\\Controllers\\Auth\\RegisterController\r\n:54\r\nregisterMahasiswa\r\n\r\nIlluminate\\Routing\\ControllerDispatcher\r\n:47\r\ndispatch\r\n\r\nIlluminate\\Routing\\Route\r\n:266\r\nrunController\r\n\r\nIlluminate\\Routing\\Route\r\n:212\r\nrun\r\n\r\nIlluminate\\Routing\\Router\r\n:808\r\nIlluminate\\Routing\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Auth\\Middleware\\RedirectIfAuthenticated\r\n:35\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Routing\\Middleware\\SubstituteBindings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken\r\n:88\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\View\\Middleware\\ShareErrorsFromSession\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:121\r\nhandleStatefulRequest\r\n\r\nIlluminate\\Session\\Middleware\\StartSession\r\n:64\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse\r\n:37\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Cookie\\Middleware\\EncryptCookies\r\n:75\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Routing\\Router\r\n:807\r\nrunRouteWithinStack\r\n\r\nIlluminate\\Routing\\Router\r\n:786\r\nrunRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:750\r\ndispatchToRoute\r\n\r\nIlluminate\\Routing\\Router\r\n:739\r\ndispatch\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:201\r\nIlluminate\\Foundation\\Http\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:170\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull\r\n:31\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TransformsRequest\r\n:21\r\nhandle\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\TrimStrings\r\n:51\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\ValidatePostSize\r\n:27\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance\r\n:110\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\HandleCors\r\n:49\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Http\\Middleware\\TrustProxies\r\n:58\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks\r\n:22\r\nhandle\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:209\r\nIlluminate\\Pipeline\\{closure}\r\n\r\nIlluminate\\Pipeline\\Pipeline\r\n:127\r\nthen\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:176\r\nsendRequestThroughRouter\r\n\r\nIlluminate\\Foundation\\Http\\Kernel\r\n:145\r\nhandle\r\n\r\nIlluminate\\Foundation\\Application\r\n:1220\r\nhandleRequest\r\n\r\nC:\\laragon\\www\\telent\\public\\index.php\r\n:17\r\nrequire_once\r\n\r\nC:\\laragon\\www\\telent\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\resources\\server.php\r\n:23\r\nC:\\laragon\\www\\telent\\vendor\\symfony\\mailer\\Transport\\Smtp\\Stream\\SocketStream.php :154\r\n        $options[\'ssl\'][\'crypto_method\'] ??= \\STREAM_CRYPTO_METHOD_TLS_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | \\STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;\r\n        $streamContext = stream_context_create($options);\r\n \r\n        $timeout = $this->getTimeout();\r\n        set_error_handler(function ($type, $msg) {\r\n            throw new TransportException(\\sprintf(\'Connection could not be established with host \"%s\": \', $this->url).$msg);\r\n        });\r\n        try {\r\n            $this->stream = stream_socket_client($this->url, $errno, $errstr, $timeout, \\STREAM_CLIENT_CONNECT, $streamContext);\r\n        } finally {\r\n            restore_error_handler();\r\n        }\r\n \r\n        stream_set_blocking($this->stream, true);\r\n        stream_set_timeout($this->stream, (int) $timeout, (int) (($timeout - (int) $timeout) * 1000000));\r\n        $this->in = &$this->stream;\r\n        $this->out = &$this->stream;\r\nRequest\r\nPOST /daftar\r\nHeaders\r\nhost\r\n127.0.0.1:8000', NULL, '2026-05-22', '2026-05-22 14:06:29', 1, '2026-05-22 14:06:29', '2026-05-22 14:06:56'),
(9, 2, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/009', 'Penerimaan Magang Mahasiswa', 'RFRGRTGH', NULL, '2026-05-23', '2026-05-23 06:20:52', 1, '2026-05-23 06:20:52', '2026-05-23 06:21:31'),
(10, 2, 1, 'penerimaan', 'TELENT/SB/ACC/2026/05/010', 'Surat Balasan Magang Mahasiswa', 'fdcfev', 'surat-balasan/ovMfCYD6d5XrX1uEvv4NP2LDyxP6PuAGUEVtJNOK.pdf', '2026-05-23', '2026-05-23 06:46:51', 1, '2026-05-23 06:46:51', '2026-05-23 06:47:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `akses_token_admin`
--
ALTER TABLE `akses_token_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akses_token_admin_token_unique` (`token`);

--
-- Indeks untuk tabel `anggota_proposal`
--
ALTER TABLE `anggota_proposal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_proposal_proposal_id_foreign` (`proposal_id`),
  ADD KEY `anggota_proposal_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_verifications_token_unique` (`token`),
  ADD KEY `email_verifications_pengguna_id_foreign` (`pengguna_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kehadiran_mahasiswa_id_tanggal_unique` (`mahasiswa_id`,`tanggal`),
  ADD KEY `kehadiran_proposal_id_foreign` (`proposal_id`),
  ADD KEY `kehadiran_verifikator_id_foreign` (`verifikator_id`);

--
-- Indeks untuk tabel `log_harian`
--
ALTER TABLE `log_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_harian_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `log_harian_proposal_id_foreign` (`proposal_id`),
  ADD KEY `log_harian_kehadiran_id_foreign` (`kehadiran_id`),
  ADD KEY `log_harian_verifikator_id_foreign` (`verifikator_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`),
  ADD KEY `notifikasi_pengguna_id_sudah_dibaca_index` (`pengguna_id`,`sudah_dibaca`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`),
  ADD UNIQUE KEY `pengguna_nim_unique` (`nim`),
  ADD KEY `pengguna_pembimbing_id_foreign` (`pembimbing_id`),
  ADD KEY `pengguna_dibuat_oleh_foreign` (`dibuat_oleh`);

--
-- Indeks untuk tabel `periode_magang`
--
ALTER TABLE `periode_magang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_magang_dibuat_oleh_foreign` (`dibuat_oleh`);

--
-- Indeks untuk tabel `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proposal_nomor_proposal_unique` (`nomor_proposal`),
  ADD KEY `proposal_pengaju_id_foreign` (`pengaju_id`),
  ADD KEY `proposal_periode_id_foreign` (`periode_id`),
  ADD KEY `proposal_reviewer_hrd_id_foreign` (`reviewer_hrd_id`),
  ADD KEY `proposal_approver_id_foreign` (`approver_id`),
  ADD KEY `proposal_pembimbing_id_foreign` (`pembimbing_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `surat_balasan`
--
ALTER TABLE `surat_balasan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surat_balasan_nomor_surat_unique` (`nomor_surat`),
  ADD KEY `surat_balasan_proposal_id_foreign` (`proposal_id`),
  ADD KEY `surat_balasan_dibuat_oleh_foreign` (`dibuat_oleh`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akses_token_admin`
--
ALTER TABLE `akses_token_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `anggota_proposal`
--
ALTER TABLE `anggota_proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `log_harian`
--
ALTER TABLE `log_harian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `periode_magang`
--
ALTER TABLE `periode_magang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `surat_balasan`
--
ALTER TABLE `surat_balasan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota_proposal`
--
ALTER TABLE `anggota_proposal`
  ADD CONSTRAINT `anggota_proposal_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `anggota_proposal_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD CONSTRAINT `kehadiran_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `kehadiran_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `kehadiran_verifikator_id_foreign` FOREIGN KEY (`verifikator_id`) REFERENCES `pengguna` (`id`);

--
-- Ketidakleluasaan untuk tabel `log_harian`
--
ALTER TABLE `log_harian`
  ADD CONSTRAINT `log_harian_kehadiran_id_foreign` FOREIGN KEY (`kehadiran_id`) REFERENCES `kehadiran` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `log_harian_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `log_harian_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`),
  ADD CONSTRAINT `log_harian_verifikator_id_foreign` FOREIGN KEY (`verifikator_id`) REFERENCES `pengguna` (`id`);

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengguna_pembimbing_id_foreign` FOREIGN KEY (`pembimbing_id`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `periode_magang`
--
ALTER TABLE `periode_magang`
  ADD CONSTRAINT `periode_magang_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`);

--
-- Ketidakleluasaan untuk tabel `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `proposal_pembimbing_id_foreign` FOREIGN KEY (`pembimbing_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `proposal_pengaju_id_foreign` FOREIGN KEY (`pengaju_id`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `proposal_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periode_magang` (`id`),
  ADD CONSTRAINT `proposal_reviewer_hrd_id_foreign` FOREIGN KEY (`reviewer_hrd_id`) REFERENCES `pengguna` (`id`);

--
-- Ketidakleluasaan untuk tabel `surat_balasan`
--
ALTER TABLE `surat_balasan`
  ADD CONSTRAINT `surat_balasan_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`),
  ADD CONSTRAINT `surat_balasan_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
