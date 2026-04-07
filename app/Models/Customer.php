<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\Coords;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AppRegistration;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'location', 'address', 'comments'];

    public $timestamps = false;

    /**
     *
     * @return array
     */
    protected $casts = [
        'location' => Coords::class
    ];

    /**
     * Get the customer's registered apps.
     * @return HasMany
     */
    public function registeredApps(): HasMany
    {
        return $this->hasMany(AppRegistration::class);
    }


}
