<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ngo extends Model
{
    use HasFactory;

    protected $fillable = ['ngo_name', 'abbreviation'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
