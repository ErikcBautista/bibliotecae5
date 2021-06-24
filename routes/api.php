<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\manage\PostController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
//definimos la ruta de acceso de la api, pasando como primer parametro a la ruta, seguido de la ubicacion del controlador

Route::apiResource('manage/libros', App\Http\Controllers\Api\Manage\LibroController::class)->middleware('api');



Route::group([

    'middleware' => 'api',
    'prefix' => 'manage/auth'

], function ($router) {
    //crear las subrutas
    //Route::post('login', 'AuthController@login');
    Route::post('login', [\App\Http\Controllers\Api\Manage\AuthController::class, 'login'])->name('login');
    //Route::post('logout', 'AuthController@logout');
    Route::post('logout', [\App\Http\Controllers\Api\Manage\AuthController::class, 'logout'])->name('logout');
   // Route::post('refresh', 'AuthController@refresh');
   Route::post('refresh', [\App\Http\Controllers\Api\Manage\AuthController::class, 'refresh'])->name('refresh');
    //Route::post('me', 'AuthController@me');
    Route::post('me', [\App\Http\Controllers\Api\Manage\AuthController::class, 'me'])->name('me');
    //ruta para el registro
    Route::post('register', [\App\Http\Controllers\Api\Manage\UserController::class, 'store'])->name('store');

});