<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Language;

class LanguageTranslation extends Model
{
    protected $fillable = [
        'name',
        'locale',
        'event_id',
        'language_id',
    ];

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class);
    }
}
