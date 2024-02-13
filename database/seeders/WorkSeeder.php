<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Work;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = base_path() . '/resources/data/works.json';
        $jsonString = file_get_contents($filePath);
        $works = json_decode($jsonString, true);
        foreach($works as $work) {
            $newWork = new Work($work);
            try {               
                $newWork->save(); 
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";  
            }
        }
    }
}
