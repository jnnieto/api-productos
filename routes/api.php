<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Productos
Route::get('/products', 'App\Http\Controllers\ProductController@index');

Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show');

Route::post('/products', 'App\Http\Controllers\ProductController@store');

Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update');

Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy');


//Usuarios
Route::get('/users', 'App\Http\Controllers\UserController@index');

Route::get('/users/{id}', 'App\Http\Controllers\UserController@show');

Route::post('/users', 'App\Http\Controllers\UserController@store');

Route::put('/users/{id}', 'App\Http\Controllers\UserController@update');

Route::delete('/users/{id}', 'App\Http\Controllers\UserController@destroy');



//Carrito de compras
Route::get('/carts', 'App\Http\Controllers\CartController@index');

Route::post('carts', 'App\Http\Controllers\CartController@store');

Route::delete('/carts/{id}', 'App\Http\Controllers\CartController@destroy');


