<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanDriver extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_penugasan_driver';
    protected $primaryKey = 'id_do';

    protected $fillable = [
        'id_service_order',
        'id_driver',
        'id_kendaraan',
        'id_petugas',
        'tgl_penugasan',
        'jam_berangkat',
        'kembali',
        'tgl_acc',
        'status_penugasan',
        'km_awal',
        'km_akhir',
        'status_bbm_awal',
        'status_bbm_akhir',
        'keterangan_bbm',
        'waktu_start',
        'waktu_finish',
        'tmp_penjemputan',
        'lat_jemput',
        'long_jemput',
        'tmp_tujuan',
        'lat_tujuan',
        'long_tujuan'
    ];
}
