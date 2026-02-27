<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GospelShare extends Model
{
    protected $fillable = [
        'event_id',
        'number_of_gospel_shares',
        'evangelist_name',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
