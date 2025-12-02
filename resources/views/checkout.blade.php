@extends('layouts.app')

@section('title', 'Checkout - TopUp Store')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-shopping-cart"></i> Checkout</h1>

    @if(empty($cart))
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 mb-4">Keranjang belanja Anda kosong</p>
            <a href="{{ route('home') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
                    <div class="space-y-4">
                        @foreach($products as $product)
                            <div class="flex items-center border-b pb-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-blue-500 rounded flex items-center justify-center">
                                        <i class="fas fa-gem text-2xl text-white"></i>
                                    </div>
                                @endif
                                <div class="ml-4 flex-1">
                                    <h3 class="font-semibold">{{ $product->name }}</h3>
                                    <p class="text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }} x {{ $cart[$product->id]['quantity'] }}</p>
                                    <p class="font-bold text-purple-600">Rp {{ number_format($product->price * $cart[$product->id]['quantity'], 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <h2 class="text-xl font-bold mb-4">Total Pembayaran</h2>
                    <div class="border-t pt-4">
                        <div class="text-3xl font-bold text-purple-600">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('order.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                    @csrf
                    <h2 class="text-xl font-bold mb-4">Informasi Pembeli</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                        <input type="text" name="customer_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="{{ old('customer_name', auth()->user()->name ?? '') }}">
                        @error('customer_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                        <input type="email" name="customer_email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                        @error('customer_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">No. WhatsApp *</label>
                        <input type="text" name="customer_phone" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx">
                        @error('customer_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">ID Game (opsional)</label>
                        <input type="text" name="game_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" value="{{ old('game_id') }}" placeholder="Masukkan ID/Username game Anda">
                        @error('game_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Metode Pembayaran *</label>
                        <select name="payment_method" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E-Wallet (OVO/GoPay/Dana)</option>
                            <option value="qris">QRIS</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition">
                        <i class="fas fa-check-circle"></i> Lanjutkan Pembayaran
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
