<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DomainController;
// use App\Http\Controllers\Admin\Cms\MenueController; // disabled
// use App\Http\Controllers\Admin\Cms\PagesController; // disabled
// use App\Http\Controllers\Admin\Cms\NewsController; // disabled
// use App\Http\Controllers\Admin\Cms\SliderController; // disabled
// use App\Http\Controllers\Admin\Cms\ContactUsController; // disabled
// use App\Http\Controllers\Admin\Cms\CategoryController; // disabled
// use App\Http\Controllers\Admin\Cms\ArticlesContoller; // disabled
// use App\Http\Controllers\Admin\Cms\TagController; // disabled
// use App\Http\Controllers\Admin\Cms\PortfolioController; // disabled
// use App\Http\Controllers\Admin\Cms\PortfolioTagController; // disabled
// use App\Http\Controllers\Admin\Cms\ProjectsController; // disabled
// use App\Http\Controllers\Admin\Cms\ServicesController; // disabled
// use App\Http\Controllers\Admin\Cms\SettingsController; // disabled
// use App\Http\Controllers\Admin\Cms\ThemesController; // disabled
// use App\Http\Controllers\Admin\Cms\PaymentMethodController; // disabled
// use App\Http\Controllers\Admin\Cms\MediaController; // disabled
use App\Http\Controllers\Admin\Authorizations\RolesController;
use App\Http\Controllers\Admin\OrdersController; // added
use App\Http\Controllers\Admin\RefersController; // added
use App\Http\Controllers\Admin\ManagersController; // added
// use App\Http\Controllers\Admin\Cms\SubscribesController; // disabled
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//   prefix Languages
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localeCookieRedirect'], // Route translate middleware
], function () {

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/', function () {
            return redirect()->route('admin.home');
        });
        
        // AUTH PAGES ---------------------------------------------------------------------
        Route::group(['middleware' => 'RedirectDashboard'], function () {
            Route::controller(AuthController::class)->group(function () {
                Route::get('login', 'showLogin')->name('login');
                Route::post('login', 'login')->name('login_post');
            });
        });

        // Dashboard Pages ---------------------------------------------------------------
        Route::group(['middleware' => 'CheckAdminAuth'], function () {

            Route::controller(AuthController::class)->group(function () {
                Route::post('logout', 'logout')->name('logout');
            });

            Route::group([], function () {

                Route::controller(DashboardController::class)->group(function () {
                    Route::get('dashboard', 'home')->name('home');
                    Route::get('switch-dark-mode', 'switchMode')->name('switch-dark-mode');
                    Route::get('update-color-header', 'updateColorHeader')->name('update-color-header');
                    Route::get('update-color-side', 'updateColorSide')->name('update-color-side');
                    Route::get('fetch-store-statistics', 'fetchStoreStatistics')->name('fetch-store-statistics');
                });

                // ---------------------- Profile ---------------------------------//
                Route::get('profile', [ProfileController::class, 'index'])->name('profile');
                Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
                // ---------------------- End Profile -----------------------------//

                // ----- Admins ----------------------------------------------------
                Route::resource('users', AdminController::class);
                Route::post('users/actions', [AdminController::class, 'actions'])->name('users.actions');
                Route::get('users/update-status/{id}', [AdminController::class, 'update_status'])->name('users.update-status');
                //--------------- End Admins ------------------------------------//

                // ----- Authorization -----------------------------------------------
                Route::resource('roles', RolesController::class);
                // ----- End Authorization -------------------------------------------

                // ----- Domains (Top-level) ----------------------------------------
                // Place statistics BEFORE resource to avoid conflict with domains/{domain}
                Route::get('domains/statistics', [DomainController::class, 'statistics'])->name('domains.statistics');
                Route::resource('domains', DomainController::class);
                //--------------- End Domains ---------------------------------------

                // ----- Orders (Top-level) -----------------------------------------
                Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
                Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
                //--------------- End Orders ----------------------------------------

                // ----- Refers (Top-level) -----------------------------------------
                Route::get('refers', [RefersController::class, 'index'])->name('refers.index');
                //--------------- End Refers ----------------------------------------

                // ----- Managers (Top-level) ---------------------------------------
                Route::get('managers', [ManagersController::class, 'index'])->name('managers.index');
                //--------------- End Managers --------------------------------------

                //--------------- Start Menus -----------------------------------------------------------------------//
                // Route::resource('menus', MenueController::class); // disabled
                // Route::get('show-menu-tree', [MenueController::class, 'show_tree'])->name('menus.show_tree');
                // Route::post('menus/actions', [MenueController::class, 'actions'])->name('menus.actions');
                // Route::get('menus/update-status/{id}', [MenueController::class, 'update_status'])->name('menus.update-status');
                // Route::get('tree/get-urls', [MenueController::class, 'getUrl'])->name('menus.getUrl');
                // Route::get('get-menus', [MenueController::class, 'getMenus'])->name('menus.getMenus');
                //--------------- End Menus -----------------------------------------------------------------------//

                // ----- Pages -----------------------------------------------
                // Route::resource('pages', PagesController::class); // disabled
                // Route::get('pages/update-status/{id}', [PagesController::class, 'update_status'])->name('pages.update-status');
                // Route::post('pages/actions', [PagesController::class, 'actions'])->name('pages.actions');
                // ----- End Pages -------------------------------------------

                // ----- news -----------------------------------------------
                // Route::resource('news', NewsController::class); // disabled
                // Route::get('news/update-status/{id}', [NewsController::class, 'update_status'])->name('news.update-status');
                // Route::post('news/actions', [NewsController::class, 'actions'])->name('news.actions');
                // Route::get('news/update-featured/{id}', [NewsController::class, 'update_featured'])->name('news.update-featured');
                // ----- End news -------------------------------------------

                //----------------Start Sliders----------------------------//
                // Route::resource('slider', SliderController::class); // disabled
                // Route::get('slider/update-status/{id}', [SliderController::class, 'update_status'])->name('slider.update-status');
                // Route::post('slider/actions', [SliderController::class, 'actions'])->name('slider.actions');
                //----------------End Sliders----------------------------//

                // ----- ContactUs -----------------------------------------------
                // Route::resource('contact-us', ContactUsController::class); // disabled
                // Route::post('contact-us/read', [ContactUsController::class, 'read'])->name('contact-us.read');
                // Route::get('/notifications/markAll', [ContactUsController::class, 'markAll'])->name('notification.read');
                //--------------- End ContactUs ---------------------------------

                // ----- subscribes -----------------------------------------------
                // Route::resource('subscribes', SubscribesController::class); // disabled
                //--------------- End subscribes ---------------------------------

                // ----- Categories -----------------------------------------------
                // Route::resource('categories', CategoryController::class); // disabled
                // Route::get('show-categories-tree', [CategoryController::class, 'show_tree'])->name('categories.show_tree');
                // Route::get('categories/update-status/{id}', [CategoryController::class, 'update_status'])->name('categories.update-status');
                // Route::post('categories/actions', [CategoryController::class, 'actions'])->name('categories.actions');
                // Route::get('categories/update-featured/{id}', [CategoryController::class, 'update_featured'])->name('categories.update-featured');
                //--------------- End Categories ---------------------------------

                // ----- articles -----------------------------------------------
                // Route::resource('articles', ArticlesContoller::class); // disabled
                // Route::get('show-articles-tree', [ArticlesContoller::class, 'show_tree'])->name('articles.show_tree');
                // Route::get('articles/update-status/{id}', [ArticlesContoller::class, 'update_status'])->name('articles.update-status');
                // Route::post('articles/actions', [ArticlesContoller::class, 'actions'])->name('articles.actions');
                // Route::get('articles/update-featured/{id}', [ArticlesContoller::class, 'update_featured'])->name('articles.update-featured');
                //--------------- End articles ---------------------------------

                // ----- Tags ---------------------------------------------------
                // Route::resource('tag', TagController::class); // disabled
                // Route::post('tag/actions', [TagController::class, 'actions'])->name('tag.actions');
                //--------------- End Tags --------------------------------------

                // ----- Portfolio Tags -----------------------------------------
                // Route::resource('portfolio-tags', PortfolioTagController::class); // disabled
                // Route::post('portfolio-tags/actions', [PortfolioTagController::class, 'actions'])->name('portfolio-tags.actions');
                //--------------- End Portfolio Tags ----------------------------

                // ----- Portfolio ----------------------------------------------
                // Route::resource('portfolio', PortfolioController::class); // disabled
                // Route::post('portfolio/actions', [PortfolioController::class, 'actions'])->name('portfolio.actions');
                // Route::get('portfolio/update-status/{id}', [PortfolioController::class, 'update_status'])->name('portfolio.update-status');
                //--------------- End Portfolio ---------------------------------

                // ----- Projects -----------------------------------------------
                // Route::resource('projects', ProjectsController::class); // disabled
                // Route::post('projects/actions', [ProjectsController::class, 'actions'])->name('projects.actions');
                // Route::get('projects/update-status/{id}', [ProjectsController::class, 'update_status'])->name('projects.update-status');
                //--------------- End Projects ---------------------------------

                // ----- Services -----------------------------------------------
                // Route::resource('services', ServicesController::class); // disabled
                // Route::post('services/actions', [ServicesController::class, 'actions'])->name('services.actions');
                // Route::get('services/update-status/{id}', [ServicesController::class, 'update_status'])->name('services.update-status');
                //--------------- End Services ---------------------------------

                // ----- Settings -----------------------------------------------
                // Route::resource('settings', SettingsController::class); // disabled
                // Route::post('settings/actions', [SettingsController::class, 'actions'])->name('settings.actions');
                //--------------- End Settings ---------------------------------

                // ----- Themes -----------------------------------------------
                // Route::resource('themes', ThemesController::class); // disabled
                // Route::post('themes/actions', [ThemesController::class, 'actions'])->name('themes.actions');
                // Route::get('themes/active/{id}', [ThemesController::class, 'active'])->name('themes.active');
                // Route::get('themes/dashboard', [ThemesController::class, 'dashboard'])->name('themes.dashboard');
                //--------------- End Themes ---------------------------------

                // ----- Payment Methods --------------------------------------
                // Route::resource('payment-method', PaymentMethodController::class); // disabled
                // Route::post('payment-method/actions', [PaymentMethodController::class, 'actions'])->name('payment-method.actions');
                // Route::get('payment-method/update-status/{id}', [PaymentMethodController::class, 'update_status'])->name('payment-method.update-status');
                //--------------- End Payment Methods ------------------------

                // ----- Media -----------------------------------------------
                // Route::resource('media', MediaController::class); // disabled
                // Route::post('media/actions', [MediaController::class, 'actions'])->name('media.actions');
                // Route::get('media/update-status/{id}', [MediaController::class, 'update_status'])->name('media.update-status');
                //--------------- End Media ---------------------------------
            });
        });
    });
});
