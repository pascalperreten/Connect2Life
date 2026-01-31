<?php

namespace App\Livewire\Ministry;

use Livewire\Component;
use App\Models\User;
use App\Models\Ministry;
use Livewire\Attributes\On;
use Flux\Flux;

class Members extends Component
{
    public Ministry $ministry;
    public $members;

    public function mount(Ministry $ministry) {
        $this->ministry = $ministry;
        //$this->authorize('update', $this->ministry);
        $this->getMembers();

        if(session()->has('success')) {
            Flux::toast(
                heading: session('success'),
                text: __('An invitation has been sent to the new member.'),
                variant: 'success',
            );
        }
    }

    #[On('invitation_sent')]
    public function getMembers() {
        $this->members = User::where('ministry_id', $this->ministry->id)->where('church_id', null)->get();
    }

    public function render()
    {
        return view('livewire.ministry.members');
    }
}
