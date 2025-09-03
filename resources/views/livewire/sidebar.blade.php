<div
    class="flex h-screen w-full flex-col rounded-xl bg-white bg-clip-border p-4 text-gray-700 shadow-xl shadow-blue-gray-900/5">
    <nav x-data="{ filter: @entangle('filter'), category_id: @entangle('category_id') }"
        class="flex w-full flex-col gap-1 p-2 font-sans text-base font-normal text-blue-gray-700">
        <div role="button" wire:click="$dispatch('filter-tasks', {filter: 'today'})"
            :class="filter === 'today' ? 'bg-gray-300' : ''"
            class="flex items-center cursor-pointer w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-gray-100 active:bg-gray-200">
            <div class="grid mr-4 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>
            </div>
            Hari Ini
            <span class="ml-auto text-gray-500">{{ $tasks_info->today ?? 0 }}</span>
        </div>
        <div role="button" wire:click="$dispatch('filter-tasks', {filter: '7days'})"
            :class="filter === '7days' ? 'bg-gray-300' : ''"
            class="flex items-center cursor-pointer w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-gray-100 active:bg-gray-200">
            <div class="grid mr-4 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                </svg>
            </div>
            7 hari kedepan
            <span class="ml-auto text-gray-500">{{ $tasks_info->seven_days ?? 0 }}</span>
        </div>
        <hr class="my-2 border-blue-gray-50" />
        <h6 class="text-sm font-semibold text-blue-gray-600">Kategori</h6>
        @foreach ($this->categories as $category)
            <div role="button"
                wire:click="$dispatch('filter-tasks', {filter: 'category', category_id: {{ $category->id }}})"
                :class="filter === 'category' && category_id === {{ $category->id }} ? 'bg-gray-300' : ''"
                class="flex items-center cursor-pointer w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-gray-100 active:bg-gray-200">
                <div class="grid mr-4 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                {{ $category->name ?? 'Tidak Berkategori' }}
                <span class="ml-auto text-gray-500">{{ $category->tasks_count ?? 0 }}</span>
            </div>
        @endforeach
        <hr class="my-2 border-blue-gray-50" />
        <div role="button" wire:click="$dispatch('filter-tasks', {filter: 'completed'})"
            :class="filter === 'completed' ? 'bg-gray-300' : ''"
            class="flex items-center cursor-pointer w-full p-3 leading-tight transition-all rounded-lg outline-none text-start hover:bg-gray-100 active:bg-gray-200">
            <div class="grid mr-4 place-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            Selesai
            <span class="ml-auto text-gray-500">{{ $tasks_info->completed ?? 0 }}</span>
        </div>
    </nav>
</div>
