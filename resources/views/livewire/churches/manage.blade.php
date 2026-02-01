<div>
    <div class="space-y-4">
        <flux:heading size="xl">
            {{ $this->church->name }}</flux:heading>

        <x-partials.header heading="{{ $event->name . ' - ' . $event->city }}" />
        <div>
            <flux:breadcrumbs>
                @can('view', $this->ministry)
                    <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                        {{ $this->ministry->name }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                        {{ $this->event->name }} - {{ $this->event->city }}
                    </flux:breadcrumbs.item>
                @endcan
                <flux:breadcrumbs.item
                    href="{{ route('churches.show', [$this->ministry, $this->event, $this->church]) }}" wire:navigate>
                    {{ $this->church->name }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>

        </div>
        <flux:separator />

    </div>
    <div class="mt-6">
        <livewire:church-nav :ministry="$this->ministry" :event="$this->event" :church="$this->church">
            <flux:card>
                <flux:tab.group class="">
                    <flux:tabs scrollable scrollable:scrollbar="hide" wire:model="activeTab">
                        <flux:tab name="details">Details</flux:tab>
                        <flux:tab name="follow-up-contact">Follow Up Kontakt</flux:tab>
                        @if ($this->evangelize)
                            <flux:tab name="evangelize">Evangelisieren</flux:tab>
                        @endif

                    </flux:tabs>
                    <flux:tab.panel name="details">
                        @if ($this->church->street === '')
                            <flux:text class="text-red-500 mb-4">
                                {{ __('Please fill out this form with all the required information!') }}</flux:text>
                        @endif
                        <livewire:churches.edit :ministry="$this->ministry" :church="$this->church" :event="$this->event" />
                    </flux:tab.panel>
                    <flux:tab.panel name="follow-up-contact">
                        <flux:select variant="listbox" wire:model.change="follow_up_contact" label="Follow-Up Kontakt"
                            placeholder="Follow-Up Kontakt"
                            description="Gib die Person an, welche wir für die Nacharbeit kontaktieren sollen">
                            @foreach ($this->church->members as $member)
                                <flux:select.option value="{{ $member->id }}" wire:key="{{ $member->id }}">
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </flux:select.option>
                            @endforeach
                            @if (!$this->church->members)
                                <flux:select.option disabled>Noch keine Mitglieder in dieser Kirche</flux:select.option>
                            @endif
                        </flux:select>

                    </flux:tab.panel>

                    @if ($this->evangelize)
                        <flux:tab.panel name="evangelize">
                            <div class="space-y-8">
                                <div class="flex justify-between items-center">
                                    <flux:heading size="lg">Evangelisieren</flux:heading>
                                </div>
                                <flux:separator />
                                <flux:text>Du möchtest selber evangelisieren gehen und direkt Leute deiner Gemeinde
                                    hinzufügen?
                                </flux:text>
                                <div class="space-y-2">
                                    <flux:text variant="strong">Kopiere diesen Link und schicke ihn deinen Evangelisten
                                    </flux:text>
                                    <flux:input readonly copyable value="{{ $this->addContact() }}"></flux:input>
                                </div>
                                <div class="space-y-2">
                                    <flux:text variant="strong">Oder öffne direkt das Formular über diesen Link
                                    </flux:text>
                                    <flux:button target="_blank" href="{{ $this->addContact() }}" wire:navigate>
                                        Kontakte
                                        hinzufügen
                                    </flux:button>
                                </div>
                            </div>

                        </flux:tab.panel>
                    @endif
                </flux:tab.group>
            </flux:card>
        </livewire:church-nav>

    </div>
    <flux:toast />
</div>
