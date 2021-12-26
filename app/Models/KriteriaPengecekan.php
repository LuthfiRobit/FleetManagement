<?php

namespace App\Models;

use App\Http\Controllers\JenisPengecekanController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPengecekan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_kriteria_pengecekan';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = [
        'nama_kriteria', 'status'
    ];

    public function jenis()
    {
        return $this->hasMany(JenisPengecekan::class, 'id_kriteria', 'id_kriteria');
    }
}
