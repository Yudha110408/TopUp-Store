@extends('layouts.admin')

@section('header', 'Test Upload Gambar')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('debug'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <strong>Debug Info:</strong>
                <pre class="mt-2 text-xs">{{ json_encode(session('debug'), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif

        <form action="{{ route('admin.test-upload.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Test Upload Gambar</label>
                <input type="file" name="test_image" accept="image/*" id="testImage" onchange="previewImage(event)" class="w-full px-4 py-2 border rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                @error('test_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div id="imagePreview" style="display: none;" class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                    <img id="previewImg" src="" alt="Preview" class="border rounded" style="max-width: 200px; max-height: 200px;">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-upload"></i> Test Upload
            </button>
        </form>

        @if(isset($uploadedFiles) && count($uploadedFiles) > 0)
            <div class="mt-6">
                <h3 class="font-semibold text-lg mb-3">File yang Sudah Diupload:</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($uploadedFiles as $file)
                        <div class="border rounded p-2">
                            <img src="{{ asset('storage/' . $file) }}" alt="Uploaded" class="w-full h-32 object-cover rounded">
                            <p class="text-xs text-gray-600 mt-1 truncate">{{ $file }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endpush
@endsection
