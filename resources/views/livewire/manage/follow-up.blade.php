<div class="space-y-3">
    <flux:heading>{{ __('Please select which form inputs you would like to include in your contact form') }}
    </flux:heading>
    <flux:separator class="my-4" />
    <flux:switch wire:model.change="language" label="{{ __('Language') }}"
        description={{ __('A field for selecting the languages you specified will be added to your form.') }} />
    <flux:separator variant="subtle" class="my-4" />
    <flux:switch wire:model.change="age" label="{{ __('Age') }}"
        description="{{ __('A field for selecting the approximate age will be added to your form.') }}" />
    <flux:separator variant="subtle" class="my-4" />

    <flux:switch wire:model.change="gender" label="{{ __('Gender') }}"
        description="{{ __('A field for selecting between male and female will be added to your form.') }}" />
    <flux:separator variant="subtle" class="my-4" />
    <flux:switch wire:model.change="district" label="{{ __('District') }}"
        description="{{ __('A field for selecting districts you specified will be added to your form.') }}" />
    <flux:separator variant="subtle" class="my-4" />

    <flux:switch wire:model.change="postal_code" label="{{ __('Postal Code') }}"
        description="{{ __('A field for entering the postal code will be added to your form.') }}" />
    <flux:separator variant="subtle" class="my-4" />
    <flux:switch wire:model.change="evangelist_name" label="{{ __('Name Evanglist') }}"
        description="{{ __('A field for entering the name of the evangelist will be added to your form.') }}" />

</div>
