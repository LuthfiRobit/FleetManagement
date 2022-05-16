<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanBiayaDetailAcc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_acc_biaya';
    protected $primaryKey = 'id_detail_acc';

    protected $fillable = [
        'id_detail_acc',
        'id_detail_biaya',
        'tgl_pengecekan',
        'status_acc',
        'id_petugas'
    ];
}
