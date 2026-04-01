{{-- resources/views/errors/503.blade.php --}}
<x-layouts.error title="503 - {{ __('Service Unavailable') }}">
    <div class="flex flex-col items-center justify-center text-center px-4">
        <img src="{{ asset('favicon.svg') }}" alt="503 Service Unavailable" class="w-34 mb-8">
        <flux:heading size="xxl">503</flux:heading>
        <flux:text class="mt-4 text-xl text-gray-600 dark:text-gray-300">
            {{ __('Service Unavailable') }}
        </flux:text>
        <flux:text class="mt-4 text-xl text-gray-600 dark:text-gray-300">
            {{ __('Unfortunately, the service is currently unavailable. Please try again later.') }}
        </flux:text>
        
    </div>
</x-layouts.error>
