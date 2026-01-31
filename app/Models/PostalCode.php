<?php

namespace App\Models;

use App\Models\Church;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostalCode extends Model
{

    protected $fillable = [
        'name',
        'event_id',
    ];
    public function churches(): BelonsToMany {
        return $this->belonsToMany(Church::class);
    }
    public function contacts(): BelonsToMany {
        return $this->belonsToMany(Contact::class);
    }
}
