<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_kendaraan';
    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'id_jenis_kendaraan',
        'id_merk',
        'id_bahan_bakar',
        'id_jenis_sim',
        'kode_asset',
        'no_polisi',
        'nomor_rangka',
        'nomor_mesin',
        'nama_kendaraan',
        'warna',
        'tanggal_pembelian',
        'harga',
        'jenis_penggerak',
        'tahun_kendaraan',
        'pemilik',
        'status'
    ];

    public function alokasiKendaraan()
    {
        return $this->hasOne(AlokasiKendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }
}
