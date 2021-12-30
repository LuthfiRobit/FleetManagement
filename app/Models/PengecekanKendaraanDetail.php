<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengecekanKendaraanDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_pengecekan';
    protected $primaryKey = 'id_detail_pengecekan';

    protected $fillable = [
        'id_detail_pengecekan',
        'id_pengecekan',
        'id_jenis_pengecekan',
        'kondisi',
        'waktu_pengecekan',
        'keterangan'
    ];

    public function pengecekan()
    {
        return $this->belongsTo(PengecekanKendaraan::class, 'id_pengecekan', 'id_pengecekan');
    }
}
