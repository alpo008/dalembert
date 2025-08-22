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


	/** Gets weather parameters values with or without units 
	 *
	 * @param string $name
	 * @param boolean $withUnit
	 * @return string
	 * */
	public function getCurrentValue($name, $withUnit = false): string
	{
		$result = Arr::get($this->forecast, 
			"current.$name"
		);
		if($withUnit) {
			$result .= ' ' . __(Arr::get($this->forecast, 
				"current_units.$name"));
		}
		return $result;
	}

	/** Converts wind direction to rumbs 
	 * 
	 * @return string
	 * */
	public function windRumb(): string
	{
		$windDirection = $this->getCurrentValue('wind_direction_10m');
		if (!is_numeric($windDirection)) {
			return "";
		}
		$rumbs = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
		return $rumbs[$windDirection % 16];
	}

	/** Gets general weather description
	 *
	 * @return string
	 * */
	public function description(): string
	{
		$result = '';
		$result .= date('Y.m.d H:m', $this->getCurrentValue('time')) . PHP_EOL;
		$result .= $this->getWmoText() . ', ';
		$result .= $this->getCurrentValue('temperature_2m', true) . PHP_EOL;
		$result .= 	__('Wind') . ': ' . $this->windRumb() . ' (' .
					$this->getCurrentValue('wind_direction_10m', true) . '), ' .
					$this->getCurrentValue('wind_speed_10m', true) . PHP_EOL;
		$result .= __('Barometer') . ': ' .
					$this->getCurrentValue('surface_pressure', true) . PHP_EOL;
		if(!!$this->getCurrentValue('rain')){
			$result .= __('Rain') . ': ' .
			$this->getCurrentValue('rain', true) . PHP_EOL;
		}
		return $result;
	}

	/** Gets wmo weather description by wmo code
	 *
	 * @return string
	 * */
	private function getWmoText(): string
	{
        $path = base_path('resources/data/weather/wx_codes.json');
        $txt = file_get_contents($path);
        $wmoCodes = json_decode($txt, true);
        $wmoCode = $this->getCurrentValue('weather_code');
        if(!is_array($wmoCodes) || !array_key_exists($wmoCode, $wmoCodes)) {
        	return __('N/A');
        }
        return __($wmoCodes[$wmoCode]);
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

	/** Checks if stored forecast is out of time or not 
	 * 
	 * @param string|null $wistored
	 * @return boolean
	 * */
	private function isOutOfTime(string|null $stored): boolean
	{
		if(empty($stored)) {
			return true;
		}
		$toCheck = json_decode($stored, true);
		$time = Arr::get($toCheck, 'current.time');
		return (time() - $time) > self::REFRESHING_TIME;
	}
}