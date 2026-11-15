<?php

namespace App\Models;

use App\Models\TuyaDevice;

/**
 * This is the model class for Generic Tuya Device api
 *
 * @property float $temp_current
 * @property int $temp_current_time
 * @property float $temp_current_external
 * @property int $temp_current_external_time
 * @property int $humidity_value
 * @property int $humidity_value_time
 * @property string $battery_state
 * @property int $battery_state_time
 * @property float $temp_calibration
 * @property int $temp_calibration_time
 * @property int $hum_calibration
 * @property int $hum_calibration_time
 * @property float $temp_correction
 * @property int $temp_correction_time
 * 
 */

class TuyaThermometer extends TuyaDevice
{
	public $temp_current;
	public $temp_current_time;
	public $temp_current_external;
	public $temp_current_external_time;
	public $humidity_value;
	public $humidity_value_time;
	public $battery_state;
	public $battery_state_time;
    public $temp_calibration;
    public $temp_calibration_time;
    public $hum_calibration;
    public $hum_calibration_time;
    public $temp_correction;
    public $temp_correction_time;
}