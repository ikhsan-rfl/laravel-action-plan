<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')

</head>

<body style="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed w-80 flex-shrink-0">
            <livewire:sidebar />
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
