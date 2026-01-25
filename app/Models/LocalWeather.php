<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

/**
 * This is the model class for Generic Meteostation api
 *
 * @property integer $updatedAt
 * @property float $temperature
 * @property string $temperatureUnit
 * @property float $feelsLike
 * @property string $feelsLikeUnit
 * @property float $dewPoint
 * @property string $dewPointUnit
 * @property float $humidity
 * @property string $humidityUnit
 * @property float $solar
 * @property string $solarUnit
 * @property integer $uvi
 * @property string $uviUnit
 * @property float $rainRate
 * @property string $rainRateUnit
 * @property float $windSpeed
 * @property string $windSpeedUnit
 * @property float $windGust
 * @property string $windGustUnit
 * @property integer $windDirection
 * @property string $windDirectionUnit
 * @property float $pressureAbsolute
 * @property string $pressureAbsoluteUnit
 * @property float $pressureRelative
 * @property string $pressureRelativeUnit
 */

class LocalWeather
{
	public $updatedAt;
	public $temperature;
	public $temperatureUnit;
	public $feelsLike;
	public $feelsLikeUnit;
	public $dewPoint;
	public $dewPointUnit;
	public $humidity;
	public $humidityUnit;
	public $solar;
	public $solarUnit;
	public $uvi;
	public $uviUnit;
	public $rainRate;
	public $rainRateUnit;
	public $windSpeed;
	public $windSpeedUnit;
	public $windGust;
	public $windGustUnit;
	public $windDirection;
	public $windDirectionUnit;
	public $pressureRelative;
	public $pressureRelativeUnit;


	/** Converts wind direction to rumbs 
	 * 
	 * @return string
	 * */
	public function windRumb(): string
	{
		if (!boolval($this->windDirection) || 
			($this->windSpeed === 0.0  && $this->windGust === 0.0)
		) {
			return "";
		}
		$rumb = $this->windDirection + 11.25;
		if ($rumb > 360) {
			$rumb = $rumb - 360;
		}
		$rumbs = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
		return $rumbs[floor($rumb / 22.5)];
	}

	/** Creates generic weather description
	 *
	 * @return string
	 * */
	public function description(): string
	{
		$result = '';
		$result .= date('Y.m.d H:i', $this->updatedAt) . PHP_EOL;
		$result .= $this->temperature . ' ' . __($this->temperatureUnit) . PHP_EOL;
		$windDirection = !empty($this->windRumb()) ? ' (' .
			$this->windDirection . ' ' . __($this->windDirectionUnit) . '), ' : '';
		$showWindGust = !!intval($this->windGust);
		$result .= 	__('Wind') . ': ' . $this->windRumb() . $windDirection .
				$this->windSpeed . ' ' . __($this->windSpeedUnit) .PHP_EOL;
		if ($showWindGust) {
			$result .= 	__('Wind gust') . ': ' . 
				$this->windGust . ' ' . __($this->windGustUnit) . PHP_EOL;
		}
		$result .= __('Barometer') . ': ' .
					$this->pressureAbsolute . ' ' . __($this->pressureAbsoluteUnit) . PHP_EOL;
		$result .= __('Humidity') . ': ' .
					$this->humidity . ' ' . __($this->humidityUnit) . PHP_EOL;
		if($this->rainRate != 0){
			$result .= __('Rain') . ': ' .
			$this->rainRate . ' ' . __($this->rainRateUnit) . PHP_EOL;
		}
		return $result;
	}
}