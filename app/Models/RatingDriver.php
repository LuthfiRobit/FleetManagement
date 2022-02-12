<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingDriver extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_rating_driver';
    protected $primaryKey = 'id_rating';

    protected $fillable = [
        'id_rating',
        'id_do',
        'id_kriteria_rating',
        'id_detail_so',
        'nilai'
    ];
}
