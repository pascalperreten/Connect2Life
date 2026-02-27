<div class="space-y-6">
    <div class="space-y-4">

        <x-partials.header heading="{{ __('Manage') }}" />
        @can('view', $this->ministry)
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('ministry', $this->ministry) }}" wire:navigate>
                    {{ $this->ministry->name }}
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('events.show', [$this->ministry, $this->event]) }}" wire:navigate>
                    {{ $this->event->name }} - {{ $this->event->city }}
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:separator />
        @endcan

    </div>

    <livewire:event-nav :ministry="$this->ministry" :event="$this->event">
        <flux:card>
            <flux:tab.group class="">
                <flux:tabs class="h-18" scrollable wire:model="activeTab">
                    <div class="flex w-full justify-center">
                        <flux:tab name="language">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-language text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Languages') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="district">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-map text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Districts') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="postal_codes">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-location-dot text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Postal Codes') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="form">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-comments text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Follow-up Form') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="evangelize">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-bullhorn text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Evangelize') }}</span>
                            </div>
                        </flux:tab>
                        <flux:tab name="gospel_shares">
                            <div class="space-y-2">
                                <div class="flex justify-center">
                                    <i class="fa-regular fa-calculator text-xl"></i>
                                </div>
                                <span class="hidden md:block">{{ __('Gospel Shares') }}</span>
                            </div>
                        </flux:tab>
                    </div>
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
                <flux:tab.panel name="gospel_shares">
                    <livewire:add-gospel-shares :ministry="$this->ministry" :event="$this->event" />
                </flux:tab.panel>

            </flux:tab.group>

        </flux:card>
    </livewire:event-nav>
    <flux:toast />
</div>
