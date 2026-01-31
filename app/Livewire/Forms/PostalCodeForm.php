<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use App\Models\Event;
use App\Models\PostalCode;
use Illuminate\Validation\Rule;
use Flux\Flux;
use Illuminate\Database\Query\Builder;
use Livewire\Form;

class PostalCodeForm extends Form
{
    public Event $event;
    public ?PostalCode $postal_code;
    public string $name = '';

    public $postal_codes;
    public $edit = [];

    protected function rules() {
        $unique = Rule::unique('postal_codes')->where('event_id', $this->event->id);

        if (isset($this->postal_code)) {
            $unique->ignore($this->postal_code->id);
        }
        return [
            'name' => [
                'required',
                'integer',
                $unique,
            ],
            ];
    }

    public function editItem($id) {
        $this->edit = [
            'postal_code' => $id,
        ];
    }

    public function setPostalCodes($event) {
        $this->postal_codes = PostalCode::where('event_id', $event->id)
            ->orderBy('name', 'asc')
            ->get();
    }
    public function setPostalCodese($event) {
        $this->postal_codes = PostalCode::where('event_id', $event->id)
            ->orderBy('name', 'asc')
            ->get();
            dd($this->postal_codes);
    }

    public function addPostalCode() {
        $this->validateOnly('name');
        $newPostalCode = PostalCode::create([
            'event_id' => $this->event->id,
            'name' => $this->name,
        ]);
        Flux::toast(
            heading: 'Postleitzahl hinzugefügt',
            text: 'Die Postleitzahl wurde erfolgreich hinzugefügt.',
            variant: 'success',
        );

        $this->setPostalCodes($this->event);
        $this->reset('name');
        return $newPostalCode;
    }

    public function updatePostalCode($id) {
        $this->validateOnly('name');
        PostalCode::where('id', $id)->update([
            'name' => $this->name,
        ]);
        Flux::toast(
            heading: 'Postleitzahl aktualisiert',
            text: 'Die Postleitzahl wurde erfolgreich aktualisiert.',
            variant: 'success',
        );
        $this->edit = [];
    }
    public function deletePostalCode($id) {
        PostalCode::where('id', $id)->delete();
        Flux::modals()->close();
        Flux::toast(
            heading: 'Postleitzahl gelöscht',
            text: 'Die Postleitzhalt wurde erfolgreich gelöscht.',
            variant: 'success',
        );
        $this->edit = [];
    }
}
