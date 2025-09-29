<?php

use App\Http\Controllers\Api\Management\OrderController;
use App\Http\Controllers\Api\Management\ProjectController;
use App\Http\Controllers\Api\Management\ManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PaymentController;
use App\Http\Controllers\Site\ProfileCardsController;
use App\Http\Controllers\Api\Test\NotficationTestController;
use App\Http\Controllers\Api\DonorAuthController;

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

Route::group([
    'as' => 'api.'
], function () {
    // Donor Authentication Routes
    Route::prefix('donor')->group(function () {
        Route::post('send-otp', [DonorAuthController::class, 'sendOtp']);
        Route::post('verify-otp', [DonorAuthController::class, 'verifyOtp']);
        
        // Protected routes
        Route::middleware('auth:donor')->group(function () {
            Route::get('me', [DonorAuthController::class, 'me']);
            Route::post('logout', [DonorAuthController::class, 'logout']);
            Route::post('refresh', [DonorAuthController::class, 'refresh']);
        });
    });

    // payment apis
    Route::any('payfort-intital', [PaymentController::class, 'authorizateResponse'])->name('payfort-intital');
    Route::any('payfort-purchase', [PaymentController::class, 'purchaseResponse'])->name('payfort-purchase');


    Route::any('payfort-respond-card', [ProfileCardsController::class, 'payfortrespondSaveCard'])->name('profile.cards.payfortrespondSaveCard'); // save card [update status 1]

    // Test Notfication
    Route::POST('notfication-whatsapp', [NotficationTestController::class, 'whatsapp']);
    Route::POST('notfication-sms', [NotficationTestController::class, 'sms']);
    Route::POST('notfication-email', [NotficationTestController::class, 'email']);


     // Start Api Management System --------------------------------------------

     Route::group([
         'prefix' => 'management',
         'middleware' => ['api']
     ], function () {
         Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
         Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
         Route::apiResource('projects', ProjectController::class)->only(['index']);
         Route::apiResource('managers', ManagerController::class)->only(['index']);
         Route::apiResource('refers', \App\Http\Controllers\Api\Management\ReferController::class);
         
         // Charity Projects API
         Route::prefix('charity-projects')->group(function () {
             Route::get('/', [\App\Http\Controllers\Api\Management\CharityProjectController::class, 'index']);
             Route::get('/{id}', [\App\Http\Controllers\Api\Management\CharityProjectController::class, 'show']);
         });
     });
     // End Api Management kafara --------------------------------------

});
