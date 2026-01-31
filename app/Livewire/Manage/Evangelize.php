<?php

namespace App\Livewire\Manage;

use App\Models\Ministry;
use App\Models\Event;
use Illuminate\Support\Facades\Url;
use App\Models\ManageFollowUp;

use Livewire\Component;

class Evangelize extends Component
{

    public Ministry $ministry;
    public Event $event;
    public ManageFollowUp $manage_follow_up;

    public bool $church_evangelize;
    public bool $assign_directly;

    public function mount() {
        $this->manage_follow_up = ManageFollowUp::where('event_id', $this->event->id)->first();
        $this->church_evangelize = $this->manage_follow_up->church_evangelize;
        $this->assign_directly = $this->manage_follow_up->assign_directly;
    }

    public function updated($name, $value) {
        $this->manage_follow_up->update([
            $name => $value,
        ]);
    }

    public function addContact() {
        return URL::signedRoute('events.evangelize', ['ministry' => $this->ministry, 'event' => $this->event] );
    }

    public function render()
    {
        return view('livewire.manage.evangelize');
    }
}
