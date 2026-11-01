<?php

use Illuminate\Support\Facades\Route;
use App\Models\SiteSetting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::get('/{any?}', function () {
        return view('welcome');     // Points to resources/views/admin.blade.php
    })->where('any', '.*');
});

$site_settings = SiteSetting::where('locale', '=', config('app.locale'))->get();
Route::get('/{any?}', function () use($site_settings) {
    return view('frontend', [       // Points to resources/views/frontend.blade.php
        'title' => $site_settings->firstWhere('key', 'meta:title'),
        'description' => $site_settings->firstWhere('key', 'meta:description')
    ]); 
})->where('any', '.*');