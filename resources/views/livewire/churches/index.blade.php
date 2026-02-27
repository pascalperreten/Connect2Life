<div class="space-y-6">
    <div class="space-y-4">

        <x-partials.header heading="{{ __('Churches') }}" />
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
        <flux:card>
            <flux:tab.group>
                <flux:tabs scrollable scrollable:scrollbar="hide" wire:model="activeTab">
                    <flux:tab name="churches">{{ __('Churches') }}</flux:tab>
                    @can('update', $this->event)
                        <flux:tab name="add_church">{{ __('Add Churches') }}</flux:tab>
                    @endcan
                </flux:tabs>
                <flux:tab.panel name="churches">
                    @if ($this->event->churches->isEmpty())
                        <flux:text class="mt-6">{{ __('No churches have been added to your event yet.') }}
                        </flux:text>
                    @else
                        <livewire:church-table :ministry="$this->ministry" :event="$this->event" />
                    @endif
                </flux:tab.panel>
                @can('update', $this->event)
                    <flux:tab.panel name="add_church">
                        <livewire:churches.create :ministry="$this->ministry" :event="$this->event" />
                    </flux:tab.panel>
                @endcan
            </flux:tab.group>

        </flux:card>
    </livewire:event-nav>

    <flux:toast />
</div>
