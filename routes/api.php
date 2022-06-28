<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ApiController;

Route::prefix('v1')->group(function () {
    Route::get('phones', [ApiController::class, 'getPhones']);
    Route::post('/create/order', [ApiController::class, 'createOrder']);

    Route::get('orders', [ApiController::class, 'getOrders']);
    Route::prefix('orders')->group(function () {
        Route::get('/{order_id}', [ApiController::class, 'getOrder']);

        //here will be some middleware to check if user is admin or not
        Route::prefix('admin')->middleware([])->group(function () {
            Route::get('/fulfill/{order_id}', [ApiController::class, 'fulfillOrder']);
            Route::get('/cancel/{order_id}', [ApiController::class, 'cancelOrder']);

            Route::post('/phone', [ApiController::class, 'createPhone']);
            Route::prefix('/phone')->group(function (){
                Route::put('/{phone_id}', [ApiController::class, 'updatePhones'])->where('phone_id', '[0-9]+');
                Route::post('/{phone_id}', [ApiController::class, 'restorePhone'])->where('phone_id', '[0-9]+');
                Route::delete('/{phone_id}', [ApiController::class, 'deletePhone'])->where('phone_id', '[0-9]+');
            });
        });
    });
});
