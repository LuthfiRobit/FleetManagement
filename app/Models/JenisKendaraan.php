<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_jenis_kendaraan';
    protected $primaryKey = 'id_jenis_kendaraan';

    protected $fillable = [
        'nama_jenis', 'status'
    ];
}
