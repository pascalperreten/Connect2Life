<div class="flex gap-4" wire:ignore>
    @can('view', $this->ministry)
        {{-- <a href="{{ route('dashboard', $this->ministry) }}"
            class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
            <x-app-logo />
        </a> --}}
        <flux:navbar class="-mb-px">
            <flux:navbar.item :href="route('dashboard', $this->ministry)" :current="request()->routeIs('ministry')"
                wire:navigate>
                {{ $this->ministry->name }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('events.index', $this->ministry)"
                :current="request()->routeIs('events.index', $this->ministry)" wire:navigate>
                {{ __('Events') }}
            </flux:navbar.item>
            {{-- <livewire:navigation.events :ministry="$this->ministry" /> --}}
        </flux:navbar>
    @endcan
</div>
