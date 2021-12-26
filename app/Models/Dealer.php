<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_dealer';
    protected $primaryKey = 'id_dealer';

    protected $fillable = [
        'nama_dealer', 'alamat', 'no_tlp', 'status', 'status_dealer'
    ];
}
