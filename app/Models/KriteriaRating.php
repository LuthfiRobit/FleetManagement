<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaRating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_kriteria_rating';
    protected $primaryKey = 'id_kriteria_rating';

    protected $fillable = [
        'pertanyaan', 'status'
    ];
}
