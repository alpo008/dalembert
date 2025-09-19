<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EcowittWeather
{
	const REFRESHING_TIME = 180;  //TODO
	protected $forecast;

	public function __construct()
	{
		$stored = Storage::disk('local')->get('meteo/ecowitt.json');
		if($this->isOutOfTime($stored)) {
			$this->refresh();
			Storage::disk('local')->put('meteo/ecowitt.json', 
				json_encode($this->forecast, JSON_PRETTY_PRINT)
			);
		} else {
			$this->forecast = json_decode($stored, true);
		}
	}

	/** Gets weather parameters values with or without units 
	 *
	 * @param string $name
	 * @param bool $withUnit
	 * @return string
	 * */
	public function getCurrentValue($name, $withUnit = false): string
	{
		$result = Arr::get($this->forecast, 
			"data.$name.value"
		);
		if($withUnit) {
			$result .= ' ' . __(Arr::get($this->forecast, 
				"data.$name.unit"));
		}
		return $result;
	}

	/** Converts wind direction to rumbs 
	 * 
	 * @return string
	 * */
	public function windRumb(): string
	{
		$windDirection = $this->getCurrentValue('wind.wind_direction');
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
		$result .= date('Y.m.d H:i', Arr::get($this->forecast, 'time')) . PHP_EOL;
		$result .= $this->getCurrentValue('outdoor.temperature', true) . PHP_EOL;
		$result .= 	__('Wind') . ': ' . $this->windRumb() . ' (' .
				$this->getCurrentValue('wind.wind_direction', true) . '), ' .
				$this->getCurrentValue('wind.wind_speed', true) . PHP_EOL;
		$result .= 	__('Wind gust') . ': ' . 
			$this->getCurrentValue('wind.wind_gust', true) . PHP_EOL;
		$result .= __('Barometer') . ': ' .
					$this->getCurrentValue('pressure.absolute', true) . PHP_EOL;
		$result .= __('Humidity') . ': ' .
					$this->getCurrentValue('outdoor.humidity', true) . PHP_EOL;
		if($this->getCurrentValue('rainfall.rain_rate') != 0){
			$result .= __('Rain') . ': ' .
			$this->getCurrentValue('rainfall.rain_rate', true) . PHP_EOL;
		}
		return $result;
	}

	/** Updates weather data from server */
	private function refresh()
	{
        $forecast = Http::get(env('ECOWITT_API_URL'), [
			'application_key' => env('ECOWITT_APP_KEY'),
			'api_key' => env('ECOWITT_API_KEY'),
			'mac' => env('ECOWITT_STATION_MAC'),
			'call_back' => 'all',
			'temp_unitid' => '1',
			'pressure_unitid' => '5',
			'wind_speed_unitid' => '6',
			'rainfall_unitid' => '12',
			'solar_irradiance_unitid' => '14',
			'capacity_unitid' => '24',
        ]);
        $this->forecast = $forecast->json();
	}

		/** Checks if stored forecast is out of time or not 
	 * 
	 * @param string|null $stored
	 * @return bool
	 * */
	private function isOutOfTime(string|null $stored): bool
	{
		if(empty($stored)) {
			return true;
		}
		$toCheck = json_decode($stored, true);
		$time = Arr::get($toCheck, 'time');
		return (time() - $time) > self::REFRESHING_TIME;
	}
}