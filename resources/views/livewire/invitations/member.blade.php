<div class="flex flex-col gap-6">

    <form wire:submit="save" class="flex flex-col gap-6">

        <!-- First Name -->
        <flux:field>
            <flux:label>First Name</flux:label>
            <flux:input readonly placeholder="First Name" autocomplete="given-name" autofocus wire:model="first_name"
                type="text" />
            <flux:error name="first_name" />
        </flux:field>


        <!-- Last Name -->
        <flux:field>
            <flux:label>Last Name</flux:label>
            <flux:input readonly placeholder="Last Name" autocomplete="family-name" wire:model="last_name"
                type="text" />
            <flux:error name="first_name" />
        </flux:field>

        <!-- Email Address -->
        <flux:field>
            <flux:label>Email address</flux:label>
            <flux:input readonly placeholder="email@example.com" autocomplete="email" wire:model="email"
                type="email" />
            <flux:error name="email" />
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label>Password</flux:label>
            <flux:input placeholder="Password" autocomplete="new-password" wire:model="password" type="password"
                viewable />
            <flux:error name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label>Confirm password</flux:label>
            <flux:input placeholder="Confirm password" autocomplete="new-password" wire:model="password_confirmation"
                type="password" viewable />
            <flux:error name="password_confirmation" />
        </flux:field>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>
</div>
