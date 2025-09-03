<div>
    <!-- Modal Delete Confirmation -->
    <dialog x-on:open-dialog.window="$el.showModal()" x-on:close-dialog.window="$el.close()" x-on:click.self="$el.close()"
        x-on:keydown.escape="$el.close()" wire:ignore.self id="dialog"
        class="fixed inset-0 max-w-lg mx-auto mt-16 p-0 bg-transparent backdrop:bg-gray-500/75 open:animate-in open:fade-in open:duration-300">

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                data-slot="icon" aria-hidden="true" class="size-6 text-red-600">
                                <path
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="dialog-title" class="text-base font-semibold text-gray-900">Hapus Tasks
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah kamu yakin ingin menghapus task ini ?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" wire:click='delete({{ $userId }})'
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Hapus</button>
                    <button type="button" x-on:click="$el.closest('dialog').close()"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                </div>
            </div>
    </dialog>
    <!-- Modal Add Category -->
    <dialog x-on:open-dialog-add-category.window="$el.showModal()" x-on:close-dialog-add-category.window="$el.close();"
        x-on:click.self="$el.close()" x-on:keydown.escape="$el.close()" wire:ignore.self id="dialog-add-category"
        class="fixed inset-0 min-w-lg mx-auto mt-16 p-0 bg-transparent backdrop:bg-gray-500/75 open:animate-in open:fade-in open:duration-300">

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="text-center">
                        <span class="block mb-4 text-gray-700 font-big text-3xl">Tambah Kategori</span>
                        <input x-ref="categoryName" type="text" placeholder="Nama Kategori" maxlength="255"
                            class="block w-full mx-auto p-2 border border-gray-300 rounded-xl text-sm mb-6" />
                        <div class="flex justify-center gap-4">
                            <button type="button"
                                wire:click="addCategory($refs.categoryName.value);$refs.categoryName.value = null"
                                class="px-6 py-2 rounded-md bg-green-300 text-gray-900 font-semibold shadow hover:bg-green-400 transition">Simpan</button>
                            <button type="button" x-on:click="$el.closest('dialog').close()"
                                class="px-6 py-2 rounded-md bg-white border border-gray-300 text-gray-900 font-semibold shadow hover:bg-gray-100 transition">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
    </dialog>
    <!-- Modal Edit Tasks -->
    <dialog x-on:open-dialog-edit-task.window="console.log($event);$el.showModal()"
        x-on:close-dialog-edit-task.window="$el.close()" x-on:click.self="$el.close()" x-on:keydown.escape="$el.close()"
        wire:ignore.self id="dialog-edit-task"
        class="fixed inset-0 min-w-xl mx-auto mt-16 p-0 bg-transparent backdrop:bg-gray-500/75 open:animate-in open:fade-in open:duration-300">

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="text-center">
                        <span class="block mb-4 text-gray-700 font-big text-3xl">Detail Agenda</span>
                        <input wire:model="content" type="text" placeholder="Nama Kategori" maxlength="255"
                            class="block w-full mx-auto p-2 border border-gray-300 rounded-xl text-sm mb-6" />
                        <div class="items-center mb-2 gap-4">
                            <div>
                                <textarea wire:model="details" rows="5" placeholder="Tulis detail agenda disini!"
                                    class="p-2 border border-gray-300 rounded-xl w-full"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-center mb-2 gap-4 text-lg">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="priority" type="radio" value="1" class="w-4 h-4"> High
                                Priority
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="priority" type="radio" value="2" class="w-4 h-4"> Medium
                                Priority
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="priority" type="radio" value="3" class="w-4 h-4"> Low Priority
                            </label>
                        </div>
                        <div class="flex gap-2 mb-4">
                            <div class="w-1/2">
                                <span class="flex mb-1 text-gray-700 font-medium">Due Date</span>
                                <input wire:model="due_date" type="date" placeholder="Pilih Tanggal"
                                    class="p-2 border border-gray-300 rounded-xl w-full" />
                            </div>
                            <div class="w-1/2">
                                <span class="flex mb-1 text-gray-700 font-medium">Kategori</span>

                                <select wire:model="category" class="p-2 border border-gray-300 rounded-xl w-full">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-center items-center gap-4">
                            <button type="button" wire:click="editAll()"
                                class="px-6 py-2 rounded-md bg-green-300 text-gray-900 font-semibold shadow hover:bg-green-400 transition">Simpan</button>
                            <button type="button" x-on:click="$el.closest('dialog').close()"
                                class="px-6 py-2 rounded-md bg-white border border-gray-300 text-gray-900 font-semibold shadow hover:bg-gray-100 transition">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
    </dialog>
</div>
