<?php
//
//use Illuminate\Http\Request;
use \App\Applications\Common\Controllers\LocationController;
use \App\Applications\Common\Controllers\EventController;
use \App\Applications\Common\Controllers\WorkingHoursController;
use \App\Applications\Common\Controllers\LikeController;
use \App\Applications\Common\Controllers\OrganizationEventController;
use \App\Applications\Common\Controllers\PostController;
use \App\Applications\Common\Controllers\PostShortController;

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
    Route::post('this-month-events', [EventController::class,'getThisMonthEvents']);
    Route::post('this-day-events', [EventController::class,'getThisDayEvents']);
    Route::post('this-week-events', [EventController::class,'getThisWeekEvents']);
    Route::post('location/{id}/all-events', [EventController::class,'allEventsLocationPublic']);

    // Locations
    Route::get('{id}/getLocation', 'Controllers\LocationController@getPostById');
    Route::post('all-locations', [LocationController::class,'allLocationsPublic']);
    Route::post('all-boosted-locations', [LocationController::class,'getBoostedLocations']);

    // Blog Post
    Route::get('{id}/getBlogPost', [PostController::class,'getPostById']);

    // Shorts Post
    Route::get('{id}/getShortsPost', [PostShortController::class,'getPostById']);

    // Likes
    Route::post('/locations/{location}/like', [LikeController::class,'likeLocation']);
    Route::post('/locations/{location}/unlike', [LikeController::class,'unlikeLocation']);
    Route::post('/events/{event}/like', [LikeController::class,'likeEvent']);
    Route::post('/events/{event}/unlike', [LikeController::class,'unlikeEvent']);

    // Organization
    Route::get('{id}/getOrganizationEvent', [OrganizationEventController::class,'getPostById']);
    Route::post('all-organiztaion-events', [OrganizationEventController::class,'allOrganiztaionEventsPublic']);

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

    // Blog Posts
    Route::post('save-blog-post',[PostController::class,'savePost']);
    Route::post('blog-post/{id}/edit/status',[PostController::class,'savePostStatus']);
    Route::post('blog-post/{id}/edit',[PostController::class,'editPost']);
    Route::post('blog-posts/draw', [PostController::class,'allPosts']);
    Route::post('blog-posts/{id}/delete', [PostController::class,'deletePost']);

    // Shorts Posts
    Route::post('save-short-post',[PostShortController::class,'savePost']);
    Route::post('short-post/{id}/edit/status',[PostShortController::class,'savePostStatus']);
    Route::post('short-post/{id}/edit',[PostShortController::class,'editPost']);
    Route::post('short-posts/draw', [PostShortController::class,'allPosts']);
    Route::post('short-posts/{id}/delete', [PostShortController::class,'deletePost']);

    // Events
    Route::post('save-event',[EventController::class,'saveEvent']);
    Route::post('event/{id}/edit',[EventController::class,'editEvent']);
    Route::post('event/{id}/edit/timeline',[EventController::class,'editEventTimeline']);
    Route::post('event/{id}/edit/status',[EventController::class,'saveEventStatus']);
    Route::post('events/draw', [EventController::class,'allEvents']);
    Route::post('events/{id}/delete', [EventController::class,'deleteEvent']);    

    // Working Hours
    Route::get('location/{id}/get-working-hours', [WorkingHoursController::class,'getWorkingHours']);
    Route::post('location/{id}/save-working-hours', [WorkingHoursController::class,'saveWorkingHours']);

    // Organization Events
    Route::post('save-organization-event',[OrganizationEventController::class,'saveOrganizationEvent']);
    Route::post('organization-event/{id}/edit',[OrganizationEventController::class,'editOrganizationEvent']);
    Route::post('organization-event/{id}/edit/timeline',[OrganizationEventController::class,'editOrganizationEventTimeline']);
    Route::post('organization-events/draw', [OrganizationEventController::class,'allOrganiztaionEvents']);
    Route::post('organization-events/{id}/delete', [OrganizationEventController::class,'deleteOrganiztaionEvent']);   
    
});
