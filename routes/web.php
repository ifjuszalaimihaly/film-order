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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/approval', 'HomeController@approval')->name('approval');
    Route::middleware(['approved'])->group(function (){
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/omdbapi', 'FilmAPIController@omdbAPIRequest')->name('omdbapi');
        Route::get('/themoviedbapi', 'FilmAPIController@theMovieDbAPIRequest')->name('themoviedbapi');
    });
});
