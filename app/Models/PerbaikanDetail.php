<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_pergantian';
    protected $primaryKey = 'id_detail_pergantian';

    protected $fillable = [
        'id_detail_pergantian',
        'id_perbaikan',
        'tgl_pergantian',
        'nama_komponen',
        'jml_komponen',
        'harga_satuan'
    ];
}
