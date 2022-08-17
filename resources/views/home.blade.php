<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="m-8">
            <a href="{{ route('purge') }}"
                    class="text-sm px-4 py-2 bg-red-700 text-white shadow rounded mt-4"
                    onclick="event.preventDefault();
                        document.getElementById('purge-form').submit();">Purge Everything</a>
            <form id="purge-form" action="{{ route('purge') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
        <image-layout></image-layout>
    </div>
</body>
</html>
