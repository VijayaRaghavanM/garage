<?php

use Illuminate\Http\Request;

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

//Endpoints that can be accessed by anyone
Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');
 
//Protected endpoints that can only be accessed by logged in Users
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::get('logout', 'PassportController@logout');
/**
 * resource() creates an api endpoints to perform CRUD operations on the Model
 */
    Route::resource('orders', 'OrderController');
    Route::resource('clients', 'ClientController');
    Route::resource('vehicles', 'ClientController');
});