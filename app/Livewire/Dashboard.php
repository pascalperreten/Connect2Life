<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ministry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\EventInvitation;

class Dashboard extends Component
{
    public Ministry $ministry;

    #[Validate('required|string|max:255')]
    public $first_name;

    #[Validate('required|string|max:255')]
    public $last_name;

    #[Validate('required|email|max:255|unique:users,email')]
    public $email;

    #[Validate('required')]
    public $ministry_id;

    public function mount() {
        $this->ministry = Auth::user()->ministry;
        $this->ministry_id = $this->ministry->id;
    }

    public function sendInvitation()
    {
        $this->validate();

        $newMember = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => 'ministry_member',
            'ministry_id' => $this->ministry_id,
            'invitation_token' => Str::random(32),
        ]);

        $this->modal('invite-member')->close();
        $this->reset('first_name', 'last_name', 'email');

        // Logic to send invitation
        $newMember->notify(new EventInvitation($newMember));

        Flux::toast(
            heading: 'Invitation Sent',
            text: 'An invitation has been sent to the new member.',
            variant: 'success',
        );
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
