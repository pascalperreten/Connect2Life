<?php

namespace App\Models;
use App\Models\Event;
use App\Models\Church;
use App\Models\Contact;
use App\Models\LanguageTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'event_id',
    ];

    public function translations(): HasMany {
        return $this->hasMany(LanguageTranslation::class);
    }

    public function translation(): HasOne {
        return $this->hasOne(LanguageTranslation::class)->where('locale', app()->getLocale());
    }

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
