<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Page Title' }}</title>
        
    @vite('resources/css/app.css')

    </head>
    <body style="background-color: #f3f4f6;">
        {{ $slot }}
    @vite('resources/js/app.js')
    </body>
</html>
