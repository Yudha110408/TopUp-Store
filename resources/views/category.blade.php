@extends('layouts.app')

@section('title', $category->name . ' - TopUp Store')

@section('content')
<div class="mb-6">
    <nav class="text-sm text-gray-600 mb-4">
        <a href="{{ route('home') }}" class="hover:text-purple-600">Home</a>
        <span class="mx-2">/</span>
        <span>{{ $category->name }}</span>
    </nav>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-gray-600">{{ $category->description }}</p>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($products as $product)
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                    <i class="fas fa-gem text-6xl text-white"></i>
                </div>
            @endif
            <div class="p-4">
                @if($product->type == 'account')
                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mb-2">
                        <i class="fas fa-user"></i> Akun
                    </span>
                @else
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mb-2">
                        <i class="fas fa-gem"></i> Item
                    </span>
                @endif
                <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                @if($product->description)
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                @endif
                <div class="flex justify-between items-center mb-3">
                    <span class="text-2xl font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-sm text-gray-600">
                        <i class="fas fa-box"></i> {{ $product->stock }}
                    </span>
                </div>
                <a href="{{ route('product', [$category->slug, $product->slug]) }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center py-2 rounded-lg hover:from-purple-700 hover:to-blue-700 transition">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600">Belum ada produk tersedia</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection
