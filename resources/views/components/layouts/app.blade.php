<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Gestion' }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex flex-col items-center h-screen">
        <div class="container h-full border-l-gray-300 border-solid border-l-[1px]">
            <header class="flex justify-between items-center p-8 pl-14">
                <nav class="flex items-center gap-8 text-gray-500 font-[is-m]">

                    <a href="/" wire:navigate class="text-2xl font-[is-b] mr-8 text-gray-900">{{ $title ?? 'Gestion' }}</a>
                    <a class="min-h-full" href="/irsa" wire:navigate>irsa</a>
                    <a class="min-h-full" href="/" wire:navigate>about</a>

                </nav>
                <div class="menu">
                    <input type="text" placeholder="Search" class="h-9 bg-gray-100 rounded-xs px-4 py-2 w-48 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </header>
            {{ $slot }}
        </div>
    </div>
</body>

</html>