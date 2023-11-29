<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AirmaxClient;
use Carbon\Carbon;

class AirmaxClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = base_path() . '/resources/data/clients.json';
        $jsonString = file_get_contents($filePath);
        $airmaxClients = json_decode($jsonString, true);
        foreach($airmaxClients as $clientData) {
            $isValid = !!$clientData['place'] & !!$clientData['ip_address'];
            if(!!$isValid) {
                $newAirmaxClient = new AirMaxClient([
                    'place' => $clientData['place'],
                    'location' => $this->convertLocation($clientData['location']),
                    'name' => $clientData['name'] ? $clientData['name'] : $clientData['place'],
                    'email' => !empty($clientData['email']) ? $clientData['email'] : null,
                    'phone' => $clientData['phone'],
                    'wlan_mac' => $clientData['wlan_mac'],
                    'lan_mac' => $clientData['lan_mac'],
                    'ap_mac' => $clientData['ap_mac'],
                    'ip_address' => $clientData['ip_address'],
                    'ap_model' => $clientData['model'],
                    'router_mac' => $clientData['router_mac'],
                    'router_ip_address' => $clientData['router_lan_ip'],
                    'ssid' => $clientData['ssid'] ? $clientData['ssid'] : null,
                    'password' => $clientData['password'] ? $clientData['password'] : null,
                    'installed_on' => $this->convertDate($clientData['installed_on']),
                    'router_model' => $clientData['router'],
                    'admin' => $clientData['admin']
                ]);
                $newAirmaxClient->save();
            }  
        }
    }

    /** 
     * Format location string as valid json
     * 
     * @param string|null $location
     * @return string|null
     */
    private function convertLocation (string|null $location):string|null 
    {
        $result = null;
        $pattern = '/\(\d+(\.\d{0,}),\-?\d+(\.\d{0,}\))/';
        if (preg_match($pattern, $location)) {
            $coords = explode(',', str_replace(['(', ')'], '', $location));
            if(!empty($coords) && is_array($coords) && count($coords) === 2) {
                $locationArray = ['lat' => $coords[0], 'lng' => $coords[1]];
                $result = json_encode($locationArray);
            }
        }
        return $result;
    }
    
    /** 
     * Format date string as valid timestamp
     * 
     * @param string|null $date
     * @return string|null
     */
    private function convertDate (string|null $date):string|null
    {
        $result = null;
        $pattern = '/(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[012])\.(19|20)\d\d/';
        if (preg_match($pattern, $date)) {
            $result = Carbon::createFromFormat('d.m.Y', $date)->toDateTimeString();
        }
        return $result;
    }
}
