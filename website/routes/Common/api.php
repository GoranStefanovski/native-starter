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
    Route::get('get-countries', 'Controllers\TaxonomiesController@getCountries');
    Route::get('location-types', 'Controllers\TaxonomiesController@getLocationTypes');
    Route::get('music-types', 'Controllers\TaxonomiesController@getMusicTypes');
    // 
    Route::post('all-locations', [LocationController::class,'allLocationsPublic']);
    Route::post('all-events', [EventController::class,'allEventsPublic']);
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
    Route::post('locations/user/draw', [LocationController::class,'getLocationsCollaborator']);

    // Events
    Route::post('save-event/info',[EventController::class,'saveEventInfo']);
    Route::post('save-event/timeline',[EventController::class,'saveEventTimeline']);
    Route::post('save-event/contact', [EventController::class,'saveEventContact']);
    Route::post('event/{id}/edit',[EventController::class,'editEvent']);
    Route::post('events/draw', [EventController::class,'allEvents']);
    Route::post('events/{id}/delete', [EventController::class,'deleteEvent']);
});
