<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\User;
use App\Models\Church;
use App\Models\Event;
use Flux\Flux;
use App\Notifications\Invitation;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Index extends Component
{
    public ?Event $event;
    public ?Church $church = null;
    public Ministry $ministry;

    public $members;

    public function mount(Event $event, Church $church) {
        $this->event = $event;
        $this->church = $church;
    }

    public function setRole($string) {
        return Str::headline($string);
    }
    
    #[On('updated')]
    public function updated() {
        $this->dispatch('invitation_sent');
        Flux::toast(
            heading: __('Changes saved'),
            text: __('Your changes have been saved successfully.'),
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.members.index');
    }
}
