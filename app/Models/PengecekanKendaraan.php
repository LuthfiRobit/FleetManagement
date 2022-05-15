<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengecekanKendaraan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_pengecekan_kendaraan';
    protected $primaryKey = 'id_pengecekan';

    protected $fillable = [
        'id_pengecekan',
        'id_driver',
        'id_kendaraan',
        'tgl_pengecekan',
        'jam_pengecekan',
        'km_kendaraan',
        'status_kendaraan',
        'status_pengecekan',
        'status_perbaikan',
        'keterangan_penolakan',
        'keterangan_pengecekan'
    ];

    public function detailPengecekan()
    {
        return $this->hasMany(PengecekanKendaraanDetail::class, 'id_pengecekan', 'id_pengecekan');
    }

    public function fotoPengecekan()
    {
        return $this->hasMany(PengecekanKendaraanFoto::class, 'id_pengecekan', 'id_pengecekan');
    }
}
