<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\GospelShare;
use Livewire\Attributes\Layout;
use Flux\Flux;

new class extends Component {
    public Ministry $ministry;
    public Event $event;
    public $evangelist_name;
    public $number_of_gospel_shares;

    public function mount(Ministry $ministry, Event $event)
    {
        $this->ministry = $ministry;
        $this->event = $event;
    }

    public function addGospelShares()
    {
        $this->validate([
            'number_of_gospel_shares' => 'required|integer|min:1',
            'evangelist_name' => 'required|string|max:255',
        ]);

        GospelShare::create([
            'event_id' => $this->event->id,
            'number_of_gospel_shares' => $this->number_of_gospel_shares,
            'evangelist_name' => $this->evangelist_name,
        ]);

        Flux::toast(heading: __('Gospel Shares added'), text: __('Your gospel shares have been successfully added.'), variant: 'success');
        $this->reset(['number_of_gospel_shares', 'evangelist_name']);
    }
};
?>
<div>
    <flux:heading class="text-center" size="lg">
        {{ $this->event->name }} | {{ __($this->event->city) }}
    </flux:heading>
    <flux:separator class="my-6" />

    <div class="max-w-md m-auto">
        <form wire:submit.prevent="addGospelShares" class="space-y-6">
            <flux:field>
                <flux:label>{{ __('Number of Gospel Shares') }}<span class="text-red-500">*</span>
                </flux:label>
                <flux:description>{{ __('How many people heard the gospel today?') }}
                </flux:description>
                <flux:input wire:model="number_of_gospel_shares" type="number" />
                <flux:error name="number_of_gospel_shares" />
            </flux:field>
            <flux:field>
                <flux:label>{{ __('Name Evangelist') }}<span class="text-red-500">*</span></flux:label>
                <flux:input wire:model="evangelist_name" type="text" autocomplete="name" />
                <flux:error name="evangelist_name" />
            </flux:field>
            <flux:button type="submit" class="bg-cyan-700 hover:bg-cyan-800 w-full" variant="primary">
                {{ __('Save') }}
            </flux:button>
        </form>
    </div>
    <flux:toast />
</div>
