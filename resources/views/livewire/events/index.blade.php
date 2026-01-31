<div>
    <div class="space-y-4">
        <flux:heading size="xl">Events</flux:heading>

        <x-partials.header heading="{{ $this->ministry->name }}" />
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $ministry->name }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Events</flux:breadcrumbs.item>
            </flux:breadcrumbs>

        </div>
        <flux:separator />
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
                                <flux:card wire:key="{{ $event->id }}" class="space-y-4">
                                    <div class="flex justify-between gap-2 items-center">
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
                                </flux:card>
                            @endforeach

                        </div>
                        {{-- <div>
                            <flux:table class="shadow-md" :paginate="$this->events">
                                <flux:table.columns>
                                    <flux:table.column>Name</flux:table.column>
                                    <flux:table.column>Stadt</flux:table.column>
                                    <flux:table.column>Datum</flux:table.column>
                                    <flux:table.column></flux:table.column>
                                </flux:table.columns>

                                <flux:table.rows>
                                    @foreach ($this->events as $event)
                                        <flux:table.row :key="$event->id">
                                            <flux:table.cell>
                                                <flux:button
                                                    href="{{ route('events.show', [$this->ministry, $event]) }}"
                                                    wire:navigate variant="ghost" icon:trailing="chevron-double-right">
                                                    {{ $event->name }}</flux:button>
                                            </flux:table.cell>
                                            <flux:table.cell>{{ $event->city }}</flux:table.cell>
                                            <flux:table.cell>
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                            </flux:table.cell>
                                            <flux:table.cell inset="top-bottom">
                                                <div class="flex gap-2 justify-end">
                                                    <flux:modal.trigger name="edit-{{ $event->id }}">
                                                        <flux:icon.pencil-square class="cursor-pointer" />
                                                    </flux:modal.trigger>

                                                    <flux:modal name="edit-{{ $event->id }}" class="md:w-96">
                                                        <livewire:events.edit :ministry="$this->ministry" :event="$event" />
                                                    </flux:modal>

                                                </div>
                                            </flux:table.cell>
                                        </flux:table.row>
                                    @endforeach
                                </flux:table.rows>
                            </flux:table>
                        </div> --}}
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
