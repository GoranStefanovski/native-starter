<?php
//
//use Illuminate\Http\Request;
use \App\Applications\Common\Controllers\LocationController;
use \App\Applications\Common\Controllers\EventController;
use \App\Applications\Common\Controllers\WorkingHoursController;
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
    // Taxonomies
    Route::get('get-countries', 'Controllers\TaxonomiesController@getCountries');
    Route::get('location-types', 'Controllers\TaxonomiesController@getLocationTypes');
    Route::get('sub-types', 'Controllers\TaxonomiesController@getSubTypes');
    Route::get('music-types', 'Controllers\TaxonomiesController@getMusicTypes');

    // Events
    Route::get('{id}/getEvent', 'Controllers\EventController@getPostById');
    Route::post('all-events', [EventController::class,'allEventsPublic']);
    Route::post('all-boosted-events', [EventController::class,'getBoostedEvents']);
    Route::post('this-month-events', [EventController::class,'getThisWeekEvents']);
    Route::post('this-day-events', [EventController::class,'getThisDayEvents']);
    Route::post('this-week-events', [EventController::class,'getThisMonthEvents']);

    // Locations
    Route::get('{id}/getLocation', 'Controllers\LocationController@getPostById');
    Route::post('all-locations', [LocationController::class,'allLocationsPublic']);
    Route::post('all-boosted-locations', [LocationController::class,'getBoostedLocations']);

});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'common',
], function () {
    // Locations
    Route::post('save-location',[LocationController::class,'saveLocation']);
    Route::post('location/{id}/edit/status',[LocationController::class,'saveLocationStatus']);
    Route::post('location/{id}/edit',[LocationController::class,'editLocation']);
    Route::post('location/{id}/edit/contact',[LocationController::class,'editLocationContact']);
    Route::post('locations/draw', [LocationController::class,'allLocations']);
    Route::post('locations/{id}/delete', [LocationController::class,'deleteLocation']);
    Route::post('locations/user/draw', [LocationController::class,'getLocationsCollaborator']);

    // Events
    Route::post('save-event',[EventController::class,'saveEvent']);
    Route::post('event/{id}/edit',[EventController::class,'editEvent']);
    Route::post('event/{id}/edit/timeline',[EventController::class,'editEventTimeline']);
    Route::post('events/draw', [EventController::class,'allEvents']);
    Route::post('events/{id}/delete', [EventController::class,'deleteEvent']);    

     // Working Hours
     Route::get('location/{id}/get-working-hours', [WorkingHoursController::class,'getWorkingHours']);
     Route::post('location/{id}/save-working-hours', [WorkingHoursController::class,'saveWorkingHours']);
});
