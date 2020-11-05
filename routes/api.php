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
    // Customer
    Route::delete('customers', 'Customer\CustomerController@destroySelected');
    Route::post('customers/{customer}/restore', 'Customer\CustomerController@restore');
    Route::post('customers/restore', 'Customer\CustomerController@restoreSelected');
    Route::resource('customers', 'Customer\CustomerController')->except([
        'edit', 'create',
    ]);

    // Customer Contacts
    Route::delete('customers/{customer}/contacts', 'Customer\ContactController@destroySelected');
    Route::post('customers/{customer}/contacts/{user}/restore', 'Customer\ContactController@restore');
    Route::post('customers/{customer}/contacts/restore', 'Customer\ContactController@restoreSelected');
    Route::resource('customers/{customer}/contacts', 'Customer\ContactController')->except([
        'edit', 'create',
    ]);

    // Customer Location
    Route::delete('customers/{customer}/locations', 'Customer\LocationController@destroySelected');
    Route::post('customers/{customer}/locations/{user}/restore', 'Customer\LocationController@restore');
    Route::post('customers/{customer}/locations/restore', 'Customer\LocationController@restoreSelected');
    Route::resource('customers/{customer}/locations', 'Customer\LocationController')->except([
        'edit', 'create',
    ]);

    // Customer Referral Source
    Route::delete('referral-source', 'Customer\ReferralSourceController@destroySelected');
    Route::post('referral-source/{customer}/restore', 'Customer\ReferralSourceController@restore');
    Route::post('referral-source/restore', 'Customer\ReferralSourceController@restoreSelected');
    Route::resource('referral-source', 'Customer\ReferralSourceController')->except([
        'edit', 'create',
    ]);

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

    // Supplier
    Route::delete('suppliers', 'Supplier\SupplierController@destroySelected');
    Route::post('suppliers/{supplier}/restore', 'Supplier\SupplierController@restore');
    Route::post('suppliers/restore', 'Supplier\SupplierController@restoreSelected');
    Route::resource('suppliers', 'Supplier\SupplierController')->except([
        'edit', 'create',
    ]);

    // Supplier Contacts
    Route::delete('suppliers/{supplier}/contacts', 'Supplier\ContactController@destroySelected');
    Route::post('suppliers/{supplier}/contacts/{user}/restore', 'Supplier\ContactController@restore');
    Route::post('suppliers/{supplier}/contacts/restore', 'Supplier\ContactController@restoreSelected');
    Route::resource('suppliers/{supplier}/contacts', 'Supplier\ContactController')->except([
        'edit', 'create',
    ]);

    // Supplier Location
    Route::delete('suppliers/{supplier}/locations', 'Supplier\LocationController@destroySelected');
    Route::post('suppliers/{supplier}/locations/{user}/restore', 'Supplier\LocationController@restore');
    Route::post('suppliers/{supplier}/locations/restore', 'Supplier\LocationController@restoreSelected');
    Route::resource('suppliers/{supplier}/locations', 'Supplier\LocationController')->except([
        'edit', 'create',
    ]);

});

