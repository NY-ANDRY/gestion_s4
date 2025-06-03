<div class="flex-1 flex flex-col justify-center items-center">
    <div class="w-[90%] flex flex-col">
        <div class="px-4 flex w-full h-12 items-center transition-all font-[is-m] border-b-1 border-gray-300 text-neutral-400">
            <div class="w-24">classe</div>
            <div class="w-32">code</div>
            <div class="flex-1">intitule</div>
            <div class="w-16 flex justify-center">action</div>
        </div>
        <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
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

                <div class="w-16 flex justify-center gap-1">
                    <button class="h-8 bg-blue-600 text-white rounded-sm px-4" wire:click="updateOne">
                        update
                    </button>
                </div>
            </div>

            @else

            <div wire:key="{{ $key }}" class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
                <div class="w-24">{{ $compte->classe }}</div>
                <div class="w-32">{{ $compte->numero_compte }}</div>
                <div class="flex-1">{{ $compte->intitule }}</div>
                <div class="w-16 flex justify-center gap-1">
                    <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="delete({{ $compte->id }})">
                        <img src="/assets/svg/delete.svg" alt="">
                    </button>
                    <button class="transition-all hover:bg-neutral-300 rounded-sm p-1" wire:click="edit({{ $compte->id }})">
                        <img src="/assets/svg/edit.svg" alt="">
                    </button>
                </div>
            </div>

            @endif

            @endforeach
        </div>
        <div class="flex flex-col w-full h-auto gap-0 pt-2 pb-4">
            <div class="px-4 h-12 flex items-center w-full transition-all rounded-sm hover:bg-neutral-100">
                <div class="w-24 pr-8">
                    <input
                        type="number"
                        class="w-full border-b-1 border-gray-400 @error('new_classe') border-red-500 border-b-3 @enderror"
                        wire:model="new_classe">
                </div>

                <div class="w-32 pr-8">
                    <input
                        type="number"
                        class="w-full border-b-1 border-gray-400 @error('new_numero_compte') border-red-500 border-b-3 @enderror"
                        wire:model="new_numero_compte">
                </div>

                <div class="flex-1 pr-8">
                    <input
                        type="text"
                        class="w-full border-b-1 border-gray-400 @error('new_intitule') border-red-500 border-b-3 @enderror"
                        wire:model="new_intitule">
                </div>

                <div class="w-16 flex justify-center gap-1">
                    <button class="h-8 bg-blue-600 text-white rounded-sm px-4" wire:click="save">
                        save
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('error'))
    <div class="py-2 text-xl text-red-500">
        {{ session('error') }}
    </div>
    @endif
</div>