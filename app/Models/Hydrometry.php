<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\TuyaThermometer;

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

    public function getWaterLevel()
    {
        return $this->level_headwater_iv ?? ($this->level_local ?? null);
    }

    public function getIceThickness()
    {
        return $this->ice_thickness_ext ?? ($this->ice_thickness_local ?? null);
    }

    public static function allData()
    {
        $tz = config('app.timezone');
        $today = static::where
            ('created_at', 'like', Carbon::now($tz)->format('Y-m-d') . '%')->first();
        $latest = static::whereNotNull('level_headwater_iv')->orWhereNotNull('level_local')
            ->orderBy('created_at', 'DESC')->first();
        $yesterday = static::where
            ('created_at', 'like', Carbon::yesterday($tz)->format('Y-m-d') . '%')->first();
        $weekAgo = static::where
            ('created_at', 'like', Carbon::now($tz)->subWeek()->format('Y-m-d') . '%')->first();
        $monthAgo = static::where
            ('created_at', 'like', Carbon::now($tz)->subMonth()->format('Y-m-d') . '%')->first();

        $perDay = ($today instanceof static && $yesterday instanceof static) ?
            [
                'level' => ($today->getWaterLevel() && $yesterday->getWaterLevel()) ? 
                    $today->getWaterLevel() - $yesterday->getWaterLevel() : 
                    null,
                'temp' => round($today->temp_local - $yesterday->temp_local, 1),
                'ice_thickness' => $today->getIceThickness() - $yesterday->getIceThickness()
            ] : null;
        $perWeek = ($today instanceof static && $weekAgo instanceof static) ?
            [
                'level' => ($today->getWaterLevel() && $weekAgo->getWaterLevel()) ? 
                    $today->getWaterLevel() - $weekAgo->getWaterLevel() : 
                    null,
                'temp' => round($today->temp_local - $weekAgo->temp_local, 1),
                'ice_thickness' => $today->getIceThickness() - $weekAgo->getIceThickness()
            ] : null;
        $perMonth = ($today instanceof static && $monthAgo instanceof static) ?
            [
                'level' => ($today->getWaterLevel() && $monthAgo->getWaterLevel()) ? 
                    $today->getWaterLevel() - $monthAgo->getWaterLevel() : 
                    null,
                'temp' => round($today->temp_local - $monthAgo->temp_local, 1),
                'ice_thickness' => $today->getIceThickness() - $monthAgo->getIceThickness()
            ] : null;

        if($today instanceof static && $level = $today->getWaterLevel()) {
            $nplRelative = $level - static::IV_NORMAL_POOL_LVL;
        } elseif ($latest instanceof static && $level = $latest->getWaterLevel()) {
            $nplRelative = $level - static::IV_NORMAL_POOL_LVL;
        } else {
            $nplRelative = null;
        }

        return [
            'current' => $today,
            'latest' => $latest,
            'perDay' => $perDay, 
            'perWeek' => $perWeek, 
            'perMonth' => $perMonth,
            'nplRelative' => $nplRelative,
            'history' => static::where
                ('created_at', '>', Carbon::now($tz)->subQuarter()->format('Y-m-d'))->get()->toArray(),
            'stats' => [
                'temp' => [
                    'avg' => round(static::avg('temp_local'), 1),
                    'min' => round(static::min('temp_local'), 1),
                    'max' => round(static::max('temp_local'), 1)
                ],
                'level_headwater_iv' => [
                    'avg' => round(static::avg('level_headwater_iv'), 1),
                    'min' => round(static::min('level_headwater_iv'), 1),
                    'max' => round(static::max('level_headwater_iv'), 1)
                ],
                'level_local' => [
                    'avg' => round(static::avg('level_local'), 1),
                    'min' => round(static::min('level_local'), 1),
                    'max' => round(static::max('level_local'), 1)
                ],
                'ice_thickness_local' => [
                    'avg' => round(static::avg('ice_thickness_local'), 1),
                    'min' => round(static::min('ice_thickness_local'), 1),
                    'max' => round(static::max('ice_thickness_local'), 1)
                ],
                'ice_thickness_ext' => [
                    'avg' => round(static::avg('ice_thickness_ext'), 1),
                    'min' => round(static::min('ice_thickness_ext'), 1),
                    'max' => round(static::max('ice_thickness_ext'), 1)
                ]
            ],
            'tempUnit' => new TuyaThermometer()->unit('temp_current')
        ];
    }
}
