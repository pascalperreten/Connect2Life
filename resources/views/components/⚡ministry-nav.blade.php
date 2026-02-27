<?php

use Livewire\Component;

new class extends Component {
    public $ministry;

    public $open = false;

    public function toggleOpen()
    {
        $this->open = !$this->open;
    }
};
?>

<div>
    <div class="flex">
        @can('update', $this->ministry)
            <div x-data="{ open: false }" class="sticky hidden sm:block top-5 h-full border rounded p-2 mr-4">
                <span class="text-center">
                    <flux:button x-on:click="open = true" class="p-4 cursor-pointer w-full" x-show="!open" size="xs"
                        variant="ghost" tooltip="{{ __('Open Sidebar') }}" icon="chevron-double-right"
                        icon:variant="outline" />
                    <flux:button x-on:click="open = false" class="p-4 cursor-pointer w-full" x-show="open" size="xs"
                        variant="ghost" tooltip="{{ __('Close Sidebar') }}" icon="chevron-double-left"
                        icon:variant="outline" />
                </span>

                <flux:navlist>

                    <flux:navlist.item wire:navigate x-show="open" href="{{ route('ministry', $this->ministry) }}">
                        <i class="fa-regular fa-house mr-2"></i>
                        {{ $this->ministry->name }}
                    </flux:navlist.item>
                    <flux:navlist.item x-show="!open" wire:navigate href="{{ route('ministry', $this->ministry) }}">
                        <i class="text-lg fa-regular fa-house"></i>
                    </flux:navlist.item>

                    <flux:navlist.item wire:navigate x-show="open" href="{{ route('events.index', $this->ministry) }}">
                        <i class="fa-regular fa-microphone-stand mr-2"></i>
                        Events
                    </flux:navlist.item>

                    <flux:navlist.item x-show="!open" wire:navigate href="{{ route('events.index', $this->ministry) }}">
                        <i class="text-lg fa-regular fa-microphone-stand"></i>
                    </flux:navlist.item>

                    <flux:navlist.item wire:navigate x-show="open" href="{{ route('ministry.members', $this->ministry) }}">
                        <i class="fa-regular fa-users mr-2"></i>
                        {{ __('Members') }}
                    </flux:navlist.item>
                    <flux:navlist.item x-show="!open" wire:navigate href="{{ route('ministry.members', $this->ministry) }}">
                        <i class="text-lg fa-regular fa-users"></i>
                    </flux:navlist.item>

                    <flux:navlist.item wire:navigate x-show="open" href="{{ route('ministry.stats', $this->ministry) }}">
                        <i class="fa-regular fa-chart-line mr-2"></i>
                        {{ __('Statistics') }}
                    </flux:navlist.item>
                    <flux:navlist.item x-show="!open" wire:navigate href="{{ route('ministry.stats', $this->ministry) }}">
                        <i class="text-lg fa-regular fa-chart-line"></i>
                    </flux:navlist.item>

                    <flux:navlist.item wire:navigate x-show="open"
                        href="{{ route('ministry.details', $this->ministry) }}">
                        <i class="fa-regular fa-pen-to-square mr-2"></i>
                        {{ __('Edit') }}
                    </flux:navlist.item>
                    <flux:navlist.item x-show="!open" wire:navigate
                        href="{{ route('ministry.details', $this->ministry) }}">
                        <i class="text-lg fa-regular fa-pen-to-square"></i>
                    </flux:navlist.item>
                </flux:navlist>
            </div>
            <div
                class="fixed sm:hidden flex justify-center bottom-0 left-0 right-0 bg-white dark:bg-zinc-900 w-full z-20 border-t-2 border-cyan-700 p-2">

                <flux:navbar>
                    <flux:navbar.item wire:navigate href="{{ route('ministry', $this->ministry) }}"><i
                            class="text-2xl fa-regular fa-house"></i>
                    </flux:navbar.item>

                    <flux:navbar.item wire:navigate href="{{ route('events.index', $this->ministry) }}"><i
                            class="text-2xl fa-regular fa-microphone-stand"></i>
                    </flux:navbar.item>

                    <flux:navbar.item wire:navigate href="{{ route('ministry.members', $this->ministry) }}"><i
                            class="text-2xl fa-regular fa-users"></i>
                    </flux:navbar.item>

                    <flux:navbar.item wire:navigate href="{{ route('ministry.details', $this->ministry) }}"><i
                            class="text-2xl fa-regular fa-pen-to-square"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate href="{{ route('ministry.stats', $this->ministry) }}"><i
                            class="text-2xl fa-regular fa-chart-line"></i>
                    </flux:navbar.item>
                </flux:navbar>
            </div>
        @endcan

        <div class="max-w-full overflow-x-auto flex-1 mb-15">
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
