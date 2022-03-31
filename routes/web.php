<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RegisterController;

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

Route::get('/', function () {
    return view('welcome');
});
// //Route::resource('service', ServiceController::class);
// Route::group(['middleware' => ['auth:sanctum']], function () {
// });
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [RegisterController::class, 'store']);
