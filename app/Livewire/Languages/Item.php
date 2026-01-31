<?php

namespace App\Livewire\Languages;

use Livewire\Component;
use App\Models\Language;
use App\Models\Event;
use Livewire\Attributes\Validate;
use App\Livewire\Forms\LanguageForm;

class Item extends Component
{
    public LanguageForm $form;
    public Language $language;

    public function mount($language, $event) {
        $this->form->event = $event;
        $this->language = $language;
        $this->form->name = $language->translation->name;
        $this->form->language = $this->language;
    }

    public function editItem($id) {
        $this->form->editItem($id);
    }


    public function updateLanguage($id) {
        $this->form->updateLanguage($id);
        $this->dispatch('updateLanguages');
    }

    public function deleteLanguage($id) {
        $this->form->deleteLanguage($id);
        $this->dispatch('updateLanguages');
    }

     public function render()
    {
        return view('livewire.languages.item');
    }
}
