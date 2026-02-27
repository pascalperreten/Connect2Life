<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use App\Models\Ministry;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Livewire\Attributes\Url;

#[Title('Events')] 
class Index extends Component
{
    use WithPagination;

    public Ministry $ministry;
    public Event $event;

    #[Url]
    public $q = '';

    public $activeTab = 'events';

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;

        if($this->q === 'create') {
            $this->activeTab = 'create-event';
            
        }
    }

   
    #[Computed]
    public function events()
    {
        return Event::where('ministry_id',$this->ministry->id)
            ->paginate(5);
        $this->activeTab = 'events';
    }   

    #[On('event_created')]
    public function refresh()
    {
        $this->events();
        $this->activeTab = 'events';
        $this->create = '';
    }   

    #[On('event-updated')]
    public function closeModal() {
        Flux::modals()->close();
    }

    public function update() {
        $this->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $this->event->save();

        session()->flash('message', 'Event updated successfully.');
    }   

    public function render()
    {
        return view('livewire.events.index');
    }
}
