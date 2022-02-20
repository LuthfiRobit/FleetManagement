<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_status_driver';
    protected $primaryKey = 'id_status';

    protected $fillable = [
        'id_status',
        'id_driver',
        'status',
        'foto_bukti',
        'keterangan',
        'tgl_nonaktif',
        'tgl_aktif',
        'jml_nonaktif'
    ];
}
