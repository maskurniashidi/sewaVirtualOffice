<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacilityServiceController;
use App\Http\Controllers\RentController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin/register', [AuthController::class, 'registerAdmin']);

Route::get('/service', [ServiceController::class, 'index']);
Route::get('/service/{id}', [ServiceController::class, 'show']);

Route::get('/image/{id}', [ImageController::class, 'show']);

Route::get('/price/{id}', [PriceController::class, 'show']);

Route::get('/facility/{id}', [FacilityController::class, 'show']);
Route::get('/facility-service/{id}', [FacilityServiceController::class, 'show']);

//Route yang bisa diakses oleh user(pembeli) yang sudah login
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::get('/rent/{id}', [RentController::class, 'show']);
    Route::post('/rent', [RentController::class, 'store']);
    Route::patch('/rent/{id}', [RentController::class, 'update']);
    Route::delete('/rent/{id}', [RentController::class, 'destroy']);

    Route::get('/user/history/{id}', [RentController::class, 'getRentHistory']);
});

//Route yang bisa diakses oleh admin yang sudah login
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/service', [ServiceController::class, 'store']);
    Route::patch('/service/{id}', [ServiceController::class, 'update']);
    Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

    Route::delete('/image/{id}', [ImageController::class, 'destroy']);
    Route::post('/image', [ImageController::class, 'store']);
    Route::patch('/image/{id}', [ImageController::class, 'update']);

    Route::post('/price', [PriceController::class, 'store']);
    Route::patch('/price/{id}', [PriceController::class, 'update']);
    Route::delete('/price/{id}', [PriceController::class, 'destroy']);

    Route::post('/facility', [FacilityController::class, 'store']);
    Route::patch('/facility/{id}', [FacilityController::class, 'update']);
    Route::delete('/facility/{id}', [FacilityController::class, 'destroy']);

    Route::post('/facility-service', [FacilityServiceController::class, 'store']);
    Route::patch('/facility-service/{id}', [FacilityServiceController::class, 'update']);
    Route::delete('/facility-service/{id}', [FacilityServiceController::class, 'destroy']);

    Route::get('/rent', [RentController::class, 'index']);
});
