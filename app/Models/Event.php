<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'organizer',
        'organizer_email',
    ];
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function files()
    {
        return $this->hasMany(EventFile::class);
    }

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }
}
