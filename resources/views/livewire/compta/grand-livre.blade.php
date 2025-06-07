<div>
    <div class="flex flex-col items-center">
        <div class="w-[1100px]">
            @if (session()->has('error'))
            <div class="py-2 text-xl text-red-500">
                {{ session('error') }}
            </div>
            @endif
            <div class="h-7 flex items-center text-neutral-500 capitalize font-[is-m]">
                <div class="w-48">date</div>
                <div class="flex-1">libelle</div>
                <div class="w-40">debit</div>
                <div class="w-40">credit</div>
            </div>

            <div class="flex flex-col">

                @if (!empty($comptes))
                @foreach ($comptes as $compte)

                <livewire:compta.livre :id_exercice="$id_exercice" :numero_compte="$compte['numero_compte']" />

                @endforeach
                @endif

            </div>

            <div class="flex items-center font-[is-m] text-lg my-2 h-12 bg-neutral-900 text-white pl-4 rounded-sm">
                <div class="flex-1 text-md">TOTAL DU GRAND LIVRE</div>
                <div class="w-40">{{ $total['debit'] }}</div>
                <div class="w-40">{{ $total['credit'] }}</div>
            </div>
        </div>
    </div>
</div>