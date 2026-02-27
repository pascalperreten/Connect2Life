<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\GospelShare;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public Ministry $ministry;

    public function mount(Ministry $ministry)
    {
        $this->ministry = $ministry;
    }
};
?>

<div class="space-y-6">
    <div class="space-y-4">

        <x-partials.header heading="{{ __('Statistics') }}" />
        @can('update', $this->ministry)
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $this->ministry->name }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:separator />
        @endcan

    </div>
    <livewire:ministry-nav :ministry="$this->ministry">
        <flux:card>
            <livewire:gospel-shares-table :model="$this->ministry" />

        </flux:card>
    </livewire:ministry-nav>
</div>
