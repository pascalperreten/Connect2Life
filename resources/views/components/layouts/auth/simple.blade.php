<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-2">
            {{-- <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                <span class="flex h-10 mb-1 items-center justify-center rounded-md">
                    <x-app-logo-icon class="size-25 fill-current text-black dark:text-white" />
                </span>
                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                
            </a> --}}
            <flux:navbar>
                <flux:navbar.item icon="arrow-left" href="{{ route('home') }}" class="flex items-center gap-2"
                    wire:navigate>
                    {{ __('Back') }}
                </flux:navbar.item>
            </flux:navbar>
            <flux:separator class="mb-4" />
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
