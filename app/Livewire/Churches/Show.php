<?php

namespace App\Livewire\Churches;

use Livewire\Component;
use App\Models\Church;
use App\Models\Event;
use App\Models\Ministry;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Str;
use App\Notifications\Invitation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Event $event;
    public Church $church;
    public Ministry $ministry;

    public function mount(Ministry $ministry, Event $event, Church $church) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->church = $church;

    if (session()->has('success')) {
            Flux::toast(
                heading: session('success'),
                text: __('Your changes have been saved successfully.'),
                variant: 'success',
            );
        }
    }

    public function mapsUrl ($church) {
        $address = urlencode($church->street . ', ' . $church->plz . ' ' . $church->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function addContact() {
        return URL::signedRoute('church.contacts.create', [$this->event, $this->church]);
    }

    public function render()
    {
        return view('livewire.churches.show');
    }
}
