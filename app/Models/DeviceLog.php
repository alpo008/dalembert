<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppRegistration;
use Illuminate\Database\Eloquent\Relations\hasMany;

class DeviceLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['model', 'platform', 'uuid', 'version', 'manufacturer', 'serial', 'action'];

    /**
     * Get the device application registrations.
     */
    public function appRegistrations(): hasMany
    {
        return $this->hasMany(AppRegistration::class, 'device_uuid', 'uuid')->with('customer');
    }
}
