<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $fillable = [
        'event_id',
        'number_of_decisions',
        'evangelist_name',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
