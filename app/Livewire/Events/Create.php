<?php

namespace App\Livewire\Events;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\ContactForm;
use App\Livewire\Forms\EventForm;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

#[Title('Create Event')]
class Create extends Component
{
    public EventForm $form;
    public Ministry $ministry;

    public function mount(Ministry $ministry) {
        $this->ministry = $ministry;
    }

    protected $rules = [
        'newDistrict' => 'required|string|max:30',
    ];

    public function create() {
        if(Auth::user()->can('create', Event::class)) {
            $this->form->create();
            Flux::toast(
                heading: 'Event erstellt!',
                text: 'Event wurde erfolgreich hinzugefügt.',
                variant: 'success',
            );
            $this->dispatch('event_created');
        }
        

    }

    public function render()
    {
        return view('livewire.events.create');
    }
}
