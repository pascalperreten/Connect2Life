<?php

use Livewire\Component;
use App\Models\Ministry;
use App\Models\Event;
use App\Models\Church;
use App\Models\District;
use App\Models\Language;
use App\Models\PostalCode;
use App\Livewire\Forms\ChurchForm;
use App\Livewire\Forms\DistrictForm;
use App\Livewire\Forms\LanguageForm;
use App\Livewire\Forms\PostalCodeForm;

new class extends Component {
    public Ministry $ministry;
    public Event $event;
    public ?Church $church;
    public churchForm $form;
    public DistrictForm $district_form;
    public LanguageForm $language_form;
    public PostalCodeForm $postal_code_form;

    public function mount(Event $event, ?Church $church)
    {
        $this->event = $event;
        $this->church = $church;
        $this->district_form->setDistricts($this->event);
        $this->language_form->setLanguages($this->event);
        $this->postal_code_form->setPostalCodes($this->event);
        if ($this->church) {
            $this->form->setChurch($this->church);
        }
    }

    public function createDistrict()
    {
        $this->district_form->event = $this->event;
        $newDistrict = $this->district_form->create();
        $this->modal('create-district')->close();
        $this->district_form->setDistricts($this->event);
        $this->form->districts[] = $newDistrict->id;
    }
    public function createLanguage()
    {
        $this->language_form->event = $this->event;
        $newLanguage = $this->language_form->addLanguage();
        $this->modal('create-language')->close();
        $this->language_form->setLanguages($this->event);
        $this->form->languages[] = $newLanguage->id;
    }

    public function createPostalCode()
    {
        $this->postal_code_form->event = $this->event;
        $newPostalCode = $this->postal_code_form->addPostalCode();
        $this->modal('create-postal-code')->close();
        $this->postal_code_form->setPostalCodes($this->event);
        $this->form->postal_codes[] = $newPostalCode->id;
    }

    public function save()
    {
        if ($this->church?->id) {
            $this->form->update($this->church);
            session()->flash('success', __('Church updated succesfully'));
            $this->redirectRoute('churches.show', [$this->ministry, $this->event, $this->church], navigate: true);
        } else {
            $this->form->create($this->event);
            return $this->redirect(route('churches.index', [$this->ministry, $this->event]), navigate: true);
        }
    }

    public function delete()
    {
        foreach ($this->church->contacts as $contact) {
            $contact->update([
                'assigned' => false,
            ]);
        }
        $this->church->delete();

        session()->flash('success', 'Church deleted!');
        return $this->redirectRoute('churches.index', [$this->ministry, $this->event], navigate: true);
    }
};
?>

<div>

    <form wire:submit="save" class="space-y-6">
        <flux:field>
            <flux:label>{{ __('Name Church') }}</flux:label>

            <flux:input wire:model="form.name" type="text" />

            <flux:error name="form.name" />
        </flux:field>
        <flux:field>
            <flux:label>{{ __('Street') }}</flux:label>

            <flux:input wire:model="form.street" type="text" />

            <flux:error name="form.street" />
        </flux:field>
        <flux:field>
            <flux:label>{{ __('Postal Code') }}</flux:label>

            <flux:input wire:model="form.postal_code" type="text" />

            <flux:error name="form.postal_code" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('City') }}</flux:label>

            <flux:input wire:model="form.city" type="text" />

            <flux:error name="form.city" />
        </flux:field>

        <flux:pillbox wire:key="district" variant="combobox" wire:model.live="form.districts"
            label="{{ __('Districts') }}" placeholder="Bezirke"
            description="{{ __('Please list all districts in which your church is active.') }}" multiple>
            <x-slot name="input">
                <flux:pillbox.input wire:model.live="district_form.name" placeholder="{{ __('District') }}" />
            </x-slot>
            @foreach ($this->district_form->districts as $district)
                <flux:pillbox.option value="{{ $district->id }}" wire:key="{{ $district->id }}">
                    {{ $district->name }}
                </flux:pillbox.option>
            @endforeach
            <flux:pillbox.option.create min-length="2" wire:click="createDistrict">
                {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span wire:text="district_form.name"></span>"
                {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}</flux:pillbox.option.create>

            <x-slot name="empty">
                <flux:pillbox.option.empty when-loading="Loading tags...">
                    {{ __('continue typing...') }}
                </flux:pillbox.option.empty>
            </x-slot>

        </flux:pillbox>
        <flux:pillbox wire:key="languge" variant="combobox" wire:model.live="form.languages"
            label="{{ __('Languages') }}"
            description="{{ __('Please list all languages that you can support in the follow-up process.') }}"
            multiple>
            <x-slot name="input">
                <flux:pillbox.input wire:model.live="language_form.name" placeholder="{{ __('Language') }}" />
            </x-slot>
            @foreach ($this->language_form->languages as $language)
                <flux:pillbox.option value="{{ $language->id }}" wire:key="{{ $language->id }}">
                    {{ $language->translation->name }}
                </flux:pillbox.option>
            @endforeach
            <flux:pillbox.option.create min-length="2" wire:click="createLanguage">
                {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span wire:text="language_form.name"></span>"
                {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}</flux:pillbox.option.create>

            <x-slot name="empty">
                <flux:pillbox.option.empty when-loading="Loading tags...">
                    {{ __('continue typing...') }}
                </flux:pillbox.option.empty>
            </x-slot>

        </flux:pillbox>
        <flux:pillbox wire:key="postal_code" variant="combobox" wire:model.live="form.postal_codes"
            label="{{ __('Postal Codes') }}" description="{{ __('Enter all postal codes in your catchment area') }}"
            multiple>
            <x-slot name="input">
                <flux:pillbox.input wire:model.live="postal_code_form.name" placeholder="{{ __('Postal Code') }}" />
            </x-slot>

            @foreach ($this->postal_code_form->postal_codes as $postal_code)
                <flux:pillbox.option value="{{ $postal_code->id }}" wire:key="{{ $postal_code->id }}">
                    {{ $postal_code->name }}
                </flux:pillbox.option>
            @endforeach
            <flux:pillbox.option.create min-length="4" wire:click="createPostalCode">
                {{ app()->getLocale() === 'en' ? 'add' : '' }} "<span wire:text="postal_code_form.name"></span>"
                {{ app()->getLocale() === 'de' ? 'hinzufügen' : '' }}
            </flux:pillbox.option.create>

            <x-slot name="empty">
                <flux:pillbox.option.empty when-loading="Loading tags...">
                    {{ __('continue typing...') }}
                </flux:pillbox.option.empty>
            </x-slot>

        </flux:pillbox>

        <flux:field>
            <flux:label>{{ __('Website Url') }}</flux:label>

            <flux:input wire:model="form.website_url" type="url" />

            <flux:error name="form.website_url" />
        </flux:field>
        <div class="flex justify-end gap-2">
            @if ($this->church?->id)
                <flux:button variant="primary" type="submit">{{ __('Save Changes') }}</flux:button>
                @can('delete', $church)
                    <flux:modal.trigger name="delete-church-{{ $church->id }}">
                        <flux:button variant="danger" class="text-red-500">Löschen</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="delete-church-{{ $church->id }}" class="md:w-96">
                        <div class="space-y-6 text-left">
                            <div>
                                <flux:heading size="lg">{{ $church->name }} löschen</flux:heading>
                                <flux:text class="mt-2 text-red-500">Möchtest du diese Kirche wirklich löschen?
                                    <br>Dies kann nicht rückgängig gemacht werden.
                                </flux:text>
                            </div>

                            <div class="flex">
                                <flux:spacer />

                                <flux:button type="button" wire:click="delete()" variant="danger">Kirche löschen
                                </flux:button>
                            </div>
                        </div>
                    </flux:modal>
                @endcan
            @else
                <flux:button variant="primary" type="submit">{{ __('Create Church') }}</flux:button>
            @endif
        </div>
    </form>

</div>
