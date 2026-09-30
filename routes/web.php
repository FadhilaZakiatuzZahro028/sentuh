<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessPageController;
use App\Http\Controllers\DeviceRedirectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/b/{slug}', [BusinessPageController::class, 'show'])
    ->name('business.show');

Route::get('/t/{deviceCode}', [DeviceRedirectController::class, 'show'])
    ->name('device.redirect');