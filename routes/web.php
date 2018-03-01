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

Route::get('/', 'Guest\HomeController@index');
Route::get('post', function () {
    return redirect('/');
});

Route::get('post/{blog}', 'Guest\BlogsController@single');
Route::get('category/{category}', 'Guest\BlogsController@category');
Route::post('post/comment', 'Guest\BlogsController@comment');

Route::post('subscribe', 'Guest\HomeController@subscribe');
Route::get('subscribe/verify/{token}', 'Guest\HomeController@subscribeVerify');

Route::get('feed', 'FeedsController@index');

Route::get('auth/verify/{token}', 'Auth\RegisterController@verify');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
