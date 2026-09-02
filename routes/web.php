<?php

use Illuminate\Support\Facades\Route;

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
        return view('welcome'); // Points to resources/views/admin.blade.php
    })->where('any', '.*');
});

Route::get('/{any?}', function () {
    return view('frontend'); // Points to resources/views/frontend.blade.php
})->where('any', '.*');