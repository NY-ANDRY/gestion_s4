<div>
        <div class="pl-16 flex text-xl gap-8">

                <button wire:click="decrement">-</button>
                <div class="w-12 flex items-center justify-center">{{ $count }}</div>
                <button wire:click="increment">+</button>

        </div>
</div>