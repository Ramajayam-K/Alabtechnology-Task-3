<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function(){
    Route::get('/', 'index')->name('dashboard');
    Route::post('/getProduct', 'getProduct')->name('getProduct');
    Route::post('/getOrderData', 'getOrderData')->name('getOrderData');
    Route::post('/UpdateProductStock', 'UpdateProductStock')->name('UpdateProductStock');
});