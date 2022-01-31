<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiKendaraan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_alokasi_kendaraan';
    protected $primaryKey = 'id_alokasi';

    protected $fillable = [
        'id_alokasi',
        'id_jenis_alokasi',
        'id_kendaraan'
    ];

    public function kendaraan()
    {
        return $this->hasOne(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
}
