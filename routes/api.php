<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AirmaxClientController;
use App\Http\Controllers\AttachmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('diagrams', DiagramController::class);
Route::apiResource('home', HomeController::class)->except(['create', 'update', 'destroy']);
Route::apiResource('airmax-clients', AirmaxClientController::class);
Route::apiResource('attachments', AttachmentController::class);
Route::post('upload', App\Http\Controllers\UploadController::class)->name('upload');

Route::get('attachments/{obj}/{id}', 'App\Http\Controllers\AttachmentController@show');

Route::prefix('auth')->group(function () {
        Route::post('register', 'App\Http\Controllers\AuthController@register');
        Route::post('login', 'App\Http\Controllers\AuthController@login');
        Route::get('refresh', 'App\Http\Controllers\AuthController@refresh');
        Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'App\Http\Controllers\AuthController@user');
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    });
});