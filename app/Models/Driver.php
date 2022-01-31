<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends  Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    public $timestamps      = false;
    protected $table        = 'tb_driver';
    protected $primaryKey   = 'id_driver';

    protected $fillable     = [
        'id_driver',
        'id_departemen',
        'no_badge',
        'nama_driver',
        'alamat',
        'umur',
        'no_tlp',
        'foto_ktp',
        'user',
        'password',
        'status_driver'
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
