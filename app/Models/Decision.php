<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Event;
use App\Models\Church;

class Decision extends Model
{
    protected $fillable = [
        'number_of_decisions',
        'event_id',
        'church_id',
        'contact_id',
    ];

    public function church(): BelongsTo {
        return $this->belongsTo(Church::class);
    }
    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
    public function contact(): BelongsTo {
        return $this->belongsTo(Contact::class);
    }
}
