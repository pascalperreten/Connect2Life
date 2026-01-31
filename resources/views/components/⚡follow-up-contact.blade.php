<?php

use Livewire\Component;

new class extends Component {
    public $church;
    public $align = '';
};
?>

<flux:dropdown align="{{ $align }}">
    <flux:button icon:trailing="user"></flux:button>
    <flux:menu keep-open>
        <flux:heading class="p-2">{{ $church->followUpContact->first_name }} {{ $church->followUpContact->last_name }}
        </flux:heading>
        @if ($church->followUpContact->phone)
            <flux:menu.item x-data="{ copied: false }" class="flex justify-between gap-4 mt-3 mb-4">
                <flux:text>{{ $church->followUpContact->phone }}
                </flux:text>
                <span class="flex gap-4">
                    <flux:link href="tel:{{ $church->followUpContact->phone }}">
                        <flux:icon.phone />
                    </flux:link>
                    <flux:separator vertical />
                    <flux:icon.clipboard class="cursor-pointer justify-self-end" x-show="!copied"
                        x-on:click="$clipboard('{{ $church->followUpContact->phone }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                    <flux:icon.clipboard-document-check x-show="copied" />
                </span>

            </flux:menu.item>
        @endif
        <flux:separator />
        <flux:menu.item x-data="{ copied: false }" class="flex gap-4 mt-4 mb-3">
            <flux:text>{{ $church->followUpContact->email }}
            </flux:text>
            <span class="flex gap-4">
                <flux:link href="mailto:{{ $church->followUpContact->email }}">
                    <flux:icon.envelope />
                </flux:link>
                <flux:separator vertical />
                <flux:icon.clipboard class="cursor-pointer self-end" x-show="!copied"
                    x-on:click="$clipboard('{{ $church->followUpContact->email }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                <flux:icon.clipboard-document-check x-show="copied" />
            </span>
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>
