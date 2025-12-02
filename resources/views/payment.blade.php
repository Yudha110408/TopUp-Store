@extends('layouts.app')

@section('title', 'Pembayaran - TopUp Store')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-credit-card"></i> Pembayaran</h1>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="border-b pb-4 mb-4">
            <h2 class="text-xl font-bold mb-2">Detail Pesanan</h2>
            <p class="text-gray-600">No. Pesanan: <strong>{{ $order->order_number }}</strong></p>
            <p class="text-gray-600">Status:
                <span class="inline-block px-3 py-1 rounded text-sm
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'paid') bg-blue-100 text-blue-800
                    @elseif($order->status == 'processing') bg-purple-100 text-purple-800
                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-3">Item Pesanan</h3>
            @foreach($order->items as $item)
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
            <div class="border-t pt-3 mt-3">
                <div class="flex justify-between items-center">
                    <p class="text-xl font-bold">Total</p>
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold mb-3"><i class="fas fa-info-circle"></i> Instruksi Pembayaran</h3>

            @if($order->payment_method == 'bank_transfer')
                <div class="space-y-2">
                    <p class="font-semibold">Transfer Bank</p>
                    <p>Bank BCA</p>
                    <p>No. Rekening: <strong>1234567890</strong></p>
                    <p>A/N: TopUp Store</p>
                </div>
            @elseif($order->payment_method == 'e_wallet')
                <div class="space-y-2">
                    <p class="font-semibold">E-Wallet</p>
                    <p>OVO/GoPay/Dana: <strong>081234567890</strong></p>
                    <p>A/N: TopUp Store</p>
                </div>
            @elseif($order->payment_method == 'qris')
                <div class="space-y-2">
                    <p class="font-semibold">QRIS - Scan untuk Bayar</p>
                    <div class="bg-white p-6 rounded-lg text-center shadow-inner">
                        <div id="qris-container" class="mx-auto">
                            <img id="qris-code" src="" alt="QRIS Code" class="w-64 h-64 mx-auto border-4 border-purple-500 rounded-lg">
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Kode akan diperbarui dalam: <span id="countdown" class="font-bold text-purple-600">60</span> detik</p>
                            <p class="text-xs text-gray-500 mt-2">No. Rekening: <strong>4940220195</strong></p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4 pt-4 border-t border-blue-300">
                <p class="text-sm text-gray-700">Jumlah yang harus dibayar:</p>
                <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($order->payment && $order->payment->status == 'pending' && $order->payment->payment_proof)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <i class="fas fa-check-circle text-green-600"></i> Bukti pembayaran telah diupload. Menunggu verifikasi admin.
            </div>
        @endif

        @if(!$order->payment || !$order->payment->payment_proof)
            <form action="{{ route('payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                    </label>
                    <input type="file" name="payment_proof" accept="image/*" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <p class="text-sm text-gray-600 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    @error('payment_proof')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition">
                    <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                </button>
            </form>
        @endif
    </div>

    <div class="text-center">
        <a href="{{ route('order.detail', $order->order_number) }}" class="text-purple-600 hover:text-purple-800">
            <i class="fas fa-eye"></i> Lihat Detail Pesanan
        </a>
    </div>
</div>

@push('scripts')
@if($order->payment_method == 'qris')
<script>
    let countdown = 60;
    let countdownInterval;

    // Function to generate QRIS code
    function generateQRIS() {
        const accountNumber = '4940220195';
        const amount = {{ $order->total_amount }};
        const orderNumber = '{{ $order->order_number }}';
        const timestamp = Math.floor(Date.now() / 1000);

        // Create dynamic data for QRIS
        const qrisData = `${accountNumber}|${amount}|${orderNumber}|${timestamp}`;

        // Generate QR Code using API
        const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=256x256&data=${encodeURIComponent(qrisData)}&bgcolor=FFFFFF&color=6B21A8&margin=10`;

        // Update QR Code image
        document.getElementById('qris-code').src = qrCodeUrl;

        // Reset countdown
        countdown = 60;
    }

    // Function to update countdown
    function updateCountdown() {
        const countdownElement = document.getElementById('countdown');
        countdownElement.textContent = countdown;

        if (countdown <= 10) {
            countdownElement.classList.add('text-red-600');
            countdownElement.classList.remove('text-purple-600');
        } else {
            countdownElement.classList.add('text-purple-600');
            countdownElement.classList.remove('text-red-600');
        }

        countdown--;

        if (countdown < 0) {
            // Generate new QRIS code
            generateQRIS();
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Generate initial QRIS code
        generateQRIS();

        // Start countdown
        countdownInterval = setInterval(updateCountdown, 1000);
    });

    // Clean up interval when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
    });
</script>
@endif
@endpush
@endsection
