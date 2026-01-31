<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Church;
use App\Models\Decision;
use App\Models\ManageFollowUp;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactForm extends Form
{
    
    use AuthorizesRequests;
    public $with_contact;

    public $number_of_decisions = '';

    public $form_fields;

    public $resetCounter = 0;
    public string $name = '';
    public $contact;
    public string $gender = '';
    public array $language = [];
    public array $districts = [];
    public ?int $district = null;
    public array $postal_codes = [];
    public $postal_code = '';
    public string $age = '';
    public string $way_to_get_in_contact = '';
    public string $phone = '';
    public $contacted_date;
    public $meeting_date;
    public bool $met = false;
    public array $social_media = [];
    public string $social_platform = '';
    public string $other_platform = '';
    public string $user_name = '';
    public string $url = '';
    public string $email = '';
    public string $other_contact = '';
    public $foreign_city;
    public string $city = '';
    public bool $assigned = false;
    public string $comments = '';
    public string $decision = '';
    public string $evangelist_name = '';
    public $event_id;
    public $church_id = null;
    public $evangelist_church_id = null;
    public $invalid_contact_details = 0;
    public $not_interested = false;
    public $part_of_church = false;
    public $fillable = ['name', 'way_to_get_in_contact', 'assigned', 'invalid_contact_details', 'foreign_city', 'city', 'comments', 'decision', 'event_id', 'church_id', 'evangelist_church_id'];

    public function setContactForm($event) {
        $this->form_fields = ManageFollowUp::where('event_id', $event->id)->first();
    }
    
    public function setContact(Contact $contact) {
        $this->contact = $contact;
        $this->name = $contact->name;
        $this->gender = $contact->gender;
        $this->contacted_date = $contact->contacted_date;
        $this->meeting_date = $contact->meeting_date;
        $this->met = $contact->met;
        $this->not_interested = $contact->not_interested;
        $this->invalid_contact_details = (int) $contact->invalid_contact_details;
        $this->part_of_church = $contact->part_of_church;
        
        $this->language = $contact->languages()->pluck('languages.id')->toArray();
        $this->districts = $contact->district()->pluck('districts.id')->toArray();
        $this->postal_codes = $contact->postalCode()->pluck('postal_codes.id')->toArray();
        $this->age = $contact->age;
        $this->way_to_get_in_contact = $contact->way_to_get_in_contact;
        $this->contact_information = $contact->contact_information;

        if($contact->way_to_get_in_contact === 'phone') {
            $this->phone = $contact->phone;
        }
        if($contact->way_to_get_in_contact === 'social_media') {
            $this->social_platform = $contact->social_media['platform'];
            $this->user_name = $contact->social_media['user_name'];

            if(isset($contact->social_media['url'])) {
                $this->url = $contact->social_media['url'];
            }
        }
        if($contact->way_to_get_in_contact === 'email') {
            $this->email = $contact->email;
        }
        if ($contact->way_to_get_in_contact === 'other_contact') {
            $this->other_contact = $contact->other_contact;
        }
        $this->foreign_city = $contact->foreign_city;
        $this->decision = $contact->decision;
        $this->evangelist_name = $contact->evangelist_name;
        
        $this->city = $contact->city;
        $this->comments = $contact->comments;
    }
    public function setDates($name, $value) {

        if($name === 'contacted_date') {
            $this->contacted_date = Carbon::create($value);
        }
        if($name === 'met' && $value !== true) {
            $this->contact->update(['part_of_church' => false]);
            $this->part_of_church = false;
        }
        
        $this->contact->update([$name => $value]);
    }

    public function validateNext($page) {
        if($page === 1) {
            $validate = ['name'];
            if($this->form_fields->age) {
                $validate[] = 'age';
                $this->fillable[] = 'age';
            }
            if($this->form_fields->language) {
                $validate[] = 'language';

            }
            if($this->form_fields->gender) {
                $validate[] = 'gender';
                $this->fillable[] = 'gender';
            }
                
            $this->validateOnlyStep($validate);
        }
        elseif($page === 2) {
            //$validate = [];
            $this->validateOnlyStep(['way_to_get_in_contact']);
            if($this->way_to_get_in_contact === "phone") {
                $this->validateOnlyStep(['phone']);
                $this->fillable[] =  'phone';
            }   
            elseif ($this->way_to_get_in_contact === 'social_media') {
                $validate = ['social_platform', 'user_name', 'url'];
                //$this->validateOnlyStep(['social_platform', 'user_name', 'url']);
                $this->social_media['platform'] = $this->social_platform;
                $this->social_media['user_name'] = $this->user_name;
                $this->social_media['url'] = $this->url;
                $this->fillable[] = 'social_media';

                if($this->social_platform === 'other_platform') {
                    $validate[] = 'other_platform';
                    // $this->validateOnlyStep(['other_platform']);
                    $this->social_media['platform'] = $this->other_platform;
                }
                $this->validateOnlyStep($validate);
            }
            elseif ($this->way_to_get_in_contact === 'email') {
                $this->validateOnlyStep(['email']);
                $this->fillable[] =  'email';
            }
            elseif($this->way_to_get_in_contact === 'other_contact') {
                $this->validateOnlyStep(['other_contact']);
                $this->fillable[] =  'other_contact';
            }
        }

        elseif($page === 3) {
            $validate = [];

            if(!isset($this->foreign_city)) {
                $this->validateOnlyStep(['foreign_city']);
            }

            if($this->foreign_city) {
                $this->validateOnlyStep(['city']);
            }
            else {
                if ($this->form_fields->postal_code) {
                    $validate[] = 'postal_code';
                }

                if($this->form_fields->district) {
                    $validate[] = 'district';
                } 

                if(!empty($validate)) {
                    $this->validateOnlyStep($validate);
                }
                
             } 
        }
    }

    // Create Contact and initial Decision

    public function create(Event $event, ?Church $church) {
        $validate = ['decision', 'comments'];
        if($this->form_fields->evangelist_name) {
            $validate[] = 'evangelist_name';
            $this->fillable[] = 'evangelist_name';
        }
        $this->validateOnlyStep($validate);
        
        if($this->city === '') {
            $this->city = $event->city;
        }
        

        if($church) {
            $this->church_id = $church->id;
            $this->evangelist_church_id = $church->id;
            $assign_directly = ManageFollowUp::where('event_id', $event->id)->pluck('assign_directly')->first();
            if($assign_directly) {
                $this->assigned = true;
            }
        }

        $this->event_id = $event->id;

        $contact = Contact::create($this->only(array_values($this->fillable)));
        if($this->decision) {
            $event->increment('decisions');
        }

        if(!empty($this->language)) {
            $contact->languages()->sync($this->language);
        }
        if(!empty($this->district)) {
            $contact->district()->sync($this->district);
        }
        if(!empty($this->postal_code)) {
            $contact->postalCode()->sync($this->postal_code);
        }
        
        $this->reset();
        $this->resetCounter++;
    }

    public function addDecisions(Event $event) {
        $this->validateOnlyStep(['number_of_decisions']);
        $event->increment('decisions', $this->number_of_decisions);
        $this->reset();
    }

    public function setVariables() {
        if($this->way_to_get_in_contact === "phone") {
        $this->contact_information = ['phone' => $this->phone];
        } else if($this->way_to_get_in_contact === "email") {
        $this->contact_information = ['email' => $this->email];
        } elseif($this->way_to_get_in_contact === 'social_media') {
        $this->contact_information = ['social_media' => $this->social_platform, 'user_name' => $this->user_name, 'url' => $this->url];
            if($this->social_platform === 'other'){
                $this->contact_information = ['social_media' => $this->other_platform];
            }
        } elseif($this->way_to_get_in_contact === 'other') {
            $this->contact_information = ['other' => $this->other];
        }
    }

    public function meetingToday() {
        $this->meeting_date = Carbon::today();
        $this->validateOnly('meeting_date');
        $this->contact->update(['meeting_date' => $this->meeting_date]);
        $this->setContact($this->contact);
    }

    protected $rules =  [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:20',
            'language' => 'required|array',
            'age' => 'required|string|max:20',
            'way_to_get_in_contact' => 'required|string|max:50',
            'foreign_city' => 'required',
            'postal_codes' => 'required|array',
            'postal_code' => 'required',
            'decision' => 'required|boolean',
            'evangelist_name' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'phone' => 'required|regex:/^\+?[0-9\s\-]{7,15}$/|max:255',
            'email' => 'required|email|max:255',
            'social_platform' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'other_platform' => 'required|string|max:255',
            'other_contact' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'districts' => 'required|array',
            'district' => 'required',
            'number_of_decisions' => 'required|int',
            'contacted_date' => 'date',
            'meeting_date' => 'date|after:contacted_date'
        ];
    public function validateOnlyStep(array $fields)
    {
        $rules = collect($this->rules)
            ->only($fields)
            ->toArray();
        $this->validate($rules);
    }

    public function update(Contact $contact) {
        $this->authorize('update', $contact);
        $this->setVariables();
        $this->validate();
        $contact->update($this->only([
            'name',
            'gender',
            'age',
            'way_to_get_in_contact',
            'contact_information',
            'foreign_city',
            'city',
            'comments',
            'decision',
            'evangelist_name',
        ]));

        if(!empty($this->language)) {
            $contact->languages()->sync($this->language);
        }
        if($this->district !== '') {
            $contact->district()->sync($this->district);
        }
        if($this->postal_code !== '') {
            $contact->postalCode()->sync($this->postal_code);
        }
    }

    public function delete(Contact $contact) {
        $this->authorize('delete', $contact);
        $this->contact->delete();
    }


}
