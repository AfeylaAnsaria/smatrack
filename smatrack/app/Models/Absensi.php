<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Absensi extends Model {
    protected $fillable = ['siswa_id','kelas_id','mata_pelajaran_id','tanggal','status','keterangan','tahun_ajaran_id'];
    protected $casts = ['tanggal' => 'date'];
    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
}
