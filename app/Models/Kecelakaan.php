<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecelakaan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_kecelakaan';
    protected $primaryKey = 'id_kecelakaan';

    protected $fillable = [
        'id_kecelakaan',
        'id_do',
        'tgl_kecelakaan',
        'jam_kecelakaan',
        'lokasi_kejadian',
        'kronologi',
        'foto_sketsa_kejadian',
        'tindakan_tidak_aman',
        'kondisi_tidak_aman'
    ];

    public function kecelakaanFoto()
    {
        return $this->hasMany(KecelakaanFoto::class, 'id_kecelakaan', 'id_kecelakaan');
    }

    public function kecelakaanSaksi()
    {
        return $this->hasMany(KecelakaanSaksi::class, 'id_kecelakaan', 'id_kecelakaan');
    }
}
