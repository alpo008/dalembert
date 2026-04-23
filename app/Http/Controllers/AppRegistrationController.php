<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppRegistration;
use App\Http\Requests\AppRegistrationRequest;

class AppRegistrationController extends Controller
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
        //$this->authorize('viewAny', AppRegistration::class);
        $request->merge(['app_key' => AppRegistration::generateKey(
            $request->input('app_id'), $request->input('customer_id')
        )]);
        $current = AppRegistration::create($request->all());

        return response()->json(
            [
                'status' => 'success',
                'current' => $current,
            ], 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @param  integer  $app
     * @return \Illuminate\Http\Response
     */
    public function show($uuid, $app)
    {
        //TODO call from app only
        $registration = AppRegistration::with('customer')
            ->where('device_uuid', $uuid)
            ->where('app_id', $app)
            ->first();
        return response()->json(
            [
                'status' => 'success',
                'regData' => $registration,
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
     * @param  App\Http\Requests\AppRegistrationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppRegistrationRequest $request, $id)
    {
        $available = AppRegistration::with('customer')
            ->where('app_key', $request->input('app_key'))
            ->where('app_id', $request->input('app_id'))
            ->whereNull('device_uuid')
            ->first();
        $available->device_uuid = $request->input('device_uuid');
        $registered = $available->save();
        return response()->json(
            [
                'status' => 'success',
                'registered' => $registered
            ]
        );
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
