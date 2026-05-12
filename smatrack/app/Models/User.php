<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nip', 'nis', 'no_hp', 'alamat', 'foto',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function isAdmin() { return $this->role === 'admin'; }
    public function isGuru()  { return $this->role === 'guru'; }
    public function isSiswa() { return $this->role === 'siswa'; }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }

    public function kelasAktif()
    {
        $taAktif = TahunAjaran::where('is_aktif', true)->first();
        return $this->siswaKelas()
            ->where('tahun_ajaran_id', $taAktif?->id)
            ->with('kelas')
            ->first();
    }

    public function dataKuliah()
    {
        return $this->hasOne(DataKuliah::class, 'siswa_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}
