<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecelakaanFoto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_foto_kecelakaan';
    protected $primaryKey = 'id_detail_foto';

    protected $fillable = [
        'id_detail_foto',
        'id_kecelakaan',
        'foto_pendukung'
    ];

    public function kecelakaan()
    {
        return $this->belongsTo(Kecelakaan::class, 'id_kecelakaan', 'id_kecelakaan');
    }
}
