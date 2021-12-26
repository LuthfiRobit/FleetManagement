<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_departemen';
    protected $primaryKey = 'id_departemen';

    protected $fillable = [
        'nama_departemen', 'perusahaan', 'status'
    ];
}
