<div class="flex gap-4 items-center justify-between">
    <flux:input wire:keydown.enter="updateDistrict({{ $district->id }})" wire:model.blur="form.name"
        :disabled="!array_key_exists('district', $this->form->edit) || $this->form->edit['district'] !== $district->id">

        <x-slot name="iconTrailing">
            @if (!array_key_exists('district', $this->form->edit) || $this->form->edit['district'] !== $district->id)
                <flux:tooltip content="Bearbeiten">
                    <flux:button wire:click="editItem({{ $district->id }})" size="sm" variant="subtle"
                        icon="pencil-square" class="-mr-1" />
                </flux:tooltip>
            @else
                <flux:button wire:click="updateDistrict({{ $district->id }})" size="sm" variant="subtle"
                    icon="check" class="-mr-1" variant="primary" color="green" />
            @endif
        </x-slot>
    </flux:input>
    <flux:modal.trigger :name="'delete-district-' . $district->id">
        <flux:tooltip content="Löschen">
            <flux:button icon="x-mark" variant="primary" color="red" class="cursor-pointer" />
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal :name="'delete-district-' . $district->id" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete district?</flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this district.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteDistrict({{ $district->id }})" variant="danger">
                    Delete district</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
