@extends('layouts.app')

@section('title', 'Home - TopUp Store')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg shadow-lg p-8 mb-8">
    <h1 class="text-4xl font-bold mb-4"><i class="fas fa-star"></i> Selamat Datang di TopUp Store</h1>
    <p class="text-xl">Top up game favoritmu dengan mudah, cepat, dan terpercaya!</p>
</div>

<!-- Categories Section -->
<div class="mb-12">
    <h2 class="text-3xl font-bold mb-6"><i class="fas fa-th-large"></i> Kategori Game</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('category', $category->slug) }}" class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden group">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center">
                        <i class="fas fa-gamepad text-6xl text-white"></i>
                    </div>
                @endif
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-1">{{ $category->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ $category->products_count }} produk</p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
                <p class="text-gray-600">Belum ada kategori tersedia</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<div class="mb-12">
    <h2 class="text-3xl font-bold mb-6"><i class="fas fa-fire"></i> Produk Populer</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-gem text-6xl text-white"></i>
                    </div>
                @endif
                <div class="p-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-2">
                        {{ $product->category->name }}
                    </span>
                    <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-600">
                            <i class="fas fa-box"></i> Stok: {{ $product->stock }}
                        </span>
                    </div>
                    <a href="{{ route('product', [$product->category->slug, $product->slug]) }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center py-2 rounded-lg hover:from-purple-700 hover:to-blue-700 transition">
                        <i class="fas fa-shopping-cart"></i> Beli Sekarang
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Features -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <i class="fas fa-bolt text-5xl text-yellow-500 mb-4"></i>
        <h3 class="font-bold text-xl mb-2">Proses Cepat</h3>
        <p class="text-gray-600">Transaksi diproses dalam hitungan menit</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <i class="fas fa-shield-alt text-5xl text-green-500 mb-4"></i>
        <h3 class="font-bold text-xl mb-2">Aman & Terpercaya</h3>
        <p class="text-gray-600">Keamanan data dan transaksi terjamin</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <i class="fas fa-tags text-5xl text-red-500 mb-4"></i>
        <h3 class="font-bold text-xl mb-2">Harga Terjangkau</h3>
        <p class="text-gray-600">Harga kompetitif dan terjangkau</p>
    </div>
</div>
@endsection
