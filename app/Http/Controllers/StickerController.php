<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StickerRequest;

class StickerController extends Controller
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
     * @param   StickerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StickerRequest $request)
    {
        $this->authorize('create', Sticker::class);
        $request->merge(['created_by' => Auth::id()]);
        $current = Sticker::create($request->all());
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
