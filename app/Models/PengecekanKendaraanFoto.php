<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengecekanKendaraanFoto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_foto_pengecekan';
    protected $primaryKey = 'id_detail_foto_cek';

    protected $fillable = [
        'id_detail_foto_cek',
        'id_pengecekan',
        'foto_pengecekan',
        'keterangan'
    ];

    public function pengecekan()
    {
        return $this->belongsTo(PengecekanKendaraan::class, 'id_pengecekan', 'id_pengecekan');
    }
}
