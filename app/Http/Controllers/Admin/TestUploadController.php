<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestUploadController extends Controller
{
    public function index()
    {
        // Get all uploaded test files
        $uploadedFiles = Storage::disk('public')->files('test-uploads');

        return view('admin.test-upload', compact('uploadedFiles'));
    }

    public function store(Request $request)
    {
        $debugInfo = [
            'hasFile' => $request->hasFile('test_image'),
            'isValid' => $request->hasFile('test_image') ? $request->file('test_image')->isValid() : false,
            'originalName' => $request->hasFile('test_image') ? $request->file('test_image')->getClientOriginalName() : null,
            'mimeType' => $request->hasFile('test_image') ? $request->file('test_image')->getMimeType() : null,
            'size' => $request->hasFile('test_image') ? $request->file('test_image')->getSize() : null,
            'error' => $request->hasFile('test_image') ? $request->file('test_image')->getError() : null,
        ];

        Log::info('Test Upload Debug:', $debugInfo);

        $request->validate([
            'test_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('test_image')) {
                $file = $request->file('test_image');

                // Create directory if not exists
                if (!Storage::disk('public')->exists('test-uploads')) {
                    Storage::disk('public')->makeDirectory('test-uploads');
                }

                // Store the file
                $path = $file->store('test-uploads', 'public');

                Log::info('File uploaded successfully to: ' . $path);

                $debugInfo['uploadedPath'] = $path;
                $debugInfo['fullPath'] = Storage::disk('public')->path($path);
                $debugInfo['exists'] = Storage::disk('public')->exists($path);

                $uploadedFiles = Storage::disk('public')->files('test-uploads');

                return redirect()->route('admin.test-upload.index')
                    ->with('success', 'File berhasil diupload ke: ' . $path)
                    ->with('debug', $debugInfo);
            }
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());

            $debugInfo['exception'] = $e->getMessage();

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->with('debug', $debugInfo);
        }

        return redirect()->back()
            ->with('error', 'Tidak ada file yang diupload')
            ->with('debug', $debugInfo);
    }
}
