<div class="space-y-6">

    <div class="space-y-4">

        <x-partials.header heading="{{ $event->name . ' - ' . $event->city }}" />

        @can('view', $this->ministry)
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ $event->name }} - {{ $event->city }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:separator />
        @endcan

    </div>

    <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
        <div class="space-y-6">
            <div>
                <div class="grid md:grid-cols-2 gap-6">
                    <flux:card class="space-y-4 grid">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <flux:heading size="lg">{{ __('Contacts') }}</flux:heading>
                                <flux:badge icon="user">{{ $event->contacts()->count() }}</flux:badge>
                            </div>

                            <flux:text>{{ __('View all contacts that have been added to this event.') }}</flux:text>
                        </div>
                        <flux:button class="justify-self-start self-end inline-block"
                            href="{{ route('contacts.index', [$this->ministry, $event]) }}" wire:navigate>
                            {{ __('To the contacts') }}
                        </flux:button>
                    </flux:card>
                    <flux:card class="space-y-4 grid">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <flux:heading size="lg">{{ __('Churches') }}</flux:heading>
                                <flux:badge icon="home">{{ $event->churches()->count() }}</flux:badge>
                            </div>
                            <flux:text>{{ __('Check out all the churches that are collaborating with this event.') }}
                            </flux:text>
                        </div>
                        <flux:button class="justify-self-start self-end inline-block"
                            href="{{ route('churches.index', [$this->ministry, $event]) }}" wire:navigate>
                            {{ __('To the churches') }}
                        </flux:button>
                    </flux:card>
                </div>
            </div>
            <livewire:assign :ministry="$this->ministry" :event="$this->event" />

        </div>
    </livewire:event-nav>
    <flux:toast />

</div>
