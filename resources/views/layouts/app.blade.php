<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Vegetable Store - Rau Củ Quả Tươi Ngon')</title>
    <meta name="description" content="@yield('description', 'Cửa hàng rau củ quả tươi ngon, chất lượng cao. Giao hàng tận nơi, giá cả hợp lý.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js Cloak CSS -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="min-h-full bg-gray-50 font-sans antialiased">
    <div class="min-h-full flex flex-col">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Main Content -->
        <main class="flex-1"></main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
