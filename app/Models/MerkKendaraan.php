<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerkKendaraan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_merk_kendaraan';
    protected $primaryKey = 'id_merk';

    protected $fillable = [
        'nama_merk', 'status'
    ];
}
