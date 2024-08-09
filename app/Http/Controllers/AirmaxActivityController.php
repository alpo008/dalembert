<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirmaxClient;
use App\Models\AirmaxActivity;
use Carbon\Carbon;

class AirmaxActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allClients = AirmaxClient::select('id','ip_address')
            ->with('airmaxActivities')
            ->limit(3)
            ->get()
            ->toArray();
        return response()->json(
            [
                'status' => 'success',
                'airmax_clients' => $allClients
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
        $dateFormat = 'Y-m-d H:i:s';
        $dayAgo = Carbon::now('Europe/Moscow')->subMinutes(1)->format($dateFormat);

        $airmaxActivities = $request->all();

        if(!empty($airmaxActivities) && is_array($airmaxActivities)) {
            foreach($airmaxActivities as &$airmaxActivity) {
                if($id = $airmaxActivity['airmax_client_id']) {
                    $lastActivity = AirmaxActivity::updateStatus($airmaxActivity);
                }
            }
        }
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
