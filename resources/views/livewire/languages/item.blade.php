<div class="flex gap-4 items-center justify-between">
    <flux:input wire:keydown.enter="updateLanguage({{ $language->id }})" wire:model="form.name"
        :disabled="!array_key_exists('language', $this->form->edit) || $this->form->edit['language'] !== $language->id">

        <x-slot name="iconTrailing">
            @if (!array_key_exists('language', $this->form->edit) || $this->form->edit['language'] !== $language->id)
                <flux:tooltip content="Bearbeiten">
                    <flux:button wire:click="editItem({{ $language->id }})" size="sm" variant="subtle"
                        icon="pencil-square" class="-mr-1" />
                </flux:tooltip>
            @else
                <flux:button wire:click="updateLanguage({{ $language->id }})" size="sm" variant="subtle"
                    icon="check" class="-mr-1" variant="primary" color="green" />
            @endif
        </x-slot>
    </flux:input>
    <flux:modal.trigger :name="'delete-language-' . $language->id">
        <flux:tooltip content="Löschen">
            <flux:button icon="x-mark" variant="primary" color="red" class="cursor-pointer" />
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal :name="'delete-language-' . $language->id" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete language?</flux:heading>
                <flux:text class="mt-2">
                    You're about to delete this language.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteLanguage({{ $language->id }})" variant="danger">
                    Delete language</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
