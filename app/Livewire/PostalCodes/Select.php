<?php

namespace App\Livewire\PostalCodes;

use Livewire\Component;
use App\Models\Event;
use App\Livewire\Forms\PostalCodeForm;
use Livewire\Attributes\Modelable;

class Select extends Component
{
    public PostalCodeForm $form;

    public Event $event;

    #[Modelable]
    public ?int $value = null;


    public function mount() {
        $this->form->setPostalCodes($this->event);
    }

    public function createPostalCode() {
        $this->form->event = $this->event;
        $newPostalCode = $this->form->addPostalCode();
        $this->form->setPostalCodes($this->event);
        $this->value = $newPostalCode->id;
        //dd($this->contact_form->postal_code);
    }

    public function render()
    {
        return view('livewire.postal-codes.select');
    }
}
