<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //Gate::authorize('upload-files');
 
        $file = $request->file('file');
        $name = $file->hashName();
 
        $upload = Storage::put("documents/{$name}", $file);
 
        Media::query()->create(
            attributes: [
                'name' => "{$name}",
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path' => "documents/{$name}"
,
                'disk' => config('uploaded'),
                'file_hash' => hash_file(
                    config('sha256'),
                    storage_path(
                        path: "documents/{$name}",
                    ),
                ),
                'collection' => $request->get('collection'),
                'size' => $file->getSize(),
            ],
        );
        return response()->json(
            [
                'status' => 'success',
                'uploaded' => 1
            ], 200
        );
    }
}
