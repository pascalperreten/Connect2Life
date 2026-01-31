<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use App\Models\Ministry;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Events extends Component
{

    public $ministry;
    public bool $open = false;

    public function change() {
        $this->open = !$this->open;
    }

    public function slug($string) {
        return Str::headline($string);
    }
    

    public function render()
    {
        return view('livewire.navigation.events' , [
            'events' => auth()->user()->ministry->events()->get(),
        ]);
    }
}
