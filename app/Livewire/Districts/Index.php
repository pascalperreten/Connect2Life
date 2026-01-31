<?php

namespace App\Livewire\Districts;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use App\Models\District;
use App\Models\Ministry;
use App\Models\Event;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Livewire\Forms\DistrictForm;
use Illuminate\Database\Query\Builder;
use Flux\Flux;

class Index extends Component
{
    public Event $event;
    public Ministry $ministry;

    public DistrictForm $form;

    #[On('updateDistricts')]
    public function updateDistricts() {
        $this->form->setDistricts($this->event);
    }

    public function mount(Ministry $ministry, Event $event) {
        $route = Route::current();
        $this->event = $event;
        $this->form->setDistricts($this->event);
        $this->form->event = $this->event;
    }

    public function addDistrict() {
        $this->form->create();
    }

    public function render()
    {
        return view('livewire.districts.index');
    }
}
