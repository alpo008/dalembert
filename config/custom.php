<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google maps api settings
    |--------------------------------------------------------------------------
    |
    */

    'google_maps' => [
        'geocode_api_url' => env('GM_GEOCODE_API_URL'),
        'api_key' => env('GM_API_KEY'),
        'default_map_center' => env('GM_MAP_CENTER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Open meteo api settings
    |--------------------------------------------------------------------------
    |
    */

    'open_meteo' => [
        'api_url' => env('OPEN_METEO_API_URL')
    ],

    /*
    |--------------------------------------------------------------------------
    | Ecowitt api settings
    |--------------------------------------------------------------------------
    |
    */

    'ecowitt' => [
        'api_url' => env('ECOWITT_API_URL'),
        'api_key' => env('ECOWITT_API_KEY'),
        'app_key' => env('ECOWITT_APP_KEY'),
        'station_mac' => env('ECOWITT_STATION_MAC')
    ],

    /*
    |--------------------------------------------------------------------------
    | Telegram api settings
    |--------------------------------------------------------------------------
    |
    */

    'telegram' => [
        'api_url' => env('TG_API_URL'),
        'token' => env('TG_TOKEN')
    ],

    'default_timezone' => env('DEFAULT_TIMEZONE')

];
