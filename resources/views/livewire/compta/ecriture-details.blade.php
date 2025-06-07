<div>
    <div class="flex items-center justify-between">
        <div class="flex items-end gap-2 font-[is-m] text-neutral-400 relative">
            <div class="text-xl">
                {{ $journal['code_journal'] }}
            </div>
            <div class="relative bottom-0 text-neutral-300">
                {{ $journal['libelle'] }}
            </div>
        </div>
        <div class="flex flex-row-reverse items-end gap-2 font-[is-m] text-neutral-400 relative">
            <div class="flex flex-row-reverse text-xl ">
                {{ $ecriture['date_ecriture'] }}
            </div>
            <div class="flex flex-row-reverse text-neutral-300">
                {{ $exercice ? $exercice['nom'] : '' }}
            </div>
        </div>
    </div>
    <div class="flex pt-4 pb-4 gap-4">
        <div class="flex flex-col w-96 max-w-96 max-h-[420px]">
            <img src="{{ empty($ecriture['piece_reference']) ? 'https://placehold.co/480x500/333333/FFFFFF/svg': $ecriture['piece_reference'] }}" class="max-w-full max-h-full rounded-sm" alt="reference">
            <div class="w-full mt-1">
                @if (empty($ecriture['piece_reference']))
                <button class="w-full items-center justify-center bg-neutral-900 text-white rounded-sm pt-1.5 pb-1.5">
                    ajouter une reference
                </button>
                @else
                <button class="w-full items-center justify-center bg-neutral-900 text-white rounded-sm pt-1.5 pb-1.5">
                    modifier la reference
                </button>
                @endif
            </div>
        </div>
        <div class="flex flex-col w-full justify-between">
            <div class="text-neutral-800 text-lg">
                {{ $ecriture['libelle_ecriture'] }}
            </div>
            <div class="flex items-center justify-between">
                <div class="flex flex-col ">
                    <div class="flex text-neutral-600 text-lg">debit</div>
                    <div class="flex text-neutral-900 text-2xl font-[is-m]">{{ $total_debit }}</div>
                </div>
                <div class="flex flex-col">
                    <div class="flex text-neutral-600 text-lg">credit</div>
                    <div class="flex text-neutral-900 text-2xl font-[is-m]">{{ $total_credit }}</div>
                </div>
            </div>
        </div>
    </div>
</div>