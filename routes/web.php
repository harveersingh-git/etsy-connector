<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EtsyController;
use App\Http\Controllers\CountryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ShopListController;
use App\Http\Controllers\MyShopController;
use App\Http\Controllers\LocalizationController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::any('/', function () {
    return redirect('/login');
});

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Auth::routes();

Route::group(['middleware' => ['auth', 'is_verify_email', 'Language']], function () {

    Route::get('/change-language/{lang}', [HomeController::class, 'changeLang']);

    // Route::get('/change-language/{lang}', [HomeController::class, 'changeLang'])->name('change-language');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/overview', [HomeController::class, 'overview'])->name('overview');

    Route::any('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::any('/edit-profile', [UserController::class, 'editProfile'])->name('editProfile');
    Route::any('/etsy-config', [EtsyController::class, 'etsyConfig'])->name('etsyConfig');
    Route::any('/etsy-config/{id}', [EtsyController::class, 'etsyConfig'])->name('etsy-config');

    Route::any('/country-list', [EtsyController::class, 'countryList'])->name('country-list');
    Route::any('/etsy-list-data', [EtsyController::class, 'etsyListData'])->name('etsy-list-data');
    Route::any('/etsy-list-data/{id}', [EtsyController::class, 'etsyListData'])->name('etsy-list-data');
    // Route::any('/shoplist-data/{id}', [EtsyController::class, 'show'])->name();
    Route::any('/etsy-download-history', [EtsyController::class, 'downloadHistory'])->name('etsy-download-history');

    Route::any('/get_access_code_url', [EtsyController::class, 'etsyAuth'])->name('get_access_code_url');
    Route::any('/get_shop_default_lang', [EtsyController::class, 'etsyShopLang'])->name('get_shop_default_lang');

    
    Route::post('/verify_access_code', [EtsyController::class, 'verifyAccessCode'])->name('verify_access_code');
    Route::any('/export-csv', [EtsyController::class, 'exportCsv'])->name('export-csv');
    Route::any('/generate-csv', [EtsyController::class, 'genrateCsv'])->name('generate-csv');
    Route::any('/delete_download_history', [EtsyController::class, 'destroy'])->name('delete_download_history');
    Route::any('/etsy-product-list/{id}', [EtsyController::class, 'view'])->name('etsy-product-list');


    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('subscriber', SubscriberController::class);
    // Route::resource('shoplist', ShopListController::class);
    Route::any('/shoplist/{id}', [ShopListController::class, 'index'])->name('shoplist');
    Route::any('/add-shoplist/{id}', [ShopListController::class, 'create'])->name('add-shoplist');
    Route::any('/delete_shoplist', [ShopListController::class, 'destroy'])->name('delete_shoplist');
    Route::any('/shoplist/edit/{id}', [ShopListController::class, 'show']);
    Route::post('/update-shop', [ShopListController::class, 'update'])->name('updateshop');

    Route::any('/my-shop', [MyShopController::class, 'index'])->name('my-shop');
    Route::any('/add-my-shop', [MyShopController::class, 'create'])->name('add-my-shop');
    Route::any('/my-shop/edit/{id}', [MyShopController::class, 'show']);
    Route::post('/update-my-shop', [MyShopController::class, 'update'])->name('update-my-shop');
    Route::any('/delete_myshoplist', [MyShopController::class, 'destroy'])->name('delete_myshoplist');


    Route::resource('country', CountryController::class);
    Route::post('delete_country', [CountryController::class, 'destroy'])->name('delete_country');
    Route::post('delete_subscriber', [SubscriberController::class, 'destroy'])->name('delete_subscriber');
    Route::post('send_email_verification_link', [SubscriberController::class, 'sendVerificationLink'])->name('send_email_verification_link');

    Route::any('/subscriber-restore', [SubscriberController::class, 'userRestore'])->name('subscriber-restore');
    Route::any('/permanently-delete', [SubscriberController::class, 'permanentlyDestroy'])->name('permanently-delete');
    Route::any('/subscriber-status-update', [SubscriberController::class, 'subscriberStatusUpdate'])->name('subscriber-status-update');
    Route::any('/subscriber-in-active', [SubscriberController::class, 'subscriberInActive'])->name('subscriber-in-active');
    Route::any('/subscriber-trash', [SubscriberController::class, 'subscriberTrash'])->name('subscriber-trash');
    Route::post('/update-password', [SubscriberController::class, 'changePassword'])->name('updatePassword');
    Route::any('/update-password/{id}', [SubscriberController::class, 'changePassword'])->name('update-password');

    Route::any('/localization', [LocalizationController::class, 'index'])->name('localization');
    Route::any('/add-localization', [LocalizationController::class, 'create'])->name('add-localization');
    Route::any('/localization/edit/{id}', [LocalizationController::class, 'show']);
    Route::post('/update-localization', [LocalizationController::class, 'update'])->name('update-localization');
    Route::any('/delete_localization', [LocalizationController::class, 'destroy'])->name('delete_localization');
});
