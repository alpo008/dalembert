<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Hydrometry;
use App\Models\TuyaThermometer;
use Carbon\Carbon;

class KimLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kim:levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get water levels from KIM api';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        $url = config('custom.hydrometric.kim_levels_api_url');
        $levels = Http::get(config('custom.hydrometric.kim_levels_api_url'));
        $levelsArray = $levels->json();
        $level_is_actual = false;
        $is_new = false;
        if(is_array($levelsArray)) {
            $hydrometryData = array_find($levelsArray, function( $entry) {
                return $entry['object_id'] === Hydrometry::IV_OBJECT_ID;
            });
            $level_headwater_iv = $hydrometryData['value_abs'];
            $measure_date = $hydrometryData['measure_date_str'];
            $measured = Carbon::createFromFormat('d.m.Y H:i', $measure_date)
                ->format('Y-m-d');
            $created_at = Carbon::createFromFormat('d.m.Y H:i', $measure_date)
                ->format('Y-m-d H:i:s');
            $level_is_actual = $measured === $today;
        }

        $thermometer = TuyaThermometer::make('2.0', config('custom.tuya.devices.thermometer.id'));
        if($thermometer instanceof TuyaThermometer && !empty($thermometer->temp_current_external)) {
            $temp_local = $thermometer->temp_current_external / 10;
        }

        if(!empty($level_headwater_iv) || !empty($temp_local)) {
            if (!empty($measured)) {
                $hydrometry = Hydrometry::where('created_at', 'like', $measured . '%')->first();
            }
            if(empty($hydrometry)) {
                $hydrometry = new Hydrometry();
                $is_new = true;
            }
            
            // Update parameter if null
            if (is_null($hydrometry->level_headwater_iv) && !empty($level_headwater_iv)) {
                $hydrometry->level_headwater_iv = $level_headwater_iv * 100;
            }
            if (is_null($hydrometry->temp_local) && !empty($temp_local) && $level_is_actual) {
                $hydrometry->temp_local = $temp_local;
            }
            if(!empty($created_at) && $is_new) {
                $hydrometry->timestamps = false;
                if(empty($hydrometry->created_at)) {
                    $hydrometry->created_at = $created_at;
                }
                if(empty($hydrometry->updated_at) && !empty($hydrometry->created_at)) {
                    $hydrometry->updated_at = $created_at;
                }
            }
            $hydrometry->save();
            if(!$level_is_actual && !empty($temp_local)) {
                Hydrometry::create(compact('temp_local'));
            }
        }
        return Command::SUCCESS;
    }
}
