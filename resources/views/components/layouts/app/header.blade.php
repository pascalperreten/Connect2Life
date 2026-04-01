<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="grid grid-cols-3 w-full items-center">
           
            <div class="justify-self-start">
                <livewire:toggle-language />
            </div>
            @if (request()->route() && request()->route()->parameter('ministry'))
                <div class="justify-self-center">
                    <livewire:logo :ministry="request()->route()?->ministry" />
                </div>
            @else
                <div class="justify-self-center">
                    <flux:navbar>
                        <flux:navbar.item :href="route('dashboard', auth()->user()->ministry)"
                            wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navbar.item>
                    </flux:navbar>
                </div>
            @endif

            <!-- Desktop User Menu -->
            @if (auth()->user())
                <div class="col-start-3 justify-self-end">
                    <flux:dropdown position="top" align="end">
                        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                    class="w-full">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif
        </div>
    </flux:header>

    {{ $slot }}


    @fluxScripts

    @stack('scripts')
</body>

</html>
