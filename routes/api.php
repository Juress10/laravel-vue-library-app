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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books','BookController@index');
Route::get('/books/show/{id}','BookController@show');
Route::post('/books/create', 'BookController@create');
Route::put('/books/update', 'BookController@update');
Route::patch('/books/delete', 'BookController@delete');

Route::get('/authors','AuthorController@index');
Route::get('/authors/show/{id}','AuthorController@show');
Route::post('/authors/create', 'AuthorController@create');
Route::put('/authors/update', 'AuthorController@update');
Route::patch('/authors/delete', 'AuthorController@delete');
