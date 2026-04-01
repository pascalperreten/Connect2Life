<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="bg-white p-6 flex items-center justify-center min-h-screen dark:bg-zinc-800">
    <div class="max-w-6xl m-auto">
        {{ $slot }}
    </div>
    @fluxScripts
    @stack('scripts')
</body>

</html>

