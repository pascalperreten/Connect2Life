<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Contact;
use Carbon\Carbon;

class Index extends Component
{

    public Ministry $ministry;
    public Event $event;
    public int $contacts_number = 0;
    public $contacts;

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->contacts = Contact::where('event_id', $event->id)->latest()->get();
        $this->contacts_number = count($this->contacts);
    }

    public function setDate($date) {
        return Carbon::parse($date)->format('d.m.Y');
    }

    public function render()
    {
        return view('livewire.contacts.index', [
            'event' => $this->event,
        ]);
       
    }
}
