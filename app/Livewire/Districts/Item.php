<?php

namespace App\Livewire\Districts;

use Livewire\Component;
use App\Models\District;
use App\Models\Event;
use App\Livewire\Forms\DistrictForm;
use Illuminate\Support\Facades\Route;
use Flux\Flux;

class Item extends Component
{
    public DistrictForm $form;

    public District $district;

    public function mount($district, $event) {
        $this->form->event = $event;
        $this->district = $district;
        $this->form->name = $district->name;
        $this->form->district = $this->district;
    }

    public function editItem($id) {
        $this->form->editItem($id);
    }


    public function updateDistrict($id) {
        $this->form->update($this->district);
        $this->dispatch('updateDistricts');
    }

    public function deleteDistrict($id) {
        $this->form->delete($id);
        $this->dispatch('updateDistricts');
    }

    public function updated() {
        $this->form->update($this->district);
    } 

    public function render()
    {
        return view('livewire.districts.item');
    }
}
