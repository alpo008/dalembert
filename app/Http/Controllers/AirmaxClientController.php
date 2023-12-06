<?php

namespace App\Http\Controllers;

use App\Models\AirmaxClient;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAirmaxClientRequest;
use Illuminate\Support\Facades\Crypt;

class AirmaxClientController extends Controller
{
    const MAX_ENCRYPTING_FIELD_LENGTH = 50;

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
     * @param  App\Http\Requests\UpdateAirmaxClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateAirmaxClientRequest $request)
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
        if(strlen($request->admin) < self::MAX_ENCRYPTING_FIELD_LENGTH && strlen($request->admin) > 0) {
            $request->merge(['admin' => Crypt::encryptString($request->admin)]);
        }
        if(strlen($request->password) < self::MAX_ENCRYPTING_FIELD_LENGTH && strlen($request->password) > 0) {
            $request->merge(['password' => Crypt::encryptString($request->password)]);
        }
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
