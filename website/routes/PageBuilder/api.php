<?php

use Illuminate\Http\Request;
use App\Applications\PageBuilder\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the api routes for the Page builder module
|
|
*/

Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'page-builder',
], function () {
    Route::get('page/{slug}', [PageController::class, 'show']);
    Route::post('page', [PageController::class, 'store']);
    Route::get('draw/{id}', [PageController::class, 'getPageById']);
    Route::post('draw', [PageController::class, 'draw']);
});
