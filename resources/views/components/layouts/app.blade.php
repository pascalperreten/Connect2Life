<x-layouts.app.header :title="$title ?? null">
    <flux:main>
        <div class="max-w-6xl m-auto">
            {{ $slot }}
        </div>
    </flux:main>

</x-layouts.app.header>
