<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'id_petugas',
        'no_badge',
        'id_jabatan',
        'id_departemen',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'tgl_mulai_kerja',
        'no_tlp',
        'user',
        'password',
        'status'
    ];
}
