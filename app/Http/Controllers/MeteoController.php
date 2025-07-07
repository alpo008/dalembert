<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeteoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meteoData = Storage::get('meteo/wx.xml');
        $meteoObject = simplexml_load_string($meteoData, "SimpleXMLElement", LIBXML_NOCDATA);
        $meteoJson = json_encode($meteoObject);
        $meteoArray = json_decode($meteoJson, TRUE);
        return response()->json(
            [
                'status' => 'success',
                'meteoData' => $meteoArray          
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('rss');
        $r = Storage::disk('local')->putFileAs('meteo', $file, 'wx.xml');
        return response()->json(
        [
            'status' => 'success',
            'path' => $r           
        ], 200);
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
