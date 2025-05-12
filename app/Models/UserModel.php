<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'profile_url',
        'image',
    ];

    public function level() {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleNama() {
        return $this->level->level_nama;
    }

    public function hasRole($role) {
        return $this->level->level_kode == $role;
    }

    public function getRole() {
        return $this->level->level_kode;
    }
}
