@extends('layouts.admin')

@section('header', 'Detail Pesanan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Informasi Pesanan</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">No. Pesanan</p>
                    <p class="font-semibold">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal</p>
                    <p class="font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Customer</p>
                    <p class="font-semibold">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="font-semibold">{{ $order->customer_email }}</p>
                </div>
                <div>
                    <p class="text-gray-600">WhatsApp</p>
                    <p class="font-semibold">{{ $order->customer_phone }}</p>
                </div>
                @if($order->game_id)
                    <div>
                        <p class="text-gray-600">ID Game</p>
                        <p class="font-semibold">{{ $order->game_id }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Item Pesanan</h2>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
                <div class="flex justify-between items-center pt-3 font-bold text-lg">
                    <span>Total</span>
                    <span class="text-purple-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Update Status</h2>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Status Pesanan</label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-save"></i> Update Status
                </button>
            </form>
        </div>

        @if($order->payment)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Pembayaran</h2>
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode:</span>
                        <span class="font-semibold">{{ ucwords(str_replace('_', ' ', $order->payment->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($order->payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->payment->status == 'success') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                </div>
                @if($order->payment->payment_proof)
                    <div class="mb-4">
                        <p class="text-gray-600 text-sm mb-2">Bukti Pembayaran:</p>
                        <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-full rounded border">
                    </div>
                @endif
                <a href="{{ route('admin.payments.show', $order->payment->id) }}" class="block text-center bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                    <i class="fas fa-eye"></i> Lihat Detail Pembayaran
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
