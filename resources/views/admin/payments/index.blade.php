@extends('layouts.admin')

@section('header', 'Kelola Pembayaran')

@section('content')
<div class="mb-6">
    <form method="GET" class="flex space-x-2">
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($payments as $payment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-sm">{{ $payment->order->order_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <p class="font-medium">{{ $payment->order->customer_name }}</p>
                            <p class="text-gray-500">{{ $payment->order->customer_email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($payment->status == 'success') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->payment_proof)
                            <i class="fas fa-check-circle text-green-600"></i> Ada
                        @else
                            <i class="fas fa-times-circle text-red-600"></i> Belum
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        Belum ada pembayaran
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $payments->links() }}
</div>
@endsection
