<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            // Debug info
            \Log::info('Store Category - Request Data:', [
                'has_file' => $request->hasFile('image'),
                'file_valid' => $request->hasFile('image') ? $request->file('image')->isValid() : false,
                'all_files' => $request->allFiles(),
                'name' => $request->name,
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            $validated['slug'] = Str::slug($validated['name']);
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $imagePath = $file->store('categories', 'public');
                $validated['image'] = $imagePath;

                \Log::info('Image uploaded successfully', [
                    'path' => $imagePath,
                    'full_path' => \Storage::disk('public')->path($imagePath),
                    'exists' => \Storage::disk('public')->exists($imagePath),
                    'size' => $file->getSize(),
                ]);
            } else {
                \Log::info('No image uploaded or invalid');
            }

            $category = Category::create($validated);
            \Log::info('Category created successfully', [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image ?? 'no image',
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil ditambahkan' . ($category->image ? ' dengan gambar' : ''));

        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $imagePath;
            \Log::info('Category image updated to: ' . $imagePath);

            // Update all products in this category if checkbox is checked
            if ($request->has('update_products_image')) {
                $category->products()->update(['image' => $imagePath]);
                \Log::info('Updated ' . $category->products()->count() . ' products with new image');
            }
        }

        $category->update($validated);

        $message = 'Kategori berhasil diupdate';
        if ($request->has('update_products_image') && $request->hasFile('image')) {
            $productCount = $category->products()->count();
            $message .= " dan {$productCount} produk ikut terupdate gambarnya";
        }

        return redirect()->route('admin.categories.index')
            ->with('success', $message);
    }

    public function destroy(Category $category)
    {
        // Delete image if exists
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
