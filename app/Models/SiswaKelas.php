<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    protected $table = 'siswa_kelas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajar_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajar_id');
    }
}