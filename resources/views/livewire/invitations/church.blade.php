<div>
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Kirche eintragen</flux:heading>
            <flux:text class="mt-2">Bitte gib die folgenden Informationen an</flux:text>
        </div>
        <flux:field>
            <flux:label>Vorname</flux:label>
            <flux:input wire:model="first_name" type="text" />
            <flux:error name="first_name" />
        </flux:field>
        <flux:field>
            <flux:label>Nachname</flux:label>
            <flux:input wire:model="last_name" type="text" />
            <flux:error name="last_name" />
        </flux:field>
        <flux:field>
            <flux:label>E-Mail</flux:label>
            <flux:input wire:model="email" type="email" />
            <flux:error name="email" />
        </flux:field>
        <flux:field>
            <flux:label>Telefon</flux:label>
            <flux:input wire:model="phone" type="text" />
            <flux:error name="phone" />
        </flux:field>
        <flux:field>
            <flux:label>Name Kirche</flux:label>
            <flux:input wire:model="church_name" type="text" />
            <flux:error name="church_name" />
        </flux:field>
        <flux:field>
            <flux:label>Funktion</flux:label>
            <flux:select wire:model.live="role" variant="listbox" placeholder="Wähle die Funktion">
                <flux:select.option value="pastor">Pastor</flux:select.option>
                <flux:select.option value="ambassador">Botschafter</flux:select.option>
                <flux:select.option value="church_member">Mitarbeiter</flux:select.option>
            </flux:select>
            <flux:error name="role" />
        </flux:field>
        <!-- Password -->
        <flux:field>
            <flux:label>Passwort</flux:label>
            <flux:input placeholder="Password" autocomplete="new-password" wire:model="password" type="password"
                viewable />
            <flux:error name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label>Passwort bestätigen</flux:label>
            <flux:input placeholder="Confirm password" autocomplete="new-password" wire:model="password_confirmation"
                type="password" viewable />
            <flux:error name="password_confirmation" />
        </flux:field>

        <div class="flex">
            <flux:spacer />
            <flux:button type="button" wire:click="registerChurch" variant="primary">Kirche registrieren
            </flux:button>
        </div>
    </div>
</div>
