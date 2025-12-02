@extends('layouts.admin')

@section('header', 'Edit Kategori')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kategori *</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" value="{{ old('name', $category->name) }}">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if($category->image)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Gambar Saat Ini</label>
                    <div class="flex items-start space-x-4">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-48 h-48 object-cover rounded-lg shadow-md border-2 border-gray-200">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-2">Preview gambar kategori</p>
                            <p class="text-xs text-gray-500">Ukuran: 48 x 48 pixels (preview)</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar Baru</label>
                <input type="file" name="image" accept="image/*" id="image-input" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" onchange="previewImage(event)">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Preview gambar baru -->
                <div id="new-image-preview" class="mt-3 hidden">
                    <label class="block text-gray-700 font-semibold mb-2">Preview Gambar Baru:</label>
                    <img id="preview-img" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg shadow-md border-2 border-blue-500">
                </div>
            </div>

            <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="update_products_image" value="1" class="mr-2" id="update-products-checkbox">
                            <span class="text-gray-700 font-medium">Update gambar semua produk dalam kategori ini</span>
                        </label>
                        <p class="text-sm text-gray-600 mt-1">
                            Jika dicentang, gambar kategori baru akan diaplikasikan ke <strong>{{ $category->products()->count() }} produk</strong> dalam kategori ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="mr-2">
                    <span class="text-gray-700">Aktif</span>
                </label>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.getElementById('new-image-preview');
                const previewImg = document.getElementById('preview-img');
                previewImg.src = e.target.result;
                previewDiv.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Auto check the update products checkbox when user selects a new image
    document.getElementById('image-input').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const checkbox = document.getElementById('update-products-checkbox');
            // Optionally auto-check (uncomment if you want auto-check behavior)
            // checkbox.checked = true;
        }
    });
</script>
@endpush
@endsection
