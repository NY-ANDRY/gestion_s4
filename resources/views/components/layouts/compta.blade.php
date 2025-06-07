<x-layouts.app>
    <div class="pl-14 pt-8 pr-14 flex max-h-full h-full relative">
        <div class="flex flex-col w-36 h-full mr-12 gap-2 relative">
            @php
            $links = [
            ['label' => 'Compte', 'href' => '/compta', 'match' => null],
            ['label' => 'Journaux', 'href' => '/compta/journaux', 'match' => 'journaux'],
            ['label' => 'Exercices', 'href' => '/compta/exercices', 'match' => 'exercices'],
            ['label' => 'Ecritures', 'href' => '/compta/ecritures', 'match' => 'ecritures']
            ];
            @endphp

            @foreach ($links as $link)
            <a href="{{ $link['href'] }}" wire:navigate wire:click="next" wire:key="{{ $link['href'] }}"
                @class([ 'text-sm font-[is-m] py-2 text-gray-400 pl-4 rounded-sm transition-all hover:bg-gray-100' , 'active'=> request()->segment(2) === $link['match']
                ])>
                {{ $link['label'] }}
            </a>
            @endforeach
        </div>
        <div class="flex-1 h-full justify-center items-center bg-neutral-0 rounded-xl overflow-auto top-0 relative">
            {{ $slot }}
        </div>
    </div>
</x-layouts.app>