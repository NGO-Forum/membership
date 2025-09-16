<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipNetwork extends Model
{
    protected $fillable = ['membership_id', 'network_name'];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}