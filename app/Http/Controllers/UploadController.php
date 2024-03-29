<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;
use Illuminate\Validation\Rules\File;

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
        $this->authorize('create', Media::class);

        $request->validate([
            'file' => ['required', File::types(['jpg', 'png' , 'jpeg', 'tiff', 'pdf'])->max(2048)],
            'name' => 'required|max:100',
            'collection' => 'required|max:50',
            'doi' => 'date|nullable'
        ]);
 
        $file = $request->file('file');
        $name = $file->hashName();
        
        Storage::disk('local')->put('documents', $file);
 
        $result = Media::query()->create(
            attributes: [
                'name' => $request->get('name'),
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path' => "documents/{$name}",                
                'disk' => 'local',
                'file_hash' => hash_file(
                    'sha256',
                    storage_path(
                        path: "app/documents/{$name}",
                    ),
                ),
                'collection' => $request->get('collection'),
                'size' => $file->getSize(),
                'uploaded_by' => Auth::id(),
                'description' => $request->get('description'),
                'doi' => $request->get('doi')
            ],
        );

        return response()->json(
            [
                'status' => 'success',
                'uploaded' => $result
            ], 200
        );
    }
}
