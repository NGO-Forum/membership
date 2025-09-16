<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'name', 'email', 'phone', 'organization', 'gender', 'position', 'ngo_id', 'membership_id', 'new_membership_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ngo()
    {
        return $this->belongsTo(Ngo::class);
    }

    public function membership()
    {
        return $this->belongsTo(NewMembership::class, 'new_membership_id');
    }
    
    public function oldMembership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
