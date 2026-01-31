<div class="space-y-8">

    <flux:heading>{{ __('Would you like to evangelize and add contacts to this event?') }}
    </flux:heading>
    <div class="space-y-2">
        <flux:text variant="strong">{{ __('Copy this link and send it to your evangelists') }}
        </flux:text>
        <flux:input readonly copyable value="{{ $this->addContact() }}"></flux:input>
    </div>
    <div class="space-y-2">
        <flux:text variant="strong">{{ __('Or open the form directly by clicking on this button.') }}
        </flux:text>
        <flux:button target="_blank" href="{{ $this->addContact() }}">{{ __('Add contacts') }}
        </flux:button>
    </div>

    <flux:separator />

    <flux:field variant="inline">
        <flux:label>{{ __('Allow churches to add contacts themselves') }}</flux:label>
        <flux:description>
            {{ __('Each church gets its own link, which can be used to add contacts directly to its church.') }}
        </flux:description>
        <flux:switch wire:model.live="church_evangelize" />
        <flux:error name="church_evangelize" />
    </flux:field>
    <flux:field variant="inline">

        <flux:label>{{ __('Add contacts directly to the church') }}</flux:label>
        <flux:description>
            {{ __('By default, contacts must still be confirmed before they are synchronized with the church.') }}
        </flux:description>
        <flux:switch wire:model.live="assign_directly" />
        <flux:error name="assign_directly" />
    </flux:field>
</div>
