<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'ngo_name', 'director_name', 'director_phone', 'director_email',
        'alt_name', 'alt_phone', 'alt_email',
        'membership_status', 'more_info', 'user_id', 'deadline', 'status'
    ];

    protected $casts = [
        'membership_status' => 'boolean',
        'more_info' => 'boolean',
    ];

    public function networks()
    {
        return $this->hasMany(MembershipNetwork::class);
    }

    public function focalPoints()
    {
        return $this->hasMany(MembershipFocalPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(MembershipApplication::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'membership_id');
    }
}

