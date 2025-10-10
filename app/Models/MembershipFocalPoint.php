<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipFocalPoint extends Model
{
    protected $fillable = [
        'membership_id', 'network_name', 'name', 'sex', 'position', 'email', 'phone'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
