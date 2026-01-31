<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use App\Models\Ministry;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\Contact;


class Show extends Component
{

    public $date_range = [];

    public Event $event;
    public Ministry $ministry;

    public $newContacts;

    
    public function mount(Ministry $ministry, Event $event)
    {
        $this->ministry = $ministry;
        $this->event = $event;
        //$this->authorize('view', $this->event);

        if (session()->has('success')) {
            Flux::toast(
                heading: session('success'),
                text: 'Your changes have been saved.',
                variant: 'success',
            );
        }
        $this->date_range = [
            'start' => Carbon::parse($this->event->start_date)->format('d.m.Y'),
            'end' => Carbon::parse($this->event->end_date)->format('d.m.Y'),
        ];
    }

    public function getContactNumber($event_id) {
        return Event::withCount('contacts')->where('id', $event_id)->get();
    }

    public function setNewContacts() {
        $this->newContacts = Contact::whereNull('church_id')->where('event_id', $this->event->id)->get();
    }


    public function updateChurch() {
        
        foreach ($this->newContacts as $contact) {
            if(array_key_exists($contact->id, $this->contact_church)) {
                
                $contact->update([
                    'church_id' => $this->contact_church[$contact->id],
                ]);
            }
        }

        $this->setNewContacts();
        Flux::toast(
                heading: 'Churches added successfully',
                text: 'Your changes have been saved.',
                variant: 'success',
            );
    }

    public function setDate($date) {
        return Carbon::parse($date)->format('d.m.Y');
    }

    public function createMapsUrl ($church) {
        $address = urlencode($church->street . ', ' . $church->plz . ' ' . $church->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function render()
    {
        return view('livewire.events.show', [
            'event' => $this->event,
            'date_range' => $this->date_range,
        ]);
    }

    
}
