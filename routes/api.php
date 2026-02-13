<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SystemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AIController;
use App\Http\Controllers\Api\DeliveryTrackingController;

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

// ==================== AI MODULE ====================
Route::prefix('ai')->group(function () {
    // Menu Descriptions
    Route::post('/menu-description', [AIController::class, 'generateMenuDescription']);
    Route::post('/bulk-menu-descriptions', [AIController::class, 'generateBulkMenuDescriptions']);
    Route::post('/seo-title', [AIController::class, 'generateSEOTitle']);
    Route::post('/restaurant-bio', [AIController::class, 'generateRestaurantBio']);
    
    // Support & Analysis
    Route::post('/support-response', [AIController::class, 'generateSupportResponse']);
    Route::post('/daily-specials', [AIController::class, 'suggestDailySpecials']);
    Route::post('/review-sentiment', [AIController::class, 'analyzeReviewSentiment']);
    Route::post('/delivery-instructions', [AIController::class, 'generateDeliveryInstructions']);
    
    // Image Generation
    Route::post('/generate-image', [AIController::class, 'generateFoodImage']);
    Route::post('/generate-restaurant-image', [AIController::class, 'generateRestaurantImage']);
    Route::post('/generate-category-banner', [AIController::class, 'generateCategoryBanner']);
    Route::post('/custom-image', [AIController::class, 'customImage']);
});
