<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tahun Ajaran
        DB::table('tahun_ajarans')->insert([
            ['tahun' => '2024/2025', 'is_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
        $taId = 1;

        // Admin
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@smatrack.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guru
        $gurus = [
            ['name' => 'Budi Santoso', 'email' => 'budi@guru.smatrack.com', 'nip' => '198001012010011001'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@guru.smatrack.com', 'nip' => '198505152012012002'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@guru.smatrack.com', 'nip' => '199003202015011003'],
        ];
        foreach ($gurus as $g) {
            DB::table('users')->insert([
                'name' => $g['name'],
                'email' => $g['email'],
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip' => $g['nip'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kelas
        DB::table('kelas')->insert([
            ['nama_kelas' => 'X IPA 1', 'tingkat' => '10', 'jurusan' => 'IPA', 'wali_kelas_id' => 2, 'tahun_ajaran_id' => $taId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI IPA 1', 'tingkat' => '11', 'jurusan' => 'IPA', 'wali_kelas_id' => 3, 'tahun_ajaran_id' => $taId, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XII IPA 1', 'tingkat' => '12', 'jurusan' => 'IPA', 'wali_kelas_id' => 4, 'tahun_ajaran_id' => $taId, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Siswa
        $siswaData = [
            ['name' => 'Andi Pratama', 'email' => 'andi@siswa.com', 'nis' => '001', 'kelas_id' => 1, 'tingkat' => '10'],
            ['name' => 'Bella Safitri', 'email' => 'bella@siswa.com', 'nis' => '002', 'kelas_id' => 1, 'tingkat' => '10'],
            ['name' => 'Citra Dewi', 'email' => 'citra@siswa.com', 'nis' => '003', 'kelas_id' => 2, 'tingkat' => '11'],
            ['name' => 'Dimas Aditya', 'email' => 'dimas@siswa.com', 'nis' => '004', 'kelas_id' => 3, 'tingkat' => '12'],
            ['name' => 'Eva Kusuma', 'email' => 'eva@siswa.com', 'nis' => '005', 'kelas_id' => 3, 'tingkat' => '12'],
        ];

        foreach ($siswaData as $s) {
            $userId = DB::table('users')->insertGetId([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => $s['nis'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('siswa_kelas')->insert([
                'siswa_id' => $userId,
                'kelas_id' => $s['kelas_id'],
                'tahun_ajaran_id' => $taId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Mata Pelajaran
        $mapels = [
            ['nama' => 'Matematika', 'kode' => 'MTK', 'kkm' => 75],
            ['nama' => 'Bahasa Indonesia', 'kode' => 'BIND', 'kkm' => 75],
            ['nama' => 'Bahasa Inggris', 'kode' => 'BING', 'kkm' => 75],
            ['nama' => 'Fisika', 'kode' => 'FIS', 'kkm' => 75],
            ['nama' => 'Kimia', 'kode' => 'KIM', 'kkm' => 75],
            ['nama' => 'Biologi', 'kode' => 'BIO', 'kkm' => 75],
        ];
        foreach ($mapels as $m) {
            DB::table('mata_pelajarans')->insert(array_merge($m, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Pengumuman
        DB::table('pengumumans')->insert([
            [
                'judul' => 'Selamat Datang di SMAtrack!',
                'isi' => 'Sistem informasi akademik SMAtrack resmi diluncurkan. Semua siswa, guru, dan admin dapat menggunakan fitur-fitur yang tersedia.',
                'untuk' => 'semua',
                'dibuat_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pendaftaran SNBP 2025 Segera Dibuka!',
                'isi' => 'Bagi siswa kelas 12, persiapkan dokumen untuk pendaftaran SNBP 2025. Pastikan nilai rapor sudah lengkap dan diunggah ke sistem.',
                'untuk' => 'kelas12',
                'dibuat_oleh' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data Kuliah contoh untuk siswa kelas 12
        DB::table('data_kuliahs')->insert([
            [
                'siswa_id' => 8, // Dimas
                'universitas_tujuan_1' => 'Universitas Indonesia',
                'prodi_tujuan_1' => 'Teknik Informatika',
                'universitas_tujuan_2' => 'Institut Teknologi Bandung',
                'prodi_tujuan_2' => 'Sistem Informasi',
                'jalur' => 'SNBP',
                'status' => 'sedang_proses',
                'tahun_ajaran_id' => $taId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 9, // Eva
                'universitas_tujuan_1' => 'Universitas Gadjah Mada',
                'prodi_tujuan_1' => 'Kedokteran',
                'jalur' => 'SNBT',
                'status' => 'diterima',
                'universitas_diterima' => 'Universitas Gadjah Mada',
                'prodi_diterima' => 'Kedokteran',
                'tanggal_pengumuman' => '2025-03-25',
                'tahun_ajaran_id' => $taId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
