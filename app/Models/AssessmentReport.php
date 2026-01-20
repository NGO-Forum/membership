<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentReport extends Model
{
    use HasFactory;


    protected $fillable = [
        'new_membership_id',
        'ngo_type',
        'established_date',
        'vision',
        'mission',
        'address',
        'key_actions',
        'membership_fee',
        'summary_html',
        'checklist_json',
        'conclusion_html',
        'status',
        'manager_approved_at',
        'ed_approved_at',
        'board_approved_at',
    ];


    protected $casts = [
        'established_date' => 'date',
        'membership_fee'   => 'decimal:2',
        'key_actions' => 'array',
        'summary_html'   => 'array',
        'checklist_json'=> 'array',
        'conclusion_html'=> 'array',
        'manager_approved_at' => 'datetime',
        'ed_approved_at' => 'datetime',
        'board_approved_at' => 'datetime',
    ];


    public function membership()
    {
        return $this->belongsTo(NewMembership::class, 'new_membership_id');
    }

    
}
