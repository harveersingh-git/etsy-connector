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
use App\Http\Controllers\EtsySettingController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\StatusController;
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
Route::any('/test', [ContactUsController::class, 'test'])->name('test');
Route::any('/', function () {
    return redirect('/login');
});
Route::get('/provider/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider')->name('redirectToProvider');

Route::get('/provider/{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');
Route::any('/localization', [LocalizationController::class, 'index'])->name('localization');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
Route::post('resend', [VerifyEmailController::class, 'resend'])->name('resend');
Route::any('contect-us', [ContactUsController::class, 'create'])->name('contect-us');
Route::any('php-info', [ContactUsController::class, 'phpinfo'])->name('php-info');
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
  
    Route::any('/etsy-list-data-progress', [EtsyController::class, 'etsyListDataProgress'])->name('etsy-list-data-progress');
    Route::any('/etsy-list-data', [EtsyController::class, 'etsyListData'])->name('etsy-list-data');
    Route::any('/etsy-list-data/{id}', [EtsyController::class, 'etsyListData']);
    // Route::any('/shoplist-data/{id}', [EtsyController::class, 'show'])->name();
    Route::any('/etsy-download-history', [EtsyController::class, 'downloadHistory'])->name('etsy-download-history');

    Route::any('/get_access_code_url', [EtsyController::class, 'etsyAuth'])->name('get_access_code_url');
    Route::any('/get_shop_default_lang', [EtsyController::class, 'etsyShopLang'])->name('get_shop_default_lang');


    Route::post('/verify_access_code', [EtsyController::class, 'verifyAccessCode'])->name('verify_access_code');
    Route::any('/export-csv', [EtsyController::class, 'exportCsv'])->name('export-csv');
    Route::any('/generate-csv', [EtsyController::class, 'genrateCsv'])->name('generate-csv');
    Route::any('/delete_download_history', [EtsyController::class, 'destroy'])->name('delete_download_history');
    Route::any('/etsy-product-list/{id}/{type}', [EtsyController::class, 'view'])->name('etsy-product-list');
    Route::post('/verify_shop_id', [EtsyController::class, 'verifyShopId'])->name('verify_shop_id');



    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('subscriber', SubscriberController::class);
    // Route::resource('shoplist', ShopListController::class);

    Route::any('/shop-list', [ShopListController::class, 'shopList'])->name('shop-list');
    Route::any('/shoplist/{id}', [ShopListController::class, 'index'])->name('shoplist');
    Route::any('/shoplist-trash/{id}', [ShopListController::class, 'shopListTrash'])->name('shoplist-trash');
    Route::any('/shoplist-permanently-delete', [ShopListController::class, 'permanentlyDestroy'])->name('shoplist-permanently-delete');
    Route::any('/shoplist-restore', [ShopListController::class, 'myShopRestore'])->name('shoplist-restore');

    Route::any('/add-shoplist/{id}', [ShopListController::class, 'create'])->name('add-shoplist');
    Route::any('/delete_shoplist', [ShopListController::class, 'destroy'])->name('delete_shoplist');
    Route::any('/shoplist/edit/{id}', [ShopListController::class, 'show']);
    Route::post('/update-shop', [ShopListController::class, 'update'])->name('updateshop');

    Route::any('/my-shop', [MyShopController::class, 'index'])->name('my-shop');
    Route::any('/my-shop-trash', [MyShopController::class, 'myShopTrash'])->name('my-shop-trash');
    Route::any('/my-shop-restore', [MyShopController::class, 'myShopRestore'])->name('my-shop-restore');

    Route::any('/my-shop-permanently-delete', [MyShopController::class, 'permanentlyDestroy'])->name('my-shop-permanently-delete');

    Route::any('/add-my-shop', [MyShopController::class, 'create'])->name('add-my-shop');
    Route::any('/my-shop/edit/{id}', [MyShopController::class, 'show']);
    Route::post('/update-my-shop', [MyShopController::class, 'update'])->name('update-my-shop');
    Route::any('/delete_myshoplist', [MyShopController::class, 'destroy'])->name('delete_myshoplist');


    Route::resource('country', CountryController::class);
    Route::any('/country-permanently-delete', [CountryController::class, 'permanentlyDestroy'])->name('country-permanently-delete');
    Route::any('/country-restore', [CountryController::class, 'countryRestore'])->name('country-restore');

    Route::any('/country-trash', [CountryController::class, 'countryTrash'])->name('country-trash');
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
    // Route::any('/license/{id}', [ShopListController::class, 'license'])->name('shoplist');

    Route::any('/license/{id}', [SubscriberController::class, 'license'])->name('license');

    Route::any('/localization', [LocalizationController::class, 'index'])->name('localization');
    Route::any('/localization-trash', [LocalizationController::class, 'localizationTrash'])->name('localization-trash');
    Route::any('/localization-restore', [LocalizationController::class, 'localizationRestore'])->name('localization-restore');
    Route::any('/localization-permanently-delete', [LocalizationController::class, 'permanentlyDestroy'])->name('localization-permanently-delete');
   


    Route::any('/add-localization', [LocalizationController::class, 'create'])->name('add-localization');
    Route::any('/localization/edit/{id}', [LocalizationController::class, 'show']);
    Route::post('/update-localization', [LocalizationController::class, 'update'])->name('update-localization');
    Route::any('/delete_localization', [LocalizationController::class, 'destroy'])->name('delete_localization');

    // Route::any('/etsy-setting', [EtsySettingController::class, 'index'])->name('etsy-setting');

    Route::resource('etsy-setting', EtsySettingController::class);
    Route::any('/etsy-setting-trash', [EtsySettingController::class, 'etsySettingTrash'])->name('etsy-setting-trash');
    Route::any('/etsy-setting-restore', [EtsySettingController::class, 'etsySettingRestore'])->name('etsy-setting-restore');
    Route::any('/etsy-setting-permanently-delete', [EtsySettingController::class, 'etsySettingDestroy'])->name('etsy-setting-permanently-delete');
   

    Route::resource('status', StatusController::class);
    Route::post('status-restore', [StatusController::class, 'statusRestore'])->name('status-restore');
    Route::post('status-permanently-delete', [StatusController::class, 'permanentlyDestroy'])->name('status-permanently-delete');
    Route::any('/status-trash', [StatusController::class, 'statusTrash'])->name('status-trash');

    Route::post('delete_status', [StatusController::class, 'destroy'])->name('delete_status');
    Route::post('delete_etsy_setting', [EtsySettingController::class, 'destroy'])->name('delete_etsy_setting');
    Route::any('support', [ContactUsController::class, 'index'])->name('support');
    Route::any('/support/edit/{id}', [ContactUsController::class, 'show']);
    Route::any('/support-update', [ContactUsController::class, 'update'])->name('support-update');
});
