{{-- resources/views/errors/500.blade.php --}}
<x-layouts.error title="500 - {{ __('Internal Server Error') }}">
    <div class="flex flex-col items-center justify-center text-center px-4">
        <img src="{{ asset('favicon.svg') }}" alt="500 Internal Server Error" class="w-34 mb-8">
        <flux:heading size="xxl">500</flux:heading>
        <flux:text class="mt-4 text-xl text-gray-600 dark:text-gray-300">
            {{ __('Internal Server Error') }}
        </flux:text>
        <flux:text class="mt-4 text-xl text-gray-600 dark:text-gray-300">
            {{ __('An unexpected error occurred on the server. Please try again later.') }}
        </flux:text>
        
    </div>
</x-layouts.error>
