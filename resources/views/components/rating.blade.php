<div class="w-full" x-data="{ rating: {{ $rating }} }">
    @if ($editable)
        <input name="rating" type="hidden" x-bind:value="rating" />
    @endif
    <div class="flex justify-around">
        <template x-for="i in 10">
            <div x-bind:class="rating > i ? 'text-yellow-400' : ''" @if ($editable)
                x-on:click="rating = i + 1"
                @endif>
                <flux:icon.star variant="solid" />
            </div>
        </template>
    </div>
</div>
