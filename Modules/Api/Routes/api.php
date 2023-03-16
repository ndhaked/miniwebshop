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

Route::get('orders','ApiController@getOrders');
Route::post('orders/add','ApiController@addOrder');
Route::post('orders/{orderid}/update','ApiController@updateOrder');
Route::delete('orders/{orderid}','ApiController@deleteOrder');

Route::post('orders/{id}/add','ApiController@addProductToOrder');
Route::post('orders/{id}/pay','ApiController@createPayOrder');