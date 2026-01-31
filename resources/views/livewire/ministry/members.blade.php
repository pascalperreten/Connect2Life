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
        <x-partials.header heading="Mitglieder" />
        @can('update', $this->ministry)
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ __('Members') }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:separator />
        @endcan
    </div>
    <livewire:ministry-nav :ministry="$this->ministry">
        <div class="sm:p-6 sm:rounded-xl sm:border">
            <flux:tab.group>
                <flux:tabs>
                    <flux:tab name="members">{{ __('Members') }}</flux:tab>
                    <flux:tab name="add-members">{{ __('Add Members') }}</flux:tab>
                </flux:tabs>

                <flux:tab.panel name="members">
                    <livewire:members.index wire:key="{{ count($this->members) }}" :members="$this->members"
                        :ministry="$this->ministry" />
                </flux:tab.panel>
                <flux:tab.panel name="add-members">
                    <livewire:members.create :ministry="$this->ministry" title="{{ __('Add Member') }}" />
                </flux:tab.panel>
            </flux:tab.group>

        </div>
    </livewire:ministry-nav>
    <flux:toast />
</div>
