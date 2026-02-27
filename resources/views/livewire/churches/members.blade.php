<div>
    <div class="space-y-4">

        <x-partials.header heading="{{ __('Members') }}" />

        @can('view', $this->event)
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item
                        href="{{ route('events.show', [$this->ministry, $this->event->city_slug, $this->event]) }}"
                        wire:navigate>
                        {{ $this->event->name }} - {{ $this->event->city }}
                    </flux:breadcrumbs.item>

                    <flux:breadcrumbs.item
                        href="{{ route('churches.show', [$this->ministry, $this->event, $this->church]) }}" wire:navigate>
                        {{ $this->church->name }}
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:separator />
        @endcan
    </div>
    <div class="mt-6">
        <livewire:church-nav :ministry="$this->ministry" :event="$this->event" :church="$this->church">
            <flux:card>
                <flux:tab.group>
                    <flux:tabs>
                        <flux:tab name="members">{{ __('Members') }}</flux:tab>
                        <flux:tab name="add-members">{{ __('Add Members') }}</flux:tab>
                    </flux:tabs>

                    <flux:tab.panel name="members">
                        <livewire:members.index wire:key="{{ count($this->church->members) }}" :members="$this->church->members"
                            :ministry="$this->ministry" :church="$this->church" />
                    </flux:tab.panel>
                    <flux:tab.panel name="add-members">
                        <livewire:members.create :ministry="$this->ministry" :event="$this->event" :church="$this->church"
                            title="{{ __('Add Member') }}" />
                    </flux:tab.panel>
                </flux:tab.group>
            </flux:card>
        </livewire:church-nav>
    </div>
    <flux:toast />
</div>
