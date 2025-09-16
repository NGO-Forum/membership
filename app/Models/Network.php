<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = ['membership_upload_id', 'network_name'];

    public function newMembership()
    {
        return $this->belongsTo(MembershipUpload::class);
    }
}
