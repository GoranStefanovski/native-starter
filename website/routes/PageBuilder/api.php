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

Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'page-builder',
], function () {
    Route::post('save-content', 'Controllers\SimpleContentController@saveContent');
});
