<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Decision;
use App\Models\Contact;

new class extends Component
{
    public Ministry $ministry;
    public Event $event;
    public $numberDecisions = 0;
    public $contacts = 0;
    public $totalDecisons = 0;

    public function mount(Ministry $ministry, Event $event)
    {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->numberDecisions = Decision::where('event_id', $this->event->id)->pluck('number_of_decisions')->sum();
        $this->contacts = Contact::where('event_id', $this->event->id)->where('decision', true)->count();
        $this->totalDecisons = $this->numberDecisions + $this->contacts;
    }

    public function date($date)
    {
        return \Carbon\Carbon::parse($date)->format('d.m.Y | H:i');
    }

    #[\Livewire\Attributes\Computed]
    public function decisions()
    {
        return Decision::where('event_id', $this->event->id)->latest()->paginate(50);
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
                <flux:table :paginate="$this->decisions()">
                    <flux:table.columns>

                        <flux:table.column>{{ __('Date') }}</flux:table.column>
                        <flux:table.column>{{ __('Name Evangelist') }}</flux:table.column>
                        <flux:table.column align="end">{{ __('Number') }}</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <flux:table.row wire:key="with-contadt-details">
                            <flux:table.cell></flux:table.cell>
                            <flux:table.cell>
                                {{ __('With contact details') }}
                            </flux:table.cell>
                            <flux:table.cell align="end">
                                {{ $this->contacts }}
                            </flux:table.cell>
                        </flux:table.row>
                        @foreach ($this->decisions() as $decision)
                            <flux:table.row wire:key="decision-{{ $decision->id }}">
                                <flux:table.cell>{{ $this->date($decision->created_at) }}</flux:table.cell>
                                <flux:table.cell>
                                    {{ $decision->evangelist_name }}
                                </flux:table.cell>
                                <flux:table.cell align="end">
                                    {{ $decision->number_of_decisions }}
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>

            </flux:card>
        </div>
    </livewire:event-nav>
</div>
