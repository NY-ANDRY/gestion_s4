<div class="flex-1 flex items-center">
    <div class="w-[50%] flex flex-col">

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
                        type="text" placeholder="code journal"
                        class="w-full border-b-1 border-gray-400 @error('new_code_journal') border-red-500 border-b-3 @enderror"
                        wire:model="new_code_journal">
                </div>

                <div class="flex-1 pr-8">
                    <input
                        type="text" placeholder="libelle"
                        class="w-full border-b-1 border-gray-400 @error('new_libelle') border-red-500 border-b-3 @enderror"
                        wire:model="new_libelle">
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
            <div class="relative max-h-full">
                <button type="button" wire:click="swapEdit" class="flex items-center gap-2 pl-4 pr-3 py-1 rounded-sm text-blue-800 hover:bg-blue-50">
                    <span>ajouter une ligne</span> <img src="/assets/svg/add.svg" alt="" class="relative top-[1px]">
                </button>
            </div>
        </div>
        @endif

        <div class="px-4 flex w-full h-12 items-center transition-all font-[is-m] border-b-1 border-gray-300 text-neutral-400">
            <div class="w-32">code journal</div>
            <div class="flex-1">libelle</div>
            <div class="w-16 flex justify-center"></div>
        </div>
        <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
            @if (!empty($journaux))

            @foreach ($journaux as $key => $journal)

            @if ($updating && $journal->id === $num_update)

            <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
                <div class="w-32 pr-8">
                    <input
                        type="text"
                        class="w-full border-b-1 border-gray-400 @error('update_code_journal') border-red-500 border-b-3 @enderror"
                        wire:model="update_code_journal">
                </div>

                <div class="flex-1 pr-8">
                    <input
                        type="text"
                        class="w-full border-b-1 border-gray-400 @error('update_libelle') border-red-500 border-b-3 @enderror"
                        wire:model="update_libelle">
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
                <div class="w-32">{{ $journal->code_journal }}</div>
                <div class="flex-1">{{ $journal->libelle }}</div>
                <div class="w-16 flex justify-center gap-1">
                    <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="delete({{ $journal->id }})" wire:confirm="Are you sure you want to delete this ligne?">
                        <img src="/assets/svg/delete.svg" alt="">
                    </button>
                    <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="edit({{ $journal->id }})">
                        <img src="/assets/svg/edit.svg" alt="">
                    </button>
                </div>
            </div>

            @endif

            @endforeach
            @endif
        </div>
    </div>
    <div class="flex flex-col"></div>
</div>