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

    <div class="flex gap-2">
        <flux:spacer />
        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>

        @can('delete', $event)
            <flux:modal.trigger name="delete-{{ $event->id }}">
                <flux:button variant="danger">{{ __('Delete Event') }}</flux:button>
            </flux:modal.trigger>
            <flux:modal name="delete-{{ $event->id }}" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Delete Event') }}</flux:heading>
                        <flux:text class="mt-2">
                            {{ __('You are about to delete this event along with all associated information.') }}<br>
                            {{ __('This action cannot be undone.') }}
                        </flux:text>
                    </div>
                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:modal.close>
                            <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                        </flux:modal.close>
                        <flux:button type="button" wire:click="delete" variant="danger">{{ __('Delete Event') }}
                        </flux:button>
                    </div>
                </div>
            </flux:modal>
        @endcan
    </div>


</form>
