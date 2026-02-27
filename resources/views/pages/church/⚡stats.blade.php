<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Contact;
use App\Models\Church;

new class extends Component {
    public Ministry $ministry;
    public Event $event;
    public Church $church;
    public $contacts;
    public $contacted;
    public $met;
    public $part_of_church;
    public $not_interested;
    public $invalid_contact_details;
    public array $data = [];
    public $contactsEvangelized;

    public function mount(Ministry $ministry, Event $event, Church $church)
    {
        $this->ministry = $ministry;
        $this->event = $event;
        $this->church = $church;
        $this->contacts = $this->church->contacts->count();
        $this->contacted = $this->church->contacts->whereNotNull('contacted_date')->where('invalid_contact_details', false)->count();
        $this->met = $this->church->contacts->where('met', true)->where('invalid_contact_details', false)->count();
        $this->part_of_church = $this->church->contacts->where('part_of_church', true)->where('invalid_contact_details', false)->count();
        $this->not_interested = $this->church->contacts->where('not_interested', true)->where('invalid_contact_details', false)->count();
        $this->invalid_contact_details = $this->church->contacts->where('invalid_contact_details', true)->count();

        $this->data = [['name' => __('Total'), 'value' => $this->contacts], ['name' => __('Contacted'), 'value' => $this->contacted], ['name' => __('Met'), 'value' => $this->met], ['name' => __('Part of Church'), 'value' => $this->part_of_church], ['name' => __('Not Interested'), 'value' => $this->not_interested], ['name' => __('Invalid Details'), 'value' => $this->invalid_contact_details]];
        $this->contactsEvangelized = $this->church->contactsEvangelized()->where('event_id', $this->event->id)->count();
    }
};
?>

<div class="space-y-6">
    <div class="space-y-4">
        <x-partials.header heading="{{ __('Statistics') }}" />

        @can('view', $this->event)
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}">
                        {{ $event->name }} - {{ $event->city }}</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item
                        href="{{ route('churches.show', [$this->ministry, $this->event, $this->church]) }}">
                        {{ $this->church->name }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:separator />
        @endcan
    </div>
    <livewire:church-nav :ministry="$this->ministry" :event="$this->event" :church="$this->church">
        <div class="space-y-6">
            @if ($this->contactsEvangelized > 0)
                <flux:card>
                    <div class="flex gap-4 items-center">
                        <flux:heading size="lg">{{ __('Contacts evangelized') }}</flux:heading>
                        <flux:badge color="orange" size="lg">{{ $this->contactsEvangelized }}</flux:badge>
                    </div>
                </flux:card>
            @endif
            <flux:card>
                <div class="flex gap-4 items-center">
                    <flux:heading size="lg">{{ __('Contacts') }}</flux:heading>
                    <flux:badge color="orange" size="lg">{{ $this->contacts }}</flux:badge>
                </div>
                <flux:chart wire:model="data" class="h-80 mt-6">
                    <flux:chart.svg>
                        <flux:chart.bar field="value" class="text-blue-300 dark:text-blue-700" width="60%" />

                        <flux:chart.axis axis="x" field="name">
                            <flux:chart.axis.tick />
                        </flux:chart.axis>

                        <flux:chart.axis axis="y">
                            <flux:chart.axis.grid />
                            <flux:chart.axis.tick />
                        </flux:chart.axis>
                    </flux:chart.svg>

                    <flux:chart.tooltip>
                        <flux:chart.tooltip.value field="value" label="{{ __('Number') }}" />
                    </flux:chart.tooltip>
                </flux:chart>
            </flux:card>
        </div>
    </livewire:church-nav>

</div>
