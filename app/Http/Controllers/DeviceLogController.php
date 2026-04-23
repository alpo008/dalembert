<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeviceLogRequest;
use App\Http\Middleware\CheckApiKey;
use App\Models\DeviceLog;

class DeviceLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckApiKey::class, ['only' => ['store']]);
        $this->middleware('auth', ['only' => ['viewAny']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allLogs = DeviceLog::with('appRegistrations')->get()->toArray();
        return response()->json(
            [
                'status' => 'success',
                'logs' => $allLogs
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
     * @param  \Illuminate\Http\DeviceLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeviceLogRequest $request)
    {
        $created = DeviceLog::create($request->all());
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
