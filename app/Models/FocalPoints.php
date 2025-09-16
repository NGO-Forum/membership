<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocalPoints extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_upload_id','network_name','name','sex','position','email','phone'
    ];

    public function newMembership()
    {
        return $this->belongsTo(MembershipUpload::class);
    }
}
