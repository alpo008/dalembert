<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AirmaxClient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place', 'name', 'email', 'location', 'phone', 'ap_model', 'wlan_mac', 'lan_mac', 'ap_mac', 'ip_address', 
        'router_model', 'router_mac', 'router_ip_address', 'ssid', 'password', 'installed_on', 'admin'
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'password' => 'encrypted',
        'admin' => 'encrypted',
        'installed_on' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        //'location' => 'array'
    ];

    /**
     * Get all of the clients's payments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payer');
    }


    /**
     * Format installed_on date.
     */
    protected function installedOn(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d.m.Y')
        );
    }
}
