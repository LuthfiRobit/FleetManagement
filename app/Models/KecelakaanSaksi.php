<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecelakaanSaksi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_saksi_kecelakaan';
    protected $primaryKey = 'id_saksi_kecelakaan';

    protected $fillable = [
        'id_saksi_kecelakaan',
        'id_kecelakaan',
        'id_saksi',
        'id_atasan'
    ];

    public function kecelakaan()
    {
        return $this->belongsTo(Kecelakaan::class, 'id_kecelakaan', 'id_kecelakaan');
    }
}
