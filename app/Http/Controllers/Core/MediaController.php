<?php

namespace App\Http\Controllers\Core;

use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreLanguageRequest;
use App\Models\Upload;

class MediaController extends Controller
{
    /**
     * Will redirect to media library
     * @return void
     */
    public function media()
    {
        return view('media.index');
    }

    public function uploadMedia(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        dd($file);

        // Get current year and month
        $currentYear = now()->format('Y');
        $currentMonth = now()->format('m');

        // Create directories if they don't exist
        if (!Storage::exists('public/uploads/' . $currentYear)) {
            Storage::makeDirectory('public/uploads/' . $currentYear);
        }

        if (!Storage::exists('public/uploads/' . $currentYear . '/' . $currentMonth)) {
            Storage::makeDirectory('public/uploads/' . $currentYear . '/' . $currentMonth);
        }

        // Save the file
        $path = $file->storeAs('uploads/' . $currentYear . '/' . $currentMonth, $fileName);

        $downloadableUrl = Storage::disk('public')->url($path);

        $file = new Upload();
        $file->name = $fileName;
        $file->file_location = $path;
        $file->file_extension = $fileExtension;
        $file->file_size = $fileSize;
        $file->file_type = $mimeType;
        $file->saveOrFail();
        
        return response()->json([
            'success' => true,
            'path'=>$path
        ]);
    }
}
