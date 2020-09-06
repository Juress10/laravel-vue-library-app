<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.all-books');
});
Route::get('/books', function () {
    return view('pages.all-books');
});
Route::get('/authors', function () {
    return view('pages.all-authors');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
