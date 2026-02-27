<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use Illuminate\Support\Facades\URL;

new class extends Component {
    public Ministry $ministry;
    public Event $event;

    public function mount(Ministry $ministry, Event $event)
    {
        $this->ministry = $ministry;
        $this->event = $event;
    }

    public function addGospelShares()
    {
        return URL::signedRoute('evangelize.gospel-shares', ['ministry' => $this->ministry, 'event' => $this->event]);
    }
};
?>


<div class="space-y-8">

    <flux:heading>{{ __('Add Gospel Shares') }}
    </flux:heading>
    <div class="space-y-2">
        <flux:text variant="strong">{{ __('Copy this link and send it to your team leaders.') }}
        </flux:text>
        <flux:input readonly copyable value="{{ $this->addGospelShares() }}"></flux:input>
    </div>
    <div class="space-y-2">
        <flux:text variant="strong">{{ __('Or open the form directly by clicking on this button.') }}
        </flux:text>
        <flux:button target="_blank" href="{{ $this->addGospelShares() }}">{{ __('Add Gospel Shares') }}
        </flux:button>
    </div>
</div>
