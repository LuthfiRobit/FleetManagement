<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanPersetujuan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_persetujuan_perbaikan';
    protected $primaryKey = 'id_persetujuan';

    protected $fillable = [
        'id_persetujuan',
        'no_wo',
        'id_pengecekan',
        'id_petugas',
        'tgl_persetujuan',
        'status'
    ];
}
