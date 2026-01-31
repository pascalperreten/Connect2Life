<div>
    <div class="mt-6 max-w-md">
        <form wire:submit="save" class="space-y-6">
            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model="form.name" type="text" />
                <flux:error name="form.name" />
            </flux:field>
            <flux:radio.group wire:model="form.gender" variant="buttons" class="w-full *:flex-1" label="Geschlecht">
                <flux:radio value="male">Mann</flux:radio>
                <flux:radio value="female">Frau</flux:radio>
            </flux:radio.group>


            <flux:pillbox wire:model="form.language" label="Sprachen" placeholder="Sprachen"
                description="Wähle alle Sprachen aus, welche ihr im Follow Up Prozess begleiten könnt" searchable
                multiple>
                @foreach ($this->language_form->languages as $language)
                    <flux:pillbox.option value="{{ $language->id }}" wire:key="{{ $language->id }}">
                        {{ $language->name }}
                    </flux:pillbox.option>
                @endforeach
                <flux:pillbox.option.create modal="create-language">Sprache hinzufügen</flux:pillbox.option>
            </flux:pillbox>

            <flux:select wire:model="form.age" variant="listbox" placeholder="Alter" label="Alter">
                <flux:select.option>U 18</flux:select.option>
                <flux:select.option>18 - 25</flux:select.option>
                <flux:select.option>25 - 40</flux:select.option>
                <flux:select.option>40 - 65</flux:select.option>
                <flux:select.option>Ü 65</flux:select.option>
            </flux:select>

            <flux:radio.group wire:model.live="form.way_to_get_in_contact" variant="buttons" class="w-full *:flex-1"
                label="Wie können wir Kontakt aufnehmen?">
                <flux:radio value="phone">Telefon</flux:radio>
                <flux:radio value="social_media">Social Media</flux:radio>
                <flux:radio value="email">Email</flux:radio>
                <flux:radio value="other">Andere</flux:radio>
            </flux:radio.group>


            @if ($this->form->way_to_get_in_contact === 'phone')
                <flux:field>
                    <flux:label>Phone number</flux:label>
                    <flux:input wire:model="form.phone" type="tel" pattern="\+?[0-9\- ]+" />
                    <flux:error name="form.phone" />
                </flux:field>
            @elseif ($this->form->way_to_get_in_contact === 'social_media')
                <div class="border border-gray-200 p-4 rounded space-y-6">
                    <flux:radio.group wire:model.live="form.social_platform" variant="buttons"
                        class="w-full grid grid-cols-2 " label="Welche Platform?">
                        <flux:radio value="insta">Instagram</flux:radio>
                        <flux:radio value="facebook">Facebook</flux:radio>
                        <flux:radio value="tiktok">Tik Tok</flux:radio>
                        <flux:radio value="other">Andere</flux:radio>
                    </flux:radio.group>

                    @if ($this->form->social_platform === 'other')
                        <flux:field>
                            <flux:label>Plattform</flux:label>
                            <flux:input wire:model="form.platform" type="text" />
                            <flux:error name="form.platform" />
                        </flux:field>
                    @endif
                    <flux:field>
                        <flux:label>Benutzername</flux:label>
                        <flux:input wire:model="form.user_name" type="text" />
                        <flux:error name="form.user_name" />
                    </flux:field>
                    <flux:field>
                        <flux:label>URL zum Profil</flux:label>
                        <flux:input wire:model="form.url" type="url" />
                        <flux:error name="form.url" />
                    </flux:field>
                </div>
            @elseif ($this->form->way_to_get_in_contact === 'email')
                <flux:field>
                    <flux:label>Email Adresse</flux:label>
                    <flux:input wire:model="form.email" type="email" />
                    <flux:error name="form.email" />
                </flux:field>
            @elseif ($this->form->way_to_get_in_contact === 'other')
                <flux:field>
                    <flux:label>Contact Information</flux:label>
                    <flux:input wire:model="form.other" type="text" />
                    <flux:error name="form.other" />
                </flux:field>
            @endif

            <flux:field>
                <flux:label>PLZ</flux:label>
                <flux:input wire:model="form.postal_code" type="number" />
                <flux:error name="form.postal_code" />
            </flux:field>
            <flux:radio.group wire:model.live="form.foreign_city" variant="buttons" class="w-full *:flex-1"
                label="Person lebt in {{ $this->event->city }}">
                <flux:radio value="0">Ja</flux:radio>
                <flux:radio value="1">Nein</flux:radio>
            </flux:radio.group>

            @if ($this->form->foreign_city === '0')
                <flux:select wire:model="form.district" label="Bezirk" placeholder="Bezirk" variant="listbox"
                    searchable>
                    <flux:select.option>Charlottenburg-Wilmersdorf</flux:select.option>
                    <flux:select.option>Friedrichshain-Kreuzberg</flux:select.option>
                    <flux:select.option>Lichtenberg</flux:select.option>
                    <flux:select.option>Marzahn-Hellersdorf</flux:select.option>
                    <flux:select.option>Mitte</flux:select.option>
                    <flux:select.option>Neukölln</flux:select.option>
                    <flux:select.option>Pankow</flux:select.option>
                    <flux:select.option>Reinickendorf</flux:select.option>
                    <flux:select.option>Spandau</flux:select.option>
                    <flux:select.option>Steglitz-Zehlendorf</flux:select.option>
                    <flux:select.option>Tempelhof-Schöneberg</flux:select.option>
                    <flux:select.option>Treptow-Köpenick</flux:select.option>
                </flux:select>
            @elseif ($this->form->foreign_city === '1')
                <flux:field>
                    <flux:label>City</flux:label>
                    <flux:input wire:model="form.city" type="text" />
                    <flux:error name="form.city" />
                </flux:field>
            @endif

            <flux:radio.group wire:model="form.decision" variant="buttons" class="w-full *:flex-1"
                label="Person hat sich für Jesus entschieden">
                <flux:radio value="true">Ja</flux:radio>
                <flux:radio value="false">Nein</flux:radio>
            </flux:radio.group>
            <flux:field>
                <flux:label>Name Evangelist</flux:label>
                <flux:input wire:model="form.evangelist_name" type="text" />
                <flux:error name="form.evangelist_name" />
            </flux:field>
            <flux:radio.group wire:model="form.soe" variant="buttons" class="w-full *:flex-1"
                label="Bist du ein Student an der SOE?">
                <flux:radio value="true">Ja</flux:radio>
                <flux:radio value="false">Nein</flux:radio>
            </flux:radio.group>
            <flux:field>
                <flux:textarea wire:model="form.comments" label="Bemerkungen" />
                <flux:error name="form.comments" />
            </flux:field>
            <flux:button type="submit" class="w-full" variant="primary" color="green">Speichern
            </flux:button>

        </form>
        <flux:toast />
    </div>
</div>
