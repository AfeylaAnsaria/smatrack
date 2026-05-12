<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
    protected $fillable = ['siswa_id', 'kelas_id', 'tahun_ajaran_id'];

    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
}