<div class="space-y-6">
    @if (!$contacts->isEmpty())
        @if (isset($currentContact))
            <div wire:show="showChurches"
                class="fixed overflow-auto top-0 left-0 w-full max-h-1/2 shadow bg-cyan-700 text-white border-b-2 border-orange-500 p-12 z-10">
                <flux:icon.x-mark wire:click="closeAndResetChurches"
                    class="position cursor-pointer absolute top-10 right-10" />

                <div class="space-y-4">
                    @if ($this->event->churches()->count() >= 1)
                        <flux:heading class="text-xl text-white">{{ __('Church suggestions for') }} <span
                                class="font-bold">{{ $currentContact->name }}</span></flux:heading>
                        <flux:text class="font-bold text-stone-200">{{ __('Same Postal Code') }}</flux:text>
                        <div class="flex gap-4">
                            @if (count($this->plzChurches) >= 1)
                                @foreach ($this->plzChurches as $church)
                                    <div class="flex items-center gap-2 border rounded-sm px-3 py-2">
                                        <flux:text class="inline text-stone-200">{{ $church->name }}</flux:text>
                                        <flux:badge icon="user" variant="solid" size="sm">
                                            {{ $this->getContactNumber($church->id) }}
                                        </flux:badge>
                                    </div>
                                @endforeach
                            @else
                                <flux:text class="text-stone-300">{{ __('No church with the same postal code') }}
                                </flux:text>
                            @endif

                        </div>
                        <div class="border-b border-stone-200"></div>
                        <flux:text class="font-bold text-stone-200">{{ __('Same district') }}</flux:text>
                        <div class="flex gap-4">
                            @if (count($this->districtChurches) >= 1)
                                @foreach ($this->districtChurches as $church)
                                    <div class="flex items-center gap-2 border rounded-sm px-3 py-2">
                                        <flux:text class="inline text-stone-200">{{ $church->name }}</flux:text>
                                        <flux:badge icon="user" variant="solid" size="sm">
                                            {{ $this->getContactNumber($church->id) }}
                                        </flux:badge>
                                    </div>
                                @endforeach
                            @else
                                <flux:text class="text-stone-300">{{ __('No church with the same district') }}
                                </flux:text>
                            @endif
                        </div>
                        <div class="border-b border-stone-200"></div>
                        <flux:text class="font-bold text-stone-200">{{ __('Same language') }}</flux:text>
                        <div class="flex gap-4">
                            @if (count($this->languageChurches) >= 1)
                                @foreach ($this->languageChurches as $church)
                                    <div class="flex items-center gap-2 border rounded-sm px-3 py-2">
                                        <flux:text class="inline text-stone-200">{{ $church->name }}</flux:text>
                                        <flux:badge icon="user" variant="solid" size="sm">
                                            {{ $this->getContactNumber($church->id) }}
                                        </flux:badge>
                                    </div>
                                @endforeach
                            @else
                                <flux:text class="text-stone-300">{{ __('No church with the same language') }}
                                </flux:text>
                            @endif
                        </div>
                    @else
                        <flux:heading class="text-xl text-white">{{ __('There are no Churches yet') }}</flux:heading>
                        <flux:button href="{{ route('churches.create', [$this->ministry, $this->event]) }}"
                            wire:navigate>{{ __('Add Church') }}</flux:button>
                    @endif
                </div>
            </div>
        @endif

        <flux:heading size="lg" class="text-orange-500 border border-orange-500 px-2 py-4 rounded text-center">
            {{ __('You have new Contacts!') }}
        </flux:heading>
        <flux:card>
            <form wire:submit="updateChurch">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                        <flux:table.column>{{ __('Postal Code') }}</flux:table.column>
                        <flux:table.column>{{ __('District') }}</flux:table.column>
                        <flux:table.column>{{ __('Age') }}</flux:table.column>
                        <flux:table.column>{{ __('Gender') }}</flux:table.column>
                        <flux:table.column>{{ __('Language') }}</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>

                        @foreach ($contacts as $contact)
                            <flux:table.row
                                class="{{ isset($currentContact) && $currentContact->id === $contact->id ? 'bg-orange-700/10' : '' }}"
                                wire:key="{ contact.id }">

                                <flux:table.cell wire:key="{ contact.id }">
                                    {{ $contact->name }}</flux:table.cell>
                                <flux:table.cell><a class="underline" target="_blank"
                                        href="{{ $this->postalCodeUrl($contact) }}">{{ $contact->postalCode->first()->name ?? 'keine' }}</a>
                                </flux:table.cell>
                                <flux:table.cell><a target="_blank" class="underline"
                                        href="{{ $this->districtUrl($contact) }}">{{ $contact->district->first()->name ?? 'keine' }}</a>
                                </flux:table.cell>
                                <flux:table.cell>{{ $contact->age ?? 'keine' }}</flux:table.cell>
                                <flux:table.cell>
                                    @if ($contact->gender === 'male')
                                        {{ __('Man') }}
                                    @else
                                        {{ __('Woman') }}
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @foreach ($contact->languages as $key => $language)
                                        @if (count($contact->languages) === 1)
                                            {{ $language->translation->name }}
                                        @elseif ($key === count($contact->languages) - 1)
                                            {{ $language->translation->name }}
                                        @else
                                            {{ $language->translation->name }},
                                        @endif
                                    @endforeach
                                </flux:table.cell>

                                <flux:table.cell class="text-end flex gap-2">
                                    <flux:button wire:click="checkChurches({{ $contact->id }})">
                                        {{ __('Churches') }}
                                    </flux:button>
                                    <flux:select wire:model="contact_church.{{ $contact->id }}" variant="listbox"
                                        placeholder="Wähle eine Kirche aus">

                                        @if (count($this->event->churches) >= 1)
                                            @foreach ($this->event->churches as $church)
                                                <div class="flex gap-2 py-2">
                                                    <flux:select.option wire:key="{{ $church->id }}"
                                                        value="{{ $church->id }}">
                                                        {{ $church->name }}
                                                    </flux:select.option>
                                                    <flux:badge icon="user">
                                                        {{ $this->getContactNumber($church->id) }}
                                                    </flux:badge>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-start p-2 space-y-2">
                                                <flux:text class="text-red-400 text-xs font-bold">
                                                    {{ __('No church yet!') }}</flux:text>
                                                <flux:link
                                                    href="{{ route('churches.create', [$this->ministry, $this->event]) }}"
                                                    wire:navigate>
                                                    {{ __('Add Church') }}</flux:link>
                                            </div>
                                        @endif


                                    </flux:select>

                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
                <div class="flex">
                    <flux:spacer />
                    <flux:button class="mt-6" type="submit">Speichern</flux:button>
                </div>
            </form>
        </flux:card>
    @endif
    @if ($this->newForeignContacts)

        <flux:heading size="lg" class=" border px-2 py-4 rounded text-center">
            {{ __('Contacts from another City!') }}
        </flux:heading>
        <flux:card>
            <div>
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                        <flux:table.column>{{ __('City') }}</flux:table.column>
                        <flux:table.column>{{ __('Age') }}</flux:table.column>
                        <flux:table.column>{{ __('Gender') }}</flux:table.column>
                        <flux:table.column>{{ __('Language') }}</flux:table.column>
                        <flux:table.column>{{ __('Contact') }}</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>

                        @foreach ($newForeignContacts as $contact)
                            <flux:table.row>

                                <flux:table.cell>
                                    {{ $contact->name }}</flux:table.cell>
                                <flux:table.cell>
                                    {{ $contact->city }}
                                </flux:table.cell>
                                <flux:table.cell>{{ $contact->age ?? 'keine' }}</flux:table.cell>
                                <flux:table.cell>
                                    @if ($contact->gender === 'male')
                                        {{ __('Man') }}
                                    @else
                                        {{ __('Woman') }}
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @foreach ($contact->languages as $key => $language)
                                        @if (count($contact->languages) === 1)
                                            {{ $language->translation->name }}
                                        @elseif ($key === count($contact->languages) - 1)
                                            {{ $language->translation->name }}
                                        @else
                                            {{ $language->translation->name }},
                                        @endif
                                    @endforeach
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div class="flex items-center gap-4">
                                        <livewire:contact-info :contact="$contact" />
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell class="justify-end flex gap-2">
                                    <flux:modal.trigger name="contact-submitted">
                                        <flux:button icon="cog-6-tooth" class="cursor-pointer" />
                                    </flux:modal.trigger>
                                    <flux:modal name="contact-submitted" class="max-w-sm">
                                        <div class="space-y-4">
                                            <flux:heading>Kontakt bearbeiten</flux:heading>
                                            <flux:text>Falls die Person doch aus {{ $this->event->city }} kommt, kannst
                                                du das hier bearbeiten
                                            </flux:text>
                                            <flux:button wire:navigate
                                                href="{{ route('contacts.edit', [$this->ministry, $this->event, $contact]) }}"
                                                icon="pencil-square" />
                                            <flux:text>Konntest du den Kontakt übermitteln?</flux:text>
                                            <flux:text>Wenn du bestätigst, ist der Kontakt hier nicht mehr sichtbar!
                                            </flux:text>
                                            <div class="flex justify-end">
                                                <flux:button variant="primary" class="cursor-pointer">Übermittlung
                                                    abschliessen</flux:button>
                                            </div>
                                        </div>


                                    </flux:modal>

                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
                <div>
        </flux:card>
    @endif
</div>
