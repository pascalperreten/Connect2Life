<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Contact;

class Show extends Component
{
    public Ministry $ministry;
    public Event $event;
    public Contact $contact;

    public function mount(Ministry $ministry, Event $event, Contact $contact) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->contact = $contact;
        //$this->authorize('view', $this->contact);
    }

public function render()
    {
        return view('livewire.contacts.show', [
            'contact' => $this->contact,
        ]);
    }

}
