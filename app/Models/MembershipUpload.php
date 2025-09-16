<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter',
        'mission_vision',
        'constitution',
        'activities',
        'funding',
        'authorization',
        'strategic_plan',
        'fundraising_strategy',
        'audit_report',
        'logo',
        'signature',
        'new_membership_id'
    ];

    public function networks()
    {
        return $this->hasMany(Network::class);
    }

    public function focalPoints()
    {
        return $this->hasMany(FocalPoints::class);
    }

    public function newMembership()
    {
        return $this->belongsTo(NewMembership::class);
    }
}
