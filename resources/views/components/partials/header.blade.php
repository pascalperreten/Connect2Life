@props([
    'heading' => '',
    'buttonText' => '',
    'href' => '',
    'icon' => '',
    'iconTrailing' => '',
])
<flux:card class="bg-cyan-700 flex justify-between items-center">
    <flux:heading size="lg" class="py-3 text-stone-100">{{ $heading }}</flux:heading>
    @if ($href)
        <flux:button icon="{{ $icon }}" icon-trailing="{{ $iconTrailing }}" wire:navigate
            href="{{ $href }}">
            {{ $buttonText }}</flux:button>
    @endif

</flux:card>
