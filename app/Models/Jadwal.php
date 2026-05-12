<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Jadwal extends Model {
    protected $fillable = ['kelas_id','mata_pelajaran_id','guru_id','hari','jam_mulai','jam_selesai','ruangan','tahun_ajaran_id'];
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
    public function guru() { return $this->belongsTo(User::class, 'guru_id'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
}
