<?php 

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class OpenMeteoWeather
{
	const REFRESHING_TIME = 1200;  //TODO

	protected $forecast;

	public function __construct()
	{
		$stored = Storage::disk('local')->get('meteo/openmeteo.json');
		if($this->isOutOfTime($stored)) {
			$this->refresh();
			Storage::disk('local')->put('meteo/openmeteo.json', 
				json_encode($this->forecast, JSON_PRETTY_PRINT)
			);
		} else {
			$this->forecast = json_decode($stored, true);
		}
	}


	/** Gets weather parameters values with or without units */
	public function getCurrentValue($name, $withUnit = false)
	{
		$result = Arr::get($this->forecast, 
			"current.$name"
		);
		if($withUnit) {
			$result .= ' ' . __(Arr::get($this->forecast, 
				"current_units.$name")
			);
		}
		return $result;
	}

	/** Updates weather data from server */
	private function refresh()
	{
        $coords = json_decode(env('MIX_GM_MAP_CENTER'), true);
        $forecast = Http::get(env('OPEN_METEO_API_URL') , [
            'latitude' => Arr::get($coords, 'lat'),
            'longitude' => Arr::get($coords, 'lng'),
            //'hourly' => ['temperature_2m', 'apparent_temperature', 'rain', 'showers', 'snowfall', 'snow_depth'],
            'current' => [
            	'temperature_2m',
            	'relative_humidity_2m',
            	'rain',
	            'showers',
             	'wind_speed_10m',
             	'wind_direction_10m',
             	'surface_pressure',
             	'snowfall',
             	'snow_depth',
             	'weather_code'
             ],
            'windspeed_unit'=> 'ms',
            'daily' => ['sunrise', 'sunset'],
            'timezone' => env('DEFAULT_TIMEZONE'),
            'timeformat' => 'unixtime'
            //'current_weather' => true
        ]);
        $this->forecast = $forecast->json();
	}

	/** Checks if stored forecast is out of time or not */
	private function isOutOfTime(string|null $stored): bool
	{
		if(empty($stored)) {
			return true;
		}
		$toCheck = json_decode($stored, true);
		$time = Arr::get($toCheck, 'current.time');
		return (time() - $time) > self::REFRESHING_TIME;
	}
}