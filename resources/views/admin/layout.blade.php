<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Vegetable Store</title>
    <meta name="description" content="@yield('description', 'Quản lý hệ thống Vegetable Store')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Admin Sidebar CSS -->
    <style>
        #admin-sidebar.collapsed { width: 64px; }
        #admin-sidebar:not(.collapsed) { width: 256px; }
        #admin-sidebar .menu-text { display: inline; }
        #admin-sidebar.collapsed .menu-text { display: none; }
        #admin-sidebar .menu-icon { width: 20px; text-align: center; }
    </style>
</head>
<body class="h-full bg-gray-50 font-sans antialiased overflow-hidden">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
        <div class="h-16 flex items-center justify-between px-4">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="inline-flex items-center justify-center w-9 h-9 rounded-md hover:bg-gray-100">
                    <i class="fas fa-bars text-gray-700"></i>
                </button>
                <div class="w-9 h-9 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <div class="leading-tight">
                    <div class="text-gray-900 font-bold">Admin Panel</div>
                    <div class="text-[11px] text-gray-500">Vegetable Store</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="inline-flex items-center h-9 px-3 text-sm text-gray-600 hover:text-gray-900 rounded-md hover:bg-gray-50 transition-colors"><i class="fas fa-home mr-2"></i>Trang chủ</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="inline-flex items-center h-9 px-3 text-sm bg-gray-100 hover:bg-gray-200 rounded-md"><i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất</button>
                </form>
            </div>
        </div>
    </header>

    <div class="flex h-[calc(100vh-64px)]">
        <!-- Sidebar -->
        <aside id="admin-sidebar" class="bg-white border-r border-gray-200 h-full transition-all duration-200 ease-in-out overflow-y-auto">
            <nav class="py-2">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2.5 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-700 border-green-600' : 'text-gray-700 hover:bg-gray-50 border-transparent' }}">
                    <i class="menu-icon fas fa-chart-pie mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    <span class="menu-text text-sm">Tổng quan</span>
                </a>
                <a href="{{ route('admin.products') }}" class="group flex items-center px-4 py-2.5 border-l-4 {{ request()->routeIs('admin.products') ? 'bg-green-50 text-green-700 border-green-600' : 'text-gray-700 hover:bg-gray-50 border-transparent' }}">
                    <i class="menu-icon fas fa-box mr-3 {{ request()->routeIs('admin.products') ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    <span class="menu-text text-sm">Quản lý sản phẩm</span>
                </a>
                <a href="{{ route('admin.categories') }}" class="group flex items-center px-4 py-2.5 border-l-4 {{ request()->routeIs('admin.categories') ? 'bg-green-50 text-green-700 border-green-600' : 'text-gray-700 hover:bg-gray-50 border-transparent' }}">
                    <i class="menu-icon fas fa-tags mr-3 {{ request()->routeIs('admin.categories') ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    <span class="menu-text text-sm">Quản lý danh mục</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="group flex items-center px-4 py-2.5 border-l-4 {{ request()->routeIs('admin.orders') ? 'bg-green-50 text-green-700 border-green-600' : 'text-gray-700 hover:bg-gray-50 border-transparent' }}">
                    <i class="menu-icon fas fa-shopping-bag mr-3 {{ request()->routeIs('admin.orders') ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    <span class="menu-text text-sm">Quản lý đơn hàng</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="group flex items-center px-4 py-2.5 border-l-4 {{ request()->routeIs('admin.customers.*') ? 'bg-green-50 text-green-700 border-green-600' : 'text-gray-700 hover:bg-gray-50 border-transparent' }}">
                    <i class="menu-icon fas fa-users mr-3 {{ request()->routeIs('admin.customers.*') ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                    <span class="menu-text text-sm">Quản lý khách hàng</span>
                </a>
            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 h-full overflow-y-auto p-3">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @stack('scripts')

    <script>
        function toggleSidebar(){
            const sb = document.getElementById('admin-sidebar');
            sb.classList.toggle('collapsed');
        }
    </script>
</body>
</html>
