# 🎀 SMAtrack — Panduan Instalasi Lengkap

## Deskripsi
SMAtrack adalah sistem informasi akademik SMA berbasis Laravel 10 dengan tampilan pink yang cantik.

### Fitur:
- ✅ **Login** untuk Admin, Guru, dan Siswa
- ✅ **Absensi** digital per mata pelajaran
- ✅ **Input Nilai** (NH, UTS, UAS) + kalkulasi otomatis
- ✅ **Rapot** digital siswa
- ✅ **Jadwal Pelajaran** mingguan
- ✅ **Pengumuman** dengan filter penerima
- 🎓 **Tracker Kuliah** — KHUSUS KELAS 12 (universitas tujuan, jalur, status diterima/tidak)

### Akun Login Demo:
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@smatrack.com | password |
| Guru | budi@guru.smatrack.com | password |
| Siswa Kelas X | andi@siswa.com | password |
| Siswa Kelas XII | dimas@siswa.com | password |
| Siswa XII (diterima) | eva@siswa.com | password |

### Hak Akses:
- **Admin**: Akses penuh — tambah siswa/guru, input absensi, input nilai, kelola data kuliah kelas 12
- **Guru**: Hanya LIHAT — absensi, nilai, jadwal. Tidak bisa edit. Setor nilai ke admin.
- **Siswa**: Lihat jadwal, absensi, nilai, rapot. Kelas 12 punya menu Tracker Kuliah.

---

## ⚡ CARA INSTALL (Step by Step)

### Yang Dibutuhkan:
- **PHP 8.1+** (XAMPP/Laragon yang punya PHP 8.1 ke atas)
- **Composer** (https://getcomposer.org)
- **MySQL + phpMyAdmin** (sudah termasuk di XAMPP/Laragon)

---

### STEP 1 — Cek PHP & Composer

Buka terminal/CMD, jalankan:
```bash
php --version
# Harus: PHP 8.1.x atau lebih tinggi

composer --version
# Harus muncul versi Composer
```

> Kalau PHP belum ada, install **Laragon** (rekomendasi) dari https://laragon.org

---

### STEP 2 — Taruh Project di Folder yang Tepat

**Jika pakai XAMPP:**
```
Ekstrak ZIP ke: C:\xampp\htdocs\smatrack
```

**Jika pakai Laragon:**
```
Ekstrak ZIP ke: C:\laragon\www\smatrack
```

---

### STEP 3 — Install Dependensi Laravel

Buka terminal di folder `smatrack`, lalu jalankan:
```bash
composer install
```
> Tunggu sampai selesai (butuh internet, sekitar 2-5 menit)

---

### STEP 4 — Setup File .env

Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Lalu edit file `.env`, sesuaikan bagian database:
```
APP_NAME=SMAtrack
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smatrack
DB_USERNAME=root
DB_PASSWORD=          ← kosongkan kalau tidak ada password MySQL
```

---

### STEP 5 — Generate App Key

```bash
php artisan key:generate
```

---

### STEP 6 — Setup Database di phpMyAdmin

**Cara A — Import SQL Langsung (TERMUDAH):**
1. Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
2. Klik tab **"Import"** di bagian atas
3. Pilih file: `database/smatrack.sql`
4. Klik **"Go"** / **"Import"**
5. ✅ Database + data langsung jadi!

**Cara B — Pakai Artisan Migration:**
```bash
# Buat dulu database 'smatrack' di phpMyAdmin
php artisan migrate
php artisan db:seed
```

---

### STEP 7 — Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

### STEP 8 — Login & Coba!

Gunakan akun demo dari tabel di atas. Klik tombol demo di halaman login untuk isi otomatis!

---

## 🛠️ Troubleshooting

**Error: Class not found**
```bash
composer dump-autoload
```

**Error: Storage not writable**
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

**Error: View not found**
```bash
php artisan view:clear
php artisan cache:clear
```

**Password hash tidak cocok (SQL import)**
```bash
php artisan tinker
# Lalu ketik:
\App\Models\User::where('role','admin')->first()->update(['password' => bcrypt('password')]);
```

---

## 📁 Struktur Project Penting

```
smatrack/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php         ← Login/Logout
│   │   ├── Admin/AdminController.php  ← Semua fungsi admin
│   │   ├── Guru/GuruController.php    ← Fungsi guru (lihat saja)
│   │   └── Siswa/SiswaController.php  ← Fungsi siswa
│   ├── Models/                         ← User, Kelas, Nilai, dll
│   └── Http/Middleware/
│       └── RoleMiddleware.php          ← Proteksi akses per role
├── database/
│   ├── migrations/                     ← Struktur tabel
│   ├── seeders/                        ← Data awal
│   └── smatrack.sql                    ← Import langsung ke phpMyAdmin
├── resources/views/
│   ├── auth/login.blade.php            ← Halaman login
│   ├── layouts/app.blade.php           ← Layout utama (sidebar pink)
│   ├── admin/                          ← Semua halaman admin
│   ├── guru/                           ← Semua halaman guru
│   └── siswa/                          ← Semua halaman siswa
└── routes/web.php                      ← Semua route URL
```

---

## 🎨 Kustomisasi Warna

Edit variabel CSS di `resources/views/layouts/app.blade.php`:
```css
:root {
    --pink-500: #ff3385;    ← Warna utama, ganti ke warna lain
    --pink-600: #e8166b;
    --bg: #fff5f9;           ← Background
}
```

---

Dibuat dengan 💖 untuk SMAtrack
