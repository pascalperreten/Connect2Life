<?php

namespace App\Livewire\Churches;

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Church;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Str;
use App\Notifications\Invitation;
use Livewire\Attributes\Validate;

class Members extends Component
{
    public Event $event;
    public Ministry $ministry;
    public Church $church;

    #[Validate('required|string|max:255')]
    public $first_name;

    #[Validate('required|string|max:255')]
    public $last_name;

    #[Validate('required|email|max:255|unique:users,email')]
    public $email;

    #[Validate('required|string|max:255')]
    public $role;

    #[Validate('required')]
    public $church_id;

    #[Validate('required')]
    public $ministry_id;

    #[Validate('required')]
    public $invitation_token;

    public function mount(Ministry $ministry, Event $event, Church $church) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->church = $church;
        $this->church_id = $this->church->id;
        $this->ministry_id = $this->event->ministry_id;
        $this->invitation_token = Str::random(32);
        
        if(session()->has('success')) {
            Flux::toast(
                heading: session('success'),
                text: __('An invitation has been sent to the new member.'),
                variant: 'success',
            );
        }
    }

    public function setRole($string) {
        return Str::headline($string);
    }

    public function send(User $newMember) {
        $newMember->notify(new Invitation($newMember));

        Flux::toast(
            heading: 'Invitation Sent',
            text: 'An invitation has been sent to the new member.',
            variant: 'success',
        );
    }

     public function sendInvitation()
    {
        $this->validate();

        $newMember = User::create(
            $this->only([
            'first_name',
            'last_name',
            'email',
            'role',
            'ministry_id',
            'church_id',
            'invitation_token',
        ]));

        $this->modal('invite-member')->close();
        $this->reset('first_name', 'last_name', 'email', 'role');

        // Logic to send invitation
        $this->send($newMember);
        
    }

    public function render()
    {
        return view('livewire.churches.members');
    }
}
