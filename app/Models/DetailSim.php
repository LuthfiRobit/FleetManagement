<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSim extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_sim';
    protected $primaryKey = 'id_detail_sim';

    protected $fillable = [
        'id_detail_sim', 'id_jenis_sim', 'id_driver', 'foto_sim'
    ];
}
