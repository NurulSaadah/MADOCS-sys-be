<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Roles;
use App\Models\UserModules;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'role_id',
        'email',
        'password',
        'status'
    ];
   
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_id');
    }
    // public function modules()
    // {
    //     return $this->hasMany(Modules::class, 'user_id', 'id');
    // }

    public function screenAccessRoles()
{
    return $this->hasMany(ScreenAccessRoles::class, 'staff_id', 'staff_id');
}
   
}
