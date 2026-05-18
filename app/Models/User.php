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

    public static function detectTingkatFromIdentifier(?string $identifier): ?string
    {
        if (!$identifier) {
            return null;
        }

        $value = strtolower(trim($identifier));

        if (preg_match('/(?:^|[._-])(kelas12|xii|12)(?:[._-]|$)/i', $value)) {
            return '12';
        }

        if (preg_match('/(?:^|[._-])(kelas11|xi|11)(?:[._-]|$)/i', $value)) {
            return '11';
        }

        if (preg_match('/(?:^|[._-])(kelas10|10)(?:[._-]|$)/i', $value)) {
            return '10';
        }

        if (preg_match('/(12)$/', $value)) {
            return '12';
        }

        if (preg_match('/(11)$/', $value)) {
            return '11';
        }

        if (preg_match('/(10)$/', $value)) {
            return '10';
        }

        if (preg_match('/^\d{2}(10|11|12)\d+$/', $value, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function tingkatAksesSiswa(): ?string
    {
        if (!$this->isSiswa()) {
            return null;
        }

        $emailLocalPart = strtolower((string) strtok((string) $this->email, '@'));
        $fromEmail = self::detectTingkatFromIdentifier($emailLocalPart);
        if ($fromEmail) {
            return $fromEmail;
        }

        $fromNis = self::detectTingkatFromIdentifier((string) $this->nis);
        if ($fromNis) {
            return $fromNis;
        }

        return $this->kelasAktif()?->kelas?->tingkat;
    }

    public function canAccessPtn(): bool
    {
        return $this->tingkatAksesSiswa() === '12';
    }

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
