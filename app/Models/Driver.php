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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }   
}
