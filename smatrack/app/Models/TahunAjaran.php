<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TahunAjaran extends Model {
    protected $fillable = ['tahun', 'is_aktif'];
    public static function aktif() { return static::where('is_aktif', true)->first(); }
}
