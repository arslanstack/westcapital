<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('newui');
});
Route::get('/mapsapi', function () {
    return view('maps');
});
Route::get('/api', function () {
    return view('api');
});

Route::get('/pdf', function () {
    return view('pdf/template');
});

Route::post('generatepdf', [PDFController::class, 'genPDF']);
Route::post('sendpdf', [PDFController::class, 'sendPDF']);
Route::post('delete-pdf/{filepath}', [PDFController::class, 'delPDF']);

Route::post('getcounty', [APIController::class, 'getCounties']);
Route::post('gettownship', [APIController::class, 'getTownships']);
Route::post('getfees', [APIController::class, 'getFee']);

Route::group(['prefix'  =>  'admin'], function () {
    Route::get('login', [AdminLoginController::class, 'index'])->name('login');
    Route::post('verify_login', [AdminLoginController::class, 'verify_login']);
    Route::get('logout', [AdminLoginController::class, 'logout']);

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('admin', [AdminController::class, 'index']);
        Route::get('change_password', [AdminController::class, 'change_password']);
        Route::post('update_password', [AdminController::class, 'update_password']);

        Route::group(['prefix'  =>  'config'], function () {
            Route::get('/', [ConfigController::class, 'index']);
            Route::post('/show', [ConfigController::class, 'show']);
            Route::post('/update', [ConfigController::class, 'update']);
            Route::post('/destroySession', [ConfigController::class, 'destroySession']);
        });
    });
});
