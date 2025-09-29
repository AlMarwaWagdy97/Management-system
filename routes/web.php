<?php

use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use App\View\Components\Gifts\CardImg;
use App\View\Components\Gifts\CardForm;
use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\MediaController;
use App\Http\Controllers\Site\StoreController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\PaymentController;
use App\Http\Controllers\Site\ProfileController;
use App\View\Components\Site\Home\LoadMoreMedia;
use App\Http\Controllers\Data\OldMenusController;
use App\Http\Controllers\Data\OldPagesController;
use App\Http\Controllers\Site\CampaignController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\VolunteerController;
use App\Http\Controllers\Site\Contact_usController;
use App\Http\Controllers\Data\OldCategoryController;
use App\Http\Controllers\Site\ReviewOrderController;
use App\Http\Controllers\Site\ProfileCardsController;
use App\Http\Controllers\Site\BeneficiariesController;
use App\Http\Controllers\Site\TrackingOrderController;
use App\Http\Controllers\Site\Vendor\VendorController;
use App\Http\Controllers\Admin\Charity\OrderController;
use App\Http\Controllers\Site\CharityProductController;
use App\Http\Controllers\Site\CharityProjectController;
use App\Http\Controllers\Site\Vendor\ProductController;
use App\Http\Controllers\Site\Manager\ManagerController;
use App\Http\Controllers\Site\ProjectCategoryController;
use App\Http\Controllers\Site\Referer\RefererController;
use App\Http\Controllers\Site\Manager\ManagerAuthController;
use App\Http\Controllers\Site\Referer\RefererAuthController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Site\ReferAffiliateController;


use App\Http\Controllers\Site\Vendor\AuthController as VendorAuthController;

// use App\Http\Controllers\Data\CategoryController;


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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'CheckStoreCookies'], // Route translate middleware
    'as' => 'site.'
], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('about', [AboutController::class, 'index'])->name('about');

    // Projects
    Route::get('categories', [ProjectCategoryController::class, 'index'])->name('projectCategories.index');
    Route::get('categories/{id}', [ProjectCategoryController::class, 'show'])->name('projectCategories.show');
    Route::get('projects/{id}', [CharityProjectController::class, 'show'])->name('charity-project.show');


    // cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.show');
    // checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.show');
    Route::POST('checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('checkout/success/{identifier}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/invoices/{id}', [OrderController::class, 'invoices'])->name('invoices');

    // site pages
    Route::get('pages/{id}', [PageController::class, 'show'])->name('page.show'); //page show by id
    // Route::get('contact-us', [ContactController::class, 'index'])->name('contact-us.index'); //contact us page
    // Route::get('about', [AboutController::class,  'index'])->name('about'); //about page

    // site media
    Route::get('media/', [MediaController::class, 'index'])->name('media.index'); //media show all
    Route::get('media/{id}', [MediaController::class, 'show'])->name('media.show'); //media show by id
    Route::get('media-more/{start}/{count}', fn($start, $count) => Blade::renderComponent(new LoadMoreMedia($start, $count)))->name('media.loadMore');

    Route::get('/r/{code}', [ReferAffiliateController::class, 'index'])->name('front.refer');

    // Blog Routes
    Route::get('blogs', [\App\Http\Controllers\Site\BlogController::class, 'index'])->name('blogs.index');
    Route::get('blogs/{slug}', [\App\Http\Controllers\Site\BlogController::class, 'show'])->name('blogs.show');
    Route::get('blog-categories', [\App\Http\Controllers\Site\BlogCategoryController::class, 'index'])->name('blog-categories.index');
    Route::get('blog-categories/{slug}', [\App\Http\Controllers\Site\BlogCategoryController::class, 'show'])->name('blog-categories.show');

    Route::get('contact-us', [Contact_usController::class, 'index'])->name('contact-us.index');
    Route::post('contact-us', [Contact_usController::class, 'store'])->name('contact-us.store');

    // store
    Route::get('store/{slug}', [StoreController::class, 'show'])->name('store.show'); //Store page

    // Products (Gifts)
    Route::get('products', [CharityProductController::class, 'index'])->name('charity-products.index');
    Route::get('products/{id}', [CharityProductController::class, 'show'])->name('charity-product.show');

    // campain
    Route::get('campaign', [CampaignController::class, 'index'])->name('campaign.show'); //page show by id

    Route::get('tracking/{id}', [TrackingOrderController::class, 'trackingOrder'])->name('tracking.order');
    Route::get('evaluation/{id}', [ReviewOrderController::class, 'reviewProduct'])->name('review.order');
    Route::post('evaluation', [ReviewOrderController::class, 'submitReview'])->name('review.save-order');

    // intial payment
    Route::get('payment-intital', [PaymentController::class, 'payfortIntital'])->name('payments.intital');
    // fast donation
    Route::get('payment-fastdonation-intital', [PaymentController::class, 'fastDonationPayfortIntital'])->name('payments.fastdonation.intital');

    // applepay
    Route::get('applepay-view/{identifier}', [CheckoutController::class, 'applepayView'])->name('checkout.applepay');
    Route::POST('payment-applepay', [PaymentController::class, 'applepay'])->name('payments.applepay');

    // volunteering ----------------------------------------------------------------------
    Route::group(['prefix' => 'volunteering', 'as' => 'volunteering.'], function () {
        Route::controller(VolunteerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('volunteers', 'volunteers')->name('volunteers');
            Route::get('join-community', 'joinCommunity')->name('join-community');
            Route::get('informations', 'informations')->name('informations');
            Route::get('ideas', 'ideas')->name('ideas');
            Route::get('ideas/create', 'createIdeas')->name('create-ideas');
            Route::get('ideas/info/{slug}', 'infoIdeas')->name('info-ideas');
        });
    });


    // Beneficiaries ----------------------------------------------------------------------
    Route::group(['prefix' => 'beneficiaries', 'as' => 'beneficiaries.'], function () {
        Route::controller(BeneficiariesController::class)->group(function () {
            // Route::get('/', 'index')->name('index');
            Route::get('join-community', 'joinCommunity')->name('join-community');
        });
    });

    // Authentication ----------------------------------------------------------------------
    Route::group(['middleware' => ['RedirectProfile']], function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::get('register', [AuthController::class, 'register'])->name('register');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Profile ----------------------------------------------------------------------
    Route::group(['prefix' => 'profile', 'middleware' => ['CheckDonorAuth'], 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::POST('update', [ProfileController::class, 'update'])->name('update');
        Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
        Route::get('/gifts', [ProfileController::class, 'gifts'])->name('gifts');
        Route::get('/statistics', [ProfileController::class, 'statistics'])->name('statistics');
        Route::POST('/close', [ProfileController::class, 'close'])->name('close');

        Route::group(['prefix' => 'cards', 'as' => 'cards.'], function () {
            Route::controller(ProfileCardsController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/add', 'add')->name('add');
                Route::POST('/save', 'save')->name('save');
                Route::delete('/delete/{id}', 'delete')->name('delete');
            });
        });
    });

    // vendor --------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'vendors', 'as' => 'vendors.'], function () {
        // Authentication ------------------------------------------
        Route::group(['middleware' => ['RedirectVendor']], function () {
            Route::get('login', [VendorAuthController::class, 'login'])->name('login');
        });
        Route::get('logout', [VendorAuthController::class, 'logout'])->name('logout');
        Route::group(['middleware' => ['CheckVendorAuth']], function () {
            Route::get('/', [VendorController::class, 'index'])->name('index');
            Route::get('edit', [VendorController::class, 'edit'])->name('edit');
            Route::resource('products', ProductController::class);
            Route::get('/orders', [VendorController::class, 'orders'])->name('orders.index');
        });
    });


    // Referer --------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'referer', 'as' => 'referer.'], function () {
        // Authentication ------------------------------------------
        Route::group(['middleware' => ['RedirectReferer']], function () {
            Route::get('login', [RefererAuthController::class, 'login'])->name('login');
        });
        Route::get('logout', [RefererAuthController::class, 'logout'])->name('logout');
        Route::group(['middleware' => ['CheckRefererAuth']], function () {
            Route::get('/', [RefererController::class, 'index'])->name('index');
            Route::get('/orders', [RefererController::class, 'orders'])->name('orders.index');
        });
    });


    // Manager --------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'managers', 'as' => 'managers.'], function () {
        // Authentication ------------------------------------------
        Route::group(['middleware' => ['RedirectManager']], function () {
            Route::get('login', [ManagerAuthController::class, 'login'])->name('login');
        });
        Route::get('logout', [ManagerAuthController::class, 'logout'])->name('logout');
        Route::group(['middleware' => ['CheckManagerAuth']], function () {
            Route::get('/', [ManagerController::class, 'index'])->name('index');
            Route::get('/orders', [ManagerController::class, 'orders'])->name('orders.index');
        });
    });

    // components
    Route::group(['prefix' => 'components', 'as' => 'components.'], function () {
        Route::get('card-form', fn() => Blade::renderComponent(new CardForm()))->name('card-form');
        Route::delete('delete-form', function () {
            return "";
        })->name('delete-form');
        Route::get('card-img', fn() => Blade::renderComponent(new CardImg()))->name('card-img');
    });
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\Laravelfilemanager\Lfm::routes();
});


// Route::get('translate-category', [OldCategoryController::class, 'category']);
// Route::get('translate-projects', [OldCategoryController::class, 'projects']);
Route::get('translate-projects-images', [OldCategoryController::class, 'categoryProjectsImages']);
Route::get('translate-projects-category', [OldCategoryController::class, 'projectCategoriesPivot']);
// Route::get('translate-projects-types', [OldCategoryController::class, 'projectTypes']);
// Route::get('translate-menus', [OldMenusController::class, 'menus']);
// Route::get('translate-menus-update', [OldMenusController::class, 'menusUpdate']);
// Route::get('translate-menus-update-url', [OldMenusController::class, 'menusUpdateUrl']);
// Route::get('translate-pages-update', [OldPagesController::class, 'pages']);
// Route::get('translate-bank-account', [OldPagesController::class, 'bankAcounts']);

// // Clear settings cache
// \Artisan::call('cache:clear');
// \Artisan::call('config:clear');
