<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the api routes for the User module
|
|
*/
Route::group([
    'middleware' => 'api',
], function () {
    Route::resource('users', 'Controllers\UserController');
});

// NON AUTHORIZED ROUTES
Route::group([
    'middleware' => 'api',
    'prefix' => 'guest/user',
], function () {
    Route::post('/tokens/create', [AuthenticatedSessionController::class,'createUserToken']);
    Route::post('/login', [AuthenticatedSessionController::class,'login']);
    Route::post('register', [RegisteredUserController::class, 'register']);
    Route::post('/sanctum/token', [AuthenticatedSessionController::class,'getToken']);
    Route::post('activate', 'Controllers\UserController@userActivate');
    Route::post('draw', 'Controllers\UserController@drawUserGuest');
//    Route::get('{id}/get', 'Controllers\UserController@getUserGuest');// TODO this route should probably not be available unless you are logged in
//    Route::post('new', 'Controllers\UserController@storeUserGuest');
//    Route::get('myprofile', 'Controllers\UserController@getMyProfile');// TODO Same issue as above
//    Route::post('myprofile/{id}', 'Controllers\UserController@updateMyProfile');// TODO Same issue as above
//    Route::post('avatar', 'Controllers\UserController@updateMyAvatar');
});

// AUTHORIZED ROUTES
Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'usersanct'
], function (){
    Route::post('/logout', [AuthenticatedSessionController::class ,'logout']); //TODO: Try to move these inside the auth.php route file, test if the api middleware somehow causes problems
    Route::get('/test',[AuthenticatedSessionController::class ,'test']);
    Route::get('/user',[AuthenticatedSessionController::class ,'user']);
});

Route::group([
    'middleware' => ['api','jwt.renew'],
    'prefix' => 'user',
], function () {
    Route::get('all', 'Controllers\UserController@allUsers');
    Route::get('roles/get', 'Controllers\UserController@getUserRoles');
    Route::get('myprofile', 'Controllers\UserController@getMyProfile');
    Route::get('admins/{count}/{search}', 'Controllers\UserController@getAdminsForDropdown');
    Route::get('dropdown/countries', 'Controllers\UserController@getCountriesForDropdown');
    Route::get('shipping_info/get', 'Controllers\UserController@getShippingInfo');
    Route::get('{id}/delete', 'Controllers\UserController@deleteUser');
    Route::get('{id}/get', 'Controllers\UserController@getUser');
    Route::post('shipping_info/edit', 'Controllers\UserController@editShippingInfo');
    Route::post('new', 'Controllers\UserController@storeUser')->middleware('permission:user_write', 'role:administrator');
    Route::post('{id}/edit', 'Controllers\UserController@updateUser')->middleware('permission:user_write', 'role:administrator');
    Route::post('edit/myprofile/{id}', 'Controllers\UserController@updateMyProfile');
    Route::post('draw', 'Controllers\UserController@drawUser');
    Route::post('public/draw', 'Controllers\UserController@drawPublicUser');
    Route::post('public/export', 'Controllers\UserController@exportPublicUser');
    Route::post('public/{id}/delete', 'Controllers\UserController@deleteUser');
    Route::post('export', 'Controllers\UserController@exportAdminUser');
});
