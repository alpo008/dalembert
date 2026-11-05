<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hydrometry extends Model
{
    use HasFactory;

    const IV_OBJECT_ID = '211';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level_headwater_iv', 'level_local', 'temp_ext', 'temp_local', 'ice_thickness_ext', 
        'ice_thickness_local', 'turbulence'
    ];
}
