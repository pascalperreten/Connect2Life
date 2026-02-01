<?php

use Livewire\Component;

new class extends Component {
    public $ministry;
    public $event;
    public $church;

    public $open = false;

    public function toggleOpen()
    {
        $this->open = !$this->open;
    }
};
?>

<div>
    <div class="flex">
        @can('update', $church)
            <div x-data="{ open: false }" class="sticky hidden sm:block top-5 h-full border rounded p-2 mr-6">

                <flux:navlist>
                    <span class="text-center">
                        <flux:button x-on:click="open = true" class="p-4 cursor-pointer" x-show="!open" size="xs"
                            variant="ghost" tooltip="{{ __('Open Sidebar') }}" icon="chevron-double-right"
                            icon:variant="outline" />
                        <flux:button x-on:click="open = false" class="p-4 cursor-pointer w-full" x-show="open"
                            size="xs" variant="ghost" tooltip="{{ __('Close Sidebar') }}" icon="chevron-double-left"
                            icon:variant="outline" />
                    </span>
                    <div x-show="open">
                        @can('view', $this->event)
                            <flux:navlist.item wire:navigate
                                href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                {{ __('Churches') }}
                            </flux:navlist.item>
                        @endcan

                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.show', [$this->ministry, $this->event, $this->church]) }}">
                            <i class="fa-solid fa-cross mr-2"></i>
                            {{ $church->name }}
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.members', [$this->ministry, $this->event, $church]) }}">
                            <i class="fa-regular fa-users mr-2"></i>
                            {{ __('Members') }}
                        </flux:navlist.item>

                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.manage', [$this->ministry, $this->event, $church]) }}">
                            <i class="fa-regular fa-gear mr-2"></i>
                            {{ __('Edit') }}
                        </flux:navlist.item>
                    </div>

                    <div x-show="!open">

                        @can('view', $this->event)
                            <flux:navlist.item wire:navigate
                                href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                                <i class="fa-solid fa-arrow-left text-lg"></i>
                            </flux:navlist.item>
                        @endcan
                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.show', [$this->ministry, $this->event, $church]) }}">
                            <i class="fa-solid fa-cross text-lg"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.members', [$this->ministry, $this->event, $church]) }}">
                            <i class="fa-regular fa-users text-lg"></i>
                        </flux:navlist.item>
                        <flux:navlist.item wire:navigate
                            href="{{ route('churches.manage', [$this->ministry, $this->event, $church]) }}">
                            <i class="fa-regular fa-gear text-lg"></i>
                        </flux:navlist.item>
                    </div>
                </flux:navlist>
            </div>
            <div
                class="fixed max-w-full overflow-x-auto sm:hidden flex justify-center bottom-0 left-0 right-0 bg-white dark:bg-zinc-900 w-full z-20 border-t-2 border-cyan-700 p-2">

                <flux:navbar>
                    @can('view', $this->event)
                        <flux:navbar.item wire:navigate href="{{ route('churches.index', [$this->ministry, $this->event]) }}">
                            <i class="text-2xl fa-solid fa-arrow-left"></i>
                        </flux:navbar.item>
                    @endcan
                    <flux:navbar.item wire:navigate
                        href="{{ route('churches.show', [$this->ministry, $this->event, $church]) }}">
                        <i class="text-2xl fa-solid fa-cross"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate
                        href="{{ route('churches.members', [$this->ministry, $this->event, $church]) }}">
                        <i class="text-2xl fa-regular fa-users"></i>
                    </flux:navbar.item>
                    <flux:navbar.item wire:navigate
                        href="{{ route('churches.manage', [$this->ministry, $this->event, $church]) }}">
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
