<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cashier\Auth\CashierAuthController;
use App\Http\Controllers\Cashier\Site\CashierSiteController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localize',
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
        'CheckStoreCookies' 
    ],
    'as' => 'site.'
], function () {

    // Cashier routes (prefix cashier)
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('login', [CashierAuthController::class, 'showLoginForm'])
            ->name('login')->middleware('guest:cashier');

        Route::post('login', [CashierAuthController::class, 'login'])
            ->name('login.post')->middleware('guest:cashier');

        Route::post('logout', [CashierAuthController::class, 'logout'])
            ->name('logout')->middleware('auth:cashier');

        Route::middleware('auth:cashier')->group(function () {
            Route::get('/', [CashierSiteController::class, 'home'])->name('home');
            Route::get('categories', [CashierSiteController::class, 'categories'])->name('categories.index');
            Route::get('category/{slug}', [CashierSiteController::class, 'categoryShow'])->name('categories.show');

        });
    });

});
