<?php

namespace App\Models;
use App\Models\Event;
use App\Models\Church;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name',
        'event_id',
    ];

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
    public function churches(): BelongsToMany {
        return $this->belongsToMany(Church::class);
    }
    public function contacts(): BelongsToMany {
        return $this->belongsToMany(Contact::class);
    }
}
