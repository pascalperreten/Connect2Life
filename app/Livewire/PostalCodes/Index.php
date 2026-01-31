<?php

namespace App\Livewire\PostalCodes;

use Livewire\Component;
use App\Models\PostalCode;
use App\Models\Ministry;
use App\Models\Event;
use App\Livewire\Forms\PostalCodeForm;
use Livewire\Attributes\On;

class Index extends Component
{
    public PostalCodeForm $form;

    public Ministry $ministry;
    public Event $event;

    public function mount(Ministry $ministry, Event $event) {
        $this->event = $event;
        $this->form->event = $this->event;
        $this->form->setPostalCodes($this->event);
    }

    #[On('updatePostalCodes')]
    public function updatePostalCodes () {
        $this->form->setPostalCodes($this->event);
    }

    public function addPostalCode() {
        $this->form->addPostalCode();
    }
    public function render()
    {
        return view('livewire.postal-codes.index');
    }
}
