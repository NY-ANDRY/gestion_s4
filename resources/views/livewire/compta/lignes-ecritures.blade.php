<div>
    @if ($show_ecriture_details)
    <div class="flex flex-row-reverse mb-2">
        <button class="flex gap-2 items-center bg-blue-600 font-[is-m] px-2 text-white rounded-sm relative" wire:click="swap_ecriture_details">
            <div class="h-5 top-px relative">
                <img src="/assets/svg/show_off_white.svg" class="max-h-full max-w-full" alt="">
            </div>
            <div>details ecriture</div>
        </button>
    </div>
    <livewire:compta.ecriture-details :id="$id_ecriture" />
    @else
    <div class="flex flex-row-reverse mb-2">
        <button class="flex gap-2 items-center bg-blue-600 font-[is-m] px-2 text-white rounded-sm relative" wire:click="swap_ecriture_details">
            <div class="h-5 top-px relative">
                <img src="/assets/svg/show_white.svg" class="max-h-full max-w-full" alt="">
            </div>
            <div>details ecriture</div>
        </button>
    </div>
    @endif


    @if (session()->has('error'))
    <div class="py-2 text-xl text-red-500">
        {{ session('error') }}
    </div>
    @endif
    @if ($isEdit)
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">

            <div class="w-20 flex flex-col relative">
                <input
                    type="text" placeholder="journal"
                    class="w-full border-b-1 border-gray-400 @error('new_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="new_numero_compte" wire:input="searchCompte">
                @if (!empty($comptes_search))

                <div class="absolute flex flex-col min-w-full rounded-b-sm rounded-tr-sm mr-8 pb-3 pt-2  pl-px top-full left-0 z-10 font-[is-m] bg-slate-600 text-white">
                    @foreach ($comptes_search as $compte)
                    <button class="flex pl-1 pr-3 py-1 whitespace-nowrap hover:bg-black" wire:click="setNew_numero_compte('{{ $compte->numero_compte }}')">{{ $compte->numero_compte }} - {{$compte->intitule}}</button>
                    @endforeach
                </div>

                @endif
            </div>

            <div class="w-48 flex items-center justify-center gap-2">

                @php
                $classBtn = 'text-sm font-[is-m] border-b border-gray-400 py-1 text-neutral-800 px-4 rounded-sm transition-all';
                @endphp
                <button
                    @class([
                    $classBtn, 'bg-blue-800 text-white'=> $new_type === 'debit',
                    'border-b-4 border-red-500' => $errors->has('new_type')
                    ])
                    wire:click="setNew_type('debit')"
                    >
                    Débit
                </button>

                <button
                    @class([
                    $classBtn, 'bg-blue-800 text-white'=> $new_type === 'credit',
                    'border-b-4 border-red-500' => $errors->has('new_type')
                    ])
                    wire:click="setNew_type('credit')"
                    >
                    Crédit
                </button>

            </div>

            <div class="w-40 pr-8">
                <input
                    type="number" placeholder="montant"
                    class="w-full border-b-1 border-gray-400 @error('new_libelle_ligne') border-red-500 border-b-3 @enderror"
                    wire:model="new_value">
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text" placeholder="libelle"
                    class="w-full border-b-1 border-gray-400 @error('new_libelle_ligne') border-red-500 border-b-3 @enderror"
                    wire:model="new_libelle_ligne">
            </div>

            <div class="w-auto flex justify-center gap-1">
                <button class="h-8 text-white rounded-sm px-2" wire:click="swapEdit">
                    <img src="/assets/svg/close.svg" alt="">
                </button>
                <button class="h-8 bg-neutral-800 text-white rounded-sm px-2" wire:click="save">
                    <img src="/assets/svg/check.svg" alt="">
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="flex flex-row justify-between w-full h-auto gap-4 pl-4 pt-2 pb-4 relative">
        <div class="flex gap-4 flex-1 relative">
            <img src="/assets/svg/search.svg" height="24px" width="24px" alt="">
            <input type="text" class="w-full text-md" placeholder="recherche" wire:model="search_value" wire:input="doFilter">
        </div>
        <button type="button" wire:click="swapEdit" class="flex items-center gap-2 pl-4 pr-1 py-1 rounded-sm text-blue-800 hover:bg-blue-50 relative">
            <span>ajouter une ligne</span> <img src="/assets/svg/add.svg" alt="" class="relative top-[1px]">
        </button>
    </div>
    @endif

    <div class="px-4 flex w-full h-12 items-center transition-all font-[is-m] border-b-1 border-gray-300 text-neutral-400">
        <div class="w-20">compte</div>
        <div class="w-28">type</div>
        <div class="w-48 flex flex-row-reverse pr-12">montant</div>
        <div class="flex-1">libelle</div>
        <div class="w-auto flex justify-center"></div>
    </div>
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        @if (!empty($lignes_ecritures))

        @foreach ($lignes_ecritures as $key => $ligne_ecriture)

        @if ($updating && $ligne_ecriture['id'] === $num_update)

        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
            <div class="w-20 pr-8 flex flex-col relative">
                <input
                    type="text" placeholder="journal"
                    class="w-full border-b-1 border-gray-400 @error('update_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="update_numero_compte" wire:input="searchCompte">
                @if (!empty($comptes_search))

                <div class="absolute flex flex-col min-w-full rounded-b-sm rounded-tr-sm mr-8 pb-3 pt-2  pl-px top-full left-0 z-10 font-[is-m] bg-slate-600 text-white">
                    @foreach ($comptes_search as $compte)
                    <button class="flex pl-1 pr-3 py-1 whitespace-nowrap hover:bg-black" wire:click="setUpdate_numero_compte('{{ $compte->numero_compte }}')">{{ $compte->numero_compte }} - {{$compte->intitule}}</button>
                    @endforeach
                </div>

                @endif
            </div>

            <div class="w-48 flex items-center gap-2">

                @php
                $classBtn = 'text-sm font-[is-m] border-b border-gray-400 py-1 text-neutral-800 px-4 rounded-sm transition-all';
                @endphp
                <button
                    @class([
                    $classBtn, 'bg-blue-800 text-white'=> $update_type === 'debit',
                    'border-b-4 border-red-500' => $errors->has('update_type')
                    ])
                    wire:click="setUpdate_type('debit')"
                    >
                    Débit
                </button>

                <button
                    @class([
                    $classBtn, 'bg-blue-800 text-white'=> $update_type === 'credit',
                    'border-b-4 border-red-500' => $errors->has('update_type')
                    ])
                    wire:click="setUpdate_type('credit')"
                    >
                    Crédit
                </button>

            </div>

            <div class="w-40 pr-8">
                <input
                    type="number" placeholder="montant"
                    class="w-full border-b-1 border-gray-400 @error('update_libelle_ligne') border-red-500 border-b-3 @enderror"
                    wire:model="update_value">
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text" placeholder="libelle"
                    class="w-full border-b-1 border-gray-400 @error('update_libelle_ligne') border-red-500 border-b-3 @enderror"
                    wire:model="update_libelle_ligne">
            </div>

            <div class="w-auto flex justify-center gap-1">
                <button class="h-8 text-white rounded-sm px-1" wire:click="updateClose">
                    <img src="/assets/svg/close.svg" alt="">
                </button>
                <button class="h-8 bg-neutral-800 text-white rounded-sm px-1" wire:click="updateOne">
                    <img src="/assets/svg/check.svg" alt="">
                </button>
            </div>
        </div>

        @else

        <div wire:key="{{ $key }}" class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
            <div class="w-20">{{ $ligne_ecriture['numero_compte'] }}</div>
            <div class="w-28 flex gap-4">
                <div
                    @class([ 'py-px px-2 font-[is-m] rounded-sm w-16 text-center' , 
                    'bg-red-400 text-white'=> $ligne_ecriture['type'] === 'debit',
                    'bg-green-400 text-white'=> $ligne_ecriture['type'] === 'credit'
                    ])
                    >
                    {{ $ligne_ecriture['type']}}
                </div>
            </div>
            <div class="w-48 flex flex-row-reverse pr-12">
                    {{ $ligne_ecriture['value'] }} ar
            </div>
            <div class="flex-1">{{ $ligne_ecriture['libelle_ligne'] }}</div>
            <div class="w-auto flex justify-center gap-1">
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="delete({{ $ligne_ecriture['id'] }})" wire:confirm="Are you sure you want to delete this ligne?">
                    <img src="/assets/svg/delete.svg" alt="">
                </button>
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="edit({{ $ligne_ecriture['id'] }})">
                    <img src="/assets/svg/edit.svg" alt="">
                </button>
            </div>
        </div>

        @endif

        @endforeach
        @endif
    </div>
</div>