<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Contact;
use App\Livewire\Forms\ContactForm;
use Livewire\Attributes\Computed;

class EditDates extends Component
{
    public ContactForm $form;

    #[Computed]
    public $contact;
    public $contacted_date;
    public $meeting_date;
    public $follow_up_person;

    public function mount() {
        $this->form->setContact($this->contact);
    }

    public function resetContacted() {
        $this->contact->update(['contacted_date' => null, 'meeting_date' => null]);
        $this->form->setContact($this->contact);
        $this->dispatch('updated');
    }

    public function resetMeeting() {
        $this->contact->update([
            'meeting_date' => null,
            'met' => false,
            ]);
        $this->form->setContact($this->contact);
        $this->resetErrorBag('form.meeting_date');
        $this->dispatch('updated');
    }

    public function updatedForm($value, $name)
    {
        $field = str_replace('form.', '', $name);
        $this->form->setDates($field, $value);
        $this->resetErrorBag('form.meeting_date');
        $this->dispatch('updated');
    }


    public function render()
    {
        return view('livewire.contacts.edit-dates');
    }
}
