<?php

namespace App\Livewire\Churches;

use Livewire\Component;
use App\Models\Event;
use App\Models\Church;
use App\Models\Ministry;

use App\Livewire\Forms\ChurchForm;
use App\Livewire\Forms\DistrictForm;
use App\Livewire\Forms\LanguageForm;
use App\Livewire\Forms\PostalCodeForm;
use Livewire\Attributes\On;
use Flux\Flux;

class Edit extends Component
{

    public Event $event;
    public Church $church;
    public Ministry $ministry;

    public function render()
    {
        return view('livewire.churches.edit');
    }
}
