<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use App\Models\Media;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;

trait MediaUploader
{
    private $media;

    /** 
     * Create Media object for Payments
     * @param  [type] $request [description]
     * @return null|Media
     */
    public function payment($request): ?Media
    {     
        $file = $request->file('file');
        if(!($file instanceof UploadedFile)) {
        	return null;
        }
        $name = $file->hashName();

        $this->media = new Media ([
            'name' => __('Payment document'),
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => 'documents',                
            'disk' => 'local',
            'file' => $request->file('file'),
            'collection' => 'Payments',
            'size' => $file->getSize(),
            'uploaded_by' => Auth::id(),
            'description' => $request->get('destination'),
            'doi' => $request->get('doi')
        ]);
        $this->media->setFile($file);
        return $this->media;
    }

    /** 
     * Attach uploaded media to morphable
     * @param  [type] $morphable 
     * @param  Media $media
     * @return Attachment
     */
    public function attach($morphable, Media $media): Attachment
    {
    	$morphable_type = str_replace('App\\Models\\', '', $morphable::class);
    	$morphable_id = $morphable->id;
    	$media_id = $media->id;
    	return Attachment::create(compact(['morphable_id', 'morphable_type', 'media_id']));
    }

}