<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Siswa\SiswaController;

// Redirect awal
Route::get('/', fn() => redirect()->route('login'));

// ================= AUTH =================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');

    Route::post('/logout', 'logout')->name('logout');

    Route::get('/dashboard', 'dashboard')
        ->name('dashboard')
        ->middleware('auth');
});


// ================= ADMIN =================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ===== SISWA =====
    Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');

    // ===== GURU =====
    Route::get('/guru', [AdminController::class, 'guruIndex'])->name('guru.index');
    Route::post('/guru', [AdminController::class, 'guruStore'])->name('guru.store');

    // ===== KELAS =====
    Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
    Route::post('/kelas', [AdminController::class, 'kelasStore'])->name('kelas.store');

    // ===== ABSENSI =====
    Route::get('/absensi', [AdminController::class, 'absensiIndex'])->name('absensi.index');
    Route::post('/absensi', [AdminController::class, 'absensiStore'])->name('absensi.store');

    // ===== NILAI =====
    Route::get('/nilai', [AdminController::class, 'nilaiIndex'])->name('nilai.index');
    Route::post('/nilai', [AdminController::class, 'nilaiStore'])->name('nilai.store');

    // ===== JADWAL =====
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // ===== KULIAH =====
    Route::get('/kuliah', [AdminController::class, 'kuliahIndex'])->name('kuliah.index');
    Route::post('/kuliah', [AdminController::class, 'kuliahStore'])->name('kuliah.store');
    Route::put('/kuliah/{id}', [AdminController::class, 'kuliahUpdate'])->name('kuliah.update');
    Route::delete('/kuliah/{id}', [AdminController::class, 'kuliahDestroy'])->name('kuliah.destroy'); // ✅ FIX

    // ===== PENGUMUMAN =====
    Route::get('/pengumuman', [AdminController::class, 'pengumumanIndex'])->name('pengumuman.index');
    Route::post('/pengumuman', [AdminController::class, 'pengumumanStore'])->name('pengumuman.store');
    Route::delete('/pengumuman/{id}', [AdminController::class, 'pengumumanDestroy'])->name('pengumuman.destroy');
});


// ================= GURU =================
Route::prefix('guru')
    ->name('guru.')
    ->middleware(['auth', 'role:guru'])
    ->group(function () {

    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi', [GuruController::class, 'absensi'])->name('absensi');
    Route::get('/nilai', [GuruController::class, 'nilai'])->name('nilai');
    Route::get('/jadwal', [GuruController::class, 'jadwal'])->name('jadwal');
});


// ================= SISWA =================
Route::prefix('siswa')
    ->name('siswa.')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {

    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi', [SiswaController::class, 'absensi'])->name('absensi');
    Route::get('/nilai', [SiswaController::class, 'nilai'])->name('nilai');
    Route::get('/rapot', [SiswaController::class, 'rapot'])->name('rapot');
    Route::get('/jadwal', [SiswaController::class, 'jadwal'])->name('jadwal');
    Route::get('/kuliah', [SiswaController::class, 'kuliah'])->name('kuliah');
});