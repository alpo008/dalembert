<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hydrometry;
use App\Http\Requests\HydrometryRequest;

class HydrometryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Hydrometry::class);
        $hydrometries = Hydrometry::all()->toArray();
        return response()->json(
            [
                'status' => 'success',
                'hydrometries' => $hydrometries
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
     * @param  HydrometryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HydrometryRequest $request)
    {
        $this->authorize('create', Hydrometry::class);
        $current = Hydrometry::create($request->all());
        return response()->json(
            [
                'status' => 'success',
                'current' => $current
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
     * @param  HydrometryRequest  $request
     * @param  Hydrometry  $hydrometry
     * @return \Illuminate\Http\Response
     */
    public function update(HydrometryRequest $request, $hydrometry)
    {
        $this->authorize('update', $hydrometry);
        $result = Hydrometry::whereId($request->id)->update($request->all());
        return response()->json(
            [
                'status' => 'success',
                'current' => Hydrometry::find($request->id)
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Hydrometry  $hydrometry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hydrometry $hydrometry)
    {
        $this->authorize('delete', $hydrometry);
        $status = 'error';
        $code = 422;
        $deleted = false;
        if (!empty($hydrometry->id) && Hydrometry::find($hydrometry->id)->delete()) {
            $deleted = $hydrometry->id;
            $status = 'success';
            $code = 200;
        }
        return response()->json(
            compact('status', 'deleted'), $code
        );
    }
}
