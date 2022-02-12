<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_detail_so';
    protected $primaryKey = 'id_detail_so';

    protected $fillable = [
        'id_detail_so',
        'id_service_order',
        'nama_penumpang',
        'no_tlp'
    ];
}
