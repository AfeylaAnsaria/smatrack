<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MataPelajaran extends Model {
    protected $fillable = ['nama','kode','kkm'];
    public function jadwals() { return $this->hasMany(Jadwal::class); }
    public function nilais() { return $this->hasMany(Nilai::class); }
}
