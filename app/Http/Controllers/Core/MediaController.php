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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Will redirect to media library
     * @return void
     */
    public function media()
    {
        $media = Upload::with('user')->orderBy('id','desc')->paginate(22);
        return view('media.index', compact('media'));
    }

    /**
     * Media pagination
     *
     * @param Request $request
     */
    public function paginateMediaLibrary(Request $request)
    {
        $skip = ($request['page'] - 1) * $request['item'];

        $selectedFileIds = '';
        if (!empty($request['selected_file'])) {
            $selectedFileIds = implode(',', $request['selected_file']);
        }

        if (!empty($selectedFileIds)) {
            $orderByRaw = "FIELD(id, $selectedFileIds) DESC";

            $media = Upload::orderByRaw($orderByRaw)
                ->orderBy('created_at', 'desc')
                ->skip($skip)->take($request['item'])->get();
        }
        else{
            $media = Upload::orderBy('id', 'desc')
                ->skip($skip)->take($request['item'])->get();
        }

        return view('media.include.files', compact('media'));
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
            $fileModel->uploaded_by = Auth::user()->id;
            $fileModel->saveOrFail();

            $details = [
                'file_name'=> $fileModel->name,
                'file_url'=> asset($fileLocation),
                'file_type'=> $fileModel->file_type,
                'file_size'=> $fileModel->file_size,
                'uploaded_by'=> $fileModel->uploaded_by,
                'file_extension'=> $fileModel->file_extension,
                'file_id'=> $fileModel->id
            ];

            return response()->json([
                'success' => true,
                'path' => asset($fileLocation),
                'details' => $details
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate('Unable to upload file')
            ]);
        }
    }

    /**
     * Will delete requested file
     *
     * @param Request $request
     */
    public function deleteFileFromMedia(Request $request)
    {
        try {
            $fileModel = Upload::find($request['id']);
            $fileModel->delete();
            Toastr::success('File deleted sucessfully from media', 'Success');
            return back();
        } catch (\Exception $ex) {
            Toastr::error('Unable to delete file from from media', 'Error');
            return back();
        }
    }

    /**
     * Delete media files in bulk
     */
    public function deleteFilesFromMediaInBulk(Request $request)
    {
        try {
            $requested_files_to_delete = explode(',', $request['files']);
            Upload::whereIn('id', $requested_files_to_delete)->delete();
            return response()->json([
                'success' => true,
                'message' => "Files deleted successfully"
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => translate('Unable to delete files')
            ], 500);
        }
    }

    /**
     * Get media library
     */
    public function getMediaForLibrary(Request $request)
    {
        $selectedFileIds = '';
        if (!empty($request['selected_file'])) {
            // $selectedFileIds = implode(',', $request['selected_file']);
            $selectedFileIds = $request['selected_file'];
        }

        if (!empty($selectedFileIds)) {
            $orderByRaw = "FIELD(id, $selectedFileIds) DESC";

            $media = Upload::orderByRaw($orderByRaw)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
        else{
            $media = Upload::orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return view('media.library', compact('media', 'selectedFileIds'));
    }
}
