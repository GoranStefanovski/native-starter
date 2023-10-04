<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the api routes for the Common module
|
|
*/


// Non auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'guest/common',
], function () {
    Route::post('contact', 'Controllers\DashboardController@contact');
});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'common',
], function () {
    Route::get('dashboard/get', 'Controllers\DashboardController@getDashboardInformation');
});
