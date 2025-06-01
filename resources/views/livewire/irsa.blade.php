<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="pl-2">
        <div class="pt-1 text-xl font-[is-m]">Calcul dette irsa</div>
        <div class="p-2 flex items-center gap-4 pt-4">
            <label for="">Montant: </label>
            <input type="number" wire:model="montant" class="border-b-1 border-neutral-500">
            <button wire:click="calcul" class="h-8 bg-blue-600 text-white rounded-sm px-4">valider</button>
        </div>

        @if (!empty($total_dettes))
        <div class="p-0 w-[700px]">
            <div class="flex min-w-full h-14 font-[is-m] border-b-1 border-gray-300 text-neutral-400">
                <div class="flex items-center w-2/6">range</div>
                <div class="flex items-center w-1/6">rate</div>
                <div class="flex items-center w-2/6">value</div>
                <div class="flex items-center w-1/6">irsa</div>
            </div>
            @foreach ($total_dettes["details"] as $key => $irsa_dette)
            <div class="flex min-w-full">
                <div class="flex items-center w-2/6 h-10">
                    <div class="w-20 ">
                        {{ is_numeric($irsa_dette["begin"]) ? number_format($irsa_dette["begin"]) : $irsa_dette["begin"] }}
                    </div>
                    <div class="pr-4">
                        -
                    </div>
                    <div class="w-20 ">
                        {{ is_numeric($irsa_dette["end"]) ? number_format($irsa_dette["end"]) : $irsa_dette["end"] }}
                        @if (empty($irsa_dette["end"]))
                        et plus
                        @endif
                    </div>
                </div>
                <div class="flex items-center w-1/6 h-10">{{ $irsa_dette["rate"] }} %</div>
                <div class="flex items-center w-2/6 ">{{ $irsa_dette["value"] }}</div>
                <div class="flex items-center w-1/6 ">{{ $irsa_dette["irsa"] }}</div>
            </div>
            @endforeach
        </div>
        <div class="pt-4 font-[is-m] text-xl text-neutral-800">IRSA: {{ $total_dettes["value"] }}</div>
        @endif
    </div>
</div>