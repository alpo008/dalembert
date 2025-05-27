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
        $this->authorize('viewAny', AirmaxClient::class);
        $allClients = AirmaxClient::with('payments')->with('attachments')->get()->toArray();
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
        $this->authorize('create', AirmaxClient::class);
        $created = AirmaxClient::create($request->all());
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
        $this->authorize('update', $airmaxClient);
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
                'current' => AirmaxClient::find($request->id)
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
        $this->authorize('delete', $airmaxClient);
        $status = 'error';
        $code = 422;
        $deleted = false;
        if (!empty($airmaxClient->id)) {
            $deleted = AirmaxClient::find($airmaxClient->id)->delete();
            $status = 'success';
            $code = 200;
        }
        return response()->json(
            compact('status', 'deleted'), $code
        );
    }

    /**
     * Remturns airmax clients statistics data.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $this->authorize('viewAny', AirmaxClient::class);
        return response()->json(
            [
                'status' => 'success',
                'statistics' => ['airmax' => [
                    'overdue' => AirmaxClient::statistics(AirmaxClient::CLIENTS_DEBTORS)->toArray(),
                    'active' => AirmaxClient::statistics(AirmaxClient::CLIENTS_ACTIVE)->toArray(), 
                    'disabled' => AirmaxClient::statistics(AirmaxClient::CLIENTS_DISABLED)->toArray(), 
                    'overdueButActive' => AirmaxClient::statistics(AirmaxClient::CLIENTS_DEBTORS_BUT_ACTIVE)->toArray(),
                    'remind' => AirmaxClient::statistics(AirmaxClient::CLIENTS_TO_REMIND)->toArray(),
                    'withLocation' => AirmaxClient::statistics(
                            AirmaxClient::CLIENTS_WITH_LOCATION
                        )->toArray()
                    ]
                ]
            ], 200
        );
    }
}
