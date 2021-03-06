<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('signup', [App\Http\Controllers\AuthController::class, 'signUp'])->name('signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout',[App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [App\Http\Controllers\AuthController::class, 'user'])->name('user');
        Route::post('save-contact',[App\Http\Controllers\ContactController::class, 'saveContact']);
        Route::post('/update-contact', [App\Http\Controllers\ContactController::class, 'updateContact']);
        Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'getContacts']);
        Route::post('/delete', [App\Http\Controllers\ContactController::class, 'deleteContact']);
    });
});