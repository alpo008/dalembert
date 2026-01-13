<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class HomeController extends Controller
{
    const EARTH_RADIUS = 6378;  //km
    const MIN_PLACE_SIZE = 1;   //km


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
        $weather = $request->session()->get('weather');
        $oldLat = Arr::get($weather, 'latitude');
        $oldLng = Arr::get($weather, 'longitude');
        $weather['updated'] = false;

        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'timezone' => 'required|string'
        ]);
        $lat = $validated['lat'];
        $lng = $validated['lng'];
        $timeZone = $validated['timezone'];

        if ($this->locationWasChanged(compact('oldLat', 'oldLng', 'lat', 'lng')) || $this->forecastIsStale($weather)) {
            $latlng = $lat . ',' . $lng;
            $openMeteoApiUrl = config('custom.open_meteo.api_url');
            $forecast = Http::get($openMeteoApiUrl , [
                'latitude' => $validated['lat'],
                'longitude' => $validated['lng'],
                //'hourly' => ['temperature_2m', 'apparent_temperature', 'rain', 'showers', 'snowfall', 'snow_depth'],
                'windspeed_unit'=> 'ms',
                'daily' => ['sunrise', 'sunset'],
                'timezone' => $timeZone,
                'current_weather' => true
            ]);

            $weather = $forecast->json();
            $weather['updated'] = true;

            $geocodingApiUrl = config('custom.google_maps.geocode_api_url');
            $geocodingApiKey = config('custom.google_maps.api_key');

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
            $request->session()->put('weather', $weather);
        }

        return response()->json(
            [
                'status' => 'success',
                'weather' => $weather
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

    /**
     * Checks if weather forecast hour was changed.
     *
     * @param  array|null $weather
     * @return bool
     */
    private function forecastIsStale(array|null $weather) :bool
    {
        $result = !$weather;
        if (!$result) {
            $time = Arr::get($weather, 'current_weather.time');
            $timeZone = Arr::get($weather, 'timezone');
            if (!!$time && !!$timeZone) {
                $forecastHour = Carbon::parse($time)->hour;
                $currentHour = now($timeZone)->hour;
                $result = ($forecastHour !== $currentHour);
            }
        }
        return $result;
    }

    /**
    * Checks if location was changed for more than MIN_PLACE_SIZE value
    * @param array $locationData
    * @return bool
    */
    private function locationWasChanged(array $locationData) :bool
    {
        $result = true;
        if (!!$locationData['oldLat'] && !!$locationData['oldLng']) {
            $toRad = pi() / 180;
            $lat1 = $locationData['oldLat'] * $toRad;
            $lng1 = $locationData['oldLng'] * $toRad;
            $lat2 = $locationData['lat'] * $toRad;
            $lng2 = $locationData['lng'] * $toRad;
            $deltaLat = $lat2 - $lat1;
            $deltaLng = $lng2 - $lng1;
            $var1 = pow(sin($deltaLat / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($deltaLng / 2), 2);
            $var2 = 2 * atan2(sqrt($var1), sqrt(1 - $var1));
            $shift = $var2 * self::EARTH_RADIUS;
            $result = ($shift > self::MIN_PLACE_SIZE);
        } 
        return $result;
    }
}
