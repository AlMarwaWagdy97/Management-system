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
