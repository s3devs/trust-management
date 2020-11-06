<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('me', 'AuthController@me');
    });
});
Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::delete('users', 'UserController@destroySelected');
    Route::post('users/{user}/restore', 'UserController@restore');
    Route::post('users/restore', 'UserController@restoreSelected');
    Route::get('users/modules', 'UserController@modules');
    Route::resource('users', 'UserController')->except([
        'edit', 'create',
    ]);

    // Roles
    Route::delete('roles', 'RoleController@destroySelected');
    Route::post('roles/{role}/restore', 'RoleController@restore');
    Route::post('roles/restore', 'RoleController@restoreSelected');
    Route::get('roles/modules', 'RoleController@modules');
    Route::resource('roles', 'RoleController')->except([
        'edit', 'create',
    ]);
});

