<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanBiayaDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_biaya';
    protected $primaryKey = 'id_detail_biaya';

    protected $fillable = [
        'id_detail_biaya',
        'id_biaya_penugasan',
        'id_jenis_pengeluaran',
        'nominal',
        'bukti',
        'keterangan'
    ];
}
