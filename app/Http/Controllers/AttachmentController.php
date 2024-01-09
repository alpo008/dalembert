<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Http\Requests\AddAttachmentRequest;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\AddAttachmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddAttachmentRequest $request)
    {
        $this->authorize('create', Attachment::class);
        $created = Attachment::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'current' => Attachment::with('media')->find($created->id)
            ], 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $obj
     * @return \Illuminate\Http\Response
     */
    public function show($obj, $id)
    {
        $this->authorize('view', Attachment::class);
        $allAttachments = Attachment::with('media')->where('object', $obj)->where('object_id', $id)->get();
        return response()->json(
            [
                'status' => 'success',
                'attachments' => $allAttachments
            ], 200
        );
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);
        Attachment::destroy($attachment->id);
        return response()->json(
            ['status' => 'success', 'deleted' => $attachment->id ], 200
        );
    }

    /**
     * Download attached mediafile.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request) {
        $this->authorize('view', Attachment::class);
        $media = Attachment::find($request->id)->media;
        return response()->json(
            [
                'status' => 'success',
                'contents' => 'data: ' . $media->mime_type . ';base64,' . base64_encode($media->getContents())
            ], 200
        );
    }
}
