<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'name',
        'gender',
        'age',
        'vulnerable',
        'position',
        'organization',
        'org_location',
        'village',
        'commune',
        'district',
        'residence_type',
        'dsa_covered_by',
        'phone',
        'email',
        'signature',
        'allow_photos',
        'ngo_id',
        'new_membership_id',
        'membership_id',
    ];

    protected $casts = [
        'allow_photos' => 'boolean',
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function newMembership()
    {
        return $this->belongsTo(NewMembership::class, 'new_membership_id');
    }
    public function ngo()
    {
        return $this->belongsTo(Ngo::class);
    }
}
