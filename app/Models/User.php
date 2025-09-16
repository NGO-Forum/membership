<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
         'ngo', 'name', 'email', 'password', 'role',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isManager() { return $this->role === 'manager'; }
    public function isED() { return $this->role === 'ed'; }
    public function isBoard() { return $this->role === 'board'; }
    public function isOperations() { return $this->role === 'operations'; }


    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function newMemberships()
    {
        return $this->hasOne(NewMembership::class);
    }

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
}
