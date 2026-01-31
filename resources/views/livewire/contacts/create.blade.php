<div>
    <flux:heading class="text-center" size="xl">
        {{ $this->event->name }} | {{ $this->event->city }}
        @if (isset($this->church))
            {{ ' | ' . $this->church->name }}
        @endif
    </flux:heading>
    <div class="border-b border-zinc-200 pb-4">
        <flux:heading class="text-center">{{ __('Evangelize') }}</flux:heading>
    </div>

    <div class="mt-6 max-w-md m-auto">
        @if ($this->success_message !== '')
            <div class=>
                <flux:card class="text-center space-y-6 p-10 m-auto max-w-md">
                    <flux:heading size="xl">{{ $this->success_message }}</flux:heading>
                    <flux:text>{{ __('Your entry has been successfully submitted!') }}</flux:text>
                    <flux:button class="bg-cyan-700 hover:bg-cyan-800 cursor-pointer" variant="primary"
                        wire:click="newContact">{{ __('Back to the form') }}
                    </flux:button>
                </flux:card>
            </div>
        @else
            <form wire:submit.prevent="save" class="space-y-6">
                <flux:tab.group>
                    <div class="text-center">
                        <flux:tabs class="w-full" variant="segmented" wire:model="with_contact">
                            <flux:tab wire:click="resetNumbers" name="true">{{ __('With contact details') }}
                            </flux:tab>
                            <flux:tab name="false">{{ __('Without contact details') }}</flux:tab>
                        </flux:tabs>
                    </div>


                    <flux:tab.panel class="space-y-6" name="true">
                        @if ($this->page === 0)
                            <flux:heading>{{ __('Approval for sharing contact information') }}</flux:heading>
                            <flux:text>
                                {{ __('The person agrees that their contact details may be passed on to a local church.') }}
                            </flux:text>

                            <flux:button wire:click="nextPage" class="bg-cyan-700 hover:bg-cyan-800 w-full"
                                variant="primary">
                                {{ __('Yes') }}
                            </flux:button>
                        @elseif ($this->page === 1)
                            <flux:field>
                                <flux:label>Name</flux:label>
                                <flux:input wire:key="name" wire:model="form.name" type="text" />
                                <flux:error name="form.name" />
                            </flux:field>
                            @if ($this->form->form_fields->gender)
                                <flux:radio.group wire:key="gender" wire:model="form.gender" variant="buttons"
                                    class="w-full *:flex-1" label="{{ __('Gender') }}">
                                    <flux:radio value="male">{{ __('Male') }}</flux:radio>
                                    <flux:radio value="female">{{ __('Female') }}</flux:radio>
                                </flux:radio.group>
                            @endif

                            @if ($this->form->form_fields->language)
                                <flux:pillbox wire:key="language" variant="combobox" wire:model.live="form.language"
                                    label="{{ __('Languages') }}"
                                    description="{{ __('Select all languages or add new ones.') }}" multiple>
                                    <x-slot name="input">
                                        <flux:pillbox.input wire:model.live="language_form.name"
                                            placeholder="{{ __('Language') }}" />
                                    </x-slot>
                                    @foreach ($this->language_form->languages as $language)
                                        <flux:pillbox.option value="{{ $language->id }}"
                                            wire:key="{{ $language->id }}">
                                            {{ $language->translation->name }}
                                        </flux:pillbox.option>
                                    @endforeach
                                    <flux:pillbox.option.create min-length="2" wire:click="createLanguage">
                                        {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span
                                            wire:text="language_form.name"></span>"
                                        {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}
                                    </flux:pillbox.option.create>

                                    <x-slot name="empty">
                                        <flux:pillbox.option.empty when-loading="Loading tags...">
                                            {{ __('continue typing...') }}
                                        </flux:pillbox.option.empty>
                                    </x-slot>
                                </flux:pillbox>
                            @endif

                            @if ($this->form->form_fields->age)
                                <flux:select wire:key="age" wire:model="form.age" variant="listbox"
                                    placeholder="{{ __('Age') }}" label="{{ __('Age') }}">
                                    <flux:select.option>U 18</flux:select.option>
                                    <flux:select.option>18 - 25</flux:select.option>
                                    <flux:select.option>25 - 40</flux:select.option>
                                    <flux:select.option>40 - 65</flux:select.option>
                                    <flux:select.option>Ü 65</flux:select.option>
                                </flux:select>
                            @endif

                            <flux:button wire:click="nextPage" class="bg-cyan-700 hover:bg-cyan-800 w-full"
                                variant="primary">{{ __('Next') }}
                            </flux:button>
                            <flux:button wire:click="lastPage" class="w-full" variant="filled">{{ __('Back') }}
                            </flux:button>

                            {{-- Kontaktaufnahme Step 2 --}}
                        @elseif ($this->page === 2)
                            <flux:radio.group wire:key="way_to_get_in_contact"
                                wire:model.change="form.way_to_get_in_contact" variant="buttons" class="w-full *:flex-1"
                                label="{{ __('How can we get in touch?') }}">
                                <flux:radio value="phone">{{ __('Phone') }}</flux:radio>
                                <flux:radio value="social_media">Social Media</flux:radio>
                                <flux:radio value="email">{{ __('Email') }}</flux:radio>
                                <flux:radio value="other_contact">{{ __('Other') }}</flux:radio>
                            </flux:radio.group>


                            @if ($this->form->way_to_get_in_contact === 'phone')
                                <flux:field>
                                    <flux:label>{{ __('Phone Number') }}</flux:label>
                                    <flux:input wire:key="phone" wire:model="form.phone" type="tel"
                                        pattern="\+?[0-9\- ]+" />
                                    <flux:error name="form.phone" />
                                </flux:field>
                            @elseif ($this->form->way_to_get_in_contact === 'social_media')
                                <div class="border border-gray-200 p-4 rounded space-y-6">
                                    <flux:radio.group wire:key="social_platform" wire:model.live="form.social_platform"
                                        variant="buttons" class="w-full grid grid-cols-2 "
                                        label="{{ __('Which platform?') }}">
                                        <flux:radio value="instagram">Instagram</flux:radio>
                                        <flux:radio value="facebook">Facebook</flux:radio>
                                        <flux:radio value="tiktok">Tik Tok</flux:radio>
                                        <flux:radio value="other_platform">{{ __('Other') }}</flux:radio>
                                    </flux:radio.group>

                                    @if ($this->form->social_platform === 'other_platform')
                                        <flux:field>
                                            <flux:label>{{ __('Platform') }}</flux:label>
                                            <flux:input wire:key="other_platform" wire:model="form.other_platform"
                                                type="text" />
                                            <flux:error name="form.other_platform" />
                                        </flux:field>
                                    @endif
                                    <flux:field>
                                        <flux:label>{{ __('Username') }}</flux:label>
                                        <flux:input wire:key="user_name" wire:model="form.user_name" type="text" />
                                        <flux:error name="form.user_name" />
                                    </flux:field>
                                    <flux:field>
                                        <flux:label>{{ __('URL to profile') }}</flux:label>
                                        <flux:input wire:key="url" wire:model="form.url" type="url" />
                                        <flux:error name="form.url" />
                                    </flux:field>
                                </div>
                            @elseif ($this->form->way_to_get_in_contact === 'email')
                                <flux:field>
                                    <flux:label>{{ __('Email Address') }}</flux:label>
                                    <flux:input wire:key="email" wire:model="form.email" type="email" />
                                    <flux:error name="form.email" />
                                </flux:field>
                            @elseif ($this->form->way_to_get_in_contact === 'other_contact')
                                <flux:field>
                                    <flux:label>{{ __('Contact Information') }}</flux:label>
                                    <flux:input wire:key="other_contact" wire:model="form.other_contact"
                                        type="text" />
                                    <flux:error name="form.other_contact" />
                                </flux:field>
                            @endif

                            <flux:button wire:click="nextPage" class="bg-cyan-700 hover:bg-cyan-800 w-full"
                                variant="primary">{{ __('Next') }}
                            </flux:button>
                            <flux:button wire:click="lastPage" class="w-full" variant="filled">{{ __('Back') }}
                            </flux:button>
                        @elseif ($this->page === 3)
                            <flux:radio.group wire:key="foreign_city" wire:model.change="form.foreign_city"
                                variant="buttons" class="w-full *:flex-1"
                                label="{{ __('Person lives in') }} {{ $this->event->city }}">
                                <flux:radio :value="0" label="{{ __('Yes') }}" />
                                <flux:radio :value="1" label="{{ __('No') }}" />
                            </flux:radio.group>

                            @if (isset($this->form->foreign_city) && !$this->form->foreign_city)
                                @if ($this->form->form_fields->postal_code)
                                    <flux:select wire:key="postal_code" wire:model="form.postal_code"
                                        label="{{ __('Postal Code') }}" variant="combobox"
                                        description="{{ __('Select the postal code or add it.') }}">
                                        <x-slot name="input">
                                            <flux:select.input wire:key="postal_input"
                                                wire:model="postal_code_form.name"
                                                placeholder="{{ __('Postal Code') }}" />
                                        </x-slot>
                                        @foreach ($this->postal_code_form->postal_codes as $postal_code)
                                            <flux:select.option wire:key="postal_code-{{ $postal_code->id }}"
                                                value="{{ $postal_code->id }}">
                                                {{ $postal_code->name }}
                                            </flux:select.option>
                                        @endforeach
                                        <flux:pillbox.option.create min-length="4" wire:click="createPostalCode">
                                            {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span
                                                wire:text="postal_code_form.name"></span>"
                                            {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}
                                        </flux:pillbox.option.create>

                                        <x-slot name="empty">
                                            <flux:pillbox.option.empty when-loading="Loading tags...">
                                                {{ __('continue typing...') }}
                                            </flux:pillbox.option.empty>
                                        </x-slot>
                                    </flux:select>
                                @endif
                                @if ($this->form->form_fields->district)
                                    <flux:select wire:key="district-{{ $this->form->resetCounter }}"
                                        wire:model="form.district" label="{{ __('District') }}" variant="combobox"
                                        description="{{ __('Select the district or add a new one.') }}">
                                        <x-slot name="input">
                                            <flux:select.input wire:model="district_form.name"
                                                placeholder="{{ __('District') }}" />
                                        </x-slot>
                                        @foreach ($this->district_form->districts as $district)
                                            <flux:select.option value="{{ $district->id }}"
                                                wire:key="{{ $district->id }}">
                                                {{ $district->name }}
                                            </flux:select.option>
                                        @endforeach
                                        <flux:pillbox.option.create min-length="2" wire:click="createDistrict">
                                            {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span
                                                wire:text="district_form.name"></span>"
                                            {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}
                                        </flux:pillbox.option.create>

                                        <x-slot name="empty">
                                            <flux:pillbox.option.empty when-loading="Loading tags...">
                                                {{ __('continue typing...') }}
                                            </flux:pillbox.option.empty>
                                        </x-slot>
                                    </flux:select>
                                @endif
                            @elseif (isset($this->form->foreign_city) && $this->form->foreign_city)
                                <flux:field>
                                    <flux:label>{{ __('City') }}</flux:label>
                                    <flux:input wire:key="city" wire:model="form.city" type="text" />
                                    <flux:error name="form.city" />
                                </flux:field>
                            @endif
                            <flux:button wire:click="nextPage" class="bg-cyan-700 hover:bg-cyan-800 w-full"
                                variant="primary">{{ __('Next') }}
                            </flux:button>
                            <flux:button wire:click="lastPage" class="w-full" variant="filled">{{ __('Back') }}
                            </flux:button>
                        @elseif ($this->page === 4)
                            <flux:radio.group wire:key="decision" wire:model="form.decision" variant="buttons"
                                class="w-full *:flex-1" label="{{ __('Person has decided for Jesus') }}">
                                <flux:radio value="1">{{ __('Yes') }}</flux:radio>
                                <flux:radio value="0">{{ __('No') }}</flux:radio>
                            </flux:radio.group>
                            @if ($this->form->form_fields->evangelist_name)
                                <flux:field>
                                    <flux:label>Name Evangelist</flux:label>
                                    <flux:input wire:key="evangelist_name" wire:model="form.evangelist_name"
                                        type="text" />
                                    <flux:error name="form.evangelist_name" />
                                </flux:field>
                            @endif

                            <flux:field>
                                <flux:textarea wire:key="comments" wire:model="form.comments"
                                    label="{{ __('Comments') }}" />
                                <flux:error name="form.comments" />
                            </flux:field>
                            <flux:button type="submit" class="bg-cyan-700 hover:bg-cyan-800 w-full"
                                variant="primary">
                                {{ __('Save') }}
                            </flux:button>
                            <flux:button wire:click="lastPage" class="w-full" variant="filled">{{ __('Back') }}
                            </flux:button>
                        @endif



                    </flux:tab.panel>
                    <flux:tab.panel class="space-y-6" name="false">
                        <flux:field>
                            <flux:label>{{ __('Number of Decisions') }}</flux:label>
                            <flux:input wire:key="number_of_decisions" wire:model="form.number_of_decisions"
                                type="number" />
                            <flux:error name="form.number_of_decisions" />
                        </flux:field>
                        <flux:button type="button" wire:click="addDecisions"
                            class="bg-cyan-700 hover:bg-cyan-800 w-full" variant="primary">
                            {{ __('Save') }}
                        </flux:button>
                    </flux:tab.panel>
                </flux:tab.group>


            </form>
        @endif
        <flux:toast />
    </div>
</div>
