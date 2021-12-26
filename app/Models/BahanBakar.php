<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_bahan_bakar';
    protected $primaryKey = 'id_bahan_bakar';

    protected $fillable = [
        'nama_bahan_bakar', 'status'
    ];
}
