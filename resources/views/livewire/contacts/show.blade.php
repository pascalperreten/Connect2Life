<div>
    <flux:heading class="" size="xl">{{ $contact->name }}</flux:heading>
    <div class="border-b border-zinc-200 pb-4">
        <flux:heading class="flex items-center justify-between">
            <div>

            </div>
            <flux:button wire:navigate variant="primary"
                href="{{ route('contacts.edit', [$this->ministry, $this->event, $contact]) }}" wire:navigate>
                Edit
                Contact</flux:button>
        </flux:heading>
    </div>
    <flux:heading>{{ $contact->name }}</flux:heading>
    <flux:text>{{ $contact->age }}</flux:text>
</div>
