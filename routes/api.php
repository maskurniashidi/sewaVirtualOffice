<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityServiceController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/service', [ServiceController::class, 'store']);
Route::get('/service', [ServiceController::class, 'index']);
Route::get('/service/{id}', [ServiceController::class, 'show']);
Route::patch('/service/{id}', [ServiceController::class, 'update']);
Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

Route::post('/image', [ImageController::class, 'store']);
Route::patch('/image/{id}', [ImageController::class, 'update']);
Route::get('/image/{id}', [ImageController::class, 'show']);
Route::delete('/image/{id}', [ImageController::class, 'destroy']);


Route::post('/price', [PriceController::class, 'store']);
Route::patch('/price/{id}', [PriceController::class, 'update']);
Route::get('/price/{id}', [PriceController::class, 'show']);
Route::delete('/price/{id}', [PriceController::class, 'destroy']);

Route::get('/facility/{id}', [FacilityController::class, 'show']);
Route::post('/facility', [FacilityController::class, 'store']);
Route::patch('/facility/{id}', [FacilityController::class, 'update']);
Route::delete('/facility/{id}', [FacilityController::class, 'destroy']);

Route::get('/facility-service/{id}', [FacilityServiceController::class, 'show']);
Route::post('/facility-service', [FacilityServiceController::class, 'store']);
Route::patch('/facility-service/{id}', [FacilityServiceController::class, 'update']);
Route::delete('/facility-service/{id}', [FacilityServiceController::class, 'destroy']);
