<?php
//
//use Illuminate\Http\Request;
use \App\Applications\Common\Controllers\PostController;
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
    Route::get('{id}/fetch', [PostController::class,'getPostByIdNonAuth']);
    Route::post('allPostsPublic', [PostController::class,'allPostsPublic']);
    Route::get('getCountries', 'Controllers\TaxonomiesController@getCountries');
    Route::get('{id}/getPost', 'Controllers\PostController@getPostById');
});

// Authorized routes
Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'common',
], function () {
    Route::post('save-post',[PostController::class,'savePost']);
    Route::post('post/{id}/edit',[PostController::class,'editPost']);
//   Route::get('index','Controllers\PostController@index');
//   Route::get('getScrolldownPosts', 'Controllers\PostController@getScrolldownPosts');
    Route::post('posts/draw', [PostController::class,'allPosts']);
    Route::post('posts/{id}/delete', [PostController::class,'deletePost']);
//    Route::post('posts/draw', [PostController::class,'allPosts']);
//   Route::get('latestPosts', 'Controllers\PostController@latestPosts'); //function(){ return PostResource::collection(Posts::all());})Route::get('{id}/fetch', 'Controllers\PostController@getPostByIdNonAuth');
});
