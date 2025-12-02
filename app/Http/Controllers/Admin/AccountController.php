<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('product')->latest()->paginate(10);
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        $products = Product::where('type', 'account')
            ->where('is_active', true)
            ->get();
        return view('admin.accounts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:available,sold,reserved',
        ]);

        Account::create($validated);

        // Increment product stock
        $product = Product::find($validated['product_id']);
        $product->increment('stock');

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    public function edit(Account $account)
    {
        $products = Product::where('type', 'account')
            ->where('is_active', true)
            ->get();
        return view('admin.accounts.edit', compact('account', 'products'));
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:available,sold,reserved',
        ]);

        $account->update($validated);

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil diupdate');
    }

    public function destroy(Account $account)
    {
        // Decrement product stock if account is available
        if ($account->status === 'available') {
            $product = Product::find($account->product_id);
            $product->decrement('stock');
        }

        $account->delete();

        return redirect()->route('admin.accounts.index')
            ->with('success', 'Akun berhasil dihapus');
    }
}
