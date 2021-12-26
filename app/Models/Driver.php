<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    public $timestamps      = false;
    protected $table        = 'tb_driver';
    protected $primaryKey   = 'id_driver';

    protected $fillable     = [
        'id_driver',
        'id_departemen',
        'no_badge',
        'no_ktp',
        'nama_driver',
        'alamat',
        'umur',
        'no_tlp',
        'no_sim',
        'foto_ktp',
        'foto_sim',
        'user',
        'password'
    ];
}
