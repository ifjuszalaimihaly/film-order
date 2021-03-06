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
    Route::middleware(['approved'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/omdbapi', 'FilmAPIController@omdbAPIRequest')->name('omdbapi');
        Route::get('/themoviedbapi', 'FilmAPIController@theMovieDbAPIRequest')->name('themoviedbapi');
        Route::post('/film-orders','FilmOrderController@store')->name("film-orders.store");
        Route::get('/orders','OrderController@index')->name("orders.index");
    });
});

Route::group(['middleware'=>['admin'],'prefix'=>'admin'], function () {
    Route::get('/approval', 'Admin\ApprovalController@index')->name('admin.approval.index');
    Route::put('/approval/{id}', 'Admin\ApprovalController@update')->name('admin.approval.update');

    Route::get('/order-status', 'Admin\OrderStatusController@index')->name('admin.order-status.index');
    Route::put('/order-status/{id}', 'Admin\OrderStatusController@update')->name('admin.order-status.update');
});
