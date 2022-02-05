<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanBatal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_pembatalan_penugasan';
    protected $primaryKey = 'id_pembatalan';

    protected $fillable = [
        'id_pembatalan',
        'id_do',
        'id_driver',
        'alasan_pembatalan',
        'bukti',
        'tanggal',
        'status_pembatalan'
    ];
}
