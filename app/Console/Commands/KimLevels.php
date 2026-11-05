<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Hydrometry;
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
        $url = config('custom.hydrometric.kim_levels_api_url');
        $levels = Http::get(config('custom.hydrometric.kim_levels_api_url'));
        $levelsArray = $levels->json();
        if(is_array($levelsArray)) {
            $hydrometry = array_find($levelsArray, function( $entry) {
                return $entry['object_id'] === Hydrometry::IV_OBJECT_ID;
            });
            $level_headwater_iv = $hydrometry['value_abs'];
            $updated_at = Carbon::createFromFormat('d.m.Y H:i', $hydrometry['measure_date_str'])->format('Y-m-d H:i:s');
            $newHydrometry = new Hydrometry();
            $newHydrometry->timestamps = false;
            $newHydrometry->level_headwater_iv = $level_headwater_iv * 100;
            $newHydrometry->updated_at = $updated_at;
            $newHydrometry->created_at = $updated_at;
            $newHydrometry->save();
        }
        return Command::SUCCESS;
    }
}
