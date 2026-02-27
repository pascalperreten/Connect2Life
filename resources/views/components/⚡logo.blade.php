<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Ministry;

new class extends Component {
    public $path;
    public Ministry $ministry;

    public function mount(Ministry $ministry)
    {
        $this->ministry = $ministry;
        $this->path = $this->ministry->logo_path;
    }

    #[On('logoUpdated')]
    public function setPath()
    {
        $this->path = $this->ministry->logo_path;
    }
};
?>
<div>
    @if ($this->ministry && $this->ministry->logo_path)
        <div class="w-30 md:w-50 flex justify-center">
            <img class="max-h-10 max-w-full" src="{{ asset('storage/' . $this->path) }}">
        </div>
    @endif
</div>
