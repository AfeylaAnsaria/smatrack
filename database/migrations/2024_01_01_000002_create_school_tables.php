<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Tahun Ajaran
        Schema::create('tahun_ajarans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun'); // e.g. 2024/2025
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();
        });

        // Tabel Kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // e.g. X IPA 1
            $table->enum('tingkat', ['10', '11', '12']);
            $table->string('jurusan')->nullable(); // IPA, IPS, Bahasa
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Siswa di Kelas
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Mata Pelajaran
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->integer('kkm')->default(75);
            $table->timestamps();
        });

        // Tabel Jadwal
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans');
            $table->foreignId('guru_id')->constrained('users');
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan')->nullable();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Absensi
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans');
            $table->date('tanggal');
            $table->enum('status', ['hadir','izin','sakit','alpa'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Nilai
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->enum('semester', ['1','2']);
            $table->decimal('nilai_harian', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat')->nullable(); // A, B, C, D
            $table->text('catatan')->nullable();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Data Kuliah (Khusus Kelas 12)
        Schema::create('data_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('universitas_tujuan_1');
            $table->string('prodi_tujuan_1');
            $table->string('universitas_tujuan_2')->nullable();
            $table->string('prodi_tujuan_2')->nullable();
            $table->enum('jalur', ['SNBP','SNBT','Mandiri','Beasiswa'])->nullable();
            $table->enum('status', ['belum_daftar','sedang_proses','diterima','tidak_diterima'])->default('belum_daftar');
            $table->string('universitas_diterima')->nullable();
            $table->string('prodi_diterima')->nullable();
            $table->date('tanggal_pengumuman')->nullable();
            $table->text('catatan')->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->timestamps();
        });

        // Tabel Pengumuman
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->enum('untuk', ['semua','siswa','guru','kelas12'])->default('semua');
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
        Schema::dropIfExists('data_kuliahs');
        Schema::dropIfExists('nilais');
        Schema::dropIfExists('absensis');
        Schema::dropIfExists('jadwals');
        Schema::dropIfExists('mata_pelajarans');
        Schema::dropIfExists('siswa_kelas');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('tahun_ajarans');
    }
};
