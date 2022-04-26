<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('user', [UserController::class, 'index']);
Route::post('user/store', [UserController::class, 'store']);



Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::post('update/{id}', [UserController::class, 'update']);
});

Route::group(['prefix' => 'meet', 'middleware' => 'auth:sanctum'], function () {
    Route::get('show/{id}', [MeetController::class, 'show']);
    Route::post('store', [MeetController::class, 'store']);
    Route::put('update/{id}', [MeetController::class, 'update']);
    Route::delete('delete/{id}', [MeetController::class, 'destroy']);
});
