<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sticker;
use App\Models\Media;
use App\Models\Attachment;
use App\Http\Requests\StickerRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\MediaUploader;

class StickerController extends Controller
{
    use MediaUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Sticker::class);
        $allStickers = Sticker::with('attachments')->get()->toArray();
        return response()->json(
            [
                'status' => 'success',
                'stickers' => $allStickers
            ], 200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   StickerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StickerRequest $request)
    {

        $this->authorize('create', Sticker::class);
        $request->merge(['created_by' => Auth::id()]);
        $current = Sticker::create($request->all());
        $mediaArray = $this->sticker($request);

        foreach($mediaArray as $media) {
            if(!!$media && $media->save()) {
                $this->attach($current::class, $current->id, $media);
            }
        }

        return response()->json(
            [
                'status' => 'success',
                'current' => Sticker::with('attachments')->find($current->id)
            ], 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StickerRequest  $request
     * @param  App\Models\Sticker $sticker
     * @return \Illuminate\Http\Response
     */
    public function update(StickerRequest $request, Sticker $sticker)
    {
        $this->authorize('update', $sticker);
        $result = Sticker::whereId($sticker->id)->update($request->except([
            'attachments', '_method', 'files'
        ]));
        $mediaArray = $this->sticker($request);

        foreach($mediaArray as $media) {
            if(!!$result && !!$media && $media->save()) {
                $sticker->attachments()->with('media')->each(function($attachment) use($media) {
                    $existedMedia = $attachment->media;
                    if($existedMedia instanceof Media && 
                        $existedMedia->description === $media->description) {
                        $attachment->delete();
                    }
                });
                $this->attach($sticker::class, $sticker->id, $media);
            }
        }
        return response()->json(
            [
                'status' => 'success',
                'current' => Sticker::with('attachments')->find($sticker->id)
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sticker $sticker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sticker $sticker)
    {
        $this->authorize('delete', $sticker);
        Sticker::destroy($sticker->id);
        return response()->json(
            ['status' => 'success', 'deleted' => $sticker->id ], 200
        );
    }
}
