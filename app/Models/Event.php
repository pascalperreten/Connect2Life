<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Ministry;
use App\Models\Contact;
use App\Models\Church;
use App\Models\User;
use App\Models\Decision;
use App\Models\Language;
use App\Models\District;

class Event extends Model
{
    protected $fillable = [
        'name',
        'city',
        'start_date',
        'end_date',
        'ministry_id',
        'slug',
        'logo_path',
        'logo_name',
        'active_invitation_link',
        'invitation_token',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'active_invitation_link' => 'boolean',
        ];
    }

    public function ministry(): BelongsTo {
        return $this->belongsTo(Ministry::class);
    }

    public function churches(): HasMany {
        return $this->hasMany(Church::class);
    }

    public function followUpMembers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'event_follow_up');
    }

    public function languages(): HasMany {
        return $this->hasMany(Language::class);
    }

    public function contacts(): HasMany {
        return $this->hasMany(Contact::class);
    }

    public function decisions(): HasMany {
        return $this->hasMany(Decision::class);
    }

    public function districts(): HasMany {
        return $this->hasMany(District::class);
    }

    public function contactForm(): HasOne {
        return $this->hasOne(ContactForm::class);
    }
}
