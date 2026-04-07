<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppRegistration;

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
        $request->merge(['app_key' => AppRegistration::generateKey()]);
        $new = true;
        $existing = AppRegistration::where('app_id', $request->input('app_id'))
            ->where('customer_id', $request->input('customer_id'))->first();
        if ($existing instanceof AppRegistration) {
            $current = $existing;
            $new = false;
        } else {
            $current = AppRegistration::create($request->all());
        }
        $key = '-' . $current->customer_id . '[' . $current->app_id . ']' . $current->app_key;

        return response()->json(
            [
                'status' => 'success',
                'current' => $current,
                'key' => $current->customerKey(),
                'new' => $new
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
