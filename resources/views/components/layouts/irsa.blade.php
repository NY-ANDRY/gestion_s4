<x-layouts.app>
    <div class="pl-14 pt-8 flex">
        <div class="flex flex-col w-36 mr-12 gap-2">
            @php
                $links = [
                    ['label' => 'Calcul', 'href' => '/irsa', 'match' => null],
                    ['label' => 'Edit',   'href' => '/irsa/edit', 'match' => 'edit'],
                ];
            @endphp

            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" wire:navigate wire:click="next" wire:key="{{ $link['href'] }}"
                   @class([
                       'text-sm font-[is-m] py-2 text-gray-400 pl-4 rounded-sm transition-all hover:bg-gray-100',
                       'active'=> request()->segment(2) === $link['match']
                   ])>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
        {{ $slot }}
    </div>
</x-layouts.app>
