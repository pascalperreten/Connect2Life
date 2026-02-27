<div class="space-y-6">
    <div class="space-y-4">
        <x-partials.header heading="Events" />
        @can('update', $this->ministry)
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $ministry->name }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:separator />
        @endcan

    </div>

    <livewire:ministry-nav :ministry="$this->ministry">
        <div class="sm:p-6 sm:rounded-xl sm:border space-y-6">
            <flux:tab.group>
                <flux:tabs wire:model="activeTab">
                    <flux:tab name="events">Events</flux:tab>
                    <flux:tab name="create-event">{{ __('Add Event') }}</flux:tab>
                </flux:tabs>

                <flux:tab.panel name="events">
                    @if ($this->events->isEmpty())
                        <div class="">
                            <flux:text>{{ __('No events found') }}</flux:text>

                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($this->events as $event)
                                <div wire:key="{{ $event->id }}" class="flex justify-between gap-2 items-center">
                                    <flux:button wire:navigate
                                        href="{{ route('events.show', [$this->ministry, $event]) }}">
                                        {{ $event->name }} | {{ $event->city }}
                                    </flux:button>
                                    <div>
                                        <flux:modal.trigger name="edit-{{ $event->id }}">
                                            <flux:icon.pencil-square class="cursor-pointer" />
                                        </flux:modal.trigger>

                                        <flux:modal name="edit-{{ $event->id }}" class="md:w-96">
                                            <livewire:events.edit :ministry="$this->ministry" :event="$event" />
                                        </flux:modal>
                                    </div>
                                </div>
                                <flux:separator />
                            @endforeach

                        </div>
                    @endif
                </flux:tab.panel>
                <flux:tab.panel name="create-event">
                    <livewire:events.create :ministry="$this->ministry" />
                </flux:tab.panel>
            </flux:tab.group>
        </div>
    </livewire:ministry-nav>
    <flux:toast />

</div>
