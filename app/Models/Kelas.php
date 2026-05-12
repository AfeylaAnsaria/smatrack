<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kelas extends Model {
    protected $fillable = ['nama_kelas','tingkat','jurusan','wali_kelas_id','tahun_ajaran_id'];
    public function waliKelas() { return $this->belongsTo(User::class, 'wali_kelas_id'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
    public function siswaKelas() { return $this->hasMany(SiswaKelas::class); }
    public function jadwals() { return $this->hasMany(Jadwal::class); }
}
