@extends('layouts.app')

@section('title', 'Detail Order - TopUp Store')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-file-invoice"></i> Detail Order</h1>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
            <div>
                <h3 class="font-semibold mb-3">Informasi Pesanan</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">No. Pesanan:</span> <strong>{{ $order->order_number }}</strong></p>
                    <p><span class="text-gray-600">Tanggal:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p><span class="text-gray-600">Status:</span>
                        <span class="inline-block px-2 py-1 rounded text-xs
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'paid') bg-blue-100 text-blue-800
                            @elseif($order->status == 'processing') bg-purple-100 text-purple-800
                            @elseif($order->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><span class="text-gray-600">Pembayaran:</span>
                        <span class="inline-block px-2 py-1 rounded text-xs
                            @if($order->payment_status == 'unpaid') bg-red-100 text-red-800
                            @elseif($order->payment_status == 'paid') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Informasi Pembeli</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Nama:</span> {{ $order->customer_name }}</p>
                    <p><span class="text-gray-600">Email:</span> {{ $order->customer_email }}</p>
                    <p><span class="text-gray-600">WhatsApp:</span> {{ $order->customer_phone }}</p>
                    @if($order->game_id)
                        <p><span class="text-gray-600">ID Game:</span> {{ $order->game_id }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-4">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center border-b pb-3">
                        <div class="flex-1">
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>

                            @if($item->product->type == 'account' && isset($accounts[$item->product_id]))
                                <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded">
                                    <p class="text-sm font-semibold text-green-800 mb-2">
                                        <i class="fas fa-user-circle"></i> Detail Akun:
                                    </p>
                                    @foreach($accounts[$item->product_id] as $account)
                                        <div class="text-sm space-y-1 mb-2 last:mb-0">
                                            <p><strong>Username:</strong> {{ $account->username }}</p>
                                            <p><strong>Password:</strong> {{ $account->password }}</p>
                                            @if($account->details)
                                                <p><strong>Detail:</strong> {{ $account->details }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <p class="font-bold ml-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center mt-4 pt-4 border-t">
                <p class="text-xl font-bold">Total</p>
                <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($order->payment)
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold mb-3">Informasi Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Metode:</span> {{ ucwords(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                    <p><span class="text-gray-600">Status:</span>
                        <span class="inline-block px-2 py-1 rounded text-xs
                            @if($order->payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->payment->status == 'success') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </p>
                    @if($order->payment->paid_at)
                        <p><span class="text-gray-600">Tanggal Bayar:</span> {{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                    @endif
                    @if($order->payment->payment_proof)
                        <div class="mt-3">
                            <p class="text-gray-600 mb-2">Bukti Pembayaran:</p>
                            <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-xs rounded border">
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($order->status == 'pending' && $order->payment_status == 'unpaid')
        <div class="text-center">
            <a href="{{ route('payment', $order->order_number) }}" class="inline-block bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition">
                <i class="fas fa-credit-card"></i> Lanjutkan Pembayaran
            </a>
        </div>
    @endif
</div>
@endsection
