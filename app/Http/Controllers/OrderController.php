<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id]['quantity'];
        }

        return view('checkout', compact('products', 'cart', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'game_id' => 'nullable|string|max:100',
            'payment_method' => 'required|string|in:bank_transfer,e_wallet,qris',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong');
        }

        DB::beginTransaction();
        try {
            $total = 0;
            $products = Product::whereIn('id', array_keys($cart))->get();

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'game_id' => $validated['game_id'],
                'total_amount' => 0,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
            ]);

            // Create order items
            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];
                $subtotal = $product->price * $quantity;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Update stock
                $product->decrement('stock', $quantity);

                // If product type is account, assign account
                if ($product->type === 'account') {
                    $accounts = Account::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->limit($quantity)
                        ->get();

                    foreach ($accounts as $account) {
                        $account->update([
                            'status' => 'sold',
                            'order_id' => $order->id,
                        ]);
                    }
                }
            }

            // Update order total
            $order->update(['total_amount' => $total]);

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'status' => 'pending',
            ]);

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('payment', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    public function payment($orderNumber)
    {
        $order = Order::with(['items', 'payment'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('payment', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            $order->payment->update([
                'payment_proof' => $path,
                'status' => 'pending',
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diupload');
        }

        return back()->with('error', 'Gagal upload bukti pembayaran');
    }

    public function history()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', auth()->id())
            ->with(['items', 'payment'])
            ->latest()
            ->paginate(10);

        return view('order-history', compact('orders'));
    }

    public function detail($orderNumber)
    {
        $order = Order::with(['items.product', 'payment'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // If user is logged in, check if order belongs to them
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        // Get accounts if product type is account
        $accounts = [];
        foreach ($order->items as $item) {
            if ($item->product->type === 'account') {
                $itemAccounts = Account::where('order_id', $order->id)
                    ->where('product_id', $item->product_id)
                    ->get();
                $accounts[$item->product_id] = $itemAccounts;
            }
        }

        return view('order-detail', compact('order', 'accounts'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
                'name' => $product->name,
                'price' => $product->price,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function removeFromCart($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
