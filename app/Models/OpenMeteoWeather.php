<?php 

namespace App\Models;

use App\Models\LocalWeather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class OpenMeteoWeather extends LocalWeather
{
	const REFRESHING_TIME = 1200;  //TODO

	public function __construct($params = [])
	{
		parent::__construct($params);
		$stored = Storage::disk('local')->get('meteo/openmeteo.json');
		if($this->isOutOfTime($stored)) {
			$this->refresh();
			Storage::disk('local')->put('meteo/openmeteo.json', 
				json_encode($this->weatherData, JSON_PRETTY_PRINT)
			);
		} else {
			$this->weatherData = json_decode($stored, true);
		}

		$this->updatedAt = intval(Arr::get($this->weatherData, 'current.time'));
		$this->temperature = floatval(Arr::get($this->weatherData, 'current.temperature_2m'));
		$this->temperatureUnit = Arr::get($this->weatherData, 
			'current_units.temperature_2m'
		);
		$this->dewPoint = floatval(Arr::get($this->weatherData, 'current.dew_point_2m'));
		$this->dewPointUnit = Arr::get($this->weatherData, 
			'current_units.dew_point_2m'
		);
		$this->feelsLike = floatval(Arr::get($this->weatherData, 
			'current.apparent_temperature'));
		$this->feelsLikeUnit = Arr::get($this->weatherData, 
			'current_units.apparent_temperature'
		);
		$this->humidity = floatval(Arr::get($this->weatherData, 
			'current.relative_humidity_2m')
		);
		$this->humidityUnit = Arr::get($this->weatherData, 
			'current_units.relative_humidity_2m'
		);
		$this->windSpeed = floatval(Arr::get($this->weatherData, 
			'current.wind_speed_10m')
		);
		$this->windSpeedUnit = Arr::get($this->weatherData, 
			'current_units.wind_speed_10m'
		);
		$this->windDirection = intval(Arr::get($this->weatherData, 
			'current.wind_direction_10m')
		);
		$this->windDirectionUnit = Arr::get($this->weatherData, 
			'current_units.wind_direction_10m'
		);
		$this->windGust = floatval(Arr::get($this->weatherData, 
			'current.wind_gusts_10m')
		);
		$this->windGustUnit = Arr::get($this->weatherData, 
			'current_units.wind_gusts_10m'
		);
		$this->rainRate = floatval(Arr::get($this->weatherData, 
			'current.rain')
		);
		$this->rainRateUnit = Arr::get($this->weatherData, 
			'current_units.rain'
		);
		$this->pressureRelative = floatval(Arr::get($this->weatherData, 
			'current.surface_pressure')
		);
		$this->pressureRelativeUnit = Arr::get($this->weatherData, 
			'current_units.surface_pressure'
		);
		$this->solar = floatval(Arr::get($this->weatherData, 
			'current.diffuse_radiation')
		);
		$this->solarUnit = Arr::get($this->weatherData, 
			'current_units.diffuse_radiation'
		);
	}


	/** Gets weather parameters values with or without units 
	 *
	 * @param string $name
	 * @param bool $withUnit
	 * @return string
	 * */
	public function getCurrentValue($name, $withUnit = false): string
	{
		$result = Arr::get($this->weatherData, 
			"current.$name"
		);
		if($withUnit) {
			$result .= ' ' . __(Arr::get($this->weatherData, 
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
		$result .= date('Y.m.d H:i', $this->getCurrentValue('time')) . PHP_EOL;
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
        $coords = json_decode(config('custom.google_maps.default_map_center'), true);
		$openMeteoApiUrl = config('custom.open_meteo.api_url');
            $weatherData = Http::get($openMeteoApiUrl , [
                'latitude' => $this->location['lat'],
                'longitude' => $this->location['lng'],
                'daily' => ['sunrise', 'sunset'],
                'current' => [
            	'temperature_2m',
            	'dew_point_2m',
            	'apparent_temperature',
            	'relative_humidity_2m',
            	'rain',
	            'showers',
             	'wind_speed_10m',
             	'wind_gusts_10m',
             	'wind_direction_10m',
             	'surface_pressure',
             	'snowfall',
             	'snow_depth',
             	'diffuse_radiation',
             	'weather_code'
             ],
                             'current_weather' => true,
            'windspeed_unit'=> 'ms',
            'timezone' => config('custom.default_timezone'),
            'timeformat' => 'unixtime'
            ]);
        $this->weatherData = $weatherData->json();
	}

	/** Checks if stored weatherData is out of time or not 
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
		$time = Arr::get($toCheck, 'current.time');
		return (time() - $time) > self::REFRESHING_TIME;
	}
}