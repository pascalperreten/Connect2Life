<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Livewire\Forms\ContactForm;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\Contact;
use App\Livewire\Forms\DistrictForm;
use App\Livewire\Forms\LanguageForm;

class Edit extends Component
{
    public Ministry $ministry;
    public Event $event;
    public Contact $contact;
    public DistrictForm $district_form;
    public LanguageForm $language_form;
    
    public ContactForm $form;

    public function mount(Ministry $ministry, Event $event, Contact $contact) {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->contact = $contact;
        //$this->authorize('update', $this->contact);
        $this->form->setContact($contact);
        $this->district_form->setDistricts($this->event);
        $this->language_form->setLanguages($this->event);
    }

    public function save() {
        $this->form->update($this->contact);
    }

    public function render()
    {
        return view('livewire.contacts.edit');
    }
}
