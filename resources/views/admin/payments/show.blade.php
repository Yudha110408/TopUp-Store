@extends('layouts.admin')

@section('header', 'Detail Pembayaran')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
            <div>
                <h3 class="font-semibold mb-3">Informasi Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Pembayaran:</span>
                        <span class="font-semibold">#{{ $payment->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Pesanan:</span>
                        <span class="font-semibold">{{ $payment->order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode:</span>
                        <span class="font-semibold">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-bold text-lg text-purple-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($payment->status == 'success') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    @if($payment->paid_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Bayar:</span>
                            <span class="font-semibold">{{ $payment->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="font-semibold mb-3">Informasi Customer</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold">{{ $payment->order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $payment->order->customer_email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">WhatsApp:</span>
                        <span class="font-semibold">{{ $payment->order->customer_phone }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($payment->payment_proof)
            <div class="mb-6">
                <h3 class="font-semibold mb-3">Bukti Pembayaran</h3>
                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" class="max-w-md rounded border">
            </div>
        @endif

        @if($payment->status == 'pending')
            <div class="flex space-x-4">
                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui pembayaran ini?')">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        <i class="fas fa-check"></i> Setujui Pembayaran
                    </button>
                </form>

                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-times"></i> Tolak Pembayaran
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">Detail Pesanan</h3>
        <div class="space-y-3">
            @foreach($payment->order->items as $item)
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
