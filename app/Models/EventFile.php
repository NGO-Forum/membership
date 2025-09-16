<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFile extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'file_path', 'file_type', 'file_name'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
