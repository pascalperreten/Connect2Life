<?php

use Livewire\Component;
use App\Models\Contact;
use App\Models\Chruch;
use Livewire\Attributes\On;
use Carbon\Carbon;

new class extends Component {
    public $contacts;
    public $invalidContacts;

    public $showMore = [];

    public Contact $contact;
    public $church;

    //public int $contacts = 0;
    public int $contacts_not_interested = 0;
    public int $contacts_met;
    public int $contacts_contacted;
    public int $contacts_invalid;

    public function mount()
    {
        $this->setContacts();
    }

    #[On('updated')]
    public function setContacts()
    {
        $this->contacts = Contact::where('church_id', $this->church->id)->where('assigned', true)->latest()->get();
        $this->contacts_met = count($this->contacts->where('met', true)->where('invalid_contact_details', false));
        $this->contacts_contacted = count($this->contacts->whereNotNull('contacted_date')->where('invalid_contact_details', false));
        $this->contacts_invalid = count($this->contacts->where('invalid_contact_details', true));
        $this->contacts_not_interested = count($this->contacts->where('not_interested', true));
    }

    public function districtMapUrl($contact)
    {
        if ($contact->postalCode->first() && $contact->district()->first()) {
            $address = urlencode($contact->postalCode->first()->name . ', ' . $contact->city . ' ' . $contact->district->first()->name);
        } elseif ($contact->postalCode->first() && !$contact->district()->first()) {
            $address = $contact->postalCode->first()->name . ', ' . $contact->city;
        } elseif (!$contact->postalCode->first() && $contact->district()->first()) {
            $address = $contact->district->first()->name . ', ' . $contact->city;
        }

        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function cityUrl($contact)
    {
        $city = $contact->city;
        return "https://www.google.com/maps/search/?api=1&query={$city}";
    }
    public function plzUrl($contact)
    {
        $plz = $contact->postalCode->first()->name;
        $city = $contact->city;
        $query = urlencode($plz . ', ' . $city);
        return "https://www.google.com/maps/search/?api=1&query={$query}";
    }
    public function districtUrl($contact)
    {
        $district = $contact->district->first()->name;
        $city = $contact->city;
        $query = urlencode($district . ', ' . $city);
        return "https://www.google.com/maps/search/?api=1&query={$query}";
    }

    public function shortText($text, $id)
    {
        if (Str::length($text) > 30) {
            $this->showMore[] = $id;
            return Str::limit($text, 30);
        } else {
            return $text;
        }
    }

    public function setDate($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }
};
?>

<div>
    <div class="mt-6">
        <flux:card class="space-y-6">

            <div class="flex justify-between items-center">
                <flux:heading size="lg">New-Believers</flux:heading>
                <flux:badge color="orange">{{ count($this->contacts) }}</flux:badge>
            </div>
            <flux:separator />
            <div class="md:flex gap-8 md:space-y-0 space-y-4">
                <div class="space-y-4 flex-1">
                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Contacts contacted') }}</flux:heading>
                        <flux:badge color="green">{{ $this->contacts_contacted }}</flux:badge>
                    </div>

                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Contacts met') }}</flux:heading>
                        <flux:badge color="green">{{ $this->contacts_met }}</flux:badge>
                    </div>
                </div>
                <flux:separator class="hidden md:block" vertical />
                <div class="space-y-4 flex-1">
                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Contacts with incorrect contact details') }}</flux:heading>
                        <flux:badge color="red">{{ $this->contacts_invalid }}</flux:badge>
                    </div>
                    <div class="flex justify-between items-center">
                        <flux:heading>{{ __('Contacts are not interested') }}</flux:heading>
                        <flux:badge color="red">{{ $this->contacts_not_interested }}</flux:badge>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    {{-- Make table full width --}}
    {{-- <div class="xl:w-screen mt-8 xl:max-w-[calc(100vw-17px)] xl:px-10 left-1/2 relative -translate-x-1/2"> --}}
    <div class="mt-6 space-y-6">
        <div class="flex justify-between items-center">
            <flux:heading size="lg">{{ __('Contacts') }}</flux:heading>
        </div>
        @if ($this->contacts->isEmpty())
            <flux:text class="mt-4">{{ __('No contacts have been added to this church yet.') }}</flux:text>
        @else
            <flux:card>
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>{{ __('Date') }}</flux:table.column>
                        <flux:table.column>Name</flux:table.column>

                        <flux:table.column>{{ __('Info') }}</flux:table.column>
                        <flux:table.column>{{ __('Follow-Up Person') }}</flux:table.column>
                        <flux:table.column>{{ __('Contacted') }}</flux:table.column>
                        <flux:table.column>{{ __('Meeting') }}</flux:table.column>
                        <flux:table.column>{{ __('Church') }}</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->contacts as $contact)
                            <flux:table.row :key="$contact->id">
                                <flux:table.cell>{{ $this->setDate($contact->created_at) }}</flux:table.cell>
                                <flux:table.cell>{{ $contact->name }}</flux:table.cell>
                                <flux:table.cell>
                                    <flux:modal.trigger name="contact-{{ $contact->id }}-info">
                                        <flux:button icon="information-circle" />
                                    </flux:modal.trigger>

                                    <flux:modal name="contact-{{ $contact->id }}-info">
                                        <div class="space-y-2 max-w-md">
                                            <flux:heading size="xl">{{ $contact->name }}</flux:heading>
                                            <flux:separator />
                                            @if (!$contact->decision)
                                                <flux:text
                                                    class="text-red-400 text-center rounded-sm font-bold p-2 text-sm">
                                                    {{ __('This contact has not made a decision for Christ yet!') }}
                                                </flux:text>
                                            @endif
                                            <flux:heading size="lg">{{ __('Address') }}</flux:heading>
                                            <flux:text>
                                                {{ __('City') . ': ' }}
                                                <flux:link target="_blank" href="{{ $this->cityUrl($contact) }}">
                                                    {{ $contact->city }}
                                                </flux:link>
                                            </flux:text>
                                            @if ($contact->postalCode()->exists())
                                                <flux:text>

                                                    {{ __('Postal Code') . ': ' }}

                                                    <flux:link target="_blank" href="{{ $this->plzUrl($contact) }}">
                                                        {{ $contact->postalCode->first()->name }}
                                                    </flux:link>

                                                </flux:text>
                                            @endif
                                            @if ($contact->district()->exists())
                                                <flux:text>
                                                    {{ __('District') . ': ' }}

                                                    <flux:link target="_blank"
                                                        href="{{ $this->districtUrl($contact) }}">
                                                        {{ $contact->district->first()->name }}
                                                    </flux:link>

                                                </flux:text>
                                            @endif
                                            <flux:separator />
                                            <flux:heading size="lg">{{ __('Contact Information') }}</flux:heading>
                                            <div x-data="{ copied: false }" class="">
                                                <div class="space-y-2">
                                                    @if ($contact->way_to_get_in_contact === 'phone')
                                                        <flux:heading>{{ __('Phone') }}</flux:heading>
                                                    @elseif ($contact->way_to_get_in_contact === 'social_media')
                                                        <flux:heading>
                                                            {{ ucfirst($contact->social_media['platform']) }}
                                                        </flux:heading>
                                                    @elseif($contact->way_to_get_in_contact === 'email')
                                                        <flux:heading>{{ __('Email') }}</flux:heading>
                                                    @elseif ($contact->way_to_get_in_contact === 'other_contact')
                                                        <flux:heading>{{ __('Other') }}</flux:heading>
                                                    @endif
                                                    <flux:separator />
                                                    <div class="flex justify-between gap-2">
                                                        @if ($contact->way_to_get_in_contact === 'phone')
                                                            <flux:text>{{ $contact->phone }}
                                                            </flux:text>
                                                            <span class="flex gap-2">
                                                                <flux:link href="tel:{{ $contact->phone }}">
                                                                    <flux:icon.phone />
                                                                </flux:link>
                                                                <flux:separator vertical />
                                                                <flux:icon.clipboard
                                                                    class="cursor-pointer justify-self-end"
                                                                    x-show="!copied"
                                                                    x-on:click="$clipboard('{{ $contact->phone }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                                                <flux:icon.clipboard-document-check x-show="copied" />
                                                            </span>
                                                        @elseif ($contact->way_to_get_in_contact === 'social_media')
                                                            <flux:text>
                                                                {{ ucfirst($contact->social_media['user_name']) }}
                                                            </flux:text>
                                                            @if ($contact->social_media['url'])
                                                                <span class="flex gap-4">
                                                                    <flux:link target="_blank"
                                                                        href="{{ $contact->social_media['url'] }}">
                                                                        <flux:icon.globe-alt />
                                                                    </flux:link>
                                                                    <flux:separator vertical />
                                                                    <flux:icon.clipboard
                                                                        class="cursor-pointer justify-self-end"
                                                                        x-show="!copied"
                                                                        x-on:click="$clipboard('{{ $contact->social_media['url'] }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                                                    <flux:icon.clipboard-document-check
                                                                        x-show="copied" />
                                                                </span>
                                                            @endif
                                                        @elseif($contact->way_to_get_in_contact === 'email')
                                                            <flux:text>{{ $contact->email }}
                                                            </flux:text>
                                                            <span class="flex gap-4">
                                                                <flux:link href="mailto:{{ $contact->email }}">
                                                                    <flux:icon.envelope />
                                                                </flux:link>
                                                                <flux:separator vertical />
                                                                <flux:icon.clipboard
                                                                    class="cursor-pointer justify-self-end"
                                                                    x-show="!copied"
                                                                    x-on:click="$clipboard('{{ $contact->email }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                                                <flux:icon.clipboard-document-check x-show="copied" />
                                                            </span>
                                                        @elseif ($contact->way_to_get_in_contact === 'other_contact')
                                                            <flux:text>{{ $contact->other_contact }}
                                                            </flux:text>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            @if ($contact->evangelist_name)
                                                <flux:separator />
                                                <div>
                                                    <flux:heading size="lg">{{ __('Evangelist Name') }}
                                                    </flux:heading>
                                                    <flux:text>{{ $contact->evangelist_name }}</flux:text>
                                                </div>
                                            @endif

                                        </div>
                                    </flux:modal>
                                </flux:table.cell>

                                <flux:table.cell>
                                    @if ($contact->followUpPerson)
                                        <livewire:contact-card :contact="$contact->followUpPerson" />
                                    @else
                                        <flux:text>{{ __('Not assigned yet') }}</flux:text>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>

                                    @if ($contact->invalid_contact_details)
                                        <flux:badge color="red">{{ __('invalid') }}</flux:badge>
                                    @elseif ($contact->contacted_date)
                                        <flux:badge color="green">
                                            {{ $this->setDate($contact->contacted_date) }}
                                        </flux:badge>
                                    @else
                                        <flux:badge color="red">{{ __('pending') }}</flux:badge>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if (!$contact->invalid_contact_details)
                                        @if ($contact->not_interested)
                                            <flux:badge color="red">{{ __('no interest') }}</flux:badge>
                                        @elseif($contact->meeting_date)
                                            <flux:badge color="{{ $contact->met ? 'green' : 'orange' }}">
                                                {{ $this->setDate($contact->meeting_date) }}
                                            </flux:badge>
                                        @else
                                            <flux:badge color="red">{{ __('pending') }}</flux:badge>
                                        @endif
                                    @endif

                                </flux:table.cell>
                                <flux:table.cell>
                                    @if (!$contact->invalid_contact_details)
                                        @if ($contact->part_of_church)
                                            <flux:badge color="green">{{ __('part of church') }}</flux:badge>
                                        @else
                                            <flux:badge color="red">{{ __('pending') }}</flux:badge>
                                        @endif
                                    @endif

                                </flux:table.cell>
                                <flux:table.cell class="text-end" inset="top-bottom">
                                    <livewire:contacts.edit-dates wire:key="contact-{{ $contact->id }}"
                                        :contact="$contact" />
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </flux:card>

        @endif
    </div>
</div>
