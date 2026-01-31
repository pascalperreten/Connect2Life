<?php

namespace App\Livewire\Contacts;

use Livewire\Component;
use Flux\Flux;
use App\Models\Contact;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Church;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\ContactAdded;

class Assign extends Component
{

    public Event $event;
    public Ministry $ministry;
    public $class = '';
    public $contact_church = [];
    public $plzChurches = [];
    public $districtChurches = [];
    public $languageChurches = [];
    public ?Contact $currentContact = null;
    public $showChurches = false;
    public $newContacts = [];
    public $newForeignContacts;
    public $withChurches = [];

    
    public function mount(Ministry $ministry, Event $event) {
        $this->event = $event;
        $this->setNewContacts();
        $this->setNewForeignContacts();
    }

    public function postalCodeUrl($contact)
    {
        $address = urlencode($contact->postalCode->first()->name . ', ' . $contact->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }
    public function districtUrl($contact)
    {
        $address = urlencode($contact->district->first()->name . ', ' . $contact->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function getContactNumber($church_id) {
        $church = Church::findOrFail($church_id);
        return $church->contacts()->where('assigned', true)->count();
    }

    public function setNewContacts() {
        $this->newContacts =  Contact::where('assigned', false)->where('event_id', $this->event->id)->where('foreign_city', false)->get();
        $this->contact_church = Contact::where('event_id', $this->event->id)
        ->whereNotNull('church_id')
        ->where('assigned', false)
        ->pluck('church_id', 'id')
        ->toArray();
    }
    public function setNewForeignContacts() {
        $this->newForeignContacts =  Contact::where('assigned', false)->where('event_id', $this->event->id)->where('foreign_city', true)->get();
    }


    public function closeAndResetChurches() {
        $this->showChurches = false;
        $this->currentContact = null;
        $this->plzChurches = [];
        $this->districtChurches = [];
        $this->languageChurches = [];
    }

    public function checkChurches($id) {
        $this->showChurches = true;
        $this->currentContact = Contact::findOrFail($id);
        $this->plzChurches = $this->checkPlz($this->currentContact);
        $this->districtChurches = $this->checkDistrict($this->currentContact);
        $this->languageChurches = $this->checkLanguage($this->currentContact);
    }

    public function checkPlz($contact) {
        $postalCodesId = $contact->postalCode()->pluck('postal_codes.id');
        $churches = Church::whereHas('postalCodes', function (Builder $query) use ($postalCodesId) {
            $query->whereIn('postal_codes.id', $postalCodesId);
        })->get();
        return $churches;
    }

    public function checkDistrict($contact) {
        $districtsIds = $contact->district()->pluck('districts.id');
        $churches = Church::whereHas('districts', function (Builder $query) use ($districtsIds) {
            $query->whereIn('districts.id', $districtsIds);
        })->get();
        return $churches;
    }

    public function checkLanguage($contact) {
        $languagesIds = $contact->languages()->pluck('languages.id');
        $churches = Church::whereHas('languages', function (Builder $query) use ($languagesIds) {
            $query->whereIn('languages.id', $languagesIds);
        })->get();
        return $churches;
    }

    public function updateChurch() {
        if(empty($this->contact_church)) {
            return;
        }
        $churchesWithContacts = [];
        
        foreach ($this->newContacts as $contact) {
            if(array_key_exists($contact->id, $this->contact_church)) {
                
                $contact->update([
                    'church_id' => $this->contact_church[$contact->id],
                    'assigned' => true,
                ]);
                $churchesWithContacts[] = $contact->church_id;
                // $contact->church->followUpContact->notify(new ContactAdded($this->event->ministry, $this->event, $contact->church));
            }

        }
        
        foreach(array_unique($churchesWithContacts) as $churchId) {
            $church = Church::findOrFail($churchId);
            if($church->followUpContact) {
                $church->followUpContact->notify(new ContactAdded($this->event->ministry, $this->event, $church));
            }
            
        }

        $this->setNewContacts();
        Flux::toast(
                heading: 'Churches added successfully',
                text: 'Your changes have been saved.',
                variant: 'success',
            );
    }

    public function render()
    {
        return view('livewire.contacts.assign', [
            'currentContact' => $this->currentContact,
            'contacts' => $this->newContacts,
            'class' => $this->class,
        ]);
    }
}
