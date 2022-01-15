<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_perbaikan';
    protected $primaryKey = 'id_perbaikan';

    protected $fillable = [
        'id_perbaikan',
        'id_persetujuan',
        'id_dealer',
        'tgl_perbaikan',
        'tgl_selesai',
        'tgl_selesai_pengerjaan',
        'status_perbaikan',
        'status_penyelesaian',
        'total_biaya_perbaikan'
    ];
}
