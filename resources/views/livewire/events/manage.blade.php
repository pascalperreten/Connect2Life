<div class="space-y-6">
    <div class="space-y-4">
        <flux:heading class="" size="xl">
            {{ __('Manage') }}</flux:heading>

        <x-partials.header heading="{{ $this->event->name }} - {{ $this->event->city }}" />
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('events.index', $this->ministry) }}" wire:navigate>
                    Events
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                    {{ $this->event->name }} - {{ $this->event->city }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ __('Manage') }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:separator />
    </div>

    <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
        <flux:card>
            <flux:tab.group class="">
                <flux:tabs class="h-18" scrollable wire:model="activeTab">
                    <div class="flex w-full justify-center">
                        <flux:tab name="language">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <flux:icon.language />
                                </div>
                                <span class="hidden md:block">{{ __('Languages') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="district">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <flux:icon.map />
                                </div>
                                <span class="hidden md:block">{{ __('Districts') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="postal_codes">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <flux:icon.map-pin />
                                </div>
                                <span class="hidden md:block">{{ __('Postal Codes') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="form">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <flux:icon.chat-bubble-left-right />
                                </div>
                                <span class="hidden md:block">{{ __('Follow-up Form') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="evangelize">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <flux:icon.megaphone />
                                </div>
                                <span class="hidden md:block">{{ __('Evangelize') }}</span>
                            </div>
                        </flux:tab>
                    </div>
                    {{-- <div class="md:hidden flex w-full justify-center p-2 gap-2">
                        <flux:tab icon="language" name="language" />
                        <flux:separator vertical />
                        <flux:tab icon="map" name="district" />
                        <flux:separator vertical />
                        <flux:tab icon="map-pin" name="postal_codes" />
                        <flux:separator vertical />
                        <flux:tab icon="chat-bubble-left-right" name="form" />
                        <flux:separator vertical />
                        <flux:tab icon="megaphone" name="evangelize" />
                    </div> --}}
                </flux:tabs>
                <flux:tab.panel name="language">
                    <livewire:languages.index :event="$this->event" />
                </flux:tab.panel>
                <flux:tab.panel name="district">
                    <livewire:districts.index :event="$this->event" />
                </flux:tab.panel>
                <flux:tab.panel name="postal_codes">
                    <livewire:postal-codes.index :event="$this->event" />
                </flux:tab.panel>
                <flux:tab.panel name="form">
                    <livewire:manage.follow-up :event="$this->event" />
                </flux:tab.panel>

                <flux:tab.panel name="evangelize">
                    <livewire:manage.evangelize :ministry="$this->ministry" :event="$this->event" />
                </flux:tab.panel>

            </flux:tab.group>

        </flux:card>
    </livewire:event-nav>
    <flux:toast />
</div>
