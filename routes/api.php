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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'User', 'prefix' => 'users'], function () {
    Route::post('/', [\App\Http\Controllers\User\StoreController::class, '__invoke']);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', '\App\Http\Controllers\AuthController@login');
    Route::post('logout', '\App\Http\Controllers\AuthController@logout');
    Route::post('refresh', '\App\Http\Controllers\AuthController@refresh');
    Route::post('me', '\App\Http\Controllers\AuthController@me');

    Route::group(['middleware' => 'jwt.auth' ], function () {

        Route::group(['prefix' => 'user'], function () {
            Route::patch('/update', [\App\Http\Controllers\User\UpdateController::class, '__invoke']);
        });

        Route::group(['namespace' => 'Account'], function () {
            Route::get('/account/{account}', [\App\Http\Controllers\Account\EditController::class, '__invoke'])->name('account.edit');
            Route::get('/accounts', [\App\Http\Controllers\Account\IndexController::class, '__invoke'])->name('account.index');
            Route::post('/account', [\App\Http\Controllers\Account\StoreController::class, '__invoke'])->name('account.store');
//            Route::delete('/accounts/{account}', 'DestroyController')->name('account.delete');
            Route::patch('/account/{account}', [\App\Http\Controllers\Account\UpdateController::class, '__invoke'])->name('account.update');
        });

        Route::group(['namespace' => 'Operation'], function () {
//            Route::get('/account/{account}', [\App\Http\Controllers\Account\EditController::class, '__invoke'])->name('account.edit');
//            Route::get('/accounts', [\App\Http\Controllers\Account\IndexController::class, '__invoke'])->name('account.index');
            Route::post('/operation', [\App\Http\Controllers\Operation\StoreController::class, '__invoke'])->name('operation.store');
//            Route::delete('/accounts/{account}', 'DestroyController')->name('account.delete');
//            Route::patch('/account/{account}', [\App\Http\Controllers\Account\UpdateController::class, '__invoke'])->name('account.update');
        });

    });
});
