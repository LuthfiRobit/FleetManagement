<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanBiaya extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_biaya_penugasan';
    protected $primaryKey = 'id_biaya';

    protected $fillable = [
        'id_biaya',
        'id_do',
        'rincian',
        'total',
        'butkti_nota',
        'ket_penolakan',
        'status',
        'tgl_acc'
    ];
}
