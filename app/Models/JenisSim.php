<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSim extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_jenis_sim';
    protected $primaryKey = 'id_jenis_sim';

    protected $fillable = [
        'nama_sim', 'status'
    ];
}
