<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EtsyController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::any('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
Route::any('/edit-profile', [UserController::class, 'editProfile'])->name('editProfile');
Route::any('/etsy-config', [EtsyController::class, 'etsyConfig'])->name('etsyConfig');

Route::any('/country-list', [EtsyController::class, 'countryList'])->name('country-list');
Route::any('/etsy-list-data', [EtsyController::class, 'etsyListData'])->name('etsy-list-data');

Route::any('/get_access_code_url', [EtsyController::class, 'etsyAuth'])->name('get_access_code_url');
Route::post('/verify_access_code', [EtsyController::class, 'verifyAccessCode'])->name('verify_access_code');
Route::any('/generate-csv', [EtsyController::class, 'genrateCsv'])->name('generate-csv');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('subscriber', SubscriberController::class);
    Route::post('delete_subscriber', [SubscriberController::class, 'destroy'])->name('delete_subscriber');
    Route::any('/subscriber-restore', [SubscriberController::class, 'userRestore'])->name('subscriber-restore');
    Route::any('/permanently-delete', [SubscriberController::class, 'permanentlyDestroy'])->name('permanently-delete');

});
