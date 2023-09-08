<?php
//
//use Illuminate\Http\Request;
use \App\Applications\Common\Controllers\LocationController;
//
///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//| This file contains the api routes for the Common module
//|
//|
//*/
//
//
// Non auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'guest/common',
], function () {
//    Route::get('get-handle-types', 'Controllers\TaxonomiesController@getHandleTypes');
    Route::get('{id}/fetch', [LocationController::class,'getPostByIdNonAuth']);
    Route::post('allPostsPublic', [LocationController::class,'allPostsPublic']);
    Route::get('getCountries', 'Controllers\TaxonomiesController@getCountries');
    Route::get('{id}/getPost', 'Controllers\LocationController@getPostById');
});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'common',
], function () {
    Route::post('save-location',[LocationController::class,'saveLocation']);
    Route::post('location/{id}/edit',[LocationController::class,'editLocation']);
//   Route::get('index','Controllers\LocationController@index');
//   Route::get('getScrolldownPosts', 'Controllers\LocationController@getScrolldownPosts');
    Route::post('locations/draw', [LocationController::class,'allLocations']);
    Route::post('locations/{id}/delete', [LocationController::class,'deleteLocation']);
//    Route::post('posts/draw', [LocationController::class,'allPosts']);
//   Route::get('latestPosts', 'Controllers\LocationController@latestPosts'); //function(){ return PostResource::collection(Posts::all());})Route::get('{id}/fetch', 'Controllers\LocationController@getPostByIdNonAuth');
});
