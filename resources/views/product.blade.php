@extends('layouts.app')

@section('title', $product->name . ' - TopUp Store')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-gray-600 mb-4">
        <a href="{{ route('home') }}" class="hover:text-purple-600">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('category', $product->category->slug) }}" class="hover:text-purple-600">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        <span>{{ $product->name }}</span>
    </nav>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Product Image -->
    <div>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
        @else
            <div class="w-full h-96 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-gem text-9xl text-white"></i>
            </div>
        @endif
    </div>

    <!-- Product Details -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        @if($product->type == 'account')
            <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded mb-3">
                <i class="fas fa-user"></i> Akun
            </span>
        @else
            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded mb-3">
                <i class="fas fa-gem"></i> Item
            </span>
        @endif

        <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

        <div class="mb-6">
            <span class="text-4xl font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        </div>

        @if($product->description)
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Deskripsi</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>
        @endif

        <div class="mb-6">
            <div class="flex items-center space-x-2">
                <i class="fas fa-box text-gray-600"></i>
                <span class="text-gray-600">Stok tersedia: <strong class="text-gray-900">{{ $product->stock }}</strong></span>
            </div>
        </div>

        @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition">
                    <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                </button>
            </form>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <i class="fas fa-exclamation-circle"></i> Stok habis
            </div>
        @endif

        <div class="mt-6 pt-6 border-t">
            <h3 class="font-semibold text-lg mb-3">Informasi</h3>
            <ul class="space-y-2 text-gray-600">
                <li><i class="fas fa-check-circle text-green-500"></i> Proses cepat & otomatis</li>
                <li><i class="fas fa-check-circle text-green-500"></i> Aman & terpercaya</li>
                <li><i class="fas fa-check-circle text-green-500"></i> Customer service 24/7</li>
            </ul>
        </div>
    </div>
</div>
@endsection
