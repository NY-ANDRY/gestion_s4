<div>
    <div class="w-[520px] pl-2">
        <div class="flex h-14 font-[is-m] border-b-1 border-gray-300 text-neutral-400">
            <div class="flex items-center w-2/3">range</div>
            <div class="flex items-center w-1/3">rate</div>
            <div class="flex items-center w-20">action</div>
        </div>
        @foreach ($irsa_dettes as $key => $irsa_dette)
        <div class="flex">
            <div class="flex items-center w-2/3 h-10">
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
            <div class="flex items-center w-1/3 h-10">{{ $irsa_dette["rate"] }} %</div>
            <div class="flex items-center w-20 text-red-500"><button wire:click="delete({{ $irsa_dette["id"] }})">delete</button></div>
        </div>
        @endforeach

        <form wire:submit="save" class="flex flex-col h-14 border-t-1 pt-1 mt-1 border-gray-300">
            <div class="flex pt-2">
                <div class="flex items-center gap-4">
                    <label for="">max</label>
                    <input type="number" wire:model="newRange" class="w-32 text-center border-b-1 border-gray-400 rounded-sm focus:outline-none focus:ring-2 focus:border-none" />
                    <div>@error('title') {{ $message }} @enderror</div>
                </div>

                <div class="flex items-center gap-4">
                    <label for="">rate</label>
                    <input type="number" wire:model="newRate" class="w-16 text-center border-b-1 border-gray-400 rounded-sm focus:outline-none focus:ring-2 focus:border-none" /> %
                    <div>@error('content') {{ $message }} @enderror</div>
                </div>

                <div class="flex items-center">
                    <button type="submit" class="h-8 bg-blue-600 text-white rounded-sm px-4">Save</button>
                </div>
            </div>
            @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
        </form>

        <form wire:submit="updateMin" class="flex flex-col h-14 border-t-1 pt-1 mt-1 border-gray-300">
            <div class="pt-4 font-[is-m] text-neutral-500 text-md">Minimum : <span class="pl-2">{{ $irsa_min["value"] }}</span> </div>
            <div class="flex pt-2">
                <div class="flex items-center gap-4">
                    <label for="">min</label>
                    <input type="number" wire:model="newMin" class="w-32 text-center border-b-1 border-gray-400 rounded-sm focus:outline-none focus:ring-2 focus:border-none" />
                    <div>@error('title') {{ $message }} @enderror</div>
                </div>
                <div class="flex items-center">
                    <button type="submit" class="h-8 bg-blue-600 text-white rounded-sm px-4">Save</button>
                </div>
            </div>
            @if (session()->has('errorMin'))
            <div class="alert alert-danger">
                {{ session('errorMin') }}
            </div>
            @endif
        </form>
    </div>
</div>