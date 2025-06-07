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
        <div class="container flex flex-col h-full border-l-gray-300 border-solid border-l-[1px]">
            <header class="flex justify-between items-center p-8 pr-14 pl-14">
                <nav class="flex items-center gap-8 text-gray-500 font-[is-m] capitalize">

                    <a href="/" wire:navigate class="text-2xl font-[is-b] mr-8 text-gray-900">
                        {{ $title ?? 'Gestion' }}
                    </a>

                    @php
                    $navLinks = [
                    ['label' => 'compta', 'href' => '/compta', 'match' => 'compta'],
                    ['label' => 'irsa', 'href' => '/irsa', 'match' => 'irsa'],
                    ];
                    @endphp

                    @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}" wire:navigate wire:key="{{ $link['href'] }}"
                        @class([ 'min-h-full text-gray-400 hover:text-gray-900 transition-all' , 'text-gray-700'=> request()->segment(1) === $link['match']
                        ])>
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                </nav>

                <div class="menu">
                    <input type="text" placeholder="Search" class="h-8 bg-gray-100 rounded-xs px-4 py-2 w-56 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </header>
            <div class="flex flex-col flex-1 overflow-hidden overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>