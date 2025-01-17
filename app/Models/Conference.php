<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    public function attendees ()
    {
        return $this->hasMany(Attendee::class,'conference_id');
    }
}
