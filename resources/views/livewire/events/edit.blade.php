<form wire:submit="update" class="space-y-6">
    <flux:field>
        <flux:label>Name</flux:label>

        <flux:input wire:model="form.name" type="text" />

        <flux:error name="form.name" />
        <flux:error name="form.slug" />
    </flux:field>
    <flux:field>
        <flux:label>City</flux:label>

        <flux:input wire:model="form.city" type="text" />

        <flux:error name="form.city" />
    </flux:field>

    <flux:field>
        <flux:label>Date Range</flux:label>
        <flux:date-picker mode="range" wire:model="form.date_range" />
        <flux:error name="form.date_range" />
    </flux:field>

    <flux:button class="mr-4" variant="primary" type="submit">Speichern</flux:button>
    {{-- <flux:button wire:navigate href="{{ route('events.show', [$this->ministry, $this->event]) }}">Cancel</flux:button> --}}

    @can('delete', $event)
        <flux:modal.trigger name="delete-{{ $event->id }}">
            <flux:button variant="danger">Veranstaltung löschen</flux:button>
        </flux:modal.trigger>
        <flux:modal name="delete-{{ $event->id }}" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Veranstalung löschen?</flux:heading>
                    <flux:text class="mt-2">
                        Du bist dabei diese Veranstaltung mit allen dazugehörenden Informationen zu löschen.<br>
                        Dies kann nicht rückgängig gemacht werden.
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="button" wire:click="delete" variant="danger">Delete Event
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endcan


</form>
