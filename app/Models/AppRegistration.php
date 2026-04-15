<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;

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
    public function airmaxClient(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
