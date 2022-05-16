<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanBiaya extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_biaya_penugasan';
    protected $primaryKey = 'id_biaya_penugasan';

    protected $fillable = [
        'id_biaya_penugasan',
        'id_do',
        'tgl_pengajuan',
        'total_biaya'
        // 'rincian',
        // 'total',
        // 'butkti_nota',
        // 'ket_penolakan',
        // 'status',
        // 'tgl_acc'
    ];
}
