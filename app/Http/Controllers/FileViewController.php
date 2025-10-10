<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FileViewController extends Controller
{
    public function viewFile($path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found.');
        }

        // Get file mime type dynamically
        $mimeType = mime_content_type($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
        ]);
    }
}
