<?php

namespace App\Livewire\Languages;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use App\Models\Language;
use App\Models\Event;
use App\Models\Ministry;
use App\Livewire\Forms\LanguageForm;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Flux\Flux;

class Index extends Component
{
    public LanguageForm $form;

    public Event $event;
    public Ministry $ministry;

    public function mount(Ministry $ministry, Event $event) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->form->event = $this->event;
        $this->form->setLanguages($this->event);
    }
    

    #[On('updateLanguages')]
    public function updateLanguages () {
        $this->form->setLanguages($this->event);
    }

    public function addLanguage() {
        $this->form->addLanguage();
    }

    public function render()
    {
        return view('livewire.languages.index');
    }
}
