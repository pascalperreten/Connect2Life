<?php

namespace App\Livewire\Ministry;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\User;
use App\Models\Event;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;
use App\Notifications\Invitation;
use Livewire\Attributes\Validate;

class Index extends Component
{

    public Ministry $ministry;

    public User $user;

    public function mount() {
        $this->user = Auth::user();
        $this->ministry = $this->user->ministry;
        // if($this->user->role === 'follow_up') {
        //     $this->redirect(route('events.show', [$ministry, $this->user->event]));
        // }
        // if(in_array($this->user->role === ['pastor', 'ambassador', 'church_member'])) {
        //     $this->redirect(route('events.show', [$ministry, $this->user->event]));
        // }
        // $this->authorize('view', $this->ministry);
    }

    public function newContacts($event) {
        $newContacts = Contact::where('event_id' , $event->id)->where('church_id', null)->first();
        return $newContacts;
    }

    public function showEvent($event) {
        return $this->redirect(route('events.show', [$this->ministry, $event['slug']]), navigate: true);
    }
    
    public function render()
    {
        return view('livewire.ministry.index');
    }
}


