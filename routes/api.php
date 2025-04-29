<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\HealthCheckController;
use App\Http\Controllers\API\Subscription\SubscriptionController;
use App\Http\Controllers\API\SubscriptionPlanController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::middleware(['api.key', 'throttle:api'])->group(function () {
        Route::post('central-admin/company/onboarding', [CompanyController::class, 'onboarding']);
        Route::post('central-admin/test-controller', [TestController::class, 'createSubscriptionPlans']);
        Route::get('central-admin/subscription-plans', [SubscriptionPlanController::class, 'index']);
        Route::post('central-admin/sync/subscription', [SubscriptionController::class,'syncSubscription']);
    });
});

Route::get('/health-check', [HealthCheckController::class, 'index']);
Route::post('/send-email', [HealthCheckController::class, 'sendEmail']);
