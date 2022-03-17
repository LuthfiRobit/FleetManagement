<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Petugas extends  Authenticatable implements JWTSubject
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
        'foto_petugas',
        'user',
        'password',
        'player_id',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
