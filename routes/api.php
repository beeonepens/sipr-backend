<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;

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
    Route::put('update/{id}', [UserController::class, 'update']);
    Route::get('show', [UserController::class, 'show']);
});

Route::group(['prefix' => 'meet', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MeetController::class, 'index']);
    Route::get('show', [MeetController::class, 'show']);
    Route::post('store', [MeetController::class, 'store']);
    Route::put('update/{id}', [MeetController::class, 'update']);
    Route::delete('delete/{id}', [MeetController::class, 'destroy']);
});


Route::group(['prefix' => 'room', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('show', [RoomController::class, 'show']);
    Route::post('store', [RoomController::class, 'store']);
    Route::put('update/{id}', [RoomController::class, 'update']);
    Route::delete('delete/{id}', [RoomController::class, 'destroy']);
});

Route::group(['prefix' => 'invite', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [InvitationController::class, 'index']);
    Route::get('show', [InvitationController::class, 'show']);
    Route::post('store', [InvitationController::class, 'store']);
    Route::put('update/{id}', [InvitationController::class, 'update']);
    Route::delete('delete/{id}', [InvitationController::class, 'destroy']);
});

Route::group(['prefix' => 'team', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TeamController::class, 'index']);
    Route::get('show', [TeamController::class, 'show']);
    Route::get('member/{id}', [TeamController::class, 'showMember']);
    Route::post('store', [TeamController::class, 'store']);
    Route::put('update/{id}', [TeamController::class, 'update']);
    Route::delete('delete/{id}', [TeamController::class, 'destroy']);
    Route::delete('delete/member/{id}/{id_member}', [TeamController::class, 'deleteMember']);
    Route::post('join', [TeamController::class, 'join']);
});

Route::group(['prefix' => 'notif', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::get('show', [NotificationController::class, 'show']);
    Route::post('store', [NotificationController::class, 'store']);
    Route::put('update/{id}', [NotificationController::class, 'update']);
    Route::delete('delete/{id}', [NotificationController::class, 'destroy']);
});
