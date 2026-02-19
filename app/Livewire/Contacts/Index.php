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
    public int $contact_with_decision = 0;
    public int $decisions = 0;
    public int $contacts_without_decision = 0;
    public int $decisions_without_contact = 0;
    public $contacts;

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->contacts = Contact::where('event_id', $event->id)->latest()->get();
        //$this->authorize('view', $this->event);
        $this->contacts_number = count($this->contacts);
        //$this->decisions = $this->event->decisions;
        $this->contact_with_decision = count(Contact::where('decision', true)->get());
        $this->contact_without_decision = count(Contact::where('decision', false)->get());
        $this->decisions_without_contact = $this->event->decisions - $this->contact_with_decision;
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
