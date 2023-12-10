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
        $media = Upload::all();
        return view('media.index',compact('media'));
    }

    /**
     * upload media files
     * @param Request $request
     */
    public function uploadMedia(Request $request)
    {
        try {
            $file = $request->file('file');

            // Generate a unique filename using timestamp
            $timestamp = now()->timestamp;
            $fileName = $timestamp . '_' . $file->getClientOriginalName();

            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Get current year and month
            $currentYear = now()->format('Y');
            $currentMonth = now()->format('m');

            // Create directories if they don't exist
            $uploadPath = public_path("uploads/$currentYear/$currentMonth");

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Save the file
            $file->move($uploadPath, $fileName);

            $fileLocation = "uploads/$currentYear/$currentMonth/$fileName"; 

            $fileModel = new Upload();
            $fileModel->name = $fileName;
            $fileModel->file_location = $fileLocation;
            $fileModel->file_extension = $fileExtension;
            $fileModel->file_size = $fileSize;
            $fileModel->file_type = $mimeType;
            $fileModel->saveOrFail();

            return response()->json([
                'success' => true,
                'path' => asset($fileLocation)
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate('Unable to upload file')
            ]);
        }
    }
}
