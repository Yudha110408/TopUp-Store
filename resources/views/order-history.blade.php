@extends('layouts.app')

@section('title', 'Riwayat Order - TopUp Store')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-history"></i> Riwayat Order</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @forelse($orders as $order)
            <div class="border-b last:border-b-0 p-6 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $order->order_number }}</h3>
                        <p class="text-gray-600 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 rounded text-sm
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'paid') bg-blue-100 text-blue-800
                            @elseif($order->status == 'processing') bg-purple-100 text-purple-800
                            @elseif($order->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-600 mb-2">Item:</p>
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center text-sm mb-1">
                            <span>{{ $item->product_name }} ({{ $item->quantity }}x)</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center pt-4 border-t">
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span class="font-bold text-xl text-purple-600 ml-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('order.detail', $order->order_number) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
                <p class="text-gray-600">Belum ada riwayat order</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                    Mulai Belanja
                </a>
            </div>
        @endforelse
    </div>

    @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
