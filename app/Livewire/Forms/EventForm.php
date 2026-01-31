<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Event;
use App\Models\ManageFollowUp;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class EventForm extends Form
{
    public ?Event $event;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:255')]
    public $city;

    public $slug = '';

    public $date_range = [];

    public $start_date;
    public $end_date;

    #[Validate('required|integer|exists:ministries,id')]
    public $ministry_id;

    public function setEvent(Event $event) {
        $this->event = $event;
        $this->name = $event->name;
        $this->city = $event->city;
        $this->date_range = [
            'start' => $event->start_date,
            'end' => $event->end_date,
        ];
    }

    protected function rules()
    {
        $unique = Rule::unique('events', 'slug')->where('ministry_id', $this->ministry_id);

        if(isset($this->event))
            $unique->ignore($this->event->id);
        return [
            'slug' => [
                $unique,
            ],
            'ministry_id' => 'required|exists:ministries,id',
            'date_range.start' => 'required|date',
            'date_range.end' => 'required|date|after:date_range.start',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' =>
                'Diese Veranstaltung gibt es schon',
        ];
    }

    public function create() {
        
        $this->ministry_id = auth()->user()->ministry_id;
        $this->slug = Str::slug($this->name . '-' . $this->city);
        $this->validate();
        $this->start_date = $this->date_range['start'];
        $this->end_date = $this->date_range['end'];

        $event = Event::create(
            $this->only(['name', 'city', 'start_date', 'end_date', 'ministry_id', 'slug'])
        );

        ManageFollowUp::create([
            'event_id' => $event->id,
            'language' => true,
            'age' => true,
            'gender' => true,
            'district' => true,
            'postal_code' => true,
            'evangelist_name' => true,
            'church_evangelize' => false,
            'assign_directly' => false,
        ]);
    }

    public function update() {
        $this->ministry_id = auth()->user()->ministry_id;
        $this->slug = Str::slug($this->name . '-' . $this->city);
        $this->validate();
        $this->start_date = $this->date_range['start'];
        $this->end_date = $this->date_range['end'];
        

        $this->event->update(
            $this->only(['name', 'city', 'start_date', 'end_date', 'slug'])
        );
        
    }
}
