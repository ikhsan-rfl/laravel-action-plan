<div class="max-w-4xl mx-auto py-10 px-4">
    <x-slot name="title">Action Plan</x-slot>
    <div class="text-center mb-8">
        <h1 class="text-4xl">My Action Plan</h1>
        <p>Keep yourself organized and be productive</p>
    </div>


    <!-- Create a input with a placeholder and button in right -->
    <div class="items-center mb-2 text-center">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input wire:model="content" type="text" placeholder="Tulis agendamu disini!" maxlength="255"
            class="p-2 border border-gray-300 rounded-xl w-1/2" />
        <button wire:click="add" wire:target="add" wire:loading.attr="disabled"
            :disabled="!$wire.content || !$wire.priority"
            class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 disabled:opacity-40 disabled:cursor-not-allowed">
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


    <div id="accordion-collapse" x-data="{ open: false }" x-on:close-dialog-add-category.window="$wire.$refresh()">
        <div class="text-center">
            <button type="button" x-on:click="open = !open"
                class="flex items-center justify-between font-medium rtl:text-right text-gray-500 gap-3">
                <span>Details</span>
                <svg data-accordion-icon class="w-3 h-3 shrink-0 transition-transform" :class="{ 'rotate-180': !open }"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </div>
        <div id="accordion-collapse-body-1" x-show="open" x-transition>
            <div class="flex items-center mb-2 gap-4">
                <div class="w-1/2">
                    <span class="block mb-1 text-gray-700 font-medium">Due Date</span>
                    <input wire:model="due_date" type="date" placeholder="Pilih Tanggal"
                        class="p-2 border border-gray-300 rounded-xl w-full" />
                </div>
                <div class="w-1/2">
                    <div class="flex items-center gap-1">
                        <span class="block mb-1 text-gray-700 font-medium">Kategori</span>
                        <div x-on:click="$dispatch('open-dialog-add-category')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>

                    <select wire:model="category" class="p-2 border border-gray-300 rounded-xl w-full">
                        <option value="0">Pilih Kategori</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="items-center mb-2 gap-4">
                <div>
                    <textarea wire:model="details" rows="5" placeholder="Tulis detail agenda disini!"
                        class="p-2 border border-gray-300 rounded-xl w-full"></textarea>
                </div>
            </div>
        </div>
    </div>



    @if ($this->tasks()->isEmpty())
        <p class="flex justify-center mt-10 text-gray-500 italic">
            Belum ada agenda, silakan tambah terlebih dahulu..
        </p>
    @endif

    <div class="space-y-4 mt-6" x-on:filter-tasks.window="$wire.$refresh()">
        @foreach ($this->tasks() as $task)
            <div x-data="{
                editing: false,
                text: @js($task->content),
                focusEnd(el) {
                    el.focus();
                    el.setSelectionRange(el.value.length, el.value.length)
                }
            }" wire:key="task-{{ $task->id }}-{{ md5($task->content) }}"
                wire:click="promptEditAll({{ $task->id }})" x-on:close-dialog-edit-task.window="$wire.$refresh()"
                x-on:close-dialog.window="$wire.$refresh()"
                class="rounded-2xl p-4 shadow-sm bg-white
                hover:bg-gray-100 transition">
                <!-- Badge -->
                <div class="flex items-center justify-between">
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium rounded-lg ring-1 {{ $task->badgeColor }}">
                        {{ $task->priority }}
                    </span>
                    <div>
                        <button type="button" class="p-2 text-gray-500 hover:text-gray-700 z-50"
                            x-on:click="editing = true; $nextTick(() => focusEnd($refs.input))" x-on:click.stop>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                        <button type="button" class="p-2 text-gray-500 hover:text-gray-700 z-50"
                            wire:click.stop="promptDelete('{{ $task->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Date & Category -->
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-3 mt-2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        {{ $task->due_date }}
                    </div>
                    <div class="flex items-center p-3 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6 inline-block align-middle">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>{{ $task->category->name ?? 'Tidak Berkategori' }}</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex items-center gap-3 mt-3">
                    <input x-on:click.stop x-on:change="setTimeout(() => $wire.complete({{ $task->id }}), 500)"
                        type="checkbox"
                        class="peer w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span x-show="!editing"
                        class="transition duration-500 peer-checked:line-through peer-checked:text-gray-400"
                        x-on:click="editing = true; $nextTick(() => $refs.input.focus())" x-text="text"></span>

                    <input x-show="editing" x-ref="input" x-cloak x-model="text" type="text"
                        class="w-full rounded border-gray-300 focus:ring-blue-500"
                        x-on:keydown.enter="$wire.edit({{ $task->id }}, text).then(() => { editing=false })"
                        x-on:blur="text='{{ $task->content }}'; editing=false"
                        x-on:keydown.escape="text='{{ $task->content }}'; editing=false">
                </div>
            </div>
        @endforeach
    </div>

    @if ($this->tasks()->hasMorePages())
        <div class="flex justify-center mt-5">
            <button type="button" x-on:click="open = !open" wire:click="loadMore" wire:target="loadMore"
                wire:loading.attr="disabled"
                class="flex items-center text-2xl justify-between font-medium rtl:text-right text-gray-500 gap-3 disabled:opacity-40 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="loadMore">Tampilkan Lagi</span>
                <span wire:loading wire:target="loadMore">
                    Loading...
                </span>
                <svg wire:loading.remove wire:target="loadMore"
                    class="w-3 h-3 shrink-0 transition-transform rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </div>
    @endif

    <livewire:action-plan-modal />

</div>
