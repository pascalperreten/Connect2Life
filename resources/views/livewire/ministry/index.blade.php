<div class="space-y-4">
    <div class="space-y-4">
        @if ($this->ministry->logo_path)
            <div class="flex justify-center">
                <div class="w-50">
                    <img class="max-h-full max-w-full" src="{{ asset('storage/' . $this->ministry->logo_path) }}">
                </div>
            </div>
        @else
            <flux:heading size="xl">{{ $this->ministry->name }}</flux:heading>
        @endif
        <x-partials.header heading="Dashboard" />
    </div>
    <livewire:ministry-nav :ministry="$this->ministry">
        <div>
            @if (count($this->ministry->events) >= 1)
                <div class="sm:p-6 sm:rounded-xl sm:border space-y-6">
                    <flux:heading size="lg">{{ __('Overview') }} {{ $ministry->name }}</flux:heading>
                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Decisions for Christ') }}</flux:heading>
                        <flux:badge color="orange" size="lg">{{ $this->ministry->events->sum('decisions') }}
                        </flux:badge>
                    </div>
                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Contacts') }}</flux:heading>
                        <flux:badge color="green" size="lg">{{ count($this->ministry->contacts) }}</flux:badge>
                    </div>
                    <flux:separator />
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($this->ministry->events as $event)
                            <div wire:key="{{ $event->id }}">
                                <flux:card wire:click="showEvent({{ $event }})" class="space-y-4 cursor-pointer">

                                    <div class="flex justify-between items-center">
                                        <flux:heading>{{ $event->name }} {{ $event->city }}</flux:heading>
                                    </div>
                                    <flux:separator />
                                    <div class="flex justify-between items-center">
                                        <flux:text>{{ __('Decisions') }}</flux:text>
                                        <flux:badge color="orange">{{ $event->decisions }}</flux:badge>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <flux:text>{{ __('Contacts') }}</flux:text>
                                        <flux:badge color="green">{{ count($event->contacts) }}</flux:badge>
                                    </div>
                                    @if ($this->newContacts($event))
                                        <flux:text class="text-red-400 text-center rounded-sm font-bold p-2 text-sm">
                                            {{ __('You have new Contacts!') }}</flux:text>
                                    @endif

                                </flux:card>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                @can('create', App\Models\User::class)
                    <flux:card class="space-y-6 text">
                        <flux:heading class="text-center" size="lg">Du hast noch keine Events!</flux:heading>
                        <flux:text class="text-center">Erstelle jetzt deinen ersten Event und fange an Kontakte zu sammeln
                        </flux:text>
                        <div class="flex justify-center">
                            <flux:button wire:navigate href="{{ route('events.index', [$this->ministry, 'create' => 1]) }}"
                                wire:navigate>
                                Event
                                erstellen
                            </flux:button>
                        </div>
                    </flux:card>
                @endcan

            @endif
        </div>
    </livewire:ministry-nav>
</div>

</div>
