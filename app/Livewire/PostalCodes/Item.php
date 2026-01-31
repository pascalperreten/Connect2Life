<?php

namespace App\Livewire\PostalCodes;

use Livewire\Component;
use App\Models\PostalCode;
use App\Models\Event;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\PostalCodeForm;

class Item extends Component
{
    public PostalCodeForm $form;
    public PostalCode $postal_code;

    public function mount($postal_code, $event) {
        $this->form->event = $event;
        $this->postal_code = $postal_code;
        $this->form->name = $postal_code->name;
        $this->form->postal_code = $this->postal_code;
    }

    public function editItem($id) {
        $this->form->editItem($id);
    }


    public function updatePostalCode($id) {
        $this->form->updatePostalCode($id);
        $this->dispatch('updatePostalCode');
    }

    public function deletePostalCode($id) {
        $this->form->deletePostalCode($id);
        $this->dispatch('updatePostalCodes');
    }
    public function render()
    {
        return view('livewire.postal-codes.item');
    }
}
