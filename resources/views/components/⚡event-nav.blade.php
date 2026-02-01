<?php

use Livewire\Component;

new class extends Component {
    public $ministry;
    public $event;

    public $open = false;

    public function toggleOpen()
    {
        $this->open = !$this->open;
    }
};
?>

<div>
    <div class="flex">
        @can('update', $this->event)
            <div x-data="{ open: false }" class="sticky hidden sm:block top-5 h-full border rounded p-2 mr-6">
                <span class="text-center">
                    <flux:button x-on:click="open = true" class="p-4 cursor-pointer w-full" x-show="!open" size="xs"
                        variant="ghost" tooltip="{{ __('Open Sidebar') }}" icon="chevron-double-right"
                        icon:variant="outline" />
                    <flux:button x-on:click="open = false" class="p-4 cursor-pointer w-full" x-show="open" size="xs"
                        variant="ghost" tooltip="{{ __('Close Sidebar') }}" icon="chevron-double-left"
                        icon:variant="outline" />
                </span>

                <flux:navlist>

                    <div x-show="open">
                        <flux:navlist.item wire:navigate href="{{ route('events.index', $this->ministry) }}">
                            <i class="fa-regular fa-arrow-left mr-2"></i>
                            Events
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate href="{{ route('events.show', [$this->ministry, $this->event]) }}">
                            <i class="fa-solid fa-microphone-stand mr-2"></i>
                            {{ $event->name }} | {{ $event->city }}
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                            <i class="fa-regular fa-cross mr-2"></i>
                            {{ __('Churches') }}
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate
                            href="{{ route('contacts.index', [$this->ministry, $this->event]) }}">
                            <i class="fa-regular fa-user mr-2"></i>
                            {{ __('Contacts') }}
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate
                            href="{{ route('events.manage', [$this->ministry, $this->event]) }}">
                            <i class="fa-regular fa-gear mr-2"></i>
                            {{ __('Manage') }}
                        </flux:navlist.item>
                    </div>

                    <div x-show="!open">

                        <flux:navlist.item wire:navigate href="{{ route('events.index', $this->ministry) }}">
                            <i class="text-lg fa-regular fa-arrow-left"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('events.show', [$this->ministry, $this->event]) }}">
                            <i class="text-lg fa-solid fa-microphone-stand"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                            <i class="text-lg fa-regular fa-cross"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('contacts.index', [$this->ministry, $this->event]) }}">
                            <i class="text-lg fa-regular fa-user"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('events.manage', [$this->ministry, $this->event]) }}">
                            <i class="text-lg fa-regular fa-gear"></i>
                        </flux:navlist.item>
                    </div>
                </flux:navlist>
            </div>
            <div
                class="fixed max-w-full overflow-x-auto sm:hidden flex justify-center bottom-0 left-0 right-0 bg-white dark:bg-zinc-900 w-full z-20 border-t-2 border-cyan-700 p-2">

                <flux:navbar>
                    {{-- <flux:navbar.item wire:navigate href="{{ route('ministry', $this->ministry) }}">
                        <i class="text-2xl fa-regular fa-house"></i>
                    </flux:navbar.item> --}}
                    <flux:navbar.item wire:navigate href="{{ route('events.index', $this->ministry) }}">
                        <i class="text-2xl fa-regular fa-arrow-left"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate href="{{ route('events.show', [$this->ministry, $this->event]) }}">
                        <i class="text-2xl fa-solid fa-microphone-stand"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                        <i class="text-2xl fa-regular fa-cross"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate href="{{ route('contacts.index', [$this->ministry, $this->event]) }}">
                        <i class="text-2xl fa-regular fa-user"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate href="{{ route('events.manage', [$this->ministry, $this->event]) }}">
                        <i class="text-2xl fa-regular fa-gear"></i>
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
