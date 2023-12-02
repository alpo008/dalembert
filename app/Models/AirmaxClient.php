<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AirmaxClient extends Model
{
    use HasFactory;

    protected $casts = [
        'password' => 'encrypted',
        'admin' => 'encrypted',
        'installed_on' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        //'location' => 'array'
    ];

    //protected $dateFormat = 'U';

    /**
     * Get the user's first name.
     */
    protected function installedOn(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d.m.Y')
        );
    }
}
