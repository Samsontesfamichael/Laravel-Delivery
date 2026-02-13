<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SystemController;
use App\Http\Controllers\Api\OrderController;

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

// ==================== SYSTEM MONITORING ====================
Route::get('/system/status', [SystemController::class, 'status']);
Route::get('/system/health', [SystemController::class, 'health']);

// ==================== ORDERS ====================
Route::get('/orders/pending', [OrderController::class, 'pending']);
Route::get('/orders/today', [OrderController::class, 'today']);
Route::get('/orders/stats', [OrderController::class, 'stats']);

// ==================== RESTAURANTS ====================
Route::apiResource('restaurants', Api\RestaurantController::class);

// ==================== DRIVERS ====================
Route::apiResource('drivers', Api\DriverController::class);

// ==================== USERS ====================
Route::apiResource('users', Api\UserController::class);

// ==================== NOTIFICATIONS ====================
Route::post('/notify/telegram', [SystemController::class, 'sendTelegram']);
Route::post('/notify/whatsapp', [SystemController::class, 'sendWhatsApp']);
