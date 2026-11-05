<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hydrometry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HydrometriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hydrometries')->truncate();
        $path = base_path() . '/resources/data/kim/';
        $files = scandir($path);
        foreach($files as $filename) {
            if (in_array($filename, ['.', '..'])) {
                continue;
            }
            try {
                $handle = fopen($path . $filename, "r");
                $contents = fread($handle, filesize($path . $filename));
                if(!!strlen($contents)) {
                    $entries = json_decode($contents, true);
                    if(is_array($entries)) {
                        $hydrometry = array_find($entries, function( $entry) {
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
                }
                fclose($handle);
            } catch(Exception $e) {}
        }
    }
}
