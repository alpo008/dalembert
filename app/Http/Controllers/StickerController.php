<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sticker;
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
        $media = $this->sticker($request);
        if(!!$media && $media->save()) {
            $this->attach($current::class, $current->id, $media);
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
     * @param  StickerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StickerRequest $request, $id)
    {
        //
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
