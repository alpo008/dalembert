<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lattitude = 56.553830;
        $longitude = 36.435032;

        $lattitude = 55.763545;
        $longitude = 37.587327;
        
        $latlng = $lattitude . ',' . $longitude;
        $openMeteoApiUrl = env('OPEN_METEO_API_URL');
        $forecast = Http::get($openMeteoApiUrl , [
            'latitude' => $lattitude,
            'longitude' => $longitude,
            //'hourly' => ['temperature_2m', 'apparent_temperature', 'rain', 'showers', 'snowfall', 'snow_depth'],
            'windspeed_unit'=> 'ms',
            'daily' => ['sunrise', 'sunset'],
            'timezone' => 'Europe/Moscow',
            'current_weather' => true
        ]);

        $weather = $forecast->json();

        $geocodingApiUrl = env('GM_API_URL');
        $geocodingApiKey = env('GM_API_KEY');
        $apiKey = 'AIzaSyCF8ntzB84KZbU051ePBW7-cmTzbCA79q0';

        $location = Http::get($geocodingApiUrl , [
            'latlng' => $latlng,
            'key' => $geocodingApiKey,
            'language' => 'ru'
        ]);

        $locationData = $location->json();

        $city = 'Unknown';

        if($addressComponents = array_get($locationData, 'results.0.address_components')) {
            foreach($addressComponents as $val) {
                $a = array_get($val, 'types.0');
                $b = array_get($val, 'types.1');
                if($a === 'locality' && $b === 'political') {
                    if(!empty($val['short_name'])) {
                        $city = $val['short_name'];
                    } elseif (!empty($val['long_name'])) {
                        $city = $val['long_name'];
                    }
                }
            }
        }

        $weather['city'] = $city;

        return response()->json(
            [
                'status' => 'success',
                'weather' => $weather
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
