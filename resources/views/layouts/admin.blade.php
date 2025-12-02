<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - TopUp Store')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-4 border-b border-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">
                    <i class="fas fa-tachometer-alt"></i> Admin Panel
                </a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-home w-6"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-th-large w-6"></i> Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-box w-6"></i> Produk
                </a>
                <a href="{{ route('admin.accounts.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.accounts.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-user-circle w-6"></i> Akun
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-shopping-bag w-6"></i> Pesanan
                </a>
                <a href="{{ route('admin.payments.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.payments.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-credit-card w-6"></i> Pembayaran
                </a>
                <hr class="my-2 border-gray-700">
                <a href="{{ route('admin.test-upload.index') }}" class="block px-4 py-3 hover:bg-gray-700 {{ request()->routeIs('admin.test-upload.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-bug w-6"></i> Test Upload
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-external-link-alt"></i> Lihat Website
                        </a>
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
