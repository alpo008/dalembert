<?php

namespace App\Http\Controllers;

use App\Models\AirmaxClient;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAirmaxClientRequest;

class AirmaxClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allClients = AirmaxClient::all()->toArray();
        return response()->json(
            [
                'status' => 'success',
                'clients' => $allClients
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Http\Response
     */
    public function show(AirmaxClient $airmaxClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Http\Response
     */
    public function edit(AirmaxClient $airmaxClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateAirmaxClientRequest  $request
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAirmaxClientRequest $request, AirmaxClient $airmaxClient)
    {
        $result = AirmaxClient::whereId($request->id)->update($request->all());
        return response()->json(
            [
                'status' => 'success',
                'updated' => $result
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirmaxClient  $airmaxClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirmaxClient $airmaxClient)
    {
        //
    }
}
