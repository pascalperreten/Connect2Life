<div class="relative" x-data="{ open: false }">
    <flux:button variant="ghost" class="cursor-pointer" icon:trailing="chevron-down" x-on:click="open = !open" />
    <div x-on:click.outside="open = false" x-show="open" class="absolute p-2 top-11 left-0 bg-white border rounded"
        style="width: max-content;">
        @foreach ($this->ministry->events as $event)
            <div class="hover:bg-gray-50 py-2 cursor-pointer px-3 text-sm">
                <a href="{{ route('events.show', [$this->ministry, $event['slug']]) }}" wire:navigate
                    wire:key="event-{{ $event->id }}">
                    {{ $this->slug($event->slug) }}
                </a>
            </div>
        @endforeach
    </div>
</div>
