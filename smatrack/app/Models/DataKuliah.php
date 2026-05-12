<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DataKuliah extends Model {
    protected $fillable = ['siswa_id','universitas_tujuan_1','prodi_tujuan_1','universitas_tujuan_2','prodi_tujuan_2','jalur','status','universitas_diterima','prodi_diterima','tanggal_pengumuman','catatan','bukti_dokumen','tahun_ajaran_id'];
    protected $casts = ['tanggal_pengumuman' => 'date'];
    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
}
