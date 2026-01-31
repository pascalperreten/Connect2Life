<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use App\Models\Ministry;
use Illuminate\Support\Facades\URL;

class Manage extends Component
{
    public Event $event;
    public Ministry $ministry;
    public $activeTab = 'language';
    protected $listeners = ['localeChanged' => '$refresh'];

    public function mount(Ministry $ministry, Event $event) {

        $this->ministry = $ministry;
        $this->event = $event;
        //$this->authorize('update', $this->event);
    }

    //=================================================
    // function to write Tabs in URL String
    //=================================================

    // public function updatedActiveTab($value)
    // {
    //     $this->redirect(route('event.manage', ['tab' => $value, 'event' => $this->event]), navigate: true);
    // }
    // public function mount($tab = null) 

    //protected $listeners = ['item-saved' => '$refresh'];

    public function render()
    {
        return view('livewire.events.manage');
    }
}
