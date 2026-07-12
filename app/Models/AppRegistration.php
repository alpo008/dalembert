<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Customer;
use App\Models\AppRegistration;
use App\Models\DeviceLog;

class AppRegistration extends Model
{
    use HasFactory;

    const APP_GWEATHER = 1;

    protected $fillable = ['device_uuid', 'device_serial', 'app_id', 'app_key', 'customer_id'];

    /**
     * Get the customer that owns apps.
     * 
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get logging events for registered application.
     * 
     * @return HasMany
     */
    public function deviceLogs(): HasMany
    {
        return $this->hasMany(DeviceLog::class, 'uuid', 'device_uuid');
    }

    /**
     * Get latest log for registered application.
     * 
     * @return HasOne
     */
    public function latestLog(): HasOne
    {
        return $this->hasOne(DeviceLog::class, 'uuid', 'device_uuid')->latestOfMany();
    }

    /**
     * List of available apps.
     *
     * @return array
     */
    public static function getAppsList(): array
    {
        return [
            self::APP_GWEATHER => 'Globus Meteo'
        ];
    }

    /**
     * Generates random string for application key.
     * 
     * @param  integer|string  $appId
     * @param  integer|string  $customerId
     *
     * @return string
     */
    public static function generateKey($appId, $customerId): string
    {
        do {
            $random = str_random(32);
        } while (!empty(self::firstWhere('app_key', $random)));
        return  '-' . $customerId . '[' . $appId . ']' . $random;
    }
}
