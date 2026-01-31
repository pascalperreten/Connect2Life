<?php

namespace App\Livewire\Churches;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\Ministry;
use App\Models\Church;

class Index extends Component
{

    public Ministry $ministry;
    public Event $event;

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;
    }
    public function mapsUrl($church)
    {
        $address = urlencode($church->street . ', ' . $church->plz . ' ' . $church->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function render()
    {
        return view('livewire.churches.index');
    }
}
