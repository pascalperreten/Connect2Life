<?php

use Livewire\Component;
use App\Models\Event;
use App\Models\Ministry;
use Flux\Flux;

new class extends Component {
    public Event $event;
    public Ministry $ministry;

    public function mapsUrl($church)
    {
        $address = urlencode($church->street . ', ' . $church->postal_code . ' ' . $church->city);
        return "https://www.google.com/maps/search/?api=1&query={$address}";
    }

    public function address($church)
    {
        $address = $church->street . ', ' . $church->postal_code . ' ' . $church->city;
        return $address;
    }

    public function deleteChurch($churchId)
    {
        $church = $this->event->churches()->findOrFail($churchId);
        foreach ($church->contacts as $contact) {
            $contact->update([
                'assigned' => false,
            ]);
        }
        $church->delete();

        Flux::toast('Kirche gelöscht', 'Die Kirche wurde erfolgreich gelöscht.', 'success');
    }
};
?>

<div>
    <flux:table>
        <flux:table.columns sticky>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Adresse</flux:table.column>
            <flux:table.column>Pastor</flux:table.column>
            <flux:table.column>Botschafter</flux:table.column>
            <flux:table.column>Follow Up Kontakt</flux:table.column>
            <flux:table.column>Webseite</flux:table.column>
            <flux:table.column></flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            @foreach ($event->churches as $church)
                <flux:table.row :key="$church->id">
                    <flux:table.cell>{{ $church->name }}
                    </flux:table.cell>
                    <flux:table.cell class="flex items-center gap-2">
                        <flux:dropdown>
                            <flux:button icon:trailing="map"></flux:button>
                            <flux:menu keep-open>
                                <div class="flex gap-2 items-center p-4">
                                    <a class="underline" target="_blank" href="{{ $this->mapsUrl($church) }}">
                                        <flux:text>
                                            {{ $church->street }}
                                        </flux:text>
                                        <flux:text>
                                            {{ $church->postal_code }} {{ $church->city }}
                                        </flux:text>
                                    </a>
                                    <flux:separator vertical />
                                    <div x-data="{ copied: false }">

                                        <flux:icon.clipboard class="cursor-pointer justify-self-end" x-show="!copied"
                                            x-on:click="$clipboard('{{ $this->address($church) }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                        <flux:icon.clipboard-document-check x-show="copied" />
                                    </div>
                                </div>
                            </flux:menu>
                        </flux:dropdown>

                    </flux:table.cell>


                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            @foreach ($church->pastors as $pastor)
                                @if ($pastor)
                                    <livewire:contact-card align="start" :contact="$pastor" />
                                @else
                                    <flux:text>kein Pastor</flux:text>
                                @endif
                            @endforeach
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            @foreach ($church->ambassadors as $ambassador)
                                @if ($ambassador)
                                    <livewire:contact-card align="start" :contact="$ambassador" />
                                @else
                                    <flux:text>kein Botschafter</flux:text>
                                @endif
                            @endforeach
                        </div>


                    </flux:table.cell>
                    <flux:table.cell>
                        @if ($church->followUpContact)
                            <div class="flex items-center gap-2">

                                <livewire:follow-up-contact align="start" :church="$church" />
                            </div>
                        @else
                            <flux:text>kein Follow Up Kontakt</flux:text>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        @if ($church->website_url)
                            <flux:dropdown>
                                <flux:button icon:trailing="globe-alt"></flux:button>
                                <flux:menu keep-open>
                                    <div class="flex gap-2 items-center p-4">
                                        <a class="underline" target="_blank" href="{{ $church->website_url }}">
                                            <flux:text>
                                                {{ $church->website_url }}
                                            </flux:text>
                                        </a>
                                        <flux:separator vertical />
                                        <div x-data="{ copied: false }">

                                            <flux:icon.clipboard class="cursor-pointer justify-self-end"
                                                x-show="!copied"
                                                x-on:click="$clipboard('{{ $church->website_url }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000)" />
                                            <flux:icon.clipboard-document-check x-show="copied" />
                                        </div>
                                    </div>
                                </flux:menu>
                            </flux:dropdown>
                        @endif
                    </flux:table.cell>
                    @can('view', $church)
                        <flux:table.cell>
                            <div class="flex justify-end">
                                <a href="{{ route('churches.show', [$ministry, $event, $church]) }}" wire:navigate>
                                    <flux:icon.arrow-right-circle />
                                </a>
                            </div>
                        </flux:table.cell>
                    @endcan
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
