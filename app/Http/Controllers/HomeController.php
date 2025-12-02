<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->latest()
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->paginate(12);

        return view('category', compact('category', 'products'));
    }

    public function product($categorySlug, $productSlug)
    {
        $product = Product::with('category')
            ->where('slug', $productSlug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('product', compact('product'));
    }
}
