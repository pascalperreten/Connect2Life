<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\Form;
use App\Models\District;
use App\Models\Event;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Flux\Flux;

class DistrictForm extends Form
{
    public $districts = [];

    public $edit = [];

    public $name = '';

    public Event $event;

    public District $district;
    

    protected function rules() {
        $unique = Rule::unique('districts')->where('event_id', $this->event->id);

        if (isset($this->district->id)) {
            $unique->ignore($this->district->id);
        }
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $unique,
            ]
            ];
    }
    public function create() {
        $this->validateOnly('name');
        $newDistrict = District::create([
            'event_id' => $this->event->id,
            'name' => $this->name,
        ]);
        Flux::toast(
            heading: 'District added',
            text: 'The district has been added successfully.',
            variant: 'success',
        );
        $this->setDistricts($this->event);
        $this->reset('name');
        return $newDistrict;
    }

    

    public function editItem($id) {
        $this->edit = [
            'district' => $id,
        ];
    }

    public function update(District $district) {
        $this->validateOnly('name');
        $district->update([
            'name' => $this->name,
        ]);
        Flux::toast(
            heading: 'District updated',
            text: 'The district has been updated successfully.',
            variant: 'success',
        );
        $this->edit = [];
    }

    public function delete($id) {
        District::where('id', $id)->delete();
        Flux::modals()->close();
        Flux::toast(
            heading: 'District deleted',
            text: 'The district has been deleted successfully.',
            variant: 'success',
        );
        $this->edit = [];
    }

    public function setDistricts($event) {
        $this->districts = District::where('event_id', $event->id)
            ->orderBy('name', 'asc')
            ->get();
    }
}
