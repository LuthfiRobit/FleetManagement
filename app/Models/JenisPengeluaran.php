<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengeluaran extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_jenis_pengeluaran';
    protected $primaryKey = 'id_jenis_pengeluaran';

    protected $fillable = [
        'nama_jenis', 'status'
    ];
}
