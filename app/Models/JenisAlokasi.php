<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAlokasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_jenis_alokasi';
    protected $primaryKey = 'id_jenis_alokasi';

    protected $fillable = [
        'id_jenis_alokasi',
        'nama_alokasi',
        'status'
    ];
}
