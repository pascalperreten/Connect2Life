<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\GospelShare;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public Ministry $ministry;
    public Event $event;

    public function mount(Ministry $ministry, Event $event)
    {
        $this->ministry = $ministry;
        $this->event = $event;
    }
};
?>

<div class="space-y-6">
    <div class="space-y-4">

        <x-partials.header heading="{{ __('Statistics') }}" />
        @can('update', $this->event)
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $this->ministry->name }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                    {{ $this->event->name }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:separator />
        @endcan

    </div>
    <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
        <div class="space-y-6">
            <flux:button icon="arrow-left" href="{{ route('events.stats', [$this->ministry, $this->event]) }}"
                wire:navigate>
                {{ __('Statistics') }}</flux:button>
            <flux:card>
                <livewire:gospel-shares-table :model="$this->event" />

            </flux:card>
        </div>
    </livewire:event-nav>
</div>
