<?php
//
//use Illuminate\Http\Request;
use \App\Applications\Common\Controllers\LocationController;
use \App\Applications\Common\Controllers\EventController;
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
    Route::get('getCountries', 'Controllers\TaxonomiesController@getCountries');
    Route::post('allLocationsPublic', [LocationController::class,'allLocationsPublic']);
    Route::post('allEventsPublic', [EventController::class,'allEventsPublic']);
    Route::get('{id}/getLocation', 'Controllers\LocationController@getPostById');
    Route::get('{id}/getEvent', 'Controllers\EventController@getPostById');
});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'common',
], function () {
    // Locations
    Route::post('save-location',[LocationController::class,'saveLocation']);
    Route::post('location/{id}/edit',[LocationController::class,'editLocation']);
    Route::post('locations/draw', [LocationController::class,'allLocations']);
    Route::post('locations/{id}/delete', [LocationController::class,'deleteLocation']);

    // Events
    Route::post('save-event',[EventController::class,'saveEvent']);
    Route::post('event/{id}/edit',[EventController::class,'editEvent']);
    Route::post('events/draw', [EventController::class,'allEvents']);
    Route::post('events/{id}/delete', [EventController::class,'deleteEvent']);

    //   Route::get('getScrolldownPosts', 'Controllers\LocationController@getScrolldownPosts');
//   Route::get('index','Controllers\LocationController@index');
//    Route::post('posts/draw', [LocationController::class,'allPosts']);
//   Route::get('latestPosts', 'Controllers\LocationController@latestPosts'); //function(){ return PostResource::collection(Posts::all());})Route::get('{id}/fetch', 'Controllers\LocationController@getPostByIdNonAuth');
});
