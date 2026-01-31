<?php

namespace App\Livewire\Navigation;
use App\Models\Ministry;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Menu extends Component
{
    public Ministry $ministry;

    public function mount() {
        $this->ministry = Auth::user()->ministry;
    }
    
    public function render()
    {
        return view('livewire.navigation.menu');
    }
}
