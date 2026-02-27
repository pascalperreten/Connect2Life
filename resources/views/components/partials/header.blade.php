@props([
    'heading' => '',
    'badgeText' => '',
    'color' => '',
])
<flux:card class="bg-cyan-700 flex gap-4 items-center">
    <flux:heading size="lg" class="py-3 text-stone-100">{{ $heading }}</flux:heading>
    @if ($badgeText)
        <flux:badge variant="solid" class="text-white" :color="$color">{{ $badgeText }}</flux:badge>
    @endif

    @if (auth()->user()->role === 'follow_up' && auth()->user()->events->count() > 1)
        <flux:spacer />
        <flux:dropdown align="end">
            <flux:button class="" icon:trailing="chevron-down">
                {{ __('Events') }}
            </flux:button>
            <flux:navmenu>
                @foreach (auth()->user()->events as $event)
                    <flux:navmenu.item href="{{ route('events.show', [$event->ministry, $event]) }}">
                        {{ $event->name }} {{ $event->city }}
                    </flux:navmenu.item>
                @endforeach
            </flux:navmenu>
        </flux:dropdown>
    @endif
</flux:card>
