<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicOrganizationalInformation extends Model
{
    use HasFactory;

    protected $table = 'basic_organizational_informations';

    protected $fillable = [
        'new_membership_id',
        'ngo_type',
        'established_date',
        'vision',
        'mission',
        'key_actions',
        'key_program_focuses',
        'staff_total',
        'staff_female',
        'staff_pwd',
        'budget_year',
        'annual_budget',
        'province',
        'district',
        'commune',
        'village',
        'file',
        'target_groups',
        'membership_fee',
        'ministries_partners',
        'development_partners',
        'private_sector_partners',
    ];

    protected $casts = [
        'established_date' => 'date',
        'key_actions' => 'array',
        'key_program_focuses' => 'array',
        'target_groups' => 'array',
        'ministries_partners' => 'array',
        'development_partners' => 'array',
        'private_sector_partners' => 'array',
    ];

    public function newMembership()
    {
        return $this->belongsTo(NewMembership::class);
    }
}
