<div class="space-y-6">
    <div class="space-y-4">
        <x-partials.header heading="{{ __('Contacts') }}" badgeText="{{ $event->contacts->count() }}" color="amber" />
        <div>
            <flux:breadcrumbs>
                @can('view', $this->ministry)
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                @endcan

                <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                    {{ $this->event->name }} - {{ $this->event->city }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:separator />
    </div>

    <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
        @if ($this->event->contacts->isEmpty())
            <flux:text>{{ __('No contacts have been added to this event yet.') }}</flux:text>
        @else
            <livewire:contacts-table variant="event" :event="$this->event" />
        @endif
    </livewire:event-nav>
</div>
