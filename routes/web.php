<?php

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

Route::pattern('id','([0-9]*)');
Route::pattern('slug','(.*)');
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('product', 'ProductController@index')->name('api.index');
Route::get('product/{id}', 'ProductController@show')->name('api.show');
Route::put('product/{id}', 'ProductController@update')->name('api.update');
Route::post('product', 'ProductController@store')->name('api.store');
Route::delete('product/{id}', 'ProductController@destroy')->name('api.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
