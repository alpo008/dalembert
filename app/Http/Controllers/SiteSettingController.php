<?php

namespace App\Http\Controllers;
use App\Models\SiteSetting;

use Illuminate\Http\Request;
use App\Http\Requests\SiteSettingRequest;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', SiteSetting::class);
        $allSiteSettings = SiteSetting::all()->toArray();
        return response()->json(
            [
                'status' => 'success',
                'settings' => $allSiteSettings
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
     * @param  SiteSettingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteSettingRequest $request)
    {
        $this->authorize('create', SiteSetting::class);
        $current = SiteSetting::create($request->all());
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
        $this->authorize('view', SiteSetting::class);
        return response()->json(
            [
                'status' => 'success',
                'current' => SiteSetting::find($id)
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
     * @param  SiteSettingRequest  $request
     * @param  SiteSetting $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function update(SiteSettingRequest $request, SiteSetting $siteSetting)
    {
        $this->authorize('update', $siteSetting);
        $result = SiteSetting::whereId($request->id)->update($request->all());
        return response()->json(
            [
                'status' => 'success',
                'current' => SiteSetting::find($request->id)
            ], 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SiteSetting $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSetting $siteSetting)
    {
        $this->authorize('delete', $siteSetting);
        $status = 'error';
        $code = 422;
        $deleted = false;
        if (!empty($siteSetting->id) && SiteSetting::find($siteSetting->id)->delete()) {
            $deleted = $siteSetting->id;
            $status = 'success';
            $code = 200;
        }
        return response()->json(
            compact('status', 'deleted'), $code
        );
    }
}
