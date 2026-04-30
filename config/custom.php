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
        'api_history_url' => env('ECOWITT_API_HISTORY_URL'),
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

    /*
    |--------------------------------------------------------------------------
    | Logger api settings
    |--------------------------------------------------------------------------
    |
    */

    'logger' => [
        'api_url' => env('LOGGER_API_URL'),
        'api_key' => env('GLOBUS_API_KEY')
    ],

    /*
    |--------------------------------------------------------------------------
    | Site settings
    |--------------------------------------------------------------------------
    |
    */

    'site' => [
        'admin_email' => env('SITE_ADMIN_EMAIL'),
        'dev_email' => env('SITE_DEV_EMAIL')
    ],

    'default_timezone' => env('DEFAULT_TIMEZONE')

];
