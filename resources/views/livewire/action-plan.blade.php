<div class="max-w-4xl mx-auto py-10 px-4">
    <x-slot name="title">Action Plan</x-slot>
    <div class="text-center mb-8">
        <h1 class="text-4xl">My Action Plan</h1>
        <p>Keep yourself organized and be productive</p>
    </div>

    
    <!-- Create a input with a placeholder and button in right -->
    <div class="items-center mb-2 text-center">
        <input wire:model="content" type="text" placeholder="Tulis agendamu disini!" maxlength="255" class="p-2 border border-gray-300 rounded-xl w-1/2" />
        <button wire:click="add" wire:target="add" wire:loading.attr="disabled" :disabled="!$wire.content || !$wire.priority" class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 disabled:opacity-40 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="add">Tambah</span>
            <span wire:loading wire:target="add">Loading...</span>
        </button>
    </div>
    <!-- Create priority radio (high medium low) -->
    <div class="flex justify-center mb-2 gap-4 text-lg">
        <label class="flex items-center gap-2 cursor-pointer">
            <input wire:model="priority" type="radio" value="1" class="w-4 h-4"> High Priority
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input wire:model="priority" type="radio" value="2" class="w-4 h-4"> Medium Priority
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input wire:model="priority" type="radio" value="3" class="w-4 h-4"> Low Priority
        </label>
    </div>

    @if($this->tasks->isEmpty())
        <p class="flex justify-center mt-10 text-gray-500 italic">
            Belum ada agenda, silakan tambah terlebih dahulu..
        </p>
    @endif

    <div class="space-y-4 mt-10">
        @foreach($this->tasks as $task)
        <div x-data="{ editing:false, text: @js($task->content), focusEnd(el){ el.focus(); el.setSelectionRange(el.value.length, el.value.length) } }" wire:key="task-{{ $task->id }}-{{ md5($task->content) }}" class="rounded-2xl p-4 shadow-sm bg-white">
            <!-- Header row (badge inside the card) -->
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium rounded-lg ring-1 {{ $task->badgeColor }}">
                    {{ $task->priority }}
                </span>
                <div>
                    <button type="button"
                        class="p-2 text-gray-500 hover:text-gray-700"
                        x-on:click="editing = true; $nextTick(() => focusEnd($refs.input))"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>
                    <button type="button"
                        class="p-2 text-gray-500 hover:text-gray-700"
                        x-on:click="if(confirm('Are you sure you want to delete this task?')) { $wire.delete({{ $task->id }}) }"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex items-center gap-3 mt-3">
                <input
                    type="checkbox"
                    class="peer w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    x-on:change="setTimeout(() => $wire.complete({{ $task->id }}), 500)"
                >
                <span x-show="!editing"
                    class="transition duration-500 peer-checked:line-through peer-checked:text-gray-400"
                    x-on:click="editing = true; $nextTick(() => $refs.input.focus())"
                    x-text="text"
                ></span>

                <input x-show="editing" x-ref="input"
                    x-cloak
                    x-model="text"
                    type="text"
                    class="w-full rounded border-gray-300 focus:ring-blue-500"
                    x-on:keydown.enter="$wire.edit({{ $task->id }}, text).then(() => { editing=false })"
                    x-on:blur="text='{{ $task->content }}'; editing=false"
                    x-on:keydown.escape="text='{{ $task->content }}'; editing=false"
                >
            </div>
        </div>
        @endforeach
    </div>

</div>