<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('order');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('order.items')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $payment->order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        return back()->with('success', 'Pembayaran berhasil disetujui');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'failed',
        ]);

        $payment->order->update([
            'status' => 'cancelled',
        ]);

        // Return stock
        foreach ($payment->order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        return back()->with('success', 'Pembayaran ditolak');
    }
}
