<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Livewire\Forms\EventForm;
use Illuminate\Support\Facades\Route;
use Flux\Flux;

class Edit extends Component
{

    public EventForm $form;
    public Ministry $ministry;
    public Event $event;

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;

        $this->form->setEvent($this->event);
    }

    public function delete() {
        $this->event->delete();
        $this->dispatch('event-updated');
        Flux::toast(
            heading: 'Event wurde gelöscht!',
            text: 'Dieser Event wurde erfolgreich gelöscht.',
            variant: 'success',
        );
    }

    public function update() {
        $this->form->update();
        
        $this->dispatch('event-updated');
        Flux::toast(
            heading: 'Veranstaltung geändert',
            text: 'Deine Änderungen wurden erfolgreich gespeichert.',
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.events.edit');
    }
}
