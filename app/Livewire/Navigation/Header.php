<?php

namespace App\Livewire\Navigation;

use App\Models\Ministry;

class Header extends Component
{
    public Ministry $ministry;
    public function render()
    {
        return view('components.layouts.app.header');
    }
}
