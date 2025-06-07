<div class="flex flex-col">

    <div class="flex items-center justify-center h-8 my-1 font-[is-m] rounded-sm uppercase tracking-wider bg-neutral-200">
        <span>
            COMPTE {{ !empty($compte) ? $compte['numero_compte'] : '' }} {{ !empty($compte) ? $compte['intitule'] : '' }}
        </span>
    </div>

    @foreach ($mouvements as $mouvement)

    <div class="flex h-10 items-center border-b-[1px] border-b-neutral-200">
        <div class="w-48">{{ $mouvement['date_ecriture'] }}</div>
        <div class="flex-1">{{ $mouvement['libelle_ligne'] }}</div>
        <div class="w-40">{{ $mouvement['debit'] }}</div>
        <div class="w-40">{{ $mouvement['credit'] }}</div>
    </div>

    @endforeach

    <div class="flex h-10 items-center text-lg font-[is-m]">
        <div class="w-48">{{ $fin_exercice }}</div>
        <div class="flex-1">total</div>
        <div class="w-40">{{ $total['debit'] }}</div>
        <div class="w-40">{{ $total['credit'] }}</div>
    </div>
    <div class="flex h-10 items-center text-lg font-[is-m] border-b-[1px] border-b-neutral-200">
        <div class="w-48">{{ $fin_exercice }}</div>
        <div class="flex-1">solde</div>
        <div class="w-40">{{ $solde['debit'] }}</div>
        <div class="w-40">{{ $solde['credit'] }}</div>
    </div>

</div>