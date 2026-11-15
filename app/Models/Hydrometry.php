<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hydrometry extends Model
{
    use HasFactory;

    const IV_OBJECT_ID = '211';
    const IV_NORMAL_POOL_LVL = 12389;       // НПУ
    const IV_SURCHARGE_POOL_LVL = 12409;    // ФПУ
    const IV_DEAD_STORAGE_LVL = 11939;      // УМО

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
