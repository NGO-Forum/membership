<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $fillable = [
        'mailing_address',
        'physical_address',
        'facebook',
        'website',
        'comm_channels',
        'comm_phones',
        'letter',
        'constitution',
        'activities',
        'funding',
        'registration',
        'strategic_plan',
        'fundraising_strategy',
        'audit_report',
        'signature',
        'vision',
        'mission',
        'goal',
        'objectives',
        'director_name',
        'title',
        'date',
        'membership_id',
    ];

    protected $casts = [
        'comm_channels' => 'array',
        'comm_phones' => 'array',
        'date' => 'date',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
