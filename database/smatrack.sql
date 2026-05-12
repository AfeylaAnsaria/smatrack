-- ============================================
-- SMAtrack Database Setup
-- Import file ini ke phpMyAdmin
-- ============================================

CREATE DATABASE IF NOT EXISTS `smatrack` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smatrack`;

-- Tabel users
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `nip` varchar(191) DEFAULT NULL,
  `nis` varchar(191) DEFAULT NULL,
  `no_hp` varchar(191) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel tahun_ajarans
CREATE TABLE `tahun_ajarans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` varchar(191) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel kelas
CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(191) NOT NULL,
  `tingkat` enum('10','11','12') NOT NULL,
  `jurusan` varchar(191) DEFAULT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`),
  KEY `kelas_tahun_ajaran_id_foreign` (`tahun_ajaran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel siswa_kelas
CREATE TABLE `siswa_kelas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel mata_pelajarans
CREATE TABLE `mata_pelajarans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) NOT NULL,
  `kode` varchar(191) NOT NULL,
  `kkm` int(11) NOT NULL DEFAULT 75,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel jadwals
CREATE TABLE `jadwals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(191) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel absensis
CREATE TABLE `absensis` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alpa') NOT NULL DEFAULT 'hadir',
  `keterangan` varchar(191) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel nilais
CREATE TABLE `nilais` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `nilai_harian` decimal(5,2) DEFAULT NULL,
  `nilai_uts` decimal(5,2) DEFAULT NULL,
  `nilai_uas` decimal(5,2) DEFAULT NULL,
  `nilai_akhir` decimal(5,2) DEFAULT NULL,
  `predikat` varchar(191) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel data_kuliahs
CREATE TABLE `data_kuliahs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `universitas_tujuan_1` varchar(191) NOT NULL,
  `prodi_tujuan_1` varchar(191) NOT NULL,
  `universitas_tujuan_2` varchar(191) DEFAULT NULL,
  `prodi_tujuan_2` varchar(191) DEFAULT NULL,
  `jalur` enum('SNBP','SNBT','Mandiri','Beasiswa') DEFAULT NULL,
  `status` enum('belum_daftar','sedang_proses','diterima','tidak_diterima') NOT NULL DEFAULT 'belum_daftar',
  `universitas_diterima` varchar(191) DEFAULT NULL,
  `prodi_diterima` varchar(191) DEFAULT NULL,
  `tanggal_pengumuman` date DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `bukti_dokumen` varchar(191) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel pengumumans
CREATE TABLE `pengumumans` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `untuk` enum('semua','siswa','guru','kelas12') NOT NULL DEFAULT 'semua',
  `dibuat_oleh` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrations table
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA AWAL (SEED)
-- ============================================

-- Tahun Ajaran
INSERT INTO `tahun_ajarans` (`tahun`, `is_aktif`, `created_at`, `updated_at`) VALUES
('2024/2025', 1, NOW(), NOW());

-- Users: Admin
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin@smatrack.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'admin', NOW(), NOW());
-- password: password

-- Users: Guru
INSERT INTO `users` (`name`, `email`, `password`, `role`, `nip`, `created_at`, `updated_at`) VALUES
('Budi Santoso, S.Pd', 'budi@guru.smatrack.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'guru', '198001012010011001', NOW(), NOW()),
('Siti Rahayu, S.Pd', 'siti@guru.smatrack.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'guru', '198505152012012002', NOW(), NOW()),
('Ahmad Fauzi, M.Pd', 'ahmad@guru.smatrack.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'guru', '199003202015011003', NOW(), NOW());
-- password semua: password

-- Kelas
INSERT INTO `kelas` (`nama_kelas`, `tingkat`, `jurusan`, `wali_kelas_id`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
('X IPA 1', '10', 'IPA', 2, 1, NOW(), NOW()),
('XI IPA 1', '11', 'IPA', 3, 1, NOW(), NOW()),
('XII IPA 1', '12', 'IPA', 4, 1, NOW(), NOW());

-- Users: Siswa Kelas 10
INSERT INTO `users` (`name`, `email`, `password`, `role`, `nis`, `created_at`, `updated_at`) VALUES
('Andi Pratama', 'andi@siswa.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'siswa', '2410001', NOW(), NOW()),
('Bella Safitri', 'bella@siswa.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'siswa', '2410002', NOW(), NOW()),
('Citra Dewi', 'citra@siswa.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'siswa', '2311001', NOW(), NOW()),
('Dimas Aditya', 'dimas@siswa.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'siswa', '2212001', NOW(), NOW()),
('Eva Kusuma', 'eva@siswa.com', '$2y$12$eEpvHWMjJRHWr7XHLl8aMuOiMkJGN5gD2j.TyJBpwZP3k3EpGCCKa', 'siswa', '2212002', NOW(), NOW());
-- password semua: password

-- Siswa Kelas (relasi)
INSERT INTO `siswa_kelas` (`siswa_id`, `kelas_id`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(5, 1, 1, NOW(), NOW()),  -- Andi -> X IPA 1
(6, 1, 1, NOW(), NOW()),  -- Bella -> X IPA 1
(7, 2, 1, NOW(), NOW()),  -- Citra -> XI IPA 1
(8, 3, 1, NOW(), NOW()),  -- Dimas -> XII IPA 1
(9, 3, 1, NOW(), NOW());  -- Eva -> XII IPA 1

-- Mata Pelajaran
INSERT INTO `mata_pelajarans` (`nama`, `kode`, `kkm`, `created_at`, `updated_at`) VALUES
('Matematika', 'MTK', 75, NOW(), NOW()),
('Bahasa Indonesia', 'BIND', 75, NOW(), NOW()),
('Bahasa Inggris', 'BING', 75, NOW(), NOW()),
('Fisika', 'FIS', 75, NOW(), NOW()),
('Kimia', 'KIM', 75, NOW(), NOW()),
('Biologi', 'BIO', 75, NOW(), NOW()),
('Sejarah Indonesia', 'SEJ', 75, NOW(), NOW()),
('Pendidikan Jasmani', 'PJOK', 75, NOW(), NOW());

-- Jadwal (untuk kelas XII IPA 1)
INSERT INTO `jadwals` (`kelas_id`, `mata_pelajaran_id`, `guru_id`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 'Senin', '07:00:00', '08:30:00', 'Ruang 12A', 1, NOW(), NOW()),
(3, 2, 3, 'Senin', '08:30:00', '10:00:00', 'Ruang 12A', 1, NOW(), NOW()),
(3, 3, 4, 'Selasa', '07:00:00', '08:30:00', 'Ruang 12A', 1, NOW(), NOW()),
(3, 4, 2, 'Rabu', '07:00:00', '08:30:00', 'Lab IPA', 1, NOW(), NOW()),
(3, 5, 3, 'Kamis', '07:00:00', '08:30:00', 'Lab Kimia', 1, NOW(), NOW()),
(3, 6, 4, 'Jumat', '07:00:00', '08:30:00', 'Lab IPA', 1, NOW(), NOW());

-- Sample Absensi
INSERT INTO `absensis` (`siswa_id`, `kelas_id`, `mata_pelajaran_id`, `tanggal`, `status`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(8, 3, 1, CURDATE(), 'hadir', 1, NOW(), NOW()),
(8, 3, 2, CURDATE(), 'hadir', 1, NOW(), NOW()),
(9, 3, 1, CURDATE(), 'hadir', 1, NOW(), NOW()),
(9, 3, 2, CURDATE(), 'sakit', 1, NOW(), NOW()),
(8, 3, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'hadir', 1, NOW(), NOW()),
(8, 3, 3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 'izin', 1, NOW(), NOW());

-- Sample Nilai
INSERT INTO `nilais` (`siswa_id`, `mata_pelajaran_id`, `kelas_id`, `semester`, `nilai_harian`, `nilai_uts`, `nilai_uas`, `nilai_akhir`, `predikat`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(8, 1, 3, '1', 85.00, 80.00, 88.00, 84.40, 'B', 1, NOW(), NOW()),
(8, 2, 3, '1', 90.00, 85.00, 92.00, 89.10, 'B', 1, NOW(), NOW()),
(8, 3, 3, '1', 78.00, 75.00, 80.00, 77.90, 'C', 1, NOW(), NOW()),
(9, 1, 3, '1', 92.00, 95.00, 90.00, 92.30, 'A', 1, NOW(), NOW()),
(9, 2, 3, '1', 88.00, 82.00, 85.00, 85.70, 'B', 1, NOW(), NOW());

-- Data Kuliah Kelas 12
INSERT INTO `data_kuliahs` (`siswa_id`, `universitas_tujuan_1`, `prodi_tujuan_1`, `universitas_tujuan_2`, `prodi_tujuan_2`, `jalur`, `status`, `universitas_diterima`, `prodi_diterima`, `tanggal_pengumuman`, `tahun_ajaran_id`, `created_at`, `updated_at`) VALUES
(8, 'Universitas Indonesia', 'Teknik Informatika', 'Institut Teknologi Bandung', 'Sistem Informasi', 'SNBP', 'sedang_proses', NULL, NULL, NULL, 1, NOW(), NOW()),
(9, 'Universitas Gadjah Mada', 'Kedokteran', 'Universitas Airlangga', 'Kedokteran', 'SNBT', 'diterima', 'Universitas Gadjah Mada', 'Kedokteran', '2025-03-25', 1, NOW(), NOW());

-- Pengumuman
INSERT INTO `pengumumans` (`judul`, `isi`, `untuk`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
('Selamat Datang di SMAtrack!', 'Sistem informasi akademik SMAtrack resmi diluncurkan. Semua siswa, guru, dan admin dapat menggunakan fitur-fitur yang tersedia. Jika ada kendala, hubungi admin.', 'semua', 1, NOW(), NOW()),
('Pendaftaran SNBP 2025 Segera Dibuka!', 'Bagi siswa kelas 12, persiapkan dokumen untuk pendaftaran SNBP 2025. Pastikan nilai rapor sudah lengkap dan diunggah ke sistem. Batas waktu pendaftaran sebelum akhir bulan ini.', 'kelas12', 1, NOW(), NOW()),
('Jadwal UTS Semester Genap', 'Ujian Tengah Semester Genap akan dilaksanakan mulai tanggal 10-20 Maret 2025. Siswa wajib hadir tepat waktu dan membawa kartu ujian.', 'siswa', 1, NOW(), NOW()),
('Rapat Koordinasi Guru', 'Rapat koordinasi guru akan dilaksanakan pada Senin, 7 Maret 2025 pukul 14.00 WIB di ruang guru. Kehadiran wajib.', 'guru', 1, NOW(), NOW());

-- Migrations record
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2024_01_01_000001_create_users_table', 1),
('2024_01_01_000002_create_school_tables', 1);

