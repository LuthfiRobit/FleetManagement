<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengecekan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tb_jenis_pengecekan';
    protected $primaryKey = 'id_jenis_pengecekan';

    protected $fillable = [
        'id_kriteria', 'jenis_pengecekan', 'status'
    ];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPengecekan::class);
    }
}
