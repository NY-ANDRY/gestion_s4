<div>
    <div class="flex flex-col items-center">
        <div class="w-[1100px]">
            <div class="h-7 flex items-center text-neutral-600 capitalize font-[is-m]">
                <div class="w-48">date</div>
                <div class="flex-1">libelle</div>
                <div class="w-40">debit</div>
                <div class="w-40">credit</div>
            </div>

            <div class="flex flex-col">

                @foreach ($comptes as $compte)
                
                <livewire:compta.livre :id_exercice="$id_exercice" :numero_compte="$compte['numero_compte']" />

                @endforeach

            </div>

            <div class="flex items-center font-[is-m] text-lg h-12 bg-neutral-900 text-white pl-4 rounded-sm">
                <div class="flex-1 text-md">TOTAL DU GRAND LIVRE</div>
                <div class="w-40">{{ $total['debit'] }}</div>
                <div class="w-40">{{ $total['credit'] }}</div>
            </div>
        </div>
    </div>
</div>