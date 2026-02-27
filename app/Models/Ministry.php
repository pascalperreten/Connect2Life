<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\User;
use App\Models\Event;
class Ministry extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    protected $fillable = [
        'name',
        'logo_path',
        'logo_name',
        'user_id',
        'slug',
    ];

    public function members(): HasMany {
        return $this->hasMany(User::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }

    public function decisions(): HasManyThrough {
        return $this->hasManyThrough(Decision::class, Event::class);
    }

    public function contacts(): HasManyThrough {
        return $this->hasManyThrough(Contact::class, Event::class);
    }
    
    public function gospelShares(): HasManyThrough {
        return $this->hasManyThrough(GospelShare::class, Event::class);
    }
}
