<div class="w-full flex flex-col">

    @if (session()->has('error'))
    <div class="py-2 text-xl text-red-500">
        {{ session('error') }}
    </div>
    @endif
    @if ($isEdit)
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">

            <div class="w-48 pr-8 flex gap-2">
                <div class="pl-1 text-sm flex items-end  text-neutral-400">exercice</div>
                <input
                    type="text" readonly placeholder="exercice"
                    class="w-full border-b-1 border-gray-400 text-neutral-600 @error('new_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="new_id_exercice">
            </div>

            <div class="w-32 mr-8 flex flex-col relative">
                <input
                    type="text" placeholder="journal"
                    class="w-full border-b-1 border-gray-400 @error('new_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="new_journal_code" wire:input="searchJournal">
                @if (!empty($journaux_search))

                <div class="absolute flex flex-col min-w-full rounded-b-sm rounded-tr-sm mr-8 pb-3 pt-2  pl-px top-full left-0 z-10 font-[is-m] bg-slate-600 text-white">
                    @foreach ($journaux_search as $journal)
                    <button class="flex pl-1 pr-3 py-1 whitespace-nowrap hover:bg-black" wire:click="setNew_journal_code('{{ $journal->code_journal }}')">{{ $journal->code_journal }} - {{$journal->libelle}}</button>
                    @endforeach
                </div>

                @endif
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text" placeholder="libelle"
                    class="w-full border-b-1 border-gray-400 @error('new_libelle_ecriture') border-red-500 border-b-3 @enderror"
                    wire:model="new_libelle_ecriture">
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
    <div class="flex flex-row justify-between w-full h-auto gap-4 px-4 pt-2 pb-4 relative">
        <div class="flex gap-4 flex-1 relative">
            <img src="/assets/svg/search.svg" height="24px" width="24px" alt="">
            <input type="text" class="w-full text-md" placeholder="recherche" wire:model="search_value" wire:input="doFilter">
        </div>
        <button type="button" wire:click="swapEdit" class="flex items-center gap-2 pl-4 pr-3 py-1 rounded-sm text-blue-800 hover:bg-blue-50 relative">
            <span>ajouter une ligne</span> <img src="/assets/svg/add.svg" alt="" class="relative top-[1px]">
        </button>
    </div>
    @endif

    <div class="px-4 flex w-full h-12 items-center transition-all font-[is-m] border-b-1 border-gray-300 text-neutral-400">
        <div class="w-36">date</div>
        <div class="w-24">journal</div>
        <div class="flex-1">libelle</div>
        <div class="w-auto flex justify-center"></div>
    </div>
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        @if (!empty($ecritures))

        @foreach ($ecritures as $key => $ecriture)

        @if ($updating && $ecriture['id'] === $num_update)

        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
            <div class="w-36 pr-8">
                <input
                    type="date"
                    class="w-full border-b-1 border-gray-400 @error('update_date_ecriture') border-red-500 border-b-3 @enderror"
                    wire:model="update_date_ecriture">
            </div>

            <div class="w-24 pr-8">
                <input
                    type="text"
                    class="w-full border-b-1 border-gray-400 @error('update_journal_code') border-red-500 border-b-3 @enderror"
                    wire:model="update_journal_code">
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text"
                    class="w-full border-b-1 border-gray-400 @error('update_libelle_ecriture') border-red-500 border-b-3 @enderror"
                    wire:model="update_libelle_ecriture">
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
            <div class="w-36">{{ $ecriture['date_ecriture'] }}</div>
            <div class="w-24">{{ $ecriture['journal_code'] }}</div>
            <div class="flex-1">{{ $ecriture['libelle_ecriture'] }}</div>
            <div class="w-auto flex justify-center gap-1">
                <a href="/compta/ecritures/{{ $ecriture['id'] }}" wire:navigate class="transition-all hover:bg-neutral-300 rounded-sm p-1 mr-px cursor-pointer">
                    <img src="/assets/svg/construction.svg" alt="">
                </a>
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="delete({{ $ecriture['id'] }})" wire:confirm="Are you sure you want to delete this ligne?">
                    <img src="/assets/svg/delete.svg" alt="">
                </button>
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="edit({{ $ecriture['id'] }})">
                    <img src="/assets/svg/edit.svg" alt="">
                </button>
            </div>
        </div>

        @endif

        @endforeach
        @endif
    </div>
</div>