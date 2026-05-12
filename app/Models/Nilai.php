<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Nilai extends Model {
    protected $fillable = ['siswa_id','mata_pelajaran_id','kelas_id','semester','nilai_harian','nilai_uts','nilai_uas','nilai_akhir','predikat','catatan','tahun_ajaran_id'];
    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public static function hitungPredikat($nilai) {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}
