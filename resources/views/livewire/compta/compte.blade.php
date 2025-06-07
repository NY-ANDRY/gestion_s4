<div class="w-full flex flex-col">

    @if (session()->has('error'))
    <div class="py-2 text-xl text-red-500">
        {{ session('error') }}
    </div>
    @endif
    @if ($isEdit)
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
            <div class="w-24 pr-8">
                <input
                    type="number" placeholder="classe"
                    class="w-full border-b-1 border-gray-400 @error('new_classe') border-red-500 border-b-3 @enderror"
                    wire:model="new_classe">
            </div>

            <div class="w-32 pr-8">
                <input
                    type="number" placeholder="{{ $label_numero_compte }}"
                    class="w-full border-b-1 border-gray-400 @error('new_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="new_numero_compte">
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text" placeholder="intitule"
                    class="w-full border-b-1 border-gray-400 @error('new_intitule') border-red-500 border-b-3 @enderror"
                    wire:model="new_intitule">
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
        <div class="w-24">classe</div>
        <div class="w-32">{{ $label_numero_compte }}</div>
        <div class="flex-1">intitule</div>
        <div class="w-16 flex justify-center"></div>
    </div>
    <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
        @if (!empty($comptes))

        @foreach ($comptes as $key => $compte)

        @if ($updating && $compte->id === $num_update)

        <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
            <div class="w-24 pr-8">
                <input
                    type="number"
                    class="w-full border-b-1 border-gray-400 @error('update_classe') border-red-500 border-b-3 @enderror"
                    wire:model="update_classe">
            </div>

            <div class="w-32 pr-8">
                <input
                    type="number"
                    class="w-full border-b-1 border-gray-400 @error('update_numero_compte') border-red-500 border-b-3 @enderror"
                    wire:model="update_numero_compte">
            </div>

            <div class="flex-1 pr-8">
                <input
                    type="text"
                    class="w-full border-b-1 border-gray-400 @error('update_intitule') border-red-500 border-b-3 @enderror"
                    wire:model="update_intitule">
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
            <div class="w-24">{{ $compte->classe }}</div>
            <div class="w-32">{{ $compte->numero_compte }}</div>
            <div class="flex-1">{{ $compte->intitule }}</div>
            <div class="w-16 flex justify-center gap-1">
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="delete({{ $compte->id }})" wire:confirm="Are you sure you want to delete this ligne?">
                    <img src="/assets/svg/delete.svg" alt="">
                </button>
                <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="edit({{ $compte->id }})">
                    <img src="/assets/svg/edit.svg" alt="">
                </button>
            </div>
        </div>

        @endif

        @endforeach
        @endif
        
    </div>
</div>