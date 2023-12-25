<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attacment;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Attachment::class);
        $created = Attachment::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'current' => $created
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
    public function show($id, $obj)
    {
        $this->authorize('view', Attachment::class);
        $allAttachments = Attachment::where('object', $obj)->where('id', $id)->toArray();
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
    public function destroy($id)
    {
        //
    }
}
