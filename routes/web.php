<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EtsyController;
use App\Http\Controllers\CountryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Auth::routes();
Route::group(['middleware' => ['auth', 'is_verify_email']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::any('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::any('/edit-profile', [UserController::class, 'editProfile'])->name('editProfile');
    Route::any('/etsy-config', [EtsyController::class, 'etsyConfig'])->name('etsyConfig');
    Route::any('/etsy-config/{id}', [EtsyController::class, 'etsyConfig'])->name('etsy-config');

    Route::any('/country-list', [EtsyController::class, 'countryList'])->name('country-list');
    Route::any('/etsy-list-data', [EtsyController::class, 'etsyListData'])->name('etsy-list-data');

    Route::any('/get_access_code_url', [EtsyController::class, 'etsyAuth'])->name('get_access_code_url');
    Route::post('/verify_access_code', [EtsyController::class, 'verifyAccessCode'])->name('verify_access_code');
    Route::any('/generate-csv', [EtsyController::class, 'genrateCsv'])->name('generate-csv');



    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('subscriber', SubscriberController::class);
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
});
