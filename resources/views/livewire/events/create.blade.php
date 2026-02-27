<div>
    <form wire:submit="create" class="space-y-6">
        <flux:field>
            <flux:label>Name</flux:label>

            <flux:input wire:model="form.name" type="text" />

            <flux:error name="form.name" />
        </flux:field>
        <flux:field>
            <flux:label>{{ __('City') }}</flux:label>

            <flux:input wire:model="form.city" type="text" />

            <flux:error name="form.city" />
        </flux:field>


        <flux:error name="form.slug" />

        <flux:button type="submit">{{ __('Create Event') }}</flux:button>
    </form>
</div>
