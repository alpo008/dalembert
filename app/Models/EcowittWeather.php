<?php

namespace App\Models;

use App\Models\LocalWeather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * This is the model class for Ecowitt Meteostation api
 */

class EcowittWeather extends LocalWeather
{
	const REFRESHING_TIME = 180;  //TODO
	const HISTORY_REFRESHING_TIME = 7200;  //TODO
	const SECONDS_IN_MONTH = 60 * 60 * 24 * 30;  //TODO

	public function __construct($params = [])
	{
		parent::__construct($params);
		$stored = Storage::disk('local')->get('meteo/ecowitt.json');
		if($this->isOutOfTime($stored)) {
			$this->refresh();
			Storage::disk('local')->put('meteo/ecowitt.json', 
				json_encode($this->weatherData, JSON_PRETTY_PRINT)
			);
		} else {
			$this->weatherData = json_decode($stored, true);
		}

		$this->updatedAt = intval(Arr::get($this->weatherData, 'time'));
		$this->temperature = floatval(Arr::get($this->weatherData, 
			"data.outdoor.temperature.value"
		));
		$this->temperatureUnit = Arr::get($this->weatherData, 
			"data.outdoor.temperature.unit"
		);
		$this->feelsLike = floatval(Arr::get($this->weatherData, 
			"data.outdoor.feels_like.value"
		));
		$this->feelsLikeUnit = Arr::get($this->weatherData, 
			"data.outdoor.feels_like.unit"
		);
		$this->dewPoint = floatval(Arr::get($this->weatherData, 
			"data.outdoor.dew_point.value"
		));
		$this->dewPointUnit = Arr::get($this->weatherData, 
			"data.outdoor.dew_point.unit"
		);
		$this->humidity = floatval(Arr::get($this->weatherData, 
			"data.outdoor.humidity.value"
		));
		$this->humidityUnit = Arr::get($this->weatherData, 
			"data.outdoor.humidity.unit"
		);
		$this->solar = floatval(Arr::get($this->weatherData, 
			"data.solar_and_uvi.solar.value"
		));
		$this->solarUnit = Arr::get($this->weatherData, 
			"data.solar_and_uvi.solar.unit"
		);
		$this->uvi = intval(Arr::get($this->weatherData, 
			"data.solar_and_uvi.uvi.value"
		));
		$this->uviUnit = Arr::get($this->weatherData, 
			"data.solar_and_uvi.uvi.unit"
		);
		$this->rainRate = floatval(Arr::get($this->weatherData, 
			"data.rainfall.rain_rate.value"
		));
		$this->rainRateUnit = Arr::get($this->weatherData, 
			"data.rainfall.rain_rate.unit"
		);
		$this->windSpeed = floatval(Arr::get($this->weatherData, 
			"data.wind.wind_speed.value"
		));
		$this->windSpeedUnit = Arr::get($this->weatherData, 
			"data.wind.wind_gust.unit"
		);
		$this->windGust = floatval(Arr::get($this->weatherData, 
			"data.wind.wind_gust.value"
		));
		$this->windGustUnit = Arr::get($this->weatherData, 
			"data.wind.wind_gust.unit"
		);
		$this->windDirection = intval(Arr::get($this->weatherData, 
			"data.wind.wind_direction.value"
		));
		$this->windDirectionUnit = Arr::get($this->weatherData, 
			"data.wind.wind_direction.unit"
		);
		$this->pressureRelative = floatval(Arr::get($this->weatherData, 
			"data.pressure.relative.value"
		));
		$this->pressureRelativeUnit = Arr::get($this->weatherData, 
			"data.pressure.relative.unit"
		);
		$this->pressureAbsolute = floatval(Arr::get($this->weatherData, 
			"data.pressure.absolute.value"
		));
		$this->pressureAbsoluteUnit = Arr::get($this->weatherData, 
			"data.pressure.absolute.unit"
		);

		$storedHistory = Storage::disk('local')->get('meteo/ecowitt_history.json');
		if($this->historyIsOutOfTime($storedHistory)) {
			$this->refreshHistory();
			Storage::disk('local')->put('meteo/ecowitt_history.json', 
				json_encode($this->historyData, JSON_PRETTY_PRINT)
			);
		} else {
			$this->historyData = json_decode($storedHistory, true);
		}
	}

	/** Returns weather data as array */
	public function all()
	{
		return $this->weatherData;
	}

	/** Returns history data as array */
	public function history()
	{
		return $this->historyData;
	}

	/** Updates weather data from server */
	private function refresh()
	{
        $weatherData = Http::get(config('custom.ecowitt.api_url'), [
			'application_key' => config('custom.ecowitt.app_key'),
			'api_key' => config('custom.ecowitt.api_key'),
			'mac' => config('custom.ecowitt.station_mac'),
			'call_back' => 'all',
			'temp_unitid' => '1',
			'pressure_unitid' => '5',
			'wind_speed_unitid' => '6',
			'rainfall_unitid' => '12',
			'solar_irradiance_unitid' => '14',
			'capacity_unitid' => '24',
        ]);
        $this->weatherData = $weatherData->json();
	}

	/** Updates weather history data from server */
	private function refreshHistory() {
        $now = time();
        $format = 'Y-m-d H:i:s';
        $currentDate = date($format, $now);
        $monthAgo = date($format, $now - self::SECONDS_IN_MONTH);
        $historyData = Http::get(config('custom.ecowitt.api_history_url'), [
			'application_key' => config('custom.ecowitt.app_key'),
			'api_key' => config('custom.ecowitt.api_key'),
			'mac' => config('custom.ecowitt.station_mac'),
	        'start_date' => $monthAgo,
	        'end_date' => $currentDate,
	        'cycle_type' => 'auto',
	        'cycle_type' => 'auto',
	        'call_back'  => 'outdoor,pressure,solar_and_uvi,wind,rainfall',
	        'temp_unitid'  => '1',
	        'pressure_unitid'  => '5',
	        'wind_speed_unitid'  => '6',
	        'rainfall_unitid'  => '12',
	        'solar_irradiance_unitid'  => '14',
	        'capacity_unitid'  => '24'
        ]);
        $this->historyData = $historyData->json();
	}

	/** Checks if stored weather data is out of time or not 
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

	/** Checks if stored weather history is out of time or not 
	 * 
	 * @param string|null $stored
	 * @return bool
	 * */
	private function historyIsOutOfTime(string|null $stored): bool
	{
		if(empty($stored)) {
			return true;
		}
		$toCheck = json_decode($stored, true);
		$time = Arr::get($toCheck, 'time');
		return (time() - $time) > self::HISTORY_REFRESHING_TIME;
	}
}
