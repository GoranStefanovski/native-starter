<?php

use Illuminate\Http\Request;
use App\Applications\User\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| This file contains the API routes for the User module
|
|
*/
Route::group([
    'middleware' => 'api',
], function () {
    Route::resource('users', 'Controllers\UserController');
});

// Non-auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'guest/user',
], function () {
    Route::post('activate', [UserController::class, 'userActivate']);
    Route::post('draw', [UserController::class, 'drawUserGuest']);
    Route::get('{id}/get', [UserController::class, 'getUserGuest']); // TODO this route should probably not be available unless you are logged in
    Route::post('new', [UserController::class, 'storeUserGuest']);
    Route::get('myprofile', [UserController::class, 'getMyProfile']); // TODO Same issue as above
    Route::post('myprofile/{id}', [UserController::class, 'updateMyProfile']); // TODO Same issue as above
    Route::post('avatar', [UserController::class, 'updateMyAvatar']);
});

// Authorized routes
Route::group([
    'middleware' => ['api', 'jwt.renew'],
    'prefix' => 'user',
], function () {
    Route::get('all', [UserController::class, 'allUsers']);
    Route::get('roles/get', [UserController::class, 'getUserRoles']);
    Route::get('myprofile', [UserController::class, 'getMyProfile']);
    Route::get('admins/{count}/{search}', [UserController::class, 'getAdminsForDropdown']);
    Route::get('dropdown/countries', [UserController::class, 'getCountriesForDropdown']);
    Route::get('shipping_info/get', [UserController::class, 'getShippingInfo']);
    Route::get('{id}/delete', [UserController::class, 'deleteUser']);
    Route::get('{id}/get', [UserController::class, 'getUser']);
    Route::post('shipping_info/edit', [UserController::class, 'editShippingInfo']);
    Route::post('new', [UserController::class, 'storeUser'])->middleware('permission:create-users', 'role:administrator');
    Route::post('{id}/edit', [UserController::class, 'updateUser'])->middleware('permission:create-users', 'role:administrator');
    Route::post('edit/myprofile/{id}', [UserController::class, 'updateMyProfile']);
    Route::post('draw', [UserController::class, 'drawUser']);
    Route::post('public/draw', [UserController::class, 'drawPublicUser']);
    Route::post('public/export', [UserController::class, 'exportPublicUser']);
    Route::post('public/{id}/delete', [UserController::class, 'deleteUser']);
    Route::post('export', [UserController::class, 'exportAdminUser']);
});
