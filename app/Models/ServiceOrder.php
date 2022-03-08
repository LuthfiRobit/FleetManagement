<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_order_kendaraan';
    protected $primaryKey = 'id_service_order';

    protected $fillable = [
        'id_service_order',
        'id_petugas',
        'no_so',
        'tgl_penjemputan',
        'jam_penjemputan',
        'jml_penumpang',
        'tempat_penjemputan',
        'tujuan',
        'keterangan',
        'status_so',
        'keterangan_penolakan'
    ];
}
